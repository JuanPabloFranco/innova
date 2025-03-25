<?php
include_once '../Modelo/Historia.php';
include_once '../Modelo/ComentarioHistoria.php';
include_once '../DAO/historiaDAO.php';
$historia = new Historia();
$comentario = new ComentarioHistoria();
$dao = new historiaDAO();
session_start();

if ($_POST['funcion'] == 'crearHistoria') {
    date_default_timezone_set('America/Bogota');
    $fecha_hora = date('Y-m-d H:i:s', time());
    $historia->setIdAutor($_SESSION['datos'][0]->id);
    $historia->setTexto($_POST['texto']);
    $historia->setLink($_POST['link']);
    $historia->setFechaHora($fecha_hora);
    if ($_FILES['imagen']['name'] <> "") {
        if (($_FILES['imagen']['type'] == 'image/jpeg') || ($_FILES['imagen']['type'] == 'image/png') || ($_FILES['imagen']['type'] == 'image/gif')) {
            $imagen = uniqid() . "-" . $_FILES['imagen']['name'];
            if ($_FILES['documento']['name'] <> "") {
                $documento = uniqid() . "-" . $_FILES['documento']['name'];
                //Imagen
                $ruta = '../Recursos/img/historias/' . $imagen;
                move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta);
                // Documento
                $rutaDoc = '../Recursos/historias/' . $documento;
                move_uploaded_file($_FILES['documento']['tmp_name'], $rutaDoc);

                $historia->setImagen($imagen);
                $historia->setDocumento($documento);

                $dao->crear($historia);
            } else {
                //Imagen
                $ruta = '../Recursos/img/historias/' . $imagen;
                move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta);
                $historia->setImagen($imagen);
                $dao->crear($historia);
            }
        } else {
            echo "La imagen adjuntada no es aceptada";
        }
    } else {
        if ($_FILES['documento']['name'] <> "") {
            $documento = uniqid() . "-" . $_FILES['documento']['name'];
            // Documento
            $rutaDoc = '../Recursos/historias/' . $documento;
            move_uploaded_file($_FILES['documento']['tmp_name'], $rutaDoc);

            $historia->setDocumento($documento);

            $dao->crear($historia);
        } else {
            $dao->crear($historia);
        }
    }
}

if ($_POST['funcion'] == 'eliminarHistoria') {
    $historia->setId($_POST['id']);
    $dao->cargar($historia);
    if ($dao->objetos[0]->imagen <> '') {
        unlink('../Recursos/img/historias/' . $dao->objetos[0]->imagen <> '');
    }
    if ($dao->objetos[0]->documento <> '') {
        unlink('../Recursos/historias/' . $dao->objetos[0]->imagen <> '');
    }

    $dao->eliminar($historia);
    $dao->eliminarComentariosHistoria($historia);
}

if ($_POST['funcion'] == 'comentar') {
    date_default_timezone_set('America/Bogota');
    $fecha_hora = date('Y-m-d H:i:s', time());
    $comentario->setIdAutor($_SESSION['datos'][0]->id);
    $comentario->setIdHistoria($_POST['id_historia']);
    $comentario->setComentario($_POST['comentario']);
    $comentario->setFechaHora($fecha_hora);
    $dao->crear_comentario($comentario);
}

if ($_POST['funcion'] == 'eliminarComentario') {
    $comentario->setId($_POST['id']);
    $dao->eliminarComentario($comentario);
}
