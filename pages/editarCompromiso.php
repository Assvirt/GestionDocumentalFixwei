<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
require 'conexion/bd.php';//conexion
$idActa = $_POST['idActa'];
$idCompromiso = $_POST['idCompromiso'];
$acentos = $mysqli->query("SET NAMES 'utf8'");
$compromisos = $mysqli->query("SELECT * FROM compromisos WHERE id = '$idCompromiso' ORDER BY id ASC");

while($col = $compromisos->fetch_assoc()) {
    $idCompromiso = $col['id'];
    $compromiso = $col['compromiso'];
    $responsableCompromiso = $col['responsableCompromiso'];
    $responsableCompromisoID =  json_decode($col['responsableID']);
    $longitud11 = count($responsableCompromisoID);
    $fechaPrimera =  $col['fechaEntrega'];
    $fechaFormato = date('Y/m/d h:i A', strtotime($fechaPrimera));
                                    
    $entregarA = $col['entregarA'];
    $entregarAID =  json_decode($col['entregarAID']);
    $longitud12 = count($entregarAID);
                                    
}

//Marcar radio buttons 

if($responsableCompromiso == 'cargo'){
    $checkCresponsable = "checked";
}

if($responsableCompromiso == 'usuario'){
    $checkUresponsable = "checked";
}


if($entregarA == 'cargo'){
    $checkCEntrega = "checked";
}

if($entregarA == 'usuario'){
    $checkUEntrega = "checked";
}


//Formato de la hora 
$fecha = date('Y-m-d',strtotime($fechaPrimera));
$hora = date('H',strtotime($fechaPrimera));
$minuto = date('i',strtotime($fechaPrimera));
/*
 //// lo siento no se como mas hace el select de la hora, que logica mas mala :c ademas hay afan pos sacar esto.
                            
                            if($hora == 0){
                                $selectHora0 = "selected";    
                            }
                            
                            if($hora == 1){
                                $selectHora1 = "selected";    
                            }
                            
                            if($hora == 2){
                                $selectHora2 = "selected";    
                            }
                            if($hora == 3){
                                $selectHora3 = "selected";    
                            }
                            if($hora == 4){
                                $selectHora4 = "selected";    
                            }
                            if($hora == 5){
                                $selectHora5 = "selected";    
                            }
                            if($hora == 6){
                                $selectHora6 = "selected";    
                            }
                            if($hora == 7){
                                $selectHora7 = "selected";    
                            }
                            if($hora == 8){
                                $selectHora8 = "selected";    
                            }
                            if($hora == 9){
                                $selectHora9 = "selected";    
                            }
                            if($hora == 10){
                                $selectHora10 = "selected";    
                            }
                            if($hora == 11){
                                $selectHora11 = "selected";    
                            }
                            if($hora == 12){
                                $selectHora12 = "selected";    
                            }
                            if($hora == 13){
                                $selectHora13 = "selected";    
                            }
                            if($hora == 14){
                                $selectHora14 = "selected";    
                            }
                            if($hora == 15){
                                $selectHora15 = "selected";    
                            }
                            if($hora == 16){
                                $selectHora16 = "selected";    
                            }
                            if($hora == 17){
                                $selectHora17 = "selected";    
                            }
                            if($hora == 18){
                                $selectHora18 = "selected";    
                            }
                            if($hora == 19){
                                $selectHora19 = "selected";    
                            }
                            if($hora == 20){
                                $selectHora20 = "selected";    
                            }
                            if($hora == 21){
                                $selectHora21 = "selected";    
                            }
                            if($hora == 22){
                                $selectHora22 = "selected";    
                            }
                            if($hora == 23){
                                $selectHora23 = "selected";    
                            }
                            
          */                  

