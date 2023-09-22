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
  <title>FIXWEI</title>
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
<body class="hold-transition sidebar-mini" onload="nobackbutton();" oncopy="return false" onpaste="return false">
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
            <h1>Editar Cargos  <?php  $id = $_POST['idCargos'];?></h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Editar Cargos</li>
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
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="cargos"><font color="white"><i class="fas fa-list"></i> Listar Cargos</font></a></button>
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
                
                <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <?php 
                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                    $query = $mysqli->query("SELECT * FROM cargos WHERE id_cargos = '$id'");
                    $row = $query->fetch_array(MYSQLI_ASSOC);
                    $nombre = $row['nombreCargos'];
                    $descripcion = $row['descripcionCargos'];
                    $jefeInmediato = $row['jefeInmediatoCargos'];
                    $nivel = $row['nivelCargo'];
                    
                   
                    
                ?>
                
              <form  action="controlador/cargos/controladorCargos" method="POST" role="form">
                  
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Cargos </label>
                    <input autocomplete="off" type="text" class="form-control" name ="nombreCargo"id="exampleInputEmail1" value="<?php echo $nombre; ?>" placeholder="Cargos"  onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250  || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Descripción</label>
                    <textarea type="text"  name="descripcionCargo"class="form-control" id="exampleInputPassword1" value="" placeholder="Descripción" onkeypress="return ( (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 46 ||  event.charCode == 44 || event.charCode == 58 || event.charCode == 59 || event.charCode == 13 || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 ||  event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required><?php echo $descripcion; ?></textarea>
                  </div>
                    
                  <div class="form-group">
                        <label>Jefe Inmediato</label>
                        <select class="form-control" type="text"  name="jefeInmediatoCargo" required>
                            <?php
                            if($jefeInmediato == 'N/A' || $jefeInmediato == 'No aplica'){
                            ?>     
                            <option value="N/A">No aplica</option>  
                            <?php
                            }
                            
                               
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $query = "SELECT * FROM cargos WHERE id_cargos='$jefeInmediato' ";
        						$resultado=$mysqli->query($query);
                              ?>
                              	<?php while ($columna = mysqli_fetch_array( $resultado )) { ?>
                              <option value="<?php echo $columna['id_cargos']; ?>"><?php echo $columna['nombreCargos']; ?> </option>
                              <?php 
                              	    
                              	    
                              	}
                              
                              
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $query = "SELECT * FROM cargos ORDER BY nombreCargos ";
        						$resultado=$mysqli->query($query);
                              ?>
                              	<?php while ($columna = mysqli_fetch_array( $resultado )) { 
                              	if($jefeInmediato == $columna['id_cargos']){
                              	    continue;
                              	}
                              	?>
                              <option value="<?php echo $columna['id_cargos']; ?>"><?php echo $columna['nombreCargos']; ?> </option>
                              <?php } 
                              
                              
                              
                            if($jefeInmediato == 'N/A' || $jefeInmediato == 'No aplica'){}else{
                            ?>     
                            <option value="N/A">No aplica</option>  
                            <?php
                            }
                            ?>
                            
                      </select>
                       
                    </div>
                      <label>Nivel del cargo</label>
                      <select class="form-control" type="text"  name="nivelCargo" required>
                        
                          <?php 
                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                            $query = "SELECT * FROM nivelcargo WHERE id='$nivel'";
    						$resultado=$mysqli->query($query);
                          ?>
                          	<?php while ($columna = mysqli_fetch_array( $resultado )) { ?>
                          <option value="<?php echo $columna['id']; ?>"><?php echo $columna['nivelCargo']; ?> </option>
                          <?php 
                          	    
                          	} 
                          
                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                            $query = "SELECT * FROM nivelcargo WHERE not id='$nivel' ORDER BY id";
    						$resultado=$mysqli->query($query);
                          ?>
                          	<?php while ($columna = mysqli_fetch_array( $resultado )) { ?>
                          <option value="<?php echo $columna['id']; ?>"><?php echo $columna['nivelCargo']; ?> </option>
                          <?php } ?>
                          <!--<option value="0">No aplica</option>-->
                      </select>



                <!-- /.form-group -->
              
        
                  <!--
                  
                  ACA SE AGREGAN ELEMENTOS NUEVOS
                  
                  SE PUEDE EXTRAER DE: 
                  https://fixwei.com/plataforma/pages/forms/general.html
                  https://fixwei.com/plataforma/pages/forms/advanced.html
                  https://fixwei.com/plataforma/pages/forms/editors.html
                  
                  -->
                  
                  
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                    <input type="hidden" name="idCargos" value="<?php echo $id; ?>" >
                  <button type="submit" name="EditarCargos"  class="btn btn-primary float-right">Actualizar</button>
                </div>
              </form>
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