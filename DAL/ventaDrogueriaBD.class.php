<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'Business/ventaDrogueria.class.php';

/**
 * Description of ventaDrogueriaBD
 *
 * @author David
 */
class ventaDrogueriaBD {

    public function getAll() {
        $db = Db::getInstance();
        try {
            //$db->query("SET NAMES 'utf8'");
            $consulta = $db->query("select row_id from auditoria_drogueria order by fecha_venta desc ");
            $lista = array();
            while ($r = $db->fetch_array($consulta)) {
                $newSale = self::getById($r['row_id']);
                $lista[] = $newSale;
            }
            $db->free_result($consulta);
        } catch (exception $e) {
            
        }
        return $lista;
    }

    public function getById($idSale, $object=true) {
        $db = db::getInstance(); // finalmente tenemos visibilidad al objeto db (conexion)
        $consulta = $db->query("select * from auditoria_drogueria where row_id = '" . $db->prepare($idSale) . "'");
        if ($db->num_rows($consulta) > 0) {
            if (!$object)
                return;
            require_once 'DAL/farmaciaBD.class.php';
            $fardb = new farmaciaBD();
            require_once 'DAL/manualBD.class.php';
            $mandb = new manualBD();
            require_once 'DAL/drogueriaBD.class.php';
            $drodb = new drogueriaBD();
            
            $s = $db->fetch_array($consulta);
            $newSale = new ventaDrogueria();
            $newSale->setIdVentaDrogueria($s['row_id']);
            $newSale->setFecha($s['fecha_venta']);
            $newSale->setFechaVencimiento($s['vto']);
            $newSale->setCantidad($s['cantidad']);
            $newSale->setNroFactura($s['factura_numero']);
            $newSale->setNroLote($s['partida_lote']);
            $newSale->setFarmacia($fardb->getPharmacyById($s['farmacia']));
            $newSale->setManual($mandb->getByRegistro($s['registro']));
            $newSale->setDrogueria($drodb->getByCodigo($s['drogueria']));
            //@todo
            //farmacia
            //drogueria
            //registro
            //            require_once 'DAL/farmaciaBD.class.php';
            return $newSale;
        }else
            return false;
    }

    public function insert(ventaDrogueria $v) {
        $db = Db::getInstance();
        $rpta = false;
        try {
            $db->query("BEGIN");
            $sql = "INSERT INTO auditoria_drogueria (drogueria,farmacia,fecha_venta,factura_numero,registro,partida_lote,vto,cantidad) " .
                    " VALUES('" . $v->getDrogueria() . "','" . $v->getFarmacia() . "','" . $v->getFecha() . "','" . $v->getNroFactura() . "'," .
                    "'" . $v->getManual() . "','" . $v->getNroLote() . "','" . $v->getFechaVencimiento() . "','" . $v->getCantidad() . "') ";
            $result = $db->query($sql);
            if (!$result) {
                //Niega la insercion
                $db->query("ROLLBACK");
            } else {
                //Realiza el commit
                $db->query("COMMIT");
                $rpta = true;
            }
        } catch (exception $e) {
            try {
                $db->query("ROLLBACK");
            } catch (exception $e1) {
                
            }
        }
        return $rpta;
    }

}

?>
