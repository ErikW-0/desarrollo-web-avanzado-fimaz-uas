<?php

require_once("../../models/torneosModel.php");

class torneosController {

    private $model;

    public function __construct() {
        $this->model = new torneosModel();
    }

    public function saveTorneo($nombreTorneo, $organizador, $patrocinadores, $sede, $categoria, $premio1, $premio2, $premio3, $usuario, $contraseña) {

        $id = $this->model->insert($nombreTorneo, $organizador, $patrocinadores, $sede, $categoria, $premio1, $premio2, $premio3,  $usuario, $contraseña);

        return ($id != false) ? header("Location: admin.php") : header("Location: frmTorneos.php");
    }

    public function readTorneos() {
    $model = new torneosModel();
    return ($model->read() != false) ? $model->read() : false;
    }
        public function readOneTorneo($id) {
    return ($this->model->readOne($id) != false) ? $this->model->readOne($id) : header("Location: admin.php");
    }
    public function updateTorneo($id, $nombre, $organizador, $pat, $sede, $cat, $p1, $p2, $p3, $otroPremio) {
    $resultado = $this->model->update($id, $nombre, $organizador, $pat, $sede, $cat, $p1, $p2, $p3, $otroPremio);
    
    if ($resultado != false) {
        header("Location: readOneTorneos.php?id=" . $id);
    } else {
        
        header("Location: readAlltorneos.php"   );
    }
}
}

?>