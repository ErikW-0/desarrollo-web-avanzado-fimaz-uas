<?php
namespace Config;

use PDO;
use PDOException;

class Database
{
    private string $host = '139.177.97.247';
    private string $dbName = 'tienda_mvc';
    private string $username = '';
    private string $password = '';
    private string $charset = 'utf8mb4';

    public function connect(): PDO
    {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbName};charset={$this->charset}";
            $pdo = new PDO($dsn, $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        } catch (PDOException $e) {
            die('Error de conexión: ' . $e->getMessage());
        }
    }
}
