<?php 
//include_once("db_connect.php");
require_once '../conexion/bd.php';
if(!empty($_FILES)){
    date_default_timezone_set('America/Bogota');
    $upload_dir = "../archivos/evaluacion/"; //uploads/
    $fileName = $_FILES['file']['name'];
    
    $uploaded_file = $upload_dir.$_POST['idEvaluacion'].''.$fileName; // ruta para subir a la carpeta
    
    if(move_uploaded_file($_FILES['file']['tmp_name'],$uploaded_file)){
       
        $uploaded_file = 'archivos/evaluacion/'.$_POST['idEvaluacion'].''.$fileName; // ruta para almacenar en BD
       
        ///  eliminar el documento si se repita para poderlo reemplazar en la tabla
        $uploaded_file = utf8_decode($uploaded_file);
        
        $mysqlE = "DELETE FROM evaluacionMaterial WHERE material='$uploaded_file' AND idEvaluacion='".$_POST['idEvaluacion']."'  ";
		mysqli_query($mysqli, $mysqlE) or die("database error:". mysqli_error($mysqli));
        
        $fileName = utf8_decode($fileName);
     	$mysql_insert = "INSERT INTO evaluacionMaterial (idEvaluacion,material,nombre)VALUES('".$_POST['idEvaluacion']."','$uploaded_file','$fileName')";
		mysqli_query($mysqli, $mysql_insert) or die(mysqli_error($mysqli));
    }   
}

