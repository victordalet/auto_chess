<?php

class Possibility {
    private $map;
    private $all_map;

    function __construct($map) {
        $this->map = $map;
        $this->all_map = [];
    }

    function is_in_check($map) {

        /* King position */

        $row = $col = -1;
        for ($i = 0; $i < 8; $i++) {
            for ($j = 0; $j < 8; $j++) {
                if ($map[$i][$j] == 6) {
                    $row = $i;
                    $col = $j;
                    break 2;
                }
            }
        }

        /* Col */

        for ($i = 0; $i < 8; $i++) {
            if ($map[$row][$i] != 0) {
                if ($map[$row][$i] < 0) {
                    return true;
                }
                break;
            }
        }

        for ($i = 0; $i < 8; $i++) {
            if ($map[$i][$col] != 0) {
                if ($map[$i][$col] < 0) {
                    return true;
                }
                break;
            }
        }

        /* Diag */

        $diagonals = [
            [$row-1, $col-1], [$row-1, $col+1],
            [$row+1, $col-1], [$row+1, $col+1]
        ];
        foreach ($diagonals as $diag) {
            $i = $diag[0];
            $j = $diag[1];
            while ($i >= 0 && $i < 8 && $j >= 0 && $j < 8) {
                if ($map[$i][$j] != 0) {
                    if ($map[$i][$j] < 0) {
                        return true;
                    } else {
                        break;
                    }
                }
                $i += $diag[0] - $row;
                $j += $diag[1] - $col;
            }
        }

        /* Knight */

        $knight_moves = [
            [$row-2, $col-1], [$row-2, $col+1],
            [$row-1, $col-2], [$row-1, $col+2],
            [$row+1, $col-2], [$row+1, $col+2],
            [$row+2, $col-1], [$row+2, $col+1]
        ];
        foreach ($knight_moves as $move) {
            $i = $move[0];
            $j = $move[1];
            if ($i >= 0 && $i < 8 && $j >= 0 && $j < 8 && $map[$i][$j] === -3) {
                return true;
            }
        }

        return false;
    }


    function simple_movement($lst_pos,$i,$j,$nb,$nb_k) {
        for ($l = 0 ; $l < count($lst_pos) ; $l++) {
            for ($k = 0; $k < $nb_k; $k++) {
                if ($i + ($k * $lst_pos[$l][0] >= 0 && $j + ($k * $lst_pos[$l][1] ) >= 0) && $i + ($k * $lst_pos[$l][0] < 8 && $j + ($k * $lst_pos[$l][1] ) < 8)) {
                    $temp = $this->map;
                    $temp[$i + ($k * $lst_pos[$l][0])][$j + ($k * $lst_pos[$l][1])] = $nb;
                    $temp[$i][$j] = 0;
                    /* MOVEMENT */
                    if ($this->map[$i + $k][$j + $k] === 0) {
                        if (!$this->is_in_check($this->map)) {
                            $this->all_map[] = $temp;
                        }
                        else {
                            if (!$this->is_in_check($temp)) {
                                $this->all_map[] = $temp;
                            }
                        }
                    }
                    /* ATTACK */
                    else if ($this->map[$i + $k][$j + $k] < 0) {
                        if (!$this->is_in_check($this->map)) {
                            $this->all_map[] = $temp;
                        }
                        else {
                            if (!$this->is_in_check($temp)) {
                                $this->all_map[] = $temp;
                            }
                        }
                        break;
                    }
                    /* US */
                    else {
                        break;
                    }
                }
            }
        }
    }
    function simple_movement_to_str($lst_pos,$i,$j,$nb,$nb_k) {
        $data = "";
        for ($l = 0 ; $l < count($lst_pos) ; $l++) {
            for ($k = 1; $k < $nb_k; $k++) {
                if ($i + ($k * $lst_pos[$l][0] >= 0 && $j + ($k * $lst_pos[$l][1] ) >= 0) && $i + ($k * $lst_pos[$l][0] < 8 && $j + ($k * $lst_pos[$l][1] ) < 8)) {
                    $temp = $this->map;
                    $temp[$i + ($k * $lst_pos[$l][0])][$j + ($k * $lst_pos[$l][1])] = $nb;
                    $temp[$i][$j] = 0;
                    /* MOVEMENT */
                    if ($this->map[$i + ($k * $lst_pos[$l][0])][$j + ($k * $lst_pos[$l][1])] === 0) {
                        if (!$this->is_in_check($this->map)) {
                            $data .= 8* ($i +($k * $lst_pos[$l][0])) + $j + ($k * $lst_pos[$l][1]);
                            $data .= ",";
                        }
                        else {
                            if (!$this->is_in_check($temp)) {
                                $data .= 8* ($i +($k * $lst_pos[$l][0])) + $j + ($k * $lst_pos[$l][1]);
                                $data .= ",";
                            }
                        }
                    }
                    /* ATTACK */
                    else if ($this->map[$i + ($k * $lst_pos[$l][0])][$j + ($k * $lst_pos[$l][1])] > 0) {
                        if (!$this->is_in_check($this->map)) {
                            $data .= 8* ($i +($k * $lst_pos[$l][0])) + $j + ($k * $lst_pos[$l][1]);
                            $data .= ",";
                        }
                        else {
                            if (!$this->is_in_check($temp)) {
                                $data .= 8* ($i +($k * $lst_pos[$l][0])) + $j + ($k * $lst_pos[$l][1]);
                                $data .= ",";
                            }
                        }
                        break;
                    }
                    /* US */
                    else {
                        break;
                    }
                }
            }
        }
        return $data;
    }

