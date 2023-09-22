<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
//require_once 'inactividad.php';
require_once 'conexion/bd.php';
$cargoID = $_SESSION['session_cargo'];

//////////////////////PERMISOS////////////////////////

$formulario = 'revisionDoc'; //aqui se cambia el nombre del formulario

require_once 'permisosPlataforma.php';
//////////////////////PERMISOS////////////////////////

//error_reporting(E_ERROR);

require 'controlador/usuarios/libreria/PHPMailerAutoload.php';

                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                    $data = $mysqli->query("SELECT * FROM documento WHERE vigente = 1 AND pre IS NULL ORDER BY codificacion ASC")or die(mysqli_error());
                    //SELECT * FROM documento WHERE vigente = 1 AND revisado = 0 AND pre IS NULL ORDER BY codificacion ASC
                    while($row = $data->fetch_assoc()){
                        
                       /// validación para visualizar solo los documentos que necesito para pruebas
                       if($row['id'] == '19' || $row['id'] == '155' || $row['id'] == '154' ){
                           
                       }else{
                           continue;
                       }
                       // emd
                        $proceso =  $row['proceso'];  
                            date_default_timezone_set("America/Bogota");
                            'Fecha inicial: '.$fechainicial = substr($row['fechaAprobado'],0,-8);
                            '<br>Fecha actual: '.$fechaactual = date("Y-m-d");
                            
                            
                            $preguntandoMeses=$row['mesesRevision'];
                            if($preguntandoMeses == 1){
                                 $tiempoRespuesta ='30';//$row['tiempoRespuesta'];
                            }else{
                                 $tiempoRespuesta =30*$row['mesesRevision'];//$row['tiempoRespuesta'];
                            }
                           
                            
                            '<br>Fecha validar: '.$fechaRestar = date("Y-m-d",strtotime($fechainicial."+ ".$tiempoRespuesta." days")); 
                            
                            $datetime1 = date_create($fechaRestar);
                            $datetime2 = date_create($fechaactual);
                            $contador = date_diff($datetime1, $datetime2);
                            $differenceFormat = '%a';
                            
                            
                            
                            if($fechaRestar > $fechaactual){
                                 '<br>Sin avisar<br>';
                                //echo $contador->format($differenceFormat);
                            }else{
                               
                                  //echo '-'.$contador->format($differenceFormat);
                               
                                
                                $consultamosSolicitud=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE id='".$row['id_solicitud']."' ");
                                $extraerSolicitudConsultaConsultamosSolicitud=$consultamosSolicitud->fetch_array(MYSQLI_ASSOC);
                                $tipoSolicitud=$extraerSolicitudConsultaConsultamosSolicitud['tipoSolicitud'];
                                  
                                /// consultamos el proceso para sacar los lideres de procesos y notificarlos
                                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                                    $consultamosProceso=$mysqli->query("SELECT * FROM procesos WHERE id='$proceso' ");
                                    $extraerConsultaProceso=$consultamosProceso->fetch_array(MYSQLI_ASSOC);
                                        //// vamos a imprimir el dueño de proceso
                                        $array = json_decode(($extraerConsultaProceso['duenoProceso']));
                                        //var_dump($array);
                                        $longitud = count($array);
                                       
                                        if($extraerConsultaProceso['importacion'] == 1 ){ 
                                            echo 'entra al A';
                                            for($i=0; $i<$longitud; $i++){
                                                    //saco el valor de cada elemento
                                                    echo 'Dato: '.$array[$i]; echo '<br>';
                                                       
                                                    $queryNombresCargos = $mysqli->query("SELECT * FROM cargos WHERE nombreCargos LIKE '%$array[$i]%' ");
                                                    $nombresCargos = $queryNombresCargos->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    "*".$nombresCargos['id_cargos']."<br><br>";
                                                    	
                                                    if($nombresCargos['id_cargos'] != NULL){
                                                    	echo  '<br>Debe avisar';
                                                    	
                                                    	$extraerUsuarios = $mysqli->query("SELECT * FROM usuario WHERE cargo ='".$nombresCargos['id_cargos']."' ")or die(mysqli_error());
                                                        $usuariosCargo = $extraerUsuarios->fetch_array(MYSQLI_ASSOC);
                                                        '<br>EL USUARIO: <b>'.$nombredelUsuario=($usuariosCargo['nombres'].' '.$usuariosCargo['apellidos']);
                                                        '<br> tiene el id cargo: '.$usuariosCargo['cargo'].'</b>';
                                                        $consultaCedula=$usuariosCargo['cedula'];
                                                        echo '<br>'.$correoNotificar=$usuariosCargo['correo'];
                                                        
                                            

                                                                  $mail = new PHPMailer();
                                                                  $mail->IsSMTP();
                                                                  
                                                                 
                                                                  require 'correoEnviar/contenido.php';
                                                                 
                                                                  //Agregar destinatario
                                                                  $mail->isHTML(true);
                                                                  $mail->AddAddress($correoNotificar);
                                                                   '-Enviar: '.$correoNotificar;
                                                                  /// end
                                                              
                                                                  $nombreDocumentoEnviarCorreo=$row['nombres'];//$_POST['nombreDocumento'];
                                                                  
                                                      
                                                                  if($tipoSolicitud == '1'){
                                                                      $tipoSolicitudNombre='creación';
                                                                  }
                                                                  if($tipoSolicitud == '2'){
                                                                      $tipoSolicitudNombre='actualización';
                                                                  }
                                                                  if($tipoSolicitud == '3'){
                                                                      $tipoSolicitudNombre='eliminación';
                                                                  }
                                                      
                                                                  $mail->Subject=utf8_decode('Solicitud de documento (revisión documental)');
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
                                                                  Se recomienda ingresar y verificar su solicitud.
                                                                  <br><br>
                                                                  Este correo es informativo y por tanto, le pedimos no responda este mensaje.
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
                                        
                                        
                                        
                                       
                                  
                                  
                            }
                     
                    }
                    

    
}
?>