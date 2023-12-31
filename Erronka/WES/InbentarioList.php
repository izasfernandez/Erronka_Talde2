<?php

    /**
     * Fitxategiak gehitzen ditu
     * DB.php
     * Listak_inter.php
     */
    include("DB.php");
    include("Listak_Inter.php");

    /**
     * Inbentarioa sortzen dituen gela da
     */
    class Inbentarioa
    {
        public $etiketa;
        public $idEkipamendu;
        public $erosketaData;

        /**
         * Inbentario gelaren konstruktorea
         * @access public
         * @param $etiketa - inbentarioaren etiketa
         * @param $idEkipamendu - inbentarioaren ekipamenduaren id
         * @param $erosketaData - inbentarioaren erosketa data
         */
        function __construct($etiketa,$idEkipamendu,$erosketaData){
            $this->etiketa = $etiketa;
            $this->idEkipamendu = $idEkipamendu;
            $this->erosketaData = $erosketaData;
        }
    }
    
    /**
     * Inbentarioaren arraya sortzen dituen gela da
     * Listak interfasea inplementatzen da
     */
    class InbentarioList implements Listak
    {
        public $inbList;

        /**
         * Inbentarioaren arraya gelaren konstruktorea
         * @access public
         */
        function __construct()
        {
            $this->inbList = [];
        }

        /**
         * Inbentarioaren informazioa kargatzen duen funtzioa da
         * @access public
         * @param $sql - Exekutatu behar den sql kontsulta
         */
        function informazioa_karga($sql)
        {
            $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $emaitza = $conn->select($sql);
            if ($emaitza->num_rows > 0) {
                while ($row = $emaitza->fetch_assoc()) {
                    $inbentarioa = new Inbentarioa($row["etiketa"],$row["izena"],$row["erosketaData"]);
                    $this->inbList[count($this->inbList)] = $inbentarioa;

                }
            }
            $conn->die();
        }

        /**
         * Kokalekuaren artikuluak kargatzen duen funtzioa da (sql sententzia)
         * @access public
         */
        function kokaleku_art_karga(){
            $sql = "SELECT inbentarioa.etiketa, ekipamendua.izena, inbentarioa.erosketaData FROM inbentarioa, ekipamendua WHERE inbentarioa.etiketa NOT IN (SELECT kokalekua.etiketa FROM kokalekua)";
            $this->informazioa_karga($sql);
        }

        /**
         * Kokalekuaren artikuluen kokalekuak kargatzen duen funtzioa da (sql sententzia)
         * @access public
         */
        function kokaleku_art_kok_karga(){
            $sql = "SELECT inbentarioa.etiketa, ekipamendua.izena, inbentarioa.erosketaData FROM inbentarioa, ekipamendua WHERE inbentarioa.etiketa IN (SELECT kokalekua.etiketa FROM kokalekua WHERE kokalekua.amaieraData IS NULL OR kokalekua.amaieraData < curdate()) AND inbentarioa.idEkipamendu = ekipamendua.id";
            $this->informazioa_karga($sql);
        }

        /**
         * Inbentarioaren artikuluak kargatzen duen funtzioa da (sql sententzia)
         * @access public
         */
        function inbentario_info_kargatu(){
            $sql = "SELECT inbentarioa.etiketa, ekipamendua.izena, inbentarioa.erosketaData FROM inbentarioa, ekipamendua  WHERE inbentarioa.idEkipamendu = ekipamendua.id";
            $this->informazioa_karga($sql);
        }

        /**
         * Inbentarioaren filtroak kargatzen duen funtzioa da (sql sententzia)
         * @access public
         * @param $filtroa - sql kontsultaren baldintza gehigarriak
         */
        function inbentario_info_filtroz_kargatu($filtroa){
            $sql = "SELECT inbentarioa.etiketa, ekipamendua.izena, inbentarioa.erosketaData FROM inbentarioa, ekipamendua  WHERE inbentarioa.idEkipamendu = ekipamendua.id".$filtroa;
            $this->informazioa_karga($sql);
        }

        /**
         * Inbentarioa ezabatzen duen funtzioa da (sql sententzia)
         * @access public
         * @param $etiketa - inbentarioaren etiketa
         * @return $error - kontsultaren emaitza
         */
        function inbent_ezabatu($etiketa){
            $sql = "UPDATE ekipamendua SET ekipamendua.stock = ekipamendua.stock-1 WHERE ekipamendua.id = (SELECT inbentarioa.idEkipamendu FROM inbentarioa WHERE inbentarioa.etiketa = '".$etiketa."')";
            $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $error = $conn->query($sql);
            $sql = "DELETE FROM inbentarioa WHERE inbentarioa.etiketa = '". $etiketa . "'";
            $error = $conn->query($sql);
            $conn->die();
            return $error;
        }

        /**
         * Inbentarioa eguneratzen duen funtzioa da (sql sententzia)
         * @access public
         * @param $etiketa - inbentarioaren etiketa zaharra
         * @param $etiketa_berria - inbentarioaren etiketa berria
         * @return $error - kontsultaren emaitza
         */
        function inbent_eguneratu($etiketa, $etiketa_berria){
            $sql = "UPDATE inbentarioa SET inbentarioa.etiketa = UPPER('".$etiketa_berria."') WHERE inbentarioa.etiketa = '".$etiketa."'";
            $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $error = $conn->query($sql);
            $conn->die();
            return $error;
        }

        /**
         * Etiketa aleatorio bat sortzen duen funtzioa (3 letra eta 3 zenbaki)
         * @access public
         * @return $etiketa - inbentarioaren etiketa
         */
        function generateRandomEtiketa() {
            $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $numbers = '0123456789';
            $etiketa = '';
        
            for ($i = 0; $i < 3; $i++) {
                $etiketa .= $letters[rand(0, strlen($letters) - 1)];
            }
        
            for ($i = 0; $i < 3; $i++) {
                $etiketa .= $numbers[rand(0, strlen($numbers) - 1)];
            }
            return $etiketa;
        }

        /**
         * Inbentarioan artikuluak gehitzen eta eguneratzen duen funtzioa da 
         * @access public
         * @param $idEkipamendu - inbentarioaren ekipamenduaren id
         * @param $erosketaData - inbentarioaren erosketa data
         * @return $exist - existitzen den edo ez
         */
        function add_inbent($idEkipamendu,$erosketaData){
            $etiketa = $this->generateRandomEtiketa();
            while($this->etiketaExists($etiketa)){
                $etiketa = $this->generateRandomEtiketa();
            }
            $conn = new DB("192.168.201.102", "talde2", "ikasle123", "3wag2e1");
            $sql = "SELECT ekipamendua.izena, ekipamendua.stock, ekipamendua.idKategoria FROM ekipamendua WHERE ekipamendua.id = ".$idEkipamendu;
            $izena = "ikasle123";
            $kat = "ikasle123";
            $stock = 0;
            $emaitza = $conn->select($sql);
            if ($emaitza->num_rows > 0) {
                $row = $emaitza->fetch_assoc();
                $izena = $row["izena"];
                $kat = $row["idKategoria"];
                $stock = $row["stock"];
                $stock++;
                $sql = "UPDATE ekipamendua SET ekipamendua.stock = ".$stock." WHERE ekipamendua.id = ".$idEkipamendu;
                $conn->query($sql);
            }
            $sql = "SELECT  kategoria.inb_yn FROM kategoria WHERE kategoria.id = ".$kat;
            $inb = false;
            $emaitza = $conn->select($sql);
            if ($emaitza->num_rows > 0) {
                $row = $emaitza->fetch_assoc();
                $inb_yn = $row["inb_yn"];
                if ($inb_yn == 1) {
                    $inb = true;
                }
            }
            if ($inb) {
                $sql = "INSERT INTO inbentarioa (etiketa, idEkipamendu, erosketaData) VALUES ('$etiketa', $idEkipamendu, '$erosketaData');";
                $conn->query($sql);
                $inbentarioa = new Inbentarioa($etiketa, $izena, $erosketaData);
                $this->inbList[count($this->inbList)] = $inbentarioa; 
            }
            $conn->die();
        }
        
        /**
         * Etiketa existitzen den begiratzen duen funtzioa da 
         * @access public
         * @param $etiketa
         * @return $exist - existitzen den edo ez
         */
        function etiketaExists($etiketa) {
            $sql = "SELECT inbentarioa.etiketa FROM inbentarioa WHERE inbentarioa.etiketa = '$etiketa';";
            $conn = new DB("192.168.201.102", "talde2", "ikasle123", "3wag2e1");
            $result = $conn->select($sql);
            $exist = false;
            if ($result->num_rows > 0) {
                $exist = true;
            }
            $conn->die();
            return $exist;
        }

        
    }
    
?>