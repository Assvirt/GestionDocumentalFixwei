<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- pace-progress -->
  <link rel="stylesheet" href="../../plugins/pace-progress/themes/black/pace-theme-flat-top.css">
  <!-- adminlte-->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini pace-primary">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->

  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index3.html" class="brand-link">
      <img src="../../dist/img/AdminLTELogo.png"
           alt="AdminLTE Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../../index.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v1</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../../index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v2</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../../index3.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v3</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="../widgets.html" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Widgets
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Layout Options
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../layout/top-nav.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Top Navigation</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../layout/boxed.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Boxed</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../layout/fixed-sidebar.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Fixed Sidebar</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../layout/fixed-topnav.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Fixed Navbar</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../layout/fixed-footer.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Fixed Footer</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../layout/collapsed-sidebar.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Collapsed Sidebar</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Charts
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../charts/chartjs.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>ChartJS</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../charts/flot.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Flot</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../charts/inline.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inline</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tree"></i>
              <p>
                UI Elements
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../UI/general.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>General</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../UI/icons.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Icons</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../UI/buttons.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Buttons</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../UI/sliders.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sliders</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../UI/modals.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Modals & Alerts</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../UI/navbar.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Navbar & Tabs</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../UI/timeline.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Timeline</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../UI/ribbons.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Ribbons</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Forms
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../forms/general.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>General Elements</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../forms/advanced.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Advanced Elements</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../forms/editors.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Editors</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Tables
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../tables/simple.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Simple Tables</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../tables/data.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>DataTables</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../tables/jsgrid.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>jsGrid</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-header">EXAMPLES</li>
          <li class="nav-item">
            <a href="../calendar.html" class="nav-link">
              <i class="nav-icon far fa-calendar-alt"></i>
              <p>
                Calendar
                <span class="badge badge-info right">2</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../gallery.html" class="nav-link">
              <i class="nav-icon far fa-image"></i>
              <p>
                Gallery
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-envelope"></i>
              <p>
                Mailbox
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../mailbox/mailbox.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inbox</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../mailbox/compose.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Compose</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../mailbox/read-mail.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Read</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Pages
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../examples/invoice.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Invoice</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../examples/profile.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Profile</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../examples/e_commerce.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>E-commerce</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../examples/projects.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Projects</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../examples/project_add.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Project Add</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../examples/project_edit.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Project Edit</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../examples/project_detail.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Project Detail</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../examples/contacts.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Contacts</p>
                </a>
              </li>
            </ul>
          </li>
          <!-- pagina -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                P&aacute;ginas
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="AdminPageInicio" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inicio</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="AdminPageAbout" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Acerca de</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="AdminPageServices" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Servicios</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="AdminPageInfo" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Contacto</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="AdminPageFooter" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Footer</p>
                </a>
              </li>
            </ul>
          </li>
          <!-- End pagina -->
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon far fa-plus-square"></i>
              <p>
                Extras
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../examples/login.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Login</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../examples/register.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Register</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="..examples/forgot-password.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Forgot Password</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="..examples/recover-password.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Recover Password</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../examples/lockscreen.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Lockscreen</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../examples/legacy-user-menu.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Legacy User Menu</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../examples/language-menu.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Language Menu</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../examples/404.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Error 404</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../examples/500.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Error 500</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../examples/pace.html" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pace</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../examples/blank.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Blank Page</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../../starter.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Starter Page</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-header">MISCELLANEOUS</li>
          <li class="nav-item">
            <a href="https://adminlte.io/docs/3.0" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>Documentation</p>
            </a>
          </li>
          <li class="nav-header">MULTI LEVEL EXAMPLE</li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-circle nav-icon"></i>
              <p>Level 1</p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-circle"></i>
              <p>
                Level 1
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Level 2</p>
                </a>
              </li>
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Level 2
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Level 3</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Level 3</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Level 3</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Level 2</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-circle nav-icon"></i>
              <p>Level 1</p>
            </a>
          </li>
          <li class="nav-header">LABELS</li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-circle text-danger"></i>
              <p class="text">Important</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-circle text-warning"></i>
              <p>Warning</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-circle text-info"></i>
              <p>Informational</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Administraci&oacute;n</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Administraci&oacute;n</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">


