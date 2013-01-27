<?
require "auth.php"; require "BLL/managerPlan.class.php";

$obraSoc = $_REQUEST["id"];
$listado = managerPlan::obtenerPlanesPorOS($obraSoc);
if(count($listado)>0){
    echo "<option value=''>Seleccionar</option>";
foreach ($listado as $p){
    
    echo "<option value='".$p->getIdPlan()."'>".$p->getDescripcion()."</option>";
}
}else { echo "<option value=''>No hay planes disponibles</option>";}
?>