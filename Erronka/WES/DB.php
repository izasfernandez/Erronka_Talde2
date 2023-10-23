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
            $this->conn = new mysqli($servername, $username, $password, $db_conexioa);
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
        }

        public function select($sql)
        {
            $emaitza = $this->conn->query($sql);
            return $emaitza;
        }

        public function query($sql)
        {
            $this->conn->query($sql);
            if ($this->conn->query($sql) === TRUE) {
                return "Artikulua eguneratu da";
            } else {
                return "Error updating record: " . $this->conn->error;
            }
              
        }

        // public function multy_query($sql)
        // {
        //     $this->conn->multy_query($sql);
        // }

        // public function prepared_statement($sql,$mota,$args)
        // {
        //     $stmt = $this->conn->prepare($sql);
        //     $stmt->bind_param($mota, $args);
        //     $stmt->execute();
        //     $stmt->close();
        // }

        public function die()
        {
            $this->conn->close();
        }
    }
?>