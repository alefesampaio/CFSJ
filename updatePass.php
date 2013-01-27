<script type="text/javascript" src="js/right.js"></script>
<script type="text/javascript">$("#oldpass").focus();</script>
<? require "auth.php";  ?>
<div id="loaderDiv" class="hide"></div>
        <div class="ui-widget-header ui-corner-all subtit">Mi cuenta</div>
        <div id="main2">
              <div class="subtit2">Actualizar mi contraseña</div>
<?
     if(isset($_POST['editar'])){
         $error=false;
         if(!$_POST['oldpass']){
             $error = true;
             $boldpass=true;
             $msg = "<li>Debes ingresar tu contraseña actual.</li>";
         }else{
             if(md5($_POST['oldpass'])==$userAuth->getPass()){
             if($_POST['pass']==$_POST['pass2']){
                 if (strlen($_POST["pass"]) < 4 || strlen($_POST["pass"] > 30)) {
                     $error = true;
                     $bpass=true;$bpass2=true;
                     $msg = "<li>Debes ingresar una contraseña válida.</li>";
                 } else { 
                     $userAuth->setPass(md5($_POST['pass']));
                     ManagerUsuario::modificarPass($userAuth);
                     setcookie("colfasj_pass", $userAuth->getPass(), time()+86400*30);
                     session_regenerate_id();
                     $_SESSION["colfasj_pass"] = $userAuth->getPass();
                     session_write_close();
                     echo "<div class='succesList'>Tu contraseña fue actualizada con éxito.</div>";
			}
              }else{
                     $error = true;
                     $bpass=true;$bpass2=true;
                     $msg = "<li>Las nuevas contraseñas no coinciden.</li>";
              }
                 
             }else{
                 $error= true;
                 $boldpass=true;
                 $msg = "<li>La contraseña actual es incorrecta.</li>";
             }
                         
         }
    }  
if((isset($error) &&  $error) || !isset($error)) {
     if(isset($error)&&$error){ echo "<div class='errorlist'><ul>$msg</ul></div>"; } ?>
 
     <form action="updatePass" name="updatePass" id="updatePass" method="post" class="ajax">
         
      
         <table width="100%" border="0" cellspacing="2" cellpadding="2">

  <tr>
    <td width="50%" align="right" class="ref">Contraseña actual:<? if (isset($boldpass) && $boldpass) { echo "<span class='requerido'>*</span>"; } ?></td>
    <td width="50%" align="left"><input name="oldpass" type="password" id="oldpass" <? if (isset($_POST["oldpass"])) { echo "value='".$_POST["oldpass"]."'"; }?> maxlength="32" class="bigInput s200" /></td>
  </tr>
 <tr>
    <td width="50%" align="right" class="ref">Nueva contraseña:<? if (isset($bpass) && $bpass) { echo "<span class='requerido'>*</span>"; } ?></td>
    <td width="50%" align="left"><input name="pass" type="password" id="pass" <? if (isset($_POST["pass"])) { echo "value='".$_POST["pass"]."'"; 	}?> maxlength="32" class="bigInput s200" /></td>
  </tr>
  <tr>
    <td width="50%" align="right" class="ref">Confirmar nueva contraseña:<? if (isset($bpass2) && $bpass2) { echo "<span class='requerido'>*</span>"; } ?></td>
    <td width="50%" align="left"><input name="pass2" type="password" id="pass2" <? if (isset($_POST["pass2"])) { echo "value='".$_POST["pass2"]."'"; 	}?> maxlength="32" class="bigInput s200" /> 
    </td>
  </tr>   
   <tr>
    <td colspan="2" align="center"><input type="submit" name="editar" value="Actualizar" class="ui-jQuery" /></td>
  </tr>                      
</table>
<input name="editar" type="hidden" value="editar">
</form> 
 <? } ?>