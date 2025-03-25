<?php
session_start();
if ((isset($_SESSION['equipos']['id']) && $_SESSION['equipos']['id'] == 10) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    include_once '../Vista/layouts/header.php';
    include_once '../Conexion/Conexion.php';
?>
    <title id="titleProd"></title>
    <?php
    include_once '../Vista/layouts/nav.php';
    ?>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap4.min.css" />

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.bootstrap4.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap4.min.js"></script>
    <!-- Modal -->
    <script src="../Recursos/js/equipos.js"></script>
    <input type="hidden" id="txtPage" value="editar">
    <!-- Content Wrapper. Contains page content -->

    <?php
    if ($_SESSION['equipos']['crear'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade" id="crear_mantenimiento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header notiHeader">
                        <h5 class="modal-title" id="exampleModalLabel">Crear Equipo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: white;"></button>
                    </div>
                    <form id="form_crear_mantenimiento">
                        <div class="modal-body">
                            <div class="div form-group">
                                <label for="selTipoMantenimiento">Tipo</label>
                                <select id="selTipoMantenimiento" class="form-control" required>
                                    <option value="">Seleccione</option>
                                    <?php
                                    $sqlTipo = "SELECT T.id, T.nombre_tipo FROM tipo_mantenimiento T ";

                                    $resTipo = ejecutarSQL::consultar($sqlTipo);
                                    while ($tipo = mysqli_fetch_array($resTipo)) {
                                        echo '<option value="' . $tipo['id'] . '">' . $tipo['nombre_tipo'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="div form-group">
                                <label for="txtFecha">Fecha</label>
                                <input type="date" id="txtFecha" class="form-control" required>
                            </div>
                            <div class="div form-group">
                                <label for="txtDescripcion">Descripción</label>
                                <textarea id="txtDescripcion" class="form-control"></textarea>
                            </div>
                            <div class="div form-group">
                                <label for="txtRealizado">Realizado Por</label>
                                <input type="text" id="txtRealizado" value="<?= $_SESSION['datos'][0]->nombre_completo ?>" class="form-control" required>
                            </div>
                            <div class="div form-group">
                                <label for="txtObsMant">Observaciones</label>
                                <textarea id="txtObsMant" class="form-control"></textarea>
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
    if ($_SESSION['equipos']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade" id="ver_mantenimiento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header notiHeader">
                        <h5 class="modal-title" id="exampleModalLabel">Detalle Mantenimiento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: white;"></button>
                    </div>
                    <div class="modal-body">
                        <div class="div form-group">
                            <label for="">Tipo</label>
                            <p id="pTipoMantenimiento"></p>
                        </div>
                        <div class="div form-group">
                            <label for="">Fecha</label>
                            <p id="pFechaMantenimiento"></p>
                        </div>
                        <div class="div form-group">
                            <label for="">Descripción</label>
                            <p id="pDescripcionMantenimiento"></p>
                        </div>
                        <div class="div form-group">
                            <label for="">Realizado Por</label>
                            <p id="pRealizadoPor"></p>
                        </div>
                        <div class="div form-group">
                            <label for="">Observaciones</label>
                            <p id="pObservacionesMantenimiento"></p>
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
    <!-- ------ -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 id="h1Name"></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="../Vista/adm_equipos_empresa.php?modulo=adm_equipos_empresa">Gestión <?= isset($_SESSION['equipos']['nombre']) ? $_SESSION['equipos']['nombre'] : 'Equipos' ?></a></li>
                            <li class="breadcrumb-item active" id="liNameProd"></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="card">
                <div class="card-header notiHeader">
                    <h3 class="card-title">Detalles del equipo</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header notiHeader">
                                            <h3 class="card-title">Información general</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                    <i class="fas fa-minus"></i></button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <form id="form_editar_equipo">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="div form-group">
                                                                <label for="selTipoEquipo">Tipo Equipo</label>
                                                                <select id="selTipoEquipo" class="formulario form-control" required>
                                                                    <option value="">Seleccione</option>
                                                                    <option value="Portátil"> Portátil</option>
                                                                    <option value="PC Escritorio">PC Escritorio</option>
                                                                    <option value="PC Todo En Uno">PC Todo En Uno</option>
                                                                    <option value="Impresora">Impresora</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="div form-group">
                                                                <label for="txtUbicacion">Ubicación</label>
                                                                <input type="text" id="txtUbicacion" class="formulario form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="div form-group">
                                                                <label for="selSede">Sede</label>
                                                                <select id="selSede" class="formulario form-control" required>
                                                                    <option value="">Seleccione</option>
                                                                    <?php
                                                                    $sqlSedes = "SELECT S.id, S.nombre_sede, M.nombre FROM sedes_empresa S JOIN municipios M ON S.id_municipio=M.id WHERE S.id_empresa=" . $_SESSION['datos'][0]->id_empresa;

                                                                    $resSedes = ejecutarSQL::consultar($sqlSedes);
                                                                    while ($sedes = mysqli_fetch_array($resSedes)) {
                                                                        echo '<option value="' . $sedes['id'] . '">' . $sedes['nombre_sede'] . '  (' . $sedes['nombre'] . ')</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="div form-group">
                                                                <label for="txtReferencia">Referencia</label>
                                                                <input type="text" id="txtReferencia" class="form-control formulario" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="div form-group">
                                                                <label for="txtSerial">Serial</label>
                                                                <input type="text" id="txtSerial" class="form-control formulario">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="div form-group">
                                                                <label for="txtCodigoMaquina">Código Interno</label>
                                                                <input type="text" id="txtCodigoMaquina" class="form-control formulario">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="div form-group">
                                                                <label for="txtPersonaCargo">Persona a Cargo</label>
                                                                <input type="text" id="txtPersonaCargo" class="form-control formulario">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="div form-group">
                                                                <label for="txtObservaciones">Observaciones</label>
                                                                <textarea id="txtObservaciones" class="form-control formulario"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group" >
                                                                <label for="rangeEstado" style="display: flex;">Estado General del Equipo:  <p id="pEstadoGeneralLabel"></p></label>
                                                                <input type="range" min="1" max="10" class="custom-range custom-range-teal formulario" id="rangeEstado">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6" id="divProcesador">
                                                            <div class="div form-group">
                                                                <label for="txtProcesador">Procesador</label>
                                                                <input type="text" id="txtProcesador" class="form-control formulario">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6" id="divRam">
                                                            <div class="div form-group">
                                                                <label for="txtRam">Memoria Ram</label>
                                                                <input type="text" id="txtRam" class="form-control formulario">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6" id="divDD">
                                                            <div class="div form-group">
                                                                <label for="txtDiscoDuro">Disco Duro</label>
                                                                <input type="text" id="txtDiscoDuro" class="form-control formulario">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6" id="divSO">
                                                            <div class="div form-group">
                                                                <label for="txtSO">Sistema Operativo</label>
                                                                <input type="text" id="txtSO" class="form-control formulario">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6" id="divTeclado">
                                                            <div class="div form-group">
                                                                <label for="txtTeclado">Teclado</label>
                                                                <input type="text" id="txtTeclado" class="form-control formulario">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6" id="divMouse">
                                                            <div class="div form-group">
                                                                <label for="txtMouse">Mouse</label>
                                                                <input type="text" id="txtMouse" class="form-control formulario">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6" id="divMonitor">
                                                            <div class="div form-group">
                                                                <label for="txtMonitor">Monitor</label>
                                                                <input type="text" id="txtMonitor" class="form-control formulario">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6" id="divOffice">
                                                            <div class="div form-group">
                                                                <label for="txtOffice">Office</label>
                                                                <input type="text" id="txtOffice" class="form-control formulario">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6" id="divPadMouse">
                                                            <div class="div form-group">
                                                                <label for="selPadMouse">Pad Mouse</label>
                                                                <select id="selPadMouse" class="form-control formulario">
                                                                    <option value="">Seleccione</option>
                                                                    <option value="1">Si</option>
                                                                    <option value="0">No</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6" id="divTipoImpresora">
                                                            <div class="div form-group">
                                                                <label for="selTipoImpresora">Tipo Impresora</label>
                                                                <select id="selTipoImpresora" class="form-control formulario">
                                                                    <option value="">Seleccione</option>
                                                                    <option value="Laser">Laser</option>
                                                                    <option value="Térmica">Térmica</option>
                                                                    <option value="Matriz de Punto">Matriz de Punto</option>
                                                                    <option value="Sistema Continuo">Sistema Continuo</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header notiHeader">
                                            <h3 class="card-title">Mantenimientos</h3>
                                            <div class="card-tools">
                                                <button type="submit" class="btn bg-gradient-success" data-bs-toggle="modal" data-bs-target="#crear_mantenimiento" class="btn bg-gradient-warning" title="Agregar Ingrediente">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body pb-0 table-responsive">
                                            <table id="dataTable" class="display" style="width:100%" class="table table-hover text-nowrap">
                                                <thead class="notiHeader">
                                                    <tr>
                                                        <th>fecha</th>
                                                        <th>Fecha</th>
                                                        <th>Tipo</th>
                                                        <th>Realizado Por</th>
                                                        <th>Detalle</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="font-family: Sans-serif; font-size: 13px;"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2 text-center">
                            <h3 class="text-primary" style="color: #000 !important;" id="h3Name"> </h3>
                            <br>
                            <div class="text-muted">
                                <p class="text-lg" style="color: #002000;">Código Interno</p>
                                <p class="text-muted" id="codigoInterno"></p>
                            </div>
                            <br>
                            <div id="divEstado" style="font-size: 30px;"></div>
                            <hr>
                            <img id="imgProd" style="width: 40%; text-align: center;">
                            <br><br>
                            <!-- <button class='foto btn btn-sm btn-warning' type='button' data-bs-toggle="modal" data-bs-target="#agregarFoto" title='Cambiar Imagen de Producto'>
                                <i class="fas fa-image"> Cambiar Imagén de Producto</i>
                            </button> -->
                            <hr>
                            <button class='foto btn btn-sm btn-info' id="btnCambiarEstado" type='button' title='Cambiar Estado'>
                                <i class="fas fa-check"> Cambiar Estado</i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
    <div class="modal fade" id="agregarFoto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Subir Foto o Imagén del equipo</h3>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: white;">&times;</span>
                        </button>
                    </div>
                    <form id="form_agregar_foto">
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class='fas fa-image' accept="image/*"></i></span>
                                </div>
                                <input type="file" id="txtFoto" name="imagen" class="form-control" required>
                            </div>
                        </div>
                        <div class="card-footer">
                            <input type="hidden" value="agregar_imagen" name="funcion">
                            <button type="submit" class="btn bg-gradient-primary float-right m-1">Guardar</button>
                            <button type="button" class="btn btn-outline-secondary float-right m-1" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-wrapper -->
<?php
    include_once '../Vista/layouts/footer.php';
} else {
    header('Location: ../login.php');
}
?>