<?php
session_start();
include '../Conexion/Conexion.php';
if (isset($_SESSION['datos'])) {
    include_once '../Vista/layouts/header.php'
?>
    <title>Mi Cargo</title>
    <?php
    include_once '../Vista/layouts/nav.php';
    ?>
    <!-- Modal -->
    <script src="../Recursos/js/user.js"></script>
    <input type="hidden" id="txtId" value="<?= $_SESSION['datos'][0]->id ?>">
    <input type="hidden" id="txtTipoUsuario" value="<?= $_SESSION['datos'][0]->id_tipo_usuario ?>">
    <input type="hidden" id="txtCargoUsuario" value="<?= $_SESSION['datos'][0]->id_cargo ?>">
    <input type="hidden" id="page" value="mi_cargo">

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Mi Cargo
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../Vista/adm_panel.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Mi Cargo</li>
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header notiHeader">
                                    <h3 class="card-title"><b>Funciones de mi Cargo</b></h3>
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
                                    <div>
                                        <p id="PfuncionesCargo" class="ml-3 mt-4"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header notiHeader">
                                    <h3 class="card-title"><b>Mi Horario</b></h3>
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
                                    <div>
                                        <p id="PHorario" class="ml-3 mt-4"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header notiHeader">
                                    <h3 class="card-title"><b>Meses Siendo Colaborador del Mes</b></h3>
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
                                <div class="card-body p-0" id="PColaboradorMes">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header notiHeader">
                            <h3 class="card-title"><b>Adjuntos</b></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0 mt-4 mb-6 ml-2" id="adjuntos">

                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header notiHeader">
                            <h3 class="card-title"><b>Otros</b></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0 mt-4 mb-6 ml-2" id="">
                            <div class="info-box text-center">
                                <span class="info-box-icon bg-warning elevation-1">
                                    <span class="info-box-number" id="divTarde">
                                        0
                                    </span>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-number">
                                        Llegadas Tarde
                                    </span>
                                </div>
                            </div>
                            <div class="info-box text-center">
                                <span class="info-box-icon bg-success elevation-1">
                                    <span class="info-box-number" id="divColaboradorMes">
                                        0
                                    </span>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-number">
                                        Cant. Colaborador Mes
                                    </span>
                                </div>
                            </div>
                        </div>
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