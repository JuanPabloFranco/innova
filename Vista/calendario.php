<?php
session_start();
if ((isset($_SESSION['agenda']['id']) && $_SESSION['agenda']['id'] == 8) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    include_once '../Vista/layouts/header.php';
    include_once '../Conexion/Conexion.php';
?>
    <title id="tituloPage">Calendario</title>
    <?php
    include_once '../Vista/layouts/nav.php';
    ?>
    <!-- Modal -->
    <input type="hidden" id="txtTipoUsuario" value="<?= $_SESSION['datos'][0]->id_tipo_usuario ?>">
    <input type="hidden" id="txtCargoUsuario" value="<?= $_SESSION['datos'][0]->id_cargo ?>">
    <input type="hidden" id="txtEditar" value="<?= $_SESSION['agenda']['editar'] ?>">
    <input type="hidden" id="txtVer" value="<?= $_SESSION['agenda']['ver'] ?>">
    <input type="hidden" id="txtEliminar" value="<?= $_SESSION['agenda']['eliminar'] ?>">
    <input type="hidden" id="txtPage" value="calendario">
    <link href='../Recursos/fullcalendar/main.css' rel='stylesheet' />
    <script src='../Recursos/fullcalendar/main.js'></script>
    <script src='../Recursos/fullcalendar/locales/es.js'></script>

    <script src="../Recursos/js/calendario.js?v=1"></script>
    <script type="text/javascript" language="javascript" src="../Recursos/js/ajaxCombos.js"></script>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <input type="hidden" id="txtTipoUsuario" value="<?= $_SESSION['type_id'] ?>">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-8" style="display: block;">
                        <div class="row" style="display: flex;">
                            <div class="col-sm-4" style="display: flex;">
                                <button class='btn btn-md ml-1' type='button' style="margin-top: -10px;" data-bs-toggle="modal" data-bs-target="#crearTarea" title='Crear Tarea'>
                                    <img src="../Recursos/img/btn_crear.png" style="width: 30px;">
                                </button>
                                <h5>Agenda</h5>
                            </div>
                            <div class="col-sm-4">
                                <select class="form-control" id="selIdUsuario" style="width: 100%;">
                                    <?php
                                    if ($_SESSION['datos'][0]->id_cargo <= 6) {
                                        echo '<option value="0">Todos los Colaboradores</option>';
                                        $sqlColaboradores = "SELECT U.id, U.nombre_completo, C.nombre_cargo FROM usuarios U JOIN cargos C ON U.id_cargo=C.id WHERE U.estado=1 AND U.id_tipo_usuario IN(2,3)";
                                    } else {
                                        $sqlColaboradores = "SELECT U.id, U.nombre_completo, C.nombre_cargo FROM usuarios U JOIN cargos C ON U.id_cargo=C.id WHERE U.estado=1 AND U.id=" . $_SESSION['datos'][0]->id;
                                    }
                                    $resColaboradores = ejecutarSQL::consultar($sqlColaboradores);
                                    if (mysqli_num_rows($resColaboradores) > 0) {
                                        while ($colaborador = mysqli_fetch_array($resColaboradores)) {
                                            echo '<option value="' . $colaborador['id'] . '" >' . $colaborador['nombre_completo'] . " (" . $colaborador['nombre_cargo'] .  ')</option>';
                                        }
                                    } else {
                                        echo '<option value="" >No se encontraron colaboradores</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../Vista/adm_panel.php">Inicio</a></li>
                            <li class="breadcrumb-item">Agenda</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card card-success">
                            <div id='calendar'></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="modal fade" id="modalVer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header notiHeader ">
                    <h2 id="verTitle"></h2>
                </div>
                <div class="modal-body" style="width: 95%; text-align: center;">
                    <div class="row">
                        <div class="col-sm-6">
                            <div id="badges"></div>
                            <h4 id="LTipoTarea"></h4>
                            <h5 id="LInicio"><b>Inicio</b></h5>
                            <input type="datetime-local" id="fInicio" class='form-control' readonly>
                            <h5 id="LFin"><b>Fin</b></h5>
                            <input type="datetime-local" id="fFin" class='form-control' readonly>
                            <br>
                            <h5 id="descripcion"></h5>
                            <h5 id="observaciones"></h5>
                        </div>
                        <div class="col-sm-6">
                            <br>
                            <h5><b>Responsables</b></h5>
                            <div id="divResponsablesVer"></div>
                            <br>
                            <h5 id="listaResponsables" style="font-size: 11px; overflow-y: auto; max-height: 400px;"></h5>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" id="verBotones"></div>
            </div>
        </div>
    </div>
    <div class='modal fade' id='modalEspera' tabindex='999' aria-labelledby='exampleModalLabel' aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div id='imgEspera'></div>
            </div>
        </div>
    </div>
    <?php
    if ((isset($_SESSION['agenda']['id']) && $_SESSION['agenda']['crear'] == 1) || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
    ?>
        <div class="modal fade bd-example-modal-lg" id="crearTarea" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="card card-success">
                        <div class="modal-header notiHeader">
                            <h3 class="card-title">Crear</h3>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" style="color: white;">&times;</span>
                            </button>
                        </div>
                        <form id="form_crear_tarea">
                            <div class="card-body">
                                <div class="div form-group">
                                    <label for="selTipo">Tipo *</label>
                                    <select name="" id="selTipo" class="form-control" style="width: 100%;" onchange="tipoTarea(this.value, 'crear');" required>
                                        <option value="">Seleccione una opción</option>
                                        <option value="Tarea">Tarea</option>
                                        <option value="Laboral Festivo">Laboral Festivo</option>
                                        <option value="Evento">Evento</option>
                                        <option value="Cita / Reunión">Cita / Reunión</option>
                                    </select>
                                </div>
                                <div class="div form-group">
                                    <label for="txtNombre">Nombre *</label>
                                    <input type="text" class="form-control" id="txtNombre" required>
                                </div>
                                <div class="div form-group">
                                    <label>Descripción *</label>
                                    <textarea id="txtDescripcion" rows="3" placeholder="Describe con detalle" class="form-control" required></textarea>
                                </div>
                                <div class="div form-group">
                                    <label for="txtFechaInicial">Fecha Inicial *</label>
                                    <input type="datetime-local" class="form-control" id="txtFechaInicial" required>
                                </div>
                                <div class="div form-group">
                                    <label for="txtFechaFin">Fecha Fin *</label>
                                    <input type="datetime-local" class="form-control" id="txtFechaFin" required>
                                </div>
                                <div class="div form-group" id="divUbicacion" style="display: none;">
                                    <label for="selUbicacion">Ubicación</label>
                                    <select name="" id="selUbicacion" class="form-control" style="width: 100%;">
                                        <option value="">Seleccione una opción</option>
                                        <option value="Virtual">Virtual</option>
                                        <option value="Presencial">Presencial</option>
                                    </select>
                                </div>
                                <div class="div form-group" id="divUbicacionDesc" style="display: none;">
                                    <label>Descripción Ubicación</label>
                                    <textarea id="txtDescripcionUbicacion" rows="3" placeholder="La dirección o link de la reunión" class="form-control"></textarea>
                                </div>
                                <div class="div form-group">
                                    <label for="selResponsable">Responsables *</label>
                                    <?php
                                    if ($_SESSION['datos'][0]->id_cargo == 3 || $_SESSION['datos'][0]->id_cargo == 5 || $_SESSION['datos'][0]->id_cargo == 6 || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
                                    ?>
                                        <button class='btn btn-sm' type='button' id="btnAgregarResponsables" title='Agregar Todos' onclick="agregarTodos('divResponsables');">
                                            <img src="../Recursos/img/infinito.png" style="width: 30px;">
                                        </button>
                                    <?
                                    }
                                    ?>
                                    <div style="display: flex;">
                                        <select name="" id="selResponsable" class="form-control" style="width: 100%;">
                                            <option value="">Seleccione una opción</option>
                                            <?php
                                            if ($_SESSION['datos'][0]->id_cargo == 3 || $_SESSION['datos'][0]->id_cargo == 9 || $_SESSION['datos'][0]->id_cargo == 17 || $_SESSION['datos'][0]->id_cargo == 5 || $_SESSION['datos'][0]->id_cargo == 6 || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
                                                $sqlResponsable = "SELECT U.id, U.nombre_completo, C.nombre_cargo FROM usuarios U JOIN cargos C ON U.id_cargo=C.id WHERE U.estado=1 AND (U.id_tipo_usuario=3 OR U.id_tipo_usuario=2)";
                                            } else {
                                                $sqlResponsable = "SELECT U.id, U.nombre_completo, C.nombre_cargo FROM usuarios U JOIN cargos C ON U.id_cargo=C.id WHERE U.id =" . $_SESSION['datos'][0]->id;
                                            }
                                            $resResponsable = ejecutarSQL::consultar($sqlResponsable);
                                            while ($responsable = mysqli_fetch_array($resResponsable)) {
                                                echo '<option value="' . $responsable['id'] . '" >' . $responsable['nombre_completo'] .  '</option>';
                                            }
                                            ?>
                                        </select>
                                        <button class='btn btn-sm' type='button' id="btnAgregarResponsable" title='Agregar Responsable' onclick="agregarResponsable('divResponsables');">
                                            <img src="../Recursos/img/btn_crear.png" style="width: 30px;">
                                        </button>

                                    </div>
                                </div>
                                <div id="divResponsables"></div>

                                <div class="div form-group">
                                    <label>Observaciones</label>
                                    <textarea id="txtObservaciones" class="form-control" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" id="btnGuardarTarea" class="btn bg-gradient-primary float-right m-1">Guardar</button>
                                <button type="button" class="btn btn-outline-secondary float-right m-1" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <?php
    }
    if ((isset($_SESSION['agenda']['id']) && $_SESSION['agenda']['editar'] == 1) || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
    ?>
        <div class="modal fade bd-example-modal-lg" id="editarTarea" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="card card-success">
                        <div class="modal-header notiHeader">
                            <h3 class="card-title">Editar</h3>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" style="color: white;">&times;</span>
                            </button>
                        </div>
                        <form id="form_editar_tarea">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="div form-group">
                                            <label for="selTipo2">Tipo *</label>
                                            <select name="" id="selTipo2" class="form-control" style="width: 100%;" onchange="tipoTarea(this.value, 'editar');" required>
                                                <option value="">Seleccione una opción</option>
                                                <option value="Laboral Festivo">Laboral Festivo</option>
                                                <option value="Tarea">Tarea</option>
                                                <option value="Evento">Evento</option>
                                                <option value="Cita / Reunión">Cita / Reunión</option>
                                            </select>
                                        </div>
                                        <div class="div form-group">
                                            <label for="txtNombre2">Nombre *</label>
                                            <input type="text" class="form-control" id="txtNombre2" required>
                                        </div>
                                        <div class="div form-group">
                                            <label>Descripción *</label>
                                            <textarea id="txtDescripcion2" rows="5" placeholder="Describe con detalle" class="form-control" required></textarea>
                                        </div>
                                        <div class="div form-group">
                                            <label for="txtFechaInicial2">Fecha Inicial *</label>
                                            <input type="datetime-local" class="form-control" id="txtFechaInicial2" required>
                                        </div>
                                        <div class="div form-group">
                                            <label for="txtFechaFin2">Fecha Fin *</label>
                                            <input type="datetime-local" class="form-control" id="txtFechaFin2" required>
                                        </div>
                                        <div class="div form-group" id="divUbicacion2" style="display: none;">
                                            <label for="selUbicación2">Ubicación</label>
                                            <select name="" id="selUbicación2" class="form-control" style="width: 100%;">
                                                <option value="">No Aplica</option>
                                                <option value="Virtual">Virtual</option>
                                                <option value="Presencial">Presencial</option>
                                            </select>
                                        </div>
                                        <div class="div form-group" id="divUbicacionDesc2" style="display: none;">
                                            <label>Descripción Ubicación</label>
                                            <textarea id="txtDescripcionUbicacion2" rows="3" placeholder="La dirección o link de la reunión" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="div form-group">
                                            <label for="selResponsable2">Responsables *</label>
                                            <div style="display: flex;">
                                                <select name="" id="selResponsable2" class="form-control" style="width: 100%;">
                                                    <option value="">Seleccione una opción</option>
                                                    <?php
                                                    if ($_SESSION['datos'][0]->id_cargo == 3 || $_SESSION['datos'][0]->id_cargo == 9 || $_SESSION['datos'][0]->id_cargo == 17 || $_SESSION['datos'][0]->id_cargo == 5 || $_SESSION['datos'][0]->id_cargo == 6) {
                                                        $sqlResponsable = "SELECT U.id, U.nombre_completo, C.nombre_cargo FROM usuarios U JOIN cargos C ON U.id_cargo=C.id WHERE U.estado=1 AND (U.id_tipo_usuario=3 OR U.id_tipo_usuario=2)";
                                                    } else {
                                                        $sqlResponsable = "SELECT U.id, U.nombre_completo, C.nombre_cargo FROM usuarios U JOIN cargos C ON U.id_cargo=C.id WHERE U.id =" . $_SESSION['datos'][0]->id;
                                                    }

                                                    $resResponsable = ejecutarSQL::consultar($sqlResponsable);
                                                    while ($responsable = mysqli_fetch_array($resResponsable)) {
                                                        echo '<option value="' . $responsable['id'] . '" >' . $responsable['nombre_completo'] .  '</option>';
                                                    }
                                                    ?>
                                                </select>
                                                <button class='btn btn-sm' type='button' id="btnAgregarResponsable2" title='Agregar Responsable' onclick="agregarResponsable('divResponsables2');">
                                                    <img src="../Recursos/img/btn_crear.png" style="width: 30px;">
                                                </button>
                                            </div>
                                        </div>
                                        <div id="divResponsables2"></div>
                                        <hr>
                                        <div class="div form-group">
                                            <label>Observaciones</label>
                                            <textarea id="txtObservaciones2" class="form-control" rows="4"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <input type="hidden" id="txtIdTareaEdit">
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
    <script>
        $(document).ready(function() {
            $('#selIdUsuario').select2({});
            $('#selResponsable').select2({});
            $('#selResponsable2').select2({});
        });
    </script>
    <style>
        .modal {
            z-index: 1050;
        }

        .modal-backdrop {
            z-index: 1040;
        }
    </style>

    <!-- /.content-wrapper -->
<?php
    include_once '../Vista/layouts/footer.php';
} else {
    header('Location: ../Vista/524.php');
}
