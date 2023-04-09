<?php

class Score {

    private $table;

    function __construct() {
        $this->get_score();
        echo <<<EOF

<section class="table-score">
EOF;
        for ($i = 0 ; $i < count($this->table) ; $i++) {
            echo "
<div class='cells'>".$this->table[$i][0].$this->table[$i][1]."</div>";

        }
        echo <<<EOF
</section>
EOF;
    }

    public function get_score() {
        $this->table = array(array("",""));
    }

}