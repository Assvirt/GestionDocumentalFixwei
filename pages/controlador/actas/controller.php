<?php
/* Controller ACTAS */
//////// traemos la bd
require_once '../../conexion/bd.php';
date_default_timezone_set('America/Bogota');
session_start();
$celdulaUser = $_SESSION['session_username']; 
$cargoID = $_SESSION['session_cargo']; 
$idUsuario = $_SESSION['session_idUsuario'];
 
error_reporting(E_ERROR); 
////////// validamos el ingreso por el name del  boton del formulario


if(isset($_POST['compromisoIndividual'])){
    
    
    
    ////////// datos solo para almacenar información a los comentarios del compromiso
    $idCompromisoC = $_POST['idCompromisoC'];
    $estadoActaC = $_POST['estadoC'];
    $controlCambioC = utf8_decode($_POST['controlCambioC']);
    
   
    
    
    date_default_timezone_set("America/Bogota");
    $fecha = date("Ymjhis");
    $fechaCompromisoC = date("Y:m:j h:i:s");
    $estadoComentarioActaC = $_POST['estadoComentarioActaC'];
    if($controlCambioC != NULL){ //// aplicamos el campo dirigido para enviar los comentarios de cada usuario como tipo chat
        $mysqli->query("INSERT INTO controlCambiosCompromisos(idCompromiso, comentario, usuario, fecha, historia, dirigido) VALUES('$idCompromisoC','$controlCambioC','$celdulaUser','$fechaCompromisoC','$estadoComentarioActaC', '".$_POST['responsableCompromisoID']."')");
    }else{
        $mysqli->query("INSERT INTO controlCambiosCompromisos(idCompromiso, comentario, usuario, fecha, historia, dirigido) VALUES ('$idCompromisoC','N/A','$celdulaUser','$fechaCompromisoC','$estadoComentarioActaC', '".$_POST['responsableCompromisoID']."')");

    }
    $mysqli->query("UPDATE compromisos SET estado = '$estadoActaC' WHERE id = $idCompromisoC");
    ///////////// end
    
    
    
    $nombreCompromiso=$_POST['nombreCompromiso'];
    
    $reponsable = $_POST['responsableCompromiso'];
    $responsableID = $_POST['responsableCompromisoID'];
    $idCompromiso = $_POST['idCompromiso'];
    $estado = $_POST['estado']; 
    $estadoArpobado = $_POST['radbtnEstado'];
    $idActa = $_POST['idActa']; 
    $nombreArchivo =$_FILES['archivo']['name']; 
    $rutaArchivo = $_FILES['archivo']['tmp_name']; 
    $nombreCarpeta = "acta".$idActa; 
    
    $fecha = date("Ymjhis");
    $nombre = $fecha.$nombreArchivo;
    
    if($estado != NULL){//Aca sube un avance o ejecutado, se sube el documento y se hace el comentario
        if(!file_exists('../../archivos/compromisos/'.$nombreCarpeta.'/')){
        
        	mkdir('../../archivos/compromisos/'.$nombreCarpeta.'/',0777,true);
        	if(file_exists('../../archivos/compromisos/'.$nombreCarpeta.'/')){
        	    
        		if(move_uploaded_file($rutaArchivo, '../../archivos/compromisos/'.$nombreCarpeta.'/'.$nombre)){
        	        //Guarda archivo
        	          //echo "Sii se suibio el archivo";
        		}else{
        			echo "Archivo no se pudo guardar 1";
        		}
        	}
        	
        }else{
            
        	if(move_uploaded_file($rutaArchivo, '../../archivos/compromisos/'.$nombreCarpeta.'/'.$nombre)){
               // echo "Sii se suibio el archivo";
        	}else{
        		//echo "Archivo no se pudo guardar 2";
        	}
        }
        
        $queryCompromiso = $mysqli->query("SELECT * FROM compromisosIndividuales WHERE id_compromiso = '$idCompromiso' AND responsableId = '$responsableID'");
        $numQuery = mysqli_num_rows($queryCompromiso);
        $nombreB=utf8_decode($nombre);
        if($numQuery < 1){
            $mysqli->query("INSERT INTO compromisosIndividuales (id_compromiso, id_responsable, estado, responsable, responsableId, rutaAvance) VALUES ('$idCompromiso','$responsableID','$estado','$reponsable','$responsableID','$nombreB')")or die(mysqli_error($mysqli));
        }else{
            $mysqli->query("UPDATE compromisosIndividuales SET estado = '$estado', rutaAvance = '$nombreB' WHERE id_compromiso = '$idCompromiso' AND responsableId = '$responsableID'");
        }
        

    }
    
     'estado: '.$estadoArpobado;
 
   if($estadoArpobado != NULL){//aca cuando el aprobador actualiza el estado.
        if($estadoArpobado == 'Aprobado'){ /// validamos que el estado quede aprobado, para mostrar la notificación en plataforma, en actas / gestión de compromiso
            $mysqli->query("UPDATE compromisosIndividuales SET estado = '$estadoArpobado', mensaje='1' WHERE id_compromiso = '$idCompromiso' AND responsableId = '$responsableID'");
        }
        $mysqli->query("UPDATE compromisosIndividuales SET estado = '$estadoArpobado' WHERE id_compromiso = '$idCompromiso' AND responsableId = '$responsableID'");
    }

    if($estadoArpobado == 'Rechazado'){ /// si se rechaza el compromiso notifica al responsable que fue rechazado
            
        $idCompromiso;
        $consultandoComprimisos=$mysqli->query("SELECT * FROM `compromisos` WHERE id= '$idCompromiso' ");
        $sacarCompromisos=$consultandoComprimisos->fetch_array(MYSQLI_ASSOC);
        $idCompromisoConsultar=$sacarCompromisos['id'];
            '-'.$nombreDocEnviar=utf8_encode($sacarCompromisos['compromiso']);
        
        require '../usuarios/libreria/PHPMailerAutoload.php';
        
        $recorriendoResponsables=$mysqli->query("SELECT * FROM compromisosIndividuales WHERE id_compromiso='$idCompromisoConsultar' AND estado='Rechazado' AND responsableId = '$responsableID' ");
        while($extraerRecorriendoResponsables=$recorriendoResponsables->fetch_array()){
               'Tipo: '.$rad_Res=$extraerRecorriendoResponsables['responsable'];  '<br>';
                  'ID responsable: '.$arrayEncargado=$extraerRecorriendoResponsables['id_responsable'];  '<br>';
                

                if($rad_Res == 'usuario'){ 
                    
                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$arrayEncargado' ");
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
                            $mail->Subject = utf8_decode('Encargado para gestionar el compromiso'); //Gestión de compromiso '.$nombreDocEnviar
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
                            <p>El compromiso <b>'.$nombreDocEnviar.'.</b> fue rechazado y está disponible para su revisión.</p>
                            Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                            <br>
                            <em>Mi perfil --> mis pendientes --> Actas --> Aprobación de compromisos +</em>.
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
        
                if($rad_Res == 'cargo'){
                
                    
                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo='$arrayEncargado' ");
                        while($columna = $nombreuser->fetch_array()){
                            'Nombre: '.$nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                            '--Correo: '.$correoResponsable=$columna['correo']; 
                            '<br>';
                            
                            //Create a new PHPMailer instance
                            $mail = new PHPMailer();
                            $mail->IsSMTP();
                            
                            //Configuracion servidor mail
                            require '../../correoEnviar/contenido.php';
                            
                            //Agregar destinatario
                            $mail->isHTML(true);
                            $mail->AddAddress($correoResponsable);
                            $mail->Subject = utf8_decode('Encargado para gestionar el compromiso'); //Gestión de compromiso '.$nombreDocEnviar
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
                            <p>El compromiso <b>'.$nombreDocEnviar.'.</b> fue rechazado y está disponible para su revisión.</p>
                            Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                            <br>
                            <em>Mi perfil --> mis pendientes --> Actas --> Aprobación de compromisos +</em>.
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
                            //echo 'Enviado';
                            } else {
        
                            }
                        
                            
                        }
                    
                }
        }
    }
    
    if($estadoArpobado == 'Aprobado'){ /// si se aprueba el compromiso, notifica al responsable que fue aprobado
            
        $idCompromiso;
        $consultandoComprimisos=$mysqli->query("SELECT * FROM `compromisos` WHERE id= '$idCompromiso' ");
        $sacarCompromisos=$consultandoComprimisos->fetch_array(MYSQLI_ASSOC);
        $idCompromisoConsultar=$sacarCompromisos['id'];
            '-'.$nombreDocEnviar=utf8_encode($sacarCompromisos['compromiso']);
        
        require '../usuarios/libreria/PHPMailerAutoload.php';
        
        $recorriendoResponsables=$mysqli->query("SELECT * FROM compromisosIndividuales WHERE id_compromiso='$idCompromisoConsultar' AND estado='Aprobado' AND responsableId = '$responsableID' ");
        while($extraerRecorriendoResponsables=$recorriendoResponsables->fetch_array()){
               'Tipo: '.$rad_Res=$extraerRecorriendoResponsables['responsable'];  '<br>';
                  'ID responsable: '.$arrayEncargado=$extraerRecorriendoResponsables['id_responsable'];  '<br>';
                

                if($rad_Res == 'usuario'){ 
                    
                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$arrayEncargado' ");
                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']);
                        $correoResponsable=$columna['correo'];  
        
                            //Create a new PHPMailer instance
                            $mail = new PHPMailer();
                            $mail->IsSMTP();
                            
                            //Configuracion servidor mail
                            require '../../correoEnviar/contenido.php';
                            
                        //Agregar destinatario
                            $mail->isHTML(true);
                            $mail->AddAddress($correoResponsable);
                            $mail->Subject = utf8_decode('Encargado para gestionar el compromiso'); //Gestión de compromiso '.$nombreDocEnviar
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
                            <p>El compromiso <b>'.$nombreDocEnviar.'.</b> fue aprobado.</p>
                            Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                            <br>
                            <em>Mi perfil --> mis pendientes --> Actas --> Aprobación de compromisos +</em>.
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
        
                if($rad_Res == 'cargo'){
                
                    
                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo='$arrayEncargado' ");
                        while($columna = $nombreuser->fetch_array()){
                            'Nombre: '.$nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                            '--Correo: '.$correoResponsable=$columna['correo']; 
                            '<br>';
                            
                            //Create a new PHPMailer instance
                            $mail = new PHPMailer();
                            $mail->IsSMTP();
                            
                            //Configuracion servidor mail
                            require '../../correoEnviar/contenido.php';
                            
                            //Agregar destinatario
                            $mail->isHTML(true);
                            $mail->AddAddress($correoResponsable);
                            $mail->Subject = utf8_decode('Encargado para gestionar el compromiso'); //Gestión de compromiso '.$nombreDocEnviar
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
                            <p>El compromiso <b>'.$nombreDocEnviar.'.</b> fue aprobado.</p>
                            Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                            <br>
                            <em>Mi perfil --> mis pendientes --> Actas --> Aprobación de compromisos +</em>.
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
                            //echo 'Enviado';
                            } else {
        
                            }
                        
                            
                        }
                    
                }
        }
    }
    
  
    //Actualizar estado general del compromiso
    
    $compromisosIndividuales = $mysqli->query("SELECT * FROM `compromisosIndividuales` WHERE id_compromiso = '$idCompromiso'");
    $numCompromisos = mysqli_num_rows($compromisosIndividuales);
    $numAprobados = 0;
    
    while($col = $compromisosIndividuales->fetch_assoc()){
        
        if($col['estado'] == "Aprobado"){
            $numAprobados++;
        }
        
        if($numAprobados == $numCompromisos){
            $estadoGeneral = "Aprobado";
        }else{
            $estadoGeneral = "Pendiente";
        }
    }
    
    $mysqli->query("UPDATE compromisos SET estado = '$estadoGeneral' WHERE id = '$idCompromiso'");

    
    
    //$mysqli->query("INSERT INTO compromisosIndividuales (id_compromiso, id_responsable, estado, responsable, responsableId, rutaAvance) VALUES ('$idCompromiso','$responsableID','$estado','$reponsable','$responsableID','$nombre')")or die(mysqli_error($mysqli));
    
    ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                     //alert("Compromiso actualizado.");
                 }
            </script>
             
            <form name="miformulario" action="../../seguimientoActasEntrega" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionActualizar" value="1">
                <input type="hidden" name="idActa" value="<?php echo $idActa; ?>">
                <input name="nombreCompromiso" value="<?php echo $nombreCompromiso;?>" type="hidden">
            </form> 
    <?php  //seguimientoActas

}


