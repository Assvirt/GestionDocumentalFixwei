<?php
//Controller ACTAS
//////// traemos la bd
error_reporting(E_ERROR);
require_once '../../conexion/bd.php';
date_default_timezone_set('America/Bogota');

session_start();
$celdulaUser = $_SESSION['session_username']; 
$cargoID = $_SESSION['session_cargo']; 
$idUsuario = $_SESSION['session_idUsuario'];



//Crear subCarpeta
if(isset($_POST['crearSubCarpeta'])){
    
    
    $ruta = $_POST['rutaCarpeta']; 
    $nombreSubCarperta = $_POST['nombreCarpeta']; 
    $nombre_fichero = "../../".$ruta.$nombreSubCarperta;
    $radiobtnARs = $_POST['radiobtnAut'];
    $encargadoVer = json_encode($_POST['select_encargadoAut']);
    $usuario = $_POST["usuario"];
    $fechaCreacion = date("Y/m/j h:i:s");
    //var_dump($encargadoVer);
 ///var_dump($radiobtnARs);  
    if($encargadoVer == 'null'){
        ?>
            <script> 
                 window.onload=function(){
                    
                    //alert("Error, Asegurese de asignar usuarios para visualización");
                    document.forms["miformulario"].submit();
                     
                 }
            </script>
             
            <form name="miformulario" action="../../repositorio" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExiste" value="1">
                <!-- Carpeta creada-->
                <input type="hidden" name="verCarpetaCreada" value="<?PHP echo $ruta;?>">
            </form> 
        <?php 
    }else{
    
     // funcion para quitar espacios
        function Quitar_Espacios($nombre_fichero)
        {
            $array = explode(' ',$nombre_fichero);  // convierte en array separa por espacios;
            $nombre_fichero ='';
            // quita los campos vacios y pone un solo espacio
            for ($i=0; $i < count($array); $i++) { 
                if(strlen($array[$i])>0) {
                    $nombre_fichero.= ' ' . $array[$i];
                }
            }
          return  trim($nombre_fichero);
        }
        /// END
       
        $nombre_fichero = Quitar_Espacios($nombre_fichero);
        
    if(file_exists($nombre_fichero)){
        ?>
            <script> 
                 window.onload=function(){
                    
                    //alert("La carpeta ya existe");
                    document.forms["miformulario"].submit();
                     
                 }
            </script>
             
            <form name="miformulario" action="../../repositorio" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExisteB" value="1">
                <!-- Carpeta creada-->
                <input type="hidden" name="verCarpetaCreada" value="<?PHP echo $ruta;?>">
            </form> 
        <?php 
    }else{
        $rutaCarpeta = "../../".$ruta.$nombreSubCarperta;
        $nombreSubCarperta = utf8_decode($nombreSubCarperta);
        $nombre_fichero = utf8_decode($nombre_fichero);
        $mysqli->query("INSERT INTO repositorioCarpeta (nombre, ruta,
                                                         visualizar, visualizarID, fechaCreacion, usuario) VALUES 
                                                            ('$nombreSubCarperta',
                                                            '$nombre_fichero',
                                                            '$radiobtnARs',
                                                            '$encargadoVer','$fechaCreacion','$usuario')")or die(mysqli_error($mysqli));
        
        
    
        if(!mkdir($rutaCarpeta, 0777, true)) {
            ?>
                <script> 
                     window.onload=function(){
                   
                         document.forms["miformulario"].submit();
                         //alert("Fallo al crear las carpeta!");
                     }
                </script>
                 
                <form name="miformulario" action="../../repositorio" method="POST" onsubmit="procesar(this.action);" >
                    <input type="hidden" name="validacionExisteC" value="1">
                    <!-- Carpeta creada-->
                    <input type="hidden" name="verCarpetaCreada" value="<?PHP echo $ruta;?>">
                </form> 
            <?php 
        }else{
           ?>
                <script> 
                     window.onload=function(){
                        
                        //alert("Carpeta creada!");
                        document.forms["miformulario"].submit();
                         
                     }
                </script>
                 
                <form name="miformulario" action="../../repositorio" method="POST" onsubmit="procesar(this.action);" >
                    <input type="hidden" name="validacionAgregar" value="1">
                    <!-- Carpeta creada-->
                    <input type="hidden" name="verCarpetaCreada" value="<?PHP echo $ruta;?>">
                </form> 
            <?php
        }
    } 
    
    
   
    }  
    
}

