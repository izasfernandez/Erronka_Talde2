<?php
    /**
     * Fitxategiak gehitzen ditu
     * DB.php
     * Listak_inter.php
     */
    include("DB.php");
    include("Listak_Inter.php");
    
    /**
     * Erabiltzaileak sortzen dituen gela da
     * Listak interfasea inplementatzen da
     */
    class Erabiltzailea implements Listak
    {
       public $nan;
       public $izena;
       public $abizena;
       public $erabiltzailea;
       public $pasahitza;
       public $rola;

        /**
        * Erabiltzailea gelaren konstruktorea
        * @access public
        */
       function __construct()
       {
            $this->nan = "";
            $this->izena = "";
            $this->abizena = "";
            $this->erabiltzailea = "";
            $this->pasahitza = "";
            $this->rola = "";
        }
        
        /**
         * Erabiltzaileen informazioa kargatzen duen funtzioa da
         * @access public
         * @param $sql
         * @return boolean
         */
        public function informazioa_karga($sql)
        {
            $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $emaitza = $conn->select($sql);
            if ($emaitza->num_rows > 0) {
                while ($row = $emaitza->fetch_assoc()) {
                    $this->nan = $row["nan"];
                    $this->izena = $row["izena"];
                    $this->abizena = $row["abizena"];
                    $this->erabiltzailea = $row["erabiltzailea"];
                    $this->pasahitza = $row["pasahitza"];
                    $this->rola = $row["rola"];
                }
                return true;
            }else{
                return false;
            }
            $conn->die();
        }

        /**
         * Erabiltzailea kargatzen duen funtzioa da
         * @access public
         * @param $erabiltzailea
         * @return $error
         */
        public function erabiltzailea_kargatu($erabiltzailea)
        {
            $sql = "SELECT * FROM erabiltzailea WHERE erabiltzailea.erabiltzailea = '".$erabiltzailea."'";
            $error = $this->informazioa_karga($sql);
            return $error;
        }

        /**
         * Erabiltzailearen sesioa kargatzen duen funtzioa da
         * @access public
         * @param $nan
         */
        public function erabiltzailea_sesion_kargatu($nan)
        {
            $sql = "SELECT * FROM erabiltzailea WHERE erabiltzailea.nan = '".$nan."'";
            $this->informazioa_karga($sql);
        }

        /**
         * Erabiltzailea existitzen den konprobatzen duen funtzioa da
         * @access public
         * @param $erabiltzailea
         * @return $exist
         */
        public function erabiltzailea_konprobatu($erabiltzailea)
        {
            $sql = "SELECT * FROM erabiltzailea WHERE erabiltzailea.erabiltzailea = '".$erabiltzailea."'";
            $exist = false;
            // $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $emaitza = $conn->select($sql);
            if ($emaitza->num_rows > 0) {
                $exist = true;
            }
            $conn->die();
            return $exist;
        }

        /**
         * Erabiltzailearen nan-a existitzen den konprobatzen duen funtzioa da
         * @access public
         * @param $nan
         * @return $exist
         */
        public function erabiltzailea_nan_konprobatu($nan)
        {
            $sql = "SELECT * FROM erabiltzailea WHERE erabiltzailea.nan = '".$nan."'";
            $exist = false;
            // $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $emaitza = $conn->select($sql);
            if ($emaitza->num_rows > 0) {
                $exist = true;
            }
            $conn->die();
            return $exist;
        }

        /**
         * Erabiltzaileak kargatzen duen funtzioa da
         * @access public
         * @return $emaitza
         */
        public function erabiltzaileak_kargatu()
        {
            $sql = "SELECT erabiltzailea.nan, erabiltzailea.izena, erabiltzailea.abizena FROM erabiltzailea";
            // $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $kontsulta = $conn->select($sql);
            $emaitza = $kontsulta->fetch_all(MYSQLI_ASSOC);
            $conn->die();
            return $emaitza;
        }

        /**
         * Erabiltzailea ezabatzen duen funtzioa da
         * @access public
         * @param $sql
         * @return $error
         */
        function ezabatu($sql)
        {
            $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $error = $conn->query($sql);
            $conn->die();
            return $error;
        }

        /**
         * Erabiltzailea gehitzen duen funtzioa da
         * @access public
         * @param $sql
         * @return $error
         */
        function gehitu($sql)
        {
            $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $error = $conn->query($sql);
            $conn->die();
            return $error;
        }

        /**
         * Erabiltzailea eguneratzen duen funtzioa da
         * @access public
         * @param $sql
         * @return $error
         */
        function eguneratu($sql)
        {
            $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $error = $conn->query($sql);
            $conn->die();
            return $error;
        }

        function nan_konprobaketa($nan){
            $nan_zenb = intval(preg_replace('/^[A-Z]/','',$nan));
            $nan_letra = preg_replace('/^[0-9]+/','',$nan);
            $correcto = false;
            if (strlen(strval($nan_zenb)) == 8 && strlen($nan_letra) == 1) {
                $hondarra = fmod($nan_zenb,23);
                if (strtoupper($nan_letra) == nan_hizkia($hondarra)) {
                    $correcto = true;
                }
            }
            return $correcto;   
        }
    
        function nan_hizkia($i_hondarra){
            switch ($i_hondarra) {
                case 0:
                    return "T";
                    break;
                case 1:
                    return "R";
                    break;
                case 2:
                    return "W";
                    break;
                case 3:
                    return "A";
                    break;
                case 4:
                    return "G";
                    break;
                case 5:
                    return "M";
                    break;
                case 6:
                    return "Y";
                    break;
                case 7:
                    return "F";
                    break;
                case 8:
                    return "P";
                    break;
                case 9:
                    return "D";
                    break;
                case 10:
                    return "X";
                    break;
                case 11:
                    return "B";
                    break;
                case 12:
                    return "N";
                    break;
                case 13:
                    return "J";
                    break;
                case 14:
                    return "Z";
                    break;
                case 15:
                    return "S";
                    break;
                case 16:
                    return "Q";
                    break;
                case 17:
                    return "V";
                    break;
                case 18:
                    return "H";
                    break;
                case 19:
                    return "L";
                    break;
                case 20:
                    return "C";
                    break;
                case 21:
                    return "K";
                    break;
                case 22:
                    return "E";
                    break;
            }
        }
    }   
?>