 <?php 
	require_once '../conexion/bd.php';
	$buscando_registro=$mysqli->query("SELECT * FROM messages WHERE msg_id='".$_GET['idEnvia']."' ");
	$extraer_buscando_registro=$buscando_registro->fetch_array(MYSQLI_ASSOC);
	$rutaDocumento=utf8_encode($extraer_buscando_registro['documento']);
	
	$eliminacion=unlink('documentos/uploads/'.$rutaDocumento);
	
	if($eliminacion != NULL){
	    $update=$mysqli->query("DELETE FROM messages WHERE msg_id='".$_GET['idEnvia']."' ");
	?>    
	<script>
        setTimeout(clickbutton, 0000);
        function clickbutton() { 
            window.close();
        }
    </script>    
	<?php    
	}else{
	    echo '<br><br><center><font color="red">No se pudo eliminar el documento '.$extraer_buscando_registro['nombreDocumento'].', por favor inténtelo de nuevo.</font></center>';
	    ?>    
    	<script>
            setTimeout(clickbutton, 5000);
            function clickbutton() { 
                window.close();
            }
        </script>    
	<?php 
	}
	
	
	?>