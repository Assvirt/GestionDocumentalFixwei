<?php
require_once '../../conexion/bd.php';
 
 //echo 'variable plataforma: '.$radElabora;
 /// OJO, validar este campo cuando el aprobador rechaza el documento, no debe entrar a esta validación ////////////////////////////////////////////////////////
 
 if($radElabora == 'usuarios'){ //////////////// validando la notificacion cuando es usuario
 // echo '<br> validación 2..... No debe entrar acá cuando se rechaza el documento del aprobador'; //////////////////////////////////////// Mensaje de abvertencía
     $longitud = count($elaboraN);
        for($i=0; $i<$longitud; $i++){
            $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$elaboraN[$i]' ");
            $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
            $extraerCC=$columna['cedula']; echo '<br>';
           
           
           
            $extraerUsuarios = $mysqli->query("SELECT * FROM usuario WHERE cedula ='$extraerCC' ")or die(mysqli_error());
              //$usuariosCargo = $extraerUsuarios->fetch_array(MYSQLI_ASSOC);
              while($usuariosCargo = $extraerUsuarios->fetch_array()){
                 'EL USUARIO: <b>'.$nombredelUsuario=utf8_encode($usuariosCargo['nombres']).''.utf8_encode($usuariosCargo['apellidos']).'</b>';
                $consultaCedula=$usuariosCargo['cedula'];
                
                            ///////// luego se consulta con la cc del usuario a esta tabla para traer los id de los grupos por usuario
                            $consultaGrupos = $mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario ='$consultaCedula' ")or die(mysqli_error());
                            //$grupoUsuario = $consultaGrupos->fetch_array(MYSQLI_ASSOC);
                            while($grupoUsuario = $consultaGrupos->fetch_array()){
                            $idGrupo=$grupoUsuario['idGrupo'];
                            $validarUsuarioMensaje=$grupoUsuario['idUsuario'];
                            //echo '<br><br>Id de la tabla usuarioGrupo: <b>'.$idGrupo.'</b><br>';
                            
                                //////// luego con el id de la tabla usuarioGrupo se consulta la otra tabla para traer los nombres de los grupos y sus id del grupo para validar
                                $consultaGruposNombreId = $mysqli->query("SELECT * FROM grupo WHERE id ='$idGrupo' ")or die(mysqli_error());
                                $grupoUsuarioNombreId = $consultaGruposNombreId->fetch_array(MYSQLI_ASSOC);
                                    if($grupoUsuarioNombreId['nombre'] != NULL && $grupoUsuarioNombreId['id'] != NULL){
                                        $nombreValidandoGrupo=$grupoUsuarioNombreId['nombre'];
                                        $idGrupoValidando=$grupoUsuarioNombreId['id'];
                                    }else{
                                        $nombreValidandoGrupo='<b>No existe el id del grupo</b>';
                                        $idGrupoValidando='<b>No existe el id del grupo</b>';
                                    }
                                    'Nombre del grupo: '.$nombreValidandoGrupo.'</b><br>';
                                
                                    //////////// Luego vamos a consultar en los permisos de notificacion por el id del grupo del usuario
                                    $consultaGruposNotificacion = $mysqli->query("SELECT * FROM permisosNotificaciones WHERE idGrupo ='$idGrupoValidando' AND formulario='creacionDoc' ")or die(mysqli_error());
                                    $grupoUsuarioNotificacion = $consultaGruposNotificacion->fetch_array(MYSQLI_ASSOC);
                                    if($grupoUsuarioNotificacion['plataforma'] != NULL && $grupoUsuarioNotificacion['correo'] != NULL){
                                        $aceptoPlataforma+=$grupoUsuarioNotificacion['plataforma'];
                                        'Plataforma: <b>'.$grupoUsuarioNotificacion['plataforma'].'</b>';
                                        '<br>';
                                        $aceptoCorreo+=$grupoUsuarioNotificacion['correo'];
                                        'Correo: <b>'.$grupoUsuarioNotificacion['correo'].'</b>';
                                        
                                    }else{
                                        'Plataforma: <b>No existe</b>';
                                        '<br>';
                                        'Correo: <b>No existe</b><br><br>';        
                                    }
                                
                            }
                
                //////////////// al terminar la validaci��n pasamos a quienes se le envia el correo
                
                            
                            
                            
                  ///////// Enter para que no salga la informaci��n por usuario pegado                
                  echo '<br><br>';
              }   //// cierre del while
              
              
              if($aceptoCorreo > 0){
                       '<br>sale plataforma: '.$aceptoPlataforma;
                       '<br>sale correo: '.$aceptoCorreo;
                       '<br>sale cargo: '.$confirmacionNotificaciones=$encargado;
                      
                      /*
                      if($aceptoPlataforma > 0 && $aceptoCorreo > 0){
                          echo '<br>Sale enviar plataforma'.$aceptoPlataforma.' y correo'.$aceptoCorreo;
                      }elseif($aceptoCorreo > 0){
                          echo '<br>Sale enviar correo';
                      } 
                       */
                  
                 //////////////////// se agrega este campo para las actividades
                                    /////////// actividades de traer nombre de modulos de notificaciones
                                    $validandoNotificacions='creacionDoc';
                                    $plataformaH =$aceptoPlataforma;
                                    $correoH = $aceptoCorreo;
                                    /////////// fin proceso para traer el nombre del modulo en las notifiaciones
                                    
                                    //////////// datos para el correo
                                    $nombreUsuario = $mysqli->query("SELECT * FROM usuario WHERE cedula='$consultaCedula' ")or die(mysqli_error());
                                    //$col = $nombreUsuario->fetch_array(MYSQLI_ASSOC);
                                    while ($col = mysqli_fetch_array( $nombreUsuario )) {
                                    $nombreU = $col['nombres'];
                                    $apellidoU = $col['apellidos'];
                                     '<br>'.$correoU = $col['correo']; echo'<br>';
                                    //$correoU = $col['correo'];
                                    $usuarioH=utf8_encode($nombreU)." ".utf8_encode($apellidoU);
                                    //////////////// fin proceso datos para el correo
                                    
                                    /////////////// datos para traer validar el nombre del formulario
                                    $datosDelFormulario = $mysqli->query("SELECT id,nombre FROM formularios WHERE idFormulario='$validandoNotificacions' ")or die(mysqli_error());
                                    $col = $datosDelFormulario->fetch_array(MYSQLI_ASSOC);
                                    $nombreNV = $col['nombre'];
                                    /////////////// fin datos para traer validar el nombre del formulario
                                    
                                    
                                    if($correoH > 0 && $plataformaH > 0){
                                        
                                        /////// esta variable se usa para habilitar o desabilitar las notificaciones y diferenciar las solicitudes viejas con las nuevas
                                        $plataformaHabilitada1='1';
                                        ////// fin
                                       
                                        $minimo2=number_format($minimo,0,'.',',');
                                        $maximo2=number_format($maximo,0,'.',',');
                                        /////////// se env��an los datos de creaci��n de usuario a ese usuario
                                        /*
                                        $to = $correoU;
                                        $subject = "Se le notifica la creación del documento";
                                        $headers = "MIME-Version: 1.0" . "\r\n";
                                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                         
                                        $message = "
                                        <html>
                                        <head><meta>
                                        <title>HTML</title>
                                        </head>
                                        <body>
                                        <img src='http://fixwei.com/plataforma/dist/img/fondoLogin2.jpg' width='200px' height='100px'><br>
                                        
                                        <p>Estimado/a. <b>'$usuarioH'</b>.
                                        <br><br>Se procede a la creación del siguiente documento, '$nombreDocEnviar' 
                                        <br><br>
                                        Cualquier inquietud sobre la misma, por favor contactar a la empresa prestadora de servicio <a target='_black' href='http://fixwei.com/plataforma/pages/examples/login'>Fixwei</a>
                                        <br><br>
                                        Atentamente, FIXWEI.
                                        <br><br>Importante. Este es un <b>aviso</b> enviado por la plataforma, por favor NO lo responda.
                                        </p>
                                        </body>
                                        </html>";
                                         
                                        mail($to, $subject, $message, $headers);
                                        */
                                        /////////// Fin se env��an los datos de creaci��n de usuario a ese usuario
                                    }elseif($correoH > 0){
                                        
                                       // echo 'estos son los correos: '.$correoU; echo '<br>';
                                        $minimo2=number_format($minimo,0,'.',',');
                                        $maximo2=number_format($maximo,0,'.',',');
                                        /////////// se env��an los datos de creaci��n de usuario a ese usuario
                                        /*
                                        $to = $correoU;
                                        $subject = "Se le notifica la creación del documento";
                                        $headers = "MIME-Version: 1.0" . "\r\n";
                                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                         
                                        $message = "
                                        <html>
                                        <head>
                                        <title>HTML</title>
                                        </head>
                                        <body>
                                        <img src='http://fixwei.com/plataforma/dist/img/fondoLogin2.jpg' width='200px' height='100px'><br>
                                        
                                        <p>Estimado/a. <b>'$usuarioH'</b>.
                                        <br><br>Se procede a la creación del siguiente documento, '$nombreDocEnviar'
                                        <br><br>
                                        Cualquier inquietud sobre la misma, por favor contactar a la empresa prestadora de servicio <a target='_black' href='http://fixwei.com/plataforma/pages/examples/login'>Fixwei</a>
                                        <br><br>
                                        Atentamente, FIXWEI.
                                        <br><br>Importante. Este es un <b>aviso</b> enviado por la plataforma, por favor NO lo responda.
                                        </p>
                                        </body>
                                        </html>";
                                         
                                        mail($to, $subject, $message, $headers);
                                        */
                                    }
                                    
                                    
                                    }
                        ////////// fin del proceso   
                    
                      
                  }elseif($aceptoCorreo == 0){
                     
                      '<br>cargo: '.$confirmacionNotificaciones='0';
                       '<br>sale plataforma: '.$aceptoPlataforma;
                       '<br>sale cargo: '.$confirmacionNotificaciones=$encargado;
                      /*
                      if($aceptoPlataforma > 0 ){
                          echo '<br>Sale solamente enviar plataforma';
                      } */
                            /////// esta variable se usa para habilitar o desabilitar las notificaciones y diferenciar las solicitudes viejas con las nuevas 
                                    $plataformaH =$aceptoPlataforma;
                                    if($plataformaH > 0){
                                        $plataformaHabilitada2='1';
                                    }
                            ////// fin
                  } //////// finaliza la validacion del if AND elseif
        } ///////////// cierre del for
        
        
}else{ ////////////////////////////// validando la notificaci��n cuando es cargo
   
    
    //echo 'cargos';
    $longitud = count($elaboraN);
    for($i=0; $i<$longitud; $i++){
            $nombreuser = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos AS idElcargo,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$elaboraN[$i]' AND cargos.id_cargos=usuario.cargo ");
            $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
             $columna['nombreCargos']; echo '<br>';
            $estraerIdCargo=$columna['idElcargo'];
                
                    $extraerUsuarios = $mysqli->query("SELECT * FROM usuario WHERE cargo ='$estraerIdCargo' ")or die(mysqli_error());
                  //$usuariosCargo = $extraerUsuarios->fetch_array(MYSQLI_ASSOC);
                  while($usuariosCargo = $extraerUsuarios->fetch_array()){
                    'EL USUARIO: <b>'.$nombredelUsuario=$usuariosCargo['nombres'].''.$usuariosCargo['apellidos'].'</b>';
                    $consultaCedula=$usuariosCargo['cedula'];
                    
                                ///////// luego se consulta con la cc del usuario a esta tabla para traer los id de los grupos por usuario
                                $consultaGrupos = $mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario ='$consultaCedula' ")or die(mysqli_error());
                                //$grupoUsuario = $consultaGrupos->fetch_array(MYSQLI_ASSOC);
                                while($grupoUsuario = $consultaGrupos->fetch_array()){
                                $idGrupo=$grupoUsuario['idGrupo'];
                                $validarUsuarioMensaje=$grupoUsuario['idUsuario'];
                                //echo '<br><br>Id de la tabla usuarioGrupo: <b>'.$idGrupo.'</b><br>';
                                
                                    //////// luego con el id de la tabla usuarioGrupo se consulta la otra tabla para traer los nombres de los grupos y sus id del grupo para validar
                                    $consultaGruposNombreId = $mysqli->query("SELECT * FROM grupo WHERE id ='$idGrupo' ")or die(mysqli_error());
                                    $grupoUsuarioNombreId = $consultaGruposNombreId->fetch_array(MYSQLI_ASSOC);
                                        if($grupoUsuarioNombreId['nombre'] != NULL && $grupoUsuarioNombreId['id'] != NULL){
                                            $nombreValidandoGrupo=$grupoUsuarioNombreId['nombre'];
                                            $idGrupoValidando=$grupoUsuarioNombreId['id'];
                                        }else{
                                            $nombreValidandoGrupo='<b>No existe el id del grupo</b>';
                                            $idGrupoValidando='<b>No existe el id del grupo</b>';
                                        }
                                        'Nombre del grupo: '.$nombreValidandoGrupo.'</b><br>';
                                    
                                        //////////// Luego vamos a consultar en los permisos de notificacion por el id del grupo del usuario
                                        $consultaGruposNotificacion = $mysqli->query("SELECT * FROM permisosNotificaciones WHERE idGrupo ='$idGrupoValidando' AND formulario='creacionDoc' ")or die(mysqli_error());
                                        $grupoUsuarioNotificacion = $consultaGruposNotificacion->fetch_array(MYSQLI_ASSOC);
                                        if($grupoUsuarioNotificacion['plataforma'] != NULL && $grupoUsuarioNotificacion['correo'] != NULL){
                                            $aceptoPlataforma+=$grupoUsuarioNotificacion['plataforma'];
                                            'Plataforma: <b>'.$grupoUsuarioNotificacion['plataforma'].'</b>';
                                            '<br>';
                                            $aceptoCorreo+=$grupoUsuarioNotificacion['correo'];
                                            'Correo: <b>'.$grupoUsuarioNotificacion['correo'].'</b>';
                                            
                                        }else{
                                            'Plataforma: <b>No existe</b>';
                                            '<br>';
                                            'Correo: <b>No existe</b><br><br>';        
                                        }
                                    
                                }
                    
                    //////////////// al terminar la validaci��n pasamos a quienes se le envia el correo
                    ///////// Enter para que no salga la informaci��n por usuario pegado                
                      echo '<br><br>';
                  }       /// cierre del while
                  
                  
                  
                  
  
                  if($aceptoCorreo > 0){
                       '<br>sale plataforma: '.$aceptoPlataforma;
                       '<br>sale correo: '.$aceptoCorreo;
                       '<br>sale cargo: '.$confirmacionNotificaciones=$encargado;
                      
                      /*
                      if($aceptoPlataforma > 0 && $aceptoCorreo > 0){
                          echo '<br>Sale enviar plataforma'.$aceptoPlataforma.' y correo'.$aceptoCorreo;
                      }elseif($aceptoCorreo > 0){
                          echo '<br>Sale enviar correo';
                      } 
                       */
                  
                 //////////////////// se agrega este campo para las actividades
                                    /////////// actividades de traer nombre de modulos de notificaciones
                                    $validandoNotificacions='creacionDoc';
                                    $plataformaH =$aceptoPlataforma;
                                    $correoH = $aceptoCorreo;
                                    /////////// fin proceso para traer el nombre del modulo en las notifiaciones
                                    
                                    //////////// datos para el correo
                                    $nombreUsuario = $mysqli->query("SELECT * FROM usuario WHERE cargo='$estraerIdCargo' ")or die(mysqli_error());
                                    //$col = $nombreUsuario->fetch_array(MYSQLI_ASSOC);
                                    while ($col = mysqli_fetch_array( $nombreUsuario )) {
                                    $nombreU = $col['nombres'];
                                    $apellidoU = $col['apellidos'];
                                    '<br>'.$correoU = $col['correo']; echo'<br>';
                                    //$correoU = $col['correo'];
                                    $usuarioH=utf8_encode($nombreU)." ".utf8_encode($apellidoU);
                                    //////////////// fin proceso datos para el correo
                                    
                                    /////////////// datos para traer validar el nombre del formulario
                                    $datosDelFormulario = $mysqli->query("SELECT id,nombre FROM formularios WHERE idFormulario='$validandoNotificacions' ")or die(mysqli_error());
                                    $col = $datosDelFormulario->fetch_array(MYSQLI_ASSOC);
                                    $nombreNV = $col['nombre'];
                                    /////////////// fin datos para traer validar el nombre del formulario
                                    
                                    
                                    if($correoH > 0 && $plataformaH > 0){
                                        
                                        /////// esta variable se usa para habilitar o desabilitar las notificaciones y diferenciar las solicitudes viejas con las nuevas
                                        $plataformaHabilitada1='1';
                                        ////// fin
                                       
                                        $minimo2=number_format($minimo,0,'.',',');
                                        $maximo2=number_format($maximo,0,'.',',');
                                        /////////// se env��an los datos de creaci��n de usuario a ese usuario
                                        /*
                                        $to = $correoU;
                                        $subject = "Se le notifica la creación del documento";
                                        $headers = "From: Notificación Fixwei" . "\r\n";
                                        $headers .= "MIME-Version: 1.0" . "\r\n";
                                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                         
                                        $message = "
                                        <html>
                                        <head>
                                        <title>HTML</title>
                                        </head>
                                        <body>
                                        <img src='http://fixwei.com/plataforma/dist/img/fondoLogin2.jpg' width='200px' height='100px'><br>
                                        
                                        <p>Estimado/a. <b>'$usuarioH'</b>.
                                        <br><br>Se procede a la creación del siguiente documento, '$nombreDocEnviar' 
                                        <br><br>
                                        Cualquier inquietud sobre la misma, por favor contactar a la empresa prestadora de servicio <a target='_black' href='http://fixwei.com/plataforma/pages/examples/login'>Fixwei</a>
                                        <br><br>
                                        Atentamente, FIXWEI.
                                        <br><br>Importante. Este es un <b>aviso</b> enviado por la plataforma, por favor NO lo responda.
                                        </p>
                                        </body>
                                        </html>";
                                         
                                        mail($to, $subject, $message, $headers);
                                        */
                                        /////////// Fin se env��an los datos de creaci��n de usuario a ese usuario
                                    }elseif($correoH > 0){
                                        
                                       // echo 'estos son los correos: '.$correoU; echo '<br>';
                                        $minimo2=number_format($minimo,0,'.',',');
                                        $maximo2=number_format($maximo,0,'.',',');
                                        /////////// se env��an los datos de creaci��n de usuario a ese usuario
                                        /*
                                        $to = $correoU;
                                        $subject = "Se le notifica la creación del documento";
                                        $headers = "From: Notificación Fixwei" . "\r\n";
                                        $headers .= "MIME-Version: 1.0" . "\r\n";
                                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                         
                                        $message = "
                                        <html>
                                        <head>
                                        <title>HTML</title>
                                        </head>
                                        <body>
                                        <img src='http://fixwei.com/plataforma/dist/img/fondoLogin2.jpg' width='200px' height='100px'><br>
                                        
                                        <p>Estimado/a. <b>'$usuarioH'</b>.
                                        <br><br>Se procede a la creación del siguiente documento, '$nombreDocEnviar' 
                                        <br><br>
                                        Cualquier inquietud sobre la misma, por favor contactar a la empresa prestadora de servicio <a target='_black' href='http://fixwei.com/plataforma/pages/examples/login'>Fixwei</a>
                                        <br><br>
                                        Atentamente, FIXWEI.
                                        <br><br>Importante. Este es un <b>aviso</b> enviado por la plataforma, por favor NO lo responda.
                                        </p>
                                        </body>
                                        </html>";
                                         
                                        mail($to, $subject, $message, $headers);
                                        */
                                    }
                                    
                                    
                                    }
                        ////////// fin del proceso   
                    
                      
                  }elseif($aceptoCorreo == 0){
                     
                      '<br>cargo: '.$confirmacionNotificaciones='0';
                       '<br>sale plataforma: '.$aceptoPlataforma;
                       '<br>sale cargo: '.$confirmacionNotificaciones=$encargado;
                      /*
                      if($aceptoPlataforma > 0 ){
                          echo '<br>Sale solamente enviar plataforma';
                      } */
                            /////// esta variable se usa para habilitar o desabilitar las notificaciones y diferenciar las solicitudes viejas con las nuevas 
                                    $plataformaH =$aceptoPlataforma;
                                    if($plataformaH > 0){
                                        $plataformaHabilitada2='1';
                                    }
                            ////// fin
                  } //////// finaliza la validacion del if AND elseif
                  
        } // finaliza el for
} // finaliza el if de usuario y cargos


