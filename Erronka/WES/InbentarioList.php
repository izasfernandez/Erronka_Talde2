<?php
    include("DB.php");
    include("Listak_Inter.php");

    class Inbentarioa
    {
        public $etiketa;
        public $idEkipamendua;
        public $erosketaData;

        function __construct($etiketa,$idEkipamendua,$erosketaData){
            $this->etiketa = $etiketa;
            $this->idEkipamendua = $idEkipamendua;
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
                    $inbentarioa = new Inbentarioa($row["etiketa"],$row["idEkipamendu"],$row["erosketaData"]);
                    $this->inbList[count($this->inbList)] = $inbentarioa;

                }
            }
            $conn->die();
        }

        function inbentario_info_kargatu(){
            $sql = "SELECT * FROM 3wag2e1.inbentarioa";
            $this->informazioa_karga($sql);
        }

        function inbent_ezabatu($etiketa){
            $sql = "DELETE FROM 3wag2e1.inbentarioa WHERE 3wag2e1.inbentarioa.etiketa = '". $etiketa . "'";
            $conn = new DB("localhost","root","","3wag2e1");
            $error = $conn->query($sql);
            $conn->die();
            return $error;
        }
    }
    
?>