<?php

class Possibility {
    private $map;
    private $all_map;

    function __construct($map) {
        $this->map = $map;
        $this->all_map = [];
    }

    function simple_movement($lst_pos,$i,$j,$nb) {
        for ($l = 0 ; $l < count($lst_pos) ; $l++) {
            for ($k = 0; $k < 8; $k++) {
                if ($i + ($k * $lst_pos[$l][0] >= 0 && $j + ($k * $lst_pos[$l][1] ) >= 0) && $i + ($k * $lst_pos[$l][0] < 8 && $j + ($k * $lst_pos[$l][1] ) < 8)) {
                    $temp = $this->map;
                    $temp[$i + ($k * $lst_pos[$l][0])][$j + ($k * $lst_pos[$l][1])] = $nb;
                    $temp[$i][$j] = 0;
                    if ($this->map[$i + $k][$j + $k] === 0) {
                        $this->all_map[] = $temp;
                    } else if ($this->map[$i + $k][$j + $k] < 0) {
                        $this->all_map[] = $temp;
                        break;
                    } else {
                        break;
                    }
                }
            }
        }
    }

    function get_possibility_for_ia() {
        for ($i = 0 ; $i < count($this->map) ; $i++) {
            for ($j = 0 ; $j < count($this->map[$i]) ; $j++) {
                switch ($this->map[$i][$j]) {
                    case 1 :
                        /* PAWN */
                        if ($this->map[$i+1][$j] === 0) {
                            if ($i === 6) {
                                /* PAWN BECOMES QUEEN */
                                $temp = $this->map;
                                $temp[$i+1][$j] = 5;
                                $temp[$i][$j] = 0;
                                $this->all_map[] = $temp;
                            }
                            /* PAWN NOIRE MOVE ONE */
                            $temp = $this->map;
                            $temp[$i+1][$j] = 1;
                            $temp[$i][$j] = 0;
                            $this->all_map[] = $temp;
                            if ($i === 1) {
                                /* PAWN NOIRE MOVE TWO */
                                if ($this->map[$i+2][$j] === 0) {
                                    $temp = $this->map;
                                    $temp[$i + 2][$j] = 1;
                                    $temp[$i][$j] = 0;
                                    $this->all_map[] = $temp;
                                }
                            }
                        }

                        if ($this->map[$i+1][$j+1] < 0) {
                            /* PAWN ATTACK 1 */
                            $temp = $this->map;
                            $temp[$i+1][$j+1] = 1;
                            $temp[$i][$j] = 0;
                            $this->all_map[] = $temp;
                        }
                        if ($this->map[$i+1][$j-1] < 0) {
                            /* PAWN ATTACK 2 */
                            $temp = $this->map;
                            $temp[$i+1][$j-1] = 1;
                            $temp[$i][$j] = 0;
                            $this->all_map[] = $temp;
                        }
                        break;
                    case 2 :
                        /* TOWER */
                        $lst_pos = [[1,0],[-1,0],[0,1],[-1,0]];
                        $this->simple_movement($lst_pos,$i,$j,2);
                        break;
                    case 3 :
                        /* KNIGHT */
                        $lst_pos = [
                            [$i+1,$j+2],
                            [$i+2,$j+1],
                            [$i-1,$j-2],
                            [$i-2,$j-1],
                            [$i-1,$j+2],
                            [$i-2,$j+1],
                            [$i+1,$j-2],
                            [$i+2,$j-1]
                        ];
                        for ($k = 0 ; $k < count($lst_pos) ; $k++) {
                            if ($lst_pos[$k][0] >= 0 && $lst_pos[$k][0] < 8 && $lst_pos[$k][1] >= 0 && $lst_pos[$k][1] < 8 ) {
                                $temp = $this->map;
                                $temp[$lst_pos[$k][0]][$lst_pos[$k][1]] = 3;
                                $temp[$i][$j] = 0;
                                $this->all_map[] = $temp;
                            }
                        }
                        break;
                    case 4 :
                        /* Bishop */
                        $lst_pos = [[1,1],[-1,1],[-1,-1],[1,-1]];
                        $this->simple_movement($lst_pos,$i,$j,4);
                        break;
                    case 5:
                        /* Queen */
                        $lst_pos = [[1,1],[-1,1],[-1,-1],[1,-1],[1,0],[-1,0],[0,1],[-1,0]];
                        $this->simple_movement($lst_pos,$i,$j,5);
                        break;
                    
                }
            }
        }
        return $this->all_map;
    }
}