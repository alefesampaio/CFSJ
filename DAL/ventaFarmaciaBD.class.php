<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'Business/ventaFarmacia.class.php';

/**
 * Description of ventaFarmaciaBD
 *
 * @author David
 */
class ventaFarmaciaBD {

    public function getAll() {
        $db = Db::getInstance();
        try {
            //$db->query("SET NAMES 'utf8'");
            $consulta = $db->query("select row_id from auditoria_farmacia order by fecha desc ");
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
        $consulta = $db->query("select * from auditoria_farmacia where row_id = '" . $db->prepare($idSale) . "'");
        if ($db->num_rows($consulta) > 0) {
            if (!$object)
                return;
            require_once 'DAL/farmaciaBD.class.php';
            $fardb = new farmaciaBD();
            require_once 'DAL/manualBD.class.php';
            $mandb = new manualBD();
            require_once 'DAL/obraSocialBD.class.php';
            $obdb = new obraSocialBD();
            
            $s = $db->fetch_array($consulta);
            $newSale = new ventaFarmacia();
            $newSale->setIdVentaFarmacia($s['row_id']);
            $newSale->setCantidad($s['cantidad']);
            $newSale->setDni($s['cliente_dni']);
            $newSale->setNombreApellido($s['apellido']);
            $newSale->setFecha($s['fecha']);
            $newSale->setMatriculaMedico($s['matricula_medico']);
            $newSale->setNroRecetario($s['recetario_nro']);
            $newSale->setFarmacia($fardb->getPharmacyById($s['farmacia']));
            $newSale->setManual($mandb->getByRegistro($s['registro']));
            $newSale->setObraSocial($obdb->getOSById($s['obra_social']));
            
            return $newSale;
        }else
            return false;
    }

    public function insert(ventaFarmacia $v) {
        $db = Db::getInstance();
        $rpta = false;
        try {
            $db->query("BEGIN");
            $sql = "INSERT INTO auditoria_farmacia (farmacia,registro,cantidad,obra_social,cliente_dni,apellido,matricula_medico,recetario_nro,fecha) " .
                    " VALUES('" . $v->getFarmacia() . "','" . $v->getManual() . "','" . $v->getCantidad() . "','" . $v->getObraSocial() . "'," .
                    "'" . $v->getDni() . "','" . $v->getNombreApellido() . "','" . $v->getMatriculaMedico() . "','" . $v->getNroRecetario() . "', '" . $v->getFecha() . "') ";
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
