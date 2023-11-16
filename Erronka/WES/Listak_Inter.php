<?php
    /**
     * Arrayentzako Interfazea da
     */
    interface Listak{
        /**
         * informazioa kargatzen duen funtzioa guztiek derrigorrez edukitzeko
         */
        public function informazioa_karga($sql); 
        // public function ezabatu($sql); 
        // public function gehitu($sql); 
        // public function eguneratu($sql); 
    }
?>