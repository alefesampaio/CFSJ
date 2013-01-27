<? require "auth.php"; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Colegio Farmaceútico de San Juan | Mi perfil</title>
        <? include 'head.html'; ?>
        <style>
            .hero-unit {
                padding: 0 30px;
                background: #FFF;
            }
            
        </style>
    <body>

        <? include 'navbar.php' ?>

        <div class="container-fluid">
            <div class="row-fluid content">
                <? include 'navmenu.php'; ?>
                <div class="span10">
                    <div class="hero-unit">
                        <div class="page-header">
                            <h3>Mi Cuenta</h3>
                        </div>
                        <!--form-->
                        <?
                        if (isset($_POST['editar'])) {
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

                            if (!$error) {
                                //Creamos el objeto
                                $u = new Usuario();
                                $u->setIdUser($_POST['idUsuario']);
                                $u->setUsuario(preparar($_POST['usuario']));
                                $u->setEmail(preparar($_POST['email']));
                                $u->setSexo(preparar($_POST['sexo']));
                                $u->setFechaNac(preparar($_POST['fechanac']));



                                // Agrega a la base de datos                                                              
                                if (ManagerUsuario::modificarUsuario2($u)) {
                                    echo "<div class='alert alert-success'>La cuenta se ha modificado con éxito.<a href='' class='close' data-dismiss='alert'>×</a></div>";
                                } else {
                                    echo "<div class='alert alert-error'>La operación no se pudo realizar.<a href='' class='close' data-dismiss='alert'>×</a></div>";
                                }
                            }
                        }
                        if (!isset($error) || $error) {
                            if (isset($error) && $error) {
                                if (isset($msg))
                                    echo "<div class='alert alert-error'><ul>$msg</ul><a href='' class='close' data-dismiss='alert'>×</a></div>";
                            }

                            if ($userAuth != null) {

                                $userDb = $userAuth;
                                ?>
                                <form action="" method="post" class="form-horizontal">
                                    <div class="control-group">
                                        <label class="control-label" for="usuario">Usuario</label>
                                        <div class="controls">
                                            <input type="text" name="usuario" class="input-xlarge" maxlength="16" id="usuario" <? echo (isset($_POST['usuario'])) ? "value='" . $_POST["usuario"] . "'" : "value='" . $userDb->getUsuario() . "'"; ?> autofocus="true" />
                                            <?
                                            if (isset($busuario) && $busuario) {
                                                echo "<span class='requerido'>*</span>";
                                            }
                                            ?></div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="email">Email</label>
                                        <div class="controls">
                                            <input type="text" name="email" class="input-xlarge"  maxlength="64" id="email" <? echo (isset($_POST['email'])) ? "value='" . $_POST["email"] . "'" : "value='" . $userDb->getEmail() . "'"; ?> />
                                            <?
                                            if (isset($bemail) && $bemail) {
                                                echo "<span class='requerido'>*</span>";
                                            }
                                            ?></div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="fechanac">Fecha de nacimiento</label>
                                        <div class="controls">
                                            <input type="text" maxlength="10" class="input-xlarge"  name="fechanac" id="fechanac" <? echo (isset($_POST["fechanac"])) ? "value='" . $_POST["fechanac"] . "'" : "value='" . $userDb->getFechaNac() . "'"; ?> placeholder="____/__/__" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="sexo">Sexo</label>
                                        <div class="controls">
                                            <label class="radio inline">
                                                <input type="radio" name="sexo" id="sexo" value="m" checked="checked" />
                                                M
                                            </label>
                                            <label class="radio inline">
                                                <input type="radio" name="sexo" value="f" <?
                                    if ((isset($_POST['sexo']) && $_POST["sexo"] == "f") || ($userDb->getSexo() == "f")) {
                                        echo "checked='checked'";
                                    }
                                            ?> />
                                                F
                                            </label>                                            
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <input type="submit" name="editar" value="Actualizar" class="btn btn-primary" />
                                        </div>
                                    </div>
                                    <input type="hidden" name="idUsuario" value="<? echo $userDb->getIdUser(); ?>" />
                                    <input name="editar" type="hidden" value="editar">
                                </form> 
                                <?
                            } else {
                                echo "<div class='alert alert-error'>No has iniciado sesión.<a href='' class='close' data-dismiss='alert'>×</a></div>";
                            }
                        }
                        ?>
                    </div>
                    <div class="row-fluid">
                    </div><!--/row-->
                </div><!--/span-->
            </div><!--/row-->
            <hr>
            <? include 'footer.php'; ?>
        </div><!--/.fluid-container-->

        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->

        <div id="XPLSS_Flyover" style="position: absolute; z-index: 10002; visibility: hidden; left: -2100px; top: -2100px; ">
        </div>
        <div id="XPLSS_Trans" style="position: absolute; z-index: 10000; visibility: hidden; left: -2100px; top: -2100px; "></div><embed type="application/avg-searchshield-plugin" hidden="yes" id="avgss-plugin">
    </body>
</html>
