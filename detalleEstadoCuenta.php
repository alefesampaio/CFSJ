<? require "auth.php";
require 'BLL/managerCuentaCorriente.class.php'; ?>
<script type="text/javascript" src="js/right.js"></script>
<script type="text/javascript">
    $(".botonExcel").click(function() {
        $("#datos_a_enviar").val( $("<div>").append( $("#example").eq(0).clone()).html());
        $("#FormularioExportacion").submit();
    });
    $("#lnkPrint").click(function(){
        $("#print").jqprint();
    });	
    //
</script>
<link rel="stylesheet" href="css/demo_table_jui.css" />
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        oTable = $('#example').dataTable({
            "bJQueryUI": true,
            "bPaginate": false,
            "bInfo": true,
            "oLanguage": {
                "sLengthMenu": "Mostrar _MENU_ registros por página.",
                "sZeroRecords": "No se encontraron registros.",
                "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 a 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                "sSearch": "Buscar",
                "sFirst" : "Primera",
                "sPageFirst" : "Primera",
                "sLast" : "Última",
                "sNext" : "Siguiente",
                "sPageNextDisabled" : "Siguiente",
                "sPagePrevDisabled" : "Anterior",
                "sEmptyTable" : "No se encontraron resultados.",
                "sPrevious" : "Anterior"
            }            
        });
    } );
</script>
<div id="loaderDiv" class="hide"></div>
<div class="ui-widget-header ui-corner-all subtit">Estado de cuenta</div>
<!-- Contenido -->
<div id="main2">
    <div class="subtit2">Detalle</div>
    <?
    require_once 'funciones/functions.php';
    if (isset($_GET['idOS']) && isset($_GET['idPlan']) && isset($_GET['q']) && isset($_GET['m']) && isset($_GET['a'])) {
        $idOS = preparar($_GET['idOS']);
        $idPlan = preparar($_GET['idPlan']);
        $q = preparar($_GET['q']);
        $m = preparar($_GET['m']);
        $a = preparar($_GET['a']);
        $criterio = "fecha_liquidacion";
        $cuenta = managerCuentaCorriente::obtenerCuentaPorId2($idOS, $idPlan, $q, $m, $a, $criterio, $userAuth->Farmacia->getIdFarmacia());
        $listado = $cuenta->getDetalle();
        ?>
        <div id="optionBar" class="ui-widget-header ui-corner-all">
            <form action="exportarExcel.php" method="post" target="_blank" id="FormularioExportacion">
                <img src="images/Icon_Excel.png" class="botonExcel" title="Exportar a Excel" alt="Exportar a Excel" width="16" height="16" />
                <a href="" id="lnkPrint" class="here"><img src="images/print.png" width="16" height="16" alt="Imprimir"  /></a>
                <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
            </form>
        </div>
        <div id="print">
            <div id="example_wrapper" class="dataTables_wrapper" role="grid">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr class="tabletit2" >
                            <td >Fecha de liquidación</td> 
                            <td >Período</td>
                            <td >Mes</td>
                            <td >Año</td>
                            <td >Obra Social</td>
                            <td >Plan</td>    
                            <td >Detalle</td>
                            <td >Cobrado</td>
                            <td >Descuento</td>
                        </tr></thead><tbody>
                        <?
                        $array = meses();
                        $total = 0;
                        for ($i = 0; $i < count($listado); $i++) {
                            $fecha = new DateTime($listado[$i]->getFecha());
                            $total = $total + $listado[$i]->getDebe() + ($listado[$i]->getHaber());
                            $mes = $array[$cuenta->getMes()];
                            $quincena = $cuenta->Unidad->getDetalle();
                            $periodo = $quincena . " de " . $mes . " de " . $cuenta->getAnio();
                            echo "<tr>
                <td align='center'>" . $fecha->format("d/m/Y") . "</td>
		<td align='center'>" . $quincena . "</td>
                <td align='center'>" . $mes . "</td>
                 <td align='center'>" . $cuenta->getAnio() . "</td>   
		<td align='center'>" . $cuenta->ObraSocial->getDenominacion() . "</td>
		<td align='center'>" . $cuenta->Plan->getDescripcion() . "</td>
		<td align='center'>" . $listado[$i]->getDetalle() . "</td>
		<td align='center'>$" . $listado[$i]->getDebe() . "</td>
		<td align='center'>$" . $listado[$i]->getHaber() . "</td>
		</tr>";
                        }
                        ?>
                    </tbody> </table>
                <?
                if (isset($total)) {
                    ?><script type="text/javascript">
                     $("#example_info").html("Total liquidado: $<?= $total ?>.00");
                      </script> <?
                }
                ?>
            </div>
            <?
        } else {
            echo "<div class='infolist'>No has seleccionado ningún detalle.</div>";
        }
        ?>	


        <br /><p align='center'><a href='estadocuenta' class='ui-jQuery here'>« Volver</a></p>


    </div>