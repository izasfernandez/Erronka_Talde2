<?php
    class GelaList implements Listak
    {
        public $gelList;

        function __construct()
        {
            $this->gelList = [];
        }

        function informazioa_karga()
        {
            $sql = "SELECT * FROM 3wag2e1.gela";
            // $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $conn = new DB("localhost","root","","3wag2e1");
            $emaitza = $conn->select($sql);
            if ($emaitza->num_rows > 0) {
                while ($row = $emaitza->fetch_assoc()) {
                    $gela = new Gela($row["id"],$row["izena"],$row["taldea"]);
                    $this->add_to_list($gela);
                }
            }
            $conn->die();
        }

        function add_to_list($gela)
        {
            $this->gelList[count($this->gelList)] = $gela;
        }
    }
    
?>