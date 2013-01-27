<?
require "auth.php"; require "BLL/managerPlan.class.php";

$obraSoc = $_POST["idOS"];
$listado = managerPlan::obtenerPlanesPorOS($obraSoc);
if(count($listado)>0){ ?>
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
      
  <? for ($i = 0; $i < count($listado); $i++) {
     echo "<tbody><tr>
           <td class='ref' align='right'><input type='hidden' name='plan$i' value='".$listado[$i]->getIdPlan()."' />".$listado[$i]->getDescripcion().":</td>
           <td><input type='text' name='folioDesde$i' class='bigInput s100' maxlength='11' onkeypress='if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;' value='0' /></td>
           <td><input type='text' name='folioHasta$i' class='bigInput s100' maxlength='11' onkeypress='if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;'  value='0'  /></td>
           <td><input type='text' name='cantidad$i' class='bigInput s100' maxlength='11' onkeypress='if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;'  value='0'  /></td>
           <td><input type='text' name='importe$i' class='bigInput s100' maxlength='16' onkeypress='if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;'  value='0'  /></td>
           <td><input type='text' name='cargo$i' class='bigInput s100' maxlength='16' onkeypress='if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;'  value='0'  /></td>
           <td><input type='text' name='neto$i' class='bigInput s100' maxlength='16' onkeypress='if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;' value='0'   /></td>
           </tr></tbody>";
 }
// echo "<tr>
//        <td></td>
//        <td></td>
//        <td class='ref' align='right'>Total:</td>
//        <td><input type='text' name='totalCantidad' class='bigInput s100' maxlength='16' onkeypress='if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;'  value=''  /></td>
//        <td><input type='text' name='totalImporte' class='bigInput s100' maxlength='16' onkeypress='if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;'  value=''  /></td>
//        <td><input type='text' name='totalCargo' class='bigInput s100' maxlength='16' onkeypress='if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;'  value=''  /></td>
//        <td><input type='text' name='totalNeto' class='bigInput s100' maxlength='16' onkeypress='if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;'  value=''  /></td>
//       </tr>"
  ?></table>   
    
<?  } ?>
<input type="hidden" name="cantPlanes" value="<?= count($listado) ?>" />
