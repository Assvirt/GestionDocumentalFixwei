<?php
error_reporting(E_ERROR);
header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=ListaRevisiónDocumental.xls');

require '../conexion/bd.php';



?>

<table border="1">
    <tr>
        <th class="text-center"><?php echo utf8_decode('Versión');?></th>
        <th class="text-center"><?php echo utf8_decode('Código');?></th>
        <th class="text-center">Nombre</th>
        <th class="text-center">Tipo de documento</th>
        <th class="text-center">Proceso</th>
        <th class="text-center"><?php echo utf8_decode('Implementación');?></th>
        <th class="text-center"><?php echo utf8_decode('Próxima fecha revisión');?></th>
        <th class="text-center"><?php echo utf8_decode('Meses para la próxima revisión');?></th>
        <!--<th class="text-center"><?php //echo utf8_decode('Control de cambios');?></th>-->
      
        <th class="text-center"><?php echo utf8_decode('Elaborador(a)');?></th>
        <th class="text-center"><?php echo utf8_decode('Revisor(a)');?></th>
        <th class="text-center"><?php echo utf8_decode('Aprobador(a)');?></th>
        <!--<th class="text-center"><?php //echo utf8_decode('Fecha de revisión');?></th>
        <th class="text-center"><?php //echo utf8_decode('Encargado(a)');?></th>
        <th class="text-center"><?php //echo utf8_decode('Comentarios');?></th>-->
       
    </tr>
    <?php
 'recibe id: '.$cargo=$_POST['idCargo'];
