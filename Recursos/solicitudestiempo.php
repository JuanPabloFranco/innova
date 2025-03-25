<?php
include_once '../Modelo/EnvioCorreo.php';
include_once '../DAO/usuarioDAO.php';
include_once '../DAO/envioCorreoDAO.php';

include_once '../Modelo/TiempoParaTi.php';
include_once '../DAO/tiempoParaTiDAO.php';

include_once '../Controlador/controlador_phpmailer.php';
$tiempo = new TiempoParaTi();
$envio = new EnvioCorreo();
$dao = new tiempoParaTiDAO();
$envioDAO = new envioCorreoDAO();
$usuarioDAO = new usuarioDAO();


set_time_limit(0);
ini_set('memory_limit', '2048M');
$dia = date('w');
//Revisar ultimo envio mayor a 24 horas
date_default_timezone_set('America/Bogota');
$fechaHoraActual = date('Y-m-d H:i:s');
$num = 0;
$destinatarios = "";
$usuarioDAO->listarActivos();
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

$body = "Quindipisos te recuerda solicitar el tiempo para ti de la proxima semana, este proceso se realiza a través del módulo de autogestión";
enviarCorreoGeneral("Recordatorio tiempo para ti ", $fechaHoraActual, 'Talento Humano Quindipisos', $body, $destinatarios);
sleep(10);

if ($num > 0) {
    $envio->setFechaHora($fechaHoraActual);
    $envio->setTipo("Recordatorio solicitar tiempo para ti - ");
    $envio->setDestinatarios($destinatarios);
    $envioDAO->crear($envio);
}