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
        
        $campoVacio=TRUE;
        
        $nombreExiste=TRUE;
        $arrayNombreRepitente = array();
        $repiteNombreExcel=TRUE;
        
        
        $codigoExiste=TRUE;
        $arrayCodigoRepitente = array();
        $repiteCodigoExcel=TRUE;
        
        $identificadorExiste=TRUE;
        $arrayIdentificadorRepitente = array();
        $repiteIdentificadorExcel = TRUE;
       
        $impuestoExiste=TRUE;
        $grupoExiste=TRUE;
        $tipoProductoExistenca=TRUE;
        $unidadEmpaqueExiste=TRUE;
        
        $proveedorExiste=TRUE;
        $inventarioExiste=TRUE;
        $activoExiste=TRUE;
        $unidadUnidadExiste=TRUE;
        
        $noExisteTiempoServicio=TRUE;
        
        $validacionNumerico=TRUE;
                            
        
        $sheetCount = count($Reader->sheets());
        
        
                            function eliminar_acentosTipoProducto($tipoProducto){
		
                            		//Reemplazamos la A y a
                            		$tipoProducto = str_replace(
                            		array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
                            		array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
                            		$tipoProducto
                            		);
                            
                            		//Reemplazamos la E y e
                            		$tipoProducto = str_replace(
                            		array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
                            		array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
                            		$tipoProducto );
                            
                            		//Reemplazamos la I y i
                            		$tipoProducto = str_replace(
                            		array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
                            		array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
                            		$tipoProducto );
                            
                            		//Reemplazamos la O y o
                            		$tipoProducto = str_replace(
                            		array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
                            		array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
                            		$tipoProducto );
                            
                            		//Reemplazamos la U y u
                            		$tipoProducto = str_replace(
                            		array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
                            		array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
                            		$tipoProducto );
                            
                            		//Reemplazamos la N, n, C y c
                            		$tipoProducto = str_replace(
                            		array('Ñ', 'ñ', 'Ç', 'ç'),
                            		array('N', 'ñ', 'C', 'c'),
                            		$tipoProducto
                            		);
                            		
                            		//Reemplazamos ;; por ;
                            		$tipoProducto = str_replace(
                            		array(';;',';;;'),
                            		array(';',';'),
                            		$tipoProducto
                            		);
                            		
                            		return $tipoProducto;
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
                            		array('N', 'ñ', 'C', 'c'),
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
        
        $activarAlerta=TRUE;
        $activarAlertaEnter=TRUE; ///  variable declarada para el mensaje con campo enter
        
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
            $contador='0';
            foreach ($Reader as $Row)
            {
            $contador++;
                if($Row[13]=='Cantidad de tiempo de servicio, Ingresar solo números (Aplica para servicios)'){ continue;} //Aca remplazo por el nombre y posicion de la ultima columna de excel para que no me agrege la primera fila.
                
                $tipoProducto = "";
                if(isset($Row[0])) {
                    $tipoProducto = mysqli_real_escape_string($con,$Row[0]);
                    $tipoProducto=trim($tipoProducto);
                    $contadorCeldaTipoProducto++;
                    $buscandoEnterTipoProducto++;
                    
                    if($tipoProducto == ""){ 
                        $campoVacio=FALSE;
                        $mensajeCampoVacio='en la columna tipo de producto';
                    }else{
                        //$tipoProducto = ucwords(strtolower($tipoProducto));
                        $tipoProducto = strtolower($tipoProducto);
                        // eliminamos los acentos
                         $tipoProducto=eliminar_acentosTipoProducto($tipoProducto);
                         '<br>';
                        
                       //compruebo que los caracteres sean los permitidos
                        $tipoProducto_carecteres=['"'];
                        for($bc=0; $bc<count($tipoProducto_carecteres); $bc++){
                            $tipoProducto_carecteres[$bc]; 
                             $cadena_carecteres_tipoProducto = $tipoProducto_carecteres[$bc];
                             ' - '.$coincidencia_caracteres= strpos($tipoProducto, $cadena_carecteres_tipoProducto);
                            if($coincidencia_caracteres != NULL){
                                $activarAlerta=FALSE;
                                 $enviarTipoProductoString.=$contadorCeldaTipoProducto.', ';
                                $tipoValidacionTipoProducto='1';
                            }
                             '<br>';
                        }
                        
                        if($tipoValidacionTipoProducto == '1'){ 
                            
                        }else{ 
                            $permitidosTipoProductos = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ ";
                               for ($i=0; $i<strlen($tipoProducto); $i++){
                                  if (strpos($permitidosTipoProductos, substr($tipoProducto,$i,1))===false){
                                     $tipoProducto . " no es válido<br>";
                                     $activarAlerta=FALSE;
                                     $tipoValidacionTipoProducto='2';
                                     $enviarTipoProductoStringL=$tipoProducto;
                                     //return false;
                                  }
                               }
                               
                               
                                //// validamos el enter antes de enviar la alerta
                                        $cadena_buscada_tipoProducto = '\n';
                                        $posicion_coincidencia_nombre = strpos($tipoProducto, $cadena_buscada_tipoProducto);
                                        if($posicion_coincidencia_nombre === false){
                                            //echo 'si';
                                        }else{
                                            //echo 'no';
                                          $activarAlertaEnter=FALSE;
                                          $enviarResponsableStringLCTipoProducto=$buscandoEnterTipoProducto.',';
                                        }
                                    
                                        if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                            //echo 'enter encontrado';
                                            $enter_encontrado_tipoProducto='1';
                                            $enviarTipoProductoStringL=$enviarResponsableStringLCTipoProducto;
                                        }else{
                                            $enviarTipoProductoStringL=$enviarTipoProductoStringL;
                                        }
                                        
                                /// end
                               
                               
                               
                        }
                        //// end
                       
                       
                       
                        $array = explode(' ',$tipoProducto);  // convierte en array separa por espacios;
                        $tipoProducto ='';
                        // quita los campos vacios y pone un solo espacio
                        for ($i=0; $i < count($array); $i++) { 
                            if(strlen($array[$i])>0) {
                                $tipoProducto.= ' ' . $array[$i];
                            }
                        }
                        
                         $tipoProducto=trim($tipoProducto);
                         '<br>';
                        
                        //if($tipoProducto == 'Bienes' || $tipoProducto == 'Servicios' || $tipoProducto == 'Bien' || $tipoProducto == 'Servicio'){
                        if($tipoProducto == 'bien' || $tipoProducto == 'servicio'){
                            if($tipoProducto == 'bien'){
                                $tipoProductoEnviar='1';
                            }else{
                                $tipoProductoEnviar='2';
                            }
                        }else{  'No: '.$enviarTipoProductoNo.=$tipoProducto.', ';
                            $tipoProductoExistenca=FALSE;
                        }
                    }
                }
                
                $nombre = "";
                if(isset($Row[1])) {
                    $nombre = mysqli_real_escape_string($con,$Row[1]);
                    $nombre=trim($nombre);
                    $contadorCeldaNombre++;
                    $buscandoEnternombre++;
                   
                    
                    if($nombre == ""){ 
                        $campoVacio=FALSE;
                        $mensajeCampoVacio='en la columna nombre del bien o servicio';
                    }else{
                       
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
                                            //echo 'si';
                                        }else{
                                            //echo 'no';
                                          $activarAlertaEnter=FALSE;
                                          $enviarResponsableStringLCnombre=$buscandoEnternombre.',';
                                        }
                                    
                                        if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                            //echo 'enter encontrado';
                                            $enter_encontrado_nombre='1';
                                            $enviarNombreStringL=$enviarResponsableStringLCnombre;
                                        }else{
                                            $enviarNombreStringL;
                                        }
                                        
                                /// end
                               
                               
                               
                        }
                        //// end
                       
                       
                       
                        $array = explode(' ',$nombre);  // convierte en array separa por espacios;
                        $nombre ='';
                        // quita los campos vacios y pone un solo espacio
                        for ($i=0; $i < count($array); $i++) { 
                            if(strlen($array[$i])>0) {
                                $nombre.= ' ' . $array[$i];
                            }
                        }
                        
                        $nombre=trim($nombre);
                       
                       
                        $validacionA = $con->query("SELECT * FROM proveedorProductos WHERE nombre = '$nombre'  ");
                        $numA = mysqli_num_rows($validacionA);
                        
                        if($numA > 0){ 
                            //si el nombre está repetido se pone falso 
                            $enviarNombreExistente.=$nombre.', ';
                            $nombreExiste = FALSE;
                        }
                       
                        
                        if($nombre == ""){ 
                            $campoVacio = FALSE;
                        }else{
                            array_push($arrayNombreRepitente,$nombre);
                        }
                    }
                }
                
                $descripcion = "";
                if(isset($Row[2])) {
                    $descripcion = mysqli_real_escape_string($con,$Row[2]);
                     '<br>'.$descripcion=trim($descripcion);
                     
                    $contadorCeldaDescripcion++;
                    $buscandoEnterdescripcion++;
                     
                    if($descripcion == ""){
                        $campoVacio=FALSE;
                         $mensajeCampoVacio='en la columna descripción';
                    }else{
                        
                         /// volvemos el texto totalmente en minuscula
                        $descripcion=mb_strtolower($descripcion);
                        '<br>';
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
                                            //echo 'si';
                                        }else{
                                            //echo 'no';
                                          $activarAlertaEnter=FALSE;
                                          $enviarResponsableStringLCdescripcion=$buscandoEnterdescripcion.',';
                                        }
                                    
                                        if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                            //echo 'enter encontrado';
                                            $enter_encontrado_descripcion='1';
                                            $enviarDescripcionStringL=$enviarResponsableStringLCdescripcion;
                                        }else{
                                            $enviarDescripcionStringL;
                                        }
                                        
                                /// end
                        }
                        //// end
                        
                    }
                }
                
                $grupo = "";
                if(isset($Row[3])) {
                    $grupo = mysqli_real_escape_string($con,$Row[3]);
                     '<br>'.$grupo=trim($grupo);
                     
                    $contadorCeldaGrupo++;
                    $buscandoEnterGrupo++;
                     
                    if($grupo == ""){ 
                        $campoVacio=FALSE;
                         $mensajeCampoVacio='en la columna grupo y subgrupo';
                    }else{
                        
                        
                         /// volvemos el texto totalmente en minuscula
                        $grupo=mb_strtolower($grupo);
                        '<br>';
                        //compruebo que los caracteres sean los permitidos
                        $grupo_carecteres=['"'];
                        for($bc=0; $bc<count($grupo_carecteres); $bc++){
                            $grupo_carecteres[$bc]; 
                             $cadena_carecteres_grupo = $grupo_carecteres[$bc];
                             ' - '.$coincidencia_caracteres= strpos($grupo, $cadena_carecteres_grupo);
                            if($coincidencia_caracteres != NULL){
                                $activarAlerta=FALSE;
                                $enviarGrupoString.=$contadorCeldaGrupo.', ';
                                $tipoValidacionGrupo='1';
                            }
                             '<br>';
                        }
                        
                        if($tipoValidacionGrupo == '1'){
                            
                        }else{
                            $permitidosgrupo = "0123456789";
                               for ($i=0; $i<strlen($grupo); $i++){
                                  if (strpos($permitidosgrupo, substr($grupo,$i,1))===false){
                                     $grupo . " no es válido<br>";
                                     $activarAlerta=FALSE;
                                     $tipoValidacionGrupo='2';
                                     $enviarGrupoStringL=$grupo;
                                     //return false;
                                  }
                               }
                               
                               //// validamos el enter antes de enviar la alerta
                                        $cadena_buscada_grupo = '\n';
                                        $posicion_coincidencia_grupo = strpos($grupo, $cadena_buscada_grupo);
                                        if($posicion_coincidencia_grupo === false){
                                            //echo 'si';
                                        }else{
                                            //echo 'no';
                                          $activarAlertaEnter=FALSE;
                                          $enviarResponsableStringLCGrupo=$buscandoEnterGrupo.',';
                                        }
                                    
                                        if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                            //echo 'enter encontrado';
                                            $enter_encontrado_grupo='1';
                                            $enviarGrupoStringL=$enviarResponsableStringLCGrupo;
                                        }else{
                                            $enviarGrupoStringL;
                                        }
                                        
                                /// end
                        }
                        //// end
                        
                    
                        $validacionGrupo = $con->query("SELECT * FROM proveedoresProductoGrupo WHERE id = '$grupo'  ");
                        $numGrupo = mysqli_num_rows($validacionGrupo);
                        
                        if($numGrupo > 0){
                            //si el nombre está repetido se pone falso 
                            $grupoExiste = TRUE;
                        }else{ $enviarGrupo.=$grupo.', ';
                            $grupoExiste = FALSE;
                        }
                    }
                    
                }
                
                $codigo = "";
                if(isset($Row[4])) {
                    $codigo = mysqli_real_escape_string($con,$Row[4]);
                     '<br>'.$codigo=trim($codigo);
                    
                    $contadorCeldaCodigo++;
                    $buscandoEnterCodigo++;
                     
                    if($codigo == ""){ 
                        $campoVacio=FALSE;
                         $mensajeCampoVacio='en la columna código';
                    }else{
                        
                        
                       
                     /// volvemos el texto totalmente en minuscula
                                  $codigo=mb_strtolower($codigo);
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
                        
                        
                        $validacionCodigo = $con->query("SELECT * FROM proveedorProductos WHERE codigo = '$codigo'  ");
                        $numCodigo = mysqli_num_rows($validacionCodigo);
                        
                        if($numCodigo > 0){
                            //si el nombre está repetido se pone falso 
                            $codigoExiste = FALSE;
                        }
                        //if($codigo == ""){  echo 'buscando';
                        //    $campoVacio = FALSE;
                        //}else{
                            array_push($arrayCodigoRepitente,$codigo);
                        //}
                    }
                    
                }
                
                $identificador = "";
                if(isset($Row[5])) {
                    $identificador = mysqli_real_escape_string($con,$Row[5]);
                     '<br>'.$identificador=trim($identificador);
                     
                    $contadorCeldaIdentificador++;
                    $buscandoEnterIdentificador++; 
                     
                    if($identificador == ""){ 
                        $campoVacio=FALSE;
                         $mensajeCampoVacio='en la columna identificador';
                    }else{
                        
                        
                        
                         /// volvemos el texto totalmente en minuscula
                        $descripcion=mb_strtolower($identificador);
                        '<br>';
                        //compruebo que los caracteres sean los permitidos
                        $identificador_carecteres=['"'];
                        for($bc=0; $bc<count($identificador_carecteres); $bc++){
                            $identificador_carecteres[$bc]; 
                             $cadena_carecteres_identificador = $identificador_carecteres[$bc];
                             ' - '.$coincidencia_caracteres= strpos($identificador, $cadena_carecteres_identificador);
                            if($coincidencia_caracteres != NULL){
                                $activarAlerta=FALSE;
                                $enviarIdentificadorString.=$contadorCeldaIdentificador.', ';
                                $tipoValidacionIdentificador='1';
                            }
                             '<br>';
                        }
                        
                        if($tipoValidacionIdentificador == '1'){
                            
                        }else{
                            $permitidosidentificador = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ0123456789 ";
                               for ($i=0; $i<strlen($identificador); $i++){
                                  if (strpos($permitidosidentificador, substr($identificador,$i,1))===false){
                                     $identificador . " no es válido<br>";
                                     $activarAlerta=FALSE;
                                     $tipoValidacionIdentificador='2';
                                     $enviarIdentificadorStringL=$identificador;
                                     //return false;
                                  }
                               }
                               
                               //// validamos el enter antes de enviar la alerta
                                        $cadena_buscada_identificador = '\n';
                                        $posicion_coincidencia_identificador = strpos($identificador, $cadena_buscada_identificador);
                                        if($posicion_coincidencia_identificador === false){
                                            //echo 'si';
                                        }else{
                                            //echo 'no';
                                          $activarAlertaEnter=FALSE;
                                          $enviarResponsableStringLCidentificador=$buscandoEnterIdentificador.',';
                                        }
                                    
                                        if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                            //echo 'enter encontrado';
                                            $enter_encontrado_identificador='1';
                                            $enviarIdentificadorStringL=$enviarResponsableStringLCidentificador;
                                        }else{
                                            $enviarIdentificadorStringL;
                                        }
                                        
                                /// end
                        }
                        //// end
                        
                        
                        $array = explode(' ',$identificador);  // convierte en array separa por espacios;
                        $identificador ='';
                        // quita los campos vacios y pone un solo espacio
                        for ($i=0; $i < count($array); $i++) { 
                            if(strlen($array[$i])>0) {
                                $identificador.= ' ' . $array[$i];
                            }
                        }
                        
                        $identificador=trim($identificador);
                      
                        $validacionIdentificador = $con->query("SELECT * FROM proveedoresProductoIdentificador WHERE grupo = '$identificador'  ");
                        $extraerConsultaValidacionIdentificar=$validacionIdentificador->fetch_array(MYSQLI_ASSOC);
                        $numIdentificador = mysqli_num_rows($validacionIdentificador);
                         'id: identificacdor: '.$identificadorEnviar=$extraerConsultaValidacionIdentificar['id'];
                        if($numIdentificador == 0){ 
                            
                            $enviarIdentificadorNo.=$identificador.', ';
                            
                            //si el nombre está repetido se pone falso 
                            $identificadorExiste = FALSE;
                        }
                        
                        if($identificador == ""){
                            $campoVacio = FALSE;
                        }else{
                            //array_push($arrayIdentificadorRepitente,$identificador);
                        }
                    }
                }
                
                $impuesto = "";
                if(isset($Row[6])) {
                    $impuesto = mysqli_real_escape_string($con,$Row[6]);
                     '<br>'.$impuesto=trim($impuesto);
                     
                     
                    $contadorCeldaImpuesto++;
                    $buscandoEnterimpuesto++; 
                     
                    if($impuesto == ""){ 
                        $campoVacio=FALSE;
                         $mensajeCampoVacio='en la columna impuesto';
                    }else{
                    
                     /// volvemos el texto totalmente en minuscula
                        $impuesto=mb_strtolower($impuesto);
                        '<br>';
                        //compruebo que los caracteres sean los permitidos
                        $impuesto_carecteres=['"'];
                        for($bc=0; $bc<count($impuesto_carecteres); $bc++){
                            $impuesto_carecteres[$bc]; 
                             $cadena_carecteres_impuesto = $impuesto_carecteres[$bc];
                             ' - '.$coincidencia_caracteres= strpos($impuesto, $cadena_carecteres_impuesto);
                            if($coincidencia_caracteres != NULL){
                                $activarAlerta=FALSE;
                                $enviarImpuestoString.=$contadorCeldaImpuesto.', ';
                                $tipoValidacionImpuesto='1';
                            }
                             '<br>';
                        }
                        
                        if($tipoValidacionImpuesto == '1'){ 
                            
                        }else{ 
                            $permitidosimpuesto = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ ";
                               for ($i=0; $i<strlen($impuesto); $i++){
                                  if (strpos($permitidosimpuesto, substr($impuesto,$i,1))===false){
                                     $impuesto . " no es válido<br>";
                                     $activarAlerta=FALSE;
                                     $tipoValidacionImpuesto='2';
                                     $enviarImpuestoStringL=$impuesto;
                                     //return false;
                                  }
                               }
                               
                               //// validamos el enter antes de enviar la alerta
                                        $cadena_buscada_impuesto = '\n';
                                        $posicion_coincidencia_impuesto = strpos($impuesto, $cadena_buscada_impuesto);
                                        if($posicion_coincidencia_impuesto === false){
                                            //echo 'si';
                                        }else{
                                            //echo 'no';
                                          $activarAlertaEnter=FALSE;
                                          $enviarResponsableStringLCimpuesto=$buscandoEnterimpuesto.',';
                                        }
                                    
                                        if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                            //echo 'enter encontrado';
                                            $enter_encontrado_impuesto='1';
                                            $enviarImpuestoStringL=$enviarResponsableStringLCimpuesto;
                                        }else{
                                            $enviarImpuestoStringL;
                                        }
                                        
                                /// end
                        }
                        //// end
                        
                            $array = explode(' ',$impuesto);  // convierte en array separa por espacios;
                            $impuesto ='';
                            // quita los campos vacios y pone un solo espacio
                            for ($i=0; $i < count($array); $i++) { 
                                if(strlen($array[$i])>0) {
                                    $impuesto.= ' ' . $array[$i];
                                }
                            }
                            
                            $impuesto=trim($impuesto);
                        
                        
                        $validacionImpuesto = $con->query("SELECT * FROM proveedoresTipoImpuesto WHERE grupo = '$impuesto'  ");
                        $traeImpuesto=$validacionImpuesto->fetch_array(MYSQLI_ASSOC);
                         ' - id: '.$impuestoEnviar=$traeImpuesto['id'];
                        
                        $numImpuesto = mysqli_num_rows($validacionImpuesto);
                        
                        if($numImpuesto > 0){
                            //si el nombre está repetido se pone falso 
                            $impuestoExiste = TRUE;
                        }else{ $enviarImpuesto.=$impuesto.', ';
                            $impuestoExiste = FALSE;
                        }
                    }
                    
                }
                
                $unidaddeEmpaque = "";
                if(isset($Row[7])) {
                    $unidaddeEmpaque = mysqli_real_escape_string($con,$Row[7]);
                     '<br>'.$unidaddeEmpaque=trim($unidaddeEmpaque);
                    
                    $contadorCeldaUnidadEmpaque++;
                    $buscandoEnterunidadEmpaque++; 
                    
                    if($tipoProductoEnviar == 1){ //$tipoProducto == 'Bienes'
                        if($unidaddeEmpaque == ""){ 
                            $campoVacio=FALSE;
                             $mensajeCampoVacio='en la columna unidad de empaque';
                        }else{
                            $unidaddeEmpaque=($unidaddeEmpaque);
                            
                            
                            
                             /// volvemos el texto totalmente en minuscula
                        $unidaddeEmpaque=mb_strtolower($unidaddeEmpaque);
                        '<br>';
                        //compruebo que los caracteres sean los permitidos
                        $unidadempaque_carecteres=['"'];
                        for($bc=0; $bc<count($unidadempaque_carecteres); $bc++){
                            $unidadempaque_carecteres[$bc]; 
                             $cadena_carecteres_unidadempaque = $unidadempaque_carecteres[$bc];
                             ' - '.$coincidencia_caracteres= strpos($unidaddeEmpaque, $cadena_carecteres_unidadempaque);
                            if($coincidencia_caracteres != NULL){
                                $activarAlerta=FALSE;
                                $enviarUnidademapqueString.=$contadorCeldaUnidadEmpaque.', ';
                                $tipoValidacionUnidadempaque='1';
                            }
                             '<br>';
                        }
                        
                        if($tipoValidacionUnidadempaque == '1'){
                            
                        }else{
                            $permitidosunidadempaque = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ.,:; ";
                               for ($i=0; $i<strlen($unidaddeEmpaque); $i++){
                                  if (strpos($permitidosunidadempaque, substr($unidaddeEmpaque,$i,1))===false){
                                     $unidaddeEmpaque . " no es válido<br>";
                                     $activarAlerta=FALSE;
                                     $tipoValidacionUnidadempaque='2';
                                     $enviarUnidademapqueStringL=$unidaddeEmpaque;
                                     //return false;
                                  }
                               }
                              
                               //// validamos el enter antes de enviar la alerta
                                        $cadena_buscada_unidadempaque = '\n';
                                        $posicion_coincidencia_unidadempaque = strpos($unidaddeEmpaque, $cadena_buscada_unidadempaque);
                                        if($posicion_coincidencia_unidadempaque === false){
                                            //echo 'si';
                                        }else{
                                            //echo 'no';
                                          $activarAlertaEnter=FALSE;
                                          $enviarResponsableStringLCunidademapque=$buscandoEnterunidadEmpaque.',';
                                        }
                                    
                                        if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                            //echo 'enter encontrado';
                                            $enter_encontrado_unidadempaque='1';
                                            $enviarUnidademapqueStringL=$enviarResponsableStringLCunidademapque;
                                        }else{
                                            $enviarUnidademapqueStringL;
                                        }
                                        
                                /// end
                        }
                        //// end
                            
                            
                            $array = explode(' ',$unidaddeEmpaque);  // convierte en array separa por espacios;
                            $unidaddeEmpaque ='';
                            // quita los campos vacios y pone un solo espacio
                            for ($i=0; $i < count($array); $i++) { 
                                if(strlen($array[$i])>0) {
                                    $unidaddeEmpaque.= ' ' . $array[$i];
                                }
                            }
                            
                            $unidaddeEmpaque=trim($unidaddeEmpaque);
                             
                            $validacionUnidadEmpaque = $con->query("SELECT * FROM proveedoresProductoEmpaque WHERE grupo = '$unidaddeEmpaque'  ");
                            $extraerUnidadEmpaque=$validacionUnidadEmpaque->fetch_array(MYSQLI_ASSOC);
                            $unidaddeEmpaqueEnviar=$extraerUnidadEmpaque['id'];
                            $numUnidadEmpaque = mysqli_num_rows($validacionUnidadEmpaque);
                            
                            if($numUnidadEmpaque > 0){
                                //si el nombre está repetido se pone falso 
                                $unidadEmpaqueExiste = TRUE;
                            }else{ $enviarUnidadEmpaque.=$unidaddeEmpaque.', ';
                                $unidadEmpaqueExiste = FALSE;
                            }
                        }
                    }else{
                       
                    }
                    
                    
                }
                
                $unidaddeMedida = "";
                if(isset($Row[8])) {
                    $unidaddeMedida = mysqli_real_escape_string($con,$Row[8]);
                    
                    $contadorCeldaUnidadmedida++;
                    $buscandoEnterunidadmedida++; 
                    
                    $unidaddeMedida=trim($unidaddeMedida);
                    
                    if($tipoProductoEnviar == 1){//if($tipoProducto == 'Bienes'){ 
                        if($unidaddeMedida == ""){ 
                            $campoVacio=FALSE;
                             $mensajeCampoVacio='en la columna unidad de medida';
                        }else{
                            //$unidaddeMedida=($unidaddeMedida);
                            
                              /// volvemos el texto totalmente en minuscula
                        $unidaddeMedida=mb_strtolower($unidaddeMedida);
                        //echo '<br>';
                        //compruebo que los caracteres sean los permitidos
                        $unidadmedida_carecteres=['"'];
                        for($bc=0; $bc<count($unidadmedida_carecteres); $bc++){
                            $unidadmedida_carecteres[$bc]; 
                             $cadena_carecteres_unidadmedida = $unidadmedida_carecteres[$bc];
                             ' - '.$coincidencia_caracteres= strpos($unidaddeMedida, $cadena_carecteres_unidadmedida);
                            if($coincidencia_caracteres != NULL){
                                $activarAlerta=FALSE;
                                $enviarUnidadmedidaString.=$contadorCeldaUnidadmedida.', ';
                                $tipoValidacionUnidadmedida='1';
                            }
                             '<br>';
                        }
                        
                        if($tipoValidacionUnidadmedida == '1'){ 
                            
                        }else{ 
                            $permitidosunidadMedida = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ.,:; ";
                               for ($i=0; $i<strlen($unidaddeMedida); $i++){
                                  if (strpos($permitidosunidadMedida, substr($unidaddeMedida,$i,1))===false){
                                     $unidaddeMedida . " no es válido<br>";
                                     $activarAlerta=FALSE;
                                     $tipoValidacionUnidadmedida='2';
                                     $enviarUnidadmedidaStringL=$unidaddeMedida;
                                     //return false;
                                  }
                               }
                               
                               //// validamos el enter antes de enviar la alerta
                                        $cadena_buscada_unidadmedida = '\n';
                                        $posicion_coincidencia_unidadmedida = strpos($unidaddeMedida, $cadena_buscada_unidadmedida);
                                        if($posicion_coincidencia_unidadmedida === false){
                                            //echo 'si';
                                        }else{
                                            //echo 'no';
                                          $activarAlertaEnter=FALSE;
                                          $enviarResponsableStringLCunidadmedida=$buscandoEnterunidadmedida.',';
                                        }
                                    
                                        if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                            //echo 'enter encontrado';
                                            $enter_encontrado_unidadmedida='1';
                                            $enviarUnidadmedidaStringL=$enviarResponsableStringLCunidadmedida;
                                        }else{
                                            $enviarUnidadmedidaStringL;
                                        }
                                        
                                /// end
                        }
                        //// end
                            
                            $array = explode(' ',$unidaddeMedida);  // convierte en array separa por espacios;
                            $unidaddeMedida ='';
                            // quita los campos vacios y pone un solo espacio
                            for ($i=0; $i < count($array); $i++) { 
                                if(strlen($array[$i])>0) {
                                    $unidaddeMedida.= ' ' . $array[$i];
                                }
                            }
                            
                            $unidaddeMedida=trim($unidaddeMedida);
                            
                            $validacionUnidadMedida = $con->query("SELECT * FROM proveedoresProductoMedida WHERE grupo = '$unidaddeMedida'  ");
                            $extraerUnidadMedida=$validacionUnidadMedida->fetch_array(MYSQLI_ASSOC);
                            $unidaddeMedidaEnviar=$extraerUnidadMedida['id'];
                            $numUnidadMedida = mysqli_num_rows($validacionUnidadMedida);
                            
                            if($numUnidadMedida > 0){ //echo 'existe';
                                //si el nombre está repetido se pone falso 
                                $unidadUnidadExiste = TRUE;
                            }else{  'no existe '.$enviarUnidadMedidaa.=$unidaddeMedida.', ';
                                $unidadUnidadExiste = FALSE;
                            }
                        }
                    }else{
                        
                    }
                }
                
                $proveedor = "";
                if(isset($Row[9])) {
                    $proveedor = mysqli_real_escape_string($con,$Row[9]);
                     '<br>'.$proveedor=trim($proveedor);
                    $contadorCeldaproveedor++;
                    $buscandoEnterproveedor++; 
                    
                    if($tipoProductoEnviar == 2){
                            if($proveedor == ""){
                                 'Viene vacio: '.$proveedorEnviar='0';  '<br>';
                            }else{
                                
                                 /// volvemos el texto totalmente en minuscula
                                    $proveedor=mb_strtolower($proveedor);
                                    '<br>';
                                    //compruebo que los caracteres sean los permitidos
                                    $proveedor_carecteres=['"'];
                                    for($bc=0; $bc<count($proveedor_carecteres); $bc++){
                                        $proveedor_carecteres[$bc]; 
                                         $cadena_carecteres_proveedor = $proveedor_carecteres[$bc];
                                         ' - '.$coincidencia_caracteres= strpos($proveedor, $cadena_carecteres_proveedor);
                                        if($coincidencia_caracteres != NULL){
                                            $activarAlerta=FALSE;
                                            $enviarProveedorString.=$contadorCeldaproveedor.', ';
                                            $tipoValidacionProveedor='1';
                                        }
                                         '<br>';
                                    }
                                    
                                    if($tipoValidacionProveedor == '1'){
                                        
                                    }else{
                                        $permitidosdescripcion = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ.,:; ";
                                           for ($i=0; $i<strlen($proveedor); $i++){
                                              if (strpos($permitidosdescripcion, substr($proveedor,$i,1))===false){
                                                 $proveedor . " no es válido<br>";
                                                 $activarAlerta=FALSE;
                                                 $tipoValidacionProveedor='2';
                                                 $enviarProveedorStringL=$proveedor;
                                                 //return false;
                                              }
                                           }
                                           
                                           //// validamos el enter antes de enviar la alerta
                                                    $cadena_buscada_proveedor = '\n';
                                                    $posicion_coincidencia_proveedor = strpos($proveedor, $cadena_buscada_proveedor);
                                                    if($posicion_coincidencia_proveedor === false){
                                                        //echo 'si';
                                                    }else{
                                                        //echo 'no';
                                                      $activarAlertaEnter=FALSE;
                                                      $enviarResponsableStringLCproveedor=$buscandoEnterproveedor.',';
                                                    }
                                                
                                                    if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                                        //echo 'enter encontrado';
                                                        $enter_encontrado_proveedor='1';
                                                        $enviarProveedorStringL=$enviarResponsableStringLCproveedor;
                                                    }else{
                                                        $enviarProveedorStringL;
                                                    }
                                                    
                                            /// end
                                    }
                                    //// end
                                    
                                $array = explode(' ',$proveedor);  // convierte en array separa por espacios;
                                $proveedor ='';
                                // quita los campos vacios y pone un solo espacio
                                for ($i=0; $i < count($array); $i++) { 
                                    if(strlen($array[$i])>0) {
                                        $proveedor.= ' ' . $array[$i];
                                    }
                                }
                                
                                $proveedor=trim($proveedor);
                                
                                $validacionProveedor = $con->query("SELECT * FROM `proveedores` WHERE razonSocial='$proveedor'  ");
                                $extraerProveedor=$validacionProveedor->fetch_array(MYSQLI_ASSOC);
                                $numUnidadProveedor = mysqli_num_rows($validacionProveedor);
                                 '<br>estado: '.$extraerProveedor['estado'];
                                if($numUnidadProveedor > 0){ 
                                    // si el proveedor existe envia el dato
                                    if($extraerProveedor['estado'] == 'Aprobado'){ /// si el proveedor aún no está activo, arroja otro mensaje
                                        $proveedorExiste = TRUE;  '<br>proveedor aprobado<br>';
                                         'existe: '.$proveedorEnviar=$extraerProveedor['id'];  '<br>';
                                    }else{  
                                         'no está habilitado: '.$proveecorNoActivo.=$proveedor.', ';
                                        $proveedorExiste = FALSE;
                                    }
                                }else{ 
                                    $proveedorNoExiste=$proveedor.', ';
                                    $proveedorExiste = FALSE;
                                }
                                
                                
                                
                            }
                        
                    }else{
                       
                    }
                }
                
                $inventario = "";
                if(isset($Row[10])) {
                    $inventario = mysqli_real_escape_string($con,$Row[10]);
                     '<br>'.$inventario=trim($inventario);
                     $inventario=mb_strtolower($inventario);
                     
                     
                    
                     if(mb_strtolower($Row[0]) == 'bien'){//if($tipoProducto == 'Bienes'){ 
                        if($inventario == ""){ 
                            $campoVacio=FALSE;
                             $mensajeCampoVacio='en la columna inventario';
                        }else{
                            if($inventario == 'si' || $inventario == 'Si' || $inventario == 'SI' || $inventario == 'sI' ){
                                $inventarioEnviar='Si';
                                $inventarioExiste=TRUE;
                            }elseif($inventario == 'no' || $inventario == 'No' || $inventario == 'NO' || $inventario == 'nO'){
                                $inventarioEnviar='No';
                                $inventarioExiste=TRUE;
                            }else{
                                'dato enviar: '.$enviarRespuestaInventario.=$inventario.', ';
                                $inventarioExiste=FALSE;
                                '<br>contando: '.$contadorInvenatio='1';
                            }
                        }
                     }
                }
                
                $activo = "";
                if(isset($Row[11])) {
                    $activo = mysqli_real_escape_string($con,$Row[11]);
                     '<br>'.$activo=trim($activo);
                    $contadorCeldaActivo++;
                    $buscandoEnterActivo++; 
                    
                    
                    if(mb_strtolower($Row[0]) == 'bien'){//if($tipoProducto == 'Bienes'){ 
                        if($activo == ""){ 
                            $campoVacio=FALSE;
                            $mensajeCampoVacio='en la columna activo';
                        }else{
                            
                            
                             /// volvemos el texto totalmente en minuscula
                                    $activo=mb_strtolower($activo);
                                    '<br>';
                                    //compruebo que los caracteres sean los permitidos
                                    $activo_carecteres=['"'];
                                    for($bc=0; $bc<count($activo_carecteres); $bc++){
                                        $activo_carecteres[$bc]; 
                                         $cadena_carecteres_activo = $activo_carecteres[$bc];
                                         ' - '.$coincidencia_caracteres= strpos($activo, $cadena_carecteres_activo);
                                        if($coincidencia_caracteres != NULL){
                                            $activarAlerta=FALSE;
                                            $enviarActivoString.=$contadorCeldaActivo.', ';
                                            $tipoValidacionActivo='1';
                                        }
                                         '<br>';
                                    }
                                    
                                    if($tipoValidacionActivo == '1'){ 
                                        
                                    }else{ 
                                        $permitidosdescripcion = "sino";
                                           for ($i=0; $i<strlen($activo); $i++){
                                              if (strpos($permitidosdescripcion, substr($activo,$i,1))===false){
                                                 $activo . " no es válido<br>";
                                                 $activarAlerta=FALSE;
                                                 $tipoValidacionActivo='2';
                                                 $enviarActivoStringL=$activo;
                                                 //return false;
                                              }
                                           }
                                           
                                           //// validamos el enter antes de enviar la alerta
                                                    $cadena_buscada_activo = '\n';
                                                    $posicion_coincidencia_activo = strpos($activo, $cadena_buscada_activo);
                                                    if($posicion_coincidencia_activo === false){
                                                        //echo 'si';
                                                    }else{
                                                        //echo 'no';
                                                      $activarAlertaEnter=FALSE;
                                                      $enviarResponsableStringLCactivo=$buscandoEnterActivo.',';
                                                    }
                                                
                                                    if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                                        //echo 'enter encontrado';
                                                        $enter_encontrado_activo='1';
                                                        $enviarActivoStringL=$enviarResponsableStringLCactivo;
                                                    }else{
                                                        $enviarActivoStringL;
                                                    }
                                                    
                                            /// end
                                    }
                                    //// end
                            
                            
                            
                            
                            if($activo == 'si' || $activo == 'Si' || $activo == 'SI' || $activo == 'sI' ){
                                $activoEnviar='Si';
                                $activoExiste=TRUE;
                            }elseif($activo == 'no' || $activo == 'No' || $activo == 'NO' || $activo == 'nO'){
                                $activoEnviar='No';
                                $activoExiste=TRUE;
                            }else{
                                $enviarActivoNo.=$activo.', ';
                                $activoExiste=FALSE;
                            }
                        }
                        
                    }
                }
                
                
                $tiempoServicio = "";
                if(isset($Row[12])) {
                    $tiempoServicio = mysqli_real_escape_string($con,$Row[12]);
                     '<br>'.$tiempoServicio=trim($tiempoServicio);
                     
                    $contadorCeldaTiemposervicio++;
                    $buscandoEntertiemposervicio++; 
                    
                   
                    
                    
                    if(mb_strtolower($Row[0]) == 'servicio'){
                        //if($tipoProducto == 'Servicios'){ 
                        if($tiempoServicio == ""){
                            $campoVacio=FALSE;
                              'campo: '.$mensajeCampoVacio='en la columna tiempo de servicio';
                        }else{
                            
                            
                            
                             /// volvemos el texto totalmente en minuscula
                        $tiempoServicio=mb_strtolower($tiempoServicio);
                        '<br>';
                        //compruebo que los caracteres sean los permitidos
                        $tiemposervicio_carecteres=['"'];
                        for($bc=0; $bc<count($tiemposervicio_carecteres); $bc++){
                            $tiemposervicio_carecteres[$bc]; 
                             $cadena_carecteres_tiemposervicio = $tiemposervicio_carecteres[$bc];
                             ' - '.$coincidencia_caracteres= strpos($tiempoServicio, $cadena_carecteres_tiemposervicio);
                            if($coincidencia_caracteres != NULL){
                                $activarAlerta=FALSE;
                                $enviarTiemposervicioString.=$contadorCeldaTiemposervicio.', ';
                                $tipoValidacionTiemposervicio='1';
                            }
                             '<br>';
                        }
                        
                        if($tipoValidacionTiemposervicio == '1'){
                            
                        }else{
                            $permitidosdescripcion = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ.,:; ";
                               for ($i=0; $i<strlen($tiempoServicio); $i++){
                                  if (strpos($permitidosdescripcion, substr($tiempoServicio,$i,1))===false){
                                     $tiempoServicio . " no es válido<br>";
                                     $activarAlerta=FALSE;
                                     $tipoValidacionTiemposervicio='2';
                                     $enviarTiemposervicioStringL=$tiempoServicio;
                                     //return false;
                                  }
                               }
                               
                               //// validamos el enter antes de enviar la alerta
                                        $cadena_buscada_tiemposervicio = '\n';
                                        $posicion_coincidencia_tiemposervicio = strpos($tiempoServicio, $cadena_buscada_tiemposervicio);
                                        if($posicion_coincidencia_tiemposervicio === false){
                                            //echo 'si';
                                        }else{
                                            //echo 'no';
                                          $activarAlertaEnter=FALSE;
                                          $enviarResponsableStringLCtiemposervicio=$buscandoEntertiemposervicio.',';
                                        }
                                    
                                        if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                            //echo 'enter encontrado';
                                            $enter_encontrado_tiemposervicio='1';
                                            $enviarTiemposervicioStringL=$enviarResponsableStringLCtiemposervicio;
                                        }else{
                                            $enviarTiemposervicioStringL;
                                        }
                                        
                                /// end
                        }
                        //// end
                            
                            
                                $array = explode(' ',$tiempoServicio);  // convierte en array separa por espacios;
                                $tiempoServicio ='';
                                // quita los campos vacios y pone un solo espacio
                                for ($i=0; $i < count($array); $i++) { 
                                    if(strlen($array[$i])>0) {
                                        $tiempoServicio.= ' ' . $array[$i];
                                    }
                                }
                                
                                $tiempoServicio=trim($tiempoServicio);
                            
                                $buscaTiempo=$con->query("SELECT * FROM proveedoresProductoTiempo WHERE grupo='$tiempoServicio' ");
                                $extraerDatos=$buscaTiempo->fetch_array(MYSQLI_ASSOC);
                                 ' - id: '.$extraerDatos['id'];
                                if($extraerDatos['id'] != NULL){
                                    $enviarIdTiempoServicio=$extraerDatos['id'];
                                    $noExisteTiempoServicio=TRUE;
                                }else{
                                    'enviar: '.$enviarTiempoServicioNo.=$tiempoServicio.', ';
                                    ///// alerta que no existe el tiempo de servicio
                                    $noExisteTiempoServicio=FALSE;
                                }
                           
                        }
                        
                    }
                }
                 
                $cantidadServicio = "";
                if(isset($Row[13])) {
                    $cantidadServicio = mysqli_real_escape_string($con,$Row[13]);
                     '<br>cantidad: '.$cantidadServicio=trim($cantidadServicio);
                    if(mb_strtolower($Row[0]) == 'servicio'){
                        if($cantidadServicio == ""){ 
                                $campoVacio=FALSE;
                                 $mensajeCampoVacio='en la columna cantidad de tiempo de servicio';
                        }else{
                            if(is_numeric($cantidadServicio)){
                                    
                            }else{  $enviarCantidadServicioNo.=$cantidadServicio.', ';
                                 $validacionNumerico=FALSE;
                            }    
                                    
                        }
                    } 
                    
                }
               
                
               
                
               
                
                
                
            }
            
           // echo 'cont '.$contador;
            if($contador == 1){ //echo 'Aca';
                ?>
                                        <script> 
                                             window.onload=function(){
                                           
                                                document.forms["miformularioV"].submit();
                                             }
                                        </script>
                                         
                                        <form name="miformularioV" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                                            <input type="hidden" name="mensajeEnviarCampoVacio" value="<?php echo $mensajeCampoVacio;?>">
                                            <input type="hidden" name="validacionExisteImportacionVacio" value="1">
                                        </form> 
                                <?php
            }
            
            
            
        }
        
        
        /// para el nombre
        if(count($arrayNombreRepitente) > count(array_unique($arrayNombreRepitente))){
            $repiteNombreExcel=FALSE;   
        }
        /// codigo
        if(count($arrayCodigoRepitente) > count(array_unique($arrayCodigoRepitente))){
            $repiteCodigoExcel=FALSE;   
        }
        
        
        /// para el nombre
        if(count($arrayIdentificadorRepitente) > count(array_unique($arrayIdentificadorRepitente))){//Valido si hay seriales repetidos
          $repiteIdentificadorExcel = FALSE;
        }
        /// END
        
        
         $conteoNumeroContador='1';
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
           
            foreach ($Reader as $Row)
            {
          
                if($Row[13]=='Cantidad de tiempo de servicio, Ingresar solo números (Aplica para servicios)'){ continue;} //Aca remplazo por el nombre y posicion de la ultima columna de excel para que no me agrege la primera fila.
               
                $tipoProducto = "";
                if(isset($Row[0])) {
                    $tipoProducto = mysqli_real_escape_string($con,$Row[0]);
                    $tipoProducto=trim($tipoProducto);
                    if($tipoProducto == ""){ 
                        $campoVacio=FALSE;
                    }else{
                        
                        //$tipoProducto = ucwords(strtolower($tipoProducto));
                        $tipoProducto = strtolower($tipoProducto);
                        // eliminamos los acentos
                         $tipoProducto=eliminar_acentosTipoProducto($tipoProducto);
                         '<br>';
                        
                       //$tipoProducto = ucwords(strtolower($tipoProducto));
                        //if($tipoProducto == 'Bienes' || $tipoProducto == 'Servicios' || $tipoProducto == 'Bien' || $tipoProducto == 'Servicio'){
                        //    if($tipoProducto == 'Bienes' || $tipoProducto == 'Bien'){
                        if($tipoProducto == 'bien' || $tipoProducto == 'servicio'){
                            if($tipoProducto == 'bien' ){
                                $tipoProductoEnviar='1';
                            }else{
                                $tipoProductoEnviar='2';
                            }
                        }else{ //echo 'no: '.$tipoProducto;
                            $tipoProductoExistenca=FALSE;
                        }
                    }
                    
                }
                
                $nombre = "";
                if(isset($Row[1])) {
                    $nombre = mysqli_real_escape_string($con,$Row[1]);
                    $nombre=trim($nombre);
                    
                }
                
                $descripcion = "";
                if(isset($Row[2])) {
                    $descripcion = mysqli_real_escape_string($con,$Row[2]);
                    $descripcion=trim($descripcion);
                   
                }
                
                $grupo = "";
                if(isset($Row[3])) {
                    $grupo = mysqli_real_escape_string($con,$Row[3]);
                    $grupo=trim($grupo);
                    if($grupo == ""){ 
                        $campoVacio=FALSE;
                    }
                    $validacionGrupo = $con->query("SELECT * FROM proveedoresProductoGrupo WHERE id = '$grupo'  ");
                    $numGrupo = mysqli_num_rows($validacionGrupo);
                    
                    if($numGrupo > 0){
                        //si el nombre está repetido se pone falso 
                        $grupoExiste = TRUE;
                    }else{
                        $grupoExiste = FALSE;
                    }
                    
                      /// validaciones para el incremento del producto
                         'Grupo entrante: '.$grupo;
                         '<br>';
                        //$grupo=str_replace($grupo);
                        $validarUltimoGrupo=$con->query("SELECt * FROM proveedorProductos WHERE grupo='$grupo' ORDER BY codigoG DESC");
                        $extraerUltimoGrupo=$validarUltimoGrupo->fetch_array(MYSQLI_ASSOC);
                      
                         'Grupo saliente: '.$ultimoGrupoIngresado=$extraerUltimoGrupo['grupo'];
                         '<br>';
                         'Codigo G: '.$ultimoGrupoIngresadocodigo=$extraerUltimoGrupo['codigoG'];
                         '<br>';
                        if($ultimoGrupoIngresadocodigo != NULL){
                             'B: '.$conteoNumero=$ultimoGrupoIngresadocodigo+1; 
                        }else{
                             'A: '.$conteoNumero=$conteoNumeroContador++;
                        }
                }
                
                $codigo = "";
                if(isset($Row[4])) {
                    $codigo = mysqli_real_escape_string($con,$Row[4]);
                    $codigo=trim($codigo);
                 
                    
                }
                
                
                $identificador = "";
                if(isset($Row[5])) {
                    $identificador = mysqli_real_escape_string($con,$Row[5]);
                     '<br>'.$identificador=trim($identificador);
                    if($identificador == ""){ 
                        $campoVacio=FALSE;
                    }else{
                        //$identificador=str_replace($identificador);
                      
                        $validacionIdentificador = $con->query("SELECT * FROM proveedoresProductoIdentificador WHERE grupo = '$identificador'  ");
                        $extraerConsultaValidacionIdentificar=$validacionIdentificador->fetch_array(MYSQLI_ASSOC);
                        $numIdentificador = mysqli_num_rows($validacionIdentificador);
                         'id: identificacdor: '.$identificadorEnviar=$extraerConsultaValidacionIdentificar['id'];
                        if($numIdentificador == 0){ 
                            //si el nombre está repetido se pone falso 
                            $identificadorExiste = FALSE;
                        }
                        
                        if($identificador == ""){
                            $campoVacio = FALSE;
                        }else{
                            //array_push($arrayIdentificadorRepitente,$identificador);
                        }
                    }
                }
                
                $impuesto = "";
                if(isset($Row[6])) {
                    $impuesto = mysqli_real_escape_string($con,$Row[6]);
                    $impuesto=trim($impuesto);
                    if($impuesto == ""){ 
                        $campoVacio=FALSE;
                    }
                    //$impuesto=str_replace($impuesto);
                    $validacionImpuesto = $con->query("SELECT * FROM proveedoresTipoImpuesto WHERE grupo = '$impuesto'  ");
                    $traeImpuesto=$validacionImpuesto->fetch_array(MYSQLI_ASSOC);
                    $impuestoEnviar=$traeImpuesto['id'];
                    
                    $numImpuesto = mysqli_num_rows($validacionImpuesto);
                    
                    if($numImpuesto > 0){
                        //si el nombre está repetido se pone falso 
                        $impuestoExiste = TRUE;
                    }else{
                        $impuestoExiste = FALSE;
                    }
                }
                
                $unidaddeEmpaque = "";
                if(isset($Row[7])) {
                    $unidaddeEmpaque = mysqli_real_escape_string($con,$Row[7]);
                    $unidaddeEmpaque=trim($unidaddeEmpaque);
                    
                    if($tipoProductoEnviar == 1){//if($tipoProducto == 'Bienes'){
                   
                        if($unidaddeEmpaque == ""){  
                            $campoVacio=FALSE;
                        }else{
                            $unidaddeEmpaque=($unidaddeEmpaque);
                            $validacionUnidadEmpaque = $con->query("SELECT * FROM proveedoresProductoEmpaque WHERE grupo = '$unidaddeEmpaque'  ");
                            $extraerUnidadEmpaque=$validacionUnidadEmpaque->fetch_array(MYSQLI_ASSOC);
                            $unidaddeEmpaqueEnviar=$extraerUnidadEmpaque['id'];
                            $numUnidadEmpaque = mysqli_num_rows($validacionUnidadEmpaque);
                            
                            if($numUnidadEmpaque > 0){
                                //si el nombre está repetido se pone falso 
                                $unidadEmpaqueExiste = TRUE;
                            }else{
                                $unidadEmpaqueExiste = FALSE;
                            }
                        }
                    }else{
                       
                    }
                    
                    
                }
                
                $unidaddeMedida = "";
                if(isset($Row[8])) {
                    $unidaddeMedida = mysqli_real_escape_string($con,$Row[8]);
                    $unidaddeMedida=trim($unidaddeMedida);
                    
                    if($tipoProductoEnviar == 1){//if($tipoProducto == 'Bienes'){ 
                        if($unidaddeMedida == ""){ 
                            $campoVacio=FALSE;
                        }else{
                            $unidaddeMedida=($unidaddeMedida);
                            $validacionUnidadMedida = $con->query("SELECT * FROM proveedoresProductoMedida WHERE grupo = '$unidaddeMedida'  ");
                            $extraerUnidadMedida=$validacionUnidadMedida->fetch_array(MYSQLI_ASSOC);
                            $unidaddeMedidaEnviar=$extraerUnidadMedida['id'];
                            $numUnidadMedida = mysqli_num_rows($validacionUnidadMedida);
                            
                            if($numUnidadMedida > 0){
                                //si el nombre está repetido se pone falso 
                                $unidadUnidadExiste = TRUE;
                            }else{ 
                                $unidadUnidadExiste = FALSE;
                            }
                        }
                    }else{
                        
                    }
                }
                
                $proveedor = "";
                if(isset($Row[9])) {
                    $proveedor = mysqli_real_escape_string($con,$Row[9]);
                    $proveedor=trim($proveedor);
                     
                    if($tipoProductoEnviar == 2){
                            if($proveedor == ""){
                                 'Viene vacio: '.$proveedorEnviar='0'; echo '<br>';
                            }else{
                                $validacionProveedor = $con->query("SELECT * FROM proveedores WHERE razonSocial = '$proveedor'  ");
                                $extraerProveedor=$validacionProveedor->fetch_array(MYSQLI_ASSOC);
                                $numUnidadProveedor = mysqli_num_rows($validacionProveedor);
                                 
                                if($numUnidadProveedor > 0){
                                    // si el proveedor existe envia el dato
                                    
                                        $proveedorExiste = TRUE;
                                        'existe: '.$proveedorEnviar=$extraerProveedor['id']; echo '<br>';
                                    
                                }else{
                                    $proveedorExiste = FALSE;
                                }
                            }
                        
                    }else{
                       
                    }
                }
                
                $inventario = "";
                if(isset($Row[10])) {
                    $inventario = mysqli_real_escape_string($con,$Row[10]);
                     '<br>'.$inventario=trim($inventario);
                     $inventario=mb_strtolower($inventario);
                    
                   
                }
                
                $activo = "";
                if(isset($Row[11])) {
                    $activo = mysqli_real_escape_string($con,$Row[11]);
                    $activo=trim($activo);
                    if($tipoProductoEnviar == 1){//if($tipoProducto == 'Bienes'){ 
                        if($activo == ""){ 
                            $campoVacio=FALSE;
                        }else{
                            if($activo == 'si' || $activo == 'Si' || $activo == 'SI' || $activo == 'sI' ){
                                $activoEnviar='Si';
                                $activoExiste=TRUE;
                            }elseif($activo == 'no' || $activo == 'No' || $activo == 'NO' || $activo == 'nO'){
                                $activoEnviar='No';
                                $activoExiste=TRUE;
                            }else{
                                $activoExiste=FALSE;
                            }
                        }
                    }else{
                        $activoEnviar='';
                    }
                    
                }
                
                $tiempoServicio = "";
                if(isset($Row[12])) {
                    $tiempoServicio = mysqli_real_escape_string($con,$Row[12]);
                    $tiempoServicio=trim($tiempoServicio);
                    
                    if(mb_strtolower($Row[0]) == 'servicio'){//if($tipoProducto == 'Servicios'){ 
                        
                        if($tiempoServicio == ""){ 
                            $campoVacio=FALSE;
                        }else{
                            
                                $buscaTiempo=$con->query("SELECT * FROM proveedoresProductoTiempo WHERE grupo='$tiempoServicio' ");
                                $extraerDatos=$buscaTiempo->fetch_array(MYSQLI_ASSOC);
                                
                                if($extraerDatos['id'] != NULL){
                                    $enviarIdTiempoServicio=$extraerDatos['id'];
                                    $noExisteTiempoServicio=TRUE;
                                }else{
                                    ///// alerta que no existe el tiempo de servicio
                                    $noExisteTiempoServicio=FALSE;
                                }
                           
                        }
                        
                    }
                }
                
				$cantidadServicio = "";
                if(isset($Row[13])) {
                    $cantidadServicio = mysqli_real_escape_string($con,$Row[13]);
                    $cantidadServicio=trim($cantidadServicio);
                    if($tipoProductoEnviar == 2){
                        if($cantidadServicio == ""){ 
                                $campoVacio=FALSE;
                        }else{
                            if(is_numeric($cantidadServicio)){
                                    
                            }else{ 
                                 $validacionNumerico=FALSE;
                            }    
                                    
                        }
                    }  
                    
                }
                
                
                if (!empty($nombre) || !empty($descripcion)  ) {
                    
                    if($activarAlerta == FALSE || $validacionNumerico == FALSE || $noExisteTiempoServicio == FALSE || $campoVacio == FALSE || $nombreExiste == FALSE || $repiteNombreExcel == FALSE || $codigoExiste == FALSE || $repiteCodigoExcel == FALSE || $identificadorExiste == FALSE || $repiteIdentificadorExcel == FALSE || $tipoProductoExistenca == FALSE || $unidadEmpaqueExiste == FALSE || $impuestoExiste == FALSE || $grupoExiste == FALSE || $proveedorExiste == FALSE || $inventarioExiste == FALSE || $contadorInvenatio == 1 || $activoExiste == FALSE || $unidadUnidadExiste == FALSE){
                      
                       //echo '<br>Validaciones<br>'; 
                       
                      if($activarAlerta == FALSE){ 
                            $enviarVariableAlerta=1;
                      }
                        
                      if($campoVacio == FALSE){ 
                           $validacionVacioa='1';
                            '<br>Campo vacio';
                          ?>
                                <script>
                                        window.onload=function(){
                                           document.forms["miformularioCampoVacio"].submit();
                                            }
                                </script>
                                <form name="miformularioCampoVacio" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                                   <input type="hidden" name="mensajeEnviarCampoVacio" value="<?php echo $mensajeCampoVacio;?>">
                                   <input type="hidden" name="validacionExisteImportacionVacio" value="1">
                                </form>
                                
                            <?php
                      }
                      
                      if($noExisteTiempoServicio == FALSE){
                          $validacionVaciob='1';
                           '<br>Campo vacio2';
                          ' -- conteo campo vacio2: '.$contadorCampoVaio2='1';
                           'Tiempo se servicio: '.$enviarTiempoServicioNo;
                          $iempoServicioACtivo=1;
                          
                      }
                      
                      if($validacionNumerico == FALSE){
                          $validacionNumericoIdentificar='1';
                             'Está intentando ingresar letras en un campo númerico<br>'; 
                             
                        }
                        
                      
                      if($nombreExiste == FALSE){ //$enviarNombreExistente
                          $validacionNombreExiste='1';
                           '<br>El nombre ya existe';
                      }
                      
                      if($repiteNombreExcel == FALSE){
                          $validacionNombreRepitente='1';
                           '<br>El nombre está repetido en el documento';
                           ?>
                                <script>
                                        window.onload=function(){
                                            document.forms["miformularioRepiteNombr"].submit();
                                            }
                                </script>
                                <form name="miformularioRepiteNombr" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                                   <input type="hidden" name="validacionExisteImportacion2" value="1">
                                </form>
                                
                            <?php
                      }
                      
                      if($codigoExiste == FALSE){
                          $validacionCodigoExiste='1';
                           '<br>el código ya existe';
                          ?>
                                <script>
                                        window.onload=function(){
                                            document.forms["miformularioCodigoE"].submit();
                                            }
                                </script>
                                <form name="miformularioCodigoE" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                                   <input type="hidden" name="validacionExisteImportacion3" value="1">
                                </form>
                                
                            <?php
                      }
                      
                      if($repiteCodigoExcel == FALSE){
                          $validacionCodigoRepite='1';
                           '<br>El código está repetido en el documento';
                           ?>
                                <script>
                                        window.onload=function(){
                                            document.forms["miformularioRepiteCodigo"].submit();
                                            }
                                </script>
                                <form name="miformularioRepiteCodigo" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                                   <input type="hidden" name="validacionExisteImportacion4" value="1">
                                </form>
                                
                            <?php
                      }
                      
                      if($identificadorExiste == FALSE){
                          $validacionIdentificadorExiste='1';
                          '<br>El identificador ya existe';
                           
                      }
                      
                      if($repiteIdentificadorExcel == FALSE){
                           $validacionIdentificadorRepite='1';
                           '<br>El identificador está repetido en el documento';
                         ?>
                                <script>
                                        window.onload=function(){
                                            document.forms["miformularioRepiteIdentifi"].submit();
                                            }
                                </script>
                                <form name="miformularioRepiteIdentifi" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                                   <input type="hidden" name="validacionExisteImportacion6" value="1">
                                </form>
                                
                            <?php
                      }
                        
                      if($impuestoExiste == FALSE){
                          $validacionImpuestoExiste='1';
                           '<br>El impuesto no existe '.$enviarImpuesto;
                            
                      }  
                      
                      if($grupoExiste == FALSE){
                          $validacionGrupoExiste='1';
                           '<br>El grupo no existe: '.$enviarGrupo;
                         
                      }
                        
                        
                      if($tipoProductoExistenca == FALSE){
                          $validacionTipoProductoExistecia='1';
                           '<br>Está ingresando un tipo de servicio no autorizado';
                          
                      }
                      
                      if($unidadEmpaqueExiste == FALSE){
                          $validacionEmpaqueExiste='1';
                            '<br>La unidad de empaque no existe '.$enviarUnidadEmpaque;
                         
                      }
                      
                      if($proveedorExiste == FALSE){
                          $validacionProveedorExiste='1';
                         'proveedor';
                      }
                      
                      if($inventarioExiste == FALSE || $contadorInvenatio == 1){ 
                          $validacionInventarioExiste='1';
                          '<br>La respuesta del inventario no es la correcta';
                           
                      }
                      
                      if($activoExiste == FALSE){
                          $validacionActivoExiste='1';
                           '<br>La respuesta del activo no es la correcta';
                         
                      }
                    
                      if($unidadUnidadExiste == FALSE){
                          $validacionUnidadExiste='1';
                           '<br>La unidad de medida no existe: '.$enviarUnidadMedidaa;
                        
                      }
                    
                        // if($impuestoValidar == FALSE){
                        //     ?><!--
                                <script>
                        //                window.onload=function(){
                        //                    document.forms["miformulario"].submit();
                        //                    }
                        //        </script>
                                <form name="miformulario" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                                   <input type="hidden" name="validacionExisteImportacionImpuesto" value="1">
                                   <input name="idProveedor" value="<?php //echo $idProveedor; ?>" type="hidden" readonly>
                                </form>
                            -->
                           <?php
                        // }
                         
                      
                        
                        
                    }else{
                   
                       
                        if($tipoProductoEnviar == '1'){ 
                            $presentacion=$unidaddeEmpaqueEnviar;
                            $presentacionb=$unidaddeMedidaEnviar;
                            $proveedorEnviarGaurdar='0';
                        }
                        
                        if($tipoProductoEnviar == '2'){
                           
                             'id proveedor'.$proveedorEnviarGaurdar=$proveedorEnviar;   '<br>';
                        }
                      
                      
                        if($proveedorEnviar == NULL){
                            $proveedorEnviarGaurdar='0';
                        }
                       
                       
                       /// evaluamos si alguna de las validaciones se activa, al activar una de las alertas, permite detener el direccionamiento del insert a la tabla, da una pausa y envia la alerta
                        '<br>alerta: '.$alertaAlgunaActivada=$contadorInvenatio+$validacionVacioa+$validacionVaciob+$validacionNumericoIdentificar+$validacionNombreExiste+$validacionNombreRepitente+$validacionCodigoExiste+$validacionCodigoRepite+$validacionIdentificadorExiste+$validacionIdentificadorRepite+$validacionImpuestoExiste+$validacionGrupoExiste+$validacionTipoProductoExistecia+$validacionEmpaqueExiste+$validacionProveedorExiste+$validacionInventarioExiste+$validacionActivoExiste+$validacionUnidadExiste;
                       
                       if($alertaAlgunaActivada > 0){
                          // echo 'activa alerta';
                       }else{ 
                           //echo '<br>Registro';
                           
                           if($tipoProductoEnviar == '1'){ // Si el producto es un bien, no ingresa cantidad de días y tampoco tipo de servicio
                           
                            $query = "INSERT INTO proveedorProductos (nombre,descripcion,codigo,identificador,impuesto,grupo,tipoProducto,presentacion,presentacionb,inventario,activo,importacion,codigoG)
                            VALUES('$nombre','$descripcion','$codigo','$identificadorEnviar','$impuestoEnviar','$grupo','$tipoProductoEnviar','$presentacion','$presentacionb','$inventarioEnviar','$activoEnviar',TRUE,'$conteoNumero')";
                            $resultados = mysqli_query($con, $query)or die(mysqli_error($con));
                            
                           }else{
                              
                            $query = "INSERT INTO proveedorProductos (nombre,descripcion,codigo,identificador,impuesto,grupo,tipoProducto,presentacion,presentacionb,proveedor,inventario,activo,importacion,codigoG,tiempoServicio,cantidadTiempoServicio)
                            VALUES('$nombre','$descripcion','$codigo','$identificadorEnviar','$impuestoEnviar','$grupo','$tipoProductoEnviar','$presentacion','$presentacionb','$proveedorEnviarGaurdar','$inventarioEnviar','$activoEnviar',TRUE,'$conteoNumero','$enviarIdTiempoServicio','$cantidadServicio')";
                            $resultados = mysqli_query($con, $query)or die(mysqli_error($con));
                            
                           }
                        
                        
                            ?>
                                <script>
                                        window.onload=function(){
                                            
                                            document.forms["miformularioRegistro"].submit();
                                            }
                                </script>
                                <form name="miformularioRegistro" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                                   <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                                   <input type="hidden" name="validacionExisteImportacionExito" value="1">
                                </form> 
                                
                            <?php 
                           
                       }
                   
                    
                    }
                }
             }
        
        }//end for 
         
  }
  else
  { 
        $type = "error";
        $message = "El archivo enviado es invalido. Por favor vuelva a intentarlo";
  }
}


