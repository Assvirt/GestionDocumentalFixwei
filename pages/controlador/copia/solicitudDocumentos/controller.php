<?php
error_reporting(E_ERROR); 
//////// traemos la bd
date_default_timezone_set("America/Bogota");
require_once '../../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario

if(isset($_POST['agregarSolicitud'])){ 
///agrega solicitud cuando el documento a crear es nuevo
    $tipoSolicitud = $_POST['tipoSolicitud'];
    $usuario = $_POST['usuario'];
    $nombre = utf8_decode($_POST['nombre']);//nombre del documento a crear
    $proceso = $_POST['proceso'];
    $tipoDoc = $_POST['tipoDoc'];
    $encargado = $_POST['encargado'];
    $solicitud = utf8_decode($_POST['solicitud']);
    $fecha = date("Y:m:j");
    
    $nombreEnviar=utf8_encode($nombre); // enviar a los correos
						 
	////////////////////////////////////
	$archivoNombre = $_FILES['archivo']['name'];
    $guardado = $_FILES['archivo']['tmp_name'];
    

   
    require '../../correoEnviar/libreria/PHPMailerAutoload.php';
    $extraerUsuarios = $mysqli->query("SELECT * FROM usuario WHERE cargo ='$encargado' ")or die(mysqli_error());
    //$usuariosCargo = $extraerUsuarios->fetch_array(MYSQLI_ASSOC);
    while($usuariosCargo = $extraerUsuarios->fetch_array()){
     'EL USUARIO: <b>'.$nombredelUsuario=utf8_encode($usuariosCargo['nombres'].' '.$usuariosCargo['apellidos']);
      ' tiene el id cargo: '.$usuariosCargo['cargo'].'</b>';
      $consultaCedula=$usuariosCargo['cedula'];
      $correoNotificar=$usuariosCargo['correo'];
  
  
          $consultandoGrupos=$mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario='$consultaCedula' ");
          while($extraerGruposDistribucion=$consultandoGrupos->fetch_array()){
          $extraerGruposDistribucion['id'];
          // subconsulta permisos
          $consultandoGruposSubconsulta=$mysqli->query("SELECT * FROM grupo WHERE id='".$extraerGruposDistribucion['idGrupo']."' ");
          $extraerGruposDistribucionSubconsulta=$consultandoGruposSubconsulta->fetch_array(MYSQLI_ASSOC);
          $sumandoPermisos+=$extraerGruposDistribucionSubconsulta['correo']; 
          // end
          }
  
          ///// validamos si tiene permiso autorizado para el envio de correos
          if($sumandoPermisos >= '1'){
            //  echo 'Tiene permiso<br>';
             
              //ignore_user_abort(1);
              //set_time_limit(0); 
            
              
              //Create a new PHPMailer instance
              $mail = new PHPMailer();
              $mail->IsSMTP();
              
              //Configuracion servidor mail
              ;
              require '../../correoEnviar/contenido.php';
             
              //Agregar destinatario
              $mail->isHTML(true);
              $mail->AddAddress($correoNotificar);
               '-Enviar: '.$correoNotificar;
              /// end
          
              $nombreDocumentoEnviarCorreo=$POST['nombre'];
              $solicitudDocumentoEnviarcorreo=$_POST['solicitud'];
  
              if($tipoSolicitud == '1'){
                  $tipoSolicitudNombre='creación';
              }
              if($tipoSolicitud == '2'){
                  $tipoSolicitudNombre='actualización';
              }
              if($tipoSolicitud == '3'){
                  $tipoSolicitudNombre='eliminación';
              }
  
              $mail->Subject='Solicitud de documento';
              $mail->Body = utf8_decode('
              <html>
              <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
              <title>HTML</title>
              </head>
              <body>
              <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
              
              <p>Estimado (a). <b><em>'.$nombredelUsuario.'</em></b>.
              <br>
              <p><b>Proceda a la '.$tipoSolicitudNombre.' del documento '.$nombreDocumentoEnviarCorreo.' y ejecutar la solicitud '.$solicitudDocumentoEnviarcorreo.', que se le ha asignado.</b></p>
              
              <br><br>
              Se recomienda ingresar y verificar su solicitud.
              <br><br>
              Este correo es informativo y por tanto, le pedimos no responda este mensaje.
              </p>
              </body>
              </html>
              ');
          
              //Avisar si fue enviado o no y dirigir al index
              if ($mail->Send()) {
                  //echo'<script type="text/javascript">
                  //    alert("Enviado Correctamente");
                  //    </script>';
                  
              } else {
                  //echo'<script type="text/javascript">
                  //    alert("NO ENVIADO, intentar de nuevo");
                  //    </script>';
              }
              $mail->ClearAddresses();  
              
              //// end
  
  
          }else{
          // echo 'No tiene permiso';
          }
          /// end
  
  
  
    }
  



   
  
    
    if($archivoNombre == NULL && $guardado == NULL){
        
        $ruta = 'sin datos';
        
        $mysqli->query("INSERT INTO solicitudDocumentos ( quienSolicita, tipoSolicitud, tipoDocumento, encargadoAprobar, nombreDocumento, nombreDocumento2, proceso, solicitud,fecha,documento,plataformaH)
                VALUES ('$usuario','$tipoSolicitud','$tipoDoc','$encargado','$nombre','$nombre','$proceso','$solicitud','$fecha','$ruta','1')")or die(mysqli_error($mysqli));

        //echo '<script language="javascript">alert("Agregado con Exito");
        //window.location.href="../../solicitudDocumentos"</script>';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../solicitudDocumentos" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionAgregar" value="1">
            </form> 
        <?php
        
    }
    
    if(!file_exists('../../archivos/solicitudes')){
        mkdir('../../archivos/solicitudes',0777,true);
        if(file_exists('../../archivos/solicitudes')){
            if(move_uploaded_file($guardado, '../../archivos/solicitudes/'.$archivoNombre)){
                
                $ruta = utf8_decode('archivos/solicitudes/'.$archivoNombre);
                
                ///////// consultamos la tabla y extraemos el nombre
		        $mysqli->query("INSERT INTO solicitudDocumentos ( quienSolicita, tipoSolicitud, tipoDocumento, encargadoAprobar, nombreDocumento, nombreDocumento2, proceso, solicitud,fecha,documento,plataformaH)
                VALUES ('$usuario','$tipoSolicitud','$tipoDoc','$encargado','$nombre','$nombre','$proceso','$solicitud','$fecha','$ruta','1')")or die(mysqli_error($mysqli));

                //echo '<script language="javascript">alert("Agregado con Exito");
                //window.location.href="../../solicitudDocumentos"</script>';
                ?>
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformulario"].submit();
                         }
                    </script>
                     
                    <form name="miformulario" action="../../solicitudDocumentos" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="validacionAgregar" value="1">
                    </form> 
                <?php
                
            }else{
                
                //echo '<script language="javascript">alert("no se pudo cargar el archivo con Exito");
                //window.location.href="../../solicitudDocumentos"</script>';
                ?>
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformulario"].submit();
                         }
                    </script>
                     
                    <form name="miformulario" action="../../solicitudDocumentos" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="validacionExiste" value="1">
                    </form> 
                <?php
            }
        }
        
    }else{
        if(move_uploaded_file($guardado, '../../archivos/solicitudes/'.$archivoNombre)){
                $ruta = utf8_decode('archivos/solicitudes/'.$archivoNombre);
                ///////// consultamos la tabla y extraemos el nombre
        		$mysqli->query("INSERT INTO solicitudDocumentos ( quienSolicita, tipoSolicitud, tipoDocumento, encargadoAprobar, nombreDocumento,nombreDocumento2, proceso, solicitud,fecha,documento,plataformaH)
                VALUES ('$usuario','$tipoSolicitud','$tipoDoc','$encargado','$nombre','$nombre','$proceso','$solicitud','$fecha','$ruta','1')")or die(mysqli_error($mysqli));

                //echo '<script language="javascript">alert("Agregado con Exito");
                //window.location.href="../../solicitudDocumentos"</script>';
                ?>
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformulario"].submit();
                         }
                    </script>
                     
                    <form name="miformulario" action="../../solicitudDocumentos" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="validacionAgregar" value="1">
                    </form> 
                <?php
            }else{
                //echo '<script language="javascript">alert("-");
                //window.location.href="../../solicitudDocumentos"</script>';
                ?>
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformulario"].submit();
                         }
                    </script>
                     
                    <form name="miformulario" action="../../solicitudDocumentos" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="validacionExiste" value="1">
                    </form> 
                <?php
            }
        
    }
	////////////////////////////////////
  
 
    
    

    
}if(isset($_POST['agregarSolicitud2'])){  
///agrega solicitud cuando el documento a crear es nuevo
    $tipoSolicitud = $_POST['tipoSolicitud'];
    $usuario = $_POST['usuario'];
    $proceso = $_POST['proceso'];
    $tipoDoc = $_POST['tipoDoc'];
    $idDocumento = $_POST['idDocumento'];//id del documento a actualizar o eliminar
    $encargado = $_POST['encargado'];
    $solicitud = utf8_decode($_POST['solicitud']);
    $fecha = date("Y:m:j");
    
    ///// para traer el nombre y enviarlo al correo
                    $nombreDocumentoCorreo = $mysqli->query("SELECT * FROM documento WHERE id ='$idDocumento' ")or die(mysqli_error());
                    $nombreDocumentoCorreoData = $nombreDocumentoCorreo->fetch_array(MYSQLI_ASSOC);
                    $nombre = $nombreDocumentoCorreoData['nombres'];//nombre del documento a crear
                    $nombreEnviarCorreo = utf8_encode($nombreDocumentoCorreoData['nombres']);//nombre del documento a crear
    //// fin
    
    
    $nombreEnviar=utf8_encode($nombre); // enviar a los correos   

        
        	////////////////////////////////////
	$archivoNombre = $_FILES['archivo']['name'];
    $guardado = $_FILES['archivo']['tmp_name'];
    
    
    if($tipoSolicitud == 2){
        $nombreTipoSolicitud='actualización';
    }
    
    if($tipoSolicitud == 3){
        $nombreTipoSolicitud='eliminación';
    }
    

    require '../../correoEnviar/libreria/PHPMailerAutoload.php';
    $extraerUsuarios = $mysqli->query("SELECT * FROM usuario WHERE cargo ='$encargado' ")or die(mysqli_error());
    //$usuariosCargo = $extraerUsuarios->fetch_array(MYSQLI_ASSOC);
    while($usuariosCargo = $extraerUsuarios->fetch_array()){
     'EL USUARIO: <b>'.$nombredelUsuario=utf8_encode($usuariosCargo['nombres'].' '.$usuariosCargo['apellidos']);
      ' tiene el id cargo: '.$usuariosCargo['cargo'].'</b>';
      $consultaCedula=$usuariosCargo['cedula'];
      $correoNotificar=$usuariosCargo['correo'];
  
  
          $consultandoGrupos=$mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario='$consultaCedula' ");
          while($extraerGruposDistribucion=$consultandoGrupos->fetch_array()){
          $extraerGruposDistribucion['id'];
          // subconsulta permisos
          $consultandoGruposSubconsulta=$mysqli->query("SELECT * FROM grupo WHERE id='".$extraerGruposDistribucion['idGrupo']."' ");
          $extraerGruposDistribucionSubconsulta=$consultandoGruposSubconsulta->fetch_array(MYSQLI_ASSOC);
          $sumandoPermisos+=$extraerGruposDistribucionSubconsulta['correo']; 
          // end
          }
  
          ///// validamos si tiene permiso autorizado para el envio de correos
          if($sumandoPermisos >= '1'){
            //  echo 'Tiene permiso<br>';
             
              //ignore_user_abort(1);
              //set_time_limit(0); 
            
              
              //Create a new PHPMailer instance
              $mail = new PHPMailer();
              $mail->IsSMTP();
              
              //Configuracion servidor mail
              ;
              require '../../correoEnviar/contenido.php';
             
              //Agregar destinatario
              $mail->isHTML(true);
              $mail->AddAddress($correoNotificar);
               '-Enviar: '.$correoNotificar;
              /// end
          
              $nombreDocumentoEnviarCorreo=$nombre;
              $solicitudDocumentoEnviarcorreo=$_POST['solicitud'];
  
              
              if($tipoSolicitud == '2'){
                  $tipoSolicitudNombre='actualización';
              }
              if($tipoSolicitud == '3'){
                  $tipoSolicitudNombre='eliminación';
              }
  
              $mail->Subject='Solicitud de documento';
              $mail->Body = utf8_decode('
              <html>
              <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
              <title>HTML</title>
              </head>
              <body>
              <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
              
              <p>Estimado (a). <b><em>'.$nombredelUsuario.'</em></b>.
              <br>
              <p><b>Proceda a la '.$tipoSolicitudNombre.' del documento '.$nombreEnviarCorreo.' y ejecutar la solicitud '.$solicitudDocumentoEnviarcorreo.', que se le ha asignado.</b></p>
              
              <br><br>
              Se recomienda ingresar y verificar su solicitud.
              <br><br>
              Este correo es informativo y por tanto, le pedimos no responda este mensaje.
              </p>
              </body>
              </html>
              ');
          
              //Avisar si fue enviado o no y dirigir al index
              if ($mail->Send()) {
                  //echo'<script type="text/javascript">
                  //    alert("Enviado Correctamente");
                  //    </script>';
                  
              } else {
                  //echo'<script type="text/javascript">
                  //    alert("NO ENVIADO, intentar de nuevo");
                  //    </script>';
              }
              $mail->ClearAddresses();  
              
              //// end
  
  
          }else{
          // echo 'No tiene permiso';
          }
          /// end
  
  
  
    }
    
    
    
    
    if($archivoNombre == NULL && $guardado == NULL){
        
        $ruta = 'sin datos';
        
       $mysqli->query("INSERT INTO solicitudDocumentos ( quienSolicita, tipoSolicitud, tipoDocumento, encargadoAprobar, nombreDocumento, nombreDocumento2, proceso, solicitud,fecha,documento,plataformaH)
                VALUES ('$usuario','$tipoSolicitud','$tipoDoc','$encargado','$idDocumento','$nombre','$proceso','$solicitud','$fecha','$ruta','1')")or die(mysqli_error($mysqli));

                //echo '<script language="javascript">alert("Agregado con Exito");
                //window.location.href="../../solicitudDocumentos"</script>';
                ?>
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformulario"].submit();
                         }
                    </script>
                     
                    <form name="miformulario" action="../../solicitudDocumentos" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="validacionAgregar" value="1">
                    </form> 
                <?php
        
    }
   
    if(!file_exists('../../archivos/solicitudes')){
        mkdir('../../archivos/solicitudes',0777,true);
        if(file_exists('../../archivos/solicitudes')){
            if(move_uploaded_file($guardado, '../../archivos/solicitudes/'.$archivoNombre)){
                $ruta = utf8_decode('archivos/solicitudes/'.$archivoNombre);
                
                ///////// consultamos la tabla y extraemos el nombre
		        $mysqli->query("INSERT INTO solicitudDocumentos ( quienSolicita, tipoSolicitud, tipoDocumento, encargadoAprobar, nombreDocumento, nombreDocumento2, proceso, solicitud,fecha,documento,plataformaH)
                VALUES ('$usuario','$tipoSolicitud','$tipoDoc','$encargado','$idDocumento','$nombre','$proceso','$solicitud','$fecha','$ruta','1')")or die(mysqli_error($mysqli));

                //echo '<script language="javascript">alert("Agregado con Exito");
                //window.location.href="../../solicitudDocumentos"</script>';
                ?>
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformulario"].submit();
                         }
                    </script>
                     
                    <form name="miformulario" action="../../solicitudDocumentos" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="validacionAgregar" value="1">
                    </form> 
                <?php
                
            }else{
                
                //echo '<script language="javascript">alert("no se pudo cargar el archivo con Exito");
                //window.location.href="../../solicitudDocumentos"</script>';
                ?>
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformulario"].submit();
                         }
                    </script>
                     
                    <form name="miformulario" action="../../solicitudDocumentos" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="validacionExiste" value="1">
                    </form> 
                <?php
            }
        }
        
    }else{
        if(move_uploaded_file($guardado, '../../archivos/solicitudes/'.$archivoNombre)){
            
            $ruta = utf8_decode('archivos/solicitudes/'.$archivoNombre);
                ///////// consultamos la tabla y extraemos el nombre
        	$mysqli->query("INSERT INTO solicitudDocumentos ( quienSolicita, tipoSolicitud, tipoDocumento, encargadoAprobar, nombreDocumento,nombreDocumento2, proceso, solicitud,fecha,documento,plataformaH)
            VALUES ('$usuario','$tipoSolicitud','$tipoDoc','$encargado','$idDocumento','$nombre','$proceso','$solicitud','$fecha','$ruta','1')")or die(mysqli_error($mysqli));

            //echo '<script language="javascript">alert("Agregado con Exito");
            //window.location.href="../../solicitudDocumentos"</script>';
                ?>
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformulario"].submit();
                         }
                    </script>
                     
                    <form name="miformulario" action="../../solicitudDocumentos" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="validacionAgregar" value="1">
                    </form> 
                <?php
            }else{
                //echo '<script language="javascript">alert("+");
                //window.location.href="../../solicitudDocumentos"</script>';
                 ?>
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformulario"].submit();
                         }
                    </script>
                     
                    <form name="miformulario" action="../../solicitudDocumentos" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="validacionExiste" value="1">
                    </form> 
                <?php
            }
        
    }
	////////////////////////////////////
   
    

   
    
    
}

