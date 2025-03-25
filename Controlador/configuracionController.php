<?php
include_once '../Modelo/Configuracion.php';
include_once '../DAO/configuracionDAO.php';
include_once '../DAO/envioCorreoDAO.php';

$configuracion = new Configuracion();

$dao = new configuracionDAO(); 

/* El bloque de código está comprobando si el valor de `['funcion']` es igual a
`'cargarInformacion'`. Si es así recupera información de la base de datos usando el método
`cargarInformacion()` del objeto `configuracionDAO`. Luego crea una matriz asociativa con los datos
recuperados y los codifica en una cadena JSON usando `json_encode()`. Finalmente, hace eco de la
cadena JSON. */
if ($_POST['funcion'] == 'cargarInformacion') {

    $json = array();
    $dao->cargarInformacion();
    $json[] = array(
        'nombre' => $dao->objetos[0]->nombre,
        'nit' => $dao->objetos[0]->nit,
        'hosting' => $dao->objetos[0]->hosting,
        'url_back' => $dao->objetos[0]->url_back,
        'url_front' => $dao->objetos[0]->url_front,
        'logo' => $dao->objetos[0]->logo,
        'logo_blanco' => $dao->objetos[0]->logo_blanco,
        'faticon' => $dao->objetos[0]->faticon,
        'img_login' => $dao->objetos[0]->img_login,
        'driver' => $dao->objetos[0]->driver,
        'cifrado' => $dao->objetos[0]->cifrado,
        'host' => $dao->objetos[0]->host,
        'port' => $dao->objetos[0]->port,
        'email' => $dao->objetos[0]->email,
        'pass_email' => $dao->objetos[0]->pass_email,
        'email_carta' => $dao->objetos[0]->email_carta,
        'direccion' => $dao->objetos[0]->direccion,
        'tel_contacto' => $dao->objetos[0]->tel_contacto,
    );
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}

/* Este bloque de código está verificando si el valor de `['funcion']` es igual a
`'guardarDatosBasicos'`. Si es así, establece las propiedades del objeto `` con los
valores correspondientes de la matriz ``. Luego llama al método `guardarDatosBasicos()` del
objeto ``, pasando como parámetro el objeto ``. Este método se encarga de guardar
los datos básicos en la base de datos. */
if ($_POST['funcion'] == 'guardarDatosBasicos') {
    $configuracion->setNombre($_POST['nombre']);
    $configuracion->setUrlBack($_POST['url_back']);
    $configuracion->setUrlFront($_POST['url_front']);
    $configuracion->setHosting($_POST['hosting']);
    $configuracion->setNit($_POST['nit']);
    $configuracion->setEmailCarta($_POST['email_carta']);
    $configuracion->setDireccion($_POST['direccion']);
    $configuracion->setTelContacto($_POST['tel_contacto']);
    $dao->guardarDatosBasicos($configuracion);      
}

/* Este bloque de código está verificando si el valor de `['funcion']` es igual a
`'guardarDatosEmail'`. Si es así, establece las propiedades del objeto `` con los
valores correspondientes de la matriz ``. Luego llama al método `guardarDatosEmail()` del
objeto ``, pasando como parámetro el objeto ``. Este método se encarga de guardar
los datos de configuración del correo electrónico en la base de datos. */
if ($_POST['funcion'] == 'guardarDatosEmail') {
    $configuracion->setDriver($_POST['driver']);
    $configuracion->setCifrado($_POST['cifrado']);
    $configuracion->setHost($_POST['host']);
    $configuracion->setPort($_POST['port']);
    $configuracion->setEmail($_POST['email']);
    $configuracion->setPassEmail($_POST['pass_email']);
    $dao->guardarDatosEmail($configuracion);
}


/* Este bloque de código maneja la funcionalidad para guardar una imagen de logotipo cargada. */
if ($_POST['funcion'] == 'guardarImagenLogo') {
    $respuesta = "";
    if (($_FILES['logo']['type'] == 'image/jpeg') || ($_FILES['logo']['type'] == 'image/png') || ($_FILES['logo']['type'] == 'image/gif')) {
        $imagen = uniqid() . "-" . $_FILES['logo']['name'];
        $ruta = '../Recursos/img/empresa/' . $imagen;
        if(move_uploaded_file($_FILES['logo']['tmp_name'], $ruta)){
            $dao->cargarInformacion();
            $logoOld = $dao->objetos[0]->logo;
            $configuracion->setLogo($imagen);
            $dao->guardarLogo($configuracion);
            unlink('../Recursos/img/empresa/'.$logoOld);
            $respuesta = "update";            
        }else{
            $respuesta = 'Error al guardar la imagen en el servidor';
        }
    } else {
        $respuesta = "El archivo seleccionado debe ser jpeg, png o gif";
    }
    echo $respuesta;
}

