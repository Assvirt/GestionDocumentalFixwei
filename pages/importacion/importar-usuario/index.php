<?php error_reporting(E_ERROR); error_reporting(0);
//Prueba repósitotio para Mayra
include('../importar-cargos/dbconect.php');
require_once('vendor/php-excel-reader/excel_reader2.php');
require_once('vendor/SpreadsheetReader.php');

if (isset($_POST["import"]))
{
    
$allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  
  if(in_array($_FILES["file"]["type"],$allowedFileType)){

        $targetPath = 'subidas/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        
        $Reader = new SpreadsheetReader($targetPath);
        
        $cedulaValidar = TRUE;
        $cedulaValidarE = TRUE;
        $cargoValidar = TRUE;
        $liderValidar = TRUE;
        $procesoValidar = TRUE;
        //$centroCostoValidar = TRUE;
        $centroTrabajoValidar = TRUE;
        $centroGrupoValidar = TRUE;
        $repiteNombreCedula = TRUE;
        $arrayCedulas = array();
        
        $repiteNombreCedulaExiste=TRUE;
        
        $campoNull=TRUE;
        $tipoDocumento=TRUE;
        
        $validarNumericoA = TRUE;
        $validarNumericoTT = TRUE;
        
        // alerta de edad
        $alertaEdad=TRUE;
        
        // alerta con el caracter del correo
        $correoConfirmado=TRUE;
        
        // alerta de repetir cargos asociados en la celda
        $repiteCargoAsociado=TRUE;
        
                                /// reemplazamos todas las tildes
                                function eliminar_acentos($centroTrabajo){
		
                            		//Reemplazamos la A y a
                            		$centroTrabajo = str_replace(
                            		array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
                            		array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
                            		$centroTrabajo
                            		);
                            
                            		//Reemplazamos la E y e
                            		$centroTrabajo = str_replace(
                            		array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
                            		array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
                            		$centroTrabajo );
                            
                            		//Reemplazamos la I y i
                            		$centroTrabajo = str_replace(
                            		array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
                            		array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
                            		$centroTrabajo );
                            
                            		//Reemplazamos la O y o
                            		$centroTrabajo = str_replace(
                            		array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
                            		array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
                            		$centroTrabajo );
                            
                            		//Reemplazamos la U y u
                            		$centroTrabajo = str_replace(
                            		array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
                            		array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
                            		$centroTrabajo );
                            
                            		//Reemplazamos la N, n, C y c
                            		$centroTrabajo = str_replace(
                            		array('Ñ', 'ñ', 'Ç', 'ç'),
                            		array('N', 'n', 'C', 'c'),
                            		$centroTrabajo
                            		);
                            		
                            		//Reemplazamos ;; por ;
                            		$centroTrabajo = str_replace(
                            		array(';;',';;;'),
                            		array(';',';'),
                            		$centroTrabajo
                            		);
                            		
                            		return $centroTrabajo;
                            	}
                            
                            
                            	
            // alerta de repetir cargos asociados en la celda
        $repiteGrupos=TRUE;
         /// reemplazamos todas las tildes
                                function eliminar_acentos_grupos($grupos){
		
                            		//Reemplazamos la A y a
                            		$grupos = str_replace(
                            		array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
                            		array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
                            		$grupos
                            		);
                            
                            		//Reemplazamos la E y e
                            		$grupos = str_replace(
                            		array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
                            		array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
                            		$grupos );
                            
                            		//Reemplazamos la I y i
                            		$grupos = str_replace(
                            		array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
                            		array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
                            		$grupos );
                            
                            		//Reemplazamos la O y o
                            		$grupos = str_replace(
                            		array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
                            		array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
                            		$grupos );
                            
                            		//Reemplazamos la U y u
                            		$centroTrabajo = str_replace(
                            		array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
                            		array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
                            		$grupos );
                            
                            		//Reemplazamos la N, n, C y c
                            		$centroTrabajo = str_replace(
                            		array('Ñ', 'ñ', 'Ç', 'ç'),
                            		array('N', 'n', 'C', 'c'),
                            		$grupos
                            		);
                            		
                            		//Reemplazamos ;; por ;
                            		$grupos = str_replace(
                            		array(';;',';;;'),
                            		array(';',';'),
                            		$grupos
                            		);
                            		
                            		return $grupos;
                            	}
                            	
        // fecha
        $alertaFechaPermitida=TRUE;                	
                            	
                            	
                            	
        $sheetCount = count($Reader->sheets());
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
            $contador=0;
            $contadorFecha=0;
            $string="";
            $stringB="";
            $contador_repetido_celda_cargos_asociadosA=0;
            $contador_repetido_celda_cargos_asociadosB=0;
            foreach ($Reader as $Row)
            {
           $contador++;
          
                if($Row[14]=='Para agregar varios grupos de distribución utilice ";"  entre grupos de distribución y sin espacios.'){ continue;} //Aca remplazo por el nombre y posicion de la ultima columna de excel para que no me agrege la primera fila.
                
                
                $nombre = "";
                if(isset($Row[0])) {
                    $nombre = mysqli_real_escape_string($con,$Row[0]);
                     $nombre. ': ';
                     if($nombre == ""){
                        $campoNull = FALSE; 
                         $mensajeCampoVacio='en la columna nombre';
                     }
                }
                
                $apellido = "";
                if(isset($Row[1])) {
                    $apellido = mysqli_real_escape_string($con,$Row[1]);
                     //$apellido. ': ';
                     if($apellido == ""){
                        $campoNull = FALSE; 
                         $mensajeCampoVacio='en la columna apellido';
                     }
                }
                
                $tipo = "";
                if(isset($Row[2])) {
                    $tipo = mysqli_real_escape_string($con,$Row[2]);
                    $tipo=trim($tipo);
                     if($tipo == ""){ 
                        $campoNull = FALSE; 
                        $mensajeCampoVacio='en la columna tipo de documento';
                     }else{ 
                         $tipo=mb_strtolower($tipo);
                        if($tipo == 'CC' || $tipo == 'cc'){
                            $tipoEnviar='C';
                        }elseif($tipo == 'CE' || $tipo == 'ce'){
                            $tipoEnviar='E';
                        }else{ 
                            $tipoDocumento=FALSE;
                        }
                     }
                }

                $cedula = "";
                if(isset($Row[3])) {
                    
                    $cedula = mysqli_real_escape_string($con,$Row[3]);
                    
                    $cedula=trim($cedula);
                    if($cedula == ""){
                        $campoNull = FALSE; 
                         'acá: '.$cedula.'-';
                        $mensajeCampoVacio='en la columna documento de identidad';
                    }else{
                        
                        if(is_numeric($cedula)){
                        
                            $compararCedula=$cedula.$tipoEnviar; //echo '<br>';
                             '<br>'.$compararCedula;
                            $validacion1 = $con->query("SELECT * FROM usuario WHERE cedula = '$compararCedula' ");//consulta a base de datos si el nombre se repite
                            $numNom = mysqli_num_rows($validacion1);
                            
                            if($numNom > 0){//si el nombre está repetido se pone falso
                                $repiteNombreCedulaExiste = FALSE;
                                //echo "<script>alert('se repite')</script>";
                            }
                            
                             "Cedula:".$cedula."<br>";
                            array_push($arrayCedulas,$cedula);
                            
                            if(in_array($cedula,$arrayCedulas)){
                                //echo "<script>alert('SE REPITEEE LA CEDULA EN EL ARCHIVO DE EXCEL')</script>";
                            }
                        }else{  ' (valor numerico cc: '.$cedula.') ';
                            $validarNumericoA=FALSE;
                        }
                    }
                }
              
                if(count($arrayCedulas) > count(array_unique($arrayCedulas))){//Valido si hay seriales repetidos
                   $repiteNombreCedula = FALSE;
                }
                
                $fecha = "";
                if(isset($Row[4])) {
                    $fecha = mysqli_real_escape_string($con,$Row[4]);
                    
                    if($fecha == ""){
                        $campoNull = FALSE; 
                        $mensajeCampoVacio='en la columna fecha de nacimiento';
                     }else{
                         
                        /// buscamos que solo deje entrar cierto formato de la fecha
                        $cadena_buscada_fecha = '-';
                        $posicion_coincidencia_fecha = strpos($fecha, $cadena_buscada_fecha);
                        
                        
                        /// validamos la cantidad de caracteres permitidos ha entrar
                        
                         'contando: '.strlen($fecha);
                        
                        if(strlen($fecha) > 10){
                            $alertaFechaPermitida=FALSE;
                        }else{
                            if($posicion_coincidencia_fecha === false){
                                $alertaFechaPermitida=FALSE;  '- entra en falso -';
                            }else{
                                 'Fecha:'.$fecha=str_replace("/","-",$fecha);
                            
                                /// validamos la fecha  del día del mes y del año
                                
                                /// validación de días evitando el 0  
                                 '<br>'.$validnadoEdad=substr($fecha,0,4);
                                if($validnadoEdad ==  0000 ){ 
                                    $enviarDatoAlerta=1;
                                    $alertaEdad=FALSE;
                                     '1 NO';
                                    
                                }else{
                                     '1 SI';
                                }
                                '<br>';
                                
                                /// validación de mes evitando el 0  
                                  '<br>'.$mesValidadoEntrante=substr($fecha,5,2);
                                if($mesValidadoEntrante >= 01 && $mesValidadoEntrante <= 12){
                                       '2 SI';
                                }else{ 
                                    $enviarDatoAlerta=1;
                                    $alertaEdad=FALSE;
                                      '2 NO';
                                   $string.='('.$fecha.') ';  
                                }
                                 '<br>';
                                 
                                /// validación de días evitando el 0  
                                 '<br>'.$diaValidadoEntranteValidar=substr($fecha,8,2);
                                if($diaValidadoEntranteValidar >= 01 && $diaValidadoEntranteValidar <= 31){
                                      '3 SI';
                                }else{ 
                                    $enviarDatoAlerta=1;
                                    $alertaEdad=FALSE;
                                      '3 NO';
                                    $stringB.='('.$fecha.') '; // agregamos cuando invierten la fecha y se van muchos 0000, ejemplo 12-03-2000, esa fecha está mal porque entiende los días como años
                                }
                                /// año
                                 '<br>';
                                
                                 date_default_timezone_set('America/Bogota');
                                 $fecha1=date('Y-m-j');
                                 
                                  '<br>'.$validnadoEdad=substr($fecha1,0,4);  '--';
                                  '<br>'.$mesValidado=substr($fecha1,5,2);
                                  '<br>'.$diaValidado=substr($fecha1,8,2);
                                  '<br>'.$resultadoFechaEdad=$validnadoEdad-18;
                                  
                                  
                                  
                                 if($diaValidado > 0 && $diaValidado < 10){
                                   $enviarCero='0';
                                 }
                                  
                                  $fechaValidadoUsuario=$resultadoFechaEdad.'-'.$mesValidado.'-'.$enviarCero.''.$diaValidado; 
                                  $resultadoFechaEdad.'-12-31';    
                                   '-- Fecha: '.$fecha;
                                   '<br>';
                                 
                                 
                                 if($fecha > $fechaValidadoUsuario || $enviarDatoAlerta == 1){ //$resultadoFechaEdad.'12-31' 
                                          '<font color="red">(</font>';
                                          $EnviarFechaEdad='('.$fecha.') ';
                                          '<font color="red">)</font>';
                                        $alertaEdad=FALSE;
                                        $contadorFecha++;
                                       
                                 }else{
                                    $alertaEdad=TRUE;
                                 }    '<br>';
                            }
                        }
                        
                        
                        
                     }
                    
                }
                
                $correo = "";
                if(isset($Row[5])) {
                    $correo = mysqli_real_escape_string($con,$Row[5]);
                    if($correo == ""){
                        $campoNull = FALSE; 
                        $mensajeCampoVacio='en la columna correo electrónico';
                     }else{
                        $cadena_buscada = '@';
                        $posicion_coincidencia = strpos($correo, $cadena_buscada);
                         
                        if ($posicion_coincidencia === false) {
                            //echo "NO se ha encontrado la palabra deseada!!!!"; echo ' - '.$cedula; echo '<br>';
                            $correoConfirmado=FALSE;
                        } else {
                            $correoConfirmado=TRUE;
                            //echo "Éxito!!! Se ha encontrado la palabra buscada en la posición: ".$posicion_coincidencia; echo ' - '.$cedula; echo '<br>';
                        }
                     }
                     
                }
                
                $telefono = "";
                if(isset($Row[6])) {
                    $telefono = mysqli_real_escape_string($con,$Row[6]);
                     if($telefono == ""){
                        $campoNull = FALSE; 
                        $mensajeCampoVacio='en la columna teléfono';
                     }else{
                         if(is_numeric($telefono)){
                             
                         }else{ //echo 'valor numerico teletono';
                            $validarNumericoTT=FALSE; 
                         }
                     }
                }
                
                
                $proceso = "";
                if(isset($Row[7])) {
                    $proceso = mysqli_real_escape_string($con,$Row[7]);
                    $proceso=trim($proceso);
                    if($proceso == ""){
                        $campoNull = FALSE;  
                        $mensajeCampoVacio='en la columna proceso';
                     }else{
                     
                        $array = explode(' ',$proceso);  // convierte en array separa por espacios;
                        $proceso ='';
                        // quita los campos vacios y pone un solo espacio
                        for ($i=0; $i < count($array); $i++) { 
                            if(strlen($array[$i])>0) {
                                $proceso.= ' ' . $array[$i];
                            }
                        }
                        
                        $proceso=trim($proceso);
                        
                        $validacionProceso = $con->query("SELECT * FROM procesos WHERE nombre = '$proceso'");
                        $extraerNombreProceso=$validacionProceso->fetch_array(MYSQLI_ASSOC);
                        $procesoE = $extraerNombreProceso['id'];
                        ' -- '.$extraerNombreProceso['nombre'];
                        '<br>';
                        $numProceso = mysqli_num_rows($validacionProceso);
                        
                        if($numProceso <= 0){
                            //si el nombre está repetido se pone falso 
                            $procesoValidar = FALSE;
                        }
                     }
                }
                
                $cargo = "";
                if(isset($Row[8])) {
                    $cargo = mysqli_real_escape_string($con,$Row[8]);
                      $cargo=trim($cargo);
                     if($cargo == ""){
                        $campoNull = FALSE; 
                        $mensajeCampoVacio='en la columna cargo';
                     }else{
                  
                        $array = explode(' ',$cargo);  // convierte en array separa por espacios;
                        $cargo ='';
                        // quita los campos vacios y pone un solo espacio
                        for ($i=0; $i < count($array); $i++) { 
                            if(strlen($array[$i])>0) {
                                $cargo.= ' ' . $array[$i];
                            }
                        }
                        
                        $cargo=trim($cargo); 
                        
                        $validacionCargo = $con->query("SELECT * FROM cargos WHERE nombreCargos = '$cargo'");
                        $extraerNombreCargo=$validacionCargo->fetch_array(MYSQLI_ASSOC);
                        $numCargo = mysqli_num_rows($validacionCargo);
                        
                        if($extraerNombreCargo['nombreCargos'] != NULL){
                         ' -- '.$extraerNombreCargo['nombreCargos']; 
                        'id cargo: '.$cargoE = $extraerNombreCargo['id_cargos'];
                        }else{
                        
                             ' Nombre cargo: '.$cargo.' -- <font color = "RED">Este cargo no existe en el sistema.</font> ';
                             '<br>';
                             $cargoValidar = FALSE;
                        }
                         '<br>';
                        if($numCargo <= 0){
                            //si el nombre está repetido se pone falso 
                           $cargoValidar = FALSE;
                            
                        }
                     }
                }
                
                $lider = "";
                if(isset($Row[9])) {
                    $lider = mysqli_real_escape_string($con,$Row[9]);
                     $lider=trim($lider);
                    
                    if($lider == ""){
                        $campoNull = FALSE; 
                        $mensajeCampoVacio='en la columna líder';
                     }else{
                    
                        $array = explode(' ',$lider);  // convierte en array separa por espacios;
                        $lider ='';
                        // quita los campos vacios y pone un solo espacio
                        for ($i=0; $i < count($array); $i++) { 
                            if(strlen($array[$i])>0) {
                                $lider.= ' ' . $array[$i];
                            }
                        }
                        
                        $lider=trim($lider);
                        
                        $validacionLider = $con->query("SELECT * FROM cargos WHERE nombreCargos = '$lider'");
                        $extraerNombreLider=$validacionLider->fetch_array(MYSQLI_ASSOC);
                        $numLider = mysqli_num_rows($validacionLider);
                        
                        if($extraerNombreLider['nombreCargos'] != NULL){
                            ' -- '.$extraerNombreLider['nombreCargos']; 
                        }else{
                        
                             ' Nombre del líder: '.$lider.' -- <font color = "RED">Este líder no existe en el sistema.</font> ';
                             '<br>';
                             $liderValidar = FALSE;
                        }
                         '<br>';
                        if($numLider <= 0){
                            //si el nombre está repetido se pone falso 
                            $liderValidar = FALSE;
                        }
                     }
                }
                
                $centroTrabajo = "";
                if(isset($Row[10])) {
                    $centroTrabajo = mysqli_real_escape_string($con,$Row[10]);
                     $centroTrabajo=trim($centroTrabajo);
                     if($centroTrabajo == ""){
                        $campoNull = FALSE; 
                        $mensajeCampoVacio='en la columna centro de trabajo';
                     }else{
                    
                                
                                /// volvemos el texto totalmente en minuscula
                                 $centroTrabajo=mb_strtolower($centroTrabajo);
                                 '<br>';
                                
                                // eliminamos los acentos
                                 $centroTrabajo=eliminar_acentos($centroTrabajo);
                                 '<br>';
                                
                                
                                
                                $arrayRecorrido = explode(' ',$centroTrabajo);  // convierte en array separa por espacios;
                                $centroTrabajo ='';
                                // quita los campos vacios y pone un solo espacio
                                for ($i=0; $i < count($arrayRecorrido); $i++) { 
                                    if(strlen($arrayRecorrido[$i])>0) {
                                        $centroTrabajo.= ' ' . $arrayRecorrido[$i];
                                    }
                                }
                                
                                 $centroTrabajo=trim($centroTrabajo); 
                                 '<br>';
                                
                                
                                 // quitamos los espacios al inicio del " 
                                $searchString = '; ';
                                $replaceString = ';';
                                $originalString = $centroTrabajo; 
                                '<br>';
                                 ' - ('.$outputString = str_replace($searchString, $replaceString, $originalString, $count); //echo ')';
                                //// end
                                
                                 // quitamos los espacios al final del " 
                                $f_searchString = ' ;';
                                $f_replaceString = ';';
                                $f_originalString = $outputString; 
                                '<br>';
                                 ' - ('.$f_outputString = str_replace($f_searchString, $f_replaceString, $f_originalString, $count); //echo ')';
                                //// end
                                
                                 // quitamos los espacios al final del " 
                                $f_searchStringPuntoComa = ';;';
                                $f_replaceStringPuntoComa = ';';
                                $f_originalStringPuntoComa = $f_outputString; 
                                '<br>';
                                 ' - ('.$f_outputString = str_replace($f_searchStringPuntoComa, $f_replaceStringPuntoComa, $f_originalStringPuntoComa, $count); //echo ')';
                                //// end
                                
                                 'sale: '.$centroTrabajo=$f_outputString;
                                  '<br>';
                                
                                
                                 ' -- ';
                                
                                ///// validando para separar los caracteres y subir los id
                                 $separarCT = explode(";", $centroTrabajo);
                               
                                
                                // leemos el array para verificar repetidos dentro de la celda
                                     $arreglo=$separarCT; //["Luis Miguel", "Pedro", "Luis Miguel"];
                                    if(count($arreglo) > count(array_unique($arreglo))){
                                       "¡Hay repetidos!";
                                      $repiteCargoAsociado=FALSE;
                                    }else{
                                       "No hay repetidos";
                                    }
                                /// end
                                
                                   '<br><br>';
                                
                                $tamanoArrayCT = count($separarCT);
                                
                                for($i =0; $i <= $tamanoArrayCT; $i++){
                                   
                                    if($separarCT[$i] == ""){
                                        
                                    }else{ 
                                       
                                        $validacionCentroTrabajo = $con->query("SELECT * FROM centrodetrabajo WHERE nombreCentrodeTrabajo = '$separarCT[$i]'");
                                        $extraerNombreCentroDeTrabajo=$validacionCentroTrabajo->fetch_array(MYSQLI_ASSOC);
                                        $numCentroTrabajo = mysqli_num_rows($validacionCentroTrabajo);
                                        
                                        if($extraerNombreCentroDeTrabajo['nombreCentrodeTrabajo'] != NULL){
                                             'Esta en el sistema: ('.$extraerNombreCentroDeTrabajo['nombreCentrodeTrabajo']; 
                                        }else{
                                             ' -- (dato del excel: '.$separarCT[$i].' )';
                                        }
                                        
                                        if($numCentroTrabajo <= 0){
                                            //si el nombre está repetido se pone falso 
                                            $centroTrabajoValidar = FALSE;
                                        }
                                        
                                    }
                                    
                                    
                                }
                                
                            
                     }
                }
                 '<br><br>';
               
                
                $arl = "";
                if(isset($Row[11])) {
                    $arl = mysqli_real_escape_string($con,$Row[11]);
                    
                     if($arl == ""){
                        $campoNull = FALSE; 
                        $mensajeCampoVacio='en la columna ARL';
                     }
                }
                
                
                $eps = "";
                if(isset($Row[12])) {
                    $eps = mysqli_real_escape_string($con,$Row[12]);
                     if($eps == ""){
                        $campoNull = FALSE; 
                        $mensajeCampoVacio='en la columna EPS';
                     }
                    
                }
                
                
                $afp = "";
                if(isset($Row[13])) {
                    $afp = mysqli_real_escape_string($con,$Row[13]);
                     if($afp == ""){
                        $campoNull = FALSE; 
                        $mensajeCampoVacio='en la columna AFP';
                     }
                    
                }
                
                $grupos = ""; 
                if(isset($Row[14])) {
                    
                    $grupos = mysqli_real_escape_string($con,$Row[14]);
                     $grupos=trim($grupos);
                     if($grupos == ""){
                        $campoNull = FALSE; 
                        $mensajeCampoVacio='en la columna grupos de distribución';
                     }else{
                               
                                
                                /// volvemos el texto totalmente en minuscula
                                 $grupos=mb_strtolower($grupos);
                                 '<br>';
                                // eliminamos los acentos
                                  $grupos=eliminar_acentos_grupos($grupos);
                                  '<br>';
                                 
                                 
                                 
                                $arrayRecorrido = explode(' ',$grupos);  // convierte en array separa por espacios;
                                $grupos ='';
                                // quita los campos vacios y pone un solo espacio
                                for ($i=0; $i < count($arrayRecorrido); $i++) { 
                                    if(strlen($arrayRecorrido[$i])>0) {
                                        $grupos.= ' ' . $arrayRecorrido[$i];
                                    }
                                }
                                
                                 $grupos=trim($grupos); 
                                 
                                 
                                 
                                 // quitamos los espacios al inicio del " 
                                $searchString = '; ';
                                $replaceString = ';';
                                $originalString = $grupos; 
                                '<br>';
                                 ' - ('.$outputString = str_replace($searchString, $replaceString, $originalString, $count); //echo ')';
                                //// end
                                
                                 // quitamos los espacios al final del " 
                                $f_searchString = ' ;';
                                $f_replaceString = ';';
                                $f_originalString = $outputString; 
                                '<br>';
                                 ' - ('.$f_outputString = str_replace($f_searchString, $f_replaceString, $f_originalString, $count); //echo ')';
                                //// end
                                
                                 'sale: '.$grupos=$f_outputString;
                                  '<br>';
                                 
                                 
                                 
                                 
                                 
                                 
                                ///// validando para separar los caracteres y subir los id
                                $separar = explode(";", $grupos);
                                
                                 // leemos el array para verificar repetidos dentro de la celda
                                     $arregloGrupo=$separar; 
                                    if(count($arregloGrupo) > count(array_unique($arregloGrupo))){
                                       "¡Hay repetidos!";
                                      $repiteGrupos=FALSE;
                                    }else{
                                       "No hay repetidos";
                                    }
                                /// end
                                 '<br><br>';
                               $tamanoArray = count($separar);
                                
                                for($i =0; $i <= $tamanoArray; $i++){
                                   
                                    if($separar[$i] == ""){
                                        
                                    }else{
                                        
                                      
                                         $separar[$i];  '<br>';
                                        $validacionGrupo = $con->query("SELECT * FROM grupo WHERE nombre = '$separar[$i]'")or die(mysqli_error($con));;
                                        $extraerNombreValidarGrupoDistri=$validacionGrupo->fetch_array(MYSQLI_ASSOC);
                                        $numGrupo = mysqli_num_rows($validacionGrupo);
                                        
                                        if($extraerNombreValidarGrupoDistri['nombre'] != NULL){
                                             ' -- '.$extraerNombreValidarGrupoDistri['nombre']; 
                                        }else{
                                        
                                             ' Grupos de distribución: '.$i.' '.$separar[$i].' -- <font color = "RED">Este grupo de distribución no existe en el sistema.</font> ';
                                             '<br>';
                                        }
                                        
                                        if($numGrupo <= 0){
                                            //si el nombre está repetido se pone falso 
                                            $centroGrupoValidar = FALSE; //FALSE
                                        }
                                        
                                    }
                                    
                                    
                                }
                                
                            
                    }
                }
                
                
              
                
                
            }
            
            
             // aca validamos que le documento viene vacio
            if($contador == 1){ 
                ?>
                                        <script> 
                                             window.onload=function(){
                                           
                                                document.forms["miformularioV"].submit();
                                             }
                                        </script>
                                         
                                        <form name="miformularioV" action="../../usuarios" method="POST" onsubmit="procesar(this.action);" >
                                            <input type="hidden" name="mensajeEnviarCampoVacio" value="<?php echo $mensajeCampoVacio;?>">
                                            <input type="hidden" name="validacionExisteImportacionVacio" value="1">
                                        </form> 
                                <?php
            }
           
            
            
        }
        
         
                for($i=0;$i<$sheetCount;$i++)
                {
                   
                    $Reader->ChangeSheet($i);
                    
                    foreach ($Reader as $Row)
                    {
                  
                        if($Row[14]=='Para agregar varios grupos de distribución utilice ";"  entre grupos de distribución y sin espacios.'){ continue;} //Aca remplazo por el nombre y posicion de la ultima columna de excel para que no me agrege la primera fila.
                  
                        $nombre = "";
                        if(isset($Row[0])) { 
                            $nombre = mysqli_real_escape_string($con,$Row[0]);
                            if($nombre == ""){ //echo '<br>buscando error nombre';
                                $campoNull = FALSE; 
                            }
                        }
                        
                        $apellido = "";
                        if(isset($Row[1])) { 
                            $apellido = mysqli_real_escape_string($con,$Row[1]);
                            if($apellido == ""){ //echo '<br>buscando error apellido';
                                $campoNull = FALSE; 
                            }
                        }
                        
                        
                        $tipo = "";
                        if(isset($Row[2])) { 
                            $tipo = mysqli_real_escape_string($con,$Row[2]);
                            
                            $tipo=trim($tipo);
                             if($tipo == ""){ //echo '<br>buscando error tipo';
                                $campoNull = FALSE; 
                             }else{
                                 $tipo=mb_strtolower($tipo);
                                if($tipo == 'CC' || $tipo == 'cc'){
                                    $tipoEnviar='C';
                                }elseif($tipo == 'CE' || $tipo == 'ce'){
                                    $tipoEnviar='E';
                                }else{
                                    $tipoDocumento=FALSE;
                                }
                             }
                        }
        
                        $cedula = "";
                        if(isset($Row[3])) { 
                           $cedula = mysqli_real_escape_string($con,$Row[3]);
                           $cedula=trim($cedula); 
                           if($cedula == ""){ //echo '<br>buscando error cedula';
                               $campoNull = FALSE;
                           }else{
                               
                           }
                        }
                        
                        $fecha = "";
                        if(isset($Row[4])) {
                            $fecha = mysqli_real_escape_string($con,$Row[4]);
                            
                            if($fecha == ""){
                                $campoNull = FALSE; 
                                $mensajeCampoVacio='en la columna fecha de nacimiento';
                             }else{
                                 
                                /// buscamos que solo deje entrar cierto formato de la fecha
                                $cadena_buscada_fecha = '-';
                                $posicion_coincidencia_fecha = strpos($fecha, $cadena_buscada_fecha);
                                
                                
                                /// validamos la cantidad de caracteres permitidos ha entrar
                                
                                 'contando: '.strlen($fecha);
                                
                                if(strlen($fecha) > 10){
                                    $alertaFechaPermitida=FALSE;
                                }else{
                                    if($posicion_coincidencia_fecha === false){
                                        $alertaFechaPermitida=FALSE;  '- entra en falso -';
                                    }else{
                                         'Fecha:'.$fecha=str_replace("/","-",$fecha);
                                    
                                        /// validamos la fecha  del día del mes y del año
                                        
                                        /// validación de días evitando el 0  
                                         '<br>'.$validnadoEdad=substr($fecha,0,4);
                                        if($validnadoEdad ==  0000 ){ 
                                            $enviarDatoAlerta=1;
                                            $alertaEdad=FALSE;
                                             '1 NO';
                                            
                                        }else{
                                             '1 SI';
                                        }
                                        '<br>';
                                        
                                        /// validación de mes evitando el 0  
                                          '<br>'.$mesValidadoEntrante=substr($fecha,5,2);
                                        if($mesValidadoEntrante >= 01 && $mesValidadoEntrante <= 12){
                                               '2 SI';
                                        }else{ 
                                            $enviarDatoAlerta=1;
                                            $alertaEdad=FALSE;
                                              '2 NO';
                                           //$string.='('.$fecha.') ';  
                                        }
                                         '<br>';
                                         
                                        /// validación de días evitando el 0  
                                        '<br>'.$diaValidadoEntranteValidar=substr($fecha,8,2);
                                        if($diaValidadoEntranteValidar >= 01 && $diaValidadoEntranteValidar <= 31){
                                             '3 SI';
                                        }else{ 
                                            $enviarDatoAlerta=1;
                                            $alertaEdad=FALSE;
                                             '3 NO';
                                            //$stringB.='('.$fecha.') '; // agregamos cuando invierten la fecha y se van muchos 0000, ejemplo 12-03-2000, esa fecha está mal porque entiende los días como años
                                        }
                                        /// año
                                         '<br>';
                                        
                                         date_default_timezone_set('America/Bogota');
                                         $fecha1=date('Y-m-j');
                                         
                                          '<br>'.$validnadoEdad=substr($fecha1,0,4);  '--';
                                          '<br>'.$mesValidado=substr($fecha1,5,2);
                                          '<br>'.$diaValidado=substr($fecha1,8,2);
                                          '<br>'.$resultadoFechaEdad=$validnadoEdad-18;
                                          
                                          
                                          
                                         if($diaValidado > 0 && $diaValidado < 10){
                                           $enviarCero='0';
                                         }
                                          
                                          $fechaValidadoUsuario=$resultadoFechaEdad.'-'.$mesValidado.'-'.$enviarCero.''.$diaValidado; 
                                          $resultadoFechaEdad.'-12-31';    
                                           '-- Fecha: '.$fecha;
                                           '<br>';
                                         
                                         
                                         if($fecha > $fechaValidadoUsuario || $enviarDatoAlerta == 1){ //$resultadoFechaEdad.'12-31' 
                                                 '<font color="red">(</font>';
                                                 //$EnviarFechaEdad='('.$fecha.') ';
                                                 '<font color="red">)</font>';
                                                $alertaEdad=FALSE;
                                               
                                         }else{
                                            $alertaEdad=TRUE;
                                         }   '<br>';
                                    }
                                }
                                
                                
                                
                             }
                            
                        }
                      
                        $correo = "";
                        if(isset($Row[5])) {
                            $correo = mysqli_real_escape_string($con,$Row[5]);
                            if($correo == ""){
                                $campoNull = FALSE; 
                             }else{
                                $cadena_buscada = '@';
                                $posicion_coincidencia = strpos($correo, $cadena_buscada);
                                 
                                if ($posicion_coincidencia === false) {
                                    //echo "NO se ha encontrado la palabra deseada!!!!"; echo ' - '.$cedula; echo '<br>';
                                    $correoConfirmado=FALSE;
                                } else {
                                    $correoConfirmado=TRUE;
                                    //echo "Éxito!!! Se ha encontrado la palabra buscada en la posición: ".$posicion_coincidencia; echo ' - '.$cedula; echo '<br>';
                                }
                             }
                             
                        }
                      
                        $telefono = "";
                        if(isset($Row[6])) { 
                            $telefono = mysqli_real_escape_string($con,$Row[6]);
                            if($telefono == ""){ //echo '<br>buscando error telefono';
                                $campoNull = FALSE; 
                             }else{
                                 if(is_numeric($telefono)){
                                     
                                 }else{ 
                                    $validarNumericoTT=FALSE; 
                                 }
                             }
                             
                        }
                        
                        $proceso = "";
                        if(isset($Row[7])) {
                            $proceso = mysqli_real_escape_string($con,$Row[7]);
                            $proceso=trim($proceso);
                            if($proceso == ""){
                                $campoNull = FALSE;  
                                $mensajeCampoVacio='en la columna proceso';
                             }else{
                             
                                $array = explode(' ',$proceso);  // convierte en array separa por espacios;
                                $proceso ='';
                                // quita los campos vacios y pone un solo espacio
                                for ($i=0; $i < count($array); $i++) { 
                                    if(strlen($array[$i])>0) {
                                        $proceso.= ' ' . $array[$i];
                                    }
                                }
                                
                                $proceso=trim($proceso);
                                
                                $validacionProceso = $con->query("SELECT * FROM procesos WHERE nombre = '$proceso'");
                                $extraerNombreProceso=$validacionProceso->fetch_array(MYSQLI_ASSOC);
                                $procesoE = $extraerNombreProceso['id'];
                                 ' -- '.$extraerNombreProceso['nombre'];
                                 '<br>';
                                $numProceso = mysqli_num_rows($validacionProceso);
                                
                                if($numProceso <= 0){
                                    //si el nombre está repetido se pone falso 
                                    $procesoValidar = FALSE;
                                }
                             }
                        }
                        
                        $cargo = "";
                        if(isset($Row[8])) { 
                             $cargo = mysqli_real_escape_string($con,$Row[8]);
                                $cargo=trim($cargo);
                                if($cargo == ""){ //echo '<br>buscando error cargo';
                                    $campoNull = FALSE; 
                                }else{
                                    
                                    $array = explode(' ',$cargo);  // convierte en array separa por espacios;
                                    $cargo ='';
                                    // quita los campos vacios y pone un solo espacio
                                    for ($i=0; $i < count($array); $i++) { 
                                        if(strlen($array[$i])>0) {
                                            $cargo.= ' ' . $array[$i];
                                        }
                                    }
                                    
                                    $cargo=trim($cargo);
                                    
                                    $extraeID = $con->query("SELECT * FROM cargos WHERE nombreCargos = '$cargo' ")or die(mysqli_error());  
                                    $rowId = $extraeID->fetch_array(MYSQLI_ASSOC);
                                     ' - id cargo: '.$cargoE = $rowId['id_cargos'];
                                }
                        }
                        
                        $lider = "";
                        if(isset($Row[9])) { 
                            $lider = mysqli_real_escape_string($con,$Row[9]);
                            $lider=trim($lider);
                            if($lider == ""){ //echo '<br>buscando error lider';
                                $campoNull = FALSE; 
                            }else{
                                
                                $array = explode(' ',$lider);  // convierte en array separa por espacios;
                                $lider ='';
                                // quita los campos vacios y pone un solo espacio
                                for ($i=0; $i < count($array); $i++) { 
                                    if(strlen($array[$i])>0) {
                                        $lider.= ' ' . $array[$i];
                                    }
                                }
                                
                                $lider=trim($lider);
                                
                                $extraeID = $con->query("SELECT * FROM cargos WHERE nombreCargos = '$lider' ")or die(mysqli_error());  
                                $rowId = $extraeID->fetch_array(MYSQLI_ASSOC);
                                $liderE = $rowId['id_cargos'];
                            }
                        }
                        
                        $centroTrabajo = "";
                        if(isset($Row[10])) { 
                            $centroTrabajo = mysqli_real_escape_string($con,$Row[10]);
                            if($centroTrabajo == ""){ //echo '<br>buscando error centro de trabajo';
                                $campoNull = FALSE; 
                            }else{
                                $centroTrabajo=trim($centroTrabajo);
                                $centroTrabajo=trim($centroTrabajo);
                            }
                        }
                        
                        
                        $arl = "";
                        if(isset($Row[11])) { 
                            $arl = mysqli_real_escape_string($con,$Row[11]);
                            if($arl == ""){ //echo '<br>buscando error arl';
                                $campoNull = FALSE; 
                            }
                        }
                        
                        
                        $eps = "";
                        if(isset($Row[12])) { 
                            $eps = mysqli_real_escape_string($con,$Row[12]);
                            if($eps == ""){ //echo '<br>buscando error eps';
                                $campoNull = FALSE; 
                            }
                        }
                        
                        
                        $afp = "";
                        if(isset($Row[13])) { 
                            $afp = mysqli_real_escape_string($con,$Row[13]);
                            if($afp == ""){ //echo '<br>buscando error afp';
                                $campoNull = FALSE; 
                            }
                        }
                        
                        
                        $grupos = "";
                        if(isset($Row[14])) { 
                            $grupos = mysqli_real_escape_string($con,$Row[14]);
                            $grupos=trim($grupos);
                            if($grupos == ""){ //echo '<br>buscando error grupo';
                                $campoNull = FALSE; 
                            }
                        }
                        
                        
                        $validarArchivo = "";
                        if(isset($Row[3])) {
                            $validarArchivo = mysqli_real_escape_string($con,$Row[3]);
                            if($validarArchivo == ""){ //echo '<br>buscando error archivo';
                                $campoNull = FALSE; 
                                $validarArchivo=1;
                            }else{
                                
                            }
                        }
                         
        				if($validarArchivo < 0 || $validarArchivo > 0){ // evitamos subir un archivo diferente
                        
                        
                         
                            
                           if($alertaFechaPermitida == FALSE || $repiteNombreCedulaExiste == FALSE || $repiteGrupos == FALSE || $repiteCargoAsociado == FALSE || $validarNumericoTT == FALSE || $correoConfirmado == FALSE || $alertaEdad == FALSE || $validarNumericoA == FALSE || $tipoDocumento == FALSE || $cedulaValidar == FALSE || $cargoValidar == FALSE || $liderValidar == FALSE || $procesoValidar == FALSE || $centroTrabajoValidar == FALSE || $centroGrupoValidar == FALSE || $repiteNombreCedula == FALSE || $campoNull == FALSE){ //$centroCostoValidar == FALSE || 
                             // echo 'Validaciones';
                             
                                if($validarNumericoA == FALSE){  //echo 'validando documento';
                                    $redireccionamientovalidarNumericoA=1;
                                }
                                 
                                if($tipoDocumento == FALSE){  //echo 'tipo de documento alerta';
                                     ?>
                                            <script> 
                                                 window.onload=function(){
                                               
                                                     document.forms["miformularioVacioTipoDocumento"].submit();
                                                 }
                                            </script>
                                            <form name="miformularioVacioTipoDocumento" action="../../usuarios" method="POST" onsubmit="procesar(this.action);" >
                                                <input type="hidden" name="Tipodocumeto" value="1">
                                            </form> 
                                    <?php
                                }
                                
                                 
                             
                                
                                if($repiteNombreCedulaExiste == FALSE){      //echo 'existe cc';
                                    ?>
                                            <script> 
                                                 window.onload=function(){
                                               
                                                     document.forms["miformularioRepiteExiste"].submit();
                                                 }
                                            </script>
                                             
                                            <form name="miformularioRepiteExiste" action="../../usuarios" method="POST" onsubmit="procesar(this.action);" >
                                                <input type="hidden" name="validacionExisteImportacionGExiste" value="1">
                                            </form> 
                                    <?php
                                }
                                
                                if($repiteNombreCedula == FALSE){      //echo 'repite cc';
                                    ?>
                                            <script> 
                                                 window.onload=function(){
                                               
                                                    document.forms["miformularioRepite"].submit();
                                                 }
                                            </script>
                                             
                                            <form name="miformularioRepite" action="../../usuarios" method="POST" onsubmit="procesar(this.action);" >
                                                <input type="hidden" name="validacionExisteImportacionG" value="1">
                                            </form> 
                                    <?php
                                }
                             
                                if($campoNull == FALSE){   //echo '<font color="red">campo vacio</font>';
                                    $redireccionamientoVacio=1;
                                   
                                }
                               
                               if($alertaEdad == FALSE){    //echo 'Alerta edad';
                                 $redirecionAlertaEdad=1;
                                
                                }
                                
                                if($alertaFechaPermitida == FALSE){
                                    $redireccionAlertaFechaPermitid=1;
                                }
                               
                                if($correoConfirmado == FALSE){  //echo 'Algunos correos no existen en el sistema';
                                    $enviarNotificaciponCorreo=1;
                                }
                                
                                if($validarNumericoTT == FALSE){  //echo 'validando telefono';
                                    $redireccionamientovalidarNumericoTT=1;
                                }
                                
                                if($procesoValidar == FALSE){  
                                    $redireccionamientoProceso = 1;
                                //echo 'Algunos procesos no existe en el sistema';
                                }
                                
                                if($cargoValidar == FALSE){   
                                   $redireccionamientoCargo = 1; 
                                   //echo 'Algunos cargos no existen en el sistema';
                                }
                                
                                if($liderValidar == FALSE){  
                                     $redireccionamientoLider = 1;
                                    //echo 'Algunos lideres no existe en el sistema';
                                }
                                
                                if($centroTrabajoValidar == FALSE){    
                                    $redireccionamientoCentroTrabajo = 1;
                                //echo 'Algunos centro de trabajo no existe en el sistema';
                                }
                                
                                if($repiteCargoAsociado == FALSE){ //echo 'entra acá cargo asociado repetidos en la celda';
                                    $activarCargoAsociadoRepetido=1  ; 
                                }
                                
                                if($repiteGrupos == FALSE){ // echo 'grupos repetidos en la celda';
                                    $actiarGruposRepetidos=1;
                                }
                                
                                
                                
                                
                                if($centroGrupoValidar == FALSE){  
                                //echo 'Algunos grupos no existe en el sistema';
                                $redireccionamietoRepiteGrupo=1;
                                }
                                
                           }else{
                               
                              //echo 'ante del registro: '.$contadorFecha;
                             
                             
                             if($contadorFecha > 0){
                                 //echo 'No permite guardar';
                                  //echo 'alerta edad<br>';
                                    ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformularioAlertaedadEnviar"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformularioAlertaedadEnviar" action="../../usuarios" method="POST" onsubmit="procesar(this.action);" >
                                         <?php
                                        // validamos si entra esta variable primero
                                        if($string != NULL){
                                        ?>
                                        <input name="variableFecha" value="<?php echo $string; ?>" type="hidden">
                                        <?php
                                        }elseif($stringB != NULL){
                                        ?>
                                        <input name="variableFecha" value="<?php echo $stringB; ?>" type="hidden">
                                        <?php
                                        }else{
                                        ?>
                                        <input name="variableFecha" value="<?php echo $EnviarFechaEdad; ?>" type="hidden">
                                        <?php
                                        }
                                        ?>
                                        <input type="hidden" name="alertaEdad" value="1">
                                    </form> 
                                    <?php
    
                             }else{
                                 
                             
                             
                             
                               
                                '<br><br><br>Registrar<br>';
                                
                            
                        
                                                
                                                $tituloA='Nuevo usuario creado';
                                                $mensajeA='Se crea usuario para el señor '.$nombre.' '.$apellido;
                                                
                                                date_default_timezone_set('America/Bogota');
                                                $fechaA=date('Y-m-j h:i:s A');
                                               
                                                
                                                $enviarCedulaTipo=$cedula.''.$tipoEnviar;
                                                
                                                '<br>documento'.$enviarCedulaTipo;  '<br>';
                                                // retiramos el punto en caso que venga para almacenar el dato
                                                '<br>Retirando: '.$enviarCedulaTipo=str_replace(".","",$enviarCedulaTipo);
                    
                    
                    
                    
                                                    /// volvemos el texto totalmente en minuscula
                                                     $grupos=mb_strtolower($grupos);
                                                     '<br>';
                                                    // eliminamos los acentos
                                                      $grupos=eliminar_acentos_grupos($grupos);
                                                      '<br>';
                                                     
                                                     
                                                     
                                                    $arrayRecorrido = explode(' ',$grupos);  // convierte en array separa por espacios;
                                                    $grupos ='';
                                                    // quita los campos vacios y pone un solo espacio
                                                    for ($i=0; $i < count($arrayRecorrido); $i++) { 
                                                        if(strlen($arrayRecorrido[$i])>0) {
                                                            $grupos.= ' ' . $arrayRecorrido[$i];
                                                        }
                                                    }
                                                    
                                                     $grupos=trim($grupos);
                                                     
                                                     // quitamos los espacios al inicio del " 
                                                    $searchString = '; ';
                                                    $replaceString = ';';
                                                    $originalString = $grupos; 
                                                    '<br>';
                                                     ' - ('.$outputString = str_replace($searchString, $replaceString, $originalString, $count); //echo ')';
                                                    //// end
                                                    
                                                     // quitamos los espacios al final del " 
                                                    $f_searchString = ' ;';
                                                    $f_replaceString = ';';
                                                    $f_originalString = $outputString; 
                                                    '<br>';
                                                     ' - ('.$f_outputString = str_replace($f_searchString, $f_replaceString, $f_originalString, $count); //echo ')';
                                                    //// end
                                                    
                                                     'sale: '.$grupos=$f_outputString;
                                                      '<br>';
                                          
                                                     
                                                     
                                                    
                                                    
                                                    $separar = explode(";", $grupos);
                                                    $tamanoArray = count($separar);
                                                   
                                                            
                                                         
                                                    
                                                    for($i =0; $i <= $tamanoArray; $i++){
                                                       
                                                        if($separar[$i] == ""){
                                                            
                                                        }else{
                                                            
                                                            $nombreGrupo = $separar[$i];
                                                            //echo $separar[$i]." ".$i."<br>";
                                                            
                                                            
                                                            
                                                            
                                                             'entra G:'.$nombreGrupo; 
                                                            $validacionGrupo = $con->query("SELECT * FROM grupo WHERE nombre = '$nombreGrupo'");
                                                            $numGrupo = mysqli_num_rows($validacionGrupo);
                                                            
                                                            if($numGrupo > 0){
                                                                
                                                                //echo "si es valido el grupo";
                                                                
                                                                $extraeID = $con->query("SELECT * FROM grupo WHERE nombre = '$nombreGrupo'")or die(mysqli_error());  
                                                                $rowId = $extraeID->fetch_array(MYSQLI_ASSOC);
                                                                $idGrupo = $rowId['id'];
                                                                
                                                                  " sale(:".$idGrupo.")<br>";
                                                                  "cedula: ".$cedula."<br>";
                                                                
                                                                $query3 = "INSERT INTO grupoUusuario (idGrupo,idUsuario)
                                                                VALUES('$idGrupo','$enviarCedulaTipo')";
                                                                $resultados = mysqli_query($con, $query3)or die(mysqli_error($con));
                                                                
                                                            }
                                                            
                                                        }
                                                        
                                                        
                                                    }            
                                              
                                              
                                              
                                              
                                              
                                                    /// volvemos el texto totalmente en minuscula
                                                     $centroTrabajo=mb_strtolower($centroTrabajo);
                                                     '<br>';
                                                    
                                                    // eliminamos los acentos
                                                     $centroTrabajo=eliminar_acentos($centroTrabajo);
                                                     '<br>';
                                                    
                                                    
                                                    
                                                    $arrayRecorrido = explode(' ',$centroTrabajo);  // convierte en array separa por espacios;
                                                    $centroTrabajo ='';
                                                    // quita los campos vacios y pone un solo espacio
                                                    for ($i=0; $i < count($arrayRecorrido); $i++) { 
                                                        if(strlen($arrayRecorrido[$i])>0) {
                                                            $centroTrabajo.= ' ' . $arrayRecorrido[$i];
                                                        }
                                                    }
                                                    
                                                     $centroTrabajo=trim($centroTrabajo); 
                                                     '<br>';
                                                    
                                                    
                                                     // quitamos los espacios al inicio del " 
                                                    $searchString = '; ';
                                                    $replaceString = ';';
                                                    $originalString = $centroTrabajo; 
                                                    '<br>';
                                                     ' - ('.$outputString = str_replace($searchString, $replaceString, $originalString, $count); //echo ')';
                                                    //// end
                                                    
                                                     // quitamos los espacios al final del " 
                                                    $f_searchString = ' ;';
                                                    $f_replaceString = ';';
                                                    $f_originalString = $outputString; 
                                                    '<br>';
                                                     ' - ('.$f_outputString = str_replace($f_searchString, $f_replaceString, $f_originalString, $count); //echo ')';
                                                    //// end
                                                    
                                                     // quitamos los espacios al final del " 
                                                    $f_searchStringPuntoComa = ';;';
                                                    $f_replaceStringPuntoComa = ';';
                                                    $f_originalStringPuntoComa = $f_outputString; 
                                                    '<br>';
                                                     ' - ('.$f_outputString = str_replace($f_searchStringPuntoComa, $f_replaceStringPuntoComa, $f_originalStringPuntoComa, $count); //echo ')';
                                                    //// end
                                                    
                                                     'sale: '.$centroTrabajo=$f_outputString;
                                                      '<br>';
                                                    
                                              
                                              
                                              
                                                    $centroTrabajo=trim($centroTrabajo);
                                                    $separarCT = explode(";", $centroTrabajo);
                                                    $tamanoArrayCT = count($separarCT);
                                                    //$centroTrabajo
                                                    for($i =0; $i <= $tamanoArrayCT; $i++){
                                                       
                                                        if($separarCT[$i] == ""){
                                                            
                                                        }else{
                                                            
                                                            $nombreCentroTrabajoValidar = $separarCT[$i];
                                                            //echo $separar[$i]." ".$i."<br>";
                                                            
                                                            $validacionCentroTrabajoV = $con->query("SELECT * FROM centrodetrabajo WHERE nombreCentrodeTrabajo = '$nombreCentroTrabajoValidar'");
                                                            $numCentrotrabajoV = mysqli_num_rows($validacionCentroTrabajoV);
                                                            
                                                            if($numCentrotrabajoV > 0){
                                                                
                                                                //echo "si es valido el grupo";
                                                                
                                                                $extraeIDCentroTrabajo = $con->query("SELECT * FROM centrodetrabajo WHERE nombreCentrodeTrabajo  = '$nombreCentroTrabajoValidar'")or die(mysqli_error());  
                                                                $rowId = $extraeIDCentroTrabajo->fetch_array(MYSQLI_ASSOC);
                                                                $idCentroTrabajo = $rowId['id_centrodetrabajo'];
                                                                
                                                                   "-".$idCentroTrabajo."<br>";
                                                                  "cedula: ".$enviarCedulaTipo."<br>";
                                                                
                                                                $query3CentroTrabajo = "INSERT INTO cTrabajoUusuario (idCtrabajo,idUsuario)
                                                                VALUES('$idCentroTrabajo','$enviarCedulaTipo')";
                                                                $resultados = mysqli_query($con, $query3CentroTrabajo)or die(mysqli_error($con));
                                                                
                                                            }
                                                            
                                                        }
                                                        
                                                        
                                                    } 
                                                    
                                        
                                            // validamos que está activado el ip sesion para navegar sobre la ip de la empresa
                                                $consultaClienteSescion=$con->query("SELECT * FROM cliente ");
                                                $extraerClienteSesion=$consultaClienteSescion->fetch_array(MYSQLI_ASSOC);
                                                
                                                if($extraerClienteSesion['sesion'] == 'Si'){
                                                    $direccionIPEmpresa=$_SERVER['REMOTE_ADDR'];
                                                }
                                                if($extraerClienteSesion['sesion'] == 'No'){
                                                    $direccionIPEmpresa='NULL';
                                                }
                                            //
                            
                                             
                                            
                                            $query = "INSERT INTO usuario (nombres,apellidos,cedula,telefono,correo,cargo,lider,fechaNacimiento,proceso,arl,eps,afp,clave,estadoEliminado,sesionIP,estadoUsuario,contadorSesion,correos)
                                            VALUES('$nombre','$apellido','$enviarCedulaTipo','$telefono','$correo','$cargoE','$liderE','$fecha','$procesoE','$arl','$eps','$afp','$cedula','0','$direccionIPEmpresa','desconectado','0','1')";
                                            $resultados = mysqli_query($con, $query)or die(mysqli_error($con));
                                            
                                            $nombreCompleto=$nombre.' '.$apellido;
                                            $agora = date('Y-m-d H:i:s');
                        					$limite = date('Y-m-d H:i:s', strtotime('+2 min'));
                        					
                        					$con->query("INSERT INTO chat_users (username,password,current_session,online)VALUES('$nombre','$enviarCedulaTipo','0','0' ) ")or die(mysqli_error($con));
                                            
                                            ?>
                                                <script> 
                                                     window.onload=function(){
                                                         //alert("Importado con éxito");
                                                         document.forms["miformularioCorreos"].submit();
                                                     }
                                                </script>
                                                 
                                                <form name="miformularioCorreos" action="correos" method="POST" onsubmit="procesar(this.action);" > <!--  importacion/importar-usuario/correos   -->
                                                    <input type="hidden" name="validacionAgregar" value="1">
                                                </form> 
                                            <?php
                                        
                                    }              
                           }//end else  
                         
                        }else{ 
                           
                                        ?>
                                                <script> 
                                                     window.onload=function(){
                                                     //alert("Archivo diferente");
                                                         document.forms["miformularioArchivoequivocado"].submit();
                                                     }
                                                </script>
                                                 
                                                <form name="miformularioArchivoequivocado" action="../../usuarios" method="POST" onsubmit="procesar(this.action);" >
                                                    <input type="hidden" name="validacionExisteImportacionI" value="1">
                                                </form> 
                                        <?php
            				
                        } /// evita subir otro archivo
                     }
                
                 }//end for
            
  }
  else
  { 
        $type = "error";
        $message = "El archivo enviado es invalido. Por favor vuelva a intentarlo";
  }
}



    if(!empty($type)) {
        
        
         $type . " display-block"; 
        
    } 
    
   
    if($redirecionAlertaEdad == 1){ //echo 'alerta edad<br>';
        ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformularioAlertaedadEnviar"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformularioAlertaedadEnviar" action="../../usuarios" method="POST" onsubmit="procesar(this.action);" >
                                        <?php
                                        // validamos si entra esta variable primero
                                        if($string != NULL){
                                        ?>
                                        <input name="variableFecha" value="<?php echo $string; ?>" type="hidden">
                                        <?php
                                        }elseif($stringB != NULL){
                                        ?>
                                        <input name="variableFecha" value="<?php echo $stringB; ?>" type="hidden">
                                        <?php
                                        }else{
                                        ?>
                                        <input name="variableFecha" value="<?php echo $EnviarFechaEdad; ?>" type="hidden">
                                        <?php
                                        }
                                        ?>
                                        <input type="hidden" name="alertaEdad" value="1">
                                    </form> 
                            <?php
    }
   
    if($redireccionAlertaFechaPermitid == 1){ //echo 'alerta fecha<br>';
        ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformularioAlertaedadFechaPermitida"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformularioAlertaedadFechaPermitida" action="../../usuarios" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="alertaFechaPermitida" value="1">
                                    </form> 
                            <?php
    }
   
    if($redireccionamientoVacio == 1){
    ?>
        <script> 
             window.onload=function(){
           
                 document.forms["miformularioVacioCampoVacio"].submit();
             }
        </script>
        <form name="miformularioVacioCampoVacio" action="../../usuarios" method="POST" onsubmit="procesar(this.action);" >
             <input type="hidden" name="mensajeEnviarCampoVacio" value="<?php echo $mensajeCampoVacio;?>">
            <input type="hidden" name="validacionExisteImportacionVacio" value="1">
        </form> 
    <?php
    }
    
    if($redireccionamientovalidarNumericoA == 1){ //echo 'documento no valido';
        ?>
        <script> 
             window.onload=function(){
           
                 document.forms["miformularioValidandoDocumentoNumericoNoValido"].submit();
             }
        </script>
        <form name="miformularioValidandoDocumentoNumericoNoValido" action="../../usuarios" method="POST" onsubmit="procesar(this.action);" >
            <input type="hidden" name="noesNumerico" value="1">
        </form> 
        <?php
    }
    
    
    if($enviarNotificaciponCorreo == 1){
    ?>
        <script> 
             window.onload=function(){
           
                 document.forms["miformularioVacioCorreo"].submit();
             }
        </script>
        <form name="miformularioVacioCorreo" action="../../usuarios" method="POST" onsubmit="procesar(this.action);" >
            <input type="hidden" name="alertaConfirmacionCorreo" value="1">
        </form> 
    <?php
    }
    
    
    if($redireccionamientovalidarNumericoTT == 1){ //echo 'mensaje telefono';
        ?>
        <script> 
             window.onload=function(){
           
                 document.forms["ValidandoDocumento"].submit();
             }
        </script>
        <form name="ValidandoDocumento" action="../../usuarios" method="POST" onsubmit="procesar(this.action);" >
            <input type="hidden" name="noesNumericoT" value="1">
        </form> 
        <?php
    }
    
    if($redireccionamientoProceso == 1){ //echo '<font color="blue">Proceso</font>';
    ?>
                                    <script> 
                                         window.onload=function(){
                                     
                                             document.forms["miformularioProceso"].submit();
                                         }
                                    </script>
                                    <form name="miformularioProceso" action="../../usuarios" method="POST" onsubmit="procesar(this.action);" >
                                          <button type="submit" style="display:none;"> Regresar </button> <!-- style="color:white;background:#17a2b8;padding: .25rem .5rem;font-size: .875rem;line-height: 1.5;border-radius: .2rem;" -->
                                          <input type="hidden" name="validacionExisteImportacionC" value="1">
                                    </form> 
    <?php    
    }
    if ($redireccionamientoCargo == 1){ //echo '<font color="blue">Cargo</font>';
    ?>
                                    <script> 
                                         window.onload=function(){
                                     
                                             document.forms["miformularioCargos"].submit();
                                         }
                                    </script>
                                    <form name="miformularioCargos" action="../../usuarios" method="POST" onsubmit="procesar(this.action);" >
                                        <button type="submit" style="display:none;"> Regresar </button> <!--  style="color:white;background:#17a2b8;padding: .25rem .5rem;font-size: .875rem;line-height: 1.5;border-radius: .2rem;" -->
                                        <input type="hidden" name="validacionExisteImportacionA" value="1">
                                    </form> 
                            <?php
    }
    
    if ($redireccionamientoLider == 1){ //echo '<font color="blue">Lider</font>';
    ?>
                                    <script> 
                                         window.onload=function(){
                                     
                                             document.forms["miformularioLider"].submit();
                                         }
                                    </script>
                                    <form name="miformularioLider" action="../../usuarios" method="POST" onsubmit="procesar(this.action);" >
                                        <button type="submit"  style="display:none;" > Regresar </button> <!-- style="color:white;background:#17a2b8;padding: .25rem .5rem;font-size: .875rem;line-height: 1.5;border-radius: .2rem;" -->
                                          <input type="hidden" name="validacionExisteImportacionB" value="1">
                                    </form> 
    <?php
    }
    
    if($redireccionamientoCentroTrabajo == 1){ //echo '<font color="blue">Centro de trabajo</font>';
    ?>
                                    <script> 
                                         window.onload=function(){
                                     
                                             document.forms["miformularioCentroTrabajo"].submit();
                                         }
                                    </script>
                                    <form name="miformularioCentroTrabajo" action="../../usuarios" method="POST" onsubmit="procesar(this.action);" >
                                          <button type="submit" style="display:none;"> Regresar </button> <!-- style="color:white;background:#17a2b8;padding: .25rem .5rem;font-size: .875rem;line-height: 1.5;border-radius: .2rem;" -->
                                          <input type="hidden" name="validacionExisteImportacionE" value="1">
                                    </form>
    <?php

    }
    
    if($activarCargoAsociadoRepetido == 1){
                                ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                            document.forms["miformularioRepiteDuenoPr"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformularioRepiteDuenoPr" action="../../usuarios" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionRepiteRepiteCentroTrabajo" value="1">
                                    </form> 
                                <?php
    }
    
    
    if($actiarGruposRepetidos == 1){
                                ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                            document.forms["miformularioRepiteGrupos"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformularioRepiteGrupos" action="../../usuarios" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionRepiteRepiteGruposDistri" value="1">
                                    </form> 
                                <?php 
    }
    /*
     if($redireccionamientoCentroCosto == 1){
    ?>
                                    <form name="miformularioCentroCostos" action="../../usuarios" method="POST" onsubmit="procesar(this.action);" >
                                          <button type="submit" style="color:white;background:#17a2b8;padding: .25rem .5rem;font-size: .875rem;line-height: 1.5;border-radius: .2rem;"> Regresar </button>
                                          <input type="hidden" name="validacionExisteImportacionD" value="1">
                                    </form> 
    <?php    
    }
    */
    
    if($redireccionamietoRepiteGrupo == 1){ //echo '<font color="blue">Repite grupo</font>';
    ?>    
                                    <script> 
                                         window.onload=function(){
                                     
                                             document.forms["miformularioReptieNombreCedula"].submit();
                                         }
                                    </script>
                                    <form name="miformularioReptieNombreCedula" action="../../usuarios" method="POST" onsubmit="procesar(this.action);" >
                                          <button type="submit" style="display:none;"> Regresar </button> <!-- style="color:white;background:#17a2b8;padding: .25rem .5rem;font-size: .875rem;line-height: 1.5;border-radius: .2rem;" -->
                                          <input type="hidden" name="validacionExisteImportacionF" value="1">
                                    </form>

    <?php
    }
        if($redirecionAlertaEdad <> 1 && $redireccionamientoCargo <> 1 && $redireccionamientoLider <> 1 && $redireccionamientoProceso <> 1 && /*$redireccionamientoCentroCosto <> 1 && */ $redireccionamientoCentroTrabajo <> 1 && $redireccionamietoRepiteGrupo <> 1 && $redireccionamientoVacio <> 1 && $redireccionamientovalidarNumericoA <> 1){
    
      
    ?>
    <br>
    <center>
                            <style>
                                .preloader {
                                    width: 70px;
                                    height: 70px;
                                    border: 10px solid #eee;
                                    border-top: 10px solid #666;
                                    border-radius: 50%;
                                    animation-name: girar;
                                    animation-duration: 2s;
                                    animation-iteration-count: infinite;
                                    animation-timing-function: linear;
                                    }
                                    @keyframes girar {
                                    from {
                                        transform: rotate(0deg);
                                    }
                                    to {
                                        transform: rotate(360deg);
                                    }
                                    }
                            </style> 
                            <div class="preloader"></div> Cargando
                        </center> 
                     
 <?php
    }   
 ?>                                                                   