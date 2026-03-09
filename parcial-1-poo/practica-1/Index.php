//**
* This PHP code snippet is including a file named "Usuario.php" which presumably contains the
* definition of a class called Usuario. It then creates an instance of the Usuario class with the
* email "erikwr3@gmail.com" and the name "Erik Watson". 
*//
<?php
include "Usuario.php";

$objUsuario1 = new Usuario("erikwr3@gmail.com ", "Erik Watson ");

echo "nombre " . $objUsuario1->getNombre() . "<br>" ;
echo "correo " . $objUsuario1->getCorreo();

?>

