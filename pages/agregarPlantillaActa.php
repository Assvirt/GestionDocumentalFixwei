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
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
  
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
  <!-- summernote -->
  <link rel="stylesheet" href="../../plugins/summernote/summernote-bs4.css">
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
<body class="hold-transition sidebar-mini" onload="nobackbutton();"  >
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
            <h1>Nueva Plantilla</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Nueva Plantilla</li>
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
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="plantillas"><font color="white"><i class="fas fa-list"></i> Listar Plantillas</font></a></button>
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
              <form  action="controlador/actas/controllerPlantillas" method="POST" role="form" enctype="multipart/form-data">
                  
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nombre Plantilla: </label>
                    <input type="text" class="form-control" name ="nombre"  value="<?php echo $_POST['nombre'];?>" placeholder="Nombre de la plantilla" autocomplete="off" onkeypress="return ( (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 ||  event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218 || (event.charCode >= 48 && event.charCode <= 57) )" required>
                  </div>
                  <div class="form-group">
                    <label>Desarrollo de la plantilla: </label><br>
                    <p>
                        <span  name="siguiente" class="btn btn-primary float-left" onclick="window.open('uploadImg')"> Subir imagen</span>
                    </p>
                    <br><br>
                    <?php
                    //// se deja para actualización
                    /*
                    ?>
                    <p>
                            
                            
                            <!-- colocamos un efecto de mostrar el formulario -->
                            <?php
                            /////// al momento de retornar la variable ruta, ocultamos el botón de subir
                            if($_POST['ruta'] != NULL){
                                $displaySubirImg='none';
                            }else{
                                $displaySubirImg='';
                            }
                            
                            if($_POST['ruta'] != NULL){
                                $displaySubirImgMostrar='';
                            }else{
                                $displaySubirImgMostrar='none';
                            }
                            ?>
                            <span  id="siguiente" class="btn btn-primary float-left" style="display:<?php echo $displaySubirImg;?>;"> Subir imagen</span>
                            
                            <!-- contenido del formulario para cargar una img -->
                            <div id="contenido_img" style="display:<?php echo $displaySubirImgMostrar;?>;">
                                
                                <span  id="siguiente_cerrar" class="btn btn-danger float-left" > Cerrar</span>
                                <br><br>
                                <div class="form-group">
                    
                                    <label for="exampleInputFile">Subir imagen (Máx 10MB): </label>
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
                                  
                                  <div> 
                                  <!-- 
                                  colocamos el botón subirImg, para enviar solo la img, omitir los campos obligatorios como nombre y textarea al dar clic en el botón subirImg.
                                  después de cargar la img, y dar click en el botón de agregar pone obligatorio los campos nombre y textarea
                                  -->
                                    <button type="submit" id="validar_obligacorios" name="subirImg" class="btn btn-primary float-right">Subir imagen</button>
                                  </div>
                                  
                                  <?php
                                  if(isset($_POST['ruta'])){
                                      
                                  ?>
                                  <div class="form-group">
                                        <label for="exampleInputFile">Ruta imagen: </label><br>
                                        <p id="p1"> <?php echo $_POST['ruta'];?></p>
                                        <span onclick="copiarAlPortapapeles('p1')" class="btn btn-primary"  >Copiar URL</span>
                                  </div> 
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
                                            }
                                  </script>
                                  <!-- animación para mostrar la alerta automaticamente --> 
                                   <button id="action-button-bloqueado" style="display:none;" data-toggle="modal" data-target='#modal-danger-alerta-Bloqueo'></button>
                               
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
                                  <?php
                                  }
                                  ?>
                                
                            </div>
                        </p>
                    
                    <?php
                    */
                                $queryEncabezado = $mysqli->query("SELECT * FROM encabezado WHERE principal = '1'");
                                $encabezado = $queryEncabezado->fetch_array(MYSQLI_ASSOC);
                                $enviarEncabezadoActivo=$encabezado['encabezado'];
                    if($enviarEncabezadoActivo == NULL){
                    ?>
                    <div class="form-group">
                     
                                <div class="form-group col-md-12">
                                    <center>
                                        
                                            <div class="modal-dialog">
                                              <div class="modal-content bg-danger">
                                                <div class="modal-header">
                                                  <h4 class="modal-title">Alerta</h4>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  </button>
                                                </div>
                                                <div class="modal-body">
                                                  <p>Debe aplicar un encabezado.</p>
                                                </div>
                                               <div class="modal-footer justify-content-between">
                                               </div>
                                              </div>
                                            </div>
                                    </center>
                                </div>
                    </div>
                    <?php
                       }else{
                    ?>
                       <div class="form-group ">
                            <textarea name="editor1"  required><?php //echo $enviarEncabezadoActivo; ?><?php echo $_POST['editor1'];?></textarea>
                            <input name="encabezadoAplicado" value="<?php echo $encabezado['id'];?>" type="hidden" readonly>
                        </div>
                    <?php
                       }
                    ?>
                  </div>

                </div>
                <!-- /.card-body -->
                <?php
                if($enviarEncabezadoActivo == NULL){ }else{
                ?>
                <div class="card-footer" >
                  <button type="submit" name="agregar"  id="agregar_registro" class="btn btn-primary float-right">Agregar</button>
                </div>
                <?php
                }
                ?>
              </form>
              
              
              
              
                
                
                
                <!-- Función de captura de datos por script -->
                                    <script>
                                          
                                    
                                     //// validación para cambiar de proceso
                                        /*
                                                $(document).ready(function(){
                                                    $('#siguiente').click(function(){ 
                                                        document.getElementById('contenido_img').style.display = '';
                                                        document.getElementById('siguiente_cerrar').style.display = '';
                                                         document.getElementById('siguiente').style.display = 'none'; 
                                                      
                                                    });
                                                    $('#siguiente_cerrar').click(function(){ 
                                                        document.getElementById('contenido_img').style.display = 'none';
                                                        document.getElementById('siguiente').style.display = ''; 
                                                        document.getElementById('siguiente_cerrar').style.display = 'none';
                                                    });
                                                    
                                                    // retiramos los campos obligatorios del nombre y textarea para enviar la img, al dar clic en el boton subirImg
                                                    $('#validar_obligacorios').click(function(){ 
                                                        //document.getElementById("retiradoTextoE").setAttribute("required","any"); 
                                                        document.getElementById("Anombre").removeAttribute("required","any");
                                                        document.getElementById("editorTexto").removeAttribute("required","any");
                                                    });
                                                    
                                                    // colocamos obligatorio los campos de nombre y textarea para recuperar los campos required
                                                    $('#agregar_registro').click(function(){ 
                                                        //document.getElementById("retiradoTextoE").setAttribute("required","any"); 
                                                        document.getElementById("Anombre").setAttribute("required","any");
                                                        document.getElementById("editorTexto").setAttribute("required","any");
                                                        document.getElementById("exampleInputFile").removeAttribute("required","any");
                                                    });
                                                    
                                                });
                                        */
                                    </script>
              
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
<script>
    CKEDITOR.replace( 'editor1' );
</script>
<!--Ckeditor
<script src="ckeditor/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'editor1' );
</script>-->
<!-- Summernote -->
<script src="../plugins/summernote/summernote-bs4.min.js"></script>
<script>
  $(function () {
    // Summernote
    $('.textarea').summernote()
  })
</script>

<!-- SweetAlert2 -->
<link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>

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