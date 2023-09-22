<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';

//////////////////////PERMISOS////////////////////////
require_once 'conexion/bd.php';

//$formulario = 'solicitudCom'; //Se cambia el nombre del formulario
//require_once 'permisosPlataforma.php';
//////////////////////PERMISOS////////////////////////

?>
<!DOCTYPE html>
<html>
    <title>Evaluación</title>
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
            <h1>Evaluación</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Evaluación</li>
            </ol>
          </div>
        </div>
        <div class="col-sm-6">
        
      </div><!-- /.container-fluid -->
       
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
          <div class="col">
              <div class="row">
                <div class="col-9">
                    <div class="row">
                        <div class="col-sm">
                          <button  type="button" class="btn btn-block btn-info btn-sm"><a href="evaluacion"><font color="white"><i class="fas fa-list"></i> Listar evaluaciones</font></a></button>
                        </div>
                        <div class="col-sm">
                        <span style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-success btn-sm'><i class="fas fa-plus-square"></i> Encabezado</span>
                        
                        <!-- desde el formulario por ajax realizamos el insert-->
                        <div class="modal fade" id="modal-danger">
                            <div class="modal-dialog modal-xl">
                              <div class="modal-content bg-success">
                                <div class="modal-header">
                                  <h4 class="modal-title">Crear encabezado</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <p>Se digita la información que se visualiza al inicio del examen</p>
                                </div>
                                 <!-- formulario para eliminar por el id -->
                                <form method="post" id="js-form-encabezado" onsubmit="return false" >
                                <div class="modal-body">
                                 
                                  <textarea type="text"  placeholder="Encabezado..." class="form-control"  id="js-encabezado" name="encabezado" ></textarea>
                                 </div>
                                <div class="modal-footer justify-content-between">
                                  <button type="reset" id="js-enviar" class="btn btn-outline-light" data-dismiss="modal">Si</button>
                                  <button type="button" class="btn btn-outline-light" data-dismiss="modal"  onClick="funcion_reiniciarEncabezado();">No</button>
                                </div>
                               
                                 </form>
                                 
                              </div>
                            </div>
                        </div>
                        <!-- END el código de ajax se encuentra después del filtro  -->
                        </div>
                        <div class="col-sm">
                            <span style='color:white;' data-toggle='modal' data-target='#modal-danger-preguntas' class='btn btn-block btn-success btn-sm'><i class="fas fa-plus-square"></i> Pregunta</span>
                         
                        <!-- desde el formulario por ajax realizamos el insert-->
                        <div class="modal fade" id="modal-danger-preguntas">
                            <div class="modal-dialog modal-xl">
                              <div class="modal-content bg-success">
                                <div class="modal-header">
                                  <h4 class="modal-title">Pregunta</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <p>Digíte la pregunta y seleccione el tipo de pregunta.</p>
                                </div>
                                 <!-- formulario para eliminar por el id -->
                                <form method="post" id="js-form-preguntas" onsubmit="return false" >
                                <div class="modal-body">
                                 <select name="tipoPregunta" id="tipoPregunta" class="form-control">
                                     <option value=""></option>
                                     <option value="1">Respuesta única</option>
                                     <option value="2">Respuesta multiple</option>
                                     <option value="3">Respuesta abierta</option>
                                 </select>
                                 
                                </div>
                                <div class="modal-footer justify-content-between">
                                  <button type="reset" id="js-enviar-preguntas" class="btn btn-outline-light" data-dismiss="modal">Si</button>
                                  <button type="button" class="btn btn-outline-light" data-dismiss="modal"  onClick="funcion_reiniciarPreguntas();">No</button>
                                </div>
                               
                                 </form>
                                 
                              </div>
                            </div>
                        </div>
                        <!-- END el código de ajax se encuentra después del filtro  -->
                        </div>
                        <div class="col-sm">
                            <span style='color:white;'  class='btn btn-block btn-success btn-sm'><i class="fas fa-plus-square"></i> Modo de calificación</span>
                        
                        </div>
                </div>
                 
                
          
            </div>

          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
     
     <section class="content-header">
         <div class="container-fluid">
            <div class="row">
                <div class="col-sm">
               
               
                           
                </div>
            </div>  
        </div>      
        <div class="row">
           
          <!-- /.col (LEFT) -->
          <div class="col-md-12">
            <!-- LINE CHART -->
            
            
            
            
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Formulario </h3>
                </div>
                <div class="card-body">
                    <div class="chart">
                        
                         
                   
                       
                      
                      
                    
                     
                    </div>
                </div>
            </div>
            
            
                      
                                   

          </div>
          <!-- /.col (RIGHT) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    
    
                        <script> /// creamos el ajax para registrar los datos
                            $(document).on('click', '#js-enviar', function(e){
                            	e.preventDefault();
                            	var encabezado = $('#js-encabezado').val();
                            	    alert(encabezado);
                            
                            	/*$.ajax({
                            		url: 'registroProductosInsert.php', // Es importante que la ruta sea correcta si no, no se va a ejecutar
                            		method: 'POST',
                            		data: { reg1: reg1, reg2: reg2, reg3: reg3, reg4: reg4 },
                            		beforeSend: function(){
                            			$('#mostrarDatos').css('display','block');
                            			//$('#estado p').html('Guardando datos...');
                            		},
                            		success: function(r){
                            			//if (r == '200' ) { // Si el php anterior, imprimió 200
                            				$('#mostrarDatos').html(r);
                            				document.getElementById("js-form").reset();
                            				//location.reload();
                            			//} else {
                            			//	$('#estado').html('<hr><p>Error al guardar los datos.</p><hr>');
                            			//}
                            		}
                            	}); */
                            });
                         
                        function funcion_reiniciarEncabezado(){
                            document.getElementById("js-form-encabezado").reset();
                        }
                        </script>
    
    
  </div>
  <!-- /.content-wrapper -->
