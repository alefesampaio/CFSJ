<div class="span2" style="width: 200px; margin-right: -10px">
    <div class="well sidebar-nav">
        <ul class="nav nav-list">
            <li class="nav-header">Sitio</li>
            <li <?= ($page == "") ? "class='active'" : "" ?> ><a href="./">Inicio</a></li>
            <li class="nav-header">Validación</li>
            <li <?= ($page == "validar") ? "class='active'" : "" ?> ><a href="validar">Importar</a></li>
            <? if ($userAuth->nivelAdmin->getIdAdmin() > 2) { ?>
                <li class="divider"></li>
                <li class="nav-header">Movimientos</li>
                <li <?= ($page == "movimientosDrogueria") ? "class='active'" : "" ?> ><a href="movimientosDrogueria">Droguerias</a></li>
                <li <?= ($page == "movimientosFarmacia") ? "class='active'" : "" ?> ><a href="movimientosFarmacia">Farmacias</a></li>
            <? } ?>
        </ul>
    </div>
    <div class="well">
        <address>
            <? $name = ($userAuth->Farmacia->getEsDrogueria()) ? "DROGUERÍA " : "FARMACIA ";
            if ($userAuth->Farmacia->getIdFarmacia() == "9200")
                $name = "" ?>
            <strong><?= $name ?><?= ucfirst($userAuth->Farmacia->getRazonSocial()) ?></strong><br />
            <?= $userAuth->Farmacia->getDomicilio() ?><br>
            <?= $userAuth->Farmacia->getLocalidad() ?>, <?= $userAuth->Farmacia->getCodigoPostal() ?><br>
<?= $userAuth->Farmacia->getCuit() ?><br>
        </address>
    </div>
    <!--/span-->
</div>

