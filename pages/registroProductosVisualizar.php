<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
//////////////////////PERMISOS////////////////////////
require_once 'conexion/bd.php';

$formulario = 'politicas'; //Se cambia el nombre del formulario

require_once 'permisosPlataforma.php';
//////////////////////PERMISOS////////////////////////

?>
<!DOCTYPE html>
<html>
    <title>Visualizar Documentos</title>
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
               <?php
                $idOrdenCompra=$_POST['idOrdenCompra'];
                $consultaSolicitud=$mysqli->query("SELECT * FROM solicitudCompra WHERE id='$idOrdenCompra' ");
                $extraerCnsultaSolicitud=$consultaSolicitud->fetch_array(MYSQLI_ASSOC);
                $estadoGeneral=$extraerCnsultaSolicitud['estado'];
                ?>
            <h1>Visualizar Documentos Solicitud N°<?php echo $extraerCnsultaSolicitud['id'];?></h1>
            
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Proveedores Documentos</li>
            </ol>
          </div>
        </div>
        <div>
            <div class="row">
             <?php
                if($visibleI == FALSE){
            ?>
            <?php
                }
            ?>
            
            <div class="col-sm"><!-- Vista PPAL -->
            <?php
                $data = $mysqli->query("SELECT * FROM solicitudCompra ORDER BY id ASC")or die(mysqli_error());
                $idCompra = $row['id'];
                echo"<form action='registroProductos' method='POST'>";
                echo"<input type='hidden' name='' value= '$idCompra' >";
                echo"</form>";
                
                if($_POST['gestionar']!= NULL){
            ?>
            <form action="solicitudCompraGestionar" method="post">
             <input name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra']; ?>" type="hidden">
             <button type="submit" class="btn btn-block btn-success btn-sm"><font color="white"><i class="fas fa-list"></i> Regresar</font></button>
            </form>   
            <?php
                }elseif($_POST['comprador']){
            ?>
            <form action="solicitudCompradorVer" method="post">
             <input name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra']; ?>" type="hidden">
             <button type="submit" class="btn btn-block btn-success btn-sm"><font color="white"><i class="fas fa-list"></i> Regresar</font></button>
            </form>
            <?php
                }elseif($_POST['presupuesto']){
            ?>
            <form action="solicitudCompradorEjecutadasVer" method="post">
             <input name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra']; ?>" type="hidden">
             <input name="idPresupuesto" value="<?php echo $_POST['idPresupuesto']; ?>" type="hidden">
             <input name="presupuesto" value="1" type="hidden">
             <button type="submit" class="btn btn-block btn-success btn-sm"><font color="white"><i class="fas fa-list"></i> Regresar </font></button>
            </form> 
            <?php
                }elseif($_POST['ejecutado']){
            ?>
            <form action="solicitudCompradorEjecutadasVer" method="post">
             <input name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra']; ?>" type="hidden">
             <input name="idPresupuesto" value="<?php echo $_POST['idPresupuesto']; ?>" type="hidden">
              
             <button type="submit" class="btn btn-block btn-success btn-sm"><font color="white"><i class="fas fa-list"></i> Regresar </font></button>
            </form> 
            <?php
                }else{
            ?>
            <form action="registroProductos" method="post">
             <input name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra']; ?>" type="hidden">
             <button type="submit" class="btn btn-block btn-success btn-sm"><font color="white"><i class="fas fa-list"></i> Regresar</font></button>
            </form> 
            <?php
                }
            ?>
                
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
            </div>
              <!-- /.card-header -->

              <div class="card-body table-responsive p-0" >
                
                <table class="table table-head-fixed text-center">
                  <thead>
                    <tr>
                    
                      <th>Documento</th>
                     <?php
                      if($_POST['gestionar']!= NULL || $_POST['comprador'] != NULL){}else{
                        if($estadoGeneral == 'Aprobado'){
                            
                        }else{
                     ?>
                        <th style="display:<?php echo$visibleD;?>;">Eliminar</th>
                     <?php
                        }
                      }
                     ?>
                      <script>
                            function funcionFormula<?php echo $contador2++;?>() {
                                /*alert("entre");*/
                              document.getElementById("capturarFormula").value = document.getElementById("capturaVariable<?php echo $contador3++;?>").value;
                            }
                        </script>
                      <th style="display:<?php echo$visibleD;?>;">Descargar</th>
                    </tr>
                  </thead>
                  <tbody>
                   <?php
                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                        $data = $mysqli->query("SELECT * FROM uploads WHERE idSolicitudCompra ='$idOrdenCompra' ORDER BY id ASC")or die(mysqli_error());
                        $idCompra = $row['id'];
                     $conteo=1;
                    while($row = $data->fetch_assoc()){
                       $id = $row['id'];
                    echo"<tr>";
                    "<td>".$conteo++."</td>";
                    
                    if($row['idSolicitudCompra'] > 9){
                        echo "<td>".substr($row['file_name'],2)."</td>";
                    }else{
                        echo "<td>".substr($row['file_name'],1)."</td>";   
                    }
                    
                    
                    if($_POST['gestionar']!= NULL || $_POST['comprador'] != NULL){}else{
                        
                         if($estadoGeneral == 'Aprobado'){}else{
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
                         }
                    }
                      $ruta='almacenamientoMultiple/uploads/'.$row['file_name'];
                    echo"<td>
                          <button  type='button'  class='btn btn-block btn-warning btn-sm'>
                            <i class='fas fa-download'></i>
                            <a style='color:black' href='$ruta' download='' target='_blank'>Descargar</a>
                          </button>
                        </td>";
                        
                    }     
                   ?>
                   
                    
                  </tbody>
                </table>
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
                            <form action='almacenamientoMultiple/file_upload' method='POST'>
                               <input name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra']; ?>" type="hidden">
                               <!--<input name="" value="" type="hidden" readonly>
                               <input name="" value="" type="hidden" readonly>-->
                            <div class="modal-footer justify-content-between">
                              <input type="hidden" id="capturarFormula" name='id' readonly>
                              <button type="submit" name='Eliminar' class="btn btn-outline-light">Si</button>
                              <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
                            </div>
                             </form>
                             <!-- END formulario para eliminar por el id -->
                          </div>
                        </div>
                    </div>
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
<!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<?php
/// validaciones de alertas
$validacionExiste=$_POST['validacionExiste'];
$validacionExisteB=$_POST['validacionExisteB'];
$validacionExisteC=$_POST['validacionExisteC'];
$validacionExisteD=$_POST['validacionExisteD'];
$validacionExisteE=$_POST['validacionExisteE'];
$validacionAgregar=$_POST['validacionAgregar'];
$validacionActualizar=$_POST['validacionActualizar'];
$validacionEliminar=$_POST['validacionEliminar'];


