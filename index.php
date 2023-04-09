<?php


include "components/Structure.php";
include "components/Score.php";
include "components/Tray.php";


$TITLE = "CHESS";


$struct = new Structure($TITLE);
$score = new Score();
$tray = new Tray();


$struct->head();
$tray->display_block();
$tray->display_icon();
$struct->footer();


