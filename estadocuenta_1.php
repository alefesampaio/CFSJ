<? ini_set('display_errors', 1);
require "auth.php";
require 'BLL/managerCuentaCorriente.class.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Colegio Farmacéutico de San Juan | Panel de administración</title>
    </head>
    <body>
           <div id="right">    
            <div id="loaderDiv" class="hide"></div>
            <div class="ui-widget-header ui-corner-all subtit">Estado de cuenta</div>
            <!-- Contenido -->
            <div id="main2">
                <div class="subtit2">Listado</div>
                <?
                require_once 'funciones/functions.php';
                $criterio = "operacion";
                $listado = managerCuentaCorriente::obtenerTodos2($criterio, $userAuth->Farmacia->getIdFarmacia());
                ?>
                <div id="optionBar" class="ui-widget-header ui-corner-all">
                    <form action="exportarExcel.php" method="post" target="_blank" id="FormularioExportacion">
                        <img src="images/Icon_Excel.png" class="botonExcel" title="Exportar a Excel" alt="Exportar a Excel" width="16" height="16" />
                        <a href="" id="lnkPrint" class="here"><img src="images/print.png" width="16" height="16" alt="Imprimir"  /></a>
                        <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
                    </form>
                </div>
                <div id="example_wrapper" class="dataTables_wrapper" role="grid">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                        <thead>
                            <tr>
                                <td>Período</td>
                                <td>Mes</td>
                                <td>Año</td>
                                <td>Obra Social</td>
                                <td>Plan</td>    
                                <td>Total facturado ($)</td>
                                <td>Total liquidado ($)</td>
                                <td>Saldo ($)</td>
                                <td>Detalle</td>
                                <td>Recepción</td>
                                <td>Presentado</td>  
                                <td>Liquidación</td>  

                            </tr></thead>
                        <tbody>
                            <?
                            $array = meses();
                            for ($i = 0; $i < count($listado); $i++) {
                                $mes = $array[$listado[$i]->getMes()];
                                $quincena = $listado[$i]->Unidad->getDetalle();
                                $periodo = "$quincena de $mes de " . $listado[$i]->getAnio();
                                if ($listado[$i] == $listado[0]) {
                                    $saldoAc = $listado[$i]->getSaldo();
                                } else {
                                    $saldoAc = (double) $listado[$i - 1]->getSaldo() + $listado[$i]->getSaldo();
                                }
                                switch ($listado[$i]->getConfirmado()) {
                                    case 1:
                                        $con = "icon_accept.png";
                                        $t2 = "Presentado";
                                        break;
                                    case 2:
                                        $con = "icon_error.png";
                                        $t2 = "Rechazado";
                                        break;
                                    default:
                                        $con = "icon_warning2.png";
                                        $t2 = "No presentado";
                                        break;
                                }

                                if ($listado[$i]->getRecibido() == 1) {
                                    $rec = "icon_accept.png";
                                    $t1 = "Recibido";
                                } else {
                                    $rec = "icon_warning2.png";
                                    $t1 = "No recibido";
                                }
                                if ($listado[$i]->getCobrado() == 1) {
                                    $liq = "icon_accept.png";
                                    $t3 = "Liquidado";
                                } else {
                                    $liq = "icon_warning2.png";
                                    $t3 = "No liquidado";
                                }
                                $obso = (!empty($listado[$i]->ObraSocial)) ? $listado[$i]->ObraSocial->getDenominacion() : "";

                                echo "<tr>
		<td align='center'>" . $quincena . "</td>
                <td align='center'>" . $mes . "</td>
                 <td align='center'>" . $listado[$i]->getAnio() . "</td>   
		<td align='center'>" . $listado[$i]->ObraSocial->getDenominacion() . "</td>
		<td align='center'>" . $listado[$i]->Plan->getDescripcion() . "</td>
		<td align='center'>" . $listado[$i]->getFacturado() . "</td>
		<td align='center'>" . $listado[$i]->getLiquidado() . "</td>
		<td align='center'>" . $listado[$i]->getSaldo() . "</td>
		<td align='center'>";
                                if ($listado[$i]->getCobrado())
                                    echo "<a href='detalleEstadoCuenta/" . $listado[$i]->getObraSocial()->getIdObraSocial() . "/"
                                    . $listado[$i]->getPlan()->getIdPlan() . "/" . $listado[$i]->getUnidad()->getIdUnidad() . "/" . $listado[$i]->getMes() . "/"
                                    . $listado[$i]->getAnio() . "'  class='here'><div class='details' title='Ver detalle'></div></a>";
                                echo "</td>
		<td align='center'><img src='images/$rec' title='$t1' alt='" . $listado[$i]->getRecibido() . "' /></td>
		<td align='center'><img src='images/$con' title='$t2' alt='" . $listado[$i]->getConfirmado() . "' /></td>
		<td align='center'><img src='images/$liq' title='$t3' alt='" . $listado[$i]->getCobrado() . "' /></td>
		</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- End Contenido -->
       
    </body>
</html>