if($validacionIdentificadorExiste == 1){
    ?>
                                <script>
                                        window.onload=function(){
                                            document.forms["miformularioIndetificador"].submit();
                                            }
                                </script>

                                <form name="miformularioIndetificador" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                                    <input name="enviarIdentificadorNo" value="<?php echo $enviarIdentificadorNo;?>" type="hidden">
                                   <input type="hidden" name="validacionExisteImportacion5" value="1">
                                </form>
                                
                            <?php
}

if($validacionTipoProductoExistecia == 1){

?>
                                <script>
                                        window.onload=function(){
                                            document.forms["miformularioTipoProducto"].submit();
                                            }
                                </script>
                                <form name="miformularioTipoProducto" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                                   <input name="enviarTipoProductoNo" value="<?php echo $enviarTipoProductoNo;?>" type="hidden">
                                   <input type="hidden" name="validacionExisteImportacion9" value="1">
                                </form>
                                
                            <?php
}

if($validacionInventarioExiste == 1){ //echo '<br>Inventario valo';
    ?>
                                <script>
                                        window.onload=function(){
                                            document.forms["miformularioInvetnatrio"].submit();
                                            }
                                </script>
                                <form name="miformularioInvetnatrio" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                                    <input name="enviarRespuestaInventario" value="<?php echo $enviarRespuestaInventario;?>" type="hidden">
                                   <input type="hidden" name="validacionExisteImportacion12" value="1">
                                </form>
                                
                            <?php
}

