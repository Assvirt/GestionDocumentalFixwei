<?php

require_once 'conexion/bd.php';
/*
echo '<br>T. Docu: '.$tipoDocumento ='4'; //$_POST['idTipoDocumento']; 
echo '<br>Proce: '.$proceso ='1';//$_POST['idProceso']; 
echo '<br>Consecutivo: '.$consecutivo ='61';//$_POST['consecutivo'];
echo '<br>Version: '.$id_version='1'; //$_POST['id_version'];
echo '<br>Id document: '.$idDocumento ='65'; //$_POST['idDocumento'];
*/
$tipoDocumento =$_POST['idTipoDocumento']; 
$proceso =$_POST['idProceso']; 
$consecutivo =$_POST['consecutivo'];
$id_version=$_POST['id_version'];
$idDocumento =$_POST['idDocumento'];

if($idDocumento != NULL){ 
    //version='$id_version' AND AND vigente = '1'
    $repiteConscutivo = $mysqli->query("SELECT * FROM documento WHERE  consecutivo = '$consecutivo' AND proceso = '$proceso' AND tipo_documento = '$tipoDocumento' AND id='$idDocumento' ");
    $extraerConsecutivo=$repiteConscutivo->fetch_array(MYSQLI_ASSOC);
    $nConsucutivo = mysqli_num_rows($repiteConscutivo);
     '<br><br>';
    if($nConsucutivo > 0){ /// el consecutivo ya fue registrado, la tiene el documento consultado, mantiene el consecutivo
        $resultado = "no";
    }else{
        $recorrido_consecutivo=$mysqli->query("SELECT * FROM documento WHERE proceso='$proceso' AND tipo_documento='$tipoDocumento' AND consecutivo='$consecutivo'  ");
        while($extraer_recorrido_consecutivo=$recorrido_consecutivo->fetch_array()){
            /// datos para validacion, solo informativo
            ///echo 'Consecutivo existente: '.$extraer_recorrido_consecutivo['consecutivo'];
             '<br>Vigente: '.$extraer_recorrido_consecutivo['vigente'];
             '<br>Obsoleto: '.$extraer_recorrido_consecutivo['obsoleto'];
    
            /// sumatoria de totales
            $verificandoVigentesExistentes+=$extraer_recorrido_consecutivo['vigente'];
            $verificandoObsoletoExistentes+=$extraer_recorrido_consecutivo['obsoleto'];
             '<br>';
        }
    }

     '<br>Conteo total de vigentes: '.$verificandoVigentesExistentes;
     '<br>Conteo total de obsoleto: '.$verificandoObsoletoExistentes;

     '<br>';
    if($verificandoVigentesExistentes > 0 || $verificandoObsoletoExistentes > 0){
        $resultado = "si";   
    }else{
        $resultado = "no";
    }

  
}else{ 
   
    
    $recorrido_consecutivo=$mysqli->query("SELECT * FROM documento WHERE proceso='$proceso' AND tipo_documento='$tipoDocumento' AND consecutivo='$consecutivo'  ");
    while($extraer_recorrido_consecutivo=$recorrido_consecutivo->fetch_array()){
        /// datos para validacion, solo informativo
        ///echo 'Consecutivo existente: '.$extraer_recorrido_consecutivo['consecutivo'];
        '<br>Vigente: '.$extraer_recorrido_consecutivo['vigente'];
        '<br>Obsoleto: '.$extraer_recorrido_consecutivo['obsoleto'];
            
        /// sumatoria de totales
        $verificandoVigentesExistentes+=$extraer_recorrido_consecutivo['vigente'];
        $verificandoObsoletoExistentes+=$extraer_recorrido_consecutivo['obsoleto'];
        '<br>';
    }
    

    '<br>Conteo total de vigentes: '.$verificandoVigentesExistentes;
    '<br>Conteo total de obsoleto: '.$verificandoObsoletoExistentes;

    '<br>';
    if($verificandoVigentesExistentes > 0 || $verificandoObsoletoExistentes > 0){
        $resultado = "si";   
    }else{
        $resultado = "no";
    }

  

    
}
    
//echo '<br>';
echo $resultado;