<!-- colocamos una ventana para solicitar lo que necesitamos ver ------------------------------ -->
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Link de la p&aacute;gina</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        
        <div class="card-body"> <!-- Encabezado titulos y color -->
        
          Procedemos a elegir lo que vamos a modificar sobre el Inicio<br><br>
         
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"> </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-condensed">
                            <thead>
                                <tr>
                               
                                <th>Encabezado</th>
                                <th>Imagen y logo del encabezado</th>
                                <th>descripci&oacute;n de producto o empresa</th>
                                <th>Portafolio</th>
                                <th>Comentarios</th>
                                <th>Servicios</th>
                                
                                
                                </tr>
                            </thead>
                            <tbody>
                             
                                    
                                <tr>
                                 
                                <td>
                                    <center>
                                        <form method="POST" action="AdminPageInicio">
                                         <input type="submit" style="background:green;color:white;border-radius:10px;font-size:18px;" value="Desplegar" name="encabezado">
                                        </form>
                                    </center>
                                </td>
                                <td> 
                                    <center>
                                        <form method="POST" action="AdminPageInicio">
                                         <input type="submit" style="background:green;color:white;border-radius:10px;font-size:18px;"  value="Desplegar" name="logoEncabezado">
                                        </form>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <form method="POST" action="AdminPageInicio"> 
                                         <input type="submit" style="background:green;color:white;border-radius:10px;font-size:18px;"  value="Desplegar" name="descripcion">
                                        </form>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <form method="POST" action="AdminPageInicio"> 
                                         <input type="submit" style="background:green;color:white;border-radius:10px;font-size:18px;"  value="Desplegar" name="portafolio">
                                        </form>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <form method="POST" action="AdminPageInicio"> 
                                         <input type="submit" style="background:green;color:white;border-radius:10px;font-size:18px;"  value="Desplegar" name="comentarios">
                                        </form>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <form method="POST" action="AdminPageInicio"> 
                                         <input type="submit" style="background:green;color:white;border-radius:10px;font-size:18px;"  value="Desplegar" name="servicios">
                                        </form>
                                    </center>
                                </td>
                                </tr>
                               
                               
                                
                            </tbody>
                            </table>
                           
                        </div>
                        <!-- /.card-body -->
                    </div>
                     
                        <!-- /.card -->
        </div> <!-- End Encabezado titulos y color -->
        <!-- /.card-body -->
        <div class="card-footer">
          ADMIN
        </div>
        <!-- /.card-footer-->
      </div>
<!-- End colocamos una ventana para solicitar lo que necesitamos ver ------------------------------ -->




<?php
            /// conexion a la BD
            require_once '../conexion/bd.php'; 
            /// End conexion a la BD -->
?>



<!-- colocamos una ventana para solicitar lo que necesitamos ver ------------------------------ -->
<?php
if(isset($_POST['encabezado'])){
    $onE=1;
        if($onE = 1){
?>
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Encabezado</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <?php 
        
        
        
            
            /// consulta de la tabla
            $resultado = $mysqli->query("SELECT * FROM inicio");
            /// End consulta de la tabla
        ?>
        <div class="card-body"> <!-- Encabezado titulos y color -->
        
          Procedemos a realizar los cambios de imagén del encabezado, titulos y colores!<br><br>
         
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">T&iacute;tulos del encabezado</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-condensed">
                            <thead>
                                <tr>
                               
                                <th>T&iacute;tulo 1</th>
                                <th>T&iacute;tulo 2</th>
                                <th>T&iacute;tulo 3</th>
                                <th>T&iacute;tulo 4</th>
                                <th>T&iacute;tulo 5</th>
                                <th>T&iacute;tulo 6</th>
                                <th>Color</th>
                                
                                </tr>
                            </thead>
                            <tbody>
                              <form action="../controlador/Inicio/controladorAdminPage.php" method="POST">
                                    <!-- empieza el while para imprimir los datos de la consulta -->
                                    <?php while($row = $resultado->fetch_assoc()) {  ?>
                                <tr>
                                  <select name="idEncabezado" style="visibility:hidden;"><option value="<?php echo $row['id']; ?>"></option></select>
                                <td> 
                                  <input type="text" name="tituloMenu1" value="<?php echo $row['tituloMenu1']; ?>" class="form-control" id="inputSuccess" placeholder="T&iacute;tulo ...">
                                </td>
                                <td> 
                                  <input type="text" name="tituloMenu2" value="<?php echo $row['tituloMenu2']; ?>" class="form-control" id="inputSuccess" placeholder="T&iacute;tulo ...">
                                </td>
                                <td> 
                                  <input type="text" name="tituloMenu3" value="<?php echo $row['tituloMenu3']; ?>" class="form-control" id="inputSuccess" placeholder="T&iacute;tulo ...">
                                </td>
                                <td> 
                                  <input type="text" name="tituloMenu4" value="<?php echo $row['tituloMenu4']; ?>" class="form-control" id="inputSuccess" placeholder="T&iacute;tulo ...">
                                </td>
                                <td> 
                                  <input type="text" name="tituloMenu5" value="<?php echo $row['tituloMenu5']; ?>" class="form-control" id="inputSuccess" placeholder="T&iacute;tulo ...">
                                </td>
                                <td> 
                                  <input type="text" name="tituloMenu6" value="<?php echo $row['tituloMenu6']; ?>" class="form-control" id="inputSuccess" placeholder="T&iacute;tulo ...">
                                </td>
                                <td> 
                                  <input type="text" name="colorTituloMenu" value="<?php echo $row['colorTituloMenu']; ?>" class="form-control" id="inputSuccess" placeholder="Color ...">
                                </td>
                                <td>
                                  <input type="submit" style="background:green;color:white;border-radius:10px;" class="form-control" value="Guardar" name="encabezado">
                                </td>
                                </tr>
                               
                                <?php } ?> <!-- cierre del while -->
                                
                              </form> 
                               
                                  
                                   <!-- End el while para imprimir los datos de la consulta -->
                            </tbody>
                            </table>
                           
                        </div>
                        <!-- /.card-body -->
                    </div>
                     
                        <!-- /.card -->
        </div> <!-- End Encabezado titulos y color -->
        <!-- /.card-body -->
        <div class="card-footer">
          ADMIN
        </div>
        <!-- /.card-footer-->
      </div>
     <?php }else{ echo 'oculto'; } } ?>
