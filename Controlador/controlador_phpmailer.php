<?php

use FontLib\Table\Type\head;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../Recursos/phpmailer/Exception.php';
require '../Recursos/phpmailer/PHPMailer.php';
require '../Recursos/phpmailer/SMTP.php';

include_once '../DAO/usuarioDAO.php';
include_once '../DAO/soporteDAO.php';
include_once '../DAO/sedeDAO.php';
include_once '../DAO/solicitudDAO.php';
include_once '../DAO/incapacidadDAO.php';
include_once '../DAO/compensacionHorasDAO.php';
include_once '../DAO/configuracionDAO.php';
include_once '../DAO/checkListVehiculoDAO.php';
include_once '../DAO/checkCumplimientoDAO.php';
include_once '../DAO/procesoSeleccionDAO.php';
include_once '../DAO/postuladoDAO.php';
include_once '../DAO/tiempoParaTiDAO.php';
include_once '../DAO/solicitudMuebleDAO.php';

include_once '../Modelo/Usuario.php';
include_once '../Modelo/Soporte.php';
include_once '../Modelo/Sede.php';
include_once '../Modelo/Solicitud.php';
include_once '../Modelo/Incapacidad.php';
include_once '../Modelo/CompensacionHoras.php';
include_once '../Modelo/OpcionCheckListVehiculo.php';
include_once '../Modelo/CheckListVehiculo.php';
include_once '../Modelo/OpcionCheckCumplimiento.php';
include_once '../Modelo/CheckCumplimiento.php';
include_once '../Modelo/Postulado.php';
include_once '../Modelo/ProcesoSeleccion.php';
include_once '../Modelo/Vacante.php';
include_once '../Modelo/TiempoParaTi.php';
include_once '../Modelo/solicitudMueble.php';

include_once '../Modelo/Configuracion.php';



function email_soporte($id_usuario, $descripcion)
{
    $soporte = new Soporte();
    $soporte->setId_autor($id_usuario);
    $soporte->setDescripcion($descripcion);
    $dao = new SoporteDAO();
    $dao->buscarDescripcionAutor($soporte);
    return $dao;
}

function cargar_soporte($id_soporte)
{
    $soporte = new Soporte();
    $soporte->setId($id_soporte);
    $dao = new SoporteDAO();
    $dao->cargar($soporte);
    return $dao;
}

function buscar_smtp()
{
    $dao = new configuracionDAO();
    $dao->cargarInformacion();
    return $dao;
}

function buscar_usuario($id_usuario)
{
    $usuario = new Usuario();
    $usuario->setId($id_usuario);
    $dao = new UsuarioDAO();
    $dao->cargarUserFull($usuario);
    return $dao;
}

function buscarUsersTalentoHumanoFull()
{
    $dao = new UsuarioDAO();
    $dao->buscarUsersTalentoHumanoFull();
    return $dao;
}

// Notificaciones usuarios
//Usuario nuevo
if (isset($_POST['funcion']) && $_POST['funcion'] == 'usuarioNuevo') {
    $smtp = buscar_smtp();
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $smtp->objetos[0]->host;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $smtp->objetos[0]->email;                     //SMTP username
    $mail->Password   = $smtp->objetos[0]->pass_email;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = $smtp->objetos[0]->port;
    $mail->CharSet = 'UTF-8';
    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    $usuarioDAO = new UsuarioDAO();
    $usuario = new Usuario();
    $usuario->setDocId($_POST['doc_id']);

    $usuarioDAO->cargarPorDocumento($usuario);
    $estado = "";

    $tipoCorreo = utf8_decode('Cuenta de Usuario Nuevo ');
    $consecutivoCorreo = $usuarioDAO->objetos[0]->doc_id;
    $plantilla = "";
    $head = cargarHead();
    $footer = cargarFooter();
    $plantilla .= $head;
    $plantilla .= '
    <body id="body" class="t78" style="min-width:100%;Margin:0px;padding:0px;background-color:#F4F7F8;">
        <div class="t77" style="background-color:#F4F7F8;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                <tr>
                    <td class="t76" style="font-size:0;line-height:0;mso-line-height-rule:exactly;background-color:#F4F7F8;" valign="top" align="center">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center" id="innerTable">
                            <tr>
                                <td>
                                    <table class="t15" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t14" style="background-color:#f09f09;width:430px;padding:25px 25px 25px 25px;">
                                                <div class="t13" style="display:inline-table;width:100%;text-align:left;vertical-align:middle;">
                                                    <div class="t3" style="display:inline-table;text-align:initial;vertical-align:inherit;width:30%;max-width:165px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t2">
                                                            <tr>
                                                                <td class="t1">
                                                                    <div style="font-size:0px;"><img class="t0" style="display:block;border:0;height:auto;width:100%;Margin:0;max-width:100%;" width="165" height="57.875" alt="" src="' . $smtp->objetos[0]->url_back . 'Recursos/img/empresa/' . $smtp->objetos[0]->logo . '" /></div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="t12" style="display:inline-table;text-align:initial;vertical-align:inherit;width:70%;max-width:385px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t11">
                                                            <tr>
                                                                <td class="t10">
                                                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t6" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t5" style="width:185px;">
                                                                                            <p class="t4" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">' . $tipoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t9" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t8" style="width:185px;">
                                                                                            <p class="t7" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">No. ' . $consecutivoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="t38" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t37" style="width:430px;padding:25px 25px 25px 25px;">
                                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td>
                                                            <table class="t18" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t17" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t16" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">Hola ' . $usuarioDAO->objetos[0]->nombre_completo . ',</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">Tienes una nueva cuenta de usuario en ' . $smtp->objetos[0]->nombre . '</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td colspan="2">Tus datos de acceso son:</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Usuario:</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $usuarioDAO->objetos[0]->email . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Contraseña</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $usuarioDAO->objetos[0]->doc_id . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Inicia sesión en</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><a target="blanck" href="' . $smtp->objetos[0]->url_back . '">' . $smtp->objetos[0]->url_back . '</a></p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>                                                    
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>';
    $plantilla .= $footer;

    $mail->setFrom($smtp->objetos[0]->email, $smtp->objetos[0]->nombre);

    $mail->addAddress($usuarioDAO->objetos[0]->email, $usuarioDAO->objetos[0]->nombre_completo);

    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Se ha creado un usuario para ti en ' . $smtp->objetos[0]->url_back;
    $mail->Body    = $plantilla;
    $mail->send();
}

// Login reset
if (isset($_POST['funcion']) && $_POST['funcion'] == 'cambio_credenciales') {
    $smtp = buscar_smtp();
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $smtp->objetos[0]->host;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $smtp->objetos[0]->email;                     //SMTP username
    $mail->Password   = $smtp->objetos[0]->pass_email;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = $smtp->objetos[0]->port;
    $mail->CharSet = 'UTF-8';
    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    $usuarioDAO = new UsuarioDAO();
    $usuario = new Usuario();
    $usuario->setDocId($_POST['id']);

    $usuarioDAO->cargarUserFull($usuario);
    $estado = "";

    $tipoCorreo = utf8_decode('Cambio Credenciales');
    $consecutivoCorreo = $usuarioDAO->objetos[0]->doc_id;
    $plantilla = "";
    $head = cargarHead();
    $footer = cargarFooter();
    $plantilla .= $head;
    $plantilla .= '
    <body id="body" class="t78" style="min-width:100%;Margin:0px;padding:0px;background-color:#F4F7F8;">
        <div class="t77" style="background-color:#F4F7F8;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                <tr>
                    <td class="t76" style="font-size:0;line-height:0;mso-line-height-rule:exactly;background-color:#F4F7F8;" valign="top" align="center">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center" id="innerTable">
                            <tr>
                                <td>
                                    <table class="t15" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t14" style="background-color:#f09f09;width:430px;padding:25px 25px 25px 25px;">
                                                <div class="t13" style="display:inline-table;width:100%;text-align:left;vertical-align:middle;">
                                                    <div class="t3" style="display:inline-table;text-align:initial;vertical-align:inherit;width:30%;max-width:165px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t2">
                                                            <tr>
                                                                <td class="t1">
                                                                    <div style="font-size:0px;"><img class="t0" style="display:block;border:0;height:auto;width:100%;Margin:0;max-width:100%;" width="165" height="57.875" alt="" src="' . $smtp->objetos[0]->url_back . 'Recursos/img/empresa/' . $smtp->objetos[0]->logo . '" /></div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="t12" style="display:inline-table;text-align:initial;vertical-align:inherit;width:70%;max-width:385px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t11">
                                                            <tr>
                                                                <td class="t10">
                                                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t6" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t5" style="width:185px;">
                                                                                            <p class="t4" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">' . $tipoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t9" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t8" style="width:185px;">
                                                                                            <p class="t7" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">No. ' . $consecutivoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="t38" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t37" style="width:430px;padding:25px 25px 25px 25px;">
                                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td>
                                                            <table class="t18" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t17" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t16" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">Hola ' . $usuarioDAO->objetos[0]->nombre_completo . ',</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">Tienes una nueva cuenta de usuario en ' . $smtp->objetos[0]->nombre . '</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td colspan="2">Tus datos de acceso son:</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Usuario:</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $usuarioDAO->objetos[0]->doc_id . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Contraseña</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $usuarioDAO->objetos[0]->doc_id . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Inicia sesión en</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><a target="blanck" href="' . $smtp->objetos[0]->url_back . '">' . $smtp->objetos[0]->url_back . '</a></p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>  
                                                    <tr>
                                                        <td><h5>Se recomienda cambiarlas al iniciar sesión</h5></td>
                                                    </tr>                                                  
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>';
    $plantilla .= $footer;

    $mail->setFrom($smtp->objetos[0]->email, $smtp->objetos[0]->nombre);

    $mail->addAddress($usuarioDAO->objetos[0]->email, $usuarioDAO->objetos[0]->nombre_completo);

    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Tus credenciales han cambiado en ' . $smtp->objetos[0]->url_back;
    $mail->Body    = $plantilla;
    $mail->send();
}

//Server settings
if (isset($_POST['funcion']) && $_POST['funcion'] == 'soporteRecibido') {
    $smtp = buscar_smtp();
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $smtp->objetos[0]->host;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $smtp->objetos[0]->email;                     //SMTP username
    $mail->Password   = $smtp->objetos[0]->pass_email;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = $smtp->objetos[0]->port;
    $mail->CharSet = 'UTF-8';
    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    $soporte = email_soporte($_POST['id_usuario'], $_POST['descripcion']);

    $tipoCorreo = utf8_decode('Ticket Soporte Nuevo');
    $consecutivoCorreo = $soporte->objetos[0]->id;
    $plantilla = "";
    $head = cargarHead();
    $footer = cargarFooter();
    $plantilla .= $head;
    $plantilla .= '
    <body id="body" class="t78" style="min-width:100%;Margin:0px;padding:0px;background-color:#F4F7F8;">
        <div class="t77" style="background-color:#F4F7F8;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                <tr>
                    <td class="t76" style="font-size:0;line-height:0;mso-line-height-rule:exactly;background-color:#F4F7F8;" valign="top" align="center">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center" id="innerTable">
                            <tr>
                                <td>
                                    <table class="t15" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t14" style="background-color:#f09f09;width:430px;padding:25px 25px 25px 25px;">
                                                <div class="t13" style="display:inline-table;width:100%;text-align:left;vertical-align:middle;">
                                                    <div class="t3" style="display:inline-table;text-align:initial;vertical-align:inherit;width:30%;max-width:165px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t2">
                                                            <tr>
                                                                <td class="t1">
                                                                    <div style="font-size:0px;"><img class="t0" style="display:block;border:0;height:auto;width:100%;Margin:0;max-width:100%;" width="165" height="57.875" alt="" src="' . $smtp->objetos[0]->url_back . 'Recursos/img/empresa/' . $smtp->objetos[0]->logo . '" /></div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="t12" style="display:inline-table;text-align:initial;vertical-align:inherit;width:70%;max-width:385px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t11">
                                                            <tr>
                                                                <td class="t10">
                                                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t6" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t5" style="width:185px;">
                                                                                            <p class="t4" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">' . $tipoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t9" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t8" style="width:185px;">
                                                                                            <p class="t7" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">No. ' . $consecutivoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="t38" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t37" style="width:430px;padding:25px 25px 25px 25px;">
                                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td>
                                                            <table class="t18" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t17" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t16" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">Hola Juan Pablo,</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">Tienes un ticket de soporte en ' . $smtp->objetos[0]->nombre . '</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td colspan="2">Información del Ticket:</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Solicitante:</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $soporte->objetos[0]->nombre_completo . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Módulo</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $soporte->objetos[0]->nombre_modulo . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Tipo</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $soporte->objetos[0]->tipo . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Descripción</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $soporte->objetos[0]->descripcion . '</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>                                                  
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>';
    $plantilla .= $footer;

    $mail->setFrom($smtp->objetos[0]->email, $smtp->objetos[0]->nombre);
    $mail->addAddress('jpfb1206@gmail.com');

    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Peticion de soporte ' . $smtp->objetos[0]->nombre;
    $mail->Body    = $plantilla;
    $mail->send();
}

