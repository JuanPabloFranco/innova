<?php
session_start();
if ((isset($_SESSION['talento humano']['id']) && $_SESSION['talento humano']['id'] == 6 && $_SESSION['talento humano']['ver'] == 1) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    include_once '../Vista/layouts/header.php';
    include_once '../Conexion/Conexion.php';
?>
    <title>Reportes Talento Humano</title>
    <?php
    include_once '../Vista/layouts/nav.php';
    include_once '../Vista/layouts/dataTable.php';

    ?>

    <!-- Modal -->
    <script src="../Recursos/js/reportes.js"></script>

    <input type="hidden" id="id_usuario" value="<?= $_SESSION['datos'][0]->id ?>">
    <input type="hidden" id="txtTipoUsuario" value="<?= $_SESSION['datos'][0]->id_tipo_usuario ?>">
    <input type="hidden" id="txtCargoUsuario" value="<?= $_SESSION['datos'][0]->id_cargo ?>">
    <input type="hidden" id="txtEditar" value="<?= $_SESSION['talento humano']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtVer" value="<?= $_SESSION['talento humano']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">

    <form action="../Recursos/xls/excelUsuarios.php" method="post" role="form" id="formExcel">
        <input type="hidden" id="id_usuario" value="<?php echo $_SESSION['id_user']; ?>">
        <input type="hidden" id="txtAccion" name="accion">
    </form>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Reportes Talento Humano</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../Vista/adm_panel.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Reportes Talento Humano</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <?php
        if ((isset($_SESSION['talento humano']['id']) && $_SESSION['talento humano']['ver']) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
        ?>
            <section>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-2 col-4">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3 id="h3Activos"></h3>
                                    <p>Activos</p>
                                </div>
                                <div class="icon">
                                    <i><img style="margin-top: -70px; opacity: 0.5;" src='../Recursos/img/user-58.png' width='70px'></i>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-2 col-4">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3 id="h3Incapacidades"></h3>
                                    <p>Incapacidades</p>
                                </div>
                                <div class="icon">
                                    <i><img style="margin-top: -70px; opacity: 0.5;" src='../Recursos/img/user-42.png' width='70px'></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-4">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3 id="h3Solicitudes"></h3>
                                    <p>Solicitudes Pendientes</p>
                                </div>
                                <div class="icon">
                                    <i><img style="margin-top: -70px; opacity: 0.5;" src='../Recursos/img/user-43.png' width='70px'></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-4">
                            <!-- small box -->
                            <div class="small-box bg-secondary">
                                <div class="inner">
                                    <h3 id="h3Asistencia"></h3>
                                    <p>Asistencia Hoy</p>
                                </div>
                                <div class="icon">
                                    <i><img style="margin-top: -70px; opacity: 0.5;" src='../Recursos/img/iconos logistica-17.png' width='70px'></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <form id="formGenerarCartaLaboral">
                                <div class="row">
                                    <div class="col">
                                        <label>Generar Carta Laboral</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col" id="divColaborador">
                                        <div class="div form-group m-2">
                                            <select id="selColaborador" class="form-control" style="width: 100%;" required>
                                                <option value="">Colaborador</option>
                                                <?php
                                                $sqlColaborador = "SELECT U.id, U.nombre_completo, C.nombre_cargo, S.nombre, IF(U.estado=1,'Activo','Inactivo') AS estado FROM usuarios U JOIN cargos C ON U.id_cargo=C.id JOIN sedes S ON U.id_sede=S.id WHERE U.id<>1";
                                                $resColaborador = ejecutarSQL::consultar($sqlColaborador);
                                                while ($colaborador = mysqli_fetch_array($resColaborador)) {
                                                    echo '<option value="' . $colaborador['id'] . '">' . $colaborador['nombre_completo'] . "-" . $colaborador['nombre_cargo'] . "(" . $colaborador['estado'] . ")" . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="div form-group m-2">
                                            <select id="selTipoCartaLaboral" class="form-control" required>
                                                <option value="">Tipo de carta laboral</option>
                                                <option value="salario">Carta básica con salario</option>
                                                <option value="sinSalario">Carta básica sin salario</option>
                                                <option value="sinSalarioHorario">Carta básica sin salario con horario</option>
                                                <option value="salarioHorario">Carta básica con salario y horario</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="div form-group m-2">
                                            <input type="text" class="form-control" placeholder="Dirigido a" id="txtDirigidoA">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="div form-group m-2">
                                            <button type="submit" id="btnGenerarCarta" class="btn bg-gradient-primary">Generar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card card-success">
                        <div class="modal-header notiHeader">
                            <h3 class="card-title">Tipo de lista</h3>
                            <div class="input-group">
                                <select name="" id="selTipoReporte" class="form-control float-left">
                                    <option value="completo">Completo</option>
                                    <option value="basico">Básico</option>
                                    <option value="incapacidades">Incapacidades</option>
                                    <option value="solicitudes">Solicitudes</option>
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-success" id="exportar"><i class="excel fas fa-file-excel"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pb-0 table-responsive">
                            <table id="tablaUsuarios" class="display" style="width:100%" class="table table-hover text-nowrap">
                                <thead class="notiHeader">
                                    <tr>
                                        <th>Sede</th>
                                        <th>Cargo</th>
                                        <th>Nombre Completo</th>
                                        <th>Documento</th>
                                        <th>Edad</th>
                                        <th>Celular</th>
                                        <th>Email</th>
                                        <th>Acción</th>
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
        <?php
        }
        ?>
    </div>
    <script>
        $(document).ready(function() {
            $('#selColaborador').select2({
                dropdownParent: $('#divColaborador')
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