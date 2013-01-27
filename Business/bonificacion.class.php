<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of bonificacion
 *
 * @author David
 */
class bonificacion {
    
    private $porcentaje;
    private $Farmacia;
    private $ObraSocial;
    
    public function getPorcentaje() {
        return $this->porcentaje;
    }

    public function getFarmacia() {
        return $this->Farmacia;
    }

    public function getObraSocial() {
        return $this->ObraSocial;
    }

    public function setPorcentaje($porcentaje) {
        $this->porcentaje = $porcentaje;
    }

    public function setFarmacia($Farmacia) {
        $this->Farmacia = $Farmacia;
    }

    public function setObraSocial($ObraSocial) {
        $this->ObraSocial = $ObraSocial;
    }


}

?>
