<center> <h4>F&oacute;rmula</h4></center>
 
<?php /*
error_reporting(E_ERROR);
require_once 'conexion/bd.php';


if(isset($_POST['guardar'])){
    
$idVariable=$_POST['idVariable'];
$idIndicador=$_POST['idIndicador'];
$operacion=$_POST['operacion'];
$variable=$_POST['variable'];

if($operacion != NULL){
    $guardarOperacion=$operacion;
}

if($variable != NULL){
    $guardarOperacion=$variable;
}

$mysqli->query("INSERT INTO IndicadoresFormula (idVariable,idIndicador,parteFormula) VALUES('1','1','$guardarOperacion') ")or die(mysqli_error($mysqli));

}
?>
 
 <form action="" method="POST">
                            <select name="operacion">
                                <option value="">Signo...</option>
                                <option value="+">+</option>
                                <option value="-">-</option>
                                <option value="*">*</option>
                                <option value="/">/</option>
                                <option value="(">(</option>
                                <option value=")">)</option>
                            </select>
                            <br><br>
                            <input placeholder="variable aplicar" type="text" name="variable" > 
                            <br><br>
                            <input type="submit" value="Agregar" name="guardar">
                       
</form>


Llenar f&oacute;rmula<br><br>

<?php
///require_once 'conexion/bd.php';
$consultarFormula=$mysqli->query("SELECT * FROM IndicadoresFormula ORDER BY id");
while($traerFormula=$consultarFormula->fetch_array()){


echo $traerFormula['parteFormula'].' ';

}
?>

<form action="" method="POST">
<?php
///require_once 'conexion/bd.php';
$consultarFormula=$mysqli->query("SELECT * FROM IndicadoresFormula ORDER BY id");
$conteo='1';
while($traerFormula=$consultarFormula->fetch_array()){

/// validamos si es una variable para montar un n��mero, pero en este caso colocaremos n��meros
    if($traerFormula['parteFormula'] == '+' || $traerFormula['parteFormula'] == '-' || $traerFormula['parteFormula'] == '*' || $traerFormula['parteFormula'] == '/' ){
        
    ?>
    <input name="dato<?php echo $conteo++; ?>" placeholder="S&iacute;mbolo" value="<?php echo $traerFormula['parteFormula']; ?>" readonly required>
    <?php
    }else{
    ?>
    <input name="dato<?php echo $conteo++; ?>" type="number" min="0" placeholder="<?php echo $traerFormula['parteFormula']; ?>" value="" required>
    <?php
    }
/// END
}
?>
<input type="submit" value="calcular indicador" name="calculoIndicador">
</form>
<br><br>
Mostrar calculo de la formula:<br><br>
<?php
if(isset($_POST['calculoIndicador'])){
    
    echo $dato1=$_POST['dato1'];
    echo ' '.$dato2=$_POST['dato2'];
    echo ' '.$dato3=$_POST['dato3'];
    echo ' '.$dato4=$_POST['dato4'];
    echo ' '.$dato5=$_POST['dato5'];
    echo '<br><br>';
     
    echo 'Resultado= <br>';
    
    if($dato2 != NULL || $dato2 != NULL || $dato2 != NULL || $dato2 != NULL ){
        if($dato2 == '+'){
            echo $resultadoFormula=$dato1+$dato3;
        }
        if($dato2 == '-'){
            echo $resultadoFormula=$dato1-$dato3;
        }
        if($dato2 == '*' && $dato4 <> '+'){
            echo $resultadoFormula=$dato1*$dato3;
        }
        if($dato2 == '/'){
            echo $resultadoFormula=$dato1/$dato3;
        }
    }
    
    
    if($dato4 == '+'){
            echo $resultadoFormula=$dato1*$dato3+$dato5;
    }
    
    
}

?>
<form action="" method="POST">
    <input type="submit" name="limpiar" value="Limpiar formula">
</form>
<?php

if(isset($_POST['limpiar'])){
    $mysqli->query("DELETE FROM IndicadoresFormula");
    header("Location: pruebaFormula");
}
*/
error_reporting(E_ERROR);
echo 'Fórmula a presentar: '.$formula='70*(50/25)+100';
echo '<br>';
echo '<form method="POST" action="">';
echo 'Fórmula aplicada para operación opción A: 70*(50/<input type="number" min="0" style="width:50px;">)+100';
echo '<br>';
echo 'Fórmula aplicada para operación opción B: <input type="text" name="simulacionCalculo" min="0" value="70*(50/VA)+100">';
echo '<br><br>';
echo '<button type="submit">Calcular</button>';
echo '</form>';
echo '<br><br>';

echo 'Ejemplo para calculo: '.$formula;
echo '<br><br>';
echo 'Símulación de datos '.$_POST['simulacionCalculo'].' resultado: '.intval($_POST['simulacionCalculo']);
echo '<br><br>';

echo 'Resultado: '.$formulaAplicada=intval(70*(50/25)+100);

//$mul = gmp_mul("12345678","2000");
//echo gmp_strval($mul)."\n";
?>
