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
    
    $fechaAprobado =  date("Y/m/j h:i:s");
    
    $estadoActual = $datosDoc1['estado'];
    
    $aprobado_elabora = 0;
    $aprobado_revisa = 0;
    $aprobado_aprueba = 0;
    
    $vigente = 0;
    
    if($estadoActual == "Pendiente"){
        
        if($radioAprobado == 'aprobado' && $flujoAprovacion == 'reinicia'){
            $estado = "Elaborado";
            $aprobado_elabora = 1;
        }
        
        if($radioAprobado == 'aprobado' && $flujoAprovacion == 'ajusta'){
            $estado = "Elaborado";
            $aprobado_elabora = 1;
        }
        
        if($radioAprobado == 'aprobado' && $flujoAprovacion == 'cierra'){
            $estado = "Elaborado";
            $aprobado_elabora = 1;
        }
        
        if($radioAprobado == 'rechazado' && $flujoAprovacion == 'reinicia'){
            $estado = "Pendiente";
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
            $estado = "Revisado";
            $aprobado_revisa = 1;
        }
        
        if($radioAprobado == 'aprobado' && $flujoAprovacion == 'cierra'){
            echo "Entro a pendiente";
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
            $estado = "Aprobado";
            $aprobado_aprueba = 1;
        }
        
        if($radioAprobado == 'aprobado' && $flujoAprovacion == 'cierra'){
            $estado = "Aprobado";
            $aprobado_aprueba = 1;
        }
        
        if($radioAprobado == 'rechazado' && $flujoAprovacion == 'reinicia'){
            $estado = "Pendiente";
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
            $mysqli->query("UPDATE documento SET vigente='1' WHERE id='$idDocumento'");
            $mysqli->query("UPDATE solicitudDocumentos SET estado = 'Ejecutado', fechaCierre = '$fechaCierre' WHERE id = $idSolicitud ");
        }
        
    }
    
    // print_r($elabora);
    ////// ac�� estaba el require de envios correos
    
    
    
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

    
    if($controlCambios != NULL){
        $mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuario, fecha, rol) VALUES('$idSolicitud','$controlCambios','$idUser','$fecha','$rol')")or die(mysqli_error($mysqli));
    }
    
    if($estado == "Rechazado"){
        
        
        $mysqli->query("UPDATE documento SET estado = 'Rechazado', vigente = '0', asumeFlujo = NULL WHERE id_solicitud = $idSolicitud");
        $mysqli->query("UPDATE solicitudDocumentos SET estado = 'Rechazado' WHERE id = $idSolicitud");
        
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
        require '../usuarios/libreria/PHPMailerAutoload.php';
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
        /*echo '<meta http-equiv="refresh" content="0; URL= ../../creacionDocumental.php">
    
            <script language="javascript"> alert("Exito al finalizar."); </script>'; */
        
      
    }

    
    
    
}

