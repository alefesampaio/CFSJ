<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of factura
 *
 * @author David
 */
class factura {
    
   private $idFactura;
   private $presenta;
   private $fechaCierre;
   public $Farmacia;
   private $cantRecetas;
   private $arancel;
   private $arancelOS;   
   public $Unidad;
   private $mes;
   private $anio;
   private $folioDesde;
   private $folioHasta;
   public  $Plan;
   public $Operador;
   private $fecha;
   private $origen;
   private $codigoBarra;
   private $fechaVenc1;
   private $fechaVenc2;
   private $recibido;
   private $confirmado;
   private $porcentajeBonificacion;
   private $importeBonificacion;
   private $agrupado;
   public $Detalle;
   
   public function getAgrupado() {
       return $this->agrupado;
   }

   public function setAgrupado($agrupado) {
       $this->agrupado = $agrupado;
   }

   public function getPorcentajeBonificacion() {
       return $this->porcentajeBonificacion;
   }

   public function getImporteBonificacion() {
       return $this->importeBonificacion;
   }

   public function setPorcentajeBonificacion($porcentajeBonificacion) {
       $this->porcentajeBonificacion = $porcentajeBonificacion;
   }

   public function setImporteBonificacion($importeBonificacion) {
       $this->importeBonificacion = $importeBonificacion;
   }

   
   public function getRecibido() {
       return $this->recibido;
   }

   public function getConfirmado() {
       return $this->confirmado;
   }

   public function setRecibido($recibido) {
       $this->recibido = $recibido;
   }

   public function setConfirmado($confirmado) {
       $this->confirmado = $confirmado;
   }

   public function getDetalle() {
       return $this->Detalle;
   }

   public function setDetalle($Detalle) {
       $this->Detalle = $Detalle;
   }

   public function getUnidad() {
       return $this->Unidad;
   }

   public function setUnidad($Unidad) {
       $this->Unidad = $Unidad;
   }

   public function setFechaVenc1($fechaVenc1) {
       $this->fechaVenc1 = $fechaVenc1;
   }

   public function setFechaVenc2($fechaVenc2) {
       $this->fechaVenc2 = $fechaVenc2;
   }

   public function getFechaVenc1() {
       return $this->fechaVenc1;
   }

   public function getFechaVenc2() {
       return $this->fechaVenc2;
   }

   
   public function getIdFactura() {
       return $this->idFactura;
   }

   public function getPresenta() {
       return $this->presenta;
   }

   public function getFechaCierre() {
       return $this->fechaCierre;
   }

   public function getFarmacia() {
       return $this->Farmacia;
   }

   public function getCantRecetas() {
       return $this->cantRecetas;
   }

   public function getArancel() {
       return $this->arancel;
   }

   public function getArancelOS() {
       return $this->arancelOS;
   }

   

   public function getMes() {
       return $this->mes;
   }

   public function getAnio() {
       return $this->anio;
   }

   public function getFolioDesde() {
       return $this->folioDesde;
   }

   public function getFolioHasta() {
       return $this->folioHasta;
   }

   public function getPlan() {
       return $this->Plan;
   }

   public function getOperador() {
       return $this->operador;
   }

   public function getFecha() {
       return $this->fecha;
   }

   public function getOrigen() {
       return $this->origen;
   }

   public function getCodigoBarra() {
       return $this->codigoBarra;
   }

   public function setIdFactura($idFactura) {
       $this->idFactura = $idFactura;
   }

   public function setPresenta($presenta) {
       $this->presenta = $presenta;
   }

   public function setFechaCierre($fechaCierre) {
       $this->fechaCierre = $fechaCierre;
   }

   public function setFarmacia($Farmacia) {
       $this->Farmacia = $Farmacia;
   }

   public function setCantRecetas($cantRecetas) {
       $this->cantRecetas = $cantRecetas;
   }

   public function setArancel($arancel) {
       $this->arancel = $arancel;
   }

   public function setArancelOS($arancelOS) {
       $this->arancelOS = $arancelOS;
   }

   

   public function setMes($mes) {
       $this->mes = $mes;
   }

   public function setAnio($anio) {
       $this->anio = $anio;
   }

   public function setFolioDesde($folio1) {
       $this->folioDesde = $folio1;
   }

   public function setFolioHasta($folio2) {
       $this->folioHasta = $folio2;
   }

   public function setPlan($plan) {
       $this->Plan = $plan;
   }

   public function setOperador($operador) {
       $this->operador = $operador;
   }

   public function setFecha($fecha) {
       $this->fecha = $fecha;
   }

   public function setOrigen($origen) {
       $this->origen = $origen;
   }

   public function setCodigoBarra($codigoBarra) {
       $this->codigoBarra = $codigoBarra;
   }
   
   public function getPeriodo(){
       //require_once 'funciones/functions.php';
       $m = meses();
       return $this->Unidad->getDetalle()." de ".$m[$this->getMes()];
   }


}

?>
