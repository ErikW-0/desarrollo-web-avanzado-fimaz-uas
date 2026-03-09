<?php
class Usuario{
    private $nombre;
    private $correo;


function __construct($correo, $nombre){
    if(!filter_var($correo, FILTER_VALIDATE_EMAIL)){
            throw new Exception("El correo no tiene un formato válido.");
        }
    $this->correo = $correo;
    $this->nombre = $nombre;
}

function getCorreo(){
    return $this->correo;

}
function getNombre(){
    return $this->nombre;

}
function setNombre($nombre){
    $this->nombre = $this->$nombre;
}
function setCorreo($correo){
    $this->correo = $this->$correo;
}
}
?>