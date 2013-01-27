<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of manual
 *
 * @author David
 */
class manual {
    
    private $idManual;
    private $troquel;
    private $nombre;
    private $presentacion;
    private $laboratorio;
    private $precio;
    private $fecha;
    private $registro;
    private $barra;
    private $unidades;
    private $tamanio;
    
    public function getIdManual() {
        return $this->idManual;
    }

    public function getTroquel() {
        return $this->troquel;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getPresentacion() {
        return $this->presentacion;
    }

    public function getLaboratorio() {
        return $this->laboratorio;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getRegistro() {
        return $this->registro;
    }

    public function getBarra() {
        return $this->barra;
    }

    public function getUnidades() {
        return $this->unidades;
    }

    public function getTamanio() {
        return $this->tamanio;
    }

    public function setIdManual($idManual) {
        $this->idManual = $idManual;
    }

    public function setTroquel($troquel) {
        $this->troquel = $troquel;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setPresentacion($presentacion) {
        $this->presentacion = $presentacion;
    }

    public function setLaboratorio($laboratorio) {
        $this->laboratorio = $laboratorio;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function setRegistro($registro) {
        $this->registro = $registro;
    }

    public function setBarra($barra) {
        $this->barra = $barra;
    }

    public function setUnidades($unidades) {
        $this->unidades = $unidades;
    }

    public function setTamanio($tamanio) {
        $this->tamanio = $tamanio;
    }


}

?>