if(isset($_POST['editarTipo'])){
       
       $id = $_POST['idTipo'];
       $nombre = utf8_decode($_POST['nombre']);//nombre del documento a crear
       $prefijo = $_POST['prefijo'];
       $descripcion = $_POST['descripcion'];
        
    $validacion2 = $mysqli->query("SELECT * FROM tipoDocumento WHERE nombre = '$nombre' AND NOT id = '$id' ");
    $numRows2 = mysqli_num_rows($validacion2);
    
    if($numRows2 > 0){
        
    echo '<script language="javascript">alert("ese nombre ya esta en uso.");
    window.location.href="../../tipoDocumento"</script>';
    
    }else{
       $mysqli->query("UPDATE tipoDocumento SET  nombre='$nombre', prefijo='$prefijo', descripcion='$descripcion' WHERE id = '$id'");
   
   //Editar de tipoDoc
   
   echo '<script language="javascript">alert("Actualizado con exito.");
   window.location.href="../../tipoDocumento"</script>';
    }
}

if(isset($_POST['eliminarTipo'])){
    $id = $_POST['idTipo'];
       $mysqli->query("DELETE FROM tipoDocumento WHERE id = '$id'");
   
   //eliminar de tipoDoc
   
   echo '<script language="javascript">alert("exito al eliminar.");
   window.location.href="../../tipoDocumento"</script>';
}

