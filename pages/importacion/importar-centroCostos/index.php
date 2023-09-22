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
                    
                     /// volvemos el texto totalmente en minuscula
                                  $codigo=mb_strtolower($codigo);
                                 '<br>';
                                
                                // eliminamos los acentos
                                 $codigo=eliminar_acentos_codigo($codigo);
                                 '<br>';
                        
                         
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
                   
                    /// volvemos el texto totalmente en minuscula
                                  $prefijo=mb_strtolower($prefijo);
                                 '<br>';
                                
                                // eliminamos los acentos
                                 $prefijo=eliminar_acentos_prefijo($prefijo);
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
                   
                   
                    $validacionPrefijo = $con->query("SELECT * FROM centroCostos WHERE prefijo ='$prefijo'")or die(mysqli_error());
                     'Conteo: '.$numPrefijo = mysqli_num_rows($validacionPrefijo); 
                    
                    if($numPrefijo > 0){
                        $prefijoExiste=FALSE;
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
                    
                    /// volvemos el texto totalmente en minuscula
                                  $nombre=mb_strtolower($nombre);
                                 '<br>';
                                
                                // eliminamos los acentos
                                 $nombre=eliminar_acentos_nombre($nombre);
                                 '<br>';
                    
                    if($nombre == ""){
                        $campoNull = FALSE; 
                        $mensajeCampoVacio='en la columna nombre';
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
                        }else{
                             array_push($arrayNombre,$nombre);
                        }
                    }
                    
                    
                }
                    
                     
                $cargo = "";
                if(isset($Row[3])) {
                    $cargo = mysqli_real_escape_string($con,$Row[3]);
                     $cargo=trim($cargo);
                    if($cargo == ""){
                        $campoNull = FALSE; 
                        $mensajeCampoVacio='en la columna cargo';
                    }
                }
                
                $cTrabajo = "";
                if(isset($Row[4])) {
                    $cTrabajo = mysqli_real_escape_string($con,$Row[4]);
                    $cTrabajo=trim($cTrabajo);
                    
                    if($cTrabajo == ""){
                        $campoNull = FALSE;
                        $mensajeCampoVacio='en la columna centro de trabajo';
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
                    if($personaV == ""){
                        $campoNull = FALSE; 
                        $mensajeCampoVacio='en la columna persona responsable';
                    }else{
                        $contadorRegistros++;  //// verificamos que las cantidades que entran y salgan sean iguales  
                        $extraeID = $con->query("SELECT * FROM usuario WHERE cedula = '$personaV'")or die(mysqli_error());  
                        $rowId = $extraeID->fetch_array(MYSQLI_ASSOC);
                        $idPersona = $rowId['id'];
                        'contador: '.$idPersonaConteo= mysqli_num_rows($extraeID);
                         
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
				    
				    
                    if($repiteNombreDocumento == FALSE || $codigoExiste == FALSE || $numerico == FALSE || $repiteNombre == FALSE || $prefijoExiste == FALSE || $repitePrefijo == FALSE || $repiteCodigo == FALSE ||  $cargoExiste == FALSE || $trabajoExiste == FALSE || $campoNullPrefijo == FALSE || $campoNull == FALSE){
                        //$codigoRepetido == FALSE || -- $codigoRepetido
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
                             ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformularioPersona"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformularioPersona" action="../../centroCostos" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionExisteImportacionNumerico" value="1">
                                    </form> 
                            <?php 
                        } 
                        
                        
                        if($codigoExiste == FALSE){ 
                            
                            ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformularioPrefijoExiste"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformularioPrefijoExiste" action="../../centroCostos" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionExisteC" value="1">
                                    </form> 
                            <?php
                         } 
                         
                         if($prefijoExiste == FALSE){ 
                            
                            ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformularioPrefijoExiste"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformularioPrefijoExiste" action="../../centroCostos" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionExisteD" value="1">
                                    </form> 
                            <?php
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
                            ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformularioCargoExistente"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformularioCargoExistente" action="../../centroCostos" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionExisteImportacionC1" value="1">
                                    </form> 
                            <?php
                         } 
                         
                         if($trabajoExiste == FALSE){ 
                            ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformularioTrabajoExiste"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformularioTrabajoExiste" action="../../centroCostos" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionExisteImportacionC2" value="1">
                                    </form> 
                            <?php
                         } 
                         
                         if($repiteNombre == FALSE){ 
                            ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformularionombreExiste"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformularionombreExiste" action="../../centroCostos" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionExisteNombre" value="1"> <!-- validacionExisteImportacionC2 -->
                                    </form> 
                            <?php
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
                         
                         
                        
                        
                        
                      
                       
                        
                        
                    }else{
                        
                        
                        
                    if($variableNoRegistrar == 1){    
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
                            <input type="hidden" name="validacionExisteImportacionNumerico" value="1">
                        </form> 
                        <noscript>Mensaje de eventos</noscript>
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




    
    
}   
?>