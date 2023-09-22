<?php
header('Content-type:application/xls');
header("Content-Type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename=ProveedoresActivos.xls');


require '../../conexion/bd.php';
?>

<table border="1">
    <tr>
       <th>Nit</th>
       <th>Contacto</th>
       <th><?php echo utf8_decode('Razón social');?></th>
       <th>Correo</th>
       <th><?php echo utf8_decode('Móvil');?></th>
       <th><?php echo utf8_decode('Actividad económica');?></th>
       <th>Criticidad</th>
       <th>Grupo</th>
       <th><?php echo utf8_decode('Método de pago');?></th>
       <th>Ciudad</th>
       <th><?php echo utf8_decode('Dirección');?></th>
       <th><?php echo utf8_decode('Fecuencia de actualización de documentos');?></th>
       <th><?php echo utf8_decode('Télefono');?></th>
       <th><?php echo utf8_decode('Tiempo de evaluación');?></th>
       <th>Tipo de persona</th>
       <th>Tipo de proveedor</th>
        
    </tr>
   
       
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="color:gray;">
                <?php 
                $consultaTipoProveedor=$mysqli->query("SELECT * FROM proveedoresCriticidad ORDER BY tipo");
                $conteo='1';
                while($extraerConsultaTipoprove=$consultaTipoProveedor->fetch_array()){
                 
                            echo $tipoConsultaValidar=$extraerConsultaTipoprove['tipo']; echo '<br>';
                }
                ?>
            </td>
            <td></td>
            <td>
                <?php echo utf8_decode('Crédito');?><br>Contado<br>Contraentrega<br>Otro
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="color:gray;">
                <?php
               
                
                //if($conteo++%2 == 0){
                    echo utf8_decode('jurídico');
                //}else{
                    echo '<br>natural';
                //}
                
                ?>
               
            </td>
            <td style="color:gray;">
            <?php
            $consultaTipoProveedorTipo=$mysqli->query("SELECT * FROM proveedoresTipo  ORDER BY tipo");
            $conteo=1;
            while($extraerConsultaTipoproveTipo=$consultaTipoProveedorTipo->fetch_array()){
            
                  
                    echo $extraerConsultaTipoproveTipo['tipo']; echo '<br>';
            
            } 
            ?>
            </td>
           
        </tr>
      

</table>