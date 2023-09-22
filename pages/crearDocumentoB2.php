<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
require_once 'conexion/bd.php';
    
    $idSolicitud = $_POST['idSolicitud'];
    $nombreDoc = $_POST['nombreDocumento'];
    $norma = $_POST['norma'];
    $proceso = $_POST['proceso'];
    $metodo = $_POST['rad_metodo'];
    $tipoDoc = $_POST['tipoDoc'];
    $ubicacion = $_POST['ubicacion'];
    $elabora = $_POST['select_encargadoE'];
    $revisa = $_POST['select_encargadoR'];
    $aprueba = $_POST['select_encargadoA'];
    $codificacion = $_POST['radCodificacion'];
    $versionDeclarada = $_POST['versionDeclarada'];
    $consecutivoDeclarada = $_POST['consecutivoDeclarado']; 
    
    $radElabora = $_POST['radiobtnE'];
    $radRevisa = $_POST['radiobtnR'];
    $radAprueba = $_POST['radiobtnA'];
    $rol = $_POST['rol'];

?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Crear documento</title>
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
            <h1>Crear Documento</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Crear documento</li>
            </ol>
          </div>
        </div>
        <!--<div class="row">
            <div class="col">
            </div>
            <div class="col-9">
                <div class="row">
                    <div class="col-sm">
                        <button type="button" class="btn btn-block btn-success btn-sm"><a href="crearDocumento"><font color="white"><i class="fas fa-chevron-left"></i> Regresar</font></a></button>
                    </div>
                    <div class="col-sm">
                    </div>
                    <div class="col-sm">
                    </div>
                    <div class="col-sm">
                    </div>
                    <div class="col-sm">
                    </div>
                </div>
            </div>
            <div class="col">
            </div>   
        </div>-->
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
              <?php
                if($metodo != "documento"){
              ?>
              <div class="col">
                <div class="form-group col-sm-12">
                    <button type="" name="siguiente" class="btn btn-primary float-left" onclick="window.open('uploadImg')"> <i class="fas fa-file-upload"></i> Subir imagen</button>    
                </div>
                </div>
              
              <?php } ?>
              <form role="form" action="crearDocumentoB3" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        
                        <?php
                            if($metodo != "documento"){
                        ?>
                        <div class="form-group col-sm-12">
                            <textarea name="editor1" required></textarea>
                        </div>
                        <?php }else{?>
                        
                        <?php
                            //if($metodo == "documento"){
                        ?>
                        <div class="form-group col-sm-6">
                            <label for="exampleInputFile">Importar documento PDF</label>
                            <div class="input-group">
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" id="miInput" name="archivopdf" accept=".pdf" >
                                <label class="custom-file-label" for="exampleInputFile">Seleccionar archivo</label>
                              </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="exampleInputFile">Importar documento editable (.docx, .xlsx, .dwg, .pptx)</label>
                            <div class="input-group">
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" id="miInput2" name="archivootro" accept=".xls,.xlsx,.docx,.doc,.dwg,.pptx,.ppt">
                                <label class="custom-file-label" for="exampleInputFile">Seleccionar archivo</label>
                              </div>
                            </div>
                        </div>
                        <?php }?>
                        
                        
                        
                        <div class="form-group col-sm-6">
                            <?php
                                require_once'conexion/bd.php';
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $resultado=$mysqli->query("SELECT id, nombre FROM documentoExterno");
                            ?>
                            <label>Documentos externos: </label>
                              <select class="duallistbox" name="documentos_externos[]" multiple >
                                <?php
                                    while ($columna = mysqli_fetch_array( $resultado )) { ?>
                                    <option value="<?php echo $columna['id']; ?>"><?php echo $columna['nombre']; ?> </option>
                                <?php }  ?>
                              </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <?php
                                require_once'conexion/bd.php';
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $resultado=$mysqli->query("SELECT id, nombre, nombreN FROM definicion ORDER by nombre, nombreN ASC");
                            ?>
                            <label>Definiciones: </label>
                              <select class="duallistbox" name="definiciones[]" multiple >
                                  
                                  
                                <?php
                                    while ($columna = mysqli_fetch_array( $resultado )) {
                                        $id = $columna['id'];
                                        $nombre = $columna['nombre'];
                                        $nombreN =$columna['nombreN'];
                                        /*
                                        if($nombreN != NULL){
                                            echo "<option value='$id' > $nombreN</option>";
                                        }*/ 
                                        if($nombre != NULL){
                                            echo "<option value='$id' > $nombre</option>";
                                        }
                                                                           
                                    
                                    ?>
                                        
                                <?php }  ?>
                              </select>
                        </div>


                        <div class="form-group col-sm-6">
                            <label>Archivo en gestión: </label>
                            <input type="text" class="form-control" name="archivo_gestion" placeholder="Archivo en gestión" required>
                                <br>
                            <label>Archivo central: </label>
                            <input type="text" class="form-control" name="archivo_central" placeholder="Archivo central" required>
                                <br>
                            <label>Archivo histórico: </label>
                            <input type="text" class="form-control" name="archivo_historico" placeholder="Archivo histórico" required>
                            
                        </div>
                        
                        <div class="form-group col-sm-6">
                            <label>Disposición Documental: </label>
                            <textarea rows="3" class="form-control" name="diposicion_documental" placeholder="Disposición Documental" required></textarea>
                            <label>Responsable de disposición: </label>
                            Activos
                                <input type="radio" id="usuariosActivos" value="activosUsuariosResponsable" name="validandoUsuarios" checked required>
                                &nbsp;&nbsp;
                            Retirados
                                <input type="radio" id="usuariosRetirados" value="retiradosUsuariosResponsable" name="validandoUsuarios" required>
                            <br>
                            
                            <div id="mostrarRetirados" style="display:none;">
                                <input type="hidden" name="radiobtnD" value="cargos">
                                <div class="select2-blue" >
                                    <br>
                                    <input multiple="multiple" class="form-control" style="width: 100%;" name="select_encargadoD" >
                                </div>
                            </div>
                                
                            <div id="mostrarActivos">
                                <input type="radio" id="rad_cargoD" name="radiobtnD" value="cargos">
                                <label for="cargo">Cargo</label>
                                <input type="radio" id="rad_usuarioD" name="radiobtnD" value="usuarios">
                                <label for="usuarios">Usuarios</label>
    
                                
                                <div class="select2-blue" >
                                    <select class="select2" multiple="multiple" data-placeholder="Seleccionar" style="width: 100%;" name="select_encargadoD[]" id="select_encargadoD" ></select>
                                </div>
                            </div>
                            
                                 <script> //// validación para elegir entre usuarios activos o usuarios retirados
                                    $(document).ready(function(){
                                        $('#usuariosRetirados').click(function(){
                                            document.getElementById('mostrarRetirados').style.display = '';
                                            document.getElementById('mostrarActivos').style.display = 'none';
                                        });
                                        $('#usuariosActivos').click(function(){
                                            document.getElementById('mostrarRetirados').style.display = 'none';
                                            document.getElementById('mostrarActivos').style.display = '';
                                        });
                                    });
                                </script>
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
                    <!--Envio variables ocultas-->
                    
                    <input type="hidden" name="rol" value="<?php echo $rol;?>"> 
                    <input type="hidden" name="idSolicitud" value="<?php echo $idSolicitud ;?>" >
                    <input type="hidden" name="nombreDocumento" value="<?php echo $nombreDoc ;?>" >
                    <input type="hidden" name="norma" value='<?php echo serialize($norma);?>' >
                    <input type="hidden" name="proceso" value="<?php echo $proceso ;?>" >
                    <input type="hidden" name="rad_metodo" value="<?php echo $metodo ;?>" >
                    <input type="hidden" name="tipoDoc" value="<?php echo $tipoDoc ;?>" >
                    <input type="hidden" name="ubicacion" value="<?php echo $ubicacion ;?>" >
                    
                    <!-- Si las variables vienen por array me habilita los campos del array en caso contrario los de texto-->
                    <input value="<?php echo $_POST['validandoUsuarios']; ?>" name="almacenamientoArray" type="hidden">
                    <?php
                    if($_POST['validandoUsuarios'] == 'retiradosUsuarios'){
                    ?>
                    <input type="hidden" name="select_encargadoE" value='<?php echo $elabora;//serialize($elabora) ;?>' >
                    <input type="hidden" name="select_encargadoR" value='<?php echo $revisa; //serialize($revisa) ;?>' >
                    <input type="hidden" name="select_encargadoA" value='<?php echo $aprueba; //serialize($aprueba) ;?>' >
                    <?php
                    }
                    if($_POST['validandoUsuarios'] == 'activosUsuarios'){
                    ?>
                    <input type="hidden" name="select_encargadoE" value='<?php echo serialize($elabora) ;?>' >
                    <input type="hidden" name="select_encargadoR" value='<?php echo serialize($revisa) ;?>' >
                    <input type="hidden" name="select_encargadoA" value='<?php echo serialize($aprueba) ;?>' >
                    <?php
                    }
                    ?>
                    
                    <input type="hidden" name="radCodificacion" value="<?php echo $codificacion;?>">
                    <input type="hidden" name="radCodificacion" value="<?php echo $codificacion;?>">
                    <input type="hidden" name="versionDeclarada" value="<?php echo $versionDeclarada;?>">
                    <input type="hidden" name="consecutivoDeclarado" value="<?php echo $consecutivoDeclarada;?>">
                    
                    <input type="hidden" name="radiobtnE" value="<?php echo $radElabora; ?>">
                    <input type="hidden" name="radiobtnR" value="<?php echo $radRevisa; ?>">
                    <input type="hidden" name="radiobtnA" value="<?php echo $radAprueba; ?>">
                    
                    
                  <button type="submit" name="agregarDoc" class="btn btn-success float-right">Siguiente >></button>
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
		//alert(`El tamaño máximo del archivo es de ${tamanioEnMb} MB`);
		// Limpiar
		$miInput.value = "";
	} else {
		// Validación asada. Envía el formulario o haz lo que tengas que hacer
	}
});
const $miInput2 = document.querySelector("#miInput2");

$miInput2.addEventListener("change", function () {
	// si no hay archivos, regresamos
	if (this.files.length <= 0) return;

	// Validamos el primer archivo únicamente
	const archivo = this.files[0];
	if (archivo.size > MAXIMO_TAMANIO_BYTES) {
		const tamanioEnMb = MAXIMO_TAMANIO_BYTES / 1000000;
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
		//alert(`El tamaño máximo del archivo es de ${tamanioEnMb} MB`);
		// Limpiar
		$miInput2.value = "";
	} else {
		// Validación asada. Envía el formulario o haz lo que tengas que hacer
	}
});
</script>
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
<!--Select dinamico-->
<script>
    $(document).ready(function(){
        $('#rad_cargoD').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoD").html(data);
            }); 
        });
        $('#rad_usuarioD').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoD").html(data);
            }); 
        });
    });
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