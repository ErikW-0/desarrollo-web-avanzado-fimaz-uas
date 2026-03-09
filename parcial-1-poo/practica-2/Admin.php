/* The Admin class extends the Usuario class and defines a method to return the role as
"administrador". */
<?php
require_once 'Usuario.php';
class Admin extends Usuario{
    public function getRol(){
        return "administrador";
    }
    
    

}

?>