if($validacionUnidadExiste == 1){
                            ?>
                                <script>
                                        window.onload=function(){
                                            document.forms["miformularioUnidadMedida"].submit();
                                            }
                                </script>
                                <form name="miformularioUnidadMedida" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                                   <input name="enviarUnidadMedida" value="<?php echo $enviarUnidadMedidaa;?>" type="hidden">
                                   <input type="hidden" name="validacionExisteImportacion14" value="1">
                                </form>
                                
                            <?php
}

if($validacionImpuestoExiste == 1){
?>
                                <script>
                                        window.onload=function(){
                                            document.forms["miformularioImpuesto"].submit();
                                            }
                                </script>
                                <form name="miformularioImpuesto" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                                    <input name="enviarImpuesto" value="<?php echo $enviarImpuesto;?>" type="hidden">
                                   <input type="hidden" name="validacionExisteImportacion7" value="1">
                                </form>
                                
                            <?php
}

if($validacionGrupoExiste == 1){
?>
                                <script>
                                        window.onload=function(){
                                            document.forms["miformularioGrupo"].submit();
                                            }
                                </script>
                                <form name="miformularioGrupo" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                                    <input name="enviarGrupo" value="<?php echo $enviarGrupo;?>" type="hidden">
                                   <input type="hidden" name="validacionExisteImportacion8" value="1">
                                </form>
                                
                            <?php
}

