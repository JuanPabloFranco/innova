<?php
session_start();
if ((isset($_SESSION['notas de inicio']['id']) && $_SESSION['notas de inicio']['id'] == 7) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    include_once '../Vista/layouts/header.php';
    include_once '../Conexion/Conexion.php';
?>
    <title>Adm | <?= isset($_SESSION['notas de inicio']['nombre']) ? $_SESSION['notas de inicio']['nombre'] : "Notas de inicio" ?></title>
    <?php
    include_once '../Vista/layouts/nav.php';
    ?>
    <!-- Modal -->
    <script src="../Recursos/js/notas.js"></script>
    <input type="hidden" id="id_usuario" value="<?= $_SESSION['datos'][0]->id ?>">
    <input type="hidden" id="txtTipoUsuario" value="<?= $_SESSION['datos'][0]->id_tipo_usuario ?>">
    <input type="hidden" id="txtCargoUsuario" value="<?= $_SESSION['datos'][0]->id_cargo ?>">
    <input type="hidden" id="txtEditar" value="<?= $_SESSION['notas de inicio']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtVer" value="<?= $_SESSION['notas de inicio']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">

    <?php
    if ($_SESSION['notas de inicio']['crear'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade" id="crearNota" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card card-success">
                        <div class="modal-header notiHeader">
                            <h3 class="card-title">Crear <?= isset($_SESSION['notas de inicio']['nombre']) ? $_SESSION['notas de inicio']['nombre'] : "Notas de inicio" ?></h3>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" style="color: white;">&times;</span>
                            </button>
                        </div>
                        <form id="form_crear_nota">
                            <div class="card-body">
                                <div class="div form-group">
                                    <label for="selTipoNota">Tipo de <?= isset($_SESSION['notas de inicio']['nombre']) ? $_SESSION['notas de inicio']['nombre'] : "Notas de inicio" ?></label>
                                    <select name="tipo_nota" id="selTipoNota" class="form-control" required>
                                        <option value="0">Seleccione una opción</option>
                                        <option value="Capacitación">Capacitación</option>
                                        <option value="Condolencia">Condolencia</option>
                                        <option value="Evento">Evento</option>
                                        <option value="Felicitación">Felicitación</option>
                                        <option value="Información Urgente">Información Urgente</option>
                                        <option value="Información">Información</option>
                                        <option value="Noticia">Noticia</option>
                                        <option value="Recordatorio">Recordatorio</option>
                                        <option value="Tarea Urgente">Tarea Urgente</option>
                                        <option value="Tarea">Tarea</option>
                                        <option value="Tip">Tip</option>
                                    </select>
                                </div>
                                <div class="div form-group">
                                    <label for="selDirigido">Dirigido a</label>
                                    <select name="dirigido" id="selDirigido" class="form-control" required>
                                        <option value="0">Seleccione una opción</option>
                                        <option value="Sede">Sede</option>
                                        <option value="Cargo">Cargo</option>
                                        <option value="Area">Area</option>
                                        <option value="Usuario">Usuario</option>
                                        <option value="Todos">Todos</option>
                                    </select>
                                </div>
                                <div class="div form-group" style="display: none;" id="divSede">
                                    <label for="selSedeNota">Sede</label>
                                    <select name="id_sede" id="selSedeNota" class="form-control" style="width: 100%;">
                                        <option value="0">Seleccione una opción</option>
                                        <?php
                                        $sql = ejecutarSQL::consultar("SELECT id, nombre FROM sedes WHERE estado=1");
                                        while ($filaSede = mysqli_fetch_array($sql)) {
                                            echo '<option value="' . $filaSede['id'] . '">' . $filaSede['nombre'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="div form-group" style="display: none;" id="divArea">
                                    <label for="selAreaNota">Area</label>
                                    <select name="id_area" id="selAreaNota" class="form-control" style="width: 100%;">
                                        <option value="0">Seleccione una opción</option>
                                        <?php
                                        $sqlAreas = "SELECT id, nombre FROM areas WHERE estado=1";
                                        $resAreas = ejecutarSQL::consultar($sqlAreas);
                                        while ($area = mysqli_fetch_array($resAreas)) {
                                            echo '<option value="' . $area['id'] . '">' . $area['nombre'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="div form-group" style="display: none;" id="divCargo">
                                    <label for="selCargoNota">Cargo</label>
                                    <select name="id_cargo" id="selCargoNota" class="form-control" style="width: 100%;">
                                        <option value="0">Seleccione una opción</option>
                                        <?php
                                        $sql = "SELECT id, nombre_cargo FROM cargos WHERE id>2";
                                        $sqlCargos = ejecutarSQL::consultar($sql);
                                        while ($filaC = mysqli_fetch_array($sqlCargos)) {
                                            echo '<option value="' . $filaC['id'] . '">' . $filaC['nombre_cargo'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="div form-group" style="display: none;" id="divUsuario">
                                    <label for="selUsuario">Usuario</label>
                                    <select name="id_usuario" id="selUsuario" class="form-control" style="width: 100%;">
                                        <option value="0">Seleccione una opción</option>
                                        <?php
                                        $sqlColaboradores = "SELECT U.id, U.nombre_completo, C.nombre_cargo FROM usuarios U JOIN cargos C ON U.id_cargo=C.id WHERE U.id<>1 AND U.estado=1";
                                        $resColaboradores = ejecutarSQL::consultar($sqlColaboradores);
                                        while ($colaborador = mysqli_fetch_array($resColaboradores)) {
                                            echo '<option value="' . $colaborador['id'] . '">' . $colaborador['nombre_completo']  . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="div form-group">
                                    <label for="txtFechaIni">Fecha Inicial</label>
                                    <input type="date" class="form-control" name="fecha_ini" placeholder="Fecha Inicio" id="txtFechaIni" required>
                                </div>
                                <div class="div form-group">
                                    <label for="txtFechaFinal">Fecha Final</label>
                                    <input type="date" class="form-control" name="fecha_fin" placeholder="Fecha Final" id="txtFechaFinal" required>
                                </div>
                                <div class="div form-group">
                                    <label for="txtDescNota">Descripción <?= isset($_SESSION['notas de inicio']['nombre']) ? $_SESSION['notas de inicio']['nombre'] : "Notas de inicio" ?></label>
                                    <textarea name="" id="txtDescNota" rows="5" placeholder="Ingresa la descripción o el contenido" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="card-footer">
                                <input type="hidden" name="funcion" value="crear_nota">
                                <input type="hidden" name="id_autor" id="txtId_autor" value="<?php echo $_SESSION['id_user']; ?>">
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
    if ($_SESSION['notas de inicio']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade" id="editar_nota" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header notiHeader">
                        <h5 class="modal-title" id="exampleModalLabel">Editar <?= isset($_SESSION['notas de inicio']['nombre']) ? $_SESSION['notas de inicio']['nombre'] : "Notas de inicio" ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: white;"></button>
                    </div>
                    <form id="form_editar_nota">
                        <div class="modal-body">
                            <div class="div form-group">
                                <label for="selTipoNota">Tipo de nota</label>
                                <select name="tipo_nota" id="selTipoNota2" class="form-control" required>
                                    <option value="0">Seleccione una opción</option>
                                    <option value="Capacitación">Capacitación</option>
                                    <option value="Condolencia">Condolencia</option>
                                    <option value="Evento">Evento</option>
                                    <option value="Felicitación">Felicitación</option>
                                    <option value="Información Urgente">Información Urgente</option>
                                    <option value="Información">Información</option>
                                    <option value="Noticia">Noticia</option>
                                    <option value="Recordatorio">Recordatorio</option>
                                    <option value="Tarea Urgente">Tarea Urgente</option>
                                    <option value="Tarea">Tarea</option>
                                    <option value="Tip">Tip</option>
                                </select>
                            </div>
                            <div class="div form-group">
                                <label for="selDirigido2">Dirigido a</label>
                                <select name="dirigido" id="selDirigido2" class="form-control" required>
                                    <option value="0">Seleccione una opción</option>
                                    <option value="Sede">Sede</option>
                                    <option value="Cargo">Cargo</option>
                                    <option value="Area">Area</option>
                                    <option value="Usuario">Usuario</option>
                                    <option value="Todos">Todos</option>
                                </select>
                            </div>
                            <div class="div form-group" style="display: none;" id="divSede2">
                                <label for="selSedeNota2">Sede</label>
                                <select name="id_sede" id="selSedeNota2" class="form-control" style="width: 100%;">
                                    <option value="0">Seleccione una opción</option>
                                    <?php
                                    $sqlSede = ejecutarSQL::consultar("SELECT id, nombre FROM sedes WHERE estado=1");
                                    while ($filaSede = mysqli_fetch_array($sqlSede)) {
                                        echo '<option value="' . $filaSede['id'] . '">' . $filaSede['nombre'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="div form-group" style="display: none;" id="divCargo2">
                                <label for="selCargoNota2">Cargo</label>
                                <select name="id_cargo" id="selCargoNota2" class="form-control" style="width: 100%;">
                                    <option value="0">Seleccione una opción</option>
                                    <?php
                                    $sql = "SELECT id, nombre_cargo FROM cargos WHERE id>2";
                                    $sqlCargos = ejecutarSQL::consultar($sql);
                                    while ($filaC = mysqli_fetch_array($sqlCargos)) {
                                        echo '<option value="' . $filaC['id'] . '">' . $filaC['nombre_cargo'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="div form-group" style="display: none;" id="divArea2">
                                <label for="selAreaNota2">Area</label>
                                <select name="id_area" id="selAreaNota2" class="form-control" style="width: 100%;">
                                    <option value="0">Seleccione una opción</option>
                                    <?php
                                    $sqlAreas = "SELECT id, nombre FROM areas WHERE estado=1";
                                    $resAreas = ejecutarSQL::consultar($sqlAreas);
                                    while ($area = mysqli_fetch_array($resAreas)) {
                                        echo '<option value="' . $area['id'] . '">' . $area['nombre'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="div form-group" style="display: none;" id="divUsuario2">
                                <label for="selUsuario2">Usuario</label>
                                <select name="id_usuario" id="selUsuario2" class="form-control" style="width: 100%;">
                                    <option value="0">Seleccione una opción</option>
                                    <?php
                                    $sqlColaboradores = "SELECT U.id, U.nombre_completo, C.nombre_cargo FROM usuarios U JOIN cargos C ON U.id_cargo=C.id WHERE U.id<>1 AND U.estado=1";
                                    $resColaboradores = ejecutarSQL::consultar($sqlColaboradores);
                                    while ($colaborador = mysqli_fetch_array($resColaboradores)) {
                                        echo '<option value="' . $colaborador['id'] . '">' . $colaborador['nombre_completo']  . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="div form-group">
                                <label for="txtFechaIni">Fecha Inicial</label>
                                <input type="date" class="form-control" name="fecha_ini" placeholder="Fecha Inicio" id="txtFechaIni2" required>
                            </div>
                            <div class="div form-group">
                                <label for="txtFechaFinal">Fecha Final</label>
                                <input type="date" class="form-control" name="fecha_fin" placeholder="Fecha Final" id="txtFechaFinal2" required>
                            </div>
                            <div class="div form-group">
                                <label for="txtDescNota">Descripción <?= isset($_SESSION['notas de inicio']['nombre']) ? $_SESSION['notas de inicio']['nombre'] : "Notas de inicio" ?></label>
                                <textarea name="" id="txtDescNota2" rows="5" placeholder="Ingresa la descripción o el contenido" class="form-control"></textarea>
                            </div>
                            <div class="input-group mb-3">
                                <input type="hidden" id="txtId_NotaEd" name="id">
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
        <div class="modal fade" id="agregar_imagen" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header notiHeader">
                        <h5 class="modal-title" id="exampleModalLabel">Editar imagén de</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="form_img_nota" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="text-center">
                                <img id="notaImg" class="profile-user-img img-fluid">
                                <div class="text-center"><b id="txtNotaImg"></b></div>
                            </div>
                            <div class="input-group mb-3 mt-2">
                                <input type="file" name="imagen" class='input-group' accept="image/*">
                                <input type="hidden" name="funcion" value="changeImagen">
                                <input type="hidden" name="id" id="txtIdNotaImg">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn bg-gradient-danger" id="deleteImg">Eliminar</button>
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
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Gestión <?= isset($_SESSION['notas de inicio']['nombre']) ? $_SESSION['notas de inicio']['nombre'] : "Notas de inicio" ?>
                            <button type="button" id="btn_crear_notas" data-bs-toggle="modal" data-bs-target="#crearNota" class="btn bg-gradient-primary m-2">Crear <?= isset($_SESSION['notas de inicio']['nombre']) ? $_SESSION['notas de inicio']['nombre'] : "Notas de inicio" ?></button>
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../Vista/adm_panel.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Gestión <?= isset($_SESSION['notas de inicio']['nombre']) ? $_SESSION['notas de inicio']['nombre'] : "Notas de inicio" ?></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section>
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-body pb-0">
                        <div id="busquedaNota" class="row d-flex align-items-stretch" style="overflow-y: auto; max-height: 1200px;"></div>
                    </div>
                    <div class="card-footer">
                    </div>
                </div>
        </section>
    </div>
    <script>
        $(document).ready(function() {
            $('#selUsuario').select2({
                allowClear: true,
                dropdownParent: $('#divUsuario')
            });
            $('#selUsuario2').select2({
                allowClear: true,
                dropdownParent: $('#divUsuario2')
            });
            $('#selSedeNota').select2({
                allowClear: true,
                dropdownParent: $('#divSede')
            });
            $('#selSedeNota2').select2({
                allowClear: true,
                dropdownParent: $('#divSede2')
            });
            $('#selCargoNota').select2({
                allowClear: true,
                dropdownParent: $('#divCargo')
            });
            $('#selCargoNota2').select2({
                allowClear: true,
                dropdownParent: $('#divCargo2')
            });
            $('#selAreaNota').select2({
                allowClear: true,
                dropdownParent: $('#divArea')
            });
            $('#selAreaNota2').select2({
                allowClear: true,
                dropdownParent: $('#divArea2')
            });
        });
    </script>
    <!-- /.content-wrapper -->
<?php
    include_once '../Vista/layouts/footer.php';
} else {
    header('Location: ../Vista/adm_panel.php');
}
?>