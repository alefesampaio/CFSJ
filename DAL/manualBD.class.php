<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'Business/manual.class.php';
/**
 * Description of manualBD
 *
 * @author David
 */
class manualBD {
    
    public function getByRegistro($id) {

        $db = db::getInstance(); // finalmente tenemos visibilidad al objeto db (conexion)
        $sql = "select * from manual where registro=$id ";
        $consulta = $db->query($sql);
        if ($db->num_rows($consulta) > 0) {
            $r = $db->fetch_array($consulta);
            $man = new manual();
            $man->setIdManual($r['row_id']);
            $man->setFecha($r['fecha']);
            $man->setBarra($r['barra']);
            $man->setLaboratorio($r['laboratorio']);
            $man->setNombre($r['nombre']);
            $man->setPrecio($r['precio']);
            $man->setPresentacion($r['presentacion']);
            $man->setRegistro($r['registro']);
            $man->setTamanio($r['tamanio']);
            $man->setTroquel($r['troquel']);
            $man->setUnidades($r['unidades']);
            return $man;
        }
    }
}

?>
