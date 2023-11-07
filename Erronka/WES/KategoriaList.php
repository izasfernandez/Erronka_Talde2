<?php
    include("DB.php");
    include("Listak_Inter.php");

    class Kategoria
    {
        public $id;
        public $izena;

        function __construct($id,$izena){
            $this->id = $id;
            $this->izena = $izena;
        }
    }
    
    class kategoriaList implements Listak
    {
        public $katList;

        function __construct()
        {
            $this->katList = [];
        }

        function informazioa_karga($sql)
        {
            // $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $conn = new DB("localhost","root","","3wag2e1");
            $emaitza = $conn->select($sql);
            if ($emaitza->num_rows > 0) {
                while ($row = $emaitza->fetch_assoc()) {
                    $kategoria = new Kategoria($row["id"],$row["izena"]);
                    $this->katList[count($this->katList)] = $kategoria;
                }
            }
            $conn->die();
        }

        function id_max()
        {
            $sql = "SELECT MAX(kategoria.id) as max FROM kategoria";
            // $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $conn = new DB("localhost","root","","3wag2e1");
            $emaitza = $conn->select($sql);
            $id_kat = 0;
            if ($emaitza->num_rows > 0) {
                while ($row = $emaitza->fetch_assoc()) {
                    $id_kat = $row["max"];
                }
            }
            $conn->die();
            $id_kat++;
            return $id_kat++;
        }

        function kategoria_kargatu()
        {
            $sql = "SELECT * FROM kategoria";
            $this->informazioa_karga($sql);
        }

        function kategoria_izena_kargatu($id)
        {
            $sql = "SELECT * FROM kategoria WHERE kategoria.id = ".$id;
            $this->informazioa_karga($sql);
        }

        function kategoria_gehitu($sql)
        {
            $conn = new DB("localhost","root","","3wag2e1");
            $error = $conn->query($sql);
            $conn->die();
            return $error;
        }

        function kategoria_ezabatu($sql)
        {
            $conn = new DB("localhost","root","","3wag2e1");
            $error = $conn->query($sql);
            $conn->die();
            return $error;
        }

        function kategoria_eguneratu($sql)
        {
            $conn = new DB("localhost","root","","3wag2e1");
            $error = $conn->query($sql);
            $conn->die();
            return $error;
        }

    }
    
?>