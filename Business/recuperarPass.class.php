<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of recuperarPass
 *
 * @author David
 */
class recuperarPass {
    
    private $idRecuperar;
    private $email;
    private $codigo;
    private $fecha;
    private $ip;
    
    public function getIdRecuperar() {
        return $this->idRecuperar;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getIp() {
        return $this->ip;
    }

    public function setIdRecuperar($idRecuperar) {
        $this->idRecuperar = $idRecuperar;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function setIp($ip) {
        $this->ip = $ip;
    }


}

?>
