<?php
error_reporting(E_ERROR);
//////// traemos la bd
require_once '../../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario

if(isset($_POST['agregarNorma'])){

    
    $nombre = utf8_decode($_POST['nombre']);
    $abreviatura = utf8_decode($_POST['abreviatura']);
    $descripcion = utf8_decode($_POST['descripcion']);
    

    
    ///////// consultamos la tabla y extraemos el nombre
		$sql= $mysqli->query("SELECT * FROM normatividad WHERE nombre = '$nombre' ");
		$numRows = mysqli_num_rows($sql);
       if($numRows > 0){
            //echo '<script language="javascript">alert("El nombre ya existe.");
           // window.location.href="../../normatividad"</script>';
            ?>
                <script> 
                     window.onload=function(){
                   
                         document.forms["miformulario"].submit();
                     }
                </script>
                 
                <form name="miformulario" action="../../normatividad" method="POST" onsubmit="procesar(this.action);" >
                    <input type="hidden" name="validacionExiste" value="1">
                </form> 
            <?php
        }else{ 
            
            $mysqli->query("INSERT INTO normatividad (nombre, abreviatura,descripcion) VALUES('$nombre', '$abreviatura','$descripcion' ) ")or die(mysqli_error($mysqli));

        
        }
        
        
        //////////////////// se agrega este campo para las actividades
                    $validandoNotificacions='normativa';
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
                    $numNom = mysqli_num_rows($mysqli);
                    if (count($numNom) > 0) {
                    echo 'repetido';
                    }
                    if($correoH == 1 && $plataformaH == 1){
                        
                        
                        $tituloA='Nueva normatividad';
                        $mensajeA='Se crea normatividad '.$nombre;
                        
                        date_default_timezone_set('America/Bogota');
                        $fechaA=date('Y-m-j h:i:s A');
                        
                        $agregarActividads= $mysqli->query("INSERT INTO actividades(idUsuario,iformulario,titulo,fecha,mensaje) VALUES('$usuarioID', '$validandoNotificacions', '$tituloA', '$fechaA','$mensajeA')")or die(mysqli_error($mysqli));
                        
                        /////////// se envían los datos de creación de usuario a ese usuario
                      
                        /////////// Fin se envían los datos de creación de usuario a ese usuario
                    }elseif($correoH == 1){
                        
                        /////////// se envían los datos de creación de usuario a ese usuario
                       
                    }elseif($plataformaH == 1){
                        $tituloA='Nueva normatividad';
                        $mensajeA='Se crea normatividad '.$nombre;
                        
                        date_default_timezone_set('America/Bogota');
                        $fechaA=date('Y-m-j h:i:s A');
                        
                        $agregarActividads= $mysqli->query("INSERT INTO actividades(idUsuario,iformulario,titulo,fecha,mensaje) VALUES('$usuarioID', '$validandoNotificacions', '$tituloA', '$fechaA','$mensajeA')")or die(mysqli_error($mysqli));
                        
                    }
        ////////// fin del proceso



      //  }

       // echo '<script language="javascript">alert("Agregado con Exito");
       // window.location.href="../../normatividad"</script>';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../normatividad" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionAgregar" value="1">
            </form> 
        <?php
}

if(isset($_POST['normatividadEditar'])){
       
       $id = $_POST['idNormatividad'];
       $nombre = utf8_decode($_POST['nombre']);
       $abreviatura = utf8_decode($_POST['abreviatura']);
       $descripcion = utf8_decode($_POST['descripcion']);
    
    
    $editar = true;
    
    $validacion1 = $mysqli->query("SELECT * FROM normatividad WHERE nombre = '$nombre' AND id != '$id'");//consulta a base de datos si el nombre se repite
    $numNom = mysqli_num_rows($validacion1);
   /* if($numNom > 0){//si el nombre está repetido se pone falso
        $editar = false;
        //echo '<script language="javascript">alert("El nombre de la norma ya existe.");</script>';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../normatividad" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExiste" value="1">
            </form> 
        <?php
    } */
    
    //if($editar != false){
        $mysqli->query("UPDATE normatividad SET  nombre='$nombre', abreviatura='$abreviatura', descripcion='$descripcion' WHERE id = '$id'");
        //echo '<script language="javascript">window.location.href="../../normatividad"</script>';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../normatividad" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionActualizar" value="1">
            </form> 
        <?php
        
    //}
  
     
    
   
}

if(isset($_POST['EliminarNormatividad'])){
    $id = $_POST['idNormatividad'];
       $mysqli->query("DELETE FROM normatividad WHERE id = '$id'");
   
   //eliminar de normatividad
   
   //echo '<script language="javascript">alert("exito al eliminar.");
   //window.location.href="../../normatividad"</script>';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../normatividad" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminar" value="1">
            </form> 
        <?php
}
?>