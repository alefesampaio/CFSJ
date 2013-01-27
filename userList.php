<script type="text/javascript" src="js/right.js"></script>
<link rel="stylesheet" href="css/demo_table_jui.css" />
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
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
<? require "auth.php"; ?>
<div id="loaderDiv" class="hide"></div>
<div class="ui-widget-header ui-corner-all subtit">Usuarios</div>
<div id="main2">
    <div class="subtit2">Listado de Usuarios</div>
    <?
    $lista = ManagerUsuario::obtenerTodos("idUser");
    ?>
    <div id="example_wrapper" class="dataTables_wrapper" role="grid">
        <table width="100%" cellpadding="0" cellspacing="0" border="0" class="display" id="example">
            <thead>
                <tr>
                    <td >ID</td>
                    <td >Farmacia</td>
                    <td >Usuario</td>
                    <td >Email</td>
                    <td >Fecha Nacimiento</td>
                    <td >Sexo</td>
                    <td >Nivel Admin</td>
                    <td >Última visita</td>
                    <td >Editar</td>
                    <td >Eliminar</td>

                </tr></thead>
            <tbody>
                <?
                foreach ($lista as $u) {
                    echo "<tr >
			<td>" . $u->getIdUser() . "</td>
			<td>" . $u->getFarmacia()->getNombreFantasia() . "</td>
			<td align='center'>" . $u->getUsuario() . "</td>
			<td align='center'>" . $u->getEmail() . "</td>
			<td align='center'>" . $u->getFechaNac() . "</td>
			<td align='center'>" . $u->getSexo() . "</td>
			<td align='center'>" . $u->nivelAdmin->getDescripcion() . "</td>
			<td align='center'>" . $u->getUltimaVisita() . "</td>
			<td align='center'><a href='userEdit/" . $u->getIdUser() . "' class='here' ><div class='editar' title='Editar'></div></a></td>
			<td align='center'><a href='userEdit/eliminar/" . $u->getIdUser() . "' class='here'><div class='delete' title='Eliminar'></div></a></td>
			</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
