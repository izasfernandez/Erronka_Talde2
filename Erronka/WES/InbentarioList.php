<?php
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

        function informazioa_karga()
        {
            $sql = "SELECT * FROM 3wag2e1.inbentarioa";
            // $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $conn = new DB("localhost","root","","3wag2e1");
            $emaitza = $conn->select($sql);
            if ($emaitza->num_rows > 0) {
                while ($row = $emaitza->fetch_assoc()) {
                    $inbentarioa = new Inbentarioa($row["etiketa"],$row["idEkipamendu"],$row["erosketaData"]);
                    $this->add_to_list($inbentarioa);
                }
            }
            $conn->die();
        }

        function add_to_list($inbentarioa)
        {
            $this->inbList[count($this->inbList)] = $inbentarioa;
        }
    }
    
?>