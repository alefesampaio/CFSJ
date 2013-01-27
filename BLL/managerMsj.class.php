<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require "DAL/msjBD.class.php";

/**
 * Description of managerMsj
 *
 * @author David
 */
class managerMsj {

    //put your code here
    public static function obtenerTodos($start, $limit) {
        $ndb = new msjBD();
        return $ndb->getMessages($start, $limit);
    }

    public static function insertarMensaje(msjAdmin $m) {
        $ndb = new msjBD();
        return $ndb->insertMessage($m);
    }

    public static function calcularFechaRelativa($fecha, $zonagmt = -3, $showano = false) {
        //$f = mktim
        $thisdate = date("Y-m-d", $fecha);
        $fechahoy = date("Y-m-d");
        $fechaayer = date("Y-m-d", time() - 3600 * 24);
        $fechamanana = date("Y-m-d", time() + 3600 * 24);
        if ($showano) {
            $formatfecha = "\e\l d/m/Y";
        } else {
            $formatfecha = "\e\l d/m";
        }
        if ($thisdate == $fechahoy) {
            $fechat = "Hoy";
        } else if ($thisdate == $fechaayer) {
            $fechat = "Ayer";
        } else if ($thisdate == $fechamanana) {
            $fechat = "Mañana";
        }
        if (isset($fechat) && $fechat != "") {
            $fechat = $fechat . ", a las " . gmdate("H:i", $fecha + 3600 * $zonagmt);
        } else {
            $fechat = gmdate("$formatfecha \a \l\a\s H:i", $fecha + 3600 * $zonagmt);
        }

        return $fechat;
    }

}

?>
