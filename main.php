<? require_once 'auth.php';
require_once 'BLL/managerMsj.class.php';
require_once 'funciones/functions.php';
require_once 'BLL/managerObraSocial.class.php';
require_once 'BLL/managerCuentaCorriente.class.php';
require_once 'BLL/managerFactura.class.php';
?>
<script type="text/javascript" src="js/right.js"></script>
<script type="text/javascript">$("#mensaje").focus();</script>
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
                                    <div class="ui-widget-header ui-corner-all section-header">Obras Sociales y SUP</div>
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

                                                                </div>  
                                                            </div> 