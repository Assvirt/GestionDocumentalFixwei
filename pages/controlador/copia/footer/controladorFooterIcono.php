<?php
//////// traemos la bd
require_once '../../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario

if(isset($_POST['piePaginaIcono1'])){

    $id = $_POST['idPiePaginaIcono1'];
   $icono1 = Addslashes(file_get_contents($_FILES['icono1']['tmp_name']));
   $icono2 = Addslashes(file_get_contents($_FILES['icono2']['tmp_name']));
    
    if($icono1 != NULL){
        $mysqli->query("UPDATE footerIconos  SET Icono1='$icono1' WHERE id = '$id'")or die(mysqli_error($mysqli));
    }elseif($icono2 != NULL){
        $mysqli->query("UPDATE footerIconos  SET Icono2='$icono2'  WHERE id = '$id'")or die(mysqli_error($mysqli));
    }else{
         $mysqli->query("UPDATE footerIconos  SET Icono1='$icono1', Icono2='$icono2'  WHERE id = '$id'")or die(mysqli_error($mysqli));
    }
    
    

    header ('location: ../../examples/AdminPageFooter');
  
    
}elseif(isset($_POST['piePaginaIcono2'])){

    $id = $_POST['idPiePaginaIcono2'];
   $icono3 = Addslashes(file_get_contents($_FILES['icono3']['tmp_name']));
   $icono4 = Addslashes(file_get_contents($_FILES['icono4']['tmp_name']));
   $icono5 = Addslashes(file_get_contents($_FILES['icono5']['tmp_name']));
    
    if($icono3 != NULL){
        $mysqli->query("UPDATE footerIconos  SET Icono3='$icono3' WHERE id = '$id'")or die(mysqli_error($mysqli));
    }elseif($icono4 != NULL){
        $mysqli->query("UPDATE footerIconos  SET Icono4='$icono4'  WHERE id = '$id'")or die(mysqli_error($mysqli));
    }elseif($icono5 != NULL){
        $mysqli->query("UPDATE footerIconos  SET Icono5='$icono5'  WHERE id = '$id'")or die(mysqli_error($mysqli));
    }else{
         $mysqli->query("UPDATE footerIconos  SET Icono3='$icono3', Icono4='$icono4', Icono5='$icono5'  WHERE id = '$id'")or die(mysqli_error($mysqli));
    }
    
    

    header ('location: ../../examples/AdminPageFooter');
  
    
}
?>