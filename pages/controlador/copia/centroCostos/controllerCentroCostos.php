<?php error_reporting(E_ERROR);
//////// traemos la bd
require_once '../../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario

if(isset($_POST['agregarCC'])){

 $nombre = utf8_decode($_POST['nombre']);
 $codigo = utf8_decode($_POST['codigo']);
 $prefijo = utf8_decode($_POST['prefijo']);

 $centrosT = $_POST['cTrabajo'];//centros de trabajo 
 
 $cargo = $_POST['cargo'];//centros de costo pero aun no han sido creados

 // funcion para quitar espacios
        function Quitar_Espacios($codigo)
        {
            $array = explode(' ',$codigo);  // convierte en array separa por espacios;
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
       
        $salida = Quitar_Espacios($codigo);
        
        
        
         // funcion para quitar espacios
        function Quitar_EspaciosB($prefijo)
        {
            $arrayB = explode(' ',$prefijo);  // convierte en array separa por espacios;
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
       
        $salidaB = Quitar_EspaciosB($prefijo);
        
//validaci贸n de nombre de grupo no exista
$validacion = $mysqli->query("SELECT * FROM centroCostos WHERE codigo = '$salida' OR prefijo='$salidaB' ");
$columna = $validacion->fetch_array(MYSQLI_ASSOC);
$cetrabajo = $columna['idCentroTrabajo'];
$numRows = mysqli_num_rows($validacion);
if($numRows > 0){
    //echo '<script language="javascript">alert("El código o prefijo ya existe.");
    //window.location.href="../../agregarCentroCostos"</script>';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../centroCostos" method="POST" onsubmit="procesar(this.action);" > <!-- agregarCentroCostos -->
                <input type="hidden" name="validacionExiste" value="1">
            </form> 
        <?php
        
}else{
    if($cetrabajo == $centrosT){
        
    //echo '<script language="javascript">alert("El Centro de trabajo para ese codigo ya existe.");
    //window.location.href="../../agregarCentroCostos"</script>';
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
        //insert
        
    $mysqli->query("INSERT INTO centroCostos (codigo,prefijo,nombre,idCargo,idCentroTrabajo) VALUES('$codigo','$prefijo','$nombre','$cargo','$centrosT')");    
    
    
    
    
    //////////////////// se agrega este campo para las actividades
                    $validandoNotificacions='centroCostos';
                    /////////// actividades de traer nombre de modulos de notificaciones
                   
                    $usuarioID=$_POST['usuarioActividad'];
                    $plataformaH = $_POST['plataforma'];
                    $correoH = $_POST['correo'];
                    /////////// fin proceso para traer el nombre del modulo en las notifiaciones
                    
                    //////////// datos para el correo
                    $nombreUsuario = $mysqli->query("SELECT * FROM usuario WHERE cedula ='$usuarioID' ")or die(mysqli_error());
                    $col = $nombreUsuario->fetch_array(MYSQLI_ASSOC);
                    $nombreU = $col['nombres'];
                    $apellidoU = $col['apellidos'];
                    $correoU = $col['correo'];
                    $usuarioH=$nombreU." ".$apellidoU;
                    //////////////// fin proceso datos para el correo
                    
                    /////////////// datos para traer validar el nombre del formulario
                    $nombreUsuario = $mysqli->query("SELECT id,nombre FROM formularios WHERE idFormulario='$validandoNotificacions' ")or die(mysqli_error());
                    $col = $nombreUsuario->fetch_array(MYSQLI_ASSOC);
                    $nombreNV = $col['nombre'];
                    /////////////// fin datos para traer validar el nombre del formulario
                    
                    
                    if($correoH == 1 && $plataformaH == 1){
                        
                        
                        $tituloA='Nuevo centro de costo';
                        $mensajeA='Se crea centro de costo '.$nombre.' con abreviatura '.$prefijo;
                        
                        date_default_timezone_set('America/Bogota');
                        $fechaA=date('Y-m-j h:i:s A');
                        
                        $agregarActividads= $mysqli->query("INSERT INTO actividades(idUsuario,iformulario,titulo,fecha,mensaje) VALUES('$usuarioID', '$validandoNotificacions', '$tituloA', '$fechaA','$mensajeA')")or die(mysqli_error($mysqli));
                        
                        /////////// se envían los datos de creación de usuario a ese usuario
                        
                        /////////// Fin se envían los datos de creación de usuario a ese usuario
                    }elseif($correoH == 1){
                        
                        /////////// se envían los datos de creación de usuario a ese usuario
                        
                    }elseif($plataformaH == 1){
                        $tituloA='Nuevo centro de costo';
                        $mensajeA='Se crea centro de costo '.$nombre.' con abreviatura '.$prefijo;
                        
                        date_default_timezone_set('America/Bogota');
                        $fechaA=date('Y-m-j h:i:s A');
                        
                        $agregarActividads= $mysqli->query("INSERT INTO actividades(idUsuario,iformulario,titulo,fecha,mensaje) VALUES('$usuarioID', '$validandoNotificacions', '$tituloA', '$fechaA','$mensajeA')")or die(mysqli_error($mysqli));
                        
                    }
        ////////// fin del proceso
    
    
    
    //echo '<script language="javascript">alert("exito al insertar.");
    //window.location.href="../../centroCostos"</script>';
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
if(isset($_POST['editarCC'])){
     $id = $_POST['idCentro'];
    $nombre = utf8_decode($_POST['nombre']);
    $codigo = utf8_decode($_POST['codigo']);
    $prefijo = utf8_decode($_POST['prefijo']);
    $centrosT = $_POST['cTrabajo'];
    $cargo = $_POST['cargo'];
    
    // funcion para quitar espacios
        function Quitar_Espacios($codigo)
        {
            $array = explode(' ',$codigo);  // convierte en array separa por espacios;
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
       
        $salida = Quitar_Espacios($codigo);
        
        
        
         // funcion para quitar espacios
        function Quitar_EspaciosB($prefijo)
        {
            $arrayB = explode(' ',$prefijo);  // convierte en array separa por espacios;
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
       
        $salidaB = Quitar_EspaciosB($prefijo);
   
   $editar = true;
   $editar2 = true;
    
    $validacion1 = $mysqli->query("SELECT * FROM centroCostos WHERE codigo = '$salida' AND id != '$id'");//consulta a base de datos si el nombre se repite
    $numNom = mysqli_num_rows($validacion1);
    if($numNom > 0){//si el nombre está repetido se pone falso
        $editar = false;
        //echo '<script language="javascript">alert("El código del centro de costos ya existe.");</script>';
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
    
    if($editar != false){
         $mysqli->query("UPDATE centroCostos SET codigo='$codigo',nombre='$nombre',idCargo='$cargo',idCentroTrabajo='$centrosT' WHERE id = '$id'");
         
    }
    
    $validacion2 = $mysqli->query("SELECT * FROM centroCostos WHERE prefijo = '$salidaB' AND id != '$id'");//consulta a base de datos si el nombre se repite
    $numNom2 = mysqli_num_rows($validacion2);
    if($numNom2 > 0){//si el nombre está repetido se pone falso
        $editar2 = false;
       // echo '<script language="javascript">alert("El prefijo del centro de costo ya existe.");</script>';
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
    
    if($editar2 != false){
         $mysqli->query("UPDATE centroCostos SET prefijo='$prefijo',nombre='$nombre',idCargo='$cargo',idCentroTrabajo='$centrosT' WHERE id = '$id'");
        
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
    //echo '<script language="javascript">window.location.href="../../centroCostos"</script>'; 
   
   
    
    
        
    
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