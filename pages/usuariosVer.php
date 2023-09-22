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
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge" charset=utf-8>
  <title>FIXWEI - Ver Usuario</title>
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
  <?php echo require_once'menu.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Ver Usuario</h1> 
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Ver usuario</li>
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
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="usuarios"><font color="white"><i class="fas fa-list"></i> Listar usuarios</font></a></button>
                        </div>
                    </div>
                </div>
                <div class="col">
                    
                </div>
                
           
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

                <?php 
                    $id=$_POST['idUsuario'];
                    $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                    $query = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$id'");
                    $row = $query->fetch_array(MYSQLI_ASSOC);
                    $nombre = $row['nombres'];
                    $apellidos = $row['apellidos'];
                    $tipo = $row['tipo'];
                    $documento = $row['cedula'];
                    $fechaNacimiento = $row['fechaNacimiento'];
                    $cargo = $row['cargo'];
                    $proceso = $row['proceso'];
                    $lider = $row['lider'];
                    $telefono = $row['telefono'];
                    $foto = $row['foto'];
                    //$idCentroCostos = $row['idCentroCostos'];
                    $idCentroTrabajo = $row['idCentroTrabajo'];
                    $arl = $row['arl'];
                    $eps = $row['eps'];
                    $afp = $row['afp'];
                    $correo = $row['correo'];
                    //$passw = $row['clave'];
                    ////////////////// datos del perfil
                    
                    
                  
                    //////////// datos de los cargos
                    //$acentos2 = $mysqli->query("SET NAMES 'utf8'");
                    $query = $mysqli->query("SELECT * FROM cargos WHERE id_cargos='$cargo'");
                    $row = $query->fetch_array(MYSQLI_ASSOC);
                    $nombreCargo= $row['nombreCargos'];  
                        
                    /////////// datos del proceso
                    //$acentos2 = $mysqli->query("SET NAMES 'utf8'");
                    $query = $mysqli->query("SELECT * FROM procesos WHERE id='$proceso'");
                    $row = $query->fetch_array(MYSQLI_ASSOC);
                    $nombreProceso= $row['nombre']; 

                    /////////// datos del lider
                    //$acentos2 = $mysqli->query("SET NAMES 'utf8'");
                    if($lider == 'N/A'){
                        $nombreLider='N/A';
                    }else{
                    $query = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos='$lider'");
                    $row = $query->fetch_array(MYSQLI_ASSOC);
                    $nombreLider= $row['nombreCargos'];
                    }
                    
                    /////////// datos del centro de cosos
                    //$acentos2 = $mysqli->query("SET NAMES 'utf8'");
                    $query = $mysqli->query("SELECT nombre FROM centroCostos WHERE id='$idCentroCostos'");
                    $row = $query->fetch_array(MYSQLI_ASSOC);
                    //$nombreCentroCostos= $row['nombre'];
                    
                    
                    
                    
                    
                ?>


    <section class="content">
        <div class="containet-fluid">
            <div class="row">
                <div class="col"></div>
                <div class="col-9">
                    <div class="card card-widget widget-user utf8">
                      <!-- Add the bg color to the header using any of the bg-* classes -->
                      <div class="widget-user-header bg-info">
                        <h3 class="widget-user-username utf8"><?php echo $nombre." ".$apellidos;?></h3>
                        <h5 class="widget-user-desc description-text"><?php echo $nombreCargo;?></h5>
                      </div>
                      <div class="widget-user-image">
                        <?php
                        if($foto != NULL){
                        ?>
                        <img class="img-circle elevation-2" width="100px" height="100px" src="data:image/jpg;base64, <?php echo base64_encode($foto); ?>" alt="Foto Perfil">
                        <?php
                        }else{
                        ?>
                        <img class="img-circle elevation-2" width="100px" height="100px" src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSAFdnwsj9XmZPJzlH-h95QvIm7QjUsIlHkpQ&usqp=CAU" alt="Foto Perfil">
                        <?php
                        }
                        ?>
                      </div>
                      <div class="card-footer">
                        <div class="row">
                          <div class="col-sm-4 border-right border-left ">
                            <div class="description-block">
                              <h5 class="description-header">Nombres:</h5>
                              <span class=""><?php echo $nombre;?></span>
                            </div>
                            <!-- /.description-block -->
                          </div>
                          <!-- /.col -->
                          <div class="col-sm-4 border-right utf8">
                            <div class="description-block">
                              <h5 class="description-header">Apellidos:</h5>
                              <span class=""><?php echo $apellidos;?></span>
                            </div>
                            <!-- /.description-block -->
                          </div>
                          <!-- /.col -->
                        <!-- /.col -->
                          <div class="col-sm-4 border-right">
                            <div class="description-block">
                              <h5 class="description-header">Correo electrónico:</h5>
                              <span class=""><?php echo $correo;?></span>
                            </div>
                            <!-- /.description-block -->
                          </div>
                          <!-- /.col -->
                                                    <!-- /.col -->
                          <div class="col-sm-4 border-right border-left">
                            <div class="description-block">
                              <h5 class="description-header">Teléfono:</h5>
                              <span class=""><?php echo $telefono;?></span>
                            </div>
                            <!-- /.description-block -->
                          </div>
                          <!-- /.col -->
                          <div class="col-sm-4 border-right">
                            <div class="description-block">
                              <h5 class="description-header">Documento de identidad</h5>
                              <span class=""><?php echo $documento;?></span>
                            </div>
                            <!-- /.description-block -->
                          </div>
                          <!-- /.col -->
                          <div class="col-sm-4 border-right">
                            <div class="description-block">
                              <h5 class="description-header">Fecha Nacimiento: </h5>
                              <span class=""><?php echo $fechaNacimiento;?></span>
                            </div>
                            <!-- /.description-block -->
                          </div>
                          <!-- /.col -->
                          <div class="col-sm-4 border-right border-left">
                            <div class="description-block">
                              <h5 class="description-header">Cargo:</h5>
                              <span class=""><?php echo $nombreCargo;?></span>
                            </div>
                            <!-- /.description-block -->
                          </div>
                          <!-- /.col -->
                          <div class="col-sm-4 border-right">
                            <div class="description-block">
                              <h5 class="description-header">Proceso:</h5>
                              <span class=""><?php echo $nombreProceso;?></span>
                            </div>
                            <!-- /.description-block -->
                          </div>
                          <div class="col-sm-4 border-right">
                            <div class="description-block">
                              <h5 class="description-header">Líder:</h5>
                              <span class=""><?php echo $nombreLider;?></span>
                            </div>
                            <!-- /.description-block -->
                          </div>
                          
                         
                         <div class="col-sm-4 border-right">
                            <div class="description-block">
                              <h5 class="description-header">Centro de trabajo:</h5>
                              <?php
                              $queryx = $mysqli->query("SELECT * FROM cTrabajoUusuario WHERE idUsuario = '$documento'");
                               while ($columnax = mysqli_fetch_array( $queryx )) {
                                   $ctrabajo = $columnax['idCtrabajo'];
                              /////////// datos del centro de trabajo
                            $queryz = $mysqli->query("SELECT nombreCentrodeTrabajo FROM centrodetrabajo WHERE id_centrodetrabajo='$ctrabajo'");
                            $row = $queryz->fetch_array(MYSQLI_ASSOC);
                            $nombreCentroTrabajo= $row['nombreCentrodeTrabajo'];
                               
                              ?>
                              <span class=""><?php echo $nombreCentroTrabajo;?><br></span>
                              
                              <?php }?>
                            </div>
                            <!-- /.description-block -->
                          </div>
                          <div class="col-sm-4 border-right border-left">
                            <div class="description-block">
                              <h5 class="description-header">ARL:</h5>
                              <span class=""><?php echo $arl;?></span>
                            </div>
                            <!-- /.description-block -->
                          </div>
                          <div class="col-sm-4 border-right">
                            <div class="description-block">
                              <h5 class="description-header">EPS:</h5>
                              <span class=""><?php echo $eps;?></span>
                            </div>
                            
                            <!-- /.description-block -->
                          </div>
                          <div class="col-sm-4 border-right">
                            <div class="description-block">
                              <h5 class="description-header">Grupos de distribución:</h5>
                              <?php
                              $queryz = $mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario = '$documento'");
                               while ($columnaz = mysqli_fetch_array( $queryz )) {
                                   $grupo = $columnaz['idGrupo'];
                              /////////// datos del centro de trabajo
                            $queryy = $mysqli->query("SELECT nombre FROM grupo WHERE id='$grupo'");
                            $rowy = $queryy->fetch_array(MYSQLI_ASSOC);
                            $nombreGrupo= $rowy['nombre'];
                               
                              ?>
                              <span class=""><?php echo $nombreGrupo;?><br></span>
                              
                              <?php }?>
                            </div>
                            <!-- /.description-block -->
                          </div>
                          
                          
                          <div class="col-sm-4 border-right">
                            <div class="description-block">
                              <h5 class="description-header">AFP:</h5>
                              <span class=""><?php echo $afp;?></span>
                            </div>
                            <!-- /.description-block -->
                          </div>
                          
 <div class="col-sm-4 border-right">
                            <!--<div class="description-block">
                              <h5 class="description-header">Centro de costos:</h5>
                              <span class=""><?php //echo $nombreCentroCostos;?></span>
                            </div>
                            <!-- /.description-block -->
                          </div>
                          <!-- /.col -->
                        </div>
                        </div>    
                    </div>
        </div>
        <div class="col"></div>
    </section>

    <!-- Main content -->
    
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
<script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>
</body>
</html>
<?php
}
?>