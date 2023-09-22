<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
//require_once 'inactividad.php';

$celdulaUser = $_SESSION['session_username']; 
$cargoID = $_SESSION['session_cargo']; 
$idUsuario = $_SESSION['session_idUsuario'];

$root2=$_SESSION["session_root"];

if($root2 != 1){
   echo '<script language="javascript">window.location.href="accesoDenegado"</script>';
}
//////////////////////PERMISOS////////////////////////

$formulario = 'actas'; //aqui se cambia el nombre del formulario

require_once 'permisosPlataforma.php';
//////////////////////PERMISOS////////////////////////

?>

<!DOCTYPE html>
<html>
    
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Encabezados</title>
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
<body class="hold-transition sidebar-mini" onload="nobackbutton();" oncopy="return false" onpaste="return false">
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
            <h1>Encabezados</h1>
            <h6>Establezca la información, actividades y desarrollo de una reunión.</h6><br>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Encabezados</li>
            </ol>
          </div>
        </div>
        <div>
            <?php
            if($visibleI == FALSE){
            ?>
             <div class="row">
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="crearEncabezadoCrear"><font color="white"><i class="fas fa-plus-square"></i> Crear</font></a></button>
            </div>
            <div class="col-sm">
                     <button type="button" class="btn btn-block btn-info btn-sm"><a href="actas"><font color="white"><i class="fas fa-list"></i> Listar Actas</font></a></button>
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
            <?php
                }else{
            ?>
             <div class="row">
            <div class="col-sm">
                     <button type="button" class="btn btn-block btn-info btn-sm"><a href="actas"><font color="white"><i class="fas fa-list"></i> Listar Actas</font></a></button>
            </div>
            <div class="col-sm">
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
            <?php
                }
            ?>
           
           
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
              <div class="card-body table-responsive p-0">
                <table class="table table-head-fixed text-center" id="example">
                  <thead>
                    <tr>
                      <th>N° Plantilla</th>
                      <th>Nombre</th>
                      <th>Principal</th>
                      <th>Editar</th>
                      <th>Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $consultandoEncabezados=$mysqli->query("SELECT count(*) FROM encabezado WHERE principal='1' ");
                    $extraerConsultaEncabezado=$consultandoEncabezados->fetch_array(MYSQLI_ASSOC);
                    $cantidadPrincipalenUno=$extraerConsultaEncabezado['count(*)'];
                        
                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                     
                    $data = $mysqli->query("SELECT * FROM encabezado  ORDER BY nombre ASC")or die(mysqli_error());
                    $contando=1;
                    while($row = $data->fetch_assoc()){
                    echo"<tr>";
                    
                    $id = $row['id'];
                    echo" <td>".$contando++."</td>";
                    echo" <td>".$row['nombre']."</td>";
                    if($row['principal'] == '1'){
                        echo"<form action='controlador/actas/encabezado' method='POST'>";
                        echo"<input type='hidden' name='id' value= '$id' >";
                        echo" <td><button type='submit' name='desaplicar' class='btn btn-block btn-warning btn-sm' $habilitaEditar><i class='fas fa-clipboard-check'></i> Desaplicar</button></td>";
                        echo"</form>";
                    }else{
                        /// validamos la cantidad de encabezados
                        if($cantidadPrincipalenUno == 1){
                            echo" <td><button disabled class='btn btn-block btn-warning btn-sm' $habilitaEditar><i class='fas fa-clipboard-check'></i> Aplicar</button></td>";
                        }else{
                            echo"<form action='controlador/actas/encabezado' method='POST'>";
                            echo"<input type='hidden' name='id' value= '$id' >";
                            echo" <td><button type='submit' name='aplicar' class='btn btn-block btn-warning btn-sm' $habilitaEditar><i class='fas fa-clipboard-check'></i> Aplicar</button></td>";
                            echo"</form>";
                        }
                        /// end
                    }
                    
                    echo"<form action='crearEncabezado' method='POST'>";
                    echo"<input type='hidden' name='id' value= '$id' >";
                    echo" <td><button type='submit' class='btn btn-block btn-success btn-sm' $habilitaEditar><i class='fas fa-edit'></i> Editar</button></td>";
                    echo"</form>";  
                    
                   
                     /// validaci��n de script y funcion de eliminacion
                        ?>
                        <input type='hidden' id='capturaVariable<?php echo $contador++;?>'  value= '<?php echo $id;?>' >
                        <?php
                        /// validamos que este encabezado se ha usado al menos 1 vez en plantillas
                        $consultandoPlantillas=$mysqli->query("SELECT * FROM actasPlantilla WHERE idEncabezado='".$row['id']."' ");
                        $extraeConsultaPlantilla=$consultandoPlantillas->fetch_array(MYSQLI_ASSOC);
                        ////// END
                        
                        /// validamos que este encabezado se ha usado al menos 1 vez en actas
                        $consultandoActas=$mysqli->query("SELECT * FROM actas WHERE idEncabezado='".$row['id']."' ");
                        $extraeConsultaActas=$consultandoActas->fetch_array(MYSQLI_ASSOC);
                        ////// END
                        
                        if($row['id'] == $extraeConsultaPlantilla['idEncabezado'] || $row['id'] == $extraeConsultaActas['idEncabezado']){
                        ?>
                        <td><button disabled style='color:white;' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</button></td>
                        <?php
                        }else{
                        ?>
                        <td><a onclick='funcionFormula<? echo $contador1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a></td>
                        <?php
                        }
                        ?>
                        <script>
                            function funcionFormula<?php echo $contador2++;?>() {
                                /*alert("entre");*/
                              document.getElementById("capturarFormula").value = document.getElementById("capturaVariable<? echo $contador3++;?>").value;
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
                            <form action='controlador/actas/encabezado' method='POST'>
                            <div class="modal-footer justify-content-between">
                              <input type="hidden" id="capturarFormula" name='id' readonly>
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
$validacionAgregar=$_POST['validacionAgregar'];
$validacionActualizar=$_POST['validacionActualizar'];
$validacionActualizarB=$_POST['validacionActualizarB'];
$validacionActualizarC=$_POST['validacionActualizarC'];
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
    if($validacionExiste == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El nombre ya existe.'
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
    
    if($validacionActualizarB == 1){
    ?>
        Toast.fire({
            type: 'success',
            title: 'Encabezado aplicado.'
        })
    <?php
    }
    if($validacionActualizarC == 1){
    ?>
        Toast.fire({
            type: 'success',
            title: 'Encabezado desaplicado.'
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