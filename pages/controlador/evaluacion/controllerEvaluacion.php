<?php
require_once '../../conexion/bd.php';
mb_internal_encoding("UTF-8");


if(isset($_POST['Agregar'])){
    $numPrueba = '1';    
    $idUsuario = utf8_decode($_POST['idUsuario']);
    //$nombre = 'nombre'.$numPrueba++; //$_POST['nombre']
    $encabezado = $_POST['encabezado'];
    $estado ='proceso';


// validamos que el usuario tenga una encuesta en proceso, eso nos hace llevar al usuario a terminar este proceso o en su defecto eliminar y empezar de nuevo


    $validacion = $mysqli->query("SELECT * FROM evaluacion WHERE idUsuario='$idUsuario' AND estado='proceso'")or die (mysqli_error());
    $numRows = mysqli_num_rows($validacion);
    if($numRows > 0){
       
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../evaluacionAgregar" method="POST" onsubmit="procesar(this.action);" >
                <!--<input type="hidden" name="validacionExiste" value="1">-->            
            </form> 
        <?php
    }else{
       
        $mysqli->query("INSERT INTO evaluacion (nombre, encabezado, estado,idUsuario) VALUES('$nombre','$encabezado', '$estado',$idUsuario) ")or die(mysqli_error($mysqli));
        
        ?>
                           <script> 
                                window.onload=function(){
                                 
                                    document.forms["miformulario"].submit();
                                }
                            </script>
                                                 
                                <form name="miformulario" action="../../evaluacionAgregar" method="POST" onsubmit="procesar(this.action);" >
                                    <!--<input type="hidden" name="validacionAgregar" value="1">-->
                                </form> 
                        <?php
    }


}elseif(isset($_POST['Editar'])){

    $id= $_POST['id'];
    $idUsuario = utf8_decode($_POST['idUsuario']);
    $nombre = $_POST['nombre'];
    $encabezado = $_POST['encabezado'];
    $estado = $_POST['estado'];
    // funcion para quitar espacios
        
        
    $validacion = $mysqli->query("SELECT * FROM evaluacion WHERE nombre='$nombre' AND id != '$id' ");
    $numRows = mysqli_num_rows($validacion);
    if($numRows > 0){
      ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../evaluacion" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionExiste" value="1">
                            </form> 
                        <?php
       // echo '<script language="javascript">alert("El grupo ya existe");
       // window.location.href="../../agregarProveedoresProductosImpuesto"</script>';
    
}else{
    $mysqli->query("UPDATE evaluacion SET  nnombre='$nombre', encabezado='$encabezado', des='$des'  WHERE id = '$id'")or die(mysqli_error($mysqli));
        //header ('location: ../../agregarProveedoresProductosImpuesto');
        ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../evaluacion" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionActualizar" value="1">
                            </form> 
                        <?php
}

}elseif(isset($_POST['Eliminar'])){
   
$id = $_POST['id'];

$recorridoArchivos=$mysqli->query("SELECT * FROM evaluacionMaterial WHERE idEvaluacion='$id' ");
$numRows = mysqli_num_rows($recorridoArchivos);
while($extraerRecorridoArchivos=$recorridoArchivos->fetch_array()){
    $nombreMaterial=utf8_encode($extraerRecorridoArchivos['material']); echo '<br>';
    $eliminacion=unlink('../../'.$nombreMaterial);
    
}

if($numRows == '0'){
    $eliminacion='1';
}else{
    $eliminacion=$eliminacion;
}

if($eliminacion != NULL){ 
    $mysqli->query(" DELETE from evaluacion WHERE id = '$id'")or die(mysqli_error($mysqli));
    $mysqli->query(" DELETE from evaluacionPrueba WHERE idEvaluacion = '$id'")or die(mysqli_error($mysqli));
    $mysqli->query(" DELETE from evaluacionMaterial WHERE idEvaluacion = '$id'")or die(mysqli_error($mysqli));
                        ?>
                             <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../evaluacion" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionEliminar" value="1">
                            </form> 
                        <?php
}else{
    ?>
                <script> 
                     window.onload=function(){
                   
                         document.forms["miformulario"].submit();
                     }
                </script>
                 
                <form name="miformulario" action="../../evaluacion" method="POST" onsubmit="procesar(this.action);" >
                    <input type="hidden" name="validacionExisteB" value="1">
                </form> 
            <?php
}
                        
                        
                      
                    
    

}elseif(isset($_POST['crearEvaluacion'])){
     $usuario = $_POST['usuario'];
     '<br>';
     $titulo = utf8_decode($_POST['titulo']);
     $descripcion = utf8_decode($_POST['descripcion']);
     '<br>';
     $pregunta = utf8_decode($_POST['pregunta']);
     '<br>';
     $tipoPregunta = $_POST['tipoPregunta'];
    $puntajeCalificacion=$_POST['puntajeCalificacion'];
    
    ////////// Se consulta para extraer el id de la evaluacion 
    if($_POST['idEvaluacion'] != NULL){
        $consultaEvaluacion=$mysqli->query("SELECT * FROM evaluacion WHERE id='".$_POST['idEvaluacion']."' ");
    }else{
        $consultaEvaluacion=$mysqli->query("SELECT * FROM evaluacion WHERE idUsuario='$usuario' AND estado='proceso' ");
    }
    $extraerConsultaEvaluacion=$consultaEvaluacion->fetch_array(MYSQLI_ASSOC);
    
    $idEvaluacion = $extraerConsultaEvaluacion['id'];
    
    $consultaActualiza = $mysqli->query("UPDATE evaluacion SET nombre='$titulo',encabezado='$descripcion' WHERE id='$idEvaluacion' " );
    
    ////////////////////////// Insercion de cada una de las preguntas del formulario en relacion a la evaluacion 
    if($tipoPregunta == '1'){
        $insertaDatosEvaluacion = $mysqli->query("INSERT INTO evaluacionPrueba(usuario,idEvaluacion,pregunta,tipoPregunta,puntajeCalificacion)VALUES('$usuario','$idEvaluacion','$pregunta','$tipoPregunta','$puntajeCalificacion')");
    }elseif($tipoPregunta == '2'){ /// respuesta si ó no
        $correcto = $_POST['SiNo'];
        $insertaDatosEvaluacion = $mysqli->query("INSERT INTO evaluacionPrueba(usuario,idEvaluacion,pregunta,tipoPregunta,correcto,puntajeCalificacion)VALUES('$usuario','$idEvaluacion','$pregunta','$tipoPregunta','$correcto','$puntajeCalificacion')");
    }elseif($tipoPregunta == '3'){ /// multiple respuesta, máximo 5 preguntas
        $opciones1 = utf8_decode($_POST['opciones1']);
        $opciones2 = utf8_decode($_POST['opciones2']);
        $opciones3 = utf8_decode($_POST['opciones3']);
        $opciones4 = utf8_decode($_POST['opciones4']);
        $opciones5 = utf8_decode($_POST['opciones5']);
        $correcto1 = $_POST['correcto1'];
        $correcto2 = $_POST['correcto2'];
        $correcto3 = $_POST['correcto3'];
        $correcto4 = $_POST['correcto4'];
        $correcto5 = $_POST['correcto5'];
        
        
        if($opciones1 != NULL && $opciones2 == NULL && $opciones3 == NULL && $opciones4 == NULL && $opciones5 == NULL ){
            $insertaDatosEvaluacion = $mysqli->query("INSERT INTO evaluacionPrueba(usuario,idEvaluacion,pregunta,tipoPregunta,pregunta1,correcto1,correcto2,correcto3,correcto4,puntajeCalificacion)VALUES('$usuario','$idEvaluacion','$pregunta','$tipoPregunta','$opciones1','$correcto1','$puntajeCalificacion')")or die(mysqli_error($mysqli));
        }elseif($opciones1 != NULL && $opciones2 != NULL && $opciones3 == NULL && $opciones4 == NULL && $opciones5 == NULL){
            //echo 'A';
            $insertaDatosEvaluacion = $mysqli->query("INSERT INTO evaluacionPrueba(usuario,idEvaluacion,pregunta,tipoPregunta,pregunta1,pregunta2,correcto1,correcto2,correcto3,correcto4,puntajeCalificacion)VALUES('$usuario','$idEvaluacion','$pregunta','$tipoPregunta','$opciones1','$opciones2','$correcto1','$correcto2','$correcto3','$correcto4','$puntajeCalificacion')")or die(mysqli_error($mysqli));
            //$complemento = "respuesta1='".$opciones1."' AND respuesta2='".$opciones2."'";
        }elseif($opciones1 != NULL && $opciones2 != NULL && $opciones3 != NULL && $opciones4 == NULL && $opciones5 == NULL){
            //echo 'B';
            $insertaDatosEvaluacion = $mysqli->query("INSERT INTO evaluacionPrueba(usuario,idEvaluacion,pregunta,tipoPregunta,pregunta1,pregunta2,pregunta3,correcto1,correcto2,correcto3,correcto4,puntajeCalificacion)VALUES('$usuario','$idEvaluacion','$pregunta','$tipoPregunta','$opciones1','$opciones2','$opciones3','$correcto1','$correcto2','$correcto3','$correcto4','$puntajeCalificacion')")or die(mysqli_error($mysqli));
            //$complemento = "respuesta1='".$opciones1."' AND respuesta2='".$opciones2."' AND respuesta3='".$opciones3."'";
        }elseif($opciones1 != NULL && $opciones2 != NULL && $opciones3 != NULL && $opciones4 != NULL && $opciones5 == NULL){
             //echo 'C';
             $insertaDatosEvaluacion = $mysqli->query("INSERT INTO evaluacionPrueba(usuario,idEvaluacion,pregunta,tipoPregunta,pregunta1,pregunta2,pregunta3,pregunta4,correcto1,correcto2,correcto3,correcto4,puntajeCalificacion)VALUES('$usuario','$idEvaluacion','$pregunta','$tipoPregunta','$opciones1','$opciones2','$opciones3','$opciones4','$correcto1','$correcto2','$correcto3','$correcto4','$puntajeCalificacion')")or die(mysqli_error($mysqli));
             //$complemento = "respuesta1='".$opciones1."' AND respuesta2='".$opciones2."' AND respuesta3='".$opciones3."' AND respuesta4='".$opciones4."'";
        }elseif($opciones1 != NULL && $opciones2 != NULL && $opciones3 != NULL && $opciones4 != NULL && $opciones5 != NULL){
            //echo 'D';
            $insertaDatosEvaluacion = $mysqli->query("INSERT INTO evaluacionPrueba(usuario,idEvaluacion,pregunta,tipoPregunta,pregunta1,pregunta2,pregunta3,pregunta4,pregunta5,correcto1,correcto2,correcto3,correcto4,correcto5,puntajeCalificacion)VALUES('$usuario','$idEvaluacion','$pregunta','$tipoPregunta','$opciones1','$opciones2','$opciones3','$opciones4','$opciones5','$correcto1','$correcto2','$correcto3','$correcto4','$correcto5','$puntajeCalificacion')")or die(mysqli_error($mysqli));
             //$complemento = "respuesta1='".$opciones1."' AND respuesta2='".$opciones2."' AND respuesta3='".$opciones3."' AND respuesta4='".$opciones4."' AND respuesta5='".$opciones5."'";
        }
       

    }elseif($tipoPregunta == '4'){
        
        $opciones1 = utf8_decode($_POST['completa1']);
        $opciones2 = utf8_decode($_POST['completa2']);
        $opciones3 = utf8_decode($_POST['completa3']);
        $opciones4 = utf8_decode($_POST['completa4']);
        $opciones5 = utf8_decode($_POST['completa5']);
        $correcto = $_POST['correcto'];
        
        
        if($opciones1 != NULL && $opciones2 == NULL && $opciones3 == NULL && $opciones4 == NULL && $opciones5 == NULL ){
            $insertaDatosEvaluacion = $mysqli->query("INSERT INTO evaluacionPrueba(usuario,idEvaluacion,pregunta,tipoPregunta,pregunta1,correcto,puntajeCalificacion)VALUES('$usuario','$idEvaluacion','$pregunta','$tipoPregunta','$opciones1','$correcto','$puntajeCalificacion')");
        }elseif($opciones1 != NULL && $opciones2 != NULL && $opciones3 == NULL && $opciones4 == NULL && $opciones5 == NULL){
            //echo 'A';
            $insertaDatosEvaluacion = $mysqli->query("INSERT INTO evaluacionPrueba(usuario,idEvaluacion,pregunta,tipoPregunta,pregunta1,pregunta2,correcto,puntajeCalificacion)VALUES('$usuario','$idEvaluacion','$pregunta','$tipoPregunta','$opciones1','$opciones2','$correcto','$puntajeCalificacion')");
            //$complemento = "respuesta1='".$opciones1."' AND respuesta2='".$opciones2."'";
        }elseif($opciones1 != NULL && $opciones2 != NULL && $opciones3 != NULL && $opciones4 == NULL && $opciones5 == NULL){
            //echo 'B';
            $insertaDatosEvaluacion = $mysqli->query("INSERT INTO evaluacionPrueba(usuario,idEvaluacion,pregunta,tipoPregunta,pregunta1,pregunta2,pregunta3,correcto,puntajeCalificacion)VALUES('$usuario','$idEvaluacion','$pregunta','$tipoPregunta','$opciones1','$opciones2','$opciones3','$correcto','$puntajeCalificacion')");
            //$complemento = "respuesta1='".$opciones1."' AND respuesta2='".$opciones2."' AND respuesta3='".$opciones3."'";
        }elseif($opciones1 != NULL && $opciones2 != NULL && $opciones3 != NULL && $opciones4 != NULL && $opciones5 == NULL){
             //echo 'C';
             $insertaDatosEvaluacion = $mysqli->query("INSERT INTO evaluacionPrueba(usuario,idEvaluacion,pregunta,tipoPregunta,pregunta1,pregunta2,pregunta3,pregunta4,correcto,puntajeCalificacion)VALUES('$usuario','$idEvaluacion','$pregunta','$tipoPregunta','$opciones1','$opciones2','$opciones3','$opciones4','$correcto','$puntajeCalificacion')");
             //$complemento = "respuesta1='".$opciones1."' AND respuesta2='".$opciones2."' AND respuesta3='".$opciones3."' AND respuesta4='".$opciones4."'";
        }elseif($opciones1 != NULL && $opciones2 != NULL && $opciones3 != NULL && $opciones4 != NULL && $opciones5 != NULL){
            //echo 'D';
            $insertaDatosEvaluacion = $mysqli->query("INSERT INTO evaluacionPrueba(usuario,idEvaluacion,pregunta,tipoPregunta,pregunta1,pregunta2,pregunta3,pregunta4,pregunta5,correcto,puntajeCalificacion)VALUES('$usuario','$idEvaluacion','$pregunta','$tipoPregunta','$opciones1','$opciones2','$opciones3','$opciones4','$opciones5','$correcto','$puntajeCalificacion')");
             //$complemento = "respuesta1='".$opciones1."' AND respuesta2='".$opciones2."' AND respuesta3='".$opciones3."' AND respuesta4='".$opciones4."' AND respuesta5='".$opciones5."'";
        }
       
    }elseif($tipoPregunta == '5'){
        
        $completa = utf8_decode($_POST['completa']);
        $relacionar = $_POST['relacionar'];
        $info = utf8_decode($_POST['info']);
        
       
        $insertaDatosEvaluacion = $mysqli->query("INSERT INTO evaluacionPrueba(usuario,idEvaluacion,pregunta,tipoPregunta,puntajeCalificacion)VALUES('$usuario','$idEvaluacion','$pregunta','$tipoPregunta','$puntajeCalificacion')")or die(mysqli_error($mysqli));
        
        $consultarUltimoRegistro=$mysqli->query("SELECT MAX(id) AS Id FROM evaluacionPrueba WHERE usuario='$usuario' AND tipoPregunta='5' AND idEvaluacion = '$idEvaluacion' ");
        $extraerConsultaUltimRegistro=$consultarUltimoRegistro->fetch_array(MYSQLI_ASSOC);
        $enviarIdPrueba=$extraerConsultaUltimRegistro['Id'];
        
        for ($i = 0, $j = 0, $k= 0; $i<count($completa), $j<count($relacionar),$k<count($info); $i++, $j++,$k++){ 
            
            'Com-'. $completa[$i]; 
            'Rel-'.$relacionar[$j]; 
            'Info-'.$info[$k];
            '<br>';
            
            $insertaDatosEvaluacion = $mysqli->query("INSERT INTO evaluacionRelacional (idEvaluacion,pregunta,relacionar,informacion,tipoPregunta)VALUES('$idEvaluacion','$completa[$i]','$relacionar[$j]','$info[$k]',$enviarIdPrueba)")or die(mysqli_error($mysqli));
        }
        
    }
    
    
    
?>
 <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../evaluacionAgregar" method="POST" onsubmit="procesar(this.action);" >
                                <?php
                                ////// rescatamos el id del editar para mantener la variable activa
                                if($_POST['idEvaluacion'] != NULL){
                                ?>
                                <input name="idEvaluacion" value="<?php echo $_POST['idEvaluacion'];?>" type="hidden">
                                <?php
                                }
                                /// end
                                ?>
                                <input type="hidden" name="validacionActualizar" value="1">
                            </form> 
<?php



}elseif(isset($_POST['editarEvaluacion'])){
   
    $pregunta = utf8_decode($_POST['pregunta']);
    '<br>';
    $idPregunta = $_POST['idPregunta'];
    $tipoPregunta = $_POST['tipoPregunta'];
    $puntajeCalificacion=$_POST['puntajeCalificacion'];
    
    ////////// Se consulta para extraer el id de la evaluacion 
    $consultaEvaluacion=$mysqli->query("SELECT * FROM evaluacion WHERE idUsuario='$usuario' AND estado='proceso' ");
    $extraerConsultaEvaluacion=$consultaEvaluacion->fetch_array(MYSQLI_ASSOC);
    
    $idEvaluacion = $extraerConsultaEvaluacion['id'];
    
    $consultaActualiza = $mysqli->query("UPDATE evaluacion SET nombre='$titulo',encabezado='$descripcion' WHERE id='$idEvaluacion' " ); 
    
    ////////////////////////// Insercion de cada una de las preguntas del formulario en relacion a la evaluacion 
    if($tipoPregunta == '1'){
        $insertaDatosEvaluacion = $mysqli->query("UPDATE evaluacionPrueba SET pregunta = '$pregunta', puntajeCalificacion='$puntajeCalificacion' WHERE id ='$idPregunta'");
    }elseif($tipoPregunta == '2'){ ///// respuesta de si ó no
        $correcto = $_POST['SiNo'];
        $insertaDatosEvaluacion = $mysqli->query("UPDATE evaluacionPrueba SET pregunta = '$pregunta', correcto = '$correcto', puntajeCalificacion='$puntajeCalificacion' WHERE id ='$idPregunta'");
    }elseif($tipoPregunta == '3'){
        $opciones1 = utf8_decode($_POST['opciones1']);
        $opciones2 = utf8_decode($_POST['opciones2']);
        $opciones3 = utf8_decode($_POST['opciones3']);
        $opciones4 = utf8_decode($_POST['opciones4']);
        $opciones5 = utf8_decode($_POST['opciones5']);
        $correcto1 = $_POST['correcto1'];
        $correcto2 = $_POST['correcto2'];
        $correcto3 = $_POST['correcto3'];
        $correcto4 = $_POST['correcto4'];
        $correcto5 = $_POST['correcto5'];
    
        
        $insertaOpcionesEvaluacion = $mysqli->query("UPDATE evaluacionPrueba SET pregunta = '$pregunta', pregunta1='$opciones1', pregunta2='$opciones2', pregunta3='$opciones3', pregunta4='$opciones4', pregunta5='$opciones5', correcto1 = '$correcto1',correcto2 = '$correcto2',correcto3 = '$correcto3',correcto4 = '$correcto4', correcto5='$correcto5', puntajeCalificacion='$puntajeCalificacion' WHERE id ='$idPregunta'");
    }elseif($tipoPregunta == '4'){
        $opciones1 = utf8_decode($_POST['completa1']);
        $opciones2 = utf8_decode($_POST['completa2']);
        $opciones3 = utf8_decode($_POST['completa3']);
        $opciones4 = utf8_decode($_POST['completa4']);
        $opciones5 = utf8_decode($_POST['completa5']);
        $correcto = $_POST['correcto'];
        
        $insertaOpcionesEvaluacionB = $mysqli->query("UPDATE evaluacionPrueba SET pregunta = '$pregunta', pregunta1='$opciones1', pregunta2='$opciones2', pregunta3='$opciones3', pregunta4='$opciones4', pregunta5='$opciones5', correcto = '$correcto', puntajeCalificacion='$puntajeCalificacion' WHERE id ='$idPregunta'");
    }elseif($tipoPregunta == '5'){
        
        $completa = $_POST['completa'];
        $relacionar = $_POST['relacionar'];
        $info = $_POST['info'];
        $idRelacionado = $_POST['idRelacionado'];
       
        $actaulizaDatosEvaluacion = $mysqli->query("UPDATE evaluacionPrueba SET pregunta = '$pregunta', puntajeCalificacion='$puntajeCalificacion' WHERE id = '$idPregunta'");
        
        for ($i = 0, $j = 0, $k= 0 ,$l = 0; $i<count($completa), $j<count($relacionar),$k<count($info), $l< count($idRelacionado); $i++, $j++,$k++,$l++){ 
            
            'Com-'. $completa[$i]; 
            'Rel-'.$relacionar[$j]; 
            'Info-'.$info[$k];
            $idRelacionado[$l];
            
            '<br>';
            $actualizaDatosEvaluacion = $mysqli->query("UPDATE evaluacionRelacional SET pregunta = '".utf8_decode($completa[$i])."',relacionar = '$relacionar[$j]',informacion = '".utf8_decode($info[$k])."' WHERE id = '$idRelacionado[$l]' ");
            
        }
        
    }
?>
 <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../evaluacionAgregar" method="POST" onsubmit="procesar(this.action);" >
                                            <?php
                                            ////// rescatamos el id del editar para mantener la variable activa
                                            if($_POST['idEvaluacion'] != NULL){
                                            ?>
                                            <input name="idEvaluacion" value="<?php echo $_POST['idEvaluacion'];?>" type="hidden">
                                            <?php
                                            }
                                            /// end
                                            ?>
                                <input type="hidden" name="validacionActualizar" value="1">
                            </form> 
<?php



}elseif(isset($_POST['eliminarEvaluacion'])){
                        $id = $_POST['id'];
                        $mysqli->query(" DELETE from evaluacionPrueba  WHERE id = '$id'")or die(mysqli_error($mysqli));
                        $mysqli->query(" DELETE from evaluacionRelacional  WHERE idEvaluacion = '$id'")or die(mysqli_error($mysqli));
                        ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../evaluacionAgregar" method="POST" onsubmit="procesar(this.action);" >
                                            <?php
                                            ////// rescatamos el id del editar para mantener la variable activa
                                            if($_POST['idEvaluacion'] != NULL){
                                            ?>
                                            <input name="idEvaluacion" value="<?php echo $_POST['idEvaluacion'];?>" type="hidden">
                                            <?php
                                            }
                                            /// end
                                            ?>
                                <input type="hidden" name="validacionEliminar" value="1">
                            </form> 
                        <?php
                       // echo '<script language="javascript">
                       // window.location.href="../../agregarProveedoresGrupos"</script>';


}elseif(isset($_POST['eliminarDocumentos'])){
    
    $id = $_POST['id'];
   
    $ConsultaDocumentosEvaluacion = $mysqli->query("SELECT * FROM evaluacionMaterial WHERE id='$id'");
    $extraerConsultaDocumento= $ConsultaDocumentosEvaluacion->fetch_array(MYSQLI_ASSOC);
    $nombreMaterial=utf8_encode($extraerConsultaDocumento['material']);
    $eliminacion=unlink('../../'.$nombreMaterial);
    if($eliminacion != NULL){
        $mysqli->query("DELETE FROM evaluacionMaterial WHERE id = '$id'");
       ?>
            <script> 
                 window.onload=function(){
               
                    document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../evaluacionAgregar" method="POST" onsubmit="procesar(this.action);" >
                                            <?php
                                            ////// rescatamos el id del editar para mantener la variable activa
                                            if($_POST['idEvaluacion'] != NULL){
                                            ?>
                                            <input name="idEvaluacion" value="<?php echo $_POST['idEvaluacion'];?>" type="hidden">
                                            <?php
                                            }
                                            /// end
                                            ?>
                <input type="hidden" name="validacionEliminar" value="1">
                 <input type="hidden" name="id" value="<?php echo $id; ?>">
            </form> 
        <?php
    }else{
        ?>
                <script> 
                     window.onload=function(){
                   
                         document.forms["miformulario"].submit();
                     }
                </script>
                 
                <form name="miformulario" action="../../evaluacionAgregar" method="POST" onsubmit="procesar(this.action);" >
                                            <?php
                                            ////// rescatamos el id del editar para mantener la variable activa
                                            if($_POST['idEvaluacion'] != NULL){
                                            ?>
                                            <input name="idEvaluacion" value="<?php echo $_POST['idEvaluacion'];?>" type="hidden">
                                            <?php
                                            }
                                            /// end
                                            ?>
                    <input type="hidden" name="validacionExisteB" value="1">
                     <input type="hidden" name="id" value="<?php echo $id; ?>">
                </form> 
            <?php
    }
  

}elseif(isset($_POST['cerrarEvaluacion'])){
    $idEvaluacion=$_POST['idEvaluacion'];
    $consultaActualiza = $mysqli->query("UPDATE evaluacion SET estado='finalizado' WHERE id='$idEvaluacion' " ); 
                        ?>
                            <script> 
                                 window.onload=function(){
                                  document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../evaluacion" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionAgregar" value="1">
                            </form> 
                        <?php
}
?>
