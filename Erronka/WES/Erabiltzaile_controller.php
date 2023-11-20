<?php
    // Edozein jatorritatik sartzeko aukera ematen du
    header("Access-Control-Allow-Origin: *");
    // Eskaeran zehaztutako goiburuak onartzen ditu
    header("Access-Control-Allow-Headers: Content-Type");
    // Zehaztutako HTTP metodoak ahalbidetzen ditu
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

    /**
     * Fitxategiak gehitzen ditu
     * Erabiltzailea.php
     */
    include("Erabiltzailea.php");

    /**
     * GET bidez deia egiten denean, behar den erabiltzailearen informazioa JSON bidaltzen da 
     */
    if($_SERVER["REQUEST_METHOD"]=="GET"){
        if (isset($_GET["erabil"])) {
            $erabil = new erabiltzailea();
            $error = $erabil->erabiltzailea_kargatu($_GET["erabil"]);
            if(!$error){
                $json = json_encode($error);
            }else{
                $json = json_encode($erabil);
            }
            echo ($json);
        }else{
            if (isset($_GET["nan"])) {
                $erabil = new erabiltzailea();
                $erabil->erabiltzailea_sesion_kargatu($_GET["nan"]);
                $json = json_encode($erabil);
            }          
            echo ($json);
        }
    }

    /**
     * DELETE bidez deia egiten denean, lortutako erabiltzailea zerbitzaritik ezabatzen da 
     */
    if($_SERVER["REQUEST_METHOD"]=="DELETE"){
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data,true);
        $erabil = new erabiltzailea();
        $error = "";
        if (isset($data["nan"])) {
            $sql = "DELETE FROM erabiltzailea WHERE erabiltzailea.nan = '".$data["nan"]."'";
            $error = $erabil->ezabatu($sql);
        }
        $json = json_encode($error);
        echo ($json);
    }

    /**
     * PUT bidez deia egiten denean, lortutako erabiltzailea zerbitzarian eguneratzen da 
     */
    if($_SERVER["REQUEST_METHOD"]=="PUT"){
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data,true);
        $erabil = new erabiltzailea();
        $error = "ERROR";
        if (isset($data["izena"])&&isset($data["abizena"])&&isset($data["erabil"])&&isset($data["nan"])) {
            if (!$erabil->erabiltzailea_konprobatu($data["erabil"])) {
                if (empty($data["pasa"])) {
                    $sql = "UPDATE erabiltzailea SET erabiltzailea.izena = '".$data["izena"]."', erabiltzailea.abizena = '".$data["abizena"]."', erabiltzailea.erabiltzailea = '".$data["erabil"]."' WHERE erabiltzailea.nan = '".$data["nan"]."'";
                }else{
                    $sql = "UPDATE erabiltzailea SET erabiltzailea.izena = '".$data["izena"]."', erabiltzailea.abizena = '".$data["abizena"]."', erabiltzailea.erabiltzailea = '".$data["erabil"]."', erabiltzailea.pasahitza = '".$data["pasa"]."' WHERE erabiltzailea.nan = '".$data["nan"]."'";
                }
            }
            $error = $erabil->eguneratu($sql);
        }
        $json = json_encode($error);
        echo ($json);
    }

    /**
     * POST bidez deia egiten denean, behar den informazioa JSON-en bidez bidaltzen duen baldintza (filtroak baieztatzeko), edota
     * erabiltzaile berria zerbitzarian txertatzen da 
     */
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data,true);
        $error = "ERROR";
        $erabil = new erabiltzailea();
        if ($data["kontsulta"]) {
            if (isset($data["erabil"])) {
                $error = $erabil->erabiltzailea_konprobatu($data["erabil"]);
                $json = json_encode($error);
            }elseif (isset($data["nan"])) {
                $error = $erabil->erabiltzailea_nan_konprobatu($data["nan"]);
                $json = json_encode($error);
            }else{
                $emaitza = $erabil->erabiltzaileak_kargatu();
                $json = json_encode($emaitza);
            }
        }else{
            if (isset($data["nan"])&&isset($data["izena"])&&isset($data["abizena"])&&isset($data["erabil"])&&isset($data["rol"])&&isset($data["pasa"])) {
                if ($erabil->nan_konprobaketa($data["nan"]) && !$erabil->erabiltzailea_nan_konprobatu($data["nan"]) && !$erabil->erabiltzailea_konprobatu($data["erabil"])) {
                    $sql = "INSERT INTO erabiltzailea VALUES('".$data["nan"]."','".$data["izena"]."','".$data["abizena"]."','".$data["erabil"]."','".$data["pasa"]."','".$data["rol"]."')";
                    $error = $erabil->gehitu($sql);
                }
            }
            $json = json_encode($error);
        }
        echo ($json);
    }
?>
