<?php
require_once "clases/Admin.php";
require_once "clases/Alumno.php";
require_once "clases/Invitado.php";

$objusuarios = [];

try {
    $objusuarios[] = new Admin("erikwr3@gmail.com", "Erik Watson");
    $objusuarios[] = new Alumno("alumno@gmail.com", "Alumno", "12345");
    $objusuarios[] = new Invitado("invitado@gmail.com", "Invitado", "Empresa33");

     $objusuarios[] = new Alumno("correo_invalido", "pedro", "54321");
} catch (Exception $e) {
echo "<p style='color:red;'>Error controlado: ".$e->getMessage()."</p>";
}
?>

<h2>Lista de Usuarios</h2>

<table border="1" cellpadding="8">
<tr>
<th>Nombre</th>
<th>Correo</th>
<th>Rol</th>
<th>Matrícula</th>
<th>Empresa</th>
</tr>

<?php
foreach($objusuarios as $u){

    $matricula = method_exists($u, "getMatricula") ? $u->getMatricula() : "—";
    $empresa = method_exists($u, "getEmpresa") ? $u->getEmpresa() : "—";

    echo "<tr>";
    echo "<td>".$u->getNombre()."</td>";
    echo "<td>".$u->getCorreo()."</td>";
    echo "<td>".$u->getRol()."</td>";
    echo "<td>".$matricula."</td>";
    echo "<td>".$empresa."</td>";
    echo "</tr>";
}
?>
</table>