<?php error_reporting(E_ERROR);
//////// traemos la bd
require_once '../../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario

if(isset($_POST['AgregarMacroproceso'])){

    
    $nombre = utf8_decode($_POST['nombre']);
    
    $descripcion = utf8_decode($_POST['descripcion']);
    
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
   
   /////////////// validamos el nombre que entra al nombre de la consulta

   $subject = $nombre;
   $capturandoCaracteres=str_replace(array('<', '>','*','/','+','#','$','%','&','||','(',')','"',"'",'[',']','{','}','@','-','_'), array('1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1'), $subject);
   
   $findme1  = '1';
   $findme2   = '1';
   $findme3   = '1';
   $findme4   = '1';
   $findme5   = '1';

   $findme6   = '1';
   $findme7   = '1';
   $findme8   = '1';
   $findme9   = '1';
   $findme10   = '1';

   $findme11  = '1';
   $findme12   = '1';
   $findme13   = '1';
   $findme14   = '1';
   $findme15   = '1';

   $findme16  = '1';
   $findme17   = '1';
   $findme18   = '1';
   $findme19   = '1';
   $findme20   = '1';

   $findme21   = '1';
   

   $pos1 = strpos($capturandoCaracteres, $findme1);
   $pos2 = strpos($capturandoCaracteres, $findme2);
   $pos3 = strpos($capturandoCaracteres, $findme3);
   $pos4 = strpos($capturandoCaracteres, $findme4);
   $pos5 = strpos($capturandoCaracteres, $findme5);

   $pos6 = strpos($capturandoCaracteres, $findme6);
   $pos7 = strpos($capturandoCaracteres, $findme7);
   $pos8 = strpos($capturandoCaracteres, $findme8);
   $pos9 = strpos($capturandoCaracteres, $findme9);
   $pos10 = strpos($capturandoCaracteres, $findme10);

   $pos11 = strpos($capturandoCaracteres, $findme11);
   $pos12 = strpos($capturandoCaracteres, $findme12);
   $pos13 = strpos($capturandoCaracteres, $findme13);
   $pos14 = strpos($capturandoCaracteres, $findme14);
   $pos15 = strpos($capturandoCaracteres, $findme15);

   $pos16 = strpos($capturandoCaracteres, $findme16);
   $pos17 = strpos($capturandoCaracteres, $findme17);
   $pos18 = strpos($capturandoCaracteres, $findme18);
   $pos19 = strpos($capturandoCaracteres, $findme19);
   $pos20 = strpos($capturandoCaracteres, $findme20);

   $pos21 = strpos($capturandoCaracteres, $findme21);

 
   if ($pos1 !== false || $pos2 !== false || $pos3 !== false || $pos4 !== false || $pos5 !== false || $pos6 !== false || $pos7 !== false || $pos8 !== false || $pos9 !== false || $pos10 !== false || $pos11 !== false || $pos12 !== false || $pos13 !== false || $pos14 !== false || $pos15 !== false || $pos16 !== false || $pos17 !== false || $pos18 !== false || $pos19 !== false || $pos20 !== false|| $pos21 !== false) {
    ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../macroproceso" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExiste" value="1">
            </form> 
        <?php
  
} else {
   $validacion = $mysqli->query("SELECT * FROM macroproceso WHERE nombre = '$salida'  "); ///OR orden='$orden'
    $numRows = mysqli_num_rows($validacion);
    if($numRows > 0){
       //echo 'funciona';
        //echo '<script language="javascript">alert("El macroproceso ya existe");
        //window.location.href="../../macroproceso"</script>';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../macroproceso" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExiste" value="1">
            </form> 
        <?php
    }else{
        //echo 'no sirve';
        $mysqli->query("INSERT INTO macroproceso (nombre,descripcion) 
        VALUES('$nombre','$descripcion' ) ")or die(mysqli_error($mysqli)); ///orden
        
        
        
        //////////////////// se agrega este campo para las actividades
                    $validandoNotificacions='macroprocesos';
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
                    
                  
                        $tituloA='Nuevo macroproceso';
                        $mensajeA=utf8_decode('Se crea macroproceso '.utf8_encode($nombre).' con información '.utf8_encode($descripcion));
                        
                        date_default_timezone_set('America/Bogota');
                        $fechaA=date('Y-m-j h:i:s A');
                        
                        $agregarActividads= $mysqli->query("INSERT INTO actividades(idUsuario,iformulario,titulo,fecha,mensaje) VALUES('$usuarioID', '$validandoNotificacions', '$tituloA', '$fechaA','$mensajeA')")or die(mysqli_error($mysqli));
                        
                 
        ////////// fin del proceso
        
        
        
        
        
        
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../macroproceso" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionAgregar" value="1">
            </form> 
        <?php
        //header ('location: ../../macroproceso');
    }



    //echo "<br>Realiza proceso";
}
  /////////////// End validamos el nombre que entra al nombre de la consulta
 
    
}elseif(isset($_POST['EditarMacroproceso'])){
    
    $id = $_POST['idMacroproceso'];
    $nombre = utf8_decode($_POST['nombre']);
   
    $descripcion = utf8_decode($_POST['descripcion']);

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
    
    $validacion1 = $mysqli->query("SELECT * FROM macroproceso WHERE nombre = '$salida' AND id != '$id'");//consulta a base de datos si el nombre se repite
    $numNom = mysqli_num_rows($validacion1);
    if($numNom > 0){//si el nombre está repetido se pone falso
        $editar = false;
        //echo '<script language="javascript">alert("El nombre del macroproceso ya existe.");</script>';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../macroproceso" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExiste" value="1">
            </form> 
    <?php
    }
    
    if($editar != false){
         $mysqli->query("UPDATE macroproceso SET  nombre='$nombre',  descripcion='$descripcion' WHERE id = '$id'")or die(mysqli_error($mysqli));
        ///echo '<script language="javascript">window.location.href="../../macroproceso"</script>';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../macroproceso" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionActualizar" value="1">
            </form> 
        <?php
    }
  
        
        
  
    
}elseif(isset($_POST['EliminarMacroproceso'])){
    
    $id = $_POST['idMacroproceso'];
    
    
        $mysqli->query("  DELETE from macroproceso  WHERE id = '$id'")or die(mysqli_error($mysqli));
    
     //header ('location: ../../macroproceso');
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../macroproceso" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminar" value="1">
            </form> 
        <?php
    
}
?>