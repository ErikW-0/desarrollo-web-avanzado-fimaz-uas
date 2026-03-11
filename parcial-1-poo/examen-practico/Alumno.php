<?php
include_once "Usuario.php";

class Alumno extends Usuario{
    private $vMatricula;
    public function __construct($vNombre, $vCorreo, $vMatricula){
        parent::__construct($vNombre, $vCorreo);

        $this->vMatricula = $vMatricula;
    }
    public function getMatricula(){
        return $this->vMatricula;
    }
    public function getRol(){
        return "alumno";
    }

}