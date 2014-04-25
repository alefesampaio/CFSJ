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

}

?>