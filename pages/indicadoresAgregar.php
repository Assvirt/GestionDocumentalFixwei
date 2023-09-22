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
  <title>FIXWEI - Agregar Indicador</title>
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
            <h1>Agregar Indicadores</h1> 
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Agregar indicadores</li>
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
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="indicadores"><font color="white"><i class="fas fa-list"></i> Listar indicadores</font></a></button>
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
              <form role="form" action="controlador/indicadores/controller" method="POST" enctype="multipart/form-data">
                  
                 
                <div class="card-body">
                    
                <!-- parametros para la activacion de correo y plataforma -->
                    <div class="row"> 
                        <div class="form-group col-sm-6">
                          <input name="usuarioActividad" value="<?php echo $sesion;?>" type="hidden" readonly>
                          <label><!-- Notificaciones por: --> </label>&nbsp;&nbsp;
                              <?php if($visibleP != 'none'){ ?>
                              
                                <label><!-- Plataforma --></label>
                                    <input style="border:0px;" name="plataforma" value="1" type="hidden" readonly>
                                <?php }else{  }
                          
                              if($visibleP != 'none' && $visibleC != 'none'){
                                  //echo '-';
                              }
                          
                                    if($visibleC != 'none'){ ?>
                                <label><!-- Correo --></label>
                                    <input style="border:0px;" name="correo" value="1" type="hidden" readonly>
                                <?php }else{  } ?>
                        </div>
                    </div>
                <!-- Fin parametros para la activacion de correo y plataforma -->
                    <div class="row">
                        <div class="form-group col-sm-6">
                           
                            <label>Nombre:</label>
                           
                            <input type="text" class="form-control" name="nombre" placeholder="Nombre" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                            <br>
                            <label>Descripción:</label>
                            <textarea type="text" class="form-control" name="descripcion" placeholder="Descripción" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required></textarea>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Tipo de indicador:</label>
                            <?php
                                //require_once'conexion/bd.php';
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $resultadoTipo=$mysqli->query("SELECT * FROM indicadoresTipo ORDER BY tipo");
                            ?>
                            <select type="text" class="form-control" name="tipoIndicador" required>
                                <option value="">Seleccionar tipo...</option>
                                <?php
                                    while ($columnaTipo = mysqli_fetch_array( $resultadoTipo )) { ?>
                                    <option value="<?php echo $columnaTipo['id']; ?>"><?php echo $columnaTipo['tipo']; ?> </option>
                                <?php }  ?>
                            </select>
                            <br>
                            <label>Responsable Indicador: </label><br>
                            <input type="radio" id="rad_cargoRI" name="radiobtn" value="cargo">
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioRI" name="radiobtn" value="usuario">
                            <label for="usuarios">Usuarios</label>
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccionar" style="width: 100%;" name="select_encargadoRI[]" id="select_encargadoRI" required></select>
                            </div>
                        
                        </div>
                    </div>
                    
                  
                    
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Desde:</label>
                            <input type="date" class="form-control"  name="desde" max="9999-12-31" required>
                            <br>
                            <label>Hasta:</label>
                            <input type="date" class="form-control"  name="hasta" max="9999-12-31" required>
                        
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Sentido:</label>
                            <select type="text" class="form-control"  name="sentido"  required>
                                <option value="">Seleccionar sentido...</option>
                                <option value="Positivo">Positivo</option>
                                <option value="Negativo">Negativo</option>
                            </select>
                            <br>
                            <label>Proceso:</label>
                            <?php
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $resultadoProceso=$mysqli->query("SELECT * FROM procesos ORDER BY nombre");
                            ?>
                            <select type="text" class="form-control"  name="proceso"  required>
                                <option value="">Seleccionar proceso...</option>
                                <?php
                                    while ($columnaProceso = mysqli_fetch_array( $resultadoProceso )) {
                                    if($columnaProceso['estado'] == 'Eliminado'){
                                        continue;
                                    }    
                                ?>
                                    <option value="<?php echo $columnaProceso['id']; ?>"><?php echo $columnaProceso['nombre']; ?> </option>
                                <?php }  ?>
                            </select>
                        </div>                        
                    </div>
                    
                   <div class="row">
                       <div class="form-group col-sm-6">
                           
                        <label>Autorizados para Visualizar: </label><br>
                            <input type="radio" id="rad_cargoAut" name="radiobtnAut" value="cargo" required>
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioAut" name="radiobtnAut" value="usuario" required>
                            <label for="usuarios">Usuarios</label>
                            <div class="select2-blue" id="listarCargos" style="display:none;">
                                
                                <label></label>
                                <?php
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $consultaCargos=$mysqli->query("SELECT * FROM cargos");
                                ?>
                                <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar" style="width: 100%;" name="select_encargadoAut[]"  > <!-- required -->
                                    <?php
                                    while($extraerCargos=$consultaCargos->fetch_array()){
                                    ?>
                                    <option value="<?php echo $extraerCargos['id_cargos']; ?>"><?php echo $extraerCargos['nombreCargos']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="select2-blue" id="listarUsuarios" style="display:none;">
                                
                                <label></label>
                                <?php
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $consultaCargos=$mysqli->query("SELECT * FROM usuario");
                                ?>
                                <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar" style="width: 100%;" name="select_encargadoAut[]"  >
                                    <?php
                                    while($extraerCargos=$consultaCargos->fetch_array()){
                                    ?>
                                    <option value="<?php echo $extraerCargos['id']; ?>"><?php echo $extraerCargos['nombres'].' '.$extraerCargos['apellidos']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                      
                       </div>
                        <div class="form-group col-sm-6">
                            <label>Frecuencia de cálculo:</label>
                            <select type="text" class="form-control"  name="frecuencia"  required>
                                <option value="">Seleccionar frecuencia de cálculo...</option>
                                <option value="Mensual">Mensual</option>
                                <option value="Bimensual">Bimensual</option>
                                <option value="Trimestral">Trimestral</option>
                                <option value="Semestral">Semestral</option>
                                <option value="Anual">Anual</option>
                            </select>
                            <br>
                            <label>¿Restringir la alimentación o análisis para fechas futuras?:</label><br>
                            Si
                            <input type="radio" class=""  name="restrincion" value="Si" required>
                            No
                            <input type="radio" class=""  name="restrincion" value="No" required>
                            <br><br>
                            <label>Clasificación:</label><br>
                            Estratégico
                            <input type="radio" class=""  name="clasificacion" value="Estrategico" required>
                            Operativo
                            <input type="radio" class=""  name="clasificacion" value="Operativo" required>
                        </div> 
                   </div>
                  
                  <div class="row">
                      <div class="form-group col-sm-6">
                        
                            <label>Autorizados para editar: </label><br>
                            <input type="radio" id="rad_cargoEd" name="radiobtnEd" value="cargo">
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioEd" name="radiobtnEd" value="usuario">
                            <label for="usuarios">Usuarios</label>
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccionar" style="width: 100%;" name="select_encargadoEd[]" id="select_encargadoEd" required></select>
                            </div>
                        
                      </div>
                      <div class="form-group col-sm-6">
                            <label>Responsable del Cálculo: </label><br>
                            <input type="radio" id="rad_cargoC" name="radiobtnC" value="cargo">
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioC" name="radiobtnC" value="usuario">
                            <label for="usuarios">Usuarios</label>
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccionar" style="width: 100%;" name="select_encargadoC[]" id="select_encargadoC" required></select>
                            </div>
                      </div>
                      
                  </div>
                  
                  <div class="row">
                      <div class="form-group col-sm-6">
                          <!--<label>Seleccione el tipo de variable a usar en el indicador:</label><br>
                                    Serie única
                                    <input type="radio" class=""  name="variables" value="Serie única" required>
                                    Multiserie
                                     -->
                                    <input type="radio" style="visibility:hidden;"  name="variables" value="Multiserie" checked required>
                      </div>
                      <div class="form-group col-sm-6">
                       
                            <br><br>
                             <table>
                                <tr>
                                    <td>
                                        <font color="white">espacio</font>
                                    </td>
                                    <td>
                                        <button type="button" Onclick="window.location='indicadores'" class="btn btn-success float-right" name="Agregar">Regresar</button>    
                                    </td>
                                    <td>
                                        <font color="white">espacio</font>
                                    </td>
                                    <td>
                                        <button type="submit" style="color:white;" class="btn btn-warning float-right" name="Agregar">Siguiente</button>
                                    </td>
                                </tr>
                             </table>
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
    $(document).ready(function(){
        $('#rad_cargoC').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoC").html(data);
            }); 
        });
        $('#rad_usuarioC').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoC").html(data);
            }); 
        });
    });
</script>
<script>
    $(document).ready(function(){
        $('#rad_cargoAut').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoAut").html(data);
            }); 
        });
        $('#rad_usuarioAut').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoAut").html(data);
            }); 
        });
    });
</script>
<script>
    $(document).ready(function(){
        $('#rad_cargoEd').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoEd").html(data);
            }); 
        });
        $('#rad_usuarioEd').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoEd").html(data);
            }); 
        });
    });
</script>
<script>
        $(document).ready(function(){
            $('#rad_cargoAut').click(function(){
                document.getElementById('listarCargos').style.display = '';
                document.getElementById('listarUsuarios').style.display = 'none';
               
            });
            $('#rad_usuarioAut').click(function(){
                document.getElementById('listarCargos').style.display = 'none';
                document.getElementById('listarUsuarios').style.display = '';
               
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