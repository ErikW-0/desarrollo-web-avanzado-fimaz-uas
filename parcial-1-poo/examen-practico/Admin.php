<?php
 include_once "Usuario.php";
 
 class Admin extends Usuario{
    public function getRol(){
        return "Administrador";
    }
 }
 ?>