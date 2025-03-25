<?php
session_start();
if ((isset($_SESSION['biblioteca']['id']) && $_SESSION['biblioteca']['id'] == 9) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    include_once '../Vista/layouts/header.php'
?>
    <title>Gestión Biblioteca</title>
    <?php
    include_once '../Vista/layouts/nav.php';
    include_once '../Conexion/Conexion.php';
    ?>
    <!-- Modal -->
    <script src="../Recursos/js/archivo.js?v=1"></script>
    <input type="hidden" id="txtPage" value="adm">
    <input type="hidden" id="id_usuario" value="<?= $_SESSION['datos'][0]->id ?>">
    <input type="hidden" id="txtTipoUsuario" value="<?= $_SESSION['datos'][0]->id_tipo_usuario ?>">
    <input type="hidden" id="txtCargoUsuario" value="<?= $_SESSION['datos'][0]->id_cargo ?>">
    <input type="hidden" id="txtEditar" value="<?= $_SESSION['biblioteca']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtVer" value="<?= $_SESSION['biblioteca']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtEliminar" value="<?= $_SESSION['biblioteca']['eliminar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">

    <?php
    if ($_SESSION['biblioteca']['crear'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade" id="crear_categoria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header notiHeader">
                        <h5 class="modal-title" id="exampleModalLabel">Crear categoria de biblioteca</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: white;"></button>
                    </div>
                    <form id="form_crear_categoria">
                        <div class="modal-body">
                            <div class="div form-group">
                                <label for="txtNombreCategoria">Nombre Categoria</label>
                                <input type="text" id="txtNombreCategoria" class="form-control" name="nombre_categoria" placeholder="Ingrese el nombre o título de la categoria" required>
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
        <div class="modal fade" id="crearArchivo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card card-success">
                        <div class="modal-header notiHeader">
                            <h3 class="card-title">Subir Documento</h3>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" style="color: white;">&times;</span>
                            </button>
                        </div>
                        <form id="form_crear_archivo">
                            <div class="card-body">
                                <div class="div form-group">
                                    <label for="txtNombre">Nombre del archivo *</label>
                                    <input type="text" id="txtNombre" name="nombre" placeholder="Ingresa el nombre o título del archivo" required class="form-control">
                                </div>
                                <div class="div form-group">
                                    <label for="txtDesc">Descripción del archivo</label>
                                    <textarea id="txtDesc" cols="30" name="descripcion" rows="5" placeholder="Ingresa la descripción del archivo" class="form-control"></textarea>
                                </div>
                                <div class="div form-group">
                                    <label for="selCategoria">Categoria *</label>
                                    <select name="id_categoria" id="selCategoria" class="form-control" required>
                                        <option value="0">Seleccione una opción</option>
                                        <?php
                                        $sqlCategoria = ejecutarSQL::consultar("SELECT id, nombre FROM categoria_archivo");
                                        while ($filaCategoria = mysqli_fetch_array($sqlCategoria)) {
                                            echo '<option value="' . $filaCategoria['id'] . '">' . $filaCategoria['nombre'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="div form-group">
                                    <label for="selPrivacidad">Privacidad *</label>
                                    <select name="privacidad" id="selPrivacidad" class="form-control" required>
                                        <option value="">Seleccione una opción</option>
                                        <option value="Todos">Todos</option>
                                        <option value="Cargo">Cargo</option>
                                        <option value="Sede">Sede</option>
                                        <option value="Area">Area</option>
                                        <option value="Usuario">Usuario</option>
                                    </select>
                                </div>
                                <div class="div form-group" style="display: none;" id="divSede">
                                    <label for="selSedeNota">Sede</label>
                                    <select name="id_sede" id="selSedeNota" class="form-control">
                                        <option value="0">Seleccione una opción</option>
                                        <?php
                                        $sql = ejecutarSQL::consultar("SELECT id, nombre FROM sedes WHERE estado=1");
                                        while ($filaSede = mysqli_fetch_array($sql)) {
                                            echo '<option value="' . $filaSede['id'] . '">' . $filaSede['nombre'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="div form-group" style="display: none;" id="divArea">
                                    <label for="selArea">Area</label>
                                    <select name="id_area" id="selArea" class="form-control" style="width: 100%;">
                                        <option value="0">Seleccione una opción</option>
                                        <?php
                                        $sqlAreas = "SELECT id, nombre FROM areas WHERE estado=1";
                                        $resAreas = ejecutarSQL::consultar($sqlAreas);
                                        while ($area = mysqli_fetch_array($resAreas)) {
                                            echo '<option value="' . $area['id'] . '">' . $area['nombre'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="div form-group" style="display: none;" id="divCargo">
                                    <label for="selCargoNota">Cargo</label>
                                    <select name="id_cargo" id="selCargoNota" class="form-control">
                                        <option value="0">Seleccione una opción</option>
                                        <?php
                                        $sql = "SELECT id, nombre_cargo FROM cargos WHERE id>2";
                                        $sqlCargos = ejecutarSQL::consultar($sql);
                                        while ($filaC = mysqli_fetch_array($sqlCargos)) {
                                            echo '<option value="' . $filaC['id'] . '">' . $filaC['nombre_cargo'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="div form-group" style="display: none;" id="divUsuario">
                                    <label for="selUsuario">Usuario</label>
                                    <select name="id_usuario" id="selUsuario" class="form-control" style="width: 100%;">
                                        <option value="0">Seleccione una opción</option>
                                        <?php
                                        $sqlColaboradores = "SELECT U.id, U.nombre_completo, C.nombre_cargo FROM usuarios U JOIN cargos C ON U.id_cargo=C.id WHERE U.id<>1 AND U.estado=1";
                                        $resColaboradores = ejecutarSQL::consultar($sqlColaboradores);
                                        while ($colaborador = mysqli_fetch_array($resColaboradores)) {
                                            echo '<option value="' . $colaborador['id'] . '">' . $colaborador['nombre_completo']  . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class='fas fa-file'></i></span>
                                    </div>
                                    <input type="file" id="txtArchivo" name="archivo" class="form-control" required>
                                </div>
                            </div>
                            <div class="card-footer">
                                <input type="hidden" name="funcion" value="crear_archivo">
                                <input type="hidden" name="id_autor" value="<?php echo $_SESSION['id_user']; ?>">
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
    if ($_SESSION['biblioteca']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade" id="editarArchivo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header notiHeader">
                        <h5 class="modal-title" id="exampleModalLabel">Editar información del archivo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: white;"></button>
                    </div>
                    <form id="form_editar_archivo">
                        <div class="modal-body">
                            <div class="div form-group">
                                <label for="txtNombre2">Nombre del archivo</label>
                                <input type="text" id="txtNombre2" name="nombre_foto" placeholder="Ingresa el nombre o título del archivo" class="form-control" required>
                            </div>
                            <div class="div form-group">
                                <label for="txtDesc2">Descripción de l archivo</label>
                                <textarea id="txtDesc2" cols="30" name="desc_foto" rows="5" placeholder="Ingresa la descripción del archivo" class="form-control" required></textarea>
                            </div>
                            <div class="div form-group">
                                <label for="selCategoria2">Categoria</label>
                                <select name="id_categoria" id="selCategoria2" class="form-control" required>
                                    <option value="0">Seleccione una opción</option>
                                    <?php
                                    $sqlCategoria2 = ejecutarSQL::consultar("SELECT id, nombre FROM categoria_archivo");
                                    while ($filaCategoria2 = mysqli_fetch_array($sqlCategoria2)) {
                                        echo '<option value="' . $filaCategoria2['id'] . '">' . $filaCategoria2['nombre'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="div form-group">
                                <label for="selPrivacidad2">Privacidad</label>
                                <select name="id_privacidad" id="selPrivacidad2" class="form-control" required>
                                    <option value="">Seleccione una opción</option>
                                    <option value="Todos">Todos</option>
                                    <option value="Cargo">Cargo</option>
                                    <option value="Area">Area</option>
                                    <option value="Sede">Sede</option>
                                    <option value="Usuario">Usuario</option>
                                </select>
                            </div>
                            <div class="div form-group" style="display: none;" id="divArea2">
                                <label for="selArea2">Area</label>
                                <select name="id_area" id="selArea2" class="form-control" style="width: 100%;">
                                    <option value="0">Seleccione una opción</option>
                                    <?php
                                    $sqlAreas = "SELECT id, nombre FROM areas WHERE estado=1";
                                    $resAreas = ejecutarSQL::consultar($sqlAreas);
                                    while ($area = mysqli_fetch_array($resAreas)) {
                                        echo '<option value="' . $area['id'] . '">' . $area['nombre'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="div form-group" style="display: none;" id="divSede2">
                                <label for="selSede2">Sede</label>
                                <select name="id_sede" id="selSede2" class="form-control">
                                    <option value="0">Seleccione una opción</option>
                                    <?php
                                    $sqlSede = ejecutarSQL::consultar("SELECT id, nombre FROM sedes WHERE estado=1");
                                    while ($filaSede = mysqli_fetch_array($sqlSede)) {
                                        echo '<option value="' . $filaSede['id'] . '">' . $filaSede['nombre'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="div form-group" style="display: none;" id="divCargo2">
                                <label for="selCargo2">Cargo</label>
                                <select name="id_cargo" id="selCargo2" class="form-control">
                                    <option value="0">Seleccione una opción</option>
                                    <?php
                                    $sql = "SELECT id, nombre_cargo FROM cargos WHERE id>2";
                                    $sqlCargos = ejecutarSQL::consultar($sql);
                                    while ($filaC = mysqli_fetch_array($sqlCargos)) {
                                        echo '<option value="' . $filaC['id'] . '">' . $filaC['nombre_cargo'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="div form-group" style="display: none;" id="divUsuario2">
                                <label for="selUsuario2">Usuario</label>
                                <select name="id_usuario" id="selUsuario2" class="form-control" style="width: 100%;">
                                    <option value="0">Seleccione una opción</option>
                                    <?php
                                    $sqlColaboradores = "SELECT U.id, U.nombre_completo, C.nombre_cargo FROM usuarios U JOIN cargos C ON U.id_cargo=C.id WHERE U.id<>1 AND U.estado=1";
                                    $resColaboradores = ejecutarSQL::consultar($sqlColaboradores);
                                    while ($colaborador = mysqli_fetch_array($resColaboradores)) {
                                        echo '<option value="' . $colaborador['id'] . '">' . $colaborador['nombre_completo']  . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="input-group mb-3">
                                <input type="hidden" id="txtId_archivo_ed" name="id">
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
        <div class="modal fade" id="editar_categoria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header notiHeader">
                        <h5 class="modal-title" id="exampleModalLabel">Editar categoria de biblioteca</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: white;"></button>
                    </div>
                    <div class="modal-body">
                        <div class="div form-group">
                            <label for="txtNombreCategoria2">Nombre Categoria</label>
                            <input type="text" id="txtNombreCategoria2" class="form-control" name="nombre_categoria" placeholder="Ingrese el nombre o título de la categoria" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="txtIdCategoriaEd" name="id">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn bg-gradient-primary">Guardar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    <?php
    }
    if ($_SESSION['biblioteca']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade" id="detalle_archivo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header notiHeader">
                        <h5 class="modal-title" id="exampleModalLabel">Detalle Archivo</h5>
                        <div></div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: white;"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12" id="divFechaCreacion"></div>
                            <div class="col-sm-12 text-left" id="divEstado"></div>
                            <div class="col-sm-6">
                                <p id="pNombre"></p>
                                <p id="pTipo"></p>
                            </div>
                            <div class="col-sm-6">
                                <p id="pCategoria"></p>
                                <p id="pPrivacidad"></p>
                            </div>
                            <div class="col-sm-12" id="divDescripcion"></div>
                            <div class="col-sm-12 text-right" id="divAutor"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
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
                    <div class="col-sm-8">
                        <h1>Gestión Biblioteca
                            <?php
                            if ($_SESSION['biblioteca']['crear'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
                            ?>
                                <button type="button" id="btn_crear_archivo" data-bs-toggle="modal" data-bs-target="#crearArchivo" class="btn bg-gradient-success m-2">Subir Documento</button>
                                <button type="button" id="btn_crear_categoria" data-bs-toggle="modal" data-bs-target="#crear_categoria" class="btn bg-gradient-warning m-2">Crear categoria</button>
                            <?php
                            }
                            ?>
                        </h1>
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../Vista/adm_panel.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Gestión Biblioteca</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section>
            <div class="card card_personalizada card-tabs">
                <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a href="#archivos" class="nav-link active" data-bs-toggle='tab'>Archivos</a></li>
                        <li class="nav-item"><a href="#categorias" class="nav-link" data-bs-toggle='tab'>Categorias</a></li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="archivos">
                            <div class="container-fluid">
                                <div class="card card-success">
                                    <div class="modal-header notiHeader">
                                        <h3 class="card-title">Buscar Archivo</h3>
                                        <div class="input-group">
                                            <input type="text" id="TxtBuscarArchivo" placeholder="Ingrese nombre, descripción, tipo o categoria" class="form-control float-left">
                                            <div class="input-group-append">
                                                <button class="btn btn-default"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body pb-0">
                                        <div id="busquedaArchivos" class="row d-flex align-items-stretch" style="overflow-y: auto; max-height: 1200px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="categorias">
                            <div class="container-fluid">
                                <div class="card card-success">
                                    <div class="modal-header notiHeader">
                                        <h3 class="card-title">Buscar Categoria</h3>
                                        <div class="input-group">
                                            <input type="text" id="TxtBuscarCategoria" placeholder="Ingrese nombre" class="form-control float-left">
                                            <div class="input-group-append">
                                                <button class="btn btn-default"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body pb-0">
                                        <div id="busquedaCategoria" class="row d-flex align-items-stretch" style="overflow-y: auto; max-height: 1200px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        $(document).ready(function() {
            $('#selUsuario').select2({
                allowClear: true,
                dropdownParent: $('#divUsuario')
            });
            $('#selUsuario2').select2({
                allowClear: true,
                dropdownParent: $('#divUsuario2')
            });
            $('#selSede').select2({
                allowClear: true,
                dropdownParent: $('#divSede')
            });
            $('#selSede2').select2({
                allowClear: true,
                dropdownParent: $('#divSede2')
            });
            $('#selCargo').select2({
                allowClear: true,
                dropdownParent: $('#divCargo')
            });
            $('#selCargo2').select2({
                allowClear: true,
                dropdownParent: $('#divCargo2')
            });
            $('#selArea').select2({
                allowClear: true,
                dropdownParent: $('#divArea')
            });
            $('#selArea2').select2({
                allowClear: true,
                dropdownParent: $('#divArea2')
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