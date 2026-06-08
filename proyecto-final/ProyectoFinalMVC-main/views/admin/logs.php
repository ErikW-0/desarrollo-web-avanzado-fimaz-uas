<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2><i class="bi bi-journal-text"></i> Bitácora de acciones</h2>
    <div>
        <a href="<?= BASE_URL ?>/productos" class="btn btn-primary">
            <i class="bi bi-box-seam"></i> Volver a productos
        </a>
    </div>
</div>

<div class="table-responsive glass-table-wrapper mb-4">
    <table class="table glass-table border-0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha y hora</th>
                <th>Usuario</th>
                <th>Acción</th>
                <th>Detalle</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($logs)): ?>
                <?php foreach ($logs as $log): ?>
                    <tr>
                        <td><?= (int) $log['id']; ?></td>
                        <td>
                            <small><?= htmlspecialchars($log['fecha']); ?></small>
                        </td>
                        <td>
                            <i class="bi bi-person-circle"></i>
                            <?= htmlspecialchars($log['usuario_nombre']); ?>
                        </td>
                        <td>
                            <?php
                            $badgeClass = 'bg-secondary';
                            $icon = 'bi-info-circle';
                            if (str_contains($log['accion'], 'Crear')) {
                                $badgeClass = 'bg-success';
                                $icon = 'bi-plus-circle';
                            } elseif (str_contains($log['accion'], 'Actualizar')) {
                                $badgeClass = 'bg-primary';
                                $icon = 'bi-pencil';
                            } elseif (str_contains($log['accion'], 'Eliminar')) {
                                $badgeClass = 'bg-danger';
                                $icon = 'bi-trash';
                            } elseif (str_contains($log['accion'], 'Inicio')) {
                                $badgeClass = 'bg-info';
                                $icon = 'bi-box-arrow-in-right';
                            } elseif (str_contains($log['accion'], 'Cierre')) {
                                $badgeClass = 'bg-warning text-dark';
                                $icon = 'bi-box-arrow-right';
                            }
                            ?>
                            <span class="badge <?= $badgeClass ?>">
                                <i class="bi <?= $icon ?>"></i> <?= htmlspecialchars($log['accion']); ?>
                            </span>
                        </td>
                        <td><small><?= htmlspecialchars($log['detalle']); ?></small></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center text-muted">No hay registros en la bitácora.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if ($totalPaginas > 1): ?>
    <nav aria-label="Paginación de bitácora">
        <ul class="pagination justify-content-center">
            <li class="page-item <?= $pagina <= 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= BASE_URL ?>/logs?pagina=<?= $pagina - 1 ?>">
                    <i class="bi bi-chevron-left"></i> Anterior
                </a>
            </li>
            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                <li class="page-item <?= $i === $pagina ? 'active' : '' ?>">
                    <a class="page-link" href="<?= BASE_URL ?>/logs?pagina=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?= $pagina >= $totalPaginas ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= BASE_URL ?>/logs?pagina=<?= $pagina + 1 ?>">
                    Siguiente <i class="bi bi-chevron-right"></i>
                </a>
            </li>
        </ul>
    </nav>
    <p class="text-muted text-center">
        Página <?= $pagina ?> de <?= $totalPaginas ?> (<?= $totalLogs ?> registros)
    </p>
<?php endif; ?>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>