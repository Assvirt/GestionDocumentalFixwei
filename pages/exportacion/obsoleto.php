<?php
error_reporting(E_ERROR);
header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=ListadoObsoletos.xls');

require '../conexion/bd.php';

$idProcesoUsuario=$_POST['idProceso'];
$visibleE=$_POST['visibleE'];
$acentos = $mysqli->query("SET NAMES 'utf8'");
$result = $mysqli->query("SELECT * FROM documento WHERE obsoleto = 1 AND pre IS NULL ORDER BY codificacion ASC")or die("ERROR, comuniquese con el administrador del sistema.");

?>

<table border="1">
    <tr>
         <th><?php echo utf8_decode("Versión")?></th>
         <th><?php echo utf8_decode("Código")?></th>
         <th>Nombre</th>
         <th>Tipo</th>
         <th>Proceso</th>
         <th><?php echo utf8_decode("Ubicación")?></th>
         <th><?php echo utf8_decode("Implementación")?></th>
         <th>Descargar</th>
    </tr>
    <?php
        
        while ($row = $result->fetch_assoc()){
                    
                        /*if($row['obsoleto'] == 1){
                            continue;
                        }*/
                        
                 
                    echo"<tr>";
                     
                     echo" <td>".$row['version']."</td>";
                     echo" <td>".$row['codificacion']."</td>";
                     echo" <td>".utf8_decode($row['nombres'])."</td>";
                         $tipo = $row['tipo_documento'];
                         $acentos = $mysqli->query("SET NAMES 'utf8'");
                         $nombreTipoDocumento = $mysqli->query("SELECT * FROM tipoDocumento WHERE id ='$tipo'")or die(mysqli_error());
                         $colu = $nombreTipoDocumento->fetch_array(MYSQLI_ASSOC);
                         $nombreT = utf8_decode($colu['nombre']);
                         ////$ruta = $colu['ruta'];
                        $ruta=$row['nombreOtro'];
                     echo" <td>".$nombreT."</td>";
                     
                     $proceso =  $row['proceso'];
                     $nombreProceso = $mysqli->query("SELECT * FROM procesos WHERE id ='$proceso'")or die(mysqli_error());
                     $col3 = $nombreProceso->fetch_array(MYSQLI_ASSOC);
                     $nombreP = utf8_decode($col3['nombre']);
                     echo" <td>".$nombreP."</td>";
                     
                     if($row['ubicacion'] != NULL){
                        echo" <td>".utf8_decode($row['ubicacion'])."</td>";
                     }else{
                         echo "<td>" . '<strong>No aplica</strong>'."</td>";
                     }
                     
                    
                    echo" <td>".substr($row['fechaAprobado'],0,-8)."</td>";
                   
                    
                
                if($row['nombrePDF'] != NULL){
                    ?>
                    <td><a href="<?php echo utf8_decode("https://fixwei.com/plataforma/pages/archivos/documentos/".$row['nombrePDF']); ?>">Descargar - <?php echo utf8_decode($row['nombrePDF']); ?></a></td>
                    
                <?php
                    
                }else{
                ?>
                    <td>Creado por HTML</td>
                <?php
                }
            
                    
                    
                    echo"</tr>";
                    }
        ?>
    

</table>