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
        $validarTipo = TRUE;
        
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
            
            foreach ($Reader as $Row)
            {
          
                if($Row[1]=='Tipo'){ continue;} //Aca remplazo por el nombre y posicion de la ultima columna de excel para que no me agrege la primera fila.
          
                $nombre = "";
                if(isset($Row[0])) {
                    $nombre = mysqli_real_escape_string($con,$Row[0]);
                    //echo $nombre;
                     $nombre=str_replace('  ', ' ', $nombre);
                    $validacion1 = $con->query("SELECT * FROM documentoExterno WHERE nombre = '$nombre'");
                    $num = mysqli_num_rows($validacion1);
                    
                    if($num > 0){ //echo 'existe';
                        //si el nombre está repetido se pone falso 
                        $nombreDefinicion = FALSE;
                    }
                    
                    if($nombre == ""){
                        $campoNull = FALSE;
                        $mensajeCampoVacio='en la columna nombre';
                    }else{
                        array_push($arrayNombre,$nombre);
                    }
                }
                
                $tipo = "";
                if(isset($Row[1])) {
                    $tipo = mysqli_real_escape_string($con,$Row[1]);
                    
                    if($tipo == ""){
                        $campoNull = FALSE;
                        $mensajeCampoVacio='en la columna tipo de documento';
                    }
                    $tipo=str_replace('  ', ' ', $tipo);
                    $validacionCargo = $con->query("SELECT * FROM documentoExternoTipo WHERE nombre = '$tipo'");
                    $extraerNombreCargo=$validacionCargo->fetch_array(MYSQLI_ASSOC);
                    $numCargo = mysqli_num_rows($validacionCargo);
                    
                    if($extraerNombreCargo['id'] != NULL){
                       $guardarID=$extraerNombreCargo['id']; 
                    }else{
                    
                        ' Nombre cargo: '.$cargo.' -- <font color = "RED">Este cargo no existe en el sistema.</font> ';
                        '<br>';
                    }
                    if($numCargo <= 0){
                        //si el nombre está repetido se pone falso 
                        $validarTipo = FALSE;
                    }
                }
            
                
                $validarArchivo = "";
                if(isset($Row[3])) {
                    $validarArchivo = mysqli_real_escape_string($con,$Row[2]);
                }
                
			
             }
        
         }
         
         
         
                    if(count($arrayNombre) > count(array_unique($arrayNombre))){//Valido si hay seriales repetidos
                      $repiteNombre = FALSE;
                    }
         
         
         
         for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
            
            foreach ($Reader as $Row)
            {
          
                if($Row[1]=='Tipo'){ continue;} //Aca remplazo por el nombre y posicion de la ultima columna de excel para que no me agrege la primera fila.
          
                $nombre = "";
                if(isset($Row[0])) {
                    $nombre = mysqli_real_escape_string($con,$Row[0]);
                }
                
                $tipo = "";
                if(isset($Row[1])) {
                    $tipo = mysqli_real_escape_string($con,$Row[1]);
                    $tipo=str_replace('  ', ' ', $tipo);
                    $validacionCargo = $con->query("SELECT * FROM documentoExternoTipo WHERE nombre = '$tipo'");
                    $extraerNombreCargo=$validacionCargo->fetch_array(MYSQLI_ASSOC);
                    $numCargo = mysqli_num_rows($validacionCargo);
                    
                    if($extraerNombreCargo['id'] != NULL){
                       $guardarID=$extraerNombreCargo['id']; 
                    }else{
                    
                        ' Nombre cargo: '.$cargo.' -- <font color = "RED">Este cargo no existe en el sistema.</font> ';
                        '<br>';
                    }
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
                                     
                                    <form name="miformulario" action="../../documentoExterno" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionExisteImportacion" value="1">
                                    </form> 
                            <?php
				}else{
				
                
                
                if (!empty($nombre) ||  !empty($definicion)  ) { 
                    
                    if($nombreDefinicion == FALSE || $validarTipo == FALSE || $repiteNombre == FALSE || $campoNull == FALSE){
                        
                        
                        if($campoNull == FALSE){
                            ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformulario"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformulario" action="../../documentoExterno" method="POST" onsubmit="procesar(this.action);" >
                                         <input type="hidden" name="mensajeEnviarCampoVacio" value="<?php echo $mensajeCampoVacio;?>">
                                        <input type="hidden" name="validacionExisteImportacionVacio" value="1">
                                    </form> 
                            <?php
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
                                     
                                    <form name="miformulario" action="../../documentoExterno" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionExisteE" value="1">
                                    </form> 
                            <?php
                        }
                         if($nombreDefinicion == FALSE){
                         //echo '<script language="javascript">alert("Algunos nombres están repetidos en el documento ");
                            //window.location.href="../../definicion"</script>';
                            ?>
                                    <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformulario"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformulario" action="../../documentoExterno" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionExiste" value="1">
                                    </form> 
                            <?php
                        }

                        if($validarTipo == FALSE){
                            //echo '<script language="javascript">alert("Algunos nombres están repetidos en el documento ");
                               //window.location.href="../../definicion"</script>';
                               ?>
                                       <script> 
                                            window.onload=function(){
                                          
                                                document.forms["miformulario"].submit();
                                            }
                                       </script>
                                        
                                       <form name="miformulario" action="../../documentoExterno" method="POST" onsubmit="procesar(this.action);" >
                                           <input type="hidden" name="validacionExisteImportacionB" value="1">
                                       </form> 
                               <?php
                           }
                        
                        $type = "error";
                        $message = "ERROR";
                        
                    }else{
                        
                        
                        
                            $query = "insert into documentoExterno(nombre,tipo)
                            values('".$nombre."','".$guardarID."')";
                            $resultados = mysqli_query($con, $query); 
                            
                       
                        
                        ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../documentoExterno" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionAgregar" value="1">
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
    
    
      /*  if(!empty($message)) {  
          ?>  
                                                                    <script>
                                                                        window.onload=function(){
                                                                      
                                                                          document.forms["miformulario"].submit();
                                                                        }
                                                                        </script>
                                                                    
                                                                    <form name="miformulario" action="../../definicion" method="POST" onsubmit="procesar(this.action);" >
                                                                        <input style="visibility:hidden" readonly type="text" name="mensaje" value="<?php echo $message; ?>">
                                                                        
                                                                        
                                                                    </form>
             <?php 
        
            } */
    ?>
    
                                                                    