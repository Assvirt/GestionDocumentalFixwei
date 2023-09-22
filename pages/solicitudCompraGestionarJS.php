<?php
require_once 'conexion/bd.php';
	$consultaProductos = $_POST['consultaProductos'];

	?>
                      <table class="table table-head-fixed text-center" >
                         <thead>
                            <tr>
                                <th>Grupo</th>
                                <th>Subgrupo</th>
                                <!--<th>consecutivo</th>-->
                                <th>Producto</th>
                                <th>Identificador</th>
                                <th>Código</th>
                                <th>Impuesto</th>
                                <th>Tipo producto</th>
                                <th>Cantidad</th>
                                <th>Comentario</th>
                            
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                            $consultaProductos=$mysqli->query("SELECT * FROM solicitudAlistamiento WHERE idSolicitud='$consultaProductos' ORDER BY id ");
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
                                     //echo $extraerProductos['identificador'];
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
                              </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                     </table>
                  
                      <?php
	
	
	
?>