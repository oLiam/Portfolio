<?php

$content = new TemplatePower("template/project.html");
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
            $check = $db->prepare(" SELECT count(*) FROM projecten ");
            $check->execute();

            if($check->fetchColumn() > 0)
            {

                $content->newBlock("ARCHIEF");
                $getProject = $db->prepare("SELECT * FROM projecten ORDER BY idProjecten DESC LIMIT 25");
                $getProject->execute();

                while($project = $getProject->fetch(PDO::FETCH_ASSOC))
                {
                    $content->newBlock("RIJ");
                    $content->assign(array(
                        "PROJECTID" => $project['idProjecten'],
                        "NAAM" => $project['naam'],
                        "BEGIN" => $project['begin'],
                        "EIND"   => $project['eind'],

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

        if(isset($_GET['projectid']))
            {
                $checkProject = $db->prepare(" SELECT count(*) FROM projecten WHERE idProjecten = :projectid");
                $checkProject->bindParam(":projectid", $_GET['projectid']);
                $checkProject->execute();

                if($checkProject->fetchColumn() == 1)
                {
                    $getProject = $db->prepare("SELECT * FROM projecten WHERE idProjecten = :blogid");
                    $getProject->bindParam(":projectid", $_GET['projectid']);
                }
                else
                {
                    $content->newBlock("ERROR");
                    $content->assign("MELDING", "De blog die je geselecteerd hebt bestaat niet");

                    $getProject = $db->prepare("SELECT * FROM projecten ORDER BY idProjecten DESC LIMIT 10");
                }

            }

                else
                {
                    $getProject = $db->prepare(" SELECT * FROM projecten ORDER BY idProjecten DESC LIMIT 10 ");
                }

                    $getProject->execute();

                    while($project = $getProject->fetch(PDO::FETCH_ASSOC)){

                        $content->newBlock("PROJECT");
                        $content->assign(array(
                            "NAAM" => $project['naam'],
                            "INHOUD" => $project['inhoud'],
                            "BEGIN" => $project['begin'],
                            "EIND"  => $project['eind'],
                            "PROJECTID" => $project['idProjecten']
                        ));
                    }

    }

$content->printToScreen();