function deleteDirectory($dir) {
    if(!$dh = @opendir($dir)) return;
    while (false !== ($current = readdir($dh))) {
        if($current != '.' && $current != '..') {
            //echo 'Se ha borrado el archivo '.$dir.'/'.$current.'<br/>';
            if (!@unlink($dir.'/'.$current)) 
                deleteDirectory($dir.'/'.$current);
        }       
    }
    closedir($dh);
    //echo 'Se ha borrado el directorio '.$dir.'<br/>';
    @rmdir($dir);
    
    
  
    
}

function deletefile($archivo){
    
    unlink($archivo);
    //echo 'Se ha borrado el archivo '.$archivo.'<br/>';
    
}



//Eliminar carpeta o achivos
if(isset($_POST['EliminarCarpeta'])){
    
    $ruta = $_POST['rutaEliminar'];
    $file = $_POST["nombre"];
    if($file == null){
            
            
            //echo '<script language="javascript">alert("Para Eliminar elija un archivo o carpeta");
            //window.location.href="../../repositorio.php"</script>';
            ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../repositorio" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExisteD" value="1">
                <input type="hidden" name="verCarpetaCreada" value="<?PHP echo $ruta;?>">
            </form> 
            <?php
        }else{


     //////////////// ARCHIVOS
                                            
    $varArchivo =$file;
    $explorando=explode(".",$varArchivo);
    $enviarSinExtension= $explorando[0];
    $enviarConExtension= $explorando[1];

    
    
    //var_dump($enviarConExtension);
    if($enviarConExtension){
        
        $trearData = $mysqli->query("SELECT * FROM repositorioRegistro WHERE nombre ='$enviarSinExtension' AND extension='$enviarConExtension' AND ruta='$ruta'  ");
        $datos = $trearData->fetch_array(MYSQLI_ASSOC);
        $id  = $datos["id"];
        
        $archivo = "../../".$ruta.$file;
        
        //echo "este es el id de ese archivo".$id;
        $mysqli->query("DELETE FROM repositorioRegistro WHERE id = '$id'");
        $mysqli->query("DELETE FROM repositorioCarpetaSolicitud WHERE idRepositorio = '$id'");
        //echo "el archivo es : ".$archivo;
        deletefile($archivo);
        
        ?>
                <script> 
                     window.onload=function(){
                   
                         //alert("Archivo Eliminado");
                         document.forms["miformulario"].submit();
                     }
                </script>
                 
                <form name="miformulario" action="../../repositorio" method="POST" onsubmit="procesar(this.action);" >
                    <input type="hidden" name="validacionEliminar" value="1">
                    <input type="hidden" name="verCarpetaCreada" value="<?PHP echo $ruta;?>">
                    <!-- Carpeta creada-->
                    
                </form> 
    <?php
        
    }else{
        $dir = "../../".$ruta.$file;
        $traeId = $mysqli->query("SELECT * FROM repositorioCarpeta WHERE nombre = '$file' and ruta = '$dir'");
        $datos = $traeId->fetch_array(MYSQLI_ASSOC);
        $id  = $datos["id"];
        //echo "este es el id carpeta".$id;
        $mysqli->query("DELETE FROM repositorioCarpeta WHERE id = '$id'");
        $mysqli->query("DELETE FROM repositorioCarpetaSolicitud WHERE idRepositorio = '$id'");
        
        $dir = $dir."/";
        deleteDirectory($dir);
        
        ?>
                <script> 
                     window.onload=function(){
                   
                         //alert("Directorio Eliminado");
                         document.forms["miformulario"].submit();
                     }
                </script>
                 
                <form name="miformulario" action="../../repositorio" method="POST" onsubmit="procesar(this.action);" >
                    <input type="hidden" name="validacionEliminarB" value="1">
                    <input type="hidden" name="verCarpetaCreada" value="<?PHP echo $ruta;?>">
                    <!-- Carpeta creada-->
                    
                </form> 
    <?php
        
    }
                 
        
    
    
    
    deleteDirectory($dir);
    
        }
}


