<?php
    require_once("../admin/template/header.php");
?>

<div class="card text-center">
    <div class="card-header">
        CAPTURAR LA INFORMACIÓN DEL TORNEO
    </div>
    <div class="card-body">
        <form action="" method="post">
            
            <div class="mb-3">
                <label for="nombreTorneo" class="form-label">NOMBRE DEL TORNEO</label>
                <input type="text" name="txtNombreTorneo" id="nombreTorneo" class="form-control">
            </div>

            <div class="mb-3">
                <label for="organizador" class="form-label">NOMBRE COMPLETO DEL ORGANIZADOR</label>
                <input type="text" name="txtOrganizador" id="organizador" class="form-control">
            </div>

            <div class="mb-3">
                <label for="patrocinador" class="form-label">PATROCINADORES 
                    <span class="text-secondary" style="font-size: 0.8rem;">(Separar con coma si hay más de uno)</span>
                </label>
                <textarea name="txtPatrocinador" id="patrocinador" rows="3" class="form-control"></textarea>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="cede" class="form-label">SEDE (CANCHA)</label>
                    <input type="text" name="txtSede" id="cede" class="form-control">
                </div>
                <div class="col">
                    <label for="categoria" class="form-label">CATEGORÍA</label>
                    <input type="text" list="lstCategorias" name="txtCategoria" id="categoria" class="form-control">
                    <datalist id="lstCategorias">
                        <option value="Primera Fuerza">
                        <option value="Segunda Fuerza">
                        <option value="Tercera Fuerza">
                        <option value="Libre">
                        <option value="Juvenil">
                        <option value="Femenil">
                        <option value="Empresarial">
                        <option value="Infantil">
                        <option value="Minibasket">
                    </datalist>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="premio1" class="form-label">PRIMER LUGAR</label>
                    <input type="text" name="txtPremio1" id="premio1" class="form-control">
                </div>
                <div class="col">
                    <label for="premio2" class="form-label">SEGUNDO LUGAR</label>
                    <input type="text" name="txtPremio2" id="premio2" class="form-control">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="premio3" class="form-label">TERCER LUGAR</label>
                    <input type="text" name="txtPremio3" id="premio3" class="form-control">
                </div>
                <div class="col">
                    <label for="otroPremio" class="form-label">OTRO PREMIO (CAMPEÓN CANASTERO)</label>
                    <input type="text" name="txtOtroPremio" id="otroPremio" class="form-control">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="usuario" class="form-label">USUARIO PARA ORGANIZADOR</label>
                    <input type="text" name="txtUsuario" id="usuario" class="form-control">
                </div>
                <div class="col">
                    <label for="contrasena" class="form-label">CONTRASEÑA</label>
                    <input type="password" name="txtContrasena" id="contrasena" class="form-control">
                </div>
            </div>

        </form>
    </div>
    <div class="card-footer text-body-secondary">
        Formulario para registrar torneos.
    </div>
</div>

<?php
    require_once("../admin/template/footer.php");
?>