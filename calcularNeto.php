<? require "auth.php";
if(isset($_POST['cargoEntidad'])) $cargo = floatval ($_POST['cargoEntidad']);
if(isset($_POST['importe'])) $total = floatval ($_POST["importe"]);
if(isset($_POST['bonificacion'])) $cargo = $cargo-(($total*floatval($_REQUEST['bonificacion']))/100);
echo round($cargo*100)/100;
?>