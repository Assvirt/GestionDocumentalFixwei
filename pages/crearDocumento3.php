<?php
error_reporting(E_ERROR);
session_start();
date_default_timezone_set("America/Bogota");
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
require_once 'conexion/bd.php';
    
    $idSolicitud = $_POST['idSolicitud'];
    $nombreDoc = $_POST['nombreDocumento'];
    $norma = $_POST['norma'];
    $proceso = $_POST['proceso'];
    $metodo = $_POST['rad_metodo'];
    $tipoDoc = $_POST['tipoDoc'];
    $ubicacion = $_POST['ubicacion'];
    $elabora = $_POST['select_encargadoE'];
    $revisa = $_POST['select_encargadoR'];
    $aprueba = $_POST['select_encargadoA'];
    $radElabora = $_POST['radiobtnE'];
    $radRevisa = $_POST['radiobtnR'];
    $radAprueba = $_POST['radiobtnA'];
    $codificacion = $_POST['radCodificacion'];
    $versionDeclarada = $_POST['versionDeclarada'];
    $consecutivoDeclarada = $_POST['consecutivoDeclarado'];
    
    
    $html = htmlentities($_POST['editor1']);
    
     '1: '.$nombrePDF = $_FILES['archivopdf']['name']; 
    $rutaPDF =$_FILES['archivopdf']['tmp_name']; 
     '<br>2: '.$nombreOtro =$_FILES['archivootro']['name'];
    $rutaOtro =$_FILES['archivootro']['tmp_name'];
    
    $documetosExternos = $_POST['documentos_externos'];
    $definiciones = $_POST['definiciones'];
    
    $archivo_gestion = $_POST['archivo_gestion']; 
    $archivo_central = $_POST['archivo_central']; 
    $archivo_historico = $_POST['archivo_historico']; 
    
    $diposicion_documental = $_POST['diposicion_documental'];
    $select_encargadoD = $_POST['select_encargadoD'];
    $radDispoDoc = $_POST['radiobtnD'];

    $fecha = date("Ymjhis");

    $rol = "Encargado(a) solicitud";


    if(!file_exists('archivos/documentos/')){
    	mkdir('archivos/documentos',0777,true);
    	if(file_exists('archivos/documentos/')){
    		if(move_uploaded_file($rutaPDF, 'archivos/documentos/'.$fecha.$nombrePDF)){
    			
    		}else{
    			 "Archivo no se pudo guardar";
    		}
    	}
    }else{
    	if(move_uploaded_file($rutaPDF, 'archivos/documentos/'.$fecha.$nombrePDF)){
    	    
    	     "Archivo guardado con exito - acá se hace la validación PDF ";
    	    
    	    if($nombrePDF != NULL){ 
    	        
    	        
    	        /// volvemos el texto totalmente en minuscula
                $validandoDocumentoCaracteresPdf=mb_strtolower($nombrePDF);
                
                $activarAlerta=TRUE;
                
    	        $descripcion_carecteres = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ0123456789-_,.()/ ";
                for ($i=0; $i<strlen($validandoDocumentoCaracteresPdf); $i++){
                    if (strpos($descripcion_carecteres, substr($validandoDocumentoCaracteresPdf,$i,1))===false){
                        $validandoDocumentoCaracteresPdf . " no es válido<br>";
                        $activarAlerta=FALSE;
                        //return false;
                    }
                }
    	        
    	        if($activarAlerta == FALSE){ 
    	             $idSolicitud = $_POST['idSolicitud'];
                                $nombreDoc = $_POST['nombreDocumento'];
                                $norma2 = $_POST['norma'];
                                $proceso = $_POST['proceso'];
                                $metodo = $_POST['rad_metodo'];
                                $tipoDoc = $_POST['tipoDoc'];
                                $ubicacion = $_POST['ubicacion'];
                                $elabora2 = $_POST['select_encargadoE'];
                                $revisa2 = $_POST['select_encargadoR'];
                                $aprueba2 = $_POST['select_encargadoA'];
                                $codificacion = $_POST['radCodificacion'];
                                $versionDeclarada = $_POST['versionDeclarada'];
                                $consecutivoDeclarada = $_POST['consecutivoDeclarado']; 
                                
                                $radElabora = $_POST['radiobtnE'];
                                $radRevisa = $_POST['radiobtnR'];
                                $radAprueba = $_POST['radiobtnA'];
                                $rol = $_POST['rol'];
                                
                                $documetosExternos = serialize($_POST['documentos_externos']);
                                $documetosExternosAlm = unserialize($documetosExternos);
                                $documetosExternosAlm = json_encode($documetosExternosAlm);
                                
                                $definiciones = serialize($_POST['definiciones']);
                                $definicionesAlm = unserialize($definiciones);
                                $definicionesAlm = json_encode($definicionesAlm);
                                
                                $enviarRespnsableEncargado=serialize($_POST['select_encargadoD']);
                                $escargadoDispo = unserialize($enviarRespnsableEncargado);
                                $radDispoDoc = $_POST['radiobtnD'];
                                array_unshift($escargadoDispo,$radDispoDoc); 
                                $escargadoDispo = json_encode($escargadoDispo);
                                
                                
                                /// guardamos los datos de definiciones de manera temporal
                                $consultamosExistenciaParametros=$mysqli->query("SELECT * FROM documentoDatosTemporales WHERE solicitud='$idSolicitud' ");
                                $extraerConsultamosExistenciaParametros=$consultamosExistenciaParametros->fetch_array(MYSQLI_ASSOC);
                                
                                if($extraerConsultamosExistenciaParametros['id'] != NULL){
                                $mysqli->query("UPDATE documentoDatosTemporales SET definicion='$definicionesAlm' , externo='$documetosExternosAlm', responsable='$escargadoDispo' WHERE solicitud='$idSolicitud' ");
                                }else{
                                $mysqli->query("INSERT INTO documentoDatosTemporales (solicitud,definicion,externo,responsable)VALUES('$idSolicitud','".$definicionesAlm."','".$documetosExternosAlm."','".$escargadoDispo."') ");
                                } 
    	            ?>
                                <script> 
                                    window.onload=function(){
                                        document.forms["miformularioPdf"].submit();
                                    }
                                    setTimeout(clickbuttonPDF, 2000);
                                    function clickbuttonPDF() { 
                                             document.forms["miformularioPdf"].submit();
                                    }
                                </script>
                                         
                                <form name="miformularioPdf" action="crearDocumento2" method="POST" onsubmit="procesar(this.action);" >
                                    <input type="hidden" name="rol" value="<?php echo $rol;?>"> 
                                    <input type="hidden" name="idSolicitud" value="<?php echo $idSolicitud ;?>" >
                                    <input type="hidden" name="nombreDocumento" value="<?php echo $nombreDoc ;?>" >
                                    <input type="hidden" name="normaRT" value='<?php echo $norma2;?>' >
                                    <input type="hidden" name="proceso" value="<?php echo $proceso ;?>" >
                                    <input type="hidden" name="rad_metodo" value="<?php echo $metodo ;?>" >
                                    <input type="hidden" name="tipoDoc" value="<?php echo $tipoDoc ;?>" >
                                    <input type="hidden" name="ubicacion" value="<?php echo $ubicacion ;?>" >
                                    <input type="hidden" name="select_encargadoERT" value='<?php echo $elabora2;?>' >
                                    <input type="hidden" name="select_encargadoRRT" value='<?php echo $revisa2;?>' >
                                    <input type="hidden" name="select_encargadoART" value='<?php echo $aprueba2;?>' >
                                    <input type="hidden" name="radCodificacion" value="<?php echo $codificacion;?>">
                                    <input type="hidden" name="radCodificacion" value="<?php echo $codificacion;?>">
                                    <input type="hidden" name="versionDeclarada" value="<?php echo $versionDeclarada;?>">
                                    <input type="hidden" name="consecutivoDeclarado" value="<?php echo $consecutivoDeclarada;?>">
                                    
                                    <input type="hidden" name="radiobtnE" value="<?php echo $radElabora; ?>">
                                    <input type="hidden" name="radiobtnR" value="<?php echo $radRevisa; ?>">
                                    <input type="hidden" name="radiobtnA" value="<?php echo $radAprueba; ?>">
                                    
                                    <input type="hidden" name="archivo_gestion" value="<?php echo $archivo_gestion ;?>">
                                    <input type="hidden" name="archivo_central" value="<?php echo $archivo_central ;?>">
                                    <input type="hidden" name="archivo_historico" value="<?php echo $archivo_historico ;?>">
                                    <input type="hidden" name="diposicion_documental" value="<?php echo $diposicion_documental ;?>">
                                    
                                    
                                    <input name="alerta" value="1" type="hidden">
                                    <!--<input type="submit" value="1">-->
                                   
                                </form> 
                                <?php
    	        }else{
    	        
    	        
    	        
    		    $mysqli->query("INSERT INTO documentoArchivoTemporal (pdf,solicitud)VALUES('".utf8_decode($fecha.$nombrePDF)."','$idSolicitud') "); 
    		    
    		    $preguntadoValidacion=$mysqli->query("SELECT * FROM documentoArchivoTemporal WHERE  pdf='".utf8_decode($fecha.$nombrePDF)."' ");
        		$extraerPreguntaValidacion=$preguntadoValidacion->fetch_array(MYSQLI_ASSOC);
        		    ' - '.$documentoExtraido2=utf8_encode($extraerPreguntaValidacion['pdf']);
        		    
        		        
                
                        //echo '<br><br>';
                
                        //Lista de letras abecedario
                        $carpeta="archivos/documentos/";
                        $ruta="/".$carpeta."/";
                        $directorio=opendir($carpeta);
                        //recoger los  datos
                        $datos=array();
                        $conteoArchivosB=0;
                        while ($archivo = readdir($directorio)) { 
                          if(($archivo != '.')&&($archivo != '..')){
                             
                            if($documentoExtraido2 == $datos[]=$archivo){
                                $conteoArchivosB++;
                                 $datos[]=$archivo; //echo '<br>';
                            }
                             
                             
                          } 
                        }
                        closedir($directorio);
                            
                        if($conteoArchivosB > 0){
                           $documentoHabilitado2='1'; 
                        }else{
                           $documentoHabilitado2='no coincide';
                        }
                         '<br>B: '.$documentoHabilitado2;
                           if($documentoHabilitado2 == 1){ 
    	       
                    	   }else{ //echo 'Redir..';
                    	        $idSolicitud = $_POST['idSolicitud'];
                                $nombreDoc = $_POST['nombreDocumento'];
                                $norma2 = $_POST['norma'];
                                $proceso = $_POST['proceso'];
                                $metodo = $_POST['rad_metodo'];
                                $tipoDoc = $_POST['tipoDoc'];
                                $ubicacion = $_POST['ubicacion'];
                                $elabora2 = $_POST['select_encargadoE'];
                                $revisa2 = $_POST['select_encargadoR'];
                                $aprueba2 = $_POST['select_encargadoA'];
                                $codificacion = $_POST['radCodificacion'];
                                $versionDeclarada = $_POST['versionDeclarada'];
                                $consecutivoDeclarada = $_POST['consecutivoDeclarado']; 
                                
                                $radElabora = $_POST['radiobtnE'];
                                $radRevisa = $_POST['radiobtnR'];
                                $radAprueba = $_POST['radiobtnA'];
                                $rol = $_POST['rol'];
                                
                                $documetosExternos = serialize($_POST['documentos_externos']);
                                $documetosExternosAlm = unserialize($documetosExternos);
                                $documetosExternosAlm = json_encode($documetosExternosAlm);
                                
                                $definiciones = serialize($_POST['definiciones']);
                                $definicionesAlm = unserialize($definiciones);
                                $definicionesAlm = json_encode($definicionesAlm);
                                
                                $enviarRespnsableEncargado=serialize($_POST['select_encargadoD']);
                                $escargadoDispo = unserialize($enviarRespnsableEncargado);
                                $radDispoDoc = $_POST['radiobtnD'];
                                array_unshift($escargadoDispo,$radDispoDoc); 
                                $escargadoDispo = json_encode($escargadoDispo);
                                
                                
                                /// guardamos los datos de definiciones de manera temporal
                                $consultamosExistenciaParametros=$mysqli->query("SELECT * FROM documentoDatosTemporales WHERE solicitud='$idSolicitud' ");
                                $extraerConsultamosExistenciaParametros=$consultamosExistenciaParametros->fetch_array(MYSQLI_ASSOC);
                                
                                if($extraerConsultamosExistenciaParametros['id'] != NULL){
                                $mysqli->query("UPDATE documentoDatosTemporales SET definicion='$definicionesAlm' , externo='$documetosExternosAlm', responsable='$escargadoDispo' WHERE solicitud='$idSolicitud' ");
                                }else{
                                $mysqli->query("INSERT INTO documentoDatosTemporales (solicitud,definicion,externo,responsable)VALUES('$idSolicitud','".$definicionesAlm."','".$documetosExternosAlm."','".$escargadoDispo."') ");
                                } 
                    	        ?>
                                <script> 
                                     window.onload=function(){
                                        document.forms["miformularioDocumentoMal"].submit();
                                     }
                                     setTimeout(clickbuttonPDF2, 1000);
                                    function clickbuttonPDF2() { 
                                             document.forms["miformularioDocumentoMal"].submit();
                                    }
                                </script>
                                         
                                <form name="miformularioDocumentoMal" action="crearDocumento2" method="POST" onsubmit="procesar(this.action);" >
                                    <input type="hidden" name="rol" value="<?php echo $rol;?>"> 
                                    <input type="hidden" name="idSolicitud" value="<?php echo $idSolicitud ;?>" >
                                    <input type="hidden" name="nombreDocumento" value="<?php echo $nombreDoc ;?>" >
                                    <input type="hidden" name="normaRT" value='<?php echo $norma2;?>' >
                                    <input type="hidden" name="proceso" value="<?php echo $proceso ;?>" >
                                    <input type="hidden" name="rad_metodo" value="<?php echo $metodo ;?>" >
                                    <input type="hidden" name="tipoDoc" value="<?php echo $tipoDoc ;?>" >
                                    <input type="hidden" name="ubicacion" value="<?php echo $ubicacion ;?>" >
                                    <input type="hidden" name="select_encargadoERT" value='<?php echo $elabora2;?>' >
                                    <input type="hidden" name="select_encargadoRRT" value='<?php echo $revisa2;?>' >
                                    <input type="hidden" name="select_encargadoART" value='<?php echo $aprueba2;?>' >
                                    <input type="hidden" name="radCodificacion" value="<?php echo $codificacion;?>">
                                    <input type="hidden" name="radCodificacion" value="<?php echo $codificacion;?>">
                                    <input type="hidden" name="versionDeclarada" value="<?php echo $versionDeclarada;?>">
                                    <input type="hidden" name="consecutivoDeclarado" value="<?php echo $consecutivoDeclarada;?>">
                                    
                                    <input type="hidden" name="radiobtnE" value="<?php echo $radElabora; ?>">
                                    <input type="hidden" name="radiobtnR" value="<?php echo $radRevisa; ?>">
                                    <input type="hidden" name="radiobtnA" value="<?php echo $radAprueba; ?>">
                                    
                                    <input type="hidden" name="archivo_gestion" value="<?php echo $archivo_gestion ;?>">
                                    <input type="hidden" name="archivo_central" value="<?php echo $archivo_central ;?>">
                                    <input type="hidden" name="archivo_historico" value="<?php echo $archivo_historico ;?>">
                                    <input type="hidden" name="diposicion_documental" value="<?php echo $diposicion_documental ;?>">
                                    
                                    
                                    
                                    <input name="alerta2" value="1" type="hidden">
                                    <!--<input type="submit" value="1">-->
                                   
                                </form> 
                                <?php
                    	   }
    	    }
        		    
    		}
    	    
    	    
    	}else{
    		 "Archivo no se pudo guardar";
    	}
    }
    
    if(!file_exists('archivos/documentos/')){
    	mkdir('archivos/documentos',0777,true);
    	if(file_exists('archivos/documentos/')){
    		if(move_uploaded_file($rutaOtro, 'archivos/documentos/'.$fecha.$nombreOtro)){
    			 "Archivo guardado con exito";
    			
    		}else{
    			 "Archivo no se pudo guardar";
    		}
    	}
    }else{
    	if(move_uploaded_file($rutaOtro, 'archivos/documentos/'.$fecha.$nombreOtro)){
    		 "Archivo guardado con exito - acá se hace la validación WORD";
    		
    		
    		
    		//// realizamos un ingreso del archivo de manera temporal para poder verificar si es un documento bien o mal
    		
    		if($nombreOtro != NULL){ 
    		    
    		    
    		    
    		    /// volvemos el texto totalmente en minuscula
                $validandoDocumentoCaractereseditable=mb_strtolower($nombreOtro);
                
                
                $activarAlerta=TRUE;
                /*$descripcion_carecteres=["'"];
                for($bc=0; $bc<count($descripcion_carecteres); $bc++){
                    $descripcion_carecteres[$bc]; 
                     $cadena_carecteres_descripcion = $descripcion_carecteres[$bc];
                     ' - '.$coincidencia_caracteres= strpos($validandoDocumentoCaractereseditable, $cadena_carecteres_descripcion);
                    if($coincidencia_caracteres != NULL){
                        $activarAlerta=FALSE;
                    }    
                }*/
                
                $permitidosNombreOtro = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ0123456789-_,.()/ ";
                for ($i=0; $i<strlen($validandoDocumentoCaractereseditable); $i++){
                    if (strpos($permitidosNombreOtro, substr($validandoDocumentoCaractereseditable,$i,1))===false){
                        $validandoDocumentoCaractereseditable . " no es válido<br>";
                        $activarAlerta=FALSE;
                        //return false;
                    }
                }
    	        
    	        if($activarAlerta == FALSE){
    	             $idSolicitud = $_POST['idSolicitud'];
                                $nombreDoc = $_POST['nombreDocumento'];
                                $norma2 = $_POST['norma'];
                                $proceso = $_POST['proceso'];
                                $metodo = $_POST['rad_metodo'];
                                $tipoDoc = $_POST['tipoDoc'];
                                $ubicacion = $_POST['ubicacion'];
                                $elabora2 = $_POST['select_encargadoE'];
                                $revisa2 = $_POST['select_encargadoR'];
                                $aprueba2 = $_POST['select_encargadoA'];
                                $codificacion = $_POST['radCodificacion'];
                                $versionDeclarada = $_POST['versionDeclarada'];
                                $consecutivoDeclarada = $_POST['consecutivoDeclarado']; 
                                
                                $radElabora = $_POST['radiobtnE'];
                                $radRevisa = $_POST['radiobtnR'];
                                $radAprueba = $_POST['radiobtnA'];
                                $rol = $_POST['rol'];
                                
                                $documetosExternos = serialize($_POST['documentos_externos']);
                                $documetosExternosAlm = unserialize($documetosExternos);
                                $documetosExternosAlm = json_encode($documetosExternosAlm);
                                
                                $definiciones = serialize($_POST['definiciones']);
                                $definicionesAlm = unserialize($definiciones);
                                $definicionesAlm = json_encode($definicionesAlm);
                                
                                $enviarRespnsableEncargado=serialize($_POST['select_encargadoD']);
                                $escargadoDispo = unserialize($enviarRespnsableEncargado);
                                $radDispoDoc = $_POST['radiobtnD'];
                                array_unshift($escargadoDispo,$radDispoDoc); 
                                $escargadoDispo = json_encode($escargadoDispo);
                                
                                /// guardamos los datos de definiciones de manera temporal
                                $consultamosExistenciaParametros=$mysqli->query("SELECT * FROM documentoDatosTemporales WHERE solicitud='$idSolicitud' ");
                                $extraerConsultamosExistenciaParametros=$consultamosExistenciaParametros->fetch_array(MYSQLI_ASSOC);
                                
                                if($extraerConsultamosExistenciaParametros['id'] != NULL){
                                $mysqli->query("UPDATE documentoDatosTemporales SET definicion='$definicionesAlm' , externo='$documetosExternosAlm', responsable='$escargadoDispo' WHERE solicitud='$idSolicitud' ");
                                }else{
                                $mysqli->query("INSERT INTO documentoDatosTemporales (solicitud,definicion,externo,responsable)VALUES('$idSolicitud','".$definicionesAlm."','".$documetosExternosAlm."','".$escargadoDispo."') ");
                                } 
                    	        ?>
                                <script> 
                                     window.onload=function(){
                                   
                                         document.forms["miformularioeditable"].submit();
                                     }
                                     setTimeout(clickbuttonPDF3, 2000);
                                    function clickbuttonPDF3() { 
                                             document.forms["miformularioeditable"].submit();
                                    }
                                </script>
                                         
                                <form name="miformularioeditable" action="crearDocumento2" method="POST" onsubmit="procesar(this.action);" >
                                    <input type="hidden" name="rol" value="<?php echo $rol;?>"> 
                                    <input type="hidden" name="idSolicitud" value="<?php echo $idSolicitud ;?>" >
                                    <input type="hidden" name="nombreDocumento" value="<?php echo $nombreDoc ;?>" >
                                    <input type="hidden" name="normaRT" value='<?php echo $norma2;?>' >
                                    <input type="hidden" name="proceso" value="<?php echo $proceso ;?>" >
                                    <input type="hidden" name="rad_metodo" value="<?php echo $metodo ;?>" >
                                    <input type="hidden" name="tipoDoc" value="<?php echo $tipoDoc ;?>" >
                                    <input type="hidden" name="ubicacion" value="<?php echo $ubicacion ;?>" >
                                    <input type="hidden" name="select_encargadoERT" value='<?php echo $elabora2;?>' >
                                    <input type="hidden" name="select_encargadoRRT" value='<?php echo $revisa2;?>' >
                                    <input type="hidden" name="select_encargadoART" value='<?php echo $aprueba2;?>' >
                                    <input type="hidden" name="radCodificacion" value="<?php echo $codificacion;?>">
                                    <input type="hidden" name="radCodificacion" value="<?php echo $codificacion;?>">
                                    <input type="hidden" name="versionDeclarada" value="<?php echo $versionDeclarada;?>">
                                    <input type="hidden" name="consecutivoDeclarado" value="<?php echo $consecutivoDeclarada;?>">
                                    
                                    <input type="hidden" name="radiobtnE" value="<?php echo $radElabora; ?>">
                                    <input type="hidden" name="radiobtnR" value="<?php echo $radRevisa; ?>">
                                    <input type="hidden" name="radiobtnA" value="<?php echo $radAprueba; ?>">
                                    
                                    <input type="hidden" name="archivo_gestion" value="<?php echo $archivo_gestion ;?>">
                                    <input type="hidden" name="archivo_central" value="<?php echo $archivo_central ;?>">
                                    <input type="hidden" name="archivo_historico" value="<?php echo $archivo_historico ;?>">
                                    <input type="hidden" name="diposicion_documental" value="<?php echo $diposicion_documental ;?>">
                                    
                                    
                                    <input name="alerta" value="1" type="hidden">
                                    <!--<input type="submit" value="1">-->
                                   
                                </form>  
                                <?php
    	        }else{
    		    
    		    
    		    
    		     '<br>Ruta ingresar: '.utf8_decode($fecha.$nombreOtro);
    		    $mysqli->query("INSERT INTO documentoArchivoTemporal (otro,solicitud)VALUES('".utf8_decode($fecha.$nombreOtro)."','$idSolicitud') ")or die(mysqli_error($mysqli)); 
    		    
    		    $preguntadoValidacion=$mysqli->query("SELECT * FROM documentoArchivoTemporal WHERE otro='".utf8_decode($fecha.$nombreOtro)."' ");
        		$extraerPreguntaValidacion=$preguntadoValidacion->fetch_array(MYSQLI_ASSOC);
        		    $documentoExtraido=utf8_encode($extraerPreguntaValidacion['otro']);
        		    
        		        
                
                         '<br><br>';
                
                        //Lista de letras abecedario
                        $carpeta="archivos/documentos/";
                        $ruta="/".$carpeta."/";
                        $directorio=opendir($carpeta);
                        //recoger los  datos
                        $datos=array();
                        $conteoArchivos=0;
                        while ($archivo = readdir($directorio)) { 
                          if(($archivo != '.')&&($archivo != '..')){
                             
                            if($documentoExtraido == $datos[]=$archivo){
                                $conteoArchivos++;
                                 $datos[]=$archivo; //echo '<br>';
                            }
                             
                             
                          } 
                        }
                        closedir($directorio);
                            
                        if($conteoArchivos > 0){
                           $documentoHabilitado='1'; 
                        }else{
                           $documentoHabilitado='no coincide';
                        }
    		    }    
    		}
    		
    		
    		
    		///// validmos nuevamente el subir documento con caracteres especiales, parar evitar el error_fatal de codificacion
    		/// volvemos el texto totalmente en minuscula
                $validandoDocumentoCaracteresPdf_correcion=mb_strtolower($nombrePDF);
                
                $activarAlerta_correcion=TRUE;
                
    	        $descripcion_carecteres_correcion = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ0123456789-_,.()/ ";
                for ($i=0; $i<strlen($validandoDocumentoCaracteresPdf_correcion); $i++){
                    if (strpos($descripcion_carecteres_correcion, substr($validandoDocumentoCaracteresPdf_correcion,$i,1))===false){
                        $validandoDocumentoCaracteresPdf_correcion . " no es válido<br>";
                        $activarAlerta_correcion=FALSE;
                        //return false;
                    }
                }
    		
    		
    		if($activarAlerta_correcion == FALSE){ }else{
    		
    		if($nombrePDF != NULL){ 
    		    $mysqli->query("INSERT INTO documentoArchivoTemporal (pdf,solicitud)VALUES('".utf8_decode($fecha.$nombrePDF)."','$idSolicitud') "); 
    		    
    		    $preguntadoValidacion=$mysqli->query("SELECT * FROM documentoArchivoTemporal WHERE  pdf='".utf8_decode($fecha.$nombrePDF)."' ");
        		$extraerPreguntaValidacion=$preguntadoValidacion->fetch_array(MYSQLI_ASSOC);
        		    ' - '.$documentoExtraido2=utf8_encode($extraerPreguntaValidacion['pdf']);
        		    
        		        
                
                         '<br><br>';
                
                        //Lista de letras abecedario
                        $carpeta="archivos/documentos/";
                        $ruta="/".$carpeta."/";
                        $directorio=opendir($carpeta);
                        //recoger los  datos
                        $datos=array();
                        $conteoArchivosB=0;
                        while ($archivo = readdir($directorio)) { 
                          if(($archivo != '.')&&($archivo != '..')){
                             
                            if($documentoExtraido2 == $datos[]=$archivo){
                                $conteoArchivosB++;
                                 $datos[]=$archivo; //echo '<br>';
                            }
                             
                             
                          } 
                        }
                        closedir($directorio);
                            
                        if($conteoArchivosB > 0){
                           $documentoHabilitado2='1'; 
                        }else{
                           $documentoHabilitado2='no coincide';
                        }
        		    
    		}
    		
    		}
    		
    	    'A: '.$documentoHabilitado;
    	    '<br>B: '.$documentoHabilitado2;
    	   
    	   
    	   
    	   if($documentoHabilitado == 1 && $documentoHabilitado2 == 1){ 
    	       
    	   }elseif($documentoHabilitado == 1 && $nombrePDF == NULL){ 
    	       
    	   }elseif($documentoHabilitado2 == 1 && $nombreOtro == NULL){ 
    	       
    	   }else{ //echo 'Redir..';
                    	        $idSolicitud = $_POST['idSolicitud'];
                                $nombreDoc = $_POST['nombreDocumento'];
                                $norma2 = $_POST['norma'];
                                $proceso = $_POST['proceso'];
                                $metodo = $_POST['rad_metodo'];
                                $tipoDoc = $_POST['tipoDoc'];
                                $ubicacion = $_POST['ubicacion'];
                                $elabora2 = $_POST['select_encargadoE'];
                                $revisa2 = $_POST['select_encargadoR'];
                                $aprueba2 = $_POST['select_encargadoA'];
                                $codificacion = $_POST['radCodificacion'];
                                $versionDeclarada = $_POST['versionDeclarada'];
                                $consecutivoDeclarada = $_POST['consecutivoDeclarado']; 
                                
                                $radElabora = $_POST['radiobtnE'];
                                $radRevisa = $_POST['radiobtnR'];
                                $radAprueba = $_POST['radiobtnA'];
                                $rol = $_POST['rol'];
                                
                                $documetosExternos = serialize($_POST['documentos_externos']);
                                $documetosExternosAlm = unserialize($documetosExternos);
                                $documetosExternosAlm = json_encode($documetosExternosAlm);
                                
                                $definiciones = serialize($_POST['definiciones']);
                                $definicionesAlm = unserialize($definiciones);
                                $definicionesAlm = json_encode($definicionesAlm);
                                
                                $enviarRespnsableEncargado=serialize($_POST['select_encargadoD']);
                                $escargadoDispo = unserialize($enviarRespnsableEncargado);
                                $radDispoDoc = $_POST['radiobtnD'];
                                array_unshift($escargadoDispo,$radDispoDoc); 
                                $escargadoDispo = json_encode($escargadoDispo);
                                
                                /// guardamos los datos de definiciones de manera temporal
                                $consultamosExistenciaParametros=$mysqli->query("SELECT * FROM documentoDatosTemporales WHERE solicitud='$idSolicitud' ");
                                $extraerConsultamosExistenciaParametros=$consultamosExistenciaParametros->fetch_array(MYSQLI_ASSOC);
                                
                                if($extraerConsultamosExistenciaParametros['id'] != NULL){
                                $mysqli->query("UPDATE documentoDatosTemporales SET definicion='$definicionesAlm' , externo='$documetosExternosAlm', responsable='$escargadoDispo' WHERE solicitud='$idSolicitud' ");
                                }else{
                                $mysqli->query("INSERT INTO documentoDatosTemporales (solicitud,definicion,externo,responsable)VALUES('$idSolicitud','".$definicionesAlm."','".$documetosExternosAlm."','".$escargadoDispo."') ");
                                }
                    	        ?>
                                <script> 
                                     window.onload=function(){
                                   
                                         document.forms["miformulario"].submit();
                                     }
                                </script>
                                         
                                <form name="miformulario" action="crearDocumento2" method="POST" onsubmit="procesar(this.action);" >
                                    <input type="hidden" name="rol" value="<?php echo $rol;?>"> 
                                    <input type="hidden" name="idSolicitud" value="<?php echo $idSolicitud ;?>" >
                                    <input type="hidden" name="nombreDocumento" value="<?php echo $nombreDoc ;?>" >
                                    <input type="hidden" name="normaRT" value='<?php echo $norma2;?>' >
                                    <input type="hidden" name="proceso" value="<?php echo $proceso ;?>" >
                                    <input type="hidden" name="rad_metodo" value="<?php echo $metodo ;?>" >
                                    <input type="hidden" name="tipoDoc" value="<?php echo $tipoDoc ;?>" >
                                    <input type="hidden" name="ubicacion" value="<?php echo $ubicacion ;?>" >
                                    <input type="hidden" name="select_encargadoERT" value='<?php echo $elabora2;?>' >
                                    <input type="hidden" name="select_encargadoRRT" value='<?php echo $revisa2;?>' >
                                    <input type="hidden" name="select_encargadoART" value='<?php echo $aprueba2;?>' >
                                    <input type="hidden" name="radCodificacion" value="<?php echo $codificacion;?>">
                                    <input type="hidden" name="radCodificacion" value="<?php echo $codificacion;?>">
                                    <input type="hidden" name="versionDeclarada" value="<?php echo $versionDeclarada;?>">
                                    <input type="hidden" name="consecutivoDeclarado" value="<?php echo $consecutivoDeclarada;?>">
                                    
                                    <input type="hidden" name="radiobtnE" value="<?php echo $radElabora; ?>">
                                    <input type="hidden" name="radiobtnR" value="<?php echo $radRevisa; ?>">
                                    <input type="hidden" name="radiobtnA" value="<?php echo $radAprueba; ?>">
                                    
                                    <input type="hidden" name="archivo_gestion" value="<?php echo $archivo_gestion ;?>">
                                    <input type="hidden" name="archivo_central" value="<?php echo $archivo_central ;?>">
                                    <input type="hidden" name="archivo_historico" value="<?php echo $archivo_historico ;?>">
                                    <input type="hidden" name="diposicion_documental" value="<?php echo $diposicion_documental ;?>">
                                    
                                    
                                    <input name="alerta2" value="1" type="hidden">
                                   
                                </form> 
                                <?php
                    	   }
    		
    		//// END
    		
    		
    	}else{
    		 "Archivo no se pudo guardar";
    	}
    }
    
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Asignar documento</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="../plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!--CKeditor-->
  <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
  
