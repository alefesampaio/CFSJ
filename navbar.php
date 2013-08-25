    <? require_once 'auth.php'; ?>
    <div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Colegio Farmaceútico de San Juan</a>
    </div>
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav pull-right">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?= ucfirst($userAuth->getUsuario()) ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a href="updatePass">Cambiar contraseña</a></li>
                <li><a href="perfil">Mi Perfil</a></li>
                <li class="divider"></li>
                <li><a href="login.php?act=logout">Salir</a></li>
            </ul>
        </li>
    </ul>
</div><!-- /.nav-collapse -->
</div><!-- /.container -->
</div><!-- /.navbar -->