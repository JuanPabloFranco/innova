<?php
include_once '../Modelo/Tarea.php';
include_once '../Modelo/ResponsableTarea.php';
include_once '../DAO/tareaDAO.php';
include_once '../Controlador/controlador_phpmailer.php';
$tarea = new Tarea();
$responsable = new ResponsableTarea();
$dao = new tareaDAO();
session_start();

if ($_POST['funcion'] == 'crear_tarea') {
    $responsables = json_decode($_POST['responsables']);
    $tarea->setNombre($_POST['nombre']);
    $tarea->setFechaInicio($_POST['fecha_inicio']);
    $tarea->setFechaFin($_POST['fecha_fin']);
    $tarea->setDescripcion($_POST['descripcion']);
    $tarea->setObservaciones($_POST['observaciones']);
    $tarea->setTipoTarea($_POST['tipo_tarea']);
    // Cita
    $tarea->setUbicacion($_POST['ubicacion']);
    $tarea->setDescripcionUbicacion($_POST['descripcion_ubicacion']);
    $tarea->setEstado(1);
    $dao->crear($tarea);
    $dao->buscar_tarea($tarea);
    $tarea->setId($dao->objetos[0]->id);
    foreach ($responsables as $resp) {
        $responsable->setIdResponsable($resp);
        $responsable->setIdTarea($dao->objetos[0]->id);
        $dao->crear_tarea_responsable($responsable);
    }

    notificarTarea($tarea->getId(), "crear");
}

if ($_POST['funcion'] == 'editar_tarea') {
    $responsables = json_decode($_POST['responsables']);

    $tarea->setId($_POST['id']);
    $tarea->setNombre($_POST['nombre']);
    $tarea->setFechaInicio($_POST['fecha_inicio']);
    $tarea->setFechaFin($_POST['fecha_fin']);
    $tarea->setDescripcion($_POST['descripcion']);
    $tarea->setObservaciones($_POST['observaciones']);
    $tarea->setTipoTarea($_POST['tipo_tarea']);
    // Cita
    $tarea->setUbicacion($_POST['ubicacion']);
    $tarea->setDescripcionUbicacion($_POST['descripcion_ubicacion']);

    $dao->editar_tarea($tarea, $_POST['pagina']);
    $responsable->setIdTarea($_POST['id']);
    $dao->listar_responsables_tareas($responsable);

    $respActuales = [];
    $numResp = 0;
    foreach ($dao->objetos as $respActual) {
        $respActuales[$numResp] = $respActual->id;
        $numResp++;
    }
    // eliminar el responsable si es el caso
    foreach ($respActuales as $actual) {
        if (!in_array($actual, $responsables)) {
            $responsable->setIdTarea($_POST['id']);
            $responsable->setIdResponsable($actual);
            $dao->eliminar_responsable_tarea($responsable);
        }
    }
    //Crear responsable si es el caso
    foreach ($responsables as $nuevo) {
        if (!in_array($nuevo, $respActuales)) {
            //crear actual
            $responsable->setIdTarea($_POST['id']);
            $responsable->setIdResponsable($nuevo);
            $dao->crear_tarea_responsable($responsable);
        }
    }
    notificarTarea($tarea->getId(), "editar");
}

