<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of managerPlan
 *
 * @author David
 */
class managerMandataria {

    const TABLE_NAME = 'mandataria2';

    public static function obtenerPlanesPorOS($idOS) {
        $db = db::getInstance();
        $sql = "SELECT *,(SELECT denomina FROM obrasocial WHERE codigo = planes_os.obrasoc) as detalle_os
                FROM planes_os
                INNER JOIN ( SELECT obrasocial FROM mandataria2 WHERE mandataria = 1) as os
                ON os.obrasocial = planes_os.obrasoc";
        $listado = array();
        $consulta = $db->query($sql);
        while ($r = $db->fetch_array($consulta)){
            $listado[$r['obrasoc']][] = $r;
        }
        return $listado;
    }

    public static function abrenHoy() {
        $db = db::getInstance();
        $dia = new Datetime();

        $sql = "SELECT * FROM mandataria1 WHERE dia_1q = " . $dia->format('d');
        $listado = array();
        $consulta = $db->query($sql);
        while($r = $db->fetch_array($consulta)){
            $listado[] = $r;
        }
        return $listado;
    }

    public static function cierranHoy() {
        $db = db::getInstance();
        $dia = new Datetime();

        $sql = "SELECT * FROM mandataria1 WHERE dia_2q = " . $dia->format('d');
        $listado = array();
        $consulta = $db->query($sql);
        while($r = $db->fetch_array($consulta)){
            $listado[] = $r;
        }
        return $listado;
    }

    public static function obtenerTodos(){
        $db = db::getInstance();
        $sql = "SELECT * FROM mandataria1";
        $listado = array();
        $consulta = $db->query($sql);
        while($r = $db->fetch_array($consulta)){
            $listado[] = $r;
        }
        return $listado;
    }

    public static function getOne($params = array()) {
        $default = array(
            'key' => NULL,
            'value' => NULL,
            'extra' => FALSE
            );
        extract(array_merge($default, $params));
        $db = db::getInstance();
        $listado = array();
        if($extra){
            $data = $db->query(
                            "SELECT * FROM ". self::TABLE_NAME .
                            " JOIN obrasocial ON mandataria2.obrasocial = obrasocial.codigo
                            JOIN mandataria1 ON mandataria2.mandataria = mandataria1.codigo
                            WHERE ".self::TABLE_NAME.".$key = $value");
            while($r = $db->fetch_array($data)){
                $listado[] = $r;
            }
            return $listado;
        }
        return $db->query("SELECT * FROM ".self::TABLE_NAME." WHERE $key = $value", true);
    }

}

?>