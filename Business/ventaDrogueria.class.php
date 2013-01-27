<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ventaDrogueria
 *
 * @author David
 */
class ventaDrogueria {
    
    private $idVentaDrogueria;
    public $Drogueria;
    public $Farmacia;
    private $fecha;
    private $nroFactura;
    public $Manual;
    private $nroLote;
    private $fechaVencimiento;
    private $cantidad;
    
    public function getIdVentaDrogueria() {
        return $this->idVentaDrogueria;
    }

    public function getDrogueria() {
        return $this->Drogueria;
    }

    public function getFarmacia() {
        return $this->Farmacia;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getNroFactura() {
        return $this->nroFactura;
    }

    public function getManual() {
        return $this->Manual;
    }

    public function getNroLote() {
        return $this->nroLote;
    }

    public function getFechaVencimiento() {
        return $this->fechaVencimiento;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function setIdVentaDrogueria($idVentaDrogueria) {
        $this->idVentaDrogueria = $idVentaDrogueria;
    }

    public function setDrogueria($Drogueria) {
        $this->Drogueria = $Drogueria;
    }

    public function setFarmacia($Farmacia) {
        $this->Farmacia = $Farmacia;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function setNroFactura($nroFactura) {
        $this->nroFactura = $nroFactura;
    }

    public function setManual($Manual) {
        $this->Manual = $Manual;
    }

    public function setNroLote($nroLote) {
        $this->nroLote = $nroLote;
    }

    public function setFechaVencimiento($fechaVencimiento) {
        $this->fechaVencimiento = $fechaVencimiento;
    }

    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }


    
}

?>
