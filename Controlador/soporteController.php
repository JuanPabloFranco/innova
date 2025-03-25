<?php
session_start();
include_once '../Modelo/Soporte.php';
include_once '../DAO/soporteDAO.php';
$soporte = new Soporte();
$dao = new soporteDAO();

if ($_POST['funcion'] == 'buscar_solicitud') {
    $json = array();
    $dao->buscar($_SESSION['datos'][0]->id, $_SESSION['datos'][0]->id_tipo_usuario);
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'tipo' => $objeto->tipo,
            'estado' => $objeto->estado,
            'imagen' => $objeto->imagen,
            'descripcion' => $objeto->descripcion,
            'observaciones' => $objeto->observaciones,
            'nombre_modulo' => $objeto->nombre_modulo,
            'nombre_completo' => $objeto->nombre_completo,
            'email' => $objeto->email,
            'doc_id' => $objeto->doc_id,
            'fecha' => $objeto->fecha,
            'avatar' => $objeto->avatar
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'img_soporte') {
    $respuesta = "";
    if (($_FILES['soporte']['type'] == 'image/jpeg') || ($_FILES['soporte']['type'] == 'image/png') || ($_FILES['soporte']['type'] == 'image/gif')) {
        $imagen = uniqid() . "-" . $_FILES['soporte']['name'];
        $ruta = '../Recursos/img/soporte/' . $imagen;
        if (move_uploaded_file($_FILES['soporte']['tmp_name'], $ruta)) {
            $soporte->setId($_POST['id']);
            $soporte->setImagen($imagen);
            $dao->cargar($soporte);
            $old = $dao->objetos[0]->imagen;
            $dao->agregarImagen($soporte);
            unlink('../Recursos/img/soporte/' . $old);
            $respuesta = "";
        } else {
            $respuesta = 'Error al guardar la imagen en el servidor';
        }
    } else {
        $respuesta = "El archivo seleccionado debe ser jpeg, png o gif";
    }
    echo $respuesta;
}

if ($_POST['funcion'] == 'crear_soporte') {
    date_default_timezone_set('America/Bogota');
    $soporte->setFecha(date('Y-m-d', time()));
    $soporte->setId_autor($_POST['id_autor']);
    $soporte->setId_modulo($_POST['id_modulo']);
    $soporte->setTipo($_POST['tipo']);
    $soporte->setDescripcion($_POST['descripcion']);
    $dao->crear($soporte);
}

if ($_POST['funcion'] == 'cambiar_estado') {
    $soporte->setId($_POST['id_soporte']);
    $soporte->setEstado($_POST['estado']);
    $soporte->setObservaciones($_POST['observaciones']);
    $dao->cambiarEstado($soporte);
}

if ($_POST['funcion'] == 'contar_soporte') {
    $json = array();
    $dao->contarSoporte($_SESSION['datos'][0]->id_tipo_usuario, $_SESSION['datos'][0]->id);
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'cantidad' => $objeto->cantidad
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'cargar') {
    $json = array();
    $soporte->setId($_POST['id']);
    $dao->cargar($soporte);
    $json[] = array(
        'tipo' => $dao->objetos[0]->tipo,
        'estado' => $dao->objetos[0]->estado,
        'imagen' => $dao->objetos[0]->imagen,
        'descripcion' => $dao->objetos[0]->descripcion,
        'observaciones' => $dao->objetos[0]->observaciones,
        'nombre_modulo' => $dao->objetos[0]->nombre_modulo,
        'nombre_completo' => $dao->objetos[0]->nombre_completo,
        'email' => $dao->objetos[0]->email,
        'doc_id' => $dao->objetos[0]->doc_id,
        'fecha' => $dao->objetos[0]->fecha,
        'avatar' => $dao->objetos[0]->avatar
    );
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}