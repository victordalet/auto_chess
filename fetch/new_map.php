<?php


include "../components/Tray.php";
include "../module/Possibility.php";
session_start();

if (isset($_POST)) {
    $data = file_get_contents("php://input");
    $json = json_decode($data,true);
}

$cases = $json['cases'];

$_SESSION['map'][$cases/8][$cases%8] = -$_SESSION['selected'];
$_SESSION['map'][$_SESSION['i']][$_SESSION['j']] = 0;

$p = new Possibility($_SESSION['map']);
if (count($p->get_possibility_for_ia()) !== 0) {
    $random_number = array_rand($p->get_possibility_for_ia());
    $_SESSION['map'] = $p->get_possibility_for_ia()[$random_number];
}
else {
    $_SESSION['map'] = [
        [2, 3, 4, 5, 6, 4, 3, 2],
        [1, 1, 1, 1, 1, 1, 1, 1],
        [0, 0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0, 0],
        [-1, -1, -1, -1, -1, -1, -1, -1],
        [-2, -3, -4, -5, -6, -4, -3, -2]
    ];
}


$tray = new Tray();
$tray->display_block();
