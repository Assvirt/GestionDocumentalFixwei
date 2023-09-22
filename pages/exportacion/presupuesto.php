<?php

error_reporting(E_ERROR);
header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=ListaPesupuesto.xls');

require '../conexion/bd.php';



$result = $mysqli->query("SELECT * FROM presupuesto  ORDER BY nombre ASC")or die("<marquee><font color='red'>SELECCIONE CARGOS</marquee></font>");

?>

<table border="1">
    <tr>
        <th class="text-center">N°</th>
        <th class="text-center">Nombre del presupuesto</th>
        <th class="text-center">Total presupuesto</th>
        <th class="text-center">Total ejecutado</th>
        <th class="text-center">Disponible</th>
        <th class="text-center">Responsable</th>
		<th class="text-center">Periodo</th>
	
		
        
        
    </tr>
   <tbody>
                     <?php
                    
                         $acentos = $mysqli->query("SET NAMES 'utf8'");
                        $data = $mysqli->query("SELECT * FROM presupuesto ORDER BY nombre ASC")or die(mysqli_error());
                    
                     $conteo=1;
                     while($row = $data->fetch_assoc()){
                        $id = $row['id'];
                                echo"<tr>";
                                echo"<td>".$conteo++."</td>";
                                echo "<td>".utf8_decode($row['nombre'])."</td>";
                                $totalPresupuesto=$row['totalPresupuesto'];
                                echo "<td> $ ".number_format($totalPresupuesto,0,'.',',') ."</td>";
                                
                                
                                $totalEjecutado=$row['totalEjecutado'];
                                
                                echo '<td>';
                                //// obtenemos el id del responsable
                                //echo '<b>Id responsable: </b>'.$row['responsable'];
                                //echo '<br>';
                               
                                $consultaSolicitudCompra=$mysqli->query("SELECT * FROM solicitudCompraFlujo WHERE idUsuario='".$row['responsable']."' AND rol='1' ");
                                $contadorTotal='0';
                                while($extraerCentroCostoSolicituCompra=$consultaSolicitudCompra->fetch_array()){
                                    
                                    /// validamos solo los que están aprobados
                                    $aprobadosTotales=$mysqli->query("SELECT * FROM solicitudComprador WHERE idSolicitud='".$extraerCentroCostoSolicituCompra['idSolicitud']."' AND estado='ejecutado' ");
                                    $validamosEjecutados=$aprobadosTotales->fetch_array(MYSQLI_ASSOC);
                                    if($validamosEjecutados['idSolicitud'] == $extraerCentroCostoSolicituCompra['idSolicitud']){
                                        
                                    }else{
                                        continue;
                                    }
                                    // ENd
                                    
                                    
                                     '<b>*Porcentaje para aplicar :</b> '. $extraerCentroCostoSolicituCompra['porcentaje'].'%';
                                    $variableCentroCostoId=$extraerCentroCostoSolicituCompra['porcentaje'];
                                     '<br>';
                                    $solicitudFinalizada=$mysqli->query("SELECT * FROM solicitudComprador WHERE idSolicitud='".$extraerCentroCostoSolicituCompra['idSolicitud']."' ");
                                    $extraerSolicituFinal=$solicitudFinalizada->fetch_array(MYSQLI_ASSOC);
                                    
                                    if($variableCentroCostoId == '100'){  /// cuanto es el 100 % se trae el totl directamente
                                    
                                      'Total: '.'$ '.$extraerSolicituFinal['total'];
                                     $presupuesto=$extraerSolicituFinal['total'];
                                     
                                    }else{ // cuando no e sel 100 % se debe calcular
                                      '$ '.$presupuesto=$extraerSolicituFinal['total'];
                                      '<br><b>Se debe aplicar este % $'.number_format($presupuesto*($extraerCentroCostoSolicituCompra['porcentaje']/100));
                                     $presupuesto=$presupuesto*($extraerCentroCostoSolicituCompra['porcentaje']/100);
                                    }
                                    
                                    $contadorTotal+=$presupuesto;
                                     '<br><br>';
                                }
                                
                                echo '$'.number_format($contadorTotal);
                    echo '</td>';
                    
                    $calculandoDisponible=ABS($contadorTotal-$totalPresupuesto);
                    echo "<td> $ ". number_format($calculandoDisponible,0,'.',',')."</td>";
                    
                    
                    
                    
                    
                            $tipoResponsable=$row['tipoResponsable'];
                            //$personalID =  json_decode($row['responsable']);
                            //$longitud = count($personalID);
                             //if($tipoResponsable == 'usuario'){
                                    echo"<td>";
                                    //for($i=0; $i<$longitud; $i++){
                                        
                                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '".$row['responsable']."' "); //'$personalID[$i]'
                                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                    
                                        echo utf8_decode($columna['nombres']." ".$columna['apellidos']);echo "<br>";
                                        $cedulaUsuario=$columna['cedula'];
                                    //} 
                                    echo"</td>";
                                 
                                /*}else{
                                    echo"<td>";
                                    for($i=0; $i<$longitud; $i++){
                                    $nombrecargo = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$personalID[$i]'");
                                    $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                    echo $carga = $columna['nombreCargos']; echo "<br>";
                                    } "</td>";
                                }*/
                    
                    echo" <td>".$row['periodo']."</td>";
            	    echo"<form action='presupuestoVer' method='POST'>";
                    echo"<input type='hidden' name='idPresupuesto' value= '$id' >";
                   
                    
                    /////// validacion por usuario para botones de editar y eliminar
                        
                    
                    
                    /*
                    echo"<form action='presupuestoGestionar' method='POST'>";
                    echo"<input type='hidden' name='idPresupuesto' value= '$id' >";
                    echo"<input type='hidden' name='tipo' value= '$tipoResponsable' >";
                    echo"<input type='hidden' name='cedula' value= '$cedulaUsuario' >";
                    echo"<input type='hidden' name='cargo' value= '$carga' >";
                    echo" <td style='display:;'><button  type='submit'  class='btn btn-block btn-warning btn-sm'><i class='fas fa-clipboard'></i>Gestionar</button></td>";
                    echo"</form>";
                    
                     */
                    echo"</tr>";
                    
                        
                    } 
                    ?>
                    
                    
                  </tbody>

</table>