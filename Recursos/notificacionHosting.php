<?php
include_once '../Modelo/EnvioCorreo.php';
include_once '../DAO/usuarioDAO.php';
include_once '../DAO/envioCorreoDAO.php';

include_once '../Modelo/Configuracion.php';
include_once '../DAO/configuracionDAO.php';

include_once '../Controlador/controlador_phpmailer.php';
$conf = new Configuracion();
$envio = new EnvioCorreo();
$dao = new configuracionDAO();
$envioDAO = new envioCorreoDAO();
$usuarioDAO = new usuarioDAO();


set_time_limit(0);
ini_set('memory_limit', '2048M');
$año = date('Y');
//Revisar ultimo envio mayor a 24 horas
date_default_timezone_set('America/Bogota');
$fechaHoraActual = date('Y-m-d H:i:s');
$num = 0;
$destinatarios = "";
$usuarioDAO->buscarUsersConfiguracionFull();
foreach ($usuarioDAO->objetos as $user) {
    if ($user->email <> "" && $user->email <> null) {
        $num++;
        if ($num <> 1) {
            $destinatarios .= "," . $user->email;
        } else {
            $destinatarios .= $user->email;
        }
    }
}


$dao->vencimientoHosting();
$num = 0;
foreach ($dao->objetos as $obj) {
    $num++;
    $body = "Se informa que el hosting y dominio esta próximo a vencerse, este se vence el día  " . $obj->hosting . ", recuerda que el hosting este proceso se hace en HOSTINGER, haciendo clic al link  <a href='https://www.hostinger.co/' target='blanck'>https://www.hostinger.co/</a><br><b>Usuario: </b>recurhumanoquindi@gmail.com<br><b>Contraseña: </b>QuindiPisos2024";
    enviarCorreoGeneral("Recordatorio Vencimiento Hosting y Dominio", $año, 'Configuración Quindisistem', $body, $destinatarios);
    sleep(10);
    $envio->setFechaHora($fechaHoraActual);
    $envio->setTipo("Recordatorio Vencimiento Hosting y Dominio");
    $envio->setDestinatarios($destinatarios);
    $envioDAO->crear($envio);
}