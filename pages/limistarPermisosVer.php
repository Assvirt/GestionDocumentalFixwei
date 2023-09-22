<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
require 'conexion/bd.php';

$root = $_SESSION['session_root'];

if($root == 1){

}else{
    echo '<script language="javascript">window.location.href="accesoDenegado"</script>';
}



$idGrupo = $_POST['id'];
$acentos = $mysqli->query("SET NAMES 'utf8'");
$queryGrupo = $mysqli->query("SELECT * FROM permisosCliente WHERE id ='$idGrupo'");
$rowNombre = $queryGrupo->fetch_array(MYSQLI_ASSOC);
$nomGrupo = strtoupper($rowNombre['cliente']);

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
            <h1>PERMISOS DEL CLIENTE <?php echo $nomGrupo;?></h1>
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
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="limitarPermisos"><font color="white"><i class="fas fa-list"></i> Listar Clientes</font></a></button>
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
                    <form action="controlador/controllerPermisosCliente" method="POST"> 
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">MÓDULOS</h3>
            
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                              <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                <i class="fas fa-times"></i></button>
                            </div>
                          </div>
                          <?php
                          if($_POST['id'] == '1'){
                            require_once 'conexion/bd.php';
                          }elseif($_POST['id'] == '2'){
                             require_once '../../RMS/pages/conexion/bd.php';  
                          }
                          
                          
                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                            $data = $mysqli->query("SELECT * FROM permisosCliente WHERE id = '$idGrupo' ");
                          ?>
                          <div class="card-body">
                              
                            <h6 style="text-align:right;"><input type="checkbox" id="selectall" /> Marcar / Desmarcar Todos</h6>
                                
                            <?php
                            // comprobamos que exista un grupo de distribución creado
                            $consultandoGrupos=$mysqli->query("SELECT count(*) FROM grupo ");
                            $extraerConsuktandoGrupos=$consultandoGrupos->fetch_array(MYSQLI_ASSOC);
                            
                            if($extraerConsuktandoGrupos['count(*)'] > 0){
                            ?>  
                                <table class="table table-bordered text-center">
                                    <thead>                  
                                        <tr>
                                          <th>Módulo</th>
                                          <th style="width: 10px">Listar</th>
                                        </tr>
                                    </thead>
                                      <tbody>
                                        <?php
                                            while($row = $data->fetch_assoc()){
                                                
                                                if($row['permiso1']==TRUE){
                                                    $checkListar1 = "checked";
                                                }else{
                                                    $checkListar1 = "";
                                                }
                                                if($row['permiso2']==TRUE){
                                                    $checkListar2 = "checked";
                                                }else{
                                                    $checkListar2 = "";
                                                }
                                                if($row['permiso3']==TRUE){
                                                    $checkListar3 = "checked";
                                                }else{
                                                    $checkListar3 = "";
                                                }
                                                if($row['permiso4']==TRUE){
                                                    $checkListar4 = "checked";
                                                }else{
                                                    $checkListar4 = "";
                                                }
                                                if($row['permiso5']==TRUE){
                                                    $checkListar5 = "checked";
                                                }else{
                                                    $checkListar5 = "";
                                                }
                                                if($row['permiso6']==TRUE){
                                                    $checkListar6 = "checked";
                                                }else{
                                                    $checkListar6 = "";
                                                }
                                                
                                                echo"<tr>";
                                                echo "<td style='text-align: left;'>";
                                                    if($row['permiso1'] == TRUE || $row['permiso1'] == FALSE ){
                                                       echo 'CONFIGURACIÓN'; 
                                                       //// consultamos la tabla de permisos para traer todos los permisos activos de configuración
                                                       $consultarTablaFormulario=$mysqli->query("SELECT * FROM `formularios` WHERE modulo='config'");
                                                       while($extraerConsultaTablaFormulario=$consultarTablaFormulario->fetch_array()){
                                                           $subconsultaPermisos=$mysqli->query("SELECT * FROM permisos WHERE formulario='".$extraerConsultaTablaFormulario['idFormulario']."' ");
                                                           $extraerSubconsultaPermisos=$subconsultaPermisos->fetch_array(MYSQLI_ASSOC);
                                                           $sumandoConfig+=$extraerSubconsultaPermisos['listar']; 
                                                       }
                                                    }
                                                echo "</td>";
                                                if($sumandoConfig > 0){
                                                    echo "<td><input class='case' name='permiso1' value='1' type='checkbox' ".$checkListar1."></td>";
                                                }else{
                                                    echo "<td><input class='case' name='permiso1' value='1' type='checkbox' ></td>";
                                                }
                                                echo"</tr>";
                                                
                                                echo"<tr>";
                                                echo "<td style='text-align: left;'>";
                                                    if($row['permiso2'] == TRUE || $row['permiso2'] == FALSE ){
                                                       echo 'GESTIÓN DOCUMENTAL'; 
                                                       //// consultamos la tabla de permisos para traer todos los permisos activos de GD
                                                       $consultarTablaFormulario=$mysqli->query("SELECT * FROM `formularios` WHERE modulo='gestionDoc'");
                                                       while($extraerConsultaTablaFormulario=$consultarTablaFormulario->fetch_array()){
                                                           $subconsultaPermisos=$mysqli->query("SELECT * FROM permisos WHERE formulario='".$extraerConsultaTablaFormulario['idFormulario']."' ");
                                                           $extraerSubconsultaPermisos=$subconsultaPermisos->fetch_array(MYSQLI_ASSOC);
                                                           $sumandoGD+=$extraerSubconsultaPermisos['listar']; 
                                                       }
                                                    }
                                                echo "</td>";
                                                if($sumandoGD > 0){
                                                    echo "<td><input class='case' name='permiso2' value='1' type='checkbox' ".$checkListar2."></td>";
                                                }else{
                                                    echo "<td><input class='case' name='permiso2' value='1' type='checkbox' ></td>";
                                                }
                                                echo"</tr>";
                                                
                                                echo"<tr>";
                                                echo "<td style='text-align: left;'>";
                                                    if($row['permiso3'] == TRUE || $row['permiso3'] == FALSE){
                                                       echo 'REPOSITORIO'; 
                                                       //// consultamos la tabla de permisos para traer todos los permisos activos de Repositorio
                                                       $consultarTablaFormulario=$mysqli->query("SELECT * FROM `formularios` WHERE modulo='Repositorio'");
                                                       while($extraerConsultaTablaFormulario=$consultarTablaFormulario->fetch_array()){
                                                           $subconsultaPermisos=$mysqli->query("SELECT * FROM permisos WHERE formulario='".$extraerConsultaTablaFormulario['idFormulario']."' ");
                                                           $extraerSubconsultaPermisos=$subconsultaPermisos->fetch_array(MYSQLI_ASSOC);
                                                           $sumandoRepositorio+=$extraerSubconsultaPermisos['listar']; 
                                                       }
                                                    }
                                                echo "</td>";
                                                if($sumandoRepositorio > 0){
                                                    echo "<td><input class='case' name='permiso3' value='1' type='checkbox' ".$checkListar3."></td>";
                                                }else{
                                                    echo "<td><input class='case' name='permiso3' value='1' type='checkbox' ></td>";
                                                }
                                                echo"</tr>";
                                                
                                                echo"<tr>";
                                                echo "<td style='text-align: left;'>";
                                                    if($row['permiso4'] == TRUE || $row['permiso4'] == FALSE){
                                                       echo 'INDICADORES'; 
                                                       //// consultamos la tabla de permisos para traer todos los permisos activos de indicadores
                                                       $consultarTablaFormulario=$mysqli->query("SELECT * FROM `formularios` WHERE modulo='indi'");
                                                       while($extraerConsultaTablaFormulario=$consultarTablaFormulario->fetch_array()){
                                                           $subconsultaPermisos=$mysqli->query("SELECT * FROM permisos WHERE formulario='".$extraerConsultaTablaFormulario['idFormulario']."' ");
                                                           $extraerSubconsultaPermisos=$subconsultaPermisos->fetch_array(MYSQLI_ASSOC);
                                                           $sumandoIndi+=$extraerSubconsultaPermisos['listar']; 
                                                       }
                                                    }
                                                echo "</td>";
                                                if($sumandoIndi > 0){
                                                    echo "<td><input class='case' name='permiso4' value='1' type='checkbox' ".$checkListar4."></td>";
                                                }else{
                                                    echo "<td><input class='case' name='permiso4' value='1' type='checkbox' ></td>";
                                                }
                                                echo"</tr>";
                                                
                                                echo"<tr>";
                                                echo "<td style='text-align: left;'>";
                                                    if($row['permiso5'] == TRUE || $row['permiso5'] == FALSE){
                                                       echo 'ACTAS E INFORMES'; 
                                                       //// consultamos la tabla de permisos para traer todos los permisos activos de actas
                                                       $consultarTablaFormulario=$mysqli->query("SELECT * FROM `formularios` WHERE modulo='actas'");
                                                       while($extraerConsultaTablaFormulario=$consultarTablaFormulario->fetch_array()){
                                                           $subconsultaPermisos=$mysqli->query("SELECT * FROM permisos WHERE formulario='".$extraerConsultaTablaFormulario['idFormulario']."' ");
                                                           $extraerSubconsultaPermisos=$subconsultaPermisos->fetch_array(MYSQLI_ASSOC);
                                                           $sumandoActas+=$extraerSubconsultaPermisos['listar']; 
                                                       }
                                                    }
                                                echo "</td>";
                                                if($sumandoActas > 0){
                                                    echo "<td><input class='case' name='permiso5' value='1' type='checkbox' ".$checkListar5."></td>";    
                                                }else{
                                                    echo "<td><input class='case' name='permiso5' value='1' type='checkbox' ></td>";
                                                }
                                                echo"</tr>";
                                                
                                                echo"<tr>";
                                                echo "<td style='text-align: left;'>";
                                                    if($row['permiso6'] == TRUE || $row['permiso6'] == FALSE){
                                                       echo 'COMPRAS'; 
                                                       //// consultamos la tabla de permisos para traer todos los permisos activos de compras
                                                       $consultarTablaFormulario=$mysqli->query("SELECT * FROM `formularios` WHERE modulo='compras'");
                                                       while($extraerConsultaTablaFormulario=$consultarTablaFormulario->fetch_array()){
                                                           $subconsultaPermisos=$mysqli->query("SELECT * FROM permisos WHERE formulario='".$extraerConsultaTablaFormulario['idFormulario']."' ");
                                                           $extraerSubconsultaPermisos=$subconsultaPermisos->fetch_array(MYSQLI_ASSOC);
                                                           $sumandoCompras+=$extraerSubconsultaPermisos['listar']; 
                                                       }
                                                    }
                                                echo "</td>";
                                                if($sumandoCompras > 0){
                                                    echo "<td><input class='case' name='permiso6' value='1' type='checkbox' ".$checkListar6."></td>";
                                                }else{
                                                    echo "<td><input class='case' name='permiso6' value='1' type='checkbox' ></td>";
                                                }
                                                echo"</tr>";
                                            }
                                        ?>
                                      </tbody>
                                </table>
                            <?php
                            }else{
                            ?>
                                    <div class="form-group col-md-12">
                                        <center>
                                            
                                                <div class="modal-dialog">
                                                <div class="modal-content bg-danger">
                                                    <div class="modal-header">
                                                    <h4 class="modal-title">Alerta</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    </button>
                                                    </div>
                                                    <div class="modal-body">
                                                    <p>Debe crear al menos un grupo de distribución.</p>
                                                    </div>
                                                <div class="modal-footer justify-content-between">
                                                </div>
                                                </div>
                                                </div>
                                        </center>
                                    </div>
                            <?php
                            }
                            ?>
                                
                                
                          </div>
                          <!-- /.card-body -->
                          <div class="card-footer">
                              <!-- Envio de variables ocultas -->
                              <input type="hidden" name="id" value="<?php echo $idGrupo ?>">
                              
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