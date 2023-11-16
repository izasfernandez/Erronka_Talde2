<?php

    include("DB.php");
    include("Listak_Inter.php");

    class Kokalekua
    {
        public $etiketa;
        public $idGela;
        public $hdata;
        public $adata;
        public $izena;

        function __construct($etiketa,$idGela,$hdata,$adata,$izena){
            $this->etiketa = $etiketa;
            $this->idGela = $idGela;
            $this->hdata = $hdata;
            $this->adata = $adata;
            $this->izena = $izena;
        }
    }
    
    class kokalekuList implements Listak
    {
        public $kokList;

        function __construct()
        {
            $this->kokList = [];
        }

        function informazioa_karga($sql)
        {
            // $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
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

        function kokaleku_info_kargatu(){
            $sql = "SELECT ekipamendua.izena as ekipIzena, kokalekua.etiketa, gela.izena as gelaIzena, kokalekua.hasieraData, kokalekua.amaieraData 
            FROM kokalekua, gela, ekipamendua, inbentarioa  
            WHERE kokalekua.idGela = gela.id 
            AND inbentarioa.idEkipamendu = ekipamendua.id 
            AND inbentarioa.etiketa = kokalekua.etiketa";
            $this->informazioa_karga($sql);
        }

        function kokaleku_filtratu($filtro){
            $sql = "SELECT ekipamendua.izena as ekipIzena, kokalekua.etiketa, gela.izena as gelaIzena, kokalekua.hasieraData, kokalekua.amaieraData 
            FROM kokalekua, gela, ekipamendua, inbentarioa  
            WHERE kokalekua.idGela = gela.id 
            AND inbentarioa.idEkipamendu = ekipamendua.id 
            AND inbentarioa.etiketa = kokalekua.etiketa".$filtro;
            echo $sql;
            $this->informazioa_karga($sql);
        }

        function kokaleku_ezabatu($etiketa,$hasieraData){
            $sql = "DELETE FROM kokalekua WHERE kokalekua.etiketa = '". $etiketa . "' AND kokalekua.hasieraData = '". $hasieraData . "'";
            $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $error = $conn->query($sql);
            $conn->die();
            return $error;
        }

        function add_kokaleku($sql){
            $conn = new DB("192.168.201.102", "talde2", "ikasle123", "3wag2e1");
            $error = $conn->query($sql);
            $conn->die();
            return $error;
        }

        function kokaleku_eguneratu($sql) {
            $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $error = $conn->query($sql);
            $conn->die();
            return $error;
        }
    }    
?>