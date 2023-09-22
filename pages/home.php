<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
//require_once 'inactividad.php';
// verificación home
?>
<!DOCTYPE html>
<html>
    <title>Inicio</title>
<head><meta charset="utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<script>
   	
    function nobackbutton(){
    	
       window.location.hash="no-back-button";
    	
       window.location.hash="Again-No-back-button" //chrome
    	
       window.onhashchange=function(){window.location.hash="no-back-button";}
    	
    }
</script>
<body class="hold-transition sidebar-mini" onload="nobackbutton();" >
<div class="wrapper">


  <!-- Main Sidebar Container -->
  <?php echo require_once'menu.php'; ?>

 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Indicadores</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Dashboard v3</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

   <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <!-- AREA CHART -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Información documentada por tipo de documento</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="stackedBarChart" style="height:250px; min-height:250px"></canvas>
                </div>
              </div>
            
            </div>
            <!-- /.card -->

       
            

          </div>
          <!-- /.col (LEFT) -->
          <div class="col-md-6">
            <!-- LINE CHART -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Información documentada por tipo de proceso</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="stackedBarChart2" style="height:250px; min-height:250px"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            

          
           

          </div>
          <!-- /.col (RIGHT) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section> 
    <section class="content"> 
            <div class="card card-primary">
              <div class="card-body">
                <div class="chart">
                    <div class="row">
                            <?php
                                //// usamos la variable fecha para validar la fecha que tenemos del sistema con las tareas y solo nos muestre las del d��a
                                date_default_timezone_set('America/Bogota');
                                $fecha1=date('Y-m-d');
                                /// end
                                    
                                    $sql= $mysqli->query("SELECT * FROM agenda WHERE asunto='Crear reunion' OR asunto='Crear tarea' ORDER BY fecha ASC ");
                                     $conteoActasA = 0;
                		            while($row = $sql->fetch_assoc()){
                		               
                		               //// valido solo las reuniones o tareas que tengo solo el d��a de hoy
                		               if($row['fecha'] == $fecha1){
                		                   
                		               }else{
                		                   continue;
                		               }
                		               /// end
                		               
                                        $idAgenda=$row['id'];
                                        $idCreacionUsuario = $row['idUsuario'];
                                  
                                  /// se trae el id para montar los colores -->
                                        $asuntoNombre=$row['asunto'];
                                        $idColorv=$row['color'];
                                        $query = $mysqli->query("SELECT * FROM agendaEtiqueta WHERE nombre='$asuntoNombre' AND idUsuario='$sesion'  ");
                                        $colorE = $query->fetch_array(MYSQLI_ASSOC);
                                        $colorEtiqueta= $colorE['etiqueta'];
                                        $colorTitulo= $colorE['titulo'];
                                        $colorSubtitulo= $colorE['subtitulo'];
                                        
                                  /// fin del proceso -->  
                                  
                                  
                                    $tipoPersonalValidando = $row['tipoPersonal'];
        		                    $personalIDValidando =  json_decode($row['personal']);
                                    $longitudValidando = count($personalIDValidando);
                                
                                        if($tipoPersonalValidando == 'usuario'){
                                            
                                            for($i=0; $i<$longitudValidando; $i++){
                                                
                                                $nombreActas = $mysqli->query("SELECT nombres, apellidos,cedula FROM usuario WHERE id = '$personalIDValidando[$i]' AND cedula='$sesion' ");
                                                $columnaValidando = $nombreActas->fetch_array(MYSQLI_ASSOC);
                                                //echo $cedulaGuardaro=$columnaValidando['cedula'];
                                                
                                                $cn = mysqli_num_rows($nombreActas);
                                                
                                                if($cn > 0){
                                                $conteoActasA++;  
                                                $asunto=$row['asunto']; 
                                                if($asunto == 'Crear reunion'){ $agenda='Reunión'; }else{ $agenda='Tarea'; } 
                                                $tematica=$row['descripcion']; 
                                                $sitioReunion=$row['sitio'];
                                                 
                                                 echo '<div class="col-md-3 col-sm-6 col-12">
                                                        <div class="info-box bg-warning">
                                                            <span class="info-box-icon"><i class="far fa-calendar-alt"></i></span>
                                                                <div class="info-box-content">'; 
                                                 echo '             <span class="info-box-number">'.$agenda.'</span>
                                                                    <font size="2px">'.$row['tematica'].'<br>Sitio: '.$sitioReunion.'</font>
                                                                    <span class="info-box-text">';
                                                                                echo $fecha=$row['fecha'].' '.$fecha=$row['hora'].'
                                                                    </span>
                                                                </div>
                                                        </div>
                                                        </div>';
                                                
                                                }
                                                
                                            } //// cierre del for
                                        } //// cierre del if
                                  
                                        if($tipoPersonalValidando == 'cargo'){
                                                    
                                                    for($i=0; $i<$longitudValidando; $i++){
                                                        
                                                        $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalIDValidando[$i]' 
                                                        AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo ");
                                                        $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                                        //echo $columna['nombreCargos'];
                                                        
                                                        $cn = mysqli_num_rows($nombrecargo);
                                                        
                                                        if($cn > 0){
                                                        $conteoActasA++;
                                                        $asunto=$row['asunto']; 
                                                        if($asunto == 'Crear reunion'){ $agenda='Reunión'; }else{ $agenda='Tarea'; } 
                                                        $tematica=$row['descripcion']; 
                                                        $sitioReunion=$row['sitio'];
                                                        
                                                                echo '<div class="col-md-3 col-sm-6 col-12">
                                                                <div class="info-box bg-warning">
                                                                    <span class="info-box-icon"><i class="far fa-calendar-alt"></i></span>
                                                                        <div class="info-box-content">'; 
                                                         echo '             <span class="info-box-number">'.$agenda.'</span>
                                                                            <font size="2px">'.$row['tematica'].'<br>Sitio: '.$sitioReunion.'</font>
                                                                            <span class="info-box-text">';
                                                                                        echo $fecha=$row['fecha'].' '.$fecha=$row['hora'].'
                                                                            </span>
                                                                        </div>
                                                                </div>
                                                                </div>';
                                                        
                                                        }
                                                        
                                                    } //// cierre del for
                                                } //// cierre del if
                                 
                		            
                		            }
                                    
                                    
                                ?>
                                </div>
                </div>
              </div>
            </div>
    </section> 
  </div>
  <!-- /.content-wrapper -->

