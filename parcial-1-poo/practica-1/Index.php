
<?php
//**This PHP code snippet is including a file named "Usuario.php" which presumably contains thedefinition of a class called Usuario. It then creates an instance of the Usuario class with theemail "erikwr3@gmail.com" and the name "Erik Watson". //

include "Usuario.php";

$objUsuario1 = new Usuario("erikwr3@gmail.com ", "Erik Watson ");

echo "nombre " . $objUsuario1->getNombre() . "<br>" ;
echo "correo " . $objUsuario1->getCorreo();

?>

