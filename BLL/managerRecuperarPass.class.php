<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require 'DAL/recuperarPassBD.class.php';

/**
 * Description of managerRecuperarPass
 *
 * @author David
 */
class managerRecuperarPass {

    public static function insertar(recuperarPass $r) {
        $rdb = new recuperarPassBD();
        return $rdb->insert($r);
    }

    public static function obtenerObjPorCodigo($code) {
        $rdb = new recuperarPassBD();
        return $rdb->getObjByCode($code);
    }

    public static function obtenerObjPorCodigoBool($code) {
        $rdb = new recuperarPassBD();
        return $rdb->getObjByCodeBool($code);
    }

    public static function eliminarRegistro($value, $attr) {
        $rdb = new recuperarPassBD();
        return $rdb->deleteRegister($value, $attr);
    }

    public static function obtenerObjPorEmailBool($email) {
        $rdb = new recuperarPassBD();
        return $rdb->getObjByEmailBool($email);
    }

}

?>
