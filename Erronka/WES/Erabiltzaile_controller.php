<?php
    header("Access-Control-Allow-Origin: http://127.0.0.1:5500");
    header("Content-Type: application/json; charset=UTF-8");

    include("Erabiltzailea.php");

    if($_SERVER["REQUEST_METHOD"]=="GET"){
        if (isset($_GET["erabil"])) {
            $erabil = new erabiltzailea($_GET["erabil"]);
            $json = json_encode($erabil);
            echo ($json);
        }
    }
?>
