<?php
error_reporting(E_error);
require_once '../conexion/bd.php';


if(isset($_POST['habilitar'])){
$usuario = $_POST['usuario'];

$grupos = $mysqli->query("SELECT idFormulario FROM `formularios` WHERE modulo='config' ORDER BY orden DESC");
$idGrupos = $grupos->fetch_array(MYSQLI_ASSOC);

foreach($grupos as $idGrupo){
    $idForm = $idGrupo['idFormulario'];
    
    $mysqli->query("INSERT INTO notificaciones(idUsuario,correo,plataforma,formulario) VALUES('$usuario', TRUE, TRUE, '$idForm')")or die(mysqli_error($mysqli));
    
    
}
echo '<script language="javascript">alert("Habilitado");
    window.location.href="../notificacion"</script>';
    
    
}elseif(isset($_POST['Addnotificaciones'])){

    //modulo usuarios
    $id = $_POST['id'];
    $usuario = $_POST['usuario'];
    $formulario=$_POST['formulario'];
    $correo=$_POST['correoU'];
    $plataforma=$_POST['plataformaU'];
    
    
    /////// se trae la consulta para poder validar antes de ingresar o actualizar
    $queryForms = $mysqli->query("SELECT * FROM notificaciones WHERE id ='$id' ");
    while($row = $queryForms->fetch_assoc()){
        $validacion = $row['id'];
    }
    //////// fin del proceso
    
    
    if($id === $validacion){
        if($correo != NULL){
            $correo=1;
        }else{
            $correo=0;
        }
        if($plataforma != NULL){
            $plataforma=1;
        }else{
            $plataforma=0;
        }
            $mysqli->query("UPDATE notificaciones SET correo ='$correo', plataforma='$plataforma'  WHERE id='$id' ");    
    }else{
        if($correo != NULL){
            $correo=1;
        }else{
            $correo=0;
        }
        if($plataforma != NULL){
            $plataforma=1;
        }else{
            $plataforma=0;
        }
        $mysqli->query("INSERT INTO notificaciones (idUsuario,correo,plataforma,formulario)VALUES('$usuario','$correo','$plataforma','$formulario') ")or die(mysqli_error($mysqli));
    } 

    echo '<script language="javascript">alert("Actualizado");
    window.location.href="../notificacion"</script>';
   
}


?>