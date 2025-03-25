<?php
session_start();
if ((isset($_SESSION['cargos']['id']) && $_SESSION['cargos']['id'] == 3) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    include_once '../Vista/layouts/header.php';
    include_once '../Conexion/Conexion.php';
?>
    <title>Gestión Cargos</title>
    <?php
    include_once '../Vista/layouts/nav.php';
    ?>
    <!-- Modal -->
    <script src="../Recursos/js/cargos.js"></script>
    <input type="hidden" id="txtPage" value="general">
    <input type="hidden" id="txtTipoUsuario" value="<?= $_SESSION['datos'][0]->id_tipo_usuario ?>">
    <input type="hidden" id="txtCargoUsuario" value="<?= $_SESSION['datos'][0]->id_cargo ?>">
    <input type="hidden" id="txtEliminar" value="<?= $_SESSION['cargos']['eliminar'] ?>">
    <input type="hidden" id="txtEditar" value="<?= $_SESSION['cargos']['editar'] ?>">
    <input type="hidden" id="txtCrear" value="<?= $_SESSION['cargos']['crear'] ?>">
    <input type="hidden" id="txtVer" value="<?= $_SESSION['cargos']['ver'] ?>">

    <?php
    if ($_SESSION['cargos']['crear'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade" id="crearCargo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header notiHeader">
                        <h5 class="modal-title" id="exampleModalLabel">Crear Cargo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: white;"></button>
                    </div>
                    <form id="form_crear_cargo">
                        <div class="modal-body">
                            <div class="div form-group">
                                <label for="txtNombreCargo">Nombre Cargo</label>
                                <input type="text" id="txtNombreCargo" class="form-control" required>
                            </div>
                            <div class="div form-group">
                                <textarea name="" id="txtDescCargo" cols="30" rows="5" placeholder="Ingresa la descripción del cargo ó las funciones" class="form-control"></textarea>
                            </div>
                            <div class="div form-group">
                                <label for="selIdJefe">Jefe Directo *</label>
                                <select name="" id="selIdJefe" class="form-control" style="width: 100%;" required>
                                    <option value="">Seleccione una opción</option>
                                    <?php
                                    $sqlJefe = "SELECT * FROM cargos WHERE id<>1 AND estado=1";
                                    $resJefe = ejecutarSQL::consultar($sqlJefe);
                                    while ($jefe = mysqli_fetch_array($resJefe)) {
                                        echo '<option value="' . $jefe['id'] . '">' . $jefe['nombre_cargo']  . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <label for="selCobertura" class="text-center">Accesos</label>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="icheck-success d-inline">
                                        <input type="checkbox" id="checkHistorias">
                                        <label for="checkHistorias">Historias</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="icheck-success d-inline">
                                        <input type="checkbox" id="checkSoporte">
                                        <label for="checkSoporte">Soporte</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="hidden" id="txtId_CargoEd" name="id">
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
    if ($_SESSION['cargos']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade" id="editar_cargo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header notiHeader">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Cargo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: white;"></button>
                    </div>
                    <form id="form_editar_cargo">
                        <div class="modal-body">
                            <div class="div form-group">
                                <label for="txtNombreCargo2">Nombre Cargo</label>
                                <input type="text" id="txtNombreCargo2" class="form-control" required>
                            </div>
                            <div class="div form-group">
                                <textarea name="" id="txtDescCargo2" cols="30" rows="5" placeholder="Ingresa la descripción del cargo ó las funciones" class="form-control"></textarea>
                            </div>
                            <div class="div form-group">
                                <label for="selIdJefe2">Jefe Directo *</label>
                                <select name="" id="selIdJefe2" class="form-control" style="width: 100%;" required>
                                    <option value="">Seleccione una opción</option>
                                    <?php
                                    $sqlJefe2 = "SELECT * FROM cargos WHERE id<>1 AND estado=1";
                                    $resJefe2 = ejecutarSQL::consultar($sqlJefe2);
                                    while ($jefe2 = mysqli_fetch_array($resJefe2)) {
                                        echo '<option value="' . $jefe2['id'] . '">' . $jefe2['nombre_cargo']  . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <label for="selCobertura" class="text-center">Permisos</label>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="icheck-success d-inline">
                                        <input type="checkbox" id="checkHistorias2">
                                        <label for="checkHistorias2">Historias</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="icheck-success d-inline">
                                        <input type="checkbox" id="checkSoporte2">
                                        <label for="checkSoporte2">Soporte</label>
                                    </div>
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
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-">
                    <div class="col-sm-6">
                        <h1>Gestión Cargos
                            <?php
                            if ($_SESSION['cargos']['crear'] == 1 || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
                            ?>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#crearCargo" class="btn bg-gradient-primary m-2">Crear Cargo</button>
                            <?php
                            }
                            ?>
                        </h1>
                    </div>
                    <div class="col-sm-6 ">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../Vista/adm_panel.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Gestión Cargos</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section>
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Buscar Cargo</h3>
                        <div class="input-group">
                            <input type="text" id="TxtBuscarCargo" placeholder="Ingrese el nombre del cargo" class="form-control float-left">
                            <div class="input-group-append">
                                <button class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <div id="busquedaCargos" class="row d-flex align-items-stretch" style="overflow-y: auto; max-height: 550px;"></div>
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