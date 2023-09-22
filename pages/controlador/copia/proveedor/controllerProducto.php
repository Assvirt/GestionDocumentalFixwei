<?php
require_once '../../conexion/bd.php';
mb_internal_encoding("UTF-8");
error_reporting(E_ERROR);

if(isset($_POST['Agregar'])){
    
$idProveedor=$_POST['idProveedor'];    
$nombre = utf8_decode($_POST['nombre']);
$descripcion = utf8_decode($_POST['descripcion']);
$identificador = utf8_decode($_POST['identificador']);
$costo = $_POST['costo'];
$presentacion = $_POST['presentacion'];
$fecha = $_POST['fecha'];
//$imagen = $_FILES['imagen']['name'];
$imagen= Addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
    
    ///////// consultamos la tabla y extraemos el nombre
    $validacion = $mysqli->query("SELECT * FROM proveedorProductos WHERE identificador = '$identificador' AND idProveedor='$idProveedor' ")or die (mysqli_error());
    $numRows = mysqli_num_rows($validacion);
if($numRows > 0){
        //echo 'funciona';
        //echo '<script language="javascript">alert("El producto ya existe");
        //window.location.href="../../agregarProveedorProducto"</script>';
         ?>
                            <script>
                                    window.onload=function(){
                                        alert("El identificador ya existe");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../agregarProveedorProducto" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                            </form>
                            
                        <?php
    }else{
        //echo 'no sirve';
        $mysqli->query("INSERT INTO proveedorProductos (idProveedor, nombre, descripcion, identificador, costo, presentacion, fechaExpedicion, imagen)
        VALUES('$idProveedor','$nombre','$descripcion','$identificador','$costo','$presentacion','$fecha','$imagen') ")or die(mysqli_error($mysqli));
        //header ('location: ../../proveedorProductos');
        ?>
                            <script>
                                    window.onload=function(){
                                        alert("El producto ha sido creado con éxito");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                            </form>
                            
                        <?php
    }

}elseif(isset($_POST['Editar'])){
    
    $idProveedor=$_POST['idProveedor'];
    $id= $_POST['idProveedorProducto'];
    $nombre = utf8_decode($_POST['nombre']);
    $descripcion = utf8_decode($_POST['descripcion']);
    $identificador = utf8_decode($_POST['identificador']);
    
    $costo = $_POST['costo'];
    $presentacion = $_POST['presentacion'];
    $fecha = $_POST['fecha'];
    $imagen= Addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
    
    $validacion = $mysqli->query("SELECT * FROM proveedorProductos WHERE id='$id' ");
    $numRows = mysqli_num_rows($validacion);
    if($numRows > 0){
        
        if($imagen != NULL){
        $mysqli->query("UPDATE proveedorProductos SET  nombre='$nombre', descripcion='$descripcion', identificador='$identificador', costo='$costo', presentacion='$presentacion',
        fechaExpedicion='$fecha', imagen='$imagen'  WHERE id = '$id'")or die(mysqli_error($mysqli));
        }else{
        $mysqli->query("UPDATE proveedorProductos SET  nombre='$nombre', descripcion='$descripcion', identificador='$identificador', costo='$costo', presentacion='$presentacion',
        fechaExpedicion='$fecha'  WHERE id = '$id'")or die(mysqli_error($mysqli));
        }
        
        //header ('location: ../../agregarProveedoresGrupos');
        ?>
                            <script>
                                    window.onload=function(){
                                        alert("El producto ha sido actualizado con éxito");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                            </form>
                            
                        <?php
        
    }else{
  
        ?>
                            <script>
                                    window.onload=function(){
                                        alert("El producto no existe");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../proveedoresProductoEditar" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idProveedorProducto" value="<?php echo $id; ?>" type="hidden" readonly>
                               <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                            </form>
                            
                        <?php
    
} 

}elseif(isset($_POST['Eliminar'])){
    
                        $idProveedor=$_POST['idProveedor'];
                        $id = $_POST['idProveedorProducto'];
                        $mysqli->query("  DELETE from proveedorProductos  WHERE id = '$id'")or die(mysqli_error($mysqli));
                        //echo '<script language="javascript">
                        //window.location.href="../../agregarProveedoresGrupos"</script>';
                    ?>
                            <script>
                                    window.onload=function(){
                                        alert("El producto ha sido eliminado con éxito");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                            </form>
                            
                        <?php
    
}
?>