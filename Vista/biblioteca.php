<?php
session_start();
if ((isset($_SESSION['biblioteca']['id']) && $_SESSION['biblioteca']['id'] == 9) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    include_once '../Vista/layouts/header.php'
?>
    <title>Biblioteca</title>
    <?php
    include_once '../Vista/layouts/nav.php';
    include_once '../Conexion/Conexion.php';
    ?>
    <!-- Modal -->
    <script src="../Recursos/js/archivo.js"></script>
    <input type="hidden" id="id_usuario" value="<?= $_SESSION['datos'][0]->id ?>">
    <input type="hidden" id="txtPage" value="ver">
    <input type="hidden" id="txtTipoUsuario" value="<?= $_SESSION['datos'][0]->id_tipo_usuario ?>">
    <input type="hidden" id="txtCargoUsuario" value="<?= $_SESSION['datos'][0]->id_cargo ?>">
    <input type="hidden" id="txtVer" value="<?= $_SESSION['biblioteca']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">

    <?php
    if ($_SESSION['biblioteca']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade" id="detalle_archivo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header notiHeader">
                        <h5 class="modal-title" id="exampleModalLabel">Detalle Archivo</h5>
                        <div></div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: white;"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12" id="divFechaCreacion"></div>
                            <div class="col-sm-12 text-left" id="divEstado"></div>
                            <div class="col-sm-6">
                                <p id="pNombre"></p>
                                <p id="pTipo"></p>
                            </div>
                            <div class="col-sm-6">
                                <p id="pCategoria"></p>
                                <p id="pPrivacidad"></p>
                            </div>
                            <div class="col-sm-12" id="divDescripcion"></div>
                            <div class="col-sm-12 text-right" id="divAutor"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-8">
                        <h1>Biblioteca</h1>
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../Vista/adm_panel.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Biblioteca</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section>
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Buscar Archivo</h3>
                        <div class="input-group">
                            <input type="text" id="TxtBuscarArchivo" placeholder="Ingrese nombre, descripción, tipo o categoria" class="form-control float-left">
                            <div class="input-group-append">
                                <button class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <div id="busquedaArchivos" class="row d-flex align-items-stretch" style="overflow-y: auto; max-height: 1200px;"></div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- /.content-wrapper -->
<?php
    include_once '../Vista/layouts/footer.php';
} else {
    header('Location: ../Vista/adm_panel.php');
}
?>