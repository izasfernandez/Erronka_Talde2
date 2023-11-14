<?php
    // header("Access-Control-Allow-Headers:{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    // header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header("Content-Type: application/json; charset=UTF-8");

    include("GelaList.php");

    $gela = new GelaList();
    if($_SERVER["REQUEST_METHOD"]=="GET"){
        if (isset($_GET["id_gela"])) {
            $gela->gela_info_kargatu($_GET["id_gela"]);
        }else{
            $gela->gela_kargatu();
        }
        $json = json_encode($gela);
        echo ($json);
    }

    if($_SERVER["REQUEST_METHOD"]=="PUT"){
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data,true);
        $error = "";
        if (isset($data["id"]) && isset($data["izena"]) && isset($data["taldea"])) {
            $sql = "UPDATE gela SET gela.izena = '".$data["izena"]."', gela.taldea = '".$data["taldea"]."' WHERE gela.id = ".$data["id"];
            $error = $gela->gela_eguneratu($sql);
        }
        $json = json_encode($error);
        echo ($json);
    }

    if($_SERVER["REQUEST_METHOD"]=="DELETE"){
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data,true);
        if (isset($data["id"])) {
            $sql = "DELETE FROM gela WHERE gela.id = ".$data["id"];
            $error = $gela->gela_ezabatu($sql);
        }
        $json = json_encode($error);
        echo ($json);
    }

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data,true);
        if (isset($data["izena"]) && isset($data["taldea"])) {
            $id_gela = $gela->id_max();
            $sql = "INSERT INTO gela VALUES (".$id_gela.",'".$data["izena"]."','".$data["taldea"]."')";
            $error = $gela->gela_gehitu($sql);
        }
        $json = json_encode($error);
        echo ($json);
    }
?>