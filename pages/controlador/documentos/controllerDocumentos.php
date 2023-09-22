<?php
error_reporting(E_ERROR);
date_default_timezone_set("America/Bogota");
require_once '../../conexion/bd.php';
session_start();
error_reporting(E_ERROR);
$idUser = $_SESSION["session_username"];

if(isset($_POST['agregarDoc'])){
    
    /* 
    
    ESTE CONTROLLER ES EL QUE NOS CREA EL DOCUMENTO 
    
    Asi se codifica y decodifica cadenas de html 
        
    $a = htmlentities($orig);
    $b = html_entity_decode($a);
    
    */
    
     
    
    $idSolicitud = $_POST['idSolicitud'];
    $nombreDoc = utf8_decode($_POST['nombreDocumento']);
    $nombreDocEnviar = utf8_encode($nombreDoc); /// enviar al correo
    $norma = unserialize($_POST['norma']);
    $norma = json_encode($norma);
    $proceso = $_POST['proceso'];
    $metodo = $_POST['rad_metodo'];
    $tipoDoc = $_POST['tipoDoc'];
    $ubicacion = utf8_decode($_POST['ubicacion']);
    $elabora = unserialize($_POST['select_encargadoE']);
    $elaboraN = unserialize($_POST['select_encargadoE']); // para la notificación creación
    $radElabora = $_POST['radiobtnE'];
    array_unshift($elabora,$radElabora);
    $elabora = json_encode($elabora);
    $revisa = unserialize($_POST['select_encargadoR']);
    $revisaN = unserialize($_POST['select_encargadoR']); // para la notificación revisión
    $radRevisa = $_POST['radiobtnR'];
    array_unshift($revisa,$radRevisa);
    $revisa = json_encode($revisa);
    $aprueba = unserialize($_POST['select_encargadoA']);
    $apruebaA = unserialize($_POST['select_encargadoA']); // para la notificación aprobar
    $radAprueba = $_POST['radiobtnA'];
    array_unshift($aprueba,$radAprueba);
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
     '1: '.$nombrePDF = utf8_decode($_POST['nombrePDF']); 
     '<br>2: '.$nombreOtro = utf8_decode($_POST['nombreOtro']);
    
    
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
    
    
    ///// vaciamos  la tabla temporal de los archivos
     $idSolicitud;
     $mysqli->query("DELETE FROM documentoArchivoTemporal WHERE solicitud='$idSolicitud' ")or die(mysqli_error($mysqli));
     $mysqli->query("DELETE FROM documentoDatosTemporales WHERE solicitud='$idSolicitud' ")or die(mysqli_error($mysqli));
    //// END
    
    
    
    /*FLUJO DE APROBACION*/
    $estado = "Pendiente";
    require '../usuarios/libreria/PHPMailerAutoload.php';
     
     
    if($radioAprobado == 'rechazado' && $flujoAprovacion == 'cierra'){
        $estado = "Rechazado";
        
                    $envioCorreoEncargado=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE id='$idSolicitud' ");
                    $extraerEnvioCorreoEncargado=$envioCorreoEncargado->fetch_array(MYSQLI_ASSOC);
                    'Quien aprueba: '.$notificarEncargadoQuienS=$extraerEnvioCorreoEncargado['quienSolicita'];
                    $nombreDocumento2=utf8_encode($extraerEnvioCorreoEncargado['nombreDocumento2']);
                    $idSolicitudNombre=utf8_encode($extraerEnvioCorreoEncargado['id']);
                     'Tipo soli Arriba <br>'.$tipoSolicitud=$extraerEnvioCorreoEncargado['tipoSolicitud'];
                    
                    $conformandoNOmbre=$mysqli->query("SELECt * FROm documento WHERE id_solicitud='$idSolicitudNombre' ");
                    $extraerNombreNuevo=$conformandoNOmbre->fetch_array(MYSQLI_ASSOC);
                    //$nombreDocumento2=utf8_encode($extraerNombreNuevo['nombres']);
                   
        
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
                                        $mail->Subject = utf8_decode('Solicitud de documento rechazado - solicitante');
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
                                        <p><b>La solicitud de documento '.$nombreDocumento2.' fue rechazado.</b></p>
                                        
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
    
    
    
    
    
    /*FLUJO DE APROBACION*/
    
    //PROCESO  
    $queryDocumentos = $mysqli->query("SELECT nombre, prefijo from tipoDocumento WHERE id = '".$tipoDoc."' ");
    $datosDocumento = $queryDocumentos->fetch_array(MYSQLI_ASSOC);
    $tipoDocumento = $datosDocumento['nombre'];
    $prefijoTipo = $datosDocumento['prefijo']; 
                    
    //TIPO DE DOCUMENTO             
    $roles=$row['cargo'];
    $queryProcesos = $mysqli->query("SELECT nombre,prefijo from procesos WHERE id = '".$proceso."' ");
    $datosProceso = $queryProcesos->fetch_array(MYSQLI_ASSOC);
    $nomProceso = $datosProceso['nombre'];
    $prefijoProceso = $datosProceso['prefijo']; 
                        
                        
    //VERSION Y CONSECUTIVO                    
    //Consecutivo y version cuando son definidos por el cliente
    $queryVersiones = $mysqli->query("SELECT * FROM versionamiento WHERE idProceso = '$proceso' AND idTipoDocumento = '$tipoDoc'");
    $datosVersiones = $queryVersiones->fetch_assoc();
    
    $versionInicial = $datosVersiones['versionInicial'];
    $consecutivoIncial = $datosVersiones['consecutivoInicial'];
    
    $rol = $_POST['rol'];
    
    //$radCodificacion = 'manual';
    
    if($radCodificacion == 'automatico'){
        
         "<br>AUTOMATICO<br>";
         '<br>'.$tipoDoc;
         '<br>'.$proceso;
        //$queryDoc = $mysqli->query("SELECT MAX(consecutivo) AS consecutivo, version FROM documento WHERE tipo_documento = $tipoDoc AND proceso = '$proceso' AND aprobado_aprueba = 1 AND tipoCodificacion = 'automatico'")or die(mysqli_error($mysqli));
        //SELECT * FROM documento WHERE consecutivo = '$consecutivo' AND proceso = '$proceso' AND tipo_documento = '$tipoDocumento' AND vigente = '1'
       
       /*
        $queryDoc = $mysqli->query("SELECT * FROM documento WHERE tipo_documento = '$tipoDoc' AND proceso = '$proceso' AND vigente='1' ORDER BY consecutivo DESC")or die(mysqli_error($mysqli));
        $datosDoc = $queryDoc->fetch_assoc();
         '<br>Consecutivo: '.$consecutivo = $datosDoc['consecutivo'];
         '<br>Version: '.$version = $datosDoc['version'];
         '<br>Consecutivo siguiente: <br>';
         '<br>Consecutivo: '.$consecutivo = $datosDoc['consecutivo']+1;
         '<br>Version: '.$version = $datosDoc['version'];
        
        
        // validamos existencia
        
        $existenciaConsecutivo=$mysqli->query("SELECT * FROM documento WHERE tipo_documento='$tipoDoc' AND proceso='$proceso' AND vigente='1'  "); //AND consecutivo='$consecutivo'
        $extraerExistenciaConsecutivo=$existenciaConsecutivo->fetch_array(MYSQLI_ASSOC);
        $validnadoConsecutivoExistente=$extraerExistenciaConsecutivo['consecutivo'];
        
        if($consecutivo > $validnadoConsecutivoExistente){
            $version = 1;
        }else{
            $version =$version;
        }
      
      */
      
      
      /*
        // validamos la existencia de este proceso
        $consultamosExistenciaDocumento=$mysqli->query("SELECT * FROM documento WHERE tipo_documento = '$tipoDoc' AND proceso = '$proceso'  ORDER BY consecutivo DESC "); //AND  vigente='1' id='$idDocumento'
        $extraemosExistenciaDocumento=$consultamosExistenciaDocumento->fetch_array(MYSQLI_ASSOC);
        $almacenarVariableAprobado=$extraemosExistenciaDocumento['aprobado_aprueba'];
       
        /// buscamos existencia por tipo de documento, proceso y vigente
        if($almacenarVariableAprobado == '1' && $extraemosExistenciaDocumento['vigente'] == '1' ){
          'Debe consultar VIGENTE';
         '<br>'.$tipoDoc;
         '<br>'.$proceso;
        $queryDoc = $mysqli->query("SELECT * FROM documento WHERE tipo_documento = '$tipoDoc' AND proceso = '$proceso' AND aprobado_aprueba = '1'  ORDER BY consecutivo DESC")or die(mysqli_error($mysqli));
        $datosDoc = $queryDoc->fetch_assoc();
         '<br>Consecutivo: '.$consecutivo = $datosDoc['consecutivo']+1;
         '<br>Version: '.$version = $datosDoc['version'];
        
        
        $existenciaConsecutivo=$mysqli->query("SELECT * FROM documento WHERE tipo_documento='$tipoDoc' AND proceso='$proceso' AND aprobado_aprueba='1'   "); //AND consecutivo='$consecutivo'
        $extraerExistenciaConsecutivo=$existenciaConsecutivo->fetch_array(MYSQLI_ASSOC);
        $validnadoConsecutivoExistente=$extraerExistenciaConsecutivo['consecutivo'];
        
            if($consecutivo > $validnadoConsecutivoExistente){
                $version = 1;
            }else{
                $version =$version;
            }
        }elseif($almacenarVariableAprobado == '1' && $extraemosExistenciaDocumento['obsoleto'] == '1'){
               
                 'Debe consultar OBSOLETO';
                 '<br>'.$tipoDoc;
                 '<br>'.$proceso;
                /// traemos el ultim digito mayor
                $queryDocNumeroMayor = $mysqli->query("SELECT max(consecutivo) AS ultimoNnumero FROM documento WHERE tipo_documento = '$tipoDoc' AND proceso = '$proceso' AND aprobado_aprueba = '1' ORDER BY consecutivo DESC")or die(mysqli_error($mysqli));
                $datosDocNumeroMayor = $queryDocNumeroMayor->fetch_assoc();
                $ultimoNumeroConsecutivo=$datosDocNumeroMayor['ultimoNnumero'];
                
                $queryDoc = $mysqli->query("SELECT * FROM documento WHERE tipo_documento = '$tipoDoc' AND proceso = '$proceso' AND aprobado_aprueba = '1' AND obsoleto='1' ORDER BY consecutivo DESC")or die(mysqli_error($mysqli));
                $datosDoc = $queryDoc->fetch_assoc();
                 '<br>Consecutivo: '.$consecutivo = $ultimoNumeroConsecutivo+1;
                 '<br>Version: '.$version = '1';//$datosDoc['version'];
                
                
                
        }elseif($almacenarVariableAprobado == '0' && $extraemosExistenciaDocumento['vigente'] == '0' && $extraemosExistenciaDocumento['obsoleto'] == '0'){
             '<br>Por si acaso está es la solución: ';
            /// traemos el ultim digito mayor
                $queryDocNumeroMayor = $mysqli->query("SELECT max(consecutivo) AS ultimoNnumero FROM documento WHERE tipo_documento = '$tipoDoc' AND proceso = '$proceso' AND aprobado_aprueba = '0' ORDER BY consecutivo DESC")or die(mysqli_error($mysqli));
                $datosDocNumeroMayor = $queryDocNumeroMayor->fetch_assoc();
                $ultimoNumeroConsecutivo=$datosDocNumeroMayor['ultimoNnumero'];
                
                $queryDoc = $mysqli->query("SELECT * FROM documento WHERE tipo_documento = '$tipoDoc' AND proceso = '$proceso' AND aprobado_aprueba = '0' AND obsoleto='0' AND vigente='0' ORDER BY consecutivo DESC")or die(mysqli_error($mysqli));
                $datosDoc = $queryDoc->fetch_assoc();
                 '<br>Consecutivo: '.$consecutivo = $ultimoNumeroConsecutivo+1;
                 '<br>Version: '.$version = '1';//$datosDoc['version'];
        }else{
             '<br>Consecutivo: '.$consecutivo = '1';
             '<br>Version: '.$version = '1';
        }
      
      
      
        '-'.$version;
        */
       
        
       
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
        
        
        if($contadorVigente >= '1' ){
            /// buscamos existencia por tipo de documento, proceso y vigente
            //if($almacenarVariableAprobado == '1' && $extraemosExistenciaDocumento['vigente'] == '1' ){
            echo '<br><br>';
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
        }
        
         '<br>';
         'consecutivo saliente: '.$consecutivo;
         'versión saliente: '.$version;
         '<br>';
        
        
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
                 '<br>Version que sale: '.$version;    
                    
            //}
        }
        
        if($contadorVigente == 0 && $contadorObsoleto == 0){ echo '<br>';
             '<br>Consecutigo: '.$consecutivo =1;
             '<br>Versión: '.$version =1;
        }
    
    
    
    
        
        
        
    }
    
    if($radCodificacion == 'manual'){
        //echo "<br>MANUAL<br>";
        $version = $versionDeclarada;
        $consecutivo = $consecutivoDeclarada;
    }
    

    $vigente = 0; //El documento se crea mas no se aprueba por eso 0 de que no es vigente hasta ahora. 
   
                        
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

     "<br>Codificacion: ".$codificacion;

    $fecha = date("Y/m/j h:i:s");

        
    $queryDocVal = $mysqli->query("SELECT * FROM documento WHERE codificacion ='$codificacion' AND nombres ='$nombreDoc' AND id_solicitud = $idSolicitud")or die(mysqli_error($mysqli));
    
    
    if(mysqli_num_rows($queryDocVal) > 0){//se velida si ya esta es codificacion, en dado caso no deja pasar 
        
        //echo '<script language="javascript">alert("Documento listo para elaboracion.");
        //    window.location.href="../../creacionDocumental.php"</script>';
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
        
    }else{
        
        if($estado == "Rechazado"){
            $fechaCierre =  date("Y/m/j");
            $mysqli->query("UPDATE solicitudDocumentos SET estado = '$estado', fechaCierre = '$fechaCierre' WHERE id = $idSolicitud ")or die(mysqli_error($mysqli));
          
            //echo '<script language="javascript">alert("Documento rechazado.");
            //window.location.href="../../creacionDocumental.php"</script>';
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
        
        }else{
    
      
            
            
            
           
            if($estado == 'Pendiente'){
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
               
                   
                
                

            }

            $mysqli->query("INSERT INTO documento(
                                        `codificacion`,
                                        `tipoCodificacion`,
                                        `consecutivo`,
                                        `version`,
                                        `nombres`,
                                        `proceso`,
                                        `nombreProceso`,
                                        `norma`,
                                        `metodo`,
                                        `tipo_documento`,
                                        `ubicacion`,
                                        `elabora`,
                                        `revisa`,
                                        `aprueba`,
                                        `documento_externo`,
                                        `definiciones`,
                                        `archivo_gestion`,
                                        `archivo_central`,
                                        `archivo_historico`,
                                        `disposicion_documental`,
                                        `responsable_disposicion`,
                                        `usuario_aprovacion_reg`,
                                        `flujo`,
                                        `mesesRevision`,
                                        `id_solicitud`,
                                        estadoCreado,
                                        nombrePDF,
                                        nombreOtro,
                                        htmlDoc,
                                        estado,
                                        usuarioElabora,
                                        plataformaH,
                                        plataformaHRevisa,
                                        plataformaHAprueba,
                                        vigente
                                    )
                                    VALUES(
                                        '$codificacion',
                                        '$radCodificacion',
                                        '$consecutivo',
                                        '$version',
                                        '$nombreDoc',
                                        '$proceso',
                                        '$nomProceso',
                                        '$norma',
                                        '$metodo',
                                        '$tipoDoc',
                                        '$ubicacion',
                                        '$elabora',
                                        '$revisa',
                                        '$aprueba',
                                        '$documentosExternos',
                                        '$definiciones',
                                        '$archivoGestion',
                                        '$archivoCentral',
                                        '$archivoHistorico',
                                        '$dispoDocumental',
                                        '$escargadoDispo',
                                        '$select_encargadoAR',
                                        '$flujoAprovacion',
                                        '$mesesRevision',
                                        '$idSolicitud',
                                        TRUE,
                                        '$nombrePDF',
                                        '$nombreOtro',
                                        '$editorHtml',
                                        '$estado',
                                        '$idUser',
                                        '1',
                                        '1',
                                        '1',
                                        '$vigente'
                                    
                                        )")or die(mysqli_error($mysqli));
                                        //"Ocurrrio un error, comuniquese con el administrador del sistema."
                                        
         
        $queryDocRegistro = $mysqli->query("SELECT MAX(id) AS registro FROM documento WHERE usuarioElabora='$idUser' ORDER BY id DESC")or die(mysqli_error($mysqli));
        $extraerRegistro=$queryDocRegistro->fetch_array(MYSQLI_ASSOC);
        $idDocumento=$extraerRegistro['registro'];
        
                    $envioEncargado=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE id='$idSolicitud' ");
                    $extraerEncargado=$envioEncargado->fetch_array(MYSQLI_ASSOC);
                    $tipoSolicitud=$extraerEncargado['tipoSolicitud'];
                    
                     // almacenamos el nombre del usuario
                    $consultaNombreUsuario=$mysqli->query("SELECT * FROM usuario WHERe cedula='$idUser' ");
                    $extraerConsultaNombreUsuario=$consultaNombreUsuario->fetch_array(MYSQLI_ASSOC);
                    $nombreUsuario=$extraerConsultaNombreUsuario['nombres'].' '.$extraerConsultaNombreUsuario['apellidos'];
      
                                if($controlCambios != NULL){ 
                                    $mysqli->query("INSERT INTO controlCambios (idDocumento, idRespaldo, comentario, idUsuario, fecha, rol, tipoSolicitud,nombre) VALUES('$idSolicitud','$idDocumento','$controlCambios','$idUser','$fecha','$rol','$tipoSolicitud','$nombreUsuario')")or die(mysqli_error($mysqli));  
                                }else{ 
                                    $mysqli->query("INSERT INTO controlCambios (idDocumento, idRespaldo, comentario, idUsuario, fecha, rol, tipoSolicitud,nombre) VALUES('$idSolicitud','$idDocumento','N/A','$idUser','$fecha','$rol','$tipoSolicitud','$nombreUsuario')")or die(mysqli_error($mysqli));
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
                                      
                                      
            
            
            
            
        }// end else
        
    }//end else otro
    
}


///// para reaglizar el registro de los documentos que ya existen en el sistema



if(isset($_POST['agregarDocB'])){
    
    /* 
    
    ESTE CONTROLLER ES EL QUE NOS CREA EL DOCUMENTO 
    
    Asi se codifica y decodifica cadenas de html 
        
    $a = htmlentities($orig);
    $b = html_entity_decode($a);
    
    */
    
     
    
    $idSolicitud = $_POST['idSolicitud'];
    $nombreDoc = utf8_decode($_POST['nombreDocumento']);
    $nombreDocEnviar = utf8_encode($nombreDoc); /// enviar al correo
    $norma = unserialize($_POST['norma']);
    $norma = json_encode($norma);
    $proceso = $_POST['proceso'];
    $metodo = $_POST['rad_metodo'];
    $tipoDoc = $_POST['tipoDoc'];
    $ubicacion = utf8_decode($_POST['ubicacion']);
    $elabora = utf8_decode($_POST['select_encargadoE']);//unserialize($_POST['select_encargadoE']);
    $elaboraN = unserialize($_POST['select_encargadoE']); // para la notificación creación
    $radElabora = $_POST['radiobtnE'];
    //array_unshift($elabora,$radElabora);
    //$elabora = json_encode($elabora);
    $revisa = utf8_decode($_POST['select_encargadoR']); //unserialize($_POST['select_encargadoR']);
    $revisaN = unserialize($_POST['select_encargadoR']); // para la notificación revisión
    $radRevisa = $_POST['radiobtnR'];
    //array_unshift($revisa,$radRevisa);
    //$revisa = json_encode($revisa);
    $aprueba = utf8_decode($_POST['select_encargadoA']);//unserialize($_POST['select_encargadoA']);
    $apruebaA = unserialize($_POST['select_encargadoA']); // para la notificación aprobar
    $radAprueba = $_POST['radiobtnA'];
    //array_unshift($aprueba,$radAprueba);
    //$aprueba = json_encode($aprueba);
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
    //$escargadoDispo = unserialize($_POST['select_encargadoD']);
    $escargadoDispo = utf8_decode($_POST['select_encargadoD']);
    $radDispoDoc = $_POST['radiobtnD'];
    //array_unshift($escargadoDispo,$radDispoDoc); 
    //$escargadoDispo = json_encode($escargadoDispo);
    
    $editorHtml = utf8_decode($_POST['editorHtml']);
     '1: '.$nombrePDF = utf8_decode($_POST['nombrePDF']); 
     '<br>2: '.$nombreOtro = utf8_decode($_POST['nombreOtro']);
    
    
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
    
    /*FLUJO DE APROBACION*/
    $estado = "Pendiente";
    
    if($radioAprobado == 'rechazado' && $flujoAprovacion == 'cierra'){
        $estado = "Rechazado";
    }
    
    
    
    
    
    /*FLUJO DE APROBACION*/
    
    //PROCESO  
    $queryDocumentos = $mysqli->query("SELECT nombre, prefijo from tipoDocumento WHERE id = '".$tipoDoc."' ");
    $datosDocumento = $queryDocumentos->fetch_array(MYSQLI_ASSOC);
    $tipoDocumento = $datosDocumento['nombre'];
    $prefijoTipo = $datosDocumento['prefijo']; 
                    
    //TIPO DE DOCUMENTO             
    $roles=$row['cargo'];
    $queryProcesos = $mysqli->query("SELECT nombre,prefijo from procesos WHERE id = '".$proceso."' ");
    $datosProceso = $queryProcesos->fetch_array(MYSQLI_ASSOC);
    $nomProceso = $datosProceso['nombre'];
    $prefijoProceso = $datosProceso['prefijo']; 
                        
                        
    //VERSION Y CONSECUTIVO                    
    //Consecutivo y version cuando son definidos por el cliente
    $queryVersiones = $mysqli->query("SELECT * FROM versionamiento WHERE idProceso = '$proceso' AND idTipoDocumento = '$tipoDoc'");
    $datosVersiones = $queryVersiones->fetch_assoc();
    
    $versionInicial = $datosVersiones['versionInicial'];
    $consecutivoIncial = $datosVersiones['consecutivoInicial'];
    
    $rol = $_POST['rol'];
    
    //$radCodificacion = 'manual';
    
    if($radCodificacion == 'automatico'){
        
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
        
        
        
    }
    
    if($radCodificacion == 'manual'){
        //echo "<br>MANUAL<br>";
        $version = $versionDeclarada;
        $consecutivo = $consecutivoDeclarada;
    }
    

    $vigente = 0; //El documento se crea mas no se aprueba por eso 0 de que no es vigente hasta ahora. 
   
                        
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

    //echo "<br>Codificacion: ".$codificacion;

    $fecha = date("Y/m/j h:i:s");

        
    $queryDocVal = $mysqli->query("SELECT * FROM documento WHERE codificacion ='$codificacion' AND nombres ='$nombreDoc' AND id_solicitud = $idSolicitud")or die(mysqli_error($mysqli));
    
    
    if(mysqli_num_rows($queryDocVal) > 0){//se velida si ya esta es codificacion, en dado caso no deja pasar 
        
        //echo '<script language="javascript">alert("Documento listo para elaboracion.");
        //    window.location.href="../../creacionDocumental.php"</script>';
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
        
    }else{
        
        if($estado == "Rechazado"){
            $fechaCierre =  date("Y/m/j");
            $mysqli->query("UPDATE solicitudDocumentos SET estado = '$estado', fechaCierre = '$fechaCierre' WHERE id = $idSolicitud ")or die(mysqli_error($mysqli));
          
            //echo '<script language="javascript">alert("Documento rechazado.");
            //window.location.href="../../creacionDocumental.php"</script>';
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
        
        }else{
    
        
        /////// codificación para notificación plataforma
           // require_once'enviosPlataforma.php';
         /// END
            
            /////// datos para el que elaboro
             'Siemre segunda ---- primera validación';
             '<br>';
             $fechaElaboracion=$_POST['fechaElaboracion'];
             '<br>';
             $controlCambios;
            //// end
            
            /////// datos para el que elaboro
             'segunda validación';
             '<br>';
             $fechaRevision=$_POST['fechaRevision'];
             '<br>';
             $comentarioRevision=utf8_decode($_POST['comentarioRevision']);
            //// end
            
            /////// datos para el que elaboro
             'tercera validación';
             '<br>';
             $fechaAprobacion=$_POST['fechaAprobacion'];
             '<br>';
             $comentarioAprobo=utf8_decode($_POST['comentarioAprobo']);
            //// end
            
            $validandoAlmacenamientoArrya=$_POST['almacenamientoArray'];
            /*
            if($validandoAlmacenamientoArrya == 'retiradosUsuarios'){
                $nombreElaboro=utf8_decode($_POST['nombreElaboro']);
                $nombreReviso=utf8_decode($_POST['nombreReviso']);
                $nombreAprobo=utf8_decode($_POST['nombreAprobo']);
               //echo '<br>Almacena en el idUsuarioB';
               if($controlCambios != NULL){
               $mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuarioB, fecha, rol) VALUES('$idSolicitud','$controlCambios','$nombreElaboro','$fechaElaboracion','Elaborador(a)')")or die(mysqli_error($mysqli));  
                }
                 if($comentarioRevision != NULL){
                   $mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuarioB, fecha, rol) VALUES('$idSolicitud','$comentarioRevision','$nombreReviso','$fechaRevision','Revisor(a)')")or die(mysqli_error($mysqli));  
                }
                 if($comentarioAprobo != NULL){
                   $mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuarioB, fecha, rol) VALUES('$idSolicitud','$comentarioAprobo','$nombreAprobo','$fechaAprobacion','Elaborador(a)')")or die(mysqli_error($mysqli));  
                }
            }
            */
            if($validandoAlmacenamientoArrya == 'activosUsuarios'){
                $nombreElaboro=$_POST['nombreElaboro'];
                $nombreReviso=$_POST['nombreReviso'];
                $nombreAprobo=$_POST['nombreAprobo'];
            }
            if($validandoAlmacenamientoArrya == 'retiradosUsuarios'){
                $nombreElaboro=utf8_decode($_POST['nombreElaboro']);
                $nombreReviso=utf8_decode($_POST['nombreReviso']);
                $nombreAprobo=utf8_decode($_POST['nombreAprobo']);
            }
            
                if($controlCambios != NULL){
                    $mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuarioB, fecha, rol) VALUES('$idSolicitud','$controlCambios','$nombreElaboro','$fechaElaboracion','Elaborador(a)')")or die(mysqli_error($mysqli));  
                }else{
                    $mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuarioB, fecha, rol) VALUES('$idSolicitud','N/A','$nombreElaboro','$fechaElaboracion','Elaborador(a)')")or die(mysqli_error($mysqli));  
                }
                if($comentarioRevision != NULL){
                   $mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuarioB, fecha, rol) VALUES('$idSolicitud','$comentarioRevision','$nombreReviso','$fechaRevision','Revisor(a)')")or die(mysqli_error($mysqli));  
                }else{
                    $mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuarioB, fecha, rol) VALUES('$idSolicitud','N/A','$nombreReviso','$fechaRevision','Revisor(a)')")or die(mysqli_error($mysqli));  
                }
                if($comentarioAprobo != NULL){
                   $mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuarioB, fecha, rol) VALUES('$idSolicitud','$comentarioAprobo','$nombreAprobo','$fechaAprobacion','Aprobador(a)')")or die(mysqli_error($mysqli));  
                }else{
                   $mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuarioB, fecha, rol) VALUES('$idSolicitud','N/A','$nombreAprobo','$fechaAprobacion','Aprobador(a)')")or die(mysqli_error($mysqli));   
                }
            
            $mysqli->query("UPDATE solicitudDocumentos SET fechaCierre = '$fechaAprobacion',estado='Ejecutado' WHERE id = $idSolicitud ")or die(mysqli_error($mysqli));
            $mysqli->query("INSERT INTO documento(
                                        `codificacion`,
                                        `tipoCodificacion`,
                                        `consecutivo`,
                                        `version`,
                                        `nombres`,
                                        `proceso`,
                                        `nombreProceso`,
                                        `norma`,
                                        `metodo`,
                                        `tipo_documento`,
                                        `ubicacion`,
                                        `elabora`,
                                        `revisa`,
                                        `aprueba`,
                                        `documento_externo`,
                                        `definiciones`,
                                        `archivo_gestion`,
                                        `archivo_central`,
                                        `archivo_historico`,
                                        `disposicion_documental`,
                                        `responsable_disposicion`,
                                        `usuario_aprovacion_reg`,
                                        `flujo`,
                                        `mesesRevision`,
                                        `id_solicitud`,
                                        estadoCreado,
                                        nombrePDF,
                                        nombreOtro,
                                        htmlDoc,
                                        estado,
                                        usuarioElabora,
                                        plataformaH,
                                        plataformaHRevisa,
                                        plataformaHAprueba,
                                        vigente,
                                        fechaAprobado
                                    )
                                    VALUES(
                                        '$codificacion',
                                        '$radCodificacion',
                                        '$consecutivo',
                                        '$version',
                                        '$nombreDoc',
                                        '$proceso',
                                        '$nomProceso',
                                        '$norma',
                                        '$metodo',
                                        '$tipoDoc',
                                        '$ubicacion',
                                        '$elabora',
                                        '$revisa',
                                        '$aprueba',
                                        '$documentosExternos',
                                        '$definiciones',
                                        '$archivoGestion',
                                        '$archivoCentral',
                                        '$archivoHistorico',
                                        '$dispoDocumental',
                                        '$escargadoDispo',
                                        '$select_encargadoAR',
                                        '$flujoAprovacion',
                                        '$mesesRevision',
                                        '$idSolicitud',
                                        TRUE,
                                        '$nombrePDF',
                                        '$nombreOtro',
                                        '$editorHtml',
                                        'Aprobado',
                                        '$idUser',
                                        '1',
                                        '1',
                                        '1',
                                        '1',
                                        '$fechaAprobacion'
                                    
                                        )")or die(mysqli_error($mysqli));
                                       
                                        //"Ocurrrio un error, comuniquese con el administrador del sistema."
                                        
                                        // /$vigente $estado
                               
                                
                                ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformulario"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformulario" action="../../creacionDocumental" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionAgregarCargado" value="1">
                                    </form> 
                                <?php 
                                    
                                        
            
            
            
            
        }// end else
        
    }//end else otro
    
}


?>