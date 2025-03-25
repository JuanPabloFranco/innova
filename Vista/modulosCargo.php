<?php
session_start();
if ((isset($_SESSION['cargos']['id']) && $_SESSION['cargos']['id'] == 3) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    include_once '../Vista/layouts/header.php';
    include_once '../Conexion/Conexion.php';
?>
    <title>Adm | Cargos</title>
    <?php
    include_once '../Vista/layouts/nav.php';
    ?>
    <!-- Modal -->
    <script src="../Recursos/js/cargos.js"></script>
    <input type="hidden" id="txtPage" value="modulos">
    <input type="hidden" id="txtTipoUsuario" value="<?= $_SESSION['datos'][0]->id_tipo_usuario ?>">
    <input type="hidden" id="txtCargoUsuario" value="<?= $_SESSION['datos'][0]->id_cargo <> null ? $_SESSION['datos'][0]->id_cargo : 0 ?>">
    <input type="hidden" id="txtEliminar" value="<?= $_SESSION['modulos']['eliminar'] ?>">
    <input type="hidden" id="txtEditar" value="<?= $_SESSION['modulos']['editar'] ?>">
    <input type="hidden" id="txtCrear" value="<?= $_SESSION['modulos']['crear'] ?>">
    <input type="hidden" id="txtVer" value="<?= $_SESSION['modulos']['ver'] ?>">
    <input type="hidden" id="txtIdCargo" value="<?= $_GET['id'] ?>">

    <?php
    if ($_SESSION['cargos']['crear'] == 1 || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
    ?>
        <div class="modal fade" id="agregarModulo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header notiHeader">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Módulo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: white;"></button>
                    </div>
                    <form id="form_crear_modulo_cargo">
                        <div class="modal-body">
                            <div class="div form-group">
                                <label for="selModulo">Modulo *</label>
                                <select name="" id="selModulo" class="form-control" style="width: 100%;" required>
                                    <option value="">Seleccione una opción</option>
                                    <?php
                                    $sqlModulos = "SELECT id, nombre FROM modulos";
                                    $resModulos = ejecutarSQL::consultar($sqlModulos);
                                    while ($modulo = mysqli_fetch_array($resModulos)) {
                                        echo '<option value="' . $modulo['id'] . '" >' . $modulo['nombre'] .  '</option>';
                                    }
                                    ?>
                                </select>
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
                        <h1>Modulos
                            <?php
                            if ($_SESSION['cargos']['crear'] == 1 || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
                            ?>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#agregarModulo" class="btn bg-gradient-primary m-2">Agregar Módulo</button>
                            <?php
                            }
                            ?>
                        </h1>
                    </div>
                    <div class="col-sm-6 ">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../Vista/adm_panel.php">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="../Vista/adm_cargos.php">Gestión Cargos</a></li>
                            <li class="breadcrumb-item active" id="liCargo"></li>
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
                            <input type="text" id="TxtBuscarModulo" placeholder="Ingrese el nombre del módulo" class="form-control float-left">
                            <div class="input-group-append">
                                <button class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <div id="busquedaModulo" class="row d-flex align-items-stretch"></div>
                    </div>
                    <div class="card-footer">
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        $('#selModulo').select2({
            dropdownParent: $('#agregarModulo')
        });
    </script>
    <!-- /.content-wrapper -->
<?php
    include_once '../Vista/layouts/footer.php';
} else {
    header('Location: ../Vista/524.php');
}
?>