if ($_POST['funcion'] == 'buscarTareas') {
    $json = array();
    $dao->listar_tareas($tarea);
    foreach ($dao->objetos as $objeto) {
        $responsables = "";
        $ids = "";
        $coma = "";
        $num = 1;
        $responsable->setIdTarea($objeto->id);
        $dao->listar_responsables_tareas($responsable);
        foreach ($dao->objetos as $objeto2) {
            if ($num <> 1) {
                $coma = ", ";
            }
            $responsables .=  "<img id='" . $objeto2->id . "' idTarea='" . $objeto2->t_responsable . "' class='img-circle elevation-2' title='" . $objeto2->nombre_completo . "' src='../Recursos/img/avatars/" . $objeto2->avatar . "' style='width: 35px; height: 35px'>";
            $ids .= $coma . $objeto2->id;
            $num++;
        }
        $json[] = array(
            'id' => $objeto->id,
            'tipo_tarea' => $objeto->tipo_tarea,
            'fecha_inicio' => $objeto->fecha_inicio,
            'fecha_fin' => $objeto->fecha_fin,
            'estado' => $objeto->estado,
            'descripcion' => $objeto->descripcion,
            'responsables' => $responsables,
            'id_responsables' => $ids,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'miAgenda') {
    $json = array();
    $dao->listar_mi_agenda($_SESSION['datos'][0]->id);
    foreach ($dao->objetos as $objeto) {
        $responsables = "";
        $ids = "";
        $coma = "";
        $num = 1;
        $responsable->setIdTarea($objeto->id);
        $dao->listar_responsables_tareas($responsable);
        foreach ($dao->objetos as $objeto2) {
            if ($num <> 1) {
                $coma = ", ";
            }
            $responsables .=  "<img id='" . $objeto2->id . "' idTarea='" . $objeto2->t_responsable . "' class='img-circle elevation-2' title='" . $objeto2->nombre_completo . "' src='../Recursos/img/avatars/" . $objeto2->avatar . "' style='width: 35px; height: 35px'>";
            $ids .= $coma . $objeto2->id;
            $num++;
        }
        $json[] = array(
            'id' => $objeto->id,
            'tipo_tarea' => $objeto->tipo_tarea,
            'nombre' => $objeto->nombre,
            'fecha_inicio' => $objeto->fecha_inicio,
            'fecha_fin' => $objeto->fecha_fin,
            'estado' => $objeto->estado,
            'descripcion' => $objeto->descripcion,
            'responsables' => $responsables,
            'id_responsables' => $ids,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'cargarTarea') {
    $json = array();
    $responsables = "";
    $ids = "";
    $coma = "";
    $num = 1;
    $responsable->setIdTarea($_POST['id']);
    $dao->listar_responsables_tareas($responsable);
    foreach ($dao->objetos as $objeto2) {
        if ($num <> 1) {
            $coma = ", ";
        }
        $responsables .=  "<img id='" . $objeto2->id . "'  idTarea='" . $objeto2->t_responsable . "' class='img-circle elevation-2 imgResponsable' title='" . $objeto2->nombre_completo . "' src='../Recursos/img/avatars/" . $objeto2->avatar . "' style='width: 35px; height: 35px'>";
        $ids .= $coma . $objeto2->id;
        $num++;
    }
    $tarea->setId($_POST['id']);
    $dao->cargar($tarea);
    $json[] = array(
        'nombreTarea' => $dao->objetos[0]->nombre_tarea,
        'fechaInicio' => $dao->objetos[0]->fecha_inicio,
        'fechaFin' => $dao->objetos[0]->fecha_fin,
        'estado' => $dao->objetos[0]->estado,
        'descripcion' => $dao->objetos[0]->descripcion,
        'tipoTarea' => $dao->objetos[0]->tipo_tarea,
        'ubicacion' => $dao->objetos[0]->ubicacion,
        'descripcionUbicacion' => $dao->objetos[0]->descripcion_ubicacion,
        'observaciones' => $dao->objetos[0]->observaciones,
        'responsables' => $responsables,
        'idsResponsables' => $ids,
    );
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}


if ($_POST['funcion'] == 'eliminarTarea') {
    $tarea->setId($_POST['id']);
    $responsable->getIdTarea($_POST['id']);
    $dao->eliminar_responsable_tarea($responsable);
    $dao->eliminar_tarea($tarea);
}

if ($_POST['funcion'] == 'finalizarTarea') {
    $tarea->setId($_POST['id']);
    $tarea->setEstado(2);
    $dao->cambiar_estado_tarea($tarea);
}

if ($_POST['funcion'] == 'cancelarTarea') {
    $tarea->setId($_POST['id']);
    $tarea->setEstado(3);
    $dao->cambiar_estado_tarea($tarea);
}

if ($_POST['funcion'] == 'activarTarea') {
    $tarea->setId($_POST['id']);
    $tarea->setEstado(1);
    $dao->cambiar_estado_tarea($tarea);
}

// Responsables
if ($_POST['funcion'] == 'eliminarResponsable') {
    $responsable->setId($_POST['id']);
    $dao->eliminar_responsable_tarea($responsable);
}

if ($_POST['funcion'] == 'graficos') {
    $json = array();
    $cantidad = [];
    $valor = [];
    if ($_POST['grafico'] == "agendaPorTipo") {
        $dao->agendaPorTipo();
    } else if ($_POST['grafico'] == "agendaPorEstado") {
        $dao->agendaPorEstado();
    } else if ($_POST['grafico'] == "agendaPorTipoProxima") {
        $dao->agendaPorTipoProxima();
    }
    foreach ($dao->objetos as $objeto) {
        if ($_POST['grafico'] == "agendaPorEstado") {
            if ($objeto->valor == 1) {
                array_push($valor, 'Pendiente');
            } else if ($objeto->valor == 2) {
                array_push($valor, 'Finalizada');
            }else{
                array_push($valor, 'Cancelada');
            }
        } else {
            array_push($valor, $objeto->valor);
        }
        array_push($cantidad, $objeto->cantidad);
    }
    $json[] = array(
        'cantidad' => $cantidad,
        'valor' => $valor
    );
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
