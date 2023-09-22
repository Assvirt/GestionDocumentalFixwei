<?php
//////// traemos la bd
date_default_timezone_set("America/Bogota");
require_once '../../conexion/bd.php';
session_start();
$usuario = $_SESSION["session_username"];

if(isset($_POST['revision'])){
    
    $controlCambios = $_POST['controlCambios'];
    $actualizar = $_POST['radiobtnActualizar'];
    
    
    $nombre = utf8_decode($_POST['nombre']);//idDocumento -- Traigo ahí el id porque ahi lo guardaron 
    
    if($actualizar == 'si'){

        $mysqli->query("UPDATE documento SET revisado = 1, usuarioRevisa = '$usuario' WHERE id = '$nombre'");
        
        $tipoSolicitud = 2; //Tipo 2 actualizacioon 
        
        $nombre = utf8_decode($_POST['nombre']);//idDocumento -- Traigo ahí el id porque ahi lo guardaron 
        $nombreDocumento = utf8_decode($_POST['nombreDocumento']);
        $proceso = $_POST['proceso'];
        $tipoDoc = $_POST['tipoDoc'];
        $encargado = $_POST['encargado'];
        $solicitud = utf8_decode($_POST['controlCambios']);
        $fecha = date("Y:m:j");
    
        $mysqli->query("INSERT INTO solicitudDocumentos ( quienSolicita, tipoSolicitud, tipoDocumento, encargadoAprobar, nombreDocumento,nombreDocumento2, proceso, solicitud,fecha,documento,plataformaH)
                VALUES ('$usuario','$tipoSolicitud','$tipoDoc','$encargado','$nombre','$nombreDocumento','$proceso','$solicitud','$fecha','sin datos','1')")or die(mysqli_error($mysqli));
                
        $mysqli->query("INSERT INTO comnetariosRevision ( idUsuario, comentario, fecha, idDocumento)
                VALUES ('$usuario','$solicitud','$fecha','$nombre')")or die(mysqli_error($mysqli));

        //echo '<script language="javascript">alert("Agregado con Exito");
        //window.location.href="../../solicitudDocumentos"</script>';
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

    }
    
    if($actualizar == 'no'){
        
        $comentario = utf8_decode($_POST['controlCambios']);
        $fecha = date("Y:m:j");
        $idDocumento = $_POST['idDocumento'];
        $mesesRevision = $_POST['nmesesRevision'];
        
        $mysqli->query("UPDATE documento SET ultimaFechaRevision = '$fecha', mesesRevision = '$mesesRevision' WHERE id = '$nombre'");
        
        $mysqli->query("INSERT INTO comnetariosRevision ( idUsuario, comentario, fecha, idDocumento)
                VALUES ('$usuario','$comentario','$fecha','$idDocumento')")or die(mysqli_error($mysqli));
        
        
        //echo '<script language="javascript">alert("Comentario agregado.");
        //window.location.href="../../revisionDocumental"</script>';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../revisionDocumental" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionAgregar" value="1">
            </form> 
        <?php
        
        
    }
    
    
}



?>