<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';

$idGrupo = $_POST['idGrupo'];
require 'conexion/bd.php';
$acentos = $mysqli->query("SET NAMES 'utf8'");
$queryGrupo = $mysqli->query("SELECT nombre FROM grupo WHERE id ='$idGrupo'");
$rowNombre = $queryGrupo->fetch_array(MYSQLI_ASSOC);
$nomGrupo = ($rowNombre['nombre']);//strtoupper($rowNombre['nombre']);

?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - PERMISOS</title>
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
            <h1>Permisos del grupo <?php echo $nomGrupo;?></h1>
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
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="grupos"><font color="white"><i class="fas fa-list"></i> Listar Grupos</font></a></button>
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
    
    
    <?php
    ////// permisos para habilitar o no habilitar los módulos par acada cliente
    $consultamosPermisosHabilitados=$mysqli->query("SELECT * FROM permisosCliente WHERE cliente='Fixwei' ");
    $extraerConsultaPermisosHabilitados=$consultamosPermisosHabilitados->fetch_array(MYSQLI_ASSOC);
    
    if($extraerConsultaPermisosHabilitados['permiso1'] == '1'){
    ?>
    <!-- TABLA PERMISOS-->
    <section class="content">
        <div class="container-fluid">
                <div class="row">
                    <div class="col"></div>
                  <div class="col-9">
                    <!-- Default box -->
                    <form action="controlador/controllerPermisos.php" method="POST"> 
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
                          <?php
                            require_once 'conexion/bd.php';
                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                            $data = $mysqli->query("SELECT permisos.listar, permisos.crear, permisos.editar, permisos.eliminar, permisos.formulario, formularios.* FROM formularios INNER JOIN permisos WHERE formularios.modulo = 'config' AND permisos.formulario =formularios.idFormulario AND permisos.idGrupo = '$idGrupo' ORDER BY formularios.orden");
                          ?>
                          <div class="card-body table-responsive p-0">
                              
                            <h6 style="text-align:right;"><input type="checkbox" id="selectall" /> Marcar / Desmarcar Todos</h6>
                                
                              
                                <table class="table table-bordered text-center">
                                    <thead>                  
                                        <tr>
                                          <th>Módulo</th>
                                          <th>Descripci&oacute;n</th>
                                          <th style="width: 10px">Listar</th>
                                          <th style="width: 10px">Crear</th>
                                          <th style="width: 10px">Editar</th>
                                          <th style="width: 10px">Eliminar</th>
                                        </tr>
                                    </thead>
                                      <tbody>
                                        <?php
                                            while($row = $data->fetch_assoc()){
                                                
                                                if($row['listar']==TRUE){
                                                    $checkListar = "checked";
                                                }else{
                                                    $checkListar = "";
                                                }
                                                
                                                if($row['crear']==TRUE){
                                                    $checkCrear = "checked";
                                                }else{
                                                    $checkCrear = "";
                                                }
                                                
                                                if($row['editar']==TRUE){
                                                    $checkEditar = "checked";
                                                }else{
                                                    $checkEditar = "";
                                                }
                                                
                                                if($row['eliminar']==TRUE){
                                                    $checkEliminar = "checked";
                                                }else{
                                                    $checkEliminar = "";
                                                }
                                                
                                                echo"<tr>";
                                                echo "<td style='text-align: left;'>".$row['nombre']." ".$row['apellido']."</td>";
                                                echo "<td style='text-align: justify;'>".$row['descripcion']." ".$row['apellido']."</td>";
                                                if($row['formulario'] == 'comunicaciones'){
                                                echo "<td><input class='case'  type='checkbox' disabled checked></td>";
                                                }else{
                                                echo "<td><input class='case' name='".$row['idFormulario']."-listar' value='".$row['idFormulario']."-listar' type='checkbox' ".$checkListar."></td>";
                                                }
                                                echo "<td><input class='case' name='".$row['idFormulario']."-crear' value='".$row['idFormulario']."-crear' type='checkbox' ".$checkCrear."></td>";
                                                echo "<td><input class='case' name='".$row['idFormulario']."-editar' value='".$row['idFormulario']."-editar' type='checkbox' ".$checkEditar."></td>";
                                                echo "<td><input class='case' name='".$row['idFormulario']."-eliminar' value='".$row['idFormulario']."-eliminar' type='checkbox' ".$checkEliminar."></td>";
                                                echo"</tr>";
                                            }
                                        ?>
                                      </tbody>
                                </table>
                          </div>
                          <!-- /.card-body -->
                          <div class="card-footer">
                              <!-- Envio de variables ocultas -->
                              <input type="hidden" name="idGrupo" value="<?php echo $idGrupo; ?>">
                              
                            <button type="submit" name="addPermisosConfig" class="btn btn-primary float-right">Actualizar</button>
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
    <?php
    }
    
    if($extraerConsultaPermisosHabilitados['permiso2'] == '1'){
    ?>
    <!-- TABLA PERMISOS-->
    <section class="content">
        <div class="container-fluid">
                <div class="row">
                    <div class="col"></div>
                  <div class="col-9">
                    <!-- Default box -->
                    <form action="controlador/controllerPermisos.php" method="POST"> 
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">GESTIÓN DOCUMENTAL</h3>
            
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
                            $data = $mysqli->query("SELECT permisos.listar, permisos.crear, permisos.editar, permisos.eliminar, permisos.formulario, formularios.*, formularios.nombre AS reposit FROM formularios INNER JOIN permisos WHERE formularios.modulo = 'gestionDoc' AND permisos.formulario =formularios.idFormulario AND permisos.idGrupo = '$idGrupo' ORDER BY formularios.orden");
                          ?>
                          <div class="card-body table-responsive p-0">
                             <h6 style="text-align:right;"><input type="checkbox" id="selectall2" /> Marcar / Desmarcar Todos</h6>
                                <table class="table table-bordered text-center">
                                    <thead>                  
                                        <tr>
                                          <th>Módulo</th>
                                          <th>Descripci&oacute;n</th>
                                          <th style="width: 10px">Listar</th>
                                          <th style="width: 10px">Crear</th>
                                          <th style="width: 10px">Editar</th>
                                          <th style="width: 10px">Eliminar</th>
                                        </tr>
                                    </thead>
                                      <tbody>
                                        <?php
                                            while($row = $data->fetch_assoc()){
                                                
                                                if($row['listar']==TRUE){
                                                    $checkListar = "checked";
                                                }else{
                                                    $checkListar = "";
                                                }
                                                
                                                if($row['crear']==TRUE){
                                                    $checkCrear = "checked";
                                                }else{
                                                    $checkCrear = "";
                                                }
                                                
                                                if($row['editar']==TRUE){
                                                    $checkEditar = "checked";
                                                }else{
                                                    $checkEditar = "";
                                                }
                                                
                                                if($row['eliminar']==TRUE){
                                                    $checkEliminar = "checked";
                                                }else{
                                                    $checkEliminar = "";
                                                }
                                                
                                                
                                                
                                                echo"<tr>";
                                                echo "<td style='text-align: left;'>".$row['nombre']." ".$row['apellido']."</td>";
                                                echo "<td style='text-align: justify;'>".$row['descripcion']." ".$row['apellido']."</td>";
                                                
                                                echo "<td><input class='case2' name='".$row['idFormulario']."-listar' value='".$row['idFormulario']."-listar' type='checkbox' ".$checkListar."></td>";
                                                
                                                if($row['idFormulario'] == 'divulgar'){
                                               
                                                echo "<td><input  type='checkbox' disabled checked ></td>";
                                                echo "<td><input  type='checkbox' disabled checked ></td>";
                                                    
                                                }else{
                                                echo "<td><input class='case2' name='".$row['idFormulario']."-crear' value='".$row['idFormulario']."-crear' type='checkbox' ".$checkCrear."></td>";
                                                echo "<td><input class='case2' name='".$row['idFormulario']."-editar' value='".$row['idFormulario']."-editar' type='checkbox' ".$checkEditar."></td>";
                                                }
                                                
                                                if($row['formulario'] == 'listadoMaestro' || $row['idFormulario'] == 'divulgar' || $row['idFormulario'] == 'documentosObs'){
                                                echo "<td><input class='case2' type='checkbox' disabled checked></td>";
                                                }else{
                                                echo "<td><input class='case2' name='".$row['idFormulario']."-eliminar' value='".$row['idFormulario']."-eliminar' type='checkbox' ".$checkEliminar."></td>";
                                                }
                                                echo"</tr>";
                                            }
                                        ?>
                                      </tbody>
                                </table>
                          </div>
                          <!-- /.card-body -->
                          <div class="card-footer">
                              <!-- Envio de variables ocultas -->
                              <input type="hidden" name="idGrupo" value="<?php echo $idGrupo; ?>">
                              
                            <button type="submit" name="addPermisosGestion" class="btn btn-primary float-right">Actualizar</button>
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
    <?php
    }
    
    if($extraerConsultaPermisosHabilitados['permiso3'] == '1'){
    ?>
    <!-- TABLA PERMISOS-->
    <section class="content">
        <div class="container-fluid">
                <div class="row">
                    <div class="col"></div>
                  <div class="col-9">
                    <!-- Default box -->
                    <form action="controlador/controllerPermisos.php" method="POST"> 
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">REPOSITORIO</h3>
            
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
                            $data = $mysqli->query("SELECT permisos.listar, permisos.crear, permisos.editar, permisos.eliminar, permisos.formulario, formularios.* FROM formularios INNER JOIN permisos WHERE formularios.modulo = 'Repositorio' AND permisos.formulario =formularios.idFormulario AND permisos.idGrupo = '$idGrupo' ORDER BY formularios.orden");
                          ?>
                          <div class="card-body table-responsive p-0">
                             <h6 style="text-align:right;"><input type="checkbox" id="selectall22" /> Marcar / Desmarcar Todos</h6>
                                <table class="table table-bordered text-center">
                                    <thead>                  
                                        <tr>
                                          <th>Módulo</th>
                                          <th>Descripci&oacute;n</th>
                                          <th style="width: 10px">Listar</th>
                                          <th style="width: 10px">Crear</th>
                                          <th style="width: 10px">Editar</th>
                                          <th style="width: 10px">Eliminar</th>
                                        </tr>
                                    </thead>
                                      <tbody>
                                        <?php
                                            while($row = $data->fetch_assoc()){
                                                
                                                if($row['listar']==TRUE){
                                                    $checkListar = "checked";
                                                }else{
                                                    $checkListar = "";
                                                }
                                                
                                                if($row['crear']==TRUE){
                                                    $checkCrear = "checked";
                                                }else{
                                                    $checkCrear = "";
                                                }
                                                
                                                if($row['editar']==TRUE){
                                                    $checkEditar = "checked";
                                                }else{
                                                    $checkEditar = "";
                                                }
                                                
                                                if($row['eliminar']==TRUE){
                                                    $checkEliminar = "checked";
                                                }else{
                                                    $checkEliminar = "";
                                                }
                                                
                                                
                                                
                                                echo"<tr>";
                                                echo "<td style='text-align: left;'>".$row['nombre']." ".$row['apellido']."</td>";
                                                echo "<td style='text-align: justify;'>".$row['descripcion']." ".$row['apellido']."</td>";
                                                echo "<td><input class='case22' name='".$row['idFormulario']."-listar' value='".$row['idFormulario']."-listar' type='checkbox' ".$checkListar."></td>";
                                                echo "<td><input class='case22' name='".$row['idFormulario']."-crear' value='".$row['idFormulario']."-crear' type='checkbox' ".$checkCrear."></td>";
                                                echo "<td><input class='case22' name='".$row['idFormulario']."-editar' value='".$row['idFormulario']."-editar' type='checkbox' ".$checkEditar."></td>";
                                                if($row['formulario'] == 'listadoMaestro'){
                                                echo "<td><input class='case22' type='checkbox' disabled checked></td>";
                                                }else{
                                                echo "<td><input class='case22' name='".$row['idFormulario']."-eliminar' value='".$row['idFormulario']."-eliminar' type='checkbox' ".$checkEliminar."></td>";
                                                }
                                                echo"</tr>";
                                            }
                                        ?>
                                      </tbody>
                                </table>
                          </div>
                          <!-- /.card-body -->
                          <div class="card-footer">
                              <!-- Envio de variables ocultas -->
                              <input type="hidden" name="idGrupo" value="<?php echo $idGrupo; ?>">
                              
                            <button type="submit" name="addPermisosRepositorio" class="btn btn-primary float-right">Actualizar</button>
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
    <?php
    }
    
    if($extraerConsultaPermisosHabilitados['permiso4'] == '1'){
    ?>
    <!-- TABLA PERMISOS-->
    <section class="content">
        <div class="container-fluid">
                <div class="row">
                    <div class="col"></div>
                  <div class="col-9">
                    <!-- Default box -->
                    <form action="controlador/controllerPermisos.php" method="POST"> 
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">INDICADORES</h3>
            
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
                            $data = $mysqli->query("SELECT permisos.listar, permisos.crear, permisos.editar, permisos.eliminar, permisos.formulario, formularios.* FROM formularios INNER JOIN permisos WHERE formularios.modulo = 'indi' AND permisos.formulario =formularios.idFormulario AND permisos.idGrupo = '$idGrupo' ORDER BY formularios.orden");
                          ?>
                          <div class="card-body table-responsive p-0">
                              <h6 style="text-align:right;"><input type="checkbox" id="selectall3" /> Marcar / Desmarcar Todos</h6>
                                <table class="table table-bordered text-center">
                                    <thead>                  
                                        <tr>
                                          <th>Módulo</th>
                                          <th>Descripci&oacute;n</th>
                                          <th style="width: 10px">Listar</th>
                                          <th style="width: 10px">Crear</th>
                                          <th style="width: 10px">Editar</th>
                                          <th style="width: 10px">Eliminar</th>
                                        </tr>
                                    </thead>
                                      <tbody>
                                        <?php
                                            while($row = $data->fetch_assoc()){
                                                
                                                if($row['listar']==TRUE){
                                                    $checkListar = "checked";
                                                }else{
                                                    $checkListar = "";
                                                }
                                                
                                                if($row['crear']==TRUE){
                                                    $checkCrear = "checked";
                                                }else{
                                                    $checkCrear = "";
                                                }
                                                
                                                if($row['editar']==TRUE){
                                                    $checkEditar = "checked";
                                                }else{
                                                    $checkEditar = "";
                                                }
                                                
                                                if($row['eliminar']==TRUE){
                                                    $checkEliminar = "checked";
                                                }else{
                                                    $checkEliminar = "";
                                                }
                                                
                                                echo"<tr>";
                                                echo "<td style='text-align: left;'>".$row['nombre']." ".$row['apellido']."</td>";
                                                echo "<td style='text-align: justify;'>".$row['descripcion']." ".$row['apellido']."</td>";
                                                echo "<td><input class='case3' name='".$row['idFormulario']."-listar' value='".$row['idFormulario']."-listar' type='checkbox' ".$checkListar."></td>";
                                                echo "<td><input class='case3' name='".$row['idFormulario']."-crear' value='".$row['idFormulario']."-crear' type='checkbox' ".$checkCrear."></td>";
                                                echo "<td><input class='case3' name='".$row['idFormulario']."-editar' value='".$row['idFormulario']."-editar' type='checkbox' ".$checkEditar."></td>";
                                                echo "<td><input class='case3' name='".$row['idFormulario']."-eliminar' value='".$row['idFormulario']."-eliminar' type='checkbox' ".$checkEliminar."></td>";
                                                echo"</tr>";
                                            }
                                        ?>
                                      </tbody>
                                </table>
                          </div>
                          <!-- /.card-body -->
                          <div class="card-footer">
                              <!-- Envio de variables ocultas -->
                              <input type="hidden" name="idGrupo" value="<?php echo $idGrupo; ?>">
                              
                            <button type="submit" name="addPermisosIndicador" class="btn btn-primary float-right">Actualizar</button>
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
    <?php
    }
    
    if($extraerConsultaPermisosHabilitados['permiso5'] == '1'){
    ?>
    <!-- TABLA PERMISOS-->
    <section class="content">
        <div class="container-fluid">
                <div class="row">
                    <div class="col"></div>
                  <div class="col-9">
                    <!-- Default box -->
                    <form action="controlador/controllerPermisos.php" method="POST"> 
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">ACTAS E INFORMES</h3>
            
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
                            $data = $mysqli->query("SELECT permisos.listar, permisos.crear, permisos.editar, permisos.eliminar, permisos.formulario, formularios.* FROM formularios INNER JOIN permisos WHERE formularios.modulo = 'actas' AND permisos.formulario =formularios.idFormulario AND permisos.idGrupo = '$idGrupo' ORDER BY formularios.orden");
                          ?>
                          <div class="card-body table-responsive p-0">
                             <h6 style="text-align:right;"><input type="checkbox" id="selectall4" /> Marcar / Desmarcar Todos</h6>
                                <table class="table table-bordered text-center">
                                    <thead>                  
                                        <tr>
                                          <th>Módulo</th>
                                          <th>Descripci&oacute;n</th>
                                          <th style="width: 10px">Listar</th>
                                          <th style="width: 10px">Crear</th>
                                          <th style="width: 10px">Editar</th>
                                          <th style="width: 10px">Eliminar</th>
                                        </tr>
                                    </thead>
                                      <tbody>
                                        <?php
                                            while($row = $data->fetch_assoc()){
                                                
                                                if($row['listar']==TRUE){
                                                    $checkListar = "checked";
                                                }else{
                                                    $checkListar = "";
                                                }
                                                
                                                if($row['crear']==TRUE){
                                                    $checkCrear = "checked";
                                                }else{
                                                    $checkCrear = "";
                                                }
                                                
                                                if($row['editar']==TRUE){
                                                    $checkEditar = "checked";
                                                }else{
                                                    $checkEditar = "";
                                                }
                                                
                                                if($row['eliminar']==TRUE){
                                                    $checkEliminar = "checked";
                                                }else{
                                                    $checkEliminar = "";
                                                }
                                                
                                                echo"<tr>";
                                                echo "<td style='text-align: left;'>".$row['nombre']." ".$row['apellido']."</td>";
                                                echo "<td style='text-align: justify;'>".$row['descripcion']." ".$row['apellido']."</td>";
                                                echo "<td><input class='case4' name='".$row['idFormulario']."-listar' value='".$row['idFormulario']."-listar' type='checkbox' ".$checkListar."></td>";
                                                echo "<td><input class='case4' name='".$row['idFormulario']."-crear' value='".$row['idFormulario']."-crear' type='checkbox' ".$checkCrear."></td>";
                                                echo "<td><input class='case4' name='".$row['idFormulario']."-editar' value='".$row['idFormulario']."-editar' type='checkbox' ".$checkEditar."></td>";
                                                echo "<td><input class='case4' name='".$row['idFormulario']."-eliminar' value='".$row['idFormulario']."-eliminar' type='checkbox' ".$checkEliminar."></td>";
                                                echo"</tr>";
                                            }
                                        ?>
                                      </tbody>
                                </table>
                          </div>
                          <!-- /.card-body -->
                          <div class="card-footer">
                              <!-- Envio de variables ocultas -->
                              <input type="hidden" name="idGrupo" value="<?php echo $idGrupo; ?>">
                              
                            <button type="submit" name="addPermisosActas" class="btn btn-primary float-right">Actualizar</button>
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
    <?php
    }
    
    if($extraerConsultaPermisosHabilitados['permiso6'] == '1'){
    ?>
    <!-- TABLA PERMISOS-->
    <section class="content">
        <div class="container-fluid">
                <div class="row">
                    <div class="col"></div>
                  <div class="col-9">
                    <!-- Default box -->
                    <form action="controlador/controllerPermisos.php" method="POST"> 
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">COMPRAS</h3>
            
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
                            $data = $mysqli->query("SELECT permisos.listar, permisos.crear, permisos.editar, permisos.eliminar, permisos.formulario, formularios.* FROM formularios INNER JOIN permisos WHERE formularios.modulo = 'compras' AND permisos.formulario =formularios.idFormulario AND permisos.idGrupo = '$idGrupo' ORDER BY formularios.orden");
                          ?>
                          <div class="card-body table-responsive p-0">
                             <h6 style="text-align:right;"><input type="checkbox" id="selectall5" /> Marcar / Desmarcar Todos</h6>
                                <table class="table table-bordered text-center">
                                    <thead>                  
                                        <tr>
                                          <th>Módulo</th>
                                          <th>Descripci&oacute;n</th>
                                          <th style="width: 10px">Listar</th>
                                          <th style="width: 10px">Crear</th>
                                          <th style="width: 10px">Editar</th>
                                          <th style="width: 10px">Eliminar</th>
                                        </tr>
                                    </thead>
                                      <tbody>
                                        <?php
                                            while($row = $data->fetch_assoc()){
                                                
                                                if($row['listar']==TRUE){
                                                    $checkListar = "checked";
                                                }else{
                                                    $checkListar = "";
                                                }
                                                
                                                if($row['crear']==TRUE){
                                                    $checkCrear = "checked";
                                                }else{
                                                    $checkCrear = "";
                                                }
                                                
                                                if($row['editar']==TRUE){
                                                    $checkEditar = "checked";
                                                }else{
                                                    $checkEditar = "";
                                                }
                                                
                                                if($row['eliminar']==TRUE){
                                                    $checkEliminar = "checked";
                                                }else{
                                                    $checkEliminar = "";
                                                }
                                                
                                                echo"<tr>";
                                                echo "<td style='text-align: left;'>".$row['nombre']." ".$row['apellido']."</td>";
                                                echo "<td style='text-align: justify;'>".$row['descripcion']." ".$row['apellido']."</td>";
                                                echo "<td><input class='case5' name='".$row['idFormulario']."-listar' value='".$row['idFormulario']."-listar' type='checkbox' ".$checkListar."></td>";
                                                
                                                if($row['formulario'] == 'informes' || $row['formulario'] == 'aprobacionOC'){
                                                
                                               
                                                echo "<td><input class='case5' disabled checked value='".$row['idFormulario']."-crear' type='checkbox' ".$checkCrear."></td>";
                                                echo "<td><input class='case5' disabled checked value='".$row['idFormulario']."-editar' type='checkbox' ".$checkEditar."></td>";
                                                echo "<td><input class='case5' disabled checked value='".$row['idFormulario']."-eliminar' type='checkbox' ".$checkEliminar."></td>";
                                                
                                                    
                                                }else{
                                                    echo "<td><input class='case5' name='".$row['idFormulario']."-crear' value='".$row['idFormulario']."-crear' type='checkbox' ".$checkCrear."></td>";
                                                    echo "<td><input class='case5' name='".$row['idFormulario']."-editar' value='".$row['idFormulario']."-editar' type='checkbox' ".$checkEditar."></td>";
                                                    echo "<td><input class='case5' name='".$row['idFormulario']."-eliminar' value='".$row['idFormulario']."-eliminar' type='checkbox' ".$checkEliminar."></td>";
                                                }
                                                echo"</tr>";
                                            }
                                        ?>
                                      </tbody>
                                </table>
                          </div>
                          <!-- /.card-body -->
                          <div class="card-footer">
                              <!-- Envio de variables ocultas -->
                              <input type="hidden" name="idGrupo" value="<?php echo $idGrupo; ?>">
                              
                            <button type="submit" name="addPermisosCompras" class="btn btn-primary float-right">Actualizar</button>
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
    <?php
    }
    ?>
    
       



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