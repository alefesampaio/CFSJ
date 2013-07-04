<? require_once "auth.php";
require_once 'BLL/managerLiquidacion.class.php'; ?>
<script type="text/javascript" src="js/right.js"></script>
<script type="text/javascript">
$(".botonExcel").click(function() {
    $("#datos_a_enviar").val( $("<div>").append( $("#example").eq(0).clone()).html());
    $("#FormularioExportacion").submit();
});
$("#lnkPrint").click(function(){
    $("#print").jqprint();
});	

</script>
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

<div class="ui-widget-header ui-corner-all subtit">Estado de cuenta</div>
<!-- Contenido -->
<div id="main2">
    <div class="subtit2">Detalle</div>
    <?
    require_once 'funciones/functions.php';
    if (isset($_GET['rendicion'])) {
        $rendicion = preparar($_GET['rendicion']);
        $criterio = "fecha_liquidacion";
        $params = array(
            'rendicion' => $rendicion,
            'criterio' => $criterio,
            'farmaciaId' => $userAuth->Farmacia->getIdFarmacia()
            );
        $listado = managerLiquidacion::obtenerTodos($params);
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

                            <td >Período</td>
                            <td >Mes</td>
                            <td >Año</td>
                            <td >Obra Social</td>
                            <td >Plan</td>
                            <td >Imputacion</td>
                            <td >Egresos</td>
                            <td >Ingresos</td>                            
                        </tr>
                    </thead><tbody>
                    <?
                    $array = meses();
                    $total = 0;
                    foreach ($listado as $liq) {
                        $mes = $array[$liq->getMes()];
                        $periodo = ($liq->getQuincena()==1) ? '1er quincena' : (($liq->getQuincena()==2) ? '2da quincena' : 'Mensual');
                        echo "<tr>
                        <td align='center'>" . $periodo . "</td>
                        <td align='center'>" . $mes . "</td>
                        <td align='center'>" . $liq->getAnio() . "</td>   
                        <td align='center'>" . $liq->getObrasocial() . "</td>
                        <td align='center'>" . $liq->getPlan() . "</td>
                        <td align='center'>" . $liq->getImputacion() . "</td>
                        <td align='center'>" . $liq->getIngresos() . "</td>
                        <td align='center'>" . $liq->getEgresos() . "</td>
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


        <br /><p align='center'><a href='estadocuenta/liquidacion' class='ui-jQuery here'>« Volver</a></p>


    </div>