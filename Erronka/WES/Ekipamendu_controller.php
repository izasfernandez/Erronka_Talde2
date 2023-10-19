<?php
    header("Access-Control-Allow-Origin: http://127.0.0.1:5500");
    header("Content-Type: application/json; charset=UTF-8");

    include("EkipamenduList.php");

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $queryFiltroa = "";
        $json_data = file_get_contents("php://input");
        if (isset($json_data)) {
            $data = json_decode($json_data,true);
            if(!empty($data["art_izena"])){
                $query_filtroa = " WHERE 3wag2e1.ekipamendua.izena = '".$data["art_izena"]."'";
            }
            if(!empty($data["art_deskribapena"])){
                if (empty($query_filtroa)) {
                    $query_filtroa = " WHERE 3wag2e1.ekipamendua.izena = '".$data["art_deskribapena"]."'";
                }else{
                    $query_filtroa = $query_filtroa." AND 3wag2e1.ekipamendua.deskribapena = '".$data["art_deskribapena"]."'";
                }
            }
            if(!empty($data["art_stck_min"])){
                if (empty($query_filtroa)) {
                    $query_filtroa = " WHERE 3wag2e1.ekipamendua.stock > '".$data["art_stck_min"]."'";
                }else{
                    $query_filtroa = $query_filtroa." AND 3wag2e1.ekipamendua.stock > '".$data["art_stck_min"]."'";
                }
            }
            if(!empty($data["art_stck_max"])){
                if (empty($query_filtroa)) {
                    $query_filtroa = " WHERE 3wag2e1.ekipamendua.stock < ".$data["art_stck_max"];
                }else{
                    $query_filtroa = $query_filtroa." AND 3wag2e1.ekipamendua.stock < ".$data["art_stck_max"];
                }
            }
        }
        $artikuluak = new EkipamenduList();
        $artikuluak->informazioa_karga($queryFiltroa);
        $json = json_encode($artikuluak);
        echo ($json);
    }
?>