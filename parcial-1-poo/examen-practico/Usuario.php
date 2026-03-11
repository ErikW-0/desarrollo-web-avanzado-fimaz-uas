<?php

class Usuario{
    Private $vNombre;
    private $vCorreo;
    public function __construct($vNombre, $vCorreo){
        if(!filter_var($vCorreo, FILTER_VALIDATE_EMAIL)){
            throw new Exception("El correo no tiene un formato valido");
        }
        $this->vNombre = $vNombre;
        $this->vCorreo = $vCorreo;
    }
    public function getNombre(){
        return $this->vNombre;
    }
    public function getCorreo(){
        return $this->vCorreo;
    }
}
?>