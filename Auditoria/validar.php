<? require "auth.php"; require_once 'BLL/managerVentaDrogueria.class.php';require_once 'BLL/managerVentaFarmacia.class.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Colegio Farmaceútico de San Juan | Actualizar Contraseña</title>
        <? include 'head.html'; ?>
    <body>

        <? include 'navbar.php' ?>

        <div class="container-fluid">
            <div class="row-fluid  content">
                <? include 'navmenu.php'; ?>
                <div class="span10">
                    <div class="row-fluid">
                        <div class="page-header">
                            <h3>Validación de Medicamentos</h3>
                        </div>   
                        <div class="alert alert_info">A continuación, selecciona el archivo de carga masiva. Recuerda que debe ser un archivo con formato XML.
                            <a href='' class='close' data-dismiss='alert'>×</a></div>
                        <?
                        if (isset($_POST["subir"])) {
                            $error = false;
                            //file extension verification
                            $fe = explode(".", $_FILES['archivo']['name']);
                            $ext = end($fe);
                            if ($ext != "xml") {
                                $error = true;
                                $msg = "El archivo tiene un formato no válido.";
                            }
                            //@todo file size verification
//                        if ($_FILES["archivo"]["size"] > 307200) {
//                        $error = true;
//                        $barchivo = true;
//                        $msg = "El tamaño máximo del archivo es de 300 KB.";
//                        }

                            if (!$error) {
                                if (move_uploaded_file($_FILES["archivo"]["tmp_name"], "files/" . $_FILES['archivo']['name'])) {
                                    $xml = simplexml_load_file("files/" . $_FILES['archivo']['name']);
                                    $count = 0;
                                    if ($userAuth->Farmacia->getEsDrogueria()) {
                                        $data = array();
                                        require_once 'Business/ventaDrogueria.class.php';
                                        foreach ($xml->children() as $child) {
                                            
                                                $venta = new ventaDrogueria();
                                                $venta->setFarmacia($child->farmacia);
                                                $venta->setCantidad($child->cantidad);
                                                $venta->setFecha($child->fecha_venta);
                                                $venta->setFechaVencimiento($child->vto);
                                                $venta->setDrogueria($child->drogueria);
                                                $venta->setManual($child->registro);
                                                $venta->setNroFactura($child->factura_numero);
                                                $venta->setNroLote($child->partida_lote);
                                                $flag = managerVentaDrogueria::insertar($venta);
                                                $count++;
                                        }
                                        if($flag) echo "<div class='alert alert-success'>Se importaron $count registros de forma exitosa.<a href='' class='close' data-dismiss='alert'>×</a></div>";
                                        else echo "<div class='alert alert-error'>Lo sentimos, la operación no se pudo completar.<a href='' class='close' data-dismiss='alert'>×</a></div>";
                                    }else if(!$userAuth->Farmacia->getEsDrogueria()){
                                        $data = array();
                                        require_once 'Business/ventaFarmacia.class.php';
                                        foreach ($xml->children() as $child) {
                                            
                                                $venta = new ventaFarmacia();
                                                $venta->setFarmacia($child->farmacia);
                                                $venta->setManual($child->registro);
                                                $venta->setFecha($child->fecha);
                                                $venta->setDni($child->cliente_dni);
                                                $venta->setCantidad($child->cantidad);
                                                $venta->setNombreApellido($child->apellido);
                                                $venta->setObraSocial($child->obra_social);
                                                $venta->setMatriculaMedico($child->matricula_medico);
                                                $venta->setNroRecetario($child->recetario_nro);
                                                $flag = managerVentaFarmacia::insertar($venta);
                                                $count++;
                                        }
                                        if($flag) echo "<div class='alert alert-success'>Se importaron $count registros de forma exitosa.<a href='' class='close' data-dismiss='alert'>×</a></div>";
                                        else echo "<div class='alert alert-error'>Lo sentimos, la operación no se pudo completar.<a href='' class='close' data-dismiss='alert'>×</a></div>";
                                    }
                                    echo "<div class='alert alert-info'><strong>" . ucfirst($xml->getName()) . "</strong><br /><hr>";
                                    $data = array();
                                    foreach ($xml->children() as $child) {
                                        //echo $child->farmacia;
                                        foreach ($child->children() as $rechild) {
                                            //$ventaDrogueria = new 
                                            echo "<strong>" . $rechild->getName() . ":</strong> " . $rechild . "<br />";
                                        }
                                        echo "<hr>";
                                    }
                                    echo "</div>";
                                } else {
                                    $error = true;
                                    $barchivo = true;
                                    $msg = "Lo sentimos, ocurrió un error durante el proceso. Por favor, intenta nuevamente.";
                                }
                            }
                        } if ((isset($error) && $error) || !isset($error)) {
                            if (isset($error) && $error) {
                                echo "<div class='alert alert-error'>$msg<a href='' class='close' data-dismiss='alert'>×</a></div>";
                            }
                            ?>
                            <form action="" method="post" class="form-horizontal" enctype="multipart/form-data" >
                                <div class="control-group">
                                    <label class="control-label" for="file">Archivo XML</label>
                                    <div class="controls">
                                        <input name="archivo" type="file" id="archivo" class="input-xlarge" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="controls">
                                        <input type="submit" name="subir" value="Subir" class="btn btn-primary" />
                                    </div>
                                </div>
                            </form>
<? } ?>
                    </div>

                </div><!--/span-->
            </div><!--/row-->
            <hr>
<? include 'footer.php'; ?>
        </div>
        <div id="XPLSS_Flyover" style="position: absolute; z-index: 10002; visibility: hidden; left: -2100px; top: -2100px; ">
        </div>
        <div id="XPLSS_Trans" style="position: absolute; z-index: 10000; visibility: hidden; left: -2100px; top: -2100px; "></div><embed type="application/avg-searchshield-plugin" hidden="yes" id="avgss-plugin">
    </body>
</html>