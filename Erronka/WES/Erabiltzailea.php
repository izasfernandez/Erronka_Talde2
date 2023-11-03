<?php
    include("DB.php");
    include("Listak_Inter.php");
    
    class Erabiltzailea implements Listak
    {
       public $nan;
       public $izena;
       public $abizena;
       public $erabiltzailea;
       public $pasahitza;
       public $rola;

       function __construct()
       {
            $this->nan = "";
            $this->izena = "";
            $this->abizena = "";
            $this->erabiltzailea = "";
            $this->pasahitza = "";
            $this->rola = "";
        }

        public function informazioa_karga($sql)
        {
            // $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $conn = new DB("localhost","root","","3wag2e1");
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
            }
            $conn->die();
        }



        public function erabiltzailea_kargatu($erabiltzailea)
        {
            $sql = "SELECT * FROM 3wag2e1.erabiltzailea WHERE 3wag2e1.erabiltzailea.erabiltzailea = '".$erabiltzailea."'";
            $this->informazioa_karga($sql);
        }

        public function erabiltzailea_sesion_kargatu($nan)
        {
            $sql = "SELECT * FROM 3wag2e1.erabiltzailea WHERE 3wag2e1.erabiltzailea.nan = '".$nan."'";
            $this->informazioa_karga($sql);
        }

        public function erabiltzailea_konprobatu($erabiltzailea)
        {
            $sql = "SELECT * FROM 3wag2e1.erabiltzailea WHERE 3wag2e1.erabiltzailea.erabiltzailea = '".$erabiltzailea."'";
            $exist = false;
            // $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $conn = new DB("localhost","root","","3wag2e1");
            $emaitza = $conn->select($sql);
            if ($emaitza->num_rows > 0) {
                $exist = true;
            }
            $conn->die();
            return $exist;
        }

        public function erabiltzailea_nan_konprobatu($nan)
        {
            $sql = "SELECT * FROM 3wag2e1.erabiltzailea WHERE 3wag2e1.erabiltzailea.nan = '".$nan."'";
            $exist = false;
            // $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $conn = new DB("localhost","root","","3wag2e1");
            $emaitza = $conn->select($sql);
            if ($emaitza->num_rows > 0) {
                $exist = true;
            }
            $conn->die();
            return $exist;
        }

        public function erabiltzaileak_kargatu()
        {
            $sql = "SELECT 3wag2e1.erabiltzailea.nan, 3wag2e1.erabiltzailea.izena, 3wag2e1.erabiltzailea.abizena FROM 3wag2e1.erabiltzailea";
            // $conn = new DB("192.168.201.102","talde2","ikasle123","3wag2e1");
            $conn = new DB("localhost","root","","3wag2e1");
            $kontsulta = $conn->select($sql);
            $emaitza = $kontsulta->fetch_all(MYSQLI_ASSOC);
            $conn->die();
            return $emaitza;
        }

        function ezabatu($sql)
        {
            $conn = new DB("localhost","root","","3wag2e1");
            $error = $conn->query($sql);
            $conn->die();
            return $error;
        }

        function gehitu($sql)
        {
            $conn = new DB("localhost","root","","3wag2e1");
            $error = $conn->query($sql);
            $conn->die();
            return $error;
        }

        function eguneratu($sql)
        {
            $conn = new DB("localhost","root","","3wag2e1");
            $error = $conn->query($sql);
            $conn->die();
            return $error;
        }
    }   
?>