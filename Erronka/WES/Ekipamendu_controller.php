<?php
    header("Access-Control-Allow-Origin: http://127.0.0.1:5500");
    header("Content-Type: application/json; charset=UTF-8");

    include("EkipamenduList.php");

    if($_SERVER["REQUEST_METHOD"]=="GET"){
        if (isset($_GET["id_art"])) {
            $artikuluak = new EkipamenduList();
            $artikuluak->artikulu_info_kargatu($_GET["id_art"]);
            $json = json_encode($artikuluak);
        } else {
            $artikuluak = new EkipamenduList();
            $artikuluak->artikuluak_kargatu();
            $markak = $artikuluak->markak_kargatu();
            $jsonData = ["artikuluak"=>$artikuluak,"markak"=>$markak];
            $json = json_encode($jsonData);
        }
        echo ($json);
    }

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $query_filtroa = "";
        $json_data = file_get_contents("php://input");
        if (isset($json_data)) {
            $data = json_decode($json_data,true);
            if(!empty($data["art_izena"])){
                $query_filtroa = " WHERE LOWER(3wag2e1.ekipamendua.izena) LIKE LOWER('%".$data["art_izena"]."%')";
            }
            if(!empty($data["art_deskribapena"])){
                if (empty($query_filtroa)) {
                    $query_filtroa = " WHERE LOWER(3wag2e1.ekipamendua.deskribapena) LIKE LOWER('%".$data["art_deskribapena"]."%')";
                }else{
                    $query_filtroa = $query_filtroa." AND 3wag2e1.ekipamendua.deskribapena LIKE LOWER('%".$data["art_deskribapena"]."%')";
                }
            }
            if(!empty($data["art_stck_min"])){
                if (empty($query_filtroa)) {
                    $query_filtroa = " WHERE 3wag2e1.ekipamendua.stock >= '".$data["art_stck_min"]."'";
                }else{
                    $query_filtroa = $query_filtroa." AND 3wag2e1.ekipamendua.stock >= '".$data["art_stck_min"]."'";
                }
            }
            if(!empty($data["art_stck_max"])){
                if (empty($query_filtroa)) {
                    $query_filtroa = " WHERE 3wag2e1.ekipamendua.stock <= ".$data["art_stck_max"];
                }else{
                    $query_filtroa = $query_filtroa." AND 3wag2e1.ekipamendua.stock <= ".$data["art_stck_max"];
                }
            }
            if(!empty($data["markak"])){
                for ($i=0; $i < count($data["markak"]); $i++) { 
                    if ($i == 0) {
                        if (empty($query_filtroa)) {
                            $query_filtroa = " WHERE (3wag2e1.ekipamendua.marka = '".$data["markak"][$i]."' ";
                        }else{
                            $query_filtroa = $query_filtroa." AND (3wag2e1.ekipamendua.marka = '".$data["markak"][$i]."' ";
                        }
                    }else{
                        $query_filtroa = $query_filtroa." OR 3wag2e1.ekipamendua.marka = '".$data["markak"][$i]."' ";
                    }
                    if ($i == count($data["markak"])-1) {
                        $query_filtroa = $query_filtroa.")";
                    }
                }
            }
            if($data["kategoria"] <> 0){
                if (empty($query_filtroa)) {
                    $query_filtroa = " WHERE 3wag2e1.ekipamendua.idKategoria = ".$data["kategoria"];
                }else{
                    $query_filtroa = $query_filtroa." AND 3wag2e1.ekipamendua.idKategoria = ".$data["kategoria"];
                }
            }
        }
        $artikuluak = new EkipamenduList();
        $artikuluak->artikuluak_filtratu($query_filtroa);
        $json = json_encode($artikuluak);
        echo ($json);
    }
?>