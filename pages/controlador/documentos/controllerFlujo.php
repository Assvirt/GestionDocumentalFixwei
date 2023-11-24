<?php
date_default_timezone_set("America/Bogota");
require_once '../../conexion/bd.php';
session_start();
error_reporting(E_ERROR);
$idUser = $_SESSION["session_username"];
$idCargo = $_SESSION["session_cargo"];


if(isset($_POST['revisarDoc'])){
    
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
    $elabora = unserialize($_POST['select_encargadoE']);
    $revisaE = unserialize($_POST['select_encargadoE']); /// quien elabora
    $radElabora = $_POST['radiobtnE'];
    //array_unshift($elabora,$radElabora);
    $elabora = json_encode($elabora);
    $revisa = unserialize($_POST['select_encargadoR']);
    $revisaN = unserialize($_POST['select_encargadoR']); // quien revisa
    $radRevisa = $_POST['radiobtnR'];
    //array_unshift($revisa,$radRevisa);
    $revisa = json_encode($revisa);
    $aprueba = unserialize($_POST['select_encargadoA']);
    $apruebaA = unserialize($_POST['select_encargadoA']); // quien aprueba
    $radAprueba = $_POST['radiobtnA'];
    //array_unshift($aprueba,$radAprueba);
    $aprueba = json_encode($aprueba);
    $radCodificacion = $_POST['radCodificacion'];
    $versionDeclarada = $_POST['versionDeclarada'];
    $consecutivoDeclarada = $_POST['consecutivoDeclarado'];
    
    //Datos del segundo fomulario crearDocumento2
    $documentosExternos = unserialize($_POST['documentos_externos']);
    $documentosExternos = json_encode($documentosExternos);
    $definiciones = unserialize($_POST['definiciones']);
    $definiciones = json_encode($definiciones);
    $archivoGestion = utf8_decode($_POST['archivo_gestion']);
    $archivoCentral = utf8_decode($_POST['archivo_central']);
    $archivoHistorico = utf8_decode($_POST['archivo_historico']);
    $dispoDocumental = utf8_decode($_POST['diposicion_documental']); //Disposicon documental
    $escargadoDispo = unserialize($_POST['select_encargadoD']);
    $radDispoDoc = $_POST['radiobtnD'];
    array_unshift($escargadoDispo,$radDispoDoc); 
    $escargadoDispo = json_encode($escargadoDispo);
    
    $editorHtml = utf8_decode($_POST['editorHtml']);
    $nombrePDF = utf8_decode($_POST['nombrePDF']); 
    $nombreOtro = utf8_decode($_POST['nombreOtro']);
    
    
    //Datos tercer formulario crearDocumento3
    $aprovacionRegistros = $_POST['radiobtn'];
    $radArpeuevaRegistros = $_POST['radiobtnAR'];
    
    if($aprovacionRegistros == 'si'){
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
    
    ///Validar en que estado esta para continuar el flujo 
    $queryDoc1 = $mysqli->query("SELECT * FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
    $datosDoc1 = $queryDoc1->fetch_assoc();
    $idSolicitud = $datosDoc1['id_solicitud'];
   
     ///// vaciamos  la tabla temporal de los archivos
    
     $mysqli->query("DELETE FROM documentoArchivoTemporal WHERE solicitud='$idSolicitud' ")or die(mysqli_error($mysqli));
     $mysqli->query("DELETE FROM documentoDatosTemporales WHERE solicitud='$idSolicitud' ")or die(mysqli_error($mysqli));
    //// END
    
     require '../usuarios/libreria/PHPMailerAutoload.php';
    
    
    $fechaAprobado =  date("Y/m/j h:i:s");
    
    $estadoActual = $datosDoc1['estado'];
    
    $aprobado_elabora = 0;
    $aprobado_revisa = 0;
    $aprobado_aprueba = 0;
    
    $vigente = 0;
    
    
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
                                        <p><b>El documento '.$nombreDocumento2.' fue cerrado.</b></p>
                                        
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
                                        Este correo es informativo por tanto, le pedimos no responda este mensaje.
                                        </p>
                                        </body>
                                        </html>
                                        ');
                                        
                                        //Avisar si fue enviado o no y dirigir al index
                                       
                                        if ($mail->Send()) {
                                        
                                        } else {

                                        }
            
            
            
            
            
            $mysqli->query("DELETE FROM documento WHERE id ='$idDocumento' ");
            
            //$mysqli->query("UPDATE documento SET obsoleto = 1, vigente = 0 WHERE id = $idDocumento ");
            
            
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
            //echo "Entro a pendiente";
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
                                        Este correo es informativo por tanto, le pedimos no responda este mensaje.
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
                                        Este correo es informativo por tanto, le pedimos no responda este mensaje.
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
            
            
            
            
            
            $mysqli->query("DELETE FROM documento WHERE id ='$idDocumento' ");
            //$mysqli->query("UPDATE documento SET obsoleto = 1, vigente = 0 WHERE id = $idDocumento ");
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
            
            /// respaldamos los datos cuando se aprueba el documento que lo lleva al listado maestro
                //TIPO DE DOCUMENTO 
                $queryDocumentos = $mysqli->query("SELECT nombre, prefijo from tipoDocumento WHERE id = '".$tipoDoc."' ");
                $datosDocumento = $queryDocumentos->fetch_array(MYSQLI_ASSOC);
                $tipoDocumento = $datosDocumento['nombre'];
                
                
                 'Norma: '.$norma;
                 '<br>';
                
                $resultado=$mysqli->query("SELECT * FROM normatividad");
                $arrayNormas = json_decode($norma);
                $string="";
                while ($columna = mysqli_fetch_array( $resultado )) { 
                    if(in_array($columna['id'],$arrayNormas)){
                    $string .= '"'.$columna['nombre'].'",';
                    }
                }
                $newStrinG=trim($string, ',');
                if($newStrinG != NULL){
                 'Guardar norma: '.$enviarNorma='['.$newStrinG.']';
                }
                
                
                 '<br><br>Documento externo: '.$documentosExternos;
                 '<br>';
                
                $resultadoDE=$mysqli->query("SELECT * FROM documentoExterno");
                $arrayDocumentosE = json_decode($documentosExternos);
                $stringDE="";
                while ($columnaDE = mysqli_fetch_array( $resultadoDE )) { 
                    if(in_array($columnaDE['id'],$arrayDocumentosE)){
                    $stringDE .= '"'.$columnaDE['nombre'].'",';
                    }
                }
                $newStrinGDE=trim($stringDE, ',');
                if($newStrinGDE != NULL){
                 'Guardar documento externo: '.$enviarDE='['.$newStrinGDE.']';
                }
                
                
                 '<br><br>Definición: '.$definiciones;
                 '<br>';
                
                $resultadoDEfinicion=$mysqli->query("SELECT * FROM definicion");
                $arrayDocumentosDefinicion = json_decode($definiciones);
                $stringDEfinicion="";
                while ($columnaDEfinicion = mysqli_fetch_array( $resultadoDEfinicion )) { 
                    if(in_array($columnaDEfinicion['id'],$arrayDocumentosDefinicion)){
                    $stringDEfinicion .= '"'.$columnaDEfinicion['nombre'].'",';
                    }
                }
                $newStrinGDEfinicion=trim($stringDEfinicion, ',');
                if($newStrinGDEfinicion != NULL){
                 'Guardar definción: '.$enviarDefinicion='['.$newStrinGDEfinicion.']';
                }
                
                
                 '<br><br>Encargado de disposición: '.$escargadoDispo;
                 '<br>';
                
                $respondableDispo = json_decode($escargadoDispo);
                if($respondableDispo[0] == 'cargos'){
                    $longitud = count($respondableDispo);
                    
                    $stringEncargadoDisposicionCargos="";                                    
                    for($i=1; $i<$longitud; $i++){
                        
                        $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$respondableDispo[$i]'");
                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                            
                    	$stringEncargadoDisposicionCargos .='"'.$nombres['nombreCargos'].'",';
                    }   
                    $newStrinGEncargadoDisposicionCargos=trim($stringEncargadoDisposicionCargos, ',');
                     'Guardar responsable disposición cargos: '.$enviarEncargadoDisposicion='["cargos",'.$newStrinGEncargadoDisposicionCargos.']';
                }
                
                if($respondableDispo[0] == 'usuarios'){
                    $longitud = count($respondableDispo);
                    
                    $stringEncargadoDisposicionUsuarios="";                                    
                    for($i=1; $i<$longitud; $i++){
                       
                        $queryNombres = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$respondableDispo[$i]'");
                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                            
                    	$stringEncargadoDisposicionUsuarios .='"'.$nombres['nombres'].' '.$nombres['apellidos'].'",';
                    } 
                    $newStrinGEncargadoDisposicionUsuarios=trim($stringEncargadoDisposicionUsuarios, ',');
                     'Guardar responsable disposición usuarios: '.$enviarEncargadoDisposicion='["usuarios",'.$newStrinGEncargadoDisposicionUsuarios.']';
                }
                
                
                 '<br><br>Roles:';
                 '<br>';
                
                $traerroles=$mysqli->query("SELECT * FROM documento WHERE id='$idDocumento' ");
                $exraerRoles=$traerroles->fetch_array(MYSQLI_ASSOC);
                $consultaQuienElabora=$exraerRoles['elabora'];
                $consultaQuienRevisa=$exraerRoles['revisa'];
                $consultaQuienAprueba=$exraerRoles['aprueba'];
                
                $quienElabora = json_decode($consultaQuienElabora);
                if($quienElabora[0] == 'cargos'){
                    $longitud = count($quienElabora);
                    
                    $stringQuienElabora="";                                    
                    for($i=1; $i<$longitud; $i++){
                        
                        $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienElabora[$i]'");
                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                            
                    	$stringQuienElabora .='"'.$nombres['nombreCargos'].'",';
                    }   
                    $newStrinGQuienElabora=trim($stringQuienElabora, ',');
                     'Guardar quien elabora cargos: '.$enviarQuienElabora='["cargos",'.$newStrinGQuienElabora.']';
                }
                
                                                    
                if($quienElabora[0] == 'usuarios'){
                    $longitud = count($quienElabora);
                    
                    $stringQuienElaboraU="";                                    
                    for($i=1; $i<$longitud; $i++){
                       
                        $queryNombres = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$quienElabora[$i]'");
                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                            
                    	$stringQuienElaboraU .='"'.$nombres['nombres'].' '.$nombres['apellidos'].'",';
                    } 
                    $newStrinGQuienElaboraU=trim($stringQuienElaboraU, ',');
                     'Guardar quien elabora usuarios: '.$enviarQuienElabora='["usuarios",'.$newStrinGQuienElaboraU.']';
                }
                
                
                 '<br>';
                
                $quienRevisa = json_decode($consultaQuienRevisa);
                if($quienRevisa[0] == 'cargos'){
                    $longitud = count($quienRevisa);
                    
                    $stringQuienRevisa="";                                    
                    for($i=1; $i<$longitud; $i++){
                        
                        $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienRevisa[$i]'");
                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                            
                    	$stringQuienRevisa .='"'.$nombres['nombreCargos'].'",';
                    }   
                    $newStrinGQuienRevisa=trim($stringQuienRevisa, ',');
                     'Guardar quien revisa cargos: '.$enviarQuienRevisa='["cargos",'.$newStrinGQuienRevisa.']';
                }
                
                                                    
                if($quienRevisa[0] == 'usuarios'){
                    $longitud = count($quienRevisa);
                    
                    $stringQuienERevisaU="";                                    
                    for($i=1; $i<$longitud; $i++){
                       
                        $queryNombres = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$quienRevisa[$i]'");
                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                            
                    	$stringQuienERevisaU .='"'.$nombres['nombres'].' '.$nombres['apellidos'].'",';
                    } 
                    $newStrinGQuienERevisaU=trim($stringQuienERevisaU, ',');
                     'Guardar quien revisa usuarios: '.$enviarQuienRevisa='["usuarios",'.$newStrinGQuienERevisaU.']';
                }
                
                 '<br>';
                
                $quienAprueba = json_decode($consultaQuienAprueba);
                if($quienAprueba[0] == 'cargos'){
                    $longitud = count($quienAprueba);
                    
                    $stringQuienAprueba="";                                    
                    for($i=1; $i<$longitud; $i++){
                        
                        $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienAprueba[$i]'");
                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                            
                    	$stringQuienAprueba .='"'.$nombres['nombreCargos'].'",';
                    }   
                    $newStrinGQuienAprueba=trim($stringQuienAprueba, ',');
                     'Guardar quien aprueba cargos: '.$enviarQuienAprueba='["cargos",'.$newStrinGQuienAprueba.']';
                }
                
                                                    
                if($quienAprueba[0] == 'usuarios'){
                    $longitud = count($quienAprueba);
                    
                    $stringQuienApruebaU="";                                    
                    for($i=1; $i<$longitud; $i++){
                       
                        $queryNombres = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$quienAprueba[$i]'");
                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                            
                    	$stringQuienApruebaU .='"'.$nombres['nombres'].' '.$nombres['apellidos'].'",';
                    } 
                    $newStrinGQuienApruebaU=trim($stringQuienApruebaU, ',');
                     'Guardar quien revisa usuarios: '.$enviarQuienAprueba='["usuarios",'.$newStrinGQuienApruebaU.']';
                }
                
                $mysqli->query("UPDATE documento SET nombreTipoD='$tipoDocumento', normaNombre='$enviarNorma', externoNombre='$enviarDE', definicionNombre='$enviarDefinicion', disposicionNombre='$enviarEncargadoDisposicion', elaboraNombre='$enviarQuienElabora', revisaNombre='$enviarQuienRevisa', apruebaNombre='$enviarQuienAprueba' WHERE id='$idDocumento' ");
            
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
                                        Este correo es informativo por tanto, le pedimos no responda este mensaje.
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
                                        Este correo es informativo por tanto, le pedimos no responda este mensaje.
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
            
            
            $mysqli->query("DELETE FROM documento WHERE id ='$idDocumento' ");
            //$mysqli->query("UPDATE documento SET obsoleto = 1, vigente = 0 WHERE id = $idDocumento ");
        }
        
        if($estado == 'Aprobado'){
            
            //echo "Entro al if  ".$idDocumento;
            $aprobado_aprueba = 1;
            $idSolicitud = $datosDoc1['id_solicitud'];
            $fechaAprobado =  date("Y/m/j h:i:s");
            $fechaCierre = date("Y/m/j");
            $vigente = 1;
            //$mysqli->query("UPDATE documento SET vigente='1', aprobado_aprueba='1', aprobado_revisa='0' WHERE id='$idDocumento'");
            $mysqli->query("UPDATE solicitudDocumentos SET estado = 'Ejecutado', fechaCierre = '$fechaCierre' WHERE id = $idSolicitud ");
        }
        
    }
    
   
   /// salvaguardamos el nombre cada vez que se cambie el nombre para mantener la validación de solicitud
   
    $mysqli->query("UPDATE solicitudDocumentos SET nombreSalvar = '$nombreDoc' WHERE id = '$idSolicitud' ");
   
   /// end
    
    
    //echo "estado final: ".$estado;


    //PROCESO            
    $roles=$row['cargo'];
    $queryProcesos = $mysqli->query("SELECT nombre,prefijo from procesos WHERE id = '".$proceso."' ");
    $datosProceso = $queryProcesos->fetch_array(MYSQLI_ASSOC);
    $nomProceso = $datosProceso['nombre'];
    $prefijoProceso = $datosProceso['prefijo'];
    

    //TIPO DE DOCUMENTO 
    $queryDocumentos = $mysqli->query("SELECT nombre, prefijo from tipoDocumento WHERE id = '".$tipoDoc."' ");
    $datosDocumento = $queryDocumentos->fetch_array(MYSQLI_ASSOC);
    $tipoDocumento = $datosDocumento['nombre'];
    $prefijoTipo = $datosDocumento['prefijo']; 
    
    //VERSION Y CONSECUTIVO
    $queryVersiones = $mysqli->query("SELECT * FROM versionamiento WHERE idProceso = '$proceso' AND idTipoDocumento = '$tipoDoc'"); //Consecutivo y version cuando son definidos por el cliente
    $datosVersiones = $queryVersiones->fetch_assoc();
    $versionInicial = $datosVersiones['versionInicial'];
    $consecutivoIncial = $datosVersiones['consecutivoInicial'];
    
    if($radCodificacion == 'automatico'){
        /*
        //echo "<br>AUTOMATICO<br>";
        
        $queryDoc = $mysqli->query("SELECT MAX(consecutivo) AS consecutivo, version FROM documento WHERE tipo_documento = $tipoDoc AND proceso = '$proceso' AND aprobado_aprueba = 1 AND tipoCodificacion = 'automatico'")or die(mysqli_error($mysqli));
        $datosDoc = $queryDoc->fetch_assoc();
        
        $consecutivo = $datosDoc['consecutivo']+1;
        $version = $datosDoc['version'];
        
        //Validar el consecutivo no se repita con uno manual
        $queryDocCon = $mysqli->query("SELECT consecutivo FROM documento WHERE consecutivo = '$consecutivo' AND tipo_documento = $tipoDoc AND proceso = '$proceso' AND aprobado_aprueba = 1 AND tipoCodificacion = 'manual'")or die(mysqli_error($mysqli));
        $datosDocCon = $queryDocCon->fetch_assoc();
        if($datosDocCon['consecutivo'] == $consecutivo){
            $consecutivo = $consecutivo+1;
        }
        
        if($version == 0){
            $version = 1;
        }else{
            $version = $version;
        }
        */
        
        
        // validamos la existencia de este proceso
         'Tipo de documento: '.$tipoDoc;
         '<br>Proceso: '.$proceso;
        $consultamosExistenciaDocumento=$mysqli->query("SELECT * FROM documento WHERE tipo_documento = '$tipoDoc' AND proceso = '$proceso'  ORDER BY consecutivo DESC "); //AND  vigente='1' id='$idDocumento' AND aprobado_aprueba='1'
        $contadorVigente=0;
        $contadorObsoleto=0;
        while($extraemosExistenciaDocumento=$consultamosExistenciaDocumento->fetch_array()){
        
        
            if($extraemosExistenciaDocumento['proceso'] && $extraemosExistenciaDocumento['tipo_documento'] && $extraemosExistenciaDocumento['consecutivo'] && $extraemosExistenciaDocumento['version'] && $extraemosExistenciaDocumento['vigente'] == 1){
                $contadorVigente++;
            }
            if($extraemosExistenciaDocumento['proceso'] && $extraemosExistenciaDocumento['tipo_documento'] && $extraemosExistenciaDocumento['consecutivo'] && $extraemosExistenciaDocumento['version'] && $extraemosExistenciaDocumento['obsoleto'] == 1){
                $contadorObsoleto++;
            } 
        }
        
        
        
         //'<br>último id: '.$extraemosExistenciaDocumento['id'];
        // '<br>Aprueba aprobado: '.$almacenarVariableAprobado=$extraemosExistenciaDocumento['aprobado_aprueba'];
         
         
        if($contadorVigente >= '1' ){
            /// buscamos existencia por tipo de documento, proceso y vigente
            //if($almacenarVariableAprobado == '1' && $extraemosExistenciaDocumento['vigente'] == '1' ){
             '<br><br>';
             '<br>Debe consultar VIGENTE';
             '<br>'.$tipoDoc;
             '<br>'.$proceso;
            $queryDoc = $mysqli->query("SELECT * FROM documento WHERE tipo_documento = '$tipoDoc' AND proceso = '$proceso' AND aprobado_aprueba = '1' AND vigente='1' ORDER BY consecutivo DESC")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
             '<br>validando Consecutivo: '.$consecutivo = $datosDoc['consecutivo']+1;
             '<br>validando Version: '.$version = $datosDoc['version'];
            
            
            $existenciaConsecutivo=$mysqli->query("SELECT * FROM documento WHERE tipo_documento='$tipoDoc' AND proceso='$proceso' AND aprobado_aprueba='1' AND vigente='1'  "); //AND consecutivo='$consecutivo'
            $extraerExistenciaConsecutivo=$existenciaConsecutivo->fetch_array(MYSQLI_ASSOC);
             '<br>Consecutivo existente: '.$validnadoConsecutivoExistente=$extraerExistenciaConsecutivo['consecutivo'];
            
                if($consecutivo > $validnadoConsecutivoExistente){
                    $version = 1;
                }else{
                    $version =$version;
                }
                 '<br>Version que sale: '.$version;
            //}
            
             '<br>consecutivo que sale en obsoleto: '.$consecutivo;
                 '<br>Version que sale en obsoleto: '.$version;
        }
        
        echo '<br>';
         'consecutivo saliente: '.$consecutivo;
         'versión saliente: '.$version;
        echo '<br>';
        
        
        if($contadorObsoleto >= '1'){
            //if($almacenarVariableAprobado == '1' && $extraemosExistenciaDocumento['obsoleto'] == '1'){
                   
                     '<br>Debe consultar OBSOLETO';
                    '<br>'.$tipoDoc;
                     '<br>'.$proceso;
                    /// traemos el ultim digito mayor
                    $queryDocNumeroMayor = $mysqli->query("SELECT max(consecutivo) AS ultimoNnumero FROM documento WHERE tipo_documento = '$tipoDoc' AND proceso = '$proceso' AND aprobado_aprueba = '1' ORDER BY consecutivo DESC")or die(mysqli_error($mysqli));
                    $datosDocNumeroMayor = $queryDocNumeroMayor->fetch_assoc();
                    $ultimoNumeroConsecutivo=$datosDocNumeroMayor['ultimoNnumero'];
                    
                    $queryDoc = $mysqli->query("SELECT * FROM documento WHERE tipo_documento = '$tipoDoc' AND proceso = '$proceso' AND aprobado_aprueba = '1' AND obsoleto='1' ORDER BY consecutivo DESC")or die(mysqli_error($mysqli));
                    $datosDoc = $queryDoc->fetch_assoc();
                     '<br>Consecutivo: '.$consecutivo = $ultimoNumeroConsecutivo+1;
                     '<br>Version: '.$version = $datosDoc['version'];
                    
                $existenciaConsecutivo=$mysqli->query("SELECT * FROM documento WHERE tipo_documento='$tipoDoc' AND proceso='$proceso' AND aprobado_aprueba='1'  AND obsoleto='1' "); //AND consecutivo='$consecutivo'
                $extraerExistenciaConsecutivo=$existenciaConsecutivo->fetch_array(MYSQLI_ASSOC);
                '<br>Consecutivo existente: '.$validnadoConsecutivoExistente=$extraerExistenciaConsecutivo['consecutivo'];
            
                if($consecutivo > $validnadoConsecutivoExistente){
                    $version = 1;
                }else{
                    $version =$version;
                }
                 '<br>consecutivo que sale en obsoleto: '.$consecutivo;
                 '<br>Version que sale en obsoleto: '.$version;
                    
            //}
        }
        
        if($contadorVigente == 0 && $contadorObsoleto == 0){
        
            //// se valida sobre obsoletos
            
         '<br>no encuentra nada en vigente y tampoco en obsoleto';
         '<br>T.documento: '.$tipoDoc;
         '<br>Proceso: '.$proceso;
                            /// en caso que el if no se cumpla, traemos el documento que se está trabajando y sacamos el mismo consecutivo y versión
                            $consultamosExistenciaDocumento=$mysqli->query("SELECT * FROM documento WHERE id='$idDocumento'  ");
                            $extraemosExistenciaDocumento=$consultamosExistenciaDocumento->fetch_array(MYSQLI_ASSOC);
                             '<br>Consecutigo: '.$consecutivo = $extraemosExistenciaDocumento['consecutivo'];
                             '<br>Versión: '.$version = $extraemosExistenciaDocumento['version'];
                            
                            
                            //// hacemos una validación para tener un conteo maximo de 2 registros y que estos sean diferentes a la aprobación
                            //// para mandar el primero registro como consecutivo 1 y versión 1
                            $consultamosExistenciaDocumentoCantidadContando=$mysqli->query("SELECT count(*) FROM documento WHERE estado='Aprobado' ");
                            $extraemosExistenciaDocumentoCantidadContando=$consultamosExistenciaDocumentoCantidadContando->fetch_array(MYSQLI_ASSOC);
                             '<br>Cantidad: '.$cantidadContando = $extraemosExistenciaDocumentoCantidadContando['count(*)'];
                            if($cantidadContando == 0){
                                 '<br>Consecutigo: '.$consecutivo =1;
                                 '<br>Versión: '.$version =1;
                            }else{
                                //AND estado='Revisado'
                                $queryDocSegundaValida = $mysqli->query("SELECT * FROM documento WHERE tipo_documento = '$tipoDoc' AND proceso = '$proceso'  ORDER BY consecutivo DESC")or die(mysqli_error($mysqli));
                                $datosDocSegundaValida = $queryDocSegundaValida->fetch_assoc();
                                
                                
                                //if($datosDocSegundaValida['id'] != NULL){ 
                                     'Inicia consecutivo';
                                     '<br>Consecutivo: '.$consecutivo =1;
                                     '<br>Version: '.$version =1;
                                /*}else{ 
                                    echo '* continua con el mismo consecutivo';
                                  //echo 'Se lleva el mismo consecutivo y version';
                                    echo  '<br>Consecutivo: '.$consecutivo = $extraemosExistenciaDocumento['consecutivo'];
                                    echo  '<br>Versión: '.$version = $extraemosExistenciaDocumento['version'];    
                                }*/
                                
                                
                                
                            }
                            
                            
        
        }
    
    
    
    }
    
    //echo 'consecutivo: '.$consecutivo;
    //echo '<br>Versión: '.$version;
    
    
    /// agregamos este update para permitir validar bien el consecutivo y versionamiento
    if($estadoActual == "Revisado"){
         if($estado == 'Aprobado'){
            $mysqli->query("UPDATE documento SET vigente='1', aprobado_aprueba='1', aprobado_revisa='0' WHERE id='$idDocumento'");
        }
        
    }
    /// end
    
    
    if($radCodificacion == 'manual'){
        //echo "<br>MANUAL<br>";
        $version = $versionDeclarada;
        $consecutivo = $consecutivoDeclarada;
    }

    
   
   
    //CODIFICACION
    $codificacion = "";
    $dataCodificacion = $mysqli->query("SELECT * FROM codificacion ORDER BY id")or die(mysqli_error());
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

                    $envioEncargado=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE id='$idSolicitud' ");
                    $extraerEncargado=$envioEncargado->fetch_array(MYSQLI_ASSOC);
                    $tipoSolicitud=$extraerEncargado['tipoSolicitud'];
                    
                    // almacenamos el nombre del usuario
                    $consultaNombreUsuario=$mysqli->query("SELECT * FROM usuario WHERe cedula='$idUser' ");
                    $extraerConsultaNombreUsuario=$consultaNombreUsuario->fetch_array(MYSQLI_ASSOC);
                    $nombreUsuario=$extraerConsultaNombreUsuario['nombres'].' '.$extraerConsultaNombreUsuario['apellidos'];
                    
    if($controlCambios != NULL){
        $mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuario, fecha, rol, idRespaldo, tipoSolicitud,nombre) VALUES('$idSolicitud','$controlCambios','$idUser','$fecha','$rol', '$idDocumento', '$tipoSolicitud','$nombreUsuario')")or die(mysqli_error($mysqli));
    }else{
        $mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuario, fecha, rol, idRespaldo, tipoSolicitud,nombre) VALUES('$idSolicitud','N/A','$idUser','$fecha','$rol', '$idDocumento', '$tipoSolicitud','$nombreUsuario')")or die(mysqli_error($mysqli));
    }
    
    //// este espacio se crea para el control de cambios el procedimiento del flujo de aprobación del documento
    $informacion=utf8_decode($_POST['editor1']);
    
    $consultamosExistenciaComentario=$mysqli->query("SELECT * FROM controlCambiosFlujo WHERE idDocumento='$idDocumento' ");
    $extrarConsultaExistenciaComentario=$consultamosExistenciaComentario->fetch_array(MYSQLI_ASSOC);
    if($extrarConsultaExistenciaComentario['idDocumento'] != NULL){
        if($radioAprobado == 'aprobado' && $flujoAprovacion == 'ajusta'){ 
            $mysqli->query("UPDATE controlCambiosFlujo SET informacion='$informacion', comentarioAnterior='$informacion', fecha='$fecha' WHERE idDocumento='$idDocumento' ")or die(mysqli_error($mysqli));
        }else{ 
            $mysqli->query("UPDATE controlCambiosFlujo SET informacion='$informacion', fecha='$fecha' WHERE idDocumento='$idDocumento' ");
        }
    }else{
        $mysqli->query("INSERT INTO controlCambiosFlujo (idDocumento,informacion,fecha)VALUES('$idDocumento','$informacion','$fecha')");
    }
    //// end
    
    //// vamos actualizar el nombre del proceso cada vez que se cambie
     $mysqli->query("UPDATE documento SET  nombreProceso='$nomProceso', tipoSolicitud='1' WHERE id = '$idDocumento' ");
    /// end
    
    if($estado == "Rechazado"){
        
        $idSolicitud;
        $mysqli->query("UPDATE documento SET estado = 'Rechazado', vigente = '0', asumeFlujo = NULL WHERE id_solicitud = '$idSolicitud' ");
       
        
        
        
        
        if($radioAprobado == 'rechazado' && $flujoAprovacion == 'cierra'){
             $mysqli->query("UPDATE solicitudDocumentos SET estado = 'Rechazado' WHERE id = '$idSolicitud' ");
        }else{
        
         if($radioAprobado == 'rechazado' && $flujoAprovacion == 'reinicia'){
                
                    //A pesar que se rechza y se devuelve debe permitir agregar cambios                               
                                        
                        if($nombreOtro == NULL){
                        //echo "IF 1";
                        
                            if($nombrePDF == NULL){
                                $mysqli->query("UPDATE
                                    documento
                                    SET
                                    nombres = '$nombreDoc',
                                    codificacion = '$codificacion',
                                    tipoCodificacion = '$radCodificacion',
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
                                    aprobado_elabora = '$aprobado_elabora',
                                    aprobado_revisa = '$aprobado_revisa',
                                    aprobado_aprueba = '$aprobado_aprueba',
                                    fechaAprobado = '$fechaAprobado',
                                    estado = '$estado',
                                    vigente = '$vigente',
                                    asumeFlujo = NULL
                                    WHERE id = $idDocumento ")or die(mysqli_error($mysqli));
                                
                            }else{
                                $mysqli->query("UPDATE
                                    documento
                                    SET
                                    nombres = '$nombreDoc',
                                    codificacion = '$codificacion',
                                    tipoCodificacion = '$radCodificacion',
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
                                    aprobado_elabora = '$aprobado_elabora',
                                    aprobado_revisa = '$aprobado_revisa',
                                    aprobado_aprueba = '$aprobado_aprueba',
                                    nombrePDF = '$nombrePDF',
                                    fechaAprobado = '$fechaAprobado',
                                    estado = '$estado',
                                    vigente = '$vigente',
                                    asumeFlujo = NULL
                                    WHERE id = $idDocumento ")or die(mysqli_error($mysqli));
                            }
                         
                        }else{
                            //echo "IF 2";
                            if($nombrePDF == NULL){
                            $mysqli->query("UPDATE
                                    documento
                                    SET
                                    nombres = '$nombreDoc',
                                    codificacion = '$codificacion',
                                    tipoCodificacion = '$radCodificacion',
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
                                    aprobado_elabora = '$aprobado_elabora',
                                    aprobado_revisa = '$aprobado_revisa',
                                    aprobado_aprueba = '$aprobado_aprueba',
                                    nombreOtro = '$nombreOtro',
                                    fechaAprobado = '$fechaAprobado',
                                    estado = '$estado',
                                    vigente = '$vigente',
                                    asumeFlujo = NULL
                                    WHERE id = '$idDocumento'")or die(mysqli_error($mysqli)); //nombrePDF = '$nombrePDF',
                            }else{
                                $mysqli->query("UPDATE
                                    documento
                                    SET
                                    nombres = '$nombreDoc',
                                    codificacion = '$codificacion',
                                    tipoCodificacion = '$radCodificacion',
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
                                    aprobado_elabora = '$aprobado_elabora',
                                    aprobado_revisa = '$aprobado_revisa',
                                    aprobado_aprueba = '$aprobado_aprueba',
                                    nombrePDF = '$nombrePDF',
                                    nombreOtro = '$nombreOtro',
                                    fechaAprobado = '$fechaAprobado',
                                    estado = '$estado',
                                    vigente = '$vigente',
                                    asumeFlujo = NULL
                                    WHERE id = '$idDocumento'")or die(mysqli_error($mysqli));
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
                                        $mail->Subject = utf8_decode('Solicitud de documento  ');
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
                                        <p><b>Ha sido asignado para aprobar la solicitud de creación del documento '.$nombreDocumento2.'.</b></p>
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
                                        
                                        
                                        
        //Finaliza los cambios aplicados/
        
        
        
         }else{
              $mysqli->query("UPDATE solicitudDocumentos SET estado = 'Rechazado' WHERE id = '$idSolicitud' ");
         }
        
        }    
        
        
        
        if($radioAprobado == 'rechazado' && $flujoAprovacion == 'reinicia'){
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../creacionDocumental" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionRegreso" value="1">
            </form> 
        <?php
         }else{
        
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../creacionDocumental" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminar" value="1">
            </form> 
        <?php
         }
    }else{
       
        if($nombreOtro == NULL){
            //echo "IF 1";
            
            if($nombrePDF == NULL){
                $mysqli->query("UPDATE
                    documento
                    SET
                    nombres = '$nombreDoc',
                    codificacion = '$codificacion',
                    tipoCodificacion = '$radCodificacion',
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
                    aprobado_elabora = '$aprobado_elabora',
                    aprobado_revisa = '$aprobado_revisa',
                    aprobado_aprueba = '$aprobado_aprueba',
                    fechaAprobado = '$fechaAprobado',
                    estado = '$estado',
                    vigente = '$vigente',
                    asumeFlujo = NULL
                    WHERE id = $idDocumento ")or die(mysqli_error($mysqli));
                
            }else{
                $mysqli->query("UPDATE
                    documento
                    SET
                    nombres = '$nombreDoc',
                    codificacion = '$codificacion',
                    tipoCodificacion = '$radCodificacion',
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
                    aprobado_elabora = '$aprobado_elabora',
                    aprobado_revisa = '$aprobado_revisa',
                    aprobado_aprueba = '$aprobado_aprueba',
                    nombrePDF = '$nombrePDF',
                    fechaAprobado = '$fechaAprobado',
                    estado = '$estado',
                    vigente = '$vigente',
                    asumeFlujo = NULL
                    WHERE id = $idDocumento ")or die(mysqli_error($mysqli));
            }
             
        }else{
            //echo "IF 2";
            
            if($nombrePDF == NULL){
            
                    $mysqli->query("UPDATE
                    documento
                    SET
                    nombres = '$nombreDoc',
                    codificacion = '$codificacion',
                    tipoCodificacion = '$radCodificacion',
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
                    aprobado_elabora = '$aprobado_elabora',
                    aprobado_revisa = '$aprobado_revisa',
                    aprobado_aprueba = '$aprobado_aprueba',
                    nombreOtro = '$nombreOtro',
                    fechaAprobado = '$fechaAprobado',
                    estado = '$estado',
                    vigente = '$vigente',
                    asumeFlujo = NULL
                    WHERE id = '$idDocumento'")or die(mysqli_error($mysqli)); //nombrePDF = '$nombrePDF',
            }else{
                 $mysqli->query("UPDATE
                    documento
                    SET
                    nombres = '$nombreDoc',
                    codificacion = '$codificacion',
                    tipoCodificacion = '$radCodificacion',
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
                    aprobado_elabora = '$aprobado_elabora',
                    aprobado_revisa = '$aprobado_revisa',
                    aprobado_aprueba = '$aprobado_aprueba',
                    nombreOtro = '$nombreOtro',
                    nombrePDF = '$nombrePDF',
                    fechaAprobado = '$fechaAprobado',
                    estado = '$estado',
                    vigente = '$vigente',
                    asumeFlujo = NULL
                    WHERE id = '$idDocumento'")or die(mysqli_error($mysqli)); 
            }
             
        }
      
      
      
      
      
      
      
       if($estadoActual == "Revisado"){
           if($radioAprobado == 'aprobado' && $flujoAprovacion == 'ajusta'){
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
                                        Este correo es informativo por tanto, le pedimos no responda este mensaje.
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
                                        Este correo es informativo por tanto, le pedimos no responda este mensaje.
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
      
      
      
      
      
      
      
      
        if($estado == 'Aprobado'){ //echo 'para la revisión';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../creacionDocumental" method="POST" onsubmit="procesar(this.action);" >
                <!--<input type="submit" value="Enviar D">-->
                <input type="hidden" name="validacionAgregarD" value="1">
            </form> 
        <?php
        }
        if($estado == 'Elaborado'){ 
        
            //$nombreDoc=$_POST['nombreDocumento'];
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



        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../creacionDocumental" method="POST" onsubmit="procesar(this.action);" >
                 <!--<input type="submit" value="Enviar">-->
                <input type="hidden" name="validacionAgregarB" value="1">
            </form> 
        <?php
        }
        if($estado == 'Revisado'){ //echo 'para aprobación';
            //$nombreDoc=$_POST['nombreDocumento'];
            'Dato: '.$radAprueba;
            '<br>';
            $elabora;
            if($radAprueba == 'usuarios'){
                $longitud = count($apruebaA); 
                for($i=0; $i<$longitud; $i++){
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$apruebaA[$i]' ");
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

            if($radAprueba == 'cargos'){
                 'Cargos';
                $longitud = count($apruebaA); 
                for($i=0; $i<$longitud; $i++){
                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo = '$apruebaA[$i]' ");
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
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../creacionDocumental" method="POST" onsubmit="procesar(this.action);" >
                 <!--<input type="submit" value="Enviar C">-->
                <input type="hidden" name="validacionAgregarC" value="1">
            </form> 
        <?php
        }
        if($estado == 'Pendiente'){ //echo 'para elaborar';

         //   $nombreDoc=$_POST['nombreDocumento'];
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
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../creacionDocumental" method="POST" onsubmit="procesar(this.action);" >
                <!--<input type="submit" value="Enviar"> -->
                <input type="hidden" name="validacionAgregar" value="1">
            </form> 
        <?php
        }
        
      
      
        
      
    }

    
   
    
}

