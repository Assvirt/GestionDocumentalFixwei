<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
  
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
            <h1>Editar Grupos</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Editar Grupos</li>
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
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="grupos"><font color="white"><i class="fas fa-list"></i> Listar Grupos</font></a></button>
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
    $id = $_POST['idGrupo'];
  ?>              
       
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
                <?php 
                    $dat = $mysqli->query("SELECT * FROM grupo WHERE id = '$id'");
                    $col = $dat->fetch_array(MYSQLI_ASSOC);
                    $nombre = $col['nombre'];
                    $descripcion = $col['descripcion'];
                ?>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="controlador/grupos/controllerGrupos" method="POST"role="form">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Grupo de distribución:</label>
                    <input autocomplete="off" type="text" name ="nombre" class="form-control"  value="<?php echo $nombre; ?>" onkeypress="return ( (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 ||  event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Descripción:</label>
                    <input autocomplete="off" type="text" name="descripcion" class="form-control"  value="<?php echo $descripcion; ?>" onkeypress="return ( (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 ||  event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                  </div>
                    <div class="form-group">
                        

                  <?php
                            require_once'conexion/bd.php';
                            //$acentos2 = $mysqli->query("SET NAMES 'utf8'");
                            $rexul = $mysqli->query("SELECT idcTrabajo FROM `grupoUcTrabajo` WHERE idGrupo = '$id' ");
                            $resultado2=$mysqli->query("SELECT * FROM centrodetrabajo ORDER BY id_centrodetrabajo");
                  
                  /*
                  ?>
                  <div class="form-group">
                      <?php
                        $arrayct = array();
                        while ($columnaG = mysqli_fetch_array($rexul)) {
                            array_push($arrayct,$columnaG['idcTrabajo']);
                        }
                        
                       //var_dump($arrayct);
                      ?>
                    <label>Centros de Trabajo Asociados</label>
                    <select class="duallistbox" name="centros[]"multiple="multiple">
                        <?php
                            
                            while ($columna2 = mysqli_fetch_array( $resultado2 )) {
                                
                                if(in_array($columna2['id_centrodetrabajo'],$arrayct)){
                                    $seleccionarCt = "selected";        
                                }else{
                                    $seleccionarCt ="";
                                }
                            
                                
                            ?>
                        
                            <option value="<?php echo $columna2['id_centrodetrabajo']; ?>"<?php echo $seleccionarCt; ?>><?php echo $columna2['nombreCentrodeTrabajo']; ?> </option>
                        <?php }  ?>
                    </select>
                  </div>
                  <?php
                  */
                  ?>
                </div>
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
                <input type="hidden" name="idGrupo" value="<?php echo $id;?>">
                <div class="card-footer" >
                  <button type="submit" name="editarGrupo" class="btn btn-primary float-right">Actualizar</button>
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
<script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>
<script>
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()
</script>
</body>
</html>
<?php
}
?>