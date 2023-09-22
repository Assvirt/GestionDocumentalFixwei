<?php
require_once 'conexion/bd.php';
	$consultaProductosId = $_POST['consultaProductos'];

	?>
                      <table class="table table-head-fixed text-center" >
                         <thead>
                            <tr>
                                <!--<th>Grupo</th>
                                <th>Subgrupo</th>
                                <th>Consecutivo</th>-->
                                <th>Producto</th>
                                <th>Identificador</th>
                                <th>Código</th>
                                <!--<th>Impuesto</th>
                                <th>Tipo producto</th>-->
                                <th>Cantidad</th>
                                <th>Comentario</th>
                                <th>Observaciones</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                            $consultaProductos=$mysqli->query("SELECT * FROM solicitudEntradaSalidas WHERE idSolicitud='$consultaProductosId' ORDER BY id ");
                            while($extraerConsulta=$consultaProductos->fetch_array()){
                            ?>
                            <tr>
                                <?php
                                /*
                                ?>
                                <td><?php  
                                    $consultandoProductos=$mysqli->query("SELECT * FROM  proveedorProductos WHERE id='".$extraerConsulta['idProducto']."' ");
                                    $extraerProductos=$consultandoProductos->fetch_array(MYSQLI_ASSOC);
                                    
                                    $grupo=$mysqli->query("SELECT * FROM proveedoresProductoGrupo WHERE id='". $extraerProductos['grupo']."' ");
                                    $extraerGrupo=$grupo->fetch_array(MYSQLI_ASSOC);
                                    echo $extraerGrupo['grupo'];
                                    $subgrupo=$mysqli->query("SELECT * FROM proveedoresProductoSubGrupo WHERE id='". $extraerGrupo['sub']."' ");
                                    $extraerSubgrupo=$subgrupo->fetch_array(MYSQLI_ASSOC);
                                    
                                    ?>
                                </td>
                                <td><?php echo $extraerSubgrupo['grupo'];?></td>
                                
                                <td><?php echo $extraerProductos['codigoG'];?></td>
                                <?php
                                */
                                ?>
                                <td><?php 
                                    $consultandoProductos=$mysqli->query("SELECT * FROM  proveedorProductos WHERE id='".$extraerConsulta['idProducto']."' ");
                                    $extraerProductos=$consultandoProductos->fetch_array(MYSQLI_ASSOC);
                                    echo $extraerProductos['nombre'];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                     echo $extraerProductos['identificador'];
                                    ?>
                                </td>
                                 <td>
                                    <?php
                                     echo $extraerProductos['codigo'];
                                    ?>
                                </td>
                                <?php
                                /*
                                ?>
                                <td><?php 
                                    $consultaImpuesto=$extraerProductos['impuesto'];
                                    $validarImpuesto=$mysqli->query("SELECT * FROM proveedoresTipoImpuesto WHERE id='$consultaImpuesto' ");
                                    $extraerValidarImpuesto=$validarImpuesto->fetch_array(MYSQLI_ASSOC);
                                    echo $extraerValidarImpuesto['grupo'].' '.$extraerValidarImpuesto['descripcion'].' %';
                                    ?>
                                </td>
                                <td><?php 
                                        if($extraerProductos['tipoProducto']){
                                            echo 'Bienes';
                                        }else{
                                            echo 'Servicios';
                                        }
                                    ?>
                                </td>
                                <?php
                                */
                                ?>
                                 <td>
                                    <?php
                                     echo $extraerConsulta['cantidad'];
                                    ?>
                                </td>
                                <?php /* ?>
                                <td>
                                    <form action="" method="post">
                                    <input name="idOrdenCompra" value="<?php echo $_POST['consultaProductos']; ?>" type="">
                                    <input name="id" value="<?php echo $extraerConsulta['id']; ?>" type="">
                                    <button type="submit" name="eliminacion">Eliminar</button>
                                    </form>
                                </td>
                                <?php */ ?>
                                <td><?php echo $extraerConsulta['comentario']; ?></td>
                                <td>
                                    <?php 
                                        $validandoConsultaPedido=$mysqli->query("SELECT * FROM solicitudAlistamiento WHERE idSolicitud='$consultaProductosId' AND idProducto='".$extraerConsulta['idProducto']."' ");
                                        $extrerValidacionProductos=$validandoConsultaPedido->fetch_array(MYSQLI_ASSOC);
                                        
                                        if($extraerConsulta['cantidad'] == $extrerValidacionProductos['cantidad']){
                                            echo '<font color="green">El producto está completo</font>';
                                        }elseif($extraerConsulta['cantidad'] > $extrerValidacionProductos['cantidad']){
                                            $restante=ABS($extraerConsulta['cantidad']-$extrerValidacionProductos['cantidad']);
                                          
                                            
                                            if($restante == 1){
                                                 echo '<font color="blue">Llego '.$restante.' de más</font>';
                                            }else{
                                                 echo '<font color="blue">Llegaron '.$restante.' de más</font>';
                                            }
                                        }elseif($extraerConsulta['cantidad'] < $extrerValidacionProductos['cantidad']){
                                            $restante=ABS($extraerConsulta['cantidad']-$extrerValidacionProductos['cantidad']);
                                            
                                            if($restante == 1){
                                                 echo '<font color="red">Falta '.$restante.' producto</font>';
                                            }else{
                                                 echo '<font color="red">Faltan '.$restante.' del producto</font>';
                                            }
                                           
                                        }
                                    ?>
                                </td>
                                <?php
                                // validacion
                                $consultandoResponsables=$mysqli->query("SELECT * FROM solicitudCompra WHERE id='$consultaProductosId' ");
                                $extraerValidacion=$consultandoResponsables->fetch_array(MYSQLI_ASSOC);
                                $idSolicitudValidacion=$extraerValidacion['estado'];
                                
                                 ?>
                                <input type='hidden' id='eliminarListaA<?php echo $contadoListarr++;?>'  value= '<?php echo $extraerConsulta['id'];?>' >
                                
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
                            <form action='controlador/solicitudCompra/controllerAlistamiento' method='POST'>
                            <div class="modal-footer justify-content-between">
                              <input name="idOrdenCompra" value="<?php echo $_POST['consultaProductos']; ?>" type="hidden">
                              <input type="hidden" id="capturarListarA" name='id' readonly>
                              <button type="submit" name='eliminarEntradaSalida' class="btn btn-outline-light">Si</button>
                              <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
                            </div>
                             </form>
                             <!-- END formulario para eliminar por el id -->
                          </div>
                        </div>
                    </div>
                      <?php
	
	
	
?>