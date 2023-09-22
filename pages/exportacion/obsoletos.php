<?php

header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=ListadoObsoletos.xls');

require '../conexion/bd.php';


$acentos = $mysqli->query("SET NAMES 'utf8'");
$result = $mysqli->query("SELECT * FROM documento WHERE obsoleto = 1")or die("ERROR, comuniquese con el administrador del sistema.");

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
        
        while ($columna = $result->fetch_assoc()){
            
            
        
            $tipo = $columna['tipo_documento'];
                     $nombreTipoDocumento = $mysqli->query("SELECT * FROM tipoDocumento WHERE id ='$tipo'")or die(mysqli_error());
                     $colu = $nombreTipoDocumento->fetch_array(MYSQLI_ASSOC);
                     $nombreT = $colu['nombre'];
            $proceso =  $columna['proceso'];
                     $nombreProceso = $mysqli->query("SELECT * FROM procesos WHERE id ='$proceso'")or die(mysqli_error());
                     $col3 = $nombreProceso->fetch_array(MYSQLI_ASSOC);
                     $nombreP = $col3['nombre'];    

    ?>
    
        <tr>
            <td><?php echo utf8_decode($columna['version']); ?></td>
            <td><?php echo utf8_decode($columna['codificacion']); ?></td>
            <td><?php echo utf8_decode($columna['nombres']); ?></td>
            <td><?php echo utf8_decode($nombreT); ?></td>
            <td><?php echo utf8_decode($nombreP ); ?></td>
            <td><?php echo utf8_decode($columna['ubicacion']); ?></td>
            <td><?php echo utf8_decode($columna['fechaAprobado']); ?></td>
            <?php
                if($columna['nombrePDF'] != NULL){
                    ?>
                    <td><a href="<?php echo utf8_decode("https://fixwei.com/plataforma/pages/archivos/documentos/".$columna['nombrePDF']); ?>">Descargar - <?php echo utf8_decode($columna['nombrePDF']); ?></a></td>
                    
                <?php
                    
                }else{
                ?>
                    <td>Creado por HTML</td>
                <?php
                }
            ?>
            
        </tr>
        <?php
        }
        ?>
    

</table>