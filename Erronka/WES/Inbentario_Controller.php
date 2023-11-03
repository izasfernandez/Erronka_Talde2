<?php
    header("Access-Control-Allow-Origin: http://127.0.0.1:5500");
    header("Content-Type: application/json; charset=UTF-8");

    include("InbentarioList.php");

    $artikuluak = new InbentarioList();

    if($_SERVER["REQUEST_METHOD"]=="GET"){
        $artikuluak->informazioa_karga();
        $json = json_encode($artikuluak);
        echo ($json);
    }
    
?>