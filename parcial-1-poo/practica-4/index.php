<?php
require_once "clases/Admin.php";
require_once "clases/Alumno.php";
require_once "clases/Invitado.php";

$objusuarios = [];

try {
    $objusuarios[] = new Admin();