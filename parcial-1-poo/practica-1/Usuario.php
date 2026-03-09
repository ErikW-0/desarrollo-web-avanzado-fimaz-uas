//**  
* The class Usuario in PHP defines a user with properties for name and email, along with getter and
* setter methods. 
*//
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