<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin p&aacute;gina</title>
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
  
  <!-- evento para el actualizar o eliminar  -->
  <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
<!-- finaliza el evento  --> 
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
            <h1>Admin p&aacute;gina</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Admin p&aacute;gina</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        
        <center>
            <body class="hold-transition login-page">
            <div class="login-box">
              <div class="login-logo">
                <a href="../index2.html"><b>Token</b> </a>
              </div>
              <!-- /.login-logo -->
              <div class="card">
                <div class="card-body login-card-body">
                  <p class="login-box-msg">Token de seguridad</p>
            <?php
            require 'conexion/bd.php';
            $queryJefeInmediato=$mysqli->query("SELECT * FROM usuario WHERE cedula='$sesion' ");
            $rowDatos=$queryJefeInmediato->fetch_array(MYSQLI_ASSOC);
            $idChatUsuario=$rowDatos['id'];
            $validacionClave = $rowDatos['clave'];
            ?>
                  <form action="" method="post">
                    <div class="input-group mb-3">
                      <input type="text" class="form-control" value="<?php echo $nombres; ?>" placeholder="Correo" disabled required>
                      <input type="" name="cc" class="form-control" value="<?php echo $sesion; ?>" placeholder="Correo" disabled required>
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-envelope"></span>
                        </div>
                      </div>
                    </div>
                    <div class="input-group mb-3">
                      <input type="password" name="clave" class="form-control" value="<?php echo $validacionClave; ?>" placeholder="Contrase&ntilde;a" disabled required>
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-lock"></span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                     
                      <!-- /.col -->
                      <div class="col-4">
                         <button type="submit" name="validacion" class="btn btn-primary btn-block">Validar</button> 
                      </div>
                      <!-- /.col -->
                    </div>
                  </form>
            
                  
                 <?php
                 if(isset($_POST['validacion'])){
                     $IngresoCC=$_POST['cc'];
                     $ingresoclave=$_POST['clave'];
                     
                     
                     
                     if($ingresoclave != $validacionClave){
                         //echo '<script language="javascript">confirm("Ingresando");
                          //window.location.href="admin-pagina-ingreso"</script>'; ?>
                            <script>
                                    window.onload=function(){
                                        alert("Ingresando");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" target="_blank" action="http://assvirt.com/plataforma/pages/examples/AdminPageInicio" method="POST" onsubmit="procesar(this.action);" >
                               
                            </form>
                     
                     <?php    
                     }else{
                         echo '<script language="javascript">alert("No tiene permisos de ingreso"); </script>';
                     }
                 }
                 ?> 
            
                  
                </div>
                <!-- /.login-card-body -->
              </div>
            </div>
            <!-- /.login-box -->
            
           
            
            </body>
        </center>
      
      
      
      
      
       
       
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
</body>
</html>



<?php
}
?>