<?php error_reporting(E_ERROR); error_reporting(0);
//IMPORTAR PROCESOS
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
        
        $sheetCount = count($Reader->sheets());
    
        //VARIABLES BOOLEANAS PARA VALIDACIONES    
        $repiteNombreProceso = TRUE; //Validar que no se repita nombre  
        $duenoProcesoExiste = TRUE; //Validar que el dueño del proceso exista
        $repitePrefijo = TRUE; //No se repita prefijo
        $macroProceso = TRUE;//Validar que exista macroproceso
        
        // nombre
        $campoNull = TRUE;
        $arrayNombres = array();
        $repiteNombre = TRUE;
        // END
        
        // prefijo
        $campoNullPrefijo = TRUE;
        $arrayPrefijo = array();
        $repitePrefijoArray = TRUE;
        // END
        
        // macroprocesos
        $macroProcesoMensaje=TRUE;
        
        $repiteDuenoProceso=TRUE;
        
        /// reemplazamos todas las tildes
                                function eliminar_acentos($asociados){
		
                            		//Reemplazamos la A y a
                            		$asociados = str_replace(
                            		array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
                            		array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
                            		$asociados
                            		);
                            
                            		//Reemplazamos la E y e
                            		$asociados = str_replace(
                            		array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
                            		array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
                            		$asociados );
                            
                            		//Reemplazamos la I y i
                            		$asociados = str_replace(
                            		array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
                            		array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
                            		$asociados );
                            
                            		//Reemplazamos la O y o
                            		$asociados = str_replace(
                            		array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
                            		array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
                            		$asociados );
                            
                            		//Reemplazamos la U y u
                            		$asociados = str_replace(
                            		array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
                            		array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
                            		$asociados );
                            
                            		//Reemplazamos la N, n, C y c
                            		$asociados = str_replace(
                            		array('Ñ', 'ñ', 'Ç', 'ç'),
                            		array('Ñ', 'ñ', 'C', 'c'),
                            		$asociados
                            		);
                            		
                            		//Reemplazamos ;; por ;
                            		$asociados = str_replace(
                            		array(';;',';;;'),
                            		array(';',';'),
                            		$asociados
                            		);
                            		
                            		return $asociados;
                            	}
                            	
                            	 function eliminar_acentosNombre($nombre){
		
                            		//Reemplazamos la A y a
                            		$nombre = str_replace(
                            		array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
                            		array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
                            		$nombre
                            		);
                            
                            		//Reemplazamos la E y e
                            		$nombre = str_replace(
                            		array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
                            		array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
                            		$nombre );
                            
                            		//Reemplazamos la I y i
                            		$nombre = str_replace(
                            		array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
                            		array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
                            		$nombre );
                            
                            		//Reemplazamos la O y o
                            		$nombre = str_replace(
                            		array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
                            		array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
                            		$nombre );
                            
                            		//Reemplazamos la U y u
                            		$nombre = str_replace(
                            		array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
                            		array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
                            		$nombre );
                            
                            		//Reemplazamos la N, n, C y c
                            		$nombre = str_replace(
                            		array('Ñ', 'ñ', 'Ç', 'ç'),
                            		array('Ñ', 'ñ', 'C', 'c'),
                            		$nombre
                            		);
                            		
                            		//Reemplazamos ;; por ;
                            		$nombre = str_replace(
                            		array(';;',';;;'),
                            		array(';',';'),
                            		$nombre
                            		);
                            		
                            		return $nombre;
                            	}
                            	
                            	function eliminar_acentosPrefijo($prefijo){
		
                            		//Reemplazamos la A y a
                            		$prefijo = str_replace(
                            		array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
                            		array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
                            		$prefijo
                            		);
                            
                            		//Reemplazamos la E y e
                            		$prefijo = str_replace(
                            		array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
                            		array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
                            		$prefijo );
                            
                            		//Reemplazamos la I y i
                            		$prefijo = str_replace(
                            		array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
                            		array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
                            		$prefijo );
                            
                            		//Reemplazamos la O y o
                            		$prefijo = str_replace(
                            		array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
                            		array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
                            		$prefijo );
                            
                            		//Reemplazamos la U y u
                            		$prefijo = str_replace(
                            		array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
                            		array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
                            		$prefijo );
                            
                            		//Reemplazamos la N, n, C y c
                            		$prefijo = str_replace(
                            		array('Ñ', 'ñ', 'Ç', 'ç'),
                            		array('Ñ', 'ñ', 'C', 'c'),
                            		$prefijo
                            		);
                            		
                            		//Reemplazamos ;; por ;
                            		$prefijo = str_replace(
                            		array(';;',';;;'),
                            		array(';',';'),
                            		$prefijo
                            		);
                            		
                            		return $prefijo;
                            	}
        
        /// variables para enviar el cargo asociado no existe
        $string_dueno_proceso='';
        
        $buscando_celda_macroproceso=1;
        $string_macroproceso='';
        
        
        // se declaran variables para el mensaje de caracteres
        $activarAlerta=TRUE;
        $enviarNombreString='';
        $enviarDescripcionString='';
        $enviarPrefijoString='';
        $enviarAsociadosString='';
        $enviarMacrprocesoString='';
        $activarAlertaEnter=TRUE; ///  variable declarada para el mensaje con campo enter
        
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
            $contador='0';
            foreach ($Reader as $Row)
            {
                $contador++;
          
                if($Row[4]=='Macroproceso'){ continue;} //Aca remplazo por el nombre y posicion de la ultima columna de excel para que no me agrege la primera fila.
          
                $nombre = "";
                if(isset($Row[0])) {
                    $nombre = mysqli_real_escape_string($con,$Row[0]);
                     $nombre=trim($nombre);
                    $contadorCeldaNombre++;
                    $buscandoEnterNombre++;
                    
                     /// volvemos el texto totalmente en minuscula
                                  $nombre=mb_strtolower($nombre);
                                 '<br>';
                                
                                // eliminamos los acentos
                                 $nombre=eliminar_acentosNombre($nombre);
                                 '<br>';
                    
                    //compruebo que los caracteres sean los permitidos
                        $nombre_carecteres=['"'];
                        for($bc=0; $bc<count($nombre_carecteres); $bc++){
                            $nombre_carecteres[$bc]; 
                             $cadena_carecteres_nombre = $nombre_carecteres[$bc];
                             ' - '.$coincidencia_caracteres= strpos($nombre, $cadena_carecteres_nombre);
                            if($coincidencia_caracteres != NULL){
                                $activarAlerta=FALSE;
                                $enviarNombreString.=$contadorCeldaNombre.', ';
                                $tipoValidacionNombre='1';
                            }
                             '<br>';
                        }
                        
                        if($tipoValidacionNombre == '1'){
                            
                        }else{
                            $permitidosNombre = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ ";
                               for ($i=0; $i<strlen($nombre); $i++){
                                  if (strpos($permitidosNombre, substr($nombre,$i,1))===false){
                                     $nombre . " no es válido<br>";
                                     $activarAlerta=FALSE;
                                     $tipoValidacionNombre='2';
                                     $enviarNombreStringL=$nombre;
                                     //return false;
                                  }
                               }
                               
                               //// validamos el enter antes de enviar la alerta
                                        $cadena_buscada_nombre = '\n';
                                        $posicion_coincidencia_nombre = strpos($nombre, $cadena_buscada_nombre);
                                        if($posicion_coincidencia_nombre === false){
                                           // echo 'si';
                                        }else{
                                           // echo 'no';
                                          $activarAlertaEnter=FALSE;
                                          $enviarResponsableStringNombre=$buscandoEnterNombre.',';
                                        }
                                    
                                        if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                            //echo 'enter encontrado';
                                            $enter_encontrado_nombre='1';
                                            $enviarNombreStringL=$enviarResponsableStringNombre;
                                        }else{
                                            $enviarNombreStringL;
                                        }
                                        
                                    /// end
                               
                        }
                        //// end
                        
                     $nombre = ucwords(strtolower($nombre));
                    
                    
                        $array = explode(' ',$nombre);  // convierte en array separa por espacios;
                        $nombre ='';
                        // quita los campos vacios y pone un solo espacio
                        for ($i=0; $i < count($array); $i++) { 
                            if(strlen($array[$i])>0) {
                                $nombre.= ' ' . $array[$i];
                            }
                        }
                        
                        $nombre=trim($nombre);
                    
                    
                    
                    $validacion1 = $con->query("SELECT * FROM procesos WHERE nombre = '$nombre' AND estado IS NULL ");//consulta a base de datos si el nombre se repite
                     $numNom = mysqli_num_rows($validacion1);
                    
                    if($numNom > 0){//si el nombre está repetido se pone falso
                        $repiteNombreProceso = FALSE;
                    }
                    
                    if($nombre == ""){
                        $campoNull = FALSE;
                        $mensajeCampoVacio='en la columna proceso';
                    }else{
                        array_push($arrayNombres,$nombre);
                    }
                    
                }
                
                $descripcion = "";
                if(isset($Row[1])) {
                    $descripcion = mysqli_real_escape_string($con,$Row[1]);
                    $contadorCeldaDescripcion++;
                    $buscandoEnterDescripcion++;
                    
                    if($descripcion == ""){
                        $campoNull = FALSE;
                        $mensajeCampoVacio='en la columna descripción';
                    }else{
                        $descripcion=mb_strtolower($descripcion);
                        
                        //compruebo que los caracteres sean los permitidos
                        $descripcion_carecteres=['"'];
                        for($bc=0; $bc<count($descripcion_carecteres); $bc++){
                            $descripcion_carecteres[$bc]; 
                             $cadena_carecteres_descripcion = $descripcion_carecteres[$bc];
                             ' - '.$coincidencia_caracteres= strpos($descripcion, $cadena_carecteres_descripcion);
                            if($coincidencia_caracteres != NULL){
                                $activarAlerta=FALSE;
                                $enviarDescripcionString.=$contadorCeldaDescripcion.', ';
                                $tipoValidacionDescripcion='1';
                            }
                             '<br>';
                        }
                        
                        if($tipoValidacionDescripcion == '1'){
                            
                        }else{
                            $permitidosdescripcion = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ.,:; ";
                               for ($i=0; $i<strlen($descripcion); $i++){
                                  if (strpos($permitidosdescripcion, substr($descripcion,$i,1))===false){
                                     $descripcion . " no es válido<br>";
                                     $activarAlerta=FALSE;
                                     $tipoValidacionDescripcion='2';
                                     $enviarDescripcionStringL=$descripcion;
                                     //return false;
                                  }
                               }
                               
                                    //// validamos el enter antes de enviar la alerta
                                        $cadena_buscada_descripcion = '\n';
                                        $posicion_coincidencia_descripcion = strpos($descripcion, $cadena_buscada_descripcion);
                                        if($posicion_coincidencia_descripcion === false){
                                           // echo 'si';
                                        }else{
                                           // echo 'no';
                                          $activarAlertaEnter=FALSE;
                                          $enviarResponsableStringDescripcion=$buscandoEnterDescripcion.',';
                                        }
                                    
                                        if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                            //echo 'enter encontrado';
                                            $enter_encontrado_descripcion='1';
                                            $enviarDescripcionStringL=$enviarResponsableStringDescripcion;
                                        }else{
                                            $enviarDescripcionStringL;
                                        }
                                        
                                    /// end
                        }
                        //// end
                    }
                }
                
                $dueno = "";
                if(isset($Row[2])) {
                    $dueno = mysqli_real_escape_string($con,$Row[2]);
                     $dueno=trim($dueno);
                     $contadorCeldaAsociados++;
                     $buscandoEnterDuenoProceso++;
                     $contandoCeldaCargosAsociados++;
                     
                    if($dueno == ""){
                        $campoNull = FALSE;
                        $mensajeCampoVacio='en la columna dueño de proceso';
                    }else{
                        
                         /// volvemos el texto totalmente en minuscula
                                $dueno=mb_strtolower($dueno);
                                '<br>';
                                
                                // eliminamos los acentos
                                $dueno=eliminar_acentos($dueno);
                                '<br>';
                        
                        //compruebo que los caracteres sean los permitidos
                        $asociados_carecteres=['"'];
                        for($bc=0; $bc<count($asociados_carecteres); $bc++){
                            $asociados_carecteres[$bc]; 
                             $cadena_carecteres_asociados = $asociados_carecteres[$bc];
                             ' - '.$coincidencia_caracteres= strpos($dueno, $cadena_carecteres_asociados);
                            if($coincidencia_caracteres != NULL){
                                $activarAlerta=FALSE;
                                'c: '.$enviarAsociadosString.=$contadorCeldaAsociados.', ';
                                $tipoValidacionAsociado='1';
                            }
                             '<br>';
                        }
                        
                        if($tipoValidacionAsociado == '1'){
                            
                        }else{
                            $permitidosAsociado = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ;,ñ ";
                               for ($i=0; $i<strlen($dueno); $i++){
                                  if (strpos($permitidosAsociado, substr($dueno,$i,1))===false){
                                     $dueno . " no es válido<br>";
                                     $activarAlerta=FALSE;
                                     $tipoValidacionAsociado='2';
                                     $enviarAsociadosStringL=$dueno;
                                     //return false;
                                  }
                               }
                                    
                                    //// validamos el enter antes de enviar la alerta
                                        $cadena_buscada_duenoProceso = '\n';
                                        $posicion_coincidencia_duenoProceso = strpos($dueno, $cadena_buscada_duenoProceso);
                                        if($posicion_coincidencia_duenoProceso === false){
                                           // echo 'si';
                                        }else{
                                           // echo 'no';
                                          $activarAlertaEnter=FALSE;
                                          $enviarResponsableStringDuenoProceso=$buscandoEnterDuenoProceso.',';
                                        }
                                    
                                        if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                            //echo 'enter encontrado';
                                            $enter_encontrado_duenoProceso='1';
                                            $enviarAsociadosStringL=$enviarResponsableStringDuenoProceso;
                                        }else{
                                            $enviarAsociadosStringL;
                                        }
                                        
                                    /// end
                        }
                        //// end 
                        
                        
                        $duenoS=trim($dueno); echo '<br>';
                        $separar = explode(";", $duenoS);
                        $duenoss=json_encode($separar,JSON_UNESCAPED_UNICODE);
                        $duenoss=str_replace(',""','',$duenoss);
                        
                        
                        $arrayRecorrido = explode(' ',$duenoss);  // convierte en array separa por espacios;
                        $duenoss ='';
                        // quita los campos vacios y pone un solo espacio
                        for ($i=0; $i < count($arrayRecorrido); $i++) { 
                            if(strlen($arrayRecorrido[$i])>0) {
                                $duenoss.= ' ' . $arrayRecorrido[$i];
                            }
                        }
                        
                        $duenoss=trim($duenoss);
                        
                         // quitamos los espacios al inicio del " 
                        $searchString = '" ';
                        $replaceString = '"';
                        $originalString = $duenoss; 
                        '<br>';
                        $outputString = str_replace($searchString, $replaceString, $originalString, $count); 
                        //// end
                        
                         // quitamos los espacios al final del " 
                        $f_searchString = ' "';
                        $f_replaceString = '"';
                        $f_originalString = $outputString; 
                        '<br>';
                        $f_outputString = str_replace($f_searchString, $f_replaceString, $f_originalString, $count); 
                        //// end
                        
                        $duenoss=$f_outputString;
                        $separar = json_decode ($duenoss);
                        
                        // leemos el array para verificar repetidos dentro de la celda
                            $arreglo =  $separar; 
                            if(count($arreglo) > count(array_unique($arreglo))){
                              //echo "¡Hay repetidos!";
                              $repiteDuenoProceso=FALSE;
                              for($i=0; $i<count($arreglo); $i++){
                                  //$duenossEnviarMensaje.=$arreglo[$i].', ';
                                  $sacandoVariableArregloCA=$arreglo[$i].',';
                              }
                                $duenossEnviarMensaje.='- En la celda '.($contandoCeldaCargosAsociados+1).' está '.$sacandoVariableArregloCA.'<br>'; /// sacamos en que celda y cuál es el nombre repetido
                            
                            }else{
                              //echo "No hay repetidos";
                            }
                        /// end
                        
                        $tamanoArray = count($separar);
                        
                        for($i=0; $i<$tamanoArray; $i++){
                             $separar[$i];
                            if($separar[$i] == ""){
                                                        
                            }else{
                                $arrayRecorrido = explode(' ',$separar[$i]);  // convierte en array separa por espacios;
                                $separar[$i] ='';
                                // quita los campos vacios y pone un solo espacio
                                for ($j=0; $j < count($arrayRecorrido); $j++) { 
                                    if(strlen($arrayRecorrido[$j])>0) {
                                        $separar[$i].= ' ' . $arrayRecorrido[$j];
                                    }
                                }
                                
                                $separar[$i]=trim($separar[$i]);
                                
                                
                                 
                                $extraeID = $con->query("SELECT * FROM cargos WHERE nombreCargos = '$separar[$i]' ");  
                                $rowIdDueno = $extraeID->fetch_array(MYSQLI_ASSOC);
                                $contandoDatosArray++; 
                                
                                $rowIdDueno['id_cargos']; 
                                $duenoss=json_encode($rowIdDueno['id_cargos']).',';
                                
                                    $verificacionExistencia=json_encode($rowIdDueno['id_cargos']); 
                                    if($verificacionExistencia == '[null]' || $verificacionExistencia == 'null'  || $verificacionExistencia == 'null,'){
                                        $duenoProcesoExiste=FALSE;
                                        $string_dueno_proceso.=$separar[$i].', ';
                                    }else{
                                    $contandoDatosArrayB++;    
                                    }
                                     '<br>';
                               
                            }
                        
                        }
                        
                       
                        
                    }
                    
                              
                }
				
                $prefijo = "";
                if(isset($Row[3])) {
                    
                    $prefijo = mysqli_real_escape_string($con,$Row[3]);
                    $prefijo=trim($prefijo);
                    $contadorCeldaPrefijo++;
                    $buscandoEnterPrefijo++;
                    
                    /// volvemos el texto totalmente en minuscula
                    $prefijo=mb_strtolower($prefijo);
                    '<br>';
                                
                    // eliminamos los acentos
                    $prefijo=eliminar_acentosPrefijo($prefijo);
                    '<br>';
                    
                    //compruebo que los caracteres sean los permitidos
                    $prefijo_carecteres=['"'];
                    for($bc=0; $bc<count($prefijo_carecteres); $bc++){
                        $prefijo_carecteres[$bc]; 
                         $cadena_carecteres_prefijo = $prefijo_carecteres[$bc];
                         ' - '.$coincidencia_caracteres= strpos($prefijo, $cadena_carecteres_prefijo);
                        if($coincidencia_caracteres != NULL){
                            $activarAlerta=FALSE;
                            $enviarPrefijoString.=$contadorCeldaPrefijo.', ';
                            $tipoValidacionPrefijo='1';
                        }
                         '<br>';
                    }
                    
                    if($tipoValidacionPrefijo == '1'){
                        
                    }else{ 
                        $permitidosPrefijo = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ ";
                           for ($i=0; $i<strlen($prefijo); $i++){
                              if (strpos($permitidosPrefijo, substr($prefijo,$i,1))===false){
                                 $prefijo . " no es válido<br>";
                                 $activarAlerta=FALSE;
                                 $tipoValidacionPrefijo='2';
                                 $enviarPrefijoStringL=$prefijo;
                                 //return false;
                              }
                           }
                           //// validamos el enter antes de enviar la alerta
                                        $cadena_buscada_prefijo = '\n';
                                        $posicion_coincidencia_prefijo = strpos($prefijo, $cadena_buscada_prefijo);
                                        if($posicion_coincidencia_prefijo === false){
                                           // echo 'si';
                                        }else{
                                           // echo 'no';
                                          $activarAlertaEnter=FALSE;
                                          $enviarResponsableStringPrefijo=$buscandoEnterPrefijo.',';
                                        }
                                    
                                        if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                            //echo 'enter encontrado';
                                            $enter_encontrado_prefijo='1';
                                            $enviarPrefijoStringL=$enviarResponsableStringPrefijo;
                                        }else{
                                            $enviarPrefijoStringL;
                                        }
                                        
                                    /// end
                    }
                    //// end
                     
                     $prefijo = ucwords(strtolower($prefijo));
                     
                        $array = explode(' ',$prefijo);  // convierte en array separa por espacios;
                        $prefijo ='';
                        // quita los campos vacios y pone un solo espacio
                        for ($i=0; $i < count($array); $i++) { 
                            if(strlen($array[$i])>0) {
                                $prefijo.= ' ' . $array[$i];
                            }
                        }
                        
                        $prefijo=trim($prefijo);
                     
                     
                    $validacion2 = $con->query("SELECT * FROM procesos WHERE prefijo = '$prefijo' AND estado IS NULL ");//consulta a base de datos si el nombre se repite
                    $numPre = mysqli_num_rows($validacion2);
                    
                    if($numPre > 0){//si el nombre está repetido se pone falso
                        $repitePrefijo = FALSE;
                    }
                    
                    if($prefijo == ""){
                        $campoNull = FALSE;
                        $mensajeCampoVacio='en la columna pefijo';
                    }else{
                        array_push($arrayPrefijo,$prefijo);
                    }
                    
                }
                

                $macroproceso = "";
                if(isset($Row[4])) {
                    $macroproceso = mysqli_real_escape_string($con,$Row[4]);
                    $macroproceso=trim($macroproceso);
                    $contadorCeldaMacroproceso++;
                    $buscandoEnterMacroproceso++;
                    
                    if($macroproceso == ""){
                        $campoNull = FALSE;
                        $mensajeCampoVacio='en la columna macroproceso';
                    }else{
                        
                        /// volvemos el texto totalmente en minuscula
                        $macroproceso=mb_strtolower($macroproceso);
                        '<br>';
                            $array = explode(' ',$macroproceso);  // convierte en array separa por espacios;
                            $macroproceso ='';
                            // quita los campos vacios y pone un solo espacio
                            for ($i=0; $i < count($array); $i++) { 
                                if(strlen($array[$i])>0) {
                                    $macroproceso.= ' ' . $array[$i];
                                }
                            }
                            
                            $macroproceso=trim($macroproceso);
                            
                            //compruebo que los caracteres sean los permitidos
                            $macroproceso_carecteres=['"'];
                            for($bc=0; $bc<count($macroproceso_carecteres); $bc++){
                                $macroproceso_carecteres[$bc]; 
                                 $cadena_carecteres_macroproceso = $macroproceso_carecteres[$bc];
                                 ' - '.$coincidencia_caracteres= strpos($macroproceso, $cadena_carecteres_macroproceso);
                                if($coincidencia_caracteres != NULL){
                                    $activarAlerta=FALSE;
                                    $enviaMacroprocesoString.=$contadorCeldaMacroproceso.', ';
                                    $tipoValidacionMacroproceso='1';
                                }
                                 '<br>';
                            }
                            
                            if($tipoValidacionMacroproceso == '1'){
                                
                            }else{ 
                                $permitidosMacroproceso = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ ";
                                   for ($i=0; $i<strlen($macroproceso); $i++){
                                      if (strpos($permitidosMacroproceso, substr($macroproceso,$i,1))===false){
                                         $macroproceso . " no es válido<br>";
                                         $activarAlerta=FALSE;
                                         $tipoValidacionMacroproceso='2';
                                         $enviarMacroprocesoStringL=$macroproceso;
                                         //return false;
                                      }
                                   }
                                   
                                   //// validamos el enter antes de enviar la alerta
                                        $cadena_buscada_macroproceso = '\n';
                                        $posicion_coincidencia_macroproceso = strpos($macroproceso, $cadena_buscada_macroproceso);
                                        if($posicion_coincidencia_macroproceso === false){
                                           // echo 'si';
                                        }else{
                                           // echo 'no';
                                          $activarAlertaEnter=FALSE;
                                          $enviarResponsableStringMacroproceso=$buscandoEnterMacroproceso.',';
                                        }
                                    
                                        if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                            //echo 'enter encontrado';
                                            $enter_encontrado_macroproceso='1';
                                            $enviarMacroprocesoStringL=$enviarResponsableStringMacroproceso;
                                        }else{
                                            $enviarMacroprocesoStringL;
                                        }
                                        
                                    /// end
                                    
                            }
                            //// end
                            
                            if($activarAlerta == FALSE){
                                
                            }else{
                                $validacion4 = $con->query("SELECT * FROM macroproceso WHERE nombre = '$macroproceso'");
                                $extraerMacro=$validacion4->fetch_array(MYSQLI_ASSOC);
                                $numMacroPro = mysqli_num_rows($validacion4);
                                
                                
                                 // validamos la celda que contiene el error
                                if($extraerMacro['id'] != NULL){
                                     (($buscando_celda_macroproceso++)+1); //echo $nivelCargo_validar;
                                }else{
                                     $string_macroproceso.=$macroproceso.', ';//(($buscando_celda_macroproceso++)+1).''; //echo $nivelCargo_validar;
                                }
                                
                                
                                if($numMacroPro < 1){
                                    $macroProcesoMensaje = FALSE;    
                                }
                            }
                        
                    }
                                    
                }
                

             }
             
              // aca validamos que le documento viene vacio
              
            'A: '.$contandoDatosArray;
            'B: '.$contandoDatosArrayB;
              
            if($contandoDatosArray <> $contandoDatosArrayB){
                                ?>
                                        <script> 
                                             window.onload=function(){
                                           
                                                document.forms["miformularioV"].submit();
                                             }
                                        </script>
                                         
                                        <form name="miformularioV" action="../../procesos" method="POST" onsubmit="procesar(this.action);" >
                                            <input type="hidden" name="mensajeEnviarCampoVacio" value="<?php echo $mensajeCampoVacio;?>">
                                            <input type="hidden" name="validacionExisteImportacionVacio" value="1">
                                        </form> 
                                <?php
            }  
            if($contador == 1){
                ?>
                                        <script> 
                                             window.onload=function(){
                                           
                                                document.forms["miformularioV"].submit();
                                             }
                                        </script>
                                         
                                        <form name="miformularioV" action="../../procesos" method="POST" onsubmit="procesar(this.action);" >
                                            <input type="hidden" name="mensajeEnviarCampoVacio" value="<?php echo $mensajeCampoVacio;?>">
                                            <input type="hidden" name="validacionExisteImportacionVacio" value="1">
                                        </form> 
                                <?php
            }
            // END
        
         }
        
        /// para el nombre
        if(count($arrayNombres) > count(array_unique($arrayNombres))){//Valido si hay seriales repetidos
          $repiteNombre = FALSE;
        }
        /// END
        /// para el prefijo
        if(count($arrayPrefijo) > count(array_unique($arrayPrefijo))){//Valido si hay seriales repetidos
          $repitePrefijoArray = FALSE;
        }
        /// END
        
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
            
            foreach ($Reader as $Row)
            {
          
                if($Row[4]=='Macroproceso'){ continue;} //Aca remplazo por el nombre y posicion de la ultima columna de excel para que no me agrege la primera fila.
          
                $nombre = "";
                if(isset($Row[0])) {
                   'Macro: '. $nombre = mysqli_real_escape_string($con,$Row[0]);
                    $nombre=trim($nombre);
                   
                   '<br>';
                        $array = explode(' ',$nombre);  // convierte en array separa por espacios;
                        $nombre ='';
                        // quita los campos vacios y pone un solo espacio
                        for ($i=0; $i < count($array); $i++) { 
                            if(strlen($array[$i])>0) {
                                $nombre.= ' ' . $array[$i];
                            }
                        }
                        
                        $nombre=trim($nombre);
                    
                }
                
                $descripcion = "";
                if(isset($Row[1])) {
                 'Descrip:'.$descripcion = mysqli_real_escape_string($con,$Row[1]);
                    '<br>';
                }
                
                $dueno = "";
                if(isset($Row[2])) {
                    'Dueño: '. $dueno = mysqli_real_escape_string($con,$Row[2]);
                    $dueno=trim($dueno);
                    '<br>';
                   
                    $separar = explode(";", $dueno);
                    $duenoo=json_encode($separar,JSON_UNESCAPED_UNICODE);
                    $duenoo=str_replace(',""','',$duenoo);
                   
                    $separar = explode(";", $dueno);
                   
                    $tamanoArray = count($separar);
                   
                    $cadena='';
                    for($i=0; $i<$tamanoArray; $i++){
                         $separar[$i];  '<br>';
                        if($separar[$i] == ""){
                                                    
                        }else{
                                 /*echo $enviarPalabra[$i]=str_replace('  ', ' ', $separar[$i]);
                                 echo strlen($separar[$i]);
                                 echo '<br>';
                                 echo strlen($enviarPalabra[$i]);
                                 */
                                 
                               $arrayRecorrido = explode(' ',$separar[$i]);  // convierte en array separa por espacios;
                                $separar[$i] ='';
                                // quita los campos vacios y pone un solo espacio
                                for ($j=0; $j < count($arrayRecorrido); $j++) { 
                                    if(strlen($arrayRecorrido[$j])>0) {
                                        $separar[$i].= ' ' . $arrayRecorrido[$j];
                                    }
                                }
                                
                                $separar[$i]=trim($separar[$i]);
                                 
                                 
                            $extraeID = $con->query("SELECT * FROM cargos WHERE nombreCargos = '$separar[$i]' ");  
                            $rowIdDueno = $extraeID->fetch_array(MYSQLI_ASSOC);
                            $duenoValidado = ''.json_encode($rowIdDueno['id_cargos']).',';
                            $cadena.=$duenoss=json_encode($rowIdDueno['id_cargos']).',';
                            
                              '<br>';
                                $verificacionExistencia=json_encode($rowIdDueno['id_cargos']); 
                                if($verificacionExistencia == '[null]' || $verificacionExistencia == 'null'  || $verificacionExistencia == 'null,'){
                                    $duenoProcesoExiste=FALSE;
                                }else{
                                    
                                }
                               // echo '<br>';
                           
                        }
                    
                    } 
                    $cadena;
                    
                    '<br>';
                    $duenoo;
                    $duenoo=str_replace('"",','',$duenoo);
                        
                                $arrayRecorrido = explode(' ',$duenoo);  // convierte en array separa por espacios;
                                $duenoo ='';
                                // quita los campos vacios y pone un solo espacio
                                for ($j=0; $j < count($arrayRecorrido); $j++) { 
                                    if(strlen($arrayRecorrido[$j])>0) {
                                        $duenoo.= ' ' . $arrayRecorrido[$j];
                                    }
                                }
                                
                                $duenoo=trim($duenoo);
                  
                    $duenoo; 
                }
				
                
                $prefijo = "";
                if(isset($Row[3])) {
                   'Pref: '.  $prefijo = mysqli_real_escape_string($con,$Row[3]);
                   $prefijo=trim($prefijo);
                   '<br>';
                   
                        $array = explode(' ',$prefijo);  // convierte en array separa por espacios;
                        $prefijo ='';
                        // quita los campos vacios y pone un solo espacio
                        for ($i=0; $i < count($array); $i++) { 
                            if(strlen($array[$i])>0) {
                                $prefijo.= ' ' . $array[$i];
                            }
                        }
                        
                        $prefijo=trim($prefijo);
                   
                }
                

                $macroproceso = "";
                if(isset($Row[4])) {
                    $macroproceso = mysqli_real_escape_string($con,$Row[4]);
                    $macroproceso=trim($macroproceso);
                    if($macroproceso == ""){
                        $campoNull = FALSE;
                    }else{
                        
                        
                            $array = explode(' ',$macroproceso);  // convierte en array separa por espacios;
                            $macroproceso ='';
                            // quita los campos vacios y pone un solo espacio
                            for ($i=0; $i < count($array); $i++) { 
                                if(strlen($array[$i])>0) {
                                    $macroproceso.= ' ' . $array[$i];
                                }
                            }
                            
                            $macroproceso=trim($macroproceso);
                            
                            
                            $validacion4 = $con->query("SELECT * FROM macroproceso WHERE nombre = '$macroproceso'");
                            $numMacroPro = mysqli_num_rows($validacion4);
                            
                            $extraeID2 = $con->query("SELECT id FROM macroproceso WHERE nombre = '$macroproceso'");  
                            $rowIdMacro = $extraeID2->fetch_array(MYSQLI_ASSOC);
                            'Macro:'.  $macroproceso = $rowIdMacro['id'];
                           
                            if($numMacroPro < 1){
                                $macroProcesoMensaje = FALSE;    
                            }
                    }
                }
                
               
                
                $validarArchivo = "";
                if(isset($Row[5])) {
                    $validarArchivo = mysqli_real_escape_string($con,$Row[5]);
                }
                
				if($validarArchivo != NULL){ // evitamos subir un archivo diferente
                ?>
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformulario"].submit();
                         }
                    </script>
                     
                    <form name="miformulario" action="../../procesos" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="validacionExisteImportacion" value="1">
                    </form> 
                <?php
                
				}else{
				   
                    if (!empty($nombre) || !empty($descripcion) || !empty($dueno) || !empty($prefijo) || !empty($macroproceso) ) {
                    
                        if($activarAlerta == FALSE || $repiteDuenoProceso == FALSE || $macroProcesoMensaje == FALSE || $repitePrefijoArray == FALSE || $repiteNombre == FALSE || $repiteNombreProceso == FALSE || $duenoProcesoExiste == FALSE || $repitePrefijo == FALSE || $macroProceso == FALSE || $campoNull == FALSE){
                            
                            if($activarAlerta == FALSE){ 
                            $enviarVariableAlerta=1;
                            }
                          
                           if($campoNull == FALSE){ //echo 'ErrorV';
                               ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                            document.forms["miformulario"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformulario" action="../../procesos" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="mensajeEnviarCampoVacio" value="<?php echo $mensajeCampoVacio;?>">
                                        <input type="hidden" name="validacionExisteImportacionVacio" value="1">
                                    </form> 
                                <?php
                           }
                           if($repiteDuenoProceso == FALSE){ 
                               $activarAlertaDuenoProceso=1;
                               /*
                            ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                            document.forms["miformularioRepiteDuenoPr"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformularioRepiteDuenoPr" action="../../procesos" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionRepiteDuenoProceso" value="1">
                                        <input type="" name="mensajeRepetidoDuenoProceso" value="<?php echo $duenossEnviarMensaje;?>">
                                    </form> 
                                <?php   
                                */
                           }
                           
                           if($macroProcesoMensaje == FALSE){
                               $ativar_alerta_macro=1;
                                /*?>
                                    <script> 
                                         window.onload=function(){
                                       
                                           // document.forms["miformularioMacroprocesos"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformularioMacroprocesos" action="../../procesos" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="" name="validacionExisteImportacionBMacro" value="1">
                                    </form> 
                                <?php*/
                            }
                            
                            if($repiteNombre == FALSE){
                               
                                ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                            document.forms["miformulario"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformulario" action="../../procesos" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionExisteImportacionB" value="1">
                                    </form> 
                                <?php
                            }
                            
                            if($repitePrefijoArray == FALSE){
                                
                                ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformulario"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformulario" action="../../procesos" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionExisteImportacionC" value="1">
                                    </form> 
                                <?php
                            }
                           
                            if($repiteNombreProceso == FALSE){
                                 
                                ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformulario"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformulario" action="../../procesos" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionExisteImportacionD" value="1">
                                    </form> 
                                <?php
                            }
                            
                            if($duenoProcesoExiste == FALSE){
                                $activando_alerta='1';
                                /*?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformulario"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformulario" action="../../procesos" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionExisteImportacionE" value="1">
                                    </form> 
                                <?php*/
                            }
                            
                            if($repitePrefijo == FALSE){
                                 
                                ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                            document.forms["miformulario"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformulario" action="../../procesos" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionExisteImportacionF" value="1">
                                    </form> 
                                <?php
                            }
                            
                            if($macroProceso == FALSE){
                                  
                                ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                           document.forms["miformulario"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformulario" action="../../procesos" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionExisteImportacionG" value="1">
                                    </form> 
                                <?php
                            }
                            
                            $type = "error";
                            $message = "ERROR";
                            /*
                            ?>
                                <script> 
                                     window.onload=function(){
                                   
                                        // document.forms["miformularioH"].submit();
                                     }
                                </script>
                                 
                                <form name="miformularioH" action="../../procesos" method="POST" onsubmit="procesar(this.action);" >
                                    <input type="hidden" name="validacionExisteImportacionH" value="1">
                                </form> 
                            <?php
                            */
                        
                            
                        }else{ 
                         
                       
                       
                       // echo 'registro<br>';
                       
                        
                        //// retiramos la ,] que sobra para almacenar solo el id
                        $duenoss='['.$cadena.']';
                         $duenoo=str_replace(',]',']',$duenoss);
                        //// end
                        
                        $query = "INSERT INTO procesos (nombre,descripcion,duenoProceso,prefijo,macroproceso,importacion)
                        VALUES('$nombre','$descripcion','$duenoo','$prefijo','$macroproceso','1')";
                        $resultados = mysqli_query($con, $query)or die(mysqli_error($con));
                        
                        
                        
                                $type = "success";
                                $message = "Excel importado correctamente";
                                ?>
                                <script> 
                                     window.onload=function(){
                                   
                                         document.forms["miformulario"].submit();
                                     }
                                </script>
                                 
                                <form name="miformulario" action="../../procesos" method="POST" onsubmit="procesar(this.action);" >
                                    <input type="hidden" name="validacionExisteImportacionExito" value="1">
                                </form> 
                                <?php
                           
                        }
                    
                     
                    
                    }
                
            } ////// para evitar que suban otro archivo
                
             }
        
         }
  }
  else
  { 
        $type = "error";
        $message = "El archivo enviado es invalido. Por favor vuelva a intentarlo";
  }
}


