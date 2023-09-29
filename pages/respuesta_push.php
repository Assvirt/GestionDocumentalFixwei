<?php
// si hay algo que notificar, devuelva la respuesta con datos para
// notificación push de lo contrario, simplemente salga del código

error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
  
}else{
    include 'conexion/bd.php';
    $sesion=$_SESSION["session_username"];
                    
                    /// consultamos el usuario
                    $usuario_consulta=$mysqli->query("SELECT id,cedula,cargo FROM `usuario` WHERE cedula='".$_SESSION["session_username"]."' ")or die(mysqli_error($mysqli));
                    $extraer_usuario_consulta=$usuario_consulta->fetch_array(MYSQLI_ASSOC);
                    $extraer_usuario_consulta['cargo'];
                    
                    $solicitudDocumento=$mysqli->query("SELECT id,encargadoAprobar,estado,tipoSolicitud,nombreDocumento2,alerta FROM solicitudDocumentos WHERE encargadoAprobar='".$extraer_usuario_consulta['cargo']."' AND estado IS NULL AND alerta='1' ")or die(mysqli_error($mysqli));
                    $extraerSolicitudDocumento=$solicitudDocumento->fetch_array(MYSQLI_ASSOC);
                    
                    if($extraerSolicitudDocumento['id'] != NULL){   
                            $mysqli->query("UPDATE solicitudDocumentos SET  alerta='0' WHERE id='".$extraerSolicitudDocumento['id']."' "); 
                            if($extraerSolicitudDocumento['tipoSolicitud'] == '1'){
                                $tipoSolicitudMensaje=' de creación';
                            }
                            if($extraerSolicitudDocumento['tipoSolicitud'] == '2'){
                                $tipoSolicitudMensaje=' de actualización';
                            }
                            if($extraerSolicitudDocumento['tipoSolicitud'] == '3'){
                                $tipoSolicitudMensaje=' de eliminación';
                            }
                            $webNotificationPayload['title'] = 'Solicitud '.$tipoSolicitudMensaje; /// título de la notificacion

                            $webNotificationPayload['body'] = ''.$extraerSolicitudDocumento['nombreDocumento2'].''; /// contenido de la notificación
                            
                            $webNotificationPayload['icon'] = 'https://fixwei.com/plataforma/pages/iconos/correo.png'; /// icono
                            
                            $webNotificationPayload['url'] = 'https://fixwei.com/plataforma/pages/myperfil#no-back-button'; /// abrir el navegador
                            
                            echo json_encode($webNotificationPayload);
                            exit();
                    }         
                            
                          
                      
             
}

?>