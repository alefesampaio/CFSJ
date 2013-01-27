<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require 'DAL/unidadBD.class.php';
/**
 * Description of managerUnidad
 *
 * @author David
 */
class managerUnidad {
    
    public static function obtenerTodos(){
        $udb = new unidadBD();
        return $udb->showUnits();
        
    }
}

?>
