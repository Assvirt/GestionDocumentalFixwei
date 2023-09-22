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
<body class="hold-transition sidebar-mini" onload="nobackbutton();">
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
            <h1>Normatividad</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Normatividad</li>
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
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="normatividad"><font color="white"><i class="fas fa-list"></i> Listar Normatividad</font></a></button>
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
              <?php 
                    $id=$_POST['idNormatividad'];
                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                    $query = $mysqli->query("SELECT * FROM normatividad WHERE id = '$id'");
                    $row = $query->fetch_array(MYSQLI_ASSOC);
                    $nombre = $row['nombre'];
                    $abreviatura = $row['abreviatura'];
                    $descripcion = $row['descripcion'];
                ?>
              <!-- form start -->
              <form role="form" action="controlador/normatividad/controllerNorma" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nombre de la Normatividad:</label>
                    <input type="text" autocomplete="off"  name="nombre" id="nombre" class="form-control" value="<?php echo $nombre;?>"  placeholder="Nombre" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 ||  event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Abreviatura:</label>
                    <input type="text" autocomplete="off"  name="abreviatura" id="abreviatura" class="form-control" value="<?php echo $abreviatura;?>"  placeholder="Abreviatura" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Descripci&oacute;n:</label>
                    <?php
                    $ancho=120; 
                    $cadena=$descripcion;

                    if (strtoupper(substr(PHP_OS,0,3)=='WIN')) { 
                      $eol="\r\n"; 
                    }elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) { 
                      $eol="\r"; 
                    } else { 
                      $eol="\n"; 
                    } 
                    
                    $cad=wordwrap($cadena, $ancho, $eol, 1); 
                    $lineas=substr_count($cad,$eol)+1;
                    ?>
                    <textarea type="text"  name="descripcion" class="form-control"  cols='<?php echo  $ancho; ?>' rows='<?php echo $lineas; ?>' id="exampleInputPassword1" placeholder="Descripci&oacute;n" onkeypress="return (event.charCode >= 13 || (event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 ||  event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required><?php echo $descripcion;?></textarea>
                    <script>
                        jQuery('#test').on('keyup', function() {
                           //jQuery(this).parent().append('<p>' + this.checkValidity() + ' ' + this.validity.patternMismatch + '</p>'); 
                        });
                        
                        
                        $('#test').keyup(validateTextarea);
                        
                        function validateTextarea() {
                                var errorMsg = "( ' ) ( '' ).";
                                var textarea = this;
                                var pattern = new RegExp('^' + $(textarea).attr('pattern') + '$');
                                // check each line of text
                                $.each($(this).val().split("\n"), function () {
                                    // check if the line matches the pattern
                                    var hasError = !this.match(pattern);
                                    if (typeof textarea.setCustomValidity === 'function') {
                                        textarea.setCustomValidity(hasError ? errorMsg : '');
                                    } else {
                                        // Not supported by the browser, fallback to manual error display...
                                        $(textarea).toggleClass('error', !!hasError);
                                        $(textarea).toggleClass('ok', !hasError);
                                        if (hasError) {
                                            $(textarea).attr('title', errorMsg);
                                        } else {
                                            $(textarea).removeAttr('title');
                                        }
                                    }
                                    return !hasError;
                                });
                            }
                    </script>
                  </div>
                  
                  
                   <div class="form-group">
                    <label for="upload-photo">Adjuntar Normatividad (Máx 10MB)</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="miInput"  name="archivo"  >
                        <label class="custom-file-label" >Subir Archivo</label>
                        
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id="">Subir</span>
                      </div>
                    </div>
                  </div>
                  
    

            
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
                    <input name="idNormatividad" type="hidden" value="<?php echo $id; ?>">
                  <button type="submit" name="normatividadEditar" id="agregarNorma" class="btn btn-primary float-right">Actualizar</button>
                  <span id="alerta" style="display:none;color:red;">En el fórmulario no se permite el caracter ( ' ) </span>
                </div>
              </form>
               <script>
                       $(document).ready(function () {
                        $("#nombre").keyup(function () {
                                var value = $(this).val();
                                var cadena = document.getElementById('nombre').value;
                                
                                let buscar = "'";
                                
                                let resultado = cadena.indexOf(buscar);
                                
                                if(resultado !== -1){
                                    //console.log("encontrado");
                                    //alert("Encontrado");
                                    document.getElementById('agregarNorma').style.display = 'none';
                                    document.getElementById('alerta').style.display = '';
                                }else{
                                    //console.log("no encontrado");
                                    document.getElementById('agregarNorma').style.display = '';
                                    document.getElementById('alerta').style.display = 'none';
                                }
                            });
                        });
                        
                        $(document).ready(function () {
                        $("#abreviatura").keyup(function () {
                                var value = $(this).val();
                                var cadena = document.getElementById('abreviatura').value;
                                
                                let buscar = "'";
                                
                                let resultado = cadena.indexOf(buscar);
                                
                                if(resultado !== -1){
                                    //console.log("encontrado");
                                    //alert("Encontrado");
                                    document.getElementById('agregarNorma').style.display = 'none';
                                    document.getElementById('alerta').style.display = '';
                                }else{
                                    //console.log("no encontrado");
                                    document.getElementById('agregarNorma').style.display = '';
                                    document.getElementById('alerta').style.display = 'none';
                                }
                            });
                        });
                        
                        $(document).ready(function () {
                        $("#descripcion").keyup(function () {
                                var value = $(this).val();
                                var cadena = document.getElementById('descripcion').value;
                                
                                let buscar = "'";
                                
                                let resultado = cadena.indexOf(buscar);
                                
                                if(resultado !== -1){
                                    //console.log("encontrado");
                                    //alert("Encontrado");
                                    document.getElementById('agregarNorma').style.display = 'none';
                                    document.getElementById('alerta').style.display = '';
                                }else{
                                    //console.log("no encontrado");
                                    document.getElementById('agregarNorma').style.display = '';
                                    document.getElementById('alerta').style.display = 'none';
                                }
                            });
                        });
                        
                </script>
            </div>
            </div>    

        <div class="col">
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
<script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>
</body>
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
<!-- para mostrar el archivo seleccionado en el file -->
<script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
<!-- END -->
</html>
<?php
}
?>