<?php
use Config\Csrf;
require_once __DIR__ . '/../layouts/header.php';
?>

<h2><i class="bi bi-plus-circle"></i> Registrar producto</h2>

<form action="<?= BASE_URL ?>/productos/store" method="POST" enctype="multipart/form-data">
    <?= Csrf::campo(); ?>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">SKU <span class="text-danger">*</span></label>
                <input type="text" name="sku" class="form-control" placeholder="Ej: SKU-001" required>
                <small class="text-muted">Identificador único del producto</small>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Nombre <span class="text-danger">*</span></label>
                <input type="text" name="nombre" class="form-control" placeholder="Nombre del producto" required>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Descripción <span class="text-danger">*</span></label>
        <textarea name="descripcion" class="form-control" rows="3" required></textarea>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Precio compra <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" step="0.01" min="0" name="precio_compra" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Precio venta <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" step="0.01" min="0" name="precio_venta" class="form-control" required>
                </div>
                <small class="text-muted">Debe ser ≥ precio de compra</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Existencia <span class="text-danger">*</span></label>
                <input type="number" min="0" name="existencia" class="form-control" value="0" required>
                <small class="text-muted">Debe ser ≥ 0</small>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Imagen del producto</label>
        <input type="file" name="imagen" class="form-control" accept="image/jpeg,image/png,image/gif,image/webp">
        <small class="text-muted">Formatos: JPG, PNG, GIF, WEBP. Máximo 2MB.</small>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-success">
            <i class="bi bi-check-circle"></i> Guardar
        </button>
        <a href="<?= BASE_URL ?>/productos" class="btn btn-secondary">
            <i class="bi bi-x-circle"></i> Cancelar
        </a>
    </div>
</form>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
