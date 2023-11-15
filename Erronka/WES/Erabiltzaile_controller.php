<?php
    // header("Access-Control-Allow-Headers:{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    // header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Content-Type");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    // header("Content-Type: application/json; charset=UTF-8");

    include("Erabiltzailea.php");

    if($_SERVER["REQUEST_METHOD"]=="GET"){
        if (isset($_GET["erabil"])) {
            $erabil = new erabiltzailea();
            $error = $erabil->erabiltzailea_kargatu($_GET["erabil"]);
            // echo $_SESSION["nan"];
            if(!$error){
                $json = json_encode($error);
            }else{
                session_start();
                ini_set('session.use_only_cookies', 1);
                $_SESSION["nan"] = $erabil->nan;
                $json = json_encode($erabil);
            }
            echo ($json);
        }else{
            session_start();
            // echo "aaa";
            // echo session.use_cookies;
            $erabil = new erabiltzailea();
            echo $_SESSION["nan"];
            $erabil->erabiltzailea_sesion_kargatu($_SESSION["nan"]);
            $json = json_encode($erabil);
            echo ($json);
        }
    }

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

    if($_SERVER["REQUEST_METHOD"]=="PUT"){
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data,true);
        $erabil = new erabiltzailea();
        if (isset($data["izena"])&&isset($data["abizena"])&&isset($data["erabil"])&&isset($data["nan"])) {
            if (empty($data["pasa"])) {
                $sql = "UPDATE erabiltzailea SET erabiltzailea.izena = '".$data["izena"]."', erabiltzailea.abizena = '".$data["abizena"]."', erabiltzailea.erabiltzailea = '".$data["erabil"]."' WHERE erabiltzailea.nan = '".$data["nan"]."'";
            }else{
                $sql = "UPDATE erabiltzailea SET erabiltzailea.izena = '".$data["izena"]."', erabiltzailea.abizena = '".$data["abizena"]."', erabiltzailea.erabiltzailea = '".$data["erabil"]."', erabiltzailea.pasahitza = '".$data["pasa"]."' WHERE erabiltzailea.nan = '".$data["nan"]."'";
            }
        }
        $error = $erabil->eguneratu($sql);
        $json = json_encode($error);
        echo ($json);
    }

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data,true);
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
                $sql = "INSERT INTO erabiltzailea VALUES('".$data["nan"]."','".$data["izena"]."','".$data["abizena"]."','".$data["erabil"]."','".$data["pasa"]."','".$data["rol"]."')";
            }
            $error = $erabil->gehitu($sql);
            $json = json_encode($error);
        }
        echo ($json);
    }
?>
