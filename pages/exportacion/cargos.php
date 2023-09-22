<?php
error_reporting(E_ERROR);
header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=ListaCargos.xls');

require '../conexion/bd.php';



$result = $mysqli->query("SELECT * FROM cargos  GROUP BY nombreCargos")or die();

?>

<table border="1">
    <tr>
        
        <th class="text-center">Cargos</th>
		<th class="text-center"><?php echo utf8_decode('Descripción'); ?></th>
		<th class="text-center">Jefe inmediato</th>
		<th class="text-center">Nivel cargo</th>
        
        
    </tr>
    <?php
        
        while ($columna = mysqli_fetch_array( $result )){
            
    ?>
    
        <tr>
            <td><?php echo $columna['nombreCargos']; ?></td>
            <td><?php echo $columna['descripcionCargos']; ?></td>
            <?php
            $idJefeInmediato=$columna['jefeInmediatoCargos'];
                     $acentos = $mysqli->query("SET NAMES 'utf8'");
                     $queryJefeInmediato=$mysqli->query("SELECT * FROM cargos WHERE id_cargos='$idJefeInmediato' ");
	                 $rowDatos=$queryJefeInmediato->fetch_array(MYSQLI_ASSOC);
	                 if($rowDatos['id_cargos'] != NULL){
	                     $nombreJefeInmediato=$rowDatos['nombreCargos'];
	                 }else{
	                     $nombreJefeInmediato="N/A";
	                 }
	                 
            ?>
            <td><?php echo utf8_decode($nombreJefeInmediato); ?></td>
            
            <?php
                    $idNivelCargo=$columna['nivelCargo'];
                    $acentos = $mysqli->query("SET NAMES 'utf8'");
            	    $queryCargo=$mysqli->query("SELECT * FROM nivelcargo WHERE id = '$idNivelCargo' ");
            	    $rowDatos=$queryCargo->fetch_array(MYSQLI_ASSOC);
            	    $NombreCargo=$rowDatos['nivelCargo'];
            	    
            	    if($NombreCargo != NULL){;
            	         $NombreCargo=$rowDatos['nivelCargo'];
            	    }else{
            	        $NombreCargo = 'N/A';
            	    }
            ?>
            <td><?php echo utf8_decode($NombreCargo); ?></td>
           
            
        </tr>
        <?php
        }
        ?>
    

</table>