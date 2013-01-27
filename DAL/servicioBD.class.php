<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'Business/servicio.class.php';
/**
 * Description of serviceBD
 *
 * @author David
 */
class servicioBD {
    
    public function getAuthService($idServicio, $idUser){
        $db = db::getInstance(); // finalmente tenemos visibilidad al objeto db (conexion)
        $sql = "select idServicio,idUser from servicioporusuario where idServicio='$idServicio' and idUser='$idUser'";
        $consulta = $db->query($sql);
        return ($db->num_rows($consulta) > 0) ;
    }
    
    public function getById($idServicio){
        $db = db::getInstance(); // finalmente tenemos visibilidad al objeto db (conexion)
        $sql = "select idServicio,descripcion,path from services where idServicio='$idServicio'";
        $consulta = $db->query($sql);
        if($db->num_rows($consulta) > 0) {
            $r = $db->fetch_array($consulta);
            $servicio = new servicio();
            $servicio->setIdServicio($r['idServicio']);
            $servicio->setDescripcion($r['descripcion']);
            $servicio->setPath($r['path']);
           
        }
        return $servicio;
    }
}

?>
