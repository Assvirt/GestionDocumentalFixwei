<?php error_reporting(E_ERROR); error_reporting(0);
include('dbconect.php');
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
        
        $nombreCargoRepetido = TRUE;
        $nombreInmediato = TRUE;
        $nombreCargoRe = TRUE;
        
        $campoNull = TRUE;
        $arrayNombres = array();
        $repiteNombre = TRUE;
        
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
        //// variables para mandar la celda del error
        $buscando_celda_nivel=1;
        $buscando_celda_nivel_contando=1;
        $string_nivel='';
        
        $buscando_celda_jefe_inmediato=1;
        $string_jefe_inmediato='';
        
        // se declaran variables para el mensaje de caracteres
        $activarAlerta=TRUE;
        $enviarNombreString='';
        $enviarDescripcionString='';
        $enviarJefeInmediatoString='';
        $enviarNivelCargoString='';
        $activarAlertaEnter=TRUE; ///  variable declarada para el mensaje con campo enter
        
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
            $contador=0;
            $contandoNivelesCargarJefe=0;
            $contandoNivelesNivelCargo=0;
            foreach ($Reader as $Row)
            {
                
                $contador++;
                
                 if($Row[3]=='Nivel Cargo'){ continue; } //Aca remplazo por el nombre y posicion de la ultima columna de excel para que no me agrege la primera fila.
          
                $nombre = "";
                if(isset($Row[0])) {
                    $nombre = mysqli_real_escape_string($con,$Row[0]);
                    $nombre=trim($nombre);
                    $contadorCeldaNombre++;
                    $buscandoEnternombre++;
                    
                    if($nombre == ""){ 
                      $campoNull = FALSE;
                      $mensajeCampoVacio='en la columna cargo';
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
                       
                        $validacion1 = $con->query("SELECT * FROM cargos WHERE nombreCargos = '$nombre'");
                        $extraerValidar=$validacion1->fetch_array(MYSQLI_ASSOC);
                        $extraerValidar['nombreCargos'];
                        $num = mysqli_num_rows($validacion1);
                        
                        
                        if($nombre == ""){ 
                           $campoNull = FALSE;
                        }else{
                            array_push($arrayNombres,$nombre);
                        }
                        
                        if($num > 0){
                            //si el nombre está repetido se pone falso 
                            $nombreCargoRepetido = FALSE;
                            $enviarCargoExistenteBDRegistro=$nombre.', '; // variable para enviar cargos existentes
                        }
                    }
                }
                
                
                $descripcion = "";
                if(isset($Row[1])) {
                   
                    $descripcion = mysqli_real_escape_string($con,$Row[1]);
                    $descripcion=trim($descripcion);
                    $contadorCeldaDescripcion++;
                    $buscandoEnterdescripcion++; 
                    
                    if($descripcion == ""){ 
                        $campoNull = FALSE;
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
				
                $jefeInmediato = "";//gerente
                if(isset($Row[2])) {
                    
                    
                     /// volvemos el texto totalmente en minuscula
                        $jefeInmediato=mb_strtolower($jefeInmediato);
                        '<br>';
                     
                    $jefeInmediato = mysqli_real_escape_string($con,$Row[2]);
                    $jefeInmediato=trim($jefeInmediato);
                    $contadorCeldaJefeInmediato++;
                    $buscandoEnterjefeInmediato++;
                    
                    //compruebo que los caracteres sean los permitidos
                    $jefeInmediato_carecteres=['"'];
                    for($bc=0; $bc<count($jefeInmediato_carecteres); $bc++){
                        $jefeInmediato_carecteres[$bc]; 
                         $cadena_carecteres_jefeInmediato = $jefeInmediato_carecteres[$bc];
                        $coincidencia_caracteres= strpos($jefeInmediato, $cadena_carecteres_jefeInmediato);
                        if($coincidencia_caracteres != NULL){
                            $activarAlerta=FALSE;
                            $enviarJefeInmediatoString.=$contadorCeldaJefeInmediato.', ';
                            $tipoValidacionJefeInmediato='1';
                        }
                         '<br>';
                    }
                    
                    if($tipoValidacionJefeInmediato == '1'){
                        
                    }else{
                        
                         /// volvemos el texto totalmente en minuscula
                        $jefeInmediato=mb_strtolower($jefeInmediato);
                        '<br>';
                        
                        $permitidosJEfeInmediato = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñÑ/ ";
                           for ($i=0; $i<strlen($jefeInmediato); $i++){
                              if (strpos($permitidosJEfeInmediato, substr($jefeInmediato,$i,1))===false){
                                 $jefeInmediato . " no es válido<br>";
                                 $activarAlerta=FALSE;
                                 $tipoValidacionJefeInmediato='2';
                                 $enviarJefeInmediatoStringL=$jefeInmediato;
                                 //return false;
                              }
                           }
                           
                           //// validamos el enter antes de enviar la alerta
                                        $cadena_buscada_jefeInmediato = '\n';
                                        $posicion_coincidencia_jefeInmediato = strpos($jefeInmediato, $cadena_buscada_jefeInmediato);
                                        if($posicion_coincidencia_jefeInmediato === false){
                                            //echo 'si';
                                        }else{
                                            //echo 'no';
                                          $activarAlertaEnter=FALSE;
                                          $enviarResponsableStringLCjefeinmediato=$buscandoEnterjefeInmediato.',';
                                        }
                                    
                                        if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                            //echo 'enter encontrado';
                                            $enter_encontrado_jefe_inmediato='1';
                                            $enviarJefeInmediatoStringL=$enviarResponsableStringLCjefeinmediato;
                                        }else{
                                            $enviarJefeInmediatoStringL;
                                        }
                                        
                            /// end
                                
                    }
                    //// end

                    
                    if($activarAlerta == FALSE){
                        
                    }else{
                        if($jefeInmediato == "" || strtolower($jefeInmediato) == 'no aplica' || strtolower($jefeInmediato) == 'n/a' || strtolower($jefeInmediato) == 'na'){   '-activar-';
                            //$campoNull = FALSE;
                            $jefeInmediato='N/A';
                        }else{
                            
                            $array = explode(' ',$jefeInmediato);  // convierte en array separa por espacios;
                            $jefeInmediato ='';
                            // quita los campos vacios y pone un solo espacio
                            for ($i=0; $i < count($array); $i++) { 
                                if(strlen($array[$i])>0) {
                                    $jefeInmediato.= ' ' . $array[$i];
                                }
                            }
                            
                             $jefeInmediato=trim($jefeInmediato);
                                $enviarNombreJefeInmediato=$jefeInmediato;
                                $validacion2P = $con->query("SELECT * FROM cargos WHERE nombreCargos = '$jefeInmediato'");  
                                $extraerValidacion2=$validacion2P->fetch_array(MYSQLI_ASSOC);
                             '--'.$validamosNombreJefe=$extraerValidacion2['nombreCargos'];
                             '<br>';
                                $num2P = mysqli_num_rows($validacion2P);
                            
                            
                             $validamosNombreJefe;
                             '<br>';
                            
                            // validamos la celda que contiene el error
                            if($validamosNombreJefe != NULL){
                                 //(($buscando_celda_jefe_inmediato++)+1);
                            }else{
                                 $string_jefe_inmediato.=$enviarNombreJefeInmediato.', ';//(($buscando_celda_jefe_inmediato++)+1).',';
                            }
                            
                             '<br>';
                            //encontro 1 row
                            //if 1 < 1
                            if($num2P > 0){
                                //si jefe no existe se pone falso
                                $nombreInmediato = TRUE;
                            }else{
                                 $contandoNivelesCargarJefe++;
                                 //'Falso: '.$nombreInmediato = FALSE;
                                 $nombreInmediato = FALSE;
                                 //$jefeInmediato='No aplica';
                            }
                               '<br>';
                        }
                    }
                }
                
                $nivelCargo = "";
                if(isset($Row[3])) { 
                     
                    $nivelCargo = mysqli_real_escape_string($con,$Row[3]);
                    $nivelCargo=trim($nivelCargo);
                    $contadorCeldaNivelCargo++;
                    $buscandoEnterNivelcargo++;
                    
                    if($nivelCargo == ""){ 
                        $campoNull = FALSE;
                        $nivelCargo = 'No Aplica';
                        $mensajeCampoVacio='en la columna Nivel de cargo';
                    }else{
                        
                        
                        //compruebo que los caracteres sean los permitidos
                        $nivelCargo_carecteres=['"'];
                        for($bc=0; $bc<count($nivelCargo_carecteres); $bc++){
                            $nivelCargo_carecteres[$bc]; 
                             $cadena_carecteres_nivelCargo = $nivelCargo_carecteres[$bc];
                             ' - '.$coincidencia_caracteres= strpos($nivelCargo, $cadena_carecteres_nivelCargo);
                            if($coincidencia_caracteres != NULL){
                                $activarAlerta=FALSE;
                                $enviarNivelCargoString.=$contadorCeldaNivelCargo.', ';
                                $tipoValidacionNivelCargo='1';
                            }
                             '<br>';
                        }
                        
                        if($tipoValidacionNivelCargo == '1'){
                            
                        }else{
                            
                             $nivelCargo=mb_strtolower($nivelCargo);
                            
                            $permitidosNivelCargo = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ ";
                               for ($i=0; $i<strlen($nivelCargo); $i++){
                                  if (strpos($permitidosNivelCargo, substr($nivelCargo,$i,1))===false){
                                     $nivelCargo . " no es válido<br>";
                                     $activarAlerta=FALSE;
                                     $tipoValidacionNivelCargo='2';
                                     $enviarNivelCargoStringL=$nivelCargo;
                                     //return false;
                                  }
                               }
                                
                                //// validamos el enter antes de enviar la alerta
                                        $cadena_buscada_nivelCargo = '\n';
                                        $posicion_coincidencia_nivelCargo = strpos($nivelCargo, $cadena_buscada_nivelCargo);
                                        if($posicion_coincidencia_nivelCargo === false){
                                            //echo 'si';
                                        }else{
                                            //echo 'no';
                                          $activarAlertaEnter=FALSE;
                                          $enviarResponsableStringLCnivelcargo=$buscandoEnterNivelcargo.',';
                                        }
                                    
                                        if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                            //echo 'enter encontrado';
                                            $enter_encontrado_nivel_cargo='1';
                                            $enviarNivelCargoStringL=$enviarResponsableStringLCnivelcargo;
                                        }else{
                                            $enviarNivelCargoStringL;
                                        }
                                        
                                /// end
                        }
                        //// end

                        
                        if($activarAlerta == FALSE){
                            
                        }else{
                                $array = explode(' ',$nivelCargo);  // convierte en array separa por espacios;
                                $nivelCargo ='';
                                // quita los campos vacios y pone un solo espacio
                                for ($i=0; $i < count($array); $i++) { 
                                    if(strlen($array[$i])>0) {
                                        $nivelCargo.= ' ' . $array[$i];
                                    }
                                }
                                
                                $nivelCargo=trim($nivelCargo);
                                
                                // variable para confirmar no existencia
                                $nivelCargo_validar=$nivelCargo;
                                $validarnombreEnviar=$nivelCargo;
                                $validacion3 = $con->query("SELECT * FROM nivelcargo WHERE nivelCargo = '$nivelCargo' ");
                                $extraerNombreNivelCargo=$validacion3->fetch_array(MYSQLI_ASSOC);
                                ' --- '.$nombreNivelCargo=$extraerNombreNivelCargo['nivelCargo'];
                                  $nivelCargo = $extraerNombreNivelCargo['id'];
                                '<br>';
                                $num3 = mysqli_num_rows($validacion3);
                                
                                // validamos la celda que contiene el error
                                if($nombreNivelCargo != NULL){
                                     (($buscando_celda_nivel++)+1); //echo $nivelCargo_validar;
                                }else{
                                     'error: '.$string_nivel.=$validarnombreEnviar.', ';//(($buscando_celda_nivel++)+1).','; //echo $nivelCargo_validar;
                                     ' - ';  $validarnombreEnviar;  '<br>';
                                }
                                
                                 '<br>';
                                if($num3 == 0){  
                                    // si el nombre del nivel de cargo no existe se pone falso
                                    $contandoNivelesNivelCargo++;
                                    $nombreCargoRe = FALSE;
                                }else{
                                    $nombreCargoRe = TRUE;
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
                                         
                                        <form name="miformularioV" action="../../cargos" method="POST" onsubmit="procesar(this.action);" >
                                            <input type="hidden" name="mensajeEnviarCampoVacio" value="<?php echo $mensajeCampoVacio;?>">
                                            <input type="hidden" name="validacionExisteImportacionVacio" value="1">
                                        </form> 
                                <?php
            }
            // END
            
        
        }
        
        if(count($arrayNombres) > count(array_unique($arrayNombres))){//Valido si hay seriales repetidos
          $repiteNombre = FALSE;
        }
        
        if($contandoNivelesCargarJefe > 0 || $contandoNivelesNivelCargo > 0){
            if($contandoNivelesCargarJefe > 0){
                                ?>
                                            <script> 
                                                 window.onload=function(){
                                               //alert("Debe alertar");
                                                     document.forms["miformularioC"].submit();
                                                 }
                                            </script>
                                             
                                            <form name="miformularioC" action="../../cargos" method="POST" onsubmit="procesar(this.action);" >
                                                 <input type="hidden" name="validacionExisteImportacionC" value="1">
                                                 <input type="hidden" name="EnviarvalidacionExisteImportacionC" value="<?php echo $string_jefe_inmediato;?>">
                                                 
                                            </form> 
                                <?php
            }elseif($contandoNivelesNivelCargo > 0){
                                ?>
                                            <script> 
                                                 window.onload=function(){
                                               //alert("Entrando en otra validación de niveles ");
                                                     document.forms["miformularioC"].submit();
                                                 }
                                            </script>
                                             
                                            <form name="miformularioC" action="../../cargos" method="POST" onsubmit="procesar(this.action);" >
                                                <input type="hidden" name="validacionExisteImportacionD" value="<?php echo $string_nivel;?>">
                                            </form> 
                                <?php
            }
                                
        }else{
        //echo '<br><br><br>';
        
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
            $contandoNivelesCargar=0;
            
            foreach ($Reader as $Row)
            {
          
                if($Row[3]=='Nivel Cargo'){ continue; } //Aca remplazo por el nombre y posicion de la ultima columna de excel para que no me agrege la primera fila.
          
          
                
                $nombre = "";
                if(isset($Row[0])) {
                    utf8_decode($nombre = mysqli_real_escape_string($con,$Row[0]));
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
                
                $descripcion = "";
                if(isset($Row[1])) {
                    utf8_decode($descripcion = mysqli_real_escape_string($con,$Row[1]));
                      $descripcion=trim($descripcion);
                }
				
                $jefeInmediato = "";
                if(isset($Row[2])) {
                    
                    $jefeInmediato = mysqli_real_escape_string($con,$Row[2]);
                     $jefeInmediato=trim($jefeInmediato);
                    if($jefeInmediato == "" || strtolower($jefeInmediato) == 'no aplica' || strtolower($jefeInmediato) == 'n/a' || strtolower($jefeInmediato) == 'na'){   '-activar-';
                        //$campoNull = FALSE;
                        $jefeInmediato='N/A';
                    }else{
                        
                        $array = explode(' ',$jefeInmediato);  // convierte en array separa por espacios;
                        $jefeInmediato ='';
                        // quita los campos vacios y pone un solo espacio
                        for ($i=0; $i < count($array); $i++) { 
                            if(strlen($array[$i])>0) {
                                $jefeInmediato.= ' ' . $array[$i];
                            }
                        }
                        
                        $jefeInmediato=trim($jefeInmediato);
                        
                        
                        $validacion2 = $con->query("SELECT * FROM cargos WHERE nombreCargos = '$jefeInmediato'");  
                        $extraerValidacion2=$validacion2->fetch_array(MYSQLI_ASSOC);
                         $jefeInmediato = $extraerValidacion2['id_cargos'];
                         '--'.$extraerValidacion2['nombreCargos'];
                        '<br>';
                        $num22 = mysqli_num_rows($validacion2);
                        
                       
                        
                        //encontro 1 row
                        //if 1 < 1
                        if($num22 > 0){
                            //si jefe no existe se pone falso
                            $nombreInmediato = TRUE;
                        }else{
                            
                             'Falso: '.$nombreInmediato = FALSE;
                             //$jefeInmediato='N/A';
                        }
                           '<br>';
                    }  
                   
                }
                
                $nivelCargo = "";
                if(isset($Row[3])) {
                    $nivelCargo = mysqli_real_escape_string($con,$Row[3]);
                    $nivelCargo=trim($nivelCargo);
                     'Cargo entrante: '.$nivelCargo; 
                    
                   if($nivelCargo == ""){   '-activar-';
                        $campoNull = FALSE;
                        
                    }else{
                       
                        $array = explode(' ',$nivelCargo);  // convierte en array separa por espacios;
                        $nivelCargo ='';
                        // quita los campos vacios y pone un solo espacio
                        for ($i=0; $i < count($array); $i++) { 
                            if(strlen($array[$i])>0) {
                                $nivelCargo.= ' ' . $array[$i];
                            }
                        }
                        
                        $nivelCargo=trim($nivelCargo);
                       
                        $extraeID2 = $con->query("SELECT * FROM nivelcargo WHERE nivelCargo = '$nivelCargo'");  
                        $rowIdCargo = $extraeID2->fetch_array(MYSQLI_ASSOC);
                        $num3 = mysqli_num_rows($extraeID2);
                        $nivelCargo = $rowIdCargo['id'];
                         '---Cargo saliente: '.$rowIdCargo['nivelCargo']; 
                       
                        
                        
                        if($num3 == 0){
                            // si el nombre del nivel de cargo no existe se pone falso
                             'Activar: '.$nombreCargoRe = FALSE;
                             ' -- Contador: '.$contandoNivelesCargar++;
                        }else{
                            $nombreCargoRe = TRUE;
                        }
                        
                         '<br>';
                    }
                }
                
                
                $validandoArchivo = "";
                if(isset($Row[4])) {
                   $validandoArchivo = mysqli_real_escape_string($con,$Row[4]);
                
                }
				
				if($validandoArchivo != NULL){ /// evitamos subir un documento diferente
				
    				    
                           ?>
                                        <script> 
                                             window.onload=function(){
                                           
                                                 document.forms["miformulario"].submit();
                                             }
                                        </script>
                                         
                                        <form name="miformulario" action="../../cargos" method="POST" onsubmit="procesar(this.action);" >
                                            <input type="hidden" name="validacionExisteImportacionAA" value="1">
                                        </form> 
                            <?php
				}else{
                
                if (!empty($nombre) || !empty($descripcion) || !empty($jefeInmediato) || !empty($nivelCargo)   ) {
                    
                    

                    if($activarAlerta == FALSE || $repiteNombre == FALSE || $nombreCargoRepetido == FALSE || $nombreInmediato == FALSE || $nombreCargoRe == FALSE || $campoNull == FALSE){
                         '<br>validaciones';
                        
                        if($activarAlerta == FALSE){ 
                            $enviarVariableAlerta=1;
                        }
                         
                        if($campoNull == FALSE){ 
                             ?>
                                        <script> 
                                             window.onload=function(){
                                           
                                                document.forms["miformularioValindaod"].submit();
                                             }
                                        </script>
                                         
                                        <form name="miformularioValindaod" action="../../cargos" method="POST" onsubmit="procesar(this.action);" >
                                             <input type="hidden" name="mensajeEnviarCampoVacio" value="<?php echo $mensajeCampoVacio;?>">
                                            <input type="hidden" name="validacionExisteImportacionVacio" value="1">
                                        </form> 
                                <?php
                        }
                        
                        
                        if($repiteNombre == FALSE){ 
                       
                                ?>
                                        <script> 
                                             window.onload=function(){
                                           
                                                 document.forms["miformularioE"].submit();
                                             }
                                        </script>
                                         
                                        <form name="miformularioE" action="../../cargos" method="POST" onsubmit="procesar(this.action);" >
                                            <input type="hidden" name="validacionExisteImportacionE" value="1">
                                        </form> 
                                <?php
                        }
                        
                        if($nombreCargoRepetido == FALSE){ 
                           
                            ?>
                                        <script> 
                                             window.onload=function(){
                                           
                                                 document.forms["miformularioB"].submit();
                                             }
                                        </script>
                                         
                                        <form name="miformularioB" action="../../cargos" method="POST" onsubmit="procesar(this.action);" >
                                            <input type="hidden" name="validacionExisteImportacionB" value="1">
                                            <input type="hidden" name="enviarCargoExistenteBDRegistro" value="<?php echo $enviarCargoExistenteBDRegistro;?>">
                                        </form> 
                            <?php
                        }
                        
                        if($nombreInmediato == FALSE){ 
                         
                            ?>
                                        <script> 
                                             window.onload=function(){
                                           //alert("Debe alertar");
                                                 document.forms["miformularioC"].submit();
                                             }
                                        </script>
                                         
                                        <form name="miformularioC" action="../../cargos" method="POST" onsubmit="procesar(this.action);" >
                                            <input type="hidden" name="validacionExisteImportacionC" value="1">
                                            <input type="hidden" name="EnviarvalidacionExisteImportacionC" value="<?php echo $string_jefe_inmediato;?>">
                                        </form> 
                            <?php
                        }
                        
                        if($nombreCargoRe == FALSE){  
                            ?>
                                        <script> 
                                             window.onload=function(){
                                                //alert("No debe entrar acá");
                                                 document.forms["miformularioD"].submit();
                                             }
                                        </script>
                                         
                                        <form name="miformularioD" action="../../cargos" method="POST" onsubmit="procesar(this.action);" >
                                            <input type="hidden" name="validacionExisteImportacionD" value="1">
                                        </form> 
                            <?php
                        }
                        
                        $type = "error";
                        $message = "ERROR";
                        
                        
                    } else{ 
                        if($contandoNivelesCargar > 0){
                             'alerta<br>'; 
                            ?>
                                        <script> 
                                             window.onload=function(){
                                             //alert("Esta alerta es cuando no existe, pero no debe entrar acá si viene vacio");
                                                 document.forms["miformularioD"].submit();
                                             }
                                        </script>
                                         
                                        <form name="miformularioD" action="../../cargos" method="POST" onsubmit="procesar(this.action);" >
                                            <input type="hidden" name="validacionExisteImportacionD" value="1">
                                        </form> 
                            <?php
                        }else{
                            
                            
                                //echo 'Registro';
    				       
                                $query = "insert into cargos(nombreCargos,descripcionCargos,jefeInmediatoCargos,nivelCargo) values('$nombre','$descripcion','$jefeInmediato','$nivelCargo')";
                                $resultados = mysqli_query($con, $query);
                               
                               
                                ?>
                                    <script> 
                                         window.onload=function(){
                                            
                                            document.forms["miformulario"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformulario" action="../../cargos" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionAgregarA" value="1">
                                    </form> 
                                <?php
                            
                                if (! empty($resultados)) {
                                    $type = "success";
                                    //$message = "Excel importado correctamente";
                                } else {
                                    $type = "error";
                                    //$message = "Hubo un problema al importar registros";
                                }
                            
                      
                        }
                    } 
                    
                    
                    
                    
                }
                
                
                
    				} // evitamos subir un documento diferente
                
             }
        
         }
        }
  }
  else
  { 
        $type = "error";
        $message = "El archivo enviado es invalido. Por favor vuelva a intentarlo";
  }
}


if($enviarVariableAlerta == '1'){ /// esta alerta debe activarse con todas las columnas
  //echo 'validaci´pon alerta';
    //// agregamos todas las variables enviadas por columna
    if($enviarNombreString != NULL || $enviarNombreStringL != NULL){ 
        if($tipoValidacionNombre == '1'){ 
            $almacenajeAlertaCaracter='en la celda '.($enviarNombreString+1);
            $almacenajeAlertaCaracterTipo='celdaNombre';
        }
        if($tipoValidacionNombre == '2'){ 
            if($enter_encontrado_nombre == '1'){ /// identificamos la alerta activa
                $enter_encontrado='1';
                $titulo='El cargo';
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
    
    if($enviarJefeInmediatoString != NULL || $enviarJefeInmediatoStringL != NULL){ 
        if($tipoValidacionJefeInmediato == '1'){ 
            $almacenajeAlertaCaracter='en la celda '.($enviarJefeInmediatoString+1);
            $almacenajeAlertaCaracterTipo='celdaJefeInmediato';
        }
        if($tipoValidacionJefeInmediato == '2'){ 
            if($enter_encontrado_jefe_inmediato == '1'){ /// identificamos la alerta activa
                $enter_encontrado='1';
                $titulo='El jefe inmediato';
                $almacenajeAlertaCaracterCelda=$enviarJefeInmediatoStringL+1;
                $almacenajeAlertaCaracterTipo='caracterJefeInmediato';
            }else{
                $almacenajeAlertaCaracter=$enviarJefeInmediatoStringL;
                $almacenajeAlertaCaracterTipo='caracterJefeInmediato';
            }
        }
        
    }
    
    if($enviarNivelCargoString != NULL || $enviarNivelCargoStringL != NULL){ 
        if($tipoValidacionNivelCargo == '1'){ 
            $almacenajeAlertaCaracter='en la celda '.($enviarNivelCargoString+1);
            $almacenajeAlertaCaracterTipo='celdaNivelCargo';
        }
        if($tipoValidacionNivelCargo == '2'){ 
            if($enter_encontrado_nivel_cargo == '1'){ /// identificamos la alerta activa
                $enter_encontrado='1';
                $titulo='El nivel de cargo';
                $almacenajeAlertaCaracterCelda=$enviarNivelCargoStringL+1;
                $almacenajeAlertaCaracterTipo='caracterNivelCargo';
            }else{
                $almacenajeAlertaCaracter=$enviarNivelCargoStringL;
                $almacenajeAlertaCaracterTipo='caracterNivelCargo';
            }
        }
        
    }
    
    
    
   
    ?>
                            <script> 
                                 window.onload=function(){
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../cargos" method="POST" onsubmit="procesar(this.action);" >
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

    if(!empty($type)) {
        
        
         $type . " display-block"; 
        
    } 
    
    
     
    ?>
    
                                                                    