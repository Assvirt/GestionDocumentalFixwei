<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
$ruta = $_POST['rutaSubir'];

?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Cargar Registros</title>
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
  <link rel="stylesheet" href="../plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="../plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!--CKeditor-->
  <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
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
            <h1>Cargar Documento</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Cargar Documento</li>
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
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="repositorio.php"><font color="white"><i class="fas fa-list"></i> Repositorio </font></a></button>
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

              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="controlador/registros/controller" method="POST" enctype="multipart/form-data">
                  <input name="usuarioActividad" value="<?php echo $sesion;?>" type="hidden">
                <div class="card-body">
                    
                    <div class="form-group">
                            <label>¿El registro esta asociado a un documento de gestión de calidad? </label><br>
                            <input type="radio" id="rad_si1" name="radiobtn1" value="si" required>
                            <label for="cargo">Si</label>
                            <input type="radio" id="rad_no1" name="radiobtn1" value="no" required>
                            <label for="usuarios">No</label>
                            
                            <div id="registros_documento" style="display:none;">
                                <div class="form-group">
                                    <label>Proceso:</label>
                                    <select name="proceso" id="cbx_cedi" class="form-control" required>
                                    <option value='0'  selected>Seleccionar Tipo Documento</option>
                                    <?php
                                    $resultado = $mysqli->query("SELECT distinct(proceso) FROM documento WHERE vigente = '1' AND pre IS NULL ");
                                    while($row = $resultado->fetch_assoc()) {
                                    $idpro = $row['proceso']; 
                                     
                				        $resultado2=$mysqli->query("SELECT nombre FROM procesos WHERE id = $idpro ORDER BY nombre DESC");
                				        $col = $resultado2->fetch_array(MYSQLI_ASSOC);
                				        $nombreP = $col['nombre'];
                                      ?>
                                      <option value="<?php echo $idpro; ?>"><?php echo $nombreP; ?></option>
                                      <?php } 
            				            ?>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label>Tipo de documento:</label>
                                    <div><select class="form-control" name="tipoDoc" id="cbx_bodega"></select></div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Documentos:</label>
                                    <div><select class="form-control" name="idDocumento" id="cbx_posicion"></select></div>
                                </div>
                                
                                
                                
                            </div>
                    </div>
                    
                    <div class="form-group">
                            <label>Centro de trabajos:</label>
                                   
                                    <div class="select2-blue">
                                        <select class="select2" multiple="multiple" data-placeholder=" centro trabajo" style="width: 100%;" name="cTrabajo[]" id="cTrabajo" required>
                                            <?php
                                            
                                            $resultadoCT =$mysqli->query("SELECT id_centrodetrabajo, nombreCentrodeTrabajo FROM centrodetrabajo");
                                            while ($columna = mysqli_fetch_array( $resultadoCT )) { ?>
                                            <option value="<?php echo $columna['id_centrodetrabajo']; ?>"><?php echo $columna['nombreCentrodeTrabajo']; ?> </option>
                                            <?php }  ?>    
                                        </select>
                                    </div>
                                </div>
                    
                    <div class="form-group">
                        <label>Nombre:</label>
                        <input autocomplete="off" type="text" class="form-control" value="<?php echo $_POST['nombre'];?>" name="nombre" placeholder="Nombre" required title="No utilice caracteres especiales" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" /><!-- pattern="[a-zA-Z0-9áÁ-úñ ]{1,205}(.*-_,'\)"-->
                    </div>
                   
                                        
                    
                    
                    <div class="form-group">
                        <label>Documento (Máx 10MB):</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="archivo" id="miInput" accept=".xls,.xlsx,.docx,.doc,.pdf, .png, .jpg, .jpeg" required>
                            <label class="custom-file-label" for="exampleInputFile">Seleccionar archivo</label>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label>Autorizados para Visualizar: </label><br>
                            <input type="radio" id="rad_cargoAut" name="radiobtnAut" value="cargo" required>
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioAut" name="radiobtnAut" value="usuario" required>
                            <label for="usuarios">Usuarios</label>
                            <input type="radio" id="rad_grupoAut" name="radiobtnAut" value="grupo" required>
                            <label for="grupos">Grupos</label>
                            
                            <div class="select2-blue" id="listarCargos" style="display:none;" required>
                                
                                <label></label>
                                <!--  <select class="duallistbox" id="select_encargadoAut" name="select_encargadoAut[]" multiple="multiple">
                                   
                                </select>
                                    <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar aprobador" style="width: 100%;" name="select_encargadoAut[]" id="select_encargadoAut" required></select>
                            -->
                                 <?php
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $consultaCargos=$mysqli->query("SELECT * FROM cargos Order by nombreCargos ASC");
                                ?>
                                <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar..." style="width: 100%;" name="select_encargadoAut[]"  >
                                    <?php
                                    while($extraerCargos=$consultaCargos->fetch_array()){
                                    ?>
                                    <option value="<?php echo $extraerCargos['id_cargos']; ?>"><?php echo $extraerCargos['nombreCargos']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="select2-blue" id="listarUsuarios" style="display:none;" required>
                                
                                <label></label>
                                <!--  <select class="duallistbox" id="select_encargadoAut" name="select_encargadoAut[]" multiple="multiple">
                                   
                                </select>
                                    <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar aprobador" style="width: 100%;" name="select_encargadoAut[]" id="select_encargadoAut" required></select>
                            -->
                                 <?php
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $consultaCargos=$mysqli->query("SELECT * FROM usuario Order by nombres ASC");
                                ?>
                                <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar..." style="width: 100%;" name="select_encargadoAut[]"  >
                                    <?php
                                    while($extraerCargos=$consultaCargos->fetch_array()){
                                    ?>
                                    <option value="<?php echo $extraerCargos['id']; ?>"><?php echo $extraerCargos['nombres'].' '.$extraerCargos['apellidos']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="select2-blue" id="listarGrupos" style="display:none;" required>
                                
                                <label></label>
                                <!--  <select class="duallistbox" id="select_encargadoAut" name="select_encargadoAut[]" multiple="multiple">
                                   
                                </select>
                                    <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar aprobador" style="width: 100%;" name="select_encargadoAut[]" id="select_encargadoAut" required></select>
                            -->
                                 <?php
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $consultaGrupo=$mysqli->query("SELECT * FROM grupo Order by nombre ASC");
                                ?>
                                <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar..." style="width: 100%;" name="select_encargadoAut[]"  >
                                    <?php
                                    while($extraerGrupo=$consultaGrupo->fetch_array()){
                                    ?>
                                    <option value="<?php echo $extraerGrupo['id']; ?>"><?php echo $extraerGrupo['nombre']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                      </div>
                    
                    <div class="form-group">
                        <!-- ruta donde se va a cargar -->
                        <input type="hidden" class="form-control" id="" name="rutaSubir" value="<?php echo $_POST['rutaSubir']?>" readonly>
                    </div> 

                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                    <input type="hidden" name="ruta" value="<?php echo $ruta;?>">
                    <input type="hidden" name="usuario" value="<?php echo $idparaChat;?>">
                  <button type="submit" class="btn btn-primary float-right" name="AgregarRegistro">Agregar</button>
                </div>
              </form>
            </div>
            </div>    
<?php
if($_POST['alerta'] != NULL){
?>
                        <script>
                            $(document).ready(function() {
                              // indicamos que se ejecuta la funcion a los 5 segundos de haberse
                              // cargado la pagina
                              setTimeout(clickbutton, 0000);
                            
                              function clickbutton() {
                                // simulamos el click del mouse en el boton del formulario
                                $("#action-button-bloqueado").click();
                                //alert("Aqui llega"); //Debugger
                              }
                              $('#action-button-bloqueado').on('click',function() {
                               // console.log('action');
                              });
                            });
                       </script> 
                       <button id="action-button-bloqueado" style="display:none;" data-toggle="modal" data-target='#modal-danger-alerta-Bloqueo'></button>
                    
                        <div class="modal fade" id="modal-danger-alerta-Bloqueo">
                            <div class="modal-dialog">
                              <div class="modal-content bg-danger">
                                <div class="modal-header">
                                  <h4 class="modal-title">Alerta</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <p>El nombre del archivo contiene caracteres inválidos, por favor digite el nombre completo del archivo e intente cargar.</p>
                                </div>
                                 <!-- END formulario para eliminar por el id -->
                              </div>
                            </div>
                        </div>
<?php
}
?>
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
 <script>
    const MAXIMO_TAMANIO_BYTES = 11000000; // 1MB = 1 millón de bytes
                    
    // Obtener referencia al elemento
    const $miInput = document.querySelector("#miInput");
                    
    $miInput.addEventListener("change", function () {
    	// si no hay archivos, regresamos
    	if (this.files.length <= 0) return;
    
    	// Validamos el primer archivo únicamente
    	const archivo = this.files[0];
    	if (archivo.size > MAXIMO_TAMANIO_BYTES) {
        	const tamanioEnMb = MAXIMO_TAMANIO_BYTES / 1000000;
        	//alert(`El tamaño máximo del archivo es de ${tamanioEnMb} MB`);
        	const Toast = Swal.mixin({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 3000
            });
    
        
            Toast.fire({
                type: 'warning',
                title: ` El tamaño máximo del archivo es de 10 MB`
            })
        	// Limpiar
        	$miInput.value = "";
        } else {
        	// Validación asada. Envía el formulario o haz lo que tengas que hacer
        }
    });
 </script>
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
<!--Ckeditor-->
<script>
    CKEDITOR.replace( 'editor1' );
</script>
<!-- bs-custom-file-input -->
<script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
<!--Ocultar divs documentos-->
<script>
    $(document).ready(function(){
        $('#rad_si1').click(function(){
            document.getElementById('registros_documento').style.display = '';
        });
        $('#rad_no1').click(function(){
            document.getElementById('registros_documento').style.display = 'none';
        });
    });
</script>
<!--Oculta div-->
<script>
    $(document).ready(function(){
        $('#rad_si').click(function(){
            document.getElementById('aprovar_regitros').style.display = '';
        });
        $('#rad_no').click(function(){
            document.getElementById('aprovar_regitros').style.display = 'none';
        });
    });
</script>
<!--Select dinamico-->
<script>
    $(document).ready(function(){
        $('#rad_cargoE').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoR").html(data);
            }); 
        });
        $('#rad_usuarioE').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoR").html(data);
            }); 
        });
    });