//// validaciones de importacion
$validacionExisteImportacion=$_POST['validacionExisteImportacion'];
$validacionExisteImportacionB=$_POST['validacionExisteImportacionB'];
$validacionExisteImportacionC=$_POST['validacionExisteImportacionC'];
$validacionExisteImportacionD=$_POST['validacionExisteImportacionD'];
$validacionExisteImportacionE=$_POST['validacionExisteImportacionE'];
$validacionExisteImportacionF=$_POST['validacionExisteImportacionF'];
$validacionExisteImportacionH=$_POST['validacionExisteImportacionG'];
$validacionExisteImportacionExito=$_POST['validacionExisteImportacionExito'];
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
    if($validacionExisteImportacionExito == 1){
     ?>
        Toast.fire({
            type: 'success',
            title: ' Excel importado correctamente.'
        })
    <?php   
    }
    if($validacionExisteImportacion == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Está intentando subir un archivo diferente.'
        })
    <?php
    }
    if($validacionExisteImportacionB == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos procesos están repetidos en el documento.'
        })
    <?php
    }
    if($validacionExisteImportacionC == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos prefijos están repetidos en el documento.'
        })
    <?php
    }
    if($validacionExisteImportacionD == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos nombres están repetidos.'
        })
    <?php
    }
    if($validacionExisteImportacionE == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos dueños de procesos no existen.'
        })
    <?php
    }
    if($validacionExisteImportacionF == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos prefijos están repetidos.'
        })
    <?php
    }
    if($validacionExisteImportacionG == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos macroproceso no existen.'
        })
    <?php
    }
    if($validacionExisteImportacionH == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos elementos no existen o estan repetidos.'
        })
    <?php
    }
    
    
    
    
    if($validacionExiste == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El documento ya existe.'
        })
    <?php
    }
    if($validacionExisteB == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El archivo no se pudo eliminar.'
        })
    <?php
    }
    if($validacionExisteC == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El nombre del proceso ya existe.'
        })
    <?php
    }
    if($validacionExisteD == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El prefijo del proceso ya existe.'
        })
    <?php
    }
    if($validacionExisteE == 1){
    ?>
        Toast.fire({
            type: 'success',
            title: ' Documentos aprobados.'
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
}
?>