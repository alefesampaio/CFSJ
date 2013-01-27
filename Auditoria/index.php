<? require "auth.php"; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Ministerio de Salud Pública</title>
        <? include 'head.html'; ?>
        <style>
            .hero-unit {
                padding: 30px;
            }
        </style>
    <body>
        <? include 'navbar.php' ?>
        <div class="container-fluid">
            <div class="row-fluid  content">
                <? include 'navmenu.php'; ?>
                <div class="span10">
                    <div class="hero-unit">
                        <h2>Bienvenido, <?= ucfirst($userAuth->getUsuario()) ?></h2>
                        <p>A continuación, podrás realizar las validaciones de medicamentos habituales desde aquí.</p>
                        <p><a href="validar" class="btn btn-primary btn-large">¡Validar!</a></p>
                    </div>
                    <div class="row-fluid">
                    </div><!--/row-->
                </div><!--/span-->
            </div><!--/row-->
            <hr>
            <? include 'footer.php'; ?>
        </div><!--/.fluid-container-->
        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->

        <div id="XPLSS_Flyover" style="position: absolute; z-index: 10002; visibility: hidden; left: -2100px; top: -2100px; ">
        </div>
        <div id="XPLSS_Trans" style="position: absolute; z-index: 10000; visibility: hidden; left: -2100px; top: -2100px; "></div><embed type="application/avg-searchshield-plugin" hidden="yes" id="avgss-plugin">
    </body>
</html>
