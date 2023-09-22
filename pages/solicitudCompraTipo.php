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
<head><meta charset="gb18030">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Agregar Tipo de gasto</title>
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
            <h1>Agregar tipo de gasto</h1> 
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Agregar tipo de gasto</li>
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
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="solicitudCompra"><font color="white"><i class="fas fa-list"></i> Listar solicitud de compra</font></a></button>
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
          
          <?php
          /////////////// se valida que botón entra para el formulario de editar o de agregar-....
          $idNivelCargo=$_POST['idNivelCargo'];
          
          
          if(isset($_POST['botonValidarEditar'])){
          ?>
               
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <?php 
                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                    $query = $mysqli->query("SELECT * FROM solicitudCompraTipo WHERE id = '$idNivelCargo'");
                    $row = $query->fetch_array(MYSQLI_ASSOC);
                    $tipo = $row['tipo'];
                    $tipoFrecuencia = $row['tipoFrecuencia'];
                    $frecuencia = $row['frecuencia'];
                    $idEnviar = $row['id'];
                    
                    if($tipoFrecuencia == 'dias'){
                        $saleFrecuencia1=$frecuencia;
                        $visible='';
                        $checked='checked';
                    }else{
                        $visible='none';
                    }
                    
                    if($tipoFrecuencia == 'mes'){
                        $saleFrecuencia2=$frecuencia;
                        $visible2='';
                        $checked2='checked';
                    }else{
                        $visible2='none';
                    }
                    
                    if($tipoFrecuencia == 'ninguno'){
                        $saleFrecuencia3=$frecuencia;
                        $visible3='';
                        $checked3='checked';
                        
                    }else{
                        $visible3='none';
                    }
                ?>
              <form role="form" action="controlador/solicitudCompra/controllerSolicitudCompraTipo" method="POST">
                  <input value="<?php echo $idEnviar; ?>" type="hidden" readonly name="idTipoSolicitud">
                <div class="card-body">
                      <div class="form-group">
                       <label>Tipo de gasto:</label>
                        <input type="text" class="form-control" id="nombreProceso" value="<?php echo $tipo; ?>" name="tipo" placeholder="Tipo de Gasto" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                        <!--<label>Frecuencia de solicitud:</label>
                        <br>
                        Días <input type="radio" name="btnFrecuencia" id="btnVerDias"  value="dias" <?php //echo $checked; ?> >
                        Mes <input type="radio" name="btnFrecuencia" id="btnVerMes" value="mes" <?php //echo $checked2; ?> >
                        N/A <input type="radio" name="btnFrecuencia" id="btnNA" value="ninguno" <?php //echo $checked3; ?> >
                        <br><br>
                        <div id="verDias" style="display:<?php //echo $visible; ?>;">
                            <input type="number" class="form-control" value="<?php //echo $frecuencia; ?>" name="frecuencia" placeholder="Frecuencia de solicitud"  min="0">
                        </div>
                        <div id="ninguno" style="display:<?php //echo $visible3; ?>;">
                            <input type="number" class="form-control" value="0" disabled readonly placeholder="Ninguna frecuencia de solicitud"  min="0">
                        </div>-->
                  </div>
                
                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                  <button type="submit" class="btn btn-primary float-right" name="editar">Actualizar</button>
                </div>
              </form>
              <div class="card-footer">
                  <button type="button" onclick="window.location='solicitudCompraTipo'" class="btn btn-success float-right">Cerrar</button>
              </div>
            </div>
            <?php
                }else{
            ?>
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="controlador/solicitudCompra/controllerSolicitudCompraTipo" method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label>Tipo de gasto:</label>
                    <input type="text" class="form-control" id="nombreProceso" name="tipo" placeholder="Tipo de gasto" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                    <!--<label>Frecuencia de solicitud:</label>
                    <br>
                    Días <input type="radio" name="btnFrecuencia" id="btnVerDias"  value="dias">
                    Mes <input type="radio" name="btnFrecuencia" id="btnVerMes" value="mes">
                    N/A <input type="radio" name="btnFrecuencia" id="btnNA" value="ninguno">
                    <br><br>
                    <div id="verDias" style="display:none;">
                        <input type="number" class="form-control"  name="frecuencia" placeholder="Frecuencia de solicitud por días"  min="0">
                    </div>
                    <div id="verMes" style="display:none;">
                        <input type="number" class="form-control"  name="frecuencia2" placeholder="Frecuencia de solicitud por mes"  min="0">
                    </div>
                    <div id="ninguno" style="display:none;">
                        <input type="number" class="form-control"  disabled readonly placeholder="Ninguna frecuencia de solicitud"  min="0">
                        <input type="hidden" class="form-control"  name="frecuencia3" value="0" placeholder="Ninguna frecuencia de solicitud"  min="0">
                    </div>-->
                    
                    
                  </div>
                
                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                  
                  <button type="submit" class="btn btn-primary float-right" name="Agregar">Agregar</button>
                </div>
              </form>
            </div>
            
            <?php
                }
                /////////////// Fin se valida que botón entra para el formulario de editar o de agregar-....
            ?>
            
            
            
            </div>    

        <div class="col">
            </div>
            
           
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
      
    </section>  

  <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
            <div class="col">
            </div>
          <div class="col-9">
            <div class="card">    
        <div class="card-body table-responsive p-0" style="height: 800px;">
                <table class="table table-head-fixed text-center">
                  <thead>
                    <tr>
                      <th>Tipo de gasto</th>
                      <!--<th>Frecuencia solicitud</th>-->
                      <th>Editar</th>
                      <th>Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>
                     <?php
                     require 'conexion/bd.php';
                     $acentos = $mysqli->query("SET NAMES 'utf8'");
                     $data = $mysqli->query("SELECT * FROM solicitudCompraTipo order by tipo")or die(mysqli_error());
                     while($row = $data->fetch_assoc()){
                 
                    echo"<tr>";
                    echo" <td>".$row['tipo']."</td>";
                    /*if($row['frecuencia'] == 0){
                        echo" <td><b>No Aplica</b></td>";    
                    }else{
                        //echo" <td>".$row['frecuencia']." ".$row['tipoFrecuencia']."</td>";
                    }*/
                    $id=$row['id'];
                   
                    $rowSolicitud=$row['id'];
                        $validacionTpoSolicitudExt = $mysqli->query("SELECT * FROM solicitudCompra");
                        $columnaValidandoTipoSolicitud = $validacionTpoSolicitudExt->fetch_array(MYSQLI_ASSOC);
                        $validnadoBotón=$columnaValidandoTipoSolicitud['tipoSolicitud'];
                      
                        if($validnadoBotón == $id){
                            echo" <td><button disabled class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";//disabled
                            echo" <td><button disabled class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</button></td>";//disabled
                        }else{
                            echo"<form action='solicitudCompraTipo' method='POST'>";
                            echo"<input type='hidden' name='idNivelCargo' value= '$id' >";
                            echo" <td><button type='submit' name='botonValidarEditar' class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";
                            echo"</form>";
                            /*
                            echo"<form action='controlador/solicitudCompra/controllerSolicitudCompraTipo' method='POST'>";
                            echo"<input type='hidden' name='idTipoSolicitud' value= '$id' >";
                            echo" <td><button onclick='return ConfirmDelete()' type='submit' name='borrar' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</button></td>";
                            echo"</form>";
                            */
                            /// validación de script y funcion de eliminacion
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
                           }
                    
                    
                    
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
                            <form action='controlador/solicitudCompra/controllerSolicitudCompraTipo' method='POST'>
                            <div class="modal-footer justify-content-between">
                              <input type="hidden" id="capturarFormula" name='idTipoSolicitud' readonly>
                              <button type="submit" name='borrar' class="btn btn-outline-light">Si</button>
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
      </div>
      </div>
      <div class="col">
            </div>
      </div>
      </div>
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
            $('#btnVerDias').click(function(){
                document.getElementById('verDias').style.display = '';
                document.getElementById('ninguno').style.display = 'none';
               
            });

            $('#btnVerMes').click(function(){
                document.getElementById('verDias').style.display = '';
                document.getElementById('ninguno').style.display = 'none';
               
            });
            
            $('#btnNA').click(function(){
                document.getElementById('ninguno').style.display = '';
                document.getElementById('verDias').style.display = 'none';
                
            });
        });
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
</script>
 <!-- SweetAlert2 -->
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

  //// Validaciones de la importación
  $validacionExisteImportacionA=$_POST['validacionExisteImportacionA'];
  $validacionExisteImportacionB=$_POST['validacionExisteImportacionB'];
  $validacionExisteImportacionC=$_POST['validacionExisteImportacionC'];
  $validacionExisteImportacionD=$_POST['validacionExisteImportacionD'];
  $validacionExisteImportacionE=$_POST['validacionExisteImportacionE'];
  $validacionExisteImportacionF=$_POST['validacionExisteImportacionF'];
  $validacionExisteImportacionG=$_POST['validacionExisteImportacionG'];
  $validacionExisteImportacionI=$_POST['validacionExisteImportacionI'];
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
              title: ' El tipo de solicitud ya existe.'
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