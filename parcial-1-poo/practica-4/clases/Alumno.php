<?php
require_once "Usuario.php";

class Alumno extends Usuario {

    private $matricula;

    public function __construct($correo, $nombre, $matricula){
        parent::__construct($correo, $nombre);
        $this->matricula = $matricula;
    }

    public function getMatricula(){
        return $this->matricula;
    }
     public function setMatricula($matricula){
        return $this->matricula;
     }

    public function getRol(){
        return "Alumno";
    }
}
?>