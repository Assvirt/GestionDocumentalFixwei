<?php
require_once '../../conexion/bd.php';
mb_internal_encoding("UTF-8");


if(isset($_POST['Agregar'])){
    
$nombre = $_POST['nombre'];
$idProveedor= $_POST['idProveedor'];
$filas = '1';

$archivoNombre = $_FILES['soporte']['name'];
$guardado = $_FILES['soporte']['tmp_name'];


/// actualizamos el estado al momento de ingresar un nuevo documento cuando este se encuentre rechazado


        $consultaCarpeta=$mysqli->query("SELECT * FROM proveedordocumentosCarpetas WHERE id='".$_POST['idCarpeta']."' ");
        $extraerCarpeta=$consultaCarpeta->fetch_array(MYSQLI_ASSOC);
        if($extraerCarpeta['estado'] == 'rechazado'){
            $mysqli->query("UPDATE proveedordocumentosCarpetas SET estado='Pendiente' WHERE  id='".$_POST['idCarpeta']."'  ");
                           
        }
    

/// end
echo $_POST['idCarpetaIdividual'];
echo '<br>'.$_POST['idCarpeta'];
//// validamos la ruta donde se almacena el archivo
                $subConsultaRuta=$mysqli->query("SELECT * FROM proveedorSubCarpetas WHERE id='".$_POST['idCarpetaIdividual']."' ");
                $extraerSubConsultaRuta=$subConsultaRuta->fetch_array(MYSQLI_ASSOC);
                $nombreCarpetaRuta=$extraerSubConsultaRuta['ruta'];
                $consultarRuta=$mysqli->query("SELECT * FROM proveedorSubCarpetas WHERE principal='".$_POST['idCarpeta']."' GROUP BY filas");
                $string="";
                while($extraerRuta=$consultarRuta->fetch_array()){
                                                
                    if($extraerRuta['indicativo'] != NULL){
                                                    
                    }else{
                        $subConsultaRutaPrincipal=$mysqli->query("SELECT * FROM proveedorSubCarpetas WHERE id='".$extraerRuta['principal']."' ");
                        $extraerSubConsultaRutaPrincipal=$subConsultaRutaPrincipal->fetch_array(MYSQLI_ASSOC);
                        echo $string.=($extraerSubConsultaRutaPrincipal['nombre']).'/';
                        
                    }
                                                
                    if($extraerRuta['filas'] <= $_POST['filas']){
                                                    
                    }else{
                        continue;
                    }
                                            
                    echo ($extraerRuta['indicativo']);
                }
                
              echo '<br>Ruta crear: '.$rutaE='../../archivos/documentoProveedor/'.$idProveedor.'/'.$string;
//// end


    /// validams que entre un documento para verificar el registro de archivos
    
    /*
    if($archivoNombre != NULL){
        if(!file_exists('../../archivos/documentoProveedor/')){
    	mkdir('archivos/documentos',0777,true);
        	if(file_exists('../../archivos/documentoProveedor/')){
        		if(move_uploaded_file($guardado, '../../archivos/documentoProveedor/'.$idProveedor.''.$_POST['idCarpeta'].''.$archivoNombre)){
        	        //Guarda archivo
        	        
        	        
        		}else{
        			//echo "Archivo no se pudo guardar";
        		}
        	}
        }else{
        	if(move_uploaded_file($guardado, '../../archivos/documentoProveedor/'.$idProveedor.''.$_POST['idCarpeta'].''.$archivoNombre)){
        	    
        	    if($idProveedor.''.$_POST['idCarpeta'].''.$archivoNombre != NULL){ 
        		    $mysqli->query("INSERT INTO documentoArchivoTemporal (proveedor)VALUES('".utf8_decode($idProveedor.''.$_POST['idCarpeta'].''.$archivoNombre)."') ")or die(mysqli_error($mysqli)); 
        		    
        		    $preguntadoValidacion=$mysqli->query("SELECT * FROM documentoArchivoTemporal WHERE  proveedor='".utf8_decode($idProveedor.''.$_POST['idCarpeta'].''.$archivoNombre)."' ");
            		$extraerPreguntaValidacion=$preguntadoValidacion->fetch_array(MYSQLI_ASSOC);
            		   ' - '.$documentoExtraido2=utf8_encode($extraerPreguntaValidacion['proveedor']);
            		    
            		        
                    
                             '<br><br>';
                    
                            //Lista de letras abecedario
                            $carpeta="../../archivos/documentoProveedor/";
                            $ruta="/".$carpeta."/";
                            $directorio=opendir($carpeta);
                            //recoger los  datos
                            $datos=array();
                            $conteoArchivosB=0;
                            while ($archivo = readdir($directorio)) { 
                              if(($archivo != '.')&&($archivo != '..')){
                                 
                                if($documentoExtraido2 == $datos[]=$archivo){
                                    $conteoArchivosB++;
                                     $datos[]=$archivo;   '<br>';
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
        	       
                        	}else{    '<br>Redir..';
                        	
                        
                                    unlink(('../../archivos/documentoProveedor/'.$idProveedor.''.$_POST['idCarpeta'].''.$archivoNombre));
                                    $mysqli->query("DELETE FROM documentoArchivoTemporal WHERE proveedor='".utf8_decode($idProveedor.''.$_POST['idCarpeta'].''.$archivoNombre)."' ")or die(mysqli_error($mysqli));
                                    
                        	        ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformulario"].submit();
                                         }
                                    </script>
                                             
                                    <form name="miformulario" action="../../proveedorDocumetos" method="POST" onsubmit="procesar(this.action);" >
                                       <input name="idCarpeta" value="<?php echo $_POST['idCarpeta']; ?>" type="hidden" readonly>
                                       <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                                       
                                        <!-- id de la carpeta contenedora-->
                                          <input name="id" value="<?php echo $_POST['id']; ?>" type="hidden">
                                          <!-- Contador para las filas -->
                                          <input name="filas" value="<?php echo $_POST['filas']; ?>" type="hidden">
                                          <!-- mantenemos la carpeta abierta -->
                                          <?php
                                           if($_POST['agregarArchivosDocumentos'] != NULL){
                                          ?>
                                          <input name="agregarArchivosDocumentos" value="1" type="hidden">
                                           <?php
                                          }
                                           ?>
                                          <input name="idCarpetaIdividual" value="<?php echo $_POST['idCarpetaIdividual'];?>" type="hidden"> 
                                          <input name="nombreCarpeta" value="<?php echo $_POST['nombreCarpeta'];?>" type="hidden">
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
        //unlink(('../../archivos/documentoProveedor/'.$idProveedor.''.$_POST['idCarpeta'].''.$archivoNombre));
        $mysqli->query("DELETE FROM documentoArchivoTemporal WHERE proveedor='".utf8_decode($idProveedor.''.$_POST['idCarpeta'].''.$archivoNombre)."' ")or die(mysqli_error($mysqli));
        
        
         '<br><br>Almacena';
       
     
      



//// Se omite validaci贸n de archivo de manera temporal


          if(!file_exists('../../archivos/documentoProveedor')){
              $ruta = 'archivos/documentoProveedor/'.$idProveedor.''.$_POST['idCarpeta'].''.$archivoNombre; 
                
              /////// se valida el archivo antes de guardar para evitar reemplazar el actual o el nombre del archivo
                        $validacion1 = $mysqli->query("SELECT * FROM proveedordocumentos WHERE idProveedor='$idProveedor' AND idCarpeta='".$_POST['idCarpeta']."' AND nombre = '$nombre' ");//consulta a base de datos si el nombre se repite
                            $numNom = mysqli_num_rows($validacion1);
                            if($numNom > 0){
                                ?>
                                    <script>
                                            window.onload=function(){
                                                //alert("El nombre o el archivo ya existen1");
                                                document.forms["miformulario"].submit();
                                                }
                                    </script>
                                    <form name="miformulario" action="../../proveedorDocumetos" method="POST" onsubmit="procesar(this.action);" >
                                       <input name="idCarpeta" value="<?php echo $_POST['idCarpeta']; ?>" type="hidden" readonly>
                                       <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                                       
                                        <!-- id de la carpeta contenedora-->
                                          <input name="id" value="<?php echo $_POST['id']; ?>" type="hidden">
                                          <!-- Contador para las filas -->
                                          <input name="filas" value="<?php echo $_POST['filas']; ?>" type="hidden">
                                          <!-- mantenemos la carpeta abierta -->
                                          <?php
                                           if($_POST['agregarArchivosDocumentos'] != NULL){
                                          ?>
                                          <input name="agregarArchivosDocumentos" value="1" type="hidden">
                                           <?php
                                          }
                                           ?>
                                          <input name="idCarpetaIdividual" value="<?php echo $_POST['idCarpetaIdividual'];?>" type="hidden"> 
                                          <input name="nombreCarpeta" value="<?php echo $_POST['nombreCarpeta'];?>" type="hidden">
                                       
                                       
                                       <input type="hidden" name="validacionExisteD" value="1">
                                    </form>
                                    
                                <?php
                            }else{/////////////// fin de la validacion
              
                                mkdir('../../archivos/documentoProveedor',0777,true);
                                if(file_exists('../../archivos/documentoProveedor')){
                                    if(move_uploaded_file($guardado, '../../archivos/documentoProveedor/'.$idProveedor.''.$_POST['idCarpeta'].''.$archivoNombre)){
                                        $ruta = 'archivos/documentoProveedor/'.$idProveedor.''.$_POST['idCarpeta'].''.$archivoNombre;
                                        
                                      
                                        ///////// consultamos la tabla y extraemos el nombre
                                        $ruta=utf8_decode($ruta);
                        		        $mysqli->query("INSERT INTO proveedordocumentos (idProveedor, nombre, soporte, idCarpeta,ruta,filas) VALUES('$idProveedor','$nombre','$ruta','".$_POST['idCarpeta'].",'$nombre','$filas' ) ")or die(mysqli_error($mysqli));
                                    
                                        ?>
                                            <script>
                                                    window.onload=function(){
                                                        //alert("Datos almacenados con 茅xito");
                                                        document.forms["miformulario"].submit();
                                                        }
                                            </script>
                                            <form name="miformulario" action="../../proveedorDocumetos" method="POST" onsubmit="procesar(this.action);" >
                                               <input name="idCarpeta" value="<?php echo $_POST['idCarpeta']; ?>" type="hidden" readonly>
                                               <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                                               
                                                <!-- id de la carpeta contenedora-->
                                              <input name="id" value="<?php echo $_POST['id']; ?>" type="hidden">
                                              <!-- Contador para las filas -->
                                              <input name="filas" value="<?php echo $_POST['filas']; ?>" type="hidden">
                                              <!-- mantenemos la carpeta abierta -->
                                              <?php
                                               if($_POST['agregarArchivosDocumentos'] != NULL){
                                              ?>
                                              <input name="agregarArchivosDocumentos" value="1" type="hidden">
                                               <?php
                                              }
                                               ?>
                                               <input name="idCarpetaIdividual" value="<?php echo $_POST['idCarpetaIdividual'];?>" type="hidden"> 
                                               <input name="nombreCarpeta" value="<?php echo $_POST['nombreCarpeta'];?>" type="hidden">
                                               
                                               
                                               <input type="hidden" name="validacionAgregar" value="1">
                                            </form>
                                            
                                        <?php
                                            }
                                    }
                                }
                
            }else{  
                 
                //$ruta = 'archivos/documentoProveedor/'.$archivoNombre;
               $ruta = 'archivos/documentoProveedor/'.$idProveedor.''.$_POST['idCarpeta'].''.$archivoNombre;
               
                /////// se valida el archivo antes de guardar para evitar reemplazar el actual o el nombre del archivo
                        $validacion1 = $mysqli->query("SELECT * FROM proveedordocumentos WHERE idProveedor='$idProveedor' AND idCarpeta='".$_POST['idCarpeta']."' AND nombre = '$nombre' ");//consulta a base de datos si el nombre se repite
                            $numNom = mysqli_num_rows($validacion1);
                if($numNom > 0){
                                ?>
                                    <script>
                                            window.onload=function(){
                                                //alert("El nombre o el archivo ya existen");
                                                document.forms["miformulario"].submit();
                                                }
                                    </script>
                                    <form name="miformulario" action="../../proveedorDocumetos" method="POST" onsubmit="procesar(this.action);" >
                                        <input name="idCarpeta" value="<?php echo $_POST['idCarpeta']; ?>" type="hidden" readonly>
                                       <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                                       
                                       
                                       <!-- id de la carpeta contenedora-->
                                          <input name="id" value="<?php echo $_POST['id']; ?>" type="hidden">
                                          <!-- Contador para las filas -->
                                          <input name="filas" value="<?php echo $_POST['filas']; ?>" type="hidden">
                                          <!-- mantenemos la carpeta abierta -->
                                          <?php
                                           if($_POST['agregarArchivosDocumentos'] != NULL){
                                          ?>
                                          <input name="agregarArchivosDocumentos" value="1" type="hidden">
                                           <?php
                                          }
                                           ?>
                                           <input name="idCarpetaIdividual" value="<?php echo $_POST['idCarpetaIdividual'];?>" type="hidden"> 
                                           <input name="nombreCarpeta" value="<?php echo $_POST['nombreCarpeta'];?>" type="hidden">
                                       
                                       
                                       <input type="hidden" name="validacionExisteD" value="1">
                                    </form>
                                    
                                <?php
                }else{/////////////// fin de la validacion
                
                            //if(move_uploaded_file($guardado, '../../archivos/documentoProveedor/'.$idProveedor.''.$_POST['idCarpeta'].''.$archivoNombre)){
                                         $ruta = 'archivos/documentoProveedor/'.$idProveedor.''.$_POST['idCarpeta'].''.$archivoNombre;
                                        
                         
                      'entra aca';  
                    /// si agregamos un documento en una carpeta diferentea la principal, se debe activar este input
                    $ruta=utf8_decode($ruta);
                    if($_POST['idCarpetaIdividual'] != NULL){ //echo 'con ID';
                        $mysqli->query("INSERT INTO proveedordocumentos (idProveedor, nombre, soporte, idCarpeta, indicativo) VALUES('$idProveedor','$nombre','$ruta','".$_POST['idCarpeta']."', '".$_POST['idCarpetaIdividual']."'  ) ")or die(mysqli_error($mysqli));       
                    }else{
                        //echo 'sin ID';
                        $mysqli->query("INSERT INTO proveedordocumentos (idProveedor, nombre, soporte, idCarpeta ) VALUES('$idProveedor','$nombre','$ruta','".$_POST['idCarpeta']."'  ) ")or die(mysqli_error($mysqli));    
                    }   
                       
                    ?>
                                                <script>
                                                       window.onload=function(){
                                                       
                                                            document.forms["miformulario"].submit();
                                                           }
                                                </script>
                                                <form name="miformulario" action="../../proveedorDocumetos" method="POST" onsubmit="procesar(this.action);" >
                                                   <input name="idCarpeta" value="<?php echo $_POST['idCarpeta']; ?>" type="hidden" readonly>
                                                   <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                                                   
                                                   <!-- id de la carpeta contenedora-->
                                                  <input name="id" value="<?php echo $_POST['id']; ?>" type="hidden">
                                                  <!-- Contador para las filas -->
                                                  <input name="filas" value="<?php echo $_POST['filas']; ?>" type="hidden">
                                                  <!-- mantenemos la carpeta abierta -->
                                                  <?php
                                                  if($_POST['agregarArchivosDocumentos'] != NULL){
                                                  ?>
                                                  <input name="agregarArchivosDocumentos" value="1" type="hidden">
                                                   <?php
                                                  }
                                                   ?>
                                                   
                                                   <input name="nombreCarpeta" value="<?php echo $_POST['nombreCarpeta'];?>" type="hidden">
                               
                                                   <input name="idCarpetaIdividual" value="<?php echo $_POST['idCarpetaIdividual'];?>" type="hidden"> 
                                                   
                                                   <input type="hidden" name="validacionAgregar" value="1">
                                                </form>
                                                
                                            <?php
                                                //}
                                                
                                        
                                    }
                                   
                        }     
    
    }
    */
}


