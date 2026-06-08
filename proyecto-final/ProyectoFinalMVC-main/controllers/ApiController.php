<?php
namespace Controllers;

use Models\ProductoModel;
use Models\UsuarioModel;

class ApiController
{
    private ProductoModel $productoModel;

    public function __construct()
    {
        $this->productoModel = new ProductoModel();
        
        // Configurar cabeceras para API REST
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');

        // Manejar solicitud preflight (OPTIONS)
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit;
        }
    }

    /**
     * Valida que exista una sesión activa
     */
    private function verificarSesionApi(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['admin'])) {
            http_response_code(401);
            echo json_encode([
                'error' => 'No autorizado. Inicie sesión como administrador para usar la API.'
            ]);
            exit;
        }
    }

    /**
     * Enviar respuesta JSON estándar
     */
    private function jsonResponse(int $statusCode, array $data): void
    {
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }

    /**
     * POST /api/login
     * Endpoint para autenticarse desde clientes como Postman
     */
    public function login(): void
    {
        // Leer datos JSON del cuerpo si existen, si no, buscar en $_POST
        $input = json_decode(file_get_contents('php://input'), true);
        $username = trim($input['username'] ?? $_POST['username'] ?? '');
        $password = trim($input['password'] ?? $_POST['password'] ?? '');

        if ($username === '' || $password === '') {
            $this->jsonResponse(400, ['error' => 'El usuario y contraseña son obligatorios']);
        }

        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->buscarPorUsername($username);

        if ($usuario && password_verify($password, $usuario['password'])) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['admin'] = [
                'id' => $usuario['id'],
                'username' => $usuario['username'],
                'nombre_completo' => $usuario['nombre_completo']
            ];

            $this->jsonResponse(200, [
                'success' => true,
                'message' => 'Login exitoso',
                'admin' => $_SESSION['admin']
            ]);
        }

        $this->jsonResponse(401, ['error' => 'Credenciales incorrectas']);
    }

    /**
     * GET /api/productos
     * Devuelve el listado de todos los productos
     */
    public function index(): void
    {
        $this->verificarSesionApi();
        
        $productos = $this->productoModel->obtenerTodos();
        $this->jsonResponse(200, ['data' => $productos]);
    }

    /**
     * GET /api/productos/{sku}
     * Devuelve un producto por su SKU
     */
    public function show(string $sku): void
    {
        $this->verificarSesionApi();

        if (empty($sku)) {
            $this->jsonResponse(400, ['error' => 'El SKU es requerido']);
        }

        $producto = $this->productoModel->obtenerPorSku($sku);

        if (!$producto) {
            $this->jsonResponse(404, ['error' => 'Producto no encontrado']);
        }

        $this->jsonResponse(200, ['data' => $producto]);
    }

    /**
     * POST o PUT /api/productos/{sku}
     * Modifica un producto por su SKU
     */
    public function update(string $sku): void
    {
        $this->verificarSesionApi();

        if (empty($sku)) {
            $this->jsonResponse(400, ['error' => 'El SKU es requerido']);
        }

        $productoOriginal = $this->productoModel->obtenerPorSku($sku);
        if (!$productoOriginal) {
            $this->jsonResponse(404, ['error' => 'Producto no encontrado para actualizar']);
        }

        // Leer datos JSON del cuerpo
        $input = json_decode(file_get_contents('php://input'), true) ?? [];

        // Combinar datos enviados con los originales para permitir actualizaciones parciales
        $data = [
            'nombre' => trim($input['nombre'] ?? $productoOriginal['nombre']),
            'descripcion' => trim($input['descripcion'] ?? $productoOriginal['descripcion']),
            'precio_compra' => trim($input['precio_compra'] ?? $productoOriginal['precio_compra']),
            'precio_venta' => trim($input['precio_venta'] ?? $productoOriginal['precio_venta']),
            'existencia' => trim($input['existencia'] ?? $productoOriginal['existencia'])
        ];

        // Validaciones básicas
        if (!is_numeric($data['precio_compra']) || !is_numeric($data['precio_venta']) || !is_numeric($data['existencia'])) {
            $this->jsonResponse(400, ['error' => 'Los precios y la existencia deben ser numéricos']);
        }

        if ($data['precio_compra'] < 0 || $data['precio_venta'] < 0 || $data['existencia'] < 0) {
            $this->jsonResponse(400, ['error' => 'Los valores numéricos no pueden ser negativos']);
        }

        if ($data['precio_venta'] < $data['precio_compra']) {
            $this->jsonResponse(400, ['error' => 'El precio de venta debe ser mayor o igual al de compra']);
        }

        // Ejecutar actualización
        if ($this->productoModel->actualizarPorSku($sku, $data)) {
            $this->jsonResponse(200, [
                'success' => true,
                'message' => 'Producto actualizado correctamente'
            ]);
        }

        $this->jsonResponse(500, ['error' => 'No se pudo actualizar el producto']);
    }

    /**
     * DELETE /api/productos/{sku}
     * Elimina un producto por su SKU
     */
    public function delete(string $sku): void
    {
        $this->verificarSesionApi();

        if (empty($sku)) {
            $this->jsonResponse(400, ['error' => 'El SKU es requerido']);
        }

        // Verificar si existe primero
        $producto = $this->productoModel->obtenerPorSku($sku);
        if (!$producto) {
            $this->jsonResponse(404, ['error' => 'Producto no encontrado para eliminar']);
        }

        if ($this->productoModel->eliminarPorSku($sku)) {
            $this->jsonResponse(200, [
                'success' => true,
                'message' => 'Producto eliminado correctamente'
            ]);
        }

        $this->jsonResponse(500, ['error' => 'No se pudo eliminar el producto']);
    }
}
