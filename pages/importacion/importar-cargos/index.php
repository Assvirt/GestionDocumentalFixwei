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
                        }
                    }
                }
                
                
                $descripcion = "";
                if(isset($Row[1])) {
                   
                    $descripcion = mysqli_real_escape_string($con,$Row[1]);
                    $descripcion=trim($descripcion);
                    if($descripcion == ""){ 
                        $campoNull = FALSE;
                        $mensajeCampoVacio='en la columna descripción';
                    }
                }
				
                $jefeInmediato = "";//gerente
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
                        
                        $validacion2P = $con->query("SELECT * FROM cargos WHERE nombreCargos = '$jefeInmediato'");  
                        $extraerValidacion2=$validacion2P->fetch_array(MYSQLI_ASSOC);
                         '--'.$extraerValidacion2['nombreCargos'];
                         '<br>';
                        $num2P = mysqli_num_rows($validacion2P);
                        
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
                
                $nivelCargo = "";
                if(isset($Row[3])) { 
                     
                     $nivelCargo = mysqli_real_escape_string($con,$Row[3]);
                     $nivelCargo=trim($nivelCargo);
                     
                    if($nivelCargo == ""){ 
                        $campoNull = FALSE;
                        $nivelCargo = 'No Aplica';
                        $mensajeCampoVacio='en la columna Nivel de cargo';
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
                        
                        $validacion3 = $con->query("SELECT * FROM nivelcargo WHERE nivelCargo = '$nivelCargo' ");
                        $extraerNombreNivelCargo=$validacion3->fetch_array(MYSQLI_ASSOC);
                         ' --- '.$nombreNivelCargo=$extraerNombreNivelCargo['nivelCargo'];
                          $nivelCargo = $extraerNombreNivelCargo['id'];
                         '<br>';
                        $num3 = mysqli_num_rows($validacion3);
                        
                        
                        
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
                                                <input type="hidden" name="validacionExisteImportacionD" value="1">
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
                    
                    

                    if($repiteNombre == FALSE || $nombreCargoRepetido == FALSE || $nombreInmediato == FALSE || $nombreCargoRe == FALSE || $campoNull == FALSE){
                         '<br>validaciones';
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
                        //echo '<script language="javascript">alert("algunos elementos no existen o están repetidos");
                        //window.location.href="../../cargos"</script>';
                        /*?>
                                        <script> 
                                             window.onload=function(){
                                           
                                                 document.forms["miformulario"].submit();
                                             }
                                        </script>
                                         
                                        <form name="miformulario" action="../../cargos" method="POST" onsubmit="procesar(this.action);" >
                                            <input type="hidden" name="" value="1">
                                        </form> 
                        <?php*/
                        
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
                                            //alert("Registro");
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



    if(!empty($type)) {
        
        
         $type . " display-block"; 
        
    } 
    
    
        /*if(!empty($message)) { 
          ?>  
                                                                    <script>
                                                                        window.onload=function(){
                                                                      
                                                                          document.forms["miformulario"].submit();
                                                                        }
                                                                        </script>
                                                                    
                                                                    <form name="miformulario" action="../../cargos" method="POST" onsubmit="procesar(this.action);" >
                                                                        <input style="visibility:hidden" readonly type="text" name="mensaje" value="<?php echo $message; ?>">
                                                                        
                                                                        
                                                                    </form>
             <?php 
        
            } */
    ?>
    
                                                                    