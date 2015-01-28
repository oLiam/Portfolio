<?php

$content = new TemplatePower("template/login.html");
$content->prepare();

if(isset($_POST['login'])
    AND !empty($_POST['username'])
    AND !empty($_POST['password']))
{
    // controle
    $check_result = $db->prepare("
        SELECT count(*) FROM gebruikers
        WHERE username = :gebruikersnaam
        AND password = :wachtwoord
    ");
    $check_result->bindParam(":gebruikersnaam", $_POST['username']);
    $wachtwoord = sha1($_POST['password']);
    $check_result->bindParam(":wachtwoord", $wachtwoord);
    $check_result->execute();

    // controle doen: heb ik 1 gebruiker (1 rij) met de username & password
    if($check_result->fetchColumn() == 1)
    {
        // er is een match

        $get_info = $db->prepare("
            SELECT * FROM gebruikers WHERE username = :gebruikersnaam AND password = :wachtwoord
        ");
        $get_info->bindParam(":gebruikersnaam", $_POST['username']);
        $get_info->bindParam(":wachtwoord", $wachtwoord);
        $get_info->execute();

        $info = $get_info->fetch(PDO::FETCH_ASSOC);
        //print_r($info);
        $_SESSION['userid'] = $info['idGebruikers'];
        $_SESSION['groepid'] = $info['Groep_idGroep'];
        $_SESSION['username'] = $info['username'];

        $content->newBlock("SUCCES");
        $content->assign("MELDING", "Je bent nu ingelogd");


    }
    else
    {
        // geen match gevonden
        $content->newBlock("ERROR");
        $content->assign("MELDING", "Combination username & password doesn't exists");

        $content->newBlock("FORMULIER");
        $content->assign("USERNAME", $_POST['username']);
    }
}
else
{
    // heb ik op de knop login gedrukt?
    if(isset($_POST['login'])){
        $content->newBlock("ERROR");
        $content->assign("MELDING", "You did not enter a username and / or password");
    }

    // formulier
    $content->newBlock("FORMULIER");
    if(!empty($_POST['username']))
    {
        $content->assign("USERNAME", $_POST['username']);
    }

}



$content->printToScreen();