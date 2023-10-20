<?php
    class Kokalekua
    {
        public $etiketa;
        public $idGela;
        public $hdata;
        public $adata;

        function __construct($etiketa,$idGela,$hdata,$adata){
            $this->etiketa = $etiketa;
            $this->idGela = $idGela;
            $this->hdata = $hdata;
            $this->adata = $adata;
        }
    }
    
    class kokalekuList implements Listak
    {
        public $kokList;

        function __construct()
        {
            $this->kokList = [];
        }

        function informazioa_karga()
        {
            $sql = "SELECT * FROM 3wag2e1.kokalekua";
            // $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $conn = new DB("localhost","root","","3wag2e1");
            $emaitza = $conn->select($sql);
            if ($emaitza->num_rows > 0) {
                while ($row = $emaitza->fetch_assoc()) {
                    $kokalekua = new Kokalekua($row["etiketa"],$row["idGela"],$row["hasieraData"],$row["amaieraData"]);
                    $this->add_to_list($kokalekua);
                }
            }
            $conn->die();
        }

        function add_to_list($kokalekua)
        {
            $this->kokList[count($this->kokList)] = $kokalekua;
        }
    }    
?>