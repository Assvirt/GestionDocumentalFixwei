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
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Editar Presupuesto</title>
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
             <h1 class="card-title">Editar presupuesto</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Editar presupuesto</li>
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
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="presupuesto"><font color="white"><i class="fas fa-list"></i> Listar presupuesto</font></a></button>
                        </div>
                    </div>
                </div>
                <div class="col">
                    
                </div>
                <?php
                
                $id=$_POST['id'];
                $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                $query = $mysqli->query("SELECT * FROM presupuesto WHERE id = '$id'");
                
                $row = $query->fetch_array(MYSQLI_ASSOC);
                
                $nombre = $row['nombre'];
                $totalPresupuesto = $row['totalPresupuesto'];
                $responsable = $row['responsable'];
                $periodo = $row['periodo'];
                
                
                
                
                
                ?>
           
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
               
                <div class="card card-primary">
              <div class="card-header">
               
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="controlador/presupuesto/controllerPresupuesto" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                <input type="hidden" value = "<?php echo $id ; ?>" name="id">    
                <!-- parametros para la activacion de correo y plataforma -->
                    <div class="row"> 
                        <div class="form-group col-sm-6">
                          <input name="usuarioActividad" value="<?php echo $sesion;?>" type="hidden" readonly>
                          <!--<label>Notificaciones por: </label>&nbsp;&nbsp;
                              <?php //if($visibleP != 'none'){ ?>
                              
                                <label>Plataforma</label>
                                    <input style="border:0px;" name="plataforma" value="1" type="hidden" readonly>
                                <?php //}else{  }
                          
                              if($visibleP != 'none' && $visibleC != 'none'){
                                 // echo '-';
                              }
                          
                                    //if($visibleC != 'none'){ ?>
                                <label>Correo</label>
                                    <input style="border:0px;" name="correo" value="1" type="hidden" readonly>-->
                                <?php //}else{  } ?>
                        </div>
                    </div>
                <!-- Fin parametros para la activacion de correo y plataforma -->
                    
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Nombre del presupuesto:</label>
                                <input type="text" class="form-control"  value= "<?php echo $nombre;  ?>"name="nombre" placeholder="Nombre del presupuesto" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                            </div>
                            <div class="form-group col-sm-6">
                               
                                <label>Responsable del presupuesto:</label><br>
                                
                                <select type="text" class="form-control" id="responsable" name="select_encargadoE" placeholder="responsables" required>
                                   
                                 
                                   <?php
                                   $consultaU=$mysqli->query("SELECT * FROM usuario WHERE id='$responsable' ");
                                   $nombreCU=$consultaU->fetch_array(MYSQLI_ASSOC);
                                   
                                           /// validamos centros de costo
                                      	    $centroCostoValidar=$mysqli->query("SELECT * FROM centroCostos WHERE persona='".$nombreCU['id']."' ");
                                      	    $extraerCentrCosto=$centroCostoValidar->fetch_array(MYSQLI_ASSOC);
                                      	    
                                      	    
                                      	    
                                   ?>
                                   <option class="form-control" value="<?php echo $nombreCU['id']; ?>"><?php echo  $extraerCentrCosto['codigo'].' - '.$extraerCentrCosto['prefijo'].' - '.$extraerCentrCosto['nombre'].'  Responsable ('.$nombreCU['nombres'].' '.$nombreCU['apellidos'].')'; ?> </option>
                                     
                                    <?php
                                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                                    $queryUsuarios = $mysqli->query("SELECT * FROM usuario WHERE not id='$responsable' ORDER BY nombres ")or die(mysqli_error());
                                     while ($row = mysqli_fetch_array($queryUsuarios)) { 
                                         
                                         
                                         /// validamos centros de costo
                                      	    $centroCostoValidar=$mysqli->query("SELECT * FROM centroCostos WHERE persona='".$row['id']."' ");
                                      	    $extraerCentrCosto=$centroCostoValidar->fetch_array(MYSQLI_ASSOC);
                                      	    
                                      	    if( $extraerCentrCosto['persona'] != NULL){
                                      	        
                                      	    }else{
                                      	        continue;
                                      	    }
                                      	    // END
                                         
                                         
                                    ?>
                                     <option class="form-control" value="<?php echo $row['id']; ?>"><?php echo  $extraerCentrCosto['codigo'].' - '.$extraerCentrCosto['prefijo'].' - '.$extraerCentrCosto['nombre'].'  Responsable ('.$row['nombres'].' '.$row['apellidos'].')'; ?> </option>
                                      <?php } ?>
                                </select>
                            </div>
                        
                                                       
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                           
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Valor total del presupuesto ($):</label>
                            <input type="text" class="form-control" min='1' id="number" value="<?php echo $totalPresupuesto; ?>" name="valor" placeholder="Valor total del presupuesto"  required>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Periodo del presupuesto (Año):</label>
                            <input type="text" class="form-control" min='1' name="periodo" value ="<?php echo $periodo; ?>"placeholder="Periodo del presupuesto" required>
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
                  
                  <button type="submit" class="btn btn-primary float-right" name="Editar">Actualizar</button>
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
    function MASK(form, n, mask, format) {
        if(format == "undefined") format = false;
            if(format || NUM(n)) {
                dec = 0, point = 0;
                x = mask.indexOf(".")+1;
            if (x) { 
                dec = mask.length - x; 
                
            }
        
            if (dec) {
              n = NUM(n, dec)+"";
              x = n.indexOf(".")+1;
              if (x){ 
                  point = n.length - x; 
                  
              }else{
                  n += "."; 
              }
            }else{
              n = NUM(n, 0)+"";
            } 
            for (var x = point; x < dec ; x++) {
              n += "0";
            }
            x = n.length, y = mask.length, XMASK = "";
            while ( x || y ) {
              if ( x ) {
                while ( y && "#0.".indexOf(mask.charAt(y-1)) == -1 ) {
                  if ( n.charAt(x-1) != "-")
                    XMASK = mask.charAt(y-1) + XMASK;
                  y--;
                }
                XMASK = n.charAt(x-1) + XMASK, x--;
              } else if ( y && "$0".indexOf(mask.charAt(y-1))+1 ) {
                XMASK = mask.charAt(y-1) + XMASK;
              }
              if ( y ) { 
                  y-- 
                  
              }
            }}
            else{
               XMASK="";
        }
        if(form) { 
            form.value = XMASK;
            if (NUM(n)<0) {
              form.style.color="#FF0000";
            } else {
              form.style.color="#000000";
            }
          }
  return XMASK;
}

// Convierte una cadena alfanumérica a numérica (incluyendo formulas aritméticas)
//
// s   = cadena a ser convertida a numérica
// dec = numero de decimales a redondear
//
// La función devuelve el numero redondeado

function NUM(s, dec) {
  for (var s = s+"", num = "", x = 0 ; x < s.length ; x++) {
    c = s.charAt(x);
    if (".-+/*".indexOf(c)+1 || c != " " && !isNaN(c)) { num+=c; }
  }
  if (isNaN(num)) { num = eval(num); }
  if (num == "")  { num=0; } else { num = parseFloat(num); }
  if (dec != undefined) {
    r=.5; if (num<0) r=-r;
    e=Math.pow(10, (dec>0) ? dec : 0 );
    return parseInt(num*e+r) / e;
  } else {
    return num;
  }
}
</script>
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
<script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>
</body>
</html>
<?php
}
?>