<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'DAL/parametrosBD.class.php';
/**
 * Description of managerParametros
 *
 * @author David
 */
class managerParametros {
    
    public static function obtenerParametros(){
        $p = new parametrosBD();
        return $p->getParameters();
    }
}

?>
