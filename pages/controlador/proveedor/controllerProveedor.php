<?php
//////// traemos la bd
require_once '../../conexion/bd.php';
mb_internal_encoding("UTF-8");
////////// validamos el ingreso por el name del  boton del formulario
if(isset($_POST['AgregarProveedor'])){

$nit=$_POST['nit'];
$nitDigito=$_POST['nitDigito'];

$contacto=utf8_decode($_POST['contacto']);
$razonSocial= utf8_decode($_POST['razonSocial']);
$email=utf8_decode($_POST['email']);

$codigoCiiu=$_POST['codigoCiiu'];
$descripcion=utf8_decode($_POST['descripcion']);

$criticidad=$_POST['criticidad'];
$grupo=$_POST['grupo'];
$movil=$_POST['movil'];
 
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
$direccion=utf8_decode($_POST['direccion']);
$frecuenciaAD=$_POST['frecuenciaAD'];
$telefono=$_POST['telefono'];
$tiempoE=$_POST['tiempoE'];

$personaNJ=$_POST['personaNJ'];
$tipoproveedor=$_POST['tipoproveedor'];

$radiobtn=$_POST['radiobtn'];
$responsableIndicador = json_encode($_POST['select_encargadoRI']);

    $validacion1 = $mysqli->query("SELECT * FROM proveedores WHERE nit = '$nit' AND nitDigito='$nitDigito' ");//consulta a base de datos si el nombre se repite
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
                             
                            <form name="miformulario" action="../../proveedoresInscripcion" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionExiste" value="1">
                            </form> 
                        <?php
    }else{
        
            
    
        // END
        
    /// id del usuatrio que realizo la inscripcion y poder notificar si fue aprobado o rechazadp un proveedor o algún documento
    $realizador=$_POST['realizador'];
    // END
        date_default_timezone_set('America/Bogota');
        $fecha1=date('Y-m-j');
        $mysqli->query("INSERT INTO proveedores (nit,razonSocial,descripcion,grupo,ciudad,direccion,telefono,contacto,email,criticidad,terminoPago,frecuenciaActualizacion,frecuenciaActualizacionD,tiempoEvaluacion,personaNJ,tipoproveedor,estado,tipo,radio,aprobador,realizador,creacion,movil,nitDigito,codigoCiiu) 
            VALUES('$nit','$razonSocial','$descripcion','$grupo','$ciudad','$direccion','$telefono','$contacto','$email','$criticidad','$terminoP','0','$frecuenciaAD','$tiempoE','$personaNJ','$tipoproveedor','Pendiente','".$_POST['terminoPago']."','$radiobtn','$responsableIndicador','$realizador','$fecha1','$movil','$nitDigito','$codigoCiiu') ")or die(mysqli_error($mysqli));
        //echo '<script language="javascript">confirm("El proveedor fue creado con éxito");
        //window.location.href="../../proveedores"</script>';
                        ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../proveedoresInscripcion" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionAgregar" value="1">
                            </form> 
                        <?php
    }
    
}elseif(isset($_POST['EditarProveedor'])){

$id=$_POST['idProveedor'];    
$nit=$_POST['nit'];
$nitDigito=$_POST['nitDigito'];

$contacto=utf8_decode($_POST['contacto']);
$razonSocial= utf8_decode($_POST['razonSocial']);
$email=utf8_decode($_POST['email']);

$codigoCiiu=$_POST['codigoCiiu'];
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
$direccion=utf8_decode($_POST['direccion']);
$frecuenciaAD=$_POST['frecuenciaAD'];
$telefono=$_POST['telefono'];
$tiempoE=$_POST['tiempoE'];
$movil=$_POST['movil'];

$personaNJ=$_POST['personaNJ'];
$tipoproveedor=$_POST['tipoproveedor'];

if($_POST['masivo'] == 1){
 $radiobtn='usuario';
 $responsableIndicador='["'.$_POST['Usuario'].'"]';
}else{
 $radiobtn=$_POST['radiobtn'];
 $responsableIndicador = json_encode($_POST['select_encargadoRI']);   
}


    $validacion1 = $mysqli->query("SELECT * FROM proveedores WHERE nit = '$nit' AND nitDigito='$nitDigito' AND id != '$id' ");//consulta a base de datos si el nombre se repite
    $numNom = mysqli_num_rows($validacion1);
    if($numNom > 0){//si el nombre está repetido se pone falso
        $insertar = false;
               if($_POST['masivo'] == 1){
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
        ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../proveedoresInscripcion" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionExiste" value="1">
                            </form> 
                        <?php
                }
    }else{
        
        
        
    $mysqli->query("UPDATE proveedores SET nit='$nit',razonSocial='$razonSocial',descripcion='$descripcion',grupo='$grupo',ciudad='$ciudad',direccion='$direccion',telefono='$telefono',contacto='$contacto',email='$email',criticidad='$criticidad',terminoPago='$terminoP',
    frecuenciaActualizacion='0',frecuenciaActualizacionD='$frecuenciaAD',tiempoEvaluacion='$tiempoE', personaNJ='$personaNJ', tipoproveedor='$tipoproveedor', tipo='".$_POST['terminoPago']."', radio='$radiobtn', aprobador='$responsableIndicador', movil='$movil', nitDigito='$nitDigito', codigoCiiu='$codigoCiiu' WHERE id='$id' ")or die(mysqli_error($mysqli));
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
                             
                            <form name="miformulario" action="../../proveedores" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionActualizar" value="1">
                            </form> 
                        <?php
        }else{
            if($_POST['masivo'] == 1){
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
                             
                            <form name="miformulario" action="../../proveedoresInscripcion" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionActualizar" value="1">
                            </form> 
                        <?php
            }
        }
    }
   
}elseif(isset($_POST['Eliminar'])){
    
                        $id = $_POST['idProveedor'];
                        /*
                        $consulta=$mysqli->query("SELECT * FROM proveedordocumentos WHERE idProveedor='$id' ");
                        while($extraer=$consulta->fetch_array()){
                            $documento=$extraer['soporte'];
                            unlink('../../'.$documento);
                        }
                        $mysqli->query("  DELETE from proveedorSubCarpetas  WHERE idProveedor = '$id'")or die(mysqli_error($mysqli));
                        $mysqli->query("  DELETE from proveedordocumentos  WHERE idProveedor = '$id'")or die(mysqli_error($mysqli));
                        $mysqli->query("  DELETE from proveedordocumentosCarpetas  WHERE idProveedor = '$id'")or die(mysqli_error($mysqli));
                        */
                        $mysqli->query("  DELETE from proveedores  WHERE id = '$id'")or die(mysqli_error($mysqli));
                        $mysqli->query("  DELETE from proveedoresControlCambio  WHERE idProveedor = '$id'")or die(mysqli_error($mysqli));
                        $mysqli->query("  DELETE from carpeta  WHERE rol = '$id'")or die(mysqli_error($mysqli));
                        $mysqli->query("  DELETE from uploadsP  WHERE user = '$id'")or die(mysqli_error($mysqli));
                        
                       
                        
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
                        $dir='../../archivos/documentoProveedor/'.$id; 
                        deleteDirectory($dir);
                        
                       if($_POST['masivo'] != NULL){
                        ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../proveedorVigente" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionEliminar" value="1">
                            </form> 
                        <?php   
                       }else{
                        ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../proveedoresInscripcion" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionEliminar" value="1">
                            </form> 
                        <?php
                       }
    
}elseif(isset($_POST['Bloquear'])){
     $id = $_POST['idProveedor'];
     $bloqueos=utf8_decode($_POST['bloque']);
                        $mysqli->query(" UPDATE  proveedores SET estado='bloqueo', bloqueo='$bloqueos'  WHERE id = '$id'")or die(mysqli_error($mysqli));
    
     ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../proveedores" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionExisteImportacionF" value="1">
                            </form> 
                        <?php
}elseif(isset($_POST['Desbloquear'])){
     $id = $_POST['idProveedor'];
     $bloqueos=utf8_decode($_POST['bloque']);
                        $mysqli->query(" UPDATE  proveedores SET estado='Aprobado', bloqueo='$bloqueos'  WHERE id = '$id'")or die(mysqli_error($mysqli));
    
     ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../proveedoresBloquearV" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionExisteImportacionF" value="1">
                            </form> 
                        <?php
}

