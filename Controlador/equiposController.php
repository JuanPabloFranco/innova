<?php
include_once '../Modelo/EquipoMantenimiento.php';
include_once '../Modelo/Equipo.php';
include_once '../DAO/equipoDAO.php';
$equipo = new Equipo();
$mantenimiento = new EquipoMantenimiento();
$dao = new equipoDAO();
session_start();

/* Este bloque de código verifica si el valor de la variable `['funcion']` es igual a `'buscar'`.
Si es así, realiza las siguientes acciones: 
Recorre el resultado de la consulta a la base de datos y los agrega a una lista en formato JSON
la cual se retorna
*/
if (isset($_POST['funcion']) && $_POST['funcion'] == 'listar') {
    $json = array();
    $dao->listar($_SESSION['equipos']['editar'], $_SESSION['equipos']['ver'],$_POST['id_empresa']);
    foreach ($dao->objetos as $objeto) {
        $json['data'][] = $objeto;
    }
    $jsonstring = json_encode($json, JSON_UNESCAPED_UNICODE);
    echo $jsonstring;
}

if (isset($_POST['funcion']) && $_POST['funcion'] == 'listar_empresa_usuario') {
    $json = array();
    $dao->listar($_SESSION['equipos']['editar'], $_SESSION['equipos']['ver'],$_SESSION['datos'][0]->id_empresa);
    foreach ($dao->objetos as $objeto) {
        $json['data'][] = $objeto;
    }
    $jsonstring = json_encode($json, JSON_UNESCAPED_UNICODE);
    echo $jsonstring;
}

/* Este bloque de código verifica si el valor de la variable `['funcion']` es igual a `'buscar'`.
Si es así, realiza las siguientes acciones: 
Recorre el resultado de la consulta a la base de datos y los agrega a una lista en formato JSON
la cual se retorna
*/
if ($_POST['funcion'] == 'cargar') {
    $json = array();
    $equipo->setId($_POST['id']);
    $dao->cargar($equipo);
    $json[] = array(
        'tipo_equipo' => $dao->objetos[0]->tipo_equipo,
        'ubicacion' => $dao->objetos[0]->ubicacion,
        'id_sede' => $dao->objetos[0]->id_sede,
        'serial' => $dao->objetos[0]->serial,
        'referencia' => $dao->objetos[0]->referencia,
        'procesador' => $dao->objetos[0]->procesador,
        'ram' => $dao->objetos[0]->ram,
        'disco_duro' => $dao->objetos[0]->disco_duro,
        'sistema_operativo' => $dao->objetos[0]->sistema_operativo,
        'teclado' => $dao->objetos[0]->teclado,
        'mouse' => $dao->objetos[0]->mouse,
        'monitor' => $dao->objetos[0]->monitor,
        'office' => $dao->objetos[0]->office,
        'pad_mouse' => $dao->objetos[0]->pad_mouse,
        'tipo_impresora' => $dao->objetos[0]->tipo_impresora,
        'codigo_maquina' => $dao->objetos[0]->codigo_maquina,
        'persona_a_cargo' => $dao->objetos[0]->persona_a_cargo,
        'estado' => $dao->objetos[0]->estado,
        'estado_general' => $dao->objetos[0]->estado_general,
        'observaciones' => $dao->objetos[0]->observaciones,
        'nombre_sede' => $dao->objetos[0]->nombre_sede,
        'direccion' => $dao->objetos[0]->direccion,
        'municipio' => $dao->objetos[0]->municipio,
        'departamento' => $dao->objetos[0]->departamento,
    );
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}

/* Este bloque de código verifica si el valor de la variable `['funcion']` es igual a
`'crear_modulo'`. Si es así, realiza las siguientes acciones:
Agregar al objeto inicializado los valores necesarios para el proceso, 
luego se ejecuta la funcion requerida a traves del DAO
*/
if ($_POST['funcion'] == 'crear') {
    $error = false;
    $type = "";
    $mensaje = "";
    $id = "";

    $equipo->setTipoEquipo($_POST['tipo_equipo']);
    $equipo->setUbicacion($_POST['ubicacion']);
    $equipo->setEstado(1);
    $equipo->setIdSede($_POST['id_sede']);
    $equipo->setEstadoGeneral(10);

    $id = $dao->crear($equipo); // Obtiene el ID del nuevo registro

    if ($id) {
        $type = "success";
        $mensaje = "Equipo creada correctamente";
    } else {
        $type = "error";
        $mensaje = "Error al crear el equipo";
        $error = true;
    }

    $respuesta[] = array(
        'error' => $error,
        'type' => $type,
        'id' => $id,
        'mensaje' => $mensaje
    );
    $jsonstring = json_encode($respuesta);
    echo $jsonstring;
}

