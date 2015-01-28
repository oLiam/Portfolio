<?php

try{
    $db = new PDO('mysql:host=localhost;dbname=portfolio',
        'root', '');

    $db->setAttribute(PDO::ATTR_ERRMODE,
        PDO::ERRMODE_WARNING);
}

catch (PDOException $error)
{
    $template->newBlock("SQLERROR");
    $template->assign(array(
        "GETLINE" => $error->getLine(),
        "GETFILE" => $error->getFile(),
        "GETMESSAGE" => $error->getMessage()
    ));
}