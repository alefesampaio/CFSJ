<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of usuario
 *
 * @author David
 */
class Usuario {
    
    private $idUser;
    private $usuario;
    private $pass;
    public $nivelAdmin;
    private $email;
    private $sexo;
    private $fechaNac;
    private $fechaReg;
    private $loginKey;
    private $activo;
    private $ipLogin;
    private $ipReg;
    private $ultimaVisita;
    public $Farmacia;

       
    public function setLoginKey($loginKey) {
        $this->loginKey = $loginKey;
    }

    public function setIpLogin($ipLogin) {
        $this->ipLogin = $ipLogin;
    }

    public function setUltimaVisita($ultimaVisita) {
        $this->ultimaVisita = $ultimaVisita;
    }

        public function setIdUser($id){
        $this->idUser = $id;
    }
    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function setPass($pass) {
        $this->pass = $pass;
    }

    public function setNivelAdmin($nivelAdmin) {
        $this->nivelAdmin = $nivelAdmin;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setSexo($sexo) {
        $this->sexo = $sexo;
    }

    public function setFechaNac($fechaNac) {
        $this->fechaNac = $fechaNac;
    }
    public function setFechaReg($fechaReg) {
        $this->fechaReg = $fechaReg;
    }
    public function setIpReg($ipReg) {
        $this->ipReg = $ipReg;
    }
    public function setFarmacia($Farmacia) {
        $this->Farmacia = $Farmacia;
    }

    public function setActivo($activo) {
        $this->activo = $activo;
    }

    public function getIdUser() {
    return $this->idUser;
    }
    public function getUsuario() {
        return $this->usuario;
    }

    public function getPass() {
        return $this->pass;
    }

    public function getNivelAdmin() {
        return $this->nivelAdmin;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getSexo() {
        return $this->sexo;
    }

    public function getFechaNac() {
        return $this->fechaNac;
    }

    public function getFechaReg() {
        return $this->fechaReg;
    }

    public function getLoginKey() {
        return $this->loginKey;
    }

    public function getActivo() {
        return $this->activo;
    }

    public function getIpLogin() {
        return $this->ipLogin;
    }

    public function getIpReg() {
        return $this->ipReg;
    }

    public function getUltimaVisita() {
        return $this->ultimaVisita;
    }

    public function getFarmacia() {
        return $this->Farmacia;
    }

    public function toString(){
        return "Usuario: ".$this->usuario."\t".
               "Email : ".$this->email."\t".
               "Fecha Nacimiento: ".$this->fechaNac."\t";
                
        
    }

    
}


?>
