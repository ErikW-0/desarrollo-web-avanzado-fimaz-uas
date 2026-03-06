<?php
class Usuario{
    private $nombre;
    private $correo;


function __construct($correo, $nombre){
    $this->correo = $correo;
    $this->nombre = $nombre;
}

function getCorreo(){
    return $this->correo;

}
function getNombre(){
    return $this->nombre;

}
function setNombre(){
    $this->nombre = $this->$nombre;
}
function setCorreo(){
    $this->correo = $this->$correo;
}
}
?>