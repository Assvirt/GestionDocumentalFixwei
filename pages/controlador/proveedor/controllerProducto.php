<?php
require_once '../../conexion/bd.php';
mb_internal_encoding("UTF-8");
error_reporting(E_ERROR);

if(isset($_POST['Agregar'])){
    
$idProveedor=$_POST['idProveedor'];    
$nombre = utf8_decode($_POST['nombre']);
$descripcion = utf8_decode($_POST['descripcion']);
$identificador = utf8_decode($_POST['identificador']);
$codigo = utf8_decode($_POST['codigo']);
$costo = $_POST['costo'];

$impuesto = $_POST['impuesto'];
//$fecha = $_POST['fecha'];
//$imagen = $_FILES['imagen']['name'];
//$imagen= Addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
$imagen = $_POST['imagen'];
///// datos faltantes del formulario


if($_POST['opcion'] == '1'){
    'unidad de empaque:'.$presentacion = utf8_decode($_POST['presentaciona']);
    'unidad de medida:'.$presentacionb = utf8_decode($_POST['presentacionb']);
}

if($_POST['opcion'] == '2'){
    
}


$opcion=$_POST['opcion'];
$grupo=$_POST['grupo'];
//$empaque=$_POST['empaque'];
$proveedor=$_POST['proveedor'];
$inventario=$_POST['inventario'];
$activo=$_POST['activo'];
//$medida=$_POST['medida'];

/// END



//// agregamos los tiempos de servicio
$tiempoServicio=$_POST['tiempoServicio']; /// opciones
$cantidadTiempoServicio=$_POST['cantidadTiempoServicio']; // numerico
/// END
    
    
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
   
    
    $validacion = $mysqli->query("SELECT * FROM proveedorProductos WHERE nombre ='$nombre' ")or die (mysqli_error());
    $numRows = mysqli_num_rows($validacion);
    if($numRows > 0){
          'Nom: '.$nombreValidar='1';
    } 
     
    $validacionB = $mysqli->query("SELECT * FROM proveedorProductos WHERE identificador ='$identificador' ")or die (mysqli_error());
    $numRowsB = mysqli_num_rows($validacionB);
    if($numRowsB > 0){
          'Inden: '.$identificadorValidar='1';
    }
    
    $validacionC = $mysqli->query("SELECT * FROM proveedorProductos WHERE codigo ='$codigo'")or die (mysqli_error());
    $numRowsC = mysqli_num_rows($validacionC);
    if($numRowsC > 0){
          'Codi: '.$CodigoValidar='1';
    }
    
    
    if($nombreValidar == '1'  || $CodigoValidar == '1' ){ //|| $identificadorValidar == '1'
    
        if($nombreValidar == '1'){
            $mensajeAlerta='validacionExiste';
        }else{
            $mensajeAlerta='validacionExisteCodigo';
        }
                            ?>
                                <script>
                                        window.onload=function(){
                                            //alert("El identificador ya existe");
                                            document.forms["miformulario"].submit();
                                            }
                                </script>
                                <form name="miformulario" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                                   <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                                   <input type="hidden" name="<?php echo $mensajeAlerta;?>" value="1">
                                </form>
                                
                            <?php
    }else{
        
        
        
        /// validaciones para el incremento del producto
         'Grupo entrante: '.$grupo;
         '<br>';
        $validarUltimoGrupo=$mysqli->query("SELECt * FROM proveedorProductos WHERE grupo='$grupo' ORDER BY codigoG DESC");
        $extraerUltimoGrupo=$validarUltimoGrupo->fetch_array(MYSQLI_ASSOC);
      
         'Grupo saliente: '.$ultimoGrupoIngresado=$extraerUltimoGrupo['grupo'];
         '<br>';
         'Codigo G: '.$ultimoGrupoIngresadocodigo=$extraerUltimoGrupo['codigoG'];
         '<br>';
        if($ultimoGrupoIngresadocodigo != NULL){
             'B: '.$conteoNumero=$ultimoGrupoIngresadocodigo+1; 
        }else{
             'A: '.$conteoNumero='1';
        }
        
         '<br>';
         $conteoNumero;
        
        $mysqli->query("INSERT INTO proveedorProductos (nombre, descripcion, identificador,  presentacion, presentacionb, imagen, codigo,impuesto,inventario,activo,tipoProducto,proveedor,grupo,codigoG,tiempoServicio,cantidadTiempoServicio,documentos)
        VALUES('$nombre','$descripcion','$identificador','$presentacion','$presentacionb','','$codigo','$impuesto','$inventario','$activo','$opcion','$proveedor','$grupo','$conteoNumero','$tiempoServicio','$cantidadTiempoServicio','$imagen') ")or die(mysqli_error($mysqli));
        
        
        $queryId = $mysqli->query("SELECT MAX(id) AS id FROM `proveedorProductos` ");
        $datos = $queryId->fetch_array(MYSQLI_ASSOC);
        
        if($imagen == '1'){
                        ?>
                            <script>
                                    window.onload=function(){
                                       
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../agregarProveedorProductoArchivos" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionAgregar" value="<?php echo $datos['id'];?>">
                               <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                            </form>
                            
                        <?php    
        }else{
        
                        ?>
                            <script>
                                    window.onload=function(){
                                        //alert("El producto ha sido creado con éxito");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionAgregar" value="1">
                               <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                            </form>
                            
                        <?php
        } 
    }
    
    

}elseif(isset($_POST['Actualizar'])){
    
    'Id Proveedor-->'.$idProveedor=$_POST['proveedor'];
    '<br>';
    'Id Proveedor Producto-->'.$id= $_POST['id'];
    '<br>';
    'Nombre-->'.$nombre = utf8_decode($_POST['nombre']);
    '<br>';
    'Descripcion-->'.$descripcion = utf8_decode($_POST['descripcion']);
    '<br>';
    'Identicador-->'.$identificador = utf8_decode($_POST['identificador']);
    '<br>';
    'Codigo-->'.$codigo = utf8_decode($_POST['codigo']);
    '<br>';
    'Tipo-->'. $tipoPorducto= $_POST['opcion'];
    '<br>';
   // echo 'Costo-->'.$costo = $_POST['costo'];
    //echo '<br>';
    
    '<br>';
    if($tipoPorducto == '1'){
         'Presentacion-->'.$presentacion = ($_POST['presentaciona']);
         '<br>Presentacionb-->'.$presentacionb = ($_POST['presentacionb']);
    }
     if($tipoPorducto == '2'){
        
    }
    'Impuesto-->'.$impuesto = $_POST['impuesto'];
    '<br>';
    $activo = $_POST['activo'];
    $inventario = $_POST['inventario'];
    //$fecha = $_POST['fecha'];
    '<br>';
    echo $imagen= Addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
    '<br>';
    $id;
 
//// agregamos los tiempos de servicio
$tiempoServicio=$_POST['tiempoServicio']; /// opciones
$cantidadTiempoServicio=$_POST['cantidadTiempoServicio']; // numerico
/// END
 
 
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
    
    
    if($identificador != NULL){
       $identificadorV=$identificador;
    }else{
        $identificadorV='NULL';
            
    }
    
    
    $validacion = $mysqli->query("SELECT * FROM proveedorProductos WHERE nombre ='$nombre'  AND codigo ='$codigo' AND id != '$id' "); //AND identificador ='$identificadorV'
    $numRows = mysqli_num_rows($validacion);
    if($numRows > 0){
         ?>
                            <script>
                                    window.onload=function(){
                                        //alert("El producto no existe");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idProveedorProducto" value="<?php echo $id; ?>" type="hidden" readonly>
                               <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                               <input type="hidden" name="validacionExiste" value="1">
                            </form>
                            
                        <?php
    }else{
        $validadoEditar='1'; 
    }
        
        
        
        /*$validacion = $mysqli->query("SELECT * FROM proveedorProductos WHERE  nombre ='$nombre' AND codigo ='$codigo'  AND id != '$id' ");
        $numRows = mysqli_num_rows($validacion);
        if($numRows > 0){
             ?>
                            <script>
                                    window.onload=function(){
                                        //alert("El producto no existe");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idProveedorProducto" value="<?php echo $id; ?>" type="hidden" readonly>
                               <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                               <input type="hidden" name="validacionExiste" value="1">
                            </form>
                            
                        <?php
        }else{*/
        $validadoEditarB='1';
        
        $grupo= $_POST['grupo'];   
           
        $consultamosExistenciaGrupo=$mysqli->query("SELECT * FROM proveedorProductos WHERE id='$id' AND grupo='$grupo' ");
        $extraerExistenciaGrupo=$consultamosExistenciaGrupo->fetch_array(MYSQLI_ASSOC);
        $confirmarValidacion=$extraerExistenciaGrupo['id'];
        
        if($confirmarValidacion == $id){
             'No se realiza modificaciones';
        }else{
            
            /// validamos el grupo anterior para cambiar el consecutivo
            $consultamosExistenciaGrupoAnterior=$mysqli->query("SELECT * FROM proveedorProductos WHERE id='$id' ");
            $extraerExistenciaGrupoAnterior=$consultamosExistenciaGrupoAnterior->fetch_array(MYSQLI_ASSOC);
            $confirmarValidacionAnterior=$extraerExistenciaGrupoAnterior['grupo'];
            $confirmarConsecutivoAnterior=$extraerExistenciaGrupoAnterior['codigoG'];
             '<br>';
             'grupo anterior: '.$confirmarValidacionAnterior;
              '<br>';
             'consecutivo anterior: '.$confirmarConsecutivoAnterior;
            // end
            
             echo '<br>'; echo '<br>';
            $cambiamosConsecutivos=$mysqli->query("SELECT * FROM proveedorProductos WHERE grupo='$confirmarValidacionAnterior' ");
            while($recorridoConsecutivos=$cambiamosConsecutivos->fetch_array()){
                if($confirmarConsecutivoAnterior < $recorridoConsecutivos['codigoG']){
                 'consecutivos: '.$recorridoConsecutivos['codigoG'];     
                 '--';
                 'Id: '.$recorridoConsecutivos['id']; 
                 '<br>';
                 'Restamos: '.$restamosConsecutivos=ABS($recorridoConsecutivos['codigoG']-1);
                $mysqli->query("UPDATE proveedorProductos SET codigoG='$restamosConsecutivos' WHERE id='".$recorridoConsecutivos['id']."' ");
                }
            }
            
            
             echo '<br>';
            
            
             echo '<br>'; echo '<br>';
            
             'Grupo entrante: '.$grupo;
             '<br>';
            $validarUltimoGrupo=$mysqli->query("SELECt * FROM proveedorProductos WHERE grupo='$grupo' ORDER BY codigoG DESC");
            $extraerUltimoGrupo=$validarUltimoGrupo->fetch_array(MYSQLI_ASSOC);
          
             'Grupo saliente: '.$ultimoGrupoIngresado=$extraerUltimoGrupo['grupo'];
             '<br>';
             'Codigo G: '.$ultimoGrupoIngresadocodigo=$extraerUltimoGrupo['codigoG'];
             '<br>';
            if($ultimoGrupoIngresadocodigo != NULL){
                 'B: '.$conteoNumero=$ultimoGrupoIngresadocodigo+1; 
            }else{
                 'A: '.$conteoNumero='1';
            }
            
             '<br>';
             $conteoNumero;
        }
          
           
        
        if($tipoPorducto == 1){
  
            if($imagen != NULL){
                $mysqli->query("UPDATE proveedorProductos SET codigo='$codigo', nombre='$nombre', descripcion='$descripcion', identificador='$identificador', presentacion='$presentacion', presentacionb='$presentacionb', proveedor='0',impuesto='$impuesto',imagen='$imagen',tipoProducto='$tipoPorducto',inventario='$inventario',activo='$activo', grupo='$grupo', codigoG='$conteoNumero', tiempoServicio='$tiempoServicio', cantidadTiempoServicio='$cantidadTiempoServicio' WHERE id = '$id'")or die(mysqli_error($mysqli));
            }else{ 
                $mysqli->query("UPDATE proveedorProductos SET codigo='$codigo', nombre='$nombre', descripcion='$descripcion', identificador='$identificador', presentacion='$presentacion', presentacionb='$presentacionb', proveedor='0',impuesto='$impuesto',tipoProducto='$tipoPorducto',inventario='$inventario',activo='$activo', grupo='$grupo', codigoG='$conteoNumero', tiempoServicio='$tiempoServicio', cantidadTiempoServicio='$cantidadTiempoServicio' WHERE id = '$id'")or die(mysqli_error($mysqli));
            }
        }
        if($tipoPorducto == 2){
   
            if($imagen != NULL){
                $mysqli->query("UPDATE proveedorProductos SET codigo='$codigo', nombre='$nombre', descripcion='$descripcion', identificador='$identificador', proveedor = '$idProveedor', impuesto='$impuesto',imagen='$imagen',tipoProducto='$tipoPorducto', grupo='$grupo', codigoG='$conteoNumero', inventario=NULL,activo=NULL, tiempoServicio='$tiempoServicio', cantidadTiempoServicio='$cantidadTiempoServicio' WHERE id = '$id'")or die(mysqli_error($mysqli));
            }else{
                $mysqli->query("UPDATE proveedorProductos SET codigo='$codigo', nombre='$nombre', descripcion='$descripcion', identificador='$identificador', proveedor = '$idProveedor', impuesto='$impuesto',tipoProducto='$tipoPorducto', grupo='$grupo', codigoG='$conteoNumero',inventario=NULL,activo=NULL, tiempoServicio='$tiempoServicio', cantidadTiempoServicio='$cantidadTiempoServicio' WHERE id = '$id'")or die(mysqli_error($mysqli));
            }
        
            
        }
        
            ?>
                                <script>
                                        window.onload=function(){
                                         
                                           document.forms["miformulario"].submit();
                                            }
                                </script>
                                <form name="miformulario" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                                   <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                                   <input type="hidden" name="validacionActualizar" value="1">
                                </form>
                                
            <?php
        
}     

if(isset($_POST['Eliminar'])){
    
                        $idProveedor=$_POST['idProveedor'];
                        $id = $_POST['idProveedorProducto'];
                       
                        
                        $ConsultaDocumento = $mysqli->query("SELECT * FROM proveedorProductosDocumentos WHERE idProducto='$id'");
                        while($extraerConsultaDocumento= $ConsultaDocumento->fetch_array()){
                             $IdOrden=utf8_encode($extraerConsultaDocumento['file_name']);
                             '-'.$idElminacion; 
                            $eliminacion=unlink('../../almacenamientoMultipleProductos/uploads/'.$IdOrden);
                            $mysqli->query("DELETE FROM proveedorProductosDocumentos WHERE idProducto='$id'")or die(mysqli_error($mysqli));
                        }
                         $mysqli->query("DELETE from proveedorProductos  WHERE id = '$id'")or die(mysqli_error($mysqli));
                    ?>
                            <script>
                                    window.onload=function(){
                                        //alert("El producto ha sido eliminado con éxito");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../proveedorProductos" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                               <input type="hidden" name="validacionEliminar" value="1">
                            </form>
                            
                        <?php
    
 }
 
?>