<?php
include_once '../Modelo/Archivo.php';
include_once '../DAO/ArchivoDAO.php';
include_once '../Modelo/CategoriaArchivo.php';
$archivo = new Archivo();
$categoria = new CategoriaArchivo();
$dao = new ArchivoDAO();
session_start();

if ($_POST['funcion'] == 'crear_archivo') {
    date_default_timezone_set('America/Bogota');
    // Se crea el objeto y almacenan los datos en los campos
    $create_at = date('Y-m-d', time());
    $archivo->setNombre($_POST['nombre']);
    $archivo->setDescripcion($_POST['descripcion']);
    $archivo->setIdCategoria($_POST['id_categoria']);
    $archivo->setPrivacidad($_POST['privacidad']);
    $archivo->setFechaCreacion($create_at);
    $archivo->setIdAutor($_SESSION['datos'][0]->id);
    $archivo->setIdCargo($_POST['id_cargo']);
    $archivo->setIdSede($_POST['id_sede']);
    $archivo->setIdArea($_POST['id_area']);
    $archivo->setIdUsuario($_POST['id_usuario']);
    $archivo->setEstado(1);
    //Se valida el archivo del formulario
    if ($_FILES['archivo']['name'] <> "") {
        $file = explode('.', $_FILES['archivo']['name'], 4);
        //Se valida el tipo de archivo
        if ($file[1] == "png" || $file[1] == "jpg" || $file[1] == "jpeg") {
            $tipo = 'Imagén';
        }
        if ($file[1] == "doc" || $file[1] == "docx") {
            $tipo = 'Documento';
        }
        if ($file[1] == "xls" || $file[1] == "xlsx") {
            $tipo = 'Hoja de calculo';
        }
        if ($file[1] == "pdf") {
            $tipo = 'Documento PDF';
        }
        //Se guarda el tipo en el objeto archivo
        $archivo->setTipo($tipo);
        // Se genera un nombre unico al archivo
        $arc = uniqid() . "-" . $_FILES['archivo']['name'];
        $archivo2 = '../Recursos/biblioteca/' . $arc;
        // Se guarda el nombre del archivo en el objeto archivo
        $archivo->setArchivo($arc);
        // Se guarda el archivo en el servidor
        move_uploaded_file($_FILES['archivo']['tmp_name'], $archivo2);
        // Se guarda el registro del archivo en base de datos
        $dao->crear($archivo);
        
    }
}

if ($_POST['funcion'] == 'buscar') {
    $json = array();
    $dao->buscar_datos();
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'estado' => $objeto->estado,
            'nombre' => $objeto->nombre,
            'descripcion' => $objeto->descripcion,
            'archivo' => $objeto->archivo,
            'id_categoria' => $objeto->id_categoria,
            'nombre_categoria' => $objeto->nombre_categoria,
            'tipo' => $objeto->tipo,
            'privacidad' => $objeto->privacidad,
            'fecha_creacion' => $objeto->fecha_creacion,
            'id_autor' => $objeto->id_autor,
            'nombre_completo' => $objeto->nombre_completo,
            'nombre_cargo' => $objeto->nombre_cargo,
            'nombre_sede' => $objeto->nombre_sede,
            'nombre_area' => $objeto->nombre_area,
            'nombre_usuario' => $objeto->nombre_usuario,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'buscar_biblioteca') {
    $json = array();
    $dao->buscar_biblioteca($_SESSION['datos'][0]->id_cargo, $_SESSION['datos'][0]->id_sede, $_SESSION['datos'][0]->id, $_SESSION['datos'][0]->id_area);
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'estado' => $objeto->estado,
            'nombre' => $objeto->nombre,
            'descripcion' => $objeto->descripcion,
            'archivo' => $objeto->archivo,
            'id_categoria' => $objeto->id_categoria,
            'nombre_categoria' => $objeto->nombre_categoria,
            'tipo' => $objeto->tipo,
            'privacidad' => $objeto->privacidad,
            'fecha_creacion' => $objeto->fecha_creacion,
            'id_autor' => $objeto->id_autor,
            'nombre_completo' => $objeto->nombre_completo,
            'nombre_cargo' => $objeto->nombre_cargo,
            'nombre_sede' => $objeto->nombre_sede,
            'nombre_area' => $objeto->nombre_area,
            'nombre_usuario' => $objeto->nombre_usuario,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'cargarArchivo') {
    $json = array();
    $archivo->setId($_POST['id']);
    $dao->cargarArchivo($archivo);
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'estado' => $objeto->estado,
            'nombre' => $objeto->nombre,
            'descripcion' => $objeto->descripcion,
            'archivo' => $objeto->archivo,
            'id_categoria' => $objeto->id_categoria,
            'nombre_categoria' => $objeto->nombre_categoria,
            'tipo' => $objeto->tipo,
            'privacidad' => $objeto->privacidad,
            'fecha_creacion' => $objeto->fecha_creacion,
            'id_autor' => $objeto->id_autor,
            'nombre_completo' => $objeto->nombre_completo,
            'nombre_cargo' => $objeto->nombre_cargo,
            'nombre_sede' => $objeto->nombre_sede,
            'nombre_area' => $objeto->nombre_area,
            'nombre_usuario' => $objeto->nombre_usuario,
            'id_sede' => $objeto->id_sede,
            'id_cargo' => $objeto->id_cargo,
            'id_area' => $objeto->id_area,
            'id_usuario' => $objeto->id_usuario,
        );
    }
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'editar_archivo') {
    $archivo->setId($_POST['id']);
    $archivo->setNombre($_POST['nombre']);
    $archivo->setDescripcion($_POST['descripcion']);
    $archivo->setIdCategoria($_POST['categoria']);
    $archivo->setPrivacidad($_POST['privacidad']);
    $archivo->setIdCargo($_POST['id_cargo']);
    $archivo->setIdSede($_POST['id_sede']);
    $archivo->setIdArea($_POST['id_area']);
    $archivo->setIdUsuario($_POST['id_usuario']);

    $dao->editar_archivo($archivo);
}

