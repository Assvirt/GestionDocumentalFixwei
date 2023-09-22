<html>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>-->
    <body>
        <div>
            <h4>Cambiar colores</h4>
            <form action="" method="POST">
                <label>Título principal</label>
                <input name="tituloPrincipal" type="text" placeholder="Título principal">
                <br><br>
                <label>Color 1</label>
                <input name="color1" type="color"><br>
                <label>Color 2</label>
                <input name="color2" type="color"><br>
                <label>Color 3</label>
                <input name="color3" type="color">
                <br><br>
                <label>Título 1</label>
                <input name="titulo1" type="text" placeholder="Título 1">
                <label>Título 2</label>
                <input name="titulo2" type="text" placeholder="Título 2">
                <label>Título 3</label>
                <input name="titulo3" type="text" placeholder="Título 3">
                <br><br>
                <label>Datos 1</label>
                <input name="dato1" type="number" placeholder="Datos 1">
                <label>Datos 2</label>
                <input name="dato2" type="number" placeholder="Datos 2">
                <label>Datos 3</label>
                <input name="dato3" type="number" placeholder="Datos 3">
                <br>
                <input type="submit" value="Ingresar Datos">
            </form>
            <?php
            ////// titulo principal
            $tituloPrincipal=$_POST['tituloPrincipal'];
            ////// colores
            $color1=$_POST['color1'];
            $color2=$_POST['color2'];
            $color3=$_POST['color3'];
            ///// titulos
            $titulo1=$_POST['titulo1'];
            $titulo2=$_POST['titulo2'];
            $titulo3=$_POST['titulo3'];
            ///// datos
            $datos1=$_POST['dato1'];
            $datos2=$_POST['dato2'];
            $datos3=$_POST['dato3'];
            ?>
        </div>
        <div style="width:30%;float:left; margin: 5px 20px 0 10px;">
            <h4>Ejemplo indicadores tipo barra</h4>
            <canvas id="myChartBarra"></canvas>
        </div>
        <div style="width:30%;float:right; margin: 5px 20px 0 10px;">
            <h4>Ejemplo indicadores tipo torta</h4>
            <canvas id="myChartTorta"></canvas>
        </div>
        <div style="width:30%;float:left; margin: 5px 20px 0 10px;">
            <h4>Ejemplo indicadores tipo lineal</h4>
    		<canvas id="myChartLine"></canvas>
    	</div>
    	<div style="width:30%;float:right; margin: 5px 20px 0 10px;">
            <h4>Ejemplo indicadores tipo Radar</h4>
    		<canvas id="myChartRadar"></canvas>
    	</div>
    	<div style="width:30%;">
            <h4>Ejemplo indicadores tipo Dona</h4>
    		<canvas id="myChartDona"></canvas>
    	</div>
    	
    </body>
    <script> /*Grafica tipo barra*/
        var ctx = document.getElementById("myChartBarra").getContext("2d");
        var myChart = new Chart(ctx, {
            type:"bar",
            data:{
                labels:['<?php echo $titulo1; ?>','<?php echo $titulo2; ?>','<?php echo $titulo3; ?>'], /*dibuja las columnas*/
                datasets:[{
                    label:'<?php echo $tituloPrincipal; ?>', /*titulo principal*/
                    data:[<?php echo $datos1; ?>,<?php echo $datos2; ?>,<?php echo $datos3; ?>],  /*imprime los datos o variables a imprimir en las columnas*/
                    backgroundColor:[ /*Colores para la grafica, se puede mandar variable de color programado*/
                            '<?php echo $color1; ?>',
                            '<?php echo $color2; ?>',
                            '<?php echo $color3; ?>'
                        ]
                }]
            },
            options:{
                scales:{
                    yAxes:[{
                        ticks:{
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    </script>
    <script> /*Grafica tipo torta*/
        var ctx = document.getElementById("myChartTorta").getContext("2d");
        var myChart = new Chart(ctx, {
            type:"pie",
            data:{
                labels:['<?php echo $titulo1; ?>','<?php echo $titulo2; ?>','<?php echo $titulo3; ?>'], /*dibuja las columnas*/
                datasets:[{
                    label:'<?php echo $tituloPrincipal; ?>', /*titulo principal*/
                    data:[<?php echo $datos1; ?>,<?php echo $datos2; ?>,<?php echo $datos3; ?>],  /*imprime los datos o variables a imprimir en las columnas*/
                    backgroundColor:[ /*Colores para la grafica, se puede mandar variable de color programado*/
                            '<?php echo $color1; ?>',
                            '<?php echo $color2; ?>',
                            '<?php echo $color3; ?>'
                        ]
                }]
            },
            options:{
                scales:{
                    yAxes:[{
                        ticks:{
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    </script>
    <script> /*Grafica tipo torta*/
        var ctx = document.getElementById("myChartLine").getContext("2d");
        var myChart = new Chart(ctx, {
            type:"line",
            data:{
                labels:['<?php echo $titulo1; ?>','<?php echo $titulo2; ?>','<?php echo $titulo3; ?>'], /*dibuja las columnas*/
                datasets:[{
                    label:'<?php echo $tituloPrincipal; ?>', /*titulo principal*/
                    data:[<?php echo $datos1; ?>,<?php echo $datos2; ?>,<?php echo $datos3; ?>],  /*imprime los datos o variables a imprimir en las columnas*/
                    backgroundColor:[ /*Colores para la grafica, se puede mandar variable de color programado*/
                            '<?php echo $color1; ?>',
                            '<?php echo $color2; ?>',
                            '<?php echo $color3; ?>'
                        ]
                }]
            },
            options:{
                scales:{
                    yAxes:[{
                        ticks:{
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    </script>
    <script> /*Grafica tipo torta*/
        var ctx = document.getElementById("myChartRadar").getContext("2d");
        var myChart = new Chart(ctx, {
            type:"radar",
            data:{
                labels:['<?php echo $titulo1; ?>','<?php echo $titulo2; ?>','<?php echo $titulo3; ?>'], /*dibuja las columnas*/
                datasets:[{
                    label:'<?php echo $tituloPrincipal; ?>', /*titulo principal*/
                    data:[<?php echo $datos1; ?>,<?php echo $datos2; ?>,<?php echo $datos3; ?>],  /*imprime los datos o variables a imprimir en las columnas*/
                    backgroundColor:[ /*Colores para la grafica, se puede mandar variable de color programado*/
                            '<?php echo $color1; ?>',
                            '<?php echo $color2; ?>',
                            '<?php echo $color3; ?>'
                        ]
                }]
            },
            options:{
                scales:{
                    yAxes:[{
                        ticks:{
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    </script>
    <script> /*Grafica tipo torta*/
        var ctx = document.getElementById("myChartDona").getContext("2d");
        var myChart = new Chart(ctx, {
            type:"doughnut",
            data:{
                labels:['<?php echo $titulo1; ?>','<?php echo $titulo2; ?>','<?php echo $titulo3; ?>'], /*dibuja las columnas*/
                datasets:[{
                    label:'<?php echo $tituloPrincipal; ?>', /*titulo principal*/
                    data:[<?php echo $datos1; ?>,<?php echo $datos2; ?>,<?php echo $datos3; ?>],  /*imprime los datos o variables a imprimir en las columnas*/
                    backgroundColor:[ /*Colores para la grafica, se puede mandar variable de color programado*/
                            '<?php echo $color1; ?>',
                            '<?php echo $color2; ?>',
                            '<?php echo $color3; ?>'
                        ]
                }]
            },
            options:{
                scales:{
                    yAxes:[{
                        ticks:{
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    </script>
   
</html>