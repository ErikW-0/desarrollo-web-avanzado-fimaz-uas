<?php
namespace Controllers;

use Models\ProductoModel;

class PublicController
{
    public function catalogo(): void
    {
        $termino = trim($_GET['buscar'] ?? '');
        $productoModel = new ProductoModel();

        // Paginación
        $pagina = max(1, (int)($_GET['pagina'] ?? 1));
        $porPagina = 9; // 3x3 grid
        $totalProductos = $productoModel->contarBusqueda($termino);
        $totalPaginas = max(1, (int)ceil($totalProductos / $porPagina));
        $pagina = min($pagina, $totalPaginas);
        $productos = $productoModel->buscarPublico($termino, $pagina, $porPagina);

        require_once __DIR__ . '/../views/public/catalogo.php';
    }
}
