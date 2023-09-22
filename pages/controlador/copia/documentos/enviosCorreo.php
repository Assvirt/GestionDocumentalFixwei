<?php
error_reporting(E_ERROR);
    
    //$estado=$_POST['estado'];
    
    
   /*
   
                                                        
    $radElabora = $_POST['radiobtnE'];//quien cita
    $revisaE = $_POST['select_encargadoE'];//Quien elabora
    json_encode($revisaE);
    
    
    $radRevisa = $_POST['radiobtnR'];//quien cita
    $revisaN = $_POST['select_encargadoR'];//Quien revisa
    json_encode($revisaN);
    
    $radAprueba = $_POST['radiobtnA'];//quien cita
    $apruebaA = $_POST['select_encargadoA'];//Quien aprueba
    json_encode($apruebaA);
   */
    
    /*
    $aprueba = unserialize($_POST['select_encargadoA']);
    $apruebaA = unserialize($_POST['select_encargadoA']); // para la notificación aprobar
    $radAprueba = $_POST['radiobtnA'];
    array_unshift($aprueba,$radAprueba);
    $aprueba = json_encode($aprueba);
    */
if($estado == 'Pendiente'){
    $tipoProcesoNombre='Creación';
}
if($estado == 'Elaborado'){
    $tipoProcesoNombre='Revisión';
}
if($estado == 'Revisado'){
    $tipoProcesoNombre='Aprobación';
}
    

    //$nombreDocEnviar='tipo proceso';

