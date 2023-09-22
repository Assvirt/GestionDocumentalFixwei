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
        
        $codigoRepetido = TRUE;
        $cargoExiste = TRUE;
        $trabajoExiste = TRUE;
        
        // codigo
        $codigoExiste=TRUE;
        $campoNull = TRUE;
        $arrayCodigo = array();
        $repiteCodigo = TRUE;
        
        // prefijo
        $campoNullPrefijo = TRUE;
        $arrayPrefijo = array();
        $repitePrefijo = TRUE;
        $prefijoExiste = TRUE;
        
        // nombre
        $repiteNombre = TRUE;
        $arrayNombre = array();
        $repiteNombreDocumento= TRUE;
        
        $numerico = TRUE;
        
        function eliminar_acentos_codigo($codigo){
		
                            		//Reemplazamos la A y a
                            		$codigo = str_replace(
                            		array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
                            		array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
                            		$codigo
                            		);
                            
                            		//Reemplazamos la E y e
                            		$codigo = str_replace(
                            		array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
                            		array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
                            		$codigo );
                            
                            		//Reemplazamos la I y i
                            		$codigo = str_replace(
                            		array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
                            		array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
                            		$codigo );
                            
                            		//Reemplazamos la O y o
                            		$codigo = str_replace(
                            		array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
                            		array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
                            		$codigo );
                            
                            		//Reemplazamos la U y u
                            		$codigo = str_replace(
                            		array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
                            		array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
                            		$codigo );
                            
                            		//Reemplazamos la N, n, C y c
                            		$codigo = str_replace(
                            		array('Ñ', 'ñ', 'Ç', 'ç'),
                            		array('N', 'n', 'C', 'c'),
                            		$codigo
                            		);
                            		
                            		//Reemplazamos ;; por ;
                            		$codigo = str_replace(
                            		array(';;',';;;'),
                            		array(';',';'),
                            		$codigo
                            		);
                            		
                            		return $codigo;
                            	}
                            	
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
                            		array('N', 'n', 'C', 'c'),
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
                            		array('N', 'n', 'C', 'c'),
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
                            	
                            	
        
        /// variables para enviar el cargo asociado no existe
        $buscando_celda_dueno=1;
        $string_dueno='';
        
        $buscando_celda_cdt=1;
        $string_cdt='';
        
        $buscando_celda_persona=1;
        $string_persona='';
        $enviarAlertaCaracterPersona='';
        $activarAlertaCarecterPersona=TRUE;
        
        
        ///// validación para enviar el mensaje de la alerta de caracteres
        $activarAlerta=TRUE;
        $activarAlertaEnter=TRUE; ///  variable declarada para el mensaje con campo enter
        $enviarCodigoString='';
        $enviarPrefijoString='';
        $enviarNombreString='';
        $enviarCargoString='';
        $enviarCtString='';
        $enviarResponsableString='';
        
        
        $sheetCount = count($Reader->sheets());
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
            $contador=0;
            
            /// validamos el conteo de registro de las personas responsables
            $contadorRegistros=0;
            $contadorRegistrosSaliendo=0;
            /// END
            
            foreach ($Reader as $Row)
            {
            $contador++;
                if($Row[5]=='Ingrese el número de documento de identidad de la persona responsable del centro de costos, sin usar puntos ni comas, luego ingrese la letra "C" para cédula de ciudadanía o "E" para cédula de extranjeria, no utilice espacios. Ejemplo 122345678C'){ continue;} //Aca remplazo por el nombre y posicion de la ultima columna de excel para que no me agrege la primera fila.
                
                $codigo = "";
                if(isset($Row[0])) {
                    $codigo = mysqli_real_escape_string($con,$Row[0]);
                    $codigo=trim($codigo);
                    $contadorCeldaCodigo++;
                    $buscandoEnterCodigo++;
                    
                     /// volvemos el texto totalmente en minuscula
                                  $codigo=mb_strtolower($codigo);
                                 '<br>';
                                
                                // eliminamos los acentos
                                 $codigo=eliminar_acentos_codigo($codigo);
                                 '<br>';
                        
                        //compruebo que los caracteres sean los permitidos
                            $codigo_carecteres=['"'];
                            for($bc=0; $bc<count($codigo_carecteres); $bc++){
                                $codigo_carecteres[$bc]; 
                                 $cadena_carecteres_codigo = $codigo_carecteres[$bc];
                                 ' - '.$coincidencia_caracteres= strpos($codigo, $cadena_carecteres_codigo);
                                if($coincidencia_caracteres != NULL){
                                    $activarAlerta=FALSE;
                                    $enviarCodigoString.=$contadorCeldaCodigo.', ';
                                    $tipoValidacionCodigo='1';
                                }
                                 '<br>';
                            }
                            
                            if($tipoValidacionCodigo == '1'){
                                
                            }else{
                                $permitidosCodigo = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ0123456789 ";
                                   for ($i=0; $i<strlen($codigo); $i++){
                                      if (strpos($permitidosCodigo, substr($codigo,$i,1))===false){
                                         $codigo . " no es válido<br>";
                                         $activarAlerta=FALSE;
                                         $tipoValidacionCodigo='2';
                                         $enviarCodigoStringL=$codigo;
                                         //return false;
                                      }
                                   }
                                   
                                   //// validamos el enter antes de enviar la alerta
                                        $cadena_buscada_codigo = '\n';
                                        $posicion_coincidencia_codigo = strpos($codigo, $cadena_buscada_codigo);
                                        if($posicion_coincidencia_codigo === false){
                                           // echo 'si';
                                        }else{
                                           // echo 'no';
                                          $activarAlertaEnter=FALSE;
                                          $enviarResponsableStringLCodigo=$buscandoEnterCodigo.',';
                                        }
                                    
                                        if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                            //echo 'enter encontrado';
                                            $enter_encontrado_codigo='1';
                                            $enviarCodigoStringL=$enviarResponsableStringLCodigo;
                                        }else{
                                            $enviarCodigoStringL;
                                        }
                                        
                                    /// end
                            }
                            //// end
                         
                        $array = explode(' ',$codigo);  // convierte en array separa por espacios;
                        $codigo ='';
                        // quita los campos vacios y pone un solo espacio
                        for ($i=0; $i < count($array); $i++) { 
                            if(strlen($array[$i])>0) {
                                $codigo.= ' ' . $array[$i];
                            }
                        }
                        
                        $codigo=trim($codigo);
                    
                    
                    $validacionCodigo = $con->query("SELECT * FROM centroCostos WHERE codigo ='$codigo'")or die(mysqli_error());
                     'Conteo: '.$numCodigo = mysqli_num_rows($validacionCodigo); 
                    
                    if($numCodigo > 0){
                        $codigoExiste=FALSE;
                        $enviarcodigoExistente.=$codigo.', ';
                    }else{ 
                        if($codigo == ""){
                            $campoNull = FALSE; 
                            $mensajeCampoVacio='en la columna código';
                        }else{
                            array_push($arrayCodigo,$codigo);
                        }
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
                                    $permitidosPrefijo = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ0123456789 ";
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
                                        $cadena_buscada_prefijoo = '\n';
                                        $posicion_coincidencia_prefijoo = strpos($prefijo, $cadena_buscada_prefijoo);
                                        if($posicion_coincidencia_prefijoo === false){
                                           // echo 'si';
                                        }else{
                                           // echo 'no';
                                          $activarAlertaEnter=FALSE;
                                          $enviarResponsableStringLCPrefijo=$buscandoEnterPrefijo.',';
                                        }
                                    
                                        if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                            //echo 'enter encontrado';
                                            $enter_encontrado_prefijo='1';
                                            $enviarPrefijoStringL=$enviarResponsableStringLCPrefijo;
                                        }else{
                                            $enviarPrefijoStringL;
                                        }
                                        
                                    /// end
                                }
                                //// end
                   
                        $array = explode(' ',$prefijo);  // convierte en array separa por espacios;
                        $prefijo ='';
                        // quita los campos vacios y pone un solo espacio
                        for ($i=0; $i < count($array); $i++) { 
                            if(strlen($array[$i])>0) {
                                $prefijo.= ' ' . $array[$i];
                            }
                        }
                        
                        $prefijo=trim($prefijo);
                   
                   
                    $validacionPrefijo = $con->query("SELECT * FROM centroCostos WHERE prefijo ='$prefijo'")or die(mysqli_error());
                     'Conteo: '.$numPrefijo = mysqli_num_rows($validacionPrefijo); 
                    
                    if($numPrefijo > 0){
                        $prefijoExiste=FALSE;
                        $enviarprefijoExistente.=$prefijo.', ';
                    }else{ 
                        if($prefijo == ""){
                            $campoNullPrefijo = FALSE;
                            $mensajeCampoVacio='en la columna prefijo';
                        }else{
                            array_push($arrayPrefijo,$prefijo);
                        }
                    }
                }    
               
                $nombre = "";
                if(isset($Row[2])) {
                    $nombre = mysqli_real_escape_string($con,$Row[2]);
                    $nombre=trim($nombre);
                    $buscandoEnterNombre++;
                    $contadorCeldaNombre++;
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
                                        $cadena_buscada_Nombre = '\n';
                                        $posicion_coincidencia_Nombre = strpos($nombre, $cadena_buscada_Nombre);
                                        if($posicion_coincidencia_Nombre === false){
                                           // echo 'si';
                                        }else{
                                           // echo 'no';
                                          $activarAlertaEnter=FALSE;
                                          $enviarResponsableStringLCNombre=$buscandoEnterNombre.',';
                                        }
                                    
                                        if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                            //echo 'enter encontrado';
                                            $enter_encontrado_nombre='1';
                                            $enviarNombreStringL=$enviarResponsableStringLCNombre;
                                        }else{
                                            $enviarNombreStringL;
                                        }
                                        
                                    /// end
                                }
                                //// end
                    
                    if($nombre == ""){
                        $campoNull = FALSE; 
                        $mensajeCampoVacio='en la columna centro de costo';
                    }else{
                         
                        $array = explode(' ',$nombre);  // convierte en array separa por espacios;
                        $nombre ='';
                        // quita los campos vacios y pone un solo espacio
                        for ($i=0; $i < count($array); $i++) { 
                            if(strlen($array[$i])>0) {
                                $nombre.= ' ' . $array[$i];
                            }
                        }
                        
                        $nombre=trim($nombre);
                         
                        $validacionNombre = $con->query("SELECT * FROM centroCostos WHERE nombre ='$nombre'")or die(mysqli_error());
                        $nombreRepite = mysqli_num_rows($validacionNombre);
                        if($nombreRepite > 0){
                           //si el nombre está repetido se pone falso 
                           $repiteNombre = FALSE;
                           $enviarNombreExistente.=$nombre.', ';
                        }else{
                             array_push($arrayNombre,$nombre);
                        }
                    }
                    
                    
                }
                    
                     
                $cargo = "";
                if(isset($Row[3])) {
                    $cargo = mysqli_real_escape_string($con,$Row[3]);
                    $cargo=trim($cargo);
                    $contadorCeldaCargo++;
                    $buscandoEntercargo++;
                    
                    if($cargo == ""){
                        $campoNull = FALSE; 
                         $mensajeCampoVacio='en la columna cargo del dueño del centro de costo';
                    }else{  
                        $cargo=trim($cargo);
                                
                                /// volvemos el texto totalmente en minuscula
                                  $cargo=mb_strtolower($cargo);
                                 '<br>';
                    
                        //compruebo que los caracteres sean los permitidos
                                $cargo_carecteres=['"'];
                                for($bc=0; $bc<count($cargo_carecteres); $bc++){
                                    $cargo_carecteres[$bc]; 
                                     $cadena_carecteres_cargo = $cargo_carecteres[$bc];
                                     ' - '.$coincidencia_caracteres= strpos($cargo, $cadena_carecteres_cargo);
                                    if($coincidencia_caracteres != NULL){
                                        $activarAlerta=FALSE;
                                        $enviarCargoString.=$contadorCeldaCargo.', ';
                                        $tipoValidacionCargo='1';
                                    }
                                     '<br>';
                                }
                                
                                if($tipoValidacionCargo == '1'){
                                    
                                }else{
                                    $permitidosCargo = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ ";
                                       for ($i=0; $i<strlen($cargo); $i++){
                                          if (strpos($permitidosCargo, substr($cargo,$i,1))===false){
                                             $cargo . " no es válido<br>";
                                             $activarAlerta=FALSE;
                                             $tipoValidacionCargo='2';
                                             $enviarCargoStringL=$cargo;
                                             //return false;
                                          }
                                       }
                                       
                                        
                                        //// validamos el enter antes de enviar la alerta
                                            $cadena_buscada_cargo = '\n';
                                            $posicion_coincidencia_cargo = strpos($cargo, $cadena_buscada_cargo);
                                            if($posicion_coincidencia_cargo === false){
                                                //echo 'si';
                                            }else{
                                                //echo 'no '.$cargo;
                                              $activarAlertaEnter=FALSE;
                                              $enviarCargoStringLC=$buscandoEntercargo.',';
                                            }
                                        
                                            if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                                //echo 'enter encontrado';
                                                $enter_encontrado_cargo='1';
                                                $enviarCargoStringL=$enviarCargoStringLC; //echo '<br>';
                                            }else{
                                                 'sin ente: '.$enviarCargoStringLT=$enviarCargoStringL;  '<br>';
                                            }
                                        
                                        
                                    /// end
                                }
                                //// end
                    
                        $array = explode(' ',$cargo);  // convierte en array separa por espacios;
                        $cargo ='';
                        // quita los campos vacios y pone un solo espacio
                        for ($i=0; $i < count($array); $i++) { 
                            if(strlen($array[$i])>0) {
                                $cargo.= ' ' . $array[$i];
                            }
                        }
                        
                        $cargo=trim($cargo);
                        $enviarNombreCar=$cargo;
                        $extraeID = $con->query("SELECT id_cargos FROM cargos WHERE nombreCargos = '$cargo'")or die(mysqli_error());  
                        $rowId = $extraeID->fetch_array(MYSQLI_ASSOC);
                        $cargo = $rowId['id_cargos'];
                        
                         // validamos la celda que contiene el error
                            if($cargo != NULL){
                                 (($buscando_celda_dueno++)+1); //echo $nivelCargo_validar;
                            }else{
                                 $string_dueno.=$enviarNombreCar.', ';//(($buscando_celda_dueno++)+1).', '; //echo $nivelCargo_validar;
                            }
                        
                        
                        if($cargo == 0){
                            $cargoExiste = FALSE;
                        }
                    }
                }
                
                $cTrabajo = "";
                if(isset($Row[4])) {
                    $cTrabajo = mysqli_real_escape_string($con,$Row[4]);
                    $cTrabajo=trim($cTrabajo);
                    $contadorCeldaCt++;
                    $buscandoEnterCentroTrabajo++;
                    
                    if($cTrabajo == ""){
                        $campoNull = FALSE;
                        $mensajeCampoVacio='en la columna centro de trabajo';
                    }else{
                        
                         /// volvemos el texto totalmente en minuscula
                                  $cTrabajo=mb_strtolower($cTrabajo);
                                 '<br>';
                                 
                        //compruebo que los caracteres sean los permitidos
                        $ct_carecteres=['"'];
                        for($bc=0; $bc<count($ct_carecteres); $bc++){
                            $ct_carecteres[$bc]; 
                             $cadena_carecteres_ct = $ct_carecteres[$bc];
                             ' - '.$coincidencia_caracteres= strpos($cTrabajo, $cadena_carecteres_ct);
                            if($coincidencia_caracteres != NULL){
                                $activarAlerta=FALSE;
                                $enviarCtString.=$contadorCeldaCt.', ';
                                $tipoValidacionCt='1';
                            }
                             '<br>';
                        }
                        
                        if($tipoValidacionCt == '1'){
                            
                        }else{
                            $permitidosCt = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ ";
                               for ($i=0; $i<strlen($cTrabajo); $i++){
                                  if (strpos($permitidosCt, substr($cTrabajo,$i,1))===false){
                                     $cTrabajo . " no es válido<br>";
                                     $activarAlerta=FALSE;
                                     $tipoValidacionCt='2';
                                     $enviarCtStringL=$cTrabajo;
                                     //return false;
                                  }
                               }
                               
                               //// validamos el enter antes de enviar la alerta
                                        $cadena_buscada_centro_trabajo = '\n';
                                        $posicion_coincidencia_centro_trabajo = strpos($cTrabajo, $cadena_buscada_centro_trabajo);
                                        if($posicion_coincidencia_centro_trabajo === false){
                                           // echo 'si';
                                        }else{
                                           // echo 'no';
                                          $activarAlertaEnter=FALSE;
                                          $enviarResponsableStringLCentroTrabajo=$buscandoEnterCentroTrabajo.',';
                                        }
                                    
                                        if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                            //echo 'enter encontrado';
                                            $enter_encontrado_centro_trabajo='1';
                                            $enviarCtStringL=$enviarResponsableStringLCentroTrabajo;
                                        }else{
                                            $enviarCtStringL;
                                        }
                                        
                                    /// end
                        }
                        //// end
                        
                        
                        //$cacra="\";
                        
                        $array = explode(' ',$cTrabajo);  // convierte en array separa por espacios;
                        $cTrabajo ='';
                        // quita los campos vacios y pone un solo espacio
                        for ($i=0; $i < count($array); $i++) { 
                            if(strlen($array[$i])>0) {
                                $cTrabajo.= ' ' . $array[$i];
                            }
                        }
                        
                        $cTrabajo=trim($cTrabajo);
                        
                        $extraeID = $con->query("SELECT * FROM centrodetrabajo WHERE nombreCentrodeTrabajo = '$cTrabajo'")or die(mysqli_error());  
                        $rowId = $extraeID->fetch_array(MYSQLI_ASSOC);
                        $cTrabajoID = $rowId['id_centrodetrabajo'];
                        $nombreCentrodeTrabajo = $rowId['nombreCentrodeTrabajo']; //echo '<br>';
                        
                         // validamos la celda que contiene el error
                            if($cTrabajoID != NULL){
                                 (($buscando_celda_cdt++)+1); //echo $nivelCargo_validar;
                            }else{
                                $cadena_buscada_fecha = '"';
                                $posicion_coincidencia_fecha = strpos($cTrabajo, $cadena_buscada_fecha);
                                 if($posicion_coincidencia_fecha == false){
                                     
                                      $string_cdt.=$cTrabajo.', ';//(($buscando_celda_cdt++)+1).', '; //echo $nivelCargo_validar;
                                      $variableMensajeE='0';
                                 }else{
                                     
                                      $variableMensajeE='1';
                                      $string_cdt.=$cTrabajo.', ';//(($buscando_celda_cdt++)+1).', '; //echo $nivelCargo_validar;
                                 }
                               // $string_cdt.=$cTrabajo.', ';//(($buscando_celda_cdt++)+1).', '; //echo $nivelCargo_validar;
                            }
                        
                        //var_dump($cTrabajo);
                        if($cTrabajoID > 0 ){
                            //echo 'Guardar <br>';
                        }else{
                            $trabajoExiste = FALSE; 
                            //echo 'Activa validación <br>';
                               
                        }
                    }
                    
                }
                
                $persona = "";
                if(isset($Row[5])) {
                    $persona = mysqli_real_escape_string($con,$Row[5]);
                    $personaV=trim($persona);
                    $buscando_celda_persona++;
                    $contadorCeldaResponsable++;
                    $buscandoEnterresponsable++;
                    if($personaV == ""){
                        $campoNull = FALSE; 
                        $mensajeCampoVacio='en la columna persona responsable';
                    }else{
                        
                            
                            
                             //compruebo que los caracteres sean los permitidos
                                $responsable_carecteres=['"'];
                                for($bc=0; $bc<count($responsable_carecteres); $bc++){
                                    $responsable_carecteres[$bc]; 
                                     $cadena_carecteres_responsable = $responsable_carecteres[$bc];
                                     ' - '.$coincidencia_caracteres= strpos($personaV, $cadena_carecteres_responsable);
                                    if($coincidencia_caracteres != NULL){
                                        $activarAlerta=FALSE;
                                        $enviarResponsableString.=$contadorCeldaResponsable.', ';
                                        $tipoValidacionResponsable='1';
                                    }
                                     '<br>';
                                }
                                
                                if($tipoValidacionResponsable == '1'){
                                    
                                }else{
                                    
                                    $permitidosResponsable = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789ñ ";
                                       for ($i=0; $i<strlen($personaV); $i++){
                                          if (strpos($permitidosResponsable, substr($personaV,$i,1))===false){
                                             $personaV . " no es válido<br>";
                                             $activarAlerta=FALSE;
                                             $tipoValidacionResponsable='2';
                                             $enviarResponsableStringL=$personaV;
                                             //return false;
                                          }
                                       }
                                    
                                    //// validamos el enter antes de enviar la alerta
                                        $cadena_buscada_fecha = '\n';
                                        $posicion_coincidencia_fecha = strpos($personaV, $cadena_buscada_fecha);
                                        if($posicion_coincidencia_fecha === false){
                                           // echo 'si';
                                        }else{
                                           // echo 'no';
                                          $activarAlertaEnter=FALSE;
                                          $enviarResponsableStringLCresponsable=$buscandoEnterresponsable.',';
                                        }
                                    
                                        if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                            //echo 'enter encontrado';
                                            $enter_encontrado_responsable='1';
                                            $enviarResponsableStringL=$enviarResponsableStringLCresponsable;
                                        }else{
                                            $enviarResponsableStringL;
                                        }
                                    /// end
                                    
                                }
                                //// end
                                
                            
                        
                                $contadorRegistros++;  //// verificamos que las cantidades que entran y salgan sean iguales  
                                $extraeID = $con->query("SELECT * FROM usuario WHERE cedula = '$personaV'")or die(mysqli_error());  
                                $rowId = $extraeID->fetch_array(MYSQLI_ASSOC);
                                $idPersona = $rowId['id'];
                                'contador: '.$idPersonaConteo= mysqli_num_rows($extraeID);
                                 
                                 
                                 // validamos la celda que contiene el error
                                    if($idPersona != NULL){
                                         //(($buscando_celda_persona++)+1); //echo $nivelCargo_validar;
                                    }else{
                                         $string_persona.=$personaV.', ';//(($buscando_celda_persona++)+1).', '; //echo $nivelCargo_validar;
                                    } 
                                 
                                if($idPersona != NULL){
                                    $contadorRegistrosSaliendo++;  //// verificamos que las cantidades que entran y salgan sean iguales
                                    $numerico=TRUE; 
                                }else{ 
                                   $numerico=FALSE;
                                } 
                           
                        
                        
                    }
                    
                    
                    
                    
                   
                }
			
             }
        
        
         'Contador Ingresos: '.$contadorRegistros;
         '<br>';
         'Contador salientes: '.$contadorRegistrosSaliendo;
        
        
        if($contadorRegistros == $contadorRegistrosSaliendo){
               /// si las cantidades que entran y salen son correctas, no enviamos la variable para restringir el registro              
        }else{ 
            $variableNoRegistrar=1;
            /// en caso contrario, mandamos una variable para detener el registro de datos
        }
        
        // aca validamos que le documento viene vacio
        if($contador == 1){
        ?>
            <script> 
                 window.onload=function(){
                                           
                    document.forms["miformularioV"].submit();
                 }
            </script>
                                         
            <form name="miformularioV" action="../../centroCostos" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="mensajeEnviarCampoVacio" value="<?php echo $mensajeCampoVacio;?>">
                <input type="hidden" name="validacionExisteImportacionVacio" value="1">
            </form> 
        <?php
        }
        // END
        
        
         }//end for
                    // codigo
                    if(count($arrayCodigo) > count(array_unique($arrayCodigo))){//Valido si hay seriales repetidos
                      $repiteCodigo = FALSE;
                    }
                    // prefijo
                    if(count($arrayPrefijo) > count(array_unique($arrayPrefijo))){//Valido si hay seriales repetidos
                      $repitePrefijo = FALSE;
                    }
                    // nombre
                    if(count($arrayNombre) > count(array_unique($arrayNombre))){//Valido si hay seriales repetidos
                      $repiteNombreDocumento = FALSE;
                    }
      
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
            
            foreach ($Reader as $Row)
            {
          
                if($Row[5]=='Ingrese el número de documento de identidad de la persona responsable del centro de costos, sin usar puntos ni comas, luego ingrese la letra "C" para cédula de ciudadanía o "E" para cédula de extranjeria, no utilice espacios. Ejemplo 122345678C'){ continue;} //Aca remplazo por el nombre y posicion de la ultima columna de excel para que no me agrege la primera fila.
                
                $codigo = "";
                if(isset($Row[0])) {
                    $codigo = mysqli_real_escape_string($con,$Row[0]);
                    if($codigo == ""){
                        $campoNull = FALSE; 
                    }else{
                        $codigo=trim($codigo);
                    
                        $array = explode(' ',$codigo);  // convierte en array separa por espacios;
                        $codigo ='';
                        // quita los campos vacios y pone un solo espacio
                        for ($i=0; $i < count($array); $i++) { 
                            if(strlen($array[$i])>0) {
                                $codigo.= ' ' . $array[$i];
                            }
                        }
                        
                        $codigo=trim($codigo);
                    }
                }
          
                $prefijo = "";
                if(isset($Row[1])) {
                    $prefijo = mysqli_real_escape_string($con,$Row[1]);
                    
                    if($prefijo == ""){
                        $campoNull = FALSE; 
                    }else{
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
                }
                
                $nombre = "";
                if(isset($Row[2])) {
                    $nombre = mysqli_real_escape_string($con,$Row[2]);
                    if($nombre == ""){
                        $campoNull = FALSE; 
                    }else{
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
                }
                
                $cargo = "";
                if(isset($Row[3])) {
                    $cargo = mysqli_real_escape_string($con,$Row[3]);
                    if($cargo == ""){
                        $campoNull = FALSE; 
                    }else{  
                        $cargo=trim($cargo);
                    
                        $array = explode(' ',$cargo);  // convierte en array separa por espacios;
                        $cargo ='';
                        // quita los campos vacios y pone un solo espacio
                        for ($i=0; $i < count($array); $i++) { 
                            if(strlen($array[$i])>0) {
                                $cargo.= ' ' . $array[$i];
                            }
                        }
                        
                        $cargo=trim($cargo);
                    
                        $extraeID = $con->query("SELECT id_cargos FROM cargos WHERE nombreCargos = '$cargo'")or die(mysqli_error());  
                        $rowId = $extraeID->fetch_array(MYSQLI_ASSOC);
                        $cargo = $rowId['id_cargos'];
                        
                         
                        
                        
                        if($cargo == 0){
                            $cargoExiste = FALSE;
                        }
                    }
                }
                 $cTrabajo = "";
                if(isset($Row[4])) {
                    $cTrabajo = mysqli_real_escape_string($con,$Row[4]);
                    $cTrabajo=trim($cTrabajo);
                    
                    if($cTrabajo == ""){
                        $campoNull = FALSE; 
                    }else{
                        $array = explode(' ',$cTrabajo);  // convierte en array separa por espacios;
                        $cTrabajo ='';
                        // quita los campos vacios y pone un solo espacio
                        for ($i=0; $i < count($array); $i++) { 
                            if(strlen($array[$i])>0) {
                                $cTrabajo.= ' ' . $array[$i];
                            }
                        }
                        
                        $cTrabajo=trim($cTrabajo);
                        
                        
                        $extraeID = $con->query("SELECT * FROM centrodetrabajo WHERE nombreCentrodeTrabajo = '$cTrabajo'")or die(mysqli_error());  
                        $rowId = $extraeID->fetch_array(MYSQLI_ASSOC);
                        $cTrabajoID = $rowId['id_centrodetrabajo'];
                        $nombreCentrodeTrabajo = $rowId['nombreCentrodeTrabajo']; //echo '<br>';
                        
                        
                        
                        //var_dump($cTrabajo);
                        if($cTrabajoID > 0 ){
                            //echo 'Guardar <br>';
                        }else{
                            $trabajoExiste = FALSE; 
                            //echo 'Activa validación <br>';
                               
                        }
                    }
                }
                
                $persona = "";
                if(isset($Row[5])) {
                    $persona = mysqli_real_escape_string($con,$Row[5]);
                    $personaV=trim($persona);
                    
                        $extraeID = $con->query("SELECT * FROM usuario WHERE cedula = '$personaV'")or die(mysqli_error());  
                        $rowId = $extraeID->fetch_array(MYSQLI_ASSOC);
                        ' -- '.$idPersona = $rowId['id'];
                        
                        
                }
				
                
			
                
                $validarArchivo = "";
                if(isset($Row[6])) {
                    $validarArchivo = mysqli_real_escape_string($con,$Row[6]);
                }
                
				if($validarArchivo != NULL){ // evitamos subir un archivo diferente
                
                ?>
                        <script> 
                             window.onload=function(){
                           
                                 document.forms["miformulario"].submit();
                             }
                        </script>
                         
                        <form name="miformulario" action="../../centroCostos" method="POST" onsubmit="procesar(this.action);" >
                            <input type="hidden" name="validacionExisteImportacion" value="1">
                        </form> 
                <?php
				}else{
				    
				    
                    if($activarAlerta == FALSE || $activarAlertaCarecterPersona == FALSE || $repiteNombreDocumento == FALSE || $codigoExiste == FALSE || $numerico == FALSE || $repiteNombre == FALSE || $prefijoExiste == FALSE || $repitePrefijo == FALSE || $repiteCodigo == FALSE ||  $cargoExiste == FALSE || $trabajoExiste == FALSE || $campoNullPrefijo == FALSE || $campoNull == FALSE){
                        
                        if($activarAlerta == FALSE){ 
                            $enviarVariableAlerta=1;
                        }
                        
                        //echo 'validaciones';
                        if($campoNull == FALSE){
                           ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformularioNull"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformularioNull" action="../../centroCostos" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="mensajeEnviarCampoVacio" value="<?php echo $mensajeCampoVacio;?>">
                                        <input type="hidden" name="validacionExisteImportacionVacio" value="1">
                                    </form> 
                            <?php 
                        } 
                        
                        
                        if($numerico == FALSE){ //echo 'persona no existe'; 
                            $activarPersona='1';
                            
                        } 
                        
                        
                        if($codigoExiste == FALSE){ 
                            
                            $codigoExisteMostrar='1';
                         } 
                         
                         if($prefijoExiste == FALSE){ 
                            $prefijoExisteMostrar='1';
                         } 
                         
                         if($campoNullPrefijo == FALSE){ 
                            ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformularioNllPrefijo"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformularioNllPrefijo" action="../../centroCostos" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionExisteImportacionPrefijo" value="1">
                                    </form> 
                            <?php
                         } 
                         
                         if($repiteCodigo == FALSE){  
                            ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformularioRepiteCodigo"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformularioRepiteCodigo" action="../../centroCostos" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionExisteImportacionB" value="1">
                                    </form> 
                            <?php
                         } 
                         
                         if($repitePrefijo == FALSE){ 
                            ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformulario"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformulario" action="../../centroCostos" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionExisteImportacionC" value="1">
                                    </form> 
                            <?php
                         } 
                         
                         if($cargoExiste == FALSE){  
                             $activarCargoDueno='1';
                            
                         } 
                         
                         if($trabajoExiste == FALSE){ 
                             $validacionCentroTrabajo='1';
                            
                         } 
                         
                         if($repiteNombre == FALSE){ 
                            $centroCostoExisteMostrar='1';
                         }
                         if($repiteNombreDocumento == FALSE){  //echo '<br>no debería entrar';
                            ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformularioNombreRepiteDocumento"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformularioNombreRepiteDocumento" action="../../centroCostos" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionNombreRepiteDocumento" value="1"> <!-- validacionExisteImportacionC2 -->
                                    </form> 
                            <?php
                         }
                         
                         if($activarAlertaCarecterPersona == FALSE){
                             $redireccionCaracterPersona=1;
                         }
                        
                        
                        
                      
                       
                        
                        
                    }else{
                        
                        
                        
                    if($variableNoRegistrar == 1){    $activarPersona='1';
                        //echo 'No registrar';  //la variable que viaja para detener el registro, entra a esta condicional y obligamos el redireccionamiento con la alerta
                        ?>
                        <script> 
                            setTimeout(clickbutton, 0000);
                            function clickbutton() {
                                 window.onload=function(){
                                           
                                     document.forms["miformularioPersonaRegistros"].submit();
                                 }
                            }
                        
                                 window.onload=function(){
                               
                                     document.forms["miformularioPersonaRegistros"].submit();
                                 }
                            </script>
                                     
                        <form name="miformularioPersonaRegistros" action="../../centroCostos" method="POST" onsubmit="procesar(this.action);" >
                            <input type="hidden" name="validacionExisteImportacionNumericoMensaje" value="<?php echo $string_persona;?>">
                            <input type="hidden" name="validacionExisteImportacionNumerico" value="1">
                        </form> 
                        <noscript></noscript>
                        <?php 
                    }else{
                        
                        //echo 'registro';
                        $con->query("INSERT INTO centroCostos (codigo,prefijo,nombre,idCargo,idCentroTrabajo,persona) VALUES('$codigo','$prefijo','$nombre','$cargo','$cTrabajoID','$idPersona')")or die(mysqli_error($con));
                    
                        ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformularioRegistroAgregado"].submit();
                                 }
                            </script>
                             
                            <form name="miformularioRegistroAgregado" action="../../centroCostos" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionAgregar" value="1">
                            </form> 
                        <?php
                        
                        
                    }
                        
                    
                
                   
                    
                    }//end else
                
                
				} //// para evitar subir otro archivo
             }
        
         }//end for
  }
  else
  { 
        $type = "error";
        $message = "El archivo enviado es invalido. Por favor vuelva a intentarlo";
  }


