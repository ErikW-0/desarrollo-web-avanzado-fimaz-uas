<?php
// Watson Rosales Jesus Erik
require_once("../../config/DataBase.php");

class torneosModel {
    public $PDO;

    public function __construct() {
        $connection = new DataBase();
        $this->PDO = $connection->connect();
    }

    public function insert($nombreTorneo, $organizador, $patrocinadores, $sede, $categoria, $premio1, $premio2, $premio3, $otroPremio, $usuario, $contrasena) {
        $sql = "INSERT INTO torneos 
                (nombre_torneo, organizador, patrocinadores, sede, categoria, premio1, premio2, premio3, otroPremio, usuario, contrasena) 
                VALUES 
                (:nombre, :org, :pat, :sede, :cat, :p1, :p2, :p3, :otro, :user, :pass)";

        $statement = $this->PDO->prepare($sql);
        $contrasena_encriptada = $this->passwordEncrypt($contrasena);

        $statement->bindParam(":nombre", $nombreTorneo);
        $statement->bindParam(":org", $organizador);
        $statement->bindParam(":pat", $patrocinadores);
        $statement->bindParam(":sede", $sede);
        $statement->bindParam(":cat", $categoria);
        $statement->bindParam(":p1", $premio1);
        $statement->bindParam(":p2", $premio2);
        $statement->bindParam(":p3", $premio3);
        $statement->bindParam(":otro", $otroPremio);
        $statement->bindParam(":user", $usuario);
        $statement->bindParam(":pass", $contrasena_encriptada);

        return ($statement->execute()) ? $this->PDO->lastInsertId() : false;
    }

    
    public function read() {
        $sql = "SELECT * FROM torneos ORDER BY id_torneo DESC"; 
        $statement = $this->PDO->prepare($sql);
        return ($statement->execute()) ? $statement->fetchAll() : false;
    }

        public function readOne($id) {
        $sql = "SELECT * FROM torneos WHERE id_torneo = :id LIMIT 1";
        $statement = $this->PDO->prepare($sql);
        $statement->bindParam(":id", $id);
        return ($statement->execute()) ? $statement->fetch() : false;
    }

   
    public function update($id, $nombre, $organizador, $pat, $sede, $cat, $p1, $p2, $p3, $otroPremio) {
        $sql = "UPDATE torneos SET nombre_torneo=:nombre, organizador=:org, patrocinadores=:pat, 
                sede=:sede, categoria=:cat, premio1=:p1, premio2=:p2, premio3=:p3, otroPremio=:otro 
                WHERE id_torneo = :id";
        
        $statement = $this->PDO->prepare($sql);
        $statement->bindParam(":id", $id);
        $statement->bindParam(":nombre", $nombre);
        $statement->bindParam(":org", $organizador);
        $statement->bindParam(":pat", $pat);
        $statement->bindParam(":sede", $sede);
        $statement->bindParam(":cat", $cat);
        $statement->bindParam(":p1", $p1);
        $statement->bindParam(":p2", $p2);
        $statement->bindParam(":p3", $p3);
        $statement->bindParam(":otro", $otroPremio);

        return ($statement->execute()) ? true : false;
    }

   
    public function delete($id) {
        $sql = "DELETE FROM torneos WHERE id_torneo = :id";
        $statement = $this->PDO->prepare($sql);
        $statement->bindParam(":id", $id);
        return ($statement->execute()) ? true : false;
    }

    public function passwordEncrypt($password){
        return password_hash($password, PASSWORD_DEFAULT);
    }
}