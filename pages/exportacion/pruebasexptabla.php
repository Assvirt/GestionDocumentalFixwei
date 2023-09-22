<?php
header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=DatosProveedores.xls');

require '../conexion/bd.php';


$acentos = $mysqli->query("SET NAMES 'utf8'");
$data = $mysqli->query("SELECT municipios.id,municipios.nombre AS Municipio, departamentos.nombre AS Departamento FROM municipios INNER JOIN departamentos ON municipios.departamento_id = departamentos.id ORDER BY id")or die(mysqli_error());
?>
<?php
/*
<table border="1" style="float: left;">
    
    <tr>
        <th>Departamento</th>
             <?php
            while($row = $data->fetch_assoc()){
                echo"<tr>";
                            echo" <td style='text-align:justify;'>".utf8_decode($row['id']).'-'.utf8_decode($row['Departamento']).'-'.utf8_decode($row['Municipio'])."</td>";
                            
                echo "</tr>";            
            }
            ?>
    </tr>
    
</table>

<table border="1" style="float: left;">
    
    <tr>
        <th>Grupo</th>
    </tr>
    <tr>
        <?php 
            $consultaGrupo=$mysqli->query("SELECT * FROM proveedoresGrupo");
            while($colGrupo = $consultaGrupo->fetch_assoc()){
        ?>
        <td>
            <?php echo utf8_decode($colGrupo['grupo']); ?>
        </td>
    </tr>
    <?php
            }
    ?>
    <?php
    while($row = $data->fetch_assoc()){
        echo"<tr>";
                    echo" <td style='text-align:justify;'>".utf8_decode($row['id']).'-'.utf8_decode($row['Departamento']).'-'.utf8_decode($row['Municipio'])."</td>";
                    
        echo "</tr>";            
    }
    ?>
</table>

<table border="1" style="float: left;">
    
    <tr>
        <th>Criticidad</th>
    </tr>
    <tr>
        <?php 
            $consultaCriticidad=$mysqli->query("SELECT * FROM proveedoresCriticidad");
            while($colCriticidad = $consultaCriticidad->fetch_assoc()){
        ?>
        <td>
            <?php echo $colCriticidad['tipo']; ?>
        </td>
    </tr>
    <?php
            }
    ?>
    <?php
    while($row = $data->fetch_assoc()){
        echo"<tr>";
                    echo" <td style='text-align:justify;'>".utf8_decode($row['id']).'-'.utf8_decode($row['Departamento']).'-'.utf8_decode($row['Municipio'])."</td>";
                    
        echo "</tr>";            
    }
    ?>
</table>

<table border="1" style="float: left;">
    
    <tr>
        <th>Tipo de Proveedor</th>
    </tr>
    <tr>
        <?php 
            $consultaTipoProveedor=$mysqli->query("SELECT * FROM proveedoresTipo");
            while($colTipoProveedor = $consultaTipoProveedor->fetch_assoc()){
        ?>
        <td>
            <?php echo $colTipoProveedor['tipo']; ?>
        </td>
    </tr>
    <?php
            }
    ?>
    <?php
    while($row = $data->fetch_assoc()){
        echo"<tr>";
                    echo" <td style='text-align:justify;'>".utf8_decode($row['id']).'-'.utf8_decode($row['Departamento']).'-'.utf8_decode($row['Municipio'])."</td>";
                    
        echo "</tr>";            
    }
    ?>
</table>

*/

?>
<thead>
        <tr>
            <th>
                <th>
                    <th>Departamento</th>
                    <th>Grupo</th>
                    <th>Criticidad</th>
                    <th>Tipo de proveedor</th>
                </th>    
            </th>    
        </tr>
    </thead>
<table>
    
    <tbody>
        <tr>
            <th>
                <?php
                    while($row = $data->fetch_assoc()){
                           
                            echo" <tr style='text-align:justify;'>".utf8_decode($row['id']).'-'.utf8_decode($row['Departamento']).'-'.utf8_decode($row['Municipio'])."</tr>";
                                        
                        }
                    echo '<br>';
                ?>
            </th>    
        </tr>
        
        
    </tbody>
    <table>
        <tr>
            <td>
                <?php
                
                $consultaGrupo=$mysqli->query("SELECT * FROM proveedoresGrupo");
                while($row2 = $consultaGrupo->fetch_assoc()){
       
                           
                            echo" <td style='text-align:justify;'>".utf8_decode($row2['grupo'])."</td>";
                                        
                        }
                    echo '<br>';
                ?>
            </td>    
        </tr>
    </table>
        
        
  
    
    
    
    
</table>
