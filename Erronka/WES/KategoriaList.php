<?php
    class kategoriaList implements Listak
    {
        public $katList;

        function __construct()
        {
            $this->katList = [];
        }

        function informazioa_karga()
        {
            $sql = "SELECT * FROM 3wag2e1.kategoria";
            // $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $conn = new DB("localhost","root","","3wag2e1");
            $emaitza = $conn->select($sql);
            if ($emaitza->num_rows > 0) {
                while ($row = $emaitza->fetch_assoc()) {
                    $kategoria = new Kategoria($row["id"],$row["izena"]);
                    $this->add_to_list($kategoria);
                }
            }
            $conn->die();
        }

        function add_to_list($kategoria)
        {
            $this->katList[count($this->katList)] = $kategoria;
        }
    }
    
?>