<!-- End colocamos una condición para mantener oculta la ventana -->
      <!-- ----------------------------------------------------------------------------1 división------------------------------------ --> 

<!-- colocamos una ventana para solicitar lo que necesitamos ver ------------------------------ -->
<?php
if(isset($_POST['logoEncabezado'])){
    $onLe=1;
        if($onLe = 1){
?>
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Imag&eacute;n encabezado y logo</h3>

          <div class="card-tools">
            <button  type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <?php
            $resultado = $mysqli->query("SELECT * FROM inicio"); 
            while($row = $resultado->fetch_assoc()) {
        ?>
        <div class="card-body"> <!-- Encabezado titulos y color -->
          Procedemos a realizar cambios en el logo y la imag&eacute;n del encabezado!<br><br>
          <form action="../controlador/Inicio/controladorAdminPage.php" method="POST" enctype="multipart/form-data">
          <select name="idEncabezado" style="visibility:hidden;"><option value="<?php echo $row['id']; ?>"></option></select>
            <div class="card-body">
            <div class="row">
            
              <div class="col-12 col-sm-6">
                <div class="col-12">Encabezado <input type="file" name="encabezado" class="form-control">
                  <img src="data:image/jpg;base64,   <?php echo base64_encode($row['ImgEncabezado']); ?>  " class="product-image" alt="Product Image">

                </div>
              </div>

              <div class="col-12 col-sm-6">Logo <input type="file" name="logo" class="form-control">
                <img src="data:image/jpg;base64,   <?php echo base64_encode($row['logo']); ?>  " class="product-image" alt="Product Image">
                
              </div>
            </div>


                                  <label for="">T&iacute;tulo del Encabezado</label>
                                  <input type="text" name="tituloEncabe" value="<?php echo $row['tituloEncabezado']; ?>" class="form-control" id="inputSuccess" placeholder="titulo Encabezado ...">
                                  <br>
                                  <label for="">Color t&iacute;tulo del Encabezado</label>
                                  <input type="text" name="colorTituloEncabezado" value="<?php echo $row['colorTituloEncabezado']; ?>" class="form-control" id="inputSuccess" placeholder="color Encabezado ...">
                                  <br>
                                  <input type="submit" style="background:green;color:white;border-radius:10px;" class="form-control" value="Guardar" name="ImgEncabezado">
                                
            <?php } ?> <!-- cierre del while -->
          </form>
        </div>
        <!-- /.card-body -->
        </div> <!-- End Encabezado titulos y color -->
        <!-- /.card-body -->
        <div class="card-footer">
          ADMIN
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->
        <?php }else{ echo 'oculto'; } } ?>
<!-- End colocamos una condición para mantener oculta la ventana -->
<!-- ----------------------------------------------------------------------------2 división------------------------------------ -->

