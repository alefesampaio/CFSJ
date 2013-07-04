<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'DAL/cuentaCorrienteBD.class.php';

/**
 * Description of managerCuentaCorriente
 *
 * @author David
 */
class managerCuentaCorriente {

    public static function obtenerTodos($criterio, $idFar) {
        $ccdb = new cuentaCorrienteBD();
        return $ccdb->showAll($criterio, $idFar);
    }
    
    public static function obtenerTodos2($params = array()) {
        $ccdb = new cuentaCorrienteBD();
        return $ccdb->showAll2($params);
    }

    public static function obtenerTodosFiltro($criterio, $idFar, $periodo, $mes, $anio, $os, $plan) {
        $ccdb = new cuentaCorrienteBD();
        return $ccdb->showAllFilter($criterio, $idFar, $periodo, $mes, $anio, $os, $plan);
    }

    public static function obtenerCuentaPorId($id) {
        $ccdb = new cuentaCorrienteBD();
        return $ccdb->getAccountById($id);
    }

    public static function obtenerCuentaPorId2($idOS, $idPlan, $q, $m, $a, $criterio, $idFar) {
        $ccdb = new cuentaCorrienteBD();
        return $ccdb->getAccountById2($idOS, $idPlan, $q, $m, $a, $criterio, $idFar);
    }

    public static function obtenerTodosAgrupados($idFar) {
        $cdb = new cuentaCorrienteBD();
        return $cdb->showAllAgrupated($criterio, $idFar);
    }

    public static function obtenerTodosPorOSYMes($idFar, $fobrasocial, $fplan) {
        $cdb = new cuentaCorrienteBD();
        return $cdb->showAllByMonthAndOS($idFar, $fobrasocial, $fplan);
    }

    public static function obtenerTodosPorOS($idFar) {
        $cdb = new cuentaCorrienteBD();
        return $cdb->showAllByOS($idFar);
    }

    public static function obtenerTodosPorPlanYMes($idFar, $idOs) {
        $cdb = new cuentaCorrienteBD();
        return $cdb->showAllByPlanAndMonth($idFar, $idOs);
    }

    public static function obtenerPlanesPorOS($idFar, $idOs) {
        $cdb = new cuentaCorrienteBD();
        return $cdb->showPlansByOs($idFar, $idOs);
    }

    public static function obtenerCantidadRecibidas($idFar) {
        $cdb = new cuentaCorrienteBD();
        return $cdb->getAmountReceive($idFar);
    }

    public static function obtenerCantidadNoPresentadas($idFar) {
        $cdb = new cuentaCorrienteBD();
        return $cdb->getAmountNotPresented($idFar);
    }

    public static function obtenerCantidadNoLiquidadas($idFar) {
        $cdb = new cuentaCorrienteBD();
        return $cdb->getAmountNotCharged($idFar);
    }

    public static function obtenerCantidadRechazadas($idFar) {
        $cdb = new cuentaCorrienteBD();
        return $cdb->getAmountRejected($idFar);
    }

}

?>
