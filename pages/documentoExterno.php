<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
   require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';

$celdulaUser = $_SESSION['session_username']; 
$cargoID = $_SESSION['session_cargo']; 
$idUsuario = $_SESSION['session_idUsuario'];

//////////////////////PERMISOS////////////////////////

$formulario = 'documentoEx'; //aqui se cambia el nombre del formulario

require_once 'permisosPlataforma.php';
//////////////////////PERMISOS////////////////////////
}
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
            <h1>Documentos Externos</h1>
            <h6>Defina los documentos externos objeto de consulta<!--Defina los documentos externos que interactúan con su compañía-->.</h6><br>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Documentos Externos</li>
            </ol>
          </div>
        </div>
        <div>
            <?php
            $visibleI = TRUE;
            //si tiene permiso de insertar , se muestran los botones de agregar, importar y demas
                if($visibleI == TRUE){
            ?>
            <div class="row">
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="agregarDocumentoExterno"><font color="white"><i class="fas fa-plus-square"></i> Agregar</font></a></button>
            </div>
            
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="tipoDocumentoExterno"><font color="white"><i class="fas fa-plus-square"></i> Tipo</font></a></button>
            </div>
            <div class="col-sm">
                    <button type="button" class="btn btn-block btn-info btn-sm"><a href="importacion/importar-documento-externo/documento-externo.xlsx" onClick="javascript:document["ver-form"].submit();"><font color="white"><i class="fas fa-cloud-download-alt"></i> Descargar Plantilla</font></a></button>
                </div>
            <div class="col-sm">
                 <form action="importacion/importar-documento-externo/index" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
                    <div class="custom-file">
                        <input type="file" name="file" class="custom-file-input" id="exampleInputFile" accept=".xls,.xlsx" required>
                                <!-- Agregamos esta linea para validar que solo sea el documento pdf-->
                                <script>
                                $('input[name="file"]').on('change', function(){
                                    var ext = $( this ).val().split('.').pop();
                                    if ($( this ).val() != '') {
                                      if(ext == "xls" || ext == "xlsx"){
                                        
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
                                <!-- END -->
                        <label class="custom-file-label" for="exampleInputFile" required>Importar archivo</label>
                        
                    </div>
            </div>
            <div class="col-sm">
                <button type="submit" name="import" class="btn btn-block btn-info btn-sm"><a class="" href="#"><font color="white"><i class="fas fa-file-upload"></i> Importar</font></a></button>
            </div>
                </form>
            
           
            </div>

        </div>
        <?php }?>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <?  ?>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 800px;">
                <table class="table table-head-fixed text-center" id="example">
                  <thead>
                    <tr>
                      <th>Nombre</th>
                      <th>Tipo</th>
                      <th>Archivo</th>
                      <th style="display:<?php echo $visibleE;?>;">Editar</th>
                      <th style="display:<?php echo $visibleD;?>;">Eliminar</th>
                      
                      
                    </tr>
                  </thead>
                  <tbody>
                     <?php
                     require 'conexion/bd.php';
                     $consultaBuscar=$_POST['buscar'];
                     $consultaBuscar2=$_POST['buscar2'];
                     
                     if($consultaBuscar != NULL || $consultaBuscar2 != NULL){
                         
                         if($consultaBuscar2 != NULL){
                         ///// se trae la consulta de la 3
                         $queryJefeInmediatoConsulta=$mysqli->query("SELECT * FROM documentoExternoTipo WHERE nombre LIKE  '%$consultaBuscar2%' ");
    	                 $rowConsulta=$queryJefeInmediatoConsulta->fetch_array(MYSQLI_ASSOC);
    	                 $nombreJefeInmediato=$rowConsulta['id'];
    	                 ///////// fin
                         }
                         $acentos = $mysqli->query("SET NAMES 'utf8'");
                         $datos = $mysqli->query("SELECT * FROM documentoExterno WHERE nombre LIKE '%$consultaBuscar%' AND tipo LIKE '%$nombreJefeInmediato%' ORDER BY nombre ASC ")or die(mysqli_error());
                     }else{
                         $acentos = $mysqli->query("SET NAMES 'utf8'");
                         $datos = $mysqli->query("SELECT * FROM documentoExterno ORDER BY nombre ASC")or die(mysqli_error());
                     }
                     while($row = $datos->fetch_assoc()){
                         
                         $tipo = $row['tipo'];
                         $acentos = $mysqli->query("SET NAMES 'utf8'");
                         $nombreTipoDocumento = $mysqli->query("SELECT * FROM documentoExternoTipo WHERE id ='$tipo'")or die(mysqli_error());
                         $colu = $nombreTipoDocumento->fetch_array(MYSQLI_ASSOC);
                         $nombreT = $colu['nombre'];
                 
                 
                    echo"<tr>";
                     $idEdit = $row['id'];
                     echo" <td style='text-align: justify;'>".$row['nombre']."</td>";
                     echo" <td style='text-align: justify;'>".$nombreT."</td>";
                     $ruta = $row['ruta'];
                    if($ruta == NULL){
                    echo"<td>
                      <button type='button'  class='btn btn-block btn-warning btn-sm' disabled>
                        <a style='color:black' ><i class='fas fa-download'></i> Descargar</a>
                      </button>
                    </td>";
                    }else{
                    echo"<td>
                      <button type='button'  class='btn btn-block btn-warning btn-sm'>
                        <a style='color:black' href='archivos/documentosExternos/$ruta' target='_blank' onClick='javascript:document['ver-form'].submit();' target='_blank'><i class='fas fa-download'></i> Descargar</a>
                      </button>
                    </td>";
                    }
                     echo"<form action='documentoExternoEditar' method='POST'>";
                     echo"<input type='hidden' name='idDoc' value= '$idEdit' >";
                     echo" <td style='display:$visibleE;'><button type='submit' class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";
                     echo"</form>";
                     /*
                     echo"<form action='controlador/documentoExterno/controller' method='POST'>";
                     echo"<input type='hidden' name='idDoc' value= '$idEdit' >";
                     echo" <td style='display:$visibleD;'><button onclick='return ConfirmDelete()' type='submit' name='eliminar' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</button></td>";
                     echo"</form>";
                     */
                      /// validación de script y funcion de eliminacion
                        ?>
                        <input type='hidden' id='capturaVariable<?php echo $contador++;?>'  value= '<?php echo $idEdit;?>' >
                        <td style='display:<?php echo $visibleD;?>'><a onclick='funcionFormula<?php echo $contador1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a></td>
                        <script>
                            function funcionFormula<?php echo $contador2++;?>() {
                                /*alert("entre");*/
                              document.getElementById("capturarFormula").value = document.getElementById("capturaVariable<?php echo $contador3++;?>").value;
                            }
                       </script>
                        <?php
                        /// END
                    echo"</tr>";
                    }
                    ?> 
                   <div class="modal fade" id="modal-danger">
                        <div class="modal-dialog">
                          <div class="modal-content bg-danger">
                            <div class="modal-header">
                              <h4 class="modal-title">Alerta</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <p>¿Est&aacute; seguro que desea eliminar?</p>
                            </div>
                             <!-- formulario para eliminar por el id -->
                            <form action='controlador/documentoExterno/controller' method='POST'>
                            <div class="modal-footer justify-content-between">
                              <input type="hidden" id="capturarFormula" name='idDoc' readonly>
                              <button type="submit" name='eliminar' class="btn btn-outline-light">Si</button>
                              <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
                            </div>
                             </form>
                             <!-- END formulario para eliminar por el id -->
                          </div>
                        </div>
                    </div>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
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
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
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
<!-- para mostrar el archivo seleccionado en el file -->
<script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
<!-- END -->
<!-- archivos para el filtro de busqueda y lista de información -->

    <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
 
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <script type="text/javascript" src="datatables/datatables.min.js"></script>    
     
    <script type="text/javascript" src="main.js"></script>
<!-- END -->
<!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<?php
/// validaciones de alertas
$validacionExiste=$_POST['validacionExiste'];
$validacionExisteB=$_POST['validacionExisteB'];
$validacionAgregar=$_POST['validacionAgregar'];
$validacionActualizar=$_POST['validacionActualizar'];
$validacionEliminar=$_POST['validacionEliminar'];

$validacionExisteImportacionB=$_POST['validacionExisteImportacionB'];
$validacionExisteE=$_POST['validacionExisteE'];
$validacionExisteImportacionVacio=$_POST['validacionExisteImportacionVacio'];

//// validación de campo vacio, identificando la columna que contiene el campo vacio
$validacionExisteImportacionVacio=$_POST['validacionExisteImportacionVacio'];
$mensajeEnviarCampoVacio=" 'Algunos campos están vacios ".$_POST['mensajeEnviarCampoVacio']." ' ";
/// END
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
    if($validacionExisteImportacionVacio == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: <?php echo $mensajeEnviarCampoVacio;?>
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
    if($validacionExiste == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El nombre ya existe.'
        })
    <?php
    }
     if($validacionExisteImportacionB == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El tipo no existe.'
        })
    <?php
    }
     if($validacionExisteE == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos de los nombres están repetidos en el documento.'
        })
    <?php
    }
    if($validacionExisteB == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' No se pudo cargar el archivo con éxito.'
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
    ?>
    
  });

</script>
<script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>
</body>
</html>
<?php

?>