if($validacionEmpaqueExiste == 1){
?>
                                <script>
                                        window.onload=function(){
                                            document.forms["miformularioUnidadEmpque"].submit();
                                            }
                                </script>
                                <form name="miformularioUnidadEmpque" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                                    <input name="enviarUnidadEmpaque" value="<?php echo $enviarUnidadEmpaque;?>" type="hidden">
                                   <input type="hidden" name="validacionExisteImportacion10" value="1">
                                </form>
                                
                            <?php
}


if($validacionProveedorExiste == 1){
?>
                                <script>
                                        window.onload=function(){
                                            document.forms["miformularioProveedor"].submit();
                                            }
                                </script>
                                <form name="miformularioProveedor" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                                    <?php
                                    if($proveecorNoActivo != NULL){
                                        'proveedor no activo'.$proveecorNoActivo;
                                    ?>
                                        <input name="enviarDatoProveedorActivo" type="hidden" value="<?php echo $proveecorNoActivo;?>">
                                    <?php
                                    }
                                    if($proveedorNoExiste != NULL){
                                        'proveedor no existente'.$proveedorNoExiste;
                                    }
                                    ?>
                                        <input name="enviarDatoProveedorNoExistente" type="hidden" value="<?php echo $proveedorNoExiste;?>">
                                    <?php
                                    ?>
                                    <!--<input type="submit">-->
                                   <input type="hidden" name="validacionExisteImportacion11" value="1">
                                </form>
                                
                            <?php
}

