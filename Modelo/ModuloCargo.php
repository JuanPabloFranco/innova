<?php
class ModuloCargo
{
    private $id;
    private $id_cargo;
    private $id_modulo;
    private $crear;
    private $editar;
    private $eliminar;
    private $ver;

    public function __CONSTRUCT()
    {
    }

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function getId_cargo() {
        return $this->id_cargo;
    }

    function setId_cargo($id_cargo) {
        $this->id_cargo = $id_cargo;
    }

    function getId_modulo() {
        return $this->id_modulo;
    }

    function setId_modulo($id_modulo) {
        $this->id_modulo = $id_modulo;
    }

    function getCrear() {
        return $this->crear;
    }

    function setCrear($crear) {
        $this->crear = $crear;
    }

    function getEditar() {
        return $this->editar;
    }

    function setEditar($editar) {
        $this->editar = $editar;
    }

    function getEliminar() {
        return $this->eliminar;
    }

    function setEliminar($eliminar) {
        $this->eliminar = $eliminar;
    }

    function getVer() {
        return $this->ver;
    }

    function setVer($ver) {
        $this->ver = $ver;
    }
}
