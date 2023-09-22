<?php
require_once '../../conexion/bd.php';
mb_internal_encoding("UTF-8");


if(isset($_POST['Agregar'])){
    
$nombre = utf8_decode($_POST['nombre']);
$valor = $_POST['valor'];
$periodo = $_POST['periodo'];
$radiobtn = $_POST['radiobtn'];//quien cita
$select = json_encode($_POST['select_encargadoE']);
    
    ///////// consultamos la tabla y extraemos el nombre
    $validacion = $mysqli->query("SELECT * FROM presupuesto WHERE nombre = '$nombre' ")or die (mysqli_error());
    $numRows = mysqli_num_rows($validacion);
if($numRows > 0){
        //echo 'funciona';
        echo '<script language="javascript">alert("El nombre del presupueso ya existe");
        window.location.href="../../presupuesto"</script>';
    }else{
        //echo 'no sirve';
        $mysqli->query("INSERT INTO presupuesto (nombre, totalPresupuesto, totalEjecutado, tipoResponsable, responsable, periodo) VALUES('$nombre','$valor','0','$radiobtn','$select','$periodo') ")or die(mysqli_error($mysqli));
        header ('location: ../../presupuesto');
    }

}elseif(isset($_POST['Editar'])){

    $id= $_POST['idProveedorGrupo'];
    $grupo = $_POST['grupo'];
    $descripcion = $_POST['descripcion'];
    
    $validacion = $mysqli->query("SELECT * FROM proveedoresGrupo WHERE id='$id' ");
    $numRows = mysqli_num_rows($validacion);
    if($numRows > 0){
        
        $mysqli->query("UPDATE proveedoresGrupo SET  grupo='$grupo', descripcion='$descripcion'  WHERE id = '$id'")or die(mysqli_error($mysqli));
        header ('location: ../../agregarProveedoresGrupos');
        
    }else{
  
        echo '<script language="javascript">alert("El grupo ya existe");
        window.location.href="../../agregarProveedoresGrupos"</script>';
    
} 

}elseif(isset($_POST['Eliminar'])){
    
                        $id = $_POST['idPresupuesto'];
                        $mysqli->query("DELETE from presupuesto  WHERE id = '$id'")or die(mysqli_error($mysqli));
                        echo '<script language="javascript">alert("El presupuesto fue eliminado");
                        window.location.href="../../presupuesto"</script>';
                    
    
}
?>