?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Editar compromiso</title>
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
  <!-- summernote -->
  <link rel="stylesheet" href="../../plugins/summernote/summernote-bs4.css">
  <!--CKeditor-->
  <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
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
            <h1>Editar compromiso</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Editar compromiso</li>
            </ol>
          </div>
        </div>
        <div>
            <div class="row">
                <div class="col">
                    
                </div>
                
                <div class="col">
                    
                </div>
                
           
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
  
    <!-- COMPROMISOS-->
    <section class="content">
        <div class="container-fluid">
                <div class="row">
                    <div class="col"></div>
                  
                  <div class="col-9">
                     <!-- Default box -->
                    <div class="card card-primary">
                      <form role="form" action="controlador/actas/controller" method="POST">
                      <div class="card-header">
                        <h3 class="card-title"></h3>
                      </div>
                      <div class="card-body">
                        <div class="row">
                            
                            <div class="col-md-1">
                            </div>
                            
                            <div class="form-group col-md-10">
                                <label>Compromiso/Tareas</label>
                                <textarea name="compromisos" class="form-control" rows="3" required><?php echo $compromiso;?></textarea>
                                
                                <label>Responsable: </label><br>
                                <input type="radio" id="rad_cargoRes" name="rad_Res" value="cargo" <?php echo $checkCresponsable; ?>>
                                <label for="cargo">Cargo</label>
                                <input type="radio" id="rad_usuarioRes" name="rad_Res" value="usuario" <?php echo $checkUresponsable; ?>>
                                <label for="usuarios">Usuarios</label>
                                <div class="select2-blue">
                                    <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoRes[]" id="select_encargadoRes" required></select>
                                </div>
                                
                                <div class="form-group col-md-10">
                                    <br>
                                    <label for="exampleInputPassword1">Fecha y hora de entrega:</label>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                   <span class="input-group-text"><i class="far fa-clock"></i></span>
                                                </div>
                                                 <input type="date" class="form-control" name="fechainicio" placeholder="" value="<?php echo $fecha;?>" required>
                                            </div>
                                            
                                        </div>
                                        
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                  <span class="input-group-text"><i class="far fa-clock"></i></span>
                                                </div>
                                                <input type="time" name="hora" value="<?php echo $hora.':'.$minuto; ?>" class="form-control float-right" id="reservationtime">
                                            </div>
                                             <!--<select name="hora" class="form-control" required>
                                              <option value="">Hora</option>
                                              <option value="0" <?php/* echo $selectHora0;?> >12:00 am</option>
                                              <option value="1" <?php echo $selectHora1;?> >1:00 am</option>
                                              <option value="2" <?php echo $selectHora2;?> >2:00 am</option>
                                              <option value="3" <?php echo $selectHora3;?> >3:00 am</option>
                                              <option value="4" <?php echo $selectHora4;?> >4:00 am</option>
                                              <option value="5" <?php echo $selectHora5;?> >5:00 am</option>
                                              <option value="6" <?php echo $selectHora6;?> >6:00 am</option>
                                              <option value="7" <?php echo $selectHora7;?> >7:00 am</option>
                                              <option value="8" <?php echo $selectHora8;?> >8:00 am</option>
                                              <option value="9" <?php echo $selectHora9;?> >9:00 am</option>
                                              <option value="10" <?php echo $selectHora10;?> >10:00 am</option>
                                              <option value="11" <?php echo $selectHora11;?> >11:00 am</option>
                                              <option value="12" <?php echo $selectHora12;?> >12:00 pm</option>
                                              <option value="13" <?php echo $selectHora13;?> >1:00 pm</option>
                                              <option value="14" <?php echo $selectHora14;?> >2:00 pm</option>
                                              <option value="15" <?php echo $selectHora15;?> >3:00 pm</option>
                                              <option value="16" <?php echo $selectHora16;?> >4:00 pm</option>
                                              <option value="17" <?php echo $selectHora17;?> >5:00 pm</option>
                                              <option value="18" <?php echo $selectHora18;?> >6:00 pm</option>
                                              <option value="19" <?php echo $selectHora19;?> >7:00 pm</option>
                                              <option value="20" <?php echo $selectHora20;?> >8:00 pm</option>
                                              <option value="21" <?php echo $selectHora21;?> >9:00 pm</option>
                                              <option value="22" <?php echo $selectHora22;?> >10:00 pm</option>
                                              <option value="23" <?php echo $selectHora23;*/?> >11:00 pm</option>
                                            </select>-->
                                        </div>
                                        <!--
                                        <div class="col-md-3">
                                            <select name="minuto" class="form-control" required>
                                                <option>Minuto</option>
                                                <?php/*
                                                    for($i=0;$i <= 60;$i++){
                                                
                                                        if($i == $minuto){
                                                            $selectmin = "selected";
                                                        }else{
                                                            $selectmin = "";
                                                        }
                                                        
                                                        echo "<option value='$i' $selectmin>$i</option>";
                                                    }*/
                                                ?>
                                            </select>
                                        </div>-->
                                    </div>
                                </div>
                                
                                <label>Entregar a: </label><br>
                                <input type="radio" id="rad_cargoEntrega" name="rad_Entrega" value="cargo" <?php echo $checkCEntrega;?>>
                                <label for="cargo">Cargo</label>
                                <input type="radio" id="rad_usuarioEntrega" name="rad_Entrega" value="usuario" <?php echo $checkUEntrega;?>>
                                <label for="usuarios">Usuarios</label>
                                <div class="select2-blue">
                                    <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoEntrega[]" id="select_encargadoEntrega" required></select>
                                </div>
                                        
                            </div>
                            <div class="col-md-1">
                            </div>
                            
                        </div>
                      </div>
                       <!-- /.card-body -->
                      <div class="card-footer">
                          <input type="hidden" name="idCompromiso" id ="idCompromiso" value="<?php echo $idCompromiso; ?>">
                          <input type="hidden" name="idActa" id ="idActa" value="<?php echo $idActa; ?>">
                          <button type="submit" style="margin: 10px;" name="actualizarCompromiso" class="btn btn-primary float-right">Actualizar compromiso</button>
                      </div>
                       <!--/.card-footer-->
                    </div>
                    </form>
                     <!--/.card-->
                  </div>
                  <div class="col"></div>
                </div>
        </div>
    </section>
     <!--COMPROMISOS--> 
    
    
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
<!--RESPONSABLES-->
<script>
    $(document).ready(function(){
        $('#rad_cargoRes').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoRes").html(data);
            }); 
        });
        $('#rad_usuarioRes').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoRes").html(data);
            }); 
        });
        
        var radios = document.getElementsByName('rad_Res');

        
        for (var i = 0, length = radios.length; i < length; i++) {
          if (radios[i].checked) {
            // do whatever you want with the checked radio
            //alert(radios[i].value);
            var rad_post = document.getElementById("idCompromiso").value;
            var grupo = radios[i].value;
            var radEncargadoCom = "radEncargadoCom";

            $.post("selectDocumentos2.php", { rad_post: rad_post, grupo: grupo, radEncargadoCom: radEncargadoCom}, function(data){
                $("#select_encargadoRes").html(data);
            }); 
            // only one radio can be logically checked, don't check the rest
            break;
          }
        }
        
        
    });

