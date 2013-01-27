<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'DAL/servicioBD.class.php';
/**
 * Description of managerServicio
 *
 * @author David
 */
class managerServicio {
    
    public static function obtenerAutenticacionDeServicio($idServicio, $idUser){
        $svcdb = new servicioBD();
        return $svcdb->getAuthService($idServicio, $idUser);
    }
    
    public static function obtenerPorId($idServicio){
        $svcdb = new servicioBD();
        return $svcdb->getById($idServicio);
    }
}

?>
