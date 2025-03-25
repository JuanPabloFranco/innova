<?php
session_start();
if ((isset($_SESSION['usuarios']['id']) && $_SESSION['usuarios']['id'] == 4 && $_SESSION['usuarios']['ver'] == 1) || (isset($_SESSION['talento humano']['id']) && $_SESSION['talento humano']['id'] == 6 && $_SESSION['talento humano']['ver'] == 1) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    include_once '../Vista/layouts/header.php';
    include_once '../Conexion/Conexion.php';
    $año = date("Y");
    $año_inicio = 2019;
?>
    <title id="titleUsuario"></title>
    <?php
    include_once '../Vista/layouts/nav.php';
    ?>
    <!-- Modal -->
    <input type="hidden" id="txtId" value="<?= $_GET['id']; ?>">
    <input type="hidden" id="txtTipoUsuario" value="<?= $_SESSION['datos'][0]->id_tipo_usuario ?>">
    <input type="hidden" id="txtCargoUsuario" value="<?= $_SESSION['datos'][0]->id_cargo ?>">
    <input type="hidden" id="txtEditar" value="<?= $_SESSION['usuarios']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>?>">
    <input type="hidden" id="txtVer" value="<?= $_SESSION['usuarios']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>?>">
    <input type="hidden" id="txtEditarTh" value="<?= $_SESSION['talento humano']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtVerTh" value="<?= $_SESSION['talento humano']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="page" value="perfil">

    <script src="../Recursos/js/user.js"></script>

    <div class="modal fade bd-example-modal-lg" id="ver_avatar" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div>
                    <img id="imagenGrande" width="100%">
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
                    <div class="col-sm-8">
                        <?php
                        if ( (isset($_SESSION['usuarios']) && $_SESSION['usuarios']['editar'] == 1) || (isset($_SESSION['talento humano']) && $_SESSION['talento humano']['editar'] == 1) || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
                        ?>
                            <a href="editar_usuario.php?id=<?= $_GET['id'] ?>&modulo=usuarios">
                                <button class='btn btn-sm btn-info ml-1' id="btnEditarPerfil" type='button' title='Editar'>
                                    <i class="fas fa-edit ml-1"> Editar</i>
                                </button>
                            </a>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../Vista/adm_panel.php">Inicio</a></li>
                            <li class="breadcrumb-item active" id="liUsuario"></li>
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
                            <strong><i class="fas fa-donate mr-1"></i> Tipo Cuenta Banco</strong>
                            <p class="text-muted" id="tipo_cuenta"></p>
                            <hr>
                            <strong><i class="fas fa-piggy-bank mr-1"></i> Banco</strong>
                            <p class="text-muted" id="banco"></p>
                            <hr>
                            <strong><i class="fas fa-barcode mr-1"></i> Número Cuenta</strong>
                            <p class="text-muted" id="numero_cuenta"></p>
                            <hr>
                            <div id="redes"></div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card card_personalizada card-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs">
                                <?php
                                if ( (isset($_SESSION['usuarios']) && $_SESSION['usuarios']['ver'] == 1) || (isset($_SESSION['talento humano']) && $_SESSION['talento humano']['ver'] == 1) || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
                                ?>
                                    <li class="nav-item"><a href="#adicional" class="nav-link active" data-bs-toggle='tab'>Laboral y Acádemico</a></li>
                                    <li class="nav-item"><a href="#familiar" class="nav-link " data-bs-toggle='tab'>Familiar</a></li>
                                    <li class="nav-item"><a href="#salud" class="nav-link " data-bs-toggle='tab'>Salud</a></li>
                                    <li class="nav-item"><a href="#sociodemografico" class="nav-link " data-bs-toggle='tab'>Sociodemográfica</a></li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <?php
                            if ( (isset($_SESSION['usuarios']) && $_SESSION['usuarios']['ver'] == 1) || (isset($_SESSION['talento humano']) && $_SESSION['talento humano']['ver'] == 1) || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
                            ?>
                                <div class="tab-content">
                                    <div class="active tab-pane" id="adicional">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <div class="card-body pb-0" id="descripcionCargo"></div>
                                                <div class="card-body pb-0" id="inf_adicional"></div>
                                            </div>
                                            <div class="col-sm-4" id="conexiones"></div>
                                            <div class="col-sm-12" id="infGeneralAcademica"></div>
                                            <div class="col-sm-12" id="estudios"></div>
                                            <div class="col-sm-12" id="cursos"></div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="familiar">
                                        <div class="row">
                                            <div class="col-sm-6" id="infMadre"></div>
                                            <div class="col-sm-6" id="infPadre"></div>
                                            <div class="col-sm-12" id="personasACargo"></div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="salud">
                                        <div class="row">
                                            <div class="col-sm-12" id="saludGeneral"></div>
                                            <div class="col-sm-12" id="medicamentos"></div>
                                            <div class="col-sm-12" id="enfermedades"></div>
                                            <div class="col-sm-12" id="alergias"></div>
                                            <div class="col-sm-12" id="cirugias"></div>
                                            <div class="col-sm-12" id="lesiones"></div>
                                            <div class="col-sm-12" id="antedentes"></div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="sociodemografico">
                                        <div class="row">
                                            <div class="col-sm-12" id="infSocio"></div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>

                        </div>
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