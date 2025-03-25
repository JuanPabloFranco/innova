<?php
class EquipoMantenimiento
{
    private $id;
    private $fecha;
    private $tipo;
    private $descripcion;
    private $realizado_por;
    private $observaciones;
    private $id_equipo;

    public function __CONSTRUCT()
    {
    }

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function getFecha() {
        return $this->fecha;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function getTipo() {
        return $this->tipo;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function getRealizadoPor() {
        return $this->realizado_por;
    }

    function setRealizadoPor($realizado_por) {
        $this->realizado_por = $realizado_por;
    }

    function getObservaciones() {
        return $this->observaciones;
    }

    function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }

    function getIdEquipo() {
        return $this->id_equipo;
    }

    function setIdEquipo($id_equipo) {
        $this->id_equipo = $id_equipo;
    }


}