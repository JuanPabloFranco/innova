<?php
session_start();
if ((isset($_SESSION['administrativo']['id']) && $_SESSION['administrativo']['ver'] == 1)
    || (isset($_SESSION['talento humano']['id']) && $_SESSION['talento humano']['id'] == 6)
    || (isset($_SESSION['agenda']['id']) && $_SESSION['talento humano']['id'] == 8)
    || (isset($_SESSION['notas de inicio']['id']) && $_SESSION['notas de inicio']['id'] == 9)
    || $_SESSION['datos'][0]->id_tipo_usuario <= 2
) {
    include_once '../Vista/layouts/header.php';
    include_once '../Conexion/Conexion.php';
    $fecha = date("Y-m-d");
?>
    <title>Dashboard</title>
    <?php
    include_once '../Vista/layouts/nav.php';
    ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@latest/dist/Chart.min.js"></script>
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

    <script src="../Recursos/js/dashboard.js"></script>
    <input type="hidden" id="id_usuario" value="<?= $_SESSION['datos'][0]->id ?>">
    <input type="hidden" id="txtTipoUsuario" value="<?= $_SESSION['datos'][0]->id_tipo_usuario ?>">
    <input type="hidden" id="txtCargoUsuario" value="<?= $_SESSION['datos'][0]->id_cargo ?>">
    <input type="hidden" id="txtVerTH" value="<?= $_SESSION['talento humano']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtVerAgenda" value="<?= $_SESSION['agenda']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtVerNotas" value="<?= $_SESSION['notas de inicio']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtVerBiblioteca" value="<?= $_SESSION['biblioteca']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtVerContratos" value="<?= $_SESSION['contratos']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtPage" value="dashboard">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <br>
        <section>
            <div class="card card_personalizada card-tabs">
                <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs">
                        <?php
                        if ($_SESSION['talento humano']['ver'] == 1 || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
                        ?>
                            <li class="nav-item"><a href="#th" class="nav-link active" data-bs-toggle='tab'><?= isset($_SESSION['talento humano']['nombre']) ? $_SESSION['talento humano']['nombre'] : "Talento Humano" ?></a></li>
                        <?php
                        }
                        if ($_SESSION['agenda']['ver'] == 1 || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
                        ?>
                            <li class="nav-item"><a href="#agenda" class="nav-link" data-bs-toggle='tab'><?= isset($_SESSION['agenda']['nombre']) ? $_SESSION['agenda']['nombre'] : "Agenda" ?></a></li>
                        <?php
                        }
                        if ($_SESSION['biblioteca']['ver'] == 1 || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
                        ?>
                            <li class="nav-item"><a href="#biblioteca" class="nav-link" data-bs-toggle='tab'><?= isset($_SESSION['biblioteca']['nombre']) ? $_SESSION['biblioteca']['nombre'] : "Biblioteca" ?></a></li>
                        <?php
                        }                        
                        ?>

                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <?php
                        if ($_SESSION['talento humano']['ver'] == 1 || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
                        ?>
                            <div class="active tab-pane" id="th">
                                <div class="row">
                                    <!-- th moroso -->
                                    <div class="col-md-12">
                                        <div class="card-body pb-0 table-responsive">
                                            <table id="tablaUsuarios" class="display" style="width:100%" class="table table-hover text-nowrap">
                                                <thead class="notiHeader">
                                                    <tr>
                                                        <th>Sede</th>
                                                        <th>Cargo</th>
                                                        <th>Nombre Completo</th>
                                                        <th>Documento</th>
                                                        <th>Inf.Personal</th>
                                                        <th>Familiar</th>
                                                        <th>Salud</th>
                                                        <th>Acádemica</th>
                                                        <th>Estudios</th>
                                                        <th>Sociodemográfica</th>
                                                        <th>Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="font-family: Sans-serif; font-size: 13px;"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- th por cargo -->
                                    <div class="col-sm-12">
                                        <div class="card">
                                            <div class="card-header notiHeader">
                                                <h3 class="card-title" style="font-weight: 900;">Talento Humano por Cargos</h3>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                        <i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <canvas id="graficoThCargo"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- th por sedes -->
                                    <div class="col-md-6 col-sm-4">
                                        <div class="card">
                                            <div class="card-header notiHeader">
                                                <h3 class="card-title" style="font-weight: 900;">Talento Humano por Sedes</h3>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                        <i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <canvas id="graficoThSedes"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- th por areas -->
                                    <div class="col-md-6 col-sm-4">
                                        <div class="card">
                                            <div class="card-header notiHeader">
                                                <h3 class="card-title" style="font-weight: 900;">Talento Humano por Áreas</h3>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                        <i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <canvas id="graficoThAreas"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- th por nivel academico -->
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header notiHeader">
                                                <h3 class="card-title" style="font-weight: 900;">Talento Humano por nivel académico</h3>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                        <i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <canvas id="graficoThNivelAcademico"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- th por estrato -->
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header notiHeader">
                                                <h3 class="card-title" style="font-weight: 900;">Talento Humano por estrato</h3>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                        <i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <canvas id="graficoThEstrato"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- th por grupo etnico -->
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header notiHeader">
                                                <h3 class="card-title" style="font-weight: 900;">Talento Humano por grupo étnico</h3>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                        <i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <canvas id="graficoThGrupoEtnico"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- th por estado civil -->
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header notiHeader">
                                                <h3 class="card-title" style="font-weight: 900;">Talento Humano por estado civil</h3>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                        <i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <canvas id="graficoThEstadoCivil"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- th por tipo sangre -->
                                    <div class="col-md-4 col-sm-3">
                                        <div class="card">
                                            <div class="card-header notiHeader">
                                                <h3 class="card-title" style="font-weight: 900;">Talento Humano por tipo sangre</h3>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                        <i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <canvas id="graficoThTipoSangre"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- th por fuma -->
                                    <div class="col-md-4 col-sm-3">
                                        <div class="card">
                                            <div class="card-header notiHeader">
                                                <h3 class="card-title" style="font-weight: 900;">Talento Humano Fuma</h3>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                        <i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <canvas id="graficoThFuma"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- th por bebidas -->
                                    <div class="col-md-4 col-sm-3">
                                        <div class="card">
                                            <div class="card-header notiHeader">
                                                <h3 class="card-title" style="font-weight: 900;">Talento Humano Bebidas Alcoholicas</h3>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                        <i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <canvas id="graficoThBebidas"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- th por licencia -->
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header notiHeader">
                                                <h3 class="card-title" style="font-weight: 900;">Licencia de conducción</h3>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                        <i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <canvas id="graficoThLicencia"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- th por cabeza flia -->
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header notiHeader">
                                                <h3 class="card-title" style="font-weight: 900;">Cabeza de Familia</h3>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                        <i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <canvas id="graficoThCabezaFamilia"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- th por tipo vivienda -->
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header notiHeader">
                                                <h3 class="card-title" style="font-weight: 900;">Tipo de Vivienda</h3>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                        <i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <canvas id="graficoThTipoVivienda"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- th enfermedades -->
                                    <!-- th alergias -->
                                    <!-- th lesiones -->
                                    <!-- th medicamentos -->
                                    <div class="col-md-6">
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        if ($_SESSION['agenda']['ver'] == 1 || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
                        ?>
                            <div class=" tab-pane" id="agenda">
                                <div class="row">
                                    <div class="col-md-4 col-sm-3">
                                        <div class="card">
                                            <div class="card-header notiHeader">
                                                <h3 class="card-title" style="font-weight: 900;">Agenda por Estado</h3>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                        <i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <canvas id="graficoAgendaEstado"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-3">
                                        <div class="card">
                                            <div class="card-header notiHeader">
                                                <h3 class="card-title" style="font-weight: 900;">Agenda por Tipo</h3>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                        <i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <canvas id="graficoAgendaTipo"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-3">
                                        <div class="card">
                                            <div class="card-header notiHeader">
                                                <h3 class="card-title" style="font-weight: 900;">Agenda Próxima</h3>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                        <i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <canvas id="graficoAgendaProxima"></canvas>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                        <?php
                        }
                        if ($_SESSION['biblioteca']['ver'] == 1 || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
                        ?>
                            <div class=" tab-pane" id="biblioteca">
                                <div class="row">
                                    <div class="col-md-4 col-sm-3">
                                        <div class="card">
                                            <div class="card-header notiHeader">
                                                <h3 class="card-title" style="font-weight: 900;">Archivos por Estado</h3>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                        <i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <canvas id="graficoArchivosEstado"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-3">
                                        <div class="card">
                                            <div class="card-header notiHeader">
                                                <h3 class="card-title" style="font-weight: 900;">Archivos por Tipo</h3>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                        <i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <canvas id="graficoArchivosTipo"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-3">
                                        <div class="card">
                                            <div class="card-header notiHeader">
                                                <h3 class="card-title" style="font-weight: 900;">Archivos por Sedes</h3>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                        <i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <canvas id="graficoArchivosSede"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-3">
                                        <div class="card">
                                            <div class="card-header notiHeader">
                                                <h3 class="card-title" style="font-weight: 900;">Archivos por Áreas</h3>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                        <i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <canvas id="graficoArchivosAreas"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-3">
                                        <div class="card">
                                            <div class="card-header notiHeader">
                                                <h3 class="card-title" style="font-weight: 900;">Archivos por Categoría</h3>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                        <i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <canvas id="graficoArchivosCategoria"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-3">
                                        <div class="card">
                                            <div class="card-header notiHeader">
                                                <h3 class="card-title" style="font-weight: 900;">Archivos por Cargo</h3>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                        <i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <canvas id="graficoArchivosCargo"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-3">
                                        <div class="card">
                                            <div class="card-header notiHeader">
                                                <h3 class="card-title" style="font-weight: 900;">Archivos por Privacidad</h3>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                        <i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <canvas id="graficoArchivosPrivacidad"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-3">
                                        <div class="card">
                                            <div class="card-header notiHeader">
                                                <h3 class="card-title" style="font-weight: 900;">Archivos por Usuario</h3>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                        <i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <canvas id="graficoArchivosUsuarios"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        if ($_SESSION['notas de inicio']['ver'] == 1 || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
                        ?>
                            <div class=" tab-pane" id="notas">

                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- /.content-wrapper -->
<?php
    include_once '../Vista/layouts/footer.php';
} else {
    header('Location: ../Vista/adm_panel.php');
}
?>