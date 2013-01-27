<script type="text/javascript" src="js/right.js"></script>
<script type="text/javascript">$("#mensaje").focus();</script>
<?
require "auth.php";
require "BLL/managerMsj.class.php";
require 'funciones/functions.php';
require_once 'BLL/managerObraSocial.class.php';
require_once 'BLL/managerCuentaCorriente.class.php';
require_once 'BLL/managerFactura.class.php';
?>
<div id="loaderDiv" class="hide"></div>
<div class="ui-widget-header ui-corner-all subtit">Dashboard</div>
<div id="main2">  
    <div id="dashboard" class="ui-corner-all">
        <!--  Caratulas - Cuenta - Obras Sociales - Estado de cuenta   -->
        <div class="section">
            <div class="column firstColumn">
                <div class="ui-widget-header ui-corner-all section-header">Informaci&oacute;n de cuenta</div>
                <div class="section-content">
                    <p><strong>Farmacia:</strong>
                        <?= $userAuth->Farmacia->getNombreFantasia()." (".$userAuth->Farmacia->getIdFarmacia().") " ?></p>
                    <p><strong>Director:</strong>
                        <?= $userAuth->Farmacia->getDirectorTecnico()->getNombreYApellido() ?></p>
                    <p><strong>CUIT:</strong>
                        <?= $userAuth->Farmacia->getCuit() ?></p>
                    <p><strong>Domicilio</strong>:
                        <?= $userAuth->Farmacia->getDomicilio() ?></p>
                    <p><strong>Último acceso:</strong>
                        <? $fecha = new DateTime($userAuth->getUltimaVisita());
                        echo $fecha->format("d/m/Y") ?></p>
                </div>
            </div>
            <div class="column">
                <div class="ui-widget-header ui-corner-all section-header">Obras Sociales</div>
                <div class="section-content">
                    <div class="inner-column"> 
                        <p><strong>Abren hoy</strong></p>

                        <?
                        $hoy = new DateTime();
                        $dia = $dia = (int) $hoy->format("d");
                        $listos = managerObraSocial::obtenerPorDiaApertura($dia);
                        echo (count($listos) == 0) ? "<em>Ninguna.</em>" : "";
                        ?>
                        <ul><?
                        foreach ($listos as $os) {
                            echo "<li>" . $os->getDenominacion() . "</li>";
                        }
                        ?></ul></div>
                    <div class="inner-column">                        
                        <p><strong>Cierran hoy</strong></p>
                        <?
                        $listos = managerObraSocial::obtenerPorDiaCierre($dia);
                        echo (count($listos) == 0) ? "<em>Ninguna.</em>" : "";
                        ?>
                        <ul><?
                        foreach ($listos as $os) {
                            echo "<li>" . ucfirst(strtolower($os->getDenominacion())) . "</li>";
                        }
                        ?></ul></div></div>
            </div>

        </div>
        <div class="section">
            <div class="column firstColumn">
                <?
                $recibidas = managerCuentaCorriente::obtenerCantidadRecibidas($userAuth->Farmacia->getIdFarmacia());
                $noPresentadas = managerCuentaCorriente::obtenerCantidadNoPresentadas($userAuth->Farmacia->getIdFarmacia());
                $noLiquidadas = managerCuentaCorriente::obtenerCantidadNoLiquidadas($userAuth->Farmacia->getIdFarmacia());
                $rechazadas = managerCuentaCorriente::obtenerCantidadRechazadas($userAuth->Farmacia->getIdFarmacia());
                ?>
                <div class="ui-widget-header ui-corner-all section-header">Estado de cuenta</div>
<!--                <p>Últimas registradas:</p>-->
                <div class="section-content">
                    <p><strong>Recibidas:</strong>
                        <?= $recibidas ?></p>
                    <p><strong>Sin presentar:</strong>
                        <?= $noPresentadas ?></p>
                    <p><strong>Sin liquidar:</strong>
                        <?= $noLiquidadas ?></p>
                    <p><strong>Rechazadas:</strong>
                        <?= $rechazadas ?></p>             
                </div>
            </div>
            <div class="column">
                <?
                $ultimas = managerFactura::obtenerUltimaFactura($userAuth->Farmacia->getIdFarmacia());
                $pendientes = managerFactura::obtenerCantidadPendientes($userAuth->Farmacia->getIdFarmacia());
                ?>
                <div class="ui-widget-header ui-corner-all section-header">Carátulas</div>
                <div class="section-content">
                    <div class="inner-column"> 
                        <p><strong>Últimos registros</strong></p>
                        <?
                        echo (count($ultimas) == 0) ? "<em>No se realizaron registros aún.</em>" : "";
                        ?>
                        <ul> <?
                        foreach ($ultimas as $u) {
                            echo "<li>" . $u->Plan->getDescripcion() . ": " . $u->getPeriodo() . "</li>";
                        }
                        ?></ul></div>
                    <div class="inner-column"> 
                        <p><strong>Pendientes:</strong>
                            <?= $pendientes ?></p></div>
                </div>
            </div>
        </div>
    </div>
    <div class="clear"></div>


    <?
    if ($userAuth->nivelAdmin->getIdAdmin() > 2) {
        if (isset($_POST["agregar"]) && $_POST["mensaje"] != "") {
            $detalle = preparar(trim(strip_tags($_POST['mensaje'])));
            $detalle = htmlspecialchars($detalle, ENT_QUOTES, "UTF-8");

            $m = new msjAdmin();
            $m->setDetalle($detalle);
            $fecha = date("Y-m-d H:i:s", time());
            $m->setFecha($fecha);
            $m->setUsuario($userAuth);
            managerMsj::insertarMensaje($m);
        }
        ?>
        <div id="msg_add">


            <form action="main" method="post" name="msj" id="msj" class="ajax">
                <textarea name="mensaje" id="mensaje" placeholder="Escribe un mensaje..." class="tablontextarea"></textarea>
                <input type="submit" name="agregar" value="Enviar" class="ui-jQuery here" />
                <input name="agregar" type="hidden" value="agregar" />
            </form>

        </div>
        <div id="msg_cont">
            <?
        }

        if (isset($_GET["s"]) && $_GET['s']) {
            $start = $_GET["s"];
        } else {
            $start = 0;
        }
        $limit = 7;
        $listado = managerMsj::obtenerTodos($start, $limit);
        $numr = count($listado);
        if ($numr > 0) {
            foreach ($listado as $m) {
                $f = new DateTime($m->getFecha());
                echo "<p><div class='msg ui-corner-all'>
                    <div class='txt'>" . $m->getDetalle() . "</div>
                       <div class='info'><strong>Colegio Farmaceútico de San Juan</strong> el " . $f->format("d/m") . " a las " . $f->format("H:i") . "</b></div>
                           </div><p>";
            }
        }

        if ($start >= $limit) {
            $but1 = "<a href='main/" . ($start - $limit) . "' class='ui-jQuery here'>« Anterior</a>";
        }
        if (isset($numr) && $numr == $limit) {
            $but2 = "<a href='main/" . ($start + $limit) . "' class='ui-jQuery here'>Siguiente »</a>";
        }
        echo "<br /><p align='center'>";
        echo (isset($but1)) ? $but1 : "";
        echo (isset($but2)) ? $but2 : "";
        echo "</p>";
        ?>

    </div>  
</div> 