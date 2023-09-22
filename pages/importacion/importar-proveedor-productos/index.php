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
                    if($tipoProducto == ""){ 
                        $campoVacio=FALSE;
                        $mensajeCampoVacio='en la columna tipo de producto';
                    }else{
                         $tipoProducto = ucwords(strtolower($tipoProducto));
                        
                        if($tipoProducto == 'Bienes' || $tipoProducto == 'Servicios' || $tipoProducto == 'Bien' || $tipoProducto == 'Servicio'){
                            if($tipoProducto == 'Bienes' || $tipoProducto == 'Bien'){
                                $tipoProductoEnviar='1';
                            }else{
                                $tipoProductoEnviar='2';
                            }
                        }else{
                            $tipoProductoExistenca=FALSE;
                        }
                    }
                }
                
                $nombre = "";
                if(isset($Row[1])) {
                    $nombre = mysqli_real_escape_string($con,$Row[1]);
                    $nombre=trim($nombre);
                    
                   
                    
                    if($nombre == ""){ 
                        $campoVacio=FALSE;
                        $mensajeCampoVacio='en la columna nombre del bien o servicio';
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
                       
                       
                        $validacionA = $con->query("SELECT * FROM proveedorProductos WHERE nombre = '$nombre'  ");
                        $numA = mysqli_num_rows($validacionA);
                        
                        if($numA > 0){ 
                            //si el nombre está repetido se pone falso 
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
                    if($descripcion == ""){
                        $campoVacio=FALSE;
                         $mensajeCampoVacio='en la columna descripción';
                    }
                }
                
                $grupo = "";
                if(isset($Row[3])) {
                    $grupo = mysqli_real_escape_string($con,$Row[3]);
                     '<br>'.$grupo=trim($grupo);
                    if($grupo == ""){ 
                        $campoVacio=FALSE;
                         $mensajeCampoVacio='en la columna grupo y subgrupo';
                    }
                    
                    $validacionGrupo = $con->query("SELECT * FROM proveedoresProductoGrupo WHERE id = '$grupo'  ");
                    $numGrupo = mysqli_num_rows($validacionGrupo);
                    
                    if($numGrupo > 0){
                        //si el nombre está repetido se pone falso 
                        $grupoExiste = TRUE;
                    }else{
                        $grupoExiste = FALSE;
                    }
                    
                }
                
                $codigo = "";
                if(isset($Row[4])) {
                    $codigo = mysqli_real_escape_string($con,$Row[4]);
                     '<br>'.$codigo=trim($codigo);
                    if($codigo == ""){ 
                        $campoVacio=FALSE;
                         $mensajeCampoVacio='en la columna código';
                    }else{
                        
                        
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
                    if($identificador == ""){ 
                        $campoVacio=FALSE;
                         $mensajeCampoVacio='en la columna identificador';
                    }else{
                        
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
                    if($impuesto == ""){ 
                        $campoVacio=FALSE;
                         $mensajeCampoVacio='en la columna impuesto';
                    }
                    
                    
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
                    }else{
                        $impuestoExiste = FALSE;
                    }
                }
                
                $unidaddeEmpaque = "";
                if(isset($Row[7])) {
                    $unidaddeEmpaque = mysqli_real_escape_string($con,$Row[7]);
                     '<br>'.$unidaddeEmpaque=trim($unidaddeEmpaque);
                    
                    if($tipoProductoEnviar == 1){ //$tipoProducto == 'Bienes'
                        if($unidaddeEmpaque == ""){ 
                            $campoVacio=FALSE;
                             $mensajeCampoVacio='en la columna unidad de empaque';
                        }else{
                             $unidaddeEmpaque=($unidaddeEmpaque);
                             
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
                     '<br>'.$unidaddeMedida=trim($unidaddeMedida);
                    
                    if($tipoProductoEnviar == 1){//if($tipoProducto == 'Bienes'){ 
                        if($unidaddeMedida == ""){ 
                            $campoVacio=FALSE;
                             $mensajeCampoVacio='en la columna unidad de medida';
                        }else{
                            $unidaddeMedida=($unidaddeMedida);
                            
                            
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
                     '<br>'.$proveedor=trim($proveedor);
                     
                    if($tipoProductoEnviar == 2){
                            if($proveedor == ""){
                                 'Viene vacio: '.$proveedorEnviar='0';  '<br>';
                            }else{
                                
                                
                                $array = explode(' ',$proveedor);  // convierte en array separa por espacios;
                                $proveedor ='';
                                // quita los campos vacios y pone un solo espacio
                                for ($i=0; $i < count($array); $i++) { 
                                    if(strlen($array[$i])>0) {
                                        $proveedor.= ' ' . $array[$i];
                                    }
                                }
                                
                                $proveedor=trim($proveedor);
                                
                                $validacionProveedor = $con->query("SELECT * FROM proveedores WHERE razonSocial = '$proveedor'  ");
                                $extraerProveedor=$validacionProveedor->fetch_array(MYSQLI_ASSOC);
                                $numUnidadProveedor = mysqli_num_rows($validacionProveedor);
                                 
                                if($numUnidadProveedor > 0){
                                    // si el proveedor existe envia el dato
                                    $proveedorExiste = TRUE;
                                     'existe: '.$proveedorEnviar=$extraerProveedor['id'];  '<br>';
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
                    
                    
                     if($tipoProductoEnviar == 1){//if($tipoProducto == 'Bienes'){ 
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
                                $inventarioExiste=FALSE;
                            }
                        }
                     }
                }
                
                $activo = "";
                if(isset($Row[11])) {
                    $activo = mysqli_real_escape_string($con,$Row[11]);
                     '<br>'.$activo=trim($activo);
                    
                    if($tipoProductoEnviar == 1){//if($tipoProducto == 'Bienes'){ 
                        if($activo == ""){ 
                            $campoVacio=FALSE;
                            $mensajeCampoVacio='en la columna activo';
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
                        
                    }
                }
                
                
                $tiempoServicio = "";
                if(isset($Row[12])) {
                    $tiempoServicio = mysqli_real_escape_string($con,$Row[12]);
                     '<br>'.$tiempoServicio=trim($tiempoServicio);
                    
                    if($tipoProductoEnviar == 2){//if($tipoProducto == 'Servicios'){ 
                        
                        if($tiempoServicio == ""){
                            $campoVacio=FALSE;
                             $mensajeCampoVacio='en la columna tiempo de servicio';
                        }else{
                            
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
                    if($tipoProductoEnviar == 2){
                        if($cantidadServicio == ""){ 
                                $campoVacio=FALSE;
                                 $mensajeCampoVacio='en la columna cantidad de tiempo de servicio';
                        }else{
                            if(is_numeric($cantidadServicio)){
                                    
                            }else{  
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
                       $tipoProducto = ucwords(strtolower($tipoProducto));
                        
                        if($tipoProducto == 'Bienes' || $tipoProducto == 'Servicios' || $tipoProducto == 'Bien' || $tipoProducto == 'Servicio'){
                            if($tipoProducto == 'Bienes' || $tipoProducto == 'Bien'){
                                $tipoProductoEnviar='1';
                            }else{
                                $tipoProductoEnviar='2';
                            }
                        }else{
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
                    $inventario=trim($inventario);
                    
                     if($tipoProductoEnviar == 1){//if($tipoProducto == 'Bienes'){ 
                        if($inventario == ""){ 
                            $campoVacio=FALSE;
                        }else{
                            if($inventario == 'si' || $inventario == 'Si' || $inventario == 'SI' || $inventario == 'sI' ){
                                $inventarioEnviar='Si';
                                $inventarioExiste=TRUE;
                            }elseif($inventario == 'no' || $inventario == 'No' || $inventario == 'NO' || $inventario == 'nO'){
                                $inventarioEnviar='No';
                                $inventarioExiste=TRUE;
                            }else{
                                $inventarioExiste=FALSE;
                            }
                        }
                     }else{
                         $inventarioEnviar='';
                     }
                     
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
                    
                    if($tipoProductoEnviar == 2){//if($tipoProducto == 'Servicios'){ 
                        
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
                    
                    if($validacionNumerico == FALSE || $noExisteTiempoServicio == FALSE || $campoVacio == FALSE || $nombreExiste == FALSE || $repiteNombreExcel == FALSE || $codigoExiste == FALSE || $repiteCodigoExcel == FALSE || $identificadorExiste == FALSE || $repiteIdentificadorExcel == FALSE || $tipoProductoExistenca == FALSE || $unidadEmpaqueExiste == FALSE || $impuestoExiste == FALSE || $grupoExiste == FALSE || $proveedorExiste == FALSE || $inventarioExiste == FALSE || $activoExiste == FALSE || $unidadUnidadExiste == FALSE){
                      
                       '<br>Validaciones<br>'; 
                      
                      if($campoVacio == FALSE){ 
                           $validacionVacioa='1';
                          // echo '<br>Campo vacio';
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
                         // echo '<br>Campo vacio2';
                          //echo ' -- conteo campo vacio2: '.$contadorCampoVaio2='1';
                          ?>
                                <script>
                                        window.onload=function(){
                                            document.forms["miformularioTiempoServicio"].submit();
                                            }
                                </script>
                                <form name="miformularioTiempoServicio" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                                   <input type="hidden" name="validacionExisteImportacionTipoServicio" value="1">
                                </form>
                                
                            <?php
                      }
                      
                      if($validacionNumerico == FALSE){
                          $validacionNumericoIdentificar='1';
                          //  echo 'Está intentando ingresar letras en un campo númerico<br>'; 
                             ?>
                                <script> 
                                     window.onload=function(){
                                   
                                       document.forms["miformularioNumerico"].submit();
                                     }
                                </script>
                                 
                                <form name="miformularioNumerico" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                                    <input type="hidden" name="validacionExisteNumerio" value="1">
                                </form> 
                            <?php
                        }
                        
                      
                      if($nombreExiste == FALSE){
                          $validacionNombreExiste='1';
                         // echo '<br>El nombre ya existe';
                           ?>
                                <script>
                                        window.onload=function(){
                                            document.forms["miformularioNombreE"].submit();
                                            }
                                </script>
                                <form name="miformularioNombreE" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                                   <input type="hidden" name="validacionExisteImportacion1" value="1">
                                </form>
                                
                            <?php
                      }
                      
                      if($repiteNombreExcel == FALSE){
                          $validacionNombreRepitente='1';
                          //echo '<br>El nombre está repetido en el documento';
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
                         // echo '<br>el código ya existe';
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
                          //echo '<br>El código está repetido en el documento';
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
                        // echo '<br>El identificador ya existe';
                           ?>
                                <script>
                                        window.onload=function(){
                                            document.forms["miformularioIndetificador"].submit();
                                            }
                                </script>
                                <form name="miformularioIndetificador" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                                   <input type="hidden" name="validacionExisteImportacion5" value="1">
                                </form>
                                
                            <?php
                      }
                      
                      if($repiteIdentificadorExcel == FALSE){
                           $validacionIdentificadorRepite='1';
                         // echo '<br>El identificador está repetido en el documento';
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
                         // echo '<br>El impuesto no existe';
                            ?>
                                <script>
                                        window.onload=function(){
                                            document.forms["miformularioImpuesto"].submit();
                                            }
                                </script>
                                <form name="miformularioImpuesto" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                                   <input type="hidden" name="validacionExisteImportacion7" value="1">
                                </form>
                                
                            <?php
                      }  
                      
                      if($grupoExiste == FALSE){
                          $validacionGrupoExiste='1';
                          //echo '<br>El grupo no existe';
                         ?>
                                <script>
                                        window.onload=function(){
                                            document.forms["miformularioGrupo"].submit();
                                            }
                                </script>
                                <form name="miformularioGrupo" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                                   <input type="hidden" name="validacionExisteImportacion8" value="1">
                                </form>
                                
                            <?php
                      }
                        
                        
                      if($tipoProductoExistenca == FALSE){
                          $validacionTipoProductoExistecia='1';
                          //echo '<br>Está ingresando un tipo de servicio no autorizado';
                          ?>
                                <script>
                                        window.onload=function(){
                                            document.forms["miformularioTipoProducto"].submit();
                                            }
                                </script>
                                <form name="miformularioTipoProducto" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                                   <input type="hidden" name="validacionExisteImportacion9" value="1">
                                </form>
                                
                            <?php
                      }
                      
                      if($unidadEmpaqueExiste == FALSE){
                          $validacionEmpaqueExiste='1';
                          //echo '<br>La unidad de empaque no existe';
                         ?>
                                <script>
                                        window.onload=function(){
                                            document.forms["miformularioUnidadEmpque"].submit();
                                            }
                                </script>
                                <form name="miformularioUnidadEmpque" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                                   <input type="hidden" name="validacionExisteImportacion10" value="1">
                                </form>
                                
                            <?php
                      }
                      
                      if($proveedorExiste == FALSE){
                          $validacionProveedorExiste='1';
                          //echo '<br>El proveedor no existe';
                            ?>
                                <script>
                                        window.onload=function(){
                                            document.forms["miformularioProveedor"].submit();
                                            }
                                </script>
                                <form name="miformularioProveedor" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                                   <input type="hidden" name="validacionExisteImportacion11" value="1">
                                </form>
                                
                            <?php
                      }
                      
                      if($inventarioExiste == FALSE){
                          $validacionInventarioExiste='1';
                         // echo '<br>La respuesta del inventario no es la correcta';
                           ?>
                                <script>
                                        window.onload=function(){
                                            document.forms["miformularioInvetnatrio"].submit();
                                            }
                                </script>
                                <form name="miformularioInvetnatrio" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                                   <input type="hidden" name="validacionExisteImportacion12" value="1">
                                </form>
                                
                            <?php
                      }
                      
                      if($activoExiste == FALSE){
                          $validacionActivoExiste='1';
                          //echo '<br>La respuesta del activo no es la correcta';
                         ?>
                                <script>
                                        window.onload=function(){
                                            document.forms["miformularioActivo"].submit();
                                            }
                                </script>
                                <form name="miformularioActivo" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                                   <input type="hidden" name="validacionExisteImportacion13" value="1">
                                </form>
                                
                            <?php
                      }
                    
                      if($unidadUnidadExiste == FALSE){
                          $validacionUnidadExiste='1';
                          //echo '<br>La unidad de medida no existe';
                          ?>
                                <script>
                                        window.onload=function(){
                                            document.forms["miformularioUnidadMedida"].submit();
                                            }
                                </script>
                                <form name="miformularioUnidadMedida" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                                   <input type="hidden" name="validacionExisteImportacion14" value="1">
                                </form>
                                
                            <?php
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
                       '<br>alerta: '.$alertaAlgunaActivada=$validacionVacioa+$validacionVaciob+$validacionNumericoIdentificar+$validacionNombreExiste+$validacionNombreRepitente+$validacionCodigoExiste+$validacionCodigoRepite+$validacionIdentificadorExiste+$validacionIdentificadorRepite+$validacionImpuestoExiste+$validacionGrupoExiste+$validacionTipoProductoExistecia+$validacionEmpaqueExiste+$validacionProveedorExiste+$validacionInventarioExiste+$validacionActivoExiste+$validacionUnidadExiste;
                       
                       if($alertaAlgunaActivada > 0){
                          // echo 'activa alerta';
                       }else{ 
                           
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


?>
    
                                                                    