<!-- colocamos una ventana para solicitar lo que necesitamos ver ------------------------------ -->
<?php
if(isset($_POST['descripcion'])){
    $onE=1;
        if($onE = 1){
?>
          <div class="card">
              <div class="card-header">
                <h3 class="card-title">Descripci&oacute;n de producto o empresa</h3>

                <div class="card-tools">
                  <button  type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fas fa-times"></i></button>
                </div>
              </div>
              <?php
                  $resultado = $mysqli->query("SELECT * FROM inicio"); 
                  while($row = $resultado->fetch_assoc()) {
              ?>
              <div class="card-body"> <!-- Encabezado titulos y color -->
                Procedemos a completar informaci&oacute;n de la empresa o alg&uacute;n producto que maneje<br><br>
                <form action="../controlador/Inicio/controladorAdminPage.php" method="POST" enctype="multipart/form-data">
                <select name="idEncabezado" style="visibility:hidden;"><option value="<?php echo $row['id']; ?>"></option></select>
                  <div class="card-body">
                    <center>
                        T&iacute;tulo principal
                        <input type="text" value="<?php echo $row['tituloPrincipal']; ?>" name="encabezadoP" class="form-control" placeholder="Titulo ...">
                      </center>
                  <div class="row">
                    <div class="col-12 col-sm-6">
                      <div class="col-12">T&iacute;tulo 
                        <input type="text" value="<?php echo $row['subtitulo1']; ?>" name="encabezado1" class="form-control" placeholder="Titulo ...">
                        <br>
                        Descripci&oacute;n
                        <textarea type="text" name="descripcion1" class="form-control" placeholder="Descripicion ..."><?php echo $row['descripcion1']; ?></textarea>
                      </div>
                    </div>

                    <div class="col-12 col-sm-6">Titulo 
                      <input type="text" value="<?php echo $row['subtitulo2']; ?>" name="encabezado2" class="form-control" placeholder="Titulo ...">
                      <br>
                      Descripci&oacute;n
                      <textarea type="text" name="descripcion2" class="form-control" placeholder="Descripcion ..."><?php echo $row['descripcion2']; ?></textarea>
                    </div>
                  </div>

                  <br>
                    Imagen
                    <input type="file" name="imagen" class="form-control"><br>
                    <img src="data:image/jpg;base64,   <?php echo base64_encode($row['imagen']); ?>  " width="25%" height="25%">                    
                    <input type="submit" style="background:green;color:white;border-radius:10px;" class="form-control" value="Guardar" name="subtituloOne">
                                      
                  <?php } ?> <!-- cierre del while -->
                </form>
              </div>
              <!-- /.card-body -->
              </div> <!-- End Encabezado titulos y color -->
              <!-- /.card-body -->
              <div class="card-footer">
                ADMIN
              </div>
              <!-- /.card-footer-->
          </div>
            <!-- /.card -->
              <?php }else{ echo 'oculto'; } } ?>
<!-- End colocamos una condición para mantener oculta la ventana -->
<!-- ----------------------------------------------------------------------------3 división------------------------------------ -->

