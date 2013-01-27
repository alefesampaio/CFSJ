<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once "DAL/nivelAdminBD.class.php";
/**
 * Description of managerNivelAdmin
 *
 * @author David
 */
class managerNivelAdmin {
   
    public static function obtenerTodos(){
    $ndb = new nivelAdminBD();
    return $ndb->mostrarNiveles();
    }
   
}

?>