if(isset($_POST['compromisoIndividualB'])){
    
    ////////// datos solo para almacenar información a los comentarios del compromiso
    $idCompromisoC = $_POST['idCompromisoC'];
    $estadoActaC = $_POST['estadoC'];
    
    // estas variables se encontaban después del insert de control cambios compromisos
    'id del responsable: '.$responsableID = $_POST['responsableCompromisoID'];
    '<br> id del compromiso: '.$idCompromiso = $_POST['idCompromiso'];
    '<br>comentario: '.$controlCambioC = utf8_decode($_POST['controlCambioC']);
    
    date_default_timezone_set("America/Bogota");
    $fecha = date("Ymjhis");
    $fechaCompromisoC = date("Y:m:j h:i:s");
    $estadoComentarioActaC = $_POST['estadoComentarioActaC'];
    
    
    /// capturamos el id del responsable del compromiso para identificar el primer comentario y desglosar la respuesta del aprobador debajo
    $consulta_primer_comentario=$mysqli->query("SELECT * FROM controlCambiosCompromisos WHERE idCompromiso='$idCompromisoC' AND usuario='$celdulaUser' ");
    $extraer_respuesta_primer_comentario=$consulta_primer_comentario->fetch_array(MYSQLI_ASSOC);
    
    //// validamos que no exista el registro del primer comentario del id compromiso concatenado con el id usuario
    
    if($extraer_respuesta_primer_comentario['id'] != NULL){
         '<br>Existe primer comentario';
        if($controlCambioC != NULL){
            $mysqli->query("INSERT INTO controlCambiosCompromisos(idCompromiso, comentario, usuario, fecha, historia) VALUES('$idCompromisoC','$controlCambioC','$celdulaUser','$fechaCompromisoC','$estadoComentarioActaC')");
        }else{
            $mysqli->query("INSERT INTO controlCambiosCompromisos(idCompromiso, comentario, usuario, fecha, historia) VALUES ('$idCompromisoC','N/A','$celdulaUser','$fechaCompromisoC','$estadoComentarioActaC')");
        }
    }else{
         '<br>No existe primer comentario - continua demás comentarios';
        if($controlCambioC != NULL){
            $mysqli->query("INSERT INTO controlCambiosCompromisos(idCompromiso, comentario, usuario, fecha, historia, primerComentario) VALUES('$idCompromisoC','$controlCambioC','$celdulaUser','$fechaCompromisoC','$estadoComentarioActaC','1')");
        }else{
            $mysqli->query("INSERT INTO controlCambiosCompromisos(idCompromiso, comentario, usuario, fecha, historia, primerComentario) VALUES ('$idCompromisoC','N/A','$celdulaUser','$fechaCompromisoC','$estadoComentarioActaC','1')");
        }
    }
    
    
    $mysqli->query("UPDATE compromisos SET estado = '$estadoActaC' WHERE id = $idCompromisoC");
    ///////////// end
    
    
    $nombreCompromiso=$_POST['nombreCompromiso'];
    
    $reponsable = $_POST['responsableCompromiso'];
    
    
    $estado = $_POST['estado']; 
    $estadoArpobado = $_POST['radbtnEstado'];
    $idActa = $_POST['idActa']; 
    $nombreArchivo =$_FILES['archivo']['name']; 
    $rutaArchivo = $_FILES['archivo']['tmp_name']; 
    $nombreCarpeta = "acta".$idActa; 
     '<br>';
    $fecha = date("Ymjhis");
    $nombre = $fecha.$nombreArchivo;
    
    
    
    /// volvemos el texto totalmente en minuscula
    $validandoDocumentoCaracteres=mb_strtolower($nombreArchivo);
    $activarAlerta=TRUE;
    $permitidosNombre = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ0123456789-_,.() ";
    for ($i=0; $i<strlen($validandoDocumentoCaracteres); $i++){
        if (strpos($permitidosNombre, substr($validandoDocumentoCaracteres,$i,1))===false){
            $validandoDocumentoCaracteres . " no es válido<br>";
            $activarAlerta=FALSE;
            //return false;
        }
    }
    
    
    if($activarAlerta == FALSE){
                                    ?>
                                        <script> 
                                             window.onload=function(){
                                                document.forms["formularioAlerta"].submit();
                                             }
                                        </script>
                                                 
                                        <form name="formularioAlerta" action="../../seguimientoActas" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="estadoComentarioActa" value="<?php echo $estado; ?>"> 

                                        <input type="hidden" name="validacionActualizar" value="1">
                                        <input type="hidden" name="idActa" value="<?php echo $idActa; ?>">
                                        <input name="nombreCompromiso" value="<?php echo $nombreCompromiso;?>" type="hidden">
                                            <input name="alerta" value="1" type="hidden">
                                        </form> 
                                    <?php
    }else{
        if($estado != NULL){//Aca sube un avance o ejecutado
        
            
          
            $nombreFinal=$nombre;
            if(!file_exists('../../archivos/compromisos/'.$nombreCarpeta.'/')){
            	mkdir('../../archivos/compromisos/'.$nombreCarpeta.'/',0777,true);
                	if(file_exists('../../archivos/compromisos/')){
                		if(move_uploaded_file($rutaArchivo, '../../archivos/compromisos/'.$nombreCarpeta.'/'.$nombreFinal)){
                	        //Guarda archivo
                	       if($nombreFinal != NULL){   '<br>Registro';
                		    $mysqli->query("INSERT INTO documentoArchivoTemporal (actas)VALUES('".utf8_decode($nombreFinal)."') ")or die(mysqli_error($mysqli)); 
                		    
                		    $preguntadoValidacion=$mysqli->query("SELECT * FROM documentoArchivoTemporal WHERE  actas='".utf8_decode($nombreFinal)."' ")or die(mysqli_error($mysqli));
                    		$extraerPreguntaValidacion=$preguntadoValidacion->fetch_array(MYSQLI_ASSOC);
                    		   '<br> - '.$documentoExtraido2=utf8_encode($extraerPreguntaValidacion['actas']);
                    		    
                    		        
                            
                                     '<br><br>';
                            
                                    //Lista de letras abecedario
                                    $carpeta="../../archivos/compromisos/".$nombreCarpeta."/";
                                    $ruta="/".$carpeta."/";
                                    $directorio=opendir($carpeta);
                                    //recoger los  datos
                                    $datos=array();
                                    $conteoArchivosB=0;
                                    while ($archivo = readdir($directorio)) { 
                                      if(($archivo != '.')&&($archivo != '..')){
                                         
                                        if($documentoExtraido2 == $datos[]=$archivo){
                                            $conteoArchivosB++;
                                             $datos[]=$archivo;  '<br>';
                                        }
                                         
                                         
                                      } 
                                    }
                                    closedir($directorio);
                                        
                                    if($conteoArchivosB > 0){
                                       $documentoHabilitado2='1'; 
                                    }else{
                                       $documentoHabilitado2='no coincide';
                                    }
                                     '<br>B: '.$documentoHabilitado2;
                                    if($documentoHabilitado2 == 1){ 
                	       
                                	}else{    '<br>Redir..'; $EvariableRedirecciónActivado='1';
                                	
                                
                                            unlink(('../../archivos/compromisos/'.$nombreCarpeta.'/'.$nombreFinal)); 
                                            utf8_decode($nombreFinal);
                                            $mysqli->query("DELETE FROM documentoArchivoTemporal WHERE actas='".utf8_decode($nombreFinal)."' ")or die(mysqli_error($mysqli));
                                	        ?>
                                            <script> 
                                                 window.onload=function(){
                                                    //alert("Mensaje de alerta archivo");
                                                    document.forms["formularioAlerta"].submit();
                                                 }
                                            </script>
                                                     
                                            <form name="formularioAlerta" action="../../seguimientoActas" method="POST" onsubmit="procesar(this.action);" >
                                            <input type="hidden" name="estadoComentarioActa" value="<?php echo $estado; ?>"> 
    
                                            <input type="hidden" name="validacionActualizar" value="1">
                                            <input type="hidden" name="idActa" value="<?php echo $idActa; ?>">
                                            <input name="nombreCompromiso" value="<?php echo $nombreCompromiso;?>" type="hidden">
                                                <input name="alerta" value="1" type="hidden">
                                            </form> 
                                            <?php
                                	   }
                		
                    		    
                		}
                	        
                		}else{ 
                			//echo "Archivo no se pudo guardar";
                		}
                	}
                }else{
                	if(move_uploaded_file($rutaArchivo, '../../archivos/compromisos/'.$nombreCarpeta.'/'.$nombreFinal)){
                	    
                	    if($nombreFinal != NULL){   '<br>Registro';
                		    $mysqli->query("INSERT INTO documentoArchivoTemporal (actas)VALUES('".utf8_decode($nombreFinal)."') ")or die(mysqli_error($mysqli)); 
                		    
                		    $preguntadoValidacion=$mysqli->query("SELECT * FROM documentoArchivoTemporal WHERE  actas='".utf8_decode($nombreFinal)."' ")or die(mysqli_error($mysqli));
                    		$extraerPreguntaValidacion=$preguntadoValidacion->fetch_array(MYSQLI_ASSOC);
                    		   '<br> - '.$documentoExtraido2=utf8_encode($extraerPreguntaValidacion['actas']);
                    		    
                    		        
                            
                                     '<br><br>';
                            
                                    //Lista de letras abecedario
                                    $carpeta="../../archivos/compromisos/".$nombreCarpeta."/";
                                    $ruta="/".$carpeta."/";
                                    $directorio=opendir($carpeta);
                                    //recoger los  datos
                                    $datos=array();
                                    $conteoArchivosB=0;
                                    while ($archivo = readdir($directorio)) { 
                                      if(($archivo != '.')&&($archivo != '..')){
                                         
                                        if($documentoExtraido2 == $datos[]=$archivo){
                                            $conteoArchivosB++;
                                             $datos[]=$archivo;   '<br>';
                                        }
                                         
                                         
                                      } 
                                    }
                                    closedir($directorio);
                                        
                                    if($conteoArchivosB > 0){
                                       $documentoHabilitado2='1'; 
                                    }else{
                                       $documentoHabilitado2='no coincide';
                                    }
                                     '<br>B: '.$documentoHabilitado2;
                                    if($documentoHabilitado2 == 1){ 
                	       
                                	}else{    '<br>Redir..'; $EvariableRedirecciónActivado='1';
                                	
                                
                                            unlink(('../../archivos/compromisos/'.$nombreCarpeta.'/'.$nombreFinal)); 
                                            utf8_decode($nombreFinal);
                                            $mysqli->query("DELETE FROM documentoArchivoTemporal WHERE actas='".utf8_decode($nombreFinal)."' ")or die(mysqli_error($mysqli));
                                	        ?>
                                            <script> 
                                                 window.onload=function(){
                                                    //alert("Mensaje de alerta archivo");
                                                    document.forms["formularioAlerta"].submit();
                                                 }
                                            </script>
                                                     
                                            <form name="formularioAlerta" action="../../seguimientoActas" method="POST" onsubmit="procesar(this.action);" >
                                            <input type="hidden" name="estadoComentarioActa" value="<?php echo $estado; ?>"> 
    
                                            <input type="hidden" name="validacionActualizar" value="1">
                                            <input type="hidden" name="idActa" value="<?php echo $idActa; ?>">
                                            <input name="nombreCompromiso" value="<?php echo $nombreCompromiso;?>" type="hidden">
                                                <input name="alerta" value="1" type="hidden">
                                            </form> 
                                            <?php
                                	   }
                		
                    		    
                		}
                	    
                	    
                	   
                	    
                	   
                	}else{
                		//echo "Archivo no se pudo guardar";
                	}
                }
            
            if($EvariableRedirecciónActivado == 1){ }else{
                $queryCompromiso = $mysqli->query("SELECT id FROM compromisosIndividuales WHERE id_compromiso = '$idCompromiso' AND responsableId = '$responsableID'");
                $numQuery = mysqli_num_rows($queryCompromiso);
                $nombreB=utf8_decode($nombre);
                if($numQuery < 1){
                    $mysqli->query("INSERT INTO compromisosIndividuales (id_compromiso, id_responsable, estado, responsable, responsableId, rutaAvance) VALUES ('$idCompromiso','$responsableID','$estado','$reponsable','$responsableID','$nombreB')")or die(mysqli_error($mysqli));
                }else{
                    $mysqli->query("UPDATE compromisosIndividuales SET estado = '$estado', rutaAvance = '$nombreB' WHERE id_compromiso = '$idCompromiso' AND responsableId = '$responsableID'");
                }
            }
            
        }
        
        if($EvariableRedirecciónActivado == 1){
            
        }else{
        
        if($estadoArpobado != NULL){//aca cuando el aprobador actualiza el estado.
            $mysqli->query("UPDATE compromisosIndividuales SET estado = '$estadoArpobado' WHERE id_compromiso = '$idCompromiso' AND responsableId = '$responsableID'");
        }
        
        
        //Actualizar estado general del compromiso
        
        $compromisosIndividuales = $mysqli->query("SELECT * FROM `compromisosIndividuales` WHERE id_compromiso = '$idCompromiso'");
        $numCompromisos = mysqli_num_rows($compromisosIndividuales);
        $numAprobados = 0;
        $numAprobadosB=0;
        $numAprobadosC=0;
        
        while($col = $compromisosIndividuales->fetch_assoc()){
            $numAprobadosB++;
            if($col['estado'] == 'Ejecutado'){
                $numAprobadosC++;
            }
            
            
            if($col['estado'] == "Aprobado"){
                 $numAprobados++;
            }
            
            if($numAprobados == $numCompromisos){
                $estadoGeneral = "Aprobado";
            }else{
                $estadoGeneral = "Pendiente";
               
            }
            
        }
        
        
       
        if($numAprobadosC == $numAprobadosB){ 
            /// cuando es ejecutado envia correo a la persona responsable de aprobar el compromiso
                        
                          
                            require '../usuarios/libreria/PHPMailerAutoload.php';
                            $recorriendoResponsables=$mysqli->query("SELECT * FROM compromisos WHERE id= '$idCompromiso' ");
                            while($extraerRecorriendoResponsables=$recorriendoResponsables->fetch_array()){
                                 $nombreDocEnviar=utf8_encode($extraerRecorriendoResponsables['compromiso']);
                                  'Tipo: '.$rad_Res=$extraerRecorriendoResponsables['entregarA'];  '<br>';
                                 'ID responsable: '.$arrayEncargado=$extraerRecorriendoResponsables['entregarAID'];  '<br>';
                                
                               
                               
                                if($rad_Res == 'usuario'){ 
                                         $arrayEncargado =  json_decode($extraerRecorriendoResponsables['entregarAID']);
                                         $longitud = count($arrayEncargado);
                                        
                                        for($i=0; $i<$longitud; $i++){
                                            $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id ='$arrayEncargado[$i]' ");
                                                while($columna = $nombreuser->fetch_array()){
                                                 $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                                                 $correoResponsable=$columna['correo']; 
                                
                                                 //Create a new PHPMailer instance
                                                 $mail = new PHPMailer();
                                                 $mail->IsSMTP();
                                                 
                                                 //Configuracion servidor mail
                                                 require '../../correoEnviar/contenido.php';
                                                 
                                                //Agregar destinatario
                                                    $mail->isHTML(true);
                                                    $mail->AddAddress($correoResponsable);
                                                    $mail->Subject = utf8_decode('Encargado para aprobar el compromiso'); //Gestión de compromiso '.$nombreDocEnviar
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
                                                    <p>El compromiso <b>'.$nombreDocEnviar.'.</b> fue gestionado y está disponible para su revisión y aprobación.</p>
                                                    Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                                    <br>
                                                    <em>Mi perfil --> mis pendientes --> Actas --> Aprobación de compromisos +</em>.
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
                                            }                    
                                                            
                                
                                }
                        
                                if($rad_Res == 'cargo'){ 
                                        $arrayEncargado =  json_decode($extraerRecorriendoResponsables['entregarAID']);
                                        $longitud = count($arrayEncargado);
                                        
                                        for($i=0; $i<$longitud; $i++){
                                            $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo='$arrayEncargado[$i]' ");
                                            while($columna = $nombreuser->fetch_array()){
                                              'Nombre: '.$nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                                              '--Correo: '.$correoResponsable=$columna['correo']; 
                                                '<br>';
                                                
                                                //Create a new PHPMailer instance
                                                $mail = new PHPMailer();
                                                $mail->IsSMTP();
                                                
                                                //Configuracion servidor mail
                                                require '../../correoEnviar/contenido.php';
                                                
                                                //Agregar destinatario
                                                $mail->isHTML(true);
                                                $mail->AddAddress($correoResponsable);
                                                $mail->Subject = utf8_decode('Encargado para aprobar el compromiso'); //Gestión de compromiso '.$nombreDocEnviar
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
                                                <p>El compromiso <b>'.$nombreDocEnviar.'.</b> fue gestionado y está disponible para su revisión y aprobación.</p>
                                                Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                                <br>
                                                <em>Mi perfil --> mis pendientes --> Actas --> Aprobación de compromisos +</em>.
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
                                                //echo 'Enviado';
                                                } else {
                            
                                                }
                                                
                                                
                                            }
                                        }
                                    
                                }
                                
                            }
                            
                            
                            
                            //// notificamos al responsable del compromiso, para decirle que fue aprobado
                            if($estado == 'Ejecutado'){ //// capturamos el id del acta para recuperar los datos del responsable y al dar ejecutado, podamos notificar que el compromiso fue aprobado
            
                                $consultandoComprimisos=$mysqli->query("SELECT * FROM `compromisos` WHERE id= '$idCompromiso' ");
                                $sacarCompromisos=$consultandoComprimisos->fetch_array(MYSQLI_ASSOC);
                                $idCompromisoConsultar=$sacarCompromisos['id'];
                                '-'.$nombreDocEnviar=utf8_encode($sacarCompromisos['compromiso']);
                                
                               // require '../usuarios/libreria/PHPMailerAutoload.php';
                                $recorriendoResponsables=$mysqli->query("SELECT * FROM compromisosIndividuales WHERE id_compromiso='$idCompromisoConsultar' AND estado='Ejecutado' ");
                                while($extraerRecorriendoResponsables=$recorriendoResponsables->fetch_array()){
                                       'Tipo: '.$rad_Res=$extraerRecorriendoResponsables['responsable'];  '<br>';
                                          'ID responsable: '.$arrayEncargado=$extraerRecorriendoResponsables['id_responsable'];  '<br>';
                                        
                        
                                        /// antes estaba el código para enviar correos
                                }
                            }
                            
                        /// EDN
        }
      
        $mysqli->query("UPDATE compromisos SET estado = '$estadoGeneral' WHERE id = '$idCompromiso'"); 
        
        
        // oculto $mysqli->query("INSERT INTO compromisosIndividuales (id_compromiso, id_responsable, estado, responsable, responsableId, rutaAvance) VALUES ('$idCompromiso','$responsableID','$estado','$reponsable','$responsableID','$nombre')")or die(mysqli_error($mysqli));
        
        ?>
                <script> 
                     window.onload=function(){
                   
                        document.forms["miformulario"].submit();
                     }
                </script>
                 
                <form name="miformulario" action="../../seguimientoActas" method="POST" onsubmit="procesar(this.action);" >
                    
    
                    <input type="hidden" name="estadoComentarioActa" value="<?php echo $estado; ?>"> 
    
                    <input type="hidden" name="validacionActualizar" value="1">
                    <input type="hidden" name="idActa" value="<?php echo $idActa; ?>">
                    <input name="nombreCompromiso" value="<?php echo $nombreCompromiso;?>" type="hidden">
                </form> 
        <?php  
        } 
    
    }
    
    
    
}


if(isset($_POST['agregarCompromiso'])){
    
    $idActa = $_POST['idActa'];
    $compromisos = utf8_decode($_POST['compromisos']);
    $rad_Res = $_POST['rad_Res'];//responsables radio button
    $selectRes = json_encode($_POST['select_encargadoRes']);
    $fechainicio = $_POST['fechainicio']; 
    $hora = $_POST['hora']; 
    $minuto = $_POST['minuto']; 
    $fechaEntrega = $fechainicio." ".$hora;
    //$fechaEntrega = $fechainicio." ".$hora.":".$minuto.":00";
    $rad_Entrega = $_POST['rad_Entrega'];//entregar a  radio button
    $selectEntrega = json_encode($_POST['select_encargadoEntrega']);
    
        $consultaActaFechas=$mysqli->query("SELECT * FROM actas WHERE id='$idActa' ");
        $extraerActaFechas=$consultaActaFechas->fetch_array(MYSQLI_ASSOC);
        'Fecha inicio acta: '.$fechaInicioActa=$extraerActaFechas['fechaInicio'];
        '<br>Fecha del cmpromiso'.$fechaEntrega;
    if($fechaEntrega < $fechaInicioActa){ //echo 'alerta';
         ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                    // alert("La fecha del compromiso no puede ser menor a la fecha inical del acta");
                 }
            </script>
             
            <form name="miformulario" action="../../compromiso" method="POST" onsubmit="procesar(this.action);" >
                <input name="compromisoGuardar" value="<?php echo $_POST['compromisos']; ?>" type="hidden">
                <input type="hidden" name="validacionExiste" value="1">
                <input type="hidden" name="idActa" value="<?php echo $idActa;?>">
            </form> 
        <?php 
    }else{
    
        if($rad_Res == 'usuario' && $rad_Entrega == 'usuario'){
            
            $selectResB = json_decode($selectRes);
            $longitud = count($selectResB);
            
            $selectEntregaB = json_decode($selectEntrega);
            $longitudB = count($selectEntregaB);
        
            //Inserto compromiso individual 
            
            for($i=0; $i<$longitud; $i++){
              
                
                for($j=0; $j<$longitudB; $j++){
                   
                    
                    'a:'.$selectResB[$i]; //echo ',';
                    '<br>';
                    'b:'.$selectEntregaB[$j]; //echo ',';
                    
                    if($selectResB[$i] == $selectEntregaB[$j]){
                        $enviarAlerta='Alerta';
                        
                    }
                    
                } // cerrando segundo For
                
            
            } // cerrando primer For
           
        }
        if($rad_Res == 'cargo' && $rad_Entrega == 'cargo'){
            
            $selectResB = json_decode($selectRes);
            $longitud = count($selectResB);
            
            $selectEntregaB = json_decode($selectEntrega);
            $longitudB = count($selectEntregaB);
        
            //Inserto compromiso individual 
            
            for($i=0; $i<$longitud; $i++){
              
                
                for($j=0; $j<$longitudB; $j++){
                   
                    
                    'a:'.$selectResB[$i]; //echo ',';
                    '<br>';
                    'b:'.$selectEntregaB[$j]; //echo ',';
                    
                    if($selectResB[$i] == $selectEntregaB[$j]){
                        $enviarAlerta='Alerta';
                        
                    }
                    
                } // cerrando segundo For
                
            
            } // cerrando primer For
           
        }
        if($enviarAlerta == 'Alerta'){
        ?>
                <script> 
                     window.onload=function(){
                   
                         document.forms["miformulario"].submit();
                         //alert("La persona que se le entrega la aprobación del compromiso no puede ser el mismo responsable del compromiso");
                     }
                </script>
                 
                <form name="miformulario" action="../../compromiso" method="POST" onsubmit="procesar(this.action);" >
                    <input name="compromisoGuardar" value="<?php echo $_POST['compromisos']; ?>" type="hidden">
                    <input name="fechaGuardar" value="<?php echo $fechainicio; ?>" type="hidden">
                    <input name="horaGuardar" value="<?php echo $hora; ?>" type="hidden">
                    <input type="hidden" name="validacionExisteB" value="1">
                    <input type="hidden" name="idActa" value="<?php echo $idActa;?>">
                </form> 
        <?php
        }else{
                
                $mysqli->query("INSERT INTO `compromisos`(
                `idActa`,
                `compromiso`,
                `responsableCompromiso`,
                `responsableID`,
                `fechaEntrega`,
                `entregarA`,
                `entregarAID`
                )
                VALUES(
                '$idActa',
                '$compromisos',
                '$rad_Res',
                '$selectRes',
                '$fechaEntrega',
                '$rad_Entrega',
                '$selectEntrega')")or die(mysqli_error($mysqli));
                
                ?>
                        <script> 
                             window.onload=function(){
                           
                                 document.forms["miformulario"].submit();
                                 //alert("Compromiso agregado");
                             }
                        </script>
                         
                        <form name="miformulario" action="../../compromiso" method="POST" onsubmit="procesar(this.action);" >
                            <input type="hidden" name="validacionAgregar" value="1">
                            <input type="hidden" name="idActa" value="<?php echo $idActa; ?>">
                        </form> 
                <?php 
        }
    }
}

