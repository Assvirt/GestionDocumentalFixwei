<?php

error_reporting(E_ERROR);
//////// traemos la bd
require_once '../../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario

if(isset($_POST['Agregar'])){
    
  $tipo = utf8_decode($_POST['tipo']);

 
 

function Quitar_Espacios($tipo)
        {
            $array = explode(' ',$tipo);  // convierte en array separa por espacios;
            $tipo ='';
            // quita los campos vacios y pone un solo espacio
            for ($i=0; $i < count($array); $i++) { 
                if(strlen($array[$i])>0) {
                    $tipo.= ' ' . $array[$i];
                }
            }
          return  trim($tipo);
        }
        /// END
       
        $tipo = Quitar_Espacios($tipo);
        
//validaci贸n de nombre de grupo no exista
$validacion = $mysqli->query("SELECT * FROM solicitudCompraSolicitud WHERE tipo='$tipo' ");
$columna = $validacion->fetch_array(MYSQLI_ASSOC);
$solicitudS = $columna['idCentroTrabajo'];

$numRows = mysqli_num_rows($validacion);
if($numRows > 0){

  ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../solicitudCompraSolicitud" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExiste" value="1">
            </form> 
        <?php
        
}else{
  
   $mysqli->query("INSERT INTO solicitudCompraSolicitud (tipo)VALUES('$tipo')")or die(mysqli_error());
   
 
  ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../solicitudCompraSolicitud" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionAgregar" value="1">
            </form> 
        <?php
 
}

}
if(isset($_POST['editar'])){
    
  $idTipoSolicitud=$_POST['idTipoSolicitud'];    
  $tipo = utf8_decode($_POST['tipo']);
    
    function Quitar_Espacios($tipo)
        {
            $array = explode(' ',$tipo);  // convierte en array separa por espacios;
            $tipo ='';
            // quita los campos vacios y pone un solo espacio
            for ($i=0; $i < count($array); $i++) { 
                if(strlen($array[$i])>0) {
                    $tipo.= ' ' . $array[$i];
                }
            }
          return  trim($tipo);
        }
        /// END
       
        $tipo = Quitar_Espacios($tipo);
    
$validacion = $mysqli->query("SELECT * FROM solicitudCompraSolicitud WHERE tipo='$tipo' AND id != '$idTipoSolicitud' ");
$columna = $validacion->fetch_array(MYSQLI_ASSOC);
$solicitudS = $columna['idCentroTrabajo'];

$numRows = mysqli_num_rows($validacion);
if($numRows > 0){
    ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../solicitudCompraSolicitud" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExiste" value="1">
            </form> 
        <?php
}else{
   
    $mysqli->query("UPDATE solicitudCompraSolicitud SET tipo='$tipo' WHERE id = '$idTipoSolicitud'");
   
    ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../solicitudCompraSolicitud" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionActualizar" value="1">
            </form> 
        <?php
    }    
    
}

if(isset($_POST['borrar'])){
    
    $id = $_POST['idTipoSolicitud'];
    
    $mysqli->query("DELETE FROM solicitudCompraSolicitud WHERE id = '$id'");
   
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../solicitudCompraSolicitud" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminar" value="1">
            </form> 
        <?php
    
    
    
    
    
}