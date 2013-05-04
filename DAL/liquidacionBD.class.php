<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'Business/liquidacion.class.php';

/**
 * Description of bonificacionBD
 *
 * @author David
 */
class liquidacionBD {

    public function showAll($params = array()) {
        if(empty($params['rendicion']) || empty($params['farmaciaId'])) 
            return false;
        $db = db::getInstance();
        $rendicion = $db->prepare($params['rendicion']);
        $farmaciaId = $db->prepare($params['farmaciaId']);        
        $sql = "SELECT * 
                FROM liquidacion 
                WHERE liquidacion.rendicion = '$rendicion' 
                AND liquidacion.codigo = '$farmaciaId'";
        $consulta = $db->query($sql);
        $listado = array();
        
        while ($r = $db->fetch_array($consulta)) {
            $liq = new liquidacion();
            $liq->setImputacion($r['imputacion']);
            $liq->setConfirmado($r['confirma']);
            $liq->setEgresos($r['egresos']);
            $liq->setIngresos($r['ingresos']);
            $liq->setDescuento($r['descuento']);
            $liq->setObraSocial($r['obra_social']);
            $liq->setPlan($r['plan']);
            $liq->setMes($r['mes']);
            $liq->setAnio($r['anio']);
            $liq->setQuincena($r['quincena']);            
            $listado[] = $liq;
        }
        return $listado;
    }

}

?>