//Actualizar un compromiso
if(isset($_POST['actualizarCompromiso'])){
    
    $idActa = $_POST['idActa'];
    $idCompromiso= $_POST['idCompromiso'];
    $compromisos = utf8_decode($_POST['compromisos']);
    $rad_Res = $_POST['rad_Res'];//responsables radio button
    $selectRes = json_encode($_POST['select_encargadoRes']);
    $fechainicio = $_POST['fechainicio']; 
    $hora = $_POST['hora']; 
    $minuto = $_POST['minuto']; 
    $fechaEntrega = $fechainicio." ".$hora;
    //$fechaEntrega = $fechainicio." ".$hora.":".$minuto.":00";
    $rad_Entrega = $_POST['rad_Entrega'];//entregar a  radio button
    $selectEntrega = json_encode($_POST['select_encargadoEntrega']);
    
    $consultaActaFechas=$mysqli->query("SELECT * FROM actas WHERE id='$idActa' ");
        $extraerActaFechas=$consultaActaFechas->fetch_array(MYSQLI_ASSOC);
        'Fecha inicio acta: '.$fechaInicioActa=$extraerActaFechas['fechaInicio'];
        '<br>Fecha del cmpromiso'.$fechaEntrega;
    if($fechaEntrega < $fechaInicioActa){ //echo 'alerta';
         ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                     //alert("La fecha del compromiso no puede ser menor a la fecha inical del acta");
                 }
            </script>
             
            <form name="miformulario" action="../../editarCompromiso" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExiste" value="1">
                <input type="hidden" name="idCompromiso" value="<?php echo $idCompromiso; ?>">
                <input type="hidden" name="idActa" value="<?php echo $idActa; ?>">
            </form>  
        <?php 
    }else{
        if($rad_Res == 'usuario' && $rad_Entrega == 'usuario'){
            
            $selectResB = json_decode($selectRes);
            $longitud = count($selectResB);
            
            $selectEntregaB = json_decode($selectEntrega);
            $longitudB = count($selectEntregaB);
        
            //Inserto compromiso individual 
            
            for($i=0; $i<$longitud; $i++){
              
                
                for($j=0; $j<$longitudB; $j++){
                   
                    
                    'a:'.$selectResB[$i]; //echo ',';
                    '<br>';
                    'b:'.$selectEntregaB[$j]; //echo ',';
                    
                    if($selectResB[$i] == $selectEntregaB[$j]){
                        $enviarAlerta='Alerta';
                        
                    }
                    
                } // cerrando segundo For
                
            
            } // cerrando primer For
           
        }
        if($rad_Res == 'cargo' && $rad_Entrega == 'cargo'){
            
            $selectResB = json_decode($selectRes);
            $longitud = count($selectResB);
            
            $selectEntregaB = json_decode($selectEntrega);
            $longitudB = count($selectEntregaB);
        
            //Inserto compromiso individual 
            
            for($i=0; $i<$longitud; $i++){
              
                
                for($j=0; $j<$longitudB; $j++){
                   
                    
                    'a:'.$selectResB[$i]; //echo ',';
                    '<br>';
                    'b:'.$selectEntregaB[$j]; //echo ',';
                    
                    if($selectResB[$i] == $selectEntregaB[$j]){
                        $enviarAlerta='Alerta';
                        
                    }
                    
                } // cerrando segundo For
                
            
            } // cerrando primer For
           
        }
        if($enviarAlerta == 'Alerta'){
        ?>
                <script> 
                     window.onload=function(){
                   
                         document.forms["miformulario"].submit();
                         //alert("La persona que se le entrega la aprobación del compromiso no puede ser el mismo responsable del compromiso");
                     }
                </script>
                 
            <form name="miformulario" action="../../editarCompromiso" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExisteB" value="1">
                <input type="hidden" name="idCompromiso" value="<?php echo $idCompromiso; ?>">
                <input type="hidden" name="idActa" value="<?php echo $idActa; ?>">
            </form> 
        <?php
        }else{
                    $mysqli->query("
                    UPDATE compromisos SET 
                    compromiso = '$compromisos',
                    responsableCompromiso = '$rad_Res',
                    responsableID ='$selectRes',
                    fechaEntrega ='$fechaEntrega',
                    entregarA = '$rad_Entrega',
                    entregarAID = '$selectEntrega'
                    WHERE id = $idCompromiso
                ");
                
                    $selectResB = json_decode($selectRes);
                    $longitud = count($selectResB);
                
                    //Inserto compromiso individual 
                    for($i=0; $i<$longitud; $i++){
                        
                        '<br><br>'.$idDelResponsable = $selectResB[$i]; echo '<br>';
                        
                        $consultarIdCI=$mysqli->query("SELECT * FROM compromisosIndividuales WHERE id_compromiso='$idCompromiso' AND id_responsable='$idDelResponsable'  ");
                        $traeIdCI=$consultarIdCI->fetch_array(MYSQLI_ASSOC);
                         'a:'.$existenciaA=$traeIdCI['id_compromiso'];
                         'b:'.$existenciaB=$traeIdCI['id_responsable']; echo '<br>';
                        
                        if($idCompromiso == $existenciaA &&  $idDelResponsable == $existenciaB){
                             'NO ingresa: '.$idDelResponsable;
                        }else{
                             'Ingresa'.$idDelResponsable; echo '<br>';
                            $mysqli->query("INSERT INTO compromisosIndividuales (id_compromiso, id_responsable, estado, responsable, responsableId) VALUES ('$idCompromiso','$idDelResponsable','Pendiente','$rad_Res','$idDelResponsable')")or die(mysqli_error($mysqli));
                        }
                        
                        
                    }
                    
                
                
                ?>
                        <script> 
                             window.onload=function(){
                           
                                 document.forms["miformulario"].submit();
                                 //alert("Compromiso actualizado");
                                 
                             }
                        </script>
                         
                        <form name="miformulario" action="../../editarActa" method="POST" onsubmit="procesar(this.action);" >
                            <input type="hidden" name="validacionActualizar" value="1">
                            <input type="hidden" name="idCompromiso" value="<?php echo $idCompromiso; ?>">
                            <input type="hidden" name="idActa" value="<?php echo $idActa; ?>">
                        </form> 
                <?php    
        }
    }
    
     
}


if(isset($_POST['eliminarCompromiso'])){
    
    $idCompromiso= $_POST['idCompromiso'];
    $idActa = $_POST['idActa'];
    $mysqli->query("DELETE FROM compromisos WHERE id = $idCompromiso");
    
    ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                     //alert("Compromiso eliminado");
                     
                 }
            </script>
             
            <form name="miformulario" action="../../editarActa" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminar" value="1">
                <input type="hidden" name="idActa" value="<?php echo $idActa; ?>">
                <input type="hidden" name="idCompromiso" value="<?php echo $idCompromiso; ?>">
            </form> 
    <?php  
    
}


if(isset($_POST['finalizarActa'])){
    $idActa = $_POST['idActa'];
    $compromisos = utf8_decode($_POST['compromisos']);
    $rad_Res = $_POST['rad_Res'];//responsables radio button
    $selectRes = json_encode($_POST['select_encargadoRes']);
    $fechainicio = $_POST['fechainicio']; 
    $hora = $_POST['hora']; 
    $minuto = $_POST['minuto'];
    $fechaEntrega = $fechainicio." ".$hora;
    //$fechaEntrega = $fechainicio." ".$hora.":".$minuto.":00";
    $rad_Entrega = $_POST['rad_Entrega'];//entregar a  radio button
    $selectEntrega = json_encode($_POST['select_encargadoEntrega']);
    
        $consultaActaFechas=$mysqli->query("SELECT * FROM actas WHERE id='$idActa' ");
        $extraerActaFechas=$consultaActaFechas->fetch_array(MYSQLI_ASSOC);
        'Fecha inicio acta: '.$fechaInicioActa=$extraerActaFechas['fechaInicio'];
        '<br>Fecha del cmpromiso'.$fechaEntrega;
    if($fechaEntrega < $fechaInicioActa){ //echo 'alerta';
         ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                     //alert("La fecha del compromiso no puede ser menor a la fecha inical del acta");
                 }
            </script>
             
            <form name="miformulario" action="../../compromiso" method="POST" onsubmit="procesar(this.action);" >
                <input name="compromisoGuardar" value="<?php echo $_POST['compromisos']; ?>" type="hidden">
                <input type="hidden" name="validacionExiste" value="1">
                <input type="hidden" name="idActa" value="<?php echo $idActa;?>">
            </form> 
        <?php 
    }else{ //echo 'ingresa';
    
        if($rad_Res == 'usuario' && $rad_Entrega == 'usuario'){
            
            $selectResB = json_decode($selectRes);
            $longitud = count($selectResB);
            
            $selectEntregaB = json_decode($selectEntrega);
            $longitudB = count($selectEntregaB);
        
            //Inserto compromiso individual 
            
            for($i=0; $i<$longitud; $i++){
              
                
                for($j=0; $j<$longitudB; $j++){
                   
                    
                    'a:'.$selectResB[$i]; //echo ',';
                    '<br>';
                    'b:'.$selectEntregaB[$j]; //echo ',';
                    
                    if($selectResB[$i] == $selectEntregaB[$j]){
                        $enviarAlerta='Alerta';
                        
                    }
                    
                } // cerrando segundo For
                
            
            } // cerrando primer For
           
        }
        if($rad_Res == 'cargo' && $rad_Entrega == 'cargo'){
            
            $selectResB = json_decode($selectRes);
            $longitud = count($selectResB);
            
            $selectEntregaB = json_decode($selectEntrega);
            $longitudB = count($selectEntregaB);
        
            //Inserto compromiso individual 
            
            for($i=0; $i<$longitud; $i++){
              
                
                for($j=0; $j<$longitudB; $j++){
                   
                    
                    'a:'.$selectResB[$i]; //echo ',';
                    '<br>';
                    'b:'.$selectEntregaB[$j]; //echo ',';
                    
                    if($selectResB[$i] == $selectEntregaB[$j]){
                        $enviarAlerta='Alerta';
                        
                    }
                    
                } // cerrando segundo For
                
            
            } // cerrando primer For
           
        }
        if($enviarAlerta == 'Alerta'){
        ?>
                <script> 
                     window.onload=function(){
                   
                         document.forms["miformulario"].submit();
                         //alert("La persona que se le entrega la aprobación del compromiso no puede ser el mismo responsable del compromiso ");
                     }
                </script>
                 
                <form name="miformulario" action="../../compromiso" method="POST" onsubmit="procesar(this.action);" >
                    <input name="compromisoGuardar" value="<?php echo $_POST['compromisos']; ?>" type="hidden">
                    <input name="fechaGuardar" value="<?php echo $fechainicio; ?>" type="hidden">
                    <input name="horaGuardar" value="<?php echo $hora; ?>" type="hidden">
                    <input type="hidden" name="validacionExisteB" value="1">
                    <input type="hidden" name="idActa" value="<?php echo $idActa;?>">
                </form> 
        <?php
        }else{
            
            
            
                $mysqli->query("INSERT INTO `compromisos`(
                `idActa`,
                `compromiso`,
                `responsableCompromiso`,
                `responsableID`,
                `fechaEntrega`,
                `entregarA`,
                `entregarAID`
                )
                VALUES(
                '$idActa',
                '$compromisos',
                '$rad_Res',
                '$selectRes',
                '$fechaEntrega',
                '$rad_Entrega',
                '$selectEntrega')")or die(mysqli_error($mysqli));
                
                                   
                //Inserto en la tabla compromisos individuales
                    
                $compromisosQuery = $mysqli->query("SELECT * FROM compromisos WHERE idActa = '$idActa'")or die(mysqli_error($mysqli));
                while($row = $compromisosQuery->fetch_assoc()){
                    
                    $idCompromiso = $row['id'];
                    $reponsable = $row['responsableCompromiso'];
                    $idResponsable = json_decode($row['responsableID']);
                    $estado = 'Pendiente';
                    $rutaArchivo = NULL;
                    $longitud = count($idResponsable);
                
                    
                    
                    
                    //Inserto compromiso individual 
                    for($i=0; $i<$longitud; $i++){
                        
                       $idDelResponsable = $idResponsable[$i];
                        
                       // $mysqli->query("INSERT INTO compromisosIndividuales (id_compromiso, id_responsable, estado, responsable, responsableId) VALUES ('$idCompromiso','$idDelResponsable','$estado','$reponsable','$idDelResponsable')")or die(mysqli_error($mysqli));
                       
                        $consultarIdCI=$mysqli->query("SELECT * FROM compromisosIndividuales WHERE id_compromiso='$idCompromiso' AND id_responsable='$idDelResponsable'  ");
                        $traeIdCI=$consultarIdCI->fetch_array(MYSQLI_ASSOC);
                         'a:'.$existenciaA=$traeIdCI['id_compromiso'];
                         'b:'.$existenciaB=$traeIdCI['id_responsable']; echo '<br>';
                        
                        if($idCompromiso == $existenciaA &&  $idDelResponsable == $existenciaB){
                             'NO ingresa: '.$idDelResponsable;
                        }else{
                             'Ingresa'.$idDelResponsable; echo '<br>';
                            $mysqli->query("INSERT INTO compromisosIndividuales (id_compromiso, id_responsable, estado, responsable, responsableId) VALUES ('$idCompromiso','$idDelResponsable','$estado','$reponsable','$idDelResponsable')")or die(mysqli_error($mysqli));
                        }
                    }
                    
                }
            
               
            require '../usuarios/libreria/PHPMailerAutoload.php'; 
            $acentos = $mysqli->query("SET NAMES 'utf8'");
            $consultandoActasEnvioCorreo=$mysqli->query("SELECT * FROM actas WHERe id='$idActa' ");
            $extraerActas=$consultandoActasEnvioCorreo->fetch_array(MYSQLI_ASSOC);
            $nombreDocEnviar=$extraerActas['nombreActa'];
            $radioActaTipo=$extraerActas['quienAprueba'];
            $arrayEncargado=$extraerActas['quienApruebaId'];
            $arrayEncargado=json_decode($arrayEncargado);
             if($radioActaTipo == 'usuario'){ 
                                       $longitud = count($arrayEncargado); 
                                       for($i=0; $i<$longitud; $i++){
                                           $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$arrayEncargado[$i]' ");
                                           while($columna = $nombreuser->fetch_array()){
                                           $nombreResponsable=($columna['nombres'].' '.$columna['apellidos']); 
                                            $correoResponsable=$columna['correo']; 
                                            '<br>';
                                           
                                           

                                                               

                                                               //Create a new PHPMailer instance
                                                               $mail = new PHPMailer();
                                                               $mail->IsSMTP();
                                                               
                                                               //Configuracion servidor mail
                                                               require '../../correoEnviar/contenido.php';
                                                               
                                                               //Agregar destinatario
                                                               $mail->isHTML(true);
                                                               $mail->AddAddress($correoResponsable);
                                                               $mail->Subject = utf8_decode('Aprobación de acta '); //$nombreDocEnviar
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
                                                               <p>El acta <b>'.$nombreDocEnviar.'.</b> se encuentra pendiente para su aprobación.</p>
                                                               Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                                               <br>
                                                               <em>Mi perfil --> mis pendientes --> Actas --> Aprobación actas +</em>.
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
                                                               
                                                               } else {

                                                               }
                                                              
                                           }  
                                       }
                                   }

                                   if($radioActaTipo == 'cargo'){
                                      
                                       $longitud = count($arrayEncargado);
                                       for($i=0; $i<$longitud; $i++){  
                                           $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo='$arrayEncargado[$i]' ");
                                           while($columna = $nombreuser->fetch_array()){
                                                'Nombre: '.$nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                                                '---'.$correoResponsable=$columna['correo']; 
                                                '<br>';
                                               
                                               //Create a new PHPMailer instance
                                               $mail = new PHPMailer();
                                               $mail->IsSMTP();
                                               
                                               //Configuracion servidor mail
                                               require '../../correoEnviar/contenido.php';
                                               
                                               //Agregar destinatario
                                               $mail->isHTML(true);
                                               $mail->AddAddress($correoResponsable);
                                               $mail->Subject = utf8_decode('Aprobación de acta '); //$nombreDocEnviar
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
                                               <p>El acta <b>'.$nombreDocEnviar.'.</b> se encuentra pendiente para su aprobación.</p>
                                               Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                               <br>
                                               <em>Mi perfil --> mis pendientes --> Actas --> Aprobación actas +</em>.
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
                                               
                                               } else {

                                               }
                                              
                                               
                                           }
                                       }
                                   }
                ?>
                        <script> 
                             window.onload=function(){
                           
                                 document.forms["miformulario"].submit();
                                 //alert("Acta finalizada.");
                             }
                        </script>
                         
                        <form name="miformulario" action="../../finacta" method="POST" onsubmit="procesar(this.action);" >
                            <input type="hidden" name="idActa" value="<?php echo $idActa;?>">
                        </form> 
                <?php  
            
        }
    }
   
}


