<? session_start();
header("Content-Type: text/html; charset=utf-8");
//ini_set ( "include_path",  $_SERVER['DOCUMENT_ROOT']."/cfsj/admin/" );
ini_set ( "include_path",  "/home3/colfa/public_html/admin/" );

require_once "BLL/managerUsuario.class.php";
require_once "BLL/managerFarmacias.class.php";
require_once "BLL/managerNivelAdmin.class.php";
require_once "BLL/managerServicio.class.php";

if ((!isset($_SESSION['colfasj_id']) || $_SESSION['colfasj_id'] == "") && (!$_COOKIE["colfasj_key"] || $_COOKIE["colfasj_key"] == "")) {
    header("Location: ../login.php?act=logout");
    exit();
} else {
    if (isset($_COOKIE["colfasj_key"])) {
        $_SESSION["colfasj_id"] = $_COOKIE['colfasj_id'];
        $_SESSION["colfasj_usuario"] = $_COOKIE['colfasj_usuario'];
        $_SESSION["colfasj_pass"] = $_COOKIE['colfasj_pass'];
        $_SESSION["colfasj_key"] = $_COOKIE['colfasj_key'];
        $_SESSION["colfasj_servicio"] = $_COOKIE['colfasj_servicio'];
    }
    $usuario = $_SESSION['colfasj_usuario'];
    $pass = $_SESSION['colfasj_pass'];
    $userid = $_SESSION['colfasj_id'];
    $key = $_SESSION['colfasj_key'];
    $servicio = $_SESSION['colfasj_servicio'];

    if (ManagerUsuario::obtenerUsuarioPorIdBool($userid)) {
        $userAuth = ManagerUsuario::obtenerUsuarioPorIdObj($userid);
        if (($pass != $userAuth->getPass())||($userAuth->getLoginKey() != $key) || ($userAuth->nivelAdmin->getIdAdmin() == 0 )) {
            header("Location: ../login.php?act=logout");
            exit();
        }
        if(!managerServicio::obtenerAutenticacionDeServicio($servicio, $userid) || $servicio!=2){
        header("Location: ../login.php?act=logout");
        exit();
    }
    }
    
}
$url = $_SERVER['REQUEST_URI'];
$split = explode("/", $url);
$page = end($split);
?>