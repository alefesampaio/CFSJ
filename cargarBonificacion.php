<?
require "auth.php"; require "BLL/managerBonificacion.class.php";

if(isset($_REQUEST['idOS'])) $idOS = $_REQUEST["idOS"] ;
if(isset($_REQUEST['idFar'])) $idFar = $_REQUEST["idFar"];
$bon = managerBonificacion::obtenerPorId($idFar, $idOS);
if(!is_null($bon)){
     echo round($bon->getPorcentaje()*100)/100;
}

?>