<?php


include "components/Structure.php";
include "components/Score.php";
include "components/Tray.php";
include "module/Possibility.php";


$TITLE = "CHESS";


$struct = new Structure($TITLE);
$score = new Score();
$tray = new Tray();
$p = new Possibility($tray->get_map());

$p->get_possibility_for_ia();


$struct->head();
$tray->display_block();
$struct->footer();


