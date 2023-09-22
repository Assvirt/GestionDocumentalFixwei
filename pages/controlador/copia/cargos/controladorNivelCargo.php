<?php
//////// traemos la bd
require_once '../../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario

if(isset($_POST['AgregarNivelCargo'])){
    
    $nivelCargo = utf8_decode($_POST['nivelCargo']);
    $prioridad = $_POST['prioridad'];
    
     // funcion para quitar espacios
        function Quitar_Espacios($nivelCargo)
        {
            $array = explode(' ',$nivelCargo);  // convierte en array separa por espacios;
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
        $salida = Quitar_Espacios($nivelCargo);
        
        // funcion para quitar espacios
        function Quitar_EspaciosB($prioridad)
        {
            $arrayB = explode(' ',$prioridad);  // convierte en array separa por espacios;
            $salidaB ='';
            // quita los campos vacios y pone un solo espacio
            for ($i=0; $i < count($arrayB); $i++) { 
                if(strlen($arrayB[$i])>0) {
                    $salidaB.= ' ' . $arrayB[$i];
                }
            }
          return  trim($salidaB);
        }
        /// END
        $salidaB = Quitar_EspaciosB($prioridad);
    
    ///////// consultamos la tabla y extraemos el nombre
    $validacion = $mysqli->query("SELECT * FROM nivelcargo WHERE nivelCargo = '$salida' OR prioridad = '$salidaB'")or die (mysqli_error());
    $numRows = mysqli_num_rows($validacion);
if($numRows > 0){
        //echo 'funciona';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../agregarCargoNivel" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExiste" value="1">
            </form> 
        <?php
        //echo '<script language="javascript">alert("El nivel o la prioridad ya existen");
        //window.location.href="../../agregarCargoNivel"</script>';
        
        
    }else{
        //echo 'no sirve';
        $mysqli->query("INSERT INTO nivelcargo (nivelCargo, prioridad) VALUES('$nivelCargo','$prioridad') ")or die(mysqli_error($mysqli));
        //header ('location: ../../agregarCargoNivel');
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../agregarCargoNivel" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionAgregar" value="1">
            </form> 
        <?php
    }
}elseif(isset($_POST['AgregarNivelCargoEditar'])){
    
    $id= $_POST['idNivelCargo'];
    $nivelCargo = utf8_decode($_POST['nivelCargo']);
    $prioridad = $_POST['prioridad'];
    
   $editar = true;
   $editar2 = true;
    
    // funcion para quitar espacios
        function Quitar_Espacios($nivelCargo)
        {
            $array = explode(' ',$nivelCargo);  // convierte en array separa por espacios;
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
        $salida = Quitar_Espacios($nivelCargo);
        
        // funcion para quitar espacios
        function Quitar_EspaciosB($prioridad)
        {
            $arrayB = explode(' ',$prioridad);  // convierte en array separa por espacios;
            $salidaB ='';
            // quita los campos vacios y pone un solo espacio
            for ($i=0; $i < count($arrayB); $i++) { 
                if(strlen($arrayB[$i])>0) {
                    $salidaB.= ' ' . $arrayB[$i];
                }
            }
          return  trim($salidaB);
        }
        /// END
        $salidaB = Quitar_EspaciosB($prioridad);
    
    
    $validacion1 = $mysqli->query("SELECT * FROM nivelcargo WHERE nivelCargo = '$salida'  AND id != '$id'");//consulta a base de datos si el nombre se repite
    $numNom = mysqli_num_rows($validacion1);
    if($numNom > 0){//si el nombre está repetido se pone falso
        $editar = false;
        //echo '<script language="javascript">alert("El nombre del grupo ya existe.");</script>';
         ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../agregarCargoNivel" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExiste" value="1">
            </form> 
    <?php
    }
    
    if($editar != false){
          $mysqli->query("UPDATE nivelcargo SET  nivelCargo='$salida'  WHERE id = '$id'")or die(mysqli_error($mysqli));
    }
    
    
    $validacion2 = $mysqli->query("SELECT * FROM nivelcargo WHERE prioridad = '$salidaB'  AND id != '$id'");//consulta a base de datos si el nombre se repite
    $numNom2 = mysqli_num_rows($validacion2);
    if($numNom2 > 0){//si el nombre está repetido se pone falso
        $editar2 = false;
        //echo '<script language="javascript">alert("El nombre del grupo ya existe.");</script>';
         ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../agregarCargoNivel" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExiste" value="1">
            </form> 
    <?php
    }
    
    if($editar2 != false){
          $mysqli->query("UPDATE nivelcargo SET  prioridad='$prioridad'  WHERE id = '$id'")or die(mysqli_error($mysqli));
          ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../agregarCargoNivel" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionActualizar" value="1">
            </form> 
        <?php
    }
    
    
    
    
    
    //header ('location: ../../agregarCargoNivel');
    

    
}elseif(isset($_POST['AgregarNivelCargoEliminar'])){
    
    $id= $_POST['idNivelCargo'];
    $mysqli->query("  DELETE from nivelcargo  WHERE id = '$id'")or die(mysqli_error($mysqli));
    //header ('location: ../../agregarCargoNivel');
    ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../agregarCargoNivel" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminar" value="1">
            </form> 
        <?php
}
?>