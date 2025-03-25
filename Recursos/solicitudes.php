<?php
include_once '../Modelo/Incapacidad.php';
include_once '../Modelo/EnvioCorreo.php';
include_once '../DAO/solicitudDAO.php';
include_once '../DAO/usuarioDAO.php';
include_once '../DAO/envioCorreoDAO.php';
include_once '../Controlador/controlador_phpmailer.php';
$incapacidad = new Incapacidad();
$envio = new EnvioCorreo();
$usuarioDAO = new usuarioDAO();
$envioDAO = new envioCorreoDAO();
$solicitudDAO = new solicitudDAO();


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
$solicitudDAO->listarSolicitudesEn2Dias();
$num = 0;
$colaboradores = "";
foreach ($solicitudDAO->objetos as $obj) {
    $num++;    
    if ($num <> 1) {
        $colaboradores .= "," . $obj->nombre_completo;
    } else {
        $colaboradores .= $obj->nombre_completo;
    }
    $body = "Te informamos que el colaborador " . $obj->nombre_completo . " comienza a disfrutar de  " . $obj->tipo . " a partir del dia " . $obj->fecha_inicial ;
    enviarCorreoGeneral("Solicitud ", $obj->id . " por iniciar", 'Área Talento Humano', $body, $destinatarios);
    sleep(10);
}
if ($num > 0) {
    $envio->setFechaHora($fechaHoraActual);
    $envio->setTipo("Solicitud aprobada por iniciar de " . $colaboradores);
    $envio->setDestinatarios($destinatarios);
    $envioDAO->crear($envio);
}