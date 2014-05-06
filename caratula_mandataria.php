<? require_once "auth.php"; ?>
<script type="text/javascript" src="js/mandataria.js"></script>
<script type="text/javascript" src="js/right.js"></script>
<div class="ui-widget-header ui-corner-all subtit">Carátulas</div>
<div id="main2">
    <?
    require_once 'BLL/managerFactura.class.php';
    require_once 'BLL/managerPlan.class.php';
    require_once 'funciones/functions.php';
    require_once 'BLL/managerObraSocial.class.php';
    require_once 'BLL/managerMandataria.class.php';
    a:
    if (isset($_SESSION['matricula']) and !empty($_SESSION['matricula'])) {

        if (isset($_POST["enviar"])) {

            $error = false;
            if (!isset($_POST['mandataria'])) {
                $error = true;
                $bmandataria = true;
                $msg = "<li>Debes seleccionar una Mandataria.</li>";
            }
            if (!isset($_SESSION['quincena']) or !isset($_SESSION['mes']) or !isset($_SESSION['anio'])) {
                $error = true;
                $bperiodo = true;
                $msg .= "<li>El periodo es requerido.</li>";
            } else {
                if (managerFactura::validarMandataria(
                        $userAuth->Farmacia->getIdFarmacia(),
                        $_POST['mandataria'],
                        $_SESSION['quincena'],
                        $_SESSION['mes'],
                        $_SESSION['anio'])) {
                        $error = true;
                        $bperiodo = true;
                }
                if (isset($bperiodo) && $bperiodo)
                    $msg = "<li>El período que intentas registrar, ya ha sido registrado.</li>";
            }

            foreach ($_POST as $key => $value) {
                if ($value == "") {
                    $msgerror = true;
                }
            }
            if (isset($msgerror) && $msgerror) {
                $error = true;
                (isset($msg)) ? $msg .= "" : $msg = "<li>Debes completar todos los campos.</li>";
            }
            if (!$error) {
                $os_mandataria = managerMandataria::getOne(array(
                    'key' => 'mandataria',
                    'value' => $_POST['mandataria'],
                    'extra' => TRUE
                ));
                $fechaActual = new DateTime();
                $array = meses();
                if ($_SESSION['quincena'] != 3) {
                    $periodo = $_SESSION['quincena'] . "° quincena de " . $array[$_SESSION['mes']] . " de " . $_SESSION['anio'];
                } else {
                    $periodo = "Mes de " . $array[$_SESSION['mes']] . " de " . $_SESSION['anio'];
                }
                $recetas = $_POST['total_recetas'];
                $total_os = $_POST['total_os'];
                $farmacia = managerFarmacias::obtenerFarmaciaPorIdObj($userAuth->Farmacia->getIdFarmacia());
                $last = $farmacia->getContadorBarra() + 1;
                $farmacia->setContadorBarra($last);
                $codPlanes = 000;
                $codigoBarra = managerFactura::generarCodigoBarra(
                    $userAuth->Farmacia->getIdFarmacia(),
                    $_POST['obraSocial'],
                    $codPlanes,
                    $_SESSION['quincena'],
                    $_SESSION['mes'],
                    $_SESSION['anio'],
                    $last,
                    '7',
                    $_POST['mandataria']
                    );
                $params = array(
                    'origen' => "'".strtoupper("on-line")."'",
                    'operador' => "'".strtoupper($userAuth->getUsuario())."'",
                    'recetas' => $_POST['total_recetas'],
                    'arancel_os' => $_POST['total_os'],
                    'farmacia' => $userAuth->Farmacia->getIdFarmacia(),
                    'nombre' => "'".$userAuth->Farmacia->getNombreFantasia()."'",
                    'mandataria' => $_POST['mandataria'],
                    'quincena' => $_SESSION['quincena'],
                    'mes' => $_SESSION['mes'],
                    'anio' => $_SESSION['anio'],
                    'barra' => $codigoBarra,
                    'fecha' => "'".$fechaActual->format("Y-m-d H:i:s")."'"
                    );
                echo managerFactura::generarTMandataria($params, $last);
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
                        </table>
                    </div>
                </div>
                <br />
                <div class="linea"></div>
                <br />
                <table class="preliminar"  align="center" width="70%"  cellspacing="0" cellpadding="0" border="1">
                    <tr>
                        <td align="left" class="subtit4">Fecha de Proceso:</td>
                        <td class="data4" align="left"><? echo date("d/m/Y H:i"); ?></td>
                    </tr>
                    <tr>
                        <td align="left" class="subtit4">Período:</td>
                        <td  class="data4" align="left"><? echo $periodo; ?></td>
                    </tr>
                    <tr>
                        <td width="50%" align="left" class="subtit4">Sistema Único de Prestaciones (SUP):</td>
                        <td width="50%"  class="data4" align="left"><? echo $os_mandataria[0]['detalle']; ?>
                        </td>
                    </tr>
                </table>
                <br />
                <table width="70%" border="1" align="center" cellpadding="0" cellspacing="0" class="preliminar">
                    <tr>
                        <td class="subtit4">Obras Sociales:</td>
                    </tr>
                    <?
                    foreach ($os_mandataria as $os) {
                        echo "<tr> <td class='data4'>" . $os['denomina'] . "</td> </tr>";
                    } ?>
                </table>
                <br />
                <table width="70%" border="1" align="center" cellpadding="0" cellspacing="0" class="preliminar">
                    <tr>
                        <td align="center" class="subtit4">Total de recetas:</td>
                        <td align="center" class="subtit4">A cargo de entidades:</td>
                    </tr>
                    <tr>
                        <td align="center"  class="data4"><?=$recetas?></td>
                        <td align="center"  class="data4">$<?=$total_os?></td>
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
    if (!isset($error) or (isset($error) and $error)) { ?>
        <div class="subtit2">Agregar</div>
        <?
        if ((isset($error) && $error) && isset($msg)) {
            echo "<div class='errorlist'><ul>$msg</ul></div>";
        }
        ?>
            <form id="carAdd" name="carAdd" method="post" class="ajax"  action="caratula_mandataria.php" >

                <table  align="center" width="100%" border="0" cellspacing="2" cellpadding="2">
                    <tr>
                        <td align="right" class="ref">Fecha:</td>
                        <td align="left">
                            <input name="fecha" type="text" class="bigInput s200" id="fecha" <? echo "value='" . date("d/m/Y") . "'"; ?> maxlength="30" readonly="readonly" />
                        </td>
                    </tr>
                    <tr>
                        <td width="50%" align="right" class="ref">Mandataria:<? if (isset($bmandataria) && $bmandataria) {echo "<span class='requerido'>*</span>"; } ?>
                        </td>
                        <td width="50%" align="left">
                            <select title="Mandataria" name="mandataria" id="mandataria" class="bigSelect big" >
                                <option value='' selected='selected'>Seleccionar</option>
                                <?
                                require_once 'BLL/managerMandataria.class.php';
                                $los = managerMandataria::obtenerTodos();
                                foreach ($los as $os) {
                                    echo "<option value='". $os['codigo'] . "'>" . $os['detalle'] . "</option>";
                                }
                                ?>
                            </select></td>
                    </tr>
                </table>

                <div class="separador"></div>
        <? if (isset($_POST['grillaPlanes'])) {
            echo stripslashes($_POST['grillaPlanes']);
        } else { ?>
                    <div id="grid" ></div> <? } ?>
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
            <form action="caratula_mandataria.php" method="post" name="dt_mat" id="dt_mat" class="ajax">
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