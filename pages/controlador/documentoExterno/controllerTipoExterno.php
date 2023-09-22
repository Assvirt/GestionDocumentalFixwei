<?php
//////// traemos la bd
require_once '../../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario

if(isset($_POST['agregar'])){

    
    $nombre = utf8_decode($_POST['nombre']);

    
    
		        $sql= $mysqli->query("SELECT * FROM documentoExternoTipo WHERE nombre = '$nombre' ");
		        $numRows = mysqli_num_rows($sql);
                if($numRows > 0){
                //echo '<script language="javascript">alert("El nombre ya existe.");
                //window.location.href="../../tipoDocumentoExterno"</script>';
                ?>
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformulario"].submit();
                         }
                    </script>
                     
                    <form name="miformulario" action="../../tipoDocumentoExterno" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="validacionExiste" value="1">
                    </form> 
                <?php
        
                }else{
            
                $mysqli->query("INSERT INTO documentoExternoTipo (nombre) VALUES('$nombre' ) ")or die(mysqli_error($mysqli));

                }

                //echo '<script language="javascript">alert("Agregado con Exito");
                //window.location.href="../../tipoDocumentoExterno"</script>';
                ?>
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformulario"].submit();
                         }
                    </script>
                     
                    <form name="miformulario" action="../../tipoDocumentoExterno" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="validacionAgregar" value="1">
                    </form> 
                <?php
                
 
}

if(isset($_POST['editar'])){
    $id = $_POST['idDoc'];  
    $nombre = utf8_decode($_POST['nombre']);

       
        
    $validacion2 = $mysqli->query("SELECT * FROM documentoExternoTipo WHERE nombre = '$nombre' AND NOT id = '$id' ");
    $numRows2 = mysqli_num_rows($validacion2);
    
    if($numRows2 > 0){
        
    //echo '<script language="javascript">alert("ese nombre ya esta en uso.");
    //window.location.href="../../documentoExterno"</script>';
                ?>
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformulario"].submit();
                         }
                    </script>
                     
                    <form name="miformulario" action="../../tipoDocumentoExterno" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="validacionExiste" value="1">
                    </form> 
                <?php
    
    }else{
       $mysqli->query("UPDATE documentoExternoTipo SET  nombre='$nombre' WHERE id = '$id'");
   
   //Editar de tipoDoc
   
  // echo '<script language="javascript">alert("Actualizado con exito.");
   //window.location.href="../../tipoDocumentoExterno"</script>';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../tipoDocumentoExterno" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionActualizar" value="1">
            </form> 
        <?php
    }
}

if(isset($_POST['eliminar'])){
    $id = $_POST['idDoc'];
       $mysqli->query("DELETE FROM documentoExternoTipo WHERE id = '$id'");
   
   //eliminar de tipoDoc
   
   //echo '<script language="javascript">alert("exito al eliminar.");
   //window.location.href="../../tipoDocumentoExterno"</script>';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../tipoDocumentoExterno" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminar" value="1">
            </form> 
        <?php
}
?>