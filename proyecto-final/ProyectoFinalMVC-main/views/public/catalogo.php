<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<style>
    /* Animación Hover en las tarjetas */
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.15) !important;
    }
    
    /* Animación Fade In escalonado */
    .fade-in-item {
        animation: fadeIn 0.6s ease-out forwards;
        opacity: 0;
        transform: translateY(15px);
    }
    @keyframes fadeIn {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    /* Añadir delays a los elementos de la grilla */
    .row > .col-md-4:nth-child(1) .fade-in-item { animation-delay: 0.1s; }
    .row > .col-md-4:nth-child(2) .fade-in-item { animation-delay: 0.2s; }
    .row > .col-md-4:nth-child(3) .fade-in-item { animation-delay: 0.3s; }
    .row > .col-md-4:nth-child(4) .fade-in-item { animation-delay: 0.4s; }
    .row > .col-md-4:nth-child(5) .fade-in-item { animation-delay: 0.5s; }
    .row > .col-md-4:nth-child(6) .fade-in-item { animation-delay: 0.6s; }
    .row > .col-md-4:nth-child(n+7) .fade-in-item { animation-delay: 0.7s; }
</style>

<div class="row mb-4">
    <div class="col-md-8">
        <h2><i class="bi bi-grid"></i> Catálogo público de productos</h2>
        <p>Consulta los productos disponibles y realiza búsquedas por nombre o descripción.</p>
    </div>
</div>

<form method="GET" action="<?= BASE_URL ?>/catalogo" class="row g-2 mb-4">
    <div class="col-md-10">
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
            <input type="text" name="buscar" class="form-control"
                   placeholder="Buscar por nombre o descripción"
                   value="<?= htmlspecialchars($termino ?? ''); ?>">
        </div>
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100">Buscar</button>
    </div>
</form>

<?php if (!empty($termino)): ?>
    <p class="text-muted mb-3">
        Resultados para: <strong>"<?= htmlspecialchars($termino); ?>"</strong>
        (<?= $totalProductos ?> encontrados)
        <a href="<?= BASE_URL ?>/catalogo" class="ms-2">
            <i class="bi bi-x-circle"></i> Limpiar
        </a>
    </p>
<?php endif; ?>

<div class="row">
    <?php if (!empty($productos)): ?>
        <?php foreach ($productos as $producto): ?>
            <div class="col-md-4 mb-4 fade-in-item">
                <div class="card h-100 shadow-sm">
                    <?php if (!empty($producto['imagen'])): ?>
                        <img src="<?= htmlspecialchars($producto['imagen']); ?>"
                             class="card-img-top" alt="<?= htmlspecialchars($producto['nombre']); ?>"
                             style="height: 200px; object-fit: contain; background-color: #f8f9fa;">
                    <?php else: ?>
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                             style="height: 200px;">
                            <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                        </div>
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($producto['nombre']); ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted">SKU: <?= htmlspecialchars($producto['sku']); ?></h6>
                        <p class="card-text"><?= htmlspecialchars($producto['descripcion']); ?></p>
                        <p class="fs-5 fw-bold text-primary">$<?= number_format((float)$producto['precio_venta'], 2); ?></p>
                        <p>
                            <?php if ((int)$producto['existencia'] > 0): ?>
                                <span class="badge bg-success"><i class="bi bi-check-circle"></i> En stock (<?= (int)$producto['existencia']; ?>)</span>
                            <?php else: ?>
                                <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Agotado</span>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12">
            <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle"></i> No se encontraron productos.
            </div>
        </div>
    <?php endif; ?>
</div>

<?php if ($totalPaginas > 1): ?>
<nav aria-label="Paginación del catálogo">
    <ul class="pagination justify-content-center">
        <li class="page-item <?= $pagina <= 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="<?= BASE_URL ?>/catalogo?buscar=<?= urlencode($termino) ?>&pagina=<?= $pagina - 1 ?>">
                <i class="bi bi-chevron-left"></i> Anterior
            </a>
        </li>
        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
        <li class="page-item <?= $i === $pagina ? 'active' : '' ?>">
            <a class="page-link" href="<?= BASE_URL ?>/catalogo?buscar=<?= urlencode($termino) ?>&pagina=<?= $i ?>"><?= $i ?></a>
        </li>
        <?php endfor; ?>
        <li class="page-item <?= $pagina >= $totalPaginas ? 'disabled' : '' ?>">
            <a class="page-link" href="<?= BASE_URL ?>/catalogo?buscar=<?= urlencode($termino) ?>&pagina=<?= $pagina + 1 ?>">
                Siguiente <i class="bi bi-chevron-right"></i>
            </a>
        </li>
    </ul>
</nav>
<p class="text-muted text-center">
    Página <?= $pagina ?> de <?= $totalPaginas ?>
</p>
<?php endif; ?>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
