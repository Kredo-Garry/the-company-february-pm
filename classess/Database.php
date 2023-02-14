<?php
    # Define the class
    class Database{
        # Define the connection properties
        private $db_server_name = "localhost"; //127.0.0.1
        private $db_username = "root"; //default
        private $db_password = ""; // default in XAMMP it empty, in MAMP = 'root'
        private $database_name = "the_company_february_pm";
        protected $conn;

        # Define constructor
        public function __construct(){
            $this->conn = new mysqli($this->db_server_name, $this->db_username, $this->db_password, $this->database_name);

            if ($this->conn->connect_error) {
                die("Unable to connect to the database. " . $this->conn->connect_error);
            }
        }
    }
?>