<?php
require_once '../conexion/bd.php';

?>


<html>
    <head>
    Prueba Importacion
    </head>
    
    <body>
        <form action="" method="post"
            name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
            <div>
                <label>Cargar Excel
                <br>
                    </label> <input type="file" name="file" id="file" accept=".xls,.xlsx">
                    <button type="submit" id="submit" name="import"
                    class="btn-submit">Importar</button>
        
            </div>
          </div>
    <div id="response" class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>"><?php if(!empty($message)) { echo $message; } ?></div>
    
         
<?php
    $sqlSelect = "SELECT * FROM tabla";
    $result = mysqli_query($mysqli, $sqlSelect);

if (mysqli_num_rows($result) > 0)
{
?>
        
    <table class='tutorial-table'>
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>

            </tr>
        </thead>
<?php
    while ($row = mysqli_fetch_array($result)) {
?>                  
        <tbody>
        <tr>
            <td><?php  echo $row['nombre']; ?></td>
            <td><?php  echo $row['descripcion']; ?></td>
        </tr>
<?php
    }
?>
        </tbody>
    </table>
<?php 
} 
?>
        </form>
    </body>
</html>





<?php





?>