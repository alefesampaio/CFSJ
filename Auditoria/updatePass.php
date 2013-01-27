<? require "auth.php"; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Colegio Farmaceútico de San Juan | Actualizar Contraseña</title>
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
                        $bpass=true;
                        $bpass2=true;
                        $msg = "<li>Debes ingresar una contraseña válida.</li>";
                        } else {
                        $userAuth->setPass(md5($_POST['pass']));
                        ManagerUsuario::modificarPass($userAuth);
                        setcookie("colfasj_pass", $userAuth->getPass(), time()+86400*30);
                        session_regenerate_id();
                        $_SESSION["colfasj_pass"] = $userAuth->getPass();
                        session_write_close();
                        echo "<div class='alert alert-success'>Tu contraseña fue actualizada con éxito.</div>";
                        }
                        }else{
                        $error = true;
                        $bpass=true;
                        $bpass2=true;
                        $msg = "<li>Las nuevas contraseñas no coinciden.</li>";
                        }

                        }else{
                        $error= true;
                        $boldpass=true;
                        $msg = "<li>La contraseña actual es incorrecta.</li>";
                        }

                        }
                        }
                        if((isset($error) && $error) ||!isset($error)) {
                        if(isset($error)&&$error){ echo "<div class='alert alert-error'><ul>$msg</ul></div>";
                        }
                        ?>

                        <form action="" method="post" class="form-horizontal">


                            <div class="control-group">
                                <label class="control-label" for="oldpass">Contraseña actual</label>
                                <div class="controls">
                                    <input name="oldpass" type="password" id="oldpass" <? if (isset($_POST["oldpass"])) { echo "value='".$_POST["oldpass"]."'";
                                    } ?> maxlength="32" class="input-xlarge" autofocus="true" />
                                           <? if (isset($boldpass) && $boldpass) { echo "<span class='requerido'>*</span>";
                                           } ?></div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="pass">Nueva contraseña</label>
                                <div class="controls">
                                    <input name="pass" type="password" id="pass" <? if (isset($_POST["pass"])) { echo "value='".$_POST["pass"]."'"; 	}?> maxlength="32" class="input-xlarge" />
                                    <? if (isset($bpass) && $bpass) { echo "<span class='requerido'>*</span>"; } ?></div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="pass2">Confirmar nueva contraseña</label>
                                <div class="controls">
                                    <input name="pass2" type="password" id="pass2" <? if (isset($_POST["pass2"])) { echo "value='".$_POST["pass2"]."'"; 	}?> maxlength="32" class="input-xlarge" />
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <div class="controls">
                                    <input type="submit" name="editar" value="Actualizar" class="btn btn-primary" />
                                </div>
                            </div>
                            </form> 
                        <? } ?>
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