if (isset($_POST['funcion']) && $_POST['funcion'] == 'soporteTerminado') {
    $smtp = buscar_smtp();
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $smtp->objetos[0]->host;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $smtp->objetos[0]->email;                     //SMTP username
    $mail->Password   = $smtp->objetos[0]->pass_email;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = $smtp->objetos[0]->port;
    $mail->CharSet = 'UTF-8';
    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    $soporte = cargar_soporte($_POST['id_soporte']);
    $tipoCorreo = utf8_decode('Ticket Soporte Finalizado');
    $consecutivoCorreo = $soporte->objetos[0]->id;    
    $plantilla = "";
    $head = cargarHead();
    $footer = cargarFooter();
    $plantilla .= $head;
    $plantilla .= '
    <body id="body" class="t78" style="min-width:100%;Margin:0px;padding:0px;background-color:#F4F7F8;">
        <div class="t77" style="background-color:#F4F7F8;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                <tr>
                    <td class="t76" style="font-size:0;line-height:0;mso-line-height-rule:exactly;background-color:#F4F7F8;" valign="top" align="center">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center" id="innerTable">
                            <tr>
                                <td>
                                    <table class="t15" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t14" style="background-color:#f09f09;width:430px;padding:25px 25px 25px 25px;">
                                                <div class="t13" style="display:inline-table;width:100%;text-align:left;vertical-align:middle;">
                                                    <div class="t3" style="display:inline-table;text-align:initial;vertical-align:inherit;width:30%;max-width:165px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t2">
                                                            <tr>
                                                                <td class="t1">
                                                                    <div style="font-size:0px;"><img class="t0" style="display:block;border:0;height:auto;width:100%;Margin:0;max-width:100%;" width="165" height="57.875" alt="" src="' . $smtp->objetos[0]->url_back . 'Recursos/img/empresa/' . $smtp->objetos[0]->logo . '" /></div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="t12" style="display:inline-table;text-align:initial;vertical-align:inherit;width:70%;max-width:385px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t11">
                                                            <tr>
                                                                <td class="t10">
                                                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t6" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t5" style="width:185px;">
                                                                                            <p class="t4" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">' . $tipoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t9" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t8" style="width:185px;">
                                                                                            <p class="t7" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">No. ' . $consecutivoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="t38" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t37" style="width:430px;padding:25px 25px 25px 25px;">
                                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td>
                                                            <table class="t18" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t17" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t16" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">Hola ' . $soporte->objetos[0]->nombre_completo . ',</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">El ticket de soporte que solicitaste ha finalizado</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td colspan="2">Información del Ticket:</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Solicitante:</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $soporte->objetos[0]->nombre_completo . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Módulo</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $soporte->objetos[0]->nombre_modulo . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Tipo</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $soporte->objetos[0]->tipo . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Descripción</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $soporte->objetos[0]->descripcion . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Observaciones</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $soporte->objetos[0]->observaciones . '</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>                                                  
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>';
    $plantilla .= $footer;

    $mail->setFrom($smtp->objetos[0]->email, $smtp->objetos[0]->nombre);
    $mail->addAddress($soporte->objetos[0]->email);

    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Tu ticket de soporte No. ' . $soporte->objetos[0]->id . ' ha finalizado';
    $mail->Body    = $plantilla;
    $mail->send();
}

if (isset($_POST['funcion']) && $_POST['funcion'] == 'enviar_email_solicitud') {
    $smtp = buscar_smtp();
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $smtp->objetos[0]->host;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $smtp->objetos[0]->email;                     //SMTP username
    $mail->Password   = $smtp->objetos[0]->pass_email;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = $smtp->objetos[0]->port;
    $mail->CharSet = 'UTF-8';
    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    $solicitudDAO = new solicitudDAO();
    $solicitud = new Solicitud();
    $solicitud->setIdUsuario($_POST['id_usuario']);
    $solicitud->setTipo($_POST['tipo']);
    $solicitud->setFechaInicial($_POST['fecha_inicial']);
    $solicitud->setCantidad($_POST['cantidad']);

    $solicitudDAO->listarUltimoCreado($solicitud);

    $tipoCorreo = utf8_decode('Solicitud ' . $_POST['tipo']);
    $consecutivoCorreo = $solicitudDAO->objetos[0]->id;
    $cantidad = '';
    if($_POST['tipo']=='Permiso'){
        $cantidad = $_POST['cantidad_horas']. ' horas';
    }else{
        $cantidad = $_POST['cantidad']. ' días';
    }
    $plantilla = "";
    $head = cargarHead();
    $footer = cargarFooter();
    $plantilla .= $head;
    $plantilla .= '
    <body id="body" class="t78" style="min-width:100%;Margin:0px;padding:0px;background-color:#F4F7F8;">
        <div class="t77" style="background-color:#F4F7F8;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                <tr>
                    <td class="t76" style="font-size:0;line-height:0;mso-line-height-rule:exactly;background-color:#F4F7F8;" valign="top" align="center">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center" id="innerTable">
                            <tr>
                                <td>
                                    <table class="t15" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t14" style="background-color:#f09f09;width:430px;padding:25px 25px 25px 25px;">
                                                <div class="t13" style="display:inline-table;width:100%;text-align:left;vertical-align:middle;">
                                                    <div class="t3" style="display:inline-table;text-align:initial;vertical-align:inherit;width:30%;max-width:165px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t2">
                                                            <tr>
                                                                <td class="t1">
                                                                    <div style="font-size:0px;"><img class="t0" style="display:block;border:0;height:auto;width:100%;Margin:0;max-width:100%;" width="165" height="57.875" alt="" src="' . $smtp->objetos[0]->url_back . 'Recursos/img/empresa/' . $smtp->objetos[0]->logo . '" /></div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="t12" style="display:inline-table;text-align:initial;vertical-align:inherit;width:70%;max-width:385px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t11">
                                                            <tr>
                                                                <td class="t10">
                                                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t6" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t5" style="width:185px;">
                                                                                            <p class="t4" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">' . $tipoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t9" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t8" style="width:185px;">
                                                                                            <p class="t7" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">No. ' . $consecutivoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="t38" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t37" style="width:430px;padding:25px 25px 25px 25px;">
                                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td>
                                                            <table class="t18" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t17" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t16" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">Hola Área de Talento Humano,</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">Tienes una nueva solicitud de ' . $_POST['tipo'] . '</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Nombre Colaborador</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $solicitudDAO->objetos[0]->nombre_completo . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Documento</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $solicitudDAO->objetos[0]->doc_id . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Sede</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $solicitudDAO->objetos[0]->nombre_sede . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Cargo</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $solicitudDAO->objetos[0]->nombre_cargo . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Fecha Inicial</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $solicitudDAO->objetos[0]->fecha_inicial . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Fecha Final</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $solicitudDAO->objetos[0]->fecha_final . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Cantidad días/horas</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $cantidad . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Observaciones</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $solicitudDAO->objetos[0]->observaciones . '</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>';
    $plantilla .= $footer;

    $mail->setFrom($smtp->objetos[0]->email, $smtp->objetos[0]->nombre);

    // correos administradores talento humano
    $administradores = new UsuarioDAO();
    $administradores->buscarUsersTalentoHumanoFull();
    foreach ($administradores->objetos as $objeto) {
        $mail->addAddress($objeto->email, $objeto->nombre_completo);
    }
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Nueva Solicitud de ' . $_POST['tipo'];
    $mail->Body    = $plantilla;
    $mail->send();
}

if (isset($_POST['funcion']) && $_POST['funcion'] == 'cambio_estado_solicitud') {
    $smtp = buscar_smtp();
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $smtp->objetos[0]->host;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $smtp->objetos[0]->email;                     //SMTP username
    $mail->Password   = $smtp->objetos[0]->pass_email;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = $smtp->objetos[0]->port;
    $mail->CharSet = 'UTF-8';
    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    $solicitudDAO = new solicitudDAO();
    $solicitud = new Solicitud();
    $solicitud->setId($_POST['id']);

    $solicitudDAO->cargar($solicitud);
    $estado = "";
    $estado2 = "";
    $urlNotificacion = "";
    $textoVacaciones = "";
    if ($solicitudDAO->objetos[0]->estado == 2) {
        $estado = "<p style='color: green;'><b>Aprobada</b></p>";
        $estado2 = "Aprobada";
        echo '<pre>';print_r($solicitudDAO->objetos[0]->tipo);
        
        if($solicitudDAO->objetos[0]->tipo=='Vacaciones'){
            $urlNotificacion .= $smtp->objetos[0]->url_back."/Vista/notificacionVacaciones.php?id=".$_POST['id'];
            
            $textoVacaciones .= '
                                                                <tr>
                                                                    <td class="t20" colspan="2" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Nota: </b>En el siguiente enlace debes descargar e imprimir el documento de notificación de vacaciones, firmarlo y entregarlo al Coordinador@ Administrativ@ y Contable</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" colspan="2" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t71" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:18px;font-weight:400;font-style:normal;font-size:12px;text-decoration:none;text-transform:none;direction:ltr;color:#000000;text-align:left;mso-line-height-rule:exactly;mso-text-raise:2px;"> • <a class="t69" href="'.$urlNotificacion.'" style="margin:0;Margin:0;font-weight:700;font-style:normal;text-decoration:none;direction:ltr;color:#000000;mso-line-height-rule:exactly;" target="_blank">Notificación Aviso de Vacaciones '.$solicitudDAO->objetos[0]->nombre_completo.' • </p>
                                                                    </td>
                                                                </tr>';
        }
    } else if ($solicitudDAO->objetos[0]->estado == 3) {
        $estado = "<p style='color: red;'><b>Rechazada</b></p>";
        $estado2 = "Rechazada";
    } else if ($solicitudDAO->objetos[0]->estado == 4) {
        $estado = "<p style='color: red;'><b>Anulada</b></p>";
        $estado2 = "Anulada";
    }
    $tipoCorreo = utf8_decode('Solicitud ' . $estado2);
    $consecutivoCorreo = $solicitudDAO->objetos[0]->id;
    $plantilla = "";
    $head = cargarHead();
    $footer = cargarFooter();
    $plantilla .= $head;
    $plantilla .= '
    <body id="body" class="t78" style="min-width:100%;Margin:0px;padding:0px;background-color:#F4F7F8;">
        <div class="t77" style="background-color:#F4F7F8;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                <tr>
                    <td class="t76" style="font-size:0;line-height:0;mso-line-height-rule:exactly;background-color:#F4F7F8;" valign="top" align="center">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center" id="innerTable">
                            <tr>
                                <td>
                                    <table class="t15" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t14" style="background-color:#f09f09;width:430px;padding:25px 25px 25px 25px;">
                                                <div class="t13" style="display:inline-table;width:100%;text-align:left;vertical-align:middle;">
                                                    <div class="t3" style="display:inline-table;text-align:initial;vertical-align:inherit;width:30%;max-width:165px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t2">
                                                            <tr>
                                                                <td class="t1">
                                                                    <div style="font-size:0px;"><img class="t0" style="display:block;border:0;height:auto;width:100%;Margin:0;max-width:100%;" width="165" height="57.875" alt="" src="' . $smtp->objetos[0]->url_back . 'Recursos/img/empresa/' . $smtp->objetos[0]->logo . '" /></div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="t12" style="display:inline-table;text-align:initial;vertical-align:inherit;width:70%;max-width:385px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t11">
                                                            <tr>
                                                                <td class="t10">
                                                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t6" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t5" style="width:185px;">
                                                                                            <p class="t4" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">' . $tipoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t9" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t8" style="width:185px;">
                                                                                            <p class="t7" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">No. ' . $consecutivoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="t38" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t37" style="width:430px;padding:25px 25px 25px 25px;">
                                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td>
                                                            <table class="t18" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t17" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t16" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">Hola, tu solicitud de ' .$solicitudDAO->objetos[0]->tipo. ' ha sido '.$estado2.'</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Nombre Colaborador</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $solicitudDAO->objetos[0]->nombre_completo . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Documento</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $solicitudDAO->objetos[0]->doc_id . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Sede</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $solicitudDAO->objetos[0]->nombre_sede . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Cargo</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $solicitudDAO->objetos[0]->nombre_cargo . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Fecha Inicial</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $solicitudDAO->objetos[0]->fecha_inicial . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Fecha Final</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $solicitudDAO->objetos[0]->fecha_final . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Cantidad días/horas</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . ($solicitudDAO->objetos[0]->cantidad<>null?$solicitudDAO->objetos[0]->cantidad:'N/A') . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Observaciones Colaborador</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $solicitudDAO->objetos[0]->observaciones . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Observaciones</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $solicitudDAO->objetos[0]->observaciones_aprobador . '</p>
                                                                    </td>
                                                                </tr>'
                                                                .$textoVacaciones.
                                                                '
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>';
    $plantilla .= $footer;

    $mail->setFrom($smtp->objetos[0]->email, $smtp->objetos[0]->nombre);

    $mail->addAddress($solicitudDAO->objetos[0]->email, $solicitudDAO->objetos[0]->nombre_completo);

    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Tu solicitud de ' . $solicitudDAO->objetos[0]->tipo . ' ha cambiado de estado ';
    $mail->Body    = $plantilla;
    $mail->send();
}

