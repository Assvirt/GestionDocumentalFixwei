<?php

$ruta = $_POST['ruta'];

header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=registros.xls');

require '../conexion/bd.php';

?>

<table class="table table-head-fixed text-center">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Nombre del regitro</th>
                      <th>Fecha de <?php echo utf8_decode("creación"); ?></th>
                      <th>Proceso</th>
                      <th>Tipo de documento</th>
                      <th>Aprobador</th>
                      <th>Estado</th>
                      <th>Fecha de <?php echo utf8_decode("aprobación"); ?></th>
                      <th>Decargar registro</th>
                      <th>Ver registro</th>
                    </tr>
                  </thead>
                  <tbody>
                     <?php
                     
                     //$acentos = $mysqli->query("SET NAMES 'utf8'");

                        
                        $data = $mysqli->query("SELECT * FROM registros WHERE carpeta = '$ruta' ORDER BY id DESC" )or die(mysqli_error());

                     $n = 1;
                     //echo $ruta;
                     while($row = $data->fetch_assoc()){
                         
                        $idRegistro= $row['id'];
                        $quienAprueba = $row['aprobador'];
                        $quienApruebaID = json_decode($row['aprobadorID']);
                        $longitud = count($quienApruebaID);
                        $idEdit = $row['id'];
                        $idProceso = $row['idProceso'];
                        $idTipoDocumento = $row['idTipoDocumento'];
                        
                        if($idProceso == NULL && $idTipoDocumento == NULL ){
                            
                            $proceso = "<b>No Aplica</b>";
                            $tipoDocumento = "<b>No Aplica</b>";
                        }else{
                            $queryConsultaProcesos=$mysqli->query("SELECT nombre FROM procesos WHERE id = $idProceso ");
    	                    $rowConsultaP=$queryConsultaProcesos->fetch_array(MYSQLI_ASSOC);
    	                    $proceso = $rowConsultaP['nombre'];
    	                    
    	                    
    	                    $queryTipoDoc=$mysqli->query("SELECT nombre FROM tipoDocumento WHERE id = $idTipoDocumento ");
    	                    $rowConsultaTD=$queryTipoDoc->fetch_array(MYSQLI_ASSOC);
    	                    $tipoDocumento = $rowConsultaTD['nombre'];
    	                    
                        }
                        
                        
                        
                    echo"<tr>";
                    echo "<td>".$n."</td>";
                    echo "<td>".utf8_decode($row['nombre'])."</td>";
                    echo "<td>".$row['fechaCreacion']."</td>";
                    echo "<td><center>".$proceso."</center></td>";
                    echo "<td><center>".$tipoDocumento."</center></td>";
                    ?>
                    <td>
                    <?php
                    
                        if($quienAprueba == 'usuarios'){
                                    
                            for($i=0; $i<$longitud; $i++){
                            
                                $nombreuser = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$quienApruebaID[$i]'");
                                $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                            
                                echo "- ".$aprobador = $columna['nombres']." ".$columna['apellidos']; echo "<br>";
                                     
                            }
                        }
                        if($quienAprueba == 'cargos'){
                                    
                            for($i=0; $i<$longitud; $i++){
                                $nombrecargo = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienApruebaID[$i]'");
                                $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                echo "- ".$aprobador = $columna['nombreCargos'];echo "<br>";
                            }
                        }
                        if($quienAprueba == NULL){
                            echo "<strong>No Aplica</strong>";
                        }
                        
                    ?>
                    </td>
                    <?php
                    
                    echo "<td>".$row['estado']."</td>";
                    
                    
                    if($row['fechaAprobacion'] == NULL){
                        echo "<td><center><strong> No aplica</strong></center></td>";
                    }else{
                        echo "<td><center>".$row['fechaAprobacion']."</center></td>";
                    }
                    
                    if($row['nombreDocumento'] != NULL){
                    ?>
                        <td><a href="<?php echo utf8_decode("https://fixwei.com/plataforma/pages/repositorio/".$row['nombreDocumento']); ?>">Descargar - <?php echo utf8_decode($row['nombreDocumento']); ?></a></td>
                    
                    <?php
                        
                    }else{
                    ?>
                        <td>Creado por HTML</td>
                    <?php
                    }
                    
                    if($row['id'] != NULL){
                        ?>
                            <td><a href="<?php echo "http://fixwei.com/plataforma/pages/verRegistro?idRegistro=".$row['id'].""; ?>">Ver Registro</a></td>
                        
                        <?php
                    }
                    
                    
                    echo"</tr>";
                    $n++;    
                    } 
                    ?>
                  </tbody>
                </table>