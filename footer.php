<?php
// inladen van footer.html
$footer = new TemplatePower("template/footer.html");
$footer->prepare();










// Op het einde van de code zorg ik ervoor dat alles uit word geprint
$header->printToScreen();
//$content->printToScreen();
$footer->printToScreen();