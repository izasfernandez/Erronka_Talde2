<?php
    // header("Access-Control-Allow-Headers:{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    // header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
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
        $filtroa = "";
        $gaurkodata = time();
        $erosketaData = date('Y-m-d', $gaurkodata);
        if (isset($data["idEkipamendu"])) {
            for ($i=0; $i < $data["stck"]; $i++) { 
                $inbentario->add_inbent($data["idEkipamendu"],$erosketaData);
                $json = json_encode($inbentario);
            }
        }else{
            if (isset($data["bilaketa"])) {
                $filtroa = " AND LOWER(inbentarioa.etiketa) LIKE '%".$data["bilaketa"]."%'";
            }
            if (!empty($data["artikulua"])) {
                $filtroa = $filtroa." AND inbentarioa.idEkipamendu IN (SELECT ekipamendua.id FROM ekipamendua WHERE ekipamendua.izena LIKE '%".$data["artikulua"]."%')";
            }
            if (!empty($data["hData"])) {
                $filtroa = $filtroa." AND inbentarioa.erosketaData >= '".$data["hData"]."'";
            }
            if (!empty($data["aData"])) {
                $filtroa = $filtroa." AND inbentarioa.erosketaData <= '".$data["aData"]."'";
            }
            $inbentario->inbentario_info_filtroz_kargatu($filtroa);
            $json = json_encode($inbentario);
        }
        echo ($json);
    }

    if($_SERVER["REQUEST_METHOD"]=="PUT"){

        
    }
?>
