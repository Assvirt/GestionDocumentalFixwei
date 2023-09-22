<?php
error_reporting(E_ERROR);
header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=ListaUsusarios.xls');

require '../conexion/bd.php';


//$acentos = $mysqli->query("SET NAMES 'utf8'");
$result = $mysqli->query("SELECT * FROM usuario ORDER BY nombres ASC")or die("ERROR, comuniquese con el administrador del sistema.");

?>

<table border="1">
    <tr>
        
        <th class="text-center">Nombre y apellidos</th>
		<!--<th class="text-center">Tipo de documento</th>-->
        <th class="text-center">Documento de identidad</th>
		<th class="text-center">Fecha de nacimiento</th>
		<th class="text-center">Correo</th>
		<th class="text-center"><?php echo utf8_decode("Teléfono");?></th>
		<th class="text-center">Proceso</th>
		<th class="text-center">Cargo</th>
		<th class="text-center"><?php echo utf8_decode("Líder");?></th>
		<th class="text-center">Centro de trabajo</th>
	    <th class="text-center">ARL</th>
		<th class="text-center">EPS</th>
		<th class="text-center">AFP</th>
		<th class="text-center"><?php echo utf8_decode("Grupo de distribución");?></th>	
		
        
    </tr>
    <?php
        
        while ($columna = $result->fetch_assoc()){
            
            $cargo = $columna['cargo']; 
            $proceso = $columna['proceso'];
            $lider = $columna['lider'];
            //$idCentroCostos = $columna['idCentroCostos'];
            //$idCentroTrabajo = $columna['idCentroTrabajo'];
            $documento = $columna['cedula'];
            
            
            //////////// datos de los cargos
            $acentos = $mysqli->query("SET NAMES 'utf8'");
                    $query = $mysqli->query("SELECT * FROM cargos WHERE id_cargos='$cargo'");
                    $row = $query->fetch_array(MYSQLI_ASSOC);
                    $nombreCargo= utf8_decode($row['nombreCargos']);  
                        
                    /////////// datos del proceso
                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                    $query = $mysqli->query("SELECT * FROM procesos WHERE id='$proceso'");
                    $row = $query->fetch_array(MYSQLI_ASSOC);
                    $nombreProceso= utf8_decode($row['nombre']); 

                    /////////// datos del lider
                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                    $query = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos='$lider'");
                    $row = $query->fetch_array(MYSQLI_ASSOC);
                    $nombreLider= utf8_decode($row['nombreCargos']);
                    
                    if($nombreLider != NULL){
                        //continue;
                    }else{
                        $nombreLider = 'N/A';
                    }
                 
                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                    $query = $mysqli->query("SELECT * FROM perfiles WHERE cedul = '$documento'");
                    $row = $query->fetch_array(MYSQLI_ASSOC);
                    $nombrePerfil = $row['nomPerfil'];
                    $passw = $row['clave'];
                    
                    if($columna['estadoAnulado'] == 1){
                        $estado = "Anulado";
                    }else{
                        $estado = "Activo";
                    }
                    if($columna['estadoEliminado'] == TRUE){
                        $estado = "Eliminado";
                    }
                    
                    
    ?>
    
        <tr>
            <td><?php echo $columna['nombres']." ".$columna['apellidos']; ?></td>
            <!--<td><?php //if($columna['tipo'] == 1){ echo 'CC'; }else{ echo 'CE'; } ?></td>-->
            <td><?php echo $columna['cedula']; ?></td>
            <td><?php echo $columna['fechaNacimiento']; ?></td>
            <td><?php echo $columna['correo']; ?></td> 
            <td><?php echo $columna['telefono']; ?></td>
            <td><?php echo $nombreProceso; ?></td>
            <td><?php echo $nombreCargo; ?></td>
            <td><?php echo $nombreLider; ?></td>
            <td>
            <?php
            /////////// datos del centro de trabajo para extraer con la CC
            $acentos = $mysqli->query("SET NAMES 'utf8'");
                    $queryC1 = $mysqli->query("SELECT * FROM cTrabajoUusuario WHERE idUsuario='$documento'");
                    while ($rowC1 = $queryC1->fetch_assoc()){
                    $idCentroTrabajoExtraer= $rowC1['idCtrabajo'];
                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                        $queryC = $mysqli->query("SELECT * FROM centrodetrabajo WHERE id_centrodetrabajo='$idCentroTrabajoExtraer'");
                        $row2 = $queryC->fetch_array(MYSQLI_ASSOC);
                        echo $nombreCentroTrabajo= utf8_decode($row2['nombreCentrodeTrabajo']).',';
                    }
            ?>
            </td>
            <td><?php echo ($columna['arl']); ?></td>
            <td><?php echo ($columna['eps']); ?></td>
            <td><?php echo ($columna['afp']); ?></td>
            <td>
            <?php
                $acentos = $mysqli->query("SET NAMES 'utf8'");
                $queryz = $mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario = '$documento'");
                while ($columnaz = mysqli_fetch_array( $queryz )) {
                    $grupo = $columnaz['idGrupo'];
                      /////////// datos del centro de trabajo
                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                    $queryy = $mysqli->query("SELECT nombre FROM grupo WHERE id='$grupo'");
                    $rowy = $queryy->fetch_array(MYSQLI_ASSOC);
                    $nombreGrupo= utf8_decode($rowy['nombre']).',';
                               
            ?>
            <?php echo $nombreGrupo;?>
            <?php }?>
            </td>
        </tr>
        <?php
        }
        ?>
    

</table>