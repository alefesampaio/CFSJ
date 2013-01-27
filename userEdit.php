<script type="text/javascript" src="js/right.js"></script>
<script type="text/javascript">$("#usuario").focus();</script>
<? 
require "auth.php"; 
?>
<div id="loaderDiv" class="hide"></div>
        <div class="ui-widget-header ui-corner-all subtit">Usuarios</div>
            
         <div id="main2">
              <div class="subtit2">Editar</div>
<?
    if(isset($_POST['editar']))
    {
        $error = false;
        require 'funciones/functions.php';
            if (!isset($_POST["usuario"]) || $_POST['usuario']==""  ) {
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
		
		
                if($_POST['admin']==""){
                    $nivelAdmin = 1;
                }else if($_POST["admin"]>$userAuth->nivelAdmin->getIdAdmin()) {
                    $error = true;
                    $badmin = true;
                    $msg .= "<li>Debes elegir un nivel de administrador menor o igual al tuyo.</li>";
                    
                    }else {
                       $nivelAdmin = $_POST['admin'];
                    }
		if($_POST['farmacia']==""){
                    $error = true;
                    $bfarmacia = true;
                    $msg .= "<li>Debes seleccionar una farmacia.</li>";
                }                      
                  if(!isset($_POST["fechanac"])){
			$error= true;
			$bfechanac= true;
			$msg .= "<li>Debes ingresar tu fecha de nacimiento.</li>";
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
                    $n = new nivelAdmin();
                    $n->setIdAdmin($_POST['admin']);
                    $u->setNivelAdmin($n);
                    $u->setEmail(preparar($_POST['email']));
                    $u->setSexo(preparar($_POST['sexo']));
                    $u->setFechaNac(preparar($_POST['fechanac']));
                    $f = new farmacia();
                    $f->setIdFarmacia(preparar($_POST['farmacia']));
                    $u->setFarmacia($f);
                    
            
               // Agrega a la base de datos                                                              
            if(ManagerUsuario::modificarUsuario($u)){
            echo "<div class='succesList'>La cuenta se ha modificado con éxito.</div>"; 
            echo "<br /><p align='center'><a href='userList' class='ui-jQuery here'>« Volver</a>";
           }else { echo "<div class='errorlist'>La operación no se pudo realizar.</div>";  }
       }
    }
     
    if (!isset($error) || $error == true) { 
                if((isset($error) && $error) && isset($msg)){ echo "<div class='errorlist'><ul>$msg</ul></div>"; }
                
    if((isset($_GET['id']) && $_GET["id"]!="") || $_POST['idUsuario']){
            $id = (isset($_POST['idUsuario'])) ? $_POST["idUsuario"] : $_GET['id'];
            if(ManagerUsuario::obtenerUsuarioPorIdBool($id)){
                    $userDb = ManagerUsuario::obtenerUsuarioPorIdObj($id);
                    
                    ?>
        <form action="userEdit" name="userEdit" id="userEdit" method="post" class="ajax">
         
      
         <table width="100%" border="0" cellspacing="2" cellpadding="2">
         <tr>
  
        <td width="50%" align="right" class="ref">Nro. de usuario:</td>
        <td width="50%" align="left"><? echo $userDb->getIdUser(); ?></td>
  </tr>
  <tr>
    <td width="50%" align="right" class="ref">Farmacia:<? if (isset($bfarmacia) && $bfarmacia) { echo "<span class='requerido'>*</span>"; } ?></td>
    <td width="50%" align="left"><select name="farmacia" id="farmacia" class="big bigSelect">
    <?   
        foreach (managerFarmacias::obtenerTodos() as $f ) {
                $sel = ($userDb->Farmacia->getIdFarmacia() == $f->getIdFarmacia()) ? "selected='selected'" : "";
                echo "<option value='".$f->getIdFarmacia()."' $sel>".$f->getRazonSocial()."</option>";  } ?>
    </select></td>
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
  	<td width="50%" align="right" class="ref">Rol:</td>
    <td width="50%" align="left"><select name="admin" class="big bigSelect" id="admin" >
    <?       foreach (managerNivelAdmin::obtenerTodos() as $n) {
                $sel = ($userDb->nivelAdmin->getIdAdmin() == $n->getIdAdmin()) ? "selected='selected'" : "";
                if($n->getIdAdmin()<=$userAuth->nivelAdmin->getIdAdmin()){
                echo "<option value='".$n->getIdAdmin()."' $sel>".$n->getDescripcion()."</option>";             }
         }
    ?></select></td>
  </tr>
  <tr>
    <td width="50%" align="right" class="ref">Sexo:</td>
    <td width="50%" align="left"><label><input type="radio" name="sexo" id="sexo" value="m" checked="checked" /> M </label> 
        <label><input type="radio" name="sexo" value="f" <? if ((isset($_POST['sexo']) && $_POST["sexo"]=="f") || ($userDb->getSexo()=="f")) { echo "checked='checked'"; } ?> /> F </label></td>
  </tr>                        
</table>
<br />
<p align='center'><a href='userList' class='ui-jQuery here'>« Volver</a><input type="submit" name="editar" value="Editar" class="ui-jQuery" />
</p>
<input type="hidden" name="idUsuario" value="<? echo $userDb->getIdUser();  ?>" />
<input type="hidden" name="editar" value="editar">
</form> 
<? }else { echo "<div class=errorlist>El usuario que intentas editar no existe.</div>"; }
}
}
?>
</div>
 