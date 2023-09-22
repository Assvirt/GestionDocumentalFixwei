<?php
require_once'../../conexion/bd.php';


if(isset($_POST['carpetaAgregar'])){ 
    //// declaración de variables
    $nombre=$_POST['nombre'];
    $rolUsuario=$_POST['documentoUsuario'];//$_POST['rolUsuario'];
    
    
    //// se crea la primera carpeta del usuario, se guarda con el cc y las subcarpetas con el nombre asignado
    if($_POST['primera'] == 1){
        //$rutaCarpeta='../../archivos/documentoProveedor/'.$_POST['documentoUsuario'];
        $rutaCarpeta='../../archivos/documentoProveedor/'.$_POST['documentoUsuario'];
        $guardarRuta=$_POST['documentoUsuario'];
    }else{
        
        
        $recorriendoCarpetas=$mysqli->query("SELECT * FROM carpeta WHERE id='".$_POST['carpetaAbrir']."' ");
        $string="";
        while($extraerRecorriendoCarpetas=$recorriendoCarpetas->fetch_array()){
             'consutruir ruta: '.$string .=utf8_encode($extraerRecorriendoCarpetas['ruta']).'/';
            
        }
         '<br>Completando: '.$completandoRuta=$string.''.$nombre;
         '<br><br>';
        
         $rutaCarpeta='../../archivos/documentoProveedor/'.$completandoRuta;
         '<br><br>';
         $guardarRuta=$completandoRuta;
        $abrirCarpeta='1';
    }
   
    
    if(file_exists($rutaCarpeta)){
        //// alerta si existe la carpeta
            ?>
            <script>
            window.onload=function(){
               // alert("La carpeta ya existe");
                document.forms["miformulario"].submit();
            }
            </script>
        <?php
        if($_POST['masivoEnviar'] != NULL){
        ?>
            <form name="miformulario" action="../../subirDocumentoMasivo" method="POST" onsubmit="procesar(this.action);" >
                 <input name="idProveedor" value="<?php echo $_POST['idProveedor']; ?>" type="hidden" readonly>
                 <input name="masivoEnviar" type="hidden" value="1">
                 <?php 
                 if($_POST['primera'] == 1){ 
                     
                 }else{
                ?>
                    <input name="abrirCarpeta" value="<?php echo $abrirCarpeta;?>" type="hidden" readonly>
                <?php
                 }
                ?>
                <input name="carpetaAbrir" value="<?php echo $_POST['carpetaAbrir'];?>" type="hidden" readonly>
                <input name="validacionExiste" value="1" type="hidden">
            </form>
        <?php    
        }else{
        ?>
            <form name="miformulario" action="../../proveedorDocumetosCarpetasB" method="POST" onsubmit="procesar(this.action);" >
                 <input name="idProveedor" value="<?php echo $_POST['idProveedor']; ?>" type="hidden" readonly>
                 <?php 
                 if($_POST['primera'] == 1){ 
                     
                 }else{
                ?>
                    <input name="abrirCarpeta" value="<?php echo $abrirCarpeta;?>" type="hidden" readonly>
                <?php
                 }
                ?>
                <input name="carpetaAbrir" value="<?php echo $_POST['carpetaAbrir'];?>" type="hidden" readonly>
                <input name="validacionExiste" value="1" type="hidden">
            </form>
        <?php
        }
    }else{
        /// si no existe la carpeta nos permite crearla
        
        if(!mkdir($rutaCarpeta, 0777, true)) {
            //// error al crear la carpeta
            ?>
            <script>
            window.onload=function(){
                //alert("Error al crear carpeta");
                document.forms["miformulario"].submit();
            }
            </script>
            <?php
            if($_POST['masivoEnviar'] != NULL){
            ?>
                <form name="miformulario" action="../../subirDocumentoMasivo" method="POST" onsubmit="procesar(this.action);" >
                     <input name="idProveedor" value="<?php echo $_POST['idProveedor']; ?>" type="hidden" readonly>
                     <input name="masivoEnviar" type="hidden" value="1">
                     <?php 
                     if($_POST['primera'] == 1){ 
                         
                     }else{
                    ?>
                        <input name="abrirCarpeta" value="<?php echo $abrirCarpeta;?>" type="hidden" readonly>
                    <?php
                     }
                    ?>
                    <input name="carpetaAbrir" value="<?php echo $_POST['carpetaAbrir'];?>" type="hidden" readonly>
                    <input name="validacionExisteB" value="1" type="hidden">
                </form>
            <?php
            }else{
            ?>
                <form name="miformulario" action="../../proveedorDocumetosCarpetasB" method="POST" onsubmit="procesar(this.action);" >
                    <input name="idProveedor" value="<?php echo $_POST['idProveedor']; ?>" type="hidden" readonly>
                    <?php 
                     if($_POST['primera'] == 1){ 
                         
                     }else{
                    ?>
                        <input name="abrirCarpeta" value="<?php echo $abrirCarpeta;?>" type="hidden" readonly>
                    <?php
                     }
                    ?>
                    <input name="carpetaAbrir" value="<?php echo $_POST['carpetaAbrir'];?>" type="hidden" readonly>
                    <input name="validacionExisteB" value="1" type="hidden">
                </form>
                <?php
            }   
        }else{
            //// carpeta creada
            if($_POST['primera'] == 1){
                $nombre=utf8_decode($nombre);
                $guardarRuta=utf8_decode($guardarRuta);
                $mysqli->query("INSERT INTO carpeta (nombre,rol,ruta,fila,idsubcarpeta)VALUES('$nombre','$rolUsuario','$guardarRuta','".$_POST['primera']."','0') ")or die (mysqli_error($mysqli));  
                /// actualizamos el bloqueo de la carpeta en proveedor
                $mysqli->query("UPDATE proveedores SET bloqueoCarpeta='1' WHERE id='".$_POST['idProveedor']."' ");
            }else{
                $nombre=utf8_decode($nombre);
                $guardarRuta=utf8_decode($guardarRuta);
                $mysqli->query("INSERT INTO carpeta (nombre,rol,ruta,fila,idsubcarpeta)VALUES('$nombre','$rolUsuario','$guardarRuta','".$_POST['primera']."','".$_POST['carpetaAbrir']."') ")or die (mysqli_error($mysqli));  
            }
            ?>
            <script>
            window.onload=function(){
                
                document.forms["miformulario"].submit();
            }
            </script>
        
            <?php
            if($_POST['masivoEnviar'] != NULL){
            ?>
                <form name="miformulario" action="../../subirDocumentoMasivo" method="POST" onsubmit="procesar(this.action);" >
                     <input name="idProveedor" value="<?php echo $_POST['idProveedor']; ?>" type="hidden" readonly>
                     <input name="masivoEnviar" type="hidden" value="1">
                     <?php 
                     if($_POST['primera'] == 1){ 
                         
                     }else{
                    ?>
                        <input name="abrirCarpeta" value="<?php echo $abrirCarpeta;?>" type="hidden" readonly>
                    <?php
                     }
                    ?>
                    <input name="carpetaAbrir" value="<?php echo $_POST['carpetaAbrir'];?>" type="hidden" readonly>
                    <input name="validacionAgregar" value="1" type="hidden">
                </form>
            <?php
            }else{
            ?>
            <form name="miformulario" action="../../proveedorDocumetosCarpetasB" method="POST" onsubmit="procesar(this.action);" >
                <input name="idProveedor" value="<?php echo $_POST['idProveedor']; ?>" type="hidden" readonly>
                <?php 
                 if($_POST['primera'] == 1){ 
                     
                 }else{
                ?>
                    <input name="abrirCarpeta" value="<?php echo $abrirCarpeta;?>" type="hidden" readonly>
                <?php
                 }
                ?>
                <input name="carpetaAbrir" value="<?php echo $_POST['carpetaAbrir'];?>" type="hidden" readonly>
                <input name="validacionAgregar" value="1" type="hidden">
            </form>
            <?php
            }
        }
    }
    
}