//Editar carpeta
if(isset($_POST['editarCarpeta'])){
    
    $ruta = $_POST['ruta'];
    $nombreAntes = $_POST['nombre']; 
    $nombreNuevo = $_POST['nombreCarpeta'];
    $radiobtnARs = $_POST['radiobtnAut'];
    $encargadoVer = json_encode($_POST['select_encargadoAut']);
    
    
   
    if($encargadoVer == 'null'){
        ?>
            <script> 
                 window.onload=function(){
                    
                    //alert("Error, Asegurese de asignar usuarios para visualización");
                    document.forms["miformulario"].submit();
                     
                 }
            </script>
             
            <form name="miformulario" action="../../repositorio" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExiste" value="1">
                <!-- Carpeta creada-->
                <input type="hidden" name="verCarpetaCreada" value="<?PHP echo $ruta;?>">
            </form> 
        <?php 
    }else{
    //var_dump($encargadoVer); 
    $nombreAntes2 = "../../".$ruta.$nombreAntes;
    $nombreNuevo2 = "../../".$ruta.$nombreNuevo;
    
    $nombreAntes2S= "../../".$ruta.$nombreAntes;
    $nombreNuevo2S= "../../".$ruta.$nombreNuevo;
    //rename("$nombreAntes2","$nombreNuevo2");
    
    $nombreAntes = utf8_decode($nombreAntes);
    $nombreAntes2 = utf8_decode($nombreAntes2);
    
    $traeid = $mysqli->query("SELECT * FROM repositorioCarpeta WHERE nombre = '$nombreAntes' AND ruta = '$nombreAntes2'");
    $datos = $traeid->fetch_array(MYSQLI_ASSOC);
    $id  = $datos["id"];
    
     
    $nombreNuevoB = utf8_decode($nombreNuevo);
    $nombreNuevo2A = utf8_decode($nombreNuevo2);
    //$nombreNuevo;
    $traeid = $mysqli->query("SELECT * FROM repositorioCarpeta WHERE nombre = '$nombreNuevoB' AND  id != '$id' ");
    $datos = $traeid->fetch_array(MYSQLI_ASSOC);
    $nombreBD  = $datos["nombre"];
    
    
     // funcion para quitar espacios
        function Quitar_EspaciosB($nombreNuevo)
        {
            $array = explode(' ',$nombreNuevo);  // convierte en array separa por espacios;
            $nombreNuevo ='';
            // quita los campos vacios y pone un solo espacio
            for ($i=0; $i < count($array); $i++) { 
                if(strlen($array[$i])>0) {
                    $nombreNuevo.= ' ' . $array[$i];
                }
            }
          return  trim($nombreNuevo);
        }
        /// END
       
        $nombreNuevo = Quitar_EspaciosB($nombreNuevo);
    
    if($nombreNuevo == $nombreBD){
        ?>
                <script> 
                     window.onload=function(){
                   
                         //alert("Directorio renombrado");
                         document.forms["miformulario"].submit();
                     }
                </script>
                 
                <form name="miformulario" action="../../repositorio" method="POST" onsubmit="procesar(this.action);" >
                    <input type="hidden" name="validacionExisteR" value="1">
                    <!-- Carpeta creada-->
                    <input type="hidden" name="verCarpetaCreada" value="<?PHP echo $ruta;?>">
                </form> 
        <?php
    }else{
        rename("$nombreAntes2S","$nombreNuevo2S");
        $mysqli->query("UPDATE repositorioCarpeta SET nombre = '$nombreNuevoB', ruta = '$nombreNuevo2A', visualizar = '$radiobtnARs', visualizarID = '$encargadoVer' WHERE id = '$id' ") or die(mysqli_error($mysqli));
       
       
        ///// sacamos el nombre de la carpeta que debems modificar
        $consultamosTodasRutas=$mysqli->query("SELECT * FROM repositorioCarpeta WHERE NOT ruta='$nombreNuevo2A' ");
        while($extraeRutas=$consultamosTodasRutas->fetch_array()){
            $rutasEnviar=$extraeRutas['ruta']; echo '<br>';
            $rutaActualizar=str_replace("$nombreAntes","$nombreNuevo","$rutasEnviar");
            
            /// ahora que ya actualizamos la nueva ruta, debemos traer los id para poder editar unicamente esos carpetas
               $consultamosCarpeta=$mysqli->query("SELECT * FROM repositorioCarpeta WHERE ruta='$rutasEnviar'  ");
                while($extraerConsultaCarpeta=$consultamosCarpeta->fetch_array()){
                    $enviandIDCarpetaMuevaRuta=$extraerConsultaCarpeta['id']; echo '<br>';
                    $mysqli->query("UPDATE repositorioCarpeta SET ruta = '$rutaActualizar'  WHERE id='$enviandIDCarpetaMuevaRuta' ") or die(mysqli_error($mysqli));
                }
            /// end
            
        }
        $consultamosTodasRutasarchivos=$mysqli->query("SELECT * FROM repositorioRegistro ");
        while($extraeRutasArchivos=$consultamosTodasRutasarchivos->fetch_array()){
            $rutasEnviarArchivos=$extraeRutasArchivos['ruta']; echo '<br>';
            $rutaActualizarArchivos=str_replace("$nombreAntes","$nombreNuevo","$rutasEnviarArchivos");
            
            /// ahora que ya actualizamos la nueva ruta, debemos traer los id para poder editar unicamente esos carpetas
                $consultamosCarpeta=$mysqli->query("SELECT * FROM repositorioRegistro WHERE ruta='$rutasEnviarArchivos'  ");
                while($extraerConsultaCarpeta=$consultamosCarpeta->fetch_array()){
                    $enviandIDCarpetaMuevaRuta=$extraerConsultaCarpeta['id']; echo '<br>';
                    $mysqli->query("UPDATE repositorioRegistro SET ruta = '$rutaActualizarArchivos'  WHERE id='$enviandIDCarpetaMuevaRuta' ") or die(mysqli_error($mysqli));
                }
            /// end
            
        }
        ///// end
       
       
        ?>
                <script> 
                     window.onload=function(){
                   
                         //alert("Directorio renombrado");
                         document.forms["miformulario"].submit();
                     }
                </script>
                 
                <form name="miformulario" action="../../repositorio" method="POST" onsubmit="procesar(this.action);" >
                    <input type="hidden" name="validacionActualizar" value="1">
                    <!-- Carpeta creada-->
                    <input type="hidden" name="verCarpetaCreada" value="<?PHP echo $ruta;?>">
                </form> 
        <?php
       
    }
    
    
    
    
    
    
    
    
 
} 


}


