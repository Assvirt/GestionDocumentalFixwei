<?php
error_reporting(E_ERROR);
//////// traemos la bd
require_once '../../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario
date_default_timezone_set("America/Bogota");
$fecha = date("Ymjhis");

if(isset($_POST['agregarNorma'])){

    
    $nombre = str_replace("?","",str_replace("'","",(str_replace("−","-",utf8_decode($_POST['nombre'])))));
    
    $abreviatura=str_replace("?","",str_replace("'","",(str_replace("−","-",utf8_decode($_POST['abreviatura'])))));
    
    $descripcion=str_replace("?","",str_replace("'","",(str_replace("−","-",utf8_decode($_POST['descripcion'])))));
    
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

    $archivoNombre = $_FILES['archivo']['name'];
    $guardado = $_FILES['archivo']['tmp_name'];
   
   
    
    /// volvemos el texto totalmente en minuscula
    $validandoDocumentoCaracteres=mb_strtolower($archivoNombre);
    
    $activarAlerta=TRUE;
    
    /*
    $descripcion_carecteres=["'"];
    for($bc=0; $bc<count($descripcion_carecteres); $bc++){
        $descripcion_carecteres[$bc]; 
         $cadena_carecteres_descripcion = $descripcion_carecteres[$bc];
         ' - '.$coincidencia_caracteres= strpos($validandoDocumentoCaracteres, $cadena_carecteres_descripcion);
        if($coincidencia_caracteres != NULL){ echo 'se debe activar';
            $activarAlerta=FALSE;
        }    
    }
    */
    
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
                                                //alert("Alerta ");
                                                document.forms["miformulario"].submit();
                                             }
                                        </script>
                                                 
                                        <form name="miformulario" action="../../agregarNormatividad" method="POST" onsubmit="procesar(this.action);" >
                                           <input name="alerta" value="1" type="hidden">
                                           <input name="nombre" value="<?php echo $_POST['nombre'];?>" type="hidden">
                                           <input name="abreviatura" value="<?php echo $_POST['abreviatura'];?>" type="hidden">
                                           <input name="descripcion" value="<?php echo $_POST['descripcion'];?>" type="hidden">
                                        </form> 
                                        <?php
    }else{ 
    
        
        
    
    
   
        if($archivoNombre != NULL){
            if(!file_exists('../../archivos/plantillasNormatividad/')){
        	mkdir('archivos/documentos',0777,true);
            	if(file_exists('../../archivos/plantillasNormatividad/')){
            		if(move_uploaded_file($guardado, '../../archivos/plantillasNormatividad/'.$fecha.$archivoNombre)){
            	        //Guarda archivo
            	        
            	        
            		}else{
            			//echo "Archivo no se pudo guardar";
            		}
            	}
            }else{
            	if(move_uploaded_file($guardado, '../../archivos/plantillasNormatividad/'.$fecha.$archivoNombre)){
            	    
            	    if($fecha.$archivoNombre != NULL){ 
            		    $mysqli->query("INSERT INTO documentoArchivoTemporal (tipodocumento)VALUES('".utf8_decode($fecha.$archivoNombre)."') ")or die(mysqli_error($mysqli)); 
            		    
            		    $preguntadoValidacion=$mysqli->query("SELECT * FROM documentoArchivoTemporal WHERE  tipodocumento='".utf8_decode($fecha.$archivoNombre)."' ");
                		$extraerPreguntaValidacion=$preguntadoValidacion->fetch_array(MYSQLI_ASSOC);
                		   ' - '.$documentoExtraido2=utf8_encode($extraerPreguntaValidacion['tipodocumento']);
                		    
                		        
                        
                                 '<br><br>';
                        
                                //Lista de letras abecedario
                                $carpeta="../../archivos/plantillasNormatividad/";
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
                            	
                            
                                        unlink(('../../archivos/plantillasNormatividad/'.$fecha.$archivoNombre));
                                        $mysqli->query("DELETE FROM documentoArchivoTemporal WHERE tipodocumento='".utf8_decode($fecha.$archivoNombre)."' ")or die(mysqli_error($mysqli));
                                        
                            	        ?>
                                        <script> 
                                             window.onload=function(){
                                                //alert("Alerta ");
                                                 document.forms["miformulario"].submit();
                                             }
                                        </script>
                                                 
                                        <form name="miformulario" action="../../agregarNormatividad" method="POST" onsubmit="procesar(this.action);" >
                                           <input name="alerta" value="1" type="hidden">
                                           <input name="nombre" value="<?php echo $_POST['nombre'];?>" type="hidden">
                                           <input name="abreviatura" value="<?php echo $_POST['abreviatura'];?>" type="hidden">
                                           <input name="descripcion" value="<?php echo $_POST['descripcion'];?>" type="hidden">
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
                		$sql= $mysqli->query("SELECT * FROM normatividad WHERE  nombre ='$nombre'   "); 
                		$numRows = mysqli_num_rows($sql);
                        if($numRows > 0){
                            unlink(('../../archivos/plantillasNormatividad/'.$fecha.$archivoNombre));
                                ?>
                                    <script> 
                                         window.onload=function(){
                                        //alert("Existencia");
                                             document.forms["miformulario"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformulario" action="../../normatividad" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionExisteA" value="1">
                                    </form> 
                                <?php
                        
                        }else{
                            if($archivoNombre != NULL){
                                $ruta=utf8_decode($fecha.$archivoNombre);
                            }else{
                                $ruta='nohayfoto';
                            }
                            $mysqli->query("INSERT INTO normatividad (nombre, abreviatura,descripcion,ruta) VALUES('$nombre', '$abreviatura','$descripcion','$ruta' ) ")or die(mysqli_error($mysqli));
                        ?>
                            <script> 
                                 window.onload=function(){
                               //alert("Registro");
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../normatividad" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionAgregar" value="1">
                            </form> 
                        <?php    
                        }                        
            
        }
    
    
    
    
    
    
        
    } 
    
  
}

if(isset($_POST['normatividadEditar'])){
       
    $id = $_POST['idNormatividad'];
       
    $nombre = str_replace("?","",str_replace("'","",(str_replace("−","-",utf8_decode($_POST['nombre'])))));
    
    $abreviatura=str_replace("?","",str_replace("'","",(str_replace("−","-",utf8_decode($_POST['abreviatura'])))));
    
    $descripcion=str_replace("?","",str_replace("'","",(str_replace("−","-",utf8_decode($_POST['descripcion'])))));
       
       /*
       $nombre = utf8_decode($_POST['nombre']);
       $abreviatura = utf8_decode($_POST['abreviatura']);
       $descripcion = utf8_decode($_POST['descripcion']);
        */
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
    
    
        
    $editar = true;
    
    $validacion1 = $mysqli->query("SELECT * FROM normatividad WHERE nombre = '$nombre' AND id != '$id'");//consulta a base de datos si el nombre se repite
    $numNom = mysqli_num_rows($validacion1);
    if($numNom > 0){//si el nombre está repetido se pone falso
        $editar = false;
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../normatividad" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExisteA" value="1">
            </form> 
        <?php
    }else{ 
    
    
    
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
                                                 
                                        <form name="miformulario" action="../../normatividadEditar" method="POST" onsubmit="procesar(this.action);" >
                                           <input name="idNormatividad" value="<?php echo $_POST['idNormatividad'];?>" type="hidden">
                                           <input name="alerta" value="1" type="hidden">
                                        </form> 
                                        <?php
    }else{    
        if($archivoNombre != NULL){
            if(!file_exists('../../archivos/plantillasNormatividad/')){
        	mkdir('archivos/documentos',0777,true);
            	if(file_exists('../../archivos/plantillasNormatividad/')){
            		if(move_uploaded_file($guardado, '../../archivos/plantillasNormatividad/'.$fecha.$archivoNombre)){
            	        //Guarda archivo
            	        
            	        
            		}else{
            			//echo "Archivo no se pudo guardar";
            		}
            	}
            }else{
            	if(move_uploaded_file($guardado, '../../archivos/plantillasNormatividad/'.$fecha.$archivoNombre)){
            	    
            	    if($fecha.$archivoNombre != NULL){ 
            		    $mysqli->query("INSERT INTO documentoArchivoTemporal (tipodocumento)VALUES('".utf8_decode($fecha.$archivoNombre)."') ")or die(mysqli_error($mysqli)); 
            		    
            		    $preguntadoValidacion=$mysqli->query("SELECT * FROM documentoArchivoTemporal WHERE  tipodocumento='".utf8_decode($fecha.$archivoNombre)."' ");
                		$extraerPreguntaValidacion=$preguntadoValidacion->fetch_array(MYSQLI_ASSOC);
                		   ' - '.$documentoExtraido2=utf8_encode($extraerPreguntaValidacion['tipodocumento']);
                		    
                		        
                        
                                 '<br><br>';
                        
                                //Lista de letras abecedario
                                $carpeta="../../archivos/plantillasNormatividad/";
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
                            	
                            
                                        unlink(('../../archivos/plantillasNormatividad/'.$fecha.$archivoNombre));
                                        $mysqli->query("DELETE FROM documentoArchivoTemporal WHERE tipodocumento='".utf8_decode($fecha.$archivoNombre)."' ")or die(mysqli_error($mysqli));
                                        
                            	        ?>
                                        <script> 
                                             window.onload=function(){
                                           
                                                 document.forms["miformulario"].submit();
                                             }
                                        </script>
                                                 
                                        <form name="miformulario" action="../../normatividadEditar" method="POST" onsubmit="procesar(this.action);" >
                                           <input name="idNormatividad" value="<?php echo $_POST['idNormatividad'];?>" type="hidden">
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
                                    $mysqli->query("UPDATE normatividad SET  nombre='$nombre', abreviatura='$abreviatura', descripcion='$descripcion', ruta='$ruta' WHERE id = '$id'");
                                }else{
                                    $ruta='nohayfoto';
                                    $mysqli->query("UPDATE normatividad SET  nombre='$nombre', abreviatura='$abreviatura', descripcion='$descripcion', ruta='$ruta' WHERE id = '$id'");
                                }
                                
                            ?>
                                <script> 
                                     window.onload=function(){
                                   
                                         document.forms["miformulario"].submit();
                                     }
                                </script>
                                 
                                <form name="miformulario" action="../../normatividad" method="POST" onsubmit="procesar(this.action);" >
                                    <input type="hidden" name="validacionActualizar" value="1">
                                </form> 
                            <?php    
                                                   
                
            }   
            
    }       
            
            
       
   
  
    } 
    
   
}

if(isset($_POST['EliminarNormatividad'])){
    $id = $_POST['idNormatividad'];
    
    
    ///// consultamos la tabla y sacamos el nombre para realizar la eliminación del documento
    
    
    //// END
    
    $consulta=$mysqli->query("SELECT * FROM normatividad WHERE id='$id' ");
    $extraer=$consulta->fetch_array(MYSQLI_ASSOC);
    $documento=utf8_encode($extraer['ruta']);
    unlink(('../../archivos/plantillasNormatividad/'.$documento));
    //unlink('../../archivos/plantillasTipoDocumento/'.$documento);
    
       $mysqli->query("DELETE FROM normatividad WHERE id = '$id'");
   
   //eliminar de normatividad
   
   //echo '<script language="javascript">alert("exito al eliminar.");
   //window.location.href="../../normatividad"</script>';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../normatividad" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminar" value="1">
            </form> 
        <?php
}
?>