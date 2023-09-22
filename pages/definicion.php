<?php
session_start();
error_reporting(E_ERROR);
if(!isset($_SESSION["session_username"])){
   require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
//////////////////////PERMISOS////////////////////////
require_once 'conexion/bd.php';

$formulario = 'definicion'; //Se cambia el nombre del formulario
require_once 'permisosPlataforma.php';
//////////////////////PERMISOS////////////////////////
?>
<!DOCTYPE html>
<html>
    
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Definiciones</title>
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
            <h1>Definici&oacute;n</h1>
            <h6>Gestione el glosario de palabras clave de su compañía.</h6><br>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Definici&oacute;n</li>
            </ol>
          </div>
        </div>
        <div>
            <?php
                if($visibleI == FALSE){
            ?>
            <div class="row">
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="agregarDefinicion"><font color="white"><i class="fas fa-plus-square"></i> Agregar</font></a></button>
            </div>
          <!--  <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="#"><font color="white"><i class="fas fa-user-plus"></i> Agregar Nivel Cargo</font></a></button>
            </div> -->
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-warning btn-sm"><a href="exportacion/definicion"><font color="white"><i class="fas fa-download"></i> Exportar</font></a></button>
            </div>
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="importacion/importar-definicion/definicion.xlsx" onClick="javascript:document["ver-form"].submit();"><font color="white"><i class="fas fa-cloud-download-alt"></i> Descargar Plantilla</font></a></button>
            </div>

            <div class="col-sm">
                <form action="importacion2/importar-definicion/index" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
                    <div class="custom-file">
                        <input type="file" name="file" class="custom-file-input" id="exampleInputFile" accept=".xls,.xlsx" required>
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
                <button type="button" class="btn btn-block btn-warning btn-sm"><a href="exportacion/definicion"><font color="white"><i class="fas fa-download"></i> Exportar</font></a></button>
                </div>
                <div class="col-sm"></div>
                <div class="col-sm"></div>
                <div class="col-sm"></div>
                <div class="col-sm"></div>
            </div>

            <?php }?>
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
                <? ?>
              </div>
              <style> 
                  textarea#note {
                	width:100%;
                	box-sizing:border-box;
                	direction:justify;
                	display:block;
                	max-width:100%;
                	line-height:1.5;
                	padding:15px 15px 30px;
                	border-radius:3px;
                	border:1px solid #F7E98D;
                	font:13px Tahoma, cursive;
                	transition:box-shadow 0.5s ease;
                	box-shadow:0 4px 6px rgba(0,0,0,0.1);
                	font-smoothing:subpixel-antialiased;
                	overflow: hidden;
                 }
                   .fake-textarea {
                    border: 1px solid black;
                    width: 30rem;
                    padding: .5rem;
                    min-height: 3rem;
                  }
                  .fake-textarea:empty::before {
                    position: absolute;
                    content: "Escribe aquí...";
                  }
                  .disabled {
                    opacity: 1.0;
                  }
                    .disabled:after {
                        width: 100%;
                        height: 100%;
                        position: absolute; 
}
              </style>
              <script src="https://rawgit.com/jackmoore/autosize/master/dist/autosize.min.js"></script>
           
              
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 800px;">
                <table class="table table-head-fixed text-center" id="example">
                  <thead>
                    <tr>
                      <th>Nombre</th>
                      <th>Definici&oacute;n</th>
                      <th>Fuente</th>
                      <th style="display:<?php echo$visibleE;?>;">Editar</th>
                      <th style="display:<?php echo$visibleD;?>;">Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>
                     <?php
                     require 'conexion/bd.php';
                     $acentos = $mysqli->query("SET NAMES 'utf8'");
                     $consultaBuscar=$_POST['buscar'];
                     $consultaBuscar2=$_POST['buscar2'];
                     
                     if($consultaBuscar != NULL || $consultaBuscar2 != NULL){
                        if($consultaBuscar >= 0){
                        $data = $mysqli->query("SELECT * FROM definicion WHERE nombreN LIKE '%$consultaBuscar%' AND definicion LIKE '%$consultaBuscar2%' ORDER BY nombreN,nombre ASC ")or die(mysqli_error());
                        }
                        if($consultaBuscar <> is_numeric($consultaBuscar)){
                            $data = $mysqli->query("SELECT * FROM definicion WHERE nombre LIKE '%$consultaBuscar%' AND definicion LIKE '%$consultaBuscar2%' ORDER BY nombreN,nombre ASC ")or die(mysqli_error());
                        }
                         
                     }else{
                        $data = $mysqli->query("SELECT * FROM definicion ORDER BY nombre ASC ")or die(mysqli_error());
                     }
                     while($row = $data->fetch_assoc()){
                 
                    echo"<tr>";
                    if($row['nombreN'] > 0){
                        echo" <td style='text-align: justify;'>".$row['nombreN']."</td>";
                    }else{    
                        echo" <td style='text-align: justify;'>".$row['nombre']."</td>";
                    }
                    
                    $ancho=120; 
                    $cadena=$row['definicion'];

                    if (strtoupper(substr(PHP_OS,0,3)=='WIN')) { 
                      $eol="\r\n"; 
                    }elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) { 
                      $eol="\r"; 
                    } else { 
                      $eol="\n"; 
                    } 
                    
                    $cad=wordwrap($cadena, $ancho, $eol, 1); 
                    $lineas=substr_count($cad,$eol)+1; 
                    
                    //echo" <td style='text-align: justify;'><textarea id='note' cols='$ancho' rows='$lineas' style='border-color:white;width:;Height:;' readonly='readonly' class='disabled' >".$cadena."</textarea></td>";
                    
                    echo '<td style="text-align: justify;">'.nl2br($row['definicion']).'</td>';
                    
                    $id = $row['id'];
                    $fuente = $row['fuente'];
                    
                    if($fuente != NULL){
                        
                        $fuente;
                        $inicioLink=$fuente[0].''.$fuente[1].''.$fuente[2].''.$fuente[3].''.$fuente[4];
                       
                        if($inicioLink == 'https'){
                               echo"<td><button type='button'  class='btn btn-block btn-warning btn-sm'><a href='$fuente' target=\"_blank\" style=\"color:black;\"><i class='fas fa-link'></i> <font color='black'>Fuente</font></a></button></td>";
                        }else{
                          
                            ?>
                            <input type='hidden' id='capturaVariableE<? echo $contadorE++;?>'  value= '<?php echo $fuente;?>' >
                            <td><a onclick='funcionFormulaE<? echo $contador1E++;?>()' style='color:black;' data-toggle='modal' data-target='#modal-dangerE' class='btn btn-block btn-warning btn-sm'><i class='fas fa-link'></i>Fuente</a></td>
                            <script>
                                function funcionFormulaE<? echo $contador2E++;?>() {
                                  
                                var dato =  document.getElementById("capturarFormulaE").value = document.getElementById("capturaVariableE<? echo $contador3E++;?>").value;
                                   
                                }
                           </script>
                            <?php
                        }
                    }else{
                        echo" <td><button disabled class='btn btn-block btn-warning btn-sm'><i class='fas fa-link'></i><font color='black'>Fuente</font></button></td>";
                    }
                    
                    echo"<form action='definicionEditar' method='POST'>";
                    echo"<input type='hidden' name='idDefinicion' value= '$id' >";
                    echo" <td style='display:$visibleE;'><button type='submit' class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";
                    echo"</form>";
                    /*
                    echo"<form action='controlador/definicion/controladordefinicion' method='POST'>";
                    echo"<input type='hidden' name='idDefinicion' value= '$id' >";
                    echo" <td style='display:$visibleD;'><button type='submit' name='EliminarDefinicion' class='btn btn-block btn-danger btn-sm' onclick='return ConfirmDelete()'><i class='fas fa-trash-alt'></i> Eliminar</button></td>";
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
                            <form action='controlador/definicion/controladordefinicion' method='POST'>
                            <div class="modal-footer justify-content-between">
                              <input type="hidden" id="capturarFormula" name='idDefinicion' readonly>
                              <button type="submit" name='EliminarDefinicion' class="btn btn-outline-light">Si</button>
                              <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
                            </div>
                             </form>
                             <!-- END formulario para eliminar por el id -->
                          </div>
                        </div>
                    </div>
                    <style>
                        textarea {
                          text-align: justify;
                          white-space: normal;
                        }
                    </style>
                    <div class="modal fade" id="modal-dangerE">
                        <div class="modal-dialog">
                          <div class="modal-content bg-warning">
                            <div class="modal-header">
                              <h4 class="modal-title">Fuente</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <p><textarea readonly id="capturarFormulaE" style="background:transparent;border-color:transparent;" class="form-control" ></textarea></p>
                            </div>
                            <div class="modal-footer justify-content-between">
                            </div>
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
$validacionAgregar=$_POST['validacionAgregar'];
$validacionActualizar=$_POST['validacionActualizar'];
$validacionEliminar=$_POST['validacionEliminar'];

/// validaciones de importacion
$validacionExisteImportacin=$_POST['validacionExisteImportacion'];
$validacionExisteImportacinB=$_POST['validacionExisteImportacionB'];

/// END

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
      timer: 5000
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
    /*if($validacionExisteImportacionVacio == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos campos están vacios.'
        })
    <?php
    }*/
    if($validacionExisteImportacin == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Está intentando subir un archivo diferente.'
        })
    <?php
    }
    if($validacionExisteImportacinB == 1){
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
            title: ' Algunas definiciones ya existen'
        })
    <?php
    }
    
    if($validacionExiste == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunas definiciones ya existen: <?php echo $_POST['MensajevalidacionExiste'];?>'
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
        $mensajeCaracter='El nombre contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterNombre'){
        $mensajeCaracter='El nombre contiene caracteres especiales no permitidos : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaDescripcion'){
        $mensajeCaracter='La definición contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterDescripcion'){
            
            $alertaDefinicion='1';
            $definicion=str_replace("'","(( ' ))",$_POST['enviarMensajeCaracter']);
            
            
        $mensajeCaracter="La definición contiene unas comillas simples no permitidas (( ' )) : <br></br>".$definicion;
        }
        
        if($alertaDefinicion == 1){
        ?> 
            Toast.fire({
                type: 'warning',
                title: "<?php echo $mensajeCaracter;?>"
            })
        
        <?php
        }else{
        ?> 
            Toast.fire({
                type: 'warning',
                title: '<?php echo $mensajeCaracter;?>'
            })
        
        <?php
        }
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
}
?>