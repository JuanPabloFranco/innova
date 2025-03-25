<?php
session_start();
include_once '../Modelo/Usuario.php';
include_once '../DAO/usuarioDAO.php';

$usuario = new Usuario();
$dao = new UsuarioDAO();
date_default_timezone_set('America/Bogota');

/* El código anterior verifica si el valor de la clave 'función' en la matriz  es igual a
'buscarAvatar'. Si es así, llama al método 'buscar_avatar' del objeto , pasando el id almacenado
en ['datos'][0]->id. Luego crea una matriz JSON con un solo elemento, que contiene la clave
'avatar' con el valor '../Recursos/img/avatars/' concatenado con el valor de
->objetos[0]->avatar. Finalmente, codifica la matriz JSON en una cadena y la repite. */
if ($_POST['funcion'] == 'buscarAvatar') {
    $json = array();
    $dao->buscar_avatar($_SESSION['datos'][0]->id);
    $json[] = array(
        'avatar' => '../Recursos/img/avatars/' . $dao->objetos[0]->avatar
    );
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}

/* El código anterior verifica si el valor de la clave 'funcion' en la matriz  es igual a
'buscar_gestion_usuario_full'. Si es así, realiza las siguientes acciones: 
* Busca todos los usuarios del sistema y los retorna en una lista JSON, el resultado puede variar segun el cargo
*/
if ($_POST['funcion'] == 'buscar_gestion_usuario_full') {
    $json = array();
    $fecha_actual = new DateTime();
    // trae los datos de los usuarios desde la base de datos en la base de datos, se envia el cargo en caso de que sea 4 este solo traiga los usuarios activos
    $dao->buscar_datos_adm_full($_POST['id_cargo']);
    foreach ($dao->objetos as $objeto) {
        // se anexa al objeto usuario el id
        $usuario->setId($objeto->id);
        // se buscan todas las conexiones al sistema de cada usuario
        $conexiones = $dao->conexiones_usuario($usuario);
        $fecha = 'N/A';
        $hora = '';
        if (count($conexiones) > 0) {
            $fecha = $conexiones[0]->fecha;
            $hora = $conexiones[0]->hora;
        }
        // if ($dao) {
        // }
        $nac = new DateTime($objeto->fecha_nacimiento);
        $edad = $nac->diff($fecha_actual);
        $edad_years = $edad->y;
        $json[] = array(
            'id' => $objeto->id,
            'nombre_completo' => $objeto->nombre_completo,
            'edad' => $edad_years,
            'fecha_nacimiento' => $objeto->fecha_nacimiento,
            'telefono' => $objeto->telefono,
            'id_empresa' => $objeto->id_empresa,
            'nombre_empresa' => $objeto->nombre_empresa,
            'direccion' => $objeto->direccion,
            'genero' => $objeto->genero,
            'email' => $objeto->email,
            'nombre_tipo' => $objeto->nombre_tipo,
            'tipo_usuario' => $objeto->id_tipo_usuario,
            'avatar' => '../Recursos/img/avatars/' . $objeto->avatar,
            'nombre_cargo' => $objeto->nombre_cargo,
            'tiktok' => $objeto->tiktok,
            'facebook' => $objeto->facebook,
            'instagram' => $objeto->instagram,
            'youtube' => $objeto->youtube,
            'estado' => $objeto->estado,
            'municipio' => $objeto->municipio,
            'departamento' => $objeto->departamento,
            'inf_usuario' => $objeto->inf_usuario,
            'fecha' => $fecha,
            'hora' => $hora
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

/* El código anterior verifica si la función 'crear_usuario' está siendo llamada a través de una
solicitud POST. Si es así, comprueba si los campos 'documento' y 'email' no están vacíos. Si no
están vacíos, crea un nuevo objeto de usuario y establece sus propiedades utilizando los valores de
la solicitud POST. Luego verifica si ya existe un usuario con el mismo correo electrónico o ID de
documento en la base de datos. Si existe un usuario con el mismo correo electrónico o ID de
documento, muestra un mensaje indicándolo. De lo contrario, establece las propiedades restantes del
objeto de usuario, como nombre, teléfono */
if ($_POST['funcion'] == 'crear_usuario') {
    $error = false;
    $type = "";
    $mensaje = "";

    if ($_POST['documento'] <> "" || $_POST['email'] <> "") {
        $usuario->setDocId($_POST['documento']);
        $usuario->setEmail($_POST['email']);
        $dao->buscar_usuario_existente($usuario);
        $cantidad = $dao->buscar_usuario_existente($usuario);
        if ($cantidad == 0) {
            $usuario->setNombreCompleto($_POST['nombre_completo']);
            $usuario->setTelefono($_POST['telefono']);
            $usuario->setIdTipoUsuario($_POST['id_tipo_usuario']);
            $usuario->setIdCargo($_POST['id_cargo']);
            $usuario->setEstado(1);
            $usuario->setAvatar('avatar_default.png');
            $usuario->setPassLogin(md5($_POST['documento']));
            $usuario->setUsuarioLogin($_POST['email']);
            $usuario->setIdEmpresa($_POST['id_empresa']);
            date_default_timezone_set('America/Bogota');
            $usuario->setFechaCreacion(date('Y-m-d h:i:s', time()));
            if ($dao->crear_usuario($usuario)) {
                $type = "success";
                $mensaje = "Usuario registrado correctamente";
            } else {
                $type = "error";
                $mensaje = "Error al registrar el usuario";
                $error = true;
            }
        } else {
            $type = "info";
            $mensaje = "Ya existe un usuario con el mismo email o documento de identidad";
            $error = true;
        }
    } else {
        $type = "info";
        $mensaje = "El documento de identidad y el email son obligatorios";
        $error = true;
    }

    $respuesta[] = array(
        'error' => $error,
        'type' => $type,
        'mensaje' => $mensaje
    );
    $jsonstring = json_encode($respuesta);
    echo $jsonstring;
}

/* El código anterior verifica si el valor de la clave 'función' en la matriz  es igual a
'activación'. Si es así, establece las propiedades id, passLogin y estado del objeto  usando
los valores correspondientes de la matriz . Luego llama al método de activación del objeto
, pasando el objeto  y la propiedad id del primer elemento del array ['datos']
como argumentos. */
if ($_POST['funcion'] == 'activacion') {
    $usuario->setId($_POST['id']);
    $usuario->setPassLogin(md5($_POST['pass']));
    $usuario->setEstado($_POST['estado']);
    $dao->activacion($usuario, $_SESSION['datos'][0]->id);
}

/* El código anterior verifica si el valor de la clave 'funcion' en la matriz  es igual a
'retablecer_login'. Si es así, establece las propiedades id y passLogin del objeto  usando
los valores de la matriz . Luego llama al método restablecer_login del objeto , pasando el
objeto  y el valor de id del array  como parámetros. */
if ($_POST['funcion'] == 'restablecer_login') {
    $usuario->setId($_POST['id']);
    $usuario->setPassLogin(md5($_POST['pass']));
    $dao->restablecer_login($usuario, $_SESSION['datos'][0]->id);
}

/* El código anterior verifica si el valor de la clave 'función' en la matriz  es igual a
'cargarCc'. Si es así, procede a ejecutar el código dentro de la declaración if. */
if ($_POST['funcion'] == 'cargarCc') {
    $json = array();
    $usuario->setId($_POST['id']);
    $dao->cargarCc($usuario);
    $json[] = array(
        'doc_id' => $dao->objetos[0]->doc_id,
        'id_tipo_usuario' => $dao->objetos[0]->id_tipo_usuario,
        'id_cargo' => $dao->objetos[0]->id_cargo,
        'nombre_completo' => $dao->objetos[0]->nombre_completo,
        'id_empresa' => $dao->objetos[0]->id_empresa,
    );
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}

/* El código anterior verifica si el valor de la clave 'función' en la matriz  es igual a
'update_cc'. Si es así, establece las propiedades del objeto  con los valores del array
 y llama al método update_cc del objeto , pasando el objeto  como parámetro. */
if ($_POST['funcion'] == 'update_cc') {
    $usuario->setId($_POST['id']);
    $usuario->setDocId($_POST['doc']);
    $usuario->setIdCargo($_POST['id_cargo']);
    $usuario->setIdTipoUsuario($_POST['id_tipo_usuario']);
    $usuario->setIdEmpresa($_POST['id_empresa']);
    $dao->update_cc($usuario);
}

/* El código anterior verifica si el valor de la clave 'función' en la matriz  es igual a
'cargarUserFull'. Si es así, procede a recuperar los datos del usuario de la base de datos
utilizando el método cargarUserFull del objeto . Luego crea una matriz JSON con los datos
recuperados y los repite como una cadena JSON. */
if ($_POST['funcion'] == 'cargarUserFull') {
    $json = array();
    $usuario->setId($_POST['id']);
    $dao->cargarUserFull($usuario);
    $json[] = array(
        'conexion' => $dao->objetos[0]->conexion,
        'nombre_tipo' => $dao->objetos[0]->nombre_tipo,
        'avatar' => '../Recursos/img/avatars/' . $dao->objetos[0]->avatar,
        'nombre_completo' => $dao->objetos[0]->nombre_completo,
        'id_sede' => $dao->objetos[0]->id_sede,
        'id_area' => $dao->objetos[0]->id_area,
        'id_cargo' => $dao->objetos[0]->id_cargo,
        'nombre_area' => $dao->objetos[0]->nombre_area,
        'nombre_sede' => $dao->objetos[0]->nombre_sede,
        'direccion' => $dao->objetos[0]->direccion,
        'municipio' => $dao->objetos[0]->municipio,
        'depto' => $dao->objetos[0]->depto,
        'telefono' => $dao->objetos[0]->telefono,
        'fecha_nacimiento' => $dao->objetos[0]->fecha_nacimiento,
        'edad' => $dao->objetos[0]->edad,
        'genero' => $dao->objetos[0]->genero,
        'doc_id' => $dao->objetos[0]->doc_id,
        'email' => $dao->objetos[0]->email,
        'estado' => $dao->objetos[0]->estado,
        'fecha_creacion' => $dao->objetos[0]->fecha_creacion,
        'facebook' => $dao->objetos[0]->facebook,
        'instagram' => $dao->objetos[0]->instagram,
        'youtube' => $dao->objetos[0]->youtube,
        'tiktok' => $dao->objetos[0]->tiktok,
        'inf_usuario' => $dao->objetos[0]->inf_usuario,
        'nombre_cargo' => $dao->objetos[0]->nombre_cargo,
        'id_tipo_usuario' => $dao->objetos[0]->id_tipo_usuario,
        'firma_digital' => $dao->objetos[0]->firma_digital,
        'usuario_login' => $dao->objetos[0]->usuario_login,
        'descripcion' => $dao->objetos[0]->descripcion,
        'nombre_cargo' => $dao->objetos[0]->nombre_cargo,
        'ciudad_residencia' => $dao->objetos[0]->ciudad_residencia,
        'contacto_emergencia' => $dao->objetos[0]->contacto_emergencia,
        'parentezco_contacto' => $dao->objetos[0]->parentezco_contacto,
        'telefono_contacto' => $dao->objetos[0]->telefono_contacto,
        'eps' => $dao->objetos[0]->eps,
        'tipo_sangre' => $dao->objetos[0]->tipo_sangre,
        'nivel_academico' => $dao->objetos[0]->nivel_academico,
        'profesion' => $dao->objetos[0]->profesion,
        'experiencia' => $dao->objetos[0]->experiencia,
        'fondo' => $dao->objetos[0]->fondo,
        'cesantias' => $dao->objetos[0]->cesantias,
        'nombre_madre' => $dao->objetos[0]->nombre_madre,
        'telefono_madre' => $dao->objetos[0]->telefono_madre,
        'nombre_padre' => $dao->objetos[0]->nombre_padre,
        'telefono_padre' => $dao->objetos[0]->telefono_padre,
        'estrato' => $dao->objetos[0]->estrato,
        'estado_civil' => $dao->objetos[0]->estado_civil,
        'grupo_etnico' => $dao->objetos[0]->grupo_etnico,
        'personas_cargo' => $dao->objetos[0]->personas_cargo,
        'cabeza_familia' => $dao->objetos[0]->cabeza_familia,
        'hijos' => $dao->objetos[0]->hijos,
        'fuma' => $dao->objetos[0]->fuma,
        'fuma_frecuencia' => $dao->objetos[0]->fuma_frecuencia,
        'bebidas' => $dao->objetos[0]->bebidas,
        'bebidas_frecuencia' => $dao->objetos[0]->bebidas_frecuencia,
        'deporte' => $dao->objetos[0]->deporte,
        'talla_camisa' => $dao->objetos[0]->talla_camisa,
        'talla_pantalon' => $dao->objetos[0]->talla_pantalon,
        'talla_calzado' => $dao->objetos[0]->talla_calzado,
        'tipo_vivienda' => $dao->objetos[0]->tipo_vivienda,
        'licencia_conduccion' => $dao->objetos[0]->licencia_conduccion,
        'licencia_descr' => $dao->objetos[0]->licencia_descr,
        'act_tiempo_libre' => $dao->objetos[0]->act_tiempo_libre,
    );
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'listarActivos') {
    $json = array();
    $dao->listarActivos();
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'avatar' => '../Recursos/img/avatars/' . $objeto->avatar,
            'nombre_completo' => $objeto->nombre_completo,
            'doc_id' => $objeto->doc_id,
            'id' => $objeto->id,
            'email' => $objeto->email,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

/* El código anterior verifica si el valor de la clave 'función' en la matriz  es igual a
'conexiones_usuario'. Si es así, establece la identificación del objeto  al valor de la
clave 'id' en la matriz . Luego llama al método conexiones_usuario del objeto , pasando el
objeto . */
if ($_POST['funcion'] == 'conexiones_usuario') {
    $usuario->setId($_POST['id']);
    $dao->conexiones_usuario($usuario);
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'fecha' => $objeto->fecha,
            'hora' => $objeto->hora,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

/* El código anterior verifica si el valor de la clave 'funcion' en la matriz  es igual a
'editar_usuario'. Si es así, establece varias propiedades del objeto  usando los valores de
la matriz . Finalmente llama al método 'editar_usuario' del objeto , pasando el objeto
 como parámetro. */
if ($_POST['funcion'] == 'editar_usuario') {
    $usuario->setId($_POST['id_usuario']);
    $usuario->setNombreCompleto($_POST['nombre']);
    $usuario->setDocId($_POST['doc_id']);
    $usuario->setFechaNacimiento($_POST['fecha_nacimiento']);
    $usuario->setGenero($_POST['genero']);
    $usuario->setTelefono($_POST['telefono']);
    $usuario->setEmail($_POST['email']);
    $usuario->setDireccion($_POST['direccion']);
    $usuario->setCiudadResidencia($_POST['ciudad_residencia']);
    $usuario->setInfUsuario($_POST['inf_usuario']);
    $dao->editar_usuario($usuario);
}

/* El código anterior verifica si el valor de la clave 'función' en la matriz  es igual a
'changePass'. Si es así, recupera los valores de 'nameUser', 'id_usuario', 'oldpass' y 'newpass' de
la matriz . Luego utiliza la función md5 para codificar los valores 'oldpass' y 'newpass'.
Finalmente, llama al método 'update_pass' del objeto , pasando los valores 'id_usuario',
'nameUser', 'oldpass' y 'newpass' como argumentos. */
if ($_POST['funcion'] == 'changePass') {
    $nameUser = $_POST['nameUser'];
    $id_usuario = $_POST['id_usuario'];
    $oldpass = md5($_POST['oldpass']);
    $newpass = md5($_POST['newpass']);
    $dao->update_pass($id_usuario, $nameUser, $oldpass, $newpass);
}

/* El código anterior maneja una solicitud POST para cambiar el avatar del usuario. */
if ($_POST['funcion'] == 'changeAvatar') {
    $usuario->setId($_POST['id_usuario']);
    if (($_FILES['avatar']['type'] == 'image/jpeg') || ($_FILES['avatar']['type'] == 'image/png') || ($_FILES['avatar']['type'] == 'image/gif')) {
        $avatar = uniqid() . "-" . $_FILES['avatar']['name'];
        $ruta = '../Recursos/img/avatars/' . $avatar;
        move_uploaded_file($_FILES['avatar']['tmp_name'], $ruta);
        $usuario->setAvatar($avatar);
        $dao->cambiar_avatar($usuario);
        foreach ($dao->objetos as $objeto) {
            if ($objeto->avatar <> 'avatar_default.png') {
                unlink('../Recursos/img/avatars/' . $objeto->avatar);
            }
        }
        $json = array();
        $json[] = array(
            'ruta' => $ruta,
            'alert' => 'edit'
        );
        $jsonstring = json_encode($json[0]);
        echo $jsonstring;
    } else {
        $json = array();
        $json[] = array(
            'alert' => 'noedit'
        );
        $jsonstring = json_encode($json[0]);
        echo $jsonstring;
    }
}

/* El código anterior verifica si el valor de la clave 'función' en la matriz  es igual a
'cambiarFirma'. Si es así, realiza las siguientes acciones: 
* cambia la firma digital guardada en el servidor, se elimina la anterior
*/
if ($_POST['funcion'] == 'changeFirma') {
    $usuario->setId($_SESSION['datos'][0]->id);
    $firma = uniqid() . "-" . $_FILES['firma_digital']['name'];
    $usuario->setFirmaDigital($firma);
    $ruta = '../Recursos/img/firmas/' . $firma;
    move_uploaded_file($_FILES['firma_digital']['tmp_name'], $ruta);
    $dao->cambiar_firma($usuario);
    foreach ($dao->objetos as $objeto) {
        if ($objeto->firma_digital <> "" && $objeto->firma_digital <> NULL) {
            unlink('../Recursos/img/firmas/' . $objeto->firma_digital);
        }
    }
    echo 'update';
}

if ($_POST['funcion'] == 'buscar_datos_general') {
    $json = array();
    $dao->buscar_datos_gerente();
    foreach ($dao->objetos as $objeto) {
        $nac = new DateTime($objeto->fecha_nac);
        $edad = $nac->diff($fecha_actual);
        $edad_years = $edad->y;
        $json[] = array(
            'id' => $objeto->id,
            'nombre_completo' => $objeto->nombre_completo,
            'telefono' => $telefono,
            'email' => $objeto->email
        );
    }
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'actualizarMenu') {
    $usuario->setId($_SESSION['datos'][0]->id);
    $dao->buscar_menu($usuario);
    if ($dao->objetos[0]->menu == 0) {
        $menu = 1;
    } else {
        $menu = 0;
    }
    $usuario->setMenu($menu);
    $dao->actualizar_menu($usuario);
}

if ($_POST['funcion'] == 'buscar_menu') {
    $usuario->setId($_SESSION['datos'][0]->id);
    $json = array();
    $dao->buscar_menu($usuario);
    $json[] = array(
        'menu' => $dao->objetos[0]->menu
    );
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}


if ($_POST['funcion'] == 'actualizarCalendario') {
    $usuario->setId($_SESSION['datos'][0]->id);
    $usuario->setCalendar($_POST['tipo']);
    $dao->actualizar_calendario($usuario);
}


if ($_POST['funcion'] == 'buscar_calendar') {
    $usuario->setId($_SESSION['datos'][0]->id);
    $json = array();
    $dao->buscar_calendario($usuario);
    $json[] = array(
        'calendar' => $dao->objetos[0]->calendar
    );
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'editar_salud') {
    $usuario->setId($_POST['id_usuario']);
    $usuario->setEps($_POST['eps']);
    $usuario->setTipoSangre($_POST['tipo_sangre']);
    $usuario->setContactoEmergencia($_POST['contacto_emergencia']);
    $usuario->setParentezcoContacto($_POST['parentezco_contacto']);
    $usuario->setTelefonoContacto($_POST['telefono_contacto']);
    $dao->editar_salud($usuario);
}

if ($_POST['funcion'] == 'editar_academica_laboral') {
    $usuario->setId($_POST['id_usuario']);
    $usuario->setNivelAcademico($_POST['nivel_academico']);
    $usuario->setProfesion($_POST['profesion']);
    $usuario->setExperiencia($_POST['experiencia']);
    $usuario->setFondo($_POST['fondo']);
    $usuario->setCesantias($_POST['cesantias']);

    $dao->editar_academico($usuario);
}

if ($_POST['funcion'] == 'editar_familiar') {
    $usuario->setId($_POST['id_usuario']);
    $usuario->setNombreMadre($_POST['nombre_madre']);
    $usuario->setTelefonoMadre($_POST['telefono_madre']);
    $usuario->setNombrePadre($_POST['nombre_padre']);
    $usuario->setTelefonoPadre($_POST['telefono_padre']);
    $dao->editar_familiar($usuario);
}

if ($_POST['funcion'] == 'editar_sociodemografica') {
    $usuario->setId($_POST['id_usuario']);
    $usuario->setEstrato($_POST['estrato']);
    $usuario->setEstadoCivil($_POST['estado_civil']);
    $usuario->setGrupoEtnico($_POST['grupo_etnico']);
    $usuario->setPersonasCargo($_POST['personas_cargo']);
    $usuario->setCabezaFamilia($_POST['cabeza_familia']);
    $usuario->setHijos($_POST['hijos']);
    $usuario->setFuma($_POST['fuma']);
    $usuario->setFumaFrecuencia($_POST['fuma_frecuencia']);
    $usuario->setBebidas($_POST['bebidas']);
    $usuario->setBebidasFrecuencia($_POST['bebidas_frecuencia']);
    $usuario->setDeporte($_POST['deporte']);
    $usuario->setTallaCamisa($_POST['talla_camisa']);
    $usuario->setTallaPantalon($_POST['talla_pantalon']);
    $usuario->setTallaCalzado($_POST['talla_calzado']);
    $usuario->setTipoVivienda($_POST['tipo_vivienda']);
    $usuario->setLicenciaConduccion($_POST['licencia_conduccion']);
    $usuario->setDescripcionLicencia($_POST['licencia_descr']);
    $usuario->setActTiempoLibre($_POST['act_tiempo_libre']);

    $dao->editar_sociodemografico($usuario);
}

//Personas a cargo

if ($_POST['funcion'] == 'crear_persona_cargo') {
    include_once '../Modelo/PersonaCargo.php';
    $persona = new PersonaCargo();

    $persona->setIdUsuario($_POST['id_usuario']);
    $persona->setNombre($_POST['nombre']);
    $persona->setFechaNac($_POST['fecha_nac']);
    $persona->setParentezco($_POST['parentezco']);

    $dao->crear_persona_a_cargo($persona);
}

if ($_POST['funcion'] == 'eliminar_persona_a_cargo') {
    include_once '../Modelo/PersonaCargo.php';
    $persona = new PersonaCargo();

    $persona->setId($_POST['id']);

    $dao->eliminar_persona_a_cargo($persona);
}

if ($_POST['funcion'] == 'listar_persona_a_cargo') {
    include_once '../Modelo/PersonaCargo.php';
    $persona = new PersonaCargo();

    $persona->setIdUsuario($_POST['id_usuario']);

    $dao->listar_persona_a_cargo($persona);
    $fecha_actual = new DateTime();
    $json = array();
    foreach ($dao->objetos as $objeto) {
        $nac = new DateTime($objeto->fecha_nac);
        $edad = $nac->diff($fecha_actual);
        $edad_years = $edad->y;
        $json[] = array(
            'id' => $objeto->id,
            'edad' => $edad_years,
            'nombre' => $objeto->nombre,
            'fecha_nac' => $objeto->fecha_nac,
            'parentezco' => $objeto->parentezco
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

//Medicamentos

//Personas a cargo

if ($_POST['funcion'] == 'crear_medicamento') {
    include_once '../Modelo/Medicamento.php';
    $medicamento = new Medicamento();

    $medicamento->setIdUsuario($_POST['id_usuario']);
    $medicamento->setNombre($_POST['nombre']);
    $medicamento->setIndicaciones($_POST['indicaciones']);

    $dao->crear_medicamentos($medicamento);
}

if ($_POST['funcion'] == 'eliminar_medicamento') {
    include_once '../Modelo/Medicamento.php';
    $medicamento = new Medicamento();

    $medicamento->setId($_POST['id']);

    $dao->eliminar_medicamentos($medicamento);
}

if ($_POST['funcion'] == 'listar_medicamentos') {
    include_once '../Modelo/Medicamento.php';
    $medicamento = new Medicamento();

    $medicamento->setIdUsuario($_POST['id_usuario']);

    $dao->listar_medicamentos($medicamento);
    $json = array();
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'nombre' => $objeto->nombre,
            'indicaciones' => $objeto->indicaciones,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

//Enfermedades
if ($_POST['funcion'] == 'crear_enfermedad') {
    include_once '../Modelo/Enfermedad.php';
    $enfermedad = new Enfermedad();

    $enfermedad->setIdUsuario($_POST['id_usuario']);
    $enfermedad->setNombre($_POST['nombre']);

    $dao->crear_enfermedades($enfermedad);
}

if ($_POST['funcion'] == 'eliminar_enfermedad') {
    include_once '../Modelo/Enfermedad.php';
    $enfermedad = new Enfermedad();

    $enfermedad->setId($_POST['id']);

    $dao->eliminar_enfermedades($enfermedad);
}

if ($_POST['funcion'] == 'listar_enfermedad') {
    include_once '../Modelo/Enfermedad.php';
    $enfermedad = new Enfermedad();

    $enfermedad->setIdUsuario($_POST['id_usuario']);

    $dao->listar_enfermedades($enfermedad);

    $json = array();
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'nombre' => $objeto->nombre,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

//Alergia
if ($_POST['funcion'] == 'crear_alergia') {
    include_once '../Modelo/Alergia.php';
    $alergia = new Alergia();

    $alergia->setIdUsuario($_POST['id_usuario']);
    $alergia->setNombre($_POST['nombre']);
    $alergia->setTipo($_POST['tipo']);

    $dao->crear_alergias($alergia);
}

if ($_POST['funcion'] == 'eliminar_alergia') {
    include_once '../Modelo/Alergia.php';
    $alergia = new Alergia();

    $alergia->setId($_POST['id']);

    $dao->eliminar_alergias($alergia);
}

if ($_POST['funcion'] == 'listar_alergia') {
    include_once '../Modelo/Alergia.php';
    $alergia = new Alergia();

    $alergia->setIdUsuario($_POST['id_usuario']);

    $dao->listar_alergias($alergia);

    $json = array();
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'tipo' => $objeto->tipo,
            'nombre' => $objeto->nombre,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

// Cirugias
if ($_POST['funcion'] == 'crear_cirugia') {
    include_once '../Modelo/Cirugia.php';
    $cirugia = new Cirugia();

    $cirugia->setIdUsuario($_POST['id_usuario']);
    $cirugia->setNombre($_POST['nombre']);

    $dao->crear_cirugia($cirugia);
}

if ($_POST['funcion'] == 'eliminar_cirugia') {
    include_once '../Modelo/Cirugia.php';
    $cirugia = new Cirugia();

    $cirugia->setId($_POST['id']);

    $dao->eliminar_cirugia($cirugia);
}

if ($_POST['funcion'] == 'listar_cirugia') {
    include_once '../Modelo/Cirugia.php';
    $cirugia = new Cirugia();

    $cirugia->setIdUsuario($_POST['id_usuario']);

    $dao->listar_cirugias($cirugia);

    $json = array();
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'nombre' => $objeto->nombre,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

// Lesiones
if ($_POST['funcion'] == 'crear_lesion') {
    include_once '../Modelo/Lesion.php';
    $lesion = new Lesion();

    $lesion->setIdUsuario($_POST['id_usuario']);
    $lesion->setNombre($_POST['nombre']);
    $lesion->setTipo($_POST['tipo']);

    $dao->crear_lesion($lesion);
}

if ($_POST['funcion'] == 'eliminar_lesion') {
    include_once '../Modelo/Lesion.php';
    $lesion = new Lesion();

    $lesion->setId($_POST['id']);

    $dao->eliminar_lesion($lesion);
}

if ($_POST['funcion'] == 'listar_lesion') {
    include_once '../Modelo/Lesion.php';
    $lesion = new Lesion();

    $lesion->setIdUsuario($_POST['id_usuario']);

    $dao->listar_lesion($lesion);

    $json = array();
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'tipo' => $objeto->tipo,
            'nombre' => $objeto->nombre,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

// Antecedentes
if ($_POST['funcion'] == 'crear_antecedente') {
    include_once '../Modelo/Antecedente.php';
    $antecedente = new Antecedente();

    $antecedente->setIdUsuario($_POST['id_usuario']);
    $antecedente->setNombre($_POST['nombre']);

    $dao->crear_antecedente($antecedente);
}

if ($_POST['funcion'] == 'eliminar_antecedente') {
    include_once '../Modelo/Antecedente.php';
    $antecedente = new Antecedente();

    $antecedente->setId($_POST['id']);

    $dao->eliminar_antecedente($antecedente);
}

if ($_POST['funcion'] == 'listar_antecedente') {
    include_once '../Modelo/Antecedente.php';
    $antecedente = new Antecedente();

    $antecedente->setIdUsuario($_POST['id_usuario']);

    $dao->listar_antecedente($antecedente);

    $json = array();
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'nombre' => $objeto->nombre,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

// Estudios
if ($_POST['funcion'] == 'crear_estudio') {
    include_once '../Modelo/Estudio.php';
    $estudio = new Estudio();

    $estudio->setIdUsuario($_POST['id_usuario']);
    $estudio->setNivel($_POST['nivel']);
    $estudio->setTipoNivel($_POST['tipo_nivel']);
    $estudio->setTitulo($_POST['titulo']);
    $estudio->setInstitucion($_POST['institucion']);
    $estudio->setAño($_POST['año']);
    $estudio->setCiudad($_POST['ciudad']);

    $dao->crear_estudio($estudio);
}

if ($_POST['funcion'] == 'eliminar_estudio') {
    include_once '../Modelo/Estudio.php';
    $estudio = new Estudio();

    $estudio->setId($_POST['id']);

    $dao->eliminar_estudio($estudio);
}

if ($_POST['funcion'] == 'listar_estudio') {
    include_once '../Modelo/Estudio.php';
    $estudio = new Estudio();

    $estudio->setIdUsuario($_POST['id_usuario']);

    $dao->listar_estudio($estudio);

    $json = array();
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'nivel' => $objeto->nivel,
            'tipo_nivel' => $objeto->tipo_nivel,
            'titulo' => $objeto->titulo,
            'institucion' => $objeto->institucion,
            'ano' => $objeto->ano,
            'ciudad' => $objeto->ciudad,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

//Cursos
if ($_POST['funcion'] == 'crear_curso') {
    include_once '../Modelo/Curso.php';
    $curso = new Curso();

    $curso->setIdUsuario($_POST['id_usuario']);
    $curso->setFecha($_POST['fecha']);
    $curso->setInstitucion($_POST['institucion']);
    $curso->setDescripcion($_POST['descripcion']);
    $curso->setHoras($_POST['horas']);

    $dao->crear_curso($curso);
}

if ($_POST['funcion'] == 'eliminar_curso') {
    include_once '../Modelo/Curso.php';
    $curso = new Curso();

    $curso->setId($_POST['id']);

    $dao->eliminar_curso($curso);
}

if ($_POST['funcion'] == 'listar_curso') {
    include_once '../Modelo/Curso.php';
    $curso = new Curso();

    $curso->setIdUsuario($_POST['id_usuario']);

    $dao->listar_curso($curso);

    $json = array();
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'fecha' => $objeto->fecha,
            'institucion' => $objeto->institucion,
            'horas' => $objeto->horas,
            'descripcion' => $objeto->descripcion,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

if ((isset($_GET['funcion']) && $_GET['funcion'] == 'reporteGeneral') || (isset($_POST['funcion']) && $_POST['funcion'] == 'reporteGeneral')) {
    $json = array();

    $dao->reporteGeneral();
    foreach ($dao->objetos as $objeto) {
        $json['data'][] = $objeto;
    }
    $jsonstring = json_encode($json, JSON_UNESCAPED_UNICODE);
    echo $jsonstring;
}

if (isset($_POST['funcion']) && $_POST['funcion'] == 'estadisticas') {
    $json = array();
    $dao->estadisticas();
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'activos' => $objeto->activos,
            'incapacidades' => $objeto->incapacidades,
            'solicitudes' => $objeto->solicitudes,
            'asistencia' => $objeto->asistencia,
        );
    }
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}
