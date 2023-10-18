<?php
    class EkipamenduList implements Listak
    {
        public $ekipList;

        function __construct()
        {
            $this->ekipList = [];
        }

        function informazioa_karga()
        {
            $sql = "SELECT * FROM 3wag2e1.ekipamendua";
            // $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $conn = new DB("localhost","root","","3wag2e1");
            $emaitza = $conn->select($sql);
            if ($emaitza->num_rows > 0) {
                while ($row = $emaitza->fetch_assoc()) {
                    $ekipamendua = new Ekipamendua($row["id"],$row["izena"],$row["deskribapena"],$row["marka"],$row["modelo"],$row["stock"],$row["idstock"]);
                    $this->add_to_list($ekipamendua);
                }
            }
            $conn->die();
        }

        function add_to_list($ekipamendua)
        {
            $this->ekipList[count($this->ekipList)] = $ekipamendua;
        }
    }
    
?>