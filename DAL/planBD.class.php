<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once "Business/plan.class.php";

/**
 * Description of planBD
 *
 * @author David
 */
class planBD {

    public function mostrarPlanes() {

        $db = Db::getInstance();
        $cr = "codigo";
        try {
            $consulta = $db->query("SELECT plan,detalle,obrasoc FROM planes_os where agrupar_caratula <> '0' ORDER BY $cr");
            $lista = array();
            while ($r = $db->fetch_array($consulta)) {
                $p = new plan();
                $p->setIdPlan($r['plan']);
                $p->setDescripcion($r['detalle']);
                require_once 'Business/obraSocial.class.php';
                $os = new obraSocial();
                $os->setIdObraSocial($r['obrasoc']);
                $p->setObraSocial($os);
                $lista[] = $p;
            }
            $db->free_result($consulta);
        } catch (exception $e) {
            
        }
        return $lista;
    }

    public function getPlanByOS($idOS) {
        $db = db::getInstance();
        $sql = "select plan,detalle from planes_os where obrasoc=$idOS and agrupar_caratula<>'0' order by agrupar_caratula asc";
        $consulta = $db->query($sql);
        $listado = array();
        if ($db->num_rows($consulta) > 0) {
            while ($r = $db->fetch_array($consulta)) {
                $p = new plan();
                $p->setIdPlan($r['plan']);
                $p->setDescripcion($r['detalle']);
                $listado[] = $p;
            }
        }
        return $listado;
    }

    public function getPlanById($id) {
        $db = db::getInstance();
        $sql = "select plan,detalle,obrasoc from planes_os where plan=$id ";
        $consulta = $db->query($sql);
        require_once 'DAL/obraSocialBD.class.php';
        $dbos = new obraSocialBD();
        if ($db->num_rows($consulta) > 0) {
            $r = $db->fetch_array($consulta);
            $p = new plan();
            $p->setIdPlan($r['plan']);
            $p->setDescripcion($r['detalle']);
            $p->setObraSocial($dbos->getOSById($r['obrasoc']));

            return $p;
        }
    }

}

?>
