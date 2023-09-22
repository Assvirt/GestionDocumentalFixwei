<?php 
//include_once("db_connect.php");
require_once '../conexion/bd.php';
if(!empty($_FILES)){
    date_default_timezone_set('America/Bogota');
    $upload_dir = "uploads/";
    $fileName = $_FILES['file']['name'];
    $uploaded_file = $upload_dir.$_POST['validacionAgregar'].''.$fileName;
    if(move_uploaded_file($_FILES['file']['tmp_name'],$uploaded_file)){
        //insert file information into db table
        $concatenar = $_POST['validacionAgregar'].''.utf8_decode($fileName);    
        ///  eliminar el documento si se repita para poderlo reemplazar en la tabla
        $mysql_insert = "DELETE FROM proveedorProductosDocumentos WHERE  file_name='".$concatenar."' AND idProducto='".$_POST['validacionAgregar']."' ";
		mysqli_query($mysqli, $mysql_insert) or die("database error:". mysqli_error($mysqli));
        
		$mysql_insert = "INSERT INTO proveedorProductosDocumentos (file_name, upload_time,idProducto)VALUES('".$concatenar."','".date("Y-m-d H:i:s")."','".$_POST['validacionAgregar']."')";
		mysqli_query($mysqli, $mysql_insert) or die("database error:". mysqli_error($mysqli));
    }   
}

if(isset($_POST['Eliminar'])){
    $id = $_POST['validacionAgregar'];
    $idElminacion = $_POST['id'];
    $ConsultaDocumento = $mysqli->query("SELECT * FROM proveedorProductosDocumentos WHERE id='$idElminacion'");
    $extraerConsultaDocumento= $ConsultaDocumento->fetch_array(MYSQLI_ASSOC);
    $IdOrden=utf8_encode($extraerConsultaDocumento['file_name']);
    $eliminacion=unlink('uploads/'.$IdOrden);
    if($eliminacion != NULL){
        $mysqli->query("DELETE FROM proveedorProductosDocumentos WHERE id='$idElminacion'")or die(mysqli_error($mysqli));
       ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../proveedoresProductoVer" method="POST" onsubmit="procesar(this.action);" >
                <input name="validacionAgregar" value="<?php echo $_POST['validacionAgregar']; ?>" type="hidden">
                <input type="hidden" name="validacionEliminar" value="1">
                 <input type="hidden" name="validacionAgregar" value="<?php echo $id; ?>">
            </form> 
        <?php
    }else{
        ?>
                <script> 
                     window.onload=function(){
                   
                         document.forms["miformulario"].submit();
                     }
                </script>
                 
                <form name="miformulario" action="../proveedoresProductoVer" method="POST" onsubmit="procesar(this.action);" >
                    <input name="validacionAgregar" value="<?php echo $_POST['validacionAgregar']; ?>" type="hidden">
                    <input type="hidden" name="validacionExisteB" value="1">
                     <input type="hidden" name="validacionAgregar" value="<?php echo $id; ?>">
                </form> 
            <?php
    }
}