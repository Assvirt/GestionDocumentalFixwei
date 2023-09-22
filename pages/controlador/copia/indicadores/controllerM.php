<?php
//////// traemos la bd
require_once '../../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario

if(isset($_POST['AplicarVariableUnicaMulti'])){
     $quienCrea=$_POST['quienCrea'];
     $variables=$_POST['variables'];
     $idContinuaIndicador=$_POST['variablesIdPrincipal'];
                        
                        if($variables == 'Serie única'){
                            $mysqli->query("UPDATE indicadores SET  terminar='Pendiente2.2'  WHERE id = '$idContinuaIndicador'  ")or die(mysqli_error($mysqli));
                    ?>
                     
                            <script>
                                    window.onload=function(){
                                        //alert("");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../indicadoresAgregar2.2" method="POST" onsubmit="procesar(this.action);" >
                               <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden" readonly>
                               <input name="variablesSU" value="<?php echo $variables; ?>" type="hidden" readonly>
                            </form>
                            
                        
                    <?php
                    }
                    if($variables == 'Multiserie'){
                        $mysqli->query("UPDATE indicadores SET  terminar='Pendiente2'  WHERE id = '$idContinuaIndicador'  ")or die(mysqli_error($mysqli));
                    ?>
                        
                            <script>
                                    window.onload=function(){
                                        //alert("");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../indicadoresAgregar2" method="POST" onsubmit="procesar(this.action);" >
                               <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden" readonly>
                               <input name="variablesMS" value="<?php echo $variables; ?>" type="hidden" readonly>
                            </form>
                    
                    <?php
                    }
    
}elseif(isset($_POST['AgregarVariables'])){
    
    $quienCrea= $_POST['usuarioActividad'];
    $idContinuaIndicador=$_POST['idContinuaIndicador'];
    
    $variables= utf8_decode($_POST['variables']);
    $nombre = utf8_decode($_POST['nombre2']);
    $desripcion = utf8_decode($_POST['descripcion2']);
    $simbolo=  utf8_decode($_POST['simbolo']);
    $unidad=  utf8_decode($_POST['unidad']);
    
    $validacion = $mysqli->query("SELECT * FROM indicadoresVariables WHERE usuario='$quienCrea' AND idIndicador='$idContinuaIndicador' AND simbolo = '$simbolo'  ")or die (mysqli_error());
    $numRows = mysqli_num_rows($validacion);
    if($numRows > 0){
      
      
        if($numRows != NULL){
                        ?>
                            <script>
                                    window.onload=function(){
                                        //alert("La variable ya existe");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../indicadoresAgregar2.2" method="POST" onsubmit="procesar(this.action);" >
                                 <input type="hidden" name="validacionExiste" value="1">
                               <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden" readonly>
                               <input name="variablesIdPrincipal" value="<?php echo $idContinuaIndicador; ?>" type="hidden" readonly>
                               <input name="calculadoraMostrar" value="TRUE" type="hidden" readonly>
                            </form>
                            
                        <?php
        }
        
        
        
        
    }else{
        
    $mysqli->query("INSERT INTO indicadoresVariables (variables,nombreVariable, descripcionVariable, simbolo, unidad, usuario, idIndicador)
    VALUES('$variables','$nombre','$desripcion','$simbolo','$unidad','$quienCrea','$idContinuaIndicador')   ")or die(mysqli_error($mysqli));
    
    $mysqli->query("UPDATE indicadores SET  terminar='Pendiente2.2'  WHERE id = '$idContinuaIndicador'  ")or die(mysqli_error($mysqli));
    
    
        if($mysqli != NULL){
                        ?>
                            <script>
                                    window.onload=function(){
                                        //alert("");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../indicadoresAgregar2.2" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionAgregar" value="1">
                               <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden" readonly>
                               <input name="variablesIdPrincipal" value="<?php echo $idContinuaIndicador; ?>" type="hidden" readonly>
                               <input name="calculadoraMostrar" value="TRUE" type="hidden" readonly>
                            </form>
                            
                        <?php
        }
    }    
}elseif(isset($_POST['AgregarVariablesActualizar'])){
    
    $quienCrea= $_POST['quienCrea'];
    $idContinuaIndicador=$_POST['id'];
    $muestraCalculadora=$_POST['calculadoraMostrar'];
    $variablesIdPrincipal=$_POST['variablesIdPrincipal'];
   
    $nombre = utf8_decode($_POST['nombre2']);
    $simbolo=  utf8_decode($_POST['simbolo']);
   
    
    $mysqli->query("UPDATE indicadoresVariables SET  nombreVariable='$nombre',  simbolo='$simbolo'   WHERE id = '$idContinuaIndicador'  ")or die(mysqli_error($mysqli));
    $mysqli->query("UPDATE indicadores SET  terminar='Pendiente2.2'  WHERE id = '$idContinuaIndicador'  ")or die(mysqli_error($mysqli));
        if($mysqli != NULL){
                        ?>
                            <script>
                                    window.onload=function(){
                                        //alert("");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../indicadoresAgregar2.2" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionActualizar" value="1">
                               <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden" readonly>
                               <input name="variablesIdPrincipal" value="<?php echo $variablesIdPrincipal; ?>" type="hidden" readonly>
                               <input name="calculadoraMostrar" value="<?php echo $muestraCalculadora; ?>" type="hidden" readonly>
                            </form>
                            
                        <?php
        }
        
}elseif(isset($_POST['AgregarVariablesActualizarEditar'])){
    
    /// mantener el actualizar en la ventana de variables
    $idEditarVariable=$_POST['idEditarVariable'];
    /// END
    
  $quienCrea= $_POST['quienCrea'];
    $idContinuaIndicador=$_POST['id'];
    $muestraCalculadora=$_POST['calculadoraMostrar'];
    $variablesIdPrincipal=$_POST['variablesIdPrincipal'];
   
    $nombre = utf8_decode($_POST['nombre2']);
    $simbolo=  utf8_decode($_POST['simbolo']);
   
    
    $mysqli->query("UPDATE indicadoresVariables SET  nombreVariable='$nombre',  simbolo='$simbolo'   WHERE id = '$idContinuaIndicador'  ")or die(mysqli_error($mysqli));
    $mysqli->query("UPDATE indicadores SET  terminar='Pendiente2.2'  WHERE id = '$idContinuaIndicador'  ")or die(mysqli_error($mysqli));
        if($mysqli != NULL){
                        ?>
                            <script>
                                    window.onload=function(){
                                        //alert("");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../indicadoresEditar1" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionActualizar" value="1">
                               <input name="id" value="<?php echo $variablesIdPrincipal; ?>" type="hidden" readonly>
                               <input type="hidden" name="idEditarVariable" value="<?php echo $idEditarVariable; ?>">
                            </form>
                        <?php
        }
        
}elseif(isset($_POST['AgregarVariablesEliminar'])){
    
    $quienCrea= $_POST['quienCrea'];
    $idContinuaIndicador=$_POST['id'];
    $muestraCalculadora=$_POST['calculadoraMostrar'];
    $variablesIdPrincipal=$_POST['variablesIdPrincipal'];
   
    $nombre = utf8_decode($_POST['nombre2']);
    $simbolo=  utf8_decode($_POST['simbolo']);
   
    
    $mysqli->query("DELETE FROM indicadoresVariables WHERE id = '$idContinuaIndicador'  ")or die(mysqli_error($mysqli));
    $mysqli->query("UPDATE indicadores SET  terminar='Pendiente2.2'  WHERE id = '$idContinuaIndicador'  ")or die(mysqli_error($mysqli));
        if($mysqli != NULL){
                        ?>
                            <script>
                                    window.onload=function(){
                                        //alert("");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../indicadoresAgregar2.2" method="POST" onsubmit="procesar(this.action);" >
                                 <input type="hidden" name="validacionEliminar" value="1">
                               <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden" readonly>
                               <input name="variablesIdPrincipal" value="<?php echo $variablesIdPrincipal; ?>" type="hidden" readonly>
                               <input name="calculadoraMostrar" value="<?php echo $muestraCalculadora; ?>" type="hidden" readonly>
                            </form>
                            
                        <?php
        }
        
}elseif(isset($_POST['AgregarVariablesEliminarEditar'])){
    //// para mantener la vista de variables habilitada
    $idEditarVariable=$_POST['idEditarVariable'];
   /// END
   
     $idContinuaIndicador=$_POST['id'];
     $variablesIdPrincipal=$_POST['variablesIdPrincipal'];
   
    $mysqli->query("DELETE FROM indicadoresVariables WHERE id = '$idContinuaIndicador'  ")or die(mysqli_error($mysqli));
   
        if($mysqli != NULL){
                        ?>
                            <script>
                                    window.onload=function(){
                                        //alert("");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../indicadoresEditar1" method="POST" onsubmit="procesar(this.action);" >
                                 <input type="hidden" name="validacionEliminar" value="1">
                               <input name="id" value="<?php echo $variablesIdPrincipal; ?>" type="hidden" readonly>
                                <input type="hidden" name="idEditarVariable" value="<?php echo $idEditarVariable; ?>">
                            </form>
                            
                        <?php
        }

}elseif(isset($_POST['AgregarVariablesAplicar'])){
    
    $quienCrea= $_POST['quienCrea']; /// quienCrea
    $idContinuaIndicador=$_POST['id']; //// idIndicadorVariable
    $muestraCalculadora=$_POST['calculadoraMostrar']; // mantiene la calculadora activa
    $variablesIdPrincipal=$_POST['variablesIdPrincipal']; //// idIndicador
   
   
   
    
    $mysqli->query("INSERT INTO indicadoresVariablesAsociadas (idIndicador,idVariable,quienCrea)VALUES('$variablesIdPrincipal','$idContinuaIndicador','$quienCrea') ")or die(mysqli_error($mysqli));
    
        
        if($mysqli != NULL){
                        ?>
                            <script>
                                    window.onload=function(){
                                        //alert("");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../indicadoresAgregar2.2" method="POST" onsubmit="procesar(this.action);" >
                               <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden" readonly>
                               <input name="variablesIdPrincipal" value="<?php echo $variablesIdPrincipal; ?>" type="hidden" readonly>
                               <input name="calculadoraMostrar" value="<?php echo $muestraCalculadora; ?>" type="hidden" readonly>
                            </form>
                            
                        <?php
        }
        
        
}elseif(isset($_POST['AgregarVariablesDesaplicar'])){
    
    $quienCrea= $_POST['quienCrea']; /// quienCrea
    $idContinuaIndicador=$_POST['id']; //// idIndicadorVariable
    $muestraCalculadora=$_POST['calculadoraMostrar']; // mantiene la calculadora activa
    $variablesIdPrincipal=$_POST['variablesIdPrincipal']; //// idIndicador
    $desaplicar=$_POST['desaplicar']; //// id para desaplicar
   
   
    
    $mysqli->query("DELETE FROM indicadoresVariablesAsociadas WHERE id='$desaplicar'  ")or die(mysqli_error($mysqli));
    
        
        if($mysqli != NULL){
                        ?>
                            <script>
                                    window.onload=function(){
                                        //alert("");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../indicadoresAgregar2.2" method="POST" onsubmit="procesar(this.action);" >
                               <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden" readonly>
                               <input name="variablesIdPrincipal" value="<?php echo $variablesIdPrincipal; ?>" type="hidden" readonly>
                               <input name="calculadoraMostrar" value="<?php echo $muestraCalculadora; ?>" type="hidden" readonly>
                            </form>
                            
                        <?php
        }
        
        
}elseif(isset($_POST['AgregarFormula'])){
    $quienCrea= $_POST['quienCrea']; /// quienCrea
    $variablesIdPrincipal=$_POST['variablesIdPrincipal']; //// idIndicador
    $formula=$_POST['formula'];
    
    $mysqli->query("UPDATE indicadores SET  formula='$formula', terminar='Pendiente3'   WHERE id = '$variablesIdPrincipal'  ")or die(mysqli_error($mysqli));
    
    
    if($mysqli != NULL){
                        ?>
                            <script>
                                    window.onload=function(){
                                        //alert("");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../indicadoresAgregar3" method="POST" onsubmit="procesar(this.action);" >
                               <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden" readonly>
                               <input name="variablesIdPrincipal" value="<?php echo $variablesIdPrincipal; ?>" type="hidden" readonly>
                            </form>
                            
                        <?php
        }
    
}elseif(isset($_POST['AgregarZonas'])){ 
    
    $quienCrea= $_POST['quienCrea']; /// quienCrea
    $variablesIdPrincipal=$_POST['variablesIdPrincipal']; //// idIndicador
    
    $metas=$_POST['metas'];
    $unidad=utf8_decode($_POST['unidad']);
    $metaActual=utf8_decode($_POST['metaActual']);
    $desde=$_POST['desde'];
    $hasta=$_POST['hasta'];
    
    $zp=$_POST['zp'];
    $za=$_POST['za'];
    $zc=$_POST['zc'];
    $ze=$_POST['ze'];
    
    $validacion = $mysqli->query("SELECT * FROM indicadoresMetas WHERE metaActual = '$metaActual' AND quienCrea='$quienCrea' AND idIndicador='$variablesIdPrincipal' ")or die (mysqli_error());
    $numRows = mysqli_num_rows($validacion);
    if($numRows > 0){ 
                        ?>
                            <script>
                                    window.onload=function(){
                                        //alert("La meta ya existe");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../indicadoresAgregar3" method="POST" onsubmit="procesar(this.action);" >
                                 <input type="hidden" name="validacionExiste" value="1">
                               <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden" readonly>
                               <input name="variablesIdPrincipal" value="<?php echo $variablesIdPrincipal; ?>" type="hidden" readonly>
                            </form>
                            
                        <?php
    }else{
        
            $mysqli->query("INSERT INTO indicadoresMetas (idIndicador,quienCrea,metas,unidad,metaActual,desde,hasta,zp,za,zc,ze)
            VALUES('$variablesIdPrincipal','$quienCrea','$metas','$unidad','$metaActual','$desde','$hasta','$zp','$za','$zc','$ze')")or die(mysqli_error($mysqli));
            $mysqli->query("UPDATE indicadores SET terminar='Terminado', plataformaH='1' WHERE id='$variablesIdPrincipal' ")or die(mysqli_error($mysqli));
            if($mysqli != NULL){
        
                        ?>
                            <script>
                                    window.onload=function(){
                                        //alert("");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../indicadores" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionAgregar" value="1">
                               <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden" readonly>
                               <input name="variablesIdPrincipal" value="<?php echo $variablesIdPrincipal; ?>" type="hidden" readonly>
                            </form> <!-- indicadoresAgregar3 -->
                            
                        <?php
                        
        }
    }
    
    
    
}elseif(isset($_POST['Eliminar'])){ /// elimina el indicador y lo que contiene el indicador
    
    $id= $_POST['id'];
    $mysqli->query("DELETE from indicadores  WHERE id = '$id'")or die(mysqli_error($mysqli));
    $mysqli->query("DELETE FROM indicadoresVariablesAsociadas WHERE idIndicador = '$id'  ")or die(mysqli_error($mysqli));
    $mysqli->query("DELETE FROM indicadoresMetas WHERE idIndicador = '$id'  ")or die(mysqli_error($mysqli));
    //header ('location: ../../indicadores');
    
    ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../indicadores" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminar" value="1">
            </form> 
        <?php
    
   
    
   
    
       
        

}
?>