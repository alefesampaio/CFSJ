<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require "Business/nivelAdmin.class.php";
/**
 * Description of nivelAdminBD
 *
 * @author David
 */
class nivelAdminBD {
    
    public static function mostrarNiveles() {
       
        $db =  Db::getInstance();
        $cr = "idAdmin";
      try{
        $consulta = $db->query("SELECT * FROM niveladmin ORDER BY $cr");
        $lista = array();
      while ($r = $db->fetch_array($consulta)) {
            $n = new nivelAdmin();
            $n->setIdAdmin($r['idAdmin']);
            $n->setDescripcion($r['descripcion']);
            $lista[] = $n;
           }
            $db->free_result($consulta);
                       
       } catch (exception $e) {
                   
            
        }
        return $lista;
    }
    
    public static function getById($id) {
       
        $db =  Db::getInstance();
     try{
        $consulta = $db->query("SELECT idAdmin,descripcion FROM niveladmin where idAdmin='".$db->prepare($id)."'");
     while ($r = $db->fetch_array($consulta)) {
            $n = new nivelAdmin();
            $n->setIdAdmin($r['idAdmin']);
            $n->setDescripcion($r['descripcion']);
            
           }
            $db->free_result($consulta);
                       
       } catch (exception $e) {
                   
            
        }
        return $n;
    }
    
}

?>
