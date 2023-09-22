<?php
error_reporting(E_ERROR);
require_once '../conexion/bd.php';

if(isset($_POST['agregarCod'])){
    
    $cod = trim($_POST['txtCondificacion']);
    
    $query = $mysqli->query("SELECT max(orden) FROM codificacion");
    $datosQuery = $query->fetch_array(MYSQLI_ASSOC);
    $numOrden = $datosQuery['orden']+1;
  
    if($cod == "-" || $cod == "/" || $cod == " "){
        $tipo = "simbolo";
    }else{
        $tipo = "prefijo";
    }
    
    
    $mysqli->query("INSERT INTO codificacion (codificacion, tipo, orden) VALUES('$cod','$tipo','$numOrden')")or die(mysqli_error($mysqli));
    
    
    //////////////////// se agrega este campo para las actividades
                    $validandoNotificacions='codificacion';
                    $usuarioID=$_POST['usuarioActividad'];
                        
                    ///////////// datos para traer el nombre del modulo en las notifiaciones
                    $nombreUsuario = $mysqli->query("SELECT * FROM notificaciones WHERE idUsuario ='$usuarioID' AND formulario='$validandoNotificacions' ")or die(mysqli_error());
                    $col = $nombreUsuario->fetch_array(MYSQLI_ASSOC);
                    $correoH = $col['correo'];
                    $plataformaH = $col['plataforma'];
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
                        
                        
                        $tituloA='Nueva codificación';
                        $mensajeA='Se crea codificación '.$cod.' '.$tipo.' '.$numOrden;
                        
                        date_default_timezone_set('America/Bogota');
                        $fechaA=date('Y-m-j h:i:s A');
                        
                        $agregarActividads= $mysqli->query("INSERT INTO actividades(idUsuario,iformulario,titulo,fecha,mensaje) VALUES('$usuarioID', '$validandoNotificacions', '$tituloA', '$fechaA','$mensajeA')")or die(mysqli_error($mysqli));
                        
                        /////////// se envían los datos de creación de usuario a ese usuario
                        
                        /////////// Fin se envían los datos de creación de usuario a ese usuario
                    }elseif($correoH == 1){
                        
                        /////////// se envían los datos de creación de usuario a ese usuario
                        
                    }elseif($plataformaH == 1){
                        $tituloA='Nueva codificación';
                        $mensajeA='Se crea codificación '.$cod.' '.$tipo.' '.$numOrden;
                        
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
             
            <form name="miformulario" action="../agregarCodificacion" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionAgregar" value="1">
            </form> 
        <?php
            
            /* ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../agregarCodificacion" method="POST" onsubmit="procesar(this.action);" >
            </form> 
        <?php */
    
}


if(isset($_POST['eliminaCod'])){
    
    $id = $_POST['idDel'];    
    $mysqli->query("DELETE FROM codificacion WHERE id = '$id'");
    //header ('location: ../agregarCodificacion.php');
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../agregarCodificacion" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminar" value="1">
            </form> 
        <?php
    
}

if(isset($_POST['eliminaCodAll'])){
    
    $mysqli->query("TRUNCATE TABLE codificacion");
    //header ('location: ../agregarCodificacion.php');
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../agregarCodificacion" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminar" value="1">
            </form> 
        <?php
    
}




?>