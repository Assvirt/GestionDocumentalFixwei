<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
require_once 'conexion/bd.php';

$idSolicitud = $_POST['idSolicitud'];

?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Crear documento</title>
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
            <h1>Crear documento</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Crear documento</li>
            </ol>
          </div>
        </div>
        <div class="row">
            <div class="col">
            </div>
            <div class="col-9">
                <div class="row">
                    <div class="col-sm">
                        <button type="button" class="btn btn-block btn-success btn-sm"><a href="creacionDocumental"><font color="white"><i class="fas fa-chevron-left"></i> Regresar</font></a></button>
                    </div>
                    <div class="col-sm">
                    </div>
                    <div class="col-sm">
                    </div>
                    <div class="col-sm">
                    </div>
                    <div class="col-sm">
                    </div>
                </div>
            </div>
            <div class="col">
            </div>   
        </div>
        
        
      </div><!-- /.container-fluid -->
    </section>


    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
            <div class="col"></div>
          <div class="col-9">
            <div class="card">
                <center>
                    <br>
                    <h2>SOLICITUD</h2>
                   
                <?php
                    $solicitud = $_POST['solicitud']; 
                ?>
                <p>
                    <?php echo $solicitud;?>
                </p>
                
                    <br><br>
                </center>
            </div>
            <!-- /.card -->
          </div>
          <div class="col"></div>
        </div>
        <!-- /.row -->
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
                <h3 class="card-title">Crear documento</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

              <form role="form" action="crearDocumento2" method="POST">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Nombre del documento: </label>
                            <input type="text" class="form-control" name="nombreDocumento" placeholder="Nombre del documento" required>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Proceso:</label>
                            <?php
                                require_once'conexion/bd.php';
                                $resultado=$mysqli->query("SELECT * FROM procesos ORDER BY nombre");
                            ?>
                            <select type="text" class="form-control" id="descripcion" name="proceso" placeholder="Proceso" required>
                                <option value=''>Seleccionar proceso</option>
                                <?php
                                while ($columna = mysqli_fetch_array( $resultado )) { ?>
                                <option value="<?php echo $columna['id']; ?>"><?php echo $columna['nombre']; ?> </option>
                                <?php }  ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <?php
                                require_once'conexion/bd.php';
                                $resultado=$mysqli->query("SELECT * FROM normatividad");
                            ?>
                            <label>Norma: </label>
                              <select class="duallistbox" name="norma[]" multiple>
                                <?php
                                    while ($columna = mysqli_fetch_array( $resultado )) { ?>
                                    <option value="<?php echo $columna['id']; ?>"><?php echo $columna['nombre']; ?> </option>
                                <?php }  ?>
                              </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Método de creación: </label><br>
                            <div class="custom-control custom-radio">
                              <input class="custom-control-input" type="radio" id="customRadio1" name="rad_metodo" value="documento">
                              <label for="customRadio1" class="custom-control-label">Documento (PDF, WORD, EXCEL)</label>
                            </div>
                            <div class="custom-control custom-radio">
                              <input class="custom-control-input" type="radio" id="customRadio2" name="rad_metodo" value="html">
                              <label for="customRadio2" class="custom-control-label">Edicion HTML</label>
                            </div>
                            
                            <div>
                                <label>Tipo documeno:</label>
                                <?php
                                    require_once'conexion/bd.php';
                                    //$acentos = $mysqli->query("SET NAMES 'utf8'");
                                    $resultado=$mysqli->query("SELECT * FROM tipoDocumento ORDER BY nombre");
                                ?>
                                <select type="text" class="form-control" id="descripcion" name="tipoDoc" placeholder="" required>
                                    <option value=''>Seleccionar tipo documento</option>
                                    <?php
                                    while ($columna = mysqli_fetch_array( $resultado )) { ?>
                                    <option value="<?php echo $columna['id']; ?>"><?php echo $columna['nombre']; ?> </option>
                                    <?php }  ?>
                                </select>
                            </div>
                            
                            <div>
                                <label>Ubicación: </label>
                                <input type="text" class="form-control" name="ubicacion" placeholder="Ubicación" >
                            </div>
                        </div>

                    </div>
                    
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Quién elabora: </label><br>
                            <input type="radio" id="rad_cargoE" name="radiobtn" value="cargo">
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioE" name="radiobtn" vaue="radio">
                            <label for="usuarios">Usuarios</label>

                            
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoE[]" id="select_encargadoE" required></select>
                            </div>
                        </div>
                        
                        <div class="form-group col-sm-6">
                            <label>Quién revisa: </label><br>
                            <input type="radio" id="rad_cargoR" name="radiobtn" value="cargo">
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioR" name="radiobtn" vaue="radio">
                            <label for="usuarios">Usuarios</label>
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoR[]" id="select_encargadoR" required></select>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Quién aprueba: </label><br>
                            <input type="radio" id="rad_cargoA" name="radiobtn" value="cargo">
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioA" name="radiobtn" vaue="radio">
                            <label for="usuarios">Usuarios</label>

                            
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoA[]" id="select_encargadoA" required></select>
                            </div>
                        </div>

                        
                    </div>

                 

                
                
              
        
                  <!--
                  
                  ACA SE AGREGAN ELEMENTOS NUEVOS
                  
                  SE PUEDE EXTRAER DE: 
                  https://fixwei.com/plataforma/pages/forms/general.html
                  https://fixwei.com/plataforma/pages/forms/advanced.html
                  https://fixwei.com/plataforma/pages/forms/editors.html
                  
                  -->
                  
                  
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                    <input type="text" name="idSolicitud" value="<?php echo $idSolicitud;?>">    
                  <button type="submit" name="crearDocumenohtml" class="btn btn-success float-right">Siguiente >></button>
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
<!--Select dinamico-->
<script>
    $(document).ready(function(){
        $('#rad_cargoE').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoE").html(data);
            }); 
        });
        $('#rad_usuarioE').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoE").html(data);
            }); 
        });
    });
</script>
<script>
    $(document).ready(function(){
        $('#rad_cargoR').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoR").html(data);
            }); 
        });
        $('#rad_usuarioR').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoR").html(data);
            }); 
        });
    });
</script>
<script>
    $(document).ready(function(){
        $('#rad_cargoA').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoA").html(data);
            }); 
        });
        $('#rad_usuarioA').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoA").html(data);
            }); 
        });
    });
</script>

</body>
</html>
<?php
}
?>