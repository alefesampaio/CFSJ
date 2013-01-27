<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of medico
 *
 * @author David
 */
class medico {
    
    private $idMedico;
    private $matricula;
    private $nombre;
    
    public function getIdMedico() {
        return $this->idMedico;
    }

    public function getMatricula() {
        return $this->matricula;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setIdMedico($idMedico) {
        $this->idMedico = $idMedico;
    }

    public function setMatricula($matricula) {
        $this->matricula = $matricula;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }


    }

?>
