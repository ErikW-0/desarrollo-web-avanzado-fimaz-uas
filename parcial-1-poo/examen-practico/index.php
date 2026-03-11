<?php

include_once("Usuario.php");
include_once("Admin.php");
include_once("Alumno.php");

$objusuarios = [];
try {
    $objusuarios [] = new Admin("Erik Watson", "erikwr3@gmail.com");
    $objusuarios [] = new Alumno("Pedro", "pedro@gmail.com", "12345");
    $objusuarios [] = new Alumno("Juan Error", "correo-malo", "54321");

}catch (Exception $e) {
    echo "<p style='color:red;'>se detecto un problema: ".$e->getMessage()."</p>";
}
?>
<h2>Lista de Usuarios</h2>

<table border="1" cellpadding="8">
<tr>
<th>Nombre</th>
<th>Correo</th>
<th>Rol</th>
<th>Matrícula</th>
</tr>

<?php
foreach($objusuarios as $u){

    $matricula = method_exists($u, "getMatricula") ? $u->getMatricula() : "—";
    
    echo "<tr>";
    echo "<td>".$u->getNombre()."</td>";
    echo "<td>".$u->getCorreo()."</td>";
    echo "<td>".$u->getRol()."</td>";
    echo "<td>".$matricula."</td>";
    echo "</tr>";

}