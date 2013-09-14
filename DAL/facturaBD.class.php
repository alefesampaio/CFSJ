<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require "Business/factura.class.php";

/**
 * Description of facturaBD
 *
 * @author David
 */
class facturaBD {

    public function showFacturas($criterio, $idFar) {
        $db = Db::getInstance();
        $cr = $db->prepare($criterio);
        try {
            $sql = "SELECT row_id,SUM(recetas) as totalRecetas,SUM(arancel) as totalImporte,"
                    . "SUM(arancel_os) as totalEntidad,SUM(importe_bonificacion) as totalNeto from factura"
                    . " WHERE farmacia='$idFar' AND colfanet='0' group by barra ORDER BY $cr";
            $consulta = $db->query($sql);
            $lista = array();
            while ($r = $db->fetch_array($consulta)) {
                $fac = self::getInvoiceByIdObj($r['row_id'], $idFar);
                $fac->setCantRecetas($r['totalRecetas']);
                $fac->setArancel($r['totalImporte']);
                $fac->setArancelOS($r['totalEntidad']);
                $fac->setImporteBonificacion($r['totalNeto']);
                $lista[] = $fac;
            }
            $db->free_result($consulta);
        } catch (exception $e) {
            
        }
        return $lista;
    }

    public function showFacturas2($criterio, $idFar) {
        $db = Db::getInstance();
        $cr = $db->prepare($criterio);
        try {
            $sql = "SELECT f.row_id,f.farmacia,f.recetas,f.arancel,f.arancel_os,f.plan,f.obra_soc,f.quincena,f.mes,f.anio,f.folio1," .
                    "f.folio2,f.operador,f.fecha,f.barra,f.recibido,f.confirmado,f.bonificacion," .
                    "f.importe_bonificacion,f.agrupado,SUM(f.recetas) as totalRecetas," .
                    "SUM(f.arancel) as totalImporte,SUM(f.arancel_os) as totalEntidad," .
                    "SUM(f.importe_bonificacion) as totalNeto,p.detalle as pplan,o.denomina as os," .
                    "u.detalle as unidad,fa.razon,fa.fantasia,fa.cuit,fa.domicilio,fa.dt " .
                    "from factura as f " .
                    "inner join planes_os as p on f.plan = p.plan " .
                    "inner join obrasocial as o on f.obra_soc = o.codigo " .
                    "inner join unidadperiodo as u on f.quincena = u.idUnidad " .
                    "inner join farmacias as fa on f.farmacia = fa.codigo " .
                    "WHERE f.farmacia='$idFar' AND f.colfanet='0' group by f.barra ORDER BY $cr";
            $consulta = $db->query($sql);
            $lista = array();
            require_once 'Business/farmacia.class.php';
            require_once 'Business/plan.class.php';
            require_once 'Business/obraSocial.class.php';
            require_once 'Business/unidad.class.php';
            while ($r = $db->fetch_array($consulta)) {
                $fac = new factura();
                $fac->setIdFactura($r['row_id']);
                $fac->setCodigoBarra($r['barra']);
                $fac->setFecha($r['fecha']);
                $fac->setFolioDesde($r['folio1']);
                $fac->setFolioHasta($r['folio2']);
                $fac->setCantRecetas($r['recetas']);
                $fac->setArancel($r['arancel']);
                $fac->setArancelOS($r['arancel_os']);
                $fac->setMes($r['mes']);
                $fac->setAnio($r['anio']);
                $fac->setOperador($r['operador']);
                $fac->setRecibido($r['recibido']);
                $fac->setConfirmado($r['confirmado']);
                $fac->setImporteBonificacion($r['importe_bonificacion']);
                $fac->setPorcentajeBonificacion($r['bonificacion']);
                $fac->setAgrupado($r['agrupado']);
                $pharmacy = new farmacia();
                $pharmacy->setIdFarmacia($r['farmacia']);
                $pharmacy->setDomicilio($r['domicilio']);
                $pharmacy->setNombreFantasia($r['fantasia']);
                $pharmacy->setRazonSocial($r['razon']);
                $pharmacy->setCuit($r['cuit']);
                $dt = new directorTecnico();
                $dt->setNombreYApellido($r['dt']);
                $pharmacy->setDirectorTecnico($dt);
                $fac->setFarmacia($pharmacy);
                $plan =  new plan();
                $plan->setIdPlan($r['plan']);
                $plan->setDescripcion($r['pplan']);
                $os = new obraSocial();
                $os->setIdObraSocial($r['obra_soc']);
                $os->setDenominacion($r['os']);
                $plan->setObraSocial($os);                        
                $fac->setPlan($plan);
                $uni = new unidad();
                $uni->setIdUnidad($r['quincena']);
                $uni->setDetalle($r['unidad']);
                $fac->setUnidad($uni);
                $fac->setCantRecetas($r['totalRecetas']);
                $fac->setArancel($r['totalImporte']);
                $fac->setArancelOS($r['totalEntidad']);
                $fac->setImporteBonificacion($r['totalNeto']);
                $lista[] = $fac;
            }
            $db->free_result($consulta);
        } catch (exception $e) {
            
        }
        return $lista;
    }

