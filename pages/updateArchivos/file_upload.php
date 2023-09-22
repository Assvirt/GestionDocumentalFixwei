<?php 
//include_once("db_connect.php");
require_once'../conexion/bd.php';
if(!empty($_FILES)){     
    date_default_timezone_set('America/Bogota');
    
    /// preguntamos si es primera carpeta o subcarpeta
    if($_POST['filaCarpeta'] == 1){
        $preguntaCarpeta=$mysqli->query("SELECT * FROM carpeta WHERE  rol='".$_POST['rolUsuario']."' AND fila='1' ")or die("database error:". mysqli_error($mysqli));
        $extraerpreguntaCarpeta=$preguntaCarpeta->fetch_array(MYSQLI_ASSOC);
        //$preguntaUsuarioCarpeta=$mysqli->query("SELECT * FROM carpeta WHERE  id='".$extraerpreguntaCarpeta['rol']."' ")or die("database error:". mysqli_error($mysqli));
        //$extraerpreguntaUsuarioCarpeta=$preguntaUsuarioCarpeta->fetch_array(MYSQLI_ASSOC);
        
        $upload_dir = "../archivos/documentoProveedor/".$extraerpreguntaCarpeta['rol'].'/';
    }else{
        
        $recorriendoCarpetas=$mysqli->query("SELECT * FROM carpeta WHERE id='".$_POST['idCarpeta']."' ");
        $string="";
        while($extraerRecorriendoCarpetas=$recorriendoCarpetas->fetch_array()){
             'consutruir ruta: '.$string .=utf8_encode($extraerRecorriendoCarpetas['ruta']).'/';
            
        }
        $upload_dir = "../archivos/documentoProveedor/".$string;
    }
    
    ///// eliminamos el simbolo % que contiene algún documento
    
    $fileName = str_replace("%","",$_FILES['file']['name']);
      
    
    /// preguntamos la existencia del documento
    $exiatenciaDocumento=$mysqli->query("SELECT * FROM uploadsP WHERE file_name='$fileName' AND idCarpeta='".$_POST['idCarpeta']."' AND fila='".$_POST['filaCarpeta']."' ");
    $extraerDcumentoNombre=$exiatenciaDocumento->fetch_array(MYSQLI_ASSOC);
    
    if($extraerDcumentoNombre['file_name'] == $fileName){
        $uploaded_file = $upload_dir.$fileName;
        if(move_uploaded_file($_FILES['file']['tmp_name'],$uploaded_file)){ 
            $nombreDocumentoEnviar=utf8_decode($fileName);
            $mysql_insert = "DELETE FROM uploadsP WHERE  file_name='".$nombreDocumentoEnviar."' AND idCarpeta='".$_POST['idCarpeta']."' AND user='".$_POST['rolUsuario']."' AND fila='".$_POST['filaCarpeta']."' ";
    		mysqli_query($mysqli, $mysql_insert) or die("database error:". mysqli_error($mysqli));
            //insert file information into db table
    		$mysql_insert = "INSERT INTO uploadsP (file_name, upload_time, idCarpeta, user, fila)VALUES('".$nombreDocumentoEnviar."','".date("Y-m-d H:i:s")."','".$_POST['idCarpeta']."', '".$_POST['rolUsuario']."', '".$_POST['filaCarpeta']."' )";
    		mysqli_query($mysqli, $mysql_insert) or die("database error:". mysqli_error($mysqli));
        } 
    }else{
        $uploaded_file = $upload_dir.$fileName;
        if(move_uploaded_file($_FILES['file']['tmp_name'],$uploaded_file)){ 
            $nombreDocumentoEnviar=utf8_decode($fileName);
            $mysql_insert = "DELETE FROM uploadsP WHERE  file_name='".$nombreDocumentoEnviar."' AND idCarpeta='".$_POST['idCarpeta']."' AND user='".$_POST['rolUsuario']."' AND fila='".$_POST['filaCarpeta']."' ";
    		mysqli_query($mysqli, $mysql_insert) or die("database error:". mysqli_error($mysqli));
            //insert file information into db table
    		$mysql_insert = "INSERT INTO uploadsP (file_name, upload_time, idCarpeta, user, fila)VALUES('".$nombreDocumentoEnviar."','".date("Y-m-d H:i:s")."','".$_POST['idCarpeta']."', '".$_POST['rolUsuario']."', '".$_POST['filaCarpeta']."' )";
    		mysqli_query($mysqli, $mysql_insert) or die("database error:". mysqli_error($mysqli));
        } 
        
    }
    
    
}
