<? require "auth.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Colegio Farmacéutico de San Juan | Panel de administración</title>
    <link rel="stylesheet" href="css/admin2.css" />
    <link rel="stylesheet" href="css/jquery-ui-1.8.19.custom.css" />
    <link rel="stylesheet" href="css/demo_table_jui.css" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.19/jquery-ui.min.js"></script>        
    <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/jquery.jqprint-0.3.js"></script>
</head>
<body>
    <? $ban = $userAuth->Farmacia->getIdFarmacia() != 0; ?>
    <div id="header">
        <div class="header-text">Colegio Farmacéutico de San Juan</div>
        <div class="welcome">
            <span class="note" id="account_info">Bienvenido, <a href="#" title="Bienvenido"><?= ucfirst($userAuth->getUsuario()) ?></a></span>
            <a class="ui-jQuery btn right" href="updatePass">
                Cambiar contraseña
            </a>
            <a class="ui-jQuery btn right" href="perfil">
                Mi Perfil
            </a>
            <a class="ui-jQuery btn" href="login.php?act=logout">
                Salir
            </a>
        </div>
    </div>
    <!--Begin Contenido -->
    <div id="right">
    <div id="loaderDiv" class="hide"></div>    
        <div id='loaderDiv'></div>
    </div>
    <!-- End Contenido -->
    <div id="menu" >
        <div style="width:100%;  border: none;" class="ui-widget-content" >
            <div id="accordion">
                <h3><a href="#">Sitio</a></h3>
                <div> 
                    <ul id="menu1">
                        <li><a href="main" >Inicio</a></li>
                        <!-- <li><a href="estadisticas" >Estadísticas</a></li> -->
                    </ul>
                </div>
                <h3><a href="#">Mis archivos</a></h3>
                <div>
                    <ul id="menu5">
                        <li><a href="download.php">Descargar</a></li>
                        <? if ($userAuth->nivelAdmin->getIdAdmin() > 3)
                        echo "<li><a href='upload.php'>Subir</a></li>"; ?>
                    </ul>
                </div>

                <h3><a href="#">Carátulas</a></h3>
                <div>
                    <ul id="menu3">
                        <li><a href="caratula.php">Registrar Plan</a></li>
                        <li><a href="caratulaSumaria.php">Registrar Obra Social</a></li>
                        <li><a href="historialCaratulas.php?act=listar" target="main">Listar </a></li>
                        <li><a href="caratula_mandataria.php">Registrar SUP</a></li>
                        <li><a href="historial_mandatarias.php?act=listar" target="main">Listar</a></li>
                    </ul>
                </div> 
                <h3><a href="#">Estado de cuenta</a></h3>
                <div>
                    <ul id="menu7">
                        <li><a href="estadocuenta.php" target="main">Listar Movimientos</a></li>
                        <li><a href="estadocuenta.php?act=liquidacion" target="main">Listar Liquidación</a></li>
                        <li><a href="estadocuenta.php?act=pendiente" target="main">Listar Pendientes</a></li>
                    </ul>
                </div> 
                <? if ($userAuth->nivelAdmin->getIdAdmin() > 2) { ?>        
                <h3><a href="#">Usuarios</a></h3><div>
                <ul id="menu4"> 
                    <li><a href="userAdd.php" target="main">Alta</a></li>
                    <!--<li><a href="usuarios_1.php?act=editar" target="main">Editar</a></li>-->
                    <li><a href="userList.php" target="main">Listado</a></li> 
                </ul></div><? } ?>
            </div>
        </div><!-- End accordionResizer -->   
        <div id="datepicker" ></div>
        <div class="menu_logo">
            <img src="images/logo_menu.png"  alt="Colegio Farmacéutico de San Juan" /></div>
        </div><!-- Menu -->
        <script type="text/javascript" src="js/jquery.ui.datepicker-es.js"></script>
        <script type="text/javascript">
        $("#right").load("main.php");
        $("#accordion div ul li a, #header div.welcome a.right").click(function (e) {
            e.preventDefault();
            $("#loaderDiv").show();            
             $.ajax({
                    url: $(this).attr('href'),
                    context: document.body,
                    success: function (data) {
                        $('#right').html(data);
                    },
                    error: function (err) {
                        console.log(err);
                    },
                    always: function(){
                        $("#loaderDiv").hide();
                    }
                });
        })
        $( "#datepicker" ).datepicker(
            $.datepicker.regional[ "es" ]
            );	
        $( "#accordion" ).accordion();
        $("#header a.ui-jQuery").button();
        </script>
    </body>
    </html>
