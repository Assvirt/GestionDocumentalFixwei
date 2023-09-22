<?php

require_once 'conexion/bd.php';

'ID: '.$idEvaluacion = $_POST['idEvaluacion'];

?>
                                <table class="table table-head-fixed text-center"> 
                                <thead>
                                    <th>Nombre</th>
                                    <th>Extensión</th>
                                    <th>Descargar/visualizar</th>
                                    <th>Eliminar</th>
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
                                        
                                        <input type='hidden' id='eliminarListaA<?php echo $contadoListarr++;?>'  value= '<?php echo $ExtraerRecorridoDocumentos['id'];?>' >
                                        <td><a <?php echo $disabled; ?> onclick='funcionFormulaListarA<?php echo $contadorListar1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-listarA' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a></td>
                                        <script>
                                            function funcionFormulaListarA<?php echo $contadorListar2++;?>() {
                                                /*alert("entre");*/
                                              document.getElementById("capturarListarA").value = document.getElementById("eliminarListaA<?php echo $contadorListar3++;?>").value;
                                              
                                            }
                                        </script> 
                               
                                        
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                                </table>
                                
                                <div class="modal fade" id="modal-listarA">
                                    <div class="modal-dialog">
                                      <div class="modal-content bg-danger">
                                        <div class="modal-header">
                                          <h4 class="modal-title">Alerta</h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                          <p>¿Est&aacute; seguro que desea eliminar?</p>
                                        </div>
                                         <!-- formulario para eliminar por el id -->
                                        <form action='controlador/evaluacion/controllerEvaluacion' method='POST'>
                                             <?php
                                            ////// rescatamos el id del editar para mantener la variable activa
                                            if($_POST['idEvaluacionEditar'] != NULL){
                                            ?>
                                            <input name="idEvaluacion" value="<?php echo $_POST['idEvaluacionEditar'];?>" type="hidden">
                                            <?php
                                            }
                                            /// end
                                            ?>
                                        <div class="modal-footer justify-content-between">
                                          <input name="idOrdenCompra" value="<?php echo $_POST['consultaProductos']; ?>" type="hidden">
                                          <input type="hidden" id="capturarListarA" name='id' readonly>
                                          <button type="submit" name='eliminarDocumentos' class="btn btn-outline-light">Si</button>
                                          <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
                                        </div>
                                         </form>
                                         <!-- END formulario para eliminar por el id -->
                                      </div>
                                    </div>
                                </div>
                                