if(isset($_POST['finactahora'])){
    $idActa = $_POST['idActa'];
    $fechafin = $_POST['fechafin'];
    $horafin = $_POST['horafin']; 
    $minutofin = $_POST['minutofin']; 
    $fechaFinActa = $fechafin." ".$horafin;
    //$fechaFinActa = $fechafin." ".$horafin.":".$minutofin.":00";
    
    $consultaCompromiso=$mysqli->query("SELECT * FROM actas WHERE id='$idActa' ");
    $extraeCompromiso=$consultaCompromiso->fetch_array(MYSQLI_ASSOC);
    $fechadeInicio=$extraeCompromiso['fechaInicio'];
    $actaConAprobacion=$extraeCompromiso['quienApruebaId'];
    
    if($fechaFinActa < $fechadeInicio){
        ?>
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformulario"].submit();
                             //alert("La fecha de cierre no puede ser menor a la fecha inical del acta");
                         }
                    </script>
                     
                    <form name="miformulario" action="../../finacta" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="validacionExiste" value="1">
                        <input type="hidden" name="idActa" value="<?php echo $idActa;?>">
                    </form> 
        <?php
    }else{ //echo 'Entra a finalizar el acta.<br><br>';
    
    require '../usuarios/libreria/PHPMailerAutoload.php'; 
        /// hacemos recorrido de los compromisos a quienes se les debe notificar
        $idActaPreguntar=$extraeCompromiso['id'];
        $consultandoCompromisos=$mysqli->query("SELECT * FROM compromisos WHERE idActa='$idActaPreguntar' ");
        while($extraerConsultaCompromisos=$consultandoCompromisos->fetch_array()){
        $nombreDocEnviar=utf8_encode($extraerConsultaCompromisos['compromiso']);
            $TipoEnviarCompromiso=$extraerConsultaCompromisos['responsableCompromiso']; echo '<br>';
            $arrayEncargado=$extraerConsultaCompromisos['responsableID']; echo '<br>';
            $arrayEncargado=json_decode($arrayEncargado);
            
            /// si el acta viene sin aprobación, debe notificar a los del compromiso
            if($actaConAprobacion == 'null'){
            
                if($TipoEnviarCompromiso == 'usuario'){
                        $longitud = count($arrayEncargado); 
                        for($i=0; $i<$longitud; $i++){
                            $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$arrayEncargado[$i]' ");
                            while($columna = $nombreuser->fetch_array()){
                            $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                            $correoResponsable=$columna['correo']; 
                            '<br>';
                                                                   //Create a new PHPMailer instance
                                                                   $mail = new PHPMailer();
                                                                   $mail->IsSMTP();
                                                                   
                                                                   //Configuracion servidor mail
                                                                   require '../../correoEnviar/contenido.php';
                                                                   
                                                                   //Agregar destinatario
                                                                   $mail->isHTML(true);
                                                                   $mail->AddAddress($correoResponsable);
                                                                   $mail->Subject = utf8_decode('Gestión de compromiso '.$nombreDocEnviar);
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
                                                                   <p>El compromiso <b>'.$nombreDocEnviar.'.</b> está pendiente por gestionar.</p>
                                                                   Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                                                   <br>
                                                                   <em>Mi perfil --> mis pendientes --> Actas --> gestión de compromisos +</em>.
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
                                                                   
                                                                   } else {
    
                                                                   }                   
                            }
                        }
                }
                
                if($TipoEnviarCompromiso == 'cargo'){
                                            $longitud = count($arrayEncargado);
                                            for($i=0; $i<$longitud; $i++){  
                                               $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo='$arrayEncargado[$i]' ");
                                               while($columna = $nombreuser->fetch_array()){
                                                    'Nombre: '.$nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                                                    '---'.$correoResponsable=$columna['correo']; 
                                                    '<br>';
                                                   
                                                   //Create a new PHPMailer instance
                                                                   $mail = new PHPMailer();
                                                                   $mail->IsSMTP();
                                                                   
                                                                   //Configuracion servidor mail
                                                                   require '../../correoEnviar/contenido.php';
                                                                   
                                                                   //Agregar destinatario
                                                                   $mail->isHTML(true);
                                                                   $mail->AddAddress($correoResponsable);
                                                                   $mail->Subject = utf8_decode('Gestión de compromiso '.$nombreDocEnviar);
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
                                                                   <p>El compromiso <b>'.$nombreDocEnviar.'.</b> está pendiente por gestionar.</p>
                                                                   Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                                                   <br>
                                                                   <em>Mi perfil --> mis pendientes --> Actas --> gestión de compromisos +</em>.
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
                                                                   
                                                                   } else {
    
                                                                   } 
                                                  
                                                   
                                               }
                                           }
                }
            
            }
        }
    
        $mysqli->query("UPDATE actas SET fechaCierre = '$fechaFinActa', finalizada = 1 WHERE actas.id = $idActa");
        
        
       ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../actas" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionAgregar" value="1">
            </form> 
        <?php
    }
 
}


if(isset($_POST['cargarActa'])){
    
        $idEncabezado=$_POST['idEncabezado'];
    
        $nombreArchivo =$_FILES['archivo']['name']; 
        $rutaArchivo = $_FILES['archivo']['tmp_name'];
        
        /// volvemos el texto totalmente en minuscula
    $validandoDocumentoCaracteres=mb_strtolower($nombreArchivo);
    
    $activarAlerta=TRUE;
    $permitidosNombre = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ0123456789-_,.() ";
    for ($i=0; $i<strlen($validandoDocumentoCaracteres); $i++){
        if (strpos($permitidosNombre, substr($validandoDocumentoCaracteres,$i,1))===false){
            $validandoDocumentoCaracteres . " no es válido<br>";
            $activarAlerta=FALSE;
            //return false;
        }
    }
    
    if($activarAlerta == FALSE){
                                    $radiobtn = $_POST['radiobtn'];//quien cita
                                    $select = json_encode($_POST['select_encargadoE']);
                                    $radiobtn2 = $_POST['radiobtn2'];//quien elabora
                                    $selectElabora = json_encode($_POST['select_encargadoR']);
                                    
                                    $radioActaSiNO = $_POST['radiobtnActa']; /// acta que requiere aprobación
                                    $radioActaTipo = $_POST['rad_AActa'];//quien aprobación
                                    $selectActaAprobacion = json_encode($_POST['select_encargadoAR2']); /// id de los aprobadores
                                    
                                    $mysqli->query("INSERT INTO documentoDatosTemporalesActas (quienCita,quienCitaId,quienElabora,quienElaboraId,usuario,aprobacion,quienAprobacion,quienAprobacionId)
                                    VALUES('$radiobtn','$select','$radiobtn2','$selectElabora','$celdulaUser','$radioActaSiNO','$radioActaTipo','$selectActaAprobacion')");
    
                                        ?>
                                        <script> 
                                             window.onload=function(){
                                                //alert("Mensaje de alerta archivo");
                                                 document.forms["miformulario"].submit();
                                             }
                                        </script>
                                                 
                                        <form name="miformulario" action="../../cargarActa" method="POST" onsubmit="procesar(this.action);" >
                                            <input name="nombre" value="<?php echo $_POST['nombre']; ?>" type="hidden">
                                            <input name="proceso" value="<?php echo $_POST['proceso']; ?>" type="hidden">
                                            <input name="ubicacion" value="<?php echo $_POST['ubicacion']; ?>" type="hidden">
                                            <input name="fechainicio" value="<?php echo $_POST['fechainicio']; ?>" type="hidden">
                                            <input name="hora" value="<?php echo $_POST['hora']; ?>" type="hidden">
                                            <input name="alerta" value="1" type="hidden">
                                        </form> 
                                        <?php
	}else{
	
        
        if($nombreArchivo != NULL){
        
            $fecha = date("Ymjhis");
            $nombreFinal = $fecha.$nombreArchivo;
            
            
            if(!file_exists('../../archivos/actas/')){
        	mkdir('archivos/documentos',0777,true);
            	if(file_exists('../../archivos/actas/')){
            		if(move_uploaded_file($rutaArchivo, '../../archivos/actas/'.$nombreFinal)){
            	        //Guarda archivo
            	        
            	        
            		}else{
            			//echo "Archivo no se pudo guardar";
            		}
            	}
            }else{
            	if(move_uploaded_file($rutaArchivo, '../../archivos/actas/'.$nombreFinal)){
            	    
            	    if($fecha.$archivoNombre != NULL){ 
            		    $mysqli->query("INSERT INTO documentoArchivoTemporal (actas)VALUES('".utf8_decode($nombreFinal)."') ")or die(mysqli_error($mysqli)); 
            		    
            		    $preguntadoValidacion=$mysqli->query("SELECT * FROM documentoArchivoTemporal WHERE  actas='".utf8_decode($nombreFinal)."' ");
                		$extraerPreguntaValidacion=$preguntadoValidacion->fetch_array(MYSQLI_ASSOC);
                		   ' - '.$documentoExtraido2=utf8_encode($extraerPreguntaValidacion['actas']);
                		    
                		        
                        
                                 '<br><br>';
                        
                                //Lista de letras abecedario
                                $carpeta="../../archivos/actas/";
                                $ruta="/".$carpeta."/";
                                $directorio=opendir($carpeta);
                                //recoger los  datos
                                $datos=array();
                                $conteoArchivosB=0;
                                while ($archivo = readdir($directorio)) { 
                                  if(($archivo != '.')&&($archivo != '..')){
                                     
                                    if($documentoExtraido2 == $datos[]=$archivo){
                                        $conteoArchivosB++;
                                         $datos[]=$archivo;  '<br>';
                                    }
                                     
                                     
                                  } 
                                }
                                closedir($directorio);
                                    
                                if($conteoArchivosB > 0){
                                   $documentoHabilitado2='1'; 
                                }else{
                                   $documentoHabilitado2='no coincide';
                                }
                                 '<br>B: '.$documentoHabilitado2;
                                if($documentoHabilitado2 == 1){ 
            	       
                            	}else{  '<br>Redir..'; $EvariableRedirecciónActivado='1';
                            	
                            
                                        unlink(('../../archivos/actas/'.$nombreFinal));  utf8_decode($nombreFinal);
                                        $mysqli->query("DELETE FROM documentoArchivoTemporal WHERE actas='".utf8_decode($nombreFinal)."' ")or die(mysqli_error($mysqli));
                                        
                                    $radiobtn = $_POST['radiobtn'];//quien cita
                                    $select = json_encode($_POST['select_encargadoE']);
                                    $radiobtn2 = $_POST['radiobtn2'];//quien elabora
                                    $selectElabora = json_encode($_POST['select_encargadoR']);
                                    
                                    $radioActaSiNO = $_POST['radiobtnActa']; /// acta que requiere aprobación
                                    $radioActaTipo = $_POST['rad_AActa'];//quien aprobación
                                    $selectActaAprobacion = json_encode($_POST['select_encargadoAR2']); /// id de los aprobadores
                                    
                                    $mysqli->query("INSERT INTO documentoDatosTemporalesActas (quienCita,quienCitaId,quienElabora,quienElaboraId,usuario,aprobacion,quienAprobacion,quienAprobacionId)VALUES('$radiobtn','$select','$radiobtn2','$selectElabora','$celdulaUser','$radioActaSiNO','$radioActaTipo','$selectActaAprobacion')");
    
    
                            	        ?>
                                        <script> 
                                             window.onload=function(){
                                                //alert("Mensaje de alerta archivo");
                                                 document.forms["miformulario"].submit();
                                             }
                                        </script>
                                                 
                                        <form name="miformulario" action="../../cargarActa" method="POST" onsubmit="procesar(this.action);" >
                                            <input name="nombre" value="<?php echo $_POST['nombre']; ?>" type="hidden">
                                            <input name="proceso" value="<?php echo $_POST['proceso']; ?>" type="hidden">
                                            <input name="ubicacion" value="<?php echo $_POST['ubicacion']; ?>" type="hidden">
                                            <input name="fechainicio" value="<?php echo $_POST['fechainicio']; ?>" type="hidden">
                                            <input name="hora" value="<?php echo $_POST['hora']; ?>" type="hidden">
                                            <input name="alerta" value="1" type="hidden">
                                        </form> 
                                        <?php
                            	   }
            		
                		    
            		}
            	    
            	    
            	   
            	    
            	   
            	}else{
            		//echo "Archivo no se pudo guardar";
            	}
            }
            
            /*
            if(!file_exists('../../archivos/actas/')){
            
            	mkdir('../../archivos/actas/',0777,true);
            	if(file_exists('../../archivos/actas/')){
            	    
            		if(move_uploaded_file($rutaArchivo, '../../archivos/actas/'.$nombreFinal)){
            	        //Guarda archivo
            	          //echo "Sii se suibio el archivo";
            		}else{
            			//echo "Archivo no se pudo guardar 1";
            		}
            	}
            	
            }else{
                
            	if(move_uploaded_file($rutaArchivo, '../../archivos/actas/'.$nombreFinal)){
                    //echo "Sii se suibio el archivo";
            	}else{
            		//echo "Archivo no se pudo guardar 2";
            	}
            }
            */
            
            
            
            
        }
    
        if($EvariableRedirecciónActivado == '1'){
            
        }else{
           
            $nombreFinal=utf8_decode($nombreFinal);
            if($_POST['radiobtnCom'] == "si"){
                
                $nombre = utf8_decode($_POST['nombre']);
                $proceso = $_POST['proceso'];
                $ubicacion = utf8_decode($_POST['ubicacion']);
                $fechainicio = $_POST['fechainicio']; 
                $hora = $_POST['hora']; 
                $minuto = $_POST['minuto']; 
                //$fechainicioActa = $fechainicio." ".$hora.":".$minuto.":00";
                $fechainicioActa = $fechainicio." ".$hora;
                //$fechainicioActa = date('Y/m/j h:i:s', strtotime($fechainicioActa));
                
                $fechafin = $_POST['fechafin'];
                $horafin = $_POST['horafin']; 
                $minutofin = $_POST['minutofin']; 
                //$fechaFinActa = $fechafin." ".$horafin.":".$minutofin.":00";
                $fechaFinActa = $fechafin." ".$horafin;
                
                $radiobtn = $_POST['radiobtn'];//quien cita
                $select = json_encode($_POST['select_encargadoE']);
                $radiobtn2 = $_POST['radiobtn2'];//quien elabora
                $selectElabora = json_encode($_POST['select_encargadoR']);
                
                ///acta requiere arpovacion 
                $radioActaSiNO = $_POST['radiobtnActa'];//requiere compromisos
                $radioActaTipo = $_POST['rad_AActa'];//quien compromisos
                $selectActaAprobacion = json_encode($_POST['select_encargadoAR2']);
                
                //if($radioActaSiNo == "no"){
                 //   $estado = "Aprobado";
                //}
                if($radioActaSiNO == "no"){
                    $estado = "Aprobado";
                }else{
                    $estado = "Pendiente";
                }
                
                //////////////////////////////////////
                $radiobtnP = $_POST['radiobtnP'];//acta abierta publico
                $radiobtnP2 = $_POST['radiobtnP2'];//usuario cargo grupo
                $selectA2 = json_encode($_POST['select_encargadoA2']); 
                $editor = utf8_decode($_POST['editor1']);
                
                
                
                $mysqli->query("INSERT INTO `actas`(
                `nombreActa`,
                `proceso`,
                `ubicacion`,
                `fechaInicio`,
                `quienCita`,
                `quienCitaID`,
                `quienElabora`,
                `quienElaboraID`,
                `publico`,
                `permisosActa`,
                `responsablesActa`,
                `acta`,
                `aprobarActa`, 
                `quienAprueba`,
                `quienApruebaId`,
                `finalizada`,
                `actaCargada`,
                `rutaArchivo`,
                `usuario`,
                `estado`,
                `idEncabezado`
                )
                VALUES(
                '$nombre',
                '$proceso',
                '$ubicacion',
                '$fechainicioActa',
                '$radiobtn',
                '$select',
                '$radiobtn2',
                '$selectElabora',
                '$radiobtnP',
                '$radiobtnP2',
                '$selectA2',
                '$editor',
                '$radioActaSiNO',
                '$radioActaTipo',
                '$selectActaAprobacion',
                '1',
                '1',
                '$nombreFinal',
                '$celdulaUser',
                '$estado',
                '$idEncabezado'
                )")or die(mysqli_error($mysqli));
                
                                        require '../usuarios/libreria/PHPMailerAutoload.php';
                                        $radiobtn2;
                                        $arrayEncargado=$_POST['select_encargadoAR2'];
                                        $nombreDocEnviar=$_POST['nombre'];
             
             
                                                if($radiobtn2 == 'usuario'){ 
                                                    $longitud = count($arrayEncargado); 
                                                    for($i=0; $i<$longitud; $i++){
                                                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$arrayEncargado[$i]' ");
                                                        while($columna = $nombreuser->fetch_array()){
                                                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                                                         $correoResponsable=$columna['correo']; 
                                                         '<br>';
                                                        
                                                        
             
                                                                            
             
                                                                            //Create a new PHPMailer instance
                                                                            $mail = new PHPMailer();
                                                                            $mail->IsSMTP();
                                                                            
                                                                            //Configuracion servidor mail
                                                                            require '../../correoEnviar/contenido.php';
                                                                            
                                                                            //Agregar destinatario
                                                                            $mail->isHTML(true);
                                                                            $mail->AddAddress($correoResponsable);
                                                                            $mail->Subject = utf8_decode('Aprobación de acta '.$nombreDocEnviar);
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
                                                                            <p>El acta <b>'.$nombreDocEnviar.'.</b> se encuentra pendiente para su aprobación.</p>
                                                                            Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                                                            <br>
                                                                            <em>Mi perfil --> mis pendientes --> Actas --> Aprobación actas +</em>.
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
                                                                            
                                                                            } else {
             
                                                                            }
                                                                           
                                                        }                
                                                    }
                                                }
             
                                                if($radiobtn2 == 'cargo'){
                                                   
                                                    $longitud = count($arrayEncargado);
                                                    for($i=0; $i<$longitud; $i++){ 
                                                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo='$arrayEncargado[$i]' ");
                                                        while($columna = $nombreuser->fetch_array()){
                                                            $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                                                             $correoResponsable=$columna['correo']; 
                                                             '<br>';
                                                            
                                                            //Create a new PHPMailer instance
                                                            $mail = new PHPMailer();
                                                            $mail->IsSMTP();
                                                            
                                                            //Configuracion servidor mail
                                                            require '../../correoEnviar/contenido.php';
                                                            
                                                            //Agregar destinatario
                                                            $mail->isHTML(true);
                                                            $mail->AddAddress($correoResponsable);
                                                            $mail->Subject = utf8_decode('Aprobación de acta '.$nombreDocEnviar);
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
                                                            <p>El acta <b>'.$nombreDocEnviar.'.</b> se encuentra pendiente para su aprobación.</p>
                                                            Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                                            <br>
                                                            <em>Mi perfil --> mis pendientes --> Actas --> Aprobación actas +</em>.
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
                                                            
                                                            } else {
             
                                                            }
                                                           
                                                            
                                                        }
                                                    }
                                                }
        
                $queryId = $mysqli->query("SELECT MAX(id) AS id FROM `actas` WHERE usuario = '$celdulaUser' ORDER BY id DESC ");
                $datos = $queryId->fetch_array(MYSQLI_ASSOC);
                $idActa = $datos['id'];
                
                
                ?>
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformulario"].submit();
                         }
                    </script>
                     
                    <form name="miformulario" action="../../compromiso" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="idActa" value="<?php echo $idActa; ?>">
                    </form> 
                <?php    
                
            }else{
                $nombre = utf8_decode($_POST['nombre']);
                $proceso = $_POST['proceso'];
                $ubicacion = utf8_decode($_POST['ubicacion']);
                $fechainicio = $_POST['fechainicio']; 
                $hora = $_POST['hora']; 
                $minuto = $_POST['minuto']; 
                $fechainicioActa = $fechainicio." ".$hora;
                //$fechainicioActa = $fechainicio." ".$hora.":".$minuto.":00";
                //$fechainicioActa = date('Y/m/j h:i:s', strtotime($fechainicioActa));
                
                $fechafin = $_POST['fechafin'];
                $horafin = $_POST['horafin']; 
                $minutofin = $_POST['minutofin']; 
                //$fechaFinActa = $fechafin." ".$horafin.":".$minutofin.":00";
                $fechaFinActa = $fechafin." ".$horafin;
                
                $radiobtn = $_POST['radiobtn'];//quien cita
                $select = json_encode($_POST['select_encargadoE']);
                $radiobtn2 = $_POST['radiobtn2'];//quien elabora
                $selectElabora = json_encode($_POST['select_encargadoR']);
                
                ///acta requiere arpovacion 
                $radioActaSiNO = $_POST['radiobtnActa'];//requiere compromisos
                $radioActaTipo = $_POST['rad_AActa'];//quien compromisos
                $selectActaAprobacion = json_encode($_POST['select_encargadoAR2']);
        
                
                //////////////////////////////////////
                $radiobtnP = $_POST['radiobtnP'];//acta abierta publico
                $radiobtnP2 = $_POST['radiobtnP2'];//usuario cargo grupo
                $selectA2 = json_encode($_POST['select_encargadoA2']); 
                $editor = utf8_decode($_POST['editor1']);
                
                 if($fechaFinActa < $fechainicioActa){
                    //echo 'alertar';
                            $mysqli->query("INSERT INTO `actas`(
                            `nombreActa`,
                            `proceso`,
                            `ubicacion`,
                            `fechaInicio`,
                            `fechaCierre`,
                            `quienCita`,
                            `quienCitaID`,
                            `quienElabora`,
                            `quienElaboraID`,
                            `publico`,
                            `permisosActa`,
                            `responsablesActa`,
                            `acta`,
                            `aprobarActa`, 
                            `quienAprueba`,
                            `quienApruebaId`,
                            `finalizada`,
                            `actaCargada`,
                            `rutaArchivo`,
                            `usuario`,
                            `idEncabezado`
                            )
                            VALUES(
                            '$nombre',
                            '$proceso',
                            '$ubicacion',
                            '$fechainicioActa',
                            '$fechaFinActa',
                            '$radiobtn',
                            '$select',
                            '$radiobtn2',
                            '$selectElabora',
                            '$radiobtnP',
                            '$radiobtnP2',
                            '$selectA2',
                            '$editor',
                            '$radioActaSiNO',
                            '$radioActaTipo',
                            '$selectActaAprobacion',
                            '1',
                            '1',
                            '$nombreFinal',
                            '$celdulaUser',
                            '$idEncabezado'
                            )")or die(mysqli_error($mysqli));
        
                    
                            require '../usuarios/libreria/PHPMailerAutoload.php';
                            $radiobtn2;
                            $arrayEncargado=$_POST['select_encargadoAR2'];
                            $nombreDocEnviar=$_POST['nombre'];
        
        
                                    if($radiobtn2 == 'usuario'){ 
                                        $longitud = count($arrayEncargado); 
                                        for($i=0; $i<$longitud; $i++){
                                            $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$arrayEncargado[$i]' ");
                                            while($columna = $nombreuser->fetch_array()){
                                            $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                                            $correoResponsable=$columna['correo']; 
                                            '<br>';
                                            
                                            
        
                                                                
        
                                                                //Create a new PHPMailer instance
                                                                $mail = new PHPMailer();
                                                                $mail->IsSMTP();
                                                                
                                                                //Configuracion servidor mail
                                                                require '../../correoEnviar/contenido.php';
                                                                
                                                                //Agregar destinatario
                                                                $mail->isHTML(true);
                                                                $mail->AddAddress($correoResponsable);
                                                                $mail->Subject = utf8_decode('Aprobación de acta '.$nombreDocEnviar);
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
                                                                <p>El acta <b>'.$nombreDocEnviar.'.</b> se encuentra pendiente para su aprobación.</p>
                                                                Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                                                <br>
                                                                <em>Mi perfil --> mis pendientes --> Actas --> Aprobación actas +</em>.
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
                                                                
                                                                } else {
        
                                                                }
                                            }
                                                                
                                        }
                                    }
        
                                    if($radiobtn2 == 'cargo'){
                                    
                                        $longitud = count($arrayEncargado);
                                        for($i=0; $i<$longitud; $i++){ 
                                            $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo='$arrayEncargado[$i]' ");
                                            while($columna = $nombreuser->fetch_array()){
                                                $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                                                $correoResponsable=$columna['correo']; 
                                                '<br>';
                                                
                                                //Create a new PHPMailer instance
                                                $mail = new PHPMailer();
                                                $mail->IsSMTP();
                                                
                                                //Configuracion servidor mail
                                                require '../../correoEnviar/contenido.php';
                                                
                                                //Agregar destinatario
                                                $mail->isHTML(true);
                                                $mail->AddAddress($correoResponsable);
                                                $mail->Subject = utf8_decode('Aprobación de acta '.$nombreDocEnviar);
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
                                                <p>El acta <b>'.$nombreDocEnviar.'.</b> se encuentra pendiente para su aprobación.</p>
                                                Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                                <br>
                                                <em>Mi perfil --> mis pendientes --> Actas --> Aprobación actas +</em>.
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
                                                
                                                } else {
        
                                                }
                                            
                                                
                                            }
                                        }
                                    }
        
        
        
                    $queryId = $mysqli->query("SELECT MAX(id) AS id FROM `actas` WHERE usuario = '$celdulaUser' ORDER BY id DESC ");
                    $datos = $queryId->fetch_array(MYSQLI_ASSOC);
                    $idActa = $datos['id'];
                    ?>
                    <script> 
                         window.onload=function(){
                            //alert("La fecha de cierre no puede ser menor a la fecha de inicio");
                            document.forms["miformulario"].submit();
                         }
                    </script>
                     
                    <form name="miformulario" action="../../cargarActaCargado" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="validacionExiste" value="1">
                        <input type="hidden" name="idActa" value="<?php echo $idActa; ?>">
                    </form> 
                <?php 
                    //echo '<script language="javascript">alert("La fecha de cierre no puede ser menor a la fecha de inicio");
                    //window.location.href="../../cargarActa"</script>';
                }else{
                
                $mysqli->query("INSERT INTO `actas`(
                `nombreActa`,
                `proceso`,
                `ubicacion`,
                `fechaInicio`,
                `fechaCierre`,
                `quienCita`,
                `quienCitaID`,
                `quienElabora`,
                `quienElaboraID`,
                `publico`,
                `permisosActa`,
                `responsablesActa`,
                `acta`,
                `aprobarActa`, 
                `quienAprueba`,
                `quienApruebaId`,
                `finalizada`,
                `actaCargada`,
                `rutaArchivo`,
                `usuario`,
                `idEncabezado`
                
                )
                VALUES(
                '$nombre',
                '$proceso',
                '$ubicacion',
                '$fechainicioActa',
                '$fechaFinActa',
                '$radiobtn',
                '$select',
                '$radiobtn2',
                '$selectElabora',
                '$radiobtnP',
                '$radiobtnP2',
                '$selectA2',
                '$editor',
                '$radioActaSiNO',
                '$radioActaTipo',
                '$selectActaAprobacion',
                '1',
                '1',
                '$nombreFinal',
                '$celdulaUser',
                '$idEncabezado'
                )")or die(mysqli_error($mysqli));
                
                require '../usuarios/libreria/PHPMailerAutoload.php';
                $radiobtn2;
                $arrayEncargado=$_POST['select_encargadoAR2'];
                $nombreDocEnviar=$_POST['nombre'];
        
        
                        if($radiobtn2 == 'usuario'){ 
                            $longitud = count($arrayEncargado); 
                            for($i=0; $i<$longitud; $i++){
                                $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$arrayEncargado[$i]' ");
                                while($columna = $nombreuser->fetch_array()){
                                $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                                $correoResponsable=$columna['correo']; 
                                '<br>';
                                
                                
        
                                                    
        
                                                    //Create a new PHPMailer instance
                                                    $mail = new PHPMailer();
                                                    $mail->IsSMTP();
                                                    
                                                    //Configuracion servidor mail
                                                    require '../../correoEnviar/contenido.php';
                                                    
                                                    //Agregar destinatario
                                                    $mail->isHTML(true);
                                                    $mail->AddAddress($correoResponsable);
                                                    $mail->Subject = utf8_decode('Aprobación de acta '.$nombreDocEnviar);
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
                                                    <p>El acta <b>'.$nombreDocEnviar.'.</b> se encuentra pendiente para su aprobación.</p>
                                                    Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                                    <br>
                                                    <em>Mi perfil --> mis pendientes --> Actas --> Aprobación actas +</em>.
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
                                                    
                                                    } else {
        
                                                    }
                                }     
                                                    
                            }
                        }
        
                        if($radiobtn2 == 'cargo'){
                        
                            $longitud = count($arrayEncargado);
                            for($i=0; $i<$longitud; $i++){ 
                                $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo='$arrayEncargado[$i]' ");
                                while($columna = $nombreuser->fetch_array()){
                                    $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                                    $correoResponsable=$columna['correo']; 
                                    '<br>';
                                    
                                    //Create a new PHPMailer instance
                                    $mail = new PHPMailer();
                                    $mail->IsSMTP();
                                    
                                    //Configuracion servidor mail
                                    require '../../correoEnviar/contenido.php';
                                    
                                    //Agregar destinatario
                                    $mail->isHTML(true);
                                    $mail->AddAddress($correoResponsable);
                                    $mail->Subject = utf8_decode('Aprobación de acta '.$nombreDocEnviar);
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
                                    <p>El acta <b>'.$nombreDocEnviar.'.</b> se encuentra pendiente para su aprobación.</p>
                                    Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                    <br>
                                    <em>Mi perfil --> mis pendientes --> Actas --> Aprobación actas +</em>.
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
                                    
                                    } else {
        
                                    }
                                
                                    
                                }
                            }
                        }
                    
                //echo '<script language="javascript">alert("Exito al cargar el acta");
                //window.location.href="../../actas"</script>';
                 ?>
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformulario"].submit();
                         }
                    </script>
                     
                    <form name="miformulario" action="../../actas" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="validacionAgregar" value="1">
                    </form> 
                <?php
                
                }
            }
        }
	}
}


