<?php
header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=Productos.xls');

require '../conexion/bd.php';
//include '../proveedores.php';

$acentos = $mysqli->query("SET NAMES 'utf8'");
$result = $mysqli->query("SELECT * FROM proveedorProductos ORDER BY nombre ASC");


?>

<table border="1">
    <tr>
       
        <th class="text-center">Producto</th>
        <th class="text-center">Codigo</th>
		<th class="text-center">Identificador</th>
		
		
        
        
    </tr>
    <?php
        
        $conteo=1;
        while ($columna = mysqli_fetch_array( $result )){
            
    ?>
    
        <tr>
            
            <td><?php echo utf8_decode($columna['nombre']); ?></td>
            <td><?php echo utf8_encode($columna['codigo']); ?></td>
            <td><?php 
                $consultaidentificadorProducto=$mysqli->query("SELECT * FROM proveedoresProductoIdentificador WHERE id='".$columna['identificador']."' ");
                $traerDAtosconsultaidentificadorProducto=$consultaidentificadorProducto->fetch_array(MYSQLI_ASSOC);
                echo utf8_encode($traerDAtosconsultaidentificadorProducto['grupo']);
                ?>
            </td>
             
        </tr>
        <?php
        }
        ?>
    

</table>