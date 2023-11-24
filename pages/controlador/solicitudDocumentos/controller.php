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
    

    $nombreTipoDocumento = $mysqli->query("SELECT * FROM tipoDocumento WHERE id ='$tipoDoc' ")or die(mysqli_error());
    $col3TipoDcumento = $nombreTipoDocumento->fetch_array(MYSQLI_ASSOC);
    $nombreTipoDOcumentoN=$col3TipoDcumento['nombre'];
  
    $nombreProceso = $mysqli->query("SELECT * FROM procesos WHERE id ='$proceso'")or die(mysqli_error());
    $col3 = $nombreProceso->fetch_array(MYSQLI_ASSOC);
    $nombreP = $col3['nombre'];

   
   
   /// volvemos el texto totalmente en minuscula
                    $validandoDocumentoCaracteres=mb_strtolower($archivoNombre);
    
                    $activarAlerta=TRUE;
                    $permitidosNombre = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ0123456789-_,.() ";
                    for ($i=0; $i<strlen($validandoDocumentoCaracteres); $i++){
                        if (strpos($permitidosNombre, substr($validandoDocumentoCaracteres,$i,1))===false){
                            $validandoDocumentoCaracteres . " no es válido<br>";
                            $activarAlerta=FALSE;
                            //return false;
                        }
                    }
                    /*$descripcion_carecteres=["'"];
                    for($bc=0; $bc<count($descripcion_carecteres); $bc++){
                        $descripcion_carecteres[$bc]; 
                         $cadena_carecteres_descripcion = $descripcion_carecteres[$bc];
                         ' - '.$coincidencia_caracteres= strpos($validandoDocumentoCaracteres, $cadena_carecteres_descripcion);
                        if($coincidencia_caracteres != NULL){
                            $activarAlerta=FALSE;
                        }    
                    }*/
    
                    
                    if($activarAlerta == FALSE){
                    	$mysqli->query("INSERT INTO solicitudDocumentos ( quienSolicita, tipoSolicitud, tipoDocumento, encargadoAprobar, nombreDocumento,nombreDocumento2, proceso, solicitud,fecha,plataformaH,tpdG,procesoG,alerta)
                        VALUES ('$usuario','$tipoSolicitud','$tipoDoc','$encargado','$nombre','$nombre','$proceso','$solicitud','$fecha','1','$nombreTipoDOcumentoN','$nombreP','1')")or die(mysqli_error($mysqli));
                    }
        
                    $verificandoDocumento = $mysqli->query("SELECT MAX(id) as documentoSolicitud FROM solicitudDocumentos WHERE quienSolicita = '$usuario'")or die(mysqli_error($mysqli));
                    $extraerVerificacionDocumento=$verificandoDocumento->fetch_array(MYSQLI_ASSOC);
                    
                        if($activarAlerta == FALSE){
                            //////////////////////// recibir los post para recuperar la información de los datos previamente almacenado
                             ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                            document.forms["miformularioRetorno"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformularioRetorno" action="../../agregarSolicitud" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="retorno" value="1">
                                        <input type="hidden" name="idRetorno" value="<?php echo $extraerVerificacionDocumento['documentoSolicitud']; ?>">
                                    </form> 
                                <?php
                        }else{
   
    
        if($archivoNombre == NULL && $guardado == NULL){
            
            $ruta = 'sin datos';
            
            $mysqli->query("INSERT INTO solicitudDocumentos ( quienSolicita, tipoSolicitud, tipoDocumento, encargadoAprobar, nombreDocumento, nombreDocumento2, proceso, solicitud,fecha,documento,plataformaH,tpdG,procesoG,alerta)
                    VALUES ('$usuario','$tipoSolicitud','$tipoDoc','$encargado','$nombre','$nombre','$proceso','$solicitud','$fecha','$ruta','1','$nombreTipoDOcumentoN','$nombreP','1')")or die(mysqli_error($mysqli));
    
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
                                      
                                          $nombreDocumentoEnviarCorreo=$_POST['nombre'];
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
                                          <p><b>Ha sido asignado para aprobar la solicitud de '.$tipoSolicitudNombre.' del documento '.$nombreDocumentoEnviarCorreo.'.</b></p>
                                          
                                          <br><br>
                                          Se recomienda ingresar y verificar su solicitud.
                                          <br><br>
                                          Este correo es informativo por tanto, le pedimos no responda este mensaje.
                                          </p>
                                          </body>
                                          </html>
                                          ');
                                      //y ejecutar la solicitud '.$solicitudDocumentoEnviarcorreo.', que se le ha asignado
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
                              
                                }
                              
                              
                              
           
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
        
            if(!file_exists('../../archivos/solicitudes')){
                mkdir('../../archivos/solicitudes',0777,true);
                if(file_exists('../../archivos/solicitudes')){
                    if(move_uploaded_file($guardado, '../../archivos/solicitudes/'.$archivoNombre)){
                        
                        $ruta = utf8_decode('archivos/solicitudes/'.$archivoNombre);
                   //echo '1';     
                        ///////// consultamos la tabla y extraemos el nombre
        		       // $mysqli->query("INSERT INTO solicitudDocumentos ( quienSolicita, tipoSolicitud, tipoDocumento, encargadoAprobar, nombreDocumento, nombreDocumento2, proceso, solicitud,fecha,documento,plataformaH)
                        //VALUES ('$usuario','$tipoSolicitud','$tipoDoc','$encargado','$nombre','$nombre','$proceso','$solicitud','$fecha','$ruta','1')")or die(mysqli_error($mysqli));
        
                        ?>
                            <script> 
                                 window.onload=function(){
                               
                                    // document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../solicitudDocumentos" method="POST" onsubmit="procesar(this.action);" >
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
                             
                            <form name="miformulario" action="../../solicitudDocumentos" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionExisteD" value="1">
                            </form> 
                        <?php
                    }
                }
                
            }else{
                if(move_uploaded_file($guardado, '../../archivos/solicitudes/'.$archivoNombre)){
                        $ruta = utf8_decode('archivos/solicitudes/'.$archivoNombre);
                        ///////// consultamos la tabla y extraemos el nombre
                		$mysqli->query("INSERT INTO solicitudDocumentos ( quienSolicita, tipoSolicitud, tipoDocumento, encargadoAprobar, nombreDocumento,nombreDocumento2, proceso, solicitud,fecha,documento,plataformaH,tpdG,procesoG,alerta)
                        VALUES ('$usuario','$tipoSolicitud','$tipoDoc','$encargado','$nombre','$nombre','$proceso','$solicitud','$fecha','$ruta','1','$nombreTipoDOcumentoN','$nombreP','1')")or die(mysqli_error($mysqli));
                //echo '2';
        
        
                    $verificandoDocumento = $mysqli->query("SELECT MAX(id) as documentoSolicitud FROM solicitudDocumentos WHERE quienSolicita = '$usuario'")or die(mysqli_error($mysqli));
                    $extraerVerificacionDocumento=$verificandoDocumento->fetch_array(MYSQLI_ASSOC);
                    
                    $verificandoDocumentoArchivo = $mysqli->query("SELECT *  FROM solicitudDocumentos WHERE id = '".$extraerVerificacionDocumento['documentoSolicitud']."' ")or die(mysqli_error($mysqli));
                    $extraerVerificacionDocumentoArchivo=$verificandoDocumentoArchivo->fetch_array(MYSQLI_ASSOC);
                    
                     $documentoExtraido='../../'.utf8_encode($extraerVerificacionDocumentoArchivo['documento']);
                
                //echo '<br><br>';
                    
                    
                                    //Lista de letras abecedario
                                $carpeta="../../archivos/solicitudes/";
                                $ruta="/".$carpeta."/";
                                $directorio=opendir($carpeta);
                                //recoger los  datos
                                $datos=array();
                                $conteoArchivos=0;
                                while ($archivo = readdir($directorio)) { 
                                  if(($archivo != '.')&&($archivo != '..')){
                                     
                                    if($documentoExtraido == '../../archivos/solicitudes/'.$datos[]=$archivo){
                                        $conteoArchivos++;
                                         '../../archivos/solicitudes/'.$datos[]=$archivo; //echo '<br>';
                                    }
                                     
                                     
                                  } 
                                }
                                closedir($directorio);
                                    
                                if($conteoArchivos > 0){
                                   $documentoHabilitado='1'; 
                                }else{
                                   $documentoHabilitado='no coincide';
                                }
                        
                            
                            if($documentoHabilitado == 1){ /// si el archivo que se sube coincide, la solicitud continua su proceso, en caso contrario no seguirá
                                    
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
                                          
                                              $nombreDocumentoEnviarCorreo=$_POST['nombre'];
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
                                              <p><b>Ha sido asignado para aprobar la solicitud de '.$tipoSolicitudNombre.' del documento '.$nombreDocumentoEnviarCorreo.'.</b></p>
                                              
                                              <br><br>
                                              Se recomienda ingresar y verificar su solicitud.
                                              <br><br>
                                              Este correo es informativo por tanto, le pedimos no responda este mensaje.
                                              </p>
                                              </body>
                                              </html>
                                              ');
                                          //y ejecutar la solicitud '.$solicitudDocumentoEnviarcorreo.', que se le ha asignado
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
                                  
                                  
                                  
                                  
                                  
                                    }
                                  
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
                                $mysqli->query("UPDATE  solicitudDocumentos SET estado='documento' WHERE id='".$extraerVerificacionDocumento['documentoSolicitud']."' ");
                                //echo 'debe retornar';
                                 ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                            document.forms["miformularioRetorno"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformularioRetorno" action="../../agregarSolicitud" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="retorno" value="1">
                                        <input type="hidden" name="idRetorno" value="<?php echo $extraerVerificacionDocumento['documentoSolicitud']; ?>">
                                    </form> 
                                <?php
                            }
                            
                          
                    }else{
                        ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../solicitudDocumentos" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionExisteD" value="1">
                            </form> 
                        <?php
                    }
                
            }
    	////////////////////////////////////
        }
 
    
 

                        }
    

    
}if(isset($_POST['agregarSolicitud2'])){  
///agrega solicitud cuando el documento a crear es nuevo
     '<br>TS: '.$tipoSolicitud = $_POST['tipoSolicitud'];
    $usuario = $_POST['usuario'];
      '<br>Pro: '.$proceso = $_POST['proceso'];
      '<br>TipDo: '.$tipoDoc = $_POST['tipoDoc'];
       '<br>id Doc: '.$idDocumento = $_POST['idDocumento'];//id del documento a actualizar o eliminar
    $encargado = $_POST['encargado'];
     $solicitud = utf8_decode($_POST['solicitud']);
    $fecha = date("Y:m:j"); 
    
    
    
    // preguntamos si el documento sigue en listado maestro, en caso contrario mandamos una alerta
    $documento_consulta_obsoleto = $mysqli->query("SELECT * FROM documento WHERE id ='$idDocumento' ")or die(mysqli_error());
    $nombdocumento_consulta_obsoleto = $documento_consulta_obsoleto->fetch_array(MYSQLI_ASSOC);
    
    if($nombdocumento_consulta_obsoleto['obsoleto'] == 1){ // si el documento ya está en obsoleto enviamos una alerta del documento
                            ?>
                            <script> 
                                 window.onload=function(){
                             
                                     document.forms["alertaObsoleto"].submit();
                                 }
                            </script>
                             
                            <form name="alertaObsoleto" action="../../agregarSolicitud" method="POST" onsubmit="procesar(this.action);" >
                                <input name="idDocumentoAlerta" value="<?php echo $idDocumento;?>" type="hidden">
                                <input type="hidden" name="alertaDocumentoActuliza" value="1">
                            </form> 
                            <?php
    }else{
        
        $nombreTipoDocumento = $mysqli->query("SELECT * FROM tipoDocumento WHERE id ='$tipoDoc' ")or die(mysqli_error());
        $col3TipoDcumento = $nombreTipoDocumento->fetch_array(MYSQLI_ASSOC);
        $nombreTipoDOcumentoN=$col3TipoDcumento['nombre'];
      
        $nombreProceso = $mysqli->query("SELECT * FROM procesos WHERE id ='$proceso'")or die(mysqli_error());
        $col3 = $nombreProceso->fetch_array(MYSQLI_ASSOC);
        $nombreP = $col3['nombre'];
        
        ///// para traer el nombre y enviarlo al correo
                        $nombreDocumentoCorreo = $mysqli->query("SELECT * FROM documento WHERE id ='$idDocumento' ")or die(mysqli_error());
                        $nombreDocumentoCorreoData = $nombreDocumentoCorreo->fetch_array(MYSQLI_ASSOC);
                        $nombre = $nombreDocumentoCorreoData['nombres'];//nombre del documento a crear
                          '<br>Estado Actualiza: '.$estadoActualizaInformacion = $nombreDocumentoCorreoData['estadoActualiza'];//nombre del documento a crear
                          '<br>estado Elimina: '.$estadoEliminarInformacion = $nombreDocumentoCorreoData['estadoElimina'];//nombre del documento a crear
                         '<br>Flujo: '.$flujoDocumentoEliminar = $nombreDocumentoCorreoData['flujo'];
                          '<br>'.$nombreEnviarCorreo = utf8_encode($nombreDocumentoCorreoData['nombres']);//nombre del documento a crear
                         '<br>id solicitud: '.$idSolicitudValidar = $nombreDocumentoCorreoData['id_solicitud'];
                        
                      
        
        $validamosExistenciaProcesoSolicitud=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE proceso='$proceso' AND tipoDocumento='$tipoDoc'  AND nombreDocumento2='".$nombreDocumentoCorreoData['nombres']."'  ORDER BY id DESC ");
        //AND nombreDocumento2='$nombreEnviarCorreo'
        $contadorVerificacionActualizacion=0;
         '<br>Row: '.$numRows = mysqli_num_rows($validamosExistenciaProcesoSolicitud).'<br><br>';
        while($extraerNombreValidacion=$validamosExistenciaProcesoSolicitud->fetch_array()){
          
                if($extraerNombreValidacion['tipoSolicitud'] == '2' || $extraerNombreValidacion['tipoSolicitud'] == '3'){ 
                    if($extraerNombreValidacion['estado'] == NULL || $extraerNombreValidacion['estado'] == 'Pendiente' || $extraerNombreValidacion['estado'] == 'Aprobado' || $extraerNombreValidacion['estado'] == 'Rechazado' && $extraerNombreValidacion['regresa'] == '1' ){
                    $contadorVerificacionActualizacion++;
                          'Id: '.$extraerNombreValidacion['id'];
                         ' - Estado <b>NULL</b> Solicitud: '.$extraerNombreValidacion['estado'];
                         ' - nombre de la Solicitud: '.$extraerNombreValidacion['nombreDocumento2'];
                        echo '<br>';   
                    }else{
                          'Id: '.$extraerNombreValidacion['id'];
                         ' - Estado Solicitud: '.$extraerNombreValidacion['estado'];
                         ' - nombre de la Solicitud: '.$extraerNombreValidacion['nombreDocumento2'];
                        echo '<br>';  
                    }
                    
                }
            
            
        }
        echo '<br><br><br>';
        
       
        
         '<br>Contador solicitud: '.$contadorVerificacionActualizacion.'<br>';
        
        /// en caso que la consulta no venga nada, libera el documento para realizar tipo solicitud 2 ó 3
        if($numRows == '0'){
            $contadorVerificacionActualizacion='1';
        }
        /// end
        
        if($contadorVerificacionActualizacion > 0){
                             'Debe mandar la alerta';
                            ?>
                            <script> 
                                 window.onload=function(){
                              // alert("Sale alerta desde solicitud");
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../solicitudDocumentosVerMas" method="POST" onsubmit="procesar(this.action);" >
                                <input name="estadoTramie" value="tramiteSolicitud" type="hidden">
                                <input name="id" value="<?php echo $idSolicitudValidar;?>" type="hidden">
                                <input type="hidden" name="validacionProceso" value="1">
                            </form> 
                            <?php
        }else{
                if($estadoActualizaInformacion == 'Aprobado' && $estadoEliminarInformacion == NULL){   'El estado de actualizar está aprobado, pero el de eliminar está listo para usar';
                    $documentoActualizacionProceso='sigue'; 
                }elseif($estadoActualizaInformacion == NULL && $estadoEliminarInformacion == 'Aprobado'){   'El estado elimina está aprobado, pero el de actualizar está listo para usar';
                    $documentoActualizacionProceso='sigue';
                }elseif($estadoActualizaInformacion == 'Aprobado' && $estadoEliminarInformacion == 'Aprobado'){   'Ambos estados están aprobados';
                    $documentoActualizacionProceso='sigue';
                }elseif($estadoActualizaInformacion == NULL && $estadoEliminarInformacion == NULL){   'Ambas están null';
                    $documentoActualizacionProceso='sigue';
                }elseif($estadoActualizaInformacion == 'Rechazado' && $estadoEliminarInformacion == 'Aprobado'){   'Ambas están null';
                    $documentoActualizacionProceso='sigue';
                }elseif($estadoActualizaInformacion == 'Aprobado' && $estadoEliminarInformacion == 'Rechazado'){  'Actualiza aprobado y elimina rechazado';
                    $documentoActualizacionProceso='sigue';
                }elseif($estadoActualizaInformacion == 'Rechazado' && $estadoEliminarInformacion == 'Rechazado'){   'Ambas están null';
                    $documentoActualizacionProceso='sigue';
                }elseif($estadoActualizaInformacion == 'Rechazado' && $estadoEliminarInformacion == NULL){   'Ambas están null';
                    $documentoActualizacionProceso='sigue';
                }elseif($estadoActualizaInformacion == NULL && $estadoEliminarInformacion == 'Rechazado'){   'Ambas están null';
                    $documentoActualizacionProceso='sigue';
                }else{
                    
                         'Debe mandar la alerta';
                            ?>
                            <script> 
                                 window.onload=function(){
                               //alert("Sale alerta desde documento");
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../solicitudDocumentosVerMas" method="POST" onsubmit="procesar(this.action);" >
                                <input name="estadoTramie" value="tramiteSolicitud" type="hidden">
                                <input name="id" value="<?php echo $idSolicitudValidar;?>" type="hidden">
                                <input type="hidden" name="validacionProceso" value="1">
                            </form> 
                            <?php
                        
                }
        
        }
        
        
        if( $documentoActualizacionProceso == 'sigue'){
             '<br>Los estados del documento están libres';
        }
        
        
      
        if($documentoActualizacionProceso == 'sigue'){
            
             '<br><br>Registro';   
            
            
            
            
            
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
            
        
            
            
            
            //// cuando se realiza otra solicitud de eliminación nos debe actualizar este campo para visualizar la eliminación en notificaciones
            if($tipoSolicitud == 3){
                $retirarEstado= $mysqli->query("UPDATE documento SET estadoElimina= NULL WHERE id='$idDocumento'  ");
            }
            //// end
            
            if($archivoNombre == NULL && $guardado == NULL){ 
                
                $ruta = 'sin datos';
                
               $mysqli->query("INSERT INTO solicitudDocumentos ( quienSolicita, tipoSolicitud, tipoDocumento, encargadoAprobar, nombreDocumento, nombreDocumento2, proceso, solicitud,fecha,documento,plataformaH,nombreSalvar,tpdG,procesoG,alerta)
                        VALUES ('$usuario','$tipoSolicitud','$tipoDoc','$encargado','$idDocumento','$nombre','$proceso','$solicitud','$fecha','$ruta','1','$nombreEnviarCorreo','$nombreTipoDOcumentoN','$nombreP','1')")or die(mysqli_error($mysqli));
        
                    require '../../correoEnviar/libreria/PHPMailerAutoload.php';
                    $extraerUsuarios = $mysqli->query("SELECT * FROM usuario WHERE cargo ='$encargado' ")or die(mysqli_error());
                    //$usuariosCargo = $extraerUsuarios->fetch_array(MYSQLI_ASSOC);
                    while($usuariosCargo = $extraerUsuarios->fetch_array()){
                     'EL USUARIO: <b>'.$nombredelUsuario=utf8_encode($usuariosCargo['nombres'].' '.$usuariosCargo['apellidos']);
                      ' tiene el id cargo: '.$usuariosCargo['cargo'].'</b>';
                      $consultaCedula=$usuariosCargo['cedula'];
                      $correoNotificar=$usuariosCargo['correo'];
                  
                  
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
                              <p><b>Ha sido asignado para aprobar la solicitud de '.$tipoSolicitudNombre.' del documento '.$nombreEnviarCorreo.'.</b></p>
                              
                              <br><br>
                              Se recomienda ingresar y verificar su solicitud.
                              <br><br>
                              Este correo es informativo por tanto, le pedimos no responda este mensaje.
                              </p>
                              </body>
                              </html>
                              ');
                          //y ejecutar la solicitud '.$solicitudDocumentoEnviarcorreo.', que se le ha asignado
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
                  
                  
                         
                  
                  
                  
                    }
                       
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
           
                if(!file_exists('../../archivos/solicitudes')){
                    mkdir('../../archivos/solicitudes',0777,true);
                    if(file_exists('../../archivos/solicitudes')){
                        if(move_uploaded_file($guardado, '../../archivos/solicitudes/'.$archivoNombre)){
                            $ruta = utf8_decode('archivos/solicitudes/'.$archivoNombre);
                            
                            ///////// consultamos la tabla y extraemos el nombre
            		        $mysqli->query("INSERT INTO solicitudDocumentos ( quienSolicita, tipoSolicitud, tipoDocumento, encargadoAprobar, nombreDocumento, nombreDocumento2, proceso, solicitud,fecha,documento,plataformaH,nombreSalvar,tpdG,procesoG,alerta)
                            VALUES ('$usuario','$tipoSolicitud','$tipoDoc','$encargado','$idDocumento','$nombre','$proceso','$solicitud','$fecha','$ruta','1','$nombreEnviarCorreo','$nombreTipoDOcumentoN','$nombreP','1')")or die(mysqli_error($mysqli));
            
                           
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
                        
                        
                        
                        
                         /// volvemos el texto totalmente en minuscula
                            $validandoDocumentoCaracteres=mb_strtolower($archivoNombre);
            
                            $activarAlerta=TRUE;
                            $permitidosNombre = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ0123456789-_,.() ";
                            for ($i=0; $i<strlen($validandoDocumentoCaracteres); $i++){
                                if (strpos($permitidosNombre, substr($validandoDocumentoCaracteres,$i,1))===false){
                                    $validandoDocumentoCaracteres . " no es válido<br>";
                                    $activarAlerta=FALSE;
                                    //return false;
                                }
                            }
                            
            
                            
                            if($activarAlerta == FALSE){
                            	$mysqli->query("INSERT INTO solicitudDocumentos ( quienSolicita, tipoSolicitud, tipoDocumento, encargadoAprobar, nombreDocumento,nombreDocumento2, proceso, solicitud,fecha,plataformaH,nombreSalvar,tpdG,procesoG,alerta)
                                VALUES ('$usuario','$tipoSolicitud','$tipoDoc','$encargado','$idDocumento','$nombre','$proceso','$solicitud','$fecha','1','$nombreEnviarCorreo','$nombreTipoDOcumentoN','$nombreP','1')")or die(mysqli_error($mysqli));
                            }
                
                            $verificandoDocumento = $mysqli->query("SELECT MAX(id) as documentoSolicitud FROM solicitudDocumentos WHERE quienSolicita = '$usuario'")or die(mysqli_error($mysqli));
                            $extraerVerificacionDocumento=$verificandoDocumento->fetch_array(MYSQLI_ASSOC);
                            
                                if($activarAlerta == FALSE){
                                    //////////////////////// recibir los post para recuperar la información de los datos previamente almacenado
                                     ?>
                                            <script> 
                                                 window.onload=function(){
                                               
                                                    document.forms["miformularioRetorno"].submit();
                                                 }
                                            </script>
                                             
                                            <form name="miformularioRetorno" action="../../agregarSolicitud" method="POST" onsubmit="procesar(this.action);" >
                                                <input type="hidden" name="retorno" value="1">
                                                <input type="hidden" name="idRetorno" value="<?php echo $extraerVerificacionDocumento['documentoSolicitud']; ?>">
                                            </form> 
                                        <?php
                                
                                }else{
                        
                        
                        
                        
                        
                            ///////// consultamos la tabla y extraemos el nombre
                    	$mysqli->query("INSERT INTO solicitudDocumentos ( quienSolicita, tipoSolicitud, tipoDocumento, encargadoAprobar, nombreDocumento,nombreDocumento2, proceso, solicitud,fecha,documento,plataformaH,nombreSalvar,tpdG,procesoG,alerta)
                        VALUES ('$usuario','$tipoSolicitud','$tipoDoc','$encargado','$idDocumento','$nombre','$proceso','$solicitud','$fecha','$ruta','1','$nombreEnviarCorreo','$nombreTipoDOcumentoN','$nombreP','1')")or die(mysqli_error($mysqli));
            
                            $verificandoDocumento = $mysqli->query("SELECT MAX(id) as documentoSolicitud FROM solicitudDocumentos WHERE quienSolicita = '$usuario'")or die(mysqli_error($mysqli));
                            $extraerVerificacionDocumento=$verificandoDocumento->fetch_array(MYSQLI_ASSOC);
                            
                            $verificandoDocumentoArchivo = $mysqli->query("SELECT *  FROM solicitudDocumentos WHERE id = '".$extraerVerificacionDocumento['documentoSolicitud']."' ")or die(mysqli_error($mysqli));
                            $extraerVerificacionDocumentoArchivo=$verificandoDocumentoArchivo->fetch_array(MYSQLI_ASSOC);
                            
                            $documentoExtraido='../../'.utf8_encode($extraerVerificacionDocumentoArchivo['documento']);
                            
                            //echo '<br><br>';
                            
                                    //Lista de letras abecedario
                                    $carpeta="../../archivos/solicitudes/";
                                    $ruta="/".$carpeta."/";
                                    $directorio=opendir($carpeta);
                                    //recoger los  datos
                                    $datos=array();
                                    $conteoArchivos=0;
                                    while ($archivo = readdir($directorio)) { 
                                      if(($archivo != '.')&&($archivo != '..')){
                                         
                                        if($documentoExtraido == '../../archivos/solicitudes/'.$datos[]=$archivo){
                                            $conteoArchivos++;
                                             '../../archivos/solicitudes/'.$datos[]=$archivo; //echo '<br>';
                                        }
                                         
                                         
                                      } 
                                    }
                                    closedir($directorio);
                                        
                                    if($conteoArchivos > 0){
                                       $documentoHabilitado='1'; 
                                    }else{
                                       $documentoHabilitado='no coincide';
                                    }
                        
                        
                            
                                 if($documentoHabilitado == 1){ /// si el archivo que se sube coincide, la solicitud continua su proceso, en caso contrario no seguirá
                                 
                                        require '../../correoEnviar/libreria/PHPMailerAutoload.php';
                                        $extraerUsuarios = $mysqli->query("SELECT * FROM usuario WHERE cargo ='$encargado' ")or die(mysqli_error());
                                        //$usuariosCargo = $extraerUsuarios->fetch_array(MYSQLI_ASSOC);
                                        while($usuariosCargo = $extraerUsuarios->fetch_array()){
                                         'EL USUARIO: <b>'.$nombredelUsuario=utf8_encode($usuariosCargo['nombres'].' '.$usuariosCargo['apellidos']);
                                          ' tiene el id cargo: '.$usuariosCargo['cargo'].'</b>';
                                          $consultaCedula=$usuariosCargo['cedula'];
                                          $correoNotificar=$usuariosCargo['correo'];
                                      
                                      
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
                                                  <p><b>Ha sido asignado para aprobar la solicitud de '.$tipoSolicitudNombre.' del documento '.$nombreEnviarCorreo.'.</b></p>
                                                  
                                                  <br><br>
                                                  Se recomienda ingresar y verificar su solicitud.
                                                  <br><br>
                                                  Este correo es informativo por tanto, le pedimos no responda este mensaje.
                                                  </p>
                                                  </body>
                                                  </html>
                                                  ');
                                              //y ejecutar la solicitud '.$solicitudDocumentoEnviarcorreo.', que se le ha asignado
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
                                      
                                      
                                             
                                      
                                      
                                      
                                        }
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
                                        
                                 }else{  $extraerVerificacionDocumento['documentoSolicitud'];
                                     $mysqli->query("UPDATE  solicitudDocumentos SET estado='documento' WHERE id='".$extraerVerificacionDocumento['documentoSolicitud']."' ");
                                     ?>
                                            <script> 
                                                 window.onload=function(){
                                               
                                                    document.forms["miformularioRetorno"].submit();
                                                 }
                                            </script>
                                             
                                            <form name="miformularioRetorno" action="../../agregarSolicitud" method="POST" onsubmit="procesar(this.action);" >
                                                <input type="hidden" name="retorno" value="1">
                                                <input type="hidden" name="idRetorno" value="<?php echo $extraerVerificacionDocumento['documentoSolicitud']; ?>">
                                            </form> 
                                    <?php
                                    
                                 }
                            
                                }
                        }else{
                            
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
        
           
            }
        
        }   
    }
    
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
    require '../usuarios/libreria/PHPMailerAutoload.php'; 
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
        
        echo '<script language="javascript">window.location.href="../../solicitudDocumentos"</script>';
    }
    
    /// eliminamos le registro de la peticon de actualizacion desde la revisión documental
    $mysqli->query("DELETE FROM `comnetariosRevision` WHERE idDocumento='$idDocumento' ");
    
    /// preguntamos si el documento ya fue aprobado, de ser así, debe retornar a la otra persona que ya ha sido aprobada o rechazada
    $pregunta_solicitud_aprobado_rechazado=$mysqli->query("SELECT estado,id FROM solicitudDocumentos WHERE id='$id' ");
    $extraer_pregunta_solicitud_rechazado_aprobado=$pregunta_solicitud_aprobado_rechazado->fetch_array(MYSQLI_ASSOC);
    
    /// verificar el encargado
    
    $query_busqueda_cargo = $mysqli->query("SELECT  cedula,cargo FROM usuario WHERE cedula = '".$quienElabora."'");
    $nombres_busqueda_cargo = $query_busqueda_cargo->fetch_array(MYSQLI_ASSOC);
     '<br>'.$quienElabora;
     '<br>id soli: '.$idValidandoasignacion=$_POST['idValidandoasignacion'];
     '<br> cargo '.$nombres_busqueda_cargo['cargo'];
    $query_busqueda_cargo_solicitud = $mysqli->query("SELECT  id,encargadoAprobar FROM solicitudDocumentos WHERE id = '$idValidandoasignacion' AND encargadoAprobar='".$nombres_busqueda_cargo['cargo']."' ");
    $nombres_busqueda_cargo_solicitud = $query_busqueda_cargo_solicitud->fetch_array(MYSQLI_ASSOC);
    
    if($nombres_busqueda_cargo_solicitud['id'] != NULL){//// si el encargado de la solicitud si es igual al encargado del usuario me deja continuar, caso contrario me debe sacar
   
        if($extraer_pregunta_solicitud_rechazado_aprobado['estado'] == 'Aprobado'){
            //echo 'documento aprobado';
            ?>
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformularioAProbado"].submit();
                             //alert("Proceda a asignar elaborador, revisor y aprobador.");
                         }
                    </script>
                     
                    <form name="miformularioAProbado" action="../../solicitudDocumentos" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="alertaAprobado" value="<?php echo $extraer_pregunta_solicitud_rechazado_aprobado['id'];?>">
                    </form> 
            <?php 
            
        }elseif($extraer_pregunta_solicitud_rechazado_aprobado['estado'] == 'Rechazado'){
            //echo 'documento rechazado';
            ?>
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformularioRechazado"].submit();
                             //alert("Proceda a asignar elaborador, revisor y aprobador.");
                         }
                    </script>
                     
                    <form name="miformularioRechazado" action="../../solicitudDocumentos" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="alertaRechazado" value="1">
                    </form> 
            <?php
        }else{
            //echo 'continue';
        
        
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
        }
    
        
        if($accion == 'Rechazado' && $tipoSolicitud == 2){
            
            $fecha = date("Y:m:j");
            $mysqli->query("UPDATE documento SET ultimaFechaRevision = '$fecha', usuarioRevisa = NULL, revisado = 0 WHERE id='$idDocumento'");
            
            //require '../usuarios/libreria/PHPMailerAutoload.php'; 
            $validamosExistenciaSolicitud=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE id='$id' ");
            $extraerExistenciaSolicitud=$validamosExistenciaSolicitud->fetch_array(MYSQLI_ASSOC);
             $nombreSolicitudEnviar=$extraerExistenciaSolicitud['nombreDocumento2'];
             '<br>';
             $documentoSolicitante=$extraerExistenciaSolicitud['quienSolicita'];
            $extraerUsuarios = $mysqli->query("SELECT * FROM usuario WHERE cedula ='$documentoSolicitante' ")or die(mysqli_error());
            $usuariosCargo = $extraerUsuarios->fetch_array(MYSQLI_ASSOC);
             '<br> solicitante: '.$nombredelUsuario=utf8_encode($usuariosCargo['nombres'].' '.$usuariosCargo['apellidos']);
            $correoNotificar=$usuariosCargo['correo'];
            
        }
        
        
        if($accion == 'Aprobado' && $tipoSolicitud == 2){//Actualizacion
            
                        
            $datosQueryIdAnt = $mysqli->query("SELECT idAnterior FROM documento WHERE idAnterior = '$idDocumento'");
              
            if(mysqli_num_rows($datosQueryIdAnt)<=0){
                
                 'id: '.$idDocumento;
                
                $preguntaIdSolicitud=$mysqli->query("SELECT * FROM documento WHERE id='$idDocumento' ");
                $extraerIdSolicitud=$preguntaIdSolicitud->fetch_array(MYSQLI_ASSOC);
                if($extraerIdSolicitud['idCreacion'] != NULL){
                    //echo 'registra junto con el id original';
                    //ESTE INSERT LARGO ME COPIA EL DOCUMENTO QUE SE VA A ACTUALIZAR PARA NO ALTERAR EL ORIGINAL
                    $copiaDocumento = $mysqli->query("INSERT INTO `documento`(`codificacion`,`tipoCodificacion`, `consecutivo`,`version`, `nombres`, `proceso`, `nombreProceso`, `norma`, `metodo`, `tipo_documento`, `htmlDoc`, `ubicacion`, `elabora`, `revisa`, `aprueba`, `documento_externo`, `definiciones`, `archivo_gestion`, `archivo_central`, `archivo_historico`, `disposicion_documental`, `responsable_disposicion`, `aprovacion_registro`, `usuario_aprovacion_reg`, `aprobado_elabora`, `aprobado_revisa`, `aprobado_elabora_e`, `aprobado_revisa_e`, `aprobado_aprueba_e`, `estado`, `control_cambios`, `flujo`, `mesesRevision`, `obsoleto`, `id_solicitud`, `estadoCreado`, `usuarioElabora`, `usuarioRevisa`, `usuarioAprueba`, `idAnterior`, `plataformaH`, `plataformaHRevisa`, `plataformaHAprueba`, `idCreacion`) SELECT `codificacion`,`tipoCodificacion`,`consecutivo`, `version`, `nombres`, `proceso`, `nombreProceso`, `norma`, `metodo`, `tipo_documento`, `htmlDoc`, `ubicacion`, `elabora`, `revisa`, `aprueba`, `documento_externo`, `definiciones`, `archivo_gestion`, `archivo_central`, `archivo_historico`, `disposicion_documental`, `responsable_disposicion`, `aprovacion_registro`, `usuario_aprovacion_reg`, `aprobado_elabora`, `aprobado_revisa`, `aprobado_elabora_e`, `aprobado_revisa_e`, `aprobado_aprueba_e`, `estado`, `control_cambios`, `flujo`, `mesesRevision`, `obsoleto`, `id_solicitud`, `estadoCreado`, `usuarioElabora`, `usuarioRevisa`, `usuarioAprueba`, `idAnterior`, `plataformaH`, `plataformaHRevisa`, `plataformaHAprueba`, `idCreacion` FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
                }else{
                    //echo 'se lleva el id original';
                    //ESTE INSERT LARGO ME COPIA EL DOCUMENTO QUE SE VA A ACTUALIZAR PARA NO ALTERAR EL ORIGINAL
                    $copiaDocumento = $mysqli->query("INSERT INTO `documento`(`codificacion`,`tipoCodificacion`, `consecutivo`,`version`, `nombres`, `proceso`, `nombreProceso`, `norma`, `metodo`, `tipo_documento`, `htmlDoc`, `ubicacion`, `elabora`, `revisa`, `aprueba`, `documento_externo`, `definiciones`, `archivo_gestion`, `archivo_central`, `archivo_historico`, `disposicion_documental`, `responsable_disposicion`, `aprovacion_registro`, `usuario_aprovacion_reg`, `aprobado_elabora`, `aprobado_revisa`, `aprobado_elabora_e`, `aprobado_revisa_e`, `aprobado_aprueba_e`, `estado`, `control_cambios`, `flujo`, `mesesRevision`, `obsoleto`, `id_solicitud`, `estadoCreado`, `usuarioElabora`, `usuarioRevisa`, `usuarioAprueba`, `idAnterior`, `plataformaH`, `plataformaHRevisa`, `plataformaHAprueba`, `idCreacion`) SELECT `codificacion`,`tipoCodificacion`,`consecutivo`, `version`, `nombres`, `proceso`, `nombreProceso`, `norma`, `metodo`, `tipo_documento`, `htmlDoc`, `ubicacion`, `elabora`, `revisa`, `aprueba`, `documento_externo`, `definiciones`, `archivo_gestion`, `archivo_central`, `archivo_historico`, `disposicion_documental`, `responsable_disposicion`, `aprovacion_registro`, `usuario_aprovacion_reg`, `aprobado_elabora`, `aprobado_revisa`, `aprobado_elabora_e`, `aprobado_revisa_e`, `aprobado_aprueba_e`, `estado`, `control_cambios`, `flujo`, `mesesRevision`, `obsoleto`, `id_solicitud`, `estadoCreado`, `usuarioElabora`, `usuarioRevisa`, `usuarioAprueba`, `idAnterior`, `plataformaH`, `plataformaHRevisa`, `plataformaHAprueba`, `id` FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
                }
                
                
    
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
                        $mysqli->query("UPDATE solicitudDocumentos SET estado ='$accion', nombreDocumento = '$idNuevo', tiempoRespuesta = '$dias', QuienAprueba='$quienElabora', regresa = NULL WHERE id = $id"); 
                    }else{
                        $mysqli->query("UPDATE solicitudDocumentos SET estado ='$accion', nombreDocumento = '$idNuevo', QuienAprueba='$quienElabora', regresa = NULL WHERE id = $id");
                    }
                    
                    
                    ?>
                        <script> 
                             window.onload=function(){
                           
                                 document.forms["miformulario"].submit();
                                 //alert("Proceda a asignar elaborador, revisor y aprobador.");
                             }
                        </script>
                         
                        <form name="miformulario" action="../../actualizarDocRoles" method="POST" onsubmit="procesar(this.action);" >
                            <input type="hidden" name="validacionAgregar" value="1">
                            <input type="hidden" name="idSolicitud" value="<?php echo $id; ?>">
                            <input type="hidden" name="solicitud" value="<?php echo $solicitud; ?>">
                            <input type="hidden" name="idDoc" value="<?php echo $idNuevo; ?>">
                        </form> 
                    <?php
                    
                   
                
                }        
                
                
            }else{
                
                    $datosQuery = $mysqli->query("SELECT usuarioElabora FROM documento WHERE id = '$idDocumento'");
                    $datosusuarioElabora = $datosQuery->fetch_array(MYSQLI_ASSOC);
                    $usuarioElabora = $datosusuarioElabora['usuarioElabora'];
                        
                    //VOY A EXTRAER EL ULRIMO ID DE LA TABLA DOCUMENTOS PARA ACTULIZAR EN LA SOLICITUD EL DOCUMENTO A ACTUALIZAR.
                    $queryId = $mysqli->query("SELECT MAX(id) AS id FROM `documento` WHERE usuarioElabora = '$usuarioElabora' ORDER BY id DESC");
                    $datos = $queryId->fetch_array(MYSQLI_ASSOC);
                    $idNuevo = $datos['id'];
                    
                    
                    //Relaciono el documento nuevo con la solicitud
                    $mysqli->query("UPDATE documento SET id_solicitud = '$id', idAnterior='$idDocumento' WHERE id = $idNuevo");
                    
                    if($dias != NULL){
                        $mysqli->query("UPDATE solicitudDocumentos SET estado ='$accion', nombreDocumento = '$idNuevo', tiempoRespuesta = '$dias', QuienAprueba='$quienElabora', regresa = NULL WHERE id = $id"); 
                    }else{
                        $mysqli->query("UPDATE solicitudDocumentos SET estado ='$accion', nombreDocumento = '$idNuevo', QuienAprueba='$quienElabora', regresa = NULL WHERE id = $id");
                    }
                
                    ?>
                        <script> 
                             window.onload=function(){
                           
                                 document.forms["miformulario"].submit();
                                 //alert("Proceda a asignar elaborador, revisor y aprobador.");
                             }
                        </script>
                         
                        <form name="miformulario" action="../../actualizarDocRoles" method="POST" onsubmit="procesar(this.action);" >
                            <input type="hidden" name="validacionAgregar" value="1">
                            <input type="hidden" name="idSolicitud" value="<?php echo $id; ?>">
                            <input type="hidden" name="solicitud" value="<?php echo $solicitud; ?>">
                            <input type="hidden" name="idDoc" value="<?php echo $idNuevo; ?>">
                        </form> 
                    <?php
                
            }
            
            
            
                
            
            
        }
        
        if($accion == 'Aprobado' && $tipoSolicitud == 3){//Eliminacion
            $recuperandoIDRespaldo=$mysqli->query("SELECT * FROM documento WHERE id='$idDocumento' ");
            $recuperarRespaldo=$recuperandoIDRespaldo->fetch_array(MYSQLI_ASSOC);
            $idRespaldo=$recuperarRespaldo['id_solicitud'];
            $mysqli->query("UPDATE documento SET id_solicitud = '$id', id_solicitudRespaldo='$idRespaldo' WHERE id = $idDocumento");
            
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
                     
                    <form name="miformulario" action="../../eliminarDocRoles" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="validacionAgregar" value="1">
                        <input type="hidden" name="idSolicitud" value="<?php echo $id; ?>">
                        <input type="hidden" name="solicitud" value="<?php echo $solicitud; ?>">
                        <input type="hidden" name="idDocumento" value="<?php echo $idDocumento; ?>">
                    </form> 
            <?php
            
            
        }
        
        
       
        
        if($accion == 'Rechazado' || $accion == 'Pendiente'){
            
             $mysqli->query("INSERT INTO comentarioSolicitud (idSolicitud,comentario) VALUES ('$id','$comentarios')");
            
            $fechaCierre = date("Y:m:j");
             //require '../usuarios/libreria/PHPMailerAutoload.php';
            $validamosExistenciaSolicitud=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE id='$id' ");
            $extraerExistenciaSolicitud=$validamosExistenciaSolicitud->fetch_array(MYSQLI_ASSOC);
             $nombreSolicitudEnviar=utf8_encode($extraerExistenciaSolicitud['nombreDocumento2']);
             '<br>';
             $documentoSolicitante=$extraerExistenciaSolicitud['quienSolicita'];
            $extraerUsuarios = $mysqli->query("SELECT * FROM usuario WHERE cedula ='$documentoSolicitante' ")or die(mysqli_error());
            $usuariosCargo = $extraerUsuarios->fetch_array(MYSQLI_ASSOC);
             '<br> solicitante: '.$nombredelUsuario=utf8_encode($usuariosCargo['nombres'].' '.$usuariosCargo['apellidos']);
            $correoNotificar=$usuariosCargo['correo'];
            
            
             
      
      
           
                  //Create a new PHPMailer instance
                  $mail = new PHPMailer();
                  $mail->IsSMTP();
                  
                  //Configuracion servidor mail
                  
                  require '../../correoEnviar/contenido.php';
                 
                  //Agregar destinatario
                  $mail->isHTML(true);
                  $mail->AddAddress($correoNotificar);
                   '-Enviar: '.$correoNotificar;
                  /// end
              
                  $nombreDocumentoEnviarCorreo=$nombre;
                 
      
                  
                  if($tipoSolicitud == '2'){
                      $tipoSolicitudNombre='actualización';
                  }
                  if($tipoSolicitud == '3'){
                      $tipoSolicitudNombre='eliminación';
                  }
      
                  $mail->Subject='Solicitud de documento rechazado';
                  $mail->Body = utf8_decode('
                  <html>
                  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                  <title>HTML</title>
                  </head>
                  <body>
                  <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                  
                  <p>Estimado (a). <b><em>'.$nombredelUsuario.'</em></b>.
                  <br>
                  <p><b>La solicitud del documento '.$nombreSolicitudEnviar.', fue rechazada.</b></p>
                  
                  <br><br>
                  Se recomienda ingresar y verificar su solicitud.
                  <br><br>
                  Este correo es informativo por tanto, le pedimos no responda este mensaje.
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
      
      
             
      
      
        }
            
            
               
            
            $mysqli->query("UPDATE solicitudDocumentos SET estado ='$accion', fechaCierre='$fechaCierre', QuienAprueba='$quienElabora' WHERE id = '$id'");
            //$mysqli->query("INSERT INTO comentarioSolicitud (idSolicitud,comentario) VALUES ('$id','$comentarios')");
           
           
           if($accion == 'Rechazado'){
               $nombreEnvio='validacionAgregarRechazado';
           }else{
               $nombreEnvio='validacionAgregar';
           }
           
           
            ?>
                <script> 
                     window.onload=function(){
                   
                         document.forms["miformulario"].submit();
                     }
                </script>
                 
                <form name="miformulario" action="../../solicitudDocumentos" method="POST" onsubmit="procesar(this.action);" >
                    <input type="hidden" name="<?php echo $nombreEnvio;?>" value="1">
                </form> 
            <?php
    
        }
        
    }else{
        ?>
                    <script> 
                         window.onload=function(){
                             document.forms["documentoValidarSinEstado"].submit();
                         }
                         setTimeout(clickbuttonArchivoPerfil, 0000);
                         function clickbuttonArchivoPerfil() { 
                            document.forms["documentoValidarSinEstado"].submit();
                         }
                    </script>
                     
                    <form name="documentoValidarSinEstado" action="../../solicitudDocumentos" method="POST" onsubmit="procesar(this.action);" >
                        <input value="1" name="alertaSinMensaje" type="hidden">
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
                     
                    <form name="miformulario" action="../../actualizarDocRoles" method="POST" onsubmit="procesar(this.action);" >
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
                     
                    <form name="miformulario" action="../../actualizarDocRoles" method="POST" onsubmit="procesar(this.action);" >
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
                         
                        <form name="miformulario" action="../../actualizarDocRoles.php" method="POST" onsubmit="procesar(this.action);" >
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
                 
                <form name="miformulario" action="../../eliminarDocRoles" method="POST" onsubmit="procesar(this.action);" >
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



if(isset($_POST['ActualizarAgregarSolicitud'])){
    
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
    
     
                    $validandoDocumentoCaracteres=mb_strtolower($archivoNombre);
    
                    $activarAlerta=TRUE;
                    $permitidosNombre = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ0123456789-_,.() ";
                    for ($i=0; $i<strlen($validandoDocumentoCaracteres); $i++){
                        if (strpos($permitidosNombre, substr($validandoDocumentoCaracteres,$i,1))===false){
                            $validandoDocumentoCaracteres . " no es válido<br>";
                            $activarAlerta=FALSE;
                            //return false;
                        }
                    }
                    /*$descripcion_carecteres=["'"];
                    for($bc=0; $bc<count($descripcion_carecteres); $bc++){
                        $descripcion_carecteres[$bc]; 
                         $cadena_carecteres_descripcion = $descripcion_carecteres[$bc];
                         ' - '.$coincidencia_caracteres= strpos($validandoDocumentoCaracteres, $cadena_carecteres_descripcion);
                        if($coincidencia_caracteres != NULL){
                            $activarAlerta=FALSE;
                        }    
                    }*/
                   
        
                    $verificandoDocumento = $mysqli->query("SELECT * FROM solicitudDocumentos WHERE id = '".$_POST['solicitudID']."' ")or die(mysqli_error($mysqli));
                    $extraerVerificacionDocumento=$verificandoDocumento->fetch_array(MYSQLI_ASSOC);
                        if($activarAlerta == FALSE){
                            //////////////////////// recibir los post para recuperar la información de los datos previamente almacenado
                             ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                            document.forms["miformularioRetorno"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformularioRetorno" action="../../agregarSolicitud" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="retorno" value="1">
                                        <input type="hidden" name="idRetorno" value="<?php echo $extraerVerificacionDocumento['id']; ?>">
                                    </form> 
                                <?php
                        }else{                        
 
    
        if(!file_exists('../../archivos/solicitudes')){
            mkdir('../../archivos/solicitudes',0777,true);
            if(file_exists('../../archivos/solicitudes')){
                if(move_uploaded_file($guardado, '../../archivos/solicitudes/'.$archivoNombre)){
                    
                    $ruta = utf8_decode('archivos/solicitudes/'.$archivoNombre);
                    //echo '1';     
                 
                    ?>
                        <script> 
                             window.onload=function(){
                           
                                // document.forms["miformulario"].submit();
                             }
                        </script>
                         
                        <form name="miformulario" action="../../solicitudDocumentos" method="POST" onsubmit="procesar(this.action);" >
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
                         
                        <form name="miformulario" action="../../solicitudDocumentos" method="POST" onsubmit="procesar(this.action);" >
                            <input type="hidden" name="validacionExisteD" value="1">
                        </form> 
                    <?php
                }
            }
            
        }else{
            if(move_uploaded_file($guardado, '../../archivos/solicitudes/'.$archivoNombre)){
                    $ruta = utf8_decode('archivos/solicitudes/'.$archivoNombre);
            
            if($_POST['Tiposolicitud'] == 2){  // nombreDocumento='".$_POST['idDocumento']."', se retira porque al enviar nuevamente la solicitud de actualizacipon despues de aprobar se daña
            $mysqli->query("UPDATE solicitudDocumentos SET tipoDocumento='$tipoDoc', encargadoAprobar='$encargado', nombreDocumento='".$_POST['idDocumento']."', proceso='$proceso', solicitud='$solicitud', documento='$ruta' WHERE id='".$_POST['solicitudID']."' ")or die(mysqli_error($mysqli));
                
            }else{ 
            $mysqli->query("UPDATE solicitudDocumentos SET tipoDocumento='$tipoDoc', encargadoAprobar='$encargado', nombreDocumento='$nombre', nombreDocumento2='$nombre', proceso='$proceso', solicitud='$solicitud', documento='$ruta' WHERE id='".$_POST['solicitudID']."' ")or die(mysqli_error($mysqli));
            }    
            //echo '2';
    
    
                $verificandoDocumento = $mysqli->query("SELECT * FROM solicitudDocumentos WHERE id = '".$_POST['solicitudID']."' ")or die(mysqli_error($mysqli));
                $extraerVerificacionDocumento=$verificandoDocumento->fetch_array(MYSQLI_ASSOC);
                 $documentoExtraido='../../'.utf8_encode($extraerVerificacionDocumento['documento']);
            
            
                
                            //Lista de letras abecedario
                        $carpeta="../../archivos/solicitudes/";
                        $ruta="/".$carpeta."/";
                        $directorio=opendir($carpeta);
                        //recoger los  datos
                        $datos=array();
                        $conteoArchivos=0;
                        while ($archivo = readdir($directorio)) { 
                          if(($archivo != '.')&&($archivo != '..')){
                             
                            if($documentoExtraido == '../../archivos/solicitudes/'.$datos[]=$archivo){
                                $conteoArchivos++;
                                 '../../archivos/solicitudes/'.$datos[]=$archivo;  '<br>';
                            }
                             
                             
                          } 
                        }
                        closedir($directorio);
                            
                        if($conteoArchivos > 0){
                           $documentoHabilitado='1'; 
                        }else{
                           $documentoHabilitado='no coincide';
                        }
                    
                    
                    if($documentoHabilitado == 1){ /// si el archivo que se sube coincide, la solicitud continua su proceso, en caso contrario no seguirá
                            
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
                                  
                                      $nombreDocumentoEnviarCorreo=$_POST['nombre'];
                                      $solicitudDocumentoEnviarcorreo=$_POST['Tiposolicitud'];
                          
                                      if($solicitudDocumentoEnviarcorreo == '1'){
                                          $tipoSolicitudNombre='creación';
                                      }
                                      if($solicitudDocumentoEnviarcorreo == '2'){
                                          $tipoSolicitudNombre='actualización';
                                      }
                                      if($solicitudDocumentoEnviarcorreo == '3'){
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
                                      <p><b>Ha sido asignado para aprobar la solicitud de '.$tipoSolicitudNombre.' del documento '.$nombreDocumentoEnviarCorreo.'.</b></p>
                                      
                                      <br><br>
                                      Se recomienda ingresar y verificar su solicitud.
                                      <br><br>
                                      Este correo es informativo por tanto, le pedimos no responda este mensaje.
                                      </p>
                                      </body>
                                      </html>
                                      ');
                                 
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
                            }    
                            
                        $mysqli->query("UPDATE  solicitudDocumentos SET estado= NULL WHERE id = '".$_POST['solicitudID']."' ");   
                        
                        //echo 'continua';
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
                        //echo 'debe retornar';
                         ?>
                            <script> 
                                 window.onload=function(){
                               
                                    document.forms["miformularioRetorno"].submit();
                                 }
                            </script>
                             
                            <form name="miformularioRetorno" action="../../agregarSolicitud" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="retorno" value="1">
                                <input type="hidden" name="idRetorno" value="<?php echo $extraerVerificacionDocumento['id']; ?>">
                            </form> 
                        <?php
                    }
                    
                    
                }else{
                    ?>
                        <script> 
                             window.onload=function(){
                           
                                 document.forms["miformulario"].submit();
                             }
                        </script>
                         
                        <form name="miformulario" action="../../solicitudDocumentos" method="POST" onsubmit="procesar(this.action);" >
                            <input type="hidden" name="validacionExisteD" value="1">
                        </form> 
                    <?php
                }
            
        }
    }
    
}





?>