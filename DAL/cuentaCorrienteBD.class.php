<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require 'Business/cuentaCorriente.class.php';

/**
 * Description of cuentaCorrienteBD
 *
 * @author David
 */
class cuentaCorrienteBD {
    
    public function showAll2($params = array()) {

        $where = ($params['liquidado']) ? ' AND c.cobrado = 1' : ''; 
        $db = Db::getInstance();
        $sql = "SELECT  c.operacion,
                        c.codigofarmacia,
                        c.obra_social,
                        o.denomina as obrasocial,
                        c.quincena,
                        u.detalle as unidad,
                        c.mes,
                        c.anio,
                        c.facturado,
                        c.imputacion,
                        c.detalle,
                        c.liquidado,
                        c.recibido,
                        c.plan,
                        p.detalle as dplan,
                        c.confirmado,
                        c.cobrado,
                        c.rendicion 
                FROM ctacte AS c 
                INNER JOIN unidadperiodo AS u ON u.idUnidad = c.quincena 
                INNER JOIN farmacias as f ON f.codigo = c.codigofarmacia 
                INNER JOIN obrasocial as o ON o.codigo = c.obra_social 
                INNER JOIN planes_os as p ON p.plan = c.plan 
                WHERE codigofarmacia='" . $db->prepare($params['farmaciaId']) . "' $where ORDER BY $params[criterio]";        
        $consulta = $db->query($sql);        
        if ($db->num_rows($consulta) == 0) return false;
        $lista = array();
        require_once 'Business/unidad.class.php';
        require_once 'Business/farmacia.class.php';
        require_once 'Business/plan.class.php';
        require_once 'Business/obraSocial.class.php';
        while ($r = $db->fetch_array($consulta)) {            
                $new = new cuentaCorriente();
                $new->setIdCtaCte($r['operacion']);
                $u = new unidad();
                $u->setIdUnidad($r['quincena']);
                $u->setDetalle($r['unidad']);
                $new->setUnidad($u);
                $new->setMes($r['mes']);
                $new->setAnio($r['anio']);
                $new->setNroRendicion($r['rendicion']);
                $f = new farmacia();
                $f->setIdFarmacia($r['codigofarmacia']);
                $new->setFarmacia($f); 
                $p = new plan();
                $p->setIdPlan($r['plan']);
                $p->setDescripcion($r['dplan']);
                $new->setPlan($p);
                $os = new obraSocial();
                $os->setIdObraSocial($r['obra_social']);
                $os->setDenominacion($r['obrasocial']);
                $new->setObraSocial($os);
                $new->setConfirmado($r['confirmado']);
                $new->setRecibido($r['recibido']);
                $new->setImputacion($r['imputacion']);
                $new->setFacturado($r['facturado']);
                $new->setLiquidado($r['liquidado']);
                $new->setCobrado($r['cobrado']);
                $lista[] = $new;
        }
        return $lista;
    }
    
    public function showAll($criterio, $idFar) {

        $db = Db::getInstance();
        $q = $db->query("select operacion from ctacte where codigofarmacia='" . $db->prepare($idFar) . "' order by $criterio ");
        $lista = array();
        while ($re = $db->fetch_array($q)) {
            $lista[] = $this->getAccountById($re['operacion']);
        }
        return $lista;
    }

    public function showAllFilter($criterio, $idFar, $periodo, $mes, $anio, $os, $plan) {
        $where = "";
        if ($periodo != null)
            $where .= " and quincena ='$periodo'";
        if ($mes != null)
            $where .= " and mes ='$mes'";
        if ($anio != null)
            $where .= " and anio ='$anio'";
        if ($os != null)
            $where .= " and obra_social ='$os'";
        if ($plan != null)
            $where .= " and plan ='$plan'";

        $db = Db::getInstance();
        $q = $db->query("select operacion from ctacte where codigofarmacia='" . $db->prepare($idFar) . "' $where order by $criterio ");
        $lista = array();
        while ($re = $db->fetch_array($q)) {
            $lista[] = $this->getAccountById($re['operacion']);
        }
        return $lista;
    }

    public function showAllAgrupated($criterio, $idFar) {
        $db = Db::getInstance();
        $q = $db->query("select obra_social,plan,SUM(facturado) as totalFacturado,SUM(liquidado) as totalLiquidado,operacion"
                . " from ctacte where codigofarmacia='" . $db->prepare($idFar) . "' order by $criterio ");
        $lista = array();
        while ($re = $db->fetch_array($q)) {
            $lista[] = $this->getAccountById($re['operacion']);
        }
        return $lista;
    }

    public function getAccountById2($idOS, $idPlan, $q, $m, $a, $criterio, $idFar) {

        $db = Db::getInstance();
        $q1 = $db->query("select operacion from ctacte where codigofarmacia='" . $db->prepare($idFar) . "' and obra_social='$idOS'"
                . " and plan='$idPlan' and quincena='$q' and mes='$m' and anio='$a'");
        while ($r1 = $db->fetch_array($q1)) {
            $cta = $this->getAccountById($r1['operacion']);
            $detalle = array();
            $q2 = $db->query("select fecha_liquidacion,detalle,debe,haber from liquidacion where "
                    . "obrasocial='" . $cta->getObraSocial()->getIdObraSocial() . "' and plan='" . $cta->getPlan()->getIdPlan() . "' "
                    . "and mes='" . $cta->getMes() . "' and quincena='" . $cta->getUnidad()->getIdUnidad() . "' and anio='" . $cta->getAnio() . "' "
                    . " and farmacia='" . $db->prepare($idFar) . "' order by $criterio desc  ");
            require_once 'Business/detalleCuentaCorriente.class.php';
            while ($r2 = $db->fetch_array($q2)) {
                $dtCta = new detalleCuentaCorriente();
                $dtCta->setDebe($r2['debe']);
                $dtCta->setHaber($r2['haber']);
                $dtCta->setDetalle($r2['detalle']);
                $dtCta->setFecha($r2['fecha_liquidacion']);
                $detalle[] = $dtCta;
            }
            $cta->setDetalle($detalle);
        }
        return $cta;
    }

