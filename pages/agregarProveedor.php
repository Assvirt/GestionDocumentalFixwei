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
  <title>FIXWEI - Agregar Proveedor</title>
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
            <h1>Agregar Proveedor</h1> 
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Agregar proveedor</li>
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
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="proveedoresInscripcion"><font color="white"><i class="fas fa-list"></i> Listar proveedores</font></a></button>
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
               
                <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="controlador/proveedor/controllerProveedor" method="POST" enctype="multipart/form-data">
                  <input name="realizador" value="<?php echo $idparaChat;?>" type="hidden">
                <div class="card-body">
                    
                <!-- parametros para la activacion de correo y plataforma -->
                    <div class="row"> 
                        <div class="form-group col-sm-6">
                          <input name="usuarioActividad" value="<?php echo $sesion;?>" type="hidden" readonly>
                              <?php if($visibleP != 'none'){ ?>
                              
                                
                                    <input style="border:0px;" name="plataforma" value="1" type="hidden" readonly>
                                <?php }else{  }
                          
                              if($visibleP != 'none' && $visibleC != 'none'){
                                   '-';
                              }
                          
                                    if($visibleC != 'none'){ ?>
                                    <input style="border:0px;" name="correo" value="1" type="hidden" readonly>
                                <?php }else{  } ?>
                        </div>
                    </div>
                <!-- Fin parametros para la activacion de correo y plataforma -->
                    
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label>Nit:</label>
                            <input type="number" min="0" class="form-control"  name="nit" placeholder="Nit" onkeypress="return soloLetras(event)" onkeydown="noPuntoComa( event )" required  onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218 )">
                        </div>
                        <div class="form-group col-sm-2">
                            <label style="color:white;">.</label>
                            <input type="number" min="0" class="form-control"  name="nitDigito" placeholder="Dígito" required >
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Contacto:</label>
                            <input type="text" class="form-control"  name="contacto" placeholder="Contacto" required onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)">
                        </div>                                
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Raz&oacute;n social:</label>
                            <input type="text" class="form-control" name="razonSocial" placeholder="Raz&oacute;n social" required onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)">
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Correo Electr&oacute;nico:</label>
                            <input type="email" class="form-control" name="email" placeholder="Correo" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Móvil:</label>
                            <input type="text" class="form-control" name="movil" placeholder="Móvil" required onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" >
                        </div>
                    
                        <div class="form-group col-sm-3">
                            <label>Código Ciiu:</label>
                            <input type="number" min="0" class="form-control" name="codigoCiiu" placeholder="Código Ciiu" required onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)">
                        </div>
                        <div class="form-group col-sm-3">
                            <label>Descripción para el Texto:</label>
                            <textarea type="text" class="form-control" name="descripcion" placeholder="Descripci&oacute;n para el texto" required onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)"></textarea>
                        </div>
                        
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Criticidad:</label>
                            <select type="text" class="form-control" name="criticidad" placeholder="Criticidad" required>
                                <option value=""></option>
                                <?php
                                $consultaTipoProveedor=$mysqli->query("SELECT * FROM proveedoresCriticidad ORDER BY tipo");
                                while($extraerConsultaTipoprove=$consultaTipoProveedor->fetch_array()){
                                ?>
                                <option value="<?php echo $extraerConsultaTipoprove['id'];?>"><?php echo $extraerConsultaTipoprove['tipo'];?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>                        
                    
                        <div class="form-group col-sm-6">
                            <label>Grupo:</label>
                            <?php
                                require_once'conexion/bd.php';
                                //$acentos = $mysqli->query("SET NAMES 'utf8'");
                                $resultado=$mysqli->query("SELECT * FROM proveedoresGrupo ORDER BY grupo");
                            ?>
                            <select type="text" class="form-control" name="grupo" placeholder="Grupo" required>
                                <option value=''></option>
                                <?php
                                while ($columna = mysqli_fetch_array( $resultado )) { ?>
                                <option value="<?php echo $columna['id']; ?>"><?php echo $columna['grupo']; ?> </option>
                                <?php }  ?>
                            </select>
                        </div>
                       </div>
                       
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Método de pago :</label>
                            
                            <br>
                            Crédito <input id="habilitarCredito" type="radio" name="terminoPago" value="credito" required>&nbsp;
                            Contado <input id="habilitarContado" type="radio" name="terminoPago" value="contado" required>&nbsp;
                            Contraentrega <input id="habilitarContraEntrefa" type="radio" name="terminoPago" value="contraentrega" required>&nbsp;
                            Otro <input id="habilitarOtro" type="radio" name="terminoPago" value="otro" required>
                         </div>
                         
                         <div class="form-group col-sm-6">
                            <label style="display:none;" id="nd">Número de días</label>
                            <label style="display:none;" id="io">Ingrese otro método de pago</label>
                            <input type="number" style="display:none;" id="mostrar" class="form-control" name="terminoPagoNumeros" placeholder="Días" min="0" >
                            <input type="text" style="display:none;" id="otro" class="form-control" name="otro" placeholder="Ingrese metodo de pago" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)">
                            
                          <script> //// validación para cambiar de proceso
                                $(document).ready(function(){
                                    $('#habilitarCredito').click(function(){ 
                                        document.getElementById('mostrar').style.display = '';
                                        document.getElementById('otro').style.display = 'none';
                                        document.getElementById('nd').style.display = '';
                                        document.getElementById('io').style.display = 'none';
                                    });
                                    $('#habilitarContado').click(function(){  
                                        document.getElementById('mostrar').style.display = 'none';
                                        document.getElementById('otro').style.display = 'none';
                                        document.getElementById('nd').style.display = 'none';
                                        document.getElementById('io').style.display = 'none';
                                    });
                                    $('#habilitarContraEntrefa').click(function(){ 
                                        document.getElementById('mostrar').style.display = 'none';
                                        document.getElementById('otro').style.display = 'none';
                                        document.getElementById('nd').style.display = 'none';
                                        document.getElementById('io').style.display = 'none';
                                    });
                                    $('#habilitarOtro').click(function(){ 
                                        document.getElementById('otro').style.display = '';
                                        document.getElementById('mostrar').style.display = 'none';
                                        document.getElementById('nd').style.display = 'none';
                                        document.getElementById('io').style.display = '';
                                    });
                                  
                                });
                            </script>
                         </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Ciudad:</label>
                            <?php
                                require_once'conexion/bd.php';
                                //$acentos = $mysqli->query("SET NAMES 'utf8'");
                                $resultado=$mysqli->query("SELECT municipios.id,municipios.nombre AS Municipio, departamentos.nombre AS Departamento FROM municipios INNER JOIN departamentos ON municipios.departamento_id = departamentos.id");
                            ?>
                            <select type="text" class="form-control" name="ciudad" placeholder="" required>
                                <option value=''></option>
                                <?php
                                while ($columna = mysqli_fetch_array( $resultado )) { ?>
                                <option value="<?php echo $columna['id']; ?>"><?php echo $columna['id'].' - '. $columna['Departamento'].' - '.$columna['Municipio']; ?> </option>
                                <?php }  ?>
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Direcci&oacute;n:</label>
                            <input type="text" class="form-control" name="direccion" placeholder="Direcci&oacute;n" required onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)">
                        </div>
                        
                    </div>
                    <div class="row">
                        
                        <div class="form-group col-sm-6">
                            <label>Frecuencia actualizaci&oacute;n de documentos (Meses):</label>
                            <input type="number" class="form-control" name="frecuenciaAD" placeholder="Frecuencia actualizaci&oacute;n de documentos" min="0" required>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Tel&eacute;fono:</label>
                            <input type="number" class="form-control" name="telefono" placeholder="Tel&eacute;fono" min="0" required>
                        </div>
                        
                    </div>
                    <div class="row">
                        
                        <div class="form-group col-sm-6">
                            <label>Tiempo para evaluaci&oacute;n (Meses):</label>
                            <input type="number" class="form-control" name="tiempoE" placeholder="Tiempo para evaluaci&oacute;n" min="0" required>
                        </div>
                      
                         <div class="form-group col-sm-6">
                            <label>Persona natural:</label>
                            <input type="radio" name="personaNJ" value="natural" required>
                            &nbsp;
                            <label>Persona jurídica:</label>
                            <input type="radio" name="personaNJ" value="jurídica" required>
                        </div>
                    </div>
                    <div class="row">
                       
                        <div class="form-group col-sm-6">
                            <label>Tipo de proveedor:</label>
                            <select  class="form-control" name="tipoproveedor"  required>
                                <option value=""></option>
                                
                                <?php
                                $consultaTipoProveedor=$mysqli->query("SELECT * FROM proveedoresTipo ORDER BY tipo");
                                while($extraerConsultaTipoprove=$consultaTipoProveedor->fetch_array()){
                                ?>
                                <option value="<?php echo $extraerConsultaTipoprove['id'];?>"><?php echo $extraerConsultaTipoprove['tipo'];?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                       
                    </div>
                  
                   <div class="form-group col-sm-6">
                            <label>Aprobación de proveedor: </label><br>
                            <input type="radio" id="rad_cargoRI" name="radiobtn" value="cargo" required>
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioRI" name="radiobtn" value="usuario" required>
                            <label for="usuarios">Usuarios</label>
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccionar" style="width:100%;" name="select_encargadoRI[]" id="select_encargadoRI" required></select>
                            </div>
                        </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                  
                  <button type="submit" class="btn btn-primary float-right" name="AgregarProveedor">Agregar</button>
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
        $('#rad_cargoRI').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoRI").html(data);
            }); 
        });
        $('#rad_usuarioRI').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoRI").html(data);
            }); 
        });
    });
</script>
<script>
    function soloLetras(e) {
      var key = e.keyCode || e.which,
        tecla = String.fromCharCode(key).toLowerCase(),
        letras = " -0123456789",
        especiales = [9, 37, 39, 46],
        tecla_especial = false;

      for (var i in especiales) {
        if (key == especiales[i]) {
          tecla_especial = true;
          break;
        }
      }

      if (letras.indexOf(tecla) == -1 && !tecla_especial) {
        return false;
      }
      
    }
function noPuntoComa( event ) {
  
    var e = event || window.event;
    var key = e.keyCode || e.which;

    if ( key === 110 || key === 190 || key === 188 ) {     
        
       e.preventDefault();     
    }
}    
</script>
<script type='text/javascript'> // bloqueo del clic derecho
	   // document.oncontextmenu = function(){return false}
    </script>
</body>
</html>
<?php
}
?>