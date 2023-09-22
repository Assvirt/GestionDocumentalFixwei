<?php
/* Archivo para control de almacenamiento de documentos masivos */
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
        
        
        /// volvemos el texto totalmente en minuscula
        $validandoDocumentoCaracteresPdf=mb_strtolower($_FILES['archivopdf']['name']);
        $validandoDocumentoCaracteresOtro=mb_strtolower($_FILES['archivootro']['name']);
        
        $activarAlerta=TRUE;
        $activarAlertaOtro=TRUE;
        
        $descripcion_carecteres = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ0123456789-_,.()/ ";
        for ($i=0; $i<strlen($validandoDocumentoCaracteresPdf); $i++){
            if (strpos($descripcion_carecteres, substr($validandoDocumentoCaracteresPdf,$i,1))===false){
                $validandoDocumentoCaracteresPdf . " no es válido<br>";
                $activarAlerta=FALSE;
                //return false;
            }
        }
        
        $descripcion_carecteres_otro = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ0123456789-_,.()/ ";
        for ($i=0; $i<strlen($validandoDocumentoCaracteresOtro); $i++){
            if (strpos($descripcion_carecteres_otro, substr($validandoDocumentoCaracteresOtro,$i,1))===false){
                $validandoDocumentoCaracteresOtro . " no es válido<br>";
                $activarAlerta=FALSE;
                //return false;
            }
        }
    
        /*
        $descripcion_carecteres=["'"];
        for($bc=0; $bc<count($descripcion_carecteres); $bc++){
            $descripcion_carecteres[$bc]; 
            $cadena_carecteres_descripcion = $descripcion_carecteres[$bc];
            ' - '.$coincidencia_caracteres= strpos($validandoDocumentoCaracteresPdf, $cadena_carecteres_descripcion);
            if($coincidencia_caracteres != NULL){
                $activarAlerta=FALSE;
            }    
        }
        
        $descripcion_carecteres_otro=["'"];
        for($bc=0; $bc<count($descripcion_carecteres_otro); $bc++){
            $descripcion_carecteres_otro[$bc]; 
            $cadena_carecteres_descripcion_otro = $descripcion_carecteres_otro[$bc];
            ' - '.$coincidencia_caracteres_otro= strpos($validandoDocumentoCaracteresOtro, $cadena_carecteres_descripcion_otro);
            if($coincidencia_caracteres_otro != NULL){
                $activarAlertaOtro=FALSE;
            }    
        }
        */
    if($activarAlerta == FALSE || $activarAlertaOtro == FALSE){
                    
                    '<br>';
            '<b>Tipo Documento:</b>'.$tipoDocumento=$_POST['tipo'];
            '<br>';
        
            '<b>Nombre Documento:</b>'.$documento=utf8_decode($_POST['nombreDocumento']);
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
            'A: '.$validandoAlmacenamientoArrya=$_POST['validandoUsuarios'];
            '<br>';
            'B: '.$validandoAlmacenamientoArryaB=$_POST['validandoUsuariosB'];
            '<br>';
            'C: '.$validandoAlmacenamientoArryaC=$_POST['validandoUsuariosC'];
            '<br>';


            //////////////// flujo usuario ELABORADOR
            $radioElabora = $_POST['radiobtnE'];
            '<br>';
            $elabora=serialize($_POST['select_encargadoE']);
            $elaboraN = unserialize($elabora); // para la notificación creación
            if($validandoAlmacenamientoArrya == 'activosUsuarios' ){
                array_unshift($elaboraN,$radioElabora);
                '<b>Quien Elabora:</b>'.$quienElabora=json_encode($elaboraN);
                '<br>';
            }else{
                '<b>Quien Elabora:</b>'.$quienElabora=utf8_decode($_POST['select_encargadoEE']);
            }
            //// END
            
            
            ////////////////// flujo usuario REVISOR
            $radioRevisa = $_POST['radiobtnR'];
            '<br>';
            $revisa=serialize($_POST['select_encargadoR']);
            $revisaN = unserialize($revisa); // para la notificación creación 
            if($validandoAlmacenamientoArryaB == 'activosUsuariosB' ){
                array_unshift($revisaN,$radioRevisa);
                '<b>Quien Revisaa:</b>'.$quienRevisa=json_encode($revisaN);
            }else{
                '<b>Quien Revisa2:</b>'.$quienRevisa=utf8_decode($_POST['select_encargadoRR']);
            }
            '<br>';
            ////// END
            
            
            //////////////// flujo usuario APROBADOR
            $radioAprueba = $_POST['radiobtnA'];
            '<br>';
            $aprueba=serialize($_POST['select_encargadoA']);
            $apruebaN = unserialize($aprueba); // para la notificación creación
            if($validandoAlmacenamientoArryaC == 'activosUsuariosC' ){
                array_unshift($apruebaN,$radioAprueba);
               '<b>Quien Aprueba:</b>'.$quienAprueba=json_encode($apruebaN);
            }else{
                '<b>Quien Aprueba:</b>'.$quienAprueba=utf8_decode($_POST['select_encargadoAA']);
            }
            '<br>';
            '<br>';
            ///// END

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
            '<br>archivo de gestión: '.$archivo_gestion=utf8_decode($_POST['archivo_gestion']);
            '<br>';
            '<br>archivo de central: '.$archivo_central=utf8_decode($_POST['archivo_central']);
            '<br>';
            '<br>archivo de historico: '.$archivo_historico=utf8_decode($_POST['archivo_historico']);
            '<br>';
            '<br>disposición documental: '.$disposicion_documental=utf8_decode($_POST['diposicion_documental']);
            '<br>';

            $radioResponsable = $_POST['radiobtnD'];
            '<br>';
            $responsable=serialize($_POST['select_encargadoD']);
            $responsableN = unserialize($responsable); // para la notificación creación
            if($_POST['validandoUsuariosR'] == 'activosUsuariosResponsable'){
                array_unshift($responsableN,$radioResponsable);
                '<b>Quien responsable: </b>'.$escargadoDispo=json_encode($responsableN);
            }else{
                '<b>Quien responsable: </b>'.$escargadoDispo=utf8_decode($_POST['select_encargadoD']);
            }
            '<br>';
            
            $editorHtml = utf8_decode($_POST['editorHtml']);
            

            '<b>Meses de Revision</b>:'.$mesesRevision = intval($_POST['mesesRevision']);
                    
                    $ruta = 'sin datos';
                    
                    $mysqli->query("INSERT INTO solicitudDocumentos (nombreEncargado,estado, quienSolicita, tipoSolicitud, tipoDocumento, encargadoAprobar, nombreDocumento, nombreDocumento2, proceso, solicitud,fecha,fechaCierre,documento,plataformaH,docVigente,quienAprueba)
                            VALUES ('$encargadoTexto','Ejecutado','$usuario','1','$tipoDocumento','$encargado','$documento','$documento','$proceso','$documento','$fecha','$fecha','$ruta','1','1','$usuario')")or die(mysqli_error($mysqli));

                    
                    $queryId = $mysqli->query("SELECT MAX(id) AS id FROM `solicitudDocumentos` WHERE quienSolicita = '$usuario' ORDER BY id DESC");
                    $datos = $queryId->fetch_array(MYSQLI_ASSOC);
                    '<br>ID documento: '.$idSolicitud=$datos['id'];
                    
                    if($datos != NULL){
                        //VERSION Y CONSECUTIVO  
                        $queryProcesos = $mysqli->query("SELECT nombre,prefijo from procesos WHERE id = '".$proceso."' ");
                        $datosProceso = $queryProcesos->fetch_array(MYSQLI_ASSOC);
                        //$nomProceso = $datosProceso['nombre'];
                        $prefijoProceso = $datosProceso['prefijo'];
                        
                    
                        //TIPO DE DOCUMENTO 
                        $queryDocumentos = $mysqli->query("SELECT nombre, prefijo from tipoDocumento WHERE id = '".$tipoDocumento."' ");
                        $datosDocumento = $queryDocumentos->fetch_array(MYSQLI_ASSOC);
                        //$tipoDocumento = $datosDocumento['nombre'];
                        $prefijoTipo = $datosDocumento['prefijo']; 
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
                            
                            
                            
                            
                             $codificacion;
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
                    $controlCambios=utf8_decode($_POST['controlCambios']);
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

                        if($validandoAlmacenamientoArrya == 'activosUsuarios'){ //echo 'No';
                            $quienElaboraDecode=json_decode($quienElabora);
                            if($quienElaboraDecode[0] == 'cargos'){ 
                                $longitud = count($quienElaboraDecode);
                                
                                for($i=1; $i<$longitud; $i++){
                                    //saco el valor de cada elemento
                                    $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienElaboraDecode[$i]'");
                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                    
                                    'Cargo: '.$enviarDocumentoControlCambiosElaborado=$nombres['nombreCargos'];
                                }            
                            }
                            
                            if($quienElaboraDecode[0] == 'usuarios'){ 
                                $longitud = count($quienElaboraDecode);
                                
                                for($i=1; $i<$longitud; $i++){
                                    //saco el valor de cada elemento
                                    $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienElaboraDecode[$i]'");
                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                    
                                    'Usuario: '.$enviarDocumentoControlCambiosElaborado=$nombres['cedula'];
                                } 
                            }
                             $nombreElaboro=$enviarDocumentoControlCambiosElaborado; '<br>';
                            
                        }
                        
                        if($validandoAlmacenamientoArryaB == 'activosUsuariosB'){ //echo 'No';
                            $quienRevisadoDecode=json_decode($quienRevisa);
                            if($quienRevisadoDecode[0] == 'cargos'){ 
                                $longitud = count($quienRevisadoDecode);
                                
                                for($i=1; $i<$longitud; $i++){
                                    //saco el valor de cada elemento
                                    $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienRevisadoDecode[$i]'");
                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                    
                                    'Cargo: '.$enviarDocumentoControlCambiosRevisado=$nombres['nombreCargos'];
                                }            
                            }
                            
                            if($quienRevisadoDecode[0] == 'usuarios'){ 
                                $longitud = count($quienRevisadoDecode);
                                
                                for($i=1; $i<$longitud; $i++){
                                    //saco el valor de cada elemento
                                    $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienRevisadoDecode[$i]'");
                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                    
                                    'Usuario: '.$enviarDocumentoControlCambiosRevisado=$nombres['cedula'];
                                } 
                            }
                            $nombreReviso=$enviarDocumentoControlCambiosRevisado; '<br>';
                        }
                        if($validandoAlmacenamientoArryaC == 'activosUsuariosC'){ 
                            $quienApruebaDecode=json_decode($quienAprueba);
                            if($quienApruebaDecode[0] == 'cargos'){ 
                                $longitud = count($quienApruebaDecode);
                                
                                for($i=1; $i<$longitud; $i++){
                                    //saco el valor de cada elemento
                                    $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienApruebaDecode[$i]'");
                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                    
                                    'Cargo: '.$enviarDocumentoControlCambiosAprueba=$nombres['nombreCargos'];
                                }            
                            }
                            
                            if($quienApruebaDecode[0] == 'usuarios'){ 
                                $longitud = count($quienApruebaDecode);
                                
                                for($i=1; $i<$longitud; $i++){
                                    //saco el valor de cada elemento
                                    $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienApruebaDecode[$i]'");
                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                    
                                    'Usuario: '.$enviarDocumentoControlCambiosAprueba=$nombres['cedula'];
                                } 
                            }
                        /// END

                           
                            $nombreAprobo=$enviarDocumentoControlCambiosAprueba; '<br>';
                            
                        }
                        if($validandoAlmacenamientoArrya == 'retiradosUsuarios'){ 
                            $nombreElaboro=utf8_decode($_POST['select_encargadoEE']);
                        }
                        if($validandoAlmacenamientoArryaB == 'retiradosUsuariosB'){
                            $nombreReviso=utf8_decode($_POST['select_encargadoRR']);
                        }
                        if($validandoAlmacenamientoArryaC == 'retiradosUsuariosC'){
                            $nombreAprobo=utf8_decode($_POST['select_encargadoAA']);
                        }
                         $nombreElaboro;
                         '<br>';
                         $nombreReviso;
                         '<br>';
                         $nombreAprobo;
                        
                        
                        // validamos los comentarios
                        if($controlCambios != NULL){
                         $controlCambios=$controlCambios;   
                        }else{
                            $controlCambios='N/A';
                        }
                        
                        if($comentarioRevision != NULL){
                         $comentarioRevision=$comentarioRevision;   
                        }else{
                            $comentarioRevision='N/A';
                        }
                        
                        if($comentarioAprobo != NULL){
                         $comentarioAprobo=$comentarioAprobo;   
                        }else{
                            $comentarioAprobo='N/A';
                        }
                        
                        
                        // end
                        
                        
                        
                            if($fechaElaboracion != NULL){ //$controlCambios
                                $mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuarioB, fecha, rol) VALUES('$idSolicitud','$controlCambios','$nombreElaboro','$fechaElaboracion','Elaborador(a)')")or die(mysqli_error($mysqli));  
                            }
                            if($fechaRevision != NULL){ //$comentarioRevision
                            $mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuarioB, fecha, rol) VALUES('$idSolicitud','$comentarioRevision','$nombreReviso','$fechaRevision','Revisor(a)')")or die(mysqli_error($mysqli));  
                            }
                            if($fechaAprobacion != NULL){ //$comentarioAprobo
                            $mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuarioB, fecha, rol) VALUES('$idSolicitud','$comentarioAprobo','$nombreAprobo','$fechaAprobacion','Aprobador(a)')")or die(mysqli_error($mysqli));  
                            }
                    
                    
                    
                    
                    /*
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
                                                obsoleto,
                                                fechaAprobado,
                                                pre,
                                                aprobado_aprueba
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
                                                '0',
                                                '1',
                                                '$fechaAprobacion',
                                                'si',
                                                '1'
                                                )")or die(mysqli_error($mysqli));
                                        */
                                                      
                                                            /* campos comentados
                                                            `codificacion`, '$codificacion',
                                                            
                                                            `consecutivo`, 
                                                            `version`, 
                                                            
                                                                                            
                                                            
                                                             
                                                            
                                                             
                                                            */                  
                                                                $mysqli->query("INSERT INTO documento(
                                                                                            
                                                                                            `tipoCodificacion`,
                                                                                            `versionTemporal`,
                                                                                            `consecutivoTemporal`,
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
                                                                                            obsoleto,
                                                                                            fechaAprobado,
                                                                                            pre,
                                                                                            aprobado_aprueba
                                                                                        )
                                                                                        VALUES(
                                                                                            
                                                                                            '$radCodificacion',
                                                                                            '$version',
                                                                                            '$consecutivo',
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
                                                                                            '0',
                                                                                            '1',
                                                                                            '$fechaAprobacion',
                                                                                            'si',
                                                                                            '1'
                                                                                            )")or die(mysqli_error($mysqli));
                                                                       
                    }
                    
                    //// este espacio se crea para el control de cambios el procedimiento del flujo de aprobación del documento
                    $queryIdUsuarioElabora = $mysqli->query("SELECT MAX(id) AS id FROM `documento` WHERE usuarioElabora = '$usuario' ORDER BY id DESC");
                    $datosUsuarioElabora = $queryIdUsuarioElabora->fetch_array(MYSQLI_ASSOC);
                    '<br>ID documento: '.$idDocumentoElaborado=$datosUsuarioElabora['id'];
                    
                    
                    
                    $informacion=utf8_decode($_POST['editor1']);
                    
                    $consultamosExistenciaComentario=$mysqli->query("SELECT * FROM controlCambiosFlujo WHERE idDocumento='$idDocumentoElaborado' ");
                    $extrarConsultaExistenciaComentario=$consultamosExistenciaComentario->fetch_array(MYSQLI_ASSOC);
                    if($extrarConsultaExistenciaComentario['idDocumento'] != NULL){
                        $mysqli->query("UPDATE controlCambiosFlujo SET informacion='$informacion' fecha='$fecha', comentarioAnterior='$informacion' WHERE idDocumento='$idDocumentoElaborado' ")or die(mysqli_error($mysqli));
                    }else{
                        $mysqli->query("INSERT INTO controlCambiosFlujo (idDocumento,informacion,fecha,comentarioAnterior)VALUES('$idDocumentoElaborado','$informacion','$fecha','$informacion')")or die(mysqli_error($mysqli));
                    }
                    //// end
                    
                    ///// validamos los documentos para verificar que estén en orden, en caso contrario mandamos la alerta
                                                        $preguntadoValidacion=$mysqli->query("SELECT * FROM documento WHERE  id='$idDocumentoElaborado' ");
                                                		$extraerPreguntaValidacion=$preguntadoValidacion->fetch_array(MYSQLI_ASSOC);
                    ?>
                                                            <script> 
                                                                 window.onload=function(){
                                                                   document.forms["miformularioAlerta"].submit();
                                                                 }
                                                            </script>
                                                             
                                                            <form name="miformularioAlerta" action="../../crearDocumentoMasivoObsoleto" method="POST" onsubmit="procesar(this.action);" >
                                                                <input name="alertaDocumento" value="1" type="hidden">
                                                                <input name="editarDocumentoMasivo" value="1" type="hidden">
                                                                <input name="enviarIdDocumento" value="<?php echo $extraerPreguntaValidacion['id'];?>" type="hidden">
                                                                <input name="enviarIdDocumentoControl" value="<?php echo $extraerPreguntaValidacion['id_solicitud'];?>" type="hidden">
                                                                <!-- <input type="submit" value="enviar alerta"> -->
                                                            </form> 
                                                        <?php 
                    
                
    }else{ 
        
        
        
        if($procesoA != NULL && $procesoB != NULL){
            //echo 'No puede enviar 2 procesos a la vez, selecione únicamente el proceso de su interés';
            ?>
            
            
                        <script> 
                            window.onload=function(){
                        
                                document.forms["miformulario"].submit();
                            }
                        </script>
                        <!-- ../../ -->
                        <form name="miformulario" action="../../crearDocumentoMasivoObsoleto" method="POST" onsubmit="procesar(this.action);" >
                            <input type="hidden" name="validacionExisteProceso" value="1">
                        </form> 
                
            
            <?php
            
        }else{
            '<br>';
            '<b>Tipo Documento:</b>'.$tipoDocumento=$_POST['tipo'];
            '<br>';
        
            '<b>Nombre Documento:</b>'.$documento=utf8_decode($_POST['nombreDocumento']);
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
            'A: '.$validandoAlmacenamientoArrya=$_POST['validandoUsuarios'];
            '<br>';
            'B: '.$validandoAlmacenamientoArryaB=$_POST['validandoUsuariosB'];
            '<br>';
            'C: '.$validandoAlmacenamientoArryaC=$_POST['validandoUsuariosC'];
            '<br>';


            //////////////// flujo usuario ELABORADOR
            $radioElabora = $_POST['radiobtnE'];
            '<br>';
            $elabora=serialize($_POST['select_encargadoE']);
            $elaboraN = unserialize($elabora); // para la notificación creación
            if($validandoAlmacenamientoArrya == 'activosUsuarios' ){
                array_unshift($elaboraN,$radioElabora);
                '<b>Quien Elabora:</b>'.$quienElabora=json_encode($elaboraN);
                '<br>';
            }else{
                '<b>Quien Elabora:</b>'.$quienElabora=utf8_decode($_POST['select_encargadoEE']);
            }
            //// END
            
            
            ////////////////// flujo usuario REVISOR
            $radioRevisa = $_POST['radiobtnR'];
            '<br>';
            $revisa=serialize($_POST['select_encargadoR']);
            $revisaN = unserialize($revisa); // para la notificación creación 
            if($validandoAlmacenamientoArryaB == 'activosUsuariosB' ){
                array_unshift($revisaN,$radioRevisa);
                '<b>Quien Revisaa:</b>'.$quienRevisa=json_encode($revisaN);
            }else{
                '<b>Quien Revisa2:</b>'.$quienRevisa=utf8_decode($_POST['select_encargadoRR']);
            }
            '<br>';
            ////// END
            
            
            //////////////// flujo usuario APROBADOR
            $radioAprueba = $_POST['radiobtnA'];
            '<br>';
            $aprueba=serialize($_POST['select_encargadoA']);
            $apruebaN = unserialize($aprueba); // para la notificación creación
            if($validandoAlmacenamientoArryaC == 'activosUsuariosC' ){
                array_unshift($apruebaN,$radioAprueba);
               '<b>Quien Aprueba:</b>'.$quienAprueba=json_encode($apruebaN);
            }else{
                '<b>Quien Aprueba:</b>'.$quienAprueba=utf8_decode($_POST['select_encargadoAA']);
            }
            '<br>';
            '<br>';
            ///// END

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
            '<br>archivo de gestión: '.$archivo_gestion=utf8_decode($_POST['archivo_gestion']);
            '<br>';
            '<br>archivo de central: '.$archivo_central=utf8_decode($_POST['archivo_central']);
            '<br>';
            '<br>archivo de historico: '.$archivo_historico=utf8_decode($_POST['archivo_historico']);
            '<br>';
            '<br>disposición documental: '.$disposicion_documental=utf8_decode($_POST['diposicion_documental']);
            '<br>';

            $radioResponsable = $_POST['radiobtnD'];
            '<br>';
            $responsable=serialize($_POST['select_encargadoD']);
            $responsableN = unserialize($responsable); // para la notificación creación
            if($_POST['validandoUsuariosR'] == 'activosUsuariosResponsable'){
                array_unshift($responsableN,$radioResponsable);
                '<b>Quien responsable: </b>'.$escargadoDispo=json_encode($responsableN);
            }else{
                '<b>Quien responsable: </b>'.$escargadoDispo=utf8_decode($_POST['select_encargadoD']);
            }
            '<br>';
            
            $editorHtml = utf8_decode($_POST['editorHtml']);
            

            '<b>Meses de Revision</b>:'.$mesesRevision = intval($_POST['mesesRevision']);
        
            //// realiza el proceso de aprobación del documento
            /// variables para validar archivos
            $validandoArchivoPDF=$_FILES['archivopdf']['name'];
            $validandoArchivoEditable=$_FILES['archivootro']['tmp_name'];
            // end
                if($archivoNombre == NULL && $guardado == NULL && $validandoArchivoPDF == NULL && $validandoArchivoEditable == NULL){
                    
                    $ruta = 'sin datos';
                    
                    $mysqli->query("INSERT INTO solicitudDocumentos (nombreEncargado,estado, quienSolicita, tipoSolicitud, tipoDocumento, encargadoAprobar, nombreDocumento, nombreDocumento2, proceso, solicitud,fecha,fechaCierre,documento,plataformaH,docVigente,quienAprueba)
                            VALUES ('$encargadoTexto','Ejecutado','$usuario','1','$tipoDocumento','$encargado','$documento','$documento','$proceso','$documento','$fecha','$fecha','$ruta','1','1','$usuario')")or die(mysqli_error($mysqli));

                    
                    $queryId = $mysqli->query("SELECT MAX(id) AS id FROM `solicitudDocumentos` WHERE quienSolicita = '$usuario' ORDER BY id DESC");
                    $datos = $queryId->fetch_array(MYSQLI_ASSOC);
                    '<br>ID documento: '.$idSolicitud=$datos['id'];
                    
                    if($datos != NULL){
                        //VERSION Y CONSECUTIVO  
                        $queryProcesos = $mysqli->query("SELECT nombre,prefijo from procesos WHERE id = '".$proceso."' ");
                        $datosProceso = $queryProcesos->fetch_array(MYSQLI_ASSOC);
                        //$nomProceso = $datosProceso['nombre'];
                        $prefijoProceso = $datosProceso['prefijo'];
                        
                    
                        //TIPO DE DOCUMENTO 
                        $queryDocumentos = $mysqli->query("SELECT nombre, prefijo from tipoDocumento WHERE id = '".$tipoDocumento."' ");
                        $datosDocumento = $queryDocumentos->fetch_array(MYSQLI_ASSOC);
                        //$tipoDocumento = $datosDocumento['nombre'];
                        $prefijoTipo = $datosDocumento['prefijo']; 
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
                            
                            
                            
                             $codificacion;
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
                    $controlCambios=utf8_decode($_POST['controlCambios']);
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

                        if($validandoAlmacenamientoArrya == 'activosUsuarios'){ //echo 'No';
                            $quienElaboraDecode=json_decode($quienElabora);
                            if($quienElaboraDecode[0] == 'cargos'){ 
                                $longitud = count($quienElaboraDecode);
                                
                                for($i=1; $i<$longitud; $i++){
                                    //saco el valor de cada elemento
                                    $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienElaboraDecode[$i]'");
                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                    
                                    'Cargo: '.$enviarDocumentoControlCambiosElaborado=$nombres['nombreCargos'];
                                }            
                            }
                            
                            if($quienElaboraDecode[0] == 'usuarios'){ 
                                $longitud = count($quienElaboraDecode);
                                
                                for($i=1; $i<$longitud; $i++){
                                    //saco el valor de cada elemento
                                    $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienElaboraDecode[$i]'");
                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                    
                                    'Usuario: '.$enviarDocumentoControlCambiosElaborado=$nombres['cedula'];
                                } 
                            }
                             $nombreElaboro=$enviarDocumentoControlCambiosElaborado; '<br>';
                            
                        }
                        
                        if($validandoAlmacenamientoArryaB == 'activosUsuariosB'){ //echo 'No';
                            $quienRevisadoDecode=json_decode($quienRevisa);
                            if($quienRevisadoDecode[0] == 'cargos'){ 
                                $longitud = count($quienRevisadoDecode);
                                
                                for($i=1; $i<$longitud; $i++){
                                    //saco el valor de cada elemento
                                    $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienRevisadoDecode[$i]'");
                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                    
                                    'Cargo: '.$enviarDocumentoControlCambiosRevisado=$nombres['nombreCargos'];
                                }            
                            }
                            
                            if($quienRevisadoDecode[0] == 'usuarios'){ 
                                $longitud = count($quienRevisadoDecode);
                                
                                for($i=1; $i<$longitud; $i++){
                                    //saco el valor de cada elemento
                                    $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienRevisadoDecode[$i]'");
                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                    
                                    'Usuario: '.$enviarDocumentoControlCambiosRevisado=$nombres['cedula'];
                                } 
                            }
                            $nombreReviso=$enviarDocumentoControlCambiosRevisado; '<br>';
                        }
                        if($validandoAlmacenamientoArryaC == 'activosUsuariosC'){ 
                            $quienApruebaDecode=json_decode($quienAprueba);
                            if($quienApruebaDecode[0] == 'cargos'){ 
                                $longitud = count($quienApruebaDecode);
                                
                                for($i=1; $i<$longitud; $i++){
                                    //saco el valor de cada elemento
                                    $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienApruebaDecode[$i]'");
                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                    
                                    'Cargo: '.$enviarDocumentoControlCambiosAprueba=$nombres['nombreCargos'];
                                }            
                            }
                            
                            if($quienApruebaDecode[0] == 'usuarios'){ 
                                $longitud = count($quienApruebaDecode);
                                
                                for($i=1; $i<$longitud; $i++){
                                    //saco el valor de cada elemento
                                    $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienApruebaDecode[$i]'");
                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                    
                                    'Usuario: '.$enviarDocumentoControlCambiosAprueba=$nombres['cedula'];
                                } 
                            }
                        /// END

                           
                            $nombreAprobo=$enviarDocumentoControlCambiosAprueba; '<br>';
                            
                        }
                        if($validandoAlmacenamientoArrya == 'retiradosUsuarios'){ 
                            $nombreElaboro=utf8_decode($_POST['select_encargadoEE']);
                        }
                        if($validandoAlmacenamientoArryaB == 'retiradosUsuariosB'){
                            $nombreReviso=utf8_decode($_POST['select_encargadoRR']);
                        }
                        if($validandoAlmacenamientoArryaC == 'retiradosUsuariosC'){
                            $nombreAprobo=utf8_decode($_POST['select_encargadoAA']);
                        }
                         $nombreElaboro;
                         '<br>';
                         $nombreReviso;
                         '<br>';
                         $nombreAprobo;
                        
                        
                        // validamos los comentarios
                        if($controlCambios != NULL){
                         $controlCambios=$controlCambios;   
                        }else{
                            $controlCambios='N/A';
                        }
                        
                        if($comentarioRevision != NULL){
                         $comentarioRevision=$comentarioRevision;   
                        }else{
                            $comentarioRevision='N/A';
                        }
                        
                        if($comentarioAprobo != NULL){
                         $comentarioAprobo=$comentarioAprobo;   
                        }else{
                            $comentarioAprobo='N/A';
                        }
                        
                        
                        // end
                        
                        
                        
                            if($fechaElaboracion != NULL){ //$controlCambios
                                $mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuarioB, fecha, rol) VALUES('$idSolicitud','$controlCambios','$nombreElaboro','$fechaElaboracion','Elaborador(a)')")or die(mysqli_error($mysqli));  
                            }
                            if($fechaRevision != NULL){ //$comentarioRevision
                            $mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuarioB, fecha, rol) VALUES('$idSolicitud','$comentarioRevision','$nombreReviso','$fechaRevision','Revisor(a)')")or die(mysqli_error($mysqli));  
                            }
                            if($fechaAprobacion != NULL){ //$comentarioAprobo
                            $mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuarioB, fecha, rol) VALUES('$idSolicitud','$comentarioAprobo','$nombreAprobo','$fechaAprobacion','Aprobador(a)')")or die(mysqli_error($mysqli));  
                            }
                    
                    
                    
                    
                    /*
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
                                                obsoleto,
                                                fechaAprobado,
                                                pre,
                                                aprobado_aprueba
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
                                                '0',
                                                '1',
                                                '$fechaAprobacion',
                                                'si',
                                                '1'
                                                )")or die(mysqli_error($mysqli));
                                  */
                                                
                                                            /* campos comentados
                                                            `codificacion`, '$codificacion',
                                                            
                                                            `consecutivo`, 
                                                            `version`, 
                                                            
                                                                                            
                                                            
                                                             
                                                            
                                                             
                                                            */                  
                                                                $mysqli->query("INSERT INTO documento(
                                                                                            
                                                                                            `tipoCodificacion`,
                                                                                            `versionTemporal`,
                                                                                            `consecutivoTemporal`,
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
                                                                                            obsoleto,
                                                                                            fechaAprobado,
                                                                                            pre,
                                                                                            aprobado_aprueba
                                                                                        )
                                                                                        VALUES(
                                                                                            
                                                                                            '$radCodificacion',
                                                                                            '$version',
                                                                                            '$consecutivo',
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
                                                                                            '0',
                                                                                            '1',
                                                                                            '$fechaAprobacion',
                                                                                            'si',
                                                                                            '1'
                                                                                            )")or die(mysqli_error($mysqli));
                                                                       
                                           
                    }
                    
                    //// este espacio se crea para el control de cambios el procedimiento del flujo de aprobación del documento
                    $queryIdUsuarioElabora = $mysqli->query("SELECT MAX(id) AS id FROM `documento` WHERE usuarioElabora = '$usuario' ORDER BY id DESC");
                    $datosUsuarioElabora = $queryIdUsuarioElabora->fetch_array(MYSQLI_ASSOC);
                    '<br>ID documento: '.$idDocumentoElaborado=$datosUsuarioElabora['id'];
                    
                    
                    
                    $informacion=utf8_decode($_POST['editor1']);
                    
                    $consultamosExistenciaComentario=$mysqli->query("SELECT * FROM controlCambiosFlujo WHERE idDocumento='$idDocumentoElaborado' ");
                    $extrarConsultaExistenciaComentario=$consultamosExistenciaComentario->fetch_array(MYSQLI_ASSOC);
                    if($extrarConsultaExistenciaComentario['idDocumento'] != NULL){
                        $mysqli->query("UPDATE controlCambiosFlujo SET informacion='$informacion' fecha='$fecha', comentarioAnterior='$informacion' WHERE idDocumento='$idDocumentoElaborado' ")or die(mysqli_error($mysqli));
                    }else{
                        $mysqli->query("INSERT INTO controlCambiosFlujo (idDocumento,informacion,fecha,comentarioAnterior)VALUES('$idDocumentoElaborado','$informacion','$fecha','$informacion')")or die(mysqli_error($mysqli));
                    }
                    //// end
                    
                    ?>
                        <script> 
                            window.onload=function(){
                                document.forms["miformulario"].submit();
                            }
                        </script>
                        <form name="miformulario" action="../../crearDocumentoMasivoObsoleto" method="POST" onsubmit="procesar(this.action);" >
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
                                                                     alert("Primera");
                                                                     document.forms["miformulario"].submit();
                                                                 }
                                                            </script>
                                                             
                                                            <form name="miformulario" action="../../crearDocumentoMasivoObsoleto" method="POST" onsubmit="procesar(this.action);" >
                                                            </form> 
                                                        <?php
                                                       
                                                    }else{
                                                        
                                                        
                                                        ?>
                                                            <script> 
                                                                 window.onload=function(){
                                                               alert("Segunda");
                                                                     document.forms["miformulario"].submit();
                                                                 }
                                                            </script>
                                                             
                                                            <form name="miformulario" aaction="../../crearDocumentoMasivoObsoleto" method="POST" onsubmit="procesar(this.action);" >
                                                                <input type="hidden" name="validacionExiste" value="1">
                                                            </form> 
                                                        <?php
                                                    }
                                                }
                                                
                                            }else{
                                               
                                                        $ruta = 'sin ruta'; //utf8_decode('archivos/solicitudes/'.$archivoNombre);
                                                     
                    
                                                                $mysqli->query("INSERT INTO solicitudDocumentos (nombreEncargado,estado, quienSolicita, tipoSolicitud, tipoDocumento, encargadoAprobar, nombreDocumento, nombreDocumento2, proceso, solicitud,fecha,fechaCierre,documento,plataformaH,docVigente,quienAprueba)
                                                                        VALUES ('$encargadoTexto','Ejecutado','$usuario','1','$tipoDocumento','$encargado','$documento','$documento','$proceso','$documento','$fecha','$fecha','$ruta','1','1','$usuario')")or die(mysqli_error($mysqli));

                                                                
                                                                $queryId = $mysqli->query("SELECT MAX(id) AS id FROM `solicitudDocumentos` WHERE quienSolicita = '$usuario' ORDER BY id DESC");
                                                                $datos = $queryId->fetch_array(MYSQLI_ASSOC);
                                                                '<br>ID documento: '.$idSolicitud=$datos['id'];
                    
                    
                                                              
                                                                    //VERSION Y CONSECUTIVO 
                                                                    //VERSION Y CONSECUTIVO  
                                                                    $queryProcesos = $mysqli->query("SELECT nombre,prefijo from procesos WHERE id = '".$proceso."' ");
                                                                    $datosProceso = $queryProcesos->fetch_array(MYSQLI_ASSOC);
                                                                    //$nomProceso = $datosProceso['nombre'];
                                                                    $prefijoProceso = $datosProceso['prefijo'];
                                                                    
                                                                
                                                                    //TIPO DE DOCUMENTO 
                                                                    $queryDocumentos = $mysqli->query("SELECT nombre, prefijo from tipoDocumento WHERE id = '".$tipoDocumento."' ");
                                                                    $datosDocumento = $queryDocumentos->fetch_array(MYSQLI_ASSOC);
                                                                    //$tipoDocumento = $datosDocumento['nombre'];
                                                                    $prefijoTipo = $datosDocumento['prefijo']; 
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
                                                                $controlCambios=utf8_decode($_POST['controlCambios']);
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
                                                                /*
                                                                if($validandoAlmacenamientoArrya == 'activosUsuarios'){ //echo 'No';
                                                                $quienElaboraDecode=json_decode($quienElabora);
                                                                if($quienElaboraDecode[0] == 'cargos'){ 
                                                                    $longitud = count($quienElaboraDecode);
                                                                    
                                                                    for($i=1; $i<$longitud; $i++){
                                                                        //saco el valor de cada elemento
                                                                        $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienElaboraDecode[$i]'");
                                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                        
                                                                         'Cargo: '.$enviarDocumentoControlCambiosElaborado=$nombres['nombreCargos'];
                                                                    }            
                                                                }
                                                                
                                                                if($quienElaboraDecode[0] == 'usuarios'){ 
                                                                    $longitud = count($quienElaboraDecode);
                                                                    
                                                                    for($i=1; $i<$longitud; $i++){
                                                                        //saco el valor de cada elemento
                                                                        $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienElaboraDecode[$i]'");
                                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                        
                                                                        'Usuario: '.$enviarDocumentoControlCambiosElaborado=$nombres['cedula'];
                                                                    } 
                                                                }
                                                                 $nombreElaboro=$enviarDocumentoControlCambiosElaborado; '<br>';
                                                                
                                                            }
                        
                                                                if($validandoAlmacenamientoArryaB == 'activosUsuariosB'){ //echo 'No';
                                                                    $quienRevisadoDecode=json_decode($quienRevisa);
                                                                    if($quienRevisadoDecode[0] == 'cargos'){ 
                                                                        $longitud = count($quienRevisadoDecode);
                                                                        
                                                                        for($i=1; $i<$longitud; $i++){
                                                                            //saco el valor de cada elemento
                                                                            $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienRevisadoDecode[$i]'");
                                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                            
                                                                            'Cargo: '.$enviarDocumentoControlCambiosRevisado=$nombres['nombreCargos'];
                                                                        }            
                                                                    }
                                                                    
                                                                    if($quienRevisadoDecode[0] == 'usuarios'){ 
                                                                        $longitud = count($quienRevisadoDecode);
                                                                        
                                                                        for($i=1; $i<$longitud; $i++){
                                                                            //saco el valor de cada elemento
                                                                            $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienRevisadoDecode[$i]'");
                                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                            
                                                                            'Usuario: '.$enviarDocumentoControlCambiosRevisado=$nombres['cedula'];
                                                                        } 
                                                                    }
                                                                    $nombreReviso=$enviarDocumentoControlCambiosRevisado; '<br>';
                                                                }
                                                                
                                                                if($validandoAlmacenamientoArryaC == 'activosUsuariosC'){ 
                                                                    $quienApruebaDecode=json_decode($quienAprueba);
                                                                    if($quienApruebaDecode[0] == 'cargos'){ 
                                                                        $longitud = count($quienApruebaDecode);
                                                                        
                                                                        for($i=1; $i<$longitud; $i++){
                                                                            //saco el valor de cada elemento
                                                                            $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienApruebaDecode[$i]'");
                                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                            
                                                                            'Cargo: '.$enviarDocumentoControlCambiosAprueba=$nombres['nombreCargos'];
                                                                        }            
                                                                    }
                                                                    
                                                                    if($quienApruebaDecode[0] == 'usuarios'){ 
                                                                        $longitud = count($quienApruebaDecode);
                                                                        
                                                                        for($i=1; $i<$longitud; $i++){
                                                                            //saco el valor de cada elemento
                                                                            $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienApruebaDecode[$i]'");
                                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                            
                                                                            'Usuario: '.$enviarDocumentoControlCambiosAprueba=$nombres['cedula'];
                                                                        } 
                                                                    }
                                                                /// END
                                        
                                                                   
                                                                    $nombreAprobo=$enviarDocumentoControlCambiosAprueba; '<br>';
                                                                    
                                                                }
                                                                */
                                                                
                                                                
                                                                if($validandoAlmacenamientoArrya == 'activosUsuarios'){ //echo 'No';
                                                                    $quienElaboraDecode=json_decode($quienElabora);
                                                                    if($quienElaboraDecode[0] == 'cargos'){ 
                                                                        $longitud = count($quienElaboraDecode);
                                                                        
                                                                        for($i=1; $i<$longitud; $i++){
                                                                            //saco el valor de cada elemento
                                                                            $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienElaboraDecode[$i]'");
                                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                            
                                                                            'Cargo: '.$enviarDocumentoControlCambiosElaborado=$nombres['nombreCargos'];
                                                                            'Cargo: '.$enviarNombreUsuarioElaborado=$nombres['nombreCargos'];
                                                                        }            
                                                                    }
                            
                                                                    if($quienElaboraDecode[0] == 'usuarios'){ 
                                                                        $longitud = count($quienElaboraDecode);
                                                                        
                                                                        for($i=1; $i<$longitud; $i++){
                                                                            //saco el valor de cada elemento
                                                                            $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienElaboraDecode[$i]'");
                                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                            
                                                                            'Usuario: '.$enviarDocumentoControlCambiosElaborado=$nombres['cedula'];
                                                                            'Usuario: '.$enviarNombreUsuarioElaborado=$nombres['nombres'].' '.$nombres['apellidos'];
                                                                        } 
                                                                    }
                                                                     $nombreElaboro=$enviarDocumentoControlCambiosElaborado; '<br>';
                                                                     $nombreElaboroGuardar=$enviarNombreUsuarioElaborado;
                                                                    
                                                                }
                        
                                                                if($validandoAlmacenamientoArryaB == 'activosUsuariosB'){ //echo 'No';
                                                                    $quienRevisadoDecode=json_decode($quienRevisa);
                                                                    if($quienRevisadoDecode[0] == 'cargos'){ 
                                                                        $longitud = count($quienRevisadoDecode);
                                                                        
                                                                        for($i=1; $i<$longitud; $i++){
                                                                            //saco el valor de cada elemento
                                                                            $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienRevisadoDecode[$i]'");
                                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                            
                                                                            'Cargo: '.$enviarDocumentoControlCambiosRevisado=$nombres['nombreCargos'];
                                                                            'Cargo: '.$enviarRevisadoGuardar=$nombres['nombreCargos'];
                                                                        }            
                                                                    }
                                                                    
                                                                    if($quienRevisadoDecode[0] == 'usuarios'){ 
                                                                        $longitud = count($quienRevisadoDecode);
                                                                        
                                                                        for($i=1; $i<$longitud; $i++){
                                                                            //saco el valor de cada elemento
                                                                            $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienRevisadoDecode[$i]'");
                                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                            
                                                                            'Usuario: '.$enviarDocumentoControlCambiosRevisado=$nombres['cedula'];
                                                                            'Usuario: '.$enviarRevisadoGuardar=$nombres['nombres'].' '.$nombres['apellidos'];
                                                                        } 
                                                                    }
                                                                    $nombreReviso=$enviarDocumentoControlCambiosRevisado; '<br>';
                                                                    $revisorNombreGuardadoENviar=$enviarRevisadoGuardar;
                                                                }
                                                                
                                                                if($validandoAlmacenamientoArryaC == 'activosUsuariosC'){ 
                                                                    $quienApruebaDecode=json_decode($quienAprueba);
                                                                    if($quienApruebaDecode[0] == 'cargos'){ 
                                                                        $longitud = count($quienApruebaDecode);
                                                                        
                                                                        for($i=1; $i<$longitud; $i++){
                                                                            //saco el valor de cada elemento
                                                                            $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienApruebaDecode[$i]'");
                                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                            
                                                                            'Cargo: '.$enviarDocumentoControlCambiosAprueba=$nombres['nombreCargos'];
                                                                            'Cargo: '.$nombreAprobadorEnviar=$enviarDocumentoControlCambiosAprueba=$nombres['nombreCargos'];
                                                                        }            
                                                                    }
                                                                    
                                                                    if($quienApruebaDecode[0] == 'usuarios'){ 
                                                                        $longitud = count($quienApruebaDecode);
                                                                        
                                                                        for($i=1; $i<$longitud; $i++){
                                                                            //saco el valor de cada elemento
                                                                            $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienApruebaDecode[$i]'");
                                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                            
                                                                            'Usuario: '.$enviarDocumentoControlCambiosAprueba=$nombres['cedula'];
                                                                            'Usuario: '.$nombreAprobadorEnviar=$nombres['nombres'].' '.$nombres['apellidos'];
                                                                        } 
                                                                    }
                                                                /// END
                                        
                                                                   
                                                                    $nombreAprobo=$enviarDocumentoControlCambiosAprueba; '<br>';
                                                                    $aprobadorNombreEnviar=$nombreAprobadorEnviar;
                                                                }
                                                                
                                                                
                                                                
                                                                if($validandoAlmacenamientoArrya == 'retiradosUsuarios'){ 
                                                                    $nombreElaboro=utf8_decode($_POST['select_encargadoEE']);
                                                                }
                                                                if($validandoAlmacenamientoArryaB == 'retiradosUsuariosB'){
                                                                    $nombreReviso=utf8_decode($_POST['select_encargadoRR']);
                                                                }
                                                                if($validandoAlmacenamientoArryaC == 'retiradosUsuariosC'){
                                                                    $nombreAprobo=utf8_decode($_POST['select_encargadoAA']);
                                                                }
                        
                         // validamos los comentarios
                        if($controlCambios != NULL){
                         $controlCambios=$controlCambios;   
                        }else{
                            $controlCambios='N/A';
                        }
                        
                        if($comentarioRevision != NULL){
                         $comentarioRevision=$comentarioRevision;   
                        }else{
                            $comentarioRevision='N/A';
                        }
                        
                        if($comentarioAprobo != NULL){
                         $comentarioAprobo=$comentarioAprobo;   
                        }else{
                            $comentarioAprobo='N/A';
                        }
                        
                        
                        // end
                                                                    
                                                                        
                                                                
                                                                        $fecha = date('Y-m-j'); // h:i:s A

                                                                        $rol = "Encargado(a) solicitud";
                                                                    
                                                                         '1: '.$nombrePDF = $_FILES['archivopdf']['name']; 
                                                                        $rutaPDF =$_FILES['archivopdf']['tmp_name']; 
                                                                         '<br>2: '.$nombreOtro =$_FILES['archivootro']['name'];
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
                                                                         
                                                                             '<br>';
                                                                       
                                                                         if ($nombrePDF != NULL){
                                                                              'PDF dato :'.$nombrePDFf=utf8_decode($fecha.$nombrePDF);
                                                                             
                                                                         }else{
                                                                              'PDF sin dato :'.$nombrePDFf = '';
                                                                         }
                                                                         
                                                                          if ($nombreOtro != NULL){
                                                                              'Otro dato : '.$nombreOtroo=utf8_decode($fecha.$nombreOtro);
                                                                             
                                                                         }else{
                                                                              'Otro sin datos'.$nombreOtroo = '';
                                                                         }
                                                                          
                                                            /* campos comentados
                                                            `codificacion`, '$codificacion',
                                                            
                                                            `consecutivo`, 
                                                            `version`, 
                                                            
                                                                                            
                                                            
                                                             
                                                            
                                                             
                                                            */                  
                                                                $mysqli->query("INSERT INTO documento(
                                                                                            
                                                                                            `tipoCodificacion`,
                                                                                            `versionTemporal`,
                                                                                            `consecutivoTemporal`,
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
                                                                                            obsoleto,
                                                                                            fechaAprobado,
                                                                                            pre,
                                                                                            aprobado_aprueba
                                                                                        )
                                                                                        VALUES(
                                                                                            
                                                                                            '$radCodificacion',
                                                                                            '$version',
                                                                                            '$consecutivo',
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
                                                                                            '0',
                                                                                            '1',
                                                                                            '$fechaAprobacion',
                                                                                            'si',
                                                                                            '1'
                                                                                            )")or die(mysqli_error($mysqli));
                                                                                            
                                                                                            
                                                        //// este espacio se crea para el control de cambios el procedimiento del flujo de aprobación del documento                                            
                                                        $queryIdUsuarioElabora = $mysqli->query("SELECT MAX(id) AS id FROM `documento` WHERE usuarioElabora = '$usuario' ORDER BY id DESC");
                                                        $datosUsuarioElabora = $queryIdUsuarioElabora->fetch_array(MYSQLI_ASSOC);
                                                        '<br>ID documento: '.$idDocumentoElaborado=$datosUsuarioElabora['id'];
                                                        
                                                        
                                                        $informacion=utf8_decode($_POST['editor1']);
                                                        
                                                        $consultamosExistenciaComentario=$mysqli->query("SELECT * FROM controlCambiosFlujo WHERE idDocumento='$idDocumentoElaborado' ");
                                                        $extrarConsultaExistenciaComentario=$consultamosExistenciaComentario->fetch_array(MYSQLI_ASSOC);
                                                        if($extrarConsultaExistenciaComentario['idDocumento'] != NULL){
                                                            $mysqli->query("UPDATE controlCambiosFlujo SET informacion='$informacion', fecha='$fecha', comentarioAnterior='$informacion' WHERE idDocumento='$idDocumentoElaborado' ")or die(mysqli_error($mysqli));
                                                        }else{ 
                                                            $mysqli->query("INSERT INTO controlCambiosFlujo (idDocumento,informacion,fecha,comentarioAnterior)VALUES('$idDocumentoElaborado','$informacion','$fecha','$informacion')")or die(mysqli_error($mysqli));
                                                        }
                                                        //// end
                                                        
                                                        /*if($fechaElaboracion != NULL){ //$controlCambios
                                                            $mysqli->query("INSERT INTO controlCambios (idDocumento,idRespaldo, comentario, idUsuarioB, fecha, rol,tipoSolicitud) VALUES('$idSolicitud','$idDocumentoElaborado','$controlCambios','$nombreElaboro','$fechaElaboracion','Elaborador(a)','1')")or die(mysqli_error($mysqli));  
                                                        }
                                                        if($fechaRevision != NULL){ //$comentarioRevision
                                                            $mysqli->query("INSERT INTO controlCambios (idDocumento,idRespaldo, comentario, idUsuarioB, fecha, rol,tipoSolicitud) VALUES('$idSolicitud','$idDocumentoElaborado','$comentarioRevision','$nombreReviso','$fechaRevision','Revisor(a)','1')")or die(mysqli_error($mysqli));  
                                                        }
                                                        if($fechaAprobacion != NULL){ //$comentarioAprobo
                                                            $mysqli->query("INSERT INTO controlCambios (idDocumento,idRespaldo, comentario, idUsuarioB, fecha, rol,tipoSolicitud) VALUES('$idSolicitud','$idDocumentoElaborado','$comentarioAprobo','$nombreAprobo','$fechaAprobacion','Aprobador(a)','1')")or die(mysqli_error($mysqli));  
                                                        } */
                                                        
                                                        if($fechaElaboracion != NULL){ //$controlCambios
                               
                                                            if($validandoAlmacenamientoArrya == 'activosUsuarios'){ 
                                                            $mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuarioB, fecha, rol,nombre) VALUES('$idSolicitud','$controlCambios','$nombreElaboro','$fechaElaboracion','Elaborador(a)','$nombreElaboroGuardar')")or die(mysqli_error($mysqli));  
                                                            }else{
                                                            $mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuarioB, fecha, rol) VALUES('$idSolicitud','$controlCambios','$nombreElaboro','$fechaElaboracion','Elaborador(a)')")or die(mysqli_error($mysqli));  
                                                            }
                                                        }
                                                        if($fechaRevision != NULL){ //$comentarioRevision
                                                           
                                                            if($validandoAlmacenamientoArryaB == 'activosUsuariosB'){
                                                            $mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuarioB, fecha, rol,nombre) VALUES('$idSolicitud','$comentarioRevision','$nombreReviso','$fechaRevision','Revisor(a)','$revisorNombreGuardadoENviar')")or die(mysqli_error($mysqli));  
                                                            }else{
                                                            $mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuarioB, fecha, rol) VALUES('$idSolicitud','$comentarioRevision','$nombreReviso','$fechaRevision','Revisor(a)')")or die(mysqli_error($mysqli));  
                                                            }
                                                        }
                                                        if($fechaAprobacion != NULL){ //$comentarioAprobo
                                                           
                                                            if($validandoAlmacenamientoArryaC == 'activosUsuariosC'){ 
                                                            $mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuarioB, fecha, rol,nombre) VALUES('$idSolicitud','$comentarioAprobo','$nombreAprobo','$fechaAprobacion','Aprobador(a)','$aprobadorNombreEnviar')")or die(mysqli_error($mysqli));  
                                                            }else{
                                                            $mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuarioB, fecha, rol) VALUES('$idSolicitud','$comentarioAprobo','$nombreAprobo','$fechaAprobacion','Aprobador(a)')")or die(mysqli_error($mysqli));  
                                                            }
                                                        }
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        ///// validamos los documentos para verificar que estén en orden, en caso contrario mandamos la alerta
                                                        $preguntadoValidacion=$mysqli->query("SELECT * FROM documento WHERE  id='$idDocumentoElaborado' ");
                                                		$extraerPreguntaValidacion=$preguntadoValidacion->fetch_array(MYSQLI_ASSOC);
                                                		     ' - '.$documentoExtraidoPdf=utf8_encode($extraerPreguntaValidacion['nombrePDF']);
                                                		    '<br> - '.$documentoExtraidoOtro=utf8_encode($extraerPreguntaValidacion['nombreOtro']);
                                                		    
                                                		  '<br>';
                                                		  '<br>';
        		                                        $carpeta="../../archivos/documentos/";
                                                        $ruta="/".$carpeta."/";
                                                        $directorio=opendir($carpeta);
                                                        //recoger los  datos
                                                        $datos=array();
                                                        $conteoArchivosB=0;
                                                        $conteoArchivosB2=0;
                                                        while ($archivo = readdir($directorio)) { 
                                                          if(($archivo != '.')&&($archivo != '..')){
                                                             
                                                            if($documentoExtraidoPdf == $datos[]=$archivo){
                                                                $conteoArchivosB++;
                                                                 $datos[]=$archivo;  '<br>';
                                                            }
                                                            if($documentoExtraidoOtro == $datos[]=$archivo){
                                                                $conteoArchivosB2++;
                                                                 $datos[]=$archivo;  '<br>';
                                                            }
                                                             
                                                             
                                                          } 
                                                        }
                                                        closedir($directorio);
                                                            
                                                        if($conteoArchivosB > 0 && $conteoArchivosB2 > 0){
                                                           $documentoHabilitado2='1'; 
                                                        }else{
                                                           $documentoHabilitado2='no coincide';
                                                        }
                                                         '<br>B: '.$documentoHabilitado2;
                                                        ///// END
                                                        
                                                      //////////////////// agregams el código que recupera la información del documento para recuperar datos eliminados
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
                
                $traerroles=$mysqli->query("SELECT * FROM documento WHERE id='$idDocumentoElaborado' ");
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
                
                
                $queryDocumentos = $mysqli->query("SELECT nombre, prefijo from tipoDocumento WHERE id = '".$tipoDocumento."' ");
                $datosDocumento = $queryDocumentos->fetch_array(MYSQLI_ASSOC);
                $enviarNombreTipoDocumento = $datosDocumento['nombre'];
                
                
                $mysqli->query("UPDATE documento SET nombreTipoD='$enviarNombreTipoDocumento', normaNombre='$enviarNorma', externoNombre='$enviarDE', definicionNombre='$enviarDefinicion', disposicionNombre='$enviarEncargadoDisposicion', elaboraNombre='$enviarQuienElabora', revisaNombre='$enviarQuienRevisa', apruebaNombre='$enviarQuienAprueba' WHERE id='$idDocumentoElaborado' ");
            ////////////////////////////////////////////////////////// END    
                                                        
                                                        
                                                        
                                                        if($documentoHabilitado2 == 1){
                                                        //echo '<br>Registro';
                                                        ?>
                                                            <script> 
                                                                 window.onload=function(){
                                                                   document.forms["miformulario"].submit();
                                                                 }
                                                            </script>
                                                             
                                                            <form name="miformulario" action="../../crearDocumentoMasivoObsoleto" method="POST" onsubmit="procesar(this.action);" >
                                                                <!--<input type="submit" value="enviar registro">-->
                                                            </form> 
                                                        <?php
                                                        }else{
                                                            //echo '<br>Alerta';
                                                        ?>
                                                            <script> 
                                                                 window.onload=function(){
                                                                   document.forms["miformulario"].submit();
                                                                 }
                                                            </script>
                                                             
                                                            <form name="miformulario" action="../../crearDocumentoMasivoObsoleto" method="POST" onsubmit="procesar(this.action);" >
                                                                <input name="alertaDocumento" value="1" type="hidden">
                                                                <input name="editarDocumentoMasivo" value="1" type="hidden">
                                                                <input name="enviarIdDocumento" value="<?php echo $extraerPreguntaValidacion['id'];?>" type="hidden">
                                                                <input name="enviarIdDocumentoControl" value="<?php echo $extraerPreguntaValidacion['id_solicitud'];?>" type="hidden">
                                                                <!-- <input type="submit" value="enviar alerta"> -->
                                                            </form> 
                                                        <?php    
                                                        }
                                                    
                                                
                                            }
                }

               
            //// END


        


        }
    }
}

