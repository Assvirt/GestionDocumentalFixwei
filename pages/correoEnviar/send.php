<?php
require 'libreria/PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer();
$mail->IsSMTP();
 
//Configuracion servidor mail
$mail->From = "soporte@fixwei.com"; //remitente
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls'; //seguridad
$mail->Host = "smtp.zoho.com"; // servidor smtp
$mail->Port = 587; //puerto 587
$mail->Username ='soporte@fixwei.com'; //nombre usuario
$mail->Password = 'Asd2021%%'; //contraseña

//Agregar destinatario
$mail->isHTML(true);
$mail->AddAddress($_POST['email']);
$mail->Subject = $_POST['subject'];
//$mail->Body = $_POST['message'];

$mail->Body = utf8_decode('<h3 align=center>Bienvenido a Servicios & Soluciones Integrales ASSVIRT SAS <br><br>Ha sido registrado como usuario en nuestro sistema ERP, mediante el cuál podrá realizar el seguimiento de las guías y procesos de la gestión logística.<br><br>Por este medio recibira el acceso al sistema de informaicón ERP <a href="https://erp.assvirt.net">Clic quí</a>.<br><br>Para mayor información contactar a <br><br> Gracias por usar nuestros servicios </h3>');

//Avisar si fue enviado o no y dirigir al index
if ($mail->Send()) {
    echo'<script type="text/javascript">
           alert("Enviado Correctamente");
        </script>';
    header("Location: datos");
} else {
    echo'<script type="text/javascript">
           alert("NO ENVIADO, intentar de nuevo");
        </script>';
}
?>