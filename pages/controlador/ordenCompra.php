<?php

require_once '../conexion/bd.php';
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
        function Quitar_EspaciosD($descripcion)
        {
            $array = explode(' ',$descripcion);  // convierte en array separa por espacios;
            $descripcion ='';
            // quita los campos vacios y pone un solo espacio
            for ($i=0; $i < count($array); $i++) { 
                if(strlen($array[$i])>0) {
                    $descripcion.= ' ' . $array[$i];
                }
            }
          return  trim($descripcion);
        }
        /// END
       
        $descripcion = Quitar_EspaciosD($descripcion);
    
    /*
    $validacion = $mysqli->query("SELECT * FROM consecutivoOC WHERE caracter = '$grupo' ")or die (mysqli_error());
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
                             
                            <form name="miformulario" action="../ordenCompraConsecutivo" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionExiste" value="1">
                            </form> 
                        <?php
    }else{
    */
    
if($grupo == NULL && $descripcion == NULL && $_POST['fecha'] == NULL){
                        ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../ordenCompraConsecutivo" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionVacio" value="1">
                            </form> 
                        <?php
}else{ 
    if($_POST['fecha'] != NULL){
        if($grupo != NULL){
        $mysqli->query("INSERT INTO consecutivoOC (caracter) VALUES('$grupo') ")or die(mysqli_error($mysqli));
        }
        if($descripcion != NULL){
        $mysqli->query("INSERT INTO consecutivoOC (caracter) VALUES('$descripcion') ")or die(mysqli_error($mysqli));
        }
        $mysqli->query("INSERT INTO consecutivoOC (caracter) VALUES('Fecha') ")or die(mysqli_error($mysqli));
    }else{
        if($grupo != NULL){
        $mysqli->query("INSERT INTO consecutivoOC (caracter) VALUES('$grupo') ")or die(mysqli_error($mysqli));
        }
        if($descripcion != NULL){
        $mysqli->query("INSERT INTO consecutivoOC (caracter) VALUES('$descripcion') ")or die(mysqli_error($mysqli));
        }
    }    
        ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../ordenCompraConsecutivo" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionAgregar" value="1">
                            </form> 
                        <?php
}
    //}

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
        function Quitar_EspaciosD($descripcion)
        {
            $array = explode(' ',$descripcion);  // convierte en array separa por espacios;
            $descripcion ='';
            // quita los campos vacios y pone un solo espacio
            for ($i=0; $i < count($array); $i++) { 
                if(strlen($array[$i])>0) {
                    $descripcion.= ' ' . $array[$i];
                }
            }
          return  trim($descripcion);
        }
        /// END
       
        $grupo = Quitar_Espacios($grupo);
        
    /*    
    $validacion = $mysqli->query("SELECT * FROM consecutivoOC WHERE caracter='$grupo' AND id !='$id' ");
    $numRows = mysqli_num_rows($validacion);
    if($numRows > 0){
      ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../ordenCompraConsecutivo" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionExiste" value="1">
                            </form> 
                        <?php
      
    
    }else{
    */
    
    if($_POST['fecha'] != NULL){
        if($grupo != NULL){
        $mysqli->query("UPDATE consecutivoOC SET  caracter='$grupo'  WHERE id = '$id'")or die(mysqli_error($mysqli));
        }
        if($descripcion != NULL){
        $mysqli->query("UPDATE consecutivoOC SET  caracter='$descripcion'  WHERE id = '$id'")or die(mysqli_error($mysqli));
        }
        $mysqli->query("UPDATE consecutivoOC SET  caracter='Fecha'  WHERE id = '$id'")or die(mysqli_error($mysqli));
    }else{
        if($grupo != NULL){
        $mysqli->query("UPDATE consecutivoOC SET  caracter='$grupo'  WHERE id = '$id'")or die(mysqli_error($mysqli));
        }
        if($descripcion != NULL){
        $mysqli->query("UPDATE consecutivoOC SET  caracter='$descripcion'  WHERE id = '$id'")or die(mysqli_error($mysqli));
        }
    }
    //$mysqli->query("UPDATE consecutivoOC SET  caracter='$grupo', descripcion='$descripcion'  WHERE id = '$id'")or die(mysqli_error($mysqli));
       
        ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../ordenCompraConsecutivo" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionActualizar" value="1">
                            </form> 
                        <?php
    //}

}elseif(isset($_POST['proveedoresGrupoEliminar'])){
    
                        $id = $_POST['idProveedorGrupo'];
                        $mysqli->query("  DELETE from consecutivoOC  WHERE id = '$id'")or die(mysqli_error($mysqli));
                        ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../ordenCompraConsecutivo" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionEliminar" value="1">
                            </form> 
                        <?php
                       // echo '<script language="javascript">
                       // window.location.href="../../agregarProveedoresGrupos"</script>';
                    
    
}elseif(isset($_POST['aplicar'])){
    
            $id = $_POST['idProveedorGrupo'];
            $mysqli->query("UPDATE consecutivoOC SET aplicado = '1' WHERE id ='$id'")or die(mysqli_error($mysqli));
            //UPDATE consecutivoOC SET  caracter='$grupo', descripcion='$descripcion'  WHERE id = '$id'"
            
            $consultaConsecutivoOC=$mysqli->query("SELECT * FROM consecutivoOC WHERE aplicado = '1'");
            $extraerConsultaConsecutivo=$consultaConsecutivoOC->fetch_array(MYSQLI_ASSOC);
            $caracter=$extraerConsultaConsecutivo['caracter'];
            
            $consultaConsevutivo ="ALTER TABLE solicitudComprador AUTO_INCREMENT=$caracter";
            $resultado = $mysqli->query($consultaConsevutivo) or die("no funciona");
            ?>
             <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../ordenCompraConsecutivo" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionActualizar" value="1">
                            </form> 
            <?php
}

?>

