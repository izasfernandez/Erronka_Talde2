<?php
    /**
     * Fitxategiak gehitzen ditu
     * DB.php
     * Listak_Inter.php
     */
    include("DB.php");
    include("Listak_Inter.php");

    /**
     * Kokalekua sortzen duen gela da
     */
    class Kokalekua
    {
        public $etiketa;
        public $idGela;
        public $hdata;
        public $adata;
        public $izena;

        /**
         * Kokalekuaren konstruktorea
         * @access public
         * @param $etiketa - kokalekuaren etiketa
         * @param $idGela - kokalekuaren gelaren id
         * @param $hdata - kokalekuaren hasiera data
         * @param $adata - kokalekuaren amaiera data
         * @param $izena - kokalekuaren ekipamenduaren izena
         */
        function __construct($etiketa,$idGela,$hdata,$adata,$izena){
            $this->etiketa = $etiketa;
            $this->idGela = $idGela;
            $this->hdata = $hdata;
            $this->adata = $adata;
            $this->izena = $izena;
        }
    }
    
    /**
     * Kokaleku arraia sortzen duen gela da
     * Listak interfasea inplementatzen da
     */
    class kokalekuList implements Listak
    {
        public $kokList;

        /**
         * Kokalekuaren arrayaren konstruktorea
         * @access public
         */
        function __construct()
        {
            $this->kokList = [];
        }

        /**
         * Kokalekua kargatzen duen funtzioa
         * @access public
         * @param $sql - Exekutatu behar den sql kontsulta
         */
        function informazioa_karga($sql)
        {
            $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $emaitza = $conn->select($sql);
            if ($emaitza->num_rows > 0) {
                while ($row = $emaitza->fetch_assoc()){
                    $kokalekua = new Kokalekua($row["etiketa"],$row["gelaIzena"],$row["hasieraData"],$row["amaieraData"],$row["ekipIzena"]);
                    $this->kokList[count($this->kokList)] = $kokalekua;
                }
            }
            $conn->die();
        }

        /**
         * Kokalekuaren informazioa kargatzen duen funtzioa
         * @access public
         */
        function kokaleku_info_kargatu(){
            $sql = "SELECT ekipamendua.izena as ekipIzena, kokalekua.etiketa, gela.izena as gelaIzena, kokalekua.hasieraData, kokalekua.amaieraData 
            FROM kokalekua, gela, ekipamendua, inbentarioa  
            WHERE kokalekua.idGela = gela.id 
            AND inbentarioa.idEkipamendu = ekipamendua.id 
            AND inbentarioa.etiketa = kokalekua.etiketa";
            $this->informazioa_karga($sql);
        }

        /**
         * Kokalekuaren informazioa filtratzen duen funtzioa
         * @access public
         * @param $filtro - kontsultaren baldintza gehigarriak
         */
        function kokaleku_filtratu($filtro){
            $sql = "SELECT ekipamendua.izena as ekipIzena, kokalekua.etiketa, gela.izena as gelaIzena, kokalekua.hasieraData, kokalekua.amaieraData 
            FROM kokalekua, gela, ekipamendua, inbentarioa  
            WHERE kokalekua.idGela = gela.id 
            AND inbentarioa.idEkipamendu = ekipamendua.id 
            AND inbentarioa.etiketa = kokalekua.etiketa".$filtro;
            $this->informazioa_karga($sql);
        }

        /**
         * Kokalekua ezabatzen duen funtzioa
         * @access public
         * @param $etiketa - kokalekuaren etiketa
         * @param $hasieraData - kokalekuaren hasiera data
         * @return $error - kontsultaren emaitza
         */
        function kokaleku_ezabatu($etiketa,$hasieraData){
            $sql = "DELETE FROM kokalekua WHERE kokalekua.etiketa = '". $etiketa . "' AND kokalekua.hasieraData = '". $hasieraData . "'";
            $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $error = $conn->query($sql);
            $conn->die();
            return $error;
        }

        /**
         * Kokalekua gehitzen duen funtzioa
         * @access public
         * @param $sql - Exekutatu behar den sql kontsulta
         * @return $error - kontsultaren emaitza
         */
        function add_kokaleku($sql){
            $conn = new DB("192.168.201.102", "talde2", "ikasle123", "3wag2e1");
            $error = $conn->query($sql);
            $conn->die();
            return $error;
        }

        /**
         * Kokalekua eguneratzen duen funtzioa
         * @access public
         * @param $sql - Exekutatu behar den sql kontsulta
         * @return $error - kontsultaren emaitza
         */
        function kokaleku_eguneratu($sql) {
            $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $error = $conn->query($sql);
            $conn->die();
            return $error;
        }
    }    
?>