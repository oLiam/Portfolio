<?php

$content = new TemplatePower("template/logout.html");
$content->prepare();


$_SESSION['userid'] = "";
$_SESSION['groepid'] = "";
$_SESSION['username'] = "";

unset($_SESSION['userid']);
unset($_SESSION['groepid']);
unset($_SESSION['username']);

$content->newBlock("SUCCES");
$content->assign("MELDING", "Je bent nu uitgelogd");

header( "refresh:3;url=index.php" );

$content->printToScreen();