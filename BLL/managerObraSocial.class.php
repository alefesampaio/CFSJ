<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require "DAL/obraSocialBD.class.php";
/**
 * Description of managerObraSocial
 *
 * @author David
 */
class managerObraSocial {
    
   public static function obtenerTodos(){
        $osdb = new obraSocialBD();
        return $osdb->mostrarOS();
    } 

   public static function obtenerOSPorId($id){
        $osdb = new obraSocialBD();
        return $osdb->getOSById($id);
    } 
    
   public static function obtenerPorDiaCierre($dia){
       $osdb = new obraSocialBD();
        return $osdb->getByCloseDay($dia);
   } 
   public static function obtenerPorDiaApertura($dia){
       $osdb = new obraSocialBD();
        return $osdb->getByOpenDay($dia);
   } 
    
}

?>
