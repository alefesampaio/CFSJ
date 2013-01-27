<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of provincia
 *
 * @author David
 */
class provincia {
    
    private $idProvincia;
    private $nombre;
    
    public function getIdProvincia() {
        return $this->idProvincia;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setIdProvincia($idProvincia) {
        $this->idProvincia = $idProvincia;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }


}

?>
