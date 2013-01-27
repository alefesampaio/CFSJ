<? //ini_set("display_errors", 1); ?>
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
                $("#email").focus();
                $("a.goBack").button();
            })
        </script>
        <title>Recuperación de cuenta</title>
    </head>
    <body>
        <div id="passRecovHeader">
   <img src="images/logo_menu.png" width="193" height="65" alt="Colegio Farmaceútico de San Juan" /></div>
        <div id="wrapper">
                <div class="subtit">¿No puedes iniciar sesión?</div>
                <form action="" method="post">
                    <p>Ingresa tu dirección de correo electrónico en el siguiente formulario, y te enviaremos las instrucciones para recuperar tu contraseña.</p><br />
                    
        <?
        require 'BLL/managerUsuario.class.php';
        if (isset($_POST['enviar'])) {
            $error = false;
            require_once 'funciones/functions.php';
            if (!$_POST['email']) {
                $error = true;
                $msg = "Debes introducir el email con el que te registraste.";
            } else {
                if (!validEmail($_POST["email"])) {
                    $error = true;
                    $msg = "Debes introducir un email válido.";
                } else {
                    // Comprueba el email
                    $email = trim(strip_tags($_POST['email']));
                    if (ManagerUsuario::obtenerUsuarioPorEmail($_POST['email'])) {
                        $user = ManagerUsuario::obtenerUsuarioPorEmailObj(preparar($_POST['email']));
                        require_once 'BLL/managerRecuperarPass.class.php';
                        if (managerRecuperarPass::obtenerObjPorEmailBool($user->getEmail())) {
                            managerRecuperarPass::eliminarRegistro($email, "email");
                        }
                    } else {
                        $error = true;
                        $msg = "El email ingresado no se encuentra registrado.";
                    }
                }
            }
            if ($error == false) {
                $fecha = new DateTime();
                $ip = getenv("REMOTE_ADDR");
                $forgot_code = md5($_POST['email']);
                $usuario = $user->getUsuario();
                // Enviar mail de confirmacion
                require_once 'class.phpmailer.php';

                $mail = new PHPMailer();

                $mail->Ismail();                                      // set mailer to use mail
                $mail->Host = "mail.colfasanjuan.com.ar;mail.colfasanjuan.com.ar";  // specify main and backup server
                $mail->mailAuth = true;     // turn on mail authentication
                $mail->Username = "info@colfasanjuan.com.ar";  // mail username
                $mail->Password = "ganimedes45&"; // mail password
                $mail->From = "info@colfasanjuan.com.ar";
                $mail->FromName = "Colegio Farmaceútico de San Juan";
                $mail->AddAddress($_POST["email"]);                  // name is optional
                $mail->AddReplyTo("info@colfasanjuan.com.ar", "CFSJ");
                $mail->WordWrap = 100; // set word wrap to 50 characters// set word wrap to 50 characters
                $mail->Subject = "Recuperar contraseña";
                $mail->Body = preg_replace("/\{forgot_code\}/", $forgot_code, preg_replace("/\{usuario\}/", $usuario, "Hola {usuario},\n\n"
                                . "Recibimos una solicitud de cambio de contraseña. Para confirmar tu nueva contraseña haz click en el siguiente enlace:\n\n"
                                . "http://www.colfasanjuan.com.ar/admin/recovery.php?codigo={forgot_code}\n(si tu explorador no te permite acceder a este link, cópialo y pégalo en la barra de direcciones)\n\n"
                                . "Por favor, ignora este mensaje si nunca solicitaste el cambio de contraseña.\n\nSaludos.\nColegio Farmaceútico de San Juan."));
                if (!$mail->Send()) {
                    echo "El mensaje no se pudo entregar. <p>";
                    echo "Mailer Error: " . $mail->ErrorInfo;
                    exit;
                }
                $recover = new recuperarPass();
                $recover->setEmail($user->getEmail());
                $recover->setCodigo($forgot_code);
                $recover->setFecha($fecha->format("Y-m-d H:i:s"));
                $recover->setIp($ip);
                //echo $forgot_code;
                echo managerRecuperarPass::insertar($recover);
            }
        }



        if ((isset($error) && $error) || !isset($error)) {
            if (isset($error) && $error) {
        echo "<p><ul class='errorlist sAuto'>$msg</ul></p>";
    }
            ?>
            <p>
                        <label><b>Email:</b><?
            if (isset($bemail) && $bemail) {
                echo "<span class='requerido'>*</span>";
            }
            ?></label>
                        <input name="email" type="text" id="email" <?
            if (isset($_POST["email"])) {
                echo "value='" . $_POST["email"] . "'";
            }
            ?> maxlength="64" class="bigInput s300" />
                  
                    <input type="submit" name="enviar" value="Recuperar contraseña" /></p>
                </form>
    <?
    
}
?> <br /><p><a href='./' class='ui-jQuery here goBack'>« Volver</a></p></div>

    </body>
</html>