<?php
include_once '../Conexion/Conexion.php';
include_once '../Modelo/Historia.php';
include_once '../Modelo/ComentarioHistoria.php';
class historiaDAO
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

    function crear(Historia $obj)
    {
        $sql2 = "INSERT INTO historia(id_autor, texto, imagen, link, documento, fecha_hora)                
               values(:id_autor,:texto,:imagen,:link, :documento, :fecha_hora)";
        $query2 = $this->acceso->prepare($sql2);
        if ($query2->execute(array(':id_autor' => $obj->getIdAutor(), ':texto' => $obj->getTexto(), ':imagen' => $obj->getImagen(), ':link' => $obj->getLink(), ':documento' => $obj->getDocumento(), ':fecha_hora' => $obj->getFechaHora()))) {
            echo 'creado';
        } else {
            echo 'Error al registrar la historia';
        }
    }

    function eliminar(Historia $obj)
    {
        $sql = "DELETE FROM historia WHERE id=:id";
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':id' => $obj->getId()))) {
            echo 'delete';
        } else {
            echo 'Error al eliminar la historia';
        }
    }

    function eliminarComentariosHistoria(Historia $obj)
    {
        $sqlComents = "DELETE FROM comentario_historia WHERE id_historia=:id_historia";
        $query2 = $this->acceso->prepare($sqlComents);
        $query2->execute(array(':id_historia' => $obj->getId()));
    }

    function crear_comentario(ComentarioHistoria $obj)
    {
        $sql2 = "INSERT INTO comentario_historia(id_autor, id_historia, comentario, fecha_hora)                
               values(:id_autor, :id_historia, :comentario, :fecha_hora)";
        $query2 = $this->acceso->prepare($sql2);
        if ($query2->execute(array(':id_autor' => $obj->getIdAutor(), ':id_historia' => $obj->getIdHistoria(), ':comentario' => $obj->getComentario(), ':fecha_hora' => $obj->getFechaHora()))) {
            echo 'creado';
        } else {
            echo 'Error al registrar el comentario';
        }
    }

    function eliminarComentario(ComentarioHistoria $obj)
    {
        $sql = "DELETE FROM comentario_historia WHERE id=:id";
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':id' => $obj->getId()))) {
            echo 'delete';
        } else {
            echo 'Error al eliminar el comentario';
        }
    }

    function cargar(Historia $obj)
    {
        $sql = "SELECT * FROM historia WHERE id=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id' => $obj->getId()));
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }
}