if($validacionActivoExiste == 1){
    ?>
                                <script>
                                        window.onload=function(){
                                            document.forms["miformularioActivo"].submit();
                                            }
                                </script>
                                <form name="miformularioActivo" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                                    <input name="enviarActivoNo" type="hidden" value="<?php echo $enviarActivoNo;?>">
                                   <input type="hidden" name="validacionExisteImportacion13" value="1">
                                </form>
                                
                            <?php
}

if($iempoServicioACtivo == 1){
?>
                                <script>
                                        window.onload=function(){
                                            document.forms["miformularioTiempoServicio"].submit();
                                            }
                                </script>
                                <form name="miformularioTiempoServicio" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                                    <input name="enviarTiempoServicioNo" type="hidden" value="<?php echo $enviarTiempoServicioNo;?>">
                                   <input type="hidden" name="validacionExisteImportacionTipoServicio" value="1">
                                </form>
                                
                            <?php
}


if($validacionNumericoIdentificar == 1){
?>
                                <script> 
                                     window.onload=function(){
                                   
                                       document.forms["miformularioNumerico"].submit();
                                     }
                                </script>
                                 
                                <form name="miformularioNumerico" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                                    <input name="enviarCantidadServicioNo" value="<?php echo $enviarCantidadServicioNo;?>" type="">
                                    <input type="hidden" name="validacionExisteNumerio" value="1">
                                </form> 
                            <?php
}


