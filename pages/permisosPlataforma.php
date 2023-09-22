<?php
error_reporting(E_ERROR);
require_once 'conexion/bd.php';
$documento = $_SESSION["session_username"];
$queryGrupos = $mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario = '$documento'");

while($row = $queryGrupos->fetch_assoc()){
     'id:grupo: '.$idGrupo = $row['idGrupo'];
    
    $queryPermisos = $mysqli->query("SELECT * FROM permisos WHERE idGrupo = '$idGrupo' AND formulario = '$formulario'");
    
    $permisos = $queryPermisos->fetch_array(MYSQLI_ASSOC);
    if($permisos['listar'] == TRUE){
        $permisoListar = $permisos['listar'];    
    }
    if($permisos['crear'] == TRUE){
        $permisoInsertar = $permisos['crear'];    
    }
    if($permisos['editar'] == TRUE){
        $permisoEditar = $permisos['editar'];    
    }
    if($permisos['eliminar'] == TRUE){
        $permisoEliminar = $permisos['eliminar'];    
    }
}

$root='';
$root = $_SESSION['session_root'];

if($root == 1){
    $permisoListar = TRUE;
    $permisoInsertar = TRUE;
    $permisoEditar = TRUE;
    $permisoEliminar = TRUE;
}

if($permisoListar == FALSE){
    echo '<script language="javascript">window.location.href="accesoDenegado"</script>';
}

if($permisoInsertar == FALSE){
    $visibleI = 'none';
}else{
    $visibleI = '';
}

if($permisoEditar == FALSE){
    $visibleE = 'none';
}else{
    $visibleE = '';
}

if($permisoEliminar == FALSE){
    $visibleD = 'none';
}else{
    $visibleD = '';
}

?>
