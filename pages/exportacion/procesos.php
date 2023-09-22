<?php

header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=ListaProcesos.xls');

require '../conexion/bd.php';


$acentos = $mysqli->query("SET NAMES 'utf8'");
$data = $mysqli->query("SELECT * FROM procesos WHERE estado IS NULL ORDER BY nombre ASC")or die(mysqli_error());
?>

<table border="1">
    <tr>
        
        <th>Proceso</th>
        <th>Descripci&oacute;n</th>
        <th>Due&ntilde;o Proceso</th>
        <th>Prefijo</th>
        <th>Macroproceso</th>
        
    </tr>
    <?php
        
        while($row = $data->fetch_assoc()){
                 
                    echo"<tr>";
                    echo" <td style='text-align:justify;'>".utf8_decode($row['nombre'])."</td>";
                    echo" <td style='text-align:justify;'>".utf8_decode($row['descripcion'])."</td>";
                    
                    if($row['importacion'] == '1'){    
                        $array = json_decode ($row['duenoProceso']);
                        //var_dump($array);
                        $longitud = count($array);
 
                        //Recorro todos los elementos
                    echo"<td style='text-align:justify;'>";
                        for($i=0; $i<$longitud; $i++){
                            //saco el valor de cada elemento
                            $queryNombres = $mysqli->query("SELECT * FROM cargos WHERE id_cargos = '$array[$i]'");
                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                            
                        	echo "*".utf8_decode($nombres['nombreCargos'])."<br>";
                        }
                    echo "</td>";
                    }else{    
                        $array = json_decode ($row['duenoProceso']);
                        //var_dump($array);
                        $longitud = count($array);
 
                        //Recorro todos los elementos
                    echo"<td style='text-align:justify;'>";
                        for($i=0; $i<$longitud; $i++){
                            //saco el valor de cada elemento
                            $queryNombres = $mysqli->query("SELECT * FROM cargos WHERE id_cargos = '$array[$i]'");
                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                            
                        	echo "*".utf8_decode($nombres['nombreCargos'])."<br>";
                        }
                    echo "</td>";
                    }
                    echo" <td>".utf8_decode($row['prefijo'])."</td>";
                    
                    $idMacroproceso=$row['macroproceso'];
                    $queryNombresMAcroprocesos = $mysqli->query("SELECT * FROM macroproceso WHERE id='$idMacroproceso' ");
                    $nombresMacroproceso = $queryNombresMAcroprocesos->fetch_array(MYSQLI_ASSOC); 
                    if($nombresMacroproceso != NULL){
                        echo" <td>".utf8_decode($nombresMacroproceso['nombre'])."</td>";
                    }else{
                        echo" <td><b>No aplica</b></td>";
                    }
                    echo"</tr>";
                    }
        ?>
    

</table>