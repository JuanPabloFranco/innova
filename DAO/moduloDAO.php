<?php
include_once '../Conexion/Conexion.php';
include_once '../Modelo/Modulo.php';
include_once '../Modelo/ModuloCargo.php';
class ModuloDAO
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

    /**
     * La función "crear" inserta un nuevo registro en la tabla "módulos" con los valores
     * proporcionados para "nombre", "icono", "estado" y "eliminar".
     * 
     * @param Modulo obj El parámetro `` es un objeto de la clase `Modulo`. Se utiliza para pasar
     * los valores de las propiedades del objeto `Modulo` a la consulta SQL. Las propiedades que se
     * pasan son:
     */
    function crear(Modulo $obj)
    {
        $sql = "INSERT INTO modulos (nombre, icono, estado, eliminar, variable) VALUES(:nombre, :icono, :estado, :eliminar, :variable)";
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':nombre' => $obj->getNombre(), ':icono' => $obj->getIcono(), ':estado' => $obj->getEstado(), ':eliminar' => $obj->getEliminar(), ':variable' => $obj->getVariable()))) {
            echo 'create';
        } else {
            echo 'Error al crear el módulo';
        }
    }

    /**
     * La función "listar" recupera todos los registros de la tabla "módulos" en orden ascendente por
     * nombre.
     * 
     * @return una serie de objetos.
     */
    function listar()
    {
        $sql = "SELECT * FROM modulos M ORDER BY M.nombre ASC";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }

    /**
     * La función "buscar_modulos" busca módulos en una base de datos en función de una consulta
     * determinada y devuelve los resultados.
     * 
     * @return una serie de objetos.
     */
    function buscar_modulos()
    {
        if (!empty($_POST['consulta'])) {
            $consulta = $_POST['consulta'];
            $sql = "SELECT * FROM modulos WHERE nombre LIKE :consulta";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta' => "%$consulta%"));
            $this->objetos = $query->fetchall();
            return $this->objetos;
        } else {
            $sql = "SELECT * FROM modulos WHERE nombre NOT LIKE ''  ORDER BY id";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos = $query->fetchall();
            return $this->objetos;
        }
    }

    /**
     * La función "cargar" recupera datos de la tabla "módulos" según el ID del módulo proporcionado.
     * 
     * @param Modulo obj El parámetro "obj" es un objeto de la clase "Modulo".
     * 
     * @return una matriz de objetos que coinciden con el ID dado de la tabla "módulos".
     */
    function cargar(Modulo $obj)
    {
        $sql = "SELECT * FROM modulos WHERE id=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id' => $obj->getId()));
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }

    function cargarPorNombre(Modulo $obj)
    {
        $sql = "SELECT id FROM modulos WHERE nombre=:nombre AND estado=:estado";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':nombre' => $obj->getNombre(), ':estado' => $obj->getEstado()));
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }

    /**
     * La función "editar" actualiza el nombre de un módulo en una base de datos utilizando una
     * declaración preparada en PHP.
     * 
     * @param Modulo obj El parámetro "obj" es un objeto de la clase "Modulo".
     */
    function editar(Modulo $obj)
    {
        $sql = "UPDATE modulos SET nombre=:nombre WHERE id=:id";
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':id' => $obj->getId(), ':nombre' => $obj->getNombre()))) {
            echo 'update';
        } else {
            echo 'Error al actualizar el módulo';
        }
    }

    /**
     * La función "change_state" actualiza el estado de un objeto Módulo en una tabla de base de datos
     * llamada "módulos"
     * 
     * @param Modulo obj El parámetro "obj" es una instancia de la clase "Modulo".
     */
    function cambiar_estado(Modulo $obj)
    {
        $sql = "UPDATE modulos SET estado=:estado WHERE id=:id";
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':id' => $obj->getId(), ':estado' => $obj->getEstado()))) {
            echo 'update';
        } else {
            echo 'Error al actualizar el módulo';
        }
    }

    /**
     * La función "actualizar_icono" actualiza el icono de un módulo en una base de datos.
     * 
     * @param Modulo obj El parámetro "obj" es una instancia de la clase "Modulo".
     */
    function actualizar_icono(Modulo $obj)
    {
        $sql = "UPDATE modulos SET icono=:icono WHERE id=:id";
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':id' => $obj->getId(), ':icono' => $obj->getIcono()))) {
            echo 'update';
        } else {
            echo 'Error al actualizar el módulo';
        }
    }

    /**
     * La función "eliminar_icono" actualiza el campo "icono" de un objeto "Modulo" a NULL en la tabla
     * "modulos".
     * 
     * @param Modulo obj El parámetro "obj" es una instancia de la clase "Modulo".
     */
    function eliminar_icono(Modulo $obj)
    {
        $sql = "UPDATE modulos SET icono=NULL WHERE id=:id";
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':id' => $obj->getId()))) {
            echo 'update';
        } else {
            echo 'Error al actualizar el módulo';
        }
    }

    // Modulos cargos

    /**
     * La función `crear_modulo_cargo` inserta un nuevo registro en la tabla `modulos_cargos` con los
     * ID de carga y módulo proporcionados.
     * 
     * @param ModuloCargo obj El parámetro "obj" es una instancia de la clase "ModuloCargo". Se utiliza
     * para pasar los datos necesarios para crear un nuevo registro en la tabla "modulos_cargos". La
     * clase "ModuloCargo" probablemente tenga propiedades como "id_cargo" e "id
     */
    function crear_modulo_cargo(ModuloCargo $obj)
    {
        $sql = "INSERT INTO modulos_cargos(id_cargo, id_modulo) 
        VALUES (:id_cargo, :id_modulo)";
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':id_cargo' => $obj->getId_cargo(), ':id_modulo' => $obj->getId_modulo()))) {
            echo 'create';
        } else {
            echo 'Error al crear el módulo';
        }
    }

    function editar_modulo_cargo(ModuloCargo $obj)
    {
        $sql = "UPDATE modulos_cargos SET crear=:crear, editar=:editar, eliminar=:eliminar, ver=:ver WHERE id=:id";
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':id' => $obj->getId(),':crear' => $obj->getCrear(),':editar' => $obj->getEditar(),':eliminar' => $obj->getEliminar(), ':ver' => $obj->getVer()))) {
            echo 'update';
        } else {
            echo 'Error al actualizar el módulo';
        }
    }

    function listar_modulos_cargo_por_cargo($id_cargo)
    {
        $sql = "SELECT MC.id, M.nombre, M.icono, MC.crear, MC.editar, MC.eliminar, MC.ver, MC.id_modulo, M.eliminar AS permite_eliminar FROM modulos_cargos MC JOIN modulos M ON MC.id_modulo=M.id WHERE MC.id_cargo=:id_cargo ORDER BY MC.id_modulo ASC";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_cargo' => $id_cargo));
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }

    function cargarModuloCargo(ModuloCargo $obj)
    {
        $sql = "SELECT * FROM modulos_cargos WHERE id=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id' => $obj->getId()));
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }

    function eliminar_modulo_cargo(ModuloCargo $obj)
    {
        $sql = "DELETE FROM modulos_cargos WHERE id=:id";
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':id' => $obj->getId()))) {
            echo 'delete';
        } else {
            echo 'Error al eliminar el módulo';
        }
    }
}
