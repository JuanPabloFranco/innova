<?php
include_once '../Conexion/Conexion.php';
include_once '../Modelo/Soporte.php';

class SoporteDAO
{
    var $objetos;
    /**
     * @var PDO
     */
    private $acceso = "";
    public function __CONSTRUCT()
    {
        $db = new Conexion();
        $this->acceso = $db->pdo;
    }

    function buscar($id_usuario, $id_tipo_usuario)
    {
        $condicion = "";
        if ($id_tipo_usuario > 2) {
            $condicion = " AND S.id_autor=".$id_usuario;
        }

        if (!empty($_POST['consulta'])) {
            $consulta = $_POST['consulta'];
            $sql = "SELECT S.id, S.estado, S.tipo, S.imagen, S.descripcion, S.observaciones, M.nombre AS nombre_modulo, U.nombre_completo, U.email, U.doc_id, U.avatar, S.fecha FROM soporte S JOIN modulos M ON S.id_modulo=M.id JOIN usuarios U ON S.id_autor=U.id WHERE (S.descripcion LIKE :consulta OR S.tipo LIKE :consulta OR S.estado LIKE :consulta OR M.nombre LIKE :consulta) $condicion ORDER BY FIELD (S.estado,'Nuevo'), FIELD (S.estado,'En Proceso'),  FIELD (S.estado,'En Pruebas'), S.id DESC";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta' => "%$consulta%"));
            $this->objetos = $query->fetchall();
            return $this->objetos;
        } else {
            $sql = "SELECT S.id, S.estado, S.tipo, S.imagen, S.descripcion, S.observaciones, M.nombre AS nombre_modulo, U.nombre_completo, U.email, U.doc_id, U.avatar, S.fecha FROM soporte S JOIN modulos M ON S.id_modulo=M.id JOIN usuarios U ON S.id_autor=U.id WHERE S.descripcion NOT LIKE '' $condicion ORDER BY FIELD (S.estado,'Nuevo') DESC, FIELD (S.estado,'En Proceso') DESC,  FIELD (S.estado,'En Pruebas')";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos = $query->fetchall();
            return $this->objetos;
        }
    }

    function cargar(Soporte $obj)
    {
        $sql = "SELECT S.id, S.estado, S.tipo, S.imagen, S.descripcion, S.observaciones, M.nombre AS nombre_modulo, U.nombre_completo, U.email, U.doc_id, U.avatar, S.fecha FROM soporte S JOIN modulos M ON S.id_modulo=M.id JOIN usuarios U ON S.id_autor=U.id WHERE S.id=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id' => $obj->getId()));
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }

    function buscarSoporte(Soporte $obj)
    {
        $sql = "SELECT * FROM soporte WHERE id_autor=:id_autor AND descripcion=:descripcion AND tipo=:tipo'";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_autor' => $obj->getId_autor(), ':descripcion' => $obj->getDescripcion(), ':tipo' => $obj->getTipo()));
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }

    function editar(Soporte $obj)
    {
        $sql = "UPDATE soporte S SET id_modulo=:id_modulo, tipo=:tipo, descripcion=:descripcion WHERE id=:id";
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':id' => $obj->getId(), ':id_modulo' => $obj->getId_modulo(), ':descripcion' => $obj->getDescripcion(), ':tipo' => $obj->getTipo()))) {
            echo 'update';
        } else {
            echo 'Error al actualizar el caso';
        }
    }

    function crear(Soporte $obj)
    {
        $sql = "INSERT INTO soporte(id_autor, id_modulo, tipo, descripcion, fecha) 
        VALUES (:id_autor, :id_modulo, :tipo, :descripcion, :fecha)";
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':id_autor' => $obj->getId_autor(), ':descripcion' => $obj->getDescripcion(), ':id_modulo' => $obj->getId_modulo(), ':tipo' => $obj->getTipo(), ':fecha' => $obj->getFecha()))) {
            echo 'creado';
        } else {
            echo 'Error al crear el caso';
        }
    }

    function cambiarEstado(Soporte $obj)
    {
        $sql = "UPDATE soporte SET estado=:estado, observaciones=:observaciones WHERE id=:id";
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':id' => $obj->getId(), ':estado' => $obj->getEstado(), ':observaciones' => $obj->getObservaciones()))) {
            echo 'update';
        } else {
            echo 'Error al cambiar el estado del caso';
        }
    }

    function agregarImagen(Soporte $obj)
    {
        $sql = "UPDATE soporte SET imagen=:imagen WHERE id=:id";
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':id' => $obj->getId(), ':imagen' => $obj->getImagen()))) {
            echo 'update';
        } else {
            echo 'Error la imagén del caso';
        }
    }

    function contarSoporte($tipo_usuario, $id_usuario)
    {
        $where = " WHERE S.estado='Nuevo' ";
        if ($tipo_usuario > 2) {
            $where .= " AND S.id_autor=$id_usuario";
        }
        $sql = "SELECT COUNT(S.id) AS cantidad FROM soporte S $where";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }

    function buscarDescripcionAutor(Soporte $obj)
    {
        $sql = "SELECT S.id, S.estado, S.tipo, S.imagen, S.descripcion, S.observaciones, M.nombre AS nombre_modulo, U.nombre_completo, U.email, U.doc_id, U.avatar, S.fecha FROM soporte S JOIN modulos M ON S.id_modulo=M.id JOIN usuarios U ON S.id_autor=U.id WHERE S.id_autor=:id_autor AND S.descripcion=:descripcion";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_autor' => $obj->getId_autor(), ':descripcion' => $obj->getDescripcion()));
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }
}
