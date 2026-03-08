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
function setNombre($nombre){
    $this->nombre = $this->$nombre;
}
function setCorreo($correo){
    $this->correo = $this->$correo;
}
}
?> 