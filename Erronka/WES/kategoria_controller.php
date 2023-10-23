<?php
    header("Access-Control-Allow-Origin: http://127.0.0.1:5500");
    header("Content-Type: application/json; charset=UTF-8");

    include("KategoriaList.php");

    if($_SERVER["REQUEST_METHOD"]=="GET"){
        if (isset($_GET["id_kat"])) {
            $kategoriak = new kategoriaList();
            $kategoriak->kategoria_izena_kargatu($_GET["id_kat"]);
        } else {
            $kategoriak = new kategoriaList();
            $kategoriak->kategoria_kargatu();
        }
        $json = json_encode($kategoriak);
        echo ($json);
    }
?>