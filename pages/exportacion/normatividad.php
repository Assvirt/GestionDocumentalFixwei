<?php

header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=Normatividad.xls');

require '../conexion/bd.php';


$acentos = $mysqli->query("SET NAMES 'utf8'");
$result = $mysqli->query("SELECT * FROM normatividad  GROUP BY nombre")or die("<marquee><font color='red'>SELECCIONE NORMATIVIDAD</marquee></font>");

?>

<table border="1">
    <tr>
        
        <th class="text-center">Nombre de la norma</th>
		<th class="text-center">Abreviatura</th>
		<th class="text-center"><?php echo utf8_decode('Descripción'); ?></th>
		
		
        
        
    </tr>
    <?php
        
        while ($columna = mysqli_fetch_array( $result )){
            
    ?>
    
        <tr>
            <td><?php echo utf8_decode($columna['nombre']); ?></td>
            <td><?php echo utf8_decode($columna['abreviatura']); ?></td>
            <?php echo '<td style="text-align: justify;">'.nl2br(utf8_decode($columna['descripcion'])).'</td>';//echo utf8_decode($columna['descripcion']); ?>
            
            
            
           
            
        </tr>
        <?php
        }
        ?>
    

</table>