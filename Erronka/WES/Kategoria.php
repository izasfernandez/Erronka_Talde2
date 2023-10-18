<?php 

    class Kategoria
    {
        public $id;
        public $izena;

        function __construct($id,$izena){
            $this->id = $id;
            $this->izena = $izena;
        }
    }
    

?>