<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';

///////// notificaciones para plataforma y correo
require_once 'conexion/bd.php';
$formulario = 'usuarios'; //Se cambia el nombre del formulario
$documento = $_SESSION["session_username"];
$queryGrupos = $mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario = '$documento'");

while($row = $queryGrupos->fetch_assoc()){
    $idGrupo = $row['idGrupo'];
    
    $queryPermisos = $mysqli->query("SELECT * FROM permisosNotificaciones WHERE idGrupo = '$idGrupo' AND formulario = '$formulario'");
    
    $permisos = $queryPermisos->fetch_array(MYSQLI_ASSOC);
    if($permisos['plataforma'] == TRUE){
        $permisoPlataforma = $permisos['plataforma'];    
    }
    if($permisos['correo'] == TRUE){
        $permisoCorreo = $permisos['correo'];    
    }
    
}

if($permisoPlataforma == FALSE){
    $visibleP = 'none';
}else{
    $visibleP = '';
}

if($permisoCorreo == FALSE){
    $visibleC = 'none';
}else{
    $visibleC = '';
}

//////// fin notificaciones correo plataforma
?>
<!DOCTYPE html>
<html>
<head><meta charset="gb18030">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Agregar Grupo Gastos</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
  <!-- Select2 -->
  <link rel="stylesheet" href="../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
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
            <h1>Agregar Grupo Gastos</h1> 
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <l<li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Agregar Grupo Gastos</li>
            </ol>
          </div>
        </div>
        <div>
            <div class="row">
                <div class="col">
                    
                </div>
                <div class="col-9">
                    <div class="row">
                        <div class="col-sm-3">
                            <form action="presupuestoGestionar" method="POST">
                                <input value="<?php echo $idPresupuesto=$_POST['idPresupuesto']; ?>" name="idPresupuesto" type="hidden" readonly >
                                <button type="submit" class="btn btn-block btn-info btn-sm"><a href="#"><font color="white"><i class="fas fa-list"></i> Listar gesti&oacute;n presupuestos</font></a></button>
                            </form>
                        </div>
                        <div class="col-sm-3">
                            <input type="radio" id="rad_grupo" name="radiobtn" value="grupo">
                            <label for="cargo">Grupo</label>
                            <input type="radio" id="rad_subgrupo" name="radiobtn" value="subgrupo">
                            <label for="usuarios">Sub grupo</label>
                        </div>
                    </div>
                </div>
                <div class="col">
                    
                </div>
                
           
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <!-- Main content Inicia la vista de grupos -->
    <?php
    //////////// validamos la vista activa para no perder el grupo visualizado
    $idGrupo=$_POST['idGrupos'];
    $idPresupuesto=$_POST['idPresupuesto'];
    
    $subgrupo=$_POST['subgrupo'];
    
    if($subgrupo == 'grupo'){
            $visible='';
        }else{
            $visible='none';
        }
    
    ?>
    <div name="grupo" id="grupo" style="display: <?php echo $visible; ?>;">
    
    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
            <div class="col">
            </div>
            <div class="col-9">
               
       
          
          <?php
          /////////////// se valida que bot贸n entra para el formulario de editar o de agregar-....
          
          
          
          if(isset($_POST['EditarGC'])){
          ?>
               
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Editar Grupo de Gastos</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <?php 
                    $idGrupo=$_POST['idGrupos'];
                    $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                    $queryGrupo = $mysqli->query("SELECT * FROM presupuestoGruposGastos WHERE id = '$idGrupo'");
                    $datosGrupo = $queryGrupo->fetch_array(MYSQLI_ASSOC);
                    $nombreGrupo = $datosGrupo['nombreGC'];
              ?>
              <form role="form" action="controlador/presupuesto/controllerPrespuestoGestionSGC" method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label>Nombre:</label>
                    <input type="text" class="form-control"  name="nombre" value="<?php echo $nombreGrupo; ?>" placeholder="Nombre" required>
                   
                   <input type="hidden" name="idGrupos" value="<?php echo $idGrupo; ?>">
                    <input type="hidden" name="idPresupuesto" value="<?php echo $idPresupuesto; ?>">
                  </div>
                
                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                  <button type="submit" class="btn btn-primary float-right" name="EditarGC">Actualizar</button>
                </div>
              </form>
            </div>
            <?php
                }else{
            ?>
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Agregar Grupo de Costo</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="controlador/presupuesto/controllerPrespuestoGestionSGC" method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label>Nombre:</label>
                    <input type="text" class="form-control"  name="nombre" placeholder="Nombre" required min="1">
                    <input value="<?php echo $idPresupuesto; ?>" name="idPresupuesto" type="hidden" readonly>
                  </div>
                
                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                  
                  <button type="submit" class="btn btn-primary float-right" name="AgregarGC">Agregar</button>
                </div>
              </form>
            </div>
            <?php
                }
                /////////////// Fin se valida que bot贸n entra para el formulario de editar o de agregar-....
            ?>
            </div>    

        <div class="col">
            </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  
    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
            <div class="col">
            </div>
          <div class="col-9">
            <div class="card">    
        <div class="card-body table-responsive p-0" style="height: 800px;">
                <table class="table table-head-fixed text-center">
                  <thead>
                    <tr>
                      <th>Costos operativos</th>
                      <th>Sub-grupos</th>
                      <th>Editar</th>
                      <th>Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>
                     <?php
                     ////style='width:100px;' 
                     require 'conexion/bd.php';
                     $acentos = $mysqli->query("SET NAMES 'utf8'");
                     $data = $mysqli->query("SELECT * FROM presupuestoGruposGastos WHERE idPresupesto='$idPresupuesto' AND modulo='grupo'  ORDER BY nombreGC ASC")or die(mysqli_error());
                     while($row = $data->fetch_assoc()){
                    echo"<tr>";
                    $id=$row['id'];
                    
                            $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                            $queryGrupoValidacion = $mysqli->query("SELECT * FROM presupuestoGruposGastos WHERE grupo = '$id'");
                            while($datosGrupoValidacion = $queryGrupoValidacion->fetch_assoc()){
                                $idGrupooo=$datosGrupoValidacion['grupo'];
                                //utf8_decode($datosGrupoValidacion['nombreSGC']);
                    			
                            }
                    		
                            ///////////// fin del proceso
                    
                    
                    if($id != $idGrupooo){
                    echo" <td>".$row['nombreGC']."</td>";
                    }else{
                    echo" <td><form action='' method='POST' ><a href='#'>".$row['nombreGC']."</a><input type='submit' name='EditarSGC' style='border:0;' value=''></td>";
                    echo"<input type='hidden' name='idSGrupos' value= '$id' >";
                    echo"<input type='hidden' name='idPresupuesto' value= '$idPresupuesto' >";
                    echo"<input type='hidden' name='subgrupo' value= 'subgrupo' ></form>";
                    }
                    
                    echo "<td>";
                            /////////// se valida si el grupo está atado a un sub-grupo y puedas eliminarlos o editarlos
                            $queryGrupoValidacion = $mysqli->query("SELECT * FROM presupuestoGruposGastos WHERE grupo = '$id'");
                            echo "<TABLE BORDER='0' align='center'>";
                            while($datosGrupoValidacion = $queryGrupoValidacion->fetch_assoc()){
                                $idGrupo=$datosGrupoValidacion['grupo'];
                                echo "<TR> <!-- ROW 1, TABLE 2 -->
                    				<TD>".$datosGrupoValidacion['nombreSGC']."</TD>
                    			</TR>";
                            }
                    		echo "</TABLE>";
                            ///////////// fin del proceso
                    echo "</td>";
                    
                    echo"<form action='' method='POST'>";
                    echo"<input type='hidden' name='idGrupos' value= '$id' >";
                    echo"<input type='hidden' name='idPresupuesto' value= '$idPresupuesto' >";
                    echo"<input type='hidden' name='subgrupo' value= 'grupo' >";
                    echo" <td><button type='submit' name='EditarGC' class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";
                    echo"</form>";
                    /////////// se valida si el grupo está atado a un sub-grupo
                    $queryGrupoValidacion = $mysqli->query("SELECT * FROM presupuestoGruposGastos WHERE grupo = '$id'");
                    $datosGrupoValidacion = $queryGrupoValidacion->fetch_array(MYSQLI_ASSOC);
                    $validacionGrupos = $datosGrupoValidacion['grupo'];
                    
                    ///////////// fin del proceso
                    if($validacionGrupos == $id){
                    echo"<form action='agregarPresupuestoGestionarSGCValidarEliminar' method='POST'>";
                    echo"<input type='hidden' name='idGrupos' value= '$id' >";
                    echo"<input type='hidden' name='idPresupuesto' value= '$idPresupuesto' >";
                    echo"<input type='hidden' name='subgrupo' value= 'grupo' >";
                    echo" <td><button onclick='return ConfirmDelete()' type='submit' name='EliminarGC' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</button></td>";
                    echo"</form>";
                    }else{
                    echo"<form action='controlador/presupuesto/controllerPrespuestoGestionSGC' method='POST'>";
                    echo"<input type='hidden' name='idGrupos' value= '$id' >";
                    echo"<input type='hidden' name='idPresupuesto' value= '$idPresupuesto' >";
                    echo" <td><button onclick='return ConfirmDelete()' type='submit' name='EliminarGC' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</button></td>";
                    echo"</form>";    
                    }
                    
                    echo"</tr>";
                    } 
                    ?> 
                   
                  </tbody>
                </table>
              </div>
      </div>
      </div>
      <div class="col">
            </div>
      </div>
      </div>
