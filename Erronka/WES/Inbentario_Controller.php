<?php
    // Edozein jatorritatik sartzeko aukera ematen du
    header("Access-Control-Allow-Origin: *");
    // Eskaeran zehaztutako goiburuak onartzen ditu
    header("Access-Control-Allow-Headers: Content-Type");
    // Zehaztutako HTTP metodoak ahalbidetzen ditu
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

    /**
     * Fitxategiak gehitzen ditu
     * InbentarioList.php
     */
    include("InbentarioList.php");

    // inbentario arraya sortzen da
    $inbentario = new InbentarioList();

    /**
     * GET bidez deia egiten denean, behar den inbentarioaren informazioa JSON bidaltzen da 
     */
    if($_SERVER["REQUEST_METHOD"]=="GET"){
        if (isset($_GET["kok_art"])) {
            $inbentario_berria = new InbentarioList();
            $inbentario_aldaketa = new InbentarioList();
            $inbentario_berria->kokaleku_art_karga();
            $inbentario_aldaketa->kokaleku_art_kok_karga();
            $inbentario = ["berria"=>$inbentario_berria,"aldaketa"=>$inbentario_aldaketa];
        } else {
            $inbentario->inbentario_info_kargatu();
        }
        $json = json_encode($inbentario);
        echo ($json);
    }

    /**
     * DELETE bidez deia egiten denean, lortutako inbentarioa zerbitzaritik ezabatzen da 
     */
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

    /**
     * POST bidez deia egiten denean, behar den informazioa JSON-en bidez bidaltzen duen baldintza (filtroak baieztatzeko), edota
     * inbentario berria zerbitzarian txertatzen da
     */
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data,true);
        $filtroa = "";
        $gaurkodata = time();
        $erosketaData = date('Y-m-d', $gaurkodata);
        if (isset($data["kontsulta"])) {
            if (isset($data["etiketa"])) {
                $exist = $inbentario->etiketaExists($data["etiketa"]);
                $json = json_encode($exist);
            }
        }else{
            if (isset($data["idEkipamendu"])) {
                if ($data["stck"] > 0) {
                    for ($i=0; $i < $data["stck"]; $i++) { 
                        $inbentario->add_inbent($data["idEkipamendu"],$erosketaData);
                    }
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
        }
        echo ($json);
    }

    /**
     * PUT bidez deia egiten denean, lortutako inbentarioa zerbitzarian eguneratzen da 
     */
    if($_SERVER["REQUEST_METHOD"]=="PUT"){
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data,true);
        $error = "ERROR";
        if (isset($data["etiketa"]) && isset($data["etiketa_berria"])) {
            if (!$inbentario->etiketaExists($data["etiketa_berria"]) || $data["etiketa"] = $data["etiketa_berria"]) {
                $error = $inbentario->inbent_eguneratu($data["etiketa"],$data["etiketa_berria"]);
            }
        }
        $json = json_encode($error);
        echo ($json);
    }
?>
