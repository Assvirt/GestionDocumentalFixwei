<?php

    date_default_timezone_set("America/Bogota");
    require_once 'conexion/bd.php';
    session_start();
    $cargoID = $_SESSION['session_cargo'];
    
    // Obteniendo la fecha actual del sistema con PHP
    
  
                    $dataRevision = $mysqli->query("SELECT * FROM documento WHERE vigente = 1 AND revisado = 0 ORDER BY codificacion ASC")or die(mysqli_error());
                     
                    while($row = $dataRevision->fetch_assoc()){
                        
                        $nombreDocumento = $row['nombres'];
                        
                        $idProceso2 = $row['proceso'];
                        
                        
                        $dataSol = $mysqli->query("SELECT duenoProceso FROM procesos WHERE id = $idProceso2")or die(mysqli_error());
                        $datosSol = $dataSol->fetch_assoc();
                        $encargadoSolicitud = json_decode($datosSol['duenoProceso']);
                        
                        
                        /*Validacioon para saber si el cargo es lider del proceso al que se ato el documento*/
                        if(in_array($cargoID,$encargadoSolicitud)){
                            
                        }else{
                            continue;
                        }
                        
                        
                        
                        $fechaActual2 = date('d-m-Y');
                        //echo "FECHA ACTUAL UNO: ".$fechaActual2; echo "<br>";
                        
                        $mesesRevision = $row['mesesRevision'];
                        
                        if($row['ultimaFechaRevision'] == NULL){
                            
                            $fechaAprobado = date("d-m-Y", strtotime($row['fechaAprobado']));
                            /*Calculo fecha de revision*/
                            $fechaRevisar = date("d-m-Y",strtotime($fechaAprobado."+ $mesesRevision month"));
                            
                        }else{
                            $fechaUltimaRevision = $row['ultimaFechaRevision'];
                            
                            $fechaRevisar = date("d-m-Y",strtotime($fechaUltimaRevision."+ $mesesRevision month"));
                            $fechaAprobado = date("d-m-Y", strtotime($row['fechaAprobado']));
                        }
                        
                        
                        //$fechaActual2 = "15-12-2020";

                        /*Pasos las fechas a un objeto tiempo*/
                        $datetime11 = new DateTime($fechaActual2);
                        $datetime22 = new DateTime($fechaRevisar);
                        
                        /*Diferendia entre las fechas*/
                        $interval2 = $datetime11->diff($datetime22);
                        
                        
                        
                           // Formato para sacar los dias entre las dos fechas
                            
                                 $interval2->format('%R%a dias'); //con %R saco si es negativo o positivo
                                 $validandoDias=$interval2->format('%R');
                        
                        $diasFaltantes = $interval2->format('%a');
                        
                        
                        
                        //$diasFaltantes = 5;

                            
                        if($diasFaltantes <= "30"){
                        
                        $conteoTotal = 1;

?>


            <div class="timeline timeline-inverse">
                        
                                    <div class="row">
                                                  <div class="col-md-12">
                                                    <!-- The time line -->
                                                    <div class="timeline">
                                                      <!-- timeline time label -->
                                                      <div class="time-label">
                                                        <span class="bg-red">Revisión de un documento: </span>
                                                      </div>
                                                      <!-- /.timeline-label -->
                                                      <!-- timeline item -->
                                                      <div>
                                                        <i class="fas fa-envelope bg-blue"></i>
                                                        <div class="timeline-item">
                                                          
                                                          <h3 class="timeline-header"> </h3>
                                        
                                                          <div class="timeline-body">
                                                              <b>Nombre del Documento: </b><?php echo $nombreDocumento;?><br>
                                                              <b>Fecha Aprobado: </b><?php echo $fechaAprobado;?></br>
                                                              <b>Fecha Revisión: </b><?php echo $fechaRevisar;?><br>
                                                              <?php if($validandoDias == '-'){ ?> <b>Días vencidos: </b> <font color="red"><?php echo $diasFaltantes; ?></font><?php }else{ ?><b>Días para revisión: </b> <font color="black"><?php echo $diasFaltantes+1; ?></font><?php } ?></br>
                                                              <?php 
                                                              
                                                              //echo $fechaActual;
                                                              
                                                              ?>
                                                          </div>
                                                          <div class="timeline-footer">
                                                                <form action="revisarDocumento" method="POST">
                                                                    <input type="hidden" readonly name="idDocumento" value="<?php echo $row['id']; ?>">
                                                                    <input type="hidden" readonly name="idSolicitud" value="<?php echo $row['id_solicitud']; ?>">
                                                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> Revisar documento</button>
                                                                </form>
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <!-- END timeline item -->
                                                     
                                                      <div>
                                                        <i class="fas fa-clock bg-gray"></i>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <!-- /.col -->
                                                </div>
                      
                        
                    </div>
<?php } } ?>                    