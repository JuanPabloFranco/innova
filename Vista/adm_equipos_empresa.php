<?php
session_start();
include '../Conexion/Conexion.php';
if ((isset($_SESSION['equipos']['id']) && $_SESSION['equipos']['id'] == 10) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    include_once '../Vista/layouts/header.php';
?>
    <title>Gestión <?= isset($_SESSION['equipos']['nombre']) ? $_SESSION['equipos']['nombre'] : 'equipos' ?></title>
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
    <script src="../Recursos/js/equipos.js?v=1"></script>
    <input type="hidden" id="txtPage" value="adm_empresas">
    <input type="hidden" id="txtIdEmpresa" value="<?= $_SESSION['datos'][0]->id_empresa ?>">

    <?php
    if ($_SESSION['equipos']['crear'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade" id="crear_equipo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header notiHeader">
                        <h5 class="modal-title" id="exampleModalLabel">Crear Equipo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: white;"></button>
                    </div>
                    <form id="form_crear_equipo">
                        <div class="modal-body">
                            <div class="div form-group">
                                <label for="selTipoEquipo">Tipo Equipo</label>
                                <select id="selTipoEquipo" class="form-control" required>
                                    <option value="">Seleccione</option>
                                    <option value="Portátil"> Portátil</option>
                                    <option value="PC Escritorio">PC Escritorio</option>
                                    <option value="PC Todo En Uno">PC Todo En Uno</option>
                                    <option value="Impresora">Impresora</option>
                                </select>
                            </div>
                            <div class="div form-group">
                                <label for="txtUbicacion">Ubicación</label>
                                <input type="text" id="txtUbicacion" class="form-control" required>
                            </div>
                            <div class="div form-group">
                                <label for="selSede">Sede</label>
                                <select id="selSede" class="form-control" required>
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
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Gestión <?= isset($_SESSION['equipos']['nombre']) ? $_SESSION['equipos']['nombre'] : 'Equipos' ?>
                            <?php
                            if ($_SESSION['equipos']['crear'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
                            ?>
                                <button type="button" id="btnCrearEquipo" data-bs-toggle="modal" data-bs-target="#crear_equipo" class="btn bg-gradient-primary m-2">Crear Equipo</button>
                            <?php
                            }
                            ?>
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../Vista/adm_panel.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Gestión <?= isset($_SESSION['equipos']['nombre']) ? $_SESSION['equipos']['nombre'] : 'Equipos' ?></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section>
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Buscar</h3>
                        <div class="input-group">
                            <input type="text" id="TxtBuscar" placeholder="Ingrese el nombre, teléfono, municipio, departamento" class="form-control float-left">
                            <div class="input-group-append">
                                <button class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-0 table-responsive">
                        <table id="dataTable" class="display" style="width:100%" class="table table-hover text-nowrap">
                            <thead class="notiHeader">
                                <tr>
                                    <th>Estado</th>
                                    <th>#</th>
                                    <th>Estado</th>
                                    <th>Tipo</th>
                                    <th>Ubicación</th>
                                    <th>Sede</th>
                                    <th>Referencia</th>
                                    <th>Estado Equipo</th>
                                    <th>Persona a Cargo</th>
                                    <th>Editar</th>
                                    <th>HV PDF</th>
                                </tr>
                            </thead>
                            <tbody style="font-family: Sans-serif; font-size: 13px;"></tbody>
                        </table>
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
                allowClear: true,
                dropdownParent: $('#crear_sede')
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