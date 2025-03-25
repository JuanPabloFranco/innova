<?php
session_start();
include '../Conexion/Conexion.php';
if ((isset($_SESSION['empresas']['id']) && $_SESSION['empresas']['id'] == 5) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    include_once '../Vista/layouts/header.php';
?>
    <title>Gestión <?= isset($_SESSION['empresas']['nombre']) ? $_SESSION['empresas']['nombre'] : 'Empresas' ?></title>
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
    <script src="../Recursos/js/empresas.js?v=1"></script>
    <input type="hidden" id="id_usuario" value="<?= $_SESSION['datos'][0]->id ?>">
    <input type="hidden" id="txtTipoUsuario" value="<?= $_SESSION['datos'][0]->id_tipo_usuario ?>">
    <input type="hidden" id="txtCargoUsuario" value="<?= $_SESSION['datos'][0]->id_cargo ?>">
    <input type="hidden" id="txtEditar" value="<?= $_SESSION['empresas']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtVer" value="<?= $_SESSION['empresas']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtPage" value="adm">

    <?php
    if ($_SESSION['empresas']['crear'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade" id="crear_empresa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card card-success">
                        <div class="modal-header notiHeader">
                            <h3 class="card-title">Crear Empresa</h3>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" style="color: white;">&times;</span>
                            </button>
                        </div>
                        <form id="form_crear_empresa">
                            <div class="card-body">
                                <div class="div form-group">
                                    <label for="txtNombre">Nombre de la Empresa *</label>
                                    <input type="text" class="form-control" placeholder="Ingrese el nombre de la sede" id="txtNombre" required>
                                </div>
                                <div class="div form-group">
                                    <label for="txtTelefono">Teléfono Contacto *</label>
                                    <input type="text" class="form-control" placeholder="Ingrese el teléfono" id="txtTelefono">
                                </div>
                                <div class="div form-group">
                                    <label for="txtDireccion">Dirección</label>
                                    <input type="text" class="form-control" placeholder="Ingrese la dirección" id="txtDireccion">
                                </div>
                                <div class="div form-group" id="divMunicipio">
                                    <label for="selMunicipio">Ciudad Dirección *</label>
                                    <select name="" id="selMunicipio" class="form-control" style="width: 100%;" required>
                                        <option value="">Seleccione una opción</option>
                                        <?php
                                        $sqlMunicipios = "SELECT M.id, M.nombre AS municipio, D.nombre AS departamento  FROM municipios M JOIN departamentos D ON M.departamento_id=D.id ORDER BY D.nombre ASC";
                                        $resMunicipio = ejecutarSQL::consultar($sqlMunicipios);
                                        while ($municipio = mysqli_fetch_array($resMunicipio)) {
                                            if ($municipio['id'] == 825) {
                                                echo '<option value="' . $municipio['id'] . '" selected>' . $municipio['municipio'] . '  (' . $municipio['departamento'] . ')</option>';
                                            } else {
                                                echo '<option value="' . $municipio['id'] . '">' . $municipio['municipio'] . '  (' . $municipio['departamento'] . ')</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="div form-group">
                                    <label for="txtEmail">Email</label>
                                    <input type="email" class="form-control" placeholder="Ingrese el email" id="txtEmail">
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
                        <h1>Gestión <?= isset($_SESSION['empresas']['nombre']) ? $_SESSION['empresas']['nombre'] : 'Empresas' ?>
                            <?php
                            if ($_SESSION['empresas']['crear'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
                            ?>
                                <button type="button" id="btnCrearEmpresa" data-bs-toggle="modal" data-bs-target="#crear_empresa" class="btn bg-gradient-primary m-2">Crear Empresa</button>
                            <?php
                            }
                            ?>
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../Vista/adm_panel.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Gestión <?= isset($_SESSION['empresas']['nombre']) ? $_SESSION['empresas']['nombre'] : 'Empresas' ?></li>
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
                                    <th>Logo</th>
                                    <th>Estado</th>
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                    <th>Email</th>
                                    <th>Dirección</th>
                                    <th>Detalle</th>
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