///////////  variable para almacenar
 if($radElabora != NULL){
              if($plataformaHabilitada1 > 0){
                  $plataformaHabilitada=$plataformaHabilitada1;
              }
              
              if($plataformaHabilitada2 > 0){
                  $plataformaHabilitada=$plataformaHabilitada2;
              }
              
              if($plataformaHabilitada1 == 0 && $plataformaHabilitada2 == 0){
                  $plataformaHabilitada='0';
              }
 }else{
     $plataformaHabilitada='vacio'; //// variable de recuperación de notificación
 } 
    '<br><font color="orange"> Habilitado quién crea: </font> '.$plataformaHabilitada.'<br><br>';
  //////
 ////////////////////////////////////// fin ------------------------------------------------------------ Final de quién debe CREAR   ///////////////////
  
   if($radRevisa == 'usuarios'){ //////////////// validando la notificacion cuando es usuario
    'entra a usuarios.<br><br>';
       $longitudR = count($revisaN);
        for($i=0; $i<$longitudR; $i++){
            $nombreuserR = $mysqli->query("SELECT * FROM usuario WHERE id = '$revisaN[$i]' ");
            $columnaR = $nombreuserR->fetch_array(MYSQLI_ASSOC);
             'Se extrae CC: '.$extraerCCR=$columnaR['cedula']; echo '<br>';
           
           
           
            $extraerUsuariosR = $mysqli->query("SELECT * FROM usuario WHERE cedula ='$extraerCCR' ")or die(mysqli_error());
              //$usuariosCargo = $extraerUsuarios->fetch_array(MYSQLI_ASSOC);
              while($usuariosCargoR = $extraerUsuariosR->fetch_array()){
                 'EL USUARIO: <b>'.$nombredelUsuario=$usuariosCargoR['nombres'].''.$usuariosCargoR['apellidos'].'</b>';
                $consultaCedulaR=$usuariosCargoR['cedula'];
                
                            ///////// luego se consulta con la cc del usuario a esta tabla para traer los id de los grupos por usuario
                            $consultaGruposR = $mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario ='$consultaCedulaR' ")or die(mysqli_error());
                            //$grupoUsuario = $consultaGrupos->fetch_array(MYSQLI_ASSOC);
                            while($grupoUsuarioR = $consultaGruposR->fetch_array()){
                            $idGrupoR=$grupoUsuarioR['idGrupo'];
                            $validarUsuarioMensajeR=$grupoUsuarioR['idUsuario'];
                             '<br><br>Id de la tabla usuarioGrupo: <b>'.$idGrupo.'</b><br>';
                            
                                //////// luego con el id de la tabla usuarioGrupo se consulta la otra tabla para traer los nombres de los grupos y sus id del grupo para validar
                                $consultaGruposNombreIdR = $mysqli->query("SELECT * FROM grupo WHERE id ='$idGrupoR' ")or die(mysqli_error());
                                $grupoUsuarioNombreIdR = $consultaGruposNombreIdR->fetch_array(MYSQLI_ASSOC);
                                    if($grupoUsuarioNombreIdR['nombre'] != NULL && $grupoUsuarioNombreIdR['id'] != NULL){
                                        $nombreValidandoGrupoR=$grupoUsuarioNombreIdR['nombre'];
                                        $idGrupoValidandoR=$grupoUsuarioNombreIdR['id'];
                                    }else{
                                        $nombreValidandoGrupoR='<b>No existe el id del grupo</b>';
                                        $idGrupoValidandoR='<b>No existe el id del grupo</b>';
                                    }
                                     'Nombre del grupo: '.$nombreValidandoGrupoR.'</b><br>';
                                
                                    //////////// Luego vamos a consultar en los permisos de notificacion por el id del grupo del usuario
                                    $consultaGruposNotificacionR = $mysqli->query("SELECT * FROM permisosNotificaciones WHERE idGrupo ='$idGrupoValidandoR' AND formulario='creacionDoc' ")or die(mysqli_error());
                                    $grupoUsuarioNotificacionR = $consultaGruposNotificacionR->fetch_array(MYSQLI_ASSOC);
                                    if($grupoUsuarioNotificacionR['plataforma'] != NULL && $grupoUsuarioNotificacionR['correo'] != NULL){
                                        $aceptoPlataformaR+=$grupoUsuarioNotificacionR['plataforma'];
                                         'Plataforma: <b>'.$grupoUsuarioNotificacionR['plataforma'].'</b>';
                                         '<br>';
                                        $aceptoCorreoR+=$grupoUsuarioNotificacionR['correo'];
                                         'Correo: <b>'.$grupoUsuarioNotificacionR['correo'].'</b>';
                                        
                                    }else{
                                         'Plataforma: <b>No existe</b>';
                                         '<br>';
                                         'Correo: <b>No existe</b><br><br>';        
                                    }
                                
                            }
                
                //////////////// al terminar la validaci��n pasamos a quienes se le envia el correo
                
                            
                            
                            
                  ///////// Enter para que no salga la informaci��n por usuario pegado                
                  echo '<br><br>';
              }   //// cierre del while
              
              
              if($aceptoCorreoR > 0){
                       '<br>sale plataforma: '.$aceptoPlataformaR;
                       '<br>sale correo: '.$aceptoCorreoR;
                       '<br>sale cargo: '.$confirmacionNotificacionesR=$encargadoR;
                      
                      /*
                      if($aceptoPlataforma > 0 && $aceptoCorreo > 0){
                          echo '<br>Sale enviar plataforma'.$aceptoPlataforma.' y correo'.$aceptoCorreo;
                      }elseif($aceptoCorreo > 0){
                          echo '<br>Sale enviar correo';
                      } 
                       */
                  
                 //////////////////// se agrega este campo para las actividades
                                    /////////// actividades de traer nombre de modulos de notificaciones
                                    $validandoNotificacionsR='creacionDoc';
                                    $plataformaHR =$aceptoPlataformaR;
                                    $correoHR = $aceptoCorreoR;
                                    /////////// fin proceso para traer el nombre del modulo en las notifiaciones
                                    
                                    //////////// datos para el correo
                                    $nombreUsuarioR = $mysqli->query("SELECT * FROM usuario WHERE cedula='$consultaCedula' ")or die(mysqli_error());
                                    //$col = $nombreUsuario->fetch_array(MYSQLI_ASSOC);
                                    while ($colR = mysqli_fetch_array( $nombreUsuarioR )) {
                                    $nombreUR = $colR['nombres'];
                                    $apellidoUR = $colR['apellidos'];
                                     '<br>'.$correoU = $colR['correo']; echo'<br>';
                                    //$correoU = $col['correo'];
                                    $usuarioHR=$nombreUR." ".$apellidoUR;
                                    //////////////// fin proceso datos para el correo
                                    
                                    /////////////// datos para traer validar el nombre del formulario
                                    $datosDelFormularioR = $mysqli->query("SELECT id,nombre FROM formularios WHERE idFormulario='$validandoNotificacionsR' ")or die(mysqli_error());
                                    $colR = $datosDelFormularioR->fetch_array(MYSQLI_ASSOC);
                                    $nombreNVR = $colR['nombre'];
                                    /////////////// fin datos para traer validar el nombre del formulario
                                    
                                    
                                    if($correoHR > 0 && $plataformaHR > 0){
                                        
                                        /////// esta variable se usa para habilitar o desabilitar las notificaciones y diferenciar las solicitudes viejas con las nuevas
                                        $plataformaHabilitadaR1='1';
                                        ////// fin
                                       
                                        
                                        /////////// Fin se env��an los datos de creaci��n de usuario a ese usuario
                                    }elseif($correoHR > 0){
                                        
                                    }
                                    
                                    
                                    }
                        ////////// fin del proceso   
                    
                      
                  }elseif($aceptoCorreoR == 0){
                     
                      '<br>cargo: '.$confirmacionNotificacionesR='0';
                       '<br>sale plataforma: '.$aceptoPlataformaR;
                       '<br>sale cargo: '.$confirmacionNotificacionesR=$encargadoR;
                      /*
                      if($aceptoPlataforma > 0 ){
                          echo '<br>Sale solamente enviar plataforma';
                      } */
                            /////// esta variable se usa para habilitar o desabilitar las notificaciones y diferenciar las solicitudes viejas con las nuevas 
                                    $plataformaHR =$aceptoPlataformaR;
                                    if($plataformaHR > 0){
                                        $plataformaHabilitadaR2='1';
                                    }
                            ////// fin
                  } //////// finaliza la validacion del if AND elseif
        } ///////////// cierre del for
        
        
}else{ ////////////////////////////// validando la notificaci��n cuando es cargo
   
    
    //echo 'cargos de revisar';
    $longitudR = count($revisaN);
    for($i=0; $i<$longitudR; $i++){
            $nombreuserR = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos AS idElcargo,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$revisaN[$i]' AND cargos.id_cargos=usuario.cargo ");
            $columnaR = $nombreuserR->fetch_array(MYSQLI_ASSOC);
            $columnaR['nombreCargos']; echo '<br>';
            $estraerIdCargoR=$columnaR['idElcargo'];
                
                    $extraerUsuariosR = $mysqli->query("SELECT * FROM usuario WHERE cargo ='$estraerIdCargoR' ")or die(mysqli_error());
                  //$usuariosCargo = $extraerUsuarios->fetch_array(MYSQLI_ASSOC);
                  while($usuariosCargoR = $extraerUsuariosR->fetch_array()){
                     'EL USUARIO: <b>'.$nombredelUsuarioR=$usuariosCargoR['nombres'].''.$usuariosCargoR['apellidos'].'</b>';
                    $consultaCedulaR=$usuariosCargoR['cedula'];
                    
                                ///////// luego se consulta con la cc del usuario a esta tabla para traer los id de los grupos por usuario
                                $consultaGruposR = $mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario ='$consultaCedulaR' ")or die(mysqli_error());
                                //$grupoUsuario = $consultaGrupos->fetch_array(MYSQLI_ASSOC);
                                while($grupoUsuarioR = $consultaGruposR->fetch_array()){
                                $idGrupoR=$grupoUsuarioR['idGrupo'];
                                $validarUsuarioMensajeR=$grupoUsuarioR['idUsuario'];
                                //echo '<br><br>Id de la tabla usuarioGrupo: <b>'.$idGrupo.'</b><br>';
                                
                                    //////// luego con el id de la tabla usuarioGrupo se consulta la otra tabla para traer los nombres de los grupos y sus id del grupo para validar
                                    $consultaGruposNombreIdR = $mysqli->query("SELECT * FROM grupo WHERE id ='$idGrupoR' ")or die(mysqli_error());
                                    $grupoUsuarioNombreIdR = $consultaGruposNombreIdR->fetch_array(MYSQLI_ASSOC);
                                        if($grupoUsuarioNombreIdR['nombre'] != NULL && $grupoUsuarioNombreIdR['id'] != NULL){
                                            $nombreValidandoGrupoR=$grupoUsuarioNombreIdR['nombre'];
                                            $idGrupoValidandoR=$grupoUsuarioNombreIdR['id'];
                                        }else{
                                            $nombreValidandoGrupoR='<b>No existe el id del grupo</b>';
                                            $idGrupoValidandoR='<b>No existe el id del grupo</b>';
                                        }
                                         'Nombre del grupo: '.$nombreValidandoGrupoR.'</b><br>';
                                    
                                        //////////// Luego vamos a consultar en los permisos de notificacion por el id del grupo del usuario
                                        $consultaGruposNotificacionR = $mysqli->query("SELECT * FROM permisosNotificaciones WHERE idGrupo ='$idGrupoValidandoR' AND formulario='creacionDoc' ")or die(mysqli_error());
                                        $grupoUsuarioNotificacionR = $consultaGruposNotificacionR->fetch_array(MYSQLI_ASSOC);
                                        if($grupoUsuarioNotificacionR['plataforma'] != NULL && $grupoUsuarioNotificacionR['correo'] != NULL){
                                            $aceptoPlataformaR+=$grupoUsuarioNotificacionR['plataforma'];
                                             'Plataforma: <b>'.$grupoUsuarioNotificacionR['plataforma'].'</b>';
                                             '<br>';
                                            $aceptoCorreoR+=$grupoUsuarioNotificacionR['correo'];
                                             'Correo: <b>'.$grupoUsuarioNotificacionR['correo'].'</b>';
                                            
                                        }else{
                                             'Plataforma: <b>No existe</b>';
                                             '<br>';
                                             'Correo: <b>No existe</b><br><br>';        
                                        }
                                    
                                }
                    
                    //////////////// al terminar la validaci��n pasamos a quienes se le envia el correo
                    ///////// Enter para que no salga la informaci��n por usuario pegado                
                      echo '<br><br>';
                  }       /// cierre del while
                  
                  
                  
                  
  
                  if($aceptoCorreoR > 0){
                       '<br>sale plataforma: '.$aceptoPlataformaR;
                       '<br>sale correo: '.$aceptoCorreoR;
                       '<br>sale cargo: '.$confirmacionNotificacionesR=$encargadoR;
                      
                      /*
                      if($aceptoPlataforma > 0 && $aceptoCorreo > 0){
                          echo '<br>Sale enviar plataforma'.$aceptoPlataforma.' y correo'.$aceptoCorreo;
                      }elseif($aceptoCorreo > 0){
                          echo '<br>Sale enviar correo';
                      } 
                       */
                  
                 //////////////////// se agrega este campo para las actividades
                                    /////////// actividades de traer nombre de modulos de notificaciones
                                    $validandoNotificacionsR='creacionDoc';
                                    $plataformaHR =$aceptoPlataformaR;
                                    $correoHR = $aceptoCorreoR;
                                    /////////// fin proceso para traer el nombre del modulo en las notifiaciones
                                    
                                    //////////// datos para el correo
                                    $nombreUsuarioR = $mysqli->query("SELECT * FROM usuario WHERE cargo='$estraerIdCargoR' ")or die(mysqli_error());
                                    //$col = $nombreUsuario->fetch_array(MYSQLI_ASSOC);
                                    while ($colR = mysqli_fetch_array( $nombreUsuarioR )) {
                                    $nombreUR = $colR['nombres'];
                                    $apellidoUR = $colR['apellidos'];
                                     '<br>'.$correoUR = $colR['correo']; echo'<br>';
                                    //$correoU = $col['correo'];
                                    $usuarioHR=$nombreUR." ".$apellidoUR;
                                    //////////////// fin proceso datos para el correo
                                    
                                    /////////////// datos para traer validar el nombre del formulario
                                    $datosDelFormularioR = $mysqli->query("SELECT id,nombre FROM formularios WHERE idFormulario='$validandoNotificacionsR' ")or die(mysqli_error());
                                    $colR = $datosDelFormularioR->fetch_array(MYSQLI_ASSOC);
                                    $nombreNVR = $colR['nombre'];
                                    /////////////// fin datos para traer validar el nombre del formulario
                                    
                                    
                                    if($correoHR > 0 && $plataformaHR > 0){
                                        
                                        /////// esta variable se usa para habilitar o desabilitar las notificaciones y diferenciar las solicitudes viejas con las nuevas
                                        $plataformaHabilitadaR1='1';
                                        ////// fin
                                       
                                        
                                        /////////// Fin se env��an los datos de creaci��n de usuario a ese usuario
                                    }elseif($correoH > 0){
                                        
                                    }
                                    
                                    
                                    }
                        ////////// fin del proceso   
                    
                      
                  }elseif($aceptoCorreoR == 0){
                     
                      '<br>cargo: '.$confirmacionNotificacionesR='0';
                       '<br>sale plataforma: '.$aceptoPlataformaR;
                       '<br>sale cargo: '.$confirmacionNotificacionesR=$encargadoR;
                      /*
                      if($aceptoPlataforma > 0 ){
                          echo '<br>Sale solamente enviar plataforma';
                      } */
                            /////// esta variable se usa para habilitar o desabilitar las notificaciones y diferenciar las solicitudes viejas con las nuevas 
                                    $plataformaHR =$aceptoPlataformaR;
                                    if($plataformaHR > 0){
                                        $plataformaHabilitadaR2='1';
                                    }
                            ////// fin
                  } //////// finaliza la validacion del if AND elseif
                  
        } // finaliza el for
} // finaliza el if de usuario y cargos
///////////  variable para almacenar
  
  if($radRevisa != NULL){
      if($plataformaHabilitadaR1 > 0){
        $plataformaHabilitadaRevisa=$plataformaHabilitadaR1;
      }
      
      if($plataformaHabilitadaR2 > 0){
       $plataformaHabilitadaRevisa=$plataformaHabilitadaR2;
      }
      
      if($plataformaHabilitadaR1 == 0 && $plataformaHabilitadaR2 == 0){
        $plataformaHabilitadaRevisa='0';
      }
  }else{
      $plataformaHabilitadaRevisa='vacio'; //// variable de recuperación de notificación
  }
   '<br><font color="blue">Habilitado quién revisa:</font> '.$plataformaHabilitadaRevisa.'<br><br>';
  //////
  ////////////////////////////////////// fin de la validación para los que revisan  ------------------------------------------------------------ ///////////////////
  



  if($radAprueba == 'usuarios'){ //////////////// validando la notificacion cuando es usuario
   
     $longitudA = count($apruebaA);
        for($i=0; $i<$longitudA; $i++){
            $nombreuserA = $mysqli->query("SELECT * FROM usuario WHERE id = '$apruebaA[$i]' ");
            $columnaA = $nombreuserA->fetch_array(MYSQLI_ASSOC);
            'ccS'.$extraerCCA=$columnaA['cedula']; echo '<br>';
           
           
           
            $extraerUsuariosA = $mysqli->query("SELECT * FROM usuario WHERE cedula ='$extraerCCA' ")or die(mysqli_error());
              //$usuariosCargo = $extraerUsuarios->fetch_array(MYSQLI_ASSOC);
              while($usuariosCargoA = $extraerUsuariosA->fetch_array()){
                 'EL USUARIO: <b>'.$nombredelUsuario=$usuariosCargoA['nombres'].''.$usuariosCargoA['apellidos'].'</b>';
                $consultaCedulaA=$usuariosCargoA['cedula'];
                
                            ///////// luego se consulta con la cc del usuario a esta tabla para traer los id de los grupos por usuario
                            $consultaGruposA = $mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario ='$consultaCedulaA' ")or die(mysqli_error());
                            //$grupoUsuario = $consultaGrupos->fetch_array(MYSQLI_ASSOC);
                            while($grupoUsuarioA = $consultaGruposA->fetch_array()){
                            $idGrupoA=$grupoUsuarioA['idGrupo'];
                            $validarUsuarioMensajeA=$grupoUsuarioA['idUsuario'];
                            //echo '<br><br>Id de la tabla usuarioGrupo: <b>'.$idGrupo.'</b><br>';
                            
                                //////// luego con el id de la tabla usuarioGrupo se consulta la otra tabla para traer los nombres de los grupos y sus id del grupo para validar
                                $consultaGruposNombreIdA = $mysqli->query("SELECT * FROM grupo WHERE id ='$idGrupoA' ")or die(mysqli_error());
                                $grupoUsuarioNombreIdA = $consultaGruposNombreIdA->fetch_array(MYSQLI_ASSOC);
                                    if($grupoUsuarioNombreIdA['nombre'] != NULL && $grupoUsuarioNombreIdA['id'] != NULL){
                                        $nombreValidandoGrupoA=$grupoUsuarioNombreIdA['nombre'];
                                        $idGrupoValidandoA=$grupoUsuarioNombreIdA['id'];
                                    }else{
                                        $nombreValidandoGrupoA='<b>No existe el id del grupo</b>';
                                        $idGrupoValidandoA='<b>No existe el id del grupo</b>';
                                    }
                                     'Nombre del grupo: '.$nombreValidandoGrupoA.'</b><br>';
                                
                                    //////////// Luego vamos a consultar en los permisos de notificacion por el id del grupo del usuario
                                    $consultaGruposNotificacionA = $mysqli->query("SELECT * FROM permisosNotificaciones WHERE idGrupo ='$idGrupoValidandoA' AND formulario='creacionDoc' ")or die(mysqli_error());
                                    $grupoUsuarioNotificacionA = $consultaGruposNotificacionA->fetch_array(MYSQLI_ASSOC);
                                    if($grupoUsuarioNotificacionA['plataforma'] != NULL && $grupoUsuarioNotificacionA['correo'] != NULL){
                                        $aceptoPlataformaA+=$grupoUsuarioNotificacionA['plataforma'];
                                         'Plataforma: <b>'.$grupoUsuarioNotificacionA['plataforma'].'</b>';
                                         '<br>';
                                        $aceptoCorreoA+=$grupoUsuarioNotificacionA['correo'];
                                         'Correo: <b>'.$grupoUsuarioNotificacionA['correo'].'</b>';
                                        
                                    }else{
                                         'Plataforma: <b>No existe</b>';
                                         '<br>';
                                         'Correo: <b>No existe</b><br><br>';        
                                    }
                                
                            }
                
                //////////////// al terminar la validaci��n pasamos a quienes se le envia el correo
                
                            
                            
                            
                  ///////// Enter para que no salga la informaci��n por usuario pegado                
                  echo '<br><br>';
              }   //// cierre del while
              
              
              if($aceptoCorreoA > 0){
                       '<br>sale plataforma: '.$aceptoPlataformaA;
                       '<br>sale correo: '.$aceptoCorreoA;
                       '<br>sale cargo: '.$confirmacionNotificacionesA=$encargadoA;
                      
                      /*
                      if($aceptoPlataforma > 0 && $aceptoCorreo > 0){
                          echo '<br>Sale enviar plataforma'.$aceptoPlataforma.' y correo'.$aceptoCorreo;
                      }elseif($aceptoCorreo > 0){
                          echo '<br>Sale enviar correo';
                      } 
                       */
                  
                 //////////////////// se agrega este campo para las actividades
                                    /////////// actividades de traer nombre de modulos de notificaciones
                                    $validandoNotificacionsA='creacionDoc';
                                    $plataformaHA =$aceptoPlataformaA;
                                    $correoHA = $aceptoCorreoA;
                                    /////////// fin proceso para traer el nombre del modulo en las notifiaciones
                                    
                                    //////////// datos para el correo
                                    $nombreUsuarioA = $mysqli->query("SELECT * FROM usuario WHERE cedula='$consultaCedulaA' ")or die(mysqli_error());
                                    //$col = $nombreUsuario->fetch_array(MYSQLI_ASSOC);
                                    while ($colA = mysqli_fetch_array( $nombreUsuarioA )) {
                                    $nombreUA = $colA['nombres'];
                                    $apellidoUA = $colA['apellidos'];
                                     '<br>'.$correoU = $colA['correo']; echo'<br>';
                                    //$correoU = $col['correo'];
                                    $usuarioHA=utf8_encode($nombreUA)." ".utf8_encode($apellidoUA);
                                    //////////////// fin proceso datos para el correo
                                    
                                    /////////////// datos para traer validar el nombre del formulario
                                    $datosDelFormularioA = $mysqli->query("SELECT id,nombre FROM formularios WHERE idFormulario='$validandoNotificacionsA' ")or die(mysqli_error());
                                    $colA = $datosDelFormularioA->fetch_array(MYSQLI_ASSOC);
                                    $nombreNVA = $colA['nombre'];
                                    /////////////// fin datos para traer validar el nombre del formulario
                                    
                                    
                                    if($correoHA > 0 && $plataformaHA > 0){
                                        
                                        /////// esta variable se usa para habilitar o desabilitar las notificaciones y diferenciar las solicitudes viejas con las nuevas
                                        $plataformaHabilitadaA1='1';
                                        ////// fin
                                       
                                        
                                        /////////// Fin se env��an los datos de creaci��n de usuario a ese usuario
                                    }elseif($correoHA > 0){
                                        
                                    }
                                    
                                    
                                    }
                        ////////// fin del proceso   
                    
                      
                  }elseif($aceptoCorreoA == 0){
                     
                      '<br>cargo: '.$confirmacionNotificacionesA='0';
                       '<br>sale plataforma: '.$aceptoPlataformaA;
                       '<br>sale cargo: '.$confirmacionNotificacionesA=$encargadoA;
                      /*
                      if($aceptoPlataforma > 0 ){
                          echo '<br>Sale solamente enviar plataforma';
                      } */
                            /////// esta variable se usa para habilitar o desabilitar las notificaciones y diferenciar las solicitudes viejas con las nuevas 
                                    $plataformaHA =$aceptoPlataformaA;
                                    if($plataformaHA > 0){
                                      $plataformaHabilitadaA2='1';
                                    }
                            ////// fin
                  } //////// finaliza la validacion del if AND elseif
        } ///////////// cierre del for
        
        
}else{ ////////////////////////////// validando la notificaci��n cuando es cargo
   
    
    //echo 'cargos de revisar';
    $longitudA = count($apruebaA);
    for($i=0; $i<$longitudA; $i++){
            $nombreuserA = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos AS idElcargo,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$apruebaA[$i]' AND cargos.id_cargos=usuario.cargo ");
            $columnaA = $nombreuserA->fetch_array(MYSQLI_ASSOC);
            $columnaA['nombreCargos']; echo '<br>';
            $estraerIdCargoA=$columnaA['idElcargo'];
                
                    $extraerUsuariosA = $mysqli->query("SELECT * FROM usuario WHERE cargo ='$estraerIdCargoA' ")or die(mysqli_error());
                  //$usuariosCargo = $extraerUsuarios->fetch_array(MYSQLI_ASSOC);
                  while($usuariosCargoA = $extraerUsuariosA->fetch_array()){
                     'EL USUARIO A: <b>'.$nombredelUsuarioA=$usuariosCargoA['nombres'].''.$usuariosCargoA['apellidos'].'</b>';
                    $consultaCedulaA=$usuariosCargoA['cedula'];
                    
                                ///////// luego se consulta con la cc del usuario a esta tabla para traer los id de los grupos por usuario
                                $consultaGruposA = $mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario ='$consultaCedulaA' ")or die(mysqli_error());
                                //$grupoUsuario = $consultaGrupos->fetch_array(MYSQLI_ASSOC);
                                while($grupoUsuarioA = $consultaGruposA->fetch_array()){
                                $idGrupoA=$grupoUsuarioA['idGrupo'];
                                $validarUsuarioMensajeA=$grupoUsuarioA['idUsuario'];
                                //echo '<br><br>Id de la tabla usuarioGrupo: <b>'.$idGrupo.'</b><br>';
                                
                                    //////// luego con el id de la tabla usuarioGrupo se consulta la otra tabla para traer los nombres de los grupos y sus id del grupo para validar
                                    $consultaGruposNombreIdA = $mysqli->query("SELECT * FROM grupo WHERE id ='$idGrupoA' ")or die(mysqli_error());
                                    $grupoUsuarioNombreIdA = $consultaGruposNombreIdA->fetch_array(MYSQLI_ASSOC);
                                        if($grupoUsuarioNombreIdA['nombre'] != NULL && $grupoUsuarioNombreIdA['id'] != NULL){
                                            $nombreValidandoGrupoA=$grupoUsuarioNombreIdA['nombre'];
                                            $idGrupoValidandoA=$grupoUsuarioNombreIdA['id'];
                                        }else{
                                            $nombreValidandoGrupoA='<b>No existe el id del grupo</b>';
                                            $idGrupoValidandoA='<b>No existe el id del grupo</b>';
                                        }
                                         'Nombre del grupo: '.$nombreValidandoGrupoA.'</b><br>';
                                    
                                        //////////// Luego vamos a consultar en los permisos de notificacion por el id del grupo del usuario
                                        $consultaGruposNotificacionA = $mysqli->query("SELECT * FROM permisosNotificaciones WHERE idGrupo ='$idGrupoValidandoA' AND formulario='creacionDoc' ")or die(mysqli_error());
                                        $grupoUsuarioNotificacionA = $consultaGruposNotificacionA->fetch_array(MYSQLI_ASSOC);
                                        if($grupoUsuarioNotificacionA['plataforma'] != NULL && $grupoUsuarioNotificacionA['correo'] != NULL){
                                            $aceptoPlataformaA+=$grupoUsuarioNotificacionA['plataforma'];
                                             'Plataforma A: <b>'.$grupoUsuarioNotificacionA['plataforma'].'</b>';
                                             '<br>';
                                            $aceptoCorreoA+=$grupoUsuarioNotificacionA['correo'];
                                             'Correo A: <b>'.$grupoUsuarioNotificacionA['correo'].'</b>';
                                            
                                        }else{
                                             'Plataforma: <b>No existe</b>';
                                             '<br>';
                                             'Correo: <b>No existe</b><br><br>';        
                                        }
                                    
                                }
                    
                    //////////////// al terminar la validaci��n pasamos a quienes se le envia el correo
                    ///////// Enter para que no salga la informaci��n por usuario pegado                
                      echo '<br><br>';
                  }       /// cierre del while
                  
                  
                  
                  
  
                  if($aceptoCorreoA > 0){
                       '<br>sale plataforma: '.$aceptoPlataformaA;
                       '<br>sale correo: '.$aceptoCorreoA;
                       '<br>sale cargo: '.$confirmacionNotificacionesA=$encargadoA;
                      
                      /*
                      if($aceptoPlataforma > 0 && $aceptoCorreo > 0){
                          echo '<br>Sale enviar plataforma'.$aceptoPlataforma.' y correo'.$aceptoCorreo;
                      }elseif($aceptoCorreo > 0){
                          echo '<br>Sale enviar correo';
                      } 
                       */
                  
                 //////////////////// se agrega este campo para las actividades
                                    /////////// actividades de traer nombre de modulos de notificaciones
                                    $validandoNotificacionsA='creacionDoc';
                                    $plataformaHA =$aceptoPlataformaA;
                                    $correoHA = $aceptoCorreoA;
                                    /////////// fin proceso para traer el nombre del modulo en las notifiaciones
                                    
                                    //////////// datos para el correo
                                    $nombreUsuarioA = $mysqli->query("SELECT * FROM usuario WHERE cargo='$estraerIdCargoA' ")or die(mysqli_error());
                                    //$col = $nombreUsuario->fetch_array(MYSQLI_ASSOC);
                                    while ($colA = mysqli_fetch_array( $nombreUsuarioA )) {
                                    $nombreUA = $colA['nombres'];
                                    $apellidoUA = $colA['apellidos'];
                                     '<br>'.$correoUA = $colA['correo']; echo'<br>';
                                    //$correoU = $col['correo'];
                                    $usuarioHA=utf8_encode($nombreUA)." ".utf8_encode($apellidoUA);
                                    //////////////// fin proceso datos para el correo
                                    
                                    /////////////// datos para traer validar el nombre del formulario
                                    $datosDelFormularioA = $mysqli->query("SELECT id,nombre FROM formularios WHERE idFormulario='$validandoNotificacionsA' ")or die(mysqli_error());
                                    $colA = $datosDelFormularioA->fetch_array(MYSQLI_ASSOC);
                                    $nombreNVA = $colA['nombre'];
                                    /////////////// fin datos para traer validar el nombre del formulario
                                    
                                    
                                    if($correoHA > 0 && $plataformaHA > 0){
                                        
                                        /////// esta variable se usa para habilitar o desabilitar las notificaciones y diferenciar las solicitudes viejas con las nuevas
                                        $plataformaHabilitadaA1='1';
                                        ////// fin
                                       
                                       
                                        /////////// Fin se env��an los datos de creaci��n de usuario a ese usuario
                                    }elseif($correoHA > 0){
                                        
                                    }
                                    
                                    
                                    }
                        ////////// fin del proceso   
                    
                      
                  }elseif($aceptoCorreoA == 0){
                     
                      '<br>cargo: '.$confirmacionNotificacionesA='0';
                       '<br>sale plataforma: '.$aceptoPlataformaA;
                       '<br>sale cargo: '.$confirmacionNotificacionesA=$encargadoA;
                      /*
                      if($aceptoPlataforma > 0 ){
                          echo '<br>Sale solamente enviar plataforma';
                      } */
                            /////// esta variable se usa para habilitar o desabilitar las notificaciones y diferenciar las solicitudes viejas con las nuevas 
                                    $plataformaHA =$aceptoPlataformaA;
                                    if($plataformaHA > 0){
                                        $plataformaHabilitadaA2='1';
                                    }
                            ////// fin
                  } //////// finaliza la validacion del if AND elseif
                  
        } // finaliza el for
} // finaliza el if de usuario y cargos


  ///////////  variable para almacenar
  if($radAprueba != NULL){
      if($plataformaHabilitadaA1 > 0){
        $plataformaHabilitadaAprueba=$plataformaHabilitadaA1;
      }
      
      if($plataformaHabilitadaA2 > 0){
       $plataformaHabilitadaAprueba=$plataformaHabilitadaA2;
      }
      
      if($plataformaHabilitadaA1 == 0 && $plataformaHabilitadaA2 == 0){
        $plataformaHabilitadaAprueba='0';
      }
  }else{
      $plataformaHabilitadaAprueba='vacio'; //// variable de recuperación de notificación
  }
   '<br><font color="red">Habilitado quién aprueba:</font> '.$plataformaHabilitadaAprueba;
  //////
  ////////////////////////////////////// fin de la validación para los que aprueban  ------------------------------------------------------------ /////////////////// 
        
        
        //echo 'crear: '.$plataformaHabilitada.' Revisar: '.$plataformaHabilitadaRevisa.' Aprobar: '.$plataformaHabilitadaAprueba;
        
        //echo $consecutivo;
        
?>