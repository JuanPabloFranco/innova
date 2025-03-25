<?php
session_start();
if (isset($_SESSION['datos'][0]->id)) {
    include_once '../Vista/layouts/header.php';
    include_once '../Conexion/Conexion.php';
    $fecha = date("Y-m-d");
    $dia = date("d");
    $mes = date("m");
?>
    <title>Panel</title>
    <?php
    include_once '../Vista/layouts/nav.php';
    ?>
    <script src="../Recursos/js/inicio.js"></script>
    <input type="hidden" id="id_usuario" value="<?php echo $_SESSION['datos'][0]->id; ?>">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <br>
        <!-- Main content -->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="container">
                        <div class="row" style="overflow-y: auto; max-height: 1200px;">
                            <?php
                            $sqlHistorias = "SELECT H.id, U.avatar, U.nombre_completo, H.id_autor, H.fecha_hora AS fecha_historia, H.texto, H.imagen, H.link, H.documento, H.id_autor FROM historia H JOIN usuarios U ON H.id_autor=U.id WHERE H.fecha_hora<=NOW() ORDER BY H.fecha_hora DESC";
                            $resHistoria = ejecutarSQL::consultar($sqlHistorias);
                            if (mysqli_num_rows($resHistoria) > 0) {
                                while ($historia = mysqli_fetch_array($resHistoria)) {
                            ?>
                                    <div class="col-sm-12 card card-widget notiHeader cardPub" style="color: black;">
                                        <div class="card-header notiHeader">
                                            <div class="user-panel d-flex">
                                                <div class="col-sm-11 d-flex">
                                                    <div class="image">
                                                        <a href="../Vista/usuario.php?id=<?= $historia['id_autor'] ?>"><img class="img-circle elevation-2" src="../Recursos/img/avatars/<?= $historia['avatar'] ?>"></a>
                                                    </div>
                                                    <div class="info d-flex">
                                                        <a href="../Vista/usuario.php?id=<?= $historia['id_autor'] ?>" class="d-block" style="color: white;"><?= $historia['nombre_completo'] ?> </a>
                                                        <small class='mt-1'> / <?= $historia['fecha_historia'] ?></small>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($historia['id_autor'] == $_SESSION['datos'][0]->id) {
                                                ?>
                                                    <div class="col-sm-1" idHistoria='<?= $historia['id'] ?>'>
                                                        <button class='delHistory btn btn-sm btn-danger mr-1 float-right' type='button' title='Eliminar'>
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="card-body" style="background-color: white !important; border-radius: 8px;">
                                            <div id="texto" style="color: black !important;"><?= $historia['texto'] ?></div><br>
                                            <?php
                                            if ($historia['imagen'] <> "") {
                                            ?>
                                                <div id="img" class='divHistorias'>
                                                    <img src="../Recursos/img/historias/<?= $historia['imagen'] ?>" style="width: 100%;">
                                                </div>
                                            <?php
                                            }
                                            if ($historia['link'] <> "") {
                                            ?>
                                                <div class='divHistorias'><a href="<?= $historia['link'] ?>" target="_blanck"><?= $historia['link'] ?></a><br><br></div>
                                            <?php
                                            }
                                            if ($historia['documento'] <> "") {
                                            ?>
                                                <div class='divHistorias'><a href="../Recursos/historias/<?= $historia['documento'] ?>" target="_blanck"><img style="width: 15%;" src="../Recursos/img/file.png"><?= $historia['documento'] ?> <br>Clic aquí para descargar</a></div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="card-footer" idHistoria='<?= $historia['id'] ?>'>
                                            <?php
                                            $sqlComentario = "SELECT U.avatar, U.nombre_completo, C.comentario, C.fecha_hora, C.id_autor FROM comentario_historia C JOIN usuarios U ON C.id_autor=U.id WHERE C.id_historia=" . $historia['id'] . " ORDER BY C.fecha_hora ASC";
                                            $resComentario = ejecutarSQL::consultar($sqlComentario);
                                            if (mysqli_num_rows($resComentario) > 0) {
                                                while ($comentario = mysqli_fetch_array($resComentario)) {
                                            ?>
                                                    <div class="d-flex">
                                                        <div class='col-sm-11 d-flex' style="color: black !important;">
                                                            <div>
                                                                <a href="../Vista/usuario.php?id=<?= $comentario['id_autor'] ?>"><img class="img-circle elevation-2" src="../Recursos/img/avatars/<?= $comentario['avatar'] ?>" width="30px"></a>
                                                            </div>
                                                            <div class='ml-2'>
                                                                <p style="text-align: justify; width: 100%;  color: black !important;">
                                                                    <a href="../Vista/usuario.php?id=<?= $comentario['id_autor'] ?>">
                                                                        <b><?= $comentario['nombre_completo'] ?></b>
                                                                    </a>
                                                                    <br><?= $comentario['comentario'] ?><br>
                                                                    <label style="font-size: 9px; margin-top: -20px; color: black !important;"><?= $comentario['fecha_hora'] ?></label>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        if ($comentario['id_autor'] == $_SESSION['datos'][0]->id) {
                                                        ?>
                                                            <div class="col-sm-1" idHistoria='<?= $historia['id'] ?>'>
                                                                <button class='delComentario btn btn-sm btn-danger mr-1 float-right' type='button' title='Eliminar' style="width: 10px; height: 20px;">
                                                                    <img src="../Recursos/img/eliminar.png" width="14px" style="margin-left: -7px; margin-top: -13px;">
                                                                </button>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                            <?php
                                                }
                                            }
                                            ?>
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#comentar" class="btn btnComentar bg-gradient-warning m-2 float-right">Comentar</button>
                                        </div>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content -->
    </div>
    <div class="modal fade" id="comentar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Registrar comentario</h3>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: white;">&times;</span>
                        </button>
                    </div>
                    <form id="form_crear_comentario">
                        <div class="card-body">
                            <div class="div form-group">
                                <label for="txtComentario">Comentario</label>
                                <textarea id="txtComentario" rows="4" placeholder="" class="form-control"></textarea>
                            </div>
                            <div class="div form-group">
                                <input type="hidden" id="txtIdHistoria">
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
    <!-- /.content-wrapper -->
<?php
    include_once '../Vista/layouts/footer.php';
} else {
    header('Location: ../index.php');
}
?>