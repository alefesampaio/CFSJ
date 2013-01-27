<script type="text/javascript" src="js/right.js"></script>
<script type="text/javascript">$("#usuario").focus();</script>
<? 
require "auth.php"; 
?>
<div id="loaderDiv" class="hide"></div>
        <div class="ui-widget-header ui-corner-all subtit">Mi cuenta</div>
            
         <div id="main2">
         <div class="subtit2">Mi perfil</div>
<?
    if(isset($_POST['editar']))
    {
        $error = false;
        require 'funciones/functions.php';
            if (!isset($_POST["usuario"]) || $_POST['usuario']=="" ) {
			$error = true;
			$busuario = true;
			$msg = "<li>Debes ingresar un nombre de usuario.</li>";
		 
		 }else {
		 		$checkuser = strlen($_POST["usuario"]);
			if ($checkuser < 4) {
				$error = true;
				$busuario = true;
				$msg = "<li>El nombre de usuario es demasiado corto(4 caracteres mínimo).</li>";
			} else if ($checkuser > 16) {
				$error = true;
				$busuario = true;
				$msg .= "<li>El nombre de usuario es muy largo(16 caracteres máx).</li>";
			} else if (!preg_match("/^[a-zA-Z0-9_]+$/i", $_POST["usuario"])) {
				$error = true;
				$busuario = true;
				$msg .= "<li>El nombre de usuario contiene caracteres no válidos (sólo letras, números y guión bajo permitidos).</li>";
			} else {
				if (!get_magic_quotes_gpc()) {
					$_POST['usuario'] = addslashes($_POST['usuario']);
				}// Comprueba si el nombre de usuario existe
				
			}
		}	
                if (!isset($_POST["email"])) {
            $error = true;
			$bemail = true;
            $msg .= "<li>Debes ingresar tu dirección de email.</li>";
		} else {
			if (!validEmail($_POST["email"])) { 
                		$error = true;
				$bemail = true;
				$msg .= "Debes ingresar una dirección de email válida.";
			}
		}
        
       if(!$error){
           //Creamos el objeto
                    $u = new Usuario();
                    $u->setIdUser($_POST['idUsuario']);
                    $u->setUsuario(preparar($_POST['usuario']));
                    $u->setEmail(preparar($_POST['email']));
                    $u->setSexo(preparar($_POST['sexo']));
                    $u->setFechaNac(preparar($_POST['fechanac']));
                    
                    
            
               // Agrega a la base de datos                                                              
            if(ManagerUsuario::modificarUsuario2($u)){
            echo "<div class='succesList'>La cuenta se ha modificado con éxito.</div>";  
           }else { echo "<div class='errorlist'>La operación no se pudo realizar.</div>";  }
    }
    }
    if (!isset($error) || $error) { 
                if(isset($error) && $error){ echo "<div class='errorlist'><ul>$msg</ul></div>"; }
                
    if($userAuth!=null){
            
            $userDb = $userAuth;
                    
                    ?>
        <form action="perfil" name="perfil" id="perfil" method="post" class="ajax">
         
      
         <table width="100%" border="0" cellspacing="2" cellpadding="2">
         <tr>
  
        <td width="50%" align="right" class="ref">Nro. de usuario:</td>
        <td width="50%" align="left"><? echo $userDb->getIdUser(); ?></td>
  </tr>
  
  
  <tr>
    <td width="50%" align="right" class="ref">Usuario:<? if (isset($busuario) && $busuario) { echo "<span class='requerido'>*</span>"; } ?></td>
    <td width="50%" align="left"><input type="text" name="usuario" maxlength="16" id="usuario" class="bigInput s200"  <? echo (isset($_POST['usuario'])) ? "value='".$_POST["usuario"]."'" : "value='".$userDb->getUsuario()."'"; ?> /></td>
  </tr>
  <tr>
    <td width="50%" align="right" class="ref">Email:<? if (isset($bemail) && $bemail) { echo "<span class='requerido'>*</span>"; } ?></td>
    <td width="50%" align="left"><input type="text" name="email" maxlength="64" id="email" class="bigInput s200"  <? echo (isset($_POST['email'])) ? "value='".$_POST["email"]."'" : "value='".$userDb->getEmail()."'"; ?> /></td>
  </tr>
 <tr>
    <td width="50%" align="right" class="ref">Fecha de nacimiento:</td>
    <td width="50%" align="left"><input type="text" maxlength="10" name="fechanac" id="fechanac" class="bigInput s200" <? echo (isset($_POST["fechanac"])) ? "value='".$_POST["fechanac"]."'" : "value='".$userDb->getFechaNac()."'" ;  ?> placeholder="____/__/__" /></td>
  </tr>
  <tr>
    <td width="50%" align="right" class="ref">Sexo:</td>
    <td width="50%" align="left"><label><input type="radio" name="sexo" id="sexo" value="m" checked="checked" /> M </label> 
        <label><input type="radio" name="sexo" value="f" <? if ((isset($_POST['sexo']) && $_POST["sexo"]=="f") || ($userDb->getSexo()=="f")) { echo "checked='checked'"; } ?> /> F </label></td>
  </tr>   
  <tr>
    <td colspan="2" align="center"><input type="submit" name="editar" value="Actualizar" class="ui-jQuery" /></td>
  </tr>
                      
</table>
<input type="hidden" name="idUsuario" value="<? echo $userDb->getIdUser();  ?>" />
<input name="editar" type="hidden" value="editar">
</form> 
<? }else { echo "<div class=errorlist>No has iniciado sesión.</div>"; }
} ?>
</div>
 