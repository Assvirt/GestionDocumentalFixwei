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
        
        //proveedor
        $repiteProveedor =TRUE;
        $arrayProveedor = array();
        $repiteProveedorExcel = TRUE;
        // end
        
        // metodo
        $metodoExiste = TRUE;
        // end
        
        // ciudad
        $ciudadExiste = TRUE;
        // end
        
        // tipo de persona
        $tipoPersonaExiste = TRUE;
        // end
        
        // tipo de proveedor
        $tipoProveedorExiste = TRUE;
        // end
        
        // validacion numerica
        $validacionNumerico = TRUE;
        // end
        
        // valida metodo de pago
        $validacionMetodoPago = TRUE;
        // end
        
        // alerta con el caracter del correo
        $correoConfirmado=TRUE;
        
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
             $contador='0';
             $contadorCorreos=0;
            foreach ($Reader as $Row)
            {
                $contador++;
                if($Row[18]=='Tipo de proveedor'){ continue;} //Aca remplazo por el nombre y posicion de la ultima columna de excel para que no me agrege la primera fila.
          
                $nit = "";
                $nitDigito = "";
                if(isset($Row[0]) && isset($Row[1])) {
                    //'NIT:'. $nit = mysqli_real_escape_string($con,$Row[0]);
                     $nit = mysqli_real_escape_string($con,$Row[0]);
                     '-'.$nitDigito = mysqli_real_escape_string($con,$Row[1]);
                    $validacion1 = $con->query("SELECT * FROM proveedores WHERE nit = '$nit' AND nitDigito='$nitDigito' ");//consulta a base de datos si el nombre se repite
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
                
                $contacto = "";
                if(isset($Row[2])) {
                    '<br>';
                    'Contacto: '.$contacto = mysqli_real_escape_string($con,$Row[2]);
                    
                    if($contacto == ""){
                        $campoNull = FALSE;
                    }else{
                       
                    }
                }
                
                $proveedor = "";
                if(isset($Row[3])) {
                     '<br>';
                     'Provedor: '.$proveedor = mysqli_real_escape_string($con,$Row[3]);
                    
                    if($proveedor == ""){
                        $campoNull = FALSE;
                    }else{
                       
                    
                    
                        $validacionProveedor = $con->query("SELECT * FROM proveedores WHERE razonSocial = '$proveedor'");
                        $numNomProveedor = mysqli_num_rows($validacionProveedor);
                        
                        if($numNomProveedor > 0){
                            $repiteProveedor = FALSE;
                        }
                        
                        if($proveedor == ""){
                            $campoNull = FALSE;
                        }else{
                            array_push($arrayProveedor,$proveedor);
                        }
                    }
                }
                
                $correo = "";
                if(isset($Row[4])) {
                     '<br>';
                     'Correo: '.$correo = mysqli_real_escape_string($con,$Row[4]);
                    if($correo == ""){
                        $campoNull = FALSE;
                    }else{
                        $cadena_buscada = '@';
                        $posicion_coincidencia = strpos($correo, $cadena_buscada);
                        
                        if ($posicion_coincidencia == FALSE) {
                             "<br>NO se ha encontrado la palabra deseada!!!!";
                            $correoConfirmado= FALSE;
                            $contadorCorreos++;
                        } else {
                            $correoConfirmado= TRUE;
                             "<br>Éxito!!! Se ha encontrado la palabra buscada en la posición: ".$posicion_coincidencia;
                        }
                       
                    }
                    
                }
                
                $movil = "";
                if(isset($Row[5])) {
                     '<br>';
                     'Movil: '.$movil = mysqli_real_escape_string($con,$Row[5]);
                    if($movil == ""){
                        $campoNull = FALSE;
                    }else{
                            if(is_numeric($movil)){
                                
                            }else{
                                 $validacionNumerico=FALSE;
                            }
                    }
                    
                }
                
                
                $codigoCiiu = "";
                if(isset($Row[6])) {
                     '<br>';
                     'codigo Ciiu: '.$codigoCiiu = mysqli_real_escape_string($con,$Row[6]);
                    if($codigoCiiu == ""){
                        $campoNull = FALSE;
                    }else{
                            if(is_numeric($codigoCiiu)){
                                
                            }else{
                                 $validacionNumerico=FALSE;
                            }
                    }
                    
                }
                
                
                $actividad = "";
                if(isset($Row[7])) {
                     '<br>';
                     'Act: '.$actividad = mysqli_real_escape_string($con,$Row[7]);
                    if($actividad == ""){
                        $campoNull = FALSE;
                    }else{
                       
                    }
                }
                
                $criticidad = "";
                if(isset($Row[8])) {
                     '<br>';
                     'Cri:'.$criticidad = mysqli_real_escape_string($con,$Row[8]);
                    if($criticidad == ""){
                        $campoNull = FALSE;
                    }else{
                        $validacionCriticidad = $con->query("SELECT * FROM proveedoresCriticidad WHERE tipo = '$criticidad' ");//consulta a base de datos si el nombre se repite
                        $numNomCriticidad = mysqli_num_rows($validacionCriticidad);
                        
                        if($numNomCriticidad <= 0){ /// no existe la criticidad
                            $criticidadExistente = FALSE;
                        }
                    }
                    
                   
                    
                    
                    
                }
                
                $grupo = "";
                if(isset($Row[9])) {
                    '<br>';     
                    'Gru:'. $grupo = mysqli_real_escape_string($con,$Row[9]);
                    
                    if($grupo == ""){
                        $campoNull = FALSE;
                    }else{
                        $validacionGrupo = $con->query("SELECT * FROM proveedoresGrupo WHERE grupo = '$grupo' ");//consulta a base de datos si el nombre se repite
                        $numNomGrupo = mysqli_num_rows($validacionGrupo);
                        
                        if($numNomGrupo <= 0){//si el nombre está repetido se pone falso
                            $grupoExiste = FALSE;
                        }
                    }
                    
                    
                }
                
                $metodo = "";
                if(isset($Row[10])) {
                     '<br>';
                     'Metodo: '.$metodo = mysqli_real_escape_string($con,$Row[10]);
                    
                    if($metodo == ""){
                        $campoNull = FALSE;
                    }else{
                        $metocominus=strtolower($metodo);
                    
                    
                        if($metocominus == 'credito' || $metocominus == 'crédito'){
                            $guardarMetodo='credito';
                        }elseif($metocominus == 'contado'){
                            $guardarMetodo='contado';
                        }elseif($metocominus == 'contraentrega'){
                            $guardarMetodo='contraentrega';
                        }elseif($metocominus == 'otro'){
                            $guardarMetodo='otro';
                        }else{
                            $metodoExiste= FALSE;
                        }
                    }
                }
                
                
                $otro = "";
                if(isset($Row[11])) {
                     '<br>';
                     'Otro:'.$otro = mysqli_real_escape_string($con,$Row[11]);
                    
                    if($otro != NULL && $metocominus == 'contado' ){
                        $validacionMetodoPago=FALSE; 
                        //var_dump($otro);
                        //echo 'entra 1';
                    }elseif($otro != NULL && $metocominus == 'contraentrega'){
                        $validacionMetodoPago=FALSE; 
                         //echo 'entra 2';
                  
                    }else{
                        if($metocominus == 'otro' || $metocominus == 'credito' || $metocominus == 'crédito'){
                            if($otro == ""){ 
                                $campoNull = FALSE;
                            }
                            
                            
                            if($metocominus == 'otro'){
                                $terminoPago=$otro;
                            }elseif($metocominus == 'credito' || $metocominus == 'crédito'){
                                if(is_numeric($otro)){
                                     $terminoPago=$otro;
                                }else{
                                     $validacionNumerico=FALSE;
                                }
                            }
                            
                        }else{
                             $terminoPago=$otro;
                        }
                    }
                }
                
                
                $ciudad = "";
                if(isset($Row[12])) {
                     '<br>';
                     'Ciudad: '.$ciudad = mysqli_real_escape_string($con,$Row[12]);
                    
                    if($ciudad == ""){
                        $campoNull = FALSE;
                    }else{
                        $validacionCiudad = $con->query("SELECT * FROM municipios WHERE id = '$ciudad' ");
                        $numNomCiudad = mysqli_num_rows($validacionCiudad);
                        
                        if($numNomCiudad <= 0){//si el nombre está repetido se pone falso
                            $ciudadExiste = FALSE;
                        }
                    }
                    
                   
                    
                    
                }

                $direccion = "";
                if(isset($Row[13])) {
                     '<br>';
                     'Direccion: '.$direccion = mysqli_real_escape_string($con,$Row[13]);
                    
                    if($direccion == ""){
                        $campoNull = FALSE;
                    }else{
                       
                    }
                    
                }
                
                $frecuenciaActualizacion = "";
                if(isset($Row[14])) {
                     '<br>';
                     'Frecue Act: '.intval($frecuenciaActualizacion = mysqli_real_escape_string($con,$Row[14]));
                    
                    if($frecuenciaActualizacion == ""){
                        $campoNull = FALSE;
                    }else{
                       if(is_numeric($frecuenciaActualizacion)){
                          
                       }else{ 
                          $validacionNumerico=FALSE;
                       }
                    }
                    
                }
                
                $telefono = "";
                if(isset($Row[15])) {
                     '<br>';
                     'Tel: '.$telefono = mysqli_real_escape_string($con,$Row[15]);
                    
                    if($telefono == ""){
                        $campoNull = FALSE;
                    }else{
                       if(is_numeric($telefono)){
                          
                       }else{ 
                          $validacionNumerico=FALSE;
                       }
                    }
                    
                }
                
                $tiempoEvaludacion = "";
                if(isset($Row[16])) {
                     '<br>';
                    //settype($variable, "integer");
                     'Tiem Eva: '.$var=(intval(substr($tiempoEvaludacion = mysqli_real_escape_string($con,$Row[16]),0,2)));
                     //var_dump($var);
                    
                    if($tiempoEvaludacion == ""){
                        $campoNull = FALSE;
                    }else{
                       if(is_numeric($tiempoEvaludacion)){
                          
                       }else{ 
                          $validacionNumerico=FALSE;
                       }
                    }
                    
                }
                
                $tipoPersona = "";
                if(isset($Row[17])) {
                     '<br>';
                     'Tipo Persona:'.$tipoPersona = mysqli_real_escape_string($con,$Row[17]);
                   
                    if($tipoPersona == ""){
                        $campoNull = FALSE;
                    }else{
                        $tipoPersonCominus=strtolower($tipoPersona);
                        if($tipoPersonCominus == 'natural' || $tipoPersonCominus == 'jurídica' ){
                            $enviarPersonaTipo=$tipoPersonCominus;
                        }else{
                            $tipoPersonaExiste= FALSE;
                        }
                    }
                   
                   
                }
                
                $tipoProveedor = "";
                if(isset($Row[18])) {
                     '<br>';
                     'Tipo Proveedor: '.$tipoProveedor = mysqli_real_escape_string($con,$Row[18]);
                    
                    if($tipoProveedor == ""){
                        $campoNull = FALSE;
                    }else{
                       
                    
                        $validacionTipoProveedor = $con->query("SELECT * FROM proveedoresTipo WHERE tipo = '$tipoProveedor' ");
                        $numNomTipoProveedor = mysqli_num_rows($validacionTipoProveedor);
                        
                        if($numNomTipoProveedor <= 0){//si el nombre está repetido se pone falso
                            $tipoProveedorExiste = FALSE;
                        }
                    }
                    
                   
                }
              

             }
             if($contador == 1){
                ?>
                                        <script> 
                                             window.onload=function(){
                                           
                                               // document.forms["miformularioV"].submit();
                                             }
                                        </script>
                                         
                                        <form name="miformularioV" action="../../proveedorVigente" method="POST" onsubmit="procesar(this.action);" >
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
        /// para el proveedor
        if(count($arrayProveedor) > count(array_unique($arrayProveedor))){
          $repiteProveedorExcel = FALSE;
        }
        /// END
       
        
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
            
            foreach ($Reader as $Row)
            {
          
                if($Row[18]=='Tipo de proveedor'){ continue;} //Aca remplazo por el nombre y posicion de la ultima columna de excel para que no me agrege la primera fila.
          
                
                $nit = "";
                $nitDigito = "";
                if(isset($Row[0]) && isset($Row[1])) {
                    //'NIT:'. $nit = mysqli_real_escape_string($con,$Row[0]);
                     $nit = mysqli_real_escape_string($con,$Row[0]);
                     '-'.$nitDigito = mysqli_real_escape_string($con,$Row[1]);
                    $validacion1 = $con->query("SELECT * FROM proveedores WHERE nit = '$nit' AND nitDigito='$nitDigito' ");//consulta a base de datos si el nombre se repite
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
                
                $contacto = "";
                if(isset($Row[2])) {
                    $contacto = mysqli_real_escape_string($con,$Row[2]);
                    
                    if($contacto == ""){
                        $campoNull = FALSE;
                    }else{
                       
                    }
                }
                
                $proveedor = "";
                if(isset($Row[3])) {
                    $proveedor = mysqli_real_escape_string($con,$Row[3]);
                    
                    if($proveedor == ""){
                        $campoNull = FALSE;
                    }else{
                       
                    
                    
                        $validacionProveedor = $con->query("SELECT * FROM proveedores WHERE razonSocial = '$proveedor'");
                        $numNomProveedor = mysqli_num_rows($validacionProveedor);
                        
                        if($numNomProveedor > 0){
                            $repiteProveedor = FALSE;
                        }
                        
                        if($proveedor == ""){
                            $campoNull = FALSE;
                        }else{
                            array_push($arrayProveedor,$proveedor);
                        }
                    }
                }
                
                $correo = "";
                if(isset($Row[4])) {
                    $correo = mysqli_real_escape_string($con,$Row[4]);
                    if($correo == ""){
                        $campoNull = FALSE;
                    }else{
                       
                    }
                    
                }
                
                $movil = "";
                if(isset($Row[5])) {
                    $movil = mysqli_real_escape_string($con,$Row[5]);
                   
                    if($movil == ""){
                        $campoNull = FALSE;
                    }else{
                            if(is_numeric($movil)){
                                
                            }else{
                                 $validacionNumerico=FALSE;
                            }
                    }
                    
                }
                
                $codigoCiiu = "";
                if(isset($Row[6])) {
                     '<br>';
                     'codigo Ciiu: '.$codigoCiiu = mysqli_real_escape_string($con,$Row[6]);
                    if($codigoCiiu == ""){
                        $campoNull = FALSE;
                    }else{
                            if(is_numeric($codigoCiiu)){
                                
                            }else{
                                 $validacionNumerico=FALSE;
                            }
                    }
                    
                }
                
                $actividad = "";
                if(isset($Row[7])) {
                    $actividad = mysqli_real_escape_string($con,$Row[7]);
                    if($actividad == ""){
                        $campoNull = FALSE;
                    }else{
                       
                    }
                }
                
                $criticidad = "";
                if(isset($Row[8])) {
                    $criticidad = mysqli_real_escape_string($con,$Row[8]);
                    if($criticidad == ""){
                        $campoNull = FALSE;
                    }else{
                       
                    
                    
                        $validacionCriticidad = $con->query("SELECT * FROM proveedoresCriticidad WHERE tipo = '$criticidad' ");//consulta a base de datos si el nombre se repite
                        $extraerValidacionCriticidad=$validacionCriticidad->fetch_array(MYSQLI_ASSOC);
                        $enviarIdCriticidad=$extraerValidacionCriticidad['id'];
                        
                        $numNomCriticidad = mysqli_num_rows($validacionCriticidad);
                        
                        if($numNomCriticidad <= 0){ /// no existe la criticidad
                            $criticidadExistente = FALSE;
                        }
                    
                    }
                    
                    
                }
                
                $grupo = "";
                if(isset($Row[9])) {
                    $grupo = mysqli_real_escape_string($con,$Row[9]);
                    
                    if($grupo == ""){
                        $campoNull = FALSE;
                    }else{
                       
                    
                    
                        $validacionGrupo = $con->query("SELECT * FROM proveedoresGrupo WHERE grupo = '$grupo' ");//consulta a base de datos si el nombre se repite
                        $extraerValidacionGrupo=$validacionGrupo->fetch_array(MYSQLI_ASSOC);
                        $enviarIdGrupo=$extraerValidacionGrupo['id'];
                        $numNomGrupo = mysqli_num_rows($validacionGrupo);
                        
                        if($numNomGrupo <= 0){//si el nombre está repetido se pone falso
                            $grupoExiste = FALSE;
                        }
                    }
                }
                
                $metodo = "";
                if(isset($Row[10])) {
                    $metodo = mysqli_real_escape_string($con,$Row[10]);
                    
                    if($metodo == ""){
                        $campoNull = FALSE;
                    }else{
                       
                    
                    
                        $metocominus=strtolower($metodo);
                        
                        
                        if($metocominus == 'credito' || $metocominus == 'crédito'){
                            $guardarMetodo='credito';
                        }elseif($metocominus == 'contado'){
                            $guardarMetodo='contado';
                        }elseif($metocominus == 'contraentrega'){
                            $guardarMetodo='contraentrega';
                        }elseif($metocominus == 'otro'){
                            $guardarMetodo='otro';
                        }else{
                            $metodoExiste= FALSE;
                        }
                    }
                    
                    
                    
                }
                
                $otro = "";
                if(isset($Row[11])) {
                    $otro = mysqli_real_escape_string($con,$Row[11]);
                    
                    if($otro != NULL && $metocominus == 'contado' ){
                        $validacionMetodoPago=FALSE; 
                        //var_dump($otro);
                        //echo 'entra 1';
                    }elseif($otro != NULL && $metocominus == 'contraentrega'){
                        $validacionMetodoPago=FALSE; 
                         //echo 'entra 2';
                  
                    }else{
                        if($metocominus == 'otro' || $metocominus == 'credito' || $metocominus == 'crédito'){
                            if($otro == ""){
                                $campoNull = FALSE;
                            }
                            
                            
                            if($metocominus == 'otro'){
                                $terminoPago=$otro;
                            }elseif($metocominus == 'credito' || $metocominus == 'crédito'){
                                if(is_numeric($otro)){
                                     $terminoPago=$otro;
                                }else{
                                     $validacionNumerico=FALSE;
                                }
                            }
                            
                        }else{
                             $terminoPago=$otro;
                        }
                    }
                    
                }
                
                $ciudad = "";
                if(isset($Row[12])) {
                    $ciudad = mysqli_real_escape_string($con,$Row[12]);
                    
                    if($ciudad == ""){
                        $campoNull = FALSE;
                    }else{
                       
                    
                    
                        $validacionCiudad = $con->query("SELECT * FROM municipios WHERE id = '$ciudad' ");
                        $extraerValidacionCiudad=$validacionCiudad->fetch_array(MYSQLI_ASSOC);
                        $enviarIdCiudad=$extraerValidacionCiudad['id'];
                        $numNomCiudad = mysqli_num_rows($validacionCiudad);
                        
                        if($numNomCiudad <= 0){//si el nombre está repetido se pone falso
                            $ciudadExiste = FALSE;
                        }
                    }
                    
                    
                }

                $direccion = "";
                if(isset($Row[13])) {
                    $direccion = mysqli_real_escape_string($con,$Row[13]);
                    
                    if($direccion == ""){
                        $campoNull = FALSE;
                    }else{
                       
                    }
                    
                }
                
                $frecuenciaActualizacion = "";
                if(isset($Row[14])) {
                    $frecuenciaActualizacion = mysqli_real_escape_string($con,$Row[14]);
                    
                    if($frecuenciaActualizacion == ""){
                        $campoNull = FALSE;
                    }else{
                       
                    }
                    
                }
                
                $telefono = "";
                if(isset($Row[15])) {
                    $telefono = mysqli_real_escape_string($con,$Row[15]);
                    
                    if($telefono == ""){
                        $campoNull = FALSE;
                    }else{
                       
                    }
                    
                }
                
                $tiempoEvaludacion = "";
                if(isset($Row[16])) {
                    $tiempoEvaludacion = mysqli_real_escape_string($con,$Row[16]);
                    
                    if($tiempoEvaludacion == ""){
                        $campoNull = FALSE;
                    }else{
                       
                    }
                    
                }
                
                $tipoPersona = "";
                if(isset($Row[17])) {
                    $tipoPersona = mysqli_real_escape_string($con,$Row[17]);
                   
                    if($tipoPersona == ""){
                        $campoNull = FALSE;
                    }else{
                       
                      
                        $tipoPersonCominus=strtolower($tipoPersona);
                        if($tipoPersonCominus == 'natural' || $tipoPersonCominus == 'jurídica' ){
                             $enviarPersonaTipo=utf8_encode($tipoPersonCominus); 
                        }else{
                            $tipoPersonaExiste= FALSE; 
                        }
                    }
                   
                }
                
                $tipoProveedor = "";
                if(isset($Row[18])) {
                    $tipoProveedor = mysqli_real_escape_string($con,$Row[18]);
                    
                    if($tipoProveedor == ""){
                        $campoNull = FALSE;
                    }else{
                       
                    
                    
                        $validacionTipoProveedor = $con->query("SELECT * FROM proveedoresTipo WHERE tipo = '$tipoProveedor' ");
                        $extraerValidacionTipoProveedor=$validacionTipoProveedor->fetch_array(MYSQLI_ASSOC);
                        $enviarIdTipoProveedor=$extraerValidacionTipoProveedor['id'];
                        $numNomTipoProveedor = mysqli_num_rows($validacionTipoProveedor);
                        
                        if($numNomTipoProveedor <= 0){//si el nombre está repetido se pone falso
                            $tipoProveedorExiste = FALSE;
                        }
                    }
                    
                   
                }
			
                    //$correoConfirmado == "alerta" ||
                    if( $campoNull == FALSE || $repiteNit == FALSE || $repiteNitExcel == FALSE || $repiteProveedor == FALSE || $repiteProveedorExcel == FALSE || $criticidadExistente == FALSE || $grupoExiste == FALSE || $metodoExiste == FALSE || $ciudadExiste == FALSE || $tipoPersonaExiste == FALSE || $tipoProveedorExiste == FALSE || $validacionNumerico == FALSE || $validacionMetodoPago == FALSE){
                       
                        if($campoNull == FALSE){ //echo 'campos vacios<br>';
                            //// cuando existe un nit
                            ?>
                                <script> 
                                     window.onload=function(){
                                   
                                        document.forms["miformulario"].submit();
                                     }
                                </script>
                                 
                                <form name="miformulario" action="../../proveedorVigente" method="POST" onsubmit="procesar(this.action);" >
                                    <input type="hidden" name="validacionExisteImportacionVacio" value="1">
                                </form> 
                            <?php
                        }
                        
                        
                        
                        
                        
                        if($validacionMetodoPago == FALSE){ //echo 'campos vacios<br>';
                            //// cuando existe un nit
                            ?>
                                <script> 
                                     window.onload=function(){
                                   
                                        document.forms["miformulario"].submit();
                                     }
                                </script>
                                 
                                <form name="miformulario" action="../../proveedorVigente" method="POST" onsubmit="procesar(this.action);" >
                                    <input type="hidden" name="validacionExisteImportacionMetodoPago" value="1">
                                </form> 
                            <?php
                        }
                        
                        if($repiteNit == FALSE){
                            //echo 'Existe el nit<br>';
                             ?>
                                <script> 
                                     window.onload=function(){
                                   
                                         document.forms["miformulario"].submit();
                                     }
                                </script>
                                 
                                <form name="miformulario" action="../../proveedorVigente" method="POST" onsubmit="procesar(this.action);" >
                                    <input type="hidden" name="validacionExisteImportacion1" value="1">
                                </form> 
                            <?php
                        }
                       
                        if($repiteNitExcel == FALSE){
                           // echo 'Se repite el nit<br>';
                            ?>
                                <script> 
                                     window.onload=function(){
                                   
                                         document.forms["miformulario"].submit();
                                     }
                                </script>
                                 
                                <form name="miformulario" action="../../proveedorVigente" method="POST" onsubmit="procesar(this.action);" >
                                    <input type="hidden" name="validacionExisteImportacion2" value="1">
                                </form> 
                            <?php
                        }
                       
                        if($repiteProveedor == FALSE){
                           //echo 'Existe proveedor<br>';
                           ?>
                                <script> 
                                     window.onload=function(){
                                   
                                         document.forms["miformulario"].submit();
                                     }
                                </script>
                                 
                                <form name="miformulario" action="../../proveedorVigente" method="POST" onsubmit="procesar(this.action);" >
                                    <input type="hidden" name="validacionExisteImportacion3" value="1">
                                </form> 
                            <?php
                        }
                        
                        if($repiteProveedorExcel == FALSE){
                           // echo 'Se repite el proveedor<br>';
                            ?>
                                <script> 
                                     window.onload=function(){
                                   
                                         document.forms["miformulario"].submit();
                                     }
                                </script>
                                 
                                <form name="miformulario" action="../../proveedorVigente" method="POST" onsubmit="procesar(this.action);" >
                                    <input type="hidden" name="validacionExisteImportacion4" value="1">
                                </form> 
                            <?php
                        }
                       
                        if($criticidadExistente == FALSE){
                            //echo 'La criticidad no existe<br>';
                            ?>
                                <script> 
                                     window.onload=function(){
                                   
                                         document.forms["miformularioCriticidad"].submit();
                                     }
                                </script>
                                 
                                <form name="miformularioCriticidad" action="../../proveedorVigente" method="POST" onsubmit="procesar(this.action);" >
                                    <input type="hidden" name="validacionExisteImportacion5" value="1">
                                </form> 
                            <?php
                        }
                        
                        if($grupoExiste == FALSE){
                            //echo 'El grupo no existe<br>';
                             ?>
                                <script> 
                                     window.onload=function(){
                                   
                                         document.forms["miformularioGrupo"].submit();
                                     }
                                </script>
                                 
                                <form name="miformularioGrupo" action="../../proveedorVigente" method="POST" onsubmit="procesar(this.action);" >
                                    <input type="hidden" name="validacionExisteImportacion6" value="1">
                                </form> 
                            <?php
                        }
                        
                        if($metodoExiste == FALSE){
                            //echo 'El metodo no existe<br>';
                             ?>
                                <script> 
                                     window.onload=function(){
                                   
                                         document.forms["miformularioMetodo"].submit();
                                     }
                                </script>
                                 
                                <form name="miformularioMetodo" action="../../proveedorVigente" method="POST" onsubmit="procesar(this.action);" >
                                    <input type="hidden" name="validacionExisteImportacion7" value="1">
                                </form> 
                            <?php
                        }
                        
                        if($ciudadExiste == FALSE){
                            //echo 'El código de la ciudad no existe<br>';
                            ?>
                                <script> 
                                     window.onload=function(){
                                   
                                         document.forms["miformulariociudad"].submit();
                                     }
                                </script>
                                 
                                <form name="miformulariociudad" action="../../proveedorVigente" method="POST" onsubmit="procesar(this.action);" >
                                    <input type="hidden" name="validacionExisteImportacion8" value="1">
                                </form> 
                            <?php
                        }
                        
                        if($tipoPersonaExiste == FALSE){
                           // echo 'El tipo de persona no existe<br>';
                            ?>
                                <script> 
                                     window.onload=function(){
                                   
                                       document.forms["miformularioTipoPersona"].submit();
                                     }
                                </script>
                                 
                                <form name="miformularioTipoPersona" action="../../proveedorVigente" method="POST" onsubmit="procesar(this.action);" >
                                    <input type="hidden" name="validacionExisteImportacion9" value="1">
                                </form> 
                            <?php
                        }
                        
                        if($tipoProveedorExiste == FALSE){
                            //echo 'El tipo de proveedor no existe<br>'; 
                             ?>
                                <script> 
                                     window.onload=function(){
                                   
                                         document.forms["miformulariotipoProveedor"].submit();
                                     }
                                </script>
                                 
                                <form name="miformulariotipoProveedor" action="../../proveedorVigente" method="POST" onsubmit="procesar(this.action);" >
                                    <input type="hidden" name="validacionExisteImportacion10" value="1">
                                </form> 
                            <?php
                        }
                        
                        if($validacionNumerico == FALSE){
                            //echo 'Está intentando ingresar letras en un campo númerico<br>'; 
                             ?>
                                <script> 
                                     window.onload=function(){
                                   
                                       document.forms["miformularioNumerico"].submit();
                                     }
                                </script>
                                 
                                <form name="miformularioNumerico" action="../../proveedorVigente" method="POST" onsubmit="procesar(this.action);" >
                                    <input type="hidden" name="validacionExisteImportacion11" value="1">
                                </form> 
                            <?php
                        }
                        
                    }else{
                      
                       
                    $usuario=$_POST['Usuario']; 
                    date_default_timezone_set('America/Bogota');
                    $fecha=date('Y-m-j');
                   
                        
            
                        if($contadorCorreos > 0){
                             "<br>Alerta";
                                ?>
                                        <script> 
                                             window.onload=function(){
                                           
                                                 document.forms["miformularioCorreo"].submit();
                                             }
                                        </script>
                                        <form name="miformularioCorreo" action="../../proveedorVigente" method="POST" onsubmit="procesar(this.action);" >
                                            <input type="hidden" name="alertaConfirmacionCorreo" value="1">
                                        </form> 
                                <?php
                                    
                        }else{
                   
                   
                       $query = "INSERT INTO proveedores (nit,razonSocial,descripcion,grupo,ciudad,direccion,telefono,contacto,email,criticidad,tipo,frecuenciaActualizacion,frecuenciaActualizacionD,tiempoEvaluacion,estado,personaNJ,tipoproveedor,realizador,movil,creacion,terminoPago)
                        VALUES('$nit','$proveedor','$actividad','$enviarIdGrupo','$enviarIdCiudad','$direccion','$telefono','$contacto','$correo','$enviarIdCriticidad','$guardarMetodo','0','$frecuenciaActualizacion','$tiempoEvaludacion','Ejecucion','$enviarPersonaTipo','$enviarIdTipoProveedor','$usuario','$movil','$fecha','$terminoPago')";
                        $resultados = mysqli_query($con, $query)or die(mysqli_error($con));
                        
                       
                        ?>
                            <script> 
                                 window.onload=function(){
                               
                                   document.forms["miformularioRegistro"].submit();
                                 }
                            </script>
                             
                            <form name="miformularioRegistro" action="../../proveedorVigente" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionExisteImportacionExito" value="1">
                            </form> 
                        <?php
                        }
                
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
    
                                                                    