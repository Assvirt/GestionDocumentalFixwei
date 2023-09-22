<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
?>
<!DOCTYPE html>
<html>
<head><meta charset="gb18030">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Ver Usuarios</title>
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
             <h1>Ver Grupo</h1>
             <?php $id = $_POST['idGrupo'];?>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Ver grupo</li>
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
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="grupos"><font color="white"><i class="fas fa-list"></i> Listar grupos</font></a></button>
                        </div>
                    </div>
                </div>
                <div class="col">
                    
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
            <div class="col">
            </div>
            <div class="col-9">
                <?php 
                    require 'conexion/bd.php';
                    $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                    $grupo = $mysqli->query("SELECT * FROM grupo WHERE id = '$id'");
                    $row = $grupo->fetch_array(MYSQLI_ASSOC);
                    $nombre = $row['nombre'];
                    $descripcion = $row['descripcion'];
                ?>
                <div class="card card-primary">
              <div class="card-header">
                
              </div>
              <!-- /.card-header -->
              <!-- form start -->
             
                <div class="card-body">
                  <div class="form-group">
                    <label>Grupo de distribución:</label>
                   <?php echo $nombre; ?>
                  </div>
                  <div class="form-group">
                    <label>Descripción:</label>
                    <?php echo $descripcion; ?>
                  </div>
                <?php
                /*
                ?>
                  <div class="form-group">
                  <label>Centros de Trabajo:</label>
                  
                  <?php
                    $centrosT = $mysqli->query("SELECT * FROM grupoUcTrabajo WHERE idGrupo = '$id'");
                    while($rows = $centrosT->fetch_assoc()){
                        
                        $centroid = $rows['idcTrabajo'];
                        
                        $centrosN = $mysqli->query("SELECT nombreCentrodeTrabajo FROM centrodetrabajo WHERE id_centrodetrabajo = '$centroid'");
                        $nombresC = $centrosN->fetch_array(MYSQLI_ASSOC);
                        $centrosNombres = $nombresC['nombreCentrodeTrabajo'];
                        
                        
                        echo $centrosNombres."<br>";
                        
                        
                        
                    }
                  ?>
                  </div>
                  <?php
                  */
                  ?>
                     <div class="form-group">
                  <label>Usuarios:</label>
                  <br>
                  <?php
                    $centrosT = $mysqli->query("SELECT * FROM grupoUusuario WHERE idGrupo = '$id'");
                    while($rows = $centrosT->fetch_assoc()){
                        
                        $idUsuario = $rows['idUsuario'];
                        
                        $centrosN = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$idUsuario'");
                        $nombresC = $centrosN->fetch_array(MYSQLI_ASSOC);
                        echo '<b>*</b>'.$nombresC['nombres'].' '.$nombresC['apellidos'].'<br>';
                    
                        
                    }
                  ?>
                  </div>
                  
                
                  <!--
                  
                  ACA SE AGREGAN ELEMENTOS NUEVOS
                  
                  SE PUEDE EXTRAER DE: 
                  https://fixwei.com/plataforma/pages/forms/general.html
                  https://fixwei.com/plataforma/pages/forms/advanced.html
                  https://fixwei.com/plataforma/pages/forms/editors.html
                  
                  -->
                  
                  
                  
                </div>
                <!-- /.card-body -->

                
             
            </div>
            </div>    

        <div class="col">
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