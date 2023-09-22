<?php error_reporting(E_ERROR); error_reporting(0);
//IMPORTAR PROCESOS
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
            
        //VARIABLES BOOLEANAS PARA VALIDACIONES    
        $repiteNit = TRUE; //Validar que no se repita nombre 
        $repiteNitExcel = TRUE;
        $grupoExiste = TRUE;
        $criticidadExistente = TRUE;
        $validarNumericoA = TRUE;
        $validarNumericoB = TRUE;
        $validarNumericoC = TRUE;
        $validarNumericoD = TRUE;
        
        // nombre
        $campoNull = TRUE;
        $arrayNit = array();
        $repiteNit = TRUE;
        // END
        
       
        
        
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
             $contador='0';
            foreach ($Reader as $Row)
            {
                $contador++;
                if($Row[13]=='Tiempo de Evaluacion'){ continue;} //Aca remplazo por el nombre y posicion de la ultima columna de excel para que no me agrege la primera fila.
          
                $nit = "";
                if(isset($Row[0])) {
                    $nit = mysqli_real_escape_string($con,$Row[0]);
                     $nit=trim($nit);
                      $nit=str_replace($nit);
                    $validacion1 = $con->query("SELECT * FROM proveedores WHERE nit = '$nit'");//consulta a base de datos si el nombre se repite
                    $numNom = mysqli_num_rows($validacion1);
                    
                    if($numNom > 0){//si el nombre está repetido se pone falso
                        $repiteNit = FALSE;
                    }
                    
                    if($nit == ""){
                        $campoNull = FALSE;
                    }else{
                        array_push($arrayNit,$nit);
                    }
                    
                }
                
                $proveedor = "";
                if(isset($Row[1])) {
                    $proveedor = mysqli_real_escape_string($con,$Row[1]);
                     $proveedor=trim($proveedor);
                }
                
                $descripcion = "";
                if(isset($Row[2])) {
                    $descripcion = mysqli_real_escape_string($con,$Row[2]);
                }
                
                $grupo = "";
                if(isset($Row[3])) {
                    $grupo = mysqli_real_escape_string($con,$Row[3]);
                      $grupo=trim($grupo);
                       $grupo=str_replace($grupo);
                    $validacion1 = $con->query("SELECT * FROM proveedoresGrupo WHERE grupo = '$grupo' ");//consulta a base de datos si el nombre se repite
                    $numNom = mysqli_num_rows($validacion1);
                    
                    if($numNom <= 0){//si el nombre está repetido se pone falso
                        $grupoExiste = FALSE;
                    }
                }
                
                $ciudad = "";
                if(isset($Row[4])) {
                    $ciudad = mysqli_real_escape_string($con,$Row[4]);
                }
                
                $direccion = "";
                if(isset($Row[5])) {
                    $direccion = mysqli_real_escape_string($con,$Row[5]);
                }
                
                $telefono = "";
                if(isset($Row[6])) {
                    $telefono = mysqli_real_escape_string($con,$Row[6]);
                }
                
                $contacto = "";
                if(isset($Row[7])) {
                    $contacto = mysqli_real_escape_string($con,$Row[7]);
                }
                
                $criticidad = "";
                if(isset($Row[9])) {
                    $criticidad = mysqli_real_escape_string($con,$Row[9]);
                    $criticidad=trim($criticidad);
                    $criticidad=strtolower($criticidad);
                    if($criticidad == 'bajo' || $criticidad == 'medio' || $criticidad == 'critico' ){ 
                        if($criticidad == 'bajo'){
                             '<br>Sale '.$guardarCriticidad='Bajo';    
                        }
                        if($criticidad == 'medio'){
                             '<br>Sale '.$guardarCriticidad='Medio';    
                        }
                        if($criticidad == 'critico'){
                             '<br>Sale '.$guardarCriticidad='Critico';    
                        }
                    }else{
                        $criticidadExistente= FALSE;
                    }
                    
                }

                $terminoPago = "";
                if(isset($Row[10])) {
                    $terminoPago = mysqli_real_escape_string($con,$Row[10]);
                    $terminoPago=trim($terminoPago);
                    if(is_numeric($terminoPago)){
                        
                    }else{
                        $validarNumericoA=FALSE;
                    }
                    
                }
                
                $frecuenciaActualizacion = "";
                if(isset($Row[11])) {
                    $frecuenciaActualizacion = mysqli_real_escape_string($con,$Row[11]);
                    
                    if(is_numeric($frecuenciaActualizacion)){
                        
                    }else{
                        $validarNumericoB=FALSE;
                    }
                    
                }
                
                $frecuenciaActualizacionDocumentos = "";
                if(isset($Row[12])) {
                    $frecuenciaActualizacionDocumentos = mysqli_real_escape_string($con,$Row[12]);
                    
                    if(is_numeric($frecuenciaActualizacionDocumentos)){
                        
                    }else{
                        $validarNumericoC=FALSE;
                    }
                    
                }
                
                $tiempoEvaludacion = "";
                if(isset($Row[13])) {
                    $tiempoEvaludacion = mysqli_real_escape_string($con,$Row[13]);
                    
                    if(is_numeric($tiempoEvaludacion)){
                        
                    }else{
                        $validarNumericoD=FALSE;
                    }
                    
                }
                
                
              

             }
             if($contador == 1){
                ?>
                                        <script> 
                                             window.onload=function(){
                                           
                                                document.forms["miformularioV"].submit();
                                             }
                                        </script>
                                         
                                        <form name="miformularioV" action="../../procesos" method="POST" onsubmit="procesar(this.action);" >
                                            <input type="hidden" name="validacionExisteImportacionVacio" value="1">
                                        </form> 
                                <?php
            }
        
         }
        
        /// para el nombre
        if(count($arrayNit) > count(array_unique($arrayNit))){//Valido si hay seriales repetidos
          $repiteNitExcel = FALSE;
        }
        /// END
       
        
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
            
            foreach ($Reader as $Row)
            {
          
                if($Row[13]=='Tiempo de Evaluacion'){ continue;} //Aca remplazo por el nombre y posicion de la ultima columna de excel para que no me agrege la primera fila.
          
                $nit = "";
                if(isset($Row[0])) {
                    $nit = mysqli_real_escape_string($con,$Row[0]);
                     $terminoPago=trim($terminoPago);
                }
                
                $proveedor = "";
                if(isset($Row[1])) {
                    $proveedor = mysqli_real_escape_string($con,$Row[1]);
                }
                
                $descripcion = "";
                if(isset($Row[2])) {
                    $descripcion = mysqli_real_escape_string($con,$Row[2]);
                }
               
                $grupo = "";
                if(isset($Row[3])) {
                    $grupo = mysqli_real_escape_string($con,$Row[3]);
                     $grupo=trim($grupo);
                       $grupo=str_replace($grupo);
                    $validacion1 = $con->query("SELECT * FROM proveedoresGrupo WHERE grupo = '$grupo' ");//consulta a base de datos si el nombre se repite
                    $extraerGrupo=$validacion1->fetch_array(MYSQLI_ASSOC);
                    $grupoSale=$extraerGrupo['id'];
                    $numNom = mysqli_num_rows($validacion1);
                    
                    if($numNom <= 0){//si el nombre está repetido se pone falso
                        $grupoExiste = FALSE;
                    }
                    
                   
                    
                }
                
                $ciudad = "";
                if(isset($Row[4])) {
                    $ciudad = mysqli_real_escape_string($con,$Row[4]);
                }
                
                $direccion = "";
                if(isset($Row[5])) {
                    $direccion = mysqli_real_escape_string($con,$Row[5]);
                }
                
                $telefono = "";
                if(isset($Row[6])) {
                    $telefono = mysqli_real_escape_string($con,$Row[6]);
                }
                
                $contacto = "";
                if(isset($Row[7])) {
                    $contacto = mysqli_real_escape_string($con,$Row[7]);
                }
                
                $correo = "";
                if(isset($Row[8])) {
                    $correo = mysqli_real_escape_string($con,$Row[8]);
                }
                
                $criticidad = "";
                if(isset($Row[9])) {
                    $criticidad = mysqli_real_escape_string($con,$Row[9]);
                }
                
                $terminoPago = "";
                if(isset($Row[10])) {
                    $terminoPago = mysqli_real_escape_string($con,$Row[10]);
                }
                
                $frecuenciaActualizacion = "";
                if(isset($Row[11])) {
                    $frecuenciaActualizacion = mysqli_real_escape_string($con,$Row[11]);
                }
                
                $frecuenciaActualizacionDocumentos = "";
                if(isset($Row[12])) {
                    $frecuenciaActualizacionDocumentos = mysqli_real_escape_string($con,$Row[12]);
                }
                
                $tiempoEvaludacion = "";
                if(isset($Row[13])) {
                    $tiempoEvaludacion = mysqli_real_escape_string($con,$Row[13]);
                }
                
                $validarArchivo = "";
                if(isset($Row[13])) {
                    $validarArchivo = mysqli_real_escape_string($con,$Row[13]);
                }
                
				if($validarArchivo < 0 || $validarArchivo > 0 ){ // evitamos subir un archivo diferente
                
				    
                if (!empty($nit) || !empty($proveedor) || !empty($descripcion) || !empty($grupo) || !empty($ciudad) || !empty($direccion) || !empty($telefono) || !empty($contacto) || !empty($correo) || !empty($criticidad) || !empty($terminoPago) || !empty($frecuenciaActualizacion) || !empty($frecuenciaActualizacionDocumentos) || !empty($tiempoEvaludacion)) {
                    
                    if($repiteNit == FALSE || $repiteNitExcel == FALSE || $grupoExiste == FALSE || $criticidadExistente == FALSE || $validarNumericoA == FALSE || $validarNumericoB == FALSE || $validarNumericoC == FALSE || $validarNumericoD == FALSE){
                       
                        if($campoNull == FALSE){ //echo 'Existe en el sistema<br>';
                            //// cuando existe un nit
                            ?>
                                <script> 
                                     window.onload=function(){
                                   
                                         document.forms["miformulario"].submit();
                                     }
                                </script>
                                 
                                <form name="miformulario" action="../../proveedoresInscripcion" method="POST" onsubmit="procesar(this.action);" >
                                    <input type="hidden" name="validacionExisteImportacionVacio" value="1">
                                </form> 
                            <?php
                        }
                        
                        if($repiteNitExcel == FALSE){ //echo 'existe en el archivo <br>';
                            //// cuando se repite un nit en el Excel
                            ?>
                                <script> 
                                     window.onload=function(){
                                   
                                         document.forms["miformulario"].submit();
                                     }
                                </script>
                                 
                                <form name="miformulario" action="../../proveedoresInscripcion" method="POST" onsubmit="procesar(this.action);" >
                                    <input type="hidden" name="validacionExisteImportacionB" value="1">
                                </form> 
                            <?php
                        }
                        
                        if($grupoExiste == FALSE){ //echo 'existe en el archivo <br>';
                            //// cuando se repite un nit en el Excel
                            ?>
                                <script> 
                                     window.onload=function(){
                                   
                                         document.forms["miformulario"].submit();
                                     }
                                </script>
                                 
                                <form name="miformulario" action="../../proveedoresInscripcion" method="POST" onsubmit="procesar(this.action);" >
                                    <input type="hidden" name="validacionExisteImportacionC" value="1">
                                </form> 
                            <?php
                        }
                        
                        if($criticidadExistente == FALSE){ //echo 'la criticidad no existe<br>';
                            //// cuando se repite un nit en el Excel
                            ?>
                                <script> 
                                     window.onload=function(){
                                   
                                         document.forms["miformulario"].submit();
                                     }
                                </script>
                                 
                                <form name="miformulario" action="../../proveedoresInscripcion" method="POST" onsubmit="procesar(this.action);" >
                                    <input type="hidden" name="validacionExisteImportacionD" value="1">
                                </form> 
                            <?php
                        }
                        
                        if($validarNumericoA == FALSE || $validarNumericoB == FALSE || $validarNumericoC == FALSE || $validarNumericoD == FALSE){
                            ?>
                                <script> 
                                     window.onload=function(){
                                   
                                         document.forms["miformulario"].submit();
                                     }
                                </script>
                                 
                                <form name="miformulario" action="../../proveedoresInscripcion" method="POST" onsubmit="procesar(this.action);" >
                                    <input type="hidden" name="validacionExisteImportacionE" value="1">
                                </form> 
                            <?php
                        }
                        
                        
                        
                       
                        
                    }else{
                       
                    
                    $query = "INSERT INTO proveedores (nit,razonSocial,descripcion,grupo,ciudad,direccion,telefono,contacto,email,criticidad,terminoPago,frecuenciaActualizacion,frecuenciaActualizacionD,tiempoEvaluacion)
                    VALUES('$nit','$proveedor','$descripcion','$grupoSale','$ciudad','$direccion','$telefono','$contacto','$correo','$guardarCriticidad','$terminoPago','$frecuenciaActualizacion','$frecuenciaActualizacionDocumentos','$tiempoEvaludacion')";
                    $resultados = mysqli_query($con, $query)or die(mysqli_error($con));
                    
                        if (!empty($resultados)) {
                            $type = "success";
                            $message = "Excel importado correctamente";
                            // echo '<script language="javascript">alert("Excel importado correctamente");
                            //window.location.href="../../procesos"</script>';
                        } else {
                            $type = "error";
                            $message = "Hubo un problema al importar registros";
                            //echo '<script language="javascript">alert("Hubo un problema al importar registros");
                            //window.location.href="../../procesos"</script>';
                        }
                    
                    ?>
                        <script> 
                             window.onload=function(){
                           
                                 document.forms["miformulario"].submit();
                             }
                        </script>
                         
                        <form name="miformulario" action="../../proveedoresInscripcion" method="POST" onsubmit="procesar(this.action);" >
                            <input type="hidden" name="validacionExisteImportacionExito" value="1">
                        </form> 
                    <?php
                    }
                }
                
            }else{
                ?>
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformulario"].submit();
                         }
                    </script>
                     
                    <form name="miformulario" action="../../proveedoresInscripcion" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="validacionExisteImportacion" value="1">
                    </form> 
                <?php
                
				}////// para evitar que suban otro archivo
                
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
    
    
        if(!empty($message)) {/*
         
          ?>  
                                                                    <script>
                                                                        window.onload=function(){
                                                                      
                                                                          document.forms["miformulario"].submit();
                                                                        }
                                                                        </script>
                                                                    
                                                                    <form name="miformulario" action="../../procesos" method="POST" onsubmit="procesar(this.action);" >
                                                                        <input style="visibility:hidden" readonly type="text" name="mensaje" value="<?php echo $message; ?>">
                                                                        
                                                                        
                                                                    </form>
             <?php 
        
            
        */}
    ?>
    
                                                                    