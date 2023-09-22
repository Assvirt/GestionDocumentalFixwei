<?php
require_once '../conexion/bd.php';


$mysqli->query("UPDATE controlCambiosParametrizacion SET informacion='".$_POST['editor1']."' ")

 ?>
        <script> 
             window.onload=function(){
           
                 document.forms["miformulario"].submit();
             }
        </script>
         
        <form name="miformulario" action="../controlCambiosParametrizacion" method="POST" onsubmit="procesar(this.action);" >
            <input type="hidden" name="validacionActualizar" value="1">
        </form> 
    <?php 

?>