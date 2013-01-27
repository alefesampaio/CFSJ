<? require "auth.php"; require_once 'funciones/functions.php';  ?>
<link rel="stylesheet" href="css/demo_table_jui.css" />
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        oTable = $('#example').dataTable({
            "bJQueryUI": true,
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": false,
            "bInfo": false,
            "bAutoWidth": false,
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
            //"sPaginationType": "full_numbers"
        });
    } );
</script>
<div id="loaderDiv" class="hide"></div>
        <div class="ui-widget-header ui-corner-all subtit">Mis archivos</div>
            
<div id="main2">
  <div class="subtit2">Descarga</div>
 <div id="example_wrapper" class="dataTables_wrapper" role="grid">
        <table width="100%" cellpadding="0" cellspacing="0" border="0" class="display" id="example">
            <thead>
<tr class="tabletit">
     <td width="9">Fecha de actualización</td>
    <td width="9">Nombre</td>
    <td width="9">Tamaño</td>
    <td width="73">Descargar</td>
</tr></thead><tbody>
<?	$path="files/";
        $dir=dir($path);
        $array = array();
        if(file_exists($dir->path)){
            while ($elemento = $dir->read()){
                if(!is_dir($elemento)){ $array[]=$elemento; 
                }
            }
        }
        $dir->close();
        for ($i = 0; $i < count($array); $i++) {
            echo "<tr>
                 <td>".date("d/m/Y H:i:s.", filectime($path.$array[$i]))."</td>
                 <td><strong>$array[$i]</strong></td>
                 <td>".obtenerTamanio(filesize($path.$array[$i]))."</td>
                 <td><a href='$path$array[$i]'><img src='images/download2.png' width='16' height='16' alt='descargar'></a></td>
                  </tr>";
        }
?>    
            </tbody></table>  
</div>
 