if(isset($_POST['eliminar'])){
    $idProveedor= $_POST['idProveedor'];
    $id=$_POST['idA'];
    
    $consulta=$mysqli->query("SELECT * FROM proveedordocumentos WHERE id='$id' ");
    $extraer=$consulta->fetch_array(MYSQLI_ASSOC);
    $documento=utf8_encode($extraer['soporte']);//$extraer['soporte'];
    unlink('../../'.$documento);
    
    
    $mysqli->query("DELETE FROM proveedordocumentos WHERE id='$id' ")or die(mysqli_error($mysqli));
    
    /// actualizamos el estado al momento de ingresar un nuevo documento cuando este se encuentre rechazado


        $consultaCarpeta=$mysqli->query("SELECT * FROM proveedordocumentosCarpetas WHERE id='".$_POST['idCarpeta']."' ");
        $extraerCarpeta=$consultaCarpeta->fetch_array(MYSQLI_ASSOC);
        if($extraerCarpeta['estado'] == 'rechazado'){
            $mysqli->query("UPDATE proveedordocumentosCarpetas SET estado='Pendiente' WHERE  id='".$_POST['idCarpeta']."'  ");
                           
        }
    

/// end                   
    
     ?>
                            <script>
                                    window.onload=function(){
                                        //alert("El nombre o el archivo ya existen1");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../proveedorDocumetos" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idCarpeta" value="<?php echo $_POST['idCarpeta']; ?>" type="hidden" readonly>
                               <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                               
                               
                                <!-- id de la carpeta contenedora-->
                                          <input name="id" value="<?php echo $_POST['id']; ?>" type="hidden">
                                          <!-- Contador para las filas -->
                                          <input name="filas" value="<?php echo $_POST['filas']; ?>" type="hidden">
                                          <!-- mantenemos la carpeta abierta -->
                                          <?php
                                          if($_POST['agregarArchivosDocumentos'] != NULL){
                                          ?>
                                          <input name="agregarArchivosDocumentos" value="1" type="hidden">
                                           <?php
                                          }
                                           ?>
                                           
                                           <input name="nombreCarpeta" value="<?php echo $_POST['nombreCarpeta'];?>" type="hidden">
                       
                                           <input name="idCarpetaIdividual" value="<?php echo $_POST['idCarpetaIdividual'];?>" type="hidden"> 
                               
                               
                               <input type="hidden" name="validacionEliminar" value="1">
                            </form>
                            
                        <?php
}
if(isset($_POST['editar'])){
    
    
    $idProveedor= $_POST['idProveedor'];
    $id=$_POST['idA'];
    $archivoNombre = $_FILES['soporte']['name'];
    $guardado = $_FILES['soporte']['tmp_name'];
    
    if($archivoNombre != NULL){
        $consulta=$mysqli->query("SELECT * FROM proveedordocumentos WHERE id='$id' ");
        $extraer=$consulta->fetch_array(MYSQLI_ASSOC);
        $documento=utf8_encode($extraer['soporte']);
       
        unlink('../../'.$documento);
    }
    
        $consultaCarpeta=$mysqli->query("SELECT * FROM proveedordocumentosCarpetas WHERE id='".$_POST['idCarpeta']."' ");
        $extraerCarpeta=$consultaCarpeta->fetch_array(MYSQLI_ASSOC);
        if($extraerCarpeta['estado'] == 'rechazado'){
            $comentarioUpdate=$extraerCarpeta['comentario'];
            $mysqli->query("UPDATE proveedordocumentosCarpetas SET  estado='Pendiente' WHERE  id='".$_POST['idCarpeta']."'  ");
            //comentario='$comentarioUpdate',
        }
    
    
    if($archivoNombre != NULL){
    
        if(!file_exists('../../archivos/documentoProveedor')){ 
          $ruta = 'archivos/documentoProveedor/'.$idProveedor.''.$_POST['idCarpeta'].''.$archivoNombre;
          
          if($archivoNombre != NULL){
                            mkdir('../../archivos/documentoProveedor',0777,true);
                            if(file_exists('../../archivos/documentoProveedor')){
                                if(move_uploaded_file($guardado, '../../archivos/documentoProveedor/'.$idProveedor.''.$_POST['idCarpeta'].''.$archivoNombre)){
                                    $ruta = 'archivos/documentoProveedor/'.$idProveedor.''.$_POST['idCarpeta'].''.$archivoNombre;
                                    
                                   
                                    ///////// consultamos la tabla y extraemos el nombre
                                    $ruta=utf8_decode($ruta);
                    		            $mysqli->query("UPDATE proveedordocumentos SET nombre='".$_POST['nombre']."', soporte='$ruta' WHERE id='$id'  ");
                    		            
                                   
                                }
                            }
          }else{
               $mysqli->query("UPDATE proveedordocumentos SET nombre='".$_POST['nombre']."' WHERE id='$id'  ");
                                    
          }           
            
        }else{ 
                             
                        $ruta = 'archivos/documentoProveedor/'.$idProveedor.''.$_POST['idCarpeta'].''.$archivoNombre;
                           
                        if($archivoNombre != NULL){    
                            if(move_uploaded_file($guardado, '../../archivos/documentoProveedor/'.$idProveedor.''.$_POST['idCarpeta'].''.$archivoNombre)){
                                $ruta = 'archivos/documentoProveedor/'.$idProveedor.''.$_POST['idCarpeta'].''.$archivoNombre;
                                $ruta=utf8_decode($ruta);     
                    		            $mysqli->query("UPDATE proveedordocumentos SET nombre='".$_POST['nombre']."', soporte='$ruta' WHERE id='$id'  ");
                    		           
                            }        
                                
                        }else{ 
                                $mysqli->query("UPDATE proveedordocumentos SET nombre='".$_POST['nombre']."' WHERE id='$id'  ");
                                    
                        }
                                        
                            
        }
    
    }else{
     $mysqli->query("UPDATE proveedordocumentos SET nombre='".$_POST['nombre']."' WHERE id='$id'  ");   
    }
    
    
    ?>
                            <script>
                                    window.onload=function(){
                                        //alert("El nombre o el archivo ya existen1");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../proveedorDocumetos" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idCarpeta" value="<?php echo $_POST['idCarpeta']; ?>" type="hidden" readonly>
                               <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                               
                               
                                          <!-- id de la carpeta contenedora-->
                                          <input name="id" value="<?php echo $_POST['id']; ?>" type="hidden">
                                          <!-- Contador para las filas -->
                                          <input name="filas" value="<?php echo $_POST['filas']; ?>" type="hidden">
                                          <!-- mantenemos la carpeta abierta -->
                                          <?php
                                          if($_POST['agregarArchivosDocumentos'] != NULL){
                                          ?>
                                          <input name="agregarArchivosDocumentos" value="1" type="hidden">
                                           <?php
                                          }
                                           ?>
                                           
                                           <input name="nombreCarpeta" value="<?php echo $_POST['nombreCarpeta'];?>" type="hidden">
                       
                                           <input name="idCarpetaIdividual" value="<?php echo $_POST['idCarpetaIdividual'];?>" type="hidden">  
                               
                               
                               <input type="hidden" name="validacionActualizar" value="1">
                            </form>
                            
                        <?php
}

if(isset($_POST['aprobador'])){
    $idProveedor= $_POST['idProveedor'];
    $id=$_POST['id'];
    
    if( $_POST['aprobadorDocumento'] == 'rechazado'){
        
         require '../usuarios/libreria/PHPMailerAutoload.php';
         
                $consultaProveedor=$mysqli->query("SELECT * FROM proveedores WHERE id='$idProveedor' ");
                $extraerConsulta=$consultaProveedor->fetch_array(MYSQLI_ASSOC);
                
                $nombreDocEnviar=utf8_encode($extraerConsulta['razonSocial']);
                $realizador=$extraerConsulta['realizador'];
                
                 $mysqli->query("UPDATE proveedores SET notificacion='Rechazado'  WHERE id='$idProveedor'  ");
                
                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$realizador' ");
                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                        $correoResponsable=$columna['correo']; 
                        '<br>';
                        
                                            $consultaNmbreCarpeta=$mysqli->query("SELECT * FROM carpeta WHERE id='".$_POST['carpetaAbrir']."' ");
                                            $extraerNombreCarpeta=$consultaNmbreCarpeta->fetch_array(MYSQLI_ASSOC);
                                            /// reeemplazamos el documento de la carpeta por el nombre de la carpeta principal
                                            $consultaNmbreCarpetaPrimeraCaperta=$mysqli->query("SELECT * FROM carpeta WHERE rol='$idProveedor' AND fila='1' ");
                                            $extraerNombreCarpetaPrimeraCaperta=$consultaNmbreCarpetaPrimeraCaperta->fetch_array(MYSQLI_ASSOC);
                                            '<b>Ruta: '.$enviamosRutaCantenidoCArpeta=str_replace($_POST['idProveedor'],$extraerNombreCarpetaPrimeraCaperta['nombre'],$extraerNombreCarpeta['ruta']).'/';
                                            
                                            
                                            if($extraerNombreCarpeta['nombre'] !=NULL && $extraerNombreCarpeta['fila'] == '1'){
                                                $enviarNombrePrincipalRuta=$extraerNombreCarpeta['nombre'];
                                            }
                                            
                                            //// hacemos el comentario
                                            date_default_timezone_set('America/Bogota');
                                            $fecha1=date('Y-m-j');
                                            $mysqli->query("INSERT INTO proveedoresControlCambio  (idProveedor,comentario,fecha,rol,Usuario)VALUEs('".$_POST['idProveedor']."','".$_POST['comentario']."','$fecha1','".$_POST['rol']."','".$_POST['usuario']."')");
                                            
                                            //// sacamos el último mensaje del rechazo del aprobador
                                            $consultaNmbreMEnsajeAProbador=$mysqli->query("SELECT * FROM proveedoresControlCambio WHERE idProveedor='".$_POST['idProveedor']."' AND rol='Aprobador' ORDER BY id DESC ");
                                            $extraerNombreMEnsajeAProbador=$consultaNmbreMEnsajeAProbador->fetch_array(MYSQLI_ASSOC);
                                           
                                            if($_POST['filaCarpeta'] == '1'){ 
                                                $mensajeCompletar='<p>El contenido de la carpeta principal '.utf8_encode($enviarNombrePrincipalRuta).' del proveedor '.($nombreDocEnviar).' fue rechazado.</p><br>Motivo del rechazo:';
                                            }else{
                                                $mensajeCompletar='<p>El contenido de la ruta '.utf8_encode($enviamosRutaCantenidoCArpeta).' del proveedor '.($nombreDocEnviar).' fue rechazado.</p><br>Motivo del rechazo:';
                                            }
                               

                                            //Create a new PHPMailer instance
                                            $mail = new PHPMailer();
                                            $mail->IsSMTP();
                                            
                                            //Configuracion servidor mail
                                            require '../../correoEnviar/contenido.php';
                                            
                                            //Agregar destinatario
                                            $mail->isHTML(true);
                                            $mail->AddAddress($correoResponsable);
                                            $mail->Subject = utf8_decode('Documento rechazado ');
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
                                            '.$mensajeCompletar.'
                                            <br>
                                            <p>
                                            '.$_POST['comentario'].'
                                            </p>
                                            <br>
                                            <em></em>
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
                       
                        
                        ?>
                            <script>
                                    window.onload=function(){
                                      
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../proveedoresInscripcion" method="POST" onsubmit="procesar(this.action);" >
                               <input type="hidden" name="validacionExisteD" value="1">
                            </form>
                            
                        <?php
                                        
    }else{
    
        date_default_timezone_set('America/Bogota');
        $fecha1=date('Y-m-j');
        $mysqli->query("UPDATE proveedores SET estado='Aprobado', fecha='$fecha1' WHERE id='$idProveedor'  ");
        $mysqli->query("UPDATE proveedores SET notificacion= NULL WHERE id='$idProveedor'  ");
        
        $consultaProveedor=$mysqli->query("SELECT * FROM proveedores WHERe id='$idProveedor' ");
        $extraerConsulta=$consultaProveedor->fetch_array(MYSQLI_ASSOC);
        
        
        
        require '../usuarios/libreria/PHPMailerAutoload.php';
    
                $nombreDocEnviar=utf8_encode($extraerConsulta['razonSocial']);
                $realizador=$extraerConsulta['realizador'];
                
                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$realizador' ");
                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
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
                                            $mail->Subject = utf8_decode('Proveedor aprobado');
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
                                            <p>Los documentos del proveedor <b>'.$nombreDocEnviar.'.</b> fueron aprobados.</p>
                                            <br>
                                            <em></em>
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
                                        
        ?>
                            <script>
                                    window.onload=function(){
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../proveedoresInscripcion" method="POST" onsubmit="procesar(this.action);" >
                               <input type="hidden" name="validacionActualizar" value="1">
                            </form>
                            
                        <?php
    
    
    
    
    }

}


if(isset($_POST['comentarioAgregar'])){
    
    
    date_default_timezone_set('America/Bogota');
    $fecha1=date('Y-m-j');
    
    $mysqli->query("INSERT INTO proveedoresControlCambio  (idProveedor,comentario,fecha,rol,Usuario)VALUEs('".$_POST['idProveedor']."','".$_POST['comentario']."','$fecha1','".$_POST['rol']."','".$_POST['usuario']."')");
    ?>
                            <script>
                                    window.onload=function(){
                                      
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../proveedorDocumetosCarpetasB" method="POST" onsubmit="procesar(this.action);" >
                               <input type='hidden' name='idProveedor' value= '<?php echo $_POST['idProveedor'];?>' > 
                               <input name="filaCarpeta" value="<?php echo $_POST['filaCarpeta']; ?>" type="hidden">
                               <input value="<?php echo $_POST['carpetaAbrir'];?>" name="carpetaAbrir" type="hidden">
                               <input name="abrirCarpeta" value="1" type="hidden">
                            </form>
                            
                        <?php
}
?>