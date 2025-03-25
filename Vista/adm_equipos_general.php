<?php
session_start();
if ((isset($_SESSION['equipos']['id']) && $_SESSION['equipos']['id'] == 10) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    include_once '../Vista/layouts/header.php'
?>
    <title><?= $_SESSION['equipos']['nombre']?></title>
    <?php
    include_once '../Vista/layouts/nav.php';
    ?>
    <!-- Modal -->
    <script src="../Recursos/js/equipos.js"></script>
    <input type="hidden" id="txtPage" value="general">

    
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-">
                    <div class="col-sm-6">
                        <h1>Gestión <?= isset($_SESSION['equipos']['nombre']) ? $_SESSION['equipos']['nombre'] : 'Equipos' ?>
                            <?php
                            if ($_SESSION['datos'][0]->id_tipo_usuario == 1) {
                            ?>
                                <button type="button" id="btn_crear_equipo" data-bs-toggle="modal" data-bs-target="#crearEquipo" class="btn bg-gradient-primary m-2">Crear <?= $_SESSION['equipos']['nombre']?></button>
                            <?php
                            }
                            ?>
                        </h1>
                    </div>
                    <div class="col-sm-6 ">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../Vista/adm_panel.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Gestión <?= isset($_SESSION['equipos']['nombre']) ? $_SESSION['equipos']['nombre'] : 'Equipos' ?></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section>
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Buscar Empresa</h3>
                        <div class="input-group">
                            <input type="text" id="TxtBuscar" placeholder="Ingrese el nombre del módulo" class="form-control float-left">
                            <div class="input-group-append">
                                <button class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <div id="busqueda" class="row d-flex align-items-stretch" style="overflow-y: auto; max-height: 500px;"></div>
                    </div>
                    <div class="card-footer">
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- /.content-wrapper -->
<?php
    include_once '../Vista/layouts/footer.php';
} else {
    header('Location: ../Vista/524.php');
}
?>