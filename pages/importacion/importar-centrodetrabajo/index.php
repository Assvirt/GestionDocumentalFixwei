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
                     
                     /// volvemos el texto totalmente en minuscula
                                  $nombre=mb_strtolower($nombre);
                                 '<br>';
                                
                                // eliminamos los acentos
                                 $nombre=eliminar_acentos_nombre($nombre);
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
                       
                    
                    $validacion2 = $con->query("SELECT * FROM centrodetrabajo WHERE nombreCentrodeTrabajo = '$nombre' ")or die(mysqli_error());
                    $num2 = mysqli_num_rows($validacion2);
                    
                    if($num2 > 0){
                        //si el nombre está repetido se pone falso 
                        $nombreRepetido = FALSE;
                    }
                    
                    if($nombre == ""){
                        $campoNull = FALSE;
                        $mensajeCampoVacio='en la columna nombre';
                    }else{
                        array_push($arrayNombres,$nombre);
                    }
                    
                }
                
                
                $prefijo = "";
                if(isset($Row[1])) {
                    $prefijo = mysqli_real_escape_string($con,$Row[1]);
                     $prefijo=trim($prefijo);
                     
                     /// volvemos el texto totalmente en minuscula
                                  $prefijo=mb_strtolower($prefijo);
                                 '<br>';
                                
                                // eliminamos los acentos
                                 $prefijo=eliminar_acentos_prefijo($prefijo);
                                 '<br>';
                     
                     
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
                                
                                
                        $asociadosS=trim($asociados); echo '<br>';
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
                            }else{
                              //echo "No hay repetidos";
                            }
                        /// end
                        
                        $longitud = count($array);
                        
                        for($i=0; $i<$longitud; $i++){
                           
                        $extraeID = $con->query("SELECT id_cargos FROM cargos WHERE nombreCargos = '$array[$i]'");  
                        $rowIdDueno = $extraeID->fetch_array(MYSQLI_ASSOC);
                         $duenoValidado = '['.json_encode($rowIdDueno['id_cargos']).']';
                         '<br>';
                        $asociadoss=json_encode($rowIdDueno['id_cargos']).',';
                        
                            if($duenoValidado == '[null]' || $duenoValidado == 'null'  || $duenoValidado == 'null,'){
                                $asociadosExiste=FALSE;
                                
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
                    
                    if($repiteNombre == FALSE || $repiteCargoAsociado == FALSE || $repitePrefijo == FALSE || $prefijoRepetido == FALSE || $nombreRepetido == FALSE || $asociadosExiste == FALSE || $campoNull == FALSE){
                        
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
                        
                        ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformularioRepetido"].submit();
                                 }
                            </script>
                             
                            <form name="miformularioRepetido" action="../../centrodetrabajo" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionExisteImportacionRepiteAsociado" value="1">
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
                        
                        if($asociadosExiste == FALSE){
                            
                       
                        ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../centrodetrabajo" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionExisteImportacionF" value="1">
                            </form> 
                        <?php
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
                        
                            $query = "insert into centrodetrabajo(prefijoCentrodeTrabajo,nombreCentrodeTrabajo,cargosAsociadoss,estilo) values('$prefijo','$nombre','$asociadoss','0')";
                            $resultados = mysqli_query($con, $query)or die(mysqli_error());
                           
                            ?>
                                <script> 
                                     window.onload=function(){
                                   
                                         document.forms["miformulario"].submit();
                                     }
                                </script>
                                 
                                <form name="miformulario" action="../../centrodetrabajo" method="POST" onsubmit="procesar(this.action);" >
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
    
    
       /* if(!empty($message)) { 
            
          ?>  
                                                                    <script>
                                                                        window.onload=function(){
                                                                      
                                                                          document.forms["miformulario"].submit();
                                                                        }
                                                                        </script>
                                                                    
                                                                    <form name="miformulario" action="../../centrodetrabajo" method="POST" onsubmit="procesar(this.action);" >
                                                                        <input style="visibility:hidden" readonly type="text" name="mensaje" value="<?php echo $message; ?>">
                                                                        
                                                                        
                                                                    </form>
             <?php 
        
            }*/ 
    ?>
    
                                                                    