<?php
require_once __DIR__ . '/config/Database.php';
use Config\Database;

$db = new Database();
$pdo = $db->connect();

try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS logs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        usuario_id INT NOT NULL,
        usuario_nombre VARCHAR(100) NOT NULL,
        accion VARCHAR(255) NOT NULL,
        detalle TEXT,
        fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
    )");
    echo "Tabla logs verificada/creada con exito.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
