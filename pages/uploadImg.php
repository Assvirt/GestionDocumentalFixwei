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
  <title>FIXWEI - Subir imagen</title>
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
            <h1>Subir imagen</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Subir imagen</li>
            </ol>
          </div>
        </div>
        <div>
            <div class="row">
                <div class="col">
                    
                </div>
                <div class="col-9">
                    
                    <div class="row">
                        <!--
                        <div class="col-sm">
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="#"><font color="white"><i class="fas fa-plus-square"></i> Agregar</font></a></button>
                        </div>
                        <div class="col-sm">
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="#"><font color="white"><i class="fas fa-user-plus"></i> Agregar Cargo</font></a></button>
                        </div>
                        <div class="col-sm">
                            <button type="button" class="btn btn-block btn-warning btn-sm"><a href="#"><font color="white"><i class="fas fa-download"></i> Exportar</font></a></button>
                        </div>
                        <div class="col-sm">
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="#"><font color="white"><i class="fas fa-cloud-download-alt"></i> Descargar Plantilla</font></a></button>
                        </div>
            
                        <div class="col-sm">
                            <form>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="exampleInputFile">
                                    <label class="custom-file-label" for="exampleInputFile">Importar archivo</label>
                                    
                                </div>
                            </form>
                        </div>
                        <div class="col-sm">
                            <button type="button" class="btn btn-block btn-info btn-sm"><a class="" href="#"><font color="white"><i class="fas fa-file-upload"></i> Importar</font></a></button>
                        </div>
                    </div>
                    -->
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
              <form role="form" action="controlador/img/controller" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                  
                  <div class="form-group">
                    
                    <label for="exampleInputFile">Subir imagen (Máx 5MB): </label>
                            <div class="input-group">
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" id="exampleInputFile" name="archivo" accept=".jpg,.jpeg,.png,.gif" required>
                                <label class="custom-file-label" for="exampleInputFile">Seleccionar archivo</label>
                              </div>
                            </div>
                            <script>
                                $('input[name="archivo"]').on('change', function(){
                                    var ext = $( this ).val().split('.').pop();
                                    if ($( this ).val() != '') {
                                      if(ext == "jpg" || ext == "jpeg" || ext == "png" || ext == "gif"){
                                        
                                      }
                                      else
                                      {
                                        $( this ).val('');
                                        //alert("Extensión no permitida: " + ext);
                                        const Toast = Swal.mixin({
                                          toast: true,
                                          position: 'top-end',
                                          showConfirmButton: false,
                                          timer: 3000
                                        });
                                    
                                    
                                        Toast.fire({
                                            type: 'warning',
                                            title: ` Extensión no permitida`
                                        })
                                      }
                                    }
                                  });
                                </script>
                  </div>
                  
                  <?php
                  if(isset($_POST['ruta'])){
                      
                  ?>
                  <div class="form-group">
                        <label for="exampleInputFile">Ruta imagen: </label><br>
                        <p id="p1"> <?php echo $_POST['ruta'];?></p>
                        <span onclick="copiarAlPortapapeles('p1')" class="btn btn-primary"  >Copiar URL</span>
                  </div> 
                  <?php
                  }
                  ?>
                
                <!-- animación para mostrar la alerta automaticamente --> 
                       <span id="action-button-bloqueado" style="display:none;" data-toggle="modal" data-target='#modal-danger-alerta-Bloqueo'></span>
                   
                        <div class="modal fade" id="modal-danger-alerta-Bloqueo" >
                            <div class="modal-dialog">
                              <div class="modal-content bg-info">
                                <div class="modal-header">
                                  <h4 class="modal-title">Información</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                    <center>
                                        <p>El enlace fue copiado con éxito.</p>
                                    </center>
                                </div>
                                 
                              </div>
                            </div>
                        </div>
                        
                <!-- Función de captura de datos por script -->
                
                <script>
                                  function copiarAlPortapapeles(id_elemento) {
                                              var aux = document.createElement("input");
                                              aux.setAttribute("value", document.getElementById(id_elemento).innerHTML);
                                              document.body.appendChild(aux);
                                              aux.select();
                                              document.execCommand("copy");
                                              document.body.removeChild(aux);
                                              //confirm("Enlace copiado");
                                              
                                              /// al momento de copiar el enlace, carga después de 1 segundo el aviso
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
                                                
                                                setTimeout(tiempoCerrar, 1000);
                                                function tiempoCerrar() {
                                                    window.close();
                                                }
                                                
                                            }
                                  </script>
                  
                <!-- /.form-group -->
              
        
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
                  <button type="submit" class="btn btn-primary float-right">Subir imagen</button>
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
<!-- SweetAlert2 -->
<link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>

<script>
    const MAXIMO_TAMANIO_BYTES = 6000000; // 1MB = 1 millón de bytes

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
            title: ` El tamaño máximo del archivo es de 5 MB`
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
<!-- SweetAlert2 -->
<link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<script>
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()
</script>
<script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>

</body>
</html>
<?php
}
?>