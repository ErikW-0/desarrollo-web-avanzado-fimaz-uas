<?php
 include_once __DIR__ . "/../config/Database.php";
 include_once __DIR__ ."/../models/Producto.php";

 class ProductoController{
    private $connection;

    public function __construct(){
        $database=new Database();
        $this->connection = $database->getConnection();

    }
    public function crear(Producto $producto){
        $sql = "INSERT INTO productos (nombre, descripcion, existencias, precio)
        VALUES(:nombre, :descripcion, :existencias, :precio)";
        $stmt = $this->connection->prepare($sql);

        $stmt->bindValue(':nombre', $producto->getNombre());
        $stmt->bindValue(':descripcion', $producto->getDescripcion());
        $stmt->bindValue(':existencias', $producto->getExistencia());
        $stmt->bindValue(':precio', $producto->getPrecio());

        return $stmt->execute();

    }

    public function listar(){
        $sql = 'SELECT * FROM productos ORDER BY id DESC';
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function obtenerPorId($id){
        $sql = 'SELECT * FROM productos WHERE id = :id';
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function actualizar(Producto $producto){
        $sql = 'UPDATE productos SET nombre = :nombre, descripcion=:descripcion, existencias= :existencias, precio= :precio WHERE id = :id';
        $stmt = $this->connection->prepare($sql);
        
        $stmt->bindValue(':id', $producto->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':nombre', $producto->getNombre());
        $stmt->bindValue(':descripcion', $producto->getDescripcion());
        $stmt->bindValue(':existencias', $producto->getExistencia(), PDO::PARAM_INT);
        $stmt->bindValue(':precio', $producto->getPrecio());

        return $stmt->execute();

    


    }
    public function eliminar($id){
        $sql = 'DELETE FROM productos WHERE id = :id';
        $stmt= $this->connection->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();

    }
    public function buscar($termino){
        $sql = 'SELECT * FROM productos WHERE nombre LIKE :termino OR descripcion LIKE :termino ORDER BY id DESC';
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':termino', '%' .  $termino . '%');
        $stmt->execute();

        return $stmt->fetchAll();
    }
 }    
?>