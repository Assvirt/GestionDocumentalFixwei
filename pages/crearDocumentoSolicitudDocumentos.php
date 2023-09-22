<?php
error_reporting(E_ERROR); 
session_start();
if(!isset($_SESSION["session_username"])){
    //header("login");
    require_once'cierreSesion.php';
}else{
//require_once 'inactividad.php';

$usuario = $_SESSION["session_username"];


///////// notificaciones para plataforma y correo
require_once 'conexion/bd.php';
$formulario = 'solicitudDocumentos'; //Se cambia el nombre del formulario
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
  <title>FIXWEI - Solicitud documentos</title>
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
            <h1>Nuevo Documento Vigente</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Nuevo Documento Vigente</li>
            </ol>
          </div>
        </div>
        <div>

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
                <?php
                    $tipo = $_POST['tipo'];
                    
                    if($tipo == 1){
                        $selectCrear = "selected";    
                    }else{
                        $selectCrear = "";
                    }
                    
                    if($tipo == 3){
                        $selectEliminar = "selected";    
                    }else{
                        $selectEliminar = "";
                    }
                    
                    if($tipo == 2){
                        $selectActualizar = "selected";    
                    }else{
                        $selectActualizar = "";
                    }
                    
                ?>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="" method="POST">
                <div class="card-body">
                   

                  <div class="form-group">
                        <label>Tipo Solicitud:</label>
                        <select class="form-control" name="tipo" onchange = "this.form.submit()" required>
                          <option value="1" <?php echo $selectCrear?> >Crear</option>
                        </select>
                        <!--
                         <option value="2" <?php echo $selectActualizar?> >Actualizar</option>
                          <option value="3" <?php echo $selectEliminar?> >Eliminar</option>
                        -->
                    </div>
                </form>    
                    
              
              <form action="controlador/solicitudDocumentos/controllerVigente" method="post" enctype="multipart/form-data">
                  
                  <!-- parametros para la activacion de correo y plataforma -->
                    <div class="row"> 
                        <div class="form-group col-sm-6">
                          <input name="usuarioActividad" value="<?php echo $sesion;?>" type="hidden" readonly>
                          <!--<label>Notificaciones por: </label>&nbsp;&nbsp;-->
                              <?php if($visibleP != 'none'){ ?>
                              
                                <!--<label>Plataforma</label>-->
                                    <input style="border:0px;" name="plataforma" value="1" type="hidden" readonly>
                                <?php }else{  }
                          
                              if($visibleP != 'none' && $visibleC != 'none'){
                                   '-';
                              }
                          
                                    if($visibleC != 'none'){ ?>
                                <!--<label>Correo</label>-->
                                    <input style="border:0px;" name="correo" value="1" type="hidden" readonly>
                                <?php }else{  } ?>
                        </div>
                    </div>
                <!-- Fin parametros para la activacion de correo y plataforma -->
                  
                  
                    <label>Documento:</label>
                    <input class="form-control" type="text"  name="nombre">    
                    <div class="form-group"><br>
                        <label>Proceso:</label>&nbsp;&nbsp;
                        Activos
                            <input type="radio" id="procesosActivos" name="validandoProcesos" required>
                            &nbsp;&nbsp;
                        Eliminados
                            <input type="radio" id="procesosEliminados" name="validandoProcesos" required>
                       
                        <select name="procesoA" class="form-control" style="display:none;" id="procesosActivosSelect">
                            <option value=""></option>
                            <?php
                            require_once'conexion/bd.php';
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $resultado=$mysqli->query("SELECT * FROM procesos WHERE estado IS NULL ORDER BY nombre ASC");
                            while ($columna = mysqli_fetch_array( $resultado )) { ?>
                            <option value="<?php echo $columna['id']; ?>"><?php echo $columna['nombre']; ?> </option>
                            <?php }  ?>
                        </select>
                        
                        <select name="procesoB" class="form-control" style="display:none;" id="procesosEliminadoSelect">
                            <option value=""></option>
                            <?php
                            require_once'conexion/bd.php';
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $resultado=$mysqli->query("SELECT * FROM procesos WHERE estado='Eliminado' ORDER BY nombre ASC");
                            while ($columna = mysqli_fetch_array( $resultado )) { ?>
                            <option value="<?php echo $columna['id']; ?>"><?php echo $columna['nombre']; ?> </option>
                            <?php }  ?>
                        </select>
                        
                        <script> //// validación para cambiar de proceso
                            $(document).ready(function(){
                                $('#procesosEliminados').click(function(){
                                    document.getElementById('procesosActivosSelect').style.display = 'none';
                                    document.getElementById('procesosEliminadoSelect').style.display = '';
                                });
                                 $('#procesosActivos').click(function(){
                                    document.getElementById('procesosActivosSelect').style.display = '';
                                    document.getElementById('procesosEliminadoSelect').style.display = 'none';
                                });
                            });
                        </script>
                        
                    </div>
                    <?php
                            require_once'conexion/bd.php';
                            $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                            $resultados=$mysqli->query("SELECT * FROM tipoDocumento ORDER BY nombre ASC");
                    ?>
                    <div class="form-group">
                        <label>Tipo de documento:</label>
                        <select name="tipoDoc" class="form-control">
                          <?php
                        while ($columnas = mysqli_fetch_array( $resultados )) { ?>
                        <option value="<?php echo $columnas['id']; ?>"><?php echo $columnas['nombre']; ?> </option>
                           <?php }  ?>
                        </select>
                    </div>
                    <?php
                            require_once'conexion/bd.php';
                            $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                            $resultado2=$mysqli->query("SELECT * FROM cargos ORDER BY nombreCargos ASC");
                    ?>
                    <div class="form-group">
                        <label>Encargado:</label>
                        <select name="encargado" class="form-control">
                           <?php
                        while ($columna = mysqli_fetch_array( $resultado2 )) { ?>
                        <option value="<?php echo $columna['id_cargos']; ?>"><?php echo $columna['nombreCargos']; ?> </option>
                           <?php }  ?>
                        </select>
                    </div>
                <!--    
                  <div class="form-group">
                    <label for="exampleInputPassword1">Solicitud:</label>
                    <input type="text" name="solicitud" class="form-control" id="" placeholder="">
                  </div>
                -->  
                  
                  <div class="form-group" >
                      
                      <label for="upload-photo">Archivo:</label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="miInput" name="archivo"  >
                          <label class="custom-file-label" >Subir Archivo</label>
                          
                        </div>
                          <div class="input-group-append">
                            <span class="input-group-text" id="">Subir</span>
                          </div>
                     </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                    <input type="hidden" name="usuario" value="<?php echo $usuario;?>">
                    <input type="hidden" name="tipoSolicitud" value="<?php echo '1';//$tipo;?>">
                  <button name="agregarSolicitud" type="submit" class="btn btn-success float-right">Siguiente >></button>
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

<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
<!-- bs-custom-file-input -->
<script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script>
    const MAXIMO_TAMANIO_BYTES = 2000000; // 1MB = 1 millón de bytes

// Obtener referencia al elemento
const $miInput = document.querySelector("#miInput");

$miInput.addEventListener("change", function () {
	// si no hay archivos, regresamos
	if (this.files.length <= 0) return;

	// Validamos el primer archivo únicamente
	const archivo = this.files[0];
	if (archivo.size > MAXIMO_TAMANIO_BYTES) {
		const tamanioEnMb = MAXIMO_TAMANIO_BYTES / 1000000;
		//alert(`El tamaño máximo del archivo es de ${tamanioEnMb} MB`);
		const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });
    
    
        Toast.fire({
            type: 'warning',
            title: ` El tamaño máximo del archivo es de ${tamanioEnMb} MB`
        })
		// Limpiar
		$miInput.value = "";
	} else {
		// Validación asada. Envía el formulario o haz lo que tengas que hacer
	}
});
</script>

