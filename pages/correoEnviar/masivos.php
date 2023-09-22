<?php
/* Se debe revisar el archivo class.phpmailer.php al momento de ejecutarlo sobre el servidor 
   ya que de manera local funciona correctamente,es importante revisar el tema de puertos
*/ 

ignore_user_abort(1);
set_time_limit(0); 
require 'libreria/PHPMailerAutoload.php';
include '../conexion/bd.php';

//Create a new PHPMailer instance
$mail = new PHPMailer();
$mail->IsSMTP();
 
//Configuracion servidor mail
;
require 'contenido.php';

//Agregar destinatario
$mail->isHTML(true);


 $sql = $mysqli->query("SELECT correo FROM correos WHERE id = '9' ");
 while($result= $sql->fetch_array()) {
  $mail->AddAddress($result['correo']);
  echo $result['correo'];
 
 }

$mail->Body = utf8_decode('<h3 align=center>Bienvenido a Servicios & Soluciones Integrales ASSVIRT SAS <br><br>Ha sido registrado como usuario en nuestro sistema ERP, mediante el cuál podrá realizar el seguimiento de las guías y procesos de la gestión logística.<br><br>Por este medio recibira el acceso al sistema de informaicón ERP <a href="https://erp.assvirt.net">Clic quí</a>.<br><br>Para mayor información contactar a <br><br> Gracias por usar nuestros servicios </h3>');

//Avisar si fue enviado o no y dirigir al index
if ($mail->Send()) {
    echo'<script type="text/javascript">
           alert("Enviado Correctamente");
        </script>';
    //header("Location: datos");
} else {
    echo'<script type="text/javascript">
           alert("NO ENVIADO, intentar de nuevo");
        </script>';
    }
    $mail->ClearAddresses();  

?>