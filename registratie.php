<?php

$content = new TemplatePower("template/registratie.html");
$content->prepare();


if(!empty($_POST['username']) AND !empty($_POST['password1']) AND !empty($_POST['password2'])
    AND !empty($_POST['email']) AND !empty($_POST['naam']) AND !empty($_POST['geb_datum']))
{
    // in ieder geval is username en password1 + 2 verstuurd (en ingevuld)

    if($_POST['password1'] == $_POST['password2'])
    {
        //print_r($_POST);
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
            $content->assign("MELDING", "The user is registered");
        }catch (PDOException $error)
        {

            $template->newBlock("SQLERROR");
            $template->assign(array(
                "GETLINE" => $error->getLine(),
                "GETFILE" => $error->getFile(),
                "GETMESSAGE" => $error->getMessage()
            ));

        }
    }
    else
    {
        $content->newBlock("ERROR");
        $content->assign("MELDING", "The password does not match");

    }
}
else
{
    $content->newBlock("FORMULIER");
}

$content->printToScreen();