<script language="javascript">
			$(document).ready(function(){
				$("#cbx_cedi").change(function () {

					$('#cbx_posicion').find('option').remove().end().append('<option value="whatever"></option>').val('whatever');
					
					$("#cbx_cedi option:selected").each(function () {
						id_cedi = $(this).val();
						$.post("selectDinamico2.php", { id_cedi: id_cedi }, function(data){
							$("#cbx_bodega").html(data);
						});            
					});
				})
			});
			
			$(document).ready(function(){
				$("#cbx_bodega").change(function () {
					$("#cbx_bodega option:selected").each(function () {
						id_bodega = $(this).val();
						$.post("selectDinamico3.php", { id_bodega: id_bodega, id_cedi: id_cedi }, function(data){
							$("#cbx_posicion").html(data);
						});           
					});
				})
			});
</script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
<!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<?php
$validacionExisteProceso=$_POST['validacionExisteProceso'];
?>
<script type="text/javascript">
  $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000
    });
    
    
    <?php
    if($validacionExisteProceso == 1){
    ?>
        Toast.fire({
            type: 'error',
            title: 'No puede enviar 2 procesos a la vez, selecione únicamente el proceso de su interés.'
        })
    
    <?php
    }
    ?>
    
  });

</script>
<script type="text/javascript">
  $(function() {
    
    
  });

</script>
</body>
</html>
<?php
}
?>