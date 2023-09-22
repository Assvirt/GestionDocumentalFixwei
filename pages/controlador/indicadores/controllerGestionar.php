<?php
require_once '../../conexion/bd.php';
mb_internal_encoding("UTF-8");

$quienCrea = $_POST['quienCrea'];
$variablesIdPrincipal = $_POST['variablesIdPrincipal'];
    
$nombre = utf8_decode($_POST['nombre']);
$analisis = $_POST['analisis'];
$mes = $_POST['mes'];
$anoPresente = $_POST['anoPresente'];

$archivoNombre = $_FILES['soporte']['name'];
$guardado = $_FILES['soporte']['tmp_name'];

$validandoDocumentoCaracteresPdf=mb_strtolower($_FILES['soporte']['name']);
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
    ?>
    <script>
            window.onload=function(){
            //alert("Datos almacenados con éxito ");
            document.forms["miformulario"].submit();
        }
    </script>
    <form name="miformulario" action="../../indicadoresGestionar" method="POST" onsubmit="procesar(this.action);" >
        <input type="hidden" name="alerta" value="1">
        <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden">
        <input name="variablesIdPrincipal" value="<?php echo $variablesIdPrincipal; ?>" type="hidden">
    </form>
                                        
    <?php
}else{
    
    
    
    if($archivoNombre != NULL){
    
    
     if(!file_exists('../../archivos/indicadores/')){
        	mkdir('archivos/indicadores/',0777,true);
            	if(file_exists('../../archivos/indicadores/')){
            		if(move_uploaded_file($guardado, '../../archivos/indicadores/'.$archivoNombre)){
            	        //Guarda archivo
            	        
            	        
            		}else{
            			//echo "Archivo no se pudo guardar";
            		}
            	}
            }else{
            	if(move_uploaded_file($guardado, '../../archivos/indicadores/'.$archivoNombre)){
            	    
            	    if($fecha.$archivoNombre != NULL){ 
            		    $mysqli->query("INSERT INTO documentoArchivoTemporal (indicadores)VALUES('".utf8_decode($archivoNombre)."') ")or die(mysqli_error($mysqli)); 
            		    
            		    $preguntadoValidacion=$mysqli->query("SELECT * FROM documentoArchivoTemporal WHERE  indicadores='".utf8_decode($archivoNombre)."' ");
                		$extraerPreguntaValidacion=$preguntadoValidacion->fetch_array(MYSQLI_ASSOC);
                		 ' - '.$documentoExtraido2=utf8_encode($extraerPreguntaValidacion['indicadores']);
                		    
                		        
                        
                                echo '<br><br>';
                        
                                //Lista de letras abecedario
                                $carpeta="../../archivos/indicadores/";
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
            	        
                            	}else{   '<br>Redir..';
                            	
                            
                                        unlink(('../../archivos/indicadores/'.$archivoNombre));
                                        $mysqli->query("DELETE FROM documentoArchivoTemporal WHERE indicadores='".utf8_decode($archivoNombre)."' ")or die(mysqli_error($mysqli));
                                        
                            	        ?>
                                        <script> 
                                             window.onload=function(){
                                           
                                                 document.forms["miformulario"].submit();
                                             }
                                        </script>
                                                 
                                        <form name="miformulario" action="../../indicadoresGestionar" method="POST" onsubmit="procesar(this.action);" >
                                            <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="">
                                            <input name="variablesIdPrincipal" value="<?php echo $variablesIdPrincipal; ?>" type="">
                                            <input name="alerta" value="1" type="">
                                            
                                        </form> 
                                        <?php
                            	   }
            		
                		    
            		}
            	    
            	    
            	   
            	    
            	   
            	}else{
            		//echo "Archivo no se pudo guardar";
            	}
            }
    
    
        if($documentoHabilitado2 == 'no coincide'){
             '<br><br>No almacena';
                                        ?>
                                        <script> 
                                             window.onload=function(){
                                           
                                                 document.forms["miformulario"].submit();
                                             }
                                        </script>
                                                 
                                        <form name="miformulario" action="../../indicadoresGestionar" method="POST" onsubmit="procesar(this.action);" >
                                            <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="">
                                            <input name="variablesIdPrincipal" value="<?php echo $variablesIdPrincipal; ?>" type="">
                                            <input name="alerta" value="1" type="">
                                            
                                        </form> 
                                        <?php
        }else{
              '<br><br>Almacena';
        
    
    
    
            if(!file_exists('../../archivos/indicadores')){
              $ruta = 'archivos/indicadores/'.$archivoNombre;
              
              /////// se valida el archivo antes de guardar para evitar reemplazar el actual o el nombre del archivo
                        $validacion1 = $mysqli->query("SELECT * FROM indicadoresGestionar WHERE quienCrea='$quienCrea' AND idIndicador='$variablesIdPrincipal' AND soporte = '$ruta' AND mes='$mes' ");//consulta a base de datos si el nombre se repite
                            $numNom = mysqli_num_rows($validacion1);
                            if($numNom > 0){
                                ?>
                                    <script>
                                            window.onload=function(){
                                                //alert("El nombre o el archivo ya existen");
                                                document.forms["miformulario"].submit();
                                                }
                                    </script>
                                    <form name="miformulario" action="../../indicadoresGestionar" method="POST" onsubmit="procesar(this.action);" >
                                         <input type="hidden" name="validacionExiste" value="1">
                                        <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden">
                                        <input name="variablesIdPrincipal" value="<?php echo $variablesIdPrincipal; ?>" type="hidden">
                                    </form>
                                    
                                <?php
                            }else{/////////////// fin de la validacion
              
                                mkdir('../../archivos/indicadores',0777,true);
                                if(file_exists('../../archivos/indicadores')){
                                    if(move_uploaded_file($guardado, '../../archivos/indicadores/'.$archivoNombre)){
                                        $ruta = 'archivos/indicadores/'.$archivoNombre;
                                        
                                        
                                        ///////// consultamos la tabla y extraemos el nombre
                        		        //$mysqli->query("UPDATE indicadoresGestionar SET nombreG='$nombre', soporte='$ruta' WHERE id='$variablesIdPrincipal' ")or die(mysqli_error($mysqli));
                        		        $archivoNombre2=utf8_decode($archivoNombre);
                        		        $analisis2=utf8_decode($analisis2);
                                        $mysqli->query("INSERT INTO indicadoresGestionar (idIndicador,nombreG,soporte,quienCrea,documento,mes,anoPresente,analisis) VALUES ('$variablesIdPrincipal','$nombre','$ruta','$quienCrea','$archivoNombre2','$mes','$anoPresente','$analisis2')  ")or die(mysqli_error($mysqli));
                                
                                        ?>
                                            <script>
                                                    window.onload=function(){
                                                        //alert("Datos almacenados con éxito");
                                                        document.forms["miformulario"].submit();
                                                        }
                                            </script>
                                            <form name="miformulario" action="../../indicadoresGestionar" method="POST" onsubmit="procesar(this.action);" >
                                                 <input type="hidden" name="validacionAgregar" value="1">
                                                <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden">
                                                <input name="variablesIdPrincipal" value="<?php echo $variablesIdPrincipal; ?>" type="hidden">
                                            </form>
                                            
                                        <?php
                                            }
                                    }
                                }
                
            }else{
                
                $ruta = 'archivos/indicadores/'.$archivoNombre;
                /////// se valida el archivo antes de guardar para evitar reemplazar el actual o el nombre del archivo
                        $validacion1 = $mysqli->query("SELECT * FROM indicadoresGestionar WHERE quienCrea='$quienCrea' AND idIndicador='$variablesIdPrincipal' AND soporte = '$ruta' AND mes='$mes' ");//consulta a base de datos si el nombre se repite
                        //$confirmarDatos =  $validacion1->fetch_array(MYSQLI_ASSOC);
                        //echo 'cc. '.$confirmarDatos['quienCrea'];
                        //echo '<br>Id. '.$confirmarDatos['idIndicador'];
                        //echo '<br> nombre. '.$confirmarDatos['nombreG'];
                            $numNom = mysqli_num_rows($validacion1);
                            if($numNom > 0){
                                ?>
                                    <script>
                                            window.onload=function(){
                                                //alert("El nombre o el archivo ya existen");
                                                document.forms["miformulario"].submit();
                                                }
                                    </script>
                                    <form name="miformulario" action="../../indicadoresGestionar" method="POST" onsubmit="procesar(this.action);" >
                                         <input type="hidden" name="validacionExiste" value="1">
                                        <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden">
                                        <input name="variablesIdPrincipal" value="<?php echo $variablesIdPrincipal; ?>" type="hidden">
                                    </form>
                                    
                                <?php 
                            }else{/////////////// fin de la validacion
              
                                        //if(move_uploaded_file($guardado, '../../archivos/indicadores/'.$archivoNombre)){  
                                        $ruta = 'archivos/indicadores/'.$archivoNombre; 
                                        
                                    
                                        ///////// consultamos la tabla y extraemos el nombre
                        		        ///$mysqli->query("UPDATE indicadoresGestionar SET nombreG='$nombre', soporte='$ruta' WHERE id='$variablesIdPrincipal' ")or die(mysqli_error($mysqli));
                        		        $archivoNombre2=utf8_decode($archivoNombre);
                        		        $analisis2=utf8_decode($analisis);
                                        $mysqli->query("INSERT INTO indicadoresGestionar (idIndicador,nombreG,soporte,quienCrea,documento,mes,anoPresente,analisis) VALUES ('$variablesIdPrincipal','$nombre','$ruta','$quienCrea','$archivoNombre2','$mes','$anoPresente','$analisis2')  ")or die(mysqli_error($mysqli));
                                
                                        ?>
                                            <script>
                                                    window.onload=function(){
                                                        //alert("Datos almacenados con éxito ");
                                                        document.forms["miformulario"].submit();
                                                        }
                                            </script>
                                            <form name="miformulario" action="../../indicadoresGestionar" method="POST" onsubmit="procesar(this.action);" >
                                                 <input type="hidden" name="validacionAgregar" value="1">
                                                <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden">
                                                <input name="variablesIdPrincipal" value="<?php echo $variablesIdPrincipal; ?>" type="hidden">
                                            </form>
                                            
                                        <?php
                                        //}
                                }
                
            }
    
        }
        
    }else{
        $archivoNombre2=$archivoNombre;
        $analisis2=utf8_decode($analisis);
        $mysqli->query("INSERT INTO indicadoresGestionar (idIndicador,nombreG,quienCrea,mes,anoPresente,analisis) VALUES ('$variablesIdPrincipal','$nombre','$quienCrea','$mes','$anoPresente','$analisis2')  ")or die(mysqli_error($mysqli));
                            
                                    ?>
                                        <script>
                                                window.onload=function(){
                                                    //alert("Datos almacenados con éxito ");
                                                    document.forms["miformulario"].submit();
                                                    }
                                        </script>
                                        <form name="miformulario" action="../../indicadoresGestionar" method="POST" onsubmit="procesar(this.action);" >
                                             <input type="hidden" name="validacionAgregar" value="1">
                                            <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden">
                                            <input name="variablesIdPrincipal" value="<?php echo $variablesIdPrincipal; ?>" type="hidden">
                                        </form>
                                        
                                    <?php
    }


}



?>