<?php
class Equipo
{
    private $id;
    private $tipo_equipo;
    private $ubicacion;
    private $id_sede;
    private $serial;
    private $referencia;
    private $procesador;
    private $ram;
    private $disco_duro;
    private $sistema_operativo;
    private $teclado;
    private $mouse;
    private $monitor;
    private $office;
    private $pad_mouse;
    private $tipo_impresora;
    private $codigo_maquina;
    private $persona_a_cargo;
    private $estado;
    private $estado_genreral;
    private $observaciones;

    public function __CONSTRUCT()
    {
    }

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function getTipoEquipo() {
        return $this->tipo_equipo;
    }

    function setTipoEquipo($tipo_equipo) {
        $this->tipo_equipo = $tipo_equipo;
    }

    function getUbicacion() {
        return $this->ubicacion;
    }

    function setUbicacion($ubicacion) {
        $this->ubicacion = $ubicacion;
    }

    function getIdSede() {
        return $this->id_sede;
    }

    function setIdSede($id_sede) {
        $this->id_sede = $id_sede;
    }

    function getSerial() {
        return $this->serial;
    }

    function setSerial($serial) {
        $this->serial = $serial;
    }

    function getReferencia() {
        return $this->referencia;
    }

    function setReferencia($referencia) {
        $this->referencia = $referencia;
    }

    function getProcesador() {
        return $this->procesador;
    }

    function setProcesador($procesador) {
        $this->procesador = $procesador;
    }

    function getRam() {
        return $this->ram;
    }

    function setRam($ram) {
        $this->ram = $ram;
    }

    function getDiscoDuro() {
        return $this->disco_duro;
    }

    function setDiscoDuro($disco_duro) {
        $this->disco_duro = $disco_duro;
    }

    function getSistemaOperativo() {
        return $this->sistema_operativo;
    }

    function setSistemaOperativo($sistema_operativo) {
        $this->sistema_operativo = $sistema_operativo;
    }

    function getTeclado() {
        return $this->teclado;
    }

    function setTeclado($teclado) {
        $this->teclado = $teclado;
    }

    function getMouse() {
        return $this->mouse;
    }

    function setMouse($mouse) {
        $this->mouse = $mouse;
    }

    function getMonitor() {
        return $this->monitor;
    }

    function setMonitor($monitor) {
        $this->monitor = $monitor;
    }

    function getOffice() {
        return $this->office;
    }

    function setOffice($office) {
        $this->office = $office;
    }

    function getPadMouse() {
        return $this->pad_mouse;
    }

    function setPadMouse($pad_mouse) {
        $this->pad_mouse = $pad_mouse;
    }

    function getTipoImpresora() {
        return $this->tipo_impresora;
    }

    function setTipoImpresora($tipo_impresora) {
        $this->tipo_impresora = $tipo_impresora;
    }

    function getCodigoMaquina() {
        return $this->codigo_maquina;
    }

    function setCodigoMaquina($codigo_maquina) {
        $this->codigo_maquina = $codigo_maquina;
    }

    function getPersonaACargo() {
        return $this->persona_a_cargo;
    }

    function setPersonaACargo($persona_a_cargo) {
        $this->persona_a_cargo = $persona_a_cargo;
    }

    function getEstado() {
        return $this->estado;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function getEstadoGeneral() {
        return $this->estado_genreral;
    }

    function setEstadoGeneral($estado_genreral) {
        $this->estado_genreral = $estado_genreral;
    }

    function getObservaciones() {
        return $this->observaciones;
    }

    function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }


}