<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';

//////////////////////PERMISOS////////////////////////
require_once 'conexion/bd.php';

$formulario = 'usuarios'; //Se cambia el nombre del formulario

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
  <title>FIXWEI - Lista de regitros</title>
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
            <h1>Lista de regitros</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Lista de regitros</li>
            </ol>
          </div>
        </div>
        <div>
            <?php
                if($visibleI == FALSE){
            ?>
            <div class="row">
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="cargarRegistros"><font color="white"><i class="fas fa-upload"></i> Cargar Registros</font></a></button>
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
            <?php }else{?>
            <div class="row">
                <div class="col-sm">
                    <button type="button" class="btn btn-block btn-warning btn-sm" Onclick="window.location='exportacion/usuarios'"><a href="#"><font color="white"><i class="fas fa-download"></i> Exportar</font></a></button>
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
                <h3 class="card-title">Lista</h3>
                <br>
                <div>
                            <input  type="radio" id="rad_si" name="radiobtn3" value="si" required>
                            <label  for="cargo">Habilitar filtros</label>
                            <input  type="radio" id="rad_no" name="radiobtn3" value="no" required>
                            <label  for="usuarios">Ocultar</label>
                </div>
                <div class="card-tools">
                    <?php
                    
                    $idDocumento = $_POST['idDocumento'];
                    
                    //////conserva la consulta
                     $consultaBuscar=$_POST['buscar'];
                     
                    if($consultaBuscar != NULL){
                         $filtroActivar='';  
                     }else{
                         $filtroActivar='none';
                     }
                    ?>        
                            
                            
                            
                    <div id="aprovar_regitros" style="display:<?php echo $filtroActivar; ?>;">
                        <form action="" method="POST">  
                          <table>
                              <tr>
                                  <td>
                                      <div class="input-group input-group-sm" style="width: 150px;">
                                        <input type="text" name="buscar" class="form-control float-right" value="<?php echo $consultaBuscar; ?>" placeholder="Nombre">
                                          <div class="input-group-append">
                                          <!-- <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button> -->
                                        </div>
                                      </div>
                                  </td>
                                  <td>                              
                                      <div class="input-group input-group-sm" style="width: 150px;">
                                          <div class="input-group-append">
                                          <input type="hidden" name="idDocumento" value="<?php echo $idDocumento;?>">
                                          <button type='submit' class='btn btn-block btn-info btn-sm'><i class='fas fa-search'></i> Buscar</button>
                                          </div>
                                      </div>      
                                  </td>
                                  <td>                              
                                      <div class="input-group input-group-sm" style="width: 150px;">
                                          <div class="input-group-append">
                                          <input type="hidden" name="idDocumento" value="<?php echo $idDocumento;?>">
                                          <button type='button' Onclick="window.location='listaRegistros'" class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Limpiar busqueda</button>
                                          </div>
                                      </div>      
                                  </td>
                              </tr>
                          </table>
                        </form>
                </div>
              </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 800px;">
                <table class="table table-head-fixed text-center">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Nombre del regitro</th>
                      <th>Fecha de creación</th>
                      <th>Aprobador</th>
                      <th>Estado</th>
                      <th>Fecha de aprobación</th>
                      <th>Ver mas</th>
                      <th style="display:<?php echo$visibleE;?>;">Editar</th>
                      <th style="display:<?php echo$visibleD;?>;">Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>
                     <?php
                     require 'conexion/bd.php';
                     
                     //$acentos = $mysqli->query("SET NAMES 'utf8'");
                     $consultaBuscar=$_POST['buscar'];

                     
                     
                     if($consultaBuscar != NULL){
                         
                         
                        $data = $mysqli->query("SELECT * FROM registros WHERE nombre LIKE '%$consultaBuscar%' AND idDocumento = '$idDocumento'  ORDER BY id ASC")or die(mysqli_error());
                     }else{
                        
                        //$data = $mysqli->query("SELECT * FROM registros WHERE idDocumento = $idDocumento ORDER BY id ASC" )or die(mysqli_error());
                        $data = $mysqli->query("SELECT * FROM registros" )or die(mysqli_error());
                         
                     }
                     $n = 1;
                     while($row = $data->fetch_assoc()){
                         
                        $idRegistro= $row['id'];
                        $quienAprueba = $row['aprobador'];
                        $quienApruebaID = json_decode($row['aprobadorID']);
                        $longitud = count($quienApruebaID);
                         
                        
                        $idEdit = $row['id'];
                    echo"<tr>";
                    echo "<td>".$n."</td>";
                    echo "<td>".$row['nombre']."</td>";
                    echo "<td>".$row['fechaCreacion']."</td>";
                    
                    
                    ?>
                    <td>
                    <?php
                    
                        if($quienAprueba == 'usuarios'){
                                    
                            for($i=0; $i<$longitud; $i++){
                            
                                $nombreuser = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$quienApruebaID[$i]'");
                                $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                            
                                echo "- ".$aprobador = $columna['nombres']." ".$columna['apellidos']; echo "<br>";
                                     
                            }
                        }
                        if($quienAprueba == 'cargos'){
                                    
                            for($i=0; $i<$longitud; $i++){
                                $nombrecargo = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienApruebaID[$i]'");
                                $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                echo "- ".$aprobador = $columna['nombreCargos'];echo "<br>";
                            }
                        }
                        if($quienAprueba == NULL){
                            echo "<strong>No Aplica</strong>";
                        }
                        
                    ?>
                    </td>
                    <?php
                    
                    echo "<td>".$row['estado']."</td>";
                    
                    
                    
                    
                    if($row['fechaAprobacion'] == NULL){
                        echo "<td><strong> No aplica</strong></td>";
                    }else{
                        echo "<td>".$row['fechaAprobacion']."</td>";
                    }
                    
                   
                                        
                    echo"<form action='verRegistro' method='POST'>";
                    echo"<input type='hidden' name='idRegistro' value= '$idRegistro' >";
                    echo"<input type='hidden' name='idDocumento' value= '$idDocumento' >";
                    echo"<td><button type='submit' class='btn btn-block btn-primary btn-sm'><i class='fas fa-eye'></i> Ver más</button></td>";
                    echo"</form>";
                    echo"<form action='editarRegistro' method='POST'>";
                    echo"<input type='hidden' name='idRegistro' value= '$idRegistro' >";
                    echo"<input type='hidden' name='idDocumento' value= '$idDocumento' >";
                    echo" <td style='display:$visibleE;'><button type='submit' class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";
                    echo"</form>";
                    echo"<form action='controlador/registros/controller.php' method='POST'>";
                    echo"<input type='hidden' name='idRegistro' value= '$idRegistro' >";
                    echo"<input type='hidden' name='idDocumento' value= '$idDocumento' >";
                    echo" <td style='display:$visibleD;'><button onclick='return ConfirmDelete()' type='submit' name='eliminar' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</button></td>";
                    echo"</form>";
                    echo"</tr>";
                    $n++;    
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
<script>
    $(document).ready(function(){
        $('#rad_si').click(function(){
            document.getElementById('aprovar_regitros').style.display = '';
        });
        $('#rad_no').click(function(){
            document.getElementById('aprovar_regitros').style.display = 'none';
        });
    });
</script>
</body>
</html>
<?php
}
?>