<?php

header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=ListaCentrodeCostos.xls');

require '../conexion/bd.php';



$result = $mysqli->query("SELECT * FROM centroCostos  GROUP BY id")or die(MYSQLI_ERROR());

?>

<table border="1">
    <tr>
        <th class="text-center">CODIGO</th>
        <th class="text-center">PREFIJO</th>
        <th class="text-center">CENTRO DE COSTO</th>
        <th class="text-center">CARGO DEL DUE&Ntilde;O DEL CENTRO DE COSTO</th>
        <th class="text-center">CENTRO DE TRABAJO</th>
        <th class="text-center">PERSONA RESPONSABLE</th>
		
	
		
        
        
    </tr>
    <?php
        
        while ($columna = mysqli_fetch_array( $result )){
            
    ?>
    
        <tr>
            <td><?php echo $columna['codigo']; ?></td>
            <td><?php echo $columna['prefijo']; ?></td>
            <td><?php echo $columna['nombre']; ?></td>
            
            <?php
            $idJefeInmediato=$columna['idCargo'];
            $acentos = $mysqli->query("SET NAMES 'utf8'");
                     $queryJefeInmediato=$mysqli->query("SELECT * FROM cargos WHERE id_cargos='$idJefeInmediato' ");
	                 $rowDatos=$queryJefeInmediato->fetch_array(MYSQLI_ASSOC);
	                 $nombreJefeInmediato=$rowDatos['nombreCargos'];
	                 if($nombreJefeInmediato != NULL){
            ?>
            <td><?php echo utf8_decode($nombreJefeInmediato); ?></td>
            <?php
	                 }else{
	       ?>     
	       <td><?php echo '<b>No aplica</b>'; ?></td>        
	        <?php             
	                 }
            $idCT=$columna['idCentroTrabajo'];
            $acentos = $mysqli->query("SET NAMES 'utf8'");
                     $query=$mysqli->query("SELECT * FROM centrodetrabajo WHERE id_centrodetrabajo='$idCT' ");
	                 $rowDato=$query->fetch_array(MYSQLI_ASSOC);
	                 $nombre=$rowDato['nombreCentrodeTrabajo'];
            ?>
            <td><?php echo utf8_decode($nombre); ?></td>
            
            <?php
             $query=$mysqli->query("SELECT * FROM usuario WHERE id='".$columna['persona']."' ");
	                 $rowDato=$query->fetch_array(MYSQLI_ASSOC);
	                 $nombre=$rowDato['nombres'].' '.$rowDato['apellidos'];
            ?>
            <td><?php echo utf8_decode($nombre); ?></td>
            
           
            
        </tr>
        <?php
        }
        ?>
    

</table>