if($prefijoExisteMostrar == '1'){
                            ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformularioPrefijoExiste"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformularioPrefijoExiste" action="../../centroCostos" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="enviarprefijoExistente" value="<?php echo $enviarprefijoExistente;?>">
                                        <input type="hidden" name="validacionExisteD" value="1">
                                    </form> 
                            <?php
                            
}

if($codigoExisteMostrar == '1'){
                            ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformularioPrefijoExiste"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformularioPrefijoExiste" action="../../centroCostos" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="enviarcodigoExistente" value="<?php echo $enviarcodigoExistente;?>">
                                        <input type="hidden" name="validacionExisteC" value="1">
                                    </form> 
                            <?php
}

if($centroCostoExisteMostrar == '1'){
    ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformularionombreExiste"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformularionombreExiste" action="../../centroCostos" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="enviarNombreExistente" value="<?php echo $enviarNombreExistente;?>">
                                        <input type="hidden" name="validacionExisteNombre" value="1"> <!-- validacionExisteImportacionC2 -->
                                    </form> 
                            <?php
}



if($activarCargoDueno == '1'){
    ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformularioCargoExistente"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformularioCargoExistente" action="../../centroCostos" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionExisteImportacionC1" value="1">
                                        <input type="hidden" name="validacionExisteImportacionC1Mensaje" value="<?php echo $string_dueno;?>">
                                    </form> 
                            <?php
}

