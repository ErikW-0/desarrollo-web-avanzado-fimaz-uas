<?php
    require_once("../admin/template/header.php");
    require_once("../../controllers/torneosControllers.php");

   
    $id = isset($_GET['id']) ? $_GET['id'] : null;

    $objController = new torneosController();
    $lstTorneo = $objController->readOneTorneo($id);

    if (!$lstTorneo) {
        echo "<script>alert('Torneo no encontrado'); window.location='readAlltorneos.php';</script>";
        exit;
    }
?>
<div class="mx-auto p-5">
    <div class="card">
        <div class="card-header">
            INFORMACIÓN DEL TORNEO.
        </div>
        <div class="card-body">
            <form>
                <div class="mb-3">
                    <label class="form-label">NOMBRE DEL TORNEO (ID: <?= $lstTorneo['id_torneo'] ?>)</label>
                    <input type="text" class="form-control" value="<?= $lstTorneo['nombre_torneo'] ?>" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">ORGANIZADOR</label>
                    <input type="text" class="form-control" value="<?= $lstTorneo['organizador'] ?>" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">PATROCINADOR(ES)</label>
                    <textarea class="form-control" rows="2" readonly><?= $lstTorneo['patrocinadores'] ?></textarea>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label class="form-label">SEDE</label>
                        <input type="text" class="form-control" value="<?= $lstTorneo['sede'] ?>" readonly>
                    </div>
                    <div class="col mb-3">
                        <label class="form-label">CATEGORÍA</label>
                        <input type="text" class="form-control" value="<?= $lstTorneo['categoria'] ?>" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label class="form-label">PREMIO 1ER. LUGAR</label>
                        <input type="text" class="form-control" value="<?= $lstTorneo['premio1'] ?>" readonly>
                    </div>
                    <div class="col mb-3">
                        <label class="form-label">OTRO PREMIO</label>
                        <input type="text" class="form-control" value="<?= isset($lstTorneo['otro_premio']) ? $lstTorneo['otro_premio'] : 'N/A' ?>" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label class="form-label">USUARIO</label>
                        <input type="text" class="form-control" value="<?= $lstTorneo['usuario'] ?>" readonly>
                    </div>
                    <div class="col mb-3">
                        <label class="form-label">CONTRASEÑA</label>
                        <input type="text" class="form-control" value="********" readonly>
                    </div>
                </div>

                <div class="col-12 mt-3">
                    <a href="readAlltorneos.php" class="btn btn-success">REGRESAR</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once("../admin/template/footer.php"); ?>