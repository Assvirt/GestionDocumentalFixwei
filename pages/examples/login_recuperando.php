<?php
//abrimos la conexion
require_once("../controlador/sesion/connection.php");
//iniciamos la session para usar el correo del anterior formulario
session_start();
//validacion con el correo
$cc = $_POST['cc'];


$_SESSION['correo'];
$email = $_SESSION['correo']; 
//llamamos a la accion del boton y consigo traemos el valor de la nueva contraseña
$consulta = "SELECT cedula,nombres,apellidos FROM usuario where cedula = '$cc'";
$query = mysqli_query($con, $consulta);
$numrows=mysqli_num_rows($query);
        
        if($numrows!=0)
    
        {
        while($row=mysqli_fetch_assoc($query))
        {
            $cedula=$row['cedula'];
            $nombreUsuario=utf8_encode($row['nombres'].' '.$row['apellidos']);


        }
    }


if ($cc == $cedula) { 
    
if(isset($_POST["reenviar"])){ 
    //echo $cc;
    //echo '---    Nueva:'.$newpass = $_POST['newpass'];
    //echo '-- Correo:'.$email;
//hacemos la actualización en la bd donde el correo corresponde al correo del anterior formulario
    //$update = "UPDATE perfiles SET clave='$newpass', estadoPerfiles ='bloqueado' WHERE cedul = '$cc'";
    $update = "UPDATE usuario SET clave='".$_POST['newpass']."' WHERE cedula = '$cc'";
    $query = mysqli_query($con, $update);

    $pass=$_POST['newpass'];

    require '../controlador/usuarios/libreria/PHPMailerAutoload.php';

    //Create a new PHPMailer instance
    $mail = new PHPMailer();
    $mail->IsSMTP();
     
    //Configuracion servidor mail
    require '../correoEnviar/contenido.php';
    
    //Agregar destinatario
    $mail->isHTML(true);
    $mail->AddAddress($email);
    $mail->Subject = utf8_decode('Recuperación de contraseña');
    //$mail->Body = $_POST['message'];
    
    $mail->Body = utf8_decode('
    <html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>HTML</title>
    </head>
    <body>
    <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
    
    <p>Estimado (a). '.$nombreUsuario.'
    <br>
    <p><b>Ha realizado la solicitud de recuperación de contraseña.</b></p>
     A continuación, conozca las credenciales para acceder al sistema e iniciar su experiencia en FIXWEI.
    
    
    <br>Nueva contraseña: <b><em>'.$pass.'</em></b>
    <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
    <br><br>
    Se recomienda ingresar y realizar el cambio de contraseña.
    <br><br>
    Este correo es informativo por tanto, le pedimos no responda este mensaje.
    </p>
    </body>
    </html>
    ');
    
    //Avisar si fue enviado o no y dirigir al index
   
    if ($mail->Send()) { 
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformularioEnviado"].submit();
                 }
            </script>
             
            <form name="miformularioEnviado" action="login" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="correoEnviado" value="1">
            </form> 
        <?php 
        
        //echo'<script type="text/javascript">
        //       alert("Enviado Correctamente");
        //    </script>';
        //header("Location: datos");
        //echo '<script language="javascript">confirm(" Verifique su clave temporal que fue enviada a su correo");
        //window.location.href="login"</script>';
    } else { 
        
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformularioNoEnviado"].submit();
                 }
            </script>
             
            <form name="miformularioNoEnviado" action="login" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="correoNoEnviado" value="1">
            </form> 
        <?php 
        //echo '<script language="javascript">confirm(" NO ENVIADO, intentar de nuevo");
        //window.location.href="login"</script>';
    }
    /*  
 //enviamos el dato al correo
$newpass=$_POST['newpass'];
$nombre= "FIXWEI";
$correoE= "fixwei@info.com";
$telefono="000012  018000";
$mensaje=" Su nueva clave es: $newpass";

// datos para el correo
$destinatario=$email;
$asunto="Recuperando clave";

$carta = "De: $nombre \n";
$carta .= "Correo: $correoE \n";
$carta .= "Telefono: $telefono \n\n";
$carta .= " $mensaje \n";
//enviando mensaje
mail($destinatario, $asunto, $carta);
*/

// finaliza proceso e confirmacion 
  
    
   
   

}else{
    echo "algo salio mal";
}

}




?>