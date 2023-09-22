<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
    
$root2=$_SESSION["session_root"];

if($root2 != 1){
   echo '<script language="javascript">window.location.href="accesoDenegado"</script>';
}

require_once 'inactividad.php';
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Editar Cliente</title>
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
            <h1>Parametrizaci&oacute;n cliente</h1> 
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Parametrizaci&oacute;n cliente</li>
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
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="cliente"><font color="white"><i class="fas fa-list"></i> Regresar</font></a></button>
                        </div>
                    </div>
                </div>
                <div class="col">
                    
                </div>
                
           
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

   <?php 
                    
                    $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                    $query = $mysqli->query("SELECT * FROM cliente");
                    $row = $query->fetch_array(MYSQLI_ASSOC);
                    $nombre = $row['nombre'];
                    $nit = $row['nit'];
                    $imagen = $row['img'];
                    $telefono = $row['telefono'];
                    $direccion = $row['direccion'];
                    $administrador = $row['administrador'];
                    $administradorUsuario = $row['usuario'];
                    $email = $row['email'];
                    $clave = $row['clave'];
                   
                   
                ?>
                                   



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
                <p>
                    <h3 class="card-title"><strong><?php echo $nombre;?></strong></h3><br>
                    <img class="img-circle elevation-2" width="100px" height="100px" src="data:image/jpg;base64, <?php echo base64_encode($imagen); ?>" alt="User profile picture">
                    
                </p>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="controlador/usuarios/controladorUsuarios" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Raz&oacute;n social:</label>
                            <input type="text" class="form-control"  name="nombre" placeholder="Raz&oacute;n social" value="<?php echo $nombre;?>" required>
                        </div>
                        
                        <div class="form-group col-sm-6">
                            <label>Nit:</label>
                            <input type="text" class="form-control"  name="nit" placeholder="Nit" value="<?php echo $nit;?>"required>
                        </div>                                
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>T&eacute;lefono:</label>
                            <input type="text" class="form-control" id="descripcion" name="telefono" placeholder="T&eacute;lefono" min='0' value="<?php echo $telefono;?>" required>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Direcci&oacute;n:</label>
                            <input type="text" class="form-control" id="descripcion" name="direccion" placeholder="Direcci&oacute;n" min='0' value="<?php echo $direccion;?>" required>
                        </div>
                        
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Administrador:</label>
                            <input type="text" class="form-control"  name="administrador" placeholder="Administrador" value="<?php echo $administrador;?>" required>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Usuario:</label>
                            <input type="text" class="form-control" id="descripcion" name="adminUsuario" placeholder="Usuario" value="<?php echo $administradorUsuario;?>" required>
                        </div>                        
                    </div>
                    <div class="row">
                        
                            <input type="hidden" readonly class="form-control" id="descripcion" name="clave" placeholder="Clave" value="<?php echo $clave;?>" required>
                       
                        <div class="form-group col-sm-6">
                            <label>Correo eléctronico:</label>
                            <input type="email" min="0" class="form-control" id="descripcion" name="correo" placeholder="Correo eléctronico" value="<?php echo $email;?>" required>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Foto:</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="imagen" accept=".jpg,.jpeg,.png" >
                                <label class="custom-file-label" >Subir Archivo</label>
                            </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Confirmar env&iacute;o:</label>
                            <input type="radio" class="" id="descripcion" name="correoSi"  value="Si" required> Si
                            <input type="radio" class="" id="descripcion" name="correoSi"  value="No" required> No
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                  <button type="submit" class="btn btn-primary float-right" name="EditarClienteAdmin">Actualizar</button>
                </div>
              </form>
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
<!-- para mostrar el archivo seleccionado en el file -->
<script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
<!-- END -->
</body>
</html>
<?php
}
?>