<?php error_reporting(E_ERROR);
//////// traemos la bd
require_once '../../conexion/bd.php';
mb_internal_encoding("UTF-8");
////////// validamos el ingreso por el name del  boton del formulario

if(isset($_POST['AgregarProceso'])){
   
    //var_dump($_POST['dueno']);
    $nombre = utf8_decode($_POST['nombreProceso']);
    $descripcion = utf8_decode($_POST['descripcion']);
    $dueno = $_POST['dueno'];
    $prefijo = utf8_decode($_POST['prefijo']);
    $macroproceso = $_POST['macroproceso'];

    $duenoj = json_encode($dueno);
    $insertar = true; // crea variable que me valida si puedo o no insertar, si se vuelve false no deja insertar porque algun dato se repite  
    
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
    
    $validacion1 = $mysqli->query("SELECT * FROM procesos WHERE nombre = '$salida'");//consulta a base de datos si el nombre se repite
    $numNom = mysqli_num_rows($validacion1);
    if($numNom > 0){//si el nombre está repetido se pone falso
        $insertar = false;
        //echo '<script language="javascript">alert("El nombre del proceso ya existe.");
        //window.location.href="../../agregarProceso.php"</script>';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../procesos" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExiste" value="1">
            </form> 
        <?php
    }
    
    $validacion2 = $mysqli->query("SELECT * FROM procesos WHERE prefijo = '$salidaB'");//consulta a base de datos si el nombre se repite
    $numPre = mysqli_num_rows($validacion2);
    if($numPre > 0){//si el nombre está repetido se pone falso
        $insertar = false;
        //echo '<script language="javascript">alert("El prefijo ya existe.");
        //window.location.href="../../agregarProceso.php"</script>';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../procesos" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExisteB" value="1">
            </form> 
        <?php
    }
    
    
    
    if($insertar != false){
        $mysqli->query("INSERT INTO procesos (nombre,descripcion,duenoProceso,prefijo,macroproceso) 
            VALUES('$nombre','$descripcion','$duenoj','$prefijo','$macroproceso') ")or die(mysqli_error($mysqli));
        
        
        
        //////////////////// se agrega este campo para las actividades
                    /////////// actividades de traer nombre de modulos de notificaciones
                    $validandoNotificacions='procesos';
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
                        
                        
                        $tituloA='Nuevo proceso';
                        $mensajeA='Se crea proceso '.$nombre.' con la informaci&oacute;n '.$descripcion;
                        
                        date_default_timezone_set('America/Bogota');
                        $fechaA=date('Y-m-j h:i:s A');
                        
                        $agregarActividads= $mysqli->query("INSERT INTO actividades(idUsuario,iformulario,titulo,fecha,mensaje) VALUES('$usuarioID', '$validandoNotificacions', '$tituloA', '$fechaA','$mensajeA')")or die(mysqli_error($mysqli));
                        
                        /////////// se envían los datos de creación de usuario a ese usuario
                       
                        /////////// Fin se envían los datos de creación de usuario a ese usuario
                    }elseif($correoH == 1){
                        
                        /////////// se envían los datos de creación de usuario a ese usuario
                       
                    }elseif($plataformaH == 1){
                        $tituloA='Nuevo proceso';
                        $mensajeA='Se crea proceso '.$nombre.' con la informaci&oacute;n '.$descripcion;
                        
                        date_default_timezone_set('America/Bogota');
                        $fechaA=date('Y-m-j h:i:s A');
                        
                        $agregarActividads= $mysqli->query("INSERT INTO actividades(idUsuario,iformulario,titulo,fecha,mensaje) VALUES('$usuarioID', '$validandoNotificacions', '$tituloA', '$fechaA','$mensajeA')")or die(mysqli_error($mysqli));
                        
                    }
        ////////// fin del proceso
        
        
        
        
            
        //header ('location: ../../procesos.php');
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../procesos" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionAgregar" value="1">
            </form> 
        <?php
    }
    
}

if(isset($_POST['EditarProceso'])){
    
    $id = $_POST['idEditar'];
    $nombre = utf8_decode($_POST['nombreProceso']);
    $descripcion = utf8_decode($_POST['descripcion']);
    $dueno = $_POST['dueno'];
    $prefijo = utf8_decode($_POST['prefijo']);
    $macroproceso = $_POST['macroproceso'];
    $duenoj = json_encode($dueno);
    
    $editar = true; // crea variabel que me valida si puedo o no editar, si se vuelve false no deja insertar porque algun dato se repite  
    $editar2 = true;
    
    
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
    
    
    $validacion1 = $mysqli->query("SELECT * FROM procesos WHERE nombre = '$salida' AND id != '$id'");//consulta a base de datos si el nombre se repite
    $numNom = mysqli_num_rows($validacion1);
    if($numNom > 0){//si el nombre está repetido se pone falso
        $editar = false;
        //echo '<script language="javascript">alert("El nombre del proceso ya existe.");</script>';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../procesos" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExisteC" value="1">
            </form> 
        <?php
    }
    
    if($editar != false){
        $mysqli->query("UPDATE procesos SET  nombre='$nombre', descripcion='$descripcion',  duenoProceso='$duenoj',
     macroproceso='$macroproceso', importacion='0' WHERE id = '$id'")or die(mysqli_error($mysqli));
    
    }
    
    $validacion2 = $mysqli->query("SELECT * FROM procesos WHERE prefijo = '$salidaB' AND id != '$id'");//consulta a base de datos si el nombre se repite
    $numNom2 = mysqli_num_rows($validacion2);
    if($numNom2 > 0){//si el nombre está repetido se pone falso
        $editar2 = false;
        //echo '<script language="javascript">alert("El prefijo del proceso ya existe.");</script>';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../procesos" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExisteD" value="1">
            </form> 
        <?php
    }
    
    
    if($editar2 != false){
        $mysqli->query("UPDATE procesos SET  descripcion='$descripcion',  duenoProceso='$duenoj',
    prefijo='$prefijo', macroproceso='$macroproceso', importacion='0' WHERE id = '$id'")or die(mysqli_error($mysqli));
    
       
    }
    
    if($editar2 == true || $editar2 == true){
     //echo '<script language="javascript">window.location.href="../../procesos"</script>';
     ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../procesos" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionActualizar" value="1">
            </form> 
    <?php
    }
    
}


if(isset($_POST['eliminarProceso'])){
    
    $id = $_POST['idDel'];
    
   
        $mysqli->query("UPDATE procesos SET estado='Eliminado'  WHERE id = '$id'")or die(mysqli_error($mysqli));
        //header ('location: ../../procesos');
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../procesos" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminar" value="1">
            </form> 
        <?php
    
    
    
    
}


if(isset($_POST['eliminarProcesoTotal'])){
    
    $id = $_POST['idDel'];
    
    $validacion2 = $mysqli->query("SELECT * FROM documento WHERE proceso = '$id' ");//consulta a base de datos si el nombre se repite
    $numNom2 = mysqli_num_rows($validacion2);
    if($numNom2 > 0){
        //echo '<script language="javascript">alert("El proceso se encuentra en uso, no se puede eliminar.");</script>';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../procesosEliminado" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExisteE" value="1">
            </form> 
        <?php
    
    }else{
        $mysqli->query("DELETE from procesos  WHERE id = '$id'")or die(mysqli_error($mysqli));
        //header ('location: ../../procesos');
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../procesosEliminado" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminar" value="1">
            </form> 
        <?php
    }
    
    
    
}
?>