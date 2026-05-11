<?php
// Watson Rosales Jesus Erik
class Database {
    private $host = "localhost";
    private $db = "db_ew";
    private $user = "root";
    private $password = "";
    private $connection;

    public function __construct() {
        
    }
    public function connect() {
    try {
       
        $this->connection = new PDO("mysql:host=".$this->host.";dbname=".$this->db, $this->user, $this->password);
        return $this->connection; 
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}
}    
?>