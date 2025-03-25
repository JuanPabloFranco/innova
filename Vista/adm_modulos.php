<?php
session_start();
if ((isset($_SESSION['modulos']['id']) && $_SESSION['modulos']['id'] == 2) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    include_once '../Vista/layouts/header.php'
?>
    <title>Adm | Módulos</title>
    <?php
    include_once '../Vista/layouts/nav.php';
    ?>
    <!-- Modal -->
    <script src="../Recursos/js/modulos.js"></script>
    <input type="hidden" id="txtTipoUsuario" value="<?= $_SESSION['datos'][0]->id_tipo_usuario ?>">
    <input type="hidden" id="txtCargoUsuario" value="<?= $_SESSION['datos'][0]->id_cargo <> null ? $_SESSION['datos'][0]->id_cargo : 0 ?>">
    <input type="hidden" id="txtEditar" value="<?= $_SESSION['modulos']['editar'] ?>">

    <?php
    if ($_SESSION['modulos']['crear'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade" id="crearModulo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header notiHeader">
                        <h5 class="modal-title" id="exampleModalLabel">Crear Módulo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: white;"></button>
                    </div>
                    <form id="form_crear_modulo">
                        <div class="modal-body">
                            <div class="div form-group">
                                <label for="txtNombreModulo">Nombre Módulo</label>
                                <input type="text" id="txtNombreModulo" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input type="checkbox" class="custom-control-input" id="customSwitchEliminar" checked>
                                    <label class="custom-control-label" for="customSwitchEliminar">Permite eliminar</label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn bg-gradient-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php
    }
    if ($_SESSION['modulos']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade" id="editar_modulo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header notiHeader">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Módulo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: white;"></button>
                    </div>
                    <form id="form_editar_modulo">
                        <div class="modal-body">
                            <div class="div form-group">
                                <label for="txtNombreModulo2">Nombre Módulo</label>
                                <input type="text" id="txtNombreModulo2" class="form-control" required>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="hidden" id="txtId_moduloEd">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn bg-gradient-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="cambiar_icono" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header notiHeader">
                        <h5 class="modal-title" id="exampleModalLabel">Actualizar Icono</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: white;"></button>
                    </div>
                    <form id="form_cambiar_icono" enctype="multipart/form-data">
                        <div class="input-group mb-3" style="text-align: center; justify-content: center;">
                            <img id="imgIconoModulo" style="width: 40%;">
                        </div>
                        <div class="input-group mb-3 ">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class='fas fa-image' accept="image/*"></i></span>
                            </div>
                            <input type="file" id="txtIcono" name="icono" class="form-control" required>
                            <input type="hidden" id="txtIdModuloIcono" name="id" class="form-control">
                            <input type="hidden" name="funcion" value="agregar_icono">
                        </div>
                        <div class="input-group mb-3">
                            <button type="submit" id="btnDelIcono" class="btn delIcono bg-gradient-danger float-right m-1">Eliminar Icono</button>
                            <button type="submit" class="btn bg-gradient-primary float-right m-1">Guardar</button>
                        </div>
                    </form>
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
                <div class="row mb-">
                    <div class="col-sm-6">
                        <h1>Gestión Módulos
                            <?php
                            if ($_SESSION['datos'][0]->id_tipo_usuario == 1) {
                            ?>
                                <button type="button" id="btn_crear_esal" data-bs-toggle="modal" data-bs-target="#crearModulo" class="btn bg-gradient-primary m-2">Crear Módulo</button>
                            <?php
                            }
                            ?>
                        </h1>
                    </div>
                    <div class="col-sm-6 ">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../Vista/adm_panel.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Gestión Módulos</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section>
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Buscar Módulo</h3>
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