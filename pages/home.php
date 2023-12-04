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
              <?php // traemos le nombre del usuario o caso contrario el del administrador
              	$acentos = $mysqli->query("SET NAMES 'utf8'");
        		$sqlPerfil= $mysqli->query("SELECT nombres,apellidos,cedula FROM usuario WHERE cedula = '".$_SESSION["session_username"]."'");
        		$rowPerfil = $sqlPerfil->fetch_array(MYSQLI_ASSOC);
        		$nombres = $rowPerfil['nombres'];
        		$apellidos = $rowPerfil['apellidos'];
        	  ?>
              <li class="breadcrumb-item active">
                  <?php
                  if($root == 1){ 
                    echo 'Administrador del sistema';
                  }else{
                    echo $nombres." ".$apellidos;   
                  }
                  ?>
              </li>
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



<!-- Validación para envio de notificacion de correos-->
<?php
                    require 'controlador/usuarios/libreria/PHPMailerAutoload.php';
                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                    $data = $mysqli->query("SELECT * FROM documento WHERE vigente = 1 AND pre IS NULL ORDER BY codificacion ASC")or die(mysqli_error());
                    //SELECT * FROM documento WHERE vigente = 1 AND revisado = 0 AND pre IS NULL ORDER BY codificacion ASC
                    while($row = $data->fetch_assoc()){
                        
                        /// parametro de prueba de correo
                        //if($row['id'] == '157'){
                            
                        //}else{
                        //    continue;
                        //}
                        
                         
                        $idProceso2 = $row['proceso'];
                        
                        
                        $dataSol = $mysqli->query("SELECT * FROM procesos WHERE id = '$idProceso2'")or die(mysqli_error());
                        $datosSol = $dataSol->fetch_assoc();
                        $encargadoSolicitud = json_decode($datosSol['duenoProceso']);
                        $longitud = count($encargadoSolicitud);
                        
                         if($datosSol['importacion'] == 1){
                            for($i=0; $i<$longitud; $i++){ 
                                //saco el valor de cada elemento
                                $queryNombres = $mysqli->query("SELECT * FROM cargos WHERE nombreCargos LIKE '%$encargadoSolicitud[$i]%' ");
                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                
                                $encargadoSolicitud=$nombres['id_cargos'];
                                // echo '<td>S'.$encargadoSolicitud.'</td>';
                            
                            }
                         }else{
                            for($i=0; $i<$longitud; $i++){ 
                                //saco el valor de cada elemento
                                $queryNombres = $mysqli->query("SELECT * FROM cargos WHERE id_cargos LIKE '%$encargadoSolicitud[$i]%' ");
                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                
                                $encargadoSolicitud=$nombres['id_cargos'];
                                // echo '<td>N'.$encargadoSolicitud.'</td>';
                            
                            } 
                         }
                        //print_r($encargadoSolicitud);
                        
                        
                        
                        if($cargo == $encargadoSolicitud){ 
                           
                        }else{
                            //continue;
                        }
                       
                        
                        $mesesRevision = $row['mesesRevision'];
                        
                        if($row['ultimaFechaRevision'] == NULL){
                            
                            $fechaAprobado = date("d-m-Y", strtotime($row['fechaAprobado']));
                            /*Calculo fecha de revision*/
                            $fechaRevisar = date("d-m-Y",strtotime($fechaAprobado."+ $mesesRevision month"));
                            
                        }else{
                            $fechaUltimaRevision = $row['ultimaFechaRevision'];
                            
                            $fechaRevisar = date("d-m-Y",strtotime($fechaUltimaRevision."+ $mesesRevision month"));
                        }
                        
                       
                        
                         "<tr>";    
                       
                         " <td style='text-align: justify;'>".$row['version']."</td>";
                         " <td style='text-align: justify;'>".$row['codificacion']."</td>";
                         " <td style='text-align: justify;'>".$row['nombres']."</td>";
                         
                         $tipo = $row['tipo_documento'];
                         $acentos = $mysqli->query("SET NAMES 'utf8'");
                         $nombreTipoDocumento = $mysqli->query("SELECT * FROM tipoDocumento WHERE id ='$tipo'")or die(mysqli_error());
                         $colu = $nombreTipoDocumento->fetch_array(MYSQLI_ASSOC);
                         $nombreT = $colu['nombre'];
                         
                         " <td style='text-align: justify;'>".$nombreT."</td>";
                         
                         $proceso =  $row['proceso'];
                         $acentos = $mysqli->query("SET NAMES 'utf8'");
                         $nombreProceso = $mysqli->query("SELECT * FROM procesos WHERE id ='$proceso'")or die(mysqli_error());
                         $col3 = $nombreProceso->fetch_array(MYSQLI_ASSOC);
                         $nombreP = $col3['nombre'];
                         
                         " <td style='text-align: justify;'>".$nombreP."</td>";
                         
                         " <td style='text-align: justify;'>".substr($row['fechaAprobado'],0,-8)."</td>"; //$row['fechaAprobado']
                          
                          date_default_timezone_set("America/Bogota");
                             'Fecha inicial: '.$fechainicial = substr($row['fechaAprobado'],0,-8);
                             '<br>Fecha actual: '.$fechaactual = date("Y-m-d");
                            
                                           
                                          
                             '<br>Meses: '.$preguntandoMeses=$row['mesesRevision'];
                            if($preguntandoMeses == 1){
                                 $tiempoRespuesta ='30';//$row['tiempoRespuesta'];
                            }else{
                                 $tiempoRespuesta =30*$row['mesesRevision'];//$row['tiempoRespuesta'];
                            }
                           
                             '<br>Cantidad días: '.$tiempoRespuesta;
                            
                              '<br>Fecha validar: '.$fechaRestar = date("Y-m-d",strtotime($fechainicial."+ ".$tiempoRespuesta." days")); 
                            
                         "<td style='text-align: justify;' >".$fechaRestar."</td>"; // $fechaRevisar --$mesesRevision    
                         
                        $idDocumento=$row['id'];
                        $validarActualizacion=$mysqli->query("SELECT * FROM `solicitudDocumentos` WHERE tipoSolicitud=2 AND proceso='$idProceso2' AND tipoDocumento='$tipo' AND nombreDocumento='$idDocumento' AND estado IS NULL");
                        $extraer_validarActualizacion=$validarActualizacion->fetch_array(MYSQLI_ASSOC);
                        
                         "<td style='text-align: justify;' >";
                        
                             $preguntandoMeses; //.'<br>Cantidad de días '.$tiempoRespuesta;
                        
                         "</td>";
                        
                        if($extraer_validarActualizacion['id'] != NULL){
                            "<td style='text-align: justify;' >En revisión</td>";
                        }else{
                            
                            $preguntaDocumento=$mysqli->query("SELECT id,vigente,revisado FROM documento WHERE id='$idDocumento' ");
                            $respuestaDocumento=$preguntaDocumento->fetch_array(MYSQLI_ASSOC);
                            '<br>vigente: '.$respuestaDocumento['vigente'];
                            '<br>revisado: '.$respuestaDocumento['revisado'];
                            if($respuestaDocumento['vigente'] == '1' && $respuestaDocumento['revisado'] == '1'){
                                "<td style='text-align: justify;' >En revisión</td>";
                            }else{
                                "<td style='text-align: justify;' ></td>";
                            }
                            
                        }
                         
                         
                         "<td>";
                                "<form action='revisarDocumento' method='POST'>";
                                        "<input type='hidden' name='idDocumento' value='".$row['id']."'>";
                                        "<input type='hidden' name='idSolicitud' value='".$row['id_solicitud']."'>";
                                        "<button type='submit' class='btn btn-block btn-warning btn-sm'><i class='fas fa-eye'></i> Trazabilidad</button>";
                                    
                                "</form>";
                         "</td>";  
                          
                          
                          
                          '<td>';
                           
                            // se traslada la validación un poco más arriba para llevar la fecha correcta
                            
                                        /// atrapamos el filtro de la fecha, desde hasta
                                           $datetime1 = new DateTime($fechainicial);
                                           $datetime2 = new DateTime($fechaRestar); //$indicadorHasta
                                           // END
                                           
                                           // sacamos el intervalo para la diferencia entre meses
                                           $interval = date_diff($datetime1, $datetime2);
                                            '<br>Diferencia entre meses: '.$enviarIntervalo=$interval->format('%m months');
                                           
                                          
                            
                            
                            $datetime1 = date_create($fechaRestar);
                            $datetime2 = date_create($fechaactual);
                            $contador = date_diff($datetime1, $datetime2);
                            $differenceFormat = '%a';
                            
                            
                             '<br>Contador: '.$contadorDíasNotificacion=$contador->format($differenceFormat);
                            $contadorDíasNotificacion=ABS($contadorDíasNotificacion-1);
                            //if($fechaRestar > $fechaactual){
                            
                            if($contadorDíasNotificacion > '30' ){
                                 '<br>Sin avisar<br>';
                                //echo $contador->format($differenceFormat);
                            }else{   '<br>Avisar';
                                 $row['id'];
                                
                                //// preguntamos si debe enviar correo o no
                                $preguntandoCorreo=$mysqli->query("SELECT * FROM documento WHERE id='".$row['id']."' ");
                                $traerPreguntaCorreo=$preguntandoCorreo->fetch_array(MYSQLI_ASSOC);
                                
                                if($traerPreguntaCorreo['revisionDocumentalCorreo'] == 1){
                                    
                                }else{
                                    ///// bloqueamos el envio de correo despues del primer aviso
                                    $mysqli->query("UPDATE documento SET revisionDocumentalCorreo='1' WHERE id ='".$row['id']."' ");
                                    //// end
                                         '<br>Debe avisar<br>';
                                    $consultamosSolicitud=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE id='".$row['id_solicitud']."' ");
                                    $extraerSolicitudConsultaConsultamosSolicitud=$consultamosSolicitud->fetch_array(MYSQLI_ASSOC);
                                    $tipoSolicitud=$extraerSolicitudConsultaConsultamosSolicitud['tipoSolicitud'];
                                      
                                    /// consultamos el proceso para sacar los lideres de procesos y notificarlos
                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                        $consultamosProceso=$mysqli->query("SELECT * FROM procesos WHERE id='$proceso' ");
                                        $extraerConsultaProceso=$consultamosProceso->fetch_array(MYSQLI_ASSOC);
                                            //// vamos a imprimir el dueño de proceso
                                            $array = json_decode(($extraerConsultaProceso['duenoProceso']));
                                            //var_dump($array);
                                            $longitud = count($array);
                                           
                                            if($extraerConsultaProceso['importacion'] == 1 ){ 
                                                 'entra al A';
                                                for($i=0; $i<$longitud; $i++){
                                                        //saco el valor de cada elemento
                                                         'Dato: '.$array[$i];  '<br>';
                                                           
                                                        $queryNombresCargos = $mysqli->query("SELECT * FROM cargos WHERE nombreCargos = '$array[$i]' ");
                                                        $nombresCargos = $queryNombresCargos->fetch_array(MYSQLI_ASSOC); 
                                                            
                                                        "*".$nombresCargos['id_cargos']."<br><br>";
                                                        	
                                                        if($nombresCargos['id_cargos'] != NULL){
                                                        	   '<br>Debe avisar A';
                                                        	
                                                        	$extraerUsuarios = $mysqli->query("SELECT * FROM usuario WHERE cargo ='".$nombresCargos['id_cargos']."' ")or die(mysqli_error());
                                                            while($usuariosCargo = $extraerUsuarios->fetch_array()){
                                                            '<br>EL USUARIO: <b>'.$nombredelUsuario=($usuariosCargo['nombres'].' '.$usuariosCargo['apellidos']);
                                                            '<br> tiene el id cargo: '.$usuariosCargo['cargo'].'</b>';
                                                            $consultaCedula=$usuariosCargo['cedula'];
                                                             '<br>A:'.$correoNotificar=$usuariosCargo['correo'];
                                                            
                                                
    
                                                                      $mail = new PHPMailer();
                                                                      $mail->IsSMTP();
                                                                      
                                                                     
                                                                      require 'correoEnviar/contenido.php';
                                                                     
                                                                      //Agregar destinatario
                                                                      $mail->isHTML(true);
                                                                      $mail->AddAddress($correoNotificar);
                                                                       '-Enviar: '.$correoNotificar;
                                                                      /// end
                                                                  
                                                                      $nombreDocumentoEnviarCorreo=$row['nombres'];//$_POST['nombreDocumento'];
                                                                      
                                                          
                                                                      if($tipoSolicitud == '1'){
                                                                          $tipoSolicitudNombre='creación';
                                                                      }
                                                                      if($tipoSolicitud == '2'){
                                                                          $tipoSolicitudNombre='actualización';
                                                                      }
                                                                      if($tipoSolicitud == '3'){
                                                                          $tipoSolicitudNombre='eliminación';
                                                                      }
                                                          
                                                                      $mail->Subject=utf8_decode('Revisión documental - dueño de proceso'); // - autorizado para visualizar
                                                                      $mail->Body = utf8_decode('
                                                                      <html>
                                                                      <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                                                      <title>HTML</title>
                                                                      </head>
                                                                      <body>
                                                                      <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                                                                      
                                                                      <p>Estimado (a). <b><em>'.$nombredelUsuario.'</em></b>.
                                                                      <br>
                                                                      <p><b>El documento '.$nombreDocumentoEnviarCorreo.' se encuentra dentro del periodo de revisión</b></p>
                                                                      
                                                                     
                                                                      <br><br>
                                                                      Este correo es informativo por tanto, le pedimos no responda este mensaje.
                                                                      </p>
                                                                      </body>
                                                                      </html>
                                                                      ');
                                                                 
                                                                      if ($mail->Send()) {
                                                                          //echo'<script type="text/javascript">
                                                                          //    alert("Enviado Correctamente");
                                                                          //    </script>';
                                                                          
                                                                      } else {
                                                                          //echo'<script type="text/javascript">
                                                                          //    alert("NO ENVIADO, intentar de nuevo");
                                                                          //    </script>';
                                                                      }
                                                                      $mail->ClearAddresses();  
                                                                      
                                                                      //// end        
                                                            }
                                                        }
                                                                    
                                                                     
                                                                    
                                                            
                                                }
                                            }else{
                                                 
                                                 'entra al A';
                                                for($i=0; $i<$longitud; $i++){
                                                        //saco el valor de cada elemento
                                                         'Dato: '.$array[$i];  '<br>';
                                                           
                                                        $queryNombresCargos = $mysqli->query("SELECT * FROM cargos WHERE id_cargos = '$array[$i]' ");
                                                        $nombresCargos = $queryNombresCargos->fetch_array(MYSQLI_ASSOC); 
                                                            
                                                        "*".$nombresCargos['id_cargos']."<br><br>";
                                                        	
                                                        if($nombresCargos['id_cargos'] != NULL){
                                                        	   '<br>Debe avisar B';
                                                        	
                                                        	$extraerUsuariosSinImportacion = $mysqli->query("SELECT * FROM usuario WHERE cargo ='".$nombresCargos['id_cargos']."' ")or die(mysqli_error());
                                                            while($usuariosCargoSinImporacion = $extraerUsuariosSinImportacion->fetch_array()){
                                                            '<br>EL USUARIO: <b>'.$nombredelUsuarioSinImportacion=($usuariosCargoSinImporacion['nombres'].' '.$usuariosCargoSinImporacion['apellidos']);
                                                            '<br> tiene el id cargo: '.$usuariosCargoSinImporacion['cargo'].'</b>';
                                                            $consultaCedula=$usuariosCargoSinImporacion['cedula'];
                                                             '<br>B: '.$correoNotificarSinImportacion=$usuariosCargoSinImporacion['correo'];
                                                            
                                                
    
                                                                      $mail = new PHPMailer();
                                                                      $mail->IsSMTP();
                                                                      
                                                                     
                                                                      require 'correoEnviar/contenido.php';
                                                                     
                                                                      //Agregar destinatario
                                                                      $mail->isHTML(true);
                                                                      $mail->AddAddress($correoNotificarSinImportacion);
                                                                       '-Enviar: '.$correoNotificar;
                                                                      /// end
                                                                  
                                                                      $nombreDocumentoEnviarCorreo=$row['nombres'];//$_POST['nombreDocumento'];
                                                                      
                                                          
                                                                      if($tipoSolicitud == '1'){
                                                                          $tipoSolicitudNombre='creación';
                                                                      }
                                                                      if($tipoSolicitud == '2'){
                                                                          $tipoSolicitudNombre='actualización';
                                                                      }
                                                                      if($tipoSolicitud == '3'){
                                                                          $tipoSolicitudNombre='eliminación';
                                                                      }
                                                          
                                                                      $mail->Subject=utf8_decode('Revisión documental - dueño de proceso '); //- autorizado para visualizar
                                                                      $mail->Body = utf8_decode('
                                                                      <html>
                                                                      <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                                                      <title>HTML</title>
                                                                      </head>
                                                                      <body>
                                                                      <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                                                                      
                                                                      <p>Estimado (a). <b><em>'.$nombredelUsuarioSinImportacion.'</em></b>.
                                                                      <br>
                                                                      <p><b>El documento '.$nombreDocumentoEnviarCorreo.' se encuentra dentro del periodo de revisión</b></p>
                                                                      
                                                                      
                                                                      <br><br>
                                                                      Este correo es informativo por tanto, le pedimos no responda este mensaje.
                                                                      </p>
                                                                      </body>
                                                                      </html>
                                                                      ');
                                                                 
                                                                      if ($mail->Send()) {
                                                                          //echo'<script type="text/javascript">
                                                                          //    alert("Enviado Correctamente");
                                                                          //    </script>';
                                                                          
                                                                      } else {
                                                                          //echo'<script type="text/javascript">
                                                                          //    alert("NO ENVIADO, intentar de nuevo");
                                                                          //    </script>';
                                                                      }
                                                                      $mail->ClearAddresses();  
                                                                      
                                                                      //// end     
                                                            }
                                                  
                                                        }
                                                                    
                                                                     
                                                                    
                                                            
                                                }
                                            
                                            }
                                            
                                            
                                        /*
                                        /// luego del envio de correo para los lideres de procesos, ahora vamos a enviar correo a un segundo resposable
                                        $preguntandoParametroCorreo=$mysqli->query("SELECT * FROM documentoRevision ");
                                        $extrerPreguntaParametroCorreo=$preguntandoParametroCorreo->fetch_array(MYSQLI_ASSOC);
                                        
                                        $arrayResponsable = json_decode(($extrerPreguntaParametroCorreo['responsable']));
                                        $longitudResponsable = count($arrayResponsable);
                                        
                                        if($extrerPreguntaParametroCorreo['quien'] == 'usuario'){
                                            for($i=0; $i<$longitudResponsable; $i++){
                                                            '<br>Entra usuario';    
                                                            $extraerUsuarios = $mysqli->query("SELECT * FROM usuario WHERE id ='$arrayResponsable[$i]' ")or die(mysqli_error());
                                                            $usuariosCargo = $extraerUsuarios->fetch_array(MYSQLI_ASSOC);
                                                            '<br>EL USUARIO: <b>'.$nombredelUsuario=($usuariosCargo['nombres'].' '.$usuariosCargo['apellidos']);
                                                            '<br> tiene el id cargo: '.$usuariosCargo['cargo'].'</b>';
                                                            $consultaCedula=$usuariosCargo['cedula'];
                                                             '<br>'.$correoNotificar=$usuariosCargo['correo'];
                                                            
                                                
    
                                                                      $mail = new PHPMailer();
                                                                      $mail->IsSMTP();
                                                                      
                                                                     
                                                                      require 'correoEnviar/contenido.php';
                                                                     
                                                                      //Agregar destinatario
                                                                      $mail->isHTML(true);
                                                                      $mail->AddAddress($correoNotificar);
                                                                       '-Enviar: '.$correoNotificar;
                                                                      /// end
                                                                  
                                                                      $nombreDocumentoEnviarCorreo=$row['nombres'];//$_POST['nombreDocumento'];
                                                                      
                                                          
                                                                      if($tipoSolicitud == '1'){
                                                                          $tipoSolicitudNombre='creación';
                                                                      }
                                                                      if($tipoSolicitud == '2'){
                                                                          $tipoSolicitudNombre='actualización';
                                                                      }
                                                                      if($tipoSolicitud == '3'){
                                                                          $tipoSolicitudNombre='eliminación';
                                                                      }
                                                          
                                                                      $mail->Subject=utf8_decode('Revisión documental');
                                                                      $mail->Body = utf8_decode('
                                                                      <html>
                                                                      <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                                                      <title>HTML</title>
                                                                      </head>
                                                                      <body>
                                                                      <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                                                                      
                                                                      <p>Estimado (a). <b><em>'.$nombredelUsuario.'</em></b>.
                                                                      <br>
                                                                      <p><b>El documento '.$nombreDocumentoEnviarCorreo.' se encuentra dentro del periodo de revisión</b></p>
                                                                      
                                                                      <br><br>
                                                                      Se recomienda ingresar y verificar su solicitud.
                                                                      <br><br>
                                                                      Este correo es informativo por tanto, le pedimos no responda este mensaje.
                                                                      </p>
                                                                      </body>
                                                                      </html>
                                                                      ');
                                                                 
                                                                      if ($mail->Send()) {
                                                                          //echo'<script type="text/javascript">
                                                                          //    alert("Enviado Correctamente");
                                                                          //    </script>';
                                                                          
                                                                      } else {
                                                                          //echo'<script type="text/javascript">
                                                                          //    alert("NO ENVIADO, intentar de nuevo");
                                                                          //    </script>';
                                                                      }
                                                                      $mail->ClearAddresses();  
                                                                      
                                            }  
                                        }elseif($extrerPreguntaParametroCorreo['quien'] == 'cargo'){
                                             '<br>Entra al cargo'; 
                                            for($i=0; $i<$longitudResponsable; $i++){
                                                            '<br>Entra usuario';    
                                                            $extraerUsuarios = $mysqli->query("SELECT * FROM usuario WHERE cargo ='$arrayResponsable[$i]' ")or die(mysqli_error());
                                                            $usuariosCargo = $extraerUsuarios->fetch_array(MYSQLI_ASSOC);
                                                            '<br>EL USUARIO: <b>'.$nombredelUsuario=($usuariosCargo['nombres'].' '.$usuariosCargo['apellidos']);
                                                            '<br> tiene el id cargo: '.$usuariosCargo['cargo'].'</b>';
                                                            $consultaCedula=$usuariosCargo['cedula'];
                                                             '<br>'.$correoNotificar=$usuariosCargo['correo'];
                                                            
                                                
    
                                                                      $mail = new PHPMailer();
                                                                      $mail->IsSMTP();
                                                                      
                                                                     
                                                                      require 'correoEnviar/contenido.php';
                                                                     
                                                                      //Agregar destinatario
                                                                      $mail->isHTML(true);
                                                                      $mail->AddAddress($correoNotificar);
                                                                       '-Enviar: '.$correoNotificar;
                                                                      /// end
                                                                  
                                                                      $nombreDocumentoEnviarCorreo=$row['nombres'];//$_POST['nombreDocumento'];
                                                                      
                                                          
                                                                      if($tipoSolicitud == '1'){
                                                                          $tipoSolicitudNombre='creación';
                                                                      }
                                                                      if($tipoSolicitud == '2'){
                                                                          $tipoSolicitudNombre='actualización';
                                                                      }
                                                                      if($tipoSolicitud == '3'){
                                                                          $tipoSolicitudNombre='eliminación';
                                                                      }
                                                          
                                                                      $mail->Subject=utf8_decode('Revisión documental');
                                                                      $mail->Body = utf8_decode('
                                                                      <html>
                                                                      <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                                                      <title>HTML</title>
                                                                      </head>
                                                                      <body>
                                                                      <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                                                                      
                                                                      <p>Estimado (a). <b><em>'.$nombredelUsuario.'</em></b>.
                                                                      <br>
                                                                      <p><b>El documento '.$nombreDocumentoEnviarCorreo.' se encuentra dentro del periodo de revisión</b></p>
                                                                      
                                                                      <br><br>
                                                                      Se recomienda ingresar y verificar su solicitud.
                                                                      <br><br>
                                                                      Este correo es informativo por tanto, le pedimos no responda este mensaje.
                                                                      </p>
                                                                      </body>
                                                                      </html>
                                                                      ');
                                                                 
                                                                      if ($mail->Send()) {
                                                                          //echo'<script type="text/javascript">
                                                                          //    alert("Enviado Correctamente");
                                                                          //    </script>';
                                                                          
                                                                      } else {
                                                                          //echo'<script type="text/javascript">
                                                                          //    alert("NO ENVIADO, intentar de nuevo");
                                                                          //    </script>';
                                                                      }
                                                                      $mail->ClearAddresses();  
                                                                      
                                            }
                                        }elseif($extrerPreguntaParametroCorreo['quien'] == 'grupo'){
                                             '<br>Entra grupo'; 
                                             for($i=0; $i<$longitudResponsable; $i++){
                                                        $centrosT = $mysqli->query("SELECT * FROM grupoUusuario WHERE idGrupo = '$arrayResponsable[$i]' ");
                                                        while($rows = $centrosT->fetch_assoc()){
                                                            
                                                            $idUsuario = $rows['idUsuario'];
                                                            $extraerUsuarios = $mysqli->query("SELECT * FROM usuario WHERE cedula ='$idUsuario' ")or die(mysqli_error());
                                                            $usuariosCargo = $extraerUsuarios->fetch_array(MYSQLI_ASSOC);
                                                            '<br>EL USUARIO: <b>'.$nombredelUsuario=($usuariosCargo['nombres'].' '.$usuariosCargo['apellidos']);
                                                            '<br> tiene el id cargo: '.$usuariosCargo['cargo'].'</b>';
                                                            $consultaCedula=$usuariosCargo['cedula'];
                                                             '<br>'.$correoNotificar=$usuariosCargo['correo'];
                                                            
                                                
                                                                      
                                                                      $mail = new PHPMailer();
                                                                      $mail->IsSMTP();
                                                                      
                                                                     
                                                                      require 'correoEnviar/contenido.php';
                                                                     
                                                                      //Agregar destinatario
                                                                      $mail->isHTML(true);
                                                                      $mail->AddAddress($correoNotificar);
                                                                       '-Enviar: '.$correoNotificar;
                                                                      /// end
                                                                  
                                                                      $nombreDocumentoEnviarCorreo=$row['nombres'];//$_POST['nombreDocumento'];
                                                                      
                                                          
                                                                      if($tipoSolicitud == '1'){
                                                                          $tipoSolicitudNombre='creación';
                                                                      }
                                                                      if($tipoSolicitud == '2'){
                                                                          $tipoSolicitudNombre='actualización';
                                                                      }
                                                                      if($tipoSolicitud == '3'){
                                                                          $tipoSolicitudNombre='eliminación';
                                                                      }
                                                          
                                                                      $mail->Subject=utf8_decode('Revisión documental');
                                                                      $mail->Body = utf8_decode('
                                                                      <html>
                                                                      <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                                                      <title>HTML</title>
                                                                      </head>
                                                                      <body>
                                                                      <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                                                                      
                                                                      <p>Estimado (a). <b><em>'.$nombredelUsuario.'</em></b>.
                                                                      <br>
                                                                      <p><b>El documento '.$nombreDocumentoEnviarCorreo.' se encuentra dentro del periodo de revisión</b></p>
                                                                      
                                                                      <br><br>
                                                                      Se recomienda ingresar y verificar su solicitud.
                                                                      <br><br>
                                                                      Este correo es informativo por tanto, le pedimos no responda este mensaje.
                                                                      </p>
                                                                      </body>
                                                                      </html>
                                                                      ');
                                                                 
                                                                      if ($mail->Send()) {
                                                                          //echo'<script type="text/javascript">
                                                                          //    alert("Enviado Correctamente");
                                                                          //    </script>';
                                                                          
                                                                      } else {
                                                                          //echo'<script type="text/javascript">
                                                                          //    alert("NO ENVIADO, intentar de nuevo");
                                                                          //    </script>';
                                                                      }
                                                                      $mail->ClearAddresses();  
                                                                      
                                                        } 
                                            }
                                        }
                                        */
                                            
                                }  
                            }
                            
                            
                            
                         
                       
                    }
?>
<!-- end -->





<?php
}
?>