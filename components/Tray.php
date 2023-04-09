<?php

class Tray {


    private $map;
    private $icon;
    private $icon2;

    function __construct() {

        $this->map = [
            [2,3,4,5,6,4,3,2],
            [1,1,1,1,1,1,1,1],
            [0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [-1,-1,-1,-1,-1,-1,-1,-1],
            [-2,-3,-4,-5,-6,-4,-3,-2]
        ];

        $this->icon = ['<i class="fa-solid fa-chess-pawn"></i>',
            '<i class="fa-solid fa-chess-rook"></i>',
            '<i class="fa-solid fa-chess-knight"></i>',
            '<i class="fa-solid fa-chess-bishop"></i>',
            '<i class="fa-solid fa-chess-queen"></i>',
            '<i class="fa-solid fa-chess-king"></i>'];

        $this->icon2 = ['<i class="fa-solid fa-chess-pawn" style="color: #FBFBFC"></i>',
            '<i class="fa-solid fa-chess-rook" style="color: #FBFBFC"></i>',
            '<i class="fa-solid fa-chess-knight" style="color: #FBFBFC"></i>',
            '<i class="fa-solid fa-chess-bishop" style="color: #FBFBFC"></i>',
            '<i class="fa-solid fa-chess-queen" style="color: #FBFBFC"></i>',
            '<i class="fa-solid fa-chess-king" style="color: #FBFBFC"></i>'];


    }

    function display_block() {
        echo <<<EOF
<div class="tray">
EOF;
        for ($i = 0 ; $i < 64 ; $i++) {
            echo <<<EOF
<div class="cells"></div>
EOF;
        }
        echo <<<EOF
</div>
EOF;
    }

    function display_icon() {
        for ($i = 0 ; $i < count($this->map) ; $i++) {
            for ($j=0 ; $j < count($this->map) ; $j++) {
                if ($this->map[$i][$j] != 0) {
                    if ($this->map[$i][$j] < 0) {
                        echo $this->icon2[-($this->map[$i][$j]) - 1];
                    }
                    else {
                        echo $this->icon[$this->map[$i][$j] - 1];
                    }
                }
            }
        }
    }



}