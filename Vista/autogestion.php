<?php
session_start();
include '../Conexion/Conexion.php';
if (isset($_SESSION['datos'])) {
    include_once '../Vista/layouts/header.php'
?>
    <title>Autogetión</title>
    <?php
    include_once '../Vista/layouts/nav.php';
    ?>
    <!-- Modal -->
    <script src="../Recursos/js/autogestion.js?v=9"></script>
    <script src="../Recursos/js/user.js"></script>
    <input type="hidden" id="txtId" value="<?= $_SESSION['datos'][0]->id ?>">
    <input type="hidden" id="txtTipoUsuario" value="<?= $_SESSION['datos'][0]->id_tipo_usuario ?>">
    <input type="hidden" id="txtCargoUsuario" value="<?= $_SESSION['datos'][0]->id_cargo ?>">
    <input type="hidden" id="page" value="autogestion">

    <div class="modal fade" id="crear_solicitud" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Crear Solicitud</h3>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: white;">&times;</span>
                        </button>
                    </div>
                    <form id="form_crear_solicitud">
                        <div class="card-body">
                            <div class="div form-group">
                                <label for="selTipoSolicitud">Tipo de Solicitud *</label>
                                <select name="" id="selTipoSolicitud" class="form-control" style="width: 100%;" onblur="tipoSolicitud(this.value);" required>
                                    <option value="">Seleccione una opción</option>
                                    <option value="Día de la Familia">Día de la Familia</option>
                                    <option value="Vacaciones">Vacaciones</option>
                                    <option value="Permiso">Permiso</option>
                                    <option value="Novedad">Novedad</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                            <div class="div form-group">
                                <label for="txtFechaInicial">Fecha Inicial</label>
                                <input type="date" class="form-control" id="txtFechaInicial" onblur="calcularFechaFinal();" required>
                            </div>
                            <div class="div form-group" id="divCantidad" style="display: none;">
                                <label for="txtCantidad">Cantidad</label>
                                <input type="number" min="1" max="30" class="form-control" placeholder="Cantidad de dias a solicitar" onblur="calcularFechaFinal();" id="txtCantidad">
                            </div>
                            <div class="div form-group" id="divCantidadHoras" style="display: none;">
                                <label for="txtCantidadHoras">Cantidad Horas</label>
                                <input type="number" min="1" max="8" value="1" class="form-control" placeholder="Cantidad de horas a solicitar" id="txtCantidadHoras">
                            </div>
                            <div class="div form-group">
                                <label>Fecha Final</label>
                                <input type="text" class="form-control float-right" id="txtTiempoSolicitud" readonly>
                                <p id="pFechaFinalSolicitud"></p>
                            </div>
                            <div class="div form-group">
                                <label>Observaciones</label>
                                <textarea id="txtObservaciones" class="form-control"></textarea>
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

    <div class="modal fade" id="crear_tiempo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Crear Solicitud de tiempo para ti</h3>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: white;">&times;</span>
                        </button>
                    </div>
                    <form id="form_crear_tiempo">
                        <div class="card-body">
                            <div class="div form-group">
                                <label for="selHorario">Horario*</label>
                                <select name="" id="selHorario" class="form-control" style="width: 100%;" required>
                                    <option value="">Seleccione una opción</option>
                                    <option value="8 am - 9 am">8 am - 9 am</option>
                                    <?php
                                    if ($_SESSION['datos'][0]->id_cargo <> 16) {
                                    ?>
                                        <option value="5 pm - 6 pm">5 pm - 6 pm</option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="div form-group">
                                <label for="txtFechaAprobacion">Fecha a solicitar</label>
                                <input type="date" class="form-control" id="txtFechaAprobacion" required>
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

    <div class="modal fade" id="detalle_solicitud_tiempo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Detalle Solicitud de tiempo para ti</h3>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: white;">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-6 text-left" id="pEstado"></div>
                                    <div class="col-sm-6 text-right" id="pFechaSolicitud"></div>
                                </div>
                            </div>
                            <br>
                            <br>
                            <hr>
                            <div class="col-sm-6">
                                <h5><b>Información del Colaborador</b></h5>
                                <p id="pColaborador"></p>
                                <p id="pDocId"></p>
                                <p id="pSede"></p>
                                <p id="pCargo"></p>
                            </div>
                            <div class="col-sm-6">
                                <h5><b>Información de la Solicitud</b></h5>
                                <p id="pHorario"></p>
                                <p id="pFechaSolicitud"></p>
                                <p id="pSemana"></p>
                                <p id="pFechaAprobacion"></p>
                                <p></p>
                            </div>
                            <div class="col-sm-12">
                                <p id="pNombreAprobador"></p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-outline-secondary float-right m-1" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="crear_compensacion_horas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Solicitar Compensación de Horas Laborales</h3>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: white;">&times;</span>
                        </button>
                    </div>
                    <form id="form_crear_compensacion_horas">
                        <div class="card-body">
                            <div class="div form-group">
                                <label for="txtHorasSolicitadas">Horas Solicitadas</label>
                                <input type="number" min="1" max="8" class="form-control" placeholder="Cantidad de horas a solicitar" id="txtHorasSolicitadas" required>
                            </div>
                            <div class="div form-group">
                                <label for="txtFechaLaboradas">Cuando se laboraron</label>
                                <input type="date" class="form-control" id="txtFechaLaboradas" value="<?= date("Y-m-d") ?>" required>
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

    <div class="modal fade" id="detalle_solicitud" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Detalle Solicitud</h3>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: white;">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-6 text-left" id="pEstado"></div>
                                    <div class="col-sm-6 text-right" id="pFechaSolicitud"></div>
                                </div>
                            </div>
                            <br>
                            <br>
                            <hr>
                            <div class="col-sm-6">
                                <h5><b>Información del Colaborador</b></h5>
                                <p id="pColaborador"></p>
                                <p id="pDocId"></p>
                                <p id="pSede"></p>
                                <p id="pArea"></p>
                                <p id="pCargo"></p>
                            </div>
                            <div class="col-sm-6">
                                <h5><b>Información de la Solicitud</b></h5>
                                <p id="pTipo"></p>
                                <p id="pFechaSolicitud"></p>
                                <p id="pFechaInicial"></p>
                                <p id="pFechaFinal"></p>
                                <p id="pDiasSolicitados"></p>
                                <p id="pDiasCompensados" style="display: none;"></p>
                                <p></p>
                            </div>
                            <div class="col-sm-12">
                                <p id="pObservaciones"></p>
                            </div>
                            <div class="col-sm-12">
                                <p id="pNombreAprobador"></p>
                            </div>
                            <div class="col-sm-12">
                                <p id="pObsAprobador"></p>
                            </div>
                            <div class="col-sm-12" id="divAdjuntosSolicitud"></div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-outline-secondary float-right m-1" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detalle_incapacidad" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Detalle Incapacidad</h3>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: white;">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-6 text-left" id="pEstadoIncapacidad"></div>
                                </div>
                            </div>
                            <br>
                            <br>
                            <hr>
                            <div class="col-sm-6">
                                <h5><b>Información del Colaborador</b></h5>
                                <p id="pColaboradorIncapacidad"></p>
                                <p id="pDocIdIncapacidad"></p>
                                <p id="pSedeIncapacidad"></p>
                                <p id="pCargoIncapacidad"></p>
                            </div>
                            <div class="col-sm-6">
                                <h5><b>Información de la Incapacidad</b></h5>
                                <p id="pTipoIncapacidad"></p>
                                <p id="pInicio"></p>
                                <p id="pFin"></p>
                                <p id="pDuracion"></p>
                                <p></p>
                            </div>
                            <div class="col-sm-12">
                                <p id="pDescripcion" style="display: none;"></p>
                            </div>
                            <div class="col-sm-12">
                                <p id="pDiagnostico" style="display: none;"></p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-outline-secondary float-right m-1" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="detalle_compensacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Detalle</h3>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: white;">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6" id="divEstadoVer"></div>
                            <div class="col-sm-6" id="divDiasVer"></div>
                            <div class="col-sm-6" id="divColaborador"></div>
                            <div class="col-sm-6" id="divAutor"></div>
                            <div class="col-sm-12" id="divDetalleCompensaciones"></div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-outline-secondary float-right m-1" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="detalle_compensacion_horas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Detalle Compensación Horas Laborales </h3>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: white;">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6" id="FechaSolicitudHoras"></div>
                            <div class="col-sm-6 float-right" id="divEstadoHoras"></div>
                            <div class="col-sm-6">
                                <p id="pColaboradorHoras"></p>
                                <p id="pSedeHoras"></p>
                                <p id="pFechaLaboradosHoras"></p>
                                <p id="pFechaAprobacionHoras"></p>
                                <p id="pFechaCompensacionHoras"></p>
                            </div>
                            <div class="col-sm-6">
                                <p id="pCargoHoras"></p>
                                <p id="pAreaHoras"></p>
                                <p id="pHorasSolicitadas"></p>
                                <p id="pHorasAprobados"></p>
                                <p id="pAprobadorHoras"></p>
                            </div>
                            <div class="col-sm-12">
                                <p id="pNota"></p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-outline-secondary float-right m-1" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="crearAdjuntoSolicitud" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Subir Adjunto a la solicitud</h3>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: white;">&times;</span>
                        </button>
                    </div>
                    <form id="form_crear_adjunto_solicitud">
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class='fas fa-file'></i></span>
                                </div>
                                <input type="file" id="txtAdjunto" name="adjunto" class="form-control" required>
                            </div>
                        </div>
                        <div class="card-footer">
                            <input type="hidden" name="funcion" value="crear_adjunto_solicitud">
                            <input type="hidden" name="id_solicitud" id="txtIdSolicitudAdjunto">
                            <button type="submit" class="btn bg-gradient-primary float-right m-1">Guardar</button>
                            <button type="button" class="btn btn-outline-secondary float-right m-1" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Autogestión
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../Vista/adm_panel.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Autogestión</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section>
            <div class="row">
                <div class="col-md-3">
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <button class="imgAvatar" data-bs-toggle="modal" data-bs-target="#ver_avatar" style="width: 60%;border: none; outline: none;  color: #ffffff;padding: 10px 20px; cursor: pointer;"><img class="profile-user-img img-fluid img-circle" id="avatarScout"></button>
                            </div>

                            <h3 class="profile-username text-center" id="NombreUser"></h3>
                            <p class="text-muted text-center" id="cargo"></p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item d-flex">
                                    <b>Tipo Usuario:  </b>
                                    <div id="tipo_user"></div>
                                </li>
                                <li class="list-group-item d-flex">
                                    <b>Sede:  </b>
                                    <div id="sede"></div>
                                </li>
                                <li class="list-group-item d-flex">
                                    <b>Área:  </b>
                                    <div id="area"></div>
                                </li>
                                <li class="list-group-item d-flex">
                                    <b>Fecha Creación:  </b>
                                    <a class="float-right" id="creacion"></a>
                                </li>
                                <!-- <li class="list-group-item d-flex">
                                    <b>Última conexión:  </b>
                                    <a class="float-right" id="conexion"></a>
                                </li> -->
                                <li class="list-group-item d-flex">
                                    <b>Estado:  </b>
                                    <div id="estado"></div>
                                </li>
                                <li class="list-group-item">
                                    <b>Género:  </b> <a class="float-right" id="genero"></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Edad:  </b> <a class="float-right" id="edad"></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Documento:  </b> <a class="float-right" id="documento"></a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>

                    <!-- About Me Box -->
                    <div class="card">
                        <div class="card-header notiHeader">
                            <h3 class="card-title">Informacion</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fas fa-phone mr-1"></i> Teléfono</strong>
                            <p class="text-muted" id="telefono"></p>
                            <hr>
                            <strong><i class="fas fa-home mr-1"></i> Residencia</strong>
                            <p class="text-muted" id="residencia"></p>
                            <hr>
                            <strong><i class="fas fa-envelope mr-1"></i> Email</strong>
                            <p class="text-muted" id="email"></p>
                            <hr>
                            <strong><i class="fas fa-envelope mr-1"></i> Email Institucional</strong>
                            <p class="text-muted" id="correo_institucional"></p>
                            <hr>
                            <strong><i class="fas fa-envelope mr-1"></i> ARL</strong>
                            <p class="text-muted" id="arl"></p>
                            <hr>
                            <strong><i class="fas fa-briefcase-medical mr-1"></i> EPS</strong>
                            <p class="text-muted" id="eps"></p>
                            <hr>
                            <strong><i class="fas fa-bullhorn mr-1"></i> Cesantías</strong>
                            <p class="text-muted" id="cesantias"></p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header notiHeader">
                            <h3 class="card-title"><b>Reporte de Vacaciones</b></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="row m-3">
                                <div class="col-sm-4 text-center">
                                    <p>
                                    <h4>Disfrutados</h4>
                                    </p>
                                    <h2 style="font-size: 50px;" id="h2Disfrutados">0</h2>
                                </div>
                                <div class="col-sm-4 text-center">
                                    <p>
                                    <h4>Compensados</h4>
                                    </p>
                                    <h2 style="font-size: 50px;" id="h2Compensados">0</h2>
                                </div>
                                <div class="col-sm-4 text-center">
                                    <p>
                                    <h4>Total</h4>
                                    </p>
                                    <h2 style="font-size: 50px;" id="h2Total">0</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header notiHeader">
                            <h3 class="card-title"><b>Tiempo para Ti</b></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0" id="divTiempoParaTi" style="overflow-y: auto; max-height: 400px;"></div>
                        <div class="card-footer p-0 text-center m-3">
                            <button type="submit" class="btn bg-gradient-primary" id="btnSolicitarTiempo" style="display: none;" data-bs-toggle="modal" data-bs-target="#crear_tiempo">Solicitar</button>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header notiHeader">
                            <h3 class="card-title"><b>Horas Compensadas</b></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0" id="divCompensacionesHoras" style="overflow-y: auto; max-height: 400px;"></div>
                        <div class="card-footer p-0 text-center m-3">
                            <button type="submit" class="btn bg-gradient-primary" data-bs-toggle="modal" data-bs-target="#crear_compensacion_horas">Solicitar</button>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header notiHeader">
                            <h3 class="card-title"><b>Solicitudes (Vacaciones, dia de la familia y permisos)</b></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0" id="divSolicitudes" style="overflow-y: auto; max-height: 400px;"></div>
                        <div class="card-footer p-0 text-center m-3">
                            <button type="submit" class="btn bg-gradient-primary" data-bs-toggle="modal" data-bs-target="#crear_solicitud">Solicitar</button>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header notiHeader">
                            <h3 class="card-title"><b>Incapacidades</b></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0" id="divIncapacidades" style="overflow-y: auto; max-height: 400px;"></div>
                    </div>
                    <div class="card">
                        <div class="card-header notiHeader">
                            <h3 class="card-title"><b>Dias Compensados</b></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0" id="divCompensaciones" style="overflow-y: auto; max-height: 400px;"></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header notiHeader">
                            <h3 class="card-title"><b>Vacaciones</b></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <h5 class="text-center"><b>Fecha últimas vacaciones</b></h5>
                            <p class="text-muted text-center" id="pUltimasVacaciones">0 días tomados</p>
                            <hr>
                            <div class="info-box text-center">
                                <span class="info-box-icon bg-info elevation-1">
                                    <span class="info-box-number" id="divDiasDisponibles">
                                        0
                                    </span>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-number">
                                        Días disponibles
                                    </span>
                                </div>
                            </div>
                            <div class="info-box text-center">
                                <span class="info-box-icon bg-primary elevation-1">
                                    <span class="info-box-number" id="divDiasNuevoPeriodo">
                                        0
                                    </span>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-number">
                                        Días para acumular un nuevo periodo
                                    </span>
                                </div>
                            </div>
                            <div class="info-box text-center">
                                <span class="info-box-icon bg-warning elevation-1">
                                    <span class="info-box-number" id="divLaborados">
                                        0
                                    </span>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-number">
                                        Días laborados
                                    </span>
                                </div>
                            </div>
                            <div class="info-box text-center">
                                <span class="info-box-icon bg-success elevation-1">
                                    <span class="info-box-number" id="divPeriodos">
                                        0
                                    </span>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-number">
                                        Periodos de vacaciones
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <form id="form_carta_laboral">
                            <div class="card-header notiHeader">
                                <h3 class="card-title"><b>Carta Laboral</b></h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0" id="divCartaLaboral" style="display: none;">
                                <div class="div form-group m-2">
                                    <label for="selTipoCartaLaboral">Tipo de Carta *</label>
                                    <select id="selTipoCartaLaboral" class="form-control" required>
                                        <option value="">Seleccionar</option>
                                        <option value="salario">Carta básica con salario</option>
                                        <option value="sinSalario">Carta básica sin salario</option>
                                        <option value="sinSalarioHorario">Carta básica sin salario con horario</option>
                                        <option value="salarioHorario">Carta básica con salario y horario</option>
                                    </select>
                                </div>
                                <div class="div form-group m-2">
                                    <label for="txtDirigidoA">Dirigido a</label>
                                    <input type="text" class="form-control" placeholder="Ingrese el nombre" id="txtDirigidoA">
                                </div>
                            </div>
                            <div class="card-footer p-0 text-center m-3">
                                <button type="submit" id="btnGenerarCarta" class="btn bg-gradient-primary">Generar</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </section>
    </div>
    <script>
        $('#txtTiempoSolicitud').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        });
    </script>

    <!-- /.content-wrapper -->
<?php
    include_once '../Vista/layouts/footer.php';
} else {
    header('Location: ../Vista/adm_panel.php');
}
?>