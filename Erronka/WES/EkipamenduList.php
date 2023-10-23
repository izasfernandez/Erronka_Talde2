<?php
    include("DB.php");
    include("Listak.php");

    class Ekipamendua
    {
        public $id;
        public $izena;
        public $deskribapena;
        public $marka;
        public $modeloa;
        public $stock;
        public $idKategoria;
        public $url;

        function __construct($id,$izena,$deskribapena,$marka,$modeloa,$stock,$idKategoria,$url){
            $this->id = $id;
            $this->izena = $izena;
            $this->deskribapena = $deskribapena;
            $this->marka = $marka;
            $this->modeloa = $modeloa;
            $this->stock = $stock;
            $this->idKategoria = $idKategoria;
            $this->url = $url;
        }
    }

    class EkipamenduList implements Listak
    {
        public $ekipList;

        function __construct()
        {
            $this->ekipList = [];
        }

        function informazioa_karga($sql)
        {
            // $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $conn = new DB("localhost","root","","3wag2e1");
            $emaitza = $conn->select($sql);
            if ($emaitza->num_rows > 0) {
                while ($row = $emaitza->fetch_assoc()) {
                    $url = "";
                    if (empty($row["img_url"])) {
                        $url = "../img/img_art_defecto.png";
                    }else{
                        $url = $row["img_url"];
                    }
                    $ekipamendua = new Ekipamendua($row["id"],$row["izena"],$row["deskribapena"],$row["marka"],$row["modelo"],$row["stock"],$row["idKategoria"],$url);
                    $this->add_to_list($ekipamendua);
                }
            }
            $conn->die();
        }

        function artikulu_info_kargatu($id)
        {
            $sql = "SELECT * FROM 3wag2e1.ekipamendua WHERE 3wag2e1.ekipamendua.id = ".$id;
            $this->informazioa_karga($sql);
        }

        function artikuluak_kargatu()
        {
            $sql = "SELECT * FROM 3wag2e1.ekipamendua";
            $this->informazioa_karga($sql);
        }

        function artikuluak_filtratu($queryFiltroa)
        {
            $sql = "SELECT * FROM 3wag2e1.ekipamendua".$queryFiltroa;
            $this->informazioa_karga($sql);
        }

        function artikulua_eguneratu($sql)
        {
            $conn = new DB("localhost","root","","3wag2e1");
            $error = $conn->query($sql);
            $conn->die();
            return $error;
        }

        function markak_kargatu()
        {
            $sql = "SELECT DISTINCT(3wag2e1.ekipamendua.marka) FROM 3wag2e1.ekipamendua;";
            $conn = new DB("localhost","root","","3wag2e1");
            $kontsulta = $conn->select($sql);
            $markak = $kontsulta->fetch_all(MYSQLI_ASSOC);
            $conn->die();
            return $markak;
        }

        function add_to_list($ekipamendua)
        {
            $this->ekipList[count($this->ekipList)] = $ekipamendua;
        }
    }

      
?>