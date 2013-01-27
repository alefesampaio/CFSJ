<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'DAL/bonificacionBD.class.php';
/**
 * Description of managerBonificacion
 *
 * @author David
 */
class managerBonificacion {
    
    public static function obtenerPorId($idFar, $idOS){
        $bdb = new bonificacionBD();
        return $bdb->getById($idFar, $idOS);
    }
}

?>
