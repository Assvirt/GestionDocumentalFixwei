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
                            		array('N', 'n', 'C', 'c'),
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
                    
                     /// volvemos el texto totalmente en minuscula
                                  $nombre=mb_strtolower($nombre);
                                 '<br>';
                                
                                // eliminamos los acentos
                                 $nombre=eliminar_acentosNombre($nombre);
                                 '<br>';
                    
                    
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
                        $mensajeCampoVacio='en la columna nombre';
                    }else{
                        array_push($arrayNombres,$nombre);
                    }
                    
                }
                
                $descripcion = "";
                if(isset($Row[1])) {
                    $descripcion = mysqli_real_escape_string($con,$Row[1]);
                    if($descripcion == ""){
                        $campoNull = FALSE;
                        $mensajeCampoVacio='en la columna descripción';
                    }
                }
                
                $dueno = "";
                if(isset($Row[2])) {
                    $dueno = mysqli_real_escape_string($con,$Row[2]);
                     $dueno=trim($dueno);
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
                    if($macroproceso == ""){
                        $campoNull = FALSE;
                        $mensajeCampoVacio='en la columna macroproceso';
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
                            
                            if($numMacroPro < 1){
                                $macroProcesoMensaje = FALSE;    
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
                    
                        if($repiteDuenoProceso == FALSE || $macroProcesoMensaje == FALSE || $repitePrefijoArray == FALSE || $repiteNombre == FALSE || $repiteNombreProceso == FALSE || $duenoProcesoExiste == FALSE || $repitePrefijo == FALSE || $macroProceso == FALSE || $campoNull == FALSE){
                            
                            
                          
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
                            ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                            document.forms["miformularioRepiteDuenoPr"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformularioRepiteDuenoPr" action="../../procesos" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionRepiteDuenoProceso" value="1">
                                    </form> 
                                <?php   
                           }
                           
                           if($macroProcesoMensaje == FALSE){
                                ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                            document.forms["miformulario"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformulario" action="../../procesos" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionExisteImportacionBMacro" value="1">
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
                                
                                ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformulario"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformulario" action="../../procesos" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionExisteImportacionE" value="1">
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
                         
                       
                       
                         'registro<br>';
                       
                        
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



     
    
    
        
    ?>
    
                                                                    