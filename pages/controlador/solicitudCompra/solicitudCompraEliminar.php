<?php
require_once '../../conexion/bd.php';
//include '../../solicitudCompra.php';

    'Id:'.$idCompra = $_POST['id'];
     '<br>';
     'Fecha:'.$fechaSolicitud = $_POST['fechaSolicitud'];
     '<br>';
      'Contacto:'.$contacto = $_POST['contacto'];
     '<br>';
     'Tipo Compra:'.$tipoCompra = $_POST['tipoCompra'];
     '<br>';
     'Centro Trabajo:'.$centroTrabajo = $_POST['centroTrabajo'];
     '<br>';
     'Centro Costo:'.$centroCosto = json_encode($_POST['centroCostoS']);//$centroCosto = $_POST['centroCosto'];
     '<br>';
     'Proceso:'.$proceso = $_POST['procesoS'];
     '<br>';
     'Contrato:'.$contrato = $_POST['contrato'];
     '<br>';
     'Observacion:'.$observacion = $_POST['observacion'];
      '<br>';
     'Tipo:'.$tipoBien = $_POST['tipoBien'];
     '<br>';
      'Archivo:'.$archivopdf = $_POST['archivopdf']['name'];
     //echo 'Archivo:';

    $mysqli->query("DELETE FROM solicitudCompra WHERE id = '$idCompra'")or die(mysqli_error($mysqli));
     echo 'Registro eliminado';

?>