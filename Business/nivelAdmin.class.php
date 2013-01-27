<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of nivelAdmin
 *
 * @author David
 */
class nivelAdmin {
    
    private $idAdmin;
    private $descripcion;
    
    public function getIdAdmin() {
        return $this->idAdmin;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }
    
    public function setIdAdmin($idAdmin) {
        $this->idAdmin = $idAdmin;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }



}

?>
