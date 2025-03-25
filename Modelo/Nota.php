<?php
class Nota
{
    private $id;
    private $id_autor;
    private $tipo_nota;
    private $dirigido;
    private $id_cargo;
    private $id_sede;
    private $id_area;
    private $id_usuario;
    private $fecha_ini;
    private $fecha_fin;
    private $descripcion_nota;
    private $imagen;

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

    function getTipo() {
        return $this->tipo_nota;
    }

    function setTipo($tipo_nota) {
        $this->tipo_nota = $tipo_nota;
    }

    function getIdCargo() {
        return $this->id_cargo;
    }

    function setIdCargo($id_cargo) {
        $this->id_cargo = $id_cargo;
    }

    function getIdSede() {
        return $this->id_sede;
    }

    function setIdSede($id_sede) {
        $this->id_sede = $id_sede;
    }

    function getIdArea() {
        return $this->id_area;
    }

    function setIdArea($id_area) {
        $this->id_area = $id_area;
    }

    function getIdUsuario() {
        return $this->id_usuario;
    }

    function setIdUsuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }
    
    function getDirigido() {
        return $this->dirigido;
    }

    function setDirigido($dirigido) {
        $this->dirigido = $dirigido;
    }

    function getFechaInicio() {
        return $this->fecha_ini;
    }

    function setFechaInicio($fecha_ini) {
        $this->fecha_ini = $fecha_ini;
    }

    function getFechaFin() {
        return $this->fecha_fin;
    }

    function setFechaFin($fecha_fin) {
        $this->fecha_fin = $fecha_fin;
    }

    function getDescripcion() {
        return $this->descripcion_nota;
    }

    function setDescripcion($descripcion_nota) {
        $this->descripcion_nota = $descripcion_nota;
    }

    function getImagen() {
        return $this->imagen;
    }

    function setImagen($imagen) {
        $this->imagen = $imagen;
    }
}
