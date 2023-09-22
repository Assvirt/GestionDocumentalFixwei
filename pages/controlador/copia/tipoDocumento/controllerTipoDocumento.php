<?php

error_reporting(E_ERROR);
//////// traemos la bd
require_once '../../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario

if(isset($_POST['agregarTipo'])){

    
    $nombre = utf8_decode($_POST['nombre']);
    $prefijo = utf8_decode($_POST['prefijo']);
    $descripcion = utf8_decode($_POST['descripcion']);
    $inicial = utf8_decode($_POST['inicial']);
    
    
     
    
    ////////////////////////////////////
    $archivoNombre = $_FILES['archivo']['name'];
    $guardado = $_FILES['archivo']['tmp_name'];
    
    if(!file_exists('../../archivos/plantillasTipoDocumento')){/*
        mkdir('../../archivos/plantillasTipoDocumento',0777,true);
        if(file_exists('../../archivos/plantillasTipoDocumento')){
            if(move_uploaded_file($guardado, '../../archivos/plantillasTipoDocumento/'.$archivoNombre)){
                $ruta = 'archivos/plantillasTipoDocumento/'.$archivoNombre;
                ///////// consultamos la tabla y extraemos el nombre
        		$sql= $mysqli->query("SELECT * FROM tipoDocumento WHERE nombre = '$salida' OR prefijo='$salidaB'  ");
        		$numRows = mysqli_num_rows($sql);
                if($numRows > 0){
                    //echo '<script language="javascript">alert("El nombre ya existe.");
                    //window.location.href="../../tipoDocumento"</script>';
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
                    
                    $mysqli->query("INSERT INTO tipoDocumento (nombre, prefijo,descripcion, inicial,ruta) VALUES('$nombre', '$prefijo','$descripcion', '$inicial','$ruta' ) ")or die(mysqli_error($mysqli));
                    
                    
                    //////////////////// se agrega este campo para las actividades
                    $validandoNotificacions='tipoDocumento';
                    /////////// actividades de traer nombre de modulos de notificaciones
                    
                    $usuarioID=$_POST['usuarioActividad'];
                    $plataformaH = $_POST['plataforma'];
                    $correoH = $_POST['correo'];
                    /////////// fin proceso para traer el nombre del modulo en las notifiaciones
                    
                    //////////// datos para el correo
                    $nombreUsuario = $mysqli->query("SELECT * FROM usuario WHERE cedula ='$usuarioID' ")or die(mysqli_error());
                    $col = $nombreUsuario->fetch_array(MYSQLI_ASSOC);
                    $nombreU = $col['nombres'];
                    $apellidoU = $col['apellidos'];
                    $correoU = $col['correo'];
                    $usuarioH=$nombreU." ".$apellidoU;
                    //////////////// fin proceso datos para el correo
                    
                    /////////////// datos para traer validar el nombre del formulario
                    $nombreUsuario = $mysqli->query("SELECT id,nombre FROM formularios WHERE idFormulario='$validandoNotificacions' ")or die(mysqli_error());
                    $col = $nombreUsuario->fetch_array(MYSQLI_ASSOC);
                    $nombreNV = $col['nombre'];
                    /////////////// fin datos para traer validar el nombre del formulario
                    
                    
                    if($correoH == 1 && $plataformaH == 1){
                        
                        
                        $tituloA='Tipo de documento';
                        $mensajeA='se crea tipo de documento con el nombre '.$nombre;
                        
                        date_default_timezone_set('America/Bogota');
                        $fechaA=date('Y-m-j h:i:s A');
                        
                        $agregarActividads= $mysqli->query("INSERT INTO actividades(idUsuario,iformulario,titulo,fecha,mensaje) VALUES('$usuarioID', '$validandoNotificacions', '$tituloA', '$fechaA','$mensajeA')")or die(mysqli_error($mysqli));
                        
                        /////////// se envían los datos de creación de usuario a ese usuario
                        
                        /////////// Fin se envían los datos de creación de usuario a ese usuario
                    }elseif($correoH == 1){
                        
                        /////////// se envían los datos de creación de usuario a ese usuario
                        
                    }elseif($plataformaH == 1){
                        $tituloA='Tipo de documento';
                        $mensajeA='se crea tipo de documento con el nombre '.$nombre;
                        
                        date_default_timezone_set('America/Bogota');
                        $fechaA=date('Y-m-j h:i:s A');
                        
                        $agregarActividads= $mysqli->query("INSERT INTO actividades(idUsuario,iformulario,titulo,fecha,mensaje) VALUES('$usuarioID', '$validandoNotificacions', '$tituloA', '$fechaA','$mensajeA')")or die(mysqli_error($mysqli));
                        
                    }
        ////////// fin del proceso
                    
                    
                    
                }
        
                //echo '<script language="javascript">alert("Agregado con Exito");
                //window.location.href="../../tipoDocumento"</script>';
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
                
            }else{
                $ruta = "nohayfoto";
                $mysqli->query("INSERT INTO tipoDocumento (nombre, prefijo,descripcion, inicial,ruta) VALUES('$nombre', '$prefijo','$descripcion', '$inicial','$ruta' ) ")or die(mysqli_error($mysqli));

               // echo '<script language="javascript">alert("");
                //window.location.href="../../tipoDocumento"</script>';
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
        */
    }else{
        if(move_uploaded_file($guardado, '../../archivos/plantillasTipoDocumento/'.$archivoNombre)){
                $ruta = 'archivos/plantillasTipoDocumento/'.$archivoNombre;
               
               
              // funcion para quitar espacios
                function Quitar_Espacios($nombre)
                {
                    $array = explode(' ',$nombre);  // convierte en array separa por espacios;
                    $salida ='';
                    // quita los campos vacios y pone un solo espacio
                    for ($i=0; $i < count($array); $i++) { 
                        if(strlen($array[$i])>0) {
                            $salida.= ' ' . $array[$i];
                        }
                    }
                  return  trim($salida);
                }
                /// END
               
                $salida = Quitar_Espacios($prefijo);
                
                // funcion para quitar espacios
                function Quitar_EspaciosB($prefijo)
                {
                    $arrayB = explode(' ',$prefijo);  // convierte en array separa por espacios;
                    $salidaB ='';
                    // quita los campos vacios y pone un solo espacio
                    for ($i=0; $i < count($arrayB); $i++) { 
                        if(strlen($arrayB[$i])>0) {
                            $salidaB.= ' ' . $arrayB[$i];
                        }
                    }
                  return  trim($salidaB);
                }
                /// END
               
                $salidaB = Quitar_EspaciosB($prefijo);
                
                
                
        
        
        		///////// consultamos la tabla y extraemos el nombre
        		$sql= $mysqli->query("SELECT * FROM tipoDocumento WHERE  nombre ='$salida' OR prefijo='$salidaB'  "); //nombre ='$salida' OR prefijo='$salidaB' 
        		$numRows = mysqli_num_rows($sql);
                if($numRows > 0){
                    //echo '<script language="javascript">alert("El nombre ya existe.");
                    //window.location.href="../../tipoDocumento"</script>';
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
                    
                    $mysqli->query("INSERT INTO tipoDocumento (nombre, prefijo,descripcion, inicial,ruta) VALUES('$nombre', '$prefijo','$descripcion', '$inicial','$ruta' ) ")or die(mysqli_error($mysqli));
                    
                    
                    //////////////////// se agrega este campo para las actividades
                    $validandoNotificacions='tipoDocumento';
                    $usuarioID=$_POST['usuarioActividad'];
                        
                    ///////////// datos para traer el nombre del modulo en las notifiaciones
                    $nombreUsuario = $mysqli->query("SELECT * FROM notificaciones WHERE idUsuario ='$usuarioID' AND formulario='$validandoNotificacions' ")or die(mysqli_error());
                    $col = $nombreUsuario->fetch_array(MYSQLI_ASSOC);
                    $correoH = $col['correo'];
                    $plataformaH = $col['plataforma'];
                    /////////// fin proceso para traer el nombre del modulo en las notifiaciones
                    
                    //////////// datos para el correo
                    $nombreUsuario = $mysqli->query("SELECT * FROM usuario WHERE cedula ='$usuarioID' ")or die(mysqli_error());
                    $col = $nombreUsuario->fetch_array(MYSQLI_ASSOC);
                    $nombreU = $col['nombres'];
                    $apellidoU = $col['apellidos'];
                    $correoU = $col['correo'];
                    $usuarioH=$nombreU." ".$apellidoU;
                    //////////////// fin proceso datos para el correo
                    
                    /////////////// datos para traer validar el nombre del formulario
                    $nombreUsuario = $mysqli->query("SELECT id,nombre FROM formularios WHERE idFormulario='$validandoNotificacions' ")or die(mysqli_error());
                    $col = $nombreUsuario->fetch_array(MYSQLI_ASSOC);
                    $nombreNV = $col['nombre'];
                    /////////////// fin datos para traer validar el nombre del formulario
                    
                    
                    if($correoH == 1 && $plataformaH == 1){
                        
                        
                        $tituloA='Nuevo usuario creado';
                        $mensajeA='Se crea usuario para el señor'.$usuario;
                        
                        date_default_timezone_set('America/Bogota');
                        $fechaA=date('Y-m-j h:i:s A');
                        
                        $agregarActividads= $mysqli->query("INSERT INTO actividades(idUsuario,iformulario,titulo,fecha,mensaje) VALUES('$usuarioID', '$validandoNotificacions', '$tituloA', '$fechaA','$mensajeA')")or die(mysqli_error($mysqli));
                        
                        /////////// se envían los datos de creación de usuario a ese usuario
                       
                        /////////// Fin se envían los datos de creación de usuario a ese usuario
                    }elseif($correoH == 1){
                        
                        /////////// se envían los datos de creación de usuario a ese usuario
                       
                    }elseif($plataformaH == 1){
                        $tituloA='Nuevo usuario creado';
                        $mensajeA='Se crea usuario para el señor '.$usuario;
                        
                        date_default_timezone_set('America/Bogota');
                        $fechaA=date('Y-m-j h:i:s A');
                        
                        $agregarActividads= $mysqli->query("INSERT INTO actividades(idUsuario,iformulario,titulo,fecha,mensaje) VALUES('$usuarioID', '$validandoNotificacions', '$tituloA', '$fechaA','$mensajeA')")or die(mysqli_error($mysqli));
                        
                    }
        ////////// fin del proceso
                
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
        
                //echo '<script language="javascript">alert("Agregado con Exito");
                //window.location.href="../../tipoDocumento"</script>';
                
            }else{
            // echo 'Está entrendo en esta opción C';
             
              // funcion para quitar espacios
                function Quitar_Espacios($nombre)
                {
                    $array = explode(' ',$nombre);  // convierte en array separa por espacios;
                    $salida ='';
                    // quita los campos vacios y pone un solo espacio
                    for ($i=0; $i < count($array); $i++) { 
                        if(strlen($array[$i])>0) {
                            $salida.= ' ' . $array[$i];
                        }
                    }
                  return  trim($salida);
                }
                /// END
               
                $salida = Quitar_Espacios($prefijo);
                
                // funcion para quitar espacios
                function Quitar_EspaciosB($prefijo)
                {
                    $arrayB = explode(' ',$prefijo);  // convierte en array separa por espacios;
                    $salidaB ='';
                    // quita los campos vacios y pone un solo espacio
                    for ($i=0; $i < count($arrayB); $i++) { 
                        if(strlen($arrayB[$i])>0) {
                            $salidaB.= ' ' . $arrayB[$i];
                        }
                    }
                  return  trim($salidaB);
                }
                /// END
               
                $salidaB = Quitar_EspaciosB($prefijo);
                
                
                
        
        
        		///////// consultamos la tabla y extraemos el nombre
        		$sql= $mysqli->query("SELECT * FROM tipoDocumento WHERE  nombre ='$salida' OR prefijo='$salidaB'   "); //nombre ='$salida' OR prefijo='$salidaB' 
        		$numRows = mysqli_num_rows($sql);
                if($numRows > 0){
                    //echo '<script language="javascript">alert("El nombre ya existe.");
                    //window.location.href="../../tipoDocumento"</script>';
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
            
            
                
                $ruta = "Nohayfoto";
                 $mysqli->query("INSERT INTO tipoDocumento (nombre, prefijo,descripcion, inicial,ruta) VALUES('$nombre', '$prefijo','$descripcion', '$inicial','$ruta' ) ")or die(mysqli_error($mysqli));

                //echo '<script language="javascript">alert("OK");
                //window.location.href="../../tipoDocumento"</script>';
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
    ////////////////////////////////////
    

    
    
    
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
                    $salida ='';
                    // quita los campos vacios y pone un solo espacio
                    for ($i=0; $i < count($array); $i++) { 
                        if(strlen($array[$i])>0) {
                            $salida.= ' ' . $array[$i];
                        }
                    }
                  return  trim($salida);
                }
                /// END
               
                $salida = Quitar_Espacios($prefijo);
                
                // funcion para quitar espacios
                function Quitar_EspaciosB($prefijo)
                {
                    $arrayB = explode(' ',$prefijo);  // convierte en array separa por espacios;
                    $salidaB ='';
                    // quita los campos vacios y pone un solo espacio
                    for ($i=0; $i < count($arrayB); $i++) { 
                        if(strlen($arrayB[$i])>0) {
                            $salidaB.= ' ' . $arrayB[$i];
                        }
                    }
                  return  trim($salidaB);
                }
                /// END
               
                $salidaB = Quitar_EspaciosB($prefijo);    
        
        
        
        
        
    $validacion2 = $mysqli->query("SELECT * FROM tipoDocumento WHERE nombre = '$salida' AND NOT id = '$id' ");
    $numRows2 = mysqli_num_rows($validacion2);
    
    $validacion3 = $mysqli->query("SELECT * FROM tipoDocumento WHERE prefijo = '$salidaB' AND NOT id = '$id' ");
    $numRows3 = mysqli_num_rows($validacion3);
    
    if($numRows2 > 0 || $numRows3 > 0){
        
    //echo '<script language="javascript">alert("ese nombre ya esta en uso.");
    //window.location.href="../../tipoDocumento"</script>';
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
        
        
      
      
    $archivoNombre = $_FILES['archivo']['name'];
    $guardado = $_FILES['archivo']['tmp_name'];
    
    if(!file_exists('../../archivos/plantillasTipoDocumento')){
        mkdir('../../archivos/plantillasTipoDocumento',0777,true);
        if(file_exists('../../archivos/plantillasTipoDocumento')){
            if(move_uploaded_file($guardado, '../../archivos/plantillasTipoDocumento/'.$archivoNombre)){
                $ruta = 'archivos/plantillasTipoDocumento/'.$archivoNombre;
                ///////// consultamos la tabla y extraemos el nombre
        		$sql= $mysqli->query("SELECT * FROM tipoDocumento WHERE ruta = '$ruta' ");
        		$numRows = mysqli_num_rows($sql);
                if($numRows > 0){
                    //echo '<script language="javascript">alert("El documento ya existe.");
                    //window.location.href="../../tipoDocumento"</script>';
                        ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../tipoDocumento" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionExisteB" value="1">
                            </form> 
                        <?php
                
                }else{
        
                        $mysqli->query("UPDATE tipoDocumento SET  nombre='$nombre', prefijo='$prefijo', descripcion='$descripcion', inicial = '$inicial', ruta='$ruta' WHERE id = '$id'");
                }
                
                //echo '<script language="javascript">alert("Actualizado con exito.");
                //window.location.href="../../tipoDocumento"</script>';
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
            }else{
                $ruta = "nohayfoto";
                 $mysqli->query("UPDATE tipoDocumento SET  nombre='$nombre', prefijo='$prefijo', descripcion='$descripcion', inicial = '$inicial', ruta='$ruta' WHERE id = '$id'");
                 
                //echo '<script language="javascript">alert("Actualizado con exito.");
                //window.location.href="../../tipoDocumento"</script>';
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
    }else{
        if(move_uploaded_file($guardado, '../../archivos/plantillasTipoDocumento/'.$archivoNombre)){
                $ruta = 'archivos/plantillasTipoDocumento/'.$archivoNombre;
               
        		///////// consultamos la tabla y extraemos el nombre
        		$sql= $mysqli->query("SELECT * FROM tipoDocumento WHERE ruta = '$ruta' ");
        		$numRows = mysqli_num_rows($sql);
                if($numRows > 0){
                    //echo '<script language="javascript">alert("El documento ya existe.");
                    //window.location.href="../../tipoDocumento"</script>';
                        ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../tipoDocumento" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionExisteB" value="1">
                            </form> 
                        <?php
                
                }else{
                    $mysqli->query("UPDATE tipoDocumento SET  nombre='$nombre', prefijo='$prefijo', descripcion='$descripcion', inicial = '$inicial', ruta='$ruta' WHERE id = '$id'");
                }
                //echo '<script language="javascript">alert("Actualizado con exito.");
                //window.location.href="../../tipoDocumento"</script>';
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
                    
    }else{
                $ruta = "Nohayfoto";
                $mysqli->query("UPDATE tipoDocumento SET  nombre='$nombre', prefijo='$prefijo', descripcion='$descripcion', inicial = '$inicial', ruta='$ruta' WHERE id = '$id'");
                //echo '<script language="javascript">alert("Actualizado con exito.");
               // window.location.href="../../tipoDocumento"</script>';
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
   //eliminar de tipoDoc
   
   //echo '<script language="javascript">alert("exito al eliminar.");
  // window.location.href="../../tipoDocumento"</script>';
}
?>