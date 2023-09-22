<?php
require_once '../../conexion/bd.php';
mb_internal_encoding("UTF-8");


if(isset($_POST['Agregar'])){
    
$nombre = utf8_decode($_POST['nombre']);
$valor = $_POST['valor'];
$periodo = $_POST['periodo'];
$radiobtn = $_POST['radiobtn'];//quien cita
//$select = json_encode($_POST['select_encargadoE']);
$select =$_POST['select_encargadoE'];
//$selectGuardar='['.$select.']';
    
     // funcion para quitar espacios
        function Quitar_Espacios($nombre)
        {
            $array = explode(' ',$nombre);  // convierte en array separa por espacios;
            $nombre ='';
            // quita los campos vacios y pone un solo espacio
            for ($i=0; $i < count($array); $i++) { 
                if(strlen($array[$i])>0) {
                    $nombre.= ' ' . $array[$i];
                }
            }
          return  trim($nombre);
        }
        /// END
       
        $nombre = Quitar_Espacios($nombre);
        
    ///////// consultamos la tabla y extraemos el nombre
    $validacion = $mysqli->query("SELECT * FROM presupuesto WHERE nombre = '$nombre' ")or die (mysqli_error());
    $numRows = mysqli_num_rows($validacion);
    if($numRows > 0){
        //echo 'funciona';
        //echo '<script language="javascript">alert("El nombre del presupueso ya existe");
        //window.location.href="../../presupuesto"</script>';
         ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../presupuesto" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExiste" value="1">
            </form> 
        <?php
    }else{
        //echo 'no sirve';
        $mysqli->query("INSERT INTO presupuesto (nombre, totalPresupuesto, totalEjecutado, tipoResponsable, responsable, periodo) VALUES('$nombre','$valor','0','usuario','$select','$periodo') ")or die(mysqli_error($mysqli));
         ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../presupuesto" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionAgregar" value="1">
            </form> 
        <?php
    } 

}elseif(isset($_POST['Editar'])){
$id=$_POST['id'];
$nombre = utf8_decode($_POST['nombre']);
$valor = $_POST['valor'];
$periodo = $_POST['periodo'];
$radiobtn = $_POST['radiobtn'];//quien cita
//$select = json_encode($_POST['select_encargadoE']);
$select =$_POST['select_encargadoE'];
//$selectGuardar='['.$select.']';

 // funcion para quitar espacios
        function Quitar_Espacios($nombre)
        {
            $array = explode(' ',$nombre);  // convierte en array separa por espacios;
            $nombre ='';
            // quita los campos vacios y pone un solo espacio
            for ($i=0; $i < count($array); $i++) { 
                if(strlen($array[$i])>0) {
                    $nombre.= ' ' . $array[$i];
                }
            }
          return  trim($nombre);
        }
        /// END
       
        $nombre = Quitar_Espacios($nombre);
        
 ///////// consultamos la tabla y extraemos el nombre
    $validacion = $mysqli->query("SELECT * FROM presupuesto WHERE nombre = '$nombre' AND id != '$id' ")or die (mysqli_error());
    $numRows = mysqli_num_rows($validacion);
    if($numRows > 0){
        //echo 'funciona';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../presupuesto" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExiste" value="1">
            </form> 
        <?php
    }else{
        //echo 'no sirve';
        $mysqli->query("UPDATE presupuesto SET nombre='$nombre', totalPresupuesto='$valor', totalEjecutado='0', tipoResponsable='usuario', responsable='$select', periodo='$periodo' WHERE id='$id' ")or die(mysqli_error($mysqli));
       ?>
        <script> 
             window.onload=function(){
           
                 document.forms["miformulario"].submit();
             }
        </script>
         
        <form name="miformulario" action="../../presupuesto" method="POST" onsubmit="procesar(this.action);" >
            <input type="hidden" name="validacionActualizar" value="1">
        </form> 
    <?php 
    }


}elseif(isset($_POST['Eliminar'])){
    
                        $id = $_POST['idPresupuesto'];
                        $mysqli->query("DELETE from presupuesto  WHERE id = '$id'")or die(mysqli_error($mysqli));
                        ?>
                                <script> 
                                     window.onload=function(){
                                   
                                         document.forms["miformulario"].submit();
                                     }
                                </script>
                                 
                                <form name="miformulario" action="../../presupuesto" method="POST" onsubmit="procesar(this.action);" >
                                    <input type="hidden" name="validacionEliminar" value="1">
                                </form> 
                        <?php
                    
    
}
?>