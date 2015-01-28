<?php

$content = new TemplatePower("template/blog.html");
$content->prepare();

if(isset($_GET['actie']))
{
    $actie = $_GET['actie'];
}
else
{
    $actie = NULL;
}

switch($actie)
{
    case "archief":
        $check = $db->prepare("SELECT count(*) FROM blog");
        $check->execute();

        if($check->fetchColumn() > 0)
        {

            $content->newBlock("ARCHIEF");
            $getBlog = $db->prepare("SELECT * FROM blog ORDER BY datum DESC LIMIT 25");
            $getBlog->execute();

            while($blog = $getBlog->fetch(PDO::FETCH_ASSOC))
            {
                $content->newBlock("RIJ");
                $content->assign(array(
                    "TITEL" => $blog['titel'],
                    "DATUM" => $blog['datum'],
                    "BLOGID" => $blog['idBlog']

                ));
            }

        }
        else
        {
            $content->newBlock("ERROR");
            $content->assign("MELDING", "Geen blogs gevonden");

        }


        break;


    default:
        if(isset($_GET['blogid']))
        {
            // controleren of blog bestaat
            $checkBlog = $db->prepare("SELECT count(*) FROM blog
            WHERE idBlog = :blogid");
            $checkBlog->bindParam(":blogid", $_GET['blogid']);
            $checkBlog->execute();

            if($checkBlog->fetchColumn() == 1)
            {
                // blog bestaat, laten zien
                $getblog = $db->prepare("SELECT * FROM blog WHERE idBlog = :blogid");
                $getblog->bindParam(":blogid", $_GET['blogid']);
            }
            else
            {
                // melding geven
                $content->newBlock("ERROR");
                $content->assign("MELDING", "De blog die je geselecteerd hebt bestaat niet");

                // nu maar de laatste blog laten zien
                $getblog = $db->prepare("SELECT * FROM blog ORDER BY datum DESC LIMIT 1");
            }

        }
        else
        {
            // laatste blog ophalen
            $getblog = $db->prepare("SELECT * FROM blog
            ORDER BY datum DESC LIMIT 1");

        }

        // heb nu sowieso een $getblog
        $getblog->execute();

        $blog = $getblog->fetch(PDO::FETCH_ASSOC);
        // blog laten zien op de pagina
        $content->newBlock("BLOG");
        $content->assign(array(
            "TITEL" => $blog['titel'],
            "INHOUD" => $blog['inhoud'],
            "DATUM" => $blog['datum'],
            "BLOGID" => $blog['idBlog']
        ));

        // als er een reactie gepost word, dan reactie in db zetten
        if(!empty($_POST['reactie'])
            AND !empty($_POST['blogid'])
            AND !empty($_POST['userid']))
        {
            // reactie formulier is verstuurd, dus melding geven
            $datum = date("Y-m-d H:i:s",time());
            $insert_reactie = $db->prepare("
                INSERT INTO reacties SET
                  inhoud = :inhoud,
                  datum = :datum,
                  Gebruikers_idGebruikers = :userid,
                  Blog_idBlog = :blogid
            ");
            $insert_reactie->bindParam(":inhoud", $_POST['reactie']);
            $insert_reactie->bindParam(":datum", $datum);
            $insert_reactie->bindParam(":userid", $_POST['userid']);
            $insert_reactie->bindParam(":blogid", $_POST['blogid']);
            $insert_reactie->execute();

            $content->newBlock("REACTIE_SUCCES");
            $content->assign("MELDING", "Reactie is geplaatst");
            $content->assign("ACTION", $_SERVER["REQUEST_URI"] );


        }
        else
        {
            // geen reactie gegeven, dus formulier laten zien
            if(isset($_SESSION['userid']))
            {
                // is ingelogd, dus form weergeven
                $content->newBlock("FORMULIER");
                $content->assign(array(
                    "ACTION" => $_SERVER["REQUEST_URI"],
                    "USERID" => $_SESSION['userid'],
                    "USERNAME" => $_SESSION['username'],
                    "BLOGID" => $blog['idBlog']
                ));
            }
            else
            {
                // melding geven dat je moet registeren / inloggen
                $content->newBlock("REACTIE_WARNING");
                $content->assign("MELDING", "Om een reactie te geven moet je ingelogd zijn.
                <a href='index.php?id=3'>Login</a> of <a href='index.php?id=2'>registreer</a>.");

            }
        }


        // laatste 5 reacties zien
        $check_reacties = $db->prepare("SELECT count(*) FROM reacties WHERE Blog_idBlog = :blogid");
        $check_reacties->bindParam(":blogid", $blog['idBlog'] );
        $check_reacties->execute();

        if($check_reacties->fetchColumn() > 0)
        {
            // reacties gevonden, dus laten zien

            $getReactie = $db->prepare("SELECT r.*, g.username
                  FROM reacties r, gebruikers g
                  WHERE r.Blog_idBlog = :blogid
                AND r.Gebruikers_idGebruikers = g.idGebruikers
                ORDER BY r.datum DESC LIMIT 5");
            $getReactie->bindParam(":blogid", $blog['idBlog'] );
            $getReactie->execute();

            // kunnen meerdere zijn, dus wel een loop gebruiken
            while($reacties = $getReactie->fetch(PDO::FETCH_ASSOC))
            {
                // per rij uitprinten
                $content->newBlock("REACTIES");
                $content->assign(array(
                    "INHOUD" => $reacties['inhoud'],
                    "DATUM" => $reacties['datum'],
                    "USERNAME" => $reacties['username']
                ));

            }



        }
        else
        {
            // geen reacties, dus melding geen reacties
            $content->newBlock("REACTIE_WARNING");
            $content->assign("MELDING", "Nog geen reacties");
        }


}

$content->printToScreen();