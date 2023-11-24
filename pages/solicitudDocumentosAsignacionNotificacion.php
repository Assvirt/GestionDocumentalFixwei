<?php
require_once 'conexion/bd.php';


// si viene 1 sola consulta, entonces no debe activar mensaje
if($_POST['consultaUsario'] != NULL && $_POST['transferir'] != NULL){

    /// mandamos una alerta, para decirle al administrador que debe seleccionar una solicitud
    if($_POST['seleccionar'] == NULL){ 
        ?>
                <script> 
                     window.onload=function(){
                   
                         document.forms["miformulario"].submit();
                     }
                </script>
                 
                <form name="miformulario" action="solicitudDocumentosAsignacion" method="POST" onsubmit="procesar(this.action);" >
                    <input type="hidden" name="consultaUsario" value="<?php echo $_POST['consultaUsario'];?>">
                    <input type="hidden" name="validacion_select" value="1">
                </form> 
            <?php
    }else{
        
    
    
    '<br> id solicitud: '.$nombreDocumento=$_POST['seleccionar'];
    '<br><br>';
    require 'controlador/usuarios/libreria/PHPMailerAutoload.php';
    /// creamos un recorrido de los id que entran en el array para su lectura
    for($i=0; $i<count($_POST['seleccionar']); $i++){
        
        //// se debe validar que solo los id que entran serán los update del encargado
        
        if($_POST['seleccionar'][$i] != NULL){
            //// se imprime el id que se envia desde la vista de asignación
            'Imprimiendo id de solicitud: '.$_POST['seleccionar'][$i].'<br>';
            //// se imprime todos los nombres de los documentos de la vista de asignación
            
            
            //// enviamos el correo a la persona que se le encargo
            $extraerUsuarios = $mysqli->query("SELECT * FROM usuario WHERE id ='".$_POST['transferir']."' ")or die(mysqli_error());
            $usuariosCargo = $extraerUsuarios->fetch_array(MYSQLI_ASSOC);
            '<br>EL USUARIO: <b>'.$nombredelUsuario=utf8_encode($usuariosCargo['nombres'].' '.$usuariosCargo['apellidos']);
            '<br> tiene el id cargo: '.$usuariosCargo['cargo'].'</b>';
            $consultaCedula=$usuariosCargo['cedula'];
            '<br>A:'.$correoNotificar=$usuariosCargo['correo'];
            '<br>Encargado a transferir: '.$transferir=$_POST['transferir'];
            
            $recorridoSolicitudesPendientes=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE  id='".$_POST['seleccionar'][$i]."' "); //asignacion='".$_POST['transferir']."'
            $extraerRecorridoSolicitudesPendiente=$recorridoSolicitudesPendientes->fetch_array(MYSQLI_ASSOC);
            $extraerRecorridoSolicitudesPendiente['id'];  
            'Nombre documento: '.$nombreDocumentoEnviarCorreo=utf8_encode($extraerRecorridoSolicitudesPendiente['nombreDocumento2']).'<br>'; 
             'tipo solici: '.$tipoSolicitud=$extraerRecorridoSolicitudesPendiente['tipoSolicitud'];
                        	        
                        	        ///// preguntamos si la solicitud ya fue trasladada a el usuario seleccionado
                                    
                                    $pregunta_existe_traslado=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE asignacion='".$transferir."' AND cambioCargo='".$usuariosCargo['cargo']."' AND id='".$_POST['seleccionar'][$i]."' ");
                                    $extraer_pregunta_existente_traslado=$pregunta_existe_traslado->fetch_array(MYSQLI_ASSOC);
                                   
                                    /// si existe el registro trasladado de una solicitud, no envia correo
                                    if($extraer_pregunta_existente_traslado['id'] != NULL){
                                        
                                    }else{
                                    
                                    /// mantenemos las solicitudes pendiente encargadas
                        	        $updateUsuario=$mysqli->query("UPDATE solicitudDocumentos SET asignacion='".$transferir."', cambioCargo='".$usuariosCargo['cargo']."', encargadoAprobar='".$usuariosCargo['cargo']."' WHERE id='".$_POST['seleccionar'][$i]."'  ");
                        	        //quienSolicita='".$usuariosCargo['cedula']."'
                        	        
                                                                        
                                                                          $mail = new PHPMailer();
                                                                          $mail->IsSMTP();
                                                                          
                                                                         
                                                                          require 'correoEnviar/contenido.php';
                                                                         
                                                                          //Agregar destinatario
                                                                          $mail->isHTML(true);
                                                                          $mail->AddAddress($correoNotificar);
                                                                           '-Enviar: '.$correoNotificar;
                                                                          /// end
                                                                      
                                                                         
                                                                          
                                                              
                                                                          if($tipoSolicitud == '1'){
                                                                              $tipoSolicitudNombre='creación';
                                                                          }
                                                                          if($tipoSolicitud == '2'){
                                                                              $tipoSolicitudNombre='actualización';
                                                                          }
                                                                          if($tipoSolicitud == '3'){
                                                                              $tipoSolicitudNombre='eliminación';
                                                                          }
                                                              
                                                                          $mail->Subject=utf8_decode('Solicitud de documento (documento asignado)');
                                                                          $mail->Body = utf8_decode('
                                                                          <html>
                                                                          <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                                                          <title>HTML</title>
                                                                          </head>
                                                                          <body>
                                                                          <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                                                                          
                                                                          <p>Estimado (a). <b><em>'.$nombredelUsuario.'</em></b>.
                                                                          <br>
                                                                          <p><b>El documento '.$nombreDocumentoEnviarCorreo.' fue asignado para su gestión de '.$tipoSolicitudNombre.'</b></p>
                                                                          
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
        }
        
    }
    
     ?>
                <script> 
                     window.onload=function(){
                   
                         document.forms["miformulario"].submit();
                     }
                </script>
                 
                <form name="miformulario" action="solicitudDocumentosAsignacion" method="POST" onsubmit="procesar(this.action);" >
                    <input type="hidden" name="consultaUsario" value="<?php echo $_POST['consultaUsario'];?>">
                    <input type="hidden" name="transferir" value="<?php echo $_POST['transferir'];?>">
                    <input type="hidden" name="validacion_select_ok" value="1">
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
                 
                <form name="miformulario" action="solicitudDocumentosAsignacion" method="POST" onsubmit="procesar(this.action);" >
                    <input type="hidden" name="consultaUsario" value="<?php echo $_POST['consultaUsario'];?>">
                </form> 
            <?php  
}