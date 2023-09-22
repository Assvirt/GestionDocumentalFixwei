<?php
require_once 'conexion/bd.php';
$idDocumento=$_POST['consultaProductos'];

$consultandoDocumentoValidar=$mysqli->query("SELECT * FROM documento WHERE id='".$_POST['consultaProductos']."' ");
$extraerDocumentoCodificacion=$consultandoDocumentoValidar->fetch_array(MYSQLI_ASSOC);
//$extraerDocumentoCodificacion['codificacion'];
 'empezamos a evaluar el proceso y el tipo de documento en vigente y obsoleto.';
   '<br>Proceso: '.$proceso=$_POST['procesos']; //$extraerDocumentoCodificacion['proceso'];
   '<br>Tipo de documento: '.$tipoDoc=$_POST['tipoDocumento']; //$tipoDoc=$extraerDocumentoCodificacion['tipo_documento'];
   '<br>Consecutivo: '.$extraerDocumentoCodificacion['consecutivo'];
   '<br>Versión: '.$extraerDocumentoCodificacion['version'];
   '<br><br>';


     // validamos la existencia de este proceso
        $consultamosExistenciaDocumento=$mysqli->query("SELECT * FROM documento WHERE tipo_documento = '$tipoDoc' AND proceso = '$proceso' ORDER BY consecutivo DESC "); 
        $contadorVigente=0;
        $contadorObsoleto=0;
        while($extraemosExistenciaDocumento=$consultamosExistenciaDocumento->fetch_array()){
            /*echo $extraemosExistenciaDocumento['proceso'];
            echo '-';
            echo $extraemosExistenciaDocumento['tipo_documento'];
            echo '-';
            echo $extraemosExistenciaDocumento['consecutivo'];
            echo '-';
            echo $extraemosExistenciaDocumento['version'];
            echo '-';
            echo $extraemosExistenciaDocumento['vigente'];
            echo '<br>';*/
            
            if($extraemosExistenciaDocumento['proceso'] && $extraemosExistenciaDocumento['tipo_documento'] && $extraemosExistenciaDocumento['consecutivo'] && $extraemosExistenciaDocumento['version'] && $extraemosExistenciaDocumento['vigente'] == 1){
                $contadorVigente++;
            }
            if($extraemosExistenciaDocumento['proceso'] && $extraemosExistenciaDocumento['tipo_documento'] && $extraemosExistenciaDocumento['consecutivo'] && $extraemosExistenciaDocumento['version'] && $extraemosExistenciaDocumento['obsoleto'] == 1){
                $contadorObsoleto++;
            }
            
            
        }
        
        
        
         '<br>Existe un vigente con esa codificación: '.$contadorVigente;
         '<br>Existe un obsoleto con esa codificación: '.$contadorObsoleto;
        
        if($contadorVigente >= '1' ){
          '<br>Debe consultar VIGENTE';
         '<br>'.$tipoDoc;
         '<br>'.$proceso;
        $queryDoc = $mysqli->query("SELECT * FROM documento WHERE tipo_documento = '$tipoDoc' AND proceso = '$proceso' AND vigente = '1'  ORDER BY consecutivo DESC")or die(mysqli_error($mysqli));
        $datosDoc = $queryDoc->fetch_assoc();
         '<br>Consecutivo: '.$consecutivo = $datosDoc['consecutivo']+1;
         '<br>Version: '.$version = $datosDoc['version'];
        
        
        $existenciaConsecutivo=$mysqli->query("SELECT * FROM documento WHERE tipo_documento='$tipoDoc' AND proceso='$proceso' AND vigente='1'   "); //AND consecutivo='$consecutivo'
        $extraerExistenciaConsecutivo=$existenciaConsecutivo->fetch_array(MYSQLI_ASSOC);
         '<br>Consecutivo existente: '.$validnadoConsecutivoExistente=$extraerExistenciaConsecutivo['consecutivo'];
        
            if($consecutivo > $validnadoConsecutivoExistente){
                $version = 1;
            }else{
                $version =$version;
            }
             '<br>Version que sale: '.$version;
        }
        
        if($contadorObsoleto >= '1'){
               
                 '<br>Debe consultar OBSOLETO';
                 '<br>'.$tipoDoc;
                 '<br>'.$proceso;
                /// traemos el ultim digito mayor
                $queryDocNumeroMayor = $mysqli->query("SELECT max(consecutivo) AS ultimoNnumero FROM documento WHERE tipo_documento = '$tipoDoc' AND proceso = '$proceso' AND aprobado_aprueba = '1' ORDER BY consecutivo DESC")or die(mysqli_error($mysqli));
                $datosDocNumeroMayor = $queryDocNumeroMayor->fetch_assoc();
                $ultimoNumeroConsecutivo=$datosDocNumeroMayor['ultimoNnumero'];
                
                $queryDoc = $mysqli->query("SELECT * FROM documento WHERE tipo_documento = '$tipoDoc' AND proceso = '$proceso' AND aprobado_aprueba = '1' AND obsoleto='1' ORDER BY consecutivo DESC")or die(mysqli_error($mysqli));
                $datosDoc = $queryDoc->fetch_assoc();
                 '<br>Consecutivo: '.$consecutivo = $ultimoNumeroConsecutivo+1;
                 '<br>Version: '.$version = $datosDoc['version'];
                
                
                
        }
        
        if($contadorVigente == 0 && $contadorObsoleto == 0){
            $consecutivo=1;
        }
        
        //$almacenarVariableAprobado=$extraemosExistenciaDocumento['aprobado_aprueba'];
       
        /// buscamos existencia por tipo de documento, proceso y vigente
       /* if($almacenarVariableAprobado == '1' && $extraemosExistenciaDocumento['vigente'] == '1' ){
        echo  'Debe consultar VIGENTE';
         '<br>'.$tipoDoc;
         '<br>'.$proceso;
        $queryDoc = $mysqli->query("SELECT * FROM documento WHERE tipo_documento = '$tipoDoc' AND proceso = '$proceso' AND aprobado_aprueba = '1'  ORDER BY consecutivo DESC")or die(mysqli_error($mysqli));
        $datosDoc = $queryDoc->fetch_assoc();
         '<br>Consecutivo: '.$consecutivo = $datosDoc['consecutivo']+1;
         '<br>Version: '.$version = $datosDoc['version'];
        
        
        $existenciaConsecutivo=$mysqli->query("SELECT * FROM documento WHERE tipo_documento='$tipoDoc' AND proceso='$proceso' AND aprobado_aprueba='1'   "); //AND consecutivo='$consecutivo'
        $extraerExistenciaConsecutivo=$existenciaConsecutivo->fetch_array(MYSQLI_ASSOC);
         '<br>Consecutivo existente: '.$validnadoConsecutivoExistente=$extraerExistenciaConsecutivo['consecutivo'];
        
            if($consecutivo > $validnadoConsecutivoExistente){
                $version = 1;
            }else{
                $version =$version;
            }
             '<br>Version que sale: '.$version;
        }elseif($almacenarVariableAprobado == '1' && $extraemosExistenciaDocumento['obsoleto'] == '1'){
               
                echo 'Debe consultar OBSOLETO';
                 '<br>'.$tipoDoc;
                 '<br>'.$proceso;
                /// traemos el ultim digito mayor
                $queryDocNumeroMayor = $mysqli->query("SELECT max(consecutivo) AS ultimoNnumero FROM documento WHERE tipo_documento = '$tipoDoc' AND proceso = '$proceso' AND aprobado_aprueba = '1' ORDER BY consecutivo DESC")or die(mysqli_error($mysqli));
                $datosDocNumeroMayor = $queryDocNumeroMayor->fetch_assoc();
                $ultimoNumeroConsecutivo=$datosDocNumeroMayor['ultimoNnumero'];
                
                $queryDoc = $mysqli->query("SELECT * FROM documento WHERE tipo_documento = '$tipoDoc' AND proceso = '$proceso' AND aprobado_aprueba = '1' AND obsoleto='1' ORDER BY consecutivo DESC")or die(mysqli_error($mysqli));
                $datosDoc = $queryDoc->fetch_assoc();
                 '<br>Consecutivo: '.$consecutivo = $ultimoNumeroConsecutivo+1;
                 '<br>Version: '.$version = $datosDoc['version'];
                
                
                
        }else{
            //// se valida sobre obsoletos
            
        echo  'Entra al ELSE';
         '<br>T.documento: '.$tipoDoc;
         '<br>Proceso: '.$proceso;
                            /// en caso que el if no se cumpla, traemos el documento que se está trabajando y sacamos el mismo consecutivo y versión
                            $consultamosExistenciaDocumento=$mysqli->query("SELECT * FROM documento WHERE id='$idDocumento'  ");
                            $extraemosExistenciaDocumento=$consultamosExistenciaDocumento->fetch_array(MYSQLI_ASSOC);
                             '<br>Consecutigo: '.$consecutivo = $extraemosExistenciaDocumento['consecutivo'];
                             '<br>Versión: '.$version = $extraemosExistenciaDocumento['version'];
                            
        }
    */
    
    
        
     '<br><br>Resultado de la validación de consulta de <b>versión y consecutivo: </b>';
     '<br>Consecutivo: '.$consecutivo;
     '<br>Versión'.$version;
   
   
   
   
   
     //PROCESO  
    $queryDocumentos = $mysqli->query("SELECT nombre, prefijo from tipoDocumento WHERE id = '".$tipoDoc."' ");
    $datosDocumento = $queryDocumentos->fetch_array(MYSQLI_ASSOC);
    $tipoDocumento = $datosDocumento['nombre'];
    $prefijoTipo = $datosDocumento['prefijo']; 
                    
    //TIPO DE DOCUMENTO             
    $roles=$row['cargo'];
    $queryProcesos = $mysqli->query("SELECT nombre,prefijo from procesos WHERE id = '".$proceso."' ");
    $datosProceso = $queryProcesos->fetch_array(MYSQLI_ASSOC);
    $nomProceso = $datosProceso['nombre'];
    $prefijoProceso = $datosProceso['prefijo']; 
    
      //CODIFICACION
    $codificacion = "";
    $dataCodificacion = $mysqli->query("SELECT * FROM codificacion ORDER BY id")or die(mysqli_error());
    while($rowC = $dataCodificacion->fetch_assoc()){
                           
        $cod = $rowC['codificacion'];
                                
        if($cod == "-"){
            $codificacion =  $codificacion."-";
        }
                            
        if($cod == "/"){
            $codificacion =  $codificacion."/";
        }
                                
        if($cod == " "){
            $codificacion =  $codificacion." ";
        }
                                
        if($cod == "Proceso"){
            $codificacion =  $codificacion.$prefijoProceso;
        }
                            
        if($cod == "Tipo de documento"){
            $codificacion = $codificacion.$prefijoTipo;        
        }
                                
        if($cod == "Consecutivo"){
            $codificacion = $codificacion.$consecutivo;        
        }
                                
        if($cod == "Versión"){
            $codificacion = $codificacion.$version;        
        }
    }//Fin codificacion 
    
     '<br>';
      "<br>Codificación: ".$codificacion;
     '<br>';
        if($extraerDocumentoCodificacion['estado'] == 'Aprobado'){
            //echo '<br><font color="green">Mantiene la misma condificación</font>';    
        }else{
            //if($consecutivo == $extraerDocumentoCodificacion['consecutivo'] && $version == $extraerDocumentoCodificacion['version']){
            //echo '<br><font color="green">Mantiene la misma condificación</font>';
            //}else{
                echo '<br><font color="blue">';
                echo 'EL DOCUMENTO " '.($_POST['enviarNuevoNombre']).' " PRÓXIMO A LIBERAR QUEDARÁ CON EL CÓDIGO '.$codificacion.' Y VERSIÓN 1 EN EL LISTADO MAESTRO, POR FAVOR VERIFIQUE QUE LOS DOCUMENTOS PREVIAMENTE CARGADOS CUENTEN CON ESTA CODIFICACIÓN';
                echo '.</font>';    
            //} $extraerDocumentoCodificacion['nombres']
        }
     


?>