</head>
<script>
   	
    function nobackbutton(){
    	
       window.location.hash="no-back-button";
    	
       window.location.hash="Again-No-back-button" //chrome
    	
       window.onhashchange=function(){window.location.hash="no-back-button";}
    	
    }
</script>
<body class="hold-transition sidebar-mini" oncopy="return false" onpaste="return false" onload="nobackbutton();">
<div class="wrapper">


  <!-- Main Sidebar Container -->
  <?php echo require_once'menu.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Asignar documento</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Asignar documento</li>
            </ol>
          </div>
        </div>
        <!--<div class="row">
            <div class="col">
            </div>
            <div class="col-9">
                <div class="row">
                    <div class="col-sm">
                        <button type="button" class="btn btn-block btn-success btn-sm"><a href="crearDocumento2"><font color="white"><i class="fas fa-chevron-left"></i> Regresar</font></a></button>
                    </div>
                    <div class="col-sm">
                    </div>
                    <div class="col-sm">
                    </div>
                    <div class="col-sm">
                    </div>
                    <div class="col-sm">
                    </div>
                </div>
            </div>
            <div class="col">
            </div>   
        </div>-->
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
            <div class="col">
            </div>
            <div class="col-9">
                
                <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start controlador/documentos/controllerDocumentos -->
              <form role="form" action="controlador/documentos/controllerDocumentos" method="POST" onsubmit="return checkSubmit();">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label>Flujo de aprobación</label>
                            <!--<br>
                            <input type="radio" id="rad_flujo" name="rad_flujo" value="reinicia" required>
                            <label>Regresa flujo de aprobación</label>-->
                            <br>
                            <input type="radio" id="rad_reinicio" name="rad_flujo" value="ajusta" checked required>
                            <label>Ajusta y continua flujo de aprobación</label>
                            <br>
                            <input type="radio" id="rad_cierra" name="rad_flujo" value="cierra" required>
                            <label>Cierra solicitud documental</label>
                        </div>
                        
                        <div class="form-group col-sm-6">
                            <label>Meses para próxima revisión</label>
                            <input name="mesesRevision" type="number" min="1" max="24" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                        </div>
                        
                        <div class="form-group col-sm-12">
                            
                            <label>Comentarios: </label>
                            <textarea rows="2" class="form-control" name="controlCambios" onkeypress="return (event.charCode == 58 || event.charCode == 59 || event.charCode == 13 || (event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" placeholder="Comentarios"></textarea>
                            <br>
                            
                            
                            <input type="radio" id="aprobado" name="radiobtnAprobado" value="aprobado"  required>
                            <label id="tituloAprobado"> Aprobado</label>
                            
                            <input style="display:none;" type="radio" id="rechazado" name="radiobtnAprobado" value="rechazado" required>
                            <label style="display:none;" id="tituloRechazado"> Rechazado</label>
                        
                        </div>
                        
                    </div>
        
                  <!--
                  
                  ACA SE AGREGAN ELEMENTOS NUEVOS
                  
                  SE PUEDE EXTRAER DE: 
                  https://fixwei.com/plataforma/pages/forms/general.html
                  https://fixwei.com/plataforma/pages/forms/advanced.html
                  https://fixwei.com/plataforma/pages/forms/editors.html
                  
                  -->
                  
                  
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                    <!--Envio variables ocultas-->
                    <input type="hidden" name="rol" value="<?php echo $rol;?>"> 
                    <input type="hidden" name="idSolicitud" value="<?php echo $idSolicitud ;?>" >
                    <input type="hidden" name="nombreDocumento" value="<?php echo $nombreDoc ;?>" >
                    <input type="hidden" name="norma" value='<?php echo $norma;?>' >
                    <input type="hidden" name="proceso" value="<?php echo $proceso ;?>" >
                    <input type="hidden" name="rad_metodo" value="<?php echo $metodo ;?>" >
                    <input type="hidden" name="tipoDoc" value="<?php echo $tipoDoc ;?>" >
                    <input type="hidden" name="ubicacion" value="<?php echo $ubicacion ;?>" >
                    <input type="hidden" name="select_encargadoE" value='<?php echo $elabora ;?>' >
                    <input type="hidden" name="select_encargadoR" value='<?php echo $revisa ;?>' >
                    <input type="hidden" name="select_encargadoA" value='<?php echo $aprueba ;?>' >
                    <input type="hidden" name="radiobtnE" value="<?php echo $radElabora; ?>">
                    <input type="hidden" name="radiobtnR" value="<?php echo $radRevisa; ?>">
                    <input type="hidden" name="radiobtnA" value="<?php echo $radAprueba; ?>">
                    <input type="hidden" name="radCodificacion" value="<?php echo $codificacion;?>">
                    <input type="hidden" name="versionDeclarada" value="<?php echo $versionDeclarada;?>">
                    <input type="hidden" name="consecutivoDeclarado" value="<?php echo $consecutivoDeclarada;?>">
                    <!--Datos de crearDocumento 2-->

                    <input type="hidden" name="editorHtml"  value="<?php echo $html?>" >
                    <input type="hidden" name="nombrePDF" value="<?php if($nombrePDF != NULL){echo $fecha.$nombrePDF;} ?>">
                    <input type="hidden" name="rutaPDF" value="<?php echo $rutaPDF ;?>">
                    <input type="hidden" name="nombreOtro" value="<?php if($nombreOtro != NULL){echo $fecha.$nombreOtro;} ?>">
                    <input type="hidden" name="rutaOtro" value="<?php echo $rutaOtro ;?>">
                    <input type="hidden" name="documentos_externos" value='<?php echo serialize($documetosExternos) ;?>'>
                    <input type="hidden" name="definiciones" value='<?php echo serialize($definiciones) ;?>'>
                    <input type="hidden" name="archivo_gestion" value="<?php echo $archivo_gestion ;?>">
                    <input type="hidden" name="archivo_central" value="<?php echo $archivo_central ;?>">
                    <input type="hidden" name="archivo_historico" value="<?php echo $archivo_historico ;?>">
                    <input type="hidden" name="diposicion_documental" value="<?php echo $diposicion_documental ;?>">
                    <!-- select_encargadoD: este es el encargado de la disposicion documental -->
                    <input type="hidden" name="select_encargadoD" value='<?php echo serialize($select_encargadoD);?>'>
                    <input type="hidden" name="radiobtnD" value="<?php echo $radDispoDoc; ?>">
                    

                  <button id="validarOcultar" type="submit" name="agregarDoc" class="btn btn-success float-right">Finalizar >></button>
                  <!--
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
                            <div id="cargando" class="preloader float-right" style="display:none;"></div>
                            <script>
                                $(document).ready(function(){
                                    $('#validarOcultar').click(function(){
                                        document.getElementById('cargando').style.display = '';
                                        document.getElementById('validarOcultar').style.display = 'none';
                                    });
                                });
                            </script>
                            -->
                </div>
              </form>
            </div>
            </div>    

        <div class="col">
            </div>
            
           
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php echo require_once'footer.php'; ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script>
         enviando = false; //Obligaremos a entrar el if en el primer submit
    
        function checkSubmit() {
            if (!enviando) {
        		enviando= true;
        		return true;
            } else {
                //Si llega hasta aca significa que pulsaron 2 veces el boton submit
                //alert("El formulario ya se esta enviando");
                return false;
            }
        }
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>

