<? require "auth.php"; //ini_set("display_errors", 1); ?>
<script type="text/javascript" src="js/right.js"></script>
<script type="text/javascript">
$(function(){	
        //$("#lnkPrint").button({ icons: {primary:'ui-icon-print'}});  
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
<div class="ui-widget-header ui-corner-all subtit">Carátulas</div>
<div id="main2">
    <div class="subtit2">Listado</div>
    <?
    if ($_GET["act"] == "listar") {
        if (isset($_GET['op']) && $_GET['op'] == 'eliminar') {
            if (isset($_GET['id']) && $_GET['id'] != "") {
                $codigoBarra = preparar($_GET['id']);
                //var_dump($codigoBarra);
                if (managerFactura::obtenerFacturaPorCodigoBarraBool($codigoBarra)) {
                    $facturasdb = managerFactura::obtenerFacturaPorCodigoBarraObj($codigoBarra, $userAuth->Farmacia->getIdFarmacia());

                    for ($i = 0; $i < count($facturasdb); $i++) {
                        if ($facturasdb[$i]->getRecibido() == 0) {
                            if ($i == count($facturasdb) - 1) {
                                echo managerFactura::borrarFactura($codigoBarra, $userAuth->Farmacia->getIdFarmacia());
                            } else {
                                managerFactura::borrarFactura($codigoBarra, $userAuth->Farmacia->getIdFarmacia());
                            }
                        } else {
                            $error = true;
                        }
                    }
                    if (isset($error) && $error)
                        echo "<div class='errorlist'>No puedes eliminar esta carátula.</div>";
                } else {
                    echo "<div class='errorlist'>La carátula que intentas eliminar, no existe.</div>";
                }
            }
        }
        $criterio = "fecha";
        $listado = managerFactura::obtenerTodos2($criterio, $userAuth->Farmacia->getIdFarmacia());
        ?>
        <div id="example_wrapper" class="dataTables_wrapper" role="grid" style="width: 100% !important">
            <table  cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                    <tr>
                        <td >Código Barra</td>
                        <td >Fecha</td>
                        <td >Obra Social</td>
                        <td >Plan</td>
                        <td >Folio Desde</td>
                        <td >Folio Hasta</td>
                        <td >Cantidad de recetas</td>
                        <td >Importe total ($)</td>
                        <td >Arancel OS ($)</td>
                        <td >Importe Neto ($)</td>
                        <td >Período</td>
                        <td >Mes</td>
                        <td >Año</td>
                        <td >Usuario</td>
                        <td >Editar</td>
                        <td >Imprimir</td>
                        <td >Eliminar</td>

                    </tr>
                </thead><tbody>
                <?
                foreach ($listado as $f) {
                    $fecha = new DateTime($f->getFecha());
                    $array = managerFactura::meses();
                    if ($f->getAgrupado() == 1) {
                        $plan = "Todos";
                        $folioDesde = "";
                        $folioHasta = "";
                        $edit = "<td></td>";
                    } else {
                        $plan = $f->Plan->getDescripcion();
                        $folioDesde = $f->getFolioDesde();
                        $folioHasta = $f->getFolioHasta();
                        $edit = "<td align='center'><a href='caratulaEdit/" . $f->getIdFactura() . "' class='here'><div class='editar' title='Editar'></div></a></td>";
                    }
                    $mes = $array[$f->getMes()];
                    $quincena = $f->Unidad->getDetalle();
                    echo "<tr>
                    <td align='center'>" . $f->getCodigoBarra() . "</td>
                    <td align='center'>" . $fecha->format("d/m/Y H:i") . "</td>
                    <td align='center'>" . $f->Plan->ObraSocial->getDenominacion() . "</td>
                    <td align='center'>" . $plan . "</td>
                    <td align='center'>" . $folioDesde . "</td>
                    <td align='center'>" . $folioHasta . "</td>
                    <td align='center'>" . $f->getCantRecetas() . "</td>
                    <td align='center'>" . $f->getArancel() . "</td>
                    <td align='center'>" . $f->getArancelOS() . "</td>
                    <td align='center'>" . $f->getImporteBonificacion() . "</td>
                    <td align='center'>" . $quincena . "</td>
                    <td align='center'>" . $mes . "</td>
                    <td align='center'>" . $f->getAnio() . "</td>
                    <td align='center'>" . $f->getOperador() . "</td>";
                    if ($f->getRecibido() == 0) {
                        echo "$edit
                        <td align='center'><a href='historialCaratulas/imprimir/" . $f->getCodigoBarra() . "' class='here' ><div class='print' title='Imprimir' ></div></a></td>
                        <td align='center'><a href='historialCaratulas/listar/eliminar/" . $f->getCodigoBarra() . "' class='here'><div class='delete' title='Eliminar' ></div></a></td>";
                    } else {
                        echo "<td></td><td></td><td></td>";
                    }
                    echo "</tr>";
                }
                ?>
            </tbody></table>


            <?
        } else if ($_GET["act"] == "imprimir") {


            if (isset($_GET["id"])) {
                $codigoBarra = preparar($_GET["id"]);

                if (managerFactura::obtenerFacturaPorCodigoBarraBool($codigoBarra)) {

                    $caratulas = managerFactura::obtenerFacturaPorCodigoBarraObj($codigoBarra, $userAuth->Farmacia->getIdFarmacia());
                    //$listPlanes = array();
                    $importe = "";
                    $cargo = "";
                    $totalRecetas = "";
                    $neto = "";
                    foreach ($caratulas as $c) {
                        $importe += $c->getArancel();
                        $cargo += $c->getArancelOS();
                        $totalRecetas += $c->getCantRecetas();
                        $neto += $c->getImporteBonificacion();
                        $caratula = $c;
                    }

                    if ($caratula->getRecibido() == 0) {
                        $array = managerFactura::meses();
                        $mes = $array[$c->getMes()];
                        $anio = $c->getAnio();
                        if ($c->Unidad->getIdUnidad() != 3) {
                            $periodo = $c->Unidad->getDetalle() . " de " . $mes . " de " . $anio;
                        } else {
                            $periodo = "Mes de " . $mes . " de " . $anio;
                        }
                        $barra = $c->getCodigoBarra();
                        $porcBon = round($c->getPorcentajeBonificacion() * 100) / 100;
                        $fechaProceso = new DateTime($c->getFecha());
                        ?>
                        <div class="imprimir"><input name="lnkPrint" id="lnkPrint" type="button" value="Imprimir" class="ui-jQuery" /></div>

                        <div id="encabezado">
                            <img align="left" src="images/logo_menu.png" alt="Colegio Farmacéutico de San Juan" />
                            <div id="farmInfo">
                                <table width="100%" border="1" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td class="subtit4">Farmacia:</td>
                                        <td class="data4" align="left"><? echo $c->Farmacia->getNombreFantasia() . " - " . $c->Farmacia->getIdFarmacia(); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="subtit4">CUIT:</td>
                                        <td class="data4" align="left"><? echo $c->Farmacia->getCuit(); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="subtit4">Domicilio:</td>
                                        <td class="data4" align="left"><? echo $c->Farmacia->getDomicilio(); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="subtit4">Director:</td>
                                        <td class="data4" align="left"><? echo $c->Farmacia->getDirectorTecnico()->getNombreYApellido(); ?></td>
                                    </tr>
                                </table></div></div>
                                <br />
                                <div class="linea"></div>
                                <br />
                                <table class="preliminar"  align="center" width="70%"  cellspacing="0" cellpadding="0" border="1">
                                    <tr>
                                        <td  class="subtit4">Fecha de Proceso:</td>
                                        <td class="data4" align="left"><? echo $fechaProceso->format("d/m/Y H:i"); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="subtit4">Período:</td>
                                        <td  class="data4" align="left"><? echo $periodo; ?></td>
                                    </tr>
                                    <tr>
                                        <td  class="subtit4">Obra Social:</td>
                                        <td class="data4"  align="left"><? echo $c->Plan->ObraSocial->getDenominacion(); ?>
                                        </td>
                                    </tr>

                                    <? if (count($caratulas) == 1) { ?>
                                    <tr>
                                        <td class="subtit4">Plan:</td>
                                        <td  class="data4"  align="left"><? echo $c->Plan->getDescripcion(); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="subtit4">Folio desde:</td>
                                        <td  class="data4" align="left"><? echo $c->getFolioDesde(); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="subtit4">Folio hasta:</td>
                                        <td  class="data4" align="left"><? echo $c->getFolioHasta(); ?></td>
                                    </tr></table>
                                    <? } else {
                                        echo "</table>"; ?>

                                        <br />
                                        <table width="70%" border="1" align="center" cellpadding="0" cellspacing="0" class="preliminar">
                                            <tr>
                                                <td align="center" class="subtit4">Plan:</td>
                                                <td align="center" class="subtit4">Cantidad de recetas:</td>
                                                <td align="center" class="subtit4">Folio desde:</td>
                                                <td align="center" class="subtit4">Folio hasta:</td>
                                                <td align="center" class="subtit4">Importe total:</td>
                                                <td align="center" class="subtit4">A cargo entidad:</td>
                                            </tr>
                                            <?
                                            foreach ($caratulas as $c) {
                                                echo "<tr>
                                                <td align='center'  class='data4'>" . $c->Plan->getDescripcion() . "</td>
                                                <td align='center'  class='data4'>" . $c->getCantRecetas() . "</td>
                                                <td align='center'  class='data4'>" . $c->getFolioDesde() . "</td>
                                                <td align='center'  class='data4'>" . $c->getFolioHasta() . "</td>
                                                <td align='center'  class='data4'>$" . $c->getArancel() . "</td>
                                                <td align='center'  class='data4'>$" . $c->getArancelOS() . "</td>
                                                </tr>";
                                            }
                                            ?>
                                        </table>
                                        <? } ?>




                                        <br />
                        <!--<div class="separador"></div>
                    -->
                    <table width="70%" border="1" align="center" cellpadding="0" cellspacing="0" class="preliminar">
                        <tr>
                            <td align="center" class="subtit4">Cantidad de recetas:</td>
                            <td align="center" class="subtit4">Importe Total:</td>
                            <td align="center" class="subtit4">A cargo entidad:</td>
                            <? if ($c->getPorcentajeBonificacion() != 0)
                            echo "<td align='center' class='subtit4'>Porcentaje de bonificación:</td>"; ?>
                            <td align="center" class="subtit4">Neto a cobrar:</td>

                        </tr>
                        <tr>

                            <td align="center"  class="data4"><? echo $totalRecetas; ?></td>
                            <td align="center"  class="data4">$<? echo $importe; ?></td>
                            <td align="center"  class="data4">$<? echo $cargo; ?></td>
                            <? if ($c->getPorcentajeBonificacion() != 0)
                            echo "<td align='center' class='subtit4'>%" . $porcBon . "</td>"; ?>  
                            <td align="center"  class="data4">$<? echo $neto; ?></td>

                        </tr>
                    </table>
                    <br	 /><br	 />
                    <div class="subtit3">Confirmación de lote</div>    
                    <br />
                    <div class="separador2"></div>
                    <table width="100%" border="0" cellspacing="2" cellpadding="2">
                        <tr>
                            <td width="33%" align="center" class="subtit4"><span>Sello</span></td>
                            <td width="33%" align="center" class="subtit4"><span>Firma</span></td>
                            <td width="34%" align="center" class="subtit4"><span>Aclaración</span></td>
                        </tr>
                    </table>
                    <br />
                    <br />
                    <table align="center" width="70%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td align="right" width="72%"><img src="codigoBarra.php?NUM=<? echo $barra ?>&TYP=Code128&IMG=png"/></td>
                        </tr>

                    </table>
                    <br /><p align='center'><a href='historialCaratulas/listar' class='ui-jQuery here' id="goBack">« Volver</a></p>
                    <br />	<?
                }else {
                    echo "<div class='errorlist'>No puedes reimprimir esta carátula.</div>";
                }
            } else {
                echo "<div class='errorlist'>La carátula que intentas imprimir, no existe.</div>";
            }
        } else {
            echo "<div class='errorlist'> Debes seleccionar una carátula.</div>";
        }
    }
    ?>
</div> 
