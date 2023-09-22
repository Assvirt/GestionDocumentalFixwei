<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';

///////// notificaciones para plataforma y correo
require_once 'conexion/bd.php';
$formulario = 'usuarios'; //Se cambia el nombre del formulario
$documento = $_SESSION["session_username"];
$queryGrupos = $mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario = '$documento'");

while($row = $queryGrupos->fetch_assoc()){
    $idGrupo = $row['idGrupo'];
    
    $queryPermisos = $mysqli->query("SELECT * FROM permisosNotificaciones WHERE idGrupo = '$idGrupo' AND formulario = '$formulario'");
    
    $permisos = $queryPermisos->fetch_array(MYSQLI_ASSOC);
    if($permisos['plataforma'] == TRUE){
        $permisoPlataforma = $permisos['plataforma'];    
    }
    if($permisos['correo'] == TRUE){
        $permisoCorreo = $permisos['correo'];    
    }
    
}

if($permisoPlataforma == FALSE){
    $visibleP = 'none';
}else{
    $visibleP = '';
}

if($permisoCorreo == FALSE){
    $visibleC = 'none';
}else{
    $visibleC = '';
}

//////// fin notificaciones correo plataforma
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Gestionar Indicador</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="../plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- grafica -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- EDN -->
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">


  <!-- Main Sidebar Container -->
  <?php echo require_once'menu.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
              <?php 
              //$quienCrea=$_POST['quienCrea'];
               
                    $muestraCalculadora=$_POST['calculadoraMostrar'];
                    $variablesIdPrincipal=$_POST['variablesIdPrincipal'];
                   
                                /// se trae el ��ltimo indicador que realizo el usuario
                                
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $ultimoIndicado=$mysqli->query("SELECT * FROM `indicadores` WHERE id='$variablesIdPrincipal'  ");
                                $extraeDatoIndicador= $ultimoIndicado->fetch_array(MYSQLI_ASSOC);
                                $ultimoIndicadorSale=$extraeDatoIndicador['id'];
                                //$ultimoIndicadorSaleQuienCrea=$extraeDatoIndicador['quienCrea'];
                                $quienCrea=$extraeDatoIndicador['quienCrea'];
                                $nombreIndicador=$extraeDatoIndicador['nombre'];
                                $descripcionIndicador=$extraeDatoIndicador['descripcion'];
                                $procesoIndicador=$extraeDatoIndicador['proceso'];
                                $indicadorDesde=$extraeDatoIndicador['desde'];
                                $indicadorHasta=$extraeDatoIndicador['hasta'];
                                $frecuenciaIndicador=$extraeDatoIndicador['frecuencia'];
                                $restrincionIndicador=$extraeDatoIndicador['restrincion'];
                                $tipoResponsable=$extraeDatoIndicador['radioCalculo'];
                                $personalID =  json_decode($extraeDatoIndicador['responsableCalculo']);
                                        
                                
                                $ultimoIndicadoProceso=$mysqli->query("SELECT * FROM `procesos` WHERE id='$procesoIndicador'  ");
                                $extraeDatoIndicadorProceso= $ultimoIndicadoProceso->fetch_array(MYSQLI_ASSOC);
                                $procesoNombreIndicador=$extraeDatoIndicadorProceso['nombre'];
                                ?>
            <h1>Gestionar Indicadores</h1> 
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <<li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Gestionar indicadores</li>
            </ol>
          </div>
        </div>
        <div>
            <div class="row">
                <div class="col-9">
                    <div class="row">
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="indicadores"><font color="white"><i class="fas fa-list"></i> Listar indicadores</font></a></button>
                        </div>
                    </div>
                </div>
                <div class="col">
                    
                </div>
                
           
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
                      
                  <div class="card-header">
                    <h3 class="card-title">Gestionar indicadores para <b><?php echo $nombreIndicador; ?></b></h3>
                  </div>
                  <!-- /.card-header -->
                   <div class="card-body">
                    <form action="" method="POST">  
                        <div class="row">
                            <div class="form-group col-sm-3">
                                <label>Nombre:</label><br>
                                <?php echo $nombreIndicador; ?>
                                <!--<input type="text" class="form-control" value="" name="nombre" placeholder="Nombre" required>-->
                             </div>
                            <div class="form-group col-sm-3">
                                <label>Descripción:</label><br>
                                
                                <textarea type="text" style="border-color:white;" cols="40%" rows="5" name="nombre" readonly required><?php echo $descripcionIndicador; ?></textarea>
                             </div>
                             <div class="form-group col-sm-3">
                                <label>Proceso:</label><br>
                                <?php echo $procesoNombreIndicador; ?>
                                <!--<input type="text" class="form-control" value="" name="nombre" placeholder="Proceso" required>-->
                             </div>
                             <div class="form-group col-sm-3">
                                <label>Responsable:</label><br>
                                <?php 
                                
                                            $longitud = count($personalID);
                                             if($tipoResponsable == 'usuario'){
                                                   
                                                    for($i=0; $i<$longitud; $i++){
                                                        
                                                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$personalID[$i]'");
                                                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                    
                                                        echo $nombreResponsableIndicador=$columna['nombres']." ".$columna['apellidos'].'<br>';
                                                        
                                                    } 
                                                 
                                                }else{
                                                    
                                                    for($i=0; $i<$longitud; $i++){
                                                    $nombrecargo = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$personalID[$i]'");
                                                    $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                                    echo $nombreResponsableIndicador = $columna['nombreCargos'].'<br>';
                                                    }
                                                }
                                ?>
                                <!--<input type="text" class="form-control" value="" name="nombre" placeholder="Responsable" required>-->
                             </div>
                        </div>
                       <div class="row">
                            <div class="form-group col-sm-3">
                                <label>Desde:</label><br>
                                <?php echo $indicadorDesde; ?>
                                <!--<input type="date" class="form-control" value="" name="nombre" placeholder="Desde" required>-->
                             </div>
                            <div class="form-group col-sm-3">
                                <label>Hasta:</label><br>
                                <?php echo $indicadorHasta; ?>
                                <!--<input type="date" class="form-control" value="" name="nombre" placeholder="Hasta" required>-->
                             </div>
                             <div class="form-group col-sm-3">
                                <label>Frecuencia:</label><br>
                                <?php echo $frecuenciaIndicador; ?>
                                <!--<input type="date" class="form-control" value="" name="nombre" placeholder="Hasta" required>-->
                             </div>
                             <div class="form-group col-sm-3">
                                <label>Gráfico:</label><br>
                                <?php echo $nombreIndicador; ?>
                                <!--<input type="text" class="form-control" value="" name="tituloPrincipal" placeholder="Gráfico" required>-->
                             </div>
                             <div class="form-group col-sm-3">
                                <label>Restrinción:</label><br>
                                <?php echo $restrincionIndicador; ?>
                                <!--<input type="text" class="form-control" value="" name="tituloPrincipal" placeholder="Gráfico" required>-->
                             </div>
                             <!--
                             <div class="form-group col-sm-3">
                                <label>Tipos de gráficas:</label>
                                <select type="text" class="form-control" name="tipoGrafica" placeholder="Tipo de graficas" required>
                                    <option value="grafica1">Tipo Barra</option>
                                    <option value="grafica1a">Tipo Barra horizontal</option>
                                    <option value="grafica2">Tipo Línea</option>
                                    <option value="grafica3">Tipo Torta</option>
                                    <option value="grafica4">Tipo Dona</option>
                                    <option value="grafica5">Tipo Radar</option>
                                </select>
                             </div> -->
                             <?php
                             /*
                             if($_POST['color1'] != NULL || $_POST['color2'] != NULL || $_POST['color3'] != NULL){
                                $color1=$_POST['color1'];
                                $color2=$_POST['color2'];
                                $color3=$_POST['color3'];
                           
                             }else{
                                $color1='#e21212';
                                $color2='#1522e0';
                                $color3='#08d90f';
                             }
                             ?>
                             <div class="form-group col-sm-3">
                                <label>Color 1</label>
                                <input name="color1" value="<? echo $color1; ?>" type="color">
                             </div>
                             <div class="form-group col-sm-3">
                                <label>Color 2</label>
                                <input name="color2" value="<? echo $color2; ?>" type="color">
                             </div>
                             <div class="form-group col-sm-3">
                                <label>Color 3</label>
                                <input name="color3" value="<? echo $color3; ?>" type="color">
                             </div> 
                             
                            <button type="submit" style="color:white;" class="btn btn-warning float-right" name="">Generar</button>
                            <? */ ?>
                            <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden">
                            <input name="variablesIdPrincipal" value="<?php echo $variablesIdPrincipal; ?>" type="hidden">
                           
                         
                        </div>
                    </form> 
                    </div>         
                    <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
               
          
            
          
    
    
    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive p-0" style="height: 800px;">
                            <table class="table table-head-fixed text-center">
                              <thead>
                                <tr>
                                    <?php 
                                    
                                    //// mes actual capturado
                                            date_default_timezone_set('America/Bogota');$fecha1=date('Y-m-j h:i:s A');
                                            'Mes actual'.$mesActual = intval(substr($fecha1, 5, 2));
                                            /// END
                                        
                                            'año presente: '.$anoPresente = intval(substr($fecha1, 0, 4)); // variable anterior $indicadorDesde
                                            
                                   //// se trae los datos de las metas
                                   $acentos = $mysqli->query("SET NAMES 'utf8'");
                                   $indicadorMeta=$mysqli->query("SELECT * FROM `indicadoresMetas` WHERE idIndicador='$variablesIdPrincipal' AND anoPresente='$anoPresente' ");
                                   $extraeDatoIndicadorMeta= $indicadorMeta->fetch_array(MYSQLI_ASSOC);
                                   $saleIndicadorMeta=$extraeDatoIndicadorMeta['metaActual'];
                                   //// END
                                   
                                   //// se trae los datos de la formula
                                   $acentos = $mysqli->query("SET NAMES 'utf8'");
                                   $indicadorFormular=$mysqli->query("SELECT * FROM `indicadores` WHERE id='$variablesIdPrincipal'  ");
                                   $extraeDatoIndicadorFormula= $indicadorFormular->fetch_array(MYSQLI_ASSOC);
                                   $saleIndicadorFormula=$extraeDatoIndicadorFormula['formula'];
                                        // necesitamos esta condición para poder validar si el mes siguiente podemos ver o no
                                        $formulaRestrincion=$extraeDatoIndicadorFormula['restrincion'];
                                        // END
                                   //// END
                                   
                                   
                                   ?>
                                            <th>
                                                <b>Fecha desde: <?php echo $indicadorDesde; ?>, Fecha hasta: <?php echo $indicadorHasta;?></b>
                                            </th>
                                            <th>
                                                <b>Fórmula</b>
                                            </th>
                                             <th>
                                                <b>Resultado</b>
                                            </th>
                                            <th>
                                                <b>Meta</b>
                                            </th>
                                            <th>
                                                <b>Análisis</b>
                                            </th>
                                            <th>
                                                <b>Aplicar fórmula</b>
                                            </th>
                                </tr>
                              </thead>
                              <tbody>
                                 
                                     <?php
                                            $indicadorDesde;
                                            
                                            $mesDesde = intval(substr($indicadorDesde, 5, 2));
                                            $mesHasta = intval(substr($indicadorHasta, 5, 2));
                                            
                                            /// variable necesaria para validar los años
                                             'Año presente'.$anoPresente;
                                             '<br>año maximo: '.$validandoAñoMaximo = intval(substr($indicadorHasta, 0, 4)); // variable anterior $indicadorDesde
                                            // END
                                            
                                            /// validacion para saber si hay restricción de alimentación futuras o no
                                            if($formulaRestrincion == 'Si'){ 
                                                $mesActualValidado=$fecha1; //$mesActual
                                            }
                                           
                                            if($formulaRestrincion == 'No'){ 
                                                $mesActualValidado=$indicadorHasta; // $mesHasta
                                            }
                                            /// END
                                           
                                           /// atrapamos el filtro de la fecha, desde hasta
                                           $datetime1 = new DateTime($indicadorDesde);
                                           $datetime2 = new DateTime($mesActualValidado); //$indicadorHasta
                                           // END
                                           
                                           // sacamos el intervalo para la diferencia entre meses
                                           $interval = date_diff($datetime1, $datetime2);
                                           $enviarIntervalo=$interval->format('%m months');
                                           
                                           $interval2 = date_diff($datetime1, $datetime2);
                                           $enviarIntevalo2=$interval2->format('%y years');
                                           /// END
                                           
                                           $totalMEses=($enviarIntevalo2*12)+$enviarIntervalo; /// calculamos los intervalos para sacar el total de los meses
                                           
                                           //// validamos la frecuencia
                                           if($frecuenciaIndicador == 'Mensual'){
                                            $totalMEsesConteo=$totalMEses/1; // se cambia la frecuencia por bimensual, trimensual,semestrual, anual.
                                            $numeroMeses='1';
                                           }
                                           if($frecuenciaIndicador == 'Bimensual'){
                                            $totalMEsesConteo=$totalMEses/2; // se cambia la frecuencia por bimensual, trimensual,semestrual, anual.
                                            $numeroMeses='2';
                                           }
                                           if($frecuenciaIndicador == 'Trimestral'){
                                            $totalMEsesConteo=$totalMEses/3; // se cambia la frecuencia por bimensual, trimensual,semestrual, anual.
                                            $numeroMeses='3';
                                           }
                                           if($frecuenciaIndicador == 'Semestral'){
                                            $totalMEsesConteo=$totalMEses/6; // se cambia la frecuencia por bimensual, trimensual,semestrual, anual.
                                            $numeroMeses='6';
                                           }
                                           if($frecuenciaIndicador == 'Anual'){
                                            $totalMEsesConteo=$totalMEses/12; // se cambia la frecuencia por bimensual, trimensual,semestrual, anual.
                                            $numeroMeses='12';
                                           }
                                           /// END
                                           
                                           
                                if($validandoAñoMaximo >= $anoPresente){  ///// comparamos que el año sea igual o mayor al presente, si la fecha máxima del indicador es menor al año presente no debe pintar los meses
                                           
                                    /// realizamos el recorrido para mostrar los meses
                                    for($i=1; $i<=$totalMEsesConteo; $i++){
                                        
                                         $indicadorDesde=date("d-m-Y",strtotime($indicadorDesde."+ $numeroMeses month")); // se cambia la frecuencia por mensual, bimensual, trimensual,semestrual, anual.
                                        
                                        'dato: '.$enviarMeses=intval(substr($indicadorDesde, 3, 2));  /// para sacar el número del mes y encontrar el nombre del mes
                                         
                                         setlocale(LC_ALL, 'es_ES');
                                         $monthNum  = $enviarMeses;
                                         $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                         $mostrarMes = strftime('%B', $dateObj->getTimestamp());
                                         '--<b>'.$mostrarMes.'</b><br>';  /// enviar este dato aplicar formula, comentarios, metas,documentos....
                                ?> 
                                         <tr>
                                                           
                                                                                <td data-titulo="Fecha" >
                                                                                <?php
                                                                                $anoPresente=$indicadorDesde;
                                                                                   echo '<center>Fecha <b>'.$anoPresente;
                                                                                   echo'</b>, mes de <b>'.$mostrarMes.'</b></center>'; //$anoPresente
                                                                                ?>
                                                                                
                                                                                </td>
                                                                                <td data-titulo="Formula">
                                                                                   <?php echo '<b>'.$saleIndicadorFormula.'</b>'; ?>
                                                                                </td>
                                                                                 <td data-titulo="Resultado">
                                                                                   <?php
                                                                                        echo '<b>'; 
                                                                                        $consultarMeta=$mysqli->query("SELECT * FROM `indicadores` WHERE id='$variablesIdPrincipal' ");
                                                                                                 $extraerMEta=$consultarMeta->fetch_array(MYSQLI_ASSOC);
                                                                                                  '<b>Sentido:</b> '.$sentidoIndicador=$extraerMEta['sentido'];
                                                                                                 $formulaAlimentada=$extraerMEta['alimentado'];
                                                                                                 
                                                                                                $ultimoIndicadoMes=$mysqli->query("SELECT * FROM `indicadoresGestionar` WHERE idIndicador='$variablesIdPrincipal' AND mes='$mostrarMes' AND anoPresente='$anoPresente' GROUP BY mes ");
                                                                                                $extraeDatoIndicadorMes= $ultimoIndicadoMes->fetch_array(MYSQLI_ASSOC);
                                                                                                 '<br>resultado: '.$DatoAlimentado=$extraeDatoIndicadorMes['alimentado'];
                                                                                                 //$resultadoEnero=$extraeDatoIndicadorMes['alimentado'];
                                                                                                 
                                                                                                 $consultarMeta=$mysqli->query("SELECT * FROM `indicadoresMetas` WHERE idIndicador='$variablesIdPrincipal' AND anoPresente='$anoPresente' ");
                                                                                                 $extraerMEta=$consultarMeta->fetch_array(MYSQLI_ASSOC);
                                                                                                  ' <b>meta:</b> '.$metaFormula=$extraerMEta['metaActual'];
                                                                                                  $metaFormulaUnidad=$extraerMEta['unidad'];
                                                                                                 
                                                                                                 
                                                                                                  //// si el sentido de la meta viene positivo
                                                                                                  if($sentidoIndicador == 'Positivo'){
                                                                                                      
                                                                                                    if($DatoAlimentado > $metaFormula ){ 
                                                                                                      echo '<font style="background:blue;color:white;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                    if($DatoAlimentado <= $metaFormula && $DatoAlimentado > $extraerMEta['za']){
                                                                                                      echo '<font style="background:green;color:white;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }  
                                                                                                    if($DatoAlimentado <= $extraerMEta['za'] && $DatoAlimentado > $extraerMEta['zp']){
                                                                                                      echo '<font style="background:yellow;color:black;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                    if($DatoAlimentado <= $extraerMEta['zp']){
                                                                                                      echo '<font style="background:red;color:white;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                  
                                                                                                      
                                                                                                  }
                                                                                                  
                                                                                                  if($sentidoIndicador == 'Negativo'){
                                                                                                      
                                                                                                    if($DatoAlimentado < $metaFormula ){ 
                                                                                                      echo '<font style="background:blue;color:white;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                    if($DatoAlimentado >= $metaFormula && $DatoAlimentado < $extraerMEta['za']){
                                                                                                      echo '<font style="background:green;color:white;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                    if($DatoAlimentado == $extraerMEta['za'] && $DatoAlimentado < $extraerMEta['zp']){
                                                                                                      echo '<font style="background:yellow;color:black;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                    if($DatoAlimentado >= $extraerMEta['zp']){
                                                                                                      echo '<font style="background:red;color:white;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                  }
                                                                                                  
                                                                                                  
                                                                                                  //// END
                                                                                        echo '</b>';
                                                                                   ?>
                                                                                </td>
                                                                                <td data-titulo="Meta">
                                                                                  <?php echo '<b>'.$saleIndicadorMeta.'</b>'; ?>
                                                                                </td>
                                                                              
                                                                                
                                                                                <td data-titulo="Análisis" align="left">
                                                                                    <?php
                                                                                       //// se trae los archivos
                                                                                       $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                                                       $indicadorArchivos=$mysqli->query("SELECT * FROM `indicadoresGestionar` WHERE idIndicador='$variablesIdPrincipal' AND mes='$mostrarMes' AND anoPresente='$anoPresente' ");
                                                                                       while($extraeDatoIndicadorArchivos= $indicadorArchivos->fetch_array()){
                                                                                       
                                                                                        $nombreDocumento=$extraeDatoIndicadorArchivos['documento'];
                                                                                        $ruta=$extraeDatoIndicadorArchivos['soporte'];
                                                                                        if($ruta != NULL){
                                                                                        echo"
                                                                                          
                                                                                            <i class='fas fa-download'></i>
                                                                                            <a style='color:black' href='$ruta' download='' target='_blank'>$nombreDocumento</a>
                                                                                        
                                                                                        <br>";
                                                                                       
                                                                                       }
                                                                                       }
                                                                                       //// END
                                                                                        echo '<br>Análisis:<br>';
                                                                                       $indicadorArchivos=$mysqli->query("SELECT * FROM `indicadoresGestionar` WHERE idIndicador='$variablesIdPrincipal' AND mes='$mostrarMes' AND anoPresente='$anoPresente' ");
                                                                                       while($extraeDatoIndicadorArchivos= $indicadorArchivos->fetch_array()){
                                                                                       
                                                                                        $nombreDocumento=$extraeDatoIndicadorArchivos['documento'];
                                                                                        $ruta=$extraeDatoIndicadorArchivos['soporte'];
                                                                                        $analisisComentario=$extraeDatoIndicadorArchivos['analisis'];
                                                                                        if($analisisComentario != NULL){
                                                                                            echo '<b>*</b> '.$analisisComentario.'<br>';
                                                                                        }
                                                                                        
                                                                                        }
                                                                                       //// END
                                                                                    ?>
                                                                                  <form action="controlador/indicadores/controllerGestionar" method="POST" enctype="multipart/form-data">
                                                                                        <input name="anoPresente" value="<?php echo $anoPresente; ?>" readonly type="hidden">
                                                                                        <input name="mes" readonly type="hidden" value="<?php echo $mostrarMes; ?>">
                                                                                        <textarea name="analisis" class="form-control"></textarea>
                                                                                        <input name="nombre" type="hidden" value="<?php echo $nombreIndicador; ?>" readonly>
                                                                                        <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden">
                                                                                        <input name="variablesIdPrincipal" value="<?php echo $variablesIdPrincipal; ?>" type="hidden">
                                                                                       <!-- <input class='btn btn-sm' style="background:gray;color:white;" type="file" name="soporte">-->
                                                                                        
                                                                                        <label for="upload-photo">Archivo:</label>
                                                                                          <div class="input-group">
                                                                                            <div class="custom-file">
                                                                                            <input type="file" class="custom-file-input" name="soporte"  >
                                                                                            <label class="custom-file-label" >Subir Archivo</label>
                                                                                            
                                                                                          </div>
                                                                                         </div>
                                                                                        <br>
                                                                                        <button class='btn btn-info btn-sm'>Agregar</button>
                                                                                    </form>
                                                                                </td>
                                                                                <td>
                                                                                    <form action="indicadoresGestionarAplicar" method="POST" enctype="multipart/form-data">
                                                                                        <input name="anoPresente" value="<?php echo $anoPresente; ?>" readonly type="hidden">
                                                                                        <input name="mes" readonly type="hidden" value="<?php echo $mostrarMes; ?>">
                                                                                        <input name="variablesIdPrincipal" type="hidden" value="<?php echo $variablesIdPrincipal; ?>">
                                                                                        <button class='btn btn-success btn-sm'>Aplicar</button>
                                                                                    </form>
                                                                                </td>
                                                       
                                                         </tr>
                                                         <?
                                    }
                                           //// END
                                } /// END
                                          
                                           
                                           
                                           /*
                                            if($validandoAñoMaximo >= $anoPresente){  ///// comparamos que el año sea igual o mayor al presente, si la fecha máxima del indicador es menor al año presente no debe pintar los meses
                                                   //echo 'fre: '.$mesActualValidado;
                                                   ///// validación de la frecuencia 
                                                   if($frecuenciaIndicador == 'Mensual'){
                                                       /// construccion de los meses
                                                       for($i=$mesDesde; $i<=$mesActualValidado; $i++){
                                                           'Conteo: '.$i;
                                                           
                                                           if($i == '1'){
                                                               $mostrarMes='Enero';
                                                           }
                                                           if($i == '2'){
                                                               $mostrarMes='Febrero';
                                                           }
                                                           if($i == '3'){
                                                               $mostrarMes='Marzo';
                                                           }
                                                           if($i == '4'){
                                                               $mostrarMes='Abril';
                                                           }
                                                           if($i == '5'){
                                                               $mostrarMes='Mayo';
                                                           }
                                                           if($i == '6'){
                                                               $mostrarMes='Junio';
                                                           }
                                                           if($i == '7'){
                                                               $mostrarMes='Julio';
                                                           }
                                                           if($i == '8'){
                                                               $mostrarMes='Agosto';
                                                           }
                                                           if($i == '9'){
                                                               $mostrarMes='Septiembre';
                                                           }
                                                           if($i == '10'){
                                                               $mostrarMes='Octubre';
                                                           }
                                                           if($i == '11'){
                                                               $mostrarMes='Noviembre';
                                                           }
                                                           if($i == '12'){
                                                               $mostrarMes='Diciembre';
                                                           }
                                                           ?>
                                                               <tr>
                                                           
                                                                                <td data-titulo="Fecha" >
                                                                                <?php
                                                                                   echo '<center>Mes de <b>'.$mostrarMes;
                                                                                   echo'</b> del año <b>'.$anoPresente.'</b></center>';
                                                                                ?>
                                                                                
                                                                                </td>
                                                                                <td data-titulo="Formula">
                                                                                   <?php echo '<b>'.$saleIndicadorFormula.'</b>'; ?>
                                                                                </td>
                                                                                 <td data-titulo="Resultado">
                                                                                   <?php
                                                                                        echo '<b>'; 
                                                                                        $consultarMeta=$mysqli->query("SELECT * FROM `indicadores` WHERE id='$variablesIdPrincipal' ");
                                                                                                 $extraerMEta=$consultarMeta->fetch_array(MYSQLI_ASSOC);
                                                                                                  '<b>Sentido:</b> '.$sentidoIndicador=$extraerMEta['sentido'];
                                                                                                 $formulaAlimentada=$extraerMEta['alimentado'];
                                                                                                 
                                                                                                $ultimoIndicadoMes=$mysqli->query("SELECT * FROM `indicadoresGestionar` WHERE idIndicador='$variablesIdPrincipal' AND mes='$mostrarMes' AND anoPresente='$anoPresente' GROUP BY mes ");
                                                                                                $extraeDatoIndicadorMes= $ultimoIndicadoMes->fetch_array(MYSQLI_ASSOC);
                                                                                                 '<br>resultado: '.$DatoAlimentado=$extraeDatoIndicadorMes['alimentado'];
                                                                                                 //$resultadoEnero=$extraeDatoIndicadorMes['alimentado'];
                                                                                                 
                                                                                                 $consultarMeta=$mysqli->query("SELECT * FROM `indicadoresMetas` WHERE idIndicador='$variablesIdPrincipal' AND anoPresente='$anoPresente' ");
                                                                                                 $extraerMEta=$consultarMeta->fetch_array(MYSQLI_ASSOC);
                                                                                                  ' <b>meta:</b> '.$metaFormula=$extraerMEta['metaActual'];
                                                                                                  $metaFormulaUnidad=$extraerMEta['unidad'];
                                                                                                 
                                                                                                 
                                                                                                  //// si el sentido de la meta viene positivo
                                                                                                  if($sentidoIndicador == 'Positivo'){
                                                                                                      
                                                                                                    if($DatoAlimentado > $metaFormula ){ 
                                                                                                      echo '<font style="background:blue;color:white;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                    if($DatoAlimentado <= $metaFormula && $DatoAlimentado > $extraerMEta['za']){
                                                                                                      echo '<font style="background:green;color:white;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }  
                                                                                                    if($DatoAlimentado <= $extraerMEta['za'] && $DatoAlimentado > $extraerMEta['zp']){
                                                                                                      echo '<font style="background:yellow;color:black;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                    if($DatoAlimentado <= $extraerMEta['zp']){
                                                                                                      echo '<font style="background:red;color:white;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                  
                                                                                                      
                                                                                                  }
                                                                                                  
                                                                                                  if($sentidoIndicador == 'Negativo'){
                                                                                                      
                                                                                                    if($DatoAlimentado < $metaFormula ){ 
                                                                                                      echo '<font style="background:blue;color:white;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                    if($DatoAlimentado >= $metaFormula && $DatoAlimentado < $extraerMEta['za']){
                                                                                                      echo '<font style="background:green;color:white;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                    if($DatoAlimentado == $extraerMEta['za'] && $DatoAlimentado < $extraerMEta['zp']){
                                                                                                      echo '<font style="background:yellow;color:black;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                    if($DatoAlimentado >= $extraerMEta['zp']){
                                                                                                      echo '<font style="background:red;color:white;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                  }
                                                                                                  
                                                                                                  
                                                                                                  //// END
                                                                                        echo '</b>';
                                                                                   ?>
                                                                                </td>
                                                                                <td data-titulo="Meta">
                                                                                  <?php echo '<b>'.$saleIndicadorMeta.'</b>'; ?>
                                                                                </td>
                                                                              
                                                                                
                                                                                <td data-titulo="Análisis" align="left">
                                                                                    <?php
                                                                                       //// se trae los archivos
                                                                                       $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                                                       $indicadorArchivos=$mysqli->query("SELECT * FROM `indicadoresGestionar` WHERE idIndicador='$variablesIdPrincipal' AND mes='$mostrarMes' AND anoPresente='$anoPresente' ");
                                                                                       while($extraeDatoIndicadorArchivos= $indicadorArchivos->fetch_array()){
                                                                                       
                                                                                        $nombreDocumento=$extraeDatoIndicadorArchivos['documento'];
                                                                                        $ruta=$extraeDatoIndicadorArchivos['soporte'];
                                                                                        if($ruta != NULL){
                                                                                        echo"
                                                                                          
                                                                                            <i class='fas fa-download'></i>
                                                                                            <a style='color:black' href='$ruta' download='' target='_blank'>$nombreDocumento</a>
                                                                                        
                                                                                        <br>";
                                                                                       
                                                                                       }
                                                                                       }
                                                                                       //// END
                                                                                        echo '<br>Análisis:<br>';
                                                                                       $indicadorArchivos=$mysqli->query("SELECT * FROM `indicadoresGestionar` WHERE idIndicador='$variablesIdPrincipal' AND mes='$mostrarMes' AND anoPresente='$anoPresente' ");
                                                                                       while($extraeDatoIndicadorArchivos= $indicadorArchivos->fetch_array()){
                                                                                       
                                                                                        $nombreDocumento=$extraeDatoIndicadorArchivos['documento'];
                                                                                        $ruta=$extraeDatoIndicadorArchivos['soporte'];
                                                                                        $analisisComentario=$extraeDatoIndicadorArchivos['analisis'];
                                                                                        if($analisisComentario != NULL){
                                                                                            echo '<b>*</b> '.$analisisComentario.'<br>';
                                                                                        }
                                                                                        
                                                                                        }
                                                                                       //// END
                                                                                    ?>
                                                                                  <form action="controlador/indicadores/controllerGestionar" method="POST" enctype="multipart/form-data">
                                                                                        <input name="anoPresente" value="<?php echo $anoPresente; ?>" readonly type="hidden">
                                                                                        <input name="mes" readonly type="hidden" value="<?php echo $mostrarMes; ?>">
                                                                                        <textarea name="analisis" class="form-control"></textarea>
                                                                                        <input name="nombre" type="hidden" value="<?php echo $nombreIndicador; ?>" readonly>
                                                                                        <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden">
                                                                                        <input name="variablesIdPrincipal" value="<?php echo $variablesIdPrincipal; ?>" type="hidden">
                                                                                       <!-- <input class='btn btn-sm' style="background:gray;color:white;" type="file" name="soporte">-->
                                                                                        
                                                                                        <label for="upload-photo">Archivo:</label>
                                                                                          <div class="input-group">
                                                                                            <div class="custom-file">
                                                                                            <input type="file" class="custom-file-input" name="soporte"  >
                                                                                            <label class="custom-file-label" >Subir Archivo</label>
                                                                                            
                                                                                          </div>
                                                                                         </div>
                                                                                        <br>
                                                                                        <button class='btn btn-info btn-sm'>Agregar</button>
                                                                                    </form>
                                                                                </td>
                                                                                <td>
                                                                                    <form action="indicadoresGestionarAplicar" method="POST" enctype="multipart/form-data">
                                                                                        <input name="anoPresente" value="<?php echo $anoPresente; ?>" readonly type="hidden">
                                                                                        <input name="mes" readonly type="hidden" value="<?php echo $mostrarMes; ?>">
                                                                                        <input name="variablesIdPrincipal" type="hidden" value="<?php echo $variablesIdPrincipal; ?>">
                                                                                        <button class='btn btn-success btn-sm'>Aplicar</button>
                                                                                    </form>
                                                                                </td>
                                                       
                                                         </tr>
                                                           <?
                                                       }
                                                       /// END
                                                   }
                                                   if($frecuenciaIndicador == 'Bimensual'){
                                                       /// construccion de los meses
                                                       for($i=$mesDesde; $i<=$mesActualValidado; $i+=2){
                                                          $i;
                                                           
                                                           if($i == '1'){
                                                               $mostrarMes='Enero';
                                                           }
                                                           if($i == '2'){
                                                               $mostrarMes='Febrero';
                                                           }
                                                           if($i == '3'){
                                                               $mostrarMes='Marzo';
                                                           }
                                                           if($i == '4'){
                                                               $mostrarMes='Abril';
                                                           }
                                                           if($i == '5'){
                                                               $mostrarMes='Mayo';
                                                           }
                                                           if($i == '6'){
                                                               $mostrarMes='Junio';
                                                           }
                                                           if($i == '7'){
                                                               $mostrarMes='Julio';
                                                           }
                                                           if($i == '8'){
                                                               $mostrarMes='Agosto';
                                                           }
                                                           if($i == '9'){
                                                               $mostrarMes='Septiembre';
                                                           }
                                                           if($i == '10'){
                                                               $mostrarMes='Octubre';
                                                           }
                                                           if($i == '11'){
                                                               $mostrarMes='Noviembre';
                                                           }
                                                           if($i == '12'){
                                                               $mostrarMes='Diciembre';
                                                           }
                                                           ?>
                                                               <tr>
                                                           
                                                                                <td data-titulo="Fecha" >
                                                                                <?php
                                                                                   echo '<center>Mes de <b>'.$mostrarMes;
                                                                                   echo'</b> del año <b>'.$anoPresente.'</b></center>';
                                                                                ?>
                                                                                
                                                                                </td>
                                                                                <td data-titulo="Formula">
                                                                                   <?php echo '<b>'.$saleIndicadorFormula.'</b>'; ?>
                                                                                </td>
                                                                                 <td data-titulo="Resultado">
                                                                                   <?php
                                                                                        echo '<b>'; 
                                                                                        $consultarMeta=$mysqli->query("SELECT * FROM `indicadores` WHERE id='$variablesIdPrincipal' ");
                                                                                                 $extraerMEta=$consultarMeta->fetch_array(MYSQLI_ASSOC);
                                                                                                  '<b>Sentido:</b> '.$sentidoIndicador=$extraerMEta['sentido'];
                                                                                                 $formulaAlimentada=$extraerMEta['alimentado'];
                                                                                                 
                                                                                                $ultimoIndicadoMes=$mysqli->query("SELECT * FROM `indicadoresGestionar` WHERE idIndicador='$variablesIdPrincipal' AND mes='$mostrarMes' AND anoPresente='$anoPresente' GROUP BY mes ");
                                                                                                $extraeDatoIndicadorMes= $ultimoIndicadoMes->fetch_array(MYSQLI_ASSOC);
                                                                                                 '<br>resultado: '.$DatoAlimentado=$extraeDatoIndicadorMes['alimentado'];
                                                                                                 //$resultadoEnero=$extraeDatoIndicadorMes['alimentado'];
                                                                                                 
                                                                                                 $consultarMeta=$mysqli->query("SELECT * FROM `indicadoresMetas` WHERE idIndicador='$variablesIdPrincipal' AND anoPresente='$anoPresente' ");
                                                                                                 $extraerMEta=$consultarMeta->fetch_array(MYSQLI_ASSOC);
                                                                                                  ' <b>meta:</b> '.$metaFormula=$extraerMEta['metaActual'];
                                                                                                  $metaFormulaUnidad=$extraerMEta['unidad'];
                                                                                                 
                                                                                                 
                                                                                                  //// si el sentido de la meta viene positivo
                                                                                                  if($sentidoIndicador == 'Positivo'){
                                                                                                      
                                                                                                    if($DatoAlimentado > $metaFormula ){ 
                                                                                                      echo '<font style="background:blue;color:white;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                    if($DatoAlimentado <= $metaFormula && $DatoAlimentado > $extraerMEta['za']){
                                                                                                      echo '<font style="background:green;color:white;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }  
                                                                                                    if($DatoAlimentado <= $extraerMEta['za'] && $DatoAlimentado > $extraerMEta['zp']){
                                                                                                      echo '<font style="background:yellow;color:black;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                    if($DatoAlimentado <= $extraerMEta['zp']){
                                                                                                      echo '<font style="background:red;color:white;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                  
                                                                                                      
                                                                                                  }
                                                                                                  
                                                                                                  if($sentidoIndicador == 'Negativo'){
                                                                                                      
                                                                                                    if($DatoAlimentado < $metaFormula ){ 
                                                                                                      echo '<font style="background:blue;color:white;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                    if($DatoAlimentado >= $metaFormula && $DatoAlimentado < $extraerMEta['za']){
                                                                                                      echo '<font style="background:green;color:white;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                    if($DatoAlimentado == $extraerMEta['za'] && $DatoAlimentado < $extraerMEta['zp']){
                                                                                                      echo '<font style="background:yellow;color:black;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                    if($DatoAlimentado >= $extraerMEta['zp']){
                                                                                                      echo '<font style="background:red;color:white;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                  }
                                                                                                  
                                                                                                  
                                                                                                  //// END
                                                                                        echo '</b>';
                                                                                   ?>
                                                                                </td>
                                                                                <td data-titulo="Meta">
                                                                                  <?php echo '<b>'.$saleIndicadorMeta.'</b>'; ?>
                                                                                </td>
                                                                              
                                                                                
                                                                                <td data-titulo="Análisis" align="left">
                                                                                    <?php
                                                                                       //// se trae los archivos
                                                                                       $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                                                       $indicadorArchivos=$mysqli->query("SELECT * FROM `indicadoresGestionar` WHERE idIndicador='$variablesIdPrincipal' AND mes='$mostrarMes' AND anoPresente='$anoPresente' ");
                                                                                       while($extraeDatoIndicadorArchivos= $indicadorArchivos->fetch_array()){
                                                                                       
                                                                                        $nombreDocumento=$extraeDatoIndicadorArchivos['documento'];
                                                                                        $ruta=$extraeDatoIndicadorArchivos['soporte'];
                                                                                        if($ruta != NULL){
                                                                                        echo"
                                                                                          
                                                                                            <i class='fas fa-download'></i>
                                                                                            <a style='color:black' href='$ruta' download='' target='_blank'>$nombreDocumento</a>
                                                                                        
                                                                                        <br>";
                                                                                       
                                                                                       }
                                                                                       }
                                                                                       //// END
                                                                                        echo '<br>Análisis:<br>';
                                                                                       $indicadorArchivos=$mysqli->query("SELECT * FROM `indicadoresGestionar` WHERE idIndicador='$variablesIdPrincipal' AND mes='$mostrarMes' AND anoPresente='$anoPresente' ");
                                                                                       while($extraeDatoIndicadorArchivos= $indicadorArchivos->fetch_array()){
                                                                                       
                                                                                        $nombreDocumento=$extraeDatoIndicadorArchivos['documento'];
                                                                                        $ruta=$extraeDatoIndicadorArchivos['soporte'];
                                                                                        $analisisComentario=$extraeDatoIndicadorArchivos['analisis'];
                                                                                        if($analisisComentario != NULL){
                                                                                            echo '<b>*</b> '.$analisisComentario.'<br>';
                                                                                        }
                                                                                        
                                                                                        }
                                                                                       //// END
                                                                                    ?>
                                                                                  <form action="controlador/indicadores/controllerGestionar" method="POST" enctype="multipart/form-data">
                                                                                        <input name="anoPresente" value="<?php echo $anoPresente; ?>" readonly type="hidden">
                                                                                        <input name="mes" readonly type="hidden" value="<?php echo $mostrarMes; ?>">
                                                                                        <textarea name="analisis" class="form-control"></textarea>
                                                                                        <input name="nombre" type="hidden" value="<?php echo $nombreIndicador; ?>" readonly>
                                                                                        <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden">
                                                                                        <input name="variablesIdPrincipal" value="<?php echo $variablesIdPrincipal; ?>" type="hidden">
                                                                                       <!-- <input class='btn btn-sm' style="background:gray;color:white;" type="file" name="soporte">-->
                                                                                        
                                                                                        <label for="upload-photo">Archivo:</label>
                                                                                          <div class="input-group">
                                                                                            <div class="custom-file">
                                                                                            <input type="file" class="custom-file-input" name="soporte"  >
                                                                                            <label class="custom-file-label" >Subir Archivo</label>
                                                                                            
                                                                                          </div>
                                                                                         </div>
                                                                                        <br>
                                                                                        <button class='btn btn-info btn-sm'>Agregar</button>
                                                                                    </form>
                                                                                </td>
                                                                                <td>
                                                                                    <form action="indicadoresGestionarAplicar" method="POST" enctype="multipart/form-data">
                                                                                        <input name="anoPresente" value="<?php echo $anoPresente; ?>" readonly type="hidden">
                                                                                        <input name="mes" readonly type="hidden" value="<?php echo $mostrarMes; ?>">
                                                                                        <input name="variablesIdPrincipal" type="hidden" value="<?php echo $variablesIdPrincipal; ?>">
                                                                                        <button class='btn btn-success btn-sm'>Aplicar</button>
                                                                                    </form>
                                                                                </td>
                                                       
                                                         </tr>
                                                           <?
                                                       }
                                                       /// END
                                                   }
                                                   if($frecuenciaIndicador == 'Trimestral'){
                                                       /// construccion de los meses
                                                        '<br>'.$mesDesde;
                                                        '<br>'.$mesActualValidado.'<br>';
                                                       for($i=$mesDesde; $i<=$mesActualValidado; $i+=3){
                                                           $i.'<br>';
                                                           
                                                           if($i == '1'){
                                                               $mostrarMes='Enero';
                                                           }
                                                           if($i == '2'){
                                                               $mostrarMes='Febrero';
                                                           }
                                                           if($i == '3'){
                                                               $mostrarMes='Marzo';
                                                           }
                                                           if($i == '4'){
                                                               $mostrarMes='Abril';
                                                           }
                                                           if($i == '5'){
                                                               $mostrarMes='Mayo';
                                                           }
                                                           if($i == '6'){
                                                               $mostrarMes='Junio';
                                                           }
                                                           if($i == '7'){
                                                               $mostrarMes='Julio';
                                                           }
                                                           if($i == '8'){
                                                               $mostrarMes='Agosto';
                                                           }
                                                           if($i == '9'){
                                                               $mostrarMes='Septiembre';
                                                           }
                                                           if($i == '10'){
                                                               $mostrarMes='Octubre';
                                                           }
                                                           if($i == '11'){
                                                               $mostrarMes='Noviembre';
                                                           }
                                                           if($i == '12'){
                                                               $mostrarMes='Diciembre';
                                                           }
                                                           ?>
                                                               <tr>
                                                           
                                                                                <td data-titulo="Fecha" >
                                                                                <?php
                                                                                   echo '<center>Mes de <b>'.$mostrarMes;
                                                                                   echo'</b> del año <b>'.$anoPresente.'</b></center>';
                                                                                ?>
                                                                                
                                                                                </td>
                                                                                <td data-titulo="Formula">
                                                                                   <?php echo '<b>'.$saleIndicadorFormula.'</b>'; ?>
                                                                                </td>
                                                                                 <td data-titulo="Resultado">
                                                                                   <?php
                                                                                        echo '<b>'; 
                                                                                        $consultarMeta=$mysqli->query("SELECT * FROM `indicadores` WHERE id='$variablesIdPrincipal' ");
                                                                                                 $extraerMEta=$consultarMeta->fetch_array(MYSQLI_ASSOC);
                                                                                                  '<b>Sentido:</b> '.$sentidoIndicador=$extraerMEta['sentido'];
                                                                                                 $formulaAlimentada=$extraerMEta['alimentado'];
                                                                                                 
                                                                                                $ultimoIndicadoMes=$mysqli->query("SELECT * FROM `indicadoresGestionar` WHERE idIndicador='$variablesIdPrincipal' AND mes='$mostrarMes' AND anoPresente='$anoPresente' GROUP BY mes ");
                                                                                                $extraeDatoIndicadorMes= $ultimoIndicadoMes->fetch_array(MYSQLI_ASSOC);
                                                                                                 '<br>resultado: '.$DatoAlimentado=$extraeDatoIndicadorMes['alimentado'];
                                                                                                 //$resultadoEnero=$extraeDatoIndicadorMes['alimentado'];
                                                                                                 
                                                                                                 $consultarMeta=$mysqli->query("SELECT * FROM `indicadoresMetas` WHERE idIndicador='$variablesIdPrincipal' AND anoPresente='$anoPresente' ");
                                                                                                 $extraerMEta=$consultarMeta->fetch_array(MYSQLI_ASSOC);
                                                                                                  ' <b>meta:</b> '.$metaFormula=$extraerMEta['metaActual'];
                                                                                                  $metaFormulaUnidad=$extraerMEta['unidad'];
                                                                                                 
                                                                                                 
                                                                                                  //// si el sentido de la meta viene positivo
                                                                                                  if($sentidoIndicador == 'Positivo'){
                                                                                                      
                                                                                                    if($DatoAlimentado > $metaFormula ){ 
                                                                                                      echo '<font style="background:blue;color:white;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                    if($DatoAlimentado <= $metaFormula && $DatoAlimentado > $extraerMEta['za']){
                                                                                                      echo '<font style="background:green;color:white;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }  
                                                                                                    if($DatoAlimentado <= $extraerMEta['za'] && $DatoAlimentado > $extraerMEta['zp']){
                                                                                                      echo '<font style="background:yellow;color:black;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                    if($DatoAlimentado <= $extraerMEta['zp']){
                                                                                                      echo '<font style="background:red;color:white;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                  
                                                                                                      
                                                                                                  }
                                                                                                  
                                                                                                  if($sentidoIndicador == 'Negativo'){
                                                                                                      
                                                                                                    if($DatoAlimentado < $metaFormula ){ 
                                                                                                      echo '<font style="background:blue;color:white;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                    if($DatoAlimentado >= $metaFormula && $DatoAlimentado < $extraerMEta['za']){
                                                                                                      echo '<font style="background:green;color:white;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                    if($DatoAlimentado == $extraerMEta['za'] && $DatoAlimentado < $extraerMEta['zp']){
                                                                                                      echo '<font style="background:yellow;color:black;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                    if($DatoAlimentado >= $extraerMEta['zp']){
                                                                                                      echo '<font style="background:red;color:white;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                  }
                                                                                                  
                                                                                                  
                                                                                                  //// END
                                                                                        echo '</b>';
                                                                                   ?>
                                                                                </td>
                                                                                <td data-titulo="Meta">
                                                                                  <?php echo '<b>'.$saleIndicadorMeta.'</b>'; ?>
                                                                                </td>
                                                                              
                                                                                
                                                                                <td data-titulo="Análisis" align="left">
                                                                                    <?php
                                                                                       //// se trae los archivos
                                                                                       $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                                                       $indicadorArchivos=$mysqli->query("SELECT * FROM `indicadoresGestionar` WHERE idIndicador='$variablesIdPrincipal' AND mes='$mostrarMes' AND anoPresente='$anoPresente' ");
                                                                                       while($extraeDatoIndicadorArchivos= $indicadorArchivos->fetch_array()){
                                                                                       
                                                                                        $nombreDocumento=$extraeDatoIndicadorArchivos['documento'];
                                                                                        $ruta=$extraeDatoIndicadorArchivos['soporte'];
                                                                                        if($ruta != NULL){
                                                                                        echo"
                                                                                          
                                                                                            <i class='fas fa-download'></i>
                                                                                            <a style='color:black' href='$ruta' download='' target='_blank'>$nombreDocumento</a>
                                                                                        
                                                                                        <br>";
                                                                                       
                                                                                       }
                                                                                       }
                                                                                       //// END
                                                                                        echo '<br>Análisis:<br>';
                                                                                       $indicadorArchivos=$mysqli->query("SELECT * FROM `indicadoresGestionar` WHERE idIndicador='$variablesIdPrincipal' AND mes='$mostrarMes' AND anoPresente='$anoPresente' ");
                                                                                       while($extraeDatoIndicadorArchivos= $indicadorArchivos->fetch_array()){
                                                                                       
                                                                                        $nombreDocumento=$extraeDatoIndicadorArchivos['documento'];
                                                                                        $ruta=$extraeDatoIndicadorArchivos['soporte'];
                                                                                        $analisisComentario=$extraeDatoIndicadorArchivos['analisis'];
                                                                                        if($analisisComentario != NULL){
                                                                                            echo '<b>*</b> '.$analisisComentario.'<br>';
                                                                                        }
                                                                                        
                                                                                        }
                                                                                       //// END
                                                                                    ?>
                                                                                  <form action="controlador/indicadores/controllerGestionar" method="POST" enctype="multipart/form-data">
                                                                                        <input name="anoPresente" value="<?php echo $anoPresente; ?>" readonly type="hidden">
                                                                                        <input name="mes" readonly type="hidden" value="<?php echo $mostrarMes; ?>">
                                                                                        <textarea name="analisis" class="form-control"></textarea>
                                                                                        <input name="nombre" type="hidden" value="<?php echo $nombreIndicador; ?>" readonly>
                                                                                        <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden">
                                                                                        <input name="variablesIdPrincipal" value="<?php echo $variablesIdPrincipal; ?>" type="hidden">
                                                                                       <!-- <input class='btn btn-sm' style="background:gray;color:white;" type="file" name="soporte">-->
                                                                                        
                                                                                        <label for="upload-photo">Archivo:</label>
                                                                                          <div class="input-group">
                                                                                            <div class="custom-file">
                                                                                            <input type="file" class="custom-file-input" name="soporte"  >
                                                                                            <label class="custom-file-label" >Subir Archivo</label>
                                                                                            
                                                                                          </div>
                                                                                         </div>
                                                                                        <br>
                                                                                        <button class='btn btn-info btn-sm'>Agregar</button>
                                                                                    </form>
                                                                                </td>
                                                                                <td>
                                                                                    <form action="indicadoresGestionarAplicar" method="POST" enctype="multipart/form-data">
                                                                                        <input name="anoPresente" value="<?php echo $anoPresente; ?>" readonly type="hidden">
                                                                                        <input name="mes" readonly type="hidden" value="<?php echo $mostrarMes; ?>">
                                                                                        <input name="variablesIdPrincipal" type="hidden" value="<?php echo $variablesIdPrincipal; ?>">
                                                                                        <button class='btn btn-success btn-sm'>Aplicar</button>
                                                                                    </form>
                                                                                </td>
                                                       
                                                         </tr>
                                                           <?
                                                       }
                                                       /// END
                                                   }
                                                   if($frecuenciaIndicador == 'Semestral'){
                                                       /// construccion de los meses
                                                       for($i=$mesDesde; $i<=$mesActualValidado; $i+=6){
                                                          $i;
                                                           
                                                           if($i == '1'){
                                                               $mostrarMes='Enero';
                                                           }
                                                           if($i == '2'){
                                                               $mostrarMes='Febrero';
                                                           }
                                                           if($i == '3'){
                                                               $mostrarMes='Marzo';
                                                           }
                                                           if($i == '4'){
                                                               $mostrarMes='Abril';
                                                           }
                                                           if($i == '5'){
                                                               $mostrarMes='Mayo';
                                                           }
                                                           if($i == '6'){
                                                               $mostrarMes='Junio';
                                                           }
                                                           if($i == '7'){
                                                               $mostrarMes='Julio';
                                                           }
                                                           if($i == '8'){
                                                               $mostrarMes='Agosto';
                                                           }
                                                           if($i == '9'){
                                                               $mostrarMes='Septiembre';
                                                           }
                                                           if($i == '10'){
                                                               $mostrarMes='Octubre';
                                                           }
                                                           if($i == '11'){
                                                               $mostrarMes='Noviembre';
                                                           }
                                                           if($i == '12'){
                                                               $mostrarMes='Diciembre';
                                                           }
                                                           ?>
                                                              <tr>
                                                           
                                                                                <td data-titulo="Fecha" >
                                                                                <?php
                                                                                   echo '<center>Mes de <b>'.$mostrarMes;
                                                                                   echo'</b> del año <b>'.$anoPresente.'</b></center>';
                                                                                ?>
                                                                                
                                                                                </td>
                                                                                <td data-titulo="Formula">
                                                                                   <?php echo '<b>'.$saleIndicadorFormula.'</b>'; ?>
                                                                                </td>
                                                                                 <td data-titulo="Resultado">
                                                                                   <?php
                                                                                        echo '<b>'; 
                                                                                        $consultarMeta=$mysqli->query("SELECT * FROM `indicadores` WHERE id='$variablesIdPrincipal' ");
                                                                                                 $extraerMEta=$consultarMeta->fetch_array(MYSQLI_ASSOC);
                                                                                                  '<b>Sentido:</b> '.$sentidoIndicador=$extraerMEta['sentido'];
                                                                                                 $formulaAlimentada=$extraerMEta['alimentado'];
                                                                                                 
                                                                                                $ultimoIndicadoMes=$mysqli->query("SELECT * FROM `indicadoresGestionar` WHERE idIndicador='$variablesIdPrincipal' AND mes='$mostrarMes' AND anoPresente='$anoPresente' GROUP BY mes ");
                                                                                                $extraeDatoIndicadorMes= $ultimoIndicadoMes->fetch_array(MYSQLI_ASSOC);
                                                                                                 '<br>resultado: '.$DatoAlimentado=$extraeDatoIndicadorMes['alimentado'];
                                                                                                 //$resultadoEnero=$extraeDatoIndicadorMes['alimentado'];
                                                                                                 
                                                                                                 $consultarMeta=$mysqli->query("SELECT * FROM `indicadoresMetas` WHERE idIndicador='$variablesIdPrincipal' AND anoPresente='$anoPresente' ");
                                                                                                 $extraerMEta=$consultarMeta->fetch_array(MYSQLI_ASSOC);
                                                                                                  ' <b>meta:</b> '.$metaFormula=$extraerMEta['metaActual'];
                                                                                                  $metaFormulaUnidad=$extraerMEta['unidad'];
                                                                                                 
                                                                                                 
                                                                                                  //// si el sentido de la meta viene positivo
                                                                                                  if($sentidoIndicador == 'Positivo'){
                                                                                                      
                                                                                                    if($DatoAlimentado > $metaFormula ){ 
                                                                                                      echo '<font style="background:blue;color:white;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                    if($DatoAlimentado <= $metaFormula && $DatoAlimentado > $extraerMEta['za']){
                                                                                                      echo '<font style="background:green;color:white;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }  
                                                                                                    if($DatoAlimentado <= $extraerMEta['za'] && $DatoAlimentado > $extraerMEta['zp']){
                                                                                                      echo '<font style="background:yellow;color:black;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                    if($DatoAlimentado <= $extraerMEta['zp']){
                                                                                                      echo '<font style="background:red;color:white;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                  
                                                                                                      
                                                                                                  }
                                                                                                  
                                                                                                  if($sentidoIndicador == 'Negativo'){
                                                                                                      
                                                                                                    if($DatoAlimentado < $metaFormula ){ 
                                                                                                      echo '<font style="background:blue;color:white;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                    if($DatoAlimentado >= $metaFormula && $DatoAlimentado < $extraerMEta['za']){
                                                                                                      echo '<font style="background:green;color:white;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                    if($DatoAlimentado == $extraerMEta['za'] && $DatoAlimentado < $extraerMEta['zp']){
                                                                                                      echo '<font style="background:yellow;color:black;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                    if($DatoAlimentado >= $extraerMEta['zp']){
                                                                                                      echo '<font style="background:red;color:white;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                  }
                                                                                                  
                                                                                                  
                                                                                                  //// END
                                                                                        echo '</b>';
                                                                                   ?>
                                                                                </td>
                                                                                <td data-titulo="Meta">
                                                                                  <?php echo '<b>'.$saleIndicadorMeta.'</b>'; ?>
                                                                                </td>
                                                                              
                                                                                
                                                                                <td data-titulo="Análisis" align="left">
                                                                                    <?php
                                                                                       //// se trae los archivos
                                                                                       $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                                                       $indicadorArchivos=$mysqli->query("SELECT * FROM `indicadoresGestionar` WHERE idIndicador='$variablesIdPrincipal' AND mes='$mostrarMes' AND anoPresente='$anoPresente' ");
                                                                                       while($extraeDatoIndicadorArchivos= $indicadorArchivos->fetch_array()){
                                                                                       
                                                                                        $nombreDocumento=$extraeDatoIndicadorArchivos['documento'];
                                                                                        $ruta=$extraeDatoIndicadorArchivos['soporte'];
                                                                                        if($ruta != NULL){
                                                                                        echo"
                                                                                          
                                                                                            <i class='fas fa-download'></i>
                                                                                            <a style='color:black' href='$ruta' download='' target='_blank'>$nombreDocumento</a>
                                                                                        
                                                                                        <br>";
                                                                                       
                                                                                       }
                                                                                       }
                                                                                       //// END
                                                                                        echo '<br>Análisis:<br>';
                                                                                       $indicadorArchivos=$mysqli->query("SELECT * FROM `indicadoresGestionar` WHERE idIndicador='$variablesIdPrincipal' AND mes='$mostrarMes' AND anoPresente='$anoPresente' ");
                                                                                       while($extraeDatoIndicadorArchivos= $indicadorArchivos->fetch_array()){
                                                                                       
                                                                                        $nombreDocumento=$extraeDatoIndicadorArchivos['documento'];
                                                                                        $ruta=$extraeDatoIndicadorArchivos['soporte'];
                                                                                        $analisisComentario=$extraeDatoIndicadorArchivos['analisis'];
                                                                                        if($analisisComentario != NULL){
                                                                                            echo '<b>*</b> '.$analisisComentario.'<br>';
                                                                                        }
                                                                                        
                                                                                        }
                                                                                       //// END
                                                                                    ?>
                                                                                  <form action="controlador/indicadores/controllerGestionar" method="POST" enctype="multipart/form-data">
                                                                                        <input name="anoPresente" value="<?php echo $anoPresente; ?>" readonly type="hidden">
                                                                                        <input name="mes" readonly type="hidden" value="<?php echo $mostrarMes; ?>">
                                                                                        <textarea name="analisis" class="form-control"></textarea>
                                                                                        <input name="nombre" type="hidden" value="<?php echo $nombreIndicador; ?>" readonly>
                                                                                        <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden">
                                                                                        <input name="variablesIdPrincipal" value="<?php echo $variablesIdPrincipal; ?>" type="hidden">
                                                                                       <!-- <input class='btn btn-sm' style="background:gray;color:white;" type="file" name="soporte">-->
                                                                                        
                                                                                        <label for="upload-photo">Archivo:</label>
                                                                                          <div class="input-group">
                                                                                            <div class="custom-file">
                                                                                            <input type="file" class="custom-file-input" name="soporte"  >
                                                                                            <label class="custom-file-label" >Subir Archivo</label>
                                                                                            
                                                                                          </div>
                                                                                         </div>
                                                                                        <br>
                                                                                        <button class='btn btn-info btn-sm'>Agregar</button>
                                                                                    </form>
                                                                                </td>
                                                                                <td>
                                                                                    <form action="indicadoresGestionarAplicar" method="POST" enctype="multipart/form-data">
                                                                                        <input name="anoPresente" value="<?php echo $anoPresente; ?>" readonly type="hidden">
                                                                                        <input name="mes" readonly type="hidden" value="<?php echo $mostrarMes; ?>">
                                                                                        <input name="variablesIdPrincipal" type="hidden" value="<?php echo $variablesIdPrincipal; ?>">
                                                                                        <button class='btn btn-success btn-sm'>Aplicar</button>
                                                                                    </form>
                                                                                </td>
                                                       
                                                         </tr>
                                                           <?
                                                       }
                                                       /// END
                                                   }
                                                   if($frecuenciaIndicador == 'Anual'){
                                                       /// construccion de los meses
                                                       for($i=$mesDesde; $i<=$mesActualValidado; $i+=12){
                                                          $i;
                                                           
                                                           if($i == '1'){
                                                               $mostrarMes='Enero';
                                                           }
                                                           if($i == '2'){
                                                               $mostrarMes='Febrero';
                                                           }
                                                           if($i == '3'){
                                                               $mostrarMes='Marzo';
                                                           }
                                                           if($i == '4'){
                                                               $mostrarMes='Abril';
                                                           }
                                                           if($i == '5'){
                                                               $mostrarMes='Mayo';
                                                           }
                                                           if($i == '6'){
                                                               $mostrarMes='Junio';
                                                           }
                                                           if($i == '7'){
                                                               $mostrarMes='Julio';
                                                           }
                                                           if($i == '8'){
                                                               $mostrarMes='Agosto';
                                                           }
                                                           if($i == '9'){
                                                               $mostrarMes='Septiembre';
                                                           }
                                                           if($i == '10'){
                                                               $mostrarMes='Octubre';
                                                           }
                                                           if($i == '11'){
                                                               $mostrarMes='Noviembre';
                                                           }
                                                           if($i == '12'){
                                                               $mostrarMes='Diciembre';
                                                           }
                                                           ?>
                                                               <tr>
                                                           
                                                                                <td data-titulo="Fecha" >
                                                                                <?php
                                                                                   echo '<center>Mes de <b>'.$mostrarMes;
                                                                                   echo'</b> del año <b>'.$anoPresente.'</b></center>';
                                                                                ?>
                                                                                
                                                                                </td>
                                                                                <td data-titulo="Formula">
                                                                                   <?php echo '<b>'.$saleIndicadorFormula.'</b>'; ?>
                                                                                </td>
                                                                                 <td data-titulo="Resultado">
                                                                                   <?php
                                                                                        echo '<b>'; 
                                                                                        $consultarMeta=$mysqli->query("SELECT * FROM `indicadores` WHERE id='$variablesIdPrincipal' ");
                                                                                                 $extraerMEta=$consultarMeta->fetch_array(MYSQLI_ASSOC);
                                                                                                  '<b>Sentido:</b> '.$sentidoIndicador=$extraerMEta['sentido'];
                                                                                                 $formulaAlimentada=$extraerMEta['alimentado'];
                                                                                                 
                                                                                                $ultimoIndicadoMes=$mysqli->query("SELECT * FROM `indicadoresGestionar` WHERE idIndicador='$variablesIdPrincipal' AND mes='$mostrarMes' AND anoPresente='$anoPresente' GROUP BY mes ");
                                                                                                $extraeDatoIndicadorMes= $ultimoIndicadoMes->fetch_array(MYSQLI_ASSOC);
                                                                                                 '<br>resultado: '.$DatoAlimentado=$extraeDatoIndicadorMes['alimentado'];
                                                                                                 //$resultadoEnero=$extraeDatoIndicadorMes['alimentado'];
                                                                                                 
                                                                                                 $consultarMeta=$mysqli->query("SELECT * FROM `indicadoresMetas` WHERE idIndicador='$variablesIdPrincipal' AND anoPresente='$anoPresente' ");
                                                                                                 $extraerMEta=$consultarMeta->fetch_array(MYSQLI_ASSOC);
                                                                                                  ' <b>meta:</b> '.$metaFormula=$extraerMEta['metaActual'];
                                                                                                  $metaFormulaUnidad=$extraerMEta['unidad'];
                                                                                                 
                                                                                                 
                                                                                                  //// si el sentido de la meta viene positivo
                                                                                                  if($sentidoIndicador == 'Positivo'){
                                                                                                      
                                                                                                    if($DatoAlimentado > $metaFormula ){ 
                                                                                                      echo '<font style="background:blue;color:white;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                    if($DatoAlimentado <= $metaFormula && $DatoAlimentado > $extraerMEta['za']){
                                                                                                      echo '<font style="background:green;color:white;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }  
                                                                                                    if($DatoAlimentado <= $extraerMEta['za'] && $DatoAlimentado > $extraerMEta['zp']){
                                                                                                      echo '<font style="background:yellow;color:black;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                    if($DatoAlimentado <= $extraerMEta['zp']){
                                                                                                      echo '<font style="background:red;color:white;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                  
                                                                                                      
                                                                                                  }
                                                                                                  
                                                                                                  if($sentidoIndicador == 'Negativo'){
                                                                                                      
                                                                                                    if($DatoAlimentado < $metaFormula ){ 
                                                                                                      echo '<font style="background:blue;color:white;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                    if($DatoAlimentado >= $metaFormula && $DatoAlimentado < $extraerMEta['za']){
                                                                                                      echo '<font style="background:green;color:white;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                    if($DatoAlimentado == $extraerMEta['za'] && $DatoAlimentado < $extraerMEta['zp']){
                                                                                                      echo '<font style="background:yellow;color:black;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                    if($DatoAlimentado >= $extraerMEta['zp']){
                                                                                                      echo '<font style="background:red;color:white;">'.$DatoAlimentado.' '.$metaFormulaUnidad.'</font><br>';
                                                                                                    }
                                                                                                  }
                                                                                                  
                                                                                                  
                                                                                                  //// END
                                                                                        echo '</b>';
                                                                                   ?>
                                                                                </td>
                                                                                <td data-titulo="Meta">
                                                                                  <?php echo '<b>'.$saleIndicadorMeta.'</b>'; ?>
                                                                                </td>
                                                                              
                                                                                
                                                                                <td data-titulo="Análisis" align="left">
                                                                                    <?php
                                                                                       //// se trae los archivos
                                                                                       $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                                                       $indicadorArchivos=$mysqli->query("SELECT * FROM `indicadoresGestionar` WHERE idIndicador='$variablesIdPrincipal' AND mes='$mostrarMes' AND anoPresente='$anoPresente' ");
                                                                                       while($extraeDatoIndicadorArchivos= $indicadorArchivos->fetch_array()){
                                                                                       
                                                                                        $nombreDocumento=$extraeDatoIndicadorArchivos['documento'];
                                                                                        $ruta=$extraeDatoIndicadorArchivos['soporte'];
                                                                                        if($ruta != NULL){
                                                                                        echo"
                                                                                          
                                                                                            <i class='fas fa-download'></i>
                                                                                            <a style='color:black' href='$ruta' download='' target='_blank'>$nombreDocumento</a>
                                                                                        
                                                                                        <br>";
                                                                                       
                                                                                       }
                                                                                       }
                                                                                       //// END
                                                                                        echo '<br>Análisis:<br>';
                                                                                       $indicadorArchivos=$mysqli->query("SELECT * FROM `indicadoresGestionar` WHERE idIndicador='$variablesIdPrincipal' AND mes='$mostrarMes' AND anoPresente='$anoPresente' ");
                                                                                       while($extraeDatoIndicadorArchivos= $indicadorArchivos->fetch_array()){
                                                                                       
                                                                                        $nombreDocumento=$extraeDatoIndicadorArchivos['documento'];
                                                                                        $ruta=$extraeDatoIndicadorArchivos['soporte'];
                                                                                        $analisisComentario=$extraeDatoIndicadorArchivos['analisis'];
                                                                                        if($analisisComentario != NULL){
                                                                                            echo '<b>*</b> '.$analisisComentario.'<br>';
                                                                                        }
                                                                                        
                                                                                        }
                                                                                       //// END
                                                                                    ?>
                                                                                  <form action="controlador/indicadores/controllerGestionar" method="POST" enctype="multipart/form-data">
                                                                                        <input name="anoPresente" value="<?php echo $anoPresente; ?>" readonly type="hidden">
                                                                                        <input name="mes" readonly type="hidden" value="<?php echo $mostrarMes; ?>">
                                                                                        <textarea name="analisis" class="form-control"></textarea>
                                                                                        <input name="nombre" type="hidden" value="<?php echo $nombreIndicador; ?>" readonly>
                                                                                        <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden">
                                                                                        <input name="variablesIdPrincipal" value="<?php echo $variablesIdPrincipal; ?>" type="hidden">
                                                                                       <!-- <input class='btn btn-sm' style="background:gray;color:white;" type="file" name="soporte">-->
                                                                                        
                                                                                        <label for="upload-photo">Archivo:</label>
                                                                                          <div class="input-group">
                                                                                            <div class="custom-file">
                                                                                            <input type="file" class="custom-file-input" name="soporte"  >
                                                                                            <label class="custom-file-label" >Subir Archivo</label>
                                                                                            
                                                                                          </div>
                                                                                         </div>
                                                                                        <br>
                                                                                        <button class='btn btn-info btn-sm'>Agregar</button>
                                                                                    </form>
                                                                                </td>
                                                                                <td>
                                                                                    <form action="indicadoresGestionarAplicar" method="POST" enctype="multipart/form-data">
                                                                                        <input name="anoPresente" value="<?php echo $anoPresente; ?>" readonly type="hidden">
                                                                                        <input name="mes" readonly type="hidden" value="<?php echo $mostrarMes; ?>">
                                                                                        <input name="variablesIdPrincipal" type="hidden" value="<?php echo $variablesIdPrincipal; ?>">
                                                                                        <button class='btn btn-success btn-sm'>Aplicar</button>
                                                                                    </form>
                                                                                </td>
                                                       
                                                         </tr>
                                                           <?
                                                       }
                                                       /// END
                                                   }
                                                   //// END
                                           
                                            
                                            }else{
                                                echo '<font color="red">El año máximo del indicador ya caduco</font>';
                                            }   ///// END validación del los años
                                              */
                                            ?>
                                
                              </tbody>
                            </table>
                </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    
    
        <section class="content">
              <div class="container-fluid">
                <!-- /.row -->
                <div class="row">
                  <div class="col-12">
                    <div class="card">
                        <h3 class="card-title">Resultado consolidado</h3>
                          <!-- <a href="javascript:void(0);">Ver reporte</a> -->
                        <!-- responsive para las graficas  -->
                        <style type="text/css">
                            *{
                                box-sizing: border-box;
                            }
                            .gallery{
                                border:0px solid #ccc;
                            }
                            .gallery img{
                                width: 100%;
                                height: auto;
                            }
                            .des{
                                padding: 15px;
                                text-align: center;
                            }
                            .responsive{
                                padding: 0 6px;
                                float: left;
                                width: 40%;
                            }
                            @media only screen and (max-width: 700px){
                                .responsive{
                                    width: 50%;
                                    margin: 6px 0;
                                }
                            }
                            @media only screen and (max-width: 500px){
                                .responsive{
                                    width: 100%;
                                }
                            }
                        </style>
                        <!-- END -->
    	
    	
                        <!-- /.d-flex -->
                        <?php
                        $graficaSelect=$_POST['tipoGrafica'];
                        ////// titulo principal
                        $tituloPrincipal=$_POST['tituloPrincipal'];
                        ////// colores
                        /*
                        if($_POST['color1'] != NULL || $_POST['color2'] != NULL || $_POST['color3'] != NULL){
                            $color1=$_POST['color1'];
                            $color2=$_POST['color2'];
                            $color3=$_POST['color3'];
                       
                        }else{
                            $color1='#e21212';
                            $color2='#1522e0';
                            $color3='#08d90f';
                        } */
                        
                        
                        ///// titulos
                        /*
                        $titulo1=$_POST['titulo1'];
                        $titulo2=$_POST['titulo2'];
                        $titulo3=$_POST['titulo3'];
                        */
                        ///// datos
                        $datos1=$_POST['dato1'];
                        $datos2=$_POST['dato2'];
                        $datos3=$_POST['dato3'];
                        
                       //// usamos está consulta para imprimir los resultados de las graficas
                        $consultarParaGraficar=$mysqli->query("SELECT * FROM indicadoresGestionar WHERE idIndicador='$variablesIdPrincipal' AND mes='Enero' AND anoPresente='$anoPresente'  GROUP BY mes ");
                        $imprimirGrafica=$consultarParaGraficar->fetch_array(MYSQLI_ASSOC);
                        $resultadoEner=$imprimirGrafica['alimentado'];
                        if($resultadoEner != NULL){$resultadoEnero=$resultadoEner;}else{ $resultadoEnero='0'; }
                        $consultarParaGraficar2=$mysqli->query("SELECT * FROM indicadoresGestionar WHERE idIndicador='$variablesIdPrincipal' AND mes='Febrero' AND anoPresente='$anoPresente'  GROUP BY mes ");
                        $imprimirGrafica2=$consultarParaGraficar2->fetch_array(MYSQLI_ASSOC);
                        $resultadoFebrer=$imprimirGrafica2['alimentado'];
                        if($resultadoFebrer != NULL){$resultadoFebrero=$resultadoFebrer;}else{ $resultadoFebrero='0'; }
                        $consultarParaGraficar3=$mysqli->query("SELECT * FROM indicadoresGestionar WHERE idIndicador='$variablesIdPrincipal' AND mes='Marzo' AND anoPresente='$anoPresente'  GROUP BY mes ");
                        $imprimirGrafica3=$consultarParaGraficar3->fetch_array(MYSQLI_ASSOC);
                        $resultadoMarz=$imprimirGrafica3['alimentado'];
                        if($resultadoMarz != NULL){$resultadoMarzo=$resultadoMarz;}else{ $resultadoMarzo='0'; }
                        $consultarParaGraficar4=$mysqli->query("SELECT * FROM indicadoresGestionar WHERE idIndicador='$variablesIdPrincipal' AND mes='Abril' AND anoPresente='$anoPresente'  GROUP BY mes ");
                        $imprimirGrafica4=$consultarParaGraficar4->fetch_array(MYSQLI_ASSOC);
                        $resultadoAbri=$imprimirGrafica4['alimentado'];
                        if($resultadoAbri != NULL){$resultadoAbril=$resultadoAbri;}else{ $resultadoAbril='0'; }
                        $consultarParaGraficar5=$mysqli->query("SELECT * FROM indicadoresGestionar WHERE idIndicador='$variablesIdPrincipal' AND mes='Mayo' AND anoPresente='$anoPresente'  GROUP BY mes ");
                        $imprimirGrafica5=$consultarParaGraficar5->fetch_array(MYSQLI_ASSOC);
                        $resultadoMay=$imprimirGrafica5['alimentado'];
                        if($resultadoMay != NULL){$resultadoMayo=$resultadoMay;}else{ $resultadoMayo='0'; }
                        $consultarParaGraficar6=$mysqli->query("SELECT * FROM indicadoresGestionar WHERE idIndicador='$variablesIdPrincipal' AND mes='Junio' AND anoPresente='$anoPresente'  GROUP BY mes ");
                        $imprimirGrafica6=$consultarParaGraficar6->fetch_array(MYSQLI_ASSOC);
                        $resultadoJuni=$imprimirGrafica6['alimentado'];
                        if($resultadoJuni > NULL){$resultadoJunio=$resultadoJuni;}else{ $resultadoJunio='0'; }
                        $consultarParaGraficar7=$mysqli->query("SELECT * FROM indicadoresGestionar WHERE idIndicador='$variablesIdPrincipal' AND mes='Julio' AND anoPresente='$anoPresente'  GROUP BY mes ");
                        $imprimirGrafica7=$consultarParaGraficar7->fetch_array(MYSQLI_ASSOC);
                        $resultadoJuli=$imprimirGrafica7['alimentado'];
                        if($resultadoJuli != NULL){$resultadoJulio=$resultadoJuli;}else{ $resultadoJulio='0'; }
                        $consultarParaGraficar8=$mysqli->query("SELECT * FROM indicadoresGestionar WHERE idIndicador='$variablesIdPrincipal' AND mes='Agosto' AND anoPresente='$anoPresente'  GROUP BY mes ");
                        $imprimirGrafica8=$consultarParaGraficar8->fetch_array(MYSQLI_ASSOC);
                        $resultadoAgot=$imprimirGrafica8['alimentado'];
                        if($resultadoAgot != NULL){$resultadoAgoto=$resultadoAgot;}else{ $resultadoAgoto='0'; }
                        $consultarParaGraficar9=$mysqli->query("SELECT * FROM indicadoresGestionar WHERE idIndicador='$variablesIdPrincipal' AND mes='Septiembre' AND anoPresente='$anoPresente'  GROUP BY mes ");
                        $imprimirGrafica9=$consultarParaGraficar9->fetch_array(MYSQLI_ASSOC);
                        $resultadoSeptiembr=$imprimirGrafica9['alimentado'];
                        if($resultadoSeptiembr != NULL){$resultadoSeptiembre=$resultadoSeptiembr;}else{ $resultadoSeptiembre='0'; }
                        $consultarParaGraficar10=$mysqli->query("SELECT * FROM indicadoresGestionar WHERE idIndicador='$variablesIdPrincipal' AND mes='Octubre' AND anoPresente='$anoPresente'  GROUP BY mes ");
                        $imprimirGrafica10=$consultarParaGraficar10->fetch_array(MYSQLI_ASSOC);
                        $resultadoOctubr=$imprimirGrafica10['alimentado'];
                        if($resultadoOctubr != NULL){$resultadoOctubre=$resultadoOctubr;}else{ $resultadoOctubre='0'; }
                        $consultarParaGraficar11=$mysqli->query("SELECT * FROM indicadoresGestionar WHERE idIndicador='$variablesIdPrincipal' AND mes='Noviembre' AND anoPresente='$anoPresente'  GROUP BY mes ");
                        $imprimirGrafica11=$consultarParaGraficar11->fetch_array(MYSQLI_ASSOC);
                        $resultadoNoviembr=$imprimirGrafica11['alimentado'];
                        if($resultadoNoviembr != NULL){$resultadoNoviembre=$resultadoNoviembr;}else{ $resultadoNoviembre='0'; }
                        $consultarParaGraficar12=$mysqli->query("SELECT * FROM indicadoresGestionar WHERE idIndicador='$variablesIdPrincipal' AND mes='Diciembre' AND anoPresente='$anoPresente'  GROUP BY mes ");
                        $imprimirGrafica12=$consultarParaGraficar12->fetch_array(MYSQLI_ASSOC);
                        $resultadoDiciembr=$imprimirGrafica12['alimentado'];
                        if($resultadoDiciembr != NULL){$resultadoDiciembre=$resultadoDiciembr;}else{ $resultadoDiciembre='0'; }
                        //// END
                        
                        ?>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <!-- AREA CHART -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="areaChart" style="height:250px; min-height:250px"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- DONUT CHART -->
            <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title"></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <canvas id="donutChart" style="height:230px; min-height:230px"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- PIE CHART -->
            <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title"></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <canvas id="pieChart" style="height:230px; min-height:230px"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
          <!-- /.col (LEFT) -->
          <div class="col-md-6">
            <!-- LINE CHART -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title"></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="lineChart" style="height:250px; min-height:250px"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- BAR CHART -->
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title"></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="barChart" style="height:230px; min-height:230px"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- STACKED BAR CHART -->
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title"></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="stackedBarChart" style="height:230px; min-height:230px"></canvas>
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
                        
                        
<script>
                        
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

    var areaChartData = {
      labels  : ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE'],
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
           data:[<?php echo $resultadoEnero; ?>,<?php echo $resultadoFebrero; ?>,<?php echo $resultadoMarzo; ?>,<?php echo $resultadoAbril; ?>,<?php echo $resultadoMayo; ?>,<?php echo $resultadoJunio; ?>,<?php echo $resultadoJulio; ?>,<?php echo $resultadoAgoto; ?>,<?php echo $resultadoSeptiembre; ?>,<?php echo $resultadoOctubre; ?>,<?php echo $resultadoNoviembre; ?>,<?php echo $resultadoDiciembre; ?>]
        },
        {
          label               : '',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
           data:[<?php echo $resultadoEnero; ?>,<?php echo $resultadoFebrero; ?>,<?php echo $resultadoMarzo; ?>,<?php echo $resultadoAbril; ?>,<?php echo $resultadoMayo; ?>,<?php echo $resultadoJunio; ?>,<?php echo $resultadoJulio; ?>,<?php echo $resultadoAgoto; ?>,<?php echo $resultadoSeptiembre; ?>,<?php echo $resultadoOctubre; ?>,<?php echo $resultadoNoviembre; ?>,<?php echo $resultadoDiciembre; ?>]
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
          }
        }]
      }
    }

    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(areaChartCanvas, { 
      type: 'line',
      data: areaChartData, 
      options: areaChartOptions
    })

    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
    var lineChartOptions = jQuery.extend(true, {}, areaChartOptions)
    var lineChartData = jQuery.extend(true, {}, areaChartData)
    lineChartData.datasets[0].fill = false;
    lineChartData.datasets[1].fill = false;
    lineChartOptions.datasetFill = false

    var lineChart = new Chart(lineChartCanvas, { 
      type: 'line',
      data: lineChartData, 
      options: lineChartOptions
    })

    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData        = {
      labels  : ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE'],
      datasets: [
        {
          data:[<?php echo $resultadoEnero; ?>,<?php echo $resultadoFebrero; ?>,<?php echo $resultadoMarzo; ?>,<?php echo $resultadoAbril; ?>,<?php echo $resultadoMayo; ?>,<?php echo $resultadoJunio; ?>,<?php echo $resultadoJulio; ?>,<?php echo $resultadoAgoto; ?>,<?php echo $resultadoSeptiembre; ?>,<?php echo $resultadoOctubre; ?>,<?php echo $resultadoNoviembre; ?>,<?php echo $resultadoDiciembre; ?>],
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de','#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var donutChart = new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions      
    })

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = donutData;
    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var pieChart = new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions      
    })

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = jQuery.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    var barChart = new Chart(barChartCanvas, {
      type: 'bar', 
      data: barChartData,
      options: barChartOptions
    })

    //---------------------
    //- STACKED BAR CHART -
    //---------------------
    var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
    var stackedBarChartData = jQuery.extend(true, {}, barChartData)

    var stackedBarChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      scales: {
        xAxes: [{
          stacked: true,
        }],
        yAxes: [{
          stacked: true
        }]
      }
    }

    var stackedBarChart = new Chart(stackedBarChartCanvas, {
      type: 'bar', 
      data: stackedBarChartData,
      options: stackedBarChartOptions
    })
  })
</script>
                        
                        
                        </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
          
          
  </div>
  <!-- /.content-wrapper -->
<?php echo require_once'footer.php'; ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>

<script>
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()
</script>
<!-- Select2 -->
<script src="../plugins/select2/js/select2.full.min.js"></script>
<!-- Page script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })
    
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

  })
</script>
<script>
    $(document).ready(function(){
        $('#rad_cargoRI').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoRI").html(data);
            }); 
        });
        $('#rad_usuarioRI').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoRI").html(data);
            }); 
        });
    });
</script>
<script>
    $(document).ready(function(){
        $('#rad_cargoC').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoC").html(data);
            }); 
        });
        $('#rad_usuarioC').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoC").html(data);
            }); 
        });
    });
</script>
<script>
    $(document).ready(function(){
        $('#rad_cargoAut').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoAut").html(data);
            }); 
        });
        $('#rad_usuarioAut').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoAut").html(data);
            }); 
        });
    });
</script>
<!-- para mostrar el archivo seleccionado en el file -->
<script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
<!-- END -->
    

<!--<script src="../dist/js/pages/dashboard3.js"></script>-->
</body>
</html>
<?php
}
?>