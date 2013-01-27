<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ventaFarmacia
 *
 * @author David
 */
class ventaFarmacia {

    private $idVentaFarmacia;
    public $Farmacia;
    public $Manual;
    public $ObraSocial;
    private $cantidad;
    private $dni;
    private $nombreApellido;
    private $matriculaMedico;
    private $nroRecetario;
    private $fecha;

    public function getObraSocial() {
        return $this->ObraSocial;
    }

    public function setObraSocial($ObraSocial) {
        $this->ObraSocial = $ObraSocial;
    }

    public function setIdVentaFarmacia($idVentaFarmacia) {
        $this->idVentaFarmacia = $idVentaFarmacia;
    }

    public function setFarmacia($Farmacia) {
        $this->Farmacia = $Farmacia;
    }

    public function setManual($Manual) {
        $this->Manual = $Manual;
    }

    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    public function setDni($dni) {
        $this->dni = $dni;
    }

    public function setNombreApellido($nombreApellido) {
        $this->nombreApellido = $nombreApellido;
    }

    public function setMatriculaMedico($matriculaMedico) {
        $this->matriculaMedico = $matriculaMedico;
    }

    public function setNroRecetario($nroRecetario) {
        $this->nroRecetario = $nroRecetario;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function getIdVentaFarmacia() {
        return $this->idVentaFarmacia;
    }

    public function getFarmacia() {
        return $this->Farmacia;
    }

    public function getManual() {
        return $this->Manual;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function getDni() {
        return $this->dni;
    }

    public function getNombreApellido() {
        return $this->nombreApellido;
    }

    public function getMatriculaMedico() {
        return $this->matriculaMedico;
    }

    public function getNroRecetario() {
        return $this->nroRecetario;
    }

    public function getFecha() {
        return $this->fecha;
    }

}

?>