<!-- colocamos una ventana para solicitar lo que necesitamos ver ------------------------------ -->
<?php
if(isset($_POST['portafolio'])){
    $onE=1;
        if($onE = 1){
?>
<div class="card">
              <div class="card-header">
                <h3 class="card-title">Portafolio</h3>

                <div class="card-tools">
                  <button  type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fas fa-times"></i></button>
                </div>
              </div>
              <?php
                  $resultado = $mysqli->query("SELECT * FROM inicioPortafolio where posicionPortafolio='0' "); 
                  while($row = $resultado->fetch_assoc()) {
              ?>
              <div class="card-body"> <!-- Encabezado titulos y color -->
                Procedemos a subir las imagenes que el cliente maneje y una breve descripci&oacute;n<br><br>
                <form action="../controlador/Inicio/controladorAdminPortafolio.php" method="POST" enctype="multipart/form-data">
                <select name="idEncabezado" style="visibility:hidden;"><option value="<?php echo $row['id']; ?>"></option></select>
                  <div class="card-body">
                    <center>
                        T&iacute;tulo principal
                        <input type="text" value="<?php echo $row['encabezadoPortafolio']; ?>" name="encabezadoPortafolio" class="form-control" placeholder="Titulo ...">
                        <br>
                      </center>
                      <?php } ?>
                      <input type="submit" style="background:green;color:white;border-radius:10px;" class="form-control" value="Guardar" name="portafolio">
                </form>
                <br><br>
                  <div class="row">
                    <div class="col-12 col-sm-6">
                      <div class="col-12">
                           
                          <table border="1">
                            <thead>
                              <tr>
                                <th>Descripci&oacute;n</th><th>Imagen</th>
                                <th>Acci&oacute;n</th>  
                              </tr>
                            </thead>
                            
                            
                            <tbody>
                                <?php
                                $resultado = $mysqli->query("SELECT * FROM inicioPortafolio where posicionPortafolio='1' ");
                                while($row = $resultado->fetch_assoc()) { 
                                ?>
                            <form action="../controlador/Inicio/controladorAdminPortafolio.php" method="POST" enctype="multipart/form-data">
                            <select name="idEncabezado" style="visibility:hidden;"><option value="<?php echo $row['id']; ?>"></option></select>
                              <tr>
                                <td width="50%">
                                    <input type="text" value="<?php echo $row['descripcionP']; ?>" name="descripcionP"  class="form-control" id="inputSuccess" placeholder="descripcion ...">
                                </td>
                                <td>
                                    <img src="data:image/jpg;base64,   <?php echo base64_encode($row['imagenP']); ?>  " width="100%" height="100px">
                                    <input type="file" name="imagenP" class="form-control">
                                </td>
                                <td>
                                    <button  type="submit" style="background:green;color:white;border-radius:10px;" class="form-control" value="Guardar" name="portafolio2">Guardar</button>
                                </td>
                              </tr>
                              <?php } ?> <!-- cierre del while -->
                             </form>
                            </tbody>
                            <tbody>
                                <?php
                                $resultado = $mysqli->query("SELECT * FROM inicioPortafolio where posicionPortafolio='3' ");
                                while($row = $resultado->fetch_assoc()) { 
                                ?>
                            <form action="../controlador/Inicio/controladorAdminPortafolio.php" method="POST" enctype="multipart/form-data">
                            <select name="idEncabezado" style="visibility:hidden;"><option value="<?php echo $row['id']; ?>"></option></select>
                              <tr>
                                <td width="50%">
                                    <input type="text" value="<?php echo $row['descripcionP']; ?>" name="descripcionP"  class="form-control" id="inputSuccess" placeholder="descripcion ...">
                                </td>
                                <td>
                                    <img src="data:image/jpg;base64,   <?php echo base64_encode($row['imagenP']); ?>  " width="100%" height="100px">
                                    <input type="file" name="imagenP" class="form-control">
                                </td>
                                <td>
                                    <button  type="submit" style="background:green;color:white;border-radius:10px;" class="form-control" value="Guardar" name="portafolio2">Guardar</button>
                                </td>
                              </tr>
                              <?php } ?> <!-- cierre del while -->
                             </form>
                            </tbody>
                             <tbody>
                                <?php
                                $resultado = $mysqli->query("SELECT * FROM inicioPortafolio where posicionPortafolio='5' ");
                                while($row = $resultado->fetch_assoc()) { 
                                ?>
                            <form action="../controlador/Inicio/controladorAdminPortafolio.php" method="POST" enctype="multipart/form-data">
                            <select name="idEncabezado" style="visibility:hidden;"><option value="<?php echo $row['id']; ?>"></option></select>
                              <tr>
                                <td width="50%">
                                    <input type="text" value="<?php echo $row['descripcionP']; ?>" name="descripcionP"  class="form-control" id="inputSuccess" placeholder="descripcion ...">
                                </td>
                                <td>
                                    <img src="data:image/jpg;base64,   <?php echo base64_encode($row['imagenP']); ?>  " width="100%" height="100px">
                                    <input type="file" name="imagenP" class="form-control">
                                </td>
                                <td>
                                    <button  type="submit" style="background:green;color:white;border-radius:10px;" class="form-control" value="Guardar" name="portafolio2">Guardar</button>
                                </td>
                              </tr>
                              <?php } ?> <!-- cierre del while -->
                             </form>
                            </tbody>
                            <tbody>
                                <?php
                                $resultado = $mysqli->query("SELECT * FROM inicioPortafolio where posicionPortafolio='7' ");
                                while($row = $resultado->fetch_assoc()) { 
                                ?>
                            <form action="../controlador/Inicio/controladorAdminPortafolio.php" method="POST" enctype="multipart/form-data">
                            <select name="idEncabezado" style="visibility:hidden;"><option value="<?php echo $row['id']; ?>"></option></select>
                              <tr>
                                <td width="50%">
                                    <input type="text" value="<?php echo $row['descripcionP']; ?>" name="descripcionP"  class="form-control" id="inputSuccess" placeholder="descripcion ...">
                                </td>
                                <td>
                                    <img src="data:image/jpg;base64,   <?php echo base64_encode($row['imagenP']); ?>  " width="100%" height="100px">
                                    <input type="file" name="imagenP" class="form-control">
                                </td>
                                <td>
                                    <button  type="submit" style="background:green;color:white;border-radius:10px;" class="form-control" value="Guardar" name="portafolio2">Guardar</button>
                                </td>
                              </tr>
                              <?php } ?> <!-- cierre del while -->
                             </form>
                            </tbody>
                            
                          </table>
                         
                         
                        
                        
                      </div>
                    </div>
                    
                    
                    <div class="col-12 col-sm-6">
                         <table border="1">
                            <thead>
                              <tr>
                                <th>Descripci&oacute;n</th><th>Imagen</th>
                                <th>Acci&oacute;n</th>  
                              </tr>
                            </thead>
                            
                            
                            <tbody>
                                <?php
                                $resultado = $mysqli->query("SELECT * FROM inicioPortafolio where posicionPortafolio='2' ");
                                while($row = $resultado->fetch_assoc()) { 
                                ?>
                            <form action="../controlador/Inicio/controladorAdminPortafolio.php" method="POST" enctype="multipart/form-data">
                            <select name="idEncabezado" style="visibility:hidden;"><option value="<?php echo $row['id']; ?>"></option></select>
                              <tr>
                                <td width="50%">
                                    <input type="text" value="<?php echo $row['descripcionP']; ?>" name="descripcionP"  class="form-control" id="inputSuccess" placeholder="descripcion ...">
                                </td>
                                <td>
                                    <img src="data:image/jpg;base64,   <?php echo base64_encode($row['imagenP']); ?>  " width="100%" height="100px">
                                    <input type="file" name="imagenP" class="form-control">
                                </td>
                                <td>
                                    <button  type="submit" style="background:green;color:white;border-radius:10px;" class="form-control" value="Guardar" name="portafolio2">Guardar</button>
                                </td>
                              </tr>
                              <?php } ?> <!-- cierre del while -->
                             </form>
                            </tbody>
                            <tbody>
                                <?php
                                $resultado = $mysqli->query("SELECT * FROM inicioPortafolio where posicionPortafolio='4' ");
                                while($row = $resultado->fetch_assoc()) { 
                                ?>
                            <form action="../controlador/Inicio/controladorAdminPortafolio.php" method="POST" enctype="multipart/form-data">
                            <select name="idEncabezado" style="visibility:hidden;"><option value="<?php echo $row['id']; ?>"></option></select>
                              <tr>
                                <td width="50%">
                                    <input type="text" value="<?php echo $row['descripcionP']; ?>" name="descripcionP"  class="form-control" id="inputSuccess" placeholder="descripcion ...">
                                </td>
                                <td>
                                    <img src="data:image/jpg;base64,   <?php echo base64_encode($row['imagenP']); ?>  " width="100%" height="100px">
                                    <input type="file" name="imagenP" class="form-control">
                                </td>
                                <td>
                                    <button  type="submit" style="background:green;color:white;border-radius:10px;" class="form-control" value="Guardar" name="portafolio2">Guardar</button>
                                </td>
                              </tr>
                              <?php } ?> <!-- cierre del while -->
                             </form>
                            </tbody>
                            <tbody>
                                <?php
                                $resultado = $mysqli->query("SELECT * FROM inicioPortafolio where posicionPortafolio='6' ");
                                while($row = $resultado->fetch_assoc()) { 
                                ?>
                            <form action="../controlador/Inicio/controladorAdminPortafolio.php" method="POST" enctype="multipart/form-data">
                            <select name="idEncabezado" style="visibility:hidden;"><option value="<?php echo $row['id']; ?>"></option></select>
                              <tr>
                                <td width="50%">
                                    <input type="text" value="<?php echo $row['descripcionP']; ?>" name="descripcionP"  class="form-control" id="inputSuccess" placeholder="descripcion ...">
                                </td>
                                <td>
                                    <img src="data:image/jpg;base64,   <?php echo base64_encode($row['imagenP']); ?>  " width="100%" height="100px">
                                    <input type="file" name="imagenP" class="form-control">
                                </td>
                                <td>
                                    <button  type="submit" style="background:green;color:white;border-radius:10px;" class="form-control" value="Guardar" name="portafolio2">Guardar</button>
                                </td>
                              </tr>
                              <?php } ?> <!-- cierre del while -->
                             </form>
                            </tbody>
                            <tbody>
                                <?php
                                $resultado = $mysqli->query("SELECT * FROM inicioPortafolio where posicionPortafolio='8' ");
                                while($row = $resultado->fetch_assoc()) { 
                                ?>
                            <form action="../controlador/Inicio/controladorAdminPortafolio.php" method="POST" enctype="multipart/form-data">
                            <select name="idEncabezado" style="visibility:hidden;"><option value="<?php echo $row['id']; ?>"></option></select>
                              <tr>
                                <td width="50%">
                                    <input type="text" value="<?php echo $row['descripcionP']; ?>" name="descripcionP"  class="form-control" id="inputSuccess" placeholder="descripcion ...">
                                </td>
                                <td>
                                    <img src="data:image/jpg;base64,   <?php echo base64_encode($row['imagenP']); ?>  " width="100%" height="100px">
                                    <input type="file" name="imagenP" class="form-control">
                                </td>
                                <td>
                                    <button  type="submit" style="background:green;color:white;border-radius:10px;" class="form-control" value="Guardar" name="portafolio2">Guardar</button>
                                </td>
                              </tr>
                              <?php } ?> <!-- cierre del while -->
                             </form>
                            </tbody>
                          </table>
                    </div>

                    
                  </div>
                 
                
              </div>
              <!-- /.card-body -->
              </div> <!-- End Encabezado titulos y color -->
              <!-- /.card-body -->
              <div class="card-footer">
                ADMIN
              </div>
              <!-- /.card-footer-->
</div>
            <!-- /.card -->
            <?php }else{ echo 'oculto'; } } ?>
