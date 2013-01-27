<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of unidad
 *
 * @author David
 */
class unidad {
    
    private $idUnidad;
    private $detalle;
    
    public function getIdUnidad() {
        return $this->idUnidad;
    }

    public function getDetalle() {
        return $this->detalle;
    }

    public function setIdUnidad($idUnidad) {
        $this->idUnidad = $idUnidad;
    }

    public function setDetalle($detalle) {
        $this->detalle = $detalle;
    }


}

?>
