<?php
session_start();
error_reporting(E_ERROR);
require_once("../controlador/sesion/connection.php"); 


if(!isset($_POST["login"])){
    session_destroy();
}

if(isset($_POST["login"])){
  ///// validamos para que solo pueda entrar cierto caracter
  if($_POST['tipo'] == 'C' || $_POST['tipo'] == 'E'){
  
    if(!empty($_POST['cedula']) && !empty($_POST['password'])) {
      $username=$_POST['cedula'].''.$_POST['tipo'];
    	$password=$_POST['password'];
    	
        $consultaRoot = "SELECT * FROM cliente WHERE usuario='".$username."' AND clave='".$password."'";
        $queryRoot = mysqli_query($con, $consultaRoot);
        $numrowsRoot = mysqli_num_rows($queryRoot);
        
        
        if($numrowsRoot != 0 ){
            $seguridadPreguntar=$con->query("SELECT * FROM seguridadDelete WHERE estado ='bloqueado'  ");
            $resultadoSeguridadPreguntar=$seguridadPreguntar->fetch_array(MYSQLI_ASSOC);
                
            if($resultadoSeguridadPreguntar['id']){
                $usuarioAdministradorBloqueado=1;
            }else{
                header("Location: ../home");
                $_SESSION['session_username']= $username;
                $_SESSION['session_root'] = 1;
                //$_SESSION['session_idUsuario']= $idUsuario;
            }
            
        }else{
            ///// primero consultamos la existencia del usuario antes de validar los datos de usuario y contraseña
            
            
            
            $preguntado_existencia_usuario=$con->query("SELECT cedula,id FROM usuario WHERE cedula='$username' ");
            $extraer_regunta_existencia=$preguntado_existencia_usuario->fetch_array(MYSQLI_ASSOC);
            if($extraer_regunta_existencia['id'] != NULL){
                
                $consulta = "SELECT * FROM usuario WHERE cedula='".$username."' AND clave='".$password."'";
                $query = mysqli_query($con, $consulta);
                $numrows=mysqli_num_rows($query);
                
                if($numrows!=0){
                    
                    while($row=mysqli_fetch_assoc($query)){
                        $idUsuario = $row['id'];
                        $cedula = $row['cedula'];
                        $clave = $row['clave'];
                        $cargo = $row['cargo'];
                        $estadoEliminado = $row['estadoEliminado'];
                        $estadoAnulado = $row['estadoAnulado'];
                    }
                    
                    //esta es la cedula 
                    if($estadoEliminado == TRUE || $estadoAnulado == TRUE ){
                        //echo "<script language='javascript'>confirm('El usuario no se encuentra activo, contacte con el administrador.');
                        //    window.location.href='login'</script>';";
                        $alertaSesionC='1';
                    }else{
                        $_SESSION['session_username']= $cedula;
                        $_SESSION['session_cargo']= $cargo;
                        $_SESSION['session_idUsuario']= $idUsuario;
                    
                               /*
                                 $nombreUsuario = $con->query("SELECT * FROM ConectadoUsuario WHERE idUsuario ='$cedula'")or die(mysqli_error());
                                 $col = $nombreUsuario->fetch_array(MYSQLI_ASSOC);
                                 $validacionU = $col['idUsuario'];
                                 */
                                 $nombreUsuario = $con->query("SELECT * FROM usuario WHERE cedula ='$cedula'")or die(mysqli_error());
                                 $col = $nombreUsuario->fetch_array(MYSQLI_ASSOC);
                                 $validacionU = $col['cedula'];
                                 $contadorsesion=$col['contadorSesion'];
                                 $contandoUsuario=$col['contadorSesion'];
                                  'sese U: '.$ipSesionValidar=$col['sesionIP'];
                                 
                                 // validamos que está activado el ip sesion para navegar sobre la ip de la empresa
                                    $consultaClienteSescion=$con->query("SELECT * FROM cliente ");
                                    $extraerClienteSesion=$consultaClienteSescion->fetch_array(MYSQLI_ASSOC);
                                    
                                    if($extraerClienteSesion['sesion'] == 'Si'){ 
                                         '<br>secion e: '.$direccionIPEmpresa=$extraerClienteSesion['registroIP'];//$_SERVER['REMOTE_ADDR'];
                                        
                                        //// en caso al usuario le han dado permiso para navegar por cualquier IP dejar ingresar al sistema
                                        if($ipSesionValidar == 'NULL'){  
                                            $alertaSesionIP='1';  
                                            $saleUsuarioCerrar=$validacionU;
                                            /*
                                            if($validacionU == $cedula && $contadorsesion == '0' ){
                                         
                                               $contandoUsuario=$contandoUsuario+1;
                                               $consulta = "UPDATE usuario SET estadoUsuario='Conectado', contadorSesion='$contandoUsuario' WHERE cedula='$validacionU' ";
                                               $query = mysqli_query($con, $consulta);
                                               header("Location: ../home");
                                               
                                            }else{
                                           
                                                $alertaSesion=1;
                                                $saleUsuarioCerrar=$validacionU;
                                                //echo "<script language='javascript'>confirm('Aplicando 1 sola sesión.');
                                                //window.location.href='login'</script>';";
                                            }*/
                                        }else{ 
                                            if($validacionU == $cedula && $contadorsesion == '0' && $direccionIPEmpresa == $ipSesionValidar){ 
                                         
                                               $contandoUsuario=$contandoUsuario+1;
                                               $consulta = "UPDATE usuario SET estadoUsuario='Conectado', contadorSesion='$contandoUsuario' WHERE cedula='$validacionU' ";
                                               $mensajeria=$con->query("UPDATE users SET  status='Disponible' WHERE email='$validacionU' ")or die(mysqli_error());
                                               $query = mysqli_query($con, $consulta);
                                               header("Location: ../home");
                                               echo "<script language='javascript'>
                                                window.location.href='../home'</script>';";
                                               
                                            }else{ 
                                                
                                                if($contadorsesion == 1){
                                                    $alertaSesion='1';
                                                }else{
                                                    $alertaSesionIP='1';    
                                                }
                                                
                                                $saleUsuarioCerrar=$validacionU;
                                                //echo "<script language='javascript'>confirm('Aplicando 1 sola sesión.');
                                                //window.location.href='login'</script>';";
                                            }
                                        }
                                        
                                        // END
                                        
                                    }
                                    if($extraerClienteSesion['sesion'] == 'No'){
                                        if($validacionU == $cedula && $contadorsesion == '0'){
                                         
                                           $contandoUsuario=$contandoUsuario+1;
                                           $consulta = "UPDATE usuario SET estadoUsuario='Conectado', contadorSesion='$contandoUsuario' WHERE cedula='$validacionU' ";
                                           $mensajeria=$con->query("UPDATE users SET  status='Disponible' WHERE email='$validacionU' ")or die(mysqli_error());
                                           $query = mysqli_query($con, $consulta);
                                           header("Location: ../home");
                                           
                                        }else{
                                       
                                            $alertaSesion='1';
                                            $saleUsuarioCerrar=$validacionU;
                                            //echo "<script language='javascript'>confirm('Aplicando 1 sola sesión.');
                                            //window.location.href='login'</script>';";
                                        }
                                    }
                                //
                                
                                 
                                        
                                   
                                    
                               
                        ///// fin del proceso
                        
                       
                        
                        
                        
                    }
                }else{
                     $alertaSesionB='1';
                }
            }else{
                $alertaSesionB_existencia='1';
            }
        }
        
        
        
        
        
        
    
    
        
    
    }
  }else{
    $noPermitirCaracteresEspeciales='1';
  }
}



        ///////// validación para cerrar la sesión en los diferentes dispositivos                     
        if(isset($_POST['CerrandoUsuariosActual'])){ 
                                 $cerrandoCompleto=$_POST['cerrandoCompleto'];
                                 $nombreUsuario = $con->query("SELECT * FROM usuario WHERE cedula ='$cerrandoCompleto'")or die(mysqli_error());
                                 $col = $nombreUsuario->fetch_array(MYSQLI_ASSOC);
                                 $validacionCerrando = $col['cedula'];
                                 
                                 
                                 if($validacionCerrando == $cerrandoCompleto){
                                 
                                   $consulta = "UPDATE usuario SET estadoUsuario='desconectado', contadorSesion='0' WHERE cedula='$validacionCerrando' ";
                                   $query = mysqli_query($con, $consulta);
                                   //header("Location: login");
                                  
                                }
                                
        }  
        /// END
        ////// validación del motivo de la solicitud para el permiso de ip
        if(isset($_POST['solicitandoUsuarioPermiso'])){
            'CC S: '.$usuarioPermisoMotivo=$_POST['usuarioSolicitudPermiso'];
           $motivoSolicitud=utf8_decode($_POST['motivoSolicitud']);
                                $nombreUsuario = $con->query("SELECT * FROM usuario WHERE cedula ='$usuarioPermisoMotivo'")or die(mysqli_error());
                                $col = $nombreUsuario->fetch_array(MYSQLI_ASSOC);
                                 'CC: '.$validacionCerrando = $col['cedula'];
                                $validacionCerrandoNombres = $col['nombres'];
                                $validacionCerrandoApellidos = $col['apellidos'];
                                
                        if($usuarioPermisoMotivo == $validacionCerrando){
                             'IPD: '.$direccionIPEmpresa=$_SERVER['REMOTE_ADDR'];
                            $consulta = "UPDATE usuario SET descripcionPermiso='$motivoSolicitud', estadoPermiso='Pendiente', ipSolicitante='$direccionIPEmpresa'  WHERE cedula='$validacionCerrando' ";
                            $query = mysqli_query($con, $consulta);
                            
                            //// enviar correo alde IT
                                $consultaClienteSescion=$con->query("SELECT * FROM cliente ");
                                $extraerClienteSesion=$consultaClienteSescion->fetch_array(MYSQLI_ASSOC);
                                $correoIT=$extraerClienteSesion['email'];
                                            $to = $correoIT;
                                            $subject = "Autorización IP";
                                            $headers = "MIME-Version: 1.0" . "\r\n";
                                            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                            
                                            $message = "
                                            <html>
                                            <head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
                                            <title>HTML</title>
                                            </head>
                                            <body>
                                            <img src='https://fixwei.com/plataforma/pages/iconos/correo.png' width='200px' height='100px'><br>
                                            
                                            <p>Estimado (a). <b><em>Administrador</em></b>.
                                            <br>
                                            <p><b>Bienvenido (a) a FIXWEI, su aliado estratégico en gestión de procesos.</b></p>
                                            
                                            <p>El usuario <b><em>$validacionCerrandoNombres $validacionCerrandoApellidos</em></b>
                                             solicita autorización de registro de IP para acceder al sistema desde una red no habilitada.</p>.
                                            <br>
                                            Cualquier inquietud, contactarse a la empresa prestadora de servicio <a target='_black' href='http://fixwei.com'>Fixwei</a>
                                            <br><br>
                                            Este correo es informativo por tanto, le pedimos no responda este mensaje.
                                            </p>
                                            </body>
                                            </html>";
                                           /* 
                                            $message = "
                                            <html>
                                            <head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
                                            <title>HTML</title>
                                            </head>
                                            <body>
                                            <img src='http://fixwei.com/plataforma/dist/img/fondoLogin2.jpg' width='200px' height='100px'><br>
                                            
                                            <p>Estimado/a, Administrador
                                            <br><br>
                                            <p>El usuario <b>'$validacionCerrandoNombres' '$validacionCerrandoApellidos'</b>
                                             solicita autorización de registro de IP para acceder al sistema desde una red no habilitada.</p>.
                                            <br><br>
                                            Cualquier inquietud, contactarse a la empresa prestadora de servicio <a target='_black' href='http://fixwei.com'>Fixwei</a>
                                            <br><br>
                                            Atentamente, FIXWEI.
                                            <br><br>Importante. Este es un <b>aviso</b> enviado por la plataforma, por favor NO lo responda.
                                            </p>
                                            </body>
                                            </html>";*/
                                             
                                            $ejecutarEmail=mail($to, $subject, $message, $headers);
                                            /////////// Fin se envían los datos de creación de usuario a ese usuario
                            /// END
                            if($ejecutarEmail != NULL){
                                echo "<script language='javascript'>
                                window.location.href='login'</script>';";
                            }
                        }
        }
        
        /// END
    
