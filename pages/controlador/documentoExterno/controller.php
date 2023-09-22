<?php
//////// traemos la bd
require_once '../../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario
date_default_timezone_set("America/Bogota");
$fecha = date("Ymjhis");

if(isset($_POST['agregar'])){

    
    $nombre = utf8_decode($_POST['nombre']);
    $tipo = $_POST['tipo'];
    
    $archivoNombre = $_FILES['archivo']['name'];
    $guardado = $_FILES['archivo']['tmp_name'];
    
    
    
    /// volvemos el texto totalmente en minuscula
    $validandoDocumentoCaracteres=mb_strtolower($archivoNombre);
    
    $activarAlerta=TRUE;
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
                                                        //alert("alerta");
                                                         document.forms["miformulario"].submit();
                                                     }
                                                </script>
                                                         
                                                <form name="miformulario" action="../../agregarDocumentoExterno" method="POST" onsubmit="procesar(this.action);" >
                                                    <input name="nombre" value="<?php echo $_POST['nombre']; ?>" type="hidden">
                                                    <input name="tipo" value="<?php echo $_POST['tipo']; ?>" type="hidden">
                                                    <input name="alerta" value="1" type="hidden">
                                                </form> 
                                                <?php
    }else{
    
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
        
        $validando=$mysqli->query("SELECT * FROM documentoExterno WHERE nombre='$nombre' ");
        $extraerValidando=$validando->fetch_array(MYSQLI_ASSOC);
        
        if($extraerValidando['nombre'] == $nombre){
            ?>
                <script> 
                     window.onload=function(){
                   
                         document.forms["miformulario"].submit();
                     }
                </script>
                 
                <form name="miformulario" action="../../documentoExterno" method="POST" onsubmit="procesar(this.action);" >
                    <input type="hidden" name="validacionExiste" value="1">
                </form> 
            <?php
        }else{
            if($archivoNombre == NULL){
                
                $mysqli->query("INSERT INTO documentoExterno (nombre, tipo) VALUES('$nombre', '$tipo' ) ")or die(mysqli_error($mysqli));
                
                ?>
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformulario"].submit();
                         }
                    </script>
                     
                    <form name="miformulario" action="../../documentoExterno" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="validacionAgregar" value="1">
                    </form> 
                <?php
                
            }else{
             
             
             
             
                if($archivoNombre != NULL){
                    if(!file_exists('../../archivos/documentosExternos/')){
                	mkdir('archivos/documentos',0777,true);
                    	if(file_exists('../../archivos/documentosExternos/')){
                    		if(move_uploaded_file($guardado, '../../archivos/documentosExternos/'.$fecha.$archivoNombre)){
                    	        //Guarda archivo
                    	        
                    	        
                    		}else{
                    			//echo "Archivo no se pudo guardar";
                    		}
                    	}
                    }else{
                    	if(move_uploaded_file($guardado, '../../archivos/documentosExternos/'.$fecha.$archivoNombre)){
                    	    
                    	    if($fecha.$archivoNombre != NULL){ 
                    		    $mysqli->query("INSERT INTO documentoArchivoTemporal (tipodocumento)VALUES('".utf8_decode($fecha.$archivoNombre)."') ")or die(mysqli_error($mysqli)); 
                    		    
                    		    $preguntadoValidacion=$mysqli->query("SELECT * FROM documentoArchivoTemporal WHERE  tipodocumento='".utf8_decode($fecha.$archivoNombre)."' ");
                        		$extraerPreguntaValidacion=$preguntadoValidacion->fetch_array(MYSQLI_ASSOC);
                        		   ' - '.$documentoExtraido2=utf8_encode($extraerPreguntaValidacion['tipodocumento']);
                        		    
                        		        
                                
                                         '<br><br>';
                                
                                        //Lista de letras abecedario
                                        $carpeta="../../archivos/documentosExternos/";
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
                                    	
                                    
                                                unlink(('../../archivos/documentosExternos/'.$fecha.$archivoNombre));
                                                $mysqli->query("DELETE FROM documentoArchivoTemporal WHERE tipodocumento='".utf8_decode($fecha.$archivoNombre)."' ")or die(mysqli_error($mysqli));
                                                
                                    	        ?>
                                                <script> 
                                                     window.onload=function(){
                                                        //alert("alerta");
                                                         document.forms["miformulario"].submit();
                                                     }
                                                </script>
                                                         
                                                <form name="miformulario" action="../../agregarDocumentoExterno" method="POST" onsubmit="procesar(this.action);" >
                                                    <input name="nombre" value="<?php echo $_POST['nombre']; ?>" type="hidden">
                                                    <input name="tipo" value="<?php echo $_POST['tipo']; ?>" type="hidden">
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
                        		$sql= $mysqli->query("SELECT * FROM documentoExterno WHERE  nombre ='$nombre'   "); 
                        		$numRows = mysqli_num_rows($sql);
                                if($numRows > 0){
                                    unlink(('../../archivos/documentosExternos/'.$fecha.$archivoNombre));
                                        ?>
                                            <script> 
                                                 window.onload=function(){
                                               
                                                     document.forms["miformulario"].submit();
                                                 }
                                            </script>
                                             
                                            <form name="miformulario" action="../../documentoExterno" method="POST" onsubmit="procesar(this.action);" >
                                                <input type="hidden" name="validacionExiste" value="1">
                                            </form> 
                                        <?php
                                
                                }else{
                                    if($archivoNombre != NULL){
                                        $ruta=utf8_decode($fecha.$archivoNombre);
                                    }else{
                                        $ruta='Nohayfoto';
                                    }
                                    $mysqli->query("INSERT INTO documentoExterno (nombre, tipo,ruta) VALUES('$nombre', '$tipo','$ruta' ) ")or die(mysqli_error($mysqli));
                                ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformulario"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformulario" action="../../documentoExterno" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionAgregar" value="1">
                                    </form> 
                                <?php    
                                }                        
                    
                }   
             
             
             
             
              
            }
        }
    
    
    
    
    }
    
    
    
}

if(isset($_POST['editar'])){
       
       $id = $_POST['idDoc'];
       $nombre = utf8_decode($_POST['nombre']);
       $tipo = $_POST['tipo'];
        $archivoNombre = $_FILES['archivo']['name'];
        $guardado = $_FILES['archivo']['tmp_name'];
    
    
    
    /// volvemos el texto totalmente en minuscula
    $validandoDocumentoCaracteres=mb_strtolower($archivoNombre);
    
    $activarAlerta=TRUE;
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
                                                        //alert("alerta");
                                                         document.forms["miformulario"].submit();
                                                     }
                                                </script>
                                                         
                                                <form name="miformulario" action="../../documentoExternoEditar" method="POST" onsubmit="procesar(this.action);" >
                                                   <input name="idDoc" value="<?php echo $id;?>" type="hidden">
                                                   <input name="alerta" value="1" type="hidden">
                                                </form>  
                                                <?php
    }else{
    
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
            
        $validacion2 = $mysqli->query("SELECT * FROM documentoExterno WHERE nombre = '$nombre' AND NOT id = '$id' ");
        $numRows2 = mysqli_num_rows($validacion2);
        
        if($numRows2 > 0){
        ?>
                <script> 
                     window.onload=function(){
                   
                         document.forms["miformulario"].submit();
                     }
                </script>
                 
                <form name="miformulario" action="../../documentoExterno" method="POST" onsubmit="procesar(this.action);" >
                    <input type="hidden" name="validacionExiste" value="1">
                </form> 
            <?php
        
        }else{
            
        
        
             if($archivoNombre != NULL){
                if(!file_exists('../../archivos/documentosExternos/')){
            	mkdir('archivos/documentos',0777,true);
                	if(file_exists('../../archivos/documentosExternos/')){
                		if(move_uploaded_file($guardado, '../../archivos/documentosExternos/'.$fecha.$archivoNombre)){
                	        //Guarda archivo
                	        
                	        
                		}else{
                			//echo "Archivo no se pudo guardar";
                		}
                	}
                }else{
                	if(move_uploaded_file($guardado, '../../archivos/documentosExternos/'.$fecha.$archivoNombre)){
                	    
                	    if($fecha.$archivoNombre != NULL){ 
                		    $mysqli->query("INSERT INTO documentoArchivoTemporal (tipodocumento)VALUES('".utf8_decode($fecha.$archivoNombre)."') ")or die(mysqli_error($mysqli)); 
                		    
                		    $preguntadoValidacion=$mysqli->query("SELECT * FROM documentoArchivoTemporal WHERE  tipodocumento='".utf8_decode($fecha.$archivoNombre)."' ");
                    		$extraerPreguntaValidacion=$preguntadoValidacion->fetch_array(MYSQLI_ASSOC);
                    		   ' - '.$documentoExtraido2=utf8_encode($extraerPreguntaValidacion['tipodocumento']);
                    		    
                    		        
                            
                                     '<br><br>';
                            
                                    //Lista de letras abecedario
                                    $carpeta="../../archivos/documentosExternos/";
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
                                	
                                
                                            unlink(('../../archivos/documentosExternos/'.$fecha.$archivoNombre));
                                            $mysqli->query("DELETE FROM documentoArchivoTemporal WHERE tipodocumento='".utf8_decode($fecha.$archivoNombre)."' ")or die(mysqli_error($mysqli));
                                            
                                	        ?>
                                            <script> 
                                                 window.onload=function(){
                                               
                                                     document.forms["miformulario"].submit();
                                                 }
                                            </script>
                                                     
                                            <form name="miformulario" action="../../documentoExternoEditar" method="POST" onsubmit="procesar(this.action);" >
                                               <input name="idDoc" value="<?php echo $id;?>" type="hidden">
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
                                        $mysqli->query("UPDATE documentoExterno SET  nombre='$nombre', tipo='$tipo', ruta='$ruta' WHERE id = '$id'");
                                    }else{
                                        $ruta='Nohayfoto';
                                        $mysqli->query("UPDATE documentoExterno SET  nombre='$nombre', tipo='$tipo', ruta='$ruta' WHERE id = '$id'");
                                    }
                                    
                                ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformulario"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformulario" action="../../documentoExterno" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionActualizar" value="1">
                                    </form> 
                                <?php    
                                                       
                    
                } 
        
        
        
        
        
            /*    
            if(!file_exists('../../archivos/documentosExternos')){
            mkdir('../../archivos/documentosExternos',0777,true);
            if(file_exists('../../archivos/documentosExternos')){
                if(move_uploaded_file($guardado, '../../archivos/documentosExternos/'.$archivoNombre)){
                    $ruta = 'archivos/documentosExternos/'.$archivoNombre;
                    ///////// consultamos la tabla y extraemos el nombre
    		        //$sql= $mysqli->query("SELECT * FROM documentoExterno WHERE nombre = '$nombre' ");
    		        //$numRows = mysqli_num_rows($sql);
                    //if($numRows > 0){
                    //echo '<script language="javascript">alert("El nombre ya existe.");
                    //window.location.href="../../documentoExterno"</script>';
            
                    //}else{
                    $ruta=utf8_decode($ruta);
                    $mysqli->query("UPDATE documentoExterno SET  nombre='$nombre', tipo='$tipo', ruta='$ruta' WHERE id = '$id'");
                    //$mysqli->query("INSERT INTO documentoExterno (nombre, tipo,ruta) VALUES('$nombre', '$tipo','$ruta' ) ")or die(mysqli_error($mysqli));
    
                    //}
    
                    
                    
                }else{
                    
                }
            }
            
            }else{ 
                if(move_uploaded_file($guardado, '../../archivos/documentosExternos/'.$archivoNombre)){
                        $ruta = 'archivos/documentosExternos/'.$archivoNombre;
                        ///////// consultamos la tabla y extraemos el nombre
                		$sql= $mysqli->query("SELECT * FROM documentoExterno WHERE nombre = '$nombre' ");
                		$numRows = mysqli_num_rows($sql);
                            $ruta=utf8_decode($ruta);
                            $mysqli->query("UPDATE documentoExterno SET  nombre='$nombre', tipo='$tipo', ruta= '$ruta' WHERE id = '$id'");
                
                    }else{
                    
                        
                    }
                
            }
            
            
            
        $mysqli->query("UPDATE documentoExterno SET  nombre='$nombre', tipo='$tipo' WHERE id = '$id'");    
            ?>
                <script> 
                     window.onload=function(){
                   
                         document.forms["miformulario"].submit();
                     }
                </script>
                 
                <form name="miformulario" action="../../documentoExterno" method="POST" onsubmit="procesar(this.action);" >
                    <input type="hidden" name="validacionActualizar" value="1">
                </form> 
            <?php 
            
            */
        }
    }
}

if(isset($_POST['eliminar'])){
    $id = $_POST['idDoc'];
    
        $preguntadoValidacion=$mysqli->query("SELECT * FROM documentoExterno WHERE  id='$id' ");
        $extraerPreguntaValidacion=$preguntadoValidacion->fetch_array(MYSQLI_ASSOC);
        $documentoExtraido2=utf8_encode($extraerPreguntaValidacion['ruta']);
        unlink(('../../archivos/documentosExternos/'.$documentoExtraido2));
       
        $mysqli->query("DELETE FROM documentoExterno WHERE id = '$id'");
   
   //eliminar de tipoDoc
   
   //echo '<script language="javascript">alert("exito al eliminar.");
   //window.location.href="../../documentoExterno"</script>';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../documentoExterno" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminar" value="1">
            </form> 
        <?php
}
?>