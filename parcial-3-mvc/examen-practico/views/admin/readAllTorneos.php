<?php
    require_once("../admin/template/header.php");
    require_once("../../controllers/torneosControllers.php");

    $objTorneosController = new torneosController();
    $rows = $objTorneosController->readTorneos();
?>

<div class="card text-center">
    <div class="card-header">
        LISTADO DE TORNEOS
    </div>
    <div class="card-body">
        <table class="table table-hover table-bordered">
            <thead class="table-light">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">TORNEO</th>
                    <th scope="col">ORGANIZADOR</th>
                    <th scope="col">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($rows): ?>
                    <?php foreach ($rows as $row): ?>
                        <tr>
                            <td><?= $row['id_torneo'] ?></td>
                            <td><?= $row['nombre_torneo'] ?></td>
                            <td><?= $row['organizador'] ?></td>
                            <td>
                                <a href="readOneTorneo.php?id=<?= $row['id_torneo'] ?>" class="btn btn-primary btn-sm">Consultar</a>
                                <a href="updateTorneo.php?id=<?= $row['id_torneo'] ?>" class="btn btn-success btn-sm">Editar</a>
                                
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#idModal<?= $row['id_torneo'] ?>">
                                    Eliminar
                                </button>

                                <div class="modal fade" id="idModal<?= $row['id_torneo'] ?>" tabindex="-1" aria-labelledby="ModalLabel<?= $row['id_torneo'] ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="ModalLabel<?= $row['id_torneo'] ?>">¿Desea eliminar el torneo?</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Esta acción no se puede deshacer. Se eliminará el torneo: <strong><?= $row['nombre_torneo'] ?></strong>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <a href="deleteTorneo.php?id=<?= $row['id_torneo'] ?>" class="btn btn-danger">Confirmar Eliminación</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No hay torneos registrados aún.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
    require_once("../admin/template/footer.php");
?>