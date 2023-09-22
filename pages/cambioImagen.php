<?php
//////// traemos la bd
require_once 'conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario

if(isset($_POST['FondoBoton'])){

    $id = '1';
   $icono1 = Addslashes(file_get_contents($_FILES['imagenBoton']['tmp_name']));
   
    
    
        $mysqli->query("UPDATE ColoresBoton  SET botonFondo='$icono1' WHERE id = '$id'")or die(mysqli_error($mysqli));
    
    
    

   // header ('location: ../../examples/AdminPageFooter');
   ?>
                                        <script>
                                             window.onload=function(){
                                               document.forms["miformulario"].submit();
                                                }
                                        </script>
                                        <form name="miformulario" action="pruebascolores" method="POST" onsubmit="procesar(this.action);" >
                                            <input type="hidden"  name="FondoBoton">
                                            <input type="hidden" value="2" type="hidden" name="botonValidacion">
                                        </form>
    <?php
}
?>