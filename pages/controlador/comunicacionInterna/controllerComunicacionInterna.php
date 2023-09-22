<?php
//////// traemos la bd
require_once '../../conexion/bd.php';
error_reporting(E_ERROR);
////////// validamos el ingreso por el name del  boton del formulario

if(isset($_POST['AddcomunicacionInternaVer'])){
    $comentario = utf8_decode($_POST['comentarioVer']);
    $idUsuario = $_POST['idUsuarioCV'];
    $recibe= $_POST['enviar'];
    date_default_timezone_set('America/Bogota');$fecha1=date('Y-m-j h:i:s A');	
        $mysqli->query("INSERT INTO comunicacionInternaVer (idUsuario,comentario,fecha,idComunicacionInterna) 
        VALUES('$idUsuario','$comentario','$fecha1','$recibe' ) ")or die(mysqli_error($mysqli));
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../myperfilVer" method="GET" onsubmit="procesar(this.action);" >
                <input type="hidden" name="enviar" value="<?php echo $recibe; ?>">
            </form> 
        <?php 



}elseif(isset($_POST['AddcomunicacionInterna'])){

    
    $archivo = Addslashes(file_get_contents($_FILES['archivo']['tmp_name'])); 
    $comentario = utf8_decode($_POST['comentario']);
    $idUsuario = $_POST['idUsuario'];
    date_default_timezone_set('America/Bogota');$fecha1=date('Y-m-j h:i:s A');
        $mysqli->query("INSERT INTO comunicacionInterna (idUsuario,comentario,archivo,fecha) 
        VALUES('$idUsuario','$comentario','$archivo','$fecha1' ) ")or die(mysqli_error($mysqli));
        //echo '<script language="javascript">
        //window.location.href="../../myperfil"</script>';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../myperfil" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionAgregar" value="1">
            </form> 
        <?php
    
  /////////////// End validamos el nombre que entra al nombre de la consulta
 
    
}elseif(isset($_GET['eliminar'])){

    
    echo '--'.$idEliminar =$_GET['ideliminar']; 
    
        ////// elimina de la tabla camnicacion interna
        $mysqli->query("DELETE from comunicacionInterna  WHERE id= '$idEliminar'")or die(mysqli_error($mysqli));
        
        //////// elimina de la tabla de comunicacion interna ver
        $mysqli->query("DELETE from comunicacionInternaVer  WHERE idComunicacionInterna = '$idEliminar'")or die(mysqli_error($mysqli));
        
        
        //echo '<script language="javascript">
        //window.location.href="../../myperfil"</script>';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../myperfil" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminar" value="1">
            </form> 
        <?php
    
  /////////////// End validamos el nombre que entra al nombre de la consulta
 
    
}elseif(isset($_POST['chat'])){


   $de=$_POST['de'];
   $para=$_POST['para'];
   $mensaje=$_POST['mensaje'];
   
    date_default_timezone_set('America/Bogota');
    $fecha=date('Y-m-j h:i:s A');
    
    
        $mysqli->query("INSERT INTO chat (de,para,mensaje,fecha,estado)VALUES('$de','$para','$mensaje','$fecha','Nuevo') ")or die(mysqli_error($mysqli));
        
     ?>
           <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../chat" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="idIniciarChat" value="<?php echo $para; ?>">
            </form> 
        <?php
    
  /////////////// End validamos el nombre que entra al nombre de la consulta
 
    
}elseif(isset($_POST['chatEstado'])){

    $idIniciarChat=$_POST['idIniciarChat'];
   
    
        $mysqli->query("UPDATE chat set estado='leido' WHERE de='$idIniciarChat' ")or die(mysqli_error($mysqli));
        
     ?>
           <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../chat" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="idIniciarChat" value="<?php echo $idIniciarChat; ?>">
            </form> 
        <?php
    
  /////////////// End validamos el nombre que entra al nombre de la consulta
 
    
}elseif(isset($_POST['agenda'])){

    
    
    $fecha=$_POST['fecha'];
    $hora=$_POST['hora'];
    $sitio=utf8_decode($_POST['sitio']);
    
    $tematica=utf8_decode($_POST['tematica']);
    $descripcion=utf8_decode($_POST['descripcion']);
    $color=$_POST['color'];
    $asunto=$_POST['asunto'];
    $idUsuario=$_POST['idUsuario'];
    $radiobtn = $_POST['radiobtn'];//quien cita
    $select = json_encode($_POST['select_encargadoE']);
    
    if($asunto == 'Crear reunion'){
    $enviarAsunto='Notificación reunión';
    $descripcionEnviar='<br>Tiene una notificación correspondiente a una reunión <br><br>Temática: '.utf8_encode($tematica).'
    <br>Descripción '.utf8_encode($descripcion).'
    <br>Fecha '.$fecha.' <br>Hora '.$hora.' <br>Lugar '.utf8_encode($sitio).'
    ';
    }
    if($asunto == 'Crear tarea'){
    $enviarAsunto='Notificación tarea';
    $descripcionEnviar='<br>Tiene una notificación correspondiente a una tarea <br><br> Temática: '.utf8_encode($tematica).'
    <br>Descripción '.utf8_encode($descripcion).'
    <br>Fecha '.$fecha.' <br>Hora '.$hora.' <br>Lugar '.utf8_encode($sitio).'
    ';
    }
    
    $selectEnviar=json_decode($select);
    $longitud = count($selectEnviar);
                                
                require '../usuarios/libreria/PHPMailerAutoload.php';
                if($radiobtn == 'usuario'){
                                 
                                for($i=0; $i<$longitud; $i++){  
                                 '<br>';
                                
                                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$selectEnviar[$i]' ");
                                    while($columna = $nombreuser->fetch_array()){
                                     $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                                     '<br>'.$correoResponsable=$columna['correo']; 
                                     '<br>';
                                      
                                    
            
                                                        
            
                                                        //Create a new PHPMailer instance
                                                        $mail = new PHPMailer();
                                                        $mail->IsSMTP();
                                                        
                                                        //Configuracion servidor mail
                                                        require '../../correoEnviar/contenido.php';
                                                        
                                                        //Agregar destinatario
                                                        $mail->isHTML(true);
                                                        $mail->AddAddress($correoResponsable);
                                                        $mail->Subject = utf8_decode($enviarAsunto);
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
                                                        <p>'.$descripcionEnviar.'</p>
                                                        Se recomienda ingresar al sistema y visualizar la actividad encargada.
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

                if($radiobtn == 'cargo'){
                     'Cargos';
                    //$longitud = count($select); 
                    for($i=0; $i<$longitud; $i++){
                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo = '$selectEnviar[$i]' ");
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
                            $mail->Subject = utf8_decode($enviarAsunto);
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
                            <p>'.$descripcionEnviar.'</p>
                            Se recomienda ingresar al sistema y visualizar la actividad encargada.
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
        $mysqli->query("INSERT INTO agenda (fecha,hora,tipoPersonal,personal,tematica,asunto,descripcion,sitio,color,idUsuario)VALUES('$fecha','$hora','$radiobtn','$select','$tematica','$asunto','$descripcion','$sitio','$color','$idUsuario' ) ")or die(mysqli_error($mysqli));
        
     ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../myperfil" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionAgregar" value="1">
            </form> 
        <?php
    
  /////////////// End validamos el nombre que entra al nombre de la consulta
 
    
}elseif(isset($_POST['agendaEtiqueta'])){

    
    
    $nombre=$_POST['nombre'];
    $etiqueta=$_POST['etiqueta'];
    $titulo=$_POST['titulo'];
    $subtitulo=$_POST['subtitulo'];
    $idUsuario=$_POST['idUsuario'];
    
                            $query = $mysqli->query("SELECT * FROM agendaEtiqueta WHERE nombre='$nombre' AND idUsuario='$idUsuario' ");
                            $row = $query->fetch_array(MYSQLI_ASSOC);
                            $nombreSale= $row['nombre'];
                            $idSale= $row['idUsuario'];
                            
    if($nombre == $nombreSale && $idUsuario == $idSale){
        //echo '<script language="javascript">alert("Los colores ya fueron asignados a la etiqueta");
        //window.location.href="../../myperfil"</script>';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../myperfil" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExisteB" value="1">
            </form> 
        <?php
    }else{
    
        $mysqli->query("INSERT INTO agendaEtiqueta (nombre,etiqueta,titulo,subtitulo,idUsuario)VALUES('$nombre','$etiqueta','$titulo','$subtitulo','$idUsuario' ) ")or die(mysqli_error($mysqli));
        //echo '<script language="javascript">
        //window.location.href="../../myperfil"</script>';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../myperfil" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionAgregar" value="1">
            </form> 
        <?php
    }
 
    
}elseif(isset($_POST['agendaEtiquetaEliminar'])){

    $id=$_POST['eliminarEtiqueta'];
    
        $mysqli->query("DELETE  FROM agendaEtiqueta WHERE id='$id' ")or die(mysqli_error($mysqli));
        //echo '<script language="javascript">
        //window.location.href="../../myperfil"</script>';
     ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../myperfil" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminar" value="1">
            </form> 
        <?php
 
    
}elseif(isset($_POST['cambiarEstado'])){

    $estadoC=$_POST['myRadios'];
    $usuario=$_POST['usuario'];
    
    $consultaExitente=$mysqli->query("SELECT * FROM ConectadoUsuario WHERE idUsuario='$usuario'  ");
    $confirmar=$consultaExitente->fetch_array(MYSQLI_ASSOC);
    $confirmaCCUsuario=$confirmar['idUsuario'];
    
    if($confirmaCCUsuario == $usuario){
        $mysqli->query("UPDATE ConectadoUsuario SET estadoUsuario='$estadoC' WHERE idUsuario='$usuario' ")or die(mysqli_error($mysqli));
        echo '<script language="javascript">
        window.location.href="../../myperfil"</script>';
    }else{
        $mysqli->query("INSERT INTO ConectadoUsuario  (estadoUsuario,idUsuario)VALUES('$estadoC','$usuario') ")or die(mysqli_error($mysqli));
        echo '<script language="javascript">
        window.location.href="../../myperfil"</script>'; 
    } 
 
    
}

if(isset($_POST['seleccionAgenda'])){
    
                                        $opcion=$_POST['solicitud'];
                                       
                                    ?>
                                             <script> 
                                                 window.onload=function(){
                                               
                                                     document.forms["miformulario"].submit();
                                                 }
                                            </script>
                                             
                                            <form name="miformulario" action="../../agenda" method="POST" onsubmit="procesar(this.action);" >
                                                <input type="hidden" name="solicitud" value="<?php echo $opcion; ?>">
                                            </form> 
                                    <?php
}
if(isset($_GET['eliminarAgenda'])){
    
        $eliminarAgenda=$_GET['eliminarAgenda'];           
                                       
        $mysqli->query("DELETE  FROM agenda WHERE id='$eliminarAgenda' ")or die(mysqli_error($mysqli));
      
      ?>
                                             <script> 
                                                 window.onload=function(){
                                               
                                                     document.forms["miformulario"].submit();
                                                 }
                                            </script>
                                             
                                            <form name="miformulario" action="../../agenda" method="POST" onsubmit="procesar(this.action);" >
                                                <input type="hidden" name="solicitud" value="Reuniones programadas">
                                                <input type="hidden" name="validacionEliminar" value="1">
                                            </form> 
                                    <?php
}

if(isset($_POST['publicidadActiva'])){
    $radiobtnP2 = $_POST['radiobtnP2'];//usuario, cargo, grupo.
    $selectA2 = json_encode($_POST['select_encargadoA2']);
    $mysqli->query("INSERT INTO `comunicaciones`(`tipo`,`activos`)VALUES('$radiobtnP2','$selectA2')")or die(mysqli_error($mysqli));
    ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../comunicaciones" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionAgregar" value="1">
            </form> 
        <?php
    
}
if(isset($_POST['publicidadActivaEditar'])){
    $id = $_POST['id'];
    $radiobtnP2 = $_POST['radiobtnP2'];//usuario, cargo, grupo.
    $selectA2 = json_encode($_POST['select_encargadoA2']);
    $mysqli->query("UPDATE `comunicaciones` SET `tipo`='$radiobtnP2',`activos`='$selectA2' WHERE id='$id' ")or die(mysqli_error($mysqli));
    ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../comunicaciones" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionActualizar" value="1">
            </form> 
        <?php
    
}
if(isset($_POST['publicidadActivaEliminar'])){
    $id = $_POST['id'];
    
    $mysqli->query("DELETE FROM  `comunicaciones` WHERE id='$id' ")or die(mysqli_error($mysqli));
    ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../comunicaciones" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminar" value="1">
            </form> 
        <?php
    
}
?>