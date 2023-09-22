<?php
error_reporting(E_ERROR);
date_default_timezone_set("America/Bogota");
// aprobación de documento para el almacenamiento de los datos del flujo
session_start();
error_reporting(E_ERROR);
$idUser = $_SESSION["session_username"];

require_once '../../conexion/bd.php'; //


if(isset($_POST['agregarDocB'])){
        '<b>Proceso A:</b>'.$procesoA = $_POST['procesoA'];
        '<br>';
        '<b>Proceso B:</b>'.$procesoB = $_POST['procesoB'];
        if($procesoA != NULL && $procesoB != NULL){
            //echo 'No puede enviar 2 procesos a la vez, selecione únicamente el proceso de su interés';
            ?>
            
            
                        <script> 
                            window.onload=function(){
                        
                                document.forms["miformulario"].submit();
                            }
                        </script>
                        <!-- ../../ -->
                        <form name="miformulario" action="../../crearDocumentoMasivo" method="POST" onsubmit="procesar(this.action);" >
                            <input type="hidden" name="validacionExisteProceso" value="1">
                        </form> 
                
            
            <?php
            
        }else{
            '<br>';
            '<b>Tipo Documento:</b>'.$tipoDocumento=$_POST['tipo'];
            '<br>';
        
            '<b>Nombre Documento:</b>'.$documento=$_POST['nombreDocumento'];
            '<br>';
        
        
            '<b>Norma:</b>';
            $norma = json_encode($_POST['norma']);
            '<br>';

            if($_POST['procesoA'] != NULL){
                $proceso=$_POST['procesoA'];     
            }
            if($_POST['procesoB'] != NULL){
                $proceso=$_POST['procesoB'];   
            }

            '<b>Proceso:</b>'.$proceso;
            '<br>';
            '<b>Tipo Documento:</b>'.$tipoDocumento=$_POST['tipoDoc'];
            '<br>';
            

            // validamos que el encargado entre números o letras
            if ($_POST['encargado'] != NULL){
                 '<b>Encargado:</b>'.$encargado =$_POST['encargado'];
            }else{
                 '<b>Encargado:</b>'.$encargado ='0';
            }
             '<br>Nombre encargado eliminado: '.$encargadoTexto=$_POST['encargadoT'];
            // END
            

            //$solicitud = utf8_decode($_POST['solicitud']);
            '<br>';

            '<b>Fecha:</b>'.$fecha = date("Y:m:j");
            '<br>';
            '<b>Archivo:</b>'.$archivoNombre = $_FILES['archivo']['name'];
            $guardado = $_FILES['archivo']['tmp_name'];
            '<br>';
            '<br>Método de creación'.$metodo=$_POST['rad_metodo'];
            '<br>';
            'Ubicación: '.$ubicacion=$_POST['ubicacion'];
            '<br>';
            '<b>Usuario:</b>'.$usuario = $_POST['usuario'];
            '<br>';
            $validandoAlmacenamientoArrya=$_POST['validandoUsuarios'];
            '<br>';

            $radioElabora = $_POST['radiobtnE'];
            '<br>';
            $elabora=serialize($_POST['select_encargadoE']);
            $elaboraN = unserialize($elabora); // para la notificación creación
            if($validandoAlmacenamientoArrya == 'activosUsuarios' ){
                array_unshift($elaboraN,$radioElabora);
                '<b>Quien Elabora:</b>'.$quienElabora=json_encode($elaboraN);
                '<br>';
            }else{
                '<b>Quien Elabora:</b>'.$quienElabora=$_POST['select_encargadoE'];
            }
            $radioRevisa = $_POST['radiobtnR'];
            '<br>';
            $revisa=serialize($_POST['select_encargadoR']);
            $revisaN = unserialize($revisa); // para la notificación creación
            if($validandoAlmacenamientoArrya == 'activosUsuarios' ){
                array_unshift($revisaN,$radioRevisa);
                '<b>Quien Revisa:</b>'.$quienRevisa=json_encode($revisaN);
            }else{
                '<b>Quien Revisa:</b>'.$quienRevisa=$_POST['select_encargadoR'];
            }
            '<br>';

            $radioAprueba = $_POST['radiobtnA'];
            '<br>';
            $aprueba=serialize($_POST['select_encargadoA']);
            $apruebaN = unserialize($aprueba); // para la notificación creación
            if($validandoAlmacenamientoArrya == 'activosUsuarios' ){
                array_unshift($apruebaN,$radioAprueba);
                '<b>Quien Aprueba:</b>'.$quienAprueba=json_encode($apruebaN);
            }else{
                '<b>Quien Aprueba:</b>'.$quienAprueba=$_POST['select_encargadoA'];
            }
            '<br>';
            '<br>';

            '<b>Codificacion:</b>'.$codificacion = $_POST['radCodificacion'];
            '<br>';
            '<b>Version:</b>'.$version = $_POST['versionDeclarada'];
            '<br>';
            '<b>Consecutivo:</b>'.$consecutivo = $_POST['consecutivoDeclarado'];
            '<br>';
            '<br>';
            //echo '<b>PDF:</b>'.$guardado = $_FILES['miInput']['name'];
            //echo '<b>PDF:</b>'.$guardado = $_FILES['archivootro']['names'];
            // echo '<b>Archivo:</b>'.$archivoNombre = $_FILES['archivo']['name'];
            '<b>Documento Externo</b>:'.$documentosExternos = json_encode($_POST['documentos_externos']);
            '<br>';
            '<b>Definiciones</b>:'.$definiciones = json_encode($_POST['definiciones']);
            '<br>';
            '<br>archivo de gestión: '.$archivo_gestion=$_POST['archivo_gestion'];
            '<br>';
            '<br>archivo de central: '.$archivo_central=$_POST['archivo_central'];
            '<br>';
            '<br>archivo de historico: '.$archivo_historico=$_POST['archivo_historico'];
            '<br>';
            '<br>disposición documental: '.$disposicion_documental=$_POST['diposicion_documental'];
            '<br>';

            $radioResponsable = $_POST['radiobtnD'];
            '<br>';
            $responsable=serialize($_POST['select_encargadoD']);
            $responsableN = unserialize($responsable); // para la notificación creación
            if($_POST['validandoUsuariosR'] == 'activosUsuariosResponsable'){
                array_unshift($responsableN,$radioResponsable);
                '<b>Quien responsable: </b>'.$escargadoDispo=json_encode($responsableN);
            }else{
                '<b>Quien responsable: </b>'.$escargadoDispo=$_POST['select_encargadoD'];
            }
            '<br>';
            
            $editorHtml = utf8_decode($_POST['editorHtml']);
            

            '<b>Meses de Revision</b>:'.$mesesRevision = intval($_POST['mesesRevision']);
        
            //// realiza el proceso de aprobación del documento
                if($archivoNombre == NULL && $guardado == NULL){
                    
                    $ruta = 'sin datos';
                    
                    $mysqli->query("INSERT INTO solicitudDocumentos (nombreEncargado,estado, quienSolicita, tipoSolicitud, tipoDocumento, encargadoAprobar, nombreDocumento, nombreDocumento2, proceso, solicitud,fecha,fechaCierre,documento,plataformaH,docVigente,quienAprueba)
                            VALUES ('$encargadoTexto','Aprobado','$usuario','1','$tipoDocumento','$encargado','$documento','$documento','$proceso','$documento','$fecha','$fecha','$ruta','$plataformaHabilitada','1','$usuario')")or die(mysqli_error($mysqli));

                    
                    $queryId = $mysqli->query("SELECT MAX(id) AS id FROM `solicitudDocumentos` WHERE quienSolicita = '$usuario' ORDER BY id DESC");
                    $datos = $queryId->fetch_array(MYSQLI_ASSOC);
                    '<br>ID documento: '.$idSolicitud=$datos['id'];
                    
                    if($datos != NULL){
                        //VERSION Y CONSECUTIVO                    
                        //Consecutivo y version cuando son definidos por el cliente
                        $queryVersiones = $mysqli->query("SELECT * FROM versionamiento WHERE idProceso = '$proceso' AND idTipoDocumento = '$tipoDocumento'");
                        $datosVersiones = $queryVersiones->fetch_assoc();
                        
                        $versionInicial = $datosVersiones['versionInicial'];
                        $consecutivoIncial = $datosVersiones['consecutivoInicial'];
                        
                        $rol = $_POST['rol'];
                        
                        $radCodificacion = 'manual';

                        if($radCodificacion == 'manual'){
                            "<br>MANUAL<br>";
                            '<br>Versión: '.$version = $version;
                            '<br>Consecutivo: '.$consecutivo = $consecutivo;
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
                            $queryProcesos = $mysqli->query("SELECT nombre,prefijo from procesos WHERE id = '".$proceso."' ");
                            $datosProceso = $queryProcesos->fetch_array(MYSQLI_ASSOC);
                            '<br>Nombre proceso: '.$nomProceso = $datosProceso['nombre'];
                            $prefijoProceso = $datosProceso['prefijo']; 
                        
                            // '<br>Fecha de aprobación: '.$fechaAprobacion=date("Y:m:j h:i:s: A");

                        /////// datos para el que elaboro
                    'Siemre segunda ---- primera validación';
                    '<br>';
                    $fechaElaboracion=$_POST['fechaElaboracion'];
                    '<br>';
                    $controlCambios=$_POST['controlCambios'];
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
                            }
                            if($comentarioRevision != NULL){
                            $mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuarioB, fecha, rol) VALUES('$idSolicitud','$comentarioRevision','$nombreReviso','$fechaRevision','Revisor(a)')")or die(mysqli_error($mysqli));  
                            }
                            if($comentarioAprobo != NULL){
                            $mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuarioB, fecha, rol) VALUES('$idSolicitud','$comentarioAprobo','$nombreAprobo','$fechaAprobacion','Aprobador(a)')")or die(mysqli_error($mysqli));  
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
                                                vigente,
                                                fechaAprobado,
                                                pre
                                            )
                                            VALUES(
                                                '$codificacion',
                                                '$radCodificacion',
                                                '$consecutivo',
                                                '$version',
                                                '$documento',
                                                '$proceso',
                                                '$nomProceso',
                                                '$norma',
                                                '$metodo',
                                                '$tipoDocumento',
                                                '$ubicacion',
                                                '$quienElabora',
                                                '$quienRevisa',
                                                '$quienAprueba',
                                                '$documentosExternos',
                                                '$definiciones',
                                                '$archivo_gestion',
                                                '$archivo_central',
                                                '$archivo_historico',
                                                '$disposicion_documental',
                                                '$escargadoDispo',
                                                '$select_encargadoAR',
                                                'cierra',
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
                                                '$fechaAprobacion',
                                                'si'
                                                )")or die(mysqli_error($mysqli));
                                            
                    }
                    
                    
                    ?>
                        <script> 
                            window.onload=function(){
                                document.forms["miformulario"].submit();
                            }
                        </script>
                        <form name="miformulario" action="../../crearDocumentoMasivo" method="POST" onsubmit="procesar(this.action);" >
                        </form> 
                    <?php
                    
                }else{
                    
                    
                                            
                                            if(!file_exists('../../archivos/solicitudes')){
                                                mkdir('../../archivos/solicitudes',0777,true);
                                                if(file_exists('../../archivos/solicitudes')){
                                                    if(move_uploaded_file($guardado, '../../archivos/solicitudes/'.$archivoNombre)){
                                                        
                                                        $ruta = utf8_decode('archivos/solicitudes/'.$archivoNombre);
                                                        
                                                       
                                                        ?>
                                                            <script> 
                                                                 window.onload=function(){
                                                               
                                                                     document.forms["miformulario"].submit();
                                                                 }
                                                            </script>
                                                             
                                                            <form name="miformulario" action="h1" method="POST" onsubmit="procesar(this.action);" >
                                                            </form> 
                                                        <?php
                                                       
                                                    }else{
                                                        
                                                        
                                                        ?>
                                                            <script> 
                                                                 window.onload=function(){
                                                               
                                                                     document.forms["miformulario"].submit();
                                                                 }
                                                            </script>
                                                             
                                                            <form name="miformulario" action="h2" method="POST" onsubmit="procesar(this.action);" >
                                                                <input type="hidden" name="validacionExiste" value="1">
                                                            </form> 
                                                        <?php
                                                    }
                                                }
                                                
                                            }else{
                                                if(move_uploaded_file($guardado, '../../archivos/solicitudes/'.$archivoNombre)){
                                                        $ruta = utf8_decode('archivos/solicitudes/'.$archivoNombre);
                                                     
                    
                                                                $mysqli->query("INSERT INTO solicitudDocumentos (nombreEncargado,estado, quienSolicita, tipoSolicitud, tipoDocumento, encargadoAprobar, nombreDocumento, nombreDocumento2, proceso, solicitud,fecha,fechaCierre,documento,plataformaH,docVigente,quienAprueba)
                                                                        VALUES ('$encargadoTexto','Aprobado','$usuario','1','$tipoDocumento','$encargado','$documento','$documento','$proceso','$documento','$fecha','$fecha','$ruta','$plataformaHabilitada','1','$usuario')")or die(mysqli_error($mysqli));

                                                                
                                                                $queryId = $mysqli->query("SELECT MAX(id) AS id FROM `solicitudDocumentos` WHERE quienSolicita = '$usuario' ORDER BY id DESC");
                                                                $datos = $queryId->fetch_array(MYSQLI_ASSOC);
                                                                '<br>ID documento: '.$idSolicitud=$datos['id'];
                                                                
                                                              
                                                                    //VERSION Y CONSECUTIVO                    
                                                                    //Consecutivo y version cuando son definidos por el cliente
                                                                    $queryVersiones = $mysqli->query("SELECT * FROM versionamiento WHERE idProceso = '$proceso' AND idTipoDocumento = '$tipoDocumento'");
                                                                    $datosVersiones = $queryVersiones->fetch_assoc();
                                                                    
                                                                    $versionInicial = $datosVersiones['versionInicial'];
                                                                    $consecutivoIncial = $datosVersiones['consecutivoInicial'];
                                                                    
                                                                    $rol = $_POST['rol'];
                                                                    
                                                                    $radCodificacion = 'manual';

                                                                    if($radCodificacion == 'manual'){
                                                                        "<br>MANUAL<br>";
                                                                        '<br>Versión: '.$version = $version;
                                                                        '<br>Consecutivo: '.$consecutivo = $consecutivo;
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
                                                                        $queryProcesos = $mysqli->query("SELECT nombre,prefijo from procesos WHERE id = '".$proceso."' ");
                                                                        $datosProceso = $queryProcesos->fetch_array(MYSQLI_ASSOC);
                                                                        '<br>Nombre proceso: '.$nomProceso = $datosProceso['nombre'];
                                                                        $prefijoProceso = $datosProceso['prefijo']; 
                                                                    
                                                                        // '<br>Fecha de aprobación: '.$fechaAprobacion=date("Y:m:j h:i:s: A");

                                                                    /////// datos para el que elaboro
                                                                'Siemre segunda ---- primera validación';
                                                                '<br>';
                                                                $fechaElaboracion=$_POST['fechaElaboracion'];
                                                                '<br>';
                                                                $controlCambios=$_POST['controlCambios'];
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
                                                                        }
                                                                        if($comentarioRevision != NULL){
                                                                        $mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuarioB, fecha, rol) VALUES('$idSolicitud','$comentarioRevision','$nombreReviso','$fechaRevision','Revisor(a)')")or die(mysqli_error($mysqli));  
                                                                        }
                                                                        if($comentarioAprobo != NULL){
                                                                        $mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuarioB, fecha, rol) VALUES('$idSolicitud','$comentarioAprobo','$nombreAprobo','$fechaAprobacion','Aprobador(a)')")or die(mysqli_error($mysqli));  
                                                                        }
                                                                
                                                                        $fecha = date("Ymjhis");

                                                                        $rol = "Encargado(a) solicitud";
                                                                    
                                                                        echo '1: '.$nombrePDF = $_FILES['archivopdf']['name']; 
                                                                        $rutaPDF =$_FILES['archivopdf']['tmp_name']; 
                                                                        echo '<br>2: '.$nombreOtro =$_FILES['archivootro']['name'];
                                                                        $rutaOtro =$_FILES['archivootro']['tmp_name'];

                                                                        if(!file_exists('../../archivos/documentos/')){
                                                                            mkdir('../../archivos/documentos',0777,true);
                                                                            if(file_exists('../../archivos/documentos/')){
                                                                                if(move_uploaded_file($rutaPDF, '../../archivos/documentos/'.$fecha.$nombrePDF)){
                                                                                    
                                                                                }else{
                                                                                    //echo "Archivo no se pudo guardar";
                                                                                }
                                                                            }
                                                                        }else{
                                                                            if(move_uploaded_file($rutaPDF, '../../archivos/documentos/'.$fecha.$nombrePDF)){
                                                                            
                                                                            }else{
                                                                                //echo "Archivo no se pudo guardar";
                                                                            }
                                                                        }
                                                                        
                                                                        if(!file_exists('../../archivos/documentos/')){
                                                                            mkdir('../../archivos/documentos',0777,true);
                                                                            if(file_exists('../../archivos/documentos/')){
                                                                                if(move_uploaded_file($rutaOtro, '../../archivos/documentos/'.$fecha.$nombreOtro)){
                                                                                    //echo "Archivo guardado con exito";
                                                                                    
                                                                                }else{
                                                                                    //echo "Archivo no se pudo guardar";
                                                                                }
                                                                            }
                                                                        }else{
                                                                            if(move_uploaded_file($rutaOtro, '../../archivos/documentos/'.$fecha.$nombreOtro)){
                                                                                //echo "Archivo guardado con exito";
                                                                            }else{
                                                                                //echo "Archivo no se pudo guardar";
                                                                            }
                                                                        }
                                                                       echo $nombrePDFf=$fecha.$nombrePDF;
                                                                       echo '<br>';
                                                                       echo $nombreOtroo=$fecha.$nombreOtro;
                                                                          
                                                                              
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
                                                                                            fechaAprobado,
                                                                                            pre
                                                                                        )
                                                                                        VALUES(
                                                                                            '$codificacion',
                                                                                            '$radCodificacion',
                                                                                            '$consecutivo',
                                                                                            '$version',
                                                                                            '$documento',
                                                                                            '$proceso',
                                                                                            '$nomProceso',
                                                                                            '$norma',
                                                                                            '$metodo',
                                                                                            '$tipoDocumento',
                                                                                            '$ubicacion',
                                                                                            '$quienElabora',
                                                                                            '$quienRevisa',
                                                                                            '$quienAprueba',
                                                                                            '$documentosExternos',
                                                                                            '$definiciones',
                                                                                            '$archivo_gestion',
                                                                                            '$archivo_central',
                                                                                            '$archivo_historico',
                                                                                            '$disposicion_documental',
                                                                                            '$escargadoDispo',
                                                                                            '$select_encargadoAR',
                                                                                            'cierra',
                                                                                            '$mesesRevision',
                                                                                            '$idSolicitud',
                                                                                            TRUE,
                                                                                            '$nombrePDFf',
                                                                                            '$nombreOtroo',
                                                                                            '$editorHtml',
                                                                                            'Aprobado',
                                                                                            '$idUser',
                                                                                            '1',
                                                                                            '1',
                                                                                            '1',
                                                                                            '1',
                                                                                            '$fechaAprobacion',
                                                                                            'si'
                                                                                            )")or die(mysqli_error($mysqli));
                                                        ?>
                                                            <script> 
                                                                 window.onload=function(){
                                                               
                                                                     document.forms["miformulario"].submit();
                                                                 }
                                                            </script>
                                                             
                                                            <form name="miformulario" action="../../crearDocumentoMasivo" method="POST" onsubmit="procesar(this.action);" >
                                                            </form> 
                                                        <?php
                                                        
                                                    }else{
                                                        
                                                        ?>
                                                            <script> 
                                                                 window.onload=function(){
                                                               
                                                                     document.forms["miformulario"].submit();
                                                                 }
                                                            </script>
                                                             
                                                            <form name="miformulario" action="h4" method="POST" onsubmit="procesar(this.action);" >
                                                            </form> 
                                                        <?php
                                                    }
                                                
                                            }
                }

               
            //// END


        


        }

}
if(isset($_POST['ejecutador'])){
    $mysqli->query("UPDATE documento SET pre = NULL WHERE pre='si' ");
    ?>
                        <script> 
                             window.onload=function(){
                           
                                document.forms["miformulario"].submit();
                             }
                        </script>
                         
                        <form name="miformulario" action="../../crearDocumentoMasivo" method="POST" onsubmit="procesar(this.action);" >
                        </form> 
                    <?php
}
//END
?>