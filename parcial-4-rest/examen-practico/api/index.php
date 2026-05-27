<?php
// Cabeceras globales obligatorias para APIs REST
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Si es una petición OPTIONS (Preflight), terminar la ejecución de forma exitosa
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Cargar dependencias de los directorios superiores correspondientes
require_once '../configuracion/Database.php';
require_once '../clases/Productos.php';

// Inicializar base de datos y modelo
$database = new Database();
$db = $database->getConnection();
$producto = new Productos($db);

// Obtener el método HTTP de la petición
$metodo = $_SERVER['REQUEST_METHOD'];

// Analizar el parámetro 'url' enviado desde el .htaccess
$url = isset($_GET['url']) ? explode('/', rtrim($_GET['url'], '/')) : [];
$recurso = isset($url[0]) ? $url[0] : '';
$id = isset($url[1]) ? intval($url[1]) : null;

// Validar que se esté accediendo al recurso correcto ('productos')
if ($recurso !== 'productos') {
    http_response_code(404);
    echo json_encode(["message" => "Recurso no encontrado"]);
    exit();
}

// Procesar según el método HTTP detectado
switch ($metodo) {
    case 'GET':
        if ($id !== null) {
            // Obtener un único producto por ID
            $producto->idProducto = $id;
            if ($producto->getProducto()) {
                $item = [
                    "idProducto" => $producto->idProducto,
                    "nombreproducto" => $producto->nombreproducto,
                    "descripcion" => $producto->descripcion,
                    "precioCompra" => $producto->precioCompra,
                    "precioVenta" => $producto->precioVenta,
                    "existencia" => $producto->existencia
                ];
                http_response_code(200);
                echo json_encode($item);
            } else {
                http_response_code(404);
                echo json_encode(["message" => "Producto no encontrado."]);
            }
        } else {
            // Obtener todos los productos
            $stmt = $producto->getProductos();
            $num = $stmt->rowCount();

            if ($num > 0) {
                $listaProductos = [];
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $item = [
                        "idProducto" => $idProducto,
                        "nombreproducto" => $nombreproducto,
                        "descripcion" => $descripcion,
                        "precioCompra" => $precioCompra,
                        "precioVenta" => $precioVenta,
                        "existencia" => $existencia
                    ];
                    array_push($listaProductos, $item);
                }
                http_response_code(200);
                echo json_encode($listaProductos);
            } else {
                http_response_code(200);
                echo json_encode([]); // Retorna arreglo vacío de forma válida
            }
        }
        break;

    case 'POST':
        // Recibir el cuerpo JSON enviado en la petición
        $data = json_decode(file_get_contents("php://input"));

        // Validaciones obligatorias implementadas
        if (
            !empty($data->nombreproducto) &&
            !empty($data->descripcion) &&
            isset($data->precioCompra) &&
            isset($data->precioVenta) &&
            isset($data->existencia)
        ) {
            // Validar que no existan números negativos
            if ($data->precioCompra < 0 || $data->precioVenta < 0 || $data->existencia < 0) {
                http_response_code(400);
                echo json_encode(["message" => "Los precios y existencias no pueden ser negativos."]);
                break;
            }
            // Validar precio de venta
            if ($data->precioVenta < $data->precioCompra) {
                http_response_code(400);
                echo json_encode(["message" => "El precio de venta no puede ser menor al precio de compra."]);
                break;
            }

            // Asignar valores al modelo
            $producto->nombreproducto = $data->nombreproducto;
            $producto->descripcion = $data->descripcion;
            $producto->precioCompra = $data->precioCompra;
            $producto->precioVenta = $data->precioVenta;
            $producto->existencia = $data->existencia;

            if ($producto->setProductos()) {
                http_response_code(201);
                echo json_encode(["message" => "Producto creado exitosamente."]);
            } else {
                http_response_code(500);
                echo json_encode(["message" => "No se pudo crear el producto."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Datos incompletos. El nombre, descripción, precios y existencia son obligatorios."]);
        }
        break;

    case 'PUT':
        if ($id === null) {
            http_response_code(400);
            echo json_encode(["message" => "ID del producto no especificado en la URL."]);
            break;
        }

        $data = json_decode(file_get_contents("php://input"));

        if (
            !empty($data->nombreproducto) &&
            !empty($data->descripcion) &&
            isset($data->precioCompra) &&
            isset($data->precioVenta) &&
            isset($data->existencia)
        ) {
            // Validar reglas de negocio
            if ($data->precioCompra < 0 || $data->precioVenta < 0 || $data->existencia < 0) {
                http_response_code(400);
                echo json_encode(["message" => "Los valores numéricos no pueden ser negativos."]);
                break;
            }
            if ($data->precioVenta < $data->precioCompra) {
                http_response_code(400);
                echo json_encode(["message" => "El precio de venta no puede ser menor al precio de compra."]);
                break;
            }

            // Asignar valores e ID
            $producto->idProducto = $id;
            $producto->nombreproducto = $data->nombreproducto;
            $producto->descripcion = $data->descripcion;
            $producto->precioCompra = $data->precioCompra;
            $producto->precioVenta = $data->precioVenta;
            $producto->existencia = $data->existencia;

            if ($producto->updateProducto()) {
                http_response_code(200);
                echo json_encode(["message" => "Producto actualizado exitosamente."]);
            } else {
                http_response_code(500);
                echo json_encode(["message" => "No se pudo actualizar el producto."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Datos incompletos para actualizar."]);
        }
        break;

    case 'DELETE':
        if ($id === null) {
            http_response_code(400);
            echo json_encode(["message" => "ID del producto no especificado para eliminar."]);
            break;
        }

        $producto->idProducto = $id;

        if ($producto->borrarProducto()) {
            http_response_code(200);
            echo json_encode(["message" => "Producto eliminado exitosamente."]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "No se pudo eliminar el producto."]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["message" => "Método HTTP no permitido."]);
        break;
}
?>