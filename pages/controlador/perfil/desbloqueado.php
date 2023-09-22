<?php

 error_reporting(E_ERROR);
 //realizamos el ingreso
 require("../../conexion/bd.php");
 $id=$_POST['cedula'];

 
 if($id != NULL){
    $id=$_POST['cedula'];
    $newpass=$_POST['newpass'];
    $estado = 'activo';
      
$mysqli->query("UPDATE perfiles SET clave='$newpass', estadoPerfiles = '$estado' where cedul='$id' ") or die(mysqli_error($mysqli));
    echo '<script language="javascript">confirm("Contraseña actualizada");
    window.location.href="../sesion/logout"</script>';
   }
 


?>