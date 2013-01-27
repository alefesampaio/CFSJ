<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of obraSocial
 *
 * @author David
 */
class obraSocial {
    
    private $idObraSocial;
    private $denominacion;
    private $domicilio;
    private $email;
    private $telefono;
    private $cuit;
    private $porcentaje;
    private $periodo;
    private $inicio1;
    private $inicio2;
    private $cierre1;
    private $cierre2;
    private $agrupaCaratula;
    private $agrupaLiquidacion;
    
    public function getPeriodo() {
        return $this->periodo;
    }

    public function setPeriodo($periodo) {
        $this->periodo = $periodo;
    }
        
    public function getAgrupaCaratula() {
        return $this->agrupaCaratula;
    }

    public function getAgrupaLiquidacion() {
        return $this->agrupaLiquidacion;
    }

    public function setAgrupaCaratula($agrupaCaratula) {
        $this->agrupaCaratula = $agrupaCaratula;
    }

    public function setAgrupaLiquidacion($agrupaLiquidacion) {
        $this->agrupaLiquidacion = $agrupaLiquidacion;
    }

    
    public function getInicio1() {
        return $this->inicio1;
    }

    public function getInicio2() {
        return $this->inicio2;
    }

    public function setInicio1($inicio1) {
        $this->inicio1 = $inicio1;
    }

    public function setInicio2($inicio2) {
        $this->inicio2 = $inicio2;
    }

    public function getCierre1() {
        return $this->cierre1;
    }

    public function getCierre2() {
        return $this->cierre2;
    }

    public function setCierre1($cierre1) {
        $this->cierre1 = $cierre1;
    }

    public function setCierre2($cierre2) {
        $this->cierre2 = $cierre2;
    }

    
    
    public function getIdObraSocial() {
        return $this->idObraSocial;
    }

    public function getDenominacion() {
        return $this->denominacion;
    }

    public function getDomicilio() {
        return $this->domicilio;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getCuit() {
        return $this->cuit;
    }

    public function getPorcentaje() {
        return $this->porcentaje;
    }

   
    public function setIdObraSocial($idObraSocial) {
        $this->idObraSocial = $idObraSocial;
    }

    public function setDenominacion($denominacion) {
        $this->denominacion = $denominacion;
    }

    public function setDomicilio($domicilio) {
        $this->domicilio = $domicilio;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function setCuit($cuit) {
        $this->cuit = $cuit;
    }

    public function setPorcentaje($porcentaje) {
        $this->porcentaje = $porcentaje;
    }

   

}

?>
