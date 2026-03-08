<?php
include "Usuario.php";
class Admin extends Usuario{
    public function getRol(){
        return "administrador";
    }
    
}
?>