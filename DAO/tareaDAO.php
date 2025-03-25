<?php
include_once '../Conexion/Conexion.php';
include_once '../Modelo/Tarea.php';
include_once '../Modelo/ResponsableTarea.php';
class tareaDAO
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

    // Tareas proyecto

    function crear(Tarea $obj)
    {
        $sql = "INSERT INTO tareas (nombre, fecha_inicio, fecha_fin, estado, descripcion, tipo_tarea, ubicacion, descripcion_ubicacion, observaciones) 
    VALUES(:nombre, :fecha_inicio, :fecha_fin, :estado, :descripcion, :tipo_tarea, :ubicacion, :descripcion_ubicacion, :observaciones)";
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':nombre' => $obj->getNombre(), ':fecha_inicio' => $obj->getFechaInicio(), ':fecha_fin' => $obj->getFechaFin(), ':estado' => $obj->getEstado(),  ':descripcion' => $obj->getDescripcion(), ':tipo_tarea' => $obj->getTipoTarea(), ':ubicacion' => $obj->getUbicacion(), ':descripcion_ubicacion' => $obj->getDescripcionUbicacion(), ':observaciones' => $obj->getObservaciones()))) {
            echo 'creado';
        } else {
            echo 'Error al crear la tarea';
        }
    }

    function cargar(Tarea $obj)
    {
        $sql = "SELECT T.nombre AS nombre_tarea, T.fecha_inicio, T.fecha_fin, T.estado, T.descripcion, T.tipo_tarea, T.ubicacion, T.descripcion_ubicacion, T.observaciones FROM tareas T WHERE T.id=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id' => $obj->getId()));
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }

    function listar_tarea_responsable($id_responsable)
    {
        $where = "";
        if ($id_responsable <> 0) {
            $where .= "WHERE TR.id_responsable=" . $id_responsable;
        }
        $sql = "SELECT DISTINCT TP.id, TP.nombre, TP.fecha_inicio, TP.fecha_fin, TP.estado, TP.descripcion, TP.tipo_tarea, TP.ubicacion, TP.descripcion_ubicacion, TP.observaciones FROM tareas TP LEFT JOIN tareas_responsables TR ON TR.id_tarea=TP.id $where GROUP BY TP.id";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }
    function listar_mi_agenda($id_responsable)
    {
        if (!empty($_POST['consulta'])) {
            $consulta = $_POST['consulta'];
            $sql = "SELECT DISTINCT TP.id, TP.nombre, TP.fecha_inicio, TP.fecha_fin, TP.estado, TP.descripcion, TP.tipo_tarea, TP.ubicacion, TP.descripcion_ubicacion, TP.observaciones FROM tareas TP LEFT JOIN tareas_responsables TR ON TR.id_tarea=TP.id WHERE TR.id_responsable=$id_responsable AND (TP.descripcion LIKE :consulta OR TP.nombre LIKE :consulta) ORDER BY TP.fecha_inicio DESC";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta' => "%$consulta%"));
            $this->objetos = $query->fetchall();
            return $this->objetos;
        } else {
            $sql = "SELECT DISTINCT TP.id, TP.nombre, TP.fecha_inicio, TP.fecha_fin, TP.estado, TP.descripcion, TP.tipo_tarea, TP.ubicacion, TP.descripcion_ubicacion, TP.observaciones FROM tareas TP LEFT JOIN tareas_responsables TR ON TR.id_tarea=TP.id WHERE TR.id_responsable=$id_responsable AND TP.nombre NOT LIKE '' ORDER BY TP.fecha_inicio DESC";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos = $query->fetchall();
            return $this->objetos;
        }
    }

    function buscar_tarea(Tarea $obj)
    {
        $sql = "SELECT * FROM tareas T WHERE T.nombre=:nombre  AND T.fecha_inicio=:fecha_inicio AND T.fecha_fin=:fecha_fin";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':nombre' => $obj->getNombre(), ':fecha_inicio' => $obj->getFechaInicio(), ':fecha_fin' => $obj->getFechaFin()));
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }

    function listar_tareas(Tarea $obj)
    {
        if (!empty($_POST['consulta'])) {
            $consulta = $_POST['consulta'];
            $sql = "SELECT PY.id, PY.tipo_tarea,PY.fecha_inicio, PY.fecha_fin, PY.estado, PY.descripcion, PY.observaciones FROM tareas PY WHERE (PY.descripcion LIKE :consulta OR T.nombre LIKE :consulta)";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta' => "%$consulta%"));
            $this->objetos = $query->fetchall();
            return $this->objetos;
        } else {
            $sql = "SELECT PY.id, PY.tipo_tarea,PY.fecha_inicio, PY.fecha_fin, PY.estado, PY.descripcion, PY.observaciones FROM tareas PY WHERE PY.descripcion NOT LIKE ''  ORDER BY PY.fecha_inicio DESC";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos = $query->fetchall();
            return $this->objetos;
        }
    }

    function editar_tarea(Tarea $obj, $pagina)
    {
        $campos = "nombre=:nombre, tipo_tarea=:tipo_tarea, fecha_inicio=:fecha_inicio, fecha_fin=:fecha_fin, descripcion=:descripcion, ubicacion=:ubicacion, descripcion_ubicacion=:descripcion_ubicacion, observaciones=:observaciones";
        if ($pagina == "calendario") {
            $arrayQuery = array(':id' => $obj->getId(), ':nombre' => $obj->getNombre(), ':tipo_tarea' => $obj->getTipoTarea(), ':fecha_inicio' => $obj->getFechaInicio(), ':fecha_fin' => $obj->getFechaFin(), ':descripcion' => $obj->getDescripcion(), ':ubicacion' => $obj->getUbicacion(), ':descripcion_ubicacion' => $obj->getDescripcionUbicacion(),  ':observaciones' => $obj->getObservaciones());
        }
        $sql = "UPDATE tareas SET $campos WHERE id=:id";
        $query = $this->acceso->prepare($sql);
        if ($query->execute($arrayQuery)) {
            echo 'update';
        } else {
            echo 'Error al actualizar la tarea';
        }
    }

    function cambiar_estado_tarea(Tarea $obj)
    {
        $sql = "UPDATE tareas SET estado=:estado WHERE id=:id";
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':id' => $obj->getId(), ':estado' => $obj->getEstado()))) {
            echo 'update';
        } else {
            echo 'Error al actualizar tarea';
        }
    }

    function eliminar_tarea(Tarea $obj)
    {
        $sql = "DELETE FROM tareas WHERE id=:id";
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':id' => $obj->getId()))) {
            echo 'delete';
        } else {
            echo 'Error al eliminar la tarea';
        }
    }

    // Responsables Tarea

    function crear_tarea_responsable(ResponsableTarea $obj)
    {
        $sql = "INSERT INTO tareas_responsables (id_responsable, id_tarea) 
    VALUES(:id_responsable, :id_tarea)";
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':id_responsable' => $obj->getIdResponsable(), ':id_tarea' => $obj->getIdTarea()))) {
            echo 'creado';
        } else {
            echo 'Error al crear el responsable de la tarea';
        }
    }

    function listar_responsables_tareas(ResponsableTarea $obj)
    {
        $sql = "SELECT T.id AS t_responsable, U.id, U.nombre_completo, U.avatar, U.email FROM tareas_responsables T JOIN usuarios U ON T.id_responsable=U.id WHERE T.id_tarea=:id_tarea";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_tarea' => $obj->getIdTarea()));
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }

    function buscar_responsables_tareas(ResponsableTarea $obj)
    {
        $sql = "SELECT T.id AS t_responsable, U.id, U.nombre_completo, U.avatar FROM tareas_responsables T JOIN usuarios U ON T.id_responsable=U.id WHERE T.id_tarea=:id_tarea AND T.id_responsable=:id_responsable";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_tarea' => $obj->getIdTarea(), ':id_responsable' => $obj->getIdResponsable()));
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }

    function eliminar_responsable_tarea(ResponsableTarea $obj)
    {
        $sql = "DELETE FROM tareas_responsables WHERE id_tarea=:id_tarea AND id_responsable=:id_responsable";
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':id_tarea' => $obj->getIdTarea(), ':id_responsable' => $obj->getIdResponsable()))) {
            echo 'delete';
        } else {
            echo 'Error al eliminar el responsable';
        }
    }

    function eliminar_responsables_tarea(ResponsableTarea $obj)
    {
        $sql = "DELETE FROM tareas_responsables WHERE id_tarea=:id_tarea";
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':id_tarea' => $obj->getIdTarea()))) {
            echo 'delete';
        } else {
            echo 'Error al eliminar los responsables';
        }
    }

    function buscar_tareas_a_vencer($fecha)
    {
        $sql = "SELECT T.id FROM tareas_proyecto T WHERE T.fecha_fin AND T.estado=1 AND TIMESTAMPDIFF(MINUTE,:fecha,T.fecha_fin) BETWEEN 55 AND 60";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':fecha' => $fecha));
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }

    function agendaPorEstado()
    {
        $sql = "SELECT U.estado  AS valor, COUNT(*) AS cantidad
          FROM tareas U
          WHERE U.estado IS NOT NULL AND U.estado!=''
          GROUP BY U.estado
          ORDER BY U.estado ASC;";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }

    function agendaPorTipo()
    {
        $sql = "SELECT U.tipo_tarea  AS valor, COUNT(*) AS cantidad
          FROM tareas U
          WHERE U.tipo_tarea IS NOT NULL AND U.tipo_tarea!=''
          GROUP BY U.tipo_tarea
          ORDER BY U.tipo_tarea ASC;";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }
    function agendaPorTipoProxima()
    {
        $sql = "SELECT U.tipo_tarea  AS valor, COUNT(*) AS cantidad
          FROM tareas U
          WHERE U.tipo_tarea IS NOT NULL AND U.tipo_tarea!='' AND U.estado=1 AND U.fecha_inicio > NOW()
          GROUP BY U.tipo_tarea
          ORDER BY U.tipo_tarea ASC;";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }

    function finalizarAntiguas()
    {
        $sql = "UPDATE tareas T SET T.estado=2 WHERE T.estado=1 AND T.fecha_inicio<NOW();";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }
}
