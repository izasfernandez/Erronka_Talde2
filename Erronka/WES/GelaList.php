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
            $conn = new DB("localhost","root","","3wag2e1");
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
    }
    
?>