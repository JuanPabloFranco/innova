<?php
include_once '../Modelo/Modulo.php';
include_once '../DAO/moduloDAO.php';
include_once '../Modelo/ModuloCargo.php';
$modulo = new Modulo();
$moduloCargo = new ModuloCargo();

$dao = new ModuloDAO();

/* Este bloque de código verifica si el valor de la variable `['funcion']` es igual a `'buscar'`.
Si es así, realiza las siguientes acciones: 
Recorre el resultado de la consulta a la base de datos y los agrega a una lista en formato JSON
la cual se retorna
*/
if ($_POST['funcion'] == 'buscar') {
    $json = array();
    $dao->buscar_modulos();
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'nombre' => $objeto->nombre,
            'icono' => $objeto->icono,
            'estado' => $objeto->estado
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

/* Este bloque de código verifica si el valor de la variable `['funcion']` es igual a `'buscar'`.
Si es así, realiza las siguientes acciones: 
Asigna el resultado de la consulta a la base de datos y los agrega a una lista en formato JSON
la cual se retorna
*/
if ($_POST['funcion'] == 'cargarModulo') {
    $json = array();
    $modulo->setId($_POST['id']);
    $dao->cargar($modulo);
    $json[] = array(
        'nombre' => $dao->objetos[0]->nombre,
        'icono' => $dao->objetos[0]->icono,
        'estado' => $dao->objetos[0]->estado
    );
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}

/* Este bloque de código verifica si el valor de la variable `['funcion']` es igual a
`'crear_modulo'`. Si es así, realiza las siguientes acciones:
Agregar al objeto inicializado los valores necesarios para el proceso, 
luego se ejecuta la funcion requerida a traves del DAO
*/
if ($_POST['funcion'] == 'crear_modulo') {
    $modulo->setNombre($_POST['nombre']);
    $modulo->setEliminar($_POST['eliminar']);
    $modulo->setEstado(1);
    $modulo->setVariable(strtolower($_POST['nombre']));
    $dao->crear($modulo);

    //Dar permisos al administrador del nuevo modulo
    $dao->cargarPorNombre($modulo);
    $modulo->setId($dao->objetos[0]->id);
    $moduloCargo->setId_cargo(1);
    $moduloCargo->setId_modulo($modulo->getId());
    $moduloCargo->setCrear(1);
    $moduloCargo->setEditar(1);
    $moduloCargo->setEliminar(1);
    $moduloCargo->setVer(1);
    $dao->crear_modulo_cargo($moduloCargo);
}

/* Este bloque de código verifica si el valor de la variable `['funcion']` es igual a
`'crear_modulo'`. Si es así, realiza las siguientes acciones:
Agregar al objeto inicializado los valores necesarios para el proceso, 
luego se ejecuta la funcion requerida a traves del DAO
*/
if ($_POST['funcion'] == 'editar_modulo') {
    $modulo->setId($_POST['id']);
    $modulo->setNombre($_POST['nombre']);
    $dao->editar($modulo);
}

/* Este bloque de código verifica si el valor de la variable `['funcion']` es igual a
`'crear_modulo'`. Si es así, realiza las siguientes acciones:
Agregar al objeto inicializado los valores necesarios para el proceso, 
luego se ejecuta la funcion requerida a traves del DAO
*/
if ($_POST['funcion'] == 'cambiar_estado') {
    $json = array();
    $modulo->setId($_POST['id']);
    $dao->cargar($modulo);
    if ($dao->objetos[0]->estado == 1) {
        $modulo->setEstado(0);
    } else {
        $modulo->setEstado(1);
    }
    $dao->cambiar_estado($modulo);
}

/* Este bloque de código maneja la funcionalidad para cargar y actualizar una imagen de icono para un
módulo. */
if ($_POST['funcion'] == 'agregar_icono') {
    $respuesta = "";
    if (($_FILES['icono']['type'] == 'image/jpeg') || ($_FILES['icono']['type'] == 'image/png') || ($_FILES['icono']['type'] == 'image/gif')) {
        $imagen = uniqid() . "-" . $_FILES['icono']['name'];
        $ruta = '../Recursos/img/empresa/' . $imagen;
        if (move_uploaded_file($_FILES['icono']['tmp_name'], $ruta)) {
            $modulo->setId($_POST['id']);
            $modulo->setIcono($imagen);
            $dao->cargar($modulo);
            $old = $dao->objetos[0]->icono;
            $dao->actualizar_icono($modulo);
            unlink('../Recursos/img/empresa/' . $old);
            $respuesta = "";
        } else {
            $respuesta = 'Error al guardar la imagen en el servidor';
        }
    } else {
        $respuesta = "El archivo seleccionado debe ser jpeg, png o gif";
    }
    echo $respuesta;
}

/* Este bloque de código maneja la funcionalidad para eliminar un ícono asociado con un módulo. */
if ($_POST['funcion'] == 'eliminarIcono') {
    $modulo->setId($_POST['id']);
    $dao->cargar($modulo);
    $old = $dao->objetos[0]->icono;
    unlink('../Recursos/img/empresa/' . $old);
    $dao->eliminar_icono($modulo);
}

/* Este bloque de código verifica si el valor de la variable `['funcion']` es igual a `'buscar'`.
Si es así, realiza las siguientes acciones: 
Recorre el resultado de la consulta a la base de datos y los agrega a una lista en formato JSON
la cual se retorna
*/
if ($_POST['funcion'] == 'listar_modulos_cargo_por_cargo') {
    $json = array();
    $dao->listar_modulos_cargo_por_cargo($_POST['id_cargo']);
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'id_modulo' => $objeto->id_modulo,
            'nombre' => $objeto->nombre,
            'icono' => $objeto->icono,
            'crear' => $objeto->crear,
            'editar' => $objeto->editar,
            'eliminar' => $objeto->eliminar,
            'permite_eliminar' => $objeto->permite_eliminar,
            'ver' => $objeto->ver
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

/* Este bloque de código verifica si el valor de la variable `['funcion']` es igual a
`'crear_modulo'`. Si es así, realiza las siguientes acciones:
Agregar al objeto inicializado los valores necesarios para el proceso, 
luego se ejecuta la funcion requerida a traves del DAO
*/
if ($_POST['funcion'] == 'crearModuloCargo') {
    $moduloCargo->setId_cargo($_POST['id_cargo']);
    $moduloCargo->setId_modulo($_POST['id_modulo']);
    $dao->crear_modulo_cargo($moduloCargo);
}

/* Este bloque de código verifica si el valor de la variable `['funcion']` es igual a
`'crear_modulo'`. Si es así, realiza las siguientes acciones:
Agregar al objeto inicializado los valores necesarios para el proceso, 
luego se ejecuta la funcion requerida a traves del DAO
*/
if ($_POST['funcion'] == 'eliminarModuloCargo') {
    $moduloCargo->setId($_POST['id']);
    $dao->eliminar_modulo_cargo($moduloCargo);
}

/* Este bloque de código verifica si el valor de la variable `['funcion']` es igual a
`'crear_modulo'`. Si es así, realiza las siguientes acciones:
Agregar al objeto inicializado los valores necesarios para el proceso, 
luego se ejecuta la funcion requerida a traves del DAO
*/
if ($_POST['funcion'] == 'permisoModuloCargo') {
    $moduloCargo->setId($_POST['id']);
    $dao->cargarModuloCargo($moduloCargo);
    $moduloCargo->setId_cargo($dao->objetos[0]->id_cargo);
    $moduloCargo->setId_modulo($dao->objetos[0]->id_modulo);
    $moduloCargo->setCrear($dao->objetos[0]->crear);
    $moduloCargo->setEditar($dao->objetos[0]->editar);
    $moduloCargo->setEliminar($dao->objetos[0]->eliminar);
    $moduloCargo->setVer($dao->objetos[0]->ver);
    if($_POST['campo']=='crear'){
        if($moduloCargo->getCrear()==1){
            $moduloCargo->setCrear(0);
        }else{
            $moduloCargo->setCrear(1);
        }
    }
    if($_POST['campo']=='editar'){
        if($moduloCargo->getEditar() == 1){
            $moduloCargo->setEditar(0);
        }else{
            $moduloCargo->setEditar(1);
        }
    }
    if($_POST['campo']=='eliminar'){
        if($moduloCargo->getEliminar()==1){
            $moduloCargo->setEliminar(0);
        }else{
            $moduloCargo->setEliminar(1);
        }
    }
    if($_POST['campo']=='ver'){
        if($moduloCargo->getVer()==1){
            $moduloCargo->setVer(0);
        }else{
            $moduloCargo->setVer(1);
        }
    }
    $dao->editar_modulo_cargo($moduloCargo);
}


