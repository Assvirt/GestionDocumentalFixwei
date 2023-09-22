<?php
//////// traemos la bd
require_once '../../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario

if(isset($_POST['AgregarDefinicion'])){

    
    //$nombre = str_replace("?","",utf8_decode($_POST['nombre']));
    $nombre = str_replace("'","",(str_replace("?","",utf8_decode($_POST['nombre'])))); //// eliminamos la comilla simple y las comillas francesas que la toma como signo de pregunta, las eliminamos
    $definicion = str_replace("'","",(str_replace("?","",utf8_decode($_POST['definicion']))));
    
    //$fuente = utf8_decode($_POST['fuente']);
    $fuente = str_replace("'","",(utf8_decode($_POST['fuente'])));
    
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
    
    ///////// consultamos la tabla y extraemos el nombre
		$sql=$mysqli->query("SELECT * FROM definicion  WHERE nombre LIKE '%$nombre%' ");
		$r=$sql->fetch_array(MYSQLI_ASSOC);
		$numRows = mysqli_num_rows($sql);
		$nombre2=$r['nombre'];
        
        
        //while($r =  $sql->fetch_object()){
        //  echo '--'. $nombre2=$r->nombre;
        //}
    ///////// consultamos la tabla y extraemos el nombre
   
   /////////////// validamos el nombre que entra al nombre de la consulta
    //if($salida == $nombre2 ){ 
    if($numRows > 0){
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
                <input type="hidden" name="validacionExisteA" value="1">
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
    //$nombre = str_replace("?","",utf8_decode($_POST['nombre']));
    $nombre = str_replace("'","",(str_replace("?","",utf8_decode($_POST['nombre']))));
    $definicion = str_replace("'","",(str_replace("?","",utf8_decode($_POST['definicion']))));
    $fuente = str_replace("'","",(utf8_decode($_POST['fuente'])));
    
    //$fuente = utf8_decode($_POST['fuente']);

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
  
 
    $editar = true;
    
    $validacion1 = $mysqli->query("SELECT * FROM definicion WHERE nombre = '$nombre' AND id != '$id'");//consulta a base de datos si el nombre se repite
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
                <input type="hidden" name="validacionExisteA" value="1">
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