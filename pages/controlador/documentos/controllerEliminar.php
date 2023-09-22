<?php error_reporting(E_ERROR);
date_default_timezone_set("America/Bogota");
require_once '../../conexion/bd.php';
session_start();
error_reporting(E_ERROR);

$rol = $_POST['rol'];
$idUser = $_SESSION["session_username"]; echo"<br>";
$idCargo = $_SESSION["session_cargo"]; echo"<br>";

$idDocumento = $_POST['idDocumento']; echo"<br>";
$nombreDoc = $_POST['nombreDocumento']; echo"<br>";

if(isset($_POST['eliminarDoc'])){
    
    $queryDoc = $mysqli->query("SELECT * FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
    $datosDoc = $queryDoc->fetch_assoc();
    
    
    $idDocumento = $_POST['idDocumento'];
    $nombreDoc = utf8_decode($_POST['nombreDocumento']);
    $nombreDocEnviar = utf8_encode($nombreDoc); /// enviar al correo
    $norma = unserialize($_POST['norma']);
    $norma = json_encode($norma);
    $proceso = $_POST['proceso'];
    $metodo = $_POST['rad_metodo'];
    $tipoDoc = $_POST['tipoDoc'];
    $ubicacion = utf8_decode($_POST['ubicacion']);
    $elabora = unserialize($_POST['select_encargadoE']);
    $elaboraN = unserialize($_POST['select_encargadoE']); /// quien elabora
    $radElabora = $_POST['radiobtnE'];
    array_unshift($elabora,$radElabora);
    $elabora = json_encode($elabora);
    $revisa = unserialize($_POST['select_encargadoR']);
    $revisaN = unserialize($_POST['select_encargadoR']); // quien revisa
    $radRevisa = $_POST['radiobtnR'];
    array_unshift($revisa,$radRevisa);
    $revisa = json_encode($revisa);
    $aprueba = unserialize($_POST['select_encargadoA']);
    $apruebaA = unserialize($_POST['select_encargadoA']); // quien aprueba
    $enviarVariableAprobador=$apruebaA; // se crea esta variable apra evitar la interrupción de los datos enviados para la notificacipon correo
    $radAprueba = $_POST['radiobtnA'];
    array_unshift($aprueba,$radAprueba);
    $aprueba = json_encode($aprueba);
    
    
    //Datos del segundo fomulario crearDocumento2
    $documentosExternos = unserialize($_POST['documentos_externos']);
    $documentosExternos = json_encode($documentosExternos);
    $definiciones = unserialize($_POST['definiciones']);
    $definiciones = json_encode($definiciones);
    $archivoGestion = $_POST['archivo_gestion'];
    $archivoCentral = $_POST['archivo_central'];
    $archivoHistorico = $_POST['archivo_historico'];
    $dispoDocumental = $_POST['diposicion_documental']; //Disposicon documental
    $escargadoDispo = unserialize($_POST['select_encargadoD']);
    $radDispoDoc = $_POST['radiobtnD'];
    array_unshift($escargadoDispo,$radDispoDoc); 
    $escargadoDispo = json_encode($escargadoDispo);
    
    $editorHtml = $_POST['editorHtml'];
    $nombrePDF = $_POST['nombrePDF']; 
    $nombreOtro = $_POST['nombreOtro'];
    
    
    //Datos tercer formulario crearDocumento3
    $aprovacionRegistros = $_POST['radiobtn'];
    $radArpeuevaRegistros = $_POST['radiobtnAR'];
    //array_unshift($_POST['select_encargadoAR'],$radArpeuevaRegistros); 
    $select_encargadoAR = json_encode($_POST['select_encargadoAR']);
    
    $flujoAprovacion = $_POST['rad_flujo'];
    $mesesRevision = $_POST['mesesRevision'];
    $controlCambios = utf8_decode($_POST['controlCambios']);
    $radioAprobado = $_POST['radiobtnAprobado'];
    
    
    //Validciones de flujo para la aprobacion

    //echo "Elabora".$elaboraf = json_decode($elabora);
    //echo "Revisa".$revisaf  = json_decode($revisa);
    //echo "Aprueba".$apruebaf = json_decode($aprueba);
    
    ///Validar en que estado esta para continuar el flujo 
    $queryDoc1 = $mysqli->query("SELECT * FROM documento WHERE id = '$idDocumento'")or die(mysqli_error($mysqli));
    $datosDoc1 = $queryDoc1->fetch_assoc();
    
    
    
    $estadoActual = $datosDoc1['estadoElimina'];
    
    $aprobado_elabora = 0;
    $aprobado_revisa = 0;
    $aprobado_aprueba = 0;
    
   $mysqli->query("UPDATE documento SET asumeFlujo=NULL, tipoSolicitud='3' WHERE id = '$idDocumento' ")or die(mysqli_error($mysqli));
    
    if($estadoActual == NULL || $estadoActual == 'Rechazado'){
        if($radioAprobado == 'rechazado' && $flujoAprovacion == 'reinicia'){
            $estado = "Rechazado";
        }elseif($radioAprobado == 'rechazado' && $flujoAprovacion == 'cierra'){
            $estado = "Rechazado";
        }else{
            $estado = "Pendiente";
        }
        //$estado = "Pendiente";
    }
    
    
    
     require '../usuarios/libreria/PHPMailerAutoload.php';
    
    if($estadoActual == NULL){
        if($radioAprobado == 'rechazado' && $flujoAprovacion == 'cierra'){
            
            $estado = "Rechazado";
            $aprobado_elabora = 0;
            $fechaCierre = date("Y/m/j");
            $idSolicitud = $datosDoc1['id_solicitud'];
            $mysqli->query("UPDATE solicitudDocumentos SET estado = '$estado', fechaCierre = '$fechaCierre' WHERE id = $idSolicitud ")or die(mysqli_error($mysqli));
            $mysqli->query("UPDATE documento SET estadoElimina = NULL, elaboraElimanar = NULL, revisaElimanar = NULL, apruebaElimanar = NULL, asumeFlujo = NULL WHERE id =  $idDocumento");
            
            
            $mysqli->query("DELETE FROM `controlCambios` WHERE idRespaldo='".$_POST['idDocumento']."' AND tipoSolicitud='3' ");
            
            $envioCorreoEncargado=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE id='$idSolicitud' ");
                    $extraerEnvioCorreoEncargado=$envioCorreoEncargado->fetch_array(MYSQLI_ASSOC);
                    'Quien aprueba: '.$notificarEncargado=$extraerEnvioCorreoEncargado['QuienAprueba'];
                    'Quien aprueba: '.$notificarEncargadoQuienS=$extraerEnvioCorreoEncargado['quienSolicita'];
                    $nombreDocumento2=utf8_encode($extraerEnvioCorreoEncargado['nombreDocumento2']);
        
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$notificarEncargado' ");
                    $columna = $nombreuser->fetch_array();
                    $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                     $correoResponsable=$columna['correo']; 
                     '<br>';
                      
                    
                                        //Create a new PHPMailer instance
                                        $mail = new PHPMailer();
                                        $mail->IsSMTP();
                                        
                                        //Configuracion servidor mail
                                        require '../../correoEnviar/contenido.php';
                                        
                                        //Agregar destinatario
                                        $mail->isHTML(true);
                                        $mail->AddAddress($correoResponsable);
                                        $mail->Subject = utf8_decode('Documento cerrado - encargado');
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
                                        <p><b>El documento '.$nombreDocumento2.' fue cerrada.</b></p>
                                        
                                        <br>
                                        <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                        <br><br>
                                        Este correo es informativo y por tanto, le pedimos no responda este mensaje.
                                        </p>
                                        </body>
                                        </html>
                                        ');
                                        
                                        //Avisar si fue enviado o no y dirigir al index
                                       
                                        if ($mail->Send()) {
                                        
                                        } else {

                                        }
                                        
                                        $nombreuser2 = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$notificarEncargadoQuienS' ");
                                        $columna2 = $nombreuser2->fetch_array();
                                        $nombreResponsable2=utf8_encode($columna2['nombres'].' '.$columna2['apellidos']); 
                                         $correoResponsable=$columna2['correo']; 
                                         '<br>';
                      
                    
                                        //Create a new PHPMailer instance
                                        $mail = new PHPMailer();
                                        $mail->IsSMTP();
                                        
                                        //Configuracion servidor mail
                                        require '../../correoEnviar/contenido.php';
                                        
                                        //Agregar destinatario
                                        $mail->isHTML(true);
                                        $mail->AddAddress($correoResponsable);
                                        $mail->Subject = utf8_decode('Documento cerrado - solicitante');
                                        //$mail->Body = $_POST['message'];
                                        
                                        $mail->Body = utf8_decode('
                                        <html>
                                        <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                        <title>HTML</title>
                                        </head>
                                        <body>
                                        <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                                        
                                        <p>Estimado (a). <b><em>'.$nombreResponsable2.'</em></b>.
                                        <br>
                                        <p><b>El documento '.$nombreDocumento2.' fue cerrado.</b></p>
                                        
                                        <br>
                                        <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                        <br><br>
                                        Este correo es informativo y por tanto, le pedimos no responda este mensaje.
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
    
    
    /// consulta de id del suaurio
    $consulta_id_usuario=$mysqli->query("SELECT id,cedula FROM usuario WHERE cedula='$idUser' ");
    $exraer_consulta_id_usuario=$consulta_id_usuario->fetch_array(MYSQLI_ASSOC);
    $idEnviarUsuario=$exraer_consulta_id_usuario['id'];
    
    if($estadoActual == "Pendiente"){
        
        if($radioAprobado == 'aprobado' && $flujoAprovacion == 'reinicia'){
            $estado = "Elaborado";
            $aprobado_elabora = 1;
        }
        
        if($radioAprobado == 'aprobado' && $flujoAprovacion == 'ajusta'){
            //// guardamos la persona que lo elaboro
            $mysqli->query("UPDATE documento SET elaborado='$idEnviarUsuario' WHERE id ='$idDocumento' ");
            $estado = "Elaborado";
            $aprobado_elabora = 1;
        }
        
        if($radioAprobado == 'aprobado' && $flujoAprovacion == 'cierra'){
            $estado = "Elaborado";
            $aprobado_elabora = 1;
        }
        
        if($radioAprobado == 'rechazado' && $flujoAprovacion == 'reinicia'){
            $estado = "Rechazado"; //Pendiente
            $aprobado_elabora = 0;
        }
        
        if($radioAprobado == 'rechazado' && $flujoAprovacion == 'ajusta'){
            $estado = "Elaborado";
            $aprobado_elabora = 1;
        }
        
        if($radioAprobado == 'rechazado' && $flujoAprovacion == 'cierra'){
            $estado = "Rechazado";
            $aprobado_elabora = 0;
            $fechaCierre = date("Y/m/j");
            $idSolicitud = $datosDoc1['id_solicitud'];
            $mysqli->query("UPDATE solicitudDocumentos SET estado = '$estado', fechaCierre = '$fechaCierre' WHERE id = $idSolicitud ")or die(mysqli_error($mysqli));
            $mysqli->query("UPDATE documento SET estadoElimina = NULL, elaboraElimanar = NULL, revisaElimanar = NULL, apruebaElimanar = NULL, asumeFlujo = NULL WHERE id =  $idDocumento");
            
            
            $mysqli->query("DELETE FROM `controlCambios` WHERE idRespaldo='".$_POST['idDocumento']."' AND tipoSolicitud='3' ");
            
            $envioCorreoEncargado=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE id='$idSolicitud' ");
                    $extraerEnvioCorreoEncargado=$envioCorreoEncargado->fetch_array(MYSQLI_ASSOC);
                    'Quien aprueba: '.$notificarEncargado=$extraerEnvioCorreoEncargado['QuienAprueba'];
                    'Quien aprueba: '.$notificarEncargadoQuienS=$extraerEnvioCorreoEncargado['quienSolicita'];
                    $nombreDocumento2=utf8_encode($extraerEnvioCorreoEncargado['nombreDocumento2']);
        
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$notificarEncargado' ");
                    $columna = $nombreuser->fetch_array();
                    $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                     $correoResponsable=$columna['correo']; 
                     '<br>';
                      
                    
                                        //Create a new PHPMailer instance
                                        $mail = new PHPMailer();
                                        $mail->IsSMTP();
                                        
                                        //Configuracion servidor mail
                                        require '../../correoEnviar/contenido.php';
                                        
                                        //Agregar destinatario
                                        $mail->isHTML(true);
                                        $mail->AddAddress($correoResponsable);
                                        $mail->Subject = utf8_decode('Documento cerrado - encargado');
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
                                        <p><b>El documento '.$nombreDocumento2.' fue cerrada.</b></p>
                                        
                                        <br>
                                        <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                        <br><br>
                                        Este correo es informativo y por tanto, le pedimos no responda este mensaje.
                                        </p>
                                        </body>
                                        </html>
                                        ');
                                        
                                        //Avisar si fue enviado o no y dirigir al index
                                       
                                        if ($mail->Send()) {
                                        
                                        } else {

                                        }
                                        
                                        $nombreuser2 = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$notificarEncargadoQuienS' ");
                                        $columna2 = $nombreuser2->fetch_array();
                                        $nombreResponsable2=utf8_encode($columna2['nombres'].' '.$columna2['apellidos']); 
                                         $correoResponsable=$columna2['correo']; 
                                         '<br>';
                      
                    
                                        //Create a new PHPMailer instance
                                        $mail = new PHPMailer();
                                        $mail->IsSMTP();
                                        
                                        //Configuracion servidor mail
                                        require '../../correoEnviar/contenido.php';
                                        
                                        //Agregar destinatario
                                        $mail->isHTML(true);
                                        $mail->AddAddress($correoResponsable);
                                        $mail->Subject = utf8_decode('Documento cerrado - solicitante');
                                        //$mail->Body = $_POST['message'];
                                        
                                        $mail->Body = utf8_decode('
                                        <html>
                                        <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                        <title>HTML</title>
                                        </head>
                                        <body>
                                        <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                                        
                                        <p>Estimado (a). <b><em>'.$nombreResponsable2.'</em></b>.
                                        <br>
                                        <p><b>El documento '.$nombreDocumento2.' fue cerrado.</b></p>
                                        
                                        <br>
                                        <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                        <br><br>
                                        Este correo es informativo y por tanto, le pedimos no responda este mensaje.
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

 
    if($estadoActual == "Elaborado"){

        if($radioAprobado == 'aprobado' && $flujoAprovacion == 'reinicia'){
            $estado = "Revisado";
            $aprobado_revisa = 1;
        }
        
        if($radioAprobado == 'aprobado' && $flujoAprovacion == 'ajusta'){
            //// guardamos la persona que lo reviso
            $mysqli->query("UPDATE documento SET revisadoo='$idEnviarUsuario' WHERE id ='$idDocumento' ");
            $estado = "Revisado";
            $aprobado_revisa = 1;
        }
        
        if($radioAprobado == 'aprobado' && $flujoAprovacion == 'cierra'){
            
            $estado = "Revisado";
            $aprobado_revisa = 1;
        }
        
        if($radioAprobado == 'rechazado' && $flujoAprovacion == 'reinicia'){
            $estado = "Pendiente";
            $aprobado_revisa = 0;
        }
        
        if($radioAprobado == 'rechazado' && $flujoAprovacion == 'ajusta'){
            $estado = "Revisado";
            $aprobado_revisa = 1;
        }
        
        if($radioAprobado == 'rechazado' && $flujoAprovacion == 'cierra'){
            $estado = "Rechazado";
            $aprobado_revisa = 0;
            $fechaCierre = date("Y/m/j");
            $idSolicitud = $datosDoc1['id_solicitud'];
            $mysqli->query("UPDATE solicitudDocumentos SET estado = '$estado', fechaCierre = '$fechaCierre' WHERE id = $idSolicitud ")or die(mysqli_error($mysqli));
            $mysqli->query("UPDATE documento SET estadoElimina = NULL, elaboraElimanar = NULL, revisaElimanar = NULL, apruebaElimanar = NULL, asumeFlujo = NULL WHERE id =  $idDocumento");
        
            $mysqli->query("DELETE FROM `controlCambios` WHERE idRespaldo='".$_POST['idDocumento']."' AND tipoSolicitud='3' ");
            
            $envioCorreoEncargado=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE id='$idSolicitud' ");
                    $extraerEnvioCorreoEncargado=$envioCorreoEncargado->fetch_array(MYSQLI_ASSOC);
                    'Quien aprueba: '.$notificarEncargado=$extraerEnvioCorreoEncargado['QuienAprueba'];
                    'Quien aprueba: '.$notificarEncargadoQuienS=$extraerEnvioCorreoEncargado['quienSolicita'];
                    $nombreDocumento2=utf8_encode($extraerEnvioCorreoEncargado['nombreDocumento2']);
        
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$notificarEncargado' ");
                    $columna = $nombreuser->fetch_array();
                    $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                     $correoResponsable=$columna['correo']; 
                     '<br>';
                      
                    
                                        //Create a new PHPMailer instance
                                        $mail = new PHPMailer();
                                        $mail->IsSMTP();
                                        
                                        //Configuracion servidor mail
                                        require '../../correoEnviar/contenido.php';
                                        
                                        //Agregar destinatario
                                        $mail->isHTML(true);
                                        $mail->AddAddress($correoResponsable);
                                        $mail->Subject = utf8_decode('Documento cerrado - encargado ');
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
                                        <p><b>El documento '.$nombreDocumento2.' fue cerrado.</b></p>
                                        
                                        <br>
                                        <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                        <br><br>
                                        Este correo es informativo y por tanto, le pedimos no responda este mensaje.
                                        </p>
                                        </body>
                                        </html>
                                        ');
                                        
                                        //Avisar si fue enviado o no y dirigir al index
                                       
                                        if ($mail->Send()) {
                                        
                                        } else {

                                        }
                                        
                                        $nombreuser2 = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$notificarEncargadoQuienS' ");
                                        $columna2 = $nombreuser2->fetch_array();
                                        $nombreResponsable2=utf8_encode($columna2['nombres'].' '.$columna2['apellidos']); 
                                         $correoResponsable=$columna2['correo']; 
                                         '<br>';
                      
                    
                                        //Create a new PHPMailer instance
                                        $mail = new PHPMailer();
                                        $mail->IsSMTP();
                                        
                                        //Configuracion servidor mail
                                        require '../../correoEnviar/contenido.php';
                                        
                                        //Agregar destinatario
                                        $mail->isHTML(true);
                                        $mail->AddAddress($correoResponsable);
                                        $mail->Subject = utf8_decode('Documento cerrado - solicitante');
                                        //$mail->Body = $_POST['message'];
                                        
                                        $mail->Body = utf8_decode('
                                        <html>
                                        <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                        <title>HTML</title>
                                        </head>
                                        <body>
                                        <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                                        
                                        <p>Estimado (a). <b><em>'.$nombreResponsable2.'</em></b>.
                                        <br>
                                        <p><b>El documento '.$nombreDocumento2.' fue cerrado.</b></p>
                                        
                                        <br>
                                        <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                        <br><br>
                                        Este correo es informativo y por tanto, le pedimos no responda este mensaje.
                                        </p>
                                        </body>
                                        </html>
                                        ');
                                        
                                        //Avisar si fue enviado o no y dirigir al index
                                       
                                        if ($mail->Send()) {
                                        
                                        } else {

                                        }
            
            
          
             if($radElabora == 'usuarios'){
                $longitud = count($elaboraN); 
                for($i=0; $i<$longitud; $i++){
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$elaboraN[$i]' ");
                    while($columna = $nombreuser->fetch_array()){
                    $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                     $correoResponsable=$columna['correo']; 
                     '<br>';
                      
                    

                                        

                                        //Create a new PHPMailer instance
                                        $mail = new PHPMailer();
                                        $mail->IsSMTP();
                                        
                                        //Configuracion servidor mail
                                        require '../../correoEnviar/contenido.php';
                                        
                                        //Agregar destinatario
                                        $mail->isHTML(true);
                                        $mail->AddAddress($correoResponsable);
                                        $mail->Subject = utf8_decode('Documento cerrado - elaborador ');
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
                                           <p><b>El documento '.$nombreDocumento2.' fue cerrado.</b></p>
                                        <br>
                                        <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                        <br><br>
                                        Este correo es informativo y por tanto, le pedimos no responda este mensaje.
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

            if($radElabora == 'cargos'){
                 'Cargos';
                $longitud = count($elaboraN); 
                for($i=0; $i<$longitud; $i++){
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo = '$elaboraN[$i]' ");
                    while($columna = $nombreuser->fetch_array()){
                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                        $correoResponsable=$columna['correo']; 
                        '<br>';
                        //Create a new PHPMailer instance
                        $mail = new PHPMailer();
                        $mail->IsSMTP();
                        
                        //Configuracion servidor mail
                        require '../../correoEnviar/contenido.php';
                        
                        //Agregar destinatario
                        $mail->isHTML(true);
                        $mail->AddAddress($correoResponsable);
                        $mail->Subject = utf8_decode('Documento cerrado - elaborador ');
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
                           <p><b>El documento '.$nombreDocumento2.' fue cerrado.</b></p>
                        <br>
                        <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                        <br><br>
                        Este correo es informativo y por tanto, le pedimos no responda este mensaje.
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
    
    if($estadoActual == "Revisado"){
        
        if($radioAprobado == 'aprobado' && $flujoAprovacion == 'reinicia'){
            $estado = "Aprobado";
            $aprobado_aprueba = 1;
        }
        
        if($radioAprobado == 'aprobado' && $flujoAprovacion == 'ajusta'){
             //// guardamos la persona que lo elaaprueba
            $mysqli->query("UPDATE documento SET aprobado='$idEnviarUsuario' WHERE id ='$idDocumento' ");
            $estado = "Aprobado";
            $aprobado_aprueba = 1;
            
             $idSolicitud = $datosDoc1['id_solicitud'];
               
             $envioCorreoEncargado=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE id='$idSolicitud' ");
                    $extraerEnvioCorreoEncargado=$envioCorreoEncargado->fetch_array(MYSQLI_ASSOC);
                    'Quien aprueba: '.$notificarEncargado=$extraerEnvioCorreoEncargado['QuienAprueba'];
                    'Quien aprueba: '.$notificarEncargadoQuienS=$extraerEnvioCorreoEncargado['quienSolicita'];
                    $nombreDocumento2=utf8_encode($extraerEnvioCorreoEncargado['nombreDocumento2']);
        
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$notificarEncargado' ");
                    $columna = $nombreuser->fetch_array();
                    $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                     $correoResponsable=$columna['correo']; 
                     '<br>';
                      
                    
                                        //Create a new PHPMailer instance
                                        $mail = new PHPMailer();
                                        $mail->IsSMTP();
                                        
                                        //Configuracion servidor mail
                                        require '../../correoEnviar/contenido.php';
                                        
                                        //Agregar destinatario
                                        $mail->isHTML(true);
                                        $mail->AddAddress($correoResponsable);
                                        $mail->Subject = utf8_decode('Documento eliminado - encargado ');
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
                                        <p><b>El documento '.$nombreDocumento2.' fue eliminado.</b></p>
                                        
                                        <br>
                                        <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                        <br><br>
                                        Este correo es informativo y por tanto, le pedimos no responda este mensaje.
                                        </p>
                                        </body>
                                        </html>
                                        ');
                                        
                                        //Avisar si fue enviado o no y dirigir al index
                                       
                                        if ($mail->Send()) {
                                        
                                        } else {

                                        }
                                        
                                        $nombreuser2 = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$notificarEncargadoQuienS' ");
                                        $columna2 = $nombreuser2->fetch_array();
                                        $nombreResponsable2=utf8_encode($columna2['nombres'].' '.$columna2['apellidos']); 
                                         $correoResponsable=$columna2['correo']; 
                                         '<br>';
                      
                    
                                        //Create a new PHPMailer instance
                                        $mail = new PHPMailer();
                                        $mail->IsSMTP();
                                        
                                        //Configuracion servidor mail
                                        require '../../correoEnviar/contenido.php';
                                        
                                        //Agregar destinatario
                                        $mail->isHTML(true);
                                        $mail->AddAddress($correoResponsable);
                                        $mail->Subject = utf8_decode('Documento eliminado - solicitante');
                                        //$mail->Body = $_POST['message'];
                                        
                                        $mail->Body = utf8_decode('
                                        <html>
                                        <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                        <title>HTML</title>
                                        </head>
                                        <body>
                                        <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                                        
                                        <p>Estimado (a). <b><em>'.$nombreResponsable2.'</em></b>.
                                        <br>
                                        <p><b>El documento '.$nombreDocumento2.' fue eliminado.</b></p>
                                        
                                        <br>
                                        <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                        <br><br>
                                        Este correo es informativo y por tanto, le pedimos no responda este mensaje.
                                        </p>
                                        </body>
                                        </html>
                                        ');
                                        
                                        //Avisar si fue enviado o no y dirigir al index
                                       
                                        if ($mail->Send()) {
                                        
                                        } else {

                                        }
            
            
          
            if($radElabora == 'usuarios'){
                $longitud = count($elaboraN); 
                for($i=0; $i<$longitud; $i++){
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$elaboraN[$i]' ");
                    while($columna = $nombreuser->fetch_array()){
                    $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                     $correoResponsable=$columna['correo']; 
                     '<br>';
                      
                    

                                        

                                        //Create a new PHPMailer instance
                                        $mail = new PHPMailer();
                                        $mail->IsSMTP();
                                        
                                        //Configuracion servidor mail
                                        require '../../correoEnviar/contenido.php';
                                        
                                        //Agregar destinatario
                                        $mail->isHTML(true);
                                        $mail->AddAddress($correoResponsable);
                                        $mail->Subject = utf8_decode('Documento eliminado - elaborador ');
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
                                           <p><b>El documento '.$nombreDocumento2.' fue eliminado.</b></p>
                                        <br>
                                        <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                        <br><br>
                                        Este correo es informativo y por tanto, le pedimos no responda este mensaje.
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

            if($radElabora == 'cargos'){
                 'Cargos';
                $longitud = count($elaboraN); 
                for($i=0; $i<$longitud; $i++){
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo = '$elaboraN[$i]' ");
                    while($columna = $nombreuser->fetch_array()){
                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                        $correoResponsable=$columna['correo']; 
                        '<br>';
                        //Create a new PHPMailer instance
                        $mail = new PHPMailer();
                        $mail->IsSMTP();
                        
                        //Configuracion servidor mail
                        require '../../correoEnviar/contenido.php';
                        
                        //Agregar destinatario
                        $mail->isHTML(true);
                        $mail->AddAddress($correoResponsable);
                        $mail->Subject = utf8_decode('Documento eliminado - elaborador ');
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
                           <p><b>El documento '.$nombreDocumento2.' fue eliminado.</b></p>
                        <br>
                        <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                        <br><br>
                        Este correo es informativo y por tanto, le pedimos no responda este mensaje.
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
            
            
             if($radRevisa == 'usuarios'){
                $longitud = count($revisaN); 
                for($i=0; $i<$longitud; $i++){
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$revisaN[$i]' ");
                   while($columna = $nombreuser->fetch_array()){
                    $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                     $correoResponsable=$columna['correo']; 
                     '<br>';
                      
                    

                                        

                                        //Create a new PHPMailer instance
                                        $mail = new PHPMailer();
                                        $mail->IsSMTP();
                                        
                                        //Configuracion servidor mail
                                        require '../../correoEnviar/contenido.php';
                                        
                                        //Agregar destinatario
                                        $mail->isHTML(true);
                                        $mail->AddAddress($correoResponsable);
                                        $mail->Subject = utf8_decode('Documento eliminado - revisor');
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
                                        <p><b>El documento '.$nombreDocumento2.' fue eliminado.</b></p>
                                        <br>
                                        <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                        <br><br>
                                        Este correo es informativo y por tanto, le pedimos no responda este mensaje.
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

            if($radRevisa == 'cargos'){
                 'Cargos';
                $longitud = count($revisaN); 
                for($i=0; $i<$longitud; $i++){
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo = '$revisaN[$i]' ");
                    while($columna = $nombreuser->fetch_array()){
                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                        $correoResponsable=$columna['correo']; 
                        '<br>';
                        //Create a new PHPMailer instance
                        $mail = new PHPMailer();
                        $mail->IsSMTP();
                        
                        //Configuracion servidor mail
                        require '../../correoEnviar/contenido.php';
                        
                        //Agregar destinatario
                        $mail->isHTML(true);
                        $mail->AddAddress($correoResponsable);
                        $mail->Subject = utf8_decode('Documento eliminado - revisor');
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
                        <p><b>El documento '.$nombreDocumento2.' fue eliminado.</b></p>
                        <br>
                        <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                        <br><br>
                        Este correo es informativo y por tanto, le pedimos no responda este mensaje.
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
        
        if($radioAprobado == 'aprobado' && $flujoAprovacion == 'cierra'){
            $estado = "Aprobado";
            $aprobado_aprueba = 1;
        }
        
        if($radioAprobado == 'rechazado' && $flujoAprovacion == 'reinicia'){
            $estado = "Elaborado"; //Pendiente
            $aprobado_aprueba = 0;
        }
        
        if($radioAprobado == 'rechazado' && $flujoAprovacion == 'ajusta'){
            $estado = "Revisado";
            $aprobado_aprueba = 1;
        }
        
        if($radioAprobado == 'rechazado' && $flujoAprovacion == 'cierra'){
            $estado = "Rechazado";
            $aprobado_aprueba = 0;
            $fechaCierre = date("Y/m/j");
            $idSolicitud = $datosDoc1['id_solicitud'];
            $mysqli->query("UPDATE solicitudDocumentos SET estado = '$estado', fechaCierre = '$fechaCierre' WHERE id = $idSolicitud ")or die(mysqli_error($mysqli));
            $mysqli->query("UPDATE documento SET estadoElimina = NULL, elaboraElimanar = NULL, revisaElimanar = NULL, apruebaElimanar = NULL, asumeFlujo = NULL WHERE id =  $idDocumento");
        
            $mysqli->query("DELETE FROM `controlCambios` WHERE idRespaldo='".$_POST['idDocumento']."' AND tipoSolicitud='3' ");
            
            $envioCorreoEncargado=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE id='$idSolicitud' ");
                    $extraerEnvioCorreoEncargado=$envioCorreoEncargado->fetch_array(MYSQLI_ASSOC);
                    'Quien aprueba: '.$notificarEncargado=$extraerEnvioCorreoEncargado['QuienAprueba'];
                    'Quien aprueba: '.$notificarEncargadoQuienS=$extraerEnvioCorreoEncargado['quienSolicita'];
                    $nombreDocumento2=utf8_encode($extraerEnvioCorreoEncargado['nombreDocumento2']);
        
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$notificarEncargado' ");
                    $columna = $nombreuser->fetch_array();
                    $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                     $correoResponsable=$columna['correo']; 
                     '<br>';
                      
                    
                                        //Create a new PHPMailer instance
                                        $mail = new PHPMailer();
                                        $mail->IsSMTP();
                                        
                                        //Configuracion servidor mail
                                        require '../../correoEnviar/contenido.php';
                                        
                                        //Agregar destinatario
                                        $mail->isHTML(true);
                                        $mail->AddAddress($correoResponsable);
                                        $mail->Subject = utf8_decode('Documento cerrado - encargado ');
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
                                        <p><b>El documento '.$nombreDocumento2.' fue cerrado.</b></p>
                                        
                                        <br>
                                        <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                        <br><br>
                                        Este correo es informativo y por tanto, le pedimos no responda este mensaje.
                                        </p>
                                        </body>
                                        </html>
                                        ');
                                        
                                        //Avisar si fue enviado o no y dirigir al index
                                       
                                        if ($mail->Send()) {
                                        
                                        } else {

                                        }
                                        
                                        $nombreuser2 = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$notificarEncargadoQuienS' ");
                                        $columna2 = $nombreuser2->fetch_array();
                                        $nombreResponsable2=utf8_encode($columna2['nombres'].' '.$columna2['apellidos']); 
                                         $correoResponsable=$columna2['correo']; 
                                         '<br>';
                      
                    
                                        //Create a new PHPMailer instance
                                        $mail = new PHPMailer();
                                        $mail->IsSMTP();
                                        
                                        //Configuracion servidor mail
                                        require '../../correoEnviar/contenido.php';
                                        
                                        //Agregar destinatario
                                        $mail->isHTML(true);
                                        $mail->AddAddress($correoResponsable);
                                        $mail->Subject = utf8_decode('Documento cerrado - solicitante');
                                        //$mail->Body = $_POST['message'];
                                        
                                        $mail->Body = utf8_decode('
                                        <html>
                                        <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                        <title>HTML</title>
                                        </head>
                                        <body>
                                        <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                                        
                                        <p>Estimado (a). <b><em>'.$nombreResponsable2.'</em></b>.
                                        <br>
                                        <p><b>El documento '.$nombreDocumento2.' fue cerrado.</b></p>
                                        
                                        <br>
                                        <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                        <br><br>
                                        Este correo es informativo y por tanto, le pedimos no responda este mensaje.
                                        </p>
                                        </body>
                                        </html>
                                        ');
                                        
                                        //Avisar si fue enviado o no y dirigir al index
                                       
                                        if ($mail->Send()) {
                                        
                                        } else {

                                        }
            
            
          
            if($radElabora == 'usuarios'){
                $longitud = count($elaboraN); 
                for($i=0; $i<$longitud; $i++){
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$elaboraN[$i]' ");
                    while($columna = $nombreuser->fetch_array()){
                    $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                     $correoResponsable=$columna['correo']; 
                     '<br>';
                      
                    

                                        

                                        //Create a new PHPMailer instance
                                        $mail = new PHPMailer();
                                        $mail->IsSMTP();
                                        
                                        //Configuracion servidor mail
                                        require '../../correoEnviar/contenido.php';
                                        
                                        //Agregar destinatario
                                        $mail->isHTML(true);
                                        $mail->AddAddress($correoResponsable);
                                        $mail->Subject = utf8_decode('Documento cerrado - elaborador ');
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
                                           <p><b>El documento '.$nombreDocumento2.' fue cerrado.</b></p>
                                        <br>
                                        <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                        <br><br>
                                        Este correo es informativo y por tanto, le pedimos no responda este mensaje.
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

            if($radElabora == 'cargos'){
                 'Cargos';
                $longitud = count($elaboraN); 
                for($i=0; $i<$longitud; $i++){
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo = '$elaboraN[$i]' ");
                    while($columna = $nombreuser->fetch_array()){
                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                        $correoResponsable=$columna['correo']; 
                        '<br>';
                        //Create a new PHPMailer instance
                        $mail = new PHPMailer();
                        $mail->IsSMTP();
                        
                        //Configuracion servidor mail
                        require '../../correoEnviar/contenido.php';
                        
                        //Agregar destinatario
                        $mail->isHTML(true);
                        $mail->AddAddress($correoResponsable);
                        $mail->Subject = utf8_decode('Documento cerrado - elaborador ');
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
                           <p><b>El documento '.$nombreDocumento2.' fue cerrado.</b></p>
                        <br>
                        <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                        <br><br>
                        Este correo es informativo y por tanto, le pedimos no responda este mensaje.
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
            
            
             if($radRevisa == 'usuarios'){
                $longitud = count($revisaN); 
                for($i=0; $i<$longitud; $i++){
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$revisaN[$i]' ");
                   while($columna = $nombreuser->fetch_array()){
                    $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                     $correoResponsable=$columna['correo']; 
                     '<br>';
                      
                    

                                        

                                        //Create a new PHPMailer instance
                                        $mail = new PHPMailer();
                                        $mail->IsSMTP();
                                        
                                        //Configuracion servidor mail
                                        require '../../correoEnviar/contenido.php';
                                        
                                        //Agregar destinatario
                                        $mail->isHTML(true);
                                        $mail->AddAddress($correoResponsable);
                                        $mail->Subject = utf8_decode('Documento cerrado - revisor');
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
                                        <p><b>El documento '.$nombreDocumento2.' fue cerrado.</b></p>
                                        <br>
                                        <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                        <br><br>
                                        Este correo es informativo y por tanto, le pedimos no responda este mensaje.
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

            if($radRevisa == 'cargos'){
                 'Cargos';
                $longitud = count($revisaN); 
                for($i=0; $i<$longitud; $i++){
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo = '$revisaN[$i]' ");
                    while($columna = $nombreuser->fetch_array()){
                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                        $correoResponsable=$columna['correo']; 
                        '<br>';
                        //Create a new PHPMailer instance
                        $mail = new PHPMailer();
                        $mail->IsSMTP();
                        
                        //Configuracion servidor mail
                        require '../../correoEnviar/contenido.php';
                        
                        //Agregar destinatario
                        $mail->isHTML(true);
                        $mail->AddAddress($correoResponsable);
                        $mail->Subject = utf8_decode('Documento cerrado - revisor');
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
                        <p><b>El documento '.$nombreDocumento2.' fue cerrado.</b></p>
                        <br>
                        <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                        <br><br>
                        Este correo es informativo y por tanto, le pedimos no responda este mensaje.
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
        
        if($estado == 'Aprobado'){
            $idSolicitud = $datosDoc1['id_solicitud'];
            $fechaCierre = date("Y/m/j");
            $mysqli->query("UPDATE solicitudDocumentos SET estado = 'Ejecutado', fechaCierre = '$fechaCierre' WHERE id = $idSolicitud ");
            $mysqli->query("UPDATE documento SET vigente = 0, obsoleto = 1, asumeFlujo = NULL WHERE id = $idDocumento");
        }
        
    }
    
    // ac�� estaba el require de envios correos
    
    //echo "estado final: ".$estado;


    $fecha = date("Y/m/j h:i:s");
    $idSolicitud = $datosDoc1['id_solicitud'];
    
                    $envioEncargado=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE id='$idSolicitud' ");
                    $extraerEncargado=$envioEncargado->fetch_array(MYSQLI_ASSOC);
                    $tipoSolicitud=$extraerEncargado['tipoSolicitud'];
    if($radioAprobado == 'rechazado' && $flujoAprovacion == 'cierra'){
        
    }else{
        if($controlCambios != NULL){
            $mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuario, fecha, rol, idRespaldo, tipoSolicitud) VALUES('$idSolicitud','$controlCambios','$idUser','$fecha','$rol','$idDocumento', '$tipoSolicitud')")or die(mysqli_error($mysqli));
        }else{
            $mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuario, fecha, rol, idRespaldo, tipoSolicitud) VALUES('$idSolicitud','N/A','$idUser','$fecha','$rol','$idDocumento', '$tipoSolicitud')")or die(mysqli_error($mysqli));
        }
    }
    
       //// este espacio se crea para el control de cambios el procedimiento del flujo de aprobación del documento
    $informacion=utf8_decode($_POST['editor1']);
     'Id: almacenado: '.$idAnteriorControlCambios=$_POST['idAnteriorControlCambios'];
    $consultamosExistenciaComentario=$mysqli->query("SELECT * FROM controlCambiosFlujo WHERE idDocumento='$idAnteriorControlCambios' ");
    $extrarConsultaExistenciaComentario=$consultamosExistenciaComentario->fetch_array(MYSQLI_ASSOC);
    if($radioAprobado == 'rechazado' && $flujoAprovacion == 'cierra'){
         '<br>Rescatando el control: '.$extrarConsultaExistenciaComentario['comentarioAnterior'];
        $mysqli->query("UPDATE controlCambiosFlujo SET informacion='".$extrarConsultaExistenciaComentario['comentarioAnterior']."' WHERE idDocumento='$idAnteriorControlCambios' ")or die(mysqli_error($mysqli));
    }else{
        if($extrarConsultaExistenciaComentario['idDocumento'] != NULL){
            $mysqli->query("UPDATE controlCambiosFlujo SET informacion='$informacion', fecha='$fecha' WHERE idDocumento='$idAnteriorControlCambios' ")or die(mysqli_error($mysqli));
        }else{
            $mysqli->query("INSERT INTO controlCambiosFlujo (idDocumento,informacion,fecha)VALUES('$idAnteriorControlCambios','$informacion','$fecha')")or die(mysqli_error($mysqli));
        }
    }
    //// end
   
  
    if($estado == "Rechazado"){
        
        $fechaCierre = date("Y/m/j");
        $idSolicitud = $datosDoc1['id_solicitud'];
        $mysqli->query("UPDATE solicitudDocumentos SET estado = '$estado', fechaCierre = '$fechaCierre' WHERE id = $idSolicitud ")or die(mysqli_error($mysqli));
        $mysqli->query("UPDATE documento SET estadoElimina = '$estado',  asumeFlujo = NULL WHERE id =  $idDocumento");
        //elaboraElimanar = NULL, revisaElimanar = NULL, apruebaElimanar = NULL,
        //NULL
        
        if($radioAprobado == 'rechazado' && $flujoAprovacion == 'cierra'){
            
        }else{
        
        if($radioAprobado == 'rechazado' && $flujoAprovacion == 'reinicia'){
                    $mysqli->query("UPDATE solicitudDocumentos SET estado = 'Rechazado', regresa='1' WHERE id = '$idSolicitud' ");
                    
                                            $envioCorreoEncargado=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE id='$idSolicitud' ");
                                            $extraerEnvioCorreoEncargado=$envioCorreoEncargado->fetch_array(MYSQLI_ASSOC);
                                             'Quien aprueba: '.$notificarEncargado=$extraerEnvioCorreoEncargado['QuienAprueba'];
                                            $nombreDocumento2=utf8_encode($extraerEnvioCorreoEncargado['nombreDocumento2']);
                                
                                            $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$notificarEncargado' ");
                                            $columna = $nombreuser->fetch_array();
                                            $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                                             $correoResponsable=$columna['correo']; 
                                             '<br>';
                      
                    

                                        

                                        //Create a new PHPMailer instance
                                        $mail = new PHPMailer();
                                        $mail->IsSMTP();
                                        
                                        //Configuracion servidor mail
                                        require '../../correoEnviar/contenido.php';
                                        
                                        //Agregar destinatario
                                        $mail->isHTML(true);
                                        $mail->AddAddress($correoResponsable);
                                        $mail->Subject = utf8_decode('Solicitud de documento');
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
                                        <p><b>Ha sido asignado para aprobar la solicitud de eliminación del documento '.$nombreDocumento2.'.</b></p>
                                        Se recomienda ingresar al sistema y realizar la actividad encargada.
                                        <br>
                                        <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                        <br><br>
                                        Este correo es informativo y por tanto, le pedimos no responda este mensaje.
                                        </p>
                                        </body>
                                        </html>
                                        ');
                                        
                                        //Avisar si fue enviado o no y dirigir al index
                                       
                                        if ($mail->Send()) {
                                        
                                        } else {

                                        }
                }else{
                        $envioCorreoEncargado=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE id='$idSolicitud' ");
                        $extraerEnvioCorreoEncargado=$envioCorreoEncargado->fetch_array(MYSQLI_ASSOC);
                         'Quien aprueba: '.$notificarEncargado=$extraerEnvioCorreoEncargado['QuienAprueba'];
                        $nombreDocumento2=utf8_encode($extraerEnvioCorreoEncargado['nombreDocumento2']);
                        
                                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$notificarEncargado' ");
                                    $columna = $nombreuser->fetch_array();
                                    $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                                     $correoResponsable=$columna['correo']; 
                                     '<br>';
                                      
                                    
                
                                                        
                
                                                        //Create a new PHPMailer instance
                                                        $mail = new PHPMailer();
                                                        $mail->IsSMTP();
                                                        
                                                        //Configuracion servidor mail
                                                        require '../../correoEnviar/contenido.php';
                                                        
                                                        //Agregar destinatario
                                                        $mail->isHTML(true);
                                                        $mail->AddAddress($correoResponsable);
                                                        $mail->Subject = utf8_decode('Solicitud rechazada');
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
                                                        <p><b>La solicitud de documento '.$nombreDocumento2.' fue rechazada.</b></p>
                                                        Se recomienda ingresar al sistema y realizar la actividad encargada.
                                                        <br>
                                                        <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                                        <br><br>
                                                        Este correo es informativo y por tanto, le pedimos no responda este mensaje.
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
        
        if($radioAprobado == 'rechazado' && $flujoAprovacion == 'reinicia'){
            $validacionRegreso='validacionRegreso';
         }else{
            $validacionRegreso='validacionEliminar'; 
         }
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../creacionDocumental" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="<?php echo $validacionRegreso;?>" value="1">
            </form> 
        <?php
    }else{
        
        $elaboraE = $datosDoc1['elaboraElimanar'];
        $revisaE = $datosDoc1['revisaElimanar'];
        $apruebaE = $datosDoc1['apruebaElimanar'];
        
        if($elaboraE != NULL && $revisaE != NULL && $apruebaE != NULL){
            $mysqli->query("UPDATE
                    documento
                    SET
                    aprobado_elabora_e = '$aprobado_elabora',
                    aprobado_revisa_e = '$aprobado_revisa',
                    aprobado_aprueba_e = '$aprobado_aprueba',
                    estadoElimina = '$estado', 
                    asumeFlujo = NULL
                    WHERE id = '$idDocumento'
                    ")or die(); 
        }else{
            $mysqli->query("UPDATE
                    documento
                    SET
                    elaboraElimanar = '$elabora',
                    revisaElimanar = '$revisa',
                    apruebaElimanar = '$aprueba',
                    aprobado_elabora_e = '$aprobado_elabora',
                    aprobado_revisa_e = '$aprobado_revisa',
                    aprobado_aprueba_e = '$aprobado_aprueba',
                    estadoElimina = '$estado', 
                    asumeFlujo = NULL
                    WHERE id = '$idDocumento'
                    ")or die(); 
        }
        
       

        if($estado == 'Aprobado'){ //echo 'para la revisión';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../creacionDocumental" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionAgregarD" value="1">
            </form> 
        <?php
        }
        if($estado == 'Elaborado'){ //echo 'para la revisión';

            $nombreDoc;
            'Dato: '.$radRevisa;
            '<br>';
            $elabora;
            if($radRevisa == 'usuarios'){
                $longitud = count($revisaN); 
                for($i=0; $i<$longitud; $i++){
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$revisaN[$i]' ");
                   while($columna = $nombreuser->fetch_array()){
                    $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                     $correoResponsable=$columna['correo']; 
                     '<br>';
                      
                    

                                        

                                        //Create a new PHPMailer instance
                                        $mail = new PHPMailer();
                                        $mail->IsSMTP();
                                        
                                        //Configuracion servidor mail
                                        require '../../correoEnviar/contenido.php';
                                        
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
                                        Este correo es informativo y por tanto, le pedimos no responda este mensaje.
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

            if($radRevisa == 'cargos'){
                 'Cargos';
                $longitud = count($revisaN); 
                for($i=0; $i<$longitud; $i++){
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo = '$revisaN[$i]' ");
                    while($columna = $nombreuser->fetch_array()){
                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                        $correoResponsable=$columna['correo']; 
                        '<br>';
                        //Create a new PHPMailer instance
                        $mail = new PHPMailer();
                        $mail->IsSMTP();
                        
                        //Configuracion servidor mail
                        require '../../correoEnviar/contenido.php';
                        
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
                        Este correo es informativo y por tanto, le pedimos no responda este mensaje.
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

        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../creacionDocumental" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionAgregarB" value="1">
            </form> 
        <?php
        }
        if($estado == 'Revisado'){ //echo 'para aprobación';

            $nombreDoc;
            $radAprueba;
              '<br>';
              $elabora;
              if($radAprueba == 'usuarios'){
                  $longitud = count($enviarVariableAprobador); 
                  for($i=0; $i<$longitud; $i++){
                      $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$enviarVariableAprobador[$i]' ");
                      while($columna = $nombreuser->fetch_array()){
                       $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                       $correoResponsable=$columna['correo']; 
                       '<br>';
                        
                      
  
                                          
  
                                          //Create a new PHPMailer instance
                                          $mail = new PHPMailer();
                                          $mail->IsSMTP();
                                          
                                          //Configuracion servidor mail
                                          require '../../correoEnviar/contenido.php';
                                          
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
                                          Este correo es informativo y por tanto, le pedimos no responda este mensaje.
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
  
              if($radAprueba == 'cargos'){ 
                   $radAprueba;      
                   $longitud = count($enviarVariableAprobador);          
               
                  for($i=0; $i<$longitud; $i++){
                      $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo = '$enviarVariableAprobador[$i]' ");
                      while($columna = $nombreuser->fetch_array()){
                          $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                          $correoResponsable=$columna['correo']; 
                          '<br>';
                          //Create a new PHPMailer instance
                          $mail = new PHPMailer();
                          $mail->IsSMTP();
                          
                          //Configuracion servidor mail
                          require '../../correoEnviar/contenido.php';
                          
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
                          Este correo es informativo y por tanto, le pedimos no responda este mensaje.
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
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../creacionDocumental" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionAgregarC" value="1">
            </form> 
        <?php
        }
        if($estado == 'Pendiente'){ //echo 'para elaborar';
            $nombreDoc;
            'Dato: '.$radElabora;
            '<br>';
            $elabora;
            if($radElabora == 'usuarios'){
                $longitud = count($elaboraN); 
                for($i=0; $i<$longitud; $i++){
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$elaboraN[$i]' ");
                    while($columna = $nombreuser->fetch_array()){
                    $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                     $correoResponsable=$columna['correo']; 
                     '<br>';
                      
                    

                                        

                                        //Create a new PHPMailer instance
                                        $mail = new PHPMailer();
                                        $mail->IsSMTP();
                                        
                                        //Configuracion servidor mail
                                        require '../../correoEnviar/contenido.php';
                                        
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
                                        Este correo es informativo y por tanto, le pedimos no responda este mensaje.
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

            if($radElabora == 'cargos'){
                 'Cargos';
                $longitud = count($elaboraN); 
                for($i=0; $i<$longitud; $i++){
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo = '$elaboraN[$i]' ");
                    while($columna = $nombreuser->fetch_array()){
                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                        $correoResponsable=$columna['correo']; 
                        '<br>';
                        //Create a new PHPMailer instance
                        $mail = new PHPMailer();
                        $mail->IsSMTP();
                        
                        //Configuracion servidor mail
                        require '../../correoEnviar/contenido.php';
                        
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
                        Este correo es informativo y por tanto, le pedimos no responda este mensaje.
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
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../creacionDocumental" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionAgregar" value="1">
            </form> 
        <?php
        }

    }

    
    
    

}
    

?>


