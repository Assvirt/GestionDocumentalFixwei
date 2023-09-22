<?php
require_once '../../conexion/bd.php';
mb_internal_encoding("UTF-8");
error_reporting(E_ERROR);

if(isset($_POST['Agregar'])){
$color = $_POST['color'];    
$minimo = $_POST['minimo'];
$maximo = $_POST['maximo'];
$radiobtn = $_POST['radiobtn'];//quien cita
//$select2 = json_encode($_POST['select_encargadoE']);
   $select = $_POST['select_encargadoE'];//centros de trabajo 
   json_encode($select);    
    



if($radiobtn == 'usuario'){ //////////////// validando la notificacion cuando es usuario
    $longitud = count($select);
        for($i=0; $i<$longitud; $i++){
            $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$select[$i]' ");
            $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
            echo $extraerCC=$columna['cedula']; echo '<br>';
           
           
           
            $extraerUsuarios = $mysqli->query("SELECT * FROM usuario WHERE cedula ='$extraerCC' ")or die(mysqli_error());
              //$usuariosCargo = $extraerUsuarios->fetch_array(MYSQLI_ASSOC);
              while($usuariosCargo = $extraerUsuarios->fetch_array()){
                 'EL USUARIO: <b>'.$nombredelUsuario=$usuariosCargo['nombres'].''.$usuariosCargo['apellidos'].' tiene el id cargo: '.$usuariosCargo['cargo'].'</b>';
                $consultaCedula=$usuariosCargo['cedula'];
                
                            ///////// luego se consulta con la cc del usuario a esta tabla para traer los id de los grupos por usuario
                            $consultaGrupos = $mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario ='$consultaCedula' ")or die(mysqli_error());
                            //$grupoUsuario = $consultaGrupos->fetch_array(MYSQLI_ASSOC);
                            while($grupoUsuario = $consultaGrupos->fetch_array()){
                            $idGrupo=$grupoUsuario['idGrupo'];
                            $validarUsuarioMensaje=$grupoUsuario['idUsuario'];
                             '<br><br>Id de la tabla usuarioGrupo: <b>'.$idGrupo.'</b><br>';
                            
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
                                     'Nombre del grupo: '.$nombreValidandoGrupo.' y su id: <b>'.$idGrupoValidando.'</b><br>';
                                
                                    //////////// Luego vamos a consultar en los permisos de notificacion por el id del grupo del usuario
                                    $consultaGruposNotificacion = $mysqli->query("SELECT * FROM permisosNotificaciones WHERE idGrupo ='$idGrupoValidando' AND formulario='politicas' ")or die(mysqli_error());
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
                
                //////////////// al terminar la validación pasamos a quienes se le envia el correo
                
                            
                            
                            
                  ///////// Enter para que no salga la información por usuario pegado                
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
                                    $validandoNotificacions='politicas';
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
                                    $usuarioH=$nombreU." ".$apellidoU;
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
                                        /////////// se envían los datos de creación de usuario a ese usuario
                                        /*
                                        $to = $correoU;
                                        $subject = "Se le notifica ser aprobador a la nueva politica";
                                        $headers = "MIME-Version: 1.0" . "\r\n";
                                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                         
                                        $message = "
                                        <html>
                                        <head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
                                        <title>HTML</title>
                                        </head>
                                        <body>
                                        <img src='http://fixwei.com/plataforma/dist/img/fondoLogin2.jpg' width='200px' height='100px'><br>
                                        
                                        <p>Estimado/a. <b>'$usuarioH'</b>.
                                        <br><br>Se detalla a continuación la aprobación asignada entre un monto mínimo $ '$minimo2' de a máximo de $ '$maximo2' 
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
                                        /////////// Fin se envían los datos de creación de usuario a ese usuario
                                    }elseif($correoH > 0){
                                        
                                       // echo 'estos son los correos: '.$correoU; echo '<br>';
                                        $minimo2=number_format($minimo,0,'.',',');
                                        $maximo2=number_format($maximo,0,'.',',');
                                        /////////// se envían los datos de creación de usuario a ese usuario
                                        /*
                                        $to = $correoU;
                                        $subject = "Se le notifica ser aprobador a la nueva politica ";
                                        $headers = "MIME-Version: 1.0" . "\r\n";
                                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                         
                                        $message = "
                                        <html>
                                        <head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
                                        <title>HTML</title>
                                        </head>
                                        <body>
                                        <img src='http://fixwei.com/plataforma/dist/img/fondoLogin2.jpg' width='200px' height='100px'><br>
                                        
                                        <p>Estimado/a. <b>'$usuarioH'</b>.
                                        <br><br>Se detalla a continuación la aprobación asignada entre un monto mínimo $ '$minimo2' de a máximo de $ '$maximo2' 
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
        
        
}else{ ////////////////////////////// validando la notificación cuando es cargo
    //echo 'cargos';
    $longitud = count($select);
    for($i=0; $i<$longitud; $i++){
            $nombreuser = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos AS idElcargo,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$select[$i]' AND cargos.id_cargos=usuario.cargo ");
            $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
             $columna['nombreCargos']; echo '<br>';
            $estraerIdCargo=$columna['idElcargo'];
                
                    $extraerUsuarios = $mysqli->query("SELECT * FROM usuario WHERE cargo ='$estraerIdCargo' ")or die(mysqli_error());
                  //$usuariosCargo = $extraerUsuarios->fetch_array(MYSQLI_ASSOC);
                  while($usuariosCargo = $extraerUsuarios->fetch_array()){
                     'EL USUARIO: <b>'.$nombredelUsuario=$usuariosCargo['nombres'].''.$usuariosCargo['apellidos'].' tiene el id cargo: '.$usuariosCargo['cargo'].'</b>';
                    $consultaCedula=$usuariosCargo['cedula'];
                    
                                ///////// luego se consulta con la cc del usuario a esta tabla para traer los id de los grupos por usuario
                                $consultaGrupos = $mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario ='$consultaCedula' ")or die(mysqli_error());
                                //$grupoUsuario = $consultaGrupos->fetch_array(MYSQLI_ASSOC);
                                while($grupoUsuario = $consultaGrupos->fetch_array()){
                                $idGrupo=$grupoUsuario['idGrupo'];
                                $validarUsuarioMensaje=$grupoUsuario['idUsuario'];
                                 '<br><br>Id de la tabla usuarioGrupo: <b>'.$idGrupo.'</b><br>';
                                
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
                                         'Nombre del grupo: '.$nombreValidandoGrupo.' y su id: <b>'.$idGrupoValidando.'</b><br>';
                                    
                                        //////////// Luego vamos a consultar en los permisos de notificacion por el id del grupo del usuario
                                        $consultaGruposNotificacion = $mysqli->query("SELECT * FROM permisosNotificaciones WHERE idGrupo ='$idGrupoValidando' AND formulario='politicas' ")or die(mysqli_error());
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
                    
                    //////////////// al terminar la validación pasamos a quienes se le envia el correo
                    ///////// Enter para que no salga la información por usuario pegado                
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
                                    $validandoNotificacions='politicas';
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
                                    $usuarioH=$nombreU." ".$apellidoU;
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
                                        /////////// se envían los datos de creación de usuario a ese usuario
                                        /*
                                        $to = $correoU;
                                        $subject = "Se le notifica ser aprobador a la nueva politica";
                                        $headers = "MIME-Version: 1.0" . "\r\n";
                                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                         
                                        $message = "
                                        <html>
                                        <head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
                                        <title>HTML</title>
                                        </head>
                                        <body>
                                        <img src='http://fixwei.com/plataforma/dist/img/fondoLogin2.jpg' width='200px' height='100px'><br>
                                        
                                        <p>Estimado/a. <b>'$usuarioH'</b>.
                                        <br><br>Se detalla a continuación la aprobació asignada entre un monto mínimo $ '$minimo2' de a máximo de $ '$maximo2' 
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
                                        /////////// Fin se envían los datos de creación de usuario a ese usuario
                                    }elseif($correoH > 0){
                                        
                                       // echo 'estos son los correos: '.$correoU; echo '<br>';
                                        $minimo2=number_format($minimo,0,'.',',');
                                        $maximo2=number_format($maximo,0,'.',',');
                                        /////////// se envían los datos de creación de usuario a ese usuario
                                        /*
                                        $to = $correoU;
                                        $subject = "Se le notifica ser aprobador a la nueva politica ";
                                        $headers = "MIME-Version: 1.0" . "\r\n";
                                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                         
                                        $message = "
                                        <html>
                                        <head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
                                        <title>HTML</title>
                                        </head>
                                        <body>
                                        <img src='http://fixwei.com/plataforma/dist/img/fondoLogin2.jpg' width='200px' height='100px'><br>
                                        
                                        <p>Estimado/a. <b>'$usuarioH'</b>.
                                        <br><br>Se detalla a continuación la aprobació asignada entre un monto mínimo $ '$minimo2' de a máximo de $ '$maximo2' 
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
                  
                  
                  
                  
                  
                  
                  
            
        }
}


///////////  variable para almacenar
  
  if($plataformaHabilitada1 > 0){
      $plataformaHabilitada=$plataformaHabilitada1;
  }
  
  if($plataformaHabilitada2 > 0){
      $plataformaHabilitada=$plataformaHabilitada2;
  }
  
  if($plataformaHabilitada1 == 0 && $plataformaHabilitada2 == 0){
      $plataformaHabilitada='0';
  }
  
   '<br>Habilitado: '.$plataformaHabilitada;
  //////
    
    
    
    
   
    ///////// consultamos la tabla y extraemos el nombre
    $validacion = $mysqli->query("SELECT * FROM politicas WHERE aprobador = '$select' AND tipoAprobador='$radiobtn' ")or die (mysqli_error());
    $numRows = mysqli_num_rows($validacion);
        if($numRows > 0){
                
                echo '<script language="javascript">alert("El aprobador ya existe");
                window.location.href="../../politicas"</script>';
            }else{
                $select2 = json_encode($_POST['select_encargadoE']);
                $mysqli->query("INSERT INTO politicas (tipoAProbador, aprobador, minimo, maximo, color, plataformaH) VALUES('$radiobtn','$select2','$minimo','$maximo','$color','$plataformaHabilitada') ")or die(mysqli_error($mysqli));
                //header ('location: ../../politicas');
                echo '<script language="javascript">alert("Politica Registrada");
                window.location.href="../../politicas"</script>';
            }
    

}elseif(isset($_POST['Editar'])){

    $id= $_POST['idPoliticas'];
    $minimo = $_POST['minimo'];
    $maximo = $_POST['maximo'];
    $radiobtn = $_POST['radiobtn'];//quien cita
    $select = json_encode($_POST['select_encargadoE']);
    
    $validacion = $mysqli->query("SELECT * FROM politicas WHERE id='$id' ");
    $numRows = mysqli_num_rows($validacion);
    if($numRows > 0){
        
        $mysqli->query("UPDATE politicas SET  tipoAprobador='$radiobtn', aprobador='$select', minimo='$minimo', maximo='$maximo'  WHERE id = '$id'")or die(mysqli_error($mysqli));
        header ('location: ../../politicas');
        
    }else{
  
        echo '<script language="javascript">alert("La politica ya existe");
        window.location.href="../../politicas"</script>';
    
} 

}elseif(isset($_POST['Eliminar'])){
    
                        $id = $_POST['idPoliticas'];
                        $mysqli->query("DELETE from politicas  WHERE id = '$id'")or die(mysqli_error($mysqli));
                        echo '<script language="javascript">alert("La politica fue eliminada");
                        window.location.href="../../politicas"</script>';
                    
    
}
?>