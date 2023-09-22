<?php
session_start();
if(!isset($_SESSION["session_username"])){
    header("login");
    echo '<script language="javascript">confirm("Sesi贸n Finalizada por Inactividad");
    window.location.href="login"</script>';
}else{
require_once 'inactividad.php';
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Centro de trabajo</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
  <!-- evento para el actualizar o eliminar  -->
  <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
<!-- finaliza el evento  --> 
<!-- estilo boton importar -->
  <link rel="stylesheet" href="styleBotonImportacion.css">
<!-- Fin estilo boton importar -->


<!-- link para ejecutar el evento de Multiple -->
    <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="../../plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
<!-- End link para ejecutar el evento de Multiple -->
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../../index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="../../dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="../../dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="../../dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  
  <?php echo require_once'menu.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Centro de trabajo</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Centro de trabajo</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        
        
       <!-- trae la consulta en Java script para la consulta dinamica -->
       
        	<html lang="es">
            	<head>
            		<title></title>
            		
            		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
            		<!-- ESTILOS -->
            		
            	
            		<!-- SCRIPTS JS-->
            		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
            		<script src="centrodetrabajo_peticion.js"></script>
            	</head>
            	<body>
		        
                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <section>
                       
                    <input type="text" class="form-control float-right" name="busqueda" id="busqueda" placeholder="Filtrar...">
                    </section>
                    <!--
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                    -->        
                  </div>
                </div>
                
                
                
                <br>
                <center>
                <table>
                    <tr>
                        <td>
                            <button class="btn btn-info btn-lg" data-toggle="modal" data-target="#modal-default-agregar"><i class="fas fa-save"></i>Agregar</button>
                        </td>
                        
                        <td>
                            <button type="button" Onclick="window.location='../exportacion/centrodetrabajo'" class="btn btn-info btn-lg" style="margin-right: 5px;"><i class="fas fa-download"></i>Exportar</button>
                        </td>
                        <td>
                            <a class="btn btn-info btn-lg" href="../importacion/importar-centrodetrabajo/centrodetrabajo.xlsx" class="hvr-icon-forward col-3" class="ver" onClick="javascript:document["ver-form"].submit();"><i class="fas fa-download"></i>Descargar Archivo</a>
                        </td>
                        <!--
                        <td><br>
                            <form action="../importacion/importar-centrodetrabajo/index" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
                                <button class="btn btn-info btn-lg"  type="submit" id="submit" name="import"
                                        class="btn-submit">Importar Registros</button>
                                <input type="file" name="file" id="file" accept=".xls,.xlsx" required>        
                           </form>
                        </td> -->
                         <td>
                            
          <form action="../importacion/importar-centrodetrabajo/index" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data"><br>
            <button class="btn btn-info btn-lg"   type="submit" id="submit" name="import" class="btn-submit"><i class="fas fa-upload"></i>Importar Registros</button>
            <input id="file" required name="file" id="file" accept=".xls,.xlsx" multiple="" style="display:none;"  size="6000" type="file" accept="application/pdf,image/x-png,image/gif,image/jpeg,image/jpg,image/tiff/xls/xlsx">
          </form>
      
      </td>
      <td>
         <label for="file">
            <div class="boxFile" data-text="Seleccionar archivo" style="width:150%; height:50px; border-radius:5px;">
              Seleccionar archivo
            </div>
          </label>
      </td>
 
<script>
    document.querySelector('#file').addEventListener('change', function(e) {
  var boxFile = document.querySelector('.boxFile');
  boxFile.classList.remove('attached');
  boxFile.innerHTML = boxFile.getAttribute("data-text");
  if(this.value != '') {
    var allowedExtensions = /(\.xls|\.xlsx|\.pdf|\.jpg|\.jpeg|\.png|\.gif\.tiff)$/i;
    if(allowedExtensions.exec(this.value)) {
      boxFile.innerHTML = e.target.files[0].name;
      boxFile.classList.add('attached');
    } else {
      this.value = '';
      alert('El archivo que intentas subir no está permitido.\nLos archivos permitidos son .xls, .xlsx, .pdf, .jpg, .jpeg, .png, .gif y .tiff');
      boxFile.classList.remove('attached');
    }
  }
});
</script>
                    </tr>
                </table>
                </center>           
                            
                
                
                <? 
                if($mensaje){
                    $mensaje=$_POST['mensaje'];
                    echo '<script language="javascript">confirm("'.$mensaje.'"); </script>';
                }else{
                    
                }
                ?>
                
               
           
            	
                    <div><!-- Responsi para que la tabla no se deforme en table o celular -->
                        <br><br>
                        		<section id="tabla_resultado">
                                
                        		<!-- AQUI SE DESPLEGARA NUESTRA TABLA DE CONSULTA -->
                              </section>
                             
                    </div>
       
	            </body>
            </html>
       
  
                                         
            
        <!-- se despliega el modal para agregar los campos de cargos  -->  
            <div class="modal fade" id="modal-default-agregar">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title"> Agregar nuevo centro de trabajo</h4>
                      <form action="../controlador/centrodetrabajo/controladorcentrodetrabajo" method="POST">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p>Prefijo:</p>
                      <input class="form-control" type="text"  name="prefijoCentro" required>
                      <p>Nombre:</p>
                      <input class="form-control" type="text"  name="nombreCentro" required>
                      
                      
                            <div class="card card-default">
                              <div class="card-header">
                                
                              </div>
                              <!-- /.card-header -->
                              <div class="card-body">
                                <div class="row">
                                  <div class="col-12">
                                    <div class="form-group">
                                        <?php
                                            require_once'../conexion/bd.php';
                                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                                            $query = "SELECT * FROM cargos ORDER BY id_cargos";
                    						$resultado=$mysqli->query($query);
                                         ?>
                                      <label>Cargos asociados</label>
                                      <select name="asociados" class="duallistbox" multiple="multiple">
                                       
                                        <?php while ($columna = mysqli_fetch_array( $resultado )) { ?>
                                        <option value="<?php echo $columna['nombreCargos']; ?>"><?php echo $columna['nombreCargos']; ?> </option>
                                        <?php }  ?>
                                      </select>
                                    </div>
                                    <!-- /.form-group -->
                                  </div>
                                  <!-- /.col -->
                                </div>
                                <!-- /.row -->
                              </div>
                              <!-- /.card-body -->
                              <div class="card-footer">
                               
                              </div>
                            </div>
                      
                      
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      <input type="submit" name="AgregarCentro" class="btn btn-primary" value="Guardar">
                      </form>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
      <!-- End se despliega el modal para agregar los campos de cargos  -->
      
      
      
      
      
       
       
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.0.0
    </div>
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- script para traer los datos ah modificar -->



<!-- finaliza el proceso del script -->


<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>


<!-- evento para el actualizar o eliminar  -->
    <!-- SweetAlert2 -->
    <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="../../plugins/toastr/toastr.min.js"></script>
    <!-- AdminLTE App -->

<!-- finaliza el evento  -->



<!-- link para ejecutar el evento de Multiple -->

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 -->
    <script src="../../plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="../../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <!-- InputMask -->
    <script src="../../plugins/moment/moment.min.js"></script>
    <script src="../../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
    <!-- date-range-picker -->
    <script src="../../plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="../../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Bootstrap Switch -->
    <script src="../../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
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



<!-- End link para ejecutar el evento de Multiple -->
</body>
</html>



<?php
}
?>