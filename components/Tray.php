<?php

class Tray {


    private $map;
    private $icon;
    private $icon2;

    function __construct() {
        session_start();

        if (!isset($_SESSION['map'])) {
            $this->map = [
                [ 2,  3,  4,  5,  6,  4,  3,  2],
                [ 1,  1,  1,  1,  1,  1,  1,  1],
                [ 0,  0,  0,  0,  0,  0,  0,  0],
                [ 0,  0,  0,  0,  0,  0,  0,  0],
                [ 0,  0,  0,  0,  0,  0,  0,  0],
                [ 0,  0,  0,  0,  0,  0,  0,  0],
                [-1, -1, -1, -1, -1, -1, -1, -1],
                [-2, -3, -4, -5, -6, -4, -3, -2]
            ];
            $_SESSION['map']  = $this->map;
        }
        else {
            $this->map = $_SESSION['map'];
        }

        $this->icon = ['<i class="fa-solid fa-chess-pawn"></i>',
            '<i class="fa-solid fa-chess-rook"></i>',
            '<i class="fa-solid fa-chess-knight"></i>',
            '<i class="fa-solid fa-chess-bishop"></i>',
            '<i class="fa-solid fa-chess-queen"></i>',
            '<i class="fa-solid fa-chess-king"></i>'];

        $this->icon2 = ['<i class="fa-solid fa-chess-pawn" onclick="get_possibility(1)"  style="color: #FBFBFC"></i>',
            '<i class="fa-solid fa-chess-rook" onclick="get_possibility(2)" style="color: #FBFBFC"></i>',
            '<i class="fa-solid fa-chess-knight" onclick="get_possibility(3)" style="color: #FBFBFC"></i>',
            '<i class="fa-solid fa-chess-bishop" onclick="get_possibility(4)" style="color: #FBFBFC"></i>',
            '<i class="fa-solid fa-chess-queen" onclick="get_possibility(5)" style="color: #FBFBFC"></i>',
            '<i class="fa-solid fa-chess-king" onclick="get_possibility(6)" style="color: #FBFBFC"></i>'];


    }
        
    function get_map() {
        return $this->map;
    }

    function display_block() {
        echo <<<EOF
<div class="tray">
EOF;
        for ($i = 0 ; $i < 64 ; $i++) {
            echo"<div class='cells' id='".$i."' onclick='go_to(".$i.")'>";
            $this->display_icon($i);
            echo <<<EOF
</div>
EOF;
        }
        echo <<<EOF
</div>
EOF;
    }

    function display_icon($nb) {
        $i = intval($nb /8);
        $j = $nb - ($i * 8);
        if ($this->map[$i][$j] != 0) {
            if ($this->map[$i][$j] < 0) {
                switch ($this->map[$i][$j]) {
                    case -1 :
                        echo '<i class="fa-solid fa-chess-pawn" onclick="get_possibility(1, '.$i.' , '.$j.')"  style="color: #FBFBFC"></i>';
                        break;
                    case -2 :
                        echo '<i class="fa-solid fa-chess-rook" onclick="get_possibility(2, '.$i.' , '.$j.')" style="color: #FBFBFC"></i>';
                        break;
                    case -3 :
                        echo '<i class="fa-solid fa-chess-knight" onclick="get_possibility(3, '.$i.' , '.$j.')" style="color: #FBFBFC"></i>';
                        break;
                    case -4 :
                        echo '<i class="fa-solid fa-chess-bishop" onclick="get_possibility(4, '.$i.' , '.$j.')" style="color: #FBFBFC"></i>';
                        break;
                    case -5:
                        echo '<i class="fa-solid fa-chess-queen" onclick="get_possibility(5, '.$i.' , '.$j.')" style="color: #FBFBFC"></i>';
                        break;
                    case -6 :
                        echo '<i class="fa-solid fa-chess-king" onclick="get_possibility(6, '.$i.' , '.$j.')" style="color: #FBFBFC"></i>';
                        break;
                }
            }
            else {
                echo $this->icon[$this->map[$i][$j] - 1];
            }
        }
    }





}