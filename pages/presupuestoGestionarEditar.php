<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';

///////// notificaciones para plataforma y correo
require_once 'conexion/bd.php';
$formulario = 'usuarios'; //Se cambia el nombre del procformulario
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
  <title>FIXWEI - Editar Gesti&oacute;n Presupuesto</title>
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
            <h1>Editar gesti&oacute;n presupuesto</h1> 
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Editar gesti&oacute;n presupuesto</li>
            </ol>
          </div>
        </div>
        <div>
            <div class="row">
                <div class="col">
                    <?php  $idPresupuesto=$_POST['idPresupuesto']; ?>
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
 
 
 /////////////// se traen los datos que se van a editar
    $idPresupuestoGestionar=$_POST['idPresupuestoGestionar'];
    $queryDatos = $mysqli->query("SELECT * FROM presupuestoGestionar WHERE id='$idPresupuestoGestionar' ORDER BY tipo ASC")or die(mysqli_error());
    $imprimirDatos = $queryDatos->fetch_array(MYSQLI_ASSOC);
    $tipo=$imprimirDatos['tipo'];
    $totalPresupuestoD=$imprimirDatos['totalPresupuesto'];
    $ProcecoCosto=$imprimirDatos['tipoProcesoCosto'];
    $procesoCostoJSON=$imprimirDatos['ProcesoCosto'];
    
    $responsable=$imprimirDatos['tipoResponsable'];
    $tipoResponsable=$imprimirDatos['responsable'];
    
    $tipoCostoGasto=$imprimirDatos['tipoCostoGasto'];
    $tipoCostoGastoGrupo=$imprimirDatos['costoGastoGrupo'];
    $tipoCostoGastoSubgrupo=$imprimirDatos['costoGastoSubrupo'];
     
     
    ///////// para habilitar los checkbox de procesos y centro de costo
    if($ProcecoCosto == 'proceso'){
                $checkedProceso= "checked";            
        }
    if($ProcecoCosto == 'centroCosto'){
                $checkedCentroCosto= "checked";            
        }
    
    ///Para habilitar los checkbox de costos y gastos
    if($tipoCostoGasto == 'costo'){
                $checkedResCosto= "checked";            
        }
                        
    if($tipoCostoGasto == 'gasto'){
                $checkedResCostoGasto = "checked"; 
        }
    
            
    ///Para habilitar los checkbox de usuario y cargo
    if($responsable == 'cargo'){
                $checkedCargo= "checked";            
        }
                        
    if($responsable == 'usuario'){
                $checkedUsuario = "checked"; 
        }        
 ////////////// fin del proceso
 
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
                <h3 class="card-title">Editar gesti&oacute;n presupuesto</h3>
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
                            <?php if($tipo == 'crear' ){ ?>
                            <input type="radio"  name="radioTipo" value="crear" checked>
                            <label for="cargo">Crear</label>
                            <?php }else{ ?>
                            <input type="radio"  name="radioTipo" value="crear">
                            <label for="cargo">Crear</label>
                            <?php } ?>
                            
                            <?php if($tipo == 'actualizar'){ ?>
                            <input type="radio"  name="radioTipo" value="actualizar" checked>
                            <label for="usuarios">Actualizar</label>
                            <?php }else{ ?>
                            <input type="radio"  name="radioTipo" value="actualizar">
                            <label for="usuarios">Actualizar</label>
                            <?php } ?>
                        </div>
                    </div>
                     <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Proceso/Centro de costo </label><br>
                            <input type="radio" id="rad_procesoE" name="procesoCC" value="proceso" <?php echo $checkedProceso; ?> >
                            <label for="cargo">Proceso</label>
                            <input type="radio" id="rad_centroE" name="procesoCC" value="centroCosto" <?php echo $checkedCentroCosto; ?> >
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
                            <input type="radio" id="rad_costoE" name="costosGastos" value="costo" <?php echo $checkedResCosto; ?> >
                            <label for="cargo">Costo</label>
                            <input type="radio" id="rad_gastoE" name="costosGastos" value="gasto" <?php echo $checkedResCostoGasto; ?> >
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
                            <input disabled class="form-control"  value="<?php echo $totalPresupuestoD; ?>"  required>
                            <input readonly type="hidden" name="presupuesto" value="<?php echo $totalPresupuestoD; ?>"  required>
                        </div>
                        <?php
                        }else{
                        ?>
                        <div class="form-group col-sm-6">
                            <label>Presupuesto disponible: (<?php echo number_format($disponible,0,'.',','); ?>)</label>
                            <input type="number" min="1" max="" class="form-control"  name="presupuesto" value="<?php echo $totalPresupuestoD; ?>" placeholder="Presupuesto" required>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Responsable del presupuesto: </label><br>
                            <input type="radio" id="rad_cargoE" name="radiobtn" value="cargo" <?php echo $checkedCargo; ?> >
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioE" name="radiobtn" value="usuario" <?php echo $checkedUsuario; ?> >
                            <label for="usuarios">Usuarios</label>
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccionar" style="width: 100%;" name="select_encargadoE[]" id="select_encargadoE" required></select>
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
                  
                  <button type="submit" class="btn btn-primary float-right" name="Editar">Editar</button>
                </div>
                <input value="<?php echo $idPresupuestoGestionar; ?>"  type="hidden" readonly name="idPresupuestoGestionarCosto" id="idPresupuestoGestionarCosto">
              </form>
              <!-- se trae este id para extraer el dato de gastos o costos -->
              <input value="<?php echo $idPresupuestoGestionar; ?>"  type="hidden" readonly name="idPresupuestoGestionarCosto" id="idPresupuestoGestionarCosto">
              <input value="<?php echo $idPresupuestoGestionar; ?>"  type="hidden" readonly name="idPresupuestoGestionarGasto" id="idPresupuestoGestionarGasto">
              <!-- fin del proceso -->
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
<!-- responsable -->
<script>
    $(document).ready(function(){
        $('#rad_cargoE').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentosEditar2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoE").html(data);
            }); 
        });
        $('#rad_usuarioE').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentosEditar2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoE").html(data);
            }); 
        });
        
        var radios = document.getElementsByName('radiobtn');

        
        for (var i = 0, length = radios.length; i < length; i++) {
          if (radios[i].checked) {
            // do whatever you want with the checked radio
            //alert(radios[i].value);
            var rad_post = document.getElementById("idPresupuestoGestionarCosto").value;
            var grupo = radios[i].value;
            var radEncargado = "radEncargado";

            $.post("selectDocumentosEditar2.php", { rad_post: rad_post, grupo: grupo, radEncargado: radEncargado}, function(data){
                $("#select_encargadoE").html(data);
            }); 
            // only one radio can be logically checked, don't check the rest
            break;
          }
        }
        
    });
