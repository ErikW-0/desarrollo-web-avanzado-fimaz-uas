<?php
    require_once("../admin/template/header.php");
?>

<div class="card text-center">
    <div class="card-header">
        MENÚ
    </div>
    <div class="card-body">
        <h5 class="card-title"></h5>
        
        <div class="row mb-3">
            <div class="col">
                <div class="card text-center">
                    <div class="card-header">
                        CREAR TORNEO
                    </div>
                    <div class="card-body">
                        <a href="frmtorneos.php" class="btn btn-primary">
                            <img src="../img/torneo-admin.png" alt="Crear un torneo." width="180" height="180">
                        </a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card text-center">
                    <div class="card-header">
                        LISTA DE TORNEOS
                    </div>
                    div class="card-body">
            <a href="read_all_torneos.php" class="btn btn-primary">
                <img src="../img/lista-torneo.png" alt="Lista de torneos." width="180" height="180">
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <div class="card text-center">
                    <div class="card-header">
                        ESTADÍSTICAS
                    </div>
                    <div class="card-body">
                        <a href="#" class="btn btn-primary">
                            <img src="../img/estadisticas.png" alt="Estadísticas." width="180" height="180">
                        </a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card text-center">
                    <div class="card-header">
                        ANUNCIOS
                    </div>
                    <div class="card-body">
                        <a href="#" class="btn btn-primary">
                            <img src="../img/anuncios.png" alt="Anuncios." width="180" height="180">
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>