<?php
error_reporting(E_ERROR);
session_start();
date_default_timezone_set("America/Bogota");
if(!isset($_SESSION["session_username"])){
   require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
require_once 'conexion/bd.php';
  
    $queryDoc = $mysqli->query("SELECT * FROM documento WHERE id = '".$_POST['idDocumento']."'")or die(mysqli_error($mysqli));
    $datosDoc = $queryDoc->fetch_assoc();
    $idUsuario = $_SESSION['session_idUsuario'];
    if($datosDoc['asumeFlujo'] == $idUsuario){//sE VALIDA QUE SEA EL USUARIO QUE TOMO PRIMERO LA SOLICITUD. 
        

    }else{
        if($datosDoc['asumeFlujo'] == NULL){
        ?>    
            <script> 
                 window.onload=function(){
               
                     document.forms["sacarDelFlujo"].submit();
                 }
                 setTimeout(clickbuttonScarFlujo, 0999);
                 function clickbuttonScarFlujo() { 
                    document.forms["sacarDelFlujo"].submit();
                 }
            </script>
             
            <form name="sacarDelFlujo" action="creacionDocumental" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="idDocumento" value="<?php echo $_POST['idDocumento'];?>">
                <input type="hidden" name="validacionUsuario2" value="1">
            </form>
    <?php    
        }else{
    ?>    
            <script> 
                 window.onload=function(){
               
                     document.forms["sacarDelFlujo"].submit();
                 }
                 setTimeout(clickbuttonScarFlujo, 0999);
                 function clickbuttonScarFlujo() { 
                    document.forms["sacarDelFlujo"].submit();
                 }
            </script>
             
            <form name="sacarDelFlujo" action="creacionDocumental" method="POST" onsubmit="procesar(this.action);" >
                <input name="documentoAsignado" value="<?php echo $_POST['idDocumento'];?>" type="hidden">
                <input type="hidden" name="validacionUsuario" value="1">
            </form>
    <?php    
        }
     
    }
    
    $idSolicitud = $_POST['idSolicitud'];
    //$rolFlujo = $_POST['rol']; 
    $idDocumento = $_POST['idDocumento'];
    $nombreDoc = $_POST['nombreDocumento'];
    $norma = $_POST['norma'];
    $proceso = $_POST['proceso'];
    $metodo = $_POST['rad_metodo'];
    $tipoDoc = $_POST['tipoDoc'];
    $ubicacion = $_POST['ubicacion'];
    $elabora = $_POST['select_encargadoE'];
    $revisa = $_POST['select_encargadoR'];
    $aprueba = $_POST['select_encargadoA'];
    $codificacion = $_POST['radCodificacion'];
    $versionDeclarada = $_POST['versionDeclarada'];
    $consecutivoDeclarada = $_POST['consecutivoDeclarado']; 
    

    $html = htmlentities($_POST['editor1']);
    
    $nombrePDF =$_FILES['archivopdf']['name']; 
    $rutaPDF =$_FILES['archivopdf']['tmp_name']; 
    $nombreOtro =$_FILES['archivootro']['name'];
    $rutaOtro =$_FILES['archivootro']['tmp_name'];
    
    $fecha = date("Ymjhis");
    
    if($nombrePDF != NULL ){
        $nombrePDF = $nombrePDF;
        
    }
    
    if($nombreOtro != NULL){
        $nombreOtro = $nombreOtro;
    }
    
    
    
    $documetosExternos = $_POST['documentos_externos'];
    $definiciones = $_POST['definiciones'];
    
    $archivo_gestion = $_POST['archivo_gestion']; 
    $archivo_central = $_POST['archivo_central']; 
    $archivo_historico = $_POST['archivo_historico']; 
    
    $diposicion_documental = $_POST['diposicion_documental'];
    $select_encargadoD = $_POST['select_encargadoD'];
    $radDispoDoc = $_POST['radiobtnD'];

    

    $radElabora = $_POST['radiobtnE'];
    $radRevisa = $_POST['radiobtnR'];
    $radAprueba = $_POST['radiobtnA'];
    
     

    
    if(!file_exists('archivos/documentos/')){
    	mkdir('archivos/documentos',0777,true);
    	if(file_exists('archivos/documentos/')){
    		if(move_uploaded_file($rutaPDF, 'archivos/documentos/'.$fecha.$nombrePDF)){
    	        //echo 'Guarda archivo pdf 1';
    	        //$nombrePDF = $datosDoc['nombrePDF'];
    	        if($nombrePDFOold != NULL){
    	            $path_to_file = "archivos/documentos/"; 
        	        $filename = $nombrePDFOold;
        	        
        	        $old = getcwd(); // Save the current directory
                    chdir($path_to_file);
                    if(unlink($filename)){
                        //echo "SE ELIMINO";
                    }else{
                        //echo "NO SE ELIMINO";
                    }
                    chdir($old); // Restore the old working directory 
                }
    	        
    		}else{
    			//echo "Archivo no se pudo guardar";
    		}
    	}
    }else{
    	if(move_uploaded_file($rutaPDF, 'archivos/documentos/'.$fecha.$nombrePDF)){
    	    
    	    'Guarda archivo pdf 2';
    	    
    	    if($nombrePDF != NULL){ 
    	        
    	         /// volvemos el texto totalmente en minuscula
                $validandoDocumentoCaracteresPdf=mb_strtolower($nombrePDF);
                
                $activarAlertaPdf=TRUE;
                /*$descripcion_carecteres=["'"];
                for($bc=0; $bc<count($descripcion_carecteres); $bc++){
                    $descripcion_carecteres[$bc]; 
                     $cadena_carecteres_descripcion = $descripcion_carecteres[$bc];
                     ' - '.$coincidencia_caracteres= strpos($validandoDocumentoCaracteresPdf, $cadena_carecteres_descripcion);
                    if($coincidencia_caracteres != NULL){
                        $activarAlertaPdf=FALSE;
                    }    
                }*/
                $descripcion_carecteres = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ0123456789-_,.()/ ";
                for ($i=0; $i<strlen($validandoDocumentoCaracteresPdf); $i++){
                    if (strpos($descripcion_carecteres, substr($validandoDocumentoCaracteresPdf,$i,1))===false){
                        $validandoDocumentoCaracteresPdf . " no es válido<br>";
                        $activarAlertaPdf=FALSE;
                        //return false;
                    }
                }
    	        
    	        if($activarAlertaPdf == FALSE){ 
    	                        $variableDireccion='1';
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
                                        document.forms["miformularioAlertaPdf"].submit();
                                     }
                                     setTimeout(clickbuttonPDF, 1000);
                                    function clickbuttonPDF() { 
                                             document.forms["miformularioAlertaPdf"].submit();
                                    }
                                </script>
                                         
                                <form name="miformularioAlertaPdf" action="revisaDoc2" method="POST" onsubmit="procesar(this.action);" >
                                    <input type="hidden" name="idDocumento" id="idDocumento" value="<?php echo $idDocumento ;?>" >
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
                                    
                                    
                                   
                                </form> 
                                <?php
    	        }else{
    	        
        		    $mysqli->query("INSERT INTO documentoArchivoTemporal (pdf,solicitud)VALUES('".utf8_decode($fecha.$nombrePDF)."','$idSolicitud') ")or die(mysqli_error($mysqli)); 
        		    
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
                    	$variableDireccion='1';
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
                                      setTimeout(clickbuttonPDF, 1000);
                                        function clickbuttonPDF() { 
                                                 document.forms["miformulario"].submit();
                                        }
                                </script>
                                         
                                <form name="miformulario" action="revisaDoc2" method="POST" onsubmit="procesar(this.action);" >
                                    <input type="hidden" name="idDocumento" id="idDocumento" value="<?php echo $idDocumento ;?>" >
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
                                    
                                    
                                   
                                </form> 
                                <?php
                    	   }
    		
    	        }    
    		}
    	    
    	    
    	    if($variableDireccion == 1){
    	        
    	    }else{
    	        if($nombrePDFOold != NULL){
        	           $path_to_file = "archivos/documentos/"; 
            	        $filename = $nombrePDFOold;
            	        
            	        $old = getcwd(); // Save the current directory
                        chdir($path_to_file);
                        if($filename){  "SE ELIMINO pdf";
                          // unlink($filename);
                        }else{
                             "NO SE ELIMINO pdf";
                        }
                        chdir($old); // Restore the old working directory 
                }
    	    }
            
            
    	}else{
    		//echo "Archivo no se pudo guardar";
    	}
    }
    
    if(!file_exists('archivos/documentos/')){
    	mkdir('archivos/documentos',0777,true);
    	if(file_exists('archivos/documentos/')){
    		if(move_uploaded_file($rutaOtro, 'archivos/documentos/'.$fecha.$nombreOtro)){
    			//echo "Archivo guardado con exito otro 1";
    			
    			
    			//$nombreOtro = $datosDoc['nombreOtro'];
    		 
    			if($nombreOtroOld != NULL){
                    $path_to_file = "archivos/documentos/"; 
        	        $filename = $nombreOtroOld;
        	        
        	        $old = getcwd(); // Save the current directory
                    chdir($path_to_file);
                    if(unlink($filename)){
                        //echo "SE ELIMINO";
                    }else{
                        //echo "NO SE ELIMINO";
                    }
                    chdir($old); // Restore the old working directory 
                }
    			
    		}else{
    			//echo "Archivo no se pudo guardar";
    		}
    	}
    }else{
    	if(move_uploaded_file($rutaOtro, 'archivos/documentos/'.$fecha.$nombreOtro)){
    		//echo "Archivo guardado con exito otro 2";
    		
    			//// realizamos un ingreso del archivo de manera temporal para poder verificar si es un documento bien o mal
    		 '<br>Nombre: '.$nombreOtro;
    		 '<br>';
    		 'Solicitud: '.$idSolicitud;
    		 
    		 
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
                $descripcion_carecteresOtro = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ0123456789-_,.()/ ";
                for ($i=0; $i<strlen($validandoDocumentoCaractereseditable); $i++){
                    if (strpos($descripcion_carecteresOtro, substr($validandoDocumentoCaractereseditable,$i,1))===false){
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
                                    $mysqli->query("INSERT INTO documentoDatosTemporales (solicitud,definicion,externo,responsable)VALUES('$idSolicitud','".$definicionesAlm."','".$documetosExternosAlm."','$escargadoDispo') ");
                                    }
                                    ?>
                                    <script> 
                                         window.onload=function(){
                                        document.forms["miformularioEditable"].submit();
                                         }
                                        setTimeout(clickbuttonPDF, 1000);
                                        function clickbuttonPDF() { 
                                                 document.forms["miformularioEditable"].submit();
                                        }
                                    </script>
                                             
                                    <form name="miformularioEditable" action="revisaDoc2" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="idDocumento" id="idDocumento" value="<?php echo $idDocumento ;?>" >
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
                                        
                                       
                                    </form> 
                                    <?php
    	        }else{
    	            
    	        
                
        		    
        		    
        		     '<br>Ruta ingresar: '.utf8_decode($fecha.$nombreOtro);
        		    $mysqli->query("INSERT INTO documentoArchivoTemporal (otro,solicitud)VALUES('".utf8_decode($fecha.$nombreOtro)."','$idSolicitud') ")or die(mysqli_error($mysqli)); 
        		    
        		    $preguntadoValidacion=$mysqli->query("SELECT * FROM documentoArchivoTemporal WHERE otro='".utf8_decode($fecha.$nombreOtro)."' ")or die(mysqli_error($mysqli));
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
                                     $datos[]=$archivo;  '<br>';
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
        		
        	
    		
    		
    		
        	    'A: '.$documentoHabilitado;
        	    '<br>B: '.$documentoHabilitado2;
    	   
    	   
    	   
        	   if($documentoHabilitado == 1 ){ 
        	       if($nombreOtroOld != NULL){
                        $path_to_file = "archivos/documentos/"; 
            	        $filename = $nombreOtroOld;
            	        
            	        $old = getcwd(); // Save the current directory
                        chdir($path_to_file);
                        /*if(unlink($filename)){
                            echo "SE ELIMINO word";
                        }else{
                            echo "NO SE ELIMINO word";
                        }*/
                        chdir($old); // Restore the old working directory 
                    }
        	   }else{  'Redir..';
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
                                    $mysqli->query("INSERT INTO documentoDatosTemporales (solicitud,definicion,externo,responsable)VALUES('$idSolicitud','".$definicionesAlm."','".$documetosExternosAlm."','$escargadoDispo') ");
                                    }
                        	        ?>
                                    <script> 
                                         window.onload=function(){
                                            document.forms["miformulario"].submit();
                                         }
                                         setTimeout(clickbuttonPDF, 1000);
                                        function clickbuttonPDF() { 
                                                 document.forms["miformulario"].submit();
                                        }
                                    </script>
                                             
                                    <form name="miformulario" action="revisaDoc2" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="idDocumento" id="idDocumento" value="<?php echo $idDocumento ;?>" >
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
                                        
                                       
                                    </form> 
                                    <?php
                        	   }
    		
    		//// END
    		
    		
    		
    		    
                
                
    	}else{
    		//echo "Archivo no se pudo guardar";
    	}
    }
    
    
    
    $acentos = $mysqli->query("SET NAMES 'utf8'");
    $queryDoc = $mysqli->query("SELECT * FROM documento WHERE id = $idDocumento")or die("OCURRIO UN ERROR DURANTE EL POCESO");
    $datosDoc = $queryDoc->fetch_assoc();
    
    
    $nombrePDFOold = $datosDoc['nombrePDF'];
    $nombreOtroOld = $datosDoc['nombreOtro'];
    
    
    if($datosDoc['estado'] == NULL || $datosDoc['estado'] == ''){
        $rolFlujo = "Encargado(a) solicitud";
    }
    
    if($datosDoc['estado'] == "Pendiente"){
        $rolFlujo = "Elaborador(a)";
    }
    
    if($datosDoc['estado'] == "Elaborado"){
        $rolFlujo = "Revisor(a)";
    }
    
    if($datosDoc['estado'] == "Revisado"){
        $rolFlujo = "Aprobador(a)";
    }
    
    
    
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Revisar documento</title>
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
    	
    } //onload="nobackbutton();"
