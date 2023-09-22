<?php
//////// traemos la bd
require_once '../../conexion/bd.php';
date_default_timezone_set('America/Bogota');

////////// validamos el ingreso por el name del  boton del formulario

if(isset($_POST['agregar'])){
    
    'nombre: '.$nombre = str_replace("'","",(str_replace("?","",utf8_decode($_POST['nombre']))));
    '<br><br>Editor: '.$editor = $_POST['editor1'];
    '<br>Encabezado: '.$encabezadoAplicado = $_POST['encabezadoAplicado'];
    
    $mysqli->query("INSERT INTO `actasPlantilla`(nombre, acta, idEncabezado) VALUES('$nombre','$editor','$encabezadoAplicado')")or die(mysqli_error());
    
    //echo '<script language="javascript">alert("Exito al cargar la plantilla");
    //window.location.href="../../plantillas"</script>'; 
    ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../plantillas" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionAgregar" value="1">
            </form> 
        <?php

    
}
if(isset($_POST['actualizarPlantilla'])){
    
    $idPlantilla=$_POST['idPlantilla'];
    $nombre = str_replace("'","",(str_replace("?","",utf8_decode($_POST['nombre']))));
    $editor = $_POST['editor1'];

    
    $mysqli->query("UPDATE `actasPlantilla` SET `nombre`='$nombre', acta='$editor' WHERE id='$idPlantilla' ")or die(mysqli_error());
    
    //echo '<script language="javascript">alert("Actualizado");
    //window.location.href="../../plantillas"</script>'; 
    ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../plantillas" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionActualizar" value="1">
            </form> 
        <?php

    
}
if(isset($_POST['eliminarPlantilla'])){
    
    $idPlantilla=$_POST['idPlantilla'];
    

    
    $mysqli->query("DELETE FROM `actasPlantilla`  WHERE id='$idPlantilla' ")or die(mysqli_error());
    
    //echo '<script language="javascript">alert("Eliminado");
   // window.location.href="../../plantillas"</script>';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../plantillas" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminar" value="1">
            </form> 
        <?php

    
}
if(isset($_POST['subirImg'])){ //echo 'subir img';
    
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
                         
                        <form name="miformulario" action="../../agregarPlantillaActa" method="POST" onsubmit="procesar(this.action);" > <!-- uploadImg -->
                            <input type="hidden" name="ruta" value="<?php echo $ruta;?>">
                            <input name="nombre" value="<?php echo $_POST['nombre'];?>" type="hidden">
                            <input name="editor1" value="<?php echo $_POST['editor1'];?>" type="hidden">
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
                         
                        <form name="miformulario" action="../../agregarPlantillaActa" method="POST" onsubmit="procesar(this.action);" > <!-- uploadImg -->
                            <input type="hidden" name="ruta" value="<?php echo $ruta;?>">
                            <input name="nombre" value="<?php echo $_POST['nombre'];?>" type="hidden">
                            <input name="editor1" value="<?php echo $_POST['editor1'];?>" type="hidden">
                        </form> 
                <?php 
    	}else{
    		//echo "Archivo no se pudo guardar";
    	}
    }
    


}

if(isset($_POST['subirImgE'])){ //echo 'subir img';
    
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
                         
                        <form name="miformulario" action="../../agregarPlantillaActaEditar" method="POST" onsubmit="procesar(this.action);" > <!-- uploadImg -->
                            <input type="hidden" name="ruta" value="<?php echo $ruta;?>">
                            <input name="idPlantilla" value="<?php echo $_POST['idPlantilla'];?>" type="hidden">
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
                         
                        <form name="miformulario" action="../../agregarPlantillaActaEditar" method="POST" onsubmit="procesar(this.action);" > <!-- uploadImg -->
                            <input type="hidden" name="ruta" value="<?php echo $ruta;?>">
                            <input name="idPlantilla" value="<?php echo $_POST['idPlantilla'];?>" type="hidden">
                        </form> 
                <?php 
    	}else{
    		//echo "Archivo no se pudo guardar";
    	}
    }
    


}
?>