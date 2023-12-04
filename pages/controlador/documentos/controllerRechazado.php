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
    
    
   
    
    $fechaAprobado =  date("Y/m/j h:i:s");
    
    ///Validar en que estado esta para continuar el flujo 
    $queryDoc1 = $mysqli->query("SELECT * FROM documento WHERE id = '$idDocumento'")or die(mysqli_error($mysqli));
    $datosDoc1 = $queryDoc1->fetch_assoc();
    
   
                
    
    $NotifiacionElaborador=$datosDoc1['plataformaH'];
    $NotifiacionRevisa=$datosDoc1['plataformaHRevisa'];
    $NotifiacionAprueba=$datosDoc1['plataformaHAprueba'];
    
     // validamos que tipo de solicitud viene el documento
    $validamosTipoDocumento=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE id='".$datosDoc1['id_solicitud']."' ");
    $extraerValidamosTP=$validamosTipoDocumento->fetch_array(MYSQLI_ASSOC);
    $tipoSolicitud=$extraerValidamosTP['tipoSolicitud'];
    /// end
   
     
    if($extraerValidamosTP['tipoSolicitud'] == '1'){
          $estadoActual = $datosDoc1['estado'];
    }elseif($extraerValidamosTP['tipoSolicitud'] == '2'){
          $estadoActual = $datosDoc1['estadoActualiza'];
    }elseif($extraerValidamosTP['tipoSolicitud'] == '3'){
          $estadoActual = $datosDoc1['estadoElimina'];
    }
    
    
    $aprobado_elabora = 0;
    $aprobado_revisa = 0;
    $aprobado_aprueba = 0;
    
    $vigente = 0;
    
    $fecha = date("Y:m:j");
    $idAnterior = $datosDoc1['idAnterior'];
    
    
   
   /// salvaguardamos el nombre cada vez que se cambie el nombre para mantener la validación de solicitud
     $mysqli->query("UPDATE solicitudDocumentos SET nombreSalvar = '$nombreDoc' WHERE id = '$idSolicitud' ");
    /// end
   
   require '../usuarios/libreria/PHPMailerAutoload.php';
   
    if($radioAprobado == 'rechazado' && $flujoAprovacion == 'cierra'){
            $estado = "Rechazado";
            $aprobado_elabora = 0;
            $fechaCierre =  date("Y/m/j");
            $idSolicitud = $datosDoc1['id_solicitud'];
            $mysqli->query("UPDATE solicitudDocumentos SET estado = '$estado', fechaCierre = '$fechaCierre', regresa = NULL WHERE id = '$idSolicitud' ")or die(mysqli_error($mysqli));
            
            /// se actualiza el revisado del documento anterior para enviar revisado = 0
            $mysqli->query("UPDATE documento SET ultimaFechaRevision = '$fechaCierre', usuarioRevisa = NULL, revisado = 0 WHERE id='$idAnterior'");
            // end
            
            $mysqli->query("DELETE FROM `controlCambios` WHERE idRespaldo='".$_POST['idDocumento']."' AND tipoSolicitud='3' ");
            
                    $envioCorreoEncargado=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE id='$idSolicitud' ");
                    $extraerEnvioCorreoEncargado=$envioCorreoEncargado->fetch_array(MYSQLI_ASSOC);
                    'Quien aprueba: '.$notificarEncargado=$extraerEnvioCorreoEncargado['QuienAprueba'];
                    'Quien aprueba: '.$notificarEncargadoQuienS=$extraerEnvioCorreoEncargado['quienSolicita'];
                    //$nombreDocumento2=utf8_encode($extraerEnvioCorreoEncargado['nombreDocumento2']);
                    $idSolicitudNombre=utf8_encode($extraerEnvioCorreoEncargado['id']);
                    
                    $conformandoNOmbre=$mysqli->query("SELECt * FROm documento WHERE id_solicitud='$idSolicitudNombre' ");
                    $extraerNombreNuevo=$conformandoNOmbre->fetch_array(MYSQLI_ASSOC);
                    $nombreDocumento2=utf8_encode($extraerNombreNuevo['nombres']);
                    
                    /*
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
                                        */
                                        
                                        
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
            
            
            //echo 'rechazado';
            
            if($extraerValidamosTP['tipoSolicitud'] == '1'){
                    $mysqli->query("DELETE FROM documento WHERE id ='$idDocumento' ");
            }elseif($extraerValidamosTP['tipoSolicitud'] == '2'){
                    $mysqli->query("DELETE FROM documento WHERE id ='$idDocumento' ");
            }elseif($extraerValidamosTP['tipoSolicitud'] == '3'){
                    $mysqli->query("UPDATE documento SET asumeFlujo = NULL, estadoElimina = NULL, elaboraElimanar = NULL, revisaElimanar= NULL, apruebaElimanar=NULL WHERE id='$idDocumento'")or die(mysqli_error($mysqli));  
            }
            
    }else{
   
         if($estadoActual == "Rechazado"){
            
           
            
            if($radioAprobado == 'aprobado' && $flujoAprovacion == 'ajusta'){
                $estado = "Pendiente";
                $aprobado_elabora = 1;
            }
            
           
              
                $aprobado_elabora = 0;
                $fechaCierre =  date("Y/m/j");
                $idSolicitud = $datosDoc1['id_solicitud'];
                $mysqli->query("UPDATE solicitudDocumentos SET estado = 'Aprobado', regresa = NULL WHERE id = $idSolicitud ")or die(mysqli_error($mysqli));
                
                if($extraerValidamosTP['tipoSolicitud'] == '1'){
                    $mysqli->query("UPDATE documento SET asumeFlujo = NULL, estado = '$estado' WHERE id='$idDocumento'");
                }elseif($extraerValidamosTP['tipoSolicitud'] == '2'){
                    $mysqli->query("UPDATE documento SET asumeFlujo = NULL, estadoActualiza = '$estado' WHERE id='$idDocumento'");
                }elseif($extraerValidamosTP['tipoSolicitud'] == '3'){
                    $mysqli->query("UPDATE documento SET asumeFlujo = NULL, estadoElimina = '$estado' WHERE id='$idDocumento'");  
                }
                
                
                //$mysqli->query("DELETE FROM documento WHERE id ='$idDocumento'");
        }
    }
  
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

    
    if($radioAprobado == 'rechazado' && $flujoAprovacion == 'cierra'){
         
    }else{
                    // almacenamos el nombre del usuario
                    $consultaNombreUsuario=$mysqli->query("SELECT * FROM usuario WHERe cedula='$idUser' ");
                    $extraerConsultaNombreUsuario=$consultaNombreUsuario->fetch_array(MYSQLI_ASSOC);
                    $nombreUsuario=$extraerConsultaNombreUsuario['nombres'].' '.$extraerConsultaNombreUsuario['apellidos'];
        if($controlCambios != NULL){
            $mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuario, fecha, rol, idRespaldo, tipoSolicitud,nombre) VALUES('$idSolicitud','$controlCambios','$idUser','$fecha','$rol','$idDocumento', '$tipoSolicitud','$nombreUsuario')")or die(mysqli_error($mysqli));
        }else{
            $mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuario, fecha, rol, idRespaldo, tipoSolicitud,nombre) VALUES('$idSolicitud','N/A','$idUser','$fecha','$rol','$idDocumento', '$tipoSolicitud','$nombreUsuario')")or die(mysqli_error($mysqli));
        }
    }
      //// este espacio se crea para el control de cambios el procedimiento del flujo de aprobación del documento
    $informacion=utf8_decode($_POST['editor1']);
    $idAnteriorControlCambios=$_POST['idAnteriorControlCambios'];
    $consultamosExistenciaComentario=$mysqli->query("SELECT * FROM controlCambiosFlujo WHERE idDocumento='$idAnteriorControlCambios' ");
    $extrarConsultaExistenciaComentario=$consultamosExistenciaComentario->fetch_array(MYSQLI_ASSOC);
     if($radioAprobado == 'rechazado' && $flujoAprovacion == 'cierra'){
        $mysqli->query("UPDATE controlCambiosFlujo SET informacion='".$extrarConsultaExistenciaComentario['comentarioAnterior']."' WHERE idDocumento='$idAnteriorControlCambios' ");
    }else{
        if($extrarConsultaExistenciaComentario['idDocumento'] != NULL){
            $mysqli->query("UPDATE controlCambiosFlujo SET informacion='$informacion', fecha='$fecha' WHERE idDocumento='$idAnteriorControlCambios' ");
        }else{
            $mysqli->query("INSERT INTO controlCambiosFlujo (idDocumento,informacion,fecha)VALUES('$idAnteriorControlCambios','$informacion','$fecha')");
        }
    }
    //// end
    
    
   
        
        $elaboraA = $datosDoc1['elaboraActualizar'];
        $revisaA = $datosDoc1['revisaActualizar'];
        $apruebaA = $datosDoc1['apruebaActualizar'];
        
     //// vamos actualizar el nombre del proceso cada vez que se cambie
     $mysqli->query("UPDATE documento SET  nombreProceso='$nomProceso' WHERE id = '$idDocumento' ");
    /// end    
        
        if($extraerValidamosTP['tipoSolicitud'] == '1'){
         
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
                        elabora = '$elabora',
                        revisa = '$revisa',
                        aprueba = '$aprueba',
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
                        estado = '$estado',
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
                        elabora = '$elabora',
                        revisa = '$revisa',
                        aprueba = '$aprueba',
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
                        estado = '$estado',
                        vigente = '$vigente',
                        asumeFlujo = NULL
                        WHERE id = '$idDocumento'
     
                        ")or die(mysqli_error($mysqli));
                }
                
                 
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
                        elabora = '$elabora',
                        revisa = '$revisa',
                        aprueba = '$aprueba',
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
                        estado = '$estado',
                        vigente = '$vigente',
                        asumeFlujo = NULL
                        WHERE id = '$idDocumento'
     
                        ")or die(mysqli_error($mysqli));
                
                 
            }
            
        }elseif($extraerValidamosTP['tipoSolicitud'] == '2'){
            
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
            
        }elseif($extraerValidamosTP['tipoSolicitud'] == '3'){
            //echo '<script>alert("entra a la 3");</script>';
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
            
            /*
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
                        elaboraElimanar = '$elabora',
                        revisaElimanar = '$revisa',
                        apruebaElimanar = '$aprueba',
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
                        estadoElimina = '$estado',
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
                        elaboraElimanar = '$elabora',
                        revisaElimanar = '$revisa',
                        apruebaElimanar = '$aprueba',
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
                        estadoElimina = '$estado',
                        vigente = '$vigente',
                        asumeFlujo = NULL
                        WHERE id = '$idDocumento'
     
                        ")or die(mysqli_error($mysqli));
                }
                
                 
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
                        elaboraElimanar = '$elabora',
                        revisaElimanar = '$revisa',
                        apruebaElimanar = '$aprueba',
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
                        estadoElimina = '$estado',
                        vigente = '$vigente',
                        asumeFlujo = NULL
                        WHERE id = '$idDocumento'
     
                        ")or die(mysqli_error($mysqli));
                
                 
            } 
            */
        }
        
        
        

      
   
        if($estado == 'Pendiente'){ 

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
                <input type="hidden" name="validacionAgregar" value="1">
            </form> 
        <?php
        }
    
        if($estado == 'Rechazado'){ 
            if($extraerValidamosTP['tipoSolicitud'] == '3'){
             $mysqli->query("UPDATE documento SET asumeFlujo = NULL, estadoElimina = NULL, elaboraElimanar = NULL, revisaElimanar= NULL, apruebaElimanar=NULL, vigente='1' WHERE id='$idDocumento'")or die(mysqli_error($mysqli));  
            }
            ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../creacionDocumental" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionCerrado" value="1">
            </form> 
            <?php
        }
    
    
}

