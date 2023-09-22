<?php

error_reporting(E_ERROR);
//////// traemos la bd
require_once '../../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario

if(isset($_POST['Agregar'])){
 $idUsuario = $_POST['idUsuario'];
 $presupuesto = $_POST['presupuesto'];
 $centroCosto = $_POST['centroCosto'];
 $fechaEntrega = $_POST['fechaEntrega'];
 $centroTrabajo = $_POST['centroTrabajo'];
 $centroTrabajoEntrega = $_POST['centroTrabajoEntrega'];
 $tipoSolicitud = $_POST['tipoSolicitud'];
 
 $nuevoProducto = $_POST['nuevoProducto'];
 
 
 
    
    if($nuevoProducto == 'si'){
         $nuevoProducto;
         $grupo=$_POST['grupo2'];
         $nombreProducto=utf8_decode($_POST['nombreProducto']);
         $identificador=utf8_decode($_POST['identificador']);
         $presentacion=utf8_decode($_POST['presentacion2']);
         $cantidad=$_POST['cantidad2'];
         $urgencia=$_POST['urgencia2'];
    }   

    if($nuevoProducto == 'no'){
         $nuevoProducto;
         $grupo=$_POST['grupo'];
         $nombreProducto=$_POST['nombreProducto'];
         $identificador=$_POST['identificador'];
         $presentacion=$_POST['presentacion'];
         $cantidad=$_POST['cantidad'];
         $urgencia=$_POST['urgencia'];
    }



//////// validaciones de correo por los cargos según los grupos tengan los permisos
   'Este es el usuario para validar: '.$idUsuario;
  echo '<br><br>';
  ////////// con el id cargo se consulta los usuarios con ese cargo
  
  $extraerUsuarios = $mysqli->query("SELECT * FROM usuario WHERE cedula ='$idUsuario' ")or die(mysqli_error());
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
                        $consultaGruposNotificacion = $mysqli->query("SELECT * FROM permisosNotificaciones WHERE idGrupo ='$idGrupoValidando' AND formulario='solicitudCom' ")or die(mysqli_error());
                        $grupoUsuarioNotificacion = $consultaGruposNotificacion->fetch_array(MYSQLI_ASSOC);
                        if($grupoUsuarioNotificacion['plataforma'] != NULL && $grupoUsuarioNotificacion['correo'] != NULL){
                            $aceptoPlataforma+=$grupoUsuarioNotificacion['plataforma'];
                             'Plataforma: <b>'.$grupoUsuarioNotificacion['plataforma'].'</b>';
                            echo '<br>';
                            $aceptoCorreo+=$grupoUsuarioNotificacion['correo'];
                             'Correo: <b>'.$grupoUsuarioNotificacion['correo'].'</b>';
                            
                        }else{
                             'Plataforma: <b>No existe</b>';
                            echo '<br>';
                             'Correo: <b>No existe</b><br><br>';        
                        }
                    
                }
    
    //////////////// al terminar la validación pasamos a quienes se le envia el correo
    
                
                
                
      ///////// Enter para que no salga la información por usuario pegado                
      echo '<br><br>';
  }
  
  if($aceptoCorreo > 0){
       '<br>sale plataforma: '.$aceptoPlataforma;
       '<br>sale correo: '.$aceptoCorreo;
       '<br>sale cargo: '.$confirmacionNotificaciones=$encargado;
      
      /*
      if($aceptoPlataforma > 0 && $aceptoCorreo > 0){
          echo '<br>Sale enviar plataforma y correo';
      }elseif($aceptoCorreo > 0){
          echo '<br>Sale enviar correo';
      } */
       
  
 //////////////////// se agrega este campo para las actividades
                    /////////// actividades de traer nombre de modulos de notificaciones
                    $validandoNotificacions='solicitudCom';
                    $usuarioID=$_POST['usuarioActividad'];
                    
                    //$plataformaH = $_POST['plataforma'];
                    //$correoH = $_POST['correo'];
                    
                    $plataformaH =$aceptoPlataforma;
                    $correoH = $aceptoCorreo;
                    
                    /////////// fin proceso para traer el nombre del modulo en las notifiaciones
                    
                    //////////// datos para el correo
                    $nombreUsuario = $mysqli->query("SELECT * FROM usuario WHERE cargo='$confirmacionNotificaciones' ")or die(mysqli_error());
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
                        $plataformaHabilitada='1';
                        ////// fin
                        
                        //$tituloA='Solicitud de documento';
                        //$mensajeA='Se realiza solicitud de documento '.$nombre;
                        
                        
                        /////////// se envían los datos de creación de usuario a ese usuario
                        /*
                        $to = $correoU;
                        $subject = "Notificación registro solicitud de documento ";
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
                        <br><br>Se detalla a continuación la solicitud de documento '$nombre' 
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
                        
                        /////////// se envían los datos de creación de usuario a ese usuario
                        /*
                        $to = $correoU;
                        $subject = "Notificación registro solicitud de documento ";
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
                        <br><br>Se detalla a continuación la solicitud de documento '$nombre' 
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
                    /*elseif($plataformaH > 0){
                        $tituloA='Solicitud de documento';
                        $mensajeA='Se realiza solicitud de documento '.$nombre;
                        
                        date_default_timezone_set('America/Bogota');
                        $fechaA=date('Y-m-j h:i:s A');
                        
                        $agregarActividads= $mysqli->query("INSERT INTO actividades(idUsuario,iformulario,titulo,fecha,mensaje) VALUES('$usuarioID', '$validandoNotificacions', '$tituloA', '$fechaA','$mensajeA')")or die(mysqli_error($mysqli));
                        
                    }*/
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
       
  
 //////////////////// se agrega este campo para las actividades
                    /////////// actividades de traer nombre de modulos de notificaciones
                    $validandoNotificacions='solicitudCom';
                    $usuarioID=$_POST['usuarioActividad'];
                    $plataformaH =$aceptoPlataforma;
                    
                    
                    /////////// fin proceso para traer el nombre del modulo en las notifiaciones
                    
                   if($plataformaH > 0){
                        /////// esta variable se usa para habilitar o desabilitar las notificaciones y diferenciar las solicitudes viejas con las nuevas
                        $plataformaHabilitada='1';
                        ////// fin
                        
                    }
        ////////// fin del proceso   
    
      
  
  } //////// finaliza la validacion del if AND elseif
  
  
  
  ///////////  variable para almacenar
  if($plataformaHabilitada > 0){
      $plataformaHabilitada;
  }else{
      $plataformaHabilitada='0';
  }
   '<br>Habilitado: '.$plataformaHabilitada;
  //////

