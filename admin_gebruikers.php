<?php


$content = new TemplatePower("template/admin_gebruikers.html");
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
                $content->newBlock("FORMULIER");
                break;

            case "toevoegen_opvang":
                if(!empty($_POST['username']) AND !empty($_POST['password1']) AND !empty($_POST['password2'])
                    AND !empty($_POST['email']) AND !empty($_POST['naam']) AND !empty($_POST['geb_datum']))
                {


                    if($_POST['password1'] == $_POST['password2'])
                    {

                        try{
                            $insert_gebruiker = $db->prepare("INSERT INTO gebruikers SET
                            naam = :naam,
                            username = :username,
                            password = :password,
                            email = :email,
                            Groep_idGroep = :groep,
                            geb_datum = :datum,
                            beschrijving = :beschrijving");

                            $insert_gebruiker->bindParam(":naam", $_POST['naam']);
                            $insert_gebruiker->bindParam(":username", $_POST['username']);
                            $password = sha1($_POST['password1']);
                            $insert_gebruiker->bindParam(":password", $password);
                            $insert_gebruiker->bindParam(":email", $_POST['email']);
                            $groep = 1;
                            $insert_gebruiker->bindParam(":groep", $groep);
                            $datum = strtotime($_POST['geb_datum']);
                            $insert_gebruiker->bindParam(":datum", $datum);
                            $insert_gebruiker->bindParam(":beschrijving", $_POST['beschrijving']);
                            $insert_gebruiker->execute();

                            $content->newBlock("SUCCES");
                            $content->assign("MELDING", "De gebruiker is geregistreerd");
                        }catch (PDOException $error)
                        {

                            $template->newBlock("ERROR");
                            $template->assign(array(
                                "MELDING" => $error->getLine()."<br>".
                                    $error->getFile()."<br>".
                                    $error->getMessage()
                            ));

                        }
                    }
                    else
                    {
                        $content->newBlock("ERROR");
                        $content->assign("MELDING", "Het wachtwoord komt niet overeen");

                    }
                }
                else
                {
                    $content->newBlock("FORMULIER");


                }
                break;


                case "wijzigen_form":

                    if(isset($_GET['gebrid']))
                    {
                        $check_gebruiker = $db->prepare(" SELECT count(*) FROM gebruikers WHERE idGebruikers = :gebruikersid ");
                        $check_gebruiker->bindParam(":gebruikersid", $_GET['gebrid']);
                        $check_gebruiker->execute();


                        if($check_gebruiker->fetchColumn() == 1)
                        {
                            $get_gegevens = $db->prepare(" SELECT * FROM gebruikers WHERE idGebruikers = :gebruikersid ");
                            $get_gegevens->bindParam(":gebruikersid", $_GET['gebrid']);
                            $get_gegevens->execute();

                            $gegevens = $get_gegevens->fetch(PDO::FETCH_ASSOC);

                            $content->newBlock("WIJZIGFORM");
                            $content->assign(array(
                                "NAAM" => $gegevens['naam'],
                                "USERNAME" => $gegevens['username'],
                                "EMAIL" => $gegevens['email'],
                                "BESCHRIJVING" => $gegevens['beschrijving'],
                                "GEBRUIKERSID" => $gegevens['idGebruikers']
                            ));
                        }

                    }
                    else
                    {
                        $content->newBlock("ERROR");
                        $content->assign("MELDING", "Geen gebruiker gekozen");

                    }


                break;


                case "wijzigen_opvang":
                    if(!empty($_POST['username']) AND
                        !empty($_POST['naam']) AND
                        !empty($_POST['email']))
                    {
                        $updateGebruiker = $db->prepare("
                       UPDATE gebruikers SET
                       naam = :naam,
                       username = :username,
                       email = :email,
                       beschrijving = :beschrijving
                       WHERE idGebruikers = :gebruikersid
               ");
                        $updateGebruiker->bindParam(":naam", $_POST['naam']);
                        $updateGebruiker->bindParam(":username", $_POST['username']);
                        $updateGebruiker->bindParam(":email", $_POST['email']);
                        $updateGebruiker->bindParam(":beschrijving", $_POST['beschrijving']);
                        $updateGebruiker->bindParam(":gebruikersid", $_POST['gebruikerid']);
                        $updateGebruiker->execute();

                        $content->newBlock("SUCCES");
                        $content->assign("MELDING", "De gebruiker is gewijzigd");
                    }
                    else{
                        $content->newBlock("ERROR");
                        $content->assign("MELDING", "Alle velden moeten zijn ingevuld.");
                    }

                break;


                case "verwijderen_form":

                    if(isset($_GET['gebrid']))
                    {
                        $check_gebruiker = $db->prepare(" SELECT count(*) FROM gebruikers WHERE idGebruikers = :gebruikersid ");
                        $check_gebruiker->bindParam(":gebruikersid", $_GET['gebrid']);
                        $check_gebruiker->execute();


                        if($check_gebruiker->fetchColumn() == 1)
                        {
                            $get_gegevens = $db->prepare(" SELECT * FROM gebruikers WHERE idGebruikers = :gebruikersid ");
                            $get_gegevens->bindParam(":gebruikersid", $_GET['gebrid']);
                            $get_gegevens->execute();

                            $gegevens = $get_gegevens->fetch(PDO::FETCH_ASSOC);

                            $content->newBlock("VERWIJDERFORM");
                            $content->assign(array(
                                "NAAM" => $gegevens['naam'],
                                "USERNAME" => $gegevens['username'],
                                "EMAIL" => $gegevens['email'],
                                "BESCHRIJVING" => $gegevens['beschrijving'],
                                "GEBRUIKERSID" => $gegevens['idGebruikers']
                            ));
                        }

                    }
                    else
                    {
                        $content->newBlock("ERROR");
                        $content->assign("MELDING", "Geen gebruiker gekozen");

                    }
                    break;


                case "verwijderen_opvang":

                    if(isset($_POST['gebruikerid']))
                    {
                        $delete_gebruiker = $db->prepare("
                    DELETE FROM gebruikers
                    WHERE idGebruikers = :gebruikersid;
                ");
                        $delete_gebruiker->bindParam(":gebruikersid", $_POST['gebruikerid']);
                        $delete_gebruiker->execute();

                        $content->newBlock("SUCCES");
                        $content->assign("MELDING", "De gebruiker is verwijderd");

                    }
                    else
                    {
                        $content->newBlock("ERROR");
                        $content->assign("MELDING", "Er is wat fout gegaan");
                    }
                    break;


                    default:
                            $content->newBlock("OVERZICHT");
                            $overzichtOphalen = $db->prepare("
                                SELECT *
                                FROM gebruikers
                                ORDER BY idGebruikers ASC ");

                            $overzichtOphalen->execute();
                            $content->newBlock("TABEL");
                            while($overzicht = $overzichtOphalen->fetch(PDO::FETCH_ASSOC)){
                                $content->newBlock("TABELRIJ");
                                $content->assign("GEBRUIKER", $overzicht['idGebruikers']);
                                $content->assign("USERNAME", $overzicht['username']);
                                $content->assign("NAAM", $overzicht['naam']);
                                $content->assign("GROEP", $overzicht['Groep_idGroep']);
                            }
                        }


}

}

$content->printToScreen();