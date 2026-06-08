<?php
namespace Controllers;

use Models\UsuarioModel;
use Models\LogModel;
use Config\Csrf;

class AuthController
{
    public function showLogin(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function login(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Validar CSRF
        if (!Csrf::validar()) {
            $_SESSION['error'] = 'Token de seguridad inválido. Intente de nuevo.';
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if ($username === '' || $password === '') {
            $_SESSION['error'] = 'Todos los campos son obligatorios.';
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->buscarPorUsername($username);

        if ($usuario && password_verify($password, $usuario['password'])) {
            $_SESSION['admin'] = [
                'id' => $usuario['id'],
                'username' => $usuario['username'],
                'nombre_completo' => $usuario['nombre_completo']
            ];

            // Registrar en bitácora
            $logModel = new LogModel();
            $logModel->registrar($usuario['id'], $usuario['nombre_completo'], 'Inicio de sesión', 'Usuario: ' . $username);

            $_SESSION['success'] = 'Bienvenido, ' . $usuario['nombre_completo'] . '.';
            header('Location: ' . BASE_URL . '/productos');
            exit;
        }

        $_SESSION['error'] = 'Credenciales incorrectas.';
        header('Location: ' . BASE_URL . '/login');
        exit;
    }

    public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Registrar en bitácora antes de destruir la sesión
        if (isset($_SESSION['admin'])) {
            $logModel = new LogModel();
            $logModel->registrar(
                $_SESSION['admin']['id'],
                $_SESSION['admin']['nombre_completo'],
                'Cierre de sesión',
                ''
            );
        }

        session_destroy();
        header('Location: ' . BASE_URL . '/login');
        exit;
    }
}
