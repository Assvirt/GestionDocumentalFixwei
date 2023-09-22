<?php
header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=DatosProveedor.xls');

require '../conexion/bd.php';

//////////// Consultas en las tablas de municipios y proveedores
$acentos = $mysqli->query("SET NAMES 'utf8'");
$data = $mysqli->query("SELECT municipios.id,municipios.nombre AS Municipio, departamentos.nombre AS Departamento FROM municipios INNER JOIN departamentos ON municipios.departamento_id = departamentos.id ORDER BY id")or die(mysqli_error());
$dataGrupos = $mysqli->query("SELECT * FROM proveedoresGrupo");
$dataCriticidad = $mysqli->query("SELECT * FROM `proveedoresCriticidad`");
$dataTipoProveedor=$mysqli->query("SELECT * FROM `proveedoresTipo`");

/////END
?>


<!----  Encabezados de la tabla ---->
<table border="1">
    
    <tr>
        <th>Departamento</th>
        <th>Grupo</th>
        <th>Criticidad</th>
        <th>Tipo de Proveedor</th>
    </tr>
    
<!--END-->    
    
    <?php
    ///////////////////////////// Datos de los municipios y departamentos
        while($row = $data->fetch_assoc()){
            echo"<tr>";
            echo" <td style='text-align:justify;'>".utf8_decode($row['id']).'-'.$row['Departamento'].'-'.$row['Municipio']."</td>";
        }
            echo "</tr>";
    /////END        
    ?>
    
    <?php
    ///////////////////////////// Datos de los grupos de proveedores
        echo "<tr>";
            while($row2 = $dataGrupos->fetch_assoc()){
                echo"<tr>";
                     echo "<td>".$row2['grupo']."</td>";
                echo "</tr>";     
            }
        echo "</tr>";
    /////END    
    ?>

    <?php
    ///////////////////////////// Datos de los tipos de criticidad de proveedores
        while($row3 = $dataCriticidad->fetch_assoc()){
            echo"<tr>";
                 echo "<td>".$row3['tipo']."</td>";
            echo "</tr>";     
        }
    /////END    
    ?>

    <?php
    ///////////////////////////// Datos de los grupos de los tipos de proveedores
        while($row4 = $dataTipoProveedor->fetch_assoc()){
            echo"<tr>";
                 echo "<td>".$row4['tipo']."</td>";
            echo "</tr>";     
        }
    ///////END    
    ?>


</table>