if(isset($_POST['actualiza'])){
    
     /// volvemos el texto totalmente en minuscula
    $validandoDocumentoCaracteresPdf=mb_strtolower($_FILES['archivopdf']['name']);
    $validandoDocumentoCaracteresOtro=mb_strtolower($_FILES['archivootro']['name']);
    
    $activarAlerta=TRUE;
    $activarAlertaOtro=TRUE;
    
    $descripcion_carecteres=["'"];
    for($bc=0; $bc<count($descripcion_carecteres); $bc++){
        $descripcion_carecteres[$bc]; 
        $cadena_carecteres_descripcion = $descripcion_carecteres[$bc];
        ' - '.$coincidencia_caracteres= strpos($validandoDocumentoCaracteresPdf, $cadena_carecteres_descripcion);
        if($coincidencia_caracteres != NULL){
            $activarAlerta=FALSE;
        }    
    }
    
    $descripcion_carecteres_otro=["'"];
    for($bc=0; $bc<count($descripcion_carecteres_otro); $bc++){
        $descripcion_carecteres_otro[$bc]; 
        $cadena_carecteres_descripcion_otro = $descripcion_carecteres_otro[$bc];
        ' - '.$coincidencia_caracteres_otro= strpos($validandoDocumentoCaracteresOtro, $cadena_carecteres_descripcion_otro);
        if($coincidencia_caracteres_otro != NULL){
            $activarAlertaOtro=FALSE;
        }    
    }
    
    
    
     'Actualizar';
     '<br>';
     $idDocumento=$_POST['idDocumento'];
     
     
     if($activarAlerta == FALSE || $activarAlertaOtro == FALSE){ 
                    ///// validamos los documentos para verificar que estén en orden, en caso contrario mandamos la alerta
                                                        $preguntadoValidacion=$mysqli->query("SELECT * FROM documento WHERE  id='$idDocumento' ");
                                                		$extraerPreguntaValidacion=$preguntadoValidacion->fetch_array(MYSQLI_ASSOC);
                  ?>
                                                            <script> 
                                                                 window.onload=function(){
                                                                   document.forms["miformularioAlerta"].submit();
                                                                 }
                                                            </script>
                                                             
                                                            <form name="miformularioAlerta" action="../../crearDocumentoMasivoObsoleto" method="POST" onsubmit="procesar(this.action);" >
                                                                <input name="alertaDocumento" value="1" type="hidden">
                                                                <input name="editarDocumentoMasivo" value="1" type="hidden">
                                                                <input name="enviarIdDocumento" value="<?php echo $extraerPreguntaValidacion['id'];?>" type="hidden">
                                                                <input name="enviarIdDocumentoControl" value="<?php echo $extraerPreguntaValidacion['id_solicitud'];?>" type="hidden">
                                                                <!-- <input type="submit" value="enviar alerta"> -->
                                                            </form> 
                                                        <?php
     
    }else{
     
     
     
     
     
     '<br>';
     '<br>';

     '<b>Nombre Documento:</b>'.$documento=utf8_decode($_POST['nombreDocumento']);
     '<br>';


     '<b>Norma:</b>';
     $norma = json_encode($_POST['norma']);
     '<br>';

    $proceso=$_POST['proceso'];     
    

     '<b>Proceso:</b>'.$proceso;
     '<br>';
     '<b>Tipo Documento:</b>'.$tipoDocumento=$_POST['tipoDoc'];
     '<br>';
    

    // validamos que el encargado entre números o letras


 'Variable encargado: '.$encargadoValidando=$_POST['validandoEncargados'];

    if ($_POST['validandoEncargados'] == '1'){
          '<b>Encargado ID :</b>'.$encargado =$_POST['encargado'];
                $encargadoTexto='';
    }
    //else{
    //echo      '<b>Encargado texto :</b>'.$encargado ='0';
    //}

    if($_POST['validandoEncargados'] == '2'){
          '<br>Nombre encargado eliminado: '.$encargadoTexto=$_POST['encargadoT'];
        $encargado ='0';
    }
   
    // END
    

    //$solicitud = utf8_decode($_POST['solicitud']);
     '<br>';

     '<b>Fecha:</b>'.$fecha = date("Y:m:j");
     '<br>';
     '<b>Archivo:</b>'.$archivoNombre = $_FILES['archivo']['name'];
    $guardado = $_FILES['archivo']['tmp_name'];
     '<br>';
     '<br>Método de creación: '.$metodo=$_POST['rad_metodo'];
     '<br>';
     'Ubicación: '.$ubicacion=$_POST['ubicacion'];
     '<br>';
     '<b>Usuario:</b>'.$usuario = $_POST['usuario'];
     '<br>';
     'A: '.$validandoAlmacenamientoArrya=$_POST['validandoUsuarios'];
            '<br>';
            'B: '.$validandoAlmacenamientoArryaB=$_POST['validandoUsuariosB'];
            '<br>';
            'C: '.$validandoAlmacenamientoArryaC=$_POST['validandoUsuariosC'];
            
               //////////////// flujo usuario ELABORADOR
            $radioElabora = $_POST['radiobtnE'];
            '<br>';
            $elabora=serialize($_POST['select_encargadoE']);
            $elaboraN = unserialize($elabora); // para la notificación creación
            if($validandoAlmacenamientoArrya == 'activosUsuarios' ){
                array_unshift($elaboraN,$radioElabora);
                '<b>Quien Elabora:</b>'.$quienElabora=json_encode($elaboraN);
                '<br>';
            }else{
                '<b>Quien Elabora:</b>'.$quienElabora=utf8_decode($_POST['select_encargadoEE']);
            }
            //// END
            
            
            ////////////////// flujo usuario REVISOR
            $radioRevisa = $_POST['radiobtnR'];
            '<br>';
            $revisa=serialize($_POST['select_encargadoR']);
            $revisaN = unserialize($revisa); // para la notificación creación 
            if($validandoAlmacenamientoArryaB == 'activosUsuariosB' ){
                array_unshift($revisaN,$radioRevisa);
                '<b>Quien Revisaa:</b>'.$quienRevisa=json_encode($revisaN);
            }else{
                '<b>Quien Revisa2:</b>'.$quienRevisa=utf8_decode($_POST['select_encargadoRR']);
            }
            '<br>';
            ////// END
            
            
            //////////////// flujo usuario APROBADOR
            $radioAprueba = $_POST['radiobtnA'];
            '<br>';
            $aprueba=serialize($_POST['select_encargadoA']);
            $apruebaN = unserialize($aprueba); // para la notificación creación
            if($validandoAlmacenamientoArryaC == 'activosUsuariosC' ){
                array_unshift($apruebaN,$radioAprueba);
               '<b>Quien Aprueba:</b>'.$quienAprueba=json_encode($apruebaN);
            }else{
                '<b>Quien Aprueba:</b>'.$quienAprueba=utf8_decode($_POST['select_encargadoAA']);
            }
            
    /*$validandoAlmacenamientoArrya=$_POST['validandoUsuarios'];
     '<br>';

    $radioElabora = $_POST['radiobtnE'];
     '<br>';
    $elabora=serialize($_POST['select_encargadoE']);
    $elaboraN = unserialize($elabora); // para la notificación creación
    if($validandoAlmacenamientoArrya == 'activosUsuarios' ){
        $elaboraNEnviarContolCambios=json_encode($elaboraN);
        array_unshift($elaboraN,$radioElabora);
         '<b>Quien Elabora:</b>'.$quienElabora=json_encode($elaboraN);
         
         '<br>';
    }else{
         '<b>Quien Elabora:</b>'.$quienElabora=$_POST['select_encargadoEE'];
    }
    $radioRevisa = $_POST['radiobtnR'];
     '<br>';
    $revisa=serialize($_POST['select_encargadoR']);
    $revisaN = unserialize($revisa); // para la notificación creación
    if($validandoAlmacenamientoArrya == 'activosUsuarios' ){
        array_unshift($revisaN,$radioRevisa);
         '<b>Quien Revisa:</b>'.$quienRevisa=json_encode($revisaN);
    }else{
         '<b>Quien Revisa:</b>'.$quienRevisa=$_POST['select_encargadoRR'];
    }
     '<br>';

    $radioAprueba = $_POST['radiobtnA'];
     '<br>';
    $aprueba=serialize($_POST['select_encargadoA']);
    $apruebaN = unserialize($aprueba); // para la notificación creación
     $validandoAlmacenamientoArrya;
    if($validandoAlmacenamientoArrya == 'activosUsuarios' ){
        array_unshift($apruebaN,$radioAprueba);
         '<b>Quien Aprueba:</b>'.$quienAprueba=json_encode($apruebaN);
    }else{
         '<b>Quien Aprueba:</b>'.$quienAprueba=$_POST['select_encargadoAA'];
    }
   */
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
     '<br>archivo de gestión: '.$archivo_gestion=utf8_decode($_POST['archivo_gestion']);
     '<br>';
     '<br>archivo de central: '.$archivo_central=utf8_decode($_POST['archivo_central']);
     '<br>';
     '<br>archivo de historico: '.$archivo_historico=utf8_decode($_POST['archivo_historico']);
     '<br>';
     '<br>disposición documental: '.$disposicion_documental=utf8_decode($_POST['diposicion_documental']);
     '<br>';

    $radioResponsable = $_POST['radiobtnD'];
     '<br>';
    $responsable=serialize($_POST['select_encargadoD']);
    $responsableN = unserialize($responsable); // para la notificación creación
    if($_POST['validandoUsuariosR'] == 'activosUsuariosResponsable'){
        array_unshift($responsableN,$radioResponsable);
         '<b>Quien responsable: </b>'.$escargadoDispo=json_encode($responsableN);
    }else{
         '<b>Quien responsable: </b>'.$escargadoDispo=utf8_decode($_POST['select_encargadoDD']);
    }
     '<br>';
    
    $editorHtml = utf8_decode($_POST['editorHtml']);
    

     '<b>Meses de Revision</b>:'.$mesesRevision = intval($_POST['mesesRevision']);

                    //// este espacio se crea para el control de cambios el procedimiento del flujo de aprobación del documento
                    $queryIdUsuarioElabora = $mysqli->query("SELECT MAX(id) AS id FROM `documento` WHERE usuarioElabora = '$usuario' ORDER BY id DESC");
                    $datosUsuarioElabora = $queryIdUsuarioElabora->fetch_array(MYSQLI_ASSOC);
                    '<br>ID documento: '.$idDocumentoElaborado=$datosUsuarioElabora['id'];
                    
                
                    $informacion=utf8_decode($_POST['editor1']);
                    $reservaIdSolicitud=$_POST['reservaIdSolicitud'];
                    
                    $consultamosExistenciaComentario=$mysqli->query("SELECT * FROM controlCambiosFlujo WHERE idDocumento='$idDocumento' ");
                    $extrarConsultaExistenciaComentario=$consultamosExistenciaComentario->fetch_array(MYSQLI_ASSOC);
                    if($extrarConsultaExistenciaComentario['idDocumento'] != NULL){ 
                        $mysqli->query("UPDATE controlCambiosFlujo SET informacion='$informacion', fecha='$fecha', comentarioAnterior='$informacion' WHERE idDocumento='$idDocumento' ")or die(mysqli_error($mysqli));
                    }else{
                        $mysqli->query("INSERT INTO controlCambiosFlujo (idDocumento,informacion,fecha,comentarioAnterior)VALUES('$idDocumento','$informacion','$fecha','$informacion')");
                    }
                    //// end





    //// realiza el proceso de aprobación del documento
   
    if( $_FILES['archivopdf']['name'] == NULL && $_FILES['archivootro']['name'] == NULL){
        //|| $_FILES['archivopdf']['name'] != NULL || $_FILES['archivootro']['name'] != NULL
                    
        $ruta = 'sin datos';
        
        $consultandoDocumento=$mysqli->query("SELECT * FROM documento WHERE id='$idDocumento' ");
        $extraerConsultaDocumento=$consultandoDocumento->fetch_array(MYSQLI_ASSOC);
      
         $mysqli->query("UPDATE solicitudDocumentos SET nombreEncargado='$encargadoTexto',  tipoDocumento='$tipoDocumento', encargadoAprobar='$encargado', 
         nombreDocumento='$documento', nombreDocumento2='$documento', proceso='$proceso', solicitud='$documento' WHERE id='".$extraerConsultaDocumento['id_solicitud']."' ")or die(mysqli_error($mysqli));
      

        $queryId = $mysqli->query("SELECT * FROM `solicitudDocumentos` WHERE id = '".$extraerConsultaDocumento['id_solicitud']."' ORDER BY id DESC");
        $datos = $queryId->fetch_array(MYSQLI_ASSOC);
         '<br>ID documento: '.$idSolicitud=$datos['id'];
        
        if($datos != NULL){
            //VERSION Y CONSECUTIVO     
            //VERSION Y CONSECUTIVO  
                        $queryProcesos = $mysqli->query("SELECT nombre,prefijo from procesos WHERE id = '".$proceso."' ");
                        $datosProceso = $queryProcesos->fetch_array(MYSQLI_ASSOC);
                        //$nomProceso = $datosProceso['nombre'];
                        $prefijoProceso = $datosProceso['prefijo'];
                        
                    
                        //TIPO DE DOCUMENTO 
                        $queryDocumentos = $mysqli->query("SELECT nombre, prefijo from tipoDocumento WHERE id = '".$tipoDocumento."' ");
                        $datosDocumento = $queryDocumentos->fetch_array(MYSQLI_ASSOC);
                        //$tipoDocumento = $datosDocumento['nombre'];
                        $prefijoTipo = $datosDocumento['prefijo']; 
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
            'control de cambios : '.$controlCambios=utf8_decode($_POST['controlCambios']);
            //// end
            '<br>';
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
            '<br><b>';
            $validandoAlmacenamientoArrya;
            '</b><br>';
            /*
            if($validandoAlmacenamientoArrya == 'activosUsuarios'){
                
                /// validar y traer el nombre del id para sacar la CC y enviar al control de cambios
                
                $quienElaboraDecode=json_decode($quienElabora);
                    if($quienElaboraDecode[0] == 'cargos'){ 
                        $longitud = count($quienElaboraDecode);
                        
                        for($i=1; $i<$longitud; $i++){
                            //saco el valor de cada elemento
                            $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienElaboraDecode[$i]'");
                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                            
                             'Cargo: '.$enviarDocumentoControlCambiosElaborado=$nombres['nombreCargos'];
                        }            
                    }
                    
                    if($quienElaboraDecode[0] == 'usuarios'){ 
                        $longitud = count($quienElaboraDecode);
                        
                        for($i=1; $i<$longitud; $i++){
                            //saco el valor de cada elemento
                            $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienElaboraDecode[$i]'");
                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                            
                            'Usuario: '.$enviarDocumentoControlCambiosElaborado=$nombres['cedula'];
                        } 
                    }
                    
                    $quiennRevisadoDecode=json_decode($quienRevisa);
                    if($quiennRevisadoDecode[0] == 'cargos'){ 
                        $longitud = count($quiennRevisadoDecode);
                        
                        for($i=1; $i<$longitud; $i++){
                            //saco el valor de cada elemento
                            $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quiennRevisadoDecode[$i]'");
                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                            
                             'Cargo: '.$enviarDocumentoControlCambiosRevisado=$nombres['nombreCargos'];
                        }            
                    }
                    
                    if($quiennRevisadoDecode[0] == 'usuarios'){ 
                        $longitud = count($quiennRevisadoDecode);
                        
                        for($i=1; $i<$longitud; $i++){
                            //saco el valor de cada elemento
                            $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quiennRevisadoDecode[$i]'");
                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                            
                             'Usuario: '.$enviarDocumentoControlCambiosRevisado=$nombres['cedula'];
                        } 
                    }

                    $quienApruebaDecode=json_decode($quienAprueba);
                    if($quienApruebaDecode[0] == 'cargos'){ 
                        $longitud = count($quienApruebaDecode);
                        
                        for($i=1; $i<$longitud; $i++){
                            //saco el valor de cada elemento
                            $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienApruebaDecode[$i]'");
                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                            
                             'Cargo: '.$enviarDocumentoControlCambiosAprueba=$nombres['nombreCargos'];
                        }            
                    }
                    
                    if($quienApruebaDecode[0] == 'usuarios'){ 
                        $longitud = count($quienApruebaDecode);
                        
                        for($i=1; $i<$longitud; $i++){
                            //saco el valor de cada elemento
                            $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienApruebaDecode[$i]'");
                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                            
                             'Usuario: '.$enviarDocumentoControlCambiosAprueba=$nombres['cedula'];
                        } 
                    }
                /// END

                $nombreElaboro=$enviarDocumentoControlCambiosElaborado; '<br>';
                $nombreReviso=$enviarDocumentoControlCambiosRevisado; '<br>';//$_POST['nombreReviso']; 
                $nombreAprobo=$enviarDocumentoControlCambiosAprueba; '<br>';//$_POST['nombreAprobo'];
            }
            if($validandoAlmacenamientoArrya == 'retiradosUsuarios'){
                $nombreElaboro=utf8_decode($quienElabora);//$_POST['nombreElaboro']);
                $nombreReviso=utf8_decode($quienRevisa);//$_POST['nombreReviso']);
                $nombreAprobo=utf8_decode($quienAprueba);//$_POST['nombreAprobo']);
            }
            
            */
                                                            if($validandoAlmacenamientoArrya == 'activosUsuarios'){ //echo 'No';
                                                                $quienElaboraDecode=json_decode($quienElabora);
                                                                if($quienElaboraDecode[0] == 'cargos'){ 
                                                                    $longitud = count($quienElaboraDecode);
                                                                    
                                                                    for($i=1; $i<$longitud; $i++){
                                                                        //saco el valor de cada elemento
                                                                        $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienElaboraDecode[$i]'");
                                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                        
                                                                         'Cargo: '.$enviarDocumentoControlCambiosElaborado=$nombres['nombreCargos'];
                                                                    }            
                                                                }
                                                                
                                                                if($quienElaboraDecode[0] == 'usuarios'){ 
                                                                    $longitud = count($quienElaboraDecode);
                                                                    
                                                                    for($i=1; $i<$longitud; $i++){
                                                                        //saco el valor de cada elemento
                                                                        $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienElaboraDecode[$i]'");
                                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                        
                                                                        'Usuario: '.$enviarDocumentoControlCambiosElaborado=$nombres['cedula'];
                                                                    } 
                                                                }
                                                                 $nombreElaboro=$enviarDocumentoControlCambiosElaborado; '<br>';
                                                                
                                                            }
                        
                                                                if($validandoAlmacenamientoArryaB == 'activosUsuariosB'){ //echo 'No';
                                                                    $quienRevisadoDecode=json_decode($quienRevisa);
                                                                    if($quienRevisadoDecode[0] == 'cargos'){ 
                                                                        $longitud = count($quienRevisadoDecode);
                                                                        
                                                                        for($i=1; $i<$longitud; $i++){
                                                                            //saco el valor de cada elemento
                                                                            $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienRevisadoDecode[$i]'");
                                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                            
                                                                            'Cargo: '.$enviarDocumentoControlCambiosRevisado=$nombres['nombreCargos'];
                                                                        }            
                                                                    }
                                                                    
                                                                    if($quienRevisadoDecode[0] == 'usuarios'){ 
                                                                        $longitud = count($quienRevisadoDecode);
                                                                        
                                                                        for($i=1; $i<$longitud; $i++){
                                                                            //saco el valor de cada elemento
                                                                            $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienRevisadoDecode[$i]'");
                                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                            
                                                                            'Usuario: '.$enviarDocumentoControlCambiosRevisado=$nombres['cedula'];
                                                                        } 
                                                                    }
                                                                    $nombreReviso=$enviarDocumentoControlCambiosRevisado; '<br>';
                                                                }
                                                                
                                                                if($validandoAlmacenamientoArryaC == 'activosUsuariosC'){ 
                                                                    $quienApruebaDecode=json_decode($quienAprueba);
                                                                    if($quienApruebaDecode[0] == 'cargos'){ 
                                                                        $longitud = count($quienApruebaDecode);
                                                                        
                                                                        for($i=1; $i<$longitud; $i++){
                                                                            //saco el valor de cada elemento
                                                                            $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienApruebaDecode[$i]'");
                                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                            
                                                                            'Cargo: '.$enviarDocumentoControlCambiosAprueba=$nombres['nombreCargos'];
                                                                        }            
                                                                    }
                                                                    
                                                                    if($quienApruebaDecode[0] == 'usuarios'){ 
                                                                        $longitud = count($quienApruebaDecode);
                                                                        
                                                                        for($i=1; $i<$longitud; $i++){
                                                                            //saco el valor de cada elemento
                                                                            $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienApruebaDecode[$i]'");
                                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                            
                                                                            'Usuario: '.$enviarDocumentoControlCambiosAprueba=$nombres['cedula'];
                                                                        } 
                                                                    }
                                                                /// END
                                        
                                                                   
                                                                    $nombreAprobo=$enviarDocumentoControlCambiosAprueba; '<br>';
                                                                    
                                                                }
                                                                
                                                                if($validandoAlmacenamientoArrya == 'retiradosUsuarios'){ 
                                                                    $nombreElaboro=utf8_decode($_POST['select_encargadoEE']);
                                                                }
                                                                if($validandoAlmacenamientoArryaB == 'retiradosUsuariosB'){
                                                                    $nombreReviso=utf8_decode($_POST['select_encargadoRR']);
                                                                }
                                                                if($validandoAlmacenamientoArryaC == 'retiradosUsuariosC'){
                                                                    $nombreAprobo=utf8_decode($_POST['select_encargadoAA']);
                                                                }
                if($fechaElaboracion != NULL){ //$controlCambios
                    //$mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuarioB, fecha, rol) VALUES('$idSolicitud','$controlCambios','$nombreElaboro','$fechaElaboracion','Elaborador(a)')")or die(mysqli_error($mysqli));  
                    $mysqli->query("UPDATE controlCambios SET comentario='$controlCambios', fecha='$fechaElaboracion', idUsuarioB='$nombreElaboro' WHERE idDocumento='$idSolicitud' AND rol='Elaborador(a)' ")or die(mysqli_error($mysqli));  
               
                }
                if($fechaRevision != NULL){ //$comentarioRevision
                    //$mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuarioB, fecha, rol) VALUES('$idSolicitud','$comentarioRevision','$nombreReviso','$fechaRevision','Revisor(a)')")or die(mysqli_error($mysqli));  
                    $mysqli->query("UPDATE controlCambios SET comentario='$comentarioRevision', fecha='$fechaRevision', idUsuarioB='$nombreReviso' WHERE idDocumento='$idSolicitud' AND rol='Revisor(a)' ")or die(mysqli_error($mysqli));  
               
                }
                if($fechaAprobacion != NULL){ //$comentarioAprobo
                    //$mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuarioB, fecha, rol) VALUES('$idSolicitud','$comentarioAprobo','$nombreAprobo','$fechaAprobacion','Aprobador(a)')")or die(mysqli_error($mysqli));  
                    $mysqli->query("UPDATE controlCambios SET comentario='$comentarioAprobo', fecha='$fechaAprobacion', idUsuarioB='$nombreAprobo' WHERE idDocumento='$idSolicitud' AND rol='Aprobador(a)' ")or die(mysqli_error($mysqli));  
               
                }
        /*
        `consecutivo`='$consecutivo',
            `version`='$version',
            `codificacion`='$codificacion',
        */
            $mysqli->query("UPDATE documento SET 
            
            `tipoCodificacion`='$radCodificacion',
            `consecutivoTemporal`='$consecutivo',
            `versionTemporal`='$version',
            `nombres`='$documento',
            `proceso`='$proceso',
            `nombreProceso`='$nomProceso',
            `norma`='$norma',
            `tipo_documento`='$tipoDocumento',
            `ubicacion`='$ubicacion',
            `elabora`='$quienElabora',
            `revisa`='$quienRevisa',
            `aprueba`='$quienAprueba',
            `documento_externo`='$documentosExternos',
            `definiciones`='$definiciones',
            `archivo_gestion`='$archivo_gestion',
            `archivo_central`='$archivo_central',
            `archivo_historico`='$archivo_historico',
            `disposicion_documental`='$disposicion_documental',
            `responsable_disposicion`='$escargadoDispo',
            `usuario_aprovacion_reg`='$select_encargadoAR',
            `mesesRevision`='$mesesRevision',
            `id_solicitud`='$idSolicitud'
            WHERE id='$idDocumento' ")or die(mysqli_error($mysqli));
            /*
            ,
            `nombrePDF`='$nombrePDFf',
            `nombreOtro`='$nombreOtroo'
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
                                    
             */                
        }
        
        
        
        
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
                
                $consultandoDocumento=$mysqli->query("SELECT * FROM documento WHERE id='$idDocumento' ");
                $extraerConsultaDocumento=$consultandoDocumento->fetch_array(MYSQLI_ASSOC);
            
                if($archivoNombre != NULL){
                    $mysqli->query("UPDATE solicitudDocumentos SET nombreEncargado='$encargadoTexto',  tipoDocumento='$tipoDocumento', encargadoAprobar='$encargado', 
                    nombreDocumento='$documento', nombreDocumento2='$documento', proceso='$proceso', solicitud='$documento', documento='$ruta' WHERE id='".$extraerConsultaDocumento['id_solicitud']."' ")or die(mysqli_error($mysqli));
                }else{
                    $mysqli->query("UPDATE solicitudDocumentos SET nombreEncargado='$encargadoTexto',  tipoDocumento='$tipoDocumento', encargadoAprobar='$encargado', 
                    nombreDocumento='$documento', nombreDocumento2='$documento', proceso='$proceso', solicitud='$documento' WHERE id='".$extraerConsultaDocumento['id_solicitud']."' ")or die(mysqli_error($mysqli));
                }

                //$mysqli->query("UPDATE solicitudDocumentos SET nombreEncargado='$encargadoTexto',  tipoDocumento='$tipoDocumento', encargadoAprobar='$encargado', 
                //nombreDocumento='$documento', nombreDocumento2='$documento', proceso='$proceso', solicitud='$documento', documento='$ruta' WHERE id='".$extraerConsultaDocumento['id_solicitud']."' ")or die(mysqli_error($mysqli));
            

                $queryId = $mysqli->query("SELECT * FROM `solicitudDocumentos` WHERE id = '".$extraerConsultaDocumento['id_solicitud']."' ORDER BY id DESC");
                $datos = $queryId->fetch_array(MYSQLI_ASSOC);
                '<br>ID documento: '.$idSolicitud=$datos['id'];
                
                if($datos != NULL){
                    //VERSION Y CONSECUTIVO        
                    //VERSION Y CONSECUTIVO  
                        $queryProcesos = $mysqli->query("SELECT nombre,prefijo from procesos WHERE id = '".$proceso."' ");
                        $datosProceso = $queryProcesos->fetch_array(MYSQLI_ASSOC);
                        //$nomProceso = $datosProceso['nombre'];
                        $prefijoProceso = $datosProceso['prefijo'];
                        
                    
                        //TIPO DE DOCUMENTO 
                        $queryDocumentos = $mysqli->query("SELECT nombre, prefijo from tipoDocumento WHERE id = '".$tipoDocumento."' ");
                        $datosDocumento = $queryDocumentos->fetch_array(MYSQLI_ASSOC);
                        //$tipoDocumento = $datosDocumento['nombre'];
                        $prefijoTipo = $datosDocumento['prefijo']; 
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
                    'control de cambios : '.$controlCambios=utf8_decode($_POST['controlCambios']);
                    //// end
                    '<br>';
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
                    '<br><b>';
                    $validandoAlmacenamientoArrya;
                    '</b><br>';
                    
                    /*
                    if($validandoAlmacenamientoArrya == 'activosUsuarios'){
                        
                        /// validar y traer el nombre del id para sacar la CC y enviar al control de cambios
                        
                        $quienElaboraDecode=json_decode($quienElabora);
                            if($quienElaboraDecode[0] == 'cargos'){ 
                                $longitud = count($quienElaboraDecode);
                                
                                for($i=1; $i<$longitud; $i++){
                                    //saco el valor de cada elemento
                                    $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienElaboraDecode[$i]'");
                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                    
                                    'Cargo: '.$enviarDocumentoControlCambiosElaborado=$nombres['nombreCargos'];
                                }            
                            }
                            
                            if($quienElaboraDecode[0] == 'usuarios'){ 
                                $longitud = count($quienElaboraDecode);
                                
                                for($i=1; $i<$longitud; $i++){
                                    //saco el valor de cada elemento
                                    $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienElaboraDecode[$i]'");
                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                    
                                    'Usuario: '.$enviarDocumentoControlCambiosElaborado=$nombres['cedula'];
                                } 
                            }
                            
                            $quiennRevisadoDecode=json_decode($quienRevisa);
                            if($quiennRevisadoDecode[0] == 'cargos'){ 
                                $longitud = count($quiennRevisadoDecode);
                                
                                for($i=1; $i<$longitud; $i++){
                                    //saco el valor de cada elemento
                                    $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quiennRevisadoDecode[$i]'");
                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                    
                                    'Cargo: '.$enviarDocumentoControlCambiosRevisado=$nombres['nombreCargos'];
                                }            
                            }
                            
                            if($quiennRevisadoDecode[0] == 'usuarios'){ 
                                $longitud = count($quiennRevisadoDecode);
                                
                                for($i=1; $i<$longitud; $i++){
                                    //saco el valor de cada elemento
                                    $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quiennRevisadoDecode[$i]'");
                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                    
                                    'Usuario: '.$enviarDocumentoControlCambiosRevisado=$nombres['cedula'];
                                } 
                            }

                            $quienApruebaDecode=json_decode($quienAprueba);
                            if($quienApruebaDecode[0] == 'cargos'){ 
                                $longitud = count($quienApruebaDecode);
                                
                                for($i=1; $i<$longitud; $i++){
                                    //saco el valor de cada elemento
                                    $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienApruebaDecode[$i]'");
                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                    
                                    'Cargo: '.$enviarDocumentoControlCambiosAprueba=$nombres['nombreCargos'];
                                }            
                            }
                            
                            if($quienApruebaDecode[0] == 'usuarios'){ 
                                $longitud = count($quienApruebaDecode);
                                
                                for($i=1; $i<$longitud; $i++){
                                    //saco el valor de cada elemento
                                    $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienApruebaDecode[$i]'");
                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                    
                                    'Usuario: '.$enviarDocumentoControlCambiosAprueba=$nombres['cedula'];
                                } 
                            }
                        /// END

                        $nombreElaboro=$enviarDocumentoControlCambiosElaborado; '<br>';
                        $nombreReviso=$enviarDocumentoControlCambiosRevisado; '<br>';//$_POST['nombreReviso']; 
                        $nombreAprobo=$enviarDocumentoControlCambiosAprueba; '<br>';//$_POST['nombreAprobo'];
                    }
                    if($validandoAlmacenamientoArrya == 'retiradosUsuarios'){
                        $nombreElaboro=utf8_decode($quienElabora);//$_POST['nombreElaboro']);
                        $nombreReviso=utf8_decode($quienRevisa);//$_POST['nombreReviso']);
                        $nombreAprobo=utf8_decode($quienAprueba);//$_POST['nombreAprobo']);
                    }
                    */
                    
                                                            if($validandoAlmacenamientoArrya == 'activosUsuarios'){ //echo 'No';
                                                                $quienElaboraDecode=json_decode($quienElabora);
                                                                if($quienElaboraDecode[0] == 'cargos'){ 
                                                                    $longitud = count($quienElaboraDecode);
                                                                    
                                                                    for($i=1; $i<$longitud; $i++){
                                                                        //saco el valor de cada elemento
                                                                        $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienElaboraDecode[$i]'");
                                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                        
                                                                         'Cargo: '.$enviarDocumentoControlCambiosElaborado=$nombres['nombreCargos'];
                                                                    }            
                                                                }
                                                                
                                                                if($quienElaboraDecode[0] == 'usuarios'){ 
                                                                    $longitud = count($quienElaboraDecode);
                                                                    
                                                                    for($i=1; $i<$longitud; $i++){
                                                                        //saco el valor de cada elemento
                                                                        $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienElaboraDecode[$i]'");
                                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                        
                                                                        'Usuario: '.$enviarDocumentoControlCambiosElaborado=$nombres['cedula'];
                                                                    } 
                                                                }
                                                                 $nombreElaboro=$enviarDocumentoControlCambiosElaborado; '<br>';
                                                                
                                                            }
                        
                                                                if($validandoAlmacenamientoArryaB == 'activosUsuariosB'){ //echo 'No';
                                                                    $quienRevisadoDecode=json_decode($quienRevisa);
                                                                    if($quienRevisadoDecode[0] == 'cargos'){ 
                                                                        $longitud = count($quienRevisadoDecode);
                                                                        
                                                                        for($i=1; $i<$longitud; $i++){
                                                                            //saco el valor de cada elemento
                                                                            $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienRevisadoDecode[$i]'");
                                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                            
                                                                            'Cargo: '.$enviarDocumentoControlCambiosRevisado=$nombres['nombreCargos'];
                                                                        }            
                                                                    }
                                                                    
                                                                    if($quienRevisadoDecode[0] == 'usuarios'){ 
                                                                        $longitud = count($quienRevisadoDecode);
                                                                        
                                                                        for($i=1; $i<$longitud; $i++){
                                                                            //saco el valor de cada elemento
                                                                            $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienRevisadoDecode[$i]'");
                                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                            
                                                                            'Usuario: '.$enviarDocumentoControlCambiosRevisado=$nombres['cedula'];
                                                                        } 
                                                                    }
                                                                    $nombreReviso=$enviarDocumentoControlCambiosRevisado; '<br>';
                                                                }
                                                                
                                                                if($validandoAlmacenamientoArryaC == 'activosUsuariosC'){ 
                                                                    $quienApruebaDecode=json_decode($quienAprueba);
                                                                    if($quienApruebaDecode[0] == 'cargos'){ 
                                                                        $longitud = count($quienApruebaDecode);
                                                                        
                                                                        for($i=1; $i<$longitud; $i++){
                                                                            //saco el valor de cada elemento
                                                                            $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienApruebaDecode[$i]'");
                                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                            
                                                                            'Cargo: '.$enviarDocumentoControlCambiosAprueba=$nombres['nombreCargos'];
                                                                        }            
                                                                    }
                                                                    
                                                                    if($quienApruebaDecode[0] == 'usuarios'){ 
                                                                        $longitud = count($quienApruebaDecode);
                                                                        
                                                                        for($i=1; $i<$longitud; $i++){
                                                                            //saco el valor de cada elemento
                                                                            $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienApruebaDecode[$i]'");
                                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                            
                                                                            'Usuario: '.$enviarDocumentoControlCambiosAprueba=$nombres['cedula'];
                                                                        } 
                                                                    }
                                                                /// END
                                        
                                                                   
                                                                    $nombreAprobo=$enviarDocumentoControlCambiosAprueba; '<br>';
                                                                    
                                                                }
                                                                
                                                                if($validandoAlmacenamientoArrya == 'retiradosUsuarios'){ 
                                                                    $nombreElaboro=utf8_decode($_POST['select_encargadoEE']);
                                                                }
                                                                if($validandoAlmacenamientoArryaB == 'retiradosUsuariosB'){
                                                                    $nombreReviso=utf8_decode($_POST['select_encargadoRR']);
                                                                }
                                                                if($validandoAlmacenamientoArryaC == 'retiradosUsuariosC'){
                                                                    $nombreAprobo=utf8_decode($_POST['select_encargadoAA']);
                                                                }
                    
                        if($fechaElaboracion != NULL){ //$controlCambios
                            //$mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuarioB, fecha, rol) VALUES('$idSolicitud','$controlCambios','$nombreElaboro','$fechaElaboracion','Elaborador(a)')")or die(mysqli_error($mysqli));  
                            $mysqli->query("UPDATE controlCambios SET comentario='$controlCambios', fecha='$fechaElaboracion', idUsuarioB='$nombreElaboro' WHERE idDocumento='$idSolicitud' AND rol='Elaborador(a)' ")or die(mysqli_error($mysqli));  
                    
                        }
                        if($fechaRevision != NULL){ //$comentarioRevision
                            //$mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuarioB, fecha, rol) VALUES('$idSolicitud','$comentarioRevision','$nombreReviso','$fechaRevision','Revisor(a)')")or die(mysqli_error($mysqli));  
                            $mysqli->query("UPDATE controlCambios SET comentario='$comentarioRevision', fecha='$fechaRevision', idUsuarioB='$nombreReviso' WHERE idDocumento='$idSolicitud' AND rol='Revisor(a)' ")or die(mysqli_error($mysqli));  
                    
                        }
                        if($fechaAprobacion != NULL){ //$comentarioAprobo
                            //$mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuarioB, fecha, rol) VALUES('$idSolicitud','$comentarioAprobo','$nombreAprobo','$fechaAprobacion','Aprobador(a)')")or die(mysqli_error($mysqli));  
                            $mysqli->query("UPDATE controlCambios SET comentario='$comentarioAprobo', fecha='$fechaAprobacion', idUsuarioB='$nombreAprobo' WHERE idDocumento='$idSolicitud' AND rol='Aprobador(a)' ")or die(mysqli_error($mysqli));  
                    
                        }
                        
                        'Fechaaaaaaaa: '.$fecha = date("Ymjhis");

                        $rol = "Encargado(a) solicitud";
                    
                        '1: '.$nombrePDF = $_FILES['archivopdf']['name']; 
                        $rutaPDF =$_FILES['archivopdf']['tmp_name']; 
                        '<br>2: '.$nombreOtro =$_FILES['archivootro']['name'];
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
                        $nombrePDFf=$fecha.utf8_decode($nombrePDF);
                        '<br>';
                        $nombreOtroo=$fecha.utf8_decode($nombreOtro); //echo 'Muechee pues !';
                        if($nombrePDF  != NULL){
                            /*
                             `consecutivo`='$consecutivo',
                            `version`='$version',
                            `codificacion`='$codificacion',
                            */
                            $mysqli->query("UPDATE documento SET 
                            
                            `tipoCodificacion`='$radCodificacion',
                            `consecutivoTemporal`='$consecutivo',
                            `versionTemporal`='$version',
                            `nombres`='$documento',
                            `proceso`='$proceso',
                            `nombreProceso`='$nomProceso',
                            `norma`='$norma',
                            `tipo_documento`='$tipoDocumento',
                            `ubicacion`='$ubicacion',
                            `elabora`='$quienElabora',
                            `revisa`='$quienRevisa',
                            `aprueba`='$quienAprueba',
                            `documento_externo`='$documentosExternos',
                            `definiciones`='$definiciones',
                            `archivo_gestion`='$archivo_gestion',
                            `archivo_central`='$archivo_central',
                            `archivo_historico`='$archivo_historico',
                            `disposicion_documental`='$disposicion_documental',
                            `responsable_disposicion`='$escargadoDispo',
                            `usuario_aprovacion_reg`='$select_encargadoAR',
                            `mesesRevision`='$mesesRevision',
                            `id_solicitud`='$idSolicitud',
                            `nombrePDF`='$nombrePDFf'
                            
                            WHERE id='$idDocumento' ")or die(mysqli_error($mysqli)); //`nombreOtro`='$nombreOtroo'
                        }
                        if($nombreOtro  != NULL){
                            /*
                             `consecutivo`='$consecutivo',
                            `version`='$version',
                            `codificacion`='$codificacion',
                            */
                            $mysqli->query("UPDATE documento SET 
                            
                            `tipoCodificacion`='$radCodificacion',
                            `consecutivoTemporal`='$consecutivo',
                            `versionTemporal`='$version',
                            `nombres`='$documento',
                            `proceso`='$proceso',
                            `nombreProceso`='$nomProceso',
                            `norma`='$norma',
                            `tipo_documento`='$tipoDocumento',
                            `ubicacion`='$ubicacion',
                            `elabora`='$quienElabora',
                            `revisa`='$quienRevisa',
                            `aprueba`='$quienAprueba',
                            `documento_externo`='$documentosExternos',
                            `definiciones`='$definiciones',
                            `archivo_gestion`='$archivo_gestion',
                            `archivo_central`='$archivo_central',
                            `archivo_historico`='$archivo_historico',
                            `disposicion_documental`='$disposicion_documental',
                            `responsable_disposicion`='$escargadoDispo',
                            `usuario_aprovacion_reg`='$select_encargadoAR',
                            `mesesRevision`='$mesesRevision',
                            `id_solicitud`='$idSolicitud',
                            `nombreOtro`='$nombreOtroo'
                            
                            WHERE id='$idDocumento' ")or die(mysqli_error($mysqli)); //`nombreOtro`='$nombreOtroo'
                        }
    
                        if($nombrePDF != NULL && $nombreOtro != NULL){
                            /*
                             `consecutivo`='$consecutivo',
                            `version`='$version',
                            `codificacion`='$codificacion',
                            */
                            $mysqli->query("UPDATE documento SET 
                            
                            `tipoCodificacion`='$radCodificacion',
                            `consecutivoTemporal`='$consecutivo',
                            `versionTemporal`='$version',
                            `nombres`='$documento',
                            `proceso`='$proceso',
                            `nombreProceso`='$nomProceso',
                            `norma`='$norma',
                            `tipo_documento`='$tipoDocumento',
                            `ubicacion`='$ubicacion',
                            `elabora`='$quienElabora',
                            `revisa`='$quienRevisa',
                            `aprueba`='$quienAprueba',
                            `documento_externo`='$documentosExternos',
                            `definiciones`='$definiciones',
                            `archivo_gestion`='$archivo_gestion',
                            `archivo_central`='$archivo_central',
                            `archivo_historico`='$archivo_historico',
                            `disposicion_documental`='$disposicion_documental',
                            `responsable_disposicion`='$escargadoDispo',
                            `usuario_aprovacion_reg`='$select_encargadoAR',
                            `mesesRevision`='$mesesRevision',
                            `id_solicitud`='$idSolicitud',
                            `nombrePDF`='$nombrePDFf',
                            `nombreOtro`='$nombreOtroo'
                            WHERE id='$idDocumento' ")or die(mysqli_error($mysqli));
                        }
                /*
                    $mysqli->query("UPDATE documento SET 
                    `codificacion`='$codificacion',
                    `tipoCodificacion`='$radCodificacion',
                    `consecutivo`='$consecutivo',
                    `version`='$version',
                    `nombres`='$documento',
                    `proceso`='$proceso',
                    `nombreProceso`='$nomProceso',
                    `norma`='$norma',
                    `tipo_documento`='$tipoDocumento',
                    `ubicacion`='$ubicacion',
                    `elabora`='$quienElabora',
                    `revisa`='$quienRevisa',
                    `aprueba`='$quienAprueba',
                    `documento_externo`='$documentosExternos',
                    `definiciones`='$definiciones',
                    `archivo_gestion`='$archivo_gestion',
                    `archivo_central`='$archivo_central',
                    `archivo_historico`='$archivo_historico',
                    `disposicion_documental`='$disposicion_documental',
                    `responsable_disposicion`='$escargadoDispo',
                    `usuario_aprovacion_reg`='$select_encargadoAR',
                    `mesesRevision`='$mesesRevision',
                    `id_solicitud`='$idSolicitud',
                    `nombrePDF`='$nombrePDFf',
                    `nombreOtro`='$nombreOtroo'
                    WHERE id='$idDocumento' ")or die(mysqli_error($mysqli));
                 */               
                }


            }else{
                
                $ruta = utf8_decode('archivos/solicitudes/'.$archivoNombre);
                
                $consultandoDocumento=$mysqli->query("SELECT * FROM documento WHERE id='$idDocumento' ");
                $extraerConsultaDocumento=$consultandoDocumento->fetch_array(MYSQLI_ASSOC);
                
                if($archivoNombre != NULL){
                    $mysqli->query("UPDATE solicitudDocumentos SET nombreEncargado='$encargadoTexto',  tipoDocumento='$tipoDocumento', encargadoAprobar='$encargado', 
                    nombreDocumento='$documento', nombreDocumento2='$documento', proceso='$proceso', solicitud='$documento', documento='$ruta' WHERE id='".$extraerConsultaDocumento['id_solicitud']."' ")or die(mysqli_error($mysqli));
                }else{
                    $mysqli->query("UPDATE solicitudDocumentos SET nombreEncargado='$encargadoTexto',  tipoDocumento='$tipoDocumento', encargadoAprobar='$encargado', 
                    nombreDocumento='$documento', nombreDocumento2='$documento', proceso='$proceso', solicitud='$documento' WHERE id='".$extraerConsultaDocumento['id_solicitud']."' ")or die(mysqli_error($mysqli));
                }
                

                $queryId = $mysqli->query("SELECT * FROM `solicitudDocumentos` WHERE id = '".$extraerConsultaDocumento['id_solicitud']."' ORDER BY id DESC");
                $datos = $queryId->fetch_array(MYSQLI_ASSOC);
                '<br>ID documento: '.$idSolicitud=$datos['id'];
                
                if($datos != NULL){
                    //VERSION Y CONSECUTIVO  
                        $queryProcesos = $mysqli->query("SELECT nombre,prefijo from procesos WHERE id = '".$proceso."' ");
                        $datosProceso = $queryProcesos->fetch_array(MYSQLI_ASSOC);
                        //$nomProceso = $datosProceso['nombre'];
                        $prefijoProceso = $datosProceso['prefijo'];
                        
                    
                        //TIPO DE DOCUMENTO 
                        $queryDocumentos = $mysqli->query("SELECT nombre, prefijo from tipoDocumento WHERE id = '".$tipoDocumento."' ");
                        $datosDocumento = $queryDocumentos->fetch_array(MYSQLI_ASSOC);
                        //$tipoDocumento = $datosDocumento['nombre'];
                        $prefijoTipo = $datosDocumento['prefijo']; 
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
                    'control de cambios : '.$controlCambios=utf8_decode($_POST['controlCambios']);
                    //// end
                    '<br>';
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
                    '<br><b>';
                    $validandoAlmacenamientoArrya;
                    '</b><br>';
                    /*
                    if($validandoAlmacenamientoArrya == 'activosUsuarios'){
                        
                        /// validar y traer el nombre del id para sacar la CC y enviar al control de cambios
                        
                        $quienElaboraDecode=json_decode($quienElabora);
                            if($quienElaboraDecode[0] == 'cargos'){ 
                                $longitud = count($quienElaboraDecode);
                                
                                for($i=1; $i<$longitud; $i++){
                                    //saco el valor de cada elemento
                                    $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienElaboraDecode[$i]'");
                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                    
                                    'Cargo: '.$enviarDocumentoControlCambiosElaborado=$nombres['nombreCargos'];
                                }            
                            }
                            
                            if($quienElaboraDecode[0] == 'usuarios'){ 
                                $longitud = count($quienElaboraDecode);
                                
                                for($i=1; $i<$longitud; $i++){
                                    //saco el valor de cada elemento
                                    $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienElaboraDecode[$i]'");
                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                    
                                    'Usuario: '.$enviarDocumentoControlCambiosElaborado=$nombres['cedula'];
                                } 
                            }
                            
                            $quiennRevisadoDecode=json_decode($quienRevisa);
                            if($quiennRevisadoDecode[0] == 'cargos'){ 
                                $longitud = count($quiennRevisadoDecode);
                                
                                for($i=1; $i<$longitud; $i++){
                                    //saco el valor de cada elemento
                                    $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quiennRevisadoDecode[$i]'");
                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                    
                                    'Cargo: '.$enviarDocumentoControlCambiosRevisado=$nombres['nombreCargos'];
                                }            
                            }
                            
                            if($quiennRevisadoDecode[0] == 'usuarios'){ 
                                $longitud = count($quiennRevisadoDecode);
                                
                                for($i=1; $i<$longitud; $i++){
                                    //saco el valor de cada elemento
                                    $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quiennRevisadoDecode[$i]'");
                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                    
                                    'Usuario: '.$enviarDocumentoControlCambiosRevisado=$nombres['cedula'];
                                } 
                            }

                            $quienApruebaDecode=json_decode($quienAprueba);
                            if($quienApruebaDecode[0] == 'cargos'){ 
                                $longitud = count($quienApruebaDecode);
                                
                                for($i=1; $i<$longitud; $i++){
                                    //saco el valor de cada elemento
                                    $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienApruebaDecode[$i]'");
                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                    
                                    'Cargo: '.$enviarDocumentoControlCambiosAprueba=$nombres['nombreCargos'];
                                }            
                            }
                            
                            if($quienApruebaDecode[0] == 'usuarios'){ 
                                $longitud = count($quienApruebaDecode);
                                
                                for($i=1; $i<$longitud; $i++){
                                    //saco el valor de cada elemento
                                    $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienApruebaDecode[$i]'");
                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                    
                                    'Usuario: '.$enviarDocumentoControlCambiosAprueba=$nombres['cedula'];
                                } 
                            }
                        /// END

                        $nombreElaboro=$enviarDocumentoControlCambiosElaborado; '<br>';
                        $nombreReviso=$enviarDocumentoControlCambiosRevisado; '<br>';//$_POST['nombreReviso']; 
                        $nombreAprobo=$enviarDocumentoControlCambiosAprueba; '<br>';//$_POST['nombreAprobo'];
                    }
                    if($validandoAlmacenamientoArrya == 'retiradosUsuarios'){
                        $nombreElaboro=utf8_decode($quienElabora);//$_POST['nombreElaboro']);
                        $nombreReviso=utf8_decode($quienRevisa);//$_POST['nombreReviso']);
                        $nombreAprobo=utf8_decode($quienAprueba);//$_POST['nombreAprobo']);
                    }
                    */
                    if($validandoAlmacenamientoArrya == 'activosUsuarios'){ //echo 'No';
                                                                $quienElaboraDecode=json_decode($quienElabora);
                                                                if($quienElaboraDecode[0] == 'cargos'){ 
                                                                    $longitud = count($quienElaboraDecode);
                                                                    
                                                                    for($i=1; $i<$longitud; $i++){
                                                                        //saco el valor de cada elemento
                                                                        $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienElaboraDecode[$i]'");
                                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                        
                                                                         'Cargo: '.$enviarDocumentoControlCambiosElaborado=$nombres['nombreCargos'];
                                                                    }            
                                                                }
                                                                
                                                                if($quienElaboraDecode[0] == 'usuarios'){ 
                                                                    $longitud = count($quienElaboraDecode);
                                                                    
                                                                    for($i=1; $i<$longitud; $i++){
                                                                        //saco el valor de cada elemento
                                                                        $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienElaboraDecode[$i]'");
                                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                        
                                                                        'Usuario: '.$enviarDocumentoControlCambiosElaborado=$nombres['cedula'];
                                                                    } 
                                                                }
                                                                 $nombreElaboro=$enviarDocumentoControlCambiosElaborado; '<br>';
                                                                
                                                            }
                        
                                                                if($validandoAlmacenamientoArryaB == 'activosUsuariosB'){ //echo 'No';
                                                                    $quienRevisadoDecode=json_decode($quienRevisa);
                                                                    if($quienRevisadoDecode[0] == 'cargos'){ 
                                                                        $longitud = count($quienRevisadoDecode);
                                                                        
                                                                        for($i=1; $i<$longitud; $i++){
                                                                            //saco el valor de cada elemento
                                                                            $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienRevisadoDecode[$i]'");
                                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                            
                                                                            'Cargo: '.$enviarDocumentoControlCambiosRevisado=$nombres['nombreCargos'];
                                                                        }            
                                                                    }
                                                                    
                                                                    if($quienRevisadoDecode[0] == 'usuarios'){ 
                                                                        $longitud = count($quienRevisadoDecode);
                                                                        
                                                                        for($i=1; $i<$longitud; $i++){
                                                                            //saco el valor de cada elemento
                                                                            $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienRevisadoDecode[$i]'");
                                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                            
                                                                            'Usuario: '.$enviarDocumentoControlCambiosRevisado=$nombres['cedula'];
                                                                        } 
                                                                    }
                                                                    $nombreReviso=$enviarDocumentoControlCambiosRevisado; '<br>';
                                                                }
                                                                
                                                                if($validandoAlmacenamientoArryaC == 'activosUsuariosC'){ 
                                                                    $quienApruebaDecode=json_decode($quienAprueba);
                                                                    if($quienApruebaDecode[0] == 'cargos'){ 
                                                                        $longitud = count($quienApruebaDecode);
                                                                        
                                                                        for($i=1; $i<$longitud; $i++){
                                                                            //saco el valor de cada elemento
                                                                            $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienApruebaDecode[$i]'");
                                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                            
                                                                            'Cargo: '.$enviarDocumentoControlCambiosAprueba=$nombres['nombreCargos'];
                                                                        }            
                                                                    }
                                                                    
                                                                    if($quienApruebaDecode[0] == 'usuarios'){ 
                                                                        $longitud = count($quienApruebaDecode);
                                                                        
                                                                        for($i=1; $i<$longitud; $i++){
                                                                            //saco el valor de cada elemento
                                                                            $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienApruebaDecode[$i]'");
                                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                            
                                                                            'Usuario: '.$enviarDocumentoControlCambiosAprueba=$nombres['cedula'];
                                                                        } 
                                                                    }
                                                                /// END
                                        
                                                                   
                                                                    $nombreAprobo=$enviarDocumentoControlCambiosAprueba; '<br>';
                                                                    
                                                                }
                                                                
                                                                if($validandoAlmacenamientoArrya == 'retiradosUsuarios'){ 
                                                                    $nombreElaboro=utf8_decode($_POST['select_encargadoEE']);
                                                                }
                                                                if($validandoAlmacenamientoArryaB == 'retiradosUsuariosB'){
                                                                    $nombreReviso=utf8_decode($_POST['select_encargadoRR']);
                                                                }
                                                                if($validandoAlmacenamientoArryaC == 'retiradosUsuariosC'){
                                                                    $nombreAprobo=utf8_decode($_POST['select_encargadoAA']);
                                                                }
                    
                        if($fechaElaboracion != NULL){ //$controlCambios
                            //$mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuarioB, fecha, rol) VALUES('$idSolicitud','$controlCambios','$nombreElaboro','$fechaElaboracion','Elaborador(a)')")or die(mysqli_error($mysqli));  
                            $mysqli->query("UPDATE controlCambios SET comentario='$controlCambios', fecha='$fechaElaboracion', idUsuarioB='$nombreElaboro' WHERE idDocumento='$idSolicitud' AND rol='Elaborador(a)' ")or die(mysqli_error($mysqli));  
                    
                        }
                        if($fechaRevision != NULL){ //$comentarioRevision
                            //$mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuarioB, fecha, rol) VALUES('$idSolicitud','$comentarioRevision','$nombreReviso','$fechaRevision','Revisor(a)')")or die(mysqli_error($mysqli));  
                            $mysqli->query("UPDATE controlCambios SET comentario='$comentarioRevision', fecha='$fechaRevision', idUsuarioB='$nombreReviso' WHERE idDocumento='$idSolicitud' AND rol='Revisor(a)' ")or die(mysqli_error($mysqli));  
                    
                        }
                        if($fechaAprobacion != NULL){ //$comentarioAprobo
                            //$mysqli->query("INSERT INTO controlCambios (idDocumento, comentario, idUsuarioB, fecha, rol) VALUES('$idSolicitud','$comentarioAprobo','$nombreAprobo','$fechaAprobacion','Aprobador(a)')")or die(mysqli_error($mysqli));  
                            $mysqli->query("UPDATE controlCambios SET comentario='$comentarioAprobo', fecha='$fechaAprobacion', idUsuarioB='$nombreAprobo' WHERE idDocumento='$idSolicitud' AND rol='Aprobador(a)' ")or die(mysqli_error($mysqli));  
                    
                        }
                        
                        'Fechaaaaaaaa: '.$fecha = date("Ymjhis");

                        $rol = "Encargado(a) solicitud";
                    
                        '1: '.$nombrePDF = $_FILES['archivopdf']['name']; 
                        $rutaPDF =$_FILES['archivopdf']['tmp_name']; 
                        '<br>2: '.$nombreOtro =$_FILES['archivootro']['name'];
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
                        'PDFFFFF: '.$nombrePDFf=$fecha.utf8_decode($nombrePDF);
                        '<br>';
                        $nombreOtroo=$fecha.utf8_decode($nombreOtro);

                    if($nombrePDF  != NULL){
                        /*
                             `consecutivo`='$consecutivo',
                            `version`='$version',
                            `codificacion`='$codificacion',
                            */
                        $mysqli->query("UPDATE documento SET 
                        
                        `tipoCodificacion`='$radCodificacion',
                        `consecutivoTemporal`='$consecutivo',
                        `versionTemporal`='$version',
                        `nombres`='$documento',
                        `proceso`='$proceso',
                        `nombreProceso`='$nomProceso',
                        `norma`='$norma',
                        `tipo_documento`='$tipoDocumento',
                        `ubicacion`='$ubicacion',
                        `elabora`='$quienElabora',
                        `revisa`='$quienRevisa',
                        `aprueba`='$quienAprueba',
                        `documento_externo`='$documentosExternos',
                        `definiciones`='$definiciones',
                        `archivo_gestion`='$archivo_gestion',
                        `archivo_central`='$archivo_central',
                        `archivo_historico`='$archivo_historico',
                        `disposicion_documental`='$disposicion_documental',
                        `responsable_disposicion`='$escargadoDispo',
                        `usuario_aprovacion_reg`='$select_encargadoAR',
                        `mesesRevision`='$mesesRevision',
                        `id_solicitud`='$idSolicitud',
                        `nombrePDF`='$nombrePDFf'
                        
                        WHERE id='$idDocumento' ")or die(mysqli_error($mysqli)); //`nombreOtro`='$nombreOtroo'
                    }
                    if($nombreOtro  != NULL){
                        /*
                             `consecutivo`='$consecutivo',
                            `version`='$version',
                            `codificacion`='$codificacion',
                            */
                        $mysqli->query("UPDATE documento SET 
                        
                        `tipoCodificacion`='$radCodificacion',
                        `consecutivoTemporal`='$consecutivo',
                        `versionTemporal`='$version',
                        `nombres`='$documento',
                        `proceso`='$proceso',
                        `nombreProceso`='$nomProceso',
                        `norma`='$norma',
                        `tipo_documento`='$tipoDocumento',
                        `ubicacion`='$ubicacion',
                        `elabora`='$quienElabora',
                        `revisa`='$quienRevisa',
                        `aprueba`='$quienAprueba',
                        `documento_externo`='$documentosExternos',
                        `definiciones`='$definiciones',
                        `archivo_gestion`='$archivo_gestion',
                        `archivo_central`='$archivo_central',
                        `archivo_historico`='$archivo_historico',
                        `disposicion_documental`='$disposicion_documental',
                        `responsable_disposicion`='$escargadoDispo',
                        `usuario_aprovacion_reg`='$select_encargadoAR',
                        `mesesRevision`='$mesesRevision',
                        `id_solicitud`='$idSolicitud',
                        `nombreOtro`='$nombreOtroo'
                        
                        WHERE id='$idDocumento' ")or die(mysqli_error($mysqli)); //`nombreOtro`='$nombreOtroo'
                    }

                    if($nombrePDF != NULL && $nombreOtro != NULL){
                        /*
                             `consecutivo`='$consecutivo',
                            `version`='$version',
                            `codificacion`='$codificacion',
                            */
                        $mysqli->query("UPDATE documento SET 
                        
                        `tipoCodificacion`='$radCodificacion',
                        `consecutivoTemporal`='$consecutivo',
                        `versionTemporal`='$version',
                        `nombres`='$documento',
                        `proceso`='$proceso',
                        `nombreProceso`='$nomProceso',
                        `norma`='$norma',
                        `tipo_documento`='$tipoDocumento',
                        `ubicacion`='$ubicacion',
                        `elabora`='$quienElabora',
                        `revisa`='$quienRevisa',
                        `aprueba`='$quienAprueba',
                        `documento_externo`='$documentosExternos',
                        `definiciones`='$definiciones',
                        `archivo_gestion`='$archivo_gestion',
                        `archivo_central`='$archivo_central',
                        `archivo_historico`='$archivo_historico',
                        `disposicion_documental`='$disposicion_documental',
                        `responsable_disposicion`='$escargadoDispo',
                        `usuario_aprovacion_reg`='$select_encargadoAR',
                        `mesesRevision`='$mesesRevision',
                        `id_solicitud`='$idSolicitud',
                        `nombrePDF`='$nombrePDFf',
                        `nombreOtro`='$nombreOtroo'
                        WHERE id='$idDocumento' ")or die(mysqli_error($mysqli));
                    }
                    
                                
                }


                    /*
                    ?>
                        <script> 
                             window.onload=function(){
                           
                                 document.forms["miformulario"].submit();
                             }
                        </script>
                         
                         <form name="miformulario" action="../../crearDocumentoMasivoObsoleto" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="enviarIdDocumento" value="<?php echo $idDocumento;?>">
                        <input type="hidden" name="enviarIdDocumentoControl" value="<?php echo $_POST['enviarIdDocumentoControl'];?>">
                        <input type="hidden" name="editarDocumentoMasivo" value="1">
                        </form>
                    <?php */
            }

        }

    }




 ///// validamos los documentos para verificar que estén en orden, en caso contrario mandamos la alerta
                                                        $preguntadoValidacion=$mysqli->query("SELECT * FROM documento WHERE  id='$idDocumento' ");
                                                		$extraerPreguntaValidacion=$preguntadoValidacion->fetch_array(MYSQLI_ASSOC);
                                                		     ' - '.$documentoExtraidoPdf=utf8_encode($extraerPreguntaValidacion['nombrePDF']);
                                                		    '<br> - '.$documentoExtraidoOtro=utf8_encode($extraerPreguntaValidacion['nombreOtro']);
                                                		    
                                                		  '<br>';
                                                		  '<br>';
        		                                        $carpeta="../../archivos/documentos/";
                                                        $ruta="/".$carpeta."/";
                                                        $directorio=opendir($carpeta);
                                                        //recoger los  datos
                                                        $datos=array();
                                                        $conteoArchivosB=0;
                                                        $conteoArchivosB2=0;
                                                        while ($archivo = readdir($directorio)) { 
                                                          if(($archivo != '.')&&($archivo != '..')){
                                                             
                                                            if($documentoExtraidoPdf == $datos[]=$archivo){
                                                                $conteoArchivosB++;
                                                                 $datos[]=$archivo;  '<br>';
                                                            }
                                                            if($documentoExtraidoOtro == $datos[]=$archivo){
                                                                $conteoArchivosB2++;
                                                                 $datos[]=$archivo;  '<br>';
                                                            }
                                                             
                                                             
                                                          } 
                                                        }
                                                        closedir($directorio);
                                                        
                                                        /// validamos que existe registro para validar cantidades de archivos
                                                        if($documentoExtraidoPdf != NULL && $documentoExtraidoOtro != NULL){
                                                            //echo 'existe los 2';
                                                        }
                                                        
                                                        if($documentoExtraidoPdf != NULL && $documentoExtraidoOtro == NULL){
                                                            //echo 'viene vacio otro';
                                                            $conteoArchivosB2=1; // cuando viene en vacio el editable, mandamos 1 para no activar la alerta, ya que debe verificar que el archivo está dañado o no
                                                        }
                                                        if($documentoExtraidoPdf == NULL && $documentoExtraidoOtro != NULL){
                                                            //echo 'viene vacio pdf';
                                                            $conteoArchivosB=1; // cuando viene en vacio el editable, mandamos 1 para no activar la alerta, ya que debe verificar que el archivo está dañado o no
                                                        }
                                                            
                                                        if($conteoArchivosB > 0 && $conteoArchivosB2 > 0){
                                                           $documentoHabilitado2='1'; 
                                                        }else{
                                                           $documentoHabilitado2='no coincide';
                                                        }
                                                         '<br>B: '.$documentoHabilitado2;
                                                        ///// END
                                                        
                                                        
                                                        
            if( $_FILES['archivopdf']['name'] == NULL && $_FILES['archivootro']['name'] == NULL){  /// si no se suben documentos, no debe activar la alerta
                 ?>
                                                            <script> 
                                                                 window.onload=function(){
                                                                   document.forms["miformulario"].submit();
                                                                 }
                                                            </script>
                                                             
                                                            <form name="miformulario" action="../../crearDocumentoMasivoObsoleto" method="POST" onsubmit="procesar(this.action);" >
                                                                <!--<input type="submit" value="enviar registro">-->
                                                            </form> 
                                                        <?php
            }else{                               
                                                        
                                            if($documentoHabilitado2 == 1){
                                            ?>
                                                    <script> 
                                                        window.onload=function(){
                                                           document.forms["miformulario"].submit();
                                                        }
                                                    </script>
                                                    <form name="miformulario" action="../../crearDocumentoMasivoObsoleto" method="POST" onsubmit="procesar(this.action);" >
                                                    <!--<input type="hidden" name="enviarIdDocumento" value="<?php //echo $idDocumento;?>">
                                                    <input type="hidden" name="enviarIdDocumentoControl" value="<?php //echo $_POST['enviarIdDocumentoControl'];?>">
                                                    <input type="hidden" name="editarDocumentoMasivo" value="1">-->
                                                    </form> 
                                            <?php
                                            }else{
                                            //echo '<br>Alerta';
                                            ?>
                                                <script> 
                                                     window.onload=function(){
                                                       document.forms["miformulario"].submit();
                                                     }
                                                </script>
                                                 
                                                <form name="miformulario" action="../../crearDocumentoMasivoObsoleto" method="POST" onsubmit="procesar(this.action);" >
                                                    <input name="alertaDocumento" value="1" type="hidden">
                                                    <input type="hidden" name="enviarIdDocumento" value="<?php echo $idDocumento;?>">
                                                    <input type="hidden" name="enviarIdDocumentoControl" value="<?php echo $_POST['enviarIdDocumentoControl'];?>">
                                                    <input type="hidden" name="editarDocumentoMasivo" value="1">
                                                    <!-- <input type="submit" value="enviar alerta"> -->
                                                </form> 
                                            <?php    
                                            }
            }


    }    

}

if(isset($_POST['ejecutador'])){ 
    //$mysqli->query("UPDATE documento SET pre = NULL WHERE pre='si' ");
    
    /// traemos todos los documentos que están en obsoletos
    $recorrido_documento_obsoleto=$mysqli->query("SELECT * FROM `documento`  order by id DESC "); //WHERE  obsoleto='1' AND pre='si'
    while($extraer_recorrido_documento=$recorrido_documento_obsoleto->fetch_array()){
        
        /// hacemos la validación del consecutivo de los documentos pendientes en ejecutar todo en obsoletos
        $consultamosExistenciaDocumento=$mysqli->query("SELECT * FROM documento WHERE tipo_documento='".$extraer_recorrido_documento['tipo_documento']."' AND proceso='".$extraer_recorrido_documento['proceso']."' AND consecutivo='".$extraer_recorrido_documento['consecutivoTemporal']."' AND version='".$extraer_recorrido_documento['versionTemporal']."' ORDER BY id DESC "); //AND  vigente='1' id='$idDocumento' AND aprobado_aprueba='1'
        $contadorVigente=0;
        $contadorObsoleto=0;
        while($extraemosExistenciaDocumento=$consultamosExistenciaDocumento->fetch_array()){
        
         'dentro del while';
            if($extraemosExistenciaDocumento['proceso'] && $extraemosExistenciaDocumento['tipo_documento'] && $extraemosExistenciaDocumento['consecutivo'] && $extraemosExistenciaDocumento['version'] && $extraemosExistenciaDocumento['vigente'] == 1){
                 'conteo vigente: '.$contadorVigente++;
            }
            if($extraemosExistenciaDocumento['proceso'] && $extraemosExistenciaDocumento['tipo_documento'] && $extraemosExistenciaDocumento['consecutivo'] && $extraemosExistenciaDocumento['version'] && $extraemosExistenciaDocumento['obsoleto'] == 1){
                 'conteo obsole: '.$contadorObsoleto++;
            } 
            
        }
       
        
        if($contadorVigente > 0 || $contadorObsoleto > 0){ 
       //echo 'alerta';
                    ?>
                        <script> 
                             window.onload=function(){
                               document.forms["miformularioAlerta"].submit();
                             }
                        </script>
                                                             
                        <form name="miformularioAlerta" action="../../crearDocumentoMasivoObsoleto" method="POST" onsubmit="procesar(this.action);" >
                            <input name="alertaConsecutivo" value="1" type="hidden">
                            <input name="editarDocumentoMasivo" value="1" type="hidden">
                            <input name="enviarIdDocumento" value="<?php echo $extraer_consulta_documento['id'];?>" type="hidden">
                            <input name="enviarIdDocumentoControl" value="<?php echo $extraer_consulta_documento['id_solicitud'];?>" type="hidden">
                            <!-- <input type="submit" value="enviar alerta"> -->
                        </form> 
                    <?php 
        }else{
        
                // guardamos la codificación anotada
                                    $consulta_documento=$mysqli->query("SELECT * FROM documento WHERE id='".$extraer_recorrido_documento['id']."' ");
                                    $extraer_consulta_documento=$consulta_documento->fetch_array(MYSQLI_ASSOC);
                                    /// consultamos el tipo de documento para traer el prefijo
                                        $consultaTipoDocumento=$mysqli->query("SELECT prefijo,id FROM tipoDocumento WHERE id='".$extraer_consulta_documento['tipo_documento']."' ");
                                        $extraerNombreTipoDocumentoConsulDocum=$consultaTipoDocumento->fetch_array(MYSQLI_ASSOC);
                                        $prefijoTipo=$extraerNombreTipoDocumentoConsulDocum['prefijo'];
                                        //// consultamos el prefijo del proceso para traerlo
                                        $consultaProceso=$mysqli->query("SELECT id,prefijo FROM procesos WHERE id='".$extraer_consulta_documento['proceso']."' ");
                                        $extraerNombreProcesoConsulDocum=$consultaProceso->fetch_array(MYSQLI_ASSOC);
                                        $prefijoProceso=$extraerNombreProcesoConsulDocum['prefijo'];
                                        
                                        /// traemos el consecutivo y version temporal para mostrar antes de ser verificado nuevamente
                                        $consecutivo=$extraer_consulta_documento['consecutivoTemporal'];
                                        $version=$extraer_consulta_documento['versionTemporal'];
                                        
                                        //echo $recorridoDocumentos['codificacion'];
                                        
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
                                            }
         '<br>consecutivo: '.$codificacion;
         '<br>id: '.$extraer_recorrido_documento['id'];
        
        
        $mysqli->query("UPDATE documento SET pre = NULL, codificacion='$codificacion', consecutivo='$consecutivo', version='$version' WHERE pre='si' AND id='".$extraer_recorrido_documento['id']."' ");
        $mysqli->query("UPDATE solicitudDocumentos SET estado ='Ejecutado' WHERE id='".$_POST['idSolicitudDocumento']."' ");
         'guarda';
                    ?>
                        <script> 
                             window.onload=function(){
                           
                                document.forms["miformulario"].submit();
                             }
                        </script>
                         
                        <form name="miformulario" action="../../crearDocumentoMasivoObsoleto" method="POST" onsubmit="procesar(this.action);" >
                            <input name="validacionAgregarD" value="1" type="hidden">
                        </form> 
                    <?php
    }
        
        
        
    }
    
    
    /// traemos todos los documentos que están en obsoletos, Volvemos a preguntar, si existe el documento, para activar el mensaje
    $recorrido_documento_obsoleto_verificando=$mysqli->query("SELECT * FROM `documento` WHERE obsoleto='1' AND pre='si' order by id DESC ");
    while($extraer_recorrido_documento_verificando=$recorrido_documento_obsoleto_verificando->fetch_array()){ 
         $extraer_recorrido_documento_verificando['tipo_documento'];
         ' - '.$extraer_recorrido_documento_verificando['proceso'];
         '<br>';
    /// hacemos la validación del consecutivo de los documentos pendientes en ejecutar todo en obsoletos
        $consultamosExistenciaDocumento=$mysqli->query("SELECT * FROM documento WHERE tipo_documento='".$extraer_recorrido_documento_verificando['tipo_documento']."' AND proceso='".$extraer_recorrido_documento_verificando['proceso']."' AND consecutivo='".$extraer_recorrido_documento_verificando['consecutivoTemporal']."' AND version='".$extraer_recorrido_documento_verificando['versionTemporal']."' ORDER BY id DESC "); //AND  vigente='1' id='$idDocumento' AND aprobado_aprueba='1'
        $contadorVigenteVerificando=0;
        $contadorObsoletoVerificando=0;
        while($extraemosExistenciaDocumento=$consultamosExistenciaDocumento->fetch_array()){
        
         'dentro del while';
            if($extraemosExistenciaDocumento['proceso'] && $extraemosExistenciaDocumento['tipo_documento'] && $extraemosExistenciaDocumento['consecutivo'] && $extraemosExistenciaDocumento['version'] && $extraemosExistenciaDocumento['vigente'] == 1){
                 'conteo vigente: '.$contadorVigenteVerificando++;
            }
            if($extraemosExistenciaDocumento['proceso'] && $extraemosExistenciaDocumento['tipo_documento'] && $extraemosExistenciaDocumento['consecutivo'] && $extraemosExistenciaDocumento['version'] && $extraemosExistenciaDocumento['obsoleto'] == 1){
                 'conteo obsole: '.$contadorObsoletoVerificando++;
            } 
            
        }
    }
    ?>
                        <script> 
                             window.onload=function(){
                                //alert("Falta configurar todos los pre de documento");
                                document.forms["miformulario"].submit();
                             }
                        </script>
                         
                        <form name="miformulario" action="../../crearDocumentoMasivoObsoleto" method="POST" onsubmit="procesar(this.action);" >
                            <?php 
                             'vigente: '.$contadorVigenteVerificando; 
                             '<br>obsoleto: '.$contadorObsoletoVerificando;
                            if($contadorVigenteVerificando > 0 || $contadorObsoletoVerificando > 0){ ///echo '<br>Entra a activar la validacion';
                            ?>
                            <input name="alertaConsecutivo" value="1" type="hidden">
                            <!--<input name="validacionAgregarD" value="1" type="hidden">-->
                            <?php
                            }
                            ?>
                        </form> 
                    <?php
}

if(isset($_POST['ejecutadorIndividual'])){
    
    
    //// consultamos el documento para traer el tipo de documento, proceso y validar el conecutivo
    
    $consulta_documento=$mysqli->query("SELECT * FROM documento WHERE id='".$_POST['idDocumento']."' ");
    $extraer_consulta_documento=$consulta_documento->fetch_array(MYSQLI_ASSOC);
     'proceso: '.$proceso=$extraer_consulta_documento['proceso'];
     '<br>tipo de documento: '.$tipoDoc=$extraer_consulta_documento['tipo_documento'];
     '<br>consecutivo: '.$consecutivo=$extraer_consulta_documento['consecutivoTemporal'];
     '<br>version: '.$version=$extraer_consulta_documento['versionTemporal'];
    
    
     '<br><br>';
    // validamos la existencia de este proceso
        
        $consultamosExistenciaDocumento=$mysqli->query("SELECT * FROM documento WHERE tipo_documento='$tipoDoc' AND proceso='$proceso' AND consecutivo='$consecutivo' AND version='$version' ORDER BY id DESC "); //AND  vigente='1' id='$idDocumento' AND aprobado_aprueba='1'
        $contadorVigente=0;
        $contadorObsoleto=0;
        while($extraemosExistenciaDocumento=$consultamosExistenciaDocumento->fetch_array()){
        
        
            if($extraemosExistenciaDocumento['proceso'] && $extraemosExistenciaDocumento['tipo_documento'] && $extraemosExistenciaDocumento['consecutivo'] && $extraemosExistenciaDocumento['version'] && $extraemosExistenciaDocumento['vigente'] == 1){
                 'conteo vigente: '.$contadorVigente++;
            }
            if($extraemosExistenciaDocumento['proceso'] && $extraemosExistenciaDocumento['tipo_documento'] && $extraemosExistenciaDocumento['consecutivo'] && $extraemosExistenciaDocumento['version'] && $extraemosExistenciaDocumento['obsoleto'] == 1){
                 'conteo obsole: '.$contadorObsoleto++;
            } 
            
        }
        
     '<br>';
    
    if($contadorVigente > 0 || $contadorObsoleto > 0){ 
        'validacion activa';
                    ?>
                        <script> 
                             window.onload=function(){
                               document.forms["miformularioAlertaObVi"].submit();
                             }
                        </script>
                                                             
                        <form name="miformularioAlertaObVi" action="../../crearDocumentoMasivoObsoleto" method="POST" onsubmit="procesar(this.action);" >
                            <input name="alertaConsecutivo" value="1" type="hidden">
                            <input name="editarDocumentoMasivo" value="1" type="hidden">
                            <input name="enviarIdDocumento" value="<?php echo $extraer_consulta_documento['id'];?>" type="hidden">
                            <input name="enviarIdDocumentoControl" value="<?php echo $extraer_consulta_documento['id_solicitud'];?>" type="hidden">
                            <!-- <input type="submit" value="enviar alerta"> -->
                        </form> 
                    <?php 
    }else{
        
        // guardamos la codificación anotada
                                    $consulta_documento=$mysqli->query("SELECT * FROM documento WHERE id='".$_POST['idDocumento']."' ");
                                    $extraer_consulta_documento=$consulta_documento->fetch_array(MYSQLI_ASSOC);
                                    /// consultamos el tipo de documento para traer el prefijo
                                        $consultaTipoDocumento=$mysqli->query("SELECT prefijo,id FROM tipoDocumento WHERE id='".$extraer_consulta_documento['tipo_documento']."' ");
                                        $extraerNombreTipoDocumentoConsulDocum=$consultaTipoDocumento->fetch_array(MYSQLI_ASSOC);
                                        $prefijoTipo=$extraerNombreTipoDocumentoConsulDocum['prefijo'];
                                        //// consultamos el prefijo del proceso para traerlo
                                        $consultaProceso=$mysqli->query("SELECT id,prefijo FROM procesos WHERE id='".$extraer_consulta_documento['proceso']."' ");
                                        $extraerNombreProcesoConsulDocum=$consultaProceso->fetch_array(MYSQLI_ASSOC);
                                        $prefijoProceso=$extraerNombreProcesoConsulDocum['prefijo'];
                                        
                                        /// traemos el consecutivo y version temporal para mostrar antes de ser verificado nuevamente
                                        $consecutivo=$extraer_consulta_documento['consecutivoTemporal'];
                                        $version=$extraer_consulta_documento['versionTemporal'];
                                        
                                        //echo $recorridoDocumentos['codificacion'];
                                        
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
                                            }
        
        
        
                    $mysqli->query("UPDATE documento SET pre = NULL, codificacion='$codificacion', consecutivo='$consecutivo', version='$version' WHERE pre='si' AND id='".$_POST['idDocumento']."' ");
                    $mysqli->query("UPDATE solicitudDocumentos SET estado ='Ejecutado' WHERE id='".$_POST['idSolicitudDocumento']."' ");
                   
                    'se registra';
                    ?>
                        <script> 
                             window.onload=function(){
                           
                                document.forms["miformularioRegistrado"].submit();
                             }
                        </script>
                         
                        <form name="miformularioRegistrado" action="../../crearDocumentoMasivoObsoleto" method="POST" onsubmit="procesar(this.action);" >
                            <input name="validacionAgregarD" value="1" type="hidden">
                        </form> 
                    <?php
    }
    
    
}


if(isset($_POST['cancelar'])){ /// se rechaza la solicitud y se elimina el documento
            date_default_timezone_set("America/Bogota");
            $estado = "Rechazado";
            $aprobado_aprueba = 0;
            $fechaCierre =  date("Y/m/j");
            $idSolicitud = $datosDoc1['id_solicitud'];
            
            $mysqli->query("UPDATE solicitudDocumentos SET estado = '$estado', fechaCierre = '$fechaCierre' WHERE id='".$_POST['idSolicitudDocumento']."' ")or die(mysqli_error($mysqli));
            $mysqli->query("DELETE FROM documento WHERE id='".$_POST['idDocumento']."' ");   
            ?>
                        <script> 
                             window.onload=function(){
                           
                                document.forms["miformulario"].submit();
                             }
                        </script>
                         
                        <form name="miformulario" action="../../crearDocumentoMasivoObsoleto" method="POST" onsubmit="procesar(this.action);" >
                            <input name="validacionEliminar" value="1" type="hidden">
                        </form> 
            <?php
}

//END
?>