<script>
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()
</script>
<!-- Select2 -->
<script src="../plugins/select2/js/select2.full.min.js"></script>
<!-- Page script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })
    
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

  })
</script>
<!--Oculta div-->
<script>
    $(document).ready(function(){
        $('#rad_si').click(function(){
            document.getElementById('aprovar_regitros').style.display = '';
        });
        $('#rad_no').click(function(){
            document.getElementById('aprovar_regitros').style.display = 'none';
        });
    });
</script>
<!--Select dinamico-->
<script>
    $(document).ready(function(){
        $('#rad_cargoE').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoE").html(data);
            }); 
        });
        $('#rad_usuarioE').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoE").html(data);
            }); 
        });
    });
</script>
<!--Ckeditor-->
<script>
    CKEDITOR.replace( 'editor1' );
</script>
                
        <script>
            $(document).ready(function(){
                $('#rad_flujo').click(function(){
                    document.getElementById('aprobado').style.display = 'none';
                    document.getElementById('rechazado').style.display = '';
                    document.getElementById('tituloRechazado').style.display = '';
                    document.getElementById('tituloAprobado').style.display = 'none';
                });
            });
            $(document).ready(function(){
                $('#rad_reinicio').click(function(){
                    document.getElementById('aprobado').style.display = '';
                    document.getElementById('rechazado').style.display = 'none';
                    document.getElementById('tituloRechazado').style.display = 'none';
                    document.getElementById('tituloAprobado').style.display = '';
                });
            
            });
            $(document).ready(function(){
                $('#rad_cierra').click(function(){
                    document.getElementById('aprobado').style.display = 'none';
                    document.getElementById('rechazado').style.display = '';
                    document.getElementById('tituloRechazado').style.display = '';
                    document.getElementById('tituloAprobado').style.display = 'none';
                });
            
            });
        </script>
</body>
</html>
<?php
}
?>