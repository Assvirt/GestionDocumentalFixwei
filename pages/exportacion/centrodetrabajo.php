<?php

header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=ListaCentrodeTrabajo.xls');

require '../conexion/bd.php';


$acentos = $mysqli->query("SET NAMES 'utf8'");
$result = $mysqli->query("SELECT * FROM centrodetrabajo  ORDER BY nombreCentrodeTrabajo ASC ")or die("<marquee><font color='red'>SELECCIONE CENTRO DE TRABAJO</marquee></font>");

?>

<table border="1">
    <tr>
        <th class="text-center">Centro de trabajo</th>
        <th class="text-center">Prefijo</th>
		<th class="text-center">Cargos asociado</th>
		
        
        
    </tr>
    <?php
        
        while ($columna = mysqli_fetch_array( $result )){
            
    ?>
    
        <tr>
            <td><?php echo utf8_decode($columna['nombreCentrodeTrabajo']); ?></td>
            <td><?php echo utf8_decode($columna['prefijoCentrodeTrabajo']); ?></td>
            <?php
               if($columna['estilo'] == '1'){ // si viene por importación no me trae ID si no me trae nombres
                	        $personalCargosAsociados =  json_decode($columna['cargosAsociadoss']);
                	        $longitud = count($personalCargosAsociados);
                                // traemos el JSON para sacar los ID y traer los nombres de los cargos asociados
                                if($columna['cargosAsociadoss'] == '[""]'){
                                    echo "<td style='text-align:justify;' class='text-center'><b>" .  'No aplica' . "</b></td>";
                                }else{
                                    if($columna['cargosAsociadoss'] != NULL){
                                            echo"<td style='text-align:justify;' class='text-center'>";
                                            for($i=0; $i<$longitud; $i++){
                                                
                                                $nombreuCargos = $mysqli->query("SELECT * FROM cargos WHERE nombreCargos LIKE '%$personalCargosAsociados[$i]%'");
                                                $columna = $nombreuCargos->fetch_array(MYSQLI_ASSOC);
                                            
                                                echo '*'.utf8_decode($columna['nombreCargos']); echo "<br>";
                                               
                                            } echo"</td>";
                                        
                            	    }else{
                            	       
                            	        echo "<td style='text-align:justify;' class='text-center'><b>" .  'No aplica' . "</b></td>";
                            	        
                            	    }
                                }
                	    }else{
                	    
                	    $personalID =  json_decode($columna['cargosAsociadoss']);
                	     $longitud = count($personalID);
                                // traemos el JSON para sacar los ID y traer los nombres de los cargos asociados
                            if($columna['cargosAsociadoss'] == '0'){
                                 echo "<td style='text-align:justify;' class='text-center'><b>" .  'No aplica' . "</b></td>";
                            }else{
                                if($columna['cargosAsociadoss'] != NULL){
                                        echo"<td style='text-align:justify;' class='text-center'>";
                                        for($i=0; $i<$longitud; $i++){
                                            
                                            $nombreuCargos = $mysqli->query("SELECT * FROM cargos WHERE id_cargos = '$personalID[$i]'");
                                            $columna = $nombreuCargos->fetch_array(MYSQLI_ASSOC);
                                        
                                            echo '*'.utf8_decode($columna['nombreCargos']); echo "<br>";
                                           
                                        } echo"</td>";
                                    
                        	    }else{
                        	       
                        	        echo "<td style='text-align:justify;' class='text-center'><b>" .  'No aplica' . "</b></td>";
                        	        
                        	    }    
                            }
                	    }
            ?>
            
        </tr>
        <?php
        }
        ?>
    

</table>