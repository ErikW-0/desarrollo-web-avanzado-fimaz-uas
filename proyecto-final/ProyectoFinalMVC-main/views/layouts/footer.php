    </div><!-- /.container -->
    </main>

    <!-- Footer -->
    <footer class="glass-footer text-white mt-5 pt-4 pb-3">
        <div class="container">
            <div class="row">
                <!-- Columna 1: Sobre el sistema -->
                <div class="col-md-4 mb-3">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-shop"></i> Tienda MVC
                    </h5>
                    <p class="text-white-50 small">
                        Sistema de gestión de productos desarrollado con arquitectura MVC en PHP 8,
                        PDO, Bootstrap 5, transacciones y buenas prácticas de seguridad.
                    </p>
                </div>

                <!-- Columna 2: Enlaces rápidos -->
                <div class="col-md-4 mb-3">
                    <h6 class="fw-bold text-uppercase text-light mb-3">
                        <i class="bi bi-link-45deg"></i> Accesos rápidos
                    </h6>
                    <ul class="list-unstyled small">
                        <li class="mb-1">
                            <a href="<?= BASE_URL ?>/catalogo" class="text-white-50 text-decoration-none">
                                <i class="bi bi-grid"></i> Catálogo público
                            </a>
                        </li>
                        <?php if (isset($_SESSION['admin'])): ?>
                        <li class="mb-1">
                            <a href="<?= BASE_URL ?>/productos" class="text-white-50 text-decoration-none">
                                <i class="bi bi-box-seam"></i> Administrar productos
                            </a>
                        </li>
                        <li class="mb-1">
                            <a href="<?= BASE_URL ?>/logs" class="text-white-50 text-decoration-none">
                                <i class="bi bi-journal-text"></i> Bitácora
                            </a>
                        </li>
                        <?php else: ?>
                        <li class="mb-1">
                            <a href="<?= BASE_URL ?>/login" class="text-white-50 text-decoration-none">
                                <i class="bi bi-lock"></i> Área de administradores
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- Columna 3: Autores -->
                <div class="col-md-4 mb-3">
                    <h6 class="fw-bold text-uppercase text-light mb-3">
                        <i class="bi bi-people"></i> Autores
                    </h6>
                    <ul class="list-unstyled small text-white-50">
                        <li class="mb-1"><i class="bi bi-person-fill me-1"></i> Eduardo Montes de Oca Zatarain</li>
                        <li class="mb-1"><i class="bi bi-person-fill me-1"></i> Abraham Paez Guerra</li>
                        <li class="mb-1"><i class="bi bi-person-fill me-1"></i> Erik Watson Rosales</li>
                        <li class="mb-1"><i class="bi bi-person-fill me-1"></i> Carlos Tirado Velazquez</li>
                    </ul>
                </div>
            </div>

            <hr class="border-secondary opacity-25">

            <!-- Barra inferior -->
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <small class="text-white-50">
                        &copy; <?= date('Y') ?> Tienda MVC &mdash; Facultad de Informática Mazatlán, UAS
                    </small>
                </div>
                <div class="col-md-6 text-center text-md-end mt-2 mt-md-0">
                    <small class="text-white-50">
                        Desarrollo Web Avanzado &mdash; Dr. José Alfonso Aguilar Calderón
                    </small>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
