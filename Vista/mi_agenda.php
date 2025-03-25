<?php
session_start();
if ((isset($_SESSION['agenda']['id']) && $_SESSION['agenda']['id'] == 8) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    include_once '../Vista/layouts/header.php';
    include_once '../Conexion/Conexion.php';
?>
    <title>Adm | <?= isset($_SESSION['agenda']['nombre']) ? $_SESSION['agenda']['nombre'] : "agenda" ?></title>
    <?php
    include_once '../Vista/layouts/nav.php';
    ?>
    <!-- Modal -->
    <script src="../Recursos/js/calendario.js"></script>
    <input type="hidden" id="id_usuario" value="<?= $_SESSION['datos'][0]->id ?>">
    <input type="hidden" id="txtPage" value="mi_agenda">
    <input type="hidden" id="txtTipoUsuario" value="<?= $_SESSION['datos'][0]->id_tipo_usuario ?>">
    <input type="hidden" id="txtCargoUsuario" value="<?= $_SESSION['datos'][0]->id_cargo ?>">
    <input type="hidden" id="txtEditar" value="<?= $_SESSION['agenda']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtEliminar" value="<?= $_SESSION['agenda']['eliminar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtVer" value="<?= $_SESSION['agenda']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">

    <div class='modal fade' id='modalEspera' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div id='imgEspera'></div>
            </div>
        </div>
    </div>
    <?php
    if ((isset($_SESSION['agenda']['id']) && $_SESSION['agenda']['editar'] == 1) || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
    ?>
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
                                <h5 id="copy"></h5>
                            </div>
                            <div class="col-sm-6">
                                <h5 id="ubicacion"></h5>
                                <h5 id="gestion"></h5>
                                <h5 id="redes"></h5>
                                <br>
                                <h5><b>Responsables</b></h5>
                                <div id="divResponsablesVer"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" id="verBotones"></div>
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
                            <h3 class="card-title">Editar Tarea</h3>
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
                                                <option value="Tarea">Tarea</option>
                                                <option value="Laboral Festivo">Laboral Festivo</option>
                                                <option value="Evento">Evento</option>
                                                <option value="Cita / Reunión">Cita / Reunión</option>
                                            </select>
                                        </div>
                                        <div class="div form-group">
                                            <label for="txtNombre2">Nombre *</label>
                                            <input type="text" class="form-control" id="txtNombre2" required>
                                        </div>
                                        <div class="div form-group">
                                            <label>Descripción tarea *</label>
                                            <textarea id="txtDescripcion2" rows="5" placeholder="Describe la tarea con detalle" class="form-control" required></textarea>
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
                                    <div class="col-sm-6" id="divListaResponsables">
                                        <div class="div form-group">
                                            <label for="selResponsable2">Responsables de la tarea *</label>
                                            <div style="display: flex;">
                                                <select name="" id="selResponsable2" class="form-control" style="width: 100%;">
                                                    <option value="">Seleccione una opción</option>
                                                    <?php
                                                    $sqlResponsable = "SELECT U.id, U.nombre_completo, C.nombre_cargo FROM usuarios U JOIN cargos C ON U.id_cargo=C.id WHERE U.estado=1 AND (U.id_tipo_usuario=3 OR U.id_tipo_usuario=2)";

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

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Gestión <?= isset($_SESSION['agenda']['nombre']) ? $_SESSION['agenda']['nombre'] : "agenda" ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../Vista/adm_panel.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Gestión <?= isset($_SESSION['agenda']['nombre']) ? $_SESSION['agenda']['nombre'] : "agenda" ?></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section>
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Buscar </h3>
                        <div class="input-group">
                            <input type="text" id="TxtBuscar" placeholder="Ingrese nombre, descripción o tipo" class="form-control float-left">
                            <div class="input-group-append">
                                <button class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <div id="busqueda" class="row d-flex align-items-stretch" style="overflow-y: auto; max-height: 1200px;"></div>
                    </div>
                    <div class="card-footer">
                    </div>
                </div>
        </section>
    </div>
    <script>
        $(document).ready(function() {
            $('#selResponsable2').select2({
                allowClear: true,
                dropdownParent: $('#divListaResponsables')
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