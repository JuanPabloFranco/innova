<?php
include_once '../Modelo/Empresa.php';
include_once '../Modelo/Sedes.php';
include_once '../DAO/empresaDAO.php';
$empresa = new Empresa();
$sedes = new Sedes();
$dao = new empresaDAO();
session_start();

/* Este bloque de código verifica si el valor de la variable `['funcion']` es igual a `'buscar'`.
Si es así, realiza las siguientes acciones: 
Recorre el resultado de la consulta a la base de datos y los agrega a una lista en formato JSON
la cual se retorna
*/
if (isset($_POST['funcion']) && $_POST['funcion'] == 'listar') {
    $json = array();
    $dao->listar($_SESSION['empresas']['editar'], $_SESSION['empresas']['ver']);
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
    $empresa->setId($_POST['id']);
    $dao->cargar($empresa);
    $json[] = array(
        'nombre' => $dao->objetos[0]->nombre,
        'direccion' => $dao->objetos[0]->direccion,
        'telefono' => $dao->objetos[0]->telefono,
        'id_municipio' => $dao->objetos[0]->id_municipio,
        'municipio' => $dao->objetos[0]->municipio,
        'departamento' => $dao->objetos[0]->departamento,
        'email' => $dao->objetos[0]->email,
        'estado' => $dao->objetos[0]->estado,
        'logo' => $dao->objetos[0]->logo,
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

    $empresa->setNombre($_POST['nombre']);
    $empresa->setDireccion($_POST['direccion']);
    $empresa->setEstado(1);
    $empresa->setTelefono($_POST['telefono']);
    $empresa->setIdMunicipio($_POST['id_municipio']);
    $empresa->setEmail($_POST['email']);
    $empresa->setLogo("logo_default.png");

    $id = $dao->crear($empresa); // Obtiene el ID del nuevo registro

    if ($id) {
        $type = "success";
        $mensaje = "Empresa creada correctamente";
    } else {
        $type = "error";
        $mensaje = "Error al crear la empresa";
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

    $empresa->setId($_POST['id']);
    $empresa->setNombre($_POST['nombre']);
    $empresa->setDireccion($_POST['direccion']);
    $empresa->setEstado($_POST['estado']);
    $empresa->setTelefono($_POST['telefono']);
    $empresa->setIdMunicipio($_POST['id_municipio']);
    $empresa->setEmail($_POST['email']);

    if ($dao->editar($empresa)) {
        $type = "success";
        $mensaje = "Empresa actualizada correctamente";
    } else {
        $type = "error";
        $mensaje = "Error al actualizar la empresa";
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
    $empresa->setId($_POST['id']);
    $dao->cargar($empresa);
    if ($dao->objetos[0]->estado == 1) {
        $empresa->setEstado(0);
    } else {
        $empresa->setEstado(1);
    }
    $dao->cambiar_estado($empresa);
}

// Sedes


/* Este bloque de código verifica si el valor de la variable `['funcion']` es igual a `'buscar'`.
Si es así, realiza las siguientes acciones: 
Recorre el resultado de la consulta a la base de datos y los agrega a una lista en formato JSON
la cual se retorna
*/
if (isset($_POST['funcion']) && $_POST['funcion'] == 'listar_sedes') {
    $json = array();
    $sedes->setIdEmpresa($_POST['id_empresa']);
    $dao->listar_sedes($_SESSION['empresas']['editar'], $_SESSION['empresas']['ver'], $sedes);
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
if ($_POST['funcion'] == 'cargar_sede') {
    $json = array();
    $sedes->setId($_POST['id']);
    $dao->cargar_sede($sedes);
    $json[] = array(
        'nombre_sede' => $dao->objetos[0]->nombre_sede,
        'direccion' => $dao->objetos[0]->direccion,
        'id_municipio' => $dao->objetos[0]->id_municipio,
        'municipio' => $dao->objetos[0]->municipio,
        'departamento' => $dao->objetos[0]->departamento
    );
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}

/* Este bloque de código verifica si el valor de la variable `['funcion']` es igual a
`'crear_modulo'`. Si es así, realiza las siguientes acciones:
Agregar al objeto inicializado los valores necesarios para el proceso, 
luego se ejecuta la funcion requerida a traves del DAO
*/
if ($_POST['funcion'] == 'crear_sede') {
    $error = false;
    $type = "";
    $mensaje = "";
    $id = "";

    $sedes->setNombre($_POST['nombre_sede']);
    $sedes->setDireccion($_POST['direccion']);
    $sedes->setIdMunicipio($_POST['id_municipio']);
    $sedes->setIdEmpresa($_POST['id_empresa']);

    $id = $dao->crear_sede($sedes); // Obtiene el ID del nuevo registro

    if ($id) {
        $type = "success";
        $mensaje = "Sede creada correctamente";
    } else {
        $type = "error";
        $mensaje = "Error al crear la sede";
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
if ($_POST['funcion'] == 'editar_sede') {
    $error = false;
    $type = "";
    $mensaje = "";

    $sedes->setId($_POST['id']);
    $sedes->setNombre($_POST['nombre_sede']);
    $sedes->setDireccion($_POST['direccion']);
    $sedes->setIdMunicipio($_POST['id_municipio']);

    if ($dao->editar_sede($sedes)) {
        $type = "success";
        $mensaje = "Empresa actualizada correctamente";
    } else {
        $type = "error";
        $mensaje = "Error al actualizar la empresa";
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
