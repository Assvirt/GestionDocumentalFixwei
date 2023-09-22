<?php
error_reporting(E_ERROR);
require_once '../../conexion/bd.php';


if(isset($_POST['AgregarCarpeta'])){
   
    $nombre = utf8_decode($_POST['nombre']);
    $idProveedor = $_POST['idProveedor'];
    
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
        
    ///////// consultamos la tabla y extraemos el nombre
    $validacion = $mysqli->query("SELECT * FROM proveedordocumentosCarpetas WHERE nombre = '$nombre' AND idProveedor='$idProveedor' ")or die (mysqli_error());
    $numRows = mysqli_num_rows($validacion);
    if($numRows > 0){
        //echo 'funciona';
        //echo '<script language="javascript">alert("El grupo ya existe");
        //window.location.href="../../agregarProveedoresGrupos"</script>';
        ?>
                            <script>
                                    window.onload=function(){
                                        //alert("El nombre o el archivo ya existen1");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                           <form name="miformulario" action="../../proveedorDocumetosCarpetas" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                               <input type="hidden" name="validacionExiste" value="1">
                            </form>
                            
                        <?php
    }else{
    
        $mysqli->query("INSERT INTO proveedordocumentosCarpetas(nombre,idProveedor)VALUES('$nombre','$idProveedor') ")or die(mysqli_error($mysqli));
        
        $mysqli->query("UPDATE proveedores SET bloqueoCarpeta ='1' WHERE id='$idProveedor'")or die(mysqli_error($mysqli));//AND id='$id'
    
?>
                            <script>
                                    window.onload=function(){
                                        //alert("El nombre o el archivo ya existen1");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../proveedorDocumetosCarpetas" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                               <input type="hidden" name="validacionAgregar" value="1">
                            </form>
                            
<?php
    }
}

if(isset($_POST['EditarCarpeta'])){
    $idProveedor = $_POST['idProveedor'];
    $id=$_POST['idCarpeta'];
    $nombre = utf8_decode($_POST['nombre']);
    
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
    ///////// consultamos la tabla y extraemos el nombre
    $validacion = $mysqli->query("SELECT * FROM proveedordocumentosCarpetas WHERE nombre = '$nombre' AND idProveedor='$idProveedor' AND id != '$id' ")or die (mysqli_error());
    $numRows = mysqli_num_rows($validacion);
    if($numRows > 0){
        //echo 'funciona';
        //echo '<script language="javascript">alert("El grupo ya existe");
        //window.location.href="../../agregarProveedoresGrupos"</script>';
        ?>
                            <script>
                                    window.onload=function(){
                                        //alert("El nombre o el archivo ya existen1");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                           <form name="miformulario" action="../../proveedorDocumetosCarpetas" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                               <input type="hidden" name="validacionExiste" value="1">
                            </form>
                            
                        <?php
    }else{
        
        
    $Eliminarcarpeta=$mysqli->query("SELECT * FROM proveedordocumentosCarpetas WHERE id='$id' ");
    $ConsultarEliminacionCarpeta=$Eliminarcarpeta->fetch_array(MYSQLI_ASSOC);
    $nombreCarpeta=$ConsultarEliminacionCarpeta['nombre'];   
    unlink('../../archivos/documentoProveedor/'.$nombreCarpeta.'.zip');    
        
     $mysqli->query("UPDATE proveedordocumentosCarpetas SET nombre='$nombre' WHERE idProveedor='$idProveedor' AND id='$id'  ")or die(mysqli_error($mysqli));
    
    ?>
                            <script>
                                    window.onload=function(){
                                        //alert("El nombre o el archivo ya existen1");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../proveedorDocumetosCarpetas" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                               <input type="hidden" name="validacionActualizar" value="1">
                            </form>
                            
<?php
    }
}

if(isset($_POST['crearSubCarpeta'])){
    $idProveedor=$_POST['idProveedor'];
    $nombre=utf8_decode($_POST['nombre']);
    $carpetaPrincipal=$_POST['idCarpeta'];
     
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
    
    
     ///////// consultamos la tabla y extraemos el nombre
    
    if($_POST['nombreCarpeta'] != NULL){
        $validacion = $mysqli->query("SELECT * FROM proveedorSubCarpetas WHERE nombre = '$nombre' AND idProveedor='$idProveedor' AND idCarpeta='$carpetaPrincipal' AND principal='".$_POST['id']."' AND filas='".$_POST['filas']."'  AND indicativo='".$_POST['nombreCarpeta']."'")or die (mysqli_error());       
    }else{
        if($_POST['id'] != NULL){
        $validacion = $mysqli->query("SELECT * FROM proveedorSubCarpetas WHERE nombre = '$nombre' AND idProveedor='$idProveedor' AND idCarpeta='$carpetaPrincipal' AND principal='".$_POST['id']."' AND filas='".$_POST['filas']."' ")or die (mysqli_error());
        }else{
        $validacion = $mysqli->query("SELECT * FROM proveedorSubCarpetas WHERE nombre = '$nombre' AND idProveedor='$idProveedor' AND idCarpeta='$carpetaPrincipal' ")or die (mysqli_error());
        }
    }
    $numRows = mysqli_num_rows($validacion);
    if($numRows > 0){
       ?>
                            <script>
                                    window.onload=function(){
                                        //alert("El nombre o el archivo ya existen1");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                           <form name="miformulario" action="../../proveedorDocumetos" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idCarpeta" value="<?php echo $_POST['idCarpeta'];?>" type="hidden">
                               <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                              
                              <input name="id" value="<?php echo $_POST['id']; ?>" type="hidden">
                              <input name="filas" value="<?php echo $_POST['filas']; ?>" type="hidden">
                              <?php
                              // mantenemos la carpeta abierta
                              if($_POST['mantenerAbierto'] != NULL){
                              ?>
                                <input name="agregarArchivosDocumentos" value="1" type="hidden">
                              <?php
                              }
                              ?>
                              <input name="nombreCarpeta" value="<?php echo $_POST['nombreCarpeta'];?>" type="hidden">
                               <input type="hidden" name="validacionExiste" value="1">
                               
                            </form>
                            
    <?php
    }else{
           $ruta=$nombre.'/';
           $filas=$_POST['id'];
           
            $_POST['idCarpeta'];
            '<br><br>';
            $_POST['id'];
            '<br><br>';
           
            if($_POST['nombreCarpeta'] != NULL){
                    $_POST['idCarpetaIdividual'];
                    $subConsultaRuta=$mysqli->query("SELECT * FROM proveedorSubCarpetas WHERE id='".$_POST['idCarpetaIdividual']."' ");
                    $extraerSubConsultaRuta=$subConsultaRuta->fetch_array(MYSQLI_ASSOC);
                    $nombreCarpetaRuta=$extraerSubConsultaRuta['ruta'];
                        $consultarRuta=$mysqli->query("SELECT * FROM proveedorSubCarpetas WHERE principal='".$_POST['id']."' GROUP BY filas");
                        $string="";
                        while($extraerRuta=$consultarRuta->fetch_array()){
                                                
                            if($extraerRuta['indicativo'] != NULL){
                                                    
                            }else{
                                $subConsultaRutaPrincipal=$mysqli->query("SELECT * FROM proveedorSubCarpetas WHERE id='".$extraerRuta['principal']."' ");
                                $extraerSubConsultaRutaPrincipal=$subConsultaRutaPrincipal->fetch_array(MYSQLI_ASSOC);
                                $string.=($extraerSubConsultaRutaPrincipal['nombre']).'/';
                            }
                                                
                            if($extraerRuta['filas'] <= $_POST['filas']){
                                                    
                            }else{
                                continue;
                            }
                                            
                             $string.=($extraerRuta['indicativo']);
                        }
                     $string.=($nombreCarpetaRuta);
                        
            }else{ 
                        $subConsultaRutaPrincipal=$mysqli->query("SELECT * FROM proveedorSubCarpetas WHERE id='".$_POST['id']."' ");
                        $extraerSubConsultaRutaPrincipal=$subConsultaRutaPrincipal->fetch_array(MYSQLI_ASSOC);
                         $string.=($extraerSubConsultaRutaPrincipal['nombre']).'/';
            }
               
                
                
                        
              echo '<br>Ruta crear: '.$rutaE='../../archivos/documentoProveedor/'.$idProveedor.'/'.$string.'/'.$ruta;
              
              
              
              if(!mkdir($rutaE, 0777, true)) {
                  echo 'error';
              }else{
                  echo 'creado';
              }
              
           if($filas != NULL){
               if($_POST['filas'] == 1){
                   $filasSumando='1';
               }else{
                   $filasSumando=$_POST['filas'];
               } 
                $mysqli->query("INSERT INTO proveedorSubCarpetas(nombre,idProveedor,idCarpeta,ruta,principal,filas,indicativo)VALUES('$nombre','$idProveedor','$carpetaPrincipal','$ruta','$filas','$filasSumando','".$_POST['nombreCarpeta']."') ")or die(mysqli_error($mysqli));  
           }else{ 
                $mysqli->query("INSERT INTO proveedorSubCarpetas(nombre,idProveedor,idCarpeta,ruta)VALUES('$nombre','$idProveedor','$carpetaPrincipal','$ruta') ")or die(mysqli_error($mysqli));  
           }
           
       
        ?>
                            <script>
                                    window.onload=function(){
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../proveedorDocumetos" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idCarpeta" value="<?php echo $_POST['idCarpeta'];?>" type="hidden">
                               <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                             
                              <input name="id" value="<?php echo $_POST['id']; ?>" type="hidden">
                              <input name="filas" value="<?php echo $_POST['filas']; ?>" type="hidden">
                              <?php
                              // mantenemos la carpeta abierta
                              if($_POST['mantenerAbierto'] != NULL){
                              ?>
                                <input name="agregarArchivosDocumentos" value="1" type="hidden">
                              <?php
                              }
                              ?>
                              <input name="nombreCarpeta" value="<?php echo $_POST['nombreCarpeta'];?>" type="hidden">
                              <input type="hidden" name="validacionAgregar" value="1">
                              
                            </form>
                            
    <?php
    }
    
}

if(isset($_POST['EditarSubCarpeta'])){
    $idProveedor=$_POST['idProveedor'];
    $nombre=utf8_decode($_POST['nombre']);
    $carpetaPrincipal=$_POST['idCarpeta'];
    $idEditar=$_POST['idEditar'];
    
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
    
    
     ///////// consultamos la tabla y extraemos el nombre
     if($_POST['nombreCarpeta'] != NULL){
        $validacion = $mysqli->query("SELECT * FROM proveedorSubCarpetas WHERE nombre = '$nombre' AND idProveedor='$idProveedor' AND idCarpeta='$carpetaPrincipal' AND principal='".$_POST['id']."' AND filas='".$_POST['filas']."'  AND indicativo='".$_POST['nombreCarpeta']."'")or die (mysqli_error()); 
     }else{
        if($_POST['id'] != NULL){
        $validacion = $mysqli->query("SELECT * FROM proveedorSubCarpetas WHERE nombre = '$nombre' AND idProveedor='$idProveedor' AND idCarpeta='$carpetaPrincipal' AND principal='".$_POST['id']."' AND filas='".$_POST['filas']."' ")or die (mysqli_error());
        }else{
        $validacion = $mysqli->query("SELECT * FROM proveedorSubCarpetas WHERE nombre = '$nombre' AND idProveedor='$idProveedor' AND idCarpeta='$carpetaPrincipal' AND id !='$idEditar' ")or die (mysqli_error());
        }
     }
    $numRows = mysqli_num_rows($validacion);
    if($numRows > 0){
       
        ?>
                            <script>
                                    window.onload=function(){
                                        //alert("El nombre o el archivo ya existen1");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                           <form name="miformulario" action="../../proveedorDocumetos" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idCarpeta" value="<?php echo $_POST['idCarpeta'];?>" type="hidden">
                               <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                               <input type="hidden" name="validacionExiste" value="1">
                              
                               <input name="id" value="<?php echo $_POST['id']; ?>" type="hidden">
                               <input name="filas" value="<?php echo $_POST['filas']; ?>" type="hidden">
                               <?php
                               // mantenemos la carpeta abierta
                               if($_POST['mantenerAbierto'] != NULL){
                               ?>
                                <input name="agregarArchivosDocumentos" value="1" type="hidden">
                               <?php
                               }
                               ?>
                               <input name="nombreCarpeta" value="<?php echo $_POST['nombreCarpeta'];?>" type="hidden">
                            </form>
                            
    <?php
    }else{
        
        
        
        
        ///////// consultamos la tabla y extraemos el nombre
     if($_POST['nombreCarpeta'] != NULL){
        echo '3';
         
     }else{
        if($_POST['id'] != NULL){
            $nombreRuta=$nombre.'/';
            
            //// realizo consulta para extraer la ruta
            $consultaRuta=$mysqli->query("SELECT * FROM proveedorSubCarpetas WHERE id='$idEditar' ");
            $extraerConsultaRuta=$consultaRuta->fetch_array(MYSQLI_ASSOC);
            $rutaAnterior=$extraerConsultaRuta['ruta'];
            
            $mysqli->query("UPDATE proveedorSubCarpetas SET indicativo='$nombreRuta' WHERE principal='".$_POST['id']."' AND indicativo='$rutaAnterior' ")or die(mysqli_error($mysqli));
            $mysqli->query("UPDATE proveedorSubCarpetas SET nombre='$nombre', ruta='$nombreRuta' WHERE id='$idEditar'  ")or die(mysqli_error($mysqli));
        }else{
            $nombreRuta=$nombre.'/';
            $mysqli->query("UPDATE proveedorSubCarpetas SET nombre='$nombre', ruta='$nombreRuta' WHERE id='$idEditar'  ")or die(mysqli_error($mysqli));
        }
     }
        
         //$mysqli->query("UPDATE proveedorSubCarpetas SET nombre='$nombre' WHERE id='$idEditar'  ")or die(mysqli_error($mysqli));
         
         
         
         
         
         
    
        ?>
                            <script>
                                    window.onload=function(){
                                        //alert("El nombre o el archivo ya existen1");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../proveedorDocumetos" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idCarpeta" value="<?php echo $_POST['idCarpeta'];?>" type="hidden">
                               <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                               <input type="hidden" name="validacionActualizar" value="1">
                               
                               <input name="id" value="<?php echo $_POST['id']; ?>" type="hidden">
                               <input name="filas" value="<?php echo $_POST['filas']; ?>" type="hidden">
                               <?php
                               // mantenemos la carpeta abierta
                               if($_POST['mantenerAbierto'] != NULL){
                               ?>
                                <input name="agregarArchivosDocumentos" value="1" type="hidden">
                               <?php
                               }
                               ?>
                               <input name="nombreCarpeta" value="<?php echo $_POST['nombreCarpeta'];?>" type="hidden">
                               
                            </form>
                            
<?php
    }
}

if(isset($_POST['EliminarSubcarpeta'])){
    
    $idProveedor=$_POST['idProveedor'];
    $nombre=$_POST['nombre'];
    $carpetaPrincipal=$_POST['idCarpeta'];
    $idEditar=$_POST['idEditar'];
    
    
     if($_POST['nombreCarpeta'] != NULL){
       echo 'Consulta 1';
     }else{
        if($_POST['id'] != NULL){
        echo 'Consulta 2';
        
        $consultaNombreCarpeta = $mysqli->query("SELECT * FROM proveedorSubCarpetas WHERE id = '$carpetaPrincipal'");
        $extraerConsultaNombre = $consultaNombreCarpeta->fetch_array(MYSQLI_ASSOC);
        echo $datoNombreCarpeta = $extraerConsultaNombre['nombre'];
        
        
        $consultaExistenciaDocumentos = $mysqli->query("SELECT * FROM proveedorSubCarpetas WHERE principal = '$idEditar' AND idCarpeta = '$carpetaPrincipal' AND indicativo = '$datoNombreCarpeta'  ")or die(mysqli_error($mysqli));
         
    ///// acá se debe realizar una consulta de todas las carpetas y archivos que existan dentro de esta carpeta y eliminar todo antes de eliminar la carpeta como tal
        while($extraerDatos=$consultaExistenciaDocumentos->fetch_assoc()){
            echo $idExisteDocumento=$extraerDatos['id'];
            
            //$consultaEliminacion = $mysqli->query("DELETE FROM proveedorSubCarpetas WHERE id = '$idExisteDocumento'");
        }
        
        
        
        }else{
        //echo 'Consulta 3 ';
         $consultaExistenciaDocumentos = $mysqli->query("SELECT * FROM proveedorSubCarpetas WHERE principal = '$idEditar' ")or die(mysqli_error($mysqli));
         
    ///// acá se debe realizar una consulta de todas las carpetas y archivos que existan dentro de esta carpeta y eliminar todo antes de eliminar la carpeta como tal
        while($extraerDatos=$consultaExistenciaDocumentos->fetch_assoc()){
            echo $idExisteDocumento=$extraerDatos['id'];
            
            $consultaEliminacion = $mysqli->query("DELETE FROM proveedorSubCarpetas WHERE id = '$idExisteDocumento'");
        }        
    /*
   
    */
    
    //// END
    
    $mysqli->query("DELETE FROM proveedorSubCarpetas WHERE id='$idEditar' ");
      ?>
                            <script>
                                    window.onload=function(){
                                        //alert("El nombre o el archivo ya existen1");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../proveedorDocumetos" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idCarpeta" value="<?php echo $_POST['idCarpeta'];?>" type="hidden">
                               <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                               
                               <input name="id" value="<?php echo $_POST['id']; ?>" type="hidden">
                              <input name="filas" value="<?php echo $_POST['filas']; ?>" type="hidden">
                              <?php
                              // mantenemos la carpeta abierta
                              if($_POST['mantenerAbierto'] != NULL){
                              ?>
                                <input name="agregarArchivosDocumentos" value="1" type="hidden">
                              <?php
                              }
                              ?>
                              <input name="nombreCarpeta" value="<?php echo $_POST['nombreCarpeta'];?>" type="hidden">
                               
                               <input type="hidden" name="validacionEliminar" value="1">
                              
                               
                            </form>
                            
<?php
    }
  }
}
?>