<!-- End colocamos una condición para mantener oculta la ventana -->
<!-- ----------------------------------------------------------------------------4 división------------------------------------ -->

<!-- colocamos una ventana para solicitar lo que necesitamos ver ------------------------------ -->
<?php
if(isset($_POST['comentarios'])){
    $onE=1;
        if($onE = 1){
?>
<div class="card">
              <div class="card-header">
                <h3 class="card-title">Comentarios</h3>

                <div class="card-tools">
                  <button  type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fas fa-times"></i></button>
                </div>
              </div>
              <?php
                  $resultado = $mysqli->query("SELECT * FROM inicioComentarios"); 
                  while($row = $resultado->fetch_assoc()) {
              ?>
              <div class="card-body"> <!-- Encabezado titulos y color -->
                Procedemos a subir las imagenes que el cliente maneje y una breve descripci&oacute;n<br><br>
                <form action="../controlador/Inicio/controladorAdminComentario.php" method="POST" enctype="multipart/form-data">
                <select name="idEncabezado" style="visibility:hidden;"><option value="<?php echo $row['id']; ?>"></option></select>
                  <div class="card-body">
                    <center>
                        T&iacute;tulo principal 
                        <input type="text" value="<?php echo $row['tituloComentario']; ?>" name="tituloComen" class="form-control" placeholder="Titulo ..." required>
                        <br>
                      </center>
                  <div class="row">
                    <div class="col-12 col-sm-6">
                      <div class="col-12">
                        <input type="file" name="imagenComentario1" class="form-control" > 
                        <input type="text" value="<?php echo $row['subtituloComentario1']; ?>" name="subtituloComentario1"  class="form-control" id="inputSuccess" placeholder="Subtitulo ..." required>
                        <input type="text" value="<?php echo $row['descripcionComentario1']; ?>" name="descripcionComentario1"  class="form-control" id="inputSuccess" placeholder="descripcion ..." required>
                        <img src="data:image/jpg;base64,   <?php echo base64_encode($row['imgComentario1']); ?>  " width="30%" height="100px"> 
                        
                      </div>
                    </div>

                    <div class="col-12 col-sm-6">
                      <div class="col-12"> 
                        <input type="file" name="imagenComentario2" class="form-control" > 
                        <input type="text" value="<?php echo $row['subtituloComentario2']; ?>" name="subtituloComentario2"  class="form-control" id="inputSuccess" placeholder="Subtitulo ..." required>
                        <input type="text" value="<?php echo $row['descripcionComentario2']; ?>" name="descripcionComentario2"  class="form-control" id="inputSuccess" placeholder="descripcion ..." required>
                        <img src="data:image/jpg;base64,   <?php echo base64_encode($row['imgComentario2']); ?>  " width="30%" height="100px">  
                        </div>
                    </div>
                    
                  </div>
                  <br><br>
                <input type="submit" style="background:green;color:white;border-radius:10px;" class="form-control" value="Guardar" name="comentario">
                   
                    
                                         
                    
                                      
                  <?php } ?> <!-- cierre del while -->
                </form>
              </div>
              <!-- /.card-body -->
              </div> <!-- End Encabezado titulos y color -->
              <!-- /.card-body -->
              <div class="card-footer">
                ADMIN
              </div>
              <!-- /.card-footer-->
</div>
<?php }else{ echo 'oculto'; } } ?>
<!-- End colocamos una condición para mantener oculta la ventana -->
<!-- ----------------------------------------------------------------------------3 división------------------------------------ -->

