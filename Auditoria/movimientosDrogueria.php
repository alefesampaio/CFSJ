<? require "auth.php";
require_once 'BLL/managerVentaDrogueria.class.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Colegio Farmaceútico de San Juan | Movimientos</title>
        <? include 'head.html'; ?>

        <link rel="stylesheet" href="css/demo_table_jui.css" />
        <script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                oTable = $('#example').dataTable({
                    "bJQueryUI": true,
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
        <style>
            .hero-unit {
                padding: 30px;
            }
            select { width: auto; }
        </style>
    <body>
        <?
        include 'navbar.php';

        $lista = managerVentaDrogueria::obtenerTodos();
        ?>
        <div class="container-fluid">
            <div class="row-fluid  content">
                <? include 'navmenu.php'; ?>
                <div class="span10">
                    <div class="row-fluid">
                        <div class="page-header">
                            <h3>Listado de ventas</h3>
                        </div> 
                        <div id="example_wrapper" class="dataTables_wrapper" role="grid">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-hover" id="example">
                                <thead>
                                    <tr>
                                        <td >Fecha</td>
                                        <td >Drogueria</td>
                                        <td >Farmacia</td>
                                        <td >Medicamento</td>
                                        <td >Presentación</td>
                                        <td >Laboratorio</td>
                                        <td >Nro. de factura</td>
                                        <td >Cantidad</td>
                                        <td >Fecha de vto.</td>
                                        <td >Nro. de lote</td>
                                        <td >Operación</td>
                                   </tr>
                                </thead>
                                <tbody>
                                    <?
                                    foreach ($lista as $s) {
                                        echo "<tr >
<td>" . $s->getFecha() . "</td>
<td>" . $s->getDrogueria()->getDenominacion() . "</td>
<td>" . $s->getFarmacia()->getNombreFantasia() . "</td>
<td>" . $s->getManual()->getNombre() . "</td>
<td>" . $s->getManual()->getPresentacion() . "</td>
<td>" . $s->getManual()->getLaboratorio() . "</td>
<td>" . $s->getNroFactura() . "</td>
<td>" . $s->getCantidad() . "</td>
<td>" . $s->getFechaVencimiento() . "</td>
<td>" . $s->getNroLote() . "</td>
<td>Venta</td>
</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                    </div><!--/row-->
                </div><!--/span-->
            </div><!--/row-->
            <hr>
            <? include 'footer.php'; ?>
        </div><!--/.fluid-container-->
        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <div id="XPLSS_Flyover" style="position: absolute; z-index: 10002; visibility: hidden; left: -2100px; top: -2100px; ">
        </div>
        <div id="XPLSS_Trans" style="position: absolute; z-index: 10000; visibility: hidden; left: -2100px; top: -2100px; "></div><embed type="application/avg-searchshield-plugin" hidden="yes" id="avgss-plugin">
    </body>
</html>
