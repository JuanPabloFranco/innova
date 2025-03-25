<?php
session_start();
if ((isset($_SESSION['administrativo']['id']) && $_SESSION['administrativo']['id'] == 1) || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
    include_once '../Vista/layouts/header.php';
    include_once '../Conexion/Conexion.php';
?>
    <title>Configuración</title>
    <?php
    include_once '../Vista/layouts/nav.php';
    ?>
    <!-- Modal -->
    <script src="../Recursos/js/configuracion.js?v=1"></script>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Configuración</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../Vista/adm_catalogo.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Configuración</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header notiHeader">
                                <h3 class="card-title">Información Básica</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                        <i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="card-body pb-0">
                                <form id="form_datos_basicos">
                                    <div class="div form-group">
                                        <label for="txtNombre">Nombre Empresa</label>
                                        <input type="text" class="form-control" placeholder="Ingrese el nombre de la empresa" id="txtNombre" required>
                                    </div>
                                    <div class="div form-group">
                                        <label for="txtNit">Nit</label>
                                        <input type="text" class="form-control" placeholder="Nit de la empresa" id="txtNit" required>
                                    </div>
                                    <div class="div form-group">
                                        <label for="txtBackend">Url Backend</label>
                                        <input type="text" class="form-control" id="txtBackend">
                                    </div>
                                    <div class="div form-group">
                                        <label for="txtFrontend">Url Frontend</label>
                                        <input type="text" class="form-control" id="txtFrontend">
                                    </div>
                                    <div class="div form-group">
                                        <label for="txtHosting">Fecha Inicio Hosting</label>
                                        <input type="date" class="form-control" id="txtHosting">
                                    </div>
                                    <div class="div form-group">
                                        <label for="txtEmailCarta">Email Cartas PDF</label>
                                        <input type="text" class="form-control" id="txtEmailCarta">
                                    </div>
                                    <div class="div form-group">
                                        <label for="txtDireccion">Dirección principal</label>
                                        <input type="text" class="form-control" id="txtDireccion">
                                    </div>
                                    <div class="div form-group">
                                        <label for="txtTelefono">Teléfono principal</label>
                                        <input type="text" class="form-control" id="txtTelefono">
                                    </div>
                                    <div class="div form-group">
                                        <button type="submit" class="btn bg-gradient-primary float-right m-1">Guardar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header notiHeader">
                                <h3 class="card-title">Información Correo electrónico</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                        <i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="card-body pb-0">
                                <form id="form_datos_email">
                                    <div class="div form-group">
                                        <label for="txtDriver">Driver del email</label>
                                        <input type="text" id="txtDriver" class="form-control" maxlength="8" size="8" required>
                                    </div>
                                    <div class="div form-group">
                                        <label for="txtCifrado">Cifrado del email</label>
                                        <input type="text" id="txtCifrado" class="form-control" maxlength="8" size="8" required>
                                    </div>
                                    <div class="div form-group">
                                        <label for="txtHost">Host del email</label>
                                        <input type="text" id="txtHost" class="form-control" required>
                                    </div>
                                    <div class="div form-group">
                                        <label for="txtPuerto">Puerto del email</label>
                                        <input type="text" id="txtPuerto" class="form-control" maxlength="4" size="4" required>
                                    </div>
                                    <div class="div form-group">
                                        <label for="txtUsuarioEmail">Email SMTP</label>
                                        <input type="text" id="txtUsuarioEmail" class="form-control" placeholder="correo electrónico" required>
                                    </div>
                                    <div class="div form-group">
                                        <label for="txtPassword">Contraseña del email</label>
                                        <input type="text" id="txtPassword" class="form-control" required>
                                    </div>
                                    <div class="div form-group">
                                        <button type="submit" class="btn bg-gradient-primary float-right m-1">Guardar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header notiHeader">
                                <h3 class="card-title">Logo</h3>
                                <button type="submit" id="btnDeleteLogo" class="btn btn-sm bg-gradient-danger float-right m-1"><i class='fas fa-trash'></i></button>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool mr-2" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                        <i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="card-body pb-0">
                                <form id="form_crear_logo" enctype="multipart/form-data">
                                    <div class="input-group mb-3" style="text-align: center; justify-content: center;">
                                        <img id="imgLogo" style="width: 40%;">
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class='fas fa-image' accept="image/*"></i></span>
                                        </div>
                                        <input type="file" id="txtLogo" name="logo" class="form-control" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="hidden" name="funcion" value="guardarImagenLogo">
                                        <button type="submit" class="btn bg-gradient-primary float-right m-1">Guardar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header notiHeader">
                                <h3 class="card-title">Logo Blanco</h3>
                                <button type="submit" id="btnDeleteLogoBlanco" class="btn btn-sm bg-gradient-danger float-right m-1"><i class='fas fa-trash'></i></button>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool mr-2" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                        <i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="card-body pb-0">
                                <form id="form_crear_logo_blanco" enctype="multipart/form-data">
                                    <div class="input-group mb-3" style="text-align: center; justify-content: center;">
                                        <img id="imgLogoBlanco" style="width: 40%;">
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class='fas fa-image' accept="image/*"></i></span>
                                        </div>
                                        <input type="file" id="txtLogo" name="logo" class="form-control" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="hidden" name="funcion" value="guardarImagenLogoBlanco">
                                        <button type="submit" class="btn bg-gradient-primary float-right m-1">Guardar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header notiHeader">
                                <h3 class="card-title">Favicon</h3>
                                <button type="submit" id="btnDeleteFavicon" class="btn btn-sm bg-gradient-danger float-right m-1"><i class='fas fa-trash'></i></button>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool mr-2" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                        <i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="card-body pb-0">
                                <form id="form_crear_favicon" enctype="multipart/form-data">
                                    <div class="input-group mb-3" style="text-align: center; justify-content: center;">
                                        <img id="imgFavicon" style="width: 40%;">
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class='fas fa-image' accept="image/*"></i></span>
                                        </div>
                                        <input type="file" id="txtFavicon" name="faticon" class="form-control" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="hidden" name="funcion" value="guardarFavicon">
                                        <button type="submit" class="btn bg-gradient-primary float-right m-1">Guardar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header notiHeader">
                                <h3 class="card-title">Imagén Fondo Login</h3>
                                <button type="submit" id="btnDeleteLogin" class="btn btn-sm bg-gradient-danger float-right m-1"><i class='fas fa-trash'></i></button>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool mr-2" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                        <i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="card-body pb-0">
                                <form id="form_crear_login" enctype="multipart/form-data">
                                    <div class="input-group mb-3" style="text-align: center; justify-content: center;">
                                        <img id="imgLogin" style="width: 40%;">
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class='fas fa-image' accept="image/*"></i></span>
                                        </div>
                                        <input type="file" id="txtLogin" name="img_login" class="form-control" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="hidden" name="funcion" value="guardarLogin">
                                        <button type="submit" class="btn bg-gradient-primary float-right m-1">Guardar</button>
                                    </div>
                                </form>
                            </div>
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
    header('Location: ../Vista/524.php');
}
?>