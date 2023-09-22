<?php

require_once 'conexion/bd.php';

'ID: '.$idEvaluacion = $_POST['idEvaluacion'];

?>
                                <table class="table table-head-fixed text-center"> 
                                <thead>
                                    <th>Nombre</th>
                                    <th>Extensión</th>
                                    <th>Descargar/visualizar</th>
                                </thead>
                                <tbody>
                                    <?php
                                    $recorridoDocumentos=$mysqli->query("SELECT * FROM evaluacionMaterial WHERE idEvaluacion='$idEvaluacion' ");
                                    $recorridoDocumentosConteoA=1;
                                    $recorridoDocumentosConteoB=1;
                                    while($ExtraerRecorridoDocumentos=$recorridoDocumentos->fetch_array()){
                                    ?>
                                    <tr>
                                        <td style="text-align: left;"><?php echo utf8_encode($ExtraerRecorridoDocumentos['nombre']);?></td>
                                        <td>
                                            <?php
                                            $varArchivo =$ExtraerRecorridoDocumentos['material'];
                                            $explorando=explode(".",$varArchivo);
                                            $enviarSinExtension= $explorando[0];
                                            echo $enviarConExtension= $explorando[1];
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if($enviarConExtension == 'mp4' || $enviarConExtension == 'avi'){
                                            ?>
                                            <button type="button" class="btn btn-block btn-info btn-sm" data-toggle="modal" data-target="#modal-<?php echo $recorridoDocumentosConteoA++;?>">
                                            <i class="fas fa-video"></i> Visualizar
                                            </button>
                                            <div class="modal fade" id="modal-<?php echo $recorridoDocumentosConteoB++;?>">
                                              <div class="modal-dialog modal-xl">
                                                <div class="modal-content">
                                                  <div class="modal-header" style="background:#17a2b8;color:white;">
                                                    <h4 class="modal-title"><?php echo utf8_encode($ExtraerRecorridoDocumentos['nombre']);?></h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                    </button>
                                                  </div>
                                                  <div class="modal-body" style="background:#17a2b8;color:white;">
                                                  <center>
                                                    <video   controls poster="tutoriales/video.poster.png" width="90%">
                                                      <source src="<?php echo utf8_encode($ExtraerRecorridoDocumentos['material']);?>" type="video/mp4" >
                                                    </video>
                                                  </center>
                                                  </div>
                                                  
                                                  <div class="modal-footer justify-content-between" style="background:#17a2b8;color:white;">
                                                    <button style="background:#17a2b8;color:white;" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                  </div>
                                                </div>
                                                <!-- /.modal-content -->
                                              </div>
                                              <!-- /.modal-dialog -->
                                            </div>
                                            
                                            
                                            <?php
                                            }else{ 
                                            echo "<button type='button'  class='btn btn-block btn-warning btn-sm' >
                                                <a style='color:black' href='".utf8_encode($ExtraerRecorridoDocumentos['material'])."' target='_blank' ><i class='fas fa-download'></i> Descargar</a>
                                                </button>";
                                            }
                                            ?>
                                        </td>
                                        
                               
                                        
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                                </table>
                                
                                
                                