if($validacionCentroTrabajo == '1'){ 
    ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformularioTrabajoExiste"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformularioTrabajoExiste" action="../../centroCostos" method="POST" onsubmit="procesar(this.action);" >
                                        <?php
                                        if($variableMensajeE == '1'){
                                        ?>
                                        <input type="hidden" name="validacionExisteImportacionC22" value="1">
                                        <input type="hidden" name="validacionExisteImportacionC2Mensaje2" value="<?php echo $string_cdt;?>">
                                        <?php
                                        }else{
                                        ?>
                                        <input type="hidden" name="validacionExisteImportacionC2" value="1">
                                        <input type="hidden" name="validacionExisteImportacionC2Mensaje" value="<?php echo $string_cdt;?>">
                                        <?php
                                        }
                                        ?>
                                    </form> 
                            <?php
}


if($activarPersona == '1'){
    ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformularioPersona"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformularioPersona" action="../../centroCostos" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionExisteImportacionNumerico" value="1">
                                        <input type="hidden" name="validacionExisteImportacionNumericoMensaje" value="<?php echo $string_persona;?>">
                                    </form> 
                            <?php
}

if($redireccionCaracterPersona == 1){
    ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformularioPersonaRedireccion"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformularioPersonaRedireccion" action="../../centroCostos" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="mensajeRedireccionPersona" value="1">
                                        <input type="hidden" name="mensajeEnviarPersona" value="<?php echo $enviarAlertaCaracterPersona;?>">
                                    </form> 
                            <?php
}
if($enviarVariableAlerta == '1'){ /// esta alerta debe activarse con todas las columnas
  
    //// agregamos todas las variables enviadas por columna
    if($enviarCodigoString != NULL || $enviarCodigoStringL != NULL){ 
        if($tipoValidacionCodigo == '1'){ 
            $almacenajeAlertaCaracter='en la celda '.($enviarCodigoString+1);
            $almacenajeAlertaCaracterTipo='celdaCodigo';
        }
        if($tipoValidacionCodigo == '2'){
            if($enter_encontrado_codigo == '1'){ /// identificamos la alerta activa
                $enter_encontradoCodigo='1';
                $titulo='código';
                $almacenajeAlertaCaracterCelda=$enviarCodigoStringL+1;
                $almacenajeAlertaCaracterTipo='caracterCodigo';
            }else{
                $almacenajeAlertaCaracter=$enviarCodigoStringL;
                $almacenajeAlertaCaracterTipo='caracterCodigo';
            }
        }
        ?>
                            <script> 
                                 window.onload=function(){
                                     document.forms["miformulariocodigo"].submit();
                                 }
                            </script>
                             
                            <form name="miformulariocodigo" action="../../centroCostos" method="POST" onsubmit="procesar(this.action);" >
                                <?php
                                if($enter_encontradoCodigo == '1'){ //// mandamos la alerta del enter, reemplazando la alerta de caractares
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
    
    if($enviarPrefijoString != NULL || $enviarPrefijoStringL != NULL){ 
        if($tipoValidacionPrefijo == '1'){ 
            $almacenajeAlertaCaracter='en la celda '.($enviarPrefijoString+1);
            $almacenajeAlertaCaracterTipo='celdaPrefijo';
        }
        if($tipoValidacionPrefijo == '2'){ 
            if($enter_encontrado_prefijo == '1'){ /// identificamos la alerta activa
                $enter_encontradoPrefijo='1';
                $titulo='prefijo';
                $almacenajeAlertaCaracterCelda=$enviarPrefijoStringL+1;
                $almacenajeAlertaCaracterTipo='caracterPrefijo';
            }else{
                $almacenajeAlertaCaracter=$enviarPrefijoStringL;
                $almacenajeAlertaCaracterTipo='caracterPrefijo';
            }
        }
        ?>
                            <script> 
                                 window.onload=function(){
                                     document.forms["miformularioprefijo"].submit();
                                 }
                            </script>
                             
                            <form name="miformularioprefijo" action="../../centroCostos" method="POST" onsubmit="procesar(this.action);" >
                                <?php
                                if($enter_encontradoPrefijo == '1'){ //// mandamos la alerta del enter, reemplazando la alerta de caractares
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
    
    if($enviarNombreString != NULL || $enviarNombreStringL != NULL){ 
        if($tipoValidacionNombre == '1'){ 
            $almacenajeAlertaCaracterNombre='en la celda '.($enviarNombreString+1);
            $almacenajeAlertaCaracterTipo='celdaNombre';
        }
        if($tipoValidacionNombre == '2'){ 
            
            /// esta validación va al final antes del direccionamiento
            if($enter_encontrado_nombre == '1'){ /// identificamos la alerta activa
                $enter_encontradoNombre='1'; 
                $titulo='centro de costo';
                $almacenajeAlertaCaracterCelda=$enviarNombreStringL+1;
                $almacenajeAlertaCaracterTipo='caracterNombre';
                
            }else{ 
                $almacenajeAlertaCaracterNombre=$enviarNombreStringL;
                $almacenajeAlertaCaracterTipo='caracterNombre';
            }
        }
        ?>
                            <script> 
                                 window.onload=function(){
                                     document.forms["miformularionombre"].submit();
                                 }
                            </script>
                             
                            <form name="miformularionombre" action="../../centroCostos" method="POST" onsubmit="procesar(this.action);" >
                                <?php
                                if($enter_encontradoNombre == '1'){ //// mandamos la alerta del enter, reemplazando la alerta de caractares
                                ?>
                                <input type="hidden" name="alertaEnter"  value="<?php echo $almacenajeAlertaCaracterCelda;?>" >
                                <input type="hidden" name="titulo"  value="<?php echo $titulo;?>" >
                                <?php    
                                }else{
                                ?>
                                <input type="hidden" name="enviarMensajeCaracter"  value="<?php echo $almacenajeAlertaCaracterNombre;?>" >
                                <input type="hidden" name="enviarMensajeCaracterTipo"  value="<?php echo $almacenajeAlertaCaracterTipo;?>" >
                                <?php
                                }
                                ?>
                            </form> 
        <?php
        
    }
    
    if($enviarCargoString != NULL || $enviarCargoStringL != NULL){ 
        if($tipoValidacionCargo == '1'){ 
            $almacenajeAlertaCaracter='en la celda '.($enviarCargoString+1);
            $almacenajeAlertaCaracterTipo='celdaCargo';
        }
        if($tipoValidacionCargo == '2'){  
            if($enter_encontrado_cargo == '1'){ /// identificamos la alerta activa
                $enter_encontradoCargo='1'; 
                 $titulo='cargo del dueño del centro de costos';
                $almacenajeAlertaCaracterCelda=$enviarCargoStringL+1;
                $almacenajeAlertaCaracterTipo='caracterCargo';
            }else{ 
                 'No: '.$almacenajeAlertaCaracter=$enviarCargoStringLT;
                $almacenajeAlertaCaracterTipo='caracterCargo';
            }
            
        }
        ?>
                            <script> 
                                 window.onload=function(){
                                     document.forms["miformulariocargo"].submit();
                                 }
                            </script>
                             
                            <form name="miformulariocargo" action="../../centroCostos" method="POST" onsubmit="procesar(this.action);" >
                                <?php
                                if($enter_encontradoCargo == '1'){ //// mandamos la alerta del enter, reemplazando la alerta de caractares
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
    
    if($enviarCtString != NULL || $enviarCtStringL != NULL){ 
        if($tipoValidacionCt == '1'){ 
            $almacenajeAlertaCaracter='en la celda '.($enviarCtString+1);
            $almacenajeAlertaCaracterTipo='celdaCt';
        }
        if($tipoValidacionCt == '2'){ 
            if($enter_encontrado_centro_trabajo == '1'){ /// identificamos la alerta activa
                $enter_encontradoCT='1';
                $titulo='centro de trabajo';
                $almacenajeAlertaCaracterCelda=$enviarCtStringL+1;
                $almacenajeAlertaCaracterTipo='caracterCt';
            }else{
                $almacenajeAlertaCaracter=$enviarCtStringL;
                $almacenajeAlertaCaracterTipo='caracterCt';
            }
        }
        ?>
                            <script> 
                                 window.onload=function(){
                                     document.forms["miformularioct"].submit();
                                 }
                            </script>
                             
                            <form name="miformularioct" action="../../centroCostos" method="POST" onsubmit="procesar(this.action);" >
                                <?php
                                if($enter_encontradoCT == '1'){ //// mandamos la alerta del enter, reemplazando la alerta de caractares
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
    
    if($enviarResponsableString != NULL || $enviarResponsableStringL != NULL){ 
        if($tipoValidacionResponsable == '1'){ 
            $almacenajeAlertaCaracter='en la celda '.($enviarResponsableString+1);
            $almacenajeAlertaCaracterTipo='celdaResponsable';
        }
        if($tipoValidacionResponsable == '2'){ 
            
            if($enter_encontrado_responsable == '1'){ /// identificamos la alerta activa
                $enter_encontradoRespo='1';
                $titulo='responsable  del centro de costo';
                $almacenajeAlertaCaracterCelda=$enviarResponsableStringL+1;
                $almacenajeAlertaCaracterTipo='caracterResponsable';
            }else{
                $almacenajeAlertaCaracter=$enviarResponsableStringL;
                $almacenajeAlertaCaracterTipo='caracterResponsable';    
            }
            
            
        }
        ?>
                            <script> 
                                 window.onload=function(){
                                     document.forms["miformularioresponsable"].submit();
                                 }
                            </script>
                             
                            <form name="miformularioresponsable" action="../../centroCostos" method="POST" onsubmit="procesar(this.action);" >
                                <?php
                                if($enter_encontradoRespo == '1'){ //// mandamos la alerta del enter, reemplazando la alerta de caractares
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
    
    
    
   
    
  }



    
}   
?>