if($estado == 'Pendiente'){
    
    echo 'El estado del documento se encuentra: '.$estado.' y entra los '.$radElabora.'<br>';

        if($radElabora == 'usuarios'){ //////////////// validando la notificacion cuando es usuario
           ///echo '<br>entra a usuarios.<br>';
          //print_r($revisaE);
               $longitudE = count($elabora);
                for($i=0; $i<$longitudE; $i++){
                    $nombreuserR = $mysqli->query("SELECT * FROM usuario WHERE id = '$elabora[$i]' ");
                    $columnaR = $nombreuserR->fetch_array(MYSQLI_ASSOC);
                     'Se extrae CC: '.$extraerCCR=$columnaR['cedula']; echo '<br>';
                   
                   
                   
                    $extraerUsuariosR = $mysqli->query("SELECT * FROM usuario WHERE cedula ='$extraerCCR' ")or die(mysqli_error());
                      //$usuariosCargo = $extraerUsuarios->fetch_array(MYSQLI_ASSOC);
                      while($usuariosCargoR = $extraerUsuariosR->fetch_array()){
                        echo 'EL USUARIO: <b>'.$nombredelUsuario0=$usuariosCargoR['nombres'].' '.$usuariosCargoR['apellidos'].'</b>';
                        $nombredelUsuario=utf8_encode($nombredelUsuario0);
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
                                             '<br>Nombre del grupo: '.$nombreValidandoGrupoR.'</b><br>';
                                        
                                            //////////// Luego vamos a consultar en los permisos de notificacion por el id del grupo del usuario
                                            $consultaGruposNotificacionR = $mysqli->query("SELECT * FROM permisosNotificaciones WHERE idGrupo ='$idGrupoValidandoR' AND formulario='creacionDoc' ")or die(mysqli_error());
                                            $grupoUsuarioNotificacionR = $consultaGruposNotificacionR->fetch_array(MYSQLI_ASSOC);
                                            if($grupoUsuarioNotificacionR['plataforma'] != NULL && $grupoUsuarioNotificacionR['correo'] != NULL){
                                                $aceptoPlataformaR+=$grupoUsuarioNotificacionR['plataforma'];
                                                 'Plataforma: <b>'.$grupoUsuarioNotificacionR['plataforma'].'</b>';
                                                
                                                $aceptoCorreoR=$grupoUsuarioNotificacionR['correo']; /// variable anterior $aceptoCorreoR+
                                                 '<br>Correo: <b>'.$grupoUsuarioNotificacionR['correo'].'</b>';
                                                
                                                if($aceptoCorreoR > 0){
                                                     '<br>al correo que debería enviar: ';
                                                       
                                                        $minimo2=number_format($minimo,0,'.',',');
                                                        $maximo2=number_format($maximo,0,'.',',');
                                                        /////////// se env��an los datos de creaci��n de usuario a ese usuario
                                                        
                                                        echo $to = $usuariosCargoR['correo'];
                                                        
                                                        $subject = "Se le notifica la '$tipoProceso' del documento";
                                                        $headers = "MIME-Version: 1.0" . "\r\n";
                                                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                                        
                                                        
                                                        
                                                         
                                                        $message = "
                                                        <html>
                                                        <head><meta>
                                                        <title>HTML</title>
                                                        </head>
                                                        <body>
                                                        <img src='http://fixwei.com/plataforma/dist/img/fondoLogin2.jpg' width='200px' height='100px'><br>
                                                        
                                                        <p>Estimado/a. <b>'$nombredelUsuario'</b>.
                                                        <br><br>Se procede a realizar la '$tipoProcesoNombre' del siguiente documento, '$nombreDocEnviar' 
                                                        <br><br>
                                                        Cualquier inquietud sobre la misma, por favor contactar a la empresa prestadora de servicio <a target='_black' href='http://fixwei.com/plataforma/pages/examples/login'>Fixwei</a>
                                                        <br><br>
                                                        Atentamente, FIXWEI.
                                                        <br><br>Importante. Este es un <b>aviso</b> enviado por la plataforma, por favor NO lo responda.
                                                        </p>
                                                        </body>
                                                        </html>";
                                                         
                                                        mail($to, $subject, $message, $headers);
                                                        
                                                        /////////// Fin se env��an los datos de creaci��n de usuario a ese usuario

                                                }
                                                
                                            }else{
                                                 'Plataforma: <b>No existe</b>';
                                                echo '<br>';
                                                 'Correo: <b>No existe</b><br><br>';        
                                            }
                                        
                                    }
                        
                        //////////////// al terminar la validaci��n pasamos a quienes se le envia el correo
                        
                                    
                                    
                                    
                          ///////// Enter para que no salga la informaci��n por usuario pegado                
                          echo '<br>';
                      }   //// cierre del while
                      
                      
                } ///////////// cierre del for
                
                
        }else{ ////////////////////////////// validando la notificaci��n cuando es cargo
           
            
            //echo 'cargos de revisar';
            $longitudE = count($elabora);
            for($i=0; $i<$longitudE; $i++){
                    $nombreuserR = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos AS idElcargo,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$elabora[$i]' AND cargos.id_cargos=usuario.cargo ");
                    $columnaR = $nombreuserR->fetch_array(MYSQLI_ASSOC);
                     '<br>'.$columnaR['nombreCargos']; echo '<br>';
                    $estraerIdCargoR=$columnaR['idElcargo'];
                        
                            $extraerUsuariosR = $mysqli->query("SELECT * FROM usuario WHERE cargo ='$estraerIdCargoR' ")or die(mysqli_error());
                          //$usuariosCargo = $extraerUsuarios->fetch_array(MYSQLI_ASSOC);
                          while($usuariosCargoR = $extraerUsuariosR->fetch_array()){
                            echo 'EL USUARIO: <b>'.$nombredelUsuarioR0=$usuariosCargoR['nombres'].' '.$usuariosCargoR['apellidos'].'</b>';
                            $nombredelUsuarioR=utf8_encode($nombredelUsuarioR0);
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
                                                    
                                                    $aceptoCorreoR=$grupoUsuarioNotificacionR['correo']; /// variable anterior $aceptoCorreoR+
                                                     'Correo: <b>'.$grupoUsuarioNotificacionR['correo'].'</b>';
                                                    
                                                    
                                                    if($aceptoCorreoR > 0){
                                                         '<br>Al que debería enviar el correo: ';
                                                
                                                        $minimo2=number_format($minimo,0,'.',',');
                                                        $maximo2=number_format($maximo,0,'.',',');
                                                        /////////// se env��an los datos de creaci��n de usuario a ese usuario
                                                        
                                                        
                                                        echo $to = $usuariosCargoR['correo'];
                                                        
                                                        $subject = "Se le notifica la '$tipoProceso' de documento";
                                                        $headers = "MIME-Version: 1.0" . "\r\n";
                                                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                                         
                                                        $message = "
                                                        <html>
                                                        <head>
                                                        <title>HTML</title>
                                                        </head>
                                                        <body>
                                                        <img src='http://fixwei.com/plataforma/dist/img/fondoLogin2.jpg' width='200px' height='100px'><br>
                                                        
                                                        <p>Estimado/a. <b>'$nombredelUsuarioR'</b>.
                                                        <br><br>Se procede a realizar la '$tipoProcesoNombre' del siguiente documento, '$nombreDocEnviar' 
                                                        <br><br>
                                                        Cualquier inquietud sobre la misma, por favor contactar a la empresa prestadora de servicio <a target='_black' href='http://fixwei.com/plataforma/pages/examples/login'>Fixwei</a>
                                                        <br><br>
                                                        Atentamente, FIXWEI.
                                                        <br><br>Importante. Este es un <b>aviso</b> enviado por la plataforma, por favor NO lo responda.
                                                        </p>
                                                        </body>
                                                        </html>";
                                                         
                                                        mail($to, $subject, $message, $headers);
                                                        
                                                        /////////// Fin se env��an los datos de creaci��n de usuario a ese usuario
                                                    }
                                                    
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
                          
                } // finaliza el for
        } // finaliza el if de usuario y cargos
    
          //////
          ////////////////////////////////////// fin de la validación para los que revisan  ------------------------------------------------------------ ///////////////////
} 

