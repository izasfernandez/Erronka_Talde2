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
?>