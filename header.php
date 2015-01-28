<?php

// Hier laad ik de header.html in

$header = new TemplatePower("template/header.html");
$header->prepare();


if(isset($_GET['id']))
{
    if($_GET['id'] == 1)
    {
        $header->newBlock("WELKOM");
    }
}
else
{
    $header->newBlock("WELKOM");
}

if(isset($_SESSION['groepid']))
{
    $header->newBlock("INGELOGD");
    if($_SESSION['groepid'] == 2)
    {
        $header->newBlock("ADMIN");
    }
}
else
{
    $header->newBlock("UITGELOGD");
}