<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of farmaciaclass
 *
 * @author David
 */
class farmacia {

    private $idFarmacia;
    private $razonSocial;
    private $nombreFantasia;
    private $nombrePropietario;
    private $directorTecnico;
    private $arrayAuxiliares;
    private $telefono;
    private $domicilio;
    private $cuit;
    private $flagCheque;
    private $transferencia;
    private $flagAlta;
    private $contadorBarra;
    private $localidad;
    private $codigoPostal;
    private $esDrogueria;
    private $provincia;
    
    public function setProvincia($provincia) {
        $this->provincia = $provincia;
    }

    public function getProvincia() {
        return $this->provincia;
    }

        public function getLocalidad() {
        return $this->localidad;
    }

    public function getCodigoPostal() {
        return $this->codigoPostal;
    }

    public function setLocalidad($localidad) {
        $this->localidad = $localidad;
    }

    public function setCodigoPostal($codigoPostal) {
        $this->codigoPostal = $codigoPostal;
    }

    public function getEsDrogueria() {
        return $this->esDrogueria;
    }

    public function setEsDrogueria($esDrogueria) {
        $this->esDrogueria = $esDrogueria;
    }

    public function getDomicilio() {
        return $this->domicilio;
    }

    public function setDomicilio($domicilio) {
        $this->domicilio = $domicilio;
    }

    public function setIdFarmacia($idFarmacia) {
        $this->idFarmacia = $idFarmacia;
    }

    public function setRazonSocial($razonSocial) {
        $this->razonSocial = $razonSocial;
    }

    public function setNombreFantasia($nombreFantasia) {
        $this->nombreFantasia = $nombreFantasia;
    }

    public function setNombrePropietario($nombrePropietario) {
        $this->nombrePropietario = $nombrePropietario;
    }

    public function setDirectorTecnico($directorTecnico) {
        $this->directorTecnico = $directorTecnico;
    }

    public function setArrayAuxiliares($arrayAuxiliares) {
        $this->arrayAuxiliares = $arrayAuxiliares;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function setCalle($calle) {
        $this->calle = $calle;
    }

    public function setNro($nro) {
        $this->nro = $nro;
    }

    public function setBarrio($barrio) {
        $this->barrio = $barrio;
    }

    public function setCuit($cuit) {
        $this->cuit = $cuit;
    }

    public function setFlagCheque($flagCheque) {
        $this->flagCheque = $flagCheque;
    }

    public function setTransferencia($transferencia) {
        $this->transferencia = $transferencia;
    }

    public function setFlagAlta($flagAlta) {
        $this->flagAlta = $flagAlta;
    }

    public function setContadorBarra($contadorBarra) {
        $this->contadorBarra = $contadorBarra;
    }

    public function getIdFarmacia() {
        return $this->idFarmacia;
    }

    public function getRazonSocial() {
        return $this->razonSocial;
    }

    public function getNombreFantasia() {
        return $this->nombreFantasia;
    }

    public function getNombrePropietario() {
        return $this->nombrePropietario;
    }

    public function getDirectorTecnico() {
        return $this->directorTecnico;
    }

    public function getArrayAuxiliares() {
        return $this->arrayAuxiliares;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getCalle() {
        return $this->calle;
    }

    public function getNro() {
        return $this->nro;
    }

    public function getBarrio() {
        return $this->barrio;
    }

    public function getCuit() {
        return $this->cuit;
    }

    public function getFlagCheque() {
        return $this->flagCheque;
    }

    public function getTransferencia() {
        return $this->transferencia;
    }

    public function getFlagAlta() {
        return $this->flagAlta;
    }

    public function getContadorBarra() {
        return $this->contadorBarra;
    }

}

?>
