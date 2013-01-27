<?
//ini_set('display_errors',1); 
require "auth.php";
require_once 'funciones/functions.php';
require_once 'BLL/managerCuentaCorriente.class.php';
require_once 'BLL/managerPlan.class.php'
?>
<script type="text/javascript" src="js/right.js"></script>
<script type="text/javascript" src="js/highcharts.js"></script>
<script type="text/javascript">
    $(function(){
        $("#fobrasocial").change(function(){ $.post("cargarPlanes.php", { id:$(this).val() }, function(data){$("#fplan").html(data)}) }) 
    })
</script>
<div id="loaderDiv" class="hide"></div>
<div class="ui-widget-header ui-corner-all subtit">Estadísticas</div>
<div id="main2">
<? require_once 'BLL/managerObraSocial.class.php';
if (1 != 1) { ?>
        <div id="filtro">
            <form action="estadisticas.php" method="post" name="statsOS" id="statsOS" class="ajax">
                <fieldset class="frmFiltro">

                    <label>Obra Social:</label><select name="fobrasocial" id="fobrasocial" ><option value=''>Seleccionar</option>
                        <?
                        $los = managerObraSocial::obtenerTodos();
                        foreach ($los as $os) {
                            $cl = ($_POST['fobrasocial'] == $os->getIdObraSocial()) ? "selected='selected'" : "";
                            echo "<option value='" . $os->getIdObraSocial() . "' $cl>" . $os->getDenominacion() . "</option>";
                        }
                        ?>      
                    </select>
                    <label>Plan:</label><select name="fplan" id="fplan"><option value=''>Seleccionar</option></select>
                    <input name="buscar" type="submit" value="Buscar" class="ui-jQuery" />
                    <input name="buscar" type="hidden" value="buscar" />
                </fieldset>
            </form>
        </div>

<? } else {
    echo "<div class='infolist'>Aún no tienes suficientes registros. </div>";
} ?>


    <div id="container3" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
    <div id="container2" style="min-width: 400px; height: 400px; margin: 0 auto"></div>     
    <div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
    <?
    if (isset($_POST['buscar'])) {
        if (isset($_POST['fobrasocial']))
            $fobrasocial = preparar($_POST['fobrasocial']);
        if (isset($_POST['fplan']))
            $fplan = preparar($_POST['fplan']);
    }else {
        $fobrasocial = 2;
        $fplan = 1;
    }
//$fobrasocial = 5; $fplan = 2;
    $nombreOS = managerObraSocial::obtenerOSPorId($fobrasocial)->getDenominacion();
    $mes = meses();
    $periodos = managerCuentaCorriente::obtenerTodosPorOSYMes($userAuth->Farmacia->getIdFarmacia(), $fobrasocial, $fplan);
    $periodos = array_reverse($periodos);
    for ($i = 0; $i < count($periodos); $i++) {
        $c = ($i < count($periodos) && $i > 0) ? " ," : "";
        $categories[] = $c . "'" . $periodos[$i]['mes'] . "/" . $periodos[$i]['anio'] . "'";
        $facturado[] = $c . $periodos[$i]['totalFacturado'];
        $liquidado[] = $c . $periodos[$i]['totalLiquidado'];
    }
//echo count($facturado)."<br />";
    $plan = managerPlan::obtenerPlanPorId($fplan);
    $name = strtolower($plan->getDescripcion());
    ?>
    <script type="text/javascript">
        $(function () {
            var chart;
            $(document).ready(function() {
                chart = new Highcharts.Chart({
                    chart: {
                        renderTo: 'container',
                        type: 'line'
                    },
                    title: {
                        text: 'Facturación-Liquidación anual para <? echo ucwords($name) ?>'
                    },
                    subtitle: {
                        text: ''
                    },
                    xAxis: {
                        categories: [ <? foreach ($categories as $c) {
        echo $c;
    } ?> ]
                    },
                    yAxis: {
                        title: {
                            text: 'Pesos ($)'
                        }
                    },
                    tooltip: {
                        enabled: true,
                        formatter: function() {
                            return '<b>'+ this.series.name +'</b><br/>'+
                                this.x +': $'+ this.y ;
                        }
                    },
                    plotOptions: {
                        line: {
                            dataLabels: {
                                enabled: true
                            },
                            enableMouseTracking: true
                        }
                    },
                    series: [{
                            name: 'Facturado',
                            data: [ <? foreach ($facturado as $f) {
        echo $f;
    } ?>]
                        }, {
                            name: 'Liquidado',
                            data: [  <? foreach ($liquidado as $l) {
        echo $l;
    } ?>]
                        }]
                });
            });
    
        });
    </script>
    <!--//////////////////////////////////////////////////////-->
