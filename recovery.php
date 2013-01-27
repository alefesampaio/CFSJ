<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="css/admin2.css" />
        <link rel="stylesheet" href="css/jquery-ui-1.8.19.custom.css" />
        <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.8.19.custom.min.js"></script>
        <script type="text/javascript"> 
            $(document).ready(function () {
                $( "input:submit, input:button").button();
                $("a").button();
                //$("a.goBack").click(function(){ history.go(-1); });
                $("#email").focus();
            })
        </script>
        <title>Recuperación de cuenta</title>
    </head>

    <body>
        <div id="passRecovHeader">
<img src="images/logo_menu.png" width="193" height="65" alt="Colegio Farmaceútico de San Juan" />
        </div>
        <div id="wrapper">
                <div class="subtit">¿No puedes iniciar sesión?</div>
                
                    <p>Ingresa tu dirección de correo electrónico en el siguiente formulario, y te enviaremos las instrucciones para recuperar tu contraseña.</p><br />
                    
        <?
        if (isset($_GET["codigo"])) {
            require_once 'funciones/functions.php';
            $error = false;
            $code = trim(strip_tags($_GET['codigo']));
            require_once 'BLL/managerRecuperarPass.class.php';
            if (managerRecuperarPass::obtenerObjPorCodigoBool($code)) {
                $obj = managerRecuperarPass::obtenerObjPorCodigo($code);
                require_once 'BLL/managerUsuario.class.php';
                if (ManagerUsuario::obtenerUsuarioPorEmail($obj->getEmail())) {
                    $fuser = ManagerUsuario::obtenerUsuarioPorEmailObj($obj->getEmail());
                    // Crear random pass
                    $totalChar = 7;
                    $salt = "abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
                    srand((double) microtime() * 1000000); // start the random generator
                    $randompass = "";
                    for ($i = 0; $i < $totalChar; $i++) {
                        $randompass = $randompass . substr($salt, rand() % strlen($salt), 1);
                    }
                    $newpass = md5($randompass);
                    $fuser->setPass($newpass);
                    ManagerUsuario::modificarPass($fuser);
                    managerRecuperarPass::eliminarRegistro(preparar($code), "codigo");
                    // Enviar mail de confirmacion
                    $usuario = $fuser->getUsuario();
                    require_once 'class.phpmailer.php';

                    $mail = new PHPMailer();

                    $mail->Ismail();                                      // set mailer to use mail
                    $mail->Host = "mail.colfasanjuan.com.ar;mail.colfasanjuan.com.ar";  // specify main and backup server
                    $mail->mailAuth = true;     // turn on mail authentication
                    $mail->Username = "info@colfasanjuan.com.ar";  // mail username
                    $mail->Password = "ganimedes45&"; // mail password
                    $mail->From = "info@colfasanjuan.com.ar";
                    $mail->FromName = "Colegio Farmaceútico de San Juan";
                    $mail->AddAddress($obj->getEmail());                  // name is optional
                    $mail->AddReplyTo("info@colfasanjuan.com.ar", "CFSJ");
                    $mail->WordWrap = 100; // set word wrap to 50 characters// set word wrap to 50 characters
                    $mail->Subject = "Nueva contraseña";
                    $mail->Body = preg_replace("/\{randompass\}/", $randompass, preg_replace("/\{usuario\}/", $usuario, "Hola {usuario},\n\n"
                                    . "A continuación, te enviamos tu nueva contraseña. Recomendamos que una vez que ingreses al sitio, la cambies por una propia, en la sección Mi Cuenta.\n\n"
                                    . "Usuario: {usuario}\n"
                                    . "Contraseña nueva: {randompass}\n\n"
                                    . "Si los problemas persisten, no dudes en contactarnos, incluyendo este email.\n\nSaludos.\nColegio Farmaceútico de San Juan."));
                    if (!$mail->Send()) {
                        echo "El mensaje no pudo ser enviado. <p>";
                        echo "Mailer Error: " . $mail->ErrorInfo;
                        exit;
                    }

                    echo "<div class='succesList p100'>Te hemos enviado un email con tu nueva contraseña.</div>";
                } else {
                    echo "<div class='errorlist  p100'>La operación no se pudo realizar.</div>";
                    managerRecuperarPass::eliminarRegistro(preparar($code));
                }
            } else {
                echo "<div class='infolist p100'>El código de recuperación ha expirado. Por favor vuelve a intentar.</div>";
            }
        } else {
            echo "<div class='infolist p100'>El código de recuperación ha expirado. Por favor vuelve a intentar.</div>";
        }
        ?>
              <p><a href='passRecovery' class='ui-jQuery here goBack'>« Volver</a></p>
        </div>
    
    </body>
</html>