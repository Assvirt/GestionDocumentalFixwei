<?php
error_reporting(E_ERROR);
    $var = $_POST['ruta'];
    $var2 = $_POST["nombre"];
    $varArchivo =$var2;
    $explorando=explode(".",$varArchivo);
    $enviarSinExtension= $explorando[0];
    $enviarConExtension= $explorando[1];
    
    
    if($var2 == null){
            
            
            //echo '<script language="javascript">alert("Para Descargar elija un archivo");
            //window.location.href="repositorio.php"</script>';
            ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="repositorio" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExisteG" value="1">
            </form> 
            <?php
    }else{
        
        //echo "ruta = ".$var;echo "<br>";
        //echo "nombre".$var2;echo "<br>";
        
        $url = $var.$var2;
        
        if($enviarConExtension != 'pdf'){
        $file_example = $url;
        if (file_exists($file_example)) {
            header('Content-Description: File Transfer');
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename='.basename($file_example));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_example));
            ob_clean();
            flush();
            readfile($file_example);
            exit;
        }else{
        echo 'Archivo no disponible.';
        }
    }else{
        //echo $url;
        ?>
            <script> 
                 window.onload=function(){
                    
                    
                    document.forms["miformulario"].submit();
                     
                 }
            </script>
             
            <form name="miformulario" action="<?php echo $url;?>" method="POST" onsubmit="procesar(this.action); "  >
                <!-- Carpeta creada-->
                
            </form> 
        <?php 
        }
        
    }
?>    
    