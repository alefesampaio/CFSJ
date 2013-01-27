<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of directorTecnico
 *
 * @author David
 */
class directorTecnico {
   
    private $matricula;
    private $nombreYApellido;
    private $domicilio;
    private $telefono;
    private $email;
   
    
    public function getNombreYApellido() {
        return $this->nombreYApellido;
    }

    public function setNombreYApellido($nombreYApellido) {
        $this->nombreYApellido = $nombreYApellido;
    }

    
    public function getMatricula() {
        return $this->matricula;
    }

    

    public function getDomicilio() {
        return $this->domicilio;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setMatricula($matricula) {
        $this->matricula = $matricula;
    }

   
    public function setDomicilio($domicilio) {
        $this->domicilio = $domicilio;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function setEmail($email) {
        $this->email = $email;
    }


}

?>