if($validacionNombreExiste == 1){
 ?>
                                <script>
                                        window.onload=function(){
                                            document.forms["miformularioNombreE"].submit();
                                            }
                                </script>
                                <form name="miformularioNombreE" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                                   <input name="enviarNombreExistente" type="" value="<?php echo $enviarNombreExistente;?>">
                                   <input type="hidden" name="validacionExisteImportacion1" value="1">
                                </form>
                                
                            <?php
                            
}

if($enviarVariableAlerta == '1'){ /// esta alerta debe activarse con todas las columnas
  //echo 'validaci´pon alerta';
    //// agregamos todas las variables enviadas por columna
    if($enviarTipoProductoString != NULL || $enviarTipoProductoStringL != NULL){  
        if($tipoValidacionTipoProducto == '1'){ 
            $almacenajeAlertaCaracter='en la celda '.($enviarTipoProductoString+1);
            $almacenajeAlertaCaracterTipo='celdaTipoProducto';
        }
        if($tipoValidacionTipoProducto == '2'){  
            if($enter_encontrado_tipoProducto == '1'){ /// identificamos la alerta activa
                $enter_encontrado='1';
                $titulo='El tipo de producto';
                $almacenajeAlertaCaracterCelda=$enviarTipoProductoStringL+1;
                $almacenajeAlertaCaracterTipo='caracterTipoProducto';
            }else{
                $almacenajeAlertaCaracter=$enviarTipoProductoStringL;
                $almacenajeAlertaCaracterTipo='caracterTipoProducto';
            }
        }
        
    }
    
    if($enviarNombreString != NULL || $enviarNombreStringL != NULL){ 
        if($tipoValidacionNombre == '1'){ 
            $almacenajeAlertaCaracter='en la celda '.($enviarNombreString+1);
            $almacenajeAlertaCaracterTipo='celdaNombre';
        }
        if($tipoValidacionNombre == '2'){ 
            if($enter_encontrado_nombre == '1'){ /// identificamos la alerta activa
                $enter_encontrado='1';
                $titulo='El nombre del bien o servicio';
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
    
    if($enviarGrupoString != NULL || $enviarGrupoStringL != NULL){ 
        if($tipoValidacionGrupo == '1'){ 
            $almacenajeAlertaCaracter='en la celda '.($enviarGrupoString+1);
            $almacenajeAlertaCaracterTipo='celdaGrupo';
        }
        if($tipoValidacionGrupo == '2'){ 
            if($enter_encontrado_grupo == '1'){ /// identificamos la alerta activa
                $enter_encontrado='1';
                $titulo='El grupo y subgrupo';
                $almacenajeAlertaCaracterCelda=$enviarGrupoStringL+1;
                $almacenajeAlertaCaracterTipo='caracterGrupo';
            }else{
                $almacenajeAlertaCaracter=$enviarGrupoStringL;
                $almacenajeAlertaCaracterTipo='caracterGrupo';
            }
        }
        
    }
   
    if($enviarCodigoString != NULL || $enviarCodigoStringL != NULL){ 
        if($tipoValidacionCodigo == '1'){ 
            $almacenajeAlertaCaracter='en la celda '.($enviarCodigoString+1);
            $almacenajeAlertaCaracterTipo='celdaCodigo';
        }
        if($tipoValidacionCodigo == '2'){
            if($enter_encontrado_codigo == '1'){ /// identificamos la alerta activa
                $enter_encontrado='1';
                $titulo='El código';
                $almacenajeAlertaCaracterCelda=$enviarCodigoStringL+1;
                $almacenajeAlertaCaracterTipo='caracterCodigo';
            }else{
                $almacenajeAlertaCaracter=$enviarCodigoStringL;
                $almacenajeAlertaCaracterTipo='caracterCodigo';
            }
        }
        
    }
    
    if($enviarIdentificadorString != NULL || $enviarIdentificadorStringL != NULL){  
        if($tipoValidacionIdentificador == '1'){ 
            $almacenajeAlertaCaracter='en la celda '.($enviarIdentificadorString+1);
            $almacenajeAlertaCaracterTipo='celdaIdentificador';
        }
        if($tipoValidacionIdentificador == '2'){
            if($enter_encontrado_identificador == '1'){ /// identificamos la alerta activa
                $enter_encontrado='1';
                $titulo='El identificador';
                $almacenajeAlertaCaracterCelda=$enviarIdentificadorStringL+1;
                $almacenajeAlertaCaracterTipo='caracterIdentificador';
            }else{
                $almacenajeAlertaCaracter=$enviarIdentificadorStringL;
                $almacenajeAlertaCaracterTipo='caracterIdentificador';
            }
        }
        
    }
    
    if($enviarImpuestoString != NULL || $enviarImpuestoStringL != NULL){  
        if($tipoValidacionImpuesto == '1'){ 
            $almacenajeAlertaCaracter='en la celda '.($enviarImpuestoString+1);
            $almacenajeAlertaCaracterTipo='celdaImpuesto';
        }
        if($tipoValidacionImpuesto == '2'){ 
            if($enter_encontrado_impuesto == '1'){ /// identificamos la alerta activa
                $enter_encontrado='1';
                $titulo='El impuesto';
                $almacenajeAlertaCaracterCelda=$enviarImpuestoStringL+1;
                $almacenajeAlertaCaracterTipo='caracterImpuesto';
            }else{ 
                $almacenajeAlertaCaracter=$enviarImpuestoStringL;
                $almacenajeAlertaCaracterTipo='caracterImpuesto';
            }
        }
        
    }
    
    if($enviarUnidademapqueString != NULL || $enviarUnidademapqueStringL != NULL){  
        if($tipoValidacionUnidadempaque == '1'){ 
            $almacenajeAlertaCaracter='en la celda '.($enviarUnidademapqueString+1);
            $almacenajeAlertaCaracterTipo='celdaUnidadempaque';
        }
        if($tipoValidacionUnidadempaque == '2'){ 
            if($enter_encontrado_unidadempaque == '1'){ /// identificamos la alerta activa
                $enter_encontrado='1';
                $titulo='La unidad de empaque';
                $almacenajeAlertaCaracterCelda=$enviarUnidademapqueStringL+1;
                $almacenajeAlertaCaracterTipo='caracterUnidadempaque';
            }else{ 
                $almacenajeAlertaCaracter=$enviarUnidademapqueStringL;
                $almacenajeAlertaCaracterTipo='caracterUnidadempaque';
            }
        }
        
    }
    
    if($enviarUnidadmedidaString != NULL || $enviarUnidadmedidaStringL != NULL){  
        if($tipoValidacionUnidadmedida == '1'){ 
            $almacenajeAlertaCaracter='en la celda '.($enviarUnidadmedidaString+1);
            $almacenajeAlertaCaracterTipo='celdaUnidadmedida';
        }
        if($tipoValidacionUnidadmedida == '2'){ 
            if($enter_encontrado_unidadmedida == '1'){ /// identificamos la alerta activa
                $enter_encontrado='1';
                $titulo='La unidad de medida';
                $almacenajeAlertaCaracterCelda=$enviarUnidadmedidaStringL+1;
                $almacenajeAlertaCaracterTipo='caracterUnidadmedida';
            }else{ 
                $almacenajeAlertaCaracter=$enviarUnidadmedidaStringL;
                $almacenajeAlertaCaracterTipo='caracterUnidadmedida';
            }
        }
        
    }
    
    if($enviarProveedorString != NULL || $enviarProveedorStringL != NULL){  
        if($tipoValidacionProveedor == '1'){ 
            $almacenajeAlertaCaracter='en la celda '.($enviarProveedorString+1);
            $almacenajeAlertaCaracterTipo='celdaProveedor';
        }
        if($tipoValidacionProveedor == '2'){
            if($enter_encontrado_proveedor == '1'){ /// identificamos la alerta activa
                $enter_encontrado='1';
                $titulo='El proveedor sugerido';
                $almacenajeAlertaCaracterCelda=$enviarProveedorStringL+1;
                $almacenajeAlertaCaracterTipo='caracterProveedor';
            }else{ 
                $almacenajeAlertaCaracter=$enviarProveedorStringL;
                $almacenajeAlertaCaracterTipo='caracterProveedor';
            }
        }
        
    }
    
    if($enviarTiemposervicioString != NULL || $enviarTiemposervicioStringL != NULL){  
        if($tipoValidacionTiemposervicio == '1'){ 
            $almacenajeAlertaCaracter='en la celda '.($enviarTiemposervicioString+1);
            $almacenajeAlertaCaracterTipo='celdaTiemposervicio';
        }
        if($tipoValidacionTiemposervicio == '2'){
            if($enter_encontrado_tiemposervicio == '1'){ /// identificamos la alerta activa
                $enter_encontrado='1';
                $titulo='El tiempo de servicio';
                $almacenajeAlertaCaracterCelda=$enviarTiemposervicioStringL+1;
                $almacenajeAlertaCaracterTipo='caracterTiemposervicio';
            }else{ 
                $almacenajeAlertaCaracter=$enviarTiemposervicioStringL;
                $almacenajeAlertaCaracterTipo='caracterTiemposervicio';
            }
        }
        
    }
    
    
    if($enviarActivoString != NULL || $enviarActivoStringL != NULL){  
        if($tipoValidacionActivo == '1'){ 
            $almacenajeAlertaCaracter='en la celda '.($enviarActivoString+1);
            $almacenajeAlertaCaracterTipo='celdaActivo';
        }
        if($tipoValidacionActivo == '2'){
            if($enter_encontrado_activo == '1'){ /// identificamos la alerta activa
                $enter_encontrado='1';
                $titulo='La columna activo';
                $almacenajeAlertaCaracterCelda=$enviarActivoStringL+1;
                $almacenajeAlertaCaracterTipo='caracterActivo';
            }else{ 
                $almacenajeAlertaCaracter=$enviarActivoStringL;
                $almacenajeAlertaCaracterTipo='caracterActivo';
            }
        }
        
    }
   
    ?>
                            <script> 
                                 window.onload=function(){
                                    document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
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
                                <!--<input type="submit">-->
                            </form> 
    <?php  
  }
                 

?>
    
                                                                    