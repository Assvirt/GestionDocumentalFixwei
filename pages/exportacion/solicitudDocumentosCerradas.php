<?php
session_start();
if(!isset($_SESSION["session_username"])){
    //header("login");
    echo '<script language="javascript">confirm("Sesión Finalizada por Inactividad");
    window.location.href="../examples/login"</script>';
}else{
    
header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=solicitudDocumentosCerradas.xls');

require '../conexion/bd.php';

$celdulaUser = $_SESSION['session_username']; 
$cargoID = $_SESSION['session_cargo']; 

$acentos = $mysqli->query("SET NAMES 'utf8'");
$data = $mysqli->query("SELECT * FROM solicitudDocumentos WHERE estado ='Ejecutado' OR estado = 'Rechazado'")or die(mysqli_error());

?>

<table border="1">
    <tr>
        
        
		<th class="text-center">Fecha</th>
        <th class="text-center">Quien Solicita</th>
        <th class="text-center">Tipo Solicitud</th>
        <th class="text-center">Documento</th>
        <th class="text-center">Encargado Aprobar</th>
        <th class="text-center">Estado</th>
        <th class="text-center">Fecha de cierre</th>
        <th class="text-center">Tiempo de respuesta</th>
        <th class="text-center">Proceso</th>
        <th class="text-center">Tipo de documento</th>
        <th class="text-center">Tiempo restante para responder la solicitud</th>
		
		
        
        
    </tr>
    <?php
        
       while($row = $data->fetch_assoc()){
                        
                        $quienSolicita = $row['quienSolicita'];
                        $encargadoAprobar = $row['encargadoAprobar'];
                        
                        if($quienSolicita != $celdulaUser){
                            if($encargadoAprobar != $cargoID ){
                                continue;
                            }
                        }
                        
                        
                        $fechainicial = $row['fecha'];
                        $fechaactual = date("Y-m-d");
                        
                        $fechainicial2 = strtotime($row['fecha']);
                        $fechacierre = strtotime($row['fechaCierre']);
                        
                        $datediff = $fechacierre - $fechainicial2 ;
                        
                        $tiempoeElaboracion = round($datediff / (60 * 60 * 24));
                        
                        $tiempoRespuesta =$row['tiempoRespuesta'];
                        
                        $fechaRestar = date("Y-m-d",strtotime($fechainicial."+ ".$tiempoRespuesta." days")); 
                        
                        $datetime1 = date_create($fechaRestar);
                        $datetime2 = date_create($fechaactual);
                        $contador = date_diff($datetime1, $datetime2);
                        $differenceFormat = '%a';

                        
                     echo"<tr>";
                     echo" <td style='text-align: justify;'>".$row['fecha']."</td>";
                     $solicitudID = $row['id'];
                     $usuarioName= $row['quienSolicita'];
                     $acentos = $mysqli->query("SET NAMES 'utf8'");
                     $nombreUsuario = $mysqli->query("SELECT * FROM usuario WHERE cedula ='$usuarioName'")or die(mysqli_error());
                     $col = $nombreUsuario->fetch_array(MYSQLI_ASSOC);
                     $nombre =utf8_decode($col['nombres']);
                     $nombre2 = utf8_decode($col['apellidos']);
                     echo" <td style='text-align: justify;'>".$nombre.' '.$nombre2."</td>";
                     $row['tipoSolicitud'];
                     if($row['tipoSolicitud'] == 1){
                        echo" <td style='text-align: justify;'>".CREAR."</td>";
                     }elseif($row['tipoSolicitud'] == 2){
                        echo" <td style='text-align: justify;'>".ACTUALIZAR."</td>"; 
                     }else{
                        echo" <td style='text-align: justify;'>".ELIMINAR."</td>"; 
                     }
                     
                     
                     if($row['tipoSolicitud'] != 1){
                        $nombreMelo = $row['nombreDocumento2'];
                        
                        echo" <td style='text-align: justify;'>".utf8_decode($nombreMelo)."</td>";
                     }else{
                        echo" <td style='text-align: justify;'>".utf8_decode($row['nombreDocumento2'])."</td>";
                     }
                     $encargadoA = $row['encargadoAprobar'];
                     $nombreEncargado = $mysqli->query("SELECT * FROM cargos WHERE id_cargos ='$encargadoA'")or die(mysqli_error());
                     $col2 = $nombreEncargado->fetch_array(MYSQLI_ASSOC);
                     $nombreE = $col2['nombreCargos'];
                     echo" <td style='text-align: justify;'>".utf8_decode($nombreE)."</td>";
                     echo" <td style='text-align: justify;'><font color='#35840E'>".$row['estado']."</font></td>";
                     echo" <td style='text-align: justify;'>".$row['fechaCierre']."</td>";
                     
                     if($tiempoRespuesta < $tiempoeElaboracion){
                        echo" <td style='text-align: justify;'><font color='red'>".$tiempoeElaboracion."</font></td>"; 
                     }else{
                        echo" <td style='text-align: justify;'><font color='green'>".$tiempoeElaboracion."</font></td>"; 
                     }
                     
                     
                     
                     $proceso = $row['proceso'];
                     $nombreProceso = $mysqli->query("SELECT * FROM procesos WHERE id ='$proceso'")or die(mysqli_error());
                     $col3 = $nombreProceso->fetch_array(MYSQLI_ASSOC);
                     $nombreP = $col3['nombre'];
                     //echo" <td style='text-align: justify;'>".utf8_decode($nombreP)."</td>";
                     
                     if($nombreTipoDOcumentoN != NULL){
                        echo" <td style='text-align: justify;'>".utf8_decode($nombreP)."</td>";
                     }else{
                        echo" <td style='text-align: justify;'>".$row['procesoG']."</td>";
                     }
                     
                     $nombreTipoDocumento = $mysqli->query("SELECT * FROM tipoDocumento WHERE id ='".$row['tipoDocumento']."'")or die(mysqli_error());
                     $col3TipoDcumento = $nombreTipoDocumento->fetch_array(MYSQLI_ASSOC);
                     $nombreTipoDOcumentoN=$col3TipoDcumento['nombre'];
                     
                     if($nombreTipoDOcumentoN != NULL){
                        echo" <td style='text-align: justify;'>".utf8_decode($nombreTipoDOcumentoN)."</td>";
                     }else{
                        echo" <td style='text-align: justify;'>".$row['tpdG']."</td>";
                     }
                     
                     if($tiempoRespuesta == NULL){
                         echo" <td style='text-align: justify;'><b>Sin definir</b></td>";
                     }else{
                         echo" <td style='text-align: justify;'>".$contador->format($differenceFormat)."</td>";
                     }
                     
                    
                     
                    echo"</tr>";
                    } 
    ?>
    

</table>
<?php
}
?>