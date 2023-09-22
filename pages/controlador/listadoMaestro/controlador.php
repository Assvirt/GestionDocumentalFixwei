<?php error_reporting(E_ERROR);
//////// traemos la bd
ignore_user_abort(1);
set_time_limit(0); 
require '../../correoEnviar/libreria/PHPMailerAutoload.php';
require_once '../../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario

$radiobtnAut=$_POST['radiobtnAut'];
if($_POST['select_encargadoAutA'] != NULL){
  $select_encargadoAut=$_POST['select_encargadoAutA'];  
}elseif($_POST['select_encargadoAutB'] != NULL){
  $select_encargadoAut=$_POST['select_encargadoAutB'];  
}elseif($_POST['select_encargadoAutC'] != NULL){
  $select_encargadoAut=$_POST['select_encargadoAutC']; 
}



if($select_encargadoAut != NULL){
    if($_POST['obsoleto'] != NULL){
        $tipoSolicitudEnviar='Eliminación';    
    }else{
        $tipoSolicitudEnviar=$_POST['tipoSolicitudEnviar'];
    }
    $codigo=$_POST['codigo'];
    $nombresDocumento=$_POST['nombresDocumento'];
    //$observaciones=trim(preg_replace('/\s+/', ' ', $_POST['observaciones']));
    //” “
    $observaciones=nl2br($_POST['observaciones']);
    '<br><br>';
    $enviarPrimeraValidacion=str_replace('“', '"', $observaciones).'<br>';
    '<br><br>';
    $observaciones=str_replace('”', '"', $enviarPrimeraValidacion).'<br>';
    
    
    //echo $observaciones=nl2br($_POST['observaciones']);//nl2br
    'ID'.$idDocumentoDescargar=$_POST['idDocumento'];
    
    
    
    ////////////////////////////////////Validacion carga de documento
        $archivoNombre = $_FILES['archivo']['name'];
        $guardado = $_FILES['archivo']['tmp_name'];
        if($archivoNombre != NULL){
            //echo 'Entra';
            if(!file_exists('../../archivos/documentos')){
                mkdir('../../archivos/documentos',0777,true);
                if(file_exists('../../archivos/documentos')){
                    if(move_uploaded_file($guardado, '../../archivos/documentos/'.'-Divulgación'.$idDocumentoDescargar.$archivoNombre)){
                        $ruta = 'archivos/documentos/'.'-Divulgación'.$idDocumentoDescargar.$archivoNombre;
                        ///////// consultamos la tabla y extraemos el nombre
                		
                       
                            'rutaA:'. $ruta=$ruta;
                            $mysqli->query("UPDATE documento SET divulgacion = '$ruta' WHERE id='$idDocumentoDescargar'")or die(mysqli_error($mysqli));
                       
                
                    }else{
                       // echo '1';
                        
                    }
                }
                
            }else{
                if(move_uploaded_file($guardado, '../../archivos/documentos/'.'-Divulgación'.$idDocumentoDescargar.$archivoNombre)){
                        $ruta = 'archivos/documentos/'.'-Divulgación'.$idDocumentoDescargar.$archivoNombre;
                       
                       
                             'rutaB:'.$ruta=$ruta;
                            $mysqli->query("UPDATE documento SET divulgacion = '$ruta' WHERE id='$idDocumentoDescargar'")or die(mysqli_error($mysqli));
        
                      
                    }else{
                        //echo '2';
                        $ruta = "Nohayfoto";
                        
                   }
                
            }
        }
    
    
    
    
    $radiobtnDoc=$_POST['radiobtnDoc'];
    
    
    
    $ruta=$documentoEditable=$_POST['documentoEditable'];
    $ruta2=$documentoPDF=$_POST['documentoPDF'];
    
    if($radiobtnDoc == 'ambos'){
        $contenido='
        Descarga los documentos en los siguientes enlaces.<br>
        <a href="https://fixwei.com/plataforma/pages/descargarDocumentos?editable='.$idDocumentoDescargar.'" target="_blank">Documento editable</a>
        <br>
        <a href="https://fixwei.com/plataforma/pages/descargarDocumentos?pdf='.$idDocumentoDescargar.'" target="_blank">Documento pdf</a>
       ';
    }elseif($radiobtnDoc == 'editable'){
        $contenido='
        Descarga el documento editable en el siguiente enlaces.<br>
        <a href="https://fixwei.com/plataforma/pages/descargarDocumentos?editable='.$idDocumentoDescargar.'" target="_blank">Documento editable</a>
       ';
    }elseif($radiobtnDoc == 'pdf'){
        $contenido='
        Descarga el documentos pdf en el siguiente enlace.<br>
        <a href="https://fixwei.com/plataforma/pages/descargarDocumentos?pdf='.$idDocumentoDescargar.'" target="_blank">Documento pdf</a>
       ';
    }
    
    
    if($archivoNombre != NULL){
       $divulgarDocumento='<br><br><a href="https://fixwei.com/plataforma/pages/descargarDocumentos?divulgar='.$idDocumentoDescargar.'" target="_blank">Documento de divulgación</a>';
    }
    
    
    
    if($radiobtnAut == 'cargo'){
        ///////////// consultamos los cargos
        $longitud=count($select_encargadoAut); 
         
        for($i=0; $i<$longitud; $i++){
            $select_encargadoAut[$i]; 
            $consultaUsuarios=$mysqli->query("SELECT * FROM usuario WHERE cargo='$select_encargadoAut[$i]' ");
            while($extraerUsuario=$consultaUsuarios->fetch_array()){
                 $correos=$extraerUsuario['correo']; 
                
                        //Create a new PHPMailer instance
                        
                        $mail = new PHPMailer();
                        $mail->IsSMTP();
                 
                       
                        require '../../correoEnviar/contenido.php';
                      
                        $mail->isHTML(true);
                        $mail->AddAddress($correos); //$correos
                        $mail->Subject = utf8_decode('Divulgación '.$tipoSolicitudEnviar);
                        
                        $nombre=utf8_encode($extraerUsuario['nombres']);  '<br>';
                        $apellido=utf8_encode($extraerUsuario['apellidos']);  '<br>';
                       
                 
                
                        $mail->Body =utf8_decode(('
                        <html>
                        <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                        <title>HTML</title>
                        </head>
                        <body>
                        <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                        
                        <p>Estimado (a). <b><em>'.($nombre.' '.$apellido).'</em></b>.
                        <br>
                        <p><b>'.$tipoSolicitudEnviar.' del documento '.$nombresDocumento.' con código '.$codigo.' </b>.
                        <br>
                        <br>
                        '.$contenido.'
                        <br><br>
                        '.$observaciones.'
                        '.$divulgarDocumento.'
                        <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                        <br><br>
                        Este correo es informativo y por tanto, le pedimos no responda este mensaje.
                        </p>
                        </body>
                        </html>
                        '));
                        //Avisar si fue enviado o no y dirigir al index
                        
                        if ($mail->Send()) {
                            
                        } else {
                            
                        }
                        $mail->ClearAddresses();  
                        
                
            }
        } 
        
    }elseif($radiobtnAut == 'usuario'){
        //////////// consultamos los usuarios
        $longitud=count($select_encargadoAut); 
        
        for($i=0; $i<$longitud; $i++){
            $select_encargadoAut[$i]; 
            $consultaUsuarios=$mysqli->query("SELECT * FROM usuario WHERE id='$select_encargadoAut[$i]' ");
            while($extraerUsuario=$consultaUsuarios->fetch_array()){
                 $correos=$extraerUsuario['correo']; 
                
                        //Create a new PHPMailer instance
                        
                        $mail = new PHPMailer();
                        $mail->IsSMTP();
                 
                        require '../../correoEnviar/contenido.php';
                      
                        $mail->isHTML(true);
                        $mail->AddAddress($correos); //$correos
                        $mail->Subject = utf8_decode('Divulgación '.$tipoSolicitudEnviar);
                        
                        $nombre=utf8_encode($extraerUsuario['nombres']);  '<br>';
                        $apellido=utf8_encode($extraerUsuario['apellidos']);  '<br>';
                       
                 
                
                        $mail->Body =utf8_decode(('
                        <html>
                        <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                        <title>HTML</title>
                        </head>
                        <body>
                        <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                        
                        <p>Estimado (a). <b><em>'.($nombre.' '.$apellido).'</em></b>.
                        <br>
                        <p><b>'.$tipoSolicitudEnviar.' del documento '.$nombresDocumento.' con código '.$codigo.' </b>.
                        <br>
                        <br>
                        '.$contenido.'
                        <br><br>
                        '.$observaciones.'
                        '.$divulgarDocumento.'
                        <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                        <br><br>
                        Este correo es informativo y por tanto, le pedimos no responda este mensaje.
                        </p>
                        </body>
                        </html>
                        '));
                        //Avisar si fue enviado o no y dirigir al index
                        
                        if ($mail->Send()) {
                            
                        } else {
                            
                        }
                        $mail->ClearAddresses();  
                        
                
            }
        } 
        
    }elseif($radiobtnAut == 'grupo'){
        //////////// consultamos los grupos
        $longitud=count($select_encargadoAut);
        
        for($i=0; $i<$longitud; $i++){
            $select_encargadoAut[$i]; 
            $consultaUsuarios=$mysqli->query("SELECT * FROM grupoUusuario WHERE idGrupo='$select_encargadoAut[$i]' ");
            while($extraerUsuario=$consultaUsuarios->fetch_array()){
                
                
                            $centrosN = $mysqli->query("SELECT * FROM usuario WHERE cedula = '". $extraerUsuario['idUsuario']."'");
                            $nombresC = $centrosN->fetch_array(MYSQLI_ASSOC);
                            $correos=$nombresC['correo'];
                        //Create a new PHPMailer instance
                        
                        $mail = new PHPMailer();
                        $mail->IsSMTP();
                 
                        
                        require '../../correoEnviar/contenido.php';
                      
                        $mail->isHTML(true);
                        $mail->AddAddress($correos); //$correos
                        $mail->Subject = utf8_decode('Divulgación '.$tipoSolicitudEnviar);
                        
                        $nombre=utf8_encode($nombresC['nombres']);  '<br>';
                        $apellido=utf8_encode($nombresC['apellidos']);  '<br>';
                       
                 
                
                        $mail->Body =utf8_decode(('
                        <html>
                        <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                        <title>HTML</title>
                        </head>
                        <body>
                        <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                        
                        <p>Estimado (a). <b><em>'.($nombre.' '.$apellido).'</em></b>.
                        <br>
                        <p><b>'.$tipoSolicitudEnviar.' del documento '.$nombresDocumento.' con código '.$codigo.' </b>.
                        <br>
                        <br>
                        '.$contenido.'
                        <br><br>
                        '.$observaciones.'
                        '.$divulgarDocumento.'
                        <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                        <br><br>
                        Este correo es informativo y por tanto, le pedimos no responda este mensaje.
                        </p>
                        </body>
                        </html>
                        '));
                        //Avisar si fue enviado o no y dirigir al index
                        
                        if ($mail->Send()) {
                            
                        } else {
                            
                        }
                        $mail->ClearAddresses();   
                        
                
            }
        } 
        
    }
    
    if($_POST['obsoleto'] != NULL){
    ?>
                <script> 
                     window.onload=function(){
                   
                         document.forms["miformulario"].submit();
                     }
                </script>
                 
                <form name="miformulario" action="../../verDocumento" method="POST" onsubmit="procesar(this.action);" >
                    <input value="<?php echo $_POST['idDocumento'];?>" name="idDocumento" type="hidden">
                    <input value="1" name="verObsoletos" type="hidden">
                    <input type="hidden" name="validacionAgregar" value="1">
                </form> 
    <?php    
    }else{
    ?>
                <script> 
                     window.onload=function(){
                   
                         document.forms["miformulario"].submit();
                     }
                </script>
                 
                <form name="miformulario" action="../../verDocumento" method="POST" onsubmit="procesar(this.action);" >
                    <input value="<?php echo $_POST['idDocumento'];?>" name="idDocumento" type="hidden">
                    <input type="hidden" name="validacionAgregar" value="1">
                </form> 
    <?php
    }
    
}else{
 
  if($_POST['obsoleto'] != NULL){
    ?>
                <script> 
                     window.onload=function(){
                   
                         document.forms["miformulario"].submit();
                     }
                </script>
                 
                <form name="miformulario" action="../../verDocumento" method="POST" onsubmit="procesar(this.action);" >
                    <input value="<?php echo $_POST['idDocumento'];?>" name="idDocumento" type="hidden">
                    <input value="1" name="verObsoletos" type="hidden">
                    <input type="hidden" name="validacionVacio" value="1">
                </form> 
    <?php    
    }else{
    ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../verDocumento" method="POST" onsubmit="procesar(this.action);" >
                <input value="<?php echo $_POST['idDocumento'];?>" name="idDocumento" type="hidden">
                <input type="hidden" name="validacionVacio" value="1">
            </form> 
<?php  
    }
}
?>