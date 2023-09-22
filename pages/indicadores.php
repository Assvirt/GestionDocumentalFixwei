<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
//////////////////////PERMISOS////////////////////////
require_once 'conexion/bd.php';

$formulario = 'indicadores'; //Se cambia el nombre del formulario
require_once 'permisosPlataforma.php';
/*
$documento = $_SESSION["session_username"];
$queryGrupos = $mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario = '$documento'");

while($row = $queryGrupos->fetch_assoc()){
    $idGrupo = $row['idGrupo'];
    
    $queryPermisos = $mysqli->query("SELECT * FROM permisos WHERE idGrupo = '$idGrupo' AND formulario = '$formulario'");
    
    $permisos = $queryPermisos->fetch_array(MYSQLI_ASSOC);
    if($permisos['listar'] == TRUE){
        $permisoListar = $permisos['listar'];    
    }
    if($permisos['crear'] == TRUE){
        $permisoInsertar = $permisos['crear'];    
    }
    if($permisos['editar'] == TRUE){
        $permisoEditar = $permisos['editar'];    
    }
    if($permisos['eliminar'] == TRUE){
        $permisoEliminar = $permisos['eliminar'];    
    }
    
}


if($permisoListar == FALSE){
    echo '<script language="javascript">window.location.href="accesoDenegado"</script>';
}

if($permisoInsertar == FALSE){
    $visibleI = 'none';
}else{
    $visibleI = '';
}

if($permisoEditar == FALSE){
    $visibleE = 'none';
}else{
    $visibleE = '';
}

if($permisoEliminar == FALSE){
    $visibleD = 'none';
}else{
    $visibleD = '';
}*/
//////////////////////PERMISOS////////////////////////

?>

<!DOCTYPE html>
<html>
    <title>Indicadores</title>
