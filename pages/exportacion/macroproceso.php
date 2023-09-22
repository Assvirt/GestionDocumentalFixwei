<?php

header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=ListaMacroprocesos.xls');

require '../conexion/bd.php';



$result = $mysqli->query("SELECT * FROM macroproceso  ORDER BY nombre")or die("<marquee><font color='red'>SELECCIONE CENTRO DE TRABAJO</marquee></font>");

?>

<table border="1">
    <tr>
        <th class="text-center">Nombre</th>
	    <th class="text-center"><?php echo utf8_decode('Descripción'); ?></th>
	</tr>
    <?php
        
        while ($columna = mysqli_fetch_array( $result )){
            
    ?>
    
        <tr>
           <td><?php echo $columna['nombre']; ?></td>
           <td><?php echo $columna['descripcion']; ?></td>
        </tr>
        <?php
        }
        ?>
    

</table>