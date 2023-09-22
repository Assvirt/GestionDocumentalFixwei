<?php

error_reporting(E_ERROR);
//////// traemos la bd
require_once '../../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario

if(isset($_POST['Agregar'])){
    
  $tipo = utf8_decode($_POST['tipo']);
  $tipoFrecuencia = $_POST['btnFrecuencia'];
  $frecuencia = $_POST['frecuencia'];
  $frecuencia2 = $_POST['frecuencia2'];
  $frecuencia3 = $_POST['frecuencia3'];
 
 if($frecuencia != NULL){
     $almacenar=$frecuencia;
 }elseif($frecuencia2 != NULL){
     $almacenar=$frecuencia2;
 }else{
     $almacenar=$frecuencia3;
 }


//validaci贸n de nombre de grupo no exista
$validacion = $mysqli->query("SELECT * FROM solicitudCompraUrgencia WHERE tipo='$tipo' ");
$columna = $validacion->fetch_array(MYSQLI_ASSOC);
$solicitudS = $columna['idCentroTrabajo'];

$numRows = mysqli_num_rows($validacion);
if($numRows > 0){
  echo '<script language="javascript">alert("La urgencia ya existe.");
   window.location.href="../../solicitudCompraUrgencia"</script>';
        
}else{
   
   $mysqli->query("INSERT INTO solicitudCompraUrgencia (tipo,tipoFrecuencia,frecuencia) 
   VALUES('$tipo','$tipoFrecuencia','$almacenar')");    
   
   echo '<script language="javascript">alert("Datos ingresados");
    window.location.href="../../solicitudCompraUrgencia"</script>';  
 
}

}
if(isset($_POST['editar'])){
    
  $idTipoSolicitud=$_POST['idTipoSolicitud'];    
  $tipo = utf8_decode($_POST['tipo']);
  $tipoFrecuencia = $_POST['btnFrecuencia'];
  $frecuencia = $_POST['frecuencia'];
 
 if($tipoFrecuencia == 'ninguno'){
     $almacenar='0';
  }else{
     $almacenar=$frecuencia;
  }
    
    
   
    $mysqli->query("UPDATE solicitudCompraUrgencia SET tipo='$tipo',tipoFrecuencia='$tipoFrecuencia',frecuencia='$almacenar' WHERE id = '$idTipoSolicitud'");
    echo '<script language="javascript">alert("Exito al Actualizar.");
    window.location.href="../../solicitudCompraUrgencia"</script>';
    }    
    

if(isset($_POST['borrar'])){
    
    $id = $_POST['idTipoSolicitud'];
    
    $mysqli->query("DELETE FROM solicitudCompraUrgencia WHERE id = '$id'");
    echo '<script language="javascript">alert("exito al Eliminar.");
    window.location.href="../../solicitudCompraUrgencia"</script>';
    
    
    
    
    
}