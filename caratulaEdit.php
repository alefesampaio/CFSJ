<? require 'auth.php'; ?>
<script type="text/javascript" src="js/right.js"></script>
<script type="text/javascript">
$("#usuario").focus();
    $("#cargoEntidad").change(function(){ //, bonificacion:$("#bonificacion").val()
        $.post("calcularNeto.php",{cargoEntidad:$(this).val(), bonificacion:$("#bonificacion").val(), importe:$("#importe").val()}, function(data){$("#neto").attr('value', data);})
        return false;
    });
    </script>
    <?
    require_once 'funciones/functions.php';
    require "BLL/managerFactura.class.php" ?>
    <div id="loaderDiv" class="hide"></div>
    <div class="ui-widget-header ui-corner-all subtit">Carátulas</div>
    <div id="main2">
        <div class="subtit2">Editar</div>
        <?
        if (isset($_POST['editar'])) {
            $error = false;
            if (!$_POST['cantRecetas']) {
                $error = true;

                $bcantRecetas = true;
                $msg = "<li>Debes ingresar la cantidad de recetas.</li>";
            } else {
                if (!is_numeric($_POST["cantRecetas"])) {
                    $error = true;
                    $bcantRecetas = true;
                    $msg = "<li>Debes ingresar sólo números en cantidad de recetas.</li>";
                }
            }
            if (!$_POST['folioDesde']) {
                $error = true;
                $bfolioDesde = true;
                $msg .= "<li>Debes ingresar el número de orden de inicio.</li>";
            } else {
                if (!is_numeric($_POST["folioDesde"])) {
                    $error = true;
                    $bfolioDesde = true;
                    $msg = "<li>Debes ingresar sólo números en número de orden(folio).</li>";
                }
            }
            if (!$_POST['folioHasta']) {
                $error = true;
                $bfolioHasta = true;
                $msg .= "<li>Debes ingresar el número de orden de cierre.</li>";
            } else {
                if (!is_numeric($_POST["folioHasta"])) {
                    $error = true;
                    $bfolioHasta = true;
                    $msg = "<li>Debes ingresar sólo números en número de orden(folio).</li>";
                }
            }
            if (!$_POST['importe']) {
                $error = true;
                $bimporte = true;
                $msg .= "<li>Debes ingresar el importe total.</li>";
            } else {
                if (!is_numeric($_POST["importe"])) {
                    $error = true;
                    $bimporte = true;
                    $msg = "<li>Debes ingresar sólo números en importe.</li>";
                }
            }
            if (!$_POST['cargoEntidad']) {
                $error = true;
                $bcargoEntidad = true;
                $msg .= "<li>Debes ingresar el cargo correspondiente a la entidad (Obra Social).</li>";
            } else {
                if (!is_numeric($_POST["cargoEntidad"])) {
                    $error = true;
                    $bcargoEntidad = true;
                    $msg = "<li>Debes ingresar sólo números en cargo a entidad.</li>";
                }
            }
            if (!$_POST['neto']) {
                $error = true;
                $bneto = true;
                $msg .="<li>Debes ingresar el importe neto a cobrar.</li>";
            } else {
                if (!is_numeric($_POST["neto"])) {
                    $error = true;
                    $bneto = true;
                    $msg .= "<li>Debes ingresar sólo números en importe neto.</li>";
                }
            }


            if (!$error) {

                $caratula = new factura();
                $caratula->setIdFactura($_POST['idCaratula']);
                $caratula->setCantRecetas($_POST['cantRecetas']);
                $caratula->setFolioDesde($_POST['folioDesde']);
                $caratula->setFolioHasta($_POST['folioHasta']);
                $caratula->setOperador(strtoupper($userAuth->getUsuario()));
                $caratula->setArancel($_POST['importe']);
                $caratula->setArancelOS($_POST['cargoEntidad']);
                $caratula->setImporteBonificacion($_POST['neto']);

                echo managerFactura::modificarFactura($caratula);
                echo "<br /><p align='center'><a href='historialCaratulas/listar' class='ui-jQuery here'>« Volver</a></p>";
            }
        }
        if (!isset($error) || (isset($error) && $error)) {
            if (isset($error) && $error) {
                echo "<div class='errorlist'><ul>$msg</ul></div>";
            }
        //if(isset($_GET['id']) && $_GET["id"]!=""){
        //$id = preparar($_GET["id"]);
            if ((isset($_GET['id']) && $_GET["id"] != "") || $_POST['idCaratula']) {
                $id = (isset($_POST['idCaratula'])) ? $_POST["idCaratula"] : $_GET['id'];
                if (managerFactura::obtenerFacturaPorIdBool($id)) {
                    $fdb = managerFactura::obtenerFacturaPorIdObj($id, $userAuth->Farmacia->getIdFarmacia());
                    if ($fdb->getRecibido() == 0) {
                        $f = new DateTime($fdb->getFecha());
                        $array = managerFactura::meses();
                        $mes = $array[$fdb->getMes()];
                        $anio = $fdb->getAnio();
                        $period = $fdb->Unidad->getDetalle() . "-" . $mes . "-" . $anio;
                        ?>

                        <form id="carEdit" name="carEdit" method="post" action="caratulaEdit.php" class="ajax" >

                            <table  align="center" width="100%" border="0" cellspacing="2" cellpadding="2">


                                <tr>
                                    <td align="right" class="ref">Fecha:</td>
                                    <td align="left"><input name="farmacia" type="text" class="bigInput s200" id="farmacia" <? echo "value='" . $f->format("d/m/Y H:i:s") . "'"; ?> maxlength="30" readonly="readonly" /></td>
                                </tr>
                                <tr>
                                    <td width="50%" align="right" class="ref">Obra Social:</td>
                                    <td width="50%" align="left"><input name="obrasocial" type="text" class="bigInput s200" id="obrasocial" readonly="readonly" value="<?= $fdb->Plan->ObraSocial->getDenominacion() ?>" />    </td>
                                </tr>

                                <tr>
                                    <td align="right" class="ref">Plan:</td>
                                    <td align="left"><input name="plan" type="text" class="bigInput s200" id="plan" readonly="readonly" value="<?= $fdb->Plan->getDescripcion() ?>" /></td>
                                </tr>
                                <tr>
                                    <td align="right" class="ref">Período:</td>
                                    <td align="left"><input name="periodo" type="text" class="bigInput s200" id="periodo" maxlength="16" readonly="readonly" value="<?= $period ?>" /></td>
                                </tr>
                                <tr>
                                    <td align="right" class="ref">Folio desde:<? if (isset($bfolioDesde) && $bfolioDesde) {
                                        echo "<span class='requerido'>*</span>";
                                    } ?></td>
                                    <td align="left"><input name="folioDesde" type="text" class="bigInput s200" id="folioDesde" value="<?= $fdb->getFolioDesde() ?>" maxlength="11" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" /></td>
                                </tr>
                                <tr>
                                    <td align="right" class="ref">Folio hasta:<? if (isset($bfolioHasta) && $bfolioHasta) {
                                        echo "<span class='requerido'>*</span>";
                                    } ?></td>
                                    <td align="left"><input name="folioHasta" type="text" class="bigInput s200" id="folioHasta" value="<?= $fdb->getFolioHasta() ?>" maxlength="11" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" /></td>
                                </tr>


                                <tr>
                                    <td align="right" class="ref">Cantidad de recetas:<? if (isset($bcantRecetas) && $bcantRecetas) {
                                        echo "<span class='requerido'>*</span>";
                                    } ?></td>
                                    <td align="left"><input name="cantRecetas" type="text" class="bigInput s200" id="cantRecetas" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" maxlength="11" value="<?= $fdb->getCantRecetas() ?>" /></td>
                                </tr>
                                <tr>
                                    <td align="right" class="ref">Importe Total:<? if (isset($bimporte) && $bimporte) {
                                        echo "<span class='requerido'>*</span>";
                                    } ?></td>

                                    <td align="left"><input name="importe" type="text" class="bigInput s200" id="importe" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" maxlength="16" value="<?= $fdb->getArancel() ?>" /></td>

                                </tr>
                                <? require_once "BLL/managerBonificacion.class.php";
                                $bon = managerBonificacion::obtenerPorId($userAuth->Farmacia->getIdFarmacia(), $fdb->Plan->ObraSocial->getIdObraSocial()); 
                                if(is_null($bon)) $porc = 0;
                                else $porc = round($bon->getPorcentaje()*100)/100;
                                ?>
                                <tr <? if($porc==0) echo "class='hide'"; ?> >
                                    <td align="right" class="ref" >Bonificación:</td>

                                    <td align="left"><input name="bonificacion" type="text"  class="bigInput s200" id="bonificacion"  maxlength="16" value="<?= $porc ?>"  /></td>

                                </tr>
                                <tr>
                                    <td align="right" class="ref">A cargo entidad:<? if (isset($bcargoEntidad) && $bcargoEntidad) {
                                        echo "<span class='requerido'>*</span>";
                                    } ?></td>
                                    <td align="left"><input name="cargoEntidad" type="text" class="bigInput s200" id="cargoEntidad" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" maxlength="16" value="<?= $fdb->getArancelOS() ?>" /></td>

                                </tr>
                                <tr>
                                    <td align="right" class="ref">Neto a cobrar:<? if (isset($bneto) && $bneto) {
                                        echo "<span class='requerido'>*</span>";
                                    } ?></td>
                                    <td align="left"><input name="neto" type="text" class="bigInput s200" id="neto" maxlength="16" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"  value='<?= $fdb->getImporteBonificacion() ?>' /></td>

                                </tr>
                            </table>
                            <p align="center">
                                <a href='historialCaratulas/listar' class='ui-jQuery here'>« Volver</a>
                                <input name="editar" type="submit" value="Editar" class="ui-jQuery"  />
                            </p>        
                            <input name="idCaratula" type="hidden" value="<?= $id ?>" />
                            <input name="editar" type="hidden" value="editar"/>
                        </form>


                        <?
                    } else {
                        echo "<div class='errorlist'>No puedes editar esta carátula, porque ya ha sido recibida.</div>";
                    }
                } else {
                    echo "<div class='errorlist'>La carátula que intentas editar, no existe.</div>";
                }
            }
        }
        ?>
    </div>