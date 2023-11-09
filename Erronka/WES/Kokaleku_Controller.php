<?php
    header("Access-Control-Allow-Origin: http://127.0.0.1:5500");
    header("Content-Type: application/json; charset=UTF-8");

    include("KokalekuList.php");

    $kokaleku = new KokalekuList();

    if($_SERVER["REQUEST_METHOD"]=="GET"){
        $kokaleku->kokaleku_info_kargatu();
        $json = json_encode($kokaleku);
        echo ($json);
    }

    if($_SERVER["REQUEST_METHOD"]=="DELETE"){
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data,true);
        $error = "";
        if (isset($data["etiketa"]) && isset($data["hasieraData"])) {
            $error = $inbentario->kokaleku_ezabatu($data["etiketa"], $data["hasieraData"]);
        }
        $json = json_encode($error);
        echo ($json);
    }

?>