</script>
<!--RESPONSABLES-->

<!--ENTREGAR A -->
<script>
    $(document).ready(function(){
        $('#rad_cargoEntrega').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoEntrega").html(data);
            }); 
        });
        $('#rad_usuarioEntrega').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoEntrega").html(data);
            }); 
        });
        
        var radios = document.getElementsByName('rad_Entrega');

        
        for (var i = 0, length = radios.length; i < length; i++) {
          if (radios[i].checked) {
            // do whatever you want with the checked radio
            //alert(radios[i].value);
            var rad_post = document.getElementById("idCompromiso").value;
            var grupo = radios[i].value;
            var radEntregaA = "radEntregaA";

            $.post("selectDocumentos2.php", { rad_post: rad_post, grupo: grupo, radEntregaA: radEntregaA}, function(data){
                $("#select_encargadoEntrega").html(data);
            }); 
            // only one radio can be logically checked, don't check the rest
            break;
          }
        }
        
    });
</script>




<!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<?php
/// validaciones de alertas
$validacionExiste=$_POST['validacionExiste'];
$validacionExisteB=$_POST['validacionExisteB'];
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
            title: ' La fecha del compromiso no puede ser menor a la fecha inical del acta.'
        })
    <?php
    }
    if($validacionExisteB == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' La persona que se le entrega la aprobación del compromiso no puede ser el mismo responsable del compromiso.'
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

</body>
</html>
<?php
}
?>