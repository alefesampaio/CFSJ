<?
require "auth.php"; require "BLL/managerMandataria.class.php"; require "BLL/managerObraSocial.class.php";

$id_mandataria = $_POST["id_mandataria"];
$listado = managerMandataria::getOne(array(
  'key' => 'mandataria',
  'value' => $id_mandataria,
  'extra' => TRUE
  ));

if(!empty($listado)){
  $periodo = managerObraSocial::obtenerPeriodo($listado[0]['obrasocial']);
  ?>
<table align="center" width="100%" border="0" cellspacing="2" cellpadding="2">
  <tbody>
    <tr>
        <td align="right" class="ref">Período:</td>
        <td align="left">
          <input name="periodo" type="text" class="bigInput s200" id="periodo" maxlength="16" value="<?=$periodo;?>" readonly="true" />
        </td>
    </tr>
    <tr>
      <td align="right" class="ref">Listado O.S.:</td>
      <td align='left'>
        <select name="os[]" multiple class="bigInput s200" id="os[]">
          <? foreach ($listado as $os) { ?>
            <option value="<?=$os['obrasocial']?>" selected="selected"><?=$os['denomina']?></option>
          <? } ?>
        </select>
      </td>
    </tr>
    <tr>
      <td align="right" class="ref">Total Recetas:</td>
      <td align="left">
        <input name="total_recetas" type="text" class="bigInput s200" id="total_recetas" value="">
      </td>
    </tr>
    <tr>
      <td width="50%" align="right" class="ref">A cargo O.S.:</td>
      <td width="50%" align="left">
        <input name="total_os" type="text" class="bigInput s200" id="total_os" value="">
      </td>
    </tr>
  </tbody>
</table>
<? } ?>