</script>
<body class="hold-transition sidebar-mini" oncopy="return false" onpaste="return false" >
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
                <?php
            /// de acuerdo al rol de la persona cambia el título
            $elaboraValidacion = json_decode($datosDoc['elabora']);
            $revisaValidacion = json_decode($datosDoc['revisa']);
            $apruebaValidacion = json_decode($datosDoc['aprueba']);
            
            ///////////////////////////// para el elaborador
                if($elaboraValidacion[0] == 'usuarios'){
                    $longitudValidacion = count($elaboraValidacion);
                                                        
                    for($i=1; $i<$longitudValidacion; $i++){
                                                            //saco el valor de cada elemento
                        $queryNombres = $mysqli->query("SELECT  * FROM usuario WHERE id = '$elaboraValidacion[$i]'");
                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                        if($idparaChat == $elaboraValidacion[$i]){                                    
                    	    $variableValidado=$nombres['id'];
                        }else{
                            continue;
                        }                                  
                    	//$variableValidado=$nombres['id'];
                    } 
                }elseif($elaboraValidacion[0] == 'cargos'){
                    $longitudCValidacion = count($elaboraValidacion);
                                                        
                    for($i=1; $i<$longitudCValidacion; $i++){
                                                            //saco el valor de cada elemento
                        $queryNombres = $mysqli->query("SELECT  * FROM usuario WHERE cargo = '$elaboraValidacion[$i]' AND id='$idparaChat' ");
                        while($nombres = $queryNombres->fetch_array()){ 
                                                            
                    	$variableValidado=$nombres['id'];
                        }
                    } 
                }
            
            /////////////////////////////// para el revisor
                if($revisaValidacion[0] == 'usuarios'){
                    $longitudBValidacion = count($revisaValidacion);
                                                        
                    for($i=1; $i<$longitudBValidacion; $i++){
                                                            //saco el valor de cada elemento
                        $queryNombres = $mysqli->query("SELECT  * FROM usuario WHERE id = '$revisaValidacion[$i]'");
                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                        if($idparaChat == $revisaValidacion[$i]){                                    
                    	    $variableValidadoB=$nombres['id'];
                        }else{
                            continue;
                        }                                  
                    	//$variableValidadoB=$nombres['id'];
                    } 
                }elseif($revisaValidacion[0] == 'cargos'){
                    $longitudCValidacion = count($revisaValidacion);
                                                        
                    for($i=1; $i<$longitudCValidacion; $i++){
                                                            //saco el valor de cada elemento
                        $queryNombres = $mysqli->query("SELECT  * FROM usuario WHERE cargo = '$revisaValidacion[$i]' AND id='$idparaChat'");
                        while($nombres = $queryNombres->fetch_array()){ 
                                                            
                    	$variableValidadoB=$nombres['id'];
                        }
                    } 
                }
            
            
            ////////////////////////////// para el aprobador
                if($apruebaValidacion[0] == 'usuarios'){
                    $longitudCValidacion = count($apruebaValidacion);
                                                        
                    for($i=1; $i<$longitudCValidacion; $i++){
                                                            //saco el valor de cada elemento
                        $queryNombres = $mysqli->query("SELECT  * FROM usuario WHERE id = '$apruebaValidacion[$i]'");
                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                        if($idparaChat == $apruebaValidacion[$i]){                                    
                    	    $variableValidadoC=$nombres['id'];
                        }else{
                            continue;
                        }                                  
                    	//$variableValidadoC=$nombres['id'];
                    } 
                }elseif($apruebaValidacion[0] == 'cargos'){
                    $longitudCValidacion = count($apruebaValidacion);
                                                        
                    for($i=1; $i<$longitudCValidacion; $i++){
                                                            //saco el valor de cada elemento
                        $queryNombres = $mysqli->query("SELECT  * FROM usuario WHERE cargo = '$apruebaValidacion[$i]' AND id='$idparaChat'");
                        while($nombres = $queryNombres->fetch_array()){ 
                                                            
                    	$variableValidadoC=$nombres['id'];
                        }
                    } 
                }
                
                
            /*    
            if($variableValidado == $datosDoc['asumeFlujo'] && $datosDoc['estado'] == 'Pendiente'){
                $títulRol='Crear documento';
            }elseif($variableValidadoB == $datosDoc['asumeFlujo'] && $datosDoc['estado'] == 'Elaborado'){ 
                $títulRol='Revisar documento';
            }elseif($variableValidadoC == $datosDoc['asumeFlujo'] && $datosDoc['estado'] == 'Revisado'){ 
                $títulRol='Aprobar documento';
            }
            */
            $celdulaUser = $_SESSION['session_username'];
            // consultamos el usuario de la sesión para verificar que tenga el mismo cargo para la aprobación del documento
            $query_busqueda_cargo = $mysqli->query("SELECT  cedula,cargo FROM usuario WHERE cedula = '$celdulaUser'");
            $nombres_busqueda_cargo = $query_busqueda_cargo->fetch_array(MYSQLI_ASSOC);
            
            $enviar_id_solicitud=$datosDoc['id_solicitud'];
            /// traemos el cargo asociado que está en la solicitud
            $query_busqueda_cargo_solicitud = $mysqli->query("SELECT  * FROM solicitudDocumentos WHERE id = '$enviar_id_solicitud'");
            $nombres_busqueda_cargo_solicitud = $query_busqueda_cargo_solicitud->fetch_array(MYSQLI_ASSOC);
            
             '<br> quien aprieba: '.$nombres_busqueda_cargo_solicitud['QuienAprueba'];
            ' - '.$nombres_busqueda_cargo['cargo'];
            
            if($variableValidado == $datosDoc['asumeFlujo'] && $datosDoc['estado'] == null || $variableValidado == $datosDoc['asumeFlujo'] && $datosDoc['estado'] == 'Pendiente'){
                $títulRol='Crear documento';
                $activador_usuario='Si';
            }elseif($variableValidadoB == $datosDoc['asumeFlujo'] && $datosDoc['estado'] == 'Elaborado'){ 
                $títulRol='Revisar documento';
                $activador_usuario='Si';
            }elseif($variableValidadoC == $datosDoc['asumeFlujo'] && $datosDoc['estado'] == 'Revisado'){ 
                $títulRol='Aprobar documento';
                $activador_usuario='Si';
            }else{ /// verificamos que los roles estén ingresando, tmabién verificamos que el encargado que es el aprobador, sea quien tenga el documento abierto
                if($activador_usuario != NULL){ //echo 'a 1';
                    $títulRol='Asignar documento';
                }elseif($nombres_busqueda_cargo_solicitud['QuienAprueba'] == $celdulaUser && $datosDoc['estado'] == null || $nombres_busqueda_cargo_solicitud['QuienAprueba'] == $celdulaUser && $datosDoc['estado'] == 'Pendiente'){ //echo 'a 2';
                    $títulRol='Asignar documento';
                }else{
                    $títulRol==NULL;
                }
            }
            
            
             
             if($títulRol == NULL || $datosDoc['id'] == null){
                 //echo 'Campo vacio';
                 //$update = $mysqli->query("UPDATE documento SET asumeFlujo = null WHERE id = '$idDocumento' ");
                 ?>
                    <script> 
                         window.onload=function(){
                            // document.forms["documentoValidarSinEstado"].submit();
                         }
                         setTimeout(clickbuttonArchivoPerfil, 2000);
                         function clickbuttonArchivoPerfil() { 
                            document.forms["documentoValidarSinEstado"].submit();
                         }
                    </script>
                     
                    <form name="documentoValidarSinEstado" action="creacionDocumental" method="POST" onsubmit="procesar(this.action);" >
                        <input value="1" name="alertaSinMensaje" type="hidden">
                    </form>
                <?php
             }
            ?>
            <h1><?php echo $títulRol;?></h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active"><?php echo $títulRol;?></li>
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
              <!-- form start -->
              <form role="form" action="controlador/documentos/controllerFlujo" method="POST" onsubmit="return checkSubmit();" >
                <div class="card-body">
                    <div class="row">
                        <?php
                            $encaAprova = json_decode($datosDoc['usuario_aprovacion_reg']);
                            
                            if($encaAprova != NULL){
                                $checkedSi = "checked";
                            }else{
                                $checkedNo = "checked";
                            }
                        ?>
                        
                        
                        <!--<div class="form-group col-sm-12">
                            <label>Aprobación de registros: </label><br>
                            <input type="radio" id="rad_si" name="radiobtnReg" value="si" <?php echo $checkedSi;?> required>
                            <label for="cargo">Si</label>
                            <input type="radio" id="rad_no" name="radiobtnReg" value="no" <?php echo $checkedNo;?> required>
                            <label for="usuarios">No</label>
                            
                            <div id="aprovar_regitros" style="display:none;">
                                
                                <?php
                                
                                   //$encaAprova = json_decode($datosDoc['usuario_aprovacion_reg']);
                        
                        
                                    if($encaAprova[0] == 'cargos'){
                                        $checkedEncaC = "checked";            
                                    }
                                    
                                    if($encaAprova[0] == 'usuarios'){
                                        $checkedEncaU = "checked"; 
                                    }

                                    
                                ?>
                                
                                
                                <input type="radio" id="rad_cargoE" name="radiobtnAR" value="cargos" <?php //echo $checkedEncaC;?>>
                                <label for="cargo">Cargo</label>
                                <input type="radio" id="rad_usuarioE" name="radiobtnAR" value="usuarios" <?php //echo $checkedEncaU;?>>
                                <label for="usuarios">Usuarios</label>
    
                                
                                <div class="select2-blue">
                                    <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoAR[]" id="select_encargadoAR"></select>
                                </div>
                            </div>
                        </div>-->
                        

                        
                        
                        <div class="form-group col-sm-12">
                            <label>Flujo de aprobación</label>
                            <br>
                            <label>
                                <input type="radio" id="rad_flujo" name="rad_flujo" value="reinicia" required>
                                Regresa flujo de aprobación
                            </label>
                            <br>
                            <label>
                                <input type="radio" id="rad_reinicio" name="rad_flujo" value="ajusta" required>
                                Ajusta y continua flujo de aprobación
                            </label>
                            <br>
                            <label>
                                <input type="radio" id="rad_cierra" name="rad_flujo" value="cierra" required>
                                Cierra solicitud documental
                            </label>
                            
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Meses para próxima revisión </label>
                            <input name="mesesRevision" type="number" min="1" max="24" value="<?php echo $datosDoc['mesesRevision'];?>">
                        </div>
                        <div class="col-sm-12">
                            <center>
                                    <br>
                                    <p><h4>Control de Cambios</h4></p>
                                </center>
                            <?php
                            // consulta de la tabla del control de cambios
                             $idDocumento;
                                //$consultandoDocumento=$mysqli->query("SELECT * FROm documento WHERE id='$idDocumento' ");
                                //$extraerConsultaDocumento=$consultandoDocumento->fetch_array(MYSQLI_ASSOC);
                                //$extraerIdSolicitud=$extraerConsultaDocumento['id_solicitud'];
                            
                            
                                $consultamosExistenciaComentario=$mysqli->query("SELECT * FROM controlCambiosFlujo WHERE idDocumento='".$idDocumento."' ");
                                $extrarConsultaExistenciaComentario=$consultamosExistenciaComentario->fetch_array(MYSQLI_ASSOC);
                                if($extrarConsultaExistenciaComentario['idDocumento'] != NULL){
                                   
                                    $informacionDelTexto=$extrarConsultaExistenciaComentario['informacion'];
                                    
                                }else{
                                
                                    $consultaControlCambios=$mysqli->query("SELECT * FROM  controlCambiosParametrizacion ");
                                    $extraerControlCambios=$consultaControlCambios->fetch_array(MYSQLI_ASSOC);
                                    $informacionDelTexto=$extraerControlCambios['informacion'];
                                }
    
                           
                            // end
                            ?>
                            <textarea name="editor1" required><?php echo $informacionDelTexto;?></textarea>
                        </div>
                        <div class="col-sm-12">
                            <div class="card">
                                <center>
                                    <br>
                                    <p><h4>Comentarios</h4></p>
                                </center>
                                    <div style="padding: 20px;" class="tab-pane" id="timeline">
                                        <!-- The timeline -->
                                        <div class="timeline timeline-inverse">
                                          <!-- timeline time label -->
                                          <?php 
                                            $idSol = $datosDoc['id_solicitud'];
                                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                                            $queryControl = $mysqli->query("SELECT * FROM controlCambios WHERE idDocumento = '$idSol'")or die(mysqli_error($mysqli));
                                            
                                            while($row = $queryControl->fetch_assoc()){
                                                $idUser = $row['idUsuario'];
                                                $rol = $row['rol'];
                                                $queryUser = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$idUser' ")or die(mysqli_error($mysqli));
                                                $datosUser = $queryUser->fetch_assoc();

                                                $nombreUsuario = $datosUser['nombres']." ".$datosUser['apellidos'];
                                          ?>
                                          
                                          <div class="time-label">
                                            <span class="bg-danger">
                                              <?php echo substr($row['fecha'],0,-8); //$row['fecha']?>
                                            </span>
                                          </div>

                                          <div>
                                            <i class="fas fa-user bg-info"></i>
                    
                                            <div class="timeline-item">
                                              <h3 class="timeline-header border-0"><b><?php echo $rol?></b> - <a href="#"><?php echo $nombreUsuario?></a> <?php  if($row['comentario'] != NULL){ echo nl2br($row['comentario']); }else{ echo 'N/A';} ?>
                                              </h3>
                                            </div>
                                            
                                          </div>
                                        <?php }?>
                                        </div>
                                     </div>
                            </div>
                        </div>
                        
                        <?php 
                            $idDocumento; 
                            $validandoDocumento=$mysqli->query("SELECT * FROM documento WHERE id='$idDocumento' ");
                            $extraerDocumentoValidacion=$validandoDocumento->fetch_array(MYSQLI_ASSOC);
                            $estadoValidando=$extraerDocumentoValidacion['estado'];
                        if($estadoValidando == 'Aprobado'){  
                        ?>
                        <center>
                            <h4>El documento ya fue aprobado</h4>
                        </center>
                        <?php    
                        }else{
                        ?>
                        <div class="form-group col-sm-12">
                            
                            <label>Comentarios: </label>
                            <textarea rows="2" class="form-control" name="controlCambios" onkeypress="return (event.charCode == 58 || event.charCode == 59 || event.charCode == 13 || (event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" placeholder="Comentarios"></textarea>
                            <br>
                            
                            <label style="display:none;" id="tituloAprobado"><input style="display:none;" type="radio" name="radiobtnAprobado" id="aprobado" value="aprobado" required> Aprobado</label>
                            <label style="display:none;" id="tituloRechazado"><input style="display:none;" type="radio" name="radiobtnAprobado" id="rechazado" value="rechazado" required> Rechazado</label>
                        
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                        <label>Códificación anterior</label><br>
                        <?php
                        echo '<b>'.$extraerDocumentoValidacion['codificacion'].'</b> ';
                        echo ' - Versión: <b>'.$extraerDocumentoValidacion['version'].'</b>';
                        ?>
        
                    <!-- acá se imprime el resultado de la consulta de Ajax-->
                    <div id="contenidoMEnsaje">
                        <div id="mostrarDatos" style="display:;"></div>
                    </div>
                    <!-- END -->
                
                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                    <!--Envio variables ocultas-->
                    <input type="hidden" name="rol" value="<?php echo $rolFlujo;?>"> 
                    <input type="hidden" name="idDocumento" id="idDocumento" value="<?php echo $idDocumento ;?>" >
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
                    <?php
                    if($nombrePDF != NULL){
                    ?>
                    <input type="hidden" name="nombrePDF" value="<?php echo $fecha.$nombrePDF ;?>">
                    <input type="hidden" name="rutaPDF" value="<?php echo $rutaPDF ;?>">
                    <?php
                    }else{
                    ?>
                    <input type="hidden" name="nombrePDF" value="">
                    <input type="hidden" name="rutaPDF" value="">
                    <?php
                    }
                    if($nombreOtro != NULL){
                    ?>
                    <input type="hidden" name="nombreOtro" value="<?php echo $fecha.$nombreOtro ;?>">
                    <input type="hidden" name="rutaOtro" value="<?php echo $rutaOtro ;?>">
                    <?php
                    }else{
                    ?>
                    <input type="hidden" name="nombreOtro" value="">
                    <input type="hidden" name="rutaOtro" value="">
                    <?php
                    }
                    ?>
                    <input type="hidden" name="documentos_externos" value='<?php echo serialize($documetosExternos) ;?>'>
                    <input type="hidden" name="definiciones" value='<?php echo serialize($definiciones) ;?>'>
                    <input type="hidden" name="archivo_gestion" value="<?php echo $archivo_gestion ;?>">
                    <input type="hidden" name="archivo_central" value="<?php echo $archivo_central ;?>">
                    <input type="hidden" name="archivo_historico" value="<?php echo $archivo_historico ;?>">
                    <input type="hidden" name="diposicion_documental" value="<?php echo $diposicion_documental ;?>">
                    <!-- select_encargadoD: este es el encargado de la disposicion documental -->
                    <input type="hidden" name="select_encargadoD" value='<?php echo serialize($select_encargadoD);?>'>
                    <input type="hidden" name="radiobtnD" value="<?php echo $radDispoDoc; ?>">
                   <?php 
                   if($estadoValidando == 'Aprobado'){ 
                   ?>
                   <a onclick="window.location.href='creacionDocumental'" style="color:white;" class="btn btn-success float-right">Finalizar >></a> 
                   <?php
                   }else{
                   ?> 
                    <div id="habilitarBotonFinalizar" style="display:none;">
                        <button id="validarOcultar"  type="submit" name="revisarDoc" class="btn btn-success float-right">Finalizar >></button>
                    </div>    
                    
                       <?php
                       if($estadoValidando == 'Revisado'){ 
                       ?>
                                <script>
                                    $(document).ready(function(){
                                        $('#validarOcultar').click(function(){
                                            document.getElementById('mostrarDatos').style.display = 'none';
                                        });
                                    });
                                </script>
                        <?php
                        }
                    
                   } 
                  ?>
                </div>
              </form>
            </div>
            </div>    

        <div class="col">
            </div>
            
                    <form method="post" onsubmit="return false">
                        <input id="consultaProductos" value="<?php echo $idDocumento; ?>" type="hidden">
                         <input id="procesos" value="<?php echo $proceso; ?>" type="hidden">
                        <input id="tipoDocumento" value="<?php echo $tipoDoc; ?>" type="hidden">
                        <input id="enviarNuevoNombre" value="<?php echo $nombreDoc;?>" type="hidden">
                        <button id="js-consulta" style="display:none;"></button>
                    </form>
                    
                    
                    
                    
                  <script>
                     
                     function recargarChat(){ //alert("Entra a la consulta constante.");
                        // traemos los datos de la consulta, después de hacer el primer click, trae los datos actualizados después de agregar otro producto
                            $(document).on('click', '#js-consulta', function(e){ 
                            	e.preventDefault();
                            	var consultaProductos = $('#consultaProductos').val(),
                            	    procesos = $('#procesos').val(),
                            	    tipoDocumento = $('#tipoDocumento').val(),
                            	    enviarNuevoNombre = $('#enviarNuevoNombre').val();
                            	    /*alert(consultaProductos);
                            	    alert(procesos);
                            	    alert(tipoDocumento);
                            	    alert(enviarNuevoNombre);*/
                            	
                                $.ajax({
                            		url: 'validacionCodificacionJs.php', // Es importante que la ruta sea correcta si no, no se va a ejecutar
                            		method: 'POST',
                            		data: { consultaProductos: consultaProductos, procesos: procesos, tipoDocumento: tipoDocumento, enviarNuevoNombre: enviarNuevoNombre }, //, procesos: procesos, tipoDocumento: tipoDocumento
                            		beforeSend: function(){
                            			$('#mostrarDatos').css('display','block');
                            			//$('#estado p').html('Guardando datos...');
                            		},
                            		success: function(lista){
                            				$('#mostrarDatos').html(lista);
                            		}
                            	});
                            });
                        // END    
                        
                        // simulamos el click en el botón del formulario para traer los datos 
                        
                            $(document).ready(function() {
                              // indicamos que se ejecuta la funcion a los 5 segundos de haberse
                              // cargado la pagina
                              setTimeout(clickbutton, 0000);
                            
                              function clickbutton() {
                                // simulamos el click del mouse en el boton del formulario
                                $("#js-consulta").click();
                                //alert("Aqui llega"); //Debugger
                              }
                              $('#js-consulta').on('click',function() {
                               // console.log('action');
                              });
                            });
                          
                     }
                     setInterval("recargarChat()",1000);
                        // END
                    </script> 
                    
                    
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
<!--Ckeditor-->
<script src="ckeditor5/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'editor1' );
</script>
<!-- jQuery -->
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
                $("#select_encargadoAR").html(data);
            }); 
        });
        $('#rad_usuarioE').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoAR").html(data);
            }); 
        });
        
        
        var radios = document.getElementsByName('radiobtnReg');

        
        for (var i = 0, length = radios.length; i < length; i++) {
          
          if (radios[i].checked) {
              if(radios[i].value == 'si'){
                 document.getElementById('aprovar_regitros').style.display = ''; 
              }
              
              if(radios[i].value == 'no'){
                 document.getElementById('aprovar_regitros').style.display = 'none'; 
              }
          }
        }
        
        
        
        var radios = document.getElementsByName('radiobtnAR');

        
        for (var i = 0, length = radios.length; i < length; i++) {
          if (radios[i].checked) {
            // do whatever you want with the checked radio
            //alert(radios[i].value);
            var rad_post = document.getElementById("idDocumento").value;
            var grupo = radios[i].value;
            var radencargadoAR = "radencargadoAR";
            
           // alert(rad_post);
            
            $.post("selectDocumentos2.php", { rad_post: rad_post, grupo: grupo, radencargadoAR: radencargadoAR}, function(data){
                $("#select_encargadoAR").html(data);
            }); 
            // only one radio can be logically checked, don't check the rest
            break;
          }
        }
        
        
        
        
    });
