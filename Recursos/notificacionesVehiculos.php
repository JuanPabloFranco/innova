<?php
include_once '../Modelo/EnvioCorreo.php';
include_once '../DAO/usuarioDAO.php';
include_once '../DAO/envioCorreoDAO.php';

include_once '../Modelo/Vehiculo.php';
include_once '../DAO/vehiculoDAO.php';

include_once '../Controlador/controlador_phpmailer.php';
$vehiculo = new Vehiculo();
$envio = new EnvioCorreo();
$dao = new vehiculoDAO();
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
$usuarioDAO->buscarUsersBodega();
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


$dao->vehiculoProximoSoat();
$num = 0;
foreach ($dao->objetos as $obj) {
    $num++;
    $body = "Te informamos que el vehiculo  " . $obj->tipo_vehiculo . " con placa No.  " . $obj->placa . " esta próximo a vencerse el SOAT ";
    enviarCorreoGeneral("Recordatorio Vencimiento SOAT", $num, 'Area de Bodega', $body, $destinatarios);
    sleep(10);
    $envio->setFechaHora($fechaHoraActual);
    $envio->setTipo("Recordatorio Vencimiento SOAT");
    $envio->setDestinatarios($destinatarios);
    $envioDAO->crear($envio);
}



$dao->vehiculoProximoTecno();
$num = 0;
foreach ($dao->objetos as $obj) {
    $num++;
    $body = "Te informamos que el vehiculo  " . $obj->tipo_vehiculo . " con placa No.  " . $obj->placa . " esta próximo a vencerse la tecnicomecánica ";
    enviarCorreoGeneral("Recordatorio Vencimiento Tecnicomecanica", $num, 'Area de Bodega', $body, $destinatarios);
    sleep(10);
    $envio->setFechaHora($fechaHoraActual);
    $envio->setTipo("Recordatorio Vencimiento Tecnicomecanica");
    $envio->setDestinatarios($destinatarios);
    $envioDAO->crear($envio);
}

$dao->vehiculoProximoMantenimiento();
$num = 0;
foreach ($dao->objetos as $obj) {
    $num++;
    $body = "Te informamos que el vehiculo  " . $obj->tipo_vehiculo . " con placa No.  " . $obj->placa . " esta próximo a realizarle mantenimiento el dia ".$obj->proximo_mantenimiento;
    enviarCorreoGeneral("Recordatorio Mantenimiento Vehiculo", $num, 'Area de Bodega', $body, $destinatarios);
    sleep(10);
    $envio->setFechaHora($fechaHoraActual);
    $envio->setTipo("Recordatorio Mantenimiento Vehiculo");
    $envio->setDestinatarios($destinatarios);
    $envioDAO->crear($envio);
}