<?php
    /**
     * Fitxategiak gehitzen ditu
     * DB.php
     * Listak_inter.php
     */
    include("DB.php");
    include("Listak_Inter.php");

    /**
     * Ekipamendua sortzen duen gela da
     */
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

        /**
         * Ekipamenduaren konstruktorea
         * @access public
         * @param $id
         * @param $izena
         * @param $deskribapena
         * @param $marka
         * @param $modeloa
         * @param $stock
         * @param $idKategoria
         * @param $url
         */
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

    /**
     * Ekipamenduaren arraya sortzen duen gela da
     */
    class EkipamenduList implements Listak
    {
        public $ekipList;

        /**
         * Ekipamenduaren arrayaren konstruktorea
         */
        function __construct()
        {
            $this->ekipList = [];
        }

        /**
         * Ekipamenduaren informazioa kargatzen duen funtzioa 
         * @access public
         * @param $sql
         */
        function informazioa_karga($sql)
        {
            $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $emaitza = $conn->select($sql);
            if ($emaitza->num_rows > 0) {
                while ($row = $emaitza->fetch_assoc()) {
                    $ekipamendua = new Ekipamendua($row["id"],$row["izena"],$row["deskribapena"],$row["marka"],$row["modelo"],$row["stock"],$row["idKategoria"],$row["img_url"]);
                    $this->ekipList[count($this->ekipList)] = $ekipamendua;
                }
            }
            $conn->die();
        }

        /**
         * Artikuluen informazioa kargatzen duen funtzioa da
         * @access public
         * @param $id
         * @return boolean
         */
        function artikulu_info_kargatu($id)
        {
            $sql = "SELECT * FROM ekipamendua WHERE ekipamendua.id = ".$id;
            $this->informazioa_karga($sql);
        }

        /**
         * Artikuluak kargatzen dituen funtzioa da
         * @access public
         */
        function artikuluak_kargatu()
        {
            $sql = "SELECT * FROM ekipamendua";
            $this->informazioa_karga($sql);
        }

        /**
         * Artikuluak filtratzen dituen funtzioa da
         * @access public
         * @param $queryFiltroa
         */
        function artikuluak_filtratu($queryFiltroa)
        {
            $sql = "SELECT * FROM ekipamendua".$queryFiltroa;
            $this->informazioa_karga($sql);
        }

        /**
         * Artikuluak eguneratzen dituen funtzioa da
         * @access public
         * @param $sql
         * @return $error
         */
        function eguneratu($sql)
        {
            $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $error = $conn->query($sql);
            $conn->die();
            return $error;
        }

        /**
         * Markak kargatzen dituen funtzioa da
         * @access public
         * @return $markak
         */
        function markak_kargatu()
        {
            $sql = "SELECT DISTINCT(ekipamendua.marka) FROM ekipamendua;";
            $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $kontsulta = $conn->select($sql);
            $markak = $kontsulta->fetch_all(MYSQLI_ASSOC);
            $conn->die();
            return $markak;
        }

        /**
         * Ekipamendua ezabatzen duen funtzioa da
         * @access public
         * @param $sql
         * @return $error
         */
        function ezabatu($sql)
        {
            $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $error = $conn->query($sql);
            $conn->die();
            return $error;
        }

        /**
         * Ekipamendua gehitzen duen funtzioa da
         * @access public
         * @param $izena
         * @param $desk
         * @param $marka
         * @param $model
         * @param $url
         * @param $kat
         * @param $stck
         * @return $ekipamendua
         */
        function add($izena,$desk,$marka,$model,$url,$kat,$stck)
        {
            $id = 0;
            $sql = "SELECT MAX(ekipamendua.id) AS id FROM ekipamendua;";
            $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $kontsulta = $conn->select($sql);
            if ($kontsulta->num_rows > 0) {
                while ($row = $kontsulta->fetch_assoc()) {
                    $id = $row["id"] + 1;
                }
            }
            $conn->die();
            $sql = "INSERT INTO ekipamendua VALUES($id,'$izena','$desk','$marka','$model',$stck,$kat,'$url');";
            $this->gehitu($sql);
            $ekipamendua = new Ekipamendua($id,$izena,$desk,$marka,$model,$stck,$kat,$url);
            return $ekipamendua;
        }

        /**
         * Ekipamendua gehitzeko bidaltzen duen sql-aren funtzioa da
         * @access public
         * @param $sql
         */
        function gehitu($sql)
        {
            $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $conn->query($sql);
            $conn->die();
        }

        /**
         * Ekipamenduaren izena existitzen den konprobatzen duen funtzioa da
         * @access public
         * @param $izena
         * @return $exist
         */
        function izena_existitu($izena)
        {
            $sql = "SELECT * FROM ekipamendua WHERE LOWER(ekipamendua.izena) = LOWER(".$izena.")";
            $exist = false;
            // $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $emaitza = $conn->select($sql);
            if ($emaitza->num_rows > 0) {
                $exist = true;
            }
            $conn->die();
            return $exist;
        }
    }

      
?>