<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cuentaCorriente
 *
 * @author David
 */
class cuentaCorriente {
    
    private $idCtaCte;
    public $Farmacia;
    public $Plan;
    public $ObraSocial;
    public $Factura;
    public $Unidad;
    private $mes;
    private $anio;
    private $facturado;
    private $imputacion;
    private $liquidado;
    private $recibido;
    private $confirmado;
    private $cobrado;
    private $Detalle;
    private $nroRendicion;

    public function getNroRendicion(){
        return $this->nroRendicion;
    }
    
    public function setNroRendicion($nroRendicion) {
        $this->nroRendicion = $nroRendicion;
    }    
    
    public function getCobrado() {
        return $this->cobrado;
    }

    public function setCobrado($cobrado) {
        $this->cobrado = $cobrado;
    }

    
    public function getIdCtaCte() {
        return $this->idCtaCte;
    }

    public function getFarmacia() {
        return $this->Farmacia;
    }

    public function getPlan() {
        return $this->Plan;
    }

    public function getObraSocial() {
        return $this->ObraSocial;
    }

    public function getFactura() {
        return $this->Factura;
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

    public function getFacturado() {
        return $this->facturado;
    }

    public function getImputacion() {
        return $this->imputacion;
    }

    public function getDetalle() {
        return $this->Detalle;
    }

    public function getLiquidado() {
        return $this->liquidado;
    }

    public function getRecibido() {
        return $this->recibido;
    }

    public function getConfirmado() {
        return $this->confirmado;
    }

    public function setIdCtaCte($idCtaCte) {
        $this->idCtaCte = $idCtaCte;
    }

    public function setFarmacia($Farmacia) {
        $this->Farmacia = $Farmacia;
    }

    public function setPlan($Plan) {
        $this->Plan = $Plan;
    }

    public function setObraSocial($ObraSocial) {
        $this->ObraSocial = $ObraSocial;
    }

    public function setFactura($Factura) {
        $this->Factura = $Factura;
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

    public function setFacturado($facturado) {
        $this->facturado = $facturado;
    }

    public function setImputacion($imputacion) {
        $this->imputacion = $imputacion;
    }

    public function setDetalle($detalle) {
        $this->Detalle = $detalle;
    }

    public function setLiquidado($liquidado) {
        $this->liquidado = $liquidado;
    }

    public function setRecibido($recibido) {
        $this->recibido = $recibido;
    }

    public function setConfirmado($confirmado) {
        $this->confirmado = $confirmado;
    }
    public function getSaldo(){
     return $this->getFacturado()-$this->getLiquidado();
     
 }
 

 
}

?>
