<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'Business/parametros.class.php';
/**
 * Description of parametrosBD
 *
 * @author David
 */
class parametrosBD {
    
    public function getParameters(){
        $db = DB::getInstance();
        $con = $db->query("select * from parametros ");
        while($r = $db->fetch_array($con)){
            $new = new parametros();
            $new->setFecha1($r['fecha1']);
            $new->setFecha2($r['fecha2']);
            return $new;
        }
        
        
    }
}

?>