    public function modify(factura $f) {
        $db = db::getInstance();
        $rpta = "<div class='errorList'>La operación no se pudo realizar.</div>";
        try {
            $db->query("BEGIN");
            $sql = "UPDATE factura SET folio1='" . $db->prepare($f->getFolioDesde()) . "',folio2='" . $db->prepare($f->getFolioHasta()) . "',"
                    . "recetas='" . $db->prepare($f->getCantRecetas()) . "',arancel='" . $db->prepare($f->getArancel()) . "',"
                    . "arancel_os='" . $db->prepare($f->getArancelOS()) . "',importe_bonificacion='" . $db->prepare($f->getImporteBonificacion()) . "' where row_id='" . $db->prepare($f->getIdFactura()) . "'";
            $result = $db->query($sql);
            if (!$result) {
                //Niega la actualizacion
                $db->query("ROLLBACK");
            } else {
                //Realiza el commit
                $db->query("COMMIT");
                $rpta = "<div class='succesList'>La carátula se modificó con éxito.</div>";
            }
        } catch (exception $e) {
            try {
                $db->query("ROLLBACK");
            } catch (exception $e1) {
                
            }
        }
        return $rpta;
    }

    public function checkPeriod($idFar, $idPlan, $quincena, $mes, $anio) {

        $db = Db::getInstance();
        $sql = "select row_id from factura where farmacia='$idFar' and "
                . "plan='$idPlan' and quincena='$quincena' and mes='$mes' "
                . "and anio='$anio' and colfanet='0'";
        $consulta = $db->query($sql);
        if ($db->num_rows($consulta) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteInvoice($codigoBarra, $idFar) {
        $db = Db::getInstance();
        $rpta = false;
        try {
            $db->query("BEGIN");
            $op1 = $db->query("delete from factura where barra='" . $db->prepare($codigoBarra) . "' and farmacia = '" . $db->prepare($idFar) . "'");
            //$op2 = $db->query("update farmacias set barras=barras-1 where codigo='".$db->prepare($idFar)."'");

            if (!$op1) {
                //Niega la insercion
                $db->query("ROLLBACK");
                $rpta = "<div onmouseover='' class='errorlist'>La operación no se pudo realizar.</div>";
            } else {
                //Realiza el commit
                $db->query("COMMIT");
                $rpta = "<div id='succesBlock' class='succesList'>La carátula se eliminó con éxito.</div>";
            }
        } catch (exception $e) {
            try {
                $db->query("ROLLBACK");
            } catch (exception $e1) {
                $rpta = $e1->getMessage();
            }
            $rpta .= $e->getMessage();
        }
        return $rpta;
    }

    public function checkPeriod2($idFar, $idPlan, $quincena, $mes, $anio, $idCaratula) {

        $db = Db::getInstance();
        $sql = "select row_id from factura where farmacia='$idFar' and "
                . "plan='$idPlan' and quincena='$quincena' and mes='$mes' "
                . "and anio='$anio' and row_id <> $idCaratula and colfanet='0'";
        $consulta = $db->query($sql);
        if ($db->num_rows($consulta) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function generateTInvoice($caratula) {
        $db = Db::getInstance();
        $rpta = false;
        try {
            $db->query("BEGIN");
            $sql1 = "insert into factura(farmacia,nombre,recetas,arancel,arancel_os," .
                    "obra_soc,quincena,mes,anio,folio1,folio2,plan,operador,fecha,origen,barra,bonificacion,importe_bonificacion,agrupado) " .
                    "values('" . $db->prepare($caratula->Farmacia->getIdFarmacia()) . "','" . $db->prepare($caratula->Farmacia->getRazonSocial()) . "'," .
                    "'" . $db->prepare($caratula->getCantRecetas()) . "','" . $db->prepare($caratula->getArancel()) . "','" . $db->prepare($caratula->getArancelOS()) . "'," .
                    "'" . $db->prepare($caratula->Plan->ObraSocial->getIdObraSocial()) . "','" . $db->prepare($caratula->Unidad->getIdUnidad()) . "','" . $db->prepare($caratula->getMes()) . "'," .
                    "'" . $db->prepare($caratula->getAnio()) . "','" . $db->prepare($caratula->getFolioDesde()) . "','" . $db->prepare($caratula->getFolioHasta()) . "'," .
                    "'" . $db->prepare($caratula->Plan->getIdPlan()) . "','" . $db->prepare(strtoupper($caratula->getOperador())) . "'," .
                    "'" . $db->prepare($caratula->getFecha()) . "','" . $db->prepare($caratula->getOrigen()) . "','" . $db->prepare($caratula->getCodigoBarra()) . "'," .
                    $db->prepare($caratula->getPorcentajeBonificacion()) . ",'" . $db->prepare($caratula->getImporteBonificacion()) . "','" . $db->prepare($caratula->getAgrupado()) . "')";
            $op1 = $db->query($sql1);
            $op2 = $db->query("update farmacias set barras='" . $db->prepare($caratula->Farmacia->getContadorBarra()) . "' where codigo='" . $db->prepare($caratula->Farmacia->getIdFarmacia()) . "'");

            if (!$op1 || !$op2) {
                //Niega la insercion
                $db->query("ROLLBACK");
                $rpta = "<div onmouseover='' class='errorlist'>La operación no se pudo realizar.</div>";
            } else {
                //Realiza el commit
                $db->query("COMMIT");
                $rpta = "<div id='succesBlock' class='succesList'>La carátula se registró con éxito.</div>";
            }
        } catch (exception $e) {
            try {
                $db->query("ROLLBACK");
            } catch (exception $e1) {
                $rpta = $e1->getMessage();
            }
            $rpta .= $e->getMessage();
        }
        return $rpta;
    }

    public function generateTInvoice2(factura $factura) {

        $db = Db::getInstance();
        $rpta = false;
        try {
            $db->query("BEGIN");
            $op1 = $db->query("insert into factura(farmacia,nombre,recetas,arancel,arancel_os," .
                    "obra_soc,quincena,mes,anio,folio1,folio2,plan,operador,fecha,origen,barra) " .
                    "values('" . $db->prepare($factura->Farmacia->getIdFarmacia()) . "','" . $db->prepare($factura->Farmacia->getRazonSocial()) . "'," .
                    "'" . $db->prepare($factura->getCantRecetas()) . "','" . $db->prepare($factura->getArancel()) . "','" . $db->prepare($factura->getArancelOS()) . "'," .
                    "'" . $db->prepare($factura->Plan->ObraSocial->getIdObraSocial()) . "','" . $db->prepare($factura->Unidad->getIdUnidad()) . "','" . $db->prepare($factura->getMes()) . "'," .
                    "'" . $db->prepare($factura->getAnio()) . "','" . $db->prepare($factura->getFolioDesde()) . "','" . $db->prepare($factura->getFolioHasta()) . "'," .
                    "'" . $db->prepare($factura->Plan->getIdPlan()) . "','" . $db->prepare(strtoupper($factura->getOperador())) . "'," .
                    "'" . $db->prepare($factura->getFecha()) . "','" . $db->prepare($factura->getOrigen()) . "','" . $db->prepare($factura->getCodigoBarra()) . "')");
            $detalles = $factura->getDetalle();
            $idF = $db->insert_id();
            foreach ($detalles as $d) {
                $op2 = $db->query("insert into facturacion(obra_soc,quincena,mes,anio,medico,fecha_recepcion,fecha_receta,
             orden_nro,apellido,carnet,dni,arancel_os,arancel_afiliado,arancel,cantidad,folio,farmacia,factura,cobertura,
             barra,troquel,operador,tipo_prestador) values('" . $db->prepare($d->Plan->ObraSocial->getIdObraSocial()) . "',
             '" . $db->prepare($d->Unidad->getIdUnidad()) . "','" . $db->prepare($d->getMes()) . "','" . $db->prepare($d->getAnio()) . "',
             '" . $db->prepare($d->Medico->getIdMedico()) . "','" . $db->prepare($d->getFechaRecepcion()) . "','" . $db->prepare($d->getFechaRecepcion()) . "',
             '" . $db->prepare($d->getFechaReceta()) . "','" . $db->prepare($d->getNroOrden()) . "','" . $db->prepare($b->getApellido()) . "',
             '" . $db->prepare($d->getCarnet()) . "','" . $db->prepare($d->getNroDocumento()) . "','" . $db->prepare($d->getRegistro()) . "',
             '" . $db->prepare($d->getArancelOS()) . "','" . $db->prepare($d->getArancelAfiliado()) . "','" . $db->prepare($d->getArancel()) . "',
             '" . $db->prepare($d->getCantidad()) . "','" . $db->prepare($d->getFolio()) . "','" . $db->prepare($d->Farmacia->getIdFarmacia()) . "',
             '" . $idF . "','" . $db->prepare($d->getCobertura()) . "','" . $db->prepare($d->getBarra()) . "','" . $db->prepare($d->getTroquel()) . "',
             '" . $db->prepare($d->getOperador()) . "','" . $db->prepare($d->getTipoPrestador()) . "')");
            }
            $op3 = $db->query("update farmacias set barras='" . $db->prepare($factura->Farmacia->getContadorBarra()) . "' where codigo='" . $db->prepare($factura->Farmacia->getIdFarmacia()) . "'");


            if (!$op1 || !$op2 || !$op3) {
                //Niega la insercion
                $db->query("ROLLBACK");
                $rpta = "<div class='errorlist'>La operación no se pudo realizar.</div>";
            } else {
                //Realiza el commit
                $db->query("COMMIT");
                $rpta = "<div id='succesBlock' class='succesList'>La carátula se registró con éxito.</div>";
            }
        } catch (exception $e) {
            try {
                $db->query("ROLLBACK");
            } catch (exception $e1) {
                $rpta = $e1->getMessage();
            }
            $rpta .= $e->getMessage();
        }
        return $rpta;
    }

    public function getInvoiceByIdBool($id) {
        $db = db::getInstance(); // finalmente tenemos visibilidad al objeto db (conexion)
        $sql = "select row_id from factura where row_id = '$id'";
        $consulta = $db->query($sql);
        if ($db->num_rows($consulta) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getInvoiceByBarCodeBool($codigoBarra) {
        $db = db::getInstance(); // finalmente tenemos visibilidad al objeto db (conexion)
        $sql = "select row_id from factura where barra = '$codigoBarra'";
        $consulta = $db->query($sql);
        return ($db->num_rows($consulta) > 0);
    }

    public function getInvoiceByIdObj($id, $idFar) {
        $db = db::getInstance(); // finalmente tenemos visibilidad al objeto db (conexion)
        $sql = "SELECT * FROM factura WHERE row_id='" . $db->prepare($id) . "' AND farmacia='" . $db->prepare($idFar) . "'";
        $consulta = $db->query($sql);
        require_once 'DAL/farmaciaBD.class.php';
        $farm = new farmaciaBD();
        require_once "DAL/planBD.class.php";
        $plan = new planBD();
        require_once 'DAL/unidadBD.class.php';
        $uni = new unidadBD();
        if ($db->num_rows($consulta) > 0) {
            $r = $db->fetch_array($consulta);
            $f = new factura();
            $f->setFarmacia($farm->getPharmacyById($r['farmacia']));
            $f->setIdFactura($r['row_id']);
            $f->setCodigoBarra($r['barra']);
            $f->setFecha($r['fecha']);
            $f->setPlan($plan->getPlanById($r['plan']));
            $f->setFolioDesde($r['folio1']);
            $f->setFolioHasta($r['folio2']);
            $f->setCantRecetas($r['recetas']);
            $f->setArancel($r['arancel']);
            $f->setArancelOS($r['arancel_os']);
            $f->setUnidad($uni->getById($r['quincena']));
            $f->setMes($r['mes']);
            $f->setAnio($r['anio']);
            $f->setOperador($r['operador']);
            $f->setRecibido($r['recibido']);
            $f->setConfirmado($r['confirmado']);
            $f->setImporteBonificacion($r['importe_bonificacion']);
            $f->setPorcentajeBonificacion($r['bonificacion']);
            $f->setAgrupado($r['agrupado']);
            return $f;
        }
    }

    public function getInvoiceByBarCodeObj($codigoBarra, $idFar) {
        $db = db::getInstance(); // finalmente tenemos visibilidad al objeto db (conexion)
        $sql = "SELECT row_id from factura WHERE barra='" . $db->prepare($codigoBarra) . "' AND farmacia='" . $db->prepare($idFar) . "' ";
        $consulta = $db->query($sql);
        $lista = array();
        while ($r = $db->fetch_array($consulta)) {
            $f = $this->getInvoiceByIdObj($r['row_id'], $idFar);
            $lista[] = $f;
        }

        return $lista;
    }

    public function getLatestInvoice($idFar) {
        $db = db::getInstance(); // finalmente tenemos visibilidad al objeto db (conexion)
        $sql = "SELECT row_id from factura WHERE farmacia='" . $db->prepare($idFar) . "' and DATE_SUB(CURDATE(),INTERVAL 1 DAY) <= fecha and colfanet='0' limit 5";
        $consulta = $db->query($sql);
        $lista = array();
        while ($r = $db->fetch_array($consulta)) {
            $f = $this->getInvoiceByIdObj($r['row_id'], $idFar);
            $lista[] = $f;
        }

        return $lista;
    }

    public function getAmountPending($idFar) {
        $db = db::getInstance(); // finalmente tenemos visibilidad al objeto db (conexion)
        $consulta = $db->query("SELECT COUNT(row_id) as cantidad from factura "
                . "WHERE farmacia='" . $db->prepare($idFar) . "' and recibido='0' and colfanet='0'");
        $r = $db->fetch_array($consulta);
        return $r['cantidad'];
    }

}

?>
