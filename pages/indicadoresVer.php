<?php
error_reporting(E_ERROR);
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
  <title>FIXWEI - Ver Indicador</title>
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
            <h1>Indicadores</h1> 
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Ver indicador</li>
            </ol>
          </div>
        </div>
        <div>
            <div class="row">
                <div class="col">
                    
                </div>
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


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
            <div class="col">
            </div>
            <div class="col-9">
               
                <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
             
                <div class="card-body">
                    
                <?php
                $recibeID=$_POST['id'];
                $consultaVerIndicador = $mysqli->query("SELECT * FROM `indicadores` WHERE id='$recibeID' ");
                $verIndicador = $consultaVerIndicador->fetch_array(MYSQLI_ASSOC);
                
                ?>
                
                <!-- Primera vista  -->
                <div id="primeraVista">
                    <div class="card-header">
                      <div class="row">
                        <div class="form-group col-sm-6">
                           
                            <label>Nombre:</label><br>
                           
                            <?php echo $verIndicador['nombre']; ?>
                            <br><br><br>
                            <label>Descripción:</label>
                            <textarea type="text" class="form-control" readonly style="border-color:white;background:white;" name="descripcion" placeholder="Descripción" required><?php echo $verIndicador['descripcion']; ?></textarea>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Tipo de indicador:</label><br>
                            <?php
                                //require_once'conexion/bd.php';
                                $tipoIndicador=$verIndicador['tipoIndicador'];
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $resultadoTipo=$mysqli->query("SELECT * FROM indicadoresTipo Where id='$tipoIndicador' ");
                                    while ($columnaTipo = mysqli_fetch_array( $resultadoTipo )) {
                                     echo $columnaTipo['tipo']; 
                                    }  ?>
                            <br><br><br>
                            <label>Responsable Indicador: </label><br>
                            
                            <div class="select2-blue">
                            <?php 
                            $tipoResponsableV=$verIndicador['radioIndicador'];
                            $personalIDV =  json_decode($verIndicador['resposableIndicador']);
                            $longitudV = count($personalIDV);
                   
                             if($tipoResponsableV == 'usuario'){
                                    for($i=0; $i<$longitudV; $i++){ //// inicia for
                                                
                                                $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$personalIDV[$i]' ");
                                                while($columna = $nombreuser->fetch_assoc()){
                                                    echo $cedulaUsuario=$columna['nombres'].' '.$cedulaUsuario=$columna['apellidos']; echo "<br>";
                                                }
                                            }  /////// cierre del for
                                            
                                            
                                
                            }else{    
                               
                                for($i=0; $i<$longitudV; $i++){ //// inicia for
                                                
                                                $nombreuser = $mysqli->query("SELECT * FROM cargos WHERE id_cargos = '$personalIDV[$i]' ");
                                                while($columna = $nombreuser->fetch_assoc()){
                                                    echo $cedulaUsuario=$columna['nombreCargos']; echo "<br>";
                                                }
                                            }  /////// cierre del for    
                                
                            }
                            
                            ?>
                            </div>
                        
                        </div>
                      </div>
                    </div>
                    <div class="card-header">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label>Desde:</label><br>
                                <?php echo $verIndicador['desdeMostrar'];//$verIndicador['desde']; ?>
                                <br><br><br>
                                <label>Hasta:</label><br>
                                <?php echo $verIndicador['hasta']; ?>
                                <br><br><br>
                                
                                <?php  $frecuenciaIndicador=$verIndicador['frecuencia']; ?>
                                <!--<input type="date" class="form-control" value="" name="nombre" placeholder="Hasta" required>-->
                             
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Sentido:</label><br>
                                <?php echo $verIndicador['sentido']; ?>
                                <br><br><br>
                                <label>Proceso:</label><br>
                                <?php
                                $idProceso=$verIndicador['proceso'];
                                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                                    $resultadoProceso=$mysqli->query("SELECT * FROM procesos WHERE id='$idProceso' ");
                               
                                        while ($columnaProceso = mysqli_fetch_array( $resultadoProceso )) { 
                                         echo $columnaProceso['nombre'];  } 
                                ?>
                                <br><br><br>
                               
                                <?php  $restrincionIndicador=$verIndicador['restrincion']; ?>
                            </div>                        
                        </div>
                    </div>
                    <div class="card-header">
                        <div class="row">
                           <div class="form-group col-sm-6">
                                
                                <label>Autorizados para Visualizar: </label><br>
                                <div class="select2-blue" >
                                <?php 
                                $tipoResponsableVisualizar=$verIndicador['radioVisualizar'];
                                $personalIDVisualizar =  json_decode($verIndicador['autorizadoVisualizar']);
                                $longitudVisualizar = count($personalIDVisualizar);
                       
                                 if($tipoResponsableVisualizar == 'usuario'){
                                        for($i=0; $i<$longitudVisualizar; $i++){ //// inicia for
                                                    
                                                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$personalIDVisualizar[$i]' ORDER BY nombres ");
                                                    while($columna = $nombreuser->fetch_assoc()){
                                                        echo $cedulaUsuario=$columna['nombres'].' '.$cedulaUsuario=$columna['apellidos']; echo "<br>";
                                                    }
                                                }  /////// cierre del for
                                                
                                                
                                    
                                }else{    
                                   
                                    for($i=0; $i<$longitudVisualizar; $i++){ //// inicia for
                                                    
                                                    $nombreuser = $mysqli->query("SELECT * FROM cargos WHERE id_cargos = '$personalIDVisualizar[$i]' ORDER BY nombreCargos ");
                                                    while($columna = $nombreuser->fetch_assoc()){
                                                        echo $cedulaUsuario=$columna['nombreCargos']; echo "<br>";
                                                    }
                                                }  /////// cierre del for    
                                    
                                }
                                
                                ?>
                                </div>
                           
                      
                                
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Frecuencia de cálculo:</label><br>
                                <?php echo $verIndicador['frecuencia']; ?>
                                <br><br><br>
                                <label>¿Restringir la alimentación o análisis para fechas futuras?:</label><br>
                                <?php echo $verIndicador['restrincion']; ?>
                                <br><br><br>
                                <label>Clasificación:</label><br>
                                <?php echo $verIndicador['clasificacion']; ?>
                            </div> 
                       </div>
                    </div>
                  
                    <div class="row">
                      <div class="form-group col-sm-6">
                          
                        <label>Autorizados para editar: </label><br>
                            <div class="select2-blue" >
                            <?php 
                            $tipoResponsableEditar=$verIndicador['radioEditar'];
                            $personalIDEditar =  json_decode($verIndicador['autorizadoEditar']);
                            $longitudEditar = count($personalIDEditar);
                   
                             if($tipoResponsableEditar == 'usuario'){
                                    for($i=0; $i<$longitudEditar; $i++){ //// inicia for
                                                
                                                $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$personalIDEditar[$i]' ORDER BY nombres ");
                                                while($columna = $nombreuser->fetch_assoc()){
                                                    echo $cedulaUsuario=$columna['nombres'].' '.$cedulaUsuario=$columna['apellidos']; echo "<br>";
                                                }
                                            }  /////// cierre del for
                                            
                                            
                                
                            }else{    
                               
                                for($i=0; $i<$longitudEditar; $i++){ //// inicia for
                                                
                                                $nombreuser = $mysqli->query("SELECT * FROM cargos WHERE id_cargos = '$personalIDEditar[$i]' ORDER BY nombreCargos ");
                                                while($columna = $nombreuser->fetch_assoc()){
                                                    echo $cedulaUsuario=$columna['nombreCargos']; echo "<br>";
                                                }
                                            }  /////// cierre del for    
                                
                            }
                            
                            ?>
                            </div>
                           
                      
                      </div>
                      <div class="form-group col-sm-6">
                        <label>Responsable del Cálculo: </label><br>
                            <div class="select2-blue">
                            <?php 
                            $tipoResponsableV=$verIndicador['radioCalculo'];
                            $personalIDV =  json_decode($verIndicador['responsableCalculo']);
                            $longitudV = count($personalIDV);
                   
                             if($tipoResponsableV == 'usuario'){
                                    for($i=0; $i<$longitudV; $i++){ //// inicia for
                                                
                                                $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$personalIDV[$i]' ");
                                                while($columna = $nombreuser->fetch_assoc()){
                                                    echo $cedulaUsuario=$columna['nombres'].' '.$cedulaUsuario=$columna['apellidos']; echo "<br>";
                                                }
                                            }  /////// cierre del for
                                            
                                            
                                
                            }else{    
                               
                                for($i=0; $i<$longitudV; $i++){ //// inicia for
                                                
                                                $nombreuser = $mysqli->query("SELECT * FROM cargos WHERE id_cargos = '$personalIDV[$i]' ");
                                                while($columna = $nombreuser->fetch_assoc()){
                                                    echo $cedulaUsuario=$columna['nombreCargos']; echo "<br>";
                                                }
                                            }  /////// cierre del for    
                                
                            }
                            
                            ?>
                            </div>
                      </div>
                      
                  </div>
                  <div class="row">
                      <div class="form-group col-sm-6">
                          
                      </div>
                      <div class="form-group col-sm-6">
                            <!-- <button type="submit" style="color:white;" class="btn btn-warning float-right" name="siguiente" id="vistaA">Siguiente</button> -->
                      </div>
                      
                  </div>
                </div>
                <!-- Primera vista  -->
                
                <!-- Segunda vista  style="display:none;" -->
                <div id="segundaVista" >
                    
                    <?php
                            /// traemos la información de la meta
                           
                            $consultaMeta=$mysqli->query("SELECT * FROM indicadoresMetas WHERE idIndicador='$recibeID'  ");
                            while($traeMeta=$consultaMeta->fetch_array()){
                            
                    ?>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Fórmula:</label><br>
                                    <?php echo $verIndicador['formula']; ?>
                        </div>
                        <div class="form-group col-sm-6">
                            
                            <label>Meta actual:</label><br>
                            <?php 
                            if( $traeMeta['unidad'] == '$'){
                                echo '$'.number_format($traeMeta['metaActual'],0,'.',',');
                            }else{
                                echo $traeMeta['metaActual'];
                            }   
                            ?>        
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Desde:</label><br>
                            <?php echo $traeMeta['desde']; ?>        
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Hasta:</label><br>
                            <?php echo $traeMeta['hasta']; ?>        
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        if($verIndicador['sentido'] == 'Positivo'){
                        
                            if( $traeMeta['unidad'] == '$'){
                            ?>
                            <input name="zp" value="$<?php echo number_format($traeMeta['zp'],0,'.',','); ?>" title="Zona de Peligro" placeholder="Zona de Peligro" style="text-align:center;border-color:red;background:red;color:white;border:0px;width: 20%;" readonly>
                            <input name="za" value="$<?php echo number_format($traeMeta['za'],0,'.',','); ?>" title="Zona de alerta" placeholder="Zona de alerta" style="text-align:center;border-color:yellow;background:yellow;color:black;border:0px;width: 20%;" readonly>
                            <input name="zc" value="$<?php echo number_format($traeMeta['zc'],0,'.',','); ?>" title="Zona de Cumplimiento" placeholder="Zona de Cumplimiento" style="text-align:center;border-color:green;background:green;color:white;border:0px;width: 20%;" readonly>
                            <input name="ze" value="$<?php echo number_format($traeMeta['ze'],0,'.',','); ?>" title="Zona de Exceso" placeholder="Zona de Exceso" style="text-align:center;border-color:blue;background:blue;color:white;border:0px;width: 20%;" readonly>
                                    
                            <?php
                            }else{
                            ?>
                            <input name="zp" value="<?php echo $traeMeta['zp']; ?>" title="Zona de Peligro" placeholder="Zona de Peligro" style="text-align:center;border-color:red;background:red;color:white;border:0px;width: 20%;" readonly>
                            <input name="za" value="<?php echo $traeMeta['za']; ?>" title="Zona de alerta" placeholder="Zona de alerta" style="text-align:center;border-color:yellow;background:yellow;color:black;border:0px;width: 20%;" readonly>
                            <input name="zc" value="<?php echo $traeMeta['zc']; ?>" title="Zona de Cumplimiento" placeholder="Zona de Cumplimiento" style="text-align:center;border-color:green;background:green;color:white;border:0px;width: 20%;" readonly>
                            <input name="ze" value="<?php echo $traeMeta['ze']; ?>" title="Zona de Exceso" placeholder="Zona de Exceso" style="text-align:center;border-color:blue;background:blue;color:white;border:0px;width: 20%;" readonly>
                             <?php 
                            }
                        }else{
                            if( $traeMeta['unidad'] == '$'){
                            ?>
                            <input name="ze" value="$<?php echo number_format($traeMeta['ze'],0,'.',','); ?>" title="Zona de Exceso" placeholder="Zona de Exceso" style="text-align:center;border-color:blue;background:blue;color:white;border:0px;width: 20%;" readonly>
                            <input name="zc" value="$<?php echo number_format($traeMeta['zc'],0,'.',','); ?>" title="Zona de Cumplimiento" placeholder="Zona de Cumplimiento" style="text-align:center;border-color:green;background:green;color:white;border:0px;width: 20%;" readonly>
                            <input name="za" value="$<?php echo number_format($traeMeta['za'],0,'.',','); ?>" title="Zona de alerta" placeholder="Zona de alerta" style="text-align:center;border-color:yellow;background:yellow;color:black;border:0px;width: 20%;" readonly>
                            <input name="zp" value="$<?php echo number_format($traeMeta['zp'],0,'.',','); ?>" title="Zona de Peligro" placeholder="Zona de Peligro" style="text-align:center;border-color:red;background:red;color:white;border:0px;width: 20%;" readonly>
                            <?php
                            }else{
                            ?>    
                            <input name="ze" value="<?php echo $traeMeta['ze']; ?>" title="Zona de Exceso" placeholder="Zona de Exceso" style="text-align:center;border-color:blue;background:blue;color:white;border:0px;width: 20%;" readonly>
                            <input name="zc" value="<?php echo $traeMeta['zc']; ?>" title="Zona de Cumplimiento" placeholder="Zona de Cumplimiento" style="text-align:center;border-color:green;background:green;color:white;border:0px;width: 20%;" readonly>
                            <input name="za" value="<?php echo $traeMeta['za']; ?>" title="Zona de alerta" placeholder="Zona de alerta" style="text-align:center;border-color:yellow;background:yellow;color:black;border:0px;width: 20%;" readonly>
                            <input name="zp" value="<?php echo $traeMeta['zp']; ?>" title="Zona de Peligro" placeholder="Zona de Peligro" style="text-align:center;border-color:red;background:red;color:white;border:0px;width: 20%;" readonly>
                            <?php
                            }
                        }
                        ?>
                    </div>
                    <br>
                    <?php
                        }
                    ?>
                    
                    <br><br>
                    
                    <?php
                    //// traemos las fechas de acuerdo al id del indicador
                    $validarExistenciaFecha=$mysqli->query("SELECT * FROM indicadoresGestionar WHERE idIndicador='$recibeID' GROUP BY anoPresente");
                    while($extrafechaIdIndicador=$validarExistenciaFecha->fetch_array()){
                       // echo ' <a href="#" style="color:white;" class="btn btn-warning" id="'.$extrafechaIdIndicador['anoPresente'].'" > Año '.$extrafechaIdIndicador['anoPresente'].'</a><br><br>';
                    
                            //echo ' <a href="#" style="color:white;display:none;" class="btn btn-success" id="cerrar'.$extrafechaIdIndicador['anoPresente'].'" > Cerrar</a><br><br>';
                   
                    }
                    ?>
                    
                    
                        <div class="row">
                            <div class="card-body table-responsive p-0" style="height: 800px;">
                                        <table class="table table-head-fixed text-center">
                                          <thead>
                                            <tr>
                                                <?php 
                                               //// se trae los datos de las metas
                                               $variablesIdPrincipal=$recibeID;
                                               $acentos = $mysqli->query("SET NAMES 'utf8'");
                                               $indicadorMeta=$mysqli->query("SELECT * FROM `indicadoresMetas` WHERE idIndicador='$variablesIdPrincipal' AND anoPresente='2020' ");
                                               $extraeDatoIndicadorMeta= $indicadorMeta->fetch_array(MYSQLI_ASSOC);
                                               $saleIndicadorMeta=$extraeDatoIndicadorMeta['metaActual'];
                                               //// END
                                               
                                               //// se trae los datos de la formula
                                               $acentos = $mysqli->query("SET NAMES 'utf8'");
                                               $indicadorFormular=$mysqli->query("SELECT * FROM `indicadores` WHERE id='$variablesIdPrincipal'  ");
                                               $extraeDatoIndicadorFormula= $indicadorFormular->fetch_array(MYSQLI_ASSOC);
                                               $saleIndicadorFormula=$extraeDatoIndicadorFormula['formula'];
                                               $indicadorDesde=$extraeDatoIndicadorFormula['desde'];
                                               $indicadorHasta=$extraeDatoIndicadorFormula['hasta'];
                                                    // necesitamos esta condición para poder validar si el mes siguiente podemos ver o no
                                                    $formulaRestrincion=$extraeDatoIndicadorFormula['restrincion'];
                                                    // END
                                               //// END
                                               
                                               
                                               ?>
                                                        <th>
                                                            <b>Fecha, desde <?php echo $verIndicador['desdeMostrar']; //$indicadorDesde; ?>, hasta <?php echo $indicadorHasta;?></b>
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
                                                       
                                            </tr>
                                          </thead>
                                          <tbody>
                                             
                                                 <?php
                                                    
                                                    
                                                        //// mes actual capturado
                                                        date_default_timezone_set('America/Bogota');$fecha1=date('Y-m-j h:i:s A');
                                                        $mesActual = intval(substr($fecha1, 5, 2));
                                                        /// END
                                                    
                                                        $anoPresente = substr($fecha1, 0, 4); // variable anterior $indicadorDesde
                                                        
                                                        $indicadorDesde;
                                                        
                                                        $mesDesde = intval(substr($indicadorDesde, 5, 2));
                                                        $mesHasta = intval(substr($indicadorHasta, 5, 2));
                                                        $validandoAñoMaximo = intval(substr($indicadorHasta, 0, 4)); 
                                                        //$mesactual = substr($indicadorDesde, 0, 7);
                                                        //se valida los meses//
                                                        //echo '<br>';
                                                        
                                                        /// validacion para saber si hay restricción de alimentación futuras o no
                                                        if($formulaRestrincion == 'Si'){ 
                                                            $mesActualValidado=date('Y-m-j');
                                                        }
                                                       
                                                        if($formulaRestrincion == 'No'){ 
                                                            $mesActualValidado=$indicadorHasta;
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
                                     $indicadorDesde=date("d-m-Y",strtotime($indicadorDesde."- $numeroMeses month"));       
                                    /// realizamos el recorrido para mostrar los meses
                                    for($i=1; $i<=$totalMEsesConteo+1; $i++){
                                        
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
                                                                                $anoPresente=intval(substr($indicadorDesde, 6, 4));
                                                                                   echo '<center>Mes <b>'.$mostrarMes;
                                                                                   echo'</b>, del año <b>'.$anoPresente.'</b></center>'; //$anoPresente
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
                                                                                                 
                                                                                                $ultimoIndicadoMes=$mysqli->query("SELECT * FROM `indicadoresGestionar` WHERE idIndicador='$variablesIdPrincipal' AND mes='$mostrarMes' AND anoPresente='$anoPresente' AND alimentado IS not NULL GROUP BY mes ");
                                                                                                $extraeDatoIndicadorMes= $ultimoIndicadoMes->fetch_array(MYSQLI_ASSOC);
                                                                                                  '<br>resultado: '.$DatoAlimentado=$extraeDatoIndicadorMes['alimentado'];
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
                                                                                <td data-titulo="Meta">
                                                                                  <?php
                                                                                                
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
                                                                                        echo"
                                                                                          
                                                                                            <i class='fas fa-download'></i>
                                                                                            <a style='color:black' href='$ruta' download='' target='_blank'>$nombreDocumento</a>
                                                                                        
                                                                                        <br>";
                                                                                       
                                                                                       }
                                                                                       }
                                                                                       //// END
                                                                                       
                                                                                       
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
                                                                                   
                                                                                        if($metaFormula != NULL){
                                                                                            $habilitaBotonDisabled='';
                                                                                        }else{
                                                                                            $habilitaBotonDisabled='disabled';
                                                                                        }
                                                                                    ?>
                                                                                  
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
                        <section class="content">
                              <div class="container-fluid">
                                <div class="row">
                                  <div class="col-md-6">
                                    <!-- AREA CHART -->
                                    <div class="card card-primary">
                                      <div class="card-header">
                                        <h3 class="card-title">Area</h3>
                        
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
                                        <h3 class="card-title">Dona</h3>
                        
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
                                        <h3 class="card-title">Torta</h3>
                        
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
                                        <h3 class="card-title">Linea</h3>
                        
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
                                        <h3 class="card-title">Barra</h3>
                        
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
                                        <h3 class="card-title">Barras apiladas</h3>
                        
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
                            
                            ///// datos
                            $datos1=$_POST['dato1'];
                            $datos2=$_POST['dato2'];
                            $datos3=$_POST['dato3'];
                            ?>
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
                                  labels  : [<?  $consultarParaGraficarMeses=$mysqli->query("SELECT * FROM indicadoresGestionar WHERE idIndicador='$variablesIdPrincipal' AND alimentado IS not NULL GROUP BY mes ");
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
                                       data:[<?  $consultarParaGraficarMesesResultado=$mysqli->query("SELECT * FROM indicadoresGestionar WHERE idIndicador='$variablesIdPrincipal' AND alimentado IS not NULL GROUP BY mes ");
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
                                       data:[<?  $consultarParaGraficarMesesResultado=$mysqli->query("SELECT * FROM indicadoresGestionar WHERE idIndicador='$variablesIdPrincipal' AND alimentado IS not NULL GROUP BY mes ");
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
                                  labels  : [<?  $consultarParaGraficarMeses=$mysqli->query("SELECT * FROM indicadoresGestionar WHERE idIndicador='$variablesIdPrincipal' AND alimentado IS not NULL GROUP BY mes ");
                                                    while($imprimirGraficaMeses=$consultarParaGraficarMeses->fetch_array()){
                                                        $imprimiendoMEs=$imprimirGraficaMeses['mes'];
                                                        $imprimiendoMEs = ucwords($imprimiendoMEs);
                                                        $imprimiendoAnoPresente=$imprimirGraficaMeses['anoPresente'];
                                                        echo "  '$imprimiendoMEs $imprimiendoAnoPresente', ";
                                                            }
                                                ?>],
                                  datasets: [
                                    {
                                      data:[<?  $consultarParaGraficarMesesResultado=$mysqli->query("SELECT * FROM indicadoresGestionar WHERE idIndicador='$variablesIdPrincipal' AND alimentado IS not NULL GROUP BY mes ");
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
                    
                    
                          
                    
                    <button type="button" style="color:white;" class="btn btn-warning float-left" onclick="window.print('areaImprimir');return false;" >Imprimir</button>
                    <!-- <button type="submit" style="color:white;" class="btn btn-success float-right" name="" id="vistaB">Regresar</button> -->
                </div>
                <!-- Segunda vista  onclick="printDiv('areaImprimir')" -->
                
                
                <!-- creamos el div para la impresión de datos en pdf  
                <script>
                	function printDiv(areaImprimir) {
                         var contenido= document.getElementById(areaImprimir).innerHTML;
                         var contenidoOriginal= document.body.innerHTML;
                    
                         document.body.innerHTML = contenido;
                    
                         window.print();
                    
                         document.body.innerHTML = contenidoOriginal;
                    }
                </script> -->
                <div style="display:none;" id="areaImprimir">
                    
                    <div class="card-header">
                      <div class="row">
                        <div class="form-group col-sm-6">
                           
                            <label>Nombre:</label><br>
                           
                            <?php echo $verIndicador['nombre']; ?>
                            <br><br><br>
                            <label>Descripción:</label>
                            <textarea type="text" class="form-control" readonly style="border-color:white;background:white;" name="descripcion" placeholder="Descripción" required><?php echo $verIndicador['descripcion']; ?></textarea>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Tipo de indicador:</label><br>
                            <?php
                                //require_once'conexion/bd.php';
                                $tipoIndicador=$verIndicador['tipoIndicador'];
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $resultadoTipo=$mysqli->query("SELECT * FROM indicadoresTipo Where id='$tipoIndicador' ");
                                    while ($columnaTipo = mysqli_fetch_array( $resultadoTipo )) {
                                     echo $columnaTipo['tipo']; 
                                    }  ?>
                            <br><br><br>
                            <label>Responsable Indicador: </label><br>
                            
                            <div class="select2-blue">
                            <?php 
                            $tipoResponsableV=$verIndicador['radioIndicador'];
                            $personalIDV =  json_decode($verIndicador['resposableIndicador']);
                            $longitudV = count($personalIDV);
                   
                             if($tipoResponsableV == 'usuario'){
                                    for($i=0; $i<$longitudV; $i++){ //// inicia for
                                                
                                                $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$personalIDV[$i]' ");
                                                while($columna = $nombreuser->fetch_assoc()){
                                                    echo $cedulaUsuario=$columna['nombres'].' '.$cedulaUsuario=$columna['apellidos']; echo "<br>";
                                                }
                                            }  /////// cierre del for
                                            
                                            
                                
                            }else{    
                               
                                for($i=0; $i<$longitudV; $i++){ //// inicia for
                                                
                                                $nombreuser = $mysqli->query("SELECT * FROM cargos WHERE id_cargos = '$personalIDV[$i]' ");
                                                while($columna = $nombreuser->fetch_assoc()){
                                                    echo $cedulaUsuario=$columna['nombreCargos']; echo "<br>";
                                                }
                                            }  /////// cierre del for    
                                
                            }
                            
                            ?>
                            </div>
                        
                        </div>
                      </div>
                    </div>
                    <div class="card-header">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label>Desde:</label><br>
                                <?php echo $verIndicador['desdeMostrar'];//$verIndicador['desde']; ?>
                                <br><br><br>
                                <label>Hasta:</label><br>
                                <?php echo $verIndicador['hasta']; ?>
                                <br><br><br>
                                
                                <?php  $frecuenciaIndicador=$verIndicador['frecuencia']; ?>
                                <!--<input type="date" class="form-control" value="" name="nombre" placeholder="Hasta" required>-->
                             
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Sentido:</label><br>
                                <?php echo $verIndicador['sentido']; ?>
                                <br><br><br>
                                <label>Proceso:</label><br>
                                <?php
                                $idProceso=$verIndicador['proceso'];
                                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                                    $resultadoProceso=$mysqli->query("SELECT * FROM procesos WHERE id='$idProceso' ");
                               
                                        while ($columnaProceso = mysqli_fetch_array( $resultadoProceso )) { 
                                         echo $columnaProceso['nombre'];  } 
                                ?>
                                <br><br><br>
                               
                                <?php  $restrincionIndicador=$verIndicador['restrincion']; ?>
                            </div>                        
                        </div>
                    </div>
                    <div class="card-header">
                        <div class="row">
                           <div class="form-group col-sm-6">
                                
                                <label>Autorizados para Visualizar: </label><br>
                                <div class="select2-blue" >
                                <?php 
                                $tipoResponsableVisualizar=$verIndicador['radioVisualizar'];
                                $personalIDVisualizar =  json_decode($verIndicador['autorizadoVisualizar']);
                                $longitudVisualizar = count($personalIDVisualizar);
                       
                                 if($tipoResponsableVisualizar == 'usuario'){
                                        for($i=0; $i<$longitudVisualizar; $i++){ //// inicia for
                                                    
                                                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$personalIDVisualizar[$i]' ORDER BY nombres ");
                                                    while($columna = $nombreuser->fetch_assoc()){
                                                        echo $cedulaUsuario=$columna['nombres'].' '.$cedulaUsuario=$columna['apellidos']; echo "<br>";
                                                    }
                                                }  /////// cierre del for
                                                
                                                
                                    
                                }else{    
                                   
                                    for($i=0; $i<$longitudVisualizar; $i++){ //// inicia for
                                                    
                                                    $nombreuser = $mysqli->query("SELECT * FROM cargos WHERE id_cargos = '$personalIDVisualizar[$i]' ORDER BY nombreCargos ");
                                                    while($columna = $nombreuser->fetch_assoc()){
                                                        echo $cedulaUsuario=$columna['nombreCargos']; echo "<br>";
                                                    }
                                                }  /////// cierre del for    
                                    
                                }
                                
                                ?>
                                </div>
                           
                      
                                
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Frecuencia de cálculo:</label><br>
                                <?php echo $verIndicador['frecuencia']; ?>
                                <br><br><br>
                                <label>¿Restringir la alimentación o análisis para fechas futuras?:</label><br>
                                <?php echo $verIndicador['restrincion']; ?>
                                <br><br><br>
                                <label>Clasificación:</label><br>
                                <?php echo $verIndicador['clasificacion']; ?>
                            </div> 
                       </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-sm-6">
                          
                        <label>Autorizados para editar: </label><br>
                            <div class="select2-blue" >
                            <?php 
                            $tipoResponsableEditar=$verIndicador['radioEditar'];
                            $personalIDEditar =  json_decode($verIndicador['autorizadoEditar']);
                            $longitudEditar = count($personalIDEditar);
                   
                             if($tipoResponsableEditar == 'usuario'){
                                    for($i=0; $i<$longitudEditar; $i++){ //// inicia for
                                                
                                                $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$personalIDEditar[$i]' ORDER BY nombres ");
                                                while($columna = $nombreuser->fetch_assoc()){
                                                    echo $cedulaUsuario=$columna['nombres'].' '.$cedulaUsuario=$columna['apellidos']; echo "<br>";
                                                }
                                            }  /////// cierre del for
                                            
                                            
                                
                            }else{    
                               
                                for($i=0; $i<$longitudEditar; $i++){ //// inicia for
                                                
                                                $nombreuser = $mysqli->query("SELECT * FROM cargos WHERE id_cargos = '$personalIDEditar[$i]' ORDER BY nombreCargos ");
                                                while($columna = $nombreuser->fetch_assoc()){
                                                    echo $cedulaUsuario=$columna['nombreCargos']; echo "<br>";
                                                }
                                            }  /////// cierre del for    
                                
                            }
                            
                            ?>
                            </div>
                           
                      
                      </div>
                      <div class="form-group col-sm-6">
                        <label>Responsable del Cálculo: </label><br>
                            <div class="select2-blue">
                            <?php 
                            $tipoResponsableV=$verIndicador['radioCalculo'];
                            $personalIDV =  json_decode($verIndicador['responsableCalculo']);
                            $longitudV = count($personalIDV);
                   
                             if($tipoResponsableV == 'usuario'){
                                    for($i=0; $i<$longitudV; $i++){ //// inicia for
                                                
                                                $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$personalIDV[$i]' ");
                                                while($columna = $nombreuser->fetch_assoc()){
                                                    echo $cedulaUsuario=$columna['nombres'].' '.$cedulaUsuario=$columna['apellidos']; echo "<br>";
                                                }
                                            }  /////// cierre del for
                                            
                                            
                                
                            }else{    
                               
                                for($i=0; $i<$longitudV; $i++){ //// inicia for
                                                
                                                $nombreuser = $mysqli->query("SELECT * FROM cargos WHERE id_cargos = '$personalIDV[$i]' ");
                                                while($columna = $nombreuser->fetch_assoc()){
                                                    echo $cedulaUsuario=$columna['nombreCargos']; echo "<br>";
                                                }
                                            }  /////// cierre del for    
                                
                            }
                            
                            ?>
                            </div>
                      </div>
                      
                  </div>
         
                    
                
                </div>
                <!-- end  -->
                
                
                </div>
                <!-- /.card-body -->

            </div>
            </div>    

        <div class="col">
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
<script>
        $(document).ready(function(){
            $('#vistaA').click(function(){
                document.getElementById('primeraVista').style.display = 'none';
                document.getElementById('segundaVista').style.display = '';
            });
            $('#vistaB').click(function(){
                document.getElementById('primeraVista').style.display = '';
                document.getElementById('segundaVista').style.display = 'none';
            });
            
});
</script>


<script>
    $(document).ready(function(){
            $('#siguienteA').click(function(){
                document.getElementById('primeraVista').style.display = 'none';
                document.getElementById('tercerVista').style.display = 'none';
                document.getElementById('segundaVista').style.display = '';
                
            });
            $('#siguienteB').click(function(){
                document.getElementById('primeraVista').style.display = 'none';
                document.getElementById('segundaVista').style.display = 'none';
                document.getElementById('tercerVista').style.display = '';
            });
            
            $('#regresarA').click(function(){
                document.getElementById('primeraVista').style.display = '';
                document.getElementById('segundaVista').style.display = 'none';
                document.getElementById('tercerVista').style.display = 'none';
               
            });
            $('#regresarB').click(function(){
                document.getElementById('primeraVista').style.display = 'none';
                document.getElementById('segundaVista').style.display = '';
                document.getElementById('tercerVista').style.display = 'none';
               
            });
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