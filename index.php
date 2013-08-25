<? 
require "auth.php";
require_once 'BLL/managerObraSocial.class.php';
require_once 'BLL/managerCuentaCorriente.class.php';
require_once 'BLL/managerFactura.class.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Colegio Farmacéutico de San Juan | Panel de administración</title>
    <? include 'head.html'; ?>
</head>
<body>
    <? $ban = $userAuth->Farmacia->getIdFarmacia() != 0; ?>
    <? include 'navbar.php'; ?>

    <div class="container">

        <div class="row row-offcanvas row-offcanvas-right">
            <div class="col-xs-12 col-sm-9">
              <p class="pull-right visible-xs">
                <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
            </p>
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-info main-panel">
                      <div class="panel-heading">
                        <h3 class="panel-title">Información de cuenta</h3>
                    </div>
                    <div class="panel-body">
                        <p><strong>Farmacia:</strong> <?= $userAuth->Farmacia->getNombreFantasia()." (".$userAuth->Farmacia->getIdFarmacia().") " ?> </p>
                        <p><strong>Director:</strong> <?= $userAuth->Farmacia->getDirectorTecnico()->getNombreYApellido() ?></p>
                        <p><strong>CUIT:</strong> <?= $userAuth->Farmacia->getCuit() ?></p>
                        <p><strong>Domicilio:</strong> <?= $userAuth->Farmacia->getDomicilio() ?></p>
                        <p><strong>Último acceso:</strong> <? $fecha = new DateTime($userAuth->getUltimaVisita()); echo $fecha->format("d/m/Y") ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-info main-panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Obras Sociales</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
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
                                ?></ul>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Cierran hoy</strong></p>
                                <? 
                                $listos = managerObraSocial::obtenerPorDiaCierre($dia);
                                echo (count($listos) == 0) ? "<em>Ninguna.</em>" : ""; ?>
                                <ul><? foreach ($listos as $os) { echo "<li>" . ucfirst(strtolower($os->getDenominacion())) . "</li>"; } ?></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-info main-panel">
                    <div class="panel-heading"><h3 class="panel-title">Estado de cuenta</h3></div>
                    <div class="panel-body">
                        <?
                        $recibidas = managerCuentaCorriente::obtenerCantidadRecibidas($userAuth->Farmacia->getIdFarmacia());
                        $noPresentadas = managerCuentaCorriente::obtenerCantidadNoPresentadas($userAuth->Farmacia->getIdFarmacia());
                        $noLiquidadas = managerCuentaCorriente::obtenerCantidadNoLiquidadas($userAuth->Farmacia->getIdFarmacia());
                        $rechazadas = managerCuentaCorriente::obtenerCantidadRechazadas($userAuth->Farmacia->getIdFarmacia());
                        ?>
                        <p><strong>Recibidas:</strong> <?= $recibidas ?></p>
                        <p><strong>Sin presentar:</strong> <?= $noPresentadas ?></p>
                        <p><strong>Sin liquidar:</strong> <?= $noLiquidadas ?></p>
                        <p><strong>Rechazadas:</strong> <?= $rechazadas ?></p> 
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-info main-panel">
                  <div class="panel-heading">
                    <h3 class="panel-title">Carátulas</h3>
                </div>
                <div class="panel-body">
                    <?
                    $ultimas = managerFactura::obtenerUltimaFactura($userAuth->Farmacia->getIdFarmacia());
                    $pendientes = managerFactura::obtenerCantidadPendientes($userAuth->Farmacia->getIdFarmacia());
                    ?>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Últimos registros</strong></p>
                            <?
                            echo (count($ultimas) == 0) ? "<em>No se realizaron registros aún.</em>" : "";
                            ?>
                            <ul> <?
                            foreach ($ultimas as $u) {
                                echo "<li>" . $u->Plan->getDescripcion() . ": " . $u->getPeriodo() . "</li>";
                            }
                            ?></ul>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Pendientes:</strong>
                                <?= $pendientes ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <? include 'navmenu.php'; ?>

    <? include 'footer.php'; ?>
</div>

</div><!--/.container-->
<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  $('[data-toggle=offcanvas]').click(function() {
    $('.row-offcanvas').toggleClass('active');
});
});
</script>
</body>
</html>
