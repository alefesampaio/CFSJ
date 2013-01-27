<? require "auth.php"; //ini_set("display_errors", 1);   ?>
<script type="text/javascript" src="js/jquery.jqprint-0.3.js"></script>
<script type="text/javascript" src="js/caratula.js"></script>
<script type="text/javascript" src="js/right.js"></script>
<div id="loaderDiv" class="hide"></div>
<div class="ui-widget-header ui-corner-all subtit">Carátulas</div>
<div id="main2">
    <?
    require 'BLL/managerFactura.class.php';
    require 'BLL/managerPlan.class.php';
    require 'funciones/functions.php';
    a:
    if (isset($_SESSION['matricula']) && $_SESSION['matricula'] != "") {

        if (isset($_POST["enviar"])) {

            $error = false;
            //verifico los campos		
            if (!$_POST['obraSocial']) {
                $error = true;
                $bobraSocial = true;
                $msg = "<li>Debes seleccionar una Obra Social.</li>";
            }
            if (!$_POST['plan']) {
                $error = true;
                $bplan = true;
                $msg .= "<li>Debes seleccionar un plan.</li>";
            }

            if (!isset($_SESSION['quincena']) || !isset($_SESSION['mes']) || !isset($_SESSION['anio'])) {
                $error = true;
                $bperiodo = true;
                $msg .= "<li>Debes seleccionar el período correspondiente.</li>";
            } else {   //Comprobamos si el periodo ya fue registrado.
                if (managerFactura::validarPeriodo($userAuth->Farmacia->getIdFarmacia(), $_POST['plan'], $_SESSION['quincena'], $_SESSION['mes'], $_SESSION['anio'])) {
                    $error = true;
                    $bperiodo = true;
                    $msg .= "<li>El período que intentas registrar, ya ha sido registrado.</li>";
                }
            }
            if (!$_POST['cantRecetas']) {
                $error = true;
                $bcantRecetas = true;
                $msg .= "<li>Debes ingresar la cantidad de recetas.</li>";
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
            //Si todo está ok
            if ($error != true) {

                $origen = strtoupper("on-line");

                //variables a utilizar en la vista preliminar

                $farmacia = managerFarmacias::obtenerFarmaciaPorIdObj($userAuth->Farmacia->getIdFarmacia());
                $last = $farmacia->getContadorBarra() + 1;
                $codigoBarra = managerFactura::generarCodigoBarra($userAuth->Farmacia->getIdFarmacia(), $_POST['obraSocial'], $_POST['plan'], $_SESSION['quincena'], $_SESSION['mes'], $_SESSION['anio'], $last);
                //$obraSocial = managerObraSocial::obtenerOSPorId($_POST['obraSocial']);
                $fechaActual = new DateTime();
                $array = meses();

                $plan = managerPlan::obtenerPlanPorId($_POST['plan']);


                $folioDesde = $_POST["folioDesde"];
                $folioHasta = $_POST["folioHasta"];
                if ($_SESSION['quincena'] != 3) {
                    $periodo = $_SESSION['quincena'] . "° quincena de " . $array[$_SESSION['mes']] . " de " . $_SESSION['anio'];
                } else {
                    $periodo = "Mes de " . $array[$_SESSION['mes']] . " de " . $_SESSION['anio'];
                }

                $cantRecetas = $_POST["cantRecetas"];
                $importe = $_POST["importe"];
                $cargoEntidad = $_POST["cargoEntidad"];
                $bonificacion = isset($_POST['bonificacion']) ? $_POST['bonificacion'] : 0;
                $neto = $_POST['neto'];
                $caratula = new factura();
                $farmacia->setContadorBarra($last);
                $caratula->setFarmacia($farmacia);
                $caratula->setOrigen($origen);
                require_once 'Business/unidad.class.php';
                $unid = new unidad();
                $unid->setIdUnidad($_SESSION['quincena']);
                $caratula->setUnidad($unid);
                $caratula->setAnio($_SESSION['anio']);
                $caratula->setMes($_SESSION['mes']);
                $caratula->setCantRecetas($cantRecetas);
                $caratula->setFecha($fechaActual->format("Y-m-d H:i:s"));
                $caratula->setFolioDesde($folioDesde);
                $caratula->setFolioHasta($folioHasta);
                $caratula->setPlan($plan);
                $caratula->setOperador(strtoupper($userAuth->getUsuario()));
                $caratula->setCodigoBarra($codigoBarra);
                $caratula->setArancel($importe);
                $caratula->setArancelOS($cargoEntidad);
                $caratula->setImporteBonificacion($neto);
                $caratula->setPorcentajeBonificacion($bonificacion);
                //$caratula->setAgrupado(0);


                echo managerFactura::generarTCaratula($caratula);
                ?>

                <div class="imprimir"><input name="lnkPrint" id="lnkPrint" class="ui-jQuery" type="button" value="Imprimir" /></div>

                <div id="encabezado">
                    <img align="left" src="images/logo_menu.png" alt="Colegio Farmacéutico de San Juan" />
                    <div id="farmInfo">
                        <table width="100%" border="1" cellspacing="0" cellpadding="0">
                            <tr>
                                <td class="subtit4">Farmacia:</td>
                                <td class="data4" align="left"><? echo $userAuth->Farmacia->getNombreFantasia() . " - " . $userAuth->Farmacia->getIdFarmacia(); ?></td>
                            </tr>
                            <tr>
                                <td class="subtit4">CUIT:</td>
                                <td class="data4" align="left"><? echo $userAuth->Farmacia->getCuit(); ?></td>
                            </tr>
                            <tr>
                                <td class="subtit4">Domicilio:</td>
                                <td class="data4" align="left"><? echo $userAuth->Farmacia->getDomicilio(); ?></td>
                            </tr>
                            <tr>
                                <td class="subtit4">Director:</td>
                                <td class="data4" align="left"><? echo $userAuth->Farmacia->getDirectorTecnico()->getNombreYApellido(); ?></td>
                            </tr>
                        </table></div></div>


                <br />
                <div class="linea"></div>
                <br />
                <table class="preliminar"  align="center" width="70%"  cellspacing="0" cellpadding="0" border="1">
                    <tr>
                        <td class="subtit4">Fecha de Proceso:</td>
                        <td class="data4" align="left"><? echo date("d/m/Y H:i"); ?></td>
                    </tr>
                    <tr>
                        <td class="subtit4">Período:</td>
                        <td  class="data4" align="left"><? echo $periodo; ?></td>
                    </tr>
                    <tr>
                        <td width="50%" class="subtit4">Obra Social:</td>
                        <td width="50%"  class="data4" align="left"><? echo $plan->ObraSocial->getDenominacion(); ?>
                        </td>
                    </tr>

                    <tr>
                        <td class="subtit4">Plan:</td>
                        <td  class="data4" align="left"><? echo $plan->getDescripcion(); ?></td>
                    </tr>
                    <tr>
                        <td class="subtit4">Folio desde:</td>
                        <td  class="data4" align="left"><? echo $folioDesde; ?></td>
                    </tr>
                    <tr>
                        <td class="subtit4">Folio hasta:</td>
                        <td  class="data4" align="left"><? echo $folioHasta; ?></td>
                    </tr>



                </table>
                <br />
                <br />
                <!--<div class="separador"></div>
                -->
                <table width="70%" border="1" align="center" cellpadding="0" cellspacing="0" class="preliminar">
                    <tr>
                        <td align="center" class="subtit4">Cantidad de recetas:</td>
                        <td align="center" class="subtit4">Importe Total:</td>
                        <td align="center" class="subtit4">A cargo entidad:</td>
            <? if ($bonificacion != 0)
                echo "<td align='center' class='subtit4'>Porcentaje de bonificacion:</td>"; ?>
                        <td align="center" class="subtit4">Neto a cobrar:</td>
                    </tr>
                    <tr>

                        <td align="center"  class="data4"><? echo $cantRecetas; ?></td>
                        <td align="center"  class="data4">$<? echo $importe; ?></td>
                        <td align="center"  class="data4">$<? echo $cargoEntidad; ?></td>
                        <?
                        if ($bonificacion != 0) {
                            echo "<td align='center' class='subtit4'>%$bonificacion</td>";
                        }
                        ?>

                        <td align="center" class="subtit4">$<? echo $neto; ?></td>
                    </tr>
                </table>
                <br	 /><br	 />
                <div class="subtit3">Confirmación de lote</div>    

                <br />

                <div class="separador2"></div>



                <table width="100%" border="0" cellspacing="2" cellpadding="2">
                    <tr>
                        <td width="33%" align="center" class="subtit4"><span>Sello</span></td>
                        <td width="33%" align="center" class="subtit4"><span>Firma</span></td>
                        <td width="34%" align="center" class="subtit4"><span>Aclaración</span></td>
                    </tr>
                </table>
                <br />
                <br />
                <!--Vista preliminar de la caratula-->

                <table align="center" width="70%" border="0" cellspacing="0" cellpadding="0">

                    <tr>



                        <td align="right" width="72%"><div class="codigoBarra"><img src="codigoBarra.php?NUM=<? echo $codigoBarra ?>&amp;TYP=Code128&amp;IMG=png" /></div></td>
                    </tr>
                </table>
                <br /><?
        }
    }
    if (!isset($error) || (isset($error) && $error)) {
                    ?><div class="subtit2">Agregar</div>
            <?
            if ((isset($error) && $error) && isset($msg)) {
                echo "<div class='errorlist'><ul>$msg</ul></div>";
            }
            ?>

            <form id="carAdd" name="carAdd" method="post" class="ajax"  action="caratula.php" >

                <table  align="center" width="100%" border="0" cellspacing="2" cellpadding="2">
                    <tr>
                        <td align="right" class="ref">Fecha:</td>
                        <td align="left"><input name="farmacia" type="text" class="bigInput s200" id="farmacia" <? echo "value='" . date("d/m/Y") . "'"; ?> maxlength="30" readonly="readonly" /></td>
                    </tr>
                    <tr>
                        <td width="50%" align="right" class="ref">Obra Social:<?
            if (isset($bobraSocial) && $bobraSocial) {
                echo "<span class='requerido'>*</span>";
            }
            ?></td>
                        <td width="50%" align="left"><select title="Obra Social" name="obraSocial" id="obraSocial" class="bigSelect big" ><option value='' selected='selected'>Seleccionar</option>
                                <?
                                require_once 'BLL/managerObraSocial.class.php';
                                $los = managerObraSocial::obtenerTodos();
                                $hoy = new DateTime();
                                foreach ($los as $os) {
                                    $dia = (int) $hoy->format("d");
                                    if ($os->getAgrupaCaratula() == 0) {
                                        if ($dia >= $os->getInicio1() && $dia <= $os->getCierre1()) {
                                            echo "<option value='" . $os->getIdObraSocial() . "'>" . $os->getDenominacion() . "</option>";
                                        } else if ($dia >= $os->getInicio2() && $dia <= $os->getCierre2()) {
                                            echo "<option value='" . $os->getIdObraSocial() . "'>" . $os->getDenominacion() . "</option>";
                                        } else if ($os->getCierre2()<$os->getInicio2()) {
                                            $cierre2= (int) $os->getCierre2()+30;
                                            $diaHoy = ($dia<=$os->getCierre2()) ? (int) $dia+30 : $dia ;
                                            if($diaHoy >= $os->getInicio2() && $diaHoy <= $cierre2){
                                                echo "<option value='" . $os->getIdObraSocial() . "'>" . $os->getDenominacion() . "</option>";
                                            }                                            
                                        }else if($os->getCierre2()>$os->getInicio2()){
                                            if($dia >= $os->getInicio2() && $dia <= $os->getCierre2()){
                                                echo "<option value='" . $os->getIdObraSocial() . "'>" . $os->getDenominacion() . "</option>";
                                            }
                                            
                                        }
                                    }
                                } 
                                ?>
                            </select></td>
                    </tr>

                    <tr>
                        <td align="right" class="ref">Plan:<?
                                if (isset($bplan) && $bplan) {
                                    echo "<span class='requerido'>*</span>";
                                }
                                ?></td>
                        <td align="left"><select name="plan" id="plan" size="1" class="bigSelect big"><option value="">Seleccionar</option></select><span id="loader"></span></td>
                    </tr>

                    <tr>
                        <td align="right" class="ref">Período:</td>
                        <td align="left"><input name="periodo" type="text" class="bigInput s200" id="periodo" maxlength="16" readonly="readonly" value="" /></td>
                    </tr>
                    <tr>
                        <td align="right" class="ref">Folio desde:<?
                                if (isset($bfolioDesde) && $bfolioDesde) {
                                    echo "<span class='requerido'>*</span>";
                                }
                                ?></td>
                        <td align="left"><input name="folioDesde" type="text" class="bigInput s200" id="folioDesde" <? if (isset($_POST["folioDesde"]))
                        echo "value='" . $_POST["folioDesde"] . "'"; ?> maxlength="11" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"  /></td>
                    </tr>
                    <tr>
                        <td align="right" class="ref">Folio hasta:<?
                                        if (isset($bfolioHasta) && $bfolioHasta) {
                                            echo "<span class='requerido'>*</span>";
                                        }
                                ?></td>
                        <td align="left"><input name="folioHasta" type="text" class="bigInput s200" id="folioHasta" <?
                    if (isset($_POST["folioHasta"]))
                        echo "value='" . $_POST["folioHasta"] . "'"; else
                        echo "value=''";
                    ?> maxlength="11" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" /></td>
                    </tr>


                    <tr>
                        <td align="right" class="ref">Cantidad de recetas:<?
                    if (isset($bcantRecetas) && $bcantRecetas) {
                        echo "<span class='requerido'>*</span>";
                    }
                    ?></td>
                        <td align="left"><input name="cantRecetas" type="text" class="bigInput s200" id="cantRecetas" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" maxlength="11" <?
                    if (isset($_POST["cantRecetas"])) {
                        echo "value='" . $_POST["cantRecetas"] . "'";
                    }
                                ?> /></td>
                    </tr>
                    <tr>
                        <td align="right" class="ref">Importe Total:<?
                    if (isset($bimporte) && $bimporte) {
                        echo "<span class='requerido'>*</span>";
                    }
                    ?></td>

                        <td align="left"><input name="importe" type="text" class="bigInput s200" id="importe" maxlength="16" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" <?
                    if (isset($_POST["importe"])) {
                        echo "value='" . $_POST["importe"] . "'";
                    }
                                ?>/></td>

                    </tr>
                    <tr class="hide">
                        <td align="right" class="ref" >Bonificación:<?
                    if (isset($bbon) && $bbon) {
                        echo "<span class='requerido'>*</span>";
                    }
                    ?></td>

                        <td align="left"><input name="bonificacion" type="text"  class="bigInput s200" id="bonificacion"  maxlength="16" <?
                    if (isset($_POST["bonificacion"])) {
                        echo "value='" . $_POST["bonificacion"] . "'";
                    }
                    ?>/></td>

                    </tr>

                    <tr>
                        <td align="right" class="ref">A cargo O.S.:<?
                    if (isset($bcargoEntidad) && $bcargoEntidad) {
                        echo "<span class='requerido'>*</span>";
                    }
                    ?></td>
                        <td align="left"><input name="cargoEntidad" type="text" class="bigInput s200" id="cargoEntidad" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" maxlength="16" <?
                    if (isset($_POST["cargoEntidad"])) {
                        echo "value='" . $_POST["cargoEntidad"] . "'";
                    }
                                ?>/></td>

                    </tr>
                    <tr>
                        <td align="right" class="ref">Neto a cobrar:<?
        if (isset($bneto) && $bneto) {
            echo "<span class='requerido'>*</span>";
        }
                                ?></td>
                        <td align="left"><input name="neto" type="text" class="bigInput s200" id="neto" maxlength="16" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"  <?
        if (isset($_POST["neto"])) {
            echo "value='" . $_POST["neto"] . "'";
        }
                                ?>/></td>

                    </tr>
                </table>

                <div class="separador"></div>

                <div align="center">
                    <input name="enviar" type="hidden" value="enviar" />
                    <input name="idFar" id="idFar" type="hidden" value="<?= $userAuth->getFarmacia()->getIdFarmacia() ?>" />
                    <input name="enviar" id="enviar" class="ui-jQuery" type="submit" value="Confirmar" />
                </div>
            </form>
            <script type="text/javascript">$("#obraSocial").focus();</script>    
            <?
        }//fin if($error ==false)
    } else {


        if (isset($_POST['siguiente'])) {
            $errorMat = false;

            if (!$_POST['matricula']) {
                $errorMat = true;
                $msj = "<li>Debes ingresar la matrícula correspondiente al Director Ténico de turno.</li>";
            } else {
                $checkMat = strlen($_POST["matricula"]);
                if ($checkMat < 3) {
                    $errorMat = true;
                    $msj .= "<li>Debes ingresar una matrícula válida.</li>";
                } else if ($checkMat > 16) {
                    $errorMat = true;
                    $msj .= "<li>Debes ingresar una matrícula válida.</li>";
                } else if (!preg_match("/^[a-zA-Z0-9_]+$/i", $_POST["matricula"])) {
                    $errorMat = true;
                    $msj .= "<li>La matrícula contiene caracteres no válidos.</li>";
                } else {
                    if (!get_magic_quotes_gpc()) { //comprueba que magic_quotes_gpc este en 1 en .ini
                        $_POST['matricula'] = addslashes($_POST['matricula']);
                    }
                    if (!managerFarmacias::esMatriculaVigente($_POST['matricula'], $userAuth->Farmacia->getIdFarmacia())) {
                        $errorMat = true;
                        $msj .= "<li>La matrícula ingresada no coinicide.</li>";
                    } else {
                        $_SESSION['matricula'] = $_POST['matricula'];
                        goto a;
                    }
                }
            }
        }

        if ((isset($errorMat) && $errorMat) || !isset($errorMat)) {
            if (isset($errorMat) && $errorMat) {
                echo "<div class='errorlist'><ul>$msj</ul></div>";
            }
            ?>
            <form action="caratula.php" method="post" name="dt_mat" id="dt_mat" class="ajax">
                <table width="100%" cellpadding="2" cellspacing="2" border="0">
                    <tr>
                        <td width="50%" align="right" class="ref">Matrícula DT:</td>
                        <td width="50%" align="left"><input type="text" name="matricula" id="matricula" class="bigInput s200" /></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><input type="submit" name="siguiente" value="Siguiente" class="ui-jQuery" /></td>
                    </tr>
                </table>
                <input name="siguiente" type="hidden" value="siguiente" />
            </form>
            <script type="text/javascript">$("#matricula").focus();</script>
        <?
    }
}
?>
</div>