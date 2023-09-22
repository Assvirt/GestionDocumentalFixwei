<?php
//////// traemos la bd
require_once '../../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario

if(isset($_POST['servicio'])){

    $id = $_POST['idServicio'];
    $tituloServicio = $_POST['tituloServicio'];
    $subtituloServicio = $_POST['subtituloServicio'];
    $descripcionServicio = $_POST['descripcionServicio'];
    
    $tituloServicio2 = $_POST['tituloServicio2'];
    
    
    
    
    

    
    
        $mysqli->query("UPDATE servicios SET  TituloServicio='$tituloServicio', SubtituloServicio='$subtituloServicio', DescripcionServicio='$descripcionServicio',
        TituloServicio2='$tituloServicio2'  WHERE id = '$id'")or die(mysqli_error($mysqli));
    
     
    
         
      

    header ('location: ../../examples/AdminPageServices');
  
    
}
?>