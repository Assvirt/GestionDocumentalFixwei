<?php
header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=ListaProveedor.xls');

require '../conexion/bd.php';
//include '../proveedores.php';

if($_POST['inscripcion'] == 1){
$result = $mysqli->query("SELECT * FROM proveedores WHERE  estado = 'Pendiente' OR estado='Rechazado'  ORDER BY razonSocial ASC")or die("<marquee><font color='red'></marquee></font>");
}else{
$result = $mysqli->query("SELECT * FROM proveedores WHERE  estado='Aprobado'  ORDER BY razonSocial ASC")or die("<marquee><font color='red'></marquee></font>");
}

?>

<table border="1">
    <tr>
        <th class="text-center"><?php echo utf8_decode('N°'); ?></th>
        <th class="text-center">Nit</th>
        <th class="text-center">Contacto</th>
        <th class="text-center"><?php echo utf8_decode('Razón Social');?></th>
        <th class="text-center"><?php echo utf8_decode('Correo Electrónico'); ?></th>
        <th class="text-center"><?php echo utf8_decode('Móvil'); ?></th>
        <th class="text-center"><?php echo utf8_decode('Código Ciiu'); ?></th>
        <th class="text-center"><?php echo utf8_decode('Descripción del Texto'); ?></th>
        <th class="text-center">Criticidad</th>
		<th class="text-center">Grupo</th>
		<th class="text-center"><?php echo utf8_decode('Método de Pago'); ?></th>
		<th class="text-center"><?php echo utf8_decode('Ciudad'); ?></th>
		<th class="text-center"><?php echo utf8_decode('Dirección'); ?></th>
		<th class="text-center"><?php echo utf8_decode('Fecha de actualización de documentos'); ?></th>
		<th class="text-center"><?php echo utf8_decode('Teléfono'); ?></th>
		<th class="text-center"><?php echo utf8_decode('Tiempo para evaluación'); ?></th>
		<th class="text-center"><?php echo utf8_decode('Persona natural/jurídica'); ?></th>
		<th class="text-center">Tipo de proveedor</th>
		<th class="text-center"><?php echo utf8_decode('Aprobación de proveedor'); ?></th>
		<?php
		if($_POST['inscripcion'] == 1){
		?>
		<th class="text-center"><?php echo utf8_decode('Fecha de solicitud'); ?></th>
		<?php
		}else{
		?>
		<th class="text-center"><?php echo utf8_decode('Fecha de aprobación'); ?></th>
		<?php
		}
		?>
	</tr>
    <?php
        
        $conteo=1;
        while ($columna = mysqli_fetch_array( $result )){
            
            $enviarFecha=$columna['creacion'];
    ?>
    
        <tr>
            <td><?php echo $conteo++; ?> </td>
            <td><?php echo $columna['nit'].'-'.$columna['nitDigito']; ?></td>
            <td><?php echo $columna['contacto']; ?></td>
            <td><?php echo $columna['razonSocial']; ?></td>
            <td><?php echo $columna['email']; ?></td>
            <td><?php echo $columna['movil']; ?></td>
            <td><?php echo $columna['codigoCiiu']; ?></td>
            <td><?php echo $columna['descripcion']; ?></td>
            <td><?php 
                    $criticidad=$columna['criticidad']; 
                    $consultaTipoProveedor=$mysqli->query("SELECT * FROM proveedoresCriticidad WHERE id='$criticidad' ORDER BY tipo");
                    $extraerConsultaTipoprove=$consultaTipoProveedor->fetch_array(MYSQLI_ASSOC);
                    echo $extraerConsultaTipoprove['tipo'];
                ?>
            </td>
            <?php
            
             'f. Creacion -->';
            $fechaRegistro=$columna['fecha'];
            $mesesEliminacion = $columna['frecuenciaActualizacionD'];
            $tiempoEvaluacion = $columna['tiempoEvaluacion'];
             '<br>';
             $proximaActualizacion = date("d-m-Y",strtotime($fechaRegistro."+ $mesesEliminacion month")); 
             $fechaEvaluacion = date("d-m-Y",strtotime($fechaRegistro."+ $tiempoEvaluacion month"));
            
            $idGrupo=$columna['grupo'];
            //$acentos = $mysqli->query("SET NAMES 'utf8'");
                     $queryJefeInmediato=$mysqli->query("SELECT * FROM proveedoresGrupo WHERE id='$idGrupo' ");
	                 $rowDatos=$queryJefeInmediato->fetch_array(MYSQLI_ASSOC);
	                 $nombreJefeInmediato=$rowDatos['grupo'];
            ?>
            <td><?php echo $nombreJefeInmediato; ?></td>
            <td><?php echo $columna['tipo'].' '.$columna['terminoPago']; ?></td>
            <?php
            $ciudad = $columna['ciudad'];
            $consultaCiudadNombre=$mysqli->query("SELECT * FROM municipios WHERE id='$ciudad'");
            $extraerCiudad=$consultaCiudadNombre->fetch_array(MYSQLI_ASSOC);
            $ciudadProveedor=$extraerCiudad['nombre'];
            ?>
            <td><?php echo $ciudadProveedor;  ?></td>
            <td><?php echo utf8_decode($columna['direccion']); ?></td>
            <td><?php echo $proximaActualizacion; ?></td>
            <td><?php echo $columna['telefono']; ?></td>
            <td><?php echo $fechaEvaluacion; ?></td>
            <td><?php echo ucwords(utf8_decode($columna['personaNJ'])); ?></td>
            <td><?php 
                    $tipoProveedor=$columna['tipoproveedor']; 
                    $consultaTipoProveedor=$mysqli->query("SELECT * FROM proveedoresTipo WHERE id='$tipoProveedor' ORDER BY tipo");
                    $extraerConsultaTipoprove=$consultaTipoProveedor->fetch_array(MYSQLI_ASSOC);
                    echo $extraerConsultaTipoprove['tipo'];
                ?>
            </td>
            <td>
                <?php
                $tipoResponsableV=$columna['radio'];
                            $personalIDV =  json_decode($columna['aprobador']);
                            $longitudV = count($personalIDV);
                   
                             if($tipoResponsableV == 'usuario'){
                                    for($i=0; $i<$longitudV; $i++){ //// inicia for
                                                
                                                $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$personalIDV[$i]' ");
                                                while($columna = $nombreuser->fetch_assoc()){
                                                    echo $cedulaUsuario=$columna['nombres'].' '.$cedulaUsuario=$columna['apellidos']; echo "<br>";
                                                }
                                            }  /////// cierre del for
                                            
                                            
                                
                            }else{    
                               
                                for($i=0; $i<$longitudV; $i++){ //// inicia for
                                                
                                                $nombreuser = $mysqli->query("SELECT * FROM cargos WHERE id_cargos = '$personalIDV[$i]' ");
                                                while($columna = $nombreuser->fetch_assoc()){
                                                    echo $cedulaUsuario=$columna['nombreCargos']; echo "<br>";
                                                }
                                            }  /////// cierre del for    
                                
                            }
                ?>
            </td>
            <td><?php echo $enviarFecha; ?></td>
        </tr>
        <?php
        }
        ?>
    

</table>