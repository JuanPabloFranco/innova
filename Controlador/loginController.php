<?php
include_once '../Modelo/Usuario.php';
include_once '../DAO/usuarioDAO.php';
include_once '../DAO/configuracionDAO.php';
include_once '../Modelo/Cargo.php';
include_once '../DAO/cargoDAO.php';
session_start();
/**
 * Crea las variables de sesión y redirige a las paginas según el caso
 * @$_SESSION['datos'] como variable de sesion principal
 */
if (!empty($_SESSION['datos'][0]->id)) {
    header('location: ../Vista/adm_panel.php');
} else {
    $user = $_POST['user'];
    $pass = md5($_POST['pass']);
    $usuario = new Usuario();
    $usuario->setUsuarioLogin($user);
    $usuario->setPassLogin($pass);
    $usuarioDAO = new UsuarioDAO();
    $empresaDAO = new configuracionDAO();
    $usuarioDAO->loguearse($usuario);
    if (!empty($usuarioDAO->objetos)) {
        //verificar tipo usuario si esta activo
        if ($usuarioDAO->objetos[0]->estado_tipo_usuario == 1 || $usuarioDAO->objetos[0]->id_tipo_usuario) {
            // verificar cargo si esta activo
            if ($usuarioDAO->objetos[0]->estado_cargo == 1 || $usuarioDAO->objetos[0]->id_tipo_usuario == 1) {
                // Verificar si el estado del usuario esta activo
                if ($usuarioDAO->objetos[0]->estado == 1) {
                    $idUsuario = $usuarioDAO->objetos[0]->id;
                    $_SESSION['datos'] = $usuarioDAO->datos($idUsuario);
                    if ($_SESSION['datos'][0]->id_tipo_usuario <> 1) {
                        date_default_timezone_set('America/Bogota');
                        $conexion = date('Y-m-d H:i:s', time());
                        $usuarioDAO->registrar_conexion($_SESSION['datos'][0]->id, $conexion);
                    }
                    //Obtiene informacion de la empresa y crea una variable de sesion con los datos
                    $_SESSION['empresa'] = $empresaDAO->cargarInformacion();
                    // Arrays vacios donde despues se almacenará la informacion del cargo y los modulos activos para el cargo
                    $cargosJson = array();
                    $modulosJson = array();
                    $cargo = new Cargo();
                    $cargoDAO = new CargoDAO();
                    $cargoUsuario = $cargoDAO->permisosCargo($idUsuario);
                    $cargo->setId($cargoUsuario[0]->id);
                    $cargoDAO->modulosCargo($cargo);
                    foreach ($cargoDAO->objetos as $objeto) {
                        $modulosJson[] = array(
                            'id' => $objeto->id,
                            'nombre' => $objeto->nombre,
                            'crear' => $objeto->crear,
                            'editar' => $objeto->editar,
                            'eliminar' => $objeto->eliminar,
                            'ver' => $objeto->ver,
                            'icono' => $objeto->icono,
                            'variable' => $objeto->variable,
                        );
                    }
                    $cargosJson[] = array(
                        'id' => $cargoUsuario[0]->id,
                        'nombre_cargo' => $cargoUsuario[0]->nombre_cargo,
                        'descripcion' => $cargoUsuario[0]->descripcion,
                        'estado' => $cargoUsuario[0]->estado,
                        'historias' => $cargoUsuario[0]->historias,
                        'soporte' => $cargoUsuario[0]->soporte,
                        'modulos' => $modulosJson,
                    );
                    $_SESSION['permisos'] = $cargosJson;
                    // Variables globales con permisos de modulos  
                    foreach ($_SESSION['permisos'][0]['modulos'] as $modulo) {
                        $nombre = strtolower($modulo['variable']);
                        $_SESSION[$nombre] = array(
                            'id' => $modulo['id'],
                            'nombre' => $modulo['nombre'],
                            'crear' => $modulo['crear'],
                            'editar' => $modulo['editar'],
                            'eliminar' => $modulo['eliminar'],
                            'ver' => $modulo['ver'],
                            'icono' => $modulo['icono']
                        );
                    }
                    //Redireccion al inicio
                    header('location: ../Vista/adm_panel.php');
                } else {
                    $msj = 'El usuario se encuentra inactivo';
                    header('location: ../index.php?msj=' . $msj);
                }
            } else {
                $msj = 'El cargo ' . $usuarioDAO->objetos[0]->nombre_cargo . ' se encuentra inactivo';
                header('location: ../index.php?msj=' . $msj);
            }
        } else {
            $msj = 'El tipo de usuario ' . $usuarioDAO->objetos[0]->nombre_tipo . ' se encuentra inactivo';
            header('location: ../index.php?msj=' . $msj);
        }
    } else {
        $msj = 'Usuario o Contraseña incorrecta';
        header('location: ../index.php?msj=' . $msj);
    }
}
