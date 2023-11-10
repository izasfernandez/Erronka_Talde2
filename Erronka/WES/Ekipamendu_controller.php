<?php
    header("Access-Control-Allow-Origin: http://127.0.0.1:5500");
    header("Content-Type: application/json; charset=UTF-8");

    include("EkipamenduList.php");
    
    $artikuluak = new EkipamenduList();
    if($_SERVER["REQUEST_METHOD"]=="GET"){
        if (isset($_GET["id_art"])) {
            $artikuluak->artikulu_info_kargatu($_GET["id_art"]);
            $json = json_encode($artikuluak);
        } elseif (isset($_GET["artikulu_izena"])) {
            $jsonData = $artikuluak->izena_existitu($_GET["artikulu_izena"]);
            $json = json_encode($jsonData);
        } else {
            $artikuluak->artikuluak_kargatu();
            $markak = $artikuluak->markak_kargatu();
            $jsonData = ["artikuluak"=>$artikuluak,"markak"=>$markak];
            $json = json_encode($jsonData);
        }
        echo ($json);
    }

    if($_SERVER["REQUEST_METHOD"]=="DELETE"){
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data,true);
        $error = "";
        if (isset($data["id"])) {
            $sql = "DELETE FROM ekipamendua WHERE ekipamendua.id = ".$data["id"];
            $error = $artikuluak->ezabatu($sql);
        }
        $json = json_encode($error);
        echo ($json);
    }

    if($_SERVER["REQUEST_METHOD"]=="PUT"){
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data,true);
        $sql = "";
        if (isset($data["izena"])&&isset($data["desk"])&&isset($data["marka"])&&isset($data["modeloa"])&&isset($data["url"])&&isset($data["id"])) {
            $sql = "UPDATE ekipamendua SET ekipamendua.izena = '".$data["izena"]."', ekipamendua.deskribapena = '".$data["desk"]."', ekipamendua.marka = '".$data["marka"]."', ekipamendua.modelo = '".$data["modeloa"]."', ekipamendua.img_url = '".$data["url"]."' WHERE ekipamendua.id = ".$data["id"];
        }
        $error = $artikuluak->eguneratu($sql);
        $json = json_encode($error);
        echo ($json);
    }

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $query_filtroa = "";
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data,true);
        if (isset($json_data)) {
            if ($data["filtro"]) {
                if(!empty($data["art_izena"])){
                    $query_filtroa = " WHERE LOWER(ekipamendua.izena) LIKE LOWER('%".$data["art_izena"]."%')";
                }
                if(!empty($data["art_deskribapena"])){
                    if (empty($query_filtroa)) {
                        $query_filtroa = " WHERE LOWER(ekipamendua.deskribapena) LIKE LOWER('%".$data["art_deskribapena"]."%')";
                    }else{
                        $query_filtroa = $query_filtroa." AND ekipamendua.deskribapena LIKE LOWER('%".$data["art_deskribapena"]."%')";
                    }
                }
                if(!empty($data["art_stck_min"])){
                    if (empty($query_filtroa)) {
                        $query_filtroa = " WHERE ekipamendua.stock >= '".$data["art_stck_min"]."'";
                    }else{
                        $query_filtroa = $query_filtroa." AND ekipamendua.stock >= '".$data["art_stck_min"]."'";
                    }
                }
                if(!empty($data["art_stck_max"])){
                    if (empty($query_filtroa)) {
                        $query_filtroa = " WHERE ekipamendua.stock <= ".$data["art_stck_max"];
                    }else{
                        $query_filtroa = $query_filtroa." AND ekipamendua.stock <= ".$data["art_stck_max"];
                    }
                }
                if(!empty($data["markak"])){
                    for ($i=0; $i < count($data["markak"]); $i++) { 
                        if ($i == 0) {
                            if (empty($query_filtroa)) {
                                $query_filtroa = " WHERE (ekipamendua.marka = '".$data["markak"][$i]."' ";
                            }else{
                                $query_filtroa = $query_filtroa." AND (ekipamendua.marka = '".$data["markak"][$i]."' ";
                            }
                        }else{
                            $query_filtroa = $query_filtroa." OR ekipamendua.marka = '".$data["markak"][$i]."' ";
                        }
                        if ($i == count($data["markak"])-1) {
                            $query_filtroa = $query_filtroa.")";
                        }
                    }
                }
                if($data["kategoria"] <> 0){
                    if (empty($query_filtroa)) {
                        $query_filtroa = " WHERE ekipamendua.idKategoria = ".$data["kategoria"];
                    }else{
                        $query_filtroa = $query_filtroa." AND ekipamendua.idKategoria = ".$data["kategoria"];
                    }
                }
                $artikuluak->artikuluak_filtratu($query_filtroa);
                $json = json_encode($artikuluak);
            } else {
                if (isset($data["izena"])&&isset($data["desk"])&&isset($data["marka"])&&isset($data["model"])&&isset($data["url"])&&isset($data["kat"])) {
                    if (isset($data["stck"])) {
                        $ekipo = $artikuluak->add($data["izena"],$data["desk"],$data["marka"],$data["model"],$data["url"],$data["kat"],$data["stck"]);
                    }else{
                        $ekipo = $artikuluak->add($data["izena"],$data["desk"],$data["marka"],$data["model"],$data["url"],$data["kat"],0);
                    }
                }
                $json = json_encode($ekipo);
            }            
        }
        echo ($json);
    }
?>