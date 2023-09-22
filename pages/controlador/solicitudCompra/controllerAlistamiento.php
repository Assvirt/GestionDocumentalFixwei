<?php
require_once '../../conexion/bd.php';
mb_internal_encoding("UTF-8");

if(isset($_POST['eliminar'])){
   
    $id= $_POST['id'];
    $idOrdenCompra=$_POST['idOrdenCompra'];
    
    $mysqli->query("DELETE FROM solicitudAlistamiento WHERE id='$id' ")or die(mysqli_error($mysqli));
                        
    
     ?>
                            <script>
                                    window.onload=function(){
                                        //alert("El nombre o el archivo ya existen1");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../registroProductos" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="idOrdenCompra" value="<?php echo $idOrdenCompra; ?>">
                                <input type="hidden" name="validacionEliminar" value="1">
                            </form>
                            
                        <?php
}




if(isset($_POST['agregarComentario'])){
 date_default_timezone_set('America/Bogota'); 
//$fecha=date('Y-m-j h:i:s A');  
 $fecha=date('Y-m-j');
  'Rol'.$rol = $_POST['rol'];
     'Orden Compra: '.$idOrdenCompra=$_POST['idOrdenCompra'];
    echo '<br>';
     'Usuario: '.$idUsuario =$_POST['idUsuario'];
    echo '<br>';
     'Comentario: '.$comentario =utf8_decode($_POST['comentario']);
    echo '<br>';
     'Estado: '.$estado=$_POST['opcion'];
    echo '<br>';
    //// verificamos la cantidad de personas por aprobación
    $consultarAprobaciones=$mysqli->query("SELECT COUNT(*) FROM solicitudCompraFlujo WHERE idSolicitud='$idOrdenCompra' AND rol='1' ");
    $extraerApribaciones=$consultarAprobaciones->fetch_array(MYSQLI_ASSOC);
     $conteoAProbaciones=$extraerApribaciones['COUNT(*)'];
     echo '<br>';
    $consultarAprobacionesAprobados=$mysqli->query("SELECT COUNT(*) FROM solicitudCompraFlujo WHERE idSolicitud='$idOrdenCompra' AND rol='1' AND estado='aprobado' ");
    $extraerApribacionesAprobados=$consultarAprobacionesAprobados->fetch_array(MYSQLI_ASSOC);
     $conteoAProbacionesAprobados=$extraerApribacionesAprobados['COUNT(*)'];
    
    $consultarAprobacionesPendienteFinal=$mysqli->query("SELECT * FROM solicitudCompraFlujo WHERE idSolicitud='$idOrdenCompra' AND rol='2' AND estado='pendiente' ");
    $extraerApribacionesPendienteFinal=$consultarAprobacionesPendienteFinal->fetch_array(MYSQLI_ASSOC);
    
    if($extraerApribacionesPendienteFinal['estado'] == 'pendiente'){/*
         'ultima aprobación';
        
        if($estado == 'aprobado'){
            $resultado='aprobado';
            $estadoGuardar='Aprobado';
        }else{
            $resultado='rechazado';
            $estadoGuardar='Rechazado';
        }
         require '../usuarios/libreria/PHPMailerAutoload.php';
                   $consultamos=$mysqli->query("SELECT * FROM solicitudCompra WHERE id='$idOrdenCompra' ");
                   $extraerConsulta=$consultamos->fetch_array(MYSQLI_ASSOC);
                    
                     $usuario=$extraerConsulta['idUsuario'];
                                                
                                                         
                                                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$usuario' ");
                                                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']);
                                                        $correoResponsable=$columna['correo'];  echo '<br>';
                                                        $enviarIdUsuario=$columna['id'];  echo '<br>';
                                        
                                                            //Create a new PHPMailer instance
                                                            $mail = new PHPMailer();
                                                            $mail->IsSMTP();
                                                            
                                                            //Configuracion servidor mail
                                                            require '../../correoEnviar/contenido.php';
                                                            
                                                            //Agregar destinatario
                                                            $mail->isHTML(true);
                                                            $mail->AddAddress($correoResponsable);
                                                            $mail->Subject = utf8_decode('Gestión de solicitud # '.$idOrdenCompra);
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
                                                            <p>La solicitud # <b>'.$idOrdenCompra.'</b> fue '.$resultado.'.</p>
                                                            Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                                            <br>
                                                            <em>Mi perfil --> mis pendientes --> Compras --> Solicitud +</em>.
                                                            <br>
                                                            <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                                            <br><br>
                                                            Este correo es informativo y por tanto, le pedimos no responda este mensaje.
                                                            </p>
                                                            </body>
                                                            </html>
                                                            ');
                                                            
                                                            //Avisar si fue enviado o no y dirigir al index
                                                        
                                                            if ($mail->Send()) {
                                                            // echo 'Enviado';
                                                            } else {
                                        
                                                            }    
       
        if($estado == 'aprobado'){ //,  comentario='$comentario'
        $mysqli->query("UPDATE solicitudCompraFlujo SET estado='$estado' WHERE idSolicitud='$idOrdenCompra' AND rol='2' ")or die(mysqli_error($mysqli));
        }
        if($estado == 'rechazado'){ //,  comentario='$comentario' 
        $mysqli->query("UPDATE solicitudCompraFlujo SET estado =NULL WHERE idSolicitud='$idOrdenCompra' AND rol='2' ")or die(mysqli_error($mysqli));
        $mysqli->query("UPDATE solicitudCompraFlujo SET estado='$estado' WHERE idSolicitud='$idOrdenCompra' AND rol='1' ")or die(mysqli_error($mysqli));
        }
        
        $mysqli->query("UPDATE solicitudCompra SET estado='$estadoGuardar' WHERE id='$idOrdenCompra' ")or die(mysqli_error($mysqli));
        $mysqli->query("INSERT INTO solicitudCompraComentarios (idSolicitud,idUsuario,comentario,estado,fecha,rol)VALUES('$idOrdenCompra','$idUsuario','$comentario','$estado','$fecha','$rol')  ")or die(mysqli_error($mysqli));
        
    */}else{
         'Contador de aprobados'.$conteoAProbacionesAprobadosb=$conteoAProbacionesAprobados+1;
        if($conteoAProbaciones == $conteoAProbacionesAprobadosb && $estado == 'aprobado'){
            //echo 'Listo para la aprobación final';
            
            
              require '../usuarios/libreria/PHPMailerAutoload.php';
                $consultamos=$mysqli->query("SELECT * FROM solicitudCompraFlujo WHERE idSolicitud='$idOrdenCompra' AND rol='2' ");
                $extraerConsulta=$consultamos->fetch_array(MYSQLI_ASSOC);
                    
                    $usuario=$extraerConsulta['idUsuario'];
                    $nombrePersona=$_POST['nombrePersona'];                          
                                                        
                                                        
                                                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$usuario' ");
                                                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']);
                                                        $correoResponsable=$columna['correo'];  echo '<br>';
                                                        
                                                            //Create a new PHPMailer instance
                                                            $mail = new PHPMailer();
                                                            $mail->IsSMTP();
                                                            
                                                            //Configuracion servidor mail
                                                            require '../../correoEnviar/contenido.php';
                                                            
                                                            //Agregar destinatario
                                                            $mail->isHTML(true);
                                                            $mail->AddAddress($correoResponsable);
                                                            $mail->Subject = utf8_decode('Gestión de solicitud # '.$idOrdenCompra);
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
                                                            <p>La solicitud # <b>'.$idOrdenCompra.'</b> fue revisada y aprobado por '.$nombrePersona.'.</p>
                                                            Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                                            <br>
                                                            <em>Mi perfil --> mis pendientes --> Compras --> Solicitud +</em>.
                                                            <br>
                                                            <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                                            <br><br>
                                                            Este correo es informativo y por tanto, le pedimos no responda este mensaje.
                                                            </p>
                                                            </body>
                                                            </html>
                                                            ');
                                                            
                                                           
                                                            //Avisar si fue enviado o no y dirigir al index
                                                            
                                                            
                                                            if ($mail->Send()) {
                                                            // echo 'Enviado';
                                                            } else {
                                        
                                                            } 
                                                            
                                                            
            $mysqli->query("INSERT INTO solicitudCompraComentarios (idSolicitud,idUsuario,comentario,estado,fecha,rol)VALUES('$idOrdenCompra','$idUsuario','$comentario','$estado','$fecha','$rol')  ");                                               
            
            $mysqli->query("UPDATE solicitudCompraFlujo SET estado='pendiente' WHERE idSolicitud='$idOrdenCompra' AND rol='2' ")or die(mysqli_error($mysqli));
            $mysqli->query("UPDATE solicitudCompraFlujo SET estado='aprobado' WHERE idSolicitud='$idOrdenCompra' AND idUsuario='$idUsuario' AND rol='1'")or die(mysqli_error($mysqli));
            //, comentario='$comentario'
            
            
           
            if($estado == 'aprobado'){
               $estadoGuardar='Revisado'; 
            }else{
               $estadoGuardar='Rechazado'; 
            }
           $mysqli->query("UPDATE solicitudCompra SET estado='$estadoGuardar' WHERE id='$idOrdenCompra' ")or die(mysqli_error($mysqli));
        }else{
            //echo '<br>Busca la siguiente para aprobar';
           
                   require '../usuarios/libreria/PHPMailerAutoload.php';
                   
                   
                   /// primero notificamos a la persona que debe realizar la siguiente aprobación
                   if($estado == 'aprobado'){
                        $nombrePersona=$_POST['nombrePersona'];  
                        $consultamosSiguienteAprobador=$mysqli->query("SELECT * FROM solicitudCompraFlujo WHERE idSolicitud='$idOrdenCompra' ");
                        $extraerConsultaAproabdor=$consultamosSiguienteAprobador->fetch_array(MYSQLI_ASSOC);
                        $idUsuarioNotificar=$extraerConsultaAproabdor['idUsuario'];
                        
                                                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$idUsuarioNotificar' ");
                                                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']);
                                                        $correoResponsable=$columna['correo'];  echo '<br>';
                                        
                                                            //Create a new PHPMailer instance
                                                            $mail = new PHPMailer();
                                                            $mail->IsSMTP();
                                                            
                                                            //Configuracion servidor mail
                                                            require '../../correoEnviar/contenido.php';
                                                            
                                                            //Agregar destinatario
                                                            $mail->isHTML(true);
                                                            $mail->AddAddress($correoResponsable);
                                                            $mail->Subject = utf8_decode('Gestión de solicitud # '.$idOrdenCompra);
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
                                                            <p>La solicitud # <b>'.$idOrdenCompra.'</b> fue '.$estado.' por '.$nombrePersona.'.</p>
                                                            Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                                            <br>
                                                            <em>Mi perfil --> mis pendientes --> Compras --> Solicitud +</em>.
                                                            <br>
                                                            <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                                            <br><br>
                                                            Este correo es informativo y por tanto, le pedimos no responda este mensaje.
                                                            </p>
                                                            </body>
                                                            </html>
                                                            ');
                                                            
                                                            //Avisar si fue enviado o no y dirigir al index
                                                        
                                                            if ($mail->Send()) {
                                                            // echo 'Enviado';
                                                            } else {
                                        
                                                            }    
                                                         
                   }
                   
                   
                   
                   $consultamos=$mysqli->query("SELECT * FROM solicitudCompra WHERE id='$idOrdenCompra' ");
                   $extraerConsulta=$consultamos->fetch_array(MYSQLI_ASSOC);
                    
                     $usuario=$extraerConsulta['idUsuario'];
                     $nombrePersona=$_POST['nombrePersona'];                            
                                                         
                                                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$usuario' ");
                                                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']);
                                                        $correoResponsable=$columna['correo'];  echo '<br>';
                                        
                                                            //Create a new PHPMailer instance
                                                            $mail = new PHPMailer();
                                                            $mail->IsSMTP();
                                                            
                                                            //Configuracion servidor mail
                                                            require '../../correoEnviar/contenido.php';
                                                            
                                                            //Agregar destinatario
                                                            $mail->isHTML(true);
                                                            $mail->AddAddress($correoResponsable);
                                                            $mail->Subject = utf8_decode('Gestión de solicitud # '.$idOrdenCompra);
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
                                                            <p>La solicitud # <b>'.$idOrdenCompra.'</b> fue '.$estado.' por '.$nombrePersona.'.</p>
                                                            Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                                            <br>
                                                            <em>Mi perfil --> mis pendientes --> Compras --> Solicitud +</em>.
                                                            <br>
                                                            <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                                            <br><br>
                                                            Este correo es informativo y por tanto, le pedimos no responda este mensaje.
                                                            </p>
                                                            </body>
                                                            </html>
                                                            ');
                                                            
                                                            //Avisar si fue enviado o no y dirigir al index
                                                        
                                                            if ($mail->Send()) {
                                                            // echo 'Enviado';
                                                            } else {
                                        
                                                            }    
                                                         
                                                     
                        
           $mysqli->query("UPDATE solicitudCompraFlujo SET estado='$estado' WHERE idSolicitud='$idOrdenCompra' AND idUsuario='$idUsuario'   ")or die(mysqli_error($mysqli));
           //, comentario='$comentario'
        
           $mysqli->query("INSERT INTO solicitudCompraComentarios (idSolicitud,idUsuario,comentario,estado,fecha,rol)VALUES('$idOrdenCompra','$idUsuario','$comentario','$estado','$fecha','$rol')  ");
            if($estado == 'aprobado'){
               $estadoGuardar='Aprobado'; 
            }else{
               $estadoGuardar='Rechazado'; 
            }
           //$mysqli->query("UPDATE solicitudCompra SET estado='$estadoGuardar' WHERE id='$idOrdenCompra' ")or die(mysqli_error($mysqli));
        }
    }
    
   ?>
                             <script> 
                                         window.onload=function(){
                                       
                                            document.forms["miformulario"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformulario" action="../../solicitudCompra" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionActualizar" value="1">
                                    </form> 
                            
                            
                        <?php
}

if(isset($_POST['agregarComentarioB'])){
 date_default_timezone_set('America/Bogota'); 
//$fecha=date('Y-m-j h:i:s A');  
 $fecha=date('Y-m-j');
  //'Rol'.$rol = $_POST['rol'];
     'Orden Compra: '.$idOrdenCompra=$_POST['idOrdenCompra'];
    echo '<br>';
     'Usuario: '.$idUsuario =$_POST['idUsuario'];
    echo '<br>';
     'Comentario: '.$comentario =utf8_decode($_POST['comentario']);
  
    echo '<br>';
    
           $mysqli->query("INSERT INTO solicitudCompraComentarios (idSolicitud,idUsuario,comentario,estado,fecha,rol)VALUES('$idOrdenCompra','$idUsuario','$comentario','Proceso de compra','$fecha','Comprador')  ");
            
    
    
   ?>
                             <script> 
                                         window.onload=function(){
                                       
                                            document.forms["miformulario"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformulario" action="../../registroValores" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionActualizar" value="1">
                                        <input name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra']; ?>" type="hidden">
                                    </form> 
                            
                            
                        <?php
}

if(isset($_POST['alistamiento'])){
    
    $porcentaje=$_POST['porcentaje'];
    $usuario=$_POST['usuario'];
     $idOrdenCompra=$_POST['idOrdenCompra'];
     '<br>Aprobador: '.$aprobador=$_POST['aprobador'];
     $total=$_POST['total'];
                                     '<br><br>';
     require '../usuarios/libreria/PHPMailerAutoload.php';
     
     // validamos si el total del porcentaje es igual a 100, en caso contrario nos debe avisar que no se puede
     for ($iA = 0, $jA = 0; $iA<count($porcentaje), $jA<count($usuario); $iA++, $jA++){
        $sumandoPorcentaje+=$porcentaje[$iA];
     }
     if($sumandoPorcentaje == '100'){
        
     
    
     
                                    for ($i = 0, $j = 0; $i<count($porcentaje), $j<count($usuario); $i++, $j++){  'Listo para enviar';
                                          'Ingresar porcentaje : '.$porcentaje[$i]; 
                                          '--- y el usuario a notificar es : '.$usuario[$j]; 
                                          '<br>';
                                         
                                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$usuario[$j]' ");
                                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']);
                                        $correoResponsable=$columna['correo'];  echo '<br>';
                        
                                            //Create a new PHPMailer instance
                                            $mail = new PHPMailer();
                                            $mail->IsSMTP();
                                            
                                            //Configuracion servidor mail
                                            require '../../correoEnviar/contenido.php';
                                            
                                            //Agregar destinatario
                                            $mail->isHTML(true);
                                            $mail->AddAddress($correoResponsable);
                                            $mail->Subject = utf8_decode('Gestión de solicitud # '.$idOrdenCompra);
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
                                            <p>La solicitud # <b>'.$idOrdenCompra.'</b> está disponible para su revisión.</p>
                                            Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                            <br>
                                            <em>Mi perfil --> mis pendientes --> Compras --> Solicitud +</em>.
                                            <br>
                                            <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                            <br><br>
                                            Este correo es informativo y por tanto, le pedimos no responda este mensaje.
                                            </p>
                                            </body>
                                            </html>
                                            ');
                                            
                                            //Avisar si fue enviado o no y dirigir al index
                                        
                                            if ($mail->Send()) {
                                            // echo 'Enviado';
                                            } else {
                        
                                            }    
                                         
                                         $mysqli->query("INSERT INTO solicitudCompraFlujo (idUsuario,estado,rol,porcentaje,idSolicitud)VALUEs('$usuario[$j]','pendiente','1','$porcentaje[$i]','$idOrdenCompra')");
                                     
                                    }
                                    $mysqli->query("INSERT INTO solicitudCompraFlujo (idUsuario,rol,idSolicitud)VALUES('$aprobador','2','$idOrdenCompra')");
                                 ?>
                                  <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformulario"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformulario" action="../../solicitudCompra" method="POST" onsubmit="procesar(this.action);" >
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
                                     
                                    <form name="miformulario" action="../../registroProductos" method="POST" onsubmit="procesar(this.action);" >
                                        <input name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra']; ?>" type="hidden">
                                        <input type="hidden" name="validacionValidarPorcentaje" value="1">
                                    </form> 
                                 <?php
     }
    
}

if(isset($_POST['notificar'])){
     
    $idOrdenCompra=$_POST['idOrdenCompra'];
     require '../usuarios/libreria/PHPMailerAutoload.php';
     
    $consultamos=$mysqli->query("SELECT * FROM solicitudCompraFlujo WHERE idSolicitud='$idOrdenCompra' AND rol='1' ");
    while($extraerConsulta=$consultamos->fetch_array()){
    
     $usuario=$extraerConsulta['idUsuario'];
                                
                                         
                                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$usuario' ");
                                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']);
                                        $correoResponsable=$columna['correo'];  echo '<br>';
                        
                                            //Create a new PHPMailer instance
                                            $mail = new PHPMailer();
                                            $mail->IsSMTP();
                                            
                                            //Configuracion servidor mail
                                            require '../../correoEnviar/contenido.php';
                                            
                                            //Agregar destinatario
                                            $mail->isHTML(true);
                                            $mail->AddAddress($correoResponsable);
                                            $mail->Subject = utf8_decode('Gestión de solicitud # '.$idOrdenCompra);
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
                                            <p>La solicitud # <b>'.$idOrdenCompra.'</b> está disponible para su revisión.</p>
                                            Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                            <br>
                                            <em>Mi perfil --> mis pendientes --> Compras --> Solicitud +</em>.
                                            <br>
                                            <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                            <br><br>
                                            Este correo es informativo y por tanto, le pedimos no responda este mensaje.
                                            </p>
                                            </body>
                                            </html>
                                            ');
                                            
                                            //Avisar si fue enviado o no y dirigir al index
                                        
                                            if ($mail->Send()) {
                                            // echo 'Enviado';
                                            } else {
                        
                                            }    
                                         
                                     
        }
        $mysqli->query("UPDATE solicitudCompraFlujo SET estado='pendiente' WHERE idSolicitud='$idOrdenCompra' AND rol='1'  ");
        $mysqli->query("UPDATE solicitudCompraFlujo SET estado= NULL WHERE idSolicitud='$idOrdenCompra' AND rol='2'  ");
        $mysqli->query("UPDATE solicitudCompra SET estado='Pendiente' WHERE id='$idOrdenCompra' ")or die(mysqli_error($mysqli));
                                 ?>
                                  <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformulario"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformulario" action="../../solicitudCompra" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionAgregar" value="1">
                                    </form> 
                                 <?php 
}

if(isset($_POST['notificarComprador'])){
    
 date_default_timezone_set('America/Bogota'); 
//$fecha=date('Y-m-j h:i:s A');  
 $fecha=date('Y-m-j');
     'Orden Compra: '.$idOrdenCompra=$_POST['idOrdenCompra'];
    echo '<br>';
     'Usuario: '.$idUsuario =$_POST['idUsuario'];
    echo '<br>';
     'Comentario: '.$comentario =utf8_decode($_POST['comentario']);
    echo '<br>';
     'Estado: '.$estado=$_POST['opcion'];
    echo '<br>';
    $rol = $_POST['rol'];
   
    
    $consultarAprobacionesPendienteFinal=$mysqli->query("SELECT * FROM solicitudCompraFlujo WHERE idSolicitud='$idOrdenCompra' AND rol='2' AND estado='pendiente' ");
    $extraerApribacionesPendienteFinal=$consultarAprobacionesPendienteFinal->fetch_array(MYSQLI_ASSOC);
    
    
     
        require '../usuarios/libreria/PHPMailerAutoload.php';
        
        if($estado == 'aprobado'){
            $resultado='aprobado';
            $comprador=$_POST['comprador'];
            $total =$_POST['total'];
            
            
            /// si la fecha se encuentra activada, debe guardar la fecha que se genera la orden de compra
            date_default_timezone_set('America/Bogota'); 
            $fecha=date('Y-m-j');
            $consucutivoCnsultando=$mysqli->query("SELECT * FROM consecutivoOC WHERE caracter='Fecha' ORDER BY id ");
            $extraerFechaConsulta=$consucutivoCnsultando->fetch_array(MYSQLI_ASSOC);
            
             '<br>En este punto se hace el insert de solicitudComprador, pero se hace en una tabla temporal llamada solicitudCompradorTemporal';
            if($extraerFechaConsulta['id'] != NULL){ /// colocamos la tabla temporal para llevar el id de compra al final
                $mysqli->query("INSERT INTO solicitudCompradorTemporal (idSolicitud,idUsuario,estado,total,fechaActivada)VALUES('$idOrdenCompra','$comprador','pendiente','$total','$fecha')  ")or die(mysqli_error($mysqli));
            }else{
                $mysqli->query("INSERT INTO solicitudCompradorTemporal (idSolicitud,idUsuario,estado,total)VALUES('$idOrdenCompra','$comprador','pendiente','$total')  ")or die(mysqli_error($mysqli));
            }
            
            
            
            $consultarUltimoRegistro=$mysqli->query("SELECT MAX(id) AS ordenCompra FROM solicitudCompradorTemporal WHERE idSolicitud='$idOrdenCompra' AND idUsuario='$comprador' ");
            $extraerConsultaUltimRegistro=$consultarUltimoRegistro->fetch_array(MYSQLI_ASSOC);
            $enviarOrdenCOmpra=$extraerConsultaUltimRegistro['ordenCompra'];
            
            
                                $consucutivo=$mysqli->query("SELECT * FROM consecutivoOC ORDER BY id ");
                                $string="";
                                while($extraerConsecutivo=$consucutivo->fetch_array()){
                                    
                                    if($extraerConsecutivo['aplicado'] == '1'){
                                        $string.=($enviarOrdenCOmpra);
                                    }elseif($extraerConsecutivo['caracter'] == 'Fecha'){
                                        $string.=$fecha;
                                    }else{
                                        echo '<br>';
                                     $string.=($extraerConsecutivo['caracter']);
                                    }
                                    $string .= "-";
                                }
                                $newStrinG=trim($string, '-');
                                 '<br>Codificación orden de compra: '.$enviarOrdenCOmpra=$newStrinG;
                                 
            
            
            // si es aprobado notificamos al comprador
                                                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$comprador' ");
                                                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']);
                                                        $correoResponsable=$columna['correo'];  echo '<br>';
                                                        $enviarIdUsuario=$columna['id'];  echo '<br>';
                                                        
               //Create a new PHPMailer instance
                                                            $mail = new PHPMailer();
                                                            $mail->IsSMTP();
                                                            
                                                            //Configuracion servidor mail
                                                            require '../../correoEnviar/contenido.php';
                                                            
                                                            //Agregar destinatario
                                                            $mail->isHTML(true);
                                                            $mail->AddAddress($correoResponsable);
                                                            $mail->Subject = utf8_decode('Orden de compra # '.$extraerConsultaUltimRegistro['ordenCompra']); //$enviarOrdenCOmpra
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
                                                            <p>La solicitud # <b>'.$idOrdenCompra.'</b> fue aprobada y autorizada para su proceso de compra y la orden de compra # '.$extraerConsultaUltimRegistro['ordenCompra'].' ha sido asignada para su gestión.</p>
                                                            Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                                            <br>
                                                            <em>Mi perfil --> mis pendientes --> Compras --> Orden de compra +</em>.
                                                            <br>
                                                            <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                                            <br><br>
                                                            Este correo es informativo y por tanto, le pedimos no responda este mensaje.
                                                            </p>
                                                            </body>
                                                            </html>
                                                            ');
                                                            
                                                            //Avisar si fue enviado o no y dirigir al index
                                                        
                                                            if ($mail->Send()) {
                                                            // echo 'Enviado';
                                                            } else {
                                        
                                                            }    
       
                                                        
        
        
        }else{
            $resultado='rechazado';
        }
        
                   $consultamos=$mysqli->query("SELECT * FROM solicitudCompra WHERE id='$idOrdenCompra' ");
                   $extraerConsulta=$consultamos->fetch_array(MYSQLI_ASSOC);
                    
                     $usuario=$extraerConsulta['idUsuario'];
                                                
                                    if($resultado == 'aprobado'){
                                     $mensaje='';   
                                    }else{
                                      $mensaje='Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                                <br>
                                                <em>Mi perfil --> mis pendientes --> Compras --> Solicitud +</em>.
                                                <br>
                                                <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.';  
                                    }                
                                                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$usuario' ");
                                                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']);
                                                        $correoResponsable=$columna['correo'];  echo '<br>';
                                                        $enviarIdUsuario=$columna['id'];  echo '<br>';
                                        
                                                            //Create a new PHPMailer instance
                                                            $mail = new PHPMailer();
                                                            $mail->IsSMTP();
                                                            
                                                            //Configuracion servidor mail
                                                            require '../../correoEnviar/contenido.php';
                                                            
                                                            //Agregar destinatario
                                                            $mail->isHTML(true);
                                                            $mail->AddAddress($correoResponsable);
                                                            $mail->Subject = utf8_decode('Gestión de solicitud # '.$idOrdenCompra);
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
                                                            <p>La solicitud # <b>'.$idOrdenCompra.'</b> fue '.$resultado.'.</p>
                                                            '.$mensaje.'
                                                            <br><br>
                                                            Este correo es informativo y por tanto, le pedimos no responda este mensaje.
                                                            </p>
                                                            </body>
                                                            </html>
                                                            ');
                                                            
                                                            //Avisar si fue enviado o no y dirigir al index
                                                        
                                                            if ($mail->Send()) {
                                                            // echo 'Enviado';
                                                            } else {
                                        
                                                            }    
                                        
       
        if($estado == 'aprobado'){ //,  comentario='$comentario'
        $mysqli->query("UPDATE solicitudCompraFlujo SET estado='$estado' WHERE idSolicitud='$idOrdenCompra' AND rol='2' ")or die(mysqli_error($mysqli));
        $mysqli->query("UPDATE solicitudCompra SET estado='Orden de compra' WHERE id='$idOrdenCompra' ")or die(mysqli_error($mysqli));
        }
        if($estado == 'rechazado'){ //,  comentario='$comentario' 
        $mysqli->query("UPDATE solicitudCompraFlujo SET estado =NULL WHERE idSolicitud='$idOrdenCompra' AND rol='2' ")or die(mysqli_error($mysqli));
        $mysqli->query("UPDATE solicitudCompraFlujo SET estado='$estado' WHERE idSolicitud='$idOrdenCompra' AND rol='1' ")or die(mysqli_error($mysqli));
        }
        
        $mysqli->query("INSERT INTO solicitudCompraComentarios (idSolicitud,idUsuario,comentario,estado,fecha,rol)VALUES('$idOrdenCompra','$idUsuario','$comentario','$estado','$fecha','$rol')  ")or die(mysqli_error($mysqli));
        
    
    
   ?>
                             <script> 
                                         window.onload=function(){
                                       
                                           document.forms["miformulario"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformulario" action="../../solicitudCompra" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionActualizar" value="1">
                                    </form> 
                            
                            
                        <?php 
}




if(isset($_POST['eliminarEntradaSalida'])){
    
   
    $id= $_POST['id'];
    $idOrdenCompra=$_POST['idOrdenCompra'];
    
    $mysqli->query("DELETE FROM solicitudEntradaSalidas WHERE id='$id' ")or die(mysqli_error($mysqli));
                        
    
     ?>
                            <script>
                                    window.onload=function(){
                                        //alert("El nombre o el archivo ya existen1");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../entradasSalidas" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="idOrdenCompra" value="<?php echo $idOrdenCompra; ?>">
                                <input type="hidden" name="validacionEliminar" value="1">
                            </form>
                            
                        <?php

}

if(isset($_POST['alistamientoIngreso'])){
    
    
    
    $porcentaje=$_POST['porcentaje'];
    $usuario=$_POST['usuario'];
     $idOrdenCompra=$_POST['idOrdenCompra'];
     '<br>Aprobador: '.$aprobador=$_POST['aprobador'];
     $total=$_POST['total'];
                                     '<br><br>';
     //require '../usuarios/libreria/PHPMailerAutoload.php';
     
                                    for ($i = 0, $j = 0; $i<count($porcentaje), $j<count($usuario); $i++, $j++){
                                          'Ingresar porcentaje : '.$porcentaje[$i]; 
                                          '--- y el usuario a notificar es : '.$usuario[$j]; 
                                          '<br>';
                                         
                                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$usuario[$j]' ");
                                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']);
                                        $correoResponsable=$columna['correo'];  echo '<br>';
                        
                                            //Create a new PHPMailer instance
                                           /* $mail = new PHPMailer();
                                            $mail->IsSMTP();
                                            
                                            //Configuracion servidor mail
                                            require '../../correoEnviar/contenido.php';
                                            
                                            //Agregar destinatario
                                            $mail->isHTML(true);
                                            $mail->AddAddress($correoResponsable);
                                            $mail->Subject = utf8_decode('Gestión de solicitud # '.$idOrdenCompra);
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
                                            <p>La solicitud # <b>'.$idOrdenCompra.'</b> está disponible para su revisión.</p>
                                            Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                            <br>
                                            <em>Mi perfil --> mis pendientes --> Compras --> Solicitud +</em>.
                                            <br>
                                            <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                            <br><br>
                                            Este correo es informativo y por tanto, le pedimos no responda este mensaje.
                                            </p>
                                            </body>
                                            </html>
                                            ');
                                            
                                            //Avisar si fue enviado o no y dirigir al index
                                        
                                            if ($mail->Send()) {
                                            // echo 'Enviado';
                                            } else {
                        
                                            }    
                                         */
                                    //     $mysqli->query("INSERT INTO solicitudCompraFlujo (idUsuario,estado,rol,porcentaje,idSolicitud)VALUEs('$usuario[$j]','pendiente','1','$porcentaje[$i]','$idOrdenCompra')");
                                     
                                    }
                                    
                                    $observacion=utf8_decode($_POST['observacion']);
                                    $estado=$_POST['estado'];
                                    
                                    $mysqli->query("INSERT INTO solicitudEntradaSalidasEstado (idSolicitud,observacion,estado)VALUES('$idOrdenCompra','$observacion','$estado')")or die(mysqli_error($mysqli));
                               
    

                        ?>
                            <script>
                                    window.onload=function(){
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../ordenCompraEntradas" method="post">
                                <input type="hidden" name="idOrdenCompra" value="<?php echo $idOrdenCompra; ?>">
                                <input type="hidden" name="validacionEliminar" value="1">
                            </form>
                            
                        <?php
}
?>