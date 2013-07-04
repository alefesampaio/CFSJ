<? require "auth.php"; require_once 'funciones/functions.php';  ?>
<script type="text/javascript" src="js/right.js"></script>
<div id="loaderDiv" class="hide"></div>
<div class="ui-widget-header ui-corner-all subtit">Mis archivos</div>
<div id="main2">
	<div class="subtit2">Subir</div>       
	<?
	if(isset($_POST["subir"])) {
		$error= false;
		if(!$error){
			if(move_uploaded_file($_FILES["archivo"]["tmp_name"], "files/".$_FILES['archivo']['name'])) {
				echo "<div class='succesList'>El archivo fue subido con éxito.</div>";
			} else {
				$error = true;
				$barchivo=true;
				$msg = "El archivo no pudo ser subido. Por favor, intenta nuevamente.";
			}
		}
		
	} if ((isset($error) && $error) || !isset($error)) {
		if(isset($error) && $error){ echo "<div class='errorlist'><ul>$msg</ul></div>"; } ?>            
		<form action="upload" method="post" enctype="multipart/form-data" name="uploadFile" class="ajax" >  
			<table width="100%" border="0" cellspacing="2" cellpadding="2">

				<tr>
					<td width="50%" align="right" class="ref">Archivo:<? if(isset($barchivo) && $barchivo) echo "<span class='requerido'>*</span>"; ?></td>
					<td width="50%" align="left"><input type="file" name="archivo" id="archivo" /></td>
				</tr>   
				<tr>
					<td colspan="2" align="center"><input type="submit" name="subir" value="Subir" class="ui-jQuery" /></td>
				</tr>
				<input type="hidden" name="subir" value="subir" />                      	
			</table>
		</form>
		<? } ?>
	</div>