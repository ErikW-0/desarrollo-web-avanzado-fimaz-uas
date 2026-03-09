<?php
require_once "Alumno.php";
require_once "admin.php";

try {
    $objadmin1 = new Admin("erikwr3@gmail.com", "Erik Watson");
    echo"correo:" . $objadmin1->getCorreo() . "<br>";
    echo"nombre:". $objadmin1->getNombre() . "<br>";
    echo"rol:" . $objadmin1->getRol() . "<br><br>";

    $objAlumno1 = new Alumno("correoprueba@gmail.com", "UsuarioPrueba", "12345678");
    echo "correo:" . $objAlumno1->getCorreo() . "<br>";
    echo "nombre:". $objAlumno1->getNombre() . "<br>";
    echo "rol:" . $objAlumno1->getRol() . "<br>";
    echo "matricula:" . $objAlumno1->getMatricula() . "<br><br>";

    $objusuarioError = new Admin("correo_invalido", "Pedro");

}catch(Exception $e){
    echo "Error" . $e->getMessage();
}
?>
