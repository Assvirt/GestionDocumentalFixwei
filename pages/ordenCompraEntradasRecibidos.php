<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';

//////////////////////PERMISOS////////////////////////
require_once 'conexion/bd.php';

$formulario = 'entradasSalidas'; //Se cambia el nombre del formulario solicitudComprador
require_once 'permisosPlataforma.php';
//////////////////////PERMISOS////////////////////////

?>
<!DOCTYPE html>
<html>
    <title>Entradas y salidas</title>
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
            <h1>Orden de Compra recibidas</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Orden de compra recibidas</li>
            </ol>
          </div>
        </div>
        <div>
           
           
            <div class="row">
                <div class="col-sm">
                    <button type="button" class="btn btn-block btn-info btn-sm"><a href="ordenCompraEntradas"><font color="white"><i class="fas fa-list"></i> Listar</font></a></button>
                </div>
                <div class="col-sm">
                </div>
                <div class="col-sm">
                </div>
                <div class="col-sm">
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
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"></h3>
           
            </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" >
                <table class="table table-head-fixed text-center" id="example">
                  <thead>
                    <tr>
                      <th>N° de ingreso</th>
                      <th>N° orden de compra</th>
                      <th>N° de solicitud</th>
                      <th>Fecha de solicitud</th>
                      <!--<th>Tipo de solicitud</th>-->
                      <th>Solicitante</th>
                      <th>Proceso</th>
                      <th>Centro de costo</th>
                       <th>Centro de Trabajo</th>
                      <th>Aprobador</th>
                      <th>Estado </th>
                      <th>Ver m&aacute;s</th>
                    </tr>
                  </thead>
                  <tbody>
                     <?php
                     require 'conexion/bd.php';
                     //$acentos = $mysqli->query("SET NAMES 'utf8'");
                  
                    
                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                        $data = $mysqli->query("SELECT * FROM solicitudCompra WHERE estado='Aprobado' ORDER BY id ASC")or die(mysqli_error());
                        $idCompra = $row['id'];
                     $conteo=1;
                     while($row = $data->fetch_assoc()){
                         
                         
                         ///// validamos quién puede ver las solitudes asignadas
                         $visualizacionSolicitud=$mysqli->query("SELECT * FROM solicitudComprador WHERE idSolicitud='".$row['id']."' AND estado='ejecutado' ");
                         $extraerDatos=$visualizacionSolicitud->fetch_array(MYSQLI_ASSOC);
                         if($extraerDatos['idUsuario'] == $idparaChat){
                            $idSolicitudOC=$extraerDatos['id']; 
                            $idSolicitudOCFechaActivada=$extraerDatos['fechaActivada'];
                         }else{
                           continue;  
                         }
                         
                         $visualizacionSolicitudRecibidos=$mysqli->query("SELECT * FROM solicitudEntradaSalidasEstado WHERE idSolicitud='".$row['id']."'  ");
                         $extraerDatosRecibidos=$visualizacionSolicitudRecibidos->fetch_array(MYSQLI_ASSOC);
                         if($extraerDatosRecibidos['estado'] == 'recibido'){
                             
                         }else{
                           continue;
                         }
                         
                         
                         
                        $id = $row['id'];
                    echo"<tr>";
                    echo '<td>'.$extraerDatosRecibidos['id'].'</td> '; 
                    echo"<td>";
                            $consucutivo=$mysqli->query("SELECT * FROM consecutivoOC ORDER BY id ");
                                while($extraerConsecutivo=$consucutivo->fetch_array()){
                                    
                                    if($extraerConsecutivo['aplicado'] == '1'){
                                    echo    $idSolicitudOC;
                                    }elseif($extraerConsecutivo['caracter'] == 'Fecha'){
                                    echo $idSolicitudOCFechaActivada;
                                    }else{
                                    echo $extraerConsecutivo['caracter'];
                                    }
                                    echo '-';
                                }
                    
                    
                    echo "</td>";
                    echo"<td>".$id."</td>";
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
                        
                   
                    /// Traemos el estado del ingreso
                    $validandoEstados=$mysqli->query("SELECt * FROM solicitudEntradaSalidasEstado WHERE idSolicitud='$id' ");
                    $extrerValidacionesEstados=$validandoEstados->fetch_array(MYSQLI_ASSOC);
                    $mostrarEstados=$extrerValidacionesEstados['estado'];
                    
                    /*if($mostrarEstados == 'recibido'){
                         echo "<td>Recibido</td>";
                    }else*/
                   
                         echo "<td>Recibido</td>";
                 
                    // end
                    
                   
                   
                    $validacionEstado= $row['estado'];
                    echo"<form action='entradasSalidasRecibido' method='POST'>";
                    echo"<input type='hidden' name='idOrdenCompra' value= '$id' >";
                    echo"<input type='hidden' name='oc' value= '$idSolicitudOC' >";
                    
                    echo"<td><button type='submit' class='btn btn-block btn-primary btn-sm'><i class='fas fa-eye'></i> Ver más</button></td>";
                    echo"</form>";
                    
                    echo"</tr>";
                    } 
                    ?>
    
                       
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

