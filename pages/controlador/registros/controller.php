<?php
//Controller registros 
error_reporting(E_ERROR);
date_default_timezone_set("America/Bogota");
require_once '../../conexion/bd.php';
session_start();
$idUser = $_SESSION["session_username"];

if(isset($_POST['actualizarEstado'])){
  
    $idRegistro = $_POST['idRegistro'];
    $idDocumento = $_POST['idDocumento'];
    $fechaAprobacion = date("Y/m/j h:i:s");
    $estado = $_POST['estado'];
    
    $mysqli->query("UPDATE registros SET estado='$estado', fechaAprobacion ='$fechaAprobacion' WHERE id = '$idRegistro'");
    
    ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                     //alert("Estado del registro actualizado.");
                 }
            </script>
             
            <form name="miformulario" action="../../verRegistro" method="POST" onsubmit="procesar(this.action);" >
                 <input type="hidden" name="validacionActualizar" value="1">
                <input type="hidden" name="idDocumento" value="<?php echo $idDocumento;?>">
                <input type="hidden" name="idRegistro" value="<?php echo $idRegistro;?>">
            </form> 
    <?php
    
}

if(isset($_POST['controlCambio'])){
    
    $idRegistro = $_POST['idRegistro'];
    $idDocumento = $_POST['idDocumento'];
    $comentario = utf8_decode($_POST['comentario']);
    $fecha= date("Y/m/j h:i:s");
    $mysqli->query("INSERT INTO controlCambioRegistros (idRegistro, comentario, usuario, fecha) VALUES('$idRegistro','$comentario','$idUser','$fecha')");
    
    ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                     //alert("Estado del registro actualizado.");
                 }
            </script>
             
            <form name="miformulario" action="../../verRegistro" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="idDocumento" value="<?php echo $idDocumento;?>">
                <input type="hidden" name="idRegistro" value="<?php echo $idRegistro;?>">
            </form> 
    <?php
    
}


if(isset($_POST['actualizarRegistro'])){
    
    $radioBtnDocumento = $_POST['radiobtn1'];
    $ruta = $_POST['ruta'];
    
    if($_POST['idDocumenton'] == null || $_POST['proceso'] == null || $_POST['tipoDoc'] == null){
        $idDocumento = $_POST['idDocumento2']; 
        $idProceo = $_POST['idProceso2']; 
        $idTipoDocumento = $_POST['idTipoDoc2'];
    }else{
        $idDocumento = $_POST['idDocumenton']; 
        $idProceo = $_POST['proceso']; 
        $idTipoDocumento = $_POST['tipoDoc'];
    }
    
    
    $centroTrabajo = json_encode($_POST['cTrabajo']);
    $idRegistro = $_POST['idRegistro'];
    $nombreDoc = utf8_decode($_POST['nombre']);
    $nombreArchivo = $_FILES['archivo']['name']; 
    $rutaArchivo = $_FILES['archivo']['tmp_name'];
    $html = $_POST['editor1'];
    $fechaCreacion = date("Y/m/j h:i:s");
    $estado = $_POST['estado'];
    
    if($estado == 'Rechazado'){
        $estado = "Pendiente";
    }else{
        $estado = $_POST['estado'];
    }
    
    
    if($_POST['radiobtn'] == "no"){
        $radiobtnAR = null;
        $encargadoRegistros = null;
        $estado = "Aprobado";
    }else{
        $radiobtnAR = $_POST['radiobtnAR'];
        $encargadoRegistros = json_encode($_POST['select_encargadoR']);
        $estado = "Pendiente";
    }
    
    if($nombreArchivo != NULL){
        
        $fecha = date("Ymjhis");
        $nombre = $fecha.$nombreArchivo;
        
        if(!file_exists('../../archivos/registros/')){
            mkdir('../../archivos/registros',0777,true);
        	if(file_exists('../../archivos/registros/')){
        		if(move_uploaded_file($rutaArchivo, '../../repositorio/'.$nombre)){
        		
        		}else{
        			//echo "Archivo no se pudo guardar";
        		}
        	}
        }else{
            
        	if(move_uploaded_file($rutaArchivo, '../../repositorio/'.$nombre)){
        	    
        	}else{
        		//echo "Archivo no se pudo guardar";
        	}
        }    
    
        $mysqli->query("UPDATE registros SET nombreDocumento='$nombre' WHERE id ='$idRegistro'");

    }
    
    if($radioBtnDocumento == 'no'){
        $mysqli->query("UPDATE registros SET idDocumento = NULL, idProceso = NULL, idTipoDocumento=NULL, idCentroTrabajo ='$centroTrabajo', nombre = '$nombreDoc',html='$html', aprobador='$radiobtnAR',aprobadorID='$encargadoRegistros',estado='$estado' WHERE id ='$idRegistro'")or die(mysqli_error($mysqli));
    }else{
        $mysqli->query("UPDATE registros SET idDocumento = '$idDocumento', idProceso ='$idProceo', idTipoDocumento='$idTipoDocumento', idCentroTrabajo ='$centroTrabajo', nombre = '$nombreDoc',html='$html',aprobador='$radiobtnAR',aprobadorID='$encargadoRegistros',estado='$estado' WHERE id ='$idRegistro'")or die(mysqli_error($mysqli));
    }
    
    
    ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                     alert("Registro actualizado.");
                 }
            </script>
             
            <form name="miformulario" action="../../editarRegistro" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="idDocumento" value="<?php echo $idDocumento;?>">
                <input type="hidden" name="idRegistro" value="<?php echo $idRegistro;?>">
                <input type="hidden" name="ruta" value="<?php echo $ruta;?>">
            </form> 
    <?php
    
}