$acentos = $mysqli->query("SET NAMES 'utf8'");
$result = $mysqli->query("SELECT * FROM documento WHERE vigente = 1 AND pre IS NULL ORDER BY codificacion ASC")or die("<marquee><font color='red'>SELECCIONE DEFINICIÓN</marquee></font>");
//SELECT * FROM documento WHERE vigente = 1 AND revisado = 0 AND pre IS NULL ORDER BY codificacion ASC
        while ($row=$result->fetch_array()){
                        
                        
                        $idProceso2 = $row['proceso'];
                        
                        
                        $dataSol = $mysqli->query("SELECT * FROM procesos WHERE id = '$idProceso2'")or die(mysqli_error());
                        $datosSol = $dataSol->fetch_assoc();
                        $encargadoSolicitud = json_decode($datosSol['duenoProceso']);
                        $longitud = count($encargadoSolicitud);
                        
                         if($datosSol['importacion'] == 1){
                            for($i=0; $i<$longitud; $i++){ 
                                //saco el valor de cada elemento
                                $queryNombres = $mysqli->query("SELECT * FROM cargos WHERE nombreCargos LIKE '%$encargadoSolicitud[$i]%' ");
                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                
                                $encargadoSolicitud=$nombres['id_cargos'];
                                // echo '<td>S'.$encargadoSolicitud.'</td>';
                            
                            }
                         }else{
                            for($i=0; $i<$longitud; $i++){ 
                                //saco el valor de cada elemento
                                $queryNombres = $mysqli->query("SELECT * FROM cargos WHERE id_cargos LIKE '%$encargadoSolicitud[$i]%' ");
                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                
                                $encargadoSolicitud=$nombres['id_cargos'];
                                // echo '<td>N'.$encargadoSolicitud.'</td>';
                            
                            } 
                         }
                        //print_r($encargadoSolicitud);
                        
                        
                        
                        if($cargo == $encargadoSolicitud){ 
                           
                        }else{
                            //continue;
                        }
                       
                       
                       $enviarIddocumento=$row['id'];
                        
                       
                        
                        $mesesRevision = $row['mesesRevision'];
                        
                        if($row['ultimaFechaRevision'] == NULL){
                            
                            $fechaAprobado = date("d-m-Y", strtotime($row['fechaAprobado']));
                            /*Calculo fecha de revision*/
                            $fechaRevisar = date("d-m-Y",strtotime($fechaAprobado."+ $mesesRevision month"));
                            
                        }else{
                            $fechaUltimaRevision = $row['ultimaFechaRevision'];
                            
                            $fechaRevisar = date("d-m-Y",strtotime($fechaUltimaRevision."+ $mesesRevision month"));
                        }
                        
                        echo"<tr>";
                         echo" <td>".$row['version']."</td>";
                         echo" <td>".utf8_decode($row['codificacion'])."</td>";
                         echo" <td>".utf8_decode($row['nombres'])."</td>";
                         $tipo = $row['tipo_documento'];
                         $acentos = $mysqli->query("SET NAMES 'utf8'");
                         $nombreTipoDocumento = $mysqli->query("SELECT * FROM tipoDocumento WHERE id ='$tipo'")or die(mysqli_error());
                         $colu = $nombreTipoDocumento->fetch_array(MYSQLI_ASSOC);
                         $nombreT = $colu['nombre'];
                         echo" <td>".utf8_decode($nombreT)."</td>";
                         $proceso =  $row['proceso'];
                         $acentos = $mysqli->query("SET NAMES 'utf8'");
                         $nombreProceso = $mysqli->query("SELECT * FROM procesos WHERE id ='$proceso'")or die(mysqli_error());
                         $col3 = $nombreProceso->fetch_array(MYSQLI_ASSOC);
                         $nombreP = $col3['nombre'];
                         echo" <td>".utf8_decode($nombreP)."</td>";
                         
                         echo" <td>".substr($row['fechaAprobado'],0,-8)."</td>";
                         $revision=utf8_decode('revisión');
                         
                         
                         
                         
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
                         
                        
                        $idSolicitudEnviar=$row['id_solicitud']; 
                         
                        
                        
                        
                        echo '<td>'; 
                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                        $queryControl = $mysqli->query("SELECT * FROM controlCambios WHERE idDocumento =  '$idSolicitudEnviar' ")or die(mysqli_error($mysqli));
                        while($row = $queryControl->fetch_assoc()){
                        $idUser = $row['idUsuario'];
                        $rol = $row['rol'];
                        if($rol == 'Elaborador(a)'){
                            
                        }else{
                            continue;
                        }                           
                                                        
                                                    if($idUser == null){
                                                    $nombreUsuario = $row['idUsuarioB'];
                                                    $rol = $row['rol'];
                                                    
                                                    
                                                    ////// si el id del usuario viene en número me debe consultar el usuario
                                                        $nombreUsuario;
                                                        
                                                        if(is_numeric($nombreUsuario)){
                                                            
                                                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                            $queryUser = $mysqli->query("SELECT * FROM usuario WHERE cedula = $nombreUsuario ")or die(mysqli_error($mysqli));
                                                            $datosUser = $queryUser->fetch_assoc();
                                                            $nombreUsuarioSale = $datosUser['nombres']." ".$datosUser['apellidos'];
                                                            
                                                        }else{
                                                            $nombreUsuarioSale=$nombreUsuario;
                                                        }
                                                        
                                                    ///// end
                                                    
                                                    
                                                    
                                                    
                                                    }else{
                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                        $queryUser = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$idUser' ")or die(mysqli_error($mysqli));
                                                        $datosUser = $queryUser->fetch_assoc();
                                                        $nombreUsuarioSale = $datosUser['nombres']." ".$datosUser['apellidos'];
                                                    }
                                                      
                                                  ?>
                                                  
                                                 
                                                      
                                               <?php //echo $rol;?> - <?php echo utf8_decode($nombreUsuarioSale);?><br> <?php //echo utf8_decode($row['comentario']);?>
                                                     
                                <?php } 
                        
                        echo '</td>';
                        
                        
                        echo '<td>'; 
                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                        $queryControl = $mysqli->query("SELECT * FROM controlCambios WHERE idDocumento =  '$idSolicitudEnviar' ")or die(mysqli_error($mysqli));
                        while($row = $queryControl->fetch_assoc()){
                        $idUser = $row['idUsuario'];
                        $rol = $row['rol'];
                        if($rol == 'Revisor(a)'){
                            
                        }else{
                            continue;
                        }                           
                                                        
                                                    if($idUser == null){
                                                    $nombreUsuario = $row['idUsuarioB'];
                                                    $rol = $row['rol'];
                                                    
                                                    
                                                    ////// si el id del usuario viene en número me debe consultar el usuario
                                                        $nombreUsuario;
                                                        
                                                        if(is_numeric($nombreUsuario)){
                                                            
                                                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                            $queryUser = $mysqli->query("SELECT * FROM usuario WHERE cedula = $nombreUsuario ")or die(mysqli_error($mysqli));
                                                            $datosUser = $queryUser->fetch_assoc();
                                                            $nombreUsuarioSale = $datosUser['nombres']." ".$datosUser['apellidos'];
                                                            
                                                        }else{
                                                            $nombreUsuarioSale=$nombreUsuario;
                                                        }
                                                        
                                                    ///// end
                                                    
                                                    
                                                    
                                                    
                                                    }else{
                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                        $queryUser = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$idUser' ")or die(mysqli_error($mysqli));
                                                        $datosUser = $queryUser->fetch_assoc();
                                                        $nombreUsuarioSale = $datosUser['nombres']." ".$datosUser['apellidos'];
                                                    }
                                                      
                                                  ?>
                                                  
                                                 
                                                      
                                                <?php //echo $rol;?> - <?php echo utf8_decode($nombreUsuarioSale);?><br> <?php //echo utf8_decode($row['comentario']);?>
                                                     
                                <?php } 
                        
                        echo '</td>';
                        
                        
                        echo '<td>'; 
                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                        $queryControl = $mysqli->query("SELECT * FROM controlCambios WHERE idDocumento =  '$idSolicitudEnviar' ")or die(mysqli_error($mysqli));
                        while($row = $queryControl->fetch_assoc()){
                        $idUser = $row['idUsuario'];
                        $rol = $row['rol'];
                        if($rol == 'Aprobador(a)'){
                            
                        }else{
                            continue;
                        }                           
                                                        
                                                    if($idUser == null){
                                                    $nombreUsuario = $row['idUsuarioB'];
                                                    $rol = $row['rol'];
                                                    
                                                    
                                                    ////// si el id del usuario viene en número me debe consultar el usuario
                                                        $nombreUsuario;
                                                        
                                                        if(is_numeric($nombreUsuario)){
                                                            
                                                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                            $queryUser = $mysqli->query("SELECT * FROM usuario WHERE cedula = $nombreUsuario ")or die(mysqli_error($mysqli));
                                                            $datosUser = $queryUser->fetch_assoc();
                                                            $nombreUsuarioSale = $datosUser['nombres']." ".$datosUser['apellidos'];
                                                            
                                                        }else{
                                                            $nombreUsuarioSale=$nombreUsuario;
                                                        }
                                                        
                                                    ///// end
                                                    
                                                    
                                                    
                                                    
                                                    }else{
                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                        $queryUser = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$idUser' ")or die(mysqli_error($mysqli));
                                                        $datosUser = $queryUser->fetch_assoc();
                                                        $nombreUsuarioSale = $datosUser['nombres']." ".$datosUser['apellidos'];
                                                    }
                                                      
                                                  ?>
                                                  
                                                 
                                                      
                                                <?php //echo $rol;?> - <?php echo utf8_decode($nombreUsuarioSale);?><br> <?php //echo utf8_decode($row['comentario']);?>
                                                     
                                <?php } 
                        
                        echo '</td>';
                        
                       
                        
                         
                                    $queryControl = $mysqli->query("SELECT * FROM comnetariosRevision WHERE idDocumento = '$enviarIddocumento' ")or die(mysqli_error($mysqli));
                                                    
                                                if(mysqli_num_rows($queryControl) == 0){
                                                    echo "<td><center></center>"; //".utf8_decode("Sin revisión")."
                                                    echo '</td>';
                                                    echo "<td></td>";
                                                    echo '<td>';   
                                                }
                                                    
                                                while($row = $queryControl->fetch_assoc()){
                                                        $idUser = $row['idUsuario'];
                                                        $queryUser = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$idUser' ")or die(mysqli_error($mysqli));
                                                        $datosUser = $queryUser->fetch_assoc();
       
                                                        $nombreUsuario = $datosUser['nombres']." ".$datosUser['apellidos'];
                                                       echo '<td><b>'.utf8_decode('Revisión documental').'</b><br>'.utf8_decode($row['comentario']);
                                                       echo '</td>';
                                                       
                                                       echo "<td><b>".utf8_decode('Responsable de la revisión documental')."</b><br>";
                                                       
                                                       echo utf8_decode($nombreUsuario).'</td>';
                                                       
                                                       echo '<td>';
                                                       echo utf8_decode('<b>Fecha de revisión documental</b><br>').$row['fecha'].'</td>';
                                                       
                                                       
                                                       
                                                       
                                                }
                        
                        
                        
                        
                        echo"</tr>";
                    }
        ?>
    

</table>