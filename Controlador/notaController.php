<?php
include_once '../Modelo/Nota.php';
include_once '../DAO/notaDAO.php';
$nota = new Nota();
$dao = new notaDAO();
session_start();

if ($_POST['funcion'] == 'crear_nota') {
    $nota->setIdAutor($_SESSION['datos'][0]->id);
    $nota->setTipo($_POST['tipo']);
    $nota->setIdCargo($_POST['id_cargo']);
    $nota->setIdSede($_POST['id_sede']);
    $nota->setIdArea($_POST['id_area']);
    $nota->setDirigido($_POST['dirigido']);
    $nota->setIdUsuario($_POST['id_usuario']);
    $nota->setFechaInicio($_POST['fechaini']);
    $nota->setFechaFin($_POST['fechafin']);
    $nota->setDescripcion($_POST['descripcion']);
    $dao->crear($nota);
}

if ($_POST['funcion'] == 'buscar_nota') {
    $json = array();    
    $nota->setIdAutor($_SESSION['datos'][0]->id);
    $dao->buscar_datos($nota);
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'tipo_nota' => $objeto->tipo_nota,
            'dirigido' => $objeto->dirigido,
            'id_cargo' => $objeto->id_cargo,
            'id_sede' => $objeto->id_sede,
            'id_usuario' => $objeto->id_usuario,
            'nombre_completo' => $objeto->nombre_completo,
            'nombre_cargo' => $objeto->nombre_cargo,
            'nombre_area' => $objeto->nombre_area,
            'nombre_sede' => $objeto->nombre_sede,
            'fecha_ini' => $objeto->fecha_ini,
            'fecha_fin' => $objeto->fecha_fin,
            'descripcion_nota' => $objeto->descripcion_nota
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'cargarNotaEdit') {
    $json = array();
    $nota->setId($_POST['id']);
    $dao->cargarNota($nota);
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'tipo_nota' => $objeto->tipo_nota,
            'dirigido' => $objeto->dirigido,
            'id_cargo' => $objeto->id_cargo,
            'id_sede' => $objeto->id_sede,
            'id_area' => $objeto->id_area,
            'id_usuario' => $objeto->id_usuario,
            'fecha_ini' => $objeto->fecha_ini,
            'fecha_fin' => $objeto->fecha_fin,
            'descripcion_nota' => $objeto->descripcion_nota
        );
    }
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'cargarNotaImg') {
    $json = array();
    $nota->setId($_POST['id']);
    $dao->cargarNota($nota);
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'tipo_nota' => $objeto->tipo_nota,
            'dirigido' => $objeto->dirigido,
            'imagen' => $objeto->imagen
        );
    }
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'changeImagen') {
    $nota->setId($_POST['id']);
    if (($_FILES['imagen']['type'] == 'image/jpeg') || ($_FILES['imagen']['type'] == 'image/png') || ($_FILES['imagen']['type'] == 'image/gif')) {
        $img = uniqid() . "-" . $_FILES['imagen']['name'];
        $nota->setImagen($img);
        $ruta = '../Recursos/img/notas/' . $img;
        if ($dao->cambiar_img($nota)) {
            move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta);
            if ($dao->objetos[0]->imagen <> "") {
                unlink('../Recursos/img/notas/' . $dao->objetos[0]->imagen);
            }
            $json = array();
            $json[] = array(
                'ruta' => $ruta,
                'alert' => 'edit'
            );
            $jsonstring = json_encode($json[0]);
            echo $jsonstring;
        } else {
            $json = array();
            $json[] = array(
                'alert' => 'Error al actualizar la imagén en base de datos'
            );
            $jsonstring = json_encode($json[0]);
            echo $jsonstring;
        }
    } else {
        $json = array();
        $json[] = array(
            'alert' => 'El formato de archivo seleccionado no es válido'
        );
        $jsonstring = json_encode($json[0]);
        echo $jsonstring;
    }
}

if ($_POST['funcion'] == 'editar_nota') {
    $nota->setId($_POST['id']);
    $nota->setTipo($_POST['tipo']);
    $nota->setIdCargo($_POST['id_cargo']);
    $nota->setIdSede($_POST['id_sede']);
    $nota->setDirigido($_POST['dirigido']);
    $nota->setIdUsuario($_POST['id_usuario']);
    $nota->setFechaInicio($_POST['fechaini']);
    $nota->setFechaFin($_POST['fechafin']);
    $nota->setDescripcion($_POST['descripcion']);
    $nota->setIdArea($_POST['id_area']);
    $dao->editar_nota($nota);
}

if ($_POST['funcion'] == 'eliminarNota') {
    $nota->setId($_POST['id']);
    $dao->cargarNota($nota);
    unlink('../Recursos/img/notas/' . $dao->objetos[0]->imagen);
    $dao->eliminarNota($nota);
}

if ($_POST['funcion'] == 'eliminarImagen') {
    $nota->setId($_POST['id']);
    $dao->cargarNota($nota);
    unlink('../Recursos/img/notas/' . $dao->objetos[0]->imagen);
    $dao->eliminarImagen($nota);
}