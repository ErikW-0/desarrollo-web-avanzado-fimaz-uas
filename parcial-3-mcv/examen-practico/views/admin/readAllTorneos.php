<?php
    require_once("../admin/template/header.php");
    require_once("../../controllers/torneosController.php");

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
                            <th><?= $row['id_torneo'] ?></th>
                            <td><?= $row['nombre_torneo'] ?></td>
                            <td><?= $row['organizador'] ?></td>
                            <td>
                                ACCIONES: EDITAR, ELIMINAR.
                                <a href="readOneTorneo.php?id=<?= $row['id'] ?>" class="btn btn-primary">Consultar</a>
                                <a href="updateTorneo.php?id=<?= $row['id'] ?>" class="btn btn-primary">Editar</a>
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