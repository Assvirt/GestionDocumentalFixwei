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
        
        $nombreMacroproceso = TRUE;
        $ordenMacroproceso = TRUE;
        
        $campoNull = TRUE;
        $arrayNombres = array();
        //$arrayNombresCaracteres = array();
        $repiteNombre = TRUE;
        //$validandoCAtacteres=1;
        
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
            $contador=0;
            foreach ($Reader as $Row)
            {
                $contador++;
          
                if($Row[1]=='Descripción'){ continue; } //Aca remplazo por el nombre y posicion de la ultima columna de excel para que no me agrege la primera fila.
          
                $nombre = "";
                if(isset($Row[0])) {
                    $nombre = mysqli_real_escape_string($con,$Row[0]);
                    $nombre=trim($nombre);
                    $nombre = ucwords(strtolower($nombre));
                     
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
                        
                         $validacion1 = $con->query("SELECT * FROM macroproceso WHERE nombre = '$nombre'");
                         $conocerDatos=$validacion1->fetch_array(MYSQLI_ASSOC);
                         //echo 'Dato: '.$conocerDatos['nombre'];
                         $num = mysqli_num_rows($validacion1);
                         
                         if($num > 0){ 
                             //si el nombre está repetido se pone falso 
                             $nombreMacroproceso = FALSE;
                         }
                        
                        
                             array_push($arrayNombres,$nombre);
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


               
                
                
                
                
                
				
             }
             
             
              // aca validamos que le documento viene vacio
            if($contador == 1){
                ?>
                                        <script> 
                                             window.onload=function(){
                                           
                                                document.forms["miformularioV"].submit();
                                             }
                                        </script>
                                         
                                        <form name="miformularioV" action="../../macroproceso" method="POST" onsubmit="procesar(this.action);" >
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


             
             
             
             
    for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
           
            foreach ($Reader as $Row)
            {
           
                if($Row[1]=='Descripción'){ continue;} //Aca remplazo por el nombre y posicion de la ultima columna de excel para que no me agrege la primera fila.
          
                $nombre = "";
                if(isset($Row[0])) {
                     $nombre = mysqli_real_escape_string($con,$Row[0]);  
                        
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
                     $descripcion = mysqli_real_escape_string($con,$Row[1]);  '<br>';
                }
                
                
               
                
                $validarArchivo = "";
                if(isset($Row[2])) {
                    $validarArchivo = mysqli_real_escape_string($con,$Row[2]);
                }
                              
                              
                if($validarArchivo != NULL){ // evitamos subir un archivo diferente
                ?>
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformulario"].submit();
                         }
                    </script>
                     
                    <form name="miformulario" action="../../macroproceso" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="validacionExisteImportacion" value="1">
                    </form> 
                <?php
                
				}else{				    
                				    
                				  //echo 'ah: '. $validandoCAtacteres;
                				    
                				
                                        if (!empty($nombre) || !empty($descripcion) ) { 
                                            if($repiteNombre == FALSE || $nombreMacroproceso == FALSE || $campoNull == FALSE){ 
                                                if($campoNull == FALSE){
                                                    //echo '<script language="javascript">alert("Algunos macroproceso están repetidos en el documento");
                                                    //window.location.href="../../macroproceso"</script>';
                                                    ?>
                                                            <script> 
                                                                 window.onload=function(){
                                                               
                                                                     document.forms["miformulario"].submit();
                                                                 }
                                                            </script>
                                                             
                                                            <form name="miformulario" action="../../macroproceso" method="POST" onsubmit="procesar(this.action);" >
                                                                <input type="hidden" name="mensajeEnviarCampoVacio" value="<?php echo $mensajeCampoVacio;?>">
                                                                <input type="hidden" name="validacionExisteImportacionVacio" value="1">
                                                            </form> 
                                                    <?php
                                                }
                                                if($repiteNombre == FALSE){
                                                    //echo '<script language="javascript">alert("Algunos macroproceso están repetidos en el documento");
                                                    //window.location.href="../../macroproceso"</script>';
                                                    ?>
                                                            <script> 
                                                                 window.onload=function(){
                                                               
                                                                     document.forms["miformulario"].submit();
                                                                 }
                                                            </script>
                                                             
                                                            <form name="miformulario" action="../../macroproceso" method="POST" onsubmit="procesar(this.action);" >
                                                                <input type="hidden" name="validacionExisteImportacionB" value="1">
                                                            </form> 
                                                    <?php
                                                }
                                                if($nombreMacroproceso == FALSE){ 
                                                    //echo '<script language="javascript">alert("El nombre del macroproceso ya existe");
                                                    //window.location.href="../../macroproceso"</script>';
                                                    ?>
                                                            <script> 
                                                                 window.onload=function(){
                                                               
                                                                     document.forms["miformulario"].submit();
                                                                 }
                                                            </script>
                                                             
                                                            <form name="miformulario" action="../../macroproceso" method="POST" onsubmit="procesar(this.action);" >
                                                                <input type="hidden" name="validacionExisteImportacionC" value="1">
                                                            </form> 
                                                    <?php
                                                }
                                                
                                                
                                                $type = "error";
                                                $message = "ERROR";
                                                
                                            }else{
                                                
                                              
                                                    
                                                    $query = "insert into macroproceso(nombre,descripcion,estilo)
                                                    values('$nombre','$descripcion','1')";
                                                    $resultados = mysqli_query($con, $query);
                                                    
                                                    //echo '<script language="javascript">alert("Excel importado correctamente");
                                                    //window.location.href="../../macroproceso"</script>';
                                                    ?>
                                                        <script> 
                                                             window.onload=function(){
                                                           
                                                                 document.forms["miformulario"].submit();
                                                             }
                                                        </script>
                                                         
                                                        <form name="miformulario" action="../../macroproceso" method="POST" onsubmit="procesar(this.action);" >
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
                                                                    
                                                                    <form name="miformulario" action="../../macroproceso" method="POST" onsubmit="procesar(this.action);" >
                                                                        <input style="visibility:hidden" readonly type="text" name="mensaje" value="<?php echo $message; ?>">
                                                                        
                                                                        
                                                                    </form>
             <?php 
        
            }
            
            
            $subject = $nombre;
                    $capturandoCaracteres=str_replace(array('<', '>','*','/','+','#','$','%','&','||','(',')','"',"'",'[',']','{','}','@','-','_'), array('1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1'), $subject);
                    
                    $findme1  = '1';
                    $findme2   = '1';
                    $findme3   = '1';
                    $findme4   = '1';
                    $findme5   = '1';
    
                    $findme6   = '1';
                    $findme7   = '1';
                    $findme8   = '1';
                    $findme9   = '1';
                    $findme10   = '1';
    
                    $findme11  = '1';
                    $findme12   = '1';
                    $findme13   = '1';
                    $findme14   = '1';
                    $findme15   = '1';
    
                    $findme16  = '1';
                    $findme17   = '1';
                    $findme18   = '1';
                    $findme19   = '1';
                    $findme20   = '1';
    
                    $findme21   = '1';
                    
    
                    $pos1 = strpos($capturandoCaracteres, $findme1);
                    $pos2 = strpos($capturandoCaracteres, $findme2);
                    $pos3 = strpos($capturandoCaracteres, $findme3);
                    $pos4 = strpos($capturandoCaracteres, $findme4);
                    $pos5 = strpos($capturandoCaracteres, $findme5);
    
                    $pos6 = strpos($capturandoCaracteres, $findme6);
                    $pos7 = strpos($capturandoCaracteres, $findme7);
                    $pos8 = strpos($capturandoCaracteres, $findme8);
                    $pos9 = strpos($capturandoCaracteres, $findme9);
                    $pos10 = strpos($capturandoCaracteres, $findme10);
    
                    $pos11 = strpos($capturandoCaracteres, $findme11);
                    $pos12 = strpos($capturandoCaracteres, $findme12);
                    $pos13 = strpos($capturandoCaracteres, $findme13);
                    $pos14 = strpos($capturandoCaracteres, $findme14);
                    $pos15 = strpos($capturandoCaracteres, $findme15);
    
                    $pos16 = strpos($capturandoCaracteres, $findme16);
                    $pos17 = strpos($capturandoCaracteres, $findme17);
                    $pos18 = strpos($capturandoCaracteres, $findme18);
                    $pos19 = strpos($capturandoCaracteres, $findme19);
                    $pos20 = strpos($capturandoCaracteres, $findme20);
    
                    $pos21 = strpos($capturandoCaracteres, $findme21);
    
                  
                    if ($pos1 !== false || $pos2 !== false || $pos3 !== false || $pos4 !== false || $pos5 !== false || $pos6 !== false || $pos7 !== false || $pos8 !== false || $pos9 !== false || $pos10 !== false || $pos11 !== false || $pos12 !== false || $pos13 !== false || $pos14 !== false || $pos15 !== false || $pos16 !== false || $pos17 !== false || $pos18 !== false || $pos19 !== false || $pos20 !== false|| $pos21 !== false) {
                       
                        echo'<br>Está intentando ingresar un caracter especial ';
                        
                    } else {
                      // echo "<br>Realiza proceso";
                        // $validandoCAtacteres=0;
                        array_push($arrayNombresCaracteres,$nombre);
              
                    }
            */ 
    ?>
    
                                                                    