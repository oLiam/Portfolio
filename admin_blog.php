<?php

$content = new TemplatePower("template/admin_blog.html");
$content->prepare();

if(isset($_GET['actie']))
{
    $actie = $_GET['actie'];
}
else
{
    $actie = NULL;
}


if(isset($_SESSION['groepid']))
{
    if($_SESSION['groepid'] == 2){
        switch($actie)
        {
            case "toevoegen_form":

                if(!empty($_SESSION['username'])){
                    $username = $_SESSION['username'];
                }
                else
                {
                    $username = "onbekend";
                }

                $content->newBlock("FORMULIER");
                $content->assign(array(
                    "ACTION" => "index.php?id=6&actie=toevoegen_opvang",
                    "BUTTONNAME" => "Blog Toevoegen",
                    "USERNAME" => $username
                ));
                break;

            case "toevoegen_opvang":
                if(!empty($_POST['titel']) && !empty($_POST['inhoud']))
                {
                    $datum = date("Y-m-d H:i:s",time());
                    $status = 1;

                    $insert_blog = $db->prepare("INSERT INTO blog SET
                        titel = :titel,
                        inhoud = :inhoud,
                        datum = :datum,
                        Gebruikers_idGebruikers = :userid,
                        status_idstatus = :status
                        ");
                    $insert_blog->bindParam(":titel", $_POST['titel']);
                    $insert_blog->bindParam(":inhoud", $_POST['inhoud']);
                    $insert_blog->bindParam(":datum", $datum);
                    $insert_blog->bindParam(":userid", $_SESSION['userid']);
                    $insert_blog->bindParam(":status", $status);
                    $insert_blog->execute();

                    $content->newBlock("SUCCES");
                    $content->assign("MELDING", "De blog is toegevoegd");

                }
                else
                {
                    $content->newBlock("ERROR");
                    $content->assign("MELDING", "Er is geen blog verstuurd via het formulier");
                }

            break;


            case "wijzigen_form":

                if(isset($_GET['blogid']))
                {
                    $checkblog = $db->prepare('SELECT count(*) FROM blog WHERE idBlog = :blogid');
                    $checkblog->bindParam(":blogid", $_GET['blogid']);
                    $checkblog->execute();

                    if($checkblog->fetchColumn() == 1 )
                    {
                        $getblog = $db->prepare("SELECT * FROM blog WHERE idBlog = :blogid ");
                        $getblog->bindParam(":blogid", $_GET['blogid']);
                        $getblog->execute();

                        $blog = $getblog->fetch(PDO::FETCH_ASSOC);

                        $content->newBlock("FORMULIER");
                        $content->assign(array(
                            "ACTION" => "index.php?id=6&actie=wijzigen_opvang",
                            "BUTTONNAME" => "Blog Wijzigen",
                            "TITEL" => $blog['titel'],
                            "INHOUD" => $blog['inhoud'],
                            "BLOGID" => $blog['idBlog']
                        ));
                    }
                    else
                    {
                        $content->newBlock("ERROR");
                        $content->assign("MELDING", "Blog niet gevonden");
                    }
                }
                else
                {
                    $content->newBlock("ERROR");
                    $content->assign("MELDING", "Geen blog geselecteerd");
                }
            break;


            case "wijzigen_opvang":

                if(isset($_POST['blogid']) AND !empty($_POST['titel']) && !empty($_POST['inhoud']))
                {
                    $updateBlog = $db->prepare("UPDATE blog SET titel = :titel, inhoud = :inhoud WHERE idBlog = :idBlog");
                    $updateBlog->bindParam(":titel", $_POST['titel']);
                    $updateBlog->bindParam(":inhoud", $_POST['inhoud']);
                    $updateBlog->bindParam(":idBlog", $_POST['blogid']);
                    $updateBlog->execute();

                    $content->newBlock("SUCCES");
                    $content->assign("MELDING", "De blog is gewijzigd");

                }
                else
                {
                    $content->newBlock("ERROR");
                    $content->assign("MELDING", "Er is wat verkeerd gegaan bij de wijziging");
                }
            break;


            case "verwijder_form";

                if(isset($_GET['blogid']))
                {
                    $check_blog = $db->prepare(" SELECT count(*) FROM blog WHERE idBlog = :idBlog ");
                    $check_blog->bindParam(":idBlog", $_GET['blogid']);
                    $check_blog->execute();


                if ($check_blog->fetchColumn() == 1)
                {
                    $get_gegevens = $db->prepare(" SELECT * FROM blog WHERE idBlog = :idBlog ");
                    $get_gegevens->bindParam(":idBlog", $_GET['blogid']);
                    $get_gegevens->execute();

                    $gegevens = $get_gegevens->fetch(PDO::FETCH_ASSOC);

                    $content->newBlock("VERWIJDERFORM");
                    $content->assign(array(
                        "TITEL" => $gegevens['titel'],
                        "INHOUD" => $gegevens['inhoud'],
                        "BLOGID" => $gegevens['idBlog']
                    ));

                }}
            break;

            case "verwijderen_opvang":

                if(isset($_POST['blogid']))
                {
                    $delete_blog = $db->prepare("
                    DELETE FROM blog
                    WHERE idBlog = :blogid;
                ");
                    $delete_blog->bindParam(":blogid", $_POST['blogid']);
                    $delete_blog->execute();

                    $content->newBlock("SUCCES");
                    $content->assign("MELDING", "Het blog artikel is verwijderd");

                }
                else
                {
                    $content->newBlock("ERROR");
                    $content->assign("MELDING", "Er is wat fout gegaan");
                }
                break;




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

                    $content->newBlock("OVERZICHT");
                    $overzichtOphalen = $db->prepare("
                                    SELECT *
                                    FROM blog
                                    ORDER BY datum DESC ");



                    $overzichtOphalen->execute();
                    $content->newBlock("TABEL");
                    while($overzicht = $overzichtOphalen->fetch(PDO::FETCH_ASSOC)){
                        $content->newBlock("TABELRIJ");
                        $content->assign("TITEL", $overzicht['titel']);
                        $content->assign("INHOUD", substr($overzicht['inhoud'],0, 80));
                        $content->assign("DATUM", $overzicht['datum']);
                        $content->assign("BLOGID", $overzicht['idBlog']);
                    }


            }
        }

        else
        {

            $content->newBlock("ERROR");
            $content->assign("MELDING", "Je hebt geen permissie om in de admin te komen");
        }
    }

    else
    {
        $content->newBlock("ERROR");
        $content->assign("MELDING", "Je bent niet ingelogd");
    }

$content->printToScreen();