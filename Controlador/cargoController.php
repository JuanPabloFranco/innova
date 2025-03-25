<?php
include_once '../Modelo/Cargo.php';
include_once '../DAO/cargoDAO.php';
$cargo = new Cargo();
$dao = new CargoDAO();

/* Este bloque de código verifica si el valor de la variable `['funcion']` es igual a `'buscar'`.
Si es así, realiza las siguientes acciones: 
Recorre el resultado de la consulta a la base de datos y los agrega a una lista en formato JSON
la cual se retorna
*/
if ($_POST['funcion'] == 'buscar_cargo') {
    $json = array();
    $dao->buscar_datos();
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'nombre_cargo' => $objeto->nombre_cargo,
            'estado' => $objeto->estado,
            'historias' => $objeto->historias,
            'soporte' => $objeto->soporte,
            'jefe' => $objeto->jefe,
            'id_jefe' => $objeto->id_jefe
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

/* Este bloque de código verifica si el valor de la variable `['funcion']` es igual a `'buscar'`.
Si es así, realiza las siguientes acciones: 
Recorre el resultado de la consulta a la base de datos y los agrega a una lista en formato JSON
la cual se retorna
*/
if ($_POST['funcion'] == 'cargarCargo') {
    $json = array();
    $cargo->setId($_POST['id']) ;
    $dao->cargarCargo($cargo);
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'nombre_cargo' => $objeto->nombre_cargo,
            'descripcion' => $objeto->descripcion,
            'estado' => $objeto->estado,
            'historias' => $objeto->historias,
            'soporte' => $objeto->soporte,
            'jefe' => $objeto->jefe,
            'id_jefe' => $objeto->id_jefe
        );
    }
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}

/* Este bloque de código verifica si el valor de la variable `['funcion']` es igual a
`'crear_modulo'`. Si es así, realiza las siguientes acciones:
Agregar al objeto inicializado los valores necesarios para el proceso, 
luego se ejecuta la funcion requerida a traves del DAO
*/
if ($_POST['funcion'] == 'crear_cargo') {
    $cargo->setNombreCargo($_POST['nombre_cargo']);
    $cargo->setDescripcion($_POST['descripcion']);
    $cargo->setEstado(1);
    $cargo->setHistorias($_POST['historias']);
    $cargo->setSoporte($_POST['soporte']);
    $cargo->setIdJefe($_POST['id_jefe']);
    $dao->crear_cargo($cargo);
}

/* Este bloque de código verifica si el valor de la variable `['funcion']` es igual a
`'crear_modulo'`. Si es así, realiza las siguientes acciones:
Agregar al objeto inicializado los valores necesarios para el proceso, 
luego se ejecuta la funcion requerida a traves del DAO
*/
if ($_POST['funcion'] == 'editar_cargo') {
    $cargo->setId($_POST['id']);
    $cargo->setNombreCargo($_POST['nombre_cargo']);
    $cargo->setDescripcion($_POST['descripcion']);
    $cargo->setEstado(1);
    $cargo->setHistorias($_POST['historias']);
    $cargo->setSoporte($_POST['soporte']);
    $cargo->setIdJefe($_POST['id_jefe']);
    $dao->editar_cargo($cargo);
}

/* Este bloque de código está verificando si el valor de la variable `['funcion']` es igual a
`'cambiar_estado'`.  */
if ($_POST['funcion'] == 'cambiar_estado') {
    $cargo->setId($_POST['id']);
    $dao->cargarCargo($cargo);
    if($dao->objetos[0]->estado==1){
        $cargo->setEstado(0);
    }else{
        $cargo->setEstado(1);
    }
    $dao->cambiar_estado($cargo);
}