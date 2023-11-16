<?php
    /** 
    * Datu-basearen konexioa egiteko funtzioa betetzen du. 
    */
    class DB{
        private $servername;
        private $username;
        private $password;
        private $db_conexioa;
        private $conn;
        
        /**
         * DB gelaren sortzailea, “if” batekin errore bat sortzeko, konexioarekin arazoak daudenean mezu hori ateratzeko. 
         * @access public
         * @param $servername
         * @param $username
         * @param $password
         * @param $db_conexioa
         */
        function __construct ($servername,$username,$password,$db_conexioa)
        {
            $this->servername = $servername;
            $this->username = $username;
            $this->password = $password;
            $this->db_conexioa = $db_conexioa;
            $this->conn = new mysqli($servername, $username, $password, $db_conexioa);
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
            $sql = "USE 3wag2e1;";
            $this->query($sql);
        }

        /**
         * SQL sententziak hartzen dituen funtzioa da, haren emaitzak bueltatzen ditu
         * @access public
         * @param $sql
         * @return $emaitza
         */
        public function select($sql)
        {
            $emaitza = $this->conn->query($sql);
            return $emaitza;
        }

        /**
         * Datuak bueltatzen ez diuen SQL sententziak hartzen ditu eta ondo edo txarto egin den bidaltzen du
         * @access public
         * @param $sql
         * @return $error or @return string
         */
        public function query($sql)
        {
            if ($this->conn->query($sql) === TRUE) {
                return "Query succesfull";
            } else {
                return "ERROR: " . $this->conn->error;
            }
        }

        /**
         * Konexioa ixten duen funtzioa
         * @access public
         */
        public function die()
        {
            $this->conn->close();
        }
    }
?>