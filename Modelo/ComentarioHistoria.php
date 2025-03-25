<?php
class ComentarioHistoria
{
    private $id;
    private $id_autor;
    private $id_historia;
    private $comentario;
    private $fecha_hora;

    public function __CONSTRUCT()
    {
    }

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function getIdAutor() {
        return $this->id_autor;
    }

    function setIdAutor($id_autor) {
        $this->id_autor = $id_autor;
    }

    function getFechaHora() {
        return $this->fecha_hora;
    }

    function setFechaHora($fecha_hora) {
        $this->fecha_hora = $fecha_hora;
    }

    function getComentario() {
        return $this->comentario;
    }

    function setComentario($comentario) {
        $this->comentario = $comentario;
    }

    function getIdHistoria() {
        return $this->id_historia;
    }

    function setIdHistoria($id_historia) {
        $this->id_historia = $id_historia;
    }
}