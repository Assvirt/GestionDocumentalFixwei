<?php
//////// traemos la bd
date_default_timezone_set("America/Bogota");
require_once '../../conexion/bd.php';
session_start();
$usuario = $_SESSION["session_username"];

if(isset($_POST['revision'])){
    
    $controlCambios = $_POST['controlCambios'];
    $actualizar = $_POST['radiobtnActualizar'];
    
    
    $nombre = utf8_decode($_POST['nombre']);//idDocumento -- Traigo ahí el id porque ahi lo guardaron 
    
    if($actualizar == 'si'){ 

        $mysqli->query("UPDATE documento SET revisado = 1, usuarioRevisa = '$usuario' WHERE id = '$nombre'");
        
        $tipoSolicitud = 2; //Tipo 2 actualizacioon 
        
        $nombre = utf8_decode($_POST['nombre']);//idDocumento -- Traigo ahí el id porque ahi lo guardaron 
        $nombreDocumento = utf8_decode($_POST['nombreDocumento']);
        $proceso = $_POST['proceso'];
        $tipoDoc = $_POST['tipoDoc'];
        $encargado = $_POST['encargado'];
        $solicitud = utf8_decode($_POST['controlCambios']);
        $fecha = date("Y:m:j");
        '<br>'.$radiobtnE=$_POST['radiobtnE'];
        '<br>'.$select_encargadoE=$_POST['select_encargadoE'];
        
        require '../../correoEnviar/libreria/PHPMailerAutoload.php';
        
        ///// acá vamos a notificar a la persona adicional
            if($radiobtnE != NULL){
                 if($radiobtnE == 'usuarios'){
                        $longitud = count($select_encargadoE); 
                        for($i=0; $i<$longitud; $i++){
                            $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$select_encargadoE[$i]' ");
                            while($columna = $nombreuser->fetch_array()){
                            $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                            $correoResponsable=$columna['correo']; 
                             '<br>';
                              
                                              //ignore_user_abort(1);
                                              //set_time_limit(0); 
                                            
                                              
                                              //Create a new PHPMailer instance
                                              $mail = new PHPMailer();
                                              $mail->IsSMTP();
                                              
                                             
                                              require '../../correoEnviar/contenido.php';
                                             
                                              //Agregar destinatario
                                              $mail->isHTML(true);
                                              $mail->AddAddress($correoResponsable);
                                               '-Enviar: '.$correoNotificar;
                                              /// end
                                          
                                              $nombreDocumentoEnviarCorreo=$_POST['nombreDocumento'];
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
                                  
                                              $mail->Subject=utf8_decode('Revisión documental - autorizado para visualizar');
                                              $mail->Body = utf8_decode('
                                              <html>
                                              <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                              <title>HTML</title>
                                              </head>
                                              <body>
                                              <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                                              
                                              <p>Estimado (a). <b><em>'.$nombreResponsable.'</em></b>.
                                              <br>
                                              <p><b>Ha sido asignado para visualizar la solicitud de '.$tipoSolicitudNombre.' del documento '.$nombreDocumentoEnviarCorreo.'.</b></p>
                                              
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
                                                //echo '<br>envia';
                                                } else {
                                                //echo '<br>no envia';
                                                }
                                                
                            }                
                        }
                    }
    
                 if($radiobtnE == 'cargos'){
                         'Cargos';
                        $longitud = count($select_encargadoE); 
                        for($i=0; $i<$longitud; $i++){
                            $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo = '$select_encargadoE[$i]' ");
                            while($columna = $nombreuser->fetch_array()){
                                $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                                 $correoResponsable=$columna['correo']; 
                                '<br>';
                                
                                            //ignore_user_abort(1);
                                              //set_time_limit(0); 
                                            
                                              
                                              //Create a new PHPMailer instance
                                              $mail = new PHPMailer();
                                              $mail->IsSMTP();
                                              
                                             
                                              require '../../correoEnviar/contenido.php';
                                             
                                              //Agregar destinatario
                                              $mail->isHTML(true);
                                              $mail->AddAddress($correoResponsable);
                                               '-Enviar: '.$correoNotificar;
                                              /// end
                                          
                                              $nombreDocumentoEnviarCorreo=$_POST['nombreDocumento'];
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
                                  
                                              $mail->Subject=utf8_decode('Revisión documental - autorizado para visualizar');
                                              $mail->Body = utf8_decode('
                                              <html>
                                              <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                              <title>HTML</title>
                                              </head>
                                              <body>
                                              <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                                              
                                              <p>Estimado (a). <b><em>'.$nombreResponsable.'</em></b>.
                                              <br>
                                              <p><b>Ha sido asignado para visualizar la solicitud de '.$tipoSolicitudNombre.' del documento '.$nombreDocumentoEnviarCorreo.'.</b></p>
                                              
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
                                
                                } else {
    
                                }
                            }
                        }
                    }
            }
        //// END
        
        
        
        
        /// consultamos el proceso para sacar los lideres de procesos y notificarlos
            $acentos = $mysqli->query("SET NAMES 'utf8'");
            $consultamosProceso=$mysqli->query("SELECT * FROM procesos WHERE id='$proceso' ");
            $extraerConsultaProceso=$consultamosProceso->fetch_array(MYSQLI_ASSOC);
                //// vamos a imprimir el dueño de proceso
                $array = json_decode(($extraerConsultaProceso['duenoProceso']));
                //var_dump($array);
                $longitud = count($array);
                if($extraerConsultaProceso['importacion'] == 1 ){
                    for($i=0; $i<$longitud; $i++){
                                //saco el valor de cada elemento
                                //echo $array[$i]; echo '<br>';
                                $queryNombres = $mysqli->query("SELECT * FROM cargos WHERE nombreCargos LIKE '%$array[$i]%' ");
                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                
                            	 "*".$nombres['id_cargos']."<br><br>";
                            	
                            	$extraerUsuarios = $mysqli->query("SELECT * FROM usuario WHERE cargo ='".$nombres['id_cargos']."' ")or die(mysqli_error());
                                while($usuariosCargo = $extraerUsuarios->fetch_array()){
                                 'EL USUARIO: <b>'.$nombredelUsuario=($usuariosCargo['nombres'].' '.$usuariosCargo['apellidos']);
                                  ' tiene el id cargo: '.$usuariosCargo['cargo'].'</b>';
                                  $consultaCedula=$usuariosCargo['cedula'];
                                  $correoNotificar=$usuariosCargo['correo'];
                              
                              
                                         
                                          //ignore_user_abort(1);
                                          //set_time_limit(0); 
                                        
                                          
                                          //Create a new PHPMailer instance
                                          $mail = new PHPMailer();
                                          $mail->IsSMTP();
                                          
                                         
                                          require '../../correoEnviar/contenido.php';
                                         
                                          //Agregar destinatario
                                          $mail->isHTML(true);
                                          $mail->AddAddress($correoNotificar);
                                           '-Enviar: '.$correoNotificar;
                                          /// end
                                      
                                          $nombreDocumentoEnviarCorreo=$_POST['nombreDocumento'];
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
                                          //<p><b>Ha sido asignado para visualizar la solicitud de '.$tipoSolicitudNombre.' del documento '.$nombreDocumentoEnviarCorreo.'.</b></p>
                                          $mail->Subject=utf8_decode('Revisión documental - dueño de proceso'); //- autorizado para visualizar
                                          $mail->Body = utf8_decode('
                                          <html>
                                          <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                          <title>HTML</title>
                                          </head>
                                          <body>
                                          <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                                          
                                          <p>Estimado (a). <b><em>'.$nombredelUsuario.'</em></b>.
                                          <br>
                                          <p><b>El documento '.$nombreDocumentoEnviarCorreo.' se encuentra dentro del periodo de revisión</b></p>
                                          
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
                }else{
                    for($i=0; $i<$longitud; $i++){
                                //saco el valor de cada elemento
                                //echo $array[$i]; echo '<br>';
                                $queryNombres = $mysqli->query("SELECT * FROM cargos WHERE id_cargos LIKE '%$array[$i]%' ");
                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                
                            	 "*".$nombres['id_cargos']."<br><br>";
                            	
                            	$extraerUsuarios = $mysqli->query("SELECT * FROM usuario WHERE cargo ='".$nombres['id_cargos']."' ")or die(mysqli_error());
                                while($usuariosCargo = $extraerUsuarios->fetch_array()){
                                 'EL USUARIO: <b>'.$nombredelUsuario=($usuariosCargo['nombres'].' '.$usuariosCargo['apellidos']);
                                  ' tiene el id cargo: '.$usuariosCargo['cargo'].'</b>';
                                  $consultaCedula=$usuariosCargo['cedula'];
                                  $correoNotificar=$usuariosCargo['correo'];
                              
                              
                                         
                                          //ignore_user_abort(1);
                                          //set_time_limit(0); 
                                        
                                          
                                          //Create a new PHPMailer instance
                                          $mail = new PHPMailer();
                                          $mail->IsSMTP();
                                          
                                         
                                          require '../../correoEnviar/contenido.php';
                                         
                                          //Agregar destinatario
                                          $mail->isHTML(true);
                                          $mail->AddAddress($correoNotificar);
                                           '-Enviar: '.$correoNotificar;
                                          /// end
                                      
                                          $nombreDocumentoEnviarCorreo=$_POST['nombreDocumento'];
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
                                          //<p><b>Ha sido asignado para visualizar la solicitud de '.$tipoSolicitudNombre.' del documento '.$nombreDocumentoEnviarCorreo.'.</b></p>
                                          $mail->Subject=utf8_decode('Revisión documental - dueño de proceso'); //- autorizado para visualizar
                                          $mail->Body = utf8_decode('
                                          <html>
                                          <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                          <title>HTML</title>
                                          </head>
                                          <body>
                                          <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                                          
                                          <p>Estimado (a). <b><em>'.$nombredelUsuario.'</em></b>.
                                          <br>
                                          <p><b>El documento '.$nombreDocumentoEnviarCorreo.' se encuentra dentro del periodo de revisión</b></p>
                                          
                                          
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
                //// end
        /// END
        
        
        
        //// validamos el encargado para enviar la notificación
            $extraerUsuarios = $mysqli->query("SELECT * FROM usuario WHERE cargo ='$encargado' ")or die(mysqli_error());
            while($usuariosCargo = $extraerUsuarios->fetch_array()){
                                 'EL USUARIO: <b>'.$nombredelUsuario=($usuariosCargo['nombres'].' '.$usuariosCargo['apellidos']);
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
                                      
                                          $nombreDocumentoEnviarCorreo=$_POST['nombreDocumento'];
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
                              
                                          $mail->Subject=utf8_decode('Revisión documental - encargado para revisión');
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
        //// END
        
         '<br>'.utf8_encode($solicitud); echo '<br>';
        $mysqli->query("INSERT INTO solicitudDocumentos ( quienSolicita, tipoSolicitud, tipoDocumento, encargadoAprobar, nombreDocumento,nombreDocumento2, proceso, solicitud,fecha,documento,plataformaH)
                VALUES ('$usuario','$tipoSolicitud','$tipoDoc','$encargado','$nombre','".($_POST['nombreDocumento'])."','$proceso','".utf8_encode($solicitud)."','$fecha','sin datos','1')")or die(mysqli_error($mysqli));
         $select_encargadoE=json_encode($select_encargadoE);        
        $mysqli->query("INSERT INTO comnetariosRevision ( idUsuario, comentario, fecha, idDocumento,notificar,notificarQuien,lider)VALUES ('$usuario','".utf8_encode($solicitud)."','$fecha','$nombre','$radiobtnE','$select_encargadoE','".$extraerConsultaProceso['duenoProceso']."')")or die(mysqli_error($mysqli));
    
       
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
    
    if($actualizar == 'no'){
        
        $comentario = utf8_decode($_POST['controlCambios']);
        $fecha = date("Y:m:j");
        $idDocumento = $_POST['idDocumento'];
        $mesesRevision = $_POST['nmesesRevision'];
        
        $mysqli->query("UPDATE documento SET ultimaFechaRevision = '$fecha', mesesRevision = '$mesesRevision' WHERE id = '$nombre'");
        
        $mysqli->query("INSERT INTO comnetariosRevision ( idUsuario, comentario, fecha, idDocumento)
                VALUES ('$usuario','$comentario','$fecha','$idDocumento')")or die(mysqli_error($mysqli));
        
        
        //echo '<script language="javascript">alert("Comentario agregado.");
        //window.location.href="../../revisionDocumental"</script>';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../revisionDocumental" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionAgregar" value="1">
            </form> 
        <?php
        
        
    }
    
    
}



?>