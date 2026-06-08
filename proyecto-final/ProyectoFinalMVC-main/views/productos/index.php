<?php
use Config\Csrf;
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-2">
    <h2><i class="bi bi-box-seam"></i> Administración de productos</h2>
    <div class="d-flex flex-wrap gap-2">
        <a href="<?= BASE_URL ?>/productos/create" class="btn btn-success btn-sm">
            <i class="bi bi-plus-circle"></i> Nuevo producto
        </a>
        <a href="<?= BASE_URL ?>/logs" class="btn btn-secondary btn-sm">
            <i class="bi bi-journal-text"></i> Bitácora
        </a>
        <a href="<?= BASE_URL ?>/logout" class="btn btn-danger btn-sm">
            <i class="bi bi-box-arrow-right"></i> Cerrar sesión
        </a>
    </div>
</div>

<div class="table-responsive glass-table-wrapper mb-4">
    <table class="table glass-table border-0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Imagen</th>
                <th>SKU</th>
                <th>Nombre</th>
                <th>Precio compra</th>
                <th>Precio venta</th>
                <th>Existencia</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><?= (int) $producto['id']; ?></td>
                        <td>
                            <?php if (!empty($producto['imagen'])): ?>
                                <img src="<?= htmlspecialchars($producto['imagen']); ?>"
                                    alt="<?= htmlspecialchars($producto['nombre']); ?>"
                                    style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                            <?php else: ?>
                                <span class="text-muted"><i class="bi bi-image" style="font-size: 1.5rem;"></i></span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($producto['sku']); ?></td>
                        <td><?= htmlspecialchars($producto['nombre']); ?></td>
                        <td>$<?= number_format((float) $producto['precio_compra'], 2); ?></td>
                        <td>$<?= number_format((float) $producto['precio_venta'], 2); ?></td>
                        <td>
                            <?php if ((int) $producto['existencia'] <= 0): ?>
                                <span class="badge bg-danger"><?= (int) $producto['existencia']; ?></span>
                            <?php elseif ((int) $producto['existencia'] <= 5): ?>
                                <span class="badge bg-warning text-dark"><?= (int) $producto['existencia']; ?></span>
                            <?php else: ?>
                                <span class="badge bg-success"><?= (int) $producto['existencia']; ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= BASE_URL ?>/productos/edit?id=<?= (int) $producto['id']; ?>"
                                class="btn btn-primary btn-sm">
                                <i class="bi bi-pencil"></i> Editar
                            </a>

                            <form action="<?= BASE_URL ?>/productos/delete" method="POST" class="d-inline">
                                <?= Csrf::campo(); ?>
                                <input type="hidden" name="id" value="<?= (int) $producto['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('¿Deseas eliminar este producto?');">
                                    <i class="bi bi-trash"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center text-muted">No hay productos registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if ($totalPaginas > 1): ?>
    <nav aria-label="Paginación de productos">
        <ul class="pagination justify-content-center">
            <li class="page-item <?= $pagina <= 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= BASE_URL ?>/productos?pagina=<?= $pagina - 1 ?>">
                    <i class="bi bi-chevron-left"></i> Anterior
                </a>
            </li>
            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                <li class="page-item <?= $i === $pagina ? 'active' : '' ?>">
                    <a class="page-link" href="<?= BASE_URL ?>/productos?pagina=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?= $pagina >= $totalPaginas ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= BASE_URL ?>/productos?pagina=<?= $pagina + 1 ?>">
                    Siguiente <i class="bi bi-chevron-right"></i>
                </a>
            </li>
        </ul>
    </nav>
<?php endif; ?>

<p class="text-muted text-center">
    Mostrando página <?= $pagina ?> de <?= $totalPaginas ?> (<?= $totalProductos ?> productos en total)
</p>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>