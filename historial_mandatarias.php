<? require "auth.php"; ini_set("display_errors", true); ?>
<script type="text/javascript" src="js/right.js"></script>
<script type="text/javascript">
$(function(){	
        $("#lnkPrint").click(function(){
            $("div.subtit2").hide();
            $("div.imprimir").hide();
            $("#goBack").hide();
            $("#main2").jqprint();
            
        })	  
    })
</script>
<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
    oTable = $('#example').dataTable({
        "bJQueryUI": true,
        "sScrollX": "100%",
        "sScrollXInner": "110%",
        "bScrollCollapse": false,
        "aLengthMenu": [[20, 50, 100 , 200, -1], [20, 50, 100, 200, "Todos"]],
        "iDisplayLength" : 100,
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
        },
        "sPaginationType": "full_numbers"
    });
} );
</script>
<?
require_once "BLL/managerFactura.class.php";
require_once 'funciones/functions.php';
?>
<div class="ui-widget-header ui-corner-all subtit">Mandatarias</div>
<div id="main2">
    <div class="subtit2">Listado</div>
    <?
    if ($_GET["act"] == "listar") {
        if (isset($_GET['op']) && $_GET['op'] == 'eliminar') {
            if (isset($_GET['id']) && $_GET['id'] != "") {
                $codigoBarra = preparar($_GET['id']);
                $r = managerFactura::borrarMandataria($codigoBarra, $userAuth->Farmacia->getIdFarmacia());
                if(!$r)
                    echo "<div class='errorlist'>La carátula que intentas eliminar, no existe.</div>";
                else
                    echo "<div id='succesBlock' class='succesList'>La carátula se eliminó con éxito.</div>";
            }
        }
        $criterio = "fecha";
        $listado = managerFactura::obtenerMandatarias($criterio, $userAuth->Farmacia->getIdFarmacia());
        ?>
        <div id="example_wrapper" class="dataTables_wrapper" role="grid" style="width: 100% !important">
            <table  cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                    <tr>
                        <td >Código Barra</td>
                        <td >Fecha</td>
                        <td >Mandataria</td>
                        <td >Cantidad de recetas</td>
                        <td >Arancel OS ($)</td>
                        <td >Período</td>
                        <td >Mes</td>
                        <td >Año</td>
                        <td >Usuario</td>
                        <td >Eliminar</td>

                    </tr>
                </thead><tbody>
                <?
                foreach ($listado as $f) {
                    // var_dump($f);exit;
                    $fecha = new DateTime($f['fecha']);
                    $array = managerFactura::meses();
                    $plan = "Todos";
                    $folioDesde = "";
                    $folioHasta = "";
                    $mes = $array[$f['mes']];
                    $quincena = $f['unidad_detalle'];
                    echo "<tr>
                    <td align='center'>" . $f['barra'] . "</td>
                    <td align='center'>" . $fecha->format("d/m/Y H:i") . "</td>
                    <td align='center'>" . $f['mandataria_detalle'] . "</td>
                    <td align='center'>" . $f['recetas'] . "</td>
                    <td align='center'>" . $f['arancel_os'] . "</td>
                    <td align='center'>" . $quincena . "</td>
                    <td align='center'>" . $mes . "</td>
                    <td align='center'>" . $f['anio'] . "</td>
                    <td align='center'>" . $f['operador'] . "</td>";
                    if ($f['recibido'] == '0') {
                        echo "<td align='center'><a href='historial_mandatarias.php?act=listar&op=eliminar&id=" . $f['barra'] . "' class='here'><div class='delete' title='Eliminar' ></div></a></td>";
                    } else {
                        echo "<td></td>";
                    }
                    echo "</tr>";
                }
                ?>
            </tbody></table>


            <?
    }
    ?>
</div> 
