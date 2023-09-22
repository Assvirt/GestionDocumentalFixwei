<?php
date_default_timezone_set("America/Bogota");
require_once '../../conexion/bd.php';
session_start();
error_reporting(E_ERROR);
$idUser = $_SESSION["session_username"];
$idCargo = $_SESSION["session_cargo"];


if(isset($_POST['revisarDoc'])){
    
    //tarigo los datos del documento y reviso si ya se le asigno elaborado, revisor, aprobador 
    
    /*
     si se asigno ya solo actuliza los datos
    
    
    */
    
    
    $rol = $_POST['rol'];
    $idDocumento = $_POST['idDocumento'];
    $nombreDoc = utf8_decode($_POST['nombreDocumento']);
    $nombreDocEnviar = utf8_encode($nombreDoc); /// enviar al correo
    $norma = unserialize($_POST['norma']);
    $norma = json_encode($norma);
    $proceso = $_POST['proceso'];
    $metodo = $_POST['rad_metodo'];
    $tipoDoc = $_POST['tipoDoc'];
    $ubicacion = utf8_decode($_POST['ubicacion']);
    /// simplificar las 3 variables
    $elabora = unserialize($_POST['select_encargadoE']);
    $revisaE = unserialize($_POST['select_encargadoE']); /// quien elabora
    $elaboraN = unserialize($_POST['select_encargadoE']); /// quien elabora
    //// Fin
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
    $archivoGestion = utf8_decode($_POST['archivo_gestion']);
    $archivoCentral = utf8_decode($_POST['archivo_central']);
    $archivoHistorico = utf8_decode($_POST['archivo_historico']);
    $dispoDocumental = utf8_decode($_POST['diposicion_documental']); //Disposicon documental
    
    if($_POST['select_encargadoDD'] != NULL){
        $escargadoDispo=utf8_decode($_POST['select_encargadoDD']);
    }else{
        $escargadoDispo = unserialize($_POST['select_encargadoD']);
        $radDispoDoc = $_POST['radiobtnD'];
        array_unshift($escargadoDispo,$radDispoDoc); 
        $escargadoDispo = json_encode($escargadoDispo);
    }
    $editorHtml = utf8_decode($_POST['editorHtml']);
    $nombrePDF = utf8_decode($_POST['nombrePDF']); 
    $nombreOtro = utf8_decode($_POST['nombreOtro']);
    
    
    //Datos tercer formulario crearDocumento3
    $aprovacionRegistros = $_POST['radiobtn'];
    $radArpeuevaRegistros = $_POST['radiobtnAR'];
        
        if($_POST['radiobtnReg'] == "si"){
            array_unshift($_POST['select_encargadoAR'],$radArpeuevaRegistros);
        }
    
    $select_encargadoAR = json_encode($_POST['select_encargadoAR']);
    
    $flujoAprovacion = $_POST['rad_flujo'];
    $mesesRevision = $_POST['mesesRevision'];
    $controlCambios = utf8_decode($_POST['controlCambios']);
    $radioAprobado = $_POST['radiobtnAprobado'];
    
    
    //Validciones de flujo para la aprobacion

    //echo "Elabora".$elaboraf = json_decode($elabora);
    //echo "Revisa".$revisaf  = json_decode($revisa);
    //echo "Aprueba".$apruebaf = json_decode($aprueba);
    
    $fechaAprobado =  date("Y/m/j h:i:s");
    
    ///Validar en que estado esta para continuar el flujo 
    $queryDoc1 = $mysqli->query("SELECT * FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
    $datosDoc1 = $queryDoc1->fetch_assoc();
    
    
    $NotifiacionElaborador=$datosDoc1['plataformaH'];
    $NotifiacionRevisa=$datosDoc1['plataformaHRevisa'];
    $NotifiacionAprueba=$datosDoc1['plataformaHAprueba'];
    
    
    $estadoActual = $datosDoc1['estadoActualiza'];
    
    $aprobado_elabora = 0;
    $aprobado_revisa = 0;
    $aprobado_aprueba = 0;
    
    $vigente = 0;
    
    $fecha = date("Y:m:j"); 
    $idAnterior = $datosDoc1['idAnterior'];
    
    
    if($estadoActual == NULL){
        if($radioAprobado == 'rechazado' && $flujoAprovacion == 'reinicia'){
            $estado = "Rechazado";
        }else{
            $estado = "Pendiente";
        }
    }
    
     require '../usuarios/libreria/PHPMailerAutoload.php';
    if($estadoActual == NULL){     
        if($radioAprobado == 'rechazado' && $flujoAprovacion == 'cierra'){
            ////// codigo anterior, no permitia enviar correo y se agrega esta validación 15 de marzo 2023
            //$estado = "Rechazado";
            //$mysqli->query("UPDATE documento SET ultimaFechaRevision = '$fecha', usuarioRevisa = NULL, revisado = 0 WHERE id='$idAnterior'");
            
                $estado = "Rechazado";
                $aprobado_elabora = 0;
                $fechaCierre =  date("Y/m/j");
                $idSolicitud = $datosDoc1['id_solicitud'];
                $mysqli->query("UPDATE solicitudDocumentos SET estado = '$estado', fechaCierre = '$fechaCierre' WHERE id = $idSolicitud ")or die(mysqli_error($mysqli));
                $mysqli->query("UPDATE documento SET ultimaFechaRevision = '$fecha', usuarioRevisa = NULL, revisado = 0 WHERE id='$idAnterior'");
                
                
                   $envioCorreoEncargado=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE id='$idSolicitud' ");
                        $extraerEnvioCorreoEncargado=$envioCorreoEncargado->fetch_array(MYSQLI_ASSOC);
                        'Quien aprueba: '.$notificarEncargado=$extraerEnvioCorreoEncargado['QuienAprueba'];
                        'Quien aprueba: '.$notificarEncargadoQuienS=$extraerEnvioCorreoEncargado['quienSolicita'];
                        //$nombreDocumento2=utf8_encode($extraerEnvioCorreoEncargado['nombreDocumento2']);
                        $idSolicitudNombre=utf8_encode($extraerEnvioCorreoEncargado['id']);
                        
                        $conformandoNOmbre=$mysqli->query("SELECt * FROm documento WHERE id_solicitud='$idSolicitudNombre' ");
                        $extraerNombreNuevo=$conformandoNOmbre->fetch_array(MYSQLI_ASSOC);
                        $nombreDocumento2=utf8_encode($extraerNombreNuevo['nombres']);
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
                                            <p><b>el documento '.$nombreDocumento2.' fue cerrado.</b></p>
                                            
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
                                            $mail->Subject = utf8_decode('Documento cerrado - solicitante ');
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
                $mysqli->query("DELETE FROM documento WHERE id ='$idDocumento'");
                
            
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
            $fechaCierre =  date("Y/m/j");
            $idSolicitud = $datosDoc1['id_solicitud'];
            $mysqli->query("UPDATE solicitudDocumentos SET estado = '$estado', fechaCierre = '$fechaCierre' WHERE id = $idSolicitud ")or die(mysqli_error($mysqli));
            $mysqli->query("UPDATE documento SET ultimaFechaRevision = '$fecha', usuarioRevisa = NULL, revisado = 0 WHERE id='$idAnterior'");
            
            
               $envioCorreoEncargado=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE id='$idSolicitud' ");
                    $extraerEnvioCorreoEncargado=$envioCorreoEncargado->fetch_array(MYSQLI_ASSOC);
                    'Quien aprueba: '.$notificarEncargado=$extraerEnvioCorreoEncargado['QuienAprueba'];
                    'Quien aprueba: '.$notificarEncargadoQuienS=$extraerEnvioCorreoEncargado['quienSolicita'];
                    //$nombreDocumento2=utf8_encode($extraerEnvioCorreoEncargado['nombreDocumento2']);
                    $idSolicitudNombre=utf8_encode($extraerEnvioCorreoEncargado['id']);
                    
                    $conformandoNOmbre=$mysqli->query("SELECt * FROm documento WHERE id_solicitud='$idSolicitudNombre' ");
                    $extraerNombreNuevo=$conformandoNOmbre->fetch_array(MYSQLI_ASSOC);
                    $nombreDocumento2=utf8_encode($extraerNombreNuevo['nombres']);
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
                                        <p><b>el documento '.$nombreDocumento2.' fue cerrado.</b></p>
                                        
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
                                        $mail->Subject = utf8_decode('Documento cerrado - solicitante ');
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
            $mysqli->query("DELETE FROM documento WHERE id ='$idDocumento'");
            
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
            $fechaCierre =  date("Y/m/j");
            $idSolicitud = $datosDoc1['id_solicitud'];
            $mysqli->query("UPDATE solicitudDocumentos SET estado = '$estado', fechaCierre = '$fechaCierre' WHERE id = $idSolicitud ")or die(mysqli_error($mysqli));
            $mysqli->query("UPDATE documento SET ultimaFechaRevision = '$fecha', usuarioRevisa = NULL, revisado = 0 WHERE id='$idAnterior'");
            
            
             $envioCorreoEncargado=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE id='$idSolicitud' ");
                    $extraerEnvioCorreoEncargado=$envioCorreoEncargado->fetch_array(MYSQLI_ASSOC);
                    'Quien aprueba: '.$notificarEncargado=$extraerEnvioCorreoEncargado['QuienAprueba'];
                    'Quien aprueba: '.$notificarEncargadoQuienS=$extraerEnvioCorreoEncargado['quienSolicita'];
                    //$nombreDocumento2=utf8_encode($extraerEnvioCorreoEncargado['nombreDocumento2']);
                    $idSolicitudNombre=utf8_encode($extraerEnvioCorreoEncargado['id']);
                    
                    $conformandoNOmbre=$mysqli->query("SELECt * FROm documento WHERE id_solicitud='$idSolicitudNombre' ");
                    $extraerNombreNuevo=$conformandoNOmbre->fetch_array(MYSQLI_ASSOC);
                    $nombreDocumento2=utf8_encode($extraerNombreNuevo['nombres']);
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
                                        $mail->Subject = utf8_decode('Documento cerrado - solicitante ');
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
                $longitud = count($revisaE); 
                for($i=0; $i<$longitud; $i++){
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$revisaE[$i]' ");
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
                $longitud = count($revisaE); 
                for($i=0; $i<$longitud; $i++){
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo = '$revisaE[$i]' ");
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
            
            
            
            
            $mysqli->query("DELETE FROM documento WHERE id ='$idDocumento'");
           
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
                    //$nombreDocumento2=utf8_encode($extraerEnvioCorreoEncargado['nombreDocumento2']);
                    $idSolicitudNombre=utf8_encode($extraerEnvioCorreoEncargado['id']);
                    
                    $conformandoNOmbre=$mysqli->query("SELECt * FROm documento WHERE id_solicitud='$idSolicitudNombre' ");
                    $extraerNombreNuevo=$conformandoNOmbre->fetch_array(MYSQLI_ASSOC);
                    $nombreDocumento2=utf8_encode($extraerNombreNuevo['nombres']);
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$notificarEncargado' ");
                    $columna = $nombreuser->fetch_array();
                    $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                     $correoResponsable=$columna['correo']; 
                     '<br>';
                      
                    
                                       
            
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
            $estado = "Aprobado";
            $aprobado_aprueba = 1;
        }
        
        if($radioAprobado == 'rechazado' && $flujoAprovacion == 'cierra'){
            $estado = "Rechazado";
            $aprobado_aprueba = 0;
            $fechaCierre =  date("Y/m/j");
            $idSolicitud = $datosDoc1['id_solicitud'];
            $mysqli->query("UPDATE solicitudDocumentos SET estado = '$estado', fechaCierre = '$fechaCierre' WHERE id = $idSolicitud ")or die(mysqli_error($mysqli));
            $mysqli->query("UPDATE documento SET ultimaFechaRevision = '$fecha', usuarioRevisa = NULL, revisado = 0 WHERE id='$idAnterior'");
            
            
            $envioCorreoEncargado=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE id='$idSolicitud' ");
                    $extraerEnvioCorreoEncargado=$envioCorreoEncargado->fetch_array(MYSQLI_ASSOC);
                    'Quien aprueba: '.$notificarEncargado=$extraerEnvioCorreoEncargado['QuienAprueba'];
                    'Quien aprueba: '.$notificarEncargadoQuienS=$extraerEnvioCorreoEncargado['quienSolicita'];
                    //$nombreDocumento2=utf8_encode($extraerEnvioCorreoEncargado['nombreDocumento2']);
                    $idSolicitudNombre=utf8_encode($extraerEnvioCorreoEncargado['id']);
                    
                    $conformandoNOmbre=$mysqli->query("SELECt * FROm documento WHERE id_solicitud='$idSolicitudNombre' ");
                    $extraerNombreNuevo=$conformandoNOmbre->fetch_array(MYSQLI_ASSOC);
                    $nombreDocumento2=utf8_encode($extraerNombreNuevo['nombres']);
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
                                        $mail->Subject = utf8_decode('Documento cerrado - solicitante ');
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
                $longitud = count($revisaE); 
                for($i=0; $i<$longitud; $i++){
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$revisaE[$i]' ");
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
                $longitud = count($revisaE); 
                for($i=0; $i<$longitud; $i++){
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo = '$revisaE[$i]' ");
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
                                        $mail->Subject = utf8_decode('Documento cerrado - revisor ');
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
                        $mail->Subject = utf8_decode('Documento cerrado - revisor ');
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
            
            
            $mysqli->query("DELETE FROM documento WHERE id ='$idDocumento'");
           
            
        }
        
        if($estado == 'Aprobado'){
            $fechaAprobado =  date("Y/m/j h:i:s");
            $fechaCierre =  date("Y/m/j");
            $vigente = 1;
            $idSolicitud = $datosDoc1['id_solicitud'];
            $mysqli->query("UPDATE solicitudDocumentos SET estado = 'Ejecutado', fechaCierre = '$fechaCierre' WHERE id = $idSolicitud ")or die(mysqli_error($mysqli));
            $idAnterior = $datosDoc1['idAnterior'];
            $mysqli->query("UPDATE documento SET vigente = 0, obsoleto =1, revisado = 1, usuarioRevisa = '$idUser' WHERE id = $idAnterior ");

        }
        
    }
    
    
    //// controlador para el envio de correos......
    
    ///// aca estaba el require envios correos
    
    //echo "estado final: ".$estado;

    //TIPO DE DOCUMENTO 
    $queryDocumentos = $mysqli->query("SELECT nombre, prefijo from tipoDocumento WHERE id = '".$tipoDoc."' ");
    $datosDocumento = $queryDocumentos->fetch_array(MYSQLI_ASSOC);
    $tipoDocumento = $datosDocumento['nombre'];
    $prefijoTipo = $datosDocumento['prefijo']; 
    
                    
    //PROCESO            
    $roles=$row['cargo'];
    $queryProcesos = $mysqli->query("SELECT nombre,prefijo from procesos WHERE id = '".$proceso."' ");
    $datosProceso = $queryProcesos->fetch_array(MYSQLI_ASSOC);
    $nomProceso = $datosProceso['nombre'];
    $prefijoProceso = $datosProceso['prefijo'];
    
    
    //CONSECUTIVO
    $queryDoc = $mysqli->query("SELECT MAX(consecutivo) AS consecutivo FROM documento WHERE tipo_documento = $tipoDoc AND proceso = '$proceso' AND aprobado_aprueba = 1")or die(mysqli_error($mysqli));
    $datosDoc = $queryDoc->fetch_assoc();
    $consecutivo = $datosDoc1['consecutivo'];
    
    
    //VERSION
    $version = $datosDoc1['version'];
    $idAnterior = $datosDoc1['idAnterior'];
    $queryVersion = $mysqli->query("SELECT version FROM documento WHERE id = '$idAnterior'")or die(mysqli_error($mysqli));
    $datosVersion = $queryVersion->fetch_assoc();
    $version = $datosVersion['version']+1;
    
    //CODIFICACION
    $codificacion = "";
    $dataCodificacion = $mysqli->query("SELECT * FROM codificacion ORDER BY id")or die(mysqli_error($mysqli));
    
    
    while($rowC = $dataCodificacion->fetch_assoc()){
                           
        $cod = $rowC['codificacion'];
                                
        if($cod == "-"){
            $codificacion =  $codificacion."-";
        }
                            
        if($cod == "/"){
            $codificacion =  $codificacion."/";
        }
                                
        if($cod == " "){
            $codificacion =  $codificacion." ";
        }
                                
        if($cod == "Proceso"){
            $codificacion =  $codificacion.$prefijoProceso;
        }
                            
        if($cod == "Tipo de documento"){
            $codificacion = $codificacion.$prefijoTipo;        
        }
                                
        if($cod == "Consecutivo"){
            $codificacion = $codificacion.$consecutivo;        
        }
                                
        if($cod == "Versión"){
            $codificacion = $codificacion.$version;        
        }
    }//Fin codificacion 

    $fecha = date("Y/m/j h:i:s");
    $idSolicitud = $datosDoc1['id_solicitud'];

    
    
    if($controlCambios != NULL){
        $mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuario, fecha, rol) VALUES('$idSolicitud','$controlCambios','$idUser','$fecha','$rol')")or die(mysqli_error($mysqli));
    }else{
        $mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuario, fecha, rol) VALUES('$idSolicitud','N/A','$idUser','$fecha','$rol')")or die(mysqli_error($mysqli));
    }
    
      //// este espacio se crea para el control de cambios el procedimiento del flujo de aprobación del documento
    $informacion=utf8_decode($_POST['editor1']);
    $idAnteriorControlCambios=$_POST['idAnteriorControlCambios'];
    $consultamosExistenciaComentario=$mysqli->query("SELECT * FROM controlCambiosFlujo WHERE idDocumento='$idAnteriorControlCambios' ");
    $extrarConsultaExistenciaComentario=$consultamosExistenciaComentario->fetch_array(MYSQLI_ASSOC);
    if($radioAprobado == 'rechazado' && $flujoAprovacion == 'cierra'){
        $mysqli->query("UPDATE controlCambiosFlujo SET informacion='".$extrarConsultaExistenciaComentario['comentarioAnterior']."' WHERE idDocumento='$idAnteriorControlCambios' ");
    }else{ 
         '<br>Guardando comentarios';
        if($extrarConsultaExistenciaComentario['idDocumento'] != NULL){
            if($estadoActual == "Revisado"){  '<br>Rescatamos datos';
            $mysqli->query("UPDATE controlCambiosFlujo SET comentarioAnterior='$informacion',informacion='$informacion', fecha='$fecha' WHERE idDocumento='$idAnteriorControlCambios' ");
            }else{
            $mysqli->query("UPDATE controlCambiosFlujo SET informacion='$informacion', fecha='$fecha' WHERE idDocumento='$idAnteriorControlCambios' ");    
            }
            
        }else{
            $mysqli->query("INSERT INTO controlCambiosFlujo (idDocumento,informacion,fecha)VALUES('$idAnteriorControlCambios','$informacion','$fecha')");
        }
    }
    
    
    
    //// end
    
    /// salvaguardamos el nombre cada vez que se cambie el nombre para mantener la validación de solicitud
     $mysqli->query("UPDATE solicitudDocumentos SET nombreSalvar = '$nombreDoc' WHERE id = '$idSolicitud' ");
    /// end
   
    //// vamos actualizar el nombre del proceso cada vez que se cambie, agregamos el tipo de solicitud también
     $mysqli->query("UPDATE documento SET  nombreProceso='$nomProceso', tipoSolicitud='2' WHERE id = '$idDocumento' ");
    /// end
    
    $mysqli->query("UPDATE documento SET asumeFlujo=NULL WHERE id = '$idDocumento' ")or die(mysqli_error($mysqli));
    
    if($estado == "Rechazado"){
        
        
        $fechaCierre =  date("Y/m/j");
        $idSolicitud = $datosDoc1['id_solicitud'];
        $mysqli->query("UPDATE solicitudDocumentos SET estado = '$estado', fechaCierre = '$fechaCierre' WHERE id = $idSolicitud ")or die(mysqli_error($mysqli));
        $mysqli->query("UPDATE documento SET estadoActualiza = '$estado', asumeFlujo=NULL WHERE id = '$idDocumento' ")or die(mysqli_error($mysqli));
        
        ///$mysqli->query("DELETE FROM documento WHERE id ='$idDocumento'"); este código estaba habilitado antes
        
       
        if($radioAprobado == 'rechazado' && $flujoAprovacion == 'cierra'){
           
        }else{
        
                if($radioAprobado == 'rechazado' && $flujoAprovacion == 'reinicia'){
                    
                    
                    
                    
                    if($nombreOtro == NULL){
            
                        if($nombrePDF == NULL){
                            
                            $mysqli->query("UPDATE
                                documento
                                SET
                                nombres = '$nombreDoc',
                                codificacion = '$codificacion',
                                consecutivo = '$consecutivo',
                                version = '$version',
                                proceso = '$proceso',
                                norma = '$norma',
                                tipo_documento = $tipoDoc,
                                htmlDoc = '$editorHtml',
                                ubicacion = '$ubicacion',
                                elaboraActualizar = '$elabora',
                                revisaActualizar = '$revisa',
                                apruebaActualizar = '$aprueba',
                                documento_externo = '$documentosExternos',
                                definiciones = '$definiciones',
                                archivo_gestion = '$archivoGestion',
                                archivo_central = '$archivoCentral',
                                archivo_historico = '$archivoHistorico',
                                disposicion_documental = '$dispoDocumental',
                                responsable_disposicion = '$escargadoDispo',
                                usuario_aprovacion_reg = '$select_encargadoAR',
                                mesesRevision = '$mesesRevision',
                                aprobado_elabora_a = '$aprobado_elabora',
                                aprobado_revisa_a = '$aprobado_revisa',
                                aprobado_aprueba_a = '$aprobado_aprueba',
                                fechaAprobado = '$fechaAprobado',
                                estadoActualiza = '$estado',
                                vigente = '$vigente',
                                asumeFlujo = NULL
                                WHERE id = '$idDocumento'
             
                                ")or die(mysqli_error($mysqli));
                        }else{
                            
                            $mysqli->query("UPDATE
                                documento
                                SET
                                nombres = '$nombreDoc',
                                codificacion = '$codificacion',
                                consecutivo = '$consecutivo',
                                version = '$version',
                                proceso = '$proceso',
                                norma = '$norma',
                                tipo_documento = $tipoDoc,
                                htmlDoc = '$editorHtml',
                                ubicacion = '$ubicacion',
                                elaboraActualizar = '$elabora',
                                revisaActualizar = '$revisa',
                                apruebaActualizar = '$aprueba',
                                documento_externo = '$documentosExternos',
                                definiciones = '$definiciones',
                                archivo_gestion = '$archivoGestion',
                                archivo_central = '$archivoCentral',
                                archivo_historico = '$archivoHistorico',
                                disposicion_documental = '$dispoDocumental',
                                responsable_disposicion = '$escargadoDispo',
                                usuario_aprovacion_reg = '$select_encargadoAR',
                                mesesRevision = '$mesesRevision',
                                aprobado_elabora_a = '$aprobado_elabora',
                                aprobado_revisa_a = '$aprobado_revisa',
                                aprobado_aprueba_a = '$aprobado_aprueba',
                                nombrePDF = '$nombrePDF',
                                fechaAprobado = '$fechaAprobado',
                                estadoActualiza = '$estado',
                                vigente = '$vigente',
                                asumeFlujo = NULL
                                WHERE id = '$idDocumento'
             
                                ")or die(mysqli_error($mysqli));
                        }
                
                 
                    }else{
                        
                        if($nombrePDF == NULL){
                         $mysqli->query("UPDATE
                                documento
                                SET
                                nombres = '$nombreDoc',
                                codificacion = '$codificacion',
                                consecutivo = '$consecutivo',
                                version = '$version',
                                proceso = '$proceso',
                                norma = '$norma',
                                tipo_documento = $tipoDoc,
                                htmlDoc = '$editorHtml',
                                ubicacion = '$ubicacion',
                                elaboraActualizar = '$elabora',
                                revisaActualizar = '$revisa',
                                apruebaActualizar = '$aprueba',
                                documento_externo = '$documentosExternos',
                                definiciones = '$definiciones',
                                archivo_gestion = '$archivoGestion',
                                archivo_central = '$archivoCentral',
                                archivo_historico = '$archivoHistorico',
                                disposicion_documental = '$dispoDocumental',
                                responsable_disposicion = '$escargadoDispo',
                                usuario_aprovacion_reg = '$select_encargadoAR',
                                mesesRevision = '$mesesRevision',
                                aprobado_elabora_a = '$aprobado_elabora',
                                aprobado_revisa_a = '$aprobado_revisa',
                                aprobado_aprueba_a = '$aprobado_aprueba',
                                nombreOtro = '$nombreOtro',
                                fechaAprobado = '$fechaAprobado',
                                estadoActualiza = '$estado',
                                vigente = '$vigente',
                                asumeFlujo = NULL
                                WHERE id = '$idDocumento'
             
                                ")or die(mysqli_error($mysqli));    // nombrePDF = '$nombrePDF',
                        }else{
                            $mysqli->query("UPDATE
                                documento
                                SET
                                nombres = '$nombreDoc',
                                codificacion = '$codificacion',
                                consecutivo = '$consecutivo',
                                version = '$version',
                                proceso = '$proceso',
                                norma = '$norma',
                                tipo_documento = $tipoDoc,
                                htmlDoc = '$editorHtml',
                                ubicacion = '$ubicacion',
                                elaboraActualizar = '$elabora',
                                revisaActualizar = '$revisa',
                                apruebaActualizar = '$aprueba',
                                documento_externo = '$documentosExternos',
                                definiciones = '$definiciones',
                                archivo_gestion = '$archivoGestion',
                                archivo_central = '$archivoCentral',
                                archivo_historico = '$archivoHistorico',
                                disposicion_documental = '$dispoDocumental',
                                responsable_disposicion = '$escargadoDispo',
                                usuario_aprovacion_reg = '$select_encargadoAR',
                                mesesRevision = '$mesesRevision',
                                aprobado_elabora_a = '$aprobado_elabora',
                                aprobado_revisa_a = '$aprobado_revisa',
                                aprobado_aprueba_a = '$aprobado_aprueba',
                                nombrePDF = '$nombrePDF',
                                nombreOtro = '$nombreOtro',
                                fechaAprobado = '$fechaAprobado',
                                estadoActualiza = '$estado',
                                vigente = '$vigente',
                                asumeFlujo = NULL
                                WHERE id = '$idDocumento'
             
                                ")or die(mysqli_error($mysqli));
                        }
                        
                        
                        
                         
                    }
                    
                    
                    
                    
                    
                    
                    $mysqli->query("UPDATE solicitudDocumentos SET estado = 'Rechazado', regresa='1' WHERE id = '$idSolicitud' ");
                    
                                            $envioCorreoEncargado=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE id='$idSolicitud' ");
                                            $extraerEnvioCorreoEncargado=$envioCorreoEncargado->fetch_array(MYSQLI_ASSOC);
                                             'Quien aprueba: '.$notificarEncargado=$extraerEnvioCorreoEncargado['QuienAprueba'];
                                            //$nombreDocumento2=utf8_encode($extraerEnvioCorreoEncargado['nombreDocumento2']);
                                            $idSolicitudNombre=utf8_encode($extraerEnvioCorreoEncargado['id']);
                    
                                            $conformandoNOmbre=$mysqli->query("SELECt * FROm documento WHERE id_solicitud='$idSolicitudNombre' ");
                                            $extraerNombreNuevo=$conformandoNOmbre->fetch_array(MYSQLI_ASSOC);
                                            $nombreDocumento2=utf8_encode($extraerNombreNuevo['nombres']);
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
                                        <p><b>Ha sido asignado para aprobar la solicitud de actualización del documento '.$nombreDocumento2.'.</b></p>
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
                //$nombreDocumento2=utf8_encode($extraerEnvioCorreoEncargado['nombreDocumento2']);
                    $idSolicitudNombre=utf8_encode($extraerEnvioCorreoEncargado['id']);
                    
                    $conformandoNOmbre=$mysqli->query("SELECt * FROm documento WHERE id_solicitud='$idSolicitudNombre' ");
                    $extraerNombreNuevo=$conformandoNOmbre->fetch_array(MYSQLI_ASSOC);
                    $nombreDocumento2=utf8_encode($extraerNombreNuevo['nombres']);
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
        
        
        $mysqli->query("UPDATE documento SET asumeFlujo=NULL WHERE id = '$idDocumento' ")or die(mysqli_error($mysqli));
        
        
        
        $elaboraA = $datosDoc1['elaboraActualizar'];
        $revisaA = $datosDoc1['revisaActualizar'];
        $apruebaA = $datosDoc1['apruebaActualizar'];
        
        
        
        if($elaboraA == NULL && $revisaA == NULL && $apruebaA == NULL){
            
            if($nombreOtro == NULL){
            
                if($nombrePDF == NULL){
                    
                    $mysqli->query("UPDATE
                        documento
                        SET
                        nombres = '$nombreDoc',
                        codificacion = '$codificacion',
                        consecutivo = '$consecutivo',
                        version = '$version',
                        proceso = '$proceso',
                        norma = '$norma',
                        tipo_documento = $tipoDoc,
                        htmlDoc = '$editorHtml',
                        ubicacion = '$ubicacion',
                        elaboraActualizar = '$elabora',
                        revisaActualizar = '$revisa',
                        apruebaActualizar = '$aprueba',
                        documento_externo = '$documentosExternos',
                        definiciones = '$definiciones',
                        archivo_gestion = '$archivoGestion',
                        archivo_central = '$archivoCentral',
                        archivo_historico = '$archivoHistorico',
                        disposicion_documental = '$dispoDocumental',
                        responsable_disposicion = '$escargadoDispo',
                        usuario_aprovacion_reg = '$select_encargadoAR',
                        mesesRevision = '$mesesRevision',
                        aprobado_elabora_a = '$aprobado_elabora',
                        aprobado_revisa_a = '$aprobado_revisa',
                        aprobado_aprueba_a = '$aprobado_aprueba',
                        fechaAprobado = '$fechaAprobado',
                        estadoActualiza = '$estado',
                        vigente = '$vigente',
                        asumeFlujo = NULL
                        WHERE id = '$idDocumento'
     
                        ")or die(mysqli_error($mysqli));
                }else{
                    
                    $mysqli->query("UPDATE
                        documento
                        SET
                        nombres = '$nombreDoc',
                        codificacion = '$codificacion',
                        consecutivo = '$consecutivo',
                        version = '$version',
                        proceso = '$proceso',
                        norma = '$norma',
                        tipo_documento = $tipoDoc,
                        htmlDoc = '$editorHtml',
                        ubicacion = '$ubicacion',
                        elaboraActualizar = '$elabora',
                        revisaActualizar = '$revisa',
                        apruebaActualizar = '$aprueba',
                        documento_externo = '$documentosExternos',
                        definiciones = '$definiciones',
                        archivo_gestion = '$archivoGestion',
                        archivo_central = '$archivoCentral',
                        archivo_historico = '$archivoHistorico',
                        disposicion_documental = '$dispoDocumental',
                        responsable_disposicion = '$escargadoDispo',
                        usuario_aprovacion_reg = '$select_encargadoAR',
                        mesesRevision = '$mesesRevision',
                        aprobado_elabora_a = '$aprobado_elabora',
                        aprobado_revisa_a = '$aprobado_revisa',
                        aprobado_aprueba_a = '$aprobado_aprueba',
                        nombrePDF = '$nombrePDF',
                        fechaAprobado = '$fechaAprobado',
                        estadoActualiza = '$estado',
                        vigente = '$vigente',
                        asumeFlujo = NULL
                        WHERE id = '$idDocumento'
     
                        ")or die(mysqli_error($mysqli));
                }
                
                 
            }else{
                
                if($nombrePDF == NULL){
                 $mysqli->query("UPDATE
                        documento
                        SET
                        nombres = '$nombreDoc',
                        codificacion = '$codificacion',
                        consecutivo = '$consecutivo',
                        version = '$version',
                        proceso = '$proceso',
                        norma = '$norma',
                        tipo_documento = $tipoDoc,
                        htmlDoc = '$editorHtml',
                        ubicacion = '$ubicacion',
                        elaboraActualizar = '$elabora',
                        revisaActualizar = '$revisa',
                        apruebaActualizar = '$aprueba',
                        documento_externo = '$documentosExternos',
                        definiciones = '$definiciones',
                        archivo_gestion = '$archivoGestion',
                        archivo_central = '$archivoCentral',
                        archivo_historico = '$archivoHistorico',
                        disposicion_documental = '$dispoDocumental',
                        responsable_disposicion = '$escargadoDispo',
                        usuario_aprovacion_reg = '$select_encargadoAR',
                        mesesRevision = '$mesesRevision',
                        aprobado_elabora_a = '$aprobado_elabora',
                        aprobado_revisa_a = '$aprobado_revisa',
                        aprobado_aprueba_a = '$aprobado_aprueba',
                        nombreOtro = '$nombreOtro',
                        fechaAprobado = '$fechaAprobado',
                        estadoActualiza = '$estado',
                        vigente = '$vigente',
                        asumeFlujo = NULL
                        WHERE id = '$idDocumento'
     
                        ")or die(mysqli_error($mysqli));    // nombrePDF = '$nombrePDF',
                }else{
                    $mysqli->query("UPDATE
                        documento
                        SET
                        nombres = '$nombreDoc',
                        codificacion = '$codificacion',
                        consecutivo = '$consecutivo',
                        version = '$version',
                        proceso = '$proceso',
                        norma = '$norma',
                        tipo_documento = $tipoDoc,
                        htmlDoc = '$editorHtml',
                        ubicacion = '$ubicacion',
                        elaboraActualizar = '$elabora',
                        revisaActualizar = '$revisa',
                        apruebaActualizar = '$aprueba',
                        documento_externo = '$documentosExternos',
                        definiciones = '$definiciones',
                        archivo_gestion = '$archivoGestion',
                        archivo_central = '$archivoCentral',
                        archivo_historico = '$archivoHistorico',
                        disposicion_documental = '$dispoDocumental',
                        responsable_disposicion = '$escargadoDispo',
                        usuario_aprovacion_reg = '$select_encargadoAR',
                        mesesRevision = '$mesesRevision',
                        aprobado_elabora_a = '$aprobado_elabora',
                        aprobado_revisa_a = '$aprobado_revisa',
                        aprobado_aprueba_a = '$aprobado_aprueba',
                        nombrePDF = '$nombrePDF',
                        nombreOtro = '$nombreOtro',
                        fechaAprobado = '$fechaAprobado',
                        estadoActualiza = '$estado',
                        vigente = '$vigente',
                        asumeFlujo = NULL
                        WHERE id = '$idDocumento'
     
                        ")or die(mysqli_error($mysqli));
                }
                
                
                
                 
            }
        }else{
            if($nombreOtro == NULL){
            
                if($nombrePDF == NULL){
                    
                    $mysqli->query("UPDATE
                        documento
                        SET
                        nombres = '$nombreDoc',
                        codificacion = '$codificacion',
                        consecutivo = '$consecutivo',
                        version = '$version',
                        proceso = '$proceso',
                        norma = '$norma',
                        tipo_documento = $tipoDoc,
                        htmlDoc = '$editorHtml',
                        ubicacion = '$ubicacion',
                        documento_externo = '$documentosExternos',
                        definiciones = '$definiciones',
                        archivo_gestion = '$archivoGestion',
                        archivo_central = '$archivoCentral',
                        archivo_historico = '$archivoHistorico',
                        disposicion_documental = '$dispoDocumental',
                        responsable_disposicion = '$escargadoDispo',
                        usuario_aprovacion_reg = '$select_encargadoAR',
                        mesesRevision = '$mesesRevision',
                        aprobado_elabora_a = '$aprobado_elabora',
                        aprobado_revisa_a = '$aprobado_revisa',
                        aprobado_aprueba_a = '$aprobado_aprueba',
                        fechaAprobado = '$fechaAprobado',
                        estadoActualiza = '$estado',
                        vigente = '$vigente',
                        asumeFlujo = NULL
                        WHERE id = '$idDocumento'
     
                        ")or die(mysqli_error($mysqli));
                }else{
                    
                    $mysqli->query("UPDATE
                        documento
                        SET
                        nombres = '$nombreDoc',
                        codificacion = '$codificacion',
                        consecutivo = '$consecutivo',
                        version = '$version',
                        proceso = '$proceso',
                        norma = '$norma',
                        tipo_documento = $tipoDoc,
                        htmlDoc = '$editorHtml',
                        ubicacion = '$ubicacion',
                        documento_externo = '$documentosExternos',
                        definiciones = '$definiciones',
                        archivo_gestion = '$archivoGestion',
                        archivo_central = '$archivoCentral',
                        archivo_historico = '$archivoHistorico',
                        disposicion_documental = '$dispoDocumental',
                        responsable_disposicion = '$escargadoDispo',
                        usuario_aprovacion_reg = '$select_encargadoAR',
                        mesesRevision = '$mesesRevision',
                        aprobado_elabora_a = '$aprobado_elabora',
                        aprobado_revisa_a = '$aprobado_revisa',
                        aprobado_aprueba_a = '$aprobado_aprueba',
                        nombrePDF = '$nombrePDF',
                        fechaAprobado = '$fechaAprobado',
                        estadoActualiza = '$estado',
                        vigente = '$vigente',
                        asumeFlujo = NULL
                        WHERE id = '$idDocumento'
     
                        ")or die(mysqli_error($mysqli));
                }
                
                 
            }else{ 
                
                
                if($nombrePDF == NULL){
                    $mysqli->query("UPDATE
                        documento
                        SET
                        nombres = '$nombreDoc',
                        codificacion = '$codificacion',
                        consecutivo = '$consecutivo',
                        version = '$version',
                        proceso = '$proceso',
                        norma = '$norma',
                        tipo_documento = $tipoDoc,
                        htmlDoc = '$editorHtml',
                        ubicacion = '$ubicacion',
                        documento_externo = '$documentosExternos',
                        definiciones = '$definiciones',
                        archivo_gestion = '$archivoGestion',
                        archivo_central = '$archivoCentral',
                        archivo_historico = '$archivoHistorico',
                        disposicion_documental = '$dispoDocumental',
                        responsable_disposicion = '$escargadoDispo',
                        usuario_aprovacion_reg = '$select_encargadoAR',
                        mesesRevision = '$mesesRevision',
                        aprobado_elabora_a = '$aprobado_elabora',
                        aprobado_revisa_a = '$aprobado_revisa',
                        aprobado_aprueba_a = '$aprobado_aprueba',
                        nombreOtro = '$nombreOtro',
                        fechaAprobado = '$fechaAprobado',
                        estadoActualiza = '$estado',
                        vigente = '$vigente',
                        asumeFlujo = NULL
                        WHERE id = '$idDocumento'
     
                        ")or die(mysqli_error($mysqli)); // nombrePDF = '$nombrePDF',
                }else{
                    $mysqli->query("UPDATE
                        documento
                        SET
                        nombres = '$nombreDoc',
                        codificacion = '$codificacion',
                        consecutivo = '$consecutivo',
                        version = '$version',
                        proceso = '$proceso',
                        norma = '$norma',
                        tipo_documento = $tipoDoc,
                        htmlDoc = '$editorHtml',
                        ubicacion = '$ubicacion',
                        documento_externo = '$documentosExternos',
                        definiciones = '$definiciones',
                        archivo_gestion = '$archivoGestion',
                        archivo_central = '$archivoCentral',
                        archivo_historico = '$archivoHistorico',
                        disposicion_documental = '$dispoDocumental',
                        responsable_disposicion = '$escargadoDispo',
                        usuario_aprovacion_reg = '$select_encargadoAR',
                        mesesRevision = '$mesesRevision',
                        aprobado_elabora_a = '$aprobado_elabora',
                        aprobado_revisa_a = '$aprobado_revisa',
                        aprobado_aprueba_a = '$aprobado_aprueba',
                        nombrePDF = '$nombrePDF',
                        nombreOtro = '$nombreOtro',
                        fechaAprobado = '$fechaAprobado',
                        estadoActualiza = '$estado',
                        vigente = '$vigente',
                        asumeFlujo = NULL
                        WHERE id = '$idDocumento'
     
                        ")or die(mysqli_error($mysqli));
                }
                
                
                 
            }
            
        }
        

    if($estadoActual == "Revisado"){
       
        
        if($radioAprobado == 'aprobado' && $flujoAprovacion == 'ajusta'){
            $estado = "Aprobado";
            $aprobado_aprueba = 1;
        
            $envioCorreoEncargado=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE id='$idSolicitud' ");
                    $extraerEnvioCorreoEncargado=$envioCorreoEncargado->fetch_array(MYSQLI_ASSOC);
                     'Quien aprueba: '.$notificarEncargado=$extraerEnvioCorreoEncargado['QuienAprueba'];
                     'Quien aprueba: '.$notificarEncargadoQuienS=$extraerEnvioCorreoEncargado['quienSolicita'];
                    //$nombreDocumento2=utf8_encode($extraerEnvioCorreoEncargado['nombreDocumento2']);
                    $idSolicitudNombre=utf8_encode($extraerEnvioCorreoEncargado['id']);
                    
                    $conformandoNOmbre=$mysqli->query("SELECt * FROm documento WHERE id_solicitud='$idSolicitudNombre' ");
                    $extraerNombreNuevo=$conformandoNOmbre->fetch_array(MYSQLI_ASSOC);
                    $nombreDocumento2=utf8_encode($extraerNombreNuevo['nombres']);
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
                                        $mail->Subject = utf8_decode('Documento aprobado - encargado ');
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
                                        <p><b>El documento '.$nombreDocumento2.' fue aprobado.</b></p>
                                        
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
                                        $mail->Subject = utf8_decode('Documento aprobado - solicitante ');
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
                                        <p><b>El documento '.$nombreDocumento2.' fue aprobado.</b></p>
                                        
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
                $longitud = count($revisaE); 
                for($i=0; $i<$longitud; $i++){
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$revisaE[$i]' ");
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
                                        $mail->Subject = utf8_decode('Documento aprobado - elaborador ');
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
                                        <p><b>El documento '.$nombreDocumento2.' fue aprobado.</b></p>
                                        
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
                $longitud = count($revisaE); 
                for($i=0; $i<$longitud; $i++){
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo = '$revisaE[$i]' ");
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
                        $mail->Subject = utf8_decode('Documento aprobado - elaborador ');
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
                        <p><b>El documento '.$nombreDocumento2.' fue aprobado.</b></p>
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
                                        $mail->Subject = utf8_decode('Documento aprobado - revisor ');
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
                                        <p><b>El documento '.$nombreDocumento2.' fue aprobado.</b></p>
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
                        $mail->Subject = utf8_decode('Documento aprobado - revisor ');
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
                         <p><b>El documento '.$nombreDocumento2.' fue aprobado.</b></p>
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
        if($estado == 'Aprobado'){ //echo 'para la revisi��n';
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
        if($estado == 'Elaborado'){ //echo 'para la revisi��n';

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
        if($estado == 'Revisado'){ //echo 'para aprobaci��n';

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
                $longitud = count($revisaE); 
                for($i=0; $i<$longitud; $i++){
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$revisaE[$i]' ");
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
                $longitud = count($revisaE); 
                for($i=0; $i<$longitud; $i++){
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo = '$revisaE[$i]' ");
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
        //echo '<script language="javascript">alert("Exito al finalizar."); "</script>';
        //header('Location: ../../creacionDocumental');
        //echo '<script language="javascript">
       // window.location.href="../../creacionDocumental"</script>';
    }

    
    
    
}