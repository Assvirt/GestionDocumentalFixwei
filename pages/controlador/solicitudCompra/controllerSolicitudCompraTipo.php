<?php

error_reporting(E_ERROR);
//////// traemos la bd
require_once '../../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario

if(isset($_POST['Agregar'])){
    
  $tipo = utf8_decode($_POST['tipo']);
  //$tipoFrecuencia = $_POST['btnFrecuencia'];
  //$frecuencia = $_POST['frecuencia'];
  //$frecuencia2 = $_POST['frecuencia2'];
  //$frecuencia3 = $_POST['frecuencia3'];
 
 if($frecuencia != NULL){
     $almacenar=$frecuencia;
 }elseif($frecuencia2 != NULL){
     $almacenar=$frecuencia2;
 }else{
     $almacenar=$frecuencia3;
 }

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
$validacion = $mysqli->query("SELECT * FROM solicitudCompraTipo WHERE tipo='$tipo' ");
$columna = $validacion->fetch_array(MYSQLI_ASSOC);
$solicitudS = $columna['idCentroTrabajo'];

$numRows = mysqli_num_rows($validacion);
if($numRows > 0){
  //echo '<script language="javascript">alert("El tipo de solicitud ya existe.");
  // window.location.href="../../solicitudCompraTipo"</script>';
  ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../solicitudCompraTipo" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExiste" value="1">
            </form> 
        <?php
        
}else{
   
   $mysqli->query("INSERT INTO solicitudCompraTipo (tipo)VALUES('$tipo')");    
   
   //echo '<script language="javascript">alert("Datos ingresados");
   // window.location.href="../../solicitudCompraTipo"</script>';  
   ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../solicitudCompraTipo" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionAgregar" value="1">
            </form> 
        <?php
 
}

}
if(isset($_POST['editar'])){
    
  $idTipoSolicitud=$_POST['idTipoSolicitud'];    
  $tipo = utf8_decode($_POST['tipo']);
 // $tipoFrecuencia = $_POST['btnFrecuencia'];
 // $frecuencia = $_POST['frecuencia'];
  
  
  
  if($tipoFrecuencia == 'ninguno'){
     $almacenar='0';
  }else{
     $almacenar=$frecuencia;
  }
    
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
    
    $validacion = $mysqli->query("SELECT * FROM solicitudCompraTipo WHERE tipo='$tipo' AND id != '$idTipoSolicitud' ");
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
             
            <form name="miformulario" action="../../solicitudCompraTipo" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExiste" value="1">
            </form> 
        <?php
}else{
        
   $mysqli->query("UPDATE solicitudCompraTipo SET tipo='$tipo' WHERE id = '$idTipoSolicitud'"); //tipoFrecuencia='$tipoFrecuencia',frecuencia='$almacenar'
    //echo '<script language="javascript">alert("Exito al Actualizar.");
    //window.location.href="../../solicitudCompraTipo"</script>';  
    ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../solicitudCompraTipo" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionActualizar" value="1">
            </form> 
        <?php
    }    
    
}
if(isset($_POST['borrar'])){
    
    $id = $_POST['idTipoSolicitud'];
    
    $mysqli->query("DELETE FROM solicitudCompraTipo WHERE id = '$id'");
    //echo '<script language="javascript">alert("exito al Eliminar.");
    //window.location.href="../../solicitudCompraTipo"</script>';
    
     ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../solicitudCompraTipo" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminar" value="1">
            </form> 
        <?php
    
    
    
}