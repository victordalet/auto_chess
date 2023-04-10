<?php

class Structure {

    private $title;
    private $date;

    function __construct($title) {
        $this->title = $title;
        $this->date = Date('Y');
    }

    function head() {
        echo <<<EOF

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset='utf-8'>
        <meta name='Author' CONTENT='Victor Dalet'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=no'>
        <meta name='description' content='Welcome to Chess.'>
        <link rel='stylesheet' type='text/css' href='../style/var.css'>
        <link rel='stylesheet' type='text/css' href='../style/tray.css'>
        <link rel='stylesheet' type='text/css' href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <title>$this->title</title>
    </head>
    <body>
EOF;
    }

    function footer() {
        echo <<<EOF
    </body>
    <footer>
        <p>$this->title | $this->date | <a target="_blank" href="https://victordalet.lescigales.org/">DALET Victor</a></p>
    </footer>
</html>
EOF;
    }


}
