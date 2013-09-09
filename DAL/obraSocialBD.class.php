<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once "Business/obraSocial.class.php";
/**
 * Description of obraSocialBD
 *
 * @author David
 */
class obraSocialBD {
    
    public function mostrarOS() {
       
        $db =  Db::getInstance();
        $cr = "denomina";
      try{
        $consulta = $db->query("SELECT codigo FROM obrasocial ORDER BY $cr");
        $lista = array();
      while ($r = $db->fetch_array($consulta)) {
            $os = $this->getOSById($r['codigo']);
            $lista[] = $os;
           }
            $db->free_result($consulta);
                       
       } catch (exception $e) {
                   
            
        }
        return $lista;
    }
    
    public function getOSById($id){
        $db = db::getInstance(); // finalmente tenemos visibilidad al objeto db (conexion)
        $sql = "select * from obrasocial where codigo=$id ";
        $consulta = $db->query($sql);
        if($db->num_rows($consulta)> 0){
         $r = $db->fetch_array($consulta);
        $os = new obraSocial();
        $os->setIdObraSocial($r['codigo']);
        $os->setDenominacion($r['denomina']);
        $os->setCuit($r['cuit']);
        $os->setPeriodo($r['periodo']);
        $os->setCierre1($r['dia_1q']);
        $os->setCierre2($r['dia_2q']);
        $os->setInicio1($r['inicia_1q']);
        $os->setInicio2($r['inicia_2q']);
        $os->setAgrupaCaratula($r['agrupa_caratula']);
        $os->setAgrupaLiquidacion($r['agrupa_liquida']);
        return $os;
        }   
        
       } 
    
    public function getByCloseDay($dia){
        
        $db =  Db::getInstance();
        $dia = $db->prepare($dia);
        $cr = "denomina";
      try{
        $consulta = $db->query("SELECT codigo FROM obrasocial where dia_1q=$dia or dia_2q=$dia order by $cr");
        $lista = array();
      while ($r = $db->fetch_array($consulta)) {
            $os = $this->getOSById($r['codigo']);
            $lista[] = $os;
           }
            $db->free_result($consulta);
                       
       } catch (exception $e) {
                   
            
        }
        return $lista;
        
        
        
    }
    
    public function getByOpenDay($dia){
        
        $db =  Db::getInstance();
        $dia = $db->prepare($dia);
        $cr = "denomina";
      try{
        $consulta = $db->query("SELECT codigo FROM obrasocial where inicia_1q=$dia or inicia_2q=$dia order by $cr");
        $lista = array();
      while ($r = $db->fetch_array($consulta)) {
            $os = $this->getOSById($r['codigo']);
            $lista[] = $os;
           }
            $db->free_result($consulta);
                       
       } catch (exception $e) {
                   
            
        }
        return $lista;
        
        
        
    }
    
    
}

?>
