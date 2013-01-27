<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'Business/unidad.class.php';

/**
 * Description of unidadBD
 *
 * @author David
 */
class unidadBD {

    public function showUnits() {
        $db = Db::getInstance();
        $consulta = $db->query("select idUnidad from unidadperiodo");
        $lista = array();
        if ($db->num_rows($consulta) > 0) {
            while ($r = $db->fetch_array($consulta)) {
                $e = self::getById($r['idUnidad']);
                $lista[] = $e;
            }
        }
        return $lista;
    }

    public function getById($id) {
        $db = Db::getInstance();
        $consulta = $db->query("select idUnidad,detalle from unidadperiodo where idUnidad='" . $db->prepare($id) . "'");
        if ($db->num_rows($consulta) > 0) {
            $r2 = $db->fetch_array($consulta);
            $u = new unidad();
            $u->setIdUnidad($r2['idUnidad']);
            $u->setDetalle($r2['detalle']);
        }
        return $u;
    }

}

?>
