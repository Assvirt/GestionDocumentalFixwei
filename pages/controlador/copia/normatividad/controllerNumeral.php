<?php
error_reporting(E_ERROR);
//////// traemos la bd
require_once '../../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario

if(isset($_POST['agregarNumeral'])){

    $id = $_POST['idNormatividad'];
    $nombre = utf8_decode($_POST['nombre']);
    $numeral = utf8_decode($_POST['numeral']);
    $descripcion = utf8_decode($_POST['descripcion']);
    

     // funcion para quitar espacios
        function Quitar_Espacios($numeral)
        {
            $array = explode(' ',$numeral);  // convierte en array separa por espacios;
            $salida ='';
            // quita los campos vacios y pone un solo espacio
            for ($i=0; $i < count($array); $i++) { 
                if(strlen($array[$i])>0) {
                    $salida.= ' ' . $array[$i];
                }
            }
          return  trim($salida);
        }
        /// END
       
        $salida = Quitar_Espacios($numeral);
        
    ///////// consultamos la tabla y extraemos el nombre
		$sql= $mysqli->query("SELECT * FROM numeralNorma WHERE numeral = '$salida' ");
		$numRows = mysqli_num_rows($sql);
        if($numRows > 0){
            //echo '<script language="javascript">alert("El numeral ya existe.");</script>';
            ?>
      <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
                 </script>
             
             <form name="miformulario" action="../../normatividadNumeral" method="POST" onsubmit="procesar(this.action);" >
                 <input type="hidden" name="validacionExiste" value="1">
                 <input style="visibility:hidden" type="text" name="idNormatividad" value="<?php echo $id; ?>">
             </form> 
      <?php
        
        }else{
            
            $mysqli->query("INSERT INTO numeralNorma (numeral,nombre,descripcion,idNorma) VALUES('$numeral', '$nombre','$descripcion','$id' ) ")or die(mysqli_error($mysqli));

        

        //echo '<script language="javascript">alert("Agregado con Exito");</script>';
        ?>
      <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
                 </script>
             
             <form name="miformulario" action="../../normatividadNumeral" method="POST" onsubmit="procesar(this.action);" >
                 <input type="hidden" name="validacionAgregar" value="1">
                 <input style="visibility:hidden" type="text" name="idNormatividad" value="<?php echo $id; ?>">
             </form> 
      <?php
    }
}
if(isset($_POST['editarNumeral'])){
    
       $id = $_POST['idNormatividad'];
       $idNum = $_POST['idNumeral'];
       $nombre = utf8_decode($_POST['nombre']);
       $numeral = utf8_decode($_POST['numeral']);
       $descripcion = utf8_decode($_POST['descripcion']);
    
    
    
    
    
    
       $mysqli->query("UPDATE numeralNorma SET  nombre='$nombre', numeral='$numeral', descripcion='$descripcion' WHERE idNorma = '$id'AND id = '$idNum'");
   
   //Editar de normatividad
   
   //echo '<script language="javascript">alert("Actualizado con exito.");</script>';
   ?>
      <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
                 </script>
             
             <form name="miformulario" action="../../normatividadNumeral" method="POST" onsubmit="procesar(this.action);" >
                  <input type="hidden" name="validacionActualizar" value="1">
                 <input style="visibility:hidden" type="text" name="idNormatividad" value="<?php echo $id; ?>">
             </form> 
      <?php
    
}
if(isset($_POST['eliminarNumeral'])){
 //id norma y id numeral   
    $id = $_POST['idNormatividad'];
    $idNum = $_POST['idNumeral'];
    $mysqli->query("DELETE FROM numeralNorma WHERE idNorma = '$id' AND id = '$idNum'");
   
   //eliminar de normatividad
   
   //echo '<script language="javascript">alert("exito al eliminar.");</script>';
   ?>
      <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
                 </script>
             
             <form name="miformulario" action="../../normatividadNumeral" method="POST" onsubmit="procesar(this.action);" >
                  <input type="hidden" name="validacionEliminar" value="1">
                 <input style="visibility:hidden" type="text" name="idNormatividad" value="<?php echo $id; ?>">
             </form> 
      <?php
}
?>