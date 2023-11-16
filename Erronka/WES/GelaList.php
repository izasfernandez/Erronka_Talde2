<?php

    /**
     * Fitxategiak gehitzen ditu
     * DB.php
     * Listak_inter.php
     */
    include("Listak_Inter.php");
    include("DB.php");

    /**
     * Gela sortzen dituen gela da
     */
    class Gela
    {
        public $id;
        public $izena;
        public $taldea;

        /**
         * Gela gelaren konstruktorea
         * @access public
         * @param $id
         * @param $izena
         * @param $taldea
         */
        function __construct($id,$izena,$taldea){
            $this->id = $id;
            $this->izena = $izena;
            $this->taldea = $taldea;
        }
    }

    /**
     * Gelaren arraya sortzen dituen gela da
     * Listak interfasea inplementatzen da
     */
    class GelaList implements Listak
    {
        public $gelList;

        /**
         * Gelaren arraya gelaren konstruktorea
         * @access public
         */
        function __construct()
        {
            $this->gelList = [];
        }

        /**
         * Gelaren informazioa kargatzen duen funtzioa da
         * @access public
         * @param $sql
         */
        function informazioa_karga($sql)
        {
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

        /**
         * Gelak filtroan kargatzen duen funtzioa da (sql sententzia)
         * @access public
         */
        function gela_kargatu()
        {
            $sql = "SELECT * FROM gela";
            $this->informazioa_karga($sql);
        }

        /**
         * Gelaren informazioa kargatzen duen funtzioa da
         * @access public
         * @param $id
         */
        function gela_info_kargatu($id)
        {
            $sql = "SELECT * FROM gela WHERE gela.id = ".$id;
            $this->informazioa_karga($sql);
        }

        /**
         * Gelaren ezabatzen duen funtzioa da
         * @access public
         * @param $sql
         * @return $error
         */
        function gela_ezabatu($sql)
        {
            $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $error = $conn->query($sql);
            $conn->die();
            return $error;
        }

        /**
         * Gelaren informazioa eguneratzen duen funtzioa da
         * @access public
         * @param $sql
         */
        function gela_eguneratu($sql)
        {
            $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $error = $conn->query($sql);
            $conn->die();
            return $error;
        }

        /**
         * Gelaren id handiena esaten duen funtzioa
         * @access public
         * @return $id_gela
         */
        function id_max()
        {
            $sql = "SELECT MAX(gela.id) as max FROM gela";
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

        /**
         * Gela gehitzen duen funtzioa da
         * @access public
         * @param $sql
         * @return $error
         */
        function gela_gehitu($sql)
        {
            $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $error = $conn->query($sql);
            $conn->die();
            return $error;
        }
    }
?>