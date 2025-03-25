<?php
include_once '../Modelo/Incapacidad.php';
include_once '../Modelo/EnvioCorreo.php';
include_once '../DAO/solicitudDAO.php';
include_once '../DAO/usuarioDAO.php';
include_once '../DAO/envioCorreoDAO.php';
include_once '../Controlador/controlador_phpmailer.php';
include_once '../DAO/asistenciaDAO.php';
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

$dao = new asistenciaDAO();
$dao->buscarLlegadasTardMes();
foreach ($dao->objetos as $obj) {
    $num++; 
    $destinatarios .= "," . $obj->email;
    $body = "Hola " . $obj->nombre_completo . ", notamos que este mes has llegado tarde " . $obj->cantidad_tardes . " veces, por favor ponte en contacto con el personal de Recursos Humanos para verificar. Si esta verificación ya fue realizada haga caso omiso a este correo." ;
    enviarCorreoGeneral("Notificacion llegadas tarde de ". $obj->nombre_completo . " mes actual", $fechaHoraActual . "-" .$num, 'Área Talento Humano', $body, $destinatarios);
    sleep(10);
}

if ($num > 0) {
    $envio->setFechaHora($fechaHoraActual);
    $envio->setTipo("Notificación llegadas tarde");
    $envio->setDestinatarios($destinatarios);
    $envioDAO->crear($envio);
}

?>