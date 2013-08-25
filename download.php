<? require "auth.php"; require_once 'funciones/functions.php';  ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Colegio Farmacéutico de San Juan | Archivos</title>
    <? include 'head.html'; ?>
</head>
<body>
    <? $ban = $userAuth->Farmacia->getIdFarmacia() != 0; ?>
    <? include 'navbar.php'; ?>

    <div class="container">
        <div class="row row-offcanvas row-offcanvas-right">
            <div class="col-xs-12 col-sm-9">
                <h2>Descarga</h2>
                <hr>
                <table class="table table-striped" id="example">
                    <thead>
                        <tr class="tabletit">
                         <td width="9">Fecha de actualización</td>
                         <td width="9">Nombre</td>
                         <td width="9">Tamaño</td>
                         <td width="73">Descargar</td>
                     </tr></thead><tbody>
                     <?  $path="files/";
                     $dir=dir($path);
                     $array = array();
                     if(file_exists($dir->path)){
                        while ($elemento = $dir->read()){
                            if(!is_dir($elemento)){ $array[]=$elemento; 
                            }
                        }
                    }
                    $dir->close();
                    for ($i = 0; $i < count($array); $i++) {
                        echo "<tr>
                        <td>".date("d/m/Y H:i:s.", filectime($path.$array[$i]))."</td>
                        <td><strong>$array[$i]</strong></td>
                        <td>".obtenerTamanio(filesize($path.$array[$i]))."</td>
                        <td><a href='$path$array[$i]' class='btn btn-primary'><span class='glyphicon glyphicon-cloud-download'></span></a></td>
                        </tr>";
                    }
                    ?>    
                </tbody>
            </table>
        </div>
        <? include 'navmenu.php'; ?>

        <? include 'footer.php'; ?> 
    </div>
</div><!--/.container-->
<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>