if(isset($_POST['notificarAprobador'])){
    
    $nombreCarpetaPrincial = $_POST['nombreCarpetaPrincial'];
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
                                            <p>Los documentos de la carpeta <b>'.$nombreCarpetaPrincial.'.</b> del proveedor <b>'.$nombreDocEnviar.'.</b> se encuentran pendientes para su revisión.</p>
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
                             
                            <form name="miformulario" action="../../proveedorDocumetosCarpetasB" method="POST" onsubmit="procesar(this.action);" >
                                <input name="idProveedor" value="<?php echo $_POST['idProveedor']; ?>" type="hidden" readonly>
                                <input name="filaCarpeta" value="<?php echo $_POST['filaCarpeta']; ?>" type="hidden">
                                <input value="<?php echo $_POST['carpetaAbrir'];?>" name="carpetaAbrir" type="hidden">
                                <input name="abrirCarpeta" value="1" type="hidden">
                                
                                <input type="hidden" name="validacionExisteImportacionB" value="1">
                            </form> 
                        <?php
}

if(isset($_POST['AgregarProveedorMasivo'])){

$nit=$_POST['nit'];
$nitDigito=$_POST['nitDigito'];
$contacto=utf8_decode($_POST['contacto']);
$razonSocial= utf8_decode($_POST['razonSocial']);
$email=utf8_decode($_POST['email']);
$codigoCiiu=$_POST['codigoCiiu'];
$descripcion=utf8_decode($_POST['descripcion']);
$criticidad=$_POST['criticidad'];
$grupo=$_POST['grupo'];
$movil=$_POST['movil'];
 
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

$responsableIndicador='["'.$Usuario.'"]';

//$responsableIndicador = json_encode($_POST['select_encargadoRI']);

    $validacion1 = $mysqli->query("SELECT * FROM proveedores WHERE nit = '$nit' AND nitDigito='$nitDigito' ");//consulta a base de datos si el nombre se repite
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
        date_default_timezone_set('America/Bogota');
        $fecha1=date('Y-m-j');
        $mysqli->query("INSERT INTO proveedores (nit,razonSocial,descripcion,grupo,ciudad,direccion,telefono,contacto,email,criticidad,terminoPago,frecuenciaActualizacion,frecuenciaActualizacionD,tiempoEvaluacion,personaNJ,tipoproveedor,estado,tipo,radio,aprobador,realizador,creacion,movil,nitDigito,codigoCiiu) 
            VALUES('$nit','$razonSocial','$descripcion','$grupo','$ciudad','$direccion','$telefono','$contacto','$email','$criticidad','$terminoP','0','$frecuenciaAD','$tiempoE','$personaNJ','$tipoproveedor','Ejecucion','".$_POST['terminoPago']."','$radiobtn','$responsableIndicador','$realizador','$fecha1','$movil','$nitDigito','$codigoCiiu') ")or die(mysqli_error($mysqli));
        
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
    
}
?>