<?php

    /**
     * Fitxategiak gehitzen ditu
     * DB.php
     * Listak_inter.php
     */
    include("DB.php");
    include("Listak_Inter.php");

    /**
     * Kategoriak sortzen dituen gela da
     */
    class Kategoria
    {
        public $id;
        public $izena;

        /**
         * Kategoriaren gelaren konstruktorea
         * @access public
         * @param $id
         * @param $izena
         */
        function __construct($id,$izena){
            $this->id = $id;
            $this->izena = $izena;
        }
    }
    
    /**
     * Kategoriaren arraya sortzen dituen gela da
     * Listak interfasea inplementatzen da
     */
    class kategoriaList implements Listak
    {
        public $katList;

        /**
         * Kategoriaren arraya gelaren konstruktorea
         * @access public
         */
        function __construct()
        {
            $this->katList = [];
        }

        /**
         * Kategoriaren informazioa kargatzen duen funtzioa da
         * @access public
         * @param $sql
         */
        function informazioa_karga($sql)
        {
            $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $emaitza = $conn->select($sql);
            if ($emaitza->num_rows > 0) {
                while ($row = $emaitza->fetch_assoc()) {
                    $kategoria = new Kategoria($row["id"],$row["izena"]);
                    $this->katList[count($this->katList)] = $kategoria;
                }
            }
            $conn->die();
        }

        /**
         * Kategoriaren id handiena esaten duen funtzioa
         * @access public
         * @return $id_kat
         */
        function id_max()
        {
            $sql = "SELECT MAX(kategoria.id) as max FROM kategoria";
            $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $emaitza = $conn->select($sql);
            $id_kat = 0;
            if ($emaitza->num_rows > 0) {
                while ($row = $emaitza->fetch_assoc()) {
                    $id_kat = $row["max"];
                }
            }
            $conn->die();
            $id_kat++;
            return $id_kat;
        }

        /**
         * Kategoria konprobatzen duen funtzioa
         * @access public
         * @param $izena
         * @return $error
         */
        function kategoria_konprobatu($izena)
        {
            $sql = "SELECT kategoria.id FROM kategoria WHERE LOWER(kategoria.izena) = '".$izena."'";
            $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $emaitza = $conn->select($sql);
            $error = false;
            if ($emaitza->num_rows > 0) {
                $error = true;
            }
            $conn->die();
            return $error;
        }

        function kategoria_konprobatu_eguneratu($izena, $id)
        {
            $sql = "SELECT kategoria.id FROM kategoria WHERE LOWER(kategoria.izena) = '".$izena."' AND kategoria.id != ".$id;
            $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $emaitza = $conn->select($sql);
            $error = false;
            if ($emaitza->num_rows > 0) {
                $error = true;
            }
            $conn->die();
            return $error;
        }

        /**
         * Kategoria kargatzen duen funtzioa (sql sententzia)
         * @access public
         */
        function kategoria_kargatu()
        {
            $sql = "SELECT * FROM kategoria";
            $this->informazioa_karga($sql);
        }

        /**
         * Kategoriaren izena kargatzen duen funtzioa (sql sententzia)
         * @access public
         * @param $id
         */
        function kategoria_izena_kargatu($id)
        {
            $sql = "SELECT * FROM kategoria WHERE kategoria.id = ".$id;
            $this->informazioa_karga($sql);
        }

        /**
         * Kategoria gehitzen duen funtzioa
         * @access public
         * @param $sql
         * @return $error
         */
        function kategoria_gehitu($sql)
        {
            $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $error = $conn->query($sql);
            $conn->die();
            return $error;
        }

        /**
         * Kategoria ezabatzen duen funtzioa
         * @access public
         * @param $sql
         * @return $error
         */
        function kategoria_ezabatu($sql)
        {
            $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $error = $conn->query($sql);
            $conn->die();
            return $error;
        }

        /**
         * Kategoria eguneratzen duen funtzioa
         * @access public
         * @param $sql
         * @return $error
         */
        function kategoria_eguneratu($sql)
        {
            $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $error = $conn->query($sql);
            $conn->die();
            return $error;
        }

    }
    
?>