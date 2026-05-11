<?php
// Watson Rosales Jesus Erik
require_once("../../models/torneosModel.php");

class torneosController {

    private $model;

    public function __construct() {
        $this->model = new torneosModel();
    }


    public function saveTorneo($nombreTorneo, $organizador, $patrocinadores, $sede, $categoria, $premio1, $premio2, $premio3, $otroPremio, $usuario, $contrasena) {

        
        $id = $this->model->insert(
            $nombreTorneo, 
            $organizador, 
            $patrocinadores, 
            $sede, 
            $categoria, 
            $premio1, 
            $premio2, 
            $premio3, 
            $otroPremio, 
            $usuario, 
            $contrasena
        );

        return ($id != false) ? header("Location: admin.php") : header("Location: frmTorneos.php");
    }

    public function readTorneos() {
        
        return ($this->model->read() != false) ? $this->model->read() : false;
    }

    public function readOneTorneo($id) {
        return ($this->model->readOne($id) != false) ? $this->model->readOne($id) : header("Location: admin.php");
    }

    public function updateTorneo($id, $nombre, $organizador, $pat, $sede, $cat, $p1, $p2, $p3, $otroPremio) {
        $resultado = $this->model->update($id, $nombre, $organizador, $pat, $sede, $cat, $p1, $p2, $p3, $otroPremio);
        
        if ($resultado != false) {
            header("Location: readOneTorneo.php?id=" . $id); // Corregí el nombre de la vista (estaba en plural)
        } else {
            header("Location: readAllTorneos.php");
        }
    }

    public function delete($id){
        return ($this->model->delete($id)) ? header("Location: readAllTorneos.php") : header("Location: readOneTorneo.php?id=".$id);
    }
}

?>