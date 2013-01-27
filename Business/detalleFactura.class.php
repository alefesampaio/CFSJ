<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of detalleFactura
 *
 * @author David
 */
class detalleFactura {
    
    private $idDetalleFactura;
    private $fecha;
    private $origen;
    public $Plan;
    public $Unidad;
    private $mes;
    private $anio;
    public $Medico;
    private $fechaRecepcion;
    private $fechaReceta;
    private $nroOrden;
    private $apellido;
    private $carnet;
    private $nroDocumento;
    private $arancelOS;
    private $arancelAfiliado;
    private $arancel;
    private $cantidad;
    private $folio;
    public $Farmacia;
    private $cobertura;
    private $barra;
    private $troquel;
    private $operador;
    private $tipoPrestador;
    
    public function getIdDetalleFactura() {
        return $this->idDetalleFactura;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getOrigen() {
        return $this->origen;
    }

    public function getPlan() {
        return $this->Plan;
    }

    public function getUnidad() {
        return $this->Unidad;
    }

    public function getMes() {
        return $this->mes;
    }

    public function getAnio() {
        return $this->anio;
    }

    public function getMedico() {
        return $this->Medico;
    }

    public function getFechaRecepcion() {
        return $this->fechaRecepcion;
    }

    public function getFechaReceta() {
        return $this->fechaReceta;
    }

    public function getNroOrden() {
        return $this->nroOrden;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function getCarnet() {
        return $this->carnet;
    }

    public function getNroDocumento() {
        return $this->nroDocumento;
    }

    public function getArancelOS() {
        return $this->arancelOS;
    }

    public function getArancelAfiliado() {
        return $this->arancelAfiliado;
    }

    public function getArancel() {
        return $this->arancel;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function getFolio() {
        return $this->folio;
    }

    public function getFarmacia() {
        return $this->Farmacia;
    }

    public function getCobertura() {
        return $this->cobertura;
    }

    public function getBarra() {
        return $this->barra;
    }

    public function getTroquel() {
        return $this->troquel;
    }

    public function getOperador() {
        return $this->operador;
    }

    public function getTipoPrestador() {
        return $this->tipoPrestador;
    }

    public function setIdDetalleFactura($idDetalleFactura) {
        $this->idDetalleFactura = $idDetalleFactura;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function setOrigen($origen) {
        $this->origen = $origen;
    }

    public function setPlan($Plan) {
        $this->Plan = $Plan;
    }

    public function setUnidad($Unidad) {
        $this->Unidad = $Unidad;
    }

    public function setMes($mes) {
        $this->mes = $mes;
    }

    public function setAnio($anio) {
        $this->anio = $anio;
    }

    public function setMedico($Medico) {
        $this->Medico = $Medico;
    }

    public function setFechaRecepcion($fechaRecepcion) {
        $this->fechaRecepcion = $fechaRecepcion;
    }

    public function setFechaReceta($fechaReceta) {
        $this->fechaReceta = $fechaReceta;
    }

    public function setNroOrden($nroOrden) {
        $this->nroOrden = $nroOrden;
    }

    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    public function setCarnet($carnet) {
        $this->carnet = $carnet;
    }

    public function setNroDocumento($nroDocumento) {
        $this->nroDocumento = $nroDocumento;
    }

    public function setArancelOS($arancelOS) {
        $this->arancelOS = $arancelOS;
    }

    public function setArancelAfiliado($arancelAfiliado) {
        $this->arancelAfiliado = $arancelAfiliado;
    }

    public function setArancel($arancel) {
        $this->arancel = $arancel;
    }

    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    public function setFolio($folio) {
        $this->folio = $folio;
    }

    public function setFarmacia($Farmacia) {
        $this->Farmacia = $Farmacia;
    }

    public function setCobertura($cobertura) {
        $this->cobertura = $cobertura;
    }

    public function setBarra($barra) {
        $this->barra = $barra;
    }

    public function setTroquel($troquel) {
        $this->troquel = $troquel;
    }

    public function setOperador($operador) {
        $this->operador = $operador;
    }

    public function setTipoPrestador($tipoPrestador) {
        $this->tipoPrestador = $tipoPrestador;
    }


    
    
    
    
    
}

?>
