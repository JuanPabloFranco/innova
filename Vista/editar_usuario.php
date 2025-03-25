<?php
session_start();
if ((isset($_SESSION['usuarios']['id']) && $_SESSION['usuarios']['id'] == 4 && $_SESSION['usuarios']['ver'] == 1) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
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
    <input type="hidden" id="id_usuario" value="<?= $_GET['id']; ?>">
    <input type="hidden" id="txtTipoUsuario" value="<?= $_SESSION['datos'][0]->id_tipo_usuario ?>">
    <input type="hidden" id="txtCargoUsuario" value="<?= $_SESSION['datos'][0]->id_cargo ?>">
    <input type="hidden" id="txtEditar" value="<?= $_SESSION['usuarios'][0]['editar'] ?>">
    <input type="hidden" id="page" value="editar">

    <!-- <script src="../Recursos/js/user.js"></script> -->
    <script src="../Recursos/js/usuario.js?v=1"></script>

    <div class="modal fade" id="changePass" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header notiHeader">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Contraseña</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_pass">
                    <div class="modal-body">
                        <div class="text-center">
                            <img id="avatar2" class="profile-user-img img-fluid img-circle">
                            <div class="text-center" id="divNombrePass"></div>
                        </div>
                        <label for="txtDireccion">Usuario *</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class='fas fa-user'></i></span>
                            </div>
                            <input type="text" id="txtUsuarioCh" class="form-control" placeholder="Ingrese un nombre de usuario">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class='fas fa-unlock-alt'></i></span>
                            </div>
                            <input type="password" id="oldPass" class="form-control" placeholder="Ingrese la contraseña actual">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class='fas fa-lock'></i></span>
                            </div>
                            <input type="password" id="newPass" class="form-control" placeholder="Ingrese la nueva contraseña">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class='fas fa-lock'></i></span>
                            </div>
                            <input type="password" id="newPass2" class="form-control" placeholder="Repita la nueva contraseña">
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
    <div class="modal fade" id="changeAvatar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Avatar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_avatar" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="text-center">
                            <img id="avatar3" class="profile-user-img img-fluid img-circle">
                            <div class="text-center" id="nombreUsuarioEdAvatar"><b></b></div>
                        </div>
                        <div class="input-group mb-3 mt-2">
                            <input type="file" name="avatar" class='input-group' accept="image/*">
                            <input type="hidden" name="funcion" value="changeAvatar">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn bg-gradient-primary">Guardar</button>
                        <input type="hidden" name="id_usuario" value="<?= $_GET['id']; ?>">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class='modal fade' id='modalEspera' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div id='imgEspera'></div>
            </div>
        </div>
    </div>

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
                    <div class="col-sm-6">
                        <a href="usuario.php?id=<?= $_GET['id'] ?>" class="text-center mt-2">
                            <button class='btn btn-sm btn-info ml-1' type='button' title='Volver'>
                                <i class="fas fa-step-backward ml-1"> Volver</i>
                            </button>
                        </a>

                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section>
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-success card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img id="avatar1" class="profile-user-img img-fluid img-circle">
                            </div>
                            <div class="text-center">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#changeAvatar" class="btn btn-primary btn-sm mt-1">Cambiar Avatar</button>
                            </div>
                            <input type="hidden" id="id_usuario" value="<?= $_SESSION['datos'][0]->id; ?>">
                            <h3 class="profile-username text-center" id="h3NombreUsuario"></h3>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item"><b>Edad</b><a class="float-right" id="edad_usuario"></a></li>
                                <li class="list-group-item"><b>Documento</b><a class="float-right" id="doc_usuario"></a></li>
                            </ul>
                            <button data-bs-toggle="modal" data-bs-target="#changePass" type="button" class='btn btn-block btn-outline-warning btn-sm'>Cambiar Login</button>
                            <hr>
                            <form id="form_firma" enctype="multipart/form-data">
                                <h6 class="text-center"><b>Firma digital</b></h6 class="text-center">
                                <div id="divFirma" style="display: flex;"></div>
                                <input type="hidden" name="funcion" value="changeFirma">
                            </form>
                        </div>
                    </div>
                    <div class="card  card-success">
                        <div class="modal-header notiHeader">
                            <h3 class="card-title">Sobre mi</h3>
                        </div>
                        <div class="card-body">
                            <strong><i class='fas fa-venus-mars mr-1'></i> Género</strong>
                            <p class="text-muted" id="genero"></p>
                            <strong><i class='fas fa-calendar-alt mr-1'></i> Fecha Nacimiento</strong>
                            <p class="text-muted" id="fecha_nac"></p>
                            <strong><i class='fas fa-phone mr-1'></i> Teléfono</strong>
                            <p class="text-muted" id="p_telefono"></p>
                            <strong><i class='fas fa-map-marker-alt mr-1'></i> Residencia</strong>
                            <p class="text-muted" id="p_residencia"></p>
                            <strong><i class='fas fa-at mr-1'></i> Email</strong>
                            <p class="text-muted" id="p_email"></p>
                            <strong><i class='fas fa-user-check mr-1'></i> Cargo</strong>
                            <p class="text-muted" id="p_cargo"></p>
                            <strong><i class='fas fa-city mr-1'></i> Sede</strong>
                            <p class="text-muted" id="p_sede"></p>
                            <strong><i class='fas fa-pencil-alt mr-1'></i> Información Adicional</strong>
                            <p class="text-muted" id="p_info"></p>
                        </div>
                        <div class="card-footer">

                        </div>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card card_personalizada card-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs">
                                <li class="nav-item"><a href="#personal" class="nav-link active" data-bs-toggle='tab'>Personal</a></li>
                                <li class="nav-item"><a href="#familiar" class="nav-link" data-bs-toggle='tab'>Familiar</a></li>
                                <li class="nav-item"><a href="#salud" class="nav-link" data-bs-toggle='tab'>Salud</a></li>
                                <li class="nav-item"><a href="#academica" class="nav-link" data-bs-toggle='tab'>Académica Laboral</a></li>
                                <li class="nav-item"><a href="#sociodmeografica" class="nav-link" data-bs-toggle='tab'>Sociodemográfica</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="personal">
                                    <form id="formEditarGeneral">
                                        <div class="card-body">
                                            <div class="div form-group">
                                                <label for="txtNombreUsuario">Nombre Completo *</label>
                                                <input type="text" class="form-control" placeholder="Ingrese el nombre" id="txtNombreUsuario" required>
                                            </div>
                                            <div class="div form-group">
                                                <label for="txtDoc">No. Documento *</label>
                                                <input type="text" class="form-control" pattern=".{7,10}" placeholder="Ingrese el documento de identidad" title='Debe contener entre 7 y 10 caracteres' id="txtDoc" required>
                                            </div>
                                            <div class="div form-group">
                                                <label for="txtFecNac">Fecha Nacimiento</label>
                                                <input type="date" class="form-control" placeholder="Ingrese el documento de identidad" id="txtFecNac" required>
                                            </div>
                                            <div class="div form-group">
                                                <label for="txtTelefono">Teléfono *</label>
                                                <input type="text" class="form-control" maxlength="10" placeholder="Ingrese el teléfono del usuario" id="txtTelefono" required>
                                            </div>
                                            <div class="div form-group">
                                                <label for="txtEmail">Email *</label>
                                                <input type="email" class="form-control" placeholder="Ingrese el documento de identidad" id="txtEmail" required>
                                            </div>
                                            <div class="div form-group">
                                                <label for="txtDireccion">Dirección *</label>
                                                <input type="text" class="form-control" placeholder="Ingrese la direccion del usuario" id="txtDireccion">
                                            </div>
                                            <div class="div form-group" id="divMunicipio">
                                                <label for="selMunicipio">Ciudad Dirección *</label>
                                                <select name="" id="selMunicipio" class="form-control" style="width: 100%;">
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
                                                <label for="selGenero">Género</label>
                                                <select class="form-control" id="selGenero" required>
                                                    <option value="">Seleccione una opción</option>
                                                    <option value="Masculino">Masculino</option>
                                                    <option value="Femenino">Femenino</option>
                                                    <option value="No Binario">No Binario</option>
                                                </select>
                                            </div>
                                            <div class="div form-group">
                                                <label for="txtInformacion">Información adicional</label>
                                                <textarea class="form-control" id="txtInformacion" placeholder="Ingrese la direccion del usuario" rows="4"></textarea>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn bg-gradient-primary float-right m-1">Guardar</button>
                                            <button type="button" class="btn btn-outline-secondary float-right m-1" data-bs-dismiss="modal">Cerrar</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="familiar">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="div form-group">
                                                <label for="txtNombreMadre">Nombre de la madre</label>
                                                <input type="text" class="form-control" name="nombre_madre" id="txtNombreMadre" onblur="familiar()">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="div form-group">
                                                <label for="txtTelMadre">Télefono madre</label>
                                                <input type="text" class="form-control" maxlength="10" name="tel_madre" id="txtTelMadre" onblur="familiar()">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="div form-group">
                                                <label for="txtNombrePadre">Nombre del padre</label>
                                                <input type="text" class="form-control" name="nombre_padre" id="txtNombrePadre" onblur="familiar()">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="div form-group">
                                                <label for="txtTelPadre">Télefono padre</label>
                                                <input type="text" class="form-control" maxlength="10" name="tel_padre" id="txtTelPadre" onblur="familiar()">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="card">
                                                <div class="card-header notiHeader">
                                                    <h5>Personas a Cargo
                                                        <button type="button" id="btn_personas_cargo" data-bs-toggle="modal" data-bs-target="#personaCargo" class="btn bg-gradient-primary float-right" title="Agregar Personas a Cargo"><i class="fas fa-plus-circle"></i></button>
                                                    </h5>
                                                </div>
                                                <div class="card-body table-responsive">
                                                    <table class="table table-hover">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">Nombre</th>
                                                                <th scope="col">Edad</th>
                                                                <th scope="col">Fecha Nacimiento</th>
                                                                <th scope="col">Parentezco</th>
                                                                <th scope="col">Acción</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="bodyPersonasCargo"></tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="salud">
                                    <div class="card-body">
                                        <form id="form_datos_salud">
                                            <div class="row">
                                                <div class=" div form-group col-sm-6">
                                                    <label for="txtEps">EPS</label>
                                                    <input type="text" class="form-control" name="eps" id="txtEps" placeholder="EPS a la que esta afiliado" onblur="salud()">
                                                </div>
                                                <div class=" div form-group col-sm-6">
                                                    <label for="selTipoSangre">Tipo de Sangre</label>
                                                    <select name="tipo_sangre" class="form-control" id="selTipoSangre" onblur="salud()">
                                                        <option selected="selected" value="">Tipo de sangre</option>
                                                        <option value="O negativo">O negativo</option>
                                                        <option value="O positivo">O positivo</option>
                                                        <option value="A negativo">A negativo</option>
                                                        <option value="A positivo">A positivo</option>
                                                        <option value="B negativo">B negativo</option>
                                                        <option value="B positivo">B positivo</option>
                                                        <option value="AB negativo">AB negativo</option>
                                                        <option value="AB positivo">AB positivo</option>
                                                    </select>
                                                </div>
                                                <div class="div form-group col-sm-6">
                                                    <label for="txtConEmerg">En caso de emergencia llamar a</label>
                                                    <input type="text" class="form-control" name="contacto_emergencia" placeholder="Nombre del contacto de emergencia" id="txtConEmerg" onblur="salud()">
                                                </div>
                                                <div class="div form-group col-sm-6">
                                                    <label for="txtParentezco">Parentezco</label>
                                                    <input type="text" class="form-control" name="parentezco_emergencia" placeholder="Parentezco del contacto de emergencia" id="txtParentezco" onblur="salud()">
                                                </div>
                                                <div class="div form-group col-sm-6">
                                                    <label for="txtTelEmerg">Télefono</label>
                                                    <input type="text" class="form-control" name="cel_emergencia" placeholder="Teléfono del contacto de emergencia" id="txtTelEmerg" onblur="salud()">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="card">
                                                        <div class="card-header notiHeader">
                                                            <h5>Medicamentos
                                                                <button type="button" id="btn_crear_medicamento" data-bs-toggle="modal" data-bs-target="#crearMedicamento" class="btn bg-gradient-primary float-right" title="Agregar Medicamento"><i class="fas fa-plus-circle"></i></button>
                                                            </h5>
                                                        </div>
                                                        <div class="card-body table-responsive">
                                                            <table class="table table-hover">
                                                                <thead class="table-light">
                                                                    <tr>
                                                                        <th scope="col">#</th>
                                                                        <th scope="col">Nombre</th>
                                                                        <th scope="col">Indicaciones</th>
                                                                        <th scope="col">Acción</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="bodyMedicamento"></tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="card">
                                                        <div class="card-header notiHeader">
                                                            <h5>Enfermedades
                                                                <button type="button" id="btn_crear_enfermedad" data-bs-toggle="modal" data-bs-target="#crearEnfermedad" class="btn bg-gradient-primary float-right" title="Agregar Enfermedad"><i class="fas fa-plus-circle"></i></button>
                                                            </h5>
                                                        </div>
                                                        <div class="card-body table-responsive">
                                                            <table class="table table-hover">
                                                                <thead class="table-light">
                                                                    <tr>
                                                                        <th scope="col">#</th>
                                                                        <th scope="col">Nombre</th>
                                                                        <th scope="col">Acción</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="bodyEnfermedad"></tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="card">
                                                        <div class="card-header notiHeader">
                                                            <h5>Alergias
                                                                <button type="button" id="btn_crear_alergia" data-bs-toggle="modal" data-bs-target="#crearAlergia" class="btn bg-gradient-primary float-right" title="Agregar Alergia"><i class="fas fa-plus-circle"></i></button>
                                                            </h5>
                                                        </div>
                                                        <div class="card-body table-responsive">
                                                            <table class="table table-hover">
                                                                <thead class="table-light">
                                                                    <tr>
                                                                        <th scope="col">#</th>
                                                                        <th scope="col">Tipo</th>
                                                                        <th scope="col">Nombre</th>
                                                                        <th scope="col">Acción</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="bodyAlergia"></tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="card">
                                                        <div class="card-header notiHeader">
                                                            <h5>Cirugías
                                                                <button type="button" id="btn_crear_cirugia" data-bs-toggle="modal" data-bs-target="#crearCirugia" class="btn bg-gradient-primary float-right" title="Agregar Cirugía"><i class="fas fa-plus-circle"></i></button>
                                                            </h5>
                                                        </div>
                                                        <div class="card-body table-responsive">
                                                            <table class="table table-hover">
                                                                <thead class="table-light">
                                                                    <tr>
                                                                        <th scope="col">#</th>
                                                                        <th scope="col">Nombre</th>
                                                                        <th scope="col">Acción</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="bodyCirugia"></tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="card">
                                                        <div class="card-header notiHeader">
                                                            <h5>Lesiones
                                                                <button type="button" id="btn_crear_lesion" data-bs-toggle="modal" data-bs-target="#crearLesion" class="btn bg-gradient-primary float-right" title="Agregar Lesión"><i class="fas fa-plus-circle"></i></button>
                                                            </h5>
                                                        </div>
                                                        <div class="card-body table-responsive">
                                                            <table class="table table-hover">
                                                                <thead class="table-light">
                                                                    <tr>
                                                                        <th scope="col">#</th>
                                                                        <th scope="col">Tipo</th>
                                                                        <th scope="col">Nombre</th>
                                                                        <th scope="col">Acción</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="bodyLesion"></tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="card">
                                                        <div class="card-header notiHeader">
                                                            <h5>Antecedentes
                                                                <button type="button" id="btn_crear_antecedente" data-bs-toggle="modal" data-bs-target="#crearAntecedente" class="btn bg-gradient-primary float-right" title="Agregar Antecedente"><i class="fas fa-plus-circle"></i></button>
                                                            </h5>
                                                        </div>
                                                        <div class="card-body table-responsive">
                                                            <table class="table table-hover">
                                                                <thead class="table-light">
                                                                    <tr>
                                                                        <th scope="col">#</th>
                                                                        <th scope="col">Nombre</th>
                                                                        <th scope="col">Acción</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="bodyAntecedente"></tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="academica">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label for="selNivelAcademico">Nivel Acádemico</label>
                                                    <select name="nivel_academico" class="form-control" id="selNivelAcademico" onblur="academica()">
                                                        <option selected="" value="">N/A</option>
                                                        <option value="Bachiller">Bachiller</option>
                                                        <option value="Técnico Laboral">Técnico Laboral</option>
                                                        <option value="Técnico Profesional">Técnico Profesional</option>
                                                        <option value="Técnologo">Técnologo</option>
                                                        <option value="Profesional">Profesional</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="txtProfesion">Profesión o labor actual</label>
                                                    <input type="text" class="form-control" name="profesion" id="txtProfesion" placeholder="Profesión o labor actual" onblur="academica()">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="txtExperiencia">Años Experiencia Laboral</label>
                                                    <input type="number" class="form-control" name="experiencia" min="0" id="txtExperiencia" placeholder="Años de Experiencia Laboral" onblur="academica()">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="txtPension">Fondo de Pensiones</label>
                                                    <input type="text" class="form-control" name="pension" id="txtPension" placeholder="Fondo de pensiones" onblur="academica()">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="txtCesantias">Cesantias</label>
                                                    <input type="text" class="form-control" name="cesantias" id="txtCesantias" placeholder="Cesantias" onblur="academica()">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="txtArl">ARL</label>
                                                    <input type="text" class="form-control" name="arl" id="txtArl" placeholder="ARL" onblur="academica()">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="txtCorreoInstitucional">Correo Institucional</label>
                                                    <input type="text" class="form-control" name="arl" id="txtCorreoInstitucional" placeholder="Correo Institucional" onblur="academica()">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="txtPassInstitucional">Contraseña Correo Institucional</label>
                                                    <input type="text" class="form-control" name="arl" id="txtPassInstitucional" placeholder="Contraseña Correo Institucional" onblur="academica()">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="selVerificarAsistencia">Verificar Asistencia</label>
                                                    <select name="verificar_asistencia" class="form-control" id="selVerificarAsistencia" onblur="academica()">
                                                        <option selected="selected" value="">Seleccione una opción</option>
                                                        <option value="0">No</option>
                                                        <option value="1">Si</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="selVerificarContrato">Verificar Contrato</label>
                                                    <select name="verificar_contrato" class="form-control" id="selVerificarContrato" onblur="academica()">
                                                        <option selected="selected" value="">Seleccione una opción</option>
                                                        <option value="0">No</option>
                                                        <option value="1">Si</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="txtHoraEntrada">Hora Entrada</label>
                                                    <input type="time" class="form-control" name="hora_entrada" placeholder="Hora Entrada Laboral" id="txtHoraEntrada" onblur="academica()">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="txtTelCorporativo">Teléfono Corporativo</label>
                                                    <input type="text" class="form-control" name="telefono_corporativo" placeholder="Número de teléfono corporativo" id="txtTelCorporativo" onblur="academica()">
                                                </div>
                                                <div class="col-sm-12 text-center">
                                                    <hr>
                                                    <h4><b>Cuenta Bancaria</b></h4>
                                                    <hr>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="txtTipoCuenta">Tipo de Cuenta</label>
                                                    <select class="form-control" name="tipo_cuenta" id="txtTipoCuenta" onblur="academica()">
                                                        <option value="" selected>Elija una opción</option>
                                                        <option value="Corriente">Corriente</option>
                                                        <option value="Ahorros">Ahorros</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="txtBanco">Banco</label>
                                                    <input type="text" class="form-control" name="banco" id="txtBanco" placeholder="Nombre del banco" onblur="academica()">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="txtNumeroCuenta">Número de Cuenta</label>
                                                    <input type="text" class="form-control" name="numero_cuenta" id="txtNumeroCuenta" placeholder="Número de la cuenta bancaria" onblur="academica()">
                                                </div>
                                                <div class="col-sm-12">
                                                    <hr>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12" style="margin-top: 10px;">
                                            <div class="card">
                                                <div class="card-header notiHeader">
                                                    <h5>Estudios Acádemicos
                                                        <button type="button" id="btn_crear_estudio" data-bs-toggle="modal" data-bs-target="#crearEstudio" class="btn bg-gradient-primary float-right" title="Agregar Estudio"><i class="fas fa-plus-circle"></i></button>
                                                    </h5>
                                                </div>
                                                <div class="card-body table-responsive">
                                                    <table class="table table-hover">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">Nivel</th>
                                                                <th scope="col">Tipo</th>
                                                                <th scope="col">Título</th>
                                                                <th scope="col">Institución</th>
                                                                <th scope="col">Año</th>
                                                                <th scope="col">Ciudad</th>
                                                                <th scope="col">Acción</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="bodyEstudios"></tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="card">
                                                <div class="card-header notiHeader">
                                                    <h5>Cursos
                                                        <button type="button" id="btn_crear_soporte" data-bs-toggle="modal" data-bs-target="#crearOtroEst" class="btn bg-gradient-primary float-right" title="Agregar Curso"><i class="fas fa-plus-circle"></i></button>
                                                    </h5>
                                                </div>
                                                <div class="card-body table-responsive">
                                                    <table class="table table-hover">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">Nombre Curso</th>
                                                                <th scope="col">Fecha</th>
                                                                <th scope="col">Institución</th>
                                                                <th scope="col">Horas</th>
                                                                <th scope="col">Acción</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="bodyCursos"></tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="sociodmeografica">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="div form-group col-sm-3">
                                                <label for="selEstrato">Estrato</label>
                                                <select name="estrato" id="selEstrato" class="form-control" onblur="sociodemografica()">
                                                    <option value="0">0</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                </select>
                                            </div>
                                            <div class="div form-group col-sm-3">
                                                <label for="selEstadoCivil">Estado civil</label>
                                                <select name="estado_civil" id="selEstadoCivil" class="form-control" onblur="sociodemografica()">
                                                    <option value="Soltero">Soltero</option>
                                                    <option value="Casado">Casado</option>
                                                    <option value="Divorciado">Divorciado</option>
                                                    <option value="Separado/a">Separado/a</option>
                                                    <option value="Viudo/a">Viudo/a</option>
                                                    <option value="Unión libre">Unión libre</option>
                                                    <option value="Otro">Otro</option>
                                                </select>
                                            </div>
                                            <div class="div form-group col-sm-6">
                                                <label for="selGrupoEtnico">Grupo Etnico</label>
                                                <select name="grupo_etnico" id="selGrupoEtnico" class="form-control" onblur="sociodemografica()">
                                                    <option value="No corresponde">No corresponde</option>
                                                    <option value="Negro, mulato, afrodescendiente, afrocolombiano">Negro, mulato, afrodescendiente, afrocolombiano</option>
                                                    <option value="Indígena">Indígena</option>
                                                    <option value="Raizal">Raizal</option>
                                                    <option value="Palenquero">Palenquero</option>
                                                    <option value="Gitano">Gitano</option>
                                                    <option value="Otro">Otro</option>
                                                </select>
                                            </div>
                                            <div class="div form-group col-sm-3">
                                                <label for="txtPersonas_cargo">Personas a cargo</label>
                                                <input type="number" value="0" min='0' class="form-control" name="personas_cargo" onblur="sociodemografica()" id="txtPersonas_cargo">
                                            </div>
                                            <div class="div form-group col-sm-3">
                                                <label for="selCabeza_familia">Cabeza_familia</label>
                                                <select name="cabeza_familia" id="selCabeza_familia" class="form-control" onblur="sociodemografica()">
                                                    <option value="0">No</option>
                                                    <option value="1m">Si</option>
                                                </select>
                                            </div>
                                            <div class="div form-group col-sm-3">
                                                <label for="txtHijos">Número de hijos</label>
                                                <input type="number" value="0" min='0' class="form-control" name="hijos" id="txtHijos" onblur="sociodemografica()">
                                            </div>
                                            <div class="div form-group col-sm-3">
                                                <label for="selFuma">Fuma</label>
                                                <select name="fuma" id="selFuma" class="form-control" onblur="sociodemografica()">
                                                    <option value="0">No</option>
                                                    <option value="1">Si</option>
                                                </select>
                                            </div>
                                            <div class="div form-group col-sm-6">
                                                <label for="txtfuma_frecuencia">Frecuencia en que fuma</label>
                                                <input type="text" class="form-control" name="fuma_frecuencia" id="txtfuma_frecuencia" onblur="sociodemografica()">
                                            </div>
                                            <div class="div form-group col-sm-6">
                                                <label for="txtDeporte">Deportes que práctica</label>
                                                <input type="text" class="form-control" name="deporte" id="txtDeporte" onblur="sociodemografica()">
                                            </div>
                                            <div class="div form-group col-sm-6">
                                                <label for="selBebidas">Consume bebidas alcoholicas </label>
                                                <select name="bebidas" id="selBebidas" class="form-control" onblur="sociodemografica()">
                                                    <option value="0">No</option>
                                                    <option value="1">Si</option>
                                                </select>
                                            </div>
                                            <div class="div form-group col-sm-6">
                                                <label for="txtbebe_frecuencia">Frecuencia en que consube bebidas alcoholicas</label>
                                                <input type="text" class="form-control" name="bebe_frecuencia" id="txtbebe_frecuencia" onblur="sociodemografica()">
                                            </div>
                                            <div class="div form-group col-sm-3">
                                                <label for="selLicencia">Liencia de conducción</label>
                                                <select name="licencia_conduccion" id="selLicencia" class="form-control" onblur="sociodemografica()">
                                                    <option value="0">No</option>
                                                    <option value="1">Si</option>
                                                </select>
                                            </div>
                                            <div class="div form-group col-sm-6">
                                                <label for="txtLicencia_descr">Descripción de la licencia</label>
                                                <input type="text" class="form-control" name="licencia_descr" id="txtLicencia_descr" onblur="sociodemografica()">
                                            </div>
                                            <div class="div form-group col-sm-3">
                                                <label for="txtTallaCamisa">Talla camisa</label>
                                                <input type="text" class="form-control" name="talla_camisa" id="txtTallaCamisa" onblur="sociodemografica()">
                                            </div>
                                            <div class="div form-group col-sm-3">
                                                <label for="txtTallaPantalon">Talla pantalón</label>
                                                <input type="text" class="form-control" name="talla_pantalon" id="txtTallaPantalon" onblur="sociodemografica()">
                                            </div>
                                            <div class="div form-group col-sm-3">
                                                <label for="txtTallaCalzado">Talla calzado</label>
                                                <input type="text" class="form-control" name="talla_calzado" id="txtTallaCalzado" onblur="sociodemografica()">
                                            </div>
                                            <div class="div form-group col-sm-3">
                                                <label for="selTVivienda">Tipo de vivienda</label>
                                                <select name="tipo_vivienda" id="selTVivienda" class="form-control" onblur="sociodemografica()">
                                                    <option value="En arriendo">En arriendo</option>
                                                    <option value="Propia">Propia</option>
                                                    <option value="Familiar">Familiar</option>
                                                    <option value="Otra">Otra</option>
                                                </select>
                                            </div>
                                            <div class="div form-group col-sm-12">
                                                <label for="txtAct_tiempo_libre">Actividades de tiempo libre</label>
                                                <textarea name="act_tiempo_libre" id="txtAct_tiempo_libre" rows="2" class="form-control" onblur="sociodemografica()"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- Personas a cargo -->
    <div class="modal fade" id="personaCargo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Agregar persona a cargo</h3>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: white;">&times;</span>
                        </button>
                    </div>
                    <form id="form_crear_persona_cargo">
                        <div class="card-body">
                            <div class="div form-group">
                                <label for="selParentezcoPersona">Parentezco</label>
                                <select name="tipo_lesion" id="selParentezcoPersona" class="form-control" required>
                                    <option value="Hij@">Hij@</option>
                                    <option value="Padre">Padre</option>
                                    <option value="Madre">Madre</option>
                                    <option value="Herman@">Herman@</option>
                                    <option value="Abuel@">Abuel@</option>
                                    <option value="Prim@">Prim@</option>
                                    <option value="Ti@">Ti@</option>
                                    <option value="Sobrin@">Sobrin@</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                            <div class="div form-group">
                                <label for="txtNombrePersona">Nombre</label>
                                <input type="text" class="form-control" id="txtNombrePersona" required>
                            </div>
                            <div class="div form-group">
                                <label for="txtFechaNacPersona">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" id="txtFechaNacPersona" required>
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

    <div class="modal fade" id="crearMedicamento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Agregar Medicamento</h3>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: white;">&times;</span>
                        </button>
                    </div>
                    <form id="form_crear_medicamento">
                        <div class="card-body">
                            <div class="div form-group">
                                <label for="txtNombreMed">Nombre del medicamento</label>
                                <input type="text" id="txtNombreMed" class="form-control" name="nombre" placeholder="Ingrese el nombre del medicamento" required>
                            </div>
                            <div class="div form-group">
                                <label for="txtIndicaciones">Indicaciones</label>
                                <textarea name="" id="txtIndicaciones" rows="5" placeholder="Ingresa la descripción o forma de medicación" class="form-control"></textarea>
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
    <!-- Enfermedad-->
    <div class="modal fade" id="crearEnfermedad" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Agregar Enfermedad</h3>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: white;">&times;</span>
                        </button>
                    </div>
                    <form id="form_crear_enfermedad">
                        <div class="card-body">
                            <div class="div form-group">
                                <label for="txtNombreEnf">Nombre de la enfermedad</label>
                                <input type="text" id="txtNombreEnf" class="form-control" name="nombre" placeholder="Ingrese el nombre de la enfermedad" required>
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
    <!-- Alergia -->
    <div class="modal fade" id="crearAlergia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Agregar Alergia</h3>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: white;">&times;</span>
                        </button>
                    </div>
                    <form id="form_crear_alergia">
                        <div class="card-body">
                            <div class="div form-group">
                                <label for="selTipoAlergia">Tipo de alergia</label>
                                <select name="tipo_alergia" id="selTipoAlergia" class="form-control" required>
                                    <option value="Respiratoria">Respiratoria</option>
                                    <option value="Alimento">Alimento</option>
                                    <option value="Medicamento">Medicamento</option>
                                    <option value="Otra">Otra</option>
                                </select>
                            </div>
                            <div class="div form-group">
                                <label for="txtNombreAlergia">Nombre de la alergia</label>
                                <input type="text" id="txtNombreAlergia" class="form-control" name="nombre" placeholder="Ingrese el nombre de la alergia" required>
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
    <!-- Cirugias -->
    <div class="modal fade" id="crearCirugia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Agregar Cirugía</h3>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: white;">&times;</span>
                        </button>
                    </div>
                    <form id="form_crear_cirugia">
                        <div class="card-body">
                            <div class="div form-group">
                                <label for="txtNombreCirugia">Nombre de la cirugía</label>
                                <input type="text" id="txtNombreCirugia" class="form-control" name="nombre" placeholder="Ingrese el nombre de la cirugía" required>
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
    <!-- Lesion -->
    <div class="modal fade" id="crearLesion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Agregar Lesión</h3>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: white;">&times;</span>
                        </button>
                    </div>
                    <form id="form_crear_lesion">
                        <div class="card-body">
                            <div class="div form-group">
                                <label for="selTipoLesion">Tipo de lesión</label>
                                <select name="tipo_lesion" id="selTipoLesion" class="form-control" required>
                                    <option value="Esguince">Esguince</option>
                                    <option value="Luxación">Luxación</option>
                                    <option value="Fractura">Fractura</option>
                                    <option value="Desgarro">Desgarro</option>
                                    <option value="Otra">Otra</option>
                                </select>
                            </div>
                            <div class="div form-group">
                                <label for="txtNombreLesion">Nombre de la Lesión</label>
                                <input type="text" id="txtNombreLesion" class="form-control" name="nombre" placeholder="Ingrese el nombre de la lesión" required>
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
    <!-- Antecendentes-->
    <div class="modal fade" id="crearAntecedente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Agregar Antecedente</h3>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: white;">&times;</span>
                        </button>
                    </div>
                    <form id="form_crear_antecedente">
                        <div class="card-body">
                            <div class="div form-group">
                                <label for="selAntecedente">Ha sufrido de</label>
                                <select name="tipo_lesion" id="selAntecedente" class="form-control" required>
                                    <option value="RUBEOLA">RUBEOLA</option>
                                    <option value="SARAMPION">SARAMPION</option>
                                    <option value="VARICELA">VARICELA</option>
                                    <option value="PAPERAS">PAPERAS</option>
                                    <option value="TETANO">TETANO</option>
                                    <option value="COVID 19">COVID 19</option>
                                </select>
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

    <!-- Estudios Academicos -->

    <div class="modal fade" id="crearEstudio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Agregar Estudio Académico</h3>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: white;">&times;</span>
                        </button>
                    </div>
                    <form id="form_crear_estudio">
                        <div class="card-body">
                            <div class="div form-group">
                                <label for="selNivel">Nivel</label>
                                <select name="nivel" id="selNivel" class="form-control" required>
                                    <option value="Bachillerato">Bachillerato</option>
                                    <option value="Superior">Superior</option>
                                    <option value="Postgrados">Postgrados</option>
                                </select>
                            </div>
                            <div class="div form-group">
                                <label for="selTipoEstudio">Tipo nivel</label>
                                <select name="tipo_estudio" id="selTipoEstudio" class="form-control" required>
                                    <option value="Bachiller">Bachiller</option>
                                    <option value="Técnico Laboral">Técnico Laboral</option>
                                    <option value="Técnico Profesional">Técnico Profesional</option>
                                    <option value="Técnologo">Técnologo</option>
                                    <option value="Pregrado">Pregrado</option>
                                    <option value="Especialización">Especialización</option>
                                    <option value="Maestría">Maestría</option>
                                    <option value="Doctorado">Doctorado</option>
                                </select>
                            </div>
                            <div class="div form-group">
                                <label for="txtTitulo">Título</label>
                                <input type="text" id="txtTitulo" class="form-control" name="nombre" placeholder="Ingrese el nombre del título adquirido" required>
                            </div>
                            <div class="div form-group">
                                <label for="txtInstitucion">Institución</label>
                                <input type="text" id="txtInstitucion" class="form-control" name="institucion   " placeholder="Ingrese el nombre de la institución" required>
                            </div>
                            <div class="div form-group">
                                <label for="txtAñoEstudio">Año</label>
                                <input type="number" value="2000" id="txtAñoEstudio" class="form-control" name="año_estudio" placeholder="Ingrese el año de graduación" required>
                            </div>
                            <div class="div form-group">
                                <label for="txtCiudad">Ciudad</label>
                                <input type="text" id="txtCiudad" class="form-control" name="ciudad_estudio" placeholder="Ingrese el nombre de la ciudad de graduación" required>
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

    <!-- Otro estudio -->
    <div class="modal fade" id="crearOtroEst" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Agregar Curso</h3>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: white;">&times;</span>
                        </button>
                    </div>
                    <form id="form_crear_curso">
                        <div class="card-body">
                            <div class="div form-group">
                                <label for="txtNombreCurso">Nombre del Curso</label>
                                <input type="text" id="txtNombreCurso" class="form-control" required>
                            </div>
                            <div class="div form-group">
                                <label for="txtFechaCurso">Fecha</label>
                                <input type="date" id="txtFechaCurso" class="form-control" required>
                            </div>
                            <div class="div form-group">
                                <label for="txtHorasCursos">Horas Cursadas</label>
                                <input type="number" min="0" id="txtHorasCursos" class="form-control" required>
                            </div>
                            <div class="div form-group">
                                <label for="txtInstitucionCurso">Institución</label>
                                <input type="text" id="txtInstitucionCurso" class="form-control" required>
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
    <script>
        $(document).ready(function() {
            $('#selMunicipio').select2({});
        });
    </script>
    <!-- /.content-wrapper -->
<?php
    include_once '../Vista/layouts/footer.php';
} else {
    header('Location: ../Vista/adm_panel.php');
}
?>