if(isset($_POST['AgregarRegistro'])){


    
    $ruta = $_POST['ruta'];
    $rutaSubir = $_POST['rutaSubir'];
    $usuario = $_POST["usuario"];
    //var_dump($usuario);
    //echo "aqui esta la ruta a la que hace redirct".$rutaSubir;
    $fechaCreacion = date("Y/m/j h:i:s");
    $radiobtnARs = $_POST['radiobtnAut'];
    $encargadoVer = json_encode($_POST['select_encargadoAut']);
    
    
    
    /// volvemos el texto totalmente en minuscula
    $validandoDocumentoCaracteresPdf=mb_strtolower($_FILES['archivo']['name']);
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
                                                                   document.forms["miformularioAlerta"].submit();
                                                                 }
                                                            </script>
                                                             
                                                            <form name="miformularioAlerta" action="../../cargarRegistros" method="POST" onsubmit="procesar(this.action);" >
                                                                <input type="hidden" value="<?php echo $_POST['nombre'];?>" name="nombre">
                                                                <input type="hidden" value="1" name="alerta">
                                                            </form> 
                                                        <?php 
    }else{
    
        if($encargadoVer == 'null'){
            ?>
                <script> 
                     window.onload=function(){
                        
                        //alert("Error, Asegurese de asignar usuarios para visualización");
                        document.forms["miformulario"].submit();
                         
                     }
                </script>
                 
                <form name="miformulario" action="../../repositorio" method="POST" onsubmit="procesar(this.action);" >
                    <input type="hidden" name="validacionExiste" value="1">
                    <!-- Carpeta creada-->
                    <input type="hidden" name="verCarpetaCreada" value="<?PHP echo $ruta;?>">
                </form> 
            <?php 
        }else{
        
           if($_POST['radiobtn1'] == 'si'){
                $idDocumento = $_POST['idDocumento']; 
                $idProceo = $_POST['proceso']; 
                $idTipoDocumento = $_POST['tipoDoc']; 
            }
            
            $centroTrabajo = json_encode($_POST['cTrabajo']);
            
            $nombreDoc = $_POST['nombre'];
            $nombreArchivo = $_FILES['archivo']['name']; 
            $rutaArchivo = $_FILES['archivo']['tmp_name'];
            
            $info = new SplFileInfo($nombreArchivo);
            //var_dump($info->getExtension());
            $extension = $info->getExtension();
            
            
             // funcion para quitar espacios
                function Quitar_Espacios($nombreDoc)
                {
                    $array = explode(' ',$nombreDoc);  // convierte en array separa por espacios;
                    $nombreDoc ='';
                    // quita los campos vacios y pone un solo espacio
                    for ($i=0; $i < count($array); $i++) { 
                        if(strlen($array[$i])>0) {
                            $nombreDoc.= ' ' . $array[$i];
                        }
                    }
                  return  trim($nombreDoc);
                }
                /// END
               
                $nombreDoc = Quitar_Espacios($nombreDoc);
            
            
            $var = '../../'.$ruta.$nombreArchivo;//$nombreDoc.".".$extension;
            
           
            if(file_exists($var)){
                
                //echo '<script language="javascript">confirm("Ya existe un registro con ese nombre");</script>';
                ?>
                    <script> 
                         window.onload=function(){
                            
                            //alert("Ya existe un registro con ese nombre");
                            document.forms["miformulario"].submit();
                             
                         }
                    </script>
                     
                    <form name="miformulario" action="../../repositorio" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="validacionExisteR" value="1">
                        <!-- Carpeta creada-->
                        <input type="hidden" name="verCarpetaCreada" value="<?PHP echo $rutaSubir;?>">
                    </form> 
                <?php 
            
            }else{
             
           
            
            
             
            
            $info = new SplFileInfo($nombreArchivo);
            //var_dump($info->getExtension());
            $extension = $info->getExtension();
            //echo "la extension es ".$extension;
            //echo "nombre ".$nombreDoc;
            
            
          if($nombreArchivo != NULL){
                
                $fecha = date("Ymjhis");
                $nombre = $fecha.$nombreArchivo;
                
                //echo "la ruta ".$ruta;
                
                
                if(!file_exists('../../'.$ruta)){
                    mkdir('../../archivos/registros',0777,true);
                	if(file_exists('../../'.$ruta)){
                	    
                		if(move_uploaded_file($rutaArchivo, '../../raiz/'.$ruta.$nombreArchivo)){ //$nombreDoc.$extension
                		   
                		}else{
                			//echo "Archivo no se pudo guardar";
                			 ?>
                            <script> 
                                 window.onload=function(){
                                    
                                    //alert("Ya existe un registro con ese nombre");
                                    document.forms["miformulario"].submit();
                                     
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../repositorio" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionExisteRR" value="1">
                                <!-- Carpeta creada-->
                                <input type="hidden" name="verCarpetaCreada" value="<?PHP echo $rutaSubir;?>">
                            </form> 
                        <?php 
                		}
                	}
                }else{
                         "entro al else".$rutaArchivo."-> ".$nombre;
                       // echo $ruta.$nombreDoc.'.'.$extension;
                	if(move_uploaded_file($rutaArchivo, '../../'.$ruta.$nombreArchivo)){ //$nombreDoc.'.'.$extension
                	    
                	    
                	}else{
                		//echo "Archivo no se pudo guardar";
                		  ?>
                            <script> 
                                 window.onload=function(){
                                    
                                    //alert("Ya existe un registro con ese nombre");
                                    document.forms["miformulario"].submit();
                                     
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../repositorio" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionExisteRR" value="1">
                                <!-- Carpeta creada-->
                                <input type="hidden" name="verCarpetaCreada" value="<?PHP echo $rutaSubir;?>">
                            </form> 
                        <?php 
                	}
                }   
            }
            
               
           
            //var_dump($idProceo);
            //$idDocumento; 
            
            $ruta = utf8_decode($ruta);
            
            $nombre = utf8_decode($nombre);
            $nombreDoc = utf8_decode($nombreDoc);
            //echo $ruta;
            //var_dump($nombre);
           
            $explorando=explode(".",$nombreArchivo);
            $enviarSinExtension= $explorando[0];
           
            if($_POST['radiobtn1'] == 'no'){
                
                //var_dump($usuario); $nombreDoc
               $mysqli->query("INSERT INTO repositorioRegistro (nombre, idCentroTrabajo, ruta,extension,
                                                                 visualizar, visualizarID, fechaCreacion,realiza) VALUES 
                                                                    ('$enviarSinExtension',
                                                                    '$centroTrabajo',
                                                                    '$ruta',
                                                                    '$extension',
                                                                    '$radiobtnARs',
                                                                    '$encargadoVer',
                                                                    '$fechaCreacion','$usuario')")or die(mysqli_error($mysqli));
            }else{
                $mysqli->query("INSERT INTO repositorioRegistro (idDocumento,nombre, idProceso, idTipoDoc, idCentroTrabajo, ruta,extension,
                                                                 visualizar, visualizarID, fechaCreacion,realiza) VALUES 
                                                    ('$idDocumento',
                                                    '$enviarSinExtension',
                                                    '$idProceo',
                                                    '$idTipoDocumento',
                                                    '$centroTrabajo',
                                                    '$ruta',
                                                    '$extension',
                                                    '$radiobtnARs',
                                                    '$encargadoVer',
                                                    '$fechaCreacion','$usuario')")or die(mysqli_error($mysqli));
            }
             
           
            ?>
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformulario"].submit();
                             //alert("Registro agregado");
                         }
                    </script>
                     
                    <form name="miformulario" action="../../repositorio" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="validacionAgregar" value="1">
                        <input type="hidden" name="verCarpetaCreada" value="<?PHP echo $rutaSubir;?>">
                    </form> 
            <?php   
         
            
            
        }
    
        }
    }
}