/* Este bloque de código maneja la funcionalidad para guardar una imagen de logotipo cargada. */
if ($_POST['funcion'] == 'guardarImagenLogoBlanco') {
    $respuesta = "";
    if (($_FILES['logo']['type'] == 'image/jpeg') || ($_FILES['logo']['type'] == 'image/png') || ($_FILES['logo']['type'] == 'image/gif')) {
        $imagen = uniqid() . "-" . $_FILES['logo']['name'];
        $ruta = '../Recursos/img/empresa/' . $imagen;
        if(move_uploaded_file($_FILES['logo']['tmp_name'], $ruta)){
            $dao->cargarInformacion();
            $logoOld = $dao->objetos[0]->logo_blanco;
            $configuracion->setLogoBlanco($imagen);
            $dao->guardarLogoBlanco($configuracion);
            unlink('../Recursos/img/empresa/'.$logoOld);
            $respuesta = "update";            
        }else{
            $respuesta = 'Error al guardar la imagen en el servidor';
        }
    } else {
        $respuesta = "El archivo seleccionado debe ser jpeg, png o gif";
    }
    echo $respuesta;
}

/* Este bloque de código maneja la funcionalidad para guardar una imagen de favicon cargada. */
if ($_POST['funcion'] == 'guardarFavicon') {
    $respuesta = "";
    if (($_FILES['faticon']['type'] == 'image/jpeg') || ($_FILES['faticon']['type'] == 'image/png') || ($_FILES['faticon']['type'] == 'image/gif')) {
        $imagen = uniqid() . "-" . $_FILES['faticon']['name'];
        $ruta = '../Recursos/img/empresa/' . $imagen;
        if(move_uploaded_file($_FILES['faticon']['tmp_name'], $ruta)){
            $dao->cargarInformacion();
            $logoOld = $dao->objetos[0]->faticon;
            $configuracion->setFavicon($imagen);
            $dao->guardarfaticon($configuracion);
            unlink('../Recursos/img/empresa/'.$logoOld);
            $respuesta = "update";
        }else{
            $respuesta = 'Error al guardar la imagen en el servidor';
        }
    } else {
        $respuesta = "El archivo seleccionado debe ser jpeg, png o gif";
    }
    echo $respuesta;
}

/* Este bloque de código maneja la funcionalidad para guardar una imagen de inicio de sesión cargada. */
if ($_POST['funcion'] == 'guardarLogin') {
    $respuesta = "";
    if (($_FILES['img_login']['type'] == 'image/jpeg') || ($_FILES['img_login']['type'] == 'image/png') || ($_FILES['img_login']['type'] == 'image/gif')) {
        $imagen = uniqid() . "-" . $_FILES['img_login']['name'];
        $ruta = '../Recursos/img/empresa/' . $imagen;
        if(move_uploaded_file($_FILES['img_login']['tmp_name'], $ruta)){
            $dao->cargarInformacion();
            $logoOld = $dao->objetos[0]->img_login;
            $configuracion->setImgLogin($imagen);
            $dao->guardarImgLogin($configuracion);
            unlink('../Recursos/img/empresa/'.$logoOld);
            $respuesta = "update";
        }else{
            $respuesta = 'Error al guardar la imagen en el servidor';
        }
    } else {
        $respuesta = "El archivo seleccionado debe ser jpeg, png o gif";
    }
    echo $respuesta;
}

/* 
* Elimina el logo de la empresa
*/
if ($_POST['funcion'] == 'eliminarLogo') {    
    $dao->cargarInformacion();
    $logoOld = $dao->objetos[0]->logo;
    unlink('../Recursos/img/empresa/'.$logoOld);
    $dao->eliminarLogo();
}

if ($_POST['funcion'] == 'eliminarLogoBlanco') {    
    $dao->cargarInformacion();
    $logoOld = $dao->objetos[0]->logo_blanco;
    unlink('../Recursos/img/empresa/'.$logoOld);
    $dao->eliminarLogoBlanco();
}

/* 
* Elimina el icono de la empresa
*/
if ($_POST['funcion'] == 'eliminarIcono') {
    $dao->cargarInformacion();
    $logoOld = $dao->objetos[0]->faticon;
    unlink('../Recursos/img/empresa/'.$logoOld);
    $dao->eliminarFaticon();
}

/* 
* Elimina la imagen de inicio del login de la empresa
*/
if ($_POST['funcion'] == 'eliminarImgLogin') {
    $dao->cargarInformacion();
    $logoOld = $dao->objetos[0]->img_login;
    unlink('../Recursos/img/empresa/'.$logoOld);
    $dao->eliminarImgLogin();
}

if ((isset($_GET['funcion']) && $_GET['funcion'] == 'reporteNotificaciones') || (isset($_POST['funcion']) && $_POST['funcion'] == 'reporteNotificaciones')) {
    $json = array();
    $envioDAO = new envioCorreoDAO();
    $envioDAO->reporteNotificaciones();
    foreach ($envioDAO->objetos as $objeto) {
        $json['data'][] = $objeto;
    }
    $jsonstring = json_encode($json, JSON_UNESCAPED_UNICODE);
    echo $jsonstring;
}

if (isset($_POST['funcion']) && $_POST['funcion'] == 'estadisticasNotificaciones') {
    $json = array();
    $envioDAO = new envioCorreoDAO();
    $envioDAO->estadisticasNotificaciones();
    foreach ($envioDAO->objetos as $objeto) {
        $json[] = array(
            'contratos' => $objeto->contratos,
            'incapacidades' => $objeto->incapacidades,
            'solicitudes' => $objeto->solicitudes,
        );
    }
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}