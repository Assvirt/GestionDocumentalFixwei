<?php
require_once '../../conexion/bd.php';
mb_internal_encoding("UTF-8");


if(isset($_POST['Agregar'])){
    
$grupo = utf8_decode($_POST['grupo']);
$descripcion = utf8_decode($_POST['descripcion']);
    
    // funcion para quitar espacios
        function Quitar_Espacios($grupo)
        {
            $array = explode(' ',$grupo);  // convierte en array separa por espacios;
            $grupo ='';
            // quita los campos vacios y pone un solo espacio
            for ($i=0; $i < count($array); $i++) { 
                if(strlen($array[$i])>0) {
                    $grupo.= ' ' . $array[$i];
                }
            }
          return  trim($grupo);
        }
        /// END
       
        $grupo = Quitar_Espacios($grupo);
    
    ///////// consultamos la tabla y extraemos el nombre
    $validacion = $mysqli->query("SELECT * FROM proveedoresGrupo WHERE grupo = '$grupo' ")or die (mysqli_error());
    $numRows = mysqli_num_rows($validacion);
if($numRows > 0){
        //echo 'funciona';
        //echo '<script language="javascript">alert("El grupo ya existe");
        //window.location.href="../../agregarProveedoresGrupos"</script>';
         ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../agregarProveedoresGrupos" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionExiste" value="1">
                            </form> 
                        <?php
    }else{
        //echo 'no sirve';
        $mysqli->query("INSERT INTO proveedoresGrupo (grupo, descripcion) VALUES('$grupo','$descripcion') ")or die(mysqli_error($mysqli));
        //header ('location: ../../agregarProveedoresGrupos');
        ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../agregarProveedoresGrupos" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionAgregar" value="1">
                            </form> 
                        <?php
    }

}elseif(isset($_POST['Editar'])){

    $id= $_POST['idProveedorGrupo'];
    $grupo = utf8_decode($_POST['grupo']);
$descripcion = utf8_decode($_POST['descripcion']);
    
    // funcion para quitar espacios
        function Quitar_Espacios($grupo)
        {
            $array = explode(' ',$grupo);  // convierte en array separa por espacios;
            $grupo ='';
            // quita los campos vacios y pone un solo espacio
            for ($i=0; $i < count($array); $i++) { 
                if(strlen($array[$i])>0) {
                    $grupo.= ' ' . $array[$i];
                }
            }
          return  trim($grupo);
        }
        /// END
       
        $grupo = Quitar_Espacios($grupo);
        
        
    $validacion = $mysqli->query("SELECT * FROM proveedoresGrupo WHERE grupo='$grupo' AND id !='$id' ");
    $numRows = mysqli_num_rows($validacion);
    if($numRows > 0){
      ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../agregarProveedoresGrupos" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionExiste" value="1">
                            </form> 
                        <?php
       // echo '<script language="javascript">alert("El grupo ya existe");
       // window.location.href="../../agregarProveedoresGrupos"</script>';
    
}else{
    $mysqli->query("UPDATE proveedoresGrupo SET  grupo='$grupo', descripcion='$descripcion'  WHERE id = '$id'")or die(mysqli_error($mysqli));
        //header ('location: ../../agregarProveedoresGrupos');
        ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../agregarProveedoresGrupos" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionActualizar" value="1">
                            </form> 
                        <?php
}

}elseif(isset($_POST['proveedoresGrupoEliminar'])){
    
                        $id = $_POST['idProveedorGrupo'];
                        $mysqli->query("  DELETE from proveedoresGrupo  WHERE id = '$id'")or die(mysqli_error($mysqli));
                        ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../agregarProveedoresGrupos" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionEliminar" value="1">
                            </form> 
                        <?php
                       // echo '<script language="javascript">
                       // window.location.href="../../agregarProveedoresGrupos"</script>';
                    
    
}
?>