<?php
  $validacionActualizar=$_POST['validacionActualizar'];
  $validacionEliminar=$_POST['validacionEliminar'];
?>

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

<script type="text/javascript">
    function ConfirmDelete(){
      var answer = confirm("¿Esta seguro de eliminar?");

      if(answer == true){
        return true;
      }else{
        return false;
      }
    }
    function ConfirmAnular(){
      var answer = confirm("¿Esta seguro de anular?");

      if(answer == true){
        return true;
      }else{
        return false;
      }
    }
  </script>
<script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>

<!-- archivos para el filtro de busqueda y lista de información -->

    <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
 
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <script type="text/javascript" src="datatables/datatables.min.js"></script>    
     
    <script type="text/javascript" src="main.js"></script>
    
      <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- SweetAlert2 -->
  <script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
  <?php
  /// validaciones de alertas
  $validacionExiste=$_POST['validacionExiste'];
  $validacionExisteA=$_POST['validacionExisteA'];
  $validacionExisteB=$_POST['validacionExisteB'];
  $validacionAgregar=$_POST['validacionAgregar'];
  $validacionAgregarB=$_POST['validacionAgregarB'];
  $validacionActualizar=$_POST['validacionActualizar'];
  $validacionEliminar=$_POST['validacionEliminar'];
  $validacionEliminarB=$_POST['validacionEliminarB'];
  $Tipodocumeto=$_POST['Tipodocumeto'];

  //// Validaciones de la importación
  $validacionExisteImportacionA=$_POST['validacionExisteImportacionA'];
  $validacionExisteImportacionB=$_POST['validacionExisteImportacionB'];
  $validacionExisteImportacionC=$_POST['validacionExisteImportacionC'];
  $validacionExisteImportacionD=$_POST['validacionExisteImportacionD'];
  $validacionExisteImportacionE=$_POST['validacionExisteImportacionE'];
  $validacionExisteImportacionF=$_POST['validacionExisteImportacionF'];
  $validacionExisteImportacionG=$_POST['validacionExisteImportacionG'];
  $validacionExisteImportacionI=$_POST['validacionExisteImportacionI'];
  $validacionExisteImportacionVacio=$_POST['validacionExisteImportacionVacio'];
  //// END
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
      
      if($Tipodocumeto == 1){
        ?>
          Toast.fire({
              type: 'warning',
              title: ' El tipo de documento no es valido.'
          })
        <?php
      }
      
      if($validacionExisteImportacionVacio == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos campos están vacios.'
          })
      <?php
      }
       if($validacionExisteImportacionA == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos cargos no existen en el sistema.'
          })
      <?php
      }
      if($validacionExisteImportacionB == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos lideres no existe en el sistema.'
          })
      <?php
      }
      if($validacionExisteImportacionC == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos procesos no existe en el sistema.'
          })
      <?php
      }
      if($validacionExisteImportacionD == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos centro de costos no existe en el sistema.'
          })
      <?php
      }
      if($validacionExisteImportacionE == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos centro de trabajo no existe en el sistema.'
          })
      <?php
      }
      if($validacionExisteImportacionF == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos grupos no existe en el sistema.'
          })
      <?php
      }
      if($validacionExisteImportacionG == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos usuarios ya existen.'
          })
      <?php
      }
      if($validacionExisteImportacionI == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Está intentando subir un archivo diferente.'
          })
      <?php
      }
      
      
      if($validacionExiste == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' El usuario ya existe.'
          })
      <?php
      }
      if($validacionExisteA == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' La fecha seleccionada no debe superar la del presente año.'
          })
      <?php
      }
      if($validacionExisteB == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' La cédula ya existe con otro usuario, asegúrese que el número de documento permanezca al usuario que se encuentra editando.'
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
      if($validacionAgregarB == 1){
      ?>
          Toast.fire({
              type: 'success',
              title: 'Registro activado.'
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
      if($validacionEliminarB == 1){
      ?>
          Toast.fire({
              type: 'error',
              title: 'Registro Anulado.'
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
<!-- END -->
</body>
</html>