if(isset($_POST['solicitudMotivo'])){
    $nombreSolicitante=$_POST['nombreSolicitante'];
    
    if($nombreSolicitante != NULL){
        $rutaSolicitar=$_POST['rutaSolicitar'];
        $nombreAntes2 = "../../".$rutaSolicitar.$nombreSolicitante;
        $motivo=utf8_decode($_POST['motivo']);
        $quienSolicita=$_POST['quienSolicita'];
       
         $nombreSolicitante;
         $nombreAntes2;
        
        $nombreSolicitante=utf8_decode($nombreSolicitante);
        $nombreAntes2=utf8_decode($nombreAntes2);
        $traeidRepositorioCarpeta=$mysqli->query(" SELECT * FROM repositorioCarpeta WHERE nombre='$nombreSolicitante' AND ruta='$nombreAntes2'");
        $datos= $traeidRepositorioCarpeta->fetch_array(MYSQLI_ASSOC);
        $id=$datos["id"];

        /// usuario a quien se solicita
        $idQuienDebeSolicitar=$datos["usuario"];
        // end
        
        
        /// validamos si el id y quien soicita ya existen en caso que si me actualiza la solicitud en caso contrario lo registra
      
        $traeidCosultar = $mysqli->query("SELECT * FROM repositorioCarpetaSolicitud WHERE idRepositorio ='$id' AND solicitante='$quienSolicita' ");
        $datosExtraer = $traeidCosultar->fetch_array(MYSQLI_ASSOC);
        'ID: '.$idExistencia=$datosExtraer['idRepositorio'];
        $solicitanteExistencia=$datosExtraer['solicitante'];
        
        if($id == $idExistencia && $quienSolicita == $solicitanteExistencia){ 
            
            $mysqli->query("UPDATE `repositorioCarpetaSolicitud` SET `motivo`='$motivo', `estado`='Pendiente' WHERE idRepositorio='$idExistencia' ") or die(mysqli_error($mysqli));
            
        }else{
             $mysqli->query("INSERT INTO `repositorioCarpetaSolicitud`(`idRepositorio`, `motivo`, `estado`, `solicitante`) VALUES ('$id','$motivo','Pendiente','$quienSolicita') ") or die(mysqli_error($mysqli));
        }

                        // notificación de correo
                        
                        /// envio de correos para los responsables del indicador
                        require '../usuarios/libreria/PHPMailerAutoload.php';
                
                        $nombreDocEnviar=utf8_encode($nombreSolicitante);

                        // quien solicita
                        $nombreuserQuienSolicita = $mysqli->query("SELECT * FROM usuario WHERE id='$quienSolicita' ");
                        $columnaSolicitante = $nombreuserQuienSolicita->fetch_array(MYSQLI_ASSOC);
                        $nombreSolicitante=utf8_encode($columnaSolicitante['nombres'].' '.$columnaSolicitante['apellidos']);
                        // end


                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id='$idQuienDebeSolicitar' ");
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
                            $mail->Subject = utf8_decode('Solicitud de visualización en repositorio');
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
                            <p>El usuario '.$nombreSolicitante.' solicita autorización de visualización para la carpeta <b>'.$nombreDocEnviar.'</b></p>
                            Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                            <br>
                            <em>Mi perfil --> mis pendientes --> repositorio --> solicitud pendiente +</em>.
                            <br>
                            <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
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
                        
                            
                        }
                        //// END 
        
        ?>
            <script> 
                 window.onload=function(){
                    document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../repositorio" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionAgregarB" value="1">
                <input type="hidden" name="verCarpetaCreada" value="<?PHP echo $rutaSolicitar;?>">
            </form> 
        <?php
     
         ///// END
    }else{
        ?>
            <script> 
                 window.onload=function(){
                    document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../repositorio" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExisteSolicitud" value="1">
                <input type="hidden" name="verCarpetaCreada" value="<?PHP echo $rutaSolicitar;?>">
            </form> 
        <?php 
    }
    
}

if(isset($_POST['ejecutaSolicitud'])){
     'id solicitar: '.$idSolicitar=$_POST['idSolicitar'];
     '<br>motivo: '.$motivo=$_POST['motivo'];
     '<br>estado: '.$aprobacionSolicitud=$_POST['aprobacionSolicitud'];
     '<br> id solicitante'.$idSolicitaSolicitante=$_POST['idSolicitaSolicitante'];
     '<br> id usuario: '.$idSolicitaSolicitanteUnico=$_POST['idSolicitaSolicitanteUnico'];
    
    $consultamosArchivosSolicitud=$mysqli->query("SELECT * FROM repositorioCarpeta WHERE id='$idSolicitar' "); //
    $extraeIDArchivoSolicitud=$consultamosArchivosSolicitud->fetch_array(MYSQLI_ASSOC);
    $campodeVisualizar=$extraeIDArchivoSolicitud['visualizarID'];
    $verificandoID=$extraeIDArchivoSolicitud['id'];
     $nombreRpositorio=$extraeIDArchivoSolicitud['nombre'];
    
    //// sacar el id de quien solicito
    $consultamosArchivosSolicitud2=$mysqli->query("SELECT * FROM repositorioCarpetaSolicitud WHERE idRepositorio='$verificandoID' "); //
    $extraeIDArchivoSolicitud2=$consultamosArchivosSolicitud2->fetch_array(MYSQLI_ASSOC);
    $idQuienDebeSolicitarSolicitante=$extraeIDArchivoSolicitud2['solicitante'];
    // END
    
    /// nos traemos la ruta para buscarla en el registro de archivos y meter el permiso de visualizaci��n tambi��n en esos documentos
     $rutaCarpeta=$extraeIDArchivoSolicitud['ruta'];
    /// END
    
    /// quilo los caracteres [] del JSON
    $solicitudAutomatica=substr($campodeVisualizar, 1, -1);
    
    /// concateno el solicitante en una variable para enviarla dentro del JSON
    $enviarNuevoVisualizar='"'.$idSolicitaSolicitante.'"';
    
    /// construyo el array para almacenar el nuevo ID
    $almacenandoNuevosDatos='['.$enviarNuevoVisualizar.','.$solicitudAutomatica.']';
    
    
    
    if($aprobacionSolicitud == 'Aprobado'){

        // notificación correo
                    /// envio de correos para los responsables del indicador
                    require '../usuarios/libreria/PHPMailerAutoload.php';
                                    
                    $nombreDocEnviar=utf8_encode($nombreRpositorio);

                  

                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id='$idSolicitaSolicitanteUnico' ");
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
                        $mail->Subject = utf8_decode('Solicitud de visualización en repositorio');
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
                        <p>La solicitud de visualización de la carpeta <b>'.$nombreDocEnviar.'</b> fue aprobada</p>
                        Se recomienda ingresar al sistema para visualizar la carpeta.
                        
                        <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
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
                    
                        
                    }
                    //// END 
        // end




        $mysqli->query("UPDATE repositorioCarpeta SET visualizarID = '$almacenandoNuevosDatos'  WHERE id='$verificandoID' ") or die(mysqli_error($mysqli));
        $mysqli->query("UPDATE repositorioCarpetaSolicitud SET estado = 'Aprobado', motivoRechazoAprobacion='$motivo'  WHERE idRepositorio='$verificandoID' AND solicitante='$idSolicitaSolicitanteUnico' ") or die(mysqli_error($mysqli));
        
        //// tambi��n autorizamos todos los archivos que contiene la carpeta principal
            //echo '<br><br><br>';
                /// a la variable $rutaCarpeta, separamos los puntos y la raiz, para buscar entre los archivos la carpeta correspondiente
                  'Nombre ruta: '.$rutaCarpeta=substr($rutaCarpeta, 10, -1);  /// oculta las primeras letras Raiz/ 
                ///END
            //echo '<br><br><br>';
           $consultaArchivos=$mysqli->query("SELECT * FROM repositorioRegistro WHERE ruta LIKE '%$rutaCarpeta%' ");
            while($extraerTodosArchivos=$consultaArchivos->fetch_array()){
                 'Estos son los id de los registro a autorizar: '.$estosIDVisualizar=$extraerTodosArchivos['id']; 
                //// traemos todos los array del visualizarID 
                     '--'.$extraerTodosArchivos['visualizarID'];
                ////
                //echo '<br>';
                //// separamos el array del visualizar ID
                    $idVIsualizarSeparados=substr($extraerTodosArchivos['visualizarID'], 1, -1);
                /// END
                //echo '<br>';
                //// acotejamos al solicitante a los permisos de los archivos dentro de las comillas
                 '--'.$enviarSolicitanteTodosArchivos='"'.$idSolicitaSolicitante='5'.'"';
                //// END
                //echo '<br>';
                //// acotejamos el solicitante dentro de los array de cada archivo contruyendo el array
                 'Listo: '.$almacenandoNuevosDatosTodosArchivos='['.$enviarSolicitanteTodosArchivos.','.$idVIsualizarSeparados.']';
                /// END
                //echo '<br>';
                ///// actualizamos los archivos
                  $mysqli->query("UPDATE repositorioRegistro SET visualizarID = '$almacenandoNuevosDatosTodosArchivos'  WHERE id='$estosIDVisualizar' ") or die(mysqli_error($mysqli));
                /// END
            }
        ////
        
        ?>
            <script> 
                 window.onload=function(){
                    document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../myperfil" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionAgregarC" value="1">
            </form> 
        <?php 
        
    }else{
        
        // notificación correo
                    /// envio de correos para los responsables del indicador
                    require '../usuarios/libreria/PHPMailerAutoload.php';
                                    
                    $nombreDocEnviar=utf8_encode($nombreRpositorio);

                  

                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id='$idSolicitaSolicitanteUnico' ");
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
                        $mail->Subject = utf8_decode('Solicitud de visualización en repositorio');
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
                        <p>La solicitud de visualización de la carpeta <b>'.$nombreDocEnviar.'</b> fue rechazada</p>
                        <br><br>
                        Motivo:<br>
                        '.$motivo.'
                        <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
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
                    
                        
                    }
                    //// END 
        // end
        
       $mysqli->query("UPDATE repositorioCarpetaSolicitud SET estado = 'Rechazado', motivoRechazoAprobacion='$motivo'  WHERE idRepositorio='$verificandoID' AND solicitante='$idSolicitaSolicitanteUnico' ") or die(mysqli_error($mysqli));
        
       ?>
            <script> 
                 window.onload=function(){
                    document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../myperfil" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminarB" value="1">
            </form> 
        <?php 
    }
    
    
        
    
}

if(isset($_POST['solicitudMotivoArchivos'])){
    $nombreSolicitante=$_POST['nombreSolicitante'];
    
    if($nombreSolicitante != NULL){
        $rutaSolicitar=$_POST['rutaSolicitar'];
        $nombreAntes2 = "../../".$rutaSolicitar.$nombreSolicitante;
        $motivo=utf8_decode($_POST['motivo']);
        $quienSolicita=$_POST['quienSolicita'];
       
        
        $nombreSolicitante=utf8_decode($nombreSolicitante);
        
        $traeid = $mysqli->query("SELECT * FROM repositorioRegistro WHERE nombre = '$nombreSolicitante' ");
        $datos = $traeid->fetch_array(MYSQLI_ASSOC);
        $id  = $datos["id"];
        /// usuario a quien se solicita
        $idQuienDebeSolicitar=$datos["realiza"];
        // end
        
        
        /// validamos si el id y quien soicita ya existen en caso que si me actualiza la solicitud en caso contrario lo registra
      
        $traeidCosultar = $mysqli->query("SELECT * FROM repositorioArchivoSolicitud WHERE idRepositorio ='$id' AND solicitante='$quienSolicita' ");
        $datosExtraer = $traeidCosultar->fetch_array(MYSQLI_ASSOC);
        $idExistencia=$datosExtraer['idRepositorio'];
        $solicitanteExistencia=$datosExtraer['solicitante'];
        
        if($id == $idExistencia && $quienSolicita == $solicitanteExistencia){ 
            
            $mysqli->query("UPDATE `repositorioArchivoSolicitud` SET `motivo`='$motivo', `estado`='Pendiente' WHERE idRepositorio='$idExistencia' ") or die(mysqli_error($mysqli));
            
        }else{
            $mysqli->query("INSERT INTO `repositorioArchivoSolicitud`(`idRepositorio`, `motivo`, `estado`, `solicitante`) VALUES ('$id','$motivo','Pendiente','$quienSolicita') ") or die(mysqli_error($mysqli));
        }
        //// END 
        // notificación de correo
                        
                        /// envio de correos para los responsables del indicador
                        require '../usuarios/libreria/PHPMailerAutoload.php';
                
                         $nombreDocEnviar=utf8_encode($nombreSolicitante);

                        // quien solicita
                        $nombreuserQuienSolicita = $mysqli->query("SELECT * FROM usuario WHERE id='$quienSolicita' ");
                        $columnaSolicitante = $nombreuserQuienSolicita->fetch_array(MYSQLI_ASSOC);
                         $nombreSolicitante=utf8_encode($columnaSolicitante['nombres'].' '.$columnaSolicitante['apellidos']);
                        // end


                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id='$idQuienDebeSolicitar' ");
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
                            $mail->Subject = utf8_decode('Solicitud de visualización en repositorio');
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
                            <p>El usuario '.$nombreSolicitante.' solicita autorización de visualización para el archivo <b>'.$nombreDocEnviar.'</b></p>
                            Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                            <br>
                            <em>Mi perfil --> mis pendientes --> repositorio --> solicitud pendiente +</em>.
                            <br>
                            <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
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
                        
                            
                        }
                        //// END 
        ?>
            <script> 
                 window.onload=function(){
                    document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../repositorio" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionAgregarB" value="1">
                <input type="hidden" name="verCarpetaCreada" value="<?PHP echo $rutaSolicitar;?>">
            </form> 
        <?php
     
         ///// END
    }else{
        ?>
            <script> 
                 window.onload=function(){
                    document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../repositorio" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExisteSolicitud" value="1">
                <input type="hidden" name="verCarpetaCreada" value="<?PHP echo $rutaSolicitar;?>">
            </form> 
        <?php 
    }
    
}

if(isset($_POST['ejecutaSolicitudCarpeta'])){
    $idSolicitar=$_POST['idSolicitar'];
    $motivo=$_POST['motivo'];
    $aprobacionSolicitud=$_POST['aprobacionSolicitud'];
    $idSolicitaSolicitante=$_POST['idSolicitaSolicitante'];
    $idSolicitaSolicitanteUnico=$_POST['idSolicitaSolicitanteUnico'];
    
    $consultamosArchivosSolicitud=$mysqli->query("SELECT * FROM repositorioRegistro WHERE id='$idSolicitar' ");
    $extraeIDArchivoSolicitud=$consultamosArchivosSolicitud->fetch_array(MYSQLI_ASSOC);
    $campodeVisualizar=$extraeIDArchivoSolicitud['visualizarID'];
    $verificandoID=$extraeIDArchivoSolicitud['id'];
    $nombreRpositorio=$extraeIDArchivoSolicitud['nombre'];

    //// sacar el id de quien solicito
    $consultamosArchivosSolicitud2=$mysqli->query("SELECT * FROM repositorioArchivoSolicitud WHERE idRepositorio='$verificandoID' "); //
    $extraeIDArchivoSolicitud2=$consultamosArchivosSolicitud2->fetch_array(MYSQLI_ASSOC);
    $idQuienDebeSolicitarSolicitante=$extraeIDArchivoSolicitud2['solicitante'];
    $motivoRechazoArchivo=$extraeIDArchivoSolicitud2['motivoRechazoAprobacion'];
    // END
    /// quilo los caracteres [] del JSON
    $solicitudAutomatica=substr($campodeVisualizar, 1, -1);
    
    /// concateno el solicitante en una variable para enviarla dentro del JSON
    $enviarNuevoVisualizar='"'.$idSolicitaSolicitante.'"';
    
    /// construyo el array para almacenar el nuevo ID
    $almacenandoNuevosDatos='['.$enviarNuevoVisualizar.','.$solicitudAutomatica.']';
    
    
    
    if($aprobacionSolicitud == 'Aprobado'){

         // notificación correo
                    /// envio de correos para los responsables del indicador
                    require '../usuarios/libreria/PHPMailerAutoload.php';
                                    
                    $nombreDocEnviar=utf8_encode($nombreRpositorio);

                  

                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id='$idSolicitaSolicitanteUnico' "); //$idQuienDebeSolicitarSolicitante
                    while($columna = $nombreuser->fetch_array()){
                        $nombreResponsable=$columna['nombres'].' '.$columna['apellidos']; 
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
                        $mail->Subject = utf8_decode('Solicitud de visualización en repositorio');
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
                        <p>La solicitud de visualización del documento <b>'.$nombreDocEnviar.'</b> fue autorizada</p>
                        Se recomienda ingresar al sistema para visualizar el documento en repositorio.
                        
                        <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
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
                    
                        
                    }
                    //// END 
        // end
       
        $mysqli->query("UPDATE repositorioRegistro SET visualizarID = '$almacenandoNuevosDatos'  WHERE id='$verificandoID' ") or die(mysqli_error($mysqli));
        $mysqli->query("UPDATE repositorioArchivoSolicitud SET estado = 'Aprobado', motivoRechazoAprobacion='$motivo'  WHERE idRepositorio='$verificandoID' AND solicitante='$idSolicitaSolicitanteUnico' ") or die(mysqli_error($mysqli));
        ?>
            <script> 
                 window.onload=function(){
                    document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../myperfil" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionAgregarC" value="1">
            </form> 
        <?php 
        
    }else{
        
        
        
        
        
         // notificación correo
                    /// envio de correos para los responsables del indicador
                    require '../usuarios/libreria/PHPMailerAutoload.php';
                                    
                    $nombreDocEnviar=utf8_encode($nombreRpositorio);

                  

                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id='$idSolicitaSolicitanteUnico' "); //$idQuienDebeSolicitarSolicitante
                    while($columna = $nombreuser->fetch_array()){
                        $nombreResponsable=$columna['nombres'].' '.$columna['apellidos']; 
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
                        $mail->Subject = utf8_decode('Solicitud de visualización en repositorio');
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
                        <p>La solicitud de visualización del documento <b>'.$nombreDocEnviar.'</b> fue rechazada</p>
                        <br><br>
                        Motivo:<br>
                        '.$motivo.'
                        <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
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
                    
                        
                    }
                    //// END 
        // end
        
        
        
       $mysqli->query("UPDATE repositorioArchivoSolicitud SET estado = 'Rechazado', motivoRechazoAprobacion='$motivo'  WHERE idRepositorio='$verificandoID' AND solicitante='$idSolicitaSolicitanteUnico' ") or die(mysqli_error($mysqli));
        
       ?>
            <script> 
                 window.onload=function(){
                    document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../myperfil" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminarB" value="1">
            </form> 
        <?php 
    }
    
    
        
    
}




