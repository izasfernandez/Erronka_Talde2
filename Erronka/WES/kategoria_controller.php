<?php
    // Edozein jatorritatik sartzeko aukera ematen du
    header("Access-Control-Allow-Origin: *");
    // Eskaeran zehaztutako goiburuak onartzen ditu
    header("Access-Control-Allow-Headers: Content-Type");
    // Zehaztutako HTTP metodoak ahalbidetzen ditu
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

    /**
     * Fitxategiak gehitzen ditu
     * KategoriaList.php
     */
    include("KategoriaList.php");

    /**
     * GET bidez deia egiten denean, behar den kategoriaren informazioa JSON bidaltzen da 
     */
    if($_SERVER["REQUEST_METHOD"]=="GET"){
        if (isset($_GET["id_kat"])) {
            $kategoriak = new kategoriaList();
            $kategoriak->kategoria_izena_kargatu($_GET["id_kat"]);
        } else {
            $kategoriak = new kategoriaList();
            $kategoriak->kategoria_kargatu();
        }
        $json = json_encode($kategoriak);
        echo ($json);
    }

    /**
     * PUT bidez deia egiten denean, lortutako kategoria zerbitzarian eguneratzen da 
     */
    if($_SERVER["REQUEST_METHOD"]=="PUT"){
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data,true);
        $error = "ERROR";
        $kategoriak = new kategoriaList();
        if (isset($data["id"])&&isset($data["izena"])) {
            if (!$kategoriak->kategoria_konprobatu_eguneratu($data["izena"],$data["id"])) {
                $sql = "UPDATE kategoria SET kategoria.izena = '".$data["izena"]."' WHERE 3wag2e1.kategoria.id = ".$data["id"];
                $error = $kategoriak->kategoria_eguneratu($sql);
            }
        }
        $json = json_encode($error);
        echo ($json);
    }

    /**
     * DELETE bidez deia egiten denean, lortutako kategoria zerbitzaritik ezabatzen da 
     */
    if($_SERVER["REQUEST_METHOD"]=="DELETE"){
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data,true);
        $kategoriak = new kategoriaList();
        if (isset($data["id"])) {
            $sql = "DELETE FROM kategoria WHERE kategoria.id = ".$data["id"];
            $error = $kategoriak->kategoria_ezabatu($sql);
        }
        $json = json_encode($error);
        echo ($json);
    }

    /**
     * POST bidez deia egiten denean, behar den informazioa JSON-en bidez bidaltzen duen baldintza (filtroak baieztatzeko), edota
     * kategoria berria zerbitzarian txertatzen da 
     */
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data,true);
        $kategoriak = new kategoriaList();
        $error = "ERROR";
        if (isset($data["kategoria_izena"])) {
            $error = $kategoriak->kategoria_konprobatu($data["kategoria_izena"]);
        }else{
            if (isset($data["izena"])) {
                if (!$kategoriak->kategoria_konprobatu($data["izena"])) {
                    $idkat = $kategoriak->id_max();
                    $sql = "INSERT INTO kategoria VALUES (".$idkat.",'".$data["izena"]."',".$data["inb"].")";
                    $error = $kategoriak->kategoria_gehitu($sql);
                }
            }
        }
        $json = json_encode($error);
        echo ($json);
    }
?>