<?php
require_once '../../conexion/bd.php';

if(isset($_POST['encabezadoCrear'])){
    $encabezado =utf8_decode($_POST['editor1']);
    //$nombre=utf8_decode($_POST['nombre']);
    $nombre = str_replace("'","",(str_replace("?","",utf8_decode($_POST['nombre']))));
    
    $validamosNombre=$mysqli->query("SELECT * FROM encabezado WHERE nombre='$nombre' ");
    $numRows = mysqli_num_rows($validamosNombre);
    
    if($numRows > 0){
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../crearEncabezadoLista" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExiste" value="1">
            </form> 
        <?php
    }else{
        $mysqli->query("INSERT INTO encabezado (encabezado,nombre,principal)VALUES('$encabezado','$nombre','0')"); 
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../crearEncabezadoLista" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionAgregar" value="1">
            </form> 
        <?php
    }
}
if(isset($_POST['encabezado'])){
    
    $encabezado =utf8_decode($_POST['editor1']);
    //$nombre=utf8_decode($_POST['nombre']);
    $nombre = str_replace("'","",(str_replace("?","",utf8_decode($_POST['nombre']))));
    $id=$_POST['id'];
    
    $editar = true;
    $validamosNombre=$mysqli->query("SELECT * FROM encabezado WHERE nombre='$nombre' AND id != '$id' ");
    $numRows = mysqli_num_rows($validamosNombre);
    
    if($numRows > 0){
        $editar = false;
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../crearEncabezadoLista" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExiste" value="1">
            </form> 
        <?php
    }
    
    if($editar != false){
        $mysqli->query("UPDATE encabezado SET encabezado = '$encabezado', nombre='$nombre'  WHERE id ='$id' ");
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../crearEncabezadoLista" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionActualizar" value="1">
            </form> 
        <?php
    }
    
    
        
    
}
if(isset($_POST['eliminar'])){
    $id=$_POST['id'];
    $mysqli->query("DELETE FROM encabezado  WHERE id='$id' ");
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../crearEncabezadoLista" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminar" value="1">
            </form> 
        <?php
}

if(isset($_POST['aplicar'])){
    $id=$_POST['id'];
    $mysqli->query("UPDATE encabezado SET principal='1'  WHERE id ='$id' ");
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../crearEncabezadoLista" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionActualizarB" value="1">
            </form> 
        <?php
}
if(isset($_POST['desaplicar'])){
    $id=$_POST['id'];
    $mysqli->query("UPDATE encabezado SET principal='0' ");
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../crearEncabezadoLista" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionActualizarC" value="1">
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
                         
                        <form name="miformulario" action="../../crearEncabezadoCrear" method="POST" onsubmit="procesar(this.action);" > <!-- uploadImg -->
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
                         
                        <form name="miformulario" action="../../crearEncabezadoCrear" method="POST" onsubmit="procesar(this.action);" > <!-- uploadImg -->
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
                         
                        <form name="miformulario" action="../../crearEncabezado" method="POST" onsubmit="procesar(this.action);" > <!-- uploadImg -->
                            <input type="hidden" name="ruta" value="<?php echo $ruta;?>">
                            <input name="id" value="<?php echo $_POST['id'];?>" type="hidden">
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
                         
                        <form name="miformulario" action="../../crearEncabezado" method="POST" onsubmit="procesar(this.action);" > <!-- uploadImg -->
                            <input type="hidden" name="ruta" value="<?php echo $ruta;?>">
                            <input name="id" value="<?php echo $_POST['id'];?>" type="hidden">
                        </form> 
                <?php 
    	}else{
    		//echo "Archivo no se pudo guardar";
    	}
    }
    


}
