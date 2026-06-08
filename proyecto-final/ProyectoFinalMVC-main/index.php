<?php
require_once __DIR__ . '/config/Autoload.php';

use Controllers\AuthController;
use Controllers\ProductoController;
use Controllers\PublicController;
use Controllers\ApiController;

define('BASE_URL', rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\'));

// Parsear ruta amigable desde REQUEST_URI
$basePath = dirname($_SERVER['SCRIPT_NAME']);
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($basePath !== '/' && $basePath !== '\\' && strpos($requestUri, $basePath) === 0) {
    $path = substr($requestUri, strlen($basePath));
} else {
    $path = $requestUri;
}
$path = trim($path, '/');

// Soportar ambos estilos: rutas amigables y ?route= (compatibilidad)
if (!empty($path) && $path !== 'index.php') {
    $route = $path;
} else {
    $route = $_GET['route'] ?? 'catalogo';
}

// ---------------------------------------------------------
// ENRUTAMIENTO API REST
// ---------------------------------------------------------
if (str_starts_with($route, 'api/')) {
    $apiController = new ApiController();
    $method = $_SERVER['REQUEST_METHOD'];

    // Extraer segmentos de la ruta api (ej: api/productos/SKU-001)
    $segments = explode('/', $route);
    $endpoint = $segments[1] ?? '';
    $sku = $segments[2] ?? '';

    if ($endpoint === 'login' && $method === 'POST') {
        $apiController->login();
        exit;
    }

    if ($endpoint === 'productos') {
        if ($sku === '') {
            // GET /api/productos
            if ($method === 'GET') {
                $apiController->index();
            }
        } else {
            // /api/productos/{sku}
            if ($method === 'GET') {
                $apiController->show($sku);
            } elseif ($method === 'PUT' || $method === 'POST') {
                $apiController->update($sku);
            } elseif ($method === 'DELETE') {
                $apiController->delete($sku);
            }
        }
    }

    // Endpoint no encontrado
    http_response_code(404);
    echo json_encode(['error' => 'Endpoint no encontrado']);
    exit;
}

// ---------------------------------------------------------
// ENRUTAMIENTO WEB MVC NORMAL
// ---------------------------------------------------------
// Extraer ID de la ruta (ej: productos/edit/5)
$segments = explode('/', $route);
if (count($segments) >= 3 && is_numeric($segments[count($segments) - 1])) {
    $_GET['id'] = $segments[count($segments) - 1];
    $route = implode('/', array_slice($segments, 0, count($segments) - 1));
}

$authController = new AuthController();
$productoController = new ProductoController();
$publicController = new PublicController();

switch ($route) {
    case 'login':
        $authController->showLogin();
        break;

    case 'auth/login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->login();
        }
        break;

    case 'logout':
        $authController->logout();
        break;

    case 'productos':
        $productoController->index();
        break;

    case 'productos/create':
        $productoController->create();
        break;

    case 'productos/store':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productoController->store();
        }
        break;

    case 'productos/edit':
        $productoController->edit();
        break;

    case 'productos/update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productoController->update();
        }
        break;

    case 'productos/delete':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productoController->delete();
        }
        break;

    case 'logs':
        $productoController->logs();
        break;

    case 'catalogo':
    default:
        $publicController->catalogo();
        break;
}