if(isset($_POST['seguimiento'])){ 
    
    ///// aseguramos que la persona que hizo la solicitud y se salio pueda volver a ingresar
    $quienElabora = $_POST['quienElabora'];
    /// END
    
    $id = $_POST['id'];
    $accion = $_POST['accion'];
    $dias = $_POST['dias'];
    $comentarios = utf8_decode($_POST['comentarios']);
    $idDocumento = $_POST['idDocumento'];
    $tipoSolicitud = $_POST['tipoSolicitud'];
    $solicitud = $_POST['solicitud'];
    
    $id = $id;
    $solicitud = $solicitud;
    
    if($accion == NULL){
        echo '<script language="javascript">alert("este");
        window.location.href="../../solicitudDocumentos"</script>';
    }
    
    if($accion == 'Aprobado' && $tipoSolicitud == 1){//Creacion
        
        if($dias != NULL){
            $mysqli->query("UPDATE solicitudDocumentos SET estado ='$accion', tiempoRespuesta = '$dias', QuienAprueba='$quienElabora' WHERE id = '$id'");
        }else{
            $mysqli->query("UPDATE solicitudDocumentos SET estado ='$accion', QuienAprueba='$quienElabora' WHERE id = '$id'");
        }
        
        $mysqli->query("INSERT INTO comentarioSolicitud (idSolicitud,comentario) VALUES ('$id','$comentarios')");
        
        
        ?>
                <script> 
                     window.onload=function(){
                   
                         document.forms["miformulario"].submit();
                         //alert("Proceda a asignar elaborador, revisor y aprobador.");
                     }
                </script>
                 
                <form name="miformulario" action="../../crearDocumento" method="POST" onsubmit="procesar(this.action);" >
                    <input type="hidden" name="validacionAgregar" value="1">
                    <input type="hidden" name="idSolicitud" value="<?php echo $id; ?>">
                    <input type="hidden" name="solicitud" value="<?php echo $solicitud; ?>">
                </form> 
        <?php 
        /*
        echo '<script language="javascript">alert("Agregado con Exito");
        window.location.href="../../solicitudDocumentos"</script>';*/
    }

    
    if($accion == 'Rechazado' && $tipoSolicitud == 2){
        
        $fecha = date("Y:m:j");
        $mysqli->query("UPDATE documento SET ultimaFechaRevision = '$fecha', usuarioRevisa = NULL, revisado = 0 WHERE id='$idDocumento'");
        
    }
    
    
    if($accion == 'Aprobado' && $tipoSolicitud == 2){//Actualizacion
        
                    
        $datosQueryIdAnt = $mysqli->query("SELECT idAnterior FROM documento WHERE idAnterior = '$idDocumento'");
          
        if(mysqli_num_rows($datosQueryIdAnt)<=0){
            
            //ESTE INSERT LARGO ME COPIA EL DOCUMENTO QUE SE VA A ACTUALIZAR PARA NO ALTERAR EL ORIGINAL
            $copiaDocumento = $mysqli->query("INSERT INTO `documento`(`codificacion`,`tipoCodificacion`, `consecutivo`,`version`, `nombres`, `proceso`, `nombreProceso`, `norma`, `metodo`, `tipo_documento`, `htmlDoc`, `ubicacion`, `elabora`, `revisa`, `aprueba`, `documento_externo`, `definiciones`, `archivo_gestion`, `archivo_central`, `archivo_historico`, `disposicion_documental`, `responsable_disposicion`, `aprovacion_registro`, `usuario_aprovacion_reg`, `aprobado_elabora`, `aprobado_revisa`, `aprobado_elabora_e`, `aprobado_revisa_e`, `aprobado_aprueba_e`, `estado`, `control_cambios`, `flujo`, `mesesRevision`, `obsoleto`, `id_solicitud`, `estadoCreado`, `usuarioElabora`, `usuarioRevisa`, `usuarioAprueba`, `idAnterior`, `plataformaH`, `plataformaHRevisa`, `plataformaHAprueba`) SELECT `codificacion`,`tipoCodificacion`,`consecutivo`, `version`, `nombres`, `proceso`, `nombreProceso`, `norma`, `metodo`, `tipo_documento`, `htmlDoc`, `ubicacion`, `elabora`, `revisa`, `aprueba`, `documento_externo`, `definiciones`, `archivo_gestion`, `archivo_central`, `archivo_historico`, `disposicion_documental`, `responsable_disposicion`, `aprovacion_registro`, `usuario_aprovacion_reg`, `aprobado_elabora`, `aprobado_revisa`, `aprobado_elabora_e`, `aprobado_revisa_e`, `aprobado_aprueba_e`, `estado`, `control_cambios`, `flujo`, `mesesRevision`, `obsoleto`, `id_solicitud`, `estadoCreado`, `usuarioElabora`, `usuarioRevisa`, `usuarioAprueba`, `idAnterior`, `plataformaH`, `plataformaHRevisa`, `plataformaHAprueba` FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));

            if($copiaDocumento){
            
                if($comentarios != NULL){
                    $mysqli->query("INSERT INTO comentarioSolicitud (idSolicitud,comentario) VALUES ('$id','$comentarios')");
                }
                
                $datosQuery = $mysqli->query("SELECT usuarioElabora FROM documento WHERE id = '$idDocumento'");
                $datosusuarioElabora = $datosQuery->fetch_array(MYSQLI_ASSOC);
                $usuarioElabora = $datosusuarioElabora['usuarioElabora'];
                    
                //VOY A EXTRAER EL ULRIMO ID DE LA TABLA DOCUMENTOS PARA ACTULIZAR EN LA SOLICITUD EL DOCUMENTO A ACTUALIZAR.
                $queryId = $mysqli->query("SELECT MAX(id) AS id FROM `documento` WHERE usuarioElabora = '$usuarioElabora' ORDER BY id DESC");
                $datos = $queryId->fetch_array(MYSQLI_ASSOC);
                $idNuevo = $datos['id'];
                $idNuevo = $idNuevo;
                
                //Relaciono el documento nuevo con la solicitud
                $mysqli->query("UPDATE documento SET id_solicitud = '$id', idAnterior='$idDocumento' WHERE id = $idNuevo");
                
                if($dias != NULL){
                    $mysqli->query("UPDATE solicitudDocumentos SET estado ='$accion', nombreDocumento = '$idNuevo', tiempoRespuesta = '$dias', QuienAprueba='$quienElabora' WHERE id = $id"); 
                }else{
                    $mysqli->query("UPDATE solicitudDocumentos SET estado ='$accion', nombreDocumento = '$idNuevo', QuienAprueba='$quienElabora' WHERE id = $id");
                }
                
                
                ?>
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformulario"].submit();
                             //alert("Proceda a asignar elaborador, revisor y aprobador.");
                         }
                    </script>
                     
                    <form name="miformulario" action="../../actualizarDoc" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="validacionAgregar" value="1">
                        <input type="hidden" name="idSolicitud" value="<?php echo $id; ?>">
                        <input type="hidden" name="solicitud" value="<?php echo $solicitud; ?>">
                        <input type="hidden" name="idDoc" value="<?php echo $idNuevo; ?>">
                    </form> 
                <?php
                
                /*echo '<script language="javascript">alert("Agregado con Exito");
                window.location.href="../../solicitudDocumentos"</script>';*/
            
            }        
            
            
        }else{
            
                $datosQuery = $mysqli->query("SELECT usuarioElabora FROM documento WHERE id = '$idDocumento'");
                $datosusuarioElabora = $datosQuery->fetch_array(MYSQLI_ASSOC);
                $usuarioElabora = $datosusuarioElabora['usuarioElabora'];
                    
                //VOY A EXTRAER EL ULRIMO ID DE LA TABLA DOCUMENTOS PARA ACTULIZAR EN LA SOLICITUD EL DOCUMENTO A ACTUALIZAR.
                $queryId = $mysqli->query("SELECT MAX(id) AS id FROM `documento` WHERE usuarioElabora = '$usuarioElabora' ORDER BY id DESC");
                $datos = $queryId->fetch_array(MYSQLI_ASSOC);
                $idNuevo = $datos['id'];
            
                ?>
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformulario"].submit();
                             //alert("Proceda a asignar elaborador, revisor y aprobador.");
                         }
                    </script>
                     
                    <form name="miformulario" action="../../actualizarDoc" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="validacionAgregar" value="1">
                        <input type="hidden" name="idSolicitud" value="<?php echo $id; ?>">
                        <input type="hidden" name="solicitud" value="<?php echo $solicitud; ?>">
                        <input type="hidden" name="idDoc" value="<?php echo $idNuevo; ?>">
                    </form> 
                <?php
            
        }
        
        
        /*if(!$copiaDocumento){
            
            $datosQueryIdAnt = $mysqli->query("SELECT idAnterior FROM documento WHERE idAnterior = '$idDocumento'");
            
            if(mysqli_num_rows($datosQueryIdAnt)>0){
            
                ?>
                        <script> 
                             window.onload=function(){
                           
                                 document.forms["miformulario"].submit();
                                 //alert("Proceda a asignar elaborador, revisor y aprobador.");
                             }
                        </script>
                         
                        <form name="miformulario" action="../../actualizarDoc.php" method="POST" onsubmit="procesar(this.action);" >
                            <input type="hidden" name="idSolicitud" value="<?php echo $id; ?>">
                            <input type="hidden" name="solicitud" value="<?php echo $solicitud; ?>">
                            <input type="hidden" name="idDoc" value="<?php echo $idNuevo; ?>">
                        </form> 
                    <?php
                
            }
                
            /*echo '<script language="javascript">alert("Ocurrio un error, intententelo de nuevo.");
            window.location.href="../../solicitudDocumentos"</script>';
        }    */
            
        
        
    }
    
    if($accion == 'Aprobado' && $tipoSolicitud == 3){//Eliminacion
        
        $mysqli->query("UPDATE documento SET id_solicitud = '$id' WHERE id = $idDocumento");
        
        if($dias != NULL){
            $mysqli->query("UPDATE solicitudDocumentos SET estado ='$accion', nombreDocumento = '$idDocumento', tiempoRespuesta = '$dias', QuienAprueba='$quienElabora' WHERE id = '$id'");
        }else{
            $mysqli->query("UPDATE solicitudDocumentos SET estado ='$accion', nombreDocumento = '$idDocumento', QuienAprueba='$quienElabora' WHERE id = '$id'");
        }
        
        ?>
                <script> 
                     window.onload=function(){
                   
                         document.forms["miformulario"].submit();
                         //alert("Proceda a asignar elaborador, revisor y aprobador.");
                     }
                </script>
                 
                <form name="miformulario" action="../../eliminarDoc" method="POST" onsubmit="procesar(this.action);" >
                    <input type="hidden" name="validacionAgregar" value="1">
                    <input type="hidden" name="idSolicitud" value="<?php echo $id; ?>">
                    <input type="hidden" name="solicitud" value="<?php echo $solicitud; ?>">
                    <input type="hidden" name="idDocumento" value="<?php echo $idDocumento; ?>">
                </form> 
        <?php
        
        /*echo '<script language="javascript">alert("Agregado con Exito");
        window.location.href="../../solicitudDocumentos"</script>';*/
    }
    
    
    
    if($accion == 'Rechazado' || $accion == 'Pendiente'){
        $fechaCierre = date("Y:m:j");
        
        $mysqli->query("UPDATE solicitudDocumentos SET estado ='$accion', fechaCierre='$fechaCierre', QuienAprueba='$quienElabora' WHERE id = '$id'");
        $mysqli->query("INSERT INTO comentarioSolicitud (idSolicitud,comentario) VALUES ('$id','$comentarios')");
        //echo '<script language="javascript">alert("Agregado con Exito");
        //window.location.href="../../solicitudDocumentos"</script>';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../solicitudDocumentos" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionAgregar" value="1">
            </form> 
        <?php
    }
    
}



