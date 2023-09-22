<?php error_reporting(E_ERROR);
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
  <!-- se comenta porque nos sale el cargar en ingles 
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  -->
  <!-- EDN -->
</head>
<script>
   	
    function nobackbutton(){
    	
       window.location.hash="no-back-button";
    	
       window.location.hash="Again-No-back-button" //chrome
    	
       window.onhashchange=function(){window.location.hash="no-back-button";}
    	
    }
</script>
<body class="hold-transition sidebar-mini" onload="nobackbutton();" oncopy="return false" onpaste="return false" >
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
                                $sentidoIndicadorPrincipal=$extraeDatoIndicador['sentido'];
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
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
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
                                
                                <textarea type="text" style="border-color:white;" cols="30%" rows="5" name="nombre" readonly autocomplete="off" onkeypress="return ( (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 ||  event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218 || (event.charCode >= 48 && event.charCode <= 57) || event.charCode == 46 || event.charCode == 44 )" required><?php echo $descripcionIndicador; ?></textarea>
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
                                <?php echo $extraeDatoIndicador['desdeMostrar'];//$indicadorDesde; ?>
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
                                <label>Restricción:</label><br>
                                <?php echo $restrincionIndicador; ?>
                                <!--<input type="text" class="form-control" value="" name="tituloPrincipal" placeholder="Gráfico" required>-->
                             </div>
                             <div class="form-group col-sm-3">
                                <label>Sentido:</label><br>
                                <?php echo $sentidoIndicadorPrincipal; ?>
                                <!--<input type="text" class="form-control" value="" name="tituloPrincipal" placeholder="Gráfico" required>-->
                             </div>
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
                                                <b>Fecha desde: <?php echo $extraeDatoIndicador['desdeMostrar']; ?>, Fecha hasta: <?php echo $indicadorHasta;?></b>
                                            </th>
                                            <th>
                                                <b>Fórmula</b>
                                            </th>
                                            <th>
                                                <b>Resultado</b>
                                            </th>
                                            <th>
                                                <b>Fórmula aplicada</b>
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
                                                $mesActualValidado=date('Y-m-j'); //$mesActual
                                            }
                                            date('Y-m-j');
                                            '--'.$indicadorDesde;
                                           
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
                                           
                                if($indicadorDesde > date('Y-m-j') && $formulaRestrincion == 'Si'){  
                                    /// si el mes del rango desde, es superior al mes actual y viene por restricción, no debe mostrarme nada         
                                }else{
                                    if($validandoAñoMaximo >= $anoPresente){  ///// comparamos que el año sea igual o mayor al presente, si la fecha máxima del indicador es menor al año presente no debe pintar los meses
                                         
                                         //// actualzición      
                                           $indicadorDesde=date("d-m-Y",strtotime($indicadorDesde."- $numeroMeses month"));
                                         /// end
                                        $contandoVaidacinArchivo=0;
                                        $contandoVaidacinArchivoB=0;
                                        for($i=1; $i<=$totalMEsesConteo+1; $i++){  // actualización FOR
                                             
                                            '<br><br>---'.$indicadorDesde=date("d-m-Y",strtotime($indicadorDesde."+ $numeroMeses month")); // se cambia la frecuencia por mensual, bimensual, trimensual,semestrual, anual.
                                            '<br>';
                                            'dato: '.$enviarMeses=intval(substr($indicadorDesde, 3, 2));  /// para sacar el número del mes y encontrar el nombre del mes
                                             
                                             setlocale(LC_ALL, 'es_ES');
                                             $monthNum  = $enviarMeses;
                                             $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                             $mostrarMes = strftime('%B', $dateObj->getTimestamp());
                                             //setlocale(LC_TIME, "es_ES");
                                              '--<b>'.$mostrarMes.'</b><br>';  /// enviar este dato aplicar formula, comentarios, metas,documentos....
                                              
                                              
                                           
                                    ?> 
                                     <tr>
                                                               
                                                                                    <td data-titulo="Fecha" >
                                                                                    <?php
                                                                                    $anoPresente=intval(substr($indicadorDesde, 6, 4));
                                                                                       echo '<center>Mes <b>'.$mostrarMes;
                                                                                       echo'</b>, del año <b>'.$anoPresente.'</b></center>'; //$anoPresente
                                                                                    ?>
                                                                                    
                                                                                    </td>
                                                                                    <td data-titulo="Fórmula">
                                                                                       <?php echo '<b>'.$saleIndicadorFormula.'</b>'; ?>
                                                                                    </td>
                                                                                     <td data-titulo="Resultado">
                                                                                       <?php
                                                                                            echo '<b>'; 
                                                                                            $consultarMeta=$mysqli->query("SELECT * FROM `indicadores` WHERE id='$variablesIdPrincipal' ");
                                                                                                     $extraerMEta=$consultarMeta->fetch_array(MYSQLI_ASSOC);
                                                                                                       '<b>Sentido:</b> '.$sentidoIndicador=$extraerMEta['sentido'];
                                                                                                     $formulaAlimentada=$extraerMEta['alimentado'];
                                                                                                     
                                                                                                    $ultimoIndicadoMes=$mysqli->query("SELECT * FROM `indicadoresGestionar` WHERE idIndicador='$variablesIdPrincipal' AND mes='$mostrarMes' AND anoPresente='$anoPresente' AND alimentado IS not NULL GROUP BY mes ");
                                                                                                    $extraeDatoIndicadorMes= $ultimoIndicadoMes->fetch_array(MYSQLI_ASSOC);
                                                                                                      '<br>resultado: '.$DatoAlimentado=$extraeDatoIndicadorMes['alimentado'];
                                                                                                      if($extraeDatoIndicadorMes['datosFormula'] != NULL){
                                                                                                        $formulaAplicada=$extraeDatoIndicadorMes['datosFormula'];
                                                                                                      }else{
                                                                                                        $formulaAplicada='---';
                                                                                                      }
                                                                                                      
                                                                                                     //$resultadoEnero=$extraeDatoIndicadorMes['alimentado'];
                                                                                                      '<br><b>'.$variablesIdPrincipal.'</b>';
                                                                                                      
                                                                                                      $originalDate =$indicadorDesde;
                                                                                                    $newDate = date("Y-m-j", strtotime($originalDate));
                                                                                                    //SELECT * FROM `indicadoresMetas` WHERE idIndicador='$variablesIdPrincipal' AND anoPresente='$anoPresente' 
                                                                                                     $consultarMeta=$mysqli->query("SELECT * FROM `indicadoresMetas` WHERE  hasta >= '$newDate' AND idIndicador='$variablesIdPrincipal' ");
                                                                                                     $extraerMEta=$consultarMeta->fetch_array(MYSQLI_ASSOC);
                                                                                                        ' <b>meta:</b> '.$metaFormula=$extraerMEta['metaActual']; 
                                                                                                      $metaFormulaUnidad=$extraerMEta['unidad'];
                                                                                                     
                                                                                                     
                                                                                                      //// si el sentido de la meta viene positivo
                                                                                                      if($sentidoIndicador == 'Positivo'){
                                                                                                          
                                                                                                        if($DatoAlimentado > $metaFormula ){ 
                                                                                                          echo '<font style="background:blue;color:white;">'.$metaFormulaUnidad.' '.$DatoAlimentado.'</font><br>';
                                                                                                        }
                                                                                                        if($DatoAlimentado <= $metaFormula && $DatoAlimentado > $extraerMEta['za']){
                                                                                                          echo '<font style="background:green;color:white;">'.$metaFormulaUnidad.' '.$DatoAlimentado.'</font><br>';
                                                                                                        }  
                                                                                                        if($DatoAlimentado <= $extraerMEta['za'] && $DatoAlimentado > $extraerMEta['zp']){
                                                                                                          echo '<font style="background:yellow;color:black;">'.$metaFormulaUnidad.' '.$DatoAlimentado.'</font><br>';
                                                                                                        }
                                                                                                        if($DatoAlimentado <= $extraerMEta['zp']){
                                                                                                          echo '<font style="background:red;color:white;">'.$metaFormulaUnidad.' '.$DatoAlimentado.'</font><br>';
                                                                                                        }
                                                                                                      
                                                                                                          
                                                                                                      }
                                                                                                      
                                                                                                      if($sentidoIndicador == 'Negativo'){
                                                                                                          
                                                                                                           $DatoAlimentado;
                                                                                                           '-';
                                                                                                             $metaFormula;
                                                                                                          
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
                                                                                    <td data-titulo="Fórmula aplicada">
                                                                                       <?php echo '<b>'.$formulaAplicada.'</b>'; ?>
                                                                                    </td>
                                                                                    <td data-titulo="Meta">
                                                                                      <?php
                                                                                                $consultarMetaValidandoRecorrido=$mysqli->query("SELECT * FROM `indicadoresMetas` WHERE  idIndicador='$variablesIdPrincipal' ");
                                                                                                while($extraerMEtaValidandoRecorrido=$consultarMetaValidandoRecorrido->fetch_array()){
                                                                                                       $enviarpermisoMeta=$extraerMEtaValidandoRecorrido['metas'];  
                                                                                                    }
                                                                                                    
                                                                                                    if($enviarpermisoMeta == 'No'){
                                                                                                        
                                                                                                    }else{
                                                                                                    $consultarMetaValidando=$mysqli->query("SELECT * FROM `indicadoresMetas` WHERE  hasta >= '$newDate' AND idIndicador='$variablesIdPrincipal' ");
                                                                                                    $extraerMEtaValidando=$consultarMetaValidando->fetch_array(MYSQLI_ASSOC);
                                                                                                     '<b>'.$habilitaOpcionesB=$extraerMEtaValidando['metaActual']; echo '</b>';
                                                                                                      
                                                                                                     if($metaFormulaUnidad == '$'){
                                                                                                         echo '<b>$'. number_format($extraerMEtaValidando['metaActual'],0,'.',','); echo '</b>';
                                                                                                     }else{
                                                                                                         echo '<b>'.$extraerMEtaValidando['metaActual']; echo '</b>';
                                                                                                     }
                                                                                                     
                                                                                                    
                                                                                                        
                                                                                                   
                                                                                                        if($habilitaOpcionesB >= 1){
                                                                                                            $habilitaBotonDisabled='';
                                                                                                        }else{
                                                                                                            $habilitaBotonDisabled='disabled';
                                                                                                            echo '<b>Configurar meta</b>';
                                                                                                        }
                                                                                                    }
                                                                                      //echo '<b>'.$metaFormula.'</b>'; //$saleIndicadorMeta ?>
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
                                                                                                 echo '<table><thead><tr><td>';
                                                                                                 echo '<form action="controlador/indicadores/controller" method="post">';
                                                                                                 echo ' <input name="quienCrea" value="'.$quienCrea.'" type="hidden">
                                                                                                    <input name="variablesIdPrincipal" value="'.$variablesIdPrincipal.'" type="hidden">';
                                                                                                 echo '<input name="eliminarAnalisis" value="'.$extraeDatoIndicadorArchivos['id'].'" type="hidden" readonly>';
                                                                                                 echo '<input name="NombreEliminarAnalisis" value="'.$extraeDatoIndicadorArchivos['documento'].'" type="hidden" readonly>';
                                                                                                 echo '<button class="btn btn-danger btn-sm" type="submit" name="eliminandoAnalisis"><i class=\'fas fa-trash-alt\'></i></button>';
                                                                                                 echo '</form>';
                                                                                                 echo '</td><td>';
                                                                                                 echo"
                                                                                                      
                                                                                                        <button class='btn btn-warning btn-sm' href='#' ><a style='color:black' href='$ruta' download='' target='_blank'><i class='fas fa-download'></i></a></button>
                                                                                                        <a style='color:black' href='$ruta' download='' target='_blank'>$nombreDocumento</a>
                                                                                                    
                                                                                                    </td></tr></table>";
                                                                                               
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
                                                                                                echo '<table><thead><tr><td>';
                                                                                                echo '<form action="controlador/indicadores/controller" method="post">';
                                                                                                echo ' <input name="quienCrea" value="'.$quienCrea.'" type="hidden">
                                                                                                    <input name="variablesIdPrincipal" value="'.$variablesIdPrincipal.'" type="hidden">';
                                                                                                echo '<input name="eliminarAnalisis" value="'.$extraeDatoIndicadorArchivos['id'].'" type="hidden" readonly>';
                                                                                                echo '<input name="NombreEliminarAnalisis" value="'.$extraeDatoIndicadorArchivos['documento'].'" type="hidden" readonly>';
                                                                                                echo '<button class="btn btn-danger btn-sm" type="submit" name="eliminandoAnalisis"><i class=\'fas fa-trash-alt\'></i></button>';
                                                                                                echo '</form>';
                                                                                                echo '</td><td>';
                                                                                                echo '<b>*</b> '.$analisisComentario.'</td></tr></table>';
                                                                                            }
                                                                                            
                                                                                            }
                                                                                           //// END
                                                                                       ?>
                                                                                      <form action="controlador/indicadores/controllerGestionar" method="POST" enctype="multipart/form-data">
                                                                                            <input name="anoPresente" value="<?php echo $anoPresente; ?>" readonly type="hidden">
                                                                                            <input name="mes" readonly type="hidden" value="<?php echo $mostrarMes; ?>">
                                                                                            <textarea name="analisis" class="form-control" <?php echo $habilitaBotonDisabled;?> onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" ></textarea>
                                                                                            <input name="nombre" type="hidden" value="<?php echo $nombreIndicador; ?>" readonly>
                                                                                            <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden">
                                                                                            <input name="variablesIdPrincipal" value="<?php echo $variablesIdPrincipal; ?>" type="hidden">
                                                                                           <!-- <input class='btn btn-sm' style="background:gray;color:white;" type="file" name="soporte">-->
                                                                                            
                                                                                            <label for="upload-photo">Archivo:</label> 
                                                                                              <div class="input-group">
                                                                                                <div class="custom-file">
                                                                                                <input type="file" id="miInput<?php echo $contandoVaidacinArchivo++;?>" class="custom-file-input" name="soporte"  <?php echo $habilitaBotonDisabled;?>>
                                                                                                <label class="custom-file-label" >Subir Archivo</label>
                                                                                                
                                                                                              </div>
                                                                                             </div>
                                                                                             <!--validando archivo dañado-->
                                                                                            <br>
                                                                                            <button class='btn btn-info btn-sm' <?php echo $habilitaBotonDisabled;?>>Agregar</button>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>
                                                                                        <form action="indicadoresGestionarAplicar" method="POST" enctype="multipart/form-data">
                                                                                            <input name="anoPresente" value="<?php echo $anoPresente; ?>" readonly type="hidden">
                                                                                            <input name="mes" readonly type="hidden" value="<?php echo $mostrarMes; ?>">
                                                                                            <input name="variablesIdPrincipal" type="hidden" value="<?php echo $variablesIdPrincipal; ?>">
                                                                                            <button class='btn btn-success btn-sm' <?php echo $habilitaBotonDisabled;?>>Aplicar</button>
                                                                                        </form>
                                                                                    </td>
                                                           
                                                             </tr>    
                                                             
                                    <?php
                                        }
                                               //// END
                                    }else{
                                            echo '<font color="red">El año máximo del indicador ya caduco</font>';
                                    } /// END
                                }          
                                           
                                           
                                           
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
                        
                    <?php
                        $graficaSelect=$_POST['tipoGrafica'];
                        ////// titulo principal
                        $tituloPrincipal=$_POST['tituloPrincipal'];
                        ////// colores
                        ///// titulos
                       
                        ///// datos
                        $datos1=$_POST['dato1'];
                        $datos2=$_POST['dato2'];
                        $datos3=$_POST['dato3'];
                    
                    ?>
                    
                   
                    
                    
                        <script>
                            const MAXIMO_TAMANIO_BYTES = 11000000; // 1MB = 1 millón de bytes
                            
                            // Obtener referencia al elemento
                            const $miInput0 = document.querySelector("#miInput0")
                            const $miInput1 = document.querySelector("#miInput1")
                            const $miInput2 = document.querySelector("#miInput2")
                            const $miInput3 = document.querySelector("#miInput3")
                            const $miInput4 = document.querySelector("#miInput4")
                            const $miInput5 = document.querySelector("#miInput5")
                            const $miInput6 = document.querySelector("#miInput6")
                            const $miInput7 = document.querySelector("#miInput7")
                            const $miInput8 = document.querySelector("#miInput8")
                            const $miInput9 = document.querySelector("#miInput9")
                            
                            
                            $miInput0.addEventListener("change", function () { 
                            	// si no hay archivos, regresamos
                            	if (this.files.length <= 0) return;
                            
                            	// Validamos el primer archivo únicamente
                            	const archivo = this.files[0];
                            	if (archivo.size > MAXIMO_TAMANIO_BYTES) {
                            		const tamanioEnMb = MAXIMO_TAMANIO_BYTES / 1000000;
                            		//alert(`El tamaño máximo del archivo es de ${tamanioEnMb} MB`);
                            		
                                        const Toast = Swal.mixin({
                                          toast: true,
                                          position: 'top-end',
                                          showConfirmButton: false,
                                          timer: 3000
                                        });
                                		Toast.fire({
                                            type: 'warning',
                                            title: ` El tamaño máximo del archivo es de 10 MB`
                                        })
                            		// Limpiar
                            		$miInput0.value = "";
                            	} else {
                            		// Validación asada. Envía el formulario o haz lo que tengas que hacer
                            	}
                            });
                            $miInput1.addEventListener("change", function () { 
                            	// si no hay archivos, regresamos
                            	if (this.files.length <= 0) return;
                            
                            	// Validamos el primer archivo únicamente
                            	const archivo = this.files[0];
                            	if (archivo.size > MAXIMO_TAMANIO_BYTES) {
                            		const tamanioEnMb = MAXIMO_TAMANIO_BYTES / 1000000;
                            		//alert(`El tamaño máximo del archivo es de ${tamanioEnMb} MB`);
                            		
                                        const Toast = Swal.mixin({
                                          toast: true,
                                          position: 'top-end',
                                          showConfirmButton: false,
                                          timer: 3000
                                        });
                                		Toast.fire({
                                            type: 'warning',
                                            title: ` El tamaño máximo del archivo es de 10 MB`
                                        })
                            		// Limpiar
                            		$miInput1.value = "";
                            	} else {
                            		// Validación asada. Envía el formulario o haz lo que tengas que hacer
                            	}
                            });
                            $miInput2.addEventListener("change", function () { 
                            	// si no hay archivos, regresamos
                            	if (this.files.length <= 0) return;
                            
                            	// Validamos el primer archivo únicamente
                            	const archivo = this.files[0];
                            	if (archivo.size > MAXIMO_TAMANIO_BYTES) {
                            		const tamanioEnMb = MAXIMO_TAMANIO_BYTES / 1000000;
                            		//alert(`El tamaño máximo del archivo es de ${tamanioEnMb} MB`);
                            		
                                        const Toast = Swal.mixin({
                                          toast: true,
                                          position: 'top-end',
                                          showConfirmButton: false,
                                          timer: 3000
                                        });
                                		Toast.fire({
                                            type: 'warning',
                                            title: ` El tamaño máximo del archivo es de 10 MB`
                                        })
                            		// Limpiar
                            		$miInput2.value = "";
                            	} else {
                            		// Validación asada. Envía el formulario o haz lo que tengas que hacer
                            	}
                            });
                            $miInput3.addEventListener("change", function () { 
                            	// si no hay archivos, regresamos
                            	if (this.files.length <= 0) return;
                            
                            	// Validamos el primer archivo únicamente
                            	const archivo = this.files[0];
                            	if (archivo.size > MAXIMO_TAMANIO_BYTES) {
                            		const tamanioEnMb = MAXIMO_TAMANIO_BYTES / 1000000;
                            		//alert(`El tamaño máximo del archivo es de ${tamanioEnMb} MB`);
                            		
                                        const Toast = Swal.mixin({
                                          toast: true,
                                          position: 'top-end',
                                          showConfirmButton: false,
                                          timer: 3000
                                        });
                                		Toast.fire({
                                            type: 'warning',
                                            title: ` El tamaño máximo del archivo es de 10 MB`
                                        })
                            		// Limpiar
                            		$miInput3.value = "";
                            	} else {
                            		// Validación asada. Envía el formulario o haz lo que tengas que hacer
                            	}
                            });
                            $miInput4.addEventListener("change", function () { 
                            	// si no hay archivos, regresamos
                            	if (this.files.length <= 0) return;
                            
                            	// Validamos el primer archivo únicamente
                            	const archivo = this.files[0];
                            	if (archivo.size > MAXIMO_TAMANIO_BYTES) {
                            		const tamanioEnMb = MAXIMO_TAMANIO_BYTES / 1000000;
                            		//alert(`El tamaño máximo del archivo es de ${tamanioEnMb} MB`);
                            		
                                        const Toast = Swal.mixin({
                                          toast: true,
                                          position: 'top-end',
                                          showConfirmButton: false,
                                          timer: 3000
                                        });
                                		Toast.fire({
                                            type: 'warning',
                                            title: ` El tamaño máximo del archivo es de 10 MB`
                                        })
                            		// Limpiar
                            		$miInput4.value = "";
                            	} else {
                            		// Validación asada. Envía el formulario o haz lo que tengas que hacer
                            	}
                            });
                            $miInput5.addEventListener("change", function () { 
                            	// si no hay archivos, regresamos
                            	if (this.files.length <= 0) return;
                            
                            	// Validamos el primer archivo únicamente
                            	const archivo = this.files[0];
                            	if (archivo.size > MAXIMO_TAMANIO_BYTES) {
                            		const tamanioEnMb = MAXIMO_TAMANIO_BYTES / 1000000;
                            		//alert(`El tamaño máximo del archivo es de ${tamanioEnMb} MB`);
                            		
                                        const Toast = Swal.mixin({
                                          toast: true,
                                          position: 'top-end',
                                          showConfirmButton: false,
                                          timer: 3000
                                        });
                                		Toast.fire({
                                            type: 'warning',
                                            title: ` El tamaño máximo del archivo es de 10 MB`
                                        })
                            		// Limpiar
                            		$miInput5.value = "";
                            	} else {
                            		// Validación asada. Envía el formulario o haz lo que tengas que hacer
                            	}
                            });
                            $miInput6.addEventListener("change", function () { 
                            	// si no hay archivos, regresamos
                            	if (this.files.length <= 0) return;
                            
                            	// Validamos el primer archivo únicamente
                            	const archivo = this.files[0];
                            	if (archivo.size > MAXIMO_TAMANIO_BYTES) {
                            		const tamanioEnMb = MAXIMO_TAMANIO_BYTES / 1000000;
                            		//alert(`El tamaño máximo del archivo es de ${tamanioEnMb} MB`);
                            		
                                        const Toast = Swal.mixin({
                                          toast: true,
                                          position: 'top-end',
                                          showConfirmButton: false,
                                          timer: 3000
                                        });
                                		Toast.fire({
                                            type: 'warning',
                                            title: ` El tamaño máximo del archivo es de 10 MB`
                                        })
                            		// Limpiar
                            		$miInput6.value = "";
                            	} else {
                            		// Validación asada. Envía el formulario o haz lo que tengas que hacer
                            	}
                            });
                            $miInput7.addEventListener("change", function () { 
                            	// si no hay archivos, regresamos
                            	if (this.files.length <= 0) return;
                            
                            	// Validamos el primer archivo únicamente
                            	const archivo = this.files[0];
                            	if (archivo.size > MAXIMO_TAMANIO_BYTES) {
                            		const tamanioEnMb = MAXIMO_TAMANIO_BYTES / 1000000;
                            		//alert(`El tamaño máximo del archivo es de ${tamanioEnMb} MB`);
                            		
                                        const Toast = Swal.mixin({
                                          toast: true,
                                          position: 'top-end',
                                          showConfirmButton: false,
                                          timer: 3000
                                        });
                                		Toast.fire({
                                            type: 'warning',
                                            title: ` El tamaño máximo del archivo es de 10 MB`
                                        })
                            		// Limpiar
                            		$miInput7.value = "";
                            	} else {
                            		// Validación asada. Envía el formulario o haz lo que tengas que hacer
                            	}
                            });
                            $miInput8.addEventListener("change", function () { 
                            	// si no hay archivos, regresamos
                            	if (this.files.length <= 0) return;
                            
                            	// Validamos el primer archivo únicamente
                            	const archivo = this.files[0];
                            	if (archivo.size > MAXIMO_TAMANIO_BYTES) {
                            		const tamanioEnMb = MAXIMO_TAMANIO_BYTES / 1000000;
                            		//alert(`El tamaño máximo del archivo es de ${tamanioEnMb} MB`);
                            		
                                        const Toast = Swal.mixin({
                                          toast: true,
                                          position: 'top-end',
                                          showConfirmButton: false,
                                          timer: 3000
                                        });
                                		Toast.fire({
                                            type: 'warning',
                                            title: ` El tamaño máximo del archivo es de 10 MB`
                                        })
                            		// Limpiar
                            		$miInput8.value = "";
                            	} else {
                            		// Validación asada. Envía el formulario o haz lo que tengas que hacer
                            	}
                            });
                             $miInput9.addEventListener("change", function () { 
                            	// si no hay archivos, regresamos
                            	if (this.files.length <= 0) return;
                            
                            	// Validamos el primer archivo únicamente
                            	const archivo = this.files[0];
                            	if (archivo.size > MAXIMO_TAMANIO_BYTES) {
                            		const tamanioEnMb = MAXIMO_TAMANIO_BYTES / 1000000;
                            		//alert(`El tamaño máximo del archivo es de ${tamanioEnMb} MB`);
                            		
                                        const Toast = Swal.mixin({
                                          toast: true,
                                          position: 'top-end',
                                          showConfirmButton: false,
                                          timer: 3000
                                        });
                                		Toast.fire({
                                            type: 'warning',
                                            title: ` El tamaño máximo del archivo es de 10 MB`
                                        })
                            		// Limpiar
                            		$miInput9.value = "";
                            	} else {
                            		// Validación asada. Envía el formulario o haz lo que tengas que hacer
                            	}
                            });
                            
                           
                           
                           
                         
                           
                           
                            
                        </script>
                                           



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
      labels  : [<?php $consultarParaGraficarMeses=$mysqli->query("SELECT * FROM indicadoresGestionar WHERE idIndicador='$variablesIdPrincipal'  GROUP BY mes ORDER BY id ASC ");
                        while($imprimirGraficaMeses=$consultarParaGraficarMeses->fetch_array()){
                            $imprimiendoMEs=$imprimirGraficaMeses['mes'];
                            $imprimiendoMEs = ucwords($imprimiendoMEs);
                            $imprimiendoAnoPresente=$imprimirGraficaMeses['anoPresente'];
                            echo "  '$imprimiendoMEs $imprimiendoAnoPresente', ";
                                }
                    ?>],
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
           data:[<?php $consultarParaGraficarMesesResultado=$mysqli->query("SELECT * FROM indicadoresGestionar WHERE idIndicador='$variablesIdPrincipal' AND alimentado IS not NULL GROUP BY mes ORDER BY id ASC");
                        while($imprimirGraficaMesesResultado=$consultarParaGraficarMesesResultado->fetch_array()){
                            $imprimiendoMEsResultado=$imprimirGraficaMesesResultado['alimentado'];
                            echo "  '$imprimiendoMEsResultado', ";
                                }
                    ?>]
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
           data:[<?php $consultarParaGraficarMesesResultado=$mysqli->query("SELECT * FROM indicadoresGestionar WHERE idIndicador='$variablesIdPrincipal' AND alimentado IS not NULL GROUP BY mes ORDER BY id ASC");
                        while($imprimirGraficaMesesResultado=$consultarParaGraficarMesesResultado->fetch_array()){
                            $imprimiendoMEsResultado=$imprimirGraficaMesesResultado['alimentado'];
                            echo "  '$imprimiendoMEsResultado', ";
                                }
                    ?> ]
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
      labels  : [<?php $consultarParaGraficarMeses=$mysqli->query("SELECT * FROM indicadoresGestionar WHERE idIndicador='$variablesIdPrincipal' AND alimentado IS not NULL GROUP BY mes ORDER BY id ASC");
                        while($imprimirGraficaMeses=$consultarParaGraficarMeses->fetch_array()){
                            $imprimiendoMEs=$imprimirGraficaMeses['mes'];
                            $imprimiendoMEs = ucwords($imprimiendoMEs);
                            $imprimiendoAnoPresente=$imprimirGraficaMeses['anoPresente'];
                            echo "  '$imprimiendoMEs $imprimiendoAnoPresente', ";
                                }
                    ?>],
      datasets: [
        {
          data:[<?php $consultarParaGraficarMesesResultado=$mysqli->query("SELECT * FROM indicadoresGestionar WHERE idIndicador='$variablesIdPrincipal' AND alimentado IS not NULL  GROUP BY mes ORDER BY id ASC");
                        while($imprimirGraficaMesesResultado=$consultarParaGraficarMesesResultado->fetch_array()){
                            $imprimiendoMEsResultado=$imprimirGraficaMesesResultado['alimentado'];
                            echo "  '$imprimiendoMEsResultado', ";
                                }
                    ?>],
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
<?php
if($_POST['alerta'] != NULL){
?>
                        <script>
                            $(document).ready(function() {
                              // indicamos que se ejecuta la funcion a los 5 segundos de haberse
                              // cargado la pagina
                              setTimeout(clickbutton, 0000);
                            
                              function clickbutton() {
                                // simulamos el click del mouse en el boton del formulario
                                $("#action-button-bloqueado").click();
                                //alert("Aqui llega"); //Debugger
                              }
                              $('#action-button-bloqueado').on('click',function() {
                               // console.log('action');
                              });
                            });
                       </script> 
                       <button id="action-button-bloqueado" style="display:none;" data-toggle="modal" data-target='#modal-danger-alerta-Bloqueo'></button>
                    
                        <div class="modal fade" id="modal-danger-alerta-Bloqueo">
                            <div class="modal-dialog">
                              <div class="modal-content bg-danger">
                                <div class="modal-header">
                                  <h4 class="modal-title">Alerta</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <p>El nombre del archivo contiene caracteres inválidos, por favor digite el nombre completo del archivo e intente cargar.</p>
                                </div>
                                 <!-- END formulario para eliminar por el id -->
                              </div>
                            </div>
                        </div>
<?php
}
?>       
    <?php
if($_POST['alerta'] != NULL){
?>
                        <script>
                            $(document).ready(function() {
                              // indicamos que se ejecuta la funcion a los 5 segundos de haberse
                              // cargado la pagina
                              setTimeout(clickbutton, 0000);
                            
                              function clickbutton() {
                                // simulamos el click del mouse en el boton del formulario
                                $("#action-button-bloqueado").click();
                                //alert("Aqui llega"); //Debugger
                              }
                              $('#action-button-bloqueado').on('click',function() {
                               // console.log('action');
                              });
                            });
                       </script> 
                       <button id="action-button-bloqueado" style="display:none;" data-toggle="modal" data-target='#modal-danger-alerta-Bloqueo'></button>
                    
                        <div class="modal fade" id="modal-danger-alerta-Bloqueo">
                            <div class="modal-dialog">
                              <div class="modal-content bg-danger">
                                <div class="modal-header">
                                  <h4 class="modal-title">Alerta</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <p>El nombre del archivo contiene caracteres inválidos, por favor digite el nombre completo del archivo e intente cargar.</p>
                                </div>
                                 <!-- END formulario para eliminar por el id -->
                              </div>
                            </div>
                        </div>
<?php
}
?>           
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
<!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<?php
/// validaciones de alertas
$validacionExiste=$_POST['validacionExiste'];
$validacionAgregar=$_POST['validacionAgregar'];
$validacionActualizar=$_POST['validacionActualizar'];
$validacionEliminar=$_POST['validacionEliminar'];
?>
<script type="text/javascript">
  $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
    
    
    <?php
    if($validacionExiste == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El nivel o la prioridad ya existe.'
        })
    <?php
    }
    
    if($validacionAgregar == 1){
    ?>
        Toast.fire({
            type: 'success',
            title: 'Registro agregado.'
        })
    <?php
    }
    
    if($validacionActualizar == 1){
    ?>
        Toast.fire({
            type: 'info',
            title: 'Registro actualizado.'
        })
    <?php
    }
    
    if($validacionEliminar == 1){
    ?>
        Toast.fire({
            type: 'error',
            title: 'Registro eliminado.'
        })
    
    <?php
    }
    ?>
    
  });

</script>
  <script type="text/javascript">
$(document).ready(function () {
   
    $('body').bind('cut copy paste', function (e) {
        e.preventDefault();
    });
   
   
    $("body").on("contextmenu",function(e){
        return false;
    });
});
</script>
</body>
</html>
<?php
}
?>