<?php


$content = new TemplatePower("template/admin_project.html");
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
                    $content->newBlock("TOEVOEGFORM");
                    $content->assign("GEBRUIKERSID", $_SESSION['userid']);
                break;


                case "toevoegen_opvang":
                    if(!empty($_POST['naam']) && !empty($_POST['inhoud']))
                    {

                        $insert_project = $db->prepare("INSERT INTO projecten SET
                            naam = :naam,
                            inhoud = :inhoud,
                            startdate = :startdate,
                            enddate = :enddate,
                            gebruikers_idGebruikers = :gebruikersid ");
                        $insert_project->bindParam(":naam", $_POST['naam']);
                        $insert_project->bindParam(":inhoud", $_POST['inhoud']);
                        $insert_project->bindParam(":startdate", $_POST['startdate']);
                        $insert_project->bindParam(":enddate", $_POST['enddate']);
                        $insert_project->bindParam(":gebruikersid", $_POST['gebruikersid']);
                        $insert_project->execute();

                        $content->newBlock("SUCCES");
                        $content->assign("MELDING", "Het project is toegevoegd");

                    }
                    else
                    {
                        $content->newBlock("ERROR");
                        $content->assign("MELDING", "Er is geen project verstuurd via het formulier");
                    }

                break;

            case "wijzigen_form":

                if(isset($_GET['projectid']))
                {
                    $check_project = $db->prepare(" SELECT count(*) FROM projecten WHERE idProjecten = :projectid ");
                    $check_project->bindParam(":projectid", $_GET['projectid']);
                    $check_project->execute();


                    if($check_project->fetchColumn() == 1)
                    {
                        $get_gegevens = $db->prepare(" SELECT * FROM projecten WHERE idProjecten = :projectid ");
                        $get_gegevens->bindParam(":projectid", $_GET['projectid']);
                        $get_gegevens->execute();

                        $gegevens = $get_gegevens->fetch(PDO::FETCH_ASSOC);

                        $content->newBlock("WIJZIGFORM");
                        $content->assign(array(
                            "NAAM" => $gegevens['naam'],
                            "INHOUD" => $gegevens['inhoud'],
                            "STARTDATE" => $gegevens['startdate'],
                            "ENDDATE" => $gegevens['enddate'],
                            "PROJECTID" => $gegevens['idProjecten']
                        ));
                    }

                }
                else
                {
                    $content->newBlock("ERROR");
                    $content->assign("MELDING", "Geen project gekozen");

                }


                break;


                case "wijzigen_opvang":
                    if(!empty($_POST['naam']) AND
                        !empty($_POST['inhoud']) AND
                        !empty($_POST['startdate']) AND
                        !empty($_POST['enddate']))
                    {

                        $updateProject = $db->prepare("
                           UPDATE projecten SET
                           naam = :naam,
                           inhoud = :inhoud,
                           startdate = :startdate,
                           enddate = :enddate
                           WHERE idProjecten = :projectenid
                   ");
                    $updateProject->bindParam(":naam", $_POST['naam']);
                    $updateProject->bindParam(":inhoud", $_POST['inhoud']);
                    $updateProject->bindParam(":startdate", $_POST['startdate']);
                    $updateProject->bindParam(":enddate", $_POST['enddate']);
                    $updateProject->bindParam(":projectenid", $_POST['projectid']);
                    $updateProject->execute();

                    $content->newBlock("SUCCES");
                    $content->assign("MELDING", "Het project is gewijzigd");
                }
                else{
                    $content->newBlock("ERROR");
                    $content->assign("MELDING", "Alle velden moeten zijn ingevuld.");
                }

                break;


            case "verwijder_form";
                if(isset($_GET['projectid']))
                {
                    $check_project = $db->prepare(" SELECT count(*) FROM projecten WHERE idProjecten = :projectid ");
                    $check_project->bindParam(":projectid", $_GET['projectid']);
                    $check_project->execute();


                    if ($check_project->fetchColumn() == 1)
                    {
                        $get_gegevens = $db->prepare(" SELECT * FROM projecten WHERE idProjecten = :projectid ");
                        $get_gegevens->bindParam(":projectid", $_GET['projectid']);
                        $get_gegevens->execute();

                        $gegevens = $get_gegevens->fetch(PDO::FETCH_ASSOC);

                        $content->newBlock("VERWIJDERFORM");
                        $content->assign(array(
                            "NAAM" => $gegevens['naam'],
                            "INHOUD" => $gegevens['inhoud'],
                            "PROJECTID" => $gegevens['idProjecten']
                        ));

                    }}
                break;

            case "verwijderen_opvang":

                if(isset($_POST['projectid']))
                {
                    $delete_project = $db->prepare("
                    DELETE FROM projecten
                    WHERE idProjecten = :projectid;
                ");
                    $delete_project->bindParam(":projectid", $_POST['projectid']);
                    $delete_project->execute();

                    $content->newBlock("SUCCES");
                    $content->assign("MELDING", "Het project is verwijderd");

                }
                else
                {
                    $content->newBlock("ERROR");
                    $content->assign("MELDING", "Er is wat fout gegaan");
                }
                break;


            case "archief":
                    $check = $db->prepare(" SELECT count(*) FROM projecten ");
                    $check->execute();

                    if($check->fetchColumn() > 0)
                    {

                        $content->newBlock("ARCHIEF");
                        $getProject = $db->prepare("SELECT * FROM projecten ORDER BY idProjecten ASC LIMIT 25");
                        $getProject->execute();

                        while($project = $getProject->fetch(PDO::FETCH_ASSOC))
                        {
                            $content->newBlock("RIJ");
                            $content->assign(array(
                                "PROJECTID" => $project['idProjecten'],
                                "NAAM" => $project['naam'],
                                "STARTDATE" => $project['startdate'],
                                "ENDDATE"   => $project['enddate'],

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
                                    FROM projecten
                                    ORDER BY idProjecten ASC ");

                    $overzichtOphalen->execute();
                    $content->newBlock("TABEL");
                    while($overzicht = $overzichtOphalen->fetch(PDO::FETCH_ASSOC)){
                        $content->newBlock("TABELRIJ");
                        $content->assign("NAAM", $overzicht['naam']);
                        $content->assign("STARTDATE", $overzicht['startdate']);
                        $content->assign("ENDDATE", $overzicht['enddate']);
                        $content->assign("PROJECTID", $overzicht['idProjecten']);
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

