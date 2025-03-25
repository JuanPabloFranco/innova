<?php
class Sedes
{
    private $id;
    private $id_empresa;
    private $nombre;
    private $direccion;
    private $id_municipio;

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

    function getDireccion() {
        return $this->direccion;
    }

    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    function getIdEmpresa() {
        return $this->id_empresa;
    }

    function setIdEmpresa($id_empresa) {
        $this->id_empresa = $id_empresa;
    }

    function getIdMunicipio() {
        return $this->id_municipio;
    }

    function setIdMunicipio($id_municipio) {
        $this->id_municipio = $id_municipio;
    }
}