if(isset($_POST['carpetaEditar'])){ 
    
    $id=$_POST['idDestino'];
    $nombre=utf8_decode($_POST['nombre']);
    $nombreAnterior=utf8_decode($_POST['nombreAnterior']);
    
    
   
    
   
        $recorriendoCarpetas=$mysqli->query("SELECT * FROM carpeta WHERE id='$id' ");
        $string="";
        while($extraerRecorriendoCarpetas=$recorriendoCarpetas->fetch_array()){
            'consutruir ruta: '.$string .=($extraerRecorriendoCarpetas['ruta']);
            
        }
        //// ruta anterior
        $string;
        
        //// reemplezamos la ruta anterior por una nueva para editar la carpeta
         $rutaActualizar=str_replace("$nombreAnterior","$nombre","$string");
        
          '<br>';
          $rutaActualizarAnterior='../../archivos/documentoProveedor/'.utf8_encode($string);
          '<br>'.$rutaActualizarNuevo='../../archivos/documentoProveedor/'.utf8_encode($rutaActualizar);
          '<br><br>';
        
        //// reemplazamos el nombre de la carpeta según la ruta
        rename("$rutaActualizarAnterior","$rutaActualizarNuevo");
        
        //// hacemos recorrido de las rutas contenedoras para cambiar el nombre de las demás rutas
        $recorriendoRutas=$mysqli->query("SELECT * FROM carpeta WHERE rol='".$_POST['idProveedor']."' ");
        while($extraerRuta=$recorriendoRutas->fetch_array()){
             'Rutas: '.$extraerRuta['ruta']; 
            
            //// reemplazamos el nombre a cambiar a todas las rutas implicadas
            $rutaActualizar=str_replace($nombreAnterior,"$nombre",$extraerRuta['ruta']);
            
            
            
            //// actuaizamos las rutas
            $mysqli->query("UPDATE carpeta SET ruta='$rutaActualizar' WHERE id='".$extraerRuta['id']."' ")or die(mysqli_error($mysqli));
            
            
             ' - - Nueva ruta: - - '.$rutaActualizar;
            
             '<br>';
        }
        
        //// end
        
        $mysqli->query("UPDATE carpeta SET nombre='$nombre' WHERE id='$id' ")or die(mysqli_error($mysqli));
        
        
        
                ?>
                 <script>
                window.onload=function(){
                    
                    document.forms["miformulario"].submit();
                }
                </script>
                <?php
                if($_POST['masivoEnviar'] != NULL){
                ?>
                <form name="miformulario" action="../../subirDocumentoMasivo" method="POST" onsubmit="procesar(this.action);" >
                    <input name="masivoEnviar" type="hidden" value="1">
                    <input name="idProveedor" value="<?php echo $_POST['idProveedor']; ?>" type="hidden" readonly>
                <?php
                if($_POST['carpetaAbrir'] != NULL){
                ?>
                  <input name="abrirCarpeta" value="1" type="hidden" required>
                  <input type="hidden" value="<?php echo $_POST['carpetaAbrir'];?>" name="carpetaAbrir" >
                <?php
                }else{
                    
                } 
                ?>
                <input name="validacionActualizar" value="1" type="hidden">
                </form>
                <?php
                }else{
                ?>
                <form name="miformulario" action="../../proveedorDocumetosCarpetasB" method="POST" onsubmit="procesar(this.action);" >
                    <input name="idProveedor" value="<?php echo $_POST['idProveedor']; ?>" type="hidden" readonly>
                <?php
                if($_POST['carpetaAbrir'] != NULL){
                ?>
                  <input name="abrirCarpeta" value="1" type="hidden" required>
                  <input type="hidden" value="<?php echo $_POST['carpetaAbrir'];?>" name="carpetaAbrir" >
                <?php
                }else{
                    
                } 
                ?>
                <input name="validacionActualizar" value="1" type="hidden">
                </form>
                <?php
                }
    
}

