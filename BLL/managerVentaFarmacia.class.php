<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'DAL/ventaFarmaciaBD.class.php';
/**
 * Description of managerVentasFarmacia
 *
 * @author David
 */
class managerVentaFarmacia {
    
    public static function obtenerTodos(){
        $vtadb = new ventaFarmaciaBD();
        return $vtadb->getAll();
    }
    
    public static function insertar($venta){
        $vtadb = new ventaFarmaciaBD();
        return $vtadb->insert($venta);
    }
}

?>
