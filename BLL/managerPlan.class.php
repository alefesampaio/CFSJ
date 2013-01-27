<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require "DAL/planBD.class.php";

/**
 * Description of managerPlan
 *
 * @author David
 */
class managerPlan {

    public static function obtenerTodos() {
        $pdb = new planBD();
        return $pdb->mostrarPlanes();
    }

    public static function obtenerPlanPorId($id) {
        $pdb = new planBD();
        return $pdb->getPlanById($id);
    }

    public static function obtenerPlanesPorOS($idOS) {
        $pdb = new planBD();
        return $pdb->getPlanByOS($idOS);
    }

}

?>
