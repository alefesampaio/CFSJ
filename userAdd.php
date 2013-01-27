<script type="text/javascript" src="js/right.js"></script>
<script type="text/javascript">$("#farmacia").focus();</script>
<? require "auth.php"; ?>
<div id="loaderDiv" class="hide"></div>
<div class="ui-widget-header ui-corner-all subtit">Usuarios</div>

<div id="main2">
    <div class="subtit2">Agregar Usuario</div>
    <?
    if (isset($_POST['guardar'])) {
        $error = false;
        require 'funciones/functions.php';
        if (!isset($_POST["usuario"]) || $_POST['usuario'] == "") {
            $error = true;
            $busuario = true;
            $msg = "<li>Debes ingresar un nombre de usuario.</li>";
        } else {
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
                if (!get_magic_quotes_gpc()) { //comprueba que magic_quotes_gpc este en 1 en .ini
                    $_POST['usuario'] = addslashes($_POST['usuario']);
                }// Comprueba si el nombre de usuario existe
                $usercheck = strtolower($_POST['usuario']);
                if (ManagerUsuario::obtenerUsuarioPorUser($usercheck)) {
                    $error = true;
                    $busuario = true;
                    $msg .= "<li>El nombre de usuario ya existe, elige uno nuevo.</li>";
                }
            }
        }
        if ($_POST["password"] == "") {
            $error = true;
            $bpass = true;
            $msg .= "<li>Debes ingresar una contraseña.</li>";
        } else {
            $checkpass = strlen($_POST["password"]);
            if ($checkpass < 4) {
                $error = true;
                $bpass = true;
                $msg .= "<li>La contraseña es demasiado corta (4 caracteres mín).</li>";
            } else if ($checkpass > 32) {
                $error = true;
                $bpass = true;
                $msg .= "<li>La contraseña es demasido larga (32 caracteres máx).</li>";
            } else {
                // Comprueba contraseña
                if ($_POST['password'] != $_POST['password2']) {
                    $error = true;
                    $bpass = true;
                    $msg .= "<li>Las contraseñas no concuerdan.</li>";
                }
            }
        }
        if ($_POST['admin'] == "") {
            $nivelAdmin = 1;
        } else if ($_POST["admin"] > $userAuth->nivelAdmin->getIdAdmin()) {
            $error = true;
            $badmin = true;
            $msg .= "<li>Debes elegir un nivel de administrador menor o igual al tuyo.</li>";
        } else {
            $nivelAdmin = $_POST['admin'];
        }
        if ($_POST['farmacia'] == "") {
            $error = true;
            $bfarmacia = true;
            $msg .= "<li>Debes seleccionar una farmacia.</li>";
        }

        if (isset($_POST['fechanac'])) {
            //$fechanac = new DateTime($_POST['fechanac']);
        }
        if (!isset($_POST["email"])) {
            $error = true;
            $bemail = true;
            $msg .= "<li>Debes ingresar tu dirección de email.</li>";
        } else {
            if (validEmail($_POST["email"])) {
                $e = $_POST['email'];
                /* if (ManagerUsuario::obtenerUsuarioPorEmail($e)) {
                  $error = true;
                  $bemail = true;
                  $msg .= "<li>La dirección de email ya ha sido registrada, elige una nueva.</li>";
                  } */
            } else {
                $error = true;
                $bemail = true;
                $msg .= "Debes ingresar una dirección de email válida.";
            }
        }


        if ($error == false) {
            //Creamos el objeto
            $u = new Usuario();
            $u->setUsuario(preparar($_POST['usuario']));
            $u->setPass(md5(preparar($_POST['password'])));
            $n = new nivelAdmin();
            $n->setIdAdmin($nivelAdmin);
            $u->setNivelAdmin($n);
            $u->setEmail(preparar($_POST['email']));
            $u->setSexo(preparar($_POST['sexo']));
            $u->setFechaNac(preparar($_POST['fechanac']));
            $u->setFechaReg(date("Y-m-d", time()));
            $f = new farmacia();
            $f->setIdFarmacia(preparar($_POST['farmacia']));
            $u->setFarmacia($f);
            $u->setIpReg(getenv("REMOTE_ADDR"));
            $u->setActivo("si");

            // Agrega a la base de datos                                                              
            if (ManagerUsuario::insertarUsuario($u)) {
                echo "<div class='succesList'>La cuenta se ha creado con éxito.</div>";
            } else {
                echo "<div class='errorlist'>La operación no se pudo realizar.</div>";
            }
        }
    }
    if (!isset($error) || $error == true) {
        if ((isset($error) && $error) && isset($msg)) {
            echo "<div class='errorlist'><ul>$msg</ul></div>";
        }
        ?>

        <form action="userAdd" method="post" id="userAdd" name="userAdd" class="ajax">

            <table width="100%" border="0" cellspacing="2" cellpadding="2">
                <tr>
                    <td width="50%" align="right" class="ref">Farmacia:<? if (isset($bfarmacia) && $bfarmacia) {
        echo "<span class='requerido'>*</span>";
    } ?></td>
                    <td width="50%" align="left"><select title="Obligatorio si el usuario a crear es para una farmacia!" name="farmacia" id="farmacia"  class="bigSelect big" >
                            <option value="" selected="selected">Seleccionar</option>
                            <option value="-">Ninguna</option>            
                            <? foreach (managerFarmacias::obtenerTodos() as $f) {
                                echo "<option value='" . $f->getIdFarmacia() . "'>" . $f->getRazonSocial() . "</option>";
                            } ?>
                        </select></td>
                </tr> 
                <tr>
                    <td width="50%" align="right" class="ref">Usuario:<? if (isset($busuario) && $busuario) {
                            echo "<span class='requerido'>*</span>";
                        } ?></td>
                    <td width="50%" align="left"><input type="text" name="usuario" maxlength="16" id="usuario" class="bigInput s200" <? if (isset($_POST['usuario']))
                            echo "value='" . $_POST["usuario"] . "'"; ?> /></td>
                </tr>
                <tr>
                    <td width="50%" align="right" class="ref">Contraseña:<? if (isset($bpass) && $bpass) {
                            echo "<span class='requerido'>*</span>";
                        } ?></td>
                    <td width="50%" align="left"><input type="password" maxlength="32" name="password" id="password" class="bigInput s200"  <? if (isset($_POST['password']))
                            echo "value='" . $_POST["password"] . "'"; ?> /></td>
                </tr>
                <tr>
                    <td width="50%" align="right" class="ref">Confirma contraseña:<? if (isset($bpass2) && $bpass2) {
                            echo "<span class='requerido'>*</span>";
                        } ?></td>
                    <td width="50%" align="left"><input type="password" maxlength="32" name="password2" id="password2" class="bigInput s200"  <? if (isset($_POST['password2']))
                            echo "value='" . $_POST["password2"] . "'"; ?> /></td>
                </tr>
                <tr>
                    <td width="50%" align="right" class="ref">Email:<? if (isset($bemail) && $bemail) {
                            echo "<span class='requerido'>*</span>";
                        } ?></td>
                    <td width="50%" align="left"><input type="text" name="email" maxlength="64" id="email" class="bigInput s200"  <? if (isset($_POST['email']))
                            echo "value='" . $_POST["email"] . "'"; ?> /></td>
                </tr>
                <tr>
                    <td width="50%" align="right" class="ref">Fecha de nacimiento:</td>
                    <td width="50%" align="left"><input type="text" maxlength="10" name="fechanac" id="fechanac" class="bigInput s200" value="<? if (isset($_POST["fechanac"]))
                            echo $_POST["fechanac"] ?>" placeholder="____/__/__" /></td>
                </tr>
    <? if ($userAuth->nivelAdmin->getIdAdmin() > 2) { ?>
                    <tr>
                        <td width="50%" align="right" class="ref">Rol:</td>
                        <td width="50%" align="left"><select class="bigSelect big" title="" name="admin" id="admin" >
                                <option value="" selected="selected">Seleccionar</option>    
        <?
        foreach (managerNivelAdmin::obtenerTodos() as $n) {
            if ($n->getIdAdmin() <= $userAuth->nivelAdmin->getIdAdmin()) {
                echo "<option value='" . $n->getIdAdmin() . "'>" . $n->getDescripcion() . "</option>";
            }
        }
        ?> </select></td>
                    </tr><? } ?>
                <tr>
                    <td width="50%" align="right" class="ref">Sexo:</td>
                    <td width="50%" align="left"><label><input type="radio" name="sexo" id="sexo" value="m" checked="checked" /> M </label> 
                        <label><input type="radio" name="sexo" value="f" <? if (isset($_POST['sexo']) && $_POST["sexo"] == "f") {
        echo "checked='checked'";
    } ?> /> F </label></td>
                </tr>   
                <tr>
                    <td colspan="2" align="center"><input type="submit" name="guardar" value="Guardar" class="ui-jQuery" /></td>
                </tr>
            </table>
            <input type="hidden" value="guardar" name="guardar" />
        </form>
<? } ?>
</div>
