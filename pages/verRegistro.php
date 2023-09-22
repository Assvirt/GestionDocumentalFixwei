<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
$idDocumento = $_POST['idDocumento'];

if(isset($_POST['idRegistro'])){
    $idRegistro = $_POST['idRegistro'];
}

if(isset($_GET['idRegistro'])){
    $idRegistro = $_GET['idRegistro'];
}

$celdulaUser = $_SESSION['session_username']; 
$cargoID = $_SESSION['session_cargo']; 
$idUsuario = $_SESSION['session_idUsuario'];
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Ver Registros</title>
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
  <!--CKeditor-->
  <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
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
            <h1>Ver Registros</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Ver Registros</li>
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
                            <form action='listaRegistros' method='POST'>
                                <input type='hidden' name='ruta' value='<?php echo $_POST['ruta']?>'>
                                <button type="submit" class="btn btn-block btn-info btn-sm"><font color="white"><i class="fas fa-list"></i> Registros </font></button>
                            </form>
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
                    
                    //$acentos = $mysqli->query("SET NAMES 'utf8'");
                    $registros = $mysqli->query("SELECT * FROM registros WHERE id = $idRegistro");
                    $n = 1;
                     
                        //echo $n++;
                    
                
                ?>
                <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Ver Registros</h3>
              </div>
              <!-- /.card-header -->
              <?php
                    while($col = $registros->fetch_assoc()) {
                        
                        $carpeta = $col['carpeta'];
                        $documento = $col['nombreDocumento'];
                        $html = $col['html'];
                        $rutaArchivo = $carpeta.$documento;
                        
                        $aprobador= $col['aprobador'];
                        
                        $idProceso = $col['idProceso'];
                        $idTipoDocumento = $col['idTipoDocumento'];
                        
                        $idResponsable = $col['idResponsable'];
                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                        $queryConsultaProcesos=$mysqli->query("SELECT nombres, apellidos FROM usuario WHERE cedula = $idResponsable ");
    	                $rowConsultaP=$queryConsultaProcesos->fetch_array(MYSQLI_ASSOC);
    	                $responsable = utf8_decode($rowConsultaP['nombres'])." ".utf8_decode($rowConsultaP['apellidos']);
                        
                        $aprobador = $col['aprobador'];
                        $aprobadorID = json_decode($col['aprobadorID']);
                        $longitudA = count($aprobadorID);
                        
                        
                        
                        if($idProceso == NULL && $idTipoDocumento == NULL ){
                            $proceso = "<b>No Aplica</b>";
                            $tipoDocumento = "<b>No Aplica</b>";
                        }else{
                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                            $queryConsultaProcesos=$mysqli->query("SELECT nombre FROM procesos WHERE id = $idProceso ");
    	                    $rowConsultaP=$queryConsultaProcesos->fetch_array(MYSQLI_ASSOC);
    	                    $proceso = $rowConsultaP['nombre'];
    	                    
    	                    $acentos = $mysqli->query("SET NAMES 'utf8'");
    	                    $queryTipoDoc=$mysqli->query("SELECT nombre FROM tipoDocumento WHERE id = $idTipoDocumento ");
    	                    $rowConsultaTD=$queryTipoDoc->fetch_array(MYSQLI_ASSOC);
    	                    $tipoDocumento = $rowConsultaTD['nombre'];
    	                    
                        }
                        
              ?>
              
              <!-- form start -->
                  <input name="usuarioActividad" value="<?php echo $sesion;?>" type="hidden">
                <div class="card-body">
                    <div class="form-group">
                        <label>Nombre:</label>
                        <?php echo $col['nombre'] ?>
                    </div>
                    
                    
                    <div class="form-group">
                        <label>Proceso:</label>
                        <?php echo $proceso ?>
                    </div>
                    
                    <div class="form-group">
                        <label>Tipo documento:</label>
                        <?php echo $tipoDocumento ?>
                    </div>
                    
                    <div class="form-group">
                        <label>Centro de trabajo:</label>
                        <?php
                            $idCentroTrabajo = json_decode($col['idCentroTrabajo']);
                            $longitudCT = count($idCentroTrabajo);
                            for($i=0; $i<$longitudCT; $i++){
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $nombrect = $mysqli->query("SELECT nombreCentrodeTrabajo FROM centrodetrabajo WHERE id_centrodetrabajo = '$idCentroTrabajo[$i]'");
                                $columnact = $nombrect->fetch_array(MYSQLI_ASSOC);
                                    
                                echo $columnact['nombreCentrodeTrabajo'];echo "<br>";
                            }
                            
                        ?>
                    </div>
                    
                    <div class="form-group">
                        <label>Responsable:</label>
                        <?php echo utf8_encode($responsable); ?>
                    </div>
                    
                    <div class="form-group">
                        <label>Aprobador:</label>
                        <?php
                                
                                $verAprobar = FALSE;
                                
                                if($aprobador == 'usuarios'){
                                    
                                    if(in_array($idUsuario,$aprobadorID)){
                                        $verAprobar = TRUE;
                                    }
                                    
                                    for($i=0; $i<$longitudA; $i++){
                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                        $nombreuser3 = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$aprobadorID[$i]'");
                                        $columna3 = $nombreuser3->fetch_array(MYSQLI_ASSOC);
                                    
                                        echo $columna3['nombres']." ".$columna3['apellidos'];echo "<br>";
                                     
                                    }
                                 
                                }
                                
                                if($aprobador == 'cargos'){
                                    
                                    if(in_array($cargoID,$aprobadorID)){
                                        $verAprobar = TRUE;
                                    }
                                    
                                    for($i=0; $i<$longitudA; $i++){
                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                    $nombrecargo3 = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$aprobadorID[$i]'");
                                    $columna3 = $nombrecargo3->fetch_array(MYSQLI_ASSOC);
                                    echo $columna3['nombreCargos'];echo "<br>";
                                    }
                                }
                                
                                if($aprobador == NULL){
                                    echo "<b>No aplica</b>";
                                }
                        
                        
                        ?>
                    </div>
                    
                    
                    <div class="form-group">
                        <label>Estado:</label>
                        <?php echo $col['estado'] ?>
                    </div>
                    <?php 
                        if($documento != NULL){
                    ?>
                    <div class="form-group">
                        <label>Documento:</label>
        
                        <button type='button'  class='btn btn-warning btn-sm'>
                            <i class='fas fa-download'></i>
                            <a style='color:black' href='<?php echo $rutaArchivo;?>' target="_blank">Descargar Registro</a>
                        </button>
                    </div>
                    <?php echo $rutaArchivo; } ?>
                    <?php 
                        if($html != NULL){
                    ?>
                    <div class="form-group">
                        <label>Registro HTML:</label>
                        <div><?php echo $html;?></div>
                    </div>
                    <?php } 
                    
                    
                    
                    
                    if($verAprobar == TRUE){
                    ?>
                    
                    <div class="form-group">
                        <form action="controlador/registros/controller.php" method="POST">
                            <label>Aprobar resgistro:</label>
                            <br>
                            <label><input type="radio" value="Aprobado" name="estado" required> Aprobado</label>
                            <label><input type="radio" value="Rechazado" name="estado" required> Rechazado</label>
                            <div>
                                <input type="hidden" name="idRegistro" value="<?php echo $idRegistro; ?>">
                                <input type="hidden" name="idDocumento" value="<?php echo $idDocumento; ?>">
                                <button type="submit" name="actualizarEstado" class="btn btn-primary btn-sm">Actualizar</button>
                            </div>
                        </form>                    
                    </div>
                    
                    <?php } ?>
                    
                    <div class="form-group">
                        <form action="controlador/registros/controller.php" method="POST">
                            <label>Control de cambios: </label>
                
                            <textarea rows="2" class="form-control" name="comentario" placeholder="Control de cambios"></textarea>
                            <br>
                            <div>
                                <input type="hidden" name="idRegistro" value="<?php echo $idRegistro; ?>">
                                <input type="hidden" name="idDocumento" value="<?php echo $idDocumento; ?>">
                                <button type="submit" name="controlCambio" class="btn btn-primary btn-sm">Agregar</button>
                            </div>
                        </form>
                    </div>

                    <div class="form-group">

                        <div class="card-body">
                            <div style="padding: 20px;" class="tab-pane" id="timeline">
                                <!-- The timeline -->
                                <div class="timeline timeline-inverse">
                                    <!-- timeline time label -->
                                    <?php 
                                      
                                      $queryControl = $mysqli->query("SELECT * FROM controlCambioRegistros WHERE idRegistro = $idRegistro")or die(mysqli_error($mysqli));
                                      
                                      while($row = $queryControl->fetch_assoc()){
                                          $idUser = $row['usuario'];
                                          $acentos = $mysqli->query("SET NAMES 'utf8'");
                                          $queryUser = $mysqli->query("SELECT * FROM usuario WHERE cedula = $idUser ")or die(mysqli_error($mysqli));
                                          $datosUser = $queryUser->fetch_assoc();
                                          $nombreUsuario = $datosUser['nombres']." ".$datosUser['apellidos'];
                                                                
                                    ?>
                                                          
                                <div class="time-label">
                                     <span class="bg-danger">
                                    <?php echo $row['fecha']?>
                                  </span>
                                </div>
                
                                <div>
                                  <i class="fas fa-user bg-info"></i>
                                    
                                  <div class="timeline-item">
                                                              
                                  <h3 class="timeline-header border-0"><a href="#"><?php echo $nombreUsuario?></a> <?php echo $row['comentario']?></h3>
                                    </div>
                                </div>
                                <?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                  
                </div>
                <!-- /.card-body -->
                <?php } ?>
                <div class="card-footer" >
                </div>
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
<!--Ckeditor-->
<script>
    CKEDITOR.replace( 'editor1' );
</script>
<!-- bs-custom-file-input -->
<script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
</body>
</html>
<?php
}
?>