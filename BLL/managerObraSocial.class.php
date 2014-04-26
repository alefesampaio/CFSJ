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
   public static function obtenerPeriodo($id_os){ 
    $os = self::obtenerOSPorId($id_os);
    if (!empty($os)) {
      $f = new DateTime();
      $q = 2;
      $today = (int) $f->format("d");
      $mes = (int) $f->format("m");
      $anio = (int) $f->format("Y");
      require_once 'funciones/functions.php';
      $meses = meses();
      if ($os->getPeriodo() == 1)
          $q = 3;
      if ($os->getCierre2() < $os->getInicio2() or ($os->getInicio2()<10)) {
          if ($today <= $os->getCierre2())
              $mes--;
          if ($mes == 0){
        $mes = 12; $anio--;
        }
              
      }
      if ($q!=3 and $today >= $os->getInicio1() and $today <= $os->getCierre1()) {
          $q = 1;
      }
      
      $_SESSION['quincena'] = $q;
      $_SESSION['mes'] = $mes;
      $_SESSION['anio'] = $anio;

      if ($q != 3)
          return $q . "° quincena de " . $meses[$mes];
      else
          return "Mes de $meses[$mes]";
    }
   }

    
}

?>
