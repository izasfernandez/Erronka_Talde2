<?php
    // header("Access-Control-Allow-Headers:{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    // header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    // header("Content-Type: application/json; charset=UTF-8");

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

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data,true);
        $error = "";
        $sql = "";
        if (isset($data["kontsulta"])) {
            if (isset($data["artikulua"])) {
                $sql = "  AND kokalekua.etiketa IN (SELECT inbentarioa.etiketa FROM inbentarioa WHERE inbentarioa.idEkipamendu IN (SELECT ekipamendua.id FROM ekipamendua WHERE LOWER(ekipamendua.izena) LIKE LOWER('%".$data["artikulua"]."%')))";
            }
            if (!empty($data["hData_f"])) {
                $sql = $sql." AND kokalekua.hasieraData <= '".$data["hData_f"]."'";
            }
            if (!empty($data["hData_t"])) {
                $sql = $sql." AND kokalekua.hasieraData >= '".$data["hData_t"]."'";
            }
            if (!empty($data["hData_f"])) {
                $sql = $sql." AND kokalekua.amaieraData <= '".$data["aData_f"]."'";
            }
            if (!empty($data["hData_t"])) {
                $sql = $sql." AND kokalekua.amaieraData >= '".$data["aData_t"]."'";
            }
            $kokaleku->kokaleku_filtratu($sql);
            $json = json_encode($kokaleku);
        }else{
            $adata = "";
            $hdata = "";
            if (empty($data["adata"])) {
                $adata = "NULL";
            }else{
                $adata = "'".$data["adata"]."'";
            }
            if (empty($data["hdata"])) {
                $gaurkodata = time();
                $hdata = date('Y-m-d', $gaurkodata);
            }else{
                $hdata = $data["hdata"];
            }
            if (isset($data["art"]) && isset($data["gela"])) {
                $sql = "INSERT INTO kokalekua VALUES('".$data["art"]."',".$data["gela"].",'".$hdata."',".$adata.")";
                $error = $kokaleku->add_kokaleku($sql);
            }
            $json = json_encode($error);
        }
        
        echo ($json);
    }

    if($_SERVER["REQUEST_METHOD"]=="PUT"){
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data,true);
        $error = "";
        $sql = "";
        $gaurkodata = time();
        $gaur = date('Y-m-d', $gaurkodata);
        if (isset($data["etiketa"]) && isset($data["gela"])) {
            $sql = "UPDATE kokalekua SET kokalekua.amaieraData = '".$gaur."' WHERE kokalekua.etiketa ='".$data["etiketa"]."' AND kokalekua.hasieraData = (SELECT MAX(kokalekua.hasieraData)  FROM kokalekua WHERE kokalekua.etiketa = '".$data["etiketa"]."')";
            $error = $kokaleku->kokaleku_eguneratu($sql);
            $sql = "INSERT INTO kokalekua VALUES('".$data["etiketa"]."',".$data["gela"].",'".$gaur."',NULL)";
            $error = $kokaleku->add_kokaleku($sql);
        }
        $json = json_encode($error);
        echo ($json);
    }
?>