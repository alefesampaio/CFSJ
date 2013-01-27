<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of drogueria
 *
 * @author David
 */
class drogueria {
    
    private $idDrogueria;
    private $codigo;
    private $denominacion;
    
    public function getIdDrogueria() {
        return $this->idDrogueria;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getDenominacion() {
        return $this->denominacion;
    }

    public function setIdDrogueria($idDrogueria) {
        $this->idDrogueria = $idDrogueria;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    public function setDenominacion($denominacion) {
        $this->denominacion = $denominacion;
    }


}

?>
