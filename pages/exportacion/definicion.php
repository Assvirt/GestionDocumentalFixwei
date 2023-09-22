<?php

header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=ListaDefinicion.xls');

require '../conexion/bd.php';



$result = $mysqli->query("SELECT * FROM definicion  GROUP BY nombre")or die("<marquee><font color='red'>SELECCIONE DEFINICIÓN</marquee></font>");

?>

<table border="1">
    <tr>
        
        <th class="text-center">Nombre</th>
		<th class="text-center"><?php echo utf8_decode('Definición'); ?></th>
		<th class="text-center">Fuente</th>
		
		
        
        
    </tr>
    <?php
        
        while ($columna = mysqli_fetch_array( $result )){
            
    ?>
    
        <tr>
            <td><?php echo $columna['nombre']; ?></td>
            <?php  echo '<td style="text-align: justify;">'.nl2br($columna['definicion']).'</td>'; //echo $columna['definicion']; ?>
            <td><?php echo $columna['fuente']; ?></td>
            
            
            
           
            
        </tr>
        <?php
        }
        ?>
    

</table>