$archivoNombre = $_FILES['archivo']['name'];
$guardado = $_FILES['archivo']['tmp_name'];

  if(!file_exists('../../archivos/compras')){
      $ruta = 'archivos/compras/'.$archivoNombre;
      
      /////// se valida el archivo antes de guardar para evitar reemplazar el actual o el nombre del archivo
                $validacion1 = $mysqli->query("SELECT * FROM solicitudCompra WHERE ruta= '$ruta' ");//consulta a base de datos si el nombre se repite
                    $numNom = mysqli_num_rows($validacion1);
                    if($numNom > 0){
                        
                      //  echo 'El archivo existe';
                        
                    }else{/////////////// fin de la validacion
      
                        mkdir('../../archivos/compras',0777,true);
                        if(file_exists('../../archivos/compras')){
                            if(move_uploaded_file($guardado, '../../archivos/compras/'.$archivoNombre)){
                                $ruta = 'archivos/compras/'.$archivoNombre;
                                
                                
                                ///////// consultamos la tabla y extraemos el nombre
                		        $mysqli->query("INSERT INTO solicitudCompra (presupuesto,fechaEstimada,centroTrabajo,centroCosto,centroTrabajoEntrega,tipoSolicitud,nuevoProducto,estado,grupo,nombreProducto,identificador,presentacion,cantidad,urgencia,idUsuario,plataformaH,ruta) 
   VALUES('$presupuesto','$fechaEntrega','$centroTrabajo','$centroCosto','$centroTrabajoEntrega','$tipoSolicitud','$nuevoProducto','Pendiente','$grupo','$nombreProducto','$identificador','$presentacion','$cantidad','$urgencia','$idUsuario','$plataformaHabilitada','$ruta')");    
   
   //echo 'almacena 1';
                                
                                    }
                            }
                        }
        
    }else{
        
        $ruta = 'archivos/compras/'.$archivoNombre;
        /////// se valida el archivo antes de guardar para evitar reemplazar el actual o el nombre del archivo
                $validacion1 = $mysqli->query("SELECT * FROM solicitudCompra WHERE ruta= '$ruta' ");//consulta a base de datos si el nombre se repite
                    $numNom = mysqli_num_rows($validacion1);
                    if($numNom > 0){
                        
                      echo '<script language="javascript">alert("El archivo ya existe ");
                            window.location.href="../../SolicitudCompra"</script>';
                        
                    }else{/////////////// fin de la validacion
        
                    $archivoNombre2 = $_FILES['archivo2']['name'];
                    $guardado2 = $_FILES['archivo2']['tmp_name'];
                    $archivoNombre3 = $_FILES['archivo3']['name'];
                    $guardado3 = $_FILES['archivo3']['tmp_name'];
                    $archivoNombre4 = $_FILES['archivo4']['name'];
                    $guardado4 = $_FILES['archivo4']['tmp_name'];
                    $archivoNombre5 = $_FILES['archivo5']['name'];
                    $guardado5 = $_FILES['archivo5']['tmp_name'];
                    
                        if(move_uploaded_file($guardado, '../../archivos/compras/'.$archivoNombre)){
                                $ruta = 'archivos/compras/'.$archivoNombre;
                        }
                        if(move_uploaded_file($guardado2, '../../archivos/compras/'.$archivoNombre2)){
                                $ruta2 = 'archivos/compras/'.$archivoNombre2;
                        }
                        if(move_uploaded_file($guardado3, '../../archivos/compras/'.$archivoNombre3)){
                                $ruta3 = 'archivos/compras/'.$archivoNombre3;
                        }
                        if(move_uploaded_file($guardado4, '../../archivos/compras/'.$archivoNombre4)){
                                $ruta4 = 'archivos/compras/'.$archivoNombre4;
                        }
                        if(move_uploaded_file($guardado5, '../../archivos/compras/'.$archivoNombre5)){
                                $ruta5 = 'archivos/compras/'.$archivoNombre5;
                        }
                            
                            
                                ///////// consultamos la tabla y extraemos el nombre
                		    $mysqli->query("INSERT INTO solicitudCompra (presupuesto,fechaEstimada,centroTrabajo,centroCosto,centroTrabajoEntrega,tipoSolicitud,nuevoProducto,estado,grupo,nombreProducto,identificador,presentacion,cantidad,urgencia,idUsuario,plataformaH,ruta,ruta2,ruta3,ruta4,ruta5) 
                            VALUES('$presupuesto','$fechaEntrega','$centroTrabajo','$centroCosto','$centroTrabajoEntrega','$tipoSolicitud','$nuevoProducto','Pendiente','$grupo','$nombreProducto','$identificador','$presentacion','$cantidad','$urgencia','$idUsuario','$plataformaHabilitada','$ruta','$ruta2','$ruta3','$ruta4','$ruta5')");    
   
                            echo '<script language="javascript">alert("Datos ingresados");
                            window.location.href="../../SolicitudCompra"</script>'; 
                            
                            
                        }
        
    }


	
	
    
 //  $mysqli->query("INSERT INTO solicitudCompra (presupuesto,fechaEstimada,centroTrabajo,centroCosto,centroTrabajoEntrega,tipoSolicitud,nuevoProducto,estado,grupo,nombreProducto,identificador,presentacion,cantidad,urgencia,idUsuario,plataformaH,ruta) 
  // VALUES('$presupuesto','$fechaEntrega','$centroTrabajo','$centroCosto','$centroTrabajoEntrega','$tipoSolicitud','$nuevoProducto','Pendiente','$grupo','$nombreProducto','$identificador','$presentacion','$cantidad','$urgencia','$idUsuario','$plataformaHabilitada','$directorio')");    
   
  // echo '<script language="javascript">alert("Datos ingresados");
//    window.location.href="../../AgregarSolicitudCompra"</script>';  
 


}
if(isset($_POST['Actualizar'])){
 
 $id = $_POST['id'];
 $idUsuario = $_POST['idUsuario'];
 $presupuesto = $_POST['presupuesto'];
 $centroCosto = $_POST['centroCosto'];
 $fechaEntrega = $_POST['fechaEntrega'];
 $centroTrabajo = $_POST['centroTrabajo'];
 $centroTrabajoEntrega = $_POST['centroTrabajoEntrega'];
 $tipoSolicitud = $_POST['tipoSolicitud'];

 
 $nuevoProducto = $_POST['nuevoProducto'];
 
         if($nuevoProducto == 'si'){
         $nuevoProducto;
         $grupo=$_POST['grupo2'];
         $nombreProducto=utf8_decode($_POST['nombreProducto']);
         $identificador=utf8_decode($_POST['identificador']);
         $presentacion=utf8_decode($_POST['presentacion2']);
         $cantidad=$_POST['cantidad2'];
         $urgencia=$_POST['urgencia2'];
    }   

    if($nuevoProducto == 'no'){
         $nuevoProducto;
         $grupo=$_POST['grupo'];
         $nombreProducto=$_POST['nombreProducto'];
         $identificador=$_POST['identificador'];
         $presentacion=$_POST['presentacion'];
         $cantidad=$_POST['cantidad'];
         $urgencia=$_POST['urgencia'];
    }
    
    $archivoNombre = $_FILES['archivo']['name'];
    $guardado = $_FILES['archivo']['tmp_name'];

  if(!file_exists('../../archivos/compras')){
      $ruta = 'archivos/compras/'.$archivoNombre;
      
      /////// se valida el archivo antes de guardar para evitar reemplazar el actual o el nombre del archivo
                $validacion1 = $mysqli->query("SELECT * FROM solicitudCompra WHERE ruta= '$ruta' ");//consulta a base de datos si el nombre se repite
                    $numNom = mysqli_num_rows($validacion1);
                    if($numNom > 0){
                        
                      //  echo 'El archivo existe';
                        
                    }else{/////////////// fin de la validacion
      
                        mkdir('../../archivos/compras',0777,true);
                        if(file_exists('../../archivos/compras')){
                            if(move_uploaded_file($guardado, '../../archivos/compras/'.$archivoNombre)){
                                $ruta = 'archivos/compras/'.$archivoNombre;
                                
                                
                                ///////// consultamos la tabla y extraemos el nombre
                		   //     $mysqli->query("INSERT INTO solicitudCompra (presupuesto,fechaEstimada,centroTrabajo,centroCosto,centroTrabajoEntrega,tipoSolicitud,nuevoProducto,estado,grupo,nombreProducto,identificador,presentacion,cantidad,urgencia,idUsuario,plataformaH,ruta) 
  // VALUES('$presupuesto','$fechaEntrega','$centroTrabajo','$centroCosto','$centroTrabajoEntrega','$tipoSolicitud','$nuevoProducto','Pendiente','$grupo','$nombreProducto','$identificador','$presentacion','$cantidad','$urgencia','$idUsuario','$plataformaHabilitada','$ruta')");    
   
   //echo 'almacena 1';
                                
                                    }
                            }
                        }
        
    }else{
        
        $ruta = 'archivos/compras/'.$archivoNombre;
        /////// se valida el archivo antes de guardar para evitar reemplazar el actual o el nombre del archivo
                $validacion1 = $mysqli->query("SELECT * FROM solicitudCompra WHERE ruta= '$ruta' ");//consulta a base de datos si el nombre se repite
                    $numNom = mysqli_num_rows($validacion1);
                    if($numNom > 0){
                        
                      echo '<script language="javascript">alert("El archivo ya existe ");
                            window.location.href="../../SolicitudCompra"</script>';
                        
                    }else{/////////////// fin de la validacion
        
                    $archivoNombre2 = $_FILES['archivo2']['name'];
                    $guardado2 = $_FILES['archivo2']['tmp_name'];
                    $archivoNombre3 = $_FILES['archivo3']['name'];
                    $guardado3 = $_FILES['archivo3']['tmp_name'];
                    $archivoNombre4 = $_FILES['archivo4']['name'];
                    $guardado4 = $_FILES['archivo4']['tmp_name'];
                    $archivoNombre5 = $_FILES['archivo5']['name'];
                    $guardado5 = $_FILES['archivo5']['tmp_name'];
                    
                        if(move_uploaded_file($guardado, '../../archivos/compras/'.$archivoNombre)){
                                $ruta = 'archivos/compras/'.$archivoNombre;
                        }
                        if(move_uploaded_file($guardado2, '../../archivos/compras/'.$archivoNombre2)){
                                $ruta2 = 'archivos/compras/'.$archivoNombre2;
                        }
                        if(move_uploaded_file($guardado3, '../../archivos/compras/'.$archivoNombre3)){
                                $ruta3 = 'archivos/compras/'.$archivoNombre3;
                        }
                        if(move_uploaded_file($guardado4, '../../archivos/compras/'.$archivoNombre4)){
                                $ruta4 = 'archivos/compras/'.$archivoNombre4;
                        }
                        if(move_uploaded_file($guardado5, '../../archivos/compras/'.$archivoNombre5)){
                                $ruta5 = 'archivos/compras/'.$archivoNombre5;
                        }
                            
                            
                        //$mysqli->query("UPDATE solicitudCompra SET presupuesto='$presupuesto',fechaEstimada='$fechaEntrega',centroTrabajo='$centroTrabajo',centroCosto='$centroCosto',centroTrabajoEntrega='$centroTrabajoEntrega',tipoSolicitud='$tipoSolicitud',nuevoProducto='$nuevoProducto',estado='Pendiente',grupo='$grupo',nombreProducto='$nombreProducto',identificador='$identificador',presentacion='$presentacion',cantidad='$cantidad',urgencia='$urgencia',ruta='$ruta',ruta2='$ruta2',ruta3='$ruta3',ruta4='$ruta4',ruta5='$ruta5' WHERE id='$id' ");
                        
                        if($archivoNombre != NULL && $guardado != NULL){
                        $mysqli->query("UPDATE solicitudCompra SET presupuesto='$presupuesto',fechaEstimada='$fechaEntrega',centroTrabajo='$centroTrabajo',centroCosto='$centroCosto',centroTrabajoEntrega='$centroTrabajoEntrega',tipoSolicitud='$tipoSolicitud',nuevoProducto='$nuevoProducto',estado='Pendiente',grupo='$grupo',nombreProducto='$nombreProducto',identificador='$identificador',presentacion='$presentacion',cantidad='$cantidad',urgencia='$urgencia',ruta='$ruta' WHERE id='$id' ");
                        }
                        
                        if($archivoNombre2 != NULL && $guardado2 != NULL){
                        $mysqli->query("UPDATE solicitudCompra SET presupuesto='$presupuesto',fechaEstimada='$fechaEntrega',centroTrabajo='$centroTrabajo',centroCosto='$centroCosto',centroTrabajoEntrega='$centroTrabajoEntrega',tipoSolicitud='$tipoSolicitud',nuevoProducto='$nuevoProducto',estado='Pendiente',grupo='$grupo',nombreProducto='$nombreProducto',identificador='$identificador',presentacion='$presentacion',cantidad='$cantidad',urgencia='$urgencia',ruta2='$ruta2' WHERE id='$id' ");
                        }
                        
                        if($archivoNombre3 != NULL && $guardado3 != NULL){
                        $mysqli->query("UPDATE solicitudCompra SET presupuesto='$presupuesto',fechaEstimada='$fechaEntrega',centroTrabajo='$centroTrabajo',centroCosto='$centroCosto',centroTrabajoEntrega='$centroTrabajoEntrega',tipoSolicitud='$tipoSolicitud',nuevoProducto='$nuevoProducto',estado='Pendiente',grupo='$grupo',nombreProducto='$nombreProducto',identificador='$identificador',presentacion='$presentacion',cantidad='$cantidad',urgencia='$urgencia',ruta3='$ruta3' WHERE id='$id' ");
                        }
                        
                        if($archivoNombre4 != NULL && $guardado4 != NULL){
                        $mysqli->query("UPDATE solicitudCompra SET presupuesto='$presupuesto',fechaEstimada='$fechaEntrega',centroTrabajo='$centroTrabajo',centroCosto='$centroCosto',centroTrabajoEntrega='$centroTrabajoEntrega',tipoSolicitud='$tipoSolicitud',nuevoProducto='$nuevoProducto',estado='Pendiente',grupo='$grupo',nombreProducto='$nombreProducto',identificador='$identificador',presentacion='$presentacion',cantidad='$cantidad',urgencia='$urgencia',ruta4='$ruta4' WHERE id='$id' ");
                        }
                        
                        if($archivoNombre5 != NULL && $guardado5 != NULL){
                        $mysqli->query("UPDATE solicitudCompra SET presupuesto='$presupuesto',fechaEstimada='$fechaEntrega',centroTrabajo='$centroTrabajo',centroCosto='$centroCosto',centroTrabajoEntrega='$centroTrabajoEntrega',tipoSolicitud='$tipoSolicitud',nuevoProducto='$nuevoProducto',estado='Pendiente',grupo='$grupo',nombreProducto='$nombreProducto',identificador='$identificador',presentacion='$presentacion',cantidad='$cantidad',urgencia='$urgencia',ruta5='$ruta5' WHERE id='$id' ");
                        }
                        
                            echo '<script language="javascript">
                            window.location.href="../../solicitudCompra"</script>';
                            
                            
                        }
        
    } 
    
    
}
if(isset($_POST['eliminarCC'])){
    $id = $_POST['idCentro'];
    
    $mysqli->query("DELETE FROM centroCostos WHERE id = '$id'");
    echo '<script language="javascript">alert("exito al Eliminar.");
    window.location.href="../../centroCostos"</script>';
    
}
if(isset($_POST['Gestionar'])){
    $id = $_POST['id'];
    $estado = $_POST['estado'];
    $cambio = utf8_decode($_POST['cambio']);
    
    $mysqli->query("UPDATE solicitudCompra SET estado='$estado' WHERE id='$id' ");
    
    if($cambio != NULL){
        $mysqli->query("INSERT INTO solicitudCompraComentarios (idSolicitud,comentario)VALUES('$id','$cambio') ");
    }
    
    echo '<script language="javascript">
    window.location.href="../../solicitudCompra"</script>';
    
}