//////// seguimiento para cuando se carga los datos para un documento que es cargado
if(isset($_POST['seguimientoSolicitudDocumentoCargado'])){
    
    ///// aseguramos que la persona que hizo la solicitud y se salio pueda volver a ingresar
    $quienElabora = $_POST['quienElabora'];
    /// END
    
    $id = $_POST['id'];
    $accion = $_POST['accion'];
    $dias = $_POST['dias'];
    $comentarios = utf8_decode($_POST['comentarios']);
    $idDocumento = $_POST['idDocumento'];
    $tipoSolicitud = $_POST['tipoSolicitud'];
    $solicitud = $_POST['solicitud'];
    
    $id = $id;
    $solicitud = $solicitud;
    
    if($accion == NULL){
        echo '<script language="javascript">alert("este");
        window.location.href="../../solicitudDocumentos"</script>';
    }
    
    if($accion == 'Aprobado' && $tipoSolicitud == 1){//Creacion
        
        if($dias != NULL){
            $mysqli->query("UPDATE solicitudDocumentos SET estado ='$accion', tiempoRespuesta = '$dias', QuienAprueba='$quienElabora' WHERE id = '$id'");
        }else{
            $mysqli->query("UPDATE solicitudDocumentos SET estado ='$accion', QuienAprueba='$quienElabora' WHERE id = '$id'");
        }
        
        $mysqli->query("INSERT INTO comentarioSolicitud (idSolicitud,comentario) VALUES ('$id','$comentarios')");
        
        
        ?>
                <script> 
                     window.onload=function(){
                   
                         document.forms["miformulario"].submit();
                         //alert("Proceda a asignar elaborador, revisor y aprobador.");
                     }
                </script>
                 
                <form name="miformulario" action="../../crearDocumentoB" method="POST" onsubmit="procesar(this.action);" >
                    <input type="hidden" name="validacionAgregar" value="1">
                    <input type="hidden" name="idSolicitud" value="<?php echo $id; ?>">
                    <input type="hidden" name="solicitud" value="<?php echo $solicitud; ?>">
                </form> 
        <?php 
        /*
        echo '<script language="javascript">alert("Agregado con Exito");
        window.location.href="../../solicitudDocumentos"</script>';*/
    }

    
    if($accion == 'Rechazado' && $tipoSolicitud == 2){
        
        $fecha = date("Y:m:j");
        $mysqli->query("UPDATE documento SET ultimaFechaRevision = '$fecha', usuarioRevisa = NULL, revisado = 0 WHERE id='$idDocumento'");
        
    }
    
    
    if($accion == 'Aprobado' && $tipoSolicitud == 2){//Actualizacion
        
                    
        $datosQueryIdAnt = $mysqli->query("SELECT idAnterior FROM documento WHERE idAnterior = '$idDocumento'");
          
        if(mysqli_num_rows($datosQueryIdAnt)<=0){
            
            //ESTE INSERT LARGO ME COPIA EL DOCUMENTO QUE SE VA A ACTUALIZAR PARA NO ALTERAR EL ORIGINAL
            $copiaDocumento = $mysqli->query("INSERT INTO `documento`(`codificacion`,`tipoCodificacion`, `consecutivo`,`version`, `nombres`, `proceso`, `nombreProceso`, `norma`, `metodo`, `tipo_documento`, `htmlDoc`, `ubicacion`, `elabora`, `revisa`, `aprueba`, `documento_externo`, `definiciones`, `archivo_gestion`, `archivo_central`, `archivo_historico`, `disposicion_documental`, `responsable_disposicion`, `aprovacion_registro`, `usuario_aprovacion_reg`, `aprobado_elabora`, `aprobado_revisa`, `aprobado_elabora_e`, `aprobado_revisa_e`, `aprobado_aprueba_e`, `estado`, `control_cambios`, `flujo`, `mesesRevision`, `obsoleto`, `id_solicitud`, `estadoCreado`, `usuarioElabora`, `usuarioRevisa`, `usuarioAprueba`, `idAnterior`, `plataformaH`, `plataformaHRevisa`, `plataformaHAprueba`) SELECT `codificacion`,`tipoCodificacion`,`consecutivo`, `version`, `nombres`, `proceso`, `nombreProceso`, `norma`, `metodo`, `tipo_documento`, `htmlDoc`, `ubicacion`, `elabora`, `revisa`, `aprueba`, `documento_externo`, `definiciones`, `archivo_gestion`, `archivo_central`, `archivo_historico`, `disposicion_documental`, `responsable_disposicion`, `aprovacion_registro`, `usuario_aprovacion_reg`, `aprobado_elabora`, `aprobado_revisa`, `aprobado_elabora_e`, `aprobado_revisa_e`, `aprobado_aprueba_e`, `estado`, `control_cambios`, `flujo`, `mesesRevision`, `obsoleto`, `id_solicitud`, `estadoCreado`, `usuarioElabora`, `usuarioRevisa`, `usuarioAprueba`, `idAnterior`, `plataformaH`, `plataformaHRevisa`, `plataformaHAprueba` FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));

            if($copiaDocumento){
            
                if($comentarios != NULL){
                    $mysqli->query("INSERT INTO comentarioSolicitud (idSolicitud,comentario) VALUES ('$id','$comentarios')");
                }
                
                $datosQuery = $mysqli->query("SELECT usuarioElabora FROM documento WHERE id = '$idDocumento'");
                $datosusuarioElabora = $datosQuery->fetch_array(MYSQLI_ASSOC);
                $usuarioElabora = $datosusuarioElabora['usuarioElabora'];
                    
                //VOY A EXTRAER EL ULRIMO ID DE LA TABLA DOCUMENTOS PARA ACTULIZAR EN LA SOLICITUD EL DOCUMENTO A ACTUALIZAR.
                $queryId = $mysqli->query("SELECT MAX(id) AS id FROM `documento` WHERE usuarioElabora = '$usuarioElabora' ORDER BY id DESC");
                $datos = $queryId->fetch_array(MYSQLI_ASSOC);
                $idNuevo = $datos['id'];
                $idNuevo = $idNuevo;
                
                //Relaciono el documento nuevo con la solicitud
                $mysqli->query("UPDATE documento SET id_solicitud = '$id', idAnterior='$idDocumento' WHERE id = $idNuevo");
                
                if($dias != NULL){
                    $mysqli->query("UPDATE solicitudDocumentos SET estado ='$accion', nombreDocumento = '$idNuevo', tiempoRespuesta = '$dias', QuienAprueba='$quienElabora' WHERE id = $id"); 
                }else{
                    $mysqli->query("UPDATE solicitudDocumentos SET estado ='$accion', nombreDocumento = '$idNuevo', QuienAprueba='$quienElabora' WHERE id = $id");
                }
                
                
                ?>
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformulario"].submit();
                             //alert("Proceda a asignar elaborador, revisor y aprobador.");
                         }
                    </script>
                     
                    <form name="miformulario" action="../../actualizarDoc" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="validacionAgregar" value="1">
                        <input type="hidden" name="idSolicitud" value="<?php echo $id; ?>">
                        <input type="hidden" name="solicitud" value="<?php echo $solicitud; ?>">
                        <input type="hidden" name="idDoc" value="<?php echo $idNuevo; ?>">
                    </form> 
                <?php
                
                /*echo '<script language="javascript">alert("Agregado con Exito");
                window.location.href="../../solicitudDocumentos"</script>';*/
            
            }        
            
            
        }else{
            
                $datosQuery = $mysqli->query("SELECT usuarioElabora FROM documento WHERE id = '$idDocumento'");
                $datosusuarioElabora = $datosQuery->fetch_array(MYSQLI_ASSOC);
                $usuarioElabora = $datosusuarioElabora['usuarioElabora'];
                    
                //VOY A EXTRAER EL ULRIMO ID DE LA TABLA DOCUMENTOS PARA ACTULIZAR EN LA SOLICITUD EL DOCUMENTO A ACTUALIZAR.
                $queryId = $mysqli->query("SELECT MAX(id) AS id FROM `documento` WHERE usuarioElabora = '$usuarioElabora' ORDER BY id DESC");
                $datos = $queryId->fetch_array(MYSQLI_ASSOC);
                $idNuevo = $datos['id'];
            
                ?>
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformulario"].submit();
                             //alert("Proceda a asignar elaborador, revisor y aprobador.");
                         }
                    </script>
                     
                    <form name="miformulario" action="../../actualizarDoc" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="validacionAgregar" value="1">
                        <input type="hidden" name="idSolicitud" value="<?php echo $id; ?>">
                        <input type="hidden" name="solicitud" value="<?php echo $solicitud; ?>">
                        <input type="hidden" name="idDoc" value="<?php echo $idNuevo; ?>">
                    </form> 
                <?php
            
        }
        
        
        /*if(!$copiaDocumento){
            
            $datosQueryIdAnt = $mysqli->query("SELECT idAnterior FROM documento WHERE idAnterior = '$idDocumento'");
            
            if(mysqli_num_rows($datosQueryIdAnt)>0){
            
                ?>
                        <script> 
                             window.onload=function(){
                           
                                 document.forms["miformulario"].submit();
                                 //alert("Proceda a asignar elaborador, revisor y aprobador.");
                             }
                        </script>
                         
                        <form name="miformulario" action="../../actualizarDoc.php" method="POST" onsubmit="procesar(this.action);" >
                            <input type="hidden" name="idSolicitud" value="<?php echo $id; ?>">
                            <input type="hidden" name="solicitud" value="<?php echo $solicitud; ?>">
                            <input type="hidden" name="idDoc" value="<?php echo $idNuevo; ?>">
                        </form> 
                    <?php
                
            }
                
            /*echo '<script language="javascript">alert("Ocurrio un error, intententelo de nuevo.");
            window.location.href="../../solicitudDocumentos"</script>';
        }    */
            
        
        
    }
    
    if($accion == 'Aprobado' && $tipoSolicitud == 3){//Eliminacion
        
        $mysqli->query("UPDATE documento SET id_solicitud = '$id' WHERE id = $idDocumento");
        
        if($dias != NULL){
            $mysqli->query("UPDATE solicitudDocumentos SET estado ='$accion', nombreDocumento = '$idDocumento', tiempoRespuesta = '$dias', QuienAprueba='$quienElabora' WHERE id = '$id'");
        }else{
            $mysqli->query("UPDATE solicitudDocumentos SET estado ='$accion', nombreDocumento = '$idDocumento', QuienAprueba='$quienElabora' WHERE id = '$id'");
        }
        
        ?>
                <script> 
                     window.onload=function(){
                   
                         document.forms["miformulario"].submit();
                         //alert("Proceda a asignar elaborador, revisor y aprobador.");
                     }
                </script>
                 
                <form name="miformulario" action="../../eliminarDoc" method="POST" onsubmit="procesar(this.action);" >
                    <input type="hidden" name="validacionAgregar" value="1">
                    <input type="hidden" name="idSolicitud" value="<?php echo $id; ?>">
                    <input type="hidden" name="solicitud" value="<?php echo $solicitud; ?>">
                    <input type="hidden" name="idDocumento" value="<?php echo $idDocumento; ?>">
                </form> 
        <?php
        
        /*echo '<script language="javascript">alert("Agregado con Exito");
        window.location.href="../../solicitudDocumentos"</script>';*/
    }
    
    
    
    if($accion == 'Rechazado' || $accion == 'Pendiente'){
        $fechaCierre = date("Y:m:j");
        
        $mysqli->query("UPDATE solicitudDocumentos SET estado ='$accion', fechaCierre='$fechaCierre', QuienAprueba='$quienElabora' WHERE id = '$id'");
        $mysqli->query("INSERT INTO comentarioSolicitud (idSolicitud,comentario) VALUES ('$id','$comentarios')");
        //echo '<script language="javascript">alert("Agregado con Exito");
        //window.location.href="../../solicitudDocumentos"</script>';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../solicitudDocumentos" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionAgregar" value="1">
            </form> 
        <?php
    }
    
}
?>