if($estado == 'Elaborado'){
    
    echo 'El estado del documento se encuentra: '.$estado.' y entra los '.$radRevisa.'<br>';

        if($radRevisa == 'usuarios'){ //////////////// validando la notificacion cuando es usuario
           //echo '<br>entra a usuarios.<br>';
               $longitudR = count($revisa);
                for($i=0; $i<$longitudR; $i++){
                    $nombreuserR = $mysqli->query("SELECT * FROM usuario WHERE id = '$revisa[$i]' ");
                    $columnaR = $nombreuserR->fetch_array(MYSQLI_ASSOC);
                     'Se extrae CC: '.$extraerCCR=$columnaR['cedula']; echo '<br>';
                   
                   
                   
                    $extraerUsuariosR = $mysqli->query("SELECT * FROM usuario WHERE cedula ='$extraerCCR' ")or die(mysqli_error());
                      //$usuariosCargo = $extraerUsuarios->fetch_array(MYSQLI_ASSOC);
                      while($usuariosCargoR = $extraerUsuariosR->fetch_array()){
                        echo 'EL USUARIO: <b>'.$nombredelUsuari0=$usuariosCargoR['nombres'].' '.$usuariosCargoR['apellidos'].'</b>';
                        $nombredelUsuario=utf8_encode($nombredelUsuari0);
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
                                             '<br>Nombre del grupo: '.$nombreValidandoGrupoR.'</b><br>';
                                        
                                            //////////// Luego vamos a consultar en los permisos de notificacion por el id del grupo del usuario
                                            $consultaGruposNotificacionR = $mysqli->query("SELECT * FROM permisosNotificaciones WHERE idGrupo ='$idGrupoValidandoR' AND formulario='creacionDoc' ")or die(mysqli_error());
                                            $grupoUsuarioNotificacionR = $consultaGruposNotificacionR->fetch_array(MYSQLI_ASSOC);
                                            if($grupoUsuarioNotificacionR['plataforma'] != NULL && $grupoUsuarioNotificacionR['correo'] != NULL){
                                                $aceptoPlataformaR+=$grupoUsuarioNotificacionR['plataforma'];
                                                 'Plataforma: <b>'.$grupoUsuarioNotificacionR['plataforma'].'</b>';
                                                
                                                $aceptoCorreoR=$grupoUsuarioNotificacionR['correo']; /// variable anterior $aceptoCorreoR+
                                                 '<br>Correo: <b>'.$grupoUsuarioNotificacionR['correo'].'</b>';
                                                
                                                if($aceptoCorreoR > 0){
                                                     '<br>al correo que debería enviar: ';
                                                       
                                                        $minimo2=number_format($minimo,0,'.',',');
                                                        $maximo2=number_format($maximo,0,'.',',');
                                                        /////////// se env��an los datos de creaci��n de usuario a ese usuario
                                                        
                                                        echo $to = $usuariosCargoR['correo'];
                                                        
                                                        $subject = "Se le notifica la '$tipoProceso' del documento";
                                                        $headers = "MIME-Version: 1.0" . "\r\n";
                                                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                                         
                                                        $message = "
                                                        <html>
                                                        <head><meta>
                                                        <title>HTML</title>
                                                        </head>
                                                        <body>
                                                        <img src='http://fixwei.com/plataforma/dist/img/fondoLogin2.jpg' width='200px' height='100px'><br>
                                                        
                                                        <p>Estimado/a. <b>'$nombredelUsuario'</b>.
                                                        <br><br>Se procede a realizar la '$tipoProcesoNombre' del siguiente documento, '$nombreDocEnviar' 
                                                        <br><br>
                                                        Cualquier inquietud sobre la misma, por favor contactar a la empresa prestadora de servicio <a target='_black' href='http://fixwei.com/plataforma/pages/examples/login'>Fixwei</a>
                                                        <br><br>
                                                        Atentamente, FIXWEI.
                                                        <br><br>Importante. Este es un <b>aviso</b> enviado por la plataforma, por favor NO lo responda.
                                                        </p>
                                                        </body>
                                                        </html>";
                                                         
                                                        mail($to, $subject, $message, $headers);
                                                        
                                                        /////////// Fin se env��an los datos de creaci��n de usuario a ese usuario

                                                }
                                                
                                            }else{
                                                 'Plataforma: <b>No existe</b>';
                                                 '<br>';
                                                 'Correo: <b>No existe</b><br><br>';        
                                            }
                                        
                                    }
                        
                        //////////////// al terminar la validaci��n pasamos a quienes se le envia el correo
                        
                                    
                                    
                                    
                          ///////// Enter para que no salga la informaci��n por usuario pegado                
                          echo '<br>';
                      }   //// cierre del while
                      
                      
                } ///////////// cierre del for
                
                
        }else{ ////////////////////////////// validando la notificaci��n cuando es cargo
           
            
            //echo 'cargos de revisar';
            $longitudR = count($revisa);
            for($i=0; $i<$longitudR; $i++){
                    $nombreuserR = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos AS idElcargo,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$revisa[$i]' AND cargos.id_cargos=usuario.cargo ");
                    $columnaR = $nombreuserR->fetch_array(MYSQLI_ASSOC);
                     '<br>'.$columnaR['nombreCargos']; echo '<br>';
                    $estraerIdCargoR=$columnaR['idElcargo'];
                        
                            $extraerUsuariosR = $mysqli->query("SELECT * FROM usuario WHERE cargo ='$estraerIdCargoR' ")or die(mysqli_error());
                          //$usuariosCargo = $extraerUsuarios->fetch_array(MYSQLI_ASSOC);
                          while($usuariosCargoR = $extraerUsuariosR->fetch_array()){
                            echo 'EL USUARIO: <b>'.$nombredelUsuario0=$usuariosCargoR['nombres'].' '.$usuariosCargoR['apellidos'].'</b>';
                            $nombredelUsuarioR=utf8_encode($nombredelUsuario0);
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
                                                    
                                                    $aceptoCorreoR=$grupoUsuarioNotificacionR['correo']; /// variable anterior $aceptoCorreoR+
                                                     'Correo: <b>'.$grupoUsuarioNotificacionR['correo'].'</b>';
                                                    
                                                    
                                                    if($aceptoCorreoR > 0){
                                                         '<br>Al que debería enviar el correo: ';
                                                
                                                        $minimo2=number_format($minimo,0,'.',',');
                                                        $maximo2=number_format($maximo,0,'.',',');
                                                        /////////// se env��an los datos de creaci��n de usuario a ese usuario
                                                        
                                                        
                                                        echo $to = $usuariosCargoR['correo'];
                                                        
                                                        $subject = "Se le notifica la '$tipoProceso' de documento";
                                                        $headers = "MIME-Version: 1.0" . "\r\n";
                                                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                                         
                                                        $message = "
                                                        <html>
                                                        <head>
                                                        <title>HTML</title>
                                                        </head>
                                                        <body>
                                                        <img src='http://fixwei.com/plataforma/dist/img/fondoLogin2.jpg' width='200px' height='100px'><br>
                                                        
                                                        <p>Estimado/a. <b>'$nombredelUsuarioR'</b>.
                                                        <br><br>Se procede a realizar la '$tipoProcesoNombre' del siguiente documento, '$nombreDocEnviar' 
                                                        <br><br>
                                                        Cualquier inquietud sobre la misma, por favor contactar a la empresa prestadora de servicio <a target='_black' href='http://fixwei.com/plataforma/pages/examples/login'>Fixwei</a>
                                                        <br><br>
                                                        Atentamente, FIXWEI.
                                                        <br><br>Importante. Este es un <b>aviso</b> enviado por la plataforma, por favor NO lo responda.
                                                        </p>
                                                        </body>
                                                        </html>";
                                                         
                                                        mail($to, $subject, $message, $headers);
                                                        
                                                        /////////// Fin se env��an los datos de creaci��n de usuario a ese usuario
                                                    }
                                                    
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
                          
                } // finaliza el for
        } // finaliza el if de usuario y cargos
    
          //////
          ////////////////////////////////////// fin de la validación para los que revisan  ------------------------------------------------------------ ///////////////////
}          