if(isset($_POST['editarRegistro'])){
    
    
    $ruta = $_POST["ruta"];
    $nombre = $_POST["nombreArchivo"];
    $nombreAnterior = $_POST["nombreAntes"];
    $extension = $_POST["extension"];
    $radiobtnARs = $_POST['radiobtnAut'];
    $encargadoVer = json_encode($_POST['select_encargadoAut']);
    
    
    
    /// volvemos el texto totalmente en minuscula
    $validandoDocumentoCaracteresPdf=mb_strtolower($_FILES['archivo']['name']);
    $subirdocumentoArchivos=$_FILES['archivo']['tmp_name'];;
    $activarAlerta=TRUE;
                
    $descripcion_carecteres = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ0123456789-_,.()/ ";
    for ($i=0; $i<strlen($validandoDocumentoCaracteresPdf); $i++){
        if (strpos($descripcion_carecteres, substr($validandoDocumentoCaracteresPdf,$i,1))===false){
            $validandoDocumentoCaracteresPdf . " no es válido<br>";
            $activarAlerta=FALSE;
            //return false;
        }
    }
                
    if($activarAlerta == FALSE && $validandoDocumentoCaracteresPdf != NULL){ 
        ?>
        <script> 
             window.onload=function(){
               document.forms["miformularioAlertaDocumentos"].submit();
             }
        </script>
                                                             
        <form name="miformularioAlertaDocumentos" action="../../repositorioEditar" method="POST" onsubmit="procesar(this.action);" >
            <input type="hidden" name="rutaEditar" value="<?php echo $_POST['var'];?>"><br>
            <input type="hidden" name="nombre" value="<?php echo $_POST['var2'];?>"><br>
            <input type="hidden" value="<?php echo $_POST['verCarpetaCreada'];?>" name='verCarpetaCreada'><br>
            <input type="hidden" value="1" name="alerta">
        </form> 
        <?php 
    }else{
    
        if($encargadoVer == 'null'){
            ?>
                <script> 
                     window.onload=function(){
                        
                        //alert("Error, Asegurese de asignar usuarios para visualización");
                        document.forms["miformulario"].submit();
                         
                     }
                </script>
                 
                <form name="miformulario" action="../../repositorio" method="POST" onsubmit="procesar(this.action);" >
                    <input type="hidden" name="validacionExiste" value="1">
                    <!-- Carpeta creada-->
                    <input type="hidden" name="verCarpetaCreada" value="<?PHP echo $ruta;?>">
                </form> 
            <?php 
        }else{
    
        $nombreAnterior2 = utf8_decode($nombreAnterior);
        $ruta2 = utf8_decode($ruta);
    
        $trearData = $mysqli->query("SELECT * FROM repositorioRegistro WHERE nombre ='$nombreAnterior2' AND extension='$extension' AND ruta='$ruta2' ");
        $datos = $trearData->fetch_array(MYSQLI_ASSOC);
        $id  = $datos['id'];
        $nombreValidar=$datos['nombre'];
        
        //echo "este es el id del archivo :".$id." y este es el nombre ".$nombre;
        // repositorioRegistro SET nombre = 'no reporte' WHERE id = 4;
        $nombre2 = utf8_decode($nombre);
        
            // funcion para quitar espacios
            function Quitar_Espacios($nombre2)
            {
                $array = explode(' ',$nombre2);  // convierte en array separa por espacios;
                $nombre2 ='';
                // quita los campos vacios y pone un solo espacio
                for ($i=0; $i < count($array); $i++) { 
                    if(strlen($array[$i])>0) {
                        $nombre2.= ' ' . $array[$i];
                    }
                }
              return  trim($nombre2);
            }
            /// END
           
            $nombre2 = Quitar_Espacios($nombre2);
            
            
            
            
            if($nombre2 == $nombreValidar){
                //echo 'Se actualiza';
                ?>
                        <script> 
                             window.onload=function(){
                           
                                 document.forms["miformulario"].submit();
                                 //alert("Registro Editado");
                             }
                        </script>
                         
                        <form name="miformulario" action="../../repositorio" method="POST" onsubmit="procesar(this.action);" >
                            <input type="hidden" name="validacionActualizar" value="1">
                            <input type="hidden" name="verCarpetaCreada" value="<?PHP echo $ruta;?>">  
                        </form> 
                <?php 
                
                /// buscamos la ruta del documento para eliminarlo antes
                $varArchivoN =$validandoDocumentoCaracteresPdf;
                $explorandoN=explode(".",$varArchivoN);
                $enviarSinExtensionN= $explorandoN[0];
                $enviarConExtensionN= $explorandoN[1];
                
                    
                if($validandoDocumentoCaracteresPdf != NULL){
                        
                        // si viene un archivo, no nos dejará cambiar el nombre, pero eliminamos el archivo anterior para subir uno nuevo
                        $varArchivo =$_POST['var2'];
                        $explorando=explode(".",$varArchivo);
                        $enviarSinExtension= $explorando[0];
                        $enviarConExtension= $explorando[1];
    
                        
                        $trearData = $mysqli->query("SELECT * FROM repositorioRegistro WHERE nombre ='$enviarSinExtension' AND extension='$enviarConExtension' AND ruta='$var'  ");
                        $datos = $trearData->fetch_array(MYSQLI_ASSOC);
                        
                        $archivo = "../../".$ruta.$_POST['var2'];
                        "<br>el archivo es : ".$archivo;
                         unlink($archivo);
                        //echo '<br>documento a cargar';
                        
                        $varArchivoN =$validandoDocumentoCaracteresPdf;
                        $explorandoN=explode(".",$varArchivoN);
                        $enviarSinExtensionN= $explorandoN[0];
                        $enviarConExtensionN= $explorandoN[1];
                        
                        $uploadFileDir = '../../raiz/';
                        $dest_path = $uploadFileDir.$_POST["nombreArchivo"].'.'.$enviarConExtensionN;
                        if(move_uploaded_file($subirdocumentoArchivos, $dest_path))
                        {
                           '<br>'.$message ='Si';
                        }
                        else
                        {
                           '<br>'.$message = 'No';
                        }
                        
                    
                        $mysqli->query("UPDATE repositorioRegistro SET nombre = '$nombre2', extension='$enviarConExtensionN', visualizar = '$radiobtnARs', visualizarID = '$encargadoVer' WHERE repositorioRegistro.id = '$id' ") or die(mysqli_error($mysqli));
                
                    
                }else{
                    $mysqli->query("UPDATE repositorioRegistro SET visualizar = '$radiobtnARs', visualizarID = '$encargadoVer' WHERE repositorioRegistro.id = '$id' ") or die(mysqli_error($mysqli));
                }
            }else{
                //echo 'Entra a verificar si el nombre existe';
                 $trearDataVerificar = $mysqli->query("SELECT * FROM repositorioRegistro WHERE nombre ='$nombre2' AND extension='$extension' ");
                 $datosVerificar = $trearDataVerificar->fetch_array(MYSQLI_ASSOC);
                 
                 if($datosVerificar['nombre'] == $nombre2){
                    // echo '<br>existe';
                     ?>
                        <script> 
                             window.onload=function(){
                           
                                 document.forms["miformulario"].submit();
                                 //alert("Registro Editado");
                             }
                        </script>
                         
                        <form name="miformulario" action="../../repositorio" method="POST" onsubmit="procesar(this.action);" >
                            <input type="hidden" name="validacionExisteR" value="1">
                            <input type="hidden" name="verCarpetaCreada" value="<?PHP echo $ruta;?>">  
                        </form> 
                <?php  
                 }else{
                    //echo '<br>Actualizado<br>';
                    
                    /// buscamos la ruta del documento para eliminarlo antes
                    
                        $varArchivoN =$validandoDocumentoCaracteresPdf;
                        $explorandoN=explode(".",$varArchivoN);
                        $enviarSinExtensionN= $explorandoN[0];
                        $enviarConExtensionN= $explorandoN[1];
                    
                    
                    
                    
                    if($validandoDocumentoCaracteresPdf != NULL){
                        $mysqli->query("UPDATE repositorioRegistro SET nombre = '$nombre2', extension='$enviarConExtensionN', visualizar = '$radiobtnARs', visualizarID = '$encargadoVer' WHERE repositorioRegistro.id = '$id' ") or die(mysqli_error($mysqli));
                    }else{
                        $mysqli->query("UPDATE repositorioRegistro SET nombre = '$nombre2', visualizar = '$radiobtnARs', visualizarID = '$encargadoVer' WHERE repositorioRegistro.id = '$id' ") or die(mysqli_error($mysqli));
                    }
                    // funcion para quitar espacios 
                    function Quitar_EspaciosB($nombre)
                    {
                        $arrayB = explode(' ',$nombre);  // convierte en array separa por espacios;
                        $nombre ='';
                        // quita los campos vacios y pone un solo espacio
                        for ($i=0; $i < count($arrayB); $i++) { 
                            if(strlen($arrayB[$i])>0) {
                                $nombre.= ' ' . $arrayB[$i];
                            }
                        }
                      return  trim($nombre);
                    }
                    /// END
                   
                    $nombre = Quitar_EspaciosB($nombre);
                
                    if($validandoDocumentoCaracteresPdf != NULL){ // si viene un archivo, no nos dejará cambiar el nombre, pero eliminamos el archivo anterior para subir uno nuevo
                        
                        $varArchivo =$_POST['var2'];
                        $explorando=explode(".",$varArchivo);
                        $enviarSinExtension= $explorando[0];
                        $enviarConExtension= $explorando[1];
    
                        
                        $trearData = $mysqli->query("SELECT * FROM repositorioRegistro WHERE nombre ='$enviarSinExtension' AND extension='$enviarConExtension' AND ruta='$var'  ");
                        $datos = $trearData->fetch_array(MYSQLI_ASSOC);
                        
                        $archivo = "../../".$ruta.$_POST['var2'];
                        "<br>el archivo es : ".$archivo;
                         unlink($archivo);
                        //echo '<br>documento a cargar';
                        
                        $varArchivoN =$validandoDocumentoCaracteresPdf;
                        $explorandoN=explode(".",$varArchivoN);
                        $enviarSinExtensionN= $explorandoN[0];
                        $enviarConExtensionN= $explorandoN[1];
                        
                        $uploadFileDir = '../../raiz/';
                        $dest_path = $uploadFileDir.$_POST["nombreArchivo"].'.'.$enviarConExtensionN;
                        if(move_uploaded_file($subirdocumentoArchivos, $dest_path))
                        {
                           '<br>'.$message ='Si';
                        }
                        else
                        {
                           '<br>'.$message = 'No';
                        }
                        
                    }else{
                        $old = "../../".$ruta.$nombreAnterior.".".$extension;
                        
                        $new = "../../".$ruta.$nombre.".".$extension;
                        
                        //echo "archivo viejo ".$old."archivo nuevo ".$new;
                        rename ("$old", "$new");
                    }
                    ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../repositorio" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionActualizar" value="1">
                                <input type="hidden" name="verCarpetaCreada" value="<?PHP echo $ruta;?>">  
                            </form> 
                    <?php 
                }
            }
            
             
        }
    }
}

if(isset($_POST['eliminar'])){
    
    echo $idRegistro = $_POST['idRegistro'];
    echo $ruta = $_POST['ruta'];
    
    //$mysqli->query("DELETE FROM repositorioRegistro WHERE id = '$idRegistro'");
    
    /*
    ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                     alert("Registro Eliminado");
                 }
            </script>
             
            <form name="miformulario" action="../../listaRegistros.php" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="ruta" value="<?php echo $ruta;?>">
                
            </form> 
    <?php */      
}

?>