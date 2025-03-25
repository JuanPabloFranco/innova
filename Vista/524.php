<?php
session_start();
    include_once '../Vista/layouts/header.php'
?>
    <title>Error 404</title>
    <?php
    include_once '../Vista/layouts/nav.php';
    ?>
    <!-- Modal -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-">
                    <div class="col-sm-12 text-center">
                        <img src="../Recursos/img/shield-2.png" width="20%">
                        <h1>ERROR 524</h1>
                        <br>
                        <h6>Lo siento, no tienes permiso para acceder a esta pagina</h6>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>  
    </div>
    <!-- /.content-wrapper -->
<?php
    include_once '../Vista/layouts/footer.php';
?>