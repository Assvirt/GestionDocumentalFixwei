<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';

$idGrupo = $_POST['idGrupo'];
require 'conexion/bd.php';
$queryGrupo = $mysqli->query("SELECT nombre FROM grupo WHERE id ='$idGrupo'");
$rowNombre = $queryGrupo->fetch_array(MYSQLI_ASSOC);
$nomGrupo = strtoupper($rowNombre['nombre']);

?>
<!DOCTYPE html>
<html>
<head><meta charset="gb18030">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - NOTIFICACIONES</title>
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
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="../plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
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
            <h1>NOTIFICACI&Oacute;N DEL USUARIO</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Notificaci&oacute;n</li>
            </ol>
          </div>
        </div>
            <div class="row">
                <div class="col">
                    
                </div>
                <div class="col-9">
                    <div class="row">
                        <div class="col-sm">
                            <button type="button" class="btn btn-block btn-success btn-sm"><a href="myperfil"><font color="white"><i class="fas fa-chevron-left"></i> Regresar</font></a></button>
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
                <div class="col">
                    
                </div>
                
           
            </div>
        <div>

        </div>
      </div><!-- /.container-fluid -->
    </section>
    
    <!-- TABLA PERMISOS-->
    <section class="content">
        <div class="container-fluid">
                <div class="row">
                    <div class="col"></div>
                  <div class="col-9">
                    <!-- Default box -->
                    <?php
                                        $nombreuser = $mysqli->query("SELECT * FROM notificaciones WHERE idUsuario = '$sesion'");
                                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                        $habilitado=$columna['idUsuario'];
                                        
                      if($habilitado === $sesion){  
                        echo '<font color="orange"><b>Las notificaciones se encuentran habilitadas</b></font>';
                    
                        }else{
                    ?>        
                    <form action="controlador/controllerNotificacion" method="POST">
                        <input name="usuario" type="hidden" readonly value="<?php echo $sesion; ?>">
                        <button type="submit" name="habilitar" class="btn btn-block btn-warning btn-sm"><i class="fa fa-bell"></i> Habilitar</button>
                    </form>
                    <?
                        }
                    ?>
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">CONFIGURACI&Oacute;N</h3>
            
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                              <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                <i class="fas fa-times"></i></button>
                            </div>
                          </div>
                          
                           <?php
                            require_once 'conexion/bd.php';
                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                            $data = $mysqli->query("SELECT * FROM notificaciones WHERE idUsuario='$sesion' ");
                            ?>
                          <div class="card-body">
                                <table class="table table-bordered text-center">
                                    <thead>                  
                                        <tr>
                                          <th>Modulo</th>
                                          <th style="width: 10px">Correo</th>
                                          <th style="width: 10px">Plataforma</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <?php
                                            while($row = $data->fetch_assoc()){
                                                
                                                if($row['correo']==TRUE){
                                                    $checkListar = "checked";
                                                }else{
                                                    $checkListar = "";
                                                }
                                                
                                                if($row['plataforma']==TRUE){
                                                    $checkCrear = "checked";
                                                }else{
                                                    $checkCrear = "";
                                                }
                                                
                                                echo "<form action='controlador/controllerNotificacion' method='POST'>";
                                                echo"<tr>";
                                                $valindadoF=$row['formulario'];
                                                $nombreUsuario = $mysqli->query("SELECT nombre,idformulario FROM formularios WHERE idformulario ='$valindadoF' ")or die(mysqli_error());
                                                $col = $nombreUsuario->fetch_array(MYSQLI_ASSOC);
                                                $nombreF = $col['nombre'];
                                                
                                                echo "<td>".$nombreF."</td>";
                                                echo "<td><input name='correoU' value='".$row['correo']."' type='checkbox' ".$checkListar."></td>";
                                                echo "<td><input name='plataformaU' value='".$row['plataforma']."' type='checkbox' ".$checkCrear."></td>";
                                                echo "<td><button type='submit' name='Addnotificaciones' class='btn btn-primary float-right'>Actualizar</button></td>";
                                                echo"</tr>";
                                                echo "<input name='usuario' value='$sesion' type='hidden' >";
                                                echo "<input name='id' value='".$row['id']."' type='hidden' >";
                                                echo '</form>';
                                            }
                                        ?>
                                        
                                      </tbody>
                                </table>
                          </div>
                          <!-- /.card-body 
                          <div class="card-footer">
                            <button type="submit" name="Addnotificaciones" class="btn btn-primary float-right">Actualizar</button>
                          </div>
                          card-footer-->
                        </div>
                    
                    <!-- /.card -->
                  </div>
                  <div class="col"></div>
                </div>
        </div>
    </section>
    <!-- TABLA PERMISOS-->
   
    
        



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
<!-- Bootstrap4 Duallistbox -->
<script src="../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>

<script>
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()
</script>
</body>
</html>
<?php
}
?>