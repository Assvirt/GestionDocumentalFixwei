<?php
error_reporting(E_ERROR);
header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=ListadoMaestro.xls');

require '../conexion/bd.php';

$idProcesoUsuario=$_POST['idProceso'];
$visibleE=$_POST['visibleE'];
$acentos = $mysqli->query("SET NAMES 'utf8'");
$result = $mysqli->query("SELECT * FROM documento WHERE vigente = 1 AND pre IS NULL ORDER BY codificacion ASC")or die("ERROR, comuniquese con el administrador del sistema.");

?>

<table border="1">
    <tr>
        <th class="text-center" ><?php echo utf8_decode('Versión');?></th>
        <th class="text-center" ><?php echo utf8_decode('Código');?></th>
        <th class="text-center" >Nombre</th>
        <th class="text-center" >Tipo de documento</th>
        <th class="text-center" >Proceso</th>
        <th class="text-center" ><?php echo utf8_decode('Ubicación');?></th>
        <th class="text-center" ><?php echo utf8_decode('Implementación');?></th>
        <th class="text-center"><?php echo utf8_decode('Próxima fecha revisión');?></th>
        <th class="text-center"><?php echo utf8_decode('Meses para la próxima revisión');?></th>
        <th class="text-center" ><?php echo utf8_decode('Archivo en gestión');?></th>
        <th class="text-center" ><?php echo utf8_decode('Archivo central');?></th>
        <th class="text-center" ><?php echo utf8_decode('Archivo histórico');?></th>
        <th class="text-center" ><?php echo utf8_decode('Disposición documental');?></th>
        <th class="text-center" ><?php echo utf8_decode('Responsable de disposición');?></th>
        <th class="text-center" ><?php echo utf8_decode('Elabora creación');?></th>
        <th class="text-center" ><?php echo utf8_decode('Revisa creación');?></th>
        <th class="text-center" ><?php echo utf8_decode('Aprueba creación');?></th>
        <th class="text-center" ><?php echo utf8_decode('Elabora actualización');?></th>
        <th class="text-center" ><?php echo utf8_decode('Revisa actualización');?></th>
        <th class="text-center" ><?php echo utf8_decode('Aprueba actualización');?></th>
        <th class="text-center" ><?php echo utf8_decode('Elabora eliminación');?></th>
        <th class="text-center" ><?php echo utf8_decode('Revisa eliminación');?></th>
        <th class="text-center" ><?php echo utf8_decode('Aprueba eliminación');?></th>
    </tr>
    <?php
        
        while ($row = $result->fetch_assoc()){
                    
                        /*if($row['obsoleto'] == 1){
                            continue;
                        }*/
                        
                 
                    echo"<tr>";
                     
                     echo" <td>".$row['version']."</td>";
                     echo" <td>".$row['codificacion']."</td>";
                     echo" <td>".utf8_decode($row['nombres'])."</td>";
                     $tipo = $row['tipo_documento'];
                     $acentos = $mysqli->query("SET NAMES 'utf8'");
                     $nombreTipoDocumento = $mysqli->query("SELECT * FROM tipoDocumento WHERE id ='$tipo'")or die(mysqli_error());
                     $colu = $nombreTipoDocumento->fetch_array(MYSQLI_ASSOC);
                     $nombreT = utf8_decode($colu['nombre']);
                     ////$ruta = $colu['ruta'];
                     $ruta=$row['nombreOtro'];
                     echo" <td>".$nombreT."</td>";
                     $proceso =  $row['proceso'];
                     $nombreProceso = $mysqli->query("SELECT * FROM procesos WHERE id ='$proceso'")or die(mysqli_error());
                     $col3 = $nombreProceso->fetch_array(MYSQLI_ASSOC);
                     $nombreP = utf8_decode($col3['nombre']);
                     echo" <td>".$nombreP."</td>";
                     
                     if($row['ubicacion'] != NULL){
                        echo" <td>".utf8_decode($row['ubicacion'])."</td>";
                     }else{
                         echo "<td>" . '<strong>No aplica</strong>'."</td>";
                     }
                     
                    echo" <td>".substr($row['fechaAprobado'],0,-8)."</td>"; 
                    
                       $mesesRevision = $row['mesesRevision'];
                        
                        if($row['ultimaFechaRevision'] == NULL){
                            
                            $fechaAprobado = date("d-m-Y", strtotime($row['fechaAprobado']));
                            /*Calculo fecha de revision*/
                            $fechaRevisar = date("d-m-Y",strtotime($fechaAprobado."+ $mesesRevision month"));
                            
                        }else{
                            $fechaUltimaRevision = $row['ultimaFechaRevision'];
                            
                            $fechaRevisar = date("d-m-Y",strtotime($fechaUltimaRevision."+ $mesesRevision month"));
                        }
                    
                    
                    
                    date_default_timezone_set("America/Bogota");
                             'Fecha inicial: '.$fechainicial = substr($row['fechaAprobado'],0,-8);
                             '<br>Fecha actual: '.$fechaactual = date("Y-m-d");
                            
                                           
                                          
                             '<br>Meses: '.$preguntandoMeses=$row['mesesRevision'];
                            if($preguntandoMeses == 1){
                                 $tiempoRespuesta ='30';//$row['tiempoRespuesta'];
                            }else{
                                 $tiempoRespuesta =30*$row['mesesRevision'];//$row['tiempoRespuesta'];
                            }
                           
                            '<br>Cantidad días: '.$tiempoRespuesta;
                            
                             '<br>Fecha validar: '.$fechaRestar = date("Y-m-d",strtotime($fechainicial."+ ".$tiempoRespuesta." days")); 
                            
                         echo"<td style='text-align: justify;' >".$fechaRestar."</td>"; // $fechaRevisar --$mesesRevision   
                    
                    
                    echo"<td style='text-align:center;'>".$mesesRevision."</td>"; 
                    echo" <td>".utf8_decode($row['archivo_gestion'])."</td>";
                    echo" <td>".utf8_decode($row['archivo_central'])."</td>";
                    echo" <td>".utf8_decode($row['archivo_historico'])."</td>";
                    echo" <td>".utf8_decode($row['disposicion_documental'])."</td>";
                    
                    echo" <td>";
                    
                    $responsableDisposicion = json_decode($row['responsable_disposicion']);
                                                
                                                if($responsableDisposicion[0] == 'cargos'){
                                                    $longitudDisposicion = count($responsableDisposicion);
                                                    
                                                    for($i=1; $i<$longitudDisposicion; $i++){
                                                        //saco el valor de cada elemento
                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                        $queryNombresDisposicion = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$responsableDisposicion[$i]'");
                                                        $nombresDisposicion = $queryNombresDisposicion->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".utf8_decode($nombresDisposicion['nombreCargos'])."<br>";
                                                    }            
                                                }
                                                elseif($responsableDisposicion[0] == 'usuarios'){
                                                    $longitudDisposicion = count($responsableDisposicion);
                                                    
                                                    for($i=1; $i<$longitudDisposicion; $i++){
                                                        //saco el valor de cada elemento
                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                        $queryNombresDisposicion = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$responsableDisposicion[$i]'");
                                                        $nombresDisposicion = $queryNombresDisposicion->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".utf8_decode($nombresDisposicion['nombres'])." ".utf8_decode($nombresDisposicion['apellidos'])."<br>";
                                                    } 
                                                }else{
                                                    echo utf8_decode($row['responsable_disposicion']);
                                                }
                    echo "</td>";
                    ////////////////// usuarios o cargos para la creación
                    echo "<td>";  //// listado en la creación
                        $elabora = json_decode($row['elabora']);
                                                
                                                if($elabora[0] == 'cargos'){
                                                    $longitud = count($elabora);
                                                    
                                                    for($i=1; $i<$longitud; $i++){
                                                        //saco el valor de cada elemento
                                                        $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$elabora[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".utf8_decode($nombres['nombreCargos'])."<br>";
                                                    }            
                                                }
                                                elseif($elabora[0] == 'usuarios'){
                                                    $longitud = count($elabora);
                                                    
                                                    for($i=1; $i<$longitud; $i++){
                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                        //saco el valor de cada elemento
                                                        $queryNombres = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$elabora[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".utf8_decode($nombres['nombres'])." ".utf8_decode($nombres['apellidos'])."<br>";
                                                    } 
                                                }else{
                                                    echo utf8_decode($row['elabora']);
                                                }
                    echo "</td>";
                    echo "<td>";  //// listado en la creación
                        $revisa = json_decode($row['revisa']);
                                                
                                                if($revisa[0] == 'cargos'){
                                                    $longitudRevisa = count($revisa);
                                                    
                                                    for($i=1; $i<$longitudRevisa; $i++){
                                                        //saco el valor de cada elemento
                                                        $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$revisa[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".utf8_decode($nombres['nombreCargos'])."<br>";
                                                    }            
                                                }
                                                elseif($revisa[0] == 'usuarios'){
                                                    $longitudRevisa = count($revisa);
                                                    
                                                    for($i=1; $i<$longitudRevisa; $i++){
                                                        //saco el valor de cada elemento
                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                        $queryNombres = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$revisa[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".utf8_decode($nombres['nombres'])." ".utf8_decode($nombres['apellidos'])."<br>";
                                                    }
                                                }else{
                                                    echo utf8_decode($row['revisa']);
                                                }
                    echo "</td>";
                    echo "<td>";  //// listado en la creación
                        $aprueba = json_decode($row['aprueba']);
                                                
                                                if($aprueba[0] == 'cargos'){
                                                    $longitudAprueba = count($aprueba);
                                                    
                                                    for($i=1; $i<$longitudAprueba; $i++){
                                                        //saco el valor de cada elemento
                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                        $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$aprueba[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".utf8_decode($nombres['nombreCargos'])."<br>";
                                                    }            
                                                }
                                                elseif($aprueba[0] == 'usuarios'){
                                                    $longitudAprueba = count($aprueba);
                                                    
                                                    for($i=1; $i<$longitudAprueba; $i++){
                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                        //saco el valor de cada elemento
                                                        $queryNombres = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$aprueba[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".utf8_decode($nombres['nombres'])." ".utf8_decode($nombres['apellidos'])."<br>";
                                                    } 
                                                }else{
                                                    echo utf8_decode($row['aprueba']);
                                                }
                    echo "</td>";
                    
                    //////////// usuarios o cargos para la actualización   
                      echo "<td>";  //// listado en la actualizacion
                        $elaboraActualizacion = json_decode($row['elaboraActualizar']);
                                                
                                                if($elaboraActualizacion[0] == 'cargos'){
                                                    $longitud = count($elaboraActualizacion);
                                                    
                                                    for($i=1; $i<$longitud; $i++){
                                                        //saco el valor de cada elemento
                                                        $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$elaboraActualizacion[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".utf8_encode($nombres['nombreCargos'])."<br>";
                                                    }            
                                                }
                                                if($elaboraActualizacion[0] == 'usuarios'){
                                                    $longitud = count($elaboraActualizacion);
                                                    
                                                    for($i=1; $i<$longitud; $i++){
                                                        //saco el valor de cada elemento
                                                        //$acentos = $mysqli->query("SET NAMES 'utf8'");
                                                        $queryNombres = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$elaboraActualizacion[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".utf8_decode(($nombres['nombres'])." ".($nombres['apellidos']))."<br>";
                                                    } 
                                                }
                    echo "</td>";
                    echo "<td>";  //// listado en la actualizacion
                        $revisaActualizacion = json_decode($row['revisaActualizar']);
                                                
                                                if($revisaActualizacion[0] == 'cargos'){
                                                    $longitudRevisa = count($revisaActualizacion);
                                                    
                                                    for($i=1; $i<$longitudRevisa; $i++){
                                                        //saco el valor de cada elemento
                                                        $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$revisaActualizacion[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".utf8_decode($nombres['nombreCargos'])."<br>";
                                                    }            
                                                }
                                                if($revisaActualizacion[0] == 'usuarios'){
                                                    $longitudRevisa = count($revisaActualizacion);
                                                    
                                                    for($i=1; $i<$longitudRevisa; $i++){
                                                        //saco el valor de cada elemento
                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                        $queryNombres = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$revisaActualizacion[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".utf8_decode(($nombres['nombres'])." ".($nombres['apellidos']))."<br>";
                                                    } 
                                                }
                    echo "</td>";
                    echo "<td>";  //// listado en la actualizacion
                        $apruebaActualizacion = json_decode($row['apruebaActualizar']);
                                                
                                                if($apruebaActualizacion[0] == 'cargos'){
                                                    $longitudAprueba = count($apruebaActualizacion);
                                                    
                                                    for($i=1; $i<$longitudAprueba; $i++){
                                                        //saco el valor de cada elemento
                                                        $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$apruebaActualizacion[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".utf8_decode($nombres['nombreCargos'])."<br>";
                                                    }            
                                                }
                                                if($apruebaActualizacion[0] == 'usuarios'){
                                                    $longitudAprueba = count($apruebaActualizacion);
                                                    
                                                    for($i=1; $i<$longitudAprueba; $i++){
                                                        //saco el valor de cada elemento
                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                        $queryNombres = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$apruebaActualizacion[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".utf8_decode(($nombres['nombres'])." ".($nombres['apellidos']))."<br>";
                                                    } 
                                                }
                    echo "</td>";
                    
                    /////////// usuarios o cargos para la eliminación
                    //////////// usuarios o cargos para la eliminacion   
                      echo "<td>";  //// listado en la actualizacion
                        $elaboraEliminacion = json_decode($row['elaboraElimanar']);
                                                
                                                if($elaboraEliminacion[0] == 'cargos'){
                                                    $longitud = count($elaboraEliminacion);
                                                    
                                                    for($i=1; $i<$longitud; $i++){
                                                        //saco el valor de cada elemento
                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                        $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$elaboraEliminacion[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".utf8_decode($nombres['nombreCargos'])."<br>";
                                                    }            
                                                }
                                                if($elaboraEliminacion[0] == 'usuarios'){
                                                    $longitud = count($elaboraEliminacion);
                                                    
                                                    for($i=1; $i<$longitud; $i++){
                                                        //saco el valor de cada elemento
                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                        $queryNombres = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$elaboraEliminacion[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".utf8_decode($nombres['nombres']." ".$nombres['apellidos'])."<br>";
                                                    } 
                                                }
                    echo "</td>";
                    echo "<td>";  //// listado en la elminacion
                        $revisaEliminacion = json_decode($row['revisaElimanar']);
                                                
                                                if($revisaEliminacion[0] == 'cargos'){
                                                    $longitudRevisa = count($revisaEliminacion);
                                                    
                                                    for($i=1; $i<$longitudRevisa; $i++){
                                                        //saco el valor de cada elemento
                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                        $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$revisaEliminacion[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".utf8_decode($nombres['nombreCargos'])."<br>";
                                                    }            
                                                }
                                                if($revisaEliminacion[0] == 'usuarios'){
                                                    $longitudRevisa = count($revisaEliminacion);
                                                    
                                                    for($i=1; $i<$longitudRevisa; $i++){
                                                        //saco el valor de cada elemento
                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                        $queryNombres = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$revisaEliminacion[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".utf8_decode($nombres['nombres'])." ".utf8_decode($nombres['apellidos'])."<br>";
                                                    } 
                                                }
                    echo "</td>";
                    echo "<td>";  //// listado en la eliminacion
                        $apruebaEliminacion = json_decode($row['apruebaElimanar']);
                                                
                                                if($apruebaEliminacion[0] == 'cargos'){
                                                    $longitudAprueba = count($apruebaEliminacion);
                                                    
                                                    for($i=1; $i<$longitudAprueba; $i++){
                                                        //saco el valor de cada elemento
                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                        $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$apruebaEliminacion[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".utf8_encode($nombres['nombreCargos'])."<br>";
                                                    }            
                                                }
                                                if($apruebaEliminacion[0] == 'usuarios'){
                                                    $longitudAprueba = count($apruebaEliminacion);
                                                    
                                                    for($i=1; $i<$longitudAprueba; $i++){
                                                        //saco el valor de cada elemento
                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                        $queryNombres = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$apruebaEliminacion[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".utf8_encode($nombres['nombres'])." ".utf8_decode($nombres['apellidos'])."<br>";
                                                    } 
                                                }
                    echo "</td>";
                    echo"</tr>";
                    }
        ?>
    

</table>