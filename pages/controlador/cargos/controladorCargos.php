<?php error_reporting(E_ERROR);
//////// traemos la bd
require_once '../../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario

if(isset($_POST['AgregarCargos'])){

    
    
    $nombreCargo=utf8_decode($_POST['nombreCargo']);
    $descripcionCargo = utf8_decode($_POST['descripcionCargo']);
    $jefeInmediatoCargo = $_POST['jefeInmediatoCargo'];
    $nivelCargo = $_POST['nivelCargo'];


    
        // funcion para quitar espacios
        function Quitar_Espacios($nombreCargo)
        {
            $array = explode(' ',$nombreCargo);  // convierte en array separa por espacios;
            $nombreCargo ='';
            // quita los campos vacios y pone un solo espacio
            for ($i=0; $i < count($array); $i++) { 
                if(strlen($array[$i])>0) {
                    $nombreCargo.= ' ' . $array[$i];
                }
            }
          return  trim($nombreCargo);
        }
        /// END
       
        $nombreCargo = Quitar_Espacios($nombreCargo);
        
        
    ///////// consultamos la tabla y extraemos el nombre
    $validacion = $mysqli->query("SELECT nombreCargos FROM cargos WHERE nombreCargos = '$nombreCargo' ")or die (mysqli_error());
    $extraerValidacionCargos=$validacion->fetch_array(MYSQLI_ASSOC);
    $numRows = mysqli_num_rows($validacion);
		
    ///////// consultamos la tabla y extraemos el nombre
   
   /////////////// validamos el nombre que entra al nombre de la consulta
     if($numRows > 0){ 
        //echo 'Alerta';
        //echo '<script language="javascript">alert("El nombre ya existe");
        //window.location.href="../../cargos"</script>';
         ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../cargos" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExiste" value="1">
            </form> 
        <?php
    }else{
        //echo 'Guarda';
       $mysqli->query("INSERT INTO cargos (nombreCargos, descripcionCargos, jefeInmediatoCargos, nivelCargo) VALUES('$nombreCargo', '$descripcionCargo', '$jefeInmediatoCargo', '$nivelCargo') ")or die(mysqli_error($mysqli));
        
        
        //////////////////// se agrega este campo para las actividades
                    /////////// actividades de traer nombre de modulos de notificaciones
                    $validandoNotificacions='cargos';
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
                    
                    
                
                        $tituloA='Nuevo cargo creado';
                        $mensajeA='Se acaba de crear el cargo '.$nombreCargo;
                        
                        date_default_timezone_set('America/Bogota');
                        $fechaA=date('Y-m-j h:i:s A');
                        
                        $agregarActividads= $mysqli->query("INSERT INTO actividades(idUsuario,iformulario,titulo,fecha,mensaje) VALUES('$usuarioID', '$validandoNotificacions', '$tituloA', '$fechaA','$mensajeA')")or die(mysqli_error($mysqli));
                        
                 
        ////////// fin del proceso
        
        
        
        //echo '<script language="javascript">alert("Cargo creado");
        //window.location.href="../../cargos"</script>';
        //header ('location: ../../cargos');
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../cargos" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionAgregar" value="1">
            </form> 
        <?php
      
    }
  /////////////// End validamos el nombre que entra al nombre de la consulta
 
    
}elseif(isset($_POST['EditarCargos'])){
    
    $id = $_POST['idCargos'];
    $nombreCargo = utf8_decode($_POST['nombreCargo']);
    $descripcionCargo = utf8_decode($_POST['descripcionCargo']);
    $jefeInmediatoCargo = $_POST['jefeInmediatoCargo'];
    $nivelCargo = $_POST['nivelCargo'];

    
    $consultaID=$mysqli->query("SELECT * FROM cargos WHERE id_cargos='$id' ");
    $traeID=$consultaID->fetch_array(MYSQLI_ASSOC);
     'El nombre del cargo a editar: '.$traeID['nombreCargos'];
     '<br>El id del cargo a editar: '.$idCargosValidar=$traeID['id_cargos'];
    
     function Quitar_Espacios($nombreCargo)
        {
            $array = explode(' ',$nombreCargo);  // convierte en array separa por espacios;
            $nombreCargo ='';
            // quita los campos vacios y pone un solo espacio
            for ($i=0; $i < count($array); $i++) { 
                if(strlen($array[$i])>0) {
                    $nombreCargo.= ' ' . $array[$i];
                }
            }
          return  trim($nombreCargo);
        }
        /// END
       
        $nombreCargo = Quitar_Espacios($nombreCargo);

     $editar = true;

    $validacion1 = $mysqli->query("SELECT * FROM cargos WHERE nombreCargos = '$nombreCargo' AND id_cargos != '$id'");//consulta a base de datos si el nombre se repite
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
             
            <form name="miformulario" action="../../cargos" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExiste" value="1">
            </form> 
    <?php
    }


    if($editar != false){
        $mysqli->query("UPDATE cargos SET nombreCargos='$nombreCargo', descripcionCargos='$descripcionCargo', jefeInmediatoCargos='$jefeInmediatoCargo', nivelCargo='$nivelCargo'  WHERE id_cargos = '$id'")or die(mysqli_error($mysqli));
        ?>
        <script> 
             window.onload=function(){
           
                 document.forms["miformulario"].submit();
             }
        </script>
         
        <form name="miformulario" action="../../cargos" method="POST" onsubmit="procesar(this.action);" >
            <input type="hidden" name="validacionActualizar" value="1">
        </form> 
    <?php 
    }
      
}elseif(isset($_POST['EliminarCargos'])){
    
    $id = $_POST['idCargos'];
    
    
    $mysqli->query("  DELETE from cargos  WHERE id_cargos = '$id'")or die(mysqli_error($mysqli));
    ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../cargos" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminar" value="1">
            </form> 
    <?php
    ///header ('location: ../../cargos');
    
}

?>