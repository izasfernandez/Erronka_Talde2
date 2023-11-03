<?php
    header("Access-Control-Allow-Origin: http://127.0.0.1:5500");
    header("Content-Type: application/json; charset=UTF-8");

    include("InbentarioList.php");

    $inbentario = new InbentarioList();

    if($_SERVER["REQUEST_METHOD"]=="GET"){
        $inbentario->inbentario_info_kargatu();
        $json = json_encode($inbentario);
        echo ($json);
    }

    if($_SERVER["REQUEST_METHOD"]=="DELETE"){
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data,true);

        $error = "";
        if (isset($data["etiketa"])) {
            $error = $inbentario->inbent_ezabatu($data["etiketa"]);
        }
        $json = json_encode($error);
        echo ($json);
    }

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data,true);
        
        $gaurkodata = time();
        $erosketaData = date('Y-m-d', $gaurkodata);
        
        if (isset($data["idEkipamendu"])) {
            $inbentario->add_inbent($data["idEkipamendu"],$erosketaData);
        }
        $json = json_encode($inbentario);
        echo ($json);
    }
?>