<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
   require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';


//////////////////////PERMISOS////////////////////////
require_once 'conexion/bd.php';

$formulario = 'gruposDis'; //aqui se cambia el nombre del formulario
//require_once 'permisosPlataforma.php';
$documento = $_SESSION["session_username"];
$queryGrupos = $mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario = '$documento'");

while($row = $queryGrupos->fetch_assoc()){
    $idGrupo = $row['idGrupo'];
    
    $queryPermisos = $mysqli->query("SELECT * FROM permisos WHERE idGrupo = '$idGrupo' AND formulario = '$formulario'");
    $permisos = $queryPermisos->fetch_array(MYSQLI_ASSOC);
    if($permisos['listar'] == TRUE){
        $permisoListar = $permisos['listar'];    
    }
    if($permisos['crear'] == TRUE){
        $permisoInsertar = $permisos['crear'];    
    }
    if($permisos['editar'] == TRUE){
        $permisoEditar = $permisos['editar'];    
    }
    if($permisos['eliminar'] == TRUE){
       $permisoEliminar = $permisos['eliminar'];    
    }
    
}

$root = $_SESSION['session_root'];

if($root == 1){
    $permisoListar = TRUE;
    $permisoInsertar = TRUE;
    $permisoEditar = TRUE;
    $permisoEliminar = TRUE;
}

if($permisoListar == FALSE){
    echo '<script language="javascript">window.location.href="accesoDenegado"</script>';
}

if($permisoInsertar == FALSE){
    $visibleI = 'none';
}else{
    $visibleI = '';
}

if($permisoEditar == FALSE){
    $visibleE = 'none';
}else{
    $visibleE = '';
}

if($permisoEliminar == FALSE){
    $visibleD = 'none';
}else{
    $visibleD = '';
}
//////////////////////PERMISOS////////////////////////

