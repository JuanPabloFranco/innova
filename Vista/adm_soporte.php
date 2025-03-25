<?php
session_start();
if (isset($_SESSION['permisos']) && $_SESSION['permisos'][0]['soporte'] == 1) {
    include_once '../Vista/layouts/header.php';
    include_once '../Conexion/Conexion.php';
?>
    <title>Soporte</title>
    <?php
    include_once '../Vista/layouts/nav.php';
    ?>
    <!-- Modal -->
    <script src="../Recursos/js/soporte_tecnico.js"></script>
    <input type="hidden" id="txtTipoUsuario" value="<?= $_SESSION['datos'][0]->id_tipo_usuario; ?>">
    <input type="hidden" id="txtId_cargo" value="<?= $_SESSION['datos'][0]->id_cargo; ?>">
    <input type="hidden" id="txtId_usuario" value="<?= $_SESSION['datos'][0]->id; ?>">
    <input type="hidden" id="txtPage" value="soporte">
    <div class="modal fade" id="crear_solicitud" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Registrar Solicitud de soporte</h3>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: white;">&times;</span>
                        </button>
                    </div>
                    <form id="form_crear_soporte">
                        <div class="card-body">
                            <div class="div form-group">
                                <label for="selTipo">Tipo *</label>
                                <select name="" id="selTipo" class="form-control" style="width: 100%;" required>
                                    <option value="">Seleccione una opción</option>
                                    <option value="Nuevo">Nuevo</option>
                                    <option value="Error">Error</option>
                                    <option value="Sugerencia">Sugerencia</option>
                                    <option value="Mejora">Mejora</option>
                                </select>
                            </div>
                            <div class="div form-group">
                                <label for="selModulo">Módulo*</label>
                                <select name="" id="selModulo" class="form-control" style="width: 100%;" required>
                                    <option value="">Seleccione una opción</option>
                                    <?php
                                    $sqlModulos = "SELECT * FROM modulos M WHERE M.estado=1 ORDER BY M.nombre ASC";
                                    $resModulos = ejecutarSQL::consultar($sqlModulos);
                                    while ($modulo = mysqli_fetch_array($resModulos)) {
                                        echo '<option value="' . $modulo['id'] . '" selected>' . $modulo['nombre'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="div form-group">
                                <label for="txtDescSoporte">Descripción</label>
                                <textarea id="txtDescSoporte" name="notas" rows="4" placeholder="Describe el problema a reportar, recomendación o sugerencia" class="form-control" required></textarea>
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

    <div class="modal fade" id="agregarSoporte" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header notiHeader">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Imagen de soporte</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_img_soporte" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="input-group mb-3 mt-2">
                            <input type="file" name="soporte" class='input-group' accept="image/*">
                            <input type="hidden" name="funcion" value="img_soporte">
                            <input type="hidden" name="id" id="txtIdSoporteImg">
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

    <div class="modal fade" id="cambiar_estado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header notiHeader">
                    <h5 class="modal-title" id="exampleModalLabel">Cambiar Estado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_estado_soporte" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="div form-group">
                            <label for="selEstado">Estado</label>
                            <select id="selEstado" class="form-control">
                                <option value="Revisado">Revisado</option>
                                <option value="En Proceso">En Proceso</option>
                                <option value="En Pruebas">En Pruebas</option>
                                <option value="Finalizado">Finalizado</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="div form-group">
                            <label for="txtObservaciones">Observaciones</label>
                            <textarea  id="txtObservaciones" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="txtIdEstadoSop">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn bg-gradient-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ver_caso" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header notiHeader">
                    <h5 class="modal-title" id="exampleModalLabel">Detalle Caso de Soporte</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_estado_soporte" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <p id="pEstado"></p>
                                <p id="pModulo"></p>
                                <p id="pFecha"></p>
                            </div>
                            <div class="col-sm-6">
                                <p id="pTipo"></p>
                                <p id="pAutor"></p>
                            </div>
                            <div class="col-sm-12 text-center">
                                <img id="imgCaso" width="60%">
                            </div>
                            <div class="col-sm-12">
                                <p id="pDescripcion"></p>
                                <p id="pObservaciones"></p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </form>
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
                        <h1>Soporte <?= $_SESSION['empresa'][0]->nombre ?>
                            <button type="button" id="btn_crear_usuario" data-bs-toggle="modal" data-bs-target="#crear_solicitud" class="btn bg-gradient-primary m-2">Registrar Solicitud</button>
                            <a href="https://api.whatsapp.com/send?phone=+573136464151&amp;text=Hola, puedes ayudarme" target="_blank">
                                <img src="../Recursos/img/whatsapp_icon.png" alt="" width="30">
                            </a>
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../Vista/adm_panel.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Soporte <?= $_SESSION['empresa'][0]->nombre ?></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section>
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Buscar Solicitud</h3>
                        <div class="input-group">
                            <input type="text" id="TxtBuscarSolicitud" placeholder="Ingrese el texto a buscar" class="form-control float-left">
                            <div class="input-group-append">
                                <button class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <div id="busquedaSoporte" class="row d-flex align-items-stretch" style="overflow-y: auto; max-height: 1200px;"></div>
                    </div>
                    <div class="card-footer">
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- /.content-wrapper -->
<?php
    include_once '../Vista/layouts/footer.php';
} else {
    header('Location: ../index.php');
}
?>