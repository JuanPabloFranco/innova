<?php
include_once '../Modelo/Contrato.php';
include_once '../Modelo/EnvioCorreo.php';
include_once '../DAO/contratoDAO.php';
include_once '../DAO/usuarioDAO.php';
include_once '../DAO/envioCorreoDAO.php';
include_once '../Controlador/controlador_phpmailer.php';
$contrato = new Contrato();
$envio = new EnvioCorreo();
$usuarioDAO = new usuarioDAO();
$envioDAO = new envioCorreoDAO();
$contratoDAO = new contratoDAO();


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
$contratoDAO->listarContratosAVencer35Dias();
$num = 0;
$colaboradores = "";
foreach ($contratoDAO->objetos as $obj) {
    $num++;    
    if ($num <> 1) {
        $colaboradores .= "," . $obj->nombre_completo;
    } else {
        $colaboradores .= $obj->nombre_completo;
    }
    $body = "Te informamos que el colaborador " . $obj->nombre_completo . " finaliza su contrato en " . $obj->dias . " días (" . $obj->fecha_finalizacion . "), es momento de enviarle la notificación escrita de la finalización del contrato (antes de 30 dias)";
    enviarCorreoGeneral("En ".$obj->dias . " finaliza el contrato", $obj->id_contrato, 'Área Talento Humano', $body, $destinatarios);
    sleep(10);
}
if ($num > 0) {
    $envio->setFechaHora($fechaHoraActual);
    $envio->setTipo("Recordatorio finalizacion contrato" . $colaboradores);
    $envio->setDestinatarios($destinatarios);
    $envioDAO->crear($envio);
}

$contratoDAO->listarContratosAVencer7Dias();
$num = 0;
$colaboradores = "";
foreach ($contratoDAO->objetos as $obj) {
    $num++;    
    if ($num <> 1) {
        $colaboradores .= "," . $obj->nombre_completo;
    } else {
        $colaboradores .= $obj->nombre_completo;
    }
    $body = "Te informamos que el colaborador " . $obj->nombre_completo . " finaliza su contrato en " . $obj->dias . " días (" . $obj->fecha_finalizacion . ")";
    enviarCorreoGeneral("En ".$obj->dias . " finaliza el contrato", $obj->id_contrato, 'Área Talento Humano', $body, $destinatarios);
    sleep(10);
}
if ($num > 0) {
    $envio->setFechaHora($fechaHoraActual);
    $envio->setTipo("Recordatorio finalizacion contrato" . $colaboradores);
    $envio->setDestinatarios($destinatarios);
    $envioDAO->crear($envio);
}