<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of plan
 *
 * @author David
 */
class plan {
    
    private $idPlan;
    private $descripcion;
    public $ObraSocial;
    private $diasVigencia;
    private $vademecum;
    public function getIdPlan() {
        return $this->idPlan;
    }
    

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getObraSocial() {
        return $this->ObraSocial;
    }

    public function getDiasVigencia() {
        return $this->diasVigencia;
    }

    public function getVademecum() {
        return $this->vademecum;
    }

    public function setIdPlan($idPlan) {
        $this->idPlan = $idPlan;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setObraSocial($obraSocial) {
        $this->ObraSocial = $obraSocial;
    }

    public function setDiasVigencia($diasVigencia) {
        $this->diasVigencia = $diasVigencia;
    }

    public function setVademecum($vademecum) {
        $this->vademecum = $vademecum;
    }


}

?>
