<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'DAL/db.class.php';
require_once 'DAL/conf.class.php';
require 'Business/recuperarPass.class.php';

/**
 * Description of recuperarPassBD
 *
 * @author David
 */
class recuperarPassBD {

    public function insert(recuperarPass $r) {
        $db = Db::getInstance();
        $sql = "insert into recuperarpass(email,codigo,fecha,ip)"
                . " values('" . $r->getEmail() . "','" . $r->getCodigo() . "','" . $r->getFecha() . "','" . $r->getIp() . "')";
        $rpta = "<div class='infolist'>La operación no se pudo realizar.</div>";
        try {
            $db->query("BEGIN");
            $result = $db->query($sql);
            if (!$result) {
                //Niega la insercion
                $db->query("ROLLBACK");
            } else {
                //Realiza el commit
                $db->query("COMMIT");
                $rpta = "<div class='infolist p100'>Te hemos enviado un email con las instrucciones para recuperar tu contraseña.</div>";
            }
        } catch (exception $e) {
            try {
                $db->query("ROLLBACK");
            } catch (exception $e1) {
                
            }
        }
        return $rpta;
    }

    public function getObjByCode($code) {

        $db = Db::getInstance();
        $sql = "select idRecuperar,email,codigo,fecha,ip from recuperarpass "
                . "where codigo='" . $db->prepare($code) . "'";
        $consulta = $db->query($sql);
        $r = $db->fetch_array($consulta);
        $new = new recuperarPass();
        $new->setIdRecuperar($r['idRecuperar']);
        $new->setEmail($r['email']);
        $new->setFecha($r['fecha']);
        $new->setCodigo($r['codigo']);
        $new->setIp($r['ip']);
        return $new;
    }

    public function getObjByCodeBool($code) {
        $db = Db::getInstance();
        $sql = "select idRecuperar from recuperarpass "
                . "where codigo='" . $db->prepare($code) . "'";
        $consulta = $db->query($sql);
        if ($db->num_rows($consulta) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteRegister($value, $attr) {
        $db = Db::getInstance();
        $sql = "DELETE FROM recuperarpass WHERE " . $attr . " = '" . $db->prepare($value) . "'";
        $del = $db->query($sql);
        ($del) ? $b = true : $b = false;
        return $b;
    }

    public function getObjByEmailBool($email) {
        $db = Db::getInstance();
        $sql = "select idRecuperar from recuperarpass "
                . "where email='" . $db->prepare($email) . "'";
        $consulta = $db->query($sql);
        if ($db->num_rows($consulta) > 0) {
            return true;
        } else {
            return false;
        }
    }

}

?>
