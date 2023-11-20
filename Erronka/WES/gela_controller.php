<?php
    // Edozein jatorritatik sartzeko aukera ematen du
    header("Access-Control-Allow-Origin: *");
    // Eskaeran zehaztutako goiburuak onartzen ditu
    header("Access-Control-Allow-Headers: Content-Type");
    // Zehaztutako HTTP metodoak ahalbidetzen ditu
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

    /**
     * Fitxategiak gehitzen ditu
     * GelaList.php
     */
    include("GelaList.php");

    // gela arraya sortzen da
    $gela = new GelaList();

    /**
     * GET bidez deia egiten denean, behar den gelaren informazioa JSON bidaltzen da 
     */
    if($_SERVER["REQUEST_METHOD"]=="GET"){
        if (isset($_GET["id_gela"])) {
            $gela->gela_info_kargatu($_GET["id_gela"]);
        }else{
            $gela->gela_kargatu();
        }
        $json = json_encode($gela);
        echo ($json);
    }

    /**
     * PUT bidez deia egiten denean, lortutako gela zerbitzarian eguneratzen da 
     */
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

    /**
     * DELETE bidez deia egiten denean, lortutako gela zerbitzaritik ezabatzen da 
     */
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

    /**
     * POST bidez deia egiten denean, behar den informazioa JSON-en bidez bidaltzen duen baldintza (filtroak baieztatzeko), edota
     * gela berria zerbitzarian txertatzen da 
     */
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data,true);
        $error = "ERROR";
        if (isset($data["kontsulta"])) {
            if (isset($data["gela"])) {
                $exist = $gela->izenaExists($data["gela"]);
                $json = json_encode($exist);
            }
        }else{
            if (isset($data["izena"]) && isset($data["taldea"])) {
                if (!$gela->izenaExists($data["izena"])) {
                    $id_gela = $gela->id_max();
                    $sql = "INSERT INTO gela VALUES (".$id_gela.",'".$data["izena"]."','".$data["taldea"]."')";
                    $error = $gela->gela_gehitu($sql);
                }                
            }
            $json = json_encode($error);
        }
        echo ($json);
    }
?>