</script>

<script>
            $(document).ready(function(){
                $('#rad_flujo').click(function(){ //alert("datoA");
                    document.getElementById('contenidoMEnsaje').style.display = 'none';  /// ocultamos el mensaje en rojo que muestra la codificación
                    //alert(pantalla);
                    //alert("datoB");
                    document.getElementById('aprobado').style.display = 'none';
                    document.getElementById('rechazado').style.display = '';
                    document.getElementById('tituloRechazado').style.display = '';
                    document.getElementById('tituloAprobado').style.display = 'none';
                    document.getElementById('habilitarBotonFinalizar').style.display = '';
                });
            });
            $(document).ready(function(){
                $('#rad_reinicio').click(function(){
                    document.getElementById('contenidoMEnsaje').style.display = '';  /// ocultamos el mensaje en rojo que muestra la codificación
                    document.getElementById('aprobado').style.display = '';
                    document.getElementById('rechazado').style.display = 'none';
                    document.getElementById('tituloRechazado').style.display = 'none';
                    document.getElementById('tituloAprobado').style.display = '';
                    document.getElementById('habilitarBotonFinalizar').style.display = '';
                });
            
            });
            $(document).ready(function(){
                $('#rad_cierra').click(function(){
                    document.getElementById('contenidoMEnsaje').style.display = 'none';  /// ocultamos el mensaje en rojo que muestra la codificación
                    document.getElementById('aprobado').style.display = 'none';
                    document.getElementById('rechazado').style.display = '';
                    document.getElementById('tituloRechazado').style.display = '';
                    document.getElementById('tituloAprobado').style.display = 'none';
                    document.getElementById('habilitarBotonFinalizar').style.display = '';
                });
            
            });
        </script>
        
        
       
        
</body>
</html>
<?php
}
?>