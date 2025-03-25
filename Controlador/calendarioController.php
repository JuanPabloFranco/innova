<?php
session_start();
include_once '../Modelo/Tarea.php';
include_once '../DAO/tareaDAO.php';
$tarea = new Tarea();
$dao = new tareaDAO();
$json = array();
$dao->listar_tarea_responsable($_GET['id']);
foreach ($dao->objetos as $objeto) {
    if ($objeto->estado == 1) { // Pendiente
        if ($objeto->tipo_tarea == 'Tarea') {
            $color = '#ff7700';
            $textColor = "#FFFFFF";
        }
        if ($objeto->tipo_tarea == 'Cita / Reunión') {
            $color = '#6c6a70';
            $textColor = "#FFFFFF";
        }
        if ($objeto->tipo_tarea == 'Evento') {
            $color = '#77FF33';
            $textColor = "#000000";
        }
        if ($objeto->tipo_tarea == 'Laboral Festivo') {
            $color = '#733DF8';
            $textColor = "#000000";
        }
    }
    if ($objeto->estado == 2) { // Cancelado
        $color = '#519548';
        $textColor = "#FFFFFF";
    }
    if ($objeto->estado == 3) { // Finalizado
        $color = '#00ff00';
        $textColor = "#FFFFFF";
    }
    $responsable = new ResponsableTarea();
    $responsable->setIdTarea($objeto->id);
    $dao->listar_responsables_tareas($responsable);
    $responsables = "";
    $listResponsables = "";
    $ids = "";
    $coma = "";
    $num = 1;
    foreach ($dao->objetos as $objeto2) {
        if ($num <> 1) {
            $coma = ", ";
        }
        $listResponsables .= "<p>" . $objeto2->nombre_completo . "</p>";
        $responsables .=  "<img id='" . $objeto2->id . "' idTarea='" . $objeto2->t_responsable . "' class='img-circle elevation-2' title='" . $objeto2->nombre_completo . "' src='../Recursos/img/avatars/" . $objeto2->avatar . "' style='width: 35px; height: 35px'>";
        $ids .= $coma . $objeto2->id;
        $num++;
    }

    $json[] = array(
        'tipoEvento' => "Tarea",
        'id' => $objeto->id,
        'title' => "(" . $objeto->tipo_tarea . ") " . $objeto->nombre,
        'start' => $objeto->fecha_inicio,
        'end' => $objeto->fecha_fin,
        'color' => $color,
        'textColor' => $textColor,
        'extendedProps' => [
            'estado' => $objeto->estado,
            'fecha_inicio' => $objeto->fecha_inicio,
            'fecha_fin' => $objeto->fecha_fin,
            'ubicacion' => $objeto->ubicacion,
            'descripcion_ubicacion' => $objeto->descripcion_ubicacion,
            'descripcion' => $objeto->descripcion,
            'tipo_tarea' => $objeto->tipo_tarea,
            'observaciones' => $objeto->observaciones,
            'responsables' => $responsables,
            'idsResponsables' => $ids,
            'listResponsables' => $listResponsables,
        ],
    );
}

// $reunion->reunionCalendario($_SESSION['id_user'], $_SESSION['type_id']);
// foreach ($reunion->objetos as $objeto) {
//     $color = '#102405f2';
//     $textColor = "white";
//     $color = 'red';
//     $json[] = array(
//         'id' => $objeto->id,
//         'tipoEvento' => 'reunion',
//         'title' => $objeto->nombre,
//         'start' => $objeto->fecha_hora_inicio,
//         'end' => $objeto->fecha_hora_final,
//         'color' => $color,
//         'textColor' => $textColor,
//         'extendedProps' => [
//             'tipoEvento' => 'reunion',
//             'tipo' => $objeto->tipo,
//             'fecha_hora_inicio' => $objeto->fecha_hora_inicio,
//             'fecha_hora_final' => $objeto->fecha_hora_final,
//             'direccion' => $objeto->direccion
//         ],
//     );
// }
$jsonstring = json_encode($json);
echo $jsonstring;
