<?
require "auth.php"; require "BLL/managerMandataria.class.php";

$id_mandataria = $_POST["id_mandataria"];
$listado = managerMandataria::obtenerPlanesPorOS($id_mandataria);
if(!empty($listado)){ ?>
    <table align="center"  border="0" cellspacing="1" cellpadding="1" class="grilla" >
      <thead>
        <tr class="tit">
        <td  class="ref"></td>
        <td  class="ref">Folio desde</td>
        <td  class="ref">Folio hasta</td>
        <td  class="ref">Cantidad</td>
        <td  class="ref">Importe total</td>
        <td  class="ref">Cargo OS</td>
        <td  class="ref">Neto</td>        
      </tr>
      </thead>
      <tbody>
      
  <?
  $row = 0;
  foreach ($listado as $os) { ?>
    <tr>
      <td colspan="7"><h4><?=$os[0]['detalle_os'];?></h4></td>
    </tr>
    <? foreach ($os as $plan) { ?>
    <tr>
    <td class='ref' align="right">
      <input type="hidden" name="plan<?=$row?>" value="<?=$plan['plan']?>" /> <?=$plan['detalle'];?>
    </td>
    <td><input type='text' name='folioDesde<?=$row?>' class='bigInput s100' maxlength='11' onkeypress='if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;' value='1' /></td>
    <td><input type='text' name='folioHasta<?=$row?>' class='bigInput s100' maxlength='11' onkeypress='if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;'  value='100'  /></td>
    <td><input type='text' name='cantidad<?=$row?>' class='bigInput s100' maxlength='11' onkeypress='if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;'  value='100'  /></td>
    <td><input type='text' name='importe<?=$row?>' class='bigInput s100' maxlength='16' onkeypress='if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;'  value='1000'  /></td>
    <td><input type='text' name='cargo<?=$row?>' class='bigInput s100' maxlength='16' onkeypress='if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;'  value='500'  /></td>
    <td><input type='text' name='neto<?=$row?>' class='bigInput s100' maxlength='16' onkeypress='if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;' value='500'   /></td>
    </tr>
  
  <? $row++;
  }
} ?>
</tbody></table>    
<?  } ?>
<input type="hidden" name="cantPlanes" value="<?= count($listado) ?>" />