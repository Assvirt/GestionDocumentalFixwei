<?php

error_reporting(E_ERROR);
//////// traemos la bd
require_once '../../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario

if(isset($_POST['AgregarSolicitud'])){
    
     'Id:'.$idUsuario = $_POST['idUsuario'];
     '<br>';
     'Fecha:'.$fechaSolicitud = $_POST['fechaSolicitud'];
     '<br>';
     'Contacto:'.$contacto = utf8_decode($_POST['contacto']);
     '<br>';
     'Tipo Compra:'.$tipoCompra = $_POST['tipoCompra'];
     '<br>';
     'Centro Trabajo:'.$centroTrabajo = $_POST['centroTrabajo'];
     '<br>';
     'Centro Costo:'. $centroCosto = json_encode($_POST['centroCostoS']);//$centroCosto = $_POST['centroCostoS'];
     '<br>';
     'Proceso:'.$proceso = $_POST['procesoS'];
     '<br>';
     'Contrato:'.$contrato = utf8_decode($_POST['contrato']);
     '<br>';
     'Observacion:'.$observacion = utf8_decode($_POST['observacion']);
     '<br>';
     'Tipo:'.$tipoBien = $_POST['tipoBien'];
     '<br>';
     $tiempo=$_POST['tiempo']; 
     $tipoSolicitud=$_POST['tipoSolicitud'];
                $mysqli->query("INSERT INTO solicitudCompra(fechaSolicitud,contacto,tipoCompra,centroTrabajo,centroCosto,proceso,contrato,observacion,TipoBS,idUsuario,estado,tiempo,tipoSolicitud)VALUES('$fechaSolicitud','$contacto','$tipoCompra','$centroTrabajo','$centroCosto','$proceso','$contrato','$observacion','$tipoBien','$idUsuario','Pendiente','$tiempo','$tipoSolicitud')")or die(mysqli_error($mysqli));//'$ruta','$ruta2','$ruta3',
                //,archivo,archivo2,archivo3
    
                
                   $consultaUltimo=$mysqli->query("SELECT MAX(id) AS idSolicitudCompra FROM solicitudCompra WHERE idUsuario='$idUsuario' ");
                    $estraUltimo=$consultaUltimo->fetch_array(MYSQLI_ASSOC);
                    $idSC=$estraUltimo['idSolicitudCompra'];
                ?>
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformulario"].submit();
                         }
                    </script>
                     
                    <form name="miformulario" action="../../registroProductos" method="POST" onsubmit="procesar(this.action);" >
                        <input name="idOrdenCompra" value="<?php echo $idSC;?>" type="hidden">
                        <input type="hidden" name="validacionAgregar" value="1">
                    </form> 
                <?php  
                
          
}
if(isset($_POST['Actualizar'])){
    $id=$_POST['id'];
     'Id:'.$idUsuario = $_POST['idUsuario'];
     '<br>';
     'Fecha:'.$fechaSolicitud = $_POST['fechaSolicitud'];
     '<br>';
      'Contacto:'.$contacto = utf8_decode($_POST['contacto']);
     '<br>';
     'Tipo Compra:'.$tipoCompra = $_POST['tipoCompra'];
     '<br>';
     'Centro Trabajo:'.$centroTrabajo = $_POST['centroTrabajo'];
     '<br>';
     'Centro Costo:'.$centroCosto = json_encode($_POST['centroCostoS']);//$centroCosto = $_POST['centroCosto'];
     '<br>';
     'Proceso:'.$proceso = $_POST['procesoS'];
     '<br>';
     'Contrato:'.$contrato = utf8_decode($_POST['contrato']);
     '<br>';
     'Observacion:'.$observacion = utf8_decode($_POST['observacion']);
      '<br>';
     'Tipo:'.$tipoBien = $_POST['tipoBien'];
     '<br>';
      'Archivo:'.$archivopdf = $_POST['archivopdf']['name'];
     //echo 'Archivo:';
     $tiempo=$_POST['tiempo']; 
     $tipoSolicitud=$_POST['tipoSolicitud'];
    $mysqli->query("UPDATE solicitudCompra SET fechaSolicitud ='$fechaSolicitud',contacto ='$contacto',tipoCompra='$tipoCompra',centroTrabajo='$centroTrabajo',centroCosto='$centroCosto',proceso='$proceso',contrato='$contrato',observacion='$observacion',TipoBS='$tipoBien', tiempo='$tiempo', tipoSolicitud='$tipoSolicitud' WHERE id='$id' ")or die(mysqli_error($mysqli));
  ?>     
   <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../solicitudCompra" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionActualizar" value="1">
            </form> 
  <?php  
}


if(isset($_POST['Eliminar'])){
   
   
   
    $idElminacion = $_POST['id'];
    $ConsultaDocumento = $mysqli->query("SELECT * FROM uploads WHERE idSolicitudCompra='$idElminacion'");
    while($extraerConsultaDocumento= $ConsultaDocumento->fetch_array()){
    $IdOrden=$extraerConsultaDocumento['file_name'];
        $eliminacion=unlink('../../almacenamientoMultiple/uploads/'.$IdOrden);
    }
    
     $mysqli->query("DELETE FROM solicitudCompra WHERE id ='".$_POST['id']."'")or die(mysqli_error($mysqli));
     $mysqli->query("DELETE FROM solicitudAlistamiento WHERE idSolicitud ='".$_POST['id']."'")or die(mysqli_error($mysqli));
     $mysqli->query("DELETE FROM solicitudCompraFlujo WHERE idSolicitud ='".$_POST['id']."'")or die(mysqli_error($mysqli)); 
     $mysqli->query("DELETE FROM uploads WHERE idSolicitudCompra ='".$_POST['id']."'")or die(mysqli_error($mysqli));
   
     //echo 'Registro eliminado';
     ?>
            <script> 
                 window.onload=function(){
               
                    document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../solicitudCompra" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminar" value="1">
            </form> 
<?php
}
?>