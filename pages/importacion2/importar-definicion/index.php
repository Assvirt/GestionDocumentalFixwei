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
        
        $sheetCount = count($Reader->sheets());
        
        $nombreDefinicion = TRUE;
        
        $campoNull = TRUE;
        $arrayNombre = array();
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
                            	
                            	
                            	 function eliminar_acentosDefinicion($definicion){
		
                            		//Reemplazamos la A y a
                            		$definicion = str_replace(
                            		array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
                            		array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
                            		$definicion
                            		);
                            
                            		//Reemplazamos la E y e
                            		$definicion = str_replace(
                            		array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
                            		array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
                            		$definicion );
                            
                            		//Reemplazamos la I y i
                            		$definicion = str_replace(
                            		array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
                            		array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
                            		$definicion );
                            
                            		//Reemplazamos la O y o
                            		$definicion = str_replace(
                            		array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
                            		array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
                            		$definicion );
                            
                            		//Reemplazamos la U y u
                            		$definicion = str_replace(
                            		array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
                            		array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
                            		$definicion );
                            
                            		//Reemplazamos la N, n, C y c
                            		$definicion = str_replace(
                            		array('Ñ', 'ñ', 'Ç', 'ç','"'),
                            		array('N', 'n', 'C', 'c',''),
                            		$definicion
                            		);
                            		
                            		//Reemplazamos ;; por ;
                            		$definicion = str_replace(
                            		array(';;',';;;'),
                            		array(';',';'),
                            		$definicion
                            		);
                            		
                            		return $definicion;
                            	}
        // se declaran variables para el mensaje de caracteres
        $activarAlerta=TRUE;
        $enviarNombreString='';
        $enviarDescripcionString='';
        $activarAlertaEnter=TRUE; ///  variable declarada para el mensaje con campo enter
        
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
            $contador='0';
            foreach ($Reader as $Row)
            {
                $contador++;
          
                if($Row[2]=='Fuente'){ continue;} //Aca remplazo por el nombre y posicion de la ultima columna de excel para que no me agrege la primera fila.
          
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
                            $permitidosNombre = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ0123456789 ";
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
                    
                    $validacion1 = $con->query("SELECT * FROM definicion WHERE nombre = '$nombre' ");
                    $num = mysqli_num_rows($validacion1);
                    
                    if($num > 0){ //echo 'existe';
                        //si el nombre está repetido se pone falso 
                        $nombreDefinicion = FALSE;
                        $enviarNombreDefinicionAlerta.=$nombre.', ';
                    }
                    
                    if($nombre == ""){
                        $campoNull = FALSE;
                        $mensajeCampoVacio='en la columna nombre';
                    }else{
                        array_push($arrayNombre,$nombre);
                        //continue;
                    }
                }
                
                $definicion = "";
                if(isset($Row[1])) {
                    $definicion = mysqli_real_escape_string($con,$Row[1]);
                     $definicion=trim($definicion);
                     $contadorCeldaDescripcion++;
                     
                    if($definicion == ""){
                        $campoNull = FALSE;
                        $mensajeCampoVacio='en la columna definición';
                    }else{
                        /// volvemos el texto totalmente en minuscula
                                  $definicion=mb_strtolower($definicion);
                                 '<br>';
                                
                        /// volvemos el texto totalmente en minuscula
                                  $definicion=mb_strtolower($definicion);
                                 '<br>';
                        
                        // eliminamos los acentos
                                 $definicion=eliminar_acentosDefinicion($definicion);
                                 '<br>';
                        
                        
                        
                                 
                        //compruebo que los caracteres sean los permitidos
                        $descripcion_carecteres=['"'];
                        /*for($bc=0; $bc<count($descripcion_carecteres); $bc++){
                            $descripcion_carecteres[$bc]; 
                             $cadena_carecteres_descripcion = $descripcion_carecteres[$bc];
                             ' - '.$coincidencia_caracteres= strpos($definicion, $cadena_carecteres_descripcion);
                            if($coincidencia_caracteres != NULL){
                                $activarAlerta=FALSE;
                                $enviarDescripcionString.=$contadorCeldaDescripcion.', ';
                                $tipoValidacionDescripcion='1';
                            }
                             '<br>';
                        }*/
                        
                        if($tipoValidacionDescripcion == '1'){
                            
                        }else{
                            /*$permitidosdescripcion = 'áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789,.?ñ;:"() ';
                               for ($i=0; $i<strlen($definicion); $i++){
                                  if (strpos($permitidosdescripcion, substr($definicion,$i,1))===false){
                                     $definicion . " no es válido<br>";
                                     $activarAlerta=FALSE;
                                     $tipoValidacionDescripcion='2';
                                     $enviarDescripcionStringL=$definicion;
                                     //return false;
                                  }
                               }*/
                               $descripcion_carecteres=["'"];
                                for($bc=0; $bc<count($descripcion_carecteres); $bc++){
                                    $descripcion_carecteres[$bc]; 
                                     $cadena_carecteres_descripcion = $descripcion_carecteres[$bc];
                                     ' - '.$coincidencia_caracteres= strpos($definicion, $cadena_carecteres_descripcion);
                                    if($coincidencia_caracteres != NULL){
                                        $activarAlerta=FALSE;
                                        //$enviarDescripcionString.=$contadorCeldaDescripcion.', ';
                                        $enviarDescripcionStringL=$definicion.', ';
                                        $tipoValidacionDescripcion='2';
                                    }
                                     '<br>';
                                }
                                /*
                                $descripcion_carecteres_frances=["‘’"];
                                for($bcFrances=0; $bcFrances<count($descripcion_carecteres_frances); $bcFrances++){
                                    $descripcion_carecteres_frances[$bcFrances]; 
                                     $cadena_carecteres_descripcionFrances = $descripcion_carecteres_frances[$bcFrances];
                                     ' - '.$coincidencia_caracteresFrances= strpos($definicion, $cadena_carecteres_descripcionFrances);
                                    if($coincidencia_caracteresFrances != NULL){
                                        $activarAlerta=FALSE;
                                        //$enviarDescripcionString.=$contadorCeldaDescripcion.', ';
                                        $enviarDescripcionStringL=$definicion.', ';
                                        $tipoValidacionDescripcion='2';
                                    }
                                     '<br>';
                                }
                                */
                        }
                        //// end
                    }
                }
                
                $link = "";
                if(isset($Row[2])) {
                    $link = mysqli_real_escape_string($con,$Row[2]);
                    $link=trim($link);
                    if($link == ""){
                        //$campoNull = FALSE;
                    }
                }
                
                
                
                $validarArchivo = "";
                if(isset($Row[3])) {
                    $validarArchivo = mysqli_real_escape_string($con,$Row[2]);
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
                                         
                                        <form name="miformularioV" action="../../definicion" method="POST" onsubmit="procesar(this.action);" >
                                            <input type="hidden" name="mensajeEnviarCampoVacio" value="<?php echo $mensajeCampoVacio;?>">
                                            <input type="hidden" name="validacionExisteImportacionVacio" value="1">
                                        </form> 
                                <?php
            }
            // END
        
        
         }
         
         
         
                    if(count($arrayNombre) > count(array_unique($arrayNombre))){//Valido si hay seriales repetidos
                      $repiteNombre = FALSE;
                    }
         
         
         
         for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
            
            foreach ($Reader as $Row)
            {
          
                if($Row[2]=='Fuente'){ continue;} //Aca remplazo por el nombre y posicion de la ultima columna de excel para que no me agrege la primera fila.
          
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
                
                $definicion = "";
                if(isset($Row[1])) {
                    $definicion = mysqli_real_escape_string($con,$Row[1]);
                     $definicion=trim($definicion);
                }
                
                $link = "";
                if(isset($Row[2])) {
                    $link = mysqli_real_escape_string($con,$Row[2]);
                    $link=trim($link);
                }
                
                
                
                $validarArchivo = "";
                if(isset($Row[3])) {
                    $validarArchivo = mysqli_real_escape_string($con,$Row[2]);
                }
                
				if($validarArchivo != NULL){ // evitamos subir un archivo diferente
                
                //echo '<script language="javascript">alert("Está intentando subir un archivo diferente");
                            //window.location.href="../../definicion"</script>';
                            ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformulario"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformulario" action="../../definicion" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionExisteImportacion" value="1">
                                    </form> 
                            <?php
				}else{
				
                
                
                if (!empty($nombre) ||  !empty($definicion) ||  !empty($link)  ) { 
                    
                    if($activarAlerta == FALSE || $nombreDefinicion == FALSE || $repiteNombre == FALSE || $campoNull == FALSE){
                        if($activarAlerta == FALSE){ 
                            $enviarVariableAlerta=1;
                        }
                        
                        if($campoNull == FALSE){
                         //echo '<script language="javascript">alert("Algunos nombres están repetidos en el documento ");
                            //window.location.href="../../definicion"</script>';
                            ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformulario"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformulario" action="../../definicion" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="mensajeEnviarCampoVacio" value="<?php echo $mensajeCampoVacio;?>">
                                        <input type="hidden" name="validacionExisteImportacionVacio" value="1">
                                    </form> 
                            <?php
                        }
                        
                        if($nombreDefinicion == FALSE){
                        $alertaEnviarDefinicion=1;
                            
                        }

                        if($repiteNombre == FALSE){
                            //echo '<script language="javascript">alert("Algunos nombres están repetidos en el documento ");
                               //window.location.href="../../definicion"</script>';
                               ?>
                                       <script> 
                                            window.onload=function(){
                                          
                                                document.forms["miformulario"].submit();
                                            }
                                       </script>
                                        
                                       <form name="miformulario" action="../../definicion" method="POST" onsubmit="procesar(this.action);" >
                                           <input type="hidden" name="validacionExisteImportacionB" value="1">
                                       </form> 
                               <?php
                           }
                        
                        $type = "error";
                        $message = "ERROR";
                        
                    }else{
                        
                        
                      
                        
                        
                        //$cadena="En un  lugar de la mancha";
                        $nombre =str_replace('  ', ' ', $nombre);
                       
                        /// eliminamos las comillas francesas
                        $definicion=str_replace("‘’","",$definicion);
                         
                        /// eliminamos las comillas francesas
                        $link=str_replace("‘’","",$link);
                        
                        
                        if(is_numeric($nombre)){ 
                            //echo 'Imprimer numero: '.$nombre.'<br>';
                         
                            $query = "insert into definicion(nombreN,definicion,fuente)
                            values('".$nombre."','".$definicion."','".$link."')";
                            $resultados = mysqli_query($con, $query); 
                            
                        }
                        
                        if($nombre <> is_numeric($nombre)){  
                            
                            
                            //echo 'Imprimer dato: '.$nombre.'<br>';
                            
                            $query = "insert into definicion(nombre,definicion,fuente)
                            values('".$nombre."','".$definicion."','".$link."')";
                            $resultados = mysqli_query($con, $query); 
                            
                        }
                        
                        ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../definicion" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionAgregar" value="1">
                            </form> 
                        <?php
                    
                    
                
                           
                            
                    }        
                }
				} /// evita subir archivo incorrecto
             }
        
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
    
    
if($alertaEnviarDefinicion == '1'){
    ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformulario"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformulario" action="../../definicion" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionExiste" value="1">
                                        <input type="hidden" name="MensajevalidacionExiste" value="<?php echo $enviarNombreDefinicionAlerta;?>">
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
    if($enviarDescripcionString != NULL || $enviarDescripcionStringL != NULL){ 
        if($tipoValidacionDescripcion == '1'){ 
            $almacenajeAlertaCaracter='en la celda '.($enviarDescripcionString+1);
            $almacenajeAlertaCaracterTipo='celdaDescripcion';
        }
        if($tipoValidacionDescripcion == '2'){ 
            $almacenajeAlertaCaracter=$enviarDescripcionStringL;
            $almacenajeAlertaCaracterTipo='caracterDescripcion';
        }
        
    }
        
    
    
   
    
    
    
   
    ?>
                            <script> 
                                 window.onload=function(){
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../definicion" method="POST" onsubmit="procesar(this.action);" >
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
    
                                                                    