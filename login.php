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
} else { //creamos la sesion despues de comprobar
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
                            $lastvisit = date(Y . "-" . m . "-" . d, time());
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
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Colegio Farmacéutico | Ingreso</title>
    <meta charset="utf-8">    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/login.css" rel="stylesheet" media="screen">
    <link rel="shortcut icon" href="favicon.png">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">

      <form class="form-signin" name="form_login" method="post">

        <h4 class="form-signin-heading">Colegio Farmacéutico de San Juan</h4>

        <input name="usuario" type="text" class="form-control" placeholder="Usuario" autofocus/>

        <input name="pass" type="password" class="form-control" placeholder="Password" />
        <input name="servicio" type="hidden" value="1" id="servicio" />

        <label class="checkbox">
          <input type="checkbox" value="remember-me" id="recordarme" name="recordarme" checked="checked"> No cerrar sesión
      </label>
      <button class="btn btn-lg btn btn-success btn-block" type="submit" name="ingresar">Ingresar</button>
      <? if (isset($msg)) { ?> <div class="alert text-danger"><?=$msg?></div> <? } ?>
      <p class="alert text-center"><a href="passRecovery.php" class="">¿Olvidaste tu contraseña?</a></p>

  </form>
</div>
<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>