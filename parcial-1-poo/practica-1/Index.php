<?php
include "Usuario.php";

$objUsuario1 = new Usuario("erikwr3@gmail.com ", "Erik Watson ");

echo "nombre " . $objUsuario1->getNombre() . "<br>" ;
echo "correo " . $objUsuario1->getCorreo();

?>

