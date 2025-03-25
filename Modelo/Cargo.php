<?php
class Cargo
{
    private $id;
    private $nombre_cargo;
    private $descripcion;
    private $estado;
    private $historias;
    private $soporte;
    private $id_jefe;

    public function __CONSTRUCT()
    {
    }

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function getNombreCargo() {
        return $this->nombre_cargo;
    }

    function setNombreCargo($nombre_cargo) {
        $this->nombre_cargo = $nombre_cargo;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function getEstado() {
        return $this->estado;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function getHistorias() {
        return $this->historias;
    }

    function setHistorias($historias) {
        $this->historias = $historias;
    }

    function getSoporte() {
        return $this->soporte;
    }

    function setSoporte($soporte) {
        $this->soporte = $soporte;
    }

    function getIdJefe() {
        return $this->id_jefe;
    }

    function setIdJefe($id_jefe) {
        $this->id_jefe = $id_jefe;
    }
}