</script>
<script>
    $(document).ready(function(){
        $('#rad_cargoEs').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoV").html(data);
            }); 
        });
        $('#rad_usuarioEs').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoV").html(data);
            }); 
        });
        $('#rad_grupoEs').click(function(){
            rad_grupo = "grupo";
            $.post("selectDocumentos2.php", { rad_grupo: rad_grupo }, function(data){
                $("#select_encargadoV").html(data);
            }); 
        });
    });
</script>

<script language="javascript">
			$(document).ready(function(){
				$("#cbx_cedi").change(function () {

					$('#cbx_posicion').find('option').remove().end().append('<option value="whatever"></option>').val('whatever');
					
					$("#cbx_cedi option:selected").each(function () {
						id_cedi = $(this).val();
						$.post("selectDinamico2R.php", { id_cedi: id_cedi }, function(data){
							$("#cbx_bodega").html(data);
						});            
					});
				})
			});
			
			$(document).ready(function(){
				$("#cbx_bodega").change(function () {
					$("#cbx_bodega option:selected").each(function () {
						id_bodega = $(this).val();
						$.post("selectDinamico3R.php", { id_bodega: id_bodega, id_cedi: id_cedi }, function(data){
							$("#cbx_posicion").html(data);
						});           
					});
				})
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
        $('#rad_grupoAut').click(function(){
            rad_grupo = "grupo";
            $.post("selectDocumentos2.php", { rad_grupo: rad_grupo }, function(data){
                $("#select_encargadoAut").html(data);
            }); 
        });
    });
</script>
<script>
        $(document).ready(function(){
            $('#rad_cargoAut').click(function(){
                document.getElementById('listarCargos').style.display = '';
                document.getElementById('listarUsuarios').style.display = 'none';
                document.getElementById('listarGrupos').style.display = 'none';
            });
            $('#rad_usuarioAut').click(function(){
                document.getElementById('listarCargos').style.display = 'none';
                document.getElementById('listarUsuarios').style.display = '';
                document.getElementById('listarGrupos').style.display = 'none';
               
            });
            $('#rad_grupoAut').click(function(){
                document.getElementById('listarCargos').style.display = 'none';
                document.getElementById('listarUsuarios').style.display = 'none';
                document.getElementById('listarGrupos').style.display = '';
               
            });
});
</script>
<!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>
<script type="text/javascript">
  $(function() {
    
    
  });

</script>
</body>
</html>
<?php
}
?>