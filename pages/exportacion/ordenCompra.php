<?php

header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=OrdenDeCompra.xls');

require '../conexion/bd.php';

$idparaChat=$_POST['usuario'];
$acentos = $mysqli->query("SET NAMES 'utf8'");
$data = $mysqli->query("SELECT * FROM solicitudCompra WHERE estado='Orden de compra' ORDER BY id ASC")or die(mysqli_error());
?>

<table border="1">
    <tr>
        <!--
        <th><?php //echo utf8_decode('N°');?></th>
        <th>Fecha de solicitud</th>
        <th><?php //echo utf8_decode('Dirección o contacto de entrega');?></th>
        <th>Tipo de compra</th>
        <th>Centro de trabajo para entrega</th>
        <th>Centro de costos</th>
        
        <th><?php //echo utf8_decode('Área o proceso');?></th>
        <th>Necesidad</th>
        <th>Contrato</th>
        <th>Observaciones</th>
        
        <th>Solicitante</th>
        <th>Aprobador</th>
        <th>Estado </th>
        <th>Trazabilidad</th> -->
        <th>Alistamiento</th>
        <!--<th>Correo con copia a</th>-->
        
    </tr>
    <?php
        
        while($row = $data->fetch_assoc()){
            
                        ///// validamos quién puede ver las solitudes asignadas
                         $visualizacionSolicitud=$mysqli->query("SELECT * FROM solicitudCompradorTemporal WHERE idSolicitud='".$row['id']."' AND estado='pendiente' "); //solicitudComprador ejecutado
                         $extraerDatos=$visualizacionSolicitud->fetch_array(MYSQLI_ASSOC);
                         $idUsuarioCorreo=$extraerDatos['correo'];
                         if($extraerDatos['idUsuario'] == $idparaChat){
                            $idSolicitudOC=$extraerDatos['id'];
                         }else{
                           continue;  
                         }
                    
                        $id = $row['id'];
                    echo"<tr>";
                    /*
                    echo"<td>".$id."</td>"; //$conteo++
                    echo "<td>".$row['fechaSolicitud']."</td>";
                    echo "<td>".utf8_decode($row['contacto'])."</td>";
                    
                    $tipoCompra=$mysqli->query("SELECT * FROM solicitudCompraTipo WHERE id='".$row['tipoCompra']."' ");
                    $extraerTipCompra=$tipoCompra->fetch_array(MYSQLI_ASSOC);
                    $nombreTipoCompra=$extraerTipCompra['tipo'];
                    echo "<td>".utf8_decode($nombreTipoCompra)."</td>";
                    
                    $rowCentroTrabajo=$row['centroTrabajo']."</td>";
                     
                        $validacionCentroTrabajoExt = $mysqli->query("SELECT * FROM centrodetrabajo WHERE id_centrodetrabajo='$rowCentroTrabajo' ");
                        $columnaValidandoCentroTrabajo = $validacionCentroTrabajoExt->fetch_array(MYSQLI_ASSOC);
                    echo "<td>".utf8_decode($columnaValidandoCentroTrabajo['nombreCentrodeTrabajo'])."</td>"; 
                        
                    
                    $rowCentroCosto=$row['centroCosto'];
                    
                        $array = json_decode ($row['centroCosto']);
                        $longitud = count($array);
                        echo "<td>";
                            for($i=0; $i<$longitud; $i++){
                              
                                $validacionCentroCostoExt = $mysqli->query("SELECT * FROM centroCostos WHERE id='$array[$i]' ");
                                $columnaValidandoCentroCosto = $validacionCentroCostoExt->fetch_array(MYSQLI_ASSOC); 
                                //// traemos al responsable del centro de costo
                                $responsable=$mysqli->query("SELECT * FROM usuario WHERe id='".$columnaValidandoCentroCosto['persona']."' ");
                                $extraerPersona=$responsable->fetch_array(MYSQLI_ASSOC);
                                $nombrePersonaResponsable=utf8_decode($extraerPersona['nombres'].' '.$extraerPersona['apellidos']);
                            	echo "*".utf8_decode($columnaValidandoCentroCosto['nombre'])." ($nombrePersonaResponsable)<br>";
                            
                            }
                        echo "</td>";
                        
                    
                    
                    
                        $rowUsuario=$row['idUsuario'];
                        $validacionUsuarioExt = $mysqli->query("SELECT * FROM usuario WHERE cedula='$rowUsuario' ");
                        $columnaValidandoUsuario = $validacionUsuarioExt->fetch_array(MYSQLI_ASSOC);
                         "<td>".$columnaValidandoUsuario['nombres']." ".$columnaValidandoUsuario['apellidos']."</td>";
                        $validandoProceso=$columnaValidandoUsuario['proceso'];
                        $validandoLider=$columnaValidandoUsuario['lider'];
                        
                        $validacionProcesoExt = $mysqli->query("SELECT * FROM procesos WHERE id='$validandoProceso' ");
                        $columnaValidandoProceso = $validacionProcesoExt->fetch_array(MYSQLI_ASSOC);
                        echo "<td>".utf8_decode($columnaValidandoProceso['nombre'])."</td>";
                        
                        echo "<td>";
                        if($row['TipoBS']=='B'){
                            echo 'Bien';
                        }elseif($row['TipoBS']=='S'){
                            echo 'Servicio';
                        }else{
                            echo 'Bien';
                            echo ' / ';
                            echo 'Servicio';
                        } 
                        echo "</td>";
                    
                     
                     echo "<td>".utf8_decode($row['contrato'])."</td>";
                     echo "<td>".utf8_decode($row['observacion'])."</td>";
                    
                    
                    
                        echo "<td>".utf8_decode($columnaValidandoUsuario['nombres']." ".$columnaValidandoUsuario['apellidos'])."</td>";
                       
                        
                        $usuarioIdAprobador=$mysqli->query("SELECT * FROM solicitudCompraFlujo  WHERE idSolicitud='$id' AND rol='2' ");
                        $columnaValidandoAprobador=$usuarioIdAprobador->fetch_array(MYSQLI_ASSOC);
                        'U:'.$idUsuarioFlujo=$columnaValidandoAprobador['idUsuario'];
                        
                        $usuarioAprobador=$mysqli->query("SELECT * FROM usuario WHERE id='$idUsuarioFlujo' ");
                        $extraerUsuarioAProbador=$usuarioAprobador->fetch_array(MYSQLI_ASSOC);
                        
                        if($idUsuarioFlujo != NULL){
                            echo "<td>".utf8_decode($extraerUsuarioAProbador['nombres']." ".$extraerUsuarioAProbador['apellidos'])."</td>";   
                        }else{
                            echo "<td>N/A</td>";
                        }
                        
                        echo "<td>".$row['estado']."</td>";
                        
                        echo '<td>';
                                $consultaComentarios = $mysqli->query("SELECT * FROM solicitudCompraComentarios WHERE idSolicitud='$id'  ");
                                while($extraerComentario = $consultaComentarios->fetch_assoc()){
                                    $usuario=$extraerComentario['idUsuario'];
                                    $consultaUsuario = $mysqli->query("SELECT nombres,apellidos FROM usuario WHERE id = '$usuario'");
                                    $extraerUsuario=$consultaUsuario->fetch_array(MYSQLI_ASSOC);
                                ?>
                                <table border="1">
                                    <thead>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                        <th>Usuario</th>
                                        <th>Comentario</th>
                                    </thead>
                                    <tr>
                                        <td>
                                        <?php
                                        echo $extraerComentario['fecha'].'<br>';
                                        echo '</td><td>';
                                        echo ucwords($extraerComentario['estado']).'<br>'; 
                                        echo '</td><td>';
                                        echo utf8_decode($usuarioComentario=$extraerUsuario['nombres'].' '.$extraerUsuario['apellidos']).'<br>';
                                        echo '</td><td>';
                                        echo utf8_decode($extraerComentario['comentario']).'<br><br>';
                                        ?>
                                        </td>
                                    </tr>
                                </table>
                                <?php                        
                                }
                        echo '</td>';
                        */
                        echo '<td>';
                            $consultandoProveedorSeleccionado=$mysqli->query("SELECT * FROM solicitudCompradorTemporal WHERE idSolicitud='$id' "); //solicitudComprador
                            $extraerDatosConsultaProveedorSeleccionado=$consultandoProveedorSeleccionado->fetch_array(MYSQLI_ASSOC);
                            $existenciaProveedor=$extraerDatosConsultaProveedorSeleccionado['proveedor'];
                            $userProv=$extraerDatosConsultaProveedorSeleccionado['idUsuario'];
                            $idSolicituCOmprador=$extraerDatosConsultaProveedorSeleccionado['id'];
                            $fechaActivada=$extraerDatosConsultaProveedorSeleccionado['fechaActivada'];
                            
                            $consultaUsuarioComprador=$mysqli->query("SELECT * FROM usuario WHERE id = '$userProv'");
                            $extraerDatosCompradorCompleto=$consultaUsuarioComprador->fetch_array(MYSQLI_ASSOC);
                            $usuarioCompras=$extraerDatosCompradorCompleto['nombres'].' '.$extraerDatosCompradorCompleto['apellidos'];
                            
                            $consultandoProveedor=$mysqli->query("SELECT * FROM proveedores WHERE id='$existenciaProveedor' ");
                            $extraerDatosConsultaProveedor=$consultandoProveedor->fetch_array(MYSQLI_ASSOC);
                            
                            $consultaSolicitudDeCompra = $mysqli->query("SELECT * FROM solicitudCompra WHERE id = '$id'");
                            $extraerDatosSolicitud = $consultaSolicitudDeCompra->fetch_array(MYSQLI_ASSOC);
                            $DateAndTime = date('d-m-Y', time());  
                            
                            ?>
                            <table border="1">
                            <tr>
                                <th>
                                     &nbsp<b> <?php echo utf8_decode('Razón Social');?>:&nbsp;</b> <?php echo utf8_decode($extraerDatosConsultaProveedor['razonSocial']);?> 
                                    <br>
                                    &nbsp<b> NIT:&nbsp;</b><?php echo $extraerDatosConsultaProveedor['nit']; ?>
                                    <br>
                                    &nbsp<b> <?php echo utf8_decode('Teléfono');?>:&nbsp;</b><?php echo $extraerDatosConsultaProveedor['telefono']; ?>
                                    <br>
                                    &nbsp<b> Ciudad:&nbsp;</b><?php echo utf8_decode($extraerDatosConsultaProveedor['ciudad']); ?>
                                    <br>
                                    &nbsp<b> <?php echo utf8_decode('Dirección');?>: &nbsp;</b><?php echo utf8_decode($extraerDatosConsultaProveedor['direccion']); ?>
                                    <br>
                                    &nbsp<b> Correo: &nbsp;</b><?php echo utf8_decode($extraerDatosConsultaProveedor['email']); ?>
                                    <br>
                                </th>
                                <th>    
                                    &nbsp;<b> Orden de Compra # &nbsp;
                                    <?php echo $idSolicituCOmprador;
                                       /* $consucutivo=$mysqli->query("SELECT * FROM consecutivoOC ORDER BY id ");
                                        while($extraerConsecutivo=$consucutivo->fetch_array()){
                                            
                                            if($extraerConsecutivo['aplicado'] == '1'){
                                            echo    $idSolicituCOmprador;
                                            }elseif($extraerConsecutivo['caracter'] == 'Fecha'){
                                            echo $fechaActivada;    
                                            }else{
                                            echo $extraerConsecutivo['caracter'];
                                            }
                                            echo '-';
                                        }*/
                                    ?>
                                    </b>
                                    <br>
                                    &nbsp;<b> Solicitud de Compra # <?php echo $id ?>&nbsp</b>
                                    <br>
                                    &nbsp;<b> Fecha de <?php echo utf8_decode('emisión');?> Orden de Compra:&nbsp;</b> <?php echo $DateAndTime ; ?>
                                    <br>
                                    &nbsp;<b> Comprador:&nbsp;</b><?php echo utf8_decode($usuarioCompras); ?>
                                </th>
                            </tr>
                            </table>        
                            
                                    <table border="1"> 
                                            
                                            <thead>
                                                <tr>
                                               
                                                <th>Producto</th>
                                                <th>Identificador</th>
                                                <th><?php echo utf8_decode('Código');?></th>
                                                <th>Tipo producto</th>
                                                <th>Impuesto</th>
                                                <th>Cantidad</th>
                                                
                                                <th>V.Unitario</th>
                                               
                                                <th>Subtotal</th>
                                               
                                                <th>Iva</th>
                                               
                                                <th>Total</th>
                                                </tr>
                                            </thead> 
                                        <tbody>
                                        <?php 
                                           $consultaProductos = $mysqli->query("SELECT * FROM solicitudAlistamiento WHERE idSolicitud='$id' ORDER BY id");
                                           
                                           while($extraerConsulta = mysqli_fetch_array($consultaProductos)){
                                              ?>
                                            
                                            <tr>
                                                
                                                <td><?php 
                                                    $consultandoProductos=$mysqli->query("SELECT * FROM  proveedorProductos WHERE id='".$extraerConsulta['idProducto']."' ");
                                                    $extraerProductos=$consultandoProductos->fetch_array(MYSQLI_ASSOC);
                                                    echo $extraerProductos['nombre'];
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    // echo $extraerProductos['identificador'];
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
                                                        if($extraerProductos['tipoProducto']){
                                                            echo 'Bienes'; 
                                                        }else{
                                                            echo 'Servicios';
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                   
                                                    
                                                        
                                                    <?php 
                                                    $consultaImpuesto=$extraerConsulta['impuesto'];
                                                    $validarImpuesto=$mysqli->query("SELECT * FROM proveedoresTipoImpuesto WHERE id='$consultaImpuesto' ");
                                                    $extraerValidarImpuesto=$validarImpuesto->fetch_array(MYSQLI_ASSOC);
                                                    $enviarImpuesto=$extraerValidarImpuesto['descripcion'];
                                                    
                                                     echo $extraerValidarImpuesto['grupo'].' '.$extraerValidarImpuesto['descripcion'].' %'; ?>
                                                   
                                                    
                                                </td>
                                               
                                                 <td>
                                                    <?php
                                                    $enviarCantidad=$extraerConsulta['cantidad'];
                                                     echo $extraerConsulta['cantidad'];
                                                    ?>
                                                </td>
                                               
                                                <td>
                                                    <?php echo '$'.(number_format($extraerConsulta['unitario']));?>
                                                </td>
                                                 
                                                <td>
                                                    <?php
                                                         echo '$'.number_format($extraerConsulta['costos']);
                                                         $costoPorUnidad=$extraerConsulta['costos'];
                                                    ?>   
                                                </td>
                                                 
                                                <td>
                                                    <?php 
                                                        
                                                        $impuestoAplicado=$costoPorUnidad*($enviarImpuesto/100);
                                                        echo '$'.number_format($impuestoAplicado);
                                                        $enviarImpuesto; echo '';
                                                    ?>   
                                                </td>
                                                   
                                                <td>
                                                    <?php
                                                        echo '$'.number_format($costoPorUnidad+$impuestoAplicado);
                                                    ?>
                                                </td>
                                            </tr>  
                                            <?php
                                            $costoPorUnidadSumatoria+=$extraerConsulta['costos'];
                                            $impuestoAplicadoSumatora+=$costoPorUnidad*($enviarImpuesto/100);
                                               
                                           }
                                        ?>
                                      </tbody>  
                                    </table>
                                      <br>
                                      <b style='text-align:right'>Subtotal : $ <?php echo number_format($costoPorUnidadSumatoria); ?></b>
                                      <br>
                                      <b style='text-align:right'>Iva : $ <?php echo number_format($impuestoAplicadoSumatora); ?></b>
                                      <br>
                                      <b style='text-align:right'>Total: $ <?php  echo number_format($costoPorUnidadSumatoria+$impuestoAplicadoSumatora);  ?></b>
                     
                     <?php
                        echo '</td>';
                   
                   
                   /* echo '<td>';
                        $usuarioCorreo=$mysqli->query("SELECT * FROM usuario WHERE id='$idUsuarioCorreo' ");
                        $extraerUusarioCorreo=$usuarioCorreo->fetch_array(MYSQLI_ASSOC);
                        echo utf8_decode($extraerUusarioCorreo['correo']);
                    echo '</td>';*/
                   
                   
                    echo"</tr>";
                    }
        ?>
    

</table>