<? require "auth.php"; ini_set('display_errors', 1);
require_once 'BLL/managerVentaFarmacia.class.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Colegio Farmaceútico de San Juan | Ventas</title>
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

        $lista = managerVentaFarmacia::obtenerTodos();
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
                                        <td >Farmacia</td>
                                        <td >Medicamento</td>
                                        <td >Presentación</td>
                                        <td >Laboratorio</td>
                                        <td >Cantidad</td>
                                        <td >Obra Social</td>
                                        <td >Nombre y apellido</td>
                                        <td >DNI Cliente</td>
                                        <td >Matrícula Médico</td>
                                        <td >Nro. de recetario</td>
                                        <td >Operación</td>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?
                                    foreach ($lista as $s) {
                                        echo "<tr >
<td>" . $s->getFecha() . "</td>
<td>" . $s->getFarmacia()->getRazonSocial() . "</td>
<td align='center'>" . $s->getManual()->getNombre() . "</td>
<td align='center'>" . $s->getManual()->getPresentacion() . "</td>
<td align='center'>" . strtoupper($s->getManual()->getLaboratorio()) . "</td>
<td align='center'>" . $s->getCantidad() . "</td>
<td align='center'>" . $s->getObraSocial()->getDenominacion() . "</td>
<td align='center'>" . $s->getNombreApellido() . "</td>
<td align='center'>" . $s->getDni() . "</td>
<td align='center'>" . $s->getMatriculaMedico() . "</td>
<td align='center'>" . $s->getNroRecetario() . "</td>
<td>VENTA</td>

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
