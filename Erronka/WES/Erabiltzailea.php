<?php
    include("DB.php");

    class Erabiltzailea
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


        public function erabiltzailea_kargatu($erabiltzailea)
        {
            $sql = "SELECT * FROM 3wag2e1.erabiltzailea WHERE 3wag2e1.erabiltzailea.erabiltzailea = '".$erabiltzailea."'";
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

        public function erabiltzailea_sesion_kargatu($nan)
        {
            $sql = "SELECT * FROM 3wag2e1.erabiltzailea WHERE 3wag2e1.erabiltzailea.nan = '".$nan."'";
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

        function erabiltzailea_eguneratu($sql)
        {
            $conn = new DB("localhost","root","","3wag2e1");
            $error = $conn->query($sql);
            $conn->die();
            return $error;
        }
    }   
?>