<? require_once 'auth.php'; ?>
<div class="row row-offcanvas row-offcanvas-right">
    <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
      <div class="well sidebar-nav">
        <ul class="nav">
          <li>Sitio</li>
          <li class="active"><a href="index" >Inicio</a></li>
          <li><a href="estadisticas" >Estadísticas</a></li>
          <li>Archivos</li>
          <li><a href="download.php">Descargar</a></li>
          <? if ($userAuth->nivelAdmin->getIdAdmin() > 3) echo "<li><a href='upload.php'>Subir</a></li>"; ?>
          <li>Carátulas</li>
          <li><a href="caratula">Registrar por plan</a></li>
          <li><a href="caratulaSumaria">Registrar por Obra Social</a></li>
          <li><a href="historialCaratulas.php?act=listar">Listado</a></li>
          <li>Estado de cuenta</li>
          <li><a href="estadocuenta.php">Movimiento</a></li>
          <li><a href="estadocuenta.php?act=liquidacion">Liquidado</a></li>
          <? if ($userAuth->nivelAdmin->getIdAdmin() > 2) { ?>        
          <li>Usuarios</li>
          <li><a href="userAdd.php">Alta</a></li>
          <!--<li><a href="usuarios_1.php?act=editar" target="main">Editar</a></li>-->
          <li><a href="userList.php">Listado</a></li> 
          <? } ?>
      </ul>
  </div><!--/.well -->
</div><!--/span-->
</div><!--/row-->