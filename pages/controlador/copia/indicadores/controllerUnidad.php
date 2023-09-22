<?php
//////// traemos la bd
require_once '../../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario

if(isset($_POST['Agregar'])){
    
    $unidad=utf8_decode($_POST['unidad']);
   
    $mysqli->query("INSERT INTO indicadoresUnidad (unidad)VALUES('$unidad') ")or die(mysqli_error($mysqli));
    //header ('location: ../../indicadoresUnidad');
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../indicadoresUnidad" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionAgregar" value="1">
            </form> 
        <?php    
        
}elseif(isset($_POST['Actualizar'])){
    $id= $_POST['id']; /// quienCrea
    $unidad=utf8_decode($_POST['unidad']);
    
    $mysqli->query("UPDATE indicadoresUnidad SET  unidad='$unidad' WHERE id = '$id'  ")or die(mysqli_error($mysqli));
    //header ('location: ../../indicadoresUnidad');
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../indicadoresUnidad" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionActualizar" value="1">
            </form> 
        <?php
    
}elseif(isset($_POST['Eliminar'])){ /// elimina el indicador y lo que contiene el indicador
    
    $id= $_POST['id'];
    $mysqli->query("DELETE from indicadoresUnidad  WHERE id = '$id'")or die(mysqli_error($mysqli));
    //header ('location: ../../indicadoresUnidad');
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../indicadoresUnidad" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminar" value="1">
            </form> 
        <?php

}
?>