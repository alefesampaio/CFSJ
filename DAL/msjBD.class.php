<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require "Business/msjAdmin.class.php";
/**
 * Description of msjBD
 *
 * @author David
 */
class msjBD {
    
    public function getMessages($start, $limit){
        $db =  Db::getInstance();
        //$cr = $db->prepare($criterio);
      try{
      $sql = "SELECT a.idMsj,a.detalle,a.fecha,u.usuario,u.idUser FROM admin_msg a, users u WHERE u.idUser = a.idUsuario ORDER BY a.idMsj DESC LIMIT $start,$limit";
      $consulta = $db->query($sql);
      $lista = array();
      while ($r = $db->fetch_array($consulta)) {
          require_once "Business/usuario.class.php";
           $u = new Usuario();
           $u->setIdUser($r['idUser']);
           $u->setUsuario($r['usuario']);
           $m = new msjAdmin();
           $m->setDetalle($r['detalle']);
           $m->setFecha($r['fecha']);
           $m->setIdMensaje($r['idMsj']);
           $m->setUsuario($u);
           $lista[] = $m;
           }
            $db->free_result($consulta);
                       
       } catch (exception $e) {
                   
            
        }
        return $lista;
        
    }
    
    public function insertMessage(msjAdmin $m) {
        $db = Db::getInstance();
        $rpta = false;
        try {
            $db->query("BEGIN");
            $sql = "INSERT INTO admin_msg (detalle,idUsuario,fecha) VALUES ('".$m->getDetalle()."','".$m->usuario->getIdUser()."','".$m->getFecha()."')";
            $result = $db->query($sql);
        if(!$result){    
        //Niega la insercion
            $db->query("ROLLBACK");
        } else {
        //Realiza el commit
            $db->query("COMMIT");
            $rpta = true;
           }
          
       } catch (exception $e) {
           try {
               $db->query("ROLLBACK");
           } catch (exception $e1) {
                
           }
        }
        return $rpta;
    }
    
    
}

?>
