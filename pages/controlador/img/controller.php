<?php

    $nombreArchivo1 = $_FILES['archivo']['name']; 
    $rutaArchivo = $_FILES['archivo']['tmp_name']; 


    date_default_timezone_set("America/Bogota");
    $fecha = date("Ymjhis");

    $nombreArchivo = $fecha.$nombreArchivo1;


    if(!file_exists('../../archivos/img/')){
    	mkdir('../../archivos/img',0777,true);
    	if(file_exists('../../archivos/img/')){
    		if(move_uploaded_file($rutaArchivo, 'archivos/img/'.$nombreArchivo)){
    	        
    	        $ruta = "http://fixwei.com/plataforma/pages/archivos/img/".$nombreArchivo;
    	        
    	        ?>
                        <script> 
                             window.onload=function(){
                           
                                 document.forms["miformulario"].submit();
                             }
                        </script>
                         
                        <form name="miformulario" action="../../uploadImg" method="POST" onsubmit="procesar(this.action);" >
                            <input type="hidden" name="ruta" value="<?php echo $ruta;?>">
                        </form> 
                <?php 
    	        
    	        
    		}else{
    			//echo "Archivo no se pudo guardar";
    		}
    	}
    }else{
    	if(move_uploaded_file($rutaArchivo, '../../archivos/img/'.$nombreArchivo)){
    	    $ruta = "http://fixwei.com/plataforma/pages/archivos/img/".$nombreArchivo;
    	        
    	        ?>
                        <script> 
                             window.onload=function(){
                           
                                 document.forms["miformulario"].submit();
                             }
                        </script>
                         
                        <form name="miformulario" action="../../uploadImg" method="POST" onsubmit="procesar(this.action);" >
                            <input type="hidden" name="ruta" value="<?php echo $ruta;?>">
                        </form> 
                <?php 
    	}else{
    		//echo "Archivo no se pudo guardar";
    	}
    }
    


?>