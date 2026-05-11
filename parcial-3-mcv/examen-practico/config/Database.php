<?php
// Watson Rosales Jesus Erik
class Database {
    private $host = "localhost";
    private $dbname = "db_ew";
    private $username = "root";
    private $password = "";
    private $connection;

    public function __construct() {
        
    }
    public function connect(){
        try {
            $PDO = new PDO("mysql:host=".$this->host.";dbname=".$this->db, $this->user, $this->password);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}    
?>