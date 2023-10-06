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
                            		array('Ñ', 'ñ', 'C', 'c'),
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
                            		array('Ñ', 'ñ', 'C', 'c'),
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
                            	
        $string_centroTrabajo='';
        $string_grupos='';
        $string_cc='';
        
         // se declaran variables para el mensaje de caracteres
        $activarAlerta=TRUE;
        $enviarNombreString='';
        $enviarApellidoString='';
        $enviarTipoString='';
        $enviarDocumentoString='';
        $enviaFechaeString='';
        $enviarCorreoString='';
        $enviarTelefonoString='';
        $enviarProcesoString='';
        $enviarCargoString='';
        $enviarLiderString='';
        $enviarCentroTrabajoString='';
        $enviarArlString='';
        $enviarEpsString='';
        $enviarAfpString='';
        $enviarGrupoString='';
        $activarAlertaEnter=TRUE; ///  variable declarada para el mensaje con campo enter
        
        $sheetCount = count($Reader->sheets());
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
            $contador=0;
            $contadorFecha=0;
            $string="";
            $stringA="";
            $stringB="";
            $contador_repetido_celda_cargos_asociadosA=0;
            $contador_repetido_celda_cargos_asociadosB=0;
            $contador_caracteres_fecha=1;
         $last = end($data);
            foreach ($Reader as $Row )
            {
           $contador++;
           
          
                if($Row[14]=='Para agregar varios grupos de distribución utilice ";"  entre grupos de distribución y sin espacios.'){ continue;} //Aca remplazo por el nombre y posicion de la ultima columna de excel para que no me agrege la primera fila.
                
              
                $nombre = "";
                if(isset($Row[0])) {
                    $nombre = mysqli_real_escape_string($con,$Row[0]);
                     $nombre. ': ';
                     
                     $contadorCeldaNombre++;
                     $buscandoEnterNombre++;
                     
                     if($nombre == ""){
                        $campoNull = FALSE; 
                         $mensajeCampoVacio='en la columna nombre';
                     }else{
                         
                         /// volvemos el texto totalmente en minuscula
                                  $nombre=mb_strtolower($nombre);
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
                     }
                }
                
                $apellido = "";
                if(isset($Row[1])) {
                    $apellido = mysqli_real_escape_string($con,$Row[1]);
                    $contadorCeldaDescripcion++;
                    $buscandoEnterapellido++;
                    
                     //$apellido. ': ';
                     if($apellido == ""){
                        $campoNull = FALSE; 
                         $mensajeCampoVacio='en la columna apellido';
                     }else{
                         
                         /// volvemos el texto totalmente en minuscula
                                  $apellido=mb_strtolower($apellido);
                                 '<br>';
                                 
                            //compruebo que los caracteres sean los permitidos
                            $descripcion_carecteres=['"'];
                            for($bc=0; $bc<count($descripcion_carecteres); $bc++){
                                $descripcion_carecteres[$bc]; 
                                 $cadena_carecteres_descripcion = $descripcion_carecteres[$bc];
                                 ' - '.$coincidencia_caracteres= strpos($apellido, $cadena_carecteres_descripcion);
                                if($coincidencia_caracteres != NULL){
                                    $activarAlerta=FALSE;
                                    $enviarApellidoString.=$contadorCeldaDescripcion.', ';
                                    $tipoValidacionApellido='1';
                                }
                                 '<br>';
                            }
                            
                            if($tipoValidacionApellido == '1'){
                                
                            }else{
                                $permitidosDescripcion = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ ";
                                   for ($i=0; $i<strlen($apellido); $i++){
                                      if (strpos($permitidosDescripcion, substr($apellido,$i,1))===false){
                                         $apellido . " no es válido<br>";
                                         $activarAlerta=FALSE;
                                         $tipoValidacionApellido='2';
                                         $enviarApellidoStringL=$apellido;
                                         //return false;
                                      }
                                   }
                                   
                                   //// validamos el enter antes de enviar la alerta
                                        $cadena_buscada_apellido = '\n';
                                        $posicion_coincidencia_apellido = strpos($apellido, $cadena_buscada_apellido);
                                        if($posicion_coincidencia_apellido === false){
                                           // echo 'si';
                                        }else{
                                           // echo 'no';
                                          $activarAlertaEnter=FALSE;
                                          $enviarResponsableStringLCApellido=$buscandoEnterapellido.',';
                                        }
                                    
                                        if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                            //echo 'enter encontrado';
                                            $enter_encontrado_apellido='1';
                                            $enviarApellidoStringL=$enviarResponsableStringLCApellido;
                                        }else{
                                            $enviarApellidoStringL;
                                        }
                                        
                                    /// end
                            }
                            //// end
                     }
                }
                
                $tipo = "";
                if(isset($Row[2])) {
                    $tipo = mysqli_real_escape_string($con,$Row[2]);
                    $tipo=trim($tipo);
                    $contadorCeldaTipo++;
                    $buscandoEnterTipo++;
                    
                     if($tipo == ""){ 
                        $campoNull = FALSE; 
                        $mensajeCampoVacio='en la columna tipo de documento';
                     }else{ 
                         
                         
                         
                          //compruebo que los caracteres sean los permitidos
                            $tipo_carecteres=['"'];
                            for($bc=0; $bc<count($tipo_carecteres); $bc++){
                                $tipo_carecteres[$bc]; 
                                 $cadena_carecteres_tipo = $tipo_carecteres[$bc];
                                 ' - '.$coincidencia_caracteres= strpos($tipo, $cadena_carecteres_tipo);
                                if($coincidencia_caracteres != NULL){
                                    $activarAlerta=FALSE;
                                    $enviarTipoString.=$contadorCeldaTipo.', ';
                                    $tipoValidacionTipo='1';
                                }
                                 '<br>';
                            }
                            
                            if($tipoValidacionTipo == '1'){
                                
                            }else{
                                $permitidosTipo = "ceCE";
                                   for ($i=0; $i<strlen($tipo); $i++){
                                      if (strpos($permitidosTipo, substr($tipo,$i,1))===false){
                                         $tipo . " no es válido<br>";
                                         $activarAlerta=FALSE;
                                         $tipoValidacionTipo='2';
                                         $enviarTipoStringL=$tipo;
                                         //return false;
                                      }
                                   }
                                   
                                   
                                   //// validamos el enter antes de enviar la alerta
                                        $cadena_buscada_tipo = '\n';
                                        $posicion_coincidencia_tipo = strpos($tipo, $cadena_buscada_tipo);
                                        if($posicion_coincidencia_tipo === false){
                                           // echo 'si';
                                        }else{
                                           // echo 'no';
                                          $activarAlertaEnter=FALSE;
                                          $enviarResponsableStringLCTipo=$buscandoEnterTipo.',';
                                        }
                                    
                                        if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                            //echo 'enter encontrado';
                                            $enter_encontrado_tipo='1';
                                            $enviarTipoStringL=$enviarResponsableStringLCTipo;
                                        }else{
                                            $enviarTipoStringL;
                                        }
                                        
                                    /// end
                                   
                            }
                            //// end
                         
                         
                         
                        $tipo=mb_strtolower($tipo);
                        if($tipo == 'CC' || $tipo == 'cc'){
                            $tipo='C';
                        }elseif($tipo == 'CE' || $tipo == 'ce'){
                            $tipo='E';
                        }else{ 
                            $tipoDocumento=FALSE;
                        }
                        
                         $tipo.'-';
                        
                     }
                }

                $cedula = "";
                if(isset($Row[3])) {
                    
                    $cedula = mysqli_real_escape_string($con,$Row[3]);
                    $cedula=trim($cedula);
                    $contadorCeldaCedula++;
                    $buscandoEnterCedula++;
                    
                    if($cedula == ""){
                        $campoNull = FALSE; 
                         'acá: '.$cedula.'-';
                        $mensajeCampoVacio='en la columna documento de identidad';
                    }else{
                        
                        
                        //compruebo que los caracteres sean los permitidos
                            $cedula_carecteres=['"'];
                            for($bc=0; $bc<count($cedula_carecteres); $bc++){
                                $cedula_carecteres[$bc]; 
                                 $cadena_carecteres_cedula = $cedula_carecteres[$bc];
                                 ' - '.$coincidencia_caracteres= strpos($cedula, $cadena_carecteres_cedula);
                                if($coincidencia_caracteres != NULL){
                                    $activarAlerta=FALSE;
                                    $enviarDocumentoString.=$contadorCeldaCedula.', ';
                                    $tipoValidacionCedula='1';
                                }
                                 '<br>';
                            }
                            
                            if($tipoValidacionCedula == '1'){
                                
                            }else{ 
                                $permitidosCedula = "0123456789";
                                   for ($i=0; $i<strlen($cedula); $i++){
                                      if (strpos($permitidosCedula, substr($cedula,$i,1))===false){
                                         $cedula . " no es válido<br>";
                                         $activarAlerta=FALSE;
                                         $tipoValidacionCedula='2';
                                         $enviarDocumentoStringL=$cedula;
                                         //return false;
                                      }
                                   }
                                   
                                   //// validamos el enter antes de enviar la alerta
                                        $cadena_buscada_cedula = '\n';
                                        $posicion_coincidencia_cedula = strpos($cedula, $cadena_buscada_cedula);
                                        if($posicion_coincidencia_cedula === false){
                                           // echo 'si';
                                        }else{
                                            //echo 'no';
                                          $activarAlertaEnter=FALSE;
                                          $enviarResponsableStringLCedula=$buscandoEnterCedula.',';
                                        }
                                    
                                        if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                            //echo 'enter encontrado';
                                            $enter_encontrado_cedula='1';
                                            $enviarDocumentoStringL=$enviarResponsableStringLCedula;
                                        }else{
                                            $enviarDocumentoStringL;
                                        }
                                        
                                    /// end
                                    
                            }
                            //// end
                        
                        
                        if(is_numeric($cedula)){
                        
                             $compararCedula=$cedula.$tipo;//$tipoEnviar; //echo '<br>';
                             '<br>';
                            $validacion1 = $con->query("SELECT * FROM usuario WHERE cedula = '$compararCedula' ")or die(mysqli_error($con));//consulta a base de datos si el nombre se repite
                            $numNom = mysqli_num_rows($validacion1);
                            
                            if($numNom > 0){
                                $enviarNumeroExistente.=$compararCedula.',';
                                //si el nombre está repetido se pone falso
                                $repiteNombreCedulaExiste = FALSE;
                                //echo "<script>alert('se repite')</script>";
                            }
                            
                            $enviarCadenaCC[].=$cedula; // enviamos una simulación de arreglo fuera del for para detectar campo repetido
                            
                            array_push($arrayCedulas,$cedula);
                            if(in_array($cedula,$arrayCedulas)){ 
                                //echo "<script>alert('SE REPITEEE LA CEDULA EN EL ARCHIVO DE EXCEL')</script>";
                            }
                            
                            
                        }else{  ' (valor numerico cc: '.$cedula.') ';
                            $validarNumericoA=FALSE;
                            $cedula_string.=$cedula.', ';
                        }
                    }
                    
                }
              
                if(count($arrayCedulas) > count(array_unique($arrayCedulas))){//Valido si hay seriales repetidos
                   $repiteNombreCedula = FALSE; 
                }
                
                $fecha = "";
                if(isset($Row[4])) {
                     $fecha = mysqli_real_escape_string($con,$Row[4]);
                     $contador_caracteres_fecha++;
                     '<br>';
                     $contadorCeldaFecha++;
                     $buscandoEnterFecha++;
                     
                    if($fecha == ""){
                        $campoNull = FALSE; 
                        $mensajeCampoVacio='en la columna fecha de nacimiento';
                     }else{
                      
                        //compruebo que los caracteres sean los permitidos
                            $fecha_carecteres=['"'];
                            for($bc=0; $bc<count($fecha_carecteres); $bc++){
                                $fecha_carecteres[$bc]; 
                                 $cadena_carecteres_fecha = $fecha_carecteres[$bc];
                                 ' - '.$coincidencia_caracteres= strpos($fecha, $cadena_carecteres_fecha);
                                if($coincidencia_caracteres != NULL){
                                    $activarAlerta=FALSE;
                                    $enviaFechaeString.=$contadorCeldaFecha.', ';
                                    $tipoValidacionFecha='1';
                                }
                                 '<br>';
                            }
                            
                            if($tipoValidacionFecha == '1'){
                                
                            }else{
                                $permitidosFecha = "0123456789-";
                                   for ($i=0; $i<strlen($fecha); $i++){
                                      if (strpos($permitidosFecha, substr($fecha,$i,1))===false){
                                         $fecha . " no es válido<br>";
                                         $activarAlerta=FALSE;
                                         $tipoValidacionFecha='2';
                                         $enviarFechaStringL=$fecha;
                                         //return false;
                                      }
                                   }
                                   
                                   //// validamos el enter antes de enviar la alerta
                                        $cadena_buscada_fecha_caracter = '\n';
                                        $posicion_coincidencia_fecha_caracter = strpos($fecha, $cadena_buscada_fecha_caracter);
                                        if($posicion_coincidencia_fecha_caracter === false){
                                           // echo 'si';
                                        }else{
                                            //echo 'no';
                                          $activarAlertaEnter=FALSE;
                                          $enviarResponsableStringLFecha=$buscandoEnterFecha.',';
                                        }
                                    
                                        if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                            //echo 'enter encontrado';
                                            $enter_encontradoFecha='1';
                                            $enviarFechaStringL=$enviarResponsableStringLFecha;
                                        }else{
                                            $enviarFechaStringL;
                                        }
                                        
                                    /// end
                            }
                        //// end
                      
                      
                      
                        /// buscamos que solo deje entrar cierto formato de la fecha
                        $cadena_buscada_fecha = '-';
                        $posicion_coincidencia_fecha = strpos($fecha, $cadena_buscada_fecha);
                        
                        
                        /// validamos la cantidad de caracteres permitidos ha entrar
                          
                           ' - contando: '.strlen($fecha);
                           '<br>';
                        if($posicion_coincidencia_fecha === false){
                            $alertaFechaPermitida=FALSE;  
                            $fecha_string_no_permitido=$fecha;
                            ' - aca A: '.$fecha_string_no_permitido='existen caracteres especiales en la celda '.($contador_caracteres_fecha);
                            
                            
                            
                        }else{
                                 $fecha=mb_strtolower($fecha);
                          
                                'cadena: '.$cadena_carecteres=['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','_'];
                                $coincidencia_caracteres_contador='0';
                                for($bc=0; $bc<count($cadena_carecteres); $bc++){
                                    'imprimir: '.$cadena_carecteres[$bc]; 
                                     $cadena_carecteres_fecha = $cadena_carecteres[$bc];
                                     ' - '.$coincidencia_caracteres= strpos($fecha, $cadena_carecteres_fecha);
                                    if($coincidencia_caracteres != NULL){
                                         ' - contando: '.$coincidencia_caracteres_contador='1';
                                    }
                                     '<br>';
                                }
                                
                                 'sale info: '.$coincidencia_caracteres_contador;
                                 '<br>';
                             
                            if($coincidencia_caracteres_contador == 1){
                                $alertaFechaPermitida=FALSE;  
                                $fecha_string_no_permitido=$fecha;
                            }else{ 
                                if(strlen($fecha) > 10 || strlen($fecha) < 10){  ///echo 'si es mayor o menor a 10 digitos';
                                    $alertaFechaPermitida=FALSE;
                                   
                                    
                                    
                                    if(strlen($fecha) < 10){
                                        //Algunas fechas de nacimiento no son permitidas
                                         'a'.$fecha_string_no_permitido='en la celda '.($contador_caracteres_fecha); ///// revisar esta validación, a veces manda celda y otras imprime la fecha o un 1
                                    
                                        
                                    }elseif(strlen($fecha) > 10){
                                         'b'.$fecha_string_no_permitido='en la celda '.($contador_caracteres_fecha);
                                    }else{
                                        'c'.$fecha_string_no_permitido=$fecha;    
                                    }
                                    
                                    
                                }else{ 
                                         'Fecha:'.$fecha=str_replace("/","-",$fecha);
                                    
                                        /// validamos la fecha  del día del mes y del año
                                        
                                        /// validación de días evitando el 0  
                                         '<br>'.$validnadoEdad=substr($fecha,0,4);
                                        if($validnadoEdad ==  0000 ){ 
                                            $enviarDatoAlerta=1;
                                            $alertaEdad=FALSE;
                                             '1 NO';
                                             $string.='('.$fecha.') '; 
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
                                            $stringA.='('.$fecha.') ';  
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
                                         }   
                                    }
                            }
                        }
                        
                        
                        
                     }
                    
                }
                
                $correo = "";
                if(isset($Row[5])) {
                    $correo = mysqli_real_escape_string($con,$Row[5]);
                    $contadorCeldaCorreo++;
                    $buscandoEnterCorreo++;
                    
                    if($correo == ""){
                        $campoNull = FALSE; 
                        $mensajeCampoVacio='en la columna correo electrónico';
                     }else{
                         
                        /// volvemos el texto totalmente en minuscula
                                  $correo=mb_strtolower($correo);
                                  
                        //compruebo que los caracteres sean los permitidos
                            $correo_carecteres=['"'];
                            for($bc=0; $bc<count($correo_carecteres); $bc++){
                                $correo_carecteres[$bc]; 
                                 $cadena_carecteres_correo = $correo_carecteres[$bc];
                                 ' - '.$coincidencia_caracteres= strpos($correo, $cadena_carecteres_correo);
                                if($coincidencia_caracteres != NULL){
                                    $activarAlerta=FALSE;
                                    $enviarCorreoString.=$contadorCeldaCorreo.', ';
                                    $tipoValidacionCorreo='1';
                                }
                                 '<br>';
                            }
                            
                            if($tipoValidacionCorreo == '1'){
                                
                            }else{
                                $permitidosCorreo = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_@.0123456789 ";
                                   for ($i=0; $i<strlen($correo); $i++){
                                      if (strpos($permitidosCorreo, substr($correo,$i,1))===false){
                                         $correo . " no es válido<br>";
                                         $activarAlerta=FALSE;
                                         $tipoValidacionCorreo='2';
                                         $enviarCorreoStringL=$correo;
                                         //return false;
                                      }
                                   }
                                   
                                   //// validamos el enter antes de enviar la alerta
                                        $cadena_buscada_correo = '\n';
                                        $posicion_coincidencia_correo = strpos($correo, $cadena_buscada_correo);
                                        if($posicion_coincidencia_correo === false){
                                           // echo 'si';
                                        }else{
                                           // echo 'no';
                                          $activarAlertaEnter=FALSE;
                                          $enviarResponsableStringLCorreo=$buscandoEnterCorreo.',';
                                        }
                                    
                                        if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                            //echo 'enter encontrado';
                                            $enter_encontrado_correo='1';
                                            $enviarCorreoStringL=$enviarResponsableStringLCorreo;
                                        }else{
                                            $enviarCorreoStringL;
                                        }
                                        
                                    /// end
                            }
                        //// end 
                         
                         
                         
                         
                        $cadena_buscada = '@';
                        $posicion_coincidencia = strpos($correo, $cadena_buscada);
                         
                        if ($posicion_coincidencia === false) {
                            //echo "NO se ha encontrado la palabra deseada!!!!"; echo ' - '.$cedula; echo '<br>';
                            $correoConfirmado=FALSE;
                            $correo_string.=$correo.', ';
                        } else {
                            $correoConfirmado=TRUE;
                            //echo "Éxito!!! Se ha encontrado la palabra buscada en la posición: ".$posicion_coincidencia; echo ' - '.$cedula; echo '<br>';
                        }
                     }
                     
                }
                
                $telefono = "";
                if(isset($Row[6])) {
                    $telefono = mysqli_real_escape_string($con,$Row[6]);
                    $contadorCeldaTelefono++;
                    $buscandoEnterTelefono++;
                     if($telefono == ""){
                        $campoNull = FALSE; 
                        $mensajeCampoVacio='en la columna teléfono';
                     }else{
                         
                            //compruebo que los caracteres sean los permitidos
                            $telefono_carecteres=['"'];
                            for($bc=0; $bc<count($telefono_carecteres); $bc++){
                                $telefono_carecteres[$bc]; 
                                 $cadena_carecteres_telefono = $telefono_carecteres[$bc];
                                 ' - '.$coincidencia_caracteres= strpos($telefono, $cadena_carecteres_telefono);
                                if($coincidencia_caracteres != NULL){
                                    $activarAlerta=FALSE;
                                    $enviarTelefonoString.=$contadorCeldaTelefono.', ';
                                    $tipoValidacionTelefono='1';
                                }
                                 '<br>';
                            }
                            
                            if($tipoValidacionTelefono == '1'){
                                
                            }else{
                                $permitidosTelefono = "0123456789";
                                   for ($i=0; $i<strlen($telefono); $i++){
                                      if (strpos($permitidosTelefono, substr($telefono,$i,1))===false){
                                         $telefono . " no es válido<br>";
                                         $activarAlerta=FALSE;
                                         $tipoValidacionTelefono='2';
                                         $enviarTelefonoStringL=$telefono;
                                         //return false;
                                      }
                                   }
                                    
                                    //// validamos el enter antes de enviar la alerta
                                        $cadena_buscada_telefono = '\n';
                                        $posicion_coincidencia_telefono = strpos($telefono, $cadena_buscada_telefono);
                                        if($posicion_coincidencia_telefono === false){
                                           // echo 'si';
                                        }else{
                                           // echo 'no';
                                          $activarAlertaEnter=FALSE;
                                          $enviarResponsableStringLTelefono=$buscandoEnterTelefono.',';
                                        }
                                    
                                        if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                            //echo 'enter encontrado';
                                            $enter_encontrado_telefono='1';
                                            $enviarTelefonoStringL=$enviarResponsableStringLTelefono;
                                        }else{
                                            $enviarTelefonoStringL;
                                        }
                                        
                                    /// end
                            }
                            //// end
                         
                         
                         if(is_numeric($telefono)){
                             
                         }else{ //echo 'valor numerico teletono';
                            $validarNumericoTT=FALSE; 
                            $telefono_string=$telefono;
                         }
                     }
                }
                
                
                $proceso = "";
                if(isset($Row[7])) {
                    $proceso = mysqli_real_escape_string($con,$Row[7]);
                    $proceso=trim($proceso);
                    $contadorCeldaProceso++;
                    $buscandoEnterProceso++;
                    
                    if($proceso == ""){
                        $campoNull = FALSE;  
                        $mensajeCampoVacio='en la columna proceso';
                     }else{
                     
                     /// volvemos el texto totalmente en minuscula
                                  $proceso=mb_strtolower($proceso);
                     
                        //compruebo que los caracteres sean los permitidos
                        $proceso_carecteres=['"'];
                        for($bc=0; $bc<count($proceso_carecteres); $bc++){
                            $proceso_carecteres[$bc]; 
                             $cadena_carecteres_proceso = $proceso_carecteres[$bc];
                             ' - '.$coincidencia_caracteres= strpos($proceso, $cadena_carecteres_proceso);
                            if($coincidencia_caracteres != NULL){
                                $activarAlerta=FALSE;
                                $enviarProcesoString.=$contadorCeldaProceso.', ';
                                $tipoValidacionProceso='1';
                            }
                             '<br>';
                        }
                        
                        if($tipoValidacionProceso == '1'){
                            
                        }else{
                            $permitidosNombre = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ ";
                               for ($i=0; $i<strlen($proceso); $i++){
                                  if (strpos($permitidosNombre, substr($proceso,$i,1))===false){
                                     $proceso . " no es válido<br>";
                                     $activarAlerta=FALSE;
                                     $tipoValidacionProceso='2';
                                     $enviarProcesoStringL=$proceso;
                                     //return false;
                                  }
                               }
                               
                               //// validamos el enter antes de enviar la alerta
                                        $cadena_buscada_proceso = '\n';
                                        $posicion_coincidencia_proceso = strpos($proceso, $cadena_buscada_proceso);
                                        if($posicion_coincidencia_proceso === false){
                                           // echo 'si';
                                        }else{
                                           // echo 'no';
                                          $activarAlertaEnter=FALSE;
                                          $enviarResponsableStringLProceso=$buscandoEnterProceso.',';
                                        }
                                    
                                        if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                            //echo 'enter encontrado';
                                            $enter_encontrado_proceso='1';
                                            $enviarProcesoStringL=$enviarResponsableStringLProceso;
                                        }else{
                                            $enviarProcesoStringL;
                                        }
                                        
                                    /// end
                                    
                        }
                        //// end
                     
                     
                     
                        $array = explode(' ',$proceso);  // convierte en array separa por espacios;
                        $proceso ='';
                        // quita los campos vacios y pone un solo espacio
                        for ($i=0; $i < count($array); $i++) { 
                            if(strlen($array[$i])>0) {
                                $proceso.= ' ' . $array[$i];
                            }
                        }
                        
                        $proceso=trim($proceso);
                        
                        $validacionProceso = $con->query("SELECT * FROM procesos WHERE nombre = '$proceso'")or die(mysqli_error($con));
                        $extraerNombreProceso=$validacionProceso->fetch_array(MYSQLI_ASSOC);
                        $procesoE = $extraerNombreProceso['id'];
                        ' -- '.$extraerNombreProceso['nombre'];
                        '<br>';
                        $numProceso = mysqli_num_rows($validacionProceso);
                        
                        
                        if($extraerNombreProceso['nombre'] != NULL){
                            
                        }else{
                            $proceso_string.=$proceso.', ';
                        }
                        
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
                      $contadorCeldaCargo++;
                      $buscandoEnterCargo++;
                      
                     if($cargo == ""){
                        $campoNull = FALSE; 
                        $mensajeCampoVacio='en la columna cargo';
                     }else{
                        
                        /// volvemos el texto totalmente en minuscula
                                  $cargo=mb_strtolower($cargo);
                                  
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
                                           // echo 'si';
                                        }else{
                                           // echo 'no';
                                          $activarAlertaEnter=FALSE;
                                          $enviarResponsableStringLCargo=$buscandoEnterCargo.',';
                                        }
                                    
                                        if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                            //echo 'enter encontrado';
                                            $enter_encontrado_cargo='1';
                                            $enviarCargoStringL=$enviarResponsableStringLCargo;
                                        }else{
                                            $enviarCargoStringL;
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
                        
                        $validacionCargo = $con->query("SELECT * FROM cargos WHERE nombreCargos = '$cargo'")or die(mysqli_error($con));
                        $extraerNombreCargo=$validacionCargo->fetch_array(MYSQLI_ASSOC);
                        $numCargo = mysqli_num_rows($validacionCargo);
                        
                        if($extraerNombreCargo['nombreCargos'] != NULL){
                         ' -- '.$extraerNombreCargo['nombreCargos']; 
                        'id cargo: '.$cargoE = $extraerNombreCargo['id_cargos'];
                        }else{
                        
                             ' Nombre cargo: '.$cargo.' -- <font color = "RED">Este cargo no existe en el sistema.</font> ';
                             '<br>';
                             $cargo_string.=$cargo.', ';
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
                    $contadorCeldaLider++;
                    $buscandoEnterLider++;
                    
                    if($lider == ""){
                        $campoNull = FALSE; 
                        $mensajeCampoVacio='en la columna líder';
                     }else{
                        
                        /// volvemos el texto totalmente en minuscula
                                  $lider=mb_strtolower($lider);
                                  
                        //compruebo que los caracteres sean los permitidos
                        $lider_carecteres=['"'];
                        for($bc=0; $bc<count($lider_carecteres); $bc++){
                            $lider_carecteres[$bc]; 
                             $cadena_carecteres_lider = $lider_carecteres[$bc];
                             ' - '.$coincidencia_caracteres= strpos($lider, $cadena_carecteres_lider);
                            if($coincidencia_caracteres != NULL){
                                $activarAlerta=FALSE;
                                $enviarLiderString.=$contadorCeldaLider.', ';
                                $tipoValidacionLider='1';
                            }
                             '<br>';
                        }
                        
                        if($tipoValidacionLider == '1'){
                            
                        }else{
                            $permitidosLider = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ ";
                               for ($i=0; $i<strlen($lider); $i++){
                                  if (strpos($permitidosLider, substr($lider,$i,1))===false){
                                     $lider . " no es válido<br>";
                                     $activarAlerta=FALSE;
                                     $tipoValidacionLider='2';
                                     $enviarLiderStringL=$lider;
                                     //return false;
                                  }
                               }
                               
                                //// validamos el enter antes de enviar la alerta
                                        $cadena_buscada_lider = '\n';
                                        $posicion_coincidencia_lider = strpos($lider, $cadena_buscada_lider);
                                        if($posicion_coincidencia_lider === false){
                                           // echo 'si';
                                        }else{
                                           // echo 'no';
                                          $activarAlertaEnter=FALSE;
                                          $enviarResponsableStringLLider=$buscandoEnterLider.',';
                                        }
                                    
                                        if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                            //echo 'enter encontrado';
                                            $enter_encontrado_lider='1';
                                            $enviarLiderStringL=$enviarResponsableStringLLider;
                                        }else{
                                            $enviarLiderStringL;
                                        }
                                        
                                    /// end
                        }
                        //// end
                        
                        
                        $array = explode(' ',$lider);  // convierte en array separa por espacios;
                        $lider ='';
                        // quita los campos vacios y pone un solo espacio
                        for ($i=0; $i < count($array); $i++) { 
                            if(strlen($array[$i])>0) {
                                $lider.= ' ' . $array[$i];
                            }
                        }
                        
                        $lider=trim($lider);
                        
                        $validacionLider = $con->query("SELECT * FROM cargos WHERE nombreCargos = '$lider'")or die(mysqli_error($con));
                        $extraerNombreLider=$validacionLider->fetch_array(MYSQLI_ASSOC);
                        $numLider = mysqli_num_rows($validacionLider);
                        
                        if($extraerNombreLider['nombreCargos'] != NULL){
                            ' -- '.$extraerNombreLider['nombreCargos']; 
                        }else{
                        
                             ' Nombre del líder: '.$lider.' -- <font color = "RED">Este líder no existe en el sistema.</font> ';
                             '<br>';
                             $lider_string.=$lider.', ';
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
                     $contadorCeldaCentroTrabajo++;
                     $buscandoEnterCentroTrabajo++;
                     $contandoCeldaCargosAsociados++;
                     
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
                                
                                //compruebo que los caracteres sean los permitidos
                                $centroTrabajo_carecteres=['"'];
                                for($bc=0; $bc<count($centroTrabajo_carecteres); $bc++){
                                    $centroTrabajo_carecteres[$bc]; 
                                     $cadena_carecteres_centroTrabajo = $centroTrabajo_carecteres[$bc];
                                     ' - '.$coincidencia_caracteres= strpos($centroTrabajo, $cadena_carecteres_centroTrabajo);
                                    if($coincidencia_caracteres != NULL){
                                        $activarAlerta=FALSE;
                                        $enviarCentroTrabajoString.=$contadorCeldaCentroTrabajo.', ';
                                        $tipoValidacionCentroTrabajo='1';
                                    }
                                     '<br>';
                                }
                                
                                if($tipoValidacionCentroTrabajo == '1'){
                                    
                                }else{
                                    $permitidosCentroTrabajo = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ; ";
                                       for ($i=0; $i<strlen($centroTrabajo); $i++){
                                          if (strpos($permitidosCentroTrabajo, substr($centroTrabajo,$i,1))===false){
                                             $centroTrabajo . " no es válido<br>";
                                             $activarAlerta=FALSE;
                                             $tipoValidacionCentroTrabajo='2';
                                             $enviarCentroTrabajoStringL=$centroTrabajo;
                                             //return false;
                                          }
                                       }
                                       
                                       //// validamos el enter antes de enviar la alerta
                                       //echo 'CEnto T: '.$centroTrabajo;
                                       //echo '<br>';
                                        $cadena_buscada_centroTrabajo = '\n';
                                        $posicion_coincidencia_centroTrabajo = strpos($centroTrabajo, $cadena_buscada_centroTrabajo);
                                        if($posicion_coincidencia_centroTrabajo === false){
                                           // echo 'si';
                                        }else{
                                           // echo 'no';
                                          $activarAlertaEnter=FALSE;
                                          $enviarResponsableStringLcentroTrabajo=$buscandoEnterCentroTrabajo.',';
                                        }
                                    
                                        if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                            'enter encontrado';
                                            $enter_encontrado_centro_trabajo='1';
                                            $enviarCentroTrabajoStringL=$enviarResponsableStringLcentroTrabajo;
                                        }else{
                                            $enviarCentroTrabajoStringL;
                                        }
                                        
                                    /// end
                                }
                                //// end
                    
                                
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
                                      for($repetido=0; $repetido<count($arreglo); $repetido++){
                                          //$centroTrabajoEnviarMensaje.=$arreglo[$repetido].', ';
                                          $sacandoVariableArregloCA=$arreglo[$repetido].',';
                                      }
                                      $centroTrabajoEnviarMensaje.='- En la celda '.($contandoCeldaCargosAsociados+1).' está '.$sacandoVariableArregloCA.'<br>'; /// sacamos en que celda y cuál es el nombre repetido
                            
                                    }else{
                                       "No hay repetidos";
                                    }
                                /// end
                                
                                   '<br><br>';
                                
                                $tamanoArrayCT = count($separarCT);
                                
                                for($k =0; $k <= $tamanoArrayCT; $k++){
                                   
                                    if($separarCT[$k] == ""){
                                        
                                    }else{ 
                                       
                                        $validacionCentroTrabajo = $con->query("SELECT * FROM centrodetrabajo WHERE nombreCentrodeTrabajo = '$separarCT[$k]'")or die(mysqli_error($con));
                                        $extraerNombreCentroDeTrabajo=$validacionCentroTrabajo->fetch_array(MYSQLI_ASSOC);
                                        $numCentroTrabajo = mysqli_num_rows($validacionCentroTrabajo);
                                        
                                        if($extraerNombreCentroDeTrabajo['nombreCentrodeTrabajo'] != NULL){
                                             'Esta en el sistema: ('.$extraerNombreCentroDeTrabajo['nombreCentrodeTrabajo']; 
                                        }else{
                                             ' -- (dato del excel: '.$separarCT[$k].' )';
                                             $string_centroTrabajo.=$separarCT[$k].', ';
                                        }
                                        
                                        if($numCentroTrabajo <= 0){
                                            //si el nombre está repetido se pone falso 
                                            $centroTrabajoValidar = FALSE;
                                        }
                                        
                                    }
                                    
                                    
                                }
                                
                            
                     }
                }
                
                
                $arl = "";
                if(isset($Row[11])) {
                    $arl = mysqli_real_escape_string($con,$Row[11]);
                    $contadorCeldaArl++;
                    $buscandoEnterArl++;
                    
                     if($arl == ""){
                        $campoNull = FALSE; 
                        $mensajeCampoVacio='en la columna ARL';
                     }else{
                         
                         /// volvemos el texto totalmente en minuscula
                                  $arl=mb_strtolower($arl);
                                  
                            //compruebo que los caracteres sean los permitidos
                            $arl_carecteres=['"'];
                            for($bc=0; $bc<count($arl_carecteres); $bc++){
                                $arl_carecteres[$bc]; 
                                 $cadena_carecteres_arl = $arl_carecteres[$bc];
                                 ' - '.$coincidencia_caracteres= strpos($arl, $cadena_carecteres_arl);
                                if($coincidencia_caracteres != NULL){
                                    $activarAlerta=FALSE;
                                    $enviarArlString.=$contadorCeldaArl.', ';
                                    $tipoValidacionArl='1';
                                }
                                 '<br>';
                            }
                            
                            if($tipoValidacionArl == '1'){
                                
                            }else{
                                
                                    $permitidosArl = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ ";
                                    for ($i=0; $i<strlen($arl); $i++){
                                        if (strpos($permitidosArl, substr($arl,$i,1))===false){
                                            $arl . " no es válido<br>";
                                            
                                            $posicion_coincidencia_arl = strpos($arl, $cadena_buscada_arl);
                                            if($posicion_coincidencia_arl === false){
                                                $activarAlerta=FALSE;
                                            }else{
                                                
                                            }
                                            
                                            $tipoValidacionArl='2';
                                            $enviarArlStringL=$arl;
                                            //return false;
                                        }
                                    }
                                   
                                   
                                        $activarAlertaARL=TRUE;
                                        $cadena_buscada_arl = '\n';
                                        $posicion_coincidencia_arl = strpos($arl, $cadena_buscada_arl);
                                        
                                        if($posicion_coincidencia_arl === false){
                                            'si '.$arl;
                                        }else{
                                           'no '.$arl;
                                          $activarAlertaARL=FALSE;
                                          $enviarResponsableStringLcentroTrabajo=$buscandoEnterArl.',';
                                        }
                                        
                                        
                                        if($activarAlertaARL == FALSE){ /// activamos la alerta del mensaje del enter
                                             'enter encontrado arl: ( '.$arl.' )';
                                            $enter_encontrado_arl='1';
                                             '<br>numero capsula: '.$enviarArlStringL=$enviarResponsableStringLcentroTrabajo;
                                                                        $envioARLOculto=$enviarResponsableStringLcentroTrabajo;
                                        }else{
                                            $enviarArlStringL;
                                        }
                                    
                                        
                                    /// end
                            } 
                            //// end
                     }
                }
                
                
                $eps = "";
                if(isset($Row[12])) {
                    $eps = mysqli_real_escape_string($con,$Row[12]);
                    $contadorCeldaEps++;
                    $buscandoEnterEps++;
                    
                     if($eps == ""){
                        $campoNull = FALSE; 
                        $mensajeCampoVacio='en la columna EPS';
                     }else{
                         
                         /// volvemos el texto totalmente en minuscula
                                  $eps=mb_strtolower($eps);
                                  
                         //compruebo que los caracteres sean los permitidos
                        $eps_carecteres=['"'];
                        for($bc=0; $bc<count($eps_carecteres); $bc++){
                            $eps_carecteres[$bc]; 
                             $cadena_carecteres_eps = $eps_carecteres[$bc];
                             ' - '.$coincidencia_caracteres= strpos($eps, $cadena_carecteres_eps);
                            if($coincidencia_caracteres != NULL){
                                $activarAlerta=FALSE;
                                $enviarEpsString.=$contadorCeldaEps.', ';
                                $tipoValidacionEps='1';
                            }
                             '<br>';
                        }
                        
                        if($tipoValidacionEps == '1'){
                            
                        }else{
                            $permitidosEps = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ ";
                               for ($i=0; $i<strlen($eps); $i++){
                                  if (strpos($permitidosEps, substr($eps,$i,1))===false){
                                     $eps . " no es válido<br>";
                                     $activarAlerta=FALSE;
                                     $tipoValidacionEps='2';
                                     $enviarEpsStringL=$eps;
                                     //return false;
                                  }
                               }
                               
                               //// validamos el enter antes de enviar la alerta
                                        $cadena_buscada_eps = '\n';
                                        $posicion_coincidencia_eps = strpos($eps, $cadena_buscada_eps);
                                        if($posicion_coincidencia_eps === false){
                                           // echo 'si';
                                        }else{
                                           // echo 'no';
                                          $activarAlertaEnter=FALSE;
                                          $enviarResponsableStringLEps=$buscandoEnterEps.',';
                                        }
                                    
                                        if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                            //echo 'enter encontrado';
                                            $enter_encontrado_eps='1';
                                            $enviarEpsStringL=$enviarResponsableStringLEps;
                                        }else{
                                            $enviarEpsStringL;
                                        }
                                        
                                    /// end
                        }
                        //// end
                         
                     }
                    
                }
                
                
                $afp = "";
                if(isset($Row[13])) {
                    $afp = mysqli_real_escape_string($con,$Row[13]);
                    $contadorCeldaAfp++;
                    $buscandoEnterAfp++;
                    
                     if($afp == ""){
                        $campoNull = FALSE; 
                        $mensajeCampoVacio='en la columna AFP';
                     }else{
                         
                         /// volvemos el texto totalmente en minuscula
                                  $afp=mb_strtolower($afp);
                         
                         //compruebo que los caracteres sean los permitidos
                            $afp_carecteres=['"'];
                            for($bc=0; $bc<count($afp_carecteres); $bc++){
                                $afp_carecteres[$bc]; 
                                 $cadena_carecteres_afp = $afp_carecteres[$bc];
                                 ' - '.$coincidencia_caracteres= strpos($afp, $cadena_carecteres_afp);
                                if($coincidencia_caracteres != NULL){
                                    $activarAlerta=FALSE;
                                    $enviarAfpString.=$contadorCeldaAfp.', ';
                                    $tipoValidacionAfp='1';
                                }
                                 '<br>';
                            }
                            
                            if($tipoValidacionAfp == '1'){
                                
                            }else{
                                $permitidosAfp = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ ";
                                   for ($i=0; $i<strlen($afp); $i++){
                                      if (strpos($permitidosAfp, substr($afp,$i,1))===false){
                                         $afp . " no es válido<br>";
                                         $activarAlerta=FALSE;
                                         $tipoValidacionAfp='2';
                                         $enviarAfpStringL=$afp;
                                         //return false;
                                      }
                                   }
                                   
                                   
                                   //// validamos el enter antes de enviar la alerta
                                        $cadena_buscada_afp = '\n';
                                        $posicion_coincidencia_afp = strpos($afp, $cadena_buscada_afp);
                                        if($posicion_coincidencia_afp === false){
                                           // echo 'si';
                                        }else{
                                           // echo 'no';
                                          $activarAlertaEnter=FALSE;
                                          $enviarResponsableStringLAfp=$buscandoEnterAfp.',';
                                        }
                                    
                                        if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                            //echo 'enter encontrado';
                                            $enter_encontrado_afp='1';
                                            $enviarAfpStringL=$enviarResponsableStringLAfp;
                                        }else{
                                            $enviarAfpStringL;
                                        }
                                        
                                    /// end
                                   
                            }
                            //// end
                     }
                    
                }
                
                $grupos = ""; 
                if(isset($Row[14])) {
                    
                    $grupos = mysqli_real_escape_string($con,$Row[14]);
                    $grupos=trim($grupos);
                    $contadorCeldaGrupo++;
                    $buscandoEnterGrupo++;
                    $contandoCeldagruposDistribucion++;
                     
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
                                
                                    //compruebo que los caracteres sean los permitidos
                                    $grupo_carecteres=['"'];
                                    for($bc=0; $bc<count($grupo_carecteres); $bc++){
                                        $grupo_carecteres[$bc]; 
                                         $cadena_carecteres_grupo = $grupo_carecteres[$bc];
                                         ' - '.$coincidencia_caracteres= strpos($grupos, $cadena_carecteres_grupo);
                                        if($coincidencia_caracteres != NULL){
                                            $activarAlerta=FALSE;
                                            $enviarGrupoString.=$contadorCeldaGrupo.', ';
                                            $tipoValidacionGrupo='1';
                                        }
                                         '<br>';
                                    }
                                    
                                    if($tipoValidacionGrupo == '1'){
                                        
                                    }else{
                                        $permitidosGrupo = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ; ";
                                           for ($i=0; $i<strlen($grupos); $i++){
                                              if (strpos($permitidosGrupo, substr($grupos,$i,1))===false){
                                                 $grupos . " no es válido<br>";
                                                 $activarAlerta=FALSE;
                                                 $tipoValidacionGrupo='2';
                                                 $enviarGrupoStringL=$grupos;
                                                 //return false;
                                              }
                                           }
                                           
                                            //// validamos el enter antes de enviar la alerta
                                                $cadena_buscada_grupo = '\n';
                                                $posicion_coincidencia_grupo = strpos($grupos, $cadena_buscada_grupo);
                                                if($posicion_coincidencia_grupo === false){
                                                   // echo 'si';
                                                }else{
                                                   // echo 'no';
                                                  $activarAlertaEnter=FALSE;
                                                  $enviarResponsableStringLGrupo=$buscandoEnterGrupo.',';
                                                }
                                            
                                                if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                                    //echo 'enter encontrado';
                                                    $enter_encontrado_grupo='1';
                                                    $enviarGrupoStringL=$enviarResponsableStringLGrupo;
                                                }else{
                                                    $enviarGrupoStringL;
                                                }
                                            /// end
                                    }
                                    //// end 
                                
                               
                               
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
                                    $separarGrupos = explode(";", $f_outputString);
                                    
                                     // leemos el array para verificar repetidos dentro de la celda
                                         $arregloGrupo=$separarGrupos; 
                                        if(count($arregloGrupo) > count(array_unique($arregloGrupo))){
                                           "¡Hay repetidos!";
                                          $repiteGrupos=FALSE;
                                          for($repetidoGrupos=0; $repetidoGrupos<count($arregloGrupo); $repetidoGrupos++){
                                              //$gruposEnviarMensaje.=$arregloGrupo[$repetidoGrupos].', ';
                                              $sacandoVariableGrupoDeDistribucion=$arregloGrupo[$repetidoGrupos].', ';
                                          }
                                          $gruposEnviarMensaje.='- En la celda '.($contandoCeldagruposDistribucion+1).' está '.$sacandoVariableGrupoDeDistribucion.'<br>';
                                        }else{
                                           "No hay repetidos";
                                        }
                                    /// end
                                    
                                     '<br><br>';
                                    $tamanoArray = count($separarGrupos);
                                    
                                    for($m =0; $m <= $tamanoArray; $m++){
                                       
                                        if($separarGrupos[$m] == ""){
                                            
                                        }else{
                                            
                                          /*
                                          
                                          */
                                            $separarGrupos[$m];  '<br>';
                                            $validacionGrupo = $con->query("SELECT * FROM grupo WHERE nombre = '$separarGrupos[$m]'")or die(mysqli_error($con));
                                            $extraerNombreValidarGrupoDistri=$validacionGrupo->fetch_array(MYSQLI_ASSOC);
                                            $numGrupo = mysqli_num_rows($validacionGrupo);
                                            
                                            if($extraerNombreValidarGrupoDistri['nombre'] != NULL){
                                                 ' -- '.$extraerNombreValidarGrupoDistri['nombre']; 
                                            }else{
                                            
                                                 ' Grupos de distribución: '.$m.' '.$separarGrupos[$m].' -- <font color = "RED">Este grupo de distribución no existe en el sistema.</font> ';
                                                 '<br>';
                                                 $string_grupos.=$separarGrupos[$m].', ';
                                            }
                                            
                                            if($numGrupo <= 0){
                                                //si el nombre está repetido se pone falso 
                                                $centroGrupoValidar = FALSE; //FALSE
                                            }
                                            
                                        }
                                        
                                        
                                    }
                                
                                
                    }
                }
                
                
               // echo 'dato: '.end($row['4']);        
                
             /// colocamos el simulador de conteo de demora
            ?>
            <script>
                setTimeout(myGreeting, 5000);
                function myGreeting() {
                        document.forms["formularioFallaFecha"].submit();
                }
            </script>
            
            <form id="formularioFallaFecha" action="../../usuarios" method="POST" onsubmit="procesar(this.action);" >
                <input name="mensajeAlertaFechaFallo" value="1" type="hidden">
            </form>                             
             
            <? 
                
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
        
        
        
        if($repiteNombreCedula == FALSE){ /// colocamos la validación de campo repetido activado
           // extraemos los datos de la variable que almacena datos repetidos
            foreach (array_count_values($enviarCadenaCC) as $valor => $repeticiones) {
                if ($repeticiones>1) {
                     $string_cc.=$valor.', ';
                }
            }

            $vaidacion_repiteCC=1;
                
        }else{ 
            
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
                                    $tipo='C';
                                }elseif($tipo == 'CE' || $tipo == 'ce'){
                                    $tipo='E';
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
                            $fecha=trim($fecha); 
                           if($fecha == ""){ //echo '<br>buscando error cedula';
                               $campoNull = FALSE;
                           }else{
                               
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
                                    
                                    $extraeID = $con->query("SELECT * FROM cargos WHERE nombreCargos = '$cargo' ")or die(mysqli_error($con));  
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
                                
                                $extraeID = $con->query("SELECT * FROM cargos WHERE nombreCargos = '$lider' ")or die(mysqli_error($con));  
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
                        if(isset($Row[14])) {
                            $validarArchivo = mysqli_real_escape_string($con,$Row[14]); 
                             'campo: '.$validarArchivo;
                            if($validarArchivo != null){  //echo '<br>buscando error archivo';
                                
                                $validarArchivo=1;
                            }else{
                                 $campoNull = FALSE;
                            }
                        }
                        //$validarArchivo < 0 || $validarArchivo > 0
        				if($validarArchivo > 0){ // evitamos subir un archivo diferente
                        
                        
                         
                            
                           if($activarAlerta == FALSE || $alertaFechaPermitida == FALSE || $repiteNombreCedulaExiste == FALSE || $repiteGrupos == FALSE || $repiteCargoAsociado == FALSE || $validarNumericoTT == FALSE || $correoConfirmado == FALSE || $alertaEdad == FALSE || $validarNumericoA == FALSE || $tipoDocumento == FALSE || $cedulaValidar == FALSE || $cargoValidar == FALSE || $liderValidar == FALSE || $procesoValidar == FALSE || $centroTrabajoValidar == FALSE || $centroGrupoValidar == FALSE || $repiteNombreCedula == FALSE || $campoNull == FALSE){ //$centroCostoValidar == FALSE || 
                             // echo 'Validaciones';
                             
                                if($activarAlerta == FALSE){ 
                                    $enviarVariableAlerta=1;
                                }

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
                                                <input name="mensaje_existente_usuario" value="<?php echo $enviarNumeroExistente;?>" type="hidden">
                                                <input type="hidden" name="validacionExisteImportacionGExiste" value="1">
                                            </form> 
                                    <?php
                                }
                                
                                if($repiteNombreCedula == FALSE){      //echo 'repite cc';
                                $vaidacion_repiteCC='1';
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
                                        }elseif($stringA != NULL){
                                        ?>
                                        <input name="variableFecha" value="<?php echo $stringA; ?>" type="hidden">
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
                                 
                                            
                                                $tituloA='Nuevo usuario creado';
                                                $mensajeA='Se crea usuario para el señor '.$nombre.' '.$apellido;
                                                
                                                date_default_timezone_set('America/Bogota');
                                                $fechaA=date('Y-m-j h:i:s A');
                                               
                                                
                                                $enviarCedulaTipo=$cedula.''.$tipo;//$tipoEnviar;
                                                
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
                                                                
                                                                $extraeID = $con->query("SELECT * FROM grupo WHERE nombre = '$nombreGrupo'")or die(mysqli_error($con));  
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
                                                                
                                                                $extraeIDCentroTrabajo = $con->query("SELECT * FROM centrodetrabajo WHERE nombreCentrodeTrabajo  = '$nombreCentroTrabajoValidar'")or die(mysqli_error($con));  
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
                            
                                            //echo '<br>Registrar<br>'; 
                                            
                                            $query = "INSERT INTO usuario (nombres,apellidos,cedula,telefono,correo,cargo,lider,fechaNacimiento,proceso,arl,eps,afp,clave,estadoEliminado,sesionIP,estadoUsuario,contadorSesion,correos)
                                            VALUES('$nombre','$apellido','$enviarCedulaTipo','$telefono','$correo','$cargoE','$liderE','$fecha','$procesoE','$arl','$eps','$afp','$cedula','0','$direccionIPEmpresa','desconectado','0','1')";
                                            $resultados = mysqli_query($con, $query)or die(mysqli_error($con));
                                            
                                            $nombreCompleto=$nombre.' '.$apellido;
                                            $agora = date('Y-m-d H:i:s');
                        					$limite = date('Y-m-d H:i:s', strtotime('+2 min'));
                        					
                        					$ran_id = rand(time(), 100000000);    
                                            $con->query("INSERT INTO users (unique_id, fname, lname, email, password, status)VALUES ({$ran_id}, '{$nombre}','{$apellido}', '{$enviarCedulaTipo}', '{$enviarCedulaTipo}', 'Offline now')");
                                            
                                            ?>
                                                <script> 
                                                     window.onload=function(){
                                                         //alert("Importado con éxito");
                                                         document.forms["miformularioCorreos"].submit();
                                                     }
                                                </script>
                                                 
                                                <form name="miformularioCorreos" action="validacion_correos" method="POST" onsubmit="procesar(this.action);" > <!--  importacion/importar-usuario/correos   -->
                                                    <input type="hidden" name="validacionAgregar" value="1">
                                                </form> 
                                            <?php
                                        
                                    }              
                           }//end else  
                         
                        }else{ 
                           
                                        ?>
                                                <script> 
                                                     window.onload=function(){
                                                    
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
                                        }elseif($stringA != NULL){
                                        ?>
                                        <input name="variableFecha" value="<?php echo $stringA; ?>" type="hidden">
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
   
    if($redireccionAlertaFechaPermitid == 1){ 
        ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformularioAlertaedadFechaPermitida"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformularioAlertaedadFechaPermitida" action="../../usuarios" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="alertaFechaPermitida" value="1">
                                        <input name="mensajeFechaNoPermitido" value="<?php echo $fecha_string_no_permitido;?>" type="hidden">
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
            <input name="mensajeCedula" value="<?php echo $cedula_string;?>" type="hidden">
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
            <input name="mensajeCorreo" value="<?php echo $correo_string;?>" type="hidden">
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
            <input name="mensajeTelefono" value="<?php echo $telefono_string;?>" type="hidden">
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
                                          <input name="mensajeProceso" value="<?php echo $proceso_string;?>" type="hidden">
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
                                        <input name="mensajeCargo" type="hidden" value="<?php echo $cargo_string;?>">
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
                                          <input name="mensajeLider" type="hidden" value="<?php echo $lider_string;?>">
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
                                          <input name="mensajeCentroTrabajo" value="<?php echo $string_centroTrabajo;?>" type="hidden">
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
                                        <input name="mensajeRepetidoCentroTrabajo" value="<?php echo '<br>'.$centroTrabajoEnviarMensaje;?>" type="hidden">
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
                                        <input name="mensajeRepetidoGrupos" value="<?php echo '<br>'.$gruposEnviarMensaje;?>" type="hidden">
                                    </form> 
                                <?php 
    }
   
    
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
                                          <input type="hidden" name="mensajeRepiteGrupo" value="<?php echo $string_grupos;?>">
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
                    $titulo='El nombre';
                    $almacenajeAlertaCaracterCelda=$enviarNombreStringL+1;
                    $almacenajeAlertaCaracterTipo='caracterNombre';
                }else{
                    $almacenajeAlertaCaracter=$enviarNombreStringL;
                    $almacenajeAlertaCaracterTipo='caracterNombre';
                }
            }
            
        }
        
        if($enviarApellidoString != NULL || $enviarApellidoStringL != NULL){ 
            if($tipoValidacionApellido == '1'){ 
                $almacenajeAlertaCaracter='en la celda '.($enviarApellidoString+1);
                $almacenajeAlertaCaracterTipo='celdaApellido';
            }
            if($tipoValidacionApellido == '2'){ 
                if($enter_encontrado_apellido == '1'){ /// identificamos la alerta activa
                    $enter_encontrado='1';
                    $titulo='El apellido';
                    $almacenajeAlertaCaracterCelda=$enviarApellidoStringL+1;
                    $almacenajeAlertaCaracterTipo='caracterApellido';
                }else{
                    $almacenajeAlertaCaracter=$enviarApellidoStringL;
                    $almacenajeAlertaCaracterTipo='caracterApellido';
                }
            }
            
        }
        
        if($enviarTipoString != NULL || $enviarTipoStringL != NULL){ 
            if($tipoValidacionTipo == '1'){ 
                $almacenajeAlertaCaracter='en la celda '.($enviarTipoString+1);
                $almacenajeAlertaCaracterTipo='celdaTipo';
            }
            if($tipoValidacionTipo == '2'){ 
                if($enter_encontrado_tipo == '1'){ /// identificamos la alerta activa
                    $enter_encontrado='1';
                    $titulo='El tipo de documento';
                    $almacenajeAlertaCaracterCelda=$enviarTipoStringL+1;
                    $almacenajeAlertaCaracterTipo='caracterTipo';
                }else{
                    $almacenajeAlertaCaracter=$enviarTipoStringL;
                    $almacenajeAlertaCaracterTipo='caracterTipo';
                }
            }
            
        }
        
        if($enviarDocumentoString != NULL || $enviarDocumentoStringL != NULL){ 
            if($tipoValidacionCedula == '1'){ 
                $almacenajeAlertaCaracter='en la celda '.($enviarDocumentoString+1);
                $almacenajeAlertaCaracterTipo='celdaDocumento';
            }
            if($tipoValidacionCedula == '2'){ 
                if($enter_encontrado_cedula == '1'){ /// identificamos la alerta activa
                    $enter_encontrado='1';
                    $titulo='El documento de identidad';
                    $almacenajeAlertaCaracterCelda=$enviarDocumentoStringL+1;
                    $almacenajeAlertaCaracterTipo='caracterDocumento';
                }else{
                    $almacenajeAlertaCaracter=$enviarDocumentoStringL;
                    $almacenajeAlertaCaracterTipo='caracterDocumento';
                }
            }
            
        }
        
        if($enviaFechaeString != NULL || $enviarFechaStringL != NULL){ 
            if($tipoValidacionFecha == '1'){ 
               $almacenajeAlertaCaracter='en la celda '.($enviaFechaeString+1);
               $almacenajeAlertaCaracterTipo='celdaFecha';
            }
            if($tipoValidacionFecha == '2'){ 
                if($enter_encontradoFecha == '1'){ /// identificamos la alerta activa
                    $enter_encontrado='1';
                    $titulo='La fecha de nacimiento';
                    $almacenajeAlertaCaracterCelda=$enviarFechaStringL+1;
                    $almacenajeAlertaCaracterTipo='caracterFecha';
                }else{
                    $almacenajeAlertaCaracter=$enviarFechaStringL;
                    $almacenajeAlertaCaracterTipo='caracterFecha';
                }
            }
            
        }
        
        if($enviarCorreoString != NULL || $enviarCorreoStringL != NULL){ 
            if($tipoValidacionCorreo == '1'){ 
               $almacenajeAlertaCaracter='en la celda '.($enviarCorreoString+1);
               $almacenajeAlertaCaracterTipo='celdaCorreo';
            }
            if($tipoValidacionCorreo == '2'){ 
                if($enter_encontrado_correo == '1'){ /// identificamos la alerta activa
                    $enter_encontrado='1';
                    $titulo='El correo';
                    $almacenajeAlertaCaracterCelda=$enviarCorreoStringL+1;
                    $almacenajeAlertaCaracterTipo='caracterCorreo';
                }else{
                    $almacenajeAlertaCaracter=$enviarCorreoStringL;
                    $almacenajeAlertaCaracterTipo='caracterCorreo';
                }
            }
            
        }
        
        if($enviarTelefonoString != NULL || $enviarTelefonoStringL != NULL){ 
            if($tipoValidacionTelefono == '1'){ 
               $almacenajeAlertaCaracter='en la celda '.($enviarTelefonoString+1);
               $almacenajeAlertaCaracterTipo='celdaTelefono';
            }
            if($tipoValidacionTelefono == '2'){ 
                
                if($enter_encontrado_telefono == '1'){ /// identificamos la alerta activa
                    $enter_encontrado='1';
                    $titulo='El teléfono';
                    $almacenajeAlertaCaracterCelda=$enviarTelefonoStringL+1;
                    $almacenajeAlertaCaracterTipo='caracterTelefono';
                }else{
                    $almacenajeAlertaCaracter=$enviarTelefonoStringL;
                    $almacenajeAlertaCaracterTipo='caracterTelefono';
                }
            }
            
        }
        
        if($enviarProcesoString != NULL || $enviarProcesoStringL != NULL){ 
            if($tipoValidacionProceso == '1'){ 
               $almacenajeAlertaCaracter='en la celda '.($enviarProcesoString+1);
               $almacenajeAlertaCaracterTipo='celdaProceso';
            }
            if($tipoValidacionProceso == '2'){ 
                if($enter_encontrado_proceso == '1'){ /// identificamos la alerta activa
                    $enter_encontrado='1';
                    $titulo='El proceso';
                    $almacenajeAlertaCaracterCelda=$enviarProcesoStringL+1;
                    $almacenajeAlertaCaracterTipo='caracterProceso';
                }else{
                    $almacenajeAlertaCaracter=$enviarProcesoStringL;
                    $almacenajeAlertaCaracterTipo='caracterProceso';
                }
            }
            
        }
        
        if($enviarCargoString != NULL || $enviarCargoStringL != NULL){ 
            if($tipoValidacionCargo == '1'){ 
               $almacenajeAlertaCaracter='en la celda '.($enviarCargoString+1);
               $almacenajeAlertaCaracterTipo='celdaCargo';
            }
            if($tipoValidacionCargo == '2'){ 
                if($enter_encontrado_cargo == '1'){ /// identificamos la alerta activa
                    $enter_encontrado='1';
                    $titulo='El cargo';
                    $almacenajeAlertaCaracterCelda=$enviarCargoStringL+1;
                    $almacenajeAlertaCaracterTipo='caracterCargo';
                }else{
                    $almacenajeAlertaCaracter=$enviarCargoStringL;
                    $almacenajeAlertaCaracterTipo='caracterCargo';
                }
            }
            
        }
        
        if($enviarLiderString != NULL || $enviarLiderStringL != NULL){ 
            if($tipoValidacionLider == '1'){ 
               $almacenajeAlertaCaracter='en la celda '.($enviarLiderString+1);
               $almacenajeAlertaCaracterTipo='celdaLider';
            }
            if($tipoValidacionLider == '2'){ 
                if($enter_encontrado_lider == '1'){ /// identificamos la alerta activa
                    $enter_encontrado='1';
                    $titulo='El líder';
                    $almacenajeAlertaCaracterCelda=$enviarLiderStringL+1;
                    $almacenajeAlertaCaracterTipo='caracterLider';
                }else{
                    $almacenajeAlertaCaracter=$enviarLiderStringL;
                    $almacenajeAlertaCaracterTipo='caracterLider';
                }
            }
            
        }
        
        if($enviarCentroTrabajoString != NULL || $enviarCentroTrabajoStringL != NULL){ 
            if($tipoValidacionCentroTrabajo == '1'){ 
               $almacenajeAlertaCaracter='en la celda '.($enviarCentroTrabajoString+1);
               $almacenajeAlertaCaracterTipo='celdaCentroTrabajo';
            }
            if($tipoValidacionCentroTrabajo == '2'){ 
                if($enter_encontrado_centro_trabajo == '1'){ /// identificamos la alerta activa
                    $enter_encontrado='1';
                    $titulo='El centro de trabajo';
                    $almacenajeAlertaCaracterCelda=$enviarCentroTrabajoStringL+1;
                    $almacenajeAlertaCaracterTipo='caracterCentroTrabajo';
                }else{
                    $almacenajeAlertaCaracter=$enviarCentroTrabajoStringL;
                    $almacenajeAlertaCaracterTipo='caracterCentroTrabajo';
                }
            }
            
        }
         
         '<br>L: '.$enviarArlStringL;
         '<br> '.$enviarArlString;
        if($enviarArlString != NULL || $enviarArlStringL != NULL){ //echo 'alerta arl';
            if($tipoValidacionArl == '1'){ 
               $almacenajeAlertaCaracter='en la celda '.($enviarArlString+1);
               $almacenajeAlertaCaracterTipo='celdaArl';
            }
            if($tipoValidacionArl == '2'){ 
                if($enter_encontrado_arl == '1'){ /// identificamos la alerta activa
                    $enter_encontrado='1';
                    $titulo='La ARL';
                    'dato oculto: '.$envioARLOculto;
                    '<br>celda: '.$almacenajeAlertaCaracterCelda=$envioARLOculto+1; //$enviarArlStringL
                    $almacenajeAlertaCaracterTipo='caracterArl';
                }else{
                    'respuesta caracter: '.$almacenajeAlertaCaracter=$enviarArlStringL;
                    $almacenajeAlertaCaracterTipo='caracterArl';
                }
            }
            
        }
        
        if($enviarEpsString != NULL || $enviarEpsStringL != NULL){ 
            if($tipoValidacionEps == '1'){ 
               $almacenajeAlertaCaracter='en la celda '.($enviarEpsString+1);
               $almacenajeAlertaCaracterTipo='celdaEps';
            }
            if($tipoValidacionEps == '2'){ 
                if($enter_encontrado_eps == '1'){ /// identificamos la alerta activa
                    $enter_encontrado='1';
                    $titulo='La EPS';
                    $almacenajeAlertaCaracterCelda=$enviarEpsStringL+1;
                    $almacenajeAlertaCaracterTipo='caracterEps';
                }else{
                    $almacenajeAlertaCaracter=$enviarEpsStringL;
                    $almacenajeAlertaCaracterTipo='caracterEps';
                }
            }
            
        }
        
        if($enviarAfpString != NULL || $enviarAfpStringL != NULL){ 
            if($tipoValidacionAfp == '1'){ 
               $almacenajeAlertaCaracter='en la celda '.($enviarAfpString+1);
               $almacenajeAlertaCaracterTipo='celdaAfp';
            }
            if($tipoValidacionAfp == '2'){ 
                if($enter_encontrado_afp == '1'){ /// identificamos la alerta activa
                    $enter_encontrado='1';
                    $titulo='La AFP';
                    $almacenajeAlertaCaracterCelda=$enviarAfpStringL+1;
                    $almacenajeAlertaCaracterTipo='caracterAfp';
                }else{
                    $almacenajeAlertaCaracter=$enviarAfpStringL;
                    $almacenajeAlertaCaracterTipo='caracterAfp';
                }
            }
            
        }
        
        if($enviarGrupoString != NULL || $enviarGrupoStringL != NULL){ 
            if($tipoValidacionGrupo == '1'){ 
               $almacenajeAlertaCaracter='en la celda '.($enviarGrupoString+1);
               $almacenajeAlertaCaracterTipo='celdaGrupo';
            }
            if($tipoValidacionGrupo == '2'){ 
                if($enter_encontrado_grupo == '1'){ /// identificamos la alerta activa
                    $enter_encontrado='1';
                    $titulo='El grupo de distribución';
                    $almacenajeAlertaCaracterCelda=$enviarGrupoStringL+1;
                    $almacenajeAlertaCaracterTipo='caracterGrupo';
                }else{
                    $almacenajeAlertaCaracter=$enviarGrupoStringL;
                    $almacenajeAlertaCaracterTipo='caracterGrupo';
                }
            }
            
        }
    
    ?>
                            <script> 
                                 window.onload=function(){
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../usuarios" method="POST" onsubmit="procesar(this.action);" >
                                <?php
                                if($enter_encontrado == '1'){ //// mandamos la alerta del enter, reemplazando la alerta de caractares
                                //echo 'Enter encontrado';
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
                                <!--<input type="submit">-->
                            </form> 
    <?php  
    }
    
    
    if($vaidacion_repiteCC == '1'){ 
        ?> 
                                            <script> 
                                                 window.onload=function(){
                                               
                                                    document.forms["miformularioRepite"].submit();
                                                 }
                                            </script>
                                             
                                            <form name="miformularioRepite" action="../../usuarios" method="POST" onsubmit="procesar(this.action);" >
                                                <input type="hidden" name="validacionExisteImportacionG" value="1">
                                                <input name="mensajeRepiteCC" value="<?php  echo $string_cc;?>" type="hidden">
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