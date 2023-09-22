<?php
//////// traemos la bd
require_once '../../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario

if(isset($_POST['piePagina'])){

    $id = $_POST['idPiePagina'];
    $tituloCompania = $_POST['tituloCompania'];
    $informacionCompania = $_POST['informacionCompania'];
    
    $tituloRedes = $_POST['tituloRedes'];
    $tituloLink1 = $_POST['tituloLink1'];
    $linkRed1 = $_POST['linkRed1'];
    $tituloLink2 = $_POST['tituloLink2'];
    $linkRed2 = $_POST['linkRed2'];
    
    $tituloContacto = $_POST['tituloContacto'];
    $direccionContacto = $_POST['direccionContacto'];
    $telefonoContacto = $_POST['telefonoContacto'];
    $correoContacto = $_POST['correoContacto'];

    
    
        $mysqli->query("UPDATE footer SET TituloCompania='$tituloCompania', InformacionCompania='$informacionCompania', TituloRedes='$tituloRedes', TituloLink1='$tituloLink1', 
        linkRed1='$linkRed1', TituloLink2='$tituloLink2', linkRed2='$linkRed2', TituloContacto='$tituloContacto', DireccionContacto='$direccionContacto', TelefonoContacto='$telefonoContacto',
        CorreoContacto='$correoContacto' WHERE id = '$id'")or die(mysqli_error($mysqli));
    
     
    
         
      

    header ('location: ../../examples/AdminPageFooter');
  
    
}
?>