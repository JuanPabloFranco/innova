<?php
class Modulo
{
    private $id;
    private $nombre;
    private $icono;
    private $estado;
    private $eliminar;
    private $variable;

    public function __CONSTRUCT()
    {
    }

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function getIcono() {
        return $this->icono;
    }

    function setIcono($icono) {
        $this->icono = $icono;
    }

    function getEstado() {
        return $this->estado;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function getEliminar() {
        return $this->eliminar;
    }

    function setEliminar($eliminar) {
        $this->eliminar = $eliminar;
    }

    function getVariable() {
        return $this->variable;
    }

    function setVariable($variable) {
        $this->variable = $variable;
    }
}