</script>
<!-- Fin responsable -->

<!-- centro de costo o proceso -->
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
        var radios = document.getElementsByName('procesoCC');

        
        for (var i = 0, length = radios.length; i < length; i++) {
          if (radios[i].checked) {
            // do whatever you want with the checked radio
            //alert(radios[i].value);
            var rad_post = document.getElementById("idPresupuestoGestionarGasto").value;
            var grupo = radios[i].value;
            var radEncargadoP = "radEncargadoP";

            $.post("selectDocumentos4.php", { rad_post: rad_post, grupo: grupo, radEncargadoP: radEncargadoP}, function(data){
                $("#select_centroE").html(data);
            }); 
            // only one radio can be logically checked, don't check the rest
            break;
          }
        }
        
    });
</script>
<!-- Fin centro de costo o proceso -->

<!-- costos-->
<script>
    $(document).ready(function(){ 
        $('#rad_costoE').click(function(){ 
            var idPresupuesto = document.getElementById("idPresupuesto").value;
            rad_costo = "costo";
            $.post("selectDocumentos5.php", { rad_costo: rad_costo, idPresupuesto: idPresupuesto }, function(data){
                $("#select_grupoE").html(data);
            });
            rad_costoS = "gasto";
            $.post("selectDocumentos5.php", { rad_costoS: rad_costoS, idPresupuesto: idPresupuesto }, function(data){
                $("#select_subgrupoE").html(data);
            });
        });
       
        var radios = document.getElementsByName('costosGastos');
        
        for (var i = 0, length = radios.length; i < length; i++) {
          if (radios[i].checked) {
            // do whatever you want with the checked radio
            //alert(radios[i].value);
            var rad_post = document.getElementById("idPresupuesto").value;
            var rad_Gestionar = document.getElementById("idPresupuestoGestionarCosto").value;
            var grupo = radios[i].value;
            var radEncargadoPC = "radEncargadoPC";

            $.post("selectDocumentos5.php", { rad_Gestionar: rad_Gestionar, rad_post:rad_post, grupo: grupo, radEncargadoPC: radEncargadoPC}, function(data){
                $("#select_grupoE").html(data);
            });
            
            var radEncargadoPCS = "radEncargadoPCS";
            $.post("selectDocumentos5.php", { rad_Gestionar: rad_Gestionar, rad_post:rad_post, grupo: grupo, radEncargadoPCS: radEncargadoPCS}, function(data){
                $("#select_subgrupoE").html(data);
            });
            // only one radio can be logically checked, don't check the rest
            break;
          }
          
        }
        
        
        
        
        
        
         
       
        
        
        
        
    
        
    });
</script>
<!-- Fin costos -->


</body>
</html>
<?php
}
?>