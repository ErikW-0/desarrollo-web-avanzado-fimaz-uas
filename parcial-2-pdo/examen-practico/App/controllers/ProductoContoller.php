<?php
// Watson Rosales Jesus Erik
namespace App\controllers;

use App\Config\Database;
use App\Models\Producto;
use PDO;
use PDOException;

class ProductoController {
    private $connection;

    public function __construct() {
        $database = new Database();
        $this->connection = $database->getConnection();
    }

    public function crear(Producto $producto) {
        try {
            $sql = "INSERT INTO productos (nombre, descripcion, existencias, precio) VALUES (:nombre, :descripcion, :existencias, :precio)";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(':nombre', $producto->getNombre());
            $stmt->bindValue(':descripcion', $producto->getDescripcion());
            $stmt->bindValue(':existencia', $producto->getExistencias(), PDO::PARAM_INT);
            $stmt->bindValue(':precio', $producto->getPrecio());
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al crear producto: " . $e->getMessage());
            return false;
        }
    }

    public function listar() {
        try {
            $sql = "SELECT * FROM productos ORDER BY id DESC";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
             error_log("Error al listar productos: " . $e->getMessage());
             return [];
        }
    }

    public function obtenerPorId($id) {
        try {
            $sql = "SELECT * FROM productos WHERE id = :id";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error al obtener producto por ID: " . $e->getMessage());
            return false;
        }
    }

    public function actualizar(Producto $producto) {
        try {
            $sql = "UPDATE productos SET nombre = :nombre, descripcion = :descripcion, existencias = :existencias, precio = :precio WHERE id = :id";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(':id', $producto->getId(), PDO::PARAM_INT);
            $stmt->bindValue(':nombre', $producto->getNombre());
            $stmt->bindValue(':descripcion', $producto->getDescripcion());
            $stmt->bindValue(':existencia', $producto->getExistencias(), PDO::PARAM_INT);
            $stmt->bindValue(':precio', $producto->getPrecio());
            return $stmt->execute();
        } catch (PDOException $e) {
             error_log("Error al actualizar producto: " . $e->getMessage());
             return false;
        }
    }

    public function eliminar($id) {
        try {
            $sql = "DELETE FROM productos WHERE id = :id";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
             error_log("Error al eliminar producto: " . $e->getMessage());
             return false;
        }
    }

    public function buscar($termino) {
        try {
            $sql = "SELECT * FROM productos WHERE nombre LIKE :termino OR descripcion LIKE :termino ORDER BY id DESC";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(':termino', '%' . $termino . '%');
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
             error_log("Error al buscar productos: " . $e->getMessage());
             return [];
        }
    }
}
?>