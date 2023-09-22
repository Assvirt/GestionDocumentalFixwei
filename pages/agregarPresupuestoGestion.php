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
  <title>FIXWEI - Agregar Prosupuesto</title>
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
            <h1>Agregar gesti&oacute;n presupuesto</h1> 
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Agregar gesti&oacute;n presupuesto</li>
            </ol>
          </div>
        </div>
        <div>
            <div class="row">
                <div class="col">
                    <?php $idPresupuesto=$_POST['idPresupuesto']; ?>
                </div>
                <div class="col-9">
                    <div class="row">
                        <div class="col-sm-3">
                            <form action="presupuestoGestionar" method="POST">
                                <input value="<?php echo $idPresupuesto; ?>" name="idPresupuesto" type="hidden" readonly >
                            <button type="submit" class="btn btn-block btn-info btn-sm"><a href="#"><font color="white"><i class="fas fa-list"></i> Listar gesti&oacute;n de presupuesto</font></a></button>
                            </form>
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
//////// se valida con el id del presupuesto para traer el valor del presupuesto
//require 'conexion/bd.php';
$queryPresupuesto = $mysqli->query("SELECT * FROM presupuesto WHERE id='$idPresupuesto'");
$datosPrespuesto = $queryPresupuesto->fetch_array(MYSQLI_ASSOC);
$TotalPresupuestoGeneral=$datosPrespuesto['totalPresupuesto'];
///// fin del proceso
$data = $mysqli->query("SELECT * FROM presupuestoGestionar WHERE idPresupuesto='$idPresupuesto' ORDER BY tipo ASC")or die(mysqli_error());
 while($row = $data->fetch_assoc()){
     $disponibl+=$totalPresupuesto=$row['totalPresupuesto'];
 }
 $disponible=$TotalPresupuestoGeneral-$disponibl;
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
                <h3 class="card-title">Agregar gesti&oacute;n presupuesto</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="controlador/presupuesto/controllerPresupuestoGestionar" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    
                <!-- parametros para la activacion de correo y plataforma -->
                    <div class="row"> 
                        <div class="form-group col-sm-6">
                          <input name="usuarioActividad" value="<?php echo $sesion;?>" type="hidden" readonly>
                          <label>Notificaciones por: </label>&nbsp;&nbsp;
                              <?php if($visibleP != 'none'){ ?>
                              
                                <label>Plataforma</label>
                                    <input style="border:0px;" name="plataforma" value="1" type="hidden" readonly>
                                <?php }else{  }
                          
                              if($visibleP != 'none' && $visibleC != 'none'){
                                  echo '-';
                              }
                          
                                    if($visibleC != 'none'){ ?>
                                <label>Correo</label>
                                    <input style="border:0px;" name="correo" value="1" type="hidden" readonly>
                                <?php }else{  } ?>
                        </div>
                    </div>
                <!-- Fin parametros para la activacion de correo y plataforma -->
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Tipo: </label><br>
                            <input type="radio"  name="radioTipo" value="crear">
                            <label for="cargo">Crear</label>
                            <input type="radio"  name="radioTipo" value="actualizar">
                            <label for="usuarios">Actualizar</label>
                        </div>
                    </div>
                     <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Proceso/Centro de costo </label><br>
                            <input type="radio" id="rad_procesoE" name="procesoCC" value="proceso">
                            <label for="cargo">Proceso</label>
                            <input type="radio" id="rad_centroE" name="procesoCC" value="centroCosto">
                            <label for="usuarios">Centro de costo</label>
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccionar" style="width: 100%;" name="select_centroE[]" id="select_centroE" required></select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label> </label><br>
                            <input value="<?php echo $idPresupuesto; ?>" name="idPresupuesto" id="idPresupuesto" type="hidden"  readonly>
                            <input type="radio" id="rad_costoE" name="costosGastos" value="costo">
                            <label for="cargo">Costo</label>
                            <input type="radio" id="rad_gastoE" name="costosGastos" value="gasto">
                            <label for="usuarios">Gastos</label>
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccionar Grupo" style="width: 100%;" name="select_grupoE[]" id="select_grupoE" required></select>
                            </div>
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccionar Subgrupo" style="width: 100%;" name="select_subgrupoE[]" id="select_subgrupoE" required></select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        if($disponible == 0){
                        ?>
                        <div class="form-group col-sm-6">
                            <label>Presupuesto disponible: (<?php echo number_format($disponible,0,'.',','); ?>)</label>
                            <input type="number" min="1" max="<?php echo $disponible;?>" class="form-control"  disabled placeholder="Presupuesto no disponible" required>
                        </div>
                        <?php }else{ ?>
                        <div class="form-group col-sm-6">
                            <label>Presupuesto disponible: (<?php echo number_format($disponible,0,'.',','); ?>)</label>
                            <input type="number" min="1" max="<?php echo $disponible;?>" class="form-control"  name="presupuesto" placeholder="Presupuesto" required>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Responsable del presupuesto: </label><br>
                            <input type="radio" id="rad_cargoE" name="radiobtn" value="cargo">
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioE" name="radiobtn" value="usuario">
                            <label for="usuarios">Usuarios</label>
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoE[]" id="select_encargadoE" required></select>
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
                  
                  <button type="submit" class="btn btn-primary float-right" name="Agregar">Agregar</button>
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
        $('#rad_procesoE').click(function(){
            rad_proceso = "proceso";
            $.post("selectDocumentos4.php", { rad_proceso: rad_proceso }, function(data){
                $("#select_centroE").html(data);
            }); 
        });
        $('#rad_centroE').click(function(){
            rad_centro = "centro";
            $.post("selectDocumentos4.php", { rad_centro: rad_centro }, function(data){
                $("#select_centroE").html(data);
            }); 
        });
    });
</script>
<script>
    $(document).ready(function(){ 
        $('#rad_costoE').click(function(){ 
            var idPresupuesto = document.getElementById("idPresupuesto").value;
            rad_costo = "costo";
            $.post("selectDocumentos5.php", { rad_costo: rad_costo, idPresupuesto: idPresupuesto }, function(data){
                $("#select_grupoE").html(data);
            });
            rad_costoS = "costo";
            $.post("selectDocumentos5.php", { rad_costoS: rad_costoS, idPresupuesto: idPresupuesto }, function(data){
                $("#select_subgrupoE").html(data);
            });
        });
        $('#rad_gastoE').click(function(){
            var idPresupuesto = document.getElementById("idPresupuesto").value;
            rad_gasto = "gasto";
            $.post("selectDocumentos5.php", { rad_gasto: rad_gasto, idPresupuesto: idPresupuesto }, function(data){
                $("#select_grupoE").html(data);
            });
            rad_gastoS = "gasto";
            $.post("selectDocumentos5.php", { rad_gastoS: rad_gastoS, idPresupuesto: idPresupuesto }, function(data){
                $("#select_subgrupoE").html(data);
            });
        });
    });
</script>
</body>
</html>
<?php
}
?>