<!-- colocamos una ventana para solicitar lo que necesitamos ver ------------------------------ -->
<?php
if(isset($_POST['servicios'])){
    $onE=1;
        if($onE = 1){
?>
<div class="card">
              <div class="card-header">
                <h3 class="card-title">Servicios</h3>

                <div class="card-tools">
                  <button  type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fas fa-times"></i></button>
                </div>
              </div>
              <?php
                  $resultado = $mysqli->query("SELECT * FROM inicioServicios"); 
                  while($row = $resultado->fetch_assoc()) {
              ?>
              <div class="card-body"> <!-- Encabezado titulos y color -->
                Procedemos a llenar informaci&oacute;n sobre los servicios<br><br>
                <form action="../controlador/Inicio/controladorAdminServicio.php" method="POST" enctype="multipart/form-data">
                <select name="idEncabezado" style="visibility:hidden;"><option value="<?php echo $row['id']; ?>"></option></select>
                  <div class="card-body">
                    <center>
                        T&iacute;tulo principal servicios
                        <input type="text" value="<?php echo $row['tituloServicio']; ?>" name="tituloServ" class="form-control" placeholder="Titulo ..." required>
                        <br>
                      </center>
                  <div class="row">
                    <div class="col-12 col-sm-6">
                      <div class="col-12">
                        <input type="file" name="imagenServicio1" class="form-control"> 
                        <input type="text" value="<?php echo $row['subtituloServicio1']; ?>" name="subtituloServicio1"  class="form-control" id="inputSuccess" placeholder="Subtitulo ..." required>
                        <input type="text" value="<?php echo $row['descripcionServicio1']; ?>" name="descripcionServicio1"  class="form-control" id="inputSuccess" placeholder="descripcion ..." required>
                        <img src="data:image/jpg;base64,   <?php echo base64_encode($row['imgServicio1']); ?>  " width="30%" height="100px">
                        
                        <br><br>
                        
                        <input type="file" name="imagenServicio3" class="form-control"> 
                        <input type="text" value="<?php echo $row['subtituloServicio3']; ?>" name="subtituloServicio3"  class="form-control" id="inputSuccess" placeholder="Subtitulo ..." required>
                        <input type="text" value="<?php echo $row['descripcionServicio3']; ?>" name="descripcionServicio3"  class="form-control" id="inputSuccess" placeholder="descripcion ..." required>
                        <img src="data:image/jpg;base64,   <?php echo base64_encode($row['imgServicio3']); ?>  " width="30%" height="100px">
                        
                      </div>
                    </div>

                    <div class="col-12 col-sm-6">
                      <div class="col-12"> 
                        <input type="file" name="imagenServicio2" class="form-control"> 
                        <input type="text" value="<?php echo $row['subtituloServicio2']; ?>" name="subtituloServicio2"  class="form-control" id="inputSuccess" placeholder="Subtitulo ..." required>
                        <input type="text" value="<?php echo $row['descripcionServicio2']; ?>" name="descripcionServicio2"  class="form-control" id="inputSuccess" placeholder="descripcion ..." required>
                        <img src="data:image/jpg;base64,   <?php echo base64_encode($row['imgServicio2']); ?>  " width="30%" height="100px">  
                        </div>
                    </div>
                  </div>
                  
                   
                    
                                         
                    <input type="submit" style="background:green;color:white;border-radius:10px;" class="form-control" value="Guardar" name="servicio">
                                      
                  <?php } ?> <!-- cierre del while -->
                </form>
              </div>
              <!-- /.card-body -->
              </div> <!-- End Encabezado titulos y color -->
              <!-- /.card-body -->
              <div class="card-footer">
                ADMIN
              </div>
              <!-- /.card-footer-->
</div>
<?php }else{ echo 'oculto'; } } ?>
<!-- End colocamos una condición para mantener oculta la ventana -->




<!-- termina los DIV que guardan los label de cada parte de la página ---------------------  -->
          </section> 
          <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
          <div class="float-right d-none d-sm-block">
            <b>Version</b> 3.0.0
          </div>
          <strong>Copyright &copy; 2014-2019 <a href="">AdminLTE.io</a>.</strong> All rights
          reserved.
        </footer>

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
  <!-- pace-progress -->
<script src="../../plugins/pace-progress/pace.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
</body>
</html>
