<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';

//////////////////////PERMISOS////////////////////////
require_once 'conexion/bd.php';

$formulario = 'usuarios'; //Se cambia el nombre del formulario

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
}
//////////////////////PERMISOS////////////////////////

?>
<!DOCTYPE html>
<html>
    <title>Ver Presupuesto</title>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
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
<body class="hold-transition sidebar-mini" onload="nobackbutton();" oncopy="return false" onpaste="return false">
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
              $idPresupuesto=$_POST['idPresupuesto'];
               
                    $query = $mysqli->query("SELECT * FROM presupuesto WHERE id= '$idPresupuesto'");
                    $row = $query->fetch_array(MYSQLI_ASSOC);
                    $idPresupuestoSalida = $row['id'];
                    $nombre = $row['nombre'];
                    
              ?>
            <h1>Ver presupuesto para <b><?php echo $nombre; ?></b> </h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Ver</li>
            </ol>
          </div>
        </div>
        <div>
        <div class="row">
            <?php
                if($visibleI == FALSE){
            ?>
           
            
            
            
            <div class="col-sm">
                <div class="col-sm">
            <button type="button" class="btn btn-block btn-success btn-sm"><a href="presupuesto"><font color="white"><i class="fas fa-list"></i> Regresar</font></a></button>
            </div>
            </div>
            <div class="col-sm">
            </div>
            <div class="col-sm">
            </div>
            <div class="col-sm">
            </div>
            </div>
            <?php }else{?>
            

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
                  <?php
                  //////// se valida con el id del presupuesto para traer el valor del presupuesto
                    //require 'conexion/bd.php';
                    $queryPresupuesto = $mysqli->query("SELECT * FROM presupuesto WHERE id='$idPresupuesto'");
                    $datosPrespuesto = $queryPresupuesto->fetch_array(MYSQLI_ASSOC);
                    $TotalPresupuestoGeneral=$datosPrespuesto['totalPresupuesto'];
                    $responsable = $datosPrespuesto['responsable'];
                    ///// fin del proceso
                  $data = $mysqli->query("SELECT * FROM presupuestoGestionar WHERE idPresupuesto='$idPresupuesto' ORDER BY tipo ASC")or die(mysqli_error());
                     while($row = $data->fetch_assoc()){
                         $disponibl+=$totalPresupuesto=$row['totalPresupuesto'];
                         
                     }
                     $consultaSolicitudCompra=$mysqli->query("SELECT * FROM solicitudCompraFlujo WHERE idUsuario='".$responsable."' AND rol='1' ");
                                $contadorTotal='0';
                                while($extraerCentroCostoSolicituCompra=$consultaSolicitudCompra->fetch_array()){
                                    
                                    /// validamos solo los que están aprobados
                                    $aprobadosTotales=$mysqli->query("SELECT * FROM solicitudComprador WHERE idSolicitud='".$extraerCentroCostoSolicituCompra['idSolicitud']."' AND estado='ejecutado' ");
                                    $validamosEjecutados=$aprobadosTotales->fetch_array(MYSQLI_ASSOC);
                                    if($validamosEjecutados['idSolicitud'] == $extraerCentroCostoSolicituCompra['idSolicitud']){
                                        
                                    }else{
                                        continue;
                                    }
                                    // ENd
                                    
                                    
                                     '<b>*Porcentaje para aplicar :</b> '. $extraerCentroCostoSolicituCompra['porcentaje'].'%';
                                    $variableCentroCostoId=$extraerCentroCostoSolicituCompra['porcentaje'];
                                     '<br>';
                                    $solicitudFinalizada=$mysqli->query("SELECT * FROM solicitudComprador WHERE idSolicitud='".$extraerCentroCostoSolicituCompra['idSolicitud']."' ");
                                    $extraerSolicituFinal=$solicitudFinalizada->fetch_array(MYSQLI_ASSOC);
                                    
                                    if($variableCentroCostoId == '100'){  /// cuanto es el 100 % se trae el totl directamente
                                    
                                      'Total: '.'$ '.$extraerSolicituFinal['total'];
                                     $presupuesto=$extraerSolicituFinal['total'];
                                     
                                    }else{ // cuando no e sel 100 % se debe calcular
                                      '$ '.$presupuesto=$extraerSolicituFinal['total'];
                                      '<br><b>Se debe aplicar este % $'.number_format($presupuesto*($extraerCentroCostoSolicituCompra['porcentaje']/100));
                                     $presupuesto=$presupuesto*($extraerCentroCostoSolicituCompra['porcentaje']/100);
                                    }
                                    
                                    $contadorTotal+=$presupuesto;
                                     '<br><br>';
                                }
                     //$disponible=$TotalPresupuestoGeneral-$disponibl;
                     $calculandoDisponible=ABS($contadorTotal-$TotalPresupuestoGeneral);
                  ?>
                <h3 class="card-title">De los <b>$ <?php echo number_format($TotalPresupuestoGeneral,0,'.',','); ?></b> del presupuesto actual van <b>$ <?php echo  number_format($contadorTotal,0,'.',','); ?></b> asignados,
                <?php if($calculandoDisponible == 0){ echo 'el presupuesto  está completo.'; }else{ ?> de los cuales <b>$ <?php echo  number_format($calculandoDisponible,0,'.',','); ?></b> están sin asignar.<?php } ?></h3>
                 
                
                <div class="card-tools">
                            
                         
                            
                            
              </div>
            </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-head-fixed text-center" id="example">
                  <thead>
                    <tr>
                      <th>N°</th>
                      <th>Fecha de solicitud</th>
                      <!--<th>Tipo de solicitud</th>-->
                      <th>Solicitante</th>
                      <th>Proceso</th>
                      <th>Centro de costo</th>
                       <th>Centro de Trabajo</th>
                      <th>Aprobador</th>
                      <th>Estado </th>
                      <th>Ejecutado </th>
                      <th>Ver m&aacute;s</th>
                    </tr>
                  </thead>
                  <tbody>
                     <?php
                     require 'conexion/bd.php';
                     $acentos = $mysqli->query("SET NAMES 'utf8'");
                        $data = $mysqli->query("SELECT * FROM solicitudCompra WHERE estado='Aprobado' ORDER BY id ASC")or die(mysqli_error());
                        $idCompra = $row['id'];
                     $conteo=1;
                     while($row = $data->fetch_assoc()){
                         
                          'Respon: '.$responsable.'---';
                         
                         ///// validamos quién puede ver las solitudes asignadas
                         $visualizacionSolicitud=$mysqli->query("SELECT * FROM solicitudCompraFlujo WHERE idSolicitud='".$row['id']."' AND idUsuario = '$responsable'  ");//AND estado='ejecutado'
                         $extraerDatos=$visualizacionSolicitud->fetch_array(MYSQLI_ASSOC);
                         $totalEjecutado=$extraerDatos['total'];
                          'ID: '.$extraerDatos['idUsuario'];
                          '<br>';
                         if($extraerDatos['idUsuario'] == $responsable){
                            $idSolicitudOC=$extraerDatos['id']; 
                         }else{
                           continue;  
                         }
                         
                         
                         
                        $id = $row['id'];
                    echo"<tr>";
                    echo"<td>".$id."</td>"; //$conteo++
                    echo "<td>".$row['fechaSolicitud']."</td>";
                  
                        
                    $rowUsuario=$row['idUsuario'];
                        $validacionUsuarioExt = $mysqli->query("SELECT * FROM usuario WHERE cedula='$rowUsuario' ");
                        $columnaValidandoUsuario = $validacionUsuarioExt->fetch_array(MYSQLI_ASSOC);
                        echo "<td>".$columnaValidandoUsuario['nombres']." ".$columnaValidandoUsuario['apellidos']."</td>";
                        $validandoProceso=$columnaValidandoUsuario['proceso'];
                        $validandoLider=$columnaValidandoUsuario['lider'];
                        
                        $validacionProcesoExt = $mysqli->query("SELECT * FROM procesos WHERE id='$validandoProceso' ");
                        $columnaValidandoProceso = $validacionProcesoExt->fetch_array(MYSQLI_ASSOC);
                        echo "<td>".$columnaValidandoProceso['nombre']."</td>";
                        
                        $rowCentroCosto=$row['centroCosto']."</td>";
                    
                        $array = json_decode ($row['centroCosto']);
                        $longitud = count($array);
                        echo "<td>";
                            for($i=0; $i<$longitud; $i++){
                              
                                $validacionCentroCostoExt = $mysqli->query("SELECT * FROM centroCostos WHERE id='$array[$i]' ");
                                $columnaValidandoCentroCosto = $validacionCentroCostoExt->fetch_array(MYSQLI_ASSOC); 
                                
                            	echo "*".$columnaValidandoCentroCosto['nombre']."<br>";
                            }
                        echo "</td>";
                        
                       
                    
                        $rowCentroTrabajo=$row['centroTrabajo']."</td>";
                     
                        $validacionCentroTrabajoExt = $mysqli->query("SELECT * FROM centrodetrabajo WHERE id_centrodetrabajo='$rowCentroTrabajo' ");
                        $columnaValidandoCentroTrabajo = $validacionCentroTrabajoExt->fetch_array(MYSQLI_ASSOC);
                        echo "<td>".$columnaValidandoCentroTrabajo['nombreCentrodeTrabajo']."</td>";    
                    
                    
                        $usuarioIdAprobador=$mysqli->query("SELECT * FROM solicitudCompraFlujo  WHERE idSolicitud='$id' AND rol='2' ");
                        $columnaValidandoAprobador=$usuarioIdAprobador->fetch_array(MYSQLI_ASSOC);
                        'U:'.$idUsuarioFlujo=$columnaValidandoAprobador['idUsuario'];
                        
                        
                        $usuarioAprobador=$mysqli->query("SELECT * FROM usuario WHERE id='$idUsuarioFlujo' ");
                        $extraerUsuarioAProbador=$usuarioAprobador->fetch_array(MYSQLI_ASSOC);
                        
                        if($idUsuarioFlujo != NULL){
                            echo "<td>".$extraerUsuarioAProbador['nombres']." ".$extraerUsuarioAProbador['apellidos']."</td>";   
                        }else{
                            echo "<td>N/A</td>";
                        }
                        
                   $consultaSolicitudCompra=$mysqli->query("SELECT * FROM solicitudCompraFlujo WHERE idUsuario='".$responsable."' AND rol='1' AND idSolicitud='$id' ");
                                $contadorTotal='0';
                                
                                $extraerCentroCostoSolicituCompra=$consultaSolicitudCompra->fetch_array(MYSQLI_ASSOC);
                                
                                    
                                    /// validamos solo los que están aprobados
                                    $aprobadosTotales=$mysqli->query("SELECT * FROM solicitudComprador WHERE idSolicitud='".$extraerCentroCostoSolicituCompra['idSolicitud']."' AND estado='ejecutado' ");
                                    $validamosEjecutados=$aprobadosTotales->fetch_array(MYSQLI_ASSOC);
                                    if($validamosEjecutados['idSolicitud'] == $extraerCentroCostoSolicituCompra['idSolicitud']){
                                        
                                    }else{
                                        continue;
                                    }
                                    // ENd
                                    
                                    
                                     '<b>*Porcentaje para aplicar :</b> '. $extraerCentroCostoSolicituCompra['porcentaje'].'%';
                                    $variableCentroCostoId=$extraerCentroCostoSolicituCompra['porcentaje'];
                                     '<br>';
                                    $solicitudFinalizada=$mysqli->query("SELECT * FROM solicitudComprador WHERE idSolicitud='".$extraerCentroCostoSolicituCompra['idSolicitud']."' ");
                                    $extraerSolicituFinal=$solicitudFinalizada->fetch_array(MYSQLI_ASSOC);
                                    
                                    if($variableCentroCostoId == '100'){  /// cuanto es el 100 % se trae el totl directamente
                                    
                                      'Total: '.'$ '.$extraerSolicituFinal['total'];
                                     $presupuesto=$extraerSolicituFinal['total'];
                                     
                                    }else{ // cuando no e sel 100 % se debe calcular
                                      '$ '.$presupuesto=$extraerSolicituFinal['total'];
                                      '<br><b>Se debe aplicar este % $'.number_format($presupuesto*($extraerCentroCostoSolicituCompra['porcentaje']/100));
                                     $presupuesto=$presupuesto*($extraerCentroCostoSolicituCompra['porcentaje']/100);
                                    }
                                    
                                    $contadorTotal=$presupuesto;
                                     '<br><br>';
                                //}
                                
                                //echo '$'.number_format($contadorTotal);
                    
                    
                    echo "<td>".$row['estado']."</td>"; 
                    echo "<td> $ ".number_format($contadorTotal)."</td>";
                    $validacionEstado= $row['estado'];
                    echo"<form action='solicitudCompradorEjecutadasVer' method='POST'>";
                    echo"<input type='hidden' name='presupuesto' value= '$id' >";
                    echo"<input type='hidden' name='idOrdenCompra' value= '$id' >";
                    echo"<input type='hidden' name='oc' value= '$idSolicitudOC' >";
                    $idPresupuesto=$_POST['idPresupuesto'];
                      echo"<input type='hidden' name='idPresupuesto' value= '$idPresupuesto' >";
                    echo"<td><button type='submit' class='btn btn-block btn-primary btn-sm'><i class='fas fa-eye'></i> Ver más</button></td>";
                    
                    echo"</form>";
                    
                    echo"</tr>";
                    } 
                    ?>
    
                       
                          </div>
                      </div>

                  </tbody>
                </table>  
                  
               <?php /*
                <table class="table table-head-fixed text-center">
                  <thead>
                    <tr>
                      <th>N°</th>
                      <th>Nombre del presupuesto</th>
                      <th>PPTO gastos</th>
                      <th>Gastos ejecutados</th>
                      <th>PPTO costos</th>
                      <th>Costos ejecutados</th>
                      <th>PPTO disponibles</th>
                      <th>Avance</th>
                      <!--<th>Detalle costos</th>-->
                      <!--<th style="display:<?php //echo$visibleE;?>;">Detalle Gastos</th>-->
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                     require 'conexion/bd.php';
                     
                    
                        $data = $mysqli->query("SELECT * FROM presupuestoGestionar WHERE idPresupuesto='$idPresupuesto' ORDER BY tipo ASC")or die(mysqli_error());
                     
                     $conteo=1;
                     $totalGastos=0;
                     $totalCostos=0;
                     while($row = $data->fetch_assoc()){
                        $id = $row['id'];
                   
                  
                     $tipoProcesoCosto=$row['tipoCostoGasto'];
                     $procesoCostoDatos=json_decode($row['CostoGastoGrupo']);
                     $longitudP = count($procesoCostoDatos);
                     
                   if($tipoProcesoCosto == 'gasto'){
                                   
                                    for($i=0; $i<$longitudP; $i++){
                                    $nombreCentro = $mysqli->query("SELECT * FROM presupuestoGruposGastos WHERE id = '$procesoCostoDatos[$i]' AND modulo='grupo' ");
                                    $columnaC = $nombreCentro->fetch_array(MYSQLI_ASSOC);
                                    $columnaC['nombreGC'];
                                    } 
                                $totalGastos+=$row['totalPresupuesto'];
                                $totalPresupuesto=$row['totalPresupuesto'];
                                number_format($totalPresupuesto,0,'.',','); 
                                
                                }else{
                                    //echo"<td>0</td>";
                                    number_format(0,0,'.',',');
                                }
                    
                   
                   
                   
                    
                    
                    
                    
                    if($tipoProcesoCosto == 'costo'){
                                   // echo"<td>";
                                    for($i=0; $i<$longitudP; $i++){
                                        
                                        $nombreProceso = $mysqli->query("SELECT * FROM presupuestoGrupos WHERE id = '$procesoCostoDatos[$i]' AND modulo='grupo' ");
                                        $columnaP = $nombreProceso->fetch_array(MYSQLI_ASSOC);
                                    
                                        $columnaP['nombreGC'];
                                       
                                    } 
                                    $totalCostos+=$row['totalPresupuesto'];
                                 $totalPresupuesto=$row['totalPresupuesto'];
                                 number_format($totalPresupuesto,0,'.',',');
                                }else{
                                 
                                    number_format(0,0,'.',',');
                                }
                    
                        
                    }
                    $totalGastos;
                    $totalCostos;
                    $sumaDisponible=$totalGastos+$totalCostos;
                    ?>
                      <tr>
                          <td>
                              1
                          </td>
                          <td>
                              <?php echo $nombre; ?>
                          </td>
                          <td>
                              <?php echo '$.'.number_format($totalGastos,0,'.',','); ?>
                          </td>
                          <td>
                              $ 0
                          </td>
                          <td>
                              <?php echo '$.'.number_format($totalCostos,0,'.',','); ?>
                          </td>
                          <td>
                              $ 0
                          </td>
                          <td>
                              <?php echo '$.'.number_format($sumaDisponible,0,'.',','); ?>
                          </td>
                          <td>
                              0%
                          </td>
                          <?php
                     require 'conexion/bd.php';
                     
                     
                     
                        $data = $mysqli->query("SELECT * FROM presupuesto WHERE id='$idPresupuesto' ")or die(mysqli_error());
                     
                     $conteo=1;
                     while($row = $data->fetch_assoc()){
                        $id = $row['id'];
                        $tipoResponsable=$row['tipoResponsable'];
                        $personalID =  json_decode($row['responsable']);
                        $longitud = count($personalID);
                             if($tipoResponsable == 'usuario'){
                                    
                                    for($i=0; $i<$longitud; $i++){
                                        
                                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$personalID[$i]'");
                                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                    
                                        $columna['nombres']." ".$columna['apellidos'];echo "<br>";
                                        $cedulaUsuarioV=$columna['cedula'];
                                    }
                                 
                                }else{
                                    
                                    for($i=0; $i<$longitud; $i++){
                                    $nombrecargo = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$personalID[$i]'");
                                    $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                    $columna['nombreCargos']; 
                                    }
                                }
                
                        
                     } ///// cierre del while
                     
                                        ?>
                      </tr>
                  </tbody>
                </table>
                */ ?>
                
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
		var answer = confirm("¿Esta seguro de eliminar?");

		if(answer == true){
			return true;
		}else{
			return false;
		}
	}
</script>
<script>
    $(document).ready(function(){
        $('#rad_si').click(function(){
            document.getElementById('aprovar_regitros').style.display = '';
        });
        $('#rad_no').click(function(){
            document.getElementById('aprovar_regitros').style.display = 'none';
        });
    });
</script>
</body>
</html>
<?php
}
?>