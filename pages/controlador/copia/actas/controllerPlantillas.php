<?php
//////// traemos la bd
require_once '../../conexion/bd.php';
date_default_timezone_set('America/Bogota');

////////// validamos el ingreso por el name del  boton del formulario

if(isset($_POST['agregar'])){
    
    $nombre = utf8_decode($_POST['nombre']);
    $editor = $_POST['editor1'];
    $encabezadoAplicado = $_POST['encabezadoAplicado'];
    
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
    $nombre = utf8_decode($_POST['nombre']);
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
?>