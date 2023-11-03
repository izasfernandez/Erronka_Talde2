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

    if($_SERVER["REQUEST_METHOD"]=="PUT"){
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data,true);
        $kategoriak = new kategoriaList();
        if (isset($data["id"])&&isset($data["izena"])) {
            $sql = "UPDATE 3wag2e1.kategoria SET 3wag2e1.kategoria.izena = '".$data["izena"]."' WHERE 3wag2e1.kategoria.id = ".$data["id"];
            $error = $kategoriak->kategoria_eguneratu($sql);
        }
        $json = json_encode($error);
        echo ($json);
    }

    if($_SERVER["REQUEST_METHOD"]=="DELETE"){
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data,true);
        $kategoriak = new kategoriaList();
        if (isset($data["id"])) {
            $sql = "DELETE FROM 3wag2e1.kategoria WHERE 3wag2e1.kategoria.id = ".$data["id"];
            $error = $kategoriak->kategoria_ezabatu($sql);
        }
        $json = json_encode($error);
        echo ($json);
    }

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data,true);
        $kategoriak = new kategoriaList();
        if (isset($data["izena"])) {
            $idkat = $kategoriak->id_max();
            $sql = "INSERT INTO 3wag2e1.kategoria VALUES (".$idkat.",'".$data["izena"]."')";
            $error = $kategoriak->kategoria_gehitu($sql);
        }
        $json = json_encode($error);
        echo ($json);
    }
?>