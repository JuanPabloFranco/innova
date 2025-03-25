<?php
class EnvioCorreo
{
    private $id;
    private $tipo;
    private $destinatarios;
    private $fecha_hora;

    public function __CONSTRUCT()
    {
    }

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function getTipo() {
        return $this->tipo;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function getDestinatarios() {
        return $this->destinatarios;
    }

    function setDestinatarios($destinatarios) {
        $this->destinatarios = $destinatarios;
    }

    function getFechaHora() {
        return $this->fecha_hora;
    }

    function setFechaHora($fecha_hora) {
        $this->fecha_hora = $fecha_hora;
    }
}