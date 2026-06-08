<?php
namespace Models;

use Config\Database;
use PDO;
use PDOException;

class ProductoModel
{
    private PDO $conexion;

    public function __construct()
    {
        $db = new Database();
        $this->conexion = $db->connect();
    }

    /**
     * Obtiene todos los productos (sin paginación)
     */
    public function obtenerTodos(): array
    {
        try {
            $sql = 'SELECT * FROM productos ORDER BY id DESC';
            $stmt = $this->conexion->query($sql);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Obtiene productos con paginación
     */
    public function obtenerPaginado(int $pagina = 1, int $porPagina = 10): array
    {
        try {
            $offset = ($pagina - 1) * $porPagina;
            $sql = 'SELECT * FROM productos ORDER BY id DESC LIMIT :limit OFFSET :offset';
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':limit', $porPagina, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Cuenta el total de productos
     */
    public function contarTotal(): int
    {
        try {
            $sql = 'SELECT COUNT(*) as total FROM productos';
            $stmt = $this->conexion->query($sql);
            $result = $stmt->fetch();
            return (int)$result['total'];
        } catch (PDOException $e) {
            return 0;
        }
    }

    /**
     * Busca productos públicamente con paginación
     */
    public function buscarPublico(string $termino = '', int $pagina = 1, int $porPagina = 9): array
    {
        try {
            if (trim($termino) === '') {
                return $this->obtenerPaginado($pagina, $porPagina);
            }

            $offset = ($pagina - 1) * $porPagina;
            $sql = 'SELECT * FROM productos WHERE nombre LIKE :termino OR
                    descripcion LIKE :termino ORDER BY id DESC LIMIT :limit OFFSET :offset';
            $stmt = $this->conexion->prepare($sql);
            $busqueda = '%' . $termino . '%';
            $stmt->bindParam(':termino', $busqueda);
            $stmt->bindParam(':limit', $porPagina, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Cuenta productos en una búsqueda
     */
    public function contarBusqueda(string $termino = ''): int
    {
        try {
            if (trim($termino) === '') {
                return $this->contarTotal();
            }

            $sql = 'SELECT COUNT(*) as total FROM productos WHERE nombre LIKE :termino OR
                    descripcion LIKE :termino';
            $stmt = $this->conexion->prepare($sql);
            $busqueda = '%' . $termino . '%';
            $stmt->bindParam(':termino', $busqueda);
            $stmt->execute();
            $result = $stmt->fetch();
            return (int)$result['total'];
        } catch (PDOException $e) {
            return 0;
        }
    }

    /**
     * Obtiene un producto por ID
     */
    public function obtenerPorId(int $id): ?array
    {
        try {
            $sql = 'SELECT * FROM productos WHERE id = :id LIMIT 1';
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $producto = $stmt->fetch();
            return $producto ?: null;
        } catch (PDOException $e) {
            return null;
        }
    }

    /**
     * Verifica si un SKU ya existe (excluyendo un ID opcional para edición)
     */
    public function existePorSku(string $sku, ?int $exceptoId = null): bool
    {
        try {
            if ($exceptoId !== null) {
                $sql = 'SELECT COUNT(*) as total FROM productos WHERE sku = :sku AND id != :id';
                $stmt = $this->conexion->prepare($sql);
                $stmt->bindParam(':sku', $sku);
                $stmt->bindParam(':id', $exceptoId, PDO::PARAM_INT);
            } else {
                $sql = 'SELECT COUNT(*) as total FROM productos WHERE sku = :sku';
                $stmt = $this->conexion->prepare($sql);
                $stmt->bindParam(':sku', $sku);
            }
            $stmt->execute();
            $result = $stmt->fetch();
            return (int)$result['total'] > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Crea un nuevo producto con transacción
     */
    public function crear(array $data): bool
    {
        try {
            $this->conexion->beginTransaction();

            $sql = 'INSERT INTO productos (sku, nombre, descripcion, precio_compra,
                    precio_venta, existencia, imagen)
                    VALUES (:sku, :nombre, :descripcion, :precio_compra, :precio_venta,
                    :existencia, :imagen)';
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':sku', $data['sku']);
            $stmt->bindParam(':nombre', $data['nombre']);
            $stmt->bindParam(':descripcion', $data['descripcion']);
            $stmt->bindParam(':precio_compra', $data['precio_compra']);
            $stmt->bindParam(':precio_venta', $data['precio_venta']);
            $stmt->bindParam(':existencia', $data['existencia'], PDO::PARAM_INT);
            $stmt->bindParam(':imagen', $data['imagen']);

            $resultado = $stmt->execute();
            if (!$resultado) {
                $this->conexion->rollBack();
                return false;
            }

            $this->conexion->commit();
            return true;
        } catch (PDOException $e) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }
            return false;
        }
    }

    /**
     * Actualiza un producto existente con transacción
     */
    public function actualizar(int $id, array $data): bool
    {
        try {
            $this->conexion->beginTransaction();

            // Si se proporciona nueva imagen, actualizarla
            if (isset($data['imagen']) && $data['imagen'] !== null) {
                $sql = 'UPDATE productos SET
                            sku = :sku,
                            nombre = :nombre,
                            descripcion = :descripcion,
                            precio_compra = :precio_compra,
                            precio_venta = :precio_venta,
                            existencia = :existencia,
                            imagen = :imagen
                        WHERE id = :id';
            } else {
                $sql = 'UPDATE productos SET
                            sku = :sku,
                            nombre = :nombre,
                            descripcion = :descripcion,
                            precio_compra = :precio_compra,
                            precio_venta = :precio_venta,
                            existencia = :existencia
                        WHERE id = :id';
            }

            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':sku', $data['sku']);
            $stmt->bindParam(':nombre', $data['nombre']);
            $stmt->bindParam(':descripcion', $data['descripcion']);
            $stmt->bindParam(':precio_compra', $data['precio_compra']);
            $stmt->bindParam(':precio_venta', $data['precio_venta']);
            $stmt->bindParam(':existencia', $data['existencia'], PDO::PARAM_INT);
            if (isset($data['imagen']) && $data['imagen'] !== null) {
                $stmt->bindParam(':imagen', $data['imagen']);
            }
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $this->conexion->commit();
            return true;
        } catch (PDOException $e) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }
            return false;
        }
    }

    /**
     * Elimina un producto con transacción
     */
    public function eliminar(int $id): bool
    {
        try {
            $this->conexion->beginTransaction();
            $sql = 'DELETE FROM productos WHERE id = :id';
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() === 0) {
                $this->conexion->rollBack();
                return false;
            }

            $this->conexion->commit();
            return true;
        } catch (PDOException $e) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }
            return false;
        }
    }

    /**
     * Obtiene un producto por SKU
     */
    public function obtenerPorSku(string $sku): ?array
    {
        try {
            $sql = 'SELECT * FROM productos WHERE sku = :sku LIMIT 1';
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':sku', $sku);
            $stmt->execute();
            $producto = $stmt->fetch();
            return $producto ?: null;
        } catch (PDOException $e) {
            return null;
        }
    }

    /**
     * Actualiza un producto existente por su SKU
     */
    public function actualizarPorSku(string $sku, array $data): bool
    {
        try {
            $this->conexion->beginTransaction();

            $sql = 'UPDATE productos SET
                        nombre = :nombre,
                        descripcion = :descripcion,
                        precio_compra = :precio_compra,
                        precio_venta = :precio_venta,
                        existencia = :existencia
                    WHERE sku = :sku';

            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':nombre', $data['nombre']);
            $stmt->bindParam(':descripcion', $data['descripcion']);
            $stmt->bindParam(':precio_compra', $data['precio_compra']);
            $stmt->bindParam(':precio_venta', $data['precio_venta']);
            $stmt->bindParam(':existencia', $data['existencia'], PDO::PARAM_INT);
            $stmt->bindParam(':sku', $sku);
            $stmt->execute();

            if ($stmt->rowCount() === 0 && $this->existePorSku($sku) === false) {
                // El producto no existía para actualizar
                $this->conexion->rollBack();
                return false;
            }

            $this->conexion->commit();
            return true;
        } catch (PDOException $e) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }
            return false;
        }
    }

    /**
     * Elimina un producto por su SKU
     */
    public function eliminarPorSku(string $sku): bool
    {
        try {
            $this->conexion->beginTransaction();
            $sql = 'DELETE FROM productos WHERE sku = :sku';
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':sku', $sku);
            $stmt->execute();

            if ($stmt->rowCount() === 0) {
                $this->conexion->rollBack();
                return false;
            }

            $this->conexion->commit();
            return true;
        } catch (PDOException $e) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }
            return false;
        }
    }
}