</section>

    </div> <!-- acá finaliza la vista de grupos -->
  
    <?php
    $subgrupo=$_POST['subgrupo'];
    
    if($subgrupo == 'subgrupo'){
            $visible='';
        }else{
            $visible='none';
        }
   
    ?>
    <div name="subgrupo" id="subgrupo" style="display: <?php echo $visible;?>;">
    
    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
            <div class="col">
            </div>
            <div class="col-9">
               
       
          
          <?php
          /////////////// se valida que bot贸n entra para el formulario de editar o de agregar-....
          
          
          
          if(isset($_POST['EditarSGC'])){
          ?>
               
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Editar Sub-grupo de Costo</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <?php 
                    $idSGrupo=$_POST['idSGrupos'];
                    $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                    $queryGrupo = $mysqli->query("SELECT * FROM presupuestoGruposGastos WHERE id = '$idSGrupo'");
                    $datosGrupo = $queryGrupo->fetch_array(MYSQLI_ASSOC);
                    $nombreGrupo = $datosGrupo['nombreSGC'];
                    $Grupo = $datosGrupo['grupo'];
              ?>
              <form role="form" action="controlador/presupuesto/controllerPrespuestoGestionSGC" method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label>Grupo:</label>
                    <select type="text" class="form-control"  name="grupo" placeholder="Grupo" required>
                        <?php 
                        $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                        $queryGrupoS = $mysqli->query("SELECT * FROM presupuestoGruposGastos WHERE id='$Grupo'  ORDER BY nombreGC ASC ");
                         while($datosGrupoS = $queryGrupoS->fetch_assoc()){
                        
                        ?>
                        <option value="<?php echo $datosGrupoS['id']; ?>"><?php echo $datosGrupoS['nombreGC']; } ?></option>
                        
                        <?php
                        $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                        $queryGrupoS = $mysqli->query("SELECT * FROM presupuestoGruposGastos WHERE idPresupesto='$idPresupuesto' AND modulo='grupo'  ORDER BY nombreGC ASC ");
                         while($datosGrupoS = $queryGrupoS->fetch_assoc()){
                        
                        ?>
                        <option value="<?php echo $datosGrupoS['id']; ?>"><?php echo $datosGrupoS['nombreGC']; } ?></option>
                    </select>
                    <label>Sub-grupo:</label>
                    <input type="text" class="form-control"  name="nombre" value="<?php echo $nombreGrupo; ?>" placeholder="Nombre" required>
                   
                   <input type="hidden" name="idSGrupos" value="<?php echo $idSGrupo; ?>">
                    <input type="hidden" name="idPresupuesto" value="<?php echo $idPresupuesto; ?>">
                  </div>
                
                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                  <button type="submit" class="btn btn-primary float-right" name="EditarSGC">Actualizar</button>
                </div>
              </form>
            </div>
            <?php
                }else{
            ?>
            <div class="card card-primary" >
              <div class="card-header">
                <h3 class="card-title">Agregar Sub-grupo de Costo</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="controlador/presupuesto/controllerPrespuestoGestionSGC" method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label>Grupo:</label>
                    <select type="text" class="form-control"  name="grupo" placeholder="Grupo" required>
                        <option value="">seleccionar...</option>
                        <?php 
                        $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                        $queryGrupoS = $mysqli->query("SELECT * FROM presupuestoGruposGastos WHERE idPresupesto='$idPresupuesto' AND modulo='grupo'  ORDER BY nombreGC ASC ");
                         while($datosGrupoS = $queryGrupoS->fetch_assoc()){
                        
                        ?>
                        <option value="<?php echo $datosGrupoS['id']; ?>"><?php echo $datosGrupoS['nombreGC']; } ?></option>
                    </select>
                    <label>Sub-grupo:</label>
                    <input type="text" class="form-control"  name="nombre" placeholder="Nombre" required min="1">
                    <input value="<?php echo $idPresupuesto; ?>" name="idPresupuesto" type="hidden" readonly>
                  </div>
                
                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                  
                  <button type="submit" class="btn btn-primary float-right" name="AgregarSGC">Agregar</button>
                </div>
              </form>
            </div>
            
           
            
            
            <?php
                }
                /////////////// Fin se valida que bot贸n entra para el formulario de editar o de agregar-....
            ?>
            
            
            
            
        
            </div>    

        <div class="col">
            </div>
            
           
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  
  <?php
  if(isset($_POST['EditarSGC'])){
  ?>
    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
            <div class="col">
            </div>
          <div class="col-9">
            <div class="card">    
        <div class="card-body table-responsive p-0" style="height: 800px;">
                <table class="table table-head-fixed text-center">
                  <thead>
                    <tr>
                      <th>Grupo</th>
                      <th>Sub-grupo</th>
                      <th>Editar</th>
                      <th>Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>
                     <?php
                     require 'conexion/bd.php';
                     $acentos = $mysqli->query("SET NAMES 'utf8'");
                     $data = $mysqli->query("SELECT * FROM presupuestoGruposGastos WHERE idPresupesto='$idPresupuesto' AND modulo='subgrupo'  AND grupo='$idSGrupo' ORDER BY nombreSGC ASC")or die(mysqli_error());
                     while($row = $data->fetch_assoc()){
                 
                 
                    echo"<tr>";
                    $idGrupoS=$row['grupo'];
                    $queryGrupoC = $mysqli->query("SELECT * FROM presupuestoGruposGastos WHERE id = '$idGrupoS'");
                    $datosGrupoC = $queryGrupoC->fetch_array(MYSQLI_ASSOC);
                    echo"<td>".$datosGrupoC['nombreGC']."</td>";
                    echo" <td>".$row['nombreSGC']."</td>";
                    $id=$row['id'];
                    echo"<form action='' method='POST'>";
                    echo"<input type='hidden' name='idSGrupos' value= '$id' >";
                    echo"<input type='hidden' name='idPresupuesto' value= '$idPresupuesto' >";
                    echo"<input type='hidden' name='subgrupo' value= 'subgrupo' >";
                    echo" <td><button type='submit' name='EditarSGC' class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";
                    echo"</form>";
                    echo"<form action='controlador/presupuesto/controllerPrespuestoGestionSGC' method='POST'>";
                    echo"<input type='hidden' name='idSGrupos' value= '$id' >";
                    echo"<input type='hidden' name='idPresupuesto' value= '$idPresupuesto' >";
                    echo" <td><button onclick='return ConfirmDelete()' type='submit' name='EliminarSGC' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</button></td>";
                    echo"</form>";
                    echo"</tr>";
                 
                         
                     } 
                    ?> 
                   
                  </tbody>
                </table>
              </div>
      </div>
      </div>
      <div class="col">
            </div>
      </div>
      </div>
</section>
  <?php
  }else{
  ?>
   <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
            <div class="col">
            </div>
          <div class="col-9">
            <div class="card">    
        <div class="card-body table-responsive p-0" style="height: 800px;">
                <table class="table table-head-fixed text-center">
                  <thead>
                    <tr>
                      <th>Costos operativos</th>
                      <th>Sub-grupos</th>
                      <th>Editar</th>
                      <th>Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>
                     <?php
                     ////style='width:100px;' 
                     require 'conexion/bd.php';
                     $acentos = $mysqli->query("SET NAMES 'utf8'");
                     $data = $mysqli->query("SELECT * FROM presupuestoGruposGastos WHERE idPresupesto='$idPresupuesto' AND modulo='grupo'  ORDER BY nombreGC ASC")or die(mysqli_error());
                     while($row = $data->fetch_assoc()){
                    echo"<tr>";
                    $id=$row['id'];
                    
                    
                            $queryGrupoValidacion = $mysqli->query("SELECT * FROM presupuestoGruposGastos WHERE grupo = '$id'");
                            while($datosGrupoValidacion = $queryGrupoValidacion->fetch_assoc()){
                                $idGrupooo=$datosGrupoValidacion['grupo'];
                                //utf8_decode($datosGrupoValidacion['nombreSGC']);
                    			
                            }
                    		
                            ///////////// fin del proceso
                    
                    
                    if($id != $idGrupooo){
                    echo" <td>".$row['nombreGC']."</td>";
                    }else{
                    echo" <td><form action='' method='POST' ><a href='#'>".$row['nombreGC']."</a><input type='submit' name='EditarSGC' style='border:0;' value=''></td>";
                    echo"<input type='hidden' name='idSGrupos' value= '$id' >";
                    echo"<input type='hidden' name='idPresupuesto' value= '$idPresupuesto' >";
                    echo"<input type='hidden' name='subgrupo' value= 'subgrupo' ></form>";
                    }
                    
                    echo "<td>";
                            /////////// se valida si el grupo está atado a un sub-grupo y puedas eliminarlos o editarlos
                            $queryGrupoValidacion = $mysqli->query("SELECT * FROM presupuestoGruposGastos WHERE grupo = '$id'");
                            echo "<TABLE BORDER='0' align='center'>";
                            while($datosGrupoValidacion = $queryGrupoValidacion->fetch_assoc()){
                                $idGrupo=$datosGrupoValidacion['grupo'];
                                echo "<TR> <!-- ROW 1, TABLE 2 -->
                    				<TD>".$datosGrupoValidacion['nombreSGC']."</TD>
                    			</TR>";
                            }
                    		echo "</TABLE>";
                            ///////////// fin del proceso
                    echo "</td>";
                    
                    echo"<form action='' method='POST'>";
                    echo"<input type='hidden' name='idGrupos' value= '$id' >";
                    echo"<input type='hidden' name='idPresupuesto' value= '$idPresupuesto' >";
                    echo"<input type='hidden' name='subgrupo' value= 'grupo' >";
                    echo" <td><button type='submit' name='EditarGC' class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";
                    echo"</form>";
                    /////////// se valida si el grupo está atado a un sub-grupo
                    $queryGrupoValidacion = $mysqli->query("SELECT * FROM presupuestoGruposGastos WHERE grupo = '$id'");
                    $datosGrupoValidacion = $queryGrupoValidacion->fetch_array(MYSQLI_ASSOC);
                    $validacionGrupos = $datosGrupoValidacion['grupo'];
                    
                    ///////////// fin del proceso
                    if($validacionGrupos == $id){
                    echo"<form action='agregarPresupuestoGestionarSGCValidarEliminar' method='POST'>";
                    echo"<input type='hidden' name='idGrupos' value= '$id' >";
                    echo"<input type='hidden' name='idPresupuesto' value= '$idPresupuesto' >";
                    echo"<input type='hidden' name='subgrupo' value= 'grupo' >";
                    echo" <td><button onclick='return ConfirmDelete()' type='submit' name='EliminarGC' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</button></td>";
                    echo"</form>";
                    }else{
                    echo"<form action='controlador/presupuesto/controllerPrespuestoGestionSGC' method='POST'>";
                    echo"<input type='hidden' name='idGrupos' value= '$id' >";
                    echo"<input type='hidden' name='idPresupuesto' value= '$idPresupuesto' >";
                    echo" <td><button onclick='return ConfirmDelete()' type='submit' name='EliminarGC' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</button></td>";
                    echo"</form>";    
                    }
                    
                    echo"</tr>";
                    } 
                    ?> 
                   
                  </tbody>
                </table>
              </div>
      </div>
      </div>
      <div class="col">
            </div>
      </div>
      </div>
</section>

    </div>  <!-- acá finaliza la vista de Sub-grupos -->
  <?php
  }
  ?>
  
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
<!-- Select2 -->
<script src="../plugins/select2/js/select2.full.min.js"></script>
<!-- Page script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })
    
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

  })
</script>
<script>
    $(document).ready(function(){
        $('#rad_cargoE').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoE").html(data);
            }); 
        });
        $('#rad_usuarioE').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoE").html(data);
            }); 
        });
    });
</script>
<script>
        $(document).ready(function(){
            $('#rad_grupo').click(function(){
                
                document.getElementById('grupo').style.display = '';
                document.getElementById('subgrupo').style.display = 'none';
            });

            $('#rad_subgrupo').click(function(){
                document.getElementById('grupo').style.display = 'none';
                document.getElementById('subgrupo').style.display = '';
            });
        });
    </script>
    <script type="text/javascript">
	function ConfirmDelete(){
		var answer = confirm("Esta seguro de eliminar?");

		if(answer == true){
			return true;
		}else{
			return false;
		}
	}
</script>
</body>
</html>
<?php
}
?>