?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Grupos de Distribución</title>
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
  <?php  require_once'menu.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Grupos de Distribución</h1>
            <h6>Gestione los grupos de trabajo.</h6><br>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Grupos de Distribución</li>
            </ol>
          </div>
        </div>
        <div>
            <div class="row">
            
            <?php
            if($root == 1){
            ?>    
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-danger btn-sm"><a href="limitarPermisos"><font color="white"><i class="fas fa-list"></i> Limitar permisos</font></a></button>
            </div>
            <?php
            }
            
                if($visibleI == FALSE){
            ?>
            
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="agregarGrupos"><font color="white"><i class="fas fa-plus-square"></i> Agregar</font></a></button>
            </div>
            <div class="col-sm"></div>
            <div class="col-sm"></div>
            <div class="col-sm"></div>
            <div class="col-sm"></div>
           
            <?php
                }else{
            ?>
            <div class="col-sm">
            </div>
            <div class="col-sm"></div>
            <div class="col-sm"></div>
            <div class="col-sm"></div>
            <div class="col-sm"></div>
            
            <?php
                }
            ?>
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
                  
                  <?php ?>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-head-fixed text-center" id="example">
                  <thead>
                    <tr>
                      <th>Grupo de distribución</th>
                      <th>Descripción</th>
                      <th>Ver más</th>
                      <th style="display:<?php echo $visibleE;?>;">Editar</th><!--Si tiene permiso de editar se muestra la columna editar -->
                      <th style="display:<?php echo $visibleD;?>;">Eliminar</th><!--Si tiene permiso de editar se muestra la columna eliminar -->
                      <th>Permisos</th>
                      <!--<th>Notificación</th>-->
                    </tr>
                  </thead>
                  <tbody>
                     <?php
                     require 'conexion/bd.php';
                     $consultaBuscar=$_POST['buscar'];
                     $consultaBuscar2=$_POST['buscar2'];
                     
                     if($consultaBuscar != NULL || $consultaBuscar2 != NULL){
                         $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                        $data = $mysqli->query("SELECT * FROM grupo WHERE nombre LIKE '%$consultaBuscar%' AND descripcion LIKE '%$consultaBuscar2%' order by nombre")or die(mysqli_error());
                     }else{
                         $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                        $data = $mysqli->query("SELECT * FROM grupo order by nombre")or die(mysqli_error());    
                     }
                     
                     while($row = $data->fetch_assoc()){
                 
                    echo"<tr>";
                    $id = $row['id'];
                     echo" <td style='text-align: justify;'>".$row['nombre']."</td>";
                     echo" <td style='text-align: justify;'>".$row['descripcion']."</td>";
                     echo"<form action='gruposVer' method='POST'>";
                     echo"<input type='hidden' name='idGrupo' value='$id'>";
                     echo"<td><button type='submit' class='btn btn-block btn-primary btn-sm'><i class='fas fa-eye'></i> Ver más</button></td>";
                     echo"</form>";
                     echo"<form action='gruposEditar' method='POST'>";
                     echo"<input type='hidden' name='idGrupo' value='$id'>";
                     echo" <td style='display:$visibleE;'><button name='editar' type='submit' class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";
                     echo"</form>";
                     
                     /// validamos si el grupo ya se encuentra en uso, en caso de ser así no me permite eliminar este grupo en caso que no, me deja eliminarlo
                     $consultarGrupo=$mysqli->query("SELECT * FROM grupoUusuario WHERE idGrupo='$id' ");
                     $verifficandoGrupo=$consultarGrupo->fetch_array(MYSQLI_ASSOC);
                     $existenciaDelGrupo=$verifficandoGrupo['idGrupo'];
                     if($id == $existenciaDelGrupo){
                     echo" <td style='display:$visibleD;'><button style='display:$visibleD;' disabled class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</button></td>";
                     }else{
                    /*
                     echo"<form action= 'controlador/grupos/controllerGrupos' method='POST'>";
                     echo"<input type='hidden' name='idGrupo' value='$id'>";
                     echo" <td style='display:$visibleD;'><button onclick='return ConfirmDelete()' style='display:$visibleD;' name='eliminar' type='submit' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</button></td>";
                     echo"</form>";
                    */
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
                     /// END
                     echo"<form action='permisos' method='post'>";
                     echo"<input type='hidden' name='idGrupo' value='$id'>";
                     echo" <td><button  type='submit' class='btn btn-block btn-info btn-sm'><i class='fa fa-unlock-alt'></i> Permisos</button></td>";
                     echo"</form>";
                     /*
                     if($row['correo'] == NULL || $row['correo'] == '0'){
                      $nombreTituloBoton='Activar';
                      $notificacionValidar='1';
                     }else{
                      $nombreTituloBoton='Desactivar';
                      $notificacionValidar='0';
                     }
                     echo "<form action='controlador/grupos/controllerGrupos' method='POST'>";
                     echo "<input type='hidden' name='permisoCorreo' value='$notificacionValidar'>";
                     echo "<input type='hidden' name='idGrupo' value='$id'>";
                     echo "<td><button  type='submit' name='ActivarCorreo' class='btn btn-block btn-warning btn-sm'><i class='fa fa-bell'></i> $nombreTituloBoton</button></td>";
                     echo "</form>";
                     */
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
                            <form action='controlador/grupos/controllerGrupos' method='POST'>
                            <div class="modal-footer justify-content-between">
                              <input type="hidden" id="capturarFormula" name='idGrupo' readonly>
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
$validacionExisteB=$_POST['validacionExisteB'];
$validacionAgregar=$_POST['validacionAgregar'];
$validacionActualizar=$_POST['validacionActualizar'];
$validacionEliminar=$_POST['validacionEliminar'];
$validacionCorreo=$_POST['validacionCorreo'];
$validacionCorreoD=$_POST['validacionCorreoD'];
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
            title: ' El nombre del grupo ya existe.'
        })
    <?php
    }
    if($validacionExisteB == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El nombre del grupo ya existe.'
        })
    <?php
    }
    
    if($validacionCorreo == 1){
    ?>
        Toast.fire({
            type: 'success',
            title: 'Permiso de notificación de correo activado.'
        })
    <?php
    }
    if($validacionCorreoD == 1){
      ?>
          Toast.fire({
              type: 'success',
              title: 'Permiso de notificación de correo desactivado.'
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