<?php //echo require_once'footer.php'; ?>

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
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
<!-- Script advertencia eliminar -->
<!--Librerias para el estilo del campo para cargar archivos -->


<!-- END-->
<?php
  $validacionActualizar=$_POST['validacionActualizar'];
  $validacionEliminar=$_POST['validacionEliminar'];
?>

<script type="text/javascript">
	function ConfirmDelete(){
		var answer = confirm("¿Esta seguro de eliminar?");

		if(answer == true){
			return true;
		}else{
			return false;
		}
	}
</script>

<script type="text/javascript">
    function ConfirmDelete(){
      var answer = confirm("¿Esta seguro de eliminar?");

      if(answer == true){
        return true;
      }else{
        return false;
      }
    }
    function ConfirmAnular(){
      var answer = confirm("¿Esta seguro de anular?");

      if(answer == true){
        return true;
      }else{
        return false;
      }
    }
  </script>
  
<script type='text/javascript'>
	    //document.oncontextmenu = function(){return false}
    </script>


  <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>-->
 
     
    <!-- archivos para el filtro de busqueda y lista de información -->
    <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
 
    <!--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <script type="text/javascript" src="datatables/datatables.min.js"></script>    
     
    <script type="text/javascript" src="main.js"></script>
    <!-- END -->
    
    
    
      <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- SweetAlert2 -->
  <script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
  <?php
  /// validaciones de alertas
  $validacionExiste=$_POST['validacionExiste'];
  $validacionExisteA=$_POST['validacionExisteA'];
  $validacionExisteB=$_POST['validacionExisteB'];
  $validacionAgregar=$_POST['validacionAgregar'];
  $validacionAgregarB=$_POST['validacionAgregarB'];
  $validacionActualizar=$_POST['validacionActualizar'];
  $validacionEliminar=$_POST['validacionEliminar'];
  $validacionEliminarB=$_POST['validacionEliminarB'];
  $Tipodocumeto=$_POST['Tipodocumeto'];

  //// Validaciones de la importación
  $validacionExisteImportacionA=$_POST['validacionExisteImportacionA'];
  $validacionExisteImportacionB=$_POST['validacionExisteImportacionB'];
  $validacionExisteImportacionC=$_POST['validacionExisteImportacionC'];
  $validacionExisteImportacionD=$_POST['validacionExisteImportacionD'];
  $validacionExisteImportacionE=$_POST['validacionExisteImportacionE'];
  $validacionExisteImportacionF=$_POST['validacionExisteImportacionF'];
  $validacionExisteImportacionG=$_POST['validacionExisteImportacionG'];
  $validacionExisteImportacionI=$_POST['validacionExisteImportacionI'];
  $validacionExisteImportacionVacio=$_POST['validacionExisteImportacionVacio'];
  //// END
  
  
    $validacionProductoExiste=$_POST['validacionProductoExiste'];
    $validacionCodigoExiste=$_POST['validacionCodigoExiste'];
    $validacionIdentificadorExiste=$_POST['validacionIdentificadorExiste'];
    $validacionNumericoExiste=$_POST['validacionNumericoExiste'];
  
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
      if($validacionNumericoExiste == 1){
        ?>
          Toast.fire({
              type: 'warning',
              title: ' Esta intentando ingresar letras en un campo númerico.'
          })
        <?php
      }
      if($validacionProductoExiste == 1){
        ?>
          Toast.fire({
              type: 'warning',
              title: ' El producto no existe.'
          })
        <?php
      }
      if($validacionCodigoExiste == 1){
        ?>
          Toast.fire({
              type: 'warning',
              title: ' El código no existe.'
          })
        <?php
      }
      if($validacionIdentificadorExiste == 1){
        ?>
          Toast.fire({
              type: 'warning',
              title: ' El identificador no existe.'
          })
        <?php
      }
      
      
      
      
      
      if($Tipodocumeto == 1){
        ?>
          Toast.fire({
              type: 'warning',
              title: ' El tipo de documento no es valido.'
          })
        <?php
      }
      
      if($validacionExisteImportacionVacio == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos campos están vacios.'
          })
      <?php
      }
       if($validacionExisteImportacionA == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos cargos no existen en el sistema.'
          })
      <?php
      }
      if($validacionExisteImportacionB == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos lideres no existe en el sistema.'
          })
      <?php
      }
      if($validacionExisteImportacionC == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos procesos no existe en el sistema.'
          })
      <?php
      }
      if($validacionExisteImportacionD == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos centro de costos no existe en el sistema.'
          })
      <?php
      }
      if($validacionExisteImportacionE == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos centro de trabajo no existe en el sistema.'
          })
      <?php
      }
      if($validacionExisteImportacionF == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos grupos no existe en el sistema.'
          })
      <?php
      }
      if($validacionExisteImportacionG == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos usuarios ya existen.'
          })
      <?php
      }
      if($validacionExisteImportacionI == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Está intentando subir un archivo diferente.'
          })
      <?php
      }
      
      
      if($validacionExiste == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' El usuario ya existe.'
          })
      <?php
      }
      if($validacionExisteA == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' La fecha seleccionada no debe superar la del presente año.'
          })
      <?php
      }
      if($validacionExisteB == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' La cédula ya existe con otro usuario, asegúrese que el número de documento permanezca al usuario que se encuentra editando.'
          })
      <?php
      }
      
      if($validacionAgregar == 1){
      ?>
          Toast.fire({
              type: 'success',
              title: 'Registro agregado.'
          })
      <?php
      }
      if($validacionAgregarB == 1){
      ?>
          Toast.fire({
              type: 'success',
              title: 'Registro activado.'
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
      
      if($validacionEliminar == 1){ 
      ?>
          Toast.fire({
              type: 'error',
              title: 'Registro eliminado.'
          })
      
      <?php
      }
      if($validacionEliminarB == 1){
      ?>
          Toast.fire({
              type: 'error',
              title: 'Registro Anulado.'
          })
      
      <?php
      }
      ?>
      
    });

  </script>
 
  <script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
  <script type="text/javascript">
  $(document).ready(function () {
    bsCustomFileInput.init();
  });
  </script>
  <!-- END -->
  <!--Ckeditor
  <script src="ckeditor/ckeditor.js"></script>
  <script>
    CKEDITOR.replace( 'encabezado' );
  </script>
  -->
</body>
</html>
<?php

}
?>
<!-- END -->
</body>
</html>
