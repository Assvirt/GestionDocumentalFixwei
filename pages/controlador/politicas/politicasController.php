<?php

error_reporting(E_ERROR);
//////// traemos la bd
require_once '../../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario


if(isset($_POST['AgregarPolitica'])){
     //$nombre=$_POST['nombre'];
     $politica=utf8_decode($_POST['politica']);
    
    // registramos el proveedor seeccionado a la orden de compra
    //$mysqli->query("INSERT INTO proveedorPoliticas (politica) VALUES('$politica')") or die(mysqli_error($mysqli));
    
    $mysqli->query("UPDATE proveedorPoliticas SET politica='$politica'") or die(mysqli_error($mysqli));
    //$mysqli->query("UPDATE usuario SET  telefono='$telefono',foto ='$foto',clave='$pass',correo='$correo',nombres='$nombreUsuario', apellidos = '$apellido', fechaNacimiento='$fechaNacimiento', cargo='$cargo', lider='$lider', proceso='$proceso', cedula='$documento' ,arl='$arl',eps='$eps',afp='$afp' WHERE id = '$id'")or die(mysqli_error($mysqli));//idCentroCostos = '$idCentroCostos'
    
    
    
}
?>

<script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../politicasOC" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionAgregar" value="1">
            </form> 
