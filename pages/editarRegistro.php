<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
//require_once 'inactividad.php';
$idRegistro = $_POST['idRegistro'];
?>
<!DOCTYPE html>
<html>
<head><meta charset="gb18030">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Editar Registro</title>
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
  <!-- Select2 -->
  <link rel="stylesheet" href="../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
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
            <h1>Editar Registro</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Editar Registro</li>
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
                            <form action='listaRegistros' method='POST'>
                                <input type='hidden' name='ruta' value='<?php echo $_POST['ruta']?>'>
                                <button type="submit" class="btn btn-block btn-info btn-sm"><font color="white"><i class="fas fa-list"></i> Registros </font></button>
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
                <h3 class="card-title">Editar Registro</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <?php
                $registros = $mysqli->query("SELECT * FROM registros WHERE id = $idRegistro");
                while($col = $registros->fetch_assoc()) {
                        
                        $idRegistro = $col['id'];
                        
                        $idProceso = $col['idProceso'];
                        $idTipoDocumento = $col['idTipoDocumento'];
                        $idDocumento = $col['idDocumento'];
                        
                        $idCentroTrabajo = json_decode($col['idCentroTrabajo']);
                        $nombre = $col['nombre'];
                        $documento = $col['nombreDocumento'];
                        $html = $col['html'];
                        $carpeta = $col['carpeta'];
                        $rutaArchivo = $carpeta.$documento;
                        $href = "href='".$rutaArchivo."'";
                        $estado= $col['estado'];
                        $aprobador = $col['aprobador'];
                        $aprobadorID = json_decode($col['aprobador']);    
                        
                        if($documento == NULL){
                            $disabledDownload = "disabled";
                            $href = "";
                        }
                        
                        if($idDocumento != NULL){
                            $checkDocumentoSi = "checked";
                        }else{
                            $checkDocumentoNo = "checked";
                        }
                        
                        if($aprobador != NULL){
                            $checkSi = "checked";
                        }else{
                            $checkNo = "checked";
                        }
                        
                        if($aprobador == 'cargos'){
                            $checkCargos = "checked";
                        }else{
                            $checkUsuarios = "checked";
                        }
                            if($idProceso != NULL){
                                $queryConsultaProcesos=$mysqli->query("SELECT nombre FROM procesos WHERE id = $idProceso ");
        	                    $rowConsultaP=$queryConsultaProcesos->fetch_array(MYSQLI_ASSOC);
        	                    $proceso = utf8_encode($rowConsultaP['nombre']);
        	                    
        	                    
        	                    $queryTipoDoc=$mysqli->query("SELECT nombre FROM tipoDocumento WHERE id = $idTipoDocumento ");
        	                    $rowConsultaTD=$queryTipoDoc->fetch_array(MYSQLI_ASSOC);
        	                    $tipoDocumento = utf8_encode($rowConsultaTD['nombre']);
        	                    
        	                    $queryDoc=$mysqli->query("SELECT nombres FROM documento WHERE id = $idDocumento ");
        	                    $rowConsultaDoc=$queryDoc->fetch_array(MYSQLI_ASSOC);
        	                    $nombreDocumento = utf8_encode($rowConsultaDoc['nombres']);
                            }
                        
                            
                        
                    
                }
              ?>
              
              
              <form role="form" action="controlador/registros/controller.php" method="POST" enctype="multipart/form-data">
                  <input name="usuarioActividad" value="<?php echo $sesion;?>" type="hidden">
                <div class="card-body">
                    
                    <div class="form-group">
                            <label>¿El registro esta asocioado a un documento? </label><br>
                            <input type="radio" id="rad_si1" name="radiobtn1" value="si" <?php echo $checkDocumentoSi; ?> required>
                            <label for="cargo">Si</label>
                            <input type="radio" id="rad_no1" name="radiobtn1" value="no" <?php echo $checkDocumentoNo; ?> required>
                            <label for="usuarios">No</label>
                            
                            <div id="registros_documento" style="display:none;">
                                <div class="form-group">
                                    
                                    <label>Proceso:</label>
                                    <input class="form-control" value="<?php echo $proceso; ?>" readonly>
                                    <input class="form-control" value="<?php echo $idProceso; ?>" type="hidden" name="idProceso2">
                                    <select name="proceso" id="cbx_cedi" class="form-control">
                                    <option value='' >Seleccionar proceso</option>
                                     <?php
                                     $mysqli->query("SET NAMES 'utf8'");
                                     $resultado = $mysqli->query("SELECT distinct(proceso) AS idproc FROM documento WHERE vigente = 1");
                                    while($row = $resultado->fetch_assoc()) { 
                                        $idproc = $row['idproc'];
                                        $mysqli->query("SET NAMES 'utf8'");
            				        $resultado2=$mysqli->query("SELECT nombre FROM procesos WHERE id = $idproc");
            				        $col = $resultado2->fetch_array(MYSQLI_ASSOC);
            				        $nombreP = $col['nombre'];
                                      ?>
                                      <option value="<?php echo $idproc; ?>"><?php echo $nombreP; ?></option>
                                      <?php } 
            				            ?>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label>Tipo de documento:</label>
                                    <input class="form-control" value="<?php echo $tipoDocumento; ?>" readonly>
                                    <input class="form-control" value="<?php echo $idTipoDocumento; ?>" type="hidden" name="idTipoDoc2">
                                    <div><select class="form-control" name="tipoDoc" id="cbx_bodega"></select></div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Documentos:</label>
                                    <input class="form-control" value="<?php echo $nombreDocumento; ?>" readonly>
                                    <input class="form-control" value="<?php echo $idDocumento; ?>" type="hidden" name="idDocumento2">
                                    <div><select class="form-control" name="idDocumenton" id="cbx_posicion"></select></div>
                                </div>
                                
                                
                                
                            </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Centro de trabajos:</label>
                                   
                        <div class="select2-blue">
                            <select class="select2" multiple="multiple" data-placeholder="Select centro trabajo" style="width: 100%;" name="cTrabajo[]" id="cTrabajo" required>
                                <?php
                                $resultadoCT =$mysqli->query("SELECT id_centrodetrabajo, nombreCentrodeTrabajo FROM centrodetrabajo");
                                
                                while ($columna = mysqli_fetch_array( $resultadoCT )) {
                                    
                                    if(in_array($columna['id_centrodetrabajo'],$idCentroTrabajo)){
                                        $selecCT = "selected";
                                    }else{
                                        $selecCT = "";
                                    }
                                
                                ?>
                                <option value="<?php echo $columna['id_centrodetrabajo']; ?>" <?php echo $selecCT; ?>><?php echo $columna['nombreCentrodeTrabajo']; ?> </option>
                                <?php }  ?>    
                            </select>
                        </div>
                    </div>
                    
                    
                    <div class="form-group">
                        <label>Nombre:</label>
                        <input type="text" class="form-control" id="" name="nombre" value="<?php echo $nombre;?>" placeholder="Nombre" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Documento:</label>
                        <button type='button'  class='btn btn-warning btn-sm' <?php echo $disabledDownload; ?>>
                            <i class='fas fa-download'></i>
                            <a style='color:black' <?php echo $href;?> target="_blank">Descargar Registro</a>
                        </button>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="miInput" name="archivo" accept=".xls,.xlsx,.docx,.doc,.pdf,.png,.jpg">
                            <label class="custom-file-label" for="exampleInputFile">Seleccionar archivo</label>
                        </div>
                    </div>
                  
                    <div class="form-group">
                        <label>HTML:</label>
                        <textarea name="editor1"><?php echo $html;?></textarea>
                    </div>
                    
                    <div class="form-group">
                            <label>¿Aprobación de registros?: </label><br>
                            <input type="radio" id="rad_si" name="radiobtn" value="si" required <?php echo $checkSi;?>>
                            <label for="cargo">Si</label>
                            <input type="radio" id="rad_no" name="radiobtn" value="no" required <?php echo $checkNo;?>>
                            <label for="usuarios">No</label>
                            
                            <div id="aprovar_regitros" style="display:none;">
                                <input type="radio" id="rad_cargoE" name="radiobtnAR" value="cargos" <?php echo $checkCargos;?>>
                                <label for="cargo">Cargo</label>
                                <input type="radio" id="rad_usuarioE" name="radiobtnAR" value="usuarios" <?php echo $checkUsuarios;?>>
                                <label for="usuarios">Usuarios</label>
    
                                
                                <div class="select2-blue">
                                    <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoR[]" id="select_encargadoR"></select>
                                </div>
                            </div>
                    </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                    <input type="hidden" id="idRegistro" name="idRegistro" value="<?php echo $idRegistro;?>">
                    <input type='hidden' name='ruta' value='<?php echo $_POST['ruta']?>'>
                    <input type='hidden' name='estado' value='<?php echo $estado;?>'>
                  <button type="submit" class="btn btn-primary float-right" name="actualizarRegistro">Actualizar Registro</button>
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
 <script>
    const MAXIMO_TAMANIO_BYTES = 2000000; // 1MB = 1 millón de bytes
                    
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
                title: ` El tamaño máximo del archivo es de ${tamanioEnMb} MB`
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
<!--Oculta div-->
<script>
    $(document).ready(function(){
        $('#rad_si').click(function(){
            document.getElementById('aprovar_regitros').style.display = '';
        });
        $('#rad_no').click(function(){
            document.getElementById('aprovar_regitros').style.display = 'none';
        });
        
        $('#rad_si1').click(function(){
            document.getElementById('registros_documento').style.display = '';
        });
        $('#rad_no1').click(function(){
            document.getElementById('registros_documento').style.display = 'none';
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
        
        var radios = document.getElementsByName('radiobtn');
        
        for (var i = 0, length = radios.length; i < length; i++) {
          
          if (radios[i].checked) {
              if(radios[i].value == 'si'){
                 document.getElementById('aprovar_regitros').style.display = ''; 
              }
              
              if(radios[i].value == 'no'){
                 document.getElementById('aprovar_regitros').style.display = 'none'; 
              }
          }
        }
        
        var radios = document.getElementsByName('radiobtnAR');

        
        for (var i = 0, length = radios.length; i < length; i++) {
          if (radios[i].checked) {
            // do whatever you want with the checked radio
            //alert(radios[i].value);
            var rad_post = document.getElementById("idRegistro").value;
            var grupo = radios[i].value;
            var aprobadorRegistros = "aprobadorRegistros";
            
            $.post("selectDinamicoActas.php", { rad_post: rad_post, grupo: grupo, aprobadorRegistros: aprobadorRegistros}, function(data){
                $("#select_encargadoR").html(data);
            }); 
            // only one radio can be logically checked, don't check the rest
            break;
          }
        }
        
        
        
    });
</script>

<!--Select dinamico-->
<script>
    $(document).ready(function(){

        var radios = document.getElementsByName('radiobtn1');
        
        for (var i = 0, length = radios.length; i < length; i++) {
          
          if (radios[i].checked) {
              if(radios[i].value == 'si'){
                 document.getElementById('registros_documento').style.display = ''; 
              }
              
              if(radios[i].value == 'no'){
                 document.getElementById('registros_documento').style.display = 'none'; 
              }
          }
        }
        
    });
    
    $(document).ready(function(){
				$("#cbx_cedi").change(function () {

					$('#cbx_posicion').find('option').remove().end().append('<option value="whatever"></option>').val('whatever');
					
					$("#cbx_cedi option:selected").each(function () {
						id_cedi = $(this).val();
						$.post("selectDinamico2.php", { id_cedi: id_cedi }, function(data){
							$("#cbx_bodega").html(data);
						});            
					});
				})
			});
			
			$(document).ready(function(){
				$("#cbx_bodega").change(function () {
					$("#cbx_bodega option:selected").each(function () {
						id_bodega = $(this).val();
						$.post("selectDinamico3.php", { id_bodega: id_bodega, id_cedi: id_cedi }, function(data){
							$("#cbx_posicion").html(data);
						});           
					});
				})
			});
</script>

<!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>

<script type="text/javascript">
  $(function() {
    
    
  });

</script>
</body>
</html>
<?php
}
?>