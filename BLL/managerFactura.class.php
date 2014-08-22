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

    public function validarMandataria($id_far, $id_mandataria, $quincena, $mes, $anio) {
        $db = Db::getInstance();
        $sql = "SELECT row_id FROM factura_mandataria 
                WHERE farmacia=$id_far
                AND mandataria=$id_mandataria
                AND quincena=$quincena
                AND mes=$mes
                AND anio=$anio";
        $consulta = $db->query($sql);
        return $db->num_rows($consulta) > 0;
    }

    public static function validarPeriodo2($idFar, $idPlan, $quincena, $mes, $anio, $idCaratula) {
        $fdb = new facturaBD();
        return $fdb->checkPeriod2($idFar, $idPlan, $quincena, $mes, $anio, $idCaratula);
    }

    public static function generarCodigoBarra($codF, $idOS, $idPlan, $unidad, $mes, $anio, $barras, $preffix = '1', $idMan = NULL) {
        $c1 = str_pad($codF, 4, "0", STR_PAD_LEFT);
        $c2 = str_pad($idOS, 3, "0", STR_PAD_LEFT);
        $c3 = str_pad($idPlan, 3, "0", STR_PAD_LEFT);
        $c4 = str_pad($unidad, 2, "0", STR_PAD_LEFT);
        $c5 = str_pad($mes, 2, "0", STR_PAD_LEFT);
        $c6 = substr($anio, -2);
        $c7 = str_pad($barras, 6, "0", STR_PAD_LEFT);

        $codigo = $preffix . $c1 . $c2 . $c3 . $c4 . $c5 . $c6 . $c7;
        $codigo .= !is_null($idMan) ? str_pad($idMan, 2, "0", STR_PAD_LEFT) : '';
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

    public static function generarTMandataria($params = array(), $last) {
       $db = Db::getInstance();
       $rpta = false;
       try {
           $db->query("BEGIN");
           $sql = "INSERT INTO factura_mandataria(".implode(',', array_keys($params)).") "
           ."VALUES (". implode(',', array_values($params)) .")";

           $op1 = $db->query($sql);
           $op2 = $db->query("UPDATE farmacias SET barras='" . $db->prepare($last)."' where codigo=".$params['farmacia']);

           if (!$op1 or !$op2) {
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

    public static function borrarFactura($codigoBarra, $idFar) {
        $fdb = new facturaBD();
        return $fdb->deleteInvoice($codigoBarra, $idFar);
    }

    public static function borrarMandataria($barra, $idFar) {
        $db = Db::getInstance();
        $sql = "DELETE FROM factura_mandataria WHERE barra=$barra AND farmacia=$idFar";
        return $db->query($sql);
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

    public static function obtenerMandatarias($criterio, $idFar){
      $db = Db::getInstance();
      $cr = $db->prepare($criterio);
      $sql = "SELECT f.*,u.detalle as unidad_detalle,m.detalle as mandataria_detalle
      FROM factura_mandataria as f
      JOIN unidadperiodo as u
      ON f.quincena = u.idUnidad
      JOIN mandataria1 as m
      ON m.codigo = f.mandataria
      WHERE farmacia = $idFar AND f.colfanet = 0 GROUP BY f.barra ORDER BY $cr";
      $consulta = $db->query($sql);
      while ($r = $db->fetch_array($consulta)) {
        $data[] = $r;
      }
      return $data;
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
