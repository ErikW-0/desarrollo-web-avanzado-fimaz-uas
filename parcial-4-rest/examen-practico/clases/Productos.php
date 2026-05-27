<?php
class Productos {
    // Conexión
    public $conn;
    // Tabla de la BD a utilizar
    private $table = "productos";

    // Columnas de la tabla
    public $idProducto;
    public $nombreproducto;
    public $descripcion;
    public $precioCompra;
    public $precioVenta;
    public $existencia;

    // Establecer conexión con la BD al instanciar
    public function __construct($db) {
        $this->conn = $db;
    }

    // GET: Obtener todos los productos
    public function getProductos() {
        $consultaSQL = "SELECT idProducto, nombreproducto, descripcion, precioCompra, precioVenta, existencia FROM " . $this->table;
        $stmt = $this->conn->prepare($consultaSQL);
        $stmt->execute();
        return $stmt;
    }

    // GET: Obtener un solo producto buscado por idProducto
    public function getProducto() {
        $consultaSQL = "SELECT idProducto, nombreproducto, descripcion, precioCompra, precioVenta, existencia 
                        FROM " . $this->table . " 
                        WHERE idProducto = ? 
                        LIMIT 0,1";
        
        $stmt = $this->conn->prepare($consultaSQL);
        $stmt->bindParam(1, $this->idProducto);
        $stmt->execute();

        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        if($dataRow) {
            $this->nombreproducto = $dataRow['nombreproducto'];
            $this->descripcion = $dataRow['descripcion'];
            $this->precioCompra = $dataRow['precioCompra'];
            $this->precioVenta = $dataRow['precioVenta'];
            $this->existencia = $dataRow['existencia'];
            return true;
        }
        return false;
    }

    // POST: Insertar un producto
    public function setProductos() {
        $consultaSQL = "INSERT INTO " . $this->table . " 
                        SET nombreproducto = :nombreproducto, 
                            descripcion = :descripcion, 
                            precioCompra = :precioCompra, 
                            precioVenta = :precioVenta, 
                            existencia = :existencia";
        
        $stmt = $this->conn->prepare($consultaSQL);

        // Limpiar caracteres especiales (Seguridad)
        $this->nombreproducto = htmlspecialchars(strip_tags($this->nombreproducto));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->precioCompra = htmlspecialchars(strip_tags($this->precioCompra));
        $this->precioVenta = htmlspecialchars(strip_tags($this->precioVenta));
        $this->existencia = htmlspecialchars(strip_tags($this->existencia));

        // Enlazar datos
        $stmt->bindParam(":nombreproducto", $this->nombreproducto);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":precioCompra", $this->precioCompra);
        $stmt->bindParam(":precioVenta", $this->precioVenta);
        $stmt->bindParam(":existencia", $this->existencia);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // PUT: Actualizar un producto existente
    public function updateProducto() {
        $consultaSQL = "UPDATE " . $this->table . " 
                        SET nombreproducto = :nombreproducto, 
                            descripcion = :descripcion, 
                            precioCompra = :precioCompra, 
                            precioVenta = :precioVenta, 
                            existencia = :existencia 
                        WHERE idProducto = :idProducto";
        
        $stmt = $this->conn->prepare($consultaSQL);

        // Limpiar datos
        $this->idProducto = htmlspecialchars(strip_tags($this->idProducto));
        $this->nombreproducto = htmlspecialchars(strip_tags($this->nombreproducto));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->precioCompra = htmlspecialchars(strip_tags($this->precioCompra));
        $this->precioVenta = htmlspecialchars(strip_tags($this->precioVenta));
        $this->existencia = htmlspecialchars(strip_tags($this->existencia));

        // Enlazar parámetros
        $stmt->bindParam(":idProducto", $this->idProducto);
        $stmt->bindParam(":nombreproducto", $this->nombreproducto);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":precioCompra", $this->precioCompra);
        $stmt->bindParam(":precioVenta", $this->precioVenta);
        $stmt->bindParam(":existencia", $this->existencia);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // DELETE: Borrar un producto por idProducto
    public function borrarProducto() {
        $consultaSQL = "DELETE FROM " . $this->table . " WHERE idProducto = ?";
        $stmt = $this->conn->prepare($consultaSQL);

        $this->idProducto = htmlspecialchars(strip_tags($this->idProducto));
        $stmt->bindParam(1, $this->idProducto);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>