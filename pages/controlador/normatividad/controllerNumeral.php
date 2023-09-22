<?php
error_reporting(E_ERROR);
//////// traemos la bd
require_once '../../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario

if(isset($_POST['agregarNumeral'])){

    $id = $_POST['idNormatividad'];
    $nombre = str_replace("?","",str_replace("'","",(str_replace("−","-",utf8_decode($_POST['nombre'])))));
    $numeral = str_replace("?","",str_replace("'","",(str_replace("−","-",utf8_decode($_POST['numeral'])))));
    $descripcion = str_replace("?","",str_replace("'","",(str_replace("−","-",utf8_decode($_POST['descripcion'])))));
   
    

     // funcion para quitar espacios
        function Quitar_Espacios($numeral)
        {
            $array = explode(' ',$numeral);  // convierte en array separa por espacios;
            $numeral ='';
            // quita los campos vacios y pone un solo espacio
            for ($i=0; $i < count($array); $i++) { 
                if(strlen($array[$i])>0) {
                    $numeral.= ' ' . $array[$i];
                }
            }
          return  trim($numeral);
        }
        /// END
       
        $numeral = Quitar_Espacios($numeral);
        
    ///////// consultamos la tabla y extraemos el nombre
		$sql= $mysqli->query("SELECT * FROM numeralNorma WHERE numeral = '$numeral' ");
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
       $nombre = str_replace("?","",str_replace("'","",(str_replace("−","-",utf8_decode($_POST['nombre'])))));
       $numeral = str_replace("?","",str_replace("'","",(str_replace("−","-",utf8_decode($_POST['numeral'])))));
       $descripcion = str_replace("?","",str_replace("'","",(str_replace("−","-",utf8_decode($_POST['descripcion'])))));
   
    
    
     // funcion para quitar espacios
        function Quitar_Espacios($numeral)
        {
            $array = explode(' ',$numeral);  // convierte en array separa por espacios;
            $numeral ='';
            // quita los campos vacios y pone un solo espacio
            for ($i=0; $i < count($array); $i++) { 
                if(strlen($array[$i])>0) {
                    $numeral.= ' ' . $array[$i];
                }
            }
          return  trim($numeral);
        }
        /// END
       
        $numeral = Quitar_Espacios($numeral);
        
        
     ///////// consultamos la tabla y extraemos el nombre
		$sql= $mysqli->query("SELECT * FROM numeralNorma WHERE numeral = '$numeral' AND id != '$idNum' ");
		$numRows = mysqli_num_rows($sql);
        if($numRows > 0){
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
    
    
       $mysqli->query("UPDATE numeralNorma SET  nombre='$nombre', numeral='$numeral', descripcion='$descripcion' WHERE idNorma = '$id' AND id = '$idNum'");
  
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
}
if(isset($_POST['eliminarNumeral'])){
 //id norma y id numeral   
     'A'.$id = $_POST['idNormatividad'];
     '<br>';
     'B'.$idNum = $_POST['idNumeral'];
    $mysqli->query("DELETE FROM numeralNorma WHERE id='$idNum'");
   
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
                 
                 <input style="visibility:hidden" type="text" name="idNum" value="<?php echo $idNum; ?>">
             </form> 
      <?php
}
?>