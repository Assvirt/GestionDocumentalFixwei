<?php
if(isset($_POST['enviar'])){
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $asunto = $_POST['asunto'];
    $mensaje =  $_POST['mensaje'];
    
    $html = "<p>Nombre: ".$nombre."</p><br><p>Mensaje: ".$mensaje."</p>";
    
    $correoEnviar = "contacto@fixwei.com";
    
    $header = "From: ".$nombre." - ".$correo."\r\n";
    $header.= "Replay-To: noreply@fixwei.com"."\r\n";
    $header.="X-Mailer: PHP/".phpversion();
    $mail = mail($correoEnviar,$asunto,$mensaje,$header);
    
    if($mail){
        echo '<script language="javascript">alert("Gracias por contactarnos!.");
    window.location.href="index.html"</script>';
    }
}