if (isset($_POST['funcion']) && $_POST['funcion'] == 'enviar_email_solicitud_actualizada') {
    $smtp = buscar_smtp();
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $smtp->objetos[0]->host;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $smtp->objetos[0]->email;                     //SMTP username
    $mail->Password   = $smtp->objetos[0]->pass_email;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = $smtp->objetos[0]->port;
    $mail->CharSet = 'UTF-8';
    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    $solicitudDAO = new solicitudDAO();
    $solicitud = new Solicitud();
    $solicitud->setId($_POST['id_solicitud']);

    $solicitudDAO->cargar($solicitud);
    $estado = "";
    $estado2 = "";
    if ($solicitudDAO->objetos[0]->estado == 2) {
        $estado = "<p style='color: green;'><b>Aprobada</b></p>";
        $estado2 = "Aprobada";
    } else if ($solicitudDAO->objetos[0]->estado == 3) {
        $estado = "<p style='color: red;'><b>Rechazada</b></p>";
        $estado2 = "Rechazada";
    } else if ($solicitudDAO->objetos[0]->estado == 4) {
        $estado = "<p style='color: red;'><b>Anulada</b></p>";
        $estado2 = "Anulada";
    }

    $tipoCorreo = utf8_decode('Solicitud Actualizada');
    $consecutivoCorreo = $solicitudDAO->objetos[0]->id;
    $plantilla = "";
    $head = cargarHead();
    $footer = cargarFooter();
    $plantilla .= $head;
    $plantilla .= '
    <body id="body" class="t78" style="min-width:100%;Margin:0px;padding:0px;background-color:#F4F7F8;">
        <div class="t77" style="background-color:#F4F7F8;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                <tr>
                    <td class="t76" style="font-size:0;line-height:0;mso-line-height-rule:exactly;background-color:#F4F7F8;" valign="top" align="center">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center" id="innerTable">
                            <tr>
                                <td>
                                    <table class="t15" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t14" style="background-color:#f09f09;width:430px;padding:25px 25px 25px 25px;">
                                                <div class="t13" style="display:inline-table;width:100%;text-align:left;vertical-align:middle;">
                                                    <div class="t3" style="display:inline-table;text-align:initial;vertical-align:inherit;width:30%;max-width:165px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t2">
                                                            <tr>
                                                                <td class="t1">
                                                                    <div style="font-size:0px;"><img class="t0" style="display:block;border:0;height:auto;width:100%;Margin:0;max-width:100%;" width="165" height="57.875" alt="" src="' . $smtp->objetos[0]->url_back . 'Recursos/img/empresa/' . $smtp->objetos[0]->logo . '" /></div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="t12" style="display:inline-table;text-align:initial;vertical-align:inherit;width:70%;max-width:385px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t11">
                                                            <tr>
                                                                <td class="t10">
                                                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t6" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t5" style="width:185px;">
                                                                                            <p class="t4" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">' . $tipoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t9" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t8" style="width:185px;">
                                                                                            <p class="t7" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">No. ' . $consecutivoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="t38" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t37" style="width:430px;padding:25px 25px 25px 25px;">
                                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td>
                                                            <table class="t18" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t17" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t16" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">Hola, tu solicitud ha sido actualizada</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Tipo Solicitud</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $solicitudDAO->objetos[0]->tipo . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Nombre Colaborador</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $solicitudDAO->objetos[0]->nombre_completo . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Documento</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $solicitudDAO->objetos[0]->doc_id . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Sede</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $solicitudDAO->objetos[0]->nombre_sede . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Cargo</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $solicitudDAO->objetos[0]->nombre_cargo . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Fecha Inicial</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $solicitudDAO->objetos[0]->fecha_inicial . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Fecha Final</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $solicitudDAO->objetos[0]->fecha_final . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Cantidad días/horas</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . ($solicitudDAO->objetos[0]->cantidad<>null?$solicitudDAO->objetos[0]->cantidad:'N/A') . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Observaciones Colaborador</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $solicitudDAO->objetos[0]->observaciones . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Observaciones</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $solicitudDAO->objetos[0]->observaciones_aprobador . '</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>';
    $plantilla .= $footer;

    $mail->setFrom($smtp->objetos[0]->email, $smtp->objetos[0]->nombre);

    $mail->addAddress($solicitudDAO->objetos[0]->email, $solicitudDAO->objetos[0]->nombre_completo);

    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Tu solicitud ha sido actualizada ';
    $mail->Body    = $plantilla;
    $mail->send();
}

//Incapacidades
if (isset($_POST['funcion']) && $_POST['funcion'] == 'enviar_email_incapacidad') {
    $smtp = buscar_smtp();
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $smtp->objetos[0]->host;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $smtp->objetos[0]->email;                     //SMTP username
    $mail->Password   = $smtp->objetos[0]->pass_email;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = $smtp->objetos[0]->port;
    $mail->CharSet = 'UTF-8';
    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    $incapacidadDAO = new incapacidadDAO();
    $incapacidad = new Incapacidad();
    $incapacidad->setIdUsuario($_POST['id_usuario']);
    $incapacidad->setTipo($_POST['tipo']);
    $incapacidad->setInicio($_POST['inicio']);
    $incapacidad->setFin($_POST['fin']);
    $incapacidad->setDuracion($_POST['duracion']);
    $incapacidad->setDescripcion($_POST['descripcion']);

    $incapacidadDAO->listarUltimoCreado($incapacidad);

    $tipoCorreo = utf8_decode('Incapacidad Nueva');
    $consecutivoCorreo = $incapacidadDAO->objetos[0]->id;
    $plantilla = "";
    $head = cargarHead();
    $footer = cargarFooter();
    $plantilla .= $head;
    $plantilla .= '
    <body id="body" class="t78" style="min-width:100%;Margin:0px;padding:0px;background-color:#F4F7F8;">
        <div class="t77" style="background-color:#F4F7F8;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                <tr>
                    <td class="t76" style="font-size:0;line-height:0;mso-line-height-rule:exactly;background-color:#F4F7F8;" valign="top" align="center">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center" id="innerTable">
                            <tr>
                                <td>
                                    <table class="t15" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t14" style="background-color:#f09f09;width:430px;padding:25px 25px 25px 25px;">
                                                <div class="t13" style="display:inline-table;width:100%;text-align:left;vertical-align:middle;">
                                                    <div class="t3" style="display:inline-table;text-align:initial;vertical-align:inherit;width:30%;max-width:165px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t2">
                                                            <tr>
                                                                <td class="t1">
                                                                    <div style="font-size:0px;"><img class="t0" style="display:block;border:0;height:auto;width:100%;Margin:0;max-width:100%;" width="165" height="57.875" alt="" src="' . $smtp->objetos[0]->url_back . 'Recursos/img/empresa/' . $smtp->objetos[0]->logo . '" /></div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="t12" style="display:inline-table;text-align:initial;vertical-align:inherit;width:70%;max-width:385px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t11">
                                                            <tr>
                                                                <td class="t10">
                                                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t6" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t5" style="width:185px;">
                                                                                            <p class="t4" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">' . $tipoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t9" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t8" style="width:185px;">
                                                                                            <p class="t7" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">No. ' . $consecutivoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="t38" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t37" style="width:430px;padding:25px 25px 25px 25px;">
                                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td>
                                                            <table class="t18" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t17" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t16" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">Hola ' . $incapacidadDAO->objetos[0]->nombre_completo . ',</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">Tienes una incapacidad registrada</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;" colspan="2">
                                                                        <h5><b>Información de la incapacidad</b></h5>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Nombre Colaborador</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $incapacidadDAO->objetos[0]->nombre_completo . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Documento</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $incapacidadDAO->objetos[0]->doc_id . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Sede</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $incapacidadDAO->objetos[0]->nombre_sede . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Cargo</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $incapacidadDAO->objetos[0]->nombre_cargo . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Fecha Inicial</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $incapacidadDAO->objetos[0]->inicio . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Fecha Final</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $incapacidadDAO->objetos[0]->fin . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Cantidad días</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $incapacidadDAO->objetos[0]->duracion . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Descripción</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $incapacidadDAO->objetos[0]->descripcion . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Diagnóstico</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $incapacidadDAO->objetos[0]->diagnostico . '</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>';
    $plantilla .= $footer;

    $mail->setFrom($smtp->objetos[0]->email, $smtp->objetos[0]->nombre);
    $mail->addAddress($incapacidadDAO->objetos[0]->email, $incapacidadDAO->objetos[0]->nombre_completo);
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Incapacidad Registrada';
    $mail->Body    = $plantilla;
    $mail->send();
}

function cargarHead()
{
    $head = '
    
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office" lang="en">

    <head>
        <title></title>
        <meta charset="UTF-8" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <!--[if !mso]>-->
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!--<![endif]-->
        <meta name="x-apple-disable-message-reformatting" content="" />
        <meta content="target-densitydpi=device-dpi" name="viewport" />
        <meta content="true" name="HandheldFriendly" />
        <meta content="width=device-width" name="viewport" />
        <meta name="format-detection" content="telephone=no, date=no, address=no, email=no, url=no" />
        <style type="text/css">
            table {
                border-collapse: separate;
                table-layout: fixed;
                mso-table-lspace: 0pt;
                mso-table-rspace: 0pt
            }

            table td {
                border-collapse: collapse
            }

            .ExternalClass {
                width: 100%
            }

            .ExternalClass,
            .ExternalClass p,
            .ExternalClass span,
            .ExternalClass font,
            .ExternalClass td,
            .ExternalClass div {
                line-height: 100%
            }

            body,
            a,
            li,
            p,
            h1,
            h2,
            h3 {
                -ms-text-size-adjust: 100%;
                -webkit-text-size-adjust: 100%;
            }

            html {
                -webkit-text-size-adjust: none !important
            }

            body,
            #innerTable {
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale
            }

            #innerTable img+div {
                display: none;
                display: none !important
            }

            img {
                Margin: 0;
                padding: 0;
                -ms-interpolation-mode: bicubic
            }

            h1,
            h2,
            h3,
            p,
            a {
                line-height: inherit;
                overflow-wrap: normal;
                white-space: normal;
                word-break: break-word
            }

            a {
                text-decoration: none
            }

            h1,
            h2,
            h3,
            p {
                min-width: 100% !important;
                width: 100% !important;
                max-width: 100% !important;
                display: inline-block !important;
                border: 0;
                padding: 0;
                margin: 0
            }

            a[x-apple-data-detectors] {
                color: inherit !important;
                text-decoration: none !important;
                font-size: inherit !important;
                font-family: inherit !important;
                font-weight: inherit !important;
                line-height: inherit !important
            }

            u+#body a {
                color: inherit;
                text-decoration: none;
                font-size: inherit;
                font-family: inherit;
                font-weight: inherit;
                line-height: inherit;
            }

            a[href^="mailto"],
            a[href^="tel"],
            a[href^="sms"] {
                color: inherit;
                text-decoration: none
            }

            img,
            p {
                margin: 0;
                Margin: 0;
                font-family: Albert Sans, BlinkMacSystemFont, Segoe UI, Helvetica Neue, Arial, sans-serif;
                line-height: 24px;
                font-weight: 400;
                font-style: normal;
                font-size: 14px;
                text-decoration: none;
                text-transform: none;
                letter-spacing: 0;
                direction: ltr;
                color: #09234f;
                text-align: left;
                mso-line-height-rule: exactly;
                mso-text-raise: 3px
            }

            h1 {
                margin: 0;
                Margin: 0;
                font-family: Roboto, BlinkMacSystemFont, Segoe UI, Helvetica Neue, Arial, sans-serif;
                line-height: 34px;
                font-weight: 400;
                font-style: normal;
                font-size: 28px;
                text-decoration: none;
                text-transform: none;
                letter-spacing: 0;
                direction: ltr;
                color: #333;
                text-align: left;
                mso-line-height-rule: exactly;
                mso-text-raise: 2px
            }

            h2 {
                margin: 0;
                Margin: 0;
                font-family: Lato, BlinkMacSystemFont, Segoe UI, Helvetica Neue, Arial, sans-serif;
                line-height: 30px;
                font-weight: 400;
                font-style: normal;
                font-size: 24px;
                text-decoration: none;
                text-transform: none;
                letter-spacing: 0;
                direction: ltr;
                color: #333;
                text-align: left;
                mso-line-height-rule: exactly;
                mso-text-raise: 2px
            }

            h3 {
                margin: 0;
                Margin: 0;
                font-family: Lato, BlinkMacSystemFont, Segoe UI, Helvetica Neue, Arial, sans-serif;
                line-height: 26px;
                font-weight: 400;
                font-style: normal;
                font-size: 20px;
                text-decoration: none;
                text-transform: none;
                letter-spacing: 0;
                direction: ltr;
                color: #333;
                text-align: left;
                mso-line-height-rule: exactly;
                mso-text-raise: 2px
            }
        </style>
        <style type="text/css">
            @media (min-width: 481px) {
                .hd {
                    display: none !important
                }
            }
        </style>
        <style type="text/css">
            @media (max-width: 480px) {
                .hm {
                    display: none !important
                }
            }
        </style>
        <style type="text/css">
            @media (min-width: 481px) {

                h1,
                img,
                p {
                    margin: 0;
                    Margin: 0
                }

                h3,
                img,
                p {
                    line-height: 26px
                }

                .t34,
                .t4,
                .t7 {
                    line-height: 26px !important
                }

                img,
                p {
                    font-family: Albert Sans, BlinkMacSystemFont, Segoe UI, Helvetica Neue, Arial, sans-serif;
                    font-weight: 400;
                    font-style: normal;
                    font-size: 16px;
                    text-decoration: none;
                    text-transform: none;
                    letter-spacing: 0;
                    direction: ltr;
                    color: #09234f;
                    text-align: left;
                    mso-line-height-rule: exactly;
                    mso-text-raise: 3px
                }

                h1 {
                    font-family: Roboto, BlinkMacSystemFont, Segoe UI, Helvetica Neue, Arial, sans-serif;
                    line-height: 34px;
                    font-weight: 400;
                    font-style: normal;
                    font-size: 28px;
                    text-decoration: none;
                    text-transform: none;
                    letter-spacing: 0;
                    direction: ltr;
                    color: #333;
                    text-align: left;
                    mso-line-height-rule: exactly;
                    mso-text-raise: 2px
                }

                h2,
                h3 {
                    margin: 0;
                    Margin: 0;
                    font-family: Lato, BlinkMacSystemFont, Segoe UI, Helvetica Neue, Arial, sans-serif;
                    font-weight: 400;
                    font-style: normal;
                    text-decoration: none;
                    text-transform: none;
                    letter-spacing: 0;
                    direction: ltr;
                    color: #333;
                    text-align: left;
                    mso-line-height-rule: exactly;
                    mso-text-raise: 2px
                }

                h2 {
                    line-height: 30px;
                    font-size: 24px
                }

                h3 {
                    font-size: 20px
                }

                .t14,
                .t37,
                .t74 {
                    width: 550px !important
                }

                .t4,
                .t7 {
                    font-size: 18px !important
                }

                .t17,
                .t20,
                .t23,
                .t26,
                .t29,
                .t32,
                .t35 {
                    width: 600px !important
                }

                .t16,
                .t19,
                .t22,
                .t25,
                .t28,
                .t31 {
                    line-height: 26px !important;
                    font-size: 16px !important
                }

                .t60 {
                    width: 800px !important
                }
            }
        </style>
        <style type="text/css" media="screen and (min-width:481px)">
            .moz-text-html img,
            .moz-text-html p {
                margin: 0;
                Margin: 0;
                font-family: Albert Sans, BlinkMacSystemFont, Segoe UI, Helvetica Neue, Arial, sans-serif;
                line-height: 26px;
                font-weight: 400;
                font-style: normal;
                font-size: 16px;
                text-decoration: none;
                text-transform: none;
                letter-spacing: 0;
                direction: ltr;
                color: #09234f;
                text-align: left;
                mso-line-height-rule: exactly;
                mso-text-raise: 3px
            }

            .moz-text-html h1 {
                margin: 0;
                Margin: 0;
                font-family: Roboto, BlinkMacSystemFont, Segoe UI, Helvetica Neue, Arial, sans-serif;
                line-height: 34px;
                font-weight: 400;
                font-style: normal;
                font-size: 28px;
                text-decoration: none;
                text-transform: none;
                letter-spacing: 0;
                direction: ltr;
                color: #333;
                text-align: left;
                mso-line-height-rule: exactly;
                mso-text-raise: 2px
            }

            .moz-text-html h2 {
                margin: 0;
                Margin: 0;
                font-family: Lato, BlinkMacSystemFont, Segoe UI, Helvetica Neue, Arial, sans-serif;
                line-height: 30px;
                font-weight: 400;
                font-style: normal;
                font-size: 24px;
                text-decoration: none;
                text-transform: none;
                letter-spacing: 0;
                direction: ltr;
                color: #333;
                text-align: left;
                mso-line-height-rule: exactly;
                mso-text-raise: 2px
            }

            .moz-text-html h3 {
                margin: 0;
                Margin: 0;
                font-family: Lato, BlinkMacSystemFont, Segoe UI, Helvetica Neue, Arial, sans-serif;
                line-height: 26px;
                font-weight: 400;
                font-style: normal;
                font-size: 20px;
                text-decoration: none;
                text-transform: none;
                letter-spacing: 0;
                direction: ltr;
                color: #333;
                text-align: left;
                mso-line-height-rule: exactly;
                mso-text-raise: 2px
            }

            .moz-text-html .t14 {
                width: 550px !important
            }

            .moz-text-html .t4,
            .moz-text-html .t7 {
                line-height: 26px !important;
                font-size: 18px !important
            }

            .moz-text-html .t37 {
                width: 550px !important
            }

            .moz-text-html .t35 {
                width: 600px !important
            }

            .moz-text-html .t34 {
                line-height: 26px !important
            }

            .moz-text-html .t17 {
                width: 600px !important
            }

            .moz-text-html .t16 {
                line-height: 26px !important;
                font-size: 16px !important
            }

            .moz-text-html .t20 {
                width: 600px !important
            }

            .moz-text-html .t19 {
                line-height: 26px !important;
                font-size: 16px !important
            }

            .moz-text-html .t23 {
                width: 600px !important
            }

            .moz-text-html .t22 {
                line-height: 26px !important;
                font-size: 16px !important
            }

            .moz-text-html .t26 {
                width: 600px !important
            }

            .moz-text-html .t25 {
                line-height: 26px !important;
                font-size: 16px !important
            }

            .moz-text-html .t29 {
                width: 600px !important
            }

            .moz-text-html .t28 {
                line-height: 26px !important;
                font-size: 16px !important
            }

            .moz-text-html .t32 {
                width: 600px !important
            }

            .moz-text-html .t31 {
                line-height: 26px !important;
                font-size: 16px !important
            }

            .moz-text-html .t74 {
                width: 550px !important
            }

            .moz-text-html .t60 {
                width: 800px !important
            }
        </style>
        <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@400;500;600;700&amp;display=swap" rel="stylesheet" type="text/css" />

    </head>';
    return $head;
}

