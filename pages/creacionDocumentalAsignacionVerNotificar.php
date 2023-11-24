<?php
require_once 'conexion/bd.php';
session_start();
error_reporting(E_ERROR);

require 'controlador/usuarios/libreria/PHPMailerAutoload.php';
$tipoSolicitud=$_POST['tipoSolicitud'];
$estado=$_POST['estado'];

$queryDoc = $mysqli->query("SELECT * FROM documento WHERE id = '".$_POST['idDocumento']."' ")or die(mysqli_error($mysqli));
$datosDoc = $queryDoc->fetch_assoc();
$nombreDocEnviar=utf8_encode($datosDoc['nombres']);
$update=$mysqli->query("UPDATE documento SET asumeFlujo = NULL WHERE id='".$_POST['idDocumento']."' ");



///// para la creación
if($tipoSolicitud == '1'){
    if($estado == 'Pendiente'){ /// notificar a los elaboradores
        
    //// si viene 1 solo usuario guardamos el campo a modificar
    if($_POST['unicoUsuario'] != NULL){
        if($_POST['cambiarCargo'] != NULL){
            $cargosEnviar=$_POST['cambiarCargo'];
            'cargo cambiado: '.$guardarRol='["cargos","'.$cargosEnviar.'"]';
        }else{
            $usuarioEnviar=$_POST['cambiarUsuario'];
            'usuario cambiado: '.$guardarRol='["usuarios","'.$usuarioEnviar.'"]';
        }
        
        $update=$mysqli->query("UPDATE documento SET elabora ='$guardarRol' WHERE id='".$_POST['idDocumento']."' ");
    }
    
    if($_POST['unicoUsuario'] != NULL){
        $elabora=json_decode($guardarRol);
    }else{
        $elabora=json_decode($datosDoc['elabora']);
    }
        
            if($elabora[0] == 'usuarios'){
                    $longitud = count($elabora); 
                    for($i=0; $i<$longitud; $i++){
                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$elabora[$i]' ");
                        while($columna = $nombreuser->fetch_array()){
                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                         $correoResponsable=$columna['correo']; 
                         '<br>';
                          
                        
    
                                            
    
                                            //Create a new PHPMailer instance
                                            $mail = new PHPMailer();
                                            $mail->IsSMTP();
                                            
                                            //Configuracion servidor mail
                                            require 'correoEnviar/contenido.php';
                                            
                                            //Agregar destinatario
                                            $mail->isHTML(true);
                                            $mail->AddAddress($correoResponsable);
                                            $mail->Subject = utf8_decode('Encargado para la elaboración');
                                            //$mail->Body = $_POST['message'];
                                            
                                            $mail->Body = utf8_decode('
                                            <html>
                                            <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                            <title>HTML</title>
                                            </head>
                                            <body>
                                            <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                                            
                                            <p>Estimado (a). <b><em>'.$nombreResponsable.'</em></b>.
                                            <br>
                                            <p><b>Se le ha asignado la elaboración del documento '.$nombreDocEnviar.'.</b></p>
                                            Se recomienda ingresar al sistema y realizar la actividad encargada.
                                            <br>
                                            <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                            <br><br>
                                            Este correo es informativo por tanto, le pedimos no responda este mensaje.
                                            </p>
                                            </body>
                                            </html>
                                            ');
                                            
                                            //Avisar si fue enviado o no y dirigir al index
                                           
                                            if ($mail->Send()) {
                                            
                                            } else {
    
                                            }
                                            
                        }                
                    }
                }

            if($elabora[0] == 'cargos'){
                $longitud = count($elabora); 
                for($i=0; $i<$longitud; $i++){
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo = '$elabora[$i]' ");
                    while($columna = $nombreuser->fetch_array()){
                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                        $correoResponsable=$columna['correo']; 
                        '<br>';
                        //Create a new PHPMailer instance
                        $mail = new PHPMailer();
                        $mail->IsSMTP();
                        
                        //Configuracion servidor mail
                        require 'correoEnviar/contenido.php';
                        
                        //Agregar destinatario
                        $mail->isHTML(true);
                        $mail->AddAddress($correoResponsable);
                        $mail->Subject = utf8_decode('Encargado para la elaboración');
                        //$mail->Body = $_POST['message'];
                        
                        $mail->Body = utf8_decode('
                        <html>
                        <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                        <title>HTML</title>
                        </head>
                        <body>
                        <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                        
                        <p>Estimado (a). <b><em>'.$nombreResponsable.'</em></b>.
                        <br>
                        <p><b>Se le ha asignado la elaboración del documento '.$nombreDocEnviar.'.</b></p>
                        Se recomienda ingresar al sistema y realizar la actividad encargada.
                        <br>
                        <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                        <br><br>
                        Este correo es informativo por tanto, le pedimos no responda este mensaje.
                        </p>
                        </body>
                        </html>
                        ');
                        
                        //Avisar si fue enviado o no y dirigir al index
                       
                        if ($mail->Send()) {
                        
                        } else {

                        }
                    }
                }
            }  
    } 
    
    if($estado == 'Elaborado'){ /// notificar a los elaboradores
        
        //// si viene 1 solo usuario guardamos el campo a modificar
        if($_POST['unicoUsuario'] != NULL){
            if($_POST['cambiarCargo'] != NULL){
                $cargosEnviar=$_POST['cambiarCargo'];
                'cargo cambiado: '.$guardarRol='["cargos","'.$cargosEnviar.'"]';
            }else{
                $usuarioEnviar=$_POST['cambiarUsuario'];
                'usuario cambiado: '.$guardarRol='["usuarios","'.$usuarioEnviar.'"]';
            }
            
            $update=$mysqli->query("UPDATE documento SET revisa ='$guardarRol' WHERE id='".$_POST['idDocumento']."' ");
        }
        
        if($_POST['unicoUsuario'] != NULL){
            $elabora=json_decode($guardarRol);
        }else{
            $elabora=json_decode($datosDoc['revisa']);
        }
        
        
            if($elabora[0] == 'usuarios'){
                    $longitud = count($elabora); 
                    for($i=0; $i<$longitud; $i++){
                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$elabora[$i]' ");
                        while($columna = $nombreuser->fetch_array()){
                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                         $correoResponsable=$columna['correo']; 
                         '<br>';
                          
                        
    
                                            
    
                                            //Create a new PHPMailer instance
                                            $mail = new PHPMailer();
                                            $mail->IsSMTP();
                                            
                                            //Configuracion servidor mail
                                            require 'correoEnviar/contenido.php';
                                            
                                            //Agregar destinatario
                                            $mail->isHTML(true);
                                            $mail->AddAddress($correoResponsable);
                                            $mail->Subject = utf8_decode('Encargado para la revisión');
                                            //$mail->Body = $_POST['message'];
                                            
                                            $mail->Body = utf8_decode('
                                            <html>
                                            <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                            <title>HTML</title>
                                            </head>
                                            <body>
                                            <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                                            
                                            <p>Estimado (a). <b><em>'.$nombreResponsable.'</em></b>.
                                            <br>
                                            <p><b>Se le ha asignado la revisión del documento '.$nombreDocEnviar.'.</b></p>
                                            Se recomienda ingresar al sistema y realizar la actividad encargada.
                                            <br>
                                            <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                            <br><br>
                                            Este correo es informativo por tanto, le pedimos no responda este mensaje.
                                            </p>
                                            </body>
                                            </html>
                                            ');
                                            
                                            //Avisar si fue enviado o no y dirigir al index
                                           
                                            if ($mail->Send()) {
                                            
                                            } else {
    
                                            }
                                            
                        }                
                    }
                }

            if($elabora[0] == 'cargos'){
                $longitud = count($elabora); 
                for($i=0; $i<$longitud; $i++){
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo = '$elabora[$i]' ");
                    while($columna = $nombreuser->fetch_array()){
                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                        $correoResponsable=$columna['correo']; 
                        '<br>';
                        //Create a new PHPMailer instance
                        $mail = new PHPMailer();
                        $mail->IsSMTP();
                        
                        //Configuracion servidor mail
                        require 'correoEnviar/contenido.php';
                        
                        //Agregar destinatario
                        $mail->isHTML(true);
                        $mail->AddAddress($correoResponsable);
                        $mail->Subject = utf8_decode('Encargado para la revisión');
                        //$mail->Body = $_POST['message'];
                        
                        $mail->Body = utf8_decode('
                        <html>
                        <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                        <title>HTML</title>
                        </head>
                        <body>
                        <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                        
                        <p>Estimado (a). <b><em>'.$nombreResponsable.'</em></b>.
                        <br>
                        <p><b>Se le ha asignado la revisión del documento '.$nombreDocEnviar.'.</b></p>
                        Se recomienda ingresar al sistema y realizar la actividad encargada.
                        <br>
                        <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                        <br><br>
                        Este correo es informativo por tanto, le pedimos no responda este mensaje.
                        </p>
                        </body>
                        </html>
                        ');
                        
                        //Avisar si fue enviado o no y dirigir al index
                       
                        if ($mail->Send()) {
                        
                        } else {

                        }
                    }
                }
            }  
    }
    
    if($estado == 'Revisado'){ /// notificar a los elaboradores
        
        //// si viene 1 solo usuario guardamos el campo a modificar
        if($_POST['unicoUsuario'] != NULL){
            if($_POST['cambiarCargo'] != NULL){
                $cargosEnviar=$_POST['cambiarCargo'];
                'cargo cambiado: '.$guardarRol='["cargos","'.$cargosEnviar.'"]';
            }else{
                $usuarioEnviar=$_POST['cambiarUsuario'];
                'usuario cambiado: '.$guardarRol='["usuarios","'.$usuarioEnviar.'"]';
            }
            
            $update=$mysqli->query("UPDATE documento SET aprueba ='$guardarRol' WHERE id='".$_POST['idDocumento']."' ");
        }
        
        if($_POST['unicoUsuario'] != NULL){
            $elabora=json_decode($guardarRol);
        }else{
            $elabora=json_decode($datosDoc['aprueba']);
        }
    
        
            if($elabora[0] == 'usuarios'){
                    $longitud = count($elabora); 
                    for($i=0; $i<$longitud; $i++){
                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$elabora[$i]' ");
                        while($columna = $nombreuser->fetch_array()){
                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                         $correoResponsable=$columna['correo']; 
                         '<br>';
                          
                        
    
                                            
    
                                            //Create a new PHPMailer instance
                                            $mail = new PHPMailer();
                                            $mail->IsSMTP();
                                            
                                            //Configuracion servidor mail
                                            require 'correoEnviar/contenido.php';
                                            
                                            //Agregar destinatario
                                            $mail->isHTML(true);
                                            $mail->AddAddress($correoResponsable);
                                            $mail->Subject = utf8_decode('Encargado para la aprobación');
                                            //$mail->Body = $_POST['message'];
                                            
                                            $mail->Body = utf8_decode('
                                            <html>
                                            <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                            <title>HTML</title>
                                            </head>
                                            <body>
                                            <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                                            
                                            <p>Estimado (a). <b><em>'.$nombreResponsable.'</em></b>.
                                            <br>
                                            <p><b>Se le ha asignado la aprobación del documento '.$nombreDocEnviar.'.</b></p>
                                            Se recomienda ingresar al sistema y realizar la actividad encargada.
                                            <br>
                                            <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                            <br><br>
                                            Este correo es informativo por tanto, le pedimos no responda este mensaje.
                                            </p>
                                            </body>
                                            </html>
                                            ');
                                            
                                            //Avisar si fue enviado o no y dirigir al index
                                           
                                            if ($mail->Send()) {
                                            
                                            } else {
    
                                            }
                                            
                        }                
                    }
                }

            if($elabora[0] == 'cargos'){
                $longitud = count($elabora); 
                for($i=0; $i<$longitud; $i++){
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo = '$elabora[$i]' ");
                    while($columna = $nombreuser->fetch_array()){
                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                        $correoResponsable=$columna['correo']; 
                        '<br>';
                        //Create a new PHPMailer instance
                        $mail = new PHPMailer();
                        $mail->IsSMTP();
                        
                        //Configuracion servidor mail
                        require 'correoEnviar/contenido.php';
                        
                        //Agregar destinatario
                        $mail->isHTML(true);
                        $mail->AddAddress($correoResponsable);
                        $mail->Subject = utf8_decode('Encargado para la aprobación');
                        //$mail->Body = $_POST['message'];
                        
                        $mail->Body = utf8_decode('
                        <html>
                        <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                        <title>HTML</title>
                        </head>
                        <body>
                        <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                        
                        <p>Estimado (a). <b><em>'.$nombreResponsable.'</em></b>.
                        <br>
                        <p><b>Se le ha asignado la aprobación del documento '.$nombreDocEnviar.'.</b></p>
                        Se recomienda ingresar al sistema y realizar la actividad encargada.
                        <br>
                        <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                        <br><br>
                        Este correo es informativo por tanto, le pedimos no responda este mensaje.
                        </p>
                        </body>
                        </html>
                        ');
                        
                        //Avisar si fue enviado o no y dirigir al index
                       
                        if ($mail->Send()) {
                        
                        } else {

                        }
                    }
                }
            }  
    }
    
}

///// para la actualización
if($tipoSolicitud == '2'){
    if($estado == 'Pendiente'){ /// notificar a los elaboradores
        
        //// si viene 1 solo usuario guardamos el campo a modificar
        if($_POST['unicoUsuario'] != NULL){
            if($_POST['cambiarCargo'] != NULL){
                $cargosEnviar=$_POST['cambiarCargo'];
                'cargo cambiado: '.$guardarRol='["cargos","'.$cargosEnviar.'"]';
            }else{
                $usuarioEnviar=$_POST['cambiarUsuario'];
                'usuario cambiado: '.$guardarRol='["usuarios","'.$usuarioEnviar.'"]';
            }
            
            $update=$mysqli->query("UPDATE documento SET elaboraActualizar ='$guardarRol' WHERE id='".$_POST['idDocumento']."' ");
        }
        
        if($_POST['unicoUsuario'] != NULL){
            $elabora=json_decode($guardarRol);
        }else{
            $elabora=json_decode($datosDoc['elaboraActualizar']);
        }
    
        //$elabora=json_decode($datosDoc['elaboraActualizar']);
            if($elabora[0] == 'usuarios'){
                    $longitud = count($elabora); 
                    for($i=0; $i<$longitud; $i++){
                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$elabora[$i]' ");
                        while($columna = $nombreuser->fetch_array()){
                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                         $correoResponsable=$columna['correo']; 
                         '<br>';
                          
                        
    
                                            
    
                                            //Create a new PHPMailer instance
                                            $mail = new PHPMailer();
                                            $mail->IsSMTP();
                                            
                                            //Configuracion servidor mail
                                            require 'correoEnviar/contenido.php';
                                            
                                            //Agregar destinatario
                                            $mail->isHTML(true);
                                            $mail->AddAddress($correoResponsable);
                                            $mail->Subject = utf8_decode('Encargado para la elaboración');
                                            //$mail->Body = $_POST['message'];
                                            
                                            $mail->Body = utf8_decode('
                                            <html>
                                            <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                            <title>HTML</title>
                                            </head>
                                            <body>
                                            <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                                            
                                            <p>Estimado (a). <b><em>'.$nombreResponsable.'</em></b>.
                                            <br>
                                            <p><b>Se le ha asignado la elaboración del documento '.$nombreDocEnviar.'.</b></p>
                                            Se recomienda ingresar al sistema y realizar la actividad encargada.
                                            <br>
                                            <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                            <br><br>
                                            Este correo es informativo por tanto, le pedimos no responda este mensaje.
                                            </p>
                                            </body>
                                            </html>
                                            ');
                                            
                                            //Avisar si fue enviado o no y dirigir al index
                                           
                                            if ($mail->Send()) {
                                            
                                            } else {
    
                                            }
                                            
                        }                
                    }
                }

            if($elabora[0] == 'cargos'){
                $longitud = count($elabora); 
                for($i=0; $i<$longitud; $i++){
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo = '$elabora[$i]' ");
                    while($columna = $nombreuser->fetch_array()){
                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                        $correoResponsable=$columna['correo']; 
                        '<br>';
                        //Create a new PHPMailer instance
                        $mail = new PHPMailer();
                        $mail->IsSMTP();
                        
                        //Configuracion servidor mail
                        require 'correoEnviar/contenido.php';
                        
                        //Agregar destinatario
                        $mail->isHTML(true);
                        $mail->AddAddress($correoResponsable);
                        $mail->Subject = utf8_decode('Encargado para la elaboración');
                        //$mail->Body = $_POST['message'];
                        
                        $mail->Body = utf8_decode('
                        <html>
                        <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                        <title>HTML</title>
                        </head>
                        <body>
                        <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                        
                        <p>Estimado (a). <b><em>'.$nombreResponsable.'</em></b>.
                        <br>
                        <p><b>Se le ha asignado la elaboración del documento '.$nombreDocEnviar.'.</b></p>
                        Se recomienda ingresar al sistema y realizar la actividad encargada.
                        <br>
                        <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                        <br><br>
                        Este correo es informativo por tanto, le pedimos no responda este mensaje.
                        </p>
                        </body>
                        </html>
                        ');
                        
                        //Avisar si fue enviado o no y dirigir al index
                       
                        if ($mail->Send()) {
                        
                        } else {

                        }
                    }
                }
            }  
    } 
    
    if($estado == 'Elaborado'){ /// notificar a los elaboradores
        
        //// si viene 1 solo usuario guardamos el campo a modificar
        if($_POST['unicoUsuario'] != NULL){
            if($_POST['cambiarCargo'] != NULL){
                $cargosEnviar=$_POST['cambiarCargo'];
                'cargo cambiado: '.$guardarRol='["cargos","'.$cargosEnviar.'"]';
            }else{
                $usuarioEnviar=$_POST['cambiarUsuario'];
                'usuario cambiado: '.$guardarRol='["usuarios","'.$usuarioEnviar.'"]';
            }
            
            $update=$mysqli->query("UPDATE documento SET revisaActualizar ='$guardarRol' WHERE id='".$_POST['idDocumento']."' ");
        }
        
        if($_POST['unicoUsuario'] != NULL){
            $elabora=json_decode($guardarRol);
        }else{
            $elabora=json_decode($datosDoc['revisaActualizar']);
        }
        
        //$elabora=json_decode($datosDoc['revisaActualizar']);
            if($elabora[0] == 'usuarios'){
                    $longitud = count($elabora); 
                    for($i=0; $i<$longitud; $i++){
                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$elabora[$i]' ");
                        while($columna = $nombreuser->fetch_array()){
                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                         $correoResponsable=$columna['correo']; 
                         '<br>';
                          
                        
    
                                            
    
                                            //Create a new PHPMailer instance
                                            $mail = new PHPMailer();
                                            $mail->IsSMTP();
                                            
                                            //Configuracion servidor mail
                                            require 'correoEnviar/contenido.php';
                                            
                                            //Agregar destinatario
                                            $mail->isHTML(true);
                                            $mail->AddAddress($correoResponsable);
                                            $mail->Subject = utf8_decode('Encargado para la revisión');
                                            //$mail->Body = $_POST['message'];
                                            
                                            $mail->Body = utf8_decode('
                                            <html>
                                            <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                            <title>HTML</title>
                                            </head>
                                            <body>
                                            <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                                            
                                            <p>Estimado (a). <b><em>'.$nombreResponsable.'</em></b>.
                                            <br>
                                            <p><b>Se le ha asignado la revisión del documento '.$nombreDocEnviar.'.</b></p>
                                            Se recomienda ingresar al sistema y realizar la actividad encargada.
                                            <br>
                                            <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                            <br><br>
                                            Este correo es informativo por tanto, le pedimos no responda este mensaje.
                                            </p>
                                            </body>
                                            </html>
                                            ');
                                            
                                            //Avisar si fue enviado o no y dirigir al index
                                           
                                            if ($mail->Send()) {
                                            
                                            } else {
    
                                            }
                                            
                        }                
                    }
                }

            if($elabora[0] == 'cargos'){
                $longitud = count($elabora); 
                for($i=0; $i<$longitud; $i++){
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo = '$elabora[$i]' ");
                    while($columna = $nombreuser->fetch_array()){
                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                        $correoResponsable=$columna['correo']; 
                        '<br>';
                        //Create a new PHPMailer instance
                        $mail = new PHPMailer();
                        $mail->IsSMTP();
                        
                        //Configuracion servidor mail
                        require 'correoEnviar/contenido.php';
                        
                        //Agregar destinatario
                        $mail->isHTML(true);
                        $mail->AddAddress($correoResponsable);
                        $mail->Subject = utf8_decode('Encargado para la revisión');
                        //$mail->Body = $_POST['message'];
                        
                        $mail->Body = utf8_decode('
                        <html>
                        <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                        <title>HTML</title>
                        </head>
                        <body>
                        <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                        
                        <p>Estimado (a). <b><em>'.$nombreResponsable.'</em></b>.
                        <br>
                        <p><b>Se le ha asignado la revisión del documento '.$nombreDocEnviar.'.</b></p>
                        Se recomienda ingresar al sistema y realizar la actividad encargada.
                        <br>
                        <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                        <br><br>
                        Este correo es informativo por tanto, le pedimos no responda este mensaje.
                        </p>
                        </body>
                        </html>
                        ');
                        
                        //Avisar si fue enviado o no y dirigir al index
                       
                        if ($mail->Send()) {
                        
                        } else {

                        }
                    }
                }
            }  
    }
    
    if($estado == 'Revisado'){ /// notificar a los elaboradores
        
        //// si viene 1 solo usuario guardamos el campo a modificar
        if($_POST['unicoUsuario'] != NULL){
            if($_POST['cambiarCargo'] != NULL){
                $cargosEnviar=$_POST['cambiarCargo'];
                'cargo cambiado: '.$guardarRol='["cargos","'.$cargosEnviar.'"]';
            }else{
                $usuarioEnviar=$_POST['cambiarUsuario'];
                'usuario cambiado: '.$guardarRol='["usuarios","'.$usuarioEnviar.'"]';
            }
            
            $update=$mysqli->query("UPDATE documento SET apruebaActualizar ='$guardarRol' WHERE id='".$_POST['idDocumento']."' ");
        }
        
        if($_POST['unicoUsuario'] != NULL){
            $elabora=json_decode($guardarRol);
        }else{
            $elabora=json_decode($datosDoc['apruebaActualizar']);
        }
        
        //$elabora=json_decode($datosDoc['apruebaActualizar']);
            if($elabora[0] == 'usuarios'){
                    $longitud = count($elabora); 
                    for($i=0; $i<$longitud; $i++){
                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$elabora[$i]' ");
                        while($columna = $nombreuser->fetch_array()){
                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                         $correoResponsable=$columna['correo']; 
                         '<br>';
                          
                        
    
                                            
    
                                            //Create a new PHPMailer instance
                                            $mail = new PHPMailer();
                                            $mail->IsSMTP();
                                            
                                            //Configuracion servidor mail
                                            require 'correoEnviar/contenido.php';
                                            
                                            //Agregar destinatario
                                            $mail->isHTML(true);
                                            $mail->AddAddress($correoResponsable);
                                            $mail->Subject = utf8_decode('Encargado para la aprobación');
                                            //$mail->Body = $_POST['message'];
                                            
                                            $mail->Body = utf8_decode('
                                            <html>
                                            <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                            <title>HTML</title>
                                            </head>
                                            <body>
                                            <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                                            
                                            <p>Estimado (a). <b><em>'.$nombreResponsable.'</em></b>.
                                            <br>
                                            <p><b>Se le ha asignado la aprobación del documento '.$nombreDocEnviar.'.</b></p>
                                            Se recomienda ingresar al sistema y realizar la actividad encargada.
                                            <br>
                                            <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                            <br><br>
                                            Este correo es informativo por tanto, le pedimos no responda este mensaje.
                                            </p>
                                            </body>
                                            </html>
                                            ');
                                            
                                            //Avisar si fue enviado o no y dirigir al index
                                           
                                            if ($mail->Send()) {
                                            
                                            } else {
    
                                            }
                                            
                        }                
                    }
                }

            if($elabora[0] == 'cargos'){
                $longitud = count($elabora); 
                for($i=0; $i<$longitud; $i++){
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo = '$elabora[$i]' ");
                    while($columna = $nombreuser->fetch_array()){
                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                        $correoResponsable=$columna['correo']; 
                        '<br>';
                        //Create a new PHPMailer instance
                        $mail = new PHPMailer();
                        $mail->IsSMTP();
                        
                        //Configuracion servidor mail
                        require 'correoEnviar/contenido.php';
                        
                        //Agregar destinatario
                        $mail->isHTML(true);
                        $mail->AddAddress($correoResponsable);
                        $mail->Subject = utf8_decode('Encargado para la aprobación');
                        //$mail->Body = $_POST['message'];
                        
                        $mail->Body = utf8_decode('
                        <html>
                        <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                        <title>HTML</title>
                        </head>
                        <body>
                        <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                        
                        <p>Estimado (a). <b><em>'.$nombreResponsable.'</em></b>.
                        <br>
                        <p><b>Se le ha asignado la aprobación del documento '.$nombreDocEnviar.'.</b></p>
                        Se recomienda ingresar al sistema y realizar la actividad encargada.
                        <br>
                        <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                        <br><br>
                        Este correo es informativo por tanto, le pedimos no responda este mensaje.
                        </p>
                        </body>
                        </html>
                        ');
                        
                        //Avisar si fue enviado o no y dirigir al index
                       
                        if ($mail->Send()) {
                        
                        } else {

                        }
                    }
                }
            }  
    }
    
}

//// para la eliminación
if($tipoSolicitud == '3'){
    if($estado == 'Pendiente'){ /// notificar a los elaboradores
        
        //// si viene 1 solo usuario guardamos el campo a modificar
        if($_POST['unicoUsuario'] != NULL){
            if($_POST['cambiarCargo'] != NULL){
                $cargosEnviar=$_POST['cambiarCargo'];
                'cargo cambiado: '.$guardarRol='["cargos","'.$cargosEnviar.'"]';
            }else{
                $usuarioEnviar=$_POST['cambiarUsuario'];
                'usuario cambiado: '.$guardarRol='["usuarios","'.$usuarioEnviar.'"]';
            }
            
            $update=$mysqli->query("UPDATE documento SET elaboraElimanar ='$guardarRol' WHERE id='".$_POST['idDocumento']."' ");
        }
        
        if($_POST['unicoUsuario'] != NULL){
            $elabora=json_decode($guardarRol);
        }else{
            $elabora=json_decode($datosDoc['elaboraElimanar']);
        }
        
        //$elabora=json_decode($datosDoc['elaboraElimanar']);
            if($elabora[0] == 'usuarios'){
                    $longitud = count($elabora); 
                    for($i=0; $i<$longitud; $i++){
                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$elabora[$i]' ");
                        while($columna = $nombreuser->fetch_array()){
                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                         $correoResponsable=$columna['correo']; 
                         '<br>';
                          
                        
    
                                            
    
                                            //Create a new PHPMailer instance
                                            $mail = new PHPMailer();
                                            $mail->IsSMTP();
                                            
                                            //Configuracion servidor mail
                                            require 'correoEnviar/contenido.php';
                                            
                                            //Agregar destinatario
                                            $mail->isHTML(true);
                                            $mail->AddAddress($correoResponsable);
                                            $mail->Subject = utf8_decode('Encargado para la elaboración');
                                            //$mail->Body = $_POST['message'];
                                            
                                            $mail->Body = utf8_decode('
                                            <html>
                                            <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                            <title>HTML</title>
                                            </head>
                                            <body>
                                            <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                                            
                                            <p>Estimado (a). <b><em>'.$nombreResponsable.'</em></b>.
                                            <br>
                                            <p><b>Se le ha asignado la elaboración del documento '.$nombreDocEnviar.'.</b></p>
                                            Se recomienda ingresar al sistema y realizar la actividad encargada.
                                            <br>
                                            <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                            <br><br>
                                            Este correo es informativo por tanto, le pedimos no responda este mensaje.
                                            </p>
                                            </body>
                                            </html>
                                            ');
                                            
                                            //Avisar si fue enviado o no y dirigir al index
                                           
                                            if ($mail->Send()) {
                                            
                                            } else {
    
                                            }
                                            
                        }                
                    }
                }

            if($elabora[0] == 'cargos'){
                $longitud = count($elabora); 
                for($i=0; $i<$longitud; $i++){
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo = '$elabora[$i]' ");
                    while($columna = $nombreuser->fetch_array()){
                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                        $correoResponsable=$columna['correo']; 
                        '<br>';
                        //Create a new PHPMailer instance
                        $mail = new PHPMailer();
                        $mail->IsSMTP();
                        
                        //Configuracion servidor mail
                        require 'correoEnviar/contenido.php';
                        
                        //Agregar destinatario
                        $mail->isHTML(true);
                        $mail->AddAddress($correoResponsable);
                        $mail->Subject = utf8_decode('Encargado para la elaboración');
                        //$mail->Body = $_POST['message'];
                        
                        $mail->Body = utf8_decode('
                        <html>
                        <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                        <title>HTML</title>
                        </head>
                        <body>
                        <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                        
                        <p>Estimado (a). <b><em>'.$nombreResponsable.'</em></b>.
                        <br>
                        <p><b>Se le ha asignado la elaboración del documento '.$nombreDocEnviar.'.</b></p>
                        Se recomienda ingresar al sistema y realizar la actividad encargada.
                        <br>
                        <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                        <br><br>
                        Este correo es informativo por tanto, le pedimos no responda este mensaje.
                        </p>
                        </body>
                        </html>
                        ');
                        
                        //Avisar si fue enviado o no y dirigir al index
                       
                        if ($mail->Send()) {
                        
                        } else {

                        }
                    }
                }
            }  
    } 
    
    if($estado == 'Elaborado'){ /// notificar a los elaboradores
        
        //// si viene 1 solo usuario guardamos el campo a modificar
        if($_POST['unicoUsuario'] != NULL){
            if($_POST['cambiarCargo'] != NULL){
                $cargosEnviar=$_POST['cambiarCargo'];
                'cargo cambiado: '.$guardarRol='["cargos","'.$cargosEnviar.'"]';
            }else{
                $usuarioEnviar=$_POST['cambiarUsuario'];
                'usuario cambiado: '.$guardarRol='["usuarios","'.$usuarioEnviar.'"]';
            }
            
            $update=$mysqli->query("UPDATE documento SET revisaElimanar ='$guardarRol' WHERE id='".$_POST['idDocumento']."' ");
        }
        
        if($_POST['unicoUsuario'] != NULL){
            $elabora=json_decode($guardarRol);
        }else{
            $elabora=json_decode($datosDoc['revisaElimanar']);
        }
        
        //$elabora=json_decode($datosDoc['revisaElimanar']);
            if($elabora[0] == 'usuarios'){
                    $longitud = count($elabora); 
                    for($i=0; $i<$longitud; $i++){
                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$elabora[$i]' ");
                        while($columna = $nombreuser->fetch_array()){
                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                         $correoResponsable=$columna['correo']; 
                         '<br>';
                          
                        
    
                                            
    
                                            //Create a new PHPMailer instance
                                            $mail = new PHPMailer();
                                            $mail->IsSMTP();
                                            
                                            //Configuracion servidor mail
                                            require 'correoEnviar/contenido.php';
                                            
                                            //Agregar destinatario
                                            $mail->isHTML(true);
                                            $mail->AddAddress($correoResponsable);
                                            $mail->Subject = utf8_decode('Encargado para la revisión');
                                            //$mail->Body = $_POST['message'];
                                            
                                            $mail->Body = utf8_decode('
                                            <html>
                                            <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                            <title>HTML</title>
                                            </head>
                                            <body>
                                            <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                                            
                                            <p>Estimado (a). <b><em>'.$nombreResponsable.'</em></b>.
                                            <br>
                                            <p><b>Se le ha asignado la revisión del documento '.$nombreDocEnviar.'.</b></p>
                                            Se recomienda ingresar al sistema y realizar la actividad encargada.
                                            <br>
                                            <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                            <br><br>
                                            Este correo es informativo por tanto, le pedimos no responda este mensaje.
                                            </p>
                                            </body>
                                            </html>
                                            ');
                                            
                                            //Avisar si fue enviado o no y dirigir al index
                                           
                                            if ($mail->Send()) {
                                            
                                            } else {
    
                                            }
                                            
                        }                
                    }
                }

            if($elabora[0] == 'cargos'){
                $longitud = count($elabora); 
                for($i=0; $i<$longitud; $i++){
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo = '$elabora[$i]' ");
                    while($columna = $nombreuser->fetch_array()){
                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                        $correoResponsable=$columna['correo']; 
                        '<br>';
                        //Create a new PHPMailer instance
                        $mail = new PHPMailer();
                        $mail->IsSMTP();
                        
                        //Configuracion servidor mail
                        require 'correoEnviar/contenido.php';
                        
                        //Agregar destinatario
                        $mail->isHTML(true);
                        $mail->AddAddress($correoResponsable);
                        $mail->Subject = utf8_decode('Encargado para la revisión');
                        //$mail->Body = $_POST['message'];
                        
                        $mail->Body = utf8_decode('
                        <html>
                        <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                        <title>HTML</title>
                        </head>
                        <body>
                        <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                        
                        <p>Estimado (a). <b><em>'.$nombreResponsable.'</em></b>.
                        <br>
                        <p><b>Se le ha asignado la revisión del documento '.$nombreDocEnviar.'.</b></p>
                        Se recomienda ingresar al sistema y realizar la actividad encargada.
                        <br>
                        <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                        <br><br>
                        Este correo es informativo por tanto, le pedimos no responda este mensaje.
                        </p>
                        </body>
                        </html>
                        ');
                        
                        //Avisar si fue enviado o no y dirigir al index
                       
                        if ($mail->Send()) {
                        
                        } else {

                        }
                    }
                }
            }  
    }
    
    if($estado == 'Revisado'){ /// notificar a los elaboradores
        
        //// si viene 1 solo usuario guardamos el campo a modificar
        if($_POST['unicoUsuario'] != NULL){
            if($_POST['cambiarCargo'] != NULL){
                $cargosEnviar=$_POST['cambiarCargo'];
                'cargo cambiado: '.$guardarRol='["cargos","'.$cargosEnviar.'"]';
            }else{
                $usuarioEnviar=$_POST['cambiarUsuario'];
                'usuario cambiado: '.$guardarRol='["usuarios","'.$usuarioEnviar.'"]';
            }
            
            $update=$mysqli->query("UPDATE documento SET apruebaElimanar ='$guardarRol' WHERE id='".$_POST['idDocumento']."' ");
        }
        
        if($_POST['unicoUsuario'] != NULL){
            $elabora=json_decode($guardarRol);
        }else{
            $elabora=json_decode($datosDoc['apruebaElimanar']);
        }
        
        //$elabora=json_decode($datosDoc['apruebaElimanar']);
            if($elabora[0] == 'usuarios'){
                    $longitud = count($elabora); 
                    for($i=0; $i<$longitud; $i++){
                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$elabora[$i]' ");
                        while($columna = $nombreuser->fetch_array()){
                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                         $correoResponsable=$columna['correo']; 
                         '<br>';
                          
                        
    
                                            
    
                                            //Create a new PHPMailer instance
                                            $mail = new PHPMailer();
                                            $mail->IsSMTP();
                                            
                                            //Configuracion servidor mail
                                            require 'correoEnviar/contenido.php';
                                            
                                            //Agregar destinatario
                                            $mail->isHTML(true);
                                            $mail->AddAddress($correoResponsable);
                                            $mail->Subject = utf8_decode('Encargado para la aprobación');
                                            //$mail->Body = $_POST['message'];
                                            
                                            $mail->Body = utf8_decode('
                                            <html>
                                            <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                            <title>HTML</title>
                                            </head>
                                            <body>
                                            <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                                            
                                            <p>Estimado (a). <b><em>'.$nombreResponsable.'</em></b>.
                                            <br>
                                            <p><b>Se le ha asignado la aprobación del documento '.$nombreDocEnviar.'.</b></p>
                                            Se recomienda ingresar al sistema y realizar la actividad encargada.
                                            <br>
                                            <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                            <br><br>
                                            Este correo es informativo por tanto, le pedimos no responda este mensaje.
                                            </p>
                                            </body>
                                            </html>
                                            ');
                                            
                                            //Avisar si fue enviado o no y dirigir al index
                                           
                                            if ($mail->Send()) {
                                            
                                            } else {
    
                                            }
                                            
                        }                
                    }
                }

            if($elabora[0] == 'cargos'){
                $longitud = count($elabora); 
                for($i=0; $i<$longitud; $i++){
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo = '$elabora[$i]' ");
                    while($columna = $nombreuser->fetch_array()){
                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                        $correoResponsable=$columna['correo']; 
                        '<br>';
                        //Create a new PHPMailer instance
                        $mail = new PHPMailer();
                        $mail->IsSMTP();
                        
                        //Configuracion servidor mail
                        require 'correoEnviar/contenido.php';
                        
                        //Agregar destinatario
                        $mail->isHTML(true);
                        $mail->AddAddress($correoResponsable);
                        $mail->Subject = utf8_decode('Encargado para la aprobación');
                        //$mail->Body = $_POST['message'];
                        
                        $mail->Body = utf8_decode('
                        <html>
                        <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                        <title>HTML</title>
                        </head>
                        <body>
                        <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                        
                        <p>Estimado (a). <b><em>'.$nombreResponsable.'</em></b>.
                        <br>
                        <p><b>Se le ha asignado la aprobación del documento '.$nombreDocEnviar.'.</b></p>
                        Se recomienda ingresar al sistema y realizar la actividad encargada.
                        <br>
                        <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                        <br><br>
                        Este correo es informativo por tanto, le pedimos no responda este mensaje.
                        </p>
                        </body>
                        </html>
                        ');
                        
                        //Avisar si fue enviado o no y dirigir al index
                       
                        if ($mail->Send()) {
                        
                        } else {

                        }
                    }
                }
            }  
    }
    
}

?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="creacionDocumentalAsignacionVer" method="POST" onsubmit="procesar(this.action);" >
                <input type='hidden' name='idDocumento' value='<?php echo $_POST['idDocumento'];?>' >
                <input type='hidden' name='idSolicitud' value='<?php echo $_POST['idSolicitud'];?>' >
                <input type="hidden" name="validacionAgregar" value="1">
            </form> 
<?php

?>
 <br>
    <center>
                            <style>
                                .preloader {
                                    width: 70px;
                                    height: 70px;
                                    border: 10px solid #eee;
                                    border-top: 10px solid #666;
                                    border-radius: 50%;
                                    animation-name: girar;
                                    animation-duration: 2s;
                                    animation-iteration-count: infinite;
                                    animation-timing-function: linear;
                                    }
                                    @keyframes girar {
                                    from {
                                        transform: rotate(0deg);
                                    }
                                    to {
                                        transform: rotate(360deg);
                                    }
                                    }
                            </style> 
                            <div class="preloader"></div> Cargando
                        </center>