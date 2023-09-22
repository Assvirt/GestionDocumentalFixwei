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
    <title>Evaluación</title>
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
            <h1>Agregar Evaluación</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Agregar Evaluación</li>
            </ol>
          </div>
      </div><!-- /.container-fluid -->
      <div class="row">
           <div class="col-sm">
               <?php
               if($root == 1){ }else{
               ?>
                <form action="controlador/evaluacion/controllerEvaluacion" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
                    <?php
                    
                
                     $consultaUsuario=$mysqli->query("SELECT * FROM usuario WHERE cedula ='$sesion'");
                     $extraerDatosUsuario = $consultaUsuario->fetch_array(MYSQLI_ASSOC);
                     $datosUsuarioId=$extraerDatosUsuario['id'];
                    
                    ?>
                    <input type="hidden" name="idUsuario" value="<?php echo $datosUsuarioId; ?>">
                    <button type="href" class="btn btn-block btn-info btn-sm" name="Agregar"><font color="white"><i class="fas fa-plus-square"></i> Agregar</font></a></button>
                </form>  
                
                <?php
               }
                ?>
                
               <!-- Este boton funciona como posibles pruebas para la elaboracion de evaluaciones 
               <form action= "generadorFormularios/index.php?p=forms">
                    <button type="href" class="btn btn-block btn-danger btn-sm" name="Agregar"><font color="white"><i class="fas fa-wrench"></i> Prueba Evaluacion</font></a></button>
                    
                </form>
                -->
                
                </div>
                <div class="col-sm">
                </div>
                <div class="col-sm">
                </div>
                <div class="col-sm">
                </div>
                <div class="col-sm">
                </div>
                
    
    </section>
    
    
    <section class="content">
        <div class="container-fluid">
          <!-- /.row -->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                    
                <?php
                // Consulta para extraer los datos va aqui
                ?>
                  <h3 class="card-title"> </h3><br>
                  <!--<h3 class="card-title" style="color:green;font-size:17px;"><?php //echo $cantidadUsuarios; ?> usuarios activos</h3>-->
                  <br>
                  <?php ?>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: 800px;">
                  <table class="table table-head-fixed text-center" id="example">
                    <thead>
                      <tr>
                        <th>N°</th>
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th>Visualizar</th>
                        <th style="display:<?php echo$visibleE;?>;">Editar</th>
                        <th style="display:<?php echo$visibleD;?>;">Eliminar</th>
                        <th>Usuarios</th>
                        <th>Notificar</th>
                        <th>Gráficas</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        require 'conexion/bd.php';
                        
                        echo"<tr>";
                            
                            $consultaEvaluacion=$mysqli->query("SELECT * FROM evaluacion");
                            $conteo = 1;
                            while($dato=$consultaEvaluacion->fetch_assoc()){
                                $id=$dato['id'];
                                ?>
                                <form action="evaluacionParticipacion" method="post">
                                    <input type='' name='idEvaluacion' value= '<?php echo $id;?>' >
                                    <button type='submit' name="practica">Práctica</button>
                                </form>
                                <?php
                                
                                
                                $nombre=$extraerDatosConsultaEvaluacion['nombre'];
                                echo "<td style='text-align:center;'>".$conteo++."</td>";
                                echo "<td style='text-align:center;'>".utf8_encode($dato['nombre'])."</td>";
                                echo "<td>".$dato['estado']."</td>";
                                echo"<form action='evaluacionVer' method='POST'>";
                                echo"<input type='hidden' name='idEvaluacion' value= '$id' >";
                                echo" <td style='display:$visibleE;'><button type='submit' class='btn btn-block btn-info btn-sm'><i class='fas fa-eye'></i> Visualizar</button></td>";
                                echo"</form>";
                                echo"<form action='evaluacionAgregar' method='POST'>";
                                echo"<input type='hidden' name='idEvaluacion' value= '$id' >";
                                echo" <td style='display:$visibleE;'><button type='submit' class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";
                                echo"</form>";
                                $idEdit = $dato['id'];
                                 ?>
                                <input type='hidden' id='capturaVariable<?php echo $contador++;?>'  value= '<?php echo $idEdit;?>' >
                                <td style='display:<?php echo $visibleD;?>'><a onclick='funcionFormula<?php echo $contador1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a></td>
                                <script>
                                    function funcionFormula<?php echo $contador2++;?>() {
                                        /*alert("entre");*/
                                      document.getElementById("capturarFormula").value = document.getElementById("capturaVariable<?php echo $contador3++;?>").value;
                                    }
                                </script>
                                <?php
                                echo"<form action='evaluacionUsuarios' method='POST'>";
                                echo"<input type='hidden' name='idEvaluacion' value= '$id' >";
                                echo" <td style='display:$visibleE;'><button type='submit' class='btn btn-block btn-warning btn-sm'><i class='fas fa-users'></i> Usuarios</button></td>";
                                echo"</form>";
                                
                                echo"<form action='' method='POST'>";
                                echo"<input type='hidden' name='idEvaluacion' value= '$id' >";
                                echo" <td style='display:$visibleE;'><button type='submit' class='btn btn-block btn-warning btn-sm'><i class='fas fa-bell'></i> Notificar</button></td>";
                                echo"</form>";
                                
                                echo"<form action='evaluacionGraficas' method='POST'>";
                                echo"<input type='hidden' name='idEvaluacion' value= '$id' >";
                                echo" <td style='display:$visibleE;'><button type='submit' class='btn btn-block btn-info btn-sm'><i class='fas fa-chart-bar'></i> Gráficas</button></td>";
                                echo"</form>";
                                
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
                              <form action='controlador/evaluacion/controllerEvaluacion' method='POST'>
                              <div class="modal-footer justify-content-between">
                                <input type="hidden" id="capturarFormula" name='id' readonly>
                                <button type="submit" name='Eliminar' class="btn btn-outline-light">Si</button>
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
          <!-- /.row --->
        </div><!-- /.container-fluid -->
      </section>
    
    <?php
                    
        /*
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
                    
                    
                    ?>
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
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-xlCTU">
                    Agregar Usuario Parte 1
                    </button>
                    <div class="modal fade" id="modal-xlCTU">
                      <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                          <div class="modal-header" style="background:#17a2b8;color:white;">
                            <h4 class="modal-title">Agregar Usuario Parte 1</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body" style="background:#17a2b8;color:white;">
                          <center>
                            <video   controls poster="tutoriales/video.poster.png" width="90%">
                              <source src="tutoriales/AgregarUsuario.mp4" type="video/mp4" >
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
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-xlCTU2">
                    Agregar Usuario Parte 2
                    </button>
                    <div class="modal fade" id="modal-xlCTU2">
                      <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                          <div class="modal-header" style="background:#17a2b8;color:white;">
                            <h4 class="modal-title">Agregar Usuario Parte 2</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body" style="background:#17a2b8;color:white;">
                          <center>
                            <video   controls poster="tutoriales/video.poster.png" width="90%">
                              <source src="tutoriales/AgregarUsuario2.mp4" type="video/mp4" >
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
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-EXU">
                  Usuarios
                    </button>
                    <div class="modal fade" id="modal-EXU">
                      <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                          <div class="modal-header" style="background:#17a2b8;color:white;">
                            <h4 class="modal-title">Usuario</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body" style="background:#17a2b8;color:white;">
                          <center>
                            <video   controls poster="tutoriales/video.poster.png" width="90%">
                              <source src="tutoriales/ExplicacionUsuarios.mp4" type="video/mp4" >
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
                              <source src="tutoriales/GrupoDeDistribucion.mp4" type="video/mp4" >
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
                              <source src="tutoriales/Cargos.mp4" type="video/mp4" >
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
                              <source src="tutoriales/CentroTrabajo.mp4" type="video/mp4" >
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
                              <source src="tutoriales/Procesos.mp4" type="video/mp4" >
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
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-xlMacroprocesos">
                        Macroprocesos
                        </button>
                        <div class="modal fade" id="modal-xlMacroprocesos">
                          <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                              <div class="modal-header" style="background:#17a2b8;color:white;">
                                <h4 class="modal-title">Macroprocesos</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body" style="background:#17a2b8;color:white;">
                              <center>
                                <video   controls poster="tutoriales/video.poster.png" width="90%">
                                  <source src="tutoriales/Macroproceso.mp4" type="video/mp4" >
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
                              <source src="tutoriales/Definiciones.mp4" type="video/mp4" >
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
                              <source src="tutoriales/Codificacion.mp4" type="video/mp4" >
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
                              <source src="tutoriales/Normatividad.mp4" type="video/mp4" >
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
                
        <?php
        */
    ?>
    
   
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php //echo require_once'footer.php'; ?>
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

<!-- SweetAlert2 -->
<link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- SweetAlert2 -->
  <script src="../plugins/sweetalert2/sweetalert2.min.js"></script>

 <?php
  /// validaciones de alertas
  $validacionExiste=$_POST['validacionExiste'];
  $validacionExisteA=$_POST['validacionExisteA'];
  $validacionExisteB=$_POST['validacionExisteB'];
  $validacionAgregar=$_POST['validacionAgregar'];
  $validacionAgregarB=$_POST['validacionAgregarB'];
  $validacionActualizar=$_POST['validacionActualizar'];
  $validacionEliminar=$_POST['validacionEliminar'];
  $validacionEliminarB=$_POST['validacionEliminarB'];
  $Tipodocumeto=$_POST['Tipodocumeto'];

  //// Validaciones de la importación
  $validacionExisteImportacionA=$_POST['validacionExisteImportacionA'];
  $validacionExisteImportacionB=$_POST['validacionExisteImportacionB'];
  $validacionExisteImportacionC=$_POST['validacionExisteImportacionC'];
  $validacionExisteImportacionD=$_POST['validacionExisteImportacionD'];
  $validacionExisteImportacionE=$_POST['validacionExisteImportacionE'];
  $validacionExisteImportacionF=$_POST['validacionExisteImportacionF'];
  $validacionExisteImportacionG=$_POST['validacionExisteImportacionG'];
  $validacionExisteImportacionI=$_POST['validacionExisteImportacionI'];
  $validacionExisteImportacionVacio=$_POST['validacionExisteImportacionVacio'];
  $validacionRealizada=$_POST['validacionRealizada'];
  //// END
  
  
    $validacionProductoExiste=$_POST['validacionProductoExiste'];
    $validacionCodigoExiste=$_POST['validacionCodigoExiste'];
    $validacionIdentificadorExiste=$_POST['validacionIdentificadorExiste'];
    $validacionNumericoExiste=$_POST['validacionNumericoExiste'];
  
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
      if($validacionRealizada == 1){
        ?>
          Toast.fire({
              type: 'success',
              title: ' Capacitación realizada.'
          })
        <?php
      }
      if($validacionNumericoExiste == 1){
        ?>
          Toast.fire({
              type: 'warning',
              title: ' Esta intentando ingresar letras en un campo númerico.'
          })
        <?php
      }
      if($validacionProductoExiste == 1){
        ?>
          Toast.fire({
              type: 'warning',
              title: ' El producto no existe.'
          })
        <?php
      }
      if($validacionCodigoExiste == 1){
        ?>
          Toast.fire({
              type: 'warning',
              title: ' El código no existe.'
          })
        <?php
      }
      if($validacionIdentificadorExiste == 1){
        ?>
          Toast.fire({
              type: 'warning',
              title: ' El identificador no existe.'
          })
        <?php
      }
      
      
      
      
      
      if($Tipodocumeto == 1){
        ?>
          Toast.fire({
              type: 'warning',
              title: ' El tipo de documento no es valido.'
          })
        <?php
      }
      
      if($validacionExisteImportacionVacio == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos campos están vacios.'
          })
      <?php
      }
       if($validacionExisteImportacionA == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos cargos no existen en el sistema.'
          })
      <?php
      }
      if($validacionExisteImportacionB == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos lideres no existe en el sistema.'
          })
      <?php
      }
      if($validacionExisteImportacionC == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos procesos no existe en el sistema.'
          })
      <?php
      }
      if($validacionExisteImportacionD == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos centro de costos no existe en el sistema.'
          })
      <?php
      }
      if($validacionExisteImportacionE == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos centro de trabajo no existe en el sistema.'
          })
      <?php
      }
      if($validacionExisteImportacionF == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos grupos no existe en el sistema.'
          })
      <?php
      }
      if($validacionExisteImportacionG == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos usuarios ya existen.'
          })
      <?php
      }
      if($validacionExisteImportacionI == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Está intentando subir un archivo diferente.'
          })
      <?php
      }
      
      
      if($validacionExiste == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' El usuario ya existe.'
          })
      <?php
      }
      if($validacionExisteA == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' La fecha seleccionada no debe superar la del presente año.'
          })
      <?php
      }
      if($validacionExisteB == 1){
      ?>
          Toast.fire({
              type: 'error',
              title: ' Error, no se pudo eliminar el material de apoyo.'
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
      if($validacionAgregarB == 1){
      ?>
          Toast.fire({
              type: 'success',
              title: 'Registro activado.'
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
      if($validacionEliminarB == 1){
      ?>
          Toast.fire({
              type: 'error',
              title: 'Registro Anulado.'
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