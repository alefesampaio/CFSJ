<?php
// Conectar Base de Datos
require_once('db.class.php');
//$db = new db_mysql("cfarmaceuticosj.no-ip.org", "root", "cydonia", "taller");
$db = new db_mysql("localhost", "root", "", "colegio");
$db->query("SET NAMES 'utf8'");
$db->query("SET CHARACTER_SET utf8");
?>
