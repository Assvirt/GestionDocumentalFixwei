<?php
/* Exportacion Actas */
header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=actas.xls');

require '../conexion/bd.php';


$acentos = $mysqli->query("SET NAMES 'utf8'");
$cargoID = $_POST["cargo"];
$idUsuario = $_POST["idUsuario"];
$idGrupo = $_POST["idGrupo"];
$data = $mysqli->query("SELECT * FROM actas WHERE finalizada = 1 ORDER BY id ASC")or die(mysqli_error());
error_reporting(E_ERROR);

?>

<table border="1">
    <tr>
                      <th><?php echo utf8_decode('N° Acta');?></th>
                      <th>Fecha</th>
                      <th>Nombre Acta</th>
                      <th>Elaborador</th>
                      <th>Proceso</th>
                      <th>Estado</th>
                      
                    </tr>
    <?php
        
         while($row = $data->fetch_assoc()){
                         
                         $idActa = $row['id'];
                         $permisoListaActa = FALSE;
                         $permisoEditar = FALSE;
                         $permisoSeguimiento = FALSE;
                         //echo "Permisos vista actas".$row['id'];
                         
                        //Quien elabora
                        $quienElabora = $row['quienElabora'];
                        $quienElaboraID = json_decode($row['quienElaboraID']);
                        if($quienElabora == "cargo"){
                            if(in_array($cargoID,$quienElaboraID)){
                                $permisoListaActa = TRUE;
                                $permisoEditar = TRUE;
                                $permisoSeguimiento = TRUE;
                            }
                        }
                        
                        if($quienElabora == "usuario"){
                            if(in_array($idUsuario,$quienElaboraID)){
                                $permisoListaActa = TRUE;
                                $permisoEditar = TRUE;
                                $permisoSeguimiento = TRUE;
                            }
                        }
                        
                        
                        //Quien aprueba
                        $apruebaActa = $row['aprobarActa'];// si / no
                        $quieAbrueba= $row['quienAprueba'];// usuario / cargo
                        $quienApruebaID = json_decode($row['quienApruebaId']);
                        
                        if($apruebaActa == "si"){
                            if($quieAbrueba == "cargo"){
                                if(in_array($cargoID,$quienApruebaID)){
                                    $permisoListaActa = TRUE;
                                    $permisoEditar = TRUE;
                                    $permisoSeguimiento = TRUE;
                                }
                            }
                            
                            if($quieAbrueba == "usuario"){
                                if(in_array($idUsuario,$quienApruebaID)){
                                    $permisoListaActa = TRUE;
                                    $permisoEditar = TRUE;
                                    $permisoSeguimiento = TRUE;
                                }
                            }
                        }
                        

                        //Quienes tiene compromisos
                        
                        $queryCompromisos = $mysqli->query("SELECT responsableCompromiso, responsableID, entregarA, entregarAID FROM `compromisos` WHERE idActa = '$idActa' AND estado != 'Aprobado'");
                        
                        while($datoCompromiso = $queryCompromisos->fetch_assoc()){
                            $responsableCompromiso = $datoCompromiso['responsableCompromiso']; 
                            $responsableID = json_decode($datoCompromiso['responsableID']);
                            $entregarA = $datoCompromiso['entregarA'];
                            $entregarAID = json_decode($datoCompromiso['entregarAID']);
                            
                            if($responsableCompromiso == "cargo"){
                                if(in_array($cargoID,$responsableID)){
                                    $permisoSeguimiento = TRUE;
                                }
                            }
                            
                            if($responsableCompromiso == "usuario"){
                                if(in_array($idUsuario,$responsableID)){
                                    $permisoSeguimiento = TRUE;
                                }
                            }
                            
                            if($entregarA == "cargo"){
                                if(in_array($cargoID,$entregarAID)){
                                    $permisoSeguimiento = TRUE;
                                }
                            }
                            
                            if($entregarA == "usuario"){
                                if(in_array($idUsuario,$entregarAID)){
                                    $permisoSeguimiento = TRUE;
                                }
                            }
                            
                            if($permisoSeguimiento == TRUE){
                                break;
                            }
                            
                        }
                        
                        //$datoCompromiso = $queryCompromisos->fetch_array(MYSQLI_ASSOC);
                        
                        
                        
                        
                        
                        
                            
                        
                        
                        //Para quien es visible  //Si el acta es abierta a todo el publico debe dejar verla 
                        $permisoActa = $row['permisosActa'];  /// usuario, grupo o cargo
                        $publico = $row['publico'];  // si o no
                        $responsablesID = json_decode($row['responsablesActa']); 
                        
                        if($publico == "no" && $row['estado'] == 'Aprobado'){
                            if($permisoActa == "cargo"){
                                if(in_array($cargoID,$responsablesID)){
                                    $permisoListaActa = TRUE;
                                }
                            }
                            
                            if($permisoActa == "usuario"){
                                if(in_array($idUsuario,$responsablesID)){
                                    $permisoListaActa = TRUE;
                                }
                            }
                            
                            if($permisoActa == "grupo"){
                                //echo "GRUPO";
                                foreach($arrayGrupos as $idGrupo){
                                    if(in_array($idGrupo,$responsablesID)){
                                        $permisoListaActa = TRUE;
                                        if($permisoListaActa == TRUE){ break; }
                                    }
                                }
                                
                            }
                        }
                        
                        
                        if($permisoSeguimiento == TRUE){
                            if($row['estado'] == "Pendiente" || $row['estado'] == "Rechazado"){
                                $permisoSeguimiento = FALSE;
                            }
                            
                            if($row['estado'] == "Aprobado"){
                                $permisoSeguimiento = TRUE; 
                            }
                        }
                        
                        
                        
                        
                        
                        if($publico == "si"){
                            $permisoListaActa = TRUE;
                        }
                         
                         
                        if($permisoListaActa == FALSE){
                            continue;
                        }
                         
                        if($permisoEditar == FALSE){
                            $habilitaEditar = "disabled";
                        }else{
                            $habilitaEditar = "";     
                        }
                        
                        
                        if($permisoSeguimiento == FALSE){
                            $habilitarSeguimieto = "disabled";
                        }else{
                            $habilitarSeguimieto = "";
                        }
                         
                        $fechaOrginal = $row['fechaInicio'];
                        $fechaNueva = date('Y/m/d h:i A', strtotime($fechaOrginal));
                 
                    echo"<tr>";
                    
                     $id = $row['id'];
                    echo" <td>". $id ."</td>";
                    echo" <td>".substr($fechaNueva,0,-8)."</td>";
                    echo" <td>".utf8_decode($row['nombreActa'])."</td>";
                    $quienElabora = $row['quienElabora'];
                    $quienElaboraID =  json_decode($row['quienElaboraID']);
                        //var_dump($quienCitaID);
                    $longitud = count($quienElaboraID);
                    echo "<td>";
                    if($quienElabora == 'usuario'){
                                    
                                    for($i=0; $i<$longitud; $i++){
                                        
                                        $nombreuser = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$quienElaboraID[$i]'");
                                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                    
                                        echo utf8_decode($columna['nombres'])." ".utf8_decode($columna['apellidos']);echo"<br>";
                                     
                                    }
                                 
                                }else{
                                    
                                    for($i=0; $i<$longitud; $i++){
                                    $nombrecargo = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienElaboraID[$i]'");
                                    $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                    echo utf8_decode($columna['nombreCargos']);echo"<br>";
                                    }
                                }
                    echo "</td>";            
                    
                    $proceso = $row['proceso'];
                    $queryProceso=$mysqli->query("SELECT * FROM procesos WHERE id='$proceso' ");
	                $rowDatos=$queryProceso->fetch_array(MYSQLI_ASSOC);
	                $nombreProceso=$rowDatos['nombre'];
                    echo "<td>" . utf8_decode($nombreProceso) . "</td>";
                    echo" <td>".$row['estado']."</td>";
                    echo"</tr>";
                    
                    }
        ?>
    

</table>