if(isset($_POST['siguiente'])){
    $idEncabezado=$_POST['idEncabezado'];
    $idEncabezadoPlantilla=$_POST['idEncabezadoPlantilla'];
    if($_POST['radiobtnCom'] == "si"){
        
        $nombre = utf8_decode($_POST['nombre']);
        $proceso = $_POST['proceso'];
        $ubicacion = utf8_decode($_POST['ubicacion']);
        $fechainicio = $_POST['fechainicio']; 
        $hora = $_POST['hora']; 
        $minuto = $_POST['minuto']; 
        $fechainicioActa = $fechainicio." ".$hora;
        //$fechainicioActa = $fechainicio." ".$hora.":".$minuto.":00";
        //$fechainicioActa = date('Y/m/j h:i:s', strtotime($fechainicioActa));
        //$fechafin = $_POST['fechafin'];
        $fechafin = date("Y/m/j h:i:s");
        $radiobtn = $_POST['radiobtn'];//quien cita
        $select = json_encode($_POST['select_encargadoE']);
        $radiobtn2 = $_POST['radiobtn2'];//quien elabora
        $selectElabora = json_encode($_POST['select_encargadoR']);
        $radiobtn3 = $_POST['radiobtn3'];//requiere compromisos
        $radiobtn31 = $_POST['radiobtn31'];//quien compromisos
        $selectCompromisos = json_encode($_POST['select_encargadoAR']);
        ///acta requiere arpovacion 
        $radioActaSiNO = $_POST['radiobtnActa'];//requiere 
        $radioActaTipo = $_POST['rad_AActa'];//quien 
        $selectActaAprobacion = json_encode($_POST['select_encargadoAR2']);
        
        $radiobtnC = $_POST['radiobtnC'];//quien convocados
        $selectConvocados = json_encode($_POST['select_encargadoC']);
       

        
       $arrayEncargadoB=$_POST['select_encargadoC'];
       $nombreDocEnviar=$_POST['nombre'];
    
                                    /*
                                       if($radiobtnC == 'usuario'){ 
                                           $longitud = count($arrayEncargadoB); 
                                           for($i=0; $i<$longitud; $i++){
                                               $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$arrayEncargadoB[$i]' ");
                                               while($columna = $nombreuser->fetch_array()){
                                               $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                                                $correoResponsable=$columna['correo']; 
                                                '<br>';
                                               
                                               
    
                                                                   
    
                                                                   //Create a new PHPMailer instance
                                                                   $mail = new PHPMailer();
                                                                   $mail->IsSMTP();
                                                                   
                                                                   //Configuracion servidor mail
                                                                   require '../../correoEnviar/contenido.php';
                                                                   
                                                                   //Agregar destinatario
                                                                   $mail->isHTML(true);
                                                                   $mail->AddAddress($correoResponsable);
                                                                   $mail->Subject = utf8_decode('Acta '.$nombreDocEnviar);
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
                                                                   <p>Se invita a ser partícipe del acta <b>'.$nombreDocEnviar.'.</b>.</p>
                                                                   Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                                                   <br>
                                                                   <em>Actas --> ubicar el nombre del acta --> ver más </em>.
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
                                                                   
                                                                   } else {
    
                                                                   }
                                               }  
                                                                   
                                           }
                                       }
    
                                       if($radiobtnC == 'cargo'){
                                          
                                           $longitud = count($arrayEncargadoB);
                                           for($i=0; $i<$longitud; $i++){ 
                                               $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo='$arrayEncargadoB[$i]' ");
                                               while($columna = $nombreuser->fetch_array()){
                                                   $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                                                    $correoResponsable=$columna['correo']; 
                                                    '<br>';
                                                   
                                                   //Create a new PHPMailer instance
                                                   $mail = new PHPMailer();
                                                   $mail->IsSMTP();
                                                   
                                                   //Configuracion servidor mail
                                                   require '../../correoEnviar/contenido.php';
                                                   
                                                   //Agregar destinatario
                                                   $mail->isHTML(true);
                                                   $mail->AddAddress($correoResponsable);
                                                   $mail->Subject = utf8_decode('Acta '.$nombreDocEnviar);
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
                                                                   <p>Se invita a ser participe del acta <b>'.$nombreDocEnviar.'.</b>.</p>
                                                                   Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                                                   <br>
                                                                   <em>Actas --> ubicar el nombre del acta --> ver más </em>.
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
                                                   
                                                   } else {
    
                                                   }
                                                  
                                                   
                                               }
                                           }
                                       }

                                    */


        $radiobtnAsis = $_POST['rad_Asis'];//quien asiste
        $selectAsis = json_encode($_POST['select_encargadoAsis']);
        /////////////convocados externos 
        $convocadosEXT =$_POST['convocadosEXT1'];
        $tipoEmpresaEXT = $_POST['tipoEmpresaEXT1'];
        $nombreEmpresa =$_POST['nombreEmpresa1'];
        $cargoEXT =$_POST['cargoEXT1'];
        
        $convocadosEXT2 =$_POST['convocadosEXT2'];
        $tipoEmpresaEXT2 = $_POST['tipoEmpresaEXT2'];
        $nombreEmpresa2 = $_POST['nombreEmpresa2'];
        $cargoEXT2 = $_POST['cargoEXT2'];
        
        $convocadosEXT3 =$_POST['convocadosEXT3'];
        $tipoEmpresaEXT3 = $_POST['tipoEmpresaEXT3'];
        $nombreEmpresa3 = $_POST['nombreEmpresa3'];
        $cargoEXT3 = $_POST['cargoEXT3'];
        
        $convocadosEXT4 =$_POST['convocadosEXT4'];
        $tipoEmpresaEXT4 = $_POST['tipoEmpresaEXT4'];
        $nombreEmpresa4 = $_POST['nombreEmpresa4'];
        $cargoEXT4 = $_POST['cargoEXT4'];
        $convocadosEXT5 =$_POST['convocadosEXT5'];
        $tipoEmpresaEXT5 = $_POST['tipoEmpresaEXT5'];
        $nombreEmpresa5 = $_POST['nombreEmpresa5'];
        $cargoEXT5 = $_POST['cargoEXT5'];
        $convocadosEXT6 =$_POST['convocadosEXT6'];
        $tipoEmpresaEXT6 = $_POST['tipoEmpresaEXT6'];
        $nombreEmpresa6 = $_POST['nombreEmpresa6'];
        $cargoEXT6 = $_POST['cargoEXT6'];
        $convocadosEXT7 =$_POST['convocadosEXT7'];
        $tipoEmpresaEXT7 = $_POST['tipoEmpresaEXT7'];
        $nombreEmpresa7 = $_POST['nombreEmpresa7'];
        $cargoEXT7 = $_POST['cargoEXT7'];
        $convocadosEXT8 =$_POST['convocadosEXT8'];
        $tipoEmpresaEXT8 = $_POST['tipoEmpresaEXT8'];
        $nombreEmpresa8 = $_POST['nombreEmpresa8'];
        $cargoEXT8 = $_POST['cargoEXT8'];
        $convocadosEXT9 =$_POST['convocadosEXT9'];
        $tipoEmpresaEXT9 = $_POST['tipoEmpresaEXT9'];
        $nombreEmpresa9 = $_POST['nombreEmpresa9'];
        $cargoEXT9 = $_POST['cargoEXT9'];
        $convocadosEXT10 =$_POST['convocadosEXT10'];
        $tipoEmpresaEXT10 = $_POST['tipoEmpresaEXT10'];
        $nombreEmpresa10 = $_POST['nombreEmpresa10'];
        $cargoEXT10 = $_POST['cargoEXT10'];
    
        $jsonConvocado = json_encode($convocadosEXT.','.$convocadosEXT2.','.$convocadosEXT3.','.$convocadosEXT4.','.$convocadosEXT5.','.$convocadosEXT6.','.$convocadosEXT7.','.$convocadosEXT8.','.$convocadosEXT9.','.$convocadosEXT10,JSON_UNESCAPED_UNICODE);
        $jsonConvocado=utf8_decode($jsonConvocado);
        //var_dump($jsonConvocado);
        $jsonTipo = json_encode($tipoEmpresaEXT.','.$tipoEmpresaEXT2.','.$tipoEmpresaEXT3.','.$tipoEmpresaEXT4.','.$tipoEmpresaEXT5.','.$tipoEmpresaEXT6.','.$tipoEmpresaEXT7.','.$tipoEmpresaEXT8.','.$tipoEmpresaEXT9.','.$tipoEmpresaEXT10,JSON_UNESCAPED_UNICODE);
        //var_dump($jsonTipo);
        $jsonNombre = json_encode($nombreEmpresa.','.$nombreEmpresa2.','.$nombreEmpresa3.','.$nombreEmpresa4.','.$nombreEmpresa5.','.$nombreEmpresa6.','.$nombreEmpresa7.','.$nombreEmpresa8.','.$nombreEmpresa9.','.$nombreEmpresa10,JSON_UNESCAPED_UNICODE);
        $jsonNombre=utf8_decode($jsonNombre);
        //var_dump($jsonNombre);
        $jsonCargo = json_encode($cargoEXT.','.$cargoEXT2.','.$cargoEXT3.','.$cargoEXT4.','.$cargoEXT5.','.$cargoEXT6.','.$cargoEXT7.','.$cargoEXT8.','.$cargoEXT9.','.$cargoEXT10,JSON_UNESCAPED_UNICODE);
        $jsonCargo=utf8_decode($jsonCargo);
        //var_dump($jsonCargo);
        
        //////////////////////////////////////
        $radiobtnP = $_POST['radiobtnP'];//acta abierta publico
        $radiobtnP2 = $_POST['radiobtnP2'];//usuario cargo grupo
        $selectA2 = json_encode($_POST['select_encargadoA2']); 
        $editor = utf8_decode($_POST['editor1']);
        
        if($radioActaSiNO == "no"){
            $estado = "Aprobado";
        }else{
            $estado = "Pendiente";
        }
        
        
        $mysqli->query("INSERT INTO `actas`(
        `nombreActa`,
        `proceso`,
        `ubicacion`,
        `fechaInicio`,
        `fechaCierre`,
        `quienCita`,
        `quienCitaID`,
        `quienElabora`,
        `quienElaboraID`,
        `aprobacionCompromisos`,
        `compromisos`,
        `compromisosID`,
        `convocado`,
        `convocadoID`,
        `asistente`,
        `asistenteID`,
        `nombreConvocadoEXT`,
        `tipoEmpresaCovEXT`,
        `nombreEmpresa`,
        `cargoConvocadoEXT`,
        `publico`,
        `permisosActa`,
        `responsablesActa`,
        `acta`,
        `aprobarActa`, 
        `quienAprueba`,
        `quienApruebaId`,
        `usuario`,
        `estado`,
        `idEncabezado`,
        `idEncabezadoPlantilla`
        )
        VALUES(
        '$nombre',
        '$proceso',
        '$ubicacion',
        '$fechainicioActa',
        '$fechafin',
        '$radiobtn',
        '$select',
        '$radiobtn2',
        '$selectElabora',
        '$radiobtn3',
        '$radiobtn31',
        '$selectCompromisos',
        '$radiobtnC',
        '$selectConvocados',
        '$radiobtnAsis',
        '$selectAsis',
        '$jsonConvocado',
        '$jsonTipo',
        '$jsonNombre',
        '$jsonCargo',
        '$radiobtnP',
        '$radiobtnP2',
        '$selectA2',
        '$editor',
        '$radioActaSiNO',
        '$radioActaTipo',
        '$selectActaAprobacion',
        '$celdulaUser',
        '$estado',
        '$idEncabezado',
        '$idEncabezadoPlantilla'
        )")or die(mysqli_error($mysqli));
    
        //require '../usuarios/libreria/PHPMailerAutoload.php';

        $radiobtn2;
        $arrayEncargado=$_POST['select_encargadoAR2'];
        $nombreDocEnviar=$_POST['nombre'];


                                  

        $queryId = $mysqli->query("SELECT MAX(id) AS id FROM `actas` WHERE usuario = '$celdulaUser' ORDER BY id DESC ");
        $datos = $queryId->fetch_array(MYSQLI_ASSOC);
        $idActa = $datos['id'];
        
        ?>
                <script> 
                    window.onload=function(){
                
                        document.forms["miformulario"].submit();
                    }
                </script>
                
                <form name="miformulario" action="../../compromiso" method="POST" onsubmit="procesar(this.action);" >
                    <input type="hidden" name="idActa" value="<?php echo $idActa; ?>">
                </form> 
        <?php    
        
        
        //echo '<script language="javascript">alert("Exito al cargar el acta");
        //window.location.href="../../actas"</script>';
        
    }else{
        
        $nombre = utf8_decode($_POST['nombre']);
        $proceso = $_POST['proceso'];
        $ubicacion = utf8_decode($_POST['ubicacion']);
        $fechainicio = $_POST['fechainicio']; 
        $hora = $_POST['hora']; 
        $minuto = $_POST['minuto'];
        $fechainicioActa = $fechainicio." ".$hora;
        //$fechainicioActa = $fechainicio." ".$hora.":".$minuto.":00";
        //$fechainicioActa = date('Y/m/j h:i:s', strtotime($fechainicioActa));
        
        $fechafin = $_POST['fechafin'];
        $horafin = $_POST['horafin']; 
        $minutofin = $_POST['minutofin']; 
        //$fechaFinActa = $fechafin." ".$horafin.":".$minutofin.":00";
        $fechaFinActa = $fechafin." ".$horafin;

        
        $radiobtn = $_POST['radiobtn'];//quien cita
        $select = json_encode($_POST['select_encargadoE']);
        $radiobtn2 = $_POST['radiobtn2'];//quien elabora
        $selectElabora = json_encode($_POST['select_encargadoR']);
        $radiobtn3 = $_POST['radiobtn3'];//requiere compromisos
        $radiobtn31 = $_POST['radiobtn31'];//quien compromisos 
        $selectCompromisos = json_encode($_POST['select_encargadoAR']);
        $radiobtnC = $_POST['radiobtnC'];//quien convocados
        $selectConvocados = json_encode($_POST['select_encargadoC']);

        require '../usuarios/libreria/PHPMailerAutoload.php';
        $arrayEncargadoB=$_POST['select_encargadoC'];
        $nombreDocEnviar=$_POST['nombre'];
     
                                /*
                                        if($radiobtnC == 'usuario'){ 
                                            $longitud = count($arrayEncargadoB); 
                                            for($i=0; $i<$longitud; $i++){
                                                $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$arrayEncargadoB[$i]' ");
                                                while($columna = $nombreuser->fetch_array()){
                                                $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                                                 $correoResponsable=$columna['correo']; 
                                                 '<br>';
                                                
                                                
     
                                                                    
     
                                                                    //Create a new PHPMailer instance
                                                                    $mail = new PHPMailer();
                                                                    $mail->IsSMTP();
                                                                    
                                                                    //Configuracion servidor mail
                                                                    require '../../correoEnviar/contenido.php';
                                                                    
                                                                    //Agregar destinatario
                                                                    $mail->isHTML(true);
                                                                    $mail->AddAddress($correoResponsable);
                                                                    $mail->Subject = utf8_decode('Acta '.$nombreDocEnviar);
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
                                                                    <p>Se invita a ser partícipe del acta <b>'.$nombreDocEnviar.'.</b>.</p>
                                                                    Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                                                    <br>
                                                                    <em>Actas --> ubicar el nombre del acta --> ver más </em>.
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
                                                                    
                                                                    } else {
     
                                                                    }
                                                                   
                                                }            
                                            }
                                        }
     
                                        if($radiobtnC == 'cargo'){
                                           
                                            $longitud = count($arrayEncargadoB);
                                            for($i=0; $i<$longitud; $i++){ 
                                                $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo='$arrayEncargadoB[$i]' ");
                                                while($columna = $nombreuser->fetch_array()){
                                                    $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                                                     $correoResponsable=$columna['correo']; 
                                                     '<br>';
                                                    
                                                    //Create a new PHPMailer instance
                                                    $mail = new PHPMailer();
                                                    $mail->IsSMTP();
                                                    
                                                    //Configuracion servidor mail
                                                    require '../../correoEnviar/contenido.php';
                                                    
                                                    //Agregar destinatario
                                                    $mail->isHTML(true);
                                                    $mail->AddAddress($correoResponsable);
                                                    $mail->Subject = utf8_decode('Acta '.$nombreDocEnviar);
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
                                                                    <p>Se invita a ser partícipe del acta <b>'.$nombreDocEnviar.'.</b>.</p>
                                                                    Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                                                    <br>
                                                                    <em>Actas --> ubicar el nombre del acta --> ver más </em>.
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
                                                    
                                                    } else {
     
                                                    }
                                                   
                                                    
                                                }
                                            }
                                        }
        
                                */
                                
        $radiobtnAsis = $_POST['rad_Asis'];//quien asiste
        $selectAsis = json_encode($_POST['select_encargadoAsis']);
        
        ///acta requiere arpovacion 
        $radioActaSiNO = $_POST['radiobtnActa'];//requiere compromisos
        $radioActaTipo = $_POST['rad_AActa'];//quien compromisos
        $selectActaAprobacion = json_encode($_POST['select_encargadoAR2']); // si require aprobación es quien aprueba
        /////////////convocados externos 
        $convocadosEXT = $_POST['convocadosEXT1']; 
        $tipoEmpresaEXT = $_POST['tipoEmpresaEXT1']; 
        $nombreEmpresa = $_POST['nombreEmpresa1']; 
        $cargoEXT = $_POST['cargoEXT1'];
        $convocadosEXT2 =$_POST['convocadosEXT2'];
        $tipoEmpresaEXT2 = $_POST['tipoEmpresaEXT2'];
        $nombreEmpresa2 = $_POST['nombreEmpresa2'];
        $cargoEXT2 = $_POST['cargoEXT2'];
        $convocadosEXT3 =$_POST['convocadosEXT3'];
        $tipoEmpresaEXT3 = $_POST['tipoEmpresaEXT3'];
        $nombreEmpresa3 = $_POST['nombreEmpresa3'];
        $cargoEXT3 = $_POST['cargoEXT3'];
        $convocadosEXT4 =$_POST['convocadosEXT4'];
        $tipoEmpresaEXT4 = $_POST['tipoEmpresaEXT4'];
        $nombreEmpresa4 = $_POST['nombreEmpresa4'];
        $cargoEXT4 = $_POST['cargoEXT4'];
        $convocadosEXT5 =$_POST['convocadosEXT5'];
        $tipoEmpresaEXT5 = $_POST['tipoEmpresaEXT5'];
        $nombreEmpresa5 = $_POST['nombreEmpresa5'];
        $cargoEXT5 = $_POST['cargoEXT5'];
        $convocadosEXT6 =$_POST['convocadosEXT6'];
        $tipoEmpresaEXT6 = $_POST['tipoEmpresaEXT6'];
        $nombreEmpresa6 = $_POST['nombreEmpresa6'];
        $cargoEXT6 = $_POST['cargoEXT6'];
        $convocadosEXT7 =$_POST['convocadosEXT7'];
        $tipoEmpresaEXT7 = $_POST['tipoEmpresaEXT7'];
        $nombreEmpresa7 = $_POST['nombreEmpresa7'];
        $cargoEXT7 = $_POST['cargoEXT7'];
        $convocadosEXT8 =$_POST['convocadosEXT8'];
        $tipoEmpresaEXT8 = $_POST['tipoEmpresaEXT8'];
        $nombreEmpresa8 = $_POST['nombreEmpresa8'];
        $cargoEXT8 = $_POST['cargoEXT8'];
        $convocadosEXT9 =$_POST['convocadosEXT9'];
        $tipoEmpresaEXT9 = $_POST['tipoEmpresaEXT9'];
        $nombreEmpresa9 = $_POST['nombreEmpresa9'];
        $cargoEXT9 = $_POST['cargoEXT9'];
        $convocadosEXT10 =$_POST['convocadosEXT10'];
        $tipoEmpresaEXT10 = $_POST['tipoEmpresaEXT10'];
        $nombreEmpresa10 = $_POST['nombreEmpresa10'];
        $cargoEXT10 = $_POST['cargoEXT10'];
    
        //$jsonConvocado = json_encode($convocadosEXT,JSON_UNESCAPED_UNICODE,$convocadosEXT2,JSON_UNESCAPED_UNICODE,$convocadosEXT3,JSON_UNESCAPED_UNICODE,$convocadosEXT4,JSON_UNESCAPED_UNICODE,$convocadosEXT5.','.$convocadosEXT6.','.$convocadosEXT7.','.$convocadosEXT8.','.$convocadosEXT9.','.$convocadosEXT10, JSON_UNESCAPED_UNICODE);

        $jsonConvocado = json_encode($convocadosEXT.','.$convocadosEXT2.','.$convocadosEXT3.','.$convocadosEXT4.','.$convocadosEXT5.','.$convocadosEXT6.','.$convocadosEXT7.','.$convocadosEXT8.','.$convocadosEXT9.','.$convocadosEXT10, JSON_UNESCAPED_UNICODE);
        $jsonConvocado=utf8_decode($jsonConvocado);
        //var_dump($jsonConvocado);
        $jsonTipo = json_encode($tipoEmpresaEXT.','.$tipoEmpresaEXT2.','.$tipoEmpresaEXT3.','.$tipoEmpresaEXT4.','.$tipoEmpresaEXT5.','.$tipoEmpresaEXT6.','.$tipoEmpresaEXT7.','.$tipoEmpresaEXT8.','.$tipoEmpresaEXT9.','.$tipoEmpresaEXT10);
        //var_dump($jsonTipo);
        $jsonNombre = json_encode($nombreEmpresa.','.$nombreEmpresa2.','.$nombreEmpresa3.','.$nombreEmpresa4.','.$nombreEmpresa5.','.$nombreEmpresa6.','.$nombreEmpresa7.','.$nombreEmpresa8.','.$nombreEmpresa9.','.$nombreEmpresa10, JSON_UNESCAPED_UNICODE);
        $jsonNombre=utf8_decode($jsonNombre);
        //var_dump($jsonNombre);
        $jsonCargo = json_encode($cargoEXT.','.$cargoEXT2.','.$cargoEXT3.','.$cargoEXT4.','.$cargoEXT5.','.$cargoEXT6.','.$cargoEXT7.','.$cargoEXT8.','.$cargoEXT9.','.$cargoEXT10, JSON_UNESCAPED_UNICODE);
        $jsonCargo=utf8_decode($jsonCargo);
        //var_dump($jsonCargo);
        
        //////////////////////////////////////
        $radiobtnP = $_POST['radiobtnP'];//acta abierta publico
        $radiobtnP2 = $_POST['radiobtnP2'];//usuario cargo grupo
        $selectA2 = json_encode($_POST['select_encargadoA2']); 
        $editor = utf8_decode($_POST['editor1']);
        
        /*$compromisos = $_POST['compromisos'];
        $rad_Res = $_POST['rad_Res'];//responsables radio button
        $selectRes = json_encode($_POST['select_encargadoRes']);
        $fechaEntrega = $_POST['fechaEntrega'];
        $rad_Entrega = $_POST['rad_Entrega'];//entregar a  radio button
        $selectEntrega = json_encode($_POST['select_encargadoEntrega']);
        */
        
        
        if($radioActaSiNO == "no"){
            $estado = "Aprobado";
        }else{
            $estado = "Pendiente";
        }
        
         

        
        if($fechaFinActa < $fechainicioActa){
            
        //if($fechafin < $fechainicio || $horafin <= $hora){
            //echo 'alertar';
            
            
                        $mysqli->query("INSERT INTO `actas`(
                        `nombreActa`,
                        `proceso`,
                        `ubicacion`,
                        `fechaInicio`,
                        `fechaCierre`,
                        `quienCita`,
                        `quienCitaID`,
                        `quienElabora`,
                        `quienElaboraID`,
                        `aprobacionCompromisos`,
                        `compromisos`,
                        `compromisosID`,
                        `convocado`,
                        `convocadoID`,
                        `asistente`,
                        `asistenteID`,
                        `nombreConvocadoEXT`,
                        `tipoEmpresaCovEXT`,
                        `nombreEmpresa`,
                        `cargoConvocadoEXT`,
                        `publico`,
                        `permisosActa`,
                        `responsablesActa`,
                        `acta`,
                        `aprobarActa`, 
                        `quienAprueba`,
                        `quienApruebaId`,
                        `finalizada`,
                        `usuario`,
                        `estado`,
                        `idEncabezado`,
                        `idEncabezadoPlantilla`
                        
                    )
                    VALUES(
                    '$nombre',
                    '$proceso',
                    '$ubicacion',
                    '$fechainicioActa',
                    '$fechaFinActa',
                    '$radiobtn',
                    '$select',
                    '$radiobtn2',
                    '$selectElabora',
                    '$radiobtn3',
                    '$radiobtn31',
                    '$selectCompromisos',
                    '$radiobtnC',
                    '$selectConvocados',
                    '$radiobtnAsis',
                    '$selectAsis',
                    '$jsonConvocado',
                    '$jsonTipo',
                    '$jsonNombre',
                    '$jsonCargo',
                    '$radiobtnP',
                    '$radiobtnP2',
                    '$selectA2',
                    '$editor',
                    '$radioActaSiNO',
                    '$radioActaTipo',
                    '$selectActaAprobacion',
                    '1',
                    '$celdulaUser',
                    '$estado',
                    '$idEncabezado',
                    '$idEncabezadoPlantilla'
                    )")or die(mysqli_error($mysqli));
    
            $queryId = $mysqli->query("SELECT MAX(id) AS id FROM `actas` WHERE usuario = '$celdulaUser' ORDER BY id DESC ");
            $datos = $queryId->fetch_array(MYSQLI_ASSOC);
            $idActa = $datos['id'];
        
            ?>
                    <script> 
                         window.onload=function(){
                            //alert("La fecha de cierre no puede ser menor a la fecha de inicio");
                             document.forms["miformulario"].submit();
                         }
                    </script>
                     
                    <form name="miformulario" action="../../agregarActa2Cargado" method="POST" onsubmit="procesar(this.action);" >
                         <input type="hidden" name="validacionExiste" value="1">
                        <input type="hidden" name="idActa" value="<?php echo $idActa; ?>">
                    </form> 
            <?php 
            //echo '<script language="javascript">alert("La fecha de cierre no puede ser menor a la fecha de inicio");
            //window.location.href="../../agregarActa2"</script>';
           
        }else{
           // echo 'ingresar';
        
                    'a'.$fechainicio;
         '-b'.$fechafin;
        
         
                                        //require '../usuarios/libreria/PHPMailerAutoload.php';

                                        $radioActaTipo;
                                        $arrayEncargado=$_POST['select_encargadoAR2'];
                                        $nombreDocEnviar=$_POST['nombre'];
     

                                        if($radioActaTipo == 'usuario'){ 
                                             'Longitud: '.$longitud = count($arrayEncargado); 
                                            for($i=0; $i<$longitud; $i++){
                                                $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$arrayEncargado[$i]' ");
                                                while($columna = $nombreuser->fetch_array()){
                                                $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                                                //echo $correoResponsable=$columna['correo']; 
                                                //echo '<br>';
                                                
                                                

                                                                    

                                                                    //Create a new PHPMailer instance
                                                                    $mail = new PHPMailer();
                                                                    $mail->IsSMTP();
                                                                    
                                                                    //Configuracion servidor mail
                                                                    require '../../correoEnviar/contenido.php';
                                                                    
                                                                    //Agregar destinatario
                                                                    $mail->isHTML(true);
                                                                    $mail->AddAddress($correoResponsable);
                                                                    $mail->Subject = utf8_decode('Aprobación de acta '); //$nombreDocEnviar
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
                                                                    <p>El acta <b>'.$nombreDocEnviar.'.</b> se encuentra pendiente para su aprobación.</p>
                                                                    Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                                                    <br>
                                                                    <em>Mi perfil --> mis pendientes --> Actas --> Aprobación actas +</em>.
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
                                                                    
                                                                    } else {

                                                                    }
                                                                   
                                                }            
                                            }
                                        }

                                        if($radioActaTipo == 'cargo'){
                                           
                                            'Logitud cargo: '.$longitud = count($arrayEncargado);
                                            for($i=0; $i<$longitud; $i++){ 
                                                $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo='$arrayEncargado[$i]' ");
                                                while($columna = $nombreuser->fetch_array()){
                                                    $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                                                    $correoResponsable=$columna['correo']; 
                                                     '<br>';
                                                    
                                                    //Create a new PHPMailer instance
                                                    $mail = new PHPMailer();
                                                    $mail->IsSMTP();
                                                    
                                                    //Configuracion servidor mail
                                                    require '../../correoEnviar/contenido.php';
                                                    
                                                    //Agregar destinatario
                                                    $mail->isHTML(true);
                                                    $mail->AddAddress($correoResponsable);
                                                    $mail->Subject = utf8_decode('Aprobación de acta '.$nombreDocEnviar);
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
                                                    <p>El acta <b>'.$nombreDocEnviar.'.</b> se encuentra pendiente para su aprobación.</p>
                                                    Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                                    <br>
                                                    <em>Mi perfil --> mis pendientes --> Actas --> Aprobación actas +</em>.
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
                                                    
                                                    } else {

                                                    }
                                                   
                                                    
                                                }
                                            }
                                        }

                    $mysqli->query("INSERT INTO `actas`(
                    `nombreActa`,
                    `proceso`,
                    `ubicacion`,
                    `fechaInicio`,
                    `fechaCierre`,
                    `quienCita`,
                    `quienCitaID`,
                    `quienElabora`,
                    `quienElaboraID`,
                    `aprobacionCompromisos`,
                    `compromisos`,
                    `compromisosID`,
                    `convocado`,
                    `convocadoID`,
                    `asistente`,
                    `asistenteID`,
                    `nombreConvocadoEXT`,
                    `tipoEmpresaCovEXT`,
                    `nombreEmpresa`,
                    `cargoConvocadoEXT`,
                    `publico`,
                    `permisosActa`,
                    `responsablesActa`,
                    `acta`,
                    `aprobarActa`, 
                    `quienAprueba`,
                    `quienApruebaId`,
                    `finalizada`,
                    `usuario`,
                    `estado`,
                    `idEncabezado`,
                    `idEncabezadoPlantilla`
                    
                )
                VALUES(
                '$nombre',
                '$proceso',
                '$ubicacion',
                '$fechainicioActa',
                '$fechaFinActa',
                '$radiobtn',
                '$select',
                '$radiobtn2',
                '$selectElabora',
                '$radiobtn3',
                '$radiobtn31',
                '$selectCompromisos',
                '$radiobtnC',
                '$selectConvocados',
                '$radiobtnAsis',
                '$selectAsis',
                '$jsonConvocado',
                '$jsonTipo',
                '$jsonNombre',
                '$jsonCargo',
                '$radiobtnP',
                '$radiobtnP2',
                '$selectA2',
                '$editor',
                '$radioActaSiNO',
                '$radioActaTipo',
                '$selectActaAprobacion',
                '1',
                '$celdulaUser',
                '$estado',
                '$idEncabezado',
                '$idEncabezadoPlantilla'
                )")or die(mysqli_error($mysqli));
                
                
                
                    
                //echo '<script language="javascript">alert("Exito al cargar el acta");
                //window.location.href="../../actas"</script>';
                    ?>
                        <script> 
                            window.onload=function(){
                        
                                document.forms["miformulario"].submit();
                            }
                        </script>
                        
                        <form name="miformulario" action="../../actas" method="POST" onsubmit="procesar(this.action);" >
                            <input type="hidden" name="validacionAgregar" value="1">
                        </form> 
                    <?php
        }
        
    }
    
        
}


