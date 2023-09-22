<?php
//////// traemos la bd
require_once '../../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario

if(isset($_POST['agregar'])){

    
    $nombre = utf8_decode($_POST['nombre']);
    $tipo = $_POST['tipo'];
    
    $archivoNombre = $_FILES['archivo']['name'];
    $guardado = $_FILES['archivo']['tmp_name'];
    
    if($archivoNombre == NULL){
        
        $mysqli->query("INSERT INTO documentoExterno (nombre, tipo) VALUES('$nombre', '$tipo' ) ")or die(mysqli_error($mysqli));
        
        //echo '<script language="javascript">alert("Agregado con Exito");
        //            window.location.href="../../documentoExterno"</script>';
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
        
        if(!file_exists('../../archivos/documentosExternos')){
            mkdir('../../archivos/documentosExternos',0777,true);
            if(file_exists('../../archivos/documentosExternos')){
                if(move_uploaded_file($guardado, '../../archivos/documentosExternos/'.$archivoNombre)){
                    $ruta = 'archivos/documentosExternos/'.$archivoNombre;
                    ///////// consultamos la tabla y extraemos el nombre
    		        $sql= $mysqli->query("SELECT * FROM documentoExterno WHERE nombre = '$nombre' ");
    		        $numRows = mysqli_num_rows($sql);
                    if($numRows > 0){
                    //echo '<script language="javascript">alert("El nombre ya existe.");
                    //window.location.href="../../documentoExterno"</script>';
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
                    $ruta=utf8_decode($ruta);
                    $mysqli->query("INSERT INTO documentoExterno (nombre, tipo,ruta) VALUES('$nombre', '$tipo','$ruta' ) ")or die(mysqli_error($mysqli));
    
                    }
    
                    //echo '<script language="javascript">alert("Agregado con Exito");
                    //window.location.href="../../documentoExterno"</script>';
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
                    
                    //echo '<script language="javascript">alert("no se pudo cargar el archivo con Exito");
                    //window.location.href="../../documentoExterno"</script>';
                    ?>
                        <script> 
                             window.onload=function(){
                           
                                 document.forms["miformulario"].submit();
                             }
                        </script>
                         
                        <form name="miformulario" action="../../documentoExterno" method="POST" onsubmit="procesar(this.action);" >
                            <input type="hidden" name="validacionExisteB" value="1">
                        </form> 
                    <?php
                }
            }
            
        }else{
            if(move_uploaded_file($guardado, '../../archivos/documentosExternos/'.$archivoNombre)){
                    $ruta = 'archivos/documentosExternos/'.$archivoNombre;
                    ///////// consultamos la tabla y extraemos el nombre
            		$sql= $mysqli->query("SELECT * FROM documentoExterno WHERE nombre = '$nombre' ");
            		$numRows = mysqli_num_rows($sql);
                    if($numRows > 0){
                        //echo '<script language="javascript">alert("El nombre ya existe.");
                        //window.location.href="../../documentoExterno"</script>';
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
                        $ruta=utf8_decode($ruta);
                        $mysqli->query("INSERT INTO documentoExterno (nombre, tipo,ruta) VALUES('$nombre', '$tipo','$ruta' ) ")or die(mysqli_error($mysqli));
            
                    }
            
                    //echo '<script language="javascript">alert("Agregado con Exito");
                    //window.location.href="../../documentoExterno"</script>';
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
                    //echo '<script language="javascript">alert("no se pudo cargar el archivo con Exito");
                    //window.location.href="../../documentoExterno"</script>';
                    ?>
                        <script> 
                             window.onload=function(){
                           
                                 document.forms["miformulario"].submit();
                             }
                        </script>
                         
                        <form name="miformulario" action="../../documentoExterno" method="POST" onsubmit="procesar(this.action);" >
                            <input type="hidden" name="validacionExisteB" value="1">
                        </form> 
                    <?php
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
        
    $validacion2 = $mysqli->query("SELECT * FROM documentoExterno WHERE nombre = '$nombre' AND NOT id = '$id' ");
    $numRows2 = mysqli_num_rows($validacion2);
    
    if($numRows2 > 0){
        
    //echo '<script language="javascript">alert("ese nombre ya esta en uso.");
    //window.location.href="../../documentoExterno"</script>';
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

                /*echo '<script language="javascript">alert("Agregado con Exito");
                window.location.href="../../documentoExterno"</script>';*/
                
            }else{
                
                /*echo '<script language="javascript">alert("no se pudo cargar el archivo con Exito");
                window.location.href="../../documentoExterno"</script>';*/
            }
        }
        
    }else{ 
        if(move_uploaded_file($guardado, '../../archivos/documentosExternos/'.$archivoNombre)){
                $ruta = 'archivos/documentosExternos/'.$archivoNombre;
                ///////// consultamos la tabla y extraemos el nombre
        		$sql= $mysqli->query("SELECT * FROM documentoExterno WHERE nombre = '$nombre' ");
        		$numRows = mysqli_num_rows($sql);
                //if($numRows > 0){
                    /*echo '<script language="javascript">alert("El nombre ya existe.");
                    window.location.href="../../documentoExterno"</script>';*/
                
                //}else{ echo 'entra aca';
                    $ruta=utf8_decode($ruta);
                    $mysqli->query("UPDATE documentoExterno SET  nombre='$nombre', tipo='$tipo', ruta= '$ruta' WHERE id = '$id'");
        
                //}
        
                /*echo '<script language="javascript">alert("Agregado con Exito");
                window.location.href="../../documentoExterno"</script>';*/
            }else{
                /*echo '<script language="javascript">alert("no se pudo cargar el archivo con Exito");
                window.location.href="../../documentoExterno"</script>';*/
            }
        
    }
        
        
        
   // $mysqli->query("UPDATE documentoExterno SET  nombre='$nombre', tipo='$tipo' WHERE id = '$id'");    
        
        
       
   
   //Editar de tipoDoc
   
  // echo '<script language="javascript">alert("Actualizado con exito.");
  // window.location.href="../../documentoExterno"</script>';
  
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
}

if(isset($_POST['eliminar'])){
    $id = $_POST['idDoc'];
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