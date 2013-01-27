<?php

require "auth.php";
require "BLL/managerObraSocial.class.php";
//Consideraciones: 
//La fecha de cierre de la 2da quincena, puede caer tanto a finales del mes en cuestion, como los primeros dias del mes siguiente.
//La fecha de inicio de la 2da quincena puede caer a fines de un mes, como a principio del mes siguiente.
//Las fechas de inicio y cierre de la 1er quincena estan dentro del mismo mes.
//El dia de cierre 2 no puede ser mayor que el dia de inicio 1
$id = $_REQUEST["id"];
$os = managerObraSocial::obtenerOSPorId($id);
if (!is_null($os)) {
    $f = new DateTime();
    $q = 2;
    $today = (int) $f->format("d");
    $mes = (int) $f->format("m");
    $anio = (int) $f->format("Y");
    require_once 'funciones/functions.php';
    $meses = meses();
    if ($os->getPeriodo() == 1)
        $q = 3;
    if ($os->getCierre2() < $os->getInicio2() || ($os->getInicio2()<10)) {
        if ($today <= $os->getCierre2())
            $mes--;
        if ($mes == 0){
			$mes = 12; $anio--;
			}
            
    }
    if ($q!=3 && $today >= $os->getInicio1() && $today <= $os->getCierre1()) {
        $q = 1;
    }
    if ($q != 3)
        echo $q . "° quincena de " . $meses[$mes];
    else
        echo "Mes de $meses[$mes]";

    $_SESSION['quincena'] = $q;
    $_SESSION['mes'] = $mes;
    $_SESSION['anio'] = $anio;
}
?>
