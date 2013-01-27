<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of barrio
 *
 * @author David
 */
class barrio {
    
    private $idBarrio;
    private $nombre;
    private $localidad;
    
    public function getIdBarrio() {
        return $this->idBarrio;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getLocalidad() {
        return $this->localidad;
    }


    public function setIdBarrio($idBarrio) {
        $this->idBarrio = $idBarrio;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setLocalidad($localidad) {
        $this->localidad = $localidad;
    }


}

?>