function cargarFooter()
{
    $smtp = buscar_smtp();
    $sedes = new sedeDAO();
    $sedes->listar();
    $infSedes = '';
    foreach ($sedes->objetos as $objeto) {
        $infSedes .= '<tr>
                            <td>
                                <table class="t67" role="presentation" cellpadding="0" cellspacing="0" align="left">
                                    <tr style="text-align: center !important">
                                        <td class="t66" style="width:280px;padding:0 0 12px 0;">
                                            <p class="t65" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:18px;font-weight:400;font-style:normal;font-size:12px;text-decoration:none;text-transform:none;direction:ltr;color:#FFFFFF;text-align:left;mso-line-height-rule:exactly;mso-text-raise:2px;">' . $objeto->direccion . '-' . $objeto->telefono . '-' . $objeto->municipio . ' (' . $objeto->departamento . ')</p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>';
    }
    $footer = '
    <footer>
    <div></div>
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center" id="innerTable">
        <tr>
            <td>
                <table class="t75" role="presentation" cellpadding="0" cellspacing="0" align="center">
                    <tr>
                        <td class="t74" style="background-color:#F09F09;width:430px;padding:25px 25px 25px 25px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">                                
                                <tr>
                                    <td>
                                        <table class="t64" role="presentation" cellpadding="0" cellspacing="0" align="left">
                                            <tr style="text-align: center !important">
                                                <td class="t63" style="width:280px;">
                                                    <p class="t62" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:18px;font-weight:400;font-style:normal;font-size:12px;text-decoration:none;text-transform:none;direction:ltr;color:#FFFFFF;text-align:left;mso-line-height-rule:exactly;mso-text-raise:2px;">' . $smtp->objetos[0]->nombre . '. All rights reserved</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                ' . $infSedes . '
                                <tr>
                                    <td>
                                        <table class="t67" role="presentation" cellpadding="0" cellspacing="0" align="left">
                                            <tr style="text-align: center !important">
                                                <td class="t66" style="width:280px;padding:0 0 12px 0;">
                                                    <p class="t65" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:18px;font-weight:400;font-style:normal;font-size:12px;text-decoration:none;text-transform:none;direction:ltr;color:#FFFFFF;text-align:left;mso-line-height-rule:exactly;mso-text-raise:2px;">Colombia</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table class="t73" role="presentation" cellpadding="0" cellspacing="0" align="left">
                                            <tr style="text-align: center !important">
                                                <td class="t72" style="width:280px;">
                                                    <p class="t71" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:18px;font-weight:400;font-style:normal;font-size:12px;text-decoration:none;text-transform:none;direction:ltr;color:#FFFFFF;text-align:left;mso-line-height-rule:exactly;mso-text-raise:2px;"> • <a class="t69" href="https://quindipisos.com/content/7-politica-de-seguridad-quindipisos" style="margin:0;Margin:0;font-weight:700;font-style:normal;text-decoration:none;direction:ltr;color:#E6E6E6;mso-line-height-rule:exactly;" target="_blank">Política de Seguridad</a> • </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</footer>

</html>';
    return $footer;
}

function enviarCorreoGeneral($tipoCorreo, $consecutivoCorreo, $to, $body, $destinatarios)
{
    $smtp = buscar_smtp();
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $smtp->objetos[0]->host;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $smtp->objetos[0]->email;                     //SMTP username
    $mail->Password   = $smtp->objetos[0]->pass_email;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = $smtp->objetos[0]->port;
    $mail->CharSet = 'UTF-8';
    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    $plantilla = "";
    $head = cargarHead();
    $footer = cargarFooter();
    $plantilla .= $head;
    $plantilla .= '
    <body id="body" class="t78" style="min-width:100%;Margin:0px;padding:0px;background-color:#F4F7F8;">
        <div class="t77" style="background-color:#F4F7F8;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                <tr>
                    <td class="t76" style="font-size:0;line-height:0;mso-line-height-rule:exactly;background-color:#F4F7F8;" valign="top" align="center">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center" id="innerTable">
                            <tr>
                                <td>
                                    <table class="t15" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t14" style="background-color:#f09f09;width:430px;padding:25px 25px 25px 25px;">
                                                <div class="t13" style="display:inline-table;width:100%;text-align:left;vertical-align:middle;">
                                                    <div class="t3" style="display:inline-table;text-align:initial;vertical-align:inherit;width:30%;max-width:165px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t2">
                                                            <tr>
                                                                <td class="t1">
                                                                    <div style="font-size:0px;"><img class="t0" style="display:block;border:0;height:auto;width:100%;Margin:0;max-width:100%;" width="165" height="57.875" alt="" src="' . $smtp->objetos[0]->url_back . 'Recursos/img/empresa/' . $smtp->objetos[0]->logo . '" /></div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="t12" style="display:inline-table;text-align:initial;vertical-align:inherit;width:70%;max-width:385px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t11">
                                                            <tr>
                                                                <td class="t10">
                                                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t6" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t5" style="width:185px;">
                                                                                            <p class="t4" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">' . $tipoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t9" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t8" style="width:185px;">
                                                                                            <p class="t7" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">No.  ' . $consecutivoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="t38" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t37" style="width:430px;padding:25px 25px 25px 25px;">
                                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td>
                                                            <table class="t18" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t17" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t16" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">Hola ' . $to . ',</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"> ' . $body . '</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>                                                    
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>';
    $plantilla .= $footer;

    $mail->setFrom($smtp->objetos[0]->email, $smtp->objetos[0]->nombre);

    // correos administradores talento humano
    $emails = explode(',', $destinatarios);

    foreach ($emails as $email) {
        $mail->addAddress(trim($email));
    }

    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = utf8_decode($tipoCorreo . "- No." . $consecutivoCorreo);
    $mail->Body    = $plantilla;
    try {
        $mail->send();
        echo '<pre>';
        print_r("envio exitoso " . $destinatarios);
        echo '</pre>';
    } catch (Exception $e) {
        echo '<pre>';
        print_r("No fue posible enviar el correo a, se presentó la siguiente excepción \n" . $e);
        echo '</pre>';
    }
}

function notificarTarea($idTarea, $accion)
{
    $fecha = date('Y-m-d', time());
    $smtp = buscar_smtp();
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $smtp->objetos[0]->host;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $smtp->objetos[0]->email;                     //SMTP username
    $mail->Password   = $smtp->objetos[0]->pass_email;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = $smtp->objetos[0]->port;
    $logo = $smtp->objetos[0]->url_back . 'Recursos/img/' . $smtp->objetos[0]->logo;

    $tareaDAO = new tareaDAO();
    $tarea = new Tarea();
    $responsables = new ResponsableTarea();
    $tarea->setId($idTarea);
    $tareaDAO->cargar($tarea);
    $tarea->setNombre($tareaDAO->objetos[0]->nombre_tarea);
    $tarea->setDescripcion($tareaDAO->objetos[0]->descripcion);
    $tarea->setObservaciones($tareaDAO->objetos[0]->observaciones);
    $tarea->setTipoTarea($tareaDAO->objetos[0]->tipo_tarea);
    $tarea->setFechaInicio($tareaDAO->objetos[0]->fecha_inicio);
    $tarea->setFechaFin($tareaDAO->objetos[0]->fecha_fin);

    $responsables->setIdTarea($idTarea);
    $tareaDAO->listar_responsables_tareas($responsables);

    $titulo = "";
    if ($accion == "crear") {
        $titulo = "Hay una tarea nueva en la que estas cómo responsable";
    }
    if ($accion == "editar") {
        $titulo = "Hay cambios en una tarea en la que eres responsable";
    }
    if ($accion == "recordar") {
        $titulo = "Tienes una tarea a punto de vencer";
    }
    
    
    $plantilla = "";
    $head = cargarHead();
    $footer = cargarFooter();
    $plantilla .= $head;
    $plantilla .= '
    <body id="body" class="t78" style="min-width:100%;Margin:0px;padding:0px;background-color:#F4F7F8;">
        <div class="t77" style="background-color:#F4F7F8;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                <tr>
                    <td class="t76" style="font-size:0;line-height:0;mso-line-height-rule:exactly;background-color:#F4F7F8;" valign="top" align="center">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center" id="innerTable">
                            <tr>
                                <td>
                                    <table class="t15" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t14" style="background-color:#f09f09;width:430px;padding:25px 25px 25px 25px;">
                                                <div class="t13" style="display:inline-table;width:100%;text-align:left;vertical-align:middle;">
                                                    <div class="t3" style="display:inline-table;text-align:initial;vertical-align:inherit;width:30%;max-width:165px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t2">
                                                            <tr>
                                                                <td class="t1">
                                                                    <div style="font-size:0px;"><img class="t0" style="display:block;border:0;height:auto;width:100%;Margin:0;max-width:100%;" width="165" height="57.875" alt="" src="' . $smtp->objetos[0]->url_back . 'Recursos/img/empresa/' . $smtp->objetos[0]->logo . '" /></div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="t12" style="display:inline-table;text-align:initial;vertical-align:inherit;width:70%;max-width:385px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t11">
                                                            <tr>
                                                                <td class="t10">
                                                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t6" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t5" style="width:185px;">
                                                                                            <p class="t4" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">Notificación Agenda</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t9" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t8" style="width:185px;">
                                                                                            <p class="t7" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">No. ' . $tarea->getId() . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="t38" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t37" style="width:430px;padding:25px 25px 25px 25px;">
                                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td>
                                                            <table class="t18" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t17" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t16" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">Hola ' . $titulo . '</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Nombre:</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">'.$tarea->getNombre().'</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>                                                    
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Tipo de Tarea:</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">'.$tarea->getTipoTarea().'</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>                                                    
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Fecha y Hora Inicial:</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">'.$tarea->getFechaInicio().'</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>                                                    
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Fecha y Hora Final:</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">'.$tarea->getFechaFin().'</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>                                                    
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Descripción:</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">'.$tarea->getDescripcion().'</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>                                                    
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Observaciones:</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">'.$tarea->getObservaciones().'</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>                                                    
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>';
    $plantilla .= $footer;


    $mail->setFrom($smtp->objetos[0]->email);
    foreach ($tareaDAO->objetos as $objeto) {
        $mail->addAddress($objeto->email);
    }
    //Add a recipient    
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Tienes una ' . utf8_decode($tarea->getTipoTarea()) . " en " . $smtp->objetos[0]->nombre;
    $mail->Body    = $plantilla;
    $mail->send();
}

