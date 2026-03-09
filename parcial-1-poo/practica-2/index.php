<?php
require_once 'Admin.php';
require_once 'Usuario.php';

$objadmin1 = new Admin("erikwr3@gmail,com", "Erik Watson");
 echo "Nombre:" . $objadmin1->getNombre() . "<br>";
  echo "Correo:" . $objadmin1->getCorreo() . "<br>";
   echo "Rol:" . $objadmin1->getRol();

?>
 