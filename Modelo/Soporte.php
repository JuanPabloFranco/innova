<?php
class Soporte
{
    private $id;
    private $id_autor;
    private $id_modulo;
    private $estado;
    private $tipo;
    private $imagen;
    private $descripcion;
    private $observaciones;
    private $fecha;

    public function __CONSTRUCT()
    {
    }

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function getId_autor() {
        return $this->id_autor;
    }

    function setId_autor($id_autor) {
        $this->id_autor = $id_autor;
    }

    function getId_modulo() {
        return $this->id_modulo;
    }

    function setId_modulo($id_modulo) {
        $this->id_modulo = $id_modulo;
    }

    function getEstado() {
        return $this->estado;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function getTipo() {
        return $this->tipo;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function getImagen() {
        return $this->imagen;
    }

    function setImagen($imagen) {
        $this->imagen = $imagen;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function getObservaciones() {
        return $this->observaciones;
    }

    function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }

    function getFecha() {
        return $this->fecha;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }
}
