<?php

include("Listak_Inter.php");
include("DB.php");
class Gela
    {
        public $id;
        public $izena;
        public $taldea;

        function __construct($id,$izena,$taldea){
            $this->id = $id;
            $this->izena = $izena;
            $this->taldea = $taldea;
        }
    }

    class GelaList implements Listak
    {
        public $gelList;

        function __construct()
        {
            $this->gelList = [];
        }

        function informazioa_karga($sql)
        {
            // $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $emaitza = $conn->select($sql);
            if ($emaitza->num_rows > 0) {
                while ($row = $emaitza->fetch_assoc()) {
                    $gela = new Gela($row["id"],$row["izena"],$row["taldea"]);
                    $this->gelList[count($this->gelList)] = $gela;
                }
            }
            $conn->die();
        }

        function gela_kargatu()
        {
            $sql = "SELECT * FROM gela";
            $this->informazioa_karga($sql);
        }

        function gela_info_kargatu($id)
        {
            $sql = "SELECT * FROM gela WHERE gela.id = ".$id;
            $this->informazioa_karga($sql);
        }

        function gela_ezabatu($sql)
        {
            $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $error = $conn->query($sql);
            $conn->die();
            return $error;
        }

        function gela_eguneratu($sql)
        {
            $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $error = $conn->query($sql);
            $conn->die();
            return $error;
        }

        function id_max()
        {
            $sql = "SELECT MAX(gela.id) as max FROM gela";
            // $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $emaitza = $conn->select($sql);
            $id_gela = 0;
            if ($emaitza->num_rows > 0) {
                while ($row = $emaitza->fetch_assoc()) {
                    $id_gela = $row["max"];
                }
            }
            $conn->die();
            $id_gela++;
            return $id_gela;
        }

        function gela_gehitu($sql)
        {
            $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $error = $conn->query($sql);
            $conn->die();
            return $error;
        }
    }
?>