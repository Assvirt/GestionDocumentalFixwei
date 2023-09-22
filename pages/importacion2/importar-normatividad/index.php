<?php error_reporting(E_ERROR); error_reporting(0);
//IMPORTAR NORMATIVIDAD
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
        $abreviatura = TRUE;
        $descripcion = TRUE;
        
        $campoNull = TRUE;
        $arrayNombre = array();
        $repiteNombre = TRUE;
         ?>
         
         <script> 
                                             window.onload=function(){
                                           
                                                document.forms["miformularioV"].submit();
                                             }
                                        </script>
                                         
                                        <form name="miformularioV" action="../../normatividad" method="POST" onsubmit="procesar(this.action);" >
                                            <input type="hidden" name="mensajeEnviarCampoVacio" value="<?php echo $mensajeCampoVacio;?>">
                                            <input type="hidden" name="validacionExisteImportacionVacio" value="1">
                                        </form> 
         <?php
        
        
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
        
        // se declaran variables para el mensaje de caracteres
        $activarAlerta=TRUE;
        $enviarNombreString='';
        $enviarAbreviaturaString='';
        $enviarDescripcionString='';
        $activarAlertaEnter=TRUE; ///  variable declarada para el mensaje con campo enter
        
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
            $contador=0;
            foreach ($Reader as $Row)
            {
                
                $contador++;
                if($Row[2]=='Descripcion'){ continue;} //Aca remplazo por el nombre y posicion de la ultima columna de excel para que no me agrege la primera fila.
                
                
                
                $nombre = "";
                if(isset($Row[0])) {
                    $nombre = mysqli_real_escape_string($con,$Row[0]);
                    $nombre=trim($nombre);
                    $contadorCeldaNombre++;
                    $buscandoEnterNombre++;
                    
                    if($nombre == ""){
                        $campoNull = FALSE;
                        $mensajeCampoVacio='en la columna nombre';
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
                          
                        $validacion1 = $con->query("SELECT * FROM normatividad WHERE nombre =  '$nombre'");
                        $num3 = mysqli_num_rows($validacion1);
                        
                        if($num3 > 0){
                            //si el nombre está repetido se pone falso 
                            $nombreDefinicion = FALSE;
                            $enviarNombreExistente.=$nombre.', ';
                        }
    
                        if($nombre == ""){
                            $campoNull = FALSE;
                            $mensajeCampoVacio='en la columna nombre';
                        }else{
                            array_push($arrayNombre,$nombre);
                        }
                    }
                }
                
                $abreviatura = "";
                if(isset($Row[1])) {
                    $abreviatura = mysqli_real_escape_string($con,$Row[1]);
                    $abreviatura=trim($abreviatura);
                    $contadorCeldaAbreviatura++;
                    $buscandoEnterAbreviatura++;
                    
                    if($abreviatura == ""){
                        $campoNull = FALSE;
                        $mensajeCampoVacio='en la columna abreviatura';
                    }else{
                        
                         /// volvemos el texto totalmente en minuscula
                                  $abreviatura=mb_strtolower($abreviatura);
                                 '<br>';
                        
                        //compruebo que los caracteres sean los permitidos
                        $abreviatura_carecteres=['"'];
                        for($bc=0; $bc<count($abreviatura_carecteres); $bc++){
                            $abreviatura_carecteres[$bc]; 
                             $cadena_carecteres_abreviatura = $abreviatura_carecteres[$bc];
                             ' - '.$coincidencia_caracteres= strpos($abreviatura, $cadena_carecteres_abreviatura);
                            if($coincidencia_caracteres != NULL){
                                $activarAlerta=FALSE;
                                $enviarAbreviaturaString.=$contadorCeldaAbreviatura.', ';
                                $tipoValidacionAbreviatura='1';
                            }
                             '<br>';
                        }
                        
                        if($tipoValidacionAbreviatura == '1'){
                            
                        }else{
                            $permitidosAbreviatura = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZñ0123456789 ";
                               for ($i=0; $i<strlen($abreviatura); $i++){
                                  if (strpos($permitidosAbreviatura, substr($abreviatura,$i,1))===false){
                                     $abreviatura . " no es válido<br>";
                                     $activarAlerta=FALSE;
                                     $tipoValidacionAbreviatura='2';
                                     $enviarAbreviaturaStringL=$abreviatura;
                                     //return false;
                                  }
                               }
                               //// validamos el enter antes de enviar la alerta
                                        $cadena_buscada_abreviatura = '\n';
                                        $posicion_coincidencia_abreviatura = strpos($abreviatura, $cadena_buscada_abreviatura);
                                        if($posicion_coincidencia_abreviatura === false){
                                            //echo 'si';
                                        }else{
                                            //echo 'no';
                                          $activarAlertaEnter=FALSE;
                                          $enviarResponsableStringLCAbreviatura=$buscandoEnterAbreviatura.',';
                                        }
                                    
                                        if($activarAlertaEnter == FALSE){ /// activamos la alerta del mensaje del enter
                                            //echo 'enter encontrado en abrev';
                                            $enter_encontrado_abreviatura='1';
                                            $enviarAbreviaturaStringL=$enviarResponsableStringLCAbreviatura;
                                        }else{
                                            $enviarAbreviaturaStringL;
                                        }
                                        
                                    /// end
                        }
                        //// end
                    }
                }
                
                $descripcion = "";
                if(isset($Row[2])) {
                    $descripcion = mysqli_real_escape_string($con,$Row[2]);
                    $descripcion=trim($descripcion);
                    $contadorCeldaDescripcion++;
                    
                    if($descripcion == ""){
                        $campoNull = FALSE;
                        $mensajeCampoVacio='en la columna descripción';
                    }else{
                        
                         /// volvemos el texto totalmente en minuscula
                                  $descripcion=mb_strtolower($descripcion);
                                 '<br>';
                        
                        //compruebo que los caracteres sean los permitidos
                        /*$descripcion_carecteres=['"'];
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
                        }*/
                        
                        if($tipoValidacionDescripcion == '1'){
                            
                        }else{
                            /*$permitidosdescripcion = "áéíóúabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789ñ ";
                               for ($i=0; $i<strlen($descripcion); $i++){
                                  if (strpos($permitidosdescripcion, substr($descripcion,$i,1))===false){
                                     $descripcion . " no es válido<br>";
                                     $activarAlerta=FALSE;
                                     $tipoValidacionDescripcion='2';
                                     $enviarDescripcionStringL=$descripcion;
                                     //return false;
                                  }
                               }
                               */
                               $descripcion_carecteres=["'"];
                                for($bc=0; $bc<count($descripcion_carecteres); $bc++){
                                    $descripcion_carecteres[$bc]; 
                                     $cadena_carecteres_descripcion = $descripcion_carecteres[$bc];
                                     ' - '.$coincidencia_caracteres= strpos($descripcion, $cadena_carecteres_descripcion);
                                    if($coincidencia_caracteres != NULL){
                                        $activarAlerta=FALSE;
                                        //$enviarDescripcionString.=$contadorCeldaDescripcion.', ';
                                        $enviarDescripcionStringL=$descripcion.', ';
                                        $tipoValidacionDescripcion='2';
                                    }
                                     '<br>';
                                }
                        }
                        //// end
                    }
                }
                
                 if($contador == 1){
                     
                ?>
                                        <script> 
                                             window.onload=function(){
                                           
                                                document.forms["miformularioV"].submit();
                                             }
                                        </script>
                                         
                                        <form name="miformularioV" action="../../normatividad" method="POST" onsubmit="procesar(this.action);" >
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
                        
                       if($Row[2]=='Descripcion'){ continue;}
                
               if(isset($Row[0])) {
                    $nombre = mysqli_real_escape_string($con,$Row[0]);
                    $nombre=trim($nombre);
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
               }
               
               if(isset($Row[1])) {
                    $abreviatura = mysqli_real_escape_string($con,$Row[1]);
                    $abreviatura=trim($abreviatura);
               }
               
               if(isset($Row[2])) {
                    $descripcion = mysqli_real_escape_string($con,$Row[2]);
                    $descripcion=trim($descripcion);
               }
               if($validarArchivo != NULL){ // evitamos subir un archivo diferente
                
                
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
               
               
                if (!empty($nombre) ||  !empty($abreviatura) ||  !empty($descripcion)  ) { 
                        
                    if($activarAlerta == FALSE || $nombreDefinicion == FALSE ||  $repiteNombre == FALSE || $campoNull == FALSE){  
                       
                        if($activarAlerta == FALSE){ 
                            $enviarVariableAlerta=1;
                        }
                        
                        if($campoNull == FALSE){
                            
                         ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformularioVacio"].submit();
                                 }
                            </script>
                             
                            <form name="miformularioVacio" action="../../normatividad" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="mensajeEnviarCampoVacio" value="<?php echo $mensajeCampoVacio;?>">
                                <input type="hidden" name="validacionExisteImportacionVacio" value="1">
                            </form> 
                        <?php
                        }
                        
                        if($nombreDefinicion == FALSE){ 
                        $activarNombreExiste=1;
                        }
                        
                        if($repiteNombre == FALSE ){  
                           
                            ?>
                               
                               
                              <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformularioRepetir"].submit();
                                 }
                            </script>
                             
                            <form name="miformularioRepetir" action="../../normatividad" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionExisteImportacion" value="1">
                            </form>  
                           <?php
                           }
                    }else{
                        $type = "error";
                        $message = "ERROR";
                        
                    
                    /// eliminamos las comillas francesas
                    $descripcion=str_replace("‘’","",$descripcion);
                  
                    $query = "insert into normatividad(nombre,abreviatura,descripcion)
                    values('".$nombre."','".$abreviatura."','".$descripcion."')";
                    $resultados = mysqli_query($con, $query);
                        ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../normatividad" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionAgregar" value="1">
                            </form> 
                        <?php
                          
                            
                    }        
                }

            
         }
   
        $type = "error";
        $message = "El archivo enviado es invalido. Por favor vuelva a intentarlo";
        
  }




    if(!empty($type)) {

         $type . " display-block"; 

        } 
    }
}    
  }
}
 
 
 