if(isset($_POST['estadoCompromisoB'])){
    $nombreCompromiso=$_POST['nombreCompromiso'];
    $idActa = $_POST['idActa'];
    $idCompromiso = $_POST['idCompromiso'];
    $estado = $_POST['estado'];
    $nombreArchivo = $_FILES['archivo']['name']; 
    $rutaArchivo = $_FILES['archivo']['tmp_name']; 
    $controlCambio = utf8_decode($_POST['controlCambio']);
    
    $radioAprobado = $_POST['radioAprobado'];
    
    if($radioAprobado != NULL){
        $estado = $radioAprobado;
    }else{
        $estado = $_POST['estado'];
    }
    
    
    date_default_timezone_set("America/Bogota");
    $fecha = date("Ymjhis");
    $fechaCompromiso = date("Y:m:j h:i:s");
    
    
    if($controlCambio != NULL){
        $mysqli->query("INSERT INTO controlCambiosCompromisos(idCompromiso, comentario, usuario, fecha, historia) VALUES('$idCompromiso','$controlCambio','$celdulaUser','$fechaCompromiso','".$_POST['estadoComentarioActa']."')");
    }else{
        $mysqli->query("INSERT INTO controlCambiosCompromisos(idCompromiso, comentario, usuario, fecha, historia) VALUES('$idCompromiso','N/A','$celdulaUser','$fechaCompromiso','".$_POST['estadoComentarioActa']."')");
    }
    
    $mysqli->query("UPDATE compromisos SET estado = '$estado' WHERE id = $idCompromiso");
    
    
    /*foreach($_FILES["archivo"]['tmp_name'] as $key => $tmp_name){
        $nombreArchivo = $_FILES['archivo']['name'][$key]; echo "<br>";
        $rutaArchivo = $_FILES['archivo']['tmp_name'][$key]; echo "<br>";
        
        $nombre = $fecha.$nombreArchivo;
        
        if(!file_exists('../../archivos/compromisos/')){
            mkdir('../../archivos/compromisos',0777,true);
        	if(file_exists('../../archivos/compromisos/')){
        		if(move_uploaded_file($rutaArchivo, '../../archivos/compromisos/'.$nombre)){
        		
        		}else{
        			//echo "Archivo no se pudo guardar";
        		}
        	}
        }else{
            
        	if(move_uploaded_file($rutaArchivo, '../../archivos/compromisos/'.$nombre)){
        	    
        	}else{
        		//echo "Archivo no se pudo guardar";
        	}
        }
        
    }
    
    
    */
    ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                     //alert('Compromiso actualizado.');
                 }
            </script>
             
            <form name="miformulario" action="../../seguimientoActasEntrega" method="POST" onsubmit="procesar(this.action);" > 
                <input type="hidden" name="validacionActualizar" value="1">
                <input type="hidden" name="idActa" value="<?php echo $idActa;?>">
                <input type="hidden" name="nombreCompromiso" value="<?php echo $nombreCompromiso;?>">
                <input type="hidden" name="estadoComentarioActa" id="resultado" value="<?php echo $_POST['estadoComentarioActa']; ?>">
            </form> 
    <?php  //
    
    
}


