<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of msjAdmin
 *
 * @author David
 */
class msjAdmin {
    
    private $idMensaje;
    private $detalle;
    public $usuario;
    private $fecha;
    
    public function getIdMensaje() {
        return $this->idMensaje;
    }

    public function getDetalle() {
        return $this->detalle;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function setIdMensaje($idMensaje) {
        $this->idMensaje = $idMensaje;
    }

    public function setDetalle($detalle) {
        $this->detalle = $detalle;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }


}

?>
