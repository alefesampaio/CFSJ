<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of servicio
 *
 * @author David
 */
class servicio {
    
    private $idServicio;
    private $descripcion;
    private $path;
    
    public function getPath() {
        return $this->path;
    }

    public function setPath($path) {
        $this->path = $path;
    }

        public function getIdServicio() {
        return $this->idServicio;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setIdServicio($idServicio) {
        $this->idServicio = $idServicio;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }


}

?>
