<?php
require_once'../conexion/bd.php';

$consultaCorreos=$mysqli->query("SELECT * FROM correos ");
while($extraerConsultaCorreo=$consultaCorreos->fetch_array(MYSQLI_ASSOC)){
    echo 'Correo: '.$extraerConsultaCorreo['correo'];
    echo '<br>';

                                                        $to=$extraerConsultaCorreo['correo'];
                                                        $subject = "Notificación";
                                                        $headers = "MIME-Version: 1.0" . "\r\n";
                                                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                                         
                                                        $message = "
                                                        <html>
                                                        <head>
                                                        <title>HTML</title>
                                                        </head>
                                                        <body>
                                                        <img src='http://fixwei.com/plataforma/dist/img/fondoLogin2.jpg' width='200px' height='100px'><br>
                                                        
                                                        <p>Estimado/a. <b>'$nombredelUsuarioR'</b>.
                                                        <br><br>Se procede a realizar la '$tipoProcesoNombre' del siguiente documento, '$nombreDocEnviar' 
                                                        <br><br>
                                                        Cualquier inquietud sobre la misma, por favor contactar a la empresa prestadora de servicio <a target='_black' href='http://fixwei.com/plataforma/pages/examples/login'>Fixwei</a>
                                                        <br><br>
                                                        Atentamente, FIXWEI.
                                                        <br><br>Importante. Este es un <b>aviso</b> enviado por la plataforma, por favor NO lo responda.
                                                        </p>
                                                        </body>
                                                        </html>";
                                                         
                                                        $confirmaiarEnvio=mail($to, $subject, $message, $headers);
    
                                                       

                                                if($confirmaiarEnvio != NULL){
                                                    echo 'Enviado con éxito<br><br>';
                                                }
    
    
    
}


/*
for($i=1; $i<=9; $i++){
    echo 'Correo enviado: '.$correo;
    echo '<br>';
}*/

/*
                                                        $to='ass55tre@gmail.com';
                                                        $subject = "Notificación";
                                                        $headers = "MIME-Version: 1.0" . "\r\n";
                                                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                                         
                                                        $message = "
                                                        <html>
                                                        <head>
                                                        <title>HTML</title>
                                                        </head>
                                                        <body>
                                                        <img src='http://fixwei.com/plataforma/dist/img/fondoLogin2.jpg' width='200px' height='100px'><br>
                                                        
                                                        <p>Estimado/a. <b>'$nombredelUsuarioR'</b>.
                                                        <br><br>Se procede a realizar la '$tipoProcesoNombre' del siguiente documento, '$nombreDocEnviar' 
                                                        <br><br>
                                                        Cualquier inquietud sobre la misma, por favor contactar a la empresa prestadora de servicio <a target='_black' href='http://fixwei.com/plataforma/pages/examples/login'>Fixwei</a>
                                                        <br><br>
                                                        Atentamente, FIXWEI.
                                                        <br><br>Importante. Este es un <b>aviso</b> enviado por la plataforma, por favor NO lo responda.
                                                        </p>
                                                        </body>
                                                        </html>";
                                                         
                                                        echo 'Envío: '.$confirmaiarEnvio=mail($to, $subject, $message, $headers);

if($confirmaiarEnvio != NULL){
    echo '<br>Enviado con éxito';
}
*/

?>