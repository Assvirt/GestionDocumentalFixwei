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
    <title>Proveedores Carpetas</title>
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
              <?php
                    $idProveedor=$_POST['idProveedor'];
                    $query = $mysqli->query("SELECT * FROM proveedores WHERE id= '$idProveedor'");
                    $row = $query->fetch_array(MYSQLI_ASSOC);
                    $idEnviarProveedor = $row['id'];
                    $nit = $row['nit'];
                    $proveedor = $row['razonSocial'];
                    $proveedorEstado = $row['estado'];
                    $realizador = $row['realizador'];
                    $bloqueoCarpeta = $row['bloqueoCarpeta'];
              ?>
            <h1>Carpetas del proveedor <?php echo $proveedor; ?></h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Proveedores Carpetas</li>
            </ol>
          </div>
        </div>
        <div>
            
            <div class="row">
            <?php
            if($visibleI == FALSE){
            ?>
            
           
                <?php
                if($bloqueoCarpeta == 1){
                    
                }else{
                ?>
                <div class="col-sm">
                <form action="agregarCarpeta" method="POST">
                    <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                    <button type="submit" class="btn btn-block btn-info btn-sm"><a href="#"><font color="white"><i class="fas fa-plus-square"></i> Nueva Carpeta</font></a></button>
                </form>
                
                </div>
            <?php
                }
            ?>
            
            <?php
            }else{ }
            ?>
            <!--
            <div class="col-sm">
                <form action="proveedoresVer" method="POST">
                    <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                <button type="submit" class="btn btn-block btn-success btn-sm"><a href="#"><font color="white"><i class="fas fa-list"></i> Regresar</font></a></button>
                </form>
            </div>
            -->
            
            <?php
            if($proveedorEstado == 'Aprobado'){
            ?>
            <div class="col-sm"><!-- Vista PPAL -->
                <button type="button" class="btn btn-block btn-success btn-sm"><a href="proveedores"><font color="white"><i class="fas fa-list"></i> Regresar</font></a></button>
            </div>
            <?php
                
            }else{
            ?>
            <div class="col-sm"><!-- Vista PPAL -->
                <button type="button" class="btn btn-block btn-success btn-sm"><a href="proveedoresInscripcion"><font color="white"><i class="fas fa-list"></i> Regresar</font></a></button>
            </div>
            <?php
            }
            
            ?>
            <!--
            <div class="col-sm">
                  <a href="pruebas.php">
   <button type="button" class="btn btn-block btn-warning btn-sm"><a href="pruebas.php"><font color="white"><i class="fas fa-list"></i> Pruebas</font></a></button>
</a>
            </div>-->
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
                <div class="card-body table-responsive p-1 card-tools">
                           
                           
              </div>
            </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" >
                <table class="table table-head-fixed ">
                  <thead>
                    <tr>
                      <th>Carpeta</th>
                      <th></th>
                      <th style="display:<?php echo$visibleE;?>;">Editar</th>
                      <th></th>
                      <!--<th>Soporte</th>-->
                    </tr>
                  </thead>
                  <tbody>
                     <?php
                     require 'conexion/bd.php';
                     //$acentos = $mysqli->query("SET NAMES 'utf8'");
                     
                     $data = $mysqli->query("SELECT * FROM proveedordocumentosCarpetas WHERE idProveedor='$idProveedor' ORDER BY nombre ASC")or die(mysqli_error());
                     
                     $conteo=1;
                     while($row = $data->fetch_assoc()){
                        $id = $row['id'];
                     echo"<tr>";
                     echo"<td>";
                    ?>
                    <form action="proveedorDocumetos" method="post">
                        <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                        <input name="idCarpeta" value="<?php echo $id; ?>" type="hidden" readonly>
                        <button type="submit" style="border:0px;background:transparent;" name="agregarArchivos">
                        <?php
                            echo"<span style=' color:#293B7D;' ><i class='fa fa-folder fa-2x' ></i></span><font color='white'>--</font>".utf8_encode($row['nombre'])." ";
                        ?>
                        </button>
                    </form>
                    <?php
                    echo "</td>";
                    $contadorContenido=$mysqli->query("SELECT count(*) FROM `proveedorSubCarpetas` WHERE idCarpeta='$id' ");
                    $extraerConsultaContenido=$contadorContenido->fetch_array(MYSQLI_ASSOC);
                    $contenidoContador=$extraerConsultaContenido['count(*)'];
                    if($contenidoContador > 1){
                        $contenidoArchivo='archivos';
                        $contenidoContador=$extraerConsultaContenido['count(*)'];
                    }else{
                        if($contenidoContador > 0 && $contenidoContador <= 1){
                        $contenidoArchivo='archivo';    
                        $contenidoContador=$extraerConsultaContenido['count(*)'];
                        }else{
                        $contenidoArchivo='sin documentos';
                        $contenidoContador='';
                        }
                    }
                    echo '<td>'.'</td>';//$contenidoContador.' '.$contenidoArchivo.
                    echo '<td style="display:'.$visibleE.';">';
                    ?>
                    <form action="agregarCarpetaEditar" method="post">
                        <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                        <input name="idCarpeta" value="<?php echo $id; ?>" type="hidden" readonly>
                    <button type="submit" class="btn btn-block btn-success btn-sm"><i class="fas fa-edit"></i> Editar</button>
                    </form>
                    <?php
                    echo '</td>';
                    echo '<td></td>';
                    
                    //$ruta=$row['soporte'];
                    /*
                        echo"<td>
                          <button type='button'  class='btn btn-block btn-warning btn-sm'>
                            <i class='fas fa-download'></i>
                            <a style='color:black' href='$ruta' download='' target='_blank'>Descargar</a>
                          </button>
                        </td>";
                    */
                    echo"</tr>";
                    
                        
                    } 
                    ?>
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
$validacionComentario=$_POST['validacionComentario'];

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
    if($validacionComentario == 1){
     ?>
        Toast.fire({
            type: 'success',
            title: ' Comentario agregado.'
        })
    <?php   
    }
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
            type: 'success',
            title: ' El aprobador fue notificado.'
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
            title: ' La carpeta ya existe.'
        })
    <?php
    }
    if($validacionExisteB == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El prefijo ya existe.'
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
            type: 'warning',
            title: ' El proceso se encuentra en uso, no se puede eliminar.'
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


<script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>
<?php
}
?>