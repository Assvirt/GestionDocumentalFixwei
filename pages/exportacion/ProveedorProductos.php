<?php

header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=ListaProductos.xls');

require '../conexion/bd.php';


$idProveedor=$_POST['idProveedor'];
$result = $mysqli->query("SELECT * FROM proveedorProductos  ORDER BY nombre ASC")or die("<marquee><font color='red'>SELECCIONE PRODUCTOS</marquee></font>");

?>

<table border="1">
    <tr>
        
        <th class="text-center">Tipo de producto</th>
        <th class="text-center">Nombre del bien o servicio</th>
        <th class="text-center"><?php echo utf8_decode('Descripción del bien o servicio'); ?></th>
        <th class="text-center">Grupo y Subgrupo</th>
		<th class="text-center"><?php echo utf8_decode('Código'); ?></th>
		<th class="text-center">Identificador</th>
		<th class="text-center">Impuesto</th>
		
		
		
	    <th class="text-center">Unidad de empaque</th>
		<th class="text-center">Unidad de medida</th>
		<th class="text-center">Proveedor Sugerido</th>
		<th class="text-center">Inventario</th>
		<th class="text-center">Activo</th>
		<th class="text-center">Tiempo de servicio</th>
		<th class="text-center">Cantidad de tiempo de servicio</th>
	
		
        
        
    </tr>
    <?php
        
        while ($columna = mysqli_fetch_array( $result )){
            
    ?>
    
        <tr>
            <td>
                <?php
                $tipoProducto=$columna['tipoProducto'];
                if($tipoProducto == 1){
                    echo 'Bienes';
                }else{
                    echo 'Servicios';
                }
                ?>
            </td>
            <td><?php echo $columna['nombre']; ?></td>
            <td><?php echo $columna['descripcion']; ?></td>
            <td>
                <?php
                $idGrupo=$columna['grupo'];
                $grupo=$mysqli->query("SELECT * FROM proveedoresProductoGrupo WHERE id='$idGrupo' ");
                $extraerGrupo=$grupo->fetch_array(MYSQLI_ASSOC);
                $subgrupo=$mysqli->query("SELECT * FROM proveedoresProductoGrupo WHERE id='".$extraerGrupo['sub']."' ");
                $extraersubgrupo=$subgrupo->fetch_array(MYSQLI_ASSOC);
                
                echo $extraerGrupo['grupo'].' - '.$extraersubgrupo['grupo'].' - '.$columna['codigoG'];
                echo '    ('.$extraerGrupo['descripcion'].' - '.$extraersubgrupo['descripcion'].')';
                ?>
            </td>
            <td><?php echo $columna['codigo']; ?></td>
            <td><?php 
                
                $unidadIdentificador=$mysqli->query("SELECT * FROM proveedoresProductoIdentificador WHERE id='".$columna['identificador']."' ORDER BY grupo ");
                $extraerIdentificador=$unidadIdentificador->fetch_array();
                echo $extraerIdentificador['grupo'];
                ?>
            </td>
            <td>
                <?php 
                 $consultaImpuesto=$columna['impuesto']; 
                 
                 if($consultaImpuesto == 'N/A'){
                    echo 'N/A';
                 }else{
                 $consultaImpuestos=$mysqli->query("SELECT * FROM proveedoresTipoImpuesto WHERE id='$consultaImpuesto' ");
                 $extraerConsultaImpuestos=$consultaImpuestos->fetch_array(MYSQLI_ASSOC);
                    echo $extraerConsultaImpuestos['grupo'].' '.$extraerConsultaImpuestos['descripcion'].' %';
                 }
                ?>
            </td>
            
            
             <td>
                <?php
                 if($tipoProducto == '1'){
                     $tipoProductoMedida=$columna['presentacion'];
                     $unidadEmpaque=$mysqli->query("SELECT * FROM proveedoresProductoEmpaque WHERE id='$tipoProductoMedida' ");
                     $extraerUnidadEmpaque=$unidadEmpaque->fetch_array(MYSQLI_ASSOC);
                     echo $extraerUnidadEmpaque['grupo'].'-'.$extraerUnidadEmpaque['descripcion'];
                     
                 }
                ?>
            </td>
            <td>
                <?php
                 if($tipoProducto == '1'){
                     $tipoProductoMedida=$columna['presentacionb'];
                     $unidadEmpaque=$mysqli->query("SELECT * FROM proveedoresProductoMedida WHERE id='$tipoProductoMedida' ");
                     $extraerUnidadEmpaque=$unidadEmpaque->fetch_array(MYSQLI_ASSOC);
                     echo $extraerUnidadEmpaque['grupo'].'-'.$extraerUnidadEmpaque['descripcion'];
                     
                 }
                ?>
            </td>
           
            <td>
                <?php
                $consultarProveedor=$columna['proveedor'];
                $proveedor=$mysqli->query("SELECT * FROM proveedores WHERE id='$consultarProveedor' ");
                $extraerConsultaProveedor=$proveedor->fetch_array(MYSQLI_ASSOC);
                echo $extraerConsultaProveedor['razonSocial'];
                ?>
            </td>
            <td>
                <?php
                    echo $columna['inventario'];
                ?>
            </td>
            <td>
                <?php
                    echo $columna['activo'];
                ?>
            </td>
            <td>
                <?php
                if($tipoProducto == 1){
                    
                }else{
                    $tiempoServicio=$columna['tiempoServicio']; 
                    $cantidadTiempoServicio=$columna['cantidadTiempoServicio'];
                    $buscaTiempo=$mysqli->query("SELECT * FROM proveedoresProductoTiempo WHERE id='$tiempoServicio' ORDER BY id ");
                    $extraerDatos=$buscaTiempo->fetch_array(MYSQLI_ASSOC);
                    //echo $cantidadTiempoServicio.' ';
                    echo $extraerDatos['grupo'];    
                }
                ?>
            </td>
            <td>
                <?php
                if($tipoProducto == 1){
                    
                }else{
                    echo $cantidadTiempoServicio=$columna['cantidadTiempoServicio'];
                        
                }
                ?>
            </td>
            
            
        </tr>
        <?php
        }
        ?>
    

</table>