<?php
include_once '../Modelo/Incapacidad.php';
include_once '../Modelo/EnvioCorreo.php';
include_once '../DAO/incapacidadDAO.php';
include_once '../DAO/usuarioDAO.php';
include_once '../DAO/envioCorreoDAO.php';
include_once '../Controlador/controlador_phpmailer.php';
$incapacidad = new Incapacidad();
$envio = new EnvioCorreo();
$usuarioDAO = new usuarioDAO();
$envioDAO = new envioCorreoDAO();
$incapacidadDAO = new incapacidadDAO();


set_time_limit(0);
ini_set('memory_limit', '2048M');
$dia = date('w');
//Revisar ultimo envio mayor a 24 horas
date_default_timezone_set('America/Bogota');
$fechaHoraActual = date('Y-m-d H:i:s');
$num = 0;
$destinatarios = "";
$usuarioDAO->buscarUsersTalentoHumanoFull();
foreach ($usuarioDAO->objetos as $user) {
    if ($user->email <> "" && $user->email <> null) {
        $num++;
        if ($num <> 1) {
            $destinatarios .= "," . $user->email;
        } else {
            $destinatarios .= $user->email;
        }
    }
    //guardar una ejecucion del envio de correos
}
//buscar incapacidades
$incapacidadDAO->incapacidadesVencidas();
$num = 0;
$colaboradores = "";
foreach ($incapacidadDAO->objetos as $obj) {
    $num++;
    $incapacidad->setId($obj->id);
    $incapacidad->setEstado(2);
    $incapacidadDAO->cambiar_estado($incapacidad);
    if ($num <> 1) {
        $colaboradores .= "," . $obj->nombre_completo;
    } else {
        $colaboradores .= $obj->nombre_completo;
    }
    $body = "Te informamos que el colaborador " . $obj->nombre_completo . " el cual tenia una incapacidad activa desde el día " . $obj->inicio . " tenia como fecha de finalización el dia de ayer " . $obj->fin . ", por lo tanto el estado de esta se cambio a Inactiva";
    enviarCorreoGeneral("Incapacidad Vencida", $obj->id, 'Área Talento Humano', $body, $destinatarios);
    sleep(10);
}
if ($num > 0) {
    $envio->setFechaHora($fechaHoraActual);
    $envio->setTipo("Incapacidad Vencida de " . $colaboradores);
    $envio->setDestinatarios($destinatarios);
    $envioDAO->crear($envio);
}