if(isset($_POST['cerrarDocumento'])){
    $fecha = date("Y:m:j");
    $idUsuario=$_POST['idUsuario'];
    $idSolicitud=$_POST['idSolicitud'];
    $idDoc=$_POST['idDoc'];
    $comentarios=$_POST['comentarios'];
     require '../usuarios/libreria/PHPMailerAutoload.php';
     
                    $envioCorreoEncargado=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE id='$idSolicitud' ");
                    $extraerEnvioCorreoEncargado=$envioCorreoEncargado->fetch_array(MYSQLI_ASSOC);
                    'Quien aprueba: '.$notificarEncargadoQuienS=$extraerEnvioCorreoEncargado['quienSolicita'];
                    'Quien aprueba: '.$tipoSolicitud=$extraerEnvioCorreoEncargado['tipoSolicitud'];
                    
                    //$nombreDocumento2=utf8_encode($extraerEnvioCorreoEncargado['nombreDocumento2']);
    
                    $idSolicitudNombre=utf8_encode($extraerEnvioCorreoEncargado['id']);
                    
                    $conformandoNOmbre=$mysqli->query("SELECt * FROm documento WHERE id_solicitud='$idSolicitudNombre' ");
                    $extraerNombreNuevo=$conformandoNOmbre->fetch_array(MYSQLI_ASSOC);
                    $nombreDocumento2=utf8_encode($extraerNombreNuevo['nombres']);
                    
                       //// este espacio se crea para el control de cambios el procedimiento del flujo de aprobación del documento
                        
                        $idAnteriorControlCambios=$extraerNombreNuevo['id'];
                        $consultamosExistenciaComentario=$mysqli->query("SELECT * FROM controlCambiosFlujo WHERE idDocumento='$idAnteriorControlCambios' ");
                        $extrarConsultaExistenciaComentario=$consultamosExistenciaComentario->fetch_array(MYSQLI_ASSOC);
                        $mysqli->query("UPDATE controlCambiosFlujo SET informacion='".$extrarConsultaExistenciaComentario['comentarioAnterior']."' WHERE idDocumento='$idAnteriorControlCambios' ");
                        //// end
    
                    
                    
                    
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
                                        $mail->Subject = utf8_decode('Solicitud de documento rechazado');
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
                                        <p><b>La solicitud de documento '.$nombreDocumento2.' fue rechazada.</b></p>
                                        
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
            
    
    
    
    
    
    
    if($tipoSolicitud == '1'){
        $mysqli->query("UPDATE solicitudDocumentos SET regresa = NULL WHERE id='$idSolicitud' ");
        $mysqli->query("UPDATE documento SET estado = NULL WHERE id='$idDoc' ");
        
        $consultaNombreUsuario=$mysqli->query("SELECT * FROM usuario WHERE cedula='$idUsuario' ");
        $extraerConsultaNombreUsuario=$consultaNombreUsuario->fetch_array(MYSQLI_ASSOC);
        'Nombre enviar: '.$nombreUsuario=$extraerConsultaNombreUsuario['nombres'].' '.$extraerConsultaNombreUsuario['apellidos'];
                    
        $mysqli->query("INSERT INTO controlCambios (idDocumento,comentario,idUsuario,fecha,rol,nombre)VALUES('$idSolicitud','$comentarios','$idUsuario','$fecha','Encargado(a) solicitud','$nombreUsuario')");
    
    }elseif($tipoSolicitud == '2'){
        $mysqli->query("UPDATE solicitudDocumentos SET regresa = NULL WHERE id='$idSolicitud' "); //, estado='Rechazado'
        //$mysqli->query("UPDATE documento SET estadoActualiza = NULL WHERE id='$idDoc' ");
        $mysqli->query("DELETE FROM documento WHERE id='$idDoc' ");
        
    }elseif($tipoSolicitud == '3'){
        $mysqli->query("UPDATE solicitudDocumentos SET regresa = NULL WHERE id='$idSolicitud' ");
        $mysqli->query("UPDATE documento SET estadoElimina = NULL WHERE id='$idDoc' ");
                        // almacenamos el nombre del usuario
        $consultaNombreUsuario=$mysqli->query("SELECT * FROM usuario WHERE cedula='$idUsuario' ");
        $extraerConsultaNombreUsuario=$consultaNombreUsuario->fetch_array(MYSQLI_ASSOC);
        'Nombre enviar: '.$nombreUsuario=$extraerConsultaNombreUsuario['nombres'].' '.$extraerConsultaNombreUsuario['apellidos'];
                    
        $mysqli->query("INSERT INTO controlCambios (idDocumento,comentario,idUsuario,fecha,rol,nombre)VALUES('$idSolicitud','$comentarios','$idUsuario','$fecha','Encargado(a) solicitud','$nombreUsuario')");
    
    
    
    }
    
    //$mysqli->query("DELETE FROM documento WHERE id='$idDoc' ");
     ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../creacionDocumental" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionCerrado" value="1">
            </form> 
        <?php
    
}

//if(isset($_POST['rad_flujo'])){
//    echo 'END';
//}