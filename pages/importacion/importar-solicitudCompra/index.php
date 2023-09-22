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
        
        $productoExiste = TRUE;
        $codigoExiste = TRUE;
        $identificadorExiste = TRUE;
     
        $campoNull = TRUE;
        
        // validacion numerica
        $validacionNumerico = TRUE;
        
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
            $contador='0';
            foreach ($Reader as $Row)
            {
                $contador++;
          
                if($Row[4]=='Comentario'){ continue;} //Aca remplazo por el nombre y posicion de la ultima columna de excel para que no me agrege la primera fila.
          
                $producto = "";
                if(isset($Row[0])) {
                    $producto = mysqli_real_escape_string($con,$Row[0]);
                
                    $validacion1 = $con->query("SELECT * FROM proveedorProductos WHERE nombre = '$producto' ");
                    $num = mysqli_num_rows($validacion1);
                    
                    if($num > 0){ //echo 'existe';
                       
                    }else{
                        $productoExiste = FALSE;
                    }
                    
                    if($producto == ""){
                        $campoNull = FALSE;
                        $mensajeCampoVacio='en la columna producto';
                    }else{
                        
                    }
                }
                
                $codigo = "";
                if(isset($Row[1])) {
                    $codigo = mysqli_real_escape_string($con,$Row[1]);
                    
                    $validacion2 = $con->query("SELECT * FROM proveedorProductos WHERE codigo = '$codigo'");
                    $num2 = mysqli_num_rows($validacion2);
                    
                    if($num2 > 0){ //echo 'existe';
                     
                    }else{
                          $codigoExiste = FALSE;
                    }
                    
                    
                   
                        if($codigo == ""){
                            $campoNull = FALSE;
                            $mensajeCampoVacio='en la columna código';
                        }else{
                          
                        }
                    
                }
                
                $identificador = "";
                if(isset($Row[2])) {
                    $identificador = mysqli_real_escape_string($con,$Row[2]);
                    
                    ///// consultamos el identificador y le mandamos el id al producto para validar si existe
                    $consultaidentificadorProducto=$con->query("SELECT * FROM proveedoresProductoIdentificador WHERE grupo='$identificador' ");
                    $traerDAtosconsultaidentificadorProducto=$consultaidentificadorProducto->fetch_array(MYSQLI_ASSOC);
                    
                    $validacion3 = $con->query("SELECT * FROM proveedorProductos WHERE identificador = '".$traerDAtosconsultaidentificadorProducto['id']."' ");//$identificador
                    $num3 = mysqli_num_rows($validacion3);
                    
                    if($num3 > 0){ //echo 'existe';
                    
                        
                    }else{
                         $identificadorExiste = FALSE;
                    }
                    
                  
                    
                        if($identificador == ""){
                            $campoNull = FALSE;
                            $mensajeCampoVacio='en la columna identificador';
                        }else{
                          
                        }
                   
                }
                
                $cantidad = "";
                if(isset($Row[3])) {
                    $cantidad = mysqli_real_escape_string($con,$Row[3]);
                    if($cantidad == ""){
                        $campoNull = FALSE;
                        $mensajeCampoVacio='en la columna cantidad';
                    }
                    
                    if(is_numeric($cantidad)){
                        
                    }else{
                        $validacionNumerico=FALSE;
                    }
                }
                
                $comentario = "";
                if(isset($Row[4])) {
                    $comentario = mysqli_real_escape_string($con,$Row[4]);
                  
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
                                         
                                        <form name="miformularioV" action="../../registroProductos" method="POST" onsubmit="procesar(this.action);" >
                                            <input type="hidden" name="mensajeEnviarCampoVacio" value="<?php echo $mensajeCampoVacio;?>">
                                            <input name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra']; ?>" type="hidden">
                                            <input type="hidden" name="validacionExisteImportacionVacio" value="1">
                                        </form> 
                                <?php
            }
            // END
        
        
         }
         
         
         
         
         
         
         for($i=0;$i<$sheetCount;$i++)
         {
            
            $Reader->ChangeSheet($i);
         
            
            foreach ($Reader as $Row)
            {
             
               
                if($Row[4]=='Comentario'){ continue;} //Aca remplazo por el nombre y posicion de la ultima columna de excel para que no me agrege la primera fila.
          
                $producto = "";
                if(isset($Row[0])) {
                    $producto = mysqli_real_escape_string($con,$Row[0]);
                   
                   
                     
                    $validacion1 = $con->query("SELECT * FROM proveedorProductos WHERE nombre = '$producto'");
                    $extraerDatos=$validacion1->fetch_array(MYSQLI_ASSOC);
                    $idProducto=$extraerDatos['id'];
                    $num = mysqli_num_rows($validacion1);
                    
                    if($num > 0){ 
                      
                    }else{
                         $productoExiste = FALSE;
                    }
                    
                    if($producto == ""){ 
                        $campoNull = FALSE;
                    }else{
                      
                    }
                    //echo $producto; echo '<br>';
                }
                
                $codigo = "";
                if(isset($Row[1])) {
                    $codigo = mysqli_real_escape_string($con,$Row[1]);
                    
                    $validacion2 = $con->query("SELECT * FROM proveedorProductos WHERE codigo = '$codigo'");
                    $extraerDatos=$validacion2->fetch_array(MYSQLI_ASSOC);
                    $num2 = mysqli_num_rows($validacion2);
                    
                    if($num2 > 0){ //echo 'existe';
                      
                    }else{
                         $codigoExiste = FALSE;
                    }
                    
                    if($codigo == ""){ 
                        $campoNull = FALSE;
                    }else{
                      
                    }
                     //echo $codigo; echo '<br>';
                }
                
                $identificador = "";
                if(isset($Row[2])) {
                    $identificador = mysqli_real_escape_string($con,$Row[2]);
                    
                      ///// consultamos el identificador y le mandamos el id al producto para validar si existe
                    $consultaidentificadorProducto=$con->query("SELECT * FROM proveedoresProductoIdentificador WHERE grupo='$identificador' ");
                    $traerDAtosconsultaidentificadorProducto=$consultaidentificadorProducto->fetch_array(MYSQLI_ASSOC);
                    
                    $validacion3 = $con->query("SELECT * FROM proveedorProductos WHERE identificador = '".$traerDAtosconsultaidentificadorProducto['id']."' ");
                    //$validacion3 = $con->query("SELECT * FROM proveedorProductos WHERE identificador = '$identificador' ");
                    $extraerDatos=$validacion3->fetch_array(MYSQLI_ASSOC);
                    $num3 = mysqli_num_rows($validacion3);
                    
                    if($num3 > 0){ //echo 'existe';
                      
                    }else{
                          $identificadorExiste = FALSE;
                    }
                    
                    if($identificador == ""){  
                        $campoNull = FALSE;
                    }else{
                      
                       
                    }
                    // echo $identificador; echo '<br>';
                }
                
                $cantidad = "";
                if(isset($Row[3])) {
                    $cantidad = mysqli_real_escape_string($con,$Row[3]);
                    if($cantidad == ""){   
                        $campoNull = FALSE;
                    }
                    
                    if(is_numeric($cantidad)){
                        
                    }else{
                        $validacionNumerico=FALSE;
                    }
                }
                
                $comentario = "";
                if(isset($Row[4])) {
                    $comentario = mysqli_real_escape_string($con,$Row[4]);
                   
                }
                
                
           
                
               
              
                    
                    if($productoExiste == FALSE || $codigoExiste == FALSE || $identificadorExiste == FALSE || $campoNull == FALSE || $validacionNumerico == FALSE){
                         
                        if($campoNull == FALSE){ 
                     
                            ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformulario"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformulario" action="../../registroProductos" method="POST" onsubmit="procesar(this.action);" >
                                          <input name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra']; ?>" type="hidden">
                                        <input type="hidden" name="validacionExisteImportacionVacio" value="1">
                                    </form> 
                            <?php
                        }
                       
                        if($productoExiste == FALSE){
                     
                            ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformulario"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformulario" action="../../registroProductos" method="POST" onsubmit="procesar(this.action);" >
                                          <input name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra']; ?>" type="hidden">
                                        <input type="hidden" name="validacionProductoExiste" value="1">
                                    </form> 
                            <?php
                        }

                        if($codigoExiste == FALSE){
                         
                               ?>
                                       <script> 
                                            window.onload=function(){
                                          
                                                document.forms["miformulario"].submit();
                                            }
                                       </script>
                                        
                                       <form name="miformulario" action="../../registroProductos" method="POST" onsubmit="procesar(this.action);" >
                                             <input name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra']; ?>" type="hidden">
                                           <input type="hidden" name="validacionCodigoExiste" value="1">
                                       </form> 
                               <?php
                           }
                           if($identificadorExiste == FALSE){
                          
                               ?>
                                       <script> 
                                            window.onload=function(){
                                          
                                                document.forms["miformulario"].submit();
                                            }
                                       </script>
                                        
                                       <form name="miformulario" action="../../registroProductos" method="POST" onsubmit="procesar(this.action);" >
                                           <input name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra']; ?>" type="hidden">
                                           <input type="hidden" name="validacionIdentificadorExiste" value="1">
                                       </form> 
                               <?php
                           }
                           
                           if($validacionNumerico == FALSE){
                          
                               ?>
                                       <script> 
                                            window.onload=function(){
                                          
                                                document.forms["miformulario"].submit();
                                            }
                                       </script>
                                        
                                       <form name="miformulario" action="../../registroProductos" method="POST" onsubmit="procesar(this.action);" >
                                           <input name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra']; ?>" type="hidden">
                                           <input type="hidden" name="validacionNumericoExiste" value="1">
                                       </form> 
                               <?php
                           }
                           
                        
                        $type = "error";
                        $message = "ERROR";
                        
                    }else{
                        
                        // validamos que el producto ya exista dentro del alistamiento para sumar la cantidad de productos 
                        'Sale: '.$idProducto; 
                        '<br>Cantidad entrante: '.$cantidad;
                        $consultamos=$con->query("SELECT * FROM solicitudAlistamiento WHERE idSolicitud='".$_POST['idOrdenCompra']."' AND idProducto='$idProducto' ");
                        $extraerConsulta=$consultamos->fetch_array(MYSQLI_ASSOC);
                        '<br>Existencia: '.$validacionExistenciaProducto=$extraerConsulta['idProducto'];
                        '<br>cantidad existente: '.$validacionExistenciaCantidad=$extraerConsulta['cantidad'];
                        // end
                        
                            
                        if($validacionExistenciaProducto != NULL){
                            $sumandoCantidad=$validacionExistenciaCantidad+$cantidad;
                              
                            $query = "UPDATE solicitudAlistamiento SET cantidad='$sumandoCantidad', comentario='$comentario' WHERE idSolicitud='".$_POST['idOrdenCompra']."' AND idProducto='$idProducto' ";
                            $resultados = mysqli_query($con, $query); 
                             
                        }  else{
                           
                              
                            $query = "INSERT INTO  solicitudAlistamiento(idSolicitud,idProducto,cantidad,comentario)
                            values('".$_POST['idOrdenCompra']."','".$idProducto."','".$cantidad."','$comentario')";
                            $resultados = mysqli_query($con, $query); 
                            
                        }
                         
                        
                        
                        ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../registroProductos" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionAgregar" value="1">
                                 <input name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra']; ?>" type="hidden">
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
    
    
        if(!empty($message)) {  
          ?>  
                                                                    <script>
                                                                        window.onload=function(){
                                                                      
                                                                          document.forms["miformulario"].submit();
                                                                        }
                                                                        </script>
                                                                    
                                                                    <form name="miformulario" action="../../registroProductos" method="POST" onsubmit="procesar(this.action);" >
                                                                        <input style="visibility:hidden" readonly type="text" name="mensaje" value="<?php echo $message; ?>">
                                                                        
                                                                        
                                                                    </form>
             <?php 
        
            } 
    ?>
    
                                                                    