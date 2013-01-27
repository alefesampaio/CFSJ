<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of parametros
 *
 * @author David
 */
class parametros {
    private $fecha1;
    private $fecha2;
    public function setFecha1($fecha1) {
        $this->fecha1 = $fecha1;
    }

    public function setFecha2($fecha2) {
        $this->fecha2 = $fecha2;
    }

    public function getFecha1() {
        return $this->fecha1;
    }

    public function getFecha2() {
        return $this->fecha2;
    }


}

?>
