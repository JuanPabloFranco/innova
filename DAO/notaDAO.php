<?php
include_once '../Conexion/Conexion.php';
include_once '../Modelo/Nota.php';
class notaDAO
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

    function crear(Nota $obj)
    {
        $sql2 = "INSERT INTO notas(id_autor, tipo_nota, dirigido, id_cargo, id_sede, id_usuario, id_area, fecha_ini, fecha_fin, descripcion_nota, imagen)                
               values(:id_autor,:tipo,:dirigido,:id_cargo,:id_sede,:id_usuario, :id_area,:fechaini,:fechafin,:descripcion,'')";
        $query2 = $this->acceso->prepare($sql2);
        if ($query2->execute(array(':id_autor' => $obj->getIdAutor(), ':tipo' => $obj->getTipo(), ':dirigido' => $obj->getDirigido(), ':id_cargo' => $obj->getIdCargo(), ':id_sede' => $obj->getIdSede(), ':id_usuario' => $obj->getIdUsuario(), ':fechaini' => $obj->getFechaInicio(), ':fechafin' => $obj->getFechaFin(), ':descripcion' => $obj->getDescripcion(), ':id_area' => $obj->getIdArea()))) {
            echo 'creado';
        } else {
            echo 'Error al registrar la nota';
        }
    }

    function buscar_datos(Nota $obj)
    {
        $sql = "SELECT N.*, S.nombre AS nombre_sede, U.nombre_completo, A.nombre AS nombre_area, C.nombre_cargo FROM notas N LEFT JOIN sedes S ON N.id_sede=S.id LEFT JOIN usuarios U ON N.id_usuario=U.id LEFT JOIN areas A ON N.id_area=A.id LEFT JOIN cargos C ON N.id_cargo=C.id WHERE id_autor=:id_autor ORDER BY fecha_ini";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_autor' => $obj->getIdAutor()));
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }

    function cargarNota(Nota $obj)
    {
        $autor = $_POST['id'];
        $sql = "SELECT * FROM notas WHERE id=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id' => $obj->getId()));
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }

    function editar_nota(Nota $obj)
    {
        $sql = "UPDATE notas SET tipo_nota=:tipo, dirigido=:dirigido, id_cargo=:id_cargo, id_sede=:id_sede, id_usuario=:id_usuario, fecha_ini=:fecha_ini, fecha_fin=:fechafin, descripcion_nota=:descripcion, id_area=:id_area WHERE id=:id";
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':id' => $obj->getId(), ':tipo' => $obj->getTipo(), ':dirigido' => $obj->getDirigido(), ':id_cargo' => $obj->getIdCargo(), ':id_sede' => $obj->getIdSede(), ':id_usuario' => $obj->getIdUsuario(), ':fecha_ini' => $obj->getFechaInicio(), ':fechafin' => $obj->getFechaFin(), ':descripcion' => $obj->getDescripcion(), ':id_area' => $obj->getIdArea()))) {
            echo 'update';
        } else {
            echo 'Error al actualizar la nota';
        }
    }

    function cambiar_img(Nota $obj)
    {
        $sql = "SELECT imagen FROM notas WHERE id=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id' => $obj->getId()));
        $this->objetos = $query->fetchall();

        $sql = "UPDATE notas SET imagen=:imagen WHERE id=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id' => $obj->getId(), ':imagen' => $obj->getImagen()));
        return $this->objetos;
    }

    function eliminarNota(Nota $obj)
    {
        $sql = "DELETE FROM notas WHERE id=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id' => $obj->getId()));
        return $this->objetos;
    }

    function eliminarImagen(Nota $obj)
    {
        $sql = "UPDATE notas SET imagen=null WHERE id=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id' => $obj->getId()));
        return $this->objetos;
    }
}
