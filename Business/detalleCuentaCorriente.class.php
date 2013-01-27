<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of detalleCuentaCorriente
 *
 * @author David
 */
class detalleCuentaCorriente {
    
    private $debe;
    private $haber;
    private $fecha;
    private $detalle;
    
    public function getDebe() {
        return $this->debe;
    }

    public function getHaber() {
        return $this->haber;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getDetalle() {
        return $this->detalle;
    }

    public function setDebe($debe) {
        $this->debe = $debe;
    }

    public function setHaber($haber) {
        $this->haber = $haber;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function setDetalle($detalle) {
        $this->detalle = $detalle;
    }


        
    
}

?>