if(isset($_POST['estadoCompromisoC'])){
    $nombreCompromiso=$_POST['nombreCompromiso'];
    $idActa = $_POST['idActa'];
    $idCompromiso = $_POST['idCompromiso'];
    $estado = $_POST['estado'];
    $nombreArchivo = $_FILES['archivo']['name']; 
    $rutaArchivo = $_FILES['archivo']['tmp_name']; 
    $controlCambio = utf8_decode($_POST['controlCambio']);
    
    $radioAprobado = $_POST['radioAprobado'];
    
    if($radioAprobado != NULL){
        $estado = $radioAprobado;
    }else{
        $estado = $_POST['estado'];
    }
    
    
    date_default_timezone_set("America/Bogota");
    $fecha = date("Ymjhis");
    $fechaCompromiso = date("Y:m:j h:i:s");
    
    
    $estadoComentarioActa = $_POST['estadoComentarioActa'];
    if($controlCambio != NULL){
        $mysqli->query("INSERT INTO controlCambiosCompromisos(idCompromiso, comentario, usuario, fecha, historia) VALUES('$idCompromiso','$controlCambio','$celdulaUser','$fechaCompromiso','$estadoComentarioActa')");
    }else{
        $mysqli->query("INSERT INTO controlCambiosCompromisos(idCompromiso, comentario, usuario, fecha, historia) VALUES ('$idCompromiso','N/A','$celdulaUser','$fechaCompromiso','$estadoComentarioActa')");

    }




    /*
    
    if($controlCambio != NULL){
        $mysqli->query("INSERT INTO controlCambiosCompromisos(idCompromiso, comentario, usuario, fecha) VALUES('$idCompromiso','$controlCambio','$celdulaUser','$fechaCompromiso')");
    }
    */
    $mysqli->query("UPDATE compromisos SET estado = '$estado' WHERE id = $idCompromiso");
    
    
    /*foreach($_FILES["archivo"]['tmp_name'] as $key => $tmp_name){
        $nombreArchivo = $_FILES['archivo']['name'][$key]; echo "<br>";
        $rutaArchivo = $_FILES['archivo']['tmp_name'][$key]; echo "<br>";
        
        $nombre = $fecha.$nombreArchivo;
        
        if(!file_exists('../../archivos/compromisos/')){
            mkdir('../../archivos/compromisos',0777,true);
        	if(file_exists('../../archivos/compromisos/')){
        		if(move_uploaded_file($rutaArchivo, '../../archivos/compromisos/'.$nombre)){
        		
        		}else{
        			//echo "Archivo no se pudo guardar";
        		}
        	}
        }else{
            
        	if(move_uploaded_file($rutaArchivo, '../../archivos/compromisos/'.$nombre)){
        	    
        	}else{
        		//echo "Archivo no se pudo guardar";
        	}
        }
        
    }
    
    
    */
    ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                     //alert('Compromiso actualizado.');
                 }
            </script>
             
            <form name="miformulario" action="../../seguimientoActas" method="POST" onsubmit="procesar(this.action);" > 
                <input type="hidden" name="validacionActualizar" value="1">
                <input type="hidden" name="idActa" value="<?php echo $idActa;?>">
                <input type="hidden" name="estadoComentarioActa" value="<?php echo $estadoComentarioActa ?>"> 
                <input type="hidden" name="nombreCompromiso" value="<?php echo $nombreCompromiso;?>">
            </form> 
    <?php  //
    
    
}


if(isset($_POST['estadoCompromiso'])){
    
    $idActa = $_POST['idActa'];
    $idCompromiso = $_POST['idCompromiso'];
    $estado = $_POST['estado'];
    $nombreArchivo = $_FILES['archivo']['name']; 
    $rutaArchivo = $_FILES['archivo']['tmp_name']; 
    $controlCambio = utf8_decode($_POST['controlCambio']);
    
    $radioAprobado = $_POST['radioAprobado'];
    
    if($radioAprobado != NULL){
        $estado = $radioAprobado;
    }else{
        $estado = $_POST['estado'];
    }
    
    
    date_default_timezone_set("America/Bogota");
    $fecha = date("Ymjhis");
    $fechaCompromiso = date("Y:m:j h:i:s");
    
    
    if($controlCambio != NULL){
        $mysqli->query("INSERT INTO controlCambiosCompromisos(idCompromiso, comentario, usuario, fecha) VALUES('$idCompromiso','$controlCambio','$celdulaUser','$fechaCompromiso')");
    }
    
    $mysqli->query("UPDATE compromisos SET estado = '$estado' WHERE id = $idCompromiso");
    
    
    /*foreach($_FILES["archivo"]['tmp_name'] as $key => $tmp_name){
        $nombreArchivo = $_FILES['archivo']['name'][$key]; echo "<br>";
        $rutaArchivo = $_FILES['archivo']['tmp_name'][$key]; echo "<br>";
        
        $nombre = $fecha.$nombreArchivo;
        
        if(!file_exists('../../archivos/compromisos/')){
            mkdir('../../archivos/compromisos',0777,true);
        	if(file_exists('../../archivos/compromisos/')){
        		if(move_uploaded_file($rutaArchivo, '../../archivos/compromisos/'.$nombre)){
        		
        		}else{
        			//echo "Archivo no se pudo guardar";
        		}
        	}
        }else{
            
        	if(move_uploaded_file($rutaArchivo, '../../archivos/compromisos/'.$nombre)){
        	    
        	}else{
        		//echo "Archivo no se pudo guardar";
        	}
        }
        
    }
    
    
    */
    ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                     //alert('Compromiso actualizado.');
                 }
            </script>
             
            <form name="miformulario" action="../../seguimientoActasVista" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionActualizar" value="1"> 
                <input type="hidden" name="idActa" value="<?php echo $idActa;?>">
            </form> 
    <?php  //
    
    
}


