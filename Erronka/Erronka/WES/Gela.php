<?php 
    class Gela
    {
        public $id;
        public $izena;
        public $taldea;

        function __construct($id,$izena,$taldea){
            $this->id = $id;
            $this->izena = $izena;
            $this->taldea = $taldea;
        }
    }

?>