<?php error_reporting(E_ERROR); error_reporting(0);
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
        
        $prefijoRepetido = TRUE;
        $nombreRepetido = TRUE;
        $asociadosExiste = TRUE;
        
        // nombre
        $campoNull = TRUE;
        $arrayNombres = array();
        $repiteNombre = TRUE;
        // END
        
        // prefijo
        $campoNullPrefijo = TRUE;
        $arrayPrefijo = array();
        $repitePrefijo = TRUE;
        // END
        
        // alerta de repetir cargos asociados en la celda
        $repiteCargoAsociado=TRUE;
        
        // variable para alerta del caracter "" 
        $activarAlerta=TRUE;
        
        
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
                            	
                            	 /// reemplazamos todas las tildes
                                function eliminar_acentos_nombre($nombre){
		
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
                            	
                            	 /// reemplazamos todas las tildes
                                function eliminar_acentos_prefijo($prefijo){
		
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
        $string_asociados='';
        
        //// validaciones para enviar caracter especial
        $enviarNombreString='';
        $enviarPrefijoString='';
        $enviarAsociadosString='';
        
        $activarAlertaEnter=TRUE; ///  variable declarada para el mensaje con campo enter
        
        
        $sheetCount = count($Reader->sheets());
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
            $contador=0;
            foreach ($Reader as $Row)
            {
            $contador++;
                if($Row[2]=='Para agregar varios cargos asociados utilice ";"  entre cargos y sin espacios.'){ continue;} //Aca remplazo por el nombre y posicion de la ultima columna de excel para que no me agrege la primera fila.
          
                
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
                    $nombre=eliminar_acentos_nombre($nombre);
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
                                          $enviarResponsableStringLnombre=$buscandoEnterNombre.',';
                                        }
                                    
                                        if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                            //echo 'enter encontrado';
                                            $enter_encontrado_nombre='1';
                                            $enviarNombreStringL=$enviarResponsableStringLnombre;
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
                       
                    
                    $validacion2 = $con->query("SELECT * FROM centrodetrabajo WHERE nombreCentrodeTrabajo = '$nombre' ")or die(mysqli_error());
                    $num2 = mysqli_num_rows($validacion2);
                    
                    if($num2 > 0){
                        //si el nombre está repetido se pone falso 
                        $nombreRepetido = FALSE;
                    }
                    
                    if($nombre == ""){
                        $campoNull = FALSE;
                        $mensajeCampoVacio='en la columna centro de trabajo';
                    }else{
                        array_push($arrayNombres,$nombre);
                    }
                    
                }
                
                
                $prefijo = "";
                if(isset($Row[1])) {
                    $prefijo = mysqli_real_escape_string($con,$Row[1]);
                    $prefijo=trim($prefijo);
                    $contadorCeldaPrefijo++;
                    $buscandoEnterPrefijo++;
                    
                    /// volvemos el texto totalmente en minuscula
                    $prefijo=mb_strtolower($prefijo);
                    '<br>';
                                
                    // eliminamos los acentos
                    $prefijo=eliminar_acentos_prefijo($prefijo);
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
                                          $enviarResponsableStringLprefijo=$buscandoEnterPrefijo.',';
                                        }
                                    
                                        if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                            //echo 'enter encontrado';
                                            $enter_encontrado_prefijo='1';
                                            $enviarPrefijoStringL=$enviarResponsableStringLprefijo;
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
                   
                    $validacion1 = $con->query("SELECT * FROM centrodetrabajo WHERE prefijoCentrodeTrabajo = '$prefijo'")or die(mysqli_error());
                    $num = mysqli_num_rows($validacion1);
                    
                    if($num > 0){
                        //si el nombre está repetido se pone falso 
                        $prefijoRepetido = FALSE;
                    }
                    
                    if($prefijo == ""){
                        $campoNull = FALSE;
                        $mensajeCampoVacio='en la columna prefijo';
                    }else{
                        array_push($arrayPrefijo,$prefijo);
                    }
                    
                }
                
                $asociados = "";
                if(isset($Row[2])) {
                    $asociados = mysqli_real_escape_string($con,$Row[2]);
                    $asociados=trim($asociados);
                    $contadorCeldaAsociados++;
                    $buscandoEnterAsociado++;
                    $contandoCeldaCargosAsociados++;
                    if($asociados == "" || $asociados == " "){
                        $campoNull = FALSE;
                        $mensajeCampoVacio='en la columna cargos asociados';
                    }else{
                    
                              
                        /// volvemos el texto totalmente en minuscula
                        $asociados=mb_strtolower($asociados);
                        '<br>';
                                
                        // eliminamos los acentos
                        $asociados=eliminar_acentos($asociados);
                        '<br>';
                        
                        //compruebo que los caracteres sean los permitidos
                        $asociados_carecteres=['"'];
                        for($bc=0; $bc<count($asociados_carecteres); $bc++){
                            $asociados_carecteres[$bc]; 
                             $cadena_carecteres_asociados = $asociados_carecteres[$bc];
                             ' - '.$coincidencia_caracteres= strpos($asociados, $cadena_carecteres_asociados);
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
                               for ($i=0; $i<strlen($asociados); $i++){
                                  if (strpos($permitidosAsociado, substr($asociados,$i,1))===false){
                                     $asociados . " no es válido<br>";
                                     $activarAlerta=FALSE;
                                     $tipoValidacionAsociado='2';
                                     $enviarAsociadosStringL=$asociados;
                                     //return false;
                                  }
                               }
                               
                                    //// validamos el enter antes de enviar la alerta
                                        $cadena_buscada_asociado = '\n';
                                        $posicion_coincidencia_asociado = strpos($asociados, $cadena_buscada_asociado);
                                        if($posicion_coincidencia_asociado === false){
                                           // echo 'si';
                                        }else{
                                           // echo 'no';
                                          $activarAlertaEnter=FALSE;
                                          $enviarResponsableStringLasociado=$buscandoEnterAsociado.',';
                                        }
                                    
                                        if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                            //echo 'enter encontrado';
                                            $enter_encontrado_cargo_asociado='1';
                                            $enviarAsociadosStringL=$enviarResponsableStringLasociado;
                                        }else{
                                            $enviarAsociadosStringL;
                                        }
                                        
                                    /// end
                        }
                        //// end 
                                
                        $asociadosS=trim($asociados); 
                        $separar = explode(";", $asociadosS);
                        $asociadoss=json_encode($separar,JSON_UNESCAPED_UNICODE);
                        $asociadoss=str_replace(',""','',$asociadoss);
                        
                        
                        $arrayRecorrido = explode(' ',$asociadoss);  // convierte en array separa por espacios;
                        $asociadoss ='';
                        // quita los campos vacios y pone un solo espacio
                        for ($i=0; $i < count($arrayRecorrido); $i++) { 
                            if(strlen($arrayRecorrido[$i])>0) {
                                $asociadoss.= ' ' . $arrayRecorrido[$i];
                            }
                        }
                        
                         $asociadoss=trim($asociadoss);
                        
                       
                        // quitamos los espacios al inicio del " 
                        $searchString = '" ';
                        $replaceString = '"';
                        $originalString = $asociadoss; 
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
                        
                         $asociadoss=$f_outputString;
                         '<br>';
                        
                        /// le retiramos las comillas vacias al inicio del documento
                         $retirarComillasInicioCelda=$asociadoss;
                         '<br>';
                         $asociadoss=str_replace('["",','[',$retirarComillasInicioCelda);
                        
                        $array = json_decode ($asociadoss);
                         
                        
                         
                        // leemos el array para verificar repetidos dentro de la celda
                            $arreglo =  $array; //["Luis Miguel", "Pedro", "Luis Miguel"];
                            if(count($arreglo) > count(array_unique($arreglo))){
                              //echo "¡Hay repetidos!";
                              $repiteCargoAsociado=FALSE;
                              for($i=0; $i<count($arreglo); $i++){
                                    $sacandoVariableArregloCA=$arreglo[$i].',';
                                   //$asociadosEnviarMensaje.=$arreglo[$i].', ';
                              }
                              $asociadosEnviarMensaje.='- En la celda '.($contandoCeldaCargosAsociados+1).' está '.$sacandoVariableArregloCA.'<br>'; /// sacamos en que celda y cuál es el nombre repetido
                            }else{
                              //echo "No hay repetidos";
                            }
                        /// end
                        
                        
                        $longitud = count($array);
                        
                        for($i=0; $i<$longitud; $i++){
                           
                        $extraeID = $con->query("SELECT id_cargos FROM cargos WHERE nombreCargos = '$array[$i]'");  
                        $rowIdDueno = $extraeID->fetch_array(MYSQLI_ASSOC);
                        
                        $duenoValidado = '['.json_encode($rowIdDueno['id_cargos']).']';
                        
                        
                        
                        $asociadoss=json_encode($rowIdDueno['id_cargos']).',';
                        
                        if($duenoValidado == '[null]' || $duenoValidado == 'null'  || $duenoValidado == 'null,'){
                            //echo $string_asociados.='el siguiente cargo asociado no existe "'.$array[$i].'"';
                             $string_asociados.=$array[$i].', ';
                             $conteoFallaAsociacos++;
                        }else{
                        
                        }
                       
                        } 
                    
                    }
                                
                } //echo '<br>';
			
             }
        
        
         // aca validamos que le documento viene vacio
            if($contador == 1){
                ?>
                                        <script> 
                                             window.onload=function(){
                                           
                                                document.forms["miformularioV"].submit();
                                             }
                                        </script>
                                         
                                        <form name="miformularioV" action="../../centrodetrabajo" method="POST" onsubmit="procesar(this.action);" >
                                            <input type="hidden" name="mensajeEnviarCampoVacio" value="<?php echo $mensajeCampoVacio;?>">
                                            <input type="hidden" name="validacionExisteImportacionVacio" value="1">
                                        </form> 
                                <?php
            }
            // END
        
        
         }//end for
         
         
         /// validando solo el nombre
          if(count($arrayNombres) > count(array_unique($arrayNombres))){//Valido si hay seriales repetidos
              $repiteNombre = FALSE;
          }
         // END
         
         /// validando solo el prefijo
          if(count($arrayPrefijo) > count(array_unique($arrayPrefijo))){//Valido si hay seriales repetidos
              $repitePrefijo = FALSE;
          }
         // END
         
        
       
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
            
            foreach ($Reader as $Row)
            {
          
                if($Row[2]=='Para agregar varios cargos asociados utilice ";"  entre cargos y sin espacios.'){ continue;} //Aca remplazo por el nombre y posicion de la ultima columna de excel para que no me agrege la primera fila.
          
                
                
                $nombre = "";
                if(isset($Row[0])) {
                    $nombre = mysqli_real_escape_string($con,$Row[0]);
                     $nombre=trim($nombre);
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
                
                
                $prefijo = "";
                if(isset($Row[1])) {
                    $prefijo = mysqli_real_escape_string($con,$Row[1]);
                     $prefijo=trim($prefijo);
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
                
                
                 $asociados = "";
                if(isset($Row[2])) {
                   
                    $asociados = mysqli_real_escape_string($con,$Row[2]);
                    $asociadosS=trim($asociados);
                    $separar = explode(";", $asociadosS);
                    $asociadoss=json_encode($separar,JSON_UNESCAPED_UNICODE);
                    $asociadoss=str_replace(',""','',$asociadoss);
                      
                    /// le retiramos las comillas vacias al inicio del documento
                         $retirarComillasInicioCelda=$asociadoss;
                         '<br>';
                         $asociadoss=str_replace('["",','[',$retirarComillasInicioCelda);  
                    
                    $array = json_decode ($asociadoss);
                    $longitud = count($array);
                    $cadena='';
                    for($i=0; $i<$longitud; $i++){
                      
                        $arrayRecorrido = explode(' ',$array[$i]);  // convierte en array separa por espacios;
                        $array[$i] ='';
                        // quita los campos vacios y pone un solo espacio
                        for ($j=0; $j < count($arrayRecorrido); $j++) { 
                            if(strlen($arrayRecorrido[$j])>0) {
                                $array[$i].= ' ' . $arrayRecorrido[$j];
                            }
                        }
                        
                        $array[$i]=trim($array[$i]);
                         
                         
                    $extraeID = $con->query("SELECT id_cargos FROM cargos WHERE nombreCargos = '$array[$i]'");  
                    $rowIdDueno = $extraeID->fetch_array(MYSQLI_ASSOC);
                    $duenoValidado = '['.json_encode($rowIdDueno['id_cargos']).']';
                    $cadena.=$asociadoss=json_encode($rowIdDueno['id_cargos']).',';
                        if($duenoValidado == '[null]' || $duenoValidado == 'null'  || $duenoValidado == 'null,'){
                            $asociadosExiste=FALSE;
                               
                        }
                    }
                    $cadena;
                    
                   
                }
				
                
				$validarArchivo = "";
                if(isset($Row[3])) {
                    $validarArchivo = mysqli_real_escape_string($con,$Row[3]);
                }
                
                if($validarArchivo != NULL){ //// para validar el archivo 
                      
                         ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../centrodetrabajo" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionExisteImportacionA" value="1">
                            </form> 
                        <?php
                        
                }else{
                
                if (!empty($prefijo) || !empty($nombre )  || !empty($asociadoss) ) {
                    
                    if($activarAlerta == FALSE || $repiteNombre == FALSE || $repiteCargoAsociado == FALSE || $repitePrefijo == FALSE || $prefijoRepetido == FALSE || $nombreRepetido == FALSE || $asociadosExiste == FALSE || $campoNull == FALSE){
                        
                        if($activarAlerta == FALSE){ 
                            $enviarVariableAlerta=1;
                        }
                        
                        if($campoNull == FALSE){ 
                            ?>
                            <script> 
                                 window.onload=function(){
                              
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../centrodetrabajo" method="POST" onsubmit="procesar(this.action);" >
                                 <input type="hidden" name="mensajeEnviarCampoVacio" value="<?php echo $mensajeCampoVacio;?>">
                                <input type="hidden" name="validacionExisteImportacionVacio" value="1">
                            </form> 
                        <?php
                        }
                        
                        
                        if($repiteNombre == FALSE){ 
                       
                        ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../centrodetrabajo" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionExisteImportacionB" value="1">
                            </form> 
                        <?php
                        }
                        
                        if($repiteCargoAsociado == FALSE){  
                            $activandoRepetidosCargoAsociado='1';
                        }
                        
                        if($repitePrefijo == FALSE){ 
                        
                        ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../centrodetrabajo" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionExisteImportacionC" value="1">
                            </form> 
                        <?php
                        }
                        
                        if($prefijoRepetido == FALSE){ 
                            
                        
                        ?>
                            <script> 
                                 window.onload=function(){
                              
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../centrodetrabajo" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionExisteImportacionD" value="1">
                            </form> 
                        <?php
                        }
                        
                        if($nombreRepetido == FALSE){ 
                            
                        
                        ?>
                            <script> 
                                 window.onload=function(){
                              
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../centrodetrabajo" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionExisteImportacionE" value="1">
                            </form> 
                        <?php
                        }
                        
                        if($asociadosExiste == FALSE){ 'entra('.$asociadosExiste;
                            $validaionCargoAsociadoNoExiste='1';    
                        }
                        
                        $type = "error";
                        $message = "ERROR";
                        /*
                        ?>
                            <script> 
                                 window.onload=function(){
                               
                                    // document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../centrodetrabajo" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionExisteImportacionG" value="1">
                            </form> 
                        <?php
                        */
                        
                        
                    }else{
                        
                     
                        //echo 'registro';
                       
                        //// retiramos la ,] que sobra para almacenar solo el id
                        $asociadoss='['.$cadena.']';
                        $asociadoss=str_replace(',]',']',$asociadoss);
                        //// end
                      
                        if($conteoFallaAsociacos  == '1'){
                         //echo 'no registrar';   
                        }else{
                        
                         //echo 'registro';
                            $query = "insert into centrodetrabajo(prefijoCentrodeTrabajo,nombreCentrodeTrabajo,cargosAsociadoss,estilo) values('$prefijo','$nombre','$asociadoss','0')";
                            $resultados = mysqli_query($con, $query)or die(mysqli_error());
                        }
                            ?>
                                <script> 
                                     window.onload=function(){
                                       document.forms["miformularioAgreagar"].submit();
                                     }
                                </script>
                                 
                                <form name="miformularioAgreagar" action="../../centrodetrabajo" method="POST" onsubmit="procesar(this.action);" >
                                    <input type="hidden" name="validacionAgregar" value="1">
                                </form> 
                            <?php
                        
                        
                    if (!empty($resultados)) {
                        $type = "success";
                        //$message = "Excel importado correctamente";
                    } else {
                        $type = "error";
                        //$message = "Hubo un problema al importar registros";
                    } 
                    
                    
                    
                    }//end else
                }
                
            } // para validar el archivo
                
                
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
                $titulo='El centro de trabajo';
                $almacenajeAlertaCaracter=$enviarNombreStringL+1;
                $almacenajeAlertaCaracterTipo='caracterNombre';
            }else{
                $almacenajeAlertaCaracter=$enviarNombreStringL;
                $almacenajeAlertaCaracterTipo='caracterNombre';
            }
        }
        ?>
                            <script> 
                                 window.onload=function(){
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../centrodetrabajo" method="POST" onsubmit="procesar(this.action);" >
                                <?php
                                if($enter_encontrado == '1'){ //// mandamos la alerta del enter, reemplazando la alerta de caractares
                                ?>
                                <input type="hidden" name="alertaEnter"  value="<?php echo $almacenajeAlertaCaracter;?>" >
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
    
    if($enviarPrefijoString != NULL || $enviarPrefijoStringL != NULL){ 
        if($tipoValidacionPrefijo == '1'){ 
            $almacenajeAlertaCaracter='en la celda '.($enviarPrefijoString+1);
            $almacenajeAlertaCaracterTipo='celdaPrefijo';
        }
        if($tipoValidacionPrefijo == '2'){ 
            if($enter_encontrado_prefijo == '1'){ /// identificamos la alerta activa
                $enter_encontrado='1';
                $titulo='El prefijo';
                $almacenajeAlertaCaracter=$enviarPrefijoStringL+1;
                $almacenajeAlertaCaracterTipo='caracterPrefijo';
            }else{
                $almacenajeAlertaCaracter=$enviarPrefijoStringL;
                $almacenajeAlertaCaracterTipo='caracterPrefijo';
            }
        }
     
        ?>
                            <script> 
                                 window.onload=function(){
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../centrodetrabajo" method="POST" onsubmit="procesar(this.action);" >
                                <?php
                                if($enter_encontrado == '1'){ //// mandamos la alerta del enter, reemplazando la alerta de caractares
                                ?>
                                <input type="hidden" name="alertaEnter"  value="<?php echo $almacenajeAlertaCaracter;?>" >
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
    
    if($enviarAsociadosString != NULL || $enviarAsociadosStringL != NULL){ 
        if($tipoValidacionAsociado == '1'){ 
            $almacenajeAlertaCaracter='en la celda '.($enviarAsociadosString+1);
            $almacenajeAlertaCaracterTipo='celdaAsociado';
        }
        if($tipoValidacionAsociado == '2'){
            if($enter_encontrado_cargo_asociado == '1'){ /// identificamos la alerta activa
                $enter_encontrado='1';
                $titulo='El cargo asociado';
                $almacenajeAlertaCaracter=$enviarAsociadosStringL+1;
                $almacenajeAlertaCaracterTipo='caracterAsociado';
            }else{
                $almacenajeAlertaCaracter=$enviarAsociadosStringL;
                $almacenajeAlertaCaracterTipo='caracterAsociado';
            }
        }
        
        
        ?>
                            <script> 
                                 window.onload=function(){
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../centrodetrabajo" method="POST" onsubmit="procesar(this.action);" >
                                <?php
                                if($enter_encontrado == '1'){ //// mandamos la alerta del enter, reemplazando la alerta de caractares
                                ?>
                                <input type="hidden" name="alertaEnter"  value="<?php echo $almacenajeAlertaCaracter;?>" >
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
    
   
    
  }
  
  if($activandoRepetidosCargoAsociado == '1'){
                        ?>
                            <script> 
                                 window.onload=function(){
                              
                                     document.forms["miformularioRepetido"].submit();
                                 }
                            </script>
                             
                            <form name="miformularioRepetido" action="../../centrodetrabajo" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionExisteImportacionRepiteAsociado" value="1">
                                <input type="hidden" name="mensajeAsociados" value="<?php echo '<br>'.$asociadosEnviarMensaje;?>">
                               <!-- <input type="submit">-->
                            </form> 
                        <?php
  }
  
if($enviarAsociadosString != NULL || $enviarAsociadosStringL != NULL){
    
}else{
    if($validaionCargoAsociadoNoExiste == '1'){ 
       ?>
                            <script> 
                                 window.onload=function(){
                               
                                    document.forms["miformularioNE"].submit();
                                 }
                            </script>
                             
                            <form name="miformularioNE" action="../../centrodetrabajo" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionExisteImportacionFMensaje" value="<?php echo $string_asociados;?>">
                                <input type="hidden" name="validacionExisteImportacionF" value="1">
                            </form> 
                        <?php
   } 
}      
    ?>
    
                                                                    