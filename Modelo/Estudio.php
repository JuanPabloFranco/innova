<?php
class Estudio
{
    private $id;
    private $id_usuario;
    private $nivel;
    private $tipo_nivel;
    private $titulo;
    private $institucion;
    private $ano;
    private $ciudad;

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

    function getNivel() {
        return $this->nivel;
    }

    function setNivel($nivel) {
        $this->nivel = $nivel;
    }

    function getTipoNivel() {
        return $this->tipo_nivel;
    }

    function setTipoNivel($tipo_nivel) {
        $this->tipo_nivel = $tipo_nivel;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function getInstitucion() {
        return $this->institucion;
    }

    function setInstitucion($institucion) {
        $this->institucion = $institucion;
    }

    function getAño() {
        return $this->ano;
    }

    function setAño($ano) {
        $this->ano = $ano;
    }

    function getCiudad() {
        return $this->ciudad;
    }

    function setCiudad($ciudad) {
        $this->ciudad = $ciudad;
    }
}
