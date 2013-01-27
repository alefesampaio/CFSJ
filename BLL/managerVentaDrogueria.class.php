<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'DAL/ventaDrogueriaBD.class.php';
/**
 * Description of managerVentaDrogueria
 *
 * @author David
 */
class managerVentaDrogueria {
    
    public static function obtenerTodos(){
        $vtadb = new ventaDrogueriaBD();
        return $vtadb->getAll();
    }
    
    public static function insertar($venta){
        $vtadb = new ventaDrogueriaBD();
        return $vtadb->insert($venta);
    }
}

?>
