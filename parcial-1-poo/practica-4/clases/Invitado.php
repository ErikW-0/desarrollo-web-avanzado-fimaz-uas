<?php
require_once 'Usuario.php';
 class invitado extends Usuario{
    private $empresa;
    
    public function __construct($correo, $nombre, $empresa){
        parent::__construct($correo, $nombre);
        $this->empresa = $empresa;
    }
public function getEmpresa(){
        return $this->empresa;
 
 }
public function getRol(){
    return "invitado";
}

 }
 ?>
  
 
 
 