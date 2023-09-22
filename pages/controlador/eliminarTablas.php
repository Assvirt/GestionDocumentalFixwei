<?php error_reporting(E_ERROR);
//////// traemos la bd
require_once '../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario

$modulo=$_POST['modulo'];


if($modulo == 'Usuarios'){
    $mysqli->query("TRUNCATE  chat_users ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE  usuarios ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE  usuarioEliminado ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE  usuario ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE  grupoUusuario ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE  cTrabajoUusuario ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE  users ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE  messages ")or die(mysqli_error($mysqli));
}
if($modulo == 'Grupos de distribución'){
    $mysqli->query("TRUNCATE  grupo ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE  permisos ")or die(mysqli_error($mysqli));
}
if($modulo == 'Cargos'){
    $mysqli->query("TRUNCATE  cargos ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE  nivelcargo ")or die(mysqli_error($mysqli));
}
if($modulo == 'Centro de Trabajos'){
    $mysqli->query("TRUNCATE  centrodetrabajo ")or die(mysqli_error($mysqli));
}
if($modulo == 'Procesos'){
    $mysqli->query("TRUNCATE  procesos ")or die(mysqli_error($mysqli));
}
if($modulo == 'Macroprocesos'){
    $mysqli->query("TRUNCATE  macroproceso ")or die(mysqli_error($mysqli));
}
if($modulo == 'Definición'){
    $mysqli->query("TRUNCATE  definicion ")or die(mysqli_error($mysqli));
}
if($modulo == 'Codificación'){
    $mysqli->query("TRUNCATE  codificacion ")or die(mysqli_error($mysqli));
}
if($modulo == 'Normatividad'){
    $mysqli->query("TRUNCATE  normatividad ")or die(mysqli_error($mysqli));
}
if($modulo == 'Centro de costos'){
    $mysqli->query("TRUNCATE  centroCostos ")or die(mysqli_error($mysqli));
}
if($modulo == 'Tipo de documento'){
    $mysqli->query("TRUNCATE  tipoDocumento ")or die(mysqli_error($mysqli));
}


if($modulo == 'gestion'){
    $mysqli->query("TRUNCATE  documento ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE  solicitudDocumentos ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE  controlCambios ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE  controlCambiosFlujo ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE  comentarioSolicitud ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE  documentoDatosTemporales ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE  documentoArchivoTemporal ")or die(mysqli_error($mysqli));
    
    $files = glob('../archivos/documentos/*'); //obtenemos todos los nombres de los ficheros
    foreach($files as $file){
        if(is_file($file))
        unlink($file); //elimino el fichero
    }
    $files = glob('../archivos/solicitudes/*'); //obtenemos todos los nombres de los ficheros
    foreach($files as $file){
        if(is_file($file))
        unlink($file); //elimino el fichero
    }
    $files = glob('../modelo_chat/documentos/uploads/*'); //obtenemos todos los nombres de los ficheros
    foreach($files as $file){
        if(is_file($file))
        unlink($file); //elimino el fichero
    }
    
}  
     
    
    ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../clienteBorrarRegistros" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="clienteBorrarRegistros" value="1">
            </form> 
    <?php


?>