//Compensacion horas solicitadas
if (isset($_POST['funcion']) && $_POST['funcion'] == 'solicitud_compensacion_horas') {
    $smtp = buscar_smtp();
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $smtp->objetos[0]->host;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $smtp->objetos[0]->email;                     //SMTP username
    $mail->Password   = $smtp->objetos[0]->pass_email;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = $smtp->objetos[0]->port;
    $mail->CharSet = 'UTF-8';
    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    $daoCompensacion = new compensacionHorasDAO();
    $compensacion = new CompensacionHoras();
    $compensacion->setId($_POST['id']);
    $daoCompensacion->cargar($compensacion);

    $tipoCorreo = utf8_decode('Solicitud Compensación Horas Laborales');
    $consecutivoCorreo = $daoCompensacion->objetos[0]->id;
    $plantilla = "";
    $head = cargarHead();
    $footer = cargarFooter();
    $plantilla .= $head;
    $plantilla .= '
    <body id="body" class="t78" style="min-width:100%;Margin:0px;padding:0px;background-color:#F4F7F8;">
        <div class="t77" style="background-color:#F4F7F8;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                <tr>
                    <td class="t76" style="font-size:0;line-height:0;mso-line-height-rule:exactly;background-color:#F4F7F8;" valign="top" align="center">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center" id="innerTable">
                            <tr>
                                <td>
                                    <table class="t15" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t14" style="background-color:#f09f09;width:430px;padding:25px 25px 25px 25px;">
                                                <div class="t13" style="display:inline-table;width:100%;text-align:left;vertical-align:middle;">
                                                    <div class="t3" style="display:inline-table;text-align:initial;vertical-align:inherit;width:30%;max-width:165px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t2">
                                                            <tr>
                                                                <td class="t1">
                                                                    <div style="font-size:0px;"><img class="t0" style="display:block;border:0;height:auto;width:100%;Margin:0;max-width:100%;" width="165" height="57.875" alt="" src="' . $smtp->objetos[0]->url_back . 'Recursos/img/empresa/' . $smtp->objetos[0]->logo . '" /></div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="t12" style="display:inline-table;text-align:initial;vertical-align:inherit;width:70%;max-width:385px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t11">
                                                            <tr>
                                                                <td class="t10">
                                                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t6" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t5" style="width:185px;">
                                                                                            <p class="t4" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">' . $tipoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t9" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t8" style="width:185px;">
                                                                                            <p class="t7" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">No. ' . $consecutivoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="t38" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t37" style="width:430px;padding:25px 25px 25px 25px;">
                                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td>
                                                            <table class="t18" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t17" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t16" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">Área de talento humano,</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">Se registró una nueva solicitud de compensación de horas laborales</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;" colspan="2">
                                                                        <h5><b>Información de la incapacidad</b></h5>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Nombre Colaborador</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $daoCompensacion->objetos[0]->nombre_colaborador . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Documento</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $daoCompensacion->objetos[0]->doc_id . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Sede</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $daoCompensacion->objetos[0]->nombre_sede . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Cargo</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $daoCompensacion->objetos[0]->nombre_cargo . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Fecha horas laboradas</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $daoCompensacion->objetos[0]->fecha_laboradas . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Horas Solicitadas</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $daoCompensacion->objetos[0]->horas_solicitadas . '</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>';
    $plantilla .= $footer;
    $mail->setFrom($smtp->objetos[0]->email, $smtp->objetos[0]->nombre);
    $administradores = new UsuarioDAO();
    $administradores->buscarUsersTalentoHumanoFull();
    foreach ($administradores->objetos as $objeto) {
        $mail->addAddress($objeto->email, $objeto->nombre_completo);
    }
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Solicitud compensacion horas laborales registrada';
    $mail->Body    = $plantilla;
    $mail->send();
}

//Cambio estado compensacion horas
if (isset($_POST['funcion']) && $_POST['funcion'] == 'enviar_email_cambio_estado_comp_horas') {
    $smtp = buscar_smtp();
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $smtp->objetos[0]->host;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $smtp->objetos[0]->email;                     //SMTP username
    $mail->Password   = $smtp->objetos[0]->pass_email;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = $smtp->objetos[0]->port;
    $mail->CharSet = 'UTF-8';
    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    $daoCompensacion = new compensacionHorasDAO();
    $compensacion = new CompensacionHoras();
    $compensacion->setId($_POST['id']);
    $daoCompensacion->cargar($compensacion);
    

    $tipoCorreo = utf8_decode('Compensación de horas '.$_POST['estado']);
    $consecutivoCorreo = $daoCompensacion->objetos[0]->id;
    $plantilla = "";
    $head = cargarHead();
    $footer = cargarFooter();
    $plantilla .= $head;
    $plantilla .= '
    <body id="body" class="t78" style="min-width:100%;Margin:0px;padding:0px;background-color:#F4F7F8;">
        <div class="t77" style="background-color:#F4F7F8;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                <tr>
                    <td class="t76" style="font-size:0;line-height:0;mso-line-height-rule:exactly;background-color:#F4F7F8;" valign="top" align="center">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center" id="innerTable">
                            <tr>
                                <td>
                                    <table class="t15" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t14" style="background-color:#f09f09;width:430px;padding:25px 25px 25px 25px;">
                                                <div class="t13" style="display:inline-table;width:100%;text-align:left;vertical-align:middle;">
                                                    <div class="t3" style="display:inline-table;text-align:initial;vertical-align:inherit;width:30%;max-width:165px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t2">
                                                            <tr>
                                                                <td class="t1">
                                                                    <div style="font-size:0px;"><img class="t0" style="display:block;border:0;height:auto;width:100%;Margin:0;max-width:100%;" width="165" height="57.875" alt="" src="' . $smtp->objetos[0]->url_back . 'Recursos/img/empresa/' . $smtp->objetos[0]->logo . '" /></div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="t12" style="display:inline-table;text-align:initial;vertical-align:inherit;width:70%;max-width:385px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t11">
                                                            <tr>
                                                                <td class="t10">
                                                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t6" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t5" style="width:185px;">
                                                                                            <p class="t4" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">' . $tipoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t9" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t8" style="width:185px;">
                                                                                            <p class="t7" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">No. ' . $consecutivoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="t38" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t37" style="width:430px;padding:25px 25px 25px 25px;">
                                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td>
                                                            <table class="t18" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t17" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t16" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">Hola ' . $daoCompensacion->objetos[0]->nombre_colaborador . ',</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">El estado de tu solicitud de compensación de horas laborales ha cambiado a '.$_POST['estado'].'</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;" colspan="2">
                                                                        <h5><b>Información de la incapacidad</b></h5>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Nombre Colaborador</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $daoCompensacion->objetos[0]->nombre_colaborador . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Documento</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $daoCompensacion->objetos[0]->doc_id . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Sede</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $daoCompensacion->objetos[0]->nombre_sede . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Cargo</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $daoCompensacion->objetos[0]->nombre_cargo . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Fecha Horas Laboradas</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $daoCompensacion->objetos[0]->fecha_laboradas . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Horas Solicitadas</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $daoCompensacion->objetos[0]->horas_solicitadas . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Nota:</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">Para ver a detalle la solicitud ingresa al sistema en la sección AUTOGESTIÓN</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>';
    $plantilla .= $footer;

    $mail->setFrom($smtp->objetos[0]->email, $smtp->objetos[0]->nombre);
    $mail->addAddress($daoCompensacion->objetos[0]->email, $daoCompensacion->objetos[0]->nombre_colaborador);
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Compensacion Horas Laborales '.$_POST['estado'];
    $mail->Body    = $plantilla;
    $mail->send();
}

// procesos de selección
if (isset($_POST['funcion']) && $_POST['funcion'] == 'postulacionNueva') {
    $smtp = buscar_smtp();
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $smtp->objetos[0]->host;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $smtp->objetos[0]->email;                     //SMTP username
    $mail->Password   = $smtp->objetos[0]->pass_email;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = $smtp->objetos[0]->port;
    $mail->CharSet = 'UTF-8';
    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    $postuladoDAO = new postuladoDAO();
    $postulado = new Postulado();
    $postulado->setId($_POST['id_postulacion']);
    $postuladoDAO->cargar($postulado);
    $postulado->setIdVacante($postuladoDAO->objetos[0]->id_vacante);
    $postulado->setEstado($postuladoDAO->objetos[0]->estado);
    $postulado->setNombrePostulado($postuladoDAO->objetos[0]->nombre_postulado);
    $postulado->setEmail($postuladoDAO->objetos[0]->email);
    $postulado->setTelefono($postuladoDAO->objetos[0]->telefono);
    $nombre_vacante = $postuladoDAO->objetos[0]->nombre_vacante;

    $tipoCorreo = utf8_decode('Nueva postulacion para ' . $nombre_vacante);
    $consecutivoCorreo = $postuladoDAO->objetos[0]->id;
    $plantilla = "";
    $head = cargarHead();
    $footer = cargarFooter();
    $plantilla .= $head;
    $plantilla .= '
    <body id="body" class="t78" style="min-width:100%;Margin:0px;padding:0px;background-color:#F4F7F8;">
        <div class="t77" style="background-color:#F4F7F8;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                <tr>
                    <td class="t76" style="font-size:0;line-height:0;mso-line-height-rule:exactly;background-color:#F4F7F8;" valign="top" align="center">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center" id="innerTable">
                            <tr>
                                <td>
                                    <table class="t15" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t14" style="background-color:#f09f09;width:430px;padding:25px 25px 25px 25px;">
                                                <div class="t13" style="display:inline-table;width:100%;text-align:left;vertical-align:middle;">
                                                    <div class="t3" style="display:inline-table;text-align:initial;vertical-align:inherit;width:30%;max-width:165px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t2">
                                                            <tr>
                                                                <td class="t1">
                                                                    <div style="font-size:0px;"><img class="t0" style="display:block;border:0;height:auto;width:100%;Margin:0;max-width:100%;" width="165" height="57.875" alt="" src="' . $smtp->objetos[0]->url_back . 'Recursos/img/empresa/' . $smtp->objetos[0]->logo . '" /></div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="t12" style="display:inline-table;text-align:initial;vertical-align:inherit;width:70%;max-width:385px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t11">
                                                            <tr>
                                                                <td class="t10">
                                                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t6" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t5" style="width:185px;">
                                                                                            <p class="t4" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">' . $tipoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t9" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t8" style="width:185px;">
                                                                                            <p class="t7" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">No. ' . $consecutivoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="t38" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t37" style="width:430px;padding:25px 25px 25px 25px;">
                                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td>
                                                            <table class="t18" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t17" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t16" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">Hola Área de Talento Humano,</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">Tienes una nueva postulación para ' . $nombre_vacante . '</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Nombre Postulado</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $postulado->getNombrePostulado() . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Email</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $postulado->getEmail() . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Teléfono</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $postulado->getTelefono(). '</p>
                                                                    </td>
                                                                </tr>                                                                
                                                            </table>
                                                        </td>
                                                    </tr>                                                    
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>';
    $plantilla .= $footer;

    $mail->setFrom($smtp->objetos[0]->email, $smtp->objetos[0]->nombre);

    // correos administradores talento humano
    $administradores = new UsuarioDAO();
    $administradores->buscarUsersTalentoHumanoFull();
    foreach ($administradores->objetos as $objeto) {
        $mail->addAddress($objeto->email, $objeto->nombre_completo);
    }
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Nueva Postulación para ' . $nombre_vacante;
    $mail->Body    = $plantilla;
    $mail->send();
}

if (isset($_POST['funcion']) && $_POST['funcion'] == 'postulacionNuevaPostulado') {
    $smtp = buscar_smtp();
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $smtp->objetos[0]->host;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $smtp->objetos[0]->email;                     //SMTP username
    $mail->Password   = $smtp->objetos[0]->pass_email;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = $smtp->objetos[0]->port;
    $mail->CharSet = 'UTF-8';
    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    $postuladoDAO = new postuladoDAO();
    $postulado = new Postulado();
    $postulado->setId($_POST['id_postulacion']);
    $postuladoDAO->cargar($postulado);
    $postulado->setIdVacante($postuladoDAO->objetos[0]->id_vacante);
    $postulado->setEstado($postuladoDAO->objetos[0]->estado);
    $postulado->setNombrePostulado($postuladoDAO->objetos[0]->nombre_postulado);
    $postulado->setEmail($postuladoDAO->objetos[0]->email);
    $postulado->setTelefono($postuladoDAO->objetos[0]->telefono);
    $nombre_vacante = $postuladoDAO->objetos[0]->nombre_vacante;

    $tipoCorreo = utf8_decode('Recibimos tu postulacion para ' . $nombre_vacante);
    $consecutivoCorreo = $postuladoDAO->objetos[0]->id;
    $plantilla = "";
    $head = cargarHead();
    $footer = cargarFooter();
    $plantilla .= $head;
    $plantilla .= '
    <body id="body" class="t78" style="min-width:100%;Margin:0px;padding:0px;background-color:#F4F7F8;">
        <div class="t77" style="background-color:#F4F7F8;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                <tr>
                    <td class="t76" style="font-size:0;line-height:0;mso-line-height-rule:exactly;background-color:#F4F7F8;" valign="top" align="center">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center" id="innerTable">
                            <tr>
                                <td>
                                    <table class="t15" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t14" style="background-color:#f09f09;width:430px;padding:25px 25px 25px 25px;">
                                                <div class="t13" style="display:inline-table;width:100%;text-align:left;vertical-align:middle;">
                                                    <div class="t3" style="display:inline-table;text-align:initial;vertical-align:inherit;width:30%;max-width:165px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t2">
                                                            <tr>
                                                                <td class="t1">
                                                                    <div style="font-size:0px;"><img class="t0" style="display:block;border:0;height:auto;width:100%;Margin:0;max-width:100%;" width="165" height="57.875" alt="" src="' . $smtp->objetos[0]->url_back . 'Recursos/img/empresa/' . $smtp->objetos[0]->logo . '" /></div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="t12" style="display:inline-table;text-align:initial;vertical-align:inherit;width:70%;max-width:385px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t11">
                                                            <tr>
                                                                <td class="t10">
                                                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t6" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t5" style="width:185px;">
                                                                                            <p class="t4" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">' . $tipoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t9" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t8" style="width:185px;">
                                                                                            <p class="t7" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">No. ' . $consecutivoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="t38" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t37" style="width:430px;padding:25px 25px 25px 25px;">
                                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td>
                                                            <table class="t18" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t17" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t16" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">Hola '.$postulado->getNombrePostulado().',</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">Recibimos tu postulación para ' . $nombre_vacante . '</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">                                                                
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Email</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $postulado->getEmail() . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Teléfono</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $postulado->getTelefono(). '</p>
                                                                    </td>
                                                                </tr>                                                                
                                                                <tr>
                                                                    <td class="t20" colspan="2" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Pronto te haremos saber sobre tu proceso</b></p>
                                                                    </td>
                                                                </tr>                                                                
                                                            </table>
                                                        </td>
                                                    </tr>                                                    
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>';
    $plantilla .= $footer;

    $mail->setFrom($smtp->objetos[0]->email, $smtp->objetos[0]->nombre);

    $administradores = new UsuarioDAO();
    $administradores->buscarUsersTalentoHumanoFull();
    $mail->addAddress($postulado->getEmail(), $postulado->getNombrePostulado());
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Recibimos tu Postulación para ' . $nombre_vacante;
    $mail->Body    = $plantilla;
    $mail->send();
}

