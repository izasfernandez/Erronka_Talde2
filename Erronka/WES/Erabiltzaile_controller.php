<?php
    header("Access-Control-Allow-Origin: http://127.0.0.1:5500");
    header("Content-Type: application/json; charset=UTF-8");

    include("Erabiltzailea.php");

    if($_SERVER["REQUEST_METHOD"]=="GET"){
        if (isset($_GET["erabil"])) {
            $erabil = new erabiltzailea();
            $erabil->erabiltzailea_kargatu($_GET["erabil"]);
            session_start();
            $_SESSION["nan"] = $erabil->nan;
            // echo $_SESSION["nan"];
            $json = json_encode($erabil);
            echo ($json);
        }else{
            session_start();
            $erabil = new erabiltzailea();
            $erabil->erabiltzailea_sesion_kargatu($_SESSION["nan"]);
            $json = json_encode($erabil);
            echo ($json);
        }
    }

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data,true);
        $erabil = new erabiltzailea();
        if ($data["kontsulta"]) {
            if (isset($data["erabil"])) {
                $error = $erabil->erabiltzailea_konprobatu($data["erabil"]);
                $json = json_encode($error);
            }
        }else{
            if (isset($data["izena"])&&isset($data["abizena"])&&isset($data["erabil"])&&isset($data["nan"])) {
                if (empty($data["pasa"])) {
                    $sql = "UPDATE 3wag2e1.erabiltzailea SET 3wag2e1.erabiltzailea.izena = '".$data["izena"]."', 3wag2e1.erabiltzailea.abizena = '".$data["abizena"]."', 3wag2e1.erabiltzailea.erabiltzailea = '".$data["erabil"]."' WHERE 3wag2e1.erabiltzailea.nan = '".$data["nan"]."'";
                }else{
                    $sql = "UPDATE 3wag2e1.erabiltzailea SET 3wag2e1.erabiltzailea.izena = '".$data["izena"]."', 3wag2e1.erabiltzailea.abizena = '".$data["abizena"]."', 3wag2e1.erabiltzailea.erabiltzailea = '".$data["erabil"]."', 3wag2e1.erabiltzailea.pasahitza = '".$data["pasa"]."' WHERE 3wag2e1.erabiltzailea.nan = '".$data["nan"]."'";
                }
            }
            $error = $erabil->erabiltzailea_eguneratu($sql);
            $json = json_encode($error);
        }
        echo ($json);
    }
?>
