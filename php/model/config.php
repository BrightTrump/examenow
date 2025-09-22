<?php 
session_start();
class config{
     public $host = "localhost";
     public $user = "u787607796_examenow";
     public $password = "Examenow1234@";
     public $database = "u787607796_examenow";
    // public $host = "localhost";
    // public $user = "root";
    // public $password = "";
    // public $database = "examenow";

    public $connection;

    public function __construct(){
        $this->connection = new mysqli($this->host, $this->user, $this->password, $this->database);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function getConnection() {
        return $this->connection;
    }
     public $url = "https://taketest.online"; 
}
