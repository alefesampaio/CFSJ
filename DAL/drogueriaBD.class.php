<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'Business/drogueria.class.php';
/**
 * Description of drogueriaBD
 *
 * @author David
 */
class drogueriaBD {
    
    public function getByCodigo($id) {

        $db = db::getInstance(); // finalmente tenemos visibilidad al objeto db (conexion)
        $sql = "select * from droguerias where codigo=$id ";
        $consulta = $db->query($sql);
        if ($db->num_rows($consulta) > 0) {
            $r = $db->fetch_array($consulta);
            $dro = new drogueria();
            $dro->setIdDrogueria($r['row_id']);
            $dro->setDenominacion($r['denominacion']);
            $dro->setCodigo($r['codigo']);
            return $dro;
        }
    }
}

?>
