<?php
ini_set('display_errors', 1);
    error_reporting(-1);
    error_reporting(E_ERROR);
require_once '../../conexion/bd.php';
//Controlado versiomes y consecutivos de los documentos 


$tipoDocumento = $_POST['idTipoDoc']; 
$proceso = $_POST['idProceso']; 
$version = $_POST['versionInicial']; 
$consecutivo = $_POST['consecutivoInicial']; 


if(isset($_POST['agregar'])){
    
    /*Se valida que no se halla definido ya en que version o en que consecutivo inicia */
    
    $repite = $mysqli->query("SELECT * FROM versionamiento WHERE idProceso = '$proceso' AND idTipoDocumento = '$tipoDocumento'");
    
    $n = mysqli_num_rows($repite);
    

    if($n > 0){
        echo '<script language="javascript">alert("Ya definicon el proceso con el tipo de documento");
        window.location.href="../../versionamiento"</script>';
    }
    
    $repiteConscutivo = $mysqli->query("SELECT * FROM `documento` where consecutivo = '$consecutivo' AND proceso = '$proceso' AND tipo_documento = '$tipoDocumento' ");
    $nConsucutivo = mysqli_num_rows($repiteConscutivo);
    
    if($nConsucutivo > 0){
        echo '<script language="javascript">alert("Ya definicon este consecutivo.");
        window.location.href="../../versionamiento"</script>';
    }
    
    if($n == 0){
        
        $mysqli->query("INSERT INTO versionamiento (idProceso, idTipoDocumento, versionInicial, consecutivoInicial) VALUES('$proceso','$tipoDocumento','$version','$consecutivo')")or die(mysqli_error($mysqli));
        
        echo '<script language="javascript">alert("Agregado con exito.");
        window.location.href="../../versionamiento"</script>';
        
    }
    
}


if(isset($_POST['actualizar'])){
    
    $repite = $mysqli->query("SELECT * FROM versionamiento WHERE idProceso = '$proceso' AND idTipoDocumento = '$tipoDocumento'");
    
    $n = mysqli_num_rows($repite);
    $n =0;
    
    $repiteConscutivo = $mysqli->query("SELECT * FROM `documento` where consecutivo = '$consecutivo' AND proceso = '$proceso' AND tipo_documento = '$tipoDocumento' ");
    $nConsucutivo = mysqli_num_rows($repiteConscutivo);
    
    if($nConsucutivo > 0){
        echo '<script language="javascript">alert("Ya definicon este consecutivo.");
        window.location.href="../../versionamiento"</script>';
    }

    if($nConsucutivo == 0){
    
        $idEditar = $_POST['idEditar'];
        $tipoDocumento = $_POST['idTipoDoc']; 
        $proceso = $_POST['idProceso']; 
        $version = $_POST['versionInicial']; 
        $consecutivo = $_POST['consecutivoInicial']; 
        
        $mysqli->query("UPDATE versionamiento SET idProceso = $proceso, idTipoDocumento = $tipoDocumento, versionInicial= $version, consecutivoInicial = $consecutivo WHERE id = $idEditar ");
    
        echo '<script language="javascript">alert("Actualizado con exito.");
            window.location.href="../../versionamiento"</script>';
    }
    
    
}


if(isset($_POST['eliminar'])){
    
    $idEliminar = $_POST['idDel'];
    
    $eliminar = $mysqli->query("DELETE FROM versionamiento WHERE id = '$idEliminar'");
    
    if($eliminar){
        echo '<script language="javascript">alert("Eliminado con exito.");
        window.location.href="../../versionamiento"</script>';
    }else{
        
        echo '<script language="javascript">alert("Error el eliminar");
        window.location.href="../../versionamiento"</script>';
        
    }
    
    
    /*
    $tipoDocumento = $_POST['idTipoDoc']; 
    $proceso = $_POST['idProceso']; 
    $version = $_POST['versionInicial']; 
    $consecutivo = $_POST['consecutivoInicial']; 
    
    $mysqli->query("UPDATE versionamiento SET idProceso = $proceso, idTipoDocumento = $tipoDocumento, versionInicial= $version, consecutivoInicial = $consecutivo WHERE id = $idEditar ");

    echo '<script language="javascript">alert("Actualizado con exito.");
        window.location.href="../../versionamiento"</script>';*/
}



?>