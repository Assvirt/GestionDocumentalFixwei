<?php

require_once 'conexion/bd.php';

$tipoDocumento = $_POST['idTipoDocumento']; 
$proceso = $_POST['idProceso']; 
$consecutivo = $_POST['consecutivo'];


$repiteConscutivo = $mysqli->query("SELECT * FROM documento WHERE consecutivo = '$consecutivo' AND proceso = '$proceso' AND tipo_documento = '$tipoDocumento' AND vigente = '1' ");
$nConsucutivo = mysqli_num_rows($repiteConscutivo);

    if($nConsucutivo > 0){
        $resultado = "si";
    }else{
        //echo "No se repite";
        $resultado = 'no';
    }

echo $resultado;