    function get_possibility_by_piece($piece,$i,$j) {
        $data = "";
        switch ($piece) {
            case 1 :
                /* PAWN */
                if ($this->map[$i-1][$j] === 0) {
                     /* PAWN NOIRE MOVE ONE */
                    $temp = $this->map;
                    $temp[$i-1][$j] = 1;
                    $temp[$i][$j] = 0;
                    if (!$this->is_in_check($this->map)) {
                        $data .= 8 * ($i-1) + $j;
                        $data .= ",";
                    }
                    else {
                        if (!$this->is_in_check($temp)) {
                            $data .= 8 * ($i-1) + $j;
                            $data .= ",";
                        }
                    }
                    if ($i === 6) {
                        /* PAWN NOIRE MOVE TWO */
                        if ($this->map[$i-2][$j] === 0) {
                            $temp = $this->map;
                            $temp[$i - 2][$j] = 1;
                            $temp[$i][$j] = 0;
                            if (!$this->is_in_check($this->map)) {
                                $data .= 8 * ($i-2) + $j;
                                $data .= ",";
                            }
                            else {
                                if (!$this->is_in_check($temp)) {
                                    $data .= 8 * ($i-2) + $j;
                                    $data .= ",";
                                }
                            }
                        }
                    }
                }

                if ($this->map[$i-1][$j-1] > 0) {
                    /* PAWN ATTACK 1 */
                    $temp = $this->map;
                    $temp[$i-1][$j-1] = 1;
                    $temp[$i][$j] = 0;
                    if (!$this->is_in_check($this->map)) {
                        $data .= 8 * ($i-1) + ($j-1);
                        $data .= ",";
                    }
                    else {
                        if (!$this->is_in_check($temp)) {
                            $data .= 8 * ($i-1) + ($j-1);
                            $data .= ",";
                        }
                    }
                }
                if ($this->map[$i-1][$j+1] > 0) {
                    /* PAWN ATTACK 2 */
                    $temp = $this->map;
                    $temp[$i-1][$j+1] = 1;
                    $temp[$i][$j] = 0;
                    if (!$this->is_in_check($this->map)) {
                        $data .= 8 * ($i-1) + ($j+1);
                        $data .= ",";
                    }
                    else {
                        if (!$this->is_in_check($temp)) {
                            $data .= 8 * ($i-1) + ($j+1);
                            $data .= ",";
                        }
                    }
                }
                break;
            case 2 :
                /* TOWER */
                $lst_pos = [[1,0],[-1,0],[0,1],[0,-1]];
                $data .= $this->simple_movement_to_str($lst_pos,$i,$j,2,8);
                break;
            case 3 :
                /* KNIGHT  */
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
                        if ($this->map[$lst_pos[$k][0]][$lst_pos[$k][1]] >= 0) {
                            $temp = $this->map;
                            $temp[$lst_pos[$k][0]][$lst_pos[$k][1]] = 3;
                            $temp[$i][$j] = 0;
                            if (!$this->is_in_check($this->map)) {
                                $data .= 8 * $lst_pos[$k][0] + $lst_pos[$k][1];
                                $data .= ",";
                            } else {
                                if (!$this->is_in_check($temp)) {
                                    $data .= 8 * $lst_pos[$k][0] + $lst_pos[$k][1];
                                    $data .= ",";
                                }
                            }
                        }
                    }
                }
                break;
            case 4 :
                /* Bishop */
                $lst_pos = [[1,1],[-1,1],[-1,-1],[1,-1]];
                $data .= $this->simple_movement_to_str($lst_pos,$i,$j,4,8);
                break;
            case 5:
                /* Queen */
                $lst_pos = [[1,1],[-1,1],[-1,-1],[1,-1],[1,0],[-1,0],[0,1],[0,-1]];
                $data .= $this->simple_movement_to_str($lst_pos,$i,$j,5,8);
                break;
            case 6 :
                /* King */
                $lst_pos = [[1,1],[-1,1],[-1,-1],[1,-1],[1,0],[-1,0],[0,1],[-1,0]];
                $data .= $this->simple_movement_to_str($lst_pos,$i,$j,6,1);
                break;
        }
        return $data;
    }

    function get_possibility_for_ia() {
        echo $this->is_in_check($this->map);
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
                                if (!$this->is_in_check($this->map)) {
                                    $this->all_map[] = $temp;
                                }
                                else {
                                    if (!$this->is_in_check($temp)) {
                                        $this->all_map[] = $temp;
                                    }
                                }
                            }
                            /* PAWN BLACK MOVE ONE */
                            $temp = $this->map;
                            $temp[$i+1][$j] = 1;
                            $temp[$i][$j] = 0;
                            if (!$this->is_in_check($this->map)) {
                                $this->all_map[] = $temp;
                            }
                            else {
                                if (!$this->is_in_check($temp)) {
                                    $this->all_map[] = $temp;
                                }
                            }
                            if ($i === 1) {
                                /* PAWN BLACK MOVE TWO */
                                if ($this->map[$i+2][$j] === 0) {
                                    $temp = $this->map;
                                    $temp[$i + 2][$j] = 1;
                                    $temp[$i][$j] = 0;
                                    if (!$this->is_in_check($this->map)) {
                                        $this->all_map[] = $temp;
                                    }
                                    else {
                                        if (!$this->is_in_check($temp)) {
                                            $this->all_map[] = $temp;
                                        }
                                    }
                                }
                            }
                        }

                        if ($this->map[$i+1][$j+1] < 0) {
                            /* PAWN ATTACK 1 */
                            $temp = $this->map;
                            $temp[$i+1][$j+1] = 1;
                            $temp[$i][$j] = 0;
                            if (!$this->is_in_check($this->map)) {
                                $this->all_map[] = $temp;
                            }
                            else {
                                if (!$this->is_in_check($temp)) {
                                    $this->all_map[] = $temp;
                                }
                            }
                        }
                        if ($this->map[$i+1][$j-1] < 0) {
                            /* PAWN ATTACK 2 */
                            $temp = $this->map;
                            $temp[$i+1][$j-1] = 1;
                            $temp[$i][$j] = 0;
                            if (!$this->is_in_check($this->map)) {
                                $this->all_map[] = $temp;
                            }
                            else {
                                if (!$this->is_in_check($temp)) {
                                    $this->all_map[] = $temp;
                                }
                            }
                        }
                        break;
                    case 2 :
                        /* TOWER */
                        $lst_pos = [[1,0],[-1,0],[0,1],[-1,0]];
                        $this->simple_movement($lst_pos,$i,$j,2,8);
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
                                if (!$this->is_in_check($this->map)) {
                                    $this->all_map[] = $temp;
                                }
                                else {
                                    if (!$this->is_in_check($temp)) {
                                        $this->all_map[] = $temp;
                                    }
                                }
                            }
                        }
                        break;
                    case 4 :
                        /* Bishop */
                        $lst_pos = [[1,1],[-1,1],[-1,-1],[1,-1]];
                        $this->simple_movement($lst_pos,$i,$j,4,8);
                        break;
                    case 5:
                        /* Queen */
                        $lst_pos = [[1,1],[-1,1],[-1,-1],[1,-1],[1,0],[-1,0],[0,1],[-1,0]];
                        $this->simple_movement($lst_pos,$i,$j,5,8);
                        break;
                    case 6 :
                        /* King */
                        $lst_pos = [[1,1],[-1,1],[-1,-1],[1,-1],[1,0],[-1,0],[0,1],[-1,0]];
                        $this->simple_movement($lst_pos,$i,$j,6,1);
                        break;
                }
            }
        }
        /* IF count($this->>all_map) === 0 THEN CHECKMATE  */
        return $this->all_map;
    }
}