<?php error_reporting(E_ERROR);
//////// traemos la bd
require_once '../../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario

if(isset($_POST['agregarCC'])){

 $nombre = utf8_decode($_POST['nombre']);
 $codigo = utf8_decode($_POST['codigo']);
 $prefijo = utf8_decode($_POST['prefijo']);
 $persona = $_POST['persona'];

 $centrosT = $_POST['cTrabajo'];//centros de trabajo 
 
 $cargo = $_POST['cargo'];//centros de costo pero aun no han sido creados

 // funcion para quitar espacios
        function Quitar_Espacios($codigo)
        {
            $array = explode(' ',$codigo);  // convierte en array separa por espacios;
            $codigo ='';
            // quita los campos vacios y pone un solo espacio
            for ($i=0; $i < count($array); $i++) { 
                if(strlen($array[$i])>0) {
                    $codigo.= ' ' . $array[$i];
                }
            }
          return  trim($codigo);
        }
        /// END
       
        $codigo = Quitar_Espacios($codigo);
        
        
        
         // funcion para quitar espacios
        function Quitar_EspaciosB($prefijo)
        {
            $arrayB = explode(' ',$prefijo);  // convierte en array separa por espacios;
            $prefijo ='';
            // quita los campos vacios y pone un solo espacio
            for ($i=0; $i < count($arrayB); $i++) { 
                if(strlen($arrayB[$i])>0) {
                    $prefijo.= ' ' . $arrayB[$i];
                }
            }
          return  trim($prefijo);
        }
        /// END
       
        $prefijo = Quitar_EspaciosB($prefijo);
        

$validacion = $mysqli->query("SELECT * FROM centroCostos WHERE codigo = '$codigo' OR prefijo='$prefijo' ");
$columna = $validacion->fetch_array(MYSQLI_ASSOC);
$cetrabajo = $columna['idCentroTrabajo'];
$numRows = mysqli_num_rows($validacion);


if($numRows > 0){
    
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../centroCostos" method="POST" onsubmit="procesar(this.action);" > 
                <input type="hidden" name="validacionExiste" value="1">
            </form> 
        <?php
        
}else{
    if($cetrabajo == $centrosT){
    ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../centroCostos" method="POST" onsubmit="procesar(this.action);" > <!-- agregarCentroCostos -->
                <input type="hidden" name="validacionExisteB" value="1">
            </form> 
        <?php
        
    }else{
        $validacionNombre = $mysqli->query("SELECT * FROM centroCostos WHERE nombre = '$nombre' ");
        $columnaNombre = $validacionNombre->fetch_array(MYSQLI_ASSOC);
        $nombreExis = $columnaNombre['nombre'];
        
        if($nombreExis == $nombre){
             ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../centroCostos" method="POST" onsubmit="procesar(this.action);" > <!-- agregarCentroCostos -->
                <input type="hidden" name="validacionExisteNombre" value="1">
            </form> 
            <?php
        }else{
            
        
            $mysqli->query("INSERT INTO centroCostos (codigo,prefijo,nombre,idCargo,idCentroTrabajo,persona) VALUES('$codigo','$prefijo','$nombre','$cargo','$centrosT','$persona')");    
            
            ?>
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformulario"].submit();
                         }
                    </script>
                     
                    <form name="miformulario" action="../../centroCostos" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="validacionAgregar" value="1">
                    </form> 
            <?php
        }
    }
 
}

}
if(isset($_POST['editarCC'])){
    $id = $_POST['idCentro'];
    $nombre = utf8_decode($_POST['nombre']);
    $codigo = utf8_decode($_POST['codigo']);
    $prefijo = utf8_decode($_POST['prefijo']);
    $centrosT = $_POST['cTrabajo'];
    $cargo = $_POST['cargo'];
    $persona = $_POST['persona'];
    
    // funcion para quitar espacios
        function Quitar_Espacios($codigo)
        {
            $array = explode(' ',$codigo);  // convierte en array separa por espacios;
            $codigo ='';
            // quita los campos vacios y pone un solo espacio
            for ($i=0; $i < count($array); $i++) { 
                if(strlen($array[$i])>0) {
                    $codigo.= ' ' . $array[$i];
                }
            }
          return  trim($codigo);
        }
        /// END
       
        $codigo = Quitar_Espacios($codigo);
        
        
        
         // funcion para quitar espacios
        function Quitar_EspaciosB($prefijo)
        {
            $arrayB = explode(' ',$prefijo);  // convierte en array separa por espacios;
            $prefijo ='';
            // quita los campos vacios y pone un solo espacio
            for ($i=0; $i < count($arrayB); $i++) { 
                if(strlen($arrayB[$i])>0) {
                    $prefijo.= ' ' . $arrayB[$i];
                }
            }
          return  trim($prefijo);
        }
        /// END
       
        $prefijo = Quitar_EspaciosB($prefijo);
        
        
         // funcion para quitar espacios
        function Quitar_EspaciosC($nombre)
        {
            $arrayB = explode(' ',$nombre);  // convierte en array separa por espacios;
            $nombre ='';
            // quita los campos vacios y pone un solo espacio
            for ($i=0; $i < count($arrayB); $i++) { 
                if(strlen($arrayB[$i])>0) {
                    $nombre.= ' ' . $arrayB[$i];
                }
            }
          return  trim($nombre);
        }
        /// END
       
        $nombre = Quitar_EspaciosC($nombre);
   
   $editar = true;
   $editar2 = true;
   $editar3 = true;
    
    $validacion1 = $mysqli->query("SELECT * FROM centroCostos WHERE codigo = '$codigo' AND id != '$id'");
    $numNom = mysqli_num_rows($validacion1);
    if($numNom > 0){
        $editar = false;
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../centroCostos" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExisteC" value="1">
            </form> 
        <?php
    }
    
    
    
    $validacion2 = $mysqli->query("SELECT * FROM centroCostos WHERE prefijo = '$prefijo' AND id != '$id'");
    $numNom2 = mysqli_num_rows($validacion2);
    if($numNom2 > 0){
        $editar2 = false;
      
       ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../centroCostos" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExisteD" value="1">
            </form> 
        <?php
    }
    
    
    
    
    $validacion3 = $mysqli->query("SELECT * FROM centroCostos WHERE nombre = '$nombre' AND id != '$id'");
    $numNom3 = mysqli_num_rows($validacion3);
    if($numNom3 > 0){
        $editar3 = false;
      
       ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../centroCostos" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExisteNombre" value="1">
            </form> 
        <?php
    }
    
    if($editar != false && $editar2 != false && $editar3 != false){
         $mysqli->query("UPDATE centroCostos SET  codigo='$codigo', prefijo='$prefijo',nombre='$nombre',idCargo='$cargo',idCentroTrabajo='$centrosT', persona='$persona' WHERE id = '$id'");
        
    }
    
    
    
    
    
    
    
    
  
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../centroCostos" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionActualizar" value="1">
            </form> 
        <?php
  
   
   
    
    
        
    
}
if(isset($_POST['eliminarCC'])){
    $id = $_POST['idCentro'];
    
    $mysqli->query("DELETE FROM centroCostos WHERE id = '$id'");
    //echo '<script language="javascript">alert("exito al Eliminar.");
    //window.location.href="../../centroCostos"</script>';
    ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../centroCostos" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminar" value="1">
            </form> 
        <?php
    
    
    
    
}