?>
<!DOCTYPE html>
<html>
<head><meta charset="euc-jp">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Fixwei</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="icon" href="../iconos/correo.png">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
  <meta name="theme-color" content="#35214a">
  <meta name="MobileOptimized" content="width">
  <meta name="HandheldFriendly" content="true">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <link rel="manifest" href="manifest.json">
  
</head>

<body class="hold-transition login-page" oncopy="return false" onpaste="return false">
<div class="login-box">
  <div class="login-logo">
   
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Iniciar sesi&oacute;n</p>
            <?php 
                if($_POST['cerrandoCompleto'] != NULL){
                     ///  traemos el documento para separar la letra de los números
                    $documentoSoloNumero=substr($_POST['cerrandoCompleto'],0,-1);
                    /// END
                    $enviarCaracter=substr($_POST['cerrandoCompleto'],10,1);
                    if($enviarCaracter == 'C'){
                      $radioActivoCC='checked';
                    }else{
                      $radioActivoCE='checked';
                    }
                }
            ?>
      <form action="" method="post">
        <div class="" style="text-align:center;">
          CC
          <input type="radio" name="tipo" value="C" <?php echo $radioActivoCC;?> required>
          CE
          <input type="radio" name="tipo" value="E" <?php echo $radioActivoCE;?> required>
        </div>
        <br>
        <div class="input-group mb-3">
          <input type="number" class="form-control" placeholder="Usuario" value="<?php echo $documentoSoloNumero;?>" name="cedula" min="0" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" id="password" placeholder="Contrase&ntilde;a" name="password" required>
          
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          
        </div>
        <input type="checkbox" name="check_mostrar" onclick='handleClick(this);'> Mostrar contraseña<br>
        <script>
            function handleClick(cb) {
                  if(cb.checked)
                     $('#password').attr("type","text");
                  else
                    $('#password').attr("type","password");
                }
            
        </script>
        <div class="row">
          <div class="col-8">

          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" name="login" class="btn btn-primary btn-block">Iniciar</button>
          </div>
          <!-- /.col -->
        </div>
      </form> <!-- formtarget='_blank' -->
      

