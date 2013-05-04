<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'DAL/liquidacionBD.class.php';

/**
 * Description of managerCuentaCorriente
 *
 * @author David
 */
class managerLiquidacion {

    public static function obtenerTodos($params = array()) {
        $ldb = new liquidacionBD();
        return $ldb->showAll($params);
    }
}

?>