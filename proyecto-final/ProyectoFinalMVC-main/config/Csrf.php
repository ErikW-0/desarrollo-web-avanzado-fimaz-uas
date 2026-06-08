<?php
namespace Config;

class Csrf
{
    /**
     * Genera o recupera el token CSRF de la sesión
     */
    public static function generar(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * Retorna el campo hidden HTML con el token CSRF
     */
    public static function campo(): string
    {
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(self::generar()) . '">';
    }

    /**
     * Valida el token CSRF enviado por POST
     */
    public static function validar(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $token = $_POST['csrf_token'] ?? '';
        if (empty($token) || empty($_SESSION['csrf_token'])) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $token);
    }
}
