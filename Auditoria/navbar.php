<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="btn btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="#">Ministerio de Salud Pública</a>
            <div class="nav-collapse collapse" style="height: 0px; ">
                <div class="navbar-text pull-right">
                    <ul class="nav pull-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="icon-user icon-white"></i> <?= ucfirst($userAuth->getUsuario()) ?>
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="perfil"> Perfil</a></li>
                                <li><a href="updatePass"> Cambiar contraseña</a></li>
                                <li class="divider"></li>
                                <li><a href="../login.php?act=logout"><i class="i"></i> Salir</a></li>
                            </ul>
                        </li>
                    </ul>


                </div>
                <ul class="nav">
                    <? if ($userAuth->nivelAdmin->getIdAdmin() > 2) { ?>
<!--                        <li>
                            <ul class="nav pull-right">
                                <li <? // ($page == "ventas") ? "class='active'" : "" ?>class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Listados <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="">Droguerias</a></li>
                                        <li><a href=""> Farmacias</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>-->
                        
                    <? } ?>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>