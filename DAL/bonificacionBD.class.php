<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'Business/bonificacion.class.php';

/**
 * Description of bonificacionBD
 *
 * @author David
 */
class bonificacionBD {

    public function getById($idFar, $idOS) {
        $db = db::getInstance(); // finalmente tenemos visibilidad al objeto db (conexion)
        $sql = "select farmacia,obrasocial,porcentaje from bonificaciones where farmacia='$idFar' and obrasocial='$idOS'";
        $consulta = $db->query($sql);
        require_once 'DAL/farmaciaBD.class.php';
        $fardb = new farmaciaBD();
        require_once 'DAL/obraSocialBD.class.php';
        $osdb = new obraSocialBD();
        if ($db->num_rows($consulta) > 0) {
            $r = $db->fetch_array($consulta);
            $bon = new bonificacion();
            $bon->setFarmacia($fardb->getPharmacyById($r['farmacia']));
            $bon->setObraSocial($osdb->getOSById($r['obrasocial']));
            $bon->setPorcentaje($r['porcentaje']);
            return $bon;
        }
    }

}

?>
