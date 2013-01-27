<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of localidad
 *
 * @author David
 */
class localidad {
    
    private $idLocalidad;
    private $nombre;
    private $codigoPostal;
    private $provincia;
    
    public function getCodigoPostal() {
        return $this->codigoPostal;
    }

    public function setCodigoPostal($codigoPostal) {
        $this->codigoPostal = $codigoPostal;
    }

    
    public function setIdLocalidad($idLocalidad) {
        $this->idLocalidad = $idLocalidad;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setProvincia($provincia) {
        $this->provincia = $provincia;
    }

    public function getIdLocalidad() {
        return $this->idLocalidad;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getProvincia() {
        return $this->provincia;
    }


}

?>