<?
$listPlanes = managerCuentaCorriente::obtenerPlanesPorOS($userAuth->Farmacia->getIdFarmacia(), $fobrasocial);
?>
    <script type="text/javascript">
        $(function () {
            var chart;
            $(document).ready(function() {
                chart = new Highcharts.Chart({
                    chart: {
                        renderTo: 'container2',
                        type: 'line',
                        marginRight: 130,
                        marginBottom: 25
                    },
                    title: {
                        text: 'Facturación por plan anual para <? echo $nombreOS ?>',
                        x: -20 //center
                    },
                    subtitle: {
                        text: '',
                        x: -20
                    },
                    xAxis: {
                        categories: [<? foreach ($categories as $c) {
    echo $c;
} ?>]
                    },
                    yAxis: {
                        title: {
                            text: 'Pesos ($)'
                        },
                        plotLines: [{
                                value: 0,
                                width: 1,
                                color: '#808080'
                            }]
                    },
                    tooltip: {
                        formatter: function() {
                            return '<b>'+ this.series.name +'</b><br/>'+
                                this.x +': $'+ this.y;
                        }
                    },
                    plotOptions: {
                        line: {
                            dataLabels: {
                                enabled: false
                            },
                            enableMouseTracking: true
                        }
                    },
            
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'top',
                        x: -10,
                        y: 100,
                        borderWidth: 0
                    },
                    series: [
<?
for ($i = 0; $i < count($listPlanes); $i++) {
    $l = ($i < count($listPlanes) && $i > 0) ? " ," : "";
    $nombrePlan = managerPlan::obtenerPlanPorId($listPlanes[$i]['plan'])->getDescripcion();
    $planPeriod = managerCuentaCorriente::obtenerTodosPorOSYMes($userAuth->Farmacia->getIdFarmacia(), $fobrasocial, $listPlanes[$i]['plan']);
    $planPeriod = array_reverse($planPeriod);
    for ($j = 0; $j < count($planPeriod); $j++) {
        $coma = ($j < count($planPeriod) && $j > 0) ? ", " : "";
        $planFacturado[] = $coma . $planPeriod[$j]['totalFacturado'];
    }
    echo $l . "{ name: '" . $nombrePlan . "', data: [";
    foreach ($planFacturado as $pf) {
        echo $pf;
    }
    echo " ] }";
    unset($planPeriod);
    unset($planFacturado);
    unset($nombrePlan);
}
?>
                                    ]
                                });
                            });
    
                        });
    </script>    
    <?
//$listPlanes = managerCuentaCorriente::obtenerPlanesPorOS($userAuth->Farmacia->getIdFarmacia(), $fobrasocial);
//
//for ($i = 0; $i < count($listPlanes); $i++) {
//                 
//                 $l = ($i<count($listPlanes) && $i>0) ? " ," : "";
//                 $planPeriod = managerCuentaCorriente::obtenerTodosPorOSYMes($userAuth->Farmacia->getIdFarmacia(), $fobrasocial, $listPlanes[$i]['plan']);
//                 $planPeriod = array_reverse($planPeriod);
//                 echo count($planPeriod);
//                 for ($j = 0; $j < count($planPeriod); $j++) {
//                      $coma = ($j<count($planPeriod) && $j>0) ? ", " : "";
//                      $planFacturado[] = $coma.$planPeriod[$j]['totalFacturado'];
//                 }
//                 echo count($planFacturado);
//                 echo $l."{ name: '".$listPlanes[$i]['plan']."', data: ["; foreach ($planFacturado as $pf) { echo $pf; }
//                 echo " ] }";
//                 //var_dump( is_array( $variable ) );
//                 unset($planPeriod);
//                 unset($planFacturado);                 
//                }
    ?>
<!--<script type="text/javascript">
$(function () {
var chart;
$(document).ready(function() {
chart = new Highcharts.Chart({
chart: {
    renderTo: 'container4',
    plotBackgroundColor: null,
    plotBorderWidth: null,
    plotShadow: false
},
title: {
    text: 'Browser market shares at a specific website, 2010'
},
tooltip: {
    formatter: function() {
        return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
    }
},
plotOptions: {
    pie: {
        allowPointSelect: true,
        cursor: 'pointer',
        dataLabels: {
            enabled: true,
            color: '#000000',
            connectorColor: '#000000',
            formatter: function() {
                return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
            }
        }
    }
},
series: [{
    type: 'pie',
    name: 'Browser share',
    data: [
        ['Firefox',   45.0],
        ['IE',       26.8],
        {
            name: 'Chrome',
            y: 12.8,
            sliced: true,
            selected: true
        },
        ['Safari',    8.5],
        ['Opera',     6.2],
        ['Others',   0.7]
    ]
}]
});
});

});
    </script>-->
    <script type="text/javascript">
        $(function () {
            var chart;
            $(document).ready(function() {
                chart = new Highcharts.Chart({
                    chart: {
                        renderTo: 'container3',
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false
                    },
                    title: {
                        text: 'Facturación mensual por Obra Social'
                    },
                    tooltip: {
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
                        }
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                color: '#000000',
                                connectorColor: '#000000',
                                formatter: function() {
                                    return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
                                }                        
                            },
                            showInLegend: true
                        }
                    },
                    series: [{
                            type: 'pie',
                            name: 'Browser share',
                            data: [<?
    $listaOS = managerCuentaCorriente::obtenerTodosPorOS($userAuth->Farmacia->getIdFarmacia());
    for ($i = 0; $i < count($listaOS); $i++) {
        $OSname = managerObraSocial::obtenerOSPorId($listaOS[$i]['obra_social'])->getDenominacion();
        $sep = ($i < count($listaOS) && $i > 0) ? ", " : "";
        if ($i != 0) {
            echo $sep . "['" . $OSname . "',   " . $listaOS[$i]['totalFacturado'] . "]";
        } else {
            echo $sep . "{  name: '" . $OSname . "', y: " . $listaOS[$i]['totalFacturado'] . ", sliced: true, selected: true }";
        }

        unset($OSname);
    }
    ?>
                        ]
                    }]
            });
        });
    
    });
    </script>

    <script type="text/javascript" src="http://code.highcharts.com/modules/exporting.js"></script>














</div>