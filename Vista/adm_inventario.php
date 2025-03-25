<?php
session_start();
if ((isset($_SESSION['inventario salas']['id']) && $_SESSION['inventario salas']['id'] == 19 && $_SESSION['inventario salas']['ver'] == 1) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    include_once '../Vista/layouts/header.php';
    include_once '../Conexion/Conexion.php';
?>
    <title>Inventario</title>
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
    <script src="https://cdn.jsdelivr.net/npm/table2excel@1.0.4/dist/table2excel.min.js"></script>
    <!-- Modal -->
    <script src="../Recursos/js/productos.js?v=4"></script>

    <input type="hidden" id="txtPage" value="inventario">
    <input type="hidden" id="id_usuario" value="<?= $_SESSION['datos'][0]->id ?>">
    <input type="hidden" id="txtTipoUsuario" value="<?= $_SESSION['datos'][0]->id_tipo_usuario ?>">
    <input type="hidden" id="txtCargoUsuario" value="<?= $_SESSION['datos'][0]->id_cargo ?>">
    <input type="hidden" id="txtEditar" value="<?= $_SESSION['inventario salas']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtVer" value="<?= $_SESSION['inventario salas']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">

    <!-- Content Wrapper. Contains page content -->
    <div class="modal fade" id="subirInventarioCsv" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Registro de Inventario desde Archivo Plano</h3>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: white;">&times;</span>
                        </button>
                    </div>
                    <form id="registro_inventario_csv" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <!-- <h5>El archivo debe ser guardado en csv separado por comas y la fila de títulos se debe eliminar</h5> -->
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class='fas fa-file-csv'></i></span>
                                </div>
                                <input type="file" id="txtArchivo" accept=".csv" name="archivo" class="form-control" required>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div id="respuesta"></div>
                            <button type="submit" id="btnSubirInventarioCsv" class="btn bg-gradient-primary float-right m-1">Guardar</button>
                            <input type="hidden" name="funcion" value="registro_inventario_csv">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="listaSedesCodigo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Codigo de Sedes</h3>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: white;">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="input-group mb-3" id="divSedesCodigo"></div>
                    </div>
                    <div class="card-footer">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Inventario
                            <?php
                            if ((isset($_SESSION['inventario salas']) && $_SESSION['inventario salas']['crear'] == 1) || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
                            ?>
                                <button type="button" id="btn_subir_inventario_csv" data-bs-toggle="modal" data-bs-target="#subirInventarioCsv" class="btn bg-gradient-secondary m-2"><i class="nav-icon"><img style="width: 20px;" src="../Recursos/img/xls.png" alt=""></i> Subir desde CSV</button>
                                <a class="btn bg-gradient-success" href="../Recursos/formato_csv registro inventario.zip" title="Formato CSV"><i class="fas fa-file-excel"></i></a>
                                <button type="button" id="btn_codigo_sedes" data-bs-toggle="modal" data-bs-target="#listaSedesCodigo" class="btn bg-gradient-info m-2"><i class="nav-icon"><img style="width: 20px;" src="../Recursos/img/home.png" alt=""></i> Códigos Sedes</button>
                            <?php
                            }
                            ?>
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../Vista/adm_panel.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Inventario</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <?php
        if ((isset($_SESSION['inventario salas']['id']) && $_SESSION['inventario salas']['ver']) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
        ?>
            <section>
                <div class="container-fluid">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Descargar en excel</h3>
                        <div class="input-group">
                            <select name="" id="selTipoReporte" class="form-control float-left">
                                <option value="full">Inventario General</option>
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-success" id="exportar"><i class="excel fas fa-file-excel"></i></button>
                            </div>
                            <form action="../Recursos/xls/excelInventario.php" method="post" role="form" id="formExcel">
                                <input type="hidden" id="txtAccion" name="accion">
                            </form>
                        </div>
                    </div>
                    <div class="card card_personalizada card-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs">
                                <li class="nav-item"><a href="#productos" class="nav-link active" data-bs-toggle='tab'>Inventario</a></li>
                                <li class="nav-item"><a href="#ventasSala" class="nav-link" data-bs-toggle='tab'>Salidas de Productos</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="productos">
                                    <div class="card card-success">
                                        <div class="modal-header notiHeader">
                                        </div>
                                        <div class="card-body pb-0 table-responsive">
                                            <table id="tablaInventario" class="display" style="width:100%" class="table table-hover text-nowrap">
                                                <thead class="notiHeader">
                                                    <tr>
                                                        <th>Código</th>
                                                        <th>Código Barras</th>
                                                        <th>Nombre Producto</th>
                                                        <th>Nombre Sede (Sala)</th>
                                                        <th>Cantidad</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="font-family: Sans-serif; font-size: 13px;"></tbody>
                                            </table>
                                        </div>
                                        <div class="card-footer">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="ventasSala">
                                    <div class="card card-success">
                                        <div class="modal-header notiHeader">
                                            <h3 class="card-title">Registrar Salida de Productos de Sede</h3>
                                            <div class="input-group">
                                                <?php
                                                if ($_SESSION['datos'][0]->id_cargo <= 5 || $_SESSION['datos'][0]->id_cargo == 18) {
                                                ?>
                                                    <select name="" id="selSede" class="form-control" style="width: 100%;" required>
                                                        <option value="">Seleccione una sede</option>
                                                        <?php
                                                        $sqlSede = "SELECT id, nombre FROM sedes WHERE estado=1";

                                                        $resSede = ejecutarSQL::consultar($sqlSede);
                                                        while ($sede = mysqli_fetch_array($resSede)) {
                                                            echo '<option value="' . $sede['id'] . '" >' . $sede['nombre'] .  '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                <?php
                                                } else {
                                                ?>
                                                    <input type="text" id="txtNombreSede" readonly class="form-control" value="<?= $_SESSION['datos'][0]->nombre_sede ?>">
                                                    <input type="hidden" id="selSede" class="form-control" value="<?= $_SESSION['datos'][0]->id_sede ?>">
                                                <?php
                                                }
                                                ?>

                                                <div class="input-group-append">
                                                    <button class="btn btn-info" id="btnCrearVenta"><i class="fas fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body pb-0 table-responsive">
                                            <table id="tablaSalidas" class="display" style="width:100%" class="table table-hover text-nowrap">
                                                <thead class="notiHeader">
                                                    <tr>
                                                        <th>Código</th>
                                                        <th>Estado</th>
                                                        <th>Sede</th>
                                                        <th>Fecha</th>
                                                        <th>Creado Por</th>
                                                        <th>Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="font-family: Sans-serif; font-size: 13px;"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php
        }
        ?>
    </div>
    <!-- /.content-wrapper -->
<?php
    include_once '../Vista/layouts/footer.php';
} else {
    header('Location: ../index.php');
}
?>