<?php 
//include_once("db_connect.php");
require_once '../conexion/bd.php';
if(!empty($_FILES)){
    date_default_timezone_set('America/Bogota');
    $upload_dir = "../archivos/documentoProveedor/"; //uploads/
    $fileName = ($_FILES['file']['name']);
    
    $uploaded_file = $upload_dir.$_POST['idProveedor'].''.$_POST['idCarpeta'].''.$fileName; // ruta para subir a la carpeta
    
    if(move_uploaded_file($_FILES['file']['tmp_name'],$uploaded_file)){
       
        $uploaded_file = 'archivos/documentoProveedor/'.$_POST['idProveedor'].''.$_POST['idCarpeta'].''.$fileName; // ruta para almacenar en BD
       
        ///  eliminar el documento si se repita para poderlo reemplazar en la tabla
        $mysql_insert = "DELETE FROM proveedordocumentos WHERE  nombre='".$fileName."' AND idProveedor='".$_POST['idProveedor']."' AND idCarpeta='".$_POST['idCarpeta']."' ";
		mysqli_query($mysqli, $mysql_insert) or die("database error:". mysqli_error($mysqli));
        
		$mysql_insert = "INSERT INTO proveedordocumentos (nombre, idProveedor,idCarpeta,soporte)VALUES('".utf8_decode($fileName)."','".$_POST['idProveedor']."','".$_POST['idCarpeta']."', '".utf8_decode($uploaded_file)."')";
		mysqli_query($mysqli, $mysql_insert) or die("database error:". mysqli_error($mysqli));
    }   
}

