<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require "Business/farmacia.class.php";

/**
 * Description of farmaciaBD
 *
 * @author David
 */
class farmaciaBD {

    public static function mostrarFarmacias() {

        $db = Db::getInstance();
        $cr = "razon";
        try {
            $consulta = $db->query("SELECT * FROM farmacias ORDER BY $cr");
            $lista = array();
            while ($r = $db->fetch_array($consulta)) {
                $f = new Farmacia();
                $f->setIdFarmacia($r['codigo']);
                $f->setRazonSocial($r['razon']);
                $lista[] = $f;
            }
            $db->free_result($consulta);
        } catch (exception $e) {
            
        }
        return $lista;
    }

    public static function getPharmacyById($id) {

        $db = db::getInstance(); // finalmente tenemos visibilidad al objeto db (conexion)
        $sql = "select codigo,razon,fantasia,propietario,dt,dt_codigo,domicilio,telefono,cuit,localidad,cpostal,provincia,barras,es_drogueria from farmacias where codigo=$id ";
        $consulta = $db->query($sql);
        if ($db->num_rows($consulta) > 0) {
            $r = $db->fetch_array($consulta);
            $phar = new farmacia();
            $phar->setIdFarmacia($r['codigo']);
            $phar->setRazonSocial($r['razon']);
            $phar->setNombreFantasia($r['fantasia']);
            $phar->setNombrePropietario($r['propietario']);
            require_once 'Business/directorTecnico.class.php';
            $dt = new directorTecnico();
            $dt->setMatricula($r['dt_codigo']);
            $dt->setNombreYApellido($r['dt']);
            $phar->setDirectorTecnico($dt);
            $phar->setDomicilio($r['domicilio']);
            $phar->setTelefono($r['telefono']);
            $phar->setCuit($r['cuit']);
            $phar->setContadorBarra($r['barras']);
            $phar->setEsDrogueria($r['es_drogueria']);
            $phar->setCodigoPostal($r['cpostal']);
            $phar->setLocalidad($r['localidad']);
            $phar->setProvincia($r['provincia']);
            return $phar;
        }
    }

    public static function isValidLicense($matricula, $idFar) {

        $db = db::getInstance(); // finalmente tenemos visibilidad al objeto db (conexion)
        $matricula = $db->prepare($matricula);
        $sql = "select dt_codigo from farmacias where dt_codigo = '$matricula' and codigo='$idFar'";
        $consulta = $db->query($sql);
        if ($db->num_rows($consulta) > 0) {
            return true;
        } else {
            return false;
        }
    }

}

?>
