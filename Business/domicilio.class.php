<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of domicilio
 *
 * @author David
 */
class domicilio {

    private $idDomicilio;
    private $calle;
    private $nro;
    private $barrio;
    
    public function getIdDomicilio() {
        return $this->idDomicilio;
    }

    public function setIdDomicilio($idDomicilio) {
        $this->idDomicilio = $idDomicilio;
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

    public function setCalle($calle) {
        $this->calle = $calle;
    }

    public function setNro($nro) {
        $this->nro = $nro;
    }

    public function setBarrio($barrio) {
        $this->barrio = $barrio;
    }


}

?>
