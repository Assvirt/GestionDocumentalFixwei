<?php
require_once '../../conexion/bd.php';
mb_internal_encoding("UTF-8");


if(isset($_POST['Agregar'])){
    
$grupo = utf8_decode($_POST['grupo']);
$descripcion = utf8_decode($_POST['descripcion']);
    
    ///////// consultamos la tabla y extraemos el nombre
    $validacion = $mysqli->query("SELECT * FROM proveedoresGrupo WHERE grupo = '$grupo' ")or die (mysqli_error());
    $numRows = mysqli_num_rows($validacion);
if($numRows > 0){
        //echo 'funciona';
        echo '<script language="javascript">alert("El grupo ya existe");
        window.location.href="../../agregarProveedoresGrupos"</script>';
    }else{
        //echo 'no sirve';
        $mysqli->query("INSERT INTO proveedoresGrupo (grupo, descripcion) VALUES('$grupo','$descripcion') ")or die(mysqli_error($mysqli));
        header ('location: ../../agregarProveedoresGrupos');
    }

}elseif(isset($_POST['Editar'])){

    $id= $_POST['idProveedorGrupo'];
    $grupo = utf8_decode($_POST['grupo']);
$descripcion = utf8_decode($_POST['descripcion']);
    
    $validacion = $mysqli->query("SELECT * FROM proveedoresGrupo WHERE id='$id' ");
    $numRows = mysqli_num_rows($validacion);
    if($numRows > 0){
        
        $mysqli->query("UPDATE proveedoresGrupo SET  grupo='$grupo', descripcion='$descripcion'  WHERE id = '$id'")or die(mysqli_error($mysqli));
        header ('location: ../../agregarProveedoresGrupos');
        
    }else{
  
        echo '<script language="javascript">alert("El grupo ya existe");
        window.location.href="../../agregarProveedoresGrupos"</script>';
    
} 

}elseif(isset($_POST['proveedoresGrupoEliminar'])){
    
                        $id = $_POST['idProveedorGrupo'];
                        $mysqli->query("  DELETE from proveedoresGrupo  WHERE id = '$id'")or die(mysqli_error($mysqli));
                        echo '<script language="javascript">
                        window.location.href="../../agregarProveedoresGrupos"</script>';
                    
    
}
?>