<?php
error_reporting(E_ERROR);
//////// traemos la bd
    ini_set('display_errors', 1);
    error_reporting(-1);
    error_reporting(E_ERROR);
require_once '../../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario

if(isset($_POST['AgregarUsuario'])){

    ///// datos para la tabla de usuarios
   if($_FILES['foto']['tmp_name'] != NULL){
    $foto= Addslashes(file_get_contents($_FILES['foto']['tmp_name'])); 
   }
   $nombreUsuario = utf8_decode($_POST['nombre']);
   $apellido = utf8_decode($_POST['apellidos']);
   $documento = $_POST['documento'].''.$_POST['tipo'];
   $fechaNacimiento= $_POST['fechaNacimiento'];
   $estado = $_POST['estado'];
   $cargo = $_POST['cargo'];
   $lider = $_POST['lider'];
   $proceso = $_POST['proceso'];
   //$idCentroCostos = $_POST['idCentroCostos'];
   $idCentroTrabajo = $_POST['cTrabajo'];
   json_encode($idCentroTrabajo);
   $arl = utf8_decode($_POST['arl']);
   $eps = utf8_decode($_POST['eps']);
   $afp = utf8_decode($_POST['afp']);
   
   $grupos = $_POST['grupos'];//centros de trabajo 
   json_encode($grupos);
   ///// fin datos para la tabla de usuarios
   
   ////////// datos para la tabla perfil
   $usuario = $nombreUsuario." ".$apellido;
   $pass = $_POST['pass'];
   $correo = $_POST['email'];
   $telefono = $_POST['telefono'];
   ////////// fin datos para la tabla perfil

        
                    

    
    ///////// consultamos la tabla y extraemos el nombre
        $queryUsuario = $mysqli->query("SELECT cedula FROM usuario WHERE cedula = '$documento'  "); //AND tipo='".$_POST['tipo']."'
		$repiteUser = mysqli_num_rows($queryUsuario);
    ///////// consultamos la tabla y extraemos el nombre
   
   /////////////// validamos el nombre que entra al nombre de la consulta
    if($repiteUser > 0){
        //echo 'funciona';
        //echo '<script language="javascript">alert("El usuario ya existe");
        //window.location.href="../../agregarUsuario"</script>';
         ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../usuarios" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExiste" value="1">
            </form> 
        <?php
    }else{
                /// validamos que el año no sea superior al actual
                    date_default_timezone_set('America/Bogota');$fecha1=date('Y-m-j h:i:s A');
                    'año actual: '.$anoActual = intval(substr($fecha1, 0, 4));
                    '<br>Año seleccionado: '.$anoSeleccionado = intval(substr($fechaNacimiento, 0, 4));
                /// END
                
                if($anoSeleccionado > $anoActual){
                    //echo 'La fecha seleccionada no debe superar la del presente año';
                     //echo '<script language="javascript">confirm("La fecha seleccionada no debe superar la del presente año");
                     //window.location.href="../../usuarios"</script>';
                     ?>
                        <script> 
                             window.onload=function(){
                           
                                 document.forms["miformulario"].submit();
                             }
                        </script>
                         
                        <form name="miformulario" action="../../usuarios" method="POST" onsubmit="procesar(this.action);" >
                            <input type="hidden" name="validacionExisteA" value="1">
                        </form> 
                    <?php
                }else{
                        //echo 'registro';
                        
                        
                            // validamos que está activado el ip sesion para navegar sobre la ip de la empresa
                            $consultaClienteSescion=$mysqli->query("SELECT * FROM cliente ");
                            $extraerClienteSesion=$consultaClienteSescion->fetch_array(MYSQLI_ASSOC);
                            
                            if($extraerClienteSesion['sesion'] == 'Si'){
                                $direccionIPEmpresa=$_SERVER['REMOTE_ADDR'];
                            }
                            if($extraerClienteSesion['sesion'] == 'No'){
                                $direccionIPEmpresa='NULL';
                            }
                            //
                        
                       //idCentroCostos
                        $mysqli->query("INSERT INTO usuario (nombres,apellidos,cedula,clave,fechaNacimiento,cargo,lider,proceso,foto,telefono,correo,arl,eps,afp,estadoEliminado,estadoAnulado,sesionIP,estadoUsuario,contadorSesion) 
                            VALUES('$nombreUsuario','$apellido','$documento','$pass','$fechaNacimiento','$cargo','$lider','$proceso','$foto','$telefono','$correo','$arl','$eps','$afp',FALSE,FALSE,'$direccionIPEmpresa','desconectado','0') ")or die(mysqli_error($mysqli));
                            //'$idCentroCostos'
                            $nombreCompleto=$nombreUsuario.' '.$apellido;
                            $agora = date('Y-m-d H:i:s');
							$limite = date('Y-m-d H:i:s', strtotime('+2 min'));
							//$mysqli->query("INSERT INTO chat_users (username,password,current_session,online)VALUES('$nombreUsuario','$documento','0','0' ) ")or die(mysqli_error($mysqli));
                            
                        $ran_id = rand(time(), 100000000);    
                        $mysqli->query("INSERT INTO users (unique_id, fname, lname, email, password, status)VALUES ({$ran_id}, '{$nombreUsuario}','{$apellido}', '{$documento}', '{$documento}', 'Offline now')");
                            
                            $extraerId = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$documento'");
                            $idGrup = $extraerId->fetch_array(MYSQLI_ASSOC);
                            $idUsuario = $idGrup['id'];
                            
                            foreach($grupos as $grupos){
                            
                                //validacion que cTrabajo no haya sido agregado a ese grupo
                                $validacionGrupos = $mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario = '$idUsuario' AND idGrupo = '$grupos'");
                                $num_row = mysqli_num_rows($validacionGrupos);
                                if($num_row > 0){
                                
                                    continue;
                                    
                                }else{
                                    //insert a grupoUcargo  
                                    $grupos;
                                    $mysqli->query("INSERT INTO grupoUusuario (idGrupo, idUsuario) VALUES ('$grupos','$documento')");
                                }
                            
                            }//end foreach
                            
                            foreach($idCentroTrabajo as $idCentroTrabajo){
                            
                                //validacion que cTrabajo no haya sido agregado a ese grupo
                                $validacionGrupo = $mysqli->query("SELECT * FROM cTrabajoUusuario WHERE idUsuario = '$documento' AND idCtrabajo = '$idCentroTrabajo'");
                                $num_rows = mysqli_num_rows($validacionGrupo);
                                if($num_rows > 0){
                                
                                    continue;
                                    
                                }else{ 
                                    //insert a grupoUcargo  
                                    $idCentroTrabajo;
                                    $mysqli->query("INSERT INTO cTrabajoUusuario (idCtrabajo, idUsuario) VALUES ('$idCentroTrabajo','$documento')");
                                    
                                    
                                    
                                }
                            
                            }//end foreach
                            
                           
                                        
                                       
                                            $tituloA='Nuevo usuario creado';
                                            $mensajeACompletar=utf8_decode('Se crea usuario para el señor ');
                                            $mensajeA=$mensajeACompletar.$usuario;
                                            
                                            date_default_timezone_set('America/Bogota');
                                            $fechaA=date('Y-m-j h:i:s A');
                                            
                                           // $agregarActividads= $mysqli->query("INSERT INTO actividades(idUsuario,iformulario,titulo,fecha,mensaje) VALUES('$documento', '$validandoNotificacions', '$tituloA', '$fechaA','$mensajeA')")or die(mysqli_error($mysqli));
                                         
                                            /////////// se envían los datos de creación de usuario a ese usuario
                                            $nombreEnviar=$_POST['nombre'];
                                            $apellidoEnviar=$_POST['apellidos'];
                                            $documentoSoloNumero=substr($documento,0,-1);
                                            $pass;
                                            $_POST['email'];


                                            require 'libreria/PHPMailerAutoload.php';

                                            //Create a new PHPMailer instance
                                            $mail = new PHPMailer();
                                            $mail->IsSMTP();
                                             
                                            //Configuracion servidor mail
                                            require '../../correoEnviar/contenido.php';
                                            
                                            //Agregar destinatario
                                            $mail->isHTML(true);
                                            $mail->AddAddress($_POST['email']);
                                            $mail->Subject = 'Registro usuario';
                                            //$mail->Body = $_POST['message'];
                                            
                                            $mail->Body = utf8_decode('
                                            <html>
                                            <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                            <title>HTML</title>
                                            </head>
                                            <body>
                                            <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                                            
                                            <p>Estimado (a). <b><em>'.$nombreEnviar.' '.$apellidoEnviar.'</em></b>.
                                            <br>
                                            <p><b>Bienvenido (a) a FIXWEI, su aliado estratégico en gestión de procesos.</b></p>
                                             A continuación, conozca las credenciales para acceder al sistema e iniciar su experiencia en FIXWEI.
                                            
                                            <br><br>Usuario: <b><em>'.$documentoSoloNumero.'</em></b>
                                            <br>Clave: <b><em>'.$pass.'</em></b>
                                            <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                            <br><br>
                                            Se recomienda ingresar y realizar el cambio de contraseña.
                                            <b>El caracter que encuentra al final del usuario corresponde al tipo de documento de identidad que tiene asignado,
                                            por lo cual no debe ser digitado y corresponde a la selección de documento segun corresponda.</b>
                                            <br><br>
                                            Este correo es informativo por tanto, le pedimos no responda este mensaje.
                                            </p>
                                            </body>
                                            </html>
                                            ');
                                            
                                            //Avisar si fue enviado o no y dirigir al index
                                           
                                            if ($mail->Send()) {
                                                //echo'<script type="text/javascript">
                                                //       alert("Enviado Correctamente");
                                                //    </script>';
                                                //header("Location: datos");
                                                ?>
                                                <script> 
                                                     window.onload=function(){
                                                   
                                                         document.forms["miformulario"].submit();
                                                     }
                                                </script>
                                                 
                                                <form name="miformulario" action="../../usuarios" method="POST" onsubmit="procesar(this.action);" >
                                                    <input type="hidden" name="validacionAgregar" value="1">
                                                </form> 
                                             <?php 
                                            } else {
                                                //echo'<script type="text/javascript">
                                                //       alert("NO ENVIADO, intentar de nuevo");
                                                //    </script>';
                                                ?>
                                                <script> 
                                                     window.onload=function(){
                                                        alert('NO ENVIADO, intentar de nuevo');
                                                         document.forms["miformulario"].submit();
                                                     }
                                                </script>
                                                 
                                                <form name="miformulario" action="../../usuarios" method="POST" onsubmit="procesar(this.action);" >
                                                </form> 
                                                <?php 
                                            }
                                           
                                           
                                            /////////// Fin se envían los datos de creación de usuario a ese usuario
                                
                                        
                                        
                                        
                                         
                                           
                }  
                       
                    
    }
}
  /////////////// End validamos el nombre que entra al nombre de la consulta
    
    
if(isset($_POST['EditarUsuario'])){
    error_reporting(E_ERROR);
    $id = $_POST['idUsuario'];
     ///// datos para la tabla de usuarios
   if($_FILES['foto']['tmp_name'] != NULL){
   $foto= Addslashes(file_get_contents($_FILES['foto']['tmp_name'])); 
   }
   $nombreUsuario = utf8_decode($_POST['nombre']);
   $apellido = utf8_decode($_POST['apellidos']);
   //$documento = $_POST['documento'];
   $documento = $_POST['documento'].''.$_POST['tipo'];
   $cedulaAntigua = $_POST['cedulaAntigua'];
   $fechaNacimiento= $_POST['fechaNacimiento'];
   $cargo = $_POST['cargo'];
   $lider = $_POST['lider'];
   $telefono = $_POST['telefono'];
   $proceso = $_POST['proceso'];
  // $idCentroCostos = $_POST['idCentroCostos'];
   $idCentroTrabajo = $_POST['idCentroTrabajo'];
   $arl = utf8_decode($_POST['arl']);
   $eps = utf8_decode($_POST['eps']);
   $afp = utf8_decode($_POST['afp']);
   ///// fin datos para la tabla de usuarios
   $grupos = $_POST['grupos'];//centros de trabajo 
   json_encode($grupos);
   $idCentroTrabajo = $_POST['cTrabajo'];
   json_encode($idCentroTrabajo);
   ////////// datos para la tabla perfil
   $usuario = $_POST['usuario'];
   $pass = $_POST['pass'];
   $correo = $_POST['email'];
   
   ////////// fin datos para la tabla perfil

     ///////// consultamos la tabla y extraemos el nombre
      $documento;
      '<br>';
       $id;
      '<br>';
        $queryUsuario = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$documento' "); //AND tipo='".$_POST['tipo']."'
		 'Documento: '.$repiteUser = mysqli_num_rows($queryUsuario);
         '<br>';
        $queryUsuarioId = $mysqli->query("SELECT * FROM usuario WHERE id = '$id' "); //AND tipo='".$_POST['tipo']."'
        $validandoUsuario=$queryUsuarioId->fetch_array(MYSQLI_ASSOC);
		 'ID: '.$repiteUserId = mysqli_num_rows($queryUsuarioId);

         '<br>';
		
	
	if($validandoUsuario['cargo'] == $cargo){
	}else{
	     'Cambio cargo verificar solicitudes';
	    
	    
	    ///// verificamos las solicitudes que contienen el cargo pendiente para recuperar las solicitudes
	    
	    $recorridoSolicitudesPendientes=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE encargadoAprobar='".$validandoUsuario['cargo']."' AND estado IS NULL ");
	    while($extraerRecorridoSolicitudesPendiente=$recorridoSolicitudesPendientes->fetch_array()){
	        $extraerRecorridoSolicitudesPendiente['id'];  '<br>';
	        /// mantenemos las solicitudes pendiente encargadas
	        $updateUsuario=$mysqli->query("UPDATE solicitudDocumentos SET cambioCargo='$cargo' WHERE id='".$extraerRecorridoSolicitudesPendiente['id']."'  ");
	    }
	    
	    //// END
	}
    ///////// consultamos la tabla y extraemos el nombre    
	
	
	
	
		
	
		if($validandoUsuario['cedula'] == $documento || $repiteUser == 0){ //$repiteUser > 0 
            
            //echo 'Debes actualizar';
         
		    //echo 'la cc y el id es el mismo';
		    
		    if($foto != NULL){
                $mysqli->query("UPDATE usuario SET  telefono='$telefono',foto ='$foto',clave='$pass',correo='$correo',nombres='$nombreUsuario', apellidos = '$apellido', fechaNacimiento='$fechaNacimiento', cargo='$cargo', lider='$lider', proceso='$proceso', cedula='$documento' ,arl='$arl',eps='$eps',afp='$afp' WHERE id = '$id'")or die(mysqli_error($mysqli));//idCentroCostos = '$idCentroCostos'
                $mysqli->query("UPDATE users SET fname = '$nombreUsuario', lname='$apellido', password='$documento', email='$documento' WHERE password='".$_POST['cedulaAntigua']."' ")or die(mysqli_error($mysqli));
                
                
                


            }else{
                $mysqli->query("UPDATE usuario SET  telefono='$telefono',clave='$pass',correo='$correo',nombres='$nombreUsuario', apellidos = '$apellido', fechaNacimiento='$fechaNacimiento', cargo='$cargo', lider='$lider', proceso='$proceso', cedula='$documento', arl='$arl',eps='$eps',afp='$afp' WHERE id = '$id'")or die(mysqli_error($mysqli));//idCentroCostos = '$idCentroCostos',
                $mysqli->query("UPDATE users SET fname = '$nombreUsuario', lname='$apellido', password='$documento', email='$documento' WHERE password='".$_POST['cedulaAntigua']."' ")or die(mysqli_error($mysqli));
                
            }
            
            $mysqli->query("DELETE FROM grupoUusuario WHERE idUsuario = '".$_POST['cedulaAntigua']."' ");
            foreach($grupos as $grupos){
                
                
                    //insert a grupoUcargo  
                    $mysqli->query("INSERT INTO grupoUusuario (idGrupo, idUsuario) VALUES ('$grupos','$documento')");
        
                
                }//end foreach
                
            $mysqli->query("DELETE FROM cTrabajoUusuario WHERE idUsuario = '".$_POST['cedulaAntigua']."' ");
            foreach($idCentroTrabajo as $idCentroTrabajo){
                
                
                    //insert a grupoUcargo  
                    $mysqli->query("INSERT INTO cTrabajoUusuario (idCtrabajo, idUsuario) VALUES ('$idCentroTrabajo','$documento')");
        
                
                }//end foreach    
               
            //header ('location: ../../usuarios');
            //echo '<script language="javascript">
            //window.location.href="../../usuarios"</script>';
             ?>
                <script> 
                     window.onload=function(){
                   
                         document.forms["miformulario"].submit();
                     }
                </script>
                 
                <form name="miformulario" action="../../usuarios" method="POST" onsubmit="procesar(this.action);" >
                    <input type="hidden" name="validacionActualizar" value="1">
                </form> 
                <?php
		
		}else{
            //echo 'Existe';
           
		    //echo 'no existe en la misa columna ';
		    //echo '<script language="javascript">alert("La cédula ya existe con otro usuario, asegúrese que el número de documento permanezca al usuario que se encuentra editando ");
            //window.location.href="../../usuarios"</script>';
            ?>
                <script> 
                     window.onload=function(){
                   
                         document.forms["miformulario"].submit();
                     }
                </script>
                 
                <form name="miformulario" action="../../usuarios" method="POST" onsubmit="procesar(this.action);" >
                    <input type="hidden" name="validacionExisteB" value="1">
                </form> 
            <?php
                    }
    
    
	



    
  
    
}
if(isset($_POST['EliminarUsuario'])){
    $eliminador=$_POST['sesion'];
    $id = $_POST['idUsuario'];
    
                    $nombreUsuario = $mysqli->query("SELECT * FROM usuario WHERE id ='$id' ")or die(mysqli_error());
                    $col = $nombreUsuario->fetch_array(MYSQLI_ASSOC);
                    $idUsuario = $col['id'];
                    $nombreUsuario = $col['nombres'];
                    $apellido = $col['apellidos'];
                    $documento = $col['cedula'];
                    $pass = $col['clave'];
                    $telefono = $col['telefono'];
                    $correo = $col['correo'];
                    $cargo = $col['cargo'];
                    $lider = $col['lider'];
                    $fechaNacimiento = $col['fechaNacimiento'];
                    $proceso = $col['proceso'];
                    $arl = $col['arl'];
                    $eps = $col['eps'];
                    $afp = $col['afp'];
                   // $idCentroCostos = $col['idCentroCostos'];
                   
                    
                    $nombreCentroTrabajo = $mysqli->query("SELECT * FROM cTrabajoUusuario WHERE idUsuario ='$documento' ")or die(mysqli_error());
                    $colCT = $nombreCentroTrabajo->fetch_array(MYSQLI_ASSOC);
                    $idCentroTrabajo = $colCT['idCtrabajo'];
                    
                    
                    $nombreGrupo = $mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario ='$documento' ")or die(mysqli_error());
                    $colCTG = $nombreGrupo->fetch_array(MYSQLI_ASSOC);
                    $idGrupo = $colCTG['idGrupo'];
                    
                    
                    
   //idCentroCostos
   $ingresaCC=$mysqli->query("INSERT INTO usuarioEliminado (quienelimina,idUsuario,nombres,apellidos,cedula,clave,fechaNacimiento,cargo,lider,proceso,telefono,correo,arl,eps,afp,idCentroTrabajo,grupo) 
        VALUES('$eliminador','$idUsuario','$nombreUsuario','$apellido','$documento','$pass','$fechaNacimiento','$cargo','$lider','$proceso','$telefono','$correo','$arl','$eps','$afp','$idCentroTrabajo','$idGrupo') ")or die(mysqli_error($mysqli));//'$idCentroCostos'
        
    
    if($ingresaCC != NULL){
        $mysqli->query("DELETE FROM usuario WHERE id = '$id'")or die(mysqli_error($mysqli));
        $mysqli->query("DELETE FROM grupoUusuario WHERE idUsuario = '$documento'"); //elimina el usuario de grupos
        $mysqli->query("DELETE FROM cTrabajoUusuario WHERE idUsuario= '$documento'"); //elimina el usuario de grupos
        //// eliminamos también el usuario del chat
        $mysqli->query("DELETE FROM users WHERE password='$documento' ")or die(mysqli_error($mysqli));
        ////
        
        //// eliminamos todas las conversaciones
        $borrar_chat=$mysqli->query("SELECT * FROM users WHERE email='$documento' ")or die(mysqli_error($mysqli));
        $extraer_borrar_chat=$borrar_chat->fetch_array(MYSQLI_ASSOC);
        $mysqli->query("DELETE FROM messages WHERE incoming_msg_id='".$extraer_borrar_chat['unique_id']."' ")or die(mysqli_error($mysqli));
        $mysqli->query("DELETE FROM messages WHERE outgoing_msg_id='".$extraer_borrar_chat['unique_id']."' ")or die(mysqli_error($mysqli));
        // eliminamos el usuario de mensajeria
        $mysqli->query("DELETE FROM users WHERE email='$documento' ")or die(mysqli_error($mysqli));
    }
    
    //header ('location: ../../usuarios');
    //echo '<script language="javascript">
    //window.location.href="../../usuarios"</script>';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../usuarios" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminar" value="1">
            </form> 
        <?php
}
if(isset($_POST['EliminarUsuarioForEver'])){
    
    $id = $_POST['idUsuario'];
    $mysqli->query("DELETE FROM usuarioEliminado WHERE id = '$id'")or die(mysqli_error($mysqli));
    //$mysqli->query("DELETE FROM usuario WHERE id = '$id'")or die(mysqli_error($mysqli));
    $mysqli->query("DELETE FROM grupoUusuario WHERE idUsuario = '$id'"); //elimina el usuario de grupos 
    //$mysqli->query("DELETE FROM usuarioEliminado WHERE idUsuario = '$id'"); //elimina el usuario eliminar 
    
    //header ('location: ../../usuariosEliminados');
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../usuariosEliminados" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminar" value="1">
            </form> 
        <?php 
}
if(isset($_POST['AnularUsuario'])){
    
    $id = $_POST['idUsuario'];
    
    
    $mysqli->query("UPDATE usuario SET estadoAnulado = TRUE, estadoUsuario='desconectado', contadorSesion='0' WHERE cedula = '$id'")or die(mysqli_error($mysqli));

    
     //header ('location: ../../usuarios');
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../usuarios" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminarB" value="1">
            </form> 
        <?php
    
}
if(isset($_POST['ActivarUsuario'])){
    
    $id = $_POST['idUsuario'];
    
    
    $mysqli->query("UPDATE usuario SET estadoAnulado = FALSE WHERE cedula = '$id'")or die(mysqli_error($mysqli));

    
    //header ('location: ../../usuarios');
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../usuarios" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionAgregarB" value="1">
            </form> 
        <?php
    
}
if(isset($_POST['EditarClienteAdmin'])){
    
   $foto= Addslashes(file_get_contents($_FILES['imagen']['tmp_name'])); 
   $nombreUsuario = $_POST['nombre'];
   $nit = $_POST['nit'];
   $direccion = $_POST['direccion'];
   $telefono = $_POST['telefono'];
   $administrador = $_POST['administrador'];
   $adminUsuario = $_POST['adminUsuario'];
   $correo = $_POST['correo'];
   $correoSi = $_POST['correoSi'];
   $clave=$_POST['clave'];
    
    if($foto != NULL){
        $mysqli->query("UPDATE cliente SET nombre='$nombreUsuario', clave='$clave', nit='$nit', img='$foto', telefono='$telefono', direccion='$direccion', administrador='$administrador', usuario='$adminUsuario', email='$correo' ")or die(mysqli_error($mysqli));
    }else{
        $mysqli->query("UPDATE cliente SET nombre='$nombreUsuario', clave='$clave', nit='$nit', telefono='$telefono', direccion='$direccion', administrador='$administrador', usuario='$adminUsuario', email='$correo' ")or die(mysqli_error($mysqli));
    }
                    if($correoSi == 'Si'){
                        require 'libreria/PHPMailerAutoload.php';

                                            //Create a new PHPMailer instance
                                            $mail = new PHPMailer();
                                            $mail->IsSMTP();
                                             
                                            //Configuracion servidor mail
                                            require '../../correoEnviar/contenido.php';
                                            
                                            //Agregar destinatario
                                            $mail->isHTML(true);
                                            $mail->AddAddress($correo);
                                            $mail->Subject = 'Registro cliente';
                                            //$mail->Body = $_POST['message'];
                                            
                                            $mail->Body = utf8_decode('
                                            <html>
                                            <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                            <title>HTML</title>
                                            </head>
                                            <body>
                                            <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                                            
                                            <p>Estimado (a). <b><em>'.$administrador.'</em></b>.
                                            <br>
                                            <p><b>Bienvenido (a) a FIXWEI, su aliado estratégico en gestión de procesos.</b></p>
                                             A continuación, conozca las credenciales para acceder al sistema e iniciar su experiencia en FIXWEI.
                                            
                                            <br><br>Usuario: <b><em>'.$adminUsuario.'</em></b>
                                            <br>Clave: <b><em>'.$clave.'</em></b>
                                            <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                            <br><br>
                                            Se recomienda ingresar y realizar el cambio de contraseña.
                                            <b>El caracter que encuentra al final del usuario corresponde al tipo de documento de identidad que tiene asignado,
                                            por lo cual no debe ser digitado y corresponde a la selección de documento segun corresponda.</b>
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
                        /*
                    $to = $correo;
                    $subject = "Registro cliente";
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                     
                   $message = "
                    <html>
                    <head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
                    <title>HTML</title>
                    </head>
                    <body>
                    <img src='https://fixwei.com/plataforma/pages/iconos/correo.png' width='200px' height='100px'><br>
                    
                    <p>Estimado (a). <b><em>$administrador</em></b>.
                    <br>
                    <p><b>Bienvenido (a) a FIXWEI, su aliado estratégico en gestión de procesos.</b></p>
                     A continuación, conozca las credenciales para acceder al sistema e iniciar su experiencia en FIXWEI.
                    
                    <br><br>Usuario: <b><em>$adminUsuario</em></b>
                    <br>Clave: <b><em>$clave</em></b>
                    <br><br><a target='_black' href='http://fixwei.com/plataforma/pages/examples/login'>Acceder</a>.
                    <br><br>
                    Se recomienda ingresar y realizar el cambio de contraseña.
                    <br><br>
                    Este correo es informativo por tanto, le pedimos no responda este mensaje.
                    </p>
                    </body>
                    </html>";
                     
                    mail($to, $subject, $message, $headers);*/
                    }
      ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../cliente" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionActualizar" value="1">
            </form> 
    <?php              
     //header ('location: ../../cliente');
    
}
?>