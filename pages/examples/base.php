<?php
session_start();
if(!isset($_SESSION["session_username"])){
    header("login");
    echo '<script language="javascript">confirm("Sesi贸n Finalizada por Inactividad");
    window.location.href="login"</script>';
}else{
require_once 'inactividad.php';
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
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
            <h1>Simple Tables</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Simple Tables</li>
            </ol>
          </div>
        </div>
        <div>
            <div class="row">
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="#"><font color="white"><i class="fas fa-plus-square"></i> Agregar</font></a></button>
            </div>
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="#"><font color="white"><i class="fas fa-user-plus"></i> Agregar Cargo</font></a></button>
            </div>
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-warning btn-sm"><a href="#"><font color="white"><i class="fas fa-download"></i> Exportar</font></a></button>
            </div>
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="#"><font color="white"><i class="fas fa-cloud-download-alt"></i> Descargar Plantilla</font></a></button>
            </div>

            <div class="col-sm">
                <form>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Importar archivo</label>
                        
                    </div>
                </form>
            </div>
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a class="" href="#"><font color="white"><i class="fas fa-file-upload"></i> Importar</font></a></button>
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
                <h3 class="card-title">Fixed Header Table</h3>
                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 800px;">
                <table class="table table-head-fixed text-center">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>User</th>
                      <th>Date</th>
                      <th>Status</th>
                      <th>Reason</th>
                      <th>Ver mas</th>
                      <th>Editar</th>
                      <th>Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>
                    <form method='POST' action="">
                        <tr>
                          <td>183</td>
                          <td>John Doe</td>
                          <td>11-7-2014</td>
                          <td><span class="tag tag-success">Approved</span></td>
                          <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                          <td><button type="button" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i> Ver más</button></a></td>
                          <td><button type="button" class="btn btn-block btn-success btn-sm"><i class="fas fa-edit"></i> Editar</button></td>
                          <td><button type="button" class="btn btn-block btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button></td>
                        </tr>
                    </form>
                    <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td>11-7-2014</td>
                      <td><span class="tag tag-success">Approved</span></td>
                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                      <td><button type="button" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i> Ver más</button></td>
                      <td><button type="button" class="btn btn-block btn-success btn-sm"><i class="fas fa-edit"></i> Editar</button></td>
                      <td><button type="button" class="btn btn-block btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button></td>
                    </tr>
                    <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td>11-7-2014</td>
                      <td><span class="tag tag-success">Approved</span></td>
                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                      <td><button type="button" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i> Ver más</button></td>
                      <td><button type="button" class="btn btn-block btn-success btn-sm"><i class="fas fa-edit"></i> Editar</button></td>
                      <td><button type="button" class="btn btn-block btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button></td>
                    </tr>
                    <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td>11-7-2014</td>
                      <td><span class="tag tag-success">Approved</span></td>
                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                      <td><button type="button" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i> Ver más</button></td>
                      <td><button type="button" class="btn btn-block btn-success btn-sm"><i class="fas fa-edit"></i> Editar</button></td>
                      <td><button type="button" class="btn btn-block btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button></td>
                    </tr>
                    <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td>11-7-2014</td>
                      <td><span class="tag tag-success">Approved</span></td>
                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                      <td><button type="button" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i> Ver más</button></td>
                      <td><button type="button" class="btn btn-block btn-success btn-sm"><i class="fas fa-edit"></i> Editar</button></td>
                      <td><button type="button" class="btn btn-block btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button></td>
                    </tr>
                    <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td>11-7-2014</td>
                      <td><span class="tag tag-success">Approved</span></td>
                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                      <td><button type="button" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i> Ver más</button></td>
                      <td><button type="button" class="btn btn-block btn-success btn-sm"><i class="fas fa-edit"></i> Editar</button></td>
                      <td><button type="button" class="btn btn-block btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button></td>
                    </tr>
                    <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td>11-7-2014</td>
                      <td><span class="tag tag-success">Approved</span></td>
                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                      <td><button type="button" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i> Ver más</button></td>
                      <td><button type="button" class="btn btn-block btn-success btn-sm"><i class="fas fa-edit"></i> Editar</button></td>
                      <td><button type="button" class="btn btn-block btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button></td>
                    </tr>
                    <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td>11-7-2014</td>
                      <td><span class="tag tag-success">Approved</span></td>
                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                      <td><button type="button" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i> Ver más</button></td>
                      <td><button type="button" class="btn btn-block btn-success btn-sm"><i class="fas fa-edit"></i> Editar</button></td>
                      <td><button type="button" class="btn btn-block btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button></td>
                    </tr>
                    <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td>11-7-2014</td>
                      <td><span class="tag tag-success">Approved</span></td>
                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                      <td><button type="button" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i> Ver más</button></td>
                      <td><button type="button" class="btn btn-block btn-success btn-sm"><i class="fas fa-edit"></i> Editar</button></td>
                      <td><button type="button" class="btn btn-block btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button></td>
                    </tr>
                    <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td>11-7-2014</td>
                      <td><span class="tag tag-success">Approved</span></td>
                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                      <td><button type="button" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i> Ver más</button></td>
                      <td><button type="button" class="btn btn-block btn-success btn-sm"><i class="fas fa-edit"></i> Editar</button></td>
                      <td><button type="button" class="btn btn-block btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button></td>
                    </tr>
                    <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td>11-7-2014</td>
                      <td><span class="tag tag-success">Approved</span></td>
                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                      <td><button type="button" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i> Ver más</button></td>
                      <td><button type="button" class="btn btn-block btn-success btn-sm"><i class="fas fa-edit"></i> Editar</button></td>
                      <td><button type="button" class="btn btn-block btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button></td>
                    </tr>
                    <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td>11-7-2014</td>
                      <td><span class="tag tag-success">Approved</span></td>
                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                      <td><button type="button" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i> Ver más</button></td>
                      <td><button type="button" class="btn btn-block btn-success btn-sm"><i class="fas fa-edit"></i> Editar</button></td>
                      <td><button type="button" class="btn btn-block btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button></td>
                    </tr>
                    <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td>11-7-2014</td>
                      <td><span class="tag tag-success">Approved</span></td>
                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                      <td><button type="button" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i> Ver más</button></td>
                      <td><button type="button" class="btn btn-block btn-success btn-sm"><i class="fas fa-edit"></i> Editar</button></td>
                      <td><button type="button" class="btn btn-block btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button></td>
                    </tr>
                    <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td>11-7-2014</td>
                      <td><span class="tag tag-success">Approved</span></td>
                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                      <td><button type="button" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i> Ver más</button></td>
                      <td><button type="button" class="btn btn-block btn-success btn-sm"><i class="fas fa-edit"></i> Editar</button></td>
                      <td><button type="button" class="btn btn-block btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button></td>
                    </tr>
                    <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td>11-7-2014</td>
                      <td><span class="tag tag-success">Approved</span></td>
                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                      <td><button type="button" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i> Ver más</button></td>
                      <td><button type="button" class="btn btn-block btn-success btn-sm"><i class="fas fa-edit"></i> Editar</button></td>
                      <td><button type="button" class="btn btn-block btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button></td>
                    </tr>
                    <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td>11-7-2014</td>
                      <td><span class="tag tag-success">Approved</span></td>
                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                      <td><button type="button" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i> Ver más</button></td>
                      <td><button type="button" class="btn btn-block btn-success btn-sm"><i class="fas fa-edit"></i> Editar</button></td>
                      <td><button type="button" class="btn btn-block btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button></td>
                    </tr>
                    <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td>11-7-2014</td>
                      <td><span class="tag tag-success">Approved</span></td>
                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                      <td><button type="button" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i> Ver más</button></td>
                      <td><button type="button" class="btn btn-block btn-success btn-sm"><i class="fas fa-edit"></i> Editar</button></td>
                      <td><button type="button" class="btn btn-block btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button></td>
                    </tr>
                    <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td>11-7-2014</td>
                      <td><span class="tag tag-success">Approved</span></td>
                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                      <td><button type="button" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i> Ver más</button></td>
                      <td><button type="button" class="btn btn-block btn-success btn-sm"><i class="fas fa-edit"></i> Editar</button></td>
                      <td><button type="button" class="btn btn-block btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button></td>
                    </tr>
                    <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td>11-7-2014</td>
                      <td><span class="tag tag-success">Approved</span></td>
                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                      <td><button type="button" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i> Ver más</button></td>
                      <td><button type="button" class="btn btn-block btn-success btn-sm"><i class="fas fa-edit"></i> Editar</button></td>
                      <td><button type="button" class="btn btn-block btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button></td>
                    </tr>
                    <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td>11-7-2014</td>
                      <td><span class="tag tag-success">Approved</span></td>
                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                      <td><button type="button" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i> Ver más</button></td>
                      <td><button type="button" class="btn btn-block btn-success btn-sm"><i class="fas fa-edit"></i> Editar</button></td>
                      <td><button type="button" class="btn btn-block btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button></td>
                    </tr>
                    <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td>11-7-2014</td>
                      <td><span class="tag tag-success">Approved</span></td>
                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                      <td><button type="button" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i> Ver más</button></td>
                      <td><button type="button" class="btn btn-block btn-success btn-sm"><i class="fas fa-edit"></i> Editar</button></td>
                      <td><button type="button" class="btn btn-block btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button></td>
                    </tr>
                    <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td>11-7-2014</td>
                      <td><span class="tag tag-success">Approved</span></td>
                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                      <td><button type="button" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i> Ver más</button></td>
                      <td><button type="button" class="btn btn-block btn-success btn-sm"><i class="fas fa-edit"></i> Editar</button></td>
                      <td><button type="button" class="btn btn-block btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button></td>
                    </tr>
                    <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td>11-7-2014</td>
                      <td><span class="tag tag-success">Approved</span></td>
                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                      <td><button type="button" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i> Ver más</button></td>
                      <td><button type="button" class="btn btn-block btn-success btn-sm"><i class="fas fa-edit"></i> Editar</button></td>
                      <td><button type="button" class="btn btn-block btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button></td>
                    </tr>
                    <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td>11-7-2014</td>
                      <td><span class="tag tag-success">Approved</span></td>
                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                      <td><button type="button" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i> Ver más</button></td>
                      <td><button type="button" class="btn btn-block btn-success btn-sm"><i class="fas fa-edit"></i> Editar</button></td>
                      <td><button type="button" class="btn btn-block btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button></td>
                    </tr>
                    <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td>11-7-2014</td>
                      <td><span class="tag tag-success">Approved</span></td>
                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                      <td><button type="button" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i> Ver más</button></td>
                      <td><button type="button" class="btn btn-block btn-success btn-sm"><i class="fas fa-edit"></i> Editar</button></td>
                      <td><button type="button" class="btn btn-block btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button></td>
                    </tr>
                    <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td>11-7-2014</td>
                      <td><span class="tag tag-success">Approved</span></td>
                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                      <td><button type="button" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i> Ver más</button></td>
                      <td><button type="button" class="btn btn-block btn-success btn-sm"><i class="fas fa-edit"></i> Editar</button></td>
                      <td><button type="button" class="btn btn-block btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button></td>
                    </tr>
                    <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td>11-7-2014</td>
                      <td><span class="tag tag-success">Approved</span></td>
                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                      <td><button type="button" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i> Ver más</button></td>
                      <td><button type="button" class="btn btn-block btn-success btn-sm"><i class="fas fa-edit"></i> Editar</button></td>
                      <td><button type="button" class="btn btn-block btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button></td>
                    </tr>
                    <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td>11-7-2014</td>
                      <td><span class="tag tag-success">Approved</span></td>
                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                      <td><button type="button" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i> Ver más</button></td>
                      <td><button type="button" class="btn btn-block btn-success btn-sm"><i class="fas fa-edit"></i> Editar</button></td>
                      <td><button type="button" class="btn btn-block btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button></td>
                    </tr>
                    
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
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
</body>
</html>
<?php
}
?>