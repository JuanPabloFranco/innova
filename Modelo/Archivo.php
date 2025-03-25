<?php
class Archivo
{
    private $id;
    private $nombre;
    private $descripcion; // null
    private $archivo;
    private $id_categoria;
    private $tipo;
    private $fecha_creacion;
    private $id_autor;
    private $privacidad;
    private $id_cargo; // null
    private $id_sede; // null
    private $id_area; // null
    private $id_usuario; //null
    private $estado;

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

    function getDescripcion() {
        return $this->descripcion;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
    

    function getIdUsuario() {
        return $this->id_usuario;
    }

    function setIdUsuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }

    function getArchivo() {
        return $this->archivo;
    }

    function setArchivo($archivo) {
        $this->archivo = $archivo;
    }

    function getIdCategoria() {
        return $this->id_categoria;
    }

    function setIdCategoria($id_categoria) {
        $this->id_categoria = $id_categoria;
    }

    function getTipo() {
        return $this->tipo;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function getFechaCreacion() {
        return $this->fecha_creacion;
    }

    function setFechaCreacion($fecha_creacion) {
        $this->fecha_creacion = $fecha_creacion;
    }

    function getIdAutor() {
        return $this->id_autor;
    }

    function setIdAutor($id_autor) {
        $this->id_autor = $id_autor;
    }

    function getPrivacidad() {
        return $this->privacidad;
    }

    function setPrivacidad($privacidad) {
        $this->privacidad = $privacidad;
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

    function getEstado() {
        return $this->estado;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }
}