if($activando_alerta == 1){
    ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformularioAlerta"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformularioAlerta" action="../../procesos" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionExisteImportacionEMensaje" value="<?php echo $string_dueno_proceso;?>">
                                        <input type="hidden" name="validacionExisteImportacionE" value="1">
                                    </form> 
                                <?php
}
     
if($ativar_alerta_macro == '1'){
    ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                            document.forms["miformularioMacroprocesos"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformularioMacroprocesos" action="../../procesos" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionExisteImportacionBMacro" value="1">
                                        <input type="hidden" name="validacionExisteImportacionBMacroMEnsaje" value="<?php echo $string_macroproceso;?>">
                                    </form> 
                                <?php
} 
    
if($activarAlertaDuenoProceso == '1'){
?>
                                    <script> 
                                         window.onload=function(){
                                       
                                            document.forms["miformularioRepiteDuenoPr"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformularioRepiteDuenoPr" action="../../procesos" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionRepiteDuenoProceso" value="1">
                                        <input type="hidden" name="mensajeRepetidoDuenoProceso" value="<?php echo '<br>'.$duenossEnviarMensaje;?>">
                                    </form> 
                                <?php     
}

if($enviarVariableAlerta == '1'){ /// esta alerta debe activarse con todas las columnas
  
    //// agregamos todas las variables enviadas por columna
    if($enviarNombreString != NULL || $enviarNombreStringL != NULL){ 
        if($tipoValidacionNombre == '1'){ 
            $almacenajeAlertaCaracter='en la celda '.($enviarNombreString+1);
            $almacenajeAlertaCaracterTipo='celdaNombre';
        }
        if($tipoValidacionNombre == '2'){ 
            
            if($enter_encontrado_nombre == '1'){ /// identificamos la alerta activa
                $enter_encontrado='1';
                $titulo='El proceso';
                $almacenajeAlertaCaracterCelda=$enviarNombreStringL+1;
                $almacenajeAlertaCaracterTipo='caracterNombre';
            }else{
                $almacenajeAlertaCaracter=$enviarNombreStringL;
                $almacenajeAlertaCaracterTipo='caracterNombre';
            }
        }
        
    }
    
    if($enviarDescripcionString != NULL || $enviarDescripcionStringL != NULL){ 
        if($tipoValidacionDescripcion == '1'){ 
            $almacenajeAlertaCaracter='en la celda '.($enviarDescripcionString+1);
            $almacenajeAlertaCaracterTipo='celdaDescripcion';
        }
        if($tipoValidacionDescripcion == '2'){ 
            if($enter_encontrado_descripcion == '1'){ /// identificamos la alerta activa
                $enter_encontrado='1';
                $titulo='La descripción';
                $almacenajeAlertaCaracterCelda=$enviarDescripcionStringL+1;
                $almacenajeAlertaCaracterTipo='caracterDescripcion';
            }else{
                $almacenajeAlertaCaracter=$enviarDescripcionStringL;
                $almacenajeAlertaCaracterTipo='caracterDescripcion';
            }
        }
        
    }
    
    if($enviarAsociadosString != NULL || $enviarAsociadosStringL != NULL){ 
        if($tipoValidacionAsociado == '1'){ 
            $almacenajeAlertaCaracter='en la celda '.($enviarAsociadosString+1);
            $almacenajeAlertaCaracterTipo='celdaAsociado';
        }
        if($tipoValidacionAsociado == '2'){  
            if($enter_encontrado_duenoProceso == '1'){ /// identificamos la alerta activa
                $enter_encontrado='1';
                $titulo='El dueño de proceso';
                $almacenajeAlertaCaracterCelda=$enviarAsociadosStringL+1;
                $almacenajeAlertaCaracterTipo='caracterAsociado';
            }else{
                $almacenajeAlertaCaracter=$enviarAsociadosStringL;
                $almacenajeAlertaCaracterTipo='caracterAsociado';
            }
        }
        
    }
    
    if($enviarPrefijoString != NULL || $enviarPrefijoStringL != NULL){ 
        if($tipoValidacionPrefijo == '1'){ 
            $almacenajeAlertaCaracter='en la celda '.($enviarPrefijoString+1);
            $almacenajeAlertaCaracterTipo='celdaPrefijo';
        }
        if($tipoValidacionPrefijo == '2'){ 
            if($enter_encontrado_prefijo == '1'){ /// identificamos la alerta activa
                $enter_encontrado='1';
                $titulo='El prefijo';
                $almacenajeAlertaCaracterCelda=$enviarPrefijoStringL+1;
                $almacenajeAlertaCaracterTipo='caracterPrefijo';
            }else{
                $almacenajeAlertaCaracter=$enviarPrefijoStringL;
                $almacenajeAlertaCaracterTipo='caracterPrefijo';
            }
        }
        
    }
    
    
    
    if($enviaMacroprocesoString != NULL || $enviarMacroprocesoStringL != NULL){ 
        if($tipoValidacionMacroproceso == '1'){ 
            $almacenajeAlertaCaracter='en la celda '.($enviaMacroprocesoString+1);
            $almacenajeAlertaCaracterTipo='celdaMacroproceso';
        }
        if($tipoValidacionMacroproceso == '2'){ 
             if($enter_encontrado_macroproceso == '1'){ /// identificamos la alerta activa
                $enter_encontrado='1';
                $titulo='El macroproceso';
                $almacenajeAlertaCaracterCelda=$enviarMacroprocesoStringL+1;
                $almacenajeAlertaCaracterTipo='caracterMacroproceso';
            }else{
                $almacenajeAlertaCaracter=$enviarMacroprocesoStringL;
                $almacenajeAlertaCaracterTipo='caracterMacroproceso';
            }
        }
        
    }
    ?>
                            <script> 
                                 window.onload=function(){
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../procesos" method="POST" onsubmit="procesar(this.action);" >
                                <?php
                                if($enter_encontrado == '1'){ //// mandamos la alerta del enter, reemplazando la alerta de caractares
                                ?>
                                <input type="hidden" name="alertaEnter"  value="<?php echo $almacenajeAlertaCaracterCelda;?>" >
                                <input type="hidden" name="titulo"  value="<?php echo $titulo;?>" >
                                <?php    
                                }else{
                                ?>
                                <input type="hidden" name="enviarMensajeCaracter"  value="<?php echo $almacenajeAlertaCaracter;?>" >
                                <input type="hidden" name="enviarMensajeCaracterTipo"  value="<?php echo $almacenajeAlertaCaracterTipo;?>" >
                                <?php
                                }
                                ?>
                                
                            </form> 
    <?php
 
 }   
    
   
    
    ?>
    
                                                                    