<?php 
    echo require_once'footer.php';     
?>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>


<!-- OPTIONAL SCRIPTS -->
<script src="../plugins/chart.js/Chart.min.js"></script>

<script>
                        
  $(function () {
 
  var areaChartCanvas = $('#stackedBarChart').get(0).getContext('2d')

    var areaChartData = {
      labels  : [<?php $consultarParaGraficar=$mysqli->query("SELECT COUNT(*) AS contadorGrafica, documento.pre, documento.tipo_documento, tipoDocumento.id, tipoDocumento.nombre as nombre FROM documento INNER JOIN tipoDocumento WHERE documento.pre IS NULL AND documento.vigente = 1 AND documento.tipo_documento = tipoDocumento.id GROUP BY documento.tipo_documento  ");
                        while($imprimirGrafica=$consultarParaGraficar->fetch_array()){
                            $nombreVariable=$imprimirGrafica["nombre"];
                            echo " '$nombreVariable', ";
                            
                        } ?>],
      datasets: [
        {
          label               : '',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
           data:[<?php $consultarParaGraficar=$mysqli->query("SELECT COUNT(*) AS contadorGrafica, documento.pre, documento.tipo_documento, tipoDocumento.id, tipoDocumento.nombre as nombre FROM documento INNER JOIN tipoDocumento WHERE documento.pre IS NULL AND documento.vigente = 1 AND documento.tipo_documento = tipoDocumento.id GROUP BY documento.tipo_documento  ");
                        while($imprimirGrafica=$consultarParaGraficar->fetch_array()){
                            $nombreVariable=$imprimirGrafica["contadorGrafica"];
                            echo " '$nombreVariable', ";
                            
                        } ?>,<?php 
                        $contandoTipoDocumento=$mysqli->query("SELECT COUNT(*) FROM `tipoDocumento` ");
                        $exatryendoTotalesTipoDocumento=$contandoTipoDocumento->fetch_array(MYSQLI_ASSOC);
                        $totalesExistentesTipoDocumento=$exatryendoTotalesTipoDocumento["COUNT(*)"];
                        echo  " '$totalesExistentesTipoDocumento' ";  
                        ?>] /// Totales de los procesos tipo de documentos existentes
        },
      ]
    }

    var areaChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          },
          ticks:{  // mostrar los datos enteros del medidor costado izquierdo de la gráfica
              beginAtZero:true
          }
        }]
      }
    }

    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(areaChartCanvas, { 
      type: 'bar',
      data: areaChartData, 
      options: areaChartOptions
    })
    
    
  })
  
  
  
  $(function () {
 
  var areaChartCanvas = $('#stackedBarChart2').get(0).getContext('2d')

    var areaChartData = {
      labels  : [<?php $consultarParaGraficarProcesos=$mysqli->query("SELECT COUNT(*) AS contadorGraficaProcesos, documento.pre, documento.proceso, procesos.id, procesos.nombre as nombreProcesos FROM documento INNER JOIN procesos WHERE  documento.pre IS NULL AND documento.vigente = 1 AND documento.proceso = procesos.id GROUP BY documento.proceso  ");
                        while($imprimirProcesos=$consultarParaGraficarProcesos->fetch_array()){
                           $nombreVariableProcesos=$imprimirProcesos["nombreProcesos"];
                           echo " '$nombreVariableProcesos', ";
                        } ?>],
      datasets: [
        {
          label               : '',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
           data:[<?php $consultarParaGraficarProcesos=$mysqli->query("SELECT COUNT(*) AS contadorGraficaProcesos, documento.pre, documento.proceso, procesos.id, procesos.nombre as nombreProcesos FROM documento INNER JOIN procesos WHERE  documento.pre IS NULL AND documento.vigente = 1 AND documento.proceso = procesos.id GROUP BY documento.proceso  ");
                        while($imprimirProcesos=$consultarParaGraficarProcesos->fetch_array()){
                           $nombreVariableProcesos=$imprimirProcesos["contadorGraficaProcesos"];
                           echo " '$nombreVariableProcesos', ";
                        } ?>,<?php 
                              $contandoProcesos=$mysqli->query("SELECT COUNT(*) FROM `procesos` ");
                              $exatryendoTotalesProcesos=$contandoProcesos->fetch_array(MYSQLI_ASSOC);
                              $totalesExistentesProcesos=$exatryendoTotalesProcesos["COUNT(*)"];
                              echo  " '$totalesExistentesProcesos' ";  
                        ?>]   /// Totales de los procesos existentes
        },
      ]
    }

    var areaChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          },
          ticks:{  // mostrar los datos enteros del medidor costado izquierdo de la gráfica
              beginAtZero:true
          }
        }]
      }
    }

    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(areaChartCanvas, { 
      type: 'bar',
      data: areaChartData, 
      options: areaChartOptions
    })
    
    
  })
</script>

<script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5dbb699c154bf74666b6f35b/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
</body>
</html>
<?php
}
?>