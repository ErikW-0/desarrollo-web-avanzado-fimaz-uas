<?php
// Watson Rosales Jesus Erik// 

namespace App\Models;
class Producto {
    private $id;
    private $nombre;
    private $descripcion;
    private $existencias;
    private $precio;

    public function __construct($id = null, $nombre = "", $descripcion = "", $existencias = 0, $precio = 0.00) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->existencias = $existencias;
        $this->precio = $precio;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getExistencias() {
        return $this->existencias;
    }

    public function setExistencias($existencias) {
        $this->existencias = $existencias;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }
}
?>