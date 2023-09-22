<?php 
//include_once("db_connect.php");
require_once '../../conexion/bd.php';
if(!empty($_FILES)){
    date_default_timezone_set('America/Bogota');
    $upload_dir = "uploads/";
    $fileName = $_FILES['file']['name'];
    $uploaded_file =$upload_dir.$_POST['idEnvia'].''.$_POST['idRecibe'].''.$fileName;
    if(move_uploaded_file($_FILES['file']['tmp_name'],$uploaded_file)){
        //insert file information into db table
        $concatenar =$_POST['idEnvia'].''.$_POST['idRecibe'].''.utf8_decode($fileName);    
        
        $mysql_insert = "INSERT INTO messages (documento,outgoing_msg_id,incoming_msg_id,nombreDocumento)VALUES('".$concatenar."','".$_POST['idEnvia']."','".$_POST['idRecibe']."','$fileName')";
		mysqli_query($mysqli, $mysql_insert) or die("database error:". mysqli_error($mysqli));
		
        /*
        ///  eliminar el documento si se repita para poderlo reemplazar en la tabla
        $mysql_insert = "DELETE FROM uploads WHERE  file_name='".$concatenar."' AND idSolicitudCompra='".$_POST['idOrdenCompra']."' ";
		mysqli_query($mysqli, $mysql_insert) or die("database error:". mysqli_error($mysqli));
        
		$mysql_insert = "INSERT INTO uploads (file_name, upload_time,idSolicitudCompra)VALUES('".$concatenar."','".date("Y-m-d H:i:s")."','".$_POST['idOrdenCompra']."')";
		mysqli_query($mysqli, $mysql_insert) or die("database error:". mysqli_error($mysqli));
		*/
		
    }   
}
/*
if(isset($_POST['Eliminar'])){
    $id = $_POST['idOrdenCompra'];
    $idElminacion = $_POST['id'];
    $ConsultaDocumento = $mysqli->query("SELECT * FROM uploads WHERE id='$idElminacion'");
    $extraerConsultaDocumento= $ConsultaDocumento->fetch_array(MYSQLI_ASSOC);
    $IdOrden=utf8_encode($extraerConsultaDocumento['file_name']);
    $eliminacion=unlink('uploads/'.$IdOrden);
    if($eliminacion != NULL){
        $mysqli->query("DELETE FROM uploads WHERE id='$idElminacion'")or die(mysqli_error($mysqli));
       ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../registroProductosVisualizar" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminar" value="1">
                 <input type="hidden" name="idOrdenCompra" value="<?php echo $id; ?>">
            </form> 
        <?php
    }else{
        ?>
                <script> 
                     window.onload=function(){
                   
                         document.forms["miformulario"].submit();
                     }
                </script>
                 
                <form name="miformulario" action="../registroProductosVisualizar" method="POST" onsubmit="procesar(this.action);" >
                    <input type="hidden" name="validacionExisteB" value="1">
                     <input type="hidden" name="idOrdenCompra" value="<?php echo $id; ?>">
                </form> 
            <?php
    }
}*/