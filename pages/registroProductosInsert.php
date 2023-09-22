<?php
require_once 'conexion/bd.php';
	$valueReg1 = $_POST['reg1'];
	$valueReg2 = $_POST['reg2'];
	$valueReg3 = $_POST['reg3'];
	$valueReg4 = utf8_decode($_POST['reg4']);
	// consultamos si ya existe el producto registrado para solo actualizar
	
	$consultamosExistencia=$mysqli->query("SELECT * FROM solicitudAlistamiento WHERE idProducto='$valueReg2' AND idSolicitud='$valueReg1'  ");
	$extraerDatos=$consultamosExistencia->fetch_array(MYSQLI_ASSOC);
	$idProductoExistente=$extraerDatos['idProducto'];
	$idProductoExistenteCantidad=$extraerDatos['cantidad'];
	
	if($idProductoExistente == $valueReg2){
	    $sumatoriaProductos=$idProductoExistenteCantidad+$valueReg3;
	     if($valueReg4 != NULL){
	        $ejecutar=$mysqli->query("UPDATE solicitudAlistamiento SET cantidad='$sumatoriaProductos' ,comentario ='$valueReg4' WHERE  idProducto='$valueReg2' AND idSolicitud='$valueReg1' ");
	     }else{
	         $ejecutar=$mysqli->query("UPDATE solicitudAlistamiento SET cantidad='$sumatoriaProductos' WHERE  idProducto='$valueReg2' AND idSolicitud='$valueReg1' ");
	     } 
	}else{
	   
	    $ejecutar=$mysqli->query("INSERT INTO solicitudAlistamiento (idSolicitud, idProducto, cantidad,comentario) VALUES ('".$valueReg1."','".$valueReg2."', '".$valueReg3."','".$valueReg4."') ");
	}
	
	
	  
	if ($ejecutar) { // Si la ejecución dio true, imprime 200
	//	echo '200';
	
	?>
	<table class="table table-head-fixed text-center" >
                         <thead>
                            <tr>
                                <th>Grupo</th>
                                <th>Subgrupo</th>
                                <!--<th>Consecutivo</th>-->
                                <th>Producto</th>
                                <th>Identificador</th>
                                <th>Código</th>
                                <th>Impuesto</th>
                                <th>Tipo producto</th>
                                <th>Cantidad</th>
                                <th>Comentario</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                            $consultaProductos=$mysqli->query("SELECT * FROM solicitudAlistamiento WHERE idSolicitud='$valueReg1' ORDER BY id ");
                            while($extraerConsulta=$consultaProductos->fetch_array()){
                            ?>
                            <tr>
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
                                <!--<td><?php //echo $extraerProductos['codigoG'];?></td>-->
                                <td><?php 
                                    $consultandoProductos=$mysqli->query("SELECT * FROM  proveedorProductos WHERE id='".$extraerConsulta['idProducto']."' ");
                                    $extraerProductos=$consultandoProductos->fetch_array(MYSQLI_ASSOC);
                                    echo $extraerProductos['nombre'];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                     $extraerProductos['identificador'];
                                     $consultaidentificadorProducto=$mysqli->query("SELECT * FROM proveedoresProductoIdentificador WHERE id='".$extraerProductos['identificador']."' ");
                                     $traerDAtosconsultaidentificadorProducto=$consultaidentificadorProducto->fetch_array(MYSQLI_ASSOC);
                                     echo $traerDAtosconsultaidentificadorProducto['grupo'];
                                    ?>
                                </td>
                                 <td>
                                    <?php
                                     echo $extraerProductos['codigo'];
                                    ?>
                                </td>
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
                                 <td>
                                    <?php
                                     echo $extraerConsulta['cantidad'];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                     echo $extraerConsulta['comentario'];
                                    ?>
                                </td>
                                <input type='hidden' id='eliminarListaB<?php echo $contadoListarBr++;?>'  value= '<?php echo $extraerConsulta['id'];?>' >
                                <td><a onclick='funcionFormulaListarB<?php echo $contadorListarB1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-listarB' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a></td>
                                <script>
                                    function funcionFormulaListarB<?php echo $contadorListarB2++;?>() {
                                        /*alert("entre");*/
                                      document.getElementById("capturarListarB").value = document.getElementById("eliminarListaB<?php echo $contadorListarB3++;?>").value;
                                    }
                                </script>
                                
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                     </table>
                      <div class="modal fade" id="modal-listarB">
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
                              <input name="idOrdenCompra" value="<?php echo $valueReg1; ?>" type="hidden">
                              <input type="hidden" id="capturarListarB" name='id' readonly>
                              <button type="submit" name='eliminar' class="btn btn-outline-light">Si</button>
                              <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
                            </div>
                             </form>
                             <!-- END formulario para eliminar por el id -->
                          </div>
                        </div>
                    </div>
                     
	<?php
	}
	
	
?>