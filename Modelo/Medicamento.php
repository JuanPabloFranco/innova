<?php
class Medicamento
{
    private $id;
    private $id_usuario;
    private $nombre;
    private $indicaciones;

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

    function getNombre() {
        return $this->nombre;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function getIndicaciones() {
        return $this->indicaciones;
    }

    function setIndicaciones($indicaciones) {
        $this->indicaciones = $indicaciones;
    }
}