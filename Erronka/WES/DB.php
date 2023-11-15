<?php
    class DB{
        private $servername;
        private $username;
        private $password;
        private $db_conexioa;
        private $conn;

        function __construct ($servername,$username,$password,$db_conexioa)
        {
            $this->servername = $servername;
            $this->username = $username;
            $this->password = $password;
            $this->db_conexioa = $db_conexioa;
            $this->conn = new mysqli("localhost", "root", "", "3wag2e1");
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
            $sql = "USE 3wag2e1;";
            $this->query($sql);
        }

        public function select($sql)
        {
            $emaitza = $this->conn->query($sql);
            return $emaitza;
        }

        public function query($sql)
        {
            if ($this->conn->query($sql) === TRUE) {
                return "Query succesfull";
            } else {
                return "ERROR: " . $this->conn->error;
            }
        }

        public function die()
        {
            $this->conn->close();
        }
    }
?>