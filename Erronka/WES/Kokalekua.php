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
?>