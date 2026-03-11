<?php

class Usuario{
    Private $vNombre;
    private $vCorreo;
    public function __construct($vNombre, $vCorreo){
        if(!filter_var($vCorreo, FILTER_VALIDATE_EMAIL)){
            throw new Exception("El correo no tiene un formato valido");
        }
        $this->nombre = $vNombre;
        $this->correo = $vCorreo;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getCorreo(){
        return $this->correo;
    }
}
?>