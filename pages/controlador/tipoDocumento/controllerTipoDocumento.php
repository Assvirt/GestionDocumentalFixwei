<?php
error_reporting(E_ERROR);
//////// traemos la bd
require_once '../../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario
date_default_timezone_set("America/Bogota");
$fecha = date("Ymjhis");

if(isset($_POST['agregarTipo'])){

    
     '<br>'.$nombre = utf8_decode($_POST['nombre']);
     '<br>'.$prefijo = utf8_decode($_POST['prefijo']);
     '<br>'.$descripcion = utf8_decode($_POST['descripcion']);
     '<br>'.$inicial = utf8_decode($_POST['inicial']);
    
                // funcion para quitar espacios
                    function Quitar_Espacios($nombre)
                    {
                        $array = explode(' ',$nombre);  // convierte en array separa por espacios;
                        $nombre ='';
                        // quita los campos vacios y pone un solo espacio
                        for ($i=0; $i < count($array); $i++) { 
                            if(strlen($array[$i])>0) {
                                $nombre.= ' ' . $array[$i];
                            }
                        }
                      return  trim($nombre);
                    }
                    /// END
                   
                    $nombre = Quitar_Espacios($nombre);
                    
                    // funcion para quitar espacios
                    function Quitar_EspaciosB($prefijo)
                    {
                        $arrayB = explode(' ',$prefijo);  // convierte en array separa por espacios;
                        $prefijo ='';
                        // quita los campos vacios y pone un solo espacio
                        for ($i=0; $i < count($arrayB); $i++) { 
                            if(strlen($arrayB[$i])>0) {
                                $prefijo.= ' ' . $arrayB[$i];
                            }
                        }
                      return  trim($prefijo);
                    }
                    /// END
                   
                    $prefijo = Quitar_EspaciosB($prefijo);
                    
    ////////////////////////////////////
    
     '<br>'.$archivoNombre = $_FILES['archivo']['name'];
     '<br>'.$guardado = $_FILES['archivo']['tmp_name'];
    
    
    /// volvemos el texto totalmente en minuscula
    $validandoDocumentoCaracteres=mb_strtolower($archivoNombre);
    
    $activarAlerta=TRUE;
    /*$descripcion_carecteres=["'"];
    for($bc=0; $bc<count($descripcion_carecteres); $bc++){
        $descripcion_carecteres[$bc]; 
         $cadena_carecteres_descripcion = $descripcion_carecteres[$bc];
         ' - '.$coincidencia_caracteres= strpos($validandoDocumentoCaracteres, $cadena_carecteres_descripcion);
        if($coincidencia_caracteres != NULL){
            $activarAlerta=FALSE;
        }    
    }*/
    $permitidosNombre = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ0123456789-_,.() ";
    for ($i=0; $i<strlen($validandoDocumentoCaracteres); $i++){
        if (strpos($permitidosNombre, substr($validandoDocumentoCaracteres,$i,1))===false){
            $validandoDocumentoCaracteres . " no es válido<br>";
            $activarAlerta=FALSE;
            //return false;
        }
    }
    
    if($activarAlerta == FALSE){
        ?>
                                        <script> 
                                             window.onload=function(){
                                           
                                                 document.forms["miformulario"].submit();
                                             }
                                        </script>
                                                 
                                        <form name="miformulario" action="../../agregarTipoDocumento" method="POST" onsubmit="procesar(this.action);" >
                                            <input name="nombre" value="<?php echo $_POST['nombre']; ?>" type="hidden">
                                            <input name="prefijo" value="<?php echo $_POST['prefijo']; ?>" type="hidden">
                                            <input name="descripcion" value="<?php echo $_POST['descripcion']; ?>" type="hidden">
                                            <input name="alerta" value="1" type="hidden">
                                        </form> 
                                        <?php
    }else{
        if($archivoNombre != NULL){
            if(!file_exists('../../archivos/plantillasTipoDocumento/')){
        	mkdir('archivos/documentos',0777,true);
            	if(file_exists('../../archivos/plantillasTipoDocumento/')){
            		if(move_uploaded_file($guardado, '../../archivos/plantillasTipoDocumento/'.$fecha.$archivoNombre)){
            	        //Guarda archivo
            	        
            	        
            		}else{
            			//echo "Archivo no se pudo guardar";
            		}
            	}
            }else{
            	if(move_uploaded_file($guardado, '../../archivos/plantillasTipoDocumento/'.$fecha.$archivoNombre)){
            	    
            	    if($fecha.$archivoNombre != NULL){ 
            		    $mysqli->query("INSERT INTO documentoArchivoTemporal (tipodocumento)VALUES('".utf8_decode($fecha.$archivoNombre)."') ")or die(mysqli_error($mysqli)); 
            		    
            		    $preguntadoValidacion=$mysqli->query("SELECT * FROM documentoArchivoTemporal WHERE  tipodocumento='".utf8_decode($fecha.$archivoNombre)."' ");
                		$extraerPreguntaValidacion=$preguntadoValidacion->fetch_array(MYSQLI_ASSOC);
                		   ' - '.$documentoExtraido2=utf8_encode($extraerPreguntaValidacion['tipodocumento']);
                		    
                		        
                        
                                 '<br><br>';
                        
                                //Lista de letras abecedario
                                $carpeta="../../archivos/plantillasTipoDocumento/";
                                $ruta="/".$carpeta."/";
                                $directorio=opendir($carpeta);
                                //recoger los  datos
                                $datos=array();
                                $conteoArchivosB=0;
                                while ($archivo = readdir($directorio)) { 
                                  if(($archivo != '.')&&($archivo != '..')){
                                     
                                    if($documentoExtraido2 == $datos[]=$archivo){
                                        $conteoArchivosB++;
                                         $datos[]=$archivo;  '<br>';
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
            	       
                            	}else{  '<br>Redir..';
                            	
                            
                                        unlink(('../../archivos/plantillasTipoDocumento/'.$fecha.$archivoNombre));
                                        $mysqli->query("DELETE FROM documentoArchivoTemporal WHERE tipodocumento='".utf8_decode($fecha.$archivoNombre)."' ")or die(mysqli_error($mysqli));
                                        
                            	        ?>
                                        <script> 
                                             window.onload=function(){
                                           
                                                 document.forms["miformulario"].submit();
                                             }
                                        </script>
                                                 
                                        <form name="miformulario" action="../../agregarTipoDocumento" method="POST" onsubmit="procesar(this.action);" >
                                            <input name="nombre" value="<?php echo $_POST['nombre']; ?>" type="hidden">
                                            <input name="prefijo" value="<?php echo $_POST['prefijo']; ?>" type="hidden">
                                            <input name="descripcion" value="<?php echo $_POST['descripcion']; ?>" type="hidden">
                                            <input name="alerta" value="1" type="hidden">
                                        </form> 
                                        <?php
                            	   }
            		
                		    
            		}
            	    
            	    
            	   
            	    
            	   
            	}else{
            		//echo "Archivo no se pudo guardar";
            	}
            }
        }
        
        
        if($documentoHabilitado2 == 'no coincide'){
             '<br><br>No almacena';
        }else{
           
            $mysqli->query("DELETE FROM documentoArchivoTemporal WHERE tipodocumento='".utf8_decode($fecha.$archivoNombre)."' ")or die(mysqli_error($mysqli));
            
            
             '<br><br>Almacena';
           
                        ///////// consultamos la tabla y extraemos el nombre
                		$sql= $mysqli->query("SELECT * FROM tipoDocumento WHERE  nombre ='$nombre' OR prefijo='$prefijo'  "); //nombre ='$salida' OR prefijo='$salidaB' 
                		$numRows = mysqli_num_rows($sql);
                        if($numRows > 0){
                            unlink(('../../archivos/plantillasTipoDocumento/'.$fecha.$archivoNombre));
                                ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformulario"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformulario" action="../../tipoDocumento" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionExiste" value="1">
                                    </form> 
                                <?php
                        
                        }else{
                            if($archivoNombre != NULL){
                                $ruta=utf8_decode($fecha.$archivoNombre);
                            }else{
                                $ruta='Nohayfoto';
                            }
                            $mysqli->query("INSERT INTO tipoDocumento (nombre, prefijo,descripcion, inicial,ruta) VALUES('$nombre', '$prefijo','$descripcion', '0','$ruta' ) ")or die(mysqli_error($mysqli));
                            
                        ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../tipoDocumento" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionAgregar" value="1">
                            </form> 
                        <?php    
                        }                        
            
        }  
    
    }
    
     
    
    
}






if(isset($_POST['editarTipo'])){ 
       
    $id = $_POST['idTipo'];
    $nombre = utf8_decode($_POST['nombre']);
    $prefijo = utf8_decode($_POST['prefijo']);
    $descripcion = utf8_decode($_POST['descripcion']);
    $inicial = utf8_decode($_POST['inicial']);
        
     // funcion para quitar espacios
                function Quitar_Espacios($nombre)
                {
                    $array = explode(' ',$nombre);  // convierte en array separa por espacios;
                    $nombre ='';
                    // quita los campos vacios y pone un solo espacio
                    for ($i=0; $i < count($array); $i++) { 
                        if(strlen($array[$i])>0) {
                            $nombre.= ' ' . $array[$i];
                        }
                    }
                  return  trim($nombre);
                }
                /// END
               
                $nombre = Quitar_Espacios($nombre);
                
                // funcion para quitar espacios
                function Quitar_EspaciosB($prefijo)
                {
                    $arrayB = explode(' ',$prefijo);  // convierte en array separa por espacios;
                    $prefijo ='';
                    // quita los campos vacios y pone un solo espacio
                    for ($i=0; $i < count($arrayB); $i++) { 
                        if(strlen($arrayB[$i])>0) {
                            $prefijo.= ' ' . $arrayB[$i];
                        }
                    }
                  return  trim($prefijo);
                }
                /// END
               
                $prefijo = Quitar_EspaciosB($prefijo);    
        
    $archivoNombre = $_FILES['archivo']['name'];
    $guardado = $_FILES['archivo']['tmp_name'];
        
    /// volvemos el texto totalmente en minuscula
    $validandoDocumentoCaracteres=mb_strtolower($archivoNombre);
    
    $activarAlerta=TRUE;
    /*$descripcion_carecteres=["'"];
    for($bc=0; $bc<count($descripcion_carecteres); $bc++){
        $descripcion_carecteres[$bc]; 
         $cadena_carecteres_descripcion = $descripcion_carecteres[$bc];
         ' - '.$coincidencia_caracteres= strpos($validandoDocumentoCaracteres, $cadena_carecteres_descripcion);
        if($coincidencia_caracteres != NULL){
            $activarAlerta=FALSE;
        }    
    }*/
    $permitidosNombre = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ0123456789-_,.() ";
    for ($i=0; $i<strlen($validandoDocumentoCaracteres); $i++){
        if (strpos($permitidosNombre, substr($validandoDocumentoCaracteres,$i,1))===false){
            $validandoDocumentoCaracteres . " no es válido<br>";
            $activarAlerta=FALSE;
            //return false;
        }
    }
    
    if($activarAlerta == FALSE){
        ?>
                                            <script> 
                                                 window.onload=function(){
                                               
                                                     document.forms["miformulario"].submit();
                                                 }
                                            </script>
                                                     
                                            <form name="miformulario" action="../../tipoDocumentoEditar" method="POST" onsubmit="procesar(this.action);" >
                                               <input name="idTipo" value="<?php echo $_POST['idTipo'];?>" type="hidden">
                                               <input name="alerta" value="1" type="hidden">
                                            </form> 
                                            <?php
    }else{ 
        
        
        $validacion2 = $mysqli->query("SELECT * FROM tipoDocumento WHERE nombre = '$nombre' AND  id != '$id' ");
        $numRows2 = mysqli_num_rows($validacion2);
        
        $validacion3 = $mysqli->query("SELECT * FROM tipoDocumento WHERE prefijo = '$prefijo' AND  id != '$id' ");
        $numRows3 = mysqli_num_rows($validacion3);
        
        if($numRows2 > 0 || $numRows3 > 0){
        ?>
                                <script> 
                                     window.onload=function(){
                                   
                                         document.forms["miformulario"].submit();
                                     }
                                </script>
                                 
                                <form name="miformulario" action="../../tipoDocumento" method="POST" onsubmit="procesar(this.action);" >
                                    <input type="hidden" name="validacionExiste" value="1">
                                </form> 
                            <?php
        
        }else{
                
            
            
            
            
                if($archivoNombre != NULL){
                if(!file_exists('../../archivos/plantillasTipoDocumento/')){
            	mkdir('archivos/documentos',0777,true);
                	if(file_exists('../../archivos/plantillasTipoDocumento/')){
                		if(move_uploaded_file($guardado, '../../archivos/plantillasTipoDocumento/'.$fecha.$archivoNombre)){
                	        //Guarda archivo
                	        
                	        
                		}else{
                			//echo "Archivo no se pudo guardar";
                		}
                	}
                }else{
                	if(move_uploaded_file($guardado, '../../archivos/plantillasTipoDocumento/'.$fecha.$archivoNombre)){
                	    
                	    if($fecha.$archivoNombre != NULL){ 
                		    $mysqli->query("INSERT INTO documentoArchivoTemporal (tipodocumento)VALUES('".utf8_decode($fecha.$archivoNombre)."') ")or die(mysqli_error($mysqli)); 
                		    
                		    $preguntadoValidacion=$mysqli->query("SELECT * FROM documentoArchivoTemporal WHERE  tipodocumento='".utf8_decode($fecha.$archivoNombre)."' ");
                    		$extraerPreguntaValidacion=$preguntadoValidacion->fetch_array(MYSQLI_ASSOC);
                    		   ' - '.$documentoExtraido2=utf8_encode($extraerPreguntaValidacion['tipodocumento']);
                    		    
                    		        
                            
                                     '<br><br>';
                            
                                    //Lista de letras abecedario
                                    $carpeta="../../archivos/plantillasTipoDocumento/";
                                    $ruta="/".$carpeta."/";
                                    $directorio=opendir($carpeta);
                                    //recoger los  datos
                                    $datos=array();
                                    $conteoArchivosB=0;
                                    while ($archivo = readdir($directorio)) { 
                                      if(($archivo != '.')&&($archivo != '..')){
                                         
                                        if($documentoExtraido2 == $datos[]=$archivo){
                                            $conteoArchivosB++;
                                             $datos[]=$archivo;  '<br>';
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
                	       
                                	}else{  '<br>Redir..';
                                	
                                
                                            unlink(('../../archivos/plantillasTipoDocumento/'.$fecha.$archivoNombre));
                                            $mysqli->query("DELETE FROM documentoArchivoTemporal WHERE tipodocumento='".utf8_decode($fecha.$archivoNombre)."' ")or die(mysqli_error($mysqli));
                                            
                                	        ?>
                                            <script> 
                                                 window.onload=function(){
                                               
                                                     document.forms["miformulario"].submit();
                                                 }
                                            </script>
                                                     
                                            <form name="miformulario" action="../../tipoDocumentoEditar" method="POST" onsubmit="procesar(this.action);" >
                                               <input name="idTipo" value="<?php echo $_POST['idTipo'];?>" type="hidden">
                                               <input name="alerta" value="1" type="hidden">
                                            </form> 
                                            <?php
                                	   }
                		
                    		    
                		}
                	    
                	    
                	   
                	    
                	   
                	}else{
                		//echo "Archivo no se pudo guardar";
                	}
                }
            }
            
            
                if($documentoHabilitado2 == 'no coincide'){
                     '<br><br>No almacena';
                }else{
                   
                    $mysqli->query("DELETE FROM documentoArchivoTemporal WHERE tipodocumento='".utf8_decode($fecha.$archivoNombre)."' ")or die(mysqli_error($mysqli));
                    
                    
                     '<br><br>Almacena';
                   
                               
                                    if($archivoNombre != NULL){
                                        $ruta=utf8_decode($fecha.$archivoNombre);
                                        $mysqli->query("UPDATE tipoDocumento SET  nombre='$nombre', prefijo='$prefijo', descripcion='$descripcion', inicial = '0', ruta='$ruta' WHERE id = '$id'");
                                    }else{
                                        $ruta='Nohayfoto';
                                        $mysqli->query("UPDATE tipoDocumento SET  nombre='$nombre', prefijo='$prefijo', descripcion='$descripcion', inicial = '0' WHERE id = '$id'");
                                    }
                                    //$mysqli->query("INSERT INTO tipoDocumento (nombre, prefijo,descripcion, inicial,ruta) VALUES('$nombre', '$prefijo','$descripcion', '0','$ruta' ) ")or die(mysqli_error($mysqli));
                                    
                                ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformulario"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformulario" action="../../tipoDocumento" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionActualizar" value="1">
                                    </form> 
                                <?php    
                                                       
                    
                } 
            
        }
    
    }
    
} // cierre del if(isset)

if(isset($_POST['eliminarTipo'])){
    $id = $_POST['idTipo'];
        $preguntadoValidacion=$mysqli->query("SELECT * FROM tipoDocumento WHERE  id='$id' ");
        $extraerPreguntaValidacion=$preguntadoValidacion->fetch_array(MYSQLI_ASSOC);
        $documentoExtraido2=utf8_encode($extraerPreguntaValidacion['ruta']);
        unlink(('../../archivos/plantillasTipoDocumento/'.$documentoExtraido2));    		
       $mysqli->query("DELETE FROM tipoDocumento WHERE id = '$id'");
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../tipoDocumento" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminar" value="1">
            </form> 
        <?php
  
}

if(isset($_POST['consecutivoParametrizacionBoton'])){
     $consecutivoParametrizacion=$_POST['consecutivoParametrizacion'];
     
     $consultaConsecutivo=$mysqli->query("SELECT count(*) FROM consecutivoDocumento ");
     $extraerConsecutivo=$consultaConsecutivo->fetch_array(MYSQLI_ASSOC);
    
    
   if($extraerConsecutivo['count(*)'] > 0){
        $mysqli->query("UPDATE consecutivoDocumento SET consecutivo='$consecutivoParametrizacion', estado='registrado' ");
   }else{
       $mysqli->query("INSERT INTO consecutivoDocumento (consecutivo,estado)VALUES('$consecutivoParametrizacion','registrado') ");
   }
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../tipoDocumento" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionActualizar" value="1">
            </form> 
        <?php
   
    
}
?>