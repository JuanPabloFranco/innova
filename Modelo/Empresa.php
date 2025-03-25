<?php
class Empresa
{
    private $id;
    private $nombre;
    private $direccion;
    private $telefono;
    private $estado;
    private $id_municipio;
    private $email;
    private $ip;
    private $logo;

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

    function getEstado() {
        return $this->estado;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function getIdMunicipio() {
        return $this->id_municipio;
    }

    function setIdMunicipio($id_municipio) {
        $this->id_municipio = $id_municipio;
    }

    function getEmail() {
        return $this->email;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function getIp() {
        return $this->ip;
    }

    function setIp($ip) {
        $this->ip = $ip;
    }

    function getLogo() {
        return $this->logo;
    }

    function setLogo($logo) {
        $this->logo = $logo;
    }    
}