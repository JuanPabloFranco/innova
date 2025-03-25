<?php
class PersonaCargo
{
    private $id;
    private $id_usuario;
    private $nombre;
    private $fecha_nac;
    private $parentezco;

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

    function getFechaNac() {
        return $this->fecha_nac;
    }

    function setFechaNac($fecha_nac) {
        $this->fecha_nac = $fecha_nac;
    }

    function getParentezco() {
        return $this->parentezco;
    }

    function setParentezco($parentezco) {
        $this->parentezco = $parentezco;
    }
}