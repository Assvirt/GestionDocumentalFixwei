<?php

//// Eliminar comentario segun la necesidad del envio masivo de correos

/*
$mail->From = "pruebasassvirt@gmail.com"; //remitente
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls';
$mail->Username = 'pruebasassvirt@gmail.com';
$mail->Password = 'pruebasassvirt1234';
*/
$mail->From = "info@assvirt.com"; //remitente
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'ssl'; //seguridad
$mail->Host = "smtp.zoho.com"; // servidor smtp
$mail->Port = 465; //puerto 587
$mail->Username ='info@assvirt.com'; //nombre usuario
$mail->Password = 'QAZXDREW2015'; //contraseña
//Configuracion servidor mail
/*
$mail->From = "soporte@fixwei.com"; //remitente
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls'; //seguridad
$mail->Host = "smtp.zoho.com"; // servidor smtp
$mail->Port = 587; //puerto 587
$mail->Username ='soporte@fixwei.com'; //nombre usuario
$mail->Password = 'Asd2021%%'; //contraseña
*/
/*
$mail->From = "info@assvirt.com"; //remitente
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'ssl'; //seguridad
$mail->Host = "smtp.zoho.com"; // servidor smtp
$mail->Port = 465; //puerto 587
$mail->Username ='info@assvirt.com'; //nombre usuario
$mail->Password = 'QAZXDREW2015'; //contraseña


$mail->From = "interno@assvirt.com"; //remitente
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls'; //seguridad
$mail->Host = "smtp.fixwei.com"; // servidor smtp
$mail->Port = 587; //puerto 587
$mail->Username ='interno@assvirt.com'; //nombre usuario
$mail->Password = 'Asd2021%%'; //contraseña

$mail->From = "felipe.mesa@assvirt.com"; //remitente
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'ssl';
$mail->Host = 'smtp.zoho.com';
$mail->Port = 465;
$mail->Username = 'interno@assvirt.com';
$mail->Password = 'Asd2021%%%';
*/

?>