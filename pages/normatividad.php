<?php
session_start();
error_reporting(E_ERROR);
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
//////////////////////PERMISOS////////////////////////
require_once 'conexion/bd.php';

$formulario = 'normativa'; //Se cambia el nombre del formulario

require_once 'permisosPlataforma.php';

//////////////////////PERMISOS////////////////////////


?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Normatividad</title>
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
            <h1>Normatividad</h1>
            <h6>Defina las normas asociadas a su compañía.</h6><br>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Normatividad</li>
            </ol>
          </div>
        </div>
        <div>
            <?php
            //si tiene permiso de insertar , se muestran los botones de agregar, importar y demas
                if($visibleI == FALSE){
            ?>
            <div class="row">
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="agregarNormatividad"><font color="white"><i class="fas fa-plus-square"></i> Agregar</font></a></button>
            </div>
            
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-warning btn-sm" Onclick="window.location='exportacion/normatividad'"><a href="#"><font color="white"><i class="fas fa-download"></i> Exportar</font></a></button>
            </div>
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="importacion/importar-normatividad/normatividad.xlsx" onClick="javascript:document["ver-form"].submit();"><font color="white"><i class="fas fa-cloud-download-alt"></i> Descargar Plantilla</font></a></button>
            </div>

            <div class="col-sm">
                <form action="importacion2/importar-normatividad/index" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
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
                        <label class="custom-file-label" for="exampleInputFile">Importar archivo</label>
                        
                    </div>
            </div>
            <div class="col-sm">
                <button type="submit" name="import" class="btn btn-block btn-info btn-sm"><a class="" href="#"><font color="white"><i class="fas fa-file-upload"></i> Importar</font></a></button>
            </div>
            </form>
            </div>
            <?php }else{?> 
            <div class="row">
                <div class="col-sm">
                    <button type="button" class="btn btn-block btn-warning btn-sm" Onclick="window.location='exportacion/normatividad'"><a href="#"><font color="white"><i class="fas fa-download"></i> Exportar</font></a></button>
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
                <h3 class="card-title"></h3>
                <?  ?>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" >
                <table class="table table-head-fixed text-center" id="example">
                  <thead>
                    <tr>
                      <th>Nombre de la Norma</th>
                      <th>Abreviatura</th>
                      <th>Descripci&oacute;n</th>
                      <th style="">Plantilla</th><!--Si tiene permiso de editar se muestra la columna editar -->
                      <th style="display:<?php echo$visibleI;?>;">Numeral</th>
                      <th style="display:<?php echo$visibleE;?>;">Editar</th><!--Si tiene permiso de editar se muestra la columna editar -->
                      <th style="display:<?php echo$visibleD;?>;">Eliminar</th><!--Si tiene permiso de editar se muestra la columna eliminar -->
                    </tr>
                  </thead>
                  <tbody>
                     <?php
                     require 'conexion/bd.php';
                     $acentos = $mysqli->query("SET NAMES 'utf8'");
                     $consultaBuscar=$_POST['buscar'];
                     $consultaBuscar2=$_POST['buscar2'];
                     $consultaBuscar3=$_POST['buscar3'];
                     
                     if($consultaBuscar != NULL || $consultaBuscar2 != NULL || $consultaBuscar3 != NULL){
                        $data = $mysqli->query("SELECT * FROM normatividad WHERE nombre LIKE '%$consultaBuscar%' AND abreviatura LIKE '%$consultaBuscar2%' AND descripcion LIKE '%$consultaBuscar3%' ORDER BY nombre ASC")or die(mysqli_error());
                     }else{
                        $data = $mysqli->query("SELECT * FROM normatividad ORDER BY nombre ASC")or die(mysqli_error());
                     }
                     while($row = $data->fetch_assoc()){
                 
                    echo"<tr>";
                    echo" <td style='text-align: justify;'>".$row['nombre']."</td>";
                    echo" <td style='text-align: justify;'>".$row['abreviatura']."</td>";
                    echo '<td style="text-align: justify;">'.nl2br($row['descripcion']).'</td>';
                    //echo" <td style='text-align: justify;'>".$row['descripcion']."</td>";
                    echo "<td>";
                     $ruta =$row['ruta'];
                    if($ruta == "nohayfoto" || $ruta == NULL){ 
                    echo"
                      <button disabled type='button'  class='btn btn-block btn-warning btn-sm'>
                        <i class='fas fa-download'></i><br>Descargar
                      </button>
                    ";
                    }else{
                    echo"
                      <button type='button'  class='btn btn-block btn-warning btn-sm'>
                        <a style='color:black' href='archivos/plantillasNormatividad/$ruta' target='_blank' onClick='javascript:document['ver-form'].submit();' target='_blank' ><i class='fas fa-download'></i> Descargar</a>
                      </button>
                    ";
                    }
                    echo "</td>";
                    $id=$row['id'];
                    echo"<form action='normatividadNumeral' method='POST'>";
                    echo"<input type='hidden' name='idNormatividad' value= '$id' >";
                    echo" <td style='display:$visibleI;'><button type='submit' class='btn btn-block btn-info btn-sm'><i class='fas fa-hashtag'></i> Numeral</button></td>";
                    echo"</form>";
                    echo"<form action='normatividadEditar' method='POST'>";
                    echo"<input type='hidden' name='idNormatividad' value= '$id' >";
                    echo" <td style='display:$visibleE;'><button type='submit' class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";
                    echo"</form>";
                    /*echo"<form action='controlador/normatividad/controllerNorma' method='POST'>";
                    echo"<input type='hidden' name='idNormatividad' value= '$id' >";
                    echo" <td><button style='display:$visibleD;' type='submit' name='EliminarNormatividad' class='btn btn-block btn-danger btn-sm' onclick='return ConfirmDelete()'><i class='fas fa-trash-alt'></i> Eliminar</button></td>";
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
                            <form action='controlador/normatividad/controllerNorma' method='POST'>
                            <div class="modal-footer justify-content-between">
                              <input type="hidden" id="capturarFormula" name='idNormatividad' readonly>
                              <button type="submit" name='EliminarNormatividad' class="btn btn-outline-light">Si</button>
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
<!-- Script advertencia eliminar -->
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
$validacionExisteA=$_POST['validacionExisteA'];
$validacionExisteImportacion=$_POST['validacionExisteImportacion'];
$validacionAgregar=$_POST['validacionAgregar'];
$validacionActualizar=$_POST['validacionActualizar'];
$validacionEliminar=$_POST['validacionEliminar'];



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
      timer: 9000
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
    if($validacionExisteImportacion == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos nombres están repetidos en el documento.'
        })
    <?php
    }

    if($validacionExisteA == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunas de las normas ya existe'
          })
      <?php
      }
       if($validacionExiste == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunas de las normas ya existe: <?php echo $_POST['mensajeAlertaNombreExiste'];?>'
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
    
    if($_POST['alertaEnter'] != NULL){ /// arrojamos el mensaje del enter
    ?>
        Toast.fire({
            type: 'warning',
            title: '<?php echo $_POST['titulo'];?> contiene un (ENTER) no permitido en la celda <?php echo $_POST['alertaEnter'];?> '
        })
    
    <?php
    }
    
    if($_POST['enviarMensajeCaracter'] != NULL){
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaNombre'){
        $mensajeCaracter='El nombre de la norma contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterNombre'){
        $mensajeCaracter='El nombre de la norma contiene caracteres especiales no permitidos : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaAbreviatura'){
        $mensajeCaracter='La abreviatura contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterAbreviatura'){
        $mensajeCaracter='La abreviatura contiene caracteres especiales no permitidos : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaDescripcion'){
        $mensajeCaracter='La descripción contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterDescripcion'){
            $alertaDescripcionNorma='1';
            $normatividadV=str_replace("'","(( ' ))",$_POST['enviarMensajeCaracter']);
            $mensajeCaracter="La descripción contiene unas comillas simples no permitidas (( ' )) :<br><br>".$normatividadV;
        }
        
        if($alertaDescripcionNorma == '1'){
    ?>
        Toast.fire({
            type: 'warning',
            title: "<?php echo $mensajeCaracter;?> "
        })
    
    <?php
        }else{
    ?>
        Toast.fire({
            type: 'warning',
            title: '<?php echo $mensajeCaracter;?> '
        })
    
    <?php
        }
    }
    
    /*if($validacionExisteImportacionVacio == 1){
    ?>
    Toast.fire({
            type: 'warning',
            title: 'Algunos de los campos estan vacios.'
        })
    <?php
       }*/
    ?>
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