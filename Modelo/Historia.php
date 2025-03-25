<?php
class Historia
{
    private $id;
    private $id_autor;
    private $fecha_hora;
    private $texto;
    private $imagen;
    private $link;
    private $documento;

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

    function getFechaHora() {
        return $this->fecha_hora;
    }

    function setFechaHora($fecha_hora) {
        $this->fecha_hora = $fecha_hora;
    }

    function getTexto() {
        return $this->texto;
    }

    function setTexto($texto) {
        $this->texto = $texto;
    }

    function getLink() {
        return $this->link;
    }

    function setLink($link) {
        $this->link = $link;
    }

    function getDocumento() {
        return $this->documento;
    }

    function setDocumento($documento) {
        $this->documento = $documento;
    }
    

    function getImagen() {
        return $this->imagen;
    }

    function setImagen($imagen) {
        $this->imagen = $imagen;
    }
}