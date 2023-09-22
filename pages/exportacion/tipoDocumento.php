<?php

header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=tipoDocumento.xls');

require '../conexion/bd.php';



$result = $mysqli->query("SELECT * FROM tipoDocumento  GROUP BY nombre");

?>

<table border="1">
    <tr>
        
        <th class="text-center">Tipo de documento</th>
		<th class="text-center">Prefijo</th>
		<th class="text-center">Descripci&oacute;n</th>
		
		
        
        
    </tr>
    <?php
        
        while ($columna = mysqli_fetch_array( $result )){
            
    ?>
    
        <tr>
            <td><?php echo $columna['nombre']; ?></td>
            <td><?php echo $columna['prefijo']; ?></td>
            <td><?php echo $columna['descripcion']; ?></td>
            
            
            
           
            
        </tr>
        <?php
        }
        ?>
    

</table>