    public function getAccountById($id) {
        $db = db::getInstance(); // finalmente tenemos visibilidad al objeto db (conexion)
        $sql = "select codigofarmacia,quincena,mes,anio,facturado,imputacion,detalle,"
                . "liquidado,recibido,plan,confirmado,cobrado,operacion from ctacte "
                . " where operacion='" . $db->prepare($id) . "'";
        $consulta = $db->query($sql);
        require_once 'DAL/unidadBD.class.php';
        $udb = new unidadBD();
        require_once 'DAL/farmaciaBD.class.php';
        $fardb = new farmaciaBD();
        require_once 'DAL/planBD.class.php';
        $plandb = new planBD();
        if ($db->num_rows($consulta) > 0) {
            $r = $db->fetch_array($consulta);
            $new = new cuentaCorriente();
            $new->setIdCtaCte($r['operacion']);
            $new->setUnidad($udb->getById($r['quincena']));
            $new->setMes($r['mes']);
            $new->setAnio($r['anio']);
            $new->setFarmacia($fardb->getPharmacyById($r['codigofarmacia']));
            $new->setPlan($plandb->getPlanById($r['plan']));
            $new->setObraSocial($plandb->getPlanById($r['plan'])->getObraSocial());
            $new->setConfirmado($r['confirmado']);
            $new->setRecibido($r['recibido']);
            $new->setImputacion($r['imputacion']);
            $new->setFacturado($r['facturado']);
            $new->setLiquidado($r['liquidado']);
            $new->setCobrado($r['cobrado']);
            return $new;
        }
    }

    public function showAllByMonthAndOS($idFar, $idOS, $idPlan) {
        $db = Db::getInstance();
        $q = $db->query("select obra_social,plan,SUM(facturado) as totalFacturado,SUM(liquidado) as totalLiquidado,mes,anio " .
                "from ctacte where codigofarmacia='" . $idFar . "' and obra_social='" . $idOS . "' and plan='" . $idPlan . "' " .
                " group by mes,anio order by anio desc, mes desc limit 13");
        $lista = array();
        while ($row = $db->fetch_array($q)) {
            $lista[] = $row;
        }
        return $lista;
    }

    public function showAllByPlanAndMonth($idFar, $idOS) {
        $db = Db::getInstance();
        $q = $db->query("select obra_social,plan,SUM(facturado) as totalFacturado,mes from ctacte where " .
                "codigofarmacia='" . $idFar . "' and obra_social='" . $idOS . "' group by mes, plan order by mes asc ");
        $lista = array();
        while ($row = $db->fetch_array($q)) {
            $lista[] = $row;
        }
        return $lista;
    }

    public function showPlansByOs($idFar, $idOS) {
        $db = Db::getInstance();
        $q = $db->query("select plan from ctacte where codigofarmacia='" . $idFar . "' and obra_social='" . $idOS . "' GROUP BY plan");
        $planes = array();
        while ($row = $db->fetch_array($q)) {
            $planes[] = $row;
        }
        return $planes;
    }

    public function showAllByOS($idFar) {
        $db = Db::getInstance();
        $q = $db->query("select obra_social,SUM(facturado) as totalFacturado from ctacte where codigofarmacia='" . $idFar . "' " .
                "and mes = DATE_FORMAT(CURDATE(), '%c')-1 and anio = DATE_FORMAT(CURDATE(), '%Y') group by obra_social");
        $os = array();
        while ($row = $db->fetch_array($q)) {
            $os[] = $row;
        }
        return $os;
    }

    public function getAmountReceive($idFar) {
        $db = db::getInstance(); 
        $consulta = $db->query("SELECT COUNT(operacion) as cantidad from ctacte "
                . "WHERE codigofarmacia='" . $db->prepare($idFar) . "' and recibido='1'");
        $r = $db->fetch_array($consulta);
        return $r['cantidad'];
    }

    public function getAmountNotPresented($idFar) {
        $db = db::getInstance(); // finalmente tenemos visibilidad al objeto db (conexion)
        $consulta = $db->query("SELECT COUNT(operacion) as cantidad from ctacte "
                . "WHERE codigofarmacia='" . $db->prepare($idFar) . "' and confirmado='0'");
        $r = $db->fetch_array($consulta);
        return $r['cantidad'];
    }

    public function getAmountNotCharged($idFar) {
        $db = db::getInstance(); // finalmente tenemos visibilidad al objeto db (conexion)
        $consulta = $db->query("SELECT COUNT(operacion) as cantidad from ctacte "
                . "WHERE codigofarmacia='" . $db->prepare($idFar) . "' and liquidado='0'");
        $r = $db->fetch_array($consulta);
        return $r['cantidad'];
    }

    public function getAmountRejected($idFar) {
        $db = db::getInstance(); // finalmente tenemos visibilidad al objeto db (conexion)
        $consulta = $db->query("SELECT COUNT(operacion) as cantidad from ctacte "
                . "WHERE codigofarmacia='" . $db->prepare($idFar) . "' and confirmado='2'");
        $r = $db->fetch_array($consulta);
        return $r['cantidad'];
    }

}
?>



