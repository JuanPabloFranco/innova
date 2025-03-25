<?php
session_start();
if (isset($_SESSION['datos'][0]->id)) {
    include_once '../Vista/layouts/header.php';
    include_once '../Conexion/Conexion.php';

?>
    <title>Inicio</title>
    <?php
    include_once '../Vista/layouts/nav.php';
    ?>
    <script src="../Recursos/js/inicio.js"></script>
    <input type="hidden" id="id_usuario" value="<?= $_SESSION['datos'][0]->id ?>">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <br>
        <!-- Main content -->
        <div class="container">
            <div class="row">                
                
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