if($estado == 'Revisado'){ 
    echo 'El estado del documento se encuentra en: '.$estado.' y entran los '.$radAprueba.'<br>';

        
          if($radAprueba == 'usuarios'){ //////////////// validando la notificacion cuando es usuario
           
             $longitudA = count($aprueba);
                for($i=0; $i<$longitudA; $i++){
                    $nombreuserA = $mysqli->query("SELECT * FROM usuario WHERE id = '$aprueba[$i]' ");
                    $columnaA = $nombreuserA->fetch_array(MYSQLI_ASSOC);
                    'ccS'.$extraerCCA=$columnaA['cedula']; echo '<br>';
                   
                   
                   
                    $extraerUsuariosA = $mysqli->query("SELECT * FROM usuario WHERE cedula ='$extraerCCA' ")or die(mysqli_error());
                      //$usuariosCargo = $extraerUsuarios->fetch_array(MYSQLI_ASSOC);
                      while($usuariosCargoA = $extraerUsuariosA->fetch_array()){
                        echo 'EL USUARIO: <b>'.$nombredelUsuari0=$usuariosCargoA['nombres'].' '.$usuariosCargoA['apellidos'].'</b>';
                        $nombredelUsuario=utf8_encode($nombredelUsuari0);
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
                                                $aceptoCorreoA=$grupoUsuarioNotificacionA['correo']; /// variable anterior $aceptoCorreoA
                                                  'Correo: <b>'.$grupoUsuarioNotificacionA['correo'].'</b>';
                                                 
                                                 if($aceptoCorreoA > 0){
                                                       '<br>Al correo que debería enviar es: ';
                                                        $minimo2=number_format($minimo,0,'.',',');
                                                        $maximo2=number_format($maximo,0,'.',',');
                                                        /////////// se env��an los datos de creaci��n de usuario a ese usuario
                                                        
                                                        echo $to = $usuariosCargoA['correo'];
                                                        
                                                        $subject = "Se le notifica la '$tipoProceso' de documento";
                                                        $headers = "MIME-Version: 1.0" . "\r\n";
                                                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                                         
                                                        $message = "
                                                        <html>
                                                        <head><meta>
                                                        <title>HTML</title>
                                                        </head>
                                                        <body>
                                                        <img src='http://fixwei.com/plataforma/dist/img/fondoLogin2.jpg' width='200px' height='100px'><br>
                                                        
                                                        <p>Estimado/a. <b>'$nombredelUsuario'</b>.
                                                        <br><br>Se procede a realizar la '$tipoProcesoNombre' del siguiente documento, '$nombreDocEnviar' 
                                                        <br><br>
                                                        Cualquier inquietud sobre la misma, por favor contactar a la empresa prestadora de servicio <a target='_black' href='http://fixwei.com/plataforma/pages/examples/login'>Fixwei</a>
                                                        <br><br>
                                                        Atentamente, FIXWEI.
                                                        <br><br>Importante. Este es un <b>aviso</b> enviado por la plataforma, por favor NO lo responda.
                                                        </p>
                                                        </body>
                                                        </html>";
                                                         
                                                        mail($to, $subject, $message, $headers);
                                                        
                                                        /////////// Fin se env��an los datos de creaci��n de usuario a ese usuario
                                                 }
                                                
                                            }else{
                                                 'Plataforma: <b>No existe</b>';
                                                 '<br>';
                                                 'Correo: <b>No existe</b><br><br>';        
                                            }
                                        
                                    }
                        
                          ///////// Enter para que no salga la informaci��n por usuario pegado                
                          echo '<br><br>';
                      }   //// cierre del while
                      
                      
                } ///////////// cierre del for
                
                
        }else{ ////////////////////////////// validando la notificaci��n cuando es cargo
           
            
            //echo 'cargos de revisar';
            $longitudA = count($aprueba);
            for($i=0; $i<$longitudA; $i++){
                    $nombreuserA = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos AS idElcargo,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$aprueba[$i]' AND cargos.id_cargos=usuario.cargo ");
                    $columnaA = $nombreuserA->fetch_array(MYSQLI_ASSOC);
                    $columnaA['nombreCargos']; echo '<br>';
                    $estraerIdCargoA=$columnaA['idElcargo'];
                        
                            $extraerUsuariosA = $mysqli->query("SELECT * FROM usuario WHERE cargo ='$estraerIdCargoA' ")or die(mysqli_error());
                          //$usuariosCargo = $extraerUsuarios->fetch_array(MYSQLI_ASSOC);
                          while($usuariosCargoA = $extraerUsuariosA->fetch_array()){
                            echo 'EL USUARIO A: <b>'.$nombredelUsuario0=$usuariosCargoA['nombres'].' '.$usuariosCargoA['apellidos'].'</b>';
                            $nombredelUsuarioA=utf8_encode($nombredelUsuario0);
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
                                                 '<br>Nombre del grupo: '.$nombreValidandoGrupoA.'</b><br>';
                                            
                                                //////////// Luego vamos a consultar en los permisos de notificacion por el id del grupo del usuario
                                                $consultaGruposNotificacionA = $mysqli->query("SELECT * FROM permisosNotificaciones WHERE idGrupo ='$idGrupoValidandoA' AND formulario='creacionDoc' ")or die(mysqli_error());
                                                $grupoUsuarioNotificacionA = $consultaGruposNotificacionA->fetch_array(MYSQLI_ASSOC);
                                                if($grupoUsuarioNotificacionA['plataforma'] != NULL && $grupoUsuarioNotificacionA['correo'] != NULL){
                                                    $aceptoPlataformaA+=$grupoUsuarioNotificacionA['plataforma']; 
                                                     'Plataforma A: <b>'.$grupoUsuarioNotificacionA['plataforma'].'</b>';
                                                    
                                                    $aceptoCorreoA=$grupoUsuarioNotificacionA['correo']; // variable anterior $aceptoCorreoA+
                                                    
                                                     'Correo A: <b>'.$grupoUsuarioNotificacionA['correo'].'</b>';
                                                    
                                                    if($aceptoCorreoA > 0){ /////////////////// se valida acá el correo para enviar los datos
                                                         '<br>Al correo que debería enviar es: ';
                                                
                                                        
                                                
                                                            $minimo2=number_format($minimo,0,'.',',');
                                                            $maximo2=number_format($maximo,0,'.',',');
                                                            /////////// se env��an los datos de creaci��n de usuario a ese usuario
                                                            
                                                            echo $to = $usuariosCargoA['correo'];
                                                            
                                                            $subject = "Se le notifica la '$tipoProceso' del documento";
                                                            $headers = "MIME-Version: 1.0" . "\r\n";
                                                            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                                             
                                                            $message = "
                                                            <html>
                                                            <head>
                                                            <title>HTML</title>
                                                            </head>
                                                            <body>
                                                            <img src='http://fixwei.com/plataforma/dist/img/fondoLogin2.jpg' width='200px' height='100px'><br>
                                                            
                                                            <p>Estimado/a. <b>'$nombredelUsuarioA'</b>.
                                                            <br><br>Se procede a realizar la '$tipoProcesoNombre' del siguiente documento, '$nombreDocEnviar' 
                                                            <br><br>
                                                            Cualquier inquietud sobre la misma, por favor contactar a la empresa prestadora de servicio <a target='_black' href='http://fixwei.com/plataforma/pages/examples/login'>Fixwei</a>
                                                            <br><br>
                                                            Atentamente, FIXWEI.
                                                            <br><br>Importante. Este es un <b>aviso</b> enviado por la plataforma, por favor NO lo responda.
                                                            </p>
                                                            </body>
                                                            </html>";
                                                             
                                                            mail($to, $subject, $message, $headers);
                                                            
                                                            /////////// Fin se env��an los datos de creaci��n de usuario a ese usuario
                                            
                                                        
                                                    }
                                                    
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
                          
                          
                } // finaliza el for
        } // finaliza el if de usuario y cargos
        
            
        
  }      
        
        
       
?>