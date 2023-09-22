<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';

$subCarperta = $_POST['verCarpeta'];

if($subCarperta != NULL){
    
    if(opendir($_SESSION["ruta_carpeta"])){
        $_SESSION["ruta_carpeta"] .=$subCarperta."/";
        $rutaVer=$_SESSION["ruta_carpeta"];
    }else{
        $_SESSION["ruta_carpeta"] = "repositorio/";
        $rutaVer = "repositorio/";
    }
    
    
}else{
    $_SESSION["ruta_carpeta"] = "repositorio/";
    $rutaVer = "repositorio/";
}

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
// echo $_POST['verCarpeta']; echo "<br>";
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Repositorio</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
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
            <h1>Repositorio</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Repositorio</li>
            </ol>
          </div>
        </div>
        <div>
            <?php
                if($visibleI == FALSE){
            ?>
            <div class="row">
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm" data-toggle="modal" data-target="#modal-carpeta"><font color="white"><i class="fas fa-plus-square"></i> Crear carpeta</font></button>
            </div>

            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm" data-toggle="modal" data-target="#modal-subCarpeta"><font color="white"><i class="fas fa-plus-square"></i> Crear sub carpeta</font></button>
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
      
      <!--Modals-->
        <div class="modal fade" id="modal-carpeta">
            <div class="modal-dialog">
              <div class="modal-content">
                  <form action="controlador/repositorio/controllerRepositorio.php" method="POST">
                    <div class="modal-header">
                      <h4 class="modal-title">Crear carpeta</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                
                      <label>Nombre carpeta:</label><br>
                      <input type="text" name="nombreCarpeta" placeholder="Nombre carpeta" class="form-control">
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      <button type="submit" name="crearCarpeta" class="btn btn-primary">Crear carpeta</button>
                    </div>
                </form>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        
        
        <div class="modal fade" id="modal-subCarpeta">
            <div class="modal-dialog">
              <div class="modal-content">
                <form action="controlador/repositorio/controllerRepositorio.php" method="POST">
                <div class="modal-header">
                  <h4 class="modal-title">Crear carpeta</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    
                    <label>Seleccione carpeta:</label><br>
                    <select name="nombreCarpeta" class="form-control" required>
                        <option value=''>Seleccione una carpeta</option>
                    <?php
                        $listar = null;
                        $directorio = opendir("repositorio/");
                        
                        
                        while($elemento = readdir($directorio)){
                            
                            if($elemento != '.' && $elemento != '..'){
                                if(is_dir("repositorio/".$elemento)){
                                    //echo $elemento; echo "<br>";
                                    echo "<option value='$elemento'>$elemento</option>";
                                }
                            
                            }
                            
                        }
                    
                    ?>
                    </select>    
                     
                    
                  <label>Nombre sub carpeta:</label><br>
                  <input type="text" name="nombreSubCarpeta" placeholder="Nombre carpeta" class="form-control" required>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <button type="submit" name="crearSubCarpeta" class="btn btn-primary">Crear sub carpeta</button>
                </div>
                </form>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
      
      
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Carpetas</h3>
                </div>
                  <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                  <?php
                    $directorio = opendir("repositorio/");
                    
                    while($elemento = readdir($directorio)){
                                    
                        if($elemento != '.' && $elemento != '..'){
                            if(is_dir("repositorio/".$elemento)){
                                //echo "*".$elemento; echo "<br>";
                                ?>
                                    <li class="nav-item has-treeview">
                                        <!--<form id="form" action="" method="POST">
                                            <a href="javascript:void(0);" class="nav-link" onclick="$(this).closest('form').submit();" > <!--onclick="myFunction()"-->
                                            <a href="#" class="nav-link" >
                                              <i class="nav-icon fas fa-folder"></i>
                                              <p>
                                                <?php echo $elemento; ?>
                                                <i class="fas fa-angle-left right"></i>
                                              </p>
                                            </a>
                                            <!--<input type="text" value="<?php echo $elemento; ?>" name="verCarpeta" >
                                        </form>-->
                                        <ul class="nav nav-treeview">
                                <?php
                                
                                            
                                $nuevodir = "repositorio/".$elemento;
                                $subdirectorios =opendir($nuevodir);
                                while($elemento2 = readdir($subdirectorios)){
                                    //echo $elemento2;
                                    if($elemento2 != '.' && $elemento2 != '..'){
                                        if(is_dir("repositorio/".$elemento.'/'.$elemento2)){           
                                        //echo "-".$elemento2; echo "<br>";
                                            ?>
                                            <li class="nav-item">
                                                <a href="pages/layout/collapsed-sidebar.html" class="nav-link">
                                                  <i class="far fa-folder"></i>
                                                  <p><?php echo $elemento2; ?></p>
                                                </a>
                                              </li>
                                            <?php
                                        
                                        }            
                                    }
                                }
                            ?>
                                </ul>
                                </li>
                            <?php    
                            }
                        }
                    }
                  ?>
                  </ul>
                </nav>
          </div>
        </div>
        <!-- /.col -->
        
        <?php
        ?>
        
        
        <div class="col-md-12">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Archivos: <?php echo $rutaVer;?><?php echo $mensaje;?></h3>

            </div>
            <div class="col-sm-12" >
                <div class="col-sm">
                    <form action="cargarRegistros" method="POST" target="_blank">
                        <input type="hidden" name="rutaSubir" value="<?php echo $rutaVer;?>">          
                        <button type="submit" class="btn btn-primary btn-sm float-right"> <i class="fas fa-upload"></i>Subir registro</button>
                    </form>
                </div>
    
                <div class="col-sm">
                    <form action="verRegistros" method="POST" target="_blank">
                        <input type="hidden" name="rutaSubir" value="<?php echo $rutaVer;?>">          
                        <button type="submit" class="btn btn-primary btn-sm float-right"> <i class="fas fa-upload"></i>Crear carpeta</button>
                    </form>
                </div>
                
                <div class="col-sm">
                    <form action="verRegistros" method="POST" target="_blank">
                        <input type="hidden" name="rutaSubir" value="<?php echo $rutaVer;?>">          
                        <button type="submit" class="btn btn-primary btn-sm float-right"> <i class="fas fa-upload"></i>Subir registro</button>
                    </form>
                </div>
    

            </div>
            
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="row">
                      
                      <?php
                            /*echo $rutaVer;
                            
                            echo "SESION:".$_SESSION["ruta_carpeta"];echo "<br>";
                            echo "Ruta ve: ".$rutaVer;
                            echo "<br>";*/
                            $directorio = opendir($rutaVer);

                          
                          while($elemento = readdir($directorio)){
                                        
                            if($elemento != '.' && $elemento != '..'){
                                if(is_dir($rutaVer.$elemento)){
                             ?>
                             <div class="col-md-3">
                                 <form action="" method="POST">
                                     <button class="btn" type="submit"><i class="far fa-folder fa-4x" style="padding:0px 20px 5px 20px; "><h6><?php echo $elemento;?></h6></i></button>
                    
                                     <input type="hidden" name="verCarpeta" value="<?php echo $elemento;?>">
                                 </form>
                             </div>
                             <?php
                                }/*else{
                                    ?>
                                    <form action="" method="POST">
                                     <div class="col-md-4">
                                         <button class="btn" type="submit"><i class="far fa-file fa-4x" style="padding:0px 20px 5px 20px; "><br><h6><?php echo $elemento;?></h6></i></button>
                                     </div>
                                     <input type="text" name="verCarpeta" value="<?php echo $elemento;?>">
                                 </form>
                                    <?php
                                }*/
                            }
                              
                          }
                      
                      ?>
                    
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer p-0">
              
            </div>
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
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
	function ConfirmAnular(){
		var answer = confirm("¿Esta seguro de anular?");

		if(answer == true){
			return true;
		}else{
			return false;
		}
	}
</script>
<script>
function myFunction() {
  alert("I am an alert box!");
}
</script>
</body>
</html>
<?php
}
?>