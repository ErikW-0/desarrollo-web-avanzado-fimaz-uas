<?php
namespace Controllers;

use Models\ProductoModel;
use Models\LogModel;
use Config\Csrf;

class ProductoController
{
    private ProductoModel $productoModel;

    public function __construct()
    {
        $this->productoModel = new ProductoModel();
    }

    private function verificarSesion(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['admin'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }

    /**
     * Registra una acción en la bitácora
     */
    private function registrarLog(string $accion, string $detalle = ''): void
    {
        if (isset($_SESSION['admin'])) {
            $logModel = new LogModel();
            $logModel->registrar(
                $_SESSION['admin']['id'],
                $_SESSION['admin']['nombre_completo'],
                $accion,
                $detalle
            );
        }
    }

    /**
     * Procesa la subida de imagen
     * Retorna la imagen en formato Base64 o null si no se subió imagen
     */
    private function procesarImagen(): ?string
    {
        if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        $file = $_FILES['imagen'];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['error'] = 'Error al subir la imagen.';
            return null;
        }

        // Validar tamaño (máximo 2MB)
        if ($file['size'] > 2 * 1024 * 1024) {
            $_SESSION['error'] = 'La imagen no debe superar los 2MB.';
            return null;
        }

        // Validar extensión
        $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, $extensionesPermitidas)) {
            $_SESSION['error'] = 'Solo se permiten imágenes JPG, PNG, GIF y WEBP.';
            return null;
        }

        // Leer el contenido del archivo y convertir a Base64
        $contenido = file_get_contents($file['tmp_name']);
        if ($contenido !== false) {
            // Detectar el tipo MIME real
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);
            
            // Construir la cadena Data URI
            return 'data:' . $mime . ';base64,' . base64_encode($contenido);
        }

        $_SESSION['error'] = 'No se pudo leer la imagen.';
        return null;
    }

    /**
     * Listado de productos (admin) con paginación
     */
    public function index(): void
    {
        $this->verificarSesion();

        $pagina = max(1, (int) ($_GET['pagina'] ?? 1));
        $porPagina = 10;
        $totalProductos = $this->productoModel->contarTotal();
        $totalPaginas = max(1, (int) ceil($totalProductos / $porPagina));
        $pagina = min($pagina, $totalPaginas);
        $productos = $this->productoModel->obtenerPaginado($pagina, $porPagina);

        require_once __DIR__ . '/../views/productos/index.php';
    }

    /**
     * Formulario de creación
     */
    public function create(): void
    {
        $this->verificarSesion();
        require_once __DIR__ . '/../views/productos/create.php';
    }

    /**
     * Almacenar nuevo producto
     */
    public function store(): void
    {
        $this->verificarSesion();

        // Validar CSRF
        if (!Csrf::validar()) {
            $_SESSION['error'] = 'Token de seguridad inválido. Intente de nuevo.';
            header('Location: ' . BASE_URL . '/productos/create');
            exit;
        }

        $data = [
            'sku' => trim($_POST['sku'] ?? ''),
            'nombre' => trim($_POST['nombre'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'precio_compra' => trim($_POST['precio_compra'] ?? ''),
            'precio_venta' => trim($_POST['precio_venta'] ?? ''),
            'existencia' => trim($_POST['existencia'] ?? '')
        ];

        // Validar campos obligatorios
        if (
            $data['sku'] === '' ||
            $data['nombre'] === '' ||
            $data['descripcion'] === '' ||
            $data['precio_compra'] === '' ||
            $data['precio_venta'] === '' ||
            $data['existencia'] === ''
        ) {
            $_SESSION['error'] = 'Todos los campos son obligatorios.';
            header('Location: ' . BASE_URL . '/productos/create');
            exit;
        }

        // Validar campos numéricos
        if (
            !is_numeric($data['precio_compra']) || !is_numeric($data['precio_venta'])
            || !is_numeric($data['existencia'])
        ) {
            $_SESSION['error'] = 'Precio de compra, precio de venta y existencia deben ser numéricos.';
            header('Location: ' . BASE_URL . '/productos/create');
            exit;
        }

        // Validar valores no negativos
        if (
            (float) $data['precio_compra'] < 0 || (float) $data['precio_venta'] < 0
            || (int) $data['existencia'] < 0
        ) {
            $_SESSION['error'] = 'No se permiten valores negativos.';
            header('Location: ' . BASE_URL . '/productos/create');
            exit;
        }

        // Mejora: Validar existencia >= 0
        if ((int) $data['existencia'] < 0) {
            $_SESSION['error'] = 'La existencia debe ser mayor o igual a 0.';
            header('Location: ' . BASE_URL . '/productos/create');
            exit;
        }

        // Mejora: Validar precio_venta >= precio_compra
        if ((float) $data['precio_venta'] < (float) $data['precio_compra']) {
            $_SESSION['error'] = 'El precio de venta debe ser mayor o igual al precio de compra.';
            header('Location: ' . BASE_URL . '/productos/create');
            exit;
        }

        // Mejora: Verificar SKU duplicado
        if ($this->productoModel->existePorSku($data['sku'])) {
            $_SESSION['error'] = 'El SKU "' . htmlspecialchars($data['sku']) . '" ya está registrado. Use un SKU diferente.';
            header('Location: ' . BASE_URL . '/productos/create');
            exit;
        }

        // Mejora: Subir imagen
        $imagen = $this->procesarImagen();
        $data['imagen'] = $imagen;

        if ($this->productoModel->crear($data)) {
            // Mejora: Registrar en bitácora
            $this->registrarLog('Crear producto', 'SKU: ' . $data['sku'] . ', Nombre: ' . $data['nombre']);
            $_SESSION['success'] = 'Producto registrado correctamente.';
        } else {
            $_SESSION['error'] = 'No fue posible registrar el producto.';
        }

        header('Location: ' . BASE_URL . '/productos');
        exit;
    }

    /**
     * Formulario de edición
     */
    public function edit(): void
    {
        $this->verificarSesion();

        $id = (int) ($_GET['id'] ?? 0);
        $producto = $this->productoModel->obtenerPorId($id);

        if (!$producto) {
            $_SESSION['error'] = 'Producto no encontrado.';
            header('Location: ' . BASE_URL . '/productos');
            exit;
        }

        require_once __DIR__ . '/../views/productos/edit.php';
    }

    /**
     * Actualizar producto existente
     */
    public function update(): void
    {
        $this->verificarSesion();

        // Validar CSRF
        if (!Csrf::validar()) {
            $_SESSION['error'] = 'Token de seguridad inválido. Intente de nuevo.';
            header('Location: ' . BASE_URL . '/productos');
            exit;
        }

        $id = (int) ($_POST['id'] ?? 0);

        $data = [
            'sku' => trim($_POST['sku'] ?? ''),
            'nombre' => trim($_POST['nombre'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'precio_compra' => trim($_POST['precio_compra'] ?? ''),
            'precio_venta' => trim($_POST['precio_venta'] ?? ''),
            'existencia' => trim($_POST['existencia'] ?? '')
        ];

        if ($id <= 0) {
            $_SESSION['error'] = 'ID inválido.';
            header('Location: ' . BASE_URL . '/productos');
            exit;
        }

        // Validar campos obligatorios
        if (
            $data['sku'] === '' ||
            $data['nombre'] === '' ||
            $data['descripcion'] === '' ||
            $data['precio_compra'] === '' ||
            $data['precio_venta'] === '' ||
            $data['existencia'] === ''
        ) {
            $_SESSION['error'] = 'Todos los campos son obligatorios.';
            header('Location: ' . BASE_URL . '/productos/edit?id=' . $id);
            exit;
        }

        // Validar campos numéricos
        if (
            !is_numeric($data['precio_compra']) || !is_numeric($data['precio_venta'])
            || !is_numeric($data['existencia'])
        ) {
            $_SESSION['error'] = 'Precio de compra, precio de venta y existencia deben ser numéricos.';
            header('Location: ' . BASE_URL . '/productos/edit?id=' . $id);
            exit;
        }

        // Validar valores no negativos
        if (
            (float) $data['precio_compra'] < 0 || (float) $data['precio_venta'] < 0
            || (int) $data['existencia'] < 0
        ) {
            $_SESSION['error'] = 'No se permiten valores negativos.';
            header('Location: ' . BASE_URL . '/productos/edit?id=' . $id);
            exit;
        }

        // Mejora: Validar existencia >= 0
        if ((int) $data['existencia'] < 0) {
            $_SESSION['error'] = 'La existencia debe ser mayor o igual a 0.';
            header('Location: ' . BASE_URL . '/productos/edit?id=' . $id);
            exit;
        }

        // Mejora: Validar precio_venta >= precio_compra
        if ((float) $data['precio_venta'] < (float) $data['precio_compra']) {
            $_SESSION['error'] = 'El precio de venta debe ser mayor o igual al precio de compra.';
            header('Location: ' . BASE_URL . '/productos/edit?id=' . $id);
            exit;
        }

        // Mejora: Verificar SKU duplicado (excluyendo el producto actual)
        if ($this->productoModel->existePorSku($data['sku'], $id)) {
            $_SESSION['error'] = 'El SKU "' . htmlspecialchars($data['sku']) . '" ya está registrado en otro producto.';
            header('Location: ' . BASE_URL . '/productos/edit?id=' . $id);
            exit;
        }

        // Mejora: Subir imagen (si se proporcionó una nueva)
        $imagen = $this->procesarImagen();
        if ($imagen !== null) {
            $data['imagen'] = $imagen;
        }

        if ($this->productoModel->actualizar($id, $data)) {
            // Mejora: Registrar en bitácora
            $this->registrarLog('Actualizar producto', 'ID: ' . $id . ', SKU: ' . $data['sku'] . ', Nombre: ' . $data['nombre']);
            $_SESSION['success'] = 'Producto actualizado correctamente.';
        } else {
            $_SESSION['error'] = 'No fue posible actualizar el producto.';
        }

        header('Location: ' . BASE_URL . '/productos');
        exit;
    }

    /**
     * Eliminar producto
     */
    public function delete(): void
    {
        $this->verificarSesion();

        // Validar CSRF
        if (!Csrf::validar()) {
            $_SESSION['error'] = 'Token de seguridad inválido. Intente de nuevo.';
            header('Location: ' . BASE_URL . '/productos');
            exit;
        }

        $id = (int) ($_POST['id'] ?? 0);

        if ($id <= 0) {
            $_SESSION['error'] = 'ID inválido.';
            header('Location: ' . BASE_URL . '/productos');
            exit;
        }

        // Obtener el producto para eliminar su imagen y registrar en log
        $producto = $this->productoModel->obtenerPorId($id);

        if ($this->productoModel->eliminar($id)) {
            // Mejora: Registrar en bitácora
            $this->registrarLog('Eliminar producto', 'ID: ' . $id . ($producto ? ', SKU: ' . $producto['sku'] . ', Nombre: ' . $producto['nombre'] : ''));
            $_SESSION['success'] = 'Producto eliminado correctamente.';
        } else {
            $_SESSION['error'] = 'No fue posible eliminar el producto.';
        }

        header('Location: ' . BASE_URL . '/productos');
        exit;
    }

    /**
     * Mejora: Vista de bitácora/log de acciones del admin
     */
    public function logs(): void
    {
        $this->verificarSesion();

        $logModel = new LogModel();
        $pagina = max(1, (int) ($_GET['pagina'] ?? 1));
        $porPagina = 15;
        $totalLogs = $logModel->contarTotal();
        $totalPaginas = max(1, (int) ceil($totalLogs / $porPagina));
        $pagina = min($pagina, $totalPaginas);
        $logs = $logModel->obtenerPaginado($pagina, $porPagina);

        require_once __DIR__ . '/../views/admin/logs.php';
    }
}
