<?php
session_start();
error_reporting(E_ERROR);
if(!isset($_SESSION["session_username"])){
   require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
//////////////////////PERMISOS////////////////////////
require_once 'conexion/bd.php';

$formulario = 'tipoDocumento'; //Se cambia el nombre del formulario

require_once 'permisosPlataforma.php';

//////////////////////PERMISOS////////////////////////

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
            <h1>Tipo Documento</h1>
            <h6>Defina los tipos de documentos establecidos en el sistema de gestión de la compañía<!--Defina los tipos de documentos requeridos para el correcto funcionamiento de procesos-->.</h6><br>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Tipo Documento</li>
            </ol>
          </div>
        </div>
        <div>
            <?php
                if($visibleI == FALSE){
            ?>
            <div class="row">
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="agregarTipoDocumento"><font color="white"><i class="fas fa-plus-square"></i> Agregar</font></a></button>
            </div>
            
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-warning btn-sm"><a href="exportacion/tipoDocumento"><font color="white"><i class="fas fa-download"></i> Exportar</font></a></button>
            </div>
            <div class="col-sm">
                <?php
                $root='';
                $root = $_SESSION['session_root'];
                
                if($root == 1){
                    $consultaConsecutivo=$mysqli->query("SELECT * FROM consecutivoDocumento ");
                    $extraerConsecutivo=$consultaConsecutivo->fetch_array(MYSQLI_ASSOC);
                ?>
               <!-- <span id="habilitarParametrizacion" class="btn btn-block btn-success btn-sm"><font color="white"><i class="fas fa-plus-square"></i> Consecutivo</font></span>-->
                <form action="controlador/tipoDocumento/controllerTipoDocumento" method="post" id="mostrarParametrizacion" style="display:none;">
                    <table class="card-body table-responsive p-0">
                    <td>
                        <?php
                        if($extraerConsecutivo['consecutivo'] > 0 ){
                        ?>
                        <input disabled value="<?php echo $extraerConsecutivo['consecutivo'];?>" class="form-control">
                        <?php
                        }else{
                        ?>
                        <input name="consecutivoParametrizacion" placeholder="Consecutivo"  class="form-control">
                        <?php
                        }
                        ?>
                    </td>
                    <?php
                    if($extraerConsecutivo['consecutivo'] > 0){
                    ?>
                     <td><span id="cerrarEvento" class="btn btn-primary float-right" >Cerrar</span></td>
                    <?php
                    }else{
                    ?>
                    <td><button type="submit" class="btn btn-primary float-right" name="consecutivoParametrizacionBoton">Guardar</button></td>
                    <?php
                    }
                    ?>
                    </table>
                </form> 
                <?php
                }
                ?>
            </div>
            <div class="col-sm">       
                   
                 <script>
                                $(document).ready(function(){
                                    $('#habilitarParametrizacion').click(function(){ 
                                        document.getElementById('habilitarParametrizacion').style.display = 'none';
                                        document.getElementById('mostrarParametrizacion').style.display = '';
                                    });
                                    $('#cerrarEvento').click(function(){ 
                                        document.getElementById('habilitarParametrizacion').style.display = ''; 
                                        document.getElementById('mostrarParametrizacion').style.display = 'none';
                                    });
                                    
                                });
                    </script>
            </div>
            <div class="col-sm">
                
                   
            </div>
            <div class="col-sm">
                
            </div>
            </div>
            <?php }else{?> 
            <div class="row">
                <div class="col-sm">
                    <button type="button" class="btn btn-block btn-warning btn-sm" Onclick="window.location='exportacion/tipoDocumento'"><a href="#"><font color="white"><i class="fas fa-download"></i> Exportar</font></a></button>
                </div>
                <div class="col-sm"></div>
                <div class="col-sm"></div>
                <div class="col-sm"></div>
                <div class="col-sm"></div>
            </div>
            <?php }//si no, solo el de exportar?>
        </div>
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
                
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" >
                <table class="table table-head-fixed text-center" id="example">
                  <thead>
                    <tr>
                      <th>Tipo de documento</th>
                      <th>Prefijo</th>
                      <th>Descripción</th>
                      <!--<th style="">Plantilla</th><!--Si tiene permiso de editar se muestra la columna editar -->
                      <th style="">Descargar Plantilla</th><!--Si tiene permiso de editar se muestra la columna editar -->
                      <th style="display:<?php echo$visibleE;?>;">Editar</th><!--Si tiene permiso de editar se muestra la columna editar -->
                      <th style="display:<?php echo$visibleD;?>;">Eliminar</th><!--Si tiene permiso de editar se muestra la columna eliminar -->
                    </tr>
                  </thead>
                  <tbody>
                     <?php
                     require 'conexion/bd.php';
                     $consultaBuscar=$_POST['buscar'];
                     $consultaBuscar2=$_POST['buscar2'];
                     $consultaBuscar3=$_POST['buscar3'];
                     $acentos = $mysqli->query("SET NAMES 'utf8'");
                     if($consultaBuscar != NULL || $consultaBuscar2 != NULL || $consultaBuscar3 != NULL){
                         $data = $mysqli->query("SELECT * FROM tipoDocumento WHERE nombre LIKE '%$consultaBuscar%' AND prefijo LIKE '%$consultaBuscar2%' AND descripcion LIKE '%$consultaBuscar3%' ORDER BY nombre ASC")or die(mysqli_error());
                     }else{
                         $data = $mysqli->query("SELECT * FROM tipoDocumento ORDER BY nombre ASC")or die(mysqli_error());
                     }
                     while($row = $data->fetch_assoc()){
                 
                    echo"<tr>";
                    $id = $row['id'];
                    echo" <td style='text-align: justify;'>".$row['nombre']."</td>";
                     echo" <td style='text-align: justify;'>".$row['prefijo']."</td>";
                     echo" <td style='text-align: justify;'>".$row['descripcion']."</td>";
                     $ruta =$row['ruta'];
                    
                    if($ruta == "Nohayfoto" || $ruta == NULL){ ///onclick='showAlert()'
                    echo"<td>
                      <button disabled type='button'  class='btn btn-block btn-warning btn-sm'>
                        <i class='fas fa-download'></i><br>Descargar
                      </button>
                    </td>";
                    }else{
                    echo"<td>
                      <button type='button'  class='btn btn-block btn-warning btn-sm'>
                        <i class='fas fa-download'></i>
                        <a style='color:black' href='archivos/plantillasTipoDocumento/$ruta' download='$ruta' target='_blank'>Descargar</a>
                      </button>
                    </td>";
                    
                    
                    }
                    
                     $ruta = $row['ruta'];
                    /*
                    if($ruta == "Nohayfoto" || $ruta == NULL){ ///onclick='showAlert()'
                    echo"<td>
                      <button disabled type='button'  class='btn btn-block btn-warning btn-sm'>
                        <i class='fas fa-download'></i><br>Descargar Plantilla
                      </button>
                    </td>";
                    }else{
                    echo"<td>
                      <button type='button'  class='btn btn-block btn-warning btn-sm'>
                        <i class='fas fa-download'></i>
                        <a style='color:black' href='$ruta' download='$ruta' target='_blank'>Descargar Plantilla</a>
                      </button>
                    </td>";
                    
                    }
                    
                    */
                     echo"<form action='tipoDocumentoEditar' method='POST'>";
                     echo"<input type='hidden' name='idTipo' value='$id'>";
                     echo" <td style='display:$visibleE;'><button type='submit' class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";
                     echo"</form>";
                     /*
                     echo"<form action='controlador/tipoDocumento/controllerTipoDocumento' method='POST'>";
                     echo"<input type='hidden' name='idTipo' value='$id'>";
                     echo" <td><button style='display:$visibleD;' type='submit' name='eliminarTipo' class='btn btn-block btn-danger btn-sm' onclick='return ConfirmDelete()'><i class='fas fa-trash-alt'></i> Eliminar</button></td>";
                     echo"</form>";*/
                     /// validación de script y funcion de eliminacion
                        ?>
                        <input type='hidden' id='capturaVariable<?php echo $contador++;?>'  value= '<?php echo $id;?>' >
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
                            <form action='controlador/tipoDocumento/controllerTipoDocumento' method='POST'>
                            <div class="modal-footer justify-content-between">
                              <input type="hidden" id="capturarFormula" name='idTipo' readonly>
                              <button type="submit" name='eliminarTipo' class="btn btn-outline-light">Si</button>
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

 <script>
  function showAlert() {
    var myText = "El documento no tiene plantilla.";
    alert (myText);
  }
  </script>
  <!-- archivos para el filtro de busqueda y lista de informaci��n -->
  
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
<script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>
<?php
/// validaciones de alertas
$validacionExiste=$_POST['validacionExiste'];
$validacionExisteB=$_POST['validacionExisteB'];
$validacionAgregar=$_POST['validacionAgregar'];
$validacionActualizar=$_POST['validacionActualizar'];
$validacionEliminar=$_POST['validacionEliminar'];
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
    if($validacionExisteB == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El documento ya existe.'
        })
    <?php
    }
    
    
    if($validacionExiste == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El nombre o prefijo ya existe.'
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
</body>
</html>
<?php
}
?>