<?php
    include("DB.php");
    include("Listak_Inter.php");

    class Inbentarioa
    {
        public $etiketa;
        public $idEkipamendu;
        public $erosketaData;

        function __construct($etiketa,$idEkipamendu,$erosketaData){
            $this->etiketa = $etiketa;
            $this->idEkipamendu = $idEkipamendu;
            $this->erosketaData = $erosketaData;
        }
    }
    
    class InbentarioList implements Listak
    {
        public $inbList;

        function __construct()
        {
            $this->inbList = [];
        }

        function informazioa_karga($sql)
        {
            // $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $conn = new DB("localhost","root","","3wag2e1");
            $emaitza = $conn->select($sql);
            if ($emaitza->num_rows > 0) {
                while ($row = $emaitza->fetch_assoc()) {
                    $inbentarioa = new Inbentarioa($row["etiketa"],$row["izena"],$row["erosketaData"]);
                    $this->inbList[count($this->inbList)] = $inbentarioa;

                }
            }
            $conn->die();
        }

        function inbentario_info_kargatu(){
            $sql = "SELECT inbentarioa.etiketa, ekipamendua.izena, inbentarioa.erosketaData FROM inbentarioa, ekipamendua  WHERE inbentarioa.idEkipamendu = ekipamendua.id";
            $this->informazioa_karga($sql);
        }

        function inbentario_info_filtroz_kargatu($filtroa){
            $sql = "SELECT inbentarioa.etiketa, ekipamendua.izena, inbentarioa.erosketaData FROM inbentarioa, ekipamendua  WHERE inbentarioa.idEkipamendu = ekipamendua.id".$filtroa;
            $this->informazioa_karga($sql);
        }

        function inbent_ezabatu($etiketa){
            $sql = "DELETE FROM inbentarioa WHERE inbentarioa.etiketa = '". $etiketa . "'";
            $conn = new DB("localhost","root","","3wag2e1");
            $error = $conn->query($sql);
            $conn->die();
            return $error;
        }

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

        function add_inbent($idEkipamendu,$erosketaData){
            $etiketa = $this->generateRandomEtiketa();
            while($this->etiketaExists($etiketa)){
                $etiketa = $this->generateRandomEtiketa();
            }
            $sql = "INSERT INTO inbentarioa (etiketa, idEkipamendu, erosketaData) VALUES ('$etiketa', $idEkipamendu, '$erosketaData');";
            $conn = new DB("localhost", "root", "", "3wag2e1");
            $conn->query($sql);
            $sql = "SELECT ekipamendua.izena, ekipamendua.stock FROM ekipamendua WHERE ekipamendua.id = ".$idEkipamendu;
            $izena = "";
            $stock = 0;
            $emaitza = $conn->select($sql);
            if ($emaitza->num_rows > 0) {
                $row = $emaitza->fetch_assoc();
                $izena = $row["izena"];
                $stock = $row["stock"];
                $stock++;
                $sql = "UPDATE ekipamendua SET ekipamendua.stock = ".$stock." WHERE ekipamendua.id = ".$idEkipamendu;
                $conn->query($sql);
            }
            $conn->die();
            $inbentarioa = new Inbentarioa($etiketa, $izena, $erosketaData);
            $this->inbList[count($this->inbList)] = $inbentarioa; 
        }
        
        function etiketaExists($etiketa) {
            $sql = "SELECT inbentarioa.etiketa FROM inbentarioa WHERE inbentarioa.etiketa = '$etiketa';";
            $conn = new DB("localhost", "root", "", "3wag2e1");
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