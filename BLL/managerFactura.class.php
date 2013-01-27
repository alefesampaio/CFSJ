<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require 'DAL/facturaBD.class.php';

/**
 * Description of managerFactura
 *
 * @author David
 */
class managerFactura {

    public static function validarPeriodo($idFar, $idPlan, $quincena, $mes, $anio) {
        $fdb = new facturaBD();
        return $fdb->checkPeriod($idFar, $idPlan, $quincena, $mes, $anio);
    }

    public static function validarPeriodo2($idFar, $idPlan, $quincena, $mes, $anio, $idCaratula) {
        $fdb = new facturaBD();
        return $fdb->checkPeriod2($idFar, $idPlan, $quincena, $mes, $anio, $idCaratula);
    }

    public static function generarCodigoBarra($codF, $idOS, $idPlan, $unidad, $mes, $anio, $barras) {
        // (bool web)(idFarmacia)(idObraSocial)(idPlan)(Periodo 00 00 00)(autoincrement)

        $c1 = str_pad($codF, 4, "0", STR_PAD_LEFT);
        $c2 = str_pad($idOS, 3, "0", STR_PAD_LEFT);
        $c3 = str_pad($idPlan, 3, "0", STR_PAD_LEFT);
        $c4 = str_pad($unidad, 2, "0", STR_PAD_LEFT);
        $c5 = str_pad($mes, 2, "0", STR_PAD_LEFT);
        $c6 = substr($anio, -2);
        $c7 = str_pad($barras, 6, "0", STR_PAD_LEFT);

        $codigo = "1" . $c1 . $c2 . $c3 . $c4 . $c5 . $c6 . $c7;
        return $codigo;
    }

    public static function meses() {
        $mes[1] = 'Enero';
        $mes[] = 'Febrero';
        $mes[] = 'Marzo';
        $mes[] = 'Abril';
        $mes[] = 'Mayo';
        $mes[] = 'Junio';
        $mes[] = 'Julio';
        $mes[] = 'Agosto';
        $mes[] = 'Septiembre';
        $mes[] = 'Octubre';
        $mes[] = 'Noviembre';
        $mes[] = 'Diciembre';

        return $mes;
    }

    public static function generarTCaratula(factura $caratula) {
        $fdb = new facturaBD();
        return $fdb->generateTInvoice($caratula);
    }

    public static function borrarFactura($codigoBarra, $idFar) {
        $fdb = new facturaBD();
        return $fdb->deleteInvoice($codigoBarra, $idFar);
    }

    public static function generarTFacturacion(factura $factura) {
        $fdb = new facturaBD();
        return $fdb->generateTInvoice2($caratula);
    }

    public static function obtenerTodos($criterio, $idFar) {
        $fdb = new facturaBD();
        return $fdb->showFacturas($criterio, $idFar);
    }
    
    public static function obtenerTodos2($criterio, $idFar) {
        $fdb = new facturaBD();
        return $fdb->showFacturas2($criterio, $idFar);
    }

    public static function obtenerFacturaPorIdBool($id) {
        $fdb = new facturaBD();
        return $fdb->getInvoiceByIdBool($id);
    }

    public static function obtenerFacturaPorCodigoBarraBool($codigoBarra) {
        $fdb = new facturaBD();
        return $fdb->getInvoiceByBarCodeBool($codigoBarra);
    }

    public static function obtenerFacturaPorCodigoBarraObj($codigoBarra, $idFar) {
        $fdb = new facturaBD();
        return $fdb->getInvoiceByBarCodeObj($codigoBarra, $idFar);
    }

    public static function obtenerFacturaPorIdObj($id, $idFar) {
        $fdb = new facturaBD();
        return $fdb->getInvoiceByIdObj($id, $idFar);
    }

    public static function modificarFactura(factura $f) {
        $fdb = new facturaBD();
        return $fdb->modify($f);
    }

    public static function obtenerUltimaFactura($idFar) {
        $fdb = new facturaBD();
        return $fdb->getLatestInvoice($idFar);
    }

    public static function obtenerCantidadPendientes($idFar) {
        $fdb = new facturaBD();
        return $fdb->getAmountPending($idFar);
    }

}

?>
