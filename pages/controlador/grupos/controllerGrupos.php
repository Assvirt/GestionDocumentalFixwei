<?php error_reporting(E_ERROR);
//////// traemos la bd
require_once '../../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario

if(isset($_POST['agregarGrupo'])){

 $nombre = utf8_decode($_POST['nombre']);
 $descripcion = utf8_decode($_POST['descripcion']);
 //$cargos = $_POST['cargos'];
 //json_encode($cargos);
 //$centrosT = $_POST['centros'];//centros de trabajo 
 //json_encode($centrosT);
//$centrosC = $_POST['centrosC'];//centros de costo pero aun no han sido creados
//json_encode($centrosC);
//validación de nombre de grupo no exista


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

$validacion = $mysqli->query("SELECT * FROM grupo WHERE nombre = '$nombre'");
$numRows = mysqli_num_rows($validacion);
if($numRows > 0){
    //echo '<script language="javascript">alert("El nombre del Grupo ya existe.");
    //window.location.href="../../agregarGrupos"</script>';
    ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../grupos" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExiste" value="1">
            </form> 
        <?php
        
}else
{
    //insert a tabla grupos
    $mysqli->query("INSERT INTO grupo (nombre,descripcion,correo)VALUES ('$nombre','$descripcion','1')");
    // recorrer array cargos y hacer insert
    $extraerId = $mysqli->query("SELECT * FROM grupo WHERE nombre = '$nombre'");
    $idGrup = $extraerId->fetch_array(MYSQLI_ASSOC);
    $idGrupo = $idGrup['id'];
    
    
    
    $formulario = $mysqli->query("SELECT idFormulario FROM formularios");

    
    while($row = $formulario->fetch_assoc()){
        $idForm = $row['idFormulario'];
        $mysqli->query("INSERT INTO permisos(idGrupo,formulario,listar,crear,editar,eliminar) VALUES('$idGrupo', '$idForm', FALSE, FALSE, FALSE, FALSE)")or die(mysqli_error($mysqli));
        ////////// se agregan para las notificaciones
        $mysqli->query("INSERT INTO permisosNotificaciones(idGrupo,formulario,plataforma,correo) VALUES('$idGrupo', '$idForm', TRUE, TRUE)")or die(mysqli_error($mysqli));
    }
    
    ////// acá se agrega para las notificaciones



    
   /* foreach($cargos as $idCargo){
        
        
        //validacion que cargo no haya sido agregado a ese grupo
        $validacionDato = $mysqli->query("SELECT * FROM grupoUcargo WHERE idCargo = '$idCargo' AND idGrupo = '$idGrupo'");
        $numrow = mysqli_num_rows($validacionDato);
        if($numrow > 0){
        
            continue;
            
        }else{
            //insert a grupoUcargo  
            $mysqli->query("INSERT INTO grupoUcargo (idGrupo, idCargo) VALUES ('$idGrupo','$idCargo')");
            
            
            
        }
        
    }*/
    //recorrer Array centros de trabajo y hacer insert
    //insert a grupoUcTrabajo
    
    
    
    /// se comenta el 02 de Agosto del 2021 para ocultar los centro de trabajo del grupo
    /*
    foreach($centrosT as $centrosT){
        
        //validacion que cTrabajo no haya sido agregado a ese grupo
        $validacioncentroT = $mysqli->query("SELECT * FROM grupoUcTrabajo WHERE idcTrabajo = '$centrosT' AND idGrupo = '$idGrupo'");
        $num_row = mysqli_num_rows($validacioncentroT);
        if($num_row > 0){
        
            continue;
            
        }else{
            //insert a grupoUcargo  
            $mysqli->query("INSERT INTO grupoUcTrabajo (idGrupo, idcTrabajo) VALUES ('$idGrupo','$centrosT')");
            
            
            
        }
        
        
    }*/
    // END
    
    
    //insert a grupoUcCostos
  /*  foreach($centrosC as $centros){
        
        //validacion que cTrabajo no haya sido agregado a ese grupo
        $validacioncentroC = $mysqli->query("SELECT * FROM grupoUcCosto WHERE idcCosto = '$centros' AND idGrupo = '$idGrupo'");
        $num_row = mysqli_num_rows($validacioncentroC);
        if($num_row > 0){
        
            continue;
            
        }else{
            //insert a grupoUcargo  
            $mysqli->query("INSERT INTO grupoUcCosto (idGrupo, idcCosto) VALUES ('$idGrupo','$centros')");
            
            
            
        }
        
        
    }*/
    
    
    
    
    
    
    
    //////////////////// se agrega este campo para las actividades
                    /////////// actividades de traer nombre de modulos de notificaciones
                    $validandoNotificacions='gruposDis';
                    $usuarioID=$_POST['usuarioActividad'];
                    $plataformaH = $_POST['plataforma'];
                    $correoH = $_POST['correo'];
                    
                    
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
                        
                        
                        $tituloA=utf8_decode('Grupo de distribución');
                        $mensajeA=utf8_decode('Se crea grupo de distribución').' '.$nombre;
                        
                        date_default_timezone_set('America/Bogota');
                        $fechaA=date('Y-m-j h:i:s A');
                        
                        $agregarActividads= $mysqli->query("INSERT INTO actividades(idUsuario,iformulario,titulo,fecha,mensaje) VALUES('$usuarioID', '$validandoNotificacions', '$tituloA', '$fechaA','$mensajeA')")or die(mysqli_error($mysqli));
                        
                        /////////// se env��an los datos de creaci��n de usuario a ese usuario
                        
                        /////////// Fin se env��an los datos de creaci��n de usuario a ese usuario
                    }elseif($correoH == 1){
                        
                        /////////// se env��an los datos de creaci��n de usuario a ese usuario
                        
                    }elseif($plataformaH == 1){
                         $tituloA=utf8_decode('Grupo de distribución');
                        $mensajeA=utf8_decode('Se crea grupo de distribución').' '.$nombre;
                        
                        date_default_timezone_set('America/Bogota');
                        $fechaA=date('Y-m-j h:i:s A');
                        
                        $agregarActividads= $mysqli->query("INSERT INTO actividades(idUsuario,iformulario,titulo,fecha,mensaje) VALUES('$usuarioID', '$validandoNotificacions', '$tituloA', '$fechaA','$mensajeA')")or die(mysqli_error($mysqli));
                        
                    }
        ////////// fin del proceso
    
    
    
    
    
    //recorrer Array centros de costos y hacer insert
    //echo '<script language="javascript">alert("exito al agregar.");
    //window.location.href="../../grupos"</script>';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../grupos" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionAgregar" value="1">
            </form> 
        <?php
}

}
if(isset($_POST['eliminar'])){
    
   $idGrupo = $_POST['idGrupo'];
   
   //eliminar de grupo
    $mysqli->query("DELETE FROM grupo WHERE id = '$idGrupo'");
   
   //eliminar de grupoUcargo
   
    //$mysqli->query("DELETE FROM grupoUcargo WHERE idGrupo = '$idGrupo'");
   //eliminar de permisos
   
   $mysqli->query("DELETE FROM permisos WHERE idGrupo = '$idGrupo'");
   
   //eliminar de grupoUcTrabajo grupoUcTrabajo
   
   $mysqli->query("DELETE FROM grupoUcTrabajo WHERE idGrupo = '$idGrupo'");
   
   //eliminar de grupoUcCostos
   
   //$mysqli->query("DELETE FROM grupoUcCostos WHERE idGrupo = '$idGrupo'");
   
   //echo '<script language="javascript">alert("exito al eliminar.");
   //window.location.href="../../grupos"</script>';
   ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../grupos" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminar" value="1">
            </form> 
        <?php
   
    
    
    
}
if(isset($_POST['editarGrupo'])){
    $idGrupo = $_POST['idGrupo'];
    $nombre = utf8_decode($_POST['nombre']);
    $descripcion = utf8_decode($_POST['descripcion']);

  
    
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
       
    $validacion1Grupo = $mysqli->query("SELECT * FROM grupo WHERE nombre = '$nombre' AND id != '$idGrupo' ");//consulta a base de datos si el nombre se repite
    $numNomGrupo = mysqli_num_rows($validacion1Grupo);
    if($numNomGrupo > 0){//si el nombre está repetido se pone falso
      
        ?>
            <script> 
                 window.onload=function(){
               
                    document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../grupos" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExisteB" value="1">
            </form> 
    <?php
    }else{
    
        
        $mysqli->query("UPDATE grupo SET nombre='$nombre',descripcion='$descripcion' WHERE id = '$idGrupo'");
        ?>
                <script> 
                     window.onload=function(){
                   
                         document.forms["miformulario"].submit();
                     }
                </script>
                 
                <form name="miformulario" action="../../grupos" method="POST" onsubmit="procesar(this.action);" >
                    <input type="hidden" name="validacionActualizar" value="1">
                </form> 
        <?php
         
    
    }
    
    
}

if(isset($_POST['ActivarCorreo'])){
    $mysqli->query("UPDATE grupo SET correo='".$_POST['permisoCorreo']."' WHERE id='".$_POST['idGrupo']."' ");


    if($_POST['permisoCorreo'] == '1'){
        $nombreEtiqueta='validacionCorreo';
    }else{
        $nombreEtiqueta='validacionCorreoD';
    }

    ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../grupos" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="<?php echo $nombreEtiqueta;?>" value="1">
            </form> 
    <?php
}
?>