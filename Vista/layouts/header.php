<!DOCTYPE html>
<html>

<head>
    <html lang="es">
    <meta charset="utf-8">
    <meta content="" name="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="" rel="icon" id="faviconHeader">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


    <!-- Font Awesome -->
    <link rel="stylesheet" href="../Recursos/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../Recursos/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Select 2 -->
    <link rel="stylesheet" href="../Recursos/css/select2.css">
    <link rel="stylesheet" href="../Recursos/css/styles.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="../Recursos/daterangepicker/daterangepicker.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="../Recursos/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="../Recursos/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="../Recursos/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">


    <script src="../Recursos/js/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../Recursos/js/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../Recursos/js/adminlte.min.js"></script>
    <!-- Sweet alert -->
    <!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script> -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Select 2 -->
    <script src="../Recursos/js/select2.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
    <!-- jQuery -->

    <script src="../Recursos/js/nav.js"></script>
    <!-- Bootstrap 4 -->
    <!-- <script src="../Recursos/js/bootstrap.bundle.min.js"></script> -->

    <script src="../Recursos/js/jquery-validation/jquery.validate.min.js"></script>
    <script src="../Recursos/js/jquery-validation/additional-methods.min.js"></script>

    <!-- Bootstrap4 Duallistbox -->
    <script src="../Recursos/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <!-- InputMask -->
    <script src="../Recursos/moment/moment.min.js"></script>
    <script src="../Recursos/inputmask/min/jquery.inputmask.bundle.min.js"></script>
    <!-- date-range-picker -->
    <script src="../Recursos/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="../Recursos/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <!-- Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script type="text/javascript" language="javascript" src="../Recursos/js/ajaxCombos.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../Recursos/js/demo.js"></script>
    <!-- <style>
            #container {
                width: 1000px;
                margin: 20px auto;
            }

            .ck-editor__editable[role="textbox"] {
                /* editing area */
                min-height: 200px;
            }

            .ck-content .image {
                /* block images */
                max-width: 80%;
                margin: 20px auto;
            }
        </style> -->


    <?php
    $styleBody = "";
    date_default_timezone_set('America/Bogota');
    $fecha = date("Y-m-d");
    $dia = date("d");
    $mes = date("m");
    $año = date("Y");
    // $mes = 12;
    // $dia = 23;
    if (isset($_SESSION['empresa']['google_analitycs'])) {
    ?>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?= $_SESSION['empresa']['google_analitycs'] ?>">
        </script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', '<?= $_SESSION['empresa']['google_analitycs'] ?>"');
        </script>
    <?php
    }
    if ($mes == 9) {
    ?>
        <link rel="stylesheet" href="../Recursos/css/amoryamistad.css">
        <?php
    }
    if ($mes == 10) {
        $styleBody = "background-image: url(../Recursos/img/fondohallowen2.png) !important;";
        if ($dia > 1) {
        ?>
            <!-- estilos hallowen -->
            <link href="../Recursos/css/hallowen/stylehallowen.css" rel="stylesheet" type="text/css" />
            <!-- <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js' type='text/javascript'></script> -->
            <script>
                var Ghost = function() {
                    var a = {};
                    a.html = '<div class="ghost"></div>';
                    a.element = null;
                    a.timer = null;
                    a.interval = Math.floor(Math.random() * 1e3) + 1e3;
                    a.directionX = Math.round(Math.random());
                    a.directionY = Math.round(Math.random());
                    if (a.directionX == 0) {
                        a.directionX = -1
                    }
                    if (a.directionY == 0) {
                        a.directionY = -1
                    }
                    a.screenWidth = null;
                    a.screenHeight = null;
                    a.elementWidth = 150;
                    a.elementHeight = 145;
                    a.init = function() {
                        a.getBrowserSize();
                        jQuery(window).resize(function() {
                            a.getBrowserSize()
                        });
                        a.element = jQuery(a.html);
                        a.timer = window.setInterval(a.move, a.interval);
                        jQuery("body").append(a.element);
                        a.move(true);
                        a.move();
                        return a
                    };
                    a.move = function(b) {
                        var c = Math.floor(Math.random() * 100 + 100);
                        var d = Math.floor(Math.random() * 100 + 100);
                        var e = a.element.offset().left;
                        var f = a.element.offset().top;
                        var g = e + a.directionX * c;
                        var h = f + a.directionY * d;
                        var i = a.screenWidth - a.elementWidth - 20;
                        var j = a.screenHeight - a.elementHeight;
                        if (g > i) {
                            g = i;
                            a.directionX = -a.directionX
                        } else if (g < 0) {
                            g = 0;
                            a.directionX = -a.directionX
                        }
                        if (h > j) {
                            h = j;
                            a.directionY = -a.directionY
                        } else if (h < 0) {
                            h = 0;
                            a.directionY = -a.directionY
                        }
                        var k = Math.random() - .1;
                        if (k < .4) {
                            k = .4
                        }
                        if (b) {
                            a.element.css("top", Math.floor(Math.random() * a.screenHeight - a.elementHeight));
                            a.element.css("left", Math.floor(Math.random() * a.screenWidth - a.elementWidth))
                        } else {
                            a.element.removeClass("moving-left");
                            a.element.removeClass("moving-right");
                            if (g > e) {
                                a.element.addClass("moving-right")
                            } else if (g < e) {
                                a.element.addClass("moving-left")
                            }
                            a.element.stop();
                            a.element.animate({
                                top: h,
                                left: g,
                                opacity: k
                            }, {
                                duration: a.interval,
                                easing: "swing"
                            })
                        }
                    };
                    a.getBrowserSize = function() {
                        a.screenWidth = jQuery(document).width();
                        a.screenHeight = jQuery(document).height()
                    };
                    a.init();
                    return a
                }
            </script>
            <script>
                jQuery(function() {
                    var Ghosts = new Array();
                    for (var i = 0; i < 3; i++) {
                        Ghosts.push(new Ghost());
                    }
                })
            </script>
            <style>
                .ghost {
                    position: absolute;
                    width: 150px;
                    height: 145px;
                    z-index: 10001;
                    display: block;
                    opacity: 0.8;
                    background: transparent url('http://2.bp.blogspot.com/-timO_aG_TEY/UmsJXlNz5zI/AAAAAAAAK8Q/pcV38Lv7hRA/s1600/fantasma.png') no-repeat;
                }

                .ghost.moving-left {
                    -moz-transform: scaleX(-1);
                    -webkit-transform: scaleX(-1);
                    -o-transform: scaleX(-1);
                    transform: scaleX(-1);
                    filter: fliph;
                    /*IE*/
                }
            </style>
        <?php
        }
    }
    if ($mes >= 12) {
        ?>
        <link href="../Recursos/css/navidad/styleNavidad.css?v=1" rel="stylesheet" type="text/css" />
        <?php
        if ($dia >= 1 && $dia <= 8) {
            $styleBody = "background-image: url(../Recursos/img/fondo-navidad-1.jpg) !important; background-position-x: 70px; background-size: contain;";
        ?>
            <link href="../Recursos/css/navidad/velas.css" rel="stylesheet" type="text/css" />
        <?php
        }
        if ($dia > 8 && $dia <= 15) {
            $styleBody = "background-image: url(../Recursos/img/pesebre.jpg) !important;";
        }
        if ($dia > 15) {
            $styleBody = "background-image: url(../Recursos/img/christmas-background.jpg) !important;";
        ?>
            <script src='../Recursos/js/navidad/snowfall.jquery.js'></script>
            <script type='text/javascript'>
                $(document).ready(function() {

                    $(document).snowfall({
                        deviceorientation: true,
                        round: true,
                        minSize: 1,
                        maxSize: 8,
                        flakeCount: 250
                    });

                });
            </script>
        <?php
        }
        ?>
        <!-- estilos navidad -->
        <!-- <script type="text/javascript" src="../Recursos/js/navidad/jquery-latest.min.js"></script> -->
    <?php
    }
    ?>
</head>