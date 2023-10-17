<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';

$idGrupo = $_POST['idGrupo'];
require 'conexion/bd.php';
$acentos = $mysqli->query("SET NAMES 'utf8'");
$queryGrupo = $mysqli->query("SELECT nombre FROM grupo WHERE id ='1'");
$rowNombre = $queryGrupo->fetch_array(MYSQLI_ASSOC);
$nomGrupo = strtoupper($rowNombre['nombre']);

?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - ELIMINACIÓN</title>
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
            <h1> <?php //echo $nomGrupo;?></h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Permisos</li>
            </ol>
          </div>
        </div>
            <div class="row">
                <div class="col">
                    
                </div>
                <div class="col-9">
                    <div class="row">
                        <div class="col-sm">
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="cliente"><font color="white"><i class="fas fa-list"></i> Cliente</font></a></button>
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
                    <form action="controlador/eliminarTablas" method="POST"> 
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">CONFIGURACIÓN</h3>
            
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                              <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                <i class="fas fa-times"></i></button>
                            </div>
                          </div>
                          <div class="card-body">
                              
                                
                              
                                <table class="table table-bordered text-center">
                                    <thead>                  
                                        <tr>
                                          <th>Módulo</th>
                                          <th style="width: 10px">Estado</th>
                                          <th style="width: 10px">Eliminar</th>
                                        </tr>
                                    </thead>
                                      <tbody>
                                        <tr>
                                            <td style='text-align: left;'>Usuarios</td>
                                            <td>
                                                <?php
                                                $consultaUsuarios=$mysqli->query("SELECT count(*) FROM usuario ");
                                                $extrerconsultaUsuarios=$consultaUsuarios->fetch_array(MYSQLI_ASSOC);
                                                if( $extrerconsultaUsuarios['count(*)'] > 0){
                                                    echo 'Datos';
                                                }else{
                                                    echo 'Sin datos';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if( $extrerconsultaUsuarios['count(*)'] > 0){
                                                ?>
                                                <input type='hidden' id='capturaVariable<?php echo $contador++;?>'  value= '<?php echo 'Usuarios';?>' >
                                                <a onclick='funcionFormula<?php echo $contador1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a>
                                                <script>
                                                    function funcionFormula<?php echo $contador2++;?>() {
                                                      document.getElementById("capturarFormula").value = document.getElementById("capturaVariable<?php echo $contador3++;?>").value;
                                                    }
                                                </script>
                                                <?php
                                                }else{
                                                ?>
                                                <button disabled style="color:white;" class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i>Eliminar</button>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style='text-align: left;'>Grupos de distribución</td>
                                            <td>
                                                <?php
                                                $consultaGrupo=$mysqli->query("SELECT count(*) FROM grupo ");
                                                $extrerconsultaGrupo=$consultaGrupo->fetch_array(MYSQLI_ASSOC);
                                                $extrerconsultaGrupo['count(*)'];
                                                if( $extrerconsultaGrupo['count(*)'] > 0){
                                                    echo 'Datos';
                                                }else{
                                                    echo 'Sin datos';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if( $extrerconsultaGrupo['count(*)'] > 0){
                                                ?>
                                                <input type='hidden' id='capturaVariable<?php echo $contador++;?>'  value= '<?php echo 'Grupos de distribución';?>' >
                                                <a onclick='funcionFormula<?php echo $contador1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a>
                                                <script>
                                                    function funcionFormula<?php echo $contador2++;?>() {
                                                      document.getElementById("capturarFormula").value = document.getElementById("capturaVariable<?php echo $contador3++;?>").value;
                                                    }
                                                </script>
                                                <?php
                                                }else{
                                                ?>
                                                <button disabled style="color:white;" class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i>Eliminar</button>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style='text-align: left;'>Cargos</td>
                                            <td>
                                                <?php
                                                $consultaCargos=$mysqli->query("SELECT count(*) FROM cargos ");
                                                $extrerconsultaCargos=$consultaCargos->fetch_array(MYSQLI_ASSOC);
                                                $extrerconsultaCargos['count(*)'];
                                                if( $extrerconsultaCargos['count(*)'] > 0){
                                                    echo 'Datos';
                                                }else{
                                                    echo 'Sin datos';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if( $extrerconsultaCargos['count(*)'] > 0){
                                                ?>
                                                <input type='hidden' id='capturaVariable<?php echo $contador++;?>'  value= '<?php echo 'Cargos';?>' >
                                                <a onclick='funcionFormula<?php echo $contador1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a>
                                                <script>
                                                    function funcionFormula<?php echo $contador2++;?>() {
                                                      document.getElementById("capturarFormula").value = document.getElementById("capturaVariable<?php echo $contador3++;?>").value;
                                                    }
                                                </script>
                                                <?php
                                                }else{
                                                ?>
                                                <button disabled style="color:white;" class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i>Eliminar</button>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style='text-align: left;'>Centro de trabajo</td>
                                            <td>
                                                <?php
                                                $centroTrabajo=$mysqli->query("SELECT count(*) FROM centrodetrabajo ");
                                                $extrercentroTrabajo=$centroTrabajo->fetch_array(MYSQLI_ASSOC);
                                                $extrercentroTrabajo['count(*)'];
                                                if( $extrercentroTrabajo['count(*)'] > 0){
                                                    echo 'Datos';
                                                }else{
                                                    echo 'Sin datos';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if( $extrercentroTrabajo['count(*)'] > 0){
                                                ?>
                                                <input type='hidden' id='capturaVariable<?php echo $contador++;?>'  value= '<?php echo 'Centro de Trabajos';?>' >
                                                <a onclick='funcionFormula<?php echo $contador1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a>
                                                <script>
                                                    function funcionFormula<?php echo $contador2++;?>() {
                                                      document.getElementById("capturarFormula").value = document.getElementById("capturaVariable<?php echo $contador3++;?>").value;
                                                    }
                                                </script>
                                                <?php
                                                }else{
                                                ?>
                                                <button disabled style="color:white;" class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i>Eliminar</button>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style='text-align: left;'>Procesos</td>
                                            <td>
                                                <?php
                                                $consultaCentroProcesos=$mysqli->query("SELECT count(*) FROM procesos ");
                                                $extrerconsultaCentroProcesos=$consultaCentroProcesos->fetch_array(MYSQLI_ASSOC);
                                                $extrerconsultaCentroProcesos['count(*)'];
                                                if( $extrerconsultaCentroProcesos['count(*)'] > 0){
                                                    echo 'Datos';
                                                }else{
                                                    echo 'Sin datos';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if( $extrerconsultaCentroProcesos['count(*)'] > 0){
                                                ?>
                                                <input type='hidden' id='capturaVariable<?php echo $contador++;?>'  value= '<?php echo 'Procesos';?>' >
                                                <a onclick='funcionFormula<?php echo $contador1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a>
                                                <script>
                                                    function funcionFormula<?php echo $contador2++;?>() {
                                                      document.getElementById("capturarFormula").value = document.getElementById("capturaVariable<?php echo $contador3++;?>").value;
                                                    }
                                                </script>
                                                <?php
                                                }else{
                                                ?>
                                                <button disabled style="color:white;" class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i>Eliminar</button>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style='text-align: left;'>Macroprocesos</td>
                                            <td>
                                                <?php
                                                $consultaCentroMacroproProcesos=$mysqli->query("SELECT count(*) FROM macroproceso ");
                                                $extrerconsultaCentroMacroproProcesos=$consultaCentroMacroproProcesos->fetch_array(MYSQLI_ASSOC);
                                                $extrerconsultaCentroMacroproProcesos['count(*)'];
                                                if( $extrerconsultaCentroMacroproProcesos['count(*)'] > 0){
                                                    echo 'Datos';
                                                }else{
                                                    echo 'Sin datos';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if( $extrerconsultaCentroMacroproProcesos['count(*)'] > 0){
                                                ?>
                                                <input type='hidden' id='capturaVariable<?php echo $contador++;?>'  value= '<?php echo 'Macroprocesos';?>' >
                                                <a onclick='funcionFormula<?php echo $contador1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a>
                                                <script>
                                                    function funcionFormula<?php echo $contador2++;?>() {
                                                      document.getElementById("capturarFormula").value = document.getElementById("capturaVariable<?php echo $contador3++;?>").value;
                                                    }
                                                </script>
                                                <?php
                                                }else{
                                                ?>
                                                <button disabled style="color:white;" class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i>Eliminar</button>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style='text-align: left;'>Definición</td>
                                            <td>
                                                <?php
                                                $consultaDefinicion=$mysqli->query("SELECT count(*) FROM definicion ");
                                                $extrerconsultaDefinicion=$consultaDefinicion->fetch_array(MYSQLI_ASSOC);
                                                $extrerconsultaDefinicion['count(*)'];
                                                if( $extrerconsultaDefinicion['count(*)'] > 0){
                                                    echo 'Datos';
                                                }else{
                                                    echo 'Sin datos';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if( $extrerconsultaDefinicion['count(*)'] > 0){
                                                ?>
                                                <input type='hidden' id='capturaVariable<?php echo $contador++;?>'  value= '<?php echo 'Definición';?>' >
                                                <a onclick='funcionFormula<?php echo $contador1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a>
                                                <script>
                                                    function funcionFormula<?php echo $contador2++;?>() {
                                                      document.getElementById("capturarFormula").value = document.getElementById("capturaVariable<?php echo $contador3++;?>").value;
                                                    }
                                                </script>
                                                <?php
                                                }else{
                                                ?>
                                                <button disabled style="color:white;" class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i>Eliminar</button>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style='text-align: left;'>Codificación</td>
                                            <td>
                                                <?php
                                                $consultaCodificacion=$mysqli->query("SELECT count(*) FROM codificacion ");
                                                $extrerconsultaCodificacion=$consultaCodificacion->fetch_array(MYSQLI_ASSOC);
                                                $extrerconsultaCodificacion['count(*)'];
                                                if( $extrerconsultaCodificacion['count(*)'] > 0){
                                                    echo 'Datos';
                                                }else{
                                                    echo 'Sin datos';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if( $extrerconsultaCodificacion['count(*)'] > 0){
                                                ?>
                                                <input type='hidden' id='capturaVariable<?php echo $contador++;?>'  value= '<?php echo 'Codificación';?>' >
                                                <a onclick='funcionFormula<?php echo $contador1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a>
                                                <script>
                                                    function funcionFormula<?php echo $contador2++;?>() {
                                                      document.getElementById("capturarFormula").value = document.getElementById("capturaVariable<?php echo $contador3++;?>").value;
                                                    }
                                                </script>
                                                <?php
                                                }else{
                                                ?>
                                                <button disabled style="color:white;" class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i>Eliminar</button>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style='text-align: left;'>Normatividad</td>
                                            <td>
                                                <?php
                                                $consultaNormatividad=$mysqli->query("SELECT count(*) FROM normatividad ");
                                                $extrerconsultaNormatividad=$consultaNormatividad->fetch_array(MYSQLI_ASSOC);
                                                $extrerconsultaNormatividad['count(*)'];
                                                if( $extrerconsultaNormatividad['count(*)'] > 0){
                                                    echo 'Datos';
                                                }else{
                                                    echo 'Sin datos';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if( $extrerconsultaNormatividad['count(*)'] > 0){
                                                ?>
                                                <input type='hidden' id='capturaVariable<?php echo $contador++;?>'  value= '<?php echo 'Normatividad';?>' >
                                                <a onclick='funcionFormula<?php echo $contador1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a>
                                                <script>
                                                    function funcionFormula<?php echo $contador2++;?>() {
                                                      document.getElementById("capturarFormula").value = document.getElementById("capturaVariable<?php echo $contador3++;?>").value;
                                                    }
                                                </script>
                                                <?php
                                                }else{
                                                ?>
                                                <button disabled style="color:white;" class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i>Eliminar</button>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style='text-align: left;'>Centro de costos</td>
                                            <td>
                                                <?php
                                                $consultaCentroCostos=$mysqli->query("SELECT count(*) FROM centroCostos ");
                                                $extrerconsultaCentroCostos=$consultaCentroCostos->fetch_array(MYSQLI_ASSOC);
                                                $extrerconsultaCentroCostos['count(*)'];
                                                if( $extrerconsultaCentroCostos['count(*)'] > 0){
                                                    echo 'Datos';
                                                }else{
                                                    echo 'Sin datos';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if( $extrerconsultaCentroCostos['count(*)'] > 0){
                                                ?>
                                                <input type='hidden' id='capturaVariable<?php echo $contador++;?>'  value= '<?php echo 'Centro de costos';?>' >
                                                <a onclick='funcionFormula<?php echo $contador1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a>
                                                <script>
                                                    function funcionFormula<?php echo $contador2++;?>() {
                                                      document.getElementById("capturarFormula").value = document.getElementById("capturaVariable<?php echo $contador3++;?>").value;
                                                    }
                                                </script>
                                                <?php
                                                }else{
                                                ?>
                                                <button disabled style="color:white;" class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i>Eliminar</button>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style='text-align: left;'>Tipo de documento</td>
                                            <td>
                                                <?php
                                                $consultaTipodocumento=$mysqli->query("SELECT count(*) FROM tipoDocumento ");
                                                $extrerconsultaTipodocumento=$consultaTipodocumento->fetch_array(MYSQLI_ASSOC);
                                                $extrerconsultaTipodocumento['count(*)'];
                                                if( $extrerconsultaTipodocumento['count(*)'] > 0){
                                                    echo 'Datos';
                                                }else{
                                                    echo 'Sin datos';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if( $extrerconsultaTipodocumento['count(*)'] > 0){
                                                ?>
                                                <input type='hidden' id='capturaVariable<?php echo $contador++;?>'  value= '<?php echo 'Tipo de documento';?>' >
                                                <a onclick='funcionFormula<?php echo $contador1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a>
                                                <script>
                                                    function funcionFormula<?php echo $contador2++;?>() {
                                                      document.getElementById("capturarFormula").value = document.getElementById("capturaVariable<?php echo $contador3++;?>").value;
                                                    }
                                                </script>
                                                <?php
                                                }else{
                                                ?>
                                                <button disabled style="color:white;" class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i>Eliminar</button>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                        </tr>
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
                                                <p>¿Est&aacute; seguro que desea eliminar los registros?</p>
                                              </div>
                                              <!-- formulario para eliminar por el id -->
                                              
                                              <div class="modal-footer justify-content-between">
                                                <input type="hidden" id="capturarFormula" name='modulo' readonly>
                                                <button type="submit" name='eliminar' class="btn btn-outline-light">Si</button>
                                                <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
                                              </div>
                                             
                                              <!-- END formulario para eliminar por el id -->
                                            </div>
                                          </div>
                                      </div>
                                      </tbody>
                                </table>
                          </div>
                          <!-- /.card-body -->
                          <div class="card-footer">
                              <!-- Envio de variables ocultas -->
                              <input type="hidden" name="idGrupo" value="<?php echo $idGrupo; ?>">
                              
                          </div>
                          <!-- /.card-footer-->
                        </div>
                    </form>
                    <!-- /.card -->
                  </div>
                  <div class="col"></div>
                </div>
        </div>
    </section>
    <!-- TABLA PERMISOS-->
    
    <!-- TABLA PERMISOS-->
    <section class="content">
        <div class="container-fluid">
                <div class="row">
                    <div class="col"></div>
                  <div class="col-9">
                    <!-- Default box -->
                    <form action="controlador/eliminarTablas" method="POST"> 
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">GETIÓN DOCUMENTAL</h3>
            
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                              <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                <i class="fas fa-times"></i></button>
                            </div>
                          </div>
                         
                          <div class="card-body">
                              
                                
                              
                              
                                       
                                        <input type='hidden' id='capturaVariable'   >
                                        <a onclick='funcionFormula' style='color:white;width:25%;' data-toggle='modal' data-target='#modal-dangerB' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a>
                                        <script>
                                            function funcionFormula() {
                                                /*alert("entre");*/
                                              document.getElementById("capturarFormula").value = document.getElementById("capturaVariable").value;
                                            }
                                        </script>
                                        <div class="modal fade" id="modal-dangerB">
                                          <div class="modal-dialog">
                                            <div class="modal-content bg-danger">
                                              <div class="modal-header">
                                                <h4 class="modal-title">Alerta</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <div class="modal-body">
                                                <p>¿Est&aacute; seguro que desea eliminar los registros de gestión documental?</p>
                                              </div>
                                              <!-- formulario para eliminar por el id -->
                                              
                                              <div class="modal-footer justify-content-between">
                                                <input type="hidden" name='modulo' value="gestion">
                                                <button type="submit" name='eliminarGestion' class="btn btn-outline-light">Si</button>
                                                <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
                                              </div>
                                             
                                              <!-- END formulario para eliminar por el id -->
                                            </div>
                                          </div>
                                      </div>
                                    
                          </div>
                          <!-- /.card-body -->
                          <div class="card-footer">
                              <!-- Envio de variables ocultas -->
                              <input type="hidden" name="idGrupo" value="<?php echo $idGrupo; ?>">
                              
                          </div>
                          <!-- /.card-footer-->
                        </div>
                    </form>
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
 <!-- SweetAlert2 -->
    <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- SweetAlert2 -->
  <script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
  
  <?php
  $validacionEliminar=$_POST['clienteBorrarRegistros'];
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
<script>
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()
</script>
<!-- para marcar todos o desmarcar todos los checkbox -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
    $("#selectall").on("click", function() {
        $(".case").prop("checked", this.checked);
    });
                            
    // if all checkbox are selected, check the selectall checkbox and viceversa
    $(".case").on("click", function() {
    if ($(".case").length == $(".case:checked").length) {
        $("#selectall").prop("checked", true);
    } else {
        $("#selectall").prop("checked", false);
    }
    });
    
    $("#selectall2").on("click", function() {
        $(".case2").prop("checked", this.checked);
    });
                            
    // if all checkbox are selected, check the selectall checkbox and viceversa
    $(".case2").on("click", function() {
    if ($(".case2").length == $(".case:checked").length) {
        $("#selectall2").prop("checked", true);
    } else {
        $("#selectall2").prop("checked", false);
    }
    });
    
    $("#selectall22").on("click", function() {
        $(".case22").prop("checked", this.checked);
    });
                            
    // if all checkbox are selected, check the selectall checkbox and viceversa
    $(".case22").on("click", function() {
    if ($(".case22").length == $(".case:checked").length) {
        $("#selectall22").prop("checked", true);
    } else {
        $("#selectall22").prop("checked", false);
    }
    });
    
    $("#selectall3").on("click", function() {
        $(".case3").prop("checked", this.checked);
    });
                            
    // if all checkbox are selected, check the selectall checkbox and viceversa
    $(".case3").on("click", function() {
    if ($(".case3").length == $(".case:checked").length) {
        $("#selectall3").prop("checked", true);
    } else {
        $("#selectall3").prop("checked", false);
    }
    });
    
    $("#selectall4").on("click", function() {
        $(".case4").prop("checked", this.checked);
    });
                            
    // if all checkbox are selected, check the selectall checkbox and viceversa
    $(".case4").on("click", function() {
    if ($(".case4").length == $(".case:checked").length) {
        $("#selectall4").prop("checked", true);
    } else {
        $("#selectall4").prop("checked", false);
    }
    });
    
    $("#selectall5").on("click", function() {
        $(".case5").prop("checked", this.checked);
    });
                            
    // if all checkbox are selected, check the selectall checkbox and viceversa
    $(".case5").on("click", function() {
    if ($(".case5").length == $(".case:checked").length) {
        $("#selectall5").prop("checked", true);
    } else {
        $("#selectall5").prop("checked", false);
    }
    });
</script>
<!-- END -->
<script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>
</body>
</html>
<?php
}
?>