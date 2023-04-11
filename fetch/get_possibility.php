<?php


include "../module/Possibility.php";


if (isset($_POST)) {
    $data = file_get_contents("php://input");
    $json = json_decode($data,true);
}

$piece = $json['pieces'];

$p = new Possibility(
    array(
    [2,3,4,5,6,4,3,2],
    [1,1,1,1,1,1,1,1],
    [0,0,0,0,0,0,0,0],
    [0,0,0,0,0,0,0,0],
    [0,0,0,0,0,0,0,0],
    [0,0,0,0,0,0,0,0],
    [-1,-1,-1,-1,-1,-1,-1,-1],
    [-2,-3,-4,-5,-6,-4,-3,-2]
    ));
echo $p->get_possibility_by_piece($piece);

