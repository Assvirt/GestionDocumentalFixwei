<?php
//////// traemos la bd
require_once '../../conexion/bd.php';
mb_internal_encoding("UTF-8");
////////// validamos el ingreso por el name del  boton del formulario
if(isset($_POST['AgregarProveedor'])){

$nit=$_POST['nit'];
$contacto=$_POST['contacto'];
$razonSocial= utf8_decode($_POST['razonSocial']);
$email=$_POST['email'];
$descripcion=utf8_decode($_POST['descripcion']);
$criticidad=$_POST['criticidad'];
$grupo=$_POST['grupo'];
$terminoP=$_POST['terminoPago'];
$ciudad=utf8_decode($_POST['ciudad']);
$frecuenciaA=$_POST['frecuenciaA'];
$direccion=$_POST['direccion'];
$frecuenciaAD=$_POST['frecuenciaAD'];
$telefono=$_POST['telefono'];
$tiempoE=$_POST['tiempoE'];

    $validacion1 = $mysqli->query("SELECT * FROM proveedores WHERE nit = '$nit'");//consulta a base de datos si el nombre se repite
    $numNom = mysqli_num_rows($validacion1);
    if($numNom > 0){//si el nombre está repetido se pone falso
        $insertar = false;
        echo '<script language="javascript">alert("El nit del proveedor ya existe.");
        window.location.href="../../agregarProveedor"</script>';
    }else{
        $mysqli->query("INSERT INTO proveedores (nit,razonSocial,descripcion,grupo,ciudad,direccion,telefono,contacto,email,criticidad,terminoPago,frecuenciaActualizacion,frecuenciaActualizacionD,tiempoEvaluacion) 
            VALUES('$nit','$razonSocial','$descripcion','$grupo','$ciudad','$direccion','$telefono','$contacto','$email','$criticidad','$terminoP','$frecuenciaA','$frecuenciaAD','$tiempoE') ")or die(mysqli_error($mysqli));
        echo '<script language="javascript">confirm("El proveedor fue creado con éxito");
        window.location.href="../../proveedores"</script>';
    }
    
}elseif(isset($_POST['EditarProveedor'])){

$id=$_POST['idProveedor'];    
$nit=$_POST['nit'];
$contacto=$_POST['contacto'];
$razonSocial= utf8_decode($_POST['razonSocial']);
$email=$_POST['email'];
$descripcion=utf8_decode($_POST['descripcion']);
$criticidad=$_POST['criticidad'];
$grupo=$_POST['grupo'];
$terminoP=$_POST['terminoPago'];
$ciudad=utf8_decode($_POST['ciudad']);
$frecuenciaA=$_POST['frecuenciaA'];
$direccion=$_POST['direccion'];
$frecuenciaAD=$_POST['frecuenciaAD'];
$telefono=$_POST['telefono'];
$tiempoE=$_POST['tiempoE'];    
    
    $mysqli->query("UPDATE proveedores SET nit='$nit',razonSocial='$razonSocial',descripcion='$descripcion',grupo='$grupo',ciudad='$ciudad',direccion='$direccion',telefono='$telefono',contacto='$contacto',email='$email',criticidad='$criticidad',terminoPago='$terminoP',
    frecuenciaActualizacion='$frecuenciaA',frecuenciaActualizacionD='$frecuenciaAD',tiempoEvaluacion='$tiempoE' WHERE id='$id' ")or die(mysqli_error($mysqli));
        echo '<script language="javascript">confirm("El proveedor fue actualizado con éxito");
        window.location.href="../../proveedores"</script>';
    
    
}elseif(isset($_POST['Eliminar'])){
    
                        $id = $_POST['idProveedor'];
                        $mysqli->query("  DELETE from proveedores  WHERE id = '$id'")or die(mysqli_error($mysqli));
                        echo '<script language="javascript">
                        window.location.href="../../proveedores"</script>';
                    
    
}
echo 'no entra';
?>