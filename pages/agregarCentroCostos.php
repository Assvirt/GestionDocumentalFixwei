<?php error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
   require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';

///////// notificaciones para plataforma y correo
require_once 'conexion/bd.php';
$formulario = 'centroCostos'; //Se cambia el nombre del formulario
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
            <h1>Centros de Costos</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Centros de Costos</li>
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
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="centroCostos"><font color="white"><i class="fas fa-list"></i> Listar Centro de costos</font></a></button>
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
              <form role="form" action="controlador/centroCostos/controllerCentroCostos" method="POST">
                  
                <div class="card-body">
                    <!-- parametros para la activacion de correo y plataforma -->
                    <div class="row"> 
                        <div class="form-group col-sm-6">
                          <input name="usuarioActividad" value="<?php echo $sesion;?>" type="hidden" readonly>
                          <!--<label>Notificaciones por: </label>&nbsp;&nbsp;-->
                              <?php if($visibleP != 'none'){ ?>
                              
                               <!-- <label>Plataforma</label>-->
                                    <input style="border:0px;" name="plataforma" value="1" type="hidden" readonly>
                                <?php }else{  }
                          
                              if($visibleP != 'none' && $visibleC != 'none'){
                                   '-';
                              }
                          
                                    if($visibleC != 'none'){ ?>
                               <!-- <label>Correo</label>-->
                                    <input style="border:0px;" name="correo" value="1" type="hidden" readonly>
                                <?php }else{  } ?>
                        </div>
                    </div>
                <!-- Fin parametros para la activacion de correo y plataforma -->

                  <div class="form-group">
                    <label for=""> Código:</label>
                    <input autocomplete="off" type="text" class="form-control" name="codigo" placeholder="Código" onkeypress="return ( (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 ||  event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218 || (event.charCode >= 48 && event.charCode <= 57) )" required>
                  </div>
                  <div class="form-group">
                    <label for="">Prefijo:</label>
                    <input autocomplete="off" type="text" class="form-control" name="prefijo" placeholder="Prefijo" onkeypress="return ( (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218 || (event.charCode >= 48 && event.charCode <= 57) )" required>
                  </div>
                  <div class="form-group">
                    <label for="">Centro de costo:</label>
                    <input autocomplete="off" type="text" class="form-control" name="nombre" placeholder="Centro de costo" onkeypress="return ( (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250  || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                  </div>
                  <?php
                            require_once'conexion/bd.php';
                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                            $resultado=$mysqli->query("SELECT * FROM cargos ORDER BY nombreCargos");
                  ?>
               
                  <div class="form-group">
                        <label>Cargo del Dueño del Centro de Costos:</label>
                        <select class="form-control" name="cargo" required>
                        <option value=""></option>
                          <?php
                        while ($columna = mysqli_fetch_array( $resultado )) { ?>
                        <option value="<?php echo $columna['id_cargos']; ?>"><?php echo $columna['nombreCargos']; ?> </option>
                <?php }  ?>
                        </select>
                    </div>
                    
                    <?php
                    /// validamos, si existen usuarios, debe mostrar este campo, pero si no, este campo no aparece
                    $recorridoUsuarios=$mysqli->query("SELECT count(*) FROM usuario ");
                    $respuestaRecorridoUsuarios=$recorridoUsuarios->fetch_array(MYSQLI_ASSOC);
                    //if($respuestaRecorridoUsuarios['count(*)'] > '0'){
                    ?>
                    
                    <div class="form-group">
                        <label>Persona responsable:</label>
                        <select class="form-control" name="persona" required>
                            <option value=""></option> 
                          <?php
                          $acentos = $mysqli->query("SET NAMES 'utf8'");
                            $resultado=$mysqli->query("SELECT * FROM usuario ORDER BY nombres");
                        while ($columna = mysqli_fetch_array( $resultado )) { ?>
                        <option value="<?php echo $columna['id']; ?>"><?php echo $columna['nombres'].' '. $columna['apellidos']; ?> </option>
                        <?php }  ?>
                        </select>
                    </div>
                    <?php
                    /*}else{
                        
                    }*/
                            require_once'conexion/bd.php';
                            $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                            $resultado2=$mysqli->query("SELECT * FROM centrodetrabajo ORDER BY nombreCentrodeTrabajo");
                  ?>
                    <div class="form-group">
                        <label>Centro de Trabajo</label>
                        <select class="form-control" name="cTrabajo" required>
                            <option value=""></option>
                           <?php
                        while ($columna2 = mysqli_fetch_array( $resultado2 )) { ?>
                        <option value="<?php echo $columna2['id_centrodetrabajo']; ?>"><?php echo $columna2['nombreCentrodeTrabajo']; ?> </option>
                <?php }  ?>
                        </select>
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

                <div class="card-footer" >
                  <button type="submit" name="agregarCC" class="btn btn-primary float-right">Agregar</button>
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