<head><meta charset="gb18030">
  
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
<body class="hold-transition sidebar-mini" onload="nobackbutton();">
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
            <h1>Indicadores</h1>
            <h6>Gestione los mecanismos de medición y mejora continua.</h6><br>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Indicadores</li>
            </ol>
          </div>
        </div>
        <div>
            <?php
                if($visibleI == FALSE){
                    
                    $root='';
                $root = $_SESSION['session_root'];
                
                if($root == 1){ }else{
            ?>
            <div class="row">
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="indicadoresAgregar"><font color="white"><i class="fas fa-plus-square"></i> Agregar Indicador</font></a></button>
            </div>
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="indicadoresTipo"><font color="white"><i class="fas fa-plus-square"></i> Agregar Tipo de Indicador</font></a></button>
            </div>
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="indicadoresUnidad"><font color="white"><i class="fas fa-plus-square"></i> Agregar Unidad de Medida</font></a></button>
            </div>
            <div class="col-sm">
            </div>

            <div class="col-sm">
            </div>
            <div class="col-sm">
            </div>
            </div>
            <?php } }else{?>
            <div class="row">
                <div class="col-sm">
                </div>
                <div class="col-sm"></div>
                <div class="col-sm"></div>
                <div class="col-sm"></div>
                <div class="col-sm"></div>
            </div>
            <?php }?>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-head-fixed text-center" id="example">
                  <thead>
                    <tr>
                      <th>N°</th>
                      <th>Creador del Indicador</th>
                      <th>Nombre</th>
                      <th>Tipo</th>
                      <th>Proceso</th>
                      <th>Responsable</th>
                      <th>Sentido</th>
                      <th>Frecuencia</th>
                      <th>Fórmula</th>
                      <th>Meta</th>
                      <th>Unidad de Medida</th>
                      <th>Valor Último Periodo</th>
                      <th>Estado</th>
                      <th>Estado del Indicador</th>
                      <th>Ver m&aacute;s</th>
                      <th style="display:<?php echo$visibleE;?>;">Editar</th>
                      <th style="display:<?php echo$visibleD;?>;">Eliminar</th>
                      <th>Responsable del cálculo</th>
                      <th>Responsable de indicador</th>
                    </tr>
                  </thead>
                  <tbody>
                     <?php
                     error_reporting(E_ERROR);
                     require 'conexion/bd.php';
                     $acentos = $mysqli->query("SET NAMES 'utf8'");
                     $data = $mysqli->query("SELECT * FROM indicadores ORDER BY nombre ASC")or die(mysqli_error()); 
                    
                     $item=1;
                     
                     while($row = $data->fetch_assoc()){
                     $quienCrea = $row['quienCrea'];
                    
                    //// si el conteo es mayor a 1 puede ver en caso contrario anulado
                    if($root == 1){
                        
                    }else{
                        $permisoVerMasConteo = FALSE;
                     
                        $quienElaboraConteo = $row['radioVisualizar']; 
                        $quienElaboraIDconteo = json_decode($row['autorizadoVisualizar']);
                        
                        if($quienElaboraConteo == "cargo"){
                            if(in_array($cargo,$quienElaboraIDconteo)){
                                $permisoVerMasConteo = TRUE;
                            }
                        }
                        
                        if($quienElaboraConteo == "usuario"){
                            if(in_array($idparaChat,$quienElaboraIDconteo)){
                                $permisoVerMasConteo = TRUE;
                            }
                        }
                    
                        if($permisoVerMasConteo == FALSE){
                            $habilitarSeguimietoConteo = "disabled";
                        }else{
                            $habilitarSeguimietoConteo = "";
                        }
                        
                       if($quienCrea == $sesion){
                           $habilitarSeguimietoConteo = "";
                       }
                    
                    $permisoEditarIndicadorConteo = FALSE;
                     
                        $quienEditaIndicadorConteo = $row['radioEditar']; 
                        $quienEditaIndicadorIDConteo = json_decode($row['autorizadoEditar']);
                        
                        if($quienEditaIndicadorConteo == "cargo"){
                            if(in_array($cargo,$quienEditaIndicadorIDConteo)){
                                $permisoEditarIndicadorConteo = TRUE;
                            }
                        }
                        
                        if($quienEditaIndicadorConteo == "usuario"){
                            if(in_array($idparaChat,$quienEditaIndicadorIDConteo)){
                                $permisoEditarIndicadorConteo = TRUE;
                            }
                        }
                    
                        if($permisoEditarIndicadorConteo == FALSE){
                            $habilitarEditarIndicadorConteo = "disabled";
                        }else{
                            $habilitarEditarIndicadorConteo = "";
                        }
                        
                        $permisoGestionarConteo = FALSE;
                     
                        $quienVeGestionarConteo = $row['radioCalculo']; 
                        $quienGestionarIDConteo = json_decode($row['responsableCalculo']);
                        
                        if($quienVeGestionarConteo == "cargo"){
                            if(in_array($cargo,$quienGestionarIDConteo)){
                                $permisoGestionarConteo = TRUE;
                            }
                        }
                        
                        if($quienVeGestionarConteo == "usuario"){
                            if(in_array($idparaChat,$quienGestionarIDConteo)){
                                $permisoGestionarConteo = TRUE;
                            }
                        }
                    
                        if($permisoGestionarConteo == FALSE){
                            $habilitarSeguimietoGestionarConteo = "disabled";
                        }else{
                            $habilitarSeguimietoGestionarConteo = "";
                        }
                        
                        $permisoGestionarIndicadorConteo = FALSE;
                     
                        $quienVeGestionarIndicadorConteo = $row['radioIndicador']; 
                        $quienGestionarIDIndicadorConteo = json_decode($row['resposableIndicador']);
                        
                        if($quienVeGestionarIndicadorConteo == "cargo"){
                            if(in_array($cargo,$quienGestionarIDIndicadorConteo)){
                                $permisoGestionarIndicadorConteo = TRUE;
                            }
                        }
                        
                        if($quienVeGestionarIndicadorConteo == "usuario"){
                            if(in_array($idparaChat,$quienGestionarIDIndicadorConteo)){
                                $permisoGestionarIndicadorConteo = TRUE;
                            }
                        }
                    
                        if($permisoGestionarIndicadorConteo == FALSE){
                            $habilitarSeguimietoGestionarIndicadorConteo = "disabled";
                        }else{
                            $habilitarSeguimietoGestionarIndicadorConteo = "";
                        }
                    //// END
                    
                    if($habilitarSeguimietoConteo == 'disabled' && $habilitarEditarIndicadorConteo == 'disabled' && $habilitarSeguimietoGestionarConteo == 'disabled' && $habilitarSeguimietoGestionarIndicadorConteo == 'disabled'){
                            continue;
                        }
                    
                 
                    }
                 
                    echo"<tr>";
                    $id = $row['id'];
                   
                    echo" <td>".$item++."</td>";
                    $quienCreaIndicaro=$mysqli->query("SELECT * FROM usuario WHERE cedula='$quienCrea' ");
                    $extraerConocidoCreadorIndicador=$quienCreaIndicaro->fetch_array(MYSQLI_ASSOC);
                    echo "<td>".$extraerConocidoCreadorIndicador['nombres']."</td>";
                    echo" <td style='text-align:justify;'>".$row['nombre']."</td>";
                     $tipoIndicador=$row['tipoIndicador'];
                     $queryTipoIndicador=$mysqli->query("SELECT * FROM indicadoresTipo WHERE id='$tipoIndicador' ");
	                 $rowDatos=$queryTipoIndicador->fetch_array(MYSQLI_ASSOC);
	                echo "<td style='text-align:justify;'>" . $rowDatos['tipo'] . "</td>";
            		
            		$idProceso=$row['proceso'];
            		$queryProceso=$mysqli->query("SELECT * FROM procesos WHERE id='$idProceso' ");
	                 $rowDatosProceso=$queryProceso->fetch_array(MYSQLI_ASSOC);
	                echo "<td style='text-align:justify;'>" . $rowDatosProceso['nombre'] . "</td>";
            		
            		$tipoResponsable=$row['radioIndicador'];
                    $personalID =  json_decode($row['resposableIndicador']);
                            $longitud = count($personalID);
                             if($tipoResponsable == 'usuario'){
                                    echo"<td style='text-align:justify;'>";
                                    for($i=0; $i<$longitud; $i++){
                                        
                                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$personalID[$i]'");
                                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                    
                                        echo $columna['nombres']." ".$columna['apellidos'];echo "<br>";
                                        $cedulaUsuario=$columna['cedula'];
                                    } echo"</td>";
                                 
                                }else{
                                    echo"<td style='text-align:justify;'>";
                                    for($i=0; $i<$longitud; $i++){
                                    $nombrecargo = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$personalID[$i]'");
                                    $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                    echo $carga = $columna['nombreCargos']; echo "<br>";
                                    } "</td>";
                                }
                    echo "<td style='text-align:justify;'>" . $row['sentido'] . "</td>";
                    echo "<td style='text-align:justify;'>" . $row['frecuencia'] . "</td>";
                    
                    if($row['formula'] != NULL){
                        echo "<td style='text-align:justify;'>" . $row['formula'] . "</td>";
                    }else{    
                        echo "<td style='text-align:justify;'>N/A</td>";
                    }
                    
                    $meta = $mysqli->query("SELECT * FROM indicadoresMetas WHERE idIndicador = '$id' ORDER BY id DESC ");
                    $metas = $meta->fetch_array(MYSQLI_ASSOC);
                        $enviarMEtas= $metas['metaActual'];          
                        if($enviarMEtas != NULL){
                            $enviarMEtas=$metas['metaActual'];
                        }else{
                            $enviarMEtas='N/A';    
                        }
                        
                        $enviasMEtasUnidad= $metas['unidad'];
                        if($enviasMEtasUnidad != NULL){
                            $enviasMEtasUnidad=$metas['unidad'];
                        }else{
                            $enviasMEtasUnidad='N/A';    
                        }
                    
                    echo "<td style='text-align:justify;'>".$enviarMEtas."</td>";
                    
                    echo "<td >".$enviasMEtasUnidad."</td>";
                    
                    //// analisamos el año del sistema para validar el estado del indicador y el último valor periodo
                    date_default_timezone_set('America/Bogota');$fecha1=date('Y-m-j h:i:s A');
                    $anoPresente =intval(substr($fecha1, 0, 4)); ///AND anoPresente='$anoPresente'
                    //// END
                    
                    /// traemos el último resultado de los indicadores AND anoPresente='$anoPresente' 
                    $ultimoResultado = $mysqli->query("SELECT * FROM `indicadoresGestionar` WHERE idIndicador='$id'  AND alimentado is not NULL  ORDER BY id DESC LIMIT 0,1 ");
                                    $metasUltimoResultado = $ultimoResultado->fetch_array(MYSQLI_ASSOC);
                                    $resultadoAlimentado=$metasUltimoResultado['alimentado'];
                                    
                                    if($resultadoAlimentado != NULL){
                                        $resultadoAlimentado=$metasUltimoResultado['alimentado'];
                                    }else{
                                        $resultadoAlimentado='N/A';
                                    }
                                    
                    /// END
                    
                    
                    echo "<td style='text-align:justify;'>".$resultadoAlimentado."</td>";
                    
                    //AND anoPresente='$anoPresente'
                    $ultimoResultadoConteoCompletoConteo = $mysqli->query("SELECT * FROM `indicadoresGestionar` WHERE idIndicador='$id'  AND alimentado is not NULL GROUP BY mes");
                    $conteoCompletoRegistradoConteo='0';
                    while($metasUltimoResultadoConteoCompletoConteo = $ultimoResultadoConteoCompletoConteo->fetch_array()){
                     //$conteoCompletoRegistradoConteo=$metasUltimoResultadoConteoCompletoConteo['count(*)'];
                     $conteoCompletoRegistradoConteo++;
                    }
                    
                    //// validación para mostrar si el indicador está alimentado o aún no lo está
                    $indicadorDesde=$row['desde'];
                    $indicadorHasta=$row['hasta'];
                    
                    $anoPresenteBasedeDatos = intval(substr($indicadorHasta, 0, 4));
                    $mesDesde = intval(substr($indicadorDesde, 5, 2));
                    $mesHasta = intval(substr($indicadorHasta, 5, 2));
                    
                    
                    //// mes actual capturado
                    date_default_timezone_set('America/Bogota');$fecha1=date('Y-m-j h:i:s A');
                    $mesActual = intval(substr($fecha1, 5, 2));
                    /// END
                    
                    /// validacion para saber si hay restricción de alimentación futuras o no
                    $formulaRestrincion=$row['restrincion'];
                    $mesActualValidado=$fecha1;
                    /*
                    if($formulaRestrincion == 'Si'){ 
                        $mesActualValidado=$fecha1;
                    }
                                   
                    if($formulaRestrincion == 'No'){ 
                        $mesActualValidado=$indicadorHasta;
                    }*/
                    /// END
                    
                    
                    //// aplicamos la frecuencia para saber si el dato se encuentra alimentado
                    $frecuenciaIndicador=$row['frecuencia'];
                   
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
                    $mostrarI='0';
                     $indicadorDesde=date("d-m-Y",strtotime($indicadorDesde."- $numeroMeses month"));
                    for($i=1; $i<=$totalMEsesConteo+1; $i++){
                        $indicadorDesde=date("d-m-Y",strtotime($indicadorDesde."+ $numeroMeses month")); // se cambia la frecuencia por mensual, bimensual, trimensual,semestrual, anual.
                        $enviarMeses=intval(substr($indicadorDesde, 3, 2));  /// para sacar el número del mes y encontrar el nombre del mes
                                         
                        setlocale(LC_ALL, 'es_ES');
                        $monthNum  = $enviarMeses;
                        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                        $mostrarMes = strftime('%B', $dateObj->getTimestamp());
                        '--<b>'.$mostrarMes.'</b><br>';
                        $mostrarI++;
                        
                       
                        /// vamos a comparar los meses alimentados
                       
                    }
                    
                    //echo '<td>'.$conteoCompletoRegistradoConteo.'--'.$mostrarI.'</td>';
                    
                    
                    
                    if($conteoCompletoRegistradoConteo >= $mostrarI  && $anoPresente <= $anoPresenteBasedeDatos){ 
                        
                        
                        
                        
                        if($conteoCompletoRegistradoConteo == '0'){
                            echo "<td style='text-align:justify;'><font color='red'>Sin alimentar</font></td>";
                        }else{
                            echo "<td style='text-align:justify;'><font color='green'>  Alimentado </font></td>";
                        }
                        
                        
                    }else{
                        
                        echo "<td style='text-align:justify;'><font color='red'> Sin alimentar </font></td>";
                    
                        
                    }
                    
                    if($row['terminar'] == 'Terminado'){
                    //echo"<form action='cargosEditar' method='POST'>";
                    echo"<input type='hidden' name='id' value= '$id' >";
                    echo" <td><button disabled type='submit' class='btn btn-block btn-success btn-sm'><i class='fas fa-clipboard-check'></i> Terminado</button></td>";
                    //echo"</form>";
                    }else{
                        
                        if($sesion == $row['quienCrea']){
                            if($row['terminar'] == 'Pendiente2'){
                                echo"<form action='indicadoresAgregar2' method='POST'>";
                                echo"<input type='hidden' name='quienCrea' value= '$quienCrea' >";
                                echo"<input type='hidden' name='variablesIdPrincipal' value= '$id' >";
                                echo" <td><button style='background:#F7FA1E;' type='submit' class='btn btn-block btn btn-sm'><i class='fas fa-user-edit'></i> Proceso</button></td>";
                                echo"</form>";
                            }
                            elseif($row['terminar'] == 'Pendiente2.2'){
                                echo"<form action='indicadoresAgregar2.2' method='POST'>";
                                echo"<input type='hidden' name='quienCrea' value= '$quienCrea' >";
                                echo"<input type='hidden' name='variablesIdPrincipal' value= '$id' >";
                                echo" <td><button style='background:#F7FA1E;' type='submit' class='btn btn-block btn btn-sm'><i class='fas fa-user-edit'></i> Proceso</button></td>";
                                echo"</form>";
                            }
                            elseif($row['terminar'] == 'Pendiente3'){
                                echo"<form action='indicadoresAgregar3' method='POST'>";
                                echo"<input type='hidden' name='quienCrea' value= '$quienCrea' >";
                                echo"<input type='hidden' name='variablesIdPrincipal' value= '$id' >";
                                echo" <td><button style='background:#F7FA1E;' type='submit' class='btn btn-block btn btn-sm'><i class='fas fa-user-edit'></i> Proceso</button></td>";
                                echo"</form>";
                            }
                        }else{
                           
                               
                                echo" <td><button style='background:#F7FA1E;' type='submit' class='btn btn-block btn btn-sm' onclick='return ConfirmPermiso()'><i class='fas fa-edit'></i> Proceso</button></td>";
                                
                        }  
                            
                    
                    }
                    
                   
                        $permisoVerMas = FALSE;
                     
                        $quienElabora = $row['radioVisualizar']; 
                        $quienElaboraID = json_decode($row['autorizadoVisualizar']);
                        
                        if($quienElabora == "cargo"){
                            if(in_array($cargo,$quienElaboraID)){
                                $permisoVerMas = TRUE;
                            }
                        }
                        
                        if($quienElabora == "usuario"){
                            if(in_array($idparaChat,$quienElaboraID)){
                                $permisoVerMas = TRUE;
                            }
                        }
                    
                        if($permisoVerMas == FALSE){
                            $habilitarSeguimieto = "disabled";
                        }else{
                            $habilitarSeguimieto = "";
                        }
                        
                       if($quienCrea == $sesion){
                           $habilitarSeguimieto = "";
                       }
                        
                         echo"<form action='indicadoresVer' method='POST'>";
                         echo"<input type='hidden' name='id' value='$id'>";
                         echo"<td><button type='submit' class='btn btn-block btn-primary btn-sm' $habilitarSeguimieto><i class='fas fa-eye'></i> Ver m&aacute;s </button></td>";
                         echo"</form>";
                         
                        
                  
                                
                                
                   //////////// validacion por cargo de gestionar
                    
                        $permisoEditarIndicador = FALSE;
                     
                        $quienEditaIndicador = $row['radioEditar']; 
                        $quienEditaIndicadorID = json_decode($row['autorizadoEditar']);
                        
                        if($quienEditaIndicador == "cargo"){
                            if(in_array($cargo,$quienEditaIndicadorID)){
                                $permisoEditarIndicador = TRUE;
                            }
                        }
                        
                        if($quienEditaIndicador == "usuario"){
                            if(in_array($idparaChat,$quienEditaIndicadorID)){
                                $permisoEditarIndicador = TRUE;
                            }
                        }
                    
                        if($permisoEditarIndicador == FALSE){
                            $habilitarEditarIndicador = "disabled";
                        }else{
                            $habilitarEditarIndicador = "";
                        }
                    
                    
                    if($root == 1){
                         echo"<form action='indicadoresEditar1' method='POST'>";
                        echo"<input type='hidden' name='id' value= '$id' >";
                        echo" <td style='display:;'><button  type='submit' class='btn btn-block btn-success btn-sm' ><i class='fas fa-edit'></i> Editar</button></td>";
                        echo"</form>";
                    }else{
                    
                    
                    echo"<form action='indicadoresEditar1' method='POST'>";
                    echo"<input type='hidden' name='id' value= '$id' >";
                    echo" <td style='display:$visibleE;'><button  type='submit' class='btn btn-block btn-success btn-sm' $habilitarEditarIndicador><i class='fas fa-edit'></i> Editar</button></td>";
                    echo"</form>";
                    }
                    
                    /*
                    echo"<form action='controlador/indicadores/controller' method='POST'>";
                    echo"<input type='hidden' name='id' value= '$id' >";
                    echo" <td style='display:$visibleD;'><button  type='submit' name='Eliminar' class='btn btn-block btn-danger btn-sm' onclick='return ConfirmDelete()' ><i class='fas fa-trash-alt'></i> Eliminar</button></td>";
                    echo"</form>";
                    */
                     /// validaci��n de script y funcion de eliminacion
                        ?>
                        <input type='hidden' id='capturaVariable<?php echo $contador++;?>'  value= '<?php echo $id;?>' >
                        <td style='display:<?php echo $visibleD;?>'><a onclick='funcionFormula<?php echo $contador1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a></td>
                        <script>
                            function funcionFormula<?php echo $contador2++;?>() {
                                /*alert("entre");*/
                              document.getElementById("capturarFormula").value = document.getElementById("capturaVariable<?php echo $contador3++;?>").value;
                            }
                       </script>
                        <?php
                        /// END
                    
                        $permisoGestionar = FALSE;
                     
                        $quienVeGestionar = $row['radioCalculo']; 
                        $quienGestionarID = json_decode($row['responsableCalculo']);
                        
                        if($quienVeGestionar == "cargo"){
                            if(in_array($cargo,$quienGestionarID)){
                                $permisoGestionar = TRUE;
                            }
                        }
                        
                        if($quienVeGestionar == "usuario"){
                            if(in_array($idparaChat,$quienGestionarID)){
                                $permisoGestionar = TRUE;
                            }
                        }
                    
                        if($permisoGestionar == FALSE){
                            $habilitarSeguimietoGestionar = "disabled";
                        }else{
                            $habilitarSeguimietoGestionar = "";
                        }
                    
                    
                    echo"<form action='indicadoresGestionar' method='POST'>";
                    echo"<input type='hidden' name='quienCrea' value= '$quienCrea' >";
                    echo"<input type='hidden' name='variablesIdPrincipal' value= '$id' >";
                    echo" <td ><button  type='submit'  class='btn btn-block btn-warning btn-sm' $habilitarSeguimietoGestionar><i class='fas fa-clipboard'></i> Gestionar</button></td>";
                    echo"</form>";
                    
                    $permisoGestionarIndicador = FALSE;
                     
                        $quienVeGestionarIndicador = $row['radioIndicador']; 
                        $quienGestionarIDIndicador = json_decode($row['resposableIndicador']);
                        
                        if($quienVeGestionarIndicador == "cargo"){
                            if(in_array($cargo,$quienGestionarIDIndicador)){
                                $permisoGestionarIndicador = TRUE;
                            }
                        }
                        
                        if($quienVeGestionarIndicador == "usuario"){
                            if(in_array($idparaChat,$quienGestionarIDIndicador)){
                                $permisoGestionarIndicador = TRUE;
                            }
                        }
                    
                        if($permisoGestionarIndicador == FALSE){
                            $habilitarSeguimietoGestionarIndicador = "disabled";
                        }else{
                            $habilitarSeguimietoGestionarIndicador = "";
                        }
                        
                    echo"<form action='indicadoresGestionar' method='POST'>";
                    echo"<input type='hidden' name='quienCrea' value= '$quienCrea' >";
                    echo"<input type='hidden' name='variablesIdPrincipal' value= '$id' >";
                    echo" <td><button  type='submit'  class='btn btn-block btn-warning btn-sm' $habilitarSeguimietoGestionarIndicador><i class='fas fa-clipboard'></i> Gestionar</button></td>";
                    echo"</form>";
                  
                            
                   //////////// validacion por cargo de gestionar
                  
                   //////////// validacion por cargo de gestionar
                            
                    //// END
                    
                    
                    
                    
                    echo"</tr>";
                
                    }
                    ?>
                     <div class="modal fade" id="modal-danger">
                        <div class="modal-dialog">
                          <div class="modal-content bg-danger">
                            <div class="modal-header">
                              <h4 class="modal-title">Alerta</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <p>¿Est&aacute; seguro que desea eliminar?</p>
                            </div>
                             <!-- formulario para eliminar por el id -->
                            <form action='controlador/indicadores/controller' method='POST'>
                            <div class="modal-footer justify-content-between">
                              <input type="hidden" id="capturarFormula" name='id' readonly>
                              <button type="submit" name='Eliminar' class="btn btn-outline-light">Si</button>
                              <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
                            </div>
                             </form>
                             <!-- END formulario para eliminar por el id -->
                          </div>
                        </div>
                    </div>
                  </tbody>
                </table>
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
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
<!-- Script advertencia eliminar -->
<script type="text/javascript">
	function ConfirmDelete(){
		var answer = confirm("Está seguro de eliminar?");

		if(answer == true){
			return true;
		}else{
			return false;
		}
	}
	
	function ConfirmPermiso(){
		var answer = confirm("No tiene permiso para terminar el indicador !");
    }
</script>

<!-- archivos para el filtro de busqueda y lista de información -->

    <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
 
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <script type="text/javascript" src="datatables/datatables.min.js"></script>    
     
    <script type="text/javascript" src="main.js"></script>
<!-- END -->
<!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<?php
/// validaciones de alertas
$validacionExisteFecha=$_POST['validacionExisteFecha'];
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
    if($validacionExisteFecha == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' La fecha que se ingreso en el campo "Hasta" no debe ser menor a la fecha del campo "Desde".'
        })
    <?php
    }
     if($validacionExiste == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El tipo de indicador ya existe.'
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
<script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>
</body>
</html>
<?php
}
?>