<?php
//////// traemos la bd
require_once '../../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario

if(isset($_POST['Agregar'])){
    
    $tipo = utf8_decode($_POST['tipo']);
    $desripcion = utf8_decode($_POST['descripcion']);
    
     // funcion para quitar espacios
        function Quitar_Espacios($tipo)
        {
            $array = explode(' ',$tipo);  // convierte en array separa por espacios;
            $tipo ='';
            // quita los campos vacios y pone un solo espacio
            for ($i=0; $i < count($array); $i++) { 
                if(strlen($array[$i])>0) {
                    $tipo.= ' ' . $array[$i];
                }
            }
          return  trim($tipo);
        }
        /// END
       
        $tipo = Quitar_Espacios($tipo);
        
    ///////// consultamos la tabla y extraemos el nombre
    $validacion = $mysqli->query("SELECT * FROM indicadoresTipo WHERE tipo = '$tipo' ")or die (mysqli_error());
    $numRows = mysqli_num_rows($validacion);
    if($numRows > 0){
        //echo 'funciona';
        //echo '<script language="javascript">alert("El tipo de indicador ya existen");
        //window.location.href="../../indicadoresTipo"</script>';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../indicadoresTipo" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExiste" value="1">
            </form> 
        <?php
    }else{
        //echo 'no sirve';
        $mysqli->query("INSERT INTO indicadoresTipo (tipo, descripcion) VALUES('$tipo','$desripcion') ")or die(mysqli_error($mysqli));
        //header ('location: ../../indicadoresTipo');
         ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../indicadoresTipo" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionAgregar" value="1">
            </form> 
        <?php
    }
}elseif(isset($_POST['Actualizar'])){
    
    $id= $_POST['id'];
    $tipo = utf8_decode($_POST['tipo']);
    $desripcion = utf8_decode($_POST['descripcion']);
   
    // funcion para quitar espacios
        function Quitar_Espacios($tipo)
        {
            $array = explode(' ',$tipo);  // convierte en array separa por espacios;
            $tipo ='';
            // quita los campos vacios y pone un solo espacio
            for ($i=0; $i < count($array); $i++) { 
                if(strlen($array[$i])>0) {
                    $tipo.= ' ' . $array[$i];
                }
            }
          return  trim($tipo);
        }
        /// END
       
        $tipo = Quitar_Espacios($tipo);
  
      $editar = true;
      $validacion1 = $mysqli->query("SELECT * FROM indicadoresTipo WHERE tipo = '$tipo' AND id != '$id'");//consulta a base de datos si el nombre se repite
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
             
            <form name="miformulario" action="../../indicadoresTipo" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExiste" value="1">
            </form> 
      <?php
      }
    
    if($editar != false){
           $mysqli->query("UPDATE indicadoresTipo SET  tipo='$tipo', descripcion='$desripcion'  WHERE id = '$id'")or die(mysqli_error($mysqli));
        //header ('location: ../../indicadoresTipo');
    }
  
     //echo '<script language="javascript">window.location.href="../../grupos"</script>'; 
    
    if($editar == true){ 
     ?>
             <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../indicadoresTipo" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionActualizar" value="1">
            </form>
    <?php
    } 
  
    
        
    
}elseif(isset($_POST['Eliminar'])){
    
    $id= $_POST['id'];
    $mysqli->query("  DELETE from indicadoresTipo  WHERE id = '$id'")or die(mysqli_error($mysqli));
    //header ('location: ../../indicadoresTipo');
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../indicadoresTipo" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminar" value="1">
            </form> 
        <?php
}
?>