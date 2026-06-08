<?php
namespace Models;

use Config\Database;
use PDO;
use PDOException;

class LogModel
{
    private PDO $conexion;

    public function __construct()
    {
        $db = new Database();
        $this->conexion = $db->connect();
    }

    /**
     * Registra una acción en la bitácora
     */
    public function registrar(int $usuarioId, string $usuarioNombre, string $accion, string $detalle = ''): bool
    {
        try {
            $sql = 'INSERT INTO logs (usuario_id, usuario_nombre, accion, detalle)
                    VALUES (:usuario_id, :usuario_nombre, :accion, :detalle)';
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
            $stmt->bindParam(':usuario_nombre', $usuarioNombre);
            $stmt->bindParam(':accion', $accion);
            $stmt->bindParam(':detalle', $detalle);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Obtiene logs paginados
     */
    public function obtenerPaginado(int $pagina = 1, int $porPagina = 15): array
    {
        try {
            $offset = ($pagina - 1) * $porPagina;
            $sql = 'SELECT * FROM logs ORDER BY fecha DESC LIMIT :limit OFFSET :offset';
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
     * Cuenta el total de registros en la bitácora
     */
    public function contarTotal(): int
    {
        try {
            $sql = 'SELECT COUNT(*) as total FROM logs';
            $stmt = $this->conexion->query($sql);
            $result = $stmt->fetch();
            return (int)$result['total'];
        } catch (PDOException $e) {
            return 0;
        }
    }
}
