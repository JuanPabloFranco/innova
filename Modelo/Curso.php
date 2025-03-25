<?php
class Curso
{
    private $id;
    private $id_usuario;
    private $fecha;
    private $institucion;
    private $descripcion;
    private $horas;

    public function __CONSTRUCT()
    {
    }

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function getIdUsuario() {
        return $this->id_usuario;
    }

    function setIdUsuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }

    function getFecha() {
        return $this->fecha;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function getInstitucion() {
        return $this->institucion;
    }

    function setInstitucion($institucion) {
        $this->institucion = $institucion;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function getHoras() {
        return $this->horas;
    }

    function setHoras($horas) {
        $this->horas = $horas;
    }
}