if (isset($_POST['funcion']) && $_POST['funcion'] == 'pasoAprobado') {
    $smtp = buscar_smtp();
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $smtp->objetos[0]->host;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $smtp->objetos[0]->email;                     //SMTP username
    $mail->Password   = $smtp->objetos[0]->pass_email;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = $smtp->objetos[0]->port;
    $mail->CharSet = 'UTF-8';
    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    $postuladoDAO = new postuladoDAO();
    $postulado = new Postulado();
    $postulado->setId($_POST['id_proceso']);
    $postuladoDAO->cargar($postulado);
    $postulado->setIdVacante($postuladoDAO->objetos[0]->id_vacante);
    $postulado->setEstado($postuladoDAO->objetos[0]->estado);
    $postulado->setNombrePostulado($postuladoDAO->objetos[0]->nombre_postulado);
    $postulado->setEmail($postuladoDAO->objetos[0]->email);
    $postulado->setTelefono($postuladoDAO->objetos[0]->telefono);
    $nombre_vacante = $postuladoDAO->objetos[0]->nombre_vacante;

    if ($_POST['aprobacion'] == "1") {
        $complemento = "Pronto nos contactáremos informandote sobre tu proceso";
        if ($_POST['paso'] == "Paso 7: Llamada aceptación") {
            $complemento = 'FELICIDADES, has aprobado todo el proceso de selección, pronto nos contactaremos contigo';
        }
        $plantilla = utf8_decode('<h3>Hola ' . $postulado->getNombrePostulado() . '<br>
        <b> ' . $smtp->objetos[0]->nombre . ' </b> te quiere informar que: </h3><br><p><ul><li>Tu postulación para la vacante <b>' . $nombre_vacante . "</b> esta en el  <b>" . $_POST['paso'] . "</b> del proceso de selección.</li><li>" . $complemento . "</li>
        <br><br>Es importante tener en cuenta que cada que avances en tu proceso de selección se te informará por correo electrónico</p>");
        $mail->Subject = utf8_decode('¡Tu postulación ha pasado un filtro!');
    } else {
        $plantilla = utf8_decode('<h3>Hola ' . $proceso->objetos[0]->nombre . '<br>
        <b> ' . $smtp->objetos[0]->nombre . ' </b> te quiere informar que: </h3><br><p><ul><li>Tu postulación para la vacante <b>' . $nombre_vacante . "</b> ha finalizado en el <b>" . $_POST['paso'] . "</b></li><li>Gracias por participar, si quieres que tu curriculum vitae siga haciendo parte de nuestra base de datos y asi tenerte en cuenta a futuras vacantes respondenos a recursoshumanos@quindipisos.com  'Si quiero seguir en la base de datos'
        <br><br>" . $smtp->objetos[0]->nombre . " te desea muchos exitos en tus futuras postulaciones a vacantes.</p>");
        $mail->Subject = utf8_decode('¡Tu postulación ha finalizado!');
    }

    $tipoCorreo = utf8_decode('Recibimos tu postulacion para ' . $nombre_vacante);
    $consecutivoCorreo = $postuladoDAO->objetos[0]->id;
    $plantilla = "";
    $head = cargarHead();
    $footer = cargarFooter();
    $plantilla .= $head;
    $plantilla .= '
    <body id="body" class="t78" style="min-width:100%;Margin:0px;padding:0px;background-color:#F4F7F8;">
        <div class="t77" style="background-color:#F4F7F8;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                <tr>
                    <td class="t76" style="font-size:0;line-height:0;mso-line-height-rule:exactly;background-color:#F4F7F8;" valign="top" align="center">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center" id="innerTable">
                            <tr>
                                <td>
                                    <table class="t15" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t14" style="background-color:#f09f09;width:430px;padding:25px 25px 25px 25px;">
                                                <div class="t13" style="display:inline-table;width:100%;text-align:left;vertical-align:middle;">
                                                    <div class="t3" style="display:inline-table;text-align:initial;vertical-align:inherit;width:30%;max-width:165px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t2">
                                                            <tr>
                                                                <td class="t1">
                                                                    <div style="font-size:0px;"><img class="t0" style="display:block;border:0;height:auto;width:100%;Margin:0;max-width:100%;" width="165" height="57.875" alt="" src="' . $smtp->objetos[0]->url_back . 'Recursos/img/empresa/' . $smtp->objetos[0]->logo . '" /></div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="t12" style="display:inline-table;text-align:initial;vertical-align:inherit;width:70%;max-width:385px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t11">
                                                            <tr>
                                                                <td class="t10">
                                                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t6" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t5" style="width:185px;">
                                                                                            <p class="t4" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">' . $tipoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t9" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t8" style="width:185px;">
                                                                                            <p class="t7" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">No. ' . $consecutivoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="t38" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t37" style="width:430px;padding:25px 25px 25px 25px;">
                                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td>
                                                            <table class="t18" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t17" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t16" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">Hola '.$postulado->getNombrePostulado().',</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">'.$plantilla.'</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">                                                                
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Email</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $postulado->getEmail() . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Teléfono</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $postulado->getTelefono(). '</p>
                                                                    </td>
                                                                </tr>                                                                
                                                                <tr>
                                                                    <td class="t20" colspan="2" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Pronto te haremos saber sobre tu proceso</b></p>
                                                                    </td>
                                                                </tr>                                                                
                                                            </table>
                                                        </td>
                                                    </tr>                                                    
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>';
    $plantilla .= $footer;

    $mail->setFrom($smtp->objetos[0]->email, $smtp->objetos[0]->nombre);
    
    $administradores = new UsuarioDAO();
    $administradores->buscarUsersTalentoHumanoFull();
    $mail->addAddress($postulado->getEmail(), $postulado->getNombrePostulado());
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Recibimos tu Postulación para ' . $nombre_vacante;
    $mail->Body    = $plantilla;
    $mail->send();
}

// Check vehiculos
if (isset($_POST['funcion']) && $_POST['funcion'] == 'checkListVehiculo') {
    $smtp = buscar_smtp();
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $smtp->objetos[0]->host;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $smtp->objetos[0]->email;                     //SMTP username
    $mail->Password   = $smtp->objetos[0]->pass_email;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = $smtp->objetos[0]->port;
    $mail->CharSet = 'UTF-8';
    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    $DAO = new checkListVehiculoDAO();
    $modelo = new CheckListVehiculo();
    $modelo->setId($_POST['id_check']);
    $DAO->cargar($modelo);
    $tipo_vehiculo = $DAO->objetos[0]->tipo_vehiculo;
    $placa = $DAO->objetos[0]->placa;
    $nombre_completo = $DAO->objetos[0]->nombre_completo;
    $doc_id = $DAO->objetos[0]->doc_id;
    $fecha = $DAO->objetos[0]->fecha ;
    $opcion = new OpcionCheckListVehiculo();
    $opcion->setIdCheckVehiculo($_POST['id_check']);
    $DAO->listar_opcion_check_list($opcion);

    $opciones = "";
    foreach ($DAO->objetos as $objeto) {
        if($objeto->estado == 1){
            $estado = 'Malo';
        } else if($objeto->estado==2){
            $estado = 'Regular';
        }else{
            $estado = 'Bueno';
        }
        $opciones .= '  <tr>
                            <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>'.$objeto->opcion.'</b></p>
                            </td>
                            <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $estado . '(' . $objeto->observaciones . ')</p>
                            </td>
                        </tr>    ';
    }

    $tipoCorreo = utf8_decode('Nuevo Check List de Vehiculo registrado ');
    $consecutivoCorreo = $DAO->objetos[0]->id;
    $plantilla = "";
    $head = cargarHead();
    $footer = cargarFooter();
    $plantilla .= $head;
    $plantilla .= '
    <body id="body" class="t78" style="min-width:100%;Margin:0px;padding:0px;background-color:#F4F7F8;">
        <div class="t77" style="background-color:#F4F7F8;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                <tr>
                    <td class="t76" style="font-size:0;line-height:0;mso-line-height-rule:exactly;background-color:#F4F7F8;" valign="top" align="center">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center" id="innerTable">
                            <tr>
                                <td>
                                    <table class="t15" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t14" style="background-color:#f09f09;width:430px;padding:25px 25px 25px 25px;">
                                                <div class="t13" style="display:inline-table;width:100%;text-align:left;vertical-align:middle;">
                                                    <div class="t3" style="display:inline-table;text-align:initial;vertical-align:inherit;width:30%;max-width:165px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t2">
                                                            <tr>
                                                                <td class="t1">
                                                                    <div style="font-size:0px;"><img class="t0" style="display:block;border:0;height:auto;width:100%;Margin:0;max-width:100%;" width="165" height="57.875" alt="" src="' . $smtp->objetos[0]->url_back . 'Recursos/img/empresa/' . $smtp->objetos[0]->logo . '" /></div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="t12" style="display:inline-table;text-align:initial;vertical-align:inherit;width:70%;max-width:385px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t11">
                                                            <tr>
                                                                <td class="t10">
                                                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t6" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t5" style="width:185px;">
                                                                                            <p class="t4" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">' . $tipoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t9" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t8" style="width:185px;">
                                                                                            <p class="t7" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">No. ' . $consecutivoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="t38" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t37" style="width:430px;padding:25px 25px 25px 25px;">
                                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td>
                                                            <table class="t18" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t17" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t16" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">Hola Área de Talento Humano,</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">Tienes un nuevo registro de Check List de Vehiculo</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Placa Vehiculo</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $tipo_vehiculo . " placa " . $placa . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Nombre Conductor</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $nombre_completo . ' Documento (' . $doc_id . ')</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Fecha</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $fecha. '</p>
                                                                    </td>
                                                                </tr>                                                                
                                                                <tr>
                                                                    <td class="t20" colspan="2" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Respuestas Check List</b></p>
                                                                    </td>
                                                                </tr>   
                                                                '.$opciones.'                                                             
                                                            </table>
                                                        </td>
                                                    </tr>                                                    
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>';
    $plantilla .= $footer;

    $mail->setFrom($smtp->objetos[0]->email, $smtp->objetos[0]->nombre);

    // correos administradores talento humano
    $administradores = new UsuarioDAO();
    $administradores->buscarUsersTalentoHumanoFull();
    foreach ($administradores->objetos as $objeto) {
        $mail->addAddress($objeto->email, $objeto->nombre_completo);
    }
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Nueva Check List de Vehiculo Registrado de ' . $nombre_completo;
    $mail->Body    = $plantilla;
    $mail->send();
}

// Check cumplimiento

if (isset($_POST['funcion']) && $_POST['funcion'] == 'checkListCumplimiento') {
    $smtp = buscar_smtp();
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $smtp->objetos[0]->host;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $smtp->objetos[0]->email;                     //SMTP username
    $mail->Password   = $smtp->objetos[0]->pass_email;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = $smtp->objetos[0]->port;
    $mail->CharSet = 'UTF-8';
    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    $DAO = new checkCumplimientoDAO();
    $modelo = new CheckCumplimiento();
    $modelo->setId($_POST['id_check']);
    $DAO->cargar($modelo);
    $colaborador = $DAO->objetos[0]->colaborador;
    $doc_id = $DAO->objetos[0]->doc_id;
    $encargado = $DAO->objetos[0]->encargado;
    $nombre_sede = $DAO->objetos[0]->nombre_sede;
    $fecha = $DAO->objetos[0]->fecha ;
    $opcion = new OpcionCheckCumplimiento();
    $opcion->setIdCheckCumplimiento($_POST['id_check']);
    $DAO->listar_opcion_check_list($opcion);

    $opciones = "";
    foreach ($DAO->objetos as $objeto) {
        if($objeto->evaluacion == 1){
            $estado = 'Cumple';
        } else{
            $estado = 'No Cumple';
        }
        $opciones .= '  <tr>
                            <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>'.$objeto->actividad.'</b></p>
                            </td>
                            <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $estado . ' (' . $objeto->observaciones . ')</p>
                            </td>
                        </tr>    ';
    }

    $tipoCorreo = utf8_decode('Nuevo Check List de Cumplimiento registrado');
    $consecutivoCorreo = $DAO->objetos[0]->id;
    $plantilla = "";
    $head = cargarHead();
    $footer = cargarFooter();
    $plantilla .= $head;
    $plantilla .= '
    <body id="body" class="t78" style="min-width:100%;Margin:0px;padding:0px;background-color:#F4F7F8;">
        <div class="t77" style="background-color:#F4F7F8;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                <tr>
                    <td class="t76" style="font-size:0;line-height:0;mso-line-height-rule:exactly;background-color:#F4F7F8;" valign="top" align="center">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center" id="innerTable">
                            <tr>
                                <td>
                                    <table class="t15" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t14" style="background-color:#f09f09;width:430px;padding:25px 25px 25px 25px;">
                                                <div class="t13" style="display:inline-table;width:100%;text-align:left;vertical-align:middle;">
                                                    <div class="t3" style="display:inline-table;text-align:initial;vertical-align:inherit;width:30%;max-width:165px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t2">
                                                            <tr>
                                                                <td class="t1">
                                                                    <div style="font-size:0px;"><img class="t0" style="display:block;border:0;height:auto;width:100%;Margin:0;max-width:100%;" width="165" height="57.875" alt="" src="' . $smtp->objetos[0]->url_back . 'Recursos/img/empresa/' . $smtp->objetos[0]->logo . '" /></div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="t12" style="display:inline-table;text-align:initial;vertical-align:inherit;width:70%;max-width:385px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t11">
                                                            <tr>
                                                                <td class="t10">
                                                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t6" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t5" style="width:185px;">
                                                                                            <p class="t4" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">' . $tipoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t9" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t8" style="width:185px;">
                                                                                            <p class="t7" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">No. ' . $consecutivoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="t38" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t37" style="width:430px;padding:25px 25px 25px 25px;">
                                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td>
                                                            <table class="t18" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t17" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t16" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">Hola Área de Talento Humano,</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">Tienes un nuevo registro de Check List de Cumplimiento</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Sede</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $nombre_sede . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Nombre Colaborador</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $colaborador . ' Documento (' . $doc_id . ')</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Fecha</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $fecha. '</p>
                                                                    </td>
                                                                </tr>                                                                
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Evaluador</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $encargado. '</p>
                                                                    </td>
                                                                </tr>                                                                
                                                                <tr>
                                                                    <td class="t20" colspan="2" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Respuestas Check List</b></p>
                                                                    </td>
                                                                </tr>   
                                                                '.$opciones.'                                                             
                                                            </table>
                                                        </td>
                                                    </tr>                                                    
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>';
    $plantilla .= $footer;

    $mail->setFrom($smtp->objetos[0]->email, $smtp->objetos[0]->nombre);

    // correos administradores talento humano
    $administradores = new UsuarioDAO();
    $administradores->buscarUsersTalentoHumanoFull();
    foreach ($administradores->objetos as $objeto) {
        $mail->addAddress($objeto->email, $objeto->nombre_completo);
    }
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Nueva Check List de Cumplimiento Registrado de ' . $colaborador;
    $mail->Body    = $plantilla;
    $mail->send();
}

//Encuestas satisfaccion
if (isset($_POST['funcion']) && $_POST['funcion'] == 'enviar_email_encuesta_bodega') {
    $smtp = buscar_smtp();
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $smtp->objetos[0]->host;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $smtp->objetos[0]->email;                     //SMTP username
    $mail->Password   = $smtp->objetos[0]->pass_email;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = $smtp->objetos[0]->port;
    $mail->CharSet = 'UTF-8';
    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`


    $tipoCorreo = utf8_decode('Nueva Encuesta de satisfacción de bodega registrada');
    $plantilla = "";
    $head = cargarHead();
    $footer = cargarFooter();
    $plantilla .= $head;
    $plantilla .= '
    <body id="body" class="t78" style="min-width:100%;Margin:0px;padding:0px;background-color:#F4F7F8;">
        <div class="t77" style="background-color:#F4F7F8;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                <tr>
                    <td class="t76" style="font-size:0;line-height:0;mso-line-height-rule:exactly;background-color:#F4F7F8;" valign="top" align="center">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center" id="innerTable">
                            <tr>
                                <td>
                                    <table class="t15" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t14" style="background-color:#f09f09;width:430px;padding:25px 25px 25px 25px;">
                                                <div class="t13" style="display:inline-table;width:100%;text-align:left;vertical-align:middle;">
                                                    <div class="t3" style="display:inline-table;text-align:initial;vertical-align:inherit;width:30%;max-width:165px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t2">
                                                            <tr>
                                                                <td class="t1">
                                                                    <div style="font-size:0px;"><img class="t0" style="display:block;border:0;height:auto;width:100%;Margin:0;max-width:100%;" width="165" height="57.875" alt="" src="' . $smtp->objetos[0]->url_back . 'Recursos/img/empresa/' . $smtp->objetos[0]->logo . '" /></div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="t12" style="display:inline-table;text-align:initial;vertical-align:inherit;width:70%;max-width:385px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t11">
                                                            <tr>
                                                                <td class="t10">
                                                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t6" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t5" style="width:185px;">
                                                                                            <p class="t4" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">' . $tipoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="t38" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t37" style="width:430px;padding:25px 25px 25px 25px;">
                                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td>
                                                            <table class="t18" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t17" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t16" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">Hola</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">Se registró una nueva encuesta de satisfacción de bodega</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>¿Está satisfecho con la calidad del servicio y atención?</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $_POST['preg1'] . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>¿Está satisfecho con la calidad de los productos?</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $_POST['preg2'] . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>¿Está satisfecho con el tiempo de entrega?</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' .$_POST['preg3'] . '</p>
                                                                    </td>
                                                                </tr>                                                                
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>¿Recomendaría nuestros servicios a otros?</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $_POST['recomendaria']. '</p>
                                                                    </td>
                                                                </tr>                                                               
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Comentarios</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $_POST['comentarios']. '</p>
                                                                    </td>
                                                                </tr>                                                    
                                                            </table>
                                                        </td>
                                                    </tr>                                                    
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>';
    $plantilla .= $footer;

    $mail->setFrom($smtp->objetos[0]->email, $smtp->objetos[0]->nombre);

    // correos administradores talento humano y jefes de bodega
    $administradores = new UsuarioDAO();
    $administradores->buscarUsersTalentoHumanoFull();
    foreach ($administradores->objetos as $objeto) {
        $mail->addAddress($objeto->email, $objeto->nombre_completo);
    }
    $administradores->buscarUsersBodega();
    foreach ($administradores->objetos as $objeto) {
        $mail->addAddress($objeto->email, $objeto->nombre_completo);
    }
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Nueva Encuesta de satisfacción de bodega registrada';
    $mail->Body    = $plantilla;
    $mail->send();
}

if (isset($_POST['funcion']) && $_POST['funcion'] == 'enviar_email_encuesta_servicio') {
    $smtp = buscar_smtp();
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $smtp->objetos[0]->host;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $smtp->objetos[0]->email;                     //SMTP username
    $mail->Password   = $smtp->objetos[0]->pass_email;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = $smtp->objetos[0]->port;
    $mail->CharSet = 'UTF-8';
    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`


    $tipoCorreo = utf8_decode('Nueva Encuesta de satisfacción de servicio en salas registrada');
    $plantilla = "";
    $head = cargarHead();
    $footer = cargarFooter();
    $plantilla .= $head;
    $plantilla .= '
    <body id="body" class="t78" style="min-width:100%;Margin:0px;padding:0px;background-color:#F4F7F8;">
        <div class="t77" style="background-color:#F4F7F8;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                <tr>
                    <td class="t76" style="font-size:0;line-height:0;mso-line-height-rule:exactly;background-color:#F4F7F8;" valign="top" align="center">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center" id="innerTable">
                            <tr>
                                <td>
                                    <table class="t15" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t14" style="background-color:#f09f09;width:430px;padding:25px 25px 25px 25px;">
                                                <div class="t13" style="display:inline-table;width:100%;text-align:left;vertical-align:middle;">
                                                    <div class="t3" style="display:inline-table;text-align:initial;vertical-align:inherit;width:30%;max-width:165px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t2">
                                                            <tr>
                                                                <td class="t1">
                                                                    <div style="font-size:0px;"><img class="t0" style="display:block;border:0;height:auto;width:100%;Margin:0;max-width:100%;" width="165" height="57.875" alt="" src="' . $smtp->objetos[0]->url_back . 'Recursos/img/empresa/' . $smtp->objetos[0]->logo . '" /></div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="t12" style="display:inline-table;text-align:initial;vertical-align:inherit;width:70%;max-width:385px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t11">
                                                            <tr>
                                                                <td class="t10">
                                                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t6" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t5" style="width:185px;">
                                                                                            <p class="t4" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">' . $tipoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="t38" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t37" style="width:430px;padding:25px 25px 25px 25px;">
                                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td>
                                                            <table class="t18" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t17" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t16" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">Hola</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">Se registró una nueva encuesta de satisfacción de servicio en salas</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>¿Logró el asesor entender sus necesidades?</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $_POST['preg1'] . '</p>
                                                                    </td>
                                                                </tr>                                                             
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>¿Recomendaría nuestros servicios a otros?</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $_POST['recomendaria']. '</p>
                                                                    </td>
                                                                </tr>                                                               
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Comentarios</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $_POST['comentarios']. '</p>
                                                                    </td>
                                                                </tr>                                                    
                                                            </table>
                                                        </td>
                                                    </tr>                                                    
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>';
    $plantilla .= $footer;

    $mail->setFrom($smtp->objetos[0]->email, $smtp->objetos[0]->nombre);

    // correos administradores talento humano y jefes de bodega
    $administradores = new UsuarioDAO();
    $administradores->buscarUsersTalentoHumanoFull();
    foreach ($administradores->objetos as $objeto) {
        $mail->addAddress($objeto->email, $objeto->nombre_completo);
    }
    $administradores->buscarUsersSalasServicio();
    foreach ($administradores->objetos as $objeto) {
        $mail->addAddress($objeto->email, $objeto->nombre_completo);
    }
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Nueva Encuesta de satisfacción de servicio en salas registrada';
    $mail->Body    = $plantilla;
    $mail->send();
}

// Solicitudes de tiempo para ti

if (isset($_POST['funcion']) && $_POST['funcion'] == 'enviar_email_solicitud_tiempo_para_ti') {
    $smtp = buscar_smtp();
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $smtp->objetos[0]->host;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $smtp->objetos[0]->email;                     //SMTP username
    $mail->Password   = $smtp->objetos[0]->pass_email;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = $smtp->objetos[0]->port;
    $mail->CharSet = 'UTF-8';
    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //cargar la solicitud
    $dao = new tiempoParaTiDAO();
    $modelo = new TiempoParaTi();
    $modelo->setIdUsuario($_POST['id_usuario']);
    $modelo->setHorario($_POST['horario']);
    $modelo->setFechaSolicitud($_POST['fecha_solicitud']);
    $dao->listarUltimoCreado($modelo);
    //cargar el colaborador
    $colaborador = $dao->objetos[0]->nombre_completo;
    $doc_id = $dao->objetos[0]->doc_id;
    $sede = $dao->objetos[0]->nombre_sede;
    $cargo = $dao->objetos[0]->nombre_cargo;


    //cargar plantilla
    $tipoCorreo = utf8_decode('Solicitud de tiempo Nueva');
    $plantilla = "";
    $head = cargarHead();
    $footer = cargarFooter();
    $plantilla .= $head;
    $plantilla .= '
    <body id="body" class="t78" style="min-width:100%;Margin:0px;padding:0px;background-color:#F4F7F8;">
        <div class="t77" style="background-color:#F4F7F8;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                <tr>
                    <td class="t76" style="font-size:0;line-height:0;mso-line-height-rule:exactly;background-color:#F4F7F8;" valign="top" align="center">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center" id="innerTable">
                            <tr>
                                <td>
                                    <table class="t15" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t14" style="background-color:#f09f09;width:430px;padding:25px 25px 25px 25px;">
                                                <div class="t13" style="display:inline-table;width:100%;text-align:left;vertical-align:middle;">
                                                    <div class="t3" style="display:inline-table;text-align:initial;vertical-align:inherit;width:30%;max-width:165px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t2">
                                                            <tr>
                                                                <td class="t1">
                                                                    <div style="font-size:0px;"><img class="t0" style="display:block;border:0;height:auto;width:100%;Margin:0;max-width:100%;" width="165" height="57.875" alt="" src="' . $smtp->objetos[0]->url_back . 'Recursos/img/empresa/' . $smtp->objetos[0]->logo . '" /></div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="t12" style="display:inline-table;text-align:initial;vertical-align:inherit;width:70%;max-width:385px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t11">
                                                            <tr>
                                                                <td class="t10">
                                                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t6" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t5" style="width:185px;">
                                                                                            <p class="t4" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">' . $tipoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="t38" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t37" style="width:430px;padding:25px 25px 25px 25px;">
                                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td>
                                                            <table class="t18" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t17" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t16" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">Hola Jefe de recursos humanos</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">Se registró una nueva solicitud de tiempo de '.$colaborador.'</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Cargo Colaborador</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $cargo. '</p>
                                                                    </td>
                                                                </tr>                                                             
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Sede Colaborador</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $sede. '</p>
                                                                    </td>
                                                                </tr>                                                               
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Documento de identidad</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $doc_id. '</p>
                                                                    </td>
                                                                </tr>                                                    
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Fecha solicitada</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $_POST['fecha_aprobacion']. '</p>
                                                                    </td>
                                                                </tr>                                                    
                                                            </table>
                                                        </td>
                                                    </tr>                                                    
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>';
    $plantilla .= $footer;

    $mail->setFrom($smtp->objetos[0]->email, $smtp->objetos[0]->nombre);

    // correos administradores talento humano y jefes de bodega
    $administradores = new UsuarioDAO();
    $administradores->buscarUsersJefeRecursoHumano();
    foreach ($administradores->objetos as $objeto) {
        $mail->addAddress($objeto->email, $objeto->nombre_completo);
    }
    if($_POST['id_usuario']==18){
        $mail->addAddress('yuliana_5_@hotmail.com', 'Yhuliana Cristina Molina Loaiza');
    }
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Nueva solicitud de tiempo de '.$colaborador;
    $mail->Body    = $plantilla;
    $mail->send();
}

if (isset($_POST['funcion']) && $_POST['funcion'] == 'solicitud_tiempo_asignado') {
    $smtp = buscar_smtp();
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $smtp->objetos[0]->host;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $smtp->objetos[0]->email;                     //SMTP username
    $mail->Password   = $smtp->objetos[0]->pass_email;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = $smtp->objetos[0]->port;
    $mail->CharSet = 'UTF-8';
    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //cargar la solicitud
    $dao = new UsuarioDAO();
    $modelo = new Usuario();
    $modelo->setId($_POST['id_usuario']);
    $dao->cargarCc($modelo);
    //cargar el colaborador
    $colaborador = $dao->objetos[0]->nombre_completo;
    $emailColaborador = $dao->objetos[0]->email;

    $mensaje = "Se te asignó un hora tiempo para ti";
    if(isset($_POST['semana']) && $_POST['semana']<>""){
        $mensaje .= ' La ' .$_POST['semana'].",";
    }
    $mensaje .= " para disfrutar el día ".$_POST['fecha_aprobacion'] . " durante el horario de ".$_POST['horario'].", recuerda llegar puntual justo despues de haber terminado de disfrutar el tiempo para ti.";

    //cargar plantilla
    $tipoCorreo = utf8_decode('Asignacion tiempo para ti');
    $plantilla = "";
    $head = cargarHead();
    $footer = cargarFooter();
    $plantilla .= $head;
    $plantilla .= '
    <body id="body" class="t78" style="min-width:100%;Margin:0px;padding:0px;background-color:#F4F7F8;">
        <div class="t77" style="background-color:#F4F7F8;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                <tr>
                    <td class="t76" style="font-size:0;line-height:0;mso-line-height-rule:exactly;background-color:#F4F7F8;" valign="top" align="center">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center" id="innerTable">
                            <tr>
                                <td>
                                    <table class="t15" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t14" style="background-color:#f09f09;width:430px;padding:25px 25px 25px 25px;">
                                                <div class="t13" style="display:inline-table;width:100%;text-align:left;vertical-align:middle;">
                                                    <div class="t3" style="display:inline-table;text-align:initial;vertical-align:inherit;width:30%;max-width:165px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t2">
                                                            <tr>
                                                                <td class="t1">
                                                                    <div style="font-size:0px;"><img class="t0" style="display:block;border:0;height:auto;width:100%;Margin:0;max-width:100%;" width="165" height="57.875" alt="" src="' . $smtp->objetos[0]->url_back . 'Recursos/img/empresa/' . $smtp->objetos[0]->logo . '" /></div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="t12" style="display:inline-table;text-align:initial;vertical-align:inherit;width:70%;max-width:385px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t11">
                                                            <tr>
                                                                <td class="t10">
                                                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t6" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t5" style="width:185px;">
                                                                                            <p class="t4" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">' . $tipoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="t38" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t37" style="width:430px;padding:25px 25px 25px 25px;">
                                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td>
                                                            <table class="t18" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t17" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t16" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">Hola '.$colaborador.'</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">'.$mensaje.'</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>                                                                                                        
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>';
    $plantilla .= $footer;

    $mail->setFrom($smtp->objetos[0]->email, $smtp->objetos[0]->nombre);

    $mail->addAddress($emailColaborador, $colaborador);
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Asignación de tiempo para ti '.$colaborador;
    $mail->Body    = $plantilla;
    $mail->send();
}

// Solicitudes de compras

if (isset($_POST['funcion']) && $_POST['funcion'] == 'notificarSolicitudCompras') {
    $smtp = buscar_smtp();
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $smtp->objetos[0]->host;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $smtp->objetos[0]->email;                     //SMTP username
    $mail->Password   = $smtp->objetos[0]->pass_email;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = $smtp->objetos[0]->port;
    $mail->CharSet = 'UTF-8';
    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    include_once '../DAO/listadoSolicitudComprasDAO.php';
    include_once '../Modelo/ListadoSolicitudCompras.php';

    $DAO = new listadoSolicitudComprasDAO();
    $modelo = new ListadoSolicitudCompras();
    $modelo->setId($_POST['id_solicitud']);
    $DAO->cargar($modelo);

    $colaborador = $DAO->objetos[0]->nombre_completo;
    $nombre_area = $DAO->objetos[0]->nombre_area;
    $nombre_sede = $DAO->objetos[0]->nombre_sede;

    $destino = '';
    $mensaje = '';
    $asunto = '';
    if($_POST['estado']==1){
        $destino = 'Hola Gerencia';
        $mensaje = 'Hay un nuevo registro de solicitud de compras que esta solicitando tu autorización';
        $asunto = 'Nueva Solicitud de Compras';
    }
    if($_POST['estado']==2){
        $destino = 'Hola Coordinación Administrativa y Contable';
        $mensaje = 'Hay una solicitud de compras autorizada esperando tu revisión';
        $asunto = 'Nueva Solicitud de Compras Autorizada';
    }


    $tipoCorreo = utf8_decode($asunto);
    $consecutivoCorreo = $DAO->objetos[0]->id;
    $plantilla = "";
    $head = cargarHead();
    $footer = cargarFooter();
    $plantilla .= $head;

    $plantilla .= '
    <body id="body" class="t78" style="min-width:100%;Margin:0px;padding:0px;background-color:#F4F7F8;">
        <div class="t77" style="background-color:#F4F7F8;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                <tr>
                    <td class="t76" style="font-size:0;line-height:0;mso-line-height-rule:exactly;background-color:#F4F7F8;" valign="top" align="center">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center" id="innerTable">
                            <tr>
                                <td>
                                    <table class="t15" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t14" style="background-color:#f09f09;width:430px;padding:25px 25px 25px 25px;">
                                                <div class="t13" style="display:inline-table;width:100%;text-align:left;vertical-align:middle;">
                                                    <div class="t3" style="display:inline-table;text-align:initial;vertical-align:inherit;width:30%;max-width:165px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t2">
                                                            <tr>
                                                                <td class="t1">
                                                                    <div style="font-size:0px;"><img class="t0" style="display:block;border:0;height:auto;width:100%;Margin:0;max-width:100%;" width="165" height="57.875" alt="" src="' . $smtp->objetos[0]->url_back . 'Recursos/img/empresa/' . $smtp->objetos[0]->logo . '" /></div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="t12" style="display:inline-table;text-align:initial;vertical-align:inherit;width:70%;max-width:385px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t11">
                                                            <tr>
                                                                <td class="t10">
                                                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t6" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t5" style="width:185px;">
                                                                                            <p class="t4" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">' . $tipoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t9" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t8" style="width:185px;">
                                                                                            <p class="t7" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">No. ' . $consecutivoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="t38" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t37" style="width:430px;padding:25px 25px 25px 25px;">
                                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td>
                                                            <table class="t18" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t17" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t16" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">Hola '.$destino . ',</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">'.$mensaje.'</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Sede</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $nombre_sede . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Nombre Colaborador</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $colaborador . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Área</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $nombre_area. '</p>
                                                                    </td>
                                                                </tr>                                                     
                                                            </table>
                                                        </td>
                                                    </tr>                                                    
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>';
    $plantilla .= $footer;

    $mail->setFrom($smtp->objetos[0]->email, $smtp->objetos[0]->nombre);

    // destinatario
    $destinatarios = new UsuarioDAO();
    $destinatarios->usuariosPorCargo();
    foreach ($destinatarios->objetos as $objeto) {
        if($_POST['estado']==1){
            if($objeto->id_cargo==3){
                $mail->addAddress($objeto->email, $objeto->nombre_completo);
            }            
        }
        if($_POST['estado']==2){
            if($objeto->id_cargo==5){
                $mail->addAddress($objeto->email, $objeto->nombre_completo);
            }        
        }
    }
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $asunto;
    $mail->Body    = $plantilla;
    $mail->send();
}

if (isset($_POST['funcion']) && $_POST['funcion'] == 'enviar_email_solicitud_mueble_terminado') {
    $smtp = buscar_smtp();
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $smtp->objetos[0]->host;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $smtp->objetos[0]->email;                     //SMTP username
    $mail->Password   = $smtp->objetos[0]->pass_email;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = $smtp->objetos[0]->port;
    $mail->CharSet = 'UTF-8';
    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    $solicitudDAO = new solicitudMuebleDAO();
    $solicitud = new SolicitudMueble();
    $solicitud->setId($_POST['id']);

    $solicitudDAO->cargar($solicitud);
    $estado = "";
    $estado2 = "";
    $urlNotificacion = "";
    if ($solicitudDAO->objetos[0]->estado == 4) {
        $estado = "<p style='color: green;'><b>Terminado</b></p>";
        $estado2 = "terminada";       
    } 
    $texto = "Para programar la entrega del mueble ponte en contacto con el asesor";
    $tipoCorreo = utf8_decode('Solicitud de Mueble' . $estado2);
    $consecutivoCorreo = $_POST['id'];
    $plantilla = "";
    $head = cargarHead();
    $footer = cargarFooter();
    $plantilla .= $head;
    $plantilla .= '
    <body id="body" class="t78" style="min-width:100%;Margin:0px;padding:0px;background-color:#F4F7F8;">
        <div class="t77" style="background-color:#F4F7F8;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                <tr>
                    <td class="t76" style="font-size:0;line-height:0;mso-line-height-rule:exactly;background-color:#F4F7F8;" valign="top" align="center">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center" id="innerTable">
                            <tr>
                                <td>
                                    <table class="t15" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t14" style="background-color:#f09f09;width:430px;padding:25px 25px 25px 25px;">
                                                <div class="t13" style="display:inline-table;width:100%;text-align:left;vertical-align:middle;">
                                                    <div class="t3" style="display:inline-table;text-align:initial;vertical-align:inherit;width:30%;max-width:165px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t2">
                                                            <tr>
                                                                <td class="t1">
                                                                    <div style="font-size:0px;"><img class="t0" style="display:block;border:0;height:auto;width:100%;Margin:0;max-width:100%;" width="165" height="57.875" alt="" src="' . $smtp->objetos[0]->url_back . 'Recursos/img/empresa/' . $smtp->objetos[0]->logo . '" /></div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="t12" style="display:inline-table;text-align:initial;vertical-align:inherit;width:70%;max-width:385px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t11">
                                                            <tr>
                                                                <td class="t10">
                                                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t6" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t5" style="width:185px;">
                                                                                            <p class="t4" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">' . $tipoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t9" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t8" style="width:185px;">
                                                                                            <p class="t7" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">No. ' . $consecutivoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="t38" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t37" style="width:430px;padding:25px 25px 25px 25px;">
                                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td>
                                                            <table class="t18" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t17" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t16" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">Hola '.$solicitudDAO->objetos[0]->nombre_cliente.', tu solicitud de mueble ha sido '.$estado2.'</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Nombre Mueble</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $solicitudDAO->objetos[0]->nombre_mueble . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Observaciones</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $solicitudDAO->objetos[0]->observaciones . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Asesor</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $solicitudDAO->objetos[0]->asesor . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Email Asesor</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $solicitudDAO->objetos[0]->correo_institucional . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Teléfono Asesor</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $solicitudDAO->objetos[0]->telefono_asesor . '</p>
                                                                    </td>
                                                                </tr>'
                                                                .$texto.
                                                                '
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>';
    $plantilla .= $footer;

    $mail->setFrom($smtp->objetos[0]->email, $smtp->objetos[0]->nombre);

    $mail->addAddress($solicitudDAO->objetos[0]->email_cliente, $solicitudDAO->objetos[0]->nombre_cliente);

    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Tu solicitud de mueble ha terminado ';
    $mail->Body    = $plantilla;
    $mail->send();
}

if (isset($_POST['funcion']) && $_POST['funcion'] == 'enviar_email_solicitud_mueble_terminado_asesor') {
    $smtp = buscar_smtp();
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $smtp->objetos[0]->host;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $smtp->objetos[0]->email;                     //SMTP username
    $mail->Password   = $smtp->objetos[0]->pass_email;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = $smtp->objetos[0]->port;
    $mail->CharSet = 'UTF-8';
    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    $solicitudDAO = new solicitudMuebleDAO();
    $solicitud = new SolicitudMueble();
    $solicitud->setId($_POST['id']);

    $solicitudDAO->cargar($solicitud);
    $estado = "";
    $estado2 = "";
    $urlNotificacion = "";
    if ($solicitudDAO->objetos[0]->estado == 4) {
        $estado = "<p style='color: green;'><b>Terminado</b></p>";
        $estado2 = "terminada";       
    } 
    $texto = "Ponte en contacto con el cliente para programar la entrega del mueble";
    $tipoCorreo = utf8_decode('Solicitud de Mueble ' . $estado2);
    $consecutivoCorreo = $_POST['id'];
    $plantilla = "";
    $head = cargarHead();
    $footer = cargarFooter();
    $plantilla .= $head;
    $plantilla .= '
    <body id="body" class="t78" style="min-width:100%;Margin:0px;padding:0px;background-color:#F4F7F8;">
        <div class="t77" style="background-color:#F4F7F8;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                <tr>
                    <td class="t76" style="font-size:0;line-height:0;mso-line-height-rule:exactly;background-color:#F4F7F8;" valign="top" align="center">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center" id="innerTable">
                            <tr>
                                <td>
                                    <table class="t15" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t14" style="background-color:#f09f09;width:430px;padding:25px 25px 25px 25px;">
                                                <div class="t13" style="display:inline-table;width:100%;text-align:left;vertical-align:middle;">
                                                    <div class="t3" style="display:inline-table;text-align:initial;vertical-align:inherit;width:30%;max-width:165px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t2">
                                                            <tr>
                                                                <td class="t1">
                                                                    <div style="font-size:0px;"><img class="t0" style="display:block;border:0;height:auto;width:100%;Margin:0;max-width:100%;" width="165" height="57.875" alt="" src="' . $smtp->objetos[0]->url_back . 'Recursos/img/empresa/' . $smtp->objetos[0]->logo . '" /></div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="t12" style="display:inline-table;text-align:initial;vertical-align:inherit;width:70%;max-width:385px;">
                                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="t11">
                                                            <tr>
                                                                <td class="t10">
                                                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t6" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t5" style="width:185px;">
                                                                                            <p class="t4" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">' . $tipoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <table class="t9" role="presentation" cellpadding="0" cellspacing="0" align="right">
                                                                                    <tr>
                                                                                        <td class="t8" style="width:185px;">
                                                                                            <p class="t7" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:600;font-style:normal;font-size:16px;text-decoration:none;text-transform:none;direction:ltr;color:#ffffff;text-align:right;mso-line-height-rule:exactly;mso-text-raise:2px;">No. ' . $consecutivoCorreo . '</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="t38" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td class="t37" style="width:430px;padding:25px 25px 25px 25px;">
                                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td>
                                                            <table class="t18" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t17" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t16" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">Hola '.$solicitudDAO->objetos[0]->asesor.', una solicitud de mueble ha sido '.$estado2.'</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="t21" role="presentation" cellpadding="0" cellspacing="0" align="center">
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Nombre Mueble</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $solicitudDAO->objetos[0]->nombre_mueble . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Observaciones</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $solicitudDAO->objetos[0]->observaciones . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Nombre Cliente</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $solicitudDAO->objetos[0]->nombre_cliente . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Email Cliente</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $solicitudDAO->objetos[0]->email_cliente . '</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;"><b>Teléfono Asesor</b></p>
                                                                    </td>
                                                                    <td class="t20" style="width:480px;padding:0 0 24px 0;">
                                                                        <p class="t19" style="margin:0;Margin:0;font-family:Albert Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:24px;font-weight:400;font-style:normal;font-size:14px;text-decoration:none;text-transform:none;direction:ltr;color:#09234F;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">' . $solicitudDAO->objetos[0]->telefono_asesor . '</p>
                                                                    </td>
                                                                </tr>'
                                                                .$texto.
                                                                '
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>';
    $plantilla .= $footer;

    $mail->setFrom($smtp->objetos[0]->email, $smtp->objetos[0]->nombre);

    $mail->addAddress($solicitudDAO->objetos[0]->correo_institucional, $solicitudDAO->objetos[0]->asesor);

    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Una solicitud de mueble ha terminado ';
    $mail->Body    = $plantilla;
    $mail->send();
}