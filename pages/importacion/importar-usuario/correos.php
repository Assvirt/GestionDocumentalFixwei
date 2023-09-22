<?php
/* Se debe revisar el archivo class.phpmailer.php al momento de ejecutarlo sobre el servidor 
   ya que de manera local funciona correctamente,es importante revisar el tema de puertos
*/ 

ignore_user_abort(1);
set_time_limit(0); 
require '../../correoEnviar/libreria/PHPMailerAutoload.php';
include '../../conexion/bd.php';

 $acentos = $mysqli->query("SET NAMES 'utf8'");
 $sql = $mysqli->query("SELECT * FROM usuario WHERE correos = '1'");
 while($result= $sql->fetch_array()) {

  //Create a new PHPMailer instance
  $mail = new PHPMailer();
  $mail->IsSMTP();
 
  //Configuracion servidor mail
  
  require '../../correoEnviar/contenido.php';
  //Agregar destinatario
  $mail->isHTML(true);
  $mail->AddAddress($result['correo']);
  $mail->Subject = 'Registro usuario';
   $result['correo'];  '<br>';
   $nombre=($result['nombres']);  '<br>';
   $apellido=($result['apellidos']);  '<br>';
   $cedula=$result['clave'];  '<br>';
 

    $mail->Body = utf8_decode(('
    <html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>HTML</title>
    </head>
    <body>
    <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
    
    <p>Estimado (a). <b><em>'.($nombre.' '.$apellido).'</em></b>.
    <br>
    <p><b>Bienvenido (a) a FIXWEI, su aliado estratégico en gestión de procesos.</b></p>
    A continuación, conozca las credenciales para acceder al sistema e iniciar su experiencia en FIXWEI.
    
    <br><br>Usuario: <b><em>'.$cedula.'</em></b>
    <br>Clave: <b><em>'.$cedula.'</em></b>
    <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
    <br><br>
    Se recomienda ingresar y realizar el cambio de contraseña.
    <br><br>
    Este correo es informativo y por tanto, le pedimos no responda este mensaje.
    </p>
    </body>
    </html>
    '));

 
 
    //Avisar si fue enviado o no y dirigir al index
    if ($mail->Send()) {
        $mysqli->query("UPDATE usuario SET correos = NULL WHERE correos='1' ");
        //echo'<script type="text/javascript">
        //       alert("Enviado Correctamente");
        //    </script>';
        //header("Location: ../../usuarios");
    ?>
                        <script> 
                             window.onload=function(){
                           
                                 document.forms["miformulario"].submit();
                             }
                        </script>
                         
                        <form name="miformulario" action="../../usuarios" method="POST" onsubmit="procesar(this.action);" >
                            <input type="hidden" name="validacionAgregar" value="1">
                        </form> 
    <?php
    } else {
    //echo'<script type="text/javascript">
      //     alert("NO ENVIADO, intentar de nuevo");
    //    </script>';
       ?>
                        <script> 
                             window.onload=function(){
                           
                                 document.forms["miformulario"].submit();
                             }
                        </script>
                         
                        <form name="miformulario" action="../../usuarios" method="POST" onsubmit="procesar(this.action);" >
                            <input type="hidden" name="validacionAgregar" value="1">
                        </form> 
    <?php
    }
    $mail->ClearAddresses();  
}
?>