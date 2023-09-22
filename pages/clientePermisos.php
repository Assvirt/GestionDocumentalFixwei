<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';

$root2=$_SESSION["session_root"];

if($root2 != 1){
   echo '<script language="javascript">window.location.href="accesoDenegado"</script>';
}


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
  <title>FIXWEI - Permiso solicitud IP</title>
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
<body class="hold-transition sidebar-mini" oncopy="return false" onpaste="return false">
<script>
   	
    function nobackbutton(){
    	
       window.location.hash="no-back-button";
    	
       window.location.hash="Again-No-back-button" //chrome
    	
       window.onhashchange=function(){window.location.hash="no-back-button";}
    	
    }
</script>
<div class="wrapper" onload="nobackbutton();">


  <!-- Main Sidebar Container -->
  <?php echo require_once'menu.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Permiso solicitud IP</h1> 
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Permiso solicitud IP</li>
            </ol>
          </div>
        </div>
        <div>
            <div class="row">
                <div class="col-sm">
                    <button Onclick="window.location='cliente'"  class="btn btn-block btn-info btn-sm"><i class='fas fa-list'></i> Regresar</button>
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

               

 <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"></h3>
                
                <?php ?>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 800px;">
                <table class="table table-head-fixed text-center" id="example">
                  <thead>
                    <tr>
                      <th>Usuario</th>
                      <th>Descripci&oacute;n del permiso</th>
                      <th>IP de acceso</th>
                      <th>Autorizar</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    require 'conexion/bd.php';
                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                    $data = $mysqli->query("SELECT * FROM usuario WHERE descripcionPermiso <> 'NULL' ORDER BY nombres ASC")or die(mysqli_error()); 
                    while($row = $data->fetch_assoc()){
                    $id=$row['cedula'];
                    echo"<tr>";
                    echo" <td style='text-align:center;'>".$row['nombres']." ".$row['apellidos']."</td>";
                    echo" <td style='text-align:center;'>".$row['descripcionPermiso']."</td>";
                    echo" <td style='text-align:center;'>".$row['ipSolicitante']."</td>";
                    
                    if($row['estadoPermiso'] == 'Pendiente'){
                        echo"<form action='controlador/usuarios/autorizacion' method='POST'>";
                        echo"<input type='hidden' name='cedulaPeticion' value= '$id' >";
                        echo" <td><button name='solicitarPermiso' type='submit' class='btn btn-block btn-warning btn-sm'><i class='fas fa-edit'></i> Autorizar</button></td>";
                        echo"</form>";
                    }else{
                        echo"<form action='controlador/usuarios/autorizacion' method='POST'>";
                        echo"<input type='hidden' name='cedulaPeticion' value= '$id' >";
                        echo" <td><button name='solicitarPermisoRestablecer' type='submit' class='btn btn-block btn-success btn-sm'><i class='fas fa-undo-alt'></i> Restablecer</button></td>";
                        echo"</form>";
                    }    
                        
                    
                    echo"</tr>";
                    
                    }
                    ?>
                    
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

    <script type="text/javascript">
	function ConfirmDelete(){
		var answer = confirm("Esta seguro de eliminar?");

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
$validacionActualizar=$_POST['validacionActualizar'];
$autorizacion=$_POST['autorizacion'];
$ingreso=$_POST['ingreso'];
$autorizado=$_POST['autorizado'];
$autorizacionRechazo=$_POST['autorizacionRechazo'];
$activado=$_POST['activado'];
$desactivado=$_POST['desactivado'];
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
    if($_POST['notificacionAutorizacion'] == 1){
    ?>
     Toast.fire({
            type: 'success',
            title: 'Solicitud autorizada.'
        })
    <?php    
    }
    if($_POST['notificacionAutorizacionB'] == 1){
    ?>
     Toast.fire({
            type: 'success',
            title: 'Solicitud restablecida.'
        })
    <?php    
    }
    if($desactivado == 1){
    ?>
     Toast.fire({
            type: 'success',
            title: 'Inicio de sesión por IP restringida Desactivado.'
        })
    <?php    
    }
    
    
    
    if($autorizacionRechazo == 1){
    ?>
        Toast.fire({
            type: 'error',
            title: 'El código ingresado no es el correcto.'
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
    if($autorizacion == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: 'Los datos ingresados no corresponden a los datos del administrador del sistema.'
        })
    <?php
    }
    if($ingreso == 1){
    ?>
        Toast.fire({
            type: 'success',
            title: 'Procesa a ingresar el código de seguridad.'
        })
    <?php
    }
    if($autorizado == 1){
    ?>
        Toast.fire({
            type: 'success',
            title: 'La información del sistema fue eliminada con éxito.'
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