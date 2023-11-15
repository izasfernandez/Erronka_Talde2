<?php
    // header("Access-Control-Allow-Headers:{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    // header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    // header("Content-Type: application/json; charset=UTF-8");

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
            $sql = "UPDATE kategoria SET kategoria.izena = '".$data["izena"]."' WHERE 3wag2e1.kategoria.id = ".$data["id"];
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
            $sql = "DELETE FROM kategoria WHERE kategoria.id = ".$data["id"];
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
            $sql = "INSERT INTO kategoria VALUES (".$idkat.",'".$data["izena"]."',".$data["inb"].")";
            $error = $kategoriak->kategoria_gehitu($sql);
        }
        $json = json_encode($error);
        echo ($json);
    }
?>