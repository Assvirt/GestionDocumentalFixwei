<?php error_reporting(E_ERROR);
//////// traemos la bd
require_once '../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario

if(isset($_POST['solicitudEliminacion'])){
    $ingresoDatos=$_POST['ingresoDatos']; 
    
    $seguridadPreguntar=$mysqli->query("SELECT * FROM seguridadDelete WHERE documento ='$ingresoDatos' ");
    $resultadoSeguridadPreguntar=$seguridadPreguntar->fetch_array(MYSQLI_ASSOC);
    $nombreUsuario=$resultadoSeguridadPreguntar['nombre'];
    $correoSeguridad=$resultadoSeguridadPreguntar['correo'];
    
    if($resultadoSeguridadPreguntar != NULL){ 
        
        
        date_default_timezone_set('America/Bogota');
        $fecha1=date('Y-m-j h:i:s A');
        
        function get_client_ip_env() {
            $ipaddress = '';
            if (getenv('HTTP_CLIENT_IP'))
                $ipaddress = getenv('HTTP_CLIENT_IP');
            else if(getenv('HTTP_X_FORWARDED_FOR'))
                $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
            else if(getenv('HTTP_X_FORWARDED'))
                $ipaddress = getenv('HTTP_X_FORWARDED');
            else if(getenv('HTTP_FORWARDED_FOR'))
                $ipaddress = getenv('HTTP_FORWARDED_FOR');
            else if(getenv('HTTP_FORWARDED'))
                $ipaddress = getenv('HTTP_FORWARDED');
            else if(getenv('REMOTE_ADDR'))
                $ipaddress = getenv('REMOTE_ADDR');
            else
                $ipaddress = 'UNKNOWN';
        
            return $ipaddress;
        }

        function get_client_ip_server() {
            $ipaddress = '';
            if ($_SERVER['HTTP_CLIENT_IP'])
                $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
            else if($_SERVER['HTTP_X_FORWARDED_FOR'])
                $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
            else if($_SERVER['HTTP_X_FORWARDED'])
                $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
            else if($_SERVER['HTTP_FORWARDED_FOR'])
                $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
            else if($_SERVER['HTTP_FORWARDED'])
                $ipaddress = $_SERVER['HTTP_FORWARDED'];
            else if($_SERVER['REMOTE_ADDR'])
                $ipaddress = $_SERVER['REMOTE_ADDR'];
            else
                $ipaddress = 'UNKNOWN';
        
            return $ipaddress;
        }
        
        //echo 'IP address (usando get_client_ip_env function) es ' . get_client_ip_env() . '<br>';
        //echo 'IP address (usando get_client_ip_server function) es ' . get_client_ip_server() . '<br>';

          $informacionCompleta=utf8_decode("El usuario ".$nombreUsuario."  realiza solicitud de eliminación de datos a la fecha ".$fecha1."
            <br><br><br>
            IP address (usando get_client_ip_env function) es " . get_client_ip_env() . "
            <br>
            IP address (usando get_client_ip_server function) es " . get_client_ip_server() . "
            <br>
            <br>
            El nombre del servidor es: {$_SERVER['SERVER_NAME']}<hr> 
            Vienes procedente de la página: {$_SERVER['HTTP_REFERER']}<hr> 
            Te has conectado usando el puerto: {$_SERVER['REMOTE_PORT']}<hr> 
            El agente de usuario de tu navegador es: {$_SERVER['HTTP_USER_AGENT']}
            ");
        
        $tupla = '1234567890abcdefghijklmnopqrstuvwxyz';
        $enviarVariableCaracteres=substr(str_shuffle($tupla), 0, 10);
        
        
        $mysqli->query("UPDATE seguridadDelete SET estado='activo', codigo='$enviarVariableCaracteres', registro='$informacionCompleta' WHERE documento ='$ingresoDatos' ");
        
        
       
                                            
                                            require 'usuarios/libreria/PHPMailerAutoload.php';

                                            //Create a new PHPMailer instance
                                            $mail = new PHPMailer();
                                            $mail->IsSMTP();
                                             
                                            //Configuracion servidor mail
                                            require '../correoEnviar/contenido.php';
                                            
                                            //Agregar destinatario
                                            $mail->isHTML(true);
                                            $mail->AddAddress($correoSeguridad);
                                            $mail->Subject = utf8_decode('Código de seguridad');
                                            //$mail->Body = $_POST['message'];
                                            
                                            $mail->Body = utf8_decode('
                                            <html>
                                            <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                            <title>HTML</title>
                                            </head>
                                            <body>
                                            <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                                            
                                            <p>Estimado (a). <b><em>Administrador</em></b>.
                                            <br>
                                            <p>Este código es único e intransferible, sólo podrá ser ingresado una única vez en el sistema y tendrá como fin eliminar la totalidad de los registros del sistema.</p>
                                            
                                            <br>Código: <b><em>'.$enviarVariableCaracteres.'</em></b>
                                            <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                            <br><br>
                                            <br><br>
                                             Este correo es informativo y por tanto, le pedimos no responda este mensaje.
                                            </p>
                                            </body>
                                            </html>
                                            ');
                                            
                                            if ($mail->Send()) {
                                                //echo 'Envio';
                                            }else{
                                                //echo 'No envio';
                                            }
        
        ?>
            <script> 
                 window.onload=function(){
               
                    document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../cliente" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="recibiendoDatos" value="<?php echo $ingresoDatos;?>">
                <input type="hidden" name="mensajeCodigo" value="1">
            </form> 
        <?php
    }else{ //echo 'alerta';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../cliente" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="alertaIngreso" value="1">
            </form> 
        <?php
    }
    
}
if(isset($_POST['codigoIntentos'])){
    $_POST['conteoSeguridad'];
    $ingresoDatos=$_POST['recibiendoDatos'];           
                    $seguridadPreguntar=$mysqli->query("SELECT * FROM seguridadDelete WHERE documento ='$ingresoDatos' ");
                    $resultadoSeguridadPreguntar=$seguridadPreguntar->fetch_array(MYSQLI_ASSOC);
                    $_POST['cdigoSeguridad'];
                    '-'.$resultadoSeguridadPreguntar['codigo'];
                    if($resultadoSeguridadPreguntar['codigo'] == $_POST['cdigoSeguridad']){ 
                        $mysqli->query("UPDATE seguridadDelete SET intentos='0', estado = 'proceso', codigo = NULL WHERE documento ='$ingresoDatos' ");
                       ?>
                            <script> 
                                 window.onload=function(){
                               
                                    document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../cliente" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="recibiendoDatos" value="<?php echo $ingresoDatos;?>">
                                <input type="hidden" name="permiteEliminar" value="1">
                            </form> 
                        <?php  
                    }else{ 
                        if($resultadoSeguridadPreguntar['intentos'] > 0){
                            //echo 'es mayor';
                            $enviarIntentosSeguridad=$resultadoSeguridadPreguntar['intentos']+1;
                        }else{
                            //echo 'no es mayor';
                            $enviarIntentosSeguridad=1;
                        }
                        
                        if($enviarIntentosSeguridad == 3){
                            $mysqli->query("UPDATE seguridadDelete SET intentos='0', estado='bloqueado' WHERE documento ='$ingresoDatos' ");
                        }else{
                            $mysqli->query("UPDATE seguridadDelete SET intentos='$enviarIntentosSeguridad' WHERE documento ='$ingresoDatos' ");
                        }
                        ?>
                            <script> 
                                 window.onload=function(){
                               
                                    document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../cliente" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="recibiendoDatos" value="<?php echo $ingresoDatos;?>">
                                <input type="hidden" name="mensajeIntentos" value="<?php echo $enviarIntentosSeguridad;?>">
                            </form> 
                        <?php
                    }
}
?>