<?php error_reporting(E_ERROR);
//////// traemos la bd
require_once '../../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario

if(isset($_POST['AgregarCentro'])){

    
    $prefijoCentro = utf8_decode($_POST['prefijoCentro']);
    $nombreCentro = utf8_decode($_POST['nombreCentro']);
    ///$asociados= $_POST['asociados'];
    $asociados = json_encode($_POST['asociados']);

 // funcion para quitar espacios
        function Quitar_Espacios($nombreCentro)
        {
            $array = explode(' ',$nombreCentro);  // convierte en array separa por espacios;
            $nombreCentro ='';
            // quita los campos vacios y pone un solo espacio
            for ($i=0; $i < count($array); $i++) { 
                if(strlen($array[$i])>0) {
                    $nombreCentro.= ' ' . $array[$i];
                }
            }
          return  trim($nombreCentro);
        }
        /// END
       
        $nombreCentro = Quitar_Espacios($nombreCentro);
        
        
        
         // funcion para quitar espacios
        function Quitar_EspaciosB($prefijoCentro)
        {
            $arrayB = explode(' ',$prefijoCentro);  // convierte en array separa por espacios;
            $prefijoCentro ='';
            // quita los campos vacios y pone un solo espacio
            for ($i=0; $i < count($arrayB); $i++) { 
                if(strlen($arrayB[$i])>0) {
                    $prefijoCentro.= ' ' . $arrayB[$i];
                }
            }
          return  trim($prefijoCentro);
        }
        /// END
       
        $prefijoCentro = Quitar_EspaciosB($prefijoCentro);
    
    ///////// consultamos la tabla y extraemos el nombre
    $validacion = $mysqli->query("SELECT * FROM centrodetrabajo WHERE  nombreCentrodeTrabajo LIKE '%$nombreCentro%' OR prefijoCentrodeTrabajo LIKE '%$prefijoCentro%' ")or die (mysqli_error());
    $numRows = mysqli_num_rows($validacion);
	
    if($numRows > 0){
	
        //echo 'funciona';
        //echo '<script language="javascript">alert("El nombre o el prefijo ya existe");
        //window.location.href="../../centrodetrabajo"</script>';
         ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../centrodetrabajo" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExiste" value="1">
            </form> 
        <?php
    }else{
        //echo 'no sirve';
        $mysqli->query("INSERT INTO centrodetrabajo (prefijoCentrodeTrabajo, nombreCentrodeTrabajo,cargosAsociadoss) VALUES('$prefijoCentro', '$nombreCentro','$asociados' ) ")or die(mysqli_error($mysqli));
        
        
        
        //////////////////// se agrega este campo para las actividades
                    /////////// actividades de traer nombre de modulos de notificaciones
                    $validandoNotificacions='centroTrabajo';
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
                        
                        
                        $tituloA='Nuevo centro de trabajo';
                        $mensajeA='Se crea centro de trabajo '.$nombreCentro.' con el prefijo '.$prefijoCentro;
                        
                        date_default_timezone_set('America/Bogota');
                        $fechaA=date('Y-m-j h:i:s A');
                        
                        $agregarActividads= $mysqli->query("INSERT INTO actividades(idUsuario,iformulario,titulo,fecha,mensaje) VALUES('$usuarioID', '$validandoNotificacions', '$tituloA', '$fechaA','$mensajeA')")or die(mysqli_error($mysqli));
                        
                        /////////// se envían los datos de creación de usuario a ese usuario
                        
                        /////////// Fin se envían los datos de creación de usuario a ese usuario
                    }elseif($correoH == 1){
                        
                        /////////// se envían los datos de creación de usuario a ese usuario
                        
                    }elseif($plataformaH == 1){
                        $tituloA='Nuevo centro de trabajo';
                        $mensajeA='Se crea centro de trabajo '.$nombreCentro.' con el prefijo '.$prefijoCentro;
                        
                        date_default_timezone_set('America/Bogota');
                        $fechaA=date('Y-m-j h:i:s A');
                        
                        $agregarActividads= $mysqli->query("INSERT INTO actividades(idUsuario,iformulario,titulo,fecha,mensaje) VALUES('$usuarioID', '$validandoNotificacions', '$tituloA', '$fechaA','$mensajeA')")or die(mysqli_error($mysqli));
                        
                    }
        ////////// fin del proceso
                    ?>
                        <script> 
                             window.onload=function(){
                           
                                 document.forms["miformulario"].submit();
                             }
                        </script>
                         
                        <form name="miformulario" action="../../centrodetrabajo" method="POST" onsubmit="procesar(this.action);" >
                            <input type="hidden" name="validacionAgregar" value="1">
                        </form> 
                    <?php
        
        //header ('location: ../../centrodetrabajo');
    }
  /////////////// End validamos el nombre que entra al nombre de la consulta
 
    
}elseif(isset($_POST['EditarCentro'])){
    
    $id = $_POST['idCentro'];
    $prefijoCentro = utf8_decode($_POST['prefijoCentro']);
    $nombreCentro = utf8_decode($_POST['nombreCentro']);
    //$asociados= $_POST['asociados'];
    $asociados = json_encode($_POST['asociados']);
    
    if($asociados == 'null'){
        $asociadoss='0';
    }else{
        $asociadoss=$asociados;
    }
    
    
    // funcion para quitar espacios
        function Quitar_Espacios($nombreCentro)
        {
            $array = explode(' ',$nombreCentro);  // convierte en array separa por espacios;
            $nombreCentro ='';
            // quita los campos vacios y pone un solo espacio
            for ($i=0; $i < count($array); $i++) { 
                if(strlen($array[$i])>0) {
                    $nombreCentro.= ' ' . $array[$i];
                }
            }
          return  trim($nombreCentro);
        }
        /// END
       
        $nombreCentro = Quitar_Espacios($nombreCentro);
        
        
        
         // funcion para quitar espacios
        function Quitar_EspaciosB($prefijoCentro)
        {
            $arrayB = explode(' ',$prefijoCentro);  // convierte en array separa por espacios;
            $prefijoCentro ='';
            // quita los campos vacios y pone un solo espacio
            for ($i=0; $i < count($arrayB); $i++) { 
                if(strlen($arrayB[$i])>0) {
                    $prefijoCentro.= ' ' . $arrayB[$i];
                }
            }
          return  trim($prefijoCentro);
        }
        /// END
       
        $prefijoCentro = Quitar_EspaciosB($prefijoCentro);
    
    
    $editar = true;
    $editar2 = true;
    
    $validacion1 = $mysqli->query("SELECT * FROM centrodetrabajo WHERE nombreCentrodeTrabajo = '$nombreCentro' AND id_centrodetrabajo != '$id'");//consulta a base de datos si el nombre se repite
    $numNom = mysqli_num_rows($validacion1);
    if($numNom > 0){//si el nombre está repetido se pone falso
    $editar = false;
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../centrodetrabajo" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExisteA" value="1">
            </form> 
        <?php
    }
    
    $validacion2 = $mysqli->query("SELECT * FROM centrodetrabajo WHERE prefijoCentrodeTrabajo ='$prefijoCentro'  AND id_centrodetrabajo != '$id'");//consulta a base de datos si el nombre se repite
    $numNom2 = mysqli_num_rows($validacion2);
    if($numNom2 > 0){ //echo 'si el prefijo está repetido se pone falso';
        $editar2 = false;
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../centrodetrabajo" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExisteB" value="1">
            </form> 
        <?php
    }
    
    
    if($editar == true && $editar2 == true){ 
        $mysqli->query("UPDATE centrodetrabajo SET nombreCentrodeTrabajo='$nombreCentro', cargosAsociadoss = '$asociadoss', estilo='0' WHERE id_centrodetrabajo = '$id'")or die(mysqli_error($mysqli));
    }
    
    
    if($editar == true && $editar2 == true){
        $mysqli->query("UPDATE centrodetrabajo SET prefijoCentrodeTrabajo='$prefijoCentro', cargosAsociadoss = '$asociadoss', estilo='0' WHERE id_centrodetrabajo = '$id'")or die(mysqli_error($mysqli));
    }
    
    if($editar2== true || $editar == true){
    ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../centrodetrabajo" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionActualizar" value="1">
            </form> 
    <?php
    }
   
    
        
    // header ('location: ../../centrodetrabajo');
  
    
}elseif(isset($_POST['EliminarCargos'])){
    
    $id = $_POST['idCentro'];
    
    
        $mysqli->query("  DELETE from centrodetrabajo  WHERE id_centrodetrabajo = '$id'")or die(mysqli_error($mysqli));
    
     //header ('location: ../../centrodetrabajo');
     ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../centrodetrabajo" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminar" value="1">
            </form> 
        <?php
    
}
?>