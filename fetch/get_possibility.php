<?php

session_start();

include "../module/Possibility.php";


if (isset($_POST)) {
    $data = file_get_contents("php://input");
    $json = json_decode($data,true);
}

$piece = $json['pieces'];
$i = $json['i'];
$j = $json['j'];

$_SESSION['i'] = $i;
$_SESSION['j'] = $j;
$_SESSION['selected'] = $piece;

$p = new Possibility($_SESSION['map']);
echo $p->get_possibility_by_piece($piece,$i,$j);