if($activarNombreExiste == '1'){
   ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../normatividad" method="POST" onsubmit="procesar(this.action);" >
                                <input name="mensajeAlertaNombreExiste" value="<?php echo $enviarNombreExistente;?>" type="hidden">
                                <input type="hidden" name="validacionExiste" value="1">
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
    
    if($enviarAbreviaturaString != NULL || $enviarAbreviaturaStringL != NULL){ 
        if($tipoValidacionAbreviatura == '1'){ 
            $almacenajeAlertaCaracter='en la celda '.($enviarAbreviaturaString+1);
            $almacenajeAlertaCaracterTipo='celdaAbreviatura';
        }
        if($tipoValidacionAbreviatura == '2'){ 
            if($enter_encontrado_abreviatura == '1'){ /// identificamos la alerta activa
                $enter_encontrado='1';
                $titulo='La abreviatura';
                $almacenajeAlertaCaracterCelda=$enviarAbreviaturaStringL+1;
                $almacenajeAlertaCaracterTipo='caracterAbreviatura';
            }else{
                $almacenajeAlertaCaracter=$enviarAbreviaturaStringL;
                $almacenajeAlertaCaracterTipo='caracterAbreviatura';
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
                             
                            <form name="miformulario" action="../../normatividad" method="POST" onsubmit="procesar(this.action);" >
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