<!--
      <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div>
-->      
      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="login_recordar">Olvid&eacute; mi contrase&ntilde;a</a>
      </p>
      <!--
      <p class="mb-0">
        <a href="" class="text-center">Register a new membership</a>
      </p>
      -->
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- SweetAlert2 -->
<link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- SweetAlert2 -->
<script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
    <?php
    if($usuarioAdministradorBloqueado == 1){
    ?>
                    <div style="position: fixed;" id="cerrarA">
                        <div class="modal-dialog">
                          <div class="modal-content bg-danger">
                            <div class="modal-header">
                              <h4 class="modal-title">Alerta</h4>
                              <button type="button" id="closeA" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                                <div class="modal-body">
                                  <p>El administrador se encuentra bloqueado por superar la cantidad de intentos permitidos al igresar el código de seguridad,
                                  contacte a su proveedor para desbloquear el administrador.</p>
                                </div>
                          </div>
                        </div>
                    </div>
    <?php
    }    
    if($alertaSesionIP == 1){
    ?>
                    <div style="position: fixed;" id="cerrarA">
                        <div class="modal-dialog">
                          <div class="modal-content bg-danger">
                            <div class="modal-header">
                              <h4 class="modal-title">Alerta</h4>
                              <button type="button" id="closeA" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form action="" method="POST">
                                <div class="modal-body">
                                  <p>Esta intentando ingresar al sistema desde un dispositivo que no se encuentra registrado en la empresa.</p>
                                  <p>¿Desea solicitar permiso de ingreso?</p>
                                  <textarea class="form-control" name="motivoSolicitud" placeholder="Digite motivo de la solicitud..." required></textarea>
                                </div>
                             <!-- formulario para eliminar por el id -->
                                <div class="modal-footer justify-content-between">
                                    <input name="usuarioSolicitudPermiso" type="hidden" value="<?php echo $saleUsuarioCerrar;?>" >
                                    <button type="submit" name='solicitandoUsuarioPermiso' class="btn btn-outline-light">Si</button>
                                    <button type="button" id="CerrarPregunta" class="btn btn-outline-light" data-dismiss="modal">No</button>
                                </div>
                            </form>  
                             <!-- END formulario para eliminar por el id -->
                          </div>
                        </div>
                    </div>
    <?php
    }
    if($alertaSesion == 1){
    ?>
                    <div style="position: fixed;" id="cerrarA">
                        <div class="modal-dialog">
                          <div class="modal-content bg-danger">
                            <div class="modal-header">
                              <h4 class="modal-title">Alerta</h4>
                              <button type="button" id="closeA" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <p>El usuario ya cuenta con una sesión activa, ¿Desea cerrarla?</p>
                            </div>
                             <!-- formulario para eliminar por el id -->
                            <form action="" method="POST">
                                <div class="modal-footer justify-content-between">
                                    <input name="cerrandoCompleto" type="hidden" value="<?php echo $saleUsuarioCerrar;?>" readonly>
                                    <button type="submit" name='CerrandoUsuariosActual' class="btn btn-outline-light">Si</button>
                                    <button type="button" id="CerrarPregunta" class="btn btn-outline-light" data-dismiss="modal">No</button>
                                </div>
                            </form>
                             <!-- END formulario para eliminar por el id -->
                          </div>
                        </div>
                    </div>
    <?php
    }
    
    if($alertaSesionB == 1){
    ?>
                    <div style="position: fixed;" id="cerrarA">
                        <div class="modal-dialog">
                          <div class="modal-content bg-secondary">
                            <div class="modal-header">
                              <h4 class="modal-title">Alerta</h4>
                              <button type="button" id="closeA" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <p>Usuario o contraseña incorrectos.</p>
                            </div>
                             <!-- formulario para eliminar por el id -->
                            
                            <div class="modal-footer justify-content-between">
                             </div>
                             
                             <!-- END formulario para eliminar por el id -->
                          </div>
                        </div>
                    </div>
    <?php
    }
    
    if($alertaSesionB_existencia == 1){
    ?>
                    <div style="position: fixed;width:300px;" id="cerrarA">
                        <div class="modal-dialog">
                          <div class="modal-content bg-danger">
                            <div class="modal-header">
                              <h4 class="modal-title">Alerta</h4>
                              <button type="button" id="closeA" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <center>
                                <p>El usuario no existe.</p>
                              </center>
                            </div>
                             <!-- formulario para eliminar por el id -->
                            
                            <div class="modal-footer justify-content-between">
                             </div>
                             
                             <!-- END formulario para eliminar por el id -->
                          </div>
                        </div>
                    </div>
    <?php
    }
    
    if($alertaSesionC == 1){
    ?>
                    <div style="position: fixed;" id="cerrarA">
                        <div class="modal-dialog">
                          <div class="modal-content bg-danger">
                            <div class="modal-header">
                              <h4 class="modal-title">Alerta</h4>
                              <button type="button" id="closeA" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <p>El usuario no se encuentra activo, contacte con el administrador.</p>
                            </div>
                             <!-- formulario para eliminar por el id -->
                            
                            <div class="modal-footer justify-content-between">
                             </div>
                             
                             <!-- END formulario para eliminar por el id -->
                          </div>
                        </div>
                    </div>
    <?php
    }

    if($noPermitirCaracteresEspeciales == 1){
      ?>
      <div style="position: fixed;" id="cerrarA">
          <div class="modal-dialog">
            <div class="modal-content bg-danger">
              <div class="modal-header">
                <h4 class="modal-title">Alerta</h4>
                <button type="button" id="closeA" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>Cuidado está intentando alterar el fórmulario de ingreso, recuerde que estas acciones tienen consecuencias legales !, sú registro digital ha sido almacenado.</p>
              </div>
               <!-- formulario para eliminar por el id -->
              
              <div class="modal-footer justify-content-between">
               </div>
               
               <!-- END formulario para eliminar por el id -->
            </div>
          </div>
      </div>
<?php
} 



