<?php
//////// traemos la bd
require_once '../../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario

if(isset($_POST['AgregarDefinicion'])){

    
    $nombre = utf8_decode($_POST['nombre']);
    $definicion = utf8_decode($_POST['definicion']);
    $fuente = utf8_decode($_POST['fuente']);
    
     // funcion para quitar espacios
        function Quitar_Espacios($nombre)
        {
            $array = explode(' ',$nombre);  // convierte en array separa por espacios;
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
       
        $salida = Quitar_Espacios($nombre);
    
    ///////// consultamos la tabla y extraemos el nombre
		$sql=$mysqli->query("SELECT * FROM definicion  WHERE nombre ='$salida' ");
		$r=$sql->fetch_array(MYSQLI_ASSOC);
		$nombre2=$r['nombre'];
        
        
        //while($r =  $sql->fetch_object()){
        //  echo '--'. $nombre2=$r->nombre;
        //}
    ///////// consultamos la tabla y extraemos el nombre
   
   /////////////// validamos el nombre que entra al nombre de la consulta
    if($salida == $nombre2 ){ 
        //echo 'funciona';
        //echo '<script language="javascript">alert("La definición ya existe");
        //window.location.href="../../definicion"</script>';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../definicion" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExiste" value="1">
            </form> 
        <?php
    }else{//echo 'guardar'; 
    
        
        
        if(is_numeric($nombre)){
            $nombreS=$nombre;
            $mysqli->query("INSERT INTO definicion (nombreN,definicion,fuente) 
            VALUES('$nombreS','$definicion','$fuente' ) ")or die(mysqli_error($mysqli));
        }
            
        if($nombre <> is_numeric($nombre)){
            $nombreS=$nombre;
            $mysqli->query("INSERT INTO definicion (nombre,definicion,fuente) 
            VALUES('$nombreS','$definicion','$fuente' ) ")or die(mysqli_error($mysqli));
        }
        
        
        
        //////////////////// se agrega este campo para las actividades
                    /////////// actividades de traer nombre de modulos de notificaciones
                    $validandoNotificacions='definicion';
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
                        
                        
                        $tituloA=utf8_decode('Nueva definición');
                        $mensajeA=utf8_decode('Se crea definición '.utf8_encode($nombre).' con la información '.utf8_encode($definicion));
                        
                        date_default_timezone_set('America/Bogota');
                        $fechaA=date('Y-m-j h:i:s A');
                        
                        $agregarActividads= $mysqli->query("INSERT INTO actividades(idUsuario,iformulario,titulo,fecha,mensaje) VALUES('$usuarioID', '$validandoNotificacions', '$tituloA', '$fechaA','$mensajeA')")or die(mysqli_error($mysqli));
                        
                        /////////// se env��an los datos de creaci��n de usuario a ese usuario
                        
                        /////////// Fin se env��an los datos de creaci��n de usuario a ese usuario
                    }elseif($correoH == 1){
                        
                        /////////// se env��an los datos de creaci��n de usuario a ese usuario
                        
                    }elseif($plataformaH == 1){
                        $tituloA=utf8_decode('Nueva definición');
                        $mensajeA=utf8_decode('Se crea definición '.utf8_encode($nombre).' con la información '.utf8_encode($definicion));
                        
                        date_default_timezone_set('America/Bogota');
                        $fechaA=date('Y-m-j h:i:s A');
                        
                        $agregarActividads= $mysqli->query("INSERT INTO actividades(idUsuario,iformulario,titulo,fecha,mensaje) VALUES('$usuarioID', '$validandoNotificacions', '$tituloA', '$fechaA','$mensajeA')")or die(mysqli_error($mysqli));
                        
                    }
        ////////// fin del proceso
        
        
        
        
        //header ('location: ../../definicion');
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../definicion" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionAgregar" value="1">
            </form> 
        <?php
        
    }
  /////////////// End validamos el nombre que entra al nombre de la consulta
 
    
}elseif(isset($_POST['EditarDefinicion'])){
    
    $id = $_POST['idDefinicion'];
    $nombre = utf8_decode($_POST['nombre']);
    $definicion = utf8_decode($_POST['definicion']);
    $fuente = utf8_decode($_POST['fuente']);

// funcion para quitar espacios
        function Quitar_Espacios($nombre)
        {
            $array = explode(' ',$nombre);  // convierte en array separa por espacios;
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
       
        $salida = Quitar_Espacios($nombre);
  
 
    $editar = true;
    
    $validacion1 = $mysqli->query("SELECT * FROM definicion WHERE nombre = '$salida' AND id != '$id'");//consulta a base de datos si el nombre se repite
    $numNom = mysqli_num_rows($validacion1);
    if($numNom > 0){//si el nombre está repetido se pone falso
        $editar = false;
        //echo '<script language="javascript">alert("El nombre de la definición ya existe.");</script>';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../definicion" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExiste" value="1">
            </form> 
        <?php
    }
    
    if($editar != false){
        
         if(is_numeric($nombre)){
            $nombreS=$nombre;
            $mysqli->query("UPDATE definicion SET  nombreN='$nombreS', definicion='$definicion', fuente='$fuente'  WHERE id = '$id'")or die(mysqli_error($mysqli));
        }
            
        if($nombre <> is_numeric($nombre)){
            $nombreS=$nombre;
            $mysqli->query("UPDATE definicion SET  nombre='$nombreS', nombreN='0', definicion='$definicion', fuente='$fuente'  WHERE id = '$id'")or die(mysqli_error($mysqli));
        }
     //echo '<script language="javascript">window.location.href="../../definicion"</script>';
     ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../definicion" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionActualizar" value="1">
            </form> 
    <?php
    }
  
    
       
        
        
    
    // header ('location: ../../definicion');
   
}elseif(isset($_POST['EliminarDefinicion'])){
    
    $id = $_POST['idDefinicion'];
    
    
        $mysqli->query("  DELETE from definicion  WHERE id = '$id'")or die(mysqli_error($mysqli));
    
    //header ('location: ../../definicion');
     ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../definicion" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminar" value="1">
            </form> 
        <?php
    
}
?>