/* Este bloque de código verifica si el valor de la variable `['funcion']` es igual a
`'crear_modulo'`. Si es así, realiza las siguientes acciones:
Agregar al objeto inicializado los valores necesarios para el proceso, 
luego se ejecuta la funcion requerida a traves del DAO
*/
if ($_POST['funcion'] == 'editar') {
    $error = false;
    $type = "";
    $mensaje = "";

    $equipo->setId($_POST['id_equipo']);
    $equipo->setTipoEquipo($_POST['tipo_equipo']);
    $equipo->setUbicacion($_POST['ubicacion']);
    $equipo->setIdSede($_POST['id_sede']);
    $equipo->setSerial($_POST['serial']);
    $equipo->setReferencia($_POST['referencia']);
    $equipo->setProcesador($_POST['procesador']);
    $equipo->setRam($_POST['ram']);
    $equipo->setDiscoDuro($_POST['disco_duro']);
    $equipo->setSistemaOperativo($_POST['sistema_operativo']);
    $equipo->setTeclado($_POST['teclado']);
    $equipo->setMouse($_POST['mouse']);
    $equipo->setMonitor($_POST['monitor']);
    $equipo->setOffice($_POST['office']);
    $equipo->setPadMouse($_POST['pad_mouse']);
    $equipo->setTipoImpresora($_POST['tipo_impresora']);
    $equipo->setCodigoMaquina($_POST['codigo_maquina']);
    $equipo->setPersonaACargo($_POST['persona_a_cargo']);
    $equipo->setEstadoGeneral($_POST['estado_general']);
    $equipo->setObservaciones($_POST['observaciones']);

    if ($dao->editar($equipo)) {
        $type = "success";
        $mensaje = "Equipo actualizada correctamente";
    } else {
        $type = "error";
        $mensaje = "Error al actualizar el equipo";
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

/* Este bloque de código está verificando si el valor de la variable `['funcion']` es igual a
`'cambiar_estado'`.  */
if ($_POST['funcion'] == 'cambiar_estado') {
    $error = false;
    $type = "";
    $mensaje = "";

    $equipo->setId($_POST['id']);
    $equipo->setEstado($_POST['estado']);
    if($dao->cambiar_estado($equipo)){
        $type = "success";
        $mensaje = "Estado actualizado correctamente";
    } else {
        $type = "error";
        $mensaje = "Error al actualizar el estado";
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

// Mantenimientos


/* Este bloque de código verifica si el valor de la variable `['funcion']` es igual a `'buscar'`.
Si es así, realiza las siguientes acciones: 
Recorre el resultado de la consulta a la base de datos y los agrega a una lista en formato JSON
la cual se retorna
*/
if (isset($_POST['funcion']) && $_POST['funcion'] == 'listar_mantenimientos') {

    $json = array();
    $mantenimiento->setIdEquipo($_POST['id_equipo']);
    $dao->listar_mantenimientos($_SESSION['equipos']['editar'], $_SESSION['equipos']['ver'], $mantenimiento);
    foreach ($dao->objetos as $objeto) {
        $json['data'][] = $objeto;
    }
    $jsonstring = json_encode($json, JSON_UNESCAPED_UNICODE);
    echo $jsonstring;
}

/* Este bloque de código verifica si el valor de la variable `['funcion']` es igual a `'buscar'`.
Si es así, realiza las siguientes acciones: 
Recorre el resultado de la consulta a la base de datos y los agrega a una lista en formato JSON
la cual se retorna
*/
if ($_POST['funcion'] == 'cargar_mantenimiento') {
    $json = array();
    $mantenimiento->setId($_POST['id']);
    $dao->cargar_mantenimiento($mantenimiento);
    $json[] = array(
        'fecha' => $dao->objetos[0]->fecha,
        'descripcion' => $dao->objetos[0]->descripcion,
        'tipo' => $dao->objetos[0]->tipo,
        'realizado_por' => $dao->objetos[0]->realizado_por,
        'observaciones' => $dao->objetos[0]->observaciones,
        'id_equipo' => $dao->objetos[0]->id_equipo,
        'nombre_tipo' => $dao->objetos[0]->nombre_tipo,
    );
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}

/* Este bloque de código verifica si el valor de la variable `['funcion']` es igual a
`'crear_modulo'`. Si es así, realiza las siguientes acciones:
Agregar al objeto inicializado los valores necesarios para el proceso, 
luego se ejecuta la funcion requerida a traves del DAO
*/
if ($_POST['funcion'] == 'crear_mantenimiento') {
    $error = false;
    $type = "";
    $mensaje = "";
    $id = "";

    $mantenimiento->setFecha($_POST['fecha']);
    $mantenimiento->setTipo($_POST['tipo']);
    $mantenimiento->setDescripcion($_POST['descripcion']);
    $mantenimiento->setRealizadoPor($_POST['realizado_por']);
    $mantenimiento->setObservaciones($_POST['observaciones']);
    $mantenimiento->setIdEquipo($_POST['id_equipo']);

    if ($dao->crear_mantenimiento($mantenimiento)) {
        $type = "success";
        $mensaje = "Mantenimiento registrado ";
    } else {
        $type = "error";
        $mensaje = "Error al registrar el mantenimiento";
        $error = true;
    }

    $respuesta[] = array(
        'error' => $error,
        'type' => $type,
        'id' => $id,
        'mensaje' => $mensaje
    );
    $jsonstring = json_encode($respuesta);
    echo $jsonstring;
}

/* Este bloque de código verifica si el valor de la variable `['funcion']` es igual a
`'crear_modulo'`. Si es así, realiza las siguientes acciones:
Agregar al objeto inicializado los valores necesarios para el proceso, 
luego se ejecuta la funcion requerida a traves del DAO
*/
if ($_POST['funcion'] == 'editar_mantenimiento') {
    $error = false;
    $type = "";
    $mensaje = "";

    $mantenimiento->setId($_POST['id']);
    $mantenimiento->setFecha($_POST['fecha']);
    $mantenimiento->setTipo($_POST['tipo']);
    $mantenimiento->setDescripcion($_POST['descripcion']);
    $mantenimiento->setRealizadoPor($_POST['realizado_por']);
    $mantenimiento->setObservaciones($_POST['observaciones']);

    if ($dao->editar_mantenimiento($mantenimiento)) {
        $type = "success";
        $mensaje = "Mantenimiento actualizada correctamente";
    } else {
        $type = "error";
        $mensaje = "Error al actualizar la el mantenimiento";
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
