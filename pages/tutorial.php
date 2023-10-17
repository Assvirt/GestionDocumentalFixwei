<?php
session_start();
error_reporting(E_ERROR);
if(!isset($_SESSION["session_username"])){
   require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
//////////////////////PERMISOS////////////////////////
require_once 'conexion/bd.php';
//////////////////////PERMISOS////////////////////////

?>
<!DOCTYPE html>
<html>
<head>
    <title>Tutoriales</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ekko Lightbox -->
  <link rel="stylesheet" href="../plugins/ekko-lightbox/ekko-lightbox.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

<?php echo require_once'menu.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tutoriales</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Tutoriales</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card card-primary">
              <div class="card-header">
                <div class="card-title">
                  Visualice el procedimiento de cada uno de los módulos
                </div>
              </div>
              <div class="card-body">
                  <!--
                <div>
                  <div class="btn-group w-100 mb-2">
                    <a class="btn btn-info active" href="javascript:void(0)" data-filter="all"></a>
                  </div>
                  <div class="mb-2">
                    <a class="btn btn-secondary" href="javascript:void(0)" data-shuffle> Barajar  </a>
                    <div class="float-right">
                      <select class="custom-select" style="width: auto;" data-sortOrder>
                        <option value="index"> Ordenar por posiciones </option>
                        <option value="sortData"> Ordenar por datos personalizados </option>
                      </select>
                      <div class="btn-group">
                        <a class="btn btn-default" href="javascript:void(0)" data-sortAsc> Ascendente </a>
                        <a class="btn btn-default" href="javascript:void(0)" data-sortDesc> Descendente </a>
                      </div>
                    </div>
                  </div>
                </div>
                <br><br>
                -->
                <div>
                  <div class="filter-container p-0 row">
                    <div class="filtr-item col-sm-2" data-category="1" data-sort="white sample">
                      <!--<a href="https://via.placeholder.com/1200/FFFFFF.png?text=1" data-toggle="lightbox" data-title="sample 1 - white">
                      <img src="https://via.placeholder.com/300/FFFFFF?text=1" class="img-fluid mb-2" alt="white sample"/>-->
                      <form action="" method="post">
                      <button type="submit" name="configuracion" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i> Configuración</button>
                      </form>
                    </div>
                    <div class="filtr-item col-sm-2" data-category="2" data-sort="black sample">
                      <!--<a href="https://via.placeholder.com/1200/000000.png?text=2" data-toggle="lightbox" data-title="sample 2 - black">
                        <img src="https://via.placeholder.com/300/000000?text=2" class="img-fluid mb-2" alt="black sample"/>-->
                          <form action="" method="post">
                        <button type="submit" name="gestionDocumental" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i> Gestión documental</button>
                    </div>
                    <div class="filtr-item col-sm-2" data-category="3" data-sort="red sample">
                      <!--<a href="https://via.placeholder.com/1200/FF0000/FFFFFF.png?text=3" data-toggle="lightbox" data-title="sample 3 - red">
                        <img src="https://via.placeholder.com/300/FF0000/FFFFFF?text=3" class="img-fluid mb-2" alt="red sample"/>-->
                        <form action="" method="post">
                        <button type="submit" name="repositorio" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i> Repositorio</button>
                    </div>
                    <div class="filtr-item col-sm-2" data-category="4" data-sort="red sample">
                      <!--<a href="https://via.placeholder.com/1200/FF0000/FFFFFF.png?text=4" data-toggle="lightbox" data-title="sample 4 - red">
                        <img src="https://via.placeholder.com/300/FF0000/FFFFFF?text=4" class="img-fluid mb-2" alt="red sample"/>-->
                        <button type="submit" name="inidicadores" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i> Indicadores</button>
                        <form action="" method="post">
                    </div>
                    <div class="filtr-item col-sm-2" data-category="5" data-sort="black sample">
                      <!--<a href="https://via.placeholder.com/1200/000000.png?text=5" data-toggle="lightbox" data-title="sample 5 - black">
                        <img src="https://via.placeholder.com/300/000000?text=5" class="img-fluid mb-2" alt="black sample"/>-->
                        <button type="submit" name="actas" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i> Actas</button>
                        <form action="" method="post">
                    </div>
                  <!--
                    <div class="filtr-item col-sm-2" data-category="6" data-sort="white sample">
                      <a href="https://via.placeholder.com/1200/FFFFFF.png?text=6" data-toggle="lightbox" data-title="sample 6 - white">
                        <img src="https://via.placeholder.com/300/FFFFFF?text=6" class="img-fluid mb-2" alt="white sample"/>
                      </a>
                    </div>
                    <div class="filtr-item col-sm-2" data-category="7" data-sort="white sample">
                      <a href="https://via.placeholder.com/1200/FFFFFF.png?text=7" data-toggle="lightbox" data-title="sample 7 - white">
                        <img src="https://via.placeholder.com/300/FFFFFF?text=7" class="img-fluid mb-2" alt="white sample"/>
                      </a>
                    </div>
                    <div class="filtr-item col-sm-2" data-category="8" data-sort="black sample">
                      <a href="https://via.placeholder.com/1200/000000.png?text=8" data-toggle="lightbox" data-title="sample 8 - black">
                        <img src="https://via.placeholder.com/300/000000?text=8" class="img-fluid mb-2" alt="black sample"/>
                      </a>
                    </div>
                    <div class="filtr-item col-sm-2" data-category="9" data-sort="red sample">
                      <a href="https://via.placeholder.com/1200/FF0000/FFFFFF.png?text=9" data-toggle="lightbox" data-title="sample 9 - red">
                        <img src="https://via.placeholder.com/300/FF0000/FFFFFF?text=9" class="img-fluid mb-2" alt="red sample"/>
                      </a>
                    </div>
                    <div class="filtr-item col-sm-2" data-category="10" data-sort="white sample">
                      <a href="https://via.placeholder.com/1200/FFFFFF.png?text=10" data-toggle="lightbox" data-title="sample 10 - white">
                        <img src="https://via.placeholder.com/300/FFFFFF?text=10" class="img-fluid mb-2" alt="white sample"/>
                      </a>
                    </div>
                    <div class="filtr-item col-sm-2" data-category="11" data-sort="white sample">
                      <a href="https://via.placeholder.com/1200/FFFFFF.png?text=11" data-toggle="lightbox" data-title="sample 11 - white">
                        <img src="https://via.placeholder.com/300/FFFFFF?text=11" class="img-fluid mb-2" alt="white sample"/>
                      </a>
                    </div>
                    <div class="filtr-item col-sm-2" data-category="12" data-sort="black sample">
                      <a href="https://via.placeholder.com/1200/000000.png?text=12" data-toggle="lightbox" data-title="sample 12 - black">
                        <img src="https://via.placeholder.com/300/000000?text=12" class="img-fluid mb-2" alt="black sample"/>
                      </a>
                    </div>
                  -->
                  </div>
                </div>

              </div>
            </div>
          </div>
        <?php
        if(isset($_POST['configuracion'])){
        ?>
          <div class="col-12">
            <div class="card card-primary">
              <div class="card-header">
                <div class="card-title">
                 Configuración
                 </div>
                 <button onclick="window.location.href='tutorial'" type="button" style="width:25px;" class="btn btn-block btn-danger btn-xs float-right"><a ><font color="white">x</a></button>
              </div>
              <div class="card-body">
                <div class="row">
                    
                <div class="col-sm-2">
                    <img src="tutoriales/video.poster.png" class="img-fluid mb-2" width=""  height=""  alt="black sample"/>
                    </button>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-xl">
                    Cargos
                    </button>
                    <div class="modal fade" id="modal-xl">
                      <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                          <div class="modal-header" style="background:#17a2b8;color:white;">
                            <h4 class="modal-title">Cargos</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body" style="background:#17a2b8;color:white;">
                          <center>
                            <video   controls poster="tutoriales/video.poster.png" width="90%">
                              <source src="tutoriales/1 - Cargos.mp4" type="video/mp4" >
                            </video>
                          </center>
                          </div>
                          <div class="modal-footer justify-content-between" style="background:#17a2b8;color:white;">
                            <button style="background:#17a2b8;color:white;" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                    
                  
                </div>    
                    
                <div class="col-sm-2">
                    <img src="tutoriales/video.poster.png" class="img-fluid mb-2" width=""  height=""  alt="black sample"/>
                    </button>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-xlProcesos">
                    Procesos
                    </button>
                    <div class="modal fade" id="modal-xlProcesos">
                      <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                          <div class="modal-header" style="background:#17a2b8;color:white;">
                            <h4 class="modal-title">Procesos</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body" style="background:#17a2b8;color:white;">
                          <center>
                            <video   controls poster="tutoriales/video.poster.png" width="90%">
                              <source src="tutoriales/2 - Procesos.mp4" type="video/mp4" >
                            </video>
                          </center>
                          </div>
                          <div class="modal-footer justify-content-between" style="background:#17a2b8;color:white;">
                            <button style="background:#17a2b8;color:white;" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                    
                  
                </div>    
                
                
                <div class="col-sm-2">
                    <img src="tutoriales/video.poster.png" class="img-fluid mb-2" width=""  height=""  alt="black sample"/>
                    </button>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-xlCT">
                    Centro de trabajo
                    </button>
                    <div class="modal fade" id="modal-xlCT">
                      <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                          <div class="modal-header" style="background:#17a2b8;color:white;">
                            <h4 class="modal-title">Centro de trabajo</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body" style="background:#17a2b8;color:white;">
                          <center>
                            <video   controls poster="tutoriales/video.poster.png" width="90%">
                              <source src="tutoriales/3 - Centro de trabajo.mp4" type="video/mp4" >
                            </video>
                          </center>
                          </div>
                          
                          <div class="modal-footer justify-content-between" style="background:#17a2b8;color:white;">
                            <button style="background:#17a2b8;color:white;" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                    
                  
                </div>
                
                
                <div class="col-sm-2">
                    <img src="tutoriales/video.poster.png" class="img-fluid mb-2" width=""  height=""  alt="black sample"/>
                    </button>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-xlGrupos">
                    Grupos de distribución
                    </button>
                    <div class="modal fade" id="modal-xlGrupos">
                      <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                          <div class="modal-header" style="background:#17a2b8;color:white;">
                            <h4 class="modal-title">Grupos de distribución</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body" style="background:#17a2b8;color:white;">
                          <center>
                            <video   controls poster="tutoriales/video.poster.png" width="90%">
                              <source src="tutoriales/4 - Grupos de distribución.mp4" type="video/mp4" >
                            </video>
                          </center>
                          </div>
                          <div class="modal-footer justify-content-between" style="background:#17a2b8;color:white;">
                            <button style="background:#17a2b8;color:white;" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                </div>
                
                    
                <div class="col-sm-2">
                    <img src="tutoriales/video.poster.png" class="img-fluid mb-2" width=""  height=""  alt="black sample"/>
                    </button>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-xlCTU">
                    Usuario
                    </button>
                    <div class="modal fade" id="modal-xlCTU">
                      <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                          <div class="modal-header" style="background:#17a2b8;color:white;">
                            <h4 class="modal-title">Usuarios</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body" style="background:#17a2b8;color:white;">
                          <center>
                            <video   controls poster="tutoriales/video.poster.png" width="90%">
                              <source src="tutoriales/5 - usuarios.mp4" type="video/mp4" >
                            </video>
                          </center>
                          </div>
                          
                          <div class="modal-footer justify-content-between" style="background:#17a2b8;color:white;">
                            <button style="background:#17a2b8;color:white;" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                  
                </div>
                  
                <div class="col-sm-2">
                    <img src="tutoriales/video.poster.png" class="img-fluid mb-2" width=""  height=""  alt="black sample"/>
                    </button>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-CENTROCOSTO">
                   Centro de costo
                    </button>
                    <div class="modal fade" id="modal-CENTROCOSTO">
                      <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                          <div class="modal-header" style="background:#17a2b8;color:white;">
                            <h4 class="modal-title">Centro de costo</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body" style="background:#17a2b8;color:white;">
                          <center>
                            <video   controls poster="tutoriales/video.poster.png" width="90%">
                              <source src="tutoriales/6 - Centro de costo.mp4" type="video/mp4" >
                            </video>
                          </center>
                          </div>
                          
                          <div class="modal-footer justify-content-between" style="background:#17a2b8;color:white;">
                            <button style="background:#17a2b8;color:white;" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                  
                </div>  
                
                
                  
                
                </div>
                
                <br><br>
                <div class="row">
                <br><br>
                
                <div class="col-sm-2">
                    <img src="tutoriales/video.poster.png" class="img-fluid mb-2" width=""  height=""  alt="black sample"/>
                    </button>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-TIPODocumento">
                   Tipo de documento
                    </button>
                    <div class="modal fade" id="modal-TIPODocumento">
                      <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                          <div class="modal-header" style="background:#17a2b8;color:white;">
                            <h4 class="modal-title">Tipo de documento</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body" style="background:#17a2b8;color:white;">
                          <center>
                            <video   controls poster="tutoriales/video.poster.png" width="90%">
                              <source src="tutoriales/7 - Tipo de documento.mp4" type="video/mp4" >
                            </video>
                          </center>
                          </div>
                          
                          <div class="modal-footer justify-content-between" style="background:#17a2b8;color:white;">
                            <button style="background:#17a2b8;color:white;" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                  
                </div>  
                
                <div class="col-sm-2">
                    <img src="tutoriales/video.poster.png" class="img-fluid mb-2" width=""  height=""  alt="black sample"/>
                    </button>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-COD">
                   Codificación
                    </button>
                    <div class="modal fade" id="modal-COD">
                      <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                          <div class="modal-header" style="background:#17a2b8;color:white;">
                            <h4 class="modal-title">Codificación</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body" style="background:#17a2b8;color:white;">
                          <center>
                            <video   controls poster="tutoriales/video.poster.png" width="90%">
                              <source src="tutoriales/8 - codificación.mp4" type="video/mp4" >
                            </video>
                          </center>
                          </div>
                          
                          <div class="modal-footer justify-content-between" style="background:#17a2b8;color:white;">
                            <button style="background:#17a2b8;color:white;" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                  
                </div>  
                
                
                <div class="col-sm-2">
                    <img src="tutoriales/video.poster.png" class="img-fluid mb-2" width=""  height=""  alt="black sample"/>
                    </button>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-DEF">
                   Definiciones
                    </button>
                    <div class="modal fade" id="modal-DEF">
                      <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                          <div class="modal-header" style="background:#17a2b8;color:white;">
                            <h4 class="modal-title">Definiciones</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body" style="background:#17a2b8;color:white;">
                          <center>
                            <video   controls poster="tutoriales/video.poster.png" width="90%">
                              <source src="tutoriales/9 - definición.mp4" type="video/mp4" >
                            </video>
                          </center>
                          </div>
                          
                          <div class="modal-footer justify-content-between" style="background:#17a2b8;color:white;">
                            <button style="background:#17a2b8;color:white;" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                </div> 
                  
                    
                  
                <div class="col-sm-2">
                    <img src="tutoriales/video.poster.png" class="img-fluid mb-2" width=""  height=""  alt="black sample"/>
                    </button>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-Normatividad">
                   Normatividad
                    </button>
                    <div class="modal fade" id="modal-Normatividad">
                      <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                          <div class="modal-header" style="background:#17a2b8;color:white;">
                            <h4 class="modal-title">Normatividad</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body" style="background:#17a2b8;color:white;">
                          <center>
                            <video   controls poster="tutoriales/video.poster.png" width="90%">
                              <source src="tutoriales/10 - normatividad.mp4" type="video/mp4" >
                            </video>
                          </center>
                          </div>
                          
                          <div class="modal-footer justify-content-between" style="background:#17a2b8;color:white;">
                            <button style="background:#17a2b8;color:white;" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                </div>   
                  
                    
                    
                <div class="col-sm-2">
                    <img src="tutoriales/video.poster.png" class="img-fluid mb-2" width=""  height=""  alt="black sample"/>
                    </button>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-Perfil">
                   Perfil de Usuario
                    </button>
                    <div class="modal fade" id="modal-Perfil">
                      <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                          <div class="modal-header" style="background:#17a2b8;color:white;">
                            <h4 class="modal-title">Perfil de Usuario</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body" style="background:#17a2b8;color:white;">
                          <center>
                            <video   controls poster="tutoriales/video.poster.png" width="90%">
                              <source src="tutoriales/Perfil.mp4" type="video/mp4" >
                            </video>
                          </center>
                          </div>
                          
                          <div class="modal-footer justify-content-between" style="background:#17a2b8;color:white;">
                            <button style="background:#17a2b8;color:white;" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                  
                  </div>    
                  
                   
                  
                    </div>
              </div>
            </div>
          </div> 
        <?php
        }
        if(isset($_POST['gestionDocumental'])){
        ?>
        <div class="col-12">
            <div class="card card-primary">
              <div class="card-header">
                <div class="card-title">
                 Gestión documental
                 </div>
                 <button onclick="window.location.href='tutorial'" type="button" style="width:25px;" class="btn btn-block btn-danger btn-xs float-right"><a ><font color="white">x</a></button>
              </div>
              <div class="card-body">
                <div class="row">
                    <div class="col-sm-2">
                    <img src="tutoriales/video.poster.png" class="img-fluid mb-2" width=""  height=""  alt="black sample"/>
                    </button>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-DOCV">
                   Documento Vigente
                    </button>
                    <div class="modal fade" id="modal-DOCV">
                      <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                          <div class="modal-header" style="background:#17a2b8;color:white;">
                            <h4 class="modal-title">Documento Vigente</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body" style="background:#17a2b8;color:white;">
                          <center>
                            <video   controls poster="tutoriales/video.poster.png" width="90%">
                              <source src="tutoriales/DocumentoVigente.mp4" type="video/mp4" >
                            </video>
                          </center>
                          </div>
                          
                          <div class="modal-footer justify-content-between" style="background:#17a2b8;color:white;">
                            <button style="background:#17a2b8;color:white;" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                  
                  </div> 
                  
                </div>
              </div>
            </div>
          </div> 
        <?php
        }
        ?>                                <!--
                  <div class="col-sm-2">
                    <a href="https://via.placeholder.com/1200/000000.png?text=2" data-toggle="lightbox" data-title="sample 2 - black" data-gallery="gallery">
                      <img src="https://via.placeholder.com/300/000000?text=2" class="img-fluid mb-2" alt="black sample"/>
                    </a>
                  </div>
                  <div class="col-sm-2">
                    <a href="https://via.placeholder.com/1200/FF0000/FFFFFF.png?text=3" data-toggle="lightbox" data-title="sample 3 - red" data-gallery="gallery">
                      <img src="https://via.placeholder.com/300/FF0000/FFFFFF?text=3" class="img-fluid mb-2" alt="red sample"/>
                    </a>
                  </div>
                  <div class="col-sm-2">
                    <a href="https://via.placeholder.com/1200/FF0000/FFFFFF.png?text=4" data-toggle="lightbox" data-title="sample 4 - red" data-gallery="gallery">
                      <img src="https://via.placeholder.com/300/FF0000/FFFFFF?text=4" class="img-fluid mb-2" alt="red sample"/>
                    </a>
                  </div>
                  <div class="col-sm-2">
                    <a href="https://via.placeholder.com/1200/000000.png?text=5" data-toggle="lightbox" data-title="sample 5 - black" data-gallery="gallery">
                      <img src="https://via.placeholder.com/300/000000?text=5" class="img-fluid mb-2" alt="black sample"/>
                    </a>
                  </div>
                  <div class="col-sm-2">
                    <a href="https://via.placeholder.com/1200/FFFFFF.png?text=6" data-toggle="lightbox" data-title="sample 6 - white" data-gallery="gallery">
                      <img src="https://via.placeholder.com/300/FFFFFF?text=6" class="img-fluid mb-2" alt="white sample"/>
                    </a>
                  </div>
                  <div class="col-sm-2">
                    <a href="https://via.placeholder.com/1200/FFFFFF.png?text=7" data-toggle="lightbox" data-title="sample 7 - white" data-gallery="gallery">
                      <img src="https://via.placeholder.com/300/FFFFFF?text=7" class="img-fluid mb-2" alt="white sample"/>
                    </a>
                  </div>
                  <div class="col-sm-2">
                    <a href="https://via.placeholder.com/1200/000000.png?text=8" data-toggle="lightbox" data-title="sample 8 - black" data-gallery="gallery">
                      <img src="https://via.placeholder.com/300/000000?text=8" class="img-fluid mb-2" alt="black sample"/>
                    </a>
                  </div>
                  <div class="col-sm-2">
                    <a href="https://via.placeholder.com/1200/FF0000/FFFFFF.png?text=9" data-toggle="lightbox" data-title="sample 9 - red" data-gallery="gallery">
                      <img src="https://via.placeholder.com/300/FF0000/FFFFFF?text=9" class="img-fluid mb-2" alt="red sample"/>
                    </a>
                  </div>
                  <div class="col-sm-2">
                    <a href="https://via.placeholder.com/1200/FFFFFF.png?text=10" data-toggle="lightbox" data-title="sample 10 - white" data-gallery="gallery">
                      <img src="https://via.placeholder.com/300/FFFFFF?text=10" class="img-fluid mb-2" alt="white sample"/>
                    </a>
                  </div>
                  <div class="col-sm-2">
                    <a href="https://via.placeholder.com/1200/FFFFFF.png?text=11" data-toggle="lightbox" data-title="sample 11 - white" data-gallery="gallery">
                      <img src="https://via.placeholder.com/300/FFFFFF?text=11" class="img-fluid mb-2" alt="white sample"/>
                    </a>
                  </div>
                  <div class="col-sm-2">
                    <a href="https://via.placeholder.com/1200/000000.png?text=12" data-toggle="lightbox" data-title="sample 12 - black" data-gallery="gallery">
                      <img src="https://via.placeholder.com/300/000000?text=12" class="img-fluid mb-2" alt="black sample"/>
                    </a>
                  </div>
                -->
                
        
        </div>
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
<!-- Bootstrap -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- jQuery UI -->
<script src="../plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Ekko Lightbox -->
<script src="../plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
<!-- Filterizr-->
<script src="../plugins/filterizr/jquery.filterizr.min.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true
      });
    });

    $('.filter-container').filterizr({gutterPixels: 3});
    $('.btn[data-filter]').on('click', function() {
      $('.btn[data-filter]').removeClass('active');
      $(this).addClass('active');
    });
  })
</script>
<script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>
</body>
</html>
<?php
}
?>