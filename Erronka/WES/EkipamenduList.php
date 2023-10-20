<?php
    include("Ekipamendua.php");
    include("DB.php");
    include("Listak.php");
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

        function add_to_list($ekipamendua)
        {
            $this->ekipList[count($this->ekipList)] = $ekipamendua;
        }
    }
    
?>