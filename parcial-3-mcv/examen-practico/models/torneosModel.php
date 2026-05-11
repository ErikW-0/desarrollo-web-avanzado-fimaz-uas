<?php

require_once("../../config/DataBase.php");

class torneosModel {

    public $PDO;

    public function __construct() {
        $connection = new DataBase();
        $this->PDO = $connection->connect();
    }

    public function insert($nombreTorneo, $organizador, $patrocinadores, $sede, $categoria, $premio1, $premio2, $premio3, $usuario, $contraseña) {

        $statement = $this->PDO->prepare("INSERT INTO torneos VALUES(null, :nombreTorneo, :organizador, :patrocinadores, :sede, :categoria, :premio1, :premio2, :premio3, :otroPremio, :usuario, :contraseña)");

        $contraseña = $this->passwordEncrypt($contraseña);

        $statement->bindParam(":nombreTorneo", $nombreTorneo);
        $statement->bindParam(":organizador", $organizador);
        $statement->bindParam(":patrocinadores", $patrocinadores);
        $statement->bindParam(":sede", $sede);
        $statement->bindParam(":categoria", $categoria);
        $statement->bindParam(":premio1", $premio1);
        $statement->bindParam(":premio2", $premio2);
        $statement->bindParam(":premio3", $premio3);
        $statement->bindParam(":usuario", $usuario);
        $statement->bindParam(":contraseña", $contraseña);

        return ($statement->execute()) ? $this->PDO->lastInsertId() : false;
    }

    public function passwordEncrypt($password){
        $passwordEncrypted = password_hash($password, PASSWORD_DEFAULT);
        return $passwordEncrypted;
    }

    public function passwordDEncrypted($passwordEncrypted, $passwordCandidate){
        return (password_verify($passwordCandidate, $passwordEncrypted)) ? true : false;
    }

    public function read() {
        $statement = $this->PDO->prepare("SELECT * FROM torneos");
    
        if ($statement->execute()) {
            return $statement->fetchAll();
        } else {
            return false;
        }
    }

    public function readOne($id) {
    $statement = $this->PDO->prepare("SELECT * FROM torneos WHERE id_torneo = :id LIMIT 1");
    $statement->bindParam(":id", $id);
    
    return ($statement->execute()) ? $statement->fetch() : false;
    }
}

?>