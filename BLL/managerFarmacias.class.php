<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require "DAL/farmaciaBD.class.php";
/**
 * Description of managerFarmacias
 *
 * @author David
 */
class managerFarmacias {

    public static function obtenerTodos(){
        $far = new farmaciaBD();
        return $far->mostrarFarmacias();
    }
    public static function obtenerFarmaciaPorIdObj($id){
        $far = new farmaciaBD();
        return $far->getPharmacyById($id);
    }
    public static function esMatriculaVigente($matricula, $idFar){
        $far = new farmaciaBD();
        return $far->isValidLicense($matricula, $idFar);
    }
    
}

?>
