<? session_start();

require "BLL/managerUsuario.class.php";
require 'BLL/managerServicio.class.php';

if (isset($_GET["act"]) && $_GET['act'] == "logout") { // Destruye la sesion    
    if (ManagerUsuario::actualizarLoginKey("", $_SESSION["colfasj_id"])) {
        unset($_SESSION["colfasj_id"]);
        unset($_SESSION["colfasj_usuario"]);
        unset($_SESSION["colfasj_pass"]);
        unset($_SESSION["colfasj_key"]);
        unset($_SESSION["matricula"]);
        unset($_SESSION["colfasj_servicio"]);
        if ($_COOKIE["colfasj_key"]) {
            setcookie("colfasj_id", "", time() - 3600);
            setcookie("colfasj_usuario", "", time() - 3600);
            setcookie("colfasj_pass", "", time() - 3600);
            setcookie("colfasj_key", "", time() - 3600);
        }
        header("Location: login");
        exit();
    }
} else {
    $errorForm = false;
    $errorAuth = false;
    if (isset($_SESSION['colfasj_id']) || isset($_COOKIE["colfasj_id"])) {
        if(isset($_SESSION['colfasj_servicio']) || isset($_COOKIE['colfasj_servicio'])){
            $idServicio = (isset($_SESSION['colfasj_servicio'])) ? $_SESSION['colfasj_servicio'] : $_COOKIE['colfasj_servicio'];
            $serv = managerServicio::obtenerPorId($idServicio);
            header("Location: ".$serv->getPath());
            exit();
        }
        
    }
    if (isset($_POST["ingresar"])) {
        if (!$_POST["usuario"] || !$_POST["pass"] || !$_POST["servicio"]) {
            $errorForm = true;
            $msg = "No has completado todos los campos";
        }
        if ($errorForm == false) {
            if (!isset($_SESSION["colfasj_loginattempt"]) || (isset($_SESSION["colfasj_loginattempt"]) && $_SESSION["colfasj_loginattempt"] < 5)) {
                $usuario = trim(strip_tags($_POST['usuario']));
                $servicio = trim(strip_tags($_POST['servicio']));
                $pass = trim(strip_tags($_POST['pass']));
                $u = ManagerUsuario::obtenerAutenticacion($usuario, md5($pass));
                if (is_null($u)) {
                    $errorAuth = true;
                    $msg = "El nombre de usuario y contraseña no concuerdan";
                    if (isset($_SESSION["colfasj_loginattempt"])) {
                        $_SESSION["colfasj_loginattempt"] = $_SESSION["colfasj_loginattempt"] + 1;
                    } else {
                        $_SESSION["colfasj_loginattempt"] = 1;
                    }
                } else {
                    if (!$errorAuth) {
                        $svc = managerServicio::obtenerAutenticacionDeServicio($servicio, $u->getIdUser());
                        if(!$svc){
                            $errorAuth = true;
                            $msg = "No puedes ingresar a este servicio.";
                            if (isset($_SESSION["colfasj_loginattempt"])) {
                                $_SESSION["colfasj_loginattempt"] = $_SESSION["colfasj_loginattempt"] + 1;
                            } else {
                                $_SESSION["colfasj_loginattempt"] = 1;
                            }
                        }else{
                            $s = managerServicio::obtenerPorId($servicio);
                            $iplogin = getenv("REMOTE_ADDR");
                            $today = new Datetime('now', new DateTimeZone('America/Argentina/San_Juan'));
                            $lastvisit = $today->format('Y-m-d H:i:s');
                            $key = md5($iplogin . $u->getUsuario() . time());
                            if (ManagerUsuario::actualizarValores($iplogin, $lastvisit, $key, $u->getIdUser())) {
                            session_regenerate_id();
                            if ($_POST["recordarme"]) {
                                setcookie("colfasj_id", $u->getIdUser(), time() + 86400);
                                setcookie("colfasj_usuario", $u->getUsuario(), time() + 86400);
                                setcookie("colfasj_pass", $u->getPass(), time() + 86400);
                                setcookie("colfasj_key", $key, time() + 86400);
                                setcookie("colfasj_servicio", $servicio, time() + 86400);
                            }
                            $_SESSION["colfasj_id"] = $u->getIdUser();
                            $_SESSION["colfasj_usuario"] = $u->getUsuario();
                            $_SESSION["colfasj_pass"] = $u->getPass();
                            $_SESSION["colfasj_key"] = $key;
                            $_SESSION['colfasj_servicio']= $servicio;
                            session_write_close();
                            header("Location: ".$s->getPath());
                            exit();
                        }                            
                            
                        }
                        
                    }
                }
            } else {
                $errorForm = true;
                $msg = "No puedes ingresar";
            }
        }
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Colegio Farmacéutico | Ingreso</title>
        <link href="css/login.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="css/jquery-ui-1.8.19.custom.css" />
        <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.8.19.custom.min.js"></script>
        <script type="text/javascript"> 
            $(document).ready(function () {
                $( "input:submit, input:button").button();
                $("#usuario").focus();
            })
        </script>
    </head>
    <body>

        <div class="login_wrapper">
            <div class="login_logo">

            </div>
            <div class="login_window">
                <div class="login_box">
                    <!--<h4>Iniciar sesión</h4>-->
                    <form method="post" action="" id="form_login" name="form_login">

                        <fieldset class="login_fieldset">

                            <input name="usuario" type="text" class="login_input" id="usuario"  title="Usuario" placeholder="Usuario"/>

                            <input name="pass" type="password" class="login_input" id="pass" title="Contraseña" placeholder="Contraseña"  />

                            
                            <select name="servicio" id="servicio" class="login_input login_select">
                                <option value="">Selecciona un servicio</option>
                                <option value="1" selected="selected">Administración</option>
                                <option value="2">Salud Pública</option>
                            </select>
                            <input type="submit" id="ingresar" name="ingresar" value="Ingresar" class="login_button" />

<? if (isset($msg)) {
    echo "<span class='error'>$msg</span>";
} ?>

                            <p align="center">
                                <input type="checkbox" id="recordarme" name="recordarme" checked="checked" />
                                <label class="remember">No cerrar sesión</label>
                            </p><p align="center">
                                <a href="passRecovery" class="link">¿Olvidaste tu contraseña?</a>
                            </p>
                        </fieldset>


                    </form>
                </div>

            </div>

        </div>

       
    </body>
</html>