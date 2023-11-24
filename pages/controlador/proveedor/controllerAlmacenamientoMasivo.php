<?php
//////// traemos la bd
require_once '../../conexion/bd.php';
mb_internal_encoding("UTF-8");

date_default_timezone_set('America/Bogota');
$fecha1=date('Y-m-j');
////////// validamos el ingreso por el name del  boton del formulario
if(isset($_POST['AgregarProveedor'])){

$nit=$_POST['nit'];
$contacto=utf8_decode($_POST['contacto']);
$razonSocial= utf8_decode($_POST['razonSocial']);
$email=utf8_decode($_POST['email']);
$descripcion=utf8_decode($_POST['descripcion']);
$criticidad=$_POST['criticidad'];
$grupo=$_POST['grupo'];
$contacto = $_POST['contacto'];

 
// validaciones para el ingreso de dias


if( $_POST['terminoPago'] == 'credito'){
    $terminoP=$_POST['terminoPagoNumeros']; 
}elseif($_POST['terminoPago'] == 'otro'){
   $terminoP=utf8_decode($_POST['Otro']);  
}else{
   $terminoP='0';
}


//// END 

$ciudad=utf8_decode($_POST['ciudad']);
$frecuenciaA=$_POST['frecuenciaA'];
$direccion=$_POST['direccion'];
$frecuenciaAD=$_POST['frecuenciaAD'];
$telefono=$_POST['telefono'];
$tiempoE=$_POST['tiempoE'];

$personaNJ=$_POST['personaNJ'];
$tipoproveedor=$_POST['tipoproveedor'];

$radiobtn=$_POST['radiobtn'];
$responsableIndicador = json_encode($_POST['select_encargadoRI']);

    $validacion1 = $mysqli->query("SELECT * FROM proveedores WHERE nit = '$nit' ");//consulta a base de datos si el nombre se repite
    $numNom = mysqli_num_rows($validacion1);
    if($numNom > 0){//si el nombre está repetido se pone falso
        $insertar = false;
        //echo '<script language="javascript">alert("El nit del proveedor ya existe.");
       // window.location.href="../../agregarProveedor"</script>';
        ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../proveedorVigente" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionExiste" value="1">
                            </form> 
                        <?php
    }else{
        
            
    
        // END
        
    /// id del usuatrio que realizo la inscripcion y poder notificar si fue aprobado o rechazadp un proveedor o algún documento
    $realizador=$_POST['realizador'];
    // END
        $mysqli->query("INSERT INTO proveedores (nit,razonSocial,descripcion,grupo,ciudad,direccion,telefono,contacto,email,criticidad,terminoPago,frecuenciaActualizacion,frecuenciaActualizacionD,tiempoEvaluacion,personaNJ,tipoproveedor,estado,tipo,radio,aprobador,realizador) 
            VALUES('$nit','$razonSocial','$descripcion','$grupo','$ciudad','$direccion','$telefono','$contacto','$email','$criticidad','$terminoP','0','$frecuenciaAD','$tiempoE','$personaNJ','$tipoproveedor','Ejecucion','".$_POST['terminoPago']."','$radiobtn','$responsableIndicador','$realizador') ")or die(mysqli_error($mysqli));
        //echo '<script language="javascript">confirm("El proveedor fue creado con éxito");
        //window.location.href="../../proveedores"</script>';
                        ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../proveedorVigente" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionAgregar" value="1">
                            </form> 
                        <?php
    }
    
}elseif(isset($_POST['EditarProveedor'])){

$id=$_POST['idProveedor'];    
$nit=$_POST['nit'];
$contacto=utf8_decode($_POST['contacto']);
$razonSocial= utf8_decode($_POST['razonSocial']);
$email=utf8_decode($_POST['email']);
$descripcion=utf8_decode($_POST['descripcion']);
$criticidad=$_POST['criticidad'];
$grupo=$_POST['grupo'];
//$terminoP=$_POST['terminoPago'];


if( $_POST['terminoPago'] == 'credito'){
    $terminoP=$_POST['terminoPagoNumeros']; 
}elseif($_POST['terminoPago'] == 'otro'){
   $terminoP=utf8_decode($_POST['otro']);  
}else{
   $terminoP='0';
}





$ciudad=utf8_decode($_POST['ciudad']);
$frecuenciaA=$_POST['frecuenciaA'];
$direccion=$_POST['direccion'];
$frecuenciaAD=$_POST['frecuenciaAD'];
$telefono=$_POST['telefono'];
$tiempoE=$_POST['tiempoE'];    

$personaNJ=$_POST['personaNJ'];
$tipoproveedor=$_POST['tipoproveedor'];

$radiobtn=$_POST['radiobtn'];
$responsableIndicador = json_encode($_POST['select_encargadoRI']);

    $validacion1 = $mysqli->query("SELECT * FROM proveedores WHERE nit = '$nit' AND id != '$id' ");//consulta a base de datos si el nombre se repite
    $numNom = mysqli_num_rows($validacion1);
    if($numNom > 0){//si el nombre está repetido se pone falso
        $insertar = false;
        //echo '<script language="javascript">alert("El nit del proveedor ya existe.");
       // window.location.href="../../agregarProveedor"</script>';
        ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../proveedorVigente" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionExiste" value="1">
                            </form> 
                        <?php
    }else{
        
        
        
    $mysqli->query("UPDATE proveedores SET nit='$nit',razonSocial='$razonSocial',descripcion='$descripcion',grupo='$grupo',ciudad='$ciudad',direccion='$direccion',telefono='$telefono',contacto='$contacto',email='$email',criticidad='$criticidad',terminoPago='$terminoP',
    frecuenciaActualizacion='0',frecuenciaActualizacionD='$frecuenciaAD',tiempoEvaluacion='$tiempoE', personaNJ='$personaNJ', tipoproveedor='$tipoproveedor', tipo='".$_POST['terminoPago']."', radio='$radiobtn', aprobador='$responsableIndicador' WHERE id='$id' ")or die(mysqli_error($mysqli));
        //echo '<script language="javascript">confirm("El proveedor fue actualizado con éxito");
        //window.location.href="../../proveedores"</script>';C
        
         $validacion1cnsulta = $mysqli->query("SELECT * FROM proveedores WHERE id='$id' ");
         $extrerEsadoAconsulta=$validacion1cnsulta->fetch_array(MYSQLI_ASSOC);
         
        if($extrerEsadoAconsulta['estado'] == 'Aprobado'){
            ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../proveedorVigente" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionActualizar" value="1">
                            </form> 
                        <?php
        }else{
        ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../proveedorVigente" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionActualizar" value="1">
                            </form> 
                        <?php
        }
    }
   
}elseif(isset($_POST['ejecutadorIndividual'])){
      $id = $_POST['idProveedor'];
      $Usuario=$_POST['Usuario'];
      $registrarUsuario='["'.$Usuario.'"]';
     
                             $mysqli->query("UPDATE proveedores SET estado='Aprobado',fecha='$fecha1',radio='usuario',aprobador='$registrarUsuario' WHERE id='$id'")or die(mysqli_error($mysqli));

    
     ?>
                            <script> 
                                 window.onload=function(){
                               
                                    document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../proveedorVigente" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionExisteImportacionF" value="1">
                            </form> 
                        <?php

}elseif(isset($_POST['ejecutador'])){
    $Usuario=$_POST['Usuario'];
    $registrarUsuario='["'.$Usuario.'"]';
    $fecha1;
    $mysqli->query("UPDATE proveedores SET estado='Aprobado',fecha='$fecha1',radio='usuario',aprobador='$registrarUsuario' WHERE estado='ejecucion' ");
    ?>
                        <script> 
                             window.onload=function(){
                           
                                document.forms["miformulario"].submit();
                             }
                        </script>
                         
                        <form name="miformulario" action="../../proveedores" method="POST" onsubmit="procesar(this.action);" >
                        </form> 
                    <?php
}

if(isset($_POST['notificarAprobador'])){
    
    $consultaProveedor=$mysqli->query("SELECT * FROM proveedores WHERe id='".$_POST['idProveedor']."' ");
    $extraerConsulta=$consultaProveedor->fetch_array(MYSQLI_ASSOC);
    
    $mysqli->query("UPDATE proveedores SET notificacion='Pendiente' WHERE id='".$_POST['idProveedor']."'  ");
    
    require '../usuarios/libreria/PHPMailerAutoload.php';
    
                $radiobtn=$extraerConsulta['radio'];
                $arrayEncargado=json_decode($extraerConsulta['aprobador']);
                $nombreDocEnviar=utf8_encode($extraerConsulta['razonSocial']);
                if($radiobtn == 'usuario'){ 
                    $longitud = count($arrayEncargado); 
                    for($i=0; $i<$longitud; $i++){
                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$arrayEncargado[$i]' ");
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
                                            $mail->Subject = utf8_decode('Aprobación del proveedor');
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
                                            <p>Los documentos del proveedor <b>'.$nombreDocEnviar.'.</b> se encuentran pendientes para su revisión.</p>
                                            Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                            <br>
                                            <em>Compras --> inscripción de proveedor </em>.
                                            <br>
                                            <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                            <br><br>
                                            Este correo es informativo por tanto, le pedimos no responda este mensaje.
                                            </p>
                                            </body>
                                            </html>
                                            ');
                                            
                                            //Avisar si fue enviado o no y dirigir al index
                                        
                                            if ($mail->Send()) {
                                            
                                            } else {

                                            }
                                        
                                            
                    }
                }

                if($radiobtn == 'cargo'){
                
                    $longitud = count($arrayEncargado);
                    for($i=0; $i<$longitud; $i++){ 
                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo='$arrayEncargado[$i]' ");
                        while($columna = $nombreuser->fetch_array()){
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
                            $mail->Subject = utf8_decode('Aprobación del proveedor');
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
                            <p>Los documentos del proveedor <b>'.$nombreDocEnviar.'.</b> se encuentran pendientes para su revisión.</p>
                            Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                            <br>
                            <em>Compras --> inscripción de proveedor </em>.
                            <br>
                            <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                            <br><br>
                            Este correo es informativo por tanto, le pedimos no responda este mensaje.
                            </p>
                            </body>
                            </html>
                            ');
                            
                            //Avisar si fue enviado o no y dirigir al index
                        
                            if ($mail->Send()) {
                            
                            } else {

                            }
                        
                            
                        }
                    }
                }
    
    
    ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../proveedorDocumetosCarpetas" method="POST" onsubmit="procesar(this.action);" >
                                <input name="idProveedor" value="<?php echo $_POST['idProveedor']; ?>" type="hidden" readonly>
                                <input type="hidden" name="validacionExisteImportacionB" value="1">
                            </form> 
                        <?php
}



if(isset($_POST['AgregarCarpeta'])){
   
    $nombre = $_POST['nombre'];
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
                           <form name="miformulario" action="../../subirDocumentoMasivo" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                               <input type="hidden" name="validacionExiste" value="1">
                            </form>
                            
                        <?php
    }else{
    
        $mysqli->query("INSERT INTO proveedordocumentosCarpetas(nombre,idProveedor,estado)VALUES('$nombre','$idProveedor','aprobado') ")or die(mysqli_error($mysqli));
    
?>
                            <script>
                                    window.onload=function(){
                                        //alert("El nombre o el archivo ya existen1");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../subirDocumentoMasivo" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                               <input type="hidden" name="validacionAgregar" value="1">
                            </form>
                            
<?php
    }
}

if(isset($_POST['EditarCarpeta'])){
    $idProveedor = $_POST['idProveedor'];
    $id=$_POST['idCarpeta'];
    $nombre=$_POST['nombre'];
    
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
                           <form name="miformulario" action="../../subirDocumentoMasivo" method="POST" onsubmit="procesar(this.action);" >
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
                            <form name="miformulario" action="../../subirDocumentoMasivo" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                               <input type="hidden" name="validacionActualizar" value="1">
                            </form>
                            
<?php
    }
}


if(isset($_POST['eliminar'])){
    $idProveedor= $_POST['idProveedor'];
    $id=$_POST['id'];
    
    $consulta=$mysqli->query("SELECT * FROM proveedordocumentos WHERE id='$id' ");
    $extraer=$consulta->fetch_array(MYSQLI_ASSOC);
    $documento=$extraer['soporte'];
    unlink('../../'.$documento);
    
    
    $mysqli->query("DELETE FROM proveedordocumentos WHERE id='$id' ")or die(mysqli_error($mysqli));
    
    /// actualizamos el estado al momento de ingresar un nuevo documento cuando este se encuentre rechazado

    /*
        $consultaCarpeta=$mysqli->query("SELECT * FROM proveedordocumentosCarpetas WHERE id='".$_POST['idCarpeta']."' ");
        $extraerCarpeta=$consultaCarpeta->fetch_array(MYSQLI_ASSOC);
        if($extraerCarpeta['estado'] == 'rechazado'){
            $mysqli->query("UPDATE proveedordocumentosCarpetas SET estado='Pendiente' WHERE  id='".$_POST['idCarpeta']."'  ");
                           
        }
    */

/// end                   
    
     ?>
                            <script>
                                    window.onload=function(){
                                        //alert("El nombre o el archivo ya existen1");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../proveedorDocumentosMasivo" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idCarpeta" value="<?php echo $_POST['idCarpeta']; ?>" type="hidden" readonly>
                               <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                               <input type="hidden" name="validacionEliminar" value="1">
                            </form>
                            
                        <?php
}

?>
