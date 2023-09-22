<?php
session_start();
if(!isset($_SESSION["session_username"])){
   require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
?>
<!DOCTYPE html>
<html>
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
   <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="../plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
</head>
<script>
   	
    function nobackbutton(){
    	
       window.location.hash="no-back-button";
    	
       window.location.hash="Again-No-back-button" //chrome
    	
       window.onhashchange=function(){window.location.hash="no-back-button";}
    	
    }
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
            <h1>Editar Centro de Trabajo  <?php  $id = $_POST['idCentro'];?></h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Centro de Trabajo</li>
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
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="centrodetrabajo"><font color="white"><i class="fas fa-list"></i> Listar Centro de Trabajo</font></a></button>
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
                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                    $query = $mysqli->query("SELECT * FROM centrodetrabajo WHERE id_centrodetrabajo = '$id'");
                    $row = $query->fetch_array(MYSQLI_ASSOC);
                    $px = $row['prefijoCentrodeTrabajo'];
                    
                    $nom = $row['nombreCentrodeTrabajo'];
                    
                    $cargo = $row['cargosAsociados'];
                   
                            /// END
                            
                            $objeto = new stdClass();
                            $objeto->texto = "Asistente Administrativo logístico";
                            $json = json_encode($objeto,JSON_UNESCAPED_UNICODE);
                             $json;
                ?>
                
                <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="controlador/centrodetrabajo/controladorcentrodetrabajo" method="POST">
                <div class="card-body">
                  
                  <div class="form-group">
                    <label for="nombre">Centro de trabajo</label>
                    <input autocomplete="off" type="text" class="form-control" name="nombreCentro" id="nombre" value="<?php echo $nom; ?>" onkeypress="return ( (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 ||  event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                  </div>
                  <div class="form-group">
                    <label for="prefijo">Prefijo</label>
                    <input autocomplete="off" type="text" class="form-control" name="prefijoCentro"id="prefijo" value="<?php echo $px; ?>" onkeypress="return ( (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 ||  event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                  </div>
                  <?php
                  /*
                        require_once'conexion/bd.php';
                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                        $resultado=$mysqli->query("SELECT * FROM cargos WHERE id_cargos = '$cargo'");
                 ?>
                  <div class="form-group">
                        <label>Cargos asociados</label>
                        <select class="form-control" name="asociados" required>
                <?php
                        while ($columna = mysqli_fetch_array( $resultado )) { ?>
                        <option value="<?php echo $columna['id_cargos']; ?>"><?php echo $columna['nombreCargos']; ?> </option>
                        <?php }  ?>
                        <?php
                        //require_once'conexion/bd.php';
                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                        $resultado=$mysqli->query("SELECT * FROM cargos ORDER BY nombreCargos");
                        ?>
                        <?php
                        while ($columna = mysqli_fetch_array( $resultado )) { ?>
                        <option value="<?php echo $columna['id_cargos']; ?>"><?php echo $columna['nombreCargos']; ?> </option>
                        <?php }  ?>
                        </select>
                    </div>
                 <? */ ?>
                  <div class="form-group">
                    <label>Cargos asociados</label>
                    <select class="duallistbox" name="asociados[]"multiple="multiple">
                        <?php
                            $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                            /// extraer los id del JSON que están en la BD  
                            //$pruebas='["Gerente","Asistente Administrativo logístico"]';
                            
                             'datoooo: '.$cargoAsociados=json_decode($row['cargosAsociadoss']);
                            /// END
                            $consultaCargos=$mysqli->query("SELECT * FROM cargos ORDER BY nombreCargos ");
                            while ($columna = $consultaCargos->fetch_array()) { 
                                //// realizamos esta validacion para comprar los ID que vienen del JSON con los ID existentes de la tabla de cargos
                                    /// realizamos otra validacion, si viene por importación me trae los nombres para comprar, en caso contrario solo compara ID
                                    if($row['estilo'] == '1'){ 
                                        if(in_array($columna['nombreCargos'],$cargoAsociados)){
                                                $seleccionarCt = "selected";        
                                            }else{
                                                $seleccionarCt ="";
                                            }
                                    }else{
                                        if(in_array($columna['id_cargos'],$cargoAsociados)){
                                                $seleccionarCt = "selected";        
                                            }else{
                                                $seleccionarCt ="";
                                            }
                                    }
                                        //// END
                                //// END        
                            ?>
                            <option value="<?php echo $columna['id_cargos']; ?>" <?php echo $seleccionarCt; ?>  ><?php echo $columna['nombreCargos']; ?> </option>
                        <?php }  ?>
                    </select>
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
                  <input type="hidden" name="idCentro" value="<?php echo $id ;?>">    
                  <button type="submit" name="EditarCentro" class="btn btn-primary float-right">Actualizar</button>
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
<script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>
<!-- END -->
</body>
</html>
<?php
}
?>