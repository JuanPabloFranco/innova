<?php
session_start();
if ((isset($_SESSION['usuarios']['id']) && $_SESSION['usuarios']['id'] == 4) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    include_once '../Vista/layouts/header.php';
    include_once '../Conexion/Conexion.php';
    $año = date("Y");
    $año_inicio = 2025;
?>
    <title>Gestión Usuarios</title>
    <?php
    include_once '../Vista/layouts/nav.php';
    ?>
    <!-- Modal -->
    <script src="../Recursos/js/gestion_usuario.js?v=2"></script>
    <script type="text/javascript" language="javascript" src="../Recursos/js/ajaxCombos.js"></script>
    <input type="hidden" id="id_usuario" value="<?= $_SESSION['datos'][0]->id ?>">
    <input type="hidden" id="txtTipoUsuario" value="<?= $_SESSION['datos'][0]->id_tipo_usuario ?>">
    <input type="hidden" id="txtCargoUsuario" value="<?= $_SESSION['datos'][0]->id_cargo ?>">
    <input type="hidden" id="txtEditar" value="<?= $_SESSION['usuarios']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtVer" value="<?= $_SESSION['usuarios']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">

    <?php
    if ($_SESSION['usuarios']['editar'] == 1 || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
    ?>
        <div class="modal fade" id="confirmar_resp" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header notiHeader">
                        <h5 class="modal-title" id="exampleModalLabel">Confirmar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="form_confirmar_user">
                        <span class='ml-2'>Ingresa tu password para continuar</span>
                        <div class="modal-body">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class='fas fa-unlock-alt'></i></span>
                                </div>
                                <input type="password" id="txtPass" class="form-control" placeholder="Ingrese la contraseña actual" required>
                                <input type="hidden" id="txtId_userConfirm">
                                <input type="hidden" id="txtFuncionConfirm">
                                <input type="hidden" id="txtTipoConfirm">
                                <input type="hidden" id="txtEstadoConfirm">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn bg-gradient-primary">Guardar</button>
                        </div>
                        <div class="alert alert-success text-center" id="updateAsc" style="display: none;">
                            <span><i class='fas fa-check m-1'> Usuario Actualizado</i></span>
                        </div>
                        <div class="alert alert-danger text-center" id="noUpdateAsc" style="display: none;">
                            <span><i class='fas fa-times m-1'></i></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editar_cc" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header notiHeader">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="form_update_cc">
                        <div class="modal-body">
                            <div class="div form-group">
                                <label for="txtDoc2">No. Documento *</label>
                                <input type="text" class="form-control" pattern=".{7,10}" placeholder="Ingrese el documento de identidad" title='Debe contener entre 7 y 10 caracteres' id="txtDoc2" required>
                            </div>
                            <div class="div form-group" id="divCargo2">
                                <label for="selCargo2">Cargo *</label>
                                <select name="" id="selCargo2" class="form-control" style="width: 100%;" required>
                                    <option value="">Seleccione una opción</option>
                                    <?php
                                    $sqlTipoCargo2 = "SELECT id, nombre_cargo FROM cargos WHERE id<>1";
                                    $resCargo2 = ejecutarSQL::consultar($sqlTipoCargo2);
                                    while ($cargo2 = mysqli_fetch_array($resCargo2)) {
                                        echo '<option value="' . $cargo2['id'] . '" >' . $cargo2['nombre_cargo'] .  '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="div form-group" id="divTipoUsuario2">
                                <label for="selTipoUsuario2">Tipo Usuario *</label>
                                <select name="" id="selTipoUsuario2" class="form-control" style="width: 100%;" required>
                                    <option value="">Seleccione una opción</option>
                                    <?php
                                    $sqlTipoUsuario2 = "SELECT id, nombre_tipo FROM tipo_usuarios WHERE id<>1";
                                    $resTipos = ejecutarSQL::consultar($sqlTipoUsuario2);
                                    while ($tipoUser = mysqli_fetch_array($resTipos)) {
                                        echo '<option value="' . $tipoUser['id'] . '" >' . $tipoUser['nombre_tipo'] .  '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="div form-group" id="divSede2">
                                <label for="selEmpresa2">Sede *</label>
                                <select name="" id="selEmpresa2" class="form-control" style="width: 100%;" required>
                                        <option value="">Seleccione una opción</option>
                                        <?php
                                        $sqlSede = "SELECT id, nombre FROM empresas WHERE estado=1";

                                        $resSede = ejecutarSQL::consultar($sqlSede);
                                        while ($sede = mysqli_fetch_array($resSede)) {
                                            echo '<option value="' . $sede['id'] . '" >' . $sede['nombre'] .  '</option>';
                                        }
                                        ?>
                                    </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" id="txtIdCc">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn bg-gradient-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php
    }
    if ($_SESSION['usuarios']['crear'] == 1 || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
    ?>
        <div class="modal fade" id="crearUsuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card">
                        <div class="card-header notiHeader">
                            <h3 class="card-title">Crear Usuario</h3>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="form_crear_usuario">
                            <div class="card-body">
                                <div class="div form-group">
                                    <label for="txtNombreUsuario">Nombre Completo *</label>
                                    <input type="text" class="form-control" placeholder="Ingrese el nombre" id="txtNombreUsuario" required>
                                </div>
                                <div class="div form-group">
                                    <label for="txtDoc">No. Documento *</label>
                                    <input type="text" class="form-control" pattern=".{7,10}" placeholder="Ingrese el documento de identidad" title='Debe contener entre 7 y 10 caracteres' id="txtDoc" required>
                                </div>
                                <div class="div form-group">
                                    <label for="txtTelefono">Teléfono *</label>
                                    <input type="text" class="form-control" maxlength="10" placeholder="Ingrese el teléfono del usuario" id="txtTelefono" required>
                                </div>
                                <div class="div form-group">
                                    <label for="txtEmail">Email *</label>
                                    <input type="email" class="form-control" placeholder="Ingrese el documento de identidad" id="txtEmail" required>
                                </div>
                                <div class="div form-group" id="divTipoUsuario">
                                    <label for="selTipoUsuario">Tipo de usuario *</label>
                                    <select name="" id="selTipoUsuario" class="form-control" style="width: 100%;" required>
                                        <option value="">Seleccione una Opción</option>
                                        <?php
                                        $sqlTipoUser = "SELECT id, nombre_tipo FROM tipo_usuarios WHERE id<>1";
                                        $resTipo = ejecutarSQL::consultar($sqlTipoUser);
                                        while ($tipo = mysqli_fetch_array($resTipo)) {
                                            echo '<option value="' . $tipo['id'] . '" >' . $tipo['nombre_tipo'] .  '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="div form-group" id="divCargo">
                                    <label for="selCargo">Cargo *</label>
                                    <select name="" id="selCargo" class="form-control" style="width: 100%;" required>
                                        <option value="">Seleccione una opción</option>
                                        <?php
                                        if ($_SESSION['datos'][0]->id_cargo == 7) {
                                            $sqlTipoCargo = "SELECT id, nombre_cargo FROM cargos WHERE id=6";
                                        } else {
                                            $sqlTipoCargo = "SELECT id, nombre_cargo FROM cargos WHERE id<>1";
                                        }
                                        $resCargo = ejecutarSQL::consultar($sqlTipoCargo);
                                        while ($cargo = mysqli_fetch_array($resCargo)) {
                                            echo '<option value="' . $cargo['id'] . '" >' . $cargo['nombre_cargo'] .  '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="div form-group" id="divSede">
                                    <label for="selEmpresa">Empresa *</label>
                                    <select name="" id="selEmpresa" class="form-control" style="width: 100%;" required>
                                        <option value="">Seleccione una opción</option>
                                        <?php
                                        $sqlSede = "SELECT id, nombre FROM empresas WHERE estado=1";

                                        $resSede = ejecutarSQL::consultar($sqlSede);
                                        while ($sede = mysqli_fetch_array($resSede)) {
                                            echo '<option value="' . $sede['id'] . '" >' . $sede['nombre'] .  '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn bg-gradient-primary float-right m-1">Guardar</button>
                                <button type="button" class="btn btn-outline-secondary float-right m-1" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </form>
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
                    <div class="col-sm-9">
                        <h1>Gestión Usuarios
                            <?php
                            if ($_SESSION['usuarios']['crear'] == 1 || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
                            ?>
                                <button type="button" id="btn_crear_usuario" data-bs-toggle="modal" data-bs-target="#crearUsuario" class="btn bg-gradient-primary m-2"><i class="fas fa-users nav-icon"></i> Crear Usuario</button>
                            <?php
                            }
                            ?>
                        </h1>
                    </div>
                    <div class="col-sm-3">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../Vista/adm_panel.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Gestión Usuarios</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section>
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header notiHeader">
                        <h3 class="card-title">Buscar Usuario</h3>
                        <div class="input-group">
                            <input type="text" id="TxtBuscarUsuario" placeholder="Ingrese el nombre o teléfono" class="form-control float-left">
                            <div class="input-group-append">
                                <button class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <div id="busquedaUsuario" class="row d-flex align-items-stretch" style="overflow-y: auto; max-height: 1200px;"></div>
                    </div>
                    <div class="card-footer">
                    </div>
                </div>
            </div>
        </section>

    </div>
    <script>
        $(document).ready(function() {
            $('#selMunicipio').select2({
                // allowClear: true,
                dropdownParent: $('#divMunicipio')
            });
            $('#selTipoUsuario').select2({
                allowClear: true,
                dropdownParent: $('#divTipoUsuario')
            });
            $('#selCargo').select2({
                allowClear: true,
                dropdownParent: $('#divCargo')
            });
            $('#selSede').select2({
                allowClear: true,
                dropdownParent: $('#divSede')
            });
            $('#selTipoUsuario2').select2({
                allowClear: true,
                dropdownParent: $('#divTipoUsuario2')
            });
            $('#selCargo2').select2({
                allowClear: true,
                dropdownParent: $('#divCargo2')
            });
            $('#selSede2').select2({
                allowClear: true,
                dropdownParent: $('#divSede2')
            });
            $('#selArea2').select2({
                allowClear: true,
                dropdownParent: $('#divArea2')
            });
            $('#selArea').select2({
                allowClear: true,
                dropdownParent: $('#divArea')
            });
        });
    </script>
    <!-- /.content-wrapper -->
<?php
    include_once '../Vista/layouts/footer.php';
} else {
    header('Location: ../index.php');
}
?>