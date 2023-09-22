<?php
error_reporting(E_ERROR);
//////// traemos la bd
date_default_timezone_set("America/Bogota");
require_once '../../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario
///crearDocumentoSolicitudDocumentosSeguimiento.php
///agrega solicitud cuando el documento a crear es nuevo
    $tipoSolicitud = $_POST['tipoSolicitud'];
    $usuario = $_POST['usuario'];
    $nombre = utf8_decode($_POST['nombre']);//nombre del documento a crear
    $procesoA = $_POST['procesoA'];
    $procesoB = $_POST['procesoB'];
    
     if($procesoA != NULL && $procesoB != NULL){
        //echo 'No puede enviar 2 procesos a la vez, selecione únicamente el proceso de su interés';
        ?>
        
        
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformulario"].submit();
                         }
                    </script>
                     
                    <form name="miformulario" action="../../crearDocumentoSolicitudDocumentos" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="validacionExisteProceso" value="1">
                    </form> 
               
        
        <?php
        
    }else{
        
        if($_POST['procesoA'] != NULL){
            $proceso=$_POST['procesoA'];     
        }
        if($_POST['procesoB'] != NULL){
            $proceso=$_POST['procesoB'];   
        }
    
    

    
    $tipoDoc = $_POST['tipoDoc'];
    $encargado = $_POST['encargado'];
    $solicitud = utf8_decode($_POST['solicitud']);
    $fecha = date("Y:m:j");
    
    $nombreEnviar=utf8_encode($nombre); // enviar a los correos
						 
	////////////////////////////////////
	$archivoNombre = $_FILES['archivo']['name'];
    $guardado = $_FILES['archivo']['tmp_name'];
    

     
  //////// validaciones de correo por los cargos según los grupos tengan los permisos
  //echo 'Este es el cargo para validar: '.$encargado;
  //echo '<br><br>';
  ////////// con el id cargo se consulta los usuarios con ese cargo
  
  $extraerUsuarios = $mysqli->query("SELECT * FROM usuario WHERE cargo ='$encargado' ")or die(mysqli_error());
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
                        $consultaGruposNotificacion = $mysqli->query("SELECT * FROM permisosNotificaciones WHERE idGrupo ='$idGrupoValidando' AND formulario='solicitudDocumentos' ")or die(mysqli_error());
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
      //echo '<br><br>';
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
                    $validandoNotificacions='solicitudDocumentos';
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
                    $usuarioH=utf8_encode($nombreU)." ".utf8_encode($apellidoU);
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
                        
                       
                        /////////// Fin se envían los datos de creación de usuario a ese usuario
                    }elseif($correoH > 0){
                        
                       // echo 'estos son los correos: '.$correoU; echo '<br>';
                        
                        /////////// se envían los datos de creación de usuario a ese usuario
                        
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
       
  
 //////////////////// se agrega este campo para las actividades
                    /////////// actividades de traer nombre de modulos de notificaciones
                    $validandoNotificacions='solicitudDocumentos';
                    $usuarioID=$_POST['usuarioActividad'];
                    $plataformaH =$aceptoPlataforma;
                    
                    
                    /////////// fin proceso para traer el nombre del modulo en las notifiaciones
                    
                   if($plataformaH > 0){
                        /////// esta variable se usa para habilitar o desabilitar las notificaciones y diferenciar las solicitudes viejas con las nuevas
                        $plataformaHabilitada='1';
                        ////// fin
                       /*
                        $tituloA='Solicitud de documento';
                        $mensajeA='Se realiza solicitud de documento '.$nombre;
                        
                        date_default_timezone_set('America/Bogota');
                        $fechaA=date('Y-m-j h:i:s A');
                        
                        $agregarActividads= $mysqli->query("INSERT INTO actividades(idUsuario,iformulario,titulo,fecha,mensaje) VALUES('$usuarioID', '$validandoNotificacions', '$tituloA', '$fechaA','$mensajeA')")or die(mysqli_error($mysqli));
                        
                       */
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
  
    
    if($archivoNombre == NULL && $guardado == NULL){
        
        $ruta = 'sin datos';
        
        $mysqli->query("INSERT INTO solicitudDocumentos (estado, quienSolicita, tipoSolicitud, tipoDocumento, encargadoAprobar, nombreDocumento, nombreDocumento2, proceso, solicitud,fecha,documento,plataformaH,docVigente)
                VALUES ('Aprobado','$usuario','$tipoSolicitud','$tipoDoc','$encargado','$nombre','$nombre','$proceso','$solicitud','$fecha','$ruta','$plataformaHabilitada','1')")or die(mysqli_error($mysqli));

        //echo '<script language="javascript">alert("Agregado con Exito");
        //window.location.href="../../solicitudDocumentos"</script>';
        $queryId = $mysqli->query("SELECT MAX(id) AS id FROM `solicitudDocumentos` WHERE quienSolicita = '$usuario' ORDER BY id DESC");
        $datos = $queryId->fetch_array(MYSQLI_ASSOC);
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../crearDocumentoSolicitudDocumentosSeguimiento" method="POST" onsubmit="procesar(this.action);" >
                <input name="id" value="<?php echo $datos['id']; ?>" type="hidden" readonly>
                <input name="tipoSolicitud" value="<?php echo $tipoSolicitud; ?>" type="hidden" readonly>
                <input type="hidden" name="validacionAgregar" value="1">
            </form> 
        <?php
        
    }
    
    if(!file_exists('../../archivos/solicitudes')){
        mkdir('../../archivos/solicitudes',0777,true);
        if(file_exists('../../archivos/solicitudes')){
            if(move_uploaded_file($guardado, '../../archivos/solicitudes/'.$archivoNombre)){
                
                $ruta = utf8_decode('archivos/solicitudes/'.$archivoNombre);
                
                ///////// consultamos la tabla y extraemos el nombre
		        $mysqli->query("INSERT INTO solicitudDocumentos (estado, quienSolicita, tipoSolicitud, tipoDocumento, encargadoAprobar, nombreDocumento, nombreDocumento2, proceso, solicitud,fecha,documento,plataformaH,docVigente)
                VALUES ('Aprobado','$usuario','$tipoSolicitud','$tipoDoc','$encargado','$nombre','$nombre','$proceso','$solicitud','$fecha','$ruta','$plataformaHabilitada','1')")or die(mysqli_error($mysqli));

                //echo '<script language="javascript">alert("Agregado con Exito");
                //window.location.href="../../solicitudDocumentos"</script>';
                $queryId = $mysqli->query("SELECT MAX(id) AS id FROM `solicitudDocumentos` WHERE quienSolicita = '$usuario' ORDER BY id DESC");
                $datos = $queryId->fetch_array(MYSQLI_ASSOC);
                ?>
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformulario"].submit();
                         }
                    </script>
                     
                    <form name="miformulario" action="../../crearDocumentoSolicitudDocumentosSeguimiento" method="POST" onsubmit="procesar(this.action);" >
                        <input name="id" value="<?php echo $datos['id']; ?>" type="hidden" readonly>
                        <input name="tipoSolicitud" value="<?php echo $tipoSolicitud; ?>" type="hidden" readonly>
                        <input type="hidden" name="validacionAgregar" value="1">
                    </form> 
                <?php
                /*
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
                */
            }else{
                
                //echo '<script language="javascript">alert("no se pudo cargar el archivo con Exito");
                //window.location.href="../../solicitudDocumentos"</script>';
                ?>
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformulario"].submit();
                         }
                    </script>
                     
                    <form name="miformulario" action="../../solicitudDocumentos" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="validacionExiste" value="1">
                    </form> 
                <?php
            }
        }
        
    }else{
        if(move_uploaded_file($guardado, '../../archivos/solicitudes/'.$archivoNombre)){
                $ruta = utf8_decode('archivos/solicitudes/'.$archivoNombre);
                ///////// consultamos la tabla y extraemos el nombre
        		$mysqli->query("INSERT INTO solicitudDocumentos (estado, quienSolicita, tipoSolicitud, tipoDocumento, encargadoAprobar, nombreDocumento,nombreDocumento2, proceso, solicitud,fecha,documento,plataformaH,docVigente)
                VALUES ('Aprobado','$usuario','$tipoSolicitud','$tipoDoc','$encargado','$nombre','$nombre','$proceso','$solicitud','$fecha','$ruta','$plataformaHabilitada','1')")or die(mysqli_error($mysqli));

                //echo '<script language="javascript">alert("Agregado con Exito");
                //window.location.href="../../solicitudDocumentos"</script>';
                $queryId = $mysqli->query("SELECT MAX(id) AS id FROM `solicitudDocumentos` WHERE quienSolicita = '$usuario' ORDER BY id DESC");
                $datos = $queryId->fetch_array(MYSQLI_ASSOC);
                ?>
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformulario"].submit();
                         }
                    </script>
                     
                    <form name="miformulario" action="../../crearDocumentoSolicitudDocumentosSeguimiento" method="POST" onsubmit="procesar(this.action);" >
                        <input name="id" value="<?php echo $datos['id']; ?>" type="hidden" readonly>
                        <input name="tipoSolicitud" value="<?php echo $tipoSolicitud; ?>" type="hidden" readonly>
                        <input type="hidden" name="validacionAgregar" value="1">
                    </form> 
                <?php
                /*
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
                */
            }else{
                //echo '<script language="javascript">alert("-");
                //window.location.href="../../solicitudDocumentos"</script>';
                ?>
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformulario"].submit();
                         }
                    </script>
                     
                    <form name="miformulario" action="../../solicitudDocumentos" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="validacionExiste" value="1">
                    </form> 
                <?php
            }
        
    }
	////////////////////////////////////
  
 
    
    
 
 
 
    
    } /// se finaliza la validación del else donde sale la variable $proceso
?>