if ($_POST['funcion'] == 'eliminarArchivo') {
    $archivo->setId($_POST['id']);
    $dao->cargarArchivo($archivo);
    unlink('../Recursos/adjuntos/contratos/' . $dao->objetos[0]->archivo);

    $dao->eliminar_archivo($archivo);


}

if ($_POST['funcion'] == 'cambiarEstado') {
    $archivo->setId($_POST['id']);
    $dao->cargarArchivo($archivo);
    if ($dao->objetos[0]->estado == 1) {
        $estado = 0;
    } else {
        $estado = 1;
    }
    $archivo->setEstado($estado);
    $dao->cambiar_estado($archivo);
}

// Categoria

if ($_POST['funcion'] == 'crear_categoria') {
    $categoria->setNombre($_POST['nombre_categoria']);
    $categoria->setEstado(1);
    $dao->crear_categoria($categoria);
}

if ($_POST['funcion'] == 'editar_categoria') {
    $categoria->setId($_POST['id']);
    $categoria->setNombre($_POST['nombre_categoria']);    
    $dao->editar_categoria($categoria);
}

if ($_POST['funcion'] == 'listarCategoria') {
    $json = array();
    $dao->listarCategorias();
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'estado' => $objeto->estado,
            'nombre' => $objeto->nombre,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'cargarCategoria') {
    $json = array();
    $dao->listarCategorias();
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'estado' => $objeto->estado,
            'nombre' => $objeto->nombre,
        );
    }
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'cambiarEstadoCategoria') {
    $categoria->setId($_POST['id']);
    $dao->cargarCategoria($categoria);
    if ($dao->objetos[0]->estado == 1) {
        $estado = 0;
    } else {
        $estado = 1;
    }
    $categoria->setEstado($estado);
    $dao->cambiarEstadoCategoria($categoria);
}

if ($_POST['funcion'] == 'graficos') {
    $json = array();
    $cantidad = [];
    $valor = [];
    if ($_POST['grafico'] == "porEstado") {
        $dao->archivosPorEstado();
    } else if ($_POST['grafico'] == "porSedes") {
        $dao->archivosPorSede();
    } else if ($_POST['grafico'] == "porAreas") {
        $dao->archivosPorArea();
    } else if ($_POST['grafico'] == "porTipo") {
        $dao->archivosPorTipo();
    } else if ($_POST['grafico'] == "porCategoria") {
        $dao->archivosPorCategoria();
    } else if ($_POST['grafico'] == "porCargo") {
        $dao->archivosPorCargo();
    } else if ($_POST['grafico'] == "porPrivacidad") {
        $dao->archivosPorPrivacidad();
    } else if ($_POST['grafico'] == "porUsuario") {
        $dao->archivosPorUsuario();
    } 
    foreach ($dao->objetos as $objeto) {
        if ($_POST['grafico'] == "porEstado") {
            if ($objeto->valor == 1) {
                array_push($valor, 'Disponible');
            } else {
                array_push($valor, 'No Disponible');
            }
        } else {
            array_push($valor, $objeto->valor);
        }
        array_push($cantidad, $objeto->cantidad);
    }
    $json[] = array(
        'cantidad' => $cantidad,
        'valor' => $valor
    );
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'archivosPorCargoEspecifico') {
    $json = array();
    $archivo->setIdCargo($_POST['id_cargo']);
    $dao->archivosPorCargoEspecifico($archivo);
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'estado' => $objeto->estado,
            'nombre' => $objeto->nombre,
            'descripcion' => $objeto->descripcion,
            'archivo' => $objeto->archivo,
            'id_categoria' => $objeto->id_categoria,
            'tipo' => $objeto->tipo,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}