if($_POST['correoEnviado'] == '1'){
?>
<div style="position: fixed;" id="cerrarA">
          <div class="modal-dialog">
            <div class="modal-content bg-danger">
              <div class="modal-header">
                <h4 class="modal-title">Contraseña restablecida</h4>
                <button type="button" id="closeA" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>Verifique su clave temporal que fue enviada a su correo.</p>
              </div>
               <!-- formulario para eliminar por el id -->
              
              <div class="modal-footer justify-content-between">
               </div>
               
               <!-- END formulario para eliminar por el id -->
            </div>
          </div>
      </div>
<?php
}

if($_POST['correoNoEnviado'] == '1'){
?>
<div style="position: fixed;" id="cerrarA">
          <div class="modal-dialog">
            <div class="modal-content bg-danger">
              <div class="modal-header">
                <h4 class="modal-title">Alerta</h4>
                <button type="button" id="closeA" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>No se pudo reestablecer la contraseña, contacte al administrador.</p>
              </div>
               <!-- formulario para eliminar por el id -->
              
              <div class="modal-footer justify-content-between">
               </div>
               
               <!-- END formulario para eliminar por el id -->
            </div>
          </div>
      </div>
<?php
}

if($_POST['correoNoEncontrado'] == '1'){
    ?>
                    <div style="position: fixed;width:300px;" id="cerrarA">
                        <div class="modal-dialog">
                          <div class="modal-content bg-danger">
                            <div class="modal-header">
                              <h4 class="modal-title">Alerta</h4>
                              <button type="button" id="closeA" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <center>
                                <p>El usuario no existe.</p>
                              </center>
                            </div>
                             <!-- formulario para eliminar por el id -->
                            
                            <div class="modal-footer justify-content-between">
                             </div>
                             
                             <!-- END formulario para eliminar por el id -->
                          </div>
                        </div>
                    </div>
    <?php
    }
    
    ?>
    <script>
        $(document).ready(function(){
            $('#closeA').click(function(){
                document.getElementById('cerrarA').style.display = 'none';
            });
            $('#CerrarPregunta').click(function(){
                document.getElementById('cerrarA').style.display = 'none';
            });
            
        });
    </script>
<script type="text/javascript">
$(document).ready(function () {
   
    $('body').bind('cut copy paste', function (e) {
        e.preventDefault();
    });
   
   
    $("body").on("contextmenu",function(e){
        return false;
    });
});
</script>
<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>

<script>
    //// ingresamos el convertidor de pwa
    if ('serviceWorker' in navigator) {
      navigator.serviceWorker.register('./sw.js')
        .then(reg => console.log('Registro de SW exitoso', reg))
        .catch(err => console.warn('Error al tratar de registrar el sw', err))
    }
</script>

</body>
</html>