if(isset($_POST['editarActa'])){
    $idActa = $_POST['idActa'];
    
            
            
    
    $nombreArchivo =$_FILES['archivo']['name']; 
    $rutaArchivo =$_FILES['archivo']['tmp_name'];
        
        
        
        if($nombreArchivo != NULL){
            $idActa = $_POST['idActa'];
            $consultarRuta=$mysqli->query("SELECT * FROM actas WHERE id='$idActa' ");
            $traerRuta=$consultarRuta->fetch_array(MYSQLI_ASSOC);
            //$eliminarRuta=$traerRuta['rutaArchivo'];
            //var_dump($eliminarRuta);
            unlink('../../archivos/actas/'.$traerRuta['rutaArchivo']);
            
                $fecha = date("Ymjhis");
                $nombreFinal = $fecha.$nombreArchivo;
                
                
                if(!file_exists('../../archivos/actas/')){
                
                	mkdir('../../archivos/actas/',0777,true);
                	if(file_exists('../../archivos/actas/')){
                	    
                		if(move_uploaded_file($rutaArchivo, '../../archivos/actas/'.$nombreFinal)){
                	        //Guarda archivo
                	          //echo "Sii se suibio el archivo";
                		}else{
                			//echo "Archivo no se pudo guardar 1";
                		}
                	}
                	
                }else{
                    
                	if(move_uploaded_file($rutaArchivo, '../../archivos/actas/'.$nombreFinal)){
                        //echo "Sii se suibio el archivo";
                	}else{
                		//echo "Archivo no se pudo guardar 2";
                	}
                }
            
        }
        
    $nombreFinal=utf8_decode($nombreFinal);
    
    
    $nombre = utf8_decode($_POST['nombre']);
    $proceso = $_POST['proceso'];
    $ubicacion = utf8_decode($_POST['ubicacion']);
    $fechainicio = $_POST['fechainicio']; 
    $hora = $_POST['hora']; 
    $minuto = $_POST['minuto']; 
    $fechainicioActa = $fechainicio." ".$hora;
    //$fechainicioActa = $fechainicio." ".$hora.":".$minuto.":00";
    //$fechainicioActa = date('Y/m/j h:i:s', strtotime($fechainicioActa));
    
    $fechafin = $_POST['fechafin'];
    $horafin = $_POST['horafin']; 
    $minutofin = $_POST['minutofin']; 
    $fechaFinActa = $fechafin." ".$horafin;
    //$fechaFinActa = $fechafin." ".$horafin.":".$minutofin.":00";
        

        
    $radiobtn = $_POST['radiobtnE'];//quien cita
    $select = json_encode($_POST['select_encargadoE']);
    $radiobtn2 = $_POST['radiobtn2'];//quien elabora
    $selectElabora = json_encode($_POST['select_encargadoR']);
    $radiobtn3 = $_POST['radiobtn3'];//requiere compromisos
    $radiobtn31 = $_POST['radiobtn31'];//quien compromisos
    $selectCompromisos = json_encode($_POST['select_encargadoAR']);
    $radiobtnC = $_POST['radiobtnC'];//quien convocados
    $selectConvocados = json_encode($_POST['select_encargadoC']);
    $radiobtnAsis = $_POST['rad_Asis'];//quien asiste
    $selectAsis = json_encode($_POST['select_encargadoAsis']);
        
    ///acta requiere arpobacion 
    $radioActaSiNO = $_POST['radiobtnAprueba'];//requiere aprobacion
    $radioActaTipo = $_POST['radiobtnAprueba2'];//quien aprueba
    $selectActaAprobacion = json_encode($_POST['select_encargadoAR']);
    /////////////convocados externos 
    $convocadosEXT = $_POST['convocadosEXT1']; 
    $tipoEmpresaEXT = $_POST['tipoEmpresaEXT1']; 
    $nombreEmpresa = $_POST['nombreEmpresa1']; 
    $cargoEXT = $_POST['cargoEXT1'];
    $convocadosEXT2 =$_POST['convocadosEXT2'];
    $tipoEmpresaEXT2 = $_POST['tipoEmpresaEXT2'];
    $nombreEmpresa2 = $_POST['nombreEmpresa2'];
    $cargoEXT2 = $_POST['cargoEXT2'];
    $convocadosEXT3 =$_POST['convocadosEXT3'];
    $tipoEmpresaEXT3 = $_POST['tipoEmpresaEXT3'];
    $nombreEmpresa3 = $_POST['nombreEmpresa3'];
    $cargoEXT3 = $_POST['cargoEXT3'];
    $convocadosEXT4 =$_POST['convocadosEXT4'];
    $tipoEmpresaEXT4 = $_POST['tipoEmpresaEXT4'];
    $nombreEmpresa4 = $_POST['nombreEmpresa4'];
    $cargoEXT4 = $_POST['cargoEXT4'];
    $convocadosEXT5 =$_POST['convocadosEXT5'];
    $tipoEmpresaEXT5 = $_POST['tipoEmpresaEXT5'];
    $nombreEmpresa5 = $_POST['nombreEmpresa5'];
    $cargoEXT5 = $_POST['cargoEXT5'];
    $convocadosEXT6 =$_POST['convocadosEXT6'];
    $tipoEmpresaEXT6 = $_POST['tipoEmpresaEXT6'];
    $nombreEmpresa6 = $_POST['nombreEmpresa6'];
    $cargoEXT6 = $_POST['cargoEXT6'];
    $convocadosEXT7 =$_POST['convocadosEXT7'];
    $tipoEmpresaEXT7 = $_POST['tipoEmpresaEXT7'];
    $nombreEmpresa7 = $_POST['nombreEmpresa7'];
    $cargoEXT7 = $_POST['cargoEXT7'];
    $convocadosEXT8 =$_POST['convocadosEXT8'];
    $tipoEmpresaEXT8 = $_POST['tipoEmpresaEXT8'];
    $nombreEmpresa8 = $_POST['nombreEmpresa8'];
    $cargoEXT8 = $_POST['cargoEXT8'];
    $convocadosEXT9 =$_POST['convocadosEXT9'];
    $tipoEmpresaEXT9 = $_POST['tipoEmpresaEXT9'];
    $nombreEmpresa9 = $_POST['nombreEmpresa9'];
    $cargoEXT9 = $_POST['cargoEXT9'];
    $convocadosEXT10 =$_POST['convocadosEXT10'];
    $tipoEmpresaEXT10 = $_POST['tipoEmpresaEXT10'];
    $nombreEmpresa10 = $_POST['nombreEmpresa10'];
    $cargoEXT10 = $_POST['cargoEXT10'];

    $jsonConvocado = json_encode($convocadosEXT.','.$convocadosEXT2.','.$convocadosEXT3.','.$convocadosEXT4.','.$convocadosEXT5.','.$convocadosEXT6.','.$convocadosEXT7.','.$convocadosEXT8.','.$convocadosEXT9.','.$convocadosEXT10, JSON_UNESCAPED_UNICODE);
    $jsonConvocado=utf8_decode($jsonConvocado);
    //var_dump($jsonConvocado);
    $jsonTipo = json_encode($tipoEmpresaEXT.','.$tipoEmpresaEXT2.','.$tipoEmpresaEXT3.','.$tipoEmpresaEXT4.','.$tipoEmpresaEXT5.','.$tipoEmpresaEXT6.','.$tipoEmpresaEXT7.','.$tipoEmpresaEXT8.','.$tipoEmpresaEXT9.','.$tipoEmpresaEXT10);
    //var_dump($jsonTipo);
    $jsonNombre = json_encode($nombreEmpresa.','.$nombreEmpresa2.','.$nombreEmpresa3.','.$nombreEmpresa4.','.$nombreEmpresa5.','.$nombreEmpresa6.','.$nombreEmpresa7.','.$nombreEmpresa8.','.$nombreEmpresa9.','.$nombreEmpresa10, JSON_UNESCAPED_UNICODE);
    $jsonNombre=utf8_decode($jsonNombre);
    //var_dump($jsonNombre);
    $jsonCargo = json_encode($cargoEXT.','.$cargoEXT2.','.$cargoEXT3.','.$cargoEXT4.','.$cargoEXT5.','.$cargoEXT6.','.$cargoEXT7.','.$cargoEXT8.','.$cargoEXT9.','.$cargoEXT10, JSON_UNESCAPED_UNICODE);
    $jsonCargo=utf8_decode($jsonCargo);
    //var_dump($jsonCargo);
        
    //////////////////////////////////////
    $radiobtnP = $_POST['radiobtnP'];//acta abierta publico
    $radiobtnP2 = $_POST['radiobtnP2'];//usuario cargo grupo
    $selectA2 = json_encode($_POST['select_encargadoA2']); 
    $editor = utf8_decode($_POST['editor1']);
    
    $acataCargada = $_POST['actaCargada'];
    /*
    if($radioActaSiNO == 'si'){
        $estado='Pendiente';
    }else{
        $estado='Aprobado';
    }*/
    
    $estado = $_POST['estado'];
    
    if($estado == "Rechazado"){
        $estado = "Pendiente";
    }else{
        $estado = $_POST['estado'];
    }
    
    if($fechaFinActa < $fechainicioActa){
        if($acataCargada == 'si'){
                            //// si el acta viene por crear acta pero le dio no generar compromiso y la validacion de fecha aplica nos devuelve a esta otra vista
                            $actaPrecargada=$_POST['precarga'];
                                if($actaPrecargada == 1){
                        ?>
                            <script> 
                                 window.onload=function(){
                                    //alert("La fecha de cierre no puede ser menor a la fecha de inicio del acta");
                                     document.forms["miformulario"].submit();
                                     
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../cargarActaCargado" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionExiste" value="1">
                                <input type="hidden" name="idActa" value="<?php echo $idActa;?>">
                            </form> 
                        <?php
                                }else{
                        ?>
                            <script> 
                                 window.onload=function(){
                                    //alert("La fecha de cierre no puede ser menor a la fecha de inicio del acta");
                                     document.forms["miformulario"].submit();
                                     
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../editarActaC" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionExiste" value="1">
                                <input type="hidden" name="idActa" value="<?php echo $idActa;?>">
                            </form> 
                        <?php
                                } //// END si el acta viene por crear acta pero le dio no generar compromiso y la validacion de fecha aplica nos devuelve a esta otra vista 
                        
                    }else{
                        
                        //// si el acta viene por crear acta pero le dio no generar compromiso y la validacion de fecha aplica nos devuelve a esta otra vista
                                $actaPrecargada=$_POST['precarga'];
                                if($actaPrecargada == 1){
                                ?>
                                            <script> 
                                                 window.onload=function(){
                                               
                                                     document.forms["miformulario"].submit();
                                                     //alert("La fecha de cierre no puede ser menor a la fecha de inicio del acta");
                                                 }
                                            </script>
                                             
                                            <form name="miformulario" action="../../agregarActa2Cargado" method="POST" onsubmit="procesar(this.action);" >
                                                <input type="hidden" name="validacionExiste" value="1">
                                                <input type="hidden" name="idActa" value="<?php echo $idActa;?>">
                                            </form> 
                                <?php
                                }else{
                            ?>
                                        <script> 
                                             window.onload=function(){
                                           
                                                 document.forms["miformulario"].submit();
                                                 //alert("La fecha de cierre no puede ser menor a la fecha de inicio del acta");
                                             }
                                        </script>
                                         
                                        <form name="miformulario" action="../../editarActa" method="POST" onsubmit="procesar(this.action);" >
                                            <input type="hidden" name="validacionExiste" value="1">
                                            <input type="hidden" name="idActa" value="<?php echo $idActa;?>">
                                        </form> 
                            <?php 
                            } //// finaliza  si el acta viene por crear acta pero le dio no generar compromiso y la validacion de fecha aplica nos devuelve a esta otra vista
                    }
    }else{
                        if($nombreFinal != NULL){
                        $mysqli->query("UPDATE 
                        actas
                        SET
                        nombreActa = '$nombre',
                        proceso = '$proceso',
                        ubicacion = '$ubicacion',
                        fechaInicio = '$fechainicioActa',
                        fechaCierre = '$fechaFinActa',
                        quienCita = '$radiobtn',
                        quienCitaID = '$select',
                        quienElabora = '$radiobtn2',
                        quienElaboraID = '$selectElabora',
                        aprobacionCompromisos = '$radiobtn3',
                        compromisos = '$radiobtn31',
                        compromisosID = '$selectCompromisos',
                        convocado = '$radiobtnC',
                        convocadoID = '$selectConvocados',
                        asistente = '$radiobtnAsis',
                        asistenteID = '$selectAsis',
                        nombreConvocadoEXT = '$jsonConvocado',
                        tipoEmpresaCovEXT = '$jsonTipo',
                        nombreEmpresa = '$jsonNombre',
                        cargoConvocadoEXT = '$jsonCargo',
                        publico = '$radiobtnP',
                        permisosActa = '$radiobtnP2',
                        responsablesActa = '$selectA2',
                        acta = '$editor',
                        aprobarActa = '$radioActaSiNO', 
                        quienAprueba = '$radioActaTipo',
                        quienApruebaId = '$selectActaAprobacion',
                        notificacionAct='1',
                        estado = '$estado',
                        rutaArchivo='$nombreFinal'
                        WHERE id = '$idActa'
                    ")or die(mysqli_error($mysqli));
                        } else{
                            $mysqli->query("UPDATE 
                        actas
                        SET
                        nombreActa = '$nombre',
                        proceso = '$proceso',
                        ubicacion = '$ubicacion',
                        fechaInicio = '$fechainicioActa',
                        fechaCierre = '$fechaFinActa',
                        quienCita = '$radiobtn',
                        quienCitaID = '$select',
                        quienElabora = '$radiobtn2',
                        quienElaboraID = '$selectElabora',
                        aprobacionCompromisos = '$radiobtn3',
                        compromisos = '$radiobtn31',
                        compromisosID = '$selectCompromisos',
                        convocado = '$radiobtnC',
                        convocadoID = '$selectConvocados',
                        asistente = '$radiobtnAsis',
                        asistenteID = '$selectAsis',
                        nombreConvocadoEXT = '$jsonConvocado',
                        tipoEmpresaCovEXT = '$jsonTipo',
                        nombreEmpresa = '$jsonNombre',
                        cargoConvocadoEXT = '$jsonCargo',
                        publico = '$radiobtnP',
                        permisosActa = '$radiobtnP2',
                        responsablesActa = '$selectA2',
                        acta = '$editor',
                        aprobarActa = '$radioActaSiNO', 
                        quienAprueba = '$radioActaTipo',
                        quienApruebaId = '$selectActaAprobacion',
                        notificacionAct='1',
                        estado = '$estado'
                        WHERE id = '$idActa'
                    ")or die(mysqli_error($mysqli));
                        }
                    
                        require '../usuarios/libreria/PHPMailerAutoload.php';

                        $radiobtn2;
                       $arrayEncargado=$_POST['select_encargadoAR'];
                       $nombreDocEnviar=$_POST['nombre'];
                    
         
                                                       if($radiobtn2 == 'usuario'){ 
                                                           $longitud = count($arrayEncargado); 
                                                           for($i=0; $i<$longitud; $i++){
                                                               $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$arrayEncargado[$i]' ");
                                                               $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                               $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                                                                $correoResponsable=$columna['correo']; 
                                                                '<br>';
                                                               
                                                               
       
                                                                                   
       
                                                                                   //Create a new PHPMailer instance
                                                                                   $mail = new PHPMailer();
                                                                                   $mail->IsSMTP();
                                                                                   
                                                                                   //Configuracion servidor mail
                                                                                   require '../../correoEnviar/contenido.php';
                                                                                   
                                                                                   //Agregar destinatario
                                                                                   $mail->isHTML(true);
                                                                                   $mail->AddAddress($correoResponsable);
                                                                                   $mail->Subject = utf8_decode('Aprobación de acta '.$nombreDocEnviar);
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
                                                                                   <p>El acta <b>'.$nombreDocEnviar.'.</b> se encuentra pendiente para su aprobación.</p>
                                                                                   Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                                                                   <br>
                                                                                   <em>Mi perfil --> mis pendientes --> Actas --> Aprobación actas +</em>.
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
                                                                                   
                                                                                   } else {
       
                                                                                   }
                                                                                  
                                                                                   
                                                           }
                                                       }
       
                                                       if($radiobtn2 == 'cargo'){
                                                          
                                                           $longitud = count($arrayEncargado);
                                                           for($i=0; $i<$longitud; $i++){ 
                                                               $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo='$arrayEncargado[$i]' ");
                                                               while($columna = $nombreuser->fetch_array()){
                                                                   $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                                                                    $correoResponsable=$columna['correo']; 
                                                                    '<br>';
                                                                   
                                                                   //Create a new PHPMailer instance
                                                                   $mail = new PHPMailer();
                                                                   $mail->IsSMTP();
                                                                   
                                                                   //Configuracion servidor mail
                                                                   require '../../correoEnviar/contenido.php';
                                                                   
                                                                   //Agregar destinatario
                                                                   $mail->isHTML(true);
                                                                   $mail->AddAddress($correoResponsable);
                                                                   $mail->Subject = utf8_decode('Aprobación de acta '.$nombreDocEnviar);
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
                                                                   <p>El acta <b>'.$nombreDocEnviar.'.</b> se encuentra pendiente para su aprobación.</p>
                                                                   Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                                                   <br>
                                                                   <em>Mi perfil --> mis pendientes --> Actas --> Aprobación actas +</em>.
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
                                                                   
                                                                   } else {
       
                                                                   }
                                                                  
                                                                   
                                                               }
                                                           }
                                                       }        
                    if($acataCargada == 'si'){
                       
                        ?>
                            <script> 
                                 window.onload=function(){
                                    //alert("Acta actualizada.");
                                     document.forms["miformulario"].submit();
                                     
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../editarActaC" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionActualizar" value="1">
                                <input type="hidden" name="idActa" value="<?php echo $idActa;?>">
                            </form> 
                        <?php
                                
                    }else{
                        ?>
                            <script> 
                                 window.onload=function(){
                                    //alert("Acta actualizada.");
                                     document.forms["miformulario"].submit();
                                     
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../editarActa" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionActualizar" value="1">
                                <input type="hidden" name="idActa" value="<?php echo $idActa;?>">
                            </form> 
                        <?php
                    }
    }
    
    
   
    
    
    
}


if(isset($_POST['eliminarActa'])){
    
    $idActa = $_POST['idActa'];
    
            $consultarRuta=$mysqli->query("SELECT * FROM actas WHERE id='$idActa' ");
            $traerRuta=$consultarRuta->fetch_array(MYSQLI_ASSOC);
            //$eliminarRuta=$traerRuta['rutaArchivo'];
            unlink('../../archivos/actas/'.$traerRuta['rutaArchivo']);
            
    
    $consultaCompromisoIndividual=$mysqli->query("SELECT * FROM compromisos WHERE idActa='$idActa' ");
    while($traerIdCompromiso=$consultaCompromisoIndividual->fetch_array()){
        $enviarIDCompromiso=$traerIdCompromiso['id'];
        $mysqli->query("DELETE FROM compromisosIndividuales WHERE id_compromiso = $enviarIDCompromiso");
        $mysqli->query("DELETE FROM controlCambiosCompromisos WHERE idCompromiso = $enviarIDCompromiso");
    }
    
    $mysqli->query("DELETE FROM compromisos WHERE idActa = $idActa");
    $mysqli->query("DELETE FROM actas WHERE id = $idActa");
    
    //echo '<script language="javascript">alert("Acta eliminada");
    //window.location.href="../../actas"</script>';
    ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../actas" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminar" value="1">
            </form> 
        <?php
    
}

if(isset($_POST['estadoActa'])){
    
    $idActa = $_POST['idActa'];echo "<br>";
    $estado = $_POST['estado'];echo "<br>";
    $comentarioACTA = utf8_decode($_POST['comentarioACTA']);
   
    $mysqli->query("UPDATE actas SET estado = '$estado', comentario = '$comentarioACTA', notificacionAct='0' WHERE id = $idActa");
    

    if($estado == 'Aprobado'){
        "<br>";
        $sacamosActa=$mysqli->query("SELECT * FROM actas WHERE id='$idActa' ");
        $exatrerActas=$sacamosActa->fetch_array(MYSQLI_ASSOC);
         'ID Acta: '.$actaID=$exatrerActas['id'];
        
        require '../usuarios/libreria/PHPMailerAutoload.php';
        $consultandoComprimisos=$mysqli->query("SELECT * FROM `compromisos` WHERE idActa= '$actaID' ");
        //$sacarCompromisosAprobado=$consultandoComprimisos->fetch_array(MYSQLI_ASSOC);
        while($sacarCompromisosAprobado=$consultandoComprimisos->fetch_array()){
        
             '--ID: compromiso: '.$idCompromisoConsultar=$sacarCompromisosAprobado['id'];
             '-'.$nombreDocEnviar=utf8_encode($sacarCompromisosAprobado['compromiso']);
             
            if($idCompromisoConsultar != NULL){
                
                
                
                
                $recorriendoResponsablesAprobado=$mysqli->query("SELECT * FROM compromisosIndividuales WHERE id_compromiso='$idCompromisoConsultar' ");
                while($extraerRecorriendoResponsablesAprobado=$recorriendoResponsablesAprobado->fetch_array()){
                     'Tipo: '.$rad_Res=$extraerRecorriendoResponsablesAprobado['responsable'];  '<br>';
                     'ID responsable: '.$arrayEncargado=$extraerRecorriendoResponsablesAprobado['id_responsable'];  '<br>';
                    
                    
        
                     if($rad_Res == 'usuario'){ 
                         
                            $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id ='$arrayEncargado' ");
                            $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                             $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                             $correoResponsable=$columna['correo']; 
                            
                                 //Create a new PHPMailer instance
                                 $mail = new PHPMailer();
                                 $mail->IsSMTP();
                                 
                                 //Configuracion servidor mail
                                 require '../../correoEnviar/contenido.php';
                                 
                              //Agregar destinatario
                                 $mail->isHTML(true);
                                 $mail->AddAddress($correoResponsable);
                                 $mail->Subject = utf8_decode('Encargado para gestionar el compromiso'); //Gestión de compromiso$nombreDocEnviar
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
                                 <p>El compromiso <b>'.$nombreDocEnviar.'.</b> está disponible para su gestión.</p>
                                 Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                 <br>
                                 <em>Mi perfil --> mis pendientes --> Actas --> Gestión de compromisos +</em>.
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
              
                     if($rad_Res == 'cargo'){
                        
                          
                             $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo='$arrayEncargado' ");
                             while($columna = $nombreuser->fetch_array()){
                                  'Nombre: '.$nombreResponsable=$columna['nombres'].' '.$columna['apellidos']; 
                                  '--Correo: '.$correoResponsable=$columna['correo']; 
                                  '<br>';
                                 
                                 //Create a new PHPMailer instance
                                 $mail = new PHPMailer();
                                 $mail->IsSMTP();
                                 
                                 //Configuracion servidor mail
                                 require '../../correoEnviar/contenido.php';
                                 
                                 //Agregar destinatario
                                 $mail->isHTML(true);
                                 $mail->AddAddress($correoResponsable);
                                 $mail->Subject = utf8_decode('Encargado para gestionar el compromiso'); //Gestión de compromiso '.$nombreDocEnviar
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
                                 <p>El compromiso <b>'.$nombreDocEnviar.'.</b> está disponible para su gestión.</p>
                                 Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                 <br>
                                 <em>Mi perfil --> mis pendientes --> Actas --> Gestión de compromisos +</em>.
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
                                  //echo 'Enviado';
                                 } else {
              
                                 }
                                
                                 
                             }
                         
                     }
                }
            }
        
        }
       
    }
        ?>
            <script> 
                 window.onload=function(){
                    //alert("Estado actualizado.");
                     document.forms["miformulario"].submit();
                     
                 }
            </script>
             
            <form name="miformulario" action="../../actas" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionActualizar" value="1">
                <input type="hidden" name="idActa" value="<?php echo $idActa;?>">
            </form> 
    <?php 
    
    
 
}


?>