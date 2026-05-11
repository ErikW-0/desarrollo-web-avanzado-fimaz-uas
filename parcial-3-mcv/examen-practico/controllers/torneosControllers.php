<?php

require_once("../../models/torneosModel.php");

class torneosController {

    private $model;

    public function __construct() {
        $this->model = new torneosModel();
    }

    public function saveTorneo($nombreTorneo, $organizador, $patrocinadores, $sede, $categoria, $premio1, $premio2, $premio3, $usuario, $contrasena) {

        $id = $this->model->insert($nombreTorneo, $organizador, $patrocinadores, $sede, $categoria, $premio1, $premio2, $premio3, $usuario, $contrasena);

        return ($id != false) ? header("Location: admin.php") : header("Location: frmTorneos.php");
    }

    public function readTorneos() {
    $model = new torneosModel();
    return ($model->read() != false) ? $model->read() : false;
}
}

?>