if(isset($_POST['carpetaBorrar'])){
    
    /// declaramos las variables
    $id=$_POST['idDestino'];
    
    
    /// declaramos la función para eliminar el directorio
    function deleteDirectory($dir) {
        if(!$dh = @opendir($dir)) return;
        while (false !== ($current = readdir($dh))) {
            if($current != '.' && $current != '..') {
                //echo 'Se ha borrado el archivo '.$dir.'/'.$current.'<br/>';
                if (!@unlink($dir.'/'.$current)) 
                    deleteDirectory($dir.'/'.$current);
            }       
        }
        closedir($dh);
        //echo 'Se ha borrado el directorio '.$dir.'<br/>';
        @rmdir($dir);
    }
    
    if($_POST['filaCarpeta'] == 1){
        $preguntaCarpeta=$mysqli->query("SELECT * FROM carpeta WHERE  id='$id' AND fila='1' ")or die("database error:". mysqli_error($mysqli));
        $extraerpreguntaCarpeta=$preguntaCarpeta->fetch_array(MYSQLI_ASSOC);
        $dir='../../archivos/documentoProveedor/'.$extraerpreguntaCarpeta['ruta'];
    }else{
        $recorriendoCarpetas=$mysqli->query("SELECT * FROM carpeta WHERE id='".$id."' ");
        $string="";
        while($extraerRecorriendoCarpetas=$recorriendoCarpetas->fetch_array()){
             'consutruir ruta: '.$string .=$extraerRecorriendoCarpetas['ruta'];
        }
         '<br>';
         $dir='../../archivos/documentoProveedor/'.utf8_encode($string);
    }
    deleteDirectory($dir);
    
    
    
    
    
    
    $mysqli->query("DELETE FROM carpeta WHERE id='$id' ")or die (mysqli_error($mysqli));
    
    ?>
                 <script>
                window.onload=function(){
                    
                    document.forms["miformulario"].submit();
                }
                </script>
                
                
                
                <?php
                if($_POST['masivoEnviar'] != NULL){
                ?>
                    <form name="miformulario" action="../../subirDocumentoMasivo" method="POST" onsubmit="procesar(this.action);" >
                        <input name="masivoEnviar" type="hidden" value="1">
                        <input name="idProveedor" value="<?php echo $_POST['idProveedor']; ?>" type="hidden" readonly>
                    <?php 
                     if($_POST['primera'] == 1){ 
                         
                     }else{
                    ?>
                        <input name="abrirCarpeta" value="1" type="hidden" required>
                    <?php 
                     }
                    ?>
                        <input type="hidden" value="<?php echo $_POST['carpetaAbrir'];?>" name="carpetaAbrir" >
                        <input name="validacionEliminar" value="1" type="hidden">
                    </form>
                <?php
                }else{
                ?>
                    <form name="miformulario" action="../../proveedorDocumetosCarpetasB" method="POST" onsubmit="procesar(this.action);" >
                        <input name="idProveedor" value="<?php echo $_POST['idProveedor']; ?>" type="hidden" readonly>
                    <?php 
                     if($_POST['primera'] == 1){ 
                         
                     }else{
                    ?>
                        <input name="abrirCarpeta" value="1" type="hidden" required>
                    <?php 
                     }
                    ?>
                        <input type="hidden" value="<?php echo $_POST['carpetaAbrir'];?>" name="carpetaAbrir" >
                        <input name="validacionEliminar" value="1" type="hidden">
                    </form>
                <?php    
                }
    
}

if(isset($_POST['archivoBorrar'])){
     $id=$_POST['idDestino'];
    
        $consulta=$mysqli->query("SELECT * FROM uploadsP WHERE id='$id' ");
        $extraer=$consulta->fetch_array(MYSQLI_ASSOC);
        $documento=$extraer['file_name'];
        if($_POST['filaCarpeta'] == 1){
            $preguntaCarpeta=$mysqli->query("SELECT * FROM carpeta WHERE  id='".$extraer['idCarpeta']."' AND fila='1' ")or die("database error:". mysqli_error($mysqli));
            $extraerpreguntaCarpeta=$preguntaCarpeta->fetch_array(MYSQLI_ASSOC);
            //echo utf8_encode('../../archivos/documentoProveedor/'.$extraerpreguntaCarpeta['ruta'].'/'.$documento);
            $eliminacion=unlink(utf8_encode('../../archivos/documentoProveedor/'.$extraerpreguntaCarpeta['ruta'].'/'.$documento));
        }else{
            $recorriendoCarpetas=$mysqli->query("SELECT * FROM carpeta WHERE id='".$extraer['idCarpeta']."' ");
            $string="";
            while($extraerRecorriendoCarpetas=$recorriendoCarpetas->fetch_array()){
                 'consutruir ruta: '.$string .=$extraerRecorriendoCarpetas['ruta'].'/';
            }
            //echo '<br>Eliminar: '.'../../archivos/documentoProveedor/'.$string.''.$documento;
            $eliminacion=unlink(utf8_encode('../../archivos/documentoProveedor/'.$string.''.$documento));
        }
    
         if($eliminacion != NULL){
             $mysqli->query("DELETE FROM uploadsP WHERE id='$id' ")or die (mysqli_error($mysqli));
         
                ?>
                 <script>
                window.onload=function(){
                    
                    document.forms["miformulario"].submit();
                }
                </script>
            <?php
            if($_POST['masivoEnviar'] != NULL){
            ?>
                <form name="miformulario" action="../../subirDocumentoMasivo" method="POST" onsubmit="procesar(this.action);" >
                    <input name="masivoEnviar" type="hidden" value="1">
                    <input name="abrirCarpeta" value="1" type="hidden" required>
                    <input type="hidden" value="<?php echo $_POST['carpetaAbrir'];?>" name="carpetaAbrir" >
                    
                    <input name="idProveedor" value="<?php echo $_POST['idProveedor']; ?>" type="hidden" readonly>
                    <input name="validacionEliminar" value="1" type="hidden">
                </form>
            <?php
            }else{
             ?>
                <form name="miformulario" action="../../proveedorDocumetosCarpetasB" method="POST" onsubmit="procesar(this.action);" >
                    <input name="abrirCarpeta" value="1" type="hidden" required>
                    <input type="hidden" value="<?php echo $_POST['carpetaAbrir'];?>" name="carpetaAbrir" >
                    
                    <input name="idProveedor" value="<?php echo $_POST['idProveedor']; ?>" type="hidden" readonly>
                    <input name="validacionEliminar" value="1" type="hidden">
                </form>
            <?php    
            }
         }else{
                ?>
                 <script>
                window.onload=function(){
                    //alert("El archivo no se pudo eliminar");
                    //document.forms["miformulario"].submit();
                }
                </script>
                <?php
                if($_POST['masivoEnviar'] != NULL){
                ?>
                <form name="miformulario" action="../../subirDocumentoMasivo" method="POST" onsubmit="procesar(this.action);" >
                    <input name="masivoEnviar" type="hidden" value="1">
                    <input name="abrirCarpeta" value="1" type="hidden" required>
                    <input type="hidden" value="<?php echo $_POST['carpetaAbrir'];?>" name="carpetaAbrir" >
                    
                    <input name="idProveedor" value="<?php echo $_POST['idProveedor']; ?>" type="hidden" readonly>
                    <input name="validacionExisteImportacion" value="1" type="hidden">
                </form>
                <?php
                }else{
                ?>
                <form name="miformulario" action="../../proveedorDocumetosCarpetasB" method="POST" onsubmit="procesar(this.action);" >
                    <input name="abrirCarpeta" value="1" type="hidden" required>
                    <input type="hidden" value="<?php echo $_POST['carpetaAbrir'];?>" name="carpetaAbrir" >
                    
                    <input name="idProveedor" value="<?php echo $_POST['idProveedor']; ?>" type="hidden" readonly>
                    <input name="validacionExisteImportacion" value="1" type="hidden">
                </form>
                <?php    
                }
         }
    
}
?>