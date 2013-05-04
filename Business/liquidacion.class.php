<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of liquidacion
 *
 * @author David
 */
class liquidacion {
    
    private $rendicionId;
    private $ingresos;
    private $egresos;
    private $imputacion;
    private $plan;
    private $obrasocial;
    private $quincena;
    private $mes;
    private $anio;
    private $confirmado;
    private $descuento;

    public function getRendicionId() {
        return $this->rendicionId;
    }
     
    public function setRendicionId($rendicionId) {
        $this->rendicionId = $rendicionId;
    }

    public function getIngresos() {
        return $this->ingresos;
    }
     
    public function setIngresos($ingresos) {
        $this->ingresos = $ingresos;
    }

    public function getEgresos() {
        return $this->egresos;
    }
     
    public function setEgresos($egresos) {
        $this->egresos = $egresos;
    }

    public function getImputacion() {
        return $this->imputacion;
    }
     
    public function setImputacion($imputacion) {
        $this->imputacion = $imputacion;
    }

    public function getDescuento() {
        return $this->descuento;
    }
     
    public function setDescuento($descuento) {
        $this->descuento = $descuento;
    }

    public function getConfirmado() {
        return $this->confirmado;
    }
     
    public function setConfirmado($confirmado) {
        $this->confirmado = $confirmado;
    }

    public function getObrasocial() {
        return $this->obrasocial;
    }
     
    public function setObrasocial($obrasocial) {
        $this->obrasocial = $obrasocial;
    }

    public function getPlan() {
        return $this->plan;
    }
     
    public function setPlan($plan) {
        $this->plan = $plan;
    }

    public function getAnio() {
        return $this->anio;
    }
     
    public function setAnio($anio) {
        $this->anio = $anio;
    }

    public function getMes() {
        return $this->mes;
    }
     
    public function setMes($mes) {
        $this->mes = $mes;
    }

    public function getQuincena() {
        return $this->